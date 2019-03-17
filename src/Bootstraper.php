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
	private $tables=['momo_api_user','momo_payment_queue'];
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
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8;CREATE TABLE IF NOT EXISTS `momo_payment_queue` (
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
					  `access_token` TEXT NULL,
					  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  `api_key` varchar(255)  NULL
					) ENGINE=InnoDB DEFAULT CHARSET=armscii8; 

				ALTER TABLE `momo_api_user` 
				ADD PRIMARY KEY (`uuid`),
				ADD UNIQUE KEY `api_primary` (`api_primary`),
				ADD UNIQUE KEY `api_secondary` (`api_secondary`),
				ADD UNIQUE `unique_user` (`api_primary`, `api_secondary`) USING BTREE;
			";

			if (in_array('momo_payment_queue', $this->found_tables)) {
					$sql.=" 

						CREATE TABLE  `momo_payment_queue` (
							  ``
							  `uuid` varchar(100) NOT NULL,
							  `api_primary` varchar(255) NOT NULL,
							  `api_secondary` varchar(255) NOT NULL,
							  `access_token` TEXT NULL,
							  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
							  `api_key` varchar(255)  NULL
							) ENGINE=InnoDB DEFAULT CHARSET=armscii8; 
					";
			}
		}
		
echo "<pre>";
echo($sql);
			// $this->newtable($sql);
			
			// $this->debugDumpParams();
		// print_r(array_values($this->found_tables));

	}
}