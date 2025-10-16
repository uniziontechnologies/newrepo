<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
date_default_timezone_set('Asia/Kolkata');
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
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
 <script>
      $(function () {
	  
	   //Date range picker
        $('#new_date').datepicker();
		 
	  });
	  </script>

<script>


function add_dr_payment() {

	if (document.billing.amount_paid.value == "") {
		showDialog('Error','Please Enter Amount Paid','error',2);
		return false;
	}
	else if ( Number(document.billing.amount_paid.value) > Number(document.billing.balance.value) ) {
		showDialog('Error','Please Enter Valid Amount','error',2);
		return false;
	}
	else{

		document.billing.add_payment.disabled = true;
		var balance = document.billing.balance.value - document.billing.amount_paid.value;
		document.billing.balance.value = balance;
		document.billing.amount_paid_so_far.value = Number(document.billing.amount_paid_so_far.value)+Number(document.billing.amount_paid.value);

		document.billing.action="../../lib/controllers/centralController.php?module=Registration&sub_module=add_dr_payment";
		document.billing.submit();

	}
	


}
</script>

</head>
<body id="frame" onload="document.billing.particulars.focus();">
 <div  id="content">
<form name="billing" id="form"  method="post" action="" onload="initailize();"> 

<?php

$post=$this->popArr['post'];
// var_dump($post);
?>
  <h4>
            <?php echo "OP DOCTOR PAYMENT"; ?>
           
          </h4>
   
       
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
				
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		
		<div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 				
				
							<tr>
							
								<td id="noborder"><?php echo $lang_doctor; ?> <span id='requiredfield'>*</span> : </td>
								<td id="noborder">
									<input name="doc_name" id="doc_name" tabbindex="2" size="12" value="<?php echo (!empty($post['doc_name']))?$post['doc_name']:''?>" readonly /> 							 
								</td>
							
							<td id="noborder">	<?php echo $lang_date; ?><span id='requiredfield'>*</span> :</td>
							<td id="noborder">								
								 <input type="text" name="visit_date" id="visit_date" size="12" value="<?php echo (!empty($post['visit_date']))?$post['visit_date']:''?>"  readonly /> 	 
							</td>
								
							<td id="noborder">	<?php echo "PAYMENT DATE"; ?><span id='requiredfield'>*</span> :</td>
							<td id="noborder">								
								 <input type="text" name="payment_date" id="payment_date" size="12" value="<?php echo date('Y-m-d');?>"  readonly /> 	 
							</td>
							
							
					</tr>

					</table>
					</div>
			</div>
			<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $lang_sl_no; ?></th>
							<th><?php echo $lang_particulars; ?></th>
							<th><?php echo $lang_amount; ?></th>
							<th><?php echo $lang_discount." ".$lang_type; ?></th>
							<th><?php echo $lang_discount; ?></th>
							<th><?php echo $lang_net_amount; ?></th>
						
							
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($post["items_in_array"])) { 
								$j=1;
								for ($i=0;$i<count($post["items_in_array"]);$i++) {
								
									$items_in_array=explode("!$%",$post["items_in_array"][$i]);
								?>
								
								<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $items_in_array[1]; ?></td>
									<td><?php echo $items_in_array[2]; ?></td>
									<td><?php echo $items_in_array[3]; ?></td>
									<td><?php echo $items_in_array[4]; ?></td>
									<td><?php echo $items_in_array[5]; ?></td>			
									
								</tr>
						
						<?php 	
								}
							} ?>
					
					
					</tbody>
				</table>
				</div>	
			</div>
		 </div>
				
				<div class="col-md-3">
						<div class="box box-info">
                
                           <div class="box-body">
				
					<table  class="table table-striped">	
				
					   <tr>
					   
					   <td id="noborder"><?php echo $lang_total_amount; ?></td>
					<td id="noborder"><input name="doc_fee" id="doc_fee" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,dr_disc)" value="<?php echo (!empty($post['doc_fee']))?$post['doc_fee']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>

					<tr>
					
					<td id="noborder"><?php echo "AMOUNT PAID SO FAR"; ?> </td>
					
					
					<td id="noborder"><input name="amount_paid_so_far" id="amount_paid_so_far" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php if(!empty($post['amount_paid_so_far'])){echo $post['amount_paid_so_far']; }else{echo '0';} ?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					
					<tr>
					
					<td id="noborder"><?php echo $lang_balance; ?> </td>
					
					
					<td id="noborder"><input name="balance" id="balance" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php if(!empty($post['balance'])){echo $post['balance']; } ?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					
					<tr>
					
					<td id="noborder">New <?php echo $lang_amount_paid; ?>	</td>
					
					
					<td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2"  size="12" onkeypress="nextField(event.keyCode,add_payment)" value="" autocomplete="off" /></td>
					
					</tr>
					
						<tr>
						<td id="noborder" colspan="2"><input id="button1" type="button" name="add_payment" class="btn btn-success" value="Add Payment" onclick="add_dr_payment();"/></td>
					
					</tr>
			
				</table>
				</div>	
						
						
			
	</div>
				
 </div>
 </div>
 </section>
 <input type="hidden" name="doc_id" value="<?php echo (!empty($post['doc_id']))?$post['doc_id']:''?>" /> 
 <!-- <input type="hidden" name="paction" value="<?php //echo (!empty($post['paction']))?$post['paction']:''?>" />  -->
   
    
</form>
 </div>
</body>
	</html>
	
