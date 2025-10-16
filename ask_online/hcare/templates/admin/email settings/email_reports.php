<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/ajax.css" />
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>

 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>


<script>
 
   function submitForm(action){

   	document.email_reports_form.paction.value=action;
   	var pass=document.email_reports_form.smtp_password.value;
   	var conpass=document.email_reports_form.confirm.value;
   	// alert(pas);
   	// alert(conpas); return false;

   
   		if(document.email_reports_form.smtp_security.value=='') {
   			showDialog('Error','Please Enter SMTP Security Type.','error',2);
			return false;
		}else if(document.email_reports_form.smtp_host.value=='') {
   			showDialog('Error','Please Enter SMTP Host.','error',2);
			return false;
		}else if(document.email_reports_form.smtp_port.value=='') {
   			showDialog('Error','Please Enter SMTP Port.','error',2);
			return false;
		}else if(document.email_reports_form.smtp_user_name.value=='') {
   			showDialog('Error','Please Enter SMTP User Name.','error',2);
			return false;
		}else if(document.email_reports_form.smtp_password.value=='') {
   			showDialog('Error','Please Enter SMTP Password.','error',2);
			return false;
		}else if(document.email_reports_form.confirm.value=='') {
   			showDialog('Error','Please Re-Enter SMTP Password.','error',2);
			return false;
		}else if(pass != conpass) {
   			showDialog('Error','Please Enter The Same Password As Above.','error',2);
			return false;
		}else {
		
			document.email_reports_form.action="../../lib/controllers/centralController.php?module=Lab&sub_module=smtp_settings_reports";
			document.email_reports_form.submit();
		
		}
   
   }
</script>

</head>
<body>
<form name="email_reports_form" id="email_reports_form" method="post" action=""> 
<?php
	$post=$this->popArr['post'];
	$action = isset($this->popArr['paction'])?$this->popArr['paction']:'';
	$regEmails = $this->popArr['regEmails'];
	$smtpInfo = $this->popArr['smtpInfo'];
	// var_dump($smtpInfo);
		
		
	
?>
<div id="content" class="content">
            <section class="content-header">
          <!-- <h1> -->
           
				<h3 id="<?php echo $lang_smtp." ".$lang_settings;?>" ><?php echo $lang_smtp." ".$lang_settings;?></h3>
           
          <!-- </h1>		   -->
         
        </section>
				<br> 	
				
<!-- 		<div class="row">
            <div class="col-md-12">
					<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
			</div>
			</div> -->
					

					<?php if(isset($this->popArr['message'])){?>
					
						<div class="row">
				            <div class="col-md-12">
									<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
							</div>
							</div>

						
					<?php } ?>
					
					<div class="row">
					
							 <div class="col-md-12">	
					<div class="box box-info">
                       <!-- <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_clinic_info;?></h3>
					    
                    </div> -->
                    <div class="col-md-6">	
                    <div class="box-body">
							<table  class="table company_info_table">
							
							
		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_smtp_secuirity; ?> <span class='requiredfield'>*</span></label>
				</td>

				<td id="noborder" >
								
						<input type="text" name="smtp_security" id="smtp_security" class="form-control " autocomplete="off" value="<?php echo (!empty($smtpInfo[0][1]))?$smtpInfo[0][1]:''?>" placeholder="ssl / tls">
								 
				</td>
			    
		</tr>

		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_smtp_host; ?> <span class='requiredfield'>*</span></label>
				</td>

				<td id="noborder" >
								
						<input type="text" name="smtp_host" id="smtp_host" class="form-control " autocomplete="off" value="<?php if(!empty($smtpInfo[0][2])){echo $smtpInfo[0][2];} ?>" placeholder="smtp.gmail.com">
								 
				</td>
			    
		</tr>

		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_smtp_port; ?> <span class='requiredfield'>*</span></label>
				</td>
				
				<td id="noborder" >
								
						<input type="text" name="smtp_port" id="smtp_port" class="form-control " autocomplete="off" value="<?php if(!empty($smtpInfo[0][3])){echo $smtpInfo[0][3];} ?>" placeholder="465 / 587">
								 
				</td>
			    
		</tr>

		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_smtp_username; ?> <span class='requiredfield'>*</span></label>
				</td>
				
				<td id="noborder" >
								
						<input type="text" name="smtp_user_name" id="smtp_user_name" class="form-control " autocomplete="off" value="<?php echo (!empty($smtpInfo[0][4]))?$smtpInfo[0][4]:''?>" placeholder="user E-mail address">
								 
				</td>
			    
		</tr>

		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_smtp_password; ?> <span class='requiredfield'>*</span></label>
				</td>
				
				<td id="noborder" >
								
						<input type="password" name="smtp_password" id="smtp_password" class="form-control " autocomplete="off" value="<?php echo (!empty($smtpInfo[0][5]))?$smtpInfo[0][5]:''?>" placeholder="user E-mail password">
								 
				</td>
			    
		</tr>

		<tr>
					
				<td id="noborder" >
								
						<label><?php echo $lang_confirm." ".$lang_smtp_password; ?> <span class='requiredfield'>*</span></label>
				</td>
				
				<td id="noborder" >
								
						<input type="password" name="confirm" id="confirm" class="form-control " autocomplete="off" value="<?php echo (!empty($smtpInfo[0][5]))?$smtpInfo[0][5]:''?>" placeholder="Confirm E-mail password">
								 
				</td>
			    
		</tr>


		<tr>
				<!-- <td></td> -->
				<td id="noborder" colspan="4" class="text-center">
				       <input id="button1" type="submit" class="btn btn-success" name="Update" value="SAVE" onclick="return submitForm('ADD')"/>
			    </td>

		</tr>


				</table >
			
					
					
				</div>
			
				
            </div>
           
						</div>


            <!-- Left col -->
            <div class="col-md-12">	
            	<div class="box-header with-border">
                       <!-- <h3 ><?php echo $lang_clinic_info;?></h3> -->
                       <h3  id="<?php echo $lang_email." ".$lang_reports;?>" ><?php echo $lang_email." ".$lang_reports;?></h3>
					    
                    </div>
					<div class="box box-info box_info_content">


                    <div class="box-body">
							<table  class="table company_info_table">
							
								<thead>
									<tr>
										<th><a href="#"><?php echo $lang_sl_no;?></a></th>
										<th><a href="#"><?php echo $lang_reports;?></a></th>
										<th><a href="#"><?php echo $lang_email."S";?></a></th>
									</tr>
								</thead>

								<tbody>

									<tr id="first">
										<td><label>1</label></td>
										<td><label><?php echo "Daily Detailed Bill Collection Report"; ?></label></td>
										
										<td>


					  						<div class="col-md-12" id="">
											  		
											  		<div class="row reg_emails" id="r1">

														<input type="button" name="add_reg_div" class="btn btn-md btn-info add_reg_div" value="+">

											  			<div class="col-md-8">

											  			<?php 

											  				if (!empty($regEmails[0][2])) {

											  					$regEmails[0][2] = explode("#", $regEmails[0][2]);
											  					
											  					for ($i=0; $i < count($regEmails[0][2]) ; $i++) {?> 

											  						<input type="text" class="form-control" id="reg_emails" name="reg_emails[]" value="<?php echo (!empty($regEmails[0][2][$i]))?$regEmails[0][2][$i]:"";?>" autocomplete="off">
											  						<br>

											  					<?php
											  					}

											  				}
											  				else{?>

											  					<input type="text" class="form-control" id="reg_emails" name="reg_emails[]" value="<?php echo (!empty($department_info[0][3]))?$department_info[0][3]:"";?>" autocomplete="off">
											  					<div id="reg_emails-error" class="error no_display text-red" for="employee" >Please Enter Atleast One E-mail</div>

											  				<?php
											  				}

											  			?>


											  			


											  			</div>

											  			<div class="col-md-1">
											  				
											  				<!-- <div class="remove_reg_button"><a class="red" id="remove_reg" onclick="remove_reg_div(1);">X</a></div> -->

											  			</div>

											  		</div>

											  		<div class="added_reg_div">
											  			
											  		</div>	 

							  				</div>


										</td>

										<td><input type="submit" name="save_reg" id="save_reg" class="btn btn-success" value="UPDATE">&nbsp;<input type="submit" name="remove_reg_data" id="remove_reg_data" class="btn btn-danger" value="REMOVE" <?php if (empty($regEmails[0][2])) {echo "disabled";} ?> ></td>

									</tr>
									<!-- <tr>
									</tr>
									<tr>
									</tr> -->

									

								</tbody>
								<tfoot></tfoot>



				</table >
					
					
					
				</div>
			
				
            </div>
           
      </div>
	</div>
	  <input name="paction" id="paction" type="hidden" value="<?php echo $action;?>" />
	   <input name="change" id="change" type="hidden" value="" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />

	   <input type="hidden" name="reg_email_counter" id="reg_email_counter" value="1">
	   <input type="hidden" name="clear_reg" id="clear_reg" value="">
	    <input type="hidden" name="report_name" id="report_name" value="">

	   


</form>	  

<script type="text/javascript">
	$( document ).ready(function() {

		$("#reg_emails-error").hide();
   
});

		function remove_reg_div(id){

			$('div.row #r'+id).remove();
			var clicks = $("#reg_email_counter").val();
			$("#reg_email_counter").val(--clicks);

		}

		


		$(".add_reg_div").click(function () {

			var clicks = $("#reg_email_counter").val();

			$("#reg_email_counter").val(++clicks);

			var new_clicks = $("#reg_email_counter").val();

		  $(".added_reg_div").append('<div class="row reg_emails" id="r'+new_clicks+'"><br><div class="col-md-8"><input type="text" class="form-control" id="reg_emails" name="reg_emails[]" value="" autocomplete="off"></div>								  			<div class="col-md-1"><div class="remove_reg_button"><a class="btn text-red" id="remove_reg" onclick="remove_reg_div('+new_clicks+');"><b>X</b></a></div></div></div>');

		});


		
	


		$("#save_reg").click(function (e) {
			// alert(111);return false;

			
			if ( $("#reg_emails").val()=="" ) {
				$("#reg_emails").addClass("error");
				$("#reg_emails-error").show();
				return false;
			}
			else{
				$("#reg_emails").removeClass("error");
				$("#reg_emails-error").hide();
				
			}
			
				$("#report_name").val("DAILY DETAILED BILL COLLECTION REPORT");
				document.email_reports_form.action="../../lib/controllers/centralController.php?module=Admin&sub_module=saveRegEmail";
				document.email_reports_form.submit();


		});


		


		$("#remove_reg_data").click(function (e) {

			var a = confirm("Are You Sure To Clear Registration Data ?");

			if (a==true) {

				$("#clear_reg").val("YES");
				document.email_reports_form.action="../../lib/controllers/centralController.php?module=Admin&sub_module=saveRegEmail";
				document.email_reports_form.submit();

			}
			else{
				return false;
			}

		});

		

		


</script>

</body>
	</html>
	