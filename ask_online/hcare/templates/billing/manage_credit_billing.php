
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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script>
	
 
   function submitform(action,id){
   	
	 
		setAction(action,id);
		if(action =="CLEAR"){
		
			document.credit_payment.from_date.value='';
			document.credit_payment.to_date.value='';
			document.credit_payment.billno.value='';
			document.credit_payment.type.value='';
			document.credit_payment.ref_no.value='';
			
			
		}
		if(action == "Credit_Payment_Form"){
			document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Credit_Billing";
		 }
		 else{
   			document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Credit_Billing";
		}

		document.credit_payment.submit();
		return true;
   }
   function print_bill(credit_id,billid){
   
      document.credit_payment.id.value=credit_id;
      document.credit_payment.is_dupclicate.value="YES";
	  document.credit_payment.billid.value=billid;
      document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Credit_Bill";
	  document.credit_payment.submit();
	  
   }
   function print_bill_new(credit_id,billid){
   
      document.credit_payment.id.value=credit_id;
      document.credit_payment.is_dupclicate.value="YES";
	  document.credit_payment.billid.value=billid;
      document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Credit_Bill_New";
	  document.credit_payment.submit();
	  
   }

   function delete_payment(credit_id,billid,credit_amt,total_amount_paid){

   	 // alert(credit_id+" || "+billid);return false;
document.credit_payment.credit_id.value=credit_id;
document.credit_payment.billid.value=billid;
document.credit_payment.credit_amt.value=credit_amt;
document.credit_payment.total_amount_paid.value=total_amount_paid;

 //alert(total_amount_paid+" || "+credit_amt);
        if(credit_amt!=total_amount_paid){
		    var a=confirm("Remaining some credit balance.....! Do You Really Want to Delete The Bill?");
		    }
		
		else{
			var a=confirm(" Do You Really Want to Delete The Bill?");

		    }
  		 if(a==true)
   			{

				var details=prompt("Please Enter Cancellation Details:","");
				
							if(details!= null){

      							document.credit_payment.credit_id.value=credit_id;
	  							document.credit_payment.billid.value=billid;
								document.credit_payment.cancellation_details.value=details;
								 document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=delete_Credit";
								 document.credit_payment.submit();

								
							}else{
							return false;
			}
				

			}else{
				return false;
			}
           document.credit_payment.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Credit_Billing";
	   //document.credit_payment.submit();
   }




</script>

</head>
<body id="frame">
<form name="credit_payment" id="form"  method="post" action=""> 
<?php
	$credit_sum_total=$this  ->popArr['credit_sum_total'];
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user_type=$this  ->popArr['user_type'];
	$user=$this  ->popArr['user'];
	


?>
 <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search." ".$lang_billing; ?></h4>
		  
        </section>
 
	<section class="content">
	 <div class="DONTPrint">				 
	   <div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?date('d-m-Y',strtotime($post['from_date'])):date('d-m-Y');?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
											
										</td>
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							</td>
										
									
								</tr>
								<tr>
								
								<td id="noborder">
										<?php echo $lang_type; ?></td>
										<td id="noborder" >	<select name="type" id="type">
														<option value ="">------</option>
														<option value ="OP" <?php echo (isset($post['type']) && $post['type']=='OP')?'selected':'';?>>OP</option>
														<option value ="DIRECT" <?php echo (isset($post['type']) && $post['type']=='DIRECT')?'selected':'';?>>DIRECT</option>
                                                        <option value ="IP" <?php echo (isset($post['type']) && $post['type']=='IP')?'selected':'';?>>IP</option>
														</select>
									</td>
								
							
							<td id="noborder">
							<?php echo $lang_ref_no; ?> </td>
								<td id="noborder" > 		
									
									<input type="text" name="ref_no" id="ref_no" value="<?php echo (!empty($post['ref_no']))?$post['ref_no']:''?>" />
							</td>
							<td id="noborder">
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" /> 		
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
								
								</tr>
								  <td id="noborder">
										<?php echo "BILL - ".$lang_status; ?></td>
							<td id="noborder" >	<select name="status">
									
														<option value ="0" <?php echo (isset($post['status']) && $post['status']=='0')?'selected':'';?>>Active</option>
														<option value ="1" <?php echo (isset($post['status']) && $post['status']=='1')?'selected':'';?>>Cancelled</option>
														</select>
									</td>					
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<h4 >CREDIT BILLING LIST</h4>		
			<div class="box box-info">
                
                           <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_invoice_no; ?></a></th>
						   <th width="15%"><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo "BILL ".$lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>            
						  <th ><a href="#"><?php echo $lang_paid_on; ?></a></th>	
						  <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_cash; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_card_amount; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_upi_amount; ?></a></th>
						  <th ><a href="#"><?php echo $lang_total; ?></a></th> 
                           <th ><a href="#">UPDATE HISTORY</a></th>
                               
                           <?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
					       <?php }//else{?>					                     
                            	
                          <th ><a href="#"><?php echo $lang_action; ?></a></th>  						  
						                                
                            <?php  //}?>	     
                            </tr>
						</thead>
						<tbody>	
		<?php
                        $total_cash_paid=0;
                        $total_card_paid=0;
                        $total_amount_paid=0;
                        $total_upi_paid=0;
			if(!empty($billInfo)){ //var_dump($billInfo);
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][15];?></td>
						<td><?php echo $billInfo[$i][20];?></td>
						<td><?php echo	$billInfo[$i][0];?> <BR>
							<?php echo	!empty($billInfo[$i][29])?"<B>(".$billInfo[$i][29].")</b>":'';?></td>
						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo ($billInfo[$i][1]=="OP")?$billInfo[$i][21]:$billInfo[$i][2]; ?></td>
                        <td><?php echo $billInfo[$i][17];?></td>
                        <td><?php echo $billInfo[$i][22];?></td>
                        <td><?php echo !empty($billInfo[$i][23])?$billInfo[$i][23]:0; ?></td>
                        <td><?php echo !empty($billInfo[$i][24])?$billInfo[$i][24]:0; ?></td>
                        <td><?php echo !empty($billInfo[$i][28])?$billInfo[$i][28]:0; ?></td>
						<td><?php echo $billInfo[$i][18];?></td>
						<td><?php echo $billInfo[$i]['name'].":".date("d-m-Y h:i A", strtotime($billInfo[$i][17]));?></td>
	                    <td>
	                    	<?php if($post['status'] == "1"){ ?>	
						<td><?php echo $billInfo[$i][26];?></td>
				<?php }else{?>
							<?php// $balance[$i] =$billInfo[$i][8]-$billInfo[$i][18];
							 //$total_cash[$i] +=$billInfo[$i][23];

							
							?>


                             


							<a href="#" class="btn btn-info btn-flat" onClick="print_bill_new('<?php echo $billInfo[$i][15];?>','<?php echo $billInfo[$i][0];?>');"><i class="fa fa-print"></i></a>

                     
						<?php if($_SESSION["user_type"]=="ADMIN"||$_SESSION["user_type"]=="ADMIN+DOCTOR"){ ?>
                         
							<?php if($post['status'] != "1"){ 

								if($billInfo[$i][27]==2 && $billInfo[$i][1] =="IP"){?>
                                  <button type="button" disabled class="btn btn-danger" onClick="delete_payment('<?php echo $billInfo[$i][15];?>','<?php echo $billInfo[$i][0];?>','<?php echo $credit_sum_total[$i];?>','<?php echo $billInfo[$i][8];?>');"><i class="fa fa-remove"></i></button>
								<?php }
                                  else if($billInfo[28]=="DISCHARGED"){?>
                                  	   <button type="button" disabled class="btn btn-danger" onClick="delete_payment('<?php echo $billInfo[$i][15];?>','<?php echo $billInfo[$i][0];?>','<?php echo $credit_sum_total[$i];?>','<?php echo $billInfo[$i][8];?>');"><i class="fa fa-remove"></i></button>
                                <?php  }else{ ?>

                                	<button type="button" class="btn btn-danger" onClick="delete_payment('<?php echo $billInfo[$i][15];?>','<?php echo $billInfo[$i][0];?>','<?php echo $credit_sum_total[$i];?>','<?php echo $billInfo[$i][8];?>');"><i class="fa fa-remove"></i></button>
                              <?php  }

								 } }}?>
							</button>
							</td>
					      </td>
						
							
					</tr>
						
				
		<?php	

						$total_cash_paid +=$billInfo[$i][23];
						$total_card_paid +=$billInfo[$i][24];
                        $total_amount_paid +=$billInfo[$i][18];
                        $total_upi_paid +=$billInfo[$i][28];

                         }
			
			}		
		?>
                                <tr>
                                	<th colspan="9" align="right" style="text-align: right;">Total</th><th><?php echo $total_cash_paid;?></th>
                                	<th><?php echo $total_card_paid;?></th>
                                	 <th><?php echo $total_upi_paid;?></th>
                                    <th><?php echo $total_amount_paid;?></th>
                                    <th></th>
                                </tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
          
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">
      </div>
     </section>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="billid" id="billid" value="" />
	  <input type="hidden" name="credit_id" id="credit_id" value="" />
	 <input type="hidden" name="action" id="action" />
	   <input type="hidden" name="cancellation_details" id="cancellation_details" />
	    <input type="hidden" name="credit_amt" id="credit_amt"/>
	     <input type="hidden" name="total_amount_paid" id="total_amount_paid"  />
	   <!--  <input type="hidden" name="billno" id="billno" /> -->
	   <input type="hidden" name="is_dupclicate" id="is_dupclicate"  />

</form>	  

</body>
	</html>
	
