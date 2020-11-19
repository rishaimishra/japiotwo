<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\model\TeamSubscriptionMapping;
use App\model\Teams;


class WebhooksController extends Controller
{
    
public function stripe_input(Request $request){

	$notification = @file_get_contents('php://input');
	$notification_array=json_decode($notification,true);
	file_put_contents(getcwd()."/../storage/logs/stripereponse.txt",PHP_EOL.$notification.PHP_EOL, FILE_APPEND);
        
	
	if($notification_array['type']=='checkout.session.completed'){
		if(isset($notification_array['data']['id']) && $notification_array['data']['id']!=''){
			$session = DB::table('team_subscription_mapping')
			->innerJoin('teams',['teams.id','team_subscription_mapping.teams_id'])
			->select('team_subscription_mapping.session_id','team_subscription_mapping.teams_id','teams.plan_valid_date','teams.plan_id')
			->where("session_id",$notification_array['data']['id'])
			->get()->first();
			//get the subscribed plan
			if($session->session_id!=''){ //session is valid and found in the db
				if($notification_array['data']['payment_status']=="paid" && $notification_array['data']['subscription']!=''){

					//fetch subscription details
					$subscriptionDetails = $stripe->subscriptions->retrieve(
						$notification_array['data']['subscription'],
						[]
					);

					$exipryDate = date("Y-m-d H:i:s",$subscriptionDetails->current_period_end);
					$planIds = [];
					//get the subscribed plans and store in the respective tables
					$subscribedPlans = [];
					foreach($subscriptionDetails->items->data as $planDetails){
						$localPlan = DB::table('subscription_plans')->select('id')->where(['stripe_prod_id'=>$planDetails->plan->product,'is_active'=>1])->get()->first();
						$planIds[] = $localPlan->id; 
					}
					$planIds = implode(",",$planIds);
					DB::table('teams')->where('id',$session->teams_id)->update(['plan_valid_date'=>$exipryDate,'plan_id'=>$planIds]);
					
					return view('admin.payment.success');
				}else{
					//degrade the plan
				}
				die;
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		foreach($notification_array['data'] as $value){	
			TeamSubscriptionMapping::where('session_id', '=', $value['id'])->update(array('stripe_customer_id' => $value['customer'],'stripe_subscription_id'=>$value['subscription']));
		}
	}
	
	if(($notification_array['type']=='customer.subscription.created')||($notification_array['type']=='customer.subscription.updated')){
		foreach($notification_array['data'] as $value){		
		
			if($value['status']=="active"){
				
				
				$subscription_plans_data = DB::table('team_subscription_mapping')->select('team_subscription_mapping.teams_id','team_subscription_mapping.user_subscription_id','team_subscription_mapping.user_id')
               ->where([['team_subscription_mapping.stripe_customer_id','=',$value['customer']],['team_subscription_mapping.stripe_subscription_id','=',$value['id']]])
               ->first();
				if(isset($subscription_plans_data->teams_id) && is_numeric($subscription_plans_data->teams_id)){
				
				
					TeamSubscriptionMapping::where('teams_id', '=', $subscription_plans_data->teams_id)->update(array('is_current'=>'0'));	
				}
				User::where('teams_id', '=', $subscription_plans_data->teams_id)->update(array('valid_date'=>date("Y-m-d",$value['current_period_end']),'subscription_plans_id'=>$subscription_plans_data->user_subscription_id));
			

//////////// team
				Teams::where('id', '=', $subscription_plans_data->teams_id)->update(array('plan_valid_date'=>date("Y-m-d",$value['current_period_end']),'plan_id'=>$subscription_plans_data->user_subscription_id));
			/////////////
			
				User::where('id', '=', $subscription_plans_data->user_id)->update(array('stripe_customer_id'=>$value['customer']));
				
				
				
				//$stripe_current_period_end = date("Y-m-d H:i:s",$value['current_period_end']);
				
			//TeamSubscriptionMapping::where('stripe_current_period_end'=>$stripe_current_period_end,'stripe_subscription_id', '=', $value['id'])->where('stripe_customer_id', '=', $value['customer'])->update(array('invoice'=>$value['latest_invoice'],'valid_till'=>date("Y-m-d",$value['current_period_end']),'is_active'=>'1','payment_status'=>'2','is_current'=>'1'));
			
			
				TeamSubscriptionMapping::where('stripe_subscription_id', '=', $value['id'])->where('stripe_customer_id', '=', $value['customer'])->update(array('stripe_current_period_end' => date("Y-m-d H:i:s",$value['current_period_end']),'stripe_current_period_start' => date("Y-m-d H:i:s",$value['current_period_start']),'invoice'=>$value['latest_invoice'],'valid_till'=>date("Y-m-d",$value['current_period_end']),'is_active'=>'1','payment_status'=>'2','is_current'=>'1'));	
			}
			
		}
	}
}	
}
