<?php
namespace App\Http\Controllers\Plans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\model\User;
use App\model\Teams;
use App\model\TeamSubscriptionMapping;
use App\model\SubscriptionPlans;
use App\model\SubscriptionTeams;
use App\model\SubscriptionPrices;
use Mail;
use App\Http\Controllers\Controller;
class AdminPlanController extends Controller
{

    public function index(){
              /*$plans = DB::table('subscription_plans')
              ->select("subscription_prices.*","subscription_plans.*" ,DB::raw("(GROUP_CONCAT(subscription_prices.price_type SEPARATOR ', ')) as type"),DB::raw("(GROUP_CONCAT(subscription_prices.price SEPARATOR ', ')) as price"))
              ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
              ->groupBy('subscription_prices.plan_id')
              ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1])
              ->orderBy('subscription_plans.id', 'DESC')
              ->get();*/
        $plans = DB::table('subscription_plans')
            ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
            ->select('subscription_plans.id','subscription_prices.is_addon','subscription_plans.plan_name','subscription_plans.valid_days','subscription_plans.plan_description','subscription_plans.is_active','subscription_prices.price_type','subscription_prices.price')
            ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1])
            ->get();
            
          /*$counts = DB::table('subscription_plans')
          ->leftjoin('subscription_prices', 'subscription_prices.is_addon', '=', 'subscription_plans.id') 
          ->select('subscription_plans.*','subscription_prices.*')
          ->where(['subscription_plans.parent_id'=>0,'subscription_plans.is_active'=>1])
          ->count();*/

          //dd($counts); 
    	return view('admin.plans.adminPlans',compact('plans','counts'));
    }
    public function store(Request $request){

      $teams = DB::table('teams')                
               ->select('id','team_name')->where('is_active',1)->get();
    	if($request->isMethod('post')){

    		$plan 						= new SubscriptionPlans();
    		$plan->plan_name 			= $request->get('name');
    		$plan->parent_id 			= 0;

    		$plan->plan_description		= $request->get('description');
    		if($request->get('monthly_price')){
    			$days = 30;
    		}elseif($request->get('quaterly_price')){
    			$days = 90;
    		}elseif($request->get('half_yealry_price')){
    			$days = 180;
    		}else{
    			$days = 365;
    		}
    		$plan->valid_days           =   $days;
        $plan->max_integrator_user  =   $request->get('max_team_size');
        $plan->max_data_sources     =   $request->get('max_data_sources');
        $plan->max_business_users   =   $request->get('max_business_users');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $product = \Stripe\Product::create([
          'name' => $request->get('name'),
        ]);
        $plan->stripe_prod_id =$product['id'];

		    $plan->save();

            $plan_id = $plan->id;

            if($plan_id){
               $team = new SubscriptionTeams();
               if($request->customised_plan=='customise'){
                    $team->team_id  = json_encode($request->get('team'));
                    $team->plan_id  = $plan_id;
                    $team->is_valid = $days;
                    $team->save();
               }
            }
            if($plan_id){

                $plans = SubscriptionPlans::find($plan_id); 
               
                if($request->get('monthly_price')>0){
                    $pricesMonthly = new SubscriptionPrices();
                     /** stripe price**/
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                    $stripePriceMonthly = \Stripe\Price::create([
                      'product'  => $plans->stripe_prod_id,
                      'unit_amount' => $request->get('monthly_price')*100,
                      'currency' => 'USD',
                      'recurring' => [
                        'interval' => 'month',
                      ],
                    ]);

                    $pricesMonthly->plan_id  = $plan_id;
                    $pricesMonthly->price_type  = 'monthly'; 
                    $pricesMonthly->stripe_price_id  = $stripePrice['id']; 
                    $pricesMonthly->price  = $request->get('monthly_price'); 
                    $pricesMonthly->currency  = 'USD';
                    $pricesMonthly->save(); 
                }if($request->get('quaterly_price')>0){
                    $pricesQuaterly = new SubscriptionPrices();
                    /** stripe price**/
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                    $stripePriceQuaterly = \Stripe\Price::create([
                      'product'  => $plans->stripe_prod_id,
                      'unit_amount' => $request->get('quaterly_price')*100,
                      'currency' => 'USD',
                      'recurring' => [
                        'interval' => 'month',
                      ],
                    ]);
                    $pricesQuaterly->plan_id  = $plan_id; 
                    $pricesQuaterly->price_type  = 'quarterly'; 
                    $pricesQuaterly->stripe_price_id  = $stripePriceQuaterly['id']; 
                    $pricesQuaterly->price  = $request->get('quaterly_price'); 
                    $pricesQuaterly->currency  = 'USD';
                    $pricesQuaterly->save(); 
                    
                }if($request->get('half_yealry_price')>0){
                    $pricesHalfyearly = new SubscriptionPrices();
                     /** stripe price**/
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                    $stripePriceHalfyearly = \Stripe\Price::create([
                      'product'  => $plans->stripe_prod_id,
                      'unit_amount' => $request->get('half_yealry_price')*100,
                      'currency' => 'USD',
                      'recurring' => [
                        'interval' => 'month',
                      ],
                    ]);
                    $pricesHalfyearly->plan_id  = $plan_id; 
                    $pricesHalfyearly->price_type  = 'halfyearly'; 
                    $pricesHalfyearly->stripe_price_id  = $stripePriceHalfyearly['id']; 
                    $pricesHalfyearly->price  = $request->get('half_yealry_price'); 
                    $pricesHalfyearly->currency  = 'USD';
                    $pricesHalfyearly->save(); 
                   
                }if($request->get('yearly_price')>0){
                    $pricesYearly = new SubscriptionPrices();
                    /** stripe price**/
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                    $stripePriceYearly = \Stripe\Price::create([
                      'product'  => $plans->stripe_prod_id,
                      'unit_amount' => $request->get('yearly_price')*100,
                      'currency' => 'USD',
                      'recurring' => [
                        'interval' => 'year',
                      ],
                    ]);
                    $pricesYearly->plan_id  = $plan_id; 
                    $pricesYearly->price_type  = 'yearly'; 
                    $pricesYearly->stripe_price_id  = $stripePriceYearly['id']; 
                    $pricesYearly->price  = $request->get('yearly_price'); 
                    $pricesYearly->currency  = 'USD';
                    $pricesYearly->save(); 

                    
                }
            }
    		return Redirect('plans')->with('success','Plan has been created successfully!');
    	}
    	return view('admin.plans.store',compact('teams'));
    }
    public function edit(Request $request,$id){

        if(SubscriptionPlans::find($id)){
          $plan = SubscriptionPlans::find($id);
          $price =SubscriptionPrices::where('plan_id',$id)->first();
          /*$price = DB::table('subscription_prices')
              ->select(DB::raw('group_concat(price) as mainprices,group_concat(price_type) as priceType'))
              ->where('plan_id',$id)
              ->first();*/
          
        }
        //dd($price->mainprices);
        $team = SubscriptionTeams::where('plan_id',$id)->first(); 
        $users =DB::table('teams')                
               ->select('id','team_name')->where('is_active',1)->get();
        if($request->isMethod('post')){
            $plan                       = SubscriptionPlans::find($id);
            $plan->plan_name            = $request->get('name');
            $plan->parent_id            = 0;
            $plan->plan_description     = $request->get('description');
            $plan->is_active            = $request->get('is_active');
           
            if($request->get('monthly_price')){
                $days = 30;
            }elseif($request->get('quaterly_price')){
                $days = 90;
            }elseif($request->get('half_yealry_price')){
                $days = 180;
            }elseif($request->get('yearly_price')){
                $days = 365;
            }else{
              $days = 0;
            }
            $plan->valid_days           =   $days;
            $plan->max_integrator_user  =   $request->get('max_team_size');
            $plan->max_data_sources     =   $request->get('max_data_sources');
            $plan->max_business_users   =   $request->get('max_business_users');

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $product = $stripe->products->update($plan->stripe_prod_id,
              ['name' => $request->get('name')]);

            $plan->stripe_prod_id = $product['id'];

            $plan->save();
            $plan_id = $plan->id;
            $plans = SubscriptionPlans::find($plan_id);
            if($plans){
              if($request->customised_plan == 'customise'){
                SubscriptionTeams::where('plan_id', '=', $plan_id)->update(array('team_id'=>json_encode($request->get('team'))));
              }
              if($request->get('monthly_price')>0){
                $pricesMonthly = new SubscriptionPrices();
                /** stripe price**/
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $stripePriceMonthly = \Stripe\Price::create($plans->stripe_prod_id,[
                'unit_amount' => $request->get('monthly_price')*100,
                'currency' => 'USD',
                'recurring' => [
                  'interval' => 'month',
                ],
                ]);
                $pricesMonthly->plan_id  = $plan_id; 
                $pricesMonthly->price_type  = 'monthly'; 
                $pricesMonthly->stripe_price_id  = $stripePriceMonthly['id']; 
                $pricesMonthly->price  = $request->get('monthly_price'); 
                $pricesMonthly->currency  = 'USD';
                $pricesMonthly->save(); 
                      
              }
              if($request->get('quaterly_price')>0){
                  $pricesQuaterly = new SubscriptionPrices();
                  /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                  $stripePriceQuaterly = \Stripe\Price::create([
                    'product'  => $plans->stripe_prod_id,
                    'unit_amount' => $request->get('quaterly_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'year',
                    ],
                  ]);
                  $pricesQuaterly->plan_id  = $plan_id; 
                  $pricesQuaterly->price_type  = 'quarterly'; 
                  $pricesQuaterly->stripe_price_id  = $stripePriceQuaterly['id']; 
                  $pricesQuaterly->price  = $request->get('quaterly_price'); 
                  $pricesQuaterly->currency  = 'USD';
                  $pricesQuaterly->save(); 
                  
              }
              if($request->get('half_yealry_price')>0){
                  $pricesHalfyearly = new SubscriptionPrices();
                  /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                  $stripePriceHalfyearly = \Stripe\Price::create([
                    'product'  => $plans->stripe_prod_id,
                    'unit_amount' => $request->get('half_yealry_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'year',
                    ],
                  ]);
                  $pricesHalfyearly->plan_id  = $plan_id; 
                  $pricesHalfyearly->price_type  = 'halfyearly'; 
                  $pricesHalfyearly->stripe_price_id  = $stripePriceHalfyearly['id']; 
                  $pricesHalfyearly->price  = $request->get('half_yealry_price'); 
                  $pricesHalfyearly->currency  = 'USD';
                  $pricesHalfyearly->save(); 
                  
              }
              if($request->get('yearly_price')>0){
                  $pricesYearly = new SubscriptionPrices();
                  /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                  $stripePriceYearly = \Stripe\Price::create([
                    'product'  => $plans->stripe_prod_id,
                    'unit_amount' => $request->get('yearly_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'year',
                    ],
                  ]);
                  $pricesYearly->plan_id          = $plan_id; 
                  $pricesYearly->price_type       = 'yearly'; 
                  $pricesYearly->stripe_price_id  = $stripePriceYearly['id'];
                  $pricesYearly->price            = $request->get('yearly_price'); 
                  $pricesYearly->currency         = 'USD';
                  $pricesYearly->save(); 
                  
              } 
            return back()->with('editSuccess','Plan has been updated successfully!');
          }
        }
        return view('admin.plans.edit',compact('plan','id','users','team','price'));
    }
    public function delete(Request $request,$id){
        
        if(SubscriptionPlans::find($id)){
            $plan =SubscriptionPlans::find($id);
            SubscriptionTeams::where('plan_id', '=', $id)->delete();
            SubscriptionPrices::where('plan_id', '=', $id)->delete();
            $plan->delete();
            return Redirect('plans')->with('deleteSuccess','Plan has been deleted successfully!');
        }
    }
}
