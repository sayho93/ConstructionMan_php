<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ApiProcess.php" ?>
<?
	$obj = new ApiProcess($_REQUEST);
	$pushTargetList = $obj->getBulkPushData($_REQUEST["push_code"]);
	
	
	$push_msg		= $_REQUEST["push_msg"];
	$push_no		= $_REQUEST["push_no"];
	$push_type		= $_REQUEST["push_type"];
	$push_send_size = 10000;
	
	$paramsArr = Array();
	
	for($i=0; $i<(floor(sizeof($pushTargetList) / $push_send_size) + 1); $i++)
	{
		$paramsArr[$i] = "push_msg={$push_msg}&push_type={$push_type}&push_no={$push_no}";
	}
	
	for ($i=0; $i<sizeof($pushTargetList); $i++)
	{
		$targetData = Array(
			"registration_key"	=> $pushTargetList[$i]["registration_key"],
			"device_type_id"	=> $pushTargetList[$i]["device_type_id"]
		);
		$paramsStr = urlencode(json_encode($targetData));
		$paramsArr[floor($i/$push_send_size)] .= "&targetList[]={$paramsStr}";
	}
	
	
	try {
		$mh = curl_multi_init();
		
		$chArr = Array();
		
		for($i=0; $i<sizeof($paramsArr); $i++)
		{
			$chArr[$i] = curl_init();
			curl_setopt($chArr[$i], CURLOPT_URL, "{$obj->con_domain}/action_front.php?cmd=ApiProcess.sendBulkPush");
			curl_setopt($chArr[$i], CURLOPT_POST, true);
			curl_setopt($chArr[$i], CURLOPT_POSTFIELDS, $paramsArr[$i]);
			curl_multi_add_handle($mh, $chArr[$i]);
		}
		
		$active = null;
		//execute the handles
		do
		{
			$mrc = curl_multi_exec($mh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);
		
		while ($active && $mrc == CURLM_OK)
		{
			if (curl_multi_select($mh) != -1)
			{
				do
				{
					$mrc = curl_multi_exec($mh, $active);
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		//close the handles
		for ($i=0; $i < sizeof($chArr); $i++)
		{
			// echo curl_multi_getcontent($chArr[$i]);
			curl_multi_remove_handle($mh, $chArr[$i]);
		}
		
		curl_multi_close($mh);
	}
	catch (Exception $e)
	{
		curl_multi_close($mh);
		echo $e->getTrace();
	}
	
?>