<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->lang->line('main_title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/bootstrap/css/bootstrap.min.css">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/plugins/iCheck/square/blue.css">

  </head>
  <body class="hold-transition login-page">
  <?php
echo form_open('login',array('id' => 'login', 'name' => 'login'));
?>
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b><img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="110px" height="110" ></img>  </a>
      </div><!-- /.login-logo -->
	  
  

	   <div  id="login_error" > <b><font size="-1"><?php echo validation_errors();?></font></b>	   
      </div>
      <div class="login-box-body">
        <p class="login-box-msg"><b><?php echo $this->lang->line('login');?></b></p>
        <form action="../../index2.html" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="User Name" onkeypress="nextField(event.keyCode,password)">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" id="password" type="password"  class="form-control" placeholder="Password" onkeypress="nextField(event.keyCode,signin)">
            
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
          <div class="col-xs-12" >
              <button type="button" class="btn btn-primary btn-block btn-flat" name="signin" id="signin">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>application/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/common_functions.js"></script>
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
<?php echo form_close();?>
  </body>
</html>
