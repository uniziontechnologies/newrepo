
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
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
    
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>

     <script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
  
    <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script>

   
   function submitform(action,id,balance,credit){
   	
	 
		//setAction(action,id);
		document.manage_bill.paction.value=action;
		document.manage_bill.id.value=id;
		//document.manage_bill.credit_amt.value=credit_amt;
		document.manage_bill.credit.value=credit;
		document.manage_bill.current_page.value='';

		if(action =="CLEAR"){
		
			// document.manage_bill.from_date.value='';
			// document.manage_bill.to_date.value='';
			// document.manage_bill.billno.value='';
			// document.manage_bill.type.value='';
			// document.manage_bill.user.value='';
			// document.manage_bill.status.value='0';
			// document.manage_bill.balance.value='0';
			// document.manage_bill.ref_no.value='';

			window.location="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing";
			return false;


			
		}
		if(action == "PRINT"){
			document.manage_bill.is_dupclicate.value="YES";
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Bill";
		}else{
		
			if(action == "DELETE"){
				if(balance!=0 && balance!=credit)
                   {
		        var b=confirm("Remaining some credit balance....!you cannot Delete The Bill...!");return false;
                     }
                     else{
                     	// alert(credit);
				var a=confirm("Do You Really Want to Delete The Bill? It may affect Accounting !!");
		
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
		}
		if(document.manage_bill.type.value=='' && document.manage_bill.ref_no.value!='') {
	   			// showDialog('Error','Please Select Patient Type.','error',2);
	   			$("#type").addClass('error-red');
	   			alert("Please Select Patient Type (OP/IP/DIRECT) !!");
				return false;
	        }
	        else{
	        	document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing";
	        }


   			
		}
		document.manage_bill.submit();
		return true;
   }
   
   function show_bill_items(billid){
	     
	      tb_show('BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_bill_items&billno="+billid);
	}
	function assign_doctors(billid){
	     
	      tb_show('ASSIGN DOCTORS',"../../lib/controllers/centralController.php?module=Billing&sub_module=assign_doctors&billno="+billid);
	}
	function xray_attachments(billid){

		document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=xray_attahments&billno="+billid;
		document.manage_bill.submit();

	}
	function edit_bill(billid,type,id){
	
		document.manage_bill.paction.value="EDIT_BILL";
		document.manage_bill.id.value=billid;
		document.manage_bill.type_edit.value=type;
		document.manage_bill.id_edit.value=id;

		document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Billing_Form";
		document.manage_bill.submit();
		return true;

	      
	}

	/*........pagination.........*/	
  $(document).ready(function(){

     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing");
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing");
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing");
                 $("#form").submit();
              });
   });
   
</script>
<style type="text/css">
	.error-red{
			border: 2px solid red;
	}
</style>
</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$type=$post['type'];
	// var_dump($billInfo);
	$user_type=$this  ->popArr['user_type'];
	// $user_type_id=$this  ->popArr['user_type_id'];
	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];
	$next_page=$this->popArr['next_page'];
?>
 
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

										<td id="noborder">							
								
										<?php echo $lang_contact_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="contact_number" id="contact_number"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['contact_number']))?$post['contact_number']:''?>" /> 	 
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
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/>

                                 <?php //if($user_type_logged_in =="ADMIN" || $user_type_logged_in =="ADMIN+DOCTOR" || $user_type_logged_in =="LAB ADMIN"){ ?>								
									<option value=''>---------------</option>
								<?php //} ?>
											
											<?php for($i=0;$i<count($user_type);$i++){ 
																						
													if(!empty($post['user_type']) && $post['user_type']==$user_type[$i][0]) { ?>
													
														<option value='<?php echo $user_type[$i][0];?>' selected><?php echo $user_type[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user_type[$i][0];?>'><?php echo $user_type[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>     
                                          
										
								
							
							<td id="noborder">
							<?php echo $lang_user; ?> </td>
								<td id="noborder" ><select name="user" id="user"   onkeypress="nextField(event.keyCode,inc)" onchange="submitform();"/> 		
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
							</tr>
							<tr>
							<td id="noborder">
										<?php echo $lang_status; ?></td>
							<td id="noborder" >	<select name="status" onchange="submitform();">
									
														<option value ="0" <?php echo (isset($post['status']) && $post['status']=='0')?'selected':'';?>>Active</option>
														<option value ="1" <?php echo (isset($post['status']) && $post['status']=='1')?'selected':'';?>>Cancelled</option>
														</select>
									</td>	
								
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success"  onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			<h3 >	

				<?php 

					$op_div =  "<div style='display:inline-flex;'><div style='width: 20px;height: 20px;background-color: #b5d3b5;'></div><P style='font-size: 14px;padding-top: 5px;padding-left: 10px;font-weight: 700;'>CREDIT PAID</P><div style='width: 20px;height: 20px;background-color: #ddadc0;margin-left: 30px;'></div><P style='font-size: 14px;padding-top: 5px;padding-left: 10px;font-weight: 700;'>CREDIT NOT PAID</P></div>";


				?>

						<?php echo $lang_billing." ".$lang_list."&nbsp;&nbsp;&nbsp;&nbsp;".$op_div; ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                <?php echo $pagination;?>
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>						
						<th ><a href="#"><?php echo $lang_patient_category; ?></a></th> 
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th ><a href="#"><?php echo $lang_phone_no; ?></a></th>

						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>   
                         <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th> 						  
                          <th ><a href="#"><?php echo $lang_cash; ?></a></th>
						  <th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						   <th width="3%"><a href="#"><?php echo $lang_upi; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th>
					<?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
					<?php }?>
					<th ><a href="#">UPDATE HISTORY</a></th>
					 <th width="10%"><a href="#"><?php echo $lang_action; ?></a></th>
						
					                             
                                
                            </tr>
						</thead>
						<tbody>	
		<?php 
			if(!empty($billInfo)){
				 // var_dump($billInfo); exit();
			// $j=1;
				$j= !empty($next_page)?$next_page+1:1;
				for($i=0;$i<count($billInfo);$i++) {

					// var_dump($billInfo);

					if ($billInfo[$i][1]=="DIRECT" || $billInfo[$i][1]=="IP") {
						$id_edit[$i]=$billInfo[$i][2];
					}
					else{
						$id_edit[$i]=$billInfo[$i][19];
					}

					?>
					<?php if($billInfo[$i][12] == "CREDIT" && $billInfo[$i][14]=='0'){?>
					<tr style="background-color: #b5d3b5;/* color:#ffffff; */">
					<?php }else if($billInfo[$i][12] == "CREDIT" && $billInfo[$i][14]!='0'){?>
						<tr style="background-color: #ddadc0;/* color:#ffffff; */">
					<?php }else{?>
						<tr>
					<?php }?>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?>
								<br>
							<?php if(!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='LAB ADMIN') || ($billInfo[$i][57]=='LAB USER')){
								$bill_type= 'LAB BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='NURSE') || ($billInfo[$i][57]=='SUPER NURSE')) {
								$bill_type= 'NURSE BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='XRAY') ) {
								$bill_type= 'XRAY BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='CASUALITY') ) {
								$bill_type= 'CASUALITY BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='RECEPTION') ) {
								$bill_type= 'RECEPTION BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='DOCTOR') ) {
								$bill_type= 'DOCTOR BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='ADMIN+DOCTOR') ) {
								$bill_type= 'DOCTOR BILL';
							}elseif (!empty($billInfo[$i][57]) && ($billInfo[$i][57]=='ADMIN') ) {
								$bill_type= 'ADMIN BILL';
							}else{
								$bill_type='';

							}
							if(!empty($bill_type)){?>
								<label style="color:green;">(<?php echo $bill_type;?>)</label>
							<?php }
							?>
						</td>
						<td><?php echo	$billInfo[$i][16];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo strtoupper($billInfo[$i][26])."/";echo ($billInfo[$i][1]=="OP")?$billInfo[$i][19]:$billInfo[$i][2]; ;?></td>
						<td>
							<?php								
								if($billInfo[$i][45]){
									echo	$billInfo[$i][45];
									if($billInfo[$i][46]){
										echo "<br> Member ID : ".$billInfo[$i][46];
									}
								}
							?>
						</td>
						<td><?php echo $billInfo[$i][3];?></td>
						<td><?php echo $billInfo[$i][7];?></td>
						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][12];?>
						
						   <?php if($billInfo[$i][12] == "CREDIT" && $billInfo[$i][1]!="IP"){ ?>
						   <br>Sanctioned By:<?php echo $billInfo[$i][32];?>
						   <br>Remarks:<?php echo $billInfo[$i][33];?>
						   <?php } ?>
						</td>
						<td><?php echo !empty($billInfo[$i][40])?$billInfo[$i][40]:$billInfo[$i][13];?></td>
						<td><?php echo !empty($billInfo[$i][41])?$billInfo[$i][41]:$billInfo[$i][15];?></td>
						<td><?php echo !empty($billInfo[$i][56])?$billInfo[$i][56]:$billInfo[$i][55];?></td>
						<td><?php echo $billInfo[$i][14];?></td>
					<?php if($post['status'] == "1"){ ?>	
						<td><?php echo $billInfo[$i][24];?></td>
				<?php } ?>
				           <td><?php echo $billInfo[$i][27];?><br>
				           	<!-- <span class="text-green">
				           	Bill entered by:
							 <?php// echo !empty($billInfo[$i][57])?"(".$billInfo[$i][57].")":'';?></span> -->
				           </td>
				<td>
				
				       <div class="btn-group">
                                
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">
                                 <li class="print_bill" onClick="submitform('<?php echo $lang_print;?>','<?php echo $billInfo[$i][0];?>');"><a href="#">PRINT</a></li>

                                 <?php
                                 	if ( (date("Y-m-d",strtotime($billInfo[$i][16]))==date("Y-m-d")) && empty($billInfo[$i][37]) && ($_SESSION["user_type"]=="LAB ADMIN") && ($_SESSION['user_type_id'] == $billInfo[$i][45] ) ) {?>
                                 		
                                 	<li class="edit_bill" onclick="edit_bill('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i][1];?>','<?php echo $id_edit[$i];?>');"><a href="#">EDIT BILL</a></li>

                                 	<?php
                                 	}

                                 	else if ( $_SESSION["user_type"]=="ADMIN"||$_SESSION["user_type"]=="ADMIN+DOCTOR")  {?>
                                 		
                                 	<li class="edit_bill" onclick="edit_bill('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i][1];?>','<?php echo $id_edit[$i];?>');"><a href="#">EDIT BILL</a></li>

                                 	<?php if($post['status'] != "1"){ ?>

                                    <li class="cancel_bill" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i][14];?>','<?php echo $billInfo[$i][21];?>');"><a href="#">CANCEL BILL</a></li>

								       <?php } 
                                 	}

           	                       ?>
           	                       <?php

									if ( (date("Y-m-d",strtotime($billInfo[$i][16]))==date("Y-m-d")) && empty($billInfo[$i][37]) && ($_SESSION["user_type"]=="RECEPTION") && ($_SESSION['user_type_id'] == $billInfo[$i][45] ) ) {?>
                                 		
                                 	<li class="edit_bill" onclick="edit_bill('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i][1];?>','<?php echo $id_edit[$i];?>');"><a href="#">EDIT BILL</a></li>

                                 	<?php
                                 	}
                                 	?>
                                 
							<?php if($_SESSION['user_type']== "ADMIN" || $_SESSION['user_type']== "ADMIN+DOCTOR") { ?>
								
								  <!--<li class="edit_bill" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $billInfo[$i][0];?>');"><a href="#">EDIT</a></li>-->

							<?php } ?>
								
                                 <li onclick="show_bill_items('<?php echo $billInfo[$i][0];?>')"><a href="#">SHOW BILL ITEMS</a></li>
								  <li onclick="assign_doctors('<?php echo $billInfo[$i][0];?>')"><a href="#">ASSIGN DOCTORS</a></li>
								
									  <li class="xray_attachments" onClick="xray_attachments('<?php echo $billInfo[$i][0];?>');"><a href="#">XRAY ATTACHMENTS</a></li>
								
                                
                                </ul>
                    </div>
						
							
						</td>
					
				
							
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	   <input type="hidden" name="credit_amt" id="credit_amt" value=<?php echo $billInfo[0][14] ;?> />
	    <input type="hidden" name="balance" id="balance" />
	      <input type="hidden" name="credit" id="credit" />
	       <input type="hidden" name="is_dupclicate" id="is_dupclicate"  />
	       	  <input type="hidden" name="type_edit" id="type_edit">
	  <input type="hidden" name="id_edit" id="id_edit">

	  <!--.....pagination......-->
  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
</form>	  
</body>
	</html>
	
