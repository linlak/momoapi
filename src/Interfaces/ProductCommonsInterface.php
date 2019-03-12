<?php
namespace Momo\MomoApp\Interfaces;

interface ProductCommonsInterface{
	
	public function requestToken();
	public function requestBalance();
	public function acountHolder($accountHolderIdType,$accountHolderId);
	
}