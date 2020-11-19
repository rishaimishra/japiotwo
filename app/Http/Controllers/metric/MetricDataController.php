<?php

namespace App\Http\Controllers\metric;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\model\UserConnector;
use App\model\TempDataConnection;
use App\model\UserDataset;
use DB;

use Illuminate\Support\Facades\Response;
use App\Helpers\DataFormatterHelpers;
use App\Helpers\TransformDataHelper;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;

class MetricDataController extends Controller
{

    // public function __construct()
    // {
    //     $page_data = ['menu_selected' => 'connection', 'header' => 'list'];
    //     $this->page_data = $page_data;
    //     $this->middleware('auth');
    // }

    public function list($dataset_id)
    {
        if (Auth::check()) {
            $json_data = file_get_contents(storage_path('app/public/csvjson.json'));
            $array_values = json_decode($json_data, true);

            $auth_id = Auth::user()->id;

            $tablename = "temp_metricbuilder_" . $auth_id . "_" . $dataset_id;
            if (DB::getSchemaBuilder()->hasTable($tablename)) {

                return view('admin.metric.allmetricdata');
            } else {


                $createTableStatement = "CREATE TABLE $tablename";
                $createTableStatement .= '(';
                $createTableStatement .= '`temp_metricbuilder_id` INT NOT NULL AUTO_INCREMENT,';

                foreach ($array_values[0] as $dataKey => $dataValues) {
                    $getDataType = gettype($dataValues);


                    if ($getDataType == 'integer') {
                        $createTableStatement .= '`' . $dataKey . '` int(11) DEFAULT NULL, ';
                    } elseif ($getDataType == 'double') {
                        $createTableStatement .= '`' . $dataKey . '` float DEFAULT NULL, ';
                    } elseif ($getDataType == 'boolean') {
                        $createTableStatement .= '`' . $dataKey . '` tinyint(2) DEFAULT NULL, ';
                    } elseif ($getDataType == 'string') {

                        if ($this->validateDate($dataValues)) {

                            $createTableStatement .= '`' . $dataKey . '` DATE, ';
                        }
                        // if ($getDataType === $format) {
                        //     dd($getDataType);
                        //    // $d = DateTime::createFromFormat($format, $getDataType);
                        //     // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
                        //     //return $d && $d->format($format) === $getDataType;
                        //     $createTableStatement .= '`' . $dataKey . '` DATE DEFAULT NULL, ';
                        // } else
                        //     $createTableStatement .= '`' . $dataKey . '` varchar(255) DEFAULT NULL, ';
                        // if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$getDataType)) {
                        //     $createTableStatement .= '`' . $dataKey . '` DATE, ';
                        // }
                        else
                            $createTableStatement .= '`' . $dataKey . '` varchar(255) DEFAULT NULL, ';
                    }
                }



                $createTableStatement .= 'PRIMARY KEY (`temp_metricbuilder_id`)';
                $createTableStatement .= ')';

                $createTableStatement .= "COLLATE='latin1_swedish_ci' ENGINE=InnoDB";
                //dd($createTableStatement);



                DB::statement($createTableStatement);


                $div = 500;

                for ($i = 0; $i < intdiv(count($array_values), $div); $i++) {

                    $new_arr = [];

                    for ($j = ($i * $div); $j < (($i + 1) * $div); $j++) {
                        $new_arr[] = $array_values[$j];
                    }

                    DB::transaction(function () use ($new_arr, $tablename) {

                        DB::table($tablename)->insert($new_arr);
                    });
                }


                return view('admin.metric.allmetricdata');
            }



            // $formattedData = DataFormatterHelpers::format($dataset_id);
            // $dataToDownload = '';
            // if(is_array($formattedData) && count($formattedData)>0){
            //     $dataToDownload = json_encode($formattedData);
            // }else{
            //     $user_id     = Auth::user()->id;
            //     //check if user is authorized to download the json data

            //     $data = DB::table('user_datasource_data')->join('user_connectors','user_connectors.id','=','user_datasource_data.user_connectors_id')->join('users','users.id','=','user_connectors.user_id')->where(['users.teams_id'=>Auth::user()->teams_id,'user_datasource_data.id'=>$dataset_id])->select('api_data')->get()->last();
            //     if(isset($data->api_data) && $data->api_data!=''){
            //         $dataToDownload = $data->api_data;

            //     }
            // }

            // if($dataToDownload!=''){

            //     echo $dataToDownload;
            // }else{
            //     echo 'Invalid Dataset, You can close this window!';
            // }
            // exit;


            // return view('datasets.list',compact('page_data','datasets'));
            return view('admin.metric.allmetricdata');
        }
    }


   

    public function GroupByData($param)
    {
        // $users = User::orderBy('name', 'desc')
        // ->groupBy('count')
        // ->having('count', '>', 100)
        // ->get();

        $users = DB::table('temp_data_metricbuilder')
            ->orderBy($param)
            ->get();




        dd($users);
    }

    public function arithmetic(Request $r)
    {

        if (Auth::check()) {
            $auth_id = Auth::user()->id;
            $operator = $r->operation;
            $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;

            $data = DB::table($tablename)
                ->get()
                ->$operator($r->cname);

            return response()->json($data, 201);
        } else
            dd('Please login first');
    }

    public function comparisonFilter(Request $r)
    {
        if (Auth::check()) {
            $auth_id = Auth::user()->id;
            $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;

            $data = DB::table($tablename)
                ->where($r->cname, $r->comparator, $r->value)
                ->get();


            return response()->json($data, 201);
        } else
            dd('Please login first');
    }

    public function cordinateFilter(Request $r)
    {
        if (Auth::check()) {
            // $formattedData = TransformDataHelper::filter($r);
           
            if ($r->cname=="Close Date" || $r->cname=="Created Date") {

                $operator = $r->operation;
                 $auth_id = Auth::user()->id;
                 $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;

                $users = DB::select("select  $r->time(`$r->cname`) as c_date , ". $operator ."(`$r->column`) as id FROM ". $tablename ." GROUP BY $r->time(`$r->cname`)");
                   
               return response()->json($users, 201);

                    
               
            }else{
              
                $operator = $r->operation;
                 $auth_id = Auth::user()->id;
                 $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;

                $users = DB::select("select ". $operator ."(`$r->column`) as id, `$r->cname` FROM ". $tablename ." GROUP BY `$r->cname`");
                   
               return response()->json($users, 201);
               
            }

         } else
             dd('Please login first');
    }
    public function filterData(Request $r)
    {
        dd($r);

        if (Auth::check()) {
            $auth_id = Auth::user()->id;
            $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;
            $compare_date = \Carbon\Carbon::today()->subDays($r->value);
            // dd($date);

            $data = DB::table($tablename)
                ->where($r->col_name, '>=', $compare_date)
                ->get();

            return response()->json($query, 201);
        } else
            dd('Please login first');
    }
    
    
    public function SameColumnCount(Request $r)
    {
        //if (Auth::check()) {
            // $formattedData = TransformDataHelper::filter($r);
           
              //$auth_id = Auth::user()->id;
              $tablename = "temp_metricbuilder_13_" . $r->dataset_id;
             
             $users = DB::select("select `$r->cname`,count(*) as count FROM ". $tablename ." GROUP BY `$r->cname`");
                
            return response()->json($users, 201);
        // } else
        //     dd('Please login first');
    }

    public function AllMetricData(Request $r)
    {
        if (Auth::check()) {
            $operator = $r->operation;
            $auth_id = Auth::user()->id;
            $tablename = "temp_metricbuilder_" . $auth_id . "_" . $r->dataset_id;

            $data = DB::table($tablename)
                ->get();

            return response()->json($data, 201);
        } else
            dd('Please login first');
    }

    public function validateDate($date, $format = 'Y-m-d')
    {

        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}