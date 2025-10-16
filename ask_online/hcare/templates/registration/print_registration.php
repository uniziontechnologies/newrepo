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

		html,body{
			height: 100% !important;
		}

 	}

 body {font-size:10px;}
 table.patient_details td {
    padding: 3px !important;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-top: 1px solid;
    padding-left: 10px;
}

.blink_me {
  animation: blinker 1s linear infinite;
     color: orangered;
    font-size: 30px;
    border: 2px solid orangered;
    width: 40%;
    border-radius: 5px;
    margin: 0 auto;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
    
</head>
<body id="frame" > 	
<form name="opsheet" id="form"  method="post" action=""> 


<?php
date_default_timezone_set('Asia/Kolkata');
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];


$patientInfo =$this->popArr['patient_info'];
// var_dump($patientInfo);
$empInfo =$this->popArr['empInfo'];
$post =$this->popArr['post'];

?>

<div id="wrapper" width ="100%" style="margin-top:-20px">
   <div id="content" >
   
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
		<!-- <hr width="100%"> -->
	   <table class="patient_details" width ="100%" border="0">
	
	<tr>
		<td id="noborder" width="40%">
		 	<b><font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_op_no)); ?> &nbsp;:&nbsp; <?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></font></b>
		</td>
		<td id="noborder" width="30%">
			  <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_visit." ".$lang_date)); ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]));?></font>
		</td>
		<td id="noborder">
			<!-- <font size="<?php echo $lang_font_size;?>"> <?php echo ucfirst(strtolower($lang_print_date)); ?>&nbsp;:&nbsp;<?php echo date("d-m-Y h:i a");?></font> -->

			<font size="<?php echo $lang_font_size;?>"> <?php echo ucfirst(strtolower($lang_validity));?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][21]));?></font>
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
		<td id="noborder" colspan="2">
		 	<b><font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_dr)).".";echo ucfirst(strtolower($patientInfo[0][15]." ".$patientInfo[0][16]." ".$empInfo[0][16]." ".$empInfo[0][9]));?></font></b>
		</td>
		<td id="noborder">

			<b>
				<?php if($patientInfo[0][41] == 1) { ?>
				
							 <font size="<?php echo $lang_font_size;?>"><?php echo "Token";?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></font>
				<?php }else { ?>
				 	<font size="<?php echo $lang_font_size;?>"><?php echo "Token";?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></font>
				<?php } ?>
			</b>


		</td>
		<td id="noborder">
			  <!-- <font size="<?php echo $lang_font_size;?>"><?php echo ucfirst(strtolower($lang_hosp_id)); ?>&nbsp;:&nbsp;<?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></font> -->



		</td>
	
	</tr>
	<tr>
		<td id="noborder" >
			 
		</td>
		
		<!-- <td id="noborder">
			<?php if($patientInfo[0][41] == 1) { ?>
			
						 <font size="<?php echo $lang_font_size;?>"><?php echo "F";?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></font>
			<?php }else { ?>
			 	<font size="<?php echo $lang_font_size;?>"><?php echo substr($patientInfo[0][32],0,1);?> &nbsp; : &nbsp;<?php echo $patientInfo[0][36]; ?></font>
			<?php } ?>
		</td> -->
	</tr>
</table>

			<br>
		
					
   					<table align="center" width="100%" class="table" id="datatable" border="1" style="border-collapse: collapse;">
						<tr>
							<td><font size="<?php echo $lang_font_size;?>">SL</font></td>
							<td><font size="<?php echo $lang_font_size;?>">PARTICULARS</font></td>
							<td><font size="<?php echo $lang_font_size;?>">AMOUNT</font></td>							
							
						</tr>
					
									<tr>
										<td><font size="<?php echo $lang_font_size;?>">1</font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_consultation;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo ($patientInfo[0][17]+$patientInfo[0][18])?></font></td>
									
					              </tr>
							<?php if($patientInfo[0][52] >0) { ?>
								  <tr>
										<td><font size="<?php echo $lang_font_size;?>">2</font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_card_fee;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo ($patientInfo[0][52])?></font></td>
									
					              </tr>
							<?php } ?>
 						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo ($patientInfo[0][17]+$patientInfo[0][18]+$patientInfo[0][52])?></font></td>
 						</tr>
 						


 						<?php
 						if (!empty($patientInfo[0][93]) && $patientInfo[0][94]!=0) {?>
 							<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">DISC AMT</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $patientInfo[0][94];?></font></td>
 						</tr>

 						<?php }?>


 							<?Php if (!empty($patientInfo[0][62])) {?>

			 						<tr>
			 							<td colspan="2" align="right" style="color: red;font-size: 15px !important;font-weight: 700;" class="DONTPrint"><font size="<?php echo $lang_font_size;?>" style="font-size: 15px !important">NET AMOUNT TO BE COLLECTED : </font></td>
			  							<td style="color: red;font-size: 15px !important;font-weight: 700;" class="DONTPrint"><font size="<?php echo $lang_font_size;?>" style="font-size: 15px !important"><?php echo ($patientInfo[0][62])?></font></td>
			 						</tr>


 							<?php
 							}





 						 ?>



					
					<table align="center" style="margin-left: 63%;margin-top: 5px;"><tr><td width="25%"><font size="<?php echo $lang_font_size;?>">User : </td><td align="left"><font size="<?php echo $lang_font_size;?>"><?php echo $_SESSION['user_name'];?></font></td></tr>
					<tr><td><font size="<?php echo $lang_font_size;?>">Signature:</font></td><td></td></tr>
					</table>
					<!-- <br> -->
			

<br><br><br>

<div class="blink_me DONTPrint">

	This Is Cash Bill Print Page !!!

</div>

<br><br><br>

				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()">
					<!-- &nbsp;<input type="button" name="prescription" value="Prescription" id="prescription" class="btn btn-primary" onclick="print_prescription()"> -->
					<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()">
					<input type="button" name="back" value="New Registration" id="back" class="btn btn-primary" onclick="newRegistration()">
					<input type="button" name="examination" value="Examination" id="examination" class="btn btn-success" onclick="select_patient('<?php echo $patientInfo[0][0];?>','<?php echo $patientInfo[0][14];?>','<?php echo $patientInfo[0][13];?>');">
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
<input type="hidden" name="pid" id="pid" />
<input type="hidden" name="doc_id" id="doc_id" />
<input type="hidden" name="op_visit_id" id="op_visit_id" />

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
 function newRegistration() {
 
        window.location = "../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration";
        return false;

  }
	function select_patient(opno,doc_id,op_visit_id){
	    
	   $("#pid").val(opno);
	   $("#doc_id").val(doc_id);
	   $("#op_visit_id").val(op_visit_id);


	   $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=op_case_sheet");
	   $("#form").submit();

	}
</script>
</body>
</html>
