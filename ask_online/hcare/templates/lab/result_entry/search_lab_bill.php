
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
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
  
    <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script>

   
   function submitform(action,id){
		
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.type.value='';
			document.manage_bill.patient_id.value='';
			// document.manage_bill.status.value='0';
			
		}
		
		if(action =="SEARCH"){
			
			if(document.manage_bill.cust_type=='' && document.manage_bill.patient_id!=''){
				
				showDialog('Error','Please Select Customer Type.','error',2);
			return false;
			}
		}
		
		
			
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Lab&sub_module=search_lab_bill";
		
		document.manage_bill.submit();
		return true;
   }
   
   function show_bill_items(billid){
	     
	      tb_show('BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_bill_items&billno="+billid);
	}
	function result_entry(billno){
		
		 
		  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=result_entry&billno="+billno);
          $("#form").submit();
	}
	function view_result(billno){
		
		 
		  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=print_lab_result&billno="+billno);
          $("#form").submit();
	}
	function edit_result(billno,action){
		$("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=edit_lab_result&billno="+billno+"&action="+action);

        $("#form").submit();
	}


	// function sendMail(id,email){
	// 	var v=confirm("Send Lab Result in Mail");
        
	//     if(v) {
	//     	if(email==''){
	//     		var details=prompt("Please Enter the Email :","");
	//     	}else{
	//     		var details=prompt("Email :",email);
	//     	}
	// 	    if(details.length>0){
	// 	    	$("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=email_lab_result&billno="+id+"&email="+details);
 //          		$("#form").submit();
	// 	    	return true;
	// 	    }else{
	// 	    	return false;
	// 	    }  
	// 	}else return false;
	// }
	function sendMail(id,email){
		var v=confirm("Send Lab Result in Mail");
        
	    if(v) {
	    	if(email==''){
	    		var details=prompt("Please Enter the Email :","");
	    	}else{
	    		var details=prompt("Email :",email);
	    	}
		    if(details.length>0){
		    	document.getElementById("emailSentLoading").style.display="block";
		    	$("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=email_lab_result&billno="+id+"&email="+details);
          		$("#form").submit();
		    	return true;
		    }else{
		    	return false;
		    }  
		}else return false;
	}
	function download_pdf(id){
		// document.getElementById("emailSentLoading").style.display="block";
		// alert(id);
		
		    	$("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=download_pdf&billno="+id);
          		$("#form").submit();
		    	return true;
		   
	}
	
	
   
</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
$config_obj=new Config_hims();
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	// $user=$this  ->popArr['user'];
?>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

 
								<tr>
									
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							          </td>
									 <td id="noborder">
										<?php echo $lang_type; ?></td>
									         <td id="noborder" >	<select name="type">
														<option value ="">------</option>
														<option value ="OP" <?php if ( !empty($post['type']) && $post['type']=="OP" ) {
															echo "selected";
														} ?> >OP</option>
														<option value ="DIRECT" <?php if ( !empty($post['type']) && $post['type']=="DIRECT" ) {
															echo "selected";
														} ?> >DIRECT</option>
                                                        <option value ="IP" <?php if ( !empty($post['type']) && $post['type']=="IP" ) {
															echo "selected";
														} ?> >IP</option>
														</select>
									  </td>	
									  
									  <td id="noborder">							
								
										<?php echo $lang_patient_id; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="patient_id" id="patient_id"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['patient_id']))?$post['patient_id']:''?>" /> 	 
							          </td>
									
								</tr>
								<tr>
								
								
								
							       	<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
										</td>
							            <td id="noborder">							
								
										<?php echo $lang_name; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="patient_name" id="patient_name"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['patient_name']))?$post['patient_name']:''?>" /> 	 
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

					$op_div =  "<div style='display:inline-flex;'><div style='width: 20px;height: 20px;background-color: #b5d3b5;'></div><P style='font-size: 14px;padding-top: 5px;padding-left: 10px;font-weight: 700;'>COMPLETED RESULTS</P><div style='width: 20px;height: 20px;background-color: #e7e4c7;margin-left: 30px;'></div><P style='font-size: 14px;padding-top: 5px;padding-left: 10px;font-weight: 700;'>PARTIAL RESULTS</P><div style='width: 20px;height: 20px;background-color: #ddadc0;margin-left: 30px;'></div><P style='font-size: 14px;padding-top: 5px;padding-left: 10px;font-weight: 700;'>CREDIT NOT PAID RESULTS</P></div>";

				?>


						<?php echo $lang_billing." ".$lang_list."&nbsp;&nbsp;&nbsp;&nbsp;".$op_div; ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<div id ="emailSentLoading" style="display:none;text-align: center;"><img id = "myImage" src ="../../dist/img/loop_loader.gif"></div>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>					 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>  
						  <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th> 
                          
						   <th ><a href="#"><?php echo $lang_result_date; ?></a></th>
                          <th ><a href="#"><?php echo $lang_veryfied_by; ?></a></th>
                          <th ><a href="#"><?php echo $lang_entered_by; ?></a></th>						  
					      <th ><a href="#"><?php echo $lang_result_entry; ?></a></th>
					      <!-- <th ><a href="#"><?php //echo 'E-mail Status'; ?></a></th> -->
					 <th width="10%"><a href="#"><?php echo $lang_action; ?></a></th>
					 <?php if ($config_obj->email_status=="YES") {?>
					 <th ><a href="#"><?php echo 'E-MAIL STATUS'; ?></a></th>
					<?php }?>
						
					                             
                                
                            </tr>
						</thead>
						<tbody>	
		<?php 
			if(!empty($billInfo)){
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {
					// var_dump($billInfo);
					?>
					<!-- <tr> -->

					<?php if($billInfo[$i][41] == 0){?>
					<tr style="background-color: #b5d3b5;/* color:#ffffff; */">
					<?php }else if($billInfo[$i][41] == 1){?>
						<tr style="background-color: #e7e4c7;/* color:#ffffff; */">
					<?php }else if($billInfo[$i][41] == 2){?>
						<tr style="background-color: #ddadc0;/* color:#ffffff; */">
					<?php }else{?>
						<tr>
					<?php }?>

						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][16];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo strtoupper($billInfo[$i][26])."/";echo ($billInfo[$i][1]=="OP")?$billInfo[$i][19]:$billInfo[$i][2]; ;?></td>
						<td><?php echo $billInfo[$i][3];?></td>

						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][12];?></td>
						<td><?php echo $billInfo[$i][14];?></td>
				
				    <td><?php echo $billInfo[$i][32];?></td>
					<td><?php echo $billInfo[$i][31];?></td>
					<td><?php echo $billInfo[$i][30];?></td>
					<?php if($billInfo[$i][28] == 0){?>
						<td><a href="#" onclick="result_entry('<?php echo $billInfo[$i][0];?>')"><?php echo $lang_result_entry; ?></a></td>
				<?php }else{ ?>
				       <td class="text-green"><font size="-1"><?php echo $lang_result_ready;?></font></td>
				<?php } ?>
			<!-- 	<td><?php 
				if($billInfo[$i]['email_status']=='Success'){
					echo '<font color="green">'.$billInfo[$i]['email_status'].'</font>';
				}else if($billInfo[$i]['email_status']=='Failed'){
					echo '<font color="red">'.$billInfo[$i]['email_status'].'</font>';
				}else{
					echo 'Email not Sent';					
				}

				?></td> -->

				<td>
				
				       <div class="btn-group">
                                
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">
                             	
                               	<?php if ($_SESSION['user_type']!="CASUALITY") {?>

                               		<li onclick="show_bill_items('<?php echo $billInfo[$i][0];?>')"><a href="#">SHOW BILL ITEMS</a></li>

                               	<?php
                               	} ?>

                                 
								<?php if($billInfo[$i][28] == 1){?> 
								 <li onclick="view_result('<?php echo $billInfo[$i][0];?>')"><a href="#"><?php echo $lang_view_result;?></a></li>

                               	<?php //if ($_SESSION['user_type']!="CASUALITY" && $_SESSION['user_type']=="ADMIN") {?>

                               		<li onclick="edit_result('<?php echo $billInfo[$i][0];?>')"><a href="#"><?php echo $lang_edit_result;?></a></li>

                               	<?php
                               	//} ?>

								 
								     
								<?php 
							   
								} ?> 

									<?php if (($_SESSION['user_type']=="ADMIN" || $_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER" || $_SESSION['user_type']=="ADMIN+DOCTOR") && $billInfo[$i][1]=="DIRECT") {?>

                               		<li onclick="edit_result('<?php echo $billInfo[$i][0];?>','EDIT_PATIENT_INFO')"><a href="#"><?php echo $lang_edit_patient_info;?></a></li>

                               	<?php
                               	} ?> 
                                
                                </ul>
                    </div>
						  <!-- <button class="btn btn-link" style="color: #02BEEE;font-size:25px;" onclick="sendMail('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i]['email'];?>')"><i class="fa fa-envelope"></i></button> -->
						 <?php if ($config_obj->email_status=="YES") {?>
														
								<button class="btn btn-link" style="color: #02BEEE;font-size:16px;" onclick="sendMail('<?php echo $billInfo[$i][0];?>','<?php echo $billInfo[$i]['email'];?>')"><i class="fa fa-envelope"></i></button>

													<?php }?>
						   
                    		<button class="btn btn-link" style="color: red;font-size:15px;" onclick="download_pdf('<?php echo $billInfo[$i][0];?>')"><i class="fa fa-download"></i></button> 
							
						</td>
						<?php if ($config_obj->email_status=="YES") {?>
						<td>
									<?php 
						if($billInfo[$i]['email_status']=='Success'){
							echo '<font color="green">'.$billInfo[$i]['email_status'].'</font>';
						}else if($billInfo[$i]['email_status']=='Failed'){
							echo '<font color="red">'.$billInfo[$i]['email_status'].'</font>';
						}else{
							echo '<font color="#0096FF">'.'Email not Sent'.'</font>';					
						}

						?>
						</td>
					<?php }?>
					
				
							
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
</form>	  
</body>
	</html>
	
