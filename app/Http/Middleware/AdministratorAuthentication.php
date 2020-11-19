<?php
namespace App\Http\Middleware;

use Auth;

use Closure;

use DB;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdministratorAuthentication
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
        if(Auth::check()){
            $roleId   = Auth::user()->role_id;

            $roleName = DB::table('roles')->find($roleId);
             
            if (Auth::check() && $roleName->name == 'administrator') {
                return $next($request);
            }else if (Auth::check() && $roleName->name != 'administrator') {

                return redirect('dashboard');

            }else{

                abort(401,'Unauthorized access');
            }
        }else{
            return redirect('/');
        }
    }
}
