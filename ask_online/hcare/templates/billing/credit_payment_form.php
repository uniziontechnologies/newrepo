<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
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
        $("#card_amount_row").hide();
        $("#upi_amount_row").hide();
		 
		 
	  });
	  </script>

<script>

function processForm(action,loc){

	
	document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Bill_Form&action="+action+"&loc="+loc;
	document.billing.submit();
}
function ProcessCredit(balance){

    if( document.billing.payment_mode.value =="CASH" && document.billing.amount_paid.value==""){
		showDialog('Error','Please Enter Amount.','error',2);
			return false;
	}
    else if( document.billing.payment_mode.value =="CREDIT CARD" && document.billing.card_amount.value==""){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}
	else if( document.billing.payment_mode.value =="CASH" && Number(document.billing.amount_paid.value) > Number(document.billing.balance.value) ){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if( document.billing.payment_mode.value =="CREDIT CARD" && (Number(document.billing.amount_paid.value)+Number(document.billing.card_amount.value)) > Number(document.billing.balance.value) ){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if( document.billing.payment_mode.value =="UPI" && ( document.billing.upi_amount.value=="" || document.billing.upi_amount.value=="0")){
		showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
	}else if( document.billing.payment_mode.value =="UPI" && (Number(document.billing.amount_paid.value)+Number(document.billing.upi_amount.value)) > Number(document.billing.balance.value) ){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else{
		showDialog('Success','Added Successfully.','success',5);
	   document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Credit";
	   document.billing.submit();
	}
	 

}
function ProcessBilling(){

	type=document.billing.type.value;
	
	if(type == "DIRECT"){
		
		if(document.billing.name.value == ''){
		
			showDialog('Error','Please Enter Name.','error',2);
			return false;
		}else if(document.billing.place.value == ''){
		
			showDialog('Error','Please Enter Place.','error',2);
			return false;
		}else if(document.billing.age.value == ''){
		
			showDialog('Error','Please Enter Age.','error',2);
			return false;
		}if(document.billing.gender.value == ''){
		
			showDialog('Error','Please Enter Gender.','error',2);
			return false;
		}
	}
	
	if(document.billing.payment_mode.value =="CASH" && document.billing.amount_paid.value <document.billing.net_amount.value){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && document.billing.card_amount.value == '' ){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && (document.billing.card_amount.value+document.billing.amount_paid.value) <document.billing.net_amount.value ){
	alert(document.billing.card_amount.value+document.billing.amount_paid.value);
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}
	showDialog('Success','Added Successfully.','success',5);
	document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Billing";
	document.billing.submit();
}

function show_fields() {
	
	var payment_mode = $("#payment_mode").val();

	// $("#card_amount").val('');
	// $("#amount_paid").val('');

	if (payment_mode=="CREDIT CARD") {
		$("#card_amount_row").show();
		$("#upi_amount_row").hide();
		$("#upi_amount").val('');
	}else if (payment_mode=="UPI") {
		$("#upi_amount_row").show();
		$("#card_amount_row").hide();
		$("#card_amount").val('');
	}else{
		$("#card_amount_row").hide();
		$("#upi_amount_row").hide();
		$("#card_amount").val('');
		$("#upi_amount").val('');
	}

}


</script>

</head>
<body id="frame" onload="document.billing.particulars.focus();">
 <div  id="content">
<form name="billing" id="form"  method="post" action="" onload="initailize();"> 

<?php

$post=$this->popArr['post'];
?>
  <h4>
            <?php echo "CREDIT".$lang_billing; ?>
           
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
							
								<td id="noborder"><?php echo $lang_name; ?> <span id='requiredfield'>*</span> : </td>
								<td id="noborder">
								
									<input name="name" id="name" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,place)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" autocomplete="off" readonly /> 							 
							</td>
							
							<td id="noborder">	<?php echo $lang_place; ?><span id='requiredfield'>*</span> :</td>
							<td id="noborder">								
								 <input type="text" name="place" id="place" size="12"  onkeypress="nextField(event.keyCode,age)" value="<?php echo (!empty($post['place']))?$post['place']:''?>"  readonly /> 	 
							</td>
								
							<td id="noborder"><?php echo $lang_age; ?> <span id='requiredfield'>*</span> :	</td>
								
							<td id="noborder">
								
								 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,gender)" value="<?php echo (!empty($post['age']))?$post['age']:''?>" autocomplete="off" size="2" readonly/>
										 
								<?php echo $lang_gender; ?> <span id='requiredfield'>*</span> :
									
										<select name="gender" onkeypress="nextField(event.keyCode,contact_no)" readonly >
											<option value="">------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='O')?'selected':''?> value="O">Other</option>
										</select>
								 
							</td>
							
							
					</tr>
					<tr>
					
														
						<?php if($post['type'] == "DIRECT") { ?>
						
								<td id="noborder"><?php echo $lang_contact_no; ?>  :</td>			
							
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off" readonly/> 
								 
							</td>
							
							
								<td id="noborder"><?php echo $lang_refferal_info; ?> :	</td>
								<td id="noborder">
								<input name="refferal_info" id="refferal_info" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,date)" value="<?php echo (!empty($post['refferal_info']))?$post['refferal_info']:''?>" autocomplete="off" readonly/> 								 
								</td>
								
						<?php	}else { ?>
						
						<td id="noborder"><?php echo $lang_contact_no; ?>  :</td>			
							
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,doctor)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off" readonly/> 
								 
							</td>
						<td id="noborder"><?php echo $lang_doctor; ?> :	</td>
								<td id="noborder">
								<input name="doctor" id="doctor" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,date)" value="<?php echo (!empty($post['doctor']))?$post['doctor']:''?>" autocomplete="off" readonly/> 								 
								</td>
						<?php  } ?>
						
						<td id="noborder">Bill <?php echo $lang_date; ?> </td>
						<td id="noborder" ><input type="text" name="date" id="date" size="12" value="<?php echo (!empty($post['date'])) ?$post['date']:date("d-m-Y");?>" autocomplete="off"    readonly="true" /></td>
								
								 
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
					<td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,dr_disc)" value="<?php echo (!empty($post['total_amount']))?$post['total_amount']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_dr_disc; ?></td>
					<td id="noborder"><input name="dr_disc" id="dr_disc" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,net_amount)" value="<?php echo (!empty($post['dr_disc']))?$post['dr_disc']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_net_amount; ?>	</td>
					<td id="noborder"><input name="net_amount" id="net_amount" size="12" tabbindex="2"  onkeypress="nextField(event.keyCode,payment_mode)" value="<?php echo (!empty($post['net_amount']))?$post['net_amount']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_payment_mode; ?>	</td>
					<!-- <td id="noborder"> <?php echo $post['payment_mode']; ?></td> -->
					<td>

						<select name="payment_mode" id="payment_mode" onchange="show_fields();">
						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
						</select>

					</td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_balance; ?> </td>
					
					
					<td id="noborder"><input name="balance" id="balance" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['balance']))?$post['balance']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>

<!-- 					<tr>
					
						<td id="noborder"><?php //echo $lang_amount_paid; ?> </td>
						<td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php //echo (!empty($post['amount_paid']))?$post['amount_paid']:''?>" autocomplete="off"/></td>
					
					</tr> -->




				<tr>
						<td id="noborder"><?php echo $lang_from_date; ?></td>
							<td id="noborder" >	
											<input type="text" name="new_date" id="new_date"  size="12" class="DatePicker" value="<?php echo date('d-m-Y');?>" readonly="true"/>
										</td>
					</tr>
					
					<tr>
					
					<td id="noborder"><?php echo $lang_amount_paid; ?>	</td>
					
					
					<td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2"  size="12" onkeypress="nextField(event.keyCode,add_credit)" value="" autocomplete="off" /></td>
					
					</tr>

					<tr id="card_amount_row">
					
						<td id="noborder"><?php echo $lang_card_amount; ?> </td>
						<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<tr id="upi_amount_row">
					
						<td id="noborder"><?php echo $lang_upi_amount; ?> </td>
						<td id="noborder"><input name="upi_amount" id="upi_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['upi_amount']))?$post['upi_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					
						<tr>
						<td id="noborder" colspan="2"><input id="button1" type="button" name="add_credit" class="btn btn-success" value="Add Credit" onclick="ProcessCredit(<?php echo $post['balance']; ?>);"/></td>
					
					</tr>
			
				</table>
				</div>	
						
						
			
	</div>
				
 </div>
 </div>
 </section>
 <input type="hidden" name="balance1" value="<?php echo (!empty($post['balance']))?$post['balance']:''?>" /> 

 <input type="hidden" name="type" value="<?php echo (!empty($post['type']))?$post['type']:''?>" /> 
 <input type="hidden" name="id" value="<?php echo (!empty($post['id']))?$post['id']:''?>" /> 
 <input type="hidden" name="action" value="<?php echo (!empty($post['action']))?$post['action']:''?>" /> 
 <input type="hidden" name="billid" value="<?php echo (!empty($post['billid']))?$post['billid']:''?>" />
 <input type="hidden" name="ins_id" value="<?php echo (!empty($post['ins_id']))?$post['ins_id']:'0'?>" /> 
   
    
</form>
 </div>
</body>
	</html>
	
