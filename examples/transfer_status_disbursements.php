<?php
	require_once "momo_disbursements.php";

	
	
	$referenceId="{referenceId  returned in transer.php}";

	//array

	$result=$disbursements->transferStatus($referenceId);

	//let's print the result

	echo "<pre>";
	print_r($result);