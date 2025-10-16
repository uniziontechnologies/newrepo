<?php
	
	$bookingInfo=$this  ->popArr['bookingInfo'];
	$doctors=$this  ->popArr['doctors'];
	
	if(!empty($this->popArr['post'])){
	
		$post=$this->popArr['post'];
		$from_date=$post['from_date'];
		$to_date=$post['to_date'];
		$doc_id=$post['doctor'];
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
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>

		 <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
	 <script>
	 	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 $('.hide_div').hide();
	  });
	  </script>
<script>

   function submitform(id){
   
	
		setAction('',id);	
   		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Report&sub_module=Scheduling_Form";
		document.manage_scheduling.submit();
   }
   function processForm(){
	
	
	
		document.booking_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=Booking_Report";
		document.booking_report.submit();
		
		
	}
	function clearForm(){
	
		
		document.booking_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=Booking_Report&paction=clear_form";
		document.booking_report.submit();
		
	}
   function download_pdf(){
   	$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Booking Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.booking_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.booking_report.submit();

   }
	
   
</script>

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
 <div  id="content">
<form name="booking_report" id="form"  method="post" action=""> 

<section class="content-header">
 
		 
          <h4><?php echo $lang_search ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

						
							<tr>	
							<td id="noborder"><?php echo $lang_from; ?> </td>
							
								<td id="noborder" ><input type="text" name="from_date" id="from_date" value="<?php echo $from_date;?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keyCode == 13){processForm()}" readonly="true"/>
							</td>
							<td id="noborder"><?php echo $lang_to; ?> </td>
							
								<td id="noborder" ><input type="text" name="to_date" id="to_date" value="<?php echo $to_date;?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keyCode == 13){processForm()}" readonly="true"/>
							</td>
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="processForm();" onChange="processForm();" class="select2" /> 		
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
									<input type="text" name="patient_name" id="patient_name" value="<?php echo $patient_name;?>" />
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
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                      <h4 ><?php echo $lang_booking." ".$lang_report; ?> From <?php echo $from_date;?> To <?php echo $to_date;?>
			
			</h4>
				<div align="left"><?php echo !empty($post['doctor_name'])?"Doctor : ".$post['doctor_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':"";?>
				<?php echo !empty($post['patient_name'])?"$lang_patient $lang_name : ".$post['patient_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['place'])?"$lang_place : ".$post['place']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				<?php echo !empty($post['phone'])?"$lang_phone_no : ".$post['phone']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				Report Date : <?php echo date("d-m-Y");;?>
				</div>	
					    
                    </div>	
                
               <div class="box-body">
			   


	


			   
			     <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse; ">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_booking." ".$lang_report; ?> <?php if (!empty($post['from_date'])) {
		echo "From ".$post['from_date'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th><a href="#"><?php echo $lang_date; ?></a></th>
						 <th ><a href="#"><?php echo $lang_token_no; ?></a></th>	
						 <th ><a href="#"><?php echo $lang_patient. " ".$lang_name; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_place; ?></a></th>
						    <th><a href="#"><?php echo $lang_phone_no; ?></a></th>
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
							<td><?php echo	$bookingInfo[$i][6];?></td>
							<td><?php echo	$bookingInfo[$i][7];?></td>
							<td><?php echo	$bookingInfo[$i][8];?></td>
							<?php if($post['status'] == "1"){ ?>						                     
						  	<td ><?php echo $bookingInfo[$i][13]; ?></td>
						  	<td><?php echo $bookingInfo[$i][11]."<br>".
						  		 date("d-m-Y h:i A",strtotime($bookingInfo[$i][12]));?>
						  	</td>
					<?php }?>
							
                           
					</tr>
						
				
		<?php	}
			
			}else { ?>
					
							<td colspan="8" align="center" id="lightMessage">No Records Found!</td>
					<?php } ?>		
	
					</tbody>
				</table>
			</div>
				</div>
				
<?php

if (empty($post['pdf'])) {?>

			 <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
				
            </div>
<?php
}
?>

           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="opno" id="opno" />
	  <input type="hidden" name="page_name" id="booking_report" value="booking_report" />
	
</form>	  
</body>
	</html>
	
