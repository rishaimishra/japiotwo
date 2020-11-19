<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use DB;
use File;
use Illuminate\Support\Facades\Response;
use Session;
class AlertController extends Controller
{
      public function __construct()
    {
         $page_data = ['menu_selected'=>'alert','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }
      public function connectiondataset_v2(Request $request, $id=false){
        $page_data=$this->page_data;
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            /// hit api and get data  user_dataset
             
			  $user_connectors = DB::table('user_connectors')               
			   ->leftJoin('user_dataset', function ($join)  {$join->on('user_dataset.user_connector_id', '=', 'user_connectors.id');})
			   ->leftJoin('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
			   ->select('user_dataset.dataset_description','user_dataset.dataset_name','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id','user_dataset.id as user_dataset_id')
               ->where([['user_connectors.user_id','=',$auth_id],['user_connectors.id_connector','=',$id]])
               ->first();
               $api_responce="";
              ///////////////
              if(isset($user_connectors->user_connectors_id)){
                
                $user_connectors_api_data = DB::table('user_datasource_data')               
			   ->select('user_datasource_data.api_data')
               ->where([['user_datasource_data.user_connectors_id','=',$user_connectors->user_connectors_id]])
               ->first();
               if(isset($user_connectors_api_data->api_data)){
              $api_responce=$user_connectors_api_data->api_data;
               }
              }
              /////////////// 
               
			   if ($user_connectors === null){ 
				   return view('admin.connection.nodatafound',compact('page_data'));
			   } else
			
			   if(isset($user_connectors)&(is_numeric($user_connectors->user_connectors_id))){
			
            if ($request->isMethod('post')) {
				
				
				////////////
				
              
				/////////////
				if(is_numeric($user_connectors->user_dataset_id)){
					$user_dataset = UserDataset::find($user_connectors->user_dataset_id);
				}else {
				$user_dataset = new UserDataset;
				}
				$user_dataset->user_connector_id=$user_connectors->user_connectors_id;
				
               
                foreach($request->post() as $key=>$value){
                    $key;
					if($key=="dataset_name"){
						$user_dataset->dataset_name=$value;
					}
					if($key=="description"){
						$user_dataset->dataset_description=$value;
					}
                    if(($key!="_token")&&($key!="save_dataset")&&($key!="dataset_name")&&($key!="description")){
						if(is_array($value)){
								$abcd[$key]=array_values($value);
						} else{
							   $abcd[$key]=$value;
						}
                    }
                }
				$user_dataset->selected_values=json_encode($abcd,JSON_FORCE_OBJECT);
                
				 $user_dataset->save();
				
				 //test the api 
				 file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$user_dataset->id);
                 
                
                Session::flash('message', 'Dataset has been successfully saved');
				
                    
                 $request->session()->flash('message', 'Dataset has been successfully saved');
                 return redirect("/dataset_v2/$id")->with('message', 'Dataset has been successfully saved');        
               
            }
            //// sample data 
            $data='{"textarea":{"name":"textarea_id","placeholder":"textareaid","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"textarea","value":210469251,"required":1},"text":{"name":"view_id","placeholder":"your id","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"text","value":210469251},"hidden":{"name":"hi_id","placeholder":"hi_id","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"hidden","value":210469251},"views":{"name":"view_id","label":"Select a View","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"select","selected":210469251,"option":[{"value":"210469251","text":"metricoid-210469251-All Web Site Data"}]},"report":{"name":"report_id","label":"Select a Report","description":"","hint":"","type":"select","is_multiple":"1","selected":["ga:sessions^^ga:sessionCount","ga:sessions^^ga:country","ga:sessions^^ga:operatingSystemVersion"],"option":[{"value":"ga:sessions^^ga:sessionCount","text":"Active Users - Returns data for Users, New Users, and Sessions."},{"value":"ga:sessions^^ga:sessionDurationBucket","text":"Behavior - Returns data for New Sessions, New Users, Count of Sessions and Session Duration."},{"value":"ga:sessions^^ga:country","text":"Geo - Returns data for New Sessions, New Users, Pages \/ Session, and Sessions broken down by Country, Region"},{"value":"ga:sessions^^ga:operatingSystem","text":"Mobile - Returns data for New Sessions,active session Mobile Operating System."},{"value":"ga:sessions^^ga:operatingSystemVersion","text":"Technology - Returns data for New Sessions, Operating System."},{"value":"ga:newUsers^^ga:source","text":"Social Networks - Returns data for Avg. Session Duration, Pages \/ Session, Pageviews and Sessions broken down by Date"},{"value":"ga:sessions^^ga:sessionCount","text":"Traffic Metrics - Returns data for New Users, Session Duration, Sessions, Transations, and Users broken down by Country"}]},"duration":{"name":"duration","label":"Select a Duration for the Data","type":"select","is_multiple":1,"selected":"present","option":[{"value":"30daysAgo","text":"Last 30 Days"},{"value":"60daysAgo","text":"Last 60 Days"},{"value":"90daysAgo","text":"Last 90 Days"},{"value":"120daysAgo","text":"Last 120 Days"},{"value":"present","text":"Start to Present"}]}}';
			
			//$data = Http::get('http://authjapio.metricoidtech.com/api/datasetfields/'.$user_connectors->user_connectors_id);
			
		
			$url=env('JAPIO_API_AND_AUTH_APP_URL')."/api/datasetfields/".$user_connectors->user_connectors_id;
            
            
                      
            
            
            
            
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, trim($url));

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



			$output = curl_exec($ch);
			curl_close($ch);
            $data_set=json_decode($output,JSON_OBJECT_AS_ARRAY);
            
            //echo "<pre>";
            //print_r($data_set);exit;
            
            if(isset($data_set['status'])&&($data_set['status']=="0")){
                Session::flash('success',$data_set['message']);
                return redirect("my-connections");
                
            }
//print_r($data_set);
  //         exit;
          //  $data_set=json_decode($data,JSON_OBJECT_AS_ARRAY);
            return view('admin.alert.index_v2',compact('page_data','data_set','user_connectors','id','api_responce'));
			  } else {
            
				return view('admin.connection.nodatafound',compact('page_data','user_connectors'));
			}
        } else {
            
        }
    }

    

    public function index(Request $request){
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            $teams_id=Auth::user()->teams_id;
            $page_data=$this->page_data;

              $logs_data=  DB::table('users') 
                ->leftjoin('user_connectors', 'user_connectors.user_id','=', 'users.id')            
                ->leftJoin('user_datasource_data','user_datasource_data.user_connectors_id','=','user_connectors.id')  
                ->leftjoin('data_sources', 'data_sources.id','=', 'user_connectors.id_connector')  
                
                ->leftjoin('user_dataset', 'user_dataset.user_connector_id','=', 'user_connectors.id')            
                ->join('api_request_history', 'api_request_history.user_dataset_id', '=', 'user_dataset.Id')            
               ->select('user_dataset.Id as user_dataset_id','users.id','users.pro_img','api_request_history.created_at','data_sources.connection_img','data_sources.description','data_sources.name as data_sources_name','api_request_history.id as api_request_history_id','users.id as users_id','users.name', 'users.email', 'user_connectors.id_connector','user_connectors.connector_type',  'user_connectors.connection_status','user_connectors.connection_response','user_connectors.id as user_connectors_id','user_dataset.Id','user_dataset.dataset_name','user_dataset.dataset_description','user_dataset.selected_values','api_request_history.status','api_request_history.error_response','api_request_history.formatted_error_message','user_datasource_data.api_data')->where([['users.teams_id','=',$teams_id],['users.is_active','=','1']])
			   ->orderBy('api_request_history.user_dataset_id', 'DESC')	
		->orderBy('api_request_history.id', 'DESC')			   			   
               ->get();

			   $last_data=array();
             $alldata=$success_data=$failure=$last_run=array();
             foreach($logs_data as $all_data_row){
				 if(is_numeric($all_data_row->api_request_history_id)){
					 
				if(!isset($last_data[$all_data_row->user_dataset_id])){
					 $last_data[$all_data_row->user_dataset_id]=$all_data_row->user_dataset_id;
				 
                 $us_title="Team By";
                 if($all_data_row->users_id==$auth_id){
                     $us_title="Owned By";
                 }
                 
                 $last_run[$all_data_row->users_id][$all_data_row->id_connector][$all_data_row->api_request_history_id]=$all_data_row->created_at;
                 if($all_data_row->status>1){
                     
                     $failure[$all_data_row->dataset_name]=$alldata[$all_data_row->dataset_name]=array(
                        'user_connectors_id'=>$all_data_row->user_connectors_id,
                        'user_dataset_id'=>$all_data_row->user_dataset_id,
                         'api_data'=>$all_data_row->api_data,
                        'user_id'=>$all_data_row->users_id,
                        'id_connector'=>$all_data_row->id_connector,
                        'dataset_name'=>$all_data_row->dataset_name,
                        'data_sources_name'=>$all_data_row->data_sources_name,
                        'connection_img'=>$all_data_row->connection_img,
                        'name'=>$all_data_row->name,
                        'pro_img'=>$all_data_row->pro_img,
						'formatted_error_message'=>$all_data_row->formatted_error_message,
                        'who'=>$us_title,
						'created_date'=>$all_data_row->created_at,
                        
                     );
                     
                 } else {
                     $success_data[$all_data_row->dataset_name]=$alldata[$all_data_row->dataset_name]=array(
                        'user_connectors_id'=>$all_data_row->user_connectors_id,
                        'user_dataset_id'=>$all_data_row->user_dataset_id,
                         'api_data'=>$all_data_row->api_data,
                        'user_id'=>$all_data_row->users_id,
                        'id_connector'=>$all_data_row->id_connector,
                        'dataset_name'=>$all_data_row->dataset_name,
                        'data_sources_name'=>$all_data_row->data_sources_name,
                        'connection_img'=>$all_data_row->connection_img,
                        'pro_img'=>$all_data_row->pro_img,
                        'name'=>$all_data_row->name,
						'formatted_error_message'=>$all_data_row->formatted_error_message,
                        'who'=>$us_title,
						'created_date'=>$all_data_row->created_at,
                        
                     );
                     
                 }
				 
				 
				 
					}
				 
				 
				 }
             }
		
            return view('admin.alert.index',compact('page_data','alldata','success_data','failure','last_run'));
        } else {
            
        }
    }
	 public function index_v2(Request $request){
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            $teams_id=Auth::user()->teams_id;
            $page_data=$this->page_data;
    
      /* 
	  $results = DB::statement(DB::raw('select  `api_request_history`.`user_dataset_id` as `user_dataset_id`,`api_request_history`.`id` as `api_request_history_id`,`users`.`pro_img`, `api_request_history`.`created_at`, `data_sources`.`connection_img`, `data_sources`.`description`, `data_sources`.`name` as `data_sources_name`,  `users`.`id` as `users_id`, `users`.`name`, `users`.`email`, `user_connectors`.`id_connector`, `user_connectors`.`connector_type`, `user_connectors`.`connection_status`, `user_connectors`.`connection_response`, `user_dataset`.`Id`, `user_dataset`.`dataset_name`, `user_dataset`.`dataset_description`, `user_dataset`.`selected_values`, `api_request_history`.`status`, `api_request_history`.`error_response`, `api_request_history`.`formatted_error_message` from `users` left join `user_connectors` on `user_connectors`.`user_id` = `users`.`id` left join `data_sources` on `data_sources`.`id` = `user_connectors`.`id_connector` left join `user_dataset` on `user_dataset`.`user_connector_id` = `user_connectors`.`id` left join `api_request_history` on `api_request_history`.`user_dataset_id` = `user_dataset`.`Id` where (`users`.`teams_id` = 1 and `users`.`is_active` = 1) GROUP BY (`api_request_history`.`user_dataset_id`)')); */
//api_request_history

//$results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = '$someVariable'") );


//	  print_R($results);
	//  exit;
              $logs_data=  DB::table('users') 
                ->leftjoin('user_connectors', 'user_connectors.user_id','=', 'users.id')            
                
                ->leftjoin('data_sources', 'data_sources.id','=', 'user_connectors.id_connector')  
                
                ->leftjoin('user_dataset', 'user_dataset.user_connector_id','=', 'user_connectors.id')            
                ->leftjoin('api_request_history', 'api_request_history.user_dataset_id', '=', 'user_dataset.Id')            
               ->select('api_request_history.user_dataset_id','api_request_history.id as api_request_history_id','users.id','users.pro_img','api_request_history.created_at','data_sources.connection_img','data_sources.description','data_sources.name as data_sources_name','users.id as users_id','users.name', 'users.email', 'user_connectors.id_connector','user_connectors.connector_type',  'user_connectors.connection_status','user_connectors.connection_response','user_dataset.Id','user_dataset.dataset_name','user_dataset.dataset_description','user_dataset.selected_values','api_request_history.status','api_request_history.error_response','api_request_history.formatted_error_message')->where([['users.teams_id','=',$teams_id],['users.is_active','=','1']])
			   ->orderBy('api_request_history.user_dataset_id', 'DESC')	
				->orderBy('api_request_history.id', 'DESC')			   
               ->get();
			   echo "<pre>";
		//	print_r($logs_data);
			      /* api_request_history.user_dataset_id as 
			    ->groupBy('api_request_history.user_dataset_id')
			$logs_data=DB::select("select `api_request_history`.`user_dataset_id`, `users`.`id`, `users`.`pro_img`, `api_request_history`.`created_at`, `data_sources`.`connection_img`, `data_sources`.`description`, `data_sources`.`name` as `data_sources_name`, `api_request_history`.`id` as `api_request_history_id`, `users`.`id` as `users_id`, `users`.`name`, `users`.`email`, `user_connectors`.`id_connector`, `user_connectors`.`connector_type`, `user_connectors`.`connection_status`, `user_connectors`.`connection_response`, `user_dataset`.`Id`, `user_dataset`.`dataset_name`, `user_dataset`.`dataset_description`, `user_dataset`.`selected_values`, `api_request_history`.`status`, `api_request_history`.`error_response`, `api_request_history`.`formatted_error_message` from `users` left join `user_connectors` on `user_connectors`.`user_id` = `users`.`id` left join `data_sources` on `data_sources`.`id` = `user_connectors`.`id_connector` left join `user_dataset` on `user_dataset`.`user_connector_id` = `user_connectors`.`id` left join `api_request_history` on `api_request_history`.`user_dataset_id` = `user_dataset`.`Id` where (`users`.`teams_id` = 1 and `users`.`is_active` = 1) group by `api_request_history`.`user_dataset_id");
			`print_r() */ 
			 //  $logs_data->groupBy('api_request_history_id');
			 
			 
			 
			   $last_data=array();
             $alldata=$success_data=$failure=$last_run=array();
             foreach($logs_data as $all_data_row){
				 if(is_numeric($all_data_row->api_request_history_id)){
				
				if(!isset($last_data[$all_data_row->user_dataset_id])){
					 $last_data[$all_data_row->user_dataset_id]=$all_data_row->user_dataset_id;
					 
					 
					 
					 
					 
				 
				 
                 $us_title="Team By";
                 if($all_data_row->users_id==$auth_id){
                     $us_title="Owned By";
                 }
                 
                 $last_run[$all_data_row->users_id][$all_data_row->id_connector][$all_data_row->api_request_history_id]=$all_data_row->created_at;
                 if($all_data_row->status>1){
                     
                     $failure[]=$alldata[]=array(
                        'user_dataset_id'=>$all_data_row->user_dataset_id,
                        'user_id'=>$all_data_row->users_id,
                        'id_connector'=>$all_data_row->id_connector,
                        'dataset_name'=>$all_data_row->dataset_name,
                        'data_sources_name'=>$all_data_row->data_sources_name,
                        'connection_img'=>$all_data_row->connection_img,
                        'name'=>$all_data_row->name,
                        'pro_img'=>$all_data_row->pro_img,
						'formatted_error_message'=>$all_data_row->formatted_error_message,
                        'who'=>$us_title,
                        'created_at'=>$all_data_row->created_at,
                        
                     );
                     
                 } else {
                     $success_data[]=$alldata[]=array(
                        'user_dataset_id'=>$all_data_row->user_dataset_id,
                        'user_id'=>$all_data_row->users_id,
                        'id_connector'=>$all_data_row->id_connector,
                        'dataset_name'=>$all_data_row->dataset_name,
                        'data_sources_name'=>$all_data_row->data_sources_name,
                        'connection_img'=>$all_data_row->connection_img,
                        'pro_img'=>$all_data_row->pro_img,
                        'name'=>$all_data_row->name,                        
                        'who'=>$us_title,
                        'created_at'=>$all_data_row->created_at,
                        
                     );
                     
                 }
				 
				 
				 
					}
				 
				 
				 
				 
				 
				 }
             }
			 
			 echo "<pre>";
			 print_r($alldata);exit;
            return view('admin.alert.index',compact('page_data','alldata','success_data','failure','last_run'));
        } else {
            
        }
    }
}
