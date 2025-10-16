<?php

class Config{

	var $smtphost;
	var $dbhost;
	var $dbport;
	var $dbname;
	var $dbuser;
	var $version;
	
	function __construct() {

		$this->dbhost	= 'localhost';
		$this->dbport 	= '3306';
		$this->dbname	= 'ask';
		$this->dbuser	= 'root';
		$this->dbpass	= 'ask123*#';
		$this->version = 'HCARE 1.0';
	}


}

?>
