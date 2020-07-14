<?php

namespace App\Http\Middleware;
use \Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;
// use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Exception;
use Auth;
class jwtv extends BaseMiddleware
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
       $verified = JWTAuth::parseToken()->authenticate()->email_verified_at;
       if($verified == null) {
            $verify = JWTAuth::parseToken()->authenticate();
            $verify->sendEmailVerificationNotification();
           return response()->json(['error' => 'ارسالنا لك رساله الى بريدك الالكترونى يجت تفعيل اميلك اولا ']);
       } else {
                   return $next($request);

       }
        
    // try {
    //     JWTAuth::parseToken()->authenticate();
    // } catch (Exception $e) {
    //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
    //         return response()->json(['error' => 'خطا فى عملية الدخول ']); 
    //     }
    //     else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException ){
    // return response()->json(['error' => 'انتهت مدة الجلسة عليك بتسجيل الدخول']);
    //         } 
    //         else {
    //             return response()->json(['error' => 'قم بتسجيل الدخول اولا']);

    //         }
    //     } 


    }
}
