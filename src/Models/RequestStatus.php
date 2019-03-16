<?php
/*Array
(
    [status_code] => 200
    [status_phrase] => OK
    [data] => Array
        (
            [externalId] => 3940bb2d-73d1-4067-b0d1-eded3221d935
            [amount] => 1000
            [currency] => EUR
            [payer] => Array
                (
                    [partyIdType] => MSISDN
                    [partyId] => 46733123450
                )

            [payerMessage] => Testing
            [payeeNote] => Testing
            [status] => FAILED
            [reason] => INTERNAL_PROCESSING_ERROR
        )

)*/

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