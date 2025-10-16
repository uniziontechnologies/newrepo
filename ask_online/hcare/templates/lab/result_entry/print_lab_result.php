
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
	
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  
 <!-- date-range-picker -->

 <script language="javascript">
   $(document).ready(function () {
    //Disable cut copy paste
  /*  $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });*/
	
	$('.view_res').attr('checked', true);
		   
	       $( ".view_res" ).click(function() {
		   
		    row_id=$(this).attr('id');
		     if($(this).is(':checked') == true) {
				
					 $('.view_res_elem.res'+row_id).prop('checked', true);
                     $("tr.resRow"+row_id+" td").removeClass();
                      $("tr.resRowDescription"+row_id+" td").removeClass();
				
             } else {
				  $('.view_res_elem.res'+row_id).attr('checked', false );
                  $("tr.resRow"+row_id+" td").addClass('DONTPrint');
                  $("tr.resRowDescription"+row_id+" td").addClass('DONTPrint');
            }
		 });
		 
		 $('.view_res_elem').attr('checked', true);
		   
	       $( ".view_res_elem" ).click(function() {
		   
		  
		   row_id=$(this).attr('id');
			
			id_arr = row_id.split("elem");
			 row_id=id_arr[1];
			
			
		     if($(this).is(':checked') == true) {
				 
                // $( ".resRow"+row_id ).removeClass();
				 $("tr#res_elem"+row_id+" td").removeClass();
             } else {
				
                  $("tr#res_elem"+row_id+" td").addClass('DONTPrint');
            }
		 });
	
	
});
	function submitform() {
	       document.result_entry.action="../../lib/controllers/centralController.php?module=Lab&sub_module=search_lab_bill";
	       document.result_entry.submit();
	}
	function download_pdf(id){
		// alert(id); return false;
		// var id=document.result_entry.billno.value;
		document.result_entry.action="../../lib/controllers/centralController.php?module=Lab&sub_module=download_pdf&billno="+id;
	       document.result_entry.submit();
		// $("#result_entry").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=download_pdf&billno="+id);
  //         		$("#result_entry").submit();
		//     	return true;
	}

    </script>
	<script>
  $(function () {
	       
 });
</script>
<style>
	#bill tr.spl td 
{

        /*border-top:solid 1px;*/
      }

 #bill tr.rowstyle td 	
          {
          	 padding-bottom: 5px;
          }
 @media print{
          	/*@page{margin-bottom: 3cm;}*/
          	html, body{
          		height: 100% !important;
          	}

          	.print-colored {
    background-color: #91c6e3 !important;
    color: white !important;
    -webkit-print-color-adjust: exact !important; /* Chrome / Edge */
    print-color-adjust: exact !important;        /* Firefox */
  }
          }

 #spacer 
    {
    	height: 2em;
    }
    div#content 
    {
    	position: relative;
    }

  #footer {
        display: block;
        width:100%;        
        position:fixed;
        left:0;
        bottom:-12px;

   /* 	font-size: 16px;
    	font-weight: 700;*/
  	}

td.first_row {
    width: 37% !important;
     /*width: 35% !important;*/
    /*font-weight: 700;*/
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
td.margin_bottom {
    padding-bottom: 10px !important;
}












	/*@page{margin-top: 4cm;}*/

@page {
  /*margin-top: 4cm;*/
  /*margin-bottom: 4cm;*/
}

@page :first {
  /*margin-top: 4cm; */
  /*margin-bottom: 3cm;*/

}
table#patient_details td {
    padding-bottom: 5px;
}

</style>
</head>
<body id="frame">
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
$empInfo=$this  ->popArr['EmployeeInfo'];

// var_dump($resultEntryInfo);
	
?>
<form name="result_entry" id="form"  method="post" action=""> 
<div id="content">
	<table width ="100%" >
	 	 <tr>
			<td id="noborder" align="center" style="padding-bottom: 15px !important;"><img src="../../dist/img/logo.png" width="80px" height="60px"></img><br></td>
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


		<section class="content">
		
		       <!--  <p align="center"><img src="../../dist/img/logo.png" ></img></p> -->

		       	
		<!-- <p style="margin-top:-80px; margin-left:-80px;">
			<img src="../../dist/img/logo.png" width="100%" height="150px"></img>
		</p> -->
		<!-- <br> -->
		  <div class="print-colored" style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 14px;font-weight: 700;box-shadow: inset 0 0 0 0px #91c6e3 !important;margin-left: -20px;">PATIENT DETAILS</div>
		
				
	

			   <!-- <div style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 14px;font-weight: 700;box-shadow: inset 0 0 0 1000px #91c6e3 !important;margin-left: -20px;">PATIENT DETAILS</div> -->

				<!-- <h5 align="center" style="border-top: 1px solid;padding-top: 10px;border-bottom: 1px solid;padding-bottom: 5px;margin-top: 15px;margin-bottom: 15px;"><b><?php echo $lang_lab_report_heading;?></b></h5> -->
			
			   
			   <table width="100%" id="patient_details">
			   
			   
			     <tr>
				    <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient;?> : <?php echo $billInfo[0][3];?></font></td>
					<td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?> : <?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id;?> : <?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no;?> : <?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_bill_no;?> : <?php echo $billInfo[0][0];?></font></td>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor;?> : <?php echo $billInfo[0][8];?>
				  	<br><?php echo $billInfo[0][49];?>
				  </font></td>
				 </tr>
				 	<tr>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_recieved_date;?> : <?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_result_date;?> : <?php echo ($resultInfo[0][2]!='')?date("d-m-Y",strtotime($resultInfo[0][2])):date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td ><font size="<?php echo $lang_font_size;?>"><?php echo $lang_print_date;?> : <?php echo date("d-m-Y");?></font></td>
				  </tr>
				  
				  
			   </table>


			   <div class="print-colored" style="margin-bottom: 10px;background-color:#91c6e3;text-align: center;color: white;font-size: 14px;font-weight: 700;box-shadow: inset 0 0 0 1000px #91c6e3 !important;margin-left: -20px;">TEST RESULT REPORT</div>

			   <br>
			    <table width="100%" id="bill" style="margin-top: -30px !important;">
					<thead>
					<tr bgcolor='' height='5' class='spl'><td colspan='5'>&nbsp;</td></tr>
					    <tr>
							<th  class='DONTPrint'><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_select; ?></font></th>
							<th ><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_name; ?></font></u></th>
							<th colspan="2"><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_value; ?></font></u></th>
						   <!-- <th><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_unit; ?></font></u>aa</th>  -->
							<th ><u><font size="<?php echo $lang_font_size;?>"><?php echo $lang_normal_range; ?></font></u></th>
							
						</tr>
						<tr bgcolor='' height='5' class='spl'><td colspan='5'>&nbsp;</td></tr>
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
							  <th class='DONTPrint' style="padding-bottom: 10px;" > 
							  
							  <?php if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3 ){
								 
								  ?>
							                                           <input type='checkbox' name='view' id='<?php echo $k;?>' class='view_res' ></th>
																	  
							                         <?php } ?>
													 
													 <?php if($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20 || $resultEntryInfo[$i][7] ==2){
								 
								  ?>
							                                           <input type='checkbox' name='view' id='elem<?php echo $m;?>' value="1" class="view_res_elem <?php echo "res".$k;?>" ></th>
																	  
							                         <?php } ?>
							   <td class="first_row">

							   	<?php if (!empty($resultEntryInfo[$i][11]) && $resultEntryInfo[$i][7]==0 && $cat!=$resultEntryInfo[$i][11] ) {?>
							   		<font size="<?php echo $lang_font_size;?>"><?php echo "<b><u>".$resultEntryInfo[$i][11]."</u></b><br><br>";?></font>
							   	<?php
							   	$br[$i] = "YES";
							   	$cat = $resultEntryInfo[$i][11];
							   	}?>
							    <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'<b><u>':'';?>
							  
							   <font size="<?php echo $lang_font_size;?>"><?php if ($cat!=$resultEntryInfo[$i][3]) {

							   	  echo (($resultEntryInfo[$i][7] !=1 || $resultEntryInfo[$i][7] !=2 || $resultEntryInfo[$i][7] !=3) && ($resultEntryInfo[$i][18] =='H' || $resultEntryInfo[$i][18] =='L'))?'<b>':'';

							   	echo $resultEntryInfo[$i][3];

							   	 echo (($resultEntryInfo[$i][7] !=1 || $resultEntryInfo[$i][7] !=2 || $resultEntryInfo[$i][7] !=3) && ($resultEntryInfo[$i][18] =='H' || $resultEntryInfo[$i][18] =='L'))?'</b>':'';
							   } ?></font>
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'</u></b>':'';?>
							   </td>
							 <?php
							    if($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3){?>
								
								  	<td></td>
								  	<td></td>
								
								<?php }else{ ?>
							        <td class="second_row" colspan="2"><font size="<?php echo $lang_font_size;?>">
							        	<?php if ($br[$i] == "YES") {
							        		echo "<br><br>";
							        	}
							        	if(($resultEntryInfo[$i][18]=='H') || ($resultEntryInfo[$i][18]=='L')){

							        		echo "<b>";
							        	}
							        	 echo $resultEntryInfo[$i][4];
							        	 if(($resultEntryInfo[$i][18]=='H') || ($resultEntryInfo[$i][18]=='L')){

							        		echo "</b>";
							        	}

							        if(!empty($resultEntryInfo[$i][4])){

							        	echo "&nbsp;&nbsp;".$resultEntryInfo[$i][6];

							        }
							        
							    ?></font></td>
									<!-- <td class="third_row"><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][6];?></font>3</td> -->
							        <td class="fourth_row"><font size="<?php echo $lang_font_size;?>"><?php if ($br[$i] == "YES") {
							        		echo "<br><br>";
							        	} echo $resultEntryInfo[$i][5];?></font></td>
								<?php } ?>
							</tr>

							<?php if(!empty($resultEntryInfo[$i][19])){
								$description=$resultEntryInfo[$i][19];


								?>
							        <tr class='resRowDescription<?php echo $k;?> rowstyle'>
							        	<td colspan="5">
							        	<font size="<?php echo $lang_font_size;?>"><p>
							        		<?php echo $resultEntryInfo[$i][19];?>
							        	</p></font>
							        </td>
							        </tr>
								<?php}else{?>
							
								<?php }?> 
							
						  <?php
						  
						  $m++;

						  if(!empty($empInfo)){
						  	// var_dump($empInfo);
						
						  for($j=0;$j<count($empInfo);$j++){ 
						  
										  $filepath_entered_by="../../lib/lab_signatures"."/".$resultEntryInfo[$i][12]."/".$resultEntryInfo[$i][14];
										  $filepath_approved_by="../../lib/lab_signatures"."/".$resultEntryInfo[$i][13]."/".$resultEntryInfo[$i][15];
										  $filepath_verified_by="../../lib/lab_signatures"."/".$empInfo[0][0]."/".$empInfo[0][27];

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
					
					
				 </tbody>
				 <tfoot>


					<tr>
					<td></td>
					<td></td>
					<td></td>
					<!-- <td></td> -->
					 <td id="spacer"><b><br><br><br></td>
					 
					 </tr>

						
					</tfoot>
				</table>
		     

				<!-- <div id="footer" class="col-xs-12" style="margin-top: -10px !important;">
  					<p style="font-size: 9px;">Though we strive to give correct results occasionally ambiguities are there, since these tests are chemical based. In such cases, Doctors/Patients can approach the lab for remedial actions.</p>
				</div> -->

            </section>
	
	 </div>


	 <div id="footer" class="col-xs-12" >
  					
					<div class="col-xs-4 col-lg-4 footer_details">
						<p align="center">
						<?php if(!empty($entered_img)){?>
						<img src="<?php echo $filepath_entered_by; ?>" style=" width:150px; height:30px ;">
						<?php }else{
						}?><br>
						
					<b><?php echo ucfirst(strtolower($entered_by_name));?></b><br>
						<b>Entered By</b> 
					</p>
						
					</div>
					<div class="col-xs-4 col-lg-4 footer_details">
						<p align="center">
						<?php if(!empty($approved_img)){?>
						<img src="<?php echo $filepath_approved_by; ?>" style=" width:150px; height:30px ;">
						<?php }else{
						}?><br>
						<b><?php echo ucfirst(strtolower($approved_by_name));?></b><br>
						<b>Approved By</b>
					</p>
						
						
					</div>
					<div class="col-xs-4 col-lg-4 footer_details">
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

	 <div align="center" class="DONTPrint col-xs-12"><a href="#" class="print btn btn-warning btn-flat" onClick="Print()">PRINT</a>&nbsp;<input type="button" name="download_result" value="Download" id="download_result" class="btn btn-success" onclick="download_pdf('<?php echo $billInfo[0][0];?>')">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"></div>


<input type="hidden" name="billno" value="<?php echo(!empty($post['billno']))?$post['billno']:''; ?>">
<input type="hidden" name="type" value="<?php echo(!empty($post['type']))?$post['type']:''; ?>">
<input type="hidden" name="patient_id" value="<?php echo(!empty($post['patient_id']))?$post['patient_id']:''; ?>">
<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="patient_name" value="<?php echo(!empty($post['patient_name']))?$post['patient_name']:''; ?>">
<input type="hidden" name="id" value="<?php echo(!empty($post['id']))?$post['id']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">
<input type="hidden" name="cancellation_details" value="<?php echo(!empty($post['cancellation_details']))?$post['cancellation_details']:''; ?>">

</form>	  
</body>
	</html>
