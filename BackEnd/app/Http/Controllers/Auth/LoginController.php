<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
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

    public function __construct()
    {
    	$this->client_id = config('app.github_client_id');
    	$this->client_secret = config('app.github_client_secret');
    }
    public function oAuth()
    {
        $url = "https://github.com/login/oauth/authorize";
        $url .= "?client_id=".$this->client_id;
        $url .= "&state=".$this->randomString(32);

        return redirect($url);
    }

    public function logout(Request $request)
    {

        $token = $request->header('authorization');
        $result = DB::table('userToken')->where('token', $token)->delete();

        if ($result) {
            header('HTTP/1.1 200 ok');
        } else {
            header('HTTP/1.1 501 Not Implemented');
        }
    }
}
