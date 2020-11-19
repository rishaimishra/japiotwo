@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
<?php 
//if ($request->session()->get('sess_data')!=""){
?>
    @if($err!="")
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
											{{ $err }}
 <?php //echo $request->session()->get('sess_data');?>
                                        </div>
                                    
<?php //} ?>
  @endif
<div class="wrapper wrapper-content animated fadeInRight"  style="padding-bottom: 9px !important;padding-right: 10px !important;">


 <div class="row">    
 <div class="col-lg-12">
 <?php 
 $current_date=date("Y-m-d");
          $valid_date=Auth::user()->valid_date;
             $date1_ts = strtotime($valid_date);
                $date2_ts = strtotime($current_date);
                $diff = $date1_ts - $date2_ts;
                
                 $days=$diff / 86400;      
                 $da="days";
                 if($days=="1"){
                     $da="day";
                 }
                 if($days<'0'){
                ?>
 
 
 
 
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               
                                            </button>
                               <h4>   Your current plan is expired, please subscribe to new one!</h4>   
                                        </div>
                 <?php } else if(Auth::user()->subscription_plans_id!="1") {?>
                                   

 <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          
                                            </button>        
                                  
<h4>You are a premium member!</h4>
                                        </div>
                 <?php }?>
                  </div>
                  </div>
            <div class="row">    

    @foreach($subscription_plans_session as $subscription_plans_data_row)
      <div class="col-lg-3" >
                    <div class="ibox">
                        <div class="ibox-title">
                        <div class="row  m-t-sm">
                                <div class="col-sm-9">
                                     <h5>{{ $subscription_plans_data_row['plan_name'] }}</h5>
                                </div>
                                <div class="col-sm-2" style="color: green;font-style: italic;">
                                 @if($subscription_plans_data_row['id']==Auth::user()->subscription_plans_id)
                                <h5><u><b>Active</b></u></h5>
                              @endif
                                </div>
                            </div>
                        
                        
                           
                        </div>
                        <div class="ibox-content">
                             <h4></h4>
                            <p>
                            {{ $subscription_plans_data_row['plan_description'] }}
                            
							
                            </p>
                            <div>
                                <span></span>
                                <div class="stat-percent"></div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-8">
                                    {{ $subscription_plans_data_row['price'] }} {{ $subscription_plans_data_row['currency'] }} / {{ $subscription_plans_data_row['month_title'] }}
                                </div>
                                <div class="col-sm-4">
								 
                               {{ $subscription_plans_data_row['max_team_size'] }} users
                                </div>
                            </div>
<div class="row  m-t-sm">
                                  @if($subscription_plans_data_row['id']!=Auth::user()->subscription_plans_id)
                                <div class="col-sm-12">
								
                                <button name="checkout_s_id"  id="checkout_s_id" onclick="setprice('{{  $subscription_plans_data_row['checkout_session_id'] }}')" class="btn btn-primary" >Select</button>
                                
                                </div>
                                
                                @endif
                            </div>
                        </div>
                    </div>
                
</div>

  @endforeach
</div>	   
 </div>









<input type="hidden" name="price_id" id="price_id" value="">
<script>
          function setprice(val){
          document.getElementById("hideshow").style.display = "block";
		  document.getElementById("price_id").value= val;
          }
          document.getElementById("hideshow").style.display = "none";

		   
       </script>

<div class="row" id="hideshow">
  <div class="col-lg-8">
 
<script src="https://js.stripe.com/v3/"></script>
<button name="checkout-button" value="checkout-button" id="checkout-button" class="btn btn-primary" >Proceed to Stripe</button>
<script>
 document.getElementById("hideshow").style.display = "none";
 
   var stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");
   var checkoutButton = document.getElementById('checkout-button');

checkoutButton.addEventListener('click', function() {
    
    
    $.ajax({  
         type:"GET",  
         url:"s_update",  
         data:'s_id='+document.getElementById("price_id").value,  
         complete:function(data){  
    
         }  
      });  
  stripe.redirectToCheckout({
    // Make the id field from the Checkout Session creation API response
    // available to this file, so you can provide it as argument here
    // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
    sessionId: document.getElementById("price_id").value
  }).then(function (result) {
    // If `redirectToCheckout` fails due to a browser or network
    // error, display the localized error message to your customer
    // using `result.error.message`.
  });
});
  </script>
 <br>          <br>          <br>          <br>          
            
</div>
</div>



@stop