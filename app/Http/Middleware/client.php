<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class client
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

        if (Auth::check() && Auth::user()->role == 'client') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->role == 'controleur') {
            return redirect('/controleur');
        }
        elseif (Auth::check() && Auth::user()->role == 'producteur') {
            return redirect('/producteur');
        }
        elseif (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/admin');
        }

    }
}
