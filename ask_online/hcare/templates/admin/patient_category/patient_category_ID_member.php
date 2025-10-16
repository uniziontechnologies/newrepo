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
  
     function submitform(action,id){
     	$('#id').val(id);
     	$('#action').val(action);
     	if(action=='DELETE_MEMBER'){
     		var r = confirm("Do you want to delete!");
			if (r == false) 
			   return false;
     	}
		document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=patient_category_id_member_action";
		document.category.submit();
	}
	function addnew(action,patient_id){
		$('#id').val(patient_id);
		$('#action').val(action);
		document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=add_member_category_patient_id";
		document.category.submit();
	}
	function goback(action){
		$('#id').val($('#category').val());
		$('#action').val(action);
		document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=patient_category";
		document.category.submit();
	}

</script>

</head>
<body id="frame">
	<div>
		<button type="button" name="back" id="back" class="btn btn-info" onClick="goback('MEMBER');">
			<i class="fa fa-arrow-left"></i>
		</button>
	</div>
	<div  id="content">
		<form name="category" id="form"  method="post" action="">
			<?php
			$category=$this->popArr['category'];
			$Memberlist=$this->popArr['CategoryMemberInfo'];
			?>
			<h4 class="col-md-6">MANAGE MEMBERS<?php echo  ' OF MEMBER ID : '.$Memberlist[0][1];?></h4><h4 class="col-md-6"> <?php echo 'PATIENT CATEGORY : '.$category;?></h4>
			<ol class="breadcrumb">
				<button type="button" class="btn btn-success" onClick="addnew('ADD_MEMBER',<?php echo $Memberlist[0][1];?>);">
					<i class="fa fa-plus"></i><?php echo 'ADD MEMBER';?>
				</button>
			</ol>
			<?php if(isset($this->popArr['message'])){?>
			<br /><br />
			<div id='message' class="callout callout-success"><?php echo $this->popArr['message'];?></div>
			<?php } ?>
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo  'MEMBERS OF MEMBER ID : '.$Memberlist[0][1];?></h3>
				</div>
				<div class="box-body">
					<table width="100%" class="table table-striped">
						<thead>
							<tr>
								<th><a href="">SL NO</a></th>
								<th><a href="">First Name</a></th>
								<th><a href="">Last Name</a></th>
								<th><a href="">Place</a></th>
								<th><a href="">Age</a></th>
								<th><a href="">Gender</a></th>
								<th><a href="">Phone</a></th>
								<th><a href="">Remark</a></th>
								<th><a href=""></a></th>						
							</tr>
						</thead>
						<tbody>
							<?php 
							if($Memberlist){
								for($i=0;$i<sizeof($Memberlist);$i++){
									
							?>
							<tr>
								<td><?php echo $i+1;?></td>
								<td><?php echo $Memberlist[$i][2];?></td>
								<td><?php echo $Memberlist[$i][3];?></td>
								<td><?php echo $Memberlist[$i][4];?></td>
								<td><?php echo $Memberlist[$i][5].' '.$Memberlist[$i][11];?></td>
								<td><?php echo $Memberlist[$i][6];?></td>
								<td><?php echo $Memberlist[$i][7];?></td>
								<td><?php echo $Memberlist[$i][9];?></td>
								<td rowspan="<?php echo $count;?>">
									<button type="button" class="btn btn-success" onClick="submitform('EDIT_MEMBER','<?php echo $Memberlist[$i][8];?>');"><i class="fa fa-edit"></i></button>
						     		<button type="button" class="btn btn-danger" onClick="submitform('DELETE_MEMBER','<?php echo $Memberlist[$i][8];?>');"><i class="fa fa-remove"></i></button>
						     	</td>						
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
			</div>
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="action" id="action">
			<input type="hidden" name="category" id="category" value="<?php echo $Memberlist[0][10];?>">
			<input type="hidden" name="patient_ref_id" id="patient_ref_id" value="<?php echo $Memberlist[0][0];?>">
		</form>
	</body>
</html>