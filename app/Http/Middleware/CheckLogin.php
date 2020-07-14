<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\VarDumper\Dumper\esc;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect(route('ipanel.login'));
        }
        // elseif (Auth::user()->email_verified_at == null) {
        //     Auth::logout();
        //     return redirect()
        //         ->back()
        //         ->with(['message' => 'قم بتفعيل حسابك.', 'type' => 'alert-danger']);
        // }

        return $next($request);
    }
}
