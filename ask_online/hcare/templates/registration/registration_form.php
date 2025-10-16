<!DOCTYPE html>

<html>
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
	
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	
	<link rel="stylesheet" href="../../dist/css/ajax.css">
	
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />

  </head>
 


<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<script>
   
   
     function submitForm(){
	 
	    
   		
		d = new Date();
		today=d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear();
		document.registration.upload_status.value='';
   		if(document.registration.first_name.value=='') {
   			showDialog('Error','Please Enter Patient  Name.','error',2);
			return false;

           // }else if(document.registration.guardian_type.value=='' && !empty(document.registration.guardian.value)) {
		
        }
		//for members
		else if(choseMember()){
			showDialog('Error','Please Select A Member.','error',2);
				return false;
		}else if(document.registration.age.value=='' || !(isNumeric(document.registration.age.value))) {
		
   			showDialog('Error','Please Enter Patient  Age.','error',2);
			return false;
			
		}else if(document.registration.gender.value=='') {
		
   			showDialog('Error','Please Select Patient  Gender.','error',2);
			return false;
			
		}else if(document.registration.place.value=='') {
		
   			showDialog('Error','Please Select Patient  Place.','error',2);
			return false;
			
		}else if(document.registration.contact_no.value=='') {
		
   			showDialog('Error','Please Enter Patient Contact Number.','error',2);
			return false;

			
		}else if(document.registration.contact_no.value!='' && !(isNumeric(document.registration.contact_no.value))) {
		
   			showDialog('Error','Please Enter Numeric Values For Contact Number.','error',2);
			return false;

		
		}else if(document.registration.email.value!='' && !(validateEmail(document.registration.email.value))) {
		
   			showDialog('Error','Please Enter Valid Email.','error',2);
			return false;
			
		}else if(document.registration.doctor.value=='') {
		
   			showDialog('Error','Please Select Doctor.','error',2);
			return false;
			
		}else if(document.registration.inc.checked ==true && document.registration.insurance_company.value == ''){
		
			showDialog('Error','Please Select Insurance Company.','error',2);
			return false;
			
		}else if(document.registration.inc.checked ==true && document.registration.date_issue.value!='' && document.registration.date_issue.value > today){
		
				showDialog('Error','You Entered An Invalid Issue date.','error',2);
				return false;
		
		}else if(document.registration.inc.checked ==true && document.registration.date_expiry.value!='' && document.registration.date_expiry.value < today ){
		
				showDialog('Error','You Entered An Invalid Expiry date.','error',2);
				return false;
		
		}else if(document.registration.mlc.checked ==true && document.registration.mlc_summary.value =='' ){
		
				showDialog('Error','Please Enter MLC Details.','error',2);
				return false;
		
		}else {
		  
		   if(document.registration.free.checked ==true) status="FREE";
		   else status=document.registration.status.value;
		   var msg ="Registeration : "+status+". Doc Fee: "+document.registration.docfee.value+" Reg Fee: "+document.registration.regfee.value+" Card Fee: "+document.registration.cardfee.value+" Do You Want To Proceed?";
		    
			var a=confirm(msg);
			
			if(a==true)
   			{
			  document.registration.Register.disabled = true;
		      document.registration.paction2.value ="SAVE";
			 document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&paction=PROCESS_FORM";
			 document.registration.submit();
			 return true;
			 }else return false;
			
		
		}
		return false;
	}
	function reRegForm(){
	
		document.getElementById('paction').value="REREG_FORM";
		document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";
		document.registration.submit();
	}
	function processForm(){
	
	//	document.getElementById('action').value="PROCESS_FORM";
		document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&paction=PROCESS_FORM";
		document.registration.submit();
		
		
	}
	function getPatientList(){ 
	
		if(document.registration.opno.value=='') {
		
		}else{
			//document.getElementById('action').value="PROCESS_OP_NO";
			document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&paction=PROCESS_OP_NO";
			document.registration.submit();
		}
	}
	function search_op_patient(){
	
	      tb_show('Select OP Patient',"../../lib/controllers/centralController.php?module=Registration&sub_module=search_op_patient");
	}
	function upload_image(){

	       document.registration.upload_status.value="upload";
	       document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";			
	       document.registration.submit();
		return true;
	}

	//for members
	function select_members(){
		if($('select[name="patient_category"] option:selected').attr('class')=='member_option'){
			var cat_id = $('#patient_category').val();
		    tb_show('MEMBERS',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_members&cat_id="+cat_id);
		}
		else{
			$('#member_id').val('');
			$('#member_patient_id').val('');
		}
	}
	function choseMember(){				
		if($('select[name="patient_category"] option:selected').attr('class')=='member_option'){
			if($('#member_id').val()=='' || $('#member_patient_id').val()=='')
				return true;
			return false;
		}
		return false;
	}

</script>

 <div  id="content">
<form name="registration" id="form"  method="post" enctype="multipart/form-data" onload="initailize();"> 
<?php 
$config_obj=new Config_hims();
$op_validity_status=$config_obj->op_validity_status;
echo $op_validity_status;
//exit;


$action=$this->popArr['action'];
$status = $this->popArr['status'];

$doctors=$this->popArr['doctors'];
$countries=$this->popArr['countries'];
$departments=$this->popArr['departments'];
$patient_category=$this->popArr['patient_category'];

if(isset($this->popArr['post'])){
	
	$post=$this->popArr['post'];
	// var_dump($post);
	//if(!empty($this->popArr['message'])) $opno_status="active";
	//else $opno_status="hide";
	$inc_company=$this->popArr['insurance_company'];

	$ip_discharge=$post['ip_discharge'];
	$member_details = $post['member_details'];
	if($member_details){
		$post['first_name'] = null;
		$post['middle_name'] = null;
		$post['last_name'] = null;
		$post['age'] = null;
		$post['age_type'] = null;
		$post['gender'] = null;
		$post['place'] = null;
		$post['contact_no'] = null;
	}
  

}else{
	//$opno_status="active";
}

if(!empty($post['opno'])){
	
	$opno_status = "hide";
}else $opno_status = "active";


// var_dump($post);
?>
<section class="content-header">
          <h1>
            <?php echo  $lang_registration;?>
            <small>OP Patients</small>
	     
          </h1>
	  <?php if($post['id'] != ""){?>
          <ol class="breadcrumb"> 
	                                        <?php						
						if(file_exists("../../templates/registration/patient_photo/".$post['opno']."/photo.jpg")){
						?>
						
						<img src="../../templates/registration/patient_photo/<?php echo $post['opno'];?>/photo.jpg" width="80" height="80">
						<?php
						 }else{						
						?>
						<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
						<?php } ?>
				
           
          </ol><br><br> <br>
  <?php } ?>
        </section>	 
	  
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		
		 <?php if($post['cardfee'] > 0 && $status !='NEW' && $action =="REGISTRATION"){ ?>
		
		                
				<div class="alert alert-warning "><h4><i class="icon fa fa-warning"></i> Alert!</h4>CARD EXPIRED. NEW CARD WILL BE ISSUED WITH THIS REGISTERATION.</div>
		
		   <?php } ?>
		   
		   <?php if($post['total_credit'] > 0){ ?>
		
		                
				<div class="alert alert-warning "><h4><i class="icon fa fa-warning"></i> Alert!</h4>THIS PATIENT HAVE A CREDIT AMOUNT OF Rs/-<?php echo $post['total_credit'];?></div>
		
		   <?php } ?>
		 <div class="box box-info">
               

               <div class="box-body">
			    <table width="100%" class="table table-striped">
							
							<?php if($status !=$lang_new && $opno_status=="active") { ?>
								
								<tr>
									<td colspan="6" align="center" id="noborder">
										<?php echo $lang_op_no; ?><span id='requiredfield'>*</span> :
										<input name="opno" id="opno" tabbindex="2"  onkeypress="nextField(event.keyCode,Search)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" autocomplete="off"/> 
									
										<input id="button1" class="btn btn-primary" type="button" name="Search" value="Search" onclick="return getPatientList()"/>
									
										<input id="button1"  class="btn btn-primary" title="Search Patient" type="button" name="search_patient" value="Search Patient" onclick="return search_op_patient()"/>
									</td>
								</tr>
							<?php }
							
							if($opno_status == "hide" && ($status!="NEW" || $action != "REGISTRATION")){ ?>
							
								<tr>
									<td id="noborder" colspan="6" align="center">
										<input name="opno" id="opno" type="hidden" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" />
									
										<b><?php echo $lang_op_no; ?> :<?php echo (!empty($post['opno']))?$post['opno']:''?></b>
									</td>
								</tr>
							<?php } ?>
							<?php if(!empty($post['token'])) {?>
							
									<tr>
									<td id="noborder" colspan="6" align="center">
										<input name="token" id="token" type="hidden" value="<?php echo (!empty($post['token']))?$post['token']:''?>" />
										<input name="bk_id" id="bk_id" type="hidden" value="<?php echo (!empty($post['bk_id']))?$post['bk_id']:''?>" />
																			
										<b><?php echo $lang_token_no; ?> :<?php echo (!empty($post['token']))?$post['token']:'0'?></b>
									</td>
								</tr>
							
							<?php } ?>
<?php if(empty($post['inc'])) 
            { 
?>						
							    <tr>
							    	<td>
							    		 <?php echo $lang_patient_category; ?>
							    	</td>
							    	<td colspan="5">
							    		  <select name="patient_category" id="patient_category" onkeypress="nextField(event.keyCode,first_name)" onChange="processForm();">
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($patient_category);$i++){ 
																						
													if(!empty($post['patient_category']) && $post['patient_category']==$patient_category[$i][0]) { ?>
													
														<option value='<?php echo $patient_category[$i][0];?>' selected <?php if($patient_category[$i][2]=='YES'){?> class="member_option" <?php }?>><?php echo $patient_category[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $patient_category[$i][0];?>' <?php if($patient_category[$i][2]=='YES'){?> class="member_option" <?php }?>><?php echo  $patient_category[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select> 
										<?php if($post['patient_ids']){ ?>
											<input type="button" name="member_pop" id="member_pop" class="btn btn-info btn-sm" value="Choose Members" onclick="select_members();">
										 
										<?php 
											if($post['member_patient_id_name']){
													echo 'Member ID : '.$post['member_patient_id_name'];
											}
										}
										?>
							    	</td>
							    </tr>
<?php       }  ?>
								<tr>
									<td >
										<?php echo $lang_first_name; ?><span id='requiredfield'>*</span> : 
									</td>
									<td id="noborder">
								
										 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['first_name']))?$post['first_name']:((!empty($member_details))?$member_details[0]:'') ?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">
								
										<?php echo $lang_middle_name; ?> : 
									</td>
									<td id="noborder">
								
										 <input name="middle_name" id="middle_name" tabbindex="2"  onkeypress="nextField(event.keyCode,last_name)" value="<?php echo (!empty($post['middle_name']))?$post['middle_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">			
								
									<?php echo $lang_last_name; ?>  : 
								</td>
								<td id="noborder">
								
										 <input name="last_name" id="last_name" tabbindex="2"  onkeypress="nextField(event.keyCode,age)" value="<?php echo (!empty($post['last_name']))?$post['last_name']:((!empty($member_details))?$member_details[1]:'')?>" autocomplete="off"/> 
								 
							</td>
							<?php if(!empty($post['opno'])){?>
								<!--<td rowspan="5"  >
								
								
								<img src="../../templates/registration/patient_photo/<?php echo $post['opno'];?>/photo.jpg" width="100px" height="150px">
								
								</td>-->
								
								
				
				

								
								
								
								<?php } ?>
						</tr>

						<tr>
									<td id="noborder">
								
										<?php echo $lang_age; ?> <span id='requiredfield'>*</span> : 
									</td>
									<td id="noborder">
								
										 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,age_type)" value="<?php echo (!empty($post['age']))?$post['age']:((!empty($member_details))?$member_details[3]:'')?>" autocomplete="off" size="2"/> 
										<select name="age_type" onkeypress="nextField(event.keyCode,dob)">

											<option value="Y" <?php echo (!empty($post['age_type']) && $post['age_type']=='Y')?'selected':((!empty($member_details) && $member_details[4]=='Y')?'selected':'')?>>Y</option>
											<option value="M" <?php echo (!empty($post['age_type']) && $post['age_type']=='M')?'selected':((!empty($member_details) && $member_details[4]=='M')?'selected':'')?>>M</option>
											<option value="D" <?php echo (!empty($post['age_type']) && $post['age_type']=='D')?'selected':((!empty($member_details) && $member_details[4]=='D')?'selected':'')?>>D</option>
										</select> 
										
										 
										
								</td>
								<td id="noborder">
										<?php echo $lang_dob; ?>
										 
									</td>
									<td id="noborder">
								
										 <input type="text" name="dob" id="dob" value="<?php echo (!empty($post['dob']))?$post['dob']:''?>" autocomplete="off"   class="DatePicker" onkeypress="nextField(event.keyCode,marital_status)" readonly="true"/>
								 
								</td>
								<td id="noborder">			
								
									<?php echo $lang_marital_status; ?>  : 
								</td>
								<td id="noborder">
								
										 <select name="marital_status" id="marital_status"  onkeypress="nextField(event.keyCode,gender)">
											<option value="">---------------------</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Single')?'selected':''?> value="Single">Single</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Married')?'selected':''?> value="Married">Married</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Widow')?'selected':''?> value="Widow">Widow</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Divorced')?'selected':''?> value="Divorced">Divorced</option>
										</select> 
								</td>
								
						</tr>
						<tr>
							<td id="noborder">		
										<?php echo $lang_gender; ?> <span id='requiredfield'>*</span> :
							</td>
							<td id="noborder">			
										<select name="gender" onkeypress="nextField(event.keyCode,place)">
											<option value="">-------------------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':((!empty($member_details) && $member_details[5]=='M')?'selected':'')?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':((!empty($member_details) && $member_details[5]=='F')?'selected':'')?> value="F">Female</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='O')?'selected':((!empty($member_details) && $member_details[5]=='O')?'selected':'')?> value="O">Other</option>
										</select>
								 
							</td>
						
							<td id="noborder">							
								
								<?php echo $lang_place; ?><span id='requiredfield'>*</span> : 
							</td>
							<td id="noborder">								
								 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,patient_address)" value="<?php echo (!empty($post['place']))?$post['place']:((!empty($member_details))?$member_details[2]:'')?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getPlace',event)"/> 	 
							</td>

							<td id="noborder">							
								
								<?php echo $lang_address; ?> : 
							</td>
							<td id="noborder">	
								 <textarea name="patient_address" id="patient_address" onkeypress="nextField(event.keyCode,nationality)" autocomplete="off"><?php echo (!empty($post['patient_address']))?$post['patient_address']:'';?></textarea> 
							</td>

						</tr>
						<tr>

 							<td id="noborder">							
								
								<?php echo $lang_nationality; ?> : 
							</td>
							<td id="noborder">								
								 <select name="nationality" id="nationality" onkeypress="nextField(event.keyCode,contact_no)">
											<option value=''>-----------------------</option>
											
										<?php for($i=0;$i<count($countries);$i++){ 
																						
													if(!empty($post['nationality']) && $post['nationality']==$countries[$i][1]) { ?>
													
														<option value='<?php echo $countries[$i][1];?>' selected><?php echo $countries[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $countries[$i][1];?>' <?php echo ($countries[$i][1] == "India")?"selected":"";?>><?php echo $countries[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select> 	 
							</td>

							<td id="noborder">							
								
								<?php echo $lang_contact_no ; ?> <span id='requiredfield'>*</span>  : 
							</td>
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2"  onkeypress="nextField(event.keyCode,contact_no2)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:((!empty($member_details))?$member_details[6]:'')?>" autocomplete="off"/> 
								 
							</td>
						
							<td id="noborder">							
								<?php echo $lang_email; ?> :
							</td>
							<td id="noborder">
								
								 <input name="email" id="email" tabbindex="2"  onkeypress="nextField(event.keyCode,aadhar)" value="<?php echo (!empty($post['email']))?$post['email']:''?>" autocomplete="off"/> 								 
							</td>
						
						</tr>
						<tr>

							<td id="noborder">							
								<?php echo $lang_dr." ".$lang_dept; ?> :
							</td>
							<td id="noborder">
									<select name="department" id="department" onkeypress="nextField(event.keyCode,doctor)" onChange="processForm();" <?php if (!empty($post['token']) || $status=='REVISIT' || $action != "REGISTRATION"){ echo 'disabled';}?>>
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($departments);$i++){ 
																						
													if(!empty($post['department']) && $post['department']==$departments[$i][0] ) { ?>
													
														<option value='<?php echo $departments[$i][0];?>' selected><?php echo $departments[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $departments[$i][0];?>'><?php echo $departments[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_doctor; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
							<?php 
							// if($action == "REGISTRATION" && $status!='REVISIT') { 
							if($action == "REGISTRATION") { 
								?>
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="processForm();" class="select2"/> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
								<?php }else{ ?>
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="processForm();" /> 		
									
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}
												} ?>
									</select>
								<?php } ?>
							</td>	
							<td id="noborder">							
								<?php echo $lang_dr." ".$lang_fees; ?> :<input name="docfee" id="docfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['docfee']))?$post['docfee']:'0'?>" autocomplete="off" size="2" readonly="true"/> 	
								
							</td>
							<td id="noborder">
								<?php echo $lang_reg_fee; ?> :
								<input name="regfee" id="regfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['regfee']))?$post['regfee']:'0'?>" autocomplete="off" size="2" readonly="true"/> 
                                 <?php echo $lang_card_fee; ?> :
								<input name="cardfee" id="cardfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['cardfee']))?$post['cardfee']:'0'?>" autocomplete="off" size="2" readonly="true"/> 							
															
							</td>
						</tr>
								<tr>

							<td id="noborder">							
								<?php echo $lang_refferal_info; ?> :
							</td>
							<td id="noborder">
								
								 <input name="refferal_info" id="refferal_info" tabbindex="2"  onkeypress="nextField(event.keyCode,department)" value="<?php echo (!empty($post['refferal_info']))?$post['refferal_info']:''?>" autocomplete="off"/> 								 
							</td>
							             

						<?php if($status !=$lang_new && (!empty($post['opno']) && $post['opno']<=49034)) { ?>
		                         <td id="noborder">
										<?php echo $lang_card_expiry; ?>
								
									</td>
									<td id="noborder">
								
										 <input type="text" name="card_expiry" id="card_expiry" value="<?php echo (!empty($post['card_expiry']))?$post['card_expiry']:''?>" autocomplete="off"   class="DatePicker"  readonly="true" onchange="processForm();"/>
								 
								</td>
				<?php }else{?>	
				                  <td id="noborder">
										<?php echo $lang_card_expiry; ?>
										 
									</td>
									
									<td id="noborder">
				                          <input type="text" name="card_expiry" id="card_expiry" value="<?php echo (!empty($post['card_expiry']))?$post['card_expiry']:''?>" autocomplete="off" readonly="true" />
										  
										 
								 </td>
				 
				<?php } ?>
				 <td><?php echo $lang_payment_mode; ?>:</td>
							<td>
								
									<select name="payment_mode" id="payment_mode" onkeypress="if(event.keyCode==13){ processForm()};" onchange="processForm();">						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
						
						</select>
							</td>
			</tr>
						<tr>
							<td id="noborder">INSURANCE</td>
							<td id="noborder"><input type="checkbox" name="inc" value="insurance" <?php echo (!empty($post['inc']))?'checked':''?> onclick="processForm();" onkeypress="nextField(event.keyCode,remarks)"/></td>
							<td id="noborder">MLC</td>
							<td id="noborder"><input type="checkbox" name="mlc" value="mlc" <?php echo (!empty($post['mlc']))?'checked':''?> onclick="processForm();" onkeypress="nextField(event.keyCode,remarks)"/></td>
							<td id="noborder">FREE<input type="checkbox" name="free" value="free" <?php echo ((!empty($post['free'])) && $post['free']!='0' )?'checked':''?> onclick="processForm();" onkeypress="nextField(event.keyCode,remarks)"/></td>
							<td id="noborder">
							HEALTH CHECKUP
							<input type="checkbox" name="health_checkup" value="health_checkup" <?php echo ((!empty($post['health_checkup'])) && $post['health_checkup']!='NO' )?'checked':''?> onclick="processForm();" onkeypress="nextField(event.keyCode,remarks)"/></td>
							
					</tr>	
						

			<tr>
		    <td><?php echo $lang_remarks; ?> </td>
			<td><input name="remarks" id="remarks" tabbindex="2"  onkeypress="nextField(event.keyCode,Register)" value="<?php echo (!empty($post['remarks']))?$post['remarks']:''?>" autocomplete="off"/></td>
		<!-- 	<td>Photo:    </td>
			<td>
							 <?php

	                             //echo "<input type=file name='multiFiles".$_GET['arg']."' id='multiFiles".$_GET['arg']."' accept='image/gif,image/jpeg,image/png'><br />\n";
	                            // echo "<input type=hidden name='multiFiles' id='multiFiles' value='multiFiles".$_GET['arg']."'>";  	
                             ?>
		    </td> -->
			
			
				</table>
		
		
		
		
		
		
		
				<?php if(!empty($post['mlc'])) { ?>
						
				<div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_mlc." ".$lang_information;?></h3>
                    </div>		
				
				<table  class="table table-striped">
				
					<tr>
						<td id="noborder">							
								<?php echo $lang_date; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<input name="mlc_date" id="mlc_date" tabbindex="2"  onkeypress="nextField(event.keyCode,mlc_time)" value="<?php echo (!empty($post['mlc_date']))?$post['mlc_date']:$commObj->getcurrentDate('d-m-Y');?>" autocomplete="off" size="8" readonly/>
							</td>
							<td id="noborder">							
								<?php echo $lang_time; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<input name="mlc_time" id="mlc_time" tabbindex="2"  onkeypress="nextField(event.keyCode,mlc_summary)" value="<?php echo (!empty($post['mlc_time']))?$post['mlc_time']:$commObj->getcurrentTime('h:i a');?>" autocomplete="off" size="6" readonly/>
							</td>
							<td id="noborder">							
								<?php echo $lang_summary; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
							<textarea name="mlc_summary" id="mlc_summary" autocomplete="off" onkeypress="nextField(event.keyCode,remarks)" rows="3" cols="30"/>					<?php echo (!empty($post['mlc_summary']))?$post['mlc_summary']:''?>	</textarea>
									
							</td>
							
					</tr>
				</table>
			</div>
				
				<?php } ?>
	<?php if(!empty($post['inc'])) { ?>
				
				<div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_insurance_company." ".$lang_information;?></h3>
                    </div>
				
				<table  class="table table-striped">
					<tr>
						<td id="noborder">							
								<?php echo $lang_insurance_company; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<select name="insurance_company" id="insurance_company" onkeypress="nextField(event.keyCode,policy_no)" onChange="processForm();">
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($inc_company);$i++){ 
																						
													if(!empty($post['insurance_company']) && $post['insurance_company']==$inc_company[$i][0]) { ?>
													
														<option value='<?php echo $inc_company[$i][0];?>' selected><?php echo $inc_company[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $inc_company[$i][0];?>'><?php echo  $inc_company[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_policy_no; ?> :
							</td>
							<td id="noborder">
								<input name="policy_no" id="policy_no" tabbindex="2"  onkeypress="nextField(event.keyCode,claim)" value="<?php echo (!empty($post['policy_no']))?$post['policy_no']:''?>" autocomplete="off"/> 		</td>
								<td id="noborder">							
								<?php echo $lang_claim_no; ?> :
							</td>
							<td id="noborder">
								<input name="claim" id="claim" tabbindex="2"  onkeypress="nextField(event.keyCode,company_name)" value="<?php echo (!empty($post['claim']))?$post['claim']:''?>" autocomplete="off"/> 		</td>	
						
					</tr>
					<tr>
						<td id="noborder">							
								<?php echo $lang_company_name; ?> :
							</td>
							<td id="noborder">
									<input name="company_name" id="company_name" tabbindex="2"  onkeypress="nextField(event.keyCode,company_id)" value="<?php echo (!empty($post['company_name']))?$post['company_name']:''?>" autocomplete="off"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_company_id; ?> :
							</td>
							<td id="noborder">
								<input name="company_id" id="company_id" tabbindex="2"  onkeypress="nextField(event.keyCode,relation)" value="<?php echo (!empty($post['company_id']))?$post['company_id']:''?>" autocomplete="off"/> 		</td>
								<td id="noborder">							
								<?php echo $lang_relation; ?> :
							</td>
							<td id="noborder">
								<input name="relation" id="relation" tabbindex="2"  onkeypress="nextField(event.keyCode,date_issue)" value="<?php echo (!empty($post['relation']))?$post['relation']:''?>" autocomplete="off"/> 		</td>	
						
					</tr>
					<tr>
						<td id="noborder">							
								<?php echo $lang_date_issue; ?> :
							</td>
							<td id="noborder">
									<input name="date_issue" id="date_issue" tabbindex="2"  onkeypress="nextField(event.keyCode,date_expiry)" value="<?php echo (!empty($post['date_issue']))?$post['date_issue']:''?>" autocomplete="off" readonly="true" class="DatePicker"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_date_expiry; ?> :
							</td>
							<td id="noborder">
									<input name="date_expiry" id="date_expiry" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['date_expiry']))?$post['date_expiry']:''?>" autocomplete="off" readonly="true" class="DatePicker"/>
							</td>
					</tr>
				</table>	
			</div>
	<?php } ?>
	
	    <br>
	      
	
		<?php if(!isset($this->popArr['message1'])){

               		
					if($action =="REGISTRATION"){
					  if(!empty($ip_discharge) && ($ip_discharge=='0000-00-00'))
                          {
        ?>
                            <font color="#FF0000">This Patient Already Admitted!</font>
        <?php                       
                          }
                      else{

		?>     
		                     <button class="btn btn-success pull-right" name="Register" onclick="return submitForm()"><i class="fa fa-credit-card" ></i> Register Patient</button>
		<?php
		                    }
		?>		 
			 	
		<?php  }else{ ?>
		                 
		                 <input id="button1" type="button" name="upload_photo" class="btn btn-success" value="Save & Upload Photo" onclick="return upload_image()"/>
				<button class="btn btn-success pull-right" name="Register"  onclick="return submitForm()"><i class="fa fa-credit-card" ></i> Update Registration</button>
			 	
		<?php  } 
		
		 ?>
		<?php }else { ?>
		
				<br /><font color="#FF0000"><?php echo $this->popArr['message1']; ?></font>
		
		<?php } ?>
		
		
		</div>			
						
			</div>	
		</div>
				
 </div>
 <input name="paction" id="paction" type="hidden" value="<?php echo(!empty($post['revisit']))?'REGISTRATION':$action  ;?>" /> 
 <input name="paction2" id="paction2" type="hidden" value="" /> 
 <input name="status" id="status" type="hidden" value="<?php echo $status;?>" /> 
  <input name="paid" id="paid" type="hidden" value="Paid" /> 
  <input name="validity_days" id="validity_days" type="hidden" value="<?php echo (!empty($post['validity_days']))?$post['validity_days']:'0'?>"  />          
   <input name="id" id="id" type="hidden" value="<?php echo (!empty($post['id']))?$post['id']:''?>" />
   <input name="card_issued" id="card_issued" type="hidden" value="<?php echo (!empty($post['card_issued']))?$post['card_issued']:''?>" />
    <input name="total_credit" id="total_credit" type="hidden" value="<?php echo (!empty($post['total_credit']))?$post['total_credit']:''?>" />
      <input type="hidden" name="upload_status" id="upload_status">
   <input type="hidden" name="ip_discharge" id="ip_discharge" value="<?php echo $ip_discharge;?>">
<input type="hidden" name="member_id" id="member_id" value="<?php echo (!empty($post['member_id']))?$post['member_id']:''?>" >
<input type="hidden" name="member_patient_id" id="member_patient_id" value="<?php echo (!empty($post['member_patient_id']))?$post['member_patient_id']:''?>" >
 <input type="hidden" name="op_validity_status" id="op_validity_status" value="<?php echo (!empty($op_validity_status))?$op_validity_status:''?>">

                </div><!-- /.box-body -->
		</div>

        </section><!-- /.content -->

 </div >
	
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>	
  <!-- Bootstrap 3.3.5 -->
 
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
<script type="text/javascript" src="../../dist/js/common.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

<link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
 <script>


    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
    
      $(function () {
	  
	   //Date range picker
        $('#dob').datepicker();
		//$('#card_expiry').datepicker();
		 $('#date_issue').datepicker();
		  $('#date_expiry').datepicker();
		
	  });
	  </script>
