<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userInfo;

    /**
     * 从 GitHub 获取用户信息并创建或更新用户
     * @param  Request  $request   应包含 state 和 code
     * @return 重定向
     */
    public function index(Request $request)
    {
        //
        $aUrl = 'https://github.com/login/oauth/access_token';
        $aParams = array(
                'state'         =>  $request->input('state'),
                'code'          =>  $request->input('code'),
                'client_id'     =>  $this->client_id,
                'client_secret' =>  $this->client_secret,
            );

        parse_str($this->sendRequest($aUrl, 'POST', $aParams), $token);

        if(!isset($token['access_token'])){
            $this->ret['status']    = 500;
            $this->ret['message']   = '获取 GitHb token 信息失败！';

            return json_encode($this->ret);
        }
        
        $uUrl = "https://api.github.com/user";
        $uParams = array(
                'access_token'     =>   $token['access_token'],
            );
        $userInfo = json_decode($this->sendRequest($uUrl, 'GET', $uParams));

        if(!isset($userInfo->login)){
            $this->ret['status']    = 500;
            $this->ret['message']   = '获取用户信息失败：'.$userInfo->message;

            return json_encode($this->ret);
        }

        $this->userInfo = $userInfo;
        $userId = DB::table('user')
                    ->where('email', $this->userInfo->email)
                    ->value('id');

        if($userId == false){
            $userId = $this->create();
            $newUser = true;
        }else{
            $this->update($userId);
            $newUser = false;
        }

        $this->updateToken($userId);

        session(['user' => $this->loadUserById($userId)]);

        return redirect('/');
    }

    /**
     * 创建新用户
     * @return mixed
     */
    public function create()
    {
        //
        $user = array(
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
        if($insertId == false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '创建用户失败！';

            return json_encode($this->ret);
        }

        $userInfo = array(
                'uid'       => $insertId,
                'bio'       => $this->userInfo->bio,
                'udate'     => date('Y-m-d H:i:s'),
                'cdate'     => date('Y-m-d H:i:s')
            );

        $result = DB::table('userDetail')->insert($userInfo);
        
        if($result == false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '添加用户详情失败！';
 
            return json_encode($this->ret);
        }

        return $insertId;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 更新用户信息
     *
     * @param  int  $userid     用户 id
     * @return mixed
     */
    public function update($userid)
    {
        //
        $user = array(
                'name'      => $this->userInfo->login,
                'avatar'    => $this->userInfo->avatar_url,
                'udate'     => date('Y-m-d H:i:s')
            );

        $result = DB::table('user')
                    ->where('id', $userid)
                    ->update($user);

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新用户信息失败！';

            return json_encode($this->ret);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * 通过用户 ID 获取用户信息
     * @param  int  $userId     用户 ID
     * @return Object           用户信息
     */
    public function loadUserById($userId)
    {
        $userInfo = DB::table('user')
                    ->join('userDetail', 'user.id', '=', 'userDetail.uid')
                    ->join('userToken', 'user.id', '=', 'userToken.uid')
                    ->where('user.id', $userId)
                    ->select('user.*', 'userDetail.major', 'userDetail.bio', 'userToken.token')
                    ->first();

        if($userInfo == false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '获取用户信息失败！';

            return json_encode($this->ret);
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

        if($record){
            $result = DB::table('userToken')
                        ->where('id', $record)
                        ->update($user);
        }else{
            $user['cdate'] = date('Y-m-d H:i:s');
            $result = DB::table('userToken')
                        ->insert($user);
        }

        if($result === false){
            $this->ret['status'] = 500;
            $this->ret['message'] = '更新 token 失败！';

            return json_encode($this->ret);
        }
    }

}
