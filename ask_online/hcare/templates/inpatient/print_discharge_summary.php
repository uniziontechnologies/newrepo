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
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<script type="text/javascript" src="../../plugins/tinymce/tinymce.min.js">  </script>
<!-- <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>	 -->


<body id="frame" >
 

<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';

$db_function=new DBFunction();
$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];

$post=$this ->popArr['postArr'];
$dischargeInfo=$this ->popArr['data']['dischargeInfo'];
$dischargeInfoFields=$this ->popArr['data']['dischargeInfoFields'];
$dischargeInfoValues=$this ->popArr['data']['dischargeInfoValues'];

$ipBillDates=$this ->popArr['data']['ipBillDates'];
$ipBillIds=$this ->popArr['data']['ipBillIds'];
$resultEntryInfo=$this ->popArr['data']['resultEntryInfo'];

?>
<style type="text/css">
	@page{margin-top: 5cm;margin-bottom: 1cm;}
    a.red {
        color: red;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }
    .class_input{
    	width: 80%;
    }
    @media print{
    	#print_data{
    		margin-top: -60px;
    		margin-bottom: 30px;
    	}
    	table {page-break-inside: avoid;}
    	/*#end_print {page-break-inside: always;}*/
  html, body {
    /*width: 210mm;
    height: 297mm;*/
    height: 100% !important;
  }



    }
    #print_data{
    	margin-bottom: 30px;
    }
    table.table.table_style td, table.table.table_style th {
    border-top: 1px solid black !important;
	}
.padding_bottom {
    padding-bottom: 5px;
    padding-top: 5px;
    font-size: 14px !important;
}
div.font_weight {
    font-weight: 600;
	/*padding-top: 5px;*/
    /*padding-bottom: 5px;*/
}
.bold_font{
	font-weight: 600;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
	border-top: none;
	padding-bottom: 0px !important;
}
.table{
	margin-bottom: 10px !important;
}
th {
    border-bottom: none !important;
}
td,th{
	font-size: 15px;
}
.font_14{
	font-size: 12px !important;
}
.table {
    margin-bottom: 0px !important;
}
p {
    margin-bottom: 0px !important;
}
</style>

<form name="department" id="form"  method="post" action=""> 

<div id="content">

<section class="content">


	 <!-- <table width ="100%" id="print_data">
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="60px"></img></td>
		</tr> 
	 
	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php// echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php //echo $lang_font_size;?>"><?php// echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php //echo $lang_font_size;?>"><?php //echo "TEL: ".$phone;?></font></td>
		</tr>
		</table>
 -->
		<div>
			<h4 style="text-align: center;"><b>DISCHARGE SUMMARY </b></h4>
		</div>			 
	<!-- <div class="box box-info" style="border-top: none;">
                


            <div class="box-body bold_font" > -->

				
			<table class="table" border="1" style="border-collapse: collapse;">

				<thead>
						
					<tr>
							
						<td rowspan="2" class="bold_font">
							
							Patient Name : <?php echo strtoupper($dischargeInfo[0][2]); ?>

						</td>

						<td rowspan="2" class="bold_font">
							
							Age/Sex : <?php echo $dischargeInfo[0][10]." / ".$dischargeInfo[0][17]; ?>

						</td>


						<td colpsan="2" class="bold_font">
							
							IP No : <?php echo $dischargeInfo[0][1]; ?>

						</td>


						<td rowspan="2" class="bold_font"> 
							
							Room/Bed No : <?php echo $dischargeInfo[0][13]; ?>

						</td>



					</tr>

					<tr>
						
						<td class="bold_font">OP No : <?php echo $dischargeInfo[0][9]."/".$dischargeInfo[0][8]; ?></td>
						
					</tr>



					<tr>
						
						<td rowspan="2" colspan="2" class="bold_font">Address : <?php echo strtoupper($dischargeInfo[0][11]); ?></td>

						<td  colspan="2" class="bold_font">Date of Admission : <?php echo date("d-m-Y",strtotime($dischargeInfo[0][3])); ?></td>


					</tr>

					<tr>
						
						<td  colspan="2" class="bold_font">Date of Discharge  : <?php echo date("d-m-Y",strtotime($dischargeInfo[0][4])); ?></td>

					</tr>


				</thead>

			</table>


	<!-- 		</div>







		</div> -->


			<?php

				if (!empty($dischargeInfoValues)) {
					
					for ($i=0; $i <count($dischargeInfoValues) ; $i++) { 

						$dischargeInfoFields[$i][2] = strtolower($dischargeInfoFields[$i][2]);
						$dischargeInfoFields[$i][2] = ucfirst($dischargeInfoFields[$i][2]);


						if ($dischargeInfoFields[$i][5]=="CONSULTANT_DETAILS") {?>

							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table" border="1" style="border-collapse: collapse;margin-top: -1px;">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]; ?></th>
										</thead>

										<tbody>
											<tr><td>
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { ?>

													<?php echo $dischargeInfoValues[$i][$j][3]."<br>"; ?>

												<?php
												}


											 ?>
											 </td></tr>
										</tbody>
										
									</table>

								</div>


							</div>

						<?php
						}
						else if ($dischargeInfoFields[$i][5]=="TEXT_FIELD") {?>

							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table"  border="1" style="border-collapse: collapse;margin-top: -1px;">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]; ?></th>
										</thead>

										<tbody>
											<tr><td>
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { ?>

													<?php echo $dischargeInfoValues[$i][$j][3]; ?>

												<?php
												}


											 ?>
											 </td></tr>
										</tbody>
										
									</table>

								</div>


							</div>

						<?php
						}
						else if ($dischargeInfoFields[$i][5]=="TINYMCE") {?>

							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table" border="1" style="border-collapse: collapse;margin-top: -1px;">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]; ?></th>
										</thead>

										<tbody>
											<tr><td style="word-break: break-word;">
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { ?>

													<?php echo $dischargeInfoValues[$i][$j][3]; ?>

												<?php
												}


											 ?>
											 </td></tr>
										</tbody>
										
									</table>

								</div>


							</div>


						<?php
						}
						else if ($dischargeInfoFields[$i][5]=="DIET") {?>


							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table" style="border-collapse: collapse;margin-top: -1px;" border="1">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]; ?></th>
										</thead>

										<tbody>
											<tr><td>
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { ?>

													<?php echo $dischargeInfoValues[$i][$j][3]; ?>

												<?php
												}


											 ?>
											 </td></tr>
										</tbody>
										
									</table>

								</div>


							</div>



					<?php	
					}
					else if ($dischargeInfoFields[$i][5]=="REMARKS") {?>


							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table" style="border-collapse: collapse;margin-top: -1px;" border="1">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]; ?></th>
										</thead>

										<tbody>
											<tr><td>
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { ?>

													<?php echo $dischargeInfoValues[$i][$j][3]; ?>

												<?php
												}


											 ?>
											 </td></tr>
										</tbody>
										
									</table>

								</div>


							</div>




					<?php
					}
					else if ($dischargeInfoFields[$i][5]=="DISCHARGE_ADVICE") {?>


							<div class="row style_class">

								<div class="col-md-12">
									
									<table class="table" style="width: 100% !important;border-collapse: collapse;margin-top: -1px;" border="1">

										<thead>
											<th><?php echo $dischargeInfoFields[$i][2]." ( Medicines ) "; ?></th>
										</thead>

										<tbody>

											<tr>
												<td>

													<table>
															
															<tr>
											<?php

												for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) {

													$items[$i][$j]=explode("#@&",$dischargeInfoValues[$i][$j][3]);
													
													if (!empty($items[$i][$j])) {?>

														
																<tr>
																<td>
																	<?php echo $items[$i][$j][0]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $items[$i][$j][1]; ?>&nbsp;&nbsp;&nbsp;</td><td><?php echo $items[$i][$j][2]." days"."<br>"; ?>
																</td>
																</tr>

															

														

													<?php
													}

												}


											 ?>

											 </tr>

														</table>
											 	</td>
											</tr>

										</tbody>
										
									</table>

								</div>


							</div>					



				    <?php
					}

						else if ($dischargeInfoFields[$i][5]=="LAB_REPORTS") {?>

							<div class="row style_class">

								<div class="col-md-12">
									


											<table class="table table_style" style="border-collapse: collapse;table-layout: fixed;margin-top: -1px;" border="1" >
						


													<tr>
														
														<td>
														<?php 
															echo "<b style='font-size:15px !important;'>Investigations :</b>"."<br>";
															if (!empty($ipBillDates)) {
																$count = 0;
																for ($x=0; $x < count($ipBillDates) ; $x++) { ?> 

																	<div class="padding_bottom"><b><u><?php echo date("d-m-Y",strtotime($ipBillDates[$x]))."<br>"; ?></u></b> </div>

																<?php
																	for ($y=0; $y < count($ipBillIds[$x]) ; $y++) { 
																		
																		for ($z=0; $z < count($resultEntryInfo[$x][$y]) ; $z++) { 



																			if ($resultEntryInfo[$x][$y][$z][7]!=3) {

																				if ( $count!=0 && $count%20==0) {
																					echo "</td><td>";
																				}
																				$count++;

																				?>

																				<?php if($resultEntryInfo[$x][$y][$z][7]==1){echo "<div class='font_weight'>";} ?>

																				<span class="font_14">
																					
																					<?php 

																					

																					if($resultEntryInfo[$x][$y][$z][7]!=1){
																						$word = strtolower($resultEntryInfo[$x][$y][$z][3].'&nbsp;&nbsp;&nbsp;&nbsp;'.$resultEntryInfo[$x][$y][$z][4]."&nbsp;<span class='unit'>".$resultEntryInfo[$x][$y][$z][6]."</span><br>");
																						echo ucfirst($word);
																					}
																					else{
																						$word = strtolower($resultEntryInfo[$x][$y][$z][3]."<br>");
																						echo strtoupper($word);
																					}

																					 ?>

																				</span>					
																				

																				<?php if($resultEntryInfo[$x][$y][$z][7]==1){echo "</div>";} ?>
																												
																			<?php
																			}

																		}

																	}


																}

															}

														?>
														</td>
													</tr>

											</table>

								</div>


							</div>


						<?php


					}
					else if ($dischargeInfoFields[$i][5]=="CONSULTATION_DETAILS") {

						$count_doctors = 0;

														for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) {

															$items[$i][$j]=explode(",",$dischargeInfoValues[$i][$j][3]);
															
															if (!empty($items[$i][$j])){

																for ($b=0; $b < count($items[$i][$j]) ; $b++) { 

																	$count_doctors++;
																
																
																}
															
															}

														}



													?>


							<div class="row style_class" style="margin-top: 50px;<?php if ($count_doctors<=1){echo "width: 150%;";} ?>">

								<div class="col-md-12">
									
									<table class="table" style="width: 100% !important;text-align: right;">

										<thead>
											<th><?php //echo "CONSULTATION DETAILS"; ?></th>
										</thead>

										<tbody>

											<tr>
												
												
													
													<?php 

														for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) {

															$items[$i][$j]=explode(",",$dischargeInfoValues[$i][$j][3]);
															
															if (!empty($items[$i][$j])){

																for ($b=0; $b < count($items[$i][$j]) ; $b++) { 

																// if ($items[$i][$j][$b]==41) {
																// 	$title_name = 'Prof';
																// }
																// else{
																// 	$title_name = $db_function->getidToValue("title","id",$items[$i][$j][$b],"hcare_emp_info");
																// }

																$doc_name = strtoupper($db_function->getidToValue("title","id",$items[$i][$j][$b],"hcare_emp_info")).". ".$db_function->getidToValue("first_name","id",$items[$i][$j][$b],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$items[$i][$j][$b],"hcare_emp_info");


																$qualification = $db_function->getidToValue("qualification","emp_id",$items[$i][$j][$b],"hcare_emp_job_info");

																?>

																<td style="text-align: center;font-weight: 700;"><?php echo $doc_name."<br>".$qualification; ?></td>

																
																<?php
																}
															
															}

														}

													?>

												
											</tr>



										</tbody>
										
									</table>

								</div>


							</div>					



				    <?php
					}




				}

			}


			 ?>



			<?php


				if (!empty($dischargeInfo[0][6]) && $dischargeInfo[0][6]!="1970-01-01" ) {?>


			    	<div class="row" id="end_print" style="font-size:13px;">
	                    <div class="col-xs-4">
						<b><?php echo $lang_followup_date; ?> : <?php echo $dischargeInfo[0][6]; ?></b>
	                    </div>
                    </div>


				<?php
				}

			 ?>

			<?php

				if (!empty($dischargeInfoValues)) {
					
					for ($i=0; $i <count($dischargeInfoValues) ; $i++) { 

		 				if ($dischargeInfoFields[$i][5]=="INVESTIGATION") {?>


					 		<div class="row" style="margin-top: 30px;">
					 			
					 			<div class="col-md-4">
					 				
					 				<button class="btn btn-danger btn-block DONTPrint" onclick="return print_investigation();">Print Investigation</button>

					 			</div>

					 		</div>


			 	<?php
			 	}
			 }

			}
		 	?>




			 <div class="row" style="margin-top: 50px;">
			 	
			 	<div class="col-md-offset-5 col-md-2">
			 		
			 		<input  type="button" name="but" value="Print" class="btn btn-info btn-block DONTPrint"  onClick="Print()">

			 	</div>

			 </div>











	</div>

</section>

<input type="hidden" name="id" id="id" value="<?php echo $dischargeInfo[0][1]; ?>">
<input type="hidden" name="printing_investigation" id="printing_investigation" value="printing_investigation">




</form>
          
<script type="text/javascript">
	

		function print_investigation(){
			
			$("#form").attr("target","_blank");
		   	document.department.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_lab_report_datewise";
			document.department.submit();
			return false;

		}

</script>