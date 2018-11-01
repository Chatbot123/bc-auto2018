<?php
$method = $_SERVER['REQUEST_METHOD'];
//process only when method id post
if($method == 'POST')
{
		$username    = "admin";
    		$password    = "Avik.17.jan";
		$ch = curl_init();
    		$options = array(
		CURLOPT_URL =>'https://dev60887.service-now.com/api/289816/incidentcreate',
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => false
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
	//echo $json;
	//	$someobj = json_decode($json,true);
	//	echo $someobj;
		//	$speech_data = $file->results->result->fulfillment->speech;
       			// $nexttick=time()+10;
		// $active=false;	
    	
	}
else
{
	echo "Method not allowed";
}
?>
