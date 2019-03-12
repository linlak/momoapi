<?php
namespace Momo\MomoApp\Models;
class RequestToPay{
	
	private $amount='';
	private $currency='UGX';
	private $externalId='';
	private $payeeNote='';
	private $payerMessage;
	private $payer=[
		'partyId'=>'',
		'partyIdType'=>'MSISDN'
	];
	public function __construct($externalId,$amount,$partyId,$partyIdType,$payeeNote,$payerMessage){
		$this->amount=$amount;
		$this->externalId=$externalId;
		$this->payeeNote=$payeeNote;
		$this->payerMessage=$payerMessage;
		$this->payer=[
			'partyId'=>$partyId,
			'partyIdType'=>$partyIdType
		];
	}
	public function setCurrency($currency){
		$this->currency=$currency;
	}
	public function generateRequestBody(){
		$output=[
			"amount"=> $this->amount,
			"currency"=> $this->currency,
			"externalId"=> $this->externalId,
			"payer"=> $this->payer,
			"payerMessage"=> $this->payerMessage,
			"payeeNote"=> $this->payeeNote
		];
		return json_encode($output,JSON_UNESCAPED_SLASHES);
	}
}