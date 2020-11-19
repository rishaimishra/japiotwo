<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestAmazonSes;
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

Route::get('testemail', function () {
	Mail::to('amarjit@metricoidtech.com')->send(new TestAmazonSes('It works!'));
});

Route::get('html1-design', function () {
	return view('html1');	
	})->name('htmldesign1');
	
	Route::get('html2-design', function () {
	return view('html2');	
	})->name('htmldesign2');
	
	Route::get('html3-design', function () {
	return view('html3');	
	})->name('htmldesign3');

	
	
	Route::get('/count-filter','metric\MetricDataController@SameColumnCount')->name('metricdata.colcount');
	
	

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
	if(!Session::has('key')){
	    return redirect('/');
	}
});
Route::match(['get','post'],'/team-register/{id}', 'TeamRegisterController@register')->name('team-register/{id}');
Route::get('/notification','Notification@index')->name("notification");
Auth::routes();

Route::group(['middleware' => ['administratorAuthentication']], function () {
	
	Route::get('/home', 'UserSubscriptionController@index')->name('home');

    Route::match(['get','post'],'/team-list', 'ManageTeamsController@show')->name('team-list');

	Route::match(['get','post'],'/profile-update', 'ProfileController@pro_edit')->name('profile-update');

	Route::match(['get','post'],'/team-members/{id}', 'ManageTeamsController@members')->name('team-members');

	Route::match(['get','post'],'/team-add', 'ManageTeamsController@teamadd')->name('team-add');

	Route::match(['get','post'],'/team-edit/{id}', 'ManageTeamsController@teamedit')->name('team-edit');
	Route::match(['get','post'],'/change-team-status', 'ManageTeamsController@changeTeamStatus')->name('change-team-status');
	Route::match(['get','post'],'/plans', 'Plans\AdminPlanController@index')->name('plans');

	Route::match(['get','post'],'/plan-add', 'Plans\AdminPlanController@store')->name('store');

	Route::match(['get','post'],'/plan-edit/{id}', 'Plans\AdminPlanController@edit')->name('edit');

	Route::match(['get','post'],'/plan-delete/{id}', 'Plans\AdminPlanController@delete')->name('delete');
	//Addon plan
	Route::match(['get','post'],'/addon-store/{id}', 'Plans\AddonPlanController@store')->name('addon-store');
	Route::match(['get','post'],'/addons/{id}', 'Plans\AddonPlanController@index')->name('addons');
	
	Route::match(['get','post'],'/addon-edit/{id}', 'Plans\AddonPlanController@edit')->name('addon-edit');
	Route::match(['get','post'],'/addon-delete/{id}', 'Plans\AddonPlanController@delete')->name('addon-delete');

});

/**** comman controller ***/

Route::get('/change_notification_status', 'Notification@change_notification_status')->name('change_notification_status');
//Route::get('/upgrade-plan', 'PaymentController@index')->name('upgrade-plan');
/**** comman controller ***/
Route::match(['get','post'],'/stripe_input', 'WebhooksController@stripe_input')->name('stripe_input');
	

Route::group(['middleware'=>['teamAuthentication']],function(){

	Route::get('/upgrade-plan', 'Plans\FrontendPlanController@index')->name('upgrade-plan');

	Route::get('/home', 'UserSubscriptionController@index')->name('home');
	
	Route::match(['get','post'],'/dashboard', 'DashboardController@index')->name('dashboard');

	Route::match(['get','post'],'/my-team', 'TeamsController@index')->name('team');

	Route::get('/my-connections', 'ConnectionController@myconnection')->name('my-connections');

	Route::get('/connections-delete/{id}/{connector_type?}', 'ConnectionController@connectiondelete')->name('connections-delete');

	Route::any('/register','HomeController@index');

	Route::get('/connections/{id}', 'ConnectionController@index')->name('connections');

	Route::match(['get','post'],'/connections/{connector_id}/reconfig', 'ConnectionController@reconfig')->name('reconfig-connection');

	Route::get('connect/callback', 'ConnectionController@call_back_url')->name('connect/callback');

	Route::post('/user-connection/{id}', 'ConnectionController@connection')->name('user_connection');

	//Route::post('/team-register', 'TeamRegisterController@register')->name('team-register');
	//Route::get('/team-register', 'TeamRegisterController@register')->name('team-register');


	Route::get('/manage-teams/create', 'ManageTeamsController@create')->name('manage-teams/create}');

	Route::match(['get','post'],'/profile-update', 'ProfileController@pro_edit')->name('profile-update');
	Route::get('/data-sources', 'DatasourcesController@index')->name('datasources');
	Route::get('/profile', 'ProfileController@index')->name('profile');

	Route::get('/test', 'TeamRegisterController@pankaj')->name('test');

	Route::get('login1/google', 'DashboardController@redirectToProvider');

	Route::get('login1/google/callback', 'DashboardController@handleProviderCallback');

	Route::post('/charge', 'test\AbcController@index')->name('test');

	Route::get('/subcription', 'test\AbcController@subcription')->name('subcription');

	Route::get('/success', 'UserSubscriptionController@payment_sus')->name('payment_sus');

	Route::get('/payment_success', 'UserSubscriptionController@payment_success')->name('payment_success');

	Route::get('/payment_cancel', 'UserSubscriptionController@payment_cancel')->name('payment_cancel');

	Route::get('/payment_success_url', 'PaymentController@payment_success')->name('payment_success_url');

	Route::get('/payment_cancel_url', 'PaymentController@payment_cancel')->name('payment_cancel_url');

	Route::get('/s_update', 'UserSubscriptionController@update_sess')->name('s_update');

	Route::get('/user-activate_delete/{id}/{is_active}/{u_id}/{re}', 'TeamsController@userdelete')->name('user-activate_delete');

	Route::get('/user-activate-delete-re/{id}/{is_active}/{u_id}/{re}', 'ManageTeamsController@userdeleter')->name('user-activate-delete-re');

	Route::match(['get'],'/dataset/{user_connectors_id}/list', 'DatasetController@list')->name('list-datasets');
	Route::match(['get','post'],'/dataset/{user_connectors_id}/add', 'DatasetController@add')->name('add-dataset');
	Route::match(['get','post'],'/dataset/{user_connectors_id}/edit/{dataset_id}', 'DatasetController@edit')->name('edit-dataset');
	Route::get('/dataset/{user_connectors_id}/refresh/{dataset_id}', 'DatasetController@refresh')->name('refresh-dataset');



	Route::get('/alert', 'AlertController@index')->name('alert');
	Route::get('download/{dataset_id}', 'DatasetController@downloadJson')->name('download-json');

	Route::match(['get'],'/download-csv/{dataset_id}', 'DatasetController@downloadCsv')->name("download-csv-data");

	Route::get('/data-ware-houses', 'DatawareHousesController@index')->name('data.ware.houses');

	Route::get('/dataware-house-feeds/{dataware_house_id}', 'DatawareHousesController@showPushHistory')->name('dataware.house.feeds');

	Route::get('/target/{user_connector_id}/status', 'DatawareHousesController@target_status')->name('target-status');
	

	Route::match(['get','post'],'/dataware-houses-connect/{id}', 'DatawareHousesController@connect')->name('dataware.add');

	Route::get('/visualization-tools', 'VisualizationController@index')->name('visualization.tools');

	Route::get('/database-create', 'Visualizationt@dbcreate')->name('db.create');

	Route::get('/database-create/{id}', 'Visualizationt@dbcreate')->name('db.add/{id}');

	Route::get('/visualization-db-view', 'VisualizationController@dbview')->name('visualization.db.view');
	Route::get('/visualization-db-view/{id}', 'VisualizationController@dbview')->name('visualization.db.view/{id}');


	Route::match(['get','post'],'/dataset_v2/{id}', 'AlertController@connectiondataset_v2')->name('dataset_v2/{id}');


	Route::match(['get','post'],'/frontend-plans', 'Plans\FrontendPlanController@plans')->name('frontend.plans');

	Route::get('/createMySQLDB/{viz_id}','VisualizationController@createMySQLDB')->name("createMySqlDB");

	Route::get('/testStripeSession','PaymentController@testStripeSession')->name("testStripeSession");

	Route::get('/testDataFormat/{dataset_id}','DataFormatController@testDataFormat')->name("testDataFormat");


	// Metric Routes
	Route::get('/metricbuilder/{id}','metric\MetricDataController@list')->name('metricdata');

	Route::get('/filteredata','metric\MetricDataController@filterData')->name('metricdata.filter');
	
	Route::get('/groupby/data/{param}','metric\MetricDataController@GroupByData')->name('metricdata.filter.groupby');
	
	Route::get('/arithmetic','metric\MetricDataController@arithmetic')->name('metricdata.arithmetic');
	Route::get('/comparison','metric\MetricDataController@comparisonFilter')->name('metricdata.comparator');
	 Route::get('/cordinate-filter','metric\MetricDataController@cordinateFilter')->name('metricdata.cordinate');
	Route::get('/all-data','metric\MetricDataController@AllMetricData')->name('metricdata.all');

});

Route::match(['get','post'],'/select-plans', 'Plans\FrontendPlanController@get_plan')->name('select.plans');
Route::match(['get','post'],'/select-yearly-plans', 'Plans\FrontendPlanController@get_yearly_plan')->name('select.plans');
	

Route::get('/terms-and-conditions', 'ContentsController@termsconditions')->name('terms-and-conditions');
Route::get('/membership-agreement', 'ContentsController@membershipagreement')->name('membership-agreement');
Route::get('/data-policies', 'ContentsController@datapolicies')->name('data-policies');
Route::get('/privacy-policies', 'ContentsController@datapolicies')->name('privacy-policies');

	




