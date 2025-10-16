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
        $('#admitted_on').datepicker();
		 $('#discharged_on').datepicker();
		 $(".timepicker").timepicker({showInputs: false,defaultTime: false});
	  });
	  </script>
<script>
	
 
   
   function submitform(action,id){
   	
	 
		setAction(action,id);
		if(action =="CLEAR"){
		
			document.manage_bill.admitted_on.value='';
			document.manage_bill.discharged_on.value='';
			document.manage_bill.opno.value='';
			document.manage_bill.ipno.value='';
			document.manage_bill.name.value='';
			document.manage_bill.place.value='';
			
		}
		if(action == "PRINT"){
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_lab_report_person";
		}else{
   		   document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_lab_reports";
		}
	    document.manage_bill.submit();
   }
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
   
</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
	
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$patientInfo=$this  ->popArr['patient_info'];
    
	
	$user_type_logged_in=$_SESSION['user_type'];

?>
 <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search; ?></h4>
		  
        </section>
 
	<section class="content">
	 <div class="DONTPrint">				 
	   <div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_admitted_on; ?> :</td>
										<td id="noborder" >	
											<input type="text" name="admitted_on" id="admitted_on"  class="DatePicker" value="<?php echo (!empty($post['admitted_on']))?date('d-m-Y',strtotime($post['admitted_on'])):'' ?>" readonly="true"/>
										
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_discharged_on; ?> :</td>
										<td id="noborder" >	<input type="text" name="discharged_on" id="discharged_on"  class="DatePicker" value="<?php echo (!empty($post['discharged_on']))?date('d-m-Y',strtotime($post['discharged_on'])):'' ?>" readonly="true"/>

										</td>
										<td id="noborder">							
								
										<?php echo $lang_op_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="opno" id="opno"   onkeypress="nextField(event.keyCode,name)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" /> 	 
							</td>
										
								
								</tr>
								<tr>
								<td id="noborder">
							            <?php echo $lang_ip_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="ipno" id="ipno"   onkeypress="nextField(event.keyCode,name)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" /> 	 
							    </td>
								<td id="noborder">							
								
										<?php echo $lang_patient." ".$lang_name; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="name" id="name"   onkeypress="nextField(event.keyCode,type)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" /> 	 
							    </td>	
								<td id="noborder">							
								
										<?php echo $lang_place; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,type)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" /> 	 
							    </td>	
								
								</tr>
								<tr>
									  <td id="noborder" colspan="6" align="center">
									  &nbsp;&nbsp;
									  <input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									  <input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									  </td>
									  <td id="noborder" colspan="2" align="center"></td>
								</tr>
									
							    
						</table>
				
					</div>
			</div>
			</div>
			<h4 >
			      <?php echo $lang_ip_patient_lab_report; ?>
	        </h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>			
			<div class="box box-info">
                
                           <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th ><a href="#"><?php echo $lang_age; ?></a></th>	
						  <th ><a href="#"><?php echo $lang_gender; ?></a></th>
						  <th ><a href="#"><?php echo $lang_place; ?></a></th>
						  <th ><a href="#"><?php echo $lang_admitted_on; ?></a></th>
						  <th ><a href="#"><?php echo $lang_time; ?></a></th>	
						  <th ><a href="#"><?php echo $lang_discharged_on; ?></a></th>
						  <th ><a href="#"><?php echo $lang_time; ?></a></th>				 	
						  <th ><a href="#"><?php echo $lang_room_no; ?></a></th>  
                          <th ><a href="#"><?php echo $lang_doctor; ?></a></th> 							  
						  <th class="DONTPrint"><a href="#"><?php echo $lang_lab_report; ?></a></th>
                                      
             
                    </tr>
						</thead>
						<tbody>	
		<?php
		// $total=0;
		// $totalcash =0;	
		// $totalcard =0;	
		// $totalcredit =0;	
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr <?php /*if($patientInfo[$i][22]=='0000-00-00'||'') {?> style="color: #ff0000;" <?php }*/ ?>>
						<td><?php echo $j++;?></td>
					    <td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php  if($patientInfo[$i][22]=='0000-00-00'||'') 
						              {
                                         /*...No display...*/
						              } 
						          else{
                                         echo $patientInfo[$i][22];
						              } 
						    ?>  
						</td>
						<td><?php echo $patientInfo[$i][21];?></td>	
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						<td class="DONTPrint">
							<a href="#" onClick="submitform('<?php echo $lang_print;?>','<?php echo $patientInfo[$i][13];?>');">
							      <?php echo $lang_lab_report; ?>  
							</a>
						</td>
					</tr>
					<tr>
		<?php
						
				
			}
			
			}		
		?>
		</tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				

        <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"   class="btn btn-info" onClick="printit()">   
      </div>
     </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
</form>	  
</body>
	</html>
	
