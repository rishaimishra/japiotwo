<?php

namespace App\Http\Controllers\test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbcController extends Controller
{
 
 public function subcription(Request $request){
     // Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price' => 'price_1H5AVfCmbO3yrb8QcDf4rXm8',
    'quantity' => 1,
    ]],
  'mode' => 'subscription',
  'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => 'http://localhost:8000/cancel',
]);
echo "<pre>";
print_r($session);
 }
 public function index(Request $request){
     
     // Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form: 
$token = $_POST['stripeToken'];
$charge = \Stripe\Charge::create([
  'amount' => $request->input('price')*100,
  'currency' => 'inr',
  'description' => $request->input('plan_name'),
  'source' => $token,
]);
 // source ->brand, country,exp_month,exp_year,last4
 // receipt_url
echo "<pre>";
print_r($charge);
 }
 
}
