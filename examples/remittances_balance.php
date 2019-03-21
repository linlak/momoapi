<?php
	require_once "momo_remittances.php";

	//instanceof BalanceResponse
	$result=$remittances->requestBalance();

	//let's print the result

	if($result->isFound()){
		$availableBalance=$result->getAvailableBalance();
		$currency=$result->getCurrency();
		echo('availableBalance: '.$availableBalance.'\n\r');
		echo('currency: '.$currency.'\n\r');
	}