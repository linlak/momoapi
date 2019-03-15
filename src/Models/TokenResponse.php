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
	private function setToken(){}
	public function isCreated(){
		return $this->is_created;
	}
	public function getAccessToken(){}
	public function getTokenType(){}
	public function getExpiresIn(){}
}