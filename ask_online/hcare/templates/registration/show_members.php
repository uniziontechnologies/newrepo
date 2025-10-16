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


	function search(action){
		$('#action').val(action);
		var cat_id = $('#category_id').val();
		if(action=='CLEAR'){
			$('#patient_id').val('');
			$('#m_name').val('');
			$('#age').val('');
			$('#phone').val('');
			$('input[type=radio]').attr('checked', false);
			tb_show('Select OP Patient',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_members&cat_id="+cat_id);
		}
		else{			
			var patient_id =  $('#patient_id').val();
			var m_name = $('#m_name').val();
			var age = $('#age').val();
			var phone = $('#phone').val();
			var gender = '';	
			if( $('#gender').is(":checked") ){ // check if the radio is checked
	            var gender = $('#gender').val(); // retrieve the value
	        }
		tb_show('Select OP Patient',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_members&cat_id="+cat_id+"&patient_id="+patient_id+"&m_name="+m_name+"&age="+age+"&phone="+phone+"&gender="+gender);
	    }
		
	}
	function submitform(member_id){
		$('#member_id').val(member_id);		
		$('#form').attr('action',"../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&paction=PROCESS_FORM");
		$('#form').submit();
	}

</script>

</head>
<body id="frame">
	<div  id="content">
		<form name="category" id="form"  method="post" action="">
			
			<?php
			$arrList=$this->popArr['PatientCategoryInfo'];
			$Memberlist=$this->popArr['CategoryMemberInfo'];
			$category_id = $arrList[0][0];
			$Search = $this ->popArr['Search'];

			function countelement($element,$list){
				$no_elements = 0;
				for($k=0;$k<sizeof($list);$k++){
					if($list[$k][1]==$element)
					{
						$no_elements++;
					}
				}
				return $no_elements;
			}
			?>
			<h4 class="col-md-6">CATEGORY MEMBERS</h4><h4 class="col-md-6"> <?php echo 'PATIENT CATEGORY : '.$arrList[0][1];?></h4>
			
			<div class="box box-info"><!-- 
				<div class="box-header with-border">
					<h3 class="box-title"><?php //echo  $lang_patient_category." ".$lang_information;?></h3>
				</div> -->
				<div class="box-body">
					<table  width="100%">
						<tr>
							<td id="noborder">MEMBER ID :</td>
							<td>
								<input type="text" name="patient_id" id="patient_id" autocomplete="off" value="<?php echo (!empty($Search['patient_id']))?$Search['patient_id']:''?>">
							</td>
							<td id="noborder">MEMBER NAME : </td>
							<td><input type="text" name="m_name" id="m_name" autocomplete="off" value="<?php echo (!empty($Search['m_name']))?$Search['m_name']:''?>">
							</td>
							<td id="noborder">AGE : </td>
							<td><input type="text" name="age" id="age" autocomplete="off" value="<?php echo (!empty($Search['age']))?$Search['age']:''?>">
							</td>
							<td id="noborder">GENDER : </td>
							<td>
								<input type="radio" name="gender" id="gender" value="M" <?php if($Search['gender']=='M'){?> checked <?php }?>>Male
							<input type="radio" name="gender" id="gender" value="F" <?php if($Search['gender']=='F'){?> checked <?php }?>>Female
						</td>
						</tr>
						<tr>
							<td id="noborder">CONTACT NO : </td>
							<td>
								<input type="text" name="phone" id="phone" autocomplete="off" value="<?php echo (!empty($Search['phone']))?$Search['phone']:''?>">
							</td>
							<td id="noborder"><input type="button" name="Search" id="Search" class="btn btn-success" value="Search" onclick="search('SEARCH');"/>
								<input type="button" name="clear" id="clear" class="btn btn-warning" value="Clear" onclick="search('CLEAR');"/></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo  $lang_patient_category." ".$lang_information;?></h3>
				</div>
				<div class="box-body">
					<table width="100%" class="table table-striped" id="value_table">
						<thead>
							<tr>
								<th rowspan="2"><a href="">SL NO</a></th>
								<th rowspan="2"><a href="">MEMBER ID</a></th>
								<th><a href="">MEMBERS INFORMATION</a></th>
							</tr>
							<tr>
								<th><a href="">First Name</a></th>
								<th><a href="">Last Name</a></th>
								<th><a href="">Place</a></th>
								<th><a href="">Age</a></th>
								<th><a href="">Gender</a></th>
								<th><a href="">Phone</a></th>
								<th><a href=""></a></th>						
							</tr>
						</thead>
						<tbody>
							<?php 
							$j=0;
							$p_id = null;
							if($Memberlist){
								for($i=0;$i<sizeof($Memberlist);$i++){
									if($p_id != $Memberlist[$i][1]){
										$p_id = $Memberlist[$i][1];	
										$condition  = 'new';
										$count = countelement($p_id,$Memberlist);
									}
									else{
										$condition = 'old';
									}
							?>
							<tr><?php 
								if($condition=='new'){
								?>
								<td rowspan="<?php echo $count;?>"><?php echo ++$j;?></td>
								<td rowspan="<?php echo $count;?>"><?php echo $Memberlist[$i][1];?></td>
								<?php }?>
								<td><?php echo $Memberlist[$i][2];?></td>
								<td><?php echo $Memberlist[$i][3];?></td>
								<td><?php echo $Memberlist[$i][4];?></td>
								<td><?php echo $Memberlist[$i][5].' '.$Memberlist[$i][11];?></td>
								<td><?php echo $Memberlist[$i][6];?></td>
								<td><?php echo $Memberlist[$i][7];?></td>								
								<td>
									<button type="button" class="btn btn-success" onClick="submitform('<?php echo $Memberlist[$i][8];?>');">Select</button>
						     	</td>					
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
			</div>
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="action" id="action">
			<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id;?>">
			
		</form>
	</body>
</html>