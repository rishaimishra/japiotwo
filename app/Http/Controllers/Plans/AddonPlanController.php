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
class AddonPlanController extends Controller
{
	public function index(Request $request,$id){
  	$plans = DB::table('subscription_plans')
             ->leftjoin('subscription_prices', 'subscription_prices.plan_id', '=', 'subscription_plans.id')
             ->select('subscription_plans.id','subscription_plans.plan_name','subscription_plans.valid_days','subscription_plans.plan_description','subscription_plans.is_active','subscription_prices.price_type','subscription_prices.price')
             ->where(['subscription_plans.parent_id'=>1,'subscription_plans.is_active'=>1,'subscription_prices.is_addon'=>$id])
             ->get();
    
    return view('admin.plans.addons',compact('plans','id'));
  }
    public function store(Request $request,$id){
    	
    	if($request->isMethod('post')){
    		$plan 						= new SubscriptionPlans();
    		$plan->plan_name 			= $request->get('name');
    		$plan->parent_id 			= 1;
        $plan->plan_description   = $request->get('description');
    		if($request->get('monthly_price')){
    			$days = 30;
    		}elseif($request->get('quaterly_price')){
    			$days = 90;
    		}elseif($request->get('half_yealry_price')){
    			$days = 180;
    		}else{
    			$days = 365;
    		}
    		$plan->valid_days               =   $days;
            $plan->max_integrator_user  =   $request->get('max_team_size');
            $plan->max_data_sources     =   $request->get('max_data_sources');
            $plan->max_business_users   =   $request->get('max_business_users');

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $product = \Stripe\Product::create([
              'name' => $request->get('name'),
            ]);
            $plan->stripe_prod_id =$product['id'];
    		    $plan->save();

            $plan_id =$plan->id;

            if($plan_id){

               if($request->get('monthly_price')>0){
                  $plansMonthly = SubscriptionPlans::find($plan_id);
                  $pricesMonthly = new SubscriptionPrices();
                   /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                  $stripePriceMonthly = \Stripe\Price::create([
                    'product'  => $plansMonthly->stripe_prod_id,
                    'unit_amount' => $request->get('monthly_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'month',
                    ],
                  ]);
                  $pricesMonthly->plan_id  = $plan_id; 
                  /*$pricesMonthly->is_addon  = $id;*/ 
                  $pricesMonthly->price_type  = 'monthly'; 
                  $pricesMonthly->stripe_price_id  = $stripePriceMonthly['id'];
                  $pricesMonthly->price  = $request->get('monthly_price'); 
                  $pricesMonthly->currency  = 'USD';
                  $pricesMonthly->save(); 
                    
                }if($request->get('quaterly_price')>0){
                  $plansQuaterly = SubscriptionPlans::find($plan_id);
                  $pricesQuaterly = new SubscriptionPrices();
                  /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                  $stripePriceQuaterly = \Stripe\Price::create([
                    'product'  => $plansQuaterly->stripe_prod_id,
                    'unit_amount' => $request->get('quaterly_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'month',
                    ],
                  ]);
                  $pricesQuaterly->plan_id  = $plan_id;
                  /*$pricesMonthly->is_addon  = $id; */
                  $pricesQuaterly->price_type  = 'quarterly'; 
                  $pricesQuaterly->stripe_price_id  = $stripePriceQuaterly['id'];
                  $pricesQuaterly->price  = $request->get('quaterly_price'); 
                  $pricesQuaterly->currency  = 'USD';
                  $pricesQuaterly->save(); 
                    
                }if($request->get('half_yealry_price')>0){
                  $plansHalfyearly = SubscriptionPlans::find($plan_id);
                  $pricesHalfyearly = new SubscriptionPrices();
                  /** stripe price**/
                  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                  $stripePriceHalfyearly = \Stripe\Price::create([
                    'product'  => $plansHalfyearly->stripe_prod_id,
                    'unit_amount' => $request->get('half_yealry_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'month',
                    ],
                  ]);
                  $pricesHalfyearly->plan_id  = $plan_id;
                  /*$pricesMonthly->is_addon    = $id;*/ 
                  $pricesHalfyearly->price_type  = 'halfyearly'; 
                  $pricesHalfyearly->stripe_price_id  = $stripePriceHalfyearly['id'];
                  $pricesHalfyearly->price  = $request->get('half_yealry_price'); 
                  $pricesHalfyearly->currency  = 'USD';
                  $pricesHalfyearly->save(); 
                    
                }if($request->get('yearly_price')>0){
                  $plansYearly = SubscriptionPlans::find($plan_id);
                  $pricesYearly = new SubscriptionPrices();
                  /** stripe price**/
                 \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                  $stripePriceYearly = \Stripe\Price::create([
                    'product'  => $plansYearly->stripe_prod_id,
                    'unit_amount' => $request->get('yearly_price')*100,
                    'currency' => 'USD',
                    'recurring' => [
                      'interval' => 'year',
                    ],
                  ]);
                  $pricesYearly->plan_id      = $plan_id;
                  /*$pricesMonthly->is_addon    = $id;*/
                  $pricesYearly->price_type   = 'yearly'; 
                  $pricesYearly->stripe_price_id  = $stripePriceYearly['id'];
                  $pricesYearly->price        = $request->get('yearly_price'); 
                  $pricesYearly->currency     = 'USD';
                  $pricesYearly->save(); 
                    
                }
            }
    		return Redirect('plans')->with('success','Addon Plan has been created successfully!');
    	}
    	return view('admin.plans.addonPlans',compact('id'));
    }
    public function edit(Request $request,$id){

        if(SubscriptionPlans::find($id)){
          $plan = SubscriptionPlans::find($id);
          $price =SubscriptionPrices::where('plan_id',$id)->first();
        }
        $team = SubscriptionTeams::where('plan_id',$id)->first(); 
        
        if($request->isMethod('post')){

            $plan                       = SubscriptionPlans::find($id);
            $plan->plan_name            = $request->get('name');
            $plan->parent_id            = 1;
            $plan->plan_description     = $request->get('description');
            $plan->is_active            = $request->get('is_active');
           
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

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $product = $stripe->products->update($plan->stripe_prod_id,
            ['name' => $request->get('name')]
            );

            $plan->stripe_prod_id =$product['id'];

            $plan->save();

            $plan_id = $plan->id;

            $plans = SubscriptionPlans::find($plan_id);

              if($request->get('monthly_price')>0){

                $pricesMonthly = SubscriptionPrices::find($request->get('price_id'));
                 /** stripe price**/
                /*\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $stripePrice = \Stripe\Price::update([
                  'product'     => $plans->stripe_prod_id,
                  'unit_amount' => $request->get('monthly_price')*100,
                  'currency'    => 'USD',
                  'recurring'   => [
                    'interval'  => 'month',
                  ],
                ]);*/
                $pricesMonthly->plan_id  = $plan_id; 
                $pricesMonthly->price_type  = 'monthly'; 
                /*$pricesMonthly->stripe_price_id  = $stripePrice['id']; */
                $pricesMonthly->price  = $request->get('monthly_price'); 
                $pricesMonthly->currency  = 'USD';
                $pricesMonthly->save(); 
                
            }if($request->get('quaterly_price')>0){
                $pricesQuaterly = SubscriptionPrices::find($request->get('price_id'));
                /** stripe price**/
                /*\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $stripePrice = \Stripe\Price::update([
                  'product'     => $plans->stripe_prod_id,
                  'unit_amount' => $request->get('quaterly_price')*100,
                  'currency'    => 'USD',
                  'recurring'   => [
                    'interval'  => 'month',
                  ],
                ]);*/

                $pricesQuaterly->plan_id  = $plan_id; 
                $pricesQuaterly->price_type  = 'quarterly'; 
                /*$pricesQuaterly->stripe_price_id  = $stripePrice['id']; */
                $pricesQuaterly->price  = $request->get('quaterly_price'); 
                $pricesQuaterly->currency  = 'USD';
                $pricesQuaterly->save(); 
                
            }if($request->get('half_yealry_price')>0){

                $pricesHalfyearly = SubscriptionPrices::find($request->get('price_id'));
                /** stripe price**/
                /*\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $stripePrice = \Stripe\Price::update([
                  'product'     => $plans->stripe_prod_id,
                  'unit_amount' => $request->get('half_yealry_price')*100,
                  'currency'    => 'USD',
                  'recurring'   => [
                    'interval'  => 'month',
                  ],
                ]);*/

                $pricesHalfyearly->plan_id  = $plan_id; 
                $pricesHalfyearly->price_type  = 'halfyearly'; 
                /*$pricesHalfyearly->stripe_price_id  = $stripePrice['id'];*/ 
                $pricesHalfyearly->price  = $request->get('half_yealry_price'); 
                $pricesHalfyearly->currency  = 'USD';
                $pricesHalfyearly->save(); 
                
            }if($request->get('yearly_price')>0){

                $pricesYearly = SubscriptionPrices::find($request->get('price_id'));
                /** stripe price**/
                /*\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $stripePrice = \Stripe\Price::update([
                  'product'     => $plans->stripe_prod_id,
                  'unit_amount' => $request->get('yearly_price')*100,
                  'currency'    => 'USD',
                  'recurring'   => [
                    'interval'  => 'year',
                  ],
                ]);*/

                $pricesYearly->plan_id          = $plan_id; 
                $pricesYearly->price_type       = 'yearly'; 
                /*$pricesYearly->stripe_price_id  = $stripePrice['id']; */
                $pricesYearly->price            = $request->get('yearly_price'); 
                $pricesYearly->currency         = 'USD';
                $pricesYearly->save(); 
            }
              
            return back()->with('editSuccess','Addon Plan has been updated successfully!');
        }
        return view('admin.plans.editAddon',compact('plan','id','team','price'));
    }
    public function delete(Request $request,$id){
        
      if(SubscriptionPlans::find($id)){
        $plan =SubscriptionPlans::find($id);
        SubscriptionTeams::where('plan_id', '=', $id)->delete();
        SubscriptionPrices::where('plan_id', '=', $id)->delete();
        $plan->delete();
        return back()->with('deleteSuccess','Addon Plan has been deleted successfully!');
      }

    }
}

