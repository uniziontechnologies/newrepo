<!DOCTYPE html>
<style>
body  {
    background-image: url("../../dist/img/hims-login.jpg");
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
  
  
  <body class="hold-transition login-page">
  <form name="user_authentication" id="user_authentication"  method="post" > 
 
    <div align="center"> 
	  <!--Login errors-->
	  <div  id="login_error" <?php echo ($login_error) == 1?"class='callout callout-danger'":"";?>> <?php echo ($login_error) == 1?"<b>Invalid Login</b>":"";?>    
      </div>
	  <br><br>
	  <div class="row" >
	  <div class="col-md-4">
	  
	  </div>
	  <div class="col-md-4">	
      <div class="box box-warning box-solid">
		 <div class="box-body">
        <p class="login-box-msg"><b><?php echo $lang_user_authentication;?></b></p>
        <form action="../../index2.html" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="User Name" onkeypress="nextField(event.keyCode,password)">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" id="password" type="password"  class="form-control" placeholder="Password" onkeypress="nextField(event.keyCode,sanctioned_by)">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
		  <div class="form-group has-feedback">
            <input name="sanctioned_by" id="sanctioned_by" type="text"  class="form-control" placeholder="Sanctioned By" onkeypress="nextField(event.keyCode,authentication_remarks)">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
		  <div class="form-group has-feedback">
            <input name="authentication_remarks" id="authentication_remarks" type="text"  class="form-control" placeholder="Remarks" onkeypress="nextField(event.keyCode,signin)">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
		  <br>
          <div class="row">
           
            <div class="col-xs-12" >
              <button type="button" class="btn btn-primary btn-block btn-flat" name="authenticate" id="authenticate">Authenticate</button>
            </div><!-- /.col -->
			  <br>
          </div>
      
       
 </div> </div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>
   </form>
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
	 <script>
      $(function () {
  
            $( "#username" ).focus();
			$('#authenticate').keypress(function(e) {
               if(e.which == 13) {
                     $(this).blur();
                     $('#authenticate').focus().click();
              }
         });
           $( "#authenticate" ).click(function() {
		   
		     if($( "#username" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter User Name.</b>");
				 return false;
			 }else if($( "#password" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Password.</b>");
				 return false;
			 }
			 else if($( "#sanctioned_by" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Sanctioned By.</b>");
				 return false;
			 }
			 else if($( "#authentication_remarks" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Remarks.</b>");
				 return false;
			 }else{
			 
			 $.post("../../lib/controllers/centralController.php?module=Billing&sub_module=verify_user_authentication", $("#user_authentication").serialize(),function(data){
				
				 if(data['authentication'] == "failed"){
				 	$( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Authentication Failed.</b>");
				 }else{
				 
				     $('#sanc_by_hidden').val($("#sanctioned_by").val());
					 $('#sanc_user_hidden').val(data['user_id']);
				     $('#auth_remarks_hidden').val($("#authentication_remarks").val());
				 
				 	$('#form').attr('action',"../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Billing");
					$('#form').submit();
				 }
			},"json");
			 
			 }
			 
			
		   
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
