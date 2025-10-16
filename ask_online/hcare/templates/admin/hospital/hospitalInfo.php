<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
  <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
  <script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script>
 
     function submitForm(){
   
   		
   		if(document.hospital.hospital_name.value=='') {
   			showDialog('Error','Please Enter Hospital Name.','error',2);
			return false;
			
		}else if(document.hospital.currency.value=='') {
		
   			showDialog('Error','Please Enter Currency.','error',2);
			return false;
			
		}else if((!validateEmail(document.hospital.email.value))){
				showDialog('Error','Please Enter A Valid Email.','error',2);
				return false;
		}else {
			document.hospital.action="../../lib/controllers/centralController.php?module=Admin&sub_module=HospitalInfo";
			document.hospital.submit();
		
		}
	}
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="hospital" id="form"  method="post" action=""> 

<?php

$arrList=$this->popArr['hospitalInfo'];
$countries=$this->popArr['countries'];



?>
 <div id="wrapper">
            <div id="content">
       			<div id="box">
                	<h3><?php echo $lang_hospitalInfo; ?></h3>
					
					<?php if(isset($this->popArr['message'])){?>
					<br />
						<div id='message' class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
				<div class="row">
                   <div class="col-md-6">
										
			        <div class="box box-info ">
                     <div class="box-header with-border">	
								
						<table  class="table table-striped">	
							
								<tr>

  								    <td><?php echo $lang_hospital; ?><span id='requiredfield'>*</span> : </td>
									<td><input name="hospital_name" id="hospital_name" value='<?php echo $arrList[1];?>' autocomplete="off" onkeypress="nextField(event.keyCode,address)"/></td>
								</tr>
								<tr>
								
								    <td><?php echo $lang_address; ?> :</td>
									<td>
										<textarea name="address" id="address" autocomplete="off" onkeypress="nextField(event.keyCode,city)" rows="2" cols="15"/><?php echo $arrList[2];?></textarea>
									</td>
                                </tr>
                                <tr>
                                								
									<td><?php echo $lang_city; ?> : </td>
									<td>	<input name="city" id="city" value='<?php echo $arrList[3];?>' autocomplete="off" onkeypress="nextField(event.keyCode,state)"/></td>
								</tr>
								<tr>
								    <td><?php echo $lang_state; ?> : </td>
									<td><input name="state" id="state" value='<?php echo $arrList[4];?>' autocomplete="off" onkeypress="nextField(event.keyCode,country)"/></td>
								</tr>
								<tr>
								
								   
										<td><?php echo $lang_country; ?> : </td>
										
										<td> <select name="country" id="country" onkeypress="nextField(event.keyCode,zipicode)">
											   <option value=''>------------------------------</option>
											
										       <?php for($i=0;$i<count($countries);$i++){ 
																						
													if($countries[$i][1] == $arrList[5]) { ?>
													
														<option value='<?php echo $countries[$i][1];?>' selected><?php echo $countries[$i][1];?></option>
										     <?php  }else {?>
										
														<option value='<?php echo $countries[$i][1];?>'><?php echo $countries[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select>
										</td>
									</tr>
										
									<tr>
										
										<td><?php echo $lang_zipicode; ?> : </td>
										<td><input name="zipicode" id="zipicode" value='<?php echo ($arrList[6] == 0 )?'':$arrList[6] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,phone_no)"/></td>
									</tr>	
									<tr>
									    										
										<td><?php echo $lang_phone_no; ?> : </td>
										<td><input name="phone_no" id="phone_no" value='<?php echo ($arrList[7] == 0 )?'':$arrList[7] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,fax)"/></td>
										</tr>
							</table>
								
						</div>
					</div>
				</div>
					  <div class="col-md-6">
						<div class="box box-info">
                
                           <div class="box-body">
							 
							 <table  class="table table-striped">	
							
								<tr>
										<td><?php echo $lang_fax; ?> : </td>
										<td><input name="fax" id="fax" value='<?php echo ($arrList[8] == 0 )?'':$arrList[8] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,email)"/></td>
								</tr>
								<tr>
										<td><?php echo $lang_email; ?> : </td>
										<td><input name="email" id="email" value='<?php echo $arrList[9];?>' autocomplete="off" onkeypress="nextField(event.keyCode,website)"/></td>
								</tr>
								<tr>
										
										<td><?php echo $lang_website; ?> : </td>
										<td><input name="website" id="website" value='<?php echo $arrList[10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,logo)"/></td>
								</tr>
								<tr>	
										<td><?php echo $lang_logo; ?> : </td>
										<td><input name="logo" id="logo" value='<?php echo $arrList[11];?>' autocomplete="off" onkeypress="nextField(event.keyCode,currency)"/></td>
								</tr>
								<tr>	
										<td><?php echo $lang_currency; ?><span id='requiredfield'>*</span> : </td>
										<td><input name="currency" id="currency" value='<?php echo $arrList[12];?>' autocomplete="off" onkeypress="nextField(event.keyCode,Update)"/></td>
									
									
								</tr>
								<tr>
								     <td colspan='2' align="center"><input id="button1" class="btn btn-success" type="button" name="Update" value="Update" onclick="return submitForm()"/></td>
								</tr>
							</table>
						</div>
									
						
				</div>
		</div>
	</div>			
 </div>
 <input name="action" id="action" type="hidden" value="<?php echo $lang_update;?>" />          
   <input name="id" id="id" type="hidden" value="<?php echo $arrList[0];?>" />   
</form>
</body>
	</html>
	
