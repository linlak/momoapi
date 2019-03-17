<?php

class RequestStatus extends MomoResponse
{
    private $payer=[];
    private $externalId="";
    private $amount=0;
    private $currency="";
    private $partyIdType="";
    private $partyId="";
    private $payerMessage="";
    private $payeeNote="";
    private $status="";
	private $reason="";
	function __construct(array $response){
		parent::__construct($response);
	}

	public function getStatus(){
        return $this->status;
    }
    public function isSucess(){
        return $this->status==="";
    }

    public function isPending(){
        return $this->status==="";
    }

    public function isFailed(){
        return $this->status==="";
    }
}