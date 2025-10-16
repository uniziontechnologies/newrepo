<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>

	<link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
	
<script>
	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
/*........pagination.........*/	
  $(document).ready(function(){
     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients");
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients");
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients");
                 $("#form").submit();
              });
  });  
/*........pagination.........*/
</script>
		

<!--<script type="text/javascript" src="../../js/mootools.v1.11.js"></script>

<script type="text/javascript" src="../../js/DatePicker.js"></script>-->
<script>
	
  
   
   function submitform(action,id){
   	
	if(action == "PRINT"){
	
		setAction('',id);
        document.patients.paction.value="";
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=Print_OP_Sheet";
	}else if(action == "PRINT CARD"){
	
		setAction('',id);
        document.patients.paction.value="";
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=print_op_card";
	}else if(action == "PRINT REGISTRATION"){
	
		setAction('',id);
        document.patients.paction.value="";
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=print_registration";
	}else if(action == "CLEAR"){
	
		setAction('',id);	
        document.patients.paction.value=action;
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients";
	}else if(action == "EDIT_PAGE"){
	
		setAction('',id);	
                 document.patients.paction.value=action;
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";
	}else if(action == "REVISIT"){
	
		setAction('',id);	
                 document.patients.paction.value=action;
                 document.patients.revisit.value="REVISIT";
		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";
	}else if(action == "DELETE"){
	
		setAction('',id);	
	       document.patients.paction.value=action;
		var a=confirm("Do u want to Delete Patient!");
		
  		 if(a==true)
   			{
				var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
					document.patients.cancellation_details.value=details;
					document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";
				}else{
				return false;
			}
				

			}else{
				return false;
			}
		
	}else{
		setAction('',id);
                 document.patients.paction.value=action;
   		document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients";
	}
		document.patients.submit();
   }
   function myfunction(id,visit_id){
   	a=true;
   	if (!($("#observation"+id).is(':checked'))){
   		var a=confirm("Do You Really Want to Cancel The Observation?");
   	}
		
  		if(a==true)
		{
	   		setAction('',visit_id);

			if ($("#observation"+id).is(':checked')) {
				
				document.patients.observation_status.value="YES";
				document.patients.action="../../lib/controllers/centralController.php?module=IP&sub_module=Observation_add_up_del";
				document.patients.submit();

			}
			else{
				
				document.patients.observation_status.value="NO";
				document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=update_observation_status";
				document.patients.submit();

			}
		}else{ 
			$("#observation"+id).prop("checked", true);
		}

	}
   function refer_doctor(action,id,ref_id,old_status,old_doctor){

   	   document.patients.id.value=id;
   	   document.patients.paction.value=action;
   	   document.patients.refer.value='REFER';

   	   if (ref_id=="") {
   	   		document.patients.whithout_refer.value='YES';
   	   }
   	   else if (ref_id!="") {
   	   		document.patients.whithout_refer.value='NO';
   	   		document.patients.ref_id.value=ref_id;
   	   }

   	   document.patients.old_status.value=old_status;
   	   document.patients.old_doctor.value=old_doctor;
   	
	   document.patients.action="../../lib/controllers/centralController.php?module=Registration&sub_module=referal_cases";
	   document.patients.submit();
   
   }
	function select_patient(opno,doc_id,op_visit_id){
	    
	   $("#pid").val(opno);
	   $("#doc_id").val(doc_id);
	   $("#op_visit_id").val(op_visit_id);


	   $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=op_case_sheet");
	   $("#form").submit();

	}
</script>
<style type="text/css">
.revisit{
	background-color: #d6b8ad !important;
}
</style>
</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];
	$today=date("Y-m-d");

	// var_dump($patientInfo);

?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_op_patients; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
								<tr>
										<td id="noborder">
									
										<?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
										</td>
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
										</td>
										<td id="noborder">
										<?php echo $lang_op_no; ?></td>
									<td id="noborder" >	<input name="opno" id="opno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" autocomplete="off"/>
									</td>
									<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" class="select2" /> 		
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
								
								<td id="noborder">
									<?php echo $lang_first_name; ?></td>
									<td id="noborder" >	 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['first_name']))?$post['first_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">							
								
								<?php echo $lang_place; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" /> 	 
							</td>
							<td id="noborder">							
								
								<?php echo $lang_contact_no; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="contact_no" id="contact_no"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" /> 	 
							</td>
							
								
								</tr>
								<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
       			
                	<h3 >
						<?php echo $lang_op_patients." ".$lang_list; ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                  <?php echo $pagination;?>
               <div class="box-body">
			        <table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						 <th><a href="#"><?php echo $lang_patient_category; ?></a></th>
						 <th><a href="#"><?php echo $lang_name; ?></a></th>
						 <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                           <th width="5%"><a href="#"><?php echo $lang_place; ?></a></th>
                           <th><a href="#"><?php echo $lang_contact_no; ?></a></th>
						    <th width="5%"><a href="#"><?php echo $lang_date; ?></a></th>
							
							<th width="5%"><a href="#"><?php echo $lang_insurance_company; ?></a></th>							
						    <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						    <th><a href="#"><?php echo $lang_payment_mode; ?></a></th>
							<th><a href="#"><?php echo $lang_amount; ?></a></th>
							  <th width="5%"><a href="#"><?php echo $lang_status; ?></a></th>  
                             <th><a href="#">PHOTO</th>	
			     <th><a href="#"><?php echo $lang_obsersvation; ?></th>	     
							<th width="10%"><a href="#"><?php echo $lang_action; ?></a></th> 
                            <!-- <th><a href="#">UPDATE HISTORY</th>-->							
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {
				 $amount=$patientInfo[$i][17]+$patientInfo[$i][18]+$patientInfo[$i][52];
				?>
					<tr <?php echo(!empty($patientInfo[$i][32])&&$patientInfo[$i][32]=="REVISIT")?'class="revisit"':""; ?>  >
						<td><?php echo $j++;?></td>
						<td><?php echo strtoupper($patientInfo[$i][47])."/".$patientInfo[$i][0];?><input type="hidden" name="obs_opno<?php echo $i;?>" id="obs_opno<?php echo $i;?>" value="<?php echo $patientInfo[$i][0];?>"></td>
						<td>
							<!-- form member category -->
							<?php 
								echo $patientInfo[$i][57];
								if($patientInfo[$i][81]){
									echo '<br>Member ID:'.$patientInfo[$i][81];
								}
							?>							
						</td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][10];?></td>
						<td><?php echo $patientInfo[$i][20]." ".$patientInfo[$i][19];?></td>
						
						<td><?php echo $patientInfo[$i][23];?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
						<td><?php echo $patientInfo[$i][95];?></td>
						<td><?php echo $amount;?></td>
						<td>
							<?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?>
						
						       <?php if($patientInfo[$i][58] == 'YES') echo "<span class='text-red' ><small>(Health checkup)</small></span>";?></td>
										
						<td>	
						<?php						
						if(file_exists("../../templates/registration/patient_photo/".$patientInfo[$i][0]."/photo.jpg")){
						?>
						
						<img src="../../templates/registration/patient_photo/<?php echo $patientInfo[$i][0];?>/photo.jpg" width="70px" height="60px"><br>
						
						<?php
						 }else{						
						?>
						<img src="../../templates/registration/patient_photo/testimage.jpg" width="60px" height="70px">
						<?php } ?>
						
						</td>   
						<?php if($patientInfo[$i][20] == $today ){ ?>
						<td style="text-align: center;padding-top: 20px;"><input type="checkbox" name="observation" id="observation<?php echo $i;?>" value="YES" onclick="myfunction('<?php echo $i;?>','<?php echo $patientInfo[$i][13];?>');" <?php if(!empty($patientInfo[$i][59])&&$patientInfo[$i][59]=="YES"){echo "checked";} else if (!empty($patientInfo[$i][59])&&($patientInfo[$i][59]=="DISCHARGED" || $patientInfo[$i][59]=="ADMITTED")) {echo "disabled='disabled'";echo " checked";} else if (!empty($patientInfo[$i][84])) {echo "disabled='disabled'";} ?> ></td>
						<?php }
							else{
								echo "<td></td>";
							}

						 ?>
						 <!-- observation rooms -->
						<td>
						 <div class="btn-group">
                                 <button type="button" class="btn btn-success">EDIT</button>
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">

                               <li onclick="select_patient('<?php echo $patientInfo[$i][0];?>','<?php echo $patientInfo[$i][14];?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-file"></i>&nbsp;<?php echo 'EXAMINATION';?></a></li>

                                <li onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-edit"></i>&nbsp;<?php echo $lang_edit_page;?></a></li>
							<?php if($patientInfo[$i][20] == $today){ ?>
								<li onClick="submitform('<?php echo $lang_revisit;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-user"></i>&nbsp;<?php echo $lang_revisit;?></a></li>
											<?php if(empty($patientInfo[$i][67])){ ?>

											<li onclick="refer_doctor('<?php echo 'REFER';?>','<?php echo $patientInfo[$i][13];?>','<?php echo $patientInfo[$i][66];?>','<?php echo $patientInfo[$i][32];?>','<?php echo $patientInfo[$i][14];?>');"><a href="#"><i class="fa fa-arrow-circle-right"></i>&nbsp;<?php echo 'REFER' ;?></a></li>
											
											<?php }if($_SESSION["user_type"]=="ADMIN"||$_SESSION["user_type"]=="ADMIN+DOCTOR"||$_SESSION["user_type"]=="RECEPTION"){ ?>
							    <li onClick="submitform('<?php echo $lang_delete;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-remove"></i>&nbsp;<?php echo $lang_cancel;?></a></li>
                           <?php } } ?>							   
							   <li onClick="submitform('<?php echo $lang_print;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-print"></i>&nbsp;<?php echo $lang_print_sheet;?></a></li>
							   <li onClick="submitform('<?php echo $lang_print_card;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-credit-card"></i>&nbsp;<?php echo $lang_print_card;?></a></li>
							   <li onClick="submitform('<?php echo $lang_print_registeration;?>','<?php echo $patientInfo[$i][13];?>');"><a href="#"><i class="fa fa-credit-card"></i>&nbsp;<?php echo $lang_print_registeration;?></a></li>
						
                                </ul>
                    </div>
							</td>
						<!--<td><?php echo $patientInfo[$i][49];?></td>-->
                           
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </section>
	  <input type="hidden" name="id" id="id"/>
	 <input type="hidden" name="paction" id="paction" />
	 <input type="hidden" name="revisit" id="revisit" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="is_dupclicate" id="is_dupclicate">
	  <input type="hidden" name="observation_status" id="observation_status">
	  <input type="hidden" name="refered_doctor" id="refered_doctor" />
	  <input type="hidden" name="status_type" id="status_type" />
	  <input type="hidden" name="refer" id="refer" />
	  <input type="hidden" name="whithout_refer" id="whithout_refer" />
	  <input type="hidden" name="ref_id" id="ref_id" />
	  <input type="hidden" name="old_status" id="old_status" />
	  <input type="hidden" name="old_doctor" id="old_doctor" />
	  <input type="hidden" name="obs_opno" id="obs_opno" />
	  <input type="hidden" name="pid" id="pid" />
	  <input type="hidden" name="doc_id" id="doc_id" />
	  <input type="hidden" name="op_visit_id" id="op_visit_id" />
	  
	  <!--.....pagination......-->
  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">

</form>	  
</body>

	</html>
	
