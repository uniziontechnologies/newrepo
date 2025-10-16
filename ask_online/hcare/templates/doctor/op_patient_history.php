<?php

	$patientInfo=$this  ->popArr['patient_info'];
	$pagination=$this  ->popArr['pagination'];
	$current_page=$this  ->popArr['current_page'];
	$post=$this  ->popArr['post'];

	if (isset($post['from'])) {
		$from_status=$post['from'];
	}
	else{
		$from_status="";
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
    <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">   


  <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
		

<script type="text/javascript">

 $('.main-header', window.parent.document).show();
$(document).ready(function(){

    $(".select_patient").bind('click', function() {

        $("#id").val($(this).attr("id"));

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=op_case_sheet");
   	$("#form").submit();
    });
    $("#search").bind('click', function() {
	
        $("#current_page").val('');
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=patient_history");
   	    $("#form").submit();
    });
    $(".consulted").bind('click', function(e) {
    
  

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd = '0'+dd
		} 

		if(mm<10) {
		    mm = '0'+mm
		} 

		// today = mm + '-' + dd + '-' + yyyy;
		today = yyyy + '-' + mm + '-' + dd;
		
		var visit_date = $(this).attr("value");
		
		if (visit_date==today) {

	        $("#id").val($(this).attr("id"));
	        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=reset_dr_consulted");
	     	$("#form").submit();		

		}
		else{
			e.preventDefault();
			return false;

		}


    });
     $(".view_casesheet").bind('click', function() {
     
         $("#id").val($(this).attr("id"));
         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&active_module=current_visit");
   	     $("#form").submit();
    });
    $(".edit_patient").bind('click', function() {

        $("#id").val($(this).attr("id"));

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=op_case_sheet&active_module=presenting_complaints");
   	$("#form").submit();
    });     
    $(".print_casesheet").bind('click', function() {
     
         $("#id").val($(this).attr("id"));
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=print_prescription");
   	$("#form").submit();
    });
	
	  $(".next_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=patient_history");
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=patient_history");
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  
			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=patient_history");
				 $("#form").submit();
			  });
 });

</script>
<style type="text/css">
.revisit{
	background-color: #d6b8ad;
}
</style>
</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 

<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
								<tr>
										<td id="noborder">
									
										<?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
										</td>
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
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
								
								<?php echo $lang_contact_no; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="contact_no" id="contact_no"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" /> 	 
							</td>
							
								
								</tr>
								<tr>		
								 <td><?php echo $lang_visit_status;?></td>
								 <td><select name="visit_status" id="visit_status">
								     <option value="">-----</option>
									 <option <?php echo (!empty($post['visit_status']) && $post['visit_status']=="NEW")?'selected':''?> value="NEW">NEW</option>
									 <option <?php echo (!empty($post['visit_status']) && $post['visit_status']=="VISIT")?'selected':''?> value="VISIT">VISIT</option>
									 <option <?php echo (!empty($post['visit_status']) && $post['visit_status']=="RENEW")?'selected':''?> value="RENEW">RENEW</option>
									</select>
								</td>
									<td id="noborder" colspan="4" align="center">
									&nbsp;&nbsp;
									<input id="search" type="button" name="Search" value="Search"  class="btn btn-success" />
									</td>
								</tr>
						</table>
				
					</div>
			</div>
<section class="content-header">
          <h4><?php echo $lang_op_patients." ".$lang_history; ?></h4>
		 
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
               <div class="box-header">
                  <div class="box-tools">
				   <?php echo $pagination;?>
				  </div>
               </div>			   
               <div class="box-body">
						<table class="table table-bordered table-striped">
 
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
                                                 <th ><a href="#"><?php echo $lang_token_no; ?></a></th>
						 <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						 <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>  			  
                                                 <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_date; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>					    
					        <th width="5%"><a href="#"><?php echo $lang_visit_status; ?></a></th>	  
                                                 <th><a href="#"><?php echo $lang_consulted; ?></a></th> 
                                                 <th><a href="#"><?php echo $lang_action; ?></a></th>  						 
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {
					?>
					<tr <?php echo(!empty($patientInfo[$i][32])&&$patientInfo[$i][32]=="REVISIT")?'class="revisit"':""; ?> >
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][0];?></td>
                                                <td><?php echo $patientInfo[$i][36];?></td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?></td>
						
						
						<td>
						 <input type="checkbox" name="consulted" class="consulted" id="<?php echo $patientInfo[$i][13];?>" value="<?php echo $patientInfo[$i][20];?>" checked <?php if (!empty($patientInfo[$i][67])) {echo "disabled";} ?> >
						</td>
						<td><a href="#" class="view_casesheet btn btn-info btn-flat" id="<?php echo $patientInfo[$i][13];?>">VIEW</a>


								
							       <a href="#" class="edit_patient btn btn-success btn-flat" id="<?php echo $patientInfo[$i][13];?>">EDIT</a>	

						

						    <a href="#" class="print_casesheet btn btn-warning btn-flat" id="<?php echo $patientInfo[$i][13];?>">PRINT</a>
						
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
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="from" id="from" value="from_op_history" />
	 <input type="hidden" name="paction" id="paction" />
	 <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
	 
</form>	 

</body>
	</html>
	
