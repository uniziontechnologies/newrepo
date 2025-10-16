<?php
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user_type=$this  ->popArr['user_type'];

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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 $('.hide_div').hide();
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
			
			
		}
		if(action == "Credit_Payment_Form"){
			document.credit_payment.action="../../lib/controllers/centralController.php?module=Report&sub_module=credit_payment";
		}else{
   			document.credit_payment.action="../../lib/controllers/centralController.php?module=Report&sub_module=credit_payment";
		}
		document.credit_payment.submit();
   }
   function printit(){  

alert('Printing..Please make Printer and Paper Ready');
					if (window.print) {
					   window.print();  
					} else {
					   var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
					document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
					   WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = "";  
					}
					}
   function download_pdf(){
   	$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Credit Payment Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.credit_payment.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.credit_payment.submit();

   }
   
</script>

</head>
<body id="frame">
<form name="credit_payment" id="form"  method="post" action=""> 

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
									<td id="noborder" >	<select name="type">
														<option value ="">------</option>
														<option value ="OP">OP</option>
														<option value ="DIRECT">DIRECT</option>
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
								</td>
                                    <td id="noborder">
										<?php echo "BILL-". $lang_status; ?></td>
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


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;"	>
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo "CREDIT BILLING LIST" ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_invoice_no; ?></a></th>
						   <th width="15%"><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo "BILL ".$lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>						 				 <th ><a href="#"><?php echo $lang_paid_on; ?></a></th>	
						  <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_cash; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_card_amount; ?></a></th> 
						   <th ><a href="#"><?php echo $lang_upi_amount; ?></a></th>	
						  <th ><a href="#"><?php echo $lang_total; ?></a></th>  
						  <?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
					<?php }?>
					
				           						                     
						                                
                                
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
						<td><?php echo	$billInfo[$i][0];?></td>
						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo ($billInfo[$i][1]=="OP")?$billInfo[$i][21]:$billInfo[$i][2]; ?></td>
                                                <td><?php echo $billInfo[$i][17];?></td>
                        <td><?php echo $billInfo[$i][22];?></td>
                        <td><?php echo !empty($billInfo[$i][23])?$billInfo[$i][23]:0; ?></td>
                        <td><?php echo !empty($billInfo[$i][24])?$billInfo[$i][24]:0; ?></td>
                        <td><?php echo !empty($billInfo[$i][28])?$billInfo[$i][28]:0; ?></td>
						<td><?php echo $billInfo[$i][18];?></td>
		</td>
						<?php if($post['status'] == "1"){ ?>	
						<td><?php echo $billInfo[$i][26];?></td>
				<?php } ?>
						
							
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
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<td></td>
                                	<th align="right" style="text-align: right;">Total</th><th><?php echo $total_cash_paid;?></th>
                                	<th><?php echo $total_card_paid;?></th>
                                	<th><?php echo $total_upi_paid;?></th>
                                    <th><?php echo $total_amount_paid;?></th>
                                    <th></th>
                                </tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
<?php

if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
      	  </div>
  		
<?php
}
?>          


     </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="credit_payment" value="credit_payment" />
</form>	  

</body>
	</html>

