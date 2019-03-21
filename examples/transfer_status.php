<?php
	require_once "momo_remittances.php";

	
	
	$referenceId="{referenceId  returned in transer.php}";

	//array

	$result=$remittances->transferStatus($referenceId);

	//let's print the result

	echo "<pre>";
	print_r($result);