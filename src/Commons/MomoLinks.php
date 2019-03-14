<?php
namespace Momo\MomoApp\Commons;
/**
* 
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
	const D_TOKEN_URI="https://ericssonbasicapi2.azure-api.net/disbursement/token";
	const D_TRANSFER_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/transfer";
	const D_BALANCE_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/account/balance";
	const D_ACCOUNT_HOLDER_URI="https://ericssonbasicapi2.azure-api.net/disbursement/v1_0/accountholder/";
	//"{accountHolderIdType}/{accountHolderId}/active"; IDTYPES [msisdn, email, party_code]
	
	//remitence
	const R_TOKEN_URI="https://ericssonbasicapi2.azure-api.net/remittance/token";
	const R_TRANSFER_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/transfer";
	// status resourceId
	const R_BALANCE_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/account/balance";
	const R_ACCOUNT_HOLDER_URI="https://ericssonbasicapi2.azure-api.net/remittance/v1_0/accountholder/";//{accountHolderIdType}/{accountHolderId}/active";
	//apiUser
	const USER_URI="https://ericssonbasicapi2.azure-api.net/v1_0/apiuser";
	// info '/{referenceId}'
	//apikey '{referenceId}/apikey'

}