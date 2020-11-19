<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/quick-clean', function () {
	\Artisan::call('config:cache');
	\Artisan::call('view:clear');
	\Artisan::call('route:clear');
	\Artisan::call('event:clear');
	\Artisan::call('cache:clear');
	\Artisan::call('optimize:clear');
	die("cache cleared");
});

Route::get('/', function () {

if(!empty(@Auth::user())){
	return redirect('/home');
}
	return view('auth/login');
});
Route::get('/login', function () {
    return view('welcome');
});

Route::get('/logout', function () {
	Session::forget('key');
	Session::flush();	
  if(!Session::has('key'))
   {
      return redirect('/');
   }
});

Auth::routes();

Route::get('/home', 'UserSubscriptionController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::any('/register','HomeController@index');
Route::get('/data-sources', 'DatasourcesController@index')->name('datasources');
Route::get('/my-team', 'TeamsController@index')->name('team');
Route::post('/my-team', 'TeamsController@index')->name('team');

Route::get('/my-connections', 'ConnectionController@myconnection')->name('my-connections');
Route::get('/connections-delete/{id}', 'ConnectionController@connectiondelete')->name('connections-delete');

Route::get('/connections/{id}', 'ConnectionController@index')->name('connections');
Route::get('connect/callback', 'ConnectionController@call_back_url')->name('connect/callback');
Route::post('/user-connection/{id}', 'ConnectionController@connection')->name('user_connection');

//Route::post('/team-register', 'TeamRegisterController@register')->name('team-register');
//Route::get('/team-register', 'TeamRegisterController@register')->name('team-register');

Route::post('/team-register/{id}', 'TeamRegisterController@register')->name('team-register/{id}');
Route::get('/team-register/{id}', 'TeamRegisterController@register')->name('team-register/{id}');


Route::get('/manage-teams/create', 'ManageTeamsController@create')->name('manage-teams/create}');
Route::get('/profile-update', 'ProfileController@pro_edit')->name('profile-update');
Route::post('/profile-update', 'ProfileController@pro_edit')->name('profile-update');

Route::get('/profile', 'ProfileController@index')->name('profile');

Route::get('/test', 'TeamRegisterController@pankaj')->name('test');
Route::get('/upgrade-plan', 'PaymentController@index')->name('upgrade-plan');



Route::get('login1/google', 'DashboardController@redirectToProvider');
Route::get('login1/google/callback', 'DashboardController@handleProviderCallback');

Route::post('/charge', 'test\AbcController@index')->name('test');
Route::get('/subcription', 'test\AbcController@subcription')->name('subcription');
Route::get('/success', 'UserSubscriptionController@payment_sus')->name('payment_sus');




Route::get('/payment_success', 'UserSubscriptionController@payment_success')->name('payment_success');
Route::get('/payment_cancel', 'UserSubscriptionController@payment_cancel')->name('payment_cancel');


Route::get('/payment_success_url', 'PaymentController@payment_success')->name('payment_success_url');
Route::get('/payment_cancel_url', 'PaymentController@payment_cancel')->name('payment_cancel_url');

Route::get('/stripe_input', 'WebhooksController@stripe_input')->name('stripe_input');
Route::post('/stripe_input', 'WebhooksController@stripe_input')->name('stripe_input');

Route::get('/s_update', 'UserSubscriptionController@update_sess')->name('s_update');
Route::get('/user-activate_delete/{id}/{is_active}/{u_id}', 'TeamsController@userdelete')->name('user-activate_delete');