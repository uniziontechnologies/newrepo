<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
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
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   <script type="text/javascript" src="../../dist/js/common_functions.js"></script>
	 <!-- jQuery 2.1.4 -->
   <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<script>
  
   function changeStatus(){
   	
	if(document.scheduling_form.show.value == "Block"){
	
		var a=confirm("Do u want to Block Doctor!");
	}else{
	
		var a=confirm("Do u want to Activate Doctor!");
	}
		
  		 if(a==true)
   			{
				document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form&action=BLOCK";
				document.scheduling_form.submit();
				

			}else{
				return false;
			}
   
   }
   function submitForm(){
   		
   		if(document.getElementById('ALL').checked==false) {
   			
	   		if(document.scheduling_form.cons_time.value=='' || document.scheduling_form.cons_time.value==0){
					showDialog('Error','Please Enter Consultation Time.','error',2);
					return false;
			}else if(document.scheduling_form.cons_time.value!='' && !(isNumeric(document.scheduling_form.cons_time.value))){
					showDialog('Error','Please Enter Valid Consultation Period.','error',2);
					return false;
			}else if(document.scheduling_form.bk_limit.value!='' && !(isNumeric(document.scheduling_form.bk_limit.value))){
					showDialog('Error','Please Enter Valid Booking Limit.','error',2);
					return false;
			}else {
				
				check=checkTime();
				if(check){
				
					showDialog('Success','Updated Successfully.','success',2);
					
					
	   				document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form";
					document.scheduling_form.submit();
				}
			
			}


   		}
   		else{

   			var status = 0;

			var allselects= document.getElementsByClassName('first');
			var L= allselects.length;

			var allselects2= document.getElementsByClassName('second');
			var M= allselects2.length;

			for(var i=0;i<L;i++){

			var tem= allselects[i];
			var temname= tem.name;
			var temIndex= tem.selectedIndex;
			var temValue= tem.options[temIndex].value;

			var tem2= allselects2[i];
			var temname2= tem2.name;
			var temIndex2= tem2.selectedIndex;
			var temValue2= tem2.options[temIndex2].value;

				if (temValue=="" && temValue2=="") {
				showDialog('Error','Timing slot cannot be empty','error',2);
				var status = 1;
				return false;	
				}

			}

			if (status==0) {

					showDialog('Success','Updated Successfully.','success',2);
					
					
	   				document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form";
					document.scheduling_form.submit();

			}

   		}



   
   }
   function checkTime(){
   		//var subfield=new Array("sun","mon","tue","wed","thu","fri","sat");
		checktrue=0;
		with (document.scheduling_form) {
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox' && elements[i].checked == true) {
				
					checktrue=1;
					field=((elements[i].value).substr(0,3)).toLowerCase();
					
					
					if((document.getElementById(field+'_fs').value =='') && (document.getElementById(field+'_ss').value =='')){
					
						showDialog('Error','Please select Valid Time For '+elements[i].value,'error',2);
						return false;
					
					}
					
				}
			}
		}
		if(checktrue ==0){
		
			showDialog('Error','Please select Atleast One Day!','error',2);
			return false;
		}
		
   		return true;
   }
   function doHandleSub(e,field)
	{
		if(e.checked == true){
		
			document.getElementById(field+'_fs').disabled = false;
			document.getElementById(field+'_fe').disabled = false;
			document.getElementById(field+'_ss').disabled = false;
			document.getElementById(field+'_se').disabled = false;
		}else if(e.checked == false){
		
			document.getElementById(field+'_fs').disabled = true;
			document.getElementById(field+'_fe').disabled = true;
			document.getElementById(field+'_ss').disabled = true;
			document.getElementById(field+'_se').disabled = true;
		}
	}
   function doHandleAll()
	{
		with (document.scheduling_form) {
			if(elements['ALL'].checked == false){
				doUnCheckAll();
			}
			else if(elements['ALL'].checked == true){
				doCheckAll();
			}
		}
	}

	function doCheckAll()
	{
		with (document.scheduling_form) {
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox') {
					elements[i].checked = true;
				}
				if (elements[i].type == 'select-one') {
					elements[i].disabled = false;
				}
			}
		}
	}

	function doUnCheckAll()
	{
		with (document.scheduling_form) {
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox') {
					elements[i].checked = false;
				}
				if (elements[i].type == 'select-one') {
					elements[i].disabled = true;
				}
			}
		}
	}

	function save_blocked_date() {


		if( document.scheduling_form.blocked_date.value == "" ){
		
			showDialog('Error','Please select a Blocking Date !','error',2);
			return false;
		}
		else{

		   	document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=save_blocked_date";
			document.scheduling_form.submit();

		}

		


	}

	function showMore() {
		
	   	document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form&View=View";
		document.scheduling_form.submit();

	}

$(document).ready(function(){

  $(".delete_date").click(function(){
    
    var delete_id = $(this).attr("id");

    
    if (delete_id > 0) {

    	var a =confirm("Are you sure to delete ?");

    	if (a == true) {

    		var details=prompt("Please Enter Cancellation Details:","");

    		if (details!=null) {
    			document.scheduling_form.cancellation_details.value=details;
    		}
    		else{
    			return false;
    		}

    		document.scheduling_form.delete_id.value=delete_id;

			document.scheduling_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=delete_blocked_date";
			document.scheduling_form.submit();


    	}
    	else{
    		return false;
    	}



    }


  });

});

	
</script>

</head>
<body id="frame" >
<div  id="content">
<form name="scheduling_form" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$id = $this->popArr['id'];
	$days=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	
	$doctor=$this->popArr['doctor'];
	$scheduling_info=$this->popArr['scheduling_info'];

	$blocked_dates=$this->popArr['blocked_dates'];
	$limit_status=$this->popArr['limit_status'];
	
?>
<section class="content-header">
          
           <h3  ><?php echo $lang_scheduling." OF ".$doctor[0][1].".".$doctor[0][2]." ".$doctor[0][3];?></h3>
        </section>
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
				
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		 <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
							<tr>
								<td id="noborder">
									<?php echo $lang_cons_time; ?>:
									
									 <input name="cons_time" id="cons_time"  onkeypress="nextField(event.keyCode,bk_limit)" value="<?php echo isset($scheduling_info[0][2])?$scheduling_info[0][2]:'';?>" autocomplete="off" size="5"/>
									 <?php echo $lang_min; ?>
								</td>
								<td id="noborder">
									<?php echo $lang_bk_limit; ?>:
									
									 <input name="bk_limit" id="bk_limit"  onkeypress="nextField(event.keyCode,bk_limit)" value="<?php echo isset($scheduling_info[0][3])?$scheduling_info[0][3]:'';?>" autocomplete="off"size="5"/>
									
								</td>
								<td id="noborder">
								<?php if(isset($scheduling_info[0][4]) && $scheduling_info[0][4] == "Active"){?>
								<input type="hidden" name="status" value="Active" />
									<input id="button1" type="button" name="show" value="Block" class="btn btn-danger" onclick="return changeStatus()"/>
									
								<?php }elseif(isset($scheduling_info[0][4]) && $scheduling_info[0][4] == "Blocked"){?>
									<input type="hidden" name="status" value="Blocked" />
									<input id="button1" type="button" name="show" class="btn btn-success" value="Activate" onclick="return changeStatus()"/>
									
								<?php } ?>
								</td>
								
							</tr>
						</table>
						
			<div class="box box-info">
			
			 
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped" id="check_table">
							<thead>
								<tr>
                          			<th ><input type="checkbox" name="ALL" id="ALL" onclick="doHandleAll();"/>&nbsp;<?php echo $lang_all; ?></th>
									<th ><?php echo $lang_first_shift; ?></th>
									<th ><?php echo $lang_second_shift; ?></th>
								</tr>
							</thead>
							<tbody>
								
									
										<?php 
										$n=5;
										for($m=0;$m<count($days);$m++) {
										
											$field=strtolower(substr($days[$m],0,3));
										?>
									<tr>
										<td>
										<input type="checkbox" name="checkD[]" id="checkD[]" value="<?php echo $days[$m];?>" <?php echo (!empty($scheduling_info[0][$n]) || !empty($scheduling_info[0][$n+2]))?'checked':'';?> onclick="doHandleSub(this,'<?php echo $field;?>')"/><?php echo $days[$m];?>
										
										</td>
										
										<td>
										<?php echo $lang_from; ?>:&nbsp;
										<select name="<?php echo $field."_fs";?>" class="first" id="<?php echo $field."_fs";?>" <?php echo (!empty($scheduling_info[0][$n]) || !empty($scheduling_info[0][$n+2]))?'':'disabled';?>>
										
										
										<?php if(!empty($scheduling_info[0][$n])) {$commObj->gettimeOPtionValues($scheduling_info[0][$n]);}
												else $commObj->gettimeOPtionValues();
										?>
										
										</select>
										<?php echo $lang_to; ?>:&nbsp;
										<select name="<?php echo $field."_fe";?>" class="first" id="<?php echo $field."_fe";?>" <?php echo (!empty($scheduling_info[0][$n]) || !empty($scheduling_info[0][$n+2]))?'':'disabled';?>>
										
										<?php if(!empty($scheduling_info[0][$n+1])) {$commObj->gettimeOPtionValues($scheduling_info[0][$n+1]);}
												else $commObj->gettimeOPtionValues();
										?>
										
										
										</select>
									</td>
									<td>
										<?php echo $lang_from; ?>:&nbsp;
										<select name="<?php echo $field."_ss";?>" class="second" id="<?php echo $field."_ss";?>" <?php echo (!empty($scheduling_info[0][$n]) || !empty($scheduling_info[0][$n+2]))?'':'disabled';?>>
										
										
										<?php if(!empty($scheduling_info[0][$n+2])) {$commObj->gettimeOPtionValues($scheduling_info[0][$n+2]);}
												else $commObj->gettimeOPtionValues();
										?>
										
										</select>
										<?php echo $lang_to; ?>:&nbsp;
										<select name="<?php echo $field."_se";?>" class="second" id="<?php echo $field."_se";?>" <?php echo (!empty($scheduling_info[0][$n]) || !empty($scheduling_info[0][$n+2]))?'':'disabled';?>>
										
										<?php if(!empty($scheduling_info[0][$n+3])) {$commObj->gettimeOPtionValues($scheduling_info[0][$n+3]);}
												else $commObj->gettimeOPtionValues();
										?>
										
										
										</select>
									</td>
								</tr>
										<?php
												$n=$n+4;
										}?>
										
								
						
						</tbody>
					</table>
						
					</DIV>	
						
					   
				</fieldset>				
				
				
					<div align="center">
					
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" value="Add" class="btn btn-success" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" value="Update" class="btn btn-success" onclick="return submitForm()"/>
					<?php } ?>
					
					 </div>
					 <br>
					
				</div>
			
				
            </div>
           


		<div class="box box-info">
                
          <div class="box-body">



			<div class="row">
					
				<div class="col-md-6">

					<table class="table">
						
						<h4>BLOCK DATE</h4>

						<tr>
							<td><?php echo 'BLOCK BOOKING DATE ON'; ?></td>
							<td><input type="date" name="blocked_date" id="blocked_date" style="    width: 59%;"></td>
						</tr>

						<tr>
							<td><?php echo $lang_remarks; ?></td>
							<td><textarea id="blocked_remarks" name="blocked_remarks" class="blocked_remarks"></textarea></td>
						</tr>

						<tr>
							<td></td>
							<td><input type="button" class="btn btn-danger" name="save_block_date" id="save_block_date" value="Block Date" onclick="save_blocked_date();"></td>
						</tr>


					</table>



				</div>

				<div class="col-md-6">
					
					<table class="table">
						
						<h4>BLOCKED DATES</h4>

						<thead>
							<th>SL NO</th>
							<th>BLOCKED DATE</th>
							<th>REMARKS</th>
							<th>ACTION</th>
						</thead>

						<tbody>
							
							<?php

								$j=1;

								if (!empty($blocked_dates)) {
									
									for ($i=0; $i < count($blocked_dates) ; $i++) {?> 

										<tr>
											<td><?php echo $j++; ?></td>
											<td><?php echo date("d-m-Y",strtotime($blocked_dates[$i][2])); ?></td>
											<td><?php echo $blocked_dates[$i][3]; ?></td>
											<td>

												<a href="#" class="delete_date btn btn-danger btn-flat btn-sm" id="<?php echo $blocked_dates[$i][0]; ?>"><i class="fa fa-remove"></i></a>

											</td>
										</tr>

									<?php
									}

								}

							 ?>

							 <?php 

							 	if ( !empty($limit_status)) {?>

									 <tr>
									 	<td>
									 		<div class="text-center"><div class="text-center btn btn-success show-more"><a href="#" style="color: white;" id="show_more" onclick="showMore();">Show More</a></div></div>
									 	</td>
									 </tr>

							 	<?php
							 	}

							 ?>



						</tbody>

					</table>

				</div>

			</div>





          </div>
			   		
		</div>




      </div>
	</section>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
	   <input name="count" id="count" type="hidden" value="<?php if(!empty($blocked_dates)){
	   	echo count($blocked_dates);
	   }else{echo 0;} ?>" />
	   <input type="hidden" name="cancellation_details" id="cancellation_details" />
	   <input type="hidden" name="delete_id" id="delete_id" />
</form>	 
</div> 
</body>
	</html>
	
