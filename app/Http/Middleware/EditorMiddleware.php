<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class EditorMiddleware
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
        if (Auth::user() == null) {
            return redirect(route('ipanel.login'));
        }

        $user = User::all()->count();
        if (!($user == 1)) {
            if (!Auth::user()->can('editor')) {
                return redirect()
                    ->back()
                    ->with(['message' => 'تحقق من الصلاحيات التي تملكها', 'type' => 'alert-danger']);
            }
        }

        return $next($request);
    }
}
