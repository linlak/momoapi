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
	private $apiToken='';
	protected $apiUserId='';
	protected $headers=[
		"Content-Length"=>0,
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
    			'timout'=>40
			
		]);
	} 
	public function gen_uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}
	private function genHeaders(){		
		$this->setHeaders(Constants::H_ENVIRON,$this->environ);
		$this->setHeaders(Constants::H_C_TYPE,'application/json');
		$this->setHeaders(Constants::H_OCP_APIM,$this->apiPrimaryKey);
	}
	public function setHeaders($key,$value){
		$this->headers[$key]=$value;
	}
	public function setApiUserId($apiUserId){
		$this->apiUserId=$apiUserId;
	}
	public function setApiKey($apiKey){
		$this->apiKey=$apiKey;
	}
	public function setApiToken($apiToken){
		$this->apiToken=$apiToken;
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
		if (""!==$this->apiToken) {
			$this->setHeaders(Constants::H_AUTH,$this->apiToken);
			return;
		}else{
		
			$authKey=$this->apiUserId.':'.$this->apiKey;
			$this->setHeaders(Constants::H_AUTH,'Basic '.base64_encode($authKey));
		}
	}

	public function genRequest($mtd,$url,$body=false){
		if (false===$body) {
			$this->removeHeader(Constants::H_C_TYPE);
			$request=new Request($mtd,$url,$this->headers);
		}else{
			$this->setHeaders(Constants::H_C_TYPE,'application/json');
			if (is_array($body)) {
				$body=json_encode($body,JSON_UNESCAPED_SLASHES);				
			}
			$this->setHeaders("Content-Length",strlen($body));

			$request=new Request($mtd,$url,$this->headers, $body);
		}
		return $request;
	}
	public function send(Request $request){
		
		$promise=$this->_client->sendAsync($request)
			->then(function (ResponseInterface $res){
			// echo(Psr7\str($res));	
				return $this->passResponse($res);
			}, function (RequestException $e){	
			echo(Psr7\str($e->getRequest())."\n\r");	
				if ($e->hasResponse()) {		
						// echo(Psr7\str($e->getResponse())."\n\r");		
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