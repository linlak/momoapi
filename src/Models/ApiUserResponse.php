<?php
namespace Momo\MomoApp\Models;
/**
* 
*/
class ApiUserResponse extends MomoResponse
{
	private $uid="";
	private $user_exists=false;
	private $is_created=false;
	
	function __construct(array $response,$uid)
	{
		parent::__construct($response);
		$this->uid=$uid;
		$this->getUser();
		
	}
	private function getUser(){
		if ($this->status_code===201||$this->status_code===200) {
			$this->is_created=true;
			$this->user_exists=true;
			
		}
	}
	public function getUid(){
		return $this->uid;
	}
	public function isUser(){
		return $this->user_exists;
	}
	public function isCreated(){
		return $this->is_created;
	}
	
}