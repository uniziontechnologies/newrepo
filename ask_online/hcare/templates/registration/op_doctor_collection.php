
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
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  
    <script>
      $(function () {
	  
	   //Date range picker
        $('#date').datepicker();
	  });
	  </script>
<script>
	
     
   function search(action,id){
   	
        document.op_doctor_bill.paction.value=action;
        document.op_doctor_bill.id.value=id;

        if (action=="CLEAR") {
        	document.op_doctor_bill.date.value="";
        	document.op_doctor_bill.doctor.value="";
        }

		document.op_doctor_bill.action="../../lib/controllers/centralController.php?module=Registration&sub_module=op_doctor_collection";
		document.op_doctor_bill.submit();
   }
   function pay_now(visit_date,doc_name,doc_fee,doc_id,balance,amount_paid_so_far) {
   	
   		$("#visit_date").val(visit_date);
   		$("#doc_name").val(doc_name);
   		$("#doc_fee").val(doc_fee);
   		$("#doc_id").val(doc_id);
   		$("#balance").val(balance);
   		$("#amount_paid_so_far").val(amount_paid_so_far);

   		document.op_doctor_bill.action="../../lib/controllers/centralController.php?module=Registration&sub_module=op_doctor_payment_Form";
   		document.op_doctor_bill.submit();

   }
   
 function payAll(){
 
 	var isChecked = false;
	var total=0;var amt=0;
		with (document.op_doctor_bill) {
			for (i in elements) {
				if (elements[i] && elements[i].type == 'checkbox' && elements[i].checked==true) {
					isChecked = true;
					amt=elements[i].value;					
					amt=amt.split("#");
					total=total+parseInt(amt[3]);

					
					}
				 
			}
		}
			
		if(isChecked!=true)
		{
		alert("Please select atleast one bill");
		return false;
		}else{ 
		var v=confirm("Do you want to pay selected bills; Total Bill Amount :"+total);
		// var v=confirm("Do you want to pay selected bills");
			if(v==true){
					document.op_doctor_bill.action="../../lib/controllers/centralController.php?module=Registration&sub_module=add_multilple_dr_collection";
			}else{
			return false;
			}
			document.op_doctor_bill.submit();
			
		}
				
		


 
 }  
</script>

</head>
<body id="frame">
<form name="op_doctor_bill" id="op_doctor_bill"  method="post" action=""> 
<?php
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$doctors=$this  ->popArr['doctors'];

?>
 <section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
								<tr>
										<td id="noborder"><?php echo $lang_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="date" id="date"  class="DatePicker" value="<?php echo (!empty($post['date']))?$post['date']:date('d-m-Y');?>" readonly="true"/>
										</td>
										<td id="noborder"><?php echo $lang_doctor; ?>:</td>
										<td id="noborder">
											
											<select id="doctor" name="doctor">
												
												<option value="">------------------------------</option>
													
												<?php

													if (!empty($doctors)) {
														for ($i=0; $i < count($doctors); $i++) { ?>

														<option value="<?php echo $doctors[$i][0] ?>" <?php if (!empty($post['doctor']) && $post['doctor']==$doctors[$i][0] ) {
															echo "selected";
														} ?> ><?php echo $doctors[$i][1]." ".$doctors[$i][2]." ".$doctors[$i][3]; ?></option>

														<?php
														}
													}

												?>

											</select>

										</td>
										
								</tr>

								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="search('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="search('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			
			<h3 >OP DOCTOR COLLECTION</h3>
					<?php if(isset($post['message'])){?>
						<div id='message' class="callout callout-success"><?php echo $post['message'];?></div>
					<?php } ?>
				<div align="right">	
					<?php 
						  $user_type_logged_in=$_SESSION['user_type'];
						  if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
						
						 <a href="#" class="btn btn-warning btn-flat" onclick="payAll();"  class="add">PAY SELECTED BILL</a>
                       	
							<?php }?>
				</div><br>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                          <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>					 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
						  <th ><a href="#"><?php echo "AMOUNT PAID SO FAR"; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th>  
						  <th ><a href="#"><?php echo $lang_action; ?></a></th>    
						  
						  <?php 
						 
						  if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
						  
						  <th ><a href="#"><?php echo "PAY"; ?></a></th>                               
                             <?php }?>   
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($billInfo)){
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {
						if (!empty($billInfo[$i][2]) && $billInfo[$i][2]!=$billInfo[$i][5] ) {
                    ?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo $billInfo[$i][2];?></td>
						<td><?php 

							if (!empty($billInfo[$i][5])) {
								$billInfo[$i][5]=$billInfo[$i][5];
							}
							else{
								$billInfo[$i][5]="0";
							}
							echo $billInfo[$i][5];							

						?></td>
						<td><?php 

							if (!empty($billInfo[$i][4])) {
								$billInfo[$i][4]=$billInfo[$i][4];
							}
							else{
								$billInfo[$i][4]=$billInfo[$i][2];
							}
							echo $billInfo[$i][4];

						?></td>
						
				<?php	if(!empty($billInfo[$i][29]) == 2 && $billInfo[$i][1] =="IP"){?>
				
				        <td><span class="text-red" ><b>BILL PREPARED</b></span></td>
				
				<?php }else{ ?>
						<td>
							<a href="#" class="btn btn-success" onclick="pay_now('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i][1];?>','<?php echo $billInfo[$i][2];?>','<?php echo $billInfo[$i][3];?>','<?php echo $billInfo[$i][4];?>','<?php echo $billInfo[$i][5];?>');">PAY NOW</a>
							
							</td>
				<?php } ?>
							
							
						  <?php 
						  
						  if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
						  
							
							<td><input type="checkbox"   value="<?php echo $billInfo[$i][0]."#".$billInfo[$i][2]."#".$billInfo[$i][3]."#".$billInfo[$i][4]."#".$billInfo[$i][5];?>" name="paybill[]" id="paybill<?php echo $i;?>" title="<?php echo "Bill No: ".$billInfo[$i][0];?>">
					
							</td>
								<?php 
								}?>
							
					</tr>
						
				
		<?php	
                              
                         }
                    }
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="doc_id" id="doc_id" value="">
	  <input type="hidden" name="doc_name" id="doc_name" value="">
	  <input type="hidden" name="visit_date" id="visit_date" value="">
	  <input type="hidden" name="doc_fee" id="doc_fee" value="">
	  <input type="hidden" name="balance" id="balance" value="">
	  <input type="hidden" name="amount_paid_so_far" id="amount_paid_so_far" value="">
</form>	  

</body>
	</html>
	
