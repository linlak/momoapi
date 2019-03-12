<?php
namespace Momo\MomoApp\Interfaces;

interface ProductCommonsInterface{
	
	public function requestToken($apiUserId);
	public function requestBalance();
	public function acountHolder($accountHolderIdType,$accountHolderId);
	
}