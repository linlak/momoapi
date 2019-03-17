<?php
namespace Momo\MomoApp\Commons;
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
class MomoLinks 
{
	
	private function __construct()
	{
		# code...
	}

	const BASE_URI='https://ericssonbasicapi2.azure-api.net/';

	//collection
	const REQUEST_TO_PAT_URI='https://ericssonbasicapi2.azure-api.net/collection/v1_0/requesttopay';
	const TOKEN_URI='https://ericssonbasicapi2.azure-api.net/collection/token/';
	const BALANCE_URI='https://ericssonbasicapi2.azure-api.net/collection/v1_0/account/balance';
	const ACOUNT_HOLDER_URI='https://ericssonbasicapi2.azure-api.net/collection/v1_0/accountholder/';

	//disbursment
	const D_TOKEN_URI="https://ericssonbasicapi2.azure-api.net/disbursement/token/";
	const D_TRANSFER_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/transfer";
	const D_BALANCE_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/account/balance";
	const D_ACCOUNT_HOLDER_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/accountholder/";
	//"{accountHolderIdType}/{accountHolderId}/active"; IDTYPES [msisdn, email, party_code]
	
	//remitence
	const R_TOKEN_URI="https://ericssonbasicapi2.azure-api.net/remittance/token/";
	const R_TRANSFER_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/transfer";
	// status resourceId
	const R_BALANCE_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/account/balance";
	const R_ACCOUNT_HOLDER_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/accountholder/";//{accountHolderIdType}/{accountHolderId}/active";
	//apiUser
	const USER_URI="https://ericssonbasicapi2.azure-api.net/v1_0/apiuser";
	// info '/{referenceId}'
	//apikey '{referenceId}/apikey'

}