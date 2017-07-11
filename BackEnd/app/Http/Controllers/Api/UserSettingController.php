<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserSettingController extends Controller
{
    /**
     * 获取用户设置内容
     * @param  int $userId  用户 ID
     * @return mixed        用户设置内容
     */
    public static function getUserSettings($userId)
    {
        $result = DB::table('usersetting')
                    ->where('uid', $userId)
                    ->first();

        return $result;
    }
    
    /**
     * 设置用户设置内容
     * @param int $userId 用户 ID
     */
    public function setUserSettings(Request $request, $userId)
    {
    	$this->isNotNull(array(
    			'translation'	=> $request->input('translation'),
    			'article'		=> $request->input('article'),
    			'review'		=> $request->input('review'),
    			'result'		=> $request->input('result'),
    			'userId'		=> $userId
    		));

    	$data = array(
                'newtranslation'    => $request->input('translation'),
                'newarticle'        => $request->input('article'),
                'newreview'         => $request->input('review'),
                'newresult'         => $request->input('result'),
                'udate'             => date("Y-m-d H:i:s")
    		);

    	$res = DB::table('usersetting')
    			->where('uid', $userId)
    			->update($data);

        if($setting == false){
            header("HTTP/1.1 500 Service unavailable");
            echo json_encode(['message' => '修改用户设置失败！']);
            die;
        }

    }

    /**
     * 添加默认用户设置
     * @param  int $userId 用户 ID
     * @return boolean
     */
    public static function setDefaultSettings($userId)
    {
        $data = array(
                'uid'               => $userId,
                'newtranslation'    => 1,
                'newreview'         => 1,
                'newarticle'        => 1,
                'newresult'         => 1,
                'udate'             => date("Y-m-d H:i:s"),
                'cdate'             => date("Y-m-d H:i:s")
            );

        $res = DB::table('usersetting')->insert($data);

        return $res;
    }

}
