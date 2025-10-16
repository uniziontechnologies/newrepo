<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

	$user=$this  ->popArr['user'];
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
	<link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
	 <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
	 
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../../plugins/timepicker/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		  $(".timepicker").timepicker({showInputs: false,defaultTime: false});
		  $('.hide_div').hide();
		  
		  var new_row="<tr><td><b>NEW:&nbsp;&nbsp;"+$('#new').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>VISIT:&nbsp;&nbsp;"+$('#visit').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>REVISIT:&nbsp;&nbsp;"+$('#revisit').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>FREE:&nbsp;&nbsp;"+$('#free').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>HEALTHCHECKUP:&nbsp;&nbsp;"+$('#health_checkup').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><b>Dr Fee:&nbsp;&nbsp;"+$('#dr_fee').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Reg Fee:&nbsp;&nbsp;"+$('#reg_fee').val()+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Card fee:&nbsp;&nbsp;"+$('#card_fee').val()+"</td></tr>";
	      $( "#show_total" ).append(new_row);
	  });

   $(function() {

    //This submits a form
	 $(".op_payment").on('change', function(event){

	 	var visit_id = this.id;
	 	var value    = this.value;
	 	var checked  = this.checked;

	 	if (checked==true) {
	 		checked = 1;
	 	}
	 	else{
	 		checked = 0;
	 	}
	
	        $.ajax({ 
	            type: "POST",
	            url: "../../lib/controllers/centralController.php?module=Registration&sub_module=save_payment_status",
	            data: {id:visit_id,value:value,checked:checked},
	            // beforeSend: function() {
	            //     $('#result').html('<img src="loading.gif" />');
	            // },
	            success: function(data) {
	            	// alert(data);
	                // $('#result').html(data);
	               location.reload(); 
	            }

	        });
	    });
	});

	  </script>
<script>

   function submitform(action,id){
   	
	
	    if(document.patients.from_time.value == "" && document.patients.to_time.value != ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else if(document.patients.from_time.value != "" && document.patients.to_time.value == ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else{
		setAction(action,id);
   		document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=patient_report_not_paid";
	
		document.patients.submit();
	 }
   }
   
   function clear_form(){

   		window.location.href = "../../lib/controllers/centralController.php?module=Report&sub_module=patient_report_not_paid";

   }
   
   
</script>
<script type="text/javascript">


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
					filename: "Op Patient Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.patients.submit();

   }


</script>
<style type="text/css">
	.not_paid{
		color: #e03333;
		font-weight: 700;
	}
	.paid{
		color: green;
		font-weight: 700;
	}
</style>

</head>
<body id="content">
<form name="patients" id="form"  method="post" action=""> 

 <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search; ?></h4>
		  
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
										    <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>	
											
										</td>
										<td id="noborder">
										<?php echo $lang_op_no; ?></td>
									<td id="noborder" >	<input name="opno" id="opno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" autocomplete="off"/>
									</td>
								</tr>
								<tr>
								
								<td id="noborder">
									<?php echo $lang_first_name; ?></td>
									<td id="noborder" >	 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['first_name']))?$post['first_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">							
								
								<?php echo $lang_place; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" /> 	 
							</td>
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" style="width: 196px;" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
								
								</tr>
								<tr>	


<!-- 									<td id="noborder">		
										<?php echo $lang_gender; ?>  :
									</td>
									<td id="noborder">			
												<select name="gender" onkeypress="nextField(event.keyCode,place)">
													<option value="">-----------------------------</option>
													<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
													<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
												</select>
										 
									</td> -->

							<!-- 		<td id="noborder">
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/> 		
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
							</td> -->
							

									<td id="noborder">		
										<?php echo 'STATUS'; ?>  :
									</td>
									<td id="noborder">			
												<select name="paid_status" onkeypress="nextField(event.keyCode,place)">
													<option value="">-----------------------------</option>
													<option <?php echo (isset($post['paid_status']) && $post['paid_status']==1)?'selected':''?> value="1">PAID</option>
													<option <?php echo (isset($post['paid_status']) && $post['paid_status']==0)?'selected':''?> value="0">NOT PAID</option>
												</select>
										 
									</td>


								</tr>
								<tr>
									
									<td id="noborder" colspan="5" align="center" style="padding-left: 20%;padding-top: 20px;">
									
								
							
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear"  class="btn btn-info" onclick="clear_form();"/>
									</td>

								</tr>
						</table>
				
					</div>
			</div>
		</div>
			<h4 ><?php echo $lang_op_patients." ".$lang_list; ?> From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?>
			
			</h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
				<br>
               <table width="80%" >
				<thead>
					<tr>
						 <th ><a href="#">Patients Visited</a></th><th ><a href="#">Total Fees collected</a></th>
					</tr>
				</thead>
				<tbody id="show_total">
					
				</tbody>
				</table>				
			<div class="box box-info">
                       <div class="box-body">


	


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
       			
				<thead>
					<tr><th>
						<h4 class="hide_div"><?php echo $lang_op_patients." ".$lang_list; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4>
					</th></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th><a href="#"><?php echo $lang_op_no; ?></a></th>						 
						 <th ><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						 <th ><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th ><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_place; ?></a></th>
                           <th><a href="#"><?php echo $lang_contact_no; ?></a></th>
						    <th ><a href="#"><?php echo $lang_date; ?></a></th>
							<th ><a href="#"><?php echo $lang_time; ?></a></th>
						    <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
							 <th ><a href="#"><?php echo $lang_dr." ".$lang_fees; ?></a></th>
							   <th ><a href="#"><?php echo $lang_reg_fee; ?></a></th>
							   <th ><a href="#"><?php echo $lang_card_fee; ?></a></th>
							  <th ><a href="#"><?php echo $lang_visit_status; ?></a></th>
							  <th ><a href="#">Payment Status</a></th>   
							  <th ><a href="#">Pay</a></th>                         
							                               
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		$free=0;
		$visit=0;
		$revisit=0;
		$new=0;
		$dr_fee=0;
		$reg_fee=0;
		$card_fee=0;
		$health_checkup=0;
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][0];?></td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2];//." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][10];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td><td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
						<td><?php echo $patientInfo[$i][17];?></td>
						<td><?php echo $patientInfo[$i][18];?></td>
						<td><?php echo $patientInfo[$i][52];?></td>
						<td>
							<?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?></td>
						
						<td>
								

								<?php 

									if ($patientInfo[$i][91]==1) {?>
										<span class="paid">PAID</span>
									<?php
									}
									else{?>
										<span class="not_paid">NOT PAID</span>
									<?php
									}

								?>


						</td>
						

						<td>

							<?php 

								// if ($patientInfo[$i][91]==0) {?>
									<input type="checkbox" name="op_payment[]" value="1" id="<?php echo $patientInfo[$i][13]; ?>" class="op_payment" <?php echo (!empty($patientInfo[$i][91]) && ($patientInfo[$i][91]==1))?'checked':'' ?> >
								<?php
								// }
								// else{?>
									<!-- <input type="checkbox" checked disabled > -->
								<?php
								// }

							?>

						</td>
					
                           
					</tr>
						
				<?php
				
						if($patientInfo[$i][41] == 1) $free +=1;
						else if($patientInfo[$i][58] == 'YES') $health_checkup +=1;
						else if($patientInfo[$i][32] == "VISIT") $visit +=1;
						else if($patientInfo[$i][32] == "REVISIT") $revisit +=1;
						else $new +=1;
						
						if ($patientInfo[$i][91]==1) {
							$dr_fee +=$patientInfo[$i][17];
							$reg_fee +=$patientInfo[$i][18];
							$card_fee +=$patientInfo[$i][52];
						}


				?>
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
				
			</div>
				</div>
				
		<input type="hidden" name="new" id="new" value="<?php echo $new;?>"/>
		<input type="hidden" name="visit" id="visit" value="<?php echo $visit;?>"/>
		<input type="hidden" name="revisit" id="revisit" value="<?php echo $revisit;?>"/>
		<input type="hidden" name="free" id="free" value="<?php echo $free;?>"/>
		<input type="hidden" name="health_checkup" id="health_checkup" value="<?php echo $health_checkup;?>"/>
		<input type="hidden" name="dr_fee" id="dr_fee" value="<?php echo $dr_fee;?>"/>	
		<input type="hidden" name="reg_fee" id="reg_fee" value="<?php echo $reg_fee;?>"/>	
	    <input type="hidden" name="card_fee" id="card_fee" value="<?php echo $card_fee;?>"/>	
	
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="patient_report_not_paid" value="patient_report_not_paid" />
	 
	 <?php if(!isset($_POST['export']) && empty($post['pdf']))
{?>
<div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
</div>

<?php }?>
</section>	 
</form>	  

</body>
	</html>
