<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Illuminate\Support\Facades\Auth;
class CheckUserSubdcription
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
         //  echo auth()->user()->id; 
       echo "fd";
        if (Auth::check()) {                
         echo "123";
        }
        exit;
        return $next($request);
    }
}
