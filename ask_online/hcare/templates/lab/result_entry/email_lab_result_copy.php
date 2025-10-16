<?php
if (!empty($this->popArr['email'])) {
	ob_start();
}
?>
<?php
if (!empty($this->popArr['pdf_download_status'])) {
	ob_start();
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css"> 
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>   
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>

    <style>
	    #bill{
	    	page-break-inside: auto !important;
	    }
	    #bill tr.rowstyle td { 
	    	padding-bottom: 5px;
	    }
	    #form tr{ 
	    	height: 50px;
	    }

	    /*#footer {
    	position: relative;
    	bottom: 10px;
    	font-size: 16px;
    	font-weight: 700;
    	/*margin-bottom: 0px;  negative value of footer height 
    	height: 180px;*/
    	/*clear: both;*/
  	/*}*/
  	#footer {
        display: block;
        width:100%;        
        position:fixed;
        left:0;
        bottom:0;  
   /* 	font-size: 16px;
    	font-weight: 700;*/
  	}
	/*.footer_details {
	    font-size: 12px !important;
	}*/
	table#patient_details td{
	padding-bottom: 10px !important; 
}
@media print{
	html, body{
		height: 100% !important;
	}
	
}

td.first_row {
    width: 35% !important;
}
td.second_row {
    width: 20% !important;
}
td.third_row {
    width: 20% !important;
}
td.fourth_row {
    width: 20% !important;
}



	</style>

</head>
<body id="frame">
	<form name="result_entry" id="form"  method="post"> 
	<div id="content">
		<?php
		require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';
		$hobj=new HospitalInfo();
		$hinfo=$hobj->getHospitalInfo();
		$clinic_name=$hinfo[1];
		$city=$hinfo[3];
		$state=$hinfo[4];
		$pincode=$hinfo[6];
		$phone=$hinfo[7];
		$email=$hinfo[9];
			
		$resultInfo=$this  ->popArr['resultInfo'];
		$resultEntryInfo=$this  ->popArr['resultEntryInfo'];
		$billInfo=$this  ->popArr['billInfo'];
		$post=$this  ->popArr['post'];
		$billno=$this  ->popArr['billno'];
		$empInfo=$this  ->popArr['EmployeeInfo'];
		// $automated_email_status=$this  ->popArr['automated_email_status'];
		// var_dump($empInfo);exit();
			
		?>

		<section class="content">
		<p style="margin-top:-80px; margin-left:-80px;">
			<img src="../../dist/img/logo.png" width="100%" height="150px"></img>
		</p>
		<br>
			
		<div style="background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0 #91c6e3 !important;">PATIENT DETAILS</div><br>

			<table width="100%" id="patient_details">
				<tr>
				    <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][3];?></font></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_bill_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][0];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][8];?></font></td>
				 </tr>
				  <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_recieved_date;?>&nbsp;&nbsp;&nbsp;:<?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_result_date;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo ($resultInfo[0][2]!='')?date("d-m-Y",strtotime($resultInfo[0][2])):date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_print_date;?>&nbsp;:<?php echo date("d-m-Y");?></font></td>
				  </tr>  
			</table>
			<br>
		<div style="background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0 #91c6e3 !important;">TEST RESULT REPORT</div>
		<br>

			
			<table width="100%" id="bill" >
				<thead>
					
					<tr>
				
						<th><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_name; ?></font></th>
						<th><font size="<?php echo $lang_font_size;?>"><?php echo $lang_value; ?></font></th>
						<th><font size="<?php echo $lang_font_size;?>"><?php echo $lang_unit; ?></font></th>
						<th><font size="<?php echo $lang_font_size;?>"><?php echo $lang_normal_range; ?></font></th>

													
					</tr>
					<tr><th colspan='4'>&nbsp;</th></tr>
					
				</thead>
				<tbody>
					<?php
					    if(!empty($resultEntryInfo)){
							$m=0;
						
						  for($i=0;$i<count($resultEntryInfo);$i++){ 
						  
						  if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3){
								  
								    if(!isset($k)) $k=0;
									else $k++;
						  }
						  ?>

                           <tr  class='resRow<?php echo $k;?> rowstyle' id="res_elem<?php echo $m;?>">
							  <!-- <th class='DONTPrint' style="padding-bottom: 10px;" > 
							  
							  <?php if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3 ){
								 
								  ?>
							         <input type='checkbox' name='view' id='<?php echo $k;?>' class='view_res' ></th>
																	  
							                         <?php } ?> -->
													 
										<!-- 			 <?php if($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20 || $resultEntryInfo[$i][7] ==2){
								 
								  ?>
							                          <input type='checkbox' name='view' id='elem<?php echo $m;?>' value="1" class="view_res_elem <?php echo "res".$k;?>" ></th>
																	  
							                         <?php } ?> -->
							   <td class="first_row">

							   	<?php if (!empty($resultEntryInfo[$i][11]) && $resultEntryInfo[$i][7]==0 && $cat!=$resultEntryInfo[$i][11] ) {?>
							   		<font size="<?php echo $lang_font_size;?>"><?php echo "<b><u>".$resultEntryInfo[$i][11]."</u></b><br><br>";?></font>
							   	<?php
							   	$cat = $resultEntryInfo[$i][11];
							   	}?>
							    <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'<b><u>':'';?>
							  
							   <font size="<?php echo $lang_font_size;?>"><?php if ($cat!=$resultEntryInfo[$i][3]) {
							   	echo $resultEntryInfo[$i][3];
							   } ;?></font>
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'</u></b>':'';?>
							   </td>
							 <?php
							    if($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3){?>
								
								  	<td></td>
								  	<td></td>
								
								<?php }else{ ?>
							        <td class="second_row"><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][4];?></font></td>
									<td class="third_row"><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][6];?></font></td>
							        <td class="fourth_row"><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][5];?></font></td>
								<?php } ?>
							</tr>
							
						  <?php
						  
						  $m++;
                          }						  
						}
					
					?>
					
					
				 </tbody>
			</table>
			

		</section>
	</div>
	<div id="footer" class="col-xs-12 pull-right" style=" margin-bottom: -60px;">
		<div style="text-align: right; margin-right: 133px;" class="font-weight-bold">
					 Lab Technician
				</div>
	<!-- <p style="margin-left:-80px; margin-right:-50px;">
		<img src="../../dist/img/ech_footer_with_verified_by.jpg" width="1500px" height="80px"></img>
	</p> -->

	
</div>
	</form>	  
</body>
</html>

<?php 
// exit();


if (!empty($this->popArr['pdf_download_status'])) {

	 // echo $billno;exit();
	
	$myvar = ob_get_clean();
	ob_end_clean();
	$myvar = utf8_encode($myvar);
	$mpdf = new mPDF('utf-8','A4');
	$mpdf->WriteHTML($myvar);
	 // $mpdf->Output("./Lab-Report.pdf", "F"); //for save file
	 $mpdf->Output('Lab-Report-'.$billno.'.pdf', 'D');//for download file
	// $filename = './Lab-Report.pdf';
	 $mpdf->close();




    // header("Location: ../../lib/controllers/centralController.php?module=Lab&sub_module=search_lab_bill");

	 // header('Refresh: 0; url=http://stackoverflow.com/');

	
} 
	
?>


<?php 


if (!empty($this->popArr['email'])) {
	$myvar = ob_get_clean();
	ob_end_clean();
	$myvar = utf8_encode($myvar);
	$mpdf = new mPDF('utf-8','A4');
	$mpdf->WriteHTML($myvar);
	$mpdf->Output("./Lab-Report.pdf", "F"); 
	$filename = 'Lab-Report.pdf';
		

	      require(getcwd().'/PHPMailer/src/PHPMailer.php');
	      require(getcwd().'/PHPMailer/src/SMTP.php');
	      require(getcwd().'/PHPMailer/src/OAuth.php');
	      require(getcwd().'/PHPMailer/src/POP3.php');
	      require(getcwd().'/PHPMailer/src/Exception.php');

	      $mail = new PHPMailer\PHPMailer\PHPMailer();

	      // $from_email = "ibnuseena.kerala@gmail.com";
	       // $from_email = "emergencycarepkl@gmail.com";
	      // $to = $this->popArr['email'];
	      $from_email = "anjali.pb@uniziontechnologies.com";
	       $to = "anjali.pb@uniziontechnologies.com";
	        $mail->IsSMTP(); // enable SMTP

	        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	        $mail->SMTPAuth = true; // authentication enabled
	        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	        $mail->Host = "smtp.zoho.com";
	        $mail->Port = 587; // or 465
	        $mail->IsHTML(true);
	        // $mail->Username = "ibnuseena.kerala@gmail.com";
	        // $mail->Password = "sjftpiojybzfwtii";
	        $mail->Username = "anjali.pb@uniziontechnologies.com";
	        $mail->Password = "Anjali7356638319";
	        $mail->SetFrom($from_email);
	        $mail->Subject = 'Emergency Care - Pulikkal, Lab Result';
	        $mail->Body = 'Hi '.$billInfo[0][3].',<br><br>Please find  attached lab result.';
	        $mail->AddAddress($to);
	        $mail->AddAttachment($filename, $filename);
	        // $mail->addCustomHeader('X-custom-header', $headers);
	        $mail_status = $mail->Send();

	         unlink($filename);

	         if($mail_status==1) {
	         	$result = 'Success';
				
	         }else{
	         	$result = 'Failed';
				
	         }
	


    echo '<form id="sendMail" method="post"><input type="hidden" name="billno" id="billno" value="'.$billno.'">
    <input type="hidden" name="email_status" id="email_status" value="'.$result.'"></form>';
}
if (!empty($this->popArr['email'])) {
?>
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<script>
	var status = $('#email_status').val();
	if(status=='Success')
		alert("Email Send Successfuly");
	else
		alert("Email Sending Failed");
	$("#sendMail").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=updateMailStatus");
    $("#sendMail").submit();
    
</script>
<?php }?>