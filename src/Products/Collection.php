<?php
namespace Momo\MomoApp\Products;

use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;

use Momo\MomoApp\Models\TokenResponse;
use Momo\MomoApp\Models\BalanceResponse;
// use Momo\MomoApp\Models\TokenResponse;

use Momo\MomoApp\Interfaces\CollectionInterface;

class Collection extends MomoApp implements CollectionInterface
{
	
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
	public function requestToken(){		
		$this->setAuth();
		$response = $this->send($this->genRequest("POST",MomoLinks::TOKEN_URI));
		return new TokenResponse($response);
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
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		return $this->send($this->genRequest("POST",MomoLinks::REQUEST_TO_PAT_URI,$requestBody->generateRequestBody()));
	}
	public function requestBalance(){
		$this->setAuth();
		$response = $this->send($this->genRequest("GET",MomoLinks::BALANCE_URI));	

		return new BalanceResponse($response);
		
	}
}