<?php 
namespace Momo\MomoApp;
use GuzzleHttp\Client;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
abstract class MomoApp{

	protected $environ="sandbox";//live
	protected $apiVersion='v1_0';
	protected $baseUri = 'https://ericssonbasicapi2.azure-api.net/';
	protected $apiKey,$apiSecret;
	protected $apiUserId='';
	protected $headers=[
		Constants::H_AUTH=>"",
		Constants::H_ENVIRON=>"",
		Constants::H_OCP_APIM=>""
	];
	private $_client;
	public function __construct($apiKey,$apiSecret,$environ='sandbox'){
		$this->apiKey=$apiKey;
		$this->apiSecret=$apiSecret;
		$this->environ=$environ;
		$this->genHeaders();
		$this->_client=new Client(
			[
				'base_uri'=>MomoLinks::BASE_URI,
    			'verify' => false,
    			'timout'=>40
			
		]);
	} 
	private function genHeaders(){		
		$this->setHeaders(Constants::H_ENVIRON,$this->environ);
		$this->setHeaders(Constants::H_C_TYPE,'application/json');
		$this->setHeaders(Constants::H_OCP_APIM,$this->apiKey);
	}
	public function setHeaders($key,$value){
		$this->headers[$key]=$value;
	}
	protected function setAuth(){
		$this->setHeaders(Constants::H_AUTH,base64_encode($this->apiKey));
	}


	public function send(Request $request){
		try {
			return $this->_client->send($request);
		} catch (RequestException $e) {
			echo Psr7\str($e->getRequest());
		    if ($e->hasResponse()) {
		        echo Psr7\str($e->getResponse());
		    }
		}
	}
	public function removeHeader($key){
		if (!array_key_exists($key, $this->headers)) {
			return;
		}
		unset($this->headers[$key]);
	}
	
	

}