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
   <script language="javascript">
   $(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
   /* $("body").on("contextmenu",function(e){
        return false;
    });*/

});

	// function submitform() {
	//        document.opsheet.action="../../lib/controllers/centralController.php?module=Billing&sub_module=IP_Search";
	//        document.opsheet.submit();
	// }

    </script>
    <style>
	
	body{
	 text-transform :capitalize;
	}
	.sub-table td,.sub-table th{
		font-size: 12px;
	}
	.credits{
		padding-left: 60px; 
	}
	.credits p{
		font-size: 14px;
		font-weight: bold;
	}
	@media print{
		@page{
			    /*size: auto;margin:0mm 60mm 0mm 0mm;*/
			    /*margin-top: 3cm;*/
			  }
		html,body{
			height: 100% !important;
		}



	}
	table#datatable th, table#datatable td {
    padding-left: 10px;
     padding-top: 5px;
     padding-bottom: 5px; 
}

    
	*{
	font-weight: 700 !important;
    }
	table#datatable font {
    font-size: 15px !important;
}
@page {
  margin-top: 4cm;
  /*margin-bottom: 4cm;*/
}
	
	</style>
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

$billInfo =$this->popArr['billInfo'];
$billitems=$this->popArr['billitems'];
$patientInfo=$this->popArr['patient_info'];
//wheather to print detailed bill
$print_status = $this->popArr['print_status'];
if($print_status){
	$s_billInfo =$this->popArr['s_billInfo'];
	$theatre_procedure = $this->popArr['theatre_procedure'];
	$doc_visits = $this->popArr['doc_visits'];
	$pharmaInfo = $this->popArr['pharmaInfo'];
	
}
$nurse_procedures = $this->popArr['nurse_added_procedures_details'];
// var_dump($patientInfo);
?>

<div id="wrapper">
   <div id="content" >
   
	 
	<!--  <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"></img></td>
		</tr> 
	 
	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>

		<?php

			if (!empty($post['is_dupclicate'])) {?>
			
				<tr>
					<td id="noborder" class="duplicate" align="center" style="font-size: 12px;padding-top: 3px;"><label>(duplicate)</label></td>	
				</tr>
				

			<?php
			}


		?>
		
		</table>
		<hr width="100%"> -->
		<table width ="90%"  align="center" style="margin-top: 10px;">
	
				<tr>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" align="right">
		 					<font size="<?php echo $lang_font_size;?>">	<?php echo $lang_ip_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][1]; ?></font>
						</td>
					
						
		
					</tr>
					<tr>
						
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][15];?></font>
						</td>
						<td id="noborder" align="right">
			 				<font size="<?php echo $lang_font_size;?>"> ROOM NO&nbsp;:&nbsp;<?php echo $patientInfo[0][37];?></font>
						</td>
						
		
				</tr>
				<tr>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]?></font>
						</td>
						<!-- <td id="noborder" align="right">
					<?php if($billInfo[0][19] ==2){?>
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_date.":&nbsp;".$billInfo[0][20];?></font>
					<?php }else{ ?>
					<font size="<?php echo $lang_font_size;?>"><?php echo $lang_date.":&nbsp;".$billInfo[0][2];?></font>
					<?php } ?>
						</td> -->
						<td id="noborder" align="right">
			 				<font size="<?php echo $lang_font_size;?>">DATE OF ADMISSION&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]))." ".date("h:i A",strtotime($patientInfo[0][19]));?></font>
						</td>
				</tr>
				
				<tr>
					<td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][8];?></font>
						</td>
						<td id="noborder" align="right">

							<font size="<?php echo $lang_font_size;?>">DATE OF DISCHARGE&nbsp;:&nbsp;
						<?php //var_dump($patientInfo[0][22]);

							if (!empty($patientInfo[0][22]) && $patientInfo[0][22] != "1970-01-01" && $patientInfo[0][22] != "0000-00-00") {?>
								<?php echo date("d-m-Y",strtotime($patientInfo[0][22]))." ".date("h:i A",strtotime($patientInfo[0][21]));?>
							<?php
							}
							else{
								echo " - <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
							}

						?>

						</font>

			 				
						</td>
						
				</tr>
				
				<tr>
		
						
						<td id="noborder" colspan="2">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][17]." ".$patientInfo[0][18];?>
			 					<br> <?php echo $patientInfo[0][68];?>
			 				</font>
						</td>		
	
						
				</tr>
				
				
			</table>
			<br>
		
					
   					<table align="center" width="90%" id="datatable" border="1">
						<tr>
							<td><font size="<?php echo $lang_font_size;?>">SL</font></td>
							<td><font size="<?php echo $lang_font_size;?>">PARTICULARS</font></td>
							<td><font size="<?php echo $lang_font_size;?>">AMOUNT</font></td>							
							
						</tr>
						<?php
							$total=0;
							if(!empty($billitems)){
								  // var_dump($billitems);
								$j=1;
								for($i=0;$i<count($billitems);$i++) {?>
									<tr>
										<td style=" vertical-align:top"><font size="<?php echo $lang_font_size;?>"><?php echo $j++;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billitems[$i][2];?>
										
										<?php 

											if ($billitems[$i][2]=="ROOM RENT" && !empty($patientInfo[0][69])) {
												echo "(".$patientInfo[0][69].")";
											}

										?>
											
										</font>

										<br>

										<?php if($billitems[$i][2]=='PROCEDURE CHARGES' || $billitems[$i][2]==$lang_nursing_procedures){


												$tot = 0;
												if($nurse_procedures)
													{
												?>
												<br>
												<!-- <p> Nursing Procedure Charges</p> -->
											<table class="sub-table table-bordered" width="100%">
												<tr>
													<th>SL NO</th>
													<th>PROCEDURE</th>
													<th>DATE</th>
													<th>AMOUNT</th>
													<th>QTY</th>
													<th>TOTAL AMOUNT</th>
												</tr>
												<?php
												$tot = 0;
													$proc = $nurse_procedures[0][2];
													$proc_amount = $nurse_procedures[0][3];
													$proc_date = $nurse_procedures[0][4];
													$no_time =0;
													$sl=1;
													for($s=0;$s<=sizeof($nurse_procedures);$s++){
														if($proc == $nurse_procedures[$s][2]){
																$no_time +=1;
															}
															else{
												?>
												<tr>
													<td><?php echo $sl;?></td>
													<td><?php echo $proc;?></td>
													<td><?php echo $proc_date;?></td>
													<td><?php echo $proc_amount;?></td>
													<td><?php echo $no_time;?></td>
													<td><?php echo $proc_amount*$no_time;?></td>
												</tr>
												<?php
												$tot = $tot+($proc_amount*$no_time);
													$proc = $nurse_procedures[$s][2];
													$proc_amount = $nurse_procedures[$s][3];
													$proc_date = $nurse_procedures[$s][4];
													$no_time =0;
													$sl++;
													--$s;
													}
												}
													?>
												<tr>
													
													<th colspan="5" class="text-right">Total</th>
													<th><?php echo $tot;?></th>
												</tr>
													
											</table>
											<?php
												}
							
							} ?>

							<?php if($billitems[$i][2]=='SPECIALIST CONSULTATION CHARGES' ){
								if($doc_visits)
								{
							?>	
								
								
								

							<?php
							$tot = 0;
							
							?>
							<br>
							<table class="sub-table table-bordered" width="100%">
								<tr>
									<th>SL NO</th>
									<th>BILL DATE</th>
									<th>DOCTOR</th>
									<th>NUMBER OF VISITS</th>
									<th>TOTAL AMOUNT</th>
								</tr>
								<?php
								$tot = 0;
									$doc = $doc_visits[0][2];
									$vis_amount = 0;
									$no_visit =0;
									$sl = 1;
									for($s=0;$s<=sizeof($doc_visits);$s++){
										if($doc==$doc_visits[$s][2]){
											$no_visit +=1;
											$vis_amount += $doc_visits[$s][3];
											$vis_date=$doc_visits[$s][4];
										}
										else{
								?>
								<tr>
									<td><?php echo $sl;?></td>
									<td><?php echo $vis_date;?></td>
									<td><?php echo $doc;?></td>
									<td><?php echo $no_visit;?></td>
									<td><?php echo $vis_amount;?></td>
								</tr>
								<?php
								$tot = $tot+($vis_amount);
									if($s==sizeof($doc_visits))break;
									$doc = $doc_visits[$s][2];
									$vis_amount = 0;
									$no_visit =0;
									$sl++;
									--$s;
									}
								}
									?>
								<tr>
								
									<th colspan="4" class="text-right">Total</th>
									<th><?php echo $tot;?></th>
								</tr>
									
							</table>
							<?php
								}
								?>

									

								<?php }?>

								<?php if($billitems[$i][2]=='LABORATORY CHARGES' ){
								if($s_billInfo['lab'])
								{
							?>	
								
								
								

						<?php
							$tot = 0;
						
								?>
								<br>
								<table class="sub-table table-bordered" width="100%" >
									<tr>	
										<th>SL NO</th>
										<th>BILL NO</th>
										<th>BILL DATE</th>
										<th>NET AMOUNT</th>
										<th>AMOUNT PAID</th>
										<th>BALANCE AMOUNT</th>
									</tr>
									<?php
									// var_dump($s_billInfo['lab']);
									for($s=0;$s<sizeof($s_billInfo['lab']);$s++){
									?>
									<?php  if($s_billInfo['lab'][$s][4]-$s_billInfo['lab'][$s][5]!=0){?>
									<tr>
										<td><?php echo $s+1;?></td>
										<td><?php echo $s_billInfo['lab'][$s][0];?></td>
										<td><?php echo date("d-m-Y",strtotime($s_billInfo['lab'][$s][1]));?></td>
										<td><?php echo $s_billInfo['lab'][$s][2];?></td>
										<td><?php echo $s_billInfo['lab'][$s][3]+$s_billInfo['lab'][$s][5];?></td>
										<td><?php echo $s_billInfo['lab'][$s][4]-$s_billInfo['lab'][$s][5];?></td>
									</tr>
									<?php
									$tot+=$s_billInfo['lab'][$s][4]-$s_billInfo['lab'][$s][5];
									}
								}
									?>
									<tr>
										<th align="right" colspan="5" class="text-right">Total</th>
										<th><?php echo $tot;?></th>
									</tr>
								</table><br/>
							<?php
								}
								?>

									

								<?php }?>
								<?php if($billitems[$i][2]=='X-RAY CHARGES' ){
							if($s_billInfo['xray'])
							{
							?>
									
								

							<?php
							$tot = 0;
							
							?>
							<br>
							<table class="sub-table table-bordered" width="100%">
								<tr>	
									<th>SL NO</th>
									<th>BILL NO</th>
									<th>BILL DATE</th>
									<th>NET AMOUNT</th>
									<th>AMOUNT PAID</th>
									<th>BALANCE AMOUNT</th>
								</tr>
								<?php
								for($s=0;$s<sizeof($s_billInfo['xray']);$s++){
								?>
								<?php  if($s_billInfo['xray'][$s][4]-$s_billInfo['xray'][$s][5]!=0){?>
								<tr>
									<td><?php echo $s+1;?></td>
									<td><?php echo $s_billInfo['xray'][$s][0];?></td>
									<td><?php echo date("d-m-Y",strtotime($s_billInfo['xray'][$s][1]));?></td>
									<td><?php echo $s_billInfo['xray'][$s][2];?></td>
									<td><?php echo $s_billInfo['xray'][$s][3]+$s_billInfo['xray'][$s][5];?></td>
									<td><?php echo $s_billInfo['xray'][$s][4]-$s_billInfo['xray'][$s][5];?></td>
								</tr>
								<?php
								$tot+=$s_billInfo['xray'][$s][4]-$s_billInfo['xray'][$s][5];
								}
							}
								?>
								<tr>
									<th class="text-right" colspan="5">Total</th>
									<th><?php echo $tot;?></th>
								</tr>
							</table>
						<?php
								}
								?>

									

								<?php }?>
								<?php if($billitems[$i][2]=='MEDICINE CHARGES' ){ 
									 // var_dump($pharmaInfo);
								if($pharmaInfo)
								{
							?>	
								
								
								

							<?php
							$tot = 0;
							
							?>
							<br>
							<table class="sub-table table-bordered" width="100%">
								<tr>
									<th>SL NO</th>
									<th>BILL NO</th>
									<th>BILL DATE</th>
									<th>NET AMOUNT</th>
									<th>AMOUNT PAID</th>
									<th>BALANCE AMOUNT</th>
								</tr>
								<?php
								$tot = 0;
								if(!empty($pharmaInfo)){
									for($s=0;$s<sizeof($pharmaInfo);$s++){
										if( ($pharmaInfo[$s][2]-$pharmaInfo[$s][7] ) !=0 && ($pharmaInfo[$s][8] > 0) ){        //var_dump($pharmaInfo[$s]);

								?>
								<tr>
									<td><?php echo $s+1;?></td>
									<td><?php echo $pharmaInfo[$s][1];?></td>
									<td><?php echo date("d-m-Y",strtotime($pharmaInfo[$s][15]));?></td>
									<td><?php echo $pharmaInfo[$s][2];?></td>
									<td><?php echo $pharmaInfo[$s][10];?></td>
									<!-- <td><?php //echo($pharmaInfo[$s][16]=="Return")?($pharmaInfo[$s][11]*-1):$pharmaInfo[$s][11];?></td> -->

									<td><?php echo($pharmaInfo[$s][16]=="Return")?( ($pharmaInfo[$s][2]-$pharmaInfo[$s][10]) *-1):(($pharmaInfo[$s][2]-$pharmaInfo[$s][10]));?></td>
								</tr>
								<?php
								$tot = $tot+(($pharmaInfo[$s][16]=="Return")?( ($pharmaInfo[$s][2]-$pharmaInfo[$s][10]) *-1): (($pharmaInfo[$s][2]-$pharmaInfo[$s][10])));
									}
									}
									?>
								<tr>
									
									<th colspan="5" class="text-right">Total</th>
									<th><?php echo $tot;?></th>
								</tr>
									<?php
								}
								?>
							</table>
							<?php
								}
								?>

									

								<?php }?>




										</td>
										<td style=" vertical-align:top"><font size="<?php echo $lang_font_size;?>"><?php echo $billitems[$i][3]?></font></td>
										
									</tr>
					<?php


 								} 
 							}?>
 						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][4];?></font></td>
 						</tr>
					<?php if($billInfo[0][7] >0) { ?>
						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>"><?php echo $lang_discount; ?></font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][7];?></font></td>
 						</tr>
					
						
					<?php } ?>
					
					<?php if($billInfo[0][5] >0) { ?>
 						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">ADVANCE PAID</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][5];?></font><br /></td>
 						</tr>
 				        <?php } ?>
 						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">NET AMOUNT</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][8];?></font></td>
 						</tr>
				      
 						<?php
 						    if($billInfo[0][9] == "CREDIT CARD") $amount=$billInfo[0][10]+$billInfo[0][11];
							else if($billInfo[0][9] == "CHEQUE") $amount=$billInfo[0][10]+$billInfo[0][28];
							else if($billInfo[0][9] == "UPI") $amount=$billInfo[0][10]+$billInfo[0][34];
 						    else $amount=$billInfo[0][10];
 						?>
 						
 						
 					<?php if($amount >0) { ?>	
 						<tr>
 							<td colspan="2" align="right"><font size="<?php echo $lang_font_size;?>">AMOUNT PAID</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $amount;?></font></td>
 						</tr>
                <?php } ?>

					</table>
					<?php if($billInfo[0][13] !=''){?>
					<div style="margin-left:35px"><font size="<?php echo $lang_font_size;?>"><?php echo $lang_remarks;?> : <?php echo $billInfo[0][13];?></font></div>
					<?php } ?>
					<div align="center"><?php echo $billInfo[0][9];?></div>
					<table align="right" width="25%"><tr><td width="25%"><font size="<?php echo $lang_font_size;?>">User : </td><td align="left"><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][18];?></font></td></tr>
					<tr><td><font size="<?php echo $lang_font_size;?>">Signature:</font></td><td></td></tr>
					</table>
					<br>
			<div>
				<div class="credits">
			<!-- 	<?php
				$tot = 0;
				if($s_billInfo['lab'])
					{
					?>
					<p>Lab Credits</p>
					<table class="sub-table table-bordered" width="60%">
						<tr>	
							<th>SL NO</th>
							<th>BILL NO</th>
							<th>BILL DATE</th>
							<th>NET AMOUNT</th>
							<th>AMOUNT PAID</th>
							<th>BALANCE AMOUNT</th>
						</tr>
						<?php
						for($s=0;$s<sizeof($s_billInfo['lab']);$s++){
						?>
						<tr>
							<td><?php echo $s+1;?></td>
							<td><?php echo $s_billInfo['lab'][$s][0];?></td>
							<td><?php echo $s_billInfo['lab'][$s][1];?></td>
							<td><?php echo $s_billInfo['lab'][$s][2];?></td>
							<td><?php echo $s_billInfo['lab'][$s][3]+$s_billInfo['lab'][$s][5];?></td>
							<td><?php echo $s_billInfo['lab'][$s][4]-$s_billInfo['lab'][$s][5];?></td>
						</tr>
						<?php
						$tot+=$s_billInfo['lab'][$s][4]-$s_billInfo['lab'][$s][5];
						}
						?>
						<tr>
							<th align="right" colspan="5">Total</th>
							<th><?php echo $tot;?></th>
						</tr>
					</table><br/>
				<?php } ?> -->
					<!-- 			<?php
						$tot = 0;
						if($s_billInfo['xray'])
							{
							?>
							<p>Xray Credits</p>
							<table class="sub-table table-bordered" width="60%">
								<tr>	
									<th>SL NO</th>
									<th>BILL NO</th>
									<th>BILL DATE</th>
									<th>NET AMOUNT</th>
									<th>AMOUNT PAID</th>
									<th>BALANCE AMOUNT</th>
								</tr>
								<?php
								for($s=0;$s<sizeof($s_billInfo['xray']);$s++){
								?>
								<tr>
									<td><?php echo $s+1;?></td>
									<td><?php echo $s_billInfo['xray'][$s][0];?></td>
									<td><?php echo $s_billInfo['xray'][$s][1];?></td>
									<td><?php echo $s_billInfo['xray'][$s][2];?></td>
									<td><?php echo $s_billInfo['xray'][$s][3]+$s_billInfo['xray'][$s][5];?></td>
									<td><?php echo $s_billInfo['xray'][$s][4]-$s_billInfo['xray'][$s][5];?></td>
								</tr>
								<?php
								$tot+=$s_billInfo['xray'][$s][4]-$s_billInfo['xray'][$s][5];
								}
								?>
								<tr>
									<th align="right" colspan="5">Total</th>
									<th><?php echo $tot;?></th>
								</tr>
							</table><?php } ?><br/> -->
						<!-- <?php
						$tot = 0;
						if($theatre_procedure)
							{
							?>
						<p>Surgery Charges</p>
						
						<table class="sub-table table-bordered" width="60%">
								<tr>
									<th>SL NO</th>
									
									<th>TEST</th>
									<th></th>
									<th><th>
								</tr>
								<?php
								$tot = 0;

								for($s=0;$s<sizeof($theatre_procedure);$s++){
								$tot_single=0;
								?>
								<tr>
									<td rowspan="6"><?php echo $s+1;?></td>
									
									<td rowspan="6"><?php echo $theatre_procedure[$s][6];?></td>
									<td>HOSPITAL AMOUNT</td><td><?php echo $theatre_procedure[$s][1];$tot_single+=$theatre_procedure[$s][1];?></td>
								</tr>
								<tr><td>SURGEON FEE</td><td><?php echo $theatre_procedure[$s][2];$tot_single+=$theatre_procedure[$s][2];?></td></tr>
								<tr><td>THEATRE CHARGE</td><td><?php echo $theatre_procedure[$s][3];$tot_single+=$theatre_procedure[$s][3];?></td></tr>
								<tr><td>ANASTHESIA</td><td><?php echo $theatre_procedure[$s][4];$tot_single+=$theatre_procedure[$s][4];?></td></tr>
								<tr><td>OTHER</td><td><?php echo $theatre_procedure[$s][5];$tot_single+=$theatre_procedure[$s][5];?></td></tr>
								<tr><th>TOTAL</th><th><?php echo $tot_single;?></th></tr>
								<?php
								$tot+=$tot_single;
								$tot_paid+=$theatre_procedure[0][9];
								}
								?>
								
								
							</table>
							<?php
							}
							?>
							<br/> -->
				<!-- 			<?php
							$tot = 0;
							if($doc_visits)
								{
							?>
							<p>Specialist Consultation Charges</p>
							<table class="sub-table table-bordered" width="60%">
								<tr>
									<th>SL NO</th>
									<th>DOCTOR</th>
									<th>Number Of Visits</th>
									<th>TOTAL AMOUNT</th>
								</tr>
								<?php
								$tot = 0;
									$doc = $doc_visits[0][2];
									$vis_amount = 0;
									$no_visit =0;
									$sl = 1;
									for($s=0;$s<=sizeof($doc_visits);$s++){
										if($doc==$doc_visits[$s][2]){
											$no_visit +=1;
											$vis_amount += $doc_visits[$s][3];
										}
										else{
								?>
								<tr>
									<td><?php echo $sl;?></td>
									<td><?php echo $doc;?></td>
									<td><?php echo $no_visit;?></td>
									<td><?php echo $vis_amount;?></td>
								</tr>
								<?php
								$tot = $tot+($vis_amount);
									if($s==sizeof($doc_visits))break;
									$doc = $doc_visits[$s][2];
									$vis_amount = 0;
									$no_visit =0;
									$sl++;
									--$s;
									}
								}
									?>
								<tr>
									<td colspan="2"></td>
									<th>Total</th>
									<th><?php echo $tot;?></th>
								</tr>
									
							</table>
							<?php
								}
								?><br/> -->
					<!-- 			<?php
							$tot = 0;
							if($nurse_procedures)
								{
							?>
							<p> Nursing Procedure Charges</p>
						<table class="sub-table table-bordered" width="60%">
							<tr>
								<th>SL NO</th>
								<th>PROCEDURE</th>
								<th>Number of count</th>
								<th>AMOUNT/PROCEDURE</th>
								<th>NET AMOUNT</th>
							</tr>
							<?php
							$tot = 0;
								$proc = $nurse_procedures[0][2];
								$proc_amount = $nurse_procedures[0][3];
								$no_time =0;
								$sl=1;
								for($s=0;$s<=sizeof($nurse_procedures);$s++){
									if($proc == $nurse_procedures[$s][2]){
											$no_time +=1;
										}
										else{
							?>
							<tr>
								<td><?php echo $sl;?></td>
								<td><?php echo $proc;?></td>
								<td><?php echo $no_time;?></td>
								<td><?php echo $proc_amount;?></td>
								<td><?php echo $proc_amount*$no_time;?></td>
							</tr>
							<?php
							$tot = $tot+($proc_amount*$no_time);
								$proc = $nurse_procedures[$s][2];
								$proc_amount = $nurse_procedures[$s][3];
								$no_time =0;
								$sl++;
								--$s;
								}
							}
								?>
							<tr>
								<td colspan="3"></td>
								<th>Total</th>
								<th><?php echo $tot;?></th>
							</tr>
								
						</table>
						<?php
							}
							?> -->
				</div>
			</div>
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()">
				<!-- &nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"> -->
			</div></div></div>
 

  

</div>
</div>

<input type="hidden" name="ipno" value="<?php echo(!empty($post['ipno']))?$post['ipno']:''; ?>">
<input type="hidden" name="room_no" value="<?php echo(!empty($post['room_no']))?$post['room_no']:''; ?>">
<input type="hidden" name="name" value="<?php echo(!empty($post['name']))?$post['name']:''; ?>">
<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="doctor" value="<?php echo(!empty($post['doctor']))?$post['doctor']:''; ?>">


</form>

</body>
</html>
