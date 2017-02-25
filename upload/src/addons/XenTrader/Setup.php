<?php

namespace XenTrader;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
	{
		$db = $this->db();
		$schemaManager = $db->getSchemaManager();
		$defaultTableConfig = $schemaManager->getTableConfigSql();

		$this->query("
	        CREATE TABLE `xf_xentrader_feedback` (
	            `feedback_id` INT(10) NOT NULL AUTO_INCREMENT,
            	`from_user_id` INT(10) UNSIGNED NOT NULL,
            	`from_username` VARCHAR(50) NOT NULL,
            	`to_user_id` INT(10) UNSIGNED NOT NULL,
            	`to_username` VARCHAR(50) NOT NULL,
            	`thread_id` INT(10) NOT NULL,
            	`thread_title` VARCHAR(150) NOT NULL,
            	`feedback` VARCHAR(80) NOT NULL,
            	`rating` TINYINT(1) NOT NULL,
            	`type` ENUM('buy','sell','trade') NOT NULL,
            	`feedback_date` INT(10) UNSIGNED NOT NULL,
	            PRIMARY KEY (`feedback_id`)
	        ) {$defaultTableConfig}
    	");
	}

	public function uninstallStep1()
	{
		$this->query("
	        DROP TABLE `xf_xentrader_feedback`;
    	");
	}
}