<?php
namespace Momo\MomoApp\Interfaces;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

interface MomoInterface{
	public function setHeaders($key,$value);
	public function removeHeader($key);
	public function send(Request $request);
	public function genRequest($mtd,$url,$body=false);
	public function setAuth();
	public function gen_uuid();
	public function setApiKey($apiKey);
	public function passResponse(ResponseInterface $response);
}