<?php

namespace App\Http\Middleware;
use \Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;
// use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Exception;
class jwtToken extends BaseMiddleware
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
       
        
    try {
        JWTAuth::parseToken()->authenticate();
    } catch (Exception $e) {
        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['error' => 'خطا فى عملية الدخول ']); 
        }
        else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException ){
    return response()->json(['error' => 'انتهت مدة الجلسة عليك بتسجيل الدخول']);
            } 
            else {
                return response()->json(['error' => 'قم بتسجيل الدخول اولا']);

            }
        } 
        return $next($request);


    }
}
