<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\model\User;
use App\model\TeamSubscriptionMapping;
use Mail;
class PaymentController extends Controller
{
    
    public function __construct()
    {
     	$page_data = ['menu_selected'=>'payment','header'=>'list'];    
 		$this->page_data=$page_data;         
    	$this->middleware('auth');
    }

public function stripe_input(Request $request){
	$notification = @file_get_contents('php://input');
	$notification_array=json_decode($notification,true);
	
	if($notification_array['type']=='checkout.session.completed'){
		foreach($notification_array['data'] as $value){	
			TeamSubscriptionMapping::where('session_id', '=', $value['id'])->update(array('stripe_customer_id' => $value['customer'],'stripe_subscription_id'=>$value['subscription']));
		}
	}
	if(($notification_array['type']=='customer.subscription.created')||($notification_array['type']=='customer.subscription.created')){
		foreach($notification_array['data'] as $value){		
		
			if($value['status']=="active"){
				 $subscription_plans_data = DB::table('team_subscription_mapping')                
               ->select('team_subscription_mapping.teams_id')
               ->where([['team_subscription_mapping.stripe_customer_id','=',$value['customer']],['team_subscription_mapping.stripe_subscription_id','!=',$value['id']]])
               ->first();
			if(isset($subscription_plans_data->teams_id) && is_numeric($subscription_plans_data->teams_id)){
				
				
			TeamSubscriptionMapping::where('teams_id', '=', $subscription_plans_data->teams_id)->update(array('is_current'=>0));	
			}
			User::where('teams_id', '=', $subscription_plans_data->teams_id)->update(array('valid_date'=>date("Y-m-d",$value['current_period_end'])));
			
			TeamSubscriptionMapping::where('stripe_subscription_id', '=', $value['id'])->where('stripe_customer_id', '=', $value['customer'])->update(array('stripe_current_period_end' => date("Y-m-d H:i:s",$value['current_period_end']),'current_period_start' => date("Y-m-d H:i:s",$value['current_period_start']),'invoice'=>$value['latest_invoice'],'valid_till'=>date("Y-m-d",$value['current_period_end']),'is_active'=>1,'payment_status'=>2,'is_current'=>1));	

			$teams_data = DB::table('teams')                
			   ->select('teams.id','teams.team_name')
               ->where([['teams.id','=',$subscription_plans_data->teams_id]])
               ->first();
			
			$users_data = DB::table('users')                
			   ->select('users.id','users.name','users.email')
               ->where([['users.teams_id','=',$subscription_plans_data->teams_id]])
               ->get();
			
			foreach($users_data as $users_data_row){
			///////// mail
			$email_id=$users_data_row->email;
				  $data = array('teamname'=>$teams_data->team_name);
				  Mail::send('admin.email.planmail', $data, function($message) use ($email_id){
					 $message->to($email_id, 'JAPIO')->subject
						('Your plan has been activated');
					 $message->from('japio.testing@gmail.com','JAPIO');
				  });
			}
			/////////////////
			}
			
		}
	}
}	
	public function payment_cancel(Request $request){
		//$request->session()->put('sessdata','Your transaction has been cancelled please try again');
		TeamSubscriptionMapping::where('payment_status', '=', '1')->where('user_id', '=', auth()->user()->id)->update(array('payment_status'=>'3'));	
		return view('admin.payment.cancelled');        
		
	}
    public function payment_success(Request $request){
		//verify the payment session id
		$paymentStatus = "processing";
		if($request->has("session_id") && $request->session_id!=''){
			$session = DB::table('team_subscription_mapping')
			->join('teams',['teams.id'=>'team_subscription_mapping.teams_id'])
			->select('team_subscription_mapping.session_id','team_subscription_mapping.teams_id','teams.plan_valid_date','teams.plan_id')
			->where("session_id",$request->session_id)
			->get()->first();
			if(isset($session->session_id) && $session->session_id!=''){ //session is valid and found in the db
				//fetch the session details and check for the payment status
				$stripe = new \Stripe\StripeClient(
					env("STRIPE_SECRET_KEY")
				);
				$stripeSession = $stripe->checkout->sessions->retrieve(
					$session->session_id,
				[]
				);

				if($stripeSession->payment_status=="paid" && $stripeSession->subscription!=''){

					//fetch subscription details
					$subscriptionDetails = $stripe->subscriptions->retrieve(
						$stripeSession->subscription,
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
					$paymentStatus = "paid";
				}
			}
		}
		return view('admin.payment.success',compact('paymentStatus'));      
		
		
	}
   public function index(Request $request){   
	   
	   
       define('CHECKOUT_SESSION_ID','');
      $err=$request->session()->get('sessdata','');
	  	$request->session()->put('sessdata','');
       Auth::user()->subscription_plans_id;
        $page_data=$this->page_data;
		
        $subscription_plans_data = DB::table('subscription_plans')                
       ->select('subscription_plans.stripe_price_id','subscription_plans.month_title','subscription_plans.max_team_size','subscription_plans.currency','subscription_plans.price','subscription_plans.id', 'subscription_plans.plan_name','subscription_plans.plan_description','subscription_plans.valid_title','subscription_plans.valid_days')
       ->where([['subscription_plans.id','!=','1']])
       ->get();
	   
			   foreach($subscription_plans_data as $subscription_plans_value){
				
					// Set your secret key. Remember to switch to your live secret key in production!
					// See your keys here: https://dashboard.stripe.com/account/apikeys
					\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

					$session = \Stripe\Checkout\Session::create([
					  'payment_method_types' => ['card'],
					  'line_items' => [
						[
							'price' => $subscription_plans_value->stripe_price_id,
							'quantity' => 1,
						],
						[
							'price' => $subscription_plans_value->stripe_price_id,
							'quantity' => 1,
						]
					],
					  'mode' => 'subscription',
					  'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
					  'cancel_url' => url('payment_cancel_url'),
					]);    
					$sess_data['session_d'][$session->id]=$subscription_plans_value->id;
					// 
					//////////
					
				  	$teamsubscription_mapping = new TeamSubscriptionMapping;
							  
							  
					$teamsubscription_mapping->user_id = auth()->user()->id;
			        $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
			        $teamsubscription_mapping->user_id = Auth::user()->id;
			        $teamsubscription_mapping->user_subscription_id = $subscription_plans_value->id;
			        $teamsubscription_mapping->session_id = $session->id;
			        $teamsubscription_mapping->is_current = '0';
			        $teamsubscription_mapping->payment_status = '0';
			        $teamsubscription_mapping->is_under_process = '1';
			        $teamsubscription_mapping->created_by = Auth::user()->id;

			        $teamsubscription_mapping->save();

					///////////
		   		$subscription_plans_session[]=array(
				'stripe_price_id'=>$subscription_plans_value->stripe_price_id,
				'month_title'=>$subscription_plans_value->month_title,
				'max_team_size'=>$subscription_plans_value->max_team_size,
				'currency'=>$subscription_plans_value->currency,
				'price'=>$subscription_plans_value->price,
				'id'=>$subscription_plans_value->id,
				'plan_name'=>$subscription_plans_value->plan_name,
				'plan_description'=>$subscription_plans_value->plan_description,
				'valid_title'=>$subscription_plans_value->valid_title,
				'valid_days'=>$subscription_plans_value->valid_days,
				
				'checkout_session_id'=>$session->id
			   );	
		   }
			
	    $request->session()->put('sess_data', $sess_data);
	     if(!defined('CHECKOUT_SESSION_ID')){define('CHECKOUT_SESSION_ID','1234') ;};
          return view('admin.payment.index',compact('page_data','subscription_plans_data','subscription_plans_session','err'));
                
   }

   public function testStripeSession(){
	$stripe = new \Stripe\StripeClient(
		env('STRIPE_SECRET_KEY')
	  );

	  // Testing price update
	  $res = $stripe->prices->update(
		'price_1HW0C5Ac4hatmiCIbngQgpio',
		['unit_amount' => '16800']
	  );
dd($res);

	// Testing product update
	$res = $stripe->products->update(
		'prod_I6Cbo6SAHFn8bG',
		['name' => 'Integrate-preneurs']
	  );
	dd($res);
	
	
	
	
	
	\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

	$session = \Stripe\Checkout\Session::create([
	  'payment_method_types' => ['card'],
	  'line_items' => [
		[
			'price' => 'price_1HUzQvAc4hatmiCIuOTmUV0u',
			'quantity' => 1,
		],
		[
			'price' => 'price_1HVc23Ac4hatmiCIMDveK0Nx',
			'quantity' => 1,
		]
	],
	  'mode' => 'subscription',
	  'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
	  'cancel_url' => url('payment_cancel_url'),
	]);   
	dd($session->id); 
   }
}
