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

<script>

   
  function print_op_card(){
	
	      document.opsheet.action="../../lib/controllers/centralController.php?module=Registration&sub_module=print_op_card";
		  document.opsheet.submit();
	}
  function print_op_registration(){
	
	      document.opsheet.action="../../lib/controllers/centralController.php?module=Registration&sub_module=print_registration";
		  document.opsheet.submit();
	}
	function submitform() {
	       document.opsheet.action="../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients";
	       document.opsheet.submit();
	}
 </script>
 <style>

 	@media print{

		html,body{
			height: 100% !important;
		}

 	}

 body {font-size:10px;}
 table.patient_details td {
    padding: 3px !important;
}

.blink_me {
  animation: blinker 1s linear infinite;
     color: orangered;
    font-size: 30px;
    border: 2px solid orangered;
    width: 40%;
    border-radius: 5px;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

 </style>
 <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>

</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];

	$patientInfo =$this->popArr['patient_info'];
	$empInfo =$this->popArr['empInfo'];
	$post =$this->popArr['post'];

?>
<div id="wrapper" style="margin-top:-20px">
   <div id="content" align="center">

 	  <table width ="100%" style="margin-bottom: 20px;">
	 	<!--  <tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="120px"></img></td>
		</tr> -->
	 
	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>
		
		</table>

   <table class="patient_details" width ="100%" border="0">
	<tr>
		<td id="noborder" colspan="2" width="80%">
			 <font size="<?php echo $lang_font_size;?>"><b><?php echo ucfirst(strtolower($lang_dr)).".";echo ucfirst(strtolower($patientInfo[0][15]." ".$patientInfo[0][16]." "));echo strtoupper($empInfo[0][16]." ");echo ucfirst(strtolower($empInfo[0][9]));?></b></font>
		</td>
		
		<td id="noborder" width="20%">
			<?php if($patientInfo[0][41] == 1) { ?>
			
						 <font size="<?php echo $lang_font_size;?>"><b><?php echo "Token";?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></b></font>
			<?php }else { ?>
			 	<font size="<?php echo $lang_font_size;?>"><b><?php echo "Token";?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></b></font>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td id="noborder" width="40%">
		 	<b><font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_op_no)); ?> &nbsp;:&nbsp; <?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></font></b>
		</td>
		<td id="noborder" width="30%">
			  <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_date)); ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]));?></font>
		</td>
		<td id="noborder" width="30%">
			<font size="<?php echo $lang_font_size;?>"> <?php echo ucfirst(strtolower($lang_time)); ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][19];?></font>
		</td>
	</tr>
	<tr>
		<td id="noborder">
			  <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_name)); ?>&nbsp;:&nbsp;<?php echo ucfirst(strtolower($patientInfo[0][1]." ". $patientInfo[0][2]." " .$patientInfo[0][3]));?></font>
		</td>
		<td id="noborder">
			  <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_age)); ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?></font>
		</td>
		<td id="noborder">
			  <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_place)); ?>&nbsp;:&nbsp;<?php echo ucfirst(strtolower($patientInfo[0][8]));?></font>
		</td>
	</tr>
	<tr>
		<td id="noborder">
		 	<font size="<?php echo $lang_font_size;?>"> <?php echo ucfirst(strtolower($lang_validity));?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][21]));?></font>
		</td>
		<td id="noborder"></td>
		<td id="noborder">
			  <!-- <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_hosp_id)); ?>&nbsp;:&nbsp;<?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></font> -->
		</td>
	
	</tr>
</table>
<input type="hidden" name="id" value="<?php echo $patientInfo[0][13];?>">
<!--<table width ="100%">
	<tr>
		<td id="noborder">
			<b><?php echo $lang_op_no; ?> : <?php echo $patientInfo[0][0];?></b>
		</td>
		<td id="noborder">
			 <?php echo $patientInfo[0][1]." ". $patientInfo[0][2]." " .$patientInfo[0][3];?>
		</td>
		<td id="noborder">
			 <?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?>
		</td>
		<td id="noborder">
			 <?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?>
		</td>
		<td id="noborder">
			 <?php echo $patientInfo[0][8];?>
		</td>
	</tr>
	<tr>
		<td id="noborder">
		<b>	<?php echo $lang_reg_fee; ?> : <?php echo $patientInfo[0][17]+$patientInfo[0][18];?></b>
		</td>
		<td id="noborder">
			 <?php echo date("d-m-Y",strtotime($patientInfo[0][20]))." ".$patientInfo[0][19];?>
		</td>
		<td id="noborder">
			 <?php echo date("d-m-Y",strtotime($patientInfo[0][21]));?>
		</td>
		
	</tr>
	
</table>-->

<br><br><br>

<div class="blink_me DONTPrint">

	This Is Prescription Print Page !!!

</div>

<br><br><br>

<div align="center" class="DONTPrint"><input  type="button" name="but" value="Print" class="btn btn-warning"  onClick="Print()">
&nbsp;<input type="button" name="Print Registration" value="Print Registration (Cash Bill)" id="Print_r Registration" class="btn btn-success" onclick="print_op_registration()">
<input  type="button" name="print_card" value="Print Card" class="btn btn-info" onClick="print_op_card()"/>&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()">
									</div>

</div>
</div>

<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="opno" value="<?php echo(!empty($post['opno']))?$post['opno']:''; ?>">
<input type="hidden" name="doctor" value="<?php echo(!empty($post['doctor']))?$post['doctor']:''; ?>">
<input type="hidden" name="first_name" value="<?php echo(!empty($post['first_name']))?$post['first_name']:''; ?>">
<input type="hidden" name="place" value="<?php echo(!empty($post['place']))?$post['place']:''; ?>">
<input type="hidden" name="contact_no" value="<?php echo(!empty($post['contact_no']))?$post['contact_no']:''; ?>">
<input type="hidden" name="id" value="<?php echo(!empty($post['id']))?$post['id']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">

</form>

</body>
</html>
