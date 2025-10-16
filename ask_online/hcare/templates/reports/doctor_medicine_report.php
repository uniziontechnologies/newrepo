<?php

	$medicine_list=$this  ->popArr['medicine_list'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$title="";

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


function submitform(){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_medicine_report";
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
					filename: "Doctor Medicine Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.report.submit();

   }
   function clear_form(){

   		window.location.href ="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_medicine_report";

   }
   function submit_form(){

		document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_report";
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
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="clear_form();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 >Doctor Medicine Report  From <?php echo $post['from_date']; ?> To <?php echo $post['to_date'];?>&nbsp;&nbsp;&nbsp;&nbsp; Doctor : <?php echo (!empty($post['doctor_name']))?$post['doctor_name']:'All';?></h4>
					
			<div class="box box-info">
                
                           <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
       			
				<thead>
					<tr class="hide_div"><td><h4>Doctor Medicine Report  From <?php echo $post['from_date']; ?> To <?php echo $post['to_date'];?>&nbsp;&nbsp;&nbsp;&nbsp; Doctor : <?php echo (!empty($post['doctor_name']))?$post['doctor_name']:'All';?></h4></td></tr>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                         <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
                         <th ><a href="#">Cust Type</a></th>
                         <th ><a href="#"><?php echo $lang_customer_name; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th><a href="#"><?php echo $lang_bill_date; ?></a></th>
						 <th><a href="#"><?php echo $lang_mode; ?></a></th>
						 <th><a href="#"><?php echo $lang_brand; ?></a></th>
						 <th><a href="#"><?php echo $lang_batch; ?></a></th>
						 <th><a href="#"><?php echo $lang_expiry; ?></a></th>
						 <th><a href="#"><?php echo $lang_qty; ?></a></th>
						 <th ><a href="#">MRP</a></th>
						 <th><a href="#"><?php echo $lang_total; ?></a></th>

                            </tr>
						</thead>
						<tbody>	
		<?php
		$qty=0;
		$mrp=0;
		$total=0;
			if(!empty($medicine_list)){
			$j=1;
				for($i=0;$i<count($medicine_list);$i++) {?>

					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $medicine_list[$i][0];?></td>
						<td><?php echo $medicine_list[$i][1];?></td>
						<td><?php echo $medicine_list[$i][4];?></td>
						<td><?php echo $medicine_list[$i][2];?></td>
						<td><?php echo $medicine_list[$i][6];?></td>
						<td><?php echo $medicine_list[$i][9];?></td>
						<td><?php echo $medicine_list[$i][19];?></td>
						<td><?php echo $medicine_list[$i][10];?></td>
						<td><?php echo $medicine_list[$i][12];?></td>
						<td><?php echo $medicine_list[$i][14];?></td>
						<td><?php echo $medicine_list[$i][16];?></td>
						<td><?php echo $medicine_list[$i][18];?></td>										         
					</tr>
						
				
		<?php
		$qty +=$medicine_list[$i][14];
		$mrp +=$medicine_list[$i][16];
		$total +=$medicine_list[$i][18];
			}
			
			}		
		?>
					</tbody>
					<tfoot>

						<tr>
						<td colspan="10" align="right"><b>Total</b></td>
						<td><b><?php echo round($qty);?></b></td>
						<td><b><?php echo round($mrp);?></b></td>
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
	 <input type="hidden" name="page_name" id="doctor_medicine_report" value="doctor_medicine_report" />

<?php
if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()"></div>

      	</div>
  		
<?php
}
?>


</section>

</form>	  

</body>
	</html>
	
