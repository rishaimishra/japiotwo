<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\model\UserConnector;
use App\model\TempDataConnection;
use App\model\UserDataset;
use DB;
use File;
use Illuminate\Support\Facades\Response;
use App\Helpers\DataFormatterHelpers;
class DatasetController extends Controller
{
    public function __construct()
    {
         $page_data = ['menu_selected'=>'connection','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }

    public function list($user_connectors_id){
        $datasets = DB::table('user_dataset')
                ->join('user_connectors', function ($join)  {$join->on('user_dataset.user_connector_id', '=', 'user_connectors.id');})
                ->join("users","users.id","=","user_connectors.user_id")               
                ->join('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
                ->leftJoin('user_datasource_data','user_datasource_data.dataset_id','=','user_dataset.id')  
                ->select('user_dataset.id as user_dataset_id','user_dataset.created_at as dataset_created_on','user_dataset.last_successfull_run as last_run','user_dataset.run_status as run_status','user_dataset.formatted_error_message as formatted_error_message','user_dataset.dataset_description','user_dataset.dataset_name','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id','user_datasource_data.api_data','user_datasource_data.id as user_datasource_data_id')
                ->where([['users.teams_id','=',Auth::user()->teams_id],['user_dataset.user_connector_id','=',$user_connectors_id]])
                ->get();
                //dd($datasets);
                $page_data=$this->page_data;

        return view('datasets.list',compact('page_data','datasets'));
    }

    public function add(Request $request, $user_connectors_id){
        $user_connectors = DB::table('user_connectors')
                ->join("users","users.id","=","user_connectors.user_id")               
			   ->join('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
               ->select('data_sources.id as data_source_id','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id')
               ->where([['users.teams_id','=',Auth::user()->teams_id],['user_connectors.id','=',$user_connectors_id]])
               ->first();
            if(isset($user_connectors->user_connectors_id)){
                if ($request->isMethod('post')) {
                    $datasetId = $this->SaveDataSet($request,$user_connectors);
                    if($datasetId>0){
                        return redirect()->route("list-datasets",[$user_connectors->user_connectors_id])->with('message', 'Dataset is created, check the more details below');  
                    }
                }
                /* Get the Dataset fields to be shown to user*/
                $dataSetFields = $this->GetDataSetFields($user_connectors->user_connectors_id);
                $data_set=json_decode($dataSetFields,JSON_OBJECT_AS_ARRAY);
                //check if this has error, redirect to reconfigure the account
                $reconfigure = $this->checkForReconfiguration($data_set);
                if($reconfigure!==false){
                   return redirect()->route('reconfig-connection',[$user_connectors->user_connectors_id])->with('error', $reconfigure);   
                }

                return view('datasets.add',compact('page_data','data_set','user_connectors'));
            }else{
                return redirect()->route('datasources')->with('error', 'Invalid Data Source, add the respective data source before creating a dataset');   
            }
    }


    public function edit(Request $request, $user_connectors_id,$dataset_id){
        $user_connectors = DB::table('user_dataset')
                ->join('user_connectors', function ($join)  {$join->on('user_dataset.user_connector_id', '=', 'user_connectors.id');})
                ->join("users","users.id","=","user_connectors.user_id")               
                ->join('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
                ->leftJoin('user_datasource_data','user_datasource_data.dataset_id','=','user_dataset.id')  
                ->select('user_dataset.last_successfull_run as last_run','user_dataset.run_status as run_status','user_dataset.formatted_error_message as formatted_error_message','user_dataset.dataset_description','user_dataset.dataset_name','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id','user_dataset.id as user_dataset_id','user_datasource_data.api_data','user_datasource_data.id as user_datasource_data_id')
               ->where([['user_dataset.id','=',$dataset_id],['users.teams_id','=',Auth::user()->teams_id],['user_connectors.id','=',$user_connectors_id]])
               ->first();
               $page_data=$this->page_data;
            if(isset($user_connectors->user_connectors_id)){
                $datasetId = $this->SaveDataSet($request,$user_connectors);
                if($datasetId>0){
                    return redirect()->route("list-datasets",[$user_connectors->user_connectors_id])->with('message', 'Dataset is updated, check the more details below');  
                }

                /* Get the Dataset fields to be shown to user*/
                $dataSetFields = $this->GetDataSetFields($user_connectors->user_connectors_id,$dataset_id);
                $data_set=json_decode($dataSetFields,JSON_OBJECT_AS_ARRAY);
                if(isset($data_set['status']) && $data_set['status']==0){
                    $data_set = false;
                }
                return view('datasets.add',compact('page_data','data_set','user_connectors'));
            }else{
                return redirect()->route('datasources')->with('error', 'Invalid Data Source, add the respective data source before creating a dataset');   
            }
    }

    public function refresh($user_connectors_id,$dataset_id){
        $this->FetchAPIData($dataset_id);
        return redirect()->route('list-datasets',$user_connectors_id);
    }

    public function SaveDataSet($request,$user_connectors){
        if ($request->isMethod('post')) {
               
            $in_putd= $request->input('japio');
             $in_putdata[0]=$in_putdata[1]="";
             if($in_putd!=""){
                 $in_putdata=explode(" ",$in_putd);					
             }
            
             /////////////
             if(isset($user_connectors->user_dataset_id) && is_numeric($user_connectors->user_dataset_id)){
                 $user_dataset = UserDataset::find($user_connectors->user_dataset_id);
             }else {
                 $user_dataset = new UserDataset;
             }
             $user_dataset->user_connector_id=$user_connectors->user_connectors_id;
             //dd($request->post());
             foreach($request->post() as $key=>$value){
                 $key = str_replace("___"," ",$key); //replace it back as you replaced space with ___ in blade
                 $value = str_replace("___"," ",$value);
                 if($key=="dataset_name"){
                     $user_dataset->dataset_name=$value;
                 }
                 if($key=="description"){
                     $user_dataset->dataset_description=$value;
                 }
                 if(($key!="_token")&&($key!="save_dataset")&&($key!="dataset_name")&&($key!="description")&&($key!="japio")){
                     if($in_putdata[1]==$key){
                         $abcd[$key]=$in_putdata[0];
                     } elseif(is_array($value)){
                        $abcd[$key]=array_values($value);
                     } else{
                        $abcd[$key]=$value;
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
           $this->FetchAPIData($conn_id);
         
         return $conn_id;   
         }
    }


    public function FetchAPIData($dataset_id){
        // @file_get_contents(env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$conn_id);
        $url_dataset=env('JAPIO_API_AND_AUTH_APP_URL')."/fetch-api-data/".$dataset_id;
        //dd($url_dataset);
        $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, trim($url_dataset));

       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



       $output = curl_exec($ch);
       curl_close($ch);
    }


    public function GetDataSetFields($user_connectors_id,$dataset_id=''){
        //temp code
        //return file_get_contents("39.json");
        
        /* Get the Dataset fields to be shown to user*/
        if($dataset_id!='' && $dataset_id>0){
            $url=env('JAPIO_API_AND_AUTH_APP_URL')."/api/datasetfields/".$user_connectors_id."/".$dataset_id;
        }else{
            $url=env('JAPIO_API_AND_AUTH_APP_URL')."/api/datasetfields/".$user_connectors_id;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /*********download json file start*********/

    public function downloadJson($dataset_id){
        $formattedData = DataFormatterHelpers::format($dataset_id);
        $dataToDownload = '';
        if(is_array($formattedData) && count($formattedData)>0){
            $dataToDownload = json_encode($formattedData);
        }else{
            $user_id     = Auth::user()->id;
            //check if user is authorized to download the json data
            
            $data = DB::table('user_datasource_data')->join('user_connectors','user_connectors.id','=','user_datasource_data.user_connectors_id')->join('users','users.id','=','user_connectors.user_id')->where(['users.teams_id'=>Auth::user()->teams_id,'user_datasource_data.id'=>$dataset_id])->select('api_data')->get()->last();
            if(isset($data->api_data) && $data->api_data!=''){
                $dataToDownload = $data->api_data;
                
            }
        }

        if($dataToDownload!=''){
            header('Content-disposition: attachment; filename=jsondata_japio.json');
            header('Content-type: application/json');
            echo $dataToDownload;
        }else{
            echo 'Invalid Dataset, You can close this window!';
        }
        exit;
        
        


    }
    /*********download json file end*********/


    /**********download csv file start*********/
    public function downloadCsv($dataset_id)
    {
        $formattedData = DataFormatterHelpers::format($dataset_id);
        //dd($formattedData);
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=csvdata_japio.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];
        # add headers for each column in the CSV download
        array_unshift($formattedData, array_keys($formattedData[0]));

       $callback = function() use ($formattedData) 
        {
            $file = fopen('php://output', 'w');
            foreach ($formattedData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers); 

    }
    /**********download csv file end***********/

    public function checkForReconfiguration($response){
        if(isset($response['error'])){
            return $response['error'];
        }elseif(isset($data_set['status']) && $data_set['status']==0){
            return "Seems incorrect credentials, double check the given details";
        }else{
            return false;
        }
    }

}
