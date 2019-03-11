<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Commons\MomoLinks;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
/**
* 
*/
class ApiUser extends MomoApp
{
	
	function __construct($apiKey,$apiSecret)
	{
		parent::__construct($apiKey,$apiSecret);
	}
	//apiUser
	public function createApiUser($uid,$callbackUri){
		$this->setHeaders('X-Reference-Id',$uid);
		$this->removeHeader('Authorization');
		$this->removeHeader('X-Target-Environment');
		$request=new Request("POST",MomoLinks::USER_URI,$this->headers,"{ providerCallbackHost: ".$callbackUri."}");
		return $this->send($request);		
	}
}