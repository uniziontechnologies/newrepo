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
   
   		if(document.company.insurance_company.value=='') {
   			showDialog('Error','Please Enter Insurance Company Name.','error',2);
			return false;
			
		}else if(document.company.valid_upto.value=='') {
		
   			showDialog('Error','Please Enter Company Expiry Date.','error',2);
			return false;
			
		}else {
			document.company.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Insurance";
			document.company.submit();
		
		}
	}
</script>

</head>
<body id="frame">
<div  id="content">
<form name="company" id="form"  method="post" action=""> 

<?php

$arrList=$this->popArr['InsuranceCompanyInfo'];
$countries=$this->popArr['countries'];
$action = $this->popArr['action'];



?>
<section class="content-header">
        
        <h4><?php echo $lang_insurance_company; ?></h4>
         
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
                       <h3 class="box-title"><?php echo  $lang_insurance_company." ".$lang_information;?></h3>
                    </div>		
               <div class="box-body">
			    <table width="100%" class="table table-striped">
                            <tr>
										<td><?php echo $lang_insurance_company; ?> <span id='requiredfield'>*</span>: </td>
										<td><input name="insurance_company" id="insurance_company" value='<?php echo $arrList[0][1];?>' autocomplete="off" onkeypress="nextField(event.keyCode,valid_upto)"/>
										</td>
							</tr>
                           <tr>							
											
										<td><?php echo $lang_valid_upto; ?><span id='requiredfield'>*</span> : </td>
										<td><input name="valid_upto" id="valid_upto" value='<?php echo ($arrList[0][2] =='0000-00-00' )?'':$arrList[0][2] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,address)" placeholder="yyyy-mm-dd" />
										</td>
							</tr>
							<tr>
										<td><?php echo $lang_address; ?> : </td>
										<td><textarea name="address" id="address" autocomplete="off" onkeypress="nextField(event.keyCode,city)" rows="2" cols="15"/><?php echo $arrList[0][3];?></textarea>
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_city; ?> : </td>
										<td><input name="city" id="city" value='<?php echo $arrList[0][4];?>' autocomplete="off" onkeypress="nextField(event.keyCode,state)"/>
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_state; ?> : </td>
										<td><input name="state" id="state" value='<?php echo $arrList[0][5];?>' autocomplete="off" onkeypress="nextField(event.keyCode,country)"/>
										
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_country; ?> : </td>
										
										<td><select name="country" id="country" onkeypress="nextField(event.keyCode,zipicode)">
											<option value=''>------------------------------</option>
											
										<?php for($i=0;$i<count($countries);$i++){ 
																						
													if($countries[$i][1] == $arrList[0][6]) { ?>
													
														<option value='<?php echo $countries[$i][1];?>' selected><?php echo $countries[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $countries[$i][1];?>'><?php echo $countries[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select>
										
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_zipicode; ?> : </td>
										<td><input name="zipicode" id="zipicode" value='<?php echo ($arrList[0][7] == 0 )?'':$arrList[0][7] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,phone_no)"/>
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_phone_no; ?> : </td>
										<td><input name="phone_no" id="phone_no" value='<?php echo ($arrList[0][8] == 0 )?'':$arrList[0][8] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,fax)"/>
										</td>
                            </tr>
                           <tr>		
										<td><?php echo $lang_fax; ?> : </td>
										<td><input name="fax" id="fax" value='<?php echo ($arrList[0][9] == 0 )?'':$arrList[0][9] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,contact_person)"/>
										</td>
							</tr>
							<tr>
  							           <td><?php echo $lang_contact_person; ?> : </td>
										<td><input name="contact_person" id="contact_person" value='<?php echo $arrList[0][10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,contact_no)"/>
										</td>
							</tr>
							<tr>
										
										<td><?php echo $lang_contact_no; ?> : </td>
										<td><input name="contact_no" id="contact_no" value='<?php echo $arrList[0][11];?>' autocomplete="off" onkeypress="nextField(event.keyCode,email)"/>
										</td>
							</tr>
                            <tr>							
										
										<td><?php echo $lang_email; ?> : </td>
										<td><input name="email" id="email" value='<?php echo $arrList[0][12];?>' autocomplete="off" onkeypress="nextField(event.keyCode,cons_disc_type)"/>
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
			                  <table width="100%" class="table table-striped">
					            <tr>
						
							       <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="cons_disc_type" id="cons_disc_type" onkeypress="nextField(event.keyCode,cons_disc_value)">
									
									<?php		if($arrList[0][15] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][15] == "CASH"){ ?>
									
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
								<td><input name="cons_disc_value" id="cons_disc_value" value='<?php echo $arrList[0][16];?>' autocomplete="off" onkeypress="nextField(event.keyCode,lab_disc_type)"/>
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
			                  <table width="100%" class="table table-striped">
						
							    <tr>
								  <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td>	<select name="lab_disc_type" id="lab_disc_type" onkeypress="nextField(event.keyCode,lab_disc_value)">
										
									<?php		if($arrList[0][17] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][17] == "CASH"){ ?>
									
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
								<td><input name="lab_disc_value" id="lab_disc_value" value='<?php echo $arrList[0][18];?>' autocomplete="off" onkeypress="nextField(event.keyCode,test_disc_type)"/>
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
			                  <table width="100%" class="table table-striped">
						        <tr>
								  <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td>	<select name="test_disc_type" id="test_disc_type" onkeypress="nextField(event.keyCode,test_disc_value)">
									<?php		if($arrList[0][19] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][19] == "CASH"){ ?>
									
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
							<td>		<input name="test_disc_value" id="test_disc_value" value='<?php echo $arrList[0][20];?>' autocomplete="off" onkeypress="nextField(event.keyCode,pharma_disc_type)"/>
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
			                  <table width="100%" class="table table-striped">
					
					            <tr>
								    <td><?php echo $lang_discount." ".$lang_type; ?> : </td>
								
									<td><select name="pharma_disc_type" id="pharma_disc_type" onkeypress="nextField(event.keyCode,pharma_disc_value)">
									<?php		if($arrList[0][21] == "%") { ?>
									
													<option value ="%" selected>%</option>
													<option value ="CASH">CASH</option>
													
									<?php		}else if($arrList[0][21] == "CASH"){ ?>
									
													<option value ="%" >%</option>
													<option value ="CASH" selected>CASH</option>
									
									<?php }else { ?>
													<option value ="%" >%</option>
													<option value ="CASH" >CASH</option>
									
									<?php } ?>
											
										</select>
								</td>
							</tr>
							
			<?php if($action== $lang_add){?>
						<tr>
							<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
							<td><input name="pharma_disc_value" id="pharma_disc_value" value='<?php echo $arrList[0][22];?>' autocomplete="off" onkeypress="nextField(event.keyCode,Add)"/>
							</td>
						</tr>
						<tr>
								
							<td colspan="2"><input id="button1" type="button" name="Add" value="Add" class="btn btn-success" onclick="return submitForm()"/></td>
						</tr>
							
			<?php } else { ?>
						<tr>
							<td><?php echo $lang_discount." ".$lang_value; ?> : </td>
							<td><input name="pharma_disc_value" id="pharma_disc_value" value='<?php echo $arrList[0][22];?>' autocomplete="off" onkeypress="nextField(event.keyCode,Update)"/>
							</td>
										
						</tr>
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
	
