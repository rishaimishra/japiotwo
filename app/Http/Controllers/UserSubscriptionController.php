<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\model\TeamSubscriptionMapping;
use DB;
use Illuminate\Http\Request;
use App\Helpers\CommonHelpers;
use Session;
class UserSubscriptionController extends Controller
{
    
    public function payment_cancel(Request $request){
		$request->session()->put('sessdata','Your transaction has been cancelled please try again');
	TeamSubscriptionMapping::where('payment_status', '=', '1')->where('user_id', '=', auth()->user()->id)->update(array('payment_status'=>'3'));
	
		return redirect('home');        
	}
    public function payment_success(Request $request){
		
		/* 
		$notification = @file_get_contents('php://input');

		file_put_contents('stripe_notification.txt', $notification, FILE_APPEND);
		
	
	     $sess_data = $request->session()->get('sess_data');
		$sess_data['session_d'][$request->input('session_id')]; /// plan id
		
        $teamsubscription_mapping = new TeamSubscriptionMapping;
				  
				  
		$teamsubscription_mapping->user_id = auth()->user()->id;
        $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
        $teamsubscription_mapping->user_id = Auth::user()->id;
        $teamsubscription_mapping->user_subscription_id = $sess_data['session_d'][$request->input('session_id')];
        $teamsubscription_mapping->session_id = $request->input('session_id');
        $teamsubscription_mapping->is_current = '0';
        $teamsubscription_mapping->payment_status = '1';
        $teamsubscription_mapping->is_under_process = '1';
        $teamsubscription_mapping->created_by = Auth::user()->id;
 */
       // $teamsubscription_mapping->save();
        
		  return redirect('upgrade-plan');        
		
		
	}
    public function payment_sus(Request $request){ 
	
		$notification = @file_get_contents('php://input');

file_put_contents('stripe_notification.txt', $notification, FILE_APPEND);
	
    /* $payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        // Then define and call a method to handle the successful payment intent.
        // handlePaymentIntentSucceeded($paymentIntent);
        break;
    case 'payment_method.attached':
        $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
        // Then define and call a method to handle the successful attachment of a PaymentMethod.
        // handlePaymentMethodAttached($paymentMethod);
        break;
    // ... handle other event types
    default:
        // Unexpected event type
        http_response_code(400);
        exit();
}

http_response_code(200);
    exit; */
    // Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_51H4jv2CmbO3yrb8QO4MWE4tCuyoiVfKbLZmHHQLzeGmSfRygG8SYxOVixiXsIXGUu17gz7RHoVKmfcK0nPg9AEZB00BP5uKt5I');

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'sk_test_51H4jv2CmbO3yrb8QO4MWE4tCuyoiVfKbLZmHHQLzeGmSfRygG8SYxOVixiXsIXGUu17gz7RHoVKmfcK0nPg9AEZB00BP5uKt5I';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Handle the checkout.session.completed event
if ($event->type == 'checkout.session.completed') {
  $session = $event->data->object;

  // Fulfill the purchase...
  handle_checkout_session($session);
}

http_response_code(200);
    }
    
    public function update_sess(Request $request){
		$request->input('s_id',true);
		if($request->input('s_id')!=""){
			
			TeamSubscriptionMapping::where('session_id', '=', $request->input('s_id'))->update(array('payment_status' => 1));	
		}
  }
  
  public function index(Request $request){ 
    $err=$request->session()->get('sessdata','');
    $request->session()->put('sessdata','');
      if (Auth::check()) {  
      $userId   = Auth::user()->role_id;
      $roleName = DB::table('roles')->find($userId); 
      if ($roleName->name == 'administrator') {
        return redirect('team-list');
      } else{
        $days = CommonHelpers::getSubscriptionExpiryDays();
        if($days>0){ //if has a valid plan

          $countUserConnectors = DB::table('users')               			   
            ->join('user_connectors', function ($join)  {$join->on('user_connectors.user_id', '=', 'users.id');})
            ->select('user_connectors.id as user_connectors_id','users.id as users_id','user_connectors.connection_status as connection_status','user_connectors.connector_type as connector_type')
             ->where([['users.teams_id','=',Auth::user()->teams_id]])
              ->orderBy('connector_type', 'asc')
             ->get()->count();

          if($countUserConnectors>0){ 
            return redirect('dashboard');
          }else{
            return redirect()->route('datasources');
          }
          
        }else{
          return redirect('upgrade-plan');
        }
      }
    }
  }

  public function index_old(Request $request){ 
	 $err=$request->session()->get('sessdata','');
	  	$request->session()->put('sessdata','');
     if (Auth::check()) {  
            $current_date=date("Y-m-d");
             $valid_date=Auth::user()->valid_date;
             $date1_ts = strtotime($valid_date);
                $date2_ts = strtotime($current_date);
                $diff = $date1_ts - $date2_ts;
          
                $days=$diff / 86400;      

            if($days<'1'){
              // we are processing your payment thanks for the subcription, we will update you once payment will confirm 
			   
			   
                $team_subscription_mapping_data = DB::table('team_subscription_mapping')                
               ->select('team_subscription_mapping.id')
               ->where([['team_subscription_mapping.teams_id','=',Auth::user()->teams_id],['team_subscription_mapping.payment_status','=','1'],['team_subscription_mapping.is_active','=','1']])
               ->first();
			 $subscription_plans_session=array();  
			  if(isset($team_subscription_mapping_data) && is_numeric($team_subscription_mapping_data)){
				/// message  
			  } else {
			   
                $subscription_plans_data = DB::table('subscription_plans')
                
               ->select('subscription_plans.stripe_price_id','subscription_plans.month_title','subscription_plans.max_team_size','subscription_plans.currency','subscription_plans.price','subscription_plans.id', 'subscription_plans.plan_name','subscription_plans.plan_description','subscription_plans.valid_title','subscription_plans.valid_days')
               ->where([['subscription_plans.is_active','=','1'],['subscription_plans.id','!=','0']])
               ->get();
			   foreach($subscription_plans_data as $subscription_plans_value){
					// Set your secret key. Remember to switch to your live secret key in production!
					// See your keys here: https://dashboard.stripe.com/account/apikeys
					\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

					$session = \Stripe\Checkout\Session::create([
					  'payment_method_types' => ['card'],
					  'line_items' => [[
						'price' => $subscription_plans_value->stripe_price_id,
						'quantity' => 1,
						]],
					  'mode' => 'subscription',
					  'success_url' => url('payment_success?session_id={CHECKOUT_SESSION_ID}'),
					  'cancel_url' => url('payment_cancel'),
					]);            
					$sess_data['session_d'][$session->id]=$subscription_plans_value->id;
					// 
					/////////
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
    
					/////////
					
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
			  }
			  define('CHECKOUT_SESSION_ID','1234');
          return view('admin.payment.plan',compact('subscription_plans_data','subscription_plans_session','team_subscription_mapping_data','err'));
                
                
            } else {

                $request->session()->put('valid_till', $days);
              	$userId   = Auth::user()->role_id;
		        $roleName = DB::table('roles')->find($userId); 
		        if ($roleName->name == 'administrator') {
					return redirect('team-list');
				} else{
                return redirect('dashboard');
				}
                
                
            }
            echo Auth::user()->valid_date;
            echo "<pre>";
            echo "<pre>";    
            print_r(Auth::user());
            exit;
        } else {
                return redirect('dashboard');
        }
    }
}
