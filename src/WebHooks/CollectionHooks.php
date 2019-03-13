<?php
namespace Momo\MomoApp\WebHooks;
use Momo\MomoApp\MomoApp;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Momo\MomoApp\Products\Collection;
/**
* genRequest
*/
class CollectionHooks 
{
	private $collection;
	function __construct(Collection $collection)
	{
		$this->collection=$collection;
	}

}