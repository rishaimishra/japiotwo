<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\model\UserConnector;
use App\model\UserDataset;
use App\Helpers\CommonHelpers;
use DB;
use Session;
use App\model\User_notifications;
use NotifiFinder;
class ConnectionController extends Controller
{
         public function __construct()
    {
         $page_data = ['menu_selected'=>'connection','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }
    public function call_back_url(Request $request, $id=false){
       /*
       $user_connectors_id = $request->session()->get('user_connectors_id', 'default');
       echo 
       $usercon_update=UserConnector::find($user_connectors_id);
       */
       $usercon_data = array();
        $data_in=$request->all();
        $error = "";
        $call_id="";
        $connectorType = 'data_source';
        if(isset($data_in['error'])){
            $errorDescription = [  
				'access_denied'=>'Access Denied, Data Source was not added' //google, if user declined
			];
			
			if(isset($errorDescription[$data_in['error']])){
				$error = $errorDescription[$data_in['error']];
			}
             $usercon_data['connection_status'] = '0';
        }elseif(isset($data_in['code']) && $data_in['code']!='') {     
            //extract the user_id and datasource_id from the code
            $decoded_code = explode("_",base64_decode($data_in['code']));
            if($decoded_code[0]>0 && isset($decoded_code[1]) && $decoded_code[1]>0 && $decoded_code[0]==Auth::user()->id && isset($decoded_code[2]) && $decoded_code[2]>0){
                $access_token = DB::table('temp_data_connection')->select('oauth2_response','input_credentials')->where(array("secured_code"=>$data_in['code'],'user_id'=>$decoded_code[0],'datasource_id'=>$decoded_code[1],'connector_type'=>$decoded_code[2]))->first();
                if($access_token->oauth2_response!=''){
                    $usercon_data['connection_status'] = '1';
                    $usercon_data['connection_response'] = $access_token->oauth2_response;
                    $usercon_data['token'] = $access_token->oauth2_response;
                    $usercon_data['input_credentials'] = $access_token->input_credentials;
                    //check if record exists, if yes then update otherwise insert
                    if($decoded_code[2]==2){
                        $connectorType = 'dataware_house';
                    }
                    $usercon_details = DB::table('user_connectors')->select('id','id_connector','connector_type')->where(array('user_id'=>$decoded_code[0],'id_connector'=>$decoded_code[1],'connector_type'=>$connectorType))->first();
                    $call_id=$decoded_code[1];
                    
                    if(isset($usercon_details->id_connector)){
                        //update the record
                        DB::table('user_connectors')->where(array('user_id'=>$decoded_code[0],'id_connector'=>$decoded_code[1]))->update($usercon_data);
                    }else{
                        //NotifiFinder::add_notification('7','2','my-connections');
                        //insert a new record
                        $usercon_data["connector_type"] = $connectorType;
                        $usercon_data["user_id"] = $decoded_code[0];
                        $usercon_data["id_connector"] = $decoded_code[1];
                        $user_connector_id = DB::table('user_connectors')->insertGetId($usercon_data);
                    }

                    if($connectorType=='dataware_house'){
                        return redirect()->route("data.ware.houses",$user_connector_id)->with('message', 'Thank You! Your connection is in progress.'); 
                    }
                    
                }
            }else{
                $error = "This operation is not permitted! You may try again.";
                $usercon_data['connection_status'] = 0;
            }
        }else{
			$error = "Authorization code was not returned by the Identity Provider, please try later";
        }
        
        if(empty($error) && isset($user_connector_id) && $user_connector_id>0){
            if($connectorType=="dataware_house"){
                return redirect()->route("data.ware.houses")->with('success', 'Successfully Connected!');  
            }else{
                return redirect()->route("add-dataset",$user_connector_id)->with('message', 'Authentication passed! Next - Add a Dataset to get desired data from your Data Source.');  
            }
            //return redirect()->route('my-connections')->with('message', 'Data Source is added successfully!');        
        }else{
            if($connectorType=="dataware_house"){
                return redirect()->route('data.ware.houses')->with('error', $error); 
            }else{
                return redirect()->route('my-connections')->with('error', $error);    
            }
        }
        
    }
    public function connectiondelete(Request $request, $id=false, $connector_type='data_source'){
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            //dd(['user_connectors.user_id'=>auth()->user()->id,'connector_type'=>$connector_type,'user_connectors.id_connector'=>$id]);
            UserConnector::where(['user_connectors.user_id'=>auth()->user()->id,'connector_type'=>$connector_type,'user_connectors.id_connector'=>$id])->delete();
            if($connector_type=='dataware_house'){
                return redirect()->route('data.ware.houses'); 
            }else{
                return redirect('data-sources'); 
            }
        } else {
            return redirect('login'); 
        }
    }

    public function connectiondataset(Request $request, $id=false){
        $page_data=$this->page_data;
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            /// hit api and get data  user_dataset
            
			  
			  
			 
			 
			  $user_connectors = DB::table('user_connectors')               
			   ->leftJoin('user_dataset', function ($join)  {$join->on('user_dataset.user_connector_id', '=', 'user_connectors.id');})
			   ->leftJoin('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
               ->leftJoin('user_datasource_data','user_datasource_data.user_connectors_id','=','user_connectors.id')  
               ->leftJoin('api_request_history','api_request_history.user_dataset_id','=','user_datasource_data.dataset_id')  
               ->select('api_request_history.created_at as last_run','user_dataset.dataset_description','user_dataset.dataset_name','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id','user_dataset.id as user_dataset_id','user_datasource_data.api_data','user_datasource_data.id as user_datasource_data_id')
               ->where([['user_connectors.user_id','=',$auth_id],['user_connectors.id_connector','=',$id]])
               ->first();
               
			
			   if ($user_connectors === null){ 
				   return view('admin.connection.nodatafound',compact('page_data'));
			   } else
			
			   if(isset($user_connectors)&(is_numeric($user_connectors->user_connectors_id))){
			
            if ($request->isMethod('post')) {
               
               $in_putd= $request->input('japio');
				$in_putdata[0]=$in_putdata[1]="";
				if($in_putd!=""){
					$in_putdata=explode(" ",$in_putd);					
				}
               
				/////////////
				if(is_numeric($user_connectors->user_dataset_id)){
					$user_dataset = UserDataset::find($user_connectors->user_dataset_id);
				}else {
                    $user_dataset = new UserDataset;
				}
				$user_dataset->user_connector_id=$user_connectors->user_connectors_id;
                //dd($request->post());
                foreach($request->post() as $key=>$value){
                    $key;
					if($key=="dataset_name"){
						$user_dataset->dataset_name=$value;
					}
					if($key=="description"){
						$user_dataset->dataset_description=$value;
					}
                    if(($key!="_token")&&($key!="save_dataset")&&($key!="dataset_name")&&($key!="description")&&($key!="japio")){
						if($in_putdata[1]==$key){
							$abcd[$key]=$in_putdata[0];
						} else 
						if(is_array($value)){
                            if($value!=""){
                              // print_r($value);
							$abcd[$key]=array_values($value);
                            }
						} else{
                            if($value!=""){
                              //  echo $value;
							   $abcd[$key]=str_replace("_"," ",$value);
                            }
						}
                    }
                }
                 
               //  echo "<pre>";print_r($abcd);
                // exit; 
				$user_dataset->selected_values=json_encode($abcd,JSON_FORCE_OBJECT);
               
				 $user_dataset->save();             
				 if(isset($user_dataset->Id)&&is_numeric($user_dataset->Id)) {
					 $conn_id=$user_dataset->Id;
				 } else {
					 $conn_id=$user_connectors->user_dataset_id;
				 }
                //echo $user_connectors->user_connectors_id; 
                ///// IF user_dataset id
              //  echo env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$conn_id;
             
             
            // @file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$conn_id);
             $url_dataset=env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$conn_id;
             //dd($url_dataset);
             $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, trim($url_dataset));

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



			$output = curl_exec($ch);
			curl_close($ch);
            
             
				// echo file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$user_connectors->user_connectors_id);
                // IF user_dataset user_connector_id
			//	 @file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$user_connectors->user_connectors_id);
              //echo env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$user_connectors->user_connectors_id;
             //exit;
                return redirect()->route("edit-dataset",["user_connectors_id"=>$user_connectors->user_connectors_id,"dataset_id"=>$conn_id])->with('message', 'Dataset has been successfully saved');  
                 exit;       
               
            }
            //// sample data 
            $data='{"textarea":{"name":"textarea_id","placeholder":"textareaid","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"textarea","value":210469251,"required":1},"text":{"name":"view_id","placeholder":"your id","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"text","value":210469251},"hidden":{"name":"hi_id","placeholder":"hi_id","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"hidden","value":210469251},"views":{"name":"view_id","label":"Select a View","description":"","hint":"A view is mandatory to fetch the Google Analytics Data","type":"select","selected":210469251,"option":[{"value":"210469251","text":"metricoid-210469251-All Web Site Data"}]},"report":{"name":"report_id","label":"Select a Report","description":"","hint":"","type":"select","is_multiple":"1","selected":["ga:sessions^^ga:sessionCount","ga:sessions^^ga:country","ga:sessions^^ga:operatingSystemVersion"],"option":[{"value":"ga:sessions^^ga:sessionCount","text":"Active Users - Returns data for Users, New Users, and Sessions."},{"value":"ga:sessions^^ga:sessionDurationBucket","text":"Behavior - Returns data for New Sessions, New Users, Count of Sessions and Session Duration."},{"value":"ga:sessions^^ga:country","text":"Geo - Returns data for New Sessions, New Users, Pages \/ Session, and Sessions broken down by Country, Region"},{"value":"ga:sessions^^ga:operatingSystem","text":"Mobile - Returns data for New Sessions,active session Mobile Operating System."},{"value":"ga:sessions^^ga:operatingSystemVersion","text":"Technology - Returns data for New Sessions, Operating System."},{"value":"ga:newUsers^^ga:source","text":"Social Networks - Returns data for Avg. Session Duration, Pages \/ Session, Pageviews and Sessions broken down by Date"},{"value":"ga:sessions^^ga:sessionCount","text":"Traffic Metrics - Returns data for New Users, Session Duration, Sessions, Transations, and Users broken down by Country"}]},"duration":{"name":"duration","label":"Select a Duration for the Data","type":"select","is_multiple":1,"selected":"present","option":[{"value":"30daysAgo","text":"Last 30 Days"},{"value":"60daysAgo","text":"Last 60 Days"},{"value":"90daysAgo","text":"Last 90 Days"},{"value":"120daysAgo","text":"Last 120 Days"},{"value":"present","text":"Start to Present"}]}}';
			
			//$data = Http::get('http://authjapio.metricoidtech.com/api/datasetfields/'.$user_connectors->user_connectors_id);
			
		
			$url=env('JAPIO_API_AND_AUTH_APP_URL')."/api/datasetfields/".$user_connectors->user_connectors_id;
        
         // $url= 'http://authjapio.metricoidtech.com/api/datasetfields/85';
           
            
           
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, trim($url));

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



			$output = curl_exec($ch);
			curl_close($ch);
            
            
            
             // $data_set='{"reports":{"name":"report","label":"Select a Report","description":"","hint":"The Report value is used to leverage LinkedIn marketing data to automate internal reporting and gain valuable insights.","type":"select","selected":"Ad Analytics","option":[{"value":"Ad Analytics","text":"Returns Ad Analytics insights on click intelligence numbers."},{"value":"Ad Accounts","text":"Returns the list of Ad Accounts."},{"value":"Ad Campaign Groups","text":"Returns the list of Ad Campaign Groups."},{"value":"Ad Campaigns","text":"Returns the list of Ad Campaigns."},{"value":"Ad Creatives","text":"Returns a list of Creatives within a given Campaign."},{"value":"Ad Budget Pricing","text":"Returns key insights on pricing metrics based on targeting criteria."},{"value":"Ad Conversion Tracking","text":"Returns conversion data associated with selected accounts."},{"value":"Ad Form Question","text":"Returns Ad Forms questions associated with an account."},{"value":"Ad Forms","text":"Returns Ad Forms associated with an account."},{"value":"Ad Targeting Facets","text":"Returns Facets describe the demographic groups of members on the LinkedIn platform."},{"value":"Targeting Options By Ad Targeting Facet","text":"Returns the information about Ad targeting facet."},{"value":"Targeting Options By Similar Entities","text":"Returns similar available options within each type of targeting."},{"value":"Targeting Options By Typeahead","text":"Returns similar options using typeahead capabilities."}],"childelements":{"Targeting Options By Typeahead":[{"name":"account_pankaj","label":"Select an Account pankaj","description":"","hint":"Account lists ad budget pricing. pankaj","type":"select","selected":"Targeting Options By Similar Entities p","option":[{"value":"Targeting Options By Similar Entities p","text":"Returns similar available options within each type of targeting."},{"value":"Targeting Options By Similar Entities","text":"Returns similar available options within each type of targeting."},{"value":"Targeting Options By Similar Entities","text":"Returns similar available options within each type of targeting."},{"value":"Targeting Options By Similar Entities","text":"Returns similar available options within each type of targeting."}]}],"Ad Budget Pricing":[{"name":"account","label":"Select an Account","description":"","hint":"Account lists ad budget pricing.","type":"text","selected":"","option":[]}],"Ad Form Question":[{"name":"form","label":"adForm URN","description":"","placeholder":"4703","hint":"An individual Ad Form Question can be requested by passing in an adForm URN in form urn:li:adForm:4703.","type":"text","selected":""},{"name":"questionId","label":"questionID","description":"","placeholder":"1","hint":"An individual Ad Form Question can be requested by passing in the ID in questionID.","type":"text","selected":""}]}}}'; 
            
         
            
            
            
            $data_set=json_decode($output,JSON_OBJECT_AS_ARRAY);
            
          //  echo "<pre>"; print_r($data_set);exit;
            
            if(isset($data_set['status'])&&($data_set['status']=="0")){
                Session::flash('success',$data_set['message']);
                return redirect("my-connections");
                
            }
			
          //  $data_set=json_decode($data,JSON_OBJECT_AS_ARRAY); data_set
            return view('admin.connection.dataset',compact('page_data','data_set','user_connectors'));
			  } else {
            
				return view('admin.connection.nodatafound',compact('page_data','user_connectors'));
			}
        } else {
            
        }
    }
    
    public function myconnection(Request $request){
        
        $page_data=$this->page_data;
        
        if (Auth::check()) {
            
            $data_sources = DB::table('user_connectors')
                ->join('users','users.id','=','user_connectors.user_id')
                ->join('data_sources', 'data_sources.id', '=', 'user_connectors.id_connector')    
                ->select('user_connectors.id as user_connectors_id','data_sources.id', 'data_sources.name','data_sources.connection_img','user_connectors.connection_status')
               ->where([['users.teams_id','=',Auth::user()->teams_id],['user_connectors.connector_type','=','data_source']])
               ->get();
            
            
          return view('admin.connection.myconnection',compact('page_data','data_sources'));
        
        } else {
              
        }
    } 
    public function connection(Request $request, $id=false, $redirect=true){
        $page_data=$this->page_data;
    
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            if(is_numeric($id)){  
                $data_sources = DB::table('data_sources')
                ->leftJoin('user_connectors', function ($join) use($auth_id)  {				$join->on('user_connectors.id_connector', '=', 'data_sources.id')->where('user_connectors.user_id', '=', $auth_id);				})	
               ->select('data_sources.input_credentials','data_sources.oauth2_url','data_sources.client_credentials','data_sources.api_url','data_sources.description','data_sources.id', 'data_sources.name','data_sources.connection_img','user_connectors.id as user_connectors_id')
               ->where([['data_sources.id','=',$id]])
               ->first();
            }
            $input_data= json_decode($data_sources->input_credentials,JSON_OBJECT_AS_ARRAY);
            foreach($input_data as $input_data_key=>$input_data_value){
                if(isset($input_data_value['name'])){
                    $input_request[$input_data_value['name']]= $request->input($input_data_value['name']);
                }
            }
            
             
        //  UserConnector::where('user_connectors.id_connector', $id)->where('user_connectors.user_id', auth()->user()->id)->delete();
            //dd($data_sources->user_connectors_id);
            if(is_numeric($data_sources->user_connectors_id) &&($data_sources->user_connectors_id!="0") ){
                 $user_connector=UserConnector::find($data_sources->user_connectors_id);
            } else {
                  $user_connector = new UserConnector;
            }


            if(is_numeric($data_sources->user_connectors_id) &&($data_sources->user_connectors_id!="0") ){
                
                 $userconnector_id=$data_sources->user_connectors_id;
            } else {
                  $userconnector_id = $user_connector->id;
            }

        
            if(isset($data_sources->oauth2_url)&&($data_sources->oauth2_url!="")){
               
                $request->session()->put('user_connectors_id', $userconnector_id);
                CommonHelpers::authenticateOAuth2($id,$input_request);
               
                //return redirect($data_sources->oauth2_url);
                
            }else{

                $user_connector->user_id = auth()->user()->id;
                $user_connector->id_connector = $id;
                $user_connector->connector_type = 'data_source';
                $user_connector->connection_status = '0';
                $user_connector->connection_response = '';
                $user_connector->token = 'data_source';
                $user_connector->input_credentials = json_encode($input_request);

                $user_connector->save();

                if($redirect===true){
                    return redirect()->route("add-dataset",["user_connectors_id"=>$user_connector->id])->with('message', 'Data Source is added! Next - Add a Dataset to get desired data from your Data Source.');
                }else{
                    return true;
                }
            }
            
        } else {
             return "You are not authorized to perform this action"; 
        }
    } 
    public function index($id=false){
        $page_data=$this->page_data;
        $name='';
        if (Auth::check()) {
             $auth_id=Auth::user()->id;
             $in_arr=array();
            if(is_numeric($id)){  
                $data_sources = DB::table('data_sources')                                   
                ->leftJoin('user_connectors', function ($join) use($auth_id)  {				$join->on('user_connectors.id_connector', '=', 'data_sources.id')->where('user_connectors.user_id', '=', $auth_id);				})			                
               ->select('data_sources.connection_img','data_sources.oauth2_url','data_sources.input_credentials','data_sources.client_credentials','data_sources.api_url','data_sources.description','data_sources.id', 'data_sources.name','data_sources.connection_img','user_connectors.input_credentials as input_credentials_uc')
               ->where([['data_sources.id','=',$id]])
               ->first();               
                if(isset($data_sources->input_credentials_uc)&&($data_sources->input_credentials_uc)){
                   $input_array=json_decode($data_sources->input_credentials_uc);
                   foreach($input_array as $input_array_key=>$input_array_value){
                       $in_arr[$input_array_key]=$input_array_value;
                   }
               }
               $name=$data_sources->name;               
            } 
            $input_data= json_decode($data_sources->input_credentials,JSON_OBJECT_AS_ARRAY);            
         
            if(is_array($input_data) && count($input_data)>0){ //if user credentials is needed, ask for it
            
                return view('admin.connection.input_data',compact('page_data','input_data','id','in_arr','name')); 
            }elseif($data_sources->oauth2_url){ //if oauth2.0 authentication is needed then do it
                CommonHelpers::authenticateOAuth2($id);
            }
                 
        } else {
         die("Not authorized!");     
        }
    }


    public function reconfig(Request $request, $id){
        $page_data=$this->page_data;
        $name='';
        if (Auth::check()) {
             $auth_id=Auth::user()->id;
             $in_arr=array();
            if(is_numeric($id)){  
                $user_connector = DB::table('user_connectors')                                   
                ->join('data_sources', function ($join) use($auth_id)  {				$join->on('user_connectors.id_connector', '=', 'data_sources.id')->where('user_connectors.user_id', '=', $auth_id);				})			                
               ->select('user_connectors.id as user_connector_id','data_sources.connection_img','data_sources.oauth2_url','data_sources.input_credentials','data_sources.client_credentials','data_sources.api_url','data_sources.description','data_sources.id', 'data_sources.name','data_sources.connection_img','user_connectors.input_credentials as input_credentials_uc')
               ->where([['user_connectors.id','=',$id]])
               ->first();
                
                if ($request->isMethod('post')) {
                    $error =$this->connection($request,$user_connector->id,false,false);
                    if($error===true){
                        return redirect()->route("add-dataset",["user_connectors_id"=>$user_connector->user_connector_id])->with('message', 'Data Source is added! Next - Add a Dataset to get desired data from your Data Source.');
                    }
                }



                if(isset($user_connector->input_credentials_uc)&&($user_connector->input_credentials_uc)){
                   $input_array=json_decode($user_connector->input_credentials_uc);
                   foreach($input_array as $input_array_key=>$input_array_value){
                       $in_arr[$input_array_key]=$input_array_value;
                   }
               }
               $name=$user_connector->name;               
            } 
            $input_data= json_decode($user_connector->input_credentials,JSON_OBJECT_AS_ARRAY);            
         
            if(is_array($input_data) && count($input_data)>0){ //if user credentials is needed, ask for it
                $reconfig = true;
                $user_connector_id = $id;
                $input_credentials_uc = json_decode($user_connector->input_credentials_uc,true);
                return view('admin.connection.input_data',compact('page_data','input_data','id','in_arr','name','reconfig','user_connector_id','input_credentials_uc')); 
            }elseif($user_connector->oauth2_url){ //if oauth2.0 authentication is needed then do it
                CommonHelpers::authenticateOAuth2($id);
            }
                 
        } else {
         die("Not authorized!");     
        }
    }
}
