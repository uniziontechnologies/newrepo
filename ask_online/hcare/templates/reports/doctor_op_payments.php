<?php
	
	$doctorInfo=$this  ->popArr['doctorInfo'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

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
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>
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
		 $('.hide_div').hide();
	  });
	  </script>
<script type="text/javascript">



function doctor_report(docid){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_payment_report&docid="+docid;
	document.report.submit();
}
function submitform(){

		if(action =="CLEAR"){
		
			document.report.from_date.value='';
			document.report.to_date.value='';
			document.report.doctor.value='';
			
			
		}

	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_op_payments";
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
   	$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Doctor Payment Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.report.submit();

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
									<input id="button1" type="button" name="Clear" class="btn btn-info" value="Clear" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 ><?php echo "DOCTOR PAYMENT REPORT"; ?></h4>
					
			<div class="box box-info">
                
                           <div class="box-body">




			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo "DOCTOR PAYMENT REPORT"; ?> <?php if (!empty($post['from_date'])) {
		echo "From ".$post['from_date'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th ><a href="#"><?php echo "DOCTOR PAYMENT"; ?></a></th>   					  
                           
                            </tr>
						</thead>
						<tbody>	
		<?php
		$total=0;
			if(!empty($doctorInfo)){
			$j=1;
				for($i=0;$i<count($doctorInfo);$i++) {
					// var_dump($doctorInfo[$i]);
					?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><a href="#" onclick="doctor_report('<?php echo $doctorInfo[$i][2];?>');"><?php echo $doctorInfo[$i][0];?></a></td>
						<td><?php echo	$doctorInfo[$i][1]?></td>
										
                           
					</tr>
						
				
		<?php
		$total +=$doctorInfo[$i][1];
			}
			
			}		
		?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="2" align="right"><b>Total</b></td>
						<td><b><?php echo round($total);?></b></td>
						
					</tr>
				</tfoot>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="doctor_op_payments" value="doctor_op_payments" />

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
