<?php
	require_once "momo_collections.php";

	$acoutHolderId="{acoutHolderId}";
	$acoutHolderIdType="{acoutHolderIdType}";

	//array
	$result=$collection->acountHolder($accountHolderIdType,$accountHolderId);

	//let's print the result

	echo "<pre>";
	print_r($result);
	