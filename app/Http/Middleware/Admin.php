<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (!auth()->check() || auth()->user()->level < 10) {
            return redirect('home')->with('flash', 'You do not have permissions to visit this page.');
        }

        return $next($request);
    }
}
