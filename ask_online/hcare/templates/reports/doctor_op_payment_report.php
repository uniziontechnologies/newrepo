<?php
	
	$doctorInfo=$this  ->popArr['doctorInfo'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$title="";

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

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_payment_report";
	document.report.submit();
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
	function submit_form() {
    		
		   $("#doctor").val('');
	       document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_payments";
	       document.report.submit();
	}
</script>

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
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
											
										</td>								
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" class="select2" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { 
													
													$title=$doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];
													?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
								
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 >Detailed Fee Collection Report Of <?php echo $title; ?> Between <?php echo $post['from_date']; ?> and <?php echo $post['to_date'];?></h4>
					
			<div class="box box-info">
                
                           <div class="box-body">

<?php

if (!empty($post['pdf'])) {

ob_end_clean();
ob_start();

?>

	<h4>Detailed Fee Collection Report Of <?php echo $title; ?> Between <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4>

<?php
}
?>

			        <table class="table table-bordered table-striped" border="1" style="border-collapse: collapse;">
       			
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_visit." ".$lang_date; ?></a></th>
						 <th><a href="#"><?php echo "PAYMENT ".$lang_date ?></a></th>
						 <th><a href="#"><?php echo $lang_amount_paid; ?></a></th>
						 <th><a href="#"><?php echo $lang_balance; ?></a></th>

                            </tr>
						</thead>
						<tbody>	
		<?php
		$amount_paid=0;
		$balance=0;
			if(!empty($doctorInfo)){
			$j=1;
				for($i=0;$i<count($doctorInfo);$i++) {?>

					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $doctorInfo[$i][2];?></td>
						<td><?php echo $doctorInfo[$i][3];?></td>
						<td><?php echo $doctorInfo[$i][5];?></td>
						<td><?php echo $doctorInfo[$i][7];?></td>										
                           
					</tr>
						
				
		<?php	

		$amount_paid +=$doctorInfo[$i][5];
		$balance +=$doctorInfo[$i][7];

	}
			
			}		
		?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="3" align="right"><b>Total</b></td>
						<td><b><?php echo round($amount_paid);?></b></td>
						<td><b><?php echo round($balance);?></b></td>
						
					</tr>
				</tfoot>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="doctor_op_payment_report" value="doctor_op_payment_report" />

<?php
if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-success" onclick="submit_form()"></div>

      	</div>
  		
<?php
}
?>


</section>

<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">

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
$mpdf->Output("Doctor-Payment-Report.pdf", "D"); 


}





 ?>