<?php
	require_once "momo_collections.php";

	$referenceId="{referenceId  returned in request_topay.php}";

	//array
	$result=$collection->requestToPayStatus($referenceId);
	//let's print the result

	echo "<pre>";
	print_r($result);