<?php

$method = $_SERVER['REQUEST_METHOD'];
//process only when method id post
if($method == 'POST')
{
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

//Setup

	if($json->queryResult->intent->displayName=='Raise_ticket_intent - Getname - getissue')
	{
		if(isset($json->queryResult->queryText))
		{ $sh_desc = $json->queryResult->queryText; }

		if(isset($json->queryResult->outputContexts[1]->parameters->name))
		{ $username = $json->queryResult->outputContexts[1]->parameters->name; }

		$sh_desc = strtolower($sh_desc);
		$instance = "dev60887";
		$username = "admin";
		$password = "Avik.17.jan";
		$table = "incident";
		$json = "{\"short_description\":$sh_desc,\"priority\":\"1\",\"Caller_id\":\"someone\"}";
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
		$incident_no =  $json->records[0]->number;
		$speech = "Thanks ".$username."! Incident Created Successfully for issue " . $sh_desc . " and your incident number is " . $incident_no;
		$response = new \stdClass();
		$response->fulfillmentText = $speech;
		$response->source = "webhook";
		//echo json_encode($response);

	}
}
else
{
	echo "Method not allowed";
}

?>
