<?php
	session_start();
	$apikey='Mu487549814095508692970935581566';
	//$apikey='prtl6749387986743898559646983194';
	$originplace =$_REQUEST['info'];
	/*$split=explode(',',$info); 
	
	$country=$split[0];
	$currency=$split[1];
	$locale=urlencode($split[2]);
	$originplace=$split[3];
	$destinationplace=$split[4];
	$outbounddate=$split[5];
	$inbounddate=$split[6];
	$cabinclass=$split[7];
	$adults=$split[8];
	$origincity=$split[9];
	$destinationcity=$split[10];
	*/
	$arr_names =array();
	$ct='';
	$session_key='';
	//get current date from server
	//set time zone
	date_default_timezone_set('ASIA/CALCUTTA');
	// Then call the date functions
	$outbounddate = date('Y-m-d');
	
	$params = http_build_query(array
	(
		"currency" => 'INR',
		"country" => 'IN',
		"locale" => 'en-IN',
		"originPlace" => 'GOI-sky',
		"destinationPlace" => $originplace,
		"outbounddate" => $outbounddate,
		"cabinclass" => 'Economy',
		"adults" => 1
	));
	/*
	$params = http_build_query(array
	(
		"currency" => 'GBP',
		"country" => 'GB',
		"locale" =>'en-GB',
		"originPlace" => 'DEL-sky',
		"destinationPlace" => 'GOA-sky',
		"outbounddate" => '2014-12-25',
		"inbounddate" => '2014-12-30',
		"cabinclass" => 'Economy',
		"adults" => 1
	));
	*/
	
	
	//variables	
	$searcheddate=' ';
	$cheapestprice=' ';
	$origin=' ';
	$destination=' ';
	$arr_names=array();					
	/*DB connection 
	$sql = "SELECT * FROM skyscanner where city1='$origincity' AND airportcode1='$originplace' AND city2='$destinationcity' AND airportcode2='$destinationplace' AND outbounddate='$outbounddate' AND inbounddate='$inbounddate'";
	$retval = mysqli_query($con,$sql);
	if(!$retval)
	{
		die('Could not enter data: ' . mysqli_error());
	}
	while($row = mysqli_fetch_array($retval)) 
	{
		$searcheddate=$row['searchdate'];
		$cheapestprice=$row['cheapestprice'];
		$origin=$row['city1'];
		$destination=$row['city2'];
	}
	*/	
	
   	//step1
	$cSession = curl_init(); 
	//step2
	curl_setopt($cSession,CURLOPT_URL,"http://partners.api.skyscanner.net/apiservices/pricing/v1.0?apikey=".$apikey);
	curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($cSession, CURLOPT_POST, true);
	curl_setopt($cSession,CURLOPT_HEADER, true);
	curl_setopt($cSession, CURLOPT_VERBOSE, 1);
	curl_setopt($cSession, CURLOPT_POSTFIELDS, $params); 
	

	curl_setopt($cSession,CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
	//step3
	$result = curl_exec($cSession);
	if(!$result)
	{
		die('Error: "' . curl_error($cSession) . '" - Code: ' . curl_errno($cSession));
	}
	else
	{
		//echo $result;
			
		$st=explode('/',$result);
		//echo '<pre>';
		//echo $st[9];
		$sessionkey= substr($st[9],0,74);
		//echo $sessionkey;
		//echo 'hello';
		$_SESSION['apikey']=$apikey;
		$_SESSION['sessionkey']=$sessionkey;
		$session_key=$_SESSION['sessionkey'];
		//array_push($arr_names,$session_key);
		//$sending_json = json_encode($arr_names);
		//echo $sending_json;
		
	}
	
	
	$header_size = curl_getinfo($cSession, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	//echo $body = substr($response, $header_size);
	
	if (empty($result)) 
	{
		// some kind of an error happened
		die(curl_error($cSession));
		
	}
	else 
	{
		$info = curl_getinfo($cSession);
		//curl_close($cSession); // close cURL handler

		if (empty($info['http_code'])) 
		{
            die("No HTTP code was returned"); 
		}
		else 
		{
			// load the HTTP codes
			$http_codes = parse_ini_file("info.ini");
        
			// echo results
			//echo "The server responded: <br />";
			//echo $info['http_code'] . " " . $http_codes[$info['http_code']];
		}

	}
	
	
	//code to get prices
	$pricedata=' ';
	
	//step1
	$ch = curl_init(); 
	//step2
	curl_setopt($ch,CURLOPT_URL,"http://partners.api.skyscanner.net/apiservices/pricing/v1.0/".$session_key."?apiKey=".$apikey);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch,CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
	curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
	//step3
	$result = curl_exec($ch);
	if(!$result)
	{
		die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
	}
	else
	{
		$myarray=array();
		$myarray1=array();
		//echo $result;
		$st=explode('GMT',$result);
		$myarray=json_decode($st[1],true);
		
		//echo '<PRE>';
		// print_r($myarray);
		// foreach($myarray as $k => $v)
		// {
			// echo "<br>";
		// }
		//echo '<pre>';
		//print_r($myarray['Itineraries']);
		
		//print_r($myarray);
		
		//$myarray1=$myarray['Itineraries'];
		// echo '<pre>';
		// print_r($myarray1);
		//echo 'here'.$myarray1['PricingOptions'];
		//Itineraries
		foreach ($myarray['Itineraries'][0]['PricingOptions'] as $Option)
		{
		
				$pricedata= $Option['Price'];
				array_push($arr_names,$pricedata);
              //	echo "<b> Agents </b> " .implode(',', $Option['Agents']), " <br> <b>price </b>",$Option['Price'] ,"<br />";
        	
		}
		$sending_json = json_encode($arr_names);
		echo $sending_json;
	}
	
	
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	//echo $body = substr($response, $header_size);
	
	if (empty($result)) 
	{
		// some kind of  error happened
		die(curl_error($ch));
		
	}
	else 
	{
		$info = curl_getinfo($ch);
		if (empty($info['http_code'])) 
		{
            die("No HTTP code was returned"); 
		}
		else 
		{
			// load the HTTP codes
			$http_codes = parse_ini_file("info.ini");
        
			// echo results
			//echo "The server responded: <br />";
			//echo $info['http_code'] . " " . $http_codes[$info['http_code']];
		}

	}
	curl_close($cSession);
	curl_close($ch);
	
?>
