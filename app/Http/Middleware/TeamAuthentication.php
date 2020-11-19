<?php

namespace App\Http\Middleware; 

use Auth;

use Closure;

use DB;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Helpers\CommonHelpers;
use Session;
use Route;

class TeamAuthentication
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
            $teamId   = Auth::user()->teams_id;
            if (Auth::check() && $roleName->name == 'administrator') {
                
               return redirect('team-list');

            }else{

                $activeTeam = DB::table('teams')->where('is_active',1)->find($teamId);
                if(Auth::check() && Route::currentRouteName()!='upgrade-plan'){
                    $days = CommonHelpers::getSubscriptionExpiryDays();
                    if($days<=0){
                        return redirect('upgrade-plan');
                    }
                }
                
                if (Auth::check() && $roleName->name != 'administrator' && !empty($activeTeam)) {

                    return $next($request);
        
                }else{
                    Auth::logout();
                    session()->flash('teamMessage', "Your team is not active please contact to japio.");
                    return redirect('/');
                    abort(401,'Unauthorized access');
                }
            }
        }else{
             return redirect('/');
        }
        
    }
}
