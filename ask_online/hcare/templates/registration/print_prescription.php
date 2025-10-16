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
   <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    
<style type="text/css">
    	
	@media print{
		@page{
		    size: auto;
		    margin:30mm 30mm 0mm 0mm;
		}

	}
	html, body{
		height: 100% !important;
	}
    *{
    	/*font-size: 12px;*/
    }
    .patient_details td{
    	padding-bottom: 5px;
    }

</style>
    
</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php
date_default_timezone_set('Asia/Kolkata');
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];

$patientInfo =$this->popArr['patient_info'];
$empInfo =$this->popArr['empInfo'];
$post =$this->popArr['post'];

?>

<div id="wrapper">
   <div id="content" >

   	<div class="row" style="border-top: 1px solid;padding-top: 10px;border-bottom: 1px solid;
    padding-bottom: 10px;">
   		
   		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 ">
   			
			   <table width ="75%" border="0" align="center" style="margin-left: 22%;" class="patient_details">
			
			<tr>

				<td id="noborder" width ="40%" style="font-size: 14px !important;">
					  <font ><?php echo ucfirst(strtolower($lang_hosp_id)); ?>&nbsp;:&nbsp;<?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></font>
				</td>

				<td id="noborder" width ="30%" style="font-size: 14px !important;">
				 	<font ><?php echo ucfirst(strtolower($lang_visit." NO")); ?> &nbsp;:&nbsp; <?php echo $patientInfo[0][39]."/".date("Y",strtotime($patientInfo[0][20]));?></font>
				</td>
				<td id="noborder" width ="30%" style="font-size: 14px !important;">
					  <font ><?php echo ucfirst(strtolower($lang_visit." ".$lang_date)); ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]));?></font>
				</td>

			</tr>
			<tr>
				<td id="noborder" width ="40%" style="font-size: 14px !important;">
					  <font ><?php echo ucfirst(strtolower($lang_name)); ?>&nbsp;:&nbsp;<?php echo ucfirst(strtoupper($patientInfo[0][1]." ". $patientInfo[0][2]." " .$patientInfo[0][3]));?></font>
				</td>
				<td id="noborder" width ="30%" style="font-size: 14px !important;">
					  <font ><?php echo ucfirst(strtolower($lang_age)); ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?></font>
				</td>
				<td id="noborder" width ="30%" style="font-size: 14px !important;">
					  <font ><?php echo ucfirst(strtolower($lang_place)); ?>&nbsp;:&nbsp;<?php echo ucfirst(strtolower($patientInfo[0][8]));?></font>
				</td>
			</tr>
			<tr>

				<td id="noborder" width ="40%" style="font-size: 14px !important;padding: 0px !important;">
					 <font ><?php echo ucfirst(strtolower($lang_dr)).".";echo ucfirst(strtoupper($patientInfo[0][15]." ".$patientInfo[0][16]." (".$empInfo[0][16].")"));?></font>
				</td>

				<td id="noborder" width ="30%" style="font-size: 14px !important;padding: 0px !important;">
				 	<font > <?php echo ucfirst(strtolower($lang_validity));?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][21]));?></font>
				</td>

				<td id="noborder" width ="30%" style="font-size: 13px !important;padding: 0px !important;">
				 	<font > <?php echo ucfirst(strtolower("FEE"));?>&nbsp;:&nbsp;<?php echo $patientInfo[0][17]+$patientInfo[0][18]+$patientInfo[0][51];?></font>
				</td>

			

			
			</tr>
			<tr>

				

			</tr>
		</table>


   		</div>

   	</div>
   

		<!-- <hr width="100%"> -->


<!-- <hr width="100%"> -->

		<br><br><br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"></div>
 

  

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
<script type="text/javascript">
  
  function submitform() {
       document.opsheet.action="../../lib/controllers/centralController.php?module=Registration&sub_module=ManagePatients";
       document.opsheet.submit();
  }

  function print_prescription() {
       document.opsheet.action="../../lib/controllers/centralController.php?module=Registration&sub_module=print_prescription";
       document.opsheet.submit();
  }

</script>
</body>
</html>
