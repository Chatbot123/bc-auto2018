<?php

//Setup
$instance = "dev60887";
$username = "admin";
$password = "Avik.17.jan";
$table = "incident";
//$printFields = array("short_description", "priority","Caller_id");



$json = "{\"short_description\":\"testing for automatic creation\",\"priority\":\"1\",\"Caller_id\":\"someone\"}";

 $query = "https://$instance.service-now.com/$table.do?JSONv2&sysparm_action=insert";
	  $curl = curl_init($query);

	  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	  curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	  curl_setopt($curl, CURLOPT_VERBOSE, 1);
	  curl_setopt($curl, CURLOPT_HEADER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  if( $json)
  {
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  }
 $response = curl_exec($curl);
	  curl_close($curl);
	  $json = json_decode($response);
	 
	echo $json->records[0]->number;

/*$res = getjsonQuery($instance, $username, $password, $table);
echo $res;
//printRecord($res, $printFields);



function getjsonQuery($instance, $username, $password, $table)
{
	  $query = "https://$instance.service-now.com/$table.do?JSON&sysparm_query=ORDERBYDESCsys_created_on";
	  
	  $curl = curl_init($query);

	  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	  curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	  curl_setopt($curl, CURLOPT_VERBOSE, 1);
	  curl_setopt($curl, CURLOPT_HEADER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/json"));
	  
 
  
	  $response = curl_exec($curl);
	  curl_close($curl);
	  $json = json_decode($response);
	 
	echo $json;
 return $json;
}
/*function printRecord($obj, $fields){
  if(!obj || !$obj->records) return;
  foreach($obj->records as $rec){
    foreach($rec as $key => $value){
      if( in_array($key, $fields ) ) echo "[$key]: $value; ";
    }
    echo "<BR>";
  }
}*/
?>
