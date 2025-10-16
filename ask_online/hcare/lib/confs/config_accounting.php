<?php

class Config_accounting{

	var $smtphost;
	var $dbhost;
	var $dbport;
	var $dbname;
	var $dbuser;
	var $version;
	
	function __construct() {

date_default_timezone_set('Asia/Kolkata');

$this_year = date('y');

$last_year = date('y', strtotime('-1 year'));

$next_year = date('y', strtotime('+1 year'));

$today = date("Y-m-d");

// $this_year_end = date("Y-03-t");

$this_year_end = date("Y-04-01");

if ($today <= $this_year_end) {
	$db_name = "ask_accounting".$last_year.$this_year;
}
else{
	$db_name = "ask_accounting".$this_year.$next_year;
}

		$this->dbhost	= 'localhost';
		$this->dbport 	= '3306';
		$this->dbname	= $db_name;
		$this->dbuser	= 'root';
		$this->dbpass	= 'ask123*#';
		$this->version = 'HCARE 1.0';
	}


}




?>
