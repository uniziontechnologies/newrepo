<!DOCTYPE html>

<html>
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
	
	<link rel="stylesheet" href="../../dist/css/ajax.css">
	
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />


  </head>
 


<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<script>
	
    $(".hide_row").hide();
   
     function submitForm(type){

     	var confirmation = confirm('Please Confirm By Pressing OK !');

     	if (confirmation==true) {


	 		if (type=="CANCEL_REFER") {
	 			$('#cancel_refer').prop('disabled', true);
	 		}
	 		else if (type=="REFER") {
	 			$('#refer').prop('disabled', true);
	 		}

			document.registration.Register.disabled = true;
			document.registration.paction2.value ="SAVE";
			document.registration.action="../../lib/controllers/centralController.php?module=Registration&sub_module=referal_cases&paction=PROCESS_FORM";
			document.registration.submit();

     	}
     	else{
     		return false;
     	}


	}

	function processForm_doc_ref(type){
		// alert(111);

		if (type != "" && type == "doctor") {

			 $("#bill_disc_type").val('');
			 $("#bill_disc_value").val('');
			 $("#disc_amt").val('');
			 $("#net_total_before_dicount").val('');

		}

		var discount_type=$("#bill_disc_type").val();
		var discount_val=$("#bill_disc_value").val();
		// if(discount_type == ''){
		// 	$("#bill_disc_value").val('');
		// 	$("#disc_amt").val('');
		// 	var net_before_disc=$("#net_total_before_dicount").val();
		// 	$("#ref_balance").val(net_before_disc);

		// }
		
		// alert("process"+disc_amt);


	

		var docid = $("#doctor").val();
		var ref_doc_id = $("#refering_doc_id").val();
		var referal_type = $("#referal_type").val();
		var opno = $("#opno").val();
		var whithout_refer = $("#whithout_refer").val();
		var old_status = $("#old_status").val();
		var old_doctor = $("#old_doctor").val();

		if (whithout_refer=="YES" && old_doctor!="" ) {
			var ref_doc_id = old_doctor;
		}

		var url = "../../lib/controllers/centralController.php?module=Registration&sub_module=referal_cases&paction=DOC_FEE";

			          $.ajax({
			            type: 'POST',
			            url:url,
			            data: {docid:docid,ref_doc_id:ref_doc_id,referal_type:referal_type,opno:opno,whithout_refer:whithout_refer,old_status:old_status,discount_type:discount_type,discount_val:discount_val},
			            success: function (data) {
			            	// alert(data);
			            	var data = data.split(":");

			            	var docfee = data[0];
			            	var regfee = data[1];
			            	var cardfee = data[2];
			            	var ref_balance = data[3];
			            	var disc_amt = data[5];
			            	var ref_balance_before_discount = data[6];
			            	// alert(disc_amt);

			            	$("#docfee").val(docfee);
			            	$("#regfee").val(regfee);
			            	$("#cardfee").val(cardfee);
			            	$("#ref_balance").val(ref_balance);
			            	$("#disc_amt").val(disc_amt);
			            	$("#net_total_before_dicount").val(ref_balance_before_discount);


			            	if ( ref_balance > 0 ) {

			            		$(".hide_row").show();

			            	}
			            	else{
			            		$(".hide_row").hide();
			            	}


			            }
			          });


	}
	function take_referal(){

		var ref_type = $("#ref_type").val();

		if (ref_type!="") {

			$("#referal_type").val('');
			$("#doctor").val('');
			$("#docfee").val('');
			$("#regfee").val('');
			$("#cardfee").val('');
			$("#ref_balance").val('');
			$("#referal_type").val(ref_type);
			$("#bill_disc_value").val('');
			$("#disc_amt").val('');
			$("#net_total_before_dicount").val('');
			$("#payment_mode").val('CASH');

			if (ref_type=="CANCEL_REFER") {
				$("button#cancel_refer").show();
				$("button#refer").hide();
			}
			else if (ref_type=="REFER") {
				$("button#refer").show();
				$("button#cancel_refer").hide();
			}

		}
		else{

			$("#referal_type").val('');
			$("#doctor").val('');
			$("#docfee").val('');
			$("#regfee").val('');
			$("#cardfee").val('');
			$("#ref_balance").val('');
			$("#bill_disc_value").val('');
			$("#disc_amt").val('');
			$("#net_total_before_dicount").val('');
			$("#payment_mode").val('CASH');

			$("button#cancel_refer").hide();
			$("button#refer").hide();

		}

	}
	function disc_type(){
		var discount_type=$("#bill_disc_type").val();
		var discount_val=$("#bill_disc_value").val();
		if(discount_type == ''){
			$("#bill_disc_value").val('');
			$("#disc_amt").val('');
			var net_before_disc=$("#net_total_before_dicount").val();
			$("#ref_balance").val(net_before_disc);

		}
		

	}
// 	
</script>

<div  id="content">
<form name="registration" id="form"  method="post" enctype="multipart/form-data" onload="initailize();"> 

<?php


$action=$this->popArr['action'];
$status = $this->popArr['status'];



$doctors=$this->popArr['doctors'];
$countries=$this->popArr['countries'];
$departments=$this->popArr['departments'];
$patient_category=$this->popArr['patient_category'];
$refInfo=$this->popArr['refInfo'];


if(isset($this->popArr['post'])){
	
	$post=$this->popArr['post'];
	//if(!empty($this->popArr['message'])) $opno_status="active";
	//else $opno_status="hide";
	$inc_company=$this->popArr['insurance_company'];

	$ip_discharge=$post['ip_discharge'];

}else{
	//$opno_status="active";
}

if(!empty($post['opno'])){
	
	$opno_status = "hide";
}else $opno_status = "active";

// var_dump($post);
?>
<section class="content-header">
          <h1>
            <?php echo 'REFER A DOCTOR' ;?>
            <!-- <small>OP Patients</small> -->
	     
          </h1>
	  <?php if($post['id'] != ""){?>
          <ol class="breadcrumb"> 
	                                        <?php						
						if(file_exists("../../templates/registration/patient_photo/".$post['opno']."/photo.jpg")){
						?>
						
						<img src="../../templates/registration/patient_photo/<?php echo $post['opno'];?>/photo.jpg" width="80" height="80">
						<?php
						 }else{						
						?>
						<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
						<?php } ?>
				
           
          </ol><br><br> <br>
  <?php } ?>
        </section>	 
	  
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		
		 <?php if($post['cardfee'] > 0 && $status !='NEW' && $action =="REGISTRATION"){ ?>
		
		                
				<div class="alert alert-warning "><h4><i class="icon fa fa-warning"></i> Alert!</h4>CARD EXPIRED. NEW CARD WILL BE ISSUED WITH THIS REGISTERATION.</div>
		
		   <?php } ?>
		   
		   <?php if($post['total_credit'] > 0 && ( $post['observation_status_op']=="" && $post['observation_status_op']=="NO" ) ){ ?>
		
		                
				<div class="alert alert-warning "><h4><i class="icon fa fa-warning"></i> Alert!</h4>THIS PATIENT HAVE A CREDIT AMOUNT OF Rs/-<?php echo $post['total_credit'];?></div>
		
		   <?php } ?>

		 
		 <div class="box box-info">
                <h4 class="box-title">PATIENT DETAILS</h4>
               <div class="box-body">

			    	<table width="100%" class="table table-striped">
							
			    		<tr>
			    			<td id="noborder">
			    				<?php echo $lang_op_no; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input name="opno" id="opno" type="text" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" style='width: 196px;' readonly >
			    			</td>

			    			<td id="noborder">
			    				<?php echo $lang_name; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input name="patient_name" id="patient_name" tabbindex="2" value="<?php echo $post['first_name'].' '.$post['middle_name'].' '.$post['last_name']  ?>" autocomplete="off" style='width: 196px;' readonly /> 
			    			</td>

							<td id="noborder">
								
										<?php echo $lang_age; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">

										 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,age_type)" value="<?php echo (!empty($post['age']))?$post['age']:''?>" autocomplete="off" style="width: 155px;" readonly /> 
										<select name="age_type" onkeypress="nextField(event.keyCode,dob)" readonly >
											<option value="Y" <?php echo (!empty($post['age_type']) && $post['age_type']=='Y')?'selected':''?>>Y</option>
											<option value="M" <?php echo (!empty($post['age_type']) && $post['age_type']=='M')?'selected':''?>>M</option>
											<option value="D" <?php echo (!empty($post['age_type']) && $post['age_type']=='D')?'selected':''?>>D</option>
										</select> 
							</td>

			    			<td id="noborder">
			    				<?php echo $lang_gender; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
										<select name="gender" onkeypress="nextField(event.keyCode,place)" style='width: 196px;' readonly >
											<option value="">-------------------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
										</select>			    			
							</td>

			    		</tr>

			    		<tr>

			    			<td id="noborder">
			    				<?php echo $lang_place; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input type="text" name="place" id="place"  value="<?php echo (!empty($post['place']))?$post['place']:''?>" style='width: 196px;' readonly /> 
			    			</td>

			    			<td id="noborder">
			    				<?php echo $lang_contact_no; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input name="contact_no" id="contact_no" tabbindex="2" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" style='width: 196px;' readonly /> 
			    			</td>

			    			<td id="noborder">
			    				<?php echo $lang_date; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input name="patient_name" id="patient_name" tabbindex="2" value="<?php echo date('d-m-Y')  ?>" autocomplete="off" style='width: 196px;' readonly /> 
			    			</td>

			    			<td id="noborder">
			    				<?php echo $lang_card_expiry; ?> : &nbsp;
			    			</td>
			    			<td id="noborder">
			    				<input type="text" name="card_expiry" id="card_expiry" value="<?php echo (!empty($post['card_expiry']))?$post['card_expiry']:''?>"  readonly="true" style='width: 196px;' />
			    			</td>


			    		</tr>



					</table>			
		
				</div>			
						
		</div>






		 <div class="box box-info">
                <h4 class="box-title">REFERAL DETAILS</h4>
               <div class="box-body">

			    	<table width="100%" class="table table-striped">
							
			    		<tr>

			    			<td id="noborder">
			    				<?php echo 'REFERED BY'; ?> : &nbsp;<label><?php echo (!empty($refInfo[0][8]))?$refInfo[0][8]:''?></label>
			    			</td>


			    			<td id="noborder">
			    				<?php echo 'REFERED TO'; ?> : &nbsp;<label style="color: green;font-size: 16px;"><?php echo (!empty($refInfo[0][9]))?$refInfo[0][9]:''?></label> 
			    			</td>

			    			<td id="noborder">
			    				<?php echo 'REFERAL TYPE'; ?> : &nbsp;<?php if ( !empty($refInfo[0][10]) && $refInfo[0][10]=="CANCEL_REFER"  ) {?>
			    					<label>CANCEL THIS OP & REFER</label>
			    				<?php
			    				}
			    				else if( !empty($refInfo[0][10]) && $refInfo[0][10]=="REFER" ){?>
			    					<label>REFER WITHOUT CANCEL</label>
			    				<?php
			    				}
			    				?> 
			    			</td>


			    			
			    		</tr>

			    		<tr>

			    			<td id="noborder" style="padding-top: 20px;">
			    				<?php echo 'REMARKS'; ?> : &nbsp;<label><?php echo (!empty($refInfo[0][5]))?$refInfo[0][5]:''?></label>

			    				
			    			</td>

			    			
			    		</tr>




					</table>			
		
				</div>			
						
		</div>






		 <div class="box box-info">
                <h4 class="box-title">FEE DETAILS</h4>
               <div class="box-body">

			    	<table width="100%" class="table table-striped">
							
			    		<tr>


			    	<?php

			    		if ($post['whithout_refer']=="YES") {?>

			    			<td id="noborder">
			    				<?php echo 'Refer Type'; ?> : &nbsp;
			    			</td>

			    			<td id="noborder">
									<select name="ref_type" id="ref_type" style="width: 210px;" onchange="take_referal();" /> 		
										<option value=''>------------------------------</option>
										<option value='CANCEL_REFER' <?php if ( !empty($post['referal_type']) && $post['referal_type']=="CANCEL_REFER" ) {echo "selected";} ?> >CANCEL THIS OP & REFER</option>
										<option value='REFER' <?php if ( !empty($post['referal_type']) && $post['referal_type']=="REFER" ) {echo "selected";} ?> >REFER WITHOUT CANCEL</option>	
									</select>
			    			</td>



			    		<?php
			    		}


			    	 ?>




			    			<td id="noborder">
			    				<?php echo $lang_doctor; ?> : &nbsp;
			    			</td>

			    			<td id="noborder">
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="processForm_doc_ref('doctor');" /> 		
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

							<td id="noborder">							
								<?php echo $lang_dr." ".$lang_fees; ?> :<input name="docfee" id="docfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['docfee']))?$post['docfee']:'0'?>" autocomplete="off" size="2" readonly="true"/> 	
								
							</td>
							<td id="noborder">
								<?php echo $lang_reg_fee; ?> :
								<input name="regfee" id="regfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['regfee']))?$post['regfee']:'0'?>" autocomplete="off" size="3" readonly="true"/> 
							</td>
							<td id="noborder">
                                 <?php echo $lang_card_fee; ?> :
								<input name="cardfee" id="cardfee" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['cardfee']))?$post['cardfee']:'0'?>" autocomplete="off" size="2" readonly="true"/> 			
															
							</td>

							<!-- <td id="noborder">
							    <?php echo $lang_payment_mode; ?> :
								<select name="payment_mode" id="payment_mode">
                                    <option value="CASH">CASH </option>
                                    <option value="CREDIT CARD">CREDIT CARD </option>
                                    <option value="UPI">UPI</option>
                                    	
                                   
								</select> 			
															
							</td>
 -->

			    			
			    		</tr>
			    		<tr>
			    			<td colspan="9"><br></td>
			    			<td colspan="9"><br></td>
			    		</tr>
			    		
			    		<tr class="hide_row " style="display: none;">
			    			
			    				<td id="noborder" colspan="4" align="right">
                                 <?php echo $lang_discount; ?> :</td>
			    		<td >
			    			 <select name="bill_disc_type" id="bill_disc_type" onchange="disc_type();" >
                                      <option value="" >-----------------</option>
                                      <option value="CASH" <?php echo ($discount_type == 'CASH')?'selected' :'';?>>CASH</option>
                                      <option value="%" <?php echo ($discount_type == '%')?'selected' :'';?>>%</option>
                                 </select>&nbsp;</td>
                                 <td>
                  <input type="text" name="bill_disc_value" value="<?php echo $discount_value;?>" id="bill_disc_value"  autocomplete="off" size="13" onkeypress="if(event.keyCode== 13){return processForm_doc_ref('discount');}" onblur="return processForm_doc_ref('discount');" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"/>&nbsp;</td>
                  <td>
							     <input type="text" name="disc_amt" value="<?php echo $discount_amt;?>" id="disc_amt" autocomplete="off" readonly="1" size="13"  />	
			    		</td>
			    		</tr>
			    		<tr class="hide_row" style="display: none;">
			    			<td colspan="4" align="right">
			    				NET TOTAL BEFORE DISCOUNT:
			    			</td>
			    				<td colspan="5">
			    		<input name="net_total_before_dicount" id="net_total_before_dicount" tabbindex="2" value="<?php echo (!empty($post['ref_balance_before_discount']))?$post['ref_balance_before_discount']:'0';?>" autocomplete="off" size="43" readonly style="font-size: 20px;font-weight: 700;text-align: center;" />
			    	</td>
			    	</tr>

			     <tr>
						<td colspan="5" align="right"><?php echo $lang_payment_mode; ?>:</td>
						<td colspan="4">
						
								
									<select name="payment_mode" id="payment_mode" onkeypress="if(event.keyCode==13){ processForm()};" onchange="processForm();">						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
						
						</select>
					</td>
					</tr>

			    		
					</table>

				<?php if( (!empty($post['ref_balance']) || $post['ref_balance']==0) ) { ?>


						

				<div class="col-md-12" style="margin-top: 50px;font-size: 17px;color: orangered;margin-bottom: 20px;font-weight: 700;padding-left: 0px ;padding-right: 120px;" align="right">

					
							
					<?php echo "<b>NET AMOUNT TO BE COLLECTED</b>"; ?> : <input name="ref_balance" id="ref_balance" tabbindex="2" value="<?php echo (!empty($post['ref_balance']))?$post['ref_balance']:'0';?>" autocomplete="off" size="18" readonly style="font-size: 25px;font-weight: 700;text-align: center;" />

				</div>

				
				<?php } ?>

		
				</div>			
						
		</div>

		<div class="col-md-offset-9 col-md-2">
			
			<?php

				if ( ($refInfo[0][10]=="CANCEL_REFER") && ($post['whithout_refer']=="NO") ) {?>

					<button class="btn btn-danger" name="Register"  onclick="return submitForm('CANCEL_REFER')">Cancel & Refer</button>

				<?php
				}
				else if ( ($refInfo[0][10]=="REFER") && ($post['whithout_refer']=="NO") ) {?>

					<button class="btn btn-danger" name="Register"  onclick="return submitForm('REFER')">Refer</button>

				<?php
				}
				else if($post['whithout_refer']=="YES"){?>

					<button class="btn btn-danger" id="cancel_refer" name="Register"  onclick="return submitForm('CANCEL_REFER')" style="display: none;" >Cancel & Refer</button>

					<button class="btn btn-danger" id="refer" name="Register"  onclick="return submitForm('REFER')" style="display: none;" >Refer</button>

				<?php
				}


			 ?>


		</div>



</div>
				
 </div>
 <input name="paction" id="paction" type="hidden" value="<?php echo(!empty($post['revisit']))?'REGISTRATION':$action  ;?>" /> 
 <input name="paction2" id="paction2" type="hidden" value="" /> 
 <input name="status" id="status" type="hidden" value="<?php echo $status;?>" /> 
  <input name="paid" id="paid" type="hidden" value="Paid" /> 
  <input name="validity_days" id="validity_days" type="hidden" value="<?php echo (!empty($post['validity_days']))?$post['validity_days']:'0'?>"  />          
   <input name="id" id="id" type="hidden" value="<?php echo (!empty($post['id']))?$post['id']:''?>" />
   <input name="card_issued" id="card_issued" type="hidden" value="<?php echo (!empty($post['card_issued']))?$post['card_issued']:''?>" />
    <input name="total_credit" id="total_credit" type="hidden" value="<?php echo (!empty($post['total_credit']))?$post['total_credit']:''?>" />
      <input type="hidden" name="upload_status" id="upload_status">
   <input type="hidden" name="ip_discharge" id="ip_discharge" value="<?php echo $ip_discharge;?>">
   <!-- <input type="hidden" name="activate_precentage" id="activate_precentage" value="<?php echo (!empty($post['activate_precentage']))?$post['activate_precentage']:''?>"> -->
   <input type="hidden" name="doctor_perc" id="doctor_perc" value="<?php echo (!empty($post['doctor_perc']))?$post['doctor_perc']:''?>">
   <input type="hidden" name="hospital_perc" id="hospital_perc" value="<?php echo (!empty($post['hospital_perc']))?$post['hospital_perc']:''?>">
    <input type="hidden" name="status_select" id="status_select" value="<?php echo (!empty($post['status_select']))?$post['status_select']:''?>">
     <input type="hidden" name="refering_doc_id" id="refering_doc_id" value="<?php echo (!empty($refInfo[0][3]))?$refInfo[0][3]:''?>">
     <input type="hidden" name="refered_doc_id" id="refered_doc_id" value="<?php echo (!empty($refInfo[0][4]))?$refInfo[0][4]:''?>">
    <input type="hidden" name="referal_type" id="referal_type" value="<?php echo (!empty($refInfo[0][10]))?$refInfo[0][10]:''?>">
    <input type="hidden" name="whithout_refer" id="whithout_refer" value="<?php echo (!empty($post['whithout_refer']))?$post['whithout_refer']:''?>">
    <input type="hidden" name="ref_id" id="ref_id" value="<?php echo (!empty($post['ref_id']))?$post['ref_id']:''?>">
    <input type="hidden" name="old_status" id="old_status" value="<?php echo (!empty($post['old_status']))?$post['old_status']:''?>">
     <input type="hidden" name="regfee_old" id="regfee_old" value="<?php echo (!empty($post['regfee_old']))?$post['regfee_old']:''?>">
      <input type="hidden" name="cardfee_old" id="cardfee_old" value="<?php echo (!empty($post['cardfee_old']))?$post['cardfee_old']:''?>">
      <input type="hidden" name="old_doctor" id="old_doctor" value="<?php echo (!empty($post['old_doctor']))?$post['old_doctor']:''?>">
                </div><!-- /.box-body -->
		</div>

        </section><!-- /.content -->

 </div >
	
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>	
  <!-- Bootstrap 3.3.5 -->
 
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
<script type="text/javascript" src="../../dist/js/common.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

	 <script>
	 	      $(function () {
	  
	   //Date range picker
        $('#dob').datepicker();
		//$('#card_expiry').datepicker();
		 $('#date_issue').datepicker();
		  $('#date_expiry').datepicker();

		  $("#bill_disc_type").change(function(){
		  	var discount_type=$("#bill_disc_type").val();
		  	$('#bill_disc_value').focus();
		  	

		  	// alert(discount_type);
		  });
		  
		 //  $("#bill_disc_value").keydown(function (e) {
			//   if (e.keyCode == 13) {
			//   	var discount_type=$("#bill_disc_type").val();
			//   	var discount_val=$("#bill_disc_value").val();

			//   	var net_amt=$('#ref_balance').val();
			//   	if(discount_type == 'CASH' && net_amt!=0){
			//   		if(discount_val == ''){
			//   			discount_val=0;
			//   		}
			//   		var net_amt_after_discount= net_amt - discount_val;
			//   		$('#disc_amt').val(discount_val);
			//   		$('#ref_balance').val(net_amt_after_discount);


			//   	}
			    
			//   }
			// });
    	
		
	  });
	  </script>
