<?php
namespace Momo\MomoApp\Interfaces;

use Momo\MomoApp\Models\RequestToPay;

interface TransferInterface extends ProductCommonsInterface{
	
	public function transfer(RequestToPay $requestBody,$ref,$callbackUri=false);
	public function transferStatus($resourceId);
	
}