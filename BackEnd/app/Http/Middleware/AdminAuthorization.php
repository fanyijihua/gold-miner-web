<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class AdminAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getClientIp() == "127.0.0.1") {
            return $next($request);
        }
        
        $admin = DB::table('userToken')
                ->join('user', 'user.id', '=', 'userToken.uid')
                ->where('userToken.token', $request->header('authorization'))
                ->where('user.admin', 1)
                ->first();

        if ($admin == false) {
            header("HTTP/1.1 401 Unauthorized!");
            echo json_encode(['message' => '您没有权限！']);
            die;
        }

        return $next($request);
    }
}
