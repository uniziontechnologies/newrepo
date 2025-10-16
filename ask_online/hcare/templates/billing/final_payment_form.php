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
	
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />

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
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
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
             $(".cheque").hide();
              $("#upi").hide();
            
  //           $( ".ipbill" ).blur(function() {
            
               
  //               $("#paction").val("json");              
               
		// var data= $("#form").serialize();
		// inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
			
		//    $.post(inline_action,data,function (response) {
		   
		//        total_amount=response['total_amount'];
		//        $("#total_amount").val(total_amount);
		//         $("#balance").val(response['balance']);
		//    },"json");;
                
  //           });
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
                
                   // $("#credit_card").show();
                   //  $(".cheque").hide();
                	$("#credit_card").show();
					$("#upi").hide();
                    $(".cheque").hide();
					$("#upi_amount").val('');
					$("#cheque_amount").val('');
					$("#cheque_no").val('');
                }else if(payment_mode == "UPI"){
                    $("#upi").show();
                    $("#credit_card").hide();
                    $(".cheque").hide();
					$("#card_amount").val('');
					$("#cheque_amount").val('');
					$("#cheque_no").val('');
                }else if(payment_mode == "CHEQUE"){
                
                    // $(".cheque").show();
                    //  $("#credit_card").hide();

                	$(".cheque").show();
					$("#upi").hide();
                     $("#credit_card").hide();
					 $("#card_amount").val('');
					$("#upi_amount").val('');
                }else{
                  
                   // $("#credit_card").hide();
                   // $(".cheque").hide();

                	 $("#upi").hide();
                   $("#credit_card").hide();
                   $(".cheque").hide();
				   $("#card_amount").val('');
				   $("#upi_amount").val('');
				   $("#cheque_amount").val('');
					$("#cheque_no").val('');
                
                }
            });
            
            
             $( "#save" ).click(function() {
             
                payment_mode= $("#payment_mode").val();
				card_paid=Number($("#card_amount").val())+Number($("#final_amount").val());
				cheque_paid=Number($("#cheque_amount").val())+Number($("#final_amount").val());
				upi_paid=Number($("#upi_amount").val())+Number($("#final_amount").val());
				
                
				 // if(payment_mode =="CREDIT"){
				 //   tb_show('Authenticate',"../../lib/controllers/centralController.php?module=Billing&sub_module=credit_bill_authentication&bill_id="+$("#billid").val()+"&from=final_payments");
				   
				 // }
				 if((payment_mode =="CASH") && ($("#final_amount").val() != $("#balance").val())){
                
                    showDialog('Error','Please Enter Full Amount.','error',2);
			      return false;
                
                }else if(payment_mode =="CREDIT CARD"  && ((isNaN(card_paid)) || card_paid != $("#balance").val())){
                //	alert(card_paid);
                   showDialog('Error','Please Enter Full Amount.','error',2);
			       return false;
                }else if((payment_mode =="UPI") && ($("#upi_amount").val() == '' || $("#upi_amount").val() == '0')){
                
                    showDialog('Error','Please Enter UPI Amount.','error',2);
			      return false;

			       }else if(payment_mode =="CHEQUE"  && ((isNaN(cheque_paid)) || cheque_paid != $("#balance").val())){
                
                   showDialog('Error','Please Enter Full Amount.','error',2);
			       return false;
                }else if(payment_mode =="CHEQUE"  && $("#cheque_no").val() == ""){
                
                   showDialog('Error','Please Enter Cheque Number.','error',2);
			       return false;
                }else if(payment_mode =="UPI"  && ((isNaN(upi_paid)) || upi_paid != $("#balance").val())){
                //	alert(card_paid);
                   showDialog('Error','Please Enter Full Amount.','error',2);
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
$billInfo=$this ->popArr['billInfo'];
$post=$this->popArr['post'];
//ip discount
 $ip_discount=$this ->popArr['ip_discount'];
 if($ip_discount && $ip_discount['discount_type']=='CASH'){
 	$billInfo[0][8]-=$ip_discount['discount_value'];
 } 
 else if($ip_discount && $ip_discount['discount_type']=='%'){
 	$billInfo[0][8]-=($billInfo[0][8]*$ip_discount['discount_value']/100);
 } 
?>
<div id="content">

 
<section class="content">
					 
	<div class="box box-info">
                
               <div class="box-body">
			    <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_ip_no; ?> : <?php echo strtoupper($patientInfo[0][13]);?>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_name; ?> : <?php echo strtoupper(strtolower(($patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3])));?>
                    </div>
                    <div class="col-xs-5">
					 <?php echo $lang_room_no; ?> : <?php echo $patientInfo[0][37];?>
                   
                    </div>
                  </div>
				   <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_doa; ?> : <?php echo strtoupper($patientInfo[0][20]);?>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_dod; ?> : <input type="text" name="dod"   value="<?php echo (!empty($post['dod']))?$post['dod']:''?>" id="dod"   onkeypress="nextField(event.keyCode,from_date)" readonly size="20"/>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div>
				
			         </div>
			</div>
			       <h4><?php echo $lang_final_payment;?></h4>
		<div class="row">aa
                
			<div class="col-md-6">
				
		     <div class="box box-info">
                
                         <div class="box-body">
			        <table class="table table-bordered table-striped">
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_total_amount;?></b>:</td>
				           <td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2"  value="<?php echo (!empty($billInfo))?$billInfo[0][4]:''?>" autocomplete="off" readonly/>
				         
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_amount_paid;?> SO FAR </b>:</td>
				           
				           <td id="noborder" ><b><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($billInfo))?$billInfo[0][5]:''?>" autocomplete="off" readonly/></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_discount?></b>:</td>
				           
				           
				           <td id="noborder" >
				                  <select name="disc_type" id="disc_type">
				                       <option value="CASH" <?php if($ip_discount['discount_type']=='CASH'){?> selected <?php }?>>CASH</option>
				                       <option value="%" <?php if($ip_discount['discount_type']=='%'){?> selected <?php }?>>%</option>
				                  </select>
				                  
				                       <input name="discount" id="discount" tabbindex="2"  class="ipbill" size="10" value="<?php echo (!empty($ip_discount['discount_value']))?$ip_discount['discount_value']:''?>" autocomplete="off" />
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_balance;?></b>:</td>
				           <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($billInfo))?$billInfo[0][8]:''?>" autocomplete="off" readonly/>
				            <input type="hidden" name="actual_balance" id="actual_balance" value="<?php echo (!empty($billInfo))?$billInfo[0][8]:''?>">
				           
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_payment_mode; ?> </b>:	</td>
				           
					   <td id="noborder">
					
						<select name="payment_mode" id="payment_mode" >						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							<!-- <option value="CREDIT" <?php //echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT')?'selected':''?>>CREDIT</option> -->
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<!-- <option value="CHEQUE" <?php //echo (!empty($post['payment_mode']) && $post['payment_mode']=='CHEQUE')?'selected':''?>>CHEQUE</option> -->
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
							
							
						</select>
					    </td>
				       </tr>
				       <tr >
			        
					 <td id="noborder" align="right"><b><?php echo $lang_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="final_amount" id="final_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="" autocomplete="off"/></td>
				      
				      </tr>
				      
				      
					
					
					<tr id="credit_card">
					
					<td id="noborder" align="right"><b><?php echo $lang_card_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					
					
					
					<tr class="cheque">
					
					<td id="noborder" align="right"><b><?php echo $lang_cheque_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="cheque_amount" id="cheque_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,cheque_no)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					</tr>
					<tr class="cheque">
					<td id="noborder" align="right"><b><?php echo $lang_checque_no; ?> <span id='requiredfield'>*</span></b>:	</td>
					
			
					<td id="noborder"><input name="cheque_no" id="cheque_no" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/>
					</td>
					
					
					</tr>
					<tr id="upi">
					
					<td id="noborder" align="right"><b><?php echo $lang_upi_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="upi_amount" id="upi_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['upi_amount']))?$post['upi_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					
				      
				      <tr>
					
					<td id="noborder" align="right"><b><?php echo $lang_remarks; ?> </b>:	</td>
					<td id="noborder"><textarea cols="18" rows="3" name="remarks"><?php echo (!empty($post['remarks']))?$post['remarks']:''?></textarea></td>
				     </tr>
				     	<!-- wheather needed detailed bill or not -->
				     <!-- 	<tr>
					<td id="noborder" colspan="2" align="center"><input id="print_status" type="checkbox" name="print_status" value="print_status"/>Print Detailed Bill</td>
				     </tr> -->
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
<input type="hidden" name="billid" id="billid" value="<?php echo (!empty($billInfo))?$billInfo[0][0]:''?>">
<input type="hidden" name="id" id="id" value="<?php echo (!empty($billInfo))?$billInfo[0][1]:''?>">
<input type="hidden" name="auth_user_id" id="auth_user_id" value="">
<input type="hidden" name="auth_sanc_by" id="auth_sanc_by" value="">
<input type="hidden" name="auth_remarks" id="auth_remarks" value="">
<input type="hidden" name="print_status" id="print_status" value="print_status">
               
