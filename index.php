<?php
$method = $_SERVER['REQUEST_METHOD'];
//process only when method id post
if($method == 'POST')
{
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	
	$sec = $json->queryResult->parameters->sec;
	
	
	$nexttick=time()+$sec;
	//echo $nexttick;
	$active=true;
	while ($active)
	{
    	if (time()>=$nexttick)
   	 {
        		$opts = array();
			$opts['http'] = array();
			$opts['http']['method']="GET";
			$opts['http']['header']="Accept-language: en\r\n"."Cookie: foo=bar\r\n";
			$t1=stream_context_create($opts);
		
			// Open the file using the HTTP headers set above
			$test_file=file_get_contents("https://efashion-r.herokuapp.com/?appid=2d1e87e7-501b-410a-b365-98356344bd82", false, $t1);
			
			$file = json_decode($test_file);
			$speech_data = $file->results->result->fulfillment->speech;
       			// $nexttick=time()+10;
		 $active=false;	
    	}
	}
