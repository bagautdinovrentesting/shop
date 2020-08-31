<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Gate;
use Closure;

class Dashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Gate::authorize('dashboard');
        //if (Gate::denies('dashboard'))
            //return redirect('/');

        return $next($request);
    }
}
