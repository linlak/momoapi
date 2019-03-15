<?php
namespace Momo\MomoApp\Models;
/**
* 
*/
class TokenResponse extends MomoResponse
{
	private $is_created=false;
	private $access_token="";
	private $token_type="";
	private $expires_in=0;
	function __construct(array $response)
	{
		parent::__construct($response);
		$this->setToken();
	}
	private function setToken(){
		if ($this->status_code===200) {
			$this->is_created=$this->is_created=true;
			$this->access_token=$this->getData('access_token');
			$this->token_type=$this->getData('token_type');
			$this->expires_in=$this->getData('expires_in');
		}
	}
	public function isCreated(){
		return $this->is_created;
	}
	public function getAccessToken(){
		return $this->access_token;
	}
	public function getTokenType(){
		$this->token_type;
	}
	public function getExpiresIn(){
		return $this->expires_in;
	}
}