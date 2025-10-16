<?php 
define('ROOT_PATH', dirname(__FILE__));
date_default_timezone_set('Asia/Kolkata');

// require_once ROOT_PATH . '/lib/model/billing/billing.php';
// require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
// require_once ROOT_PATH . '/lib/model/admin/user.php';
// require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';
require_once ROOT_PATH . '/lib/model/admin/accounting.php';

// CREATE NEW ACCOUNTING DATABASE IN EVERY FINANCIAL YEAR APRIL 1

$acc_obj_new = new AccountingModel();

$host     = $acc_obj_new->dbConnection->myHost;
$port     = $acc_obj_new->dbConnection->myHostPort;
$username = $acc_obj_new->dbConnection->userName;
$password = $acc_obj_new->dbConnection->userPassword;
$db_name  = $acc_obj_new->dbConnection->db_name;

$this_year = date("y");
$next_year = date("y", strtotime('+1 year'));
$account_label = "ask$this_year$next_year";

$db_name_new = "ask_accounting$this_year$next_year";

$this_year = date("Y");
$next_year = date("Y", strtotime('+1 year'));

$fy_start      = $this_year.'-'.date("04-01 00:00:00");
$fy_end        = $next_year.'-'.date("03-31 23:59:59");

// var_dump($fy_start,$fy_end);exit;

$settingInfo = $acc_obj_new->getSettings();

$data_account_label               = $account_label;
$data_account_name                = $data_account_label;
$data_account_address             = $settingInfo['address'];
$data_account_email               = $settingInfo['email'];
$data_fy_start                    = $fy_start;
$data_fy_end                      = $fy_end;
$data_account_currency            = $settingInfo['currency_symbol'];
$data_account_date                = $settingInfo['date_format'];
$data_account_timezone            = $settingInfo['timezone'];
$data_account_manage_inventory    = $settingInfo['manage_inventory'];
$data_account_account_locked      = $settingInfo['account_locked'];
$data_account_email_protocol      = $settingInfo['email_protocol'];
$data_account_email_host          = $settingInfo['email_host'];
$data_account_email_port          = $settingInfo['email_port'];
$data_account_email_username      = $settingInfo['email_username'];
$data_account_email_password      = $settingInfo['email_password'];
$data_account_print_paper_height  = $settingInfo['print_paper_height'];
$data_account_print_paper_width   = $settingInfo['print_paper_width'];
$data_account_print_margin_top    = $settingInfo['print_margin_top'];
$data_account_print_margin_bottom = $settingInfo['print_margin_bottom'];
$data_account_print_margin_left   = $settingInfo['print_margin_left'];
$data_account_print_margin_right  = $settingInfo['print_margin_right'];
$data_account_print_orientation   = $settingInfo['print_orientation'];
$data_account_print_page_format   = $settingInfo['print_page_format'];

$data_database_type     = 'mysql';
$data_database_host     = $host;
$data_database_port     = $port;
$data_database_name     = $db_name_new;
$data_database_username = $username;
$data_database_password = $password;


$ini_file = realpath(__DIR__ . '/..').'/accounting/config/accounts/'. $data_account_label . '.ini';

/* Adding account settings to file. Code copied from manage controller */
$con_details = "[database]" . "\r\n" . "db_type = \"" . $data_database_type . "\"" . "\r\n" . "db_hostname = \"" . $data_database_host . "\"" . "\r\n" . "db_port = \"" . $data_database_port . "\"" . "\r\n" . "db_name = \"" . $data_database_name . "\"" . "\r\n" . "db_username = \"" . $data_database_username . "\"" . "\r\n" . "db_password = \"" . $data_database_password . "\"" . "\r\n";


$myfile = fopen($ini_file, "w") or die("Unable to open file!");
$txt = $con_details;
fwrite($myfile, $txt);
fclose($myfile);
// chmod($myfile,0777);



$mysqli = new mysqli($data_database_host,$data_database_username,$data_database_password);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$data_database_name = $mysqli -> real_escape_string($data_database_name);

$db_create_q = 'CREATE DATABASE ' . $data_database_name;

$mysqli -> query($db_create_q);

$mysqli -> select_db($data_database_name);

$schema_file = realpath(__DIR__ . '/..').'/accounting/system/application/controllers/admin/schema.sql';

$myfile = fopen($schema_file, "r") or die("Unable to open file!");
$setup_account =  fread($myfile,filesize($schema_file));
fclose($myfile);

$setup_account_array = explode(";", $setup_account);

foreach ($setup_account_array as $key => $value) {

	$mysqli -> query($value);

}

$sql = "INSERT INTO settings (id, name, address, email, fy_start, fy_end, currency_symbol, date_format, timezone, manage_inventory, account_locked, email_protocol, email_host, email_port, email_username, email_password, print_paper_height, print_paper_width, print_margin_top, print_margin_bottom, print_margin_left, print_margin_right, print_orientation, print_page_format, database_version) VALUES (1, '$data_account_name', '$data_account_address', '$data_account_email', '$data_fy_start', '$data_fy_end', '$data_account_currency', '$data_account_date', '$data_account_timezone', '$data_account_manage_inventory', 0, '$data_account_email_protocol', '$data_account_email_host', '$data_account_email_port', '$data_account_email_username', '$data_account_email_password', '$data_account_print_paper_height', '$data_account_print_paper_width', '$data_account_print_margin_top', '$data_account_print_margin_bottom', '$data_account_print_margin_left', '$data_account_print_margin_right', '$data_account_print_orientation', '$data_account_print_page_format', 4)";

$mysqli -> query($sql);


$groupInfo = $acc_obj_new->getGroupInfo();

if (!empty($groupInfo)) {
	
	foreach ($groupInfo as $key => $value) {

		$value[2] = $mysqli -> real_escape_string($value[2]);

		// $value[2] = mysql_real_escape_string($value[2]);
		
		$sql = "INSERT INTO `groups` (id, parent_id, name, affects_gross) VALUES ('$value[0]', '$value[1]', '$value[2]', '$value[3]')";

		$mysqli -> query($sql);


	}

}


$entryInfo = $acc_obj_new->getEntryInfo();

if (!empty($entryInfo)) {
	
	foreach ($entryInfo as $key => $value) {
		
		$sql = "INSERT INTO entry_types (id, label, name, description, base_type, numbering, prefix, suffix, zero_padding, bank_cash_ledger_restriction) VALUES ('$value[0]', '$value[1]', '$value[2]', '$value[3]', '$value[4]', '$value[5]', '$value[6]', '$value[7]', '$value[8]', '$value[9]')";

		$mysqli -> query($sql);


	}

}

$TagInfo = $acc_obj_new->getTagInfo();

if (!empty($TagInfo)) {
	
	foreach ($TagInfo as $key => $value) {
		
		$sql = "INSERT INTO tags (id, title, color, background) VALUES ('$value[0]', '$value[1]', '$value[2]', '$value[3]')";

		$mysqli -> query($sql);


	}

}



$ledgerInfo = $acc_obj_new->getLedgers();

if (!empty($ledgerInfo)) {
	
	for ($i=0; $i < count($ledgerInfo) ; $i++) { 
		
		$ledgerOpeningBal   = $ledgerInfo[$i][3];

		$ledgerOpeningBalDC = $ledgerInfo[$i][4];

		$drTotal            = $acc_obj_new->getDrTotal($ledgerInfo[$i][0]);

		$crTotal            = $acc_obj_new->getCrTotal($ledgerInfo[$i][0]);

		$sum          	    = ($drTotal - $crTotal);

		if ($ledgerOpeningBalDC=="D") {
			$clBalance = ($sum+$ledgerOpeningBal);
		}
		else{
			$clBalance = ($sum-$ledgerOpeningBal);
		}

		if ($clBalance > 0) {
			$op_balance_dc = "D";
		}
		else{
			$clBalance = -$clBalance;
			$op_balance_dc = "C";
		}


		$ledgerInfo[$i][2] = $mysqli -> real_escape_string($ledgerInfo[$i][2]);

		$sql = "INSERT INTO ledgers (id, group_id, name, op_balance, op_balance_dc, type, reconciliation) VALUES ('".$ledgerInfo[$i][0]."', '".$ledgerInfo[$i][1]."', '".$ledgerInfo[$i][2]."', '".$clBalance."', '".$op_balance_dc."', '".$ledgerInfo[$i][5]."', '".$ledgerInfo[$i][6]."')";

		$mysqli -> query($sql);

		// var_dump($sql);


	}

}