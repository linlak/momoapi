<?php

namespace Momo\MomoApp;

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

use GuzzleHttp\Client;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;



use GuzzleHttp\Psr7\Request;
use Momo\MomoApp\Commons\Constants;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Interfaces\MomoInterface;
use Momo\MomoApp\Traits\CreateApiUser;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

use Ramsey\Uuid\Uuid;

abstract class MomoApp implements MomoInterface
{
	use CreateApiUser;
	private $default_settings = [
		'environ' => 'sandbox', //live
		'base_uri' => MomoLinks::BASE_URI,
		'version' => Constants::V_CODE,
		'api_primary' => '',
		'api_secondary' => '',
		'api_product' => '',
		'api_key' => '',
		'api_token' => '',
		'api_user_id' => '',
		//links
		'user_uri' => '',
		'token_uri' => '',
		'account_holder' => '',
		'balance_url' => '',
		'request_uri' => '',

	];

	private $user_settings = [];

	protected $db = null;

	protected $headers = [
		// "Content-Length"=>0,
		Constants::H_AUTH => "",
		Constants::H_ENVIRON => "",
		// Constants::H_REF_ID=>"",
		Constants::H_C_TYPE => "",
		Constants::H_OCP_APIM => ""
	];
	private $_client;
	/**
	 *@param String [primaryKey] found on your momo profile
	 *@param String [secondaryKey] found on your momo profile
	 *@param String [sandbox,live]
	 *@param String $apiVersion
	 *@param String $base_uri
	 *@internal
	 */
	public function __construct(array $config)
	{

		$this->parseSettings($config)
			->genHeaders();
		$this->_client = new Client(
			[
				'base_uri' => $this->getSetting(Constants::BASE_KEY),
				'verify' => false,
				'timout' => 40
			]
		);
	}
	private function parseSettings($config)
	{
		$this->user_settings = $config;
		return $this;
	}

	public function setDatabase(Bootstraper $db)
	{
		$this->db = $db;
		return $this;
	}
	final protected function addUserSetting($key, $value)
	{
		$this->user_settings[$key] = $value;
		return $this;
	}


	final protected function addSetting($key, $value)
	{
		if (isset($this->default_settings[$key])) {
			$this->default_settings[$key] = $value;
		}
		return $this;
	}
	public function gen_uuid()
	{
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff)
		);
	}
	public function uuid4()
	{
		try {
			$uuid4 = Uuid::uuid4();
			return $uuid4->toString();
		} catch (UnsatisfiedDependencyException $e) {
			$err = $e->getMessage();
			return $this->gen_uuid();
		}
	}
	private function genHeaders()
	{
		$this->setHeaders(Constants::H_ENVIRON, $this->getSetting(Constants::ENV_KEY) ?? 'sandbox');
		$this->setHeaders(Constants::H_C_TYPE, 'application/json');
		$this->setHeaders(Constants::H_OCP_APIM, $this->getPrimaryKey());
	}

	final public function getSetting($key)
	{
		if (isset($this->default_settings[$key])) {
			return $this->default_settings[$key];
		}
		return null;
	}
	final public function getPrimaryKey()
	{
		return $this->getSetting(Constants::PRI_KEY);
	}
	final public function getSecondaryKey()
	{
		return $this->getSetting(Constants::SEC_KEY);
	}
	public function setHeaders($key, $value)
	{
		$this->headers[$key] = $value;
		return $this;
	}

	public function setApiUserId($apiUserId)
	{
		return $this->addSetting(Constants::USER_KEY, $apiUserId);
	}
	public function setApiKey($apiKey)
	{
		return $this->addSetting(Constants::API_KEY, $apiKey);
	}
	public function setApiToken($apiToken)
	{
		return $this->addSetting(Constants::TOKEN_KEY, $apiToken);
	}
	public function passResponse(ResponseInterface $response)
	{

		if ($response !== null) {

			$output = [
				"status_code" => $response->getStatusCode(),
				"status_phrase" => $response->getReasonPhrase(),
			];
			$body = $response->getBody();
			$output['data'] = json_decode($body->getContents(), 1);
			return $output;
		}
		return false;
	}
	public function setAuth()
	{
		if (($token = (string) $this->getSetting(Constants::TOKEN_KEY)) !== "") {
			$this->setHeaders(Constants::H_AUTH, 'Bearer ' . $token);
			return $this;
		} else {

			$authKey = $this->getSetting(Constants::USER_KEY) . ':' . $this->getSetting(Constants::API_KEY);
			$this->setHeaders(Constants::H_AUTH, 'Basic ' . base64_encode($authKey));
		}
		return $this;
	}

	public function genRequest($mtd, $url, $body = false)
	{
		if (false === $body) {
			$this->removeHeader(Constants::H_C_TYPE);
			$request = new Request($mtd, $url, $this->headers);
		} else {
			$this->setHeaders(Constants::H_C_TYPE, 'application/json');
			if (is_array($body)) {
				$body = json_encode($body, JSON_UNESCAPED_SLASHES);
			}
			$this->setHeaders("Content-Length", strlen($body));

			$request = new Request($mtd, $url, $this->headers, $body);
		}
		return $request;
	}
	public function send(Request $request)
	{
		$promise = $this->_client->sendAsync($request)
			->then(function (ResponseInterface $res) {
				// echo(Psr7\str($res));	
				return $this->passResponse($res);
			}, function (RequestException $e) {
				// echo(Psr7\str($e->getRequest())."\n\r");	
				if ($e->hasResponse()) {
					// echo(Psr7\str($e->getResponse())."\n\r");		
					return $this->passResponse($e->getResponse());
				}
				return [
					'status_code' => $e->getCode(),
					'status_phrase' => "Connection Error"
				];
			});
		return  $promise->wait();
	}
	public function removeHeader($key)
	{
		if (!array_key_exists($key, $this->headers)) {
			return $this;
		}
		unset($this->headers[$key]);
		return $this;
	}

	private function genLinks()
	{
		$backend = $this->getSetting(Constants::BASE_KEY) . $this->getSetting(Constants::PRODUCT_KEY);
		$this
			->addSetting(Constants::BAL_URI, $backend . '/' . $this->getSetting(Constants::VER_KEY) . '/' . MomoLinks::BALANCE_URI)
			->addSetting(Constants::USER_URI, $this->getSetting(Constants::BASE_KEY) .  $this->getSetting(Constants::VER_KEY) . '/' .  MomoLinks::USER_URI)
			->addSetting(Constants::ACC_HOLDER, $backend . '/' . $this->getSetting(Constants::VER_KEY) . '/' . MomoLinks::ACOUNT_HOLDER_URI)
			->addSetting(Constants::TOKEN_URI, $backend . '/' . MomoLinks::TOKEN_URI);

		if ($this->getSetting(Constants::PRODUCT_KEY) === 'collection') {
			$this->addSetting(Constants::REQ_URI, $backend . $this->getSetting(Constants::VER_KEY) . '/' . MomoLinks::REQUEST_TO_PAY_URI);
		} else {
			$this->addSetting(Constants::REQ_URI, $backend . $this->getSetting(Constants::VER_KEY) . '/' . MomoLinks::TRANSFER_URI);
		}
		return $this;
	}
}
