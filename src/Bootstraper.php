<?php
namespace Momo\MomoApp;
use Momo\MomoApp\Products\Collection;
use Momo\MomoApp\Products\Remittances;
use Momo\MomoApp\Products\Disbursements;
use Momo\MomoApp\Products\ApiUser;
use Momo\MomoApp\Data\Database;
class Bootstraper extends Database
{
		
	private $environ="sandbox";
	private $dbName="";
	private $tables=['momo_api_user','momo_payment_queue','momo_access_tokens'];
	private $found_tables=[];
	function __construct($host,$dbName,$dbUser,$dbPass,$environ='sandbox')
	{
		parent::__construct($host,$dbName,$dbUser,$dbPass);
		$this->environ=$environ;
		$this->dbName=$dbName;
		$this->createTables();
	}
	public function initCollection($apiKey,$apiSecret)
	{
		# code...
	}
	public function initRemittances($apiKey,$apiSecret)
	{
		# code...
	}
	public function initDisbursements($apiKey,$apiSecret)
	{
		# code...
	}
	private function createTables(){
		/*CREATE TABLE IF NOT EXISTS `momo_api_user` (
					  `admin_id` int(11) NOT NULL,
					  `user_id` int(11) NOT NULL,
					  `admin_post` varchar(255) NOT NULL,
					  `lastVisted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `admin_level` enum('a','b','c','d') NOT NULL DEFAULT 'a'
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;
				CREATE TABLE IF NOT EXISTS `momo_payment_queue` (
					  `admin_id` int(11) NOT NULL,
					  `user_id` int(11) NOT NULL,
					  `admin_post` varchar(255) NOT NULL,
					  `lastVisted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `admin_level` enum('a','b','c','d') NOT NULL DEFAULT 'a'
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;
					ALTER TABLE `wash_bays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bay_link` (`bay_link`),
  ADD KEY `user_id` (`user_id`);
					*/
  $sql1="SELECT TABLE_NAME as table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=:table_schema";
  	$this->query($sql1);
	$this->bind(':table_schema',$this->dbName);
	if ($fd=$this->resultSet()) {
		foreach ($fd as $key => $value) {
			array_push($this->found_tables, $value['table_name']);
		}
	}
		$sql="";
		if (!in_array("momo_api_user", $this->found_tables)) {
			$sql.=" 

				CREATE TABLE  `momo_api_user` (
					  `uuid` varchar(100) NOT NULL,
					  `api_primary` varchar(255) NOT NULL,
					  `api_secondary` varchar(255) NOT NULL,
					  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `api_key` varchar(255)  NULL
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

					CREATE TABLE  `momo_access_tokens` (
					  `uuid` varchar(100) NOT NULL,
					  `access_token` TEXT NULL,
					  `token_type` TEXT NULL,
					  `expires_in`  int(11) NOT NULL DEFAULT 0,
					  `started_at`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `expires_at`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

				ALTER TABLE `momo_api_user` 
				ADD PRIMARY KEY (`uuid`),
				ADD UNIQUE KEY `api_primary` (`api_primary`),
				ADD UNIQUE KEY `api_secondary` (`api_secondary`),
				ADD UNIQUE `unique_user` (`api_primary`, `api_secondary`) USING BTREE;

				ALTER TABLE `momo_access_tokens` 
				ADD PRIMARY KEY (`uuid`);

				ALTER TABLE `momo_access_tokens`
  				ADD CONSTRAINT `fk_momo_token_api_uuid` FOREIGN KEY (`uuid`) REFERENCES `momo_api_user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
			";
			$sql.=$this->paymentsTable('momo_payment_queue','queue');
						
		}else{
			$sql.=$this->paymentsTable('momo_payment_queue','queue');
			// $sql.=$this->paymentsTable('momo_payment_queue','queue');
			// $sql.=$this->paymentsTable('momo_payment_queue','queue');
			// $sql.=$this->paymentsTable('momo_payment_queue','queue');
		}
		
echo "<pre>";
echo($sql);
			// $this->newtable($sql);
			
			// $this->debugDumpParams();
		// print_r(array_values($this->found_tables));

	}

	private function paymentsTable($tbName,$fkPrefix){
		$sql="";
		if (!in_array($tbName, $this->found_tables)) {
				$sql.=" 

						CREATE TABLE  `$tbName` (
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

							ALTER TABLE `momo_access_tokens`
  							ADD CONSTRAINT `fk_momo_".$fkPrefix."_api_uuid` FOREIGN KEY (`uuid`) REFERENCES `momo_api_user` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
					";	
			}
			return $sql;
	}
}