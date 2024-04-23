<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AllLevel
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
        if(Auth::user()->type_user==0 || Auth::user()->type_user==1 || Auth::user()->type_user==2){
            return $next($request);
        }
        abort(404);
    }
}
