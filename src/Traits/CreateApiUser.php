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

use Momo\MomoApp\Models\ApiKeyResponse;
use Momo\MomoApp\Models\ApiUserInfoResponse;
use Momo\MomoApp\Models\ApiUserResponse;
use Momo\MomoApp\Models\TokenResponse;

trait CreateApiUser
{

	public function createApiUser($providerCallbackHost)
	{

		$uid = $this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID, $uid);
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$body = ['providerCallbackHost' => $providerCallbackHost];
		$result = $this->send($this->genRequest("POST", $this->getSetting(Constants::USER_URI), $body));
		return new ApiUserResponse($result, $uid);
	}

	public function getApiUser()
	{

		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result = $this->send($this->genRequest("GET", $this->getSetting(Constants::USER_URI) . '/' . $this->getSetting(Constants::USER_KEY)));
		return new ApiUserInfoResponse($result, $this->getSetting(Constants::USER_KEY));
	}

	public function getApikey()
	{

		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result = $this->send($this->genRequest("POST", $this->getSetting(Constants::USER_URI) . '/' . $this->getSetting(Constants::USER_KEY) . '/apikey'));
		return new ApiKeyResponse($result, $this->getSetting(Constants::USER_KEY));
	}

	public function apiUserHook()
	{ }

	public function requestToken()
	{
		$this->setApiToken("");
		$this->setAuth();
		$response = $this->send($this->genRequest("POST", $this->getSetting(Constants::TOKEN_URI)));
		if ($this->db->saveApiToken(new TokenResponse($response), $this)) {
			return true;
		}
		return false;
	}
	public function acountHolder($accountHolderIdType, $accountHolderId)
	{
		$this->setAuth();
		return $this->send($this->genRequest("GET", $this->getSetting(Constants::ACC_HOLDER) . $accountHolderIdType . '/' . $accountHolderId . '/active'));
	}
}
