<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
/**
* genRequest
*/
class ApiUser extends MomoApp
{
	
	function __construct($apiKey,$apiSecret)
	{
		parent::__construct($apiKey,$apiSecret);
	}
	//apiUser
	public function createApiUser($uid,$callbackUri){
		$this->setHeaders(Constants::H_REF_ID,$uid);
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		return $this->send($this->genRequest("POST",MomoLinks::USER_URI,"{ providerCallbackHost: ".$callbackUri."}"));		
	}
	public function apiUserHook(){}
}