<?php
namespace Momo\MomoApp\Models;

class ApiKeyResponse extends ApiUserResponse
{
	private $apiKey="";
	function __construct(array $response,$uid)
	{
		parent::__construct($response,$uid);
		$this->initKey();
	}
	private function initKey(){
		if ($this->isUser()) {
			$this->apiKey=$this->getData('apiKey');
		}
	}
	public function getApiKey(){
		return $this->apiKey;
	}
}