<?php

class Config_pcare{

	var $smtphost;
	var $dbhost;
	var $dbport;
	var $dbname;
	var $dbuser;
	var $version;
	
	function __construct() {

		$this->dbhost	= '192.168.1.155';
		$this->dbport 	= '3306';
		$this->dbname	= 'aswini_hims';
		$this->dbuser	= 'root';
		$this->dbpass	= '';
		$this->branch_id= '1'; //branch_id from pcare table.
		$this->version = 'HCARE 1.0';
	}


}




?>
