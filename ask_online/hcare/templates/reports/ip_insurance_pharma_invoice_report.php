<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	   
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

//print
 function printit(){  

alert('Printing..Please make Printer and Paper Ready');
					if (window.print) {
					   window.print();  
					} else {
					   var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
					document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
					   WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = "";  
					}
					}
</script>
<script type="text/javascript">
/*..... Go Back Function .....*/
    function goBack() 
        {      
           document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_report";
           document.patients.submit();
        }
</script>
</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 

<button class="btn btn-success no-print" style="margin-top: -15px;" onclick="goBack()">Go Back</button>
<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];

$pharmaInfo =$this->popArr['pharmaInfo'];
$resultInfo =$this->popArr['resultInfo'];
$patientInfo =$this->popArr['patient_info'];
$post=$this  ->popArr['post']; 
?>

          <h4><?php echo $lang_ip_pharmacy_invoice_report; ?></h4>
		  
 
		<section class="content">		 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
								    <td id="noborder" >
			 				           <font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][1]." ".$patientInfo[0][2]." " .$patientInfo[0][3];?></font>
						            </td>
						            <td id="noborder">
			 				           <font size="<?php echo $lang_font_size;?>"><?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]."/". $patientInfo[0][6];?></font>
						            </td>
						            <td id="noborder">
			 				           <font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][52]."/". $patientInfo[0][0];?></font>
						            </td>
						        </tr>
						        <tr>    
									<td id="noborder">
			 			               <font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no; ?>&nbsp;:&nbsp;<?php echo "IP ".$patientInfo[0][13];?></font>
						            </td>
						            <td id="noborder">
			 			               <font size="<?php echo $lang_font_size;?>"><?php echo $lang_room_no; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][37]."/". $patientInfo[0][38];?></font>
						            </td>
						            <td id="noborder" >
							           <font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor.":&nbsp;"."Dr ".$patientInfo[0][17]." ". $patientInfo[0][18];?></font>
						            </td>
								</tr>
								<tr>
								
								    <td id="noborder">
			 			               <font size="<?php echo $lang_font_size;?>"><?php echo $lang_addmitted_date; ?>&nbsp;:&nbsp;<?php echo date("d-m-Y", strtotime($patientInfo[0][20]));?></font>
						            </td>
						            <td id="noborder">
			 			               <font size="<?php echo $lang_font_size;?>"><?php echo $lang_discharged_date; ?>&nbsp;:&nbsp;<?php if($patientInfo[0][22]=='0000-00-00'||'') 
						              {
                                         /*...No display...*/
						              } 
						          else{
                                         echo date("d-m-Y", strtotime($patientInfo[0][22]));
						              } 
						          ?>  
			 			             </font>
						            </td>
						            <td id="noborder" >
							           <font size="<?php echo $lang_font_size;?>"><?php echo $lang_insurance_company; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][24]; ?></font>
						            </td>
								</tr>
		
						</table>
				
			</div>
			</div>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th><a href="#"><?php echo $lang_date; ?></a></th>
						<th><a href="#"><?php echo $lang_total_amount; ?></a></th>
						<th><a href="#"><?php echo $lang_payment_mode; ?></a></th>	
						<th><a href="#"><?php echo $lang_cash; ?></a></th>   			  
                        <th><a href="#"><?php echo $lang_credit_card; ?></a></th>
                        <th><a href="#"><?php echo $lang_credit_paid; ?></a></th>
						<th><a href="#"><?php echo $lang_balance; ?></a></th>
          
                     </tr>
						</thead>
						<tbody>	
		<?php
						$total=0;
						$totalcash=0;
						$totalcard=0;
						$total_credit_paid=0;
						$balance=0;
							if(!empty($pharmaInfo)){
								$j=1;
								 for($i=0;$i<count($pharmaInfo);$i++) {
	                                   
				                  
								  ?>
									<tr class="rowstyle">
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $j++;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][0];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][11];?></font></td>
			                            <td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][17];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][19];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][23];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][22];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][26];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $pharmaInfo[$i][25];?></font></td>
		                                    
									</tr>
					<?php                  
					                     $total=$total+$pharmaInfo[$i][17];
					                     $totalcash=$totalcash+$pharmaInfo[$i][23];
					                     $totalcard=$totalcard+$pharmaInfo[$i][22];
					                     $total_credit_paid=$total_credit_paid+$pharmaInfo[$i][26];
					                     $balance=$balance+$pharmaInfo[$i][25];
					                            }
                                       
 								} 
 							?>
 							         <tr>
 							         	  <td></td>
 							         	  <td></td>
 							         	  <td><b>TOTAL</b></td>
 							         	  <td><b><?php echo $total; ?><b></td>
 							         	  <td></td>
 							         	  <td><b><?php echo $totalcash; ?><b></td>
 							         	  <td><b><?php echo $totalcard; ?><b></td>
 							         	  <td><b><?php echo $total_credit_paid; ?><b></td>
 							         	  <td><b><?php echo $balance; ?><b></td>
 							         </tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">

<!--......back button settings......-->
  <input type="hidden" name="from_date" id="from_date" value="<?php echo $post['from_date']; ?>" />
  <input type="hidden" name="to_date" id="to_date" value="<?php echo $post['to_date']; ?>" />
  <input type="hidden" name="ipno" id="ipno" value="<?php echo $post['ipno']; ?>" />
  <input type="hidden" name="opno" id="opno" value="<?php echo $post['opno']; ?>" />
  <input type="hidden" name="first_name" id="first_name" value="<?php echo $post['first_name']; ?>" />
  <input type="hidden" name="place" id="place" value="<?php echo $post['place']; ?>" />
  <input type="hidden" name="doctor" id="doctor" value="<?php echo $post['doctor']; ?>" />
  <input type="hidden" name="insurance_company" id="insurance_company" value="<?php echo $post['insurance_company']; ?>" />
  <input type="hidden" name="paction" id="paction" value="BACK" />
  <input type='hidden' name='current_page' id='current_page' value="<?php echo $post['current_page']; ?>">
  
</form>
</body>
</html>
