<?php
namespace Momo\MomoApp\Models;
/**
* 
*/
class BalanceResponse extends MomoResponse
{
	private $is_found=false;
	private $availableBalance=0;
	private $currency="EUR";
	function __construct(array $response)
	{
		parent::__construct($response);
		$this->setBalance();
	}
	private function setBalance(){
		if ($this->status_code===200) {
			$this->is_found=true;
			$this->balance=$this->getData('availableBalance');
			$this->currency=$this->getData('currency');
		}
	}
	public function getAvailableBalance(){
		return $this->availableBalance;
	}
	public function isFound(){
		return $this->is_found;
	}
	public function getCurrency(){
		return $this->currency;
	}
}