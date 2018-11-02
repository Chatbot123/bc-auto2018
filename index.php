<?php

//Setup
$instance = "dev60887";
$username = "admin";
$password = "Avik.17.jan";
$table = "incident";
//$printFields = array("sys_id", "name", "type", "version");

//Create a MySQL Database Server
echo "<br><br>Create a MySQL Database Server<br>";
$filter = "";
$json = '{"short_description":"My First JSON incident","priority":"1"}';
$res = jsonQuery($instance, $username, $password, $table, "insert", $filter, $json);
echo $res;

/*$newDbServer = $res->records[0]->sys_id;
printRecord($res, $printFields);*/








/*

// List MySQL Databases
echo "<br><br>List current MySQL Databases<br>";
$filter = "type%3DMySQL";
$json = "";
$res = jsonQuery($instance, $username, $password, $table, "getRecords", $filter, $json);
printRecord($res, $printFields);
*/



function jsonQuery($instance, $username, $password, $table, $action, $encodedQuery, $jsonInput)
{
	  $query = "https://$instance.service-now.com/$table.do?JSON&" .
		  "sysparm_action=$action";
	  if($encodedQuery) $query .= "&sysparm_query=$encodedQuery"; 
	  $curl = curl_init($query);

	  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	  curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	  curl_setopt($curl, CURLOPT_VERBOSE, 1);
	  curl_setopt($curl, CURLOPT_HEADER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  if( $jsonInput )
  {
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonInput);
  }
  
	  $response = curl_exec($curl);
	  curl_close($curl);
	  $json = json_decode($response);
	  if ($json != "" && property_exists($json, 'error')){
	    throw new ErrorException("SN JSON Error: {$json->error}");
	  }
  return $json;
}

/*function printRecord($obj, $fields){
  if(!obj || !$obj->records) return;
  foreach($obj->records as $rec){
    foreach($rec as $key => $value){
      if( in_array($key, $fields ) ) echo "[$key]: $value; ";
    }
    echo "<BR>";*/
  }
}
?>
