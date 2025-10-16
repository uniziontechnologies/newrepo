<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$ipbillInfo=$this  ->popArr['ipbillInfo'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

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
<script type="text/javascript">


function submitform(action,id){

	
        document.patients.paction.value=action;
		document.patients.id.value=id;
   		document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=admitted_patient_report";
		document.patients.submit();
    
}
function download_pdf(){
   		$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Admitted Patient Report",
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

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 

<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_inpatient; ?></h4>
		  
        </section>
 
		<section class="content">
			<div class="DONTPrint">			 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
										</td>
										<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	<input name="ipno" id="ipno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" autocomplete="off"/>
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
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" /> 		
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
								<td id="noborder">
									<?php echo $lang_room_no; ?></td>
									<td id="noborder" >	 <input name="room_no" id="room_no" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['room_no']))?$post['room_no']:''?>" autocomplete="off"/> 
								 
								</td>
								</tr>
								<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
                	<h3 >
						<?php echo $lang_addmitted_patient." ".$lang_list; ?> From <?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?> To <?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>
						</a>
                       
					
					</h3>
					<div align="left"><?php echo !empty($post['ipno'])?"IPNO : ".$post['ipno']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['opno'])?"OPNO : ".$post['opno']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['doc_name'])?"Doctor : ".$post['doc_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['room_no'])?"Room No : ".$post['room_no']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_addmitted_patient." ".$lang_list; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_op_no; ?></a></th>												
						<th ><a href="#"><?php echo $lang_patient_category; ?></a></th> 
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						<th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                        <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
					     <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						 <th><a href="#"><?php echo $lang_room_no;?></a></th>							
						 <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_total_amount; ?></a></th>
						 <th><a href="#"><?php echo $lang_amount_paid;?> SO FAR</a></th>							
						 <th><a href="#"><?php echo $lang_balance; ?></a></th>
						 <th><a href="#"><?php echo $lang_bill_status; ?></a></th>
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		$total_amt=0;
		$amount_paid=0;
		$balance=0;
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
						<td>
							<?php 
							if($patientInfo[$i][54]){
								echo	$patientInfo[$i][54];
								if($patientInfo[$i][62]){
									echo "<br> Member ID : ".$patientInfo[$i][62];
								}
							}
							?>
						</td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						<td><?php echo $ipbillInfo[$i][0];?></td>
						<td><?php echo $ipbillInfo[$i][1];?></td>
						<td><?php echo $ipbillInfo[$i][2];?></td>
						<td><?php echo ($patientInfo[$i][51] == 2)?'Bill Ready':'';?></td>
						
						
                           
					</tr>
						
				
		<?php
		$total_amt +=$ipbillInfo[$i][0];
		$amount_paid +=$ipbillInfo[$i][1];
		$balance +=$ipbillInfo[$i][2];

			}
			
			}		
		?>
					</tbody>
					<tfoot>

						<tr>
						<td colspan="12" align="right"><b>Total</b></td>
						<td><b><?php echo round($total_amt);?></b></td>
						<td><b><?php echo round($amount_paid);?></b></td>
						<td><b><?php echo round($balance);?></b></td>
						
						
						
					</tr>
						
					</tfoot>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>

<?php

if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()"></div>
  		
<?php
}
?>
	  


	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="admitted_patient_report" value="admitted_patient_report" />
  
</form>
</body>
</html>
