<?php
	
	$doctorInfo=$this  ->popArr['doctor_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$doctor_selected=$this  ->popArr['doctor_selected'];
	$data=$this  ->popArr['data'];

	$dataPoints = array( 
		array("y" => $data['ip_discharge'], "label" => "DISCHARGE" ),
		array("y" => $data['lab'], "label" => "LAB BILL" ),
		array("y" => $data['pharmacy'], "label" => "PHARMACY CASH BILL" ),
		array("y" => $data['procedure'], "label" => "PROCEEDURE CASH BILL" ),
		array("y" => $data['registration'], "label" => "REGISTRATION" ),
		array("y" => $data['xray'], "label" => "X-RAY" )
	);

if (!empty($post['pdf'])) {

ob_start();

}
?>
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
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="../../dist/js/canvasjs.min.js"></script>
 <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
	 <script>
	 	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script type="text/javascript">



function submitform(){

	if (document.report.from_date.value == '') {
		document.getElementById('from_date_error').style.display = "block";
		return false;		
	}
	else if (document.report.to_date.value =='') {
		document.getElementById('to_date_error').style.display = "block";
		return false;			
	}
	else if (document.report.doctor.value =='') {
		document.getElementById('doctor_error').style.display = "block";
		return false;		
	}
	else{
		document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctors_collection_report";
		document.report.submit();
	}
	

}

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
   function download_pdf(){
   	
		document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		document.report.submit();

   }
   function clear_form(){

   	    window.location.href = "../../lib/controllers/centralController.php?module=Report&sub_module=doctors_collection_report";
   }



	window.onload = function() {
	 
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light2",
		title:{
			text: ""
		},
		dataPointWidth: 60,
		axisY: {
			title: ""
		},
		data: [{
			type: "column",
			yValueFormatString: "#,##0.## Rs",
			dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	 
	}

</script>

<style type="text/css">
	.text-red{
		font-weight: 700;
	}
	.doctor_name{
	    font-size: 16px;
	    font-weight: 700;
	    padding-bottom: 15px !important;
	    padding-top: 15px !important;		
	}
	.bill_data{
		font-weight: 600;
		font-size: 13px !important;
	}
	@media print{
		html,body{
			height: 100% !important;
		}
	}
	a.canvasjs-chart-credit {
	    display: none;
	}
</style>

</head>
<body id="frame">
<form name="report" id="form"  method="post" action=""> 

    	
  <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search; ?></h4>
		  
        </section>
 
	<section class="content">
      	 <div class="DONTPrint">	 
	   <div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
											<br>
											<span id="from_date_error" class="text-red" style="display:none;">please select from date</span>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
										<span id="to_date_error" class="text-red" style="display:none;">please select to date</span>
											
										</td>								
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" class="select2" /> 		
									<option value=''>------------------------------</option>
											
											<?php
											   if(!empty($doctors)){	

											   for($i=0;$i<count($doctors);$i++){ ?>																					
												<option value='<?php echo $doctors[$i][0];?>' <?php if(!empty($doctor_selected) && $doctor_selected==$doctors[$i][0] ){echo "selected";} ?> ><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
								  	
												
										<?php 		} 
												} ?>
									</select>
									<span id="doctor_error" class="text-red" style="display:none;">please select a Doctor</span>
							</td>	
								
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" class="btn btn-info" value="Clear" onclick="clear_form();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 ><?php echo "DOCTOR COLLECTION REPORT" ?></h4>
				
		<h5 style="font-weight: 700;font-size: 17px;">
			<?php

				if (!empty($data['doctor_name'])) {
					echo "Doctor Name : ".$data['doctor_name'];
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "Report Date : ".date("d-m-Y h:i A");
				}

			?>
		</h5>

			<div class="box box-info">
                
                           <div class="box-body">


<?php

if (!empty($post['pdf'])) {

ob_end_clean();
ob_start();

?>

	<h4><?php echo "DOCTOR COLLECTION REPORT"; ?> <?php if (!empty($post['from_date'])) {
		echo "FROM ".$post['from_date'];} if (!empty($post['to_date'])) {
			echo " TO ".$post['to_date'];
		}?></h4>
		<h4 style="font-weight: 700;font-size: 14px;">
			<?php

				if (!empty($data['doctor_name'])) {
					echo "Doctor Name : ".$data['doctor_name'];
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "Report Date : ".date("d-m-Y h:i A");
				}

			?>
		</h4>


<?php
}
?>


		<?php
			if (!empty($data)) {?>


			    <table class="table table-bordered table-striped" border="1" style="border-collapse: collapse;width: 70%;">

			    	<thead>

			    	<!-- 	<tr>
				    		<td width="15%" class="doctor_name">DOCTOR NAME</td>
				    		<td width="15%" class="doctor_name"><?php echo strtoupper($data['doctor_name']); ?></td>
			    		</tr> -->

			    		<tr>
				    		<td width="15%" class="bill_data">BILL NAME</td>
				    		<td width="15%" class="bill_data">GROSS AMOUNT</td>
			    		</tr>

			    	</thead>
       			
			    	<?php

			    		if (!empty($data['ip_discharge'])) {?>

			    			<tr>
			    				<td width="15%">DISCHARGE</td>
			    				<td width="15%"><?php echo $data['ip_discharge']; ?></td>
			    			</tr>

			    		<?php
			    			}
			    		if (!empty($data['lab'])) {?>

			    			<tr>
			    				<td width="15%">LAB BILL</td>
			    				<td width="15%"><?php echo $data['lab']; ?></td>
			    			</tr>

			    		<?php
			    			}
			    		if (!empty($data['pharmacy'])) {?>

			    			<tr>
			    				<td width="15%">PHARMACY CASH BILL</td>
			    				<td width="15%"><?php echo $data['pharmacy']; ?></td>
			    			</tr>

			    		<?php
			    			}
			    		if (!empty($data['procedure'])) {?>

			    			<tr>
			    				<td width="15%">PROCEDURE CHARGES</td>
			    				<td width="15%"><?php echo $data['procedure']; ?></td>
			    			</tr>

			    		<?php
			    			}
			    		if (!empty($data['registration'])) {?>

			    			<tr>
			    				<td width="15%">REGISTRATION</td>
			    				<td width="15%"><?php echo $data['registration']; ?></td>
			    			</tr>

			    		<?php
			    		}
			    		if (!empty($data['xray'])) {?>

			    			<tr>
			    				<td width="15%">X-RAY</td>
			    				<td width="15%"><?php echo $data['xray']; ?></td>
			    			</tr>

			    		<?php

			    		}

			    		$total = $data['ip_discharge']+$data['lab']+$data['procedure']+$data['registration']+$data['xray']+$data['pharmacy'];

			    	?>
			    			<tr>
			    				<td width="15%" class="bill_data">TOTAL</td>
			    				<td width="15%" class="bill_data"><?php echo $total; ?></td>
			    			</tr>



				</table>

				<div id="chartContainer" class="DONTPrint" style="height: 370px; width: 70%;margin-top: 40px;"></div>


				<?php

				if (empty($post['pdf'])) {?>

					 <div class="DONTPrint" align="center" style="margin-top: 70px;"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
				</div>

				<?php
				}
				?>
			<?php
			}
 		?>




			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="doctors_collection_report" value="doctors_collection_report" />

	



</section>
</form>	  
</body>
	</html>
	
<?php
if (!empty($post['pdf'])) {

$myvar = ob_get_clean();
ob_end_clean();


$myvar = utf8_encode($myvar);
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->allow_charset_conversion = TRUE;
$mpdf->charset_in = 'UTF8'; 
$mpdf->WriteHTML($myvar);
$mpdf->Output("Doctor-Collection-Report.pdf", "D"); 


}





 ?>