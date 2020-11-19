<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\model\UserConnector;
use App\model\Teams;
use App\User;
use App\model\UserInvitation;
use Illuminate\Support\Facades\Config;
use Mail;
use DB;
use Session;
use App\Helpers\CommonHelpers;
class ManageTeamsController extends Controller
{
     public function __construct()
    {
         $page_data = ['menu_selected'=>'manage_teams','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }
    public function show(Request $request){

          $page_data=['menu_selected'=>'manage_teams','header'=>'list','sub_menu_selected'=>'manage_list'];
           
        if (Auth::check()) {
            
            $team_data =array();
            $teams = DB::table('teams')
                ->leftjoin('user_invitation', 'user_invitation.teams_id', '=', 'teams.id')            
                ->leftjoin('subscription_plans', 'subscription_plans.id', '=', 'teams.plan_id')            
               ->select('subscription_plans.plan_name as plan_name','teams.id as teams_id', 'teams.team_name as team_name', 'teams.company_name as company_name','teams.website as website', 'teams.email_address as email_address','teams.is_active as teams_is_active','teams.plan_id as plan_id','teams.plan_valid_date as plan_valid_date','user_invitation.id as user_invitation_id','user_invitation.is_active as user_invitation_is_active','user_invitation.is_acepted as user_invitation_is_acepted')
             //  ->where([['user_connectors.user_id','=',Auth::user()->id]])
               ->get();
               
               foreach($teams as $teams_row){
                   $teams_row->teams_id;
                   $teams_row->team_name;
                   $teams_row->user_invitation_id;
                   
                   if(($teams_row->user_invitation_is_active=="1")&&($teams_row->user_invitation_is_acepted=="1")){   
                     $team_data[$teams_row->teams_id]['active'][]=$teams_row->user_invitation_is_active;
                   }
                   if($teams_row->user_invitation_is_active=="0"){     
                         $team_data[$teams_row->teams_id]['deactivate'][]=$teams_row->user_invitation_is_active;
                   }
				          if($teams_row->user_invitation_is_acepted=="1"){     
                         $team_data[$teams_row->teams_id]['acepted'][]=$teams_row->user_invitation_is_acepted;
                   }
                   if($teams_row->user_invitation_is_acepted=="0"){     
                         $team_data[$teams_row->teams_id]['pending'][]=$teams_row->user_invitation_is_acepted;
                   }
                   
                   $team_data[$teams_row->teams_id]['team_id']=$teams_row->teams_id;
                   $team_data[$teams_row->teams_id]['team_name']=$teams_row->team_name;
                   $team_data[$teams_row->teams_id]['company_name']=$teams_row->company_name;
                   $team_data[$teams_row->teams_id]['website']=$teams_row->website;
                   $team_data[$teams_row->teams_id]['plan_name']=$teams_row->plan_name;
                   $team_data[$teams_row->teams_id]['teams_is_active']=$teams_row->teams_is_active;
                   if(is_numeric($teams_row->user_invitation_id)){
                        $team_data[$teams_row->teams_id]['total_invitaion'][]=$teams_row->user_invitation_id;
                   }
                  
               }
               return view('admin.manageteams.index',compact('page_data','team_data'));
           //   echo "<pre>";
             //  print_r($team_data);
        }
       
        
        
        
        
    }
    
	
	
	
	public function teamedit(Request $request, $id=false){
		$page_data=['menu_selected'=>'manage_teams','header'=>'list','sub_menu_selected'=>'manage_edit'];    
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                
                /*
                $dataplan = DB::table('subscription_plans')
               ->select('subscription_plans.valid_days')
               ->where([['subscription_plans.id','=','1']])
               ->first();
               */
               
                $teams_update = Teams::find($id);
                 
                   $teams_update->team_name = $request->input('team_name');
                   $teams_update->mobile_number = $request->input('mobile_number');
                   $teams_update->company_name = $request->input('company_name');
                   $teams_update->website = $request->input('website');
                   $teams_update->email_address = $request->input('email');                   
                   $teams_update->is_active = $request->input('is_active'); 
                 
                   $teams_update->save();
					return redirect("team-list");
                
            }
           
		        
                $team_details = DB::table('teams')
               ->select('teams.team_name','teams.mobile_number','teams.company_name','teams.website','teams.email_address')
               ->where([['teams.id','=',$id]])
               ->first();
           
		   
            return view('admin.manageteams.teamedit',compact('page_data','team_details'));
        }
		
		
	}
    public function teamadd(Request $request){
        
        $page_data=['menu_selected'=>'manage_teams','header'=>'list','sub_menu_selected'=>'manage_add'];    
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                
                $dataplan = DB::table('subscription_plans')
               ->select('subscription_plans.valid_days')
               ->where([['subscription_plans.id','=','0']])
               ->first();
               
                
                 $teams_create = new Teams;
                   $teams_create->team_name = $request->input('team_name');
                   $teams_create->mobile_number = $request->input('mobile_number');
                   $teams_create->company_name = $request->input('company_name');
                   $teams_create->website = $request->input('website');
                   $teams_create->email_address = $request->input('email');                   
                   $teams_create->plan_valid_date = date('Y-m-d', strtotime("+$dataplan->valid_days days"));
                   $teams_create->created_by = auth()->user()->id;
                   $teams_create->save();
 
                    //create the team db, later move this code to data source add
                    file_get_contents($_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/cron_job/createTeamDB.php?teamId=".$teams_create->id);


                   Session::flash('success', 'Team is added! Now you can invite a user in this team');
					return redirect("team-members/$teams_create->id");
                
            }
           
            return view('admin.manageteams.teamadd',compact('page_data'));
        }
    }
    public function members(Request $request, $id=false){
        $page_data=['menu_selected'=>'manage_teams','header'=>'list','sub_menu_selected'=>'manage_list'];    
         $page_data=$this->page_data;
        if (Auth::check()) {
            if ($request->isMethod('post')) {
                   
               $datrces = DB::table('user_invitation')
               ->select('user_invitation.email_id')
               ->where([['user_invitation.email_id','=',$request->input('email_id')]])
               ->first();
                  if(isset($datrces->email_id)&&($datrces->email_id!="")){
                      $request->session()->flash('error', 'Email already exits');
                      return redirect("team-members/$id");
                      
                     
                      exit;
                  } else {
                      /// save in database
                    
                      
                      
                        $teams_user = new UserInvitation;
                        $teams_user->is_active = '1';
                        $teams_user->invite_by = auth()->user()->id;
                        $teams_user->teams_id = $id;
                        $teams_user->role_id = $request->input('role_id');
                        $teams_user->subscription_plans_id = '0';//auth()->user()->subscription_plans_id;
                        $teams_user->invitation_code = $code=rand(10000,99999);
                        $teams_user->email_id =$email_id= $request->input('email_id');
                        $teams_user->save();
                        
                    $created_id= md5($teams_user->id);
                        
                        $teams_user = UserInvitation::find($teams_user->id);
                    
                        $teams_user->created_md5_id = $created_id;
                    
                    $teams_user->save();
                     $name= auth()->user()->name;
                      
                   
                                    
                    
              
                      
                    $data = array('code'=>$code,'md5'=>$created_id,'name'=>$name);
        
                    $email_id = $request->input('email_id');//"amarjit@metricoidtech.com";
                    Mail::send('emails.admin.userinvite', $data, function($message) use ($email_id){
                        $message->to($email_id)->subject
                            ("Invitation to join ".env("APP_NAME")." Free Trial");
                        $message->from(env('MAIL_FROM_EMAIL'),env('MAIL_FROM_NAME'));
                    });            
                    $request->session()->flash('success', 'An invitation email has been sent to user');      
                    return redirect("team-members/$id"); 
                  }
                   
                    
                }            
                
               /*  $subscription_plans = DB::table('subscription_plans')                                   
               
               ->select('subscription_plans.plan_name','subscription_plans.max_team_size')
               ->where('id', $id)->first();
                */ 
            
            $subscription_plans = DB::table('teams')                                   
               ->leftJoin('subscription_plans', function ($join)   {$join->on('subscription_plans.id', '=', 'teams.plan_id');})	
               
               ->select('subscription_plans.plan_name','subscription_plans.max_team_size')
               ->where('teams.id', $id)->first();
                
                
            
            
            $teamList=array();

             


                   $teamList = DB::table('teams')
                ->leftjoin('user_invitation', 'user_invitation.teams_id', '=', 'teams.id')            
                ->leftjoin('subscription_plans', 'subscription_plans.id', '=', 'teams.plan_id')            
               ->select('subscription_plans.id as plan_id','subscription_plans.plan_name as plan_name','subscription_plans.max_team_size','teams.id as teams_id', 'teams.team_name as team_name', 'teams.company_name as company_name','teams.website as website', 'teams.email_address as email_address','teams.is_active as teams_is_active','teams.plan_id as plan_id','teams.plan_valid_date as plan_valid_date','user_invitation.id as user_invitation_id','user_invitation.users_created_id','user_invitation.name','user_invitation.id','user_invitation.invitation_code','user_invitation.email_id','user_invitation.is_acepted','user_invitation.created_at', 'user_invitation.is_active')
               ->where([['teams.id','=',$id]])
               ->get();
            
            $team_id=$id;
         $ij="0";
              foreach($teamList as $teamList_row){
                  if($teamList_row->is_acepted=="1"){
                       $ij++; 
                  }
              }
               
               
              // $member_reached= count($teamList);
               $member_reached= $ij;
            $roles = CommonHelpers::getRoles();
            return view('admin.manageteams.team',compact('page_data','teamList','member_reached','team_id','subscription_plans','roles'));        
            
        }
    }
    
    
   public function userdeleter(Request $request, $id=false,$is_active=false,$u_id=false,$team_id=false){
        if (Auth::check()) {
            
            $auth_id=Auth::user()->id;
            $uder_id=$id;
            $is_active=$is_active;
            
            User::where('id',$u_id)->update(['is_active' => $is_active]);
            
            UserInvitation::where('id',$id)->update(['is_active' => $is_active]);
            
            
            
            return redirect("/team-members/$team_id"); 
        } else {
            
        }
    
   }
    
    
    public function create(Request $request, $id=false){
        $page_data=$this->page_data;
        
        return view('admin.manageteams.create',compact('page_data'));
            
    }
    public function changeTeamStatus(Request $request){

      if ($request->isMethod('post')) {

        $teams_update = Teams::find($request->id);
        if($request->is_active==1){
          $is_active = 0;
        }else{
          $is_active = 1;
        }                  
        $teams_update->is_active = $is_active;                  
        $teams_update->save();
        return response()->json(['success' => true]);
      }
    }
    
    
}
