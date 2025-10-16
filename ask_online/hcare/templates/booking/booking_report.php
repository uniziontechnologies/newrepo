
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
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
  <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

    <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>

	 <script type="text/javascript">

	 	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });

	 	$( document ).ready(function() {
	 		$('#from_date').datepicker();
		 $('#to_date').datepicker();
	 	

	 		$('.check_all').click(function(){
	 			// alert(11);

                  var d = $(this).data(); // access the data object of the button
                  // alert(d);
                  $('.check_cancellation').prop('checked', !d.checked); // set all checkboxes 'checked' property using '.prop()'
                  d.checked = !d.checked; // set the new 'checked' opposite value to the button's data object
              });
	 		$('#cancel_all_booking').click(function(){
	 		// alert("cancel all");

	 			 var no_of_items=$(".check_cancellation:checked").length;
                   // alert(no_of_items);
                    if (no_of_items <= 0) {
                    showDialog('Error','Select Atleast One Booking.','error',2);
                        return false;
                  }else{
                  	   var confirm_data = confirm("Are you sure you want to cancel these bookings ?");
                   
                   if(confirm_data){
                    $("#cancel_all_bookings").val('YES');
                    var no_of_items=$(".check_cancellation:checked").length;
                   // alert(no_of_items);
                   var details=prompt("Please Enter Cancellation Reason :","");
                   if(details.length>0){
					    	 document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Cancel_Booking&no_of_items="+no_of_items+"&reason="+details;
									 document.booking_report.submit();
					    	return true;
					    }else{
					    	return false;
					    } 

                   }else{
                    return false;
                   }
                  }
	 		});
	 		// 


	 		$('.transfer_booking').click(function(){

	 			var transfer_id = $(this).attr("transfer-id");
	 			var transfer_name = $(this).attr("transfer-name");
	 			var transfer_place = $(this).attr("transfer-place");
	 			var transfer_phone = $(this).attr("transfer-phone");

	 			$("#transfer_id").val(transfer_id);
	 			$("#transfer_name").val(transfer_name);
	 			$("#transfer_place").val(transfer_place);
	 			$("#transfer_phone").val(transfer_phone);

		   		document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking";
				document.booking_report.submit();	 			



	 		});

    
		});

   //    $(function () {
	  
	  //  //Date range picker
   //      $('#from_date').datepicker();
		 // $('#to_date').datepicker();
	  // });


   function submitform(id){
   
	
		setAction('',id);	
   		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form";
		document.manage_scheduling.submit();
   }
   function processForm(){
	
	
	
		document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking_Report";
		document.booking_report.submit();
		
		
	}
	function redirect(action,bk_id,bookdate){
	
		dateObj= new  Date;

        var day=dateObj.getDate();
		if(day<10)
		{
		 day='0'+day;
		}
       
		var month=dateObj.getMonth()+1;
		if(month<10)
		{
		 month='0'+month;
		}
		
		currDate=day+"-"+month+"-"+dateObj.getFullYear();
	
		if(currDate == bookdate) {
			if(action == "PROCESS_OP_NO"){
		
				if(document.getElementById(''+bk_id+'').value == ''){
				
					showDialog('Error','Please Enter OP Number.','error',2);
					return false;
				}
				document.booking_report.opno.value=document.getElementById(''+bk_id+'').value;
			
			}
			
			document.booking_report.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&bk_id="+bk_id+"&paction="+action;
			document.booking_report.submit();
			return true;
		}else {
		
			//showDialog('Error','Registration Not Started For The Selected Date.','error',2);
					// return false;
document.booking_report.action="../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&bk_id="+bk_id+"&paction="+action;
			document.booking_report.submit();
			return true;
		}
	}
	function clearForm(){
		window.location="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking_Report";
		return false;

		// document.booking_report.doctor.value='';
		// document.booking_report.patient_name.value='';
		// document.booking_report.place.value='';
		// document.booking_report.phone.value='';
		// document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking_Report";
		// document.booking_report.submit();
	}
	function cancelBooking(booking_id){

         var confirm_data = confirm("Are you sure you want to cancel this booking ?");
                   
                   if(confirm_data){

                   var details=prompt("Please Enter Cancellation Reason :","");
                   if(details.length>0){

                   	document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Cancel_Booking&booking_id="+booking_id+"&reason="+details;
							document.booking_report.submit();

					    	//  document.booking_report.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Cancel_Booking&no_of_items="+no_of_items+"&reason="+details;
									 // document.booking_report.submit();
					    	return true;
					    }else{
					    	return false;
					    } 

                   }else{
                    return false;
                   }


		// alert(booking_id);
		
	}


	
   
</script>

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
 <div  id="content">
<form name="booking_report" id="form"  method="post" action=""> 
<?php
	
	$config_obj=new Config_hims();
$op_validity_status=$config_obj->op_validity_status;
	
	
	$bookingInfo=$this  ->popArr['bookingInfo'];
	$doctors=$this  ->popArr['doctors'];
	
	
	
	if(!empty($this->popArr['post'])){
	
		$post=$this->popArr['post'];
		// var_dump($post);
		$from_date=$post['from_date'];
		$to_date=$post['to_date'];
		$doc_id=$post['doc_id'];
		$patient_name=$post['patient_name'];
		$place=$post['place'];
		$phone=$post['phone'];
		$status=$post['status'];
		
	}else{
	
		$from_date=date("d-m-Y");
		$to_date=date("d-m-Y");
		$doc_id=='';
		$patient_name='';
		$place='';
		$phone='';
		$status='';
	}
	
	

?>
<section class="content-header">
 
		 
          <h4><?php echo $lang_search ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

						
							<tr>	
							<td id="noborder"><?php echo $lang_from; ?> </td>
							
								<td id="noborder" ><input type="text" name="from_date" id="from_date" value="<?php echo $from_date;?>" autocomplete="off"   class="DatePicker"  readonly="true"/>
							</td>
							<td id="noborder"><?php echo $lang_to; ?> </td>
							
								<td id="noborder" ><input type="text" name="to_date" id="to_date" value="<?php echo $to_date;?>" autocomplete="off"   class="DatePicker"  readonly="true"/>
							</td>
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor" class="select2"   onkeypress="processForm();" onChange="processForm();" /> 		
									<option value=''>------------------------------</option>
											
											<?php if(!empty($doctors)){
													for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($doc_id) && $doc_id==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} 
												} ?>
									</select>
								</td>	
								
							</tr>
							<tr>
								<td id="noborder">
									<?php echo $lang_patient." ".$lang_name;?>:
								</td>
								<td id="noborder">
									<input type="text" name="patient_name" id="patient_name" value="<?php echo $patient_name;?>"/>
								</td>
								<td id="noborder">
									<?php echo $lang_place?>:
								</td>
								<td id="noborder">
									<input type="text" name="place" id="place" value="<?php echo $place;?>" />
								</td>
								<td id="noborder">
									<?php echo $lang_phone_no?>:
								</td>
								<td id="noborder">
									<input type="text" name="phone" id="phone" value="<?php echo $phone;?>" />
								</td>
							
							</tr>
							<tr>
								<td id="noborder">
										<?php echo $lang_status; ?></td>
							<td id="noborder" >	<select name="status">
									
														<option value ="0" <?php echo (isset($post['status']) && $post['status']=='0')?'selected':'';?>>Active</option>
														<option value ="1" <?php echo (isset($post['status']) && $post['status']=='1')?'selected':'';?>>Cancelled</option>
														</select>
									</td>
									<td colspan="6"></td>
							</tr>
								
							<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="processForm();"/>
									<input id="button1" type="button" name="Clear" class="btn btn-danger" value="Clear" onclick="clearForm();"/>
									</td>
							</tr>
						</table>
				
					</div>
			</div>
			
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
			<?php } ?>
			<?php if(isset($this->popArr['message1'])){?>
						<div class="callout callout-danger"><?php echo $this->popArr['message1'];?></div>
			<?php } ?>
					<br />
					<?php if($post['status'] != "1"){?>

					<div class="col-md-12 text-right">
            
                 <input type="button" name="check_all" id="check_all" class="btn btn-success check_all" value="Check/Uncheck All" style="width: auto;">&nbsp;
           
                 <input type="button" name="cancel_all_booking" id="cancel_all_booking" class="btn btn-danger cancel_all_booking" value="Cancel Booking" >
                 
            </div>&nbsp;
         <?php }?>
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_booking." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th><a href="#"><?php echo $lang_date; ?></a></th>
						 <th ><a href="#"><?php echo $lang_token_no; ?></a></th>	
						 <th ><a href="#">TOKEN TIME</a></th>
						 <th ><a href="#"><?php echo $lang_patient. " ".$lang_name; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_place; ?></a></th>
						    <th><a href="#"><?php echo $lang_phone_no; ?></a></th>
						  <?php
						 if($post['status'] != "1"){?>
  
							<th ><a href="#"><?php echo $lang_new_reg; ?></a></th>	
							<th ><a href="#"><?php echo $lang_re_reg; ?></a></th>
						
							<th><a href="#">ACTION</a></th>
							<th><a href="#">TRANSFER</a></th>
							<?php }?>
							<?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
						  	<th ><a href="#">CANCELLED BY</a></th>
					<?php }?>					                      
							                             
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		
			if(!empty($bookingInfo)){
			$j=1;
				for($i=0;$i<count($bookingInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						
					
							
							<td><?php echo	$bookingInfo[$i][3];?></td>
							<td><?php echo	$bookingInfo[$i][4];?></td>
							<td><?php echo	$bookingInfo[$i][1];?></td>
							<td><?php echo	$bookingInfo[$i][10];?></td>
							<td><?php echo	$bookingInfo[$i][6];?></td>
							<td><?php echo	$bookingInfo[$i][7];?></td>
							<td><?php echo	$bookingInfo[$i][8];?></td>

					<?php
						 if($post['status'] != "1"){

							if (date('d-m-Y')==$bookingInfo[$i][4]) {?>


								<td>
									<a href="#" onclick="redirect('<?php echo $lang_new_reg;?>','<?php echo	$bookingInfo[$i][0];?>','<?php echo	$bookingInfo[$i][4];?>');"><?php echo $lang_registration;?></a>
								</td>
								<td>
								<?php echo $lang_op_no;?>    <input type="text" id="<?php echo	$bookingInfo[$i][0];?>"  value=""  size="8" onkeypress="if(event.keyCode == 13){redirect('<?php echo $lang_process_OPNo;?>','<?php echo	$bookingInfo[$i][0];?>','<?php echo	$bookingInfo[$i][4];?>')}" />
								</td>



							<?php
							}
							else{?>
							<td></td>
							<td></td>
							<?php
							}


							?>


										
						
						<!-- <td>
							<a href="#" onClick="submitform('<?php echo $scheduling_list[$i][0];?>');"><img src="../../img/icons/user_edit.png" title="Time Schedule" width="16" height="16" /></a>
							
						</td> -->
						<td>
							
							<input type="checkbox" class="check_cancellation"  value="<?php echo $bookingInfo[$i][0]; ?>" name="select_for_cancellation[]" id="select_for_cancellation<?php echo $i;?>" title="<?php echo "ID: ".$bookingInfo[$i][0];?>">&nbsp;
							
							<!-- <input type="button" name="cancel_booking" id="cancel_booking" class="btn btn-primary btn-xs cancel_booking" value="Cancel"  style="width: auto;" onclick="cancelBooking('<?php echo $bookingInfo[$i][0]; ?>');"> -->
							
						</td>

						<td>
							<input type="button" name="transfer_booking[]" class="btn btn-info transfer_booking" value="Transfer" transfer-id="<?php echo $bookingInfo[$i][0]; ?>" transfer-name="<?php echo $bookingInfo[$i][6]; ?>" transfer-place="<?php echo $bookingInfo[$i][7]; ?>" transfer-phone="<?php echo $bookingInfo[$i][8]; ?>"  >
						</td>


					<?php }?>
							<?php if($post['status'] == "1"){ ?>						                     
						  	<td ><?php echo $bookingInfo[$i][13]; ?></td>
						  	<td><?php echo $bookingInfo[$i][11]."<br>".
						  		 date("d-m-Y h:i A",strtotime($bookingInfo[$i][12]));?>
						  	</td>
					<?php }?>

                           
					</tr>
						
				
		<?php	}
			
			}else { ?>
					
							<td colspan="11" align="center" id="lightMessage">No Records Found!</td>
					<?php } ?>		
	
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="opno" id="opno" />
	  <input type="hidden" name="cancel_all_bookings" id="cancel_all_bookings" />

	  <input type="hidden" name="transfer_id" id="transfer_id" />
	  <input type="hidden" name="transfer_name" id="transfer_name" />
	  <input type="hidden" name="transfer_place" id="transfer_place" />
	  <input type="hidden" name="transfer_phone" id="transfer_phone" />
	<input type="hidden" name="op_validity_status" id="op_validity_status" value="<?php echo (!empty($op_validity_status))?$op_validity_status:''?>">
</form>	  
</body>
	</html>
	
