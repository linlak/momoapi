<?php
namespace Momo\MomoApp\Interfaces;

use Momo\MomoApp\Models\RequestToPay;

interface CollectionInterface extends ProductCommonsInterface{

	public function requestToPay(RequestToPay $requestBody,$ref,$callbackUri=false);
	public function requestToPayStatus($resourceId);
	
}