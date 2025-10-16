<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>



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
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
	


 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
 <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
 <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

<script>
   
   
     function submitForm(){
   		
		d = new Date();
		today=d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear();
		
		if( document.admission.room.value=='' && document.admission.paction.value == 'SAVE') {
		
   			showDialog('Error','Please Select Room No.','error',2);
			return false;
			
		}else {
			document.admission.action="../../lib/controllers/centralController.php?module=Registration&sub_module=update_observation_status"
			document.admission.submit();
			return true;
		
		}
	}
	
	
	
	$(document).ready(function() {           
           
          
			
			$("#room").change( function(){
			
			 var room_id=$("#room").val();
			 
			 
			 	var data = 'id='+room_id;
				
				inline_action="../../lib/controllers/centralController.php?module=IP&sub_module=process_room";
				
				 $.post(inline_action, data, function (response) {
				 	console.log(response);
				 
				 	var bedInfo=response['bedInfo'];
				 	var hcharges=response['hcharges'];
				 	// alert(bedInfo);
				 	// alert(hcharges);
					
					$("#bed_no option").remove();
						for(i=0;i<bedInfo.length;i++){
						
							$("#bed_no").append("<option value='"+bedInfo[i][0]+"'>"+bedInfo[i][1]+" </option>");
						
						}
				$("#hcharge").val(response['hcharges']);
				 },"json");
			
			});
                      
			
        });
</script>

</head>
<body id="frame">
<form name="admission" id="form"  method="post" action="" enctype="multipart/form-data" onload="initailize();"> 


<?php

 
$action=$this->popArr['action'];
$status = $this->popArr['status'];
$opid = $this->popArr['opid'];
$observation_status = $this ->popArr['observation_status'];
$posts = $this->popArr['post'];
$roomInfo=$this->popArr['roomInfo'];
// var_dump($posts);

// var_dump($post);
?>
<div  id="content">
	<section class="content-header">
		<h1>
		<?php echo $lang_admission; ?>
		</h1>
		<?php if($posts['id'] != ""){?>
		<ol class="breadcrumb">
			<?php
			if(file_exists("../../templates/registration/patient_photo/".$posts['obs_opno0']."/photo.jpg")){
			?>
			<img src="../../templates/registration/patient_photo/<?php echo $posts['obs_opno0'];?>/photo.jpg" width="80" height="80">
			<?php
									}else{
			?>
			<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
			<?php } ?>
		</ol><br><br> <br>
		<?php } ?>
	</section><!-- 
	<input name="ipno" id="ipno" type="hidden" value="<?php //echo (!empty($post['ipno']))?$post['ipno']:''?>" />
	<b><?php //echo $lang_ip_no; ?> :<?php //echo (!empty($post['ipno']))?$post['ipno']:''?></b> -->
	<input name="opno" id="opno" type="hidden" value="<?php echo (!empty($posts['obs_opno0']))?$posts['obs_opno0']:''?>" />
	<b><?php echo $lang_op_no; ?> :<?php echo (!empty($posts['obs_opno0']))?$posts['obs_opno0']:''?></b>
	<?php if($action == "SAVE") { ?>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $lang_select." ".$lang_room;?></h3>
		</div>
		<table  class="table table-striped" style="width: 500px;">
			<tr>
				<td id="noborder">
					<?php echo $lang_room_no; ?> <span id='requiredfield'>*</span>:
				</td>
				<td id="noborder">
					<select name="room" id="room">
						<option value="">-----------</option>
						<?php if(!empty($roomInfo)){
						for($i=0;$i<count($roomInfo);$i++) { ?>
						<option value="<?php echo $roomInfo[$i][0];?>"><?php echo $roomInfo[$i][1];?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td id="noborder">
					<?php echo $lang_bed_no; ?> <span id='requiredfield'>*</span>:
				</td>
				<td id="noborder">
					<select name="bed_no" id="bed_no">
					</select>
				</td>
			</tr>
			<tr>	
				<td id="noborder">
					<?php echo $lang_observation_charge; ?> <span id='requiredfield'>*</span>:
				</td>
				<td id="noborder">
					<input type="text" name="hcharge" id="hcharge" readonly size="8"/>
				</td>
			</tr>
		</table>
	</div>
	<?php }else{ ?>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $lang_room;?></h3>
		</div>
		<table  class="table table-striped">
			<?php
			$cur_ad_date=='';
			$roomhist=$this->popArr['roomhist'];
			if(!empty($roomhist)){
			for($i=0;$i<count($roomhist);$i++) {
			?>
			<tr>
				<td id="noborder">
					<?php echo $lang_room_no; ?> &nbsp;:<?php echo $roomhist[$i][7];?>
				</td>
				<td id="noborder">
					<?php echo $lang_bed_no; ?> &nbsp;:<?php echo $roomhist[$i][8];?>
				</td>
				<td id="noborder">
					<?php echo $lang_rent; ?>&nbsp; :<?php echo $roomhist[$i][6];?>
				</td>
				<td id="noborder">
					<?php echo $lang_nursing_charges; ?>&nbsp; :<?php echo $roomhist[$i][8];?>
				</td>
				<td id="noborder">
					<?php echo $lang_maintenance; ?>&nbsp; :<?php echo $roomhist[$i][9];?>
				</td>
				<td id="noborder">
					<?php echo $lang_from_date; ?>&nbsp; :<?php echo date("d-m-Y",strtotime($roomhist[$i][2]));?>
				</td>
				<td id="noborder">
					<?php echo $lang_to_date; ?>&nbsp; :<?php echo date("d-m-Y",strtotime($roomhist[$i][3]));?>
				</td>
			</tr>
			<?php
			if($i==(count($roomhist)-1)){
			$cur_ad_date=$roomhist[$i][3];
			}
			}
			}
			?>
			<tr style="font-weight:bold;">
				<td id="noborder">
					<?php echo $lang_room_no; ?> &nbsp;:<?php echo $post['room_no'];?>
					<input type="hidden" name="old_room" value="<?php echo $post['room_no'];?>" />
					<input type="hidden" name="room_id" value="<?php echo $post['room_id'];?>" />
				</td>
				<td id="noborder">
					<?php echo $lang_bed_no; ?> &nbsp;:<?php echo $post['bed_no'];?>
					<input type="hidden" name="bed_id" value="<?php echo $post['bed_id'];?>" />
				</td>
				<td id="noborder">
					<?php echo $lang_rent; ?>&nbsp; :<?php echo $post['rent'];?>
					<input type="hidden" name="current_rent" value="<?php echo $post['rent'];?>" />
				</td>
				<td id="noborder">
					<?php echo $lang_nursing_charges; ?>&nbsp; :<?php echo $post['ncharge'];?>
					<input type="hidden" name="current_ncharge" value="<?php echo $post['ncharge'];?>" />
				</td>
				<td id="noborder">
					<?php echo $lang_maintenance; ?>&nbsp; :<?php echo $post['mcharge'];?>
					<input type="hidden" name="current_mcharge" value="<?php echo $post['mcharge'];?>" />
				</td>
				<td id="noborder">
					<?php echo $lang_from_date; ?>&nbsp; :<?php echo (!empty($cur_ad_date))?date("d-m-Y",strtotime($cur_ad_date)):date("d-m-Y",strtotime($post['admission_date']));?>
				</td>
			</tr>
		</table>
	</div>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $lang_room_transfer;?></h3>
		</div>
		<table  class="table table-striped">
			<tr>
				<td id="noborder">
					<?php echo $lang_room_no; ?> <span id='requiredfield'>*</span>:
				</td>
				<td id="noborder">
					<select name="room" id="room">
						<option value="">-----------</option>
						<?php if(!empty($roomInfo)){
						for($i=0;$i<count($roomInfo);$i++) { ?>
						<option value="<?php echo $roomInfo[$i][0];?>"><?php echo $roomInfo[$i][1];?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</td>
				<td id="noborder">
					<?php echo $lang_bed_no; ?> <span id='requiredfield'>*</span>:
				</td>
				<td id="noborder">
					<select name="bed_no" id="bed_no">
					</select>
				</td>
				<td><?php echo $lang_observation_charge; ?></td>
				<td id="noborder">
					<input type="text" name="hcharge" id="hcharge" readonly />
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
	<?php if(!isset($this->popArr['message1'])){
	if($action =="SAVE"){
	?>
	<input id="button1" type="button" name="admit"  class="btn btn-success" value="ADMIT FOR OBSERVATION" onclick="return submitForm()"/>
	<?php  }else{ ?>
	<input id="button1" type="button" name="admit" class="btn btn-success" value="UPDATE OBSERVATION" onclick="return submitForm()"/>
	<!--<input id="button1" type="button" name="trasfer" class="trasfer" value="Transfer Room" onclick="return submitForm()"/>-->
	<input id="button1" type="button" name="discharge" class="btn btn-info" value="DISCHARGE FROM OBSERVATION" onclick="return submitForm()"/>
	<?php  } ?>
	<?php }else { ?>
	<br /><font color="#FF0000"><?php echo $this->popArr['message1']; ?></font>
	<?php } ?>
</div>
<input name="paction" id="paction" type="hidden" value="<?php echo $action;?>" />
<input name="id" id="id" type="hidden" value="<?php echo $opid;?>" />
<input type="hidden" name="observation_status" id="observation_status" value="<?php echo $observation_status;?>">

<input type="hidden" name="from_date" id="from_date" value="<?php echo $posts['from_date'];?>"/>
<input type="hidden" name="to_date" id="to_date" value="<?php echo $posts['to_date'];?>"/>
<input type="hidden" name="doctor" id="doctor" value="<?php echo $posts['doctor'];?>"/>
<input type="hidden" name="first_name" id="first_name" value="<?php echo $posts['first_name'];?>"/> 
<input type="hidden" name="place" id="place" value="<?php echo $posts['place'];?>" /> 	 
<input type="hidden" name="contact_no" id="contact_no" value="<?php echo $posts['contact_no'];?>" />	
<input type="hidden" name="paction" id="paction" value="<?php echo $posts['paction'];?>" /> 	 
<input type="hidden" name="current_page" id="current_page" value="<?php echo $posts['current_page'];?>" />	

</form>
</body>
</html>