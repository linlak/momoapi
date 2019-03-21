<?php
	require_once "momo_disbursements.php";


	$acoutHolderId="{acoutHolderId}";
	$acoutHolderIdType="{acoutHolderIdType}";

	//array
	$result=$disbursements->acountHolder($accountHolderIdType,$accountHolderId);

	//let's print the result

	echo "<pre>";
	print_r($result);