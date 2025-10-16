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

<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#dod').datepicker();
		
	  });
	  </script>
	 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>	
<script>

$(document).ready(function() {           
           
          
            
             $("#credit_card").hide();
             $("#cheque").hide();
            
            $( ".ipbill" ).blur(function() {
            
               
                $("#paction").val("json");              
               
		var data= $("#form").serialize();
		inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
			
		   $.post(inline_action,data,function (response) {
		   
		       total_amount=response['total_amount'];
		       $("#total_amount").val(total_amount);
		        $("#balance").val(response['balance']);
		   },"json");;
                
            });
            $('.ipbill').bind('keypress', function(e) {
	            if(e.keyCode==13){
		       $("#paction").val("json");              
               
		var data= $("#form").serialize();
		inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
			
		   $.post(inline_action,data,function (response) {
		   
		       total_amount=response['total_amount'];
		       $("#total_amount").val(total_amount);
		        $("#balance").val(response['balance']);
		   },"json");;
	           }
            });
            
            $( "#disc_type" ).change(function() {
            
               $("#paction").val("json");              
               
		var data= $("#form").serialize();
		inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
			
		   $.post(inline_action,data,function (response) {
		   
		       total_amount=response['total_amount'];
		       $("#total_amount").val(total_amount);
		       $("#balance").val(response['balance']);
		   },"json");;
            });
            
            $( "#payment_mode" ).change(function() {
            
                payment_mode= $("#payment_mode").val();
                
                if(payment_mode == "CREDIT CARD"){
                
                   $("#credit_card").show();
                    $("#cheque").hide();
                }else if(payment_mode == "CHEQUE"){
                
                    $("#cheque").show();
                     $("#credit_card").hide();
                }else{
                  
                   $("#credit_card").hide();
                   $("#cheque").hide();
                
                }
            });
            
            
             $( "#save" ).click(function() {
             
                payment_mode= $("#payment_mode").val();
                
                if((payment_mode =="CASH" || payment_mode ==CHEQUE) && $("#final_amount").val() == ""){
                
                    showDialog('Error','Please Enter Amount.','error',2);
			return false;
                
                }else if(payment_mode =="CREDIT CARD"  && $("#card_amount").val() == ""){
                
                   showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
                }else if(payment_mode =="CHEQUE"  && $("#cheque_no").val() == ""){
                
                   showDialog('Error','Please Enter Cheque Number.','error',2);
			return false;
                }else{
                
                
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Final_Payment");
                  $("#form").submit();
                
                }
             
             });
			
});
/*function processForm(){

	
	document.advance_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
	document.advance_payment.submit();
}*/
function finalpayment(){


     if((document.advance_payment.payment_mode.value =="CASH" || document.advance_payment.payment_mode.value =="CHEQUE") && document.advance_payment.advance_amount.value =="" ){
		showDialog('Error','Please Enter Amount.','error',2);
			return false;
	}else if(document.advance_payment.payment_mode.value =="CREDIT CARD" && document.advance_payment.card_amount.value =="" ){
		showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
	}else if(document.advance_payment.payment_mode.value =="CHEQUE" && document.advance_payment.cheque_no.value=="" ){
	
		showDialog('Error','Please Enter Cheque Number.','error',2);
			return false;
	}
	showDialog('Success','Added Successfully.','success',5);
	
	document.advance_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Add_Advance_Payment";
	document.advance_payment.submit();
	return true;

}

</script>
<body id="frame" onload="document.billing.particulars.focus();">
<form name="final_payment" id="form"  method="post" action="" > 

<?php
$patientInfo=$this ->popArr['patient_info'];
$itemInfo=$this ->popArr['procedure_items'];
$theatre_procedure=$this ->popArr['theatre_procedure'];
$post=$this->popArr['post'];
?>
<div id="content">

 
<section class="content">
					 
	<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

					<tr>
							
					   <td id="noborder"><?php echo $lang_name; ?> : <input type="text" name="pname" value="<?php echo $patientInfo[0][1].' '.$patientInfo[0][2].' '.$patientInfo[0][3];?>" readonly/></td>
					   <td id="noborder"><?php echo $lang_ip_no; ?> : <input type="text" name="id" value="<?php echo $patientInfo[0][13];?>" readonly/></td>
					   <td id="noborder"><?php echo $lang_room_no; ?> : <input type="text" name="roomno" value="<?php echo $patientInfo[0][37];?>" readonly/></td>
					</tr>
					<tr>
					   <td id="noborder"> <?php echo $lang_doa; ?>: <input type="text" name="doa"  size="12" value="<?php echo $patientInfo[0][20];?>" onkeypress="nextField(event.keyCode,dod)" readonly/></td>
					  <td id="noborder"> <?php echo $lang_dod; ?>: <input type="text" name="dod"   value="<?php echo (!empty($post['dod']))?$post['dod']:''?>" id="dod"   onkeypress="nextField(event.keyCode,from_date)" readonly/></td>
					 </tr>
			       </table>
			         </div>
			</div>
			       <h4><?php echo $lang_final_payment;?></h4>
		<div class="row">
                   <div class="col-md-6">
				
		     <div class="box box-info">
                
                         <div class="box-body">
			        <table class="table table-bordered table-striped">
				
				<?php $i=13;?>
				      <tr>
				      
				           <td id="noborder"><?php echo $lang_admission_fee;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_admission_fee;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="admission_fee" class="ipbill" tabbindex="2"  value="<?php echo (!empty($post['admission_fee']))?$post['admission_fee']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,'item[1]')" /></td>
				       </tr>
				
				       <tr>
				           <td id="noborder"><?php echo $lang_surgery_charges ;?>: </td>
				           <td id="noborder"></td>
				       </tr>
					    <tr>
				           <td id="noborder" align="right"><?php echo $lang_hosp_amount;?>:<input type="hidden" name="particulars[0]" value="<?php echo $lang_hosp_amount;?>"></td>
				           <td id="noborder"><input name="item[0]" id="surgeon_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($theatre_procedure[0][1]))?$theatre_procedure[0][1]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_surgeon_fee;?>:<input type="hidden" name="particulars[1]" value="<?php echo $lang_surgeon_fee;?>"></td>
				           <td id="noborder"><input name="item[1]" id="surgeon_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($theatre_procedure[0][2]))?$theatre_procedure[0][2]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_anaesthesia_fee;?>:<input type="hidden" name="particulars[2]" value="<?php echo $lang_anaesthesia_fee;?>"></td>
				           <td id="noborder"><input name="item[2]" id="anaesthesia_fee" tabbindex="2" class="ipbill"  value="<?php echo (!empty($theatre_procedure[0][3]))?$theatre_procedure[0][3]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_theatre_charges;?>:<input type="hidden" name="particulars[3]" value="<?php echo $lang_theatre_charges;?>"></td>
				           <td id="noborder"><input name="item[3]" id="theatre_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($theatre_procedure[0][4]))?$theatre_procedure[0][4]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
					   <tr>
				           <td id="noborder" align="right"><?php echo $lang_other_charges;?>:<input type="hidden" name="particulars[4]" value="<?php echo $lang_other_charges;?>"></td>
				           <td id="noborder"><input name="item[4]" id="other_charges" tabbindex="2"class="ipbill"value="<?php echo (!empty($theatre_procedure[0][5]))?$theatre_procedure[0][5]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				
                          <tr>
				           <td id="noborder"><?php echo $lang_medicine_charges;?><input type="hidden" name="particulars[5]" value="<?php echo $lang_medicine_charges;?>"></td>
				           <td id="noborder"><input name="item[5]" id="medicine_charges"  tabbindex="2"class="ipbill"value="<?php echo (!empty($post['medicine_charges']))?$post['medicine_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>	
                       <tr>
				           <td id="noborder"><?php echo $lang_special_cons;?><input type="hidden" name="particulars[6]" value="<?php echo $lang_special_cons;?>"></td>
				           <td id="noborder"><input name="item[6]" id="special_cons" tabbindex="2" class="ipbill"  value="<?php echo (!empty($post['doc_visit_amt']))?$post['doc_visit_amt']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				     
				       <tr>
				           <td id="noborder"><?php echo $lang_xray_charges;?><input type="hidden" name="particulars[7]" value="<?php echo $lang_xray_charges;?>"></td>
				           <td id="noborder"><input name="item[7]" id="xray_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($post['xray_charges']))?$post['xray_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_laboratory_charges;?><input type="hidden" name="particulars[8]" value="<?php echo $lang_laboratory_charges;?>"></td>
				           <td id="noborder"><input name="item[8]" id="lab" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['lab']))?$post['lab']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_room_rent;?><input type="hidden" name="particulars[9]" value="<?php echo $lang_room_rent;?>"></td>
				           
				           <td id="noborder"><input name="item[9]" id="room_rent" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['room_rent']))?$post['room_rent']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_nursing_charges;?><input type="hidden" name="particulars[10]" value="<?php echo $lang_nursing_charges;?>"></td>
				           
				           <td id="noborder"><input name="item[10]" id="nursing_charges" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['nursing_charges']))?$post['nursing_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
				           </td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_maintenance;?><input type="hidden" name="particulars[11]" value="<?php echo $lang_maintenance;?>"></td>
				           
				           <td id="noborder"><input name="item[11]" id="maintenance" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['maintenance']))?$post['maintenance']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
				           </td>
				       </tr>
                       <tr>
				           <td id="noborder"><?php echo $lang_nursing_procedures;?><input type="hidden" name="particulars[12]" value="<?php echo $lang_nursing_procedures;?>"></td>
				           <td id="noborder"><input name="item[12]" id="nursing_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($post['nurse_added_procedures']))?$post['nurse_added_procedures']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"  /></td>
				       </tr>					   
				       <tr>
				           <td id="noborder"><?php echo $lang_delivery_fee;?></td>
				           <td id="noborder"></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo$lang_gynaecologist_fee;;?>:<input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_gynaecologist_fee;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="gynaecologist_fee"  class="ipbill" tabbindex="2"  value="<?php echo (!empty($post['gynaecologist_fee']))?$post['gynaecologist_fee']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_labour_charges;?>:<input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_labour_charges;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="labour_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($post['labour_charges']))?$post['labour_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
				       <tr>
				       
				       
				           <td id="noborder"><?php echo $lang_icu_charge;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_icu_charge;?>"></td>
				           
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="icu_charge" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['icu_charge']))?$post['icu_charge']:''?>" autocomplete="off" onkeypress="if(event.keyCode==13){ processForm()};" onblur="processForm"/></td>
				       </tr>
				      
				       <tr>
				           <td id="noborder"><?php echo $lang_candd_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_candd_charges;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="candd_charges" tabbindex="2"  class="ipbill" value="<?php echo (!empty($post['candd_charges']))?$post['candd_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_suturing_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_suturing_charges;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="suturing_charges" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['suturing_charges']))?$post['suturing_charges']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_medico_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_medico_charges;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="medico" tabbindex="2"  class="ipbill" value="<?php echo (!empty($post['medico']))?$post['medico']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
                          <tr>
				           <td id="noborder"><?php echo $lang_birth_reg_fee;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_birth_reg_fee;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="birth_reg_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($post['birth_reg_fee']))?$post['birth_reg_fee']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_ryes_tube;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_ryes_tube;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="ryes_tube" tabbindex="2" class="ipbill" value="<?php echo (!empty($post['ryes_tube']))?$post['ryes_tube']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_warmer;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_warmer;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i++;?>]" id="warmer" tabbindex="2"  class="ipbill" value="<?php echo (!empty($post['warmer']))?$post['warmer']:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				       </tr>            
				       <?php
				             $m=$i;
				           if(!empty($itemInfo)){ 
				           
				              for($i=0;$i<count($itemInfo);$i++){
				           
				           ?>
				           
				           <tr>
				           <td id="noborder"><?php echo $itemInfo[$i][2];?><input type="hidden" name="particulars[<?php echo $m;?>]" value="<?php echo $itemInfo[$i][2];?>"></td>
				           <td id="noborder"><input name="item[<?php echo $m++;?>]" id="$items[]" tabbindex="2"  value="<?php echo $itemInfo[$i][0]?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" readonly/></td>
				       </tr>
				           
				           
				        <?php }
				        
				        
				         } ?>
				        <tr>
				           <td id="noborder" colspan="2"><hr width="100%"></td>
				         </tr>
				</table>
			  </div>
			</div>
		    </div>
			<div class="col-md-6">
				
		     <div class="box box-info">
                
                         <div class="box-body">
			        <table class="table table-bordered table-striped">
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_total_amount;?></b>:</td>
				           <td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2"  value="<?php echo (!empty($post['total_bill_amount']))?$post['total_bill_amount']:''?>" autocomplete="off" readonly/>
				           <input type="hidden" name="actual_bill" id="actual_bill" value="<?php echo (!empty($post['total_bill_amount']))?$post['total_bill_amount']:''?>">
				           
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_amount_paid;?> SO FAR </b>:</td>
				           
				           <td id="noborder" ><b><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($post['paid_amount']))?$post['paid_amount']:''?>" autocomplete="off" readonly/></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_discount?></b>:</td>
				           
				           
				           <td id="noborder" >
				                  <select name="disc_type" id="disc_type">
				                       <option value="CASH">CASH</option>
				                       <option value="%">%</option>
				                  </select>
				                  
				                       <input name="discount" id="discount" tabbindex="2"  class="ipbill" size="10" value="<?php echo (!empty($post['discount']))?$post['discount']:''?>" autocomplete="off" />
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_balance;?></b>:</td>
				           <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($post['balance']))?$post['balance']:''?>" autocomplete="off" readonly/>
				            <input type="hidden" name="actual_balance" id="actual_balance" value="<?php echo (!empty($post['balance']))?$post['balance']:''?>">
				           
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_payment_mode; ?> </b>:	</td>
				           
					   <td id="noborder">
					
						<select name="payment_mode" id="payment_mode" >						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							<option value="CREDIT" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT')?'selected':''?>>CREDIT</option>
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="CHEQUE" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CHEQUE')?'selected':''?>>CHEQUE</option>
							
							
						</select>
					    </td>
				       </tr>
				       <tr >
			        
					 <td id="noborder" align="right"><b><?php echo $lang_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="final_amount" id="final_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['final_amount']))?$post['final_amount']:''?>" autocomplete="off"/></td>
				      
				      </tr>
				      
				      
					
					
					<tr id="credit_card">
					
					<td id="noborder" align="right"><b><?php echo $lang_card_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					
					
					
					<tr id="cheque">
					
					
					
					<td id="noborder" align="right"><b><?php echo $lang_checque_no; ?> <span id='requiredfield'>*</span></b>:	</td>
					
			
					<td id="noborder"><input name="cheque_no" id="cheque_no" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/>
					</td>
					
					
					</tr>
					
				      
				      <tr>
					
					<td id="noborder" align="right"><b><?php echo $lang_remarks; ?> </b>:	</td>
					<td id="noborder"><textarea cols="18" rows="3" name="remarks"><?php echo (!empty($post['remarks']))?$post['remarks']:''?></textarea></td>
				     </tr>
				     <tr>
					<td id="noborder" colspan="2" align="center"><input id="save" type="button" name="Save" class="btn btn-success" value="Save" class="save"/></td>
				     </tr>
				 </table>						
                	 
                	   </div>
                       </div>
             </div>
</div>

</section>
<input type="hidden" name="paction" id="paction" value="">
               
