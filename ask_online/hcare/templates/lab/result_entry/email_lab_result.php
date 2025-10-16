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
@page {
  /*margin-top: 40cm;*/
  /*margin-bottom: 4cm;*/
}



 #bill{
	page-break-inside: auto !important;
}
#bill tr.rowstyle td { 
	padding-bottom: 5px;
}



#footer {
display: block;
width:100%;        
position:fixed;
left:0;
bottom:0;


/* 	font-size: 16px;
font-weight: 700;*/
}
.footer_details {
font-size: 12px !important;
}

td.first_row {
    width: 37% !important;
    
     /*width: 35% !important;*/
    font-weight: 700;
}
td.second_row {
    width: 27% !important;
    /*width: 20% !important;*/
}
/*td.third_row {
    width: 20% !important;
}*/
td.fourth_row {
    width: 33% !important;
    /*width: 30% !important;*/
}

/*td.first_row {
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
}*/
td.margin_bottom {
    padding-bottom: 10px !important;
}


table#patient_details td {
    padding-bottom: 5px;
}


</style>

</head>
<body id="frame">
	<form name="result_entry" id="form"  method="post"> 
	<div id="content">
		<?php
		// require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';
		// $hobj=new HospitalInfo();
		// $hinfo=$hobj->getHospitalInfo();
		$resultInfo=$this  ->popArr['resultInfo'];
		$resultEntryInfo=$this  ->popArr['resultEntryInfo'];
		$billInfo=$this  ->popArr['billInfo'];
		$post=$this  ->popArr['post'];
		$billno=$this  ->popArr['billno'];
		$smtpInfo=$this  ->popArr['smtpInfo'];
		$hinfo=$this  ->popArr['hInfo'];
		$empInfo=$this  ->popArr['EmployeeInfo'];

		$clinic_name=$hinfo[1];
		$city=$hinfo[3];
		$state=$hinfo[4];
		$pincode=$hinfo[6];
		$phone=$hinfo[7];
		$email=$hinfo[9];
			

		// $empInfo=$this  ->popArr['EmployeeInfo'];
		// $automated_email_status=$this  ->popArr['automated_email_status'];
		 // var_dump($empInfo);exit();
			
		?>

		<section class="contents">
			<table width ="100%" >
	 	 <tr>
			<td id="noborder" align="center" style="padding-bottom: 15px !important;"><img src="../../dist/img/logo.png" width="80px" height="60px"></img><br><br><br></td>
		</tr>
	 
	 	 <tr>
			<td id="noborder" class="clinic" align="center" style="padding-top: 5px !important;font-size: 16px;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr> 
		<tr>
			<td id="noborder"  align="center" style="font-size: 13px ;"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center" style="font-size: 13px ;"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>
		
		</table>
		<!-- <p style="margin-top:-80px; margin-left:-80px;">
			<img src="../../dist/img/logo.png" width="100%" height="150px"></img>
		</p> -->
		<br>
			
		<div style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0 #91c6e3 !important;">
		<!-- 	<div style="background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0px #91c6e3 !important;"> -->
		PATIENT DETAILS</div><br>

			<table width="100%" id="patient_details">
				
				<tr>
				    <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient;?> : <?php echo $billInfo[0][3];?></font></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?> : <?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id;?> : <?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no;?> : <?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_bill_no;?> : <?php echo $billInfo[0][0];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor;?> : <?php echo $billInfo[0][8];?>
				  <br><?php echo $billInfo[0][49];?>
				  	
				  </font></td>
				 </tr>
				 <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_recieved_date;?> : <?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_result_date;?> : <?php echo ($resultInfo[0][2]!='')?date("d-m-Y",strtotime($resultInfo[0][2])):date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_print_date;?> : <?php echo date("d-m-Y");?></font></td>
				  </tr>
				    
			</table>
			<br>
			<div style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0 #91c6e3 !important;">TEST RESULT REPORT</div>
		<!-- <div style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 10px;font-weight: 700;margin-left: -20px;box-shadow: inset 0 0 0 0 #91c6e3 !important;">TEST RESULT REPORT</div> -->
		<br>

			
			 <table width="100%" id="bill" >
					<thead>
					<tr bgcolor='' height='5' class='spl'><td colspan='4'>&nbsp;</td></tr>
					    <tr>
							<!-- <th  class='DONTPrint'><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_select; ?></font></th> -->
							<th ><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_name; ?></font></u></th>
							<th colspan="2"><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_value; ?></font></u></th>
							<!-- <th><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_unit; ?></font></u></th> -->
							<th ><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_normal_range; ?></font></u></th>
							
						</tr>
						<tr bgcolor='' height='5' class='spl'><td colspan='4'>&nbsp;</td></tr>
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
							 <!--  <th class='DONTPrint' style="padding-bottom: 10px;" >  -->
							  
							  <!-- <?php if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3 ){
								 
								  ?> -->
							                                          <!--  <input type='checkbox' name='view' id='<?php echo $k;?>' class='view_res' ></th> -->
																	  
							                         <!-- <?php } ?> -->
													 
													 <!-- <?php if($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20 || $resultEntryInfo[$i][7] ==2){
								 
								  ?> -->
							                                           <!-- <input type='checkbox' name='view' id='elem<?php echo $m;?>' value="1" class="view_res_elem <?php echo "res".$k;?>" ></th> -->
																	  
							                         <!-- <?php } ?> -->
							   <td class="first_row">

							   	<?php if (!empty($resultEntryInfo[$i][11]) && $resultEntryInfo[$i][7]==0 && $cat!=$resultEntryInfo[$i][11] ) {?>
							   		<font size="<?php echo $lang_font_size;?>"><?php echo "<span style='font-weight:bold'><u>".$resultEntryInfo[$i][11]."</u></span><br><br>";?></font>
							   	<?php
							   	$br[$i] = "YES";
							   	$cat = $resultEntryInfo[$i][11];
							   	}?>
							    <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'<span style="font-weight:bold"><u>':'';?>
							  
							   <font size="<?php echo $lang_font_size;?>"><?php if ($cat!=$resultEntryInfo[$i][3]) {

							   	echo (($resultEntryInfo[$i][7] !=1 || $resultEntryInfo[$i][7] !=2 || $resultEntryInfo[$i][7] !=3) && ($resultEntryInfo[$i][18] =='H' || $resultEntryInfo[$i][18] =='L'))?'<span style="font-weight:bold">':'';

							   	echo $resultEntryInfo[$i][3];

							   	 echo (($resultEntryInfo[$i][7] !=1 || $resultEntryInfo[$i][7] !=2 || $resultEntryInfo[$i][7] !=3) && ($resultEntryInfo[$i][18] =='H' || $resultEntryInfo[$i][18] =='L'))?'</span>':'';


							   } ;?></font>
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'</u></span>':'';?>
							   </td>
							 <?php
							    if($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3){?>
								
								  	<td></td>
								  	<td></td>
								
								<?php }else{ ?>
							        <td class="second_row" colspan="2"><font size="<?php echo $lang_font_size;?>"><?php
							        	if ($br[$i] == "YES") {
							        		echo "<br><br>";
							        	}
							        	if(($resultEntryInfo[$i][18]=='H') || ($resultEntryInfo[$i][18]=='L')){

							        		echo "<span style='font-weight:bold'>";
							        	}
							         echo $resultEntryInfo[$i][4];

							         if(($resultEntryInfo[$i][18]=='H') || ($resultEntryInfo[$i][18]=='L')){

							        		echo "</span>";
							        	}
							        if(!empty($resultEntryInfo[$i][4])){
							        	echo "&nbsp;&nbsp;".$resultEntryInfo[$i][6];

							        };?></font></td>
									<!-- <td class="third_row"><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][6];?></font></td> -->
							        <td class="fourth_row"><font size="<?php echo $lang_font_size;?>"><?php if ($br[$i] == "YES") {
							        		echo "<br><br>";
							        	} echo $resultEntryInfo[$i][5];?></font></td>
								<?php } ?>
							</tr>

							 <?php if(!empty($resultEntryInfo[$i][19])){
								 	$description=$resultEntryInfo[$i][19];
								 	$description=str_replace("<!DOCTYPE html>",'',$description);
									$description=str_replace("<html>",'',$description);
									$description=str_replace("<head>",'',$description);
									$description=str_replace("<body>",'',$description);
									$description=str_replace("</body>",'',$description);
									$description=str_replace("</html>",'',$description);
								 	?>
							        <tr>
							        	<td colspan="4">
							        	<font size="<?php echo $lang_font_size;?>"><p>
							        		<?php echo "<b>Note :</b>".$description;?>
							        	</p></font>
							        </td>
							        </tr>
								<?php}else{?>
							
								<?php }?>
							
						  <?php
						  
						  $m++;

						  if(!empty($empInfo)){
						
						  for($j=0;$j<count($empInfo);$j++){ 
						  
										  $filepath_entered_by="../../lib/lab_signatures"."/".$resultEntryInfo[$i][12]."/".$resultEntryInfo[$i][14];
										  $filepath_approved_by="../../lib/lab_signatures"."/".$resultEntryInfo[$i][13]."/".$resultEntryInfo[$i][15];
										  $filepath_verified_by="../../lib/lab_signatures"."/".$empInfo[0][0]."/".$empInfo[0][27];

										  $entered_by_name=$resultEntryInfo[$i][16];
										  $approved_by_name=$resultEntryInfo[$i][17];
										  $verified_by_name=$empInfo[0][29]."".$empInfo[0][30];

										  $entered_by_name=$resultEntryInfo[$i][16];
										  $approved_by_name=$resultEntryInfo[$i][17];
										  $verified_by_name=$empInfo[0][29]."".$empInfo[0][30];


										  // echo $filepath_entered_by.""." ".$filepath_approved_by;exit;

										  $entered_img=$resultEntryInfo[$i][14];
										  $approved_img=$resultEntryInfo[$i][15];
										  $verified_img=$empInfo[0][27];

										  $result_id=$resultEntryInfo[$i][10];
										  // $microbiology=$resultEntryInfo[$i][11];
                          }						  
						}





                          }						  
						}
					
					?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<!-- <td><b><br><br><br> Lab Technician<b></td> -->
							<td><br><br><br> </td>
					</tr>

					
					
				 </tbody>
				 <!-- <tfoot>
			


					<tr>
					<td></td>
					<td></td>
					<td></td>
				
					 <td id="spacer"><b><br><br><br></td>
					 
					 </tr>

						
					</tfoot> -->
				</table>
			

		</section>
	</div>


	</form>	  


  <div id="footer" class="col-xs-12 col-lg-12 footer" >
  					
					<div class="col-xs-3 col-lg-3 footer_details">
						<p align="center">
						<?php if(!empty($entered_img)){?>
						<img src="<?php echo $filepath_entered_by; ?>" style=" width:150px; height:30px ;">
						<?php }else{
						}?><br>
						
					<b><?php echo ucfirst(strtolower($entered_by_name));?></b><br>
						<b>Entered By</b> 
					</p>
						
					</div>
					<div class="col-xs-3 col-lg-3 footer_details">
						<p align="center">
						<?php if(!empty($approved_img)){?>
						<img src="<?php echo $filepath_approved_by; ?>" style=" width:150px; height:30px ;">
						<?php }else{
						}?><br>
						<b><?php echo ucfirst(strtolower($approved_by_name));?></b><br>
						<b>Approved By</b>
					</p>
						
						
					</div>
					<div class="col-xs-3 col-lg-3 footer_details">
						<p align="center">
						<?php if(!empty($verified_img)){?>
						<img src="<?php echo $filepath_verified_by; ?>" style=" width:150px ; height:30px ;">
						<?php }else{
						}?><br>
						<b><?php echo ucfirst(strtolower($verified_by_name));?></b><br>
						<b>Verified By</b>
					</p>

					</div>



				</div> 

				
	</body>	

</html>



<?php 



if (!empty($this->popArr['pdf_download_status'])) {

	 // echo $billno;exit();
	
	$myvar = ob_get_clean();
	ob_end_clean();
	$myvar = utf8_encode($myvar);
	// $mpdf = new mPDF('utf-8','A4');//old
	$mpdf=new \Mpdf\Mpdf();
	$mpdf->WriteHTML($myvar);
	 // $mpdf->Output("./Lab-Report.pdf", "F"); //for save file
	 $mpdf->Output('Lab-Report-'.$billno.'.pdf', 'D');//for download file
	// $filename = './Lab-Report.pdf';
	// $mpdf->Output('Lab-Report-'.$billno.'.pdf', 'I');
	 $mpdf->close();




    // header("Location: ../../lib/controllers/centralController.php?module=Lab&sub_module=search_lab_bill");

	 // header('Refresh: 0; url=http://stackoverflow.com/');

	
} 
	
?>


<?php 
$config_obj=new Config_hims();

if (!empty($this->popArr['email']) && $config_obj->email_status=="YES") {

	$myvar = ob_get_clean();
	ob_end_clean();


// var_dump(ROOT_PATH);exit;
 // include_once ROOT_PATH.'\plugins\mpdf\vendor\autoload.php';
	require_once ROOT_PATH.'/plugins/mpdf/vendor/autoload.php';
	require_once ROOT_PATH.'/plugins/mpdf/src/Mpdf.php';


	$myvar = utf8_encode($myvar);
	$mpdf = new \Mpdf\Mpdf();
	// $mpdf->showImageErrors = true;
	$mpdf->WriteHTML($myvar);

	$mpdf->Output("./Lab-Report.pdf", "F");
	
	$filename = 'Lab-Report.pdf'; 
	
		

	      require(getcwd().'/PHPMailer/src/PHPMailer.php');
	      require(getcwd().'/PHPMailer/src/SMTP.php');
	      require(getcwd().'/PHPMailer/src/OAuth.php');
	      require(getcwd().'/PHPMailer/src/POP3.php');
	      require(getcwd().'/PHPMailer/src/Exception.php');

	        $from_email = $smtpInfo[0][4];
            $to = $this->popArr['email'];
            $SMTPSecure = $smtpInfo[0][1]; // 'ssl' secure transfer enabled for gamil tls for zoho 
            $Host = $smtpInfo[0][2];//smtp.gmail.com for gmail //smtp.zoho.com for zoho
            $Port = $smtpInfo[0][3]; // or 465 for gmail 587 for zoho
            $Username = $smtpInfo[0][4];
            $Password = $smtpInfo[0][5];

	      $mail = new PHPMailer\PHPMailer\PHPMailer();

	      
	        $mail->IsSMTP(); // enable SMTP

	         // TO BYPASS SSL CERTIFACE VERIFICATION
			// $mail->SMTPOptions = array(
			//     'ssl' => array(
			//         'verify_peer' => false,
			//         'verify_peer_name' => false,
			//         'allow_self_signed' => true
			//     )
			// );
			// TO BYPASS SSL CERTIFACE VERIFICATION

	        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	        $mail->SMTPAuth = true; // authentication enabled
	        $mail->SMTPSecure = $SMTPSecure; // secure transfer enabled REQUIRED for Gmail
	        $mail->Host = $Host;
	        $mail->Port = $Port; // or 587
	        $mail->IsHTML(true);
	        $mail->Username = $Username;
	        $mail->Password = $Password;
	        $mail->SetFrom($from_email);
	        $mail->Subject =  $clinic_name.'-Lab Result';
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