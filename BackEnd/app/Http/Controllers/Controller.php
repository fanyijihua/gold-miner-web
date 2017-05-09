<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * GitHub 注册应用 client_id
     * @var string
     */
    protected $client_id 		= '';//config('app.github_client_id');

    /**
     * GitHub 注册应用 client_secret
     * @var string
     */
    protected $client_secret 	= '';//config('app.github_client_secret');

    /**
     * 状态响应内容
     * @var array
     */
    protected $ret = array();

    public function __construct()
    {
    	$this->client_id = config('app.github_client_id');
    	$this->client_secret = config('app.github_client_secret');
    	$this->ret['status'] = 200;
    	$this->ret['message'] = 'OK';
    }

    /**
     * 获取指定长度的随机字符串
     * @param  int 		$length 	随机字符串长度
     * @return string   			指定长度的随机字符串
     */
    public function randomString($length)
    {
        $range = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $index = rand(0,strlen($range));
            $randomString .=substr($range, $index-1, 1);
        }

        return $randomString;
    }

    /**
     * 发送 HTTP 请求
     * @param  string 	$url    请求地址
     * @param  string 	$method 请求方法，'GET' 或者 'POST'
     * @param  array  	$params 请求参数
     * @return mixd         	HTTP 请求返回值
     */
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

    /**
     * 生成随机的唯一的 token
     * @param  string   $flag   用户标志（唯一）
     * @return string   token
     */
    public function generateToken($flag)
    {
        return md5($this->randomString(32).time().$flag);
    }
}
