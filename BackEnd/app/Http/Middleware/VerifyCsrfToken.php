<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        "api/translations/pr"
    ];

    public function handle($request, Closure $next)
    {
    	if ($request->getClientIP() == "127.0.0.1") {
            return $next($request);
    	}
      
    	return parent::handle($request, $next);
    }
}
