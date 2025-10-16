<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
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
<script>
	
  
   function submitform(action,id){
   	
	
		setAction(action,id);
   		document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=agewise_ip_patient_report";
	
		document.patients.submit();
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
					filename: "Agewise Ip Patient Report",
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
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
											
										</td>
										<td id="noborder">		
										<?php echo $lang_gender; ?>  :
							</td>
							<td id="noborder">			
										<select name="gender" onkeypress="nextField(event.keyCode,place)">
											<option value="">-----------------------------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
										</select>
								 
							</td>
							</tr>
							<tr>
										<td id="noborder">AGE TYPE:</td>
										<td id="noborder" >	
											<select name="age_type" onkeypress="nextField(event.keyCode,age_type)">
											<option value="Y" <?php echo (!empty($post['age_type']) && $post['age_type']=='Y')?'selected':''?>>Y</option>
											<option value="M" <?php echo (!empty($post['age_type']) && $post['age_type']=='M')?'selected':''?>>M</option>
											<option value="D" <?php echo (!empty($post['age_type']) && $post['age_type']=='D')?'selected':''?>>D</option>
											</select> 
										</td>
										<td id="noborder">
								
										<?php echo $lang_age; ?> <span id='requiredfield'>*</span> : 
									</td>
									<td id="noborder">
									
										<select name="age_from" onkeypress="nextField(event.keyCode,age_tp)">
										<option value="">---------------</option>
										<?php
											for($i=1;$i<=100;$i++){ ?>
											<option value="<?php echo $i;?>" <?php echo (!empty($post['age_from']) && $post['age_from']== $i)?'selected':''?> ><?php echo $i;?></option>
											
											<?php } ?>
										</select>
										<select name="age_to" onkeypress="nextField(event.keyCode,Search)">
										<option value="">---------------</option>
										<?php
											for($i=1;$i<=100;$i++){ ?>
											<option value="<?php echo $i;?>" <?php echo (!empty($post['age_to']) && $post['age_to']== $i)?'selected':''?>><?php echo $i;?></option>
											
											<?php } ?>
										</select>
									</td>

									<td id="noborder">
									<?php echo $lang_doctor; ?> </td>
										<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" style="width: 170px;" /> 		
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
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
		<h4 ><?php echo $lang_inpatient." ".$lang_list; ?> From <?php echo date("d-m-Y",strtotime($post['from_date'])); ?> To <?php echo date("d-m-Y",strtotime($post['to_date']));?></h4>
					
	<div class="box box-info">
                
               <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_inpatient." ".$lang_list; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						<th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                        <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
					     <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_discharged_on; ?></a></th>
					     <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						 <th><a href="#"><?php echo $lang_room_no;?></a></th>							
						 <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr >
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
						<td><?php echo $patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php echo ($patientInfo[$i][22] == '0000-00-00')?'':$patientInfo[$i][22];?></td>
						<td><?php echo $patientInfo[$i][21];?></td>
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						
						
						
                           
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
	 <input type="hidden" name="page_name" id="agewise_ip_patient_report" value="agewise_ip_patient_report" />
	 
	 <?php if(!isset($_POST['export']) && empty($post['pdf']) )
{?>
<div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
</div>
<?php }?>
  </section>	 
</form>	  

</body>
	</html>
