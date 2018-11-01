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
        	CURLOPT_HTTPHEADER     => array( "Accept: application/json" ),
    		);
    		curl_setopt_array( $ch, $options );
		$json = curl_exec( $ch );
		$someobj = json_decode($json,true);
		$speech = $someobj->text;
		
    	$response = new \stdClass();
    	$response->fulfillmentText = $speech;
    	$response->source = "webhook";
	}
else
{
	echo "Method not allowed";
}
?>
