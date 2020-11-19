<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\model\Teamdatabase;
class VisualizationController extends Controller
{
    
    public function __construct()
    {
         $page_data = ['menu_selected'=>'visualization_tools','header'=>'list'];    
         $this->page_data=$page_data;
         
        $this->middleware('auth');
    }
    public function dbview(Request $request,$id){ 
      $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        $teams_id=Auth::user()->teams_id;
         if (Auth::check()) {  
         
         if(is_numeric($id)){
             
             $visualization_tools = DB::table('visualization_tools')   
               ->select('visualization_tools.id','visualization_tools.name','visualization_tools.description','visualization_tools.guides','visualization_tools.logo')
               ->where([['visualization_tools.id','=',$id]])
               ->first();
             
             if(!isset($visualization_tools)){
                 return redirect('visualization-tools'); 
             }

             //get all dataware house/targets added by user
             $dataware_houses = DB::table('user_connectors')
                ->join('users','users.id','=','user_connectors.user_id')
                ->join('dataware_houses', 'dataware_houses.id', '=', 'user_connectors.id_connector')    
                ->select('user_connectors.id as user_connectors_id','dataware_houses.id', 'dataware_houses.name','dataware_houses.logo','user_connectors.connection_status')
               ->where([['users.teams_id','=',Auth::user()->teams_id],['user_connectors.connector_type','=','dataware_house'],['user_connectors.connection_status','=',1]])
               ->get();
             
            $teamId = Auth::user()->teams_id;

            $team_database_data = DB::table('team_database')  
 ->leftJoin('teams', function ($join)  {$join->on('teams.id', '=', 'team_database.team_id');}) 
               ->select('teams.team_name','teams.company_name','team_database.id as team_database_id', 'team_database.team_id as team_database_team_id', 'team_database.db_credentials as team_database_db_credentials')
               ->where([['team_database.team_id','=',$teams_id]])
               ->first();
             
               
                return view('admin.visualizationt.dbview',compact('page_data','auth_id','team_database_data','visualization_tools','dataware_houses','teamId'));
         } else {
             echo "Redirect";
         }  
            
         }
         
    }

    public function createMySQLDB($vizId){
      //create the team db, later move this code to data source add
      if(isset(Auth::user()->teams_id) && Auth::user()->teams_id>0){
        file_get_contents($_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/cron_job/createTeamDB.php?teamId=".Auth::user()->teams_id);
        return redirect()->route("visualization.db.view/{id}",$vizId);
      }else{
        return redirect()->route("logout");
      }
    }


     public function dbcreate(Request $request,$id){ 
        $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        $teams_id=Auth::user()->teams_id;
         if (Auth::check()) {  
            if(is_numeric($teams_id)){
                $team_database_data = DB::table('teams')                              
                ->leftJoin('team_database', function ($join) use($teams_id)  {$join->on('team_database.team_id', '=', 'teams.id');	})	
              ->select('teams.team_name as team_name','team_database.id as team_database_id', 'team_database.team_id as team_database_team_id', 'team_database.db_credentials as team_database_db_credentials')
               ->where([['teams.id','=',$teams_id]])
               ->first();
               if(is_numeric($team_database_data->team_database_id)){
                  /// send error 
                  return redirect('/visualization-tools'); 
                
               } else {
                $db_name = str_replace( array( '\'', '"',',' , ';', '<', '>', '`' ), '', 'EF`');
                $database_name=  $db_name."_".$teams_id;
                $database_user=$database_name."_root";
                $database_password= substr(str_shuffle(env('RANDOM_GENERATE_CODE')), 0, env('RANDOM_CODE_LENTH'));
                 
              $data_base=array(
                'database_name'=>$database_name,                        
                'database_user'=>$database_user,
                'database_password'=>$database_password,
              )  ;   
                   $new_db = DB::statement("CREATE DATABASE `$database_name`"); 
                        DB::statement("CREATE USER '$database_user'@'localhost' IDENTIFIED BY '$database_password' ");
                        DB::statement("GRANT ALL PRIVILEGES ON $database_name TO '$database_user'@'localhost'");
                        DB::statement("FLUSH PRIVILEGES");    
                        $team_database =new Teamdatabase;
                        $team_database->team_id = $teams_id;                       
                        $team_database->db_credentials = json_encode($data_base);
                        $team_database->save();
                        return redirect('/visualization-db-view/'.$id); 
                        
               }                
            }
         }
     }
     public function index(Request $request){ 
        $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        $teams_id=Auth::user()->teams_id;
         if (Auth::check()) {  
         
         
         /* 
         $new_db = DB::statement('CREATE DATABASE `aqeel1`'); visualization_tools_id	
        DB::statement("CREATE USER 'aqeel_root1'@'localhost' IDENTIFIED BY 'aqeelroot1' ");
        DB::statement("GRANT ALL PRIVILEGES ON * . * TO 'aqeel_root1'@'localhost'");
        DB::statement("FLUSH PRIVILEGES"); */
         
         
         
            $team_database_data = DB::table('team_database')                                    
               ->select('team_database.id as team_database_id', 'team_database.team_id as team_database_team_id', 'team_database.db_credentials as team_database_db_credentials')
               ->where([['team_database.team_id','=',$teams_id]])
               ->first();
               
            $visualization_tools_data = DB::table('visualization_tools')                                    
               ->select('visualization_tools.id as visualization_tools_id','visualization_tools.name as visualization_tools_name', 'visualization_tools.description as visualization_tools_description', 'visualization_tools.logo as visualization_tools_logo')
               ->where([['visualization_tools.active','=','1']])
               ->get();
               //$visualization_tools_data->team_database_db_credentials;
               //$visualization_tools_data->visualization_tools_logo;
              
                return view('admin.visualizationt.index',compact('page_data','visualization_tools_data','auth_id','team_database_data'));
            
         }
     }
}
