<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\model\UserConnector;
use App\Helpers\CommonHelpers;
use Session;
class DatawareHousesController extends Controller
{
    public function __construct()
    {
         $page_data = ['menu_selected'=>'data_ware_houses','header'=>'list'];    
         $this->page_data=$page_data;
         
        $this->middleware('auth');
    }
    public function connect(Request $request, $id=false){
        $user = auth()->user()->role_id;
       
        $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        
        
        if ($request->isMethod('post')) {
				/////////////
            $user_connectors = DB::table('user_connectors')        
               ->select('user_connectors.id as user_connectors_id')
               ->where([['user_connectors.user_id','=',$auth_id],['user_connectors.id_connector','=',$id],['user_connectors.connector_type','=','dataware_house']])
               ->first();
               if(isset($user_connectors)&& is_numeric($user_connectors->user_connectors_id)){
                   	$user_dataset = UserConnector::find($user_connectors->user_connectors_id);
               } else {
                    $user_dataset = new UserConnector;
               }
              
      				$user_dataset->user_id=$auth_id;
      				$user_dataset->id_connector=$id;
      				$user_dataset->connector_type='dataware_house';
      				$user_dataset->connection_status='1';
                foreach($request->post() as $key=>$value){
                    $key;
					
                    if(($key!="_token")&&($key!="dataware_houses")){
                      if(is_array($value)){
                          $abcd[$key]=array_values($value);
                      } else{
                          $abcd[$key]=$value;
                      }
                    }
                }
				$user_dataset->input_credentials=json_encode($abcd,JSON_FORCE_OBJECT);
         $user_dataset->save();   
         
                 // @file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$conn_id);
                $url_dataset=env('JAPIO_API_AND_AUTH_APP_URL')."/data-warehouse/fetch-api-data/".$user_dataset->id;
                //dd($url_dataset);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, trim($url_dataset));

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



                $output = curl_exec($ch);
                curl_close($ch);
              
                return redirect("/dataware-houses-connect/$id")->with('message', 'Details Saved Successfully!');  
                 exit;       
               
            }
        
        
        if (Auth::check()) {
            $datawarehouses = DB::table('dataware_houses')                    
                ->leftJoin('user_connectors', function ($join) use($auth_id)  {$join->on('user_connectors.id_connector', '=', 'dataware_houses.id')->where('user_connectors.user_id', '=', $auth_id)->where('user_connectors.connector_type', '=', 'dataware_house');	})			                
               ->select('dataware_houses.id as dataware_houses_id','dataware_houses.name as dataware_houses_name', 'dataware_houses.description as dataware_houses_description', 'dataware_houses.input_credentials as dataware_houses_input_credentials','dataware_houses.oauth2_url as is_oauth2', 'dataware_houses.logo as dataware_houses_logo','user_connectors.id as user_connectors_id', 'user_connectors.connection_status as user_connectors_connection_status', 'user_connectors.input_credentials as   user_connectors_input_credentials')
               ->where([['dataware_houses.active','=','1'],['dataware_houses.id','=',$id]])
               ->first();
               $in_data=array();
              if(isset($datawarehouses->user_connectors_input_credentials)&&($datawarehouses->user_connectors_input_credentials!="")){ 
                $in_data=json_decode($datawarehouses->user_connectors_input_credentials);
              }

            if($datawarehouses->is_oauth2==true){
              CommonHelpers::authenticateOAuth2($id,$in_data,2);
            }

              
              
          return view('admin.datawarehouses.inputdata',compact('page_data','datawarehouses','auth_id','in_data'));
            
        }
    }
      public function index(){
        $user = auth()->user()->role_id;
       
        $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        
        
        
        
        
        if (Auth::check()) {
            $datawarehouses = DB::table('dataware_houses')                    
                ->leftJoin('user_connectors', function ($join) use($auth_id)  {$join->on('user_connectors.id_connector', '=', 'dataware_houses.id')->where('user_connectors.user_id', '=', $auth_id)->where('user_connectors.connector_type', '=', 'dataware_house');	})			                
               ->select('dataware_houses.id as dataware_houses_id','dataware_houses.name as dataware_houses_name', 'dataware_houses.description as dataware_houses_description', 'dataware_houses.input_credentials as dataware_houses_input_credentials', 'dataware_houses.logo as dataware_houses_logo','user_connectors.id_connector','user_connectors.id as user_connectors_id', 'user_connectors.connection_status as user_connectors_connection_status', 'user_connectors.input_credentials as   user_connectors_input_credentials','user_connectors.token as oauth2_token')
               ->where([['dataware_houses.active','=','1']])
               ->get();
          return view('admin.datawarehouses.index',compact('page_data','datawarehouses','auth_id'));
            
        }
      }

      public function showPushHistory(Request $request,$dataware_house_id){
      if($dataware_house_id){

          $datawareHouseDats = DB::table('push_data_target_history')
              ->leftjoin('user_dataset', 'user_dataset.Id', '=', 'push_data_target_history.user_dataset_id')            
              ->select('user_dataset.dataset_name','push_data_target_history.target_name','push_data_target_history.status','push_data_target_history.error_response','push_data_target_history.formatted_error_message','push_data_target_history.created_at')
              ->where([['push_data_target_history.dataware_house_id','=',$dataware_house_id]])
              ->get();

          $datawareHouse = DB::table('dataware_houses')
                ->select('dataware_houses.name')
                ->where([['dataware_houses.id','=',$dataware_house_id]])
                ->first();
        return view('admin.datawarehouses.datawareHouse',compact('datawareHouseDats','datawareHouse'));
      }
    }

}
