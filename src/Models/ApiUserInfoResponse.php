<?php

namespace Momo\MomoApp\Models;
class ApiUserInfoResponse extends ApiUserResponse
{
	private $providerCallbackHost="";
	private $targetEnvironment="sandbox";
	function __construct(array $response,$uid)
	{
		parent::__construct($response,$uid);
		$this->parseInfo();
	}
	private function parseInfo(){
		if ($this->isUser()) {
			$this->providerCallbackHost=$this->getData("providerCallbackHost");
			$this->targetEnvironment=$this->getData('targetEnvironment');
		}
	}
	public function getProviderCallbackHost(){
		return $this->providerCallbackHost;
	}
	public function getTargetEnvironment(){
		return $this->targetEnvironment;
	}
}