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

<script>

function processForm(){

	
	document.advance_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Advance_Payment_Form";
	document.advance_payment.submit();
}
function advancepayment(){


     if((document.advance_payment.payment_mode.value =="CASH" || document.advance_payment.payment_mode.value =="CHEQUE") && document.advance_payment.advance_amount.value =="" ){
		showDialog('Error','Please Enter Amount.','error',2);
			return false;
	}else if(document.advance_payment.payment_mode.value =="CREDIT CARD" && document.advance_payment.card_amount.value =="" ){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}else if(document.advance_payment.payment_mode.value =="CHEQUE" && document.advance_payment.cheque_no.value=="" ){
	
		showDialog('Error','Please Enter Cheque Number.','error',2);
			return false;
	}else if(document.advance_payment.payment_mode.value =="UPI" && (document.advance_payment.upi_amount.value =="" || document.advance_payment.upi_amount.value =="0" ) ){
		showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
	}
	showDialog('Success','Added Successfully.','success',5);
	
	document.advance_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Advance_Payment";
	document.advance_payment.submit();
	return true;

}

</script>
<body id="frame" onload="document.billing.particulars.focus();">
<form name="advance_payment" id="form"  method="post" action="" > 

<?php
$patientInfo=$this ->popArr['patient_info'];
$post=$this->popArr['post'];
// var_dump($post);
?>
<div id="content">
<section class="content-header">
          <h4><?php echo $lang_inpatient." ".$lang_information; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

					<tr>
							
					   <td id="noborder"><?php echo $lang_name; ?> : <input type="text" name="pname" value="<?php echo $patientInfo[0][1].' '.$patientInfo[0][2].' '.$patientInfo[0][3];?>" readonly/></td>
					   <td id="noborder"><?php echo $lang_ip_no; ?> : <input type="text" name="id" value="<?php echo $patientInfo[0][13];?>" readonly/></td>
					   <td id="noborder"><?php echo $lang_room_no; ?> : <input type="text" name="roomno" value="<?php echo $patientInfo[0][37];?>" readonly/></td>
					 </tr>
			       </table>
			  </div>
			</div>
			       <h3 ><?php echo $lang_advance_payment;?></h3>
			     <div class="row">
                   <div class="col-md-6">
				
				<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
				      <tr>
				           <td id="noborder"><?php echo $lang_total_amount;?></td>
				           <td id="noborder"><input name="total_amount" id=" total_amount" tabbindex="2"  value="<?php echo (!empty($post['total_bill_amount']))?$post['total_bill_amount']:''?>" autocomplete="off"/></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_amount_paid ;?></td>
				          <!--  <td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($post['paid_amount']))?$post['paid_amount']:''?>" autocomplete="off" readonly/></td> -->
				           <td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($post['advance_paid']))?$post['advance_paid']:''?>" autocomplete="off" readonly/></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_balance;?></td>
				           <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($post['balance']))?$post['balance']:''?>" autocomplete="off"/></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_payment_mode; ?> :	</td>
				           
					   <td id="noborder">
					
						<select name="payment_mode" id="payment_mode" onkeypress="if(event.keyCode==13){ processForm()};" onchange="processForm();">						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
							<!-- <option value="CHEQUE" <?php //echo (!empty($post['payment_mode']) && $post['payment_mode']=='CHEQUE')?'selected':''?>>CHEQUE</option> -->
							
						</select>
					    </td>
				       </tr>
				       <tr>
			        
					 <td id="noborder"><?php echo $lang_amount; ?> <span id='requiredfield'>*</span>:	</td>
					<td id="noborder"><input name="advance_amount" id="advance_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['advance_amount']))?$post['advance_amount']:''?>" autocomplete="off"/></td>
				      
				      </tr>
				      
					<?php
					if($post['payment_mode']=='CREDIT CARD'){?>
					<tr>
					
					<td id="noborder"><?php echo $lang_card_amount; ?> <span id='requiredfield'>*</span>:	</td>
					<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<?php } ?>
					<?php
					if($post['payment_mode']=='UPI'){?>
					<tr>
					
					<td id="noborder"><?php echo $lang_upi_amount; ?> <span id='requiredfield'>*</span>:	</td>
					<td id="noborder"><input name="upi_amount" id="upi_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['upi_amount']))?$post['upi_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<?php } ?>
					<?php
					if($post['payment_mode']=='CHEQUE'){?>
					<tr>
					
					
					<td id="noborder"><?php echo $lang_checque_no; ?> <span id='requiredfield'>*</span>:	</td>
					<td id="noborder"><input name="cheque_no" id="cheque_no" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<?php } ?>
				      </tr>
				      <tr>
					
					<td id="noborder"><?php echo $lang_remarks; ?> :	</td>
					<td id="noborder"><textarea cols="18" rows="3"><?php echo (!empty($post['remarks']))?$post['remarks']:''?></textarea></td>
				     </tr>
				     <tr>
					<td id="noborder" colspan="2" align="center"><input id="button1" type="button" class="btn btn-success" name="Save" value="Save" onclick="advancepayment();"/></td>
				     </tr>
				 </table>						
                	 
                	   </div>
                       </div>
           </div>
                       </div>
</section>
    </div>           