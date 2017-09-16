<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\MailController as Mail;

class RecommendController extends Controller
{
    const AWAITING = 0;
    const SUCCESS = 1;
    const FAILURE = 2;
    /**
     * 获取所有推荐文章记录（分页）
     * @param int $status 推荐文章记录类别，0 为未处理，1 为成功，2 为失败
     * @return void
     */
    public function index(Request $request)
    {
        if (intval($request->input('status')) > 2) {
            header("HTTP/1.1 400 Bad request!");
            return json_encode(['message' => '参数错误！']);
        }
        
        $recommends = DB::table('recommend')
                        ->join('user', 'recommend.recommender', '=', 'user.id')
                        ->join('category', 'recommend.category', '=', 'category.id')
                        ->select('recommend.id', 'recommend.title', 'recommend.url', 'recommend.status', 'recommend.description', 'recommend.udate', 'recommend.cdate', 'user.id as userId', 'user.name as userName', 'user.email as userEmail', 'user.avatar as userAvatar', 'category.id as categoryId', 'category.category')
                        ->where('recommend.status', $request->has('status') ? intval($request->input('status')) : 0)
                        ->orderBy('recommend.id', 'ASC')
                        ->skip($this->start)
                        ->take($this->offset)
                        ->get();

        return json_encode($recommends);
    }

    /**
     * 添加推荐文章记录
     * @param  int      $category       文章分类（对应 category 表）
     * @param  string   $title          文章标题
     * @param  string   $url            文章来源地址
     * @param  int      $recommender    推荐者（对应 user 表）
     * @param  string   $description    推荐理由
     * @return void
     */
    public function store(Request $request)
    {
        $this->isNotNull(array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description')
            ));
        $this->isUnique('recommend', array(
                'url' => $request->input('url')
            ));
        $data = array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description'),
                'status'        => AWAITING,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $lastId = DB::table('recommend')
                    ->insertGetId($data);

        if ( $lastId == false ) {
            header("HTTP/1.1 503 Service Unavailable");
            return;
        }

        return $this->show($lastId);
    }

    /**
     * 获取指定文章信息
     *
     * @param int $id
     * @return void
     * @author Romeo
     */
    public function show($id)
    {
        $recommend = DB::table('recommend')
                        ->join('user', 'recommend.recommender', '=', 'user.id')
                        ->select('recommend.*', 'user.name as recommenderName')
                        ->where('recommend.id', $id)
                        ->first();

        if ( $recommend == false ) {
            header("HTTP/1.1 400 Bad Request");
            return json_encode(['message' => '参数错误！']);
        }
                        
        return json_encode($recommend);
    }

    /**
     * 更新推荐文章记录
     * @param  int      $category       文章分类（对应 category 表）
     * @param  string   $title          文章标题
     * @param  string   $url            文章来源地址
     * @param  int      $recommender    推荐者（对应 user 表）
     * @param  string   $description    推荐理由
     * @param  int      $id             文章 ID
     * @return void
     */
    public function update(Request $request, $id)
    {
        $record = DB::table('recommend')
                    ->select('status', 'recommender')
                    ->where('id', $id)
                    ->first();
        $user = DB::table('userToken')
                    ->where('userToken.token', $request->header('authorization'))
                    ->value('uid');

        if ($record->status != 0) {
            header("HTTP/1.1 403 forbidden");
            return json_encode(['message' => '您推荐的文章已被管理员处理，无法操作！']);
        } elseif ($record->recommender != $user) {
            header("HTTP/1.1 403 forbidden");
            return json_encode(['message' => '您没有权限修改他人推荐的文章！']);
        }

        $this->isNotNull(array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description')
            ));
        $this->isUpdateConflict('recommend', $id, array(
                'url' => $request->input('url')
            ));

        $data = array(
                'category'      => $request->input('category'),
                'title'         => $request->input('title'),
                'url'           => $request->input('url'),
                'recommender'   => $request->input('recommender'),
                'description'   => $request->input('description'),
                'udate'         => date('Y-m-d H:i:s')
            );
        
        $result = DB::table('recommend')
                        ->where('id', $id)
                        ->update($data);

        if ( $result == false ) {
            header("HTTP/1.1 503 Service Unavailable");
            return;
        }

        return $this->show($id);
    }

    /**
     * 更新文章处理结果
     * @param  int      $id     文章 ID
     * @param  boolean  $result 推荐结果，true 为通过，false 为未通过
     * @return void
     */
    public function result(Request $request, $id, Mail $mail)
    {
        if (!is_numeric($id)) {
            header("HTTP/1.1 400 Bad request");
            return json_encode(['message' => '参数错误！']);
        }

        $data = array(
                'comment'   => $request->input('opinion'),
                'status'    => SUCCESS,
                'udate'     => date('Y-m-d H:i:s')
            );

        if ($request->input('result') == false) {
            $data['status'] = FAILURE;
        }

        $res = DB::table('recommend')
                    ->where('id', $id)
                    ->update($data);

        if ( $res == false ) {
            header("HTTP/1.1 503 Service Unavailable");
            return json_encode(['message' => '更新推荐结果失败！']);
        }

        $mail->result($id);
        
        if ( $data['status'] == FAILURE) {
            return;
        }

        $uid = DB::table('recommend')
                ->where('id', $id)
                ->value('recommender');
        
        UserController::incrementRecommend($uid);
        $this->retrieve($id);
    }

    /**
     * 向 GitHub Micro Service 请求抓取文章
     * @param  int $rid 推荐文章 ID
     * @return boolean  
     */
    protected function retrieve($rid)
    {
        $params = DB::table('recommend')
                    ->join('category', 'recommend.category', '=', 'category.id')
                    ->select('recommend.id as rid', 'recommend.url', 'category.category')
                    ->where('recommend.id', $rid)
                    ->first();

        $url = '127.0.0.1:' . env('GITHUB_MICRO_SERVER_PORT') . '/articles';
        $this->sendRequest($url, 'POST', (array) $params);
    }

}
