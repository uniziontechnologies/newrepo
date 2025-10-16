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
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script> 

<script>
 
   function submitForm(action){
   	document.email_settings_form_lab.paction.value=action;
   	var pass=document.email_settings_form_lab.smtp_password.value;
   	var conpass=document.email_settings_form_lab.confirm.value;
   	// alert(pas);
   	// alert(conpas); return false;

   
   		if(document.email_settings_form_lab.smtp_security.value=='') {
   			showDialog('Error','Please Enter SMTP Security Type.','error',2);
			return false;
		}else if(document.email_settings_form_lab.smtp_host.value=='') {
   			showDialog('Error','Please Enter SMTP Host.','error',2);
			return false;
		}else if(document.email_settings_form_lab.smtp_port.value=='') {
   			showDialog('Error','Please Enter SMTP Port.','error',2);
			return false;
		}else if(document.email_settings_form_lab.smtp_user_name.value=='') {
   			showDialog('Error','Please Enter SMTP User Name.','error',2);
			return false;
		}else if(document.email_settings_form_lab.smtp_password.value=='') {
   			showDialog('Error','Please Enter SMTP Password.','error',2);
			return false;
		}else if(document.email_settings_form_lab.confirm.value=='') {
   			showDialog('Error','Please Re-Enter SMTP Password.','error',2);
			return false;
		}else if(pass != conpass) {
   			showDialog('Error','Please Enter The Same Password As Above.','error',2);
			return false;
		}else {
		
			document.email_settings_form_lab.action="../../lib/controllers/centralController.php?module=Lab&sub_module=email_settings_lab";
			document.email_settings_form_lab.submit();
		
		}
   
   }
</script>

</head>
<body>
<form name="email_settings_form_lab" id="email_settings_form_lab" method="post" action=""> 
<?php
	$post=$this->popArr['post'];
	$action = isset($this->popArr['paction'])?$this->popArr['paction']:'';
	$smtpInfo = $this->popArr['smtpInfo'];
		
		
	
?>
<div id="content" class="content">
            <section class="content-header">
          <!-- <h1> -->
           
				<h3 id="<?php echo $lang_email." ".$lang_settings;?>" ><?php echo $lang_email." ".$lang_settings;?></h3>
           
          <!-- </h1>		   -->
         
        </section>
				<br> 	
				
		<div class="row">
            <div class="col-md-6">
					<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
			</div>
			</div>
					

					<?php if(isset($this->popArr['message'])){?>
					
						<div class="row">
				            <div class="col-md-6">
									<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
							</div>
							</div>

						
					<?php } ?>
					
					<div class="row">
            <!-- Left col -->
            <div class="col-md-6">	
					<div class="box box-info">
                       <!-- <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_clinic_info;?></h3>
					    
                    </div> -->	
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
				       <input id="button1" type="submit" class="btn btn-success" name="Update" value="Update" onclick="return submitForm('ADD')"/>
			    </td>

		</tr>


				</table >
			
					
					
				</div>
			
				
            </div>
           
      </div>
	</div>
	  <input name="paction" id="paction" type="hidden" value="<?php echo $action;?>" />
	  <!--  <input name="change" id="change" type="hidden" value="" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" /> -->
</form>	  
</body>
	</html>
	
