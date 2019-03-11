<?php namespace Momo\MomoApp;


class MomoApp{

	private $environ="sandbox";//live
	private $apiVersion='v1_0';
	private $baseUri = 'https://ericssonbasicapi2.azure-api.net/';
	private $apiKey,$apiSecret;
	private $headers=[
		"Authorization"=>"",
		"X-Target-Environment"=>"",
		"Ocp-Apim-Subscription-Key"=>""
	];
/*"Authorization: "
-H "X-Target-Environment: "
-H "Ocp-Apim-Subscription-Key: {subscription key}"*/
/*
"Authorization: "
-H "X-Callback-Url: "
-H "X-Reference-Id: "
-H "X-Target-Environment: "
-H "Content-Type: application/json"
-H "Ocp-Apim-Subscription-Key: {subscription key}"*/
	public function __construct($apiKey,$apiSecret,$environ='sandbox'){
		$this->apiKey=$apiKey;
		$this->apiSecret=$apiSecret;
		$this->environ=$environ;
		$this->genHeaders();
	} 
	private function genHeaders(){
		$this->setHeaders('Authorization','');
		$this->setHeaders('X-Target-Environment',$this->environ);
		$this->setHeaders('Content-Type','application/json');
		$this->setHeaders('Ocp-Apim-Subscription-Key',$this->apiKey);
	}
	private function setHeaders($key,$value){
		$this->headers[$key]=$value;
	}
	private function getCollectionsUri(){
		return $this->baseUri.'collections/'.$this->apiVersion.'/';
	}

	public function requestToPay(RequestToPay $requestBody,$ref,$callbackUri=false){
		$this->setHeaders('X-Reference-Id',$ref);
		if (false!==$callbackUri) {
			$this->setHeaders('X-Callback-Url',$callbackUri);
		}
	}
	public function requestBalance(){}
	public function requestToken(){}
	public function requestToPayHook($resourceId){}
	public function acountHolder($accountHolderIdType,$accountHolderId){}

}