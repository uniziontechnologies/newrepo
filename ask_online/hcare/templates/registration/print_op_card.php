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

</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php
	$patientInfo =$this->popArr['patient_info'];
	$empInfo =$this->popArr['empInfo'];
  $post =$this->popArr['post'];

?>
<div id="wrapper" style="margin-top:140">
   <div id="content" align="center">
   <!-- <table width="20%"  id="noborder" style="font-size:13px" > -->
   <!--<tr>
   <td>.</td>
   </tr>
  <tr>
   <td>.</td>
   </tr>
   <tr>
   <td>.</td>
   </tr>
    <tr>
   <td>.</td>
   </tr>
    <tr>
   <td>.</td>
   </tr>-->
<!-- 	<tr>
		
	   
		<td align="center"><?php echo $patientInfo[0][1]." ". $patientInfo[0][2]." " .$patientInfo[0][3];?>(<?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?>)<BR>
		<?php echo $patientInfo[0][10];?><br>
		Renew On :<?php echo date("d-m-Y",strtotime($patientInfo[0][53]));?></td>
		</tr>
		<tr>
		
		  <td id="noborder"><?php echo "<img src='../../templates/registration/barcode.php?c=barcode&barcode=MID ".$patientInfo[0][0]."&text=".strtoupper($patientInfo[0][47])."/".$patientInfo[0][0]."&width=220&height=40' />"; ?></td>
	
	
</table> -->

<div class="row" style="font-size: 13px !important;width: 80%;">
  
    <div class="col-xs-12">
      
      <label><?php echo $patientInfo[0][1]." ". $patientInfo[0][2]." " .$patientInfo[0][3];?>(<?php echo $patientInfo[0][4]."/ ". $patientInfo[0][6];?>)</label><br>
      <label><?php echo $patientInfo[0][10];?></label><br>
      <label>Renew On :<?php echo date("d-m-Y",strtotime($patientInfo[0][53]));?></label><br>
      <?php echo "<img src='../../templates/registration/barcode.php?c=barcode&barcode=MID ".$patientInfo[0][0]."&text=".strtoupper($patientInfo[0][47])."/".$patientInfo[0][0]."&width=220&height=40' />"; ?>

    </div>

</div>


<div align="center" class="DONTPrint"><input  type="button" name="but" value="Print"  class="btn btn-warning" onClick="Print()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()">

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

</script>
</body>
</html>
<?php exit;?>