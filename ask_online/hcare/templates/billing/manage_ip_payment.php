
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
   	
	 
		//setAction(action,id);
		document.manage_bill.paction.value=action;
		document.manage_bill.billid.value=id;
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.ipno.value='';
			document.manage_bill.user.value='';
			
			
		}
		//wheather print a detailed bill
		if(action == "PRINT" || action == "print_detailed"){
			if(action == "print_detailed"){
				$('#print_status').val('print_status');
			}
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_IP_Bill";
		}else{
		
			if(action == "DELETE"){

				var a=confirm("Do You Really Want to Delete The Bill?");
		
  		 if(a==true)
   			{
				var details=prompt("Please Enter Cancellation Details:","");
				
				if(details!= null){
					document.manage_bill.cancellation_details.value=details;
					
				}else{
				return false;
			}
				

			}else{
				return false;
			}
			}
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_IP_Payments";
		}
		document.manage_bill.submit();
		return true;
   }
   
   
</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
	
	$billInfo=$this ->popArr['billInfo'];
	
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_billing; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
											
										</td>
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							</td>
										
									
								</tr>
								<tr>
								
								<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	 <input type="text" name="ipno" id="ipno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" /> 	 
									</td>
								
							
							<td id="noborder">
							<?php echo $lang_user; ?> </td>
								<td id="noborder" ><select name="user" id="user"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($user);$i++){ 
																						
													if(!empty($post['user']) && $post['user']==$user[$i][0]) { ?>
													
														<option value='<?php echo $user[$i][0];?>' selected><?php echo $user[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user[$i][0];?>'><?php echo $user[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">
										</td>
							<td id="noborder" >	
									</td>	
								
								</tr>
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
			<h3 ><?php echo $lang_billing_info; ?></h3>
		
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>						 
						  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th><a href="#"><?php echo $lang_room_no; ?></a></th>					 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
						  <th ><a href="#"><?php echo $lang_amount_paid; ?></a></th>
						  <th ><a href="#"><?php echo $lang_discount; ?></a></th>
						  <th ><a href="#"><?php echo $lang_net_amount; ?></a></th> 
						   <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>   					  
                          <th ><a href="#"><?php echo $lang_cash; ?></a></th>
						  <th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						  <th ><a href="#"><?php echo $lang_upi_amount; ?></a></th>
						  <th ><a href="#"><?php echo $lang_cheque_amount; ?></a></th>
						  <th ><a href="#"><?php echo $lang_checque_no; ?></a></th>
						   <th ><a href="#"><?php echo $lang_credit_paid; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th>
						  <th ><a href="#"><?php echo $lang_remarks; ?></a></th>
					
					<?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
					<?php }?>
					 <th ><a href="#"><?php echo $lang_action; ?></a></th>
					 <th ><a href="#">UPDATE HISTORY</a></th>
					
						
					                             
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($billInfo)){
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][2]." ".$billInfo[$i][3];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo $billInfo[$i][23];?></td>
						<td><?php echo $billInfo[$i][15]; ;?></td>
						<td><?php echo $billInfo[$i][16]; ;?></td>
						<td><?php echo $billInfo[$i][4];?></td>
						<td><?php echo $billInfo[$i][5];?></td>
						<td><?php echo ($billInfo[$i][6] == "CASH")?Rs.$billInfo[$i][7]:$billInfo[$i][7]." ".$billInfo[$i][6];?></td>
						<td><?php echo $billInfo[$i][8];?></td>
						<td><?php echo $billInfo[$i][9];?>
						
						     <?php if($billInfo[$i][9] == "CREDIT"){?>
							 
							        <br>
									Sanc By:<?php echo $billInfo[$i][21];?>
									 <br>
									Remarks:<?php echo $billInfo[$i][22];?>
							 <?php } ?>
						</td>
						<td><?php echo $billInfo[$i][10];?></td>
						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][34];?></td>
						<td><?php echo $billInfo[$i][28];?></td>
						<td><?php echo $billInfo[$i][12];?></td>
						<td><?php echo $billInfo[$i][26];?></td>
						<td><?php echo $billInfo[$i][24];?></td>
						<td><?php echo $billInfo[$i][13];?></td>
					<td>
						
							<!-- <a href="#" class="btn btn-info btn-flat" onClick="submitform('<?php echo $lang_print;?>','<?php echo $billInfo[$i][0];?>');" title="print bill"><i class="fa fa-print"></i></a> -->
							<a href="#" class="btn btn-info btn-flat" onClick="submitform('<?php echo 'print_detailed';?>','<?php echo $billInfo[$i][0];?>');" title="print  bill"><i class="fa fa-print"></i></a>
							
						</td>
					
					<?php if($post['status'] == "1"){ ?>	
						<td><?php echo $billInfo[$i][24];?></td>
				<?php } ?>
				               <td><?php echo $billInfo[$i][17];?></td>
				
				
							
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="billid" id="billid" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="is_dupclicate" id="is_dupclicate">
	  
	  <input type="hidden" name="print_status" id="print_status"/>
</form>	  
</body>
	</html>
	
