<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function index()
	{
		$user = session('user') ? session('user') : null;

		return view('index', ['user' => urlencode(json_encode($user))]);
	}

    public function oAuth()
    {
        $url = "https://github.com/login/oauth/authorize";
        $url .= "?client_id=".$this->client_id;
        $url .= "&state=".$this->randomString(32);

        return redirect($url);
    }

}
