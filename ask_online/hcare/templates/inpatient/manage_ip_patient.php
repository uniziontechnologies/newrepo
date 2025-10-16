
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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>




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
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manageInpatient");
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manageInpatient");
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manageInpatient");
                 $("#form").submit();
              });
  });  
/*........pagination.........*/
	  </script>
<script type="text/javascript">


function submitform(action,id){

	if(action == "EDIT_PAGE"){
	
		
		document.patients.paction.value=action;
		document.patients.id.value=id;
		document.patients.action="../../lib/controllers/centralController.php?module=IP&sub_module=Admission_Form";
		document.patients.submit();
	}else{
                 document.patients.paction.value=action;
		document.patients.id.value=id;
   		document.patients.action="../../lib/controllers/centralController.php?module=IP&sub_module=manageInpatient";
		document.patients.submit();
     }

}

	function redirect(pid,action){
	    
		document.patients.id.value=pid;

		document.patients.action="../../lib/controllers/centralController.php?module=IP&sub_module=discharge_summary_templates";

		document.patients.submit();
	}

</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];
?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_inpatient; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
											
										</td>
										<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	<input name="ipno" id="ipno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" autocomplete="off"/>
									</td>
										<td id="noborder">
										<?php echo $lang_op_no; ?></td>
									<td id="noborder" >	<input name="opno" id="opno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" autocomplete="off"/>
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
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor" class="select2"   onkeypress="nextField(event.keyCode,inc)" /> 		
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
								<td id="noborder">
									<?php echo $lang_room_no; ?></td>
									<td id="noborder" >	 <input name="room_no" id="room_no" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['room_no']))?$post['room_no']:''?>" autocomplete="off"/> 
								 
								</td>
								</tr>
								<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			
                	<h3 >
						<?php echo $lang_inpatient." ".$lang_list; ?>
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
						 <th><a href="#">UPDATE HISTORY</a></th>			                              
						  <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
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
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?>
							<?php if ($patientInfo[$i][66] ==1) {?>
							
						<br>
						<span class='text-red' ><small>(Bystander added)</small></span>
					<?php }?>
						</td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						
						<td><?php echo $patientInfo[$i][48];?></td>	
						
						<td>
							<?php if ($_SESSION['user_type'] !='DOCTOR') {  ?>
								 <a href="#" class="btn btn-warning btn-flat" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $patientInfo[$i][13];?>');"><i class="fa fa-edit"></i></a>
					    	<?php	} ?>
						       
							<!--<a href="#" class="btn btn-danger btn-flat" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $patientInfo[$i][13];?>');"><i class="fa fa-remove"></i></a>-->

							<a href="#" class="btn btn-success btn-flat" onclick="redirect('<?php echo $patientInfo[$i][13];?>','discharge_summary')"><i class="fa fa-file-text"></i></a>
                          
                          	<?php //if ($_SESSION['user_type'] !='DOCTOR') {  ?>

                          		<!-- <a href="#" class="btn btn-info btn-flat" onClick="submitform('<?php //echo $lang_print;?>','<?php //echo $patientInfo[$i][13];?>');"><i class="fa fa-print"></i></a> -->
                            <?php	//} ?>

							
							</td>
                           
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <!--.....pagination......-->
  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
  
</form>
</body>
</html>
