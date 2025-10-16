<?php session_start();
//Define Root Path
define('ROOT_PATH', dirname(__FILE__));
$_SESSION['path'] = ROOT_PATH;

$base_path=$_SESSION['base_path'];
 define('base_path', $base_path);
                  
if(!isset($_SESSION['demo'])) {

	header("Location: login.php");
	exit();
}

require_once ROOT_PATH . '/language/language.php';
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];

date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_path;?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_path;?>dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="<?php echo base_path;?>dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_path;?>dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="<?php echo base_path;?>dist/css/skins/skin-blue.min.css">

  </head>
 

     