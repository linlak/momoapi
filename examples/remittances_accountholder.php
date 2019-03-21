<?php
	require_once "momo_remittances.php";


	$acoutHolderId="{acoutHolderId}";
	$acoutHolderIdType="{acoutHolderIdType}";

	//array
	$result=$remittances->acountHolder($accountHolderIdType,$accountHolderId);

	//let's print the result

	echo "<pre>";
	print_r($result);