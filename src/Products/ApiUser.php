<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use Momo\MomoApp\Models\ApiUserResponse;
use Momo\MomoApp\Models\ApiKeyResponse;
use Momo\MomoApp\Models\apiUserInfoResponse;
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
	public function createApiUser($providerCallbackHost){
		$uid=$this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID,$uid);
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$body=['providerCallbackHost'=>$providerCallbackHost];
		$result=$this->send($this->genRequest("POST",MomoLinks::USER_URI,$body));
		return new ApiUserResponse($result,$uid);
	}
	public function getApiUser($uid){
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result=$this->send($this->genRequest("GET",MomoLinks::USER_URI.'/'.$uid));
		return new ApiUserInfoResponse($result,$uid);
	}
	public function getApikey($uid){
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result=$this->send($this->genRequest("POST",MomoLinks::USER_URI.'/'.$uid.'/apikey'));
		return new ApiKeyResponse($result,$uid);
	}
	public function apiUserHook(){}
}