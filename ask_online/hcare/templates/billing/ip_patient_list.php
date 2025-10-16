<?php session_start();
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
$comm_obj= new CommonFunctions();
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

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 
		  $('.print_bill').click(function(e) {
		  
		   $("#id").val($(this).attr('id'));
		  
		   $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Print_IP_Bill");
           $("#form").submit();
		  });

		  //detailed print
		  $('.print_detailed_bill').click(function(e) {
		  
		   $("#id").val($(this).attr('id'));
		   $("#print_status").val('print_status');
		  
		   $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Print_IP_Bill");
           $("#form").submit();
		  });
		   $('.cancel_bill').click(function(e) {
		  
		   $("#id").val($(this).attr('id'));
		   var a=confirm("Do You Really Want to Cancel The Bill?");
		
  		   if(a==true)
   			{
				var details=prompt("Please Enter Cancellation Details:","");
				
				if(details!= null){
					$("#cancellation_details").val(details);
					 $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Cancel_IP_Bill");
                    $("#form").submit();
					
				}else{
				return false;
			}
				

			}else{
				return false;
			}
		  
		  });
	  });
	  </script>
<script type="text/javascript">

      function searchForm(){	
		
		document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=IP_Search";
		document.select_patient.submit();
	}
	function redirect(pid,action){
	    
		document.select_patient.id.value=pid;
		
		if(action == "advance"){
		   document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Advance_Payment_Form";
		}else if(action == "final_bill"){
		   document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";
		}
		else if(action == "discharge_summary"){
		   document.select_patient.action="../../lib/controllers/centralController.php?module=IP&sub_module=discharge_summary_templates";
		}
		else{ 
		
		   document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Prepare_Final_Bill";
		}
		
		
		document.select_patient.submit();
	}
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="select_patient" id="form"  method="post" action=""> 
<?php
	
	
		$post=$this  ->popArr['post'];
		$doctors=$this  ->popArr['doctors'];
		$patientInfo=$this  ->popArr['patient_info'];
		// var_dump($patientInfo);exit();
?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_inpatient; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
	
					 
                                             <tr>
							
                                                <td id="noborder"> <?php echo $lang_ip_no; ?>:</td>
								<td id="noborder"><input type="text" name="ipno"  size="12" value="" onkeypress="nextField(event.keyCode,room_no)" /></td>
                                
								<td id="noborder"> <?php echo $lang_room_no; ?>:</td>
								<td id="noborder"><input type="text" name="room_no"  size="12" value="" onkeypress="nextField(event.keyCode,name)" /></td>
								
								<td id="noborder"> <?php echo $lang_first_name; ?>:</td>
								<td id="noborder"><input type="text" name="name"  size="12" value="" onkeypress="nextField(event.keyCode,from_date)" />

								</td>
								
								
                                
                                </tr>
                                <tr>
                                             <td id="noborder"><?php echo $lang_from_date; ?> </td>
							   <td id="noborder" ><input type="text" name="from_date" id="from_date" value="<?php echo $post['from_date'];?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
                               
                                            <td id="noborder"><?php echo $lang_to_date; ?> </td>
                                            
							   <td id="noborder" ><input type="text" name="to_date" id="to_date" value="<?php echo $post['to_date'];?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
                                           <td id="noborder"><?php echo $lang_doctor; ?> </td>
                                         <td id="noborder">
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="searchForm();" /> 		
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
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="searchForm();"/>
									
									</td>
								</tr>	
								</table>
				</div>
			</div>
				
		<h3 ><?php echo $lang_inpatient." ".$lang_list; ?></h3>
		
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
			
       			
				<thead>
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
						 <th><a href="#"><?php echo $lang_room_no;?></a></th>			
					         
					         
					         <th><a href="#"><?php echo $lang_doctor; ?></a></th>
                                          <?php echo $post['request_from']; if(empty($post['request_from']) ){ ?>

					         <th width="8%"><a href="#"><?php echo $lang_advance_payment; ?></a></th>
                                         <?php } ?>
					        
							<th  width="15%"><a href="#"><?php echo $lang_status; ?></a></th>
										                              
						
                              </tr>
                          </thead>
                          <tbody>
                               
                                       <?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {
                 // var_dump($patientInfo);
					?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
					<td>

						<!-- <a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>')"><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a> -->
						<a href="#" ><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a>
						<?php if ($patientInfo[$i][66] ==1) {?>
							
						<br>
						<span class='text-red' ><small>(Bystander added)</small></span>
					<?php }?>
					</td>
						
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>

                    <?php if(empty($post['request_from'])){ 

					     if($patientInfo[$i][51] == 0 || $patientInfo[$i][51] == 3 ){?>                    
						  <td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>','advance')"><?php echo $lang_advance_payment; ?></a></td>
						  
						  
                   <?php }else{?>
				       <td></td>
				  <?php
				   }
				  
				   }

 			   ?>
						<td><?php
						   if($patientInfo[$i][51] == 2){?>
						   
						      <div class="btn-group">
                                 <button type="button" class="btn btn-success">BILL READY</button>
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">
                                <!--  <li class="print_bill" id="<?php echo $patientInfo[$i][13];?>"><a href="#">PRINT</a></li> -->
                                 <!-- detailed print -->
                                 <li class="print_detailed_bill" id="<?php echo $patientInfo[$i][13];?>"><a href="#">PRINT <!-- DETAILED --> BILL</a></li>
                                 <li class="cancel_bill" id="<?php echo $patientInfo[$i][13];?>"><a href="#">CANCEL BILL</a></li>
                                 <li onclick="redirect('<?php echo $patientInfo[$i][13];?>','final_bill')"><a href="#">GO TO PAYMENT</a></li>
                                 <?php
						   if(empty($patientInfo[$i][55])){?>
                                 <li onclick="redirect('<?php echo $patientInfo[$i][13];?>','discharge_summary')"><a href="#">DISCHARGE SUMMARY</a></li>
                            <?php } ?>     
                                
                                </ul>
                    </div>
					<?php  }else{
						?>
						
						<a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>','prepare_bill')"><?php echo $lang_prepare_bill; ?></a>
						
						<?php } ?>
						</td>
						<td>
						
						
						</td>
				        </tr>
		       <?php       }
		             }
		        ?>
                                       
                          </tbody>
                        </table>
                        
                         
           
          
			</div>
				</div>
				
				
				 </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
           <input type="hidden" name="request_from" id="request_from" value="<?php echo (!empty($post['request_from']) )?$post['request_from']:'';?>"/>
      <input type="hidden" name="is_dupclicate" id="is_dupclicate">
	  
	<input type="hidden" name="print_status" id="print_status" />
</form>	  
</body>
	</html>
                
