<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
 date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	 <!-- jQuery 2.1.4 -->
   <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js"></script>

	<link rel="stylesheet" href="../../dist/css/ajax.css">
   <script type="text/javascript" src="../../ajax/ajax.js"></script>
   <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   
   <link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
   <script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
   
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#date').datepicker();
		
	  });
	  </script>

<script>

function myfunction(){

	  	

}

function processForm(action,loc,removetestid){

	document.billing.removeitemid.value=removetestid;
	document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Bill_Form&action="+action+"&loc="+loc;
	document.billing.submit();
}
function ProcessBilling(){


	  		status = 0;
        	$(".quantity").each(function() {
        	var element = $(this);
           		   if (element.val() == "0" || element.val() == "" ) {
				       
				   		status = 1;
				   
				   }
         });


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
		}else if(document.billing.gender.value == ''){
		
			showDialog('Error','Please Enter Gender.','error',2);
			return false;
		}else if(document.billing.contact_no.value == ''){
		
			showDialog('Error','Please Enter Mob No.','error',2);
			return false;
		}
	}
	if(document.billing.email_status.value == 'YES'){
	
	if((type == "DIRECT" || type == "OP" || type == "IP") && (document.billing.user_type.value == 'LAB ADMIN' || document.billing.user_type.value == 'LAB USER') && document.billing.email.value != ''){
		var str=document.billing.email.value;
			// alert(email);return false;
			var emailvalid=looksLikeMail(str);
			// alert(emailvalid);
			if(emailvalid == false){
				showDialog('Error','Please Enter a valid Email ID.','error',2);
				return false;

			}

	}
}
// }
	
	if(status=="1"){
		showDialog('Error','Please Enter Qty.','error',2);
			return false;
	}
	else if(document.billing.payment_mode.value =="CASH" && document.billing.amount_paid.value != document.billing.net_amount.value){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && document.billing.card_amount.value == '' ){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && (Number(document.billing.card_amount.value)+Number(document.billing.amount_paid.value)) != document.billing.net_amount.value ){
	
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="UPI" && (document.billing.upi_amount.value == '' || document.billing.upi_amount.value == '0' ) ){
		showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="UPI" && (Number(document.billing.upi_amount.value)+Number(document.billing.amount_paid.value)) != document.billing.net_amount.value ){
	
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}
	// else if((type == "DIRECT" || type == "OP") && document.billing.payment_mode.value =="CREDIT"){
	// 	$("#button1").attr("disabled", true);
	//     tb_show('User Authentication',"../../lib/controllers/centralController.php?module=Billing&sub_module=credit_bill_authentication&bill_id=0&from=bill");
	// }
	else{
		$("#button1").attr("disabled", true);
	showDialog('Success','Added Successfully.','success',5);
	document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Billing";
	document.billing.submit();
	}
	
	
}

function change_bill_item_amount(itemid,pos){
	     
	      tb_show('BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=change_item_amount_form&itemid="+itemid+"&pos="+pos);
	}
function update_bill(bill_id){


	if(document.billing.payment_mode.value =="CASH" && document.billing.amount_paid.value != document.billing.net_amount.value){
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && document.billing.card_amount.value == '' ){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="CREDIT CARD" && ( Number(document.billing.card_amount.value) + Number(document.billing.amount_paid.value) ) != Number(document.billing.net_amount.value) ){
	
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="UPI" && (document.billing.upi_amount.value == '' || document.billing.upi_amount.value == '0' ) ){
		showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
	}else if(document.billing.payment_mode.value =="UPI" && (Number(document.billing.upi_amount.value)+Number(document.billing.amount_paid.value)) != document.billing.net_amount.value ){
	
		showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
	}else{

		document.billing.billid.value=bill_id;
		     
		document.billing.action="../../lib/controllers/centralController.php?module=Billing&sub_module=updateBill";
		document.billing.submit();


	}



	      
	}
	function looksLikeMail(str) {
    var lastAtPos = str.lastIndexOf('@');
    var lastDotPos = str.lastIndexOf('.');
    return (lastAtPos < lastDotPos && lastAtPos > 0 && str.indexOf('@@') == -1 && lastDotPos > 2 && (str.length - lastDotPos) > 2);
}
</script>

</head>
<body id="frame" onload="document.billing.particulars.focus();">
 <div  id="content">
<form name="billing" id="form"  method="post" action="" onload="initailize();"> 

<?php
$config_obj=new Config_hims();
 
$post=$this->popArr['post'];
$doctors=$this->popArr['doctors'];
$doctorsDirect=$this->popArr['doctorsDirect'];
// $patientInfo=$this->popArr['patientInfo'];

	// procedure  ==> 1	
	// x-ray      ==> 2

// var_dump($post);


	if (!empty($post['items_in_array'][0]) && $_SESSION['user_type']=="RECEPTION") {
		
		$items_in_first = explode("!$%",$post["items_in_array"][0]);

		if ($items_in_first[7]==2) {

			$bill_type="XRAY";

			echo "<input type='hidden' name='bill_type' id='bill_type' value='2' />";
		}
		else if ($items_in_first[7]!=2) {

			$bill_type="PROCEDURE";

			echo "<input type='hidden' name='bill_type' id='bill_type' value='1' />";
		}


	}
	else{

		$bill_type="ALL";

		echo "<input type='hidden' name='bill_type' id='bill_type' value='' />";
	}


?>

          <h4>
            <?php echo $post['type']." ".$lang_billing; ?>
           
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
<?php //var_dump($post['patient_cat_id'],$post['patient_cat_name']); ?>			    
<?php if(!empty($post['patient_cat_id'])>0)  
         { 
?>
                <tr>
                    <td>PATIENT CATEGORY</td>
                    <td>
                        <input type="text" name="patient_category" id="patient_category" value="<?php echo $post['patient_cat_name']; ?>" readonly >
                    </td>
                </tr> 
<?php    } ?>
							<tr>
							
								<td id="noborder"><?php echo $lang_name; ?> <span id='requiredfield'>*</span> </td>
								<td id="noborder">
								
									<input name="name" id="name" size="12" tabbindex="2"  onkeypress="nextField(event.keyCode,place)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" autocomplete="off" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/> 							 
							</td>
							
							<td id="noborder">	<?php echo $lang_place; ?><span id='requiredfield'>*</span> </td>
							<td id="noborder">								
								 <input type="text" name="place" id="place"  size="12" onkeypress="nextField(event.keyCode,age)" value="<?php echo (!empty($post['place']))?$post['place']:''?>"  <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/> 	 
							</td>
								
							<td id="noborder"><?php echo $lang_age; ?> <span id='requiredfield'>*</span> </td>
								
							<td id="noborder">
								
								 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,gender)" value="<?php echo (!empty($post['age']))?$post['age']:''?>" autocomplete="off" size="2" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/>

								 <?php if($post['type'] == "DIRECT"
								) { ?>

								 	<select name="age_type" onkeypress="nextField(event.keyCode,dob)">

											<option value="Y" <?php echo (!empty($post['age_type']) && $post['age_type']=='Y')?'selected':''?>>Y</option>
											<option value="M" <?php echo (!empty($post['age_type']) && $post['age_type']=='M')?'selected':''?>>M</option>
											<option value="D" <?php echo (!empty($post['age_type']) && $post['age_type']=='D')?'selected':''?>>D</option>
										</select> 

								 <?php }?>
										 
								<?php echo $lang_gender; ?> <span id='requiredfield'>*</span>
									
										<select name="gender" onkeypress="nextField(event.keyCode,contact_no)" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>>
											<option value="">------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='O')?'selected':''?> value="O">Other</option>
										</select>
								 
							</td>
							
							
					</tr>
					<tr>
					
														
						<?php if($post['type'] == "DIRECT") { ?>
						
								<td id="noborder"><?php echo $lang_contact_no; ?> </td>			
							
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" size="12" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/> 
								 
							</td>
							
							
								<td id="noborder"><?php echo $lang_refferal_info; ?> </td>
								<td id="noborder">
								<input name="refferal_info" id="refferal_info" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,date)" value="<?php echo (!empty($post['refferal_info']))?$post['refferal_info']:''?>" autocomplete="off"  /> 
								<!-- <input type="hidden" id="refferal_info_hidden" name="refferal_info_ID" value="<?php echo (!empty($post['refferal_info_ID']))?$post['refferal_info_ID']:''?>">								  -->
								</td>
								
						<?php	}else { ?>
						
						<td id="noborder"><?php echo $lang_contact_no; ?> </td>			
							
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2"  size="12"onkeypress="nextField(event.keyCode,doctor)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/> 
								 
							</td>
						<td id="noborder"><?php echo $lang_doctor; ?>	</td>
								<td id="noborder">
								<input name="doctor" id="doctor" tabbindex="2"  onkeypress="nextField(event.keyCode,date)" value="<?php echo (!empty($post['doctor']))?$post['doctor']:''?>" autocomplete="off" <?php echo (!empty($post['type']) && $post['type']=='OP')?'readonly':''?>/> 								 
								</td>
						<?php  } ?>
						
						<td id="noborder"><?php echo $lang_date; ?> </td>
						<td id="noborder" ><input type="text" name="date" id="date" size="12" value="<?php echo (!empty($post['date'])) ?$post['date']:date("d-m-Y");?>" autocomplete="off"   class="DatePicker"  readonly="true"/></td>
			 
					</tr>
					<?php if ($config_obj->email_status=="YES") {
						 ?>
					<tr>
						<?php if($_SESSION['user_type'] == "LAB ADMIN" || $_SESSION['user_type'] == "LAB USER"){?>
							<td >
								<?php echo "EMAIL ID"; ?> 
							</td>
							<td>
								
								 <input name="email" id="email" type="email" tabbindex="2"  size="22" value="<?php echo (!empty($post['email']))?$post['email']:''?>" autocomplete="off"/> 
								 
							</td>



						<?php }?>


							<?php 

								if ($post['type'] == "DIRECT") {?>

									<td id="noborder"><?php echo "DOCTOR"; ?> </td>

									<td id="noborder">
										
										 <input name="doctor_direct" id="doctor_direct" tabbindex="2"  size="12"onkeypress="nextField(event.keyCode,doctor)" value="<?php echo (!empty($post['doctor_direct']))?$post['doctor_direct']:''?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getDoctors',event)"; />


										<input type="hidden" id="doctor_direct_hidden" name="doctor_direct_ID" value="<?php echo (!empty($post['doctor_direct_ID']))?$post['doctor_direct_ID']:''?>">

										 
									</td>

								<?php
								}

							?>

							<td colspan="3"></td>

					</tr>
				<?php }?>
					</table>
				</div>
			</div>
			
			   
					<div align="center"><?php echo $lang_particulars;?>&nbsp;:&nbsp;
					
					
					<?php if($_SESSION['user_type'] == "SUPER NURSE" && $post['type'] == "IP"){?>
					      <input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('AP','')};" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'getTheatreProcedure',event)" >
					 
					<?php }else if($_SESSION['user_type'] == "RECEPTION"){

							if ($bill_type=="ALL") {?>
								
								<input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('AP','')};" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'getBillParticularsReceptionAll',event)" >

							<?php
							}
							else if ($bill_type=="XRAY") {?>

								<input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('AP','')};" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'getBillParticularsReceptionXray',event)" >


							<?php
							}
							else if ($bill_type=="PROCEDURE") {?>


								<input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('AP','')};" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'getBillParticularsReceptionProcedure',event)" >


						<?php
							}

						}

						 else{ ?>
									<input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('AP','')};" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'getBillParticulars',event)" >
					 
					<?php  } ?>
					 <input type="hidden" id="particulars_hidden" name="particulars_ID" >
					 
					 </div>
					 <br>
			<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $lang_sl_no; ?></th>
							<th><?php echo $lang_particulars; ?></th>
							<th><?php echo $lang_qty; ?></th>
							<th><?php echo $lang_amount; ?></th>
							<th><?php echo $lang_discount." ".$lang_type; ?></th>
							<th><?php echo $lang_discount; ?></th>
							<th><?php echo $lang_net_amount; ?></th>
						   <th><?php echo $lang_doctor; ?></th>
							<th><?php echo $lang_remove; ?></th>
							
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($post["items_in_array"])) { 
								$j=1;
								for ($i=0;$i<count($post["items_in_array"]);$i++) {
								
									$items_in_array=explode("!$%",$post["items_in_array"][$i]);

									// var_dump($items_in_array);

								?>
								
								<tr>
									<td><?php echo $j++;?></td>
									<td><input type="text" name="items[<?php echo $i; ?>][1]" value="<?php echo $items_in_array[1]; ?>" /></td>

									<td><input type="text" name="items[<?php echo $i; ?>][13]" value="<?php echo $items_in_array[13]; ?>" size="5" onkeypress="javascript: if(event.keyCode == 13){processForm('QTY','<?php echo $i; ?>','')}" onblur="processForm('QTY','<?php echo $i; ?>','')" class="quantity" /></td>

									<td><input type="text" id="<?php echo $i; ?>2" name="items[<?php echo $i; ?>][2]" value="<?php echo $items_in_array[2]; ?>" size="5" readonly />
									   <?php if($items_in_array[12]=="NO"){?>
									   	<br>
									   <a href="#" onclick="change_bill_item_amount('<?php echo $items_in_array[0];?>','<?php echo $i; ?>')">Change</a>
									  <?php } ?>
									</td>
									<td><select name="items[<?php echo $i; ?>][3]" onchange="processForm('DISC','<?php echo $i; ?>','')">
									
											<option value="">----------</option>
											<option value="CASH" <?php echo (!empty($items_in_array[3]) && $items_in_array[3]=='CASH')?'selected':''?>>CASH</option>
											<option value="%" <?php echo (!empty($items_in_array[3]) && $items_in_array[3]=='%')?'selected':''?>>%</option>	
																			
										</select></td>
									<td><input type="text" name="items[<?php echo $i; ?>][4]" value="<?php echo $items_in_array[4]; ?>" size="5" onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('DISC','','')};"/></td>
									<td><input type="text" name="items[<?php echo $i; ?>][5]" value="<?php echo $items_in_array[5]; ?>" size="5" readonly /></td>
									
									<td>
								<?php
								  if(($items_in_array[10] > 0 || $items_in_array[11] >0)  && !empty($doctors)){?>
								  
								       <select name="items[<?php echo $i; ?>][9]" id="doctor" style="width: 100%;"/> 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($items_in_array[9]) && $items_in_array[9]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][9]" value="<?php echo $items_in_array[9]; ?>" />
								<?php } ?>
								</td>
								<?php if($items_in_array[6] !=="C"){ ?>
								
								<td> <a href="#"  onclick="processForm('RM','<?php echo $i; ?>','<?php echo $items_in_array[0]; ?>')">Remove</a>
								
								<?php }else { ?>
									<td></td>
								<?php } ?>
									
									<input type="hidden" name="items[<?php echo $i; ?>][0]" value="<?php echo $items_in_array[0]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][6]" value="<?php echo $items_in_array[6]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][7]" value="<?php echo $items_in_array[7]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][8]" value="<?php echo $items_in_array[8]; ?>" />
									
									<input type="hidden" name="items[<?php echo $i; ?>][10]" value="<?php echo $items_in_array[10]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][11]" value="<?php echo $items_in_array[11]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][12]" value="<?php echo $items_in_array[12]; ?>" />
									<!--<input type="hidden" name="items[<?php echo $i; ?>][12]" value="<?php echo $items_in_array[12]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][13]" value="<?php echo $items_in_array[13]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][14]" value="<?php echo $items_in_array[14]; ?>" />-->

									<input type="hidden" name="items[<?php echo $i; ?>][14]" value="<?php echo $items_in_array[14]; ?>" />
									<input type="hidden" name="items[<?php echo $i; ?>][15]" value="<?php echo $items_in_array[15]; ?>" />
									
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
					   
					   <td id="noborder"><?php echo $lang_total_amount; ?> </td>
					<td id="noborder"><input name="total_amount" id="total_amount" size="12" tabbindex="2"  onkeypress="nextField(event.keyCode,dr_disc)" value="<?php echo (!empty($post['total_amount']))?$post['total_amount']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_dr_disc; ?> (%)</td>
					<td id="noborder"><input name="dr_disc" id="dr_disc" tabbindex="2"  size="12" value="<?php echo (!empty($post['dr_disc']))?$post['dr_disc']:''?>" autocomplete="off"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ processForm('DRDISC','','')};" onblur="processForm('DRDISC','','');"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_net_amount; ?> </td>
					<td id="noborder"><input name="net_amount" id="net_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,payment_mode)" value="<?php echo (!empty($post['net_amount']))?$post['net_amount']:''?>" autocomplete="off" readonly="true"/></td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_payment_mode; ?> </td>
					<td id="noborder">

<?php

                    $login_user_type=$_SESSION['user_type'];

                    if($login_user_type == "RECEPTION"){

?>
					
						<select name="payment_mode" id="payment_mode" onkeypress="if(event.keyCode==13){ processForm('PM','')};" onchange="processForm('PM');"  >
						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							<option value="CREDIT" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT')?'selected':''?>>CREDIT</option>
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
							<?php if(!empty($post['ins_id']) && $post['ins_id']>0) { ?>
							<option value="INSURANCE" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='INSURANCE')?'selected':''?>>INSURANCE</option>
							<?php } ?>
						</select>
					<?php }else{?>
						<select name="payment_mode" id="payment_mode" onkeypress="if(event.keyCode==13){ processForm('PM','')};" onchange="processForm('PM');"  >
							<option value="CREDIT" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT')?'selected':''?>>CREDIT</option>
						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
							<?php if(!empty($post['ins_id']) && $post['ins_id']>0) { ?>
							<option value="INSURANCE" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='INSURANCE')?'selected':''?>>INSURANCE</option>
						<?php }?>
					</select>
					<?php }?>
					</td>
					
					</tr>
					<tr>
					
					<td id="noborder"><?php echo $lang_amount_paid; ?> </td>
					<td id="noborder"><input name="amount_paid" id="amount_paid" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php if(!empty($post['payment_mode']) && $post['payment_mode']=='CASH'){echo $post['net_amount'];} ?>" autocomplete="off"/></td>
					
					</tr>
				<?php
					if(!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD'){?>
					<tr>
					
					<td id="noborder"><?php echo $lang_card_amount; ?> </td>
					<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<?php } ?>
					<?php
					if($post['payment_mode']=='UPI'){?>
					<tr>
					
					<td id="noborder"><?php echo $lang_upi_amount; ?> </td>
					<td id="noborder"><input name="upi_amount" id="upi_amount" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['upi_amount']))?$post['upi_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					<?php } ?>
				<?php if(!empty($post['payment_mode']) && $post['payment_mode'] == 'INSURANCE'){ ?>
				
					<tr>
					
					<td id="noborder"><?php echo $lang_ins_deduction; ?> </td>
					<td id="noborder"><input name="ins_deduction" id="ins_deduction" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['ins_deduction']))?$post['ins_deduction']:''?>" autocomplete="off"/></td>
					
					</tr>
				<?php } ?>
					
					
					<?php 
						if($post['paction'] == "ADD") { ?>
						
					<tr>
					
					<td id="noborder"><?php echo $lang_remarks; ?> 	</td>
					<td id="noborder"><input name="remarks" id="remarks" tabbindex="2" size="12" onkeypress="nextField(event.keyCode,Save)" value="<?php echo (!empty($post['remarks']))?$post['remarks']:''?>" autocomplete="off"/></td>
					</tr>
					
						<tr>
						<td id="noborder" colspan="2"><input id="button1" type="button" class="btn btn-success" name="Save" value="Save" onclick="ProcessBilling();"/></td>
					<?php } ?>
					<?php 
						if($post['paction'] == "UPDATE") { ?>
						
						<tr>
					
					<td id="noborder"><?php echo $lang_remarks; ?> 	</td>
					<td id="noborder"><input name="remarks" id="remarks" tabbindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo (!empty($post['remarks']))?$post['remarks']:''?>" autocomplete="off"/></td>
					</tr>
					
						<tr>
						<td id="noborder" colspan="2" align="center"><input id="button1" type="button" class="btn btn-success" name="Update" value="Update" onclick="ProcessBilling();"/></td>
					<?php } ?>
					<?php 
						if($post['paction'] == "EDIT_BILL") { ?>
						

					
						<tr>
						<td id="noborder" colspan="2" align="center"><input id="button1" type="button" class="btn btn-success" name="Edit" value="Update Bill" onclick="update_bill('<?php echo $post['id']; ?>');"/></td>
					<?php } ?>
					</tr>
			
				</table>
				</div>	
						
						
			
	</div>
	</div>
</div>	

 
 <input type="hidden" name="type" value="<?php echo (!empty($post['type']))?$post['type']:''?>" /> 
 <input type="hidden" name="id" value="<?php echo (!empty($post['id']))?$post['id']:''?>" /> 
 <input type="hidden" name="paction" value="<?php echo (!empty($post['paction']))?$post['paction']:''?>" /> 
 <input type="hidden" name="billid" value="<?php echo (!empty($post['billid']))?$post['billid']:''?>" />
 <input type="hidden" name="ins_id" value="<?php echo (!empty($post['ins_id']))?$post['ins_id']:'0'?>" /> 
 <input type="hidden" name="patient_cat_id" value="<?php echo (!empty($post['patient_cat_id']))?$post['patient_cat_id']:'0'?>" />
 <input type="hidden" name="observation_show" value="<?php echo (!empty($post['observation_show']))?$post['observation_show']:''?>" />
<input type="hidden" name="auth_user_id" id="auth_user_id" value="">
<input type="hidden" name="auth_sanc_by" id="auth_sanc_by" value="">
<input type="hidden" name="auth_remarks" id="auth_remarks" value="">
<input type="hidden" name="doc_id_prescribed" value="<?php echo (!empty($post['doc_id_prescribed']))?$post['doc_id_prescribed']:''?>" />
<?php
$ip_labtest_pres_id_list='';
if(!empty($ip_labtest_pres_id_list)){

   $ip_labtest_pres_id_list=$post['ip_labtest_pres_id_list'];
    
   

        for ($l=0; $l <count($ip_labtest_pres_id_list); $l++) { 
        	
?>
        
    <input type="hidden" name="ip_labtest_pres_id[<?php echo $l; ?>][0]" id="ip_labtest_pres_id['<?php echo $l; ?>'][0]" value="<?php echo $ip_labtest_pres_id_list[$l][0]; ?>">
    <input type="hidden" name="ip_labtest_pres_id[<?php echo $l; ?>][1]" id="ip_labtest_pres_id[<?php echo $l; ?>][1]" value="<?php echo $ip_labtest_pres_id_list[$l][1]; ?>">

<?php
       }

   }

?>
<input type="hidden" name="removeitemid" id="removeitemid" value=""> 
<input type="hidden" name="user_type" id="user_type" value="<?php echo $_SESSION['user_type'];?>">  
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $_SESSION['user_type_id'];?>">  
<input type="hidden" name="email_status" id="email_status" value="<?php echo (!empty($config_obj->email_status))?$config_obj->email_status:''?>">  
</form>
</div>
</body>
	</html>
	
