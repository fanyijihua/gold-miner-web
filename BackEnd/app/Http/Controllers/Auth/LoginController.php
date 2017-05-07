<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    public function oAuth()
    {
        $url = "https://github.com/login/oauth/authorize";
        $url .= "?client_id=".$this->client_id;
        $url .= "&state=".$this->randomString(32);

        return redirect($url);
    }

}
