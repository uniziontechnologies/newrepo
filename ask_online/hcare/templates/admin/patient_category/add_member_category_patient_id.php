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
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		 <!-- jQuery 2.1.4 -->
    
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- <script type="text/javascript" src="../../dist/js/common_functions.js">  </script> -->

<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

<script>
  
     function submitForm(action,id){ 
     	$('#id').val(id);
     	$('#action').val(action);
   		if(document.category.patient_id.value=='') {
   			showDialog('Error','Please Enter Patient ID.','error',2);
			return false;
			
		}
		else if(document.category.f_name.value=='') {
   			showDialog('Error','Please Enter Patient Name.','error',2);
			return false;
			
		}else if(document.category.place.value=='') {
   			showDialog('Error','Please Enter Patient Place.','error',2);
			return false;
			
		}else if(document.category.age.value=='') {
   			showDialog('Error','Please Enter Patient Age.','error',2);
			return false;
			
		}else if(document.category.age_type.value=='') {
   			showDialog('Error','Please Enter Patient Age type.','error',2);
			return false;
			
		}else if(document.category.gender.value=='') {
   			showDialog('Error','Please Enter Patient Gender.','error',2);
			return false;
			
		}else if(document.category.phone.value=='') {
   			showDialog('Error','Please Enter Patient Phone.','error',2);
			return false;
			
		}else {
			document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=add_category_member";
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
			$category_id = $arrList[0][0];
			$MemberInfo=$this->popArr['MemberInfo'];
			$addmember = $this ->popArr['addmember'];
			?>
			<section class="content-header">
				<?php if($MemberInfo){
					echo '<h4>EDIT MEMBER</h4>';
				}else if($addmember){
					echo '<h4>ADD MEMBER</h4>';
				}else{
					echo '<h4>ADD MEMBER ID</h4>';
				}?>
				
			</section>
			<div id='required'><?php echo $lang_markedfieldrequired; ?></div>
			<!-- Main content -->
			<?php if(isset($this->popArr['message'])){?>
			<br /><br />
			<div id='message' class="callout callout-danger"><?php echo $this->popArr['message'];?></div>
			<?php } ?>
			<div class="row">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo  "MEMBER ".$lang_information;?></h3>
						</div>
						<div class="box-body">
							<table width="100%" class="table table-striped">
								<tr>
									<td>Member ID *</td>
									<?php if($MemberInfo){
										?>									
									<td><input type="text" name="patient_id" id="patient_id" value="<?php echo $MemberInfo[0][1];?>" readonly></td>
									<?php 
									}else if($addmember){
										?>
									<td><input type="text" name="patient_id" id="patient_id" value="<?php echo $addmember['id'];?>" readonly></td>
								<?php }else{
									?>
									<td><input type="text" name="patient_id" id="patient_id"></td>
								<?php }?>
								</tr>
								<tr>
									<td>First Name *</td>
									<td><input type="text" name="f_name" id="f_name" value="<?php echo (!empty($MemberInfo[0][2]))?$MemberInfo[0][2]:''?>"></td>
								</tr>
								<tr>
									<td>Last Name</td>
									<td><input type="text" name="l_name" id="l_name" value="<?php echo (!empty($MemberInfo[0][3]))?$MemberInfo[0][3]:''?>"></td>
								</tr>
								<tr>
									<td>Place *</td>
									<td><input type="text" name="place" id="place" value="<?php echo (!empty($MemberInfo[0][4]))?$MemberInfo[0][4]:''?>"></td>
								</tr>
								<tr>
									<td>Age *</td>
									<td><input type="text" name="age" id="age" size="8" value="<?php echo (!empty($MemberInfo[0][5]))?$MemberInfo[0][5]:''?>">
										<input type="radio" name="age_type" id="age_type" value="Y" <?php if($MemberInfo[0][11]=='Y'){?> checked <?php }?>>Y
										<input type="radio" name="age_type" id="age_type" value="M" <?php if($MemberInfo[0][11]=='M'){?> checked <?php }?>>M
										<input type="radio" name="age_type" id="age_type" value="D" <?php if($MemberInfo[0][11]=='D'){?> checked <?php }?>>D
									</td>
								</tr>
								<tr>
									<td>Gender *</td>
									<td><input type="radio" name="gender" id="gender"  value="M" <?php if($MemberInfo[0][6]=='M'){?> checked <?php }?>>Male
										<input type="radio" name="gender" id="gender"  value="F" <?php if($MemberInfo[0][6]=='F'){?> checked <?php }?>>Female</td>
								</tr>
								<tr>
									<td>Phone *</td>
									<td><input type="text" name="phone" id="phone" value="<?php echo (!empty($MemberInfo[0][7]))?$MemberInfo[0][7]:''?>"></td>
								</tr>
								<tr>
									<td>Remark</td>
									<td><textarea name="remark" id="remark" value="<?php echo (!empty($MemberInfo[0][9]))?$MemberInfo[0][9]:''?>"></textarea></td>
								</tr>	
								<tr><td></td>
									<?php
									if($MemberInfo){
										?>
										<td><input id="edit" type="button" name="edit" class="btn btn-success" value="EDIT" class="save" onClick="submitForm('EDIT','<?php echo $MemberInfo[0][8];?>')"/></td>
										<?php
									}else if($addmember){
										?>
										<td><input id="save_member" type="button" name="save_member" class="btn btn-success" value="SAVE" class="save" onClick="submitForm('ADD_MEMBER',' <?php echo $addmember['patient_ref_id'];?>')"/></td>
										<?php
									}
									else{
										?>
										<td><input id="save" type="button" name="save" class="btn btn-success" value="Save" class="save" onClick="submitForm('ADD','<?php echo $category_id;?>');"/></td>
										<?php
									} ?>
									
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="action" id="action">			
		</form>
	</body>
</html>

