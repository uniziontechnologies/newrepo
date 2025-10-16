<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="../../dist/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
		<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		<!-- jQuery 2.1.4 -->
		<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
		<!-- date-range-picker -->
		<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
		<script>
		$(function () {
		//Date range picker
		$('#from_date').datepicker();
		$('#to_date').datepicker();
		});
		</script>
		<script>
		function submitform(action,id){
		//setAction(action,id);
		document.credit_bill.paction.value=action;
		document.credit_bill.id.value=id;
		if(action =="CLEAR"){
			window.location="../../lib/controllers/centralController.php?module=Billing&sub_module=Credit_Billing";
			return false;
		}
		if(action == "Credit_Payment_Form"){
		document.credit_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Credit_Payment_Form";
		}else{

			if ( document.credit_bill.ref_no.value !="" && document.credit_bill.type.value == ""  ){
				
				$("#type").addClass('error-red');
				alert("Please Select Patient Type (OP/IP/DIRECT) !!");
				return false;
			}

		document.credit_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Credit_Billing";
		}
		document.credit_bill.submit();
		}
		function payAll(){
		var isChecked = false;
		var total=0;var amt=0;
		with (document.credit_bill) {
		for (i in elements) {
		if (elements[i] && elements[i].type == 'checkbox' && elements[i].checked==true) {
		isChecked = true;
							amt=elements[i].value;
		amt=amt.split("#");
		total=total+parseInt(amt[1]);
		}
		}
		}
		if(isChecked!=true)
		{
		alert("Please select atleast one bill");
		return false;
		}else{
		var v=confirm("Do you want to pay selected bills; Total Bill Amount :"+total);
		//var v=confirm("Do you want to pay selected bills");
		if(v==true){
		document.credit_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Multiple_Credit";
		}else{
		return false;
		}
		document.credit_bill.submit();
		}
		}
		</script>
<style type="text/css">
	.error-red{
			border: 2px solid red;
	}
</style>
		
	</head>
	<body id="frame">
		<form name="credit_bill" id="form"  method="post" action="">
			<?php
			$billInfo=$this  ->popArr['billInfo'];
			$post=$this  ->popArr['post'];
			$user=$this  ->popArr['user'];

			?>
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
								<?php echo $lang_bill_no; ?> : </td>
							<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" />
							</td>
						</tr>
						<tr>
							<td id="noborder">
							<?php echo $lang_type; ?></td>
							<td id="noborder" >	
								<select name="type" id="type">
									<option value ="">------</option>
									<option value ="OP" <?php if (!empty($post['type']) && $post['type']=="OP" ) {echo "selected";} ?> >OP</option>
									<option value ="IP" <?php if (!empty($post['type']) && $post['type']=="IP" ) {echo "selected";} ?> >IP</option>
									<option value ="DIRECT" <?php if (!empty($post['type']) && $post['type']=="DIRECT" ) {echo "selected";} ?> >DIRECT</option>
								</select>
							</td>
							<td id="noborder">
							<?php echo $lang_ref_no; ?> </td>
							<td id="noborder" >
								<input type="text" name="ref_no" id="ref_no" value="<?php echo (!empty($post['ref_no']))?$post['ref_no']:''?>" />
							</td>
							<!-- <td id="noborder">
							<?php echo $lang_patient." ".$lang_name;  ?></td>
							<td id="noborder" >	<input type="text" name="patient_name" id="patient_name" value="<?php echo (!empty($post['patient_name']))?$post['patient_name']:''?>" />
							</td> -->
						</tr>
						<tr>
							<td id="noborder" colspan="6" align="center">
								&nbsp;&nbsp;
								<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
								<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<h3 >CREDIT BILLING LIST</h3>
			<?php if(isset($this->popArr['message'])){?>
			<div id='message'><?php echo $this->popArr['message'];?></div>
			<?php } ?>
			<div align="right">
				<?php
				$user_type_logged_in=$_SESSION['user_type'];
				if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
				<a href="#" class="btn btn-warning btn-flat" onClick="payAll();"  class="add">PAY SELECTED BILL</a>
				<?php }?>
			</div><br>
			<div class="box box-info">
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
								<th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
								<th ><a href="#"><?php echo $lang_date; ?></a></th>
								<th ><a href="#"><?php echo $lang_type; ?></a></th>
								<th ><a href="#"><?php echo $lang_ref_no; ?></a></th>
								<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
								<th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
								<!-- <th ><a href="#"><?php //echo $lang_cash; ?></a></th> -->
								<!-- <th ><a href="#"><?php //echo $lang_credit_card; ?></a></th> -->
								<th ><a href="#"><?php echo $lang_balance; ?></a></th>
								<th><a href="#"><?php echo $lang_bill_user;?></a></th>
								<th ><a href="#"><?php echo $lang_action; ?></a></th>
								<?php
								if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
								<th ><a href="#"><?php echo "PAY"; ?></a></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($billInfo)){ //var_dump($billInfo);
							$j=1;
							for($i=0;$i<count($billInfo);$i++) {
							if($billInfo[$i][25] =='' || $billInfo[$i][25] =='0000-00-00'){
							if( ($_SESSION['user_id'] =='105' && ($billInfo[$i][37]=='6' || $billInfo[$i][37]=='7')) || ($_SESSION['user_id'] !='105') ){
							?>
							<tr>
								<td><?php echo $j++;?></td>
								<td><?php echo $billInfo[$i][0];?></td>
								<td><?php echo $billInfo[$i][16];?></td>
								<td><?php echo $billInfo[$i][1];?></td>
								<td><?php echo strtoupper($billInfo[$i][26])."/";echo ($billInfo[$i][1]=="OP")?$billInfo[$i][19]:$billInfo[$i][2]; ?></td>
								<td><?php echo $billInfo[$i][3];?></td>
								<td><?php echo $billInfo[$i][11];?></td>
								<!-- <td><?php //echo $billInfo[$i][41];?></td> -->
								<!-- <td><?php //echo $billInfo[$i][42];?></td> -->
								<td><?php echo $billInfo[$i][14];?></td>
								<td><?php echo $billInfo[$i][57];?></td>
								<?php	if($billInfo[$i][29] == 2 && $billInfo[$i][1] =="IP"){?>
								<td><span class="text-red" ><b>BILL PREPARED</b></span></td>
								<?php }
								elseif ($billInfo[$i][42] =="DISCHARGED" ) {?>
								<td><span class="text-red" ><b>BILL PREPARED</b></span></td>
								<?php
								}
								else{ ?>
								<td>
									<a href="#" class="btn btn-success" onClick="submitform('<?php echo "Credit_Payment_Form";?>','<?php echo $billInfo[$i][0];?>');">PAY NOW</a>
								</td>
								<?php } ?>
								<?php
								if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
								<?php	if($billInfo[$i][29] == 2 && $billInfo[$i][1] =="IP"){?>
								<td><input type="checkbox" disabled  value="<?php echo $billInfo[$i][0]."#".$billInfo[$i][14];?>" name="paybill[]" id="paybill<?php echo $i;?>" title="<?php echo "Bill No: ".$billInfo[$i][0];?>">
								<?php }
								else if($billInfo[$i][42] =="DISCHARGED"){?>
								<td><input type="checkbox" disabled  value="<?php echo $billInfo[$i][0]."#".$billInfo[$i][14];?>" name="paybill[]" id="paybill<?php echo $i;?>" title="<?php echo "Bill No: ".$billInfo[$i][0];?>">
								<?php }
								else{ ?>
								<td><input type="checkbox"   value="<?php echo $billInfo[$i][0]."#".$billInfo[$i][14];?>" name="paybill[]" id="paybill<?php echo $i;?>" title="<?php echo "Bill No: ".$billInfo[$i][0];?>">
								<input type="hidden" value="<?php echo $billInfo[$i][14];?>" name="amount[]" id="amount<?php echo $i;?>" >
							</td>
							<?php
							}
							}?>
						</tr>
						<?php
						}
						}
							}
						}
						?>
					</tbody>
				</table>
			</div>
			</div>
			<input type="hidden" name="id" id="id" />
			<input type="hidden" name="paction" id="paction" />
		</form>
	</body>
</html>