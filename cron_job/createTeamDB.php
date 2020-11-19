<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['teamId']) && $_GET['teamId']>0){
    processDBCreation($_GET['teamId']);
}else{
    die("Invalid Team Id");
}

function processDBCreation($teamId){
    require_once "init.php";

    define("RANDOM_GENERATE_CODE", "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz");
    define("RANDOM_CODE_LENTH", "10");

    
    //get team details
    $sql ="select count(id) from teams where id=".$teamId;

    $result = $appConn->query($sql);

    if($result->num_rows===1){
        //create the database for team
        $database_name = "japio_team_db_".$teamId;//str_replace( array( '\'', '"',',' , ';', '<', '>', '`' ), '', $team_database_row_team_name);
        $database_user=$database_name."_user";
        $database_password= substr(str_shuffle(RANDOM_GENERATE_CODE), 0, RANDOM_CODE_LENTH);
        
        $data_base=array(
            'host'=>$teamDBServer,
            'port'=>$teamPort,
            'database_name'=>$database_name,                        
            'database_user'=>$database_user,
            'database_password'=>$database_password,
        ); 
        $json_data	=json_encode($data_base);
        
        $teamConn = new mysqli($teamDBServer, $teamUser, $teamPass);

        $sql_db = "CREATE DATABASE `$database_name`";
        $res = $teamConn->query($sql_db);
        if($res!==false){
            $sql_user = "CREATE USER '$database_user'@'%' IDENTIFIED BY '$database_password'";
            $res = $teamConn->query($sql_user);
            print_r($res);
            $sql_permission = "GRANT ALL PRIVILEGES ON `$database_name`.* TO '$database_user'@'%' WITH GRANT OPTION";
            $res = $teamConn->query($sql_permission);	
            print_r($res);
            $databaseCreated[] = $data_base;
            
            //check if entry already exists
            $recExist = $appConn->query("SELECT id from team_database where team_id=".$teamId);
			if($recExist->num_rows<1){
				$sql_in = "INSERT INTO `team_database` (`team_id`, `db_credentials`)VALUES ('$teamId', '$json_data')";
				$res = $appConn->query($sql_in);
			}		
            print_r($res);
        }	
        //echo "eeeee";
    }else{
        die("Invalid Team ID");
    }
}


function prdie($arr){
	echo "<pre>";
	print_r($arr);
	die;
}
?>
