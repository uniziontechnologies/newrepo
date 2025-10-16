<?php	
	$collectionInfo=$this  ->popArr['daily_collection'];
	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];
	$post=$this  ->popArr['post'];
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
		<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		<link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
		<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
		<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
		
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
		<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../../plugins/timepicker/bootstrap-timepicker.js"></script>
		<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>
		<script>
		$(function () {
			
			//Date range picker
		$('#from_date').datepicker();
				$('#to_date').datepicker();
				$(".timepicker").timepicker({showInputs: false,defaultTime: false});
				$('.hide_div').hide();
				
			});
		</script>
		
		
		<script>
			
		function submitform(){
			
			if(document.patients.from_time.value == "" && document.patients.to_time.value != ""){
				
				showDialog('Error','Please Enter From Time.','error',2);
				return false;
				}else if(document.patients.from_time.value != "" && document.patients.to_time.value == ""){
				
				showDialog('Error','Please Enter From Time.','error',2);
				return false;
				}else{
				document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=daily_collection";
				document.patients.submit();
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
			$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Daily Collection Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
				// document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
				// document.patients.submit();			
		}
		</script>
	</head>
	<body id="content">
		<form name="patients" id="form"  method="post" action="">
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
									<td id="noborder"  >
										<input type="text" name="from_date" class="DatePicker" id="from_date" value="<?php echo(empty($post['from_date']))?date('d-m-Y'):date('d-m-Y',strtotime($post['from_date'])) ;?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
									</td>
									
									
									
									<td id="noborder"><?php echo $lang_to_date; ?>:</td>
									<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo(empty($post['to_date']))?date('d-m-Y'):date('d-m-Y',strtotime($post['to_date'])) ;?>" readonly="true"/>
									<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>
								</td>
								
							</tr>
							<tr>
								<td id="noborder">
								<?php echo $lang_user." ".$lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/>
									<option value=''>------------------------------</option>
									
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
								<option value=''>------------------------------</option>
								
								<?php for($i=0;$i<count($user);$i++){
																			
								if(!empty($post['user']) && $post['user']==$user[$i][0]) { ?>
								
								<option value='<?php echo $user[$i][0];?>' selected><?php echo $user[$i][3];?></option>
								<?php   	}else {?>
								
								<option value='<?php echo $user[$i][0];?>'><?php echo $user[$i][3];?></option>
								
								<?php 		}
								} ?>
							</select>
						</td>
						
						
						
						<td id="noborder" colspan="2" align="center">
							&nbsp;&nbsp;
							<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform();"/>
						</td>
					</tr>
					
				</table>
				
			</div>
		</div>
	</div>
	<h4 ><?php echo $lang_daily_collection." ".$lang_report; ?> From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?>
	
	</h4>
	<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
		Report Date : <?php echo date("m-d-Y");;?>
	</div>
	
	<div class="box box-info">
		
		<div class="box-body">
			<table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr>
						<!-- <th colspan="2">
							<h4 class="hide_div"><?php echo $lang_daily_collection." ".$lang_report; ?> <?php if (!empty($post['from_date'])) {
							echo "From ".$post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
							echo "To ".$post['to_date']." ".$post['to_time'];
							}?></h4>
						</th> -->
						<th><a href="#">PARTICULARS</a></th>
       			     	<th><a href="#">CASH PAID</a></th>
       			     	<th><a href="#">CREDIT CARD</a> </th>
       			     	<th><a href="#">UPI</a> </th>
       			     	<th><a href="#">TOTAL AMOUNT</a></th>
					</tr>
					
				</thead>
				
				<tbody>

					<?php
					$cash=0;
					$credit_card=0;
					$upi=0;
					$total=0;

					for($i=0;$i<count($collectionInfo);$i++){ //var_dump($collectionInfo);
					if ($i!=4) { ?>

						<tr>
						<td width="50%"><?php echo $collectionInfo[$i][0];?></td>
						<td><?php echo ($collectionInfo[$i][1] == '') ?0:$collectionInfo[$i][1];?></td>
						<td><?php echo ($collectionInfo[$i][2] == '') ?0:$collectionInfo[$i][2];?></td>
						<td><?php echo ($collectionInfo[$i][4] == '') ?0:$collectionInfo[$i][4];?></td> 
						<td style="font-size: 20px;color: red;"><b><?php echo ($collectionInfo[$i][5] == '') ?0:$collectionInfo[$i][5];?></b></td>


						</tr>


				<?php 
				$cash +=round($collectionInfo[$i][1]);
				  $credit_card +=round($collectionInfo[$i][2]);
				  $upi +=round($collectionInfo[$i][4]);
				   $total +=round($collectionInfo[$i][5]);
			} 
			}?>
					
					<?php for($i=0;$i<count($collectionInfo);$i++){
					if ($i!=4) {?>
					<!-- <tr>
						<td width="50%"><?php echo $collectionInfo[$i][0];?></td>
						<td><?php echo ($collectionInfo[$i][1] == '') ?0:$collectionInfo[$i][1];?></td>
					</tr> -->
					
					<?php
					}
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td align="right"><b>Total</b></td>
						<td><b><?php echo round($cash);?></b></td>
						<td><b><?php echo round($credit_card);?></b></td>
						<td><b><?php echo round($upi);?></b></td>
						<td><b><?php echo round($total);?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
	<div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
</div>

</section>
<input type="hidden" name="id" id="id" />
<input type="hidden" name="action" id="action" />
<input type="hidden" name="page_name" id="daily_collection" value="daily_collection" />
</form>
</body>
</html>