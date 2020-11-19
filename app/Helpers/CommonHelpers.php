<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use DB; 
use Illuminate\Support\Facades\Auth;
use Session;
use App\model\UserConnector;
use App\model\TempDataConnection;
class CommonHelpers 
{
	
    static function getRemainingUsers($teamId="")
    {
        if($teamId==""){
            $teamId = Auth::user()->teams_id;
        }
        $totalAllowedUsers = self::getTotalUsersInPlan($teamId);
        if($totalAllowedUsers=="unlimited"){
            return 1000000;
        }else{
            //get total users already added in this team
            $count = DB::table('users') 
                    ->where('teams_id', $teamId)
                    ->get()->count();
            
            return ($totalAllowedUsers-$count); 
        }
    }

    static function getTotalUsersInPlan($teamId=""){
        if($teamId==""){
            $teamId = Auth::user()->teams_id;
        }
        $team = DB::table('teams') 
        ->select(array('plan_id',DB::raw("DATEDIFF(plan_valid_date,NOW()) AS Days")))
        ->where('id', $teamId)
        ->get()->first();
        $maxUsers = 0;
        if(isset($team->plan_id) && $team->plan_id!=''){
            $subscribedPlans = DB::table('subscription_plans')->whereIn('id',explode(",",$team->plan_id))->get();
            foreach($subscribedPlans as $planDetails){
                if($planDetails->max_business_users==-1 || $planDetails->max_integrator_user==-1){ //if its unlimited
                    return "unlimited";
                }else{
                    $maxUsers += ($planDetails->max_business_users+$planDetails->max_integrator_user);
                }
                
            }
        }
        return $maxUsers;
        
    }

    static function getRoles($forTeam=1){
        return DB::table('roles')                                   
        ->where('isForTeam', $forTeam)->get();
    }

    static function getSubscriptionExpiryDays(){
        $a = DB::table('teams') 
        ->select(array('plan_id',DB::raw("DATEDIFF(plan_valid_date,NOW()) AS Days")))
        ->where('id', Auth::user()->teams_id)
        ->get()->first();

        $days = (isset($a->Days) && $a->Days>0)?$a->Days:0;
        $planType = ($a->plan_id!=0)?"paid":"free";

        //get the plan names
        $planDetails = DB::table('subscription_plans') 
        ->whereIn('id', explode(",",$a->plan_id))
        ->get();
        $mainPlan = $addOn = "";
        foreach($planDetails as $details){
            if($details->parent_id==0){
                $mainPlan = $details->plan_name;
            }else{
                $addOn = $details->plan_name;
            }
        }
        if($mainPlan!='' && $addOn!=''){
            $planName = "$mainPlan with addon $addOn";
        }else{
            $planName = $mainPlan;
        }
        Session::put('plan_validity_days', $days);
        Session::put('subscribed_plan', $planName);
        Session::put('subscribed_plan_type',$planType);
        
        return $days;

    }

    public static function authenticateOAuth2($id,$input_credentials=array(),$connectorType=1){ //default is data source, 2 is for target/datawarehouse
        if(Auth::user()->id>0){
            $secured_code = base64_encode(Auth::user()->id."_".$id."_".$connectorType);
            $tmp_details = DB::table('temp_data_connection')->select('id')->where(array("secured_code"=>$secured_code,'user_id'=>Auth::user()->id,'datasource_id'=>$id, 'connector_type'=>$connectorType))->first();
            if(count($input_credentials)>0){
                $input_credentials = json_encode($input_credentials);
            }else{
                $input_credentials = '';
            }
            if(isset($tmp_details->id)){
                $TempDataConnection = TempDataConnection::find($tmp_details->id);
                $TempDataConnection->input_credentials = $input_credentials;
            }else{
                $TempDataConnection = new TempDataConnection();
                $TempDataConnection->secured_code = $secured_code;
                $TempDataConnection->connector_type = $connectorType;
                $TempDataConnection->user_id = Auth::user()->id;
                $TempDataConnection->datasource_id = $id;
                $TempDataConnection->input_credentials = $input_credentials;            
            }
            
            $TempDataConnection->save();
            ob_start();
			header('Location:' .env("JAPIO_API_AND_AUTH_APP_URL")."/oauth2connect/".$secured_code);
			exit;

        }else{
            return redirect('data-sources'); 
        }

    }
}
