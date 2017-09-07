<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserSettingController as USetting;

class UserController extends Controller
{
    /**
     * 前端返回内容
     *
     * @var array
     * @author Romeo
     */
    protected $store;

    /**
     * 用户信息
     *
     * @var object
     * @author Romeo
     */
    protected $userInfo;

    public function __construct () {
        $this->store = array(
            "user"  => '',
            "error" => ''
        );
    }

    /**
     * 从 GitHub 获取用户信息并创建或更新用户
     * @param  Request  $request   应包含 state 和 code
     * @return void
     */
    public function index(Request $request)
    {
        $aUrl = 'https://github.com/login/oauth/access_token';
        $aParams = array(
                'state'         =>  $request->input('state'),
                'code'          =>  $request->input('code'),
                'client_id'     =>  $this->client_id,
                'client_secret' =>  $this->client_secret,
            );

        parse_str($this->sendRequest($aUrl, 'POST', $aParams), $token);

        if (!isset($token['access_token'])) {
            header("HTTP/1.1 401 Service unavailable");
            $this->store["error"] = "获取 GitHub token 失败！";
            return view('index', $this->decodeStore());
        }
        
        $uUrl = "https://api.github.com/user";
        $uParams = ['access_token' => $token['access_token']];
        $userInfo = json_decode($this->sendRequest($uUrl, 'GET', $uParams));

        if (!isset($userInfo->id)) {
            header("HTTP/1.1 401 Unauthorized");
            $this->store["error"] = "GitHub 授权失败！";
            return view('index', $this->decodeStore());
        } elseif ($userInfo->email == null) {
            header("HTTP/1.1 404 Not found");
            $this->store["error"] = "GitHub 邮箱未公开！";
            return view('index', $this->decodeStore());
        }

        $this->userInfo = $userInfo;
        $userId = DB::table('user')
                    ->where('gid', $userInfo->id)
                    ->value('id');

        if ($userId == false) {
            $userId = $this->create();
        } else {
            $this->update($userId);
        }

        $this->updateToken($userId);

        $this->store['user'] = $this->loadUserById($userId);
        return view('index', $this->decodeStore());
    }

    /**
     * 创建新用户
     * @return mixed
     */
    public function create()
    {
        //
        $user = array(
                'gid'           => $this->userInfo->id,
                'name'          => $this->userInfo->login,
                'email'         => $this->userInfo->email,
                'avatar'        => $this->userInfo->avatar_url,
                'status'        => 1,
                'isadvanced'    => 0,
                'isadmin'       => 0,
                'istranslator'  => 0,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $insertId = DB::table('user')->insertGetId($user);
        if ($insertId == false) {
            header("HTTP/1.1 500 Service unavailable");
            $this->store['error'] = "添加新用户失败！";
            return view('index', $this->decodeStore());
        }

        $userDetail = array(
                'uid'       => $insertId,
                'bio'       => $this->userInfo->bio,
                'udate'     => date('Y-m-d H:i:s'),
                'cdate'     => date('Y-m-d H:i:s')
            );

        $detail = DB::table('userDetail')->insert($userDetail);

        if ($detail == false) {
            header("HTTP/1.1 500 Service unavailable");
            $this->store['error'] = "添加用户详情失败！";
            return view('index', $this->decodeStore());
        }

        $setting = USetting::setDefaultSettings($insertId);

        if ($setting == false) {
            header("HTTP/1.1 500 Service unavailable");
            $this->store['error'] = "添加用户设置失败！";
            return view('index', $this->decodeStore());
        }
        
        return $insertId;
    }

    /**
     * 获取单个用户信息
     * @param  int $id 用户 ID
     * @return void    用户信息
     */
    public function show($id)
    {
        //
        if (!is_numeric($id)) {
            header("HTTP/1.1 400 Bad request");
            echo json_encode(['message' => '参数错误！']);
            return;
        }

        $user = DB::table('user')
                    ->leftjoin('userDetail', 'user.id', '=', 'userDetail.uid')
                    ->where('user.id', $id)
                    ->select('user.*', 'userDetail.translate as translateNumber', 'userDetail.review as reviewNumber', 'userDetail.recommend as recommendNumber', 'userDetail.totalScore', 'userDetail.currentScore', 'userDetail.appraisal', 'userDetail.major', 'userDetail.bio')
                    ->first();

        if ($user == false) {
            header("HTTP/1.1 503 Service unavailable");
            echo json_encode(['message' => '获取用户信息失败！']);
            return;
        }

        echo json_encode($user);
    }

    /**
     * 更新用户信息
     *
     * @param  int $userId 用户 id
     * @return void
     */
    public function update($userId)
    {
        //
        $user = array(
                'name'      => $this->userInfo->login,
                'avatar'    => $this->userInfo->avatar_url,
                'udate'     => date('Y-m-d H:i:s')
            );

        $result = DB::table('user')
                    ->where('id', $userId)
                    ->update($user);

        if (USetting::getUserSettings($userId) == false) {
            USetting::setDefaultSettings($userId);
        }
    }

    /**
     * 通过用户 ID 获取用户信息
     * @param  int  $userId     用户 ID
     * @return Object           用户信息
     */
    public function loadUserById($userId)
    {
        if (!is_numeric($userId)) {
            header("HTTP/1.1 400 Bad request");
            echo json_encode(['message' => '参数错误！']);
            return;
        }

        $userInfo = DB::table('user')
                    ->leftjoin('userDetail', 'user.id', '=', 'userDetail.uid')
                    ->leftjoin('userToken', 'user.id', '=', 'userToken.uid')
                    ->where('user.id', $userId)
                    ->select('user.*', 'userDetail.major', 'userDetail.bio', 'userToken.token')
                    ->first();

        if ($userInfo == false) {
            header("HTTP/1.1 500 Service unavailable");
            $this->store['error'] = "获取用户信息失败！";
            return view('index', $this->decodeStore());
        }

        return $userInfo;
    }

    /**
     * 更新登陆 token
     * @param   int     $userId     用户 id
     * @return  mixed
     */
    public function updateToken($userId)
    {
        $token = $this->generateToken($userId);

        $user = array(
                'uid'       => $userId,
                'token'     => $token,
                'expiry'    => date('Y-m-d H:i:s', strtotime('+1 week')),
                'udate'     => date('Y-m-d H:i:s')
            );
        
        $record = DB::table('userToken')
                    ->where('uid', $userId)
                    ->value('id');

        if ($record) {
            $result = DB::table('userToken')
                        ->where('id', $record)
                        ->update($user);
        } else {
            $user['cdate'] = date('Y-m-d H:i:s');
            $result = DB::table('userToken')
                        ->insert($user);
        }
    }

    /**
     * 递增用户推荐文章数量
     * @param  int  $uid    用户 ID
     * @param  int  $num    文章数量
     * @return void
     */
    public static function incrementRecommend($uid, $num=1)
    {
        DB::table('userDetail')->where('uid', $uid)->increment('recommend', $num);
    }

    /**
     * 递增用户翻译文章数量
     * @param  int  $uid    用户 ID
     * @param  int  $num    文章数量
     * @return void
     */
    public static function incrementTranslate($uid, $num=1)
    {
        DB::table('userDetail')->where('uid', $uid)->increment('translate', $num);
    }

    /**
     * 递增用户校对文章数量
     * @param  int  $uid    用户 ID
     * @param  int  $num    校对数量
     * @return void
     */
    public static function incrementReview($uid, $num=1)
    {
        DB::table('userDetail')->where('uid', $uid)->increment('review', $num);
    }

    /**
     * 用户添加积分
     * @param  int  $uid    用户 ID
     * @param  int  $num    积分数量
     * @return void
     */
    public static function incrementScore($uid, $num=1)
    {
        DB::table('userDetail')->where('uid', $uid)->increment('totalScore', $num);
        DB::table('userDetail')->where('uid', $uid)->increment('currentScore', $num);
    }

    /**
     * 用户减去积分
     * @param  int  $uid    用户 ID
     * @param  int  $num    积分数量
     * @return void
     */
    public static function decrementScore($uid, $num=1)
    {
        DB::table('userDetail')->where('uid', $uid)->decrement('currentScore', $num);
    }

    public function decodeStore () {
        return base64_encode(json_encode($this->store));
    }
}
