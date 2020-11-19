<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use DB; 
use Illuminate\Support\Facades\Auth;
class DataFormatterHelpers 
{
	
    static function format($datasetId)
    {
        //temp code
        //return self::formatTwitter(file_get_contents('http://japioapp/public/sample_raw_data/twitter.json'));
        //$rawData = json_decode('{"paging":{"start":0,"count":10,"links":[],"total":0},"elements":[]}',true);
        //return self::recurse_func($rawData);
            
        $datasets = DB::table('user_datasource_data')
                ->join('user_dataset','user_dataset.id','=','user_datasource_data.dataset_id')
                ->join('user_connectors', function ($join)  {$join->on('user_dataset.user_connector_id', '=', 'user_connectors.id');})
                ->join("users","users.id","=","user_connectors.user_id")               
                ->join('data_sources', function ($join)  {$join->on('data_sources.id', '=', 'user_connectors.id_connector');})
                ->select('user_dataset.created_at as dataset_created_on','user_dataset.last_successfull_run as last_run','user_dataset.dataset_description','user_dataset.dataset_name','data_sources.connection_img as connection_img','data_sources.api_url as  data_sources_api_url','data_sources.description as  data_sources_description','data_sources.id as  data_source_id','data_sources.name as  data_sources_name','user_connectors.id as user_connectors_id','user_dataset.id as user_dataset_id','user_datasource_data.api_data','user_datasource_data.id as user_datasource_data_id')
                ->where([['users.teams_id','=',Auth::user()->teams_id],['user_datasource_data.dataset_id','=',$datasetId]])
                ->first();

        if(isset($datasets->data_source_id) && $datasets->data_source_id>0 && $datasets->api_data!=''){
            if($datasets->data_source_id==2){
                return self::formatGoogleAnalytics($datasets->api_data);
            }elseif($datasets->data_source_id==10){
                return self::formatTwitter($datasets->api_data);
            }elseif($datasets->data_source_id==22){
                return self::formatYoutube($datasets->api_data);
            }else{
                $rawData = json_decode($datasets->api_data,true);
                return self::recurse_func($rawData);
            }
        }else{
            return false;
        }
    }

    static function toCSV($formattedData){

    }
    static function formatGoogleAnalytics($rawData){
        $rawData = json_decode($rawData,true);
        $columns = [];
        foreach($rawData[0]['columnHeader']['dimensions'] as $colName){
            $columns[] = "dimension_".$colName;
        }
        foreach($rawData[0]['columnHeader']['metricHeader']['metricHeaderEntries'] as $colDetails){
            $columns[] = "metric_".$colDetails['name'];
        }

        $rows = [];
        if(isset($rawData[0]) && isset($rawData[0]['data']) && isset($rawData[0]['data']['rows'])){
            foreach($rawData[0]['data']['rows'] as $apiRow){
                $tmpArr = [];
                $tmpRows = array_merge($apiRow['dimensions'],$apiRow['metrics'][0]['values']);
                foreach($columns as $key=>$colName){
                    $tmpArr[$colName] = $tmpRows[$key];     
                }
                $rows[] = $tmpArr;
            }
        }else{ //api has returned blank rows
            foreach($columns as $key=>$colName){
                $tmpArr[$colName] = "";     
            }
            $rows[] = $tmpArr;
        }
        return $rows;
    }
    static function formatYoutube($rawData){
        $rawData = json_decode($rawData,true);
        return self::recurse_func($rawData['items']);

    }

    static function formatTwitter($rawData){
        $rawData = json_decode($rawData,true);
        return self::recurse_func($rawData);
    }
    
    static function formatGoogleAdsense($rawData){

    }



    static function recurse_func($arrData){
        $columns = [];
        $rows = [];
        
        foreach($arrData as $item){
            $tmpRow = [];
            foreach($item as $key=>$values){
                if(is_array($values) && count($values)>0){
                    foreach($values as $tmpKey=>$tmpVal){
                        if(is_array($tmpVal)){
                            foreach($tmpVal as $tmpKey1=>$tmpVal1){
                                if(is_array($tmpVal1)){
                                    foreach($tmpVal1 as $tmpKey2=>$tmpVal2){
                                        if(is_array($tmpVal2)){
                                            foreach($tmpVal2 as $tmpKey3=>$tmpVal3){
                                                if(is_array($tmpVal3)){
                                                    foreach($tmpVal3 as $tmpKey4=>$tmpVal4){
                                                        if(is_array($tmpVal4)){
                                                            foreach($tmpVal4 as $tmpKey5=>$tmpVal5){
                                                                if(is_array($tmpVal5)){
                                                                    foreach($tmpVal5 as $tmpKey6=>$tmpVal6){
                                                                        $col = $key."_".$tmpKey."_".$tmpKey1."_".$tmpKey2."_".$tmpKey3."_".$tmpKey4."_".$tmpKey5."_".$tmpKey6;
                                                                        $tmpRow[$col] = $tmpVal6;
                                                                        $allColumns[$col] = $col;
                                                                    }
                                                                }elseif(!is_array($tmpVal5)){
                                                                    $col = $key."_".$tmpKey."_".$tmpKey1."_".$tmpKey2."_".$tmpKey3."_".$tmpKey4."_".$tmpKey5;
                                                                    $tmpRow[$col] = $tmpVal5;
                                                                    $allColumns[$col] = $col;
                                                                }
                                                            }
                                                        }else{
                                                            $col = $key."_".$tmpKey."_".$tmpKey1."_".$tmpKey2."_".$tmpKey3."_".$tmpKey4;
                                                            $tmpRow[$col] = $tmpVal4;
                                                            $allColumns[$col] = $col;
                                                            
                                                        }
                                                    }
                                                }else{
                                                    $col = $key."_".$tmpKey."_".$tmpKey1."_".$tmpKey2."_".$tmpKey3;
                                                    $tmpRow[$col] = $tmpVal3;
                                                    $allColumns[$col] = $col;
                                                }
                                            }
                                        }else{
                                            $col = $key."_".$tmpKey."_".$tmpKey1."_".$tmpKey2;
                                            $tmpRow[$col] = $tmpVal2;
                                            $allColumns[$col] = $col;
                                        }
                                    }
                                }else{
                                    $col = $key."_".$tmpKey."_".$tmpKey1;
                                    $tmpRow[$col] = $tmpVal1;
                                    $allColumns[$col] = $col;
                                }
                            }
                        }else{
                            $col = $key."_".$tmpKey;
                            $tmpRow[$col] = $tmpVal;
                            $allColumns[$col] = $col;
                        }
                        
                    }
                }else{
                    $tmpRow[$key] = $values;
                    $allColumns[$key] = $key;
                }
            }
            $rows[] = $tmpRow;
        }

        //make sure its same no. of keys in each row
        $finalRows = [];
        foreach($rows as $row){
            $tmpRow = [];
            foreach($allColumns as $colName){
                if(isset($row[$colName])){
                    if(is_array($row[$colName]) && count($row[$colName])==0){ //blank array
                        $tmpRow[$colName] = "";
                    }else{
                        $tmpRow[$colName] = $row[$colName];
                    }
                }else{
                    $tmpRow[$colName] =  "";
                }
            }
            $finalRows[] = $tmpRow;
        }
        
        return $finalRows;
    }


    static function recurse($key,$arr,$finalArr=[]){
        
        $has_array = false;
        $tmpRow = [];
        if(is_array($arr) && count($arr)>0){
            $has_array = true;
            foreach($arr as $tmpKey=>$tmpVal){
                if($key!=''){
                    $col = $key."_".$tmpKey;
                }else{
                    $col = $tmpKey;
                }
                if(is_array($tmpVal) && count($tmpVal)>0){
                    $has_array = true;
                    self::recurse($col,$tmpVal,$finalArr);
                }else{
                    $tmpRow[$col] = $tmpVal;
                }
            }
        }else{
            $tmpRow[$key] = $arr;
        }

        if(count($tmpRow)>0){
            $finalArr[] = $tmpRow;
        }

        return $finalArr;

        if(!$has_array){
            return $finalArr;
        }
    }
}
