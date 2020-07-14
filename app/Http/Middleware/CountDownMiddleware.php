<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CountDownMiddleware
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
        $now = Carbon::today()->toDateString();
        $newYear = Carbon::createFromDate(2018, 12, 31)->toDateString();
        if ($now < $newYear)
            return redirect('/countdown');

        return $next($request);
    }
}
