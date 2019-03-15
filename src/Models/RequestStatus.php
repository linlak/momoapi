<?php
/*{
  "amount": 100,
  "currency": "UGX",
  "financialTransactionId": 23503452,
  "externalId": 947354,
  "payer": {
    "partyIdType": "MSISDN",
    "partyId": 4656473839
  },
  "status": "SUCCESSFUL"
}*/
/**
* 
*/

class RequestStatus extends RequestToPay
{
	private $status="unknown";
	function __construct(array $response){
		
	}
	public function getStatus(){}
}