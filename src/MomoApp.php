<?php 
namespace Momo\MomoApp;
use GuzzleHttp\Client;
use Momo\MomoApp\Interfaces\MomoInterface;
use Momo\MomoApp\Commons\MomoLinks;
use Momo\MomoApp\Commons\Constants;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
abstract class MomoApp implements MomoInterface{

	protected $environ="sandbox";//live
	protected $apiVersion='v1_0';
	protected $baseUri = 'https://ericssonbasicapi2.azure-api.net/';
	protected $apiPrimaryKey,$apiSecondary;
	protected $apiKey='';
	protected $apiUserId='';
	protected $headers=[
		Constants::H_AUTH=>"",
		Constants::H_ENVIRON=>"",
		// Constants::H_REF_ID=>"",
		Constants::H_C_TYPE=>"",
		Constants::H_OCP_APIM=>""
	];
	private $_client;
	/**
	*@param String [primaryKey] found on your momo profile
	*@param String [secondaryKey] found on your momo profile
	*@param String [sandbox,live]
	*@internal
	*/
	public function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox'){
		$this->apiPrimaryKey=$apiPrimaryKey;
		$this->apiSecondary=$apiSecondary;
		$this->environ=$environ;
		$this->genHeaders();
		$this->_client=new Client(
			[
				'base_uri'=>MomoLinks::BASE_URI,
    			'verify' => false,
    			'timout'=>40,
    			'allow_redirects' => false
			
		]);
	} 
	private function genHeaders(){		
		$this->setHeaders(Constants::H_ENVIRON,$this->environ);
		$this->setHeaders(Constants::H_C_TYPE,'application/json');
		$this->setHeaders(Constants::H_OCP_APIM,$this->apiPrimaryKey);
	}
	public function setHeaders($key,$value){
		$this->headers[$key]=$value;
	}
	public function setApiKey($apiKey){
		$this->apiKey=$apiKey;
	}
	public function passResponse(ResponseInterface $response){
		
		if ($response!==null) {

			$output=[
				"status_code"=>$response->getStatusCode(),
				"status_phrase"=>$response->getReasonPhrase(),				
			];
			$body=$response->getBody();
			$output['data']=json_decode($body->getContents(),1);
			return $output;
		}
		return false;
	}
	public function setAuth(){
		$this->setHeaders(Constants::H_AUTH,base64_encode($this->apiPrimaryKey));
	}

	public function genRequest($mtd,$url,$body=false){
		if (false==$body) {
			$request=new Request($mtd,$url,$this->headers);
		}else{
			if (is_array($body)) {
				$body=json_encode($body,JSON_UNESCAPED_SLASHES);
			}
			$request=new Request($mtd,$url,$this->headers, $body);
		}
		return $request;
	}
	public function send(Request $request){
		
		$promise=$this->_client->sendAsync($request)
			->then(function (ResponseInterface $res){

				return $this->passResponse($res);
			}, function (RequestException $e){	
			echo(Psr7\str($e->getRequest()));			
				if ($e->hasResponse()) {					
					return $this->passResponse($e->getResponse());
				}
				return [
					'status_code'=>$e->getCode(),
					'status_phrase'=>"Connection Error"
				];
				

		});
		return  $promise->wait();
		
	}
	public function removeHeader($key){
		if (!array_key_exists($key, $this->headers)) {
			return;
		}
		unset($this->headers[$key]);
	}
	
	

}