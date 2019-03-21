<?php
	require_once "momo_collections.php";

	//instanceof BalanceResponse
	$result=$collection->requestBalance();

	//let's print the result

	if($result->isFound()){
		$availableBalance=$result->getAvailableBalance();
		$currency=$result->getCurrency();
		echo('availableBalance: '.$availableBalance.'\n\r');
		echo('currency: '.$currency.'\n\r');
	}