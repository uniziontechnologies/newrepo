<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

<script type="text/javascript">

 $(document).ready(function(){
 
 
 	$(".lab_report").bind('click', function() {
		
			$("#ip_no").val($(this).attr("id"));
			
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Report&sub_module=ip_detailed_lab_report");
			$("#form").submit();
		});
 });


</script>
<script type="text/javascript">


function submitform(action,id){

	
        document.patients.paction.value=action;
		document.patients.id.value=id;
   		document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_patient_report";
		document.patients.submit();
    
}
</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$ipbillInfo=$this  ->popArr['ipbillInfo'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_inpatient; ?></h4>
		  
        </section>
 
		<section class="content">
			<div class="DONTPrint">			 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_admitted_on; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="admitted_on" id="admitted_on"  class="DatePicker" value="<?php echo (!empty($post['admitted_on']))?$post['admitted_on']:'';?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_discharged_on; ?>:</td>
										<td id="noborder" >	<input type="text" name="discharged_on" id="discharged_on"  class="DatePicker" value="<?php echo (!empty($post['discharged_on']))?$post['discharged_on']:'';?>" readonly="true"/>
											
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
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
                	<h3 >
						<?php echo $lang_inpatient." ".$lang_list; ?>
						</a>
                       
					
					</h3>
					<div align="left"><?php echo !empty($post['ipno'])?"IPNO : ".$post['ipno']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['opno'])?"OPNO : ".$post['opno']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['doc_name'])?"Doctor : ".$post['doc_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['room_no'])?"Room No : ".$post['room_no']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
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
						 <th width="5%"><a href="#"><?php echo $lang_discharged_on; ?></a></th>
					     <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						 <th><a href="#"><?php echo $lang_room_no;?></a></th>							
						 <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_lab_report; ?></a></th>
						
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr <?php echo ($patientInfo[$i][22] == '0000-00-00')?'class="text-red"':'';?>>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
						<td><?php echo $patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php echo ($patientInfo[$i][22] == '0000-00-00')?'':$patientInfo[$i][22];?></td>
						<td><?php echo $patientInfo[$i][21];?></td>
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						<th width="5%"><a href="#" class="lab_report" id="<?php echo $patientInfo[$i][13];?>"><?php echo $lang_lab_report; ?></a></th>
						
						
                           
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
	  <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">
	  <input type="hidden" name="ip_no" id="ip_no" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
  
</form>
</body>
</html>
