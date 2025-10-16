<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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
   
   		if(document.category.patient_category.value=='') {
   			showDialog('Error','Please Enter Patient Category Name.','error',2);
			return false;
			
		}else {
			document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=patient_category";
			document.category.submit();
		
		}
	}
</script>

</head>
<body id="frame">
<div  id="content">
<form name="category" id="form"  method="post" action=""> 

<?php

$arrList=$this->popArr['PatientCategoryInfo'];
$action = $this->popArr['action'];



?>
<section class="content-header">
        
        <h4><?php echo $lang_patient_category; ?></h4>
         
        </section>
		<div id='required'><?php echo $lang_markedfieldrequired; ?></div>
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		<div class="row">
              <div class="col-md-6">
		          <div class="box box-info">
                     <div class="box-header with-border">
                       <h3 class="box-title"><?php echo  $lang_patient_category." ".$lang_information;?></h3>
                    </div>		
               <div class="box-body">
			    <table class="table table-striped" style="width:50%;">
                            <tr>
										<td><?php echo $lang_patient_category; ?> <span id='requiredfield'>*</span>: </td>
										<td><input name="patient_category" id="patient_category" value='<?php echo $arrList[0][1];?>' autocomplete="off" onkeypress="nextField(event.keyCode,description)"/>
										</td>
							</tr>
                          
							<tr>
										<td><?php echo $lang_description; ?> : </td>
										<td><textarea name="description" id="description" autocomplete="off" onkeypress="nextField(event.keyCode,cons_disc_type)" rows="2" cols="15"/><?php echo $arrList[0][2];?></textarea>
										</td>
							</tr>	
							<!-- member category -->
							<tr>
								<td></td>
								<td>
									<input type="checkbox" name="member_category" id="member_category" <?php if($arrList[0][13]=='YES'){?> checked <?php }?>>Applicable only for Members
								</td>
							</tr>
								
							</table>
							
						</div>
					</div>
				</div>
					 <div class="col-md-6">	
						<div class="box box-info">
                              <div class="box-header with-border">
                                   <h3 class="box-title"><?php echo $lang_consultation." ".$lang_discount;?></h3>
                              </div>		
                          <div class="box-body">
			                  <table class="table table-striped" style="width:50%;">
					            <tr>
						
							       <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="cons_disc_type" id="cons_disc_type" onkeypress="nextField(event.keyCode,cons_disc_value)">
									
									<?php		if($arrList[0][5] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][5] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
											
											
										</select>
								</td>
							</tr>
							<tr>
							    <td><?php echo $lang_discount." ".$lang_value; ?> : </td>
								<td><input name="cons_disc_value" id="cons_disc_value" value='<?php echo $arrList[0][6];?>' autocomplete="off" onkeypress="nextField(event.keyCode,lab_disc_type)" size="4"/>
								</td>
							</tr>			
										
						</table>
					</div>
					</div>
					<div class="box box-info">
                              <div class="box-header with-border">
                                   <h3 class="box-title"><?php echo $lang_lab." ".$lang_discount;?></h3>
                              </div>		
                          <div class="box-body">
			                  <table class="table table-striped" style="width:50%;">
						
							    <tr>
								  <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td>	<select name="lab_disc_type" id="lab_disc_type" onkeypress="nextField(event.keyCode,lab_disc_value)">
										
									<?php		if($arrList[0][7] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][7] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
								</td>
							</tr>
							<tr>
							   <td><?php echo $lang_discount." ".$lang_value; ?> : </td>
								<td><input name="lab_disc_value" id="lab_disc_value" value='<?php echo $arrList[0][8];?>' autocomplete="off" onkeypress="nextField(event.keyCode,test_disc_type)" size="4"/>
										</td>
							</tr>
										
										
						</table>
					</div>
				</div>
				<div class="box box-info">
                              <div class="box-header with-border">
                                   <h3 class="box-title"><?php echo $lang_test." ".$lang_discount;?></h3>
                              </div>		
                          <div class="box-body">
			                  <table class="table table-striped" style="width:50%;">
						        <tr>
								  <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td>	<select name="test_disc_type" id="test_disc_type" onkeypress="nextField(event.keyCode,test_disc_value)">
									<?php		if($arrList[0][9] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][9] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
								</td>
						</tr>
						<tr>
							<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
							<td>		<input name="test_disc_value" id="test_disc_value" value='<?php echo $arrList[0][10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,pharma_disc_type)" size="4"/>
							</td>
						</tr>
										
										
						</table>
						</div>
				</div>
				<div class="box box-info">
                              <div class="box-header with-border">
                                   <h3 class="box-title"><?php echo $lang_pharma." ".$lang_discount;?></h3>
                              </div>		
                          <div class="box-body">
			                  <table class="table table-striped" style="width:50%;">
					
					            <tr>
								    <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="pharma_disc_type" id="pharma_disc_type" onkeypress="nextField(event.keyCode,pharma_disc_value)">
									<?php		if($arrList[0][11] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][11] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
								</td>
							</tr>
							<tr>
								<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
								<td><input name="pharma_disc_value" id="pharma_disc_value" value='<?php echo $arrList[0][12];?>' autocomplete="off" onkeypress="nextField(event.keyCode,ip_disc_type)" size="4"/>
								</td>
							</tr>
						</table>
					</div></div>
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang_ip." ".$lang_discount;?></h3>
						</div>		
						<div class="box-body">
							<table class="table table-striped" style="width:50%;">
					
					            <tr>
								    <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="ip_disc_type" id="ip_disc_type" onkeypress="nextField(event.keyCode,ip_disc_value)">
									<?php		if($arrList[0][14] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][14] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
									</td>
								</tr>
								<tr>
									<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
									<td><input name="ip_disc_value" id="ip_disc_value" value='<?php echo $arrList[0][15];?>' autocomplete="off" onkeypress="nextField(event.keyCode,reg_disc_type)" size="4"/>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<!-- for reg fee and card fee discount -->
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo "REGISTRATION FEE ".$lang_discount;?></h3>
						</div>		
						<div class="box-body">
							<table class="table table-striped" style="width:50%;">
					
					            <tr>
								    <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="reg_disc_type" id="reg_disc_type" onkeypress="nextField(event.keyCode,reg_disc_value)">
									<?php		if($arrList[0][16] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][16] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
									</td>
								</tr>
								<tr>
									<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
									<td><input name="reg_disc_value" id="reg_disc_value" value='<?php echo $arrList[0][17];?>' autocomplete="off" onkeypress="nextField(event.keyCode,card_disc_type)" size="4"/>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo "CARD FEE ".$lang_discount;?></h3>
						</div>		
						<div class="box-body">
							<table class="table table-striped" style="width:50%;">
					
					            <tr>
								    <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="card_disc_type" id="card_disc_type" onkeypress="nextField(event.keyCode,card_disc_value)">
									<?php		if($arrList[0][18] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][18] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
									</td>
								</tr>
								<tr>
									<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
									<td><input name="card_disc_value" id="card_disc_value" value='<?php echo $arrList[0][19];?>' autocomplete="off" onkeypress="<?php if($action== $lang_add){?> nextField(event.keyCode,Add) <?php } else { ?>nextField(event.keyCode,Update) <?php }?>" size="4"/>
									</td>
								</tr>
							</table>
						</div>
					</div>
							
			<?php if($action== $lang_add){?>						
						<tr>
								
							<td colspan="2"><input id="button1" type="button" name="Add" value="Add" class="btn btn-success" onclick="return submitForm()"/></td>
						</tr>
							
			<?php } else { ?>
						<tr>
							<td colspan="2"><input id="button1" type="button" name="Update" value="Update" class="btn btn-success" onclick="return submitForm()"/></td>
						</tr>
							
					<?php } ?>
								
						</table>
						
						</div>
						
						
				</div>
		</div>
				
 </div>
 </section>
 <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />          
   <input name="id" id="id" type="hidden" value="<?php echo $arrList[0][0];?>" />   
</form>
</body>
	</html>
	
