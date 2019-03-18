<?php
namespace Momo\MomoApp;
/**
*Copyright (c) 2019, LinWorld Tech Solutions.
*
*All rights reserved.
*
*Redistribution and use in source and binary forms, with or without
*modification, are permitted provided that the following conditions are met:
*
*    * Redistributions of source code must retain the above copyright
*      notice, this list of conditions and the following disclaimer.
*
*    * Redistributions in binary form must reproduce the above
*      copyright notice, this list of conditions and the following
*      disclaimer in the documentation and/or other materials provided
*      with the distribution.
*
*    * Neither the name of LinWorld Tech Solutions nor the names of other
*      contributors may be used to endorse or promote products derived
*      from this software without specific prior written permission.

*THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
*"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
*LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
*A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
*OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
*SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
*LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
*DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
*THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
*(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
*OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
use Momo\MomoApp\Products\Collection;
use Momo\MomoApp\Products\Remittances;
use Momo\MomoApp\Products\Disbursements;
use Momo\MomoApp\Data\Database;
class Bootstraper extends Database
{
		
	private $environ="sandbox";
	private $dbName="";
	private $cCallback="";
	private $dCallback="";
	private $rCallback="";
	private $tables=[
		'momo_api_user',
		'momo_payment_queue',
		'momo_access_tokens',
		'momo_payment_success',
		'momo_payment_failed'
	];
	private $found_tables=[];
	function __construct($host,$dbName,$dbUser,$dbPass,$environ='sandbox')
	{
		parent::__construct($host,$dbName,$dbUser,$dbPass);
		$this->environ=$environ;
		$this->dbName=$dbName;
		$this->createTables();
	}
	public function initCollection($api_primary,$api_secondary,$callBackUrl)
	{
		$this->cCallback=$callBackUrl;
		$momo=new Collection($api_primary,$api_secondary,$this->environ);
		$momo->setDatabase($this);
		if ($apiUser=$this->checkUser($api_primary,$api_secondary)) {
			if ($apiUser==="no_tables") {
				return null;
			}
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}

				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;
		}else{
			if ($apiUser=$this->insertNewApiUser($momo, $api_primary,$api_secondary,"Collection")) {
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}

				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;
			}
		}
		return null;
	}

	public function initRemittances($api_primary,$api_secondary,$callBackUrl)
	{
		$this->rCallback=$callBackUrl;
		$momo=new Remittances($api_primary,$api_secondary,$this->environ);
		$momo->setDatabase($this);
		if ($apiUser=$this->checkUser($api_primary,$api_secondary)) {
			if ($apiUser==="no_tables") {
				//throw expcetion
				return null;
			}
			
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}

				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;
		}else{
			if ($apiUser=$this->insertNewApiUser($momo, $api_primary,$api_secondary,"Remittances")) {
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}
				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;
			}
		}
		// need to throw exception
		return null;
	}
	public function initDisbursements($api_primary,$api_secondary,$callBackUrl)
	{
		$this->dCallback=$callBackUrl;
		$momo=new Disbursements($api_primary,$api_secondary,$this->environ);
		$momo->setDatabase($this);
		if ($apiUser=$this->checkUser($api_primary,$api_secondary)) {
			if ($apiUser==="no_tables") {
				return $momo;
			}
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}

				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;

		}else{
			if ($apiUser=$this->insertNewApiUser($momo, $api_primary,$api_secondary,"Disbursements")) {
				$momo->setApiUserId($apiUser['uuid']);
				
				$momo->setApiUserId($apiUser['uuid']);
				if ((string)$apiUser['api_key']==="") {
					
					if ($apiUser=$this->getApiKey($momo,$api_primary,$api_secondary)) {
						$momo->setApiKey($apiUser['api_key']);
					}
				}else{

					$momo->setApiKey($apiUser['api_key']);
					
				}
				return $momo;
			}
		}
		return $momo;
	}

	private function insertNewApiUser(MomoApp $momo,$api_primary,$api_secondary,$product){	
		$cBackUrl="";	
		switch ($product) {
			case 'Collection':
				$cBackUrl=$this->cCallback;
				break;
			case 'Disbursements':
				$cBackUrl=$this->dCallback;
				break;
			case 'Remittances':
				$cBackUrl=$this->rCallback;
				break;
		}
		if ($res=$momo->createApiUser($cBackUrl)) {
			if ($res->isCreated()) {
				$sql="INSERT INTO momo_api_user (uuid,api_primary,api_secondary,product,callback_url) VALUES (:uuid,:api_primary,:api_secondary,:product,:callback_url) ON DUPLICATE KEY UPDATE uuid=:uuid, api_primary=:api_primary,api_secondary=:api_secondary,product=:product,api_key=null";
				$this->query($sql);
				$this->bind(':uuid',$res->getUid());
				$this->bind(':api_primary',$api_primary);
				$this->bind(':api_secondary',$api_secondary);
				$this->bind(':product',$product);
				$this->bind(':callback_url',$cBackUrl);
				if($this->execute()){
				if($apiUser=$this->checkUser($api_primary,$api_secondary))
					{
						return $apiUser;
					}
				}
			}
		}
		return false;
	}
	private function checkUser($api_primary,$api_secondary){
		if (in_array('momo_api_user', $this->found_tables)) {			
			$sql="SELECT a.uuid,a.api_primary,a.api_secondary,a.product,a.created_at,a.updated_at,a.api_key,a.callback_url FROM momo_api_user a WHERE a.api_primary=:api_primary AND a.api_secondary=:api_secondary";
			$this->query($sql);
			$this->bind(':api_primary',$api_primary);
			$this->bind('api_secondary',$api_secondary);
			return $this->single();
		}else{
			return 'no_tables';
		}
		
	}
	private function loadExists(){
		$sql1="SELECT TABLE_NAME as table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=:table_schema";
	  	$this->query($sql1);
		$this->bind(':table_schema',$this->dbName);
		if ($fd=$this->resultSet()) {
			for ($i=0;$i<count($fd);$i++) {
				array_push($this->found_tables, $fd[$i]['table_name']);
			}
		}
	}
	private function createTables(){
  		$this->loadExists();
		$sql="";
		if (!in_array("momo_api_user", $this->found_tables)) {
			$sql.=" 

				CREATE TABLE  `momo_api_user` (
					  `uuid` varchar(100) NOT NULL,
					  `api_primary` varchar(255) NOT NULL,
					  `api_secondary` varchar(255) NOT NULL,
					  `product` varchar(255) NOT NULL,
					  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `api_key` varchar(255)  NULL,
					  `callback_url` varchar(255) NULL
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

					CREATE TABLE  `momo_access_tokens` (
					  `uuid` varchar(100) NOT NULL,
					  `access_token` TEXT NULL,
					  `token_type` TEXT NULL,
					  `expires_in`  int(11) NOT NULL DEFAULT '0',
					  `started_at`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `expires_at`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

				ALTER TABLE `momo_api_user` 
				ADD PRIMARY KEY (`uuid`),
				ADD UNIQUE KEY `api_primary` (`api_primary`),
				ADD UNIQUE KEY `api_secondary` (`api_secondary`),
				ADD UNIQUE `unique_user` (`api_primary`, `api_secondary`) USING BTREE;

				ALTER TABLE `momo_access_tokens` 
				ADD PRIMARY KEY (`uuid`);

				ALTER TABLE `momo_access_tokens`
  				ADD CONSTRAINT `fk_momo_token_api_uuid` FOREIGN KEY (`uuid`)
  				 REFERENCES `momo_api_user` (`uuid`) 
  				 ON DELETE CASCADE ON UPDATE CASCADE;

			";
			$sql.=$this->paymentsTable('momo_payment_queue','queue');						
			$sql.=$this->paymentsTable('momo_payment_success','success');
			$sql.=$this->paymentsTable('momo_payment_failed','failed');
			// $sql.=$this->paymentsTable('momo_payment_queue','queue');
		}else{
			$sql.=$this->paymentsTable('momo_payment_queue','queue');						
			$sql.=$this->paymentsTable('momo_payment_success','success');
			$sql.=$this->paymentsTable('momo_payment_failed','failed');
			// $sql.=$this->paymentsTable('momo_payment_queue','queue');
		}
		$sql=(string)trim($sql);

		if ($sql!=="") {
			$this->newtable($sql);
				$this->loadExists();
				
		}
	}

	private function paymentsTable($tbName,$fkPrefix){
		$sql="";
		if (!in_array($tbName, $this->found_tables)) {
				$sql.=" CREATE TABLE  `$tbName` (
							  `referenceId` varchar(100) NOT NULL, 
							  `uuid` varchar(100) NOT NULL,
							  `amount` varchar(255) NOT NULL,
							  `partyIdType` varchar(255) NOT NULL,
							  `partyId` varchar(255) NOT NULL,
							  `currency` varchar(255) NOT NULL,
							  `externalId` varchar(100) NOT NULL,
							  `payerMessage` TEXT  NULL,
							  `payeeNote` TEXT  NULL,
							  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
							  `reason` TEXT  NULL,
							  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
							) ENGINE=InnoDB DEFAULT CHARSET=armscii8; 

							ALTER TABLE `$tbName` 
							ADD PRIMARY KEY (`referenceId`),
							ADD KEY `uuid` (`uuid`);

							ALTER TABLE `$tbName`
  							ADD CONSTRAINT `fk_momo_".$fkPrefix."_api_uuid` 
  							FOREIGN KEY (`uuid`) REFERENCES `momo_api_user` (`uuid`) 
  							ON DELETE CASCADE ON UPDATE CASCADE;
					";	
			}
			return $sql;
	}
	private function getApiKey(MomoApp $momo,$api_primary,$api_secondary){
		if ($res=$momo->getApikey()) {
			if ($res->isUser()) {
				if($this->saveApiKey($api_primary,$api_secondary,$res->getApiKey())){
					return $this->checkUser($api_primary,$api_secondary);
				}
			}
		}
		return false;
	}
	private function saveApiKey($api_primary,$api_secondary,$api_key){
		if($apiUser = $this->checkUser($api_primary,$api_secondary)){
			$user=['api_key'=>$api_key];
			return $this->genUpdate('momo_api_user',$user,['uuid'=>$apiUser['uuid']],1);
		}
	}

	public function saveApiToken(TokenResponse $response,$api_primary,$api_secondary){
		if ($response->isCreated()) {
			if ($apiUser=$this->checkUser($api_primary,$api_secondary)) {
				$sql="INSERT INTO momo_access_tokens (uuid,access_token,token_type,expires_in,expires_at) VALUES (:uuid,:access_token,:token_type,:expires_in,DATE_ADD(NOW(),INTERVAL :expires_in SECOND)) ON DUPLICATE KEY UPDATE access_token=:access_token,token_type=:token_type,expires_in=:expires_in,started_at=NOW(),expires_at=DATE_ADD(NOW(),INTERVAL :expires_in SECOND)";
				$this->query($sql);
				$this->bind(':access_token',$response->getAccessToken());
				$this->bind(':token_type',$response->getTokenType());
				$this->bind(':expires_in',$response->getExpiresIn());
				$this->bind(':uuid',$apiUser['uuid']);
				if ($this->execute()) {
					return true;
				}
			}
		}
		return false;
	}
}