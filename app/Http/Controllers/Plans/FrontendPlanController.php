<?php
namespace App\Http\Controllers\Plans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\model\User;
use App\model\TeamSubscriptionMapping;
use Mail;
use App\Http\Controllers\Controller;
use App\model\SubscriptionPlans;
use App\model\SubscriptionTeams;
use App\model\SubscriptionPrices;
use App\Helpers\CommonHelpers;
class FrontendPlanController extends Controller
{
    public function index(){
      CommonHelpers::getSubscriptionExpiryDays();
      $mainPlansMonthly = DB::table('subscription_plans')
          ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
          ->select('subscription_plans.*','subscription_prices.*')
          ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1,'subscription_prices.price_type'=>'monthly'])
          ->get()->toArray();
      $mainPlansYearly = DB::table('subscription_plans')
          ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
          ->select('subscription_plans.*','subscription_prices.*')
          ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1,'subscription_prices.price_type'=>'yearly'])
          ->get()->toArray();
         // dd($mainPlansYearly);
      $addonPlansMonthly = DB::table('subscription_plans')
          ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
          ->select('subscription_plans.*','subscription_prices.*')
          ->where(['subscription_plans.parent_id'=>1,'subscription_plans.is_active'=>1,'subscription_prices.price_type'=>'monthly'])
          ->get()->toArray();
        //dd($addonPlansMonthly);
      $addonPlansYearly = DB::table('subscription_plans')
          ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
          ->select('subscription_plans.*','subscription_prices.*')
          ->where(['subscription_plans.parent_id'=>1,'subscription_plans.is_active'=>1,'subscription_prices.price_type'=>'yearly'])
          ->get()->toArray(); 
          //dd($addonPlansYearly);    
      $freePlan = DB::table('subscription_plans')
          ->select('subscription_plans.*')
          ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1,'id'=>0])
          ->get()->toArray();
      $teams = DB::table('subscription_teams')
          ->select('*')
          ->first();
          if(isset($teams->team_id)){         
            $teams_id   = json_decode($teams->team_id);
          }else{
            $teams_id   = array();
          }
          $loginUser  = in_array(Auth::user()->id,  $teams_id);

      $page_data = ['menu_selected'=>'upgrade-plan']; 

    	return view('admin.plans.frontendPlans',compact('mainPlansMonthly','addonPlansMonthly','teams','mainPlansYearly','addonPlansYearly','freePlan','page_data'));
    }
    public function get_plan(Request $request){

      if($request->isMethod('post')){

       \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        if(!empty($request->id ) && !empty($request->addon_id )){

            $mainPlan = SubscriptionPrices::where('plan_id',$request->id)->first();

            $addonPlan = SubscriptionPrices::where('plan_id',$request->addon_id)->first();

            $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
              'price' => $mainPlan->stripe_price_id,
              'quantity' => 1,
              ],[
              'price' => $addonPlan->stripe_price_id,
              'quantity' => 1,
              ]],
              'mode' => 'subscription',
              'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
              'cancel_url' => url('payment_cancel_url'),
            ]);
            
            
            $teamsubscription_mapping = new TeamSubscriptionMapping;
            $teamsubscription_mapping->user_id = auth()->user()->id;
            $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
            $teamsubscription_mapping->session_id = $session->id;
            $teamsubscription_mapping->save();
            

        }elseif (!empty($request->id)) {
         $mainPlan = SubscriptionPrices::where('plan_id',$request->id)->first();
          $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
              'price' => $mainPlan->stripe_price_id,
              'quantity' => 1,
              ]],
              'mode' => 'subscription',
              'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
              'cancel_url' => url('payment_cancel_url'),
            ]);
            $teamsubscription_mapping = new TeamSubscriptionMapping;
            $teamsubscription_mapping->user_id = auth()->user()->id;
            $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
            $teamsubscription_mapping->session_id = $session->id;
            $teamsubscription_mapping->save();
        }
        return response()->json([
          'success' => true,
          'data'   => $session->id
        ]);  
      }
    }
    public function get_yearly_plan(Request $request){

      if($request->isMethod('post')){

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        if(!empty($request->yearly_id ) && !empty($request->yearly_addon_id )){
          $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
              'price' => $request->yearly_id,
              'quantity' => 1,
              ],[
              'price' => $request->yearly_addon_id,
              'quantity' => 1,
              ]],
              'mode' => 'subscription',
              'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
              'cancel_url' => url('payment_cancel_url'),
            ]);
            $teamsubscription_mapping = new TeamSubscriptionMapping;
            $teamsubscription_mapping->user_id = auth()->user()->id;
            $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
            $teamsubscription_mapping->session_id = $session->id;
            $teamsubscription_mapping->save();
        }elseif (!empty($request->yearly_id)) {
          $session = \Stripe\Checkout\Session::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
              'price' => $request->yearly_id,
              'quantity' => 1,
              ]],
              'mode' => 'subscription',
              'success_url' => url('payment_success_url?session_id={CHECKOUT_SESSION_ID}'),
              'cancel_url' => url('payment_cancel_url'),
            ]);
            $teamsubscription_mapping = new TeamSubscriptionMapping;
            $teamsubscription_mapping->user_id = auth()->user()->id;
            $teamsubscription_mapping->teams_id = Auth::user()->teams_id;
            $teamsubscription_mapping->session_id = $session->id;
            $teamsubscription_mapping->save();
        }
        return response()->json([
          'success' => true,
          'data'   => $session->id
        ]);

      }
    }
}

