<?php
namespace Momo\MomoApp\Models;
/**
* [status_code] => 202
    [status_phrase] => Accepted
    [data] => 
*/
class RequestToPayResponse extends MomoResponse
{
	private $is_accepted=false;//202 
	private $is_duplicate=false;//409
	private $resource_exists=false;//200 
	private $requestStatus;/*"PENDING",
        "SUCCESSFUL",
        "FAILED"*/
	function __construct(array $response)
	{
		parent::__construct($response);
		
	}
	public function getRequestStatus(){
		return $this->requestStatus;
	}
}