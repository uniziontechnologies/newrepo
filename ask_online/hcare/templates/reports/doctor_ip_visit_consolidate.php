
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

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 $('.hide_div').hide();
	  });
	  </script>
<script type="text/javascript">



function doctor_visit_report(docid){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_ip_visit_report&docid="+docid;
	document.report.submit();
}
function change_user_type(){
        document.report.user.value='';
        document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_ip_visit_consolidated";
	document.report.submit();
}
function submitform(){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_ip_visit_consolidated";
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
					filename: "Doctor Ip Visit Consolidated",
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
<?php
	
	$doctor_visitinfo=$this  ->popArr['doctor_visitinfo'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];
	
?>
    	
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
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="change_user_type();"/> 		
							
									<option value=''>-----------------</option>
						
											
											<?php for($i=0;$i<count($user_type);$i++){ 
																						
													if(!empty($post['user_type']) && $post['user_type']==$user_type[$i][0]) { ?>
													
														<option value='<?php echo $user_type[$i][0];?>' selected><?php echo $user_type[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user_type[$i][0];?>'><?php echo $user_type[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">
							<?php echo $lang_user; ?> </td>
								<td id="noborder" ><select name="user" id="user"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>-------------</option>
											
											<?php for($i=0;$i<count($user);$i++){ 
																						
													if(!empty($post['user']) && $post['user']==$user[$i][0]) { ?>
													
														<option value='<?php echo $user[$i][0];?>' selected><?php echo $user[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user[$i][0];?>'><?php echo $user[$i][3];?></option>
												
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
		<h4 ><?php echo $lang_doctor." ".$lang_ip." ".$lang_visit." ".$lang_report; ?> (CONSOLIDATED) From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?></h4>
		
			
			</h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>
					
			<div class="box box-info">
                
                           <div class="box-body">




			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_doctor." ".$lang_ip." ".$lang_visit." ".$lang_report; ?> (CONSOLIDATED) From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th  colspan="2" align="center"><?php echo $lang_emergency ?></th>
						 <th colspan="2"><?php echo $lang_ip_visit ?></th>
						 <th colspan="2"><?php echo $lang_ip_billing; ?></th>	
						 <th ><a href="#"><?php echo $lang_fees_collected; ?></a></th> 
										  
                           
                            </tr>
			    <tr>
			                  <th></th>
					  <th></th>
					  <th><a href="#"><?php echo $lang_fees; ?></a></th>
					  <th><a href="#"><?php echo $lang_no_visit; ?></a></th>
					  <th><a href="#"><?php echo $lang_fees; ?></a></th>
					  <th><a href="#"><?php echo $lang_no_visit; ?></a></th>
					  <th><a href="#"><?php echo $lang_fees; ?></a></th>
					  <th><a href="#"><?php echo $lang_visit; ?></a></th>
					  <th></th>
					 
			</tr>
						</thead>
						<tbody>	
		<?php
		$emergency_visit_fee=0;
	    $e_count=0;
		$ip_visit_fee=0;
		$ip_count=0;
		$ip_billing_fee=0;
		$ip_billing_count=0;
		$total=0;
			if(!empty($doctor_visitinfo)){
			$j=1;
			
				for($i=0;$i<count($doctor_visitinfo);$i++) {
				$dr_fee_total=0;
				?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><a href="#" onclick="doctor_visit_report('<?php echo $doctor_visitinfo[$i][7];?>');"><?php echo $doctor_visitinfo[$i][0];?></a></td>
						<td><?php echo	$doctor_visitinfo[$i][1]?></td>
						<td><?php echo $doctor_visitinfo[$i][2];?></td>
						<td><?php echo $doctor_visitinfo[$i][3];?></td>
						<td><?php echo $doctor_visitinfo[$i][4];?></td>
						<td><?php echo $doctor_visitinfo[$i][5];?></td>
						<td><?php echo $doctor_visitinfo[$i][6];?></td>
						<?php
                                                 $dr_fee_total= $doctor_visitinfo[$i][1]+$doctor_visitinfo[$i][3]+$doctor_visitinfo[$i][5];
                                                ?>
                                                <td><?php echo $dr_fee_total;?></td>						
                           
					</tr>

						
				
		<?php
		$emergency_visit_fee +=$doctor_visitinfo[$i][1];
	    $e_count +=$doctor_visitinfo[$i][2];
		$ip_visit_fee +=$doctor_visitinfo[$i][3];
		$ip_count +=$doctor_visitinfo[$i][4];
		$ip_billing_fee +=$doctor_visitinfo[$i][5];
		$ip_billing_count +=$doctor_visitinfo[$i][6];
		$total +=$doctor_visitinfo[$i][1]+$doctor_visitinfo[$i][3]+$doctor_visitinfo[$i][5];	
	}
			
			}		
		?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="2" align="right"><b>Total</b></td>
						<td><b><?php echo round($emergency_visit_fee);?></b></td>
						<td><b><?php echo round($e_count);?></b></td>
						<td><b><?php echo round($ip_visit_fee);?></b></td>
						<td><b><?php echo round($ip_count);?></b></td>
						<td><b><?php echo round($ip_billing_fee);?></b></td>
						<td><b><?php echo round($ip_billing_count);?></b></td>
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
	 <input type="hidden" name="page_name" id="doctor_ip_visit_consolidated" value="doctor_ip_visit_consolidated" />

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
