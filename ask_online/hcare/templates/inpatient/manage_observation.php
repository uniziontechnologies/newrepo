<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];

if (!empty($post['pdf'])) {

ob_start();
			
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

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		  $(".timepicker").timepicker({showInputs: false,defaultTime: false});
		  
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
   		document.patients.action="../../lib/controllers/centralController.php?module=IP&sub_module=manage_observation";
	
		document.patients.submit();
	 }
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
   	
		document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		document.patients.submit();

   }
   function print_bill(billid){
   

	  document.patients.billid.value=billid;
	  document.patients.no_action.value="YES";
      document.patients.action="../../lib/controllers/centralController.php?module=Billing&sub_module=discharge_observation";
	  document.patients.submit();
   }
   function clear_form(){

   		window.location.href ="../../lib/controllers/centralController.php?module=IP&sub_module=manage_observation";

   }


</script>


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


									<td id="noborder">		
										<?php echo $lang_gender; ?>  :
									</td>
									<td id="noborder">			
												<select name="gender" onkeypress="nextField(event.keyCode,place)" style="width: 196px;" >
													<option value="">-----------------------------</option>
													<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
													<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
												</select>
										 
									</td>

	
							

								</tr>
								<tr>
									
									<td id="noborder" colspan="5" align="center" style="padding-left: 20%;padding-top: 20px;">
							
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear"  class="btn btn-info" onclick="clear_form();"/>
									</td>

								</tr>
						</table>
				
					</div>
			</div>
		</div>
			<h4 >

				<?php 

					(!empty($post['from_date'])) ? $from_date_echo =$post['from_date'] : $from_date_echo =date('d-m-Y') ;
					(!empty($post['to_date'])) ? $to_date_echo =$post['to_date'] : $to_date_echo =date('d-m-Y') ;

					(!empty($post['from_time'])) ? $from_time_echo =$post['from_time'] : $from_time_echo ='' ;
					
					(!empty($post['to_time'])) ? $to_time_echo =$post['to_time'] : $to_time_echo ='' ;

				 		echo "OBSERVATION"." ".$lang_list; ?> From <?php echo $from_date_echo. " ".$from_time_echo;?> To <?php echo $to_date_echo." ".$to_time_echo;

				?>

			</h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
				<br>
				
			<div class="box box-info">
                       <div class="box-body">

<?php

if (!empty($post['pdf'])) {
ob_end_clean();
ob_start();
?>

	<h4><?php echo "OBSERVATION"." ".$lang_list; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4>

<?php			
}
?> 

			        <table class="table table-bordered table-striped" border="1" style="border-collapse: collapse;">
       			
       			
				<thead>
					<tr>
                          <th><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_op_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th><a href="#"><?php echo $lang_age; ?></a></th>	
						  <th><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                          <th><a href="#"><?php echo $lang_place; ?></a></th>
						  <th><a href="#"><?php echo $lang_date; ?></a></th>
						  <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						  <th><a href="#"><?php echo "ADMISSION"; ?></a></th>
                           	 <th><a href="#"><?php echo $lang_observation_room; ?></th>
                           	  <th><a href="#"><?php echo $lang_observation_bed; ?></th>
						  <th><a href="#"><?php echo "DISCHARGE"; ?></a></th>
						  <th><a href="#"><?php echo $lang_status; ?></a></th>
						  <th class="DONTPrint"><a href="#"><?php echo $lang_print; ?></a></th>

							                         
							                                  
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
						<td><?php echo $patientInfo[$i][47]."/".$patientInfo[$i][0];?></td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($patientInfo[$i][60]));?></td>
						<td><?php echo $patientInfo[$i][86];?></td>
						<td><?php echo $patientInfo[$i][87];?></td>	
						<td><?php if ($patientInfo[$i][61]!="0000-00-00 00:00:00") {
							echo date("d-m-Y h:i A",strtotime($patientInfo[$i][61]));
						}else{echo "NA";} ?></td>
						<td><?php if ($patientInfo[$i][59]=="YES") {
							echo "IN OBSERVATION";
						}elseif ($patientInfo[$i][59]=="DISCHARGED") {
							echo "DISCHARGED";
						}elseif ($patientInfo[$i][59]=="ADMITTED") {
							echo "ADMITTED";
						}  ?></td>

						<td class="DONTPrint">

							<?php if ($patientInfo[$i][59]=="DISCHARGED") {?>

								<a href="#" class="btn btn-info btn-flat" onclick="print_bill('<?php echo $patientInfo[$i][65] ?>');"><i class="fa fa-print"></i></a>

							<?php }else{?>

								<a href="#" class="btn btn-info btn-flat" onclick="print_bill('<?php echo $patientInfo[$i][65] ?>');" style="visibility: hidden;" ><i class="fa fa-print"></i></a>

							<?php
							} ?>

							
					     </td>


					
					
                           
					</tr>

		<?php	}
			
			}		
		?>
					</tbody>
				</table>
				
			</div>
				</div>
				
	
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="observation_report" value="observation_report" />
	 <input type="hidden" name="billid" id="billid" />
	 <input type="hidden" name="no_action" id="no_action" />
	 
	 <?php if(!isset($_POST['export']) && empty($post['pdf']))
{?>
<div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">
</div>

<?php }?>
</section>	 
</form>	  

</body>
	</html>
	
<?php
if (!empty($post['pdf'])) {

$myvar = ob_get_clean();
ob_end_clean();


$myvar = utf8_encode($myvar);
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf->allow_charset_conversion = TRUE;
$mpdf->charset_in = 'UTF8'; 
$mpdf->WriteHTML($myvar);
$mpdf->Output("Observation-Report.pdf", "D"); 

}





 ?>