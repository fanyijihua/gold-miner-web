<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckToken
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
        if ($request->is("api/users")) {
            return $next($request);
        }

        if ($token = $request->header('authorization')) {
            $res = DB::table('userToken')
                    ->where('token', $token)
                    ->first();

            if ($res == null) {
                header("HTTP/1.1 403 Forbiden");
                echo json_encode(['message' => 'Token 错误！']);
                die;
            }

            if (strtotime($res->expiry) < time()) {
                header("HTTP/1.1 403 Forbiden");
                echo json_encode(['message' => 'Token 已过期！']);
                die;
            }
        } else {
            header("HTTP/1.1 403 Forbiden");
            echo json_encode(['message' => 'Token 丢失！']);
            die;
        }

        return $next($request);
    }
}
