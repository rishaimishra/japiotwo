@extends('admin.layouts.dashboard_v3')
@section('content1')
<script type="text/javascript">
var ajaxurl = {!! json_encode(url('/')) !!}
</script>
<style type="text/css">
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  vertical-align: baseline;
 
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section, main {
  display: block;
}
body {
  line-height: 1;
}
ol, ul {
  list-style: none;
}
blockquote, q {
  quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
  content: '';
  content: none;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
*,
*::after,
*::before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

html {
  font-size: 62.5%;
}

.pricing-container a {
  text-decoration: none;
  text-decoration: none;
  font-size: 13px;
  font-family: inherit;
}

.pricing-container {
  width: 100%;
  max-width: 1170px;
}

.pricing-container.full-width {
    width: 100%;
    max-width: none;
}

.pricing-switcher {
  text-align: center;
}

.pricing-switcher .fieldset {
  display: inline-block;
  position: relative;
  padding: 2px;
  border-radius: 50em;
  border: 2px solid #2d3e50;
}

.pricing-switcher input[type="radio"] {
  position: absolute;
  opacity: 0;
}

.pricing-switcher label {
  position: relative;
  z-index: 1;
  display: inline-block;
  float: left;
  width: 90px;
  height: 40px;
  line-height: 40px;
  cursor: pointer;
  font-size: 1.4rem;
  color: #000000;
}

.pricing-switcher .switch {
  position: absolute;
  top: 2px;
  left: 2px;
  height: 40px;
  width: 90px;
  background-color: #e70f21;
  border-radius: 50em;
  transition: transform 0.5s;
}

.no-js .pricing-switcher {
  display: none;
}

.pricing-list {
  margin: 2em 0 0;
}

.pricing-list > li {
  position: relative;
  margin-bottom: 1em;
}

@media only screen and (min-width: 768px) {
  .pricing-list {
    margin: 3em 0 0;
  }
  .pricing-list:after {
    content: "";
    display: table;
    clear: both;
  }
  .pricing-list > li {
    width: 25%;
    float: left;
    /*padding-left: 5px;
    padding-right: 5px;*/
  }
  .has-margins .pricing-list > li {
    width: 32.3333333333%;
    float: left;
    /*margin-right: 1.5%;*/
  }
  .has-margins .pricing-list > li:last-of-type {
    margin-right: 0;
  }
}

.pricing-wrapper {
  position: relative;
}

.pricing-wrapper > li {
  background-color: #ffffff;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  outline: 1px solid transparent;
}

.pricing-wrapper > li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  width: 50px;
  pointer-events: none;
  background: -webkit-linear-gradient( right , #ffffff, rgba(255, 255, 255, 0));
  background: linear-gradient(to left, #ffffff, rgba(255, 255, 255, 0));
}

.pricing-wrapper > li.is-ended::after {
  display: none;
}

.pricing-wrapper .is-visible {
  position: relative;
  z-index: 5;
}

.pricing-wrapper .is-hidden {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  z-index: 1;
 
}

.pricing-wrapper .is-selected {
  z-index: 3 !important;
}

@media only screen and (min-width: 768px) {
  .pricing-wrapper > li::before {
    content: '';
    position: absolute;
    z-index: 6;
    left: -1px;
    top: 50%;
    bottom: auto;
    height: 50%;
    width: 1px;
    background-color: #b1d6e8;
  }
  .pricing-wrapper > li::after {
    display: none;
  }
  .exclusive .pricing-wrapper > li {
    box-shadow: inset 0 0 0 3px #2d3e50;
  }
  .has-margins .pricing-wrapper > li,
  .has-margins .exclusive .pricing-wrapper > li {
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  }
  :nth-of-type(1) > .pricing-wrapper > li::before {
    display: none;
  }
  .has-margins .pricing-wrapper > li {
    border-radius: 4px 4px 6px 6px;
  }
  .has-margins .pricing-wrapper > li::before {
    display: none;
  }
}

@media only screen and (min-width: 1500px) {
  .full-width .pricing-wrapper > li {
    padding: 2.5em 0;
  }
}

.no-js .pricing-wrapper .is-hidden {
  position: relative;
  -webkit-transform: rotateY(0);
  -moz-transform: rotateY(0);
  -ms-transform: rotateY(0);
  -o-transform: rotateY(0);
  transform: rotateY(0);
  margin-top: 1em;
}

@media only screen and (min-width: 768px) {
  .exclusive .pricing-wrapper > li::before {
    display: none;
  }
  .exclusive + li .pricing-wrapper > li::before {
    display: none;
  }
}

.pricing-header h2 {
  padding: 0.9em 0.9em 0.6em;
    font-weight: 400;
    margin-bottom: 30px;
    margin-top: 10px;
    text-transform: uppercase;
  text-align: center;
}

.pricing-header {
    height: auto;
    padding: 8px 15px;
    pointer-events: auto;
    text-align: center;
    color: #173d50;
    background-color: transparent;
}

.exclusive .pricing-header {
    color: #1bbc9d;
    background-color: transparent;
}

.pricing-header h2 {
    font-size: 2.8rem;
    letter-spacing: 2px;
}

.currency,
.value {
  font-size: 3rem;
  font-weight: 300;
}

.duration {

  font-weight: 700;
  font-size: 1.3rem;
  color: #8dc8e4;
  text-transform: uppercase;
}

.exclusive .duration {
  color: #e70f21;
}

.duration::before {
  
  margin-right: 2px;
}

.value {
    font-size: 1.4rem;
    font-weight: 700;
}

.currency, 
.duration {
    color: #fff;
}

.exclusive .currency,
.exclusive .duration {
    color: #2d3e50;
}

.currency {
    display: inline-block;
    margin-left: 7px;
    vertical-align: top;
    font-size: 2rem;
    font-weight: 700;
}

.duration {
    font-size: 1.4rem;
}

.pricing-body {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

.is-switched .pricing-body {
  overflow: hidden;
}

.pricing-body {
    overflow-x: visible;
}

.pricing-features {
  width: 600px;
}

.pricing-features:after {
  content: "";
  display: table;
  clear: both;
}

.pricing-features li {
  width: 100px;
  float: left;
  padding: 1.6em 1em;
  font-size: 1.5rem;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.pricing-features em {
  display: block;
  margin-bottom: 5px;
  font-weight: 600;
}

.pricing-features {
    width: auto;
}

.pricing-features li {
    float: none;
    width: auto;
    padding: 1em;
}

.exclusive .pricing-features li {
    margin: 0 3px;
}
  
.pricing-features em {
    display: inline-block;
    margin-bottom: 0;
}

.has-margins .exclusive .pricing-features li {
    margin: 0;
}

.pricing-footer {
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  height: 80px;
  width: 100%;
}

.pricing-footer {
    position: relative;
    height: auto;
    padding: 1.8em 0;
    text-align: center;
}

.pricing-footer::after {
    display: none;
}

.has-margins .pricing-footer {
    padding-bottom: 0;
}

.select {
  position: relative;
  z-index: 1;
  display: block;
  height: 100%;
  overflow: hidden;
  text-indent: 100%;
  white-space: nowrap;
  color: transparent;
}

.select {
    position: static;
    display: inline-block;
    height: auto;
    padding: 1.3em 2em;
    color: #1bbc9d;
    border-radius: 8px;
    border: 2px solid #1bbc9d;
    font-size: 1.4rem;
    text-indent: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: all .6s;
    width: 70%;
}

.no-touch .select:hover {
    background-color: #1bbc9d;
    color: #ffffff;
}

.exclusive .select {
    background-color: #1bbc9d;
    color: #ffffff;
}
  
.no-touch .exclusive .select:hover {
    background-color: #24e0ba;
}
  
.secondary-theme .exclusive .select {
    background-color: #1bbc9d;
}
  
.no-touch .secondary-theme .exclusive .select:hover {
    background-color: #112e3c;
}
  
.has-margins .select {
    display: block;
    padding: 1.7em 0;
    border-radius: 0 0 4px 4px;
}
.lastCard12 hr,.lastCard12 h3{
  display: none;
}

.plan-heading{
  font-size: 20px;
}
.customAddonButton{
  width: 100%;
  padding-top: 5px;
  padding-bottom: 5px;
  margin-top: 13px;
}
#checkout-button{
  display: none;
  margin-left: 82px;
}
.panel-title a:after {
    font-family:Fontawesome;
    content:'\f078';
    float:right;
    font-size:10px;
    font-weight:300;
}
.panel-title a.collapsed:after {
    font-family:Fontawesome;
    content:'\f078';
}
.customAddon p{
  /*font-size: 14px;*/
  padding-top: 7px;
}
/*.radioAddAddon{
  font-size: 18px;
}*/
.addonLine {
    background: lightcoral;
}
.headingofAddon{
  text-align: center;
  /*font-size: 20px;*/
}
#loader-div{
  margin-left: 80px;
}
.loading-image{
  display: none; 
  height: 53px;
  width: 50px;
}
.panel-default > .panel-heading {
    color: #333;
    background-color: #ffffff;
    border-color: #e7eaec;
}
.pricing-wrapper {
  margin-left: 7px;
  margin-right: 7px;
}
.CustomPriceAddonWithMonthly{
  display: none;
}
.CustomPriceAddonWithYearly{
  display: none;
}
.customAddonButton{
  color: #ffffff !important;
}
.see-all-feature,.see-all-feature:hover{
  color: #e70f21;
}
.header-pricing-addon{
  display: none;
}
.buyNowText{
  font-size: 17px;
  font-weight: 700; 
}
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Your Current Plan Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                  <?php
                  if(Session::get("plan_validity_days")>0){
                  ?>
                        <div class="alert alert-success">
                          Your current plan is <b><?php echo Session::get("subscribed_plan");?> </b>, expiring in <?php echo Session::get("plan_validity_days");?> days 
                        </div>
                  <?php
                  }else{
                  ?>
                      <div class="alert alert-danger">
                        Your current plan <b><?php echo Session::get("subscribed_plan");?> </b> is already expired, subscribe a new plan 
                      </div>
                  <?php
                  }
                  ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-6 offset-lg-3 text-center pb-3 pt-3">
        <a class="btn btn-primary btn-rounded btn-block" href="https://japio.com/pricing/" target="_blank"><i class="fa fa-info-circle"></i> Click here to check and compare features of all Packages</a>
      </div>
    </div>
    <div class="row">
      <div class="pricing-container">
    <!--
    <div class="pricing-switcher">
      <p class="fieldset">
        <input type="radio" name="duration-1" value="monthly" id="monthly-1" >
        <label for="monthly-1">Monthly</label>
        <input type="radio" name="duration-1" value="yearly" id="yearly-1" checked>
        <label for="yearly-1">Yearly</label>
        <span class="switch"></span>
      </p>
    </div>
    !-->
     
      <ul class="pricing-list bounce-invert">
        <!---monthly start--->
        <?php 
        if(!empty($mainPlansMonthly)){
          $i=1;
          foreach($mainPlansMonthly as $mainPlan){
         
        ?>
       <li>
          <ul class="pricing-wrapper">
            <li data-type="monthly" class="is-hidden">
              <header class="pricing-header">
              
                <div class="price">
                  <span class="currency">$</span>
                  <span class="value MainValueMonthly" id="MainValueMonthly{{$i}}">{{ $mainPlan->price }}</span>
                  <span class="duration">{{ $mainPlan->price_type }}</span>
                </div>

              </header>
              <div class="pricing-body">
                <h3 class="text-center plan-heading product-name">{{ $mainPlan->plan_name}}</h3>
                <ul class="pricing-features lastCard{{ $i }}">
                  <?php if($mainPlan->max_integrator_user=='-1'){
                      $unlimited = 'Unlimited';
                    }else{
                      $unlimited = $mainPlan->max_integrator_user;
                    }
                  ?>
                  <li>Integrator Users: {{ $unlimited }}</li>
                  <li>Business Users: {{ $mainPlan->max_business_users }}</li>
                  <li>Data Sources: {{ $mainPlan->max_data_sources }}</li>
                  
                  <?php 
                  if(!empty($addonPlansMonthly) ){ ?>
                    <hr class="addonLine">
                      <h3 class="headingofAddon product-name">Add-on Plans</h3>
                    <hr class="addonLine">
                    <div class="panel-group customAccordin" id="accordion" role="tablist" aria-multiselectable="true">
                      <?php 
                      foreach($addonPlansMonthly as $addonPlan){

                          if($mainPlan->id == $addonPlan->is_addon){
                       ?>
                      <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="heading{{$i}}">
                          <h4 class="panel-title text-center"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">{{ $addonPlan->plan_name }} : $ {{ $addonPlan->price }}</a> </h4>
                        </div>

                        <div id="collapse{{$i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$i}}">
                            <div class="panel-body">
                              <header class="pricing-header">
                                <div class="price">
                                  <span class="currency">$</span>
                                  <span class="value" id="customisedValueMonthly{{$i}}">{{ $addonPlan->price }}</span>
                                  <span class="duration">{{ $addonPlan->price_type }}</span>
                                </div>
                              </header>
                              <div class="pricing-body text-center customAddon">
                                <?php if($addonPlan->max_integrator_user=='-1'){ ?>
                                <p>Integrator Users: {{ $unlimited }}</p>
                                <?php }elseif($addonPlan->max_integrator_user==0){ }else{ ?>
                                    <p>Integrator Users: {{ $addonPlan->max_integrator_user }}</p>
                                <?php } 

                                if( $addonPlan->max_business_users==0){}else{ ?>

                                <p>Business Users: {{ $addonPlan->max_business_users }}</p>
                                <?php } 

                                if($addonPlan->max_data_sources==0){}else{ ?>
                              
                                  <p>Data Sources: {{ $addonPlan->max_data_sources }}</p>
                                <?php } 
                                
                                if (is_numeric($mainPlan->price) && is_numeric($addonPlan->price)) {
                                  $customPriceAddonWithMonth=($mainPlan->price+$addonPlan->price);
                                }else{
                                  $customPriceAddonWithMonth=0;
                                }
                                ?>
                                <input type="hidden" name="" class="CustomPriceAddonWithMonthly" value="{{ $customPriceAddonWithMonth }}" id="CustomPriceAddonWithMonthly{{$i}}" data-value="{{ $mainPlan->price }}">
                                <p><input type="checkbox" class="MaincustomisedCheckbox{{$i}} selectAddon animated fadeInRightBig" name="customised_plan" data-animation="fadeInUpBig" value="{{ $addonPlan->plan_id }}">
                                <label for="customised" class="radioAddAddon"> Select this plan</label><br></p>
                                
                              </div>

                            </div>
                        </div>
                      </div>
                      <?php  $i++; } } ?>
                    </div>

                  <?php  } ?>
                  <p class="pb-3"><button type="button" data-id="{{ $mainPlan->id }}" class="btn btn-primary customAddonButton selectPlan">Subscribe <i class="fa fa-chevron-circle-right"></i> </button></p>
              </div>
              
            </li>
          </ul>
        </li>
        <?php $i++; } }?>
            <!---- monthly end---->

            <!--- yearly start---->
          <?php 
          $j=1;
          if(!empty($mainPlansYearly)){
          foreach($mainPlansYearly as $YearlyMainPlan){
           ?>
         <li>
          <ul class="pricing-wrapper">
          <li data-type="yearly" class="is-visible">
            <header class="pricing-header">
              
              <div class="price" style="display: none;">
                <span class="currency">$</span>
                <span class="value">{{$YearlyMainPlan->price}}</span>
                <span class="duration">{{$YearlyMainPlan->price_type}}</span>
              </div>
            </header>
            <div class="pricing-body">
              <h3 class="text-center plan-heading product-name">{{ $YearlyMainPlan->plan_name }}</h3>
              <ul class="pricing-features lastCard{{ $j }}">
                <?php if($YearlyMainPlan->max_integrator_user==-1){
                    $unlimited ='Unlimited';
                }else{
                    $unlimited = $YearlyMainPlan->max_integrator_user;
                }?>
                <li>Integrator Users: {{ $unlimited }}</li>
                <li>Business Users: {{ $YearlyMainPlan->max_business_users }}</li>
                <li>Data Sources: {{ $YearlyMainPlan->max_data_sources }}</li>
                <?php 
               
                if(!empty($addonPlansYearly)){ ?>
                  <hr class="addonLine">
                    <h3 class="headingofAddon product-name">Add-on Plans</h3>
                  <hr class="addonLine">
                <?php foreach($addonPlansYearly as $YearlyaddonPlan){ 
                  if($YearlyMainPlan->plan_id == $YearlyaddonPlan->is_addon){
                  ?>

                  <div class="panel-group customAccordin" id="accordion" role="tablist" aria-multiselectable="true">

                      <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="heading{{$j}}">
                          <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$j}}" aria-expanded="true" aria-controls="collapse{{$j}}">{{ $YearlyaddonPlan->plan_name }} : $ {{ $YearlyaddonPlan->price }}</a> </h4>
                        </div>

                        <div id="collapse{{$j}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$j}}">
                            <div class="panel-body">
                              <header class="pricing-header header-pricing-addon">
                                <div class="price">
                                  <span class="currency">$</span>
                                  <span class="value" id="CustomiseValueYear{{$j}}">{{ $YearlyaddonPlan->price }}</span>
                                  <span class="duration">{{ $YearlyaddonPlan->price_type }}</span>
                                </div>
                              </header>
                              <div class="pricing-body text-center customAddon">
                                <?php if($YearlyaddonPlan->max_integrator_user=='-1'){ ?>
                                <p>Integrator Users: {{ $unlimited }}</p>
                                <?php }elseif($YearlyaddonPlan->max_integrator_user==0){ }else{ ?>
                                    <p>Integrator Users: {{ $YearlyaddonPlan->max_integrator_user }}</p>
                                <?php } 

                                if( $YearlyaddonPlan->max_business_users==0){}else{ ?>

                                <p>Business Users: {{ $YearlyaddonPlan->max_business_users }}</p>
                                <?php } 

                                if($YearlyaddonPlan->max_data_sources==0){}else{ ?>
                              
                                  <p>Data Sources: {{ $YearlyaddonPlan->max_data_sources }}</p>
                                <?php }
                                if (is_numeric($YearlyMainPlan->price) && is_numeric($YearlyaddonPlan->price)){
                                $customPriceAddonWithYearly = $YearlyMainPlan->price+$YearlyaddonPlan->price;
                                  }else{
                                    $customPriceAddonWithYearly = 0;
                                  }
                                 ?> 
                                 <input type="hidden" name="" value="{{ $customPriceAddonWithYearly }}" class="CustomPriceAddonWithYearly" id="CustomPriceAddonWithYearly{{$j}}" data-value="{{ $YearlyMainPlan->price }}">
                                <h4 class="animated slideInDown pt-4"><input type="checkbox" class="MaincustomisedCheckboxYear{{$j}} selectAddon" name="customised_plan" value="{{$YearlyaddonPlan->stripe_price_id}}">
                                <label for="customised" class="radioAddAddon"> Select this plan</label><br></h4>
                                
                              </div>

                            </div>
                        </div>
                      </div>
                      
                    </div>
                <?php $j++; } } } ?>
              <p class="pb-3"><a class="btn btn-primary btn-rounded m-t-n-xs customAddonButton selectYearlyPlan" data-id="{{ $YearlyMainPlan->stripe_price_id }}"><span class="buyNowText"></span><span class="price"><span class="value">USD&nbsp;</span><span class="value" id="MainValueYear{{$j}}">{{$YearlyMainPlan->price}}</span><span class="duration">&nbsp;{{$YearlyMainPlan->price_type}}</span></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a></p>
              </ul>
            </div>
          </li>
           </ul>
        </li>
          <?php $j++; } } ?>
          <!----yearly end---->
      </ul>
      <div id="loader-div">
        <img id="loading-image" class="loading-image" src="{{ asset('img/loader.gif') }}"/>
      </div>
  </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
  <script type="text/javascript">

  jQuery(document).ready(function() {
    $('input.selectAddon').on('change', function() {
      $('input.selectAddon').not(this).prop('checked', false);  
    });
    /*** get monthly session id ***/
    jQuery('.selectPlan').click(function(){
      var addonId = jQuery(".selectAddon:checked").val();
      if(addonId !=''){
        var addPlanId = addonId;
      }else{
        var addPlanId = 0;
      }
      $.ajax({
        url: ajaxurl+'/select-plans',
        type: 'POST',
        beforeSend: function() {
            $("#loading-image").show();
        }, 
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data:{
          id: jQuery(this).data('id'),
          addon_id:addPlanId
        },
        success:function(response){

            if (response.success) {
              $("#loading-image").hide();
              var priceId = response.data;
              var stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");
            
              $.ajax({  
                 type:"GET",  
                 url:"s_update",     
                 data:'s_id='+priceId,  
                 complete:function(data){  
            
                 }  
              });

              stripe.redirectToCheckout({
                sessionId: priceId
              }).then(function (result) {
         
            });
          }
        },      
      }); 
      return false;
    });
    /***** yearly get session id*****/

    /*** get session id ***/
    jQuery('.selectYearlyPlan').click(function(){
      var addonId = jQuery(".selectAddon:checked").val();
      if(addonId !=''){
        var addPlanId = addonId;
      }else{
        var addPlanId = 0;
      }
      console.log(addPlanId);
      $.ajax({
        url: ajaxurl+'/select-yearly-plans',
        type: 'POST',
        beforeSend: function() {
            $("#loading-image").show();
        }, 
        headers: {
          'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data:{
          yearly_id: jQuery(this).data('id'),
          yearly_addon_id:addPlanId
        },
        success:function(response){
            if (response.success) {
              $("#loading-image").hide();
              var priceId = response.data;
              var stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");
            
              $.ajax({  
                 type:"GET",  
                 url:"s_update",     
                 data:'s_id='+priceId,  
                 complete:function(data){  
            
                 }  
              });

              stripe.redirectToCheckout({
                sessionId: priceId
              }).then(function (result) {
         
            });
          }
        },      
      }); 
      return false;
    });
  });

   
      
  </script>

@stop 