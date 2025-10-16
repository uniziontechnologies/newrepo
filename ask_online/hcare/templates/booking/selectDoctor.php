<?php session_start();
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
$comm_obj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">

	<script src="../../dist/js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
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
	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#date').datepicker();
		
	  });
	  </script>
		
<script>

   function submitform(id){
   
	
		setAction('',id);	
   		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form";
		document.manage_scheduling.submit();
   }
   function processForm(){
	
	checktrue=0;
	count=0;
	with (document.select_doctor) {
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox' && elements[i].checked == true) {
					checktrue=1;
					docid=elements[i].value;
					count++;
				}
			}
		}
		if(checktrue == 0){
		
			showDialog('Error','Please Select a Doctor.','error',2);
				return false;
		}else if(count >1){
			showDialog('Error','Select Atleat One Doctor.','error',2);
				return false;
		}else{
		
			date=document.select_doctor.date.value;
			url='doctors_next_available.php?docname='+docid+'&date='+date;	
			window.open(url,'Doctors next Available Date','height=400,width=250,left = 362,top = 234');
			
		/*document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Manage_Scheduling&View=View";
		document.manage_scheduling.submit();*/
		}
		
		
	}
	function searchForm(){
	
		document.select_doctor.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking&View=View";
		document.select_doctor.submit();
	}
	function clearForm(){
	
		document.select_doctor.department.value='';
		document.select_doctor.date.value='';
		document.select_doctor.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking&View=View";
		document.select_doctor.submit();
	}
	function closedStatus(doctor){
	
				showDialog('Error','Booking is Closed For '+doctor+'.','error',2);
				return false;
	}
	function nextAvailDates(docid){
	
		document.select_doctor.id.value=docid;
		document.select_doctor.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking";
		document.select_doctor.submit();
	}
	function redirect(docid){
	
		document.select_doctor.id.value=docid;
		document.select_doctor.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking_Form";
		
		
		document.select_doctor.submit();
	}
	function selectDate(date,docid){
	
		document.select_doctor.date.value=date;
		redirect(docid);
	}
	
   
</script>

</head>
<body id="frame">
<form name="select_doctor" id="form"  method="post" action=""> 
<?php
	
	
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$departments=$this  ->popArr['departments'];
	
	$dep_id='';
	
	if(!empty($this->popArr['dep_id'])){
		$dep_id=$this->popArr['dep_id'];
	}
	if(!empty($post['date'])) {
		$date=$post['date'];
	}else $date=date('d-m-Y');


?>
<section class="content-header">
          <h4><?php echo $lang_search; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
						<tr>	
							<td id="noborder">
							<?php echo $lang_department; ?> </td>
								<td id="noborder" ><select name="department" id="department"   onkeypress="searchForm();" onChange="searchForm();"/> 		
									<option value=''>------------------------------</option>
											
											<?php if(!empty($departments)){
													
													for($i=0;$i<count($departments);$i++){ 
																						
													if(!empty($dep_id) && $dep_id==$departments[$i][0]) { ?>
													
														<option value='<?php echo $departments[$i][0];?>' selected><?php echo $departments[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $departments[$i][0];?>'><?php echo  $departments[$i][1];?></option>
												
										<?php 		} 
												} 
												} ?>
									</select>
							</td>		
							
							<td id="noborder">
							<?php echo $lang_date; ?> </td>
								<td id="noborder" ><input type="text" name="date" id="date" value="<?php echo $date;?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/>
							</td>	
								
									
									<td id="noborder"  align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="searchForm();"/>
								&nbsp;&nbsp;&nbsp;&nbsp;
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-danger" onclick="clearForm();"/>
									</td>
								</tr>
								</table>
				
					</div>
			</div>
		
       			
                	<h3 ><?php echo $lang_doctor." ".$lang_list; ?>			</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message' class="callout callout-danger"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="row">
                   <div class="col-md-6">
										
			        <div class="box box-info ">
                     <div class="box-header with-border">	
								
						<table  class="table table-striped">	
				       <thead>
						<th><?php echo $lang_doctor;?></th>
						<th><?php echo $lang_consultation;?></th>
						<th><?php echo $lang_next;?></th>
						
					<?php
						/*for($l=0;$l<=5;$l++) {
						
						echo "<th>".date('d-m-Y',(strtotime($date)+($l*24*3600)))."</th>";
						
					}*/ ?>
				<tbody>
				
					<?php if(!empty($doctors)){
							for($i=0;$i<count($doctors);$i++){
							$shift_start='';
							 ?>
							
					
						<tr>
					
							<td>
									
										
									<?php
										if(!empty($doctors[$i][2]) ){
											
											$shift_start=$doctors[$i][2];
										}
										if(empty($doctors[$i][2]) && !empty($doctors[$i][4])){
											
											$shift_start=$doctors[$i][4];
										}
										
										$currenttime=$comm_obj->getcurrentTime("h:i a");
									?>	
									<a href="#" onclick="redirect('<?php echo $doctors[$i][0];?>');"><?php echo $doctors[$i][1];?></a>
									
									<?php
									/*if(strtotime($date." ".$shift_start) > (strtotime($currenttime)+1800)){
									?>
										<a href="#" onclick="redirect('<?php echo $doctors[$i][0];?>');"><?php echo $doctors[$i][1];?></a>
									<?php }else {?>
									
										<a href="#" onclick="closedStatus('<?php echo $doctors[$i][1];?>');"><?php echo $doctors[$i][1];?></a>
									<?php } */ ?>
							</td>
							<td>
										<?php if(!empty($doctors[$i][2])){
										
												echo $doctors[$i][2]." - ".$doctors[$i][3];
												
										} ?>
										
										<?php if(!empty($doctors[$i][2]) && !empty($doctors[$i][4])){
											echo ' <br> ';
											
										}
										
										
										
										
										?>
										<?php if(!empty($doctors[$i][4])){
										
												echo $doctors[$i][4]." - ".$doctors[$i][5];
												
										} ?>
										
								</td>
								<td>
										

											<a href="#" onclick="nextAvailDates('<?php echo $doctors[$i][0];?>')" class="thickbox none" title="New Item">
											Next Dates</a>		

										
										<!--<a href="#" onclick="nextAvailDates('<?php echo $doctors[$i][0];?>')">Next Available Dates</a>-->
										
									
									</td>
									
						
								</tr>
						
                            
							
					<?php	}
					
						}
					?>
					
						</tbody>
						
				</table>
			</div>
		</div>
	</div>
			<?php if(!empty($this->popArr['dateAvaillability'])) { 
				$dateInfo=$this->popArr['dateAvaillability'];
				$docid=$this->popArr['docid'];
				$docname=$this->popArr['docname'];
				$j=0;
			?>
			 <div class="col-md-6">
						<div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $docname; ?> Next Available Dates</h3>
					    
                           </div>	
                           <div class="box-body">
							 
							 <table  class="table table-striped">	
							
								<?php for($i=0;$i<count($dateInfo);$i++){ 
									$j++;
									if($j==1) { 
								?>
									<tr>
								<?php } ?>
										<td><a href="#" onclick="selectDate('<?php echo $dateInfo[$i];?>','<?php echo $docid;?>');"><?php echo $dateInfo[$i];?></a></td>
								<?php
									if($j%3==0) {
									$j=0; 
								?>
									</tr>
								<?php } ?>
								<?php } ?>
							</table>
						
						</div>
						
						
			<?php } ?>
						
				</div>
				
			
				
            </div>
           
      </div>
	</section>
	  <input type="hidden" name="id" id="id" />

	  <input type="hidden" name="transfer_id" id="transfer_id" value="<?php echo !empty($post['transfer_id'])?$post['transfer_id']:''; ?>" />
	  <input type="hidden" name="transfer_name" id="transfer_name" value="<?php echo !empty($post['transfer_name'])?$post['transfer_name']:''; ?>" />
	  <input type="hidden" name="transfer_place" id="transfer_place" value="<?php echo !empty($post['transfer_place'])?$post['transfer_place']:''; ?>" />
	  <input type="hidden" name="transfer_phone" id="transfer_phone" value="<?php echo !empty($post['transfer_phone'])?$post['transfer_phone']:''; ?>" />
	  
	
</form>	  
</body>
	</html>
	
