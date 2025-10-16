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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>

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
</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
?>
<section class="content-header">
          <h4><?php echo $lang_op_patients; ?></h4>
		  
        </section>
 <div id="wrapper">
            <div id="content">
			<div id="box">
                	
					<h3> <?php echo $lang_search." ".$lang_inpatient; ?></h3>
					<div align="center">
						<table width="100%">
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
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" /> 		
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
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			<div id="rightnow">
                	<h3 class="reallynow">
						<?php echo $lang_inpatient." ".$lang_list; ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div align="center">
			<table width="100%">
				<thead>
					<tr>
                                                <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						<th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                                                 <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
					         <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						
				                 <th><a href="#"><?php echo $lang_room_no;?></a></th>							
						   <th><a href="#"><?php echo $lang_doctor; ?></a></th>
										                              
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
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						
							
						
						<td>
							<a href="#" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $patientInfo[$i][13];?>');"><img src="../../img/icons/user_edit.png" title="Edit Patient" width="16" height="16" /></a>
							<a href="#" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $patientInfo[$i][13];?>');"><img src="../../img/icons/user_delete.png" title="Delete Patient Visit" width="16" height="16" /></a>
							<a href="#" onClick="submitform('<?php echo $lang_print;?>','<?php echo $patientInfo[$i][13];?>');"><img src="../../img/icons/report_link.png" title="Print OP Sheet" width="16" height="16" /></a>
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
  
</form>
</body>
</html>
