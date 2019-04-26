<?php
namespace Momo\MomoApp\Traits;
/**
*Copyright (c) 2019, LinWorld Tech Solutions.
*
*All rights reserved.
*
*Redistribution and use in source and binary forms, with or without
*modification, are permitted provided that the following conditions are met:
*
*    * Redistributions of source code must retain the above copyright
*      notice, this list of conditions and the following disclaimer.
*
*    * Redistributions in binary form must reproduce the above
*      copyright notice, this list of conditions and the following
*      disclaimer in the documentation and/or other materials provided
*      with the distribution.
*
*    * Neither the name of LinWorld Tech Solutions nor the names of other
*      contributors may be used to endorse or promote products derived
*      from this software without specific prior written permission.

*THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
*"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
*LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
*A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
*OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
*SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
*LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
*DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
*THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
*(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
*OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

use Momo\MomoApp\Commons\Constants;

use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Models\RequestStatus;
use Momo\MomoApp\Models\RequestToPayResponse;


trait PerformsTransfers{
	use ChecksBalance;

	public function requestToPay(RequestToPay $requestBody,$callbackUri=false){
		$referenceId=$this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID,$referenceId);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		$response= $this->send($this->genRequest("POST",$this->request_uri,$requestBody->generateRequestBody()));

		$result=new RequestToPayResponse($response,$referenceId,$requestBody);

		if ($result->isAccepted()) {
			return $this->db->saveRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary);
		}
		return false;
	}
	public function requestToPayStatus($referenceId){
		if($payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary)){
			if ($payt['status']==="PENDING") {
				$this->setAuth();
				$response= $this->send($this->genRequest("GET",$this->request_uri.'/'.$referenceId));
				$result=new RequestStatus($response,$referenceId);
				if ($this->db->updateRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary)) {
					$payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary);
				}
			}	
			return $payt;		
		}
		return false;
	}

	/*public function requestPreAproval(RequestToPay $requestBody,$callbackUri=false){
		$referenceId=$this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID,$referenceId);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		$response=$this->send($this->genRequest("POST",MomoLinks::PRE_APPROVAL_URI,$requestBody->generateRequestBody()));
		$result=new RequestToPayResponse($response,$referenceId,$requestBody);
		if ($result->isAccepted()) {
			return $this->db->saveRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary);
		}
		return false;

	}*/
	/*public function requestPreAprovalStatus($referenceId){
		if($payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary)){
			if ($payt['status']==="PENDING") {
				$this->setAuth();
				$response= $this->send($this->genRequest("GET",MomoLinks::PRE_APPROVAL_URI.'/'.$referenceId));
				$result=new RequestStatus($response,$referenceId);
				if ($this->db->updateRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary)) {
					$payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary);
				}
			}	
			return $payt;		
		}
		return false;
	}*/
}