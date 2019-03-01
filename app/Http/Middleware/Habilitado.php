<?php

namespace App\Http\Middleware;

use Closure;

class Habilitado
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
        if (\Auth::user()->habilitado) {
            return $next($request);
        } else {
            \Auth::logout();
            return response(view('inhabilitado'));
        }
    }
}
