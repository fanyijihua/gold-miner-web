<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function index()
    {
        $url = "https://github.com/login/oauth/authorize?client_id=c846cde270a97d98d957&redirect_uri=http://fanyi.juejin.im/auth/getToken&scope=user&state=".$this->randomString();
        return redirect($url);
    }

    public function randomString()
    {
        $range = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomString = '';
        for($i = 0; $i < 32; $i++){
            $index = rand(0,strlen($range));
            $randomString .=substr($range, $index-1, 1);
        }

        return $randomString;
    }

    public function getToken(Request $request)
    {
        $aUrl = 'https://github.com/login/oauth/access_token';
        $aParams = array(
                'state'         =>  $request->input('state'),
                'code'          =>  $request->input('code'),
                'client_id'     =>  'c846cde270a97d98d957',
                'client_secret' =>  'a7b14c8343bded979f1cad9df3964c1ca1047239',
            );

        $access_token = $this->sendRequest($aUrl, 'POST', $aParams);
        parse_str($access_token, $ret);
        
        $uUrl = "https://api.github.com/user";
        $uParams = array(
                'access_token'     =>   $ret['access_token'],
            );
        $userInfo = $this->sendRequest($uUrl, 'GET', $uParams);

        var_dump(json_decode($userInfo));

    }

    public function sendRequest($url, $method, $params = array()) 
    {
        $options = array(
                CURLOPT_USERAGENT       =>  'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Safari/537.36',
                CURLOPT_HTTPHEADER      =>  array(
                        'Content-type'      =>  'application/x-www-form-urlencoded'                    ),
                // CURLOPT_HEADER          =>  true,
                CURLOPT_RETURNTRANSFER  =>  true
            );
        
        $query = http_build_query($params);

        $options[CURLOPT_URL] = $url.($method == 'GET' ? '?'.$query : '');

        if ($method == 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $query;
        }

        $sr = curl_init();
        curl_setopt_array($sr, $options);
        $ret = curl_exec($sr);
        curl_close($sr);

        return $ret;
    }
}
