    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
	
   <body class="hold-transition login-page">
  <form name="login" id="login"  method="post" > 
    <div class="login-box">
     
	 <?php
	 $auth_from=$this->popArr['auth_from'];
	 ?>
	  
	  <!--Login errors-->
	  <div  id="login_error" <?php echo ($login_error) == 1?"class='callout callout-danger'":"";?>> <?php echo ($login_error) == 1?"<b>Invalid Login</b>":"";?>    
      </div>
      <div class="login-box-body">
        <div class="row" >
	
	  <div class="col-md-12">	
      <div class="box box-info box-solid">
		 <div class="box-body">
		 <p class="login-box-msg"><b><?php echo $lang_user_authentication;?></b></p>
        <form  method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="User Name" onkeypress="nextField(event.keyCode,password)">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" id="password" type="password"  class="form-control" placeholder="Password" onkeypress="nextField(event.keyCode,sanctioned_by)">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
		<?php if($auth_from != 'verify_lab_result'){ ?>
		  <div class="form-group has-feedback">
            <input type="text" name="sanctioned_by" id="sanctioned_by" class="form-control" placeholder="Sanctioned By" onkeypress="nextField(event.keyCode,remarks_auth)">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
		   <div class="form-group has-feedback">
            <input type="text" name="remarks_auth" id="remarks_auth" class="form-control" placeholder="Remarks" onkeypress="nextField(event.keyCode,authenticate)">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
		 <?php }else{?>
		 <input type="hidden" name="sanctioned_by" id="sanctioned_by" class="form-control" placeholder="Sanctioned By" onkeypress="nextField(event.keyCode,remarks_auth)">
             <input type="hidden" name="remarks_auth" id="remarks_auth" class="form-control" placeholder="Remarks" onkeypress="nextField(event.keyCode,authenticate)">
            
		 
		 <?php } ?>
		  <br>
          <div class="row">
           
            <div class="col-xs-12" >
              <button type="button" class="btn btn-primary btn-block btn-flat" name="authenticate" id="authenticate">Authenticate</button>
            </div><!-- /.col -->
			  <br>
          </div>
      
       <input type="hidden" name="auth_from" id="auth_from" value="<?php echo $auth_from;?>">

      </div><!-- /.login-box-body -->
	  </div>
	  </div>
	  </div>
    </div><!-- /.login-box -->
 <script>
      $(function () {
	  
	       $( "#authenticate" ).click(function() {
		    if($( "#username" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter User Name.</b>");
				 return false;
			 }else if($( "#password" ).val() == ""){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Password.</b>");
				 return false;
			 }else if($( "#sanctioned_by" ).val() == "" && $( "#auth_from" ).val() != "verify_lab_result"){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Sanctioned By.</b>");
				 return false;
			 }else if($( "#remarks_auth" ).val() == "" && $( "#auth_from" ).val() != "verify_lab_result"){
			 
			      $( "#login_error" ).addClass( "callout callout-danger" );
			     $( "#login_error" ).html("<b>Please Enter Remarks.</b>");
				 return false;
			 }else{
			 
			    var data = 'username='+$( "#username" ).val()+'&password='+$( "#password" ).val()+'&auth_from='+$( "#auth_from" ).val();
				
				inline_action="../../lib/controllers/centralController.php?module=User_Authenticate&sub_module=authenticate_json";
				
				 $.post(inline_action, data, function (response) {
				 
				     if(response['status'] == "Failed"){
					  $( "#login_error" ).addClass( "callout callout-danger" );
			          $( "#login_error" ).html("<b>Invalid Login</b>");
					 // return false;
					 }else if(response['status'] == "login_another_user"){
					  $( "#login_error" ).addClass( "callout callout-danger" );
			          $( "#login_error" ).html("<b>Authenticate As Another User</b>");
					  //return false;
					 }else{
					 
					   $( "#auth_user_id" ).val(response['user_id']);
					
					
					 if($( "#auth_from" ).val() == "bill"){
					 
					      $( "#auth_sanc_by" ).val($( "#sanctioned_by" ).val());
					      $( "#auth_remarks" ).val($( "#remarks_auth" ).val());
					 
					      $('#form').attr('action',"../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Billing");
					 }else if($( "#auth_from" ).val() == "verify_lab_result"){
					 
					   $('#form').attr('action',"../../lib/controllers/centralController.php?module=Lab&sub_module=Save_result_entry&auth_id="+response['user_id']);
					  
					 }else{
					 
					     $( "#auth_sanc_by" ).val($( "#sanctioned_by" ).val());
					     $( "#auth_remarks" ).val($( "#remarks_auth" ).val());
					     $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Final_Payment");
					 }
                      $("#form").submit();
					 
					 }
				  },"json");
			 
			 }
		   });
	  });
    </script>
   </form>
   </body>