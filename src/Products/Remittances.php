<?php
namespace Momo\MomoApp\Products;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
/**
* 
*/
class Remittances extends MomoApp
{
	
	function __construct($apiKey,$apiSecret,$environ='sandbox')
	{
		parent::__construct($apiKey,$apiSecret,$environ);
	}
}