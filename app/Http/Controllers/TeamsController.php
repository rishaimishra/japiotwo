<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\User;

use App\model\UserInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Mail;
use App\Helpers\CommonHelpers;

class TeamsController extends Controller
{
     public function __construct()
    {
         $page_data = ['menu_selected'=>'my_team','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }
    //public function index($id=false){
        
         
        
        
     
   public function userdelete(Request $request, $id=false,$is_active=false,$u_id=false){
        if (Auth::check()) {
            
            $auth_id=Auth::user()->id;
            $uder_id=$id;
            $is_active=$is_active;
            
            User::where('id',$u_id)->where('invite_by_id', $auth_id)->update(['is_active' => $is_active]);
            
            UserInvitation::where('id',$id)->where('invite_by', $auth_id)->update(['is_active' => $is_active]);
            
            
            
            return redirect('my-team'); 
        } else {
            
        }
    
   }
   
   
        
    public function index(Request $request){
        
            $page_data=$this->page_data;
            if (Auth::check()) {                
               if ($request->isMethod('post')) {
                   
                    $datrces = DB::table('user_invitation')
                    ->select('user_invitation.email_id')
                    ->where([['user_invitation.email_id','=',$request->input('email_id')]])
                    ->first();
                        if(isset($datrces->email_id)&&($datrces->email_id!="")){
                            $request->session()->flash('error', 'Email already exits');
                            return redirect()->action('TeamsController@index');
                            exit;
                        } else {
                            /// save in database
                    
                      
                      
                        $teams_user = new UserInvitation;
                        $teams_user->is_active = '1';
                        $teams_user->invite_by = auth()->user()->id;
                        $teams_user->teams_id = auth()->user()->teams_id;
                        $teams_user->subscription_plans_id = auth()->user()->subscription_plans_id;
                        $teams_user->invitation_code = $code=rand(10000,99999);
                        $teams_user->email_id =$email_id= $request->input('email_id');
                        $teams_user->save();
                        
                        $created_id= md5($teams_user->id);
                        
                        $teams_user = UserInvitation::find($teams_user->id);
                    
                        $teams_user->created_md5_id = $created_id;
                    
                        $teams_user->save();
                                    $name= auth()->user()->name;   
                                    
                        $data = array('code'=>$code,'md5'=>$created_id,'name'=>$name);
                        Mail::send('admin.myteam.mail', $data, function($message) use ($email_id){
                            $message->to($email_id)->subject
                                (Config::get('constants.user.invation_subject'));
                            $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
                        });            
                      
                  }
                   
                    
                }
                
                
               $teamList = DB::table('users')
               ->leftjoin('user_invitation','users.teams_id','=','user_invitation.teams_id')                                   
               ->select('user_invitation.users_created_id','user_invitation.name','user_invitation.id','user_invitation.invitation_code','user_invitation.email_id','user_invitation.is_acepted','user_invitation.created_at', 'user_invitation.is_active')
               ->where('users.teams_id', Auth::user()->teams_id)
               ->get();
               
               $remainingUsers = CommonHelpers::getRemainingUsers();
                
              return view('admin.myteam.index',compact('page_data','teamList','subscription_plans','remainingUsers'));        
            } else {
                  
            }
        }
    }
