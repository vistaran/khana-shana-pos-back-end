<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use JWTAuth;
use App\Http\Middleware\Request;

class JWTMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
