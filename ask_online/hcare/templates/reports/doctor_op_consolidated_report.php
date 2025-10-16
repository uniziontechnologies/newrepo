<?php
	
	$doctorInfo=$this  ->popArr['doctor_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

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

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script type="text/javascript">



// function doctor_report(docid){

	
// 	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_report&docid="+docid;
// 	document.report.submit();
// }
function submitform(){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_consolidated_report";
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
   function clear_form(){

   		window.location.href ="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_consolidated_report";

   }


</script>

<style type="text/css">
						<!--
						@media print {
						  .DONTPrint{ display:none }
						  .DOCheck        { display:table}
						}
						-->
					</style>

</head>
<body id="frame">
<form name="report" id="form"  method="post" action=""> 

    	
  <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search; ?>a</h4>
		  
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
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
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
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" class="btn btn-info" value="Clear" onclick="clear_form();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 ><?php echo $lang_doctor." ".$lang_report." (All values are in INR)"; ?></h4>
					
			<div class="box box-info">
                
                           <div class="box-body">


<?php

if (!empty($post['pdf'])) {

ob_end_clean();
ob_start();

?>

	<h4><?php echo $lang_doctor." ".$lang_report; ?> <?php if (!empty($post['from_date'])) {
		echo "From ".$post['from_date'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date'];
		}?></h4>

<?php
}
?>

			        <table class="table table-bordered table-striped" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th><a href="#"><?php echo "TOTAL CONSULTATION COLLECTED" ?></a></th>
						 <th><a href="#"><?php echo "DOCTOR SHARE" ?></a></th>
						 <th ><a href="#"><?php echo "HOSPITAL SHARE"; ?></a></th>	  					  
                           
                    </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($doctorInfo)){
			$j=1;
				for($i=0;$i<count($doctorInfo);$i++) {

					if ($doctorInfo[$i][2]!="" && $doctorInfo[$i][3]!="") {?>

						<tr>
							<td><?php echo $j++;?></td>
							<td><a href="#"><?php echo $doctorInfo[$i][0];?></a></td>
							<td><?php echo $doctorInfo[$i][1]?></td>
							<td><?php echo $doctorInfo[$i][2];?></td>
							<td><?php echo $doctorInfo[$i][3];?></td>
											     
						</tr>


					<?php
					}						
				
			}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="doctor_op_consolidated_report" value="doctor_op_consolidated_report" />

<?php

if (empty($post['pdf'])) {?>

	 <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
</div>

<?php
}
?>


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
$mpdf->Output("Doctor-Op-Consolidated-Report.pdf", "D"); 


}





 ?>