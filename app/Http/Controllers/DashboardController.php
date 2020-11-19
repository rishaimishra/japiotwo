<?php

namespace App\Http\Controllers;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\User;
use App\Role;

class DashboardController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $page_data = ['menu_selected'=>'home','header'=>'list'];    
        $this->page_data=$page_data;
             
       $this->middleware('auth');
    }




/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        echo "<pre>";
        print_r($user);
        // $user->token;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_data=$this->page_data;
        if (Auth::check()) {
            $teams_id=  Auth::user()->teams_id;
		
			  $user_connectors = DB::table('users')               			   
			   ->join('user_connectors', function ($join)  {$join->on('user_connectors.user_id', '=', 'users.id');})
			   ->select('user_connectors.id as user_connectors_id','users.id as users_id','user_connectors.connection_status as connection_status','user_connectors.connector_type as connector_type')
               ->where([['users.teams_id','=',$teams_id]])
                ->orderBy('connector_type', 'asc')
               ->get();

            if($user_connectors->count()>0){
                $chart['data_source']['failure']=$chart['data_source']['success']=$chart['dataware_house']['failure']=$chart['dataware_house']['success']=$chart['visualisation_tool']['failure']=$chart['visualisation_tool']['success']=array();
            
                foreach($user_connectors as $user_connectors_data){
                    $key_name=$header_name="";
                
                    if($user_connectors_data->connector_type=="data_source"){
                        $key_name="data_source";
                        $header_name="Data Sources";
                    }
                    if($user_connectors_data->connector_type=="dataware_house"){
                        $key_name="dataware_house";
                        $header_name="Data Warehouse";
                    }
                    if($user_connectors_data->connector_type=="visualisation_tool"){
                        $key_name="visualisation_tool";
                    }
                    if($key_name!=""){
                        $sub_key="failure";                    
                        if($user_connectors_data->connection_status=="1"){
                            $sub_key="success";
                        } 
                        $chart[$key_name][$sub_key][]=$user_connectors_data->users_id;           
                        $chart[$key_name]['name']=$header_name;           
                    }              
                }
            
            
                ksort($chart);
            
            
                return view('admin.dashboard.index',compact('page_data','chart'));  
            }else{
                //redirect to the data sources
                return redirect()->route('datasources');
            }
            
        
        } else {
              
        }
    }
}
