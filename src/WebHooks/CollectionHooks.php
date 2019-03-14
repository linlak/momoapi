<?php
namespace Momo\MomoApp\WebHooks;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
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
	public function reqisterHook(){}
}
