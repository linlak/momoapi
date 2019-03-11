<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
/**
* 
*/
class Remittances extends MomoApp
{
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
		public function requestToken($apiUserId){
		$this->apiUserId=$apiUserId;
		$this->setAuth();
		$this->removeHeader(Constants::H_ENVIRON);
		// $this->removeHeader(Constants::H_AUTH);
		$request=new Request("GET",MomoLinks::R_TOKEN_URI,$this->headers);
		return $this->send($request);
	}
	public function transferStatus($resourceId){
		$this->setAuth();
		$request=new Request("GET",MomoLinks::R_TRANSFER_URI.'/'.$resourceId,$this->headers);
		return $this->send($request);
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){
		$request=new Request("GET",MomoLinks::R_ACCOUNT_HOLDER_URI.$accountHolderIdType.'/'.$accountHolderId.'/active',$this->headers);
		return $this->send($request);
	}
	public function transfer(RequestToPay $requestBody,$ref,$callbackUri=false){
		$this->setHeaders(Constants::H_REF_ID,$ref);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		$request=new Request("POST",MomoLinks::R_TRANSFER_URI,$this->headers,$requestBody->generateRequestBody());
		return $this->send($request);
	}
	public function requestBalance(){
		// $this->setAuth();
		$this->removeHeader(Constants::H_AUTH);
		$request=new Request("GET",MomoLinks::R_BALANCE_URI,$this->headers);
		return $this->send($request);
		
	}
}