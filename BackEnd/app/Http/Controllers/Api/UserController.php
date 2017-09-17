<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserSettingController as USetting;

class UserController extends Controller
{
    /**
     * GitHub 注册应用 client_id
     * @var string
     */
    protected $client_id;

    /**
     * GitHub 注册应用 client_secret
     * @var string
     */
    protected $client_secret;

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

    public function __construct (Request $request) {
    	$this->client_id = config('app.github_client_id');
    	$this->client_secret = config('app.github_client_secret');
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
            $this->store["error"] = "获取 GitHub token 失败！";
            return view('index', $this->decodeStore());
        }
        
        $uUrl = "https://api.github.com/user";
        $uParams = ['access_token' => $token['access_token']];
        $userInfo = json_decode($this->sendRequest($uUrl, 'GET', $uParams));

        if (!isset($userInfo->id)) {
            $this->store["error"] = "GitHub 授权失败！";
            return view('index', $this->decodeStore());
        } elseif ($userInfo->email == null) {
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
        $user = array(
                'gid'           => $this->userInfo->id,
                'name'          => $this->userInfo->login,
                'email'         => $this->userInfo->email,
                'avatar'        => $this->userInfo->avatar_url,
                'status'        => 1,
                'advance'       => 0,
                'admin'         => 0,
                'translator'    => 0,
                'udate'         => date('Y-m-d H:i:s'),
                'cdate'         => date('Y-m-d H:i:s')
            );

        $insertId = DB::table('user')->insertGetId($user);
        if ($insertId == false) {
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
            $this->store['error'] = "添加用户详情失败！";
            return view('index', $this->decodeStore());
        }

        $setting = USetting::setDefaultSettings($insertId);

        if ($setting === false) {
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
        if (!is_numeric($id)) {
            return response("Bad request", 400)
                    ->json(['message' => '参数错误！']);
        }

        $user = DB::table('user')
                    ->leftjoin('userDetail', 'user.id', '=', 'userDetail.uid')
                    ->where('user.id', $id)
                    ->select('user.id', 'user.name', 'user.email', 'user.avatar', 'user.cdate', 'userDetail.translate as translateNumber', 'userDetail.review as reviewNumber', 'userDetail.recommend as recommendNumber', 'userDetail.totalScore', 'userDetail.currentScore', 'userDetail.appraisal', 'userDetail.major', 'userDetail.bio')
                    ->first();

        if ($user === null) {
            return response("Service unavailable", 503)
                    ->json(['message' => ' 获取用户信息失败！']);
        }

        return json_encode($user);
    }

    /**
     * 更新用户信息
     *
     * @param  int $userId 用户 id
     * @return void
     */
    public function update($userId)
    {
        $user = array(
                'name'      => $this->userInfo->login,
                'avatar'    => $this->userInfo->avatar_url,
                'udate'     => date('Y-m-d H:i:s')
            );

        $result = DB::table('user')
                    ->where('id', $userId)
                    ->update($user);

        if (USetting::getUserSettings($userId) === false) {
            USetting::setDefaultSettings($userId);
        }
    }

    /**
     * 拉取当前用户信息
     *
     * @param Request $request
     * @return void
     * @author Romeo
     */
    public function pull(Request $request)
    {
        $userInfo = DB::table('userToken')
                    ->leftjoin('userDetail', 'userToken.uid', '=', 'userDetail.uid')
                    ->leftjoin('user', 'user.id', '=', 'userToken.uid')
                    ->where('userToken.token', $request->header('authorization'))
                    ->select('user.*', 'userDetail.major', 'userDetail.bio', 'userToken.token')
                    ->first();

        if ($userInfo == false) {
            return response("Service unavailable", 503)
                    ->json(['message' => '拉取用户信息失败！']);
        }

        return json_encode($userInfo);
    }

    /**
     * 通过用户 ID 获取用户信息
     * @param  int  $userId     用户 ID
     * @return Object           用户信息
     */
    public function loadUserById($userId)
    {
        if (!is_numeric($userId)) {
            return response("Bad request", 400)
                    ->json(['message' => '参数错误！']);
        }

        $userInfo = DB::table('user')
                    ->leftjoin('userDetail', 'user.id', '=', 'userDetail.uid')
                    ->leftjoin('userToken', 'user.id', '=', 'userToken.uid')
                    ->where('user.id', $userId)
                    ->select('user.*', 'userDetail.major', 'userDetail.bio', 'userToken.token')
                    ->first();

        if ($userInfo === null) {
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
        return ['store' => base64_encode(json_encode($this->store))];
    }
}
