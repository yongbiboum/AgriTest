<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class controleur
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

        if (Auth::check() && Auth::user()->role == 'controleur') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'client') {
            return redirect('/client');
        }
        elseif (Auth::check() && Auth::user()->role == 'producteur') {
            return redirect('/producteur');
        }
        else {
            return redirect('/admin');
        }

    }
}
