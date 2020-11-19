<?php

namespace App\Http\Controllers;

use NotifiFinder;
use App\User;
use App\model\UserInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB; 
use App\model\User_notifications;
class TeamRegisterController extends Controller
{
public function pankaj(Request $request, $id=false){
	 return view('admin.test.index');        
} 
 public function register(Request $request, $id=false){
       $page_data=$teamList=$email_id="";
       $t_status="0"; 
        
       $datrces = DB::table('user_invitation')
       ->leftJoin('team_subscription_mapping', function ($join)  {				$join->on('team_subscription_mapping.user_subscription_id', '=', 'user_invitation.subscription_plans_id')->where('team_subscription_mapping.is_current', '=', '1');				})	
       ->select('user_invitation.role_id','team_subscription_mapping.valid_till','user_invitation.teams_id','user_invitation.subscription_plans_id','user_invitation.id','user_invitation.email_id','user_invitation.email_id','user_invitation.invitation_code','user_invitation.invite_by as invite_by')
       ->where([['user_invitation.created_md5_id','=',$id],['user_invitation.created_md5_id','=',$id]])
       ->first();
       
       
       $user_count = DB::table('user_invitation')
        ->leftJoin('subscription_plans', function ($join)  {$join->on('subscription_plans.id', '=', 'user_invitation.subscription_plans_id');})	      
       ->select('subscription_plans.max_team_size','user_invitation.id','user_invitation.is_acepted')
        ->where([['user_invitation.teams_id','=',$datrces->teams_id]])
       ->get();
       $ij="0";
       foreach($user_count as $user_count_row){
           $max_team_size=$user_count_row->max_team_size;
           if($user_count_row->is_acepted){
            $ij++;   
           }
       }
        $gotouser="0";
       if($max_team_size<$ij){
           $gotouser="1";
       }
       
         if(isset($datrces)&&(is_numeric($datrces->id))){
            $email_id=$datrces->email_id;
            $users = DB::table('users')
            ->select('users.id')
            ->where([['users.email','=',$email_id]])
            ->first();
           if(isset($users)){
               $t_status="1";
                $request->session()->flash('error', 'You already register, Please login');
           } else {
               if ($request->isMethod('post')) {
                   
                     if($gotouser=="1"){
                               $request->session()->flash('error', 'Please contact Your Team Manager, Your Team size has reached on max');
                     }else
                        if($request->input('password')!=$request->input('repassword')){
                               $request->session()->flash('error', 'Password and Re-Password does not match');
                        } else                            
                       if((isset($request->name)&&($request->name!=""))&&(isset($request->password)&&($request->password!=""))){
                            $user_d = new User;
                            $user_d->name = $request->name;
                            $user_d->position = $request->destination;
                            $user_d->invite_by_id = $datrces->invite_by;
                            $user_d->valid_date = $datrces->valid_till;
                            $user_d->role_id = $datrces->role_id;
                            
       
                            $user_d->teams_id = $datrces->teams_id;
                            $user_d->subscription_plans_id = $datrces->subscription_plans_id;
                            $user_d->email = $email_id;
                            $user_d->password = Hash::make($request->password);
                           // $user_d->role_id = '2';
 //NotifiFinder::add_notification('','1','my-team');
                            $user_d->save();                               
                            $team_update=UserInvitation::find($datrces->id);
                            $team_update->name=$request->name;
                            $team_update->is_acepted='1';
                           // $team_update->pro_img='img/profile_img/user.png';
                            $team_update->users_created_id=$user_d->id;
                            $team_update->save();
                                  return redirect('login');             
                   //         $request->session()->flash('success', 'Your Account has create, Login');                           
                       } else {
                           $request->session()->flash('error', 'Please try again');                               
                       }                                
                       
                        
                    }     
               }
                        
          } else {
              $request->session()->flash('error', 'Invalid user please close this window and open again');
          }       
          return view('admin.myteam.register',compact('page_data','teamList','email_id','t_status'));        
        }
   }
