<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;

use Momo\MomoApp\Models\TokenResponse;
use Momo\MomoApp\Models\BalanceResponse;
// use Momo\MomoApp\Models\TokenResponse;
use Momo\MomoApp\Interfaces\TransferInterface;
/**
* 
*/
class Remittances extends MomoApp implements TransferInterface
{
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
		public function requestToken(){		
		$this->setAuth();
		$response= $this->send($this->genRequest("POST",MomoLinks::R_TOKEN_URI));
		return new TokenResponse($response);
	}
	public function transferStatus($resourceId){
		$this->setAuth();
		return $this->send($this->genRequest("GET",MomoLinks::R_TRANSFER_URI.'/'.$resourceId));
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){		
		return $this->send($this->genRequest("GET",MomoLinks::R_ACCOUNT_HOLDER_URI.$accountHolderIdType.'/'.$accountHolderId.'/active'));
	}
	public function transfer(RequestToPay $requestBody,$ref,$callbackUri=false){
		$this->setHeaders(Constants::H_REF_ID,$ref);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		return $this->send($this->genRequest("POST",MomoLinks::R_TRANSFER_URI,$requestBody->generateRequestBody()));
	}
	public function requestBalance(){
		$this->setAuth();
		$response= $this->send($this->genRequest("GET",MomoLinks::R_BALANCE_URI));
		return new BalanceResponse($response);
		
	}
}