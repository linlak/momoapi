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
class Constants
{

	private	function __construct()
	{
		# code...
	}
	const V_CODE = "v1_0";
	const H_ENVIRON = "X-Target-Environment";
	const H_OCP_APIM = "Ocp-Apim-Subscription-Key";
	const H_AUTH = "Authorization";
	const H_C_TYPE = "Content-Type";
	const H_REF_ID = "X-Reference-Id";
	const H_CALL_BACK = "X-Callback-Url";

	//settings
	const ENV_KEY = 'environ';
	const BASE_KEY = 'base_uri';
	const VER_KEY = 'version';
	const PRI_KEY = 'api_primary';
	const SEC_KEY = 'api_secondary';
	const PRODUCT_KEY = 'api_product';
	const API_KEY = 'api_key';
	const TOKEN_KEY = 'api_token';
	const USER_KEY = 'api_user_id';
	//links
	const USER_URI = 'user_uri';
	const TOKEN_URI = 'token_uri';
	const ACC_HOLDER = 'account_holder';
	const BAL_URI = 'balance_url';
	const REQ_URI = 'request_uri';
}
