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
		{ $name = $json->queryResult->outputContexts[1]->parameters->name; }

		$sh_desc = strtolower($sh_desc);
		//$sh_desc = "Testing";
		//$name = "someone";
		$instance = "dev60887";
		$username = "admin";
		$password = "Avik.17.jan";
		$table = "incident";
		//$jsonobj = "{\"short_description\":$sh_desc,\"priority\":\"1\",\"Caller_id\":\"someone\"}";
		$jsonobj = array('short_description' => $sh_desc);
             	$jsonobj = json_encode($jsonobj);	

		//$jsonobj = "{\"short_description\":$sh_desc,\"priority\":\"1\",\"Caller_id\":$name}";
		$query = "https://$instance.service-now.com/$table.do?JSONv2&sysparm_action=insert";
		$curl = curl_init($query);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		if($jsonobj)
		{
			    curl_setopt($curl, CURLOPT_POST, true);
			    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonobj);
		}
		$response = curl_exec($curl);
		curl_close($curl);
		$jsonoutput = json_decode($response);
		$incident_no =  $jsonoutput->records[0]->number;
		
		$speech = "Thanks ".$name."! Incident Created Successfully for issue " . $sh_desc . " and your incident number is " . $incident_no;
		//echo $speech;
		

	}
	if($json->queryResult->intent->displayName=='Get_Status_ticket')
	{
		if(isset($json->queryResult->queryText))
		{ $sh_desc = $json->queryResult->queryText; }

		if(isset($json->queryResult->parameters->Raisedate))
		{ $Raisedate = $json->queryResult->parameters->Raisedate; }
		
		if(isset($json->queryResult->parameters->Ticketno))
		{ $Ticketno = $json->queryResult->parameters->Ticketno; }
		
		$Raisedate = substr($Raisedate, 0, 10);
		
		
		$sh_desc = strtolower($sh_desc);
		//$sh_desc = "Testing";
		//$name = "someone";
		$instance = "dev60887";
		$username = "admin";
		$password = "Avik.17.jan";
		$table = "incident";
		//$jsonobj = "{\"short_description\":$sh_desc,\"priority\":\"1\",\"Caller_id\":\"someone\"}";
		//$jsonobj = array('short_description' => $sh_desc);
             	//$jsonobj = json_encode($jsonobj);	

		//$jsonobj = "{\"short_description\":$sh_desc,\"priority\":\"1\",\"Caller_id\":$name}";
		$query = "https://$instance.service-now.com/$table.do?JSONv2&sysparm_action=getRecords&sysparm_query=numberENDSWITH".$Ticketno."^sys_created_onSTARTSWITH".$Raisedate;
		$curl = curl_init($query);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

		/*if($jsonobj)
		{
			    curl_setopt($curl, CURLOPT_POST, true);
			    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonobj);
		}*/
		$response = curl_exec($curl);
		curl_close($curl);
		$jsonoutput = json_decode($response);
		$assigned_to =  $jsonoutput->records[0]->assigned_to;
		$number =  $jsonoutput->records[0]->number;
		$state =  $jsonoutput->records[0]->state;
		$sys_updated_by = $jsonoutput->records[0]->sys_updated_by;
		$sys_updated_on = $jsonoutput->records[0]->sys_updated_on;
		$short_description = $jsonoutput->records[0]->short_description;
		
		
		if($assigned_to=='')
		{
			$assigned_to = 'no one';
		}
		$speech = "Incident ".$number." is currently assigned to ".$assigned_to.". Current status of  the incident is ".$state." . This incident was last updated by ".$sys_updated_by." on ".$sys_updated_on;
		$speech .= " The incident was raised for the issue ".$short_description;
				
		
		//$speech = "Thanks ".$name."! Incident Created Successfully for issue " . $sh_desc . " and your incident number is " . $incident_no;
		//echo $speech;
		

	}
		$res = new \stdClass();
		$res->fulfillmentText = $speech;
		$res->source = "webhook";
		echo json_encode($res);
}
else
{
	echo "Method not allowed";
}

?>
