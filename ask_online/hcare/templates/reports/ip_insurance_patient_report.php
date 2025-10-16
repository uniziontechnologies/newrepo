<?php

	$patientInfo=$this  ->popArr['patient_info'];
	$ipbillInfo=$this  ->popArr['ipbillInfo'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$insurance_company=$this  ->popArr['insurance_company'];
	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];

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
/*........pagination.........*/	
  $(document).ready(function(){
     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_report");
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_report");
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_report");
                 $("#form").submit();
              });
  });  
</script>
<script type="text/javascript">


function submitform(action,id){

	
        document.patients.paction.value=action;
		document.patients.id.value=id;
  if(action =="CLEAR"){
		
			document.patients.from_date.value='';
			document.patients.to_date.value='';
			document.patients.ipno.value='';
			document.patients.opno.value='';
			document.patients.first_name.value='';
			document.patients.place.value='';
			document.patients.doctor.value='';
			document.patients.insurance_company.value='';
			
		}	
  if(action == "PRINT"){
			document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_bill_report";
  }else if(action == "PRINT PHARMA"){		
   		    document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_pharma_invoice_report";
   	   }else{			
   		    document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_insurance_patient_report";
   	   }    
		document.patients.submit();
    
}
//print
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
					filename: "Ip Insurance Patient Report",
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
									<?php echo $lang_insurance_company; ?></td>
									<td id="noborder" ><select name="insurance_company" id="insurance_company"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>------------------------------</option>
											
										<?php for($i=0;$i<count($insurance_company);$i++){ 
																						
												if(!empty($post['insurance_company']) && $post['insurance_company']==$insurance_company[$i][0]) { ?>
													
													<option value='<?php echo $insurance_company[$i][0];?>' selected><?php echo $insurance_company[$i][1];?></option>
										<?php   	}else {?>
										
													<option value='<?php echo $insurance_company[$i][0];?>'><?php echo  $insurance_company[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
								 
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
			<div>
			    <div>
                	<h3 >
						<?php echo $lang_inpatient." ".$lang_list; ?>
						</a>
					</h3>
			    </div>
			    <div>
			    	    <div class="box-header">
                          <div class="box-tools DONTPrint">
                            <?php echo $pagination;?>
                          </div>
                        </div>
			    </div>		
		    </div>			
					<div align="left"><?php echo !empty($post['ipno'])?"IPNO : ".$post['ipno']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['opno'])?"OPNO : ".$post['opno']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['doc_name'])?"Doctor : ".$post['doc_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				<?php echo !empty($post['insurance_company'])?"Insurance Company : ".$post['insurance_company_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                  <!-- <div class="box-header">
                  <div class="box-tools DONTPrint">
                    <?php echo $pagination;?>
                  </div>
                </div> -->
               <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_inpatient." ".$lang_list; ?></h4></td></tr>
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
						 <th><a href="#"><?php echo $lang_insurance_company;?></a></th>
						 <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th class="DONTPrint"><a href="#"><?php echo $lang_bill_report; ?></a></th>
                          <th class="DONTPrint"><a href="#"><?php echo $lang_pharma_report; ?></a></th>
						 <!-- <th width="5%"><a href="#"><?php echo $lang_total_amount; ?></a></th>
						 <th><a href="#"><?php echo $lang_amount_paid;?> SO FAR</a></th>							
						 <th><a href="#"><?php echo $lang_balance; ?></a></th>
						 <th><a href="#"><?php echo $lang_bill_status; ?></a></th> -->
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr <?php echo ($patientInfo[$i][22] == '0000-00-00')?'class="text-red"':'';?>>
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
						<td><?php echo $patientInfo[$i][24];?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
						<td class="DONTPrint">
							<a href="#" onClick="submitform('<?php echo $lang_print;?>','<?php echo $patientInfo[$i][13];?>');">
							      <?php echo $lang_bill_report; ?>  
							</a>
						</td>
						<td class="DONTPrint">
							<a href="#" onClick="submitform('<?php echo $lang_print_pharma;?>','<?php echo $patientInfo[$i][13];?>');">
							      <?php echo $lang_pharma_report; ?>  
							</a>
						</td>
						<!-- <td><?php echo $ipbillInfo[$i][0];?></td>
						<td><?php echo $ipbillInfo[$i][1];?></td>
						<td><?php echo $ipbillInfo[$i][2];?></td>
						<td><?php echo ($patientInfo[$i][51] == 2)?'Bill Ready':'';?></td> -->
						
						
                           
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>

<?php

if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()"></div>

      </div>
  		
<?php
}
?>

	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="ip_insurance_patient_report" value="ip_insurance_patient_report" />
<!--.....pagination......-->
  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
  
</form>
</body>
</html>
