<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
class Collection extends MomoApp
{
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
	public function requestToken($apiUserId){
		
		$this->apiUserId=$apiUserId;
		$this->setAuth();
		$this->removeHeader(Constants::H_ENVIRON);
		$promise=$this->send($this->genRequest("GET",MomoLinks::TOKEN_URI));
		return $promise;
	}
	public function requestToPayStatus($resourceId){
		$this->setAuth();
		return $this->send($this->genRequest("GET",MomoLinks::REQUEST_TO_PAT_URI.'/'.$resourceId));
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){		
		return $this->send($this->genRequest("GET",MomoLinks::ACOUNT_HOLDER_URI.$accountHolderIdType.'/'.$accountHolderId.'/active'));
	}
	public function requestToPay(RequestToPay $requestBody,$ref,$callbackUri=false){
		$this->setHeaders(Constants::H_REF_ID,$ref);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		return $this->send($this->genRequest("POST",MomoLinks::REQUEST_TO_PAT_URI,$requestBody->generateRequestBody()));
	}
	public function requestBalance(){
		$this->setAuth();
		return $this->send($this->genRequest("GET",MomoLinks::BALANCE_URI));		
	}
}