<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("RANDOM_GENERATE_CODE", "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz");
define("RANDOM_CODE_LENTH", "10");

$host = 'localhost';
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "japio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else{
	//echo "yes";
	
}
//echo "ssssssssssss";
$table_create=$in_table=array();
//user_datasource_data1

$sql ="select `user_datasource_data`.dataset_id as `dataset_id`,`users`.`teams_id` as `users_teams_id`, `data_sources`.`name` as `data_sources_name`, `data_sources`.`id` as `data_sources_id`, `users`.`email` as `users_email`, `users`.`id` as `users_id`, `user_datasource_data`.`id` as `duser_datasource_data_id`, `user_datasource_data`.`api_data` as `api_data` from `user_datasource_data` inner join `user_connectors` on `user_connectors`.`id` = `user_datasource_data`.`user_connectors_id` and `user_connectors`.`connector_type` = 'data_source' inner join `users` on `users`.`id` = `user_connectors`.`user_id` inner join `data_sources` on `data_sources`.`id` = `user_connectors`.`id_connector`";

$result = $conn->query($sql);

//echo "<pre>";
if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		$table_n=str_replace(" ","_",$row['data_sources_name']);
		$in_table[$row['users_teams_id']][$table_n][]=array(
			'user_email'=>$row['users_email'],
			'dataset_name'=>$row['data_sources_name'],
			'raw_data'=>$row['api_data'],
			'dataset_id'=>$row['dataset_id'],
			'datasource_id'=>$row['data_sources_id']
		);
	
	}
} 


/*
$sq2 = "select `users`.`teams_id` as `users_teams_id`, `dataware_houses`.`name` as `dataware_houses_name`, `users`.`email` as `users_email`, `users`.`id` as `users_id`, `user_datasource_data`.`id` as `duser_datasource_data_id`, `user_datasource_data`.`api_data` as `api_data` from `user_datasource_data` inner join `user_connectors` on `user_connectors`.`id` = `user_datasource_data`.`user_connectors_id` and `user_connectors`.`connector_type` = 'dataware_house' inner join `users` on `users`.`id` = `user_connectors`.`user_id` inner join `dataware_houses` on `dataware_houses`.`id` = `user_connectors`.`id_connector`";


$result1 = $conn->query($sq2);

if ($result1->num_rows > 0) {
  // output data of each row
	  while($row1 = $result1->fetch_assoc()) {
		  
		$table_n=str_replace(" ","_",$row1['dataware_houses_name'])."_raw_data";
	   $in_table[$row1['users_teams_id']][$table_n][]=array(
		'user_email'=>$row1['users_email'],
		'dataset_name'=>$row1['dataware_houses_name'],
		'raw_data'=>$row1['api_data']
		
	   );
		
	  }
	}


*/	
	//echo "<pre>";
	//print_r($in_table);
$sq3 = "select `data_sources`.`id` as `data_sources_id`, `data_sources`.`name` as `data_sources_name` from `data_sources` where (`data_sources`.`active` = 1)";
	 
$result2 = $conn->query($sq3);	
if ($result2->num_rows > 0) {
	while($data_sources_row = $result2->fetch_assoc()) {	
		$table_create[]=str_replace(" ","_",$data_sources_row['data_sources_name'])."_raw_data";		
	}
}
	
	
	
/*
$sq4 = "select `dataware_houses`.`id` as `visualization_tools_id`, `dataware_houses`.`name` as `dataware_houses_name` from `dataware_houses` where (`dataware_houses`.`active` = 1)";

$result5 = $conn->query($sq4);	
if ($result5->num_rows > 0) {
	while($dataware_houses_row = $result5->fetch_assoc()) {	
	echo $dataware_houses_row['dataware_houses_name'];
	$table_create[]=str_replace(" ","_",$dataware_houses_row['dataware_houses_name'])."_raw_data";
	
	
	}
}
*/	
	
	/////////////////////////
echo $sq5 = "select `teams`.`id` as `teams_id`, `teams`.`team_name` as `team_name`, `team_database`.`id` as `team_database_id`, `team_database`.`team_id` as `team_database_team_id`, `team_database`.`db_credentials` as `team_database_db_credentials` from `teams` left join `team_database` on `team_database`.`team_id` = `teams`.`id` WHERE teams.is_active=1";
$result6 = $conn->query($sq5);	

$databaseCreated = array();
if ($result6->num_rows > 0) {
	while($team_database_data = $result6->fetch_assoc()) {
		
		if(!is_numeric($team_database_data['team_database_team_id'])){
			//////////// create dataase
			
			//$team_database_row_team_name= str_replace(" ","_",$team_database_data['team_name']);
			
			$database_name = "japio_team_db_".$team_database_data['teams_id'];//str_replace( array( '\'', '"',',' , ';', '<', '>', '`' ), '', $team_database_row_team_name);
			//$database_name=  $db_name."_".$team_database_data['teams_id'];
			$database_user=$database_name."_user";
			$database_password= substr(str_shuffle(RANDOM_GENERATE_CODE), 0, RANDOM_CODE_LENTH);
			
			$data_base=array(
				'host'=>$host,
				'database_name'=>$database_name,                        
				'database_user'=>$database_user,
				'database_password'=>$database_password,
			); 
			$json_data	=json_encode($data_base);
			echo "<pre>";

			$sql_db = "CREATE DATABASE `$database_name`";
			$res = $conn->query($sql_db);
			print_r($res);
			echo $sql_user = "CREATE USER '$database_user'@'".$host."' IDENTIFIED BY '$database_password'";
			$res = $conn->query($sql_user);
			print_r($res);
			$sql_permission = "GRANT ALL PRIVILEGES ON `$database_name`.* TO '$database_user'@'".$host."' WITH GRANT OPTION";
			$res = $conn->query($sql_permission);	
			$teams_ids=$team_database_data['teams_id'];
			print_r($res);
			$databaseCreated[] = $data_base;
			
			echo $sql_in = "INSERT INTO `team_database` (`team_id`, `db_credentials`)VALUES ('$teams_ids', '$json_data')";
			$res = $conn->query($sql_in);		
			print_r($res);	
			//echo "eeeee";
			
		} else {
				
			$data_conn= json_decode($team_database_data['team_database_db_credentials']);
		
			$new_conn_database_name =$data_conn->database_name;
			$new_conn_database_user= $data_conn->database_user;
		
			$new_conn_database_password=$data_conn->database_password;
			echo "<br>Database: $new_conn_database_name <br>";
			$conn1 = new mysqli($host, $new_conn_database_user, $new_conn_database_password, $new_conn_database_name);

			if ($conn1->connect_error) {
				echo "<br>Connection failed: $host, $new_conn_database_user, $new_conn_database_password, $new_conn_database_name " . $conn1->connect_error;
			} 

			if(isset($in_table[$team_database_data['teams_id']])){
				foreach($in_table[$team_database_data['teams_id']] as $tableName=>$details){
					JSONToTable($tableName,$details,$conn1);
				}
			}	
		}
	}
	
	echo "<pre>";
	print_r($databaseCreated);
	die;
	
}

function prdie($arr){
	echo "<pre>";
	print_r($arr);
	die;
}


function JSONToTable($tableName,$apiDatarows,$dbConn){
	if(is_array($apiDatarows) && count($apiDatarows)>0){
		foreach($apiDatarows as $row){
			$tableName = strtolower(clean($tableName."_".$row['dataset_id']));
			if($row['datasource_id']==2){ //google analytics
				$rawData = json_decode($row['raw_data'],true);
				$columns = $rawData[0]['columnHeader']['dimensions'];
				foreach($rawData[0]['columnHeader']['metricHeader']['metricHeaderEntries'] as $colDetails){
					$columns[] = $colDetails['name'];
				}
				$sql_table = "CREATE TABLE IF NOT EXISTS $tableName  (
					id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
				
				$columnList = [];
				foreach($columns as $col){ //consider all varchar for now
					$colName = str_replace(":","",$col);
					$columnList[] = $colName;
					$sql_table.= " $colName VARCHAR(254) NULL, ";
				}

				$sql_table.="created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
				$sql_table.=")";
				$res = $dbConn->query($sql_table);
				echo "<br>Tables Created? ";var_dump($res);

				//truncate the table before inserting 
				$dbConn->query("TRUNCATE TABLE $tableName");

				//insert the rows
				$columnList = implode(", ",$columnList);
				$insertSql = "INSERT INTO $tableName ($columnList) VALUES ";
				foreach($rawData[0]['data']['rows'] as $apiRow){
					$insertRow[] = "(".implode(", ",array_merge($apiRow['dimensions'],$apiRow['metrics'][0]['values'])).")";
				}
				echo "<br>Inserting Records in table $tableName ....... <br>";
				$insertSql .= implode(", ",$insertRow);
				$dbConn->query($insertSql);


			}else{
				$sql_table = "CREATE TABLE IF NOT EXISTS $tableName  (
					id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					user_email VARCHAR(200) NOT NULL,
					dataset_name VARCHAR(256) NOT NULL,
					raw_data VARCHAR(200) NOT NULL,
					created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP /*,
					updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP */
					)";

				//truncate the table before inserting 
				$dbConn->query("TRUNCATE TABLE $tableName");
				echo "<br>Inserting Records in table $tableName ....... <br>";
				$sqlin = "INSERT INTO `$tableName` (`user_email`, `dataset_name`,`raw_data`) VALUES ('".$row['user_email']."','".$row['dataset_name']."','".$row['raw_data']."',')";
				$dbConn->query($sqlin);
			}
		}
		
	}
		
}


function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
	return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
 }
	



?>