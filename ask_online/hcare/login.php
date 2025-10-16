<?php
ob_start();
session_start();

define('ROOT_PATH', $_SESSION['path']);

require_once ROOT_PATH . '/language/language.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/logWriter.php';

if(isset($_SESSION['demo'])) {

	header("Location: index.php");
	exit();
}
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
?>
<!DOCTYPE html>
<style>
body  {
    background-image: url("dist/img/hims-login.jpg");
}
</style>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<script type="text/javascript" src="dist/js/common_functions.js">  </script>
  
  </head>
  
  <?php 
  
  $login_error=0;
	if(isset($_POST['username'])){
	
			$user = new User();
			$logwriter=new LogWriter();
			
			$user_name=$_POST['username'];
			$password1=$_POST['password'];
			
			$isLogin=$user->login($user_name,$password1);
			
			if(!empty($isLogin)){
				$_SESSION['user_id']=$isLogin[0][0];
				$_SESSION['user_name']=$isLogin[0][3];
				$_SESSION['user_type']=$isLogin[0][5];
	            $_SESSION['user_type_id']=$isLogin[0][6];
				$_SESSION['emp_id']=$isLogin[0][2];
				$_SESSION['demo']=1;
				
				//$logwriter->addLog($user_id);
				
				
				
			//if($_SESSION['user_type'] == "LAB ADMIN" || $_SESSION['user_type'] == "LAB USER"){
									

                                        if($_SESSION['user_type'] == "NURSE") $_SESSION['select_station']=1;
										
					$base_path = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                    $base_path .= "://".$_SERVER['HTTP_HOST'];
                    $base_path .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
                    define('base_path', $base_path);
                    $_SESSION['base_path'] = $base_path;

					header("Location: index.php");
				//}
				
			}else {
			
			$login_error="1";
		}
	
	}


?>
  <body class="hold-transition login-page">
  <form name="login" id="login"  method="post" action="login.php"> 
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b><?php //echo $clinic_name; ?><img src="dist/img/logo.png" height="110" width="110"></b></a>
      </div><!-- /.login-logo -->
	  
	  <!--Login errors-->
	  <div  id="login_error" <?php echo ($login_error) == 1?"class='callout callout-danger'":"";?>> <?php echo ($login_error) == 1?"<b>Invalid Login</b>":"";?>    
      </div>
      <div class="login-box-body">
        <p class="login-box-msg"><b><?php echo $lang_login;?></b></p>
        <form action="../../index2.html" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="User Name" onkeypress="nextField(event.keyCode,password)">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" id="password" type="password"  class="form-control" placeholder="Password" onkeypress="nextField(event.keyCode,signin)">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
		  <br>
          <div class="row">
           
            <div class="col-xs-12" >
              <button type="button" class="btn btn-primary btn-block btn-flat" name="signin" id="signin">Sign In</button>
            </div><!-- /.col -->
			  <br>
          </div>
      
       

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

   </form>
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script type="text/javascript" src="dist/js/common_functions.js"></script>
	 <script>
      $(function () {
  
            $( "#username" ).focus();
			$('#signin').keypress(function(e) {
               if(e.which == 13) {
                     $(this).blur();
                     $('#signin').focus().click();
              }
         });
           $( "#signin" ).click(function() {
		   
		     if($( "#username" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter User Name.</b>");
				 return false;
			 }else if($( "#password" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Password.</b>");
				 return false;
			 }
			 
			 $( "#login" ).submit();
		   
		   });
	    });
    </script>
    <!--<script src="../../bootstrap/js/bootstrap.min.js"></script>
  
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>-->
	
	
  </body>
</html>
