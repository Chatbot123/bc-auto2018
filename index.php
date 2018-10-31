<?php
$method = $_SERVER['REQUEST_METHOD'];
//process only when method id post
if($method == 'POST')
{
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$json_url = "https://dev60887.service-now.com/api/289816/incidentcreate";
		$username    = "admin";
    		$password    = "Avik.17.jan";
		$ch      = curl_init( $json_url );
    		$options = array(
        	CURLOPT_SSL_VERIFYPEER => false,
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_USERPWD        => "{$username}:{$password}",
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		//$someobj = json_decode($json,true);
		
		//	$speech_data = $file->results->result->fulfillment->speech;
       			// $nexttick=time()+10;
		// $active=false;	
    	
	}
else
{
	echo "Method not allowed";
}

?>
