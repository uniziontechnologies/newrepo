<?php session_start();
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
$comm_obj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	   
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
    <script type="text/javascript" src="../../dist/js/thickbox.js"></script>
    <script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   
<script>

   function processForm(){
	
		type=document.select_bill.type.value;
		
		if(type == "DIRECT") {
			redirect('0');
			return true;
		}
        if(type == "IP") {
        
            document.select_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Select_Bill";
		   document.select_bill.submit();
        }else{
		  document.select_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Select_Bill";
		  document.select_bill.submit();
        }
		
	}
	
	function searchForm(){
	
		
		document.select_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Select_Bill";
		document.select_bill.submit();
	}
	
	function redirect(pid){
	            
		document.select_bill.id.value=pid;
		document.select_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Billing_Form";
		
		
		document.select_bill.submit();
	}

	function redirect_prescription(ipno,opno){
	      
	   tb_show('IP Prescription Date',"../../lib/controllers/centralController.php?module=Billing&sub_module=doctor_lab_prescription_date_ip&ip_no="+ipno+"&op_no="+opno);
       return false;
	}
	
   
</script>

	 <script>
      $(function () {
	  
	   //Date range picker
        $('#date').datepicker();
        $('#from_date').datepicker();
        $('#to_date').datepicker();
		
	  });
	  </script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
<style type="text/css">
.revisit{
	background-color: #d6b8ad;
}
.black a{
	color: black !important;
}
tr#yesterday {
    background-color: lightgray;
}
.prescription_color{
    font-weight: 700;
    font-size: 17px;
    background: lightgreen;
}
</style>
</head>
<body id="frame">
<form name="select_bill" id="form"  method="post" action=""> 
<?php


		$post=$this  ->popArr['post'];
		$doctors=$this  ->popArr['doctors'];
		$patientInfo=$this  ->popArr['patient_info'];
	
	
	$dep_id='';
	
	if(!empty($this->popArr['dep_id'])){
		$dep_id=$this->popArr['dep_id'];
	}
	if(!empty($post['date'])) {
		$date=$post['date'];
	}else $date=date("d-m-Y");    
   
	
	if(!empty($post['type'])) {
		$type=$post['type'];
	}else $type="OP";
	
	
	

?>
<section class="content-header">
          <h4><?php echo $lang_select; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
								
							<!--<tr>
							
								<td id="noborder"><?php echo $lang_type; ?> </td>
								<td id="noborder" >
								
								   <select name="type" id="type"   onkeypress="processForm();" onChange="processForm();"/> 		
									<option value='<?php echo $lang_op;?>' <?php echo (!empty($type) && $type=='OP')?'selected':''?>><?php echo $lang_op;?></option>
									<option value='<?php echo $lang_direct;?>' <?php echo (!empty($type) && $type=='DIRECT')?'selected':''?>><?php echo $lang_direct;?></option>
                                    <option value='<?php echo $lang_ip;?>' <?php echo (!empty($type) && $type=='IP')?'selected':''?>><?php echo $lang_ip;?></option>
											
											
									</select>
								</td>			
								
							</tr>-->
			<?php if($type == "OP") {?>
					
							<tr>
							
								<td id="noborder"> <?php echo $lang_op_no; ?>:</td>
								<td id="noborder"><input type="text" name="opno"  size="12" value="" onkeypress="nextField(event.keyCode,name)" /></td>
								
								<td id="noborder"> <?php echo $lang_first_name; ?>:</td>
								<td id="noborder"><input type="text" name="name"  size="12" value="" onkeypress="nextField(event.keyCode,place)" /></td>

																
								<td id="noborder"> <?php echo $lang_place; ?>:</td>
								<td id="noborder"><input type="text" name="place" value="" size="12" onkeypress="nextField(event.keyCode,lname)" /></td>
							</tr>
							<tr>
							
								<td id="noborder"><?php echo $lang_contact_no; ?>:</td>
								<td id="noborder"><input type="text" name="telNo" value="" size="12" onkeypress="nextField(event.keyCode,lname)" /></td>	
								
								<td id="noborder"><?php echo $lang_date." OF VISIT"; ?> </td>
								<td id="noborder" ><input type="text" name="date" id="date" value="<?php if(!empty($post['date'])){echo date('d-m-Y',strtotime($post['date']));}else{date("d-m-Y");} ?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
								
								<td id="noborder"><?php echo $lang_doctor; ?> </td>
								<td id="noborder">
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="searchForm();" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
							
							</tr>	
							<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="searchForm();"/>
									
									</td>
								</tr>	
				<?php	}else if($type == "IP"){?>
                
                
                                             <tr>
							<td id="noborder"> <?php echo $lang_op_no; ?>:</td>
								<td id="noborder"><input type="text" name="opno"  size="12" value="" onkeypress="nextField(event.keyCode,ipno)" /></td>
								
                                                <td id="noborder"> <?php echo $lang_ip_no; ?>:</td>
								<td id="noborder"><input type="text" name="ipno"  size="12" value="" onkeypress="nextField(event.keyCode,room_no)" /></td>
                                
								<td id="noborder"> <?php echo $lang_room_no; ?>:</td>
								<td id="noborder"><input type="text" name="room_no"  size="12" value="" onkeypress="nextField(event.keyCode,name)" /></td>
								
								<td id="noborder"> <?php echo $lang_first_name; ?>:</td>
								<td id="noborder"><input type="text" name="name"  size="12" value="" onkeypress="nextField(event.keyCode,from_date)" /></td>
                                
                                </tr>
                                <tr>
                               <td id="noborder"><?php echo $lang_from_date; ?> </td>
							   <td id="noborder" ><input type="text" name="from_date" id="from_date" value="<?php echo $post['from_date'];?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
                               
                                            <td id="noborder"><?php echo $lang_to_date; ?> </td>
							   <td id="noborder" ><input type="text" name="to_date" id="to_date" value="<?php echo $post['to_date'];?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
                                           <td id="noborder"><?php echo $lang_doctor; ?> </td>
                                         <td id="noborder">
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="searchForm();" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
							
                                
                                </tr>
                                <tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success "onclick="searchForm();"/>
									
									</td>
								</tr>	
                
                    <?php }else if($type == "DIRECT") {?>
				
				
							<tr>
									<td id="noborder"><?php echo $lang_name; ?> <span id='requiredfield'>*</span> : </td>
									<td id="noborder">
								
										 <input name="name" id="name" tabbindex="2"  onkeypress="nextField(event.keyCode,age)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" autocomplete="off"/> 							 
								</td>
								<td id="noborder">	<?php echo $lang_place; ?><span id='requiredfield'>*</span> :</td>
							<td id="noborder">								
								 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" /> 	 
							</td>
								
								<td id="noborder"><?php echo $lang_age; ?> <span id='requiredfield'>*</span> :	</td>
								
									<td id="noborder">
								
										 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,age_type)" value="<?php echo (!empty($post['age']))?$post['age']:''?>" autocomplete="off" size="2"/>
										 
								<?php echo $lang_gender; ?> <span id='requiredfield'>*</span> :
									
										<select name="gender" onkeypress="nextField(event.keyCode,place)">
											<option value="">------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
										</select>
								 
							</td>
							
							
					</tr>
					<tr>
					
							<td id="noborder"><?php echo $lang_contact_no; ?>  :</td>			
							
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2"  onkeypress="nextField(event.keyCode,email)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off"/> 
								 
							</td>
							<td id="noborder"><?php echo $lang_refferal_info; ?> :	</td>
							<td id="noborder">
								
								 <input name="refferal_info" id="refferal_info" tabbindex="2"  onkeypress="nextField(event.keyCode,department)" value="<?php echo (!empty($post['refferal_info']))?$post['refferal_info']:''?>" autocomplete="off"/> 								 
							</td>
					</tr>
				
				<?php  } ?>
				</table>
				</div>
			</div>
				
	              <h3 >
						<?php 


						if ($type=="OP") {

							$op_div =  "<div style='display:inline-flex;'><div style='width: 20px;height: 20px;background-color: lightgrey;'><P style='font-size: 12px;padding-top: 5px;padding-left: 30px;'>YESTERDAY</P></div><div style='width: 20px;height: 20px;background-color: #d6b8ad;margin-left: 110px;'><P style='font-size: 12px;padding-top: 5px;padding-left: 30px;'>REVISIT</P></div></div>";

						}

						echo $type." PATIENT ".$lang_list."&nbsp;&nbsp;&nbsp;&nbsp;".$op_div;

						 ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			
			
		<?php if($type == "OP") {?>		
			  <table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_op_no; ?></a></th>						
						<th ><a href="#"><?php echo $lang_patient_category; ?></a></th> 
						 <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						 <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_place; ?></a></th>
						    <th width="5%"><a href="#"><?php echo $lang_date; ?></a></th>
							<th width="6%"><a href="#"><?php echo $lang_time; ?></a></th>
							<th><a href="#"><?php echo $lang_insurance_company; ?></a></th>							
						    <th><a href="#"><?php echo $lang_doctor; ?></a></th>							 
							  <th width="5%"><a href="#"><?php echo $lang_visit_status; ?></a></th>

							  <?php 

							  	if ($_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER") {?>
							  		<th width="5%"><a href="#"><?php echo 'PRESCRIPTION'; ?></a></th> 
							  	<?php
							  	}

							  ?>

                          </tr>
				</thead>
				<tbody>
				
					<?php if(!empty($patientInfo)){
							$j=1;
							for($i=0;$i<count($patientInfo);$i++){	 ?>
							
					
							<tr <?php echo(!empty($patientInfo[$i][32])&&$patientInfo[$i][32]=="REVISIT")?'class="revisit"':""; ?> <?php if (date("d-m-Y",strtotime($patientInfo[$i][20]))!=date("d-m-Y")) {
									echo "id=yesterday";
								} ?> >
								<td><?php echo $j++;?></td>
								<td><?php echo strtoupper($patientInfo[$i][47])."/".$patientInfo[$i][0];?></td>
								<td>
									<?php 
									if($patientInfo[$i][57]){
										echo	$patientInfo[$i][57];
										if($patientInfo[$i][81]){
											echo "<br> Member ID : ".$patientInfo[$i][81];
										}
									}
									?>
								</td>
								<td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>')"><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a>
								<?php if($patientInfo[$i][58] == 'YES') echo "<Br><span class='text-red' ><small>(Health checkup)</small></span>";?>

								<?php if($patientInfo[$i][59] == 'YES') echo '<br><font color="red"><small>(In Observation)</small></font>';?>

								</td>
								<td><?php echo $patientInfo[$i][4];?></td>
								<td><?php echo $patientInfo[$i][6];?></td>
								<td><?php echo $patientInfo[$i][8];?></td>
								<td><?php echo date("d-m-Y",strtotime($patientInfo[$i][20]));?></td>
								<td><?php echo $patientInfo[$i][19];?></td>
								<td><?php echo $patientInfo[$i][23];?></td>
								<td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
								
								<td><?php echo $patientInfo[$i][32];?></td>


							  <?php 

							  	if ($_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER") {

				                  if (!empty($patientInfo[$i][90])) {?>
				                    <td class="prescription_color"><?php echo 'YES';?></td>
				                  <?php
				                  }
				                  else{?>
				                    <td><?php //echo ' - ';?></td>
				                  <?php
				                  }

							  	}

							  ?>



						</tr>
						
									
								
					<?php
								}
							}
						
					?>
					
						</tbody>
						
				</table>
           <?php }else if($type == "IP") {?>
           
           
                  <table class="table table-bordered table-striped">
				<thead>
					<tr>
                                 
                      <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
					  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
					  <th ><a href="#"><?php echo $lang_op_no; ?></a></th>		
					  <th ><a href="#"><?php echo $lang_patient_category; ?></a></th> 
					  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
					  <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
					  <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>
                      <th><a href="#"><?php echo $lang_place; ?></a></th>
					  <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
                      <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
					  <th><a href="#"><?php echo $lang_room_no;?></a></th>
					  <th><a href="#"><?php echo $lang_doctor; ?></a></th>
<?php 

	if ($_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER") {?>

					  <th width="5%"><a href="#"><?php echo 'PRESCRIPTION'; ?></a></th> 
<?php
	}

?>
										                              
						
                              </tr>
                          </thead>
                          <tbody>
                               
<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {
?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
						<td>
							<?php 
							if($patientInfo[$i][54]){
								echo	$patientInfo[$i][54];
								if($patientInfo[$i][62]){
									echo "<br> Member ID : ".$patientInfo[$i][62];
								}
							}
?>
						</td>
<?php 
		if($patientInfo[$i][51] == 2){
?>
			            <td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?><br> 
						
						<span class="text-red" ><small>(Bill Prepared)</small></span></td>			
<?php 
		}else{
?>                  	   
                        <td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>')"><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a></td>
<?php 
		} 
?>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
												<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>

<?php 

	if ($_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER") {

		if (!empty($patientInfo[$i][65])) {
?>

	      <td><input type="button" name="prescription_submit" value="Prescription" onclick="redirect_prescription('<?php echo $patientInfo[$i][13];?>','<?php echo $patientInfo[$i][15];?>')" class="btn btn-info" id="prescription_submit"></td>

<?php
		}else{
?>
				        <td><?php //echo ' - ';?></td>
<?php
			 }

	}

?>
						
				        </tr>
		       <?php       }
		             }
		        ?>
                                       
                          </tbody>
                        </table>
                        
                         
           
           <?php } ?>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
	  <input type="hidden" name="ip_prescribed_date" id="ip_prescribed_date" />
	  
	
</form>	  
</body>
	</html>
	
