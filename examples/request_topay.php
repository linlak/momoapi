<?php
	require_once "momo_collections.php";
	use Momo\MomoApp\Models\RequestToPay;
			
	//requestToPay object

	$requestToPay=new RequestToPay("{externalId}","{amount}","{partyId}","{partyIdType}","{payeeNote}","{payerMessage}");

	//to set the currency

	$requestToPay->setCurrency("{curency}");// read docs for more info on supported currencies.

	$callbackUrl="{url to your webhook}";

	//array
	$result=$collection->requestToPay($requestToPay,$callbackUrl);
	//let's print the result

	echo "<pre>";
	print_r($result);