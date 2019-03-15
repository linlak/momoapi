<?php
namespace Momo\MomoApp\Models;
/**
* 
*/
abstract class MomoResponse 
{
	protected $response=[];
	protected $data=[];
	protected $status_code=0;
	protected $status_phrase="Network error";
	function __construct(array $response)
	{
		$this->response=$response;
		$this->parseResponse();
	}
	private function parseResponse(){
		if (array_key_exists("status_code", $this->response)) {
			$this->status_code=$this->response['status_code'];
			$this->status_phrase=$this->response['status_phrase'];
			if (array_key_exists("data", $this->response)) {
				$data=$this->response['data'];
				if (is_array($data)&&!empty($data)) {
					$this->data=$data;
				}
			}
		}
	}
	public getData($key){
		if (is_array($key)||!array_key_exists($key, $this->data)) {
			return "";
		}
		return $this->data[$key];
	}
}