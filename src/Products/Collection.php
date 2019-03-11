<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
class Collection extends MomoApp
{
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
	public function requestToken(){
		$request=new Request("GET",MomoLinks::TOKEN_URI,$this->headers);
		return $this->send($request);
	}
	public function requestToPayStatus($resourceId){
		$request=new Request("GET",MomoLinks::REQUEST_TO_PAT_URI.'/'.$resourceId,$this->headers);
		return $this->send($request);
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){
		$request=new Request("GET",MomoLinks::ACOUNT_HOLDER_URI.$accountHolderIdType.'/'.$accountHolderId.'/active',$this->headers);
		return $this->send($request);
	}
	public function requestToPay(RequestToPay $requestBody,$ref,$callbackUri=false){
		$this->setHeaders('X-Reference-Id',$ref);
		if (false!==$callbackUri) {
			$this->setHeaders('X-Callback-Url',$callbackUri);
		}
		$request=new Request("POST",MomoLinks::REQUEST_TO_PAT_URI,$this->headers,$requestBody->generateRequestBody());
		return $this->send($request);
	}
	public function requestBalance(){
		$request=new Request("GET",MomoLinks::BALANCE_URI,$this->headers);
		return $this->send($request);
		
	}
}