 <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>
var $j = jQuery.noConflict();
    $(document).ready(function() {  
    
             $("#credit_card").hide();
             $("#cheque").hide();
             $("#upi").hide();
	     
	     $( "#payment_mode" ).change(function() {
            
                payment_mode= $("#payment_mode").val();
                
                if(payment_mode == "CREDIT CARD"){
                
                   // $("#credit_card").show();
                   //  $("#cheque").hide();
                	 $("#credit_card").show();
				   $("#upi").hide();
                   $("#cheque").hide();
				   $("#upi_amount").val('');
					$("#cheque_no").val('');
                }else if(payment_mode == "UPI"){
                    $("#upi").show();
                    $("#credit_card").hide();
                    $(".cheque").hide();
					$("#card_amount").val('');
					$("#cheque_no").val('');
                }else if(payment_mode == "CHEQUE"){
                
                     $("#cheque").show();
                     $("#credit_card").hide();
					 $("#upi").hide();
					 $("#card_amount").val('');
					 $("#upi_amount").val('');
                }else{
                  
                   $("#upi").hide();
                   $("#credit_card").hide();
                   $(".cheque").hide();
				   $("#card_amount").val('');
				   $("#upi_amount").val('');
					$("#cheque_no").val('');
                
                }
            });
	    
	     $( "#save" ).click(function() {
             
                payment_mode= $("#payment_mode").val();
		
		if((payment_mode =="CASH" || payment_mode =="CHEQUE") && ($("#cash_amount").val() == '')){
                
                    showDialog('Error','Please Enter Amount.','error',2);
			      return false;
                
                }else if(payment_mode =="CREDIT CARD"  && ($("#card_amount").val() =='')){
                
                   showDialog('Error','Please Enter Card Amount.','error',2);
			       return false;
                }else if(payment_mode =="CHEQUE"  && $("#cheque_no").val() == ""){
                
                   showDialog('Error','Please Enter Cheque Number.','error',2);
			       return false;
                }else if(payment_mode =="UPI"  && ($("#upi_amount").val() =='' || $("#upi_amount").val() =='0')){
                
                   showDialog('Error','Please Enter UPI Amount.','error',2);
			       return false;
                }else if(  payment_mode  =="UPI" && (Number($("#cash_amount").val())+Number($("#upi_amount").val())) > Number($("#balance").val()) ){

		           showDialog('Error','Please Enter Full Amount.','error',2);
			       return false;
			       
	             

                }else{
                
                
                  $("#payment").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=add_ip_credit_payment");
                  $("#payment").submit();
                
                }
             
             });
	});
</script>
 <div  id="content">
<form name="payment" id="payment"  method="post" action="" > 
 

<?php

$billInfo=$this->popArr['billInfo'];

?>
<input name="billid" id="billid" value="<?php echo $billInfo[0][0];?>">
       
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
				
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		
		<div class="row">
          <div class="col-xs-12">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
							<tr style="font-weight:bold" class="text-navy">
						<td>
			 			<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" >
		 						<font size="<?php echo $lang_font_size;?>"><?php echo $lang_ip_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][1]; ?></font>
						</td>
					   <td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_room_no; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][16];?></font>
						</td>
						
		
					</tr>
					</table>
				</div>
			</div>
					
			<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
				 <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_total_amount;?></b>:</td>
				           <td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2"  value="<?php echo (!empty($billInfo))?($billInfo[0][4]-$billInfo[0][7]):''?>" autocomplete="off" readonly/>
				         
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_amount_paid;?> SO FAR </b>:</td>
				           
				           <td id="noborder" ><b><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($billInfo))?$billInfo[0][25]:''?>" autocomplete="off" readonly/></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_balance;?></b>:</td>
				           <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($billInfo))?$billInfo[0][24]:''?>" autocomplete="off" readonly/>
				           
				           
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_payment_mode; ?> </b>:	</td>
				           
					   <td id="noborder">
					
						<select name="payment_mode" id="payment_mode" >						
							<option value="CASH" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CASH')?'selected':''?>>CASH</option>
							<option value="CREDIT CARD" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CREDIT CARD')?'selected':''?>>CREDIT CARD</option>
							<option value="CHEQUE" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='CHEQUE')?'selected':''?>>CHEQUE</option>
							<option value="UPI" <?php echo (!empty($post['payment_mode']) && $post['payment_mode']=='UPI')?'selected':''?>>UPI</option>
							
							
						</select>
					    </td>
				       </tr>
				       <tr >
			        
					 <td id="noborder" align="right"><b><?php echo $lang_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="cash_amount" id="cash_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="" autocomplete="off"/></td>
				      
				      </tr>
				      
				      
					
					
					<tr id="credit_card">
					
					<td id="noborder" align="right"><b><?php echo $lang_card_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="card_amount" id="card_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['card_amount']))?$post['card_amount']:''?>" autocomplete="off"/></td>
					
					</tr>

					<tr id="upi">
					
					<td id="noborder" align="right"><b><?php echo $lang_upi_amount; ?> <span id='requiredfield'>*</span></b>:	</td>
					<td id="noborder"><input name="upi_amount" id="upi_amount" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['upi_amount']))?$post['upi_amount']:''?>" autocomplete="off"/></td>
					
					</tr>
					
					
					
					<tr id="cheque">
					
					
					
					<td id="noborder" align="right"><b><?php echo $lang_checque_no; ?> <span id='requiredfield'>*</span></b>:	</td>
					
			
					<td id="noborder"><input name="cheque_no" id="cheque_no" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['checque_no']))?$post['checque_no']:''?>" autocomplete="off"/>
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
	</div>
</div>	

   
   
</form>
</div>

	
