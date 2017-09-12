<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /**
     * SendCloud 用户名
     *
     * @var string
     * @author Romeo
     */
    protected $apiUser;

    /**
     * SendCloud 用户 key
     *
     * @var string
     * @author Romeo
     */
    protected $apiKey;

    /**
     * SendCloud 发信接口地址
     *
     * @var string
     * @author Romeo
     */
    protected $apiUrl;

    /**
     * 发信人名称
     *
     * @var string
     * @author Romeo
     */
    protected $from;

    /**
     * 新翻译任务
     */
    const NEW_TRANSLATE_TASK = 1;

    /**
     * 新校对任务
     */
    const NEW_REVIEW_TASK = 2;
    
    /**
     * 新文章
     */
    const NEW_ARTICLE = 3;

    public function __construct()
    {
        $this->apiUser  = env('MAIL_USER');
        $this->apiKey   = env('MAIL_KEY');
        $this->apiUrl   = env('MAIL_HOST');
        $this->from     = env('MAIL_FROM');
    }

    /**
     * 发送邮件
     *
     * @param string $to
     * @param string $subject
     * @param string $html
     * @return void
     * @author Romeo
     */
    public function sendMail($to, $subject, $html)
    {
        $params = array(
                'apiUser'   => $this->apiUser,
                'apiKey'    => $this->apiKey,
                'from'      => $this->from,
                'to'        => $to,
                'subject'   => $subject,
                'html'      => $html
            );
        return $this->sendRequest($this->apiUrl, 'POST', $params);
    }

    /**
     * 发送译者申请结果通知邮件
     *
     * @param  int $id
     * @return void
     * @author Romeo
     */
    public function activate($id)
    {
        $applicant = DB::table('applicant')
                        ->select('email', 'invitation', 'comment as reason')
                        ->where('id', $id)
                        ->first();

        $subject = $applicant->invitation ? "欢迎加入掘金翻译计划！" : "很遗憾，您没有通过我们的审核！";
        return $this->sendMail($applicant->email, $subject, view("mails/active", ['invitationCode' => $applicant->invitation])->render());
    }

    /**
     * 发送新任务通知邮件 WIP
     *
     * @return void
     * @author Romeo
     */
    public function notify()
    {
       
    }

    /**
     * 发送推荐文章结果通知邮件
     *
     * @param [type] $id
     * @return void
     * @author Romeo
     */
    public function result($id)
    {
        $article = DB::table('recommend')
                    ->join('user', 'recommend.recommender', '=', 'user.id')
                    ->select('recommend.title', 'recommend.status as result', 'user.email', 'recommend.comment as reason')
                    ->where('recommend.id', $id)
                    ->first();
        $subject = ($article->result == 1) ? "您推荐文章已经通过啦！" : "很遗憾，您推荐的文章未通过审核。";
        return $this->sendMail($article->email, $subject, view("mails/result", ['article' => $article])->render());
    }
}
