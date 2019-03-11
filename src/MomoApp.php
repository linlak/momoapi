<?php 
namespace Momo\MomoApp;
use GuzzleHttp\Client;
use Momo\MomoApp\Models\RequestToPay;
use Momo\MomoApp\Commons\MomoLinks;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
abstract class MomoApp{

	protected $environ="sandbox";//live
	protected $apiVersion='v1_0';
	protected $baseUri = 'https://ericssonbasicapi2.azure-api.net/';
	protected $apiKey,$apiSecret;
	protected $headers=[
		"Authorization"=>"",
		"X-Target-Environment"=>"",
		"Ocp-Apim-Subscription-Key"=>""
	];
	protected $_client;
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
		$this->setHeaders('Authorization',base64_encode($this->apiKey));
		$this->setHeaders('X-Target-Environment',$this->environ);
		$this->setHeaders('Content-Type','application/json');
		$this->setHeaders('Ocp-Apim-Subscription-Key',$this->apiKey);
	}
	public function setHeaders($key,$value){
		$this->headers[$key]=$value;
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
		unset($this->headers[$key]);
	}
	
	

}