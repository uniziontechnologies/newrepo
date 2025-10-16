 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
 <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />

 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	
	
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>   
	
	<!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>


	<link rel="stylesheet" href="../../dist/css/ajax.css">
    <script type="text/javascript" src="../../ajax/ajax.js"></script>
    <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

	
	 <script>

 function save_ip_medicines(){

 	if ($("#medicines_hidden").val()=="") {
        showDialog('Error','Please Enter a Medicine.','error',2);
        $("#medicines").focus();
		return false;
 	}
 	else if ($("#med_course").val()=="") {
        showDialog('Error','Please Enter Medicine Course.','error',2);
        $("#med_course").focus();
		return false;
 	}
 	else if ($("#med_days").val()=="") {
        showDialog('Error','Please Enter Medicine Duration.','error',2);
        $("#med_days").focus();
		return false;
 	}
 	// else if ($("#qty").val()=="") {
  //       showDialog('Error','Please Enter Medicine Qty.','error',2);
  //       $("#qty").focus();
		// return false;
 	// }
 	else{

		$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=save_ip_medicines");
		$("#form").submit();
		return true;

 	}




 }

      $(function () {

      	// alert($("#sub_tab").val());
	  
	   //Date range picker
        $('#date').datepicker();
		 $('#vdate').datepicker();
		  $('#nrdate').datepicker();

		  if ($("#sub_tab").val()=="medicines") {
		  		$("#medicines").focus();
		  }

	  });

	  </script>
    <script type="text/javascript">

$(document).ready(function(){

    //     $(".textareaNursingNote").each(function(textarea) {
    //      // $(this).height(0);
    //     $(this).height(this.scrollHeight);
    // });



 
        
 
 	$(".addProcedure").bind('click', function() {
		
                       if($("#procedure").val() == ""){

                      }else {
			
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_procedure");
			$("#form").submit();
                     }
		});

       $(".deleteProcedure").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Procedure Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_procedure");
			               $("#form").submit();
                                }
                }

     });
	 
 	$(".addVisit").bind('click', function() {
		
                       if($("#doctor").val() == ""){

                      }else if($("#visit_type").val() == ""){

                      }else {
			
                        
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_doctor_visit");
			$("#form").submit();
                     }
		});

       $(".deleteVisit").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Doctor Visit Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_doctor_visit");
			               $("#form").submit();
                                }
                }

     });
	 	$(".addNotes").bind('click', function() {
		
                       if($("#nursing_notes").val() == ""){

                      }else {
			
                        
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_nursing_notes");
			$("#form").submit();
                     }
		});

	 	$(".editNotes").bind('click', function() {

	 		var position = $(this).attr("id");

	 		var nursing_note = $("#nursing_notes_value_"+position).attr("id");

	 		var nursing_note_data = $("#"+nursing_note).val();
		
                if(nursing_note_data == ""){

			        showDialog('Error','Nursing Note Cannot be empty !.','error',2);
			        $("#medicines").focus();
					return false;

                }else{

                	$("#nursing_id").val(position);
                	$("#nursing_note_data").val(nursing_note_data);
			
					$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=edit_nursing_notes");
					$("#form").submit();
               }

		});


       $(".deleteNotes").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Doctor Visit Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_nursing_notes");
			               $("#form").submit();
                                }
                }

     });
	 
	 $(".transfer").bind('click', function() {
	 
	               if($("#room").val() == ""){
				   
				     showDialog('Error','Please Select Room No.','error',2);
				     return false;

                    }else if($("#bed_no").val() == ""){
                         showDialog('Error','Please Choose Bed No.','error',2);
				         return false;
                    }else {
			              $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_room_transfer");
			              $("#form").submit();
                   }
	 });

       $(".deleteMedicines").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Procedure Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_medicines");
			               $("#form").submit();
                                }
                }

     });

     $(".addOwnMedicines").bind('click', function() {
	 		
	 			 if($("#datetime").val() == ""){
                         showDialog('Error','Please select date time.','error',2);
				         return false;
                    }else if($("#drug").val() == ""){
				   
				     showDialog('Error','Please enter drug.','error',2);
				     return false;

                    }else if($("#dose").val() == ""){
                         showDialog('Error','Please enter dose.','error',2);
				         return false;
                    }else if($("#route").val() == ""){
                         showDialog('Error','Please enter route.','error',2);
				         return false;
                    }else if($("#frequence").val() == ""){
                         showDialog('Error','Please enter frequency.','error',2);
				         return false;
                    }else {
			              $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_own_medicines");
			              $("#form").submit();
                   }
	 }); 


    $(".editOwnMedicines").bind('click', function() {

	 		var position = $(this).attr("id");

	 		var drug = $("#drug_value_"+position).attr("id");

	 		var drug_data = $("#"+drug).val();

	 		var dose = $("#dose_value_"+position).attr("id");

	 		var dose_data = $("#"+dose).val();

	 		var route = $("#route_value_"+position).attr("id");

	 		var route_data = $("#"+route).val();
	 		var freq = $("#frequency_value_"+position).attr("id");

	 		var freq_data = $("#"+freq).val();
	 		var remarks = $("#remarks_own_medicine_value_"+position).attr("id");

	 		var remarks_data = $("#"+remarks).val();
		
                if(drug_data == ""){

			        showDialog('Error','Drug Cannot be empty !.','error',2);
			        // $("#medicines").focus();
					return false;

                }else if(dose_data == ""){

			        showDialog('Error','Dose Cannot be empty !.','error',2);
			        // $("#medicines").focus();
					return false;

                }else if(route_data == ""){

			        showDialog('Error','Route Cannot be empty !.','error',2);
			        // $("#medicines").focus();
					return false;

                }else if(freq_data == ""){

			        showDialog('Error','Frequency Cannot be empty !.','error',2);
			        // $("#medicines").focus();
					return false;

                }else{

                	$("#own_medicine_id").val(position);
                	$("#drug_data").val(drug_data);
                	$("#dose_data").val(dose_data);
                	$("#route_data").val(route_data);
                	$("#freq_data").val(freq_data);
                	$("#remarks_data").val(remarks_data);


                	





			
					$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=edit_own_medicines");
					$("#form").submit();
               }

		});

    $(".deleteOwnMedicines").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete this  Medicine for the selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_own_medicines");
			               $("#form").submit();
                                }
                }

     });
	 




	 
	
 });



</script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>
var $j = jQuery.noConflict();
$j(document).ready(function() { 
 $j("#room").change( function(){
			
			 var room_id=$("#room").val();
			 
			 
			 	var data = 'id='+room_id;
				
				inline_action="../../lib/controllers/centralController.php?module=IP&sub_module=process_room";
				
				 $j.post(inline_action, data, function (response) {
				 
				 	var bedInfo=response['bedInfo'];
					
					$("#bed_no option").remove();
						for(i=0;i<bedInfo.length;i++){
						
							$("#bed_no").append("<option value='"+bedInfo[i][0]+"'>"+bedInfo[i][1]+" </option>");
						
						}
					
				 $("#rent").val(response['room_rent']);
				 $("#ncharge").val(response['ncharges']);
				  $("#mcharge").val(response['mcharges']);
				 },"json").fail(function(){alert(response)});;
			
			});
  $j("#btn-back").click(function(e){
  		e.preventDefault();
  		if($j("#btn-back").val()){
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Prepare_Final_Bill");
			$("#form").submit();
		}
  })

});  
</script>
<style type="text/css">
.addMedicines:focus {
        border: 4px solid indianred;
}
/*.textareaNursingNote{
    resize: horizontal;
    overflow: hidden;
}*/


</style>
</head>
<body id="content">

<?php
$patientInfo=$this  ->popArr['patientInfo'];

$procedureInfo=$this  ->popArr['procedureInfo'];
$ipProcedure=$this  ->popArr['ipProcedure'];

$doctors=$this  ->popArr['doctors'];
$DocVisit=$this  ->popArr['DocVisit'];

$nurNotes=$this  ->popArr['nurNotes'];

$roomInfo=$this->popArr['roomInfo'];
$roomhist=$this->popArr['roomhist'];
$freeRooms=$this->popArr['freeRooms'];

$subtab=$this  ->popArr['subtab'];
if(empty($subtab)) $subtab='ip_procedure';
$type=$this ->popArr['type'];
if($type && $type=="specialist_consultation"){
	$subtab = "doctor_visit";
}
if($type && $type=="nursing_procedures"){
	$subtab = "ip_procedure";
}

$medicineInfo=$this  ->popArr['ipMedicines'];
$ownMedicines=$this  ->popArr['ownMedicines'];



?>
<form name="ip_case_sheet" id="form"  method="post" action="">
<div class="box box-info">
	<input type="hidden" name="type" id="type" value="<?php echo $type;?>">
                
               <div class="box-body">
						<table class="table table-striped">
 

                                               <tr>
                                                  <td id="noborder"><?php echo $lang_ip_no; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][13];?>" name="ipno" id="ipno"></td>
                                                   <td id="noborder"><?php echo $lang_name; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];?>"></td>
                                                    <td id="noborder"><?php echo $lang_age; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][4];?>"></td>
                                              </tr>
                                              <tr>
                                                   <td id="noborder"><?php echo $lang_gender; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][6];?>"></td>
                                            
                                                   <td id="noborder"><?php echo $lang_room; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][37];?> (BED NO:<?php echo $patientInfo[0][38];?>)"></td>
                                                   <td id="noborder"><?php echo $lang_doctor; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][17]." ".$patientInfo[0][18];?>"></td>
                                               </tr>
                        </table>
				</div>
			</div>	
	 <!-- START CUSTOM TABS -->
           <!-- back button -->
           <?php if($type){ ?>
           <div style="padding: 20px;">           	
           	<button class="btn btn-success" id="btn-back" value="<?php echo $type;?>">BACK</button>
           </div>
       <?php } ?>
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom bg-gray">
                <ul class="nav nav-tabs">
                  <li class="<?php echo (!empty($subtab) && $subtab == 'ip_procedure')?'active' :'';?>"><a href="#tab_1" data-toggle="tab"<?php
                  //hide visibility when call is made from prepare_final_bill
                  if($type && $type=="nursing_procedures"){}else if($type){?> style="display: none;"<?php }?>>IP Procedure</a></li>
                  <li class="<?php echo (!empty($subtab) && $subtab == 'doctor_visit')?'active' :'';?>"><a href="#tab_2" data-toggle="tab"<?php
                  //hide visibility when call is made from prepare_final_bill
                  if($type && $type=="specialist_consultation"){}else if($type){?> style="display: none;"<?php }?>>Doctor Visit</a></li>
                  <li class="<?php echo (!empty($subtab) && $subtab == 'nursing_notes')?'active' :'';?>"><a href="#tab_3" data-toggle="tab"<?php
                  //hide visibility when call is made from prepare_final_bill
                  if($type && $type=="nurse_note"){}else if($type){?> style="display: none;"<?php }?>>Nursing Notes</a></li>
				  <li class="<?php echo (!empty($subtab) && $subtab == 'room_transfer')?'active' :'';?>"><a href="#tab_4" data-toggle="tab"<?php
                  //hide visibility when call is made from prepare_final_bill
                  if($type && $type=="room_transfer"){}else if($type){?> style="display: none;"<?php }?>>Room Transfer</a></li>

                  <li class="<?php echo (!empty($subtab) && $subtab == 'medicines')?'active' :'';?>"><a href="#tab_5" data-toggle="tab">Medicines</a></li>
                  <li class="<?php echo (!empty($subtab) && $subtab == 'own_medicines')?'active' :'';?>"><a href="#tab_6" data-toggle="tab">Own Medicines</a></li>
                 
                  
                </ul>
                <div class="tab-content">
                  <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'ip_procedure')?'active' :'';?>" id="tab_1">
                  	<div class="row">
		
		 <div class="col-md-4">
				<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
							<tr>
								<td id="noborder"><?php echo $lang_date; ?>:</td>
								<td id="noborder" >	
									<input type="text" name="date" id="date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
								</td>
                                                       </tr>

                                                       <tr>
								<td id="noborder"><?php echo $lang_procedure; ?></td>
								<td id="noborder" >	
											
											 <select name="procedure" id="procedure" keypress="nextField(event.keyCode,Search)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($procedureInfo)){
								
									for($i=0;$i<count($procedureInfo);$i++){ ?>									
												
												<option value='<?php echo $procedureInfo[$i][0];?>' ><?php echo $procedureInfo[$i][3];?></option>
						<?php			
									}
								}
						?>							
						
						</select>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>

                                                       </tr>
                                                       <tr>
                                                             <td id="noborder">
									&nbsp;&nbsp;
								<input id="button1" type="button" name="add"  value="ADD" class="addProcedure btn btn-success" /></td>
								</tr>
                        </table>
					</div>
				</div>
			</div>
			 <div class="col-md-6">
               
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">                 
				          <thead>
					     <tr>
                                                 <th ><a href="#"><?php echo $lang_id; ?></a></th>                            	              
                                                 <th><a href="#"><?php echo $lang_procedure; ?></a></th> 
						 <th><a href="#"><?php echo $lang_date; ?></a></th> 
						 <th><a href="#"><?php echo $lang_user; ?></a></th>   
						 <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($ipProcedure)){
                               $j=1;
				for($i=0;$i<count($ipProcedure);$i++) {?>
					<tr>
                                                <td><?php echo $j++;?></td>
						<td><?php echo $ipProcedure[$i][2];?></td>
						<td><?php echo $ipProcedure[$i][4];?></td>						
						<td><?php echo $ipProcedure[$i][8];?></td>
						
					<?php if($ipProcedure[$i][5] ==0){	?>			
						
						<td>
							  <a href="#" class="deleteProcedure btn btn-danger btn-flat" id="<?php echo $ipProcedure[$i][0];?>"><i class='fa fa-remove'></i></a>
							</td>
					<?php }else{ ?>
					           <td> <p class="text-red"><strong>Deleted</strong></p>
							   Reason:<?php echo $ipProcedure[$i][9];?>
							    </td>
					<?php } ?>
                           
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
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'doctor_visit')?'active' :'';?>" id="tab_2">
                    <div class="row">
					   <div class="col-md-4">
					   
					     <div class="box box-info">
   						      <div class="box-body">
						        <table class="table table-striped">
								  <tr>
								       <td ><?php echo $lang_date; ?>:</td>
								       <td ><input type="text" name="vdate" id="vdate"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/></td>
                                  </tr>

                                  <tr>
								     <td id="noborder"><?php echo $lang_doctor; ?></td>
								     <td id="noborder" >	
											
								      <select name="doctor" id="doctor" keypress="nextField(event.keyCode,Search)" />
						  
						  		          <option value=''>------------------------</option>
						             <?php
								         if(!empty($doctors)){
								
									        for($i=0;$i<count($doctors);$i++){ ?>									
												
												<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
						              <?php			
									        }
								        }
						              ?>							
						
						              </select>
										
								     </td>
								</tr>
                            <tr>
								<td id="noborder"><?php echo $lang_visit_type; ?>:</td>
								<td id="noborder" >	
									<select name="visit_type" id="visit_type">
                                                                          <option value="">--------------</option>
                                                                         <option value="E">Emergency Visit (E)</option>
                                                                          <option value="V">Doctor Visit (V)</option>
                                                                          <option value="IP BILL">IP Billing</option>
                                                                      </select>
								</td>
                                                       </tr>
                                                       <tr>
                                     <td id="noborder">
								
								<input id="button1" type="button" name="add" class="addVisit btn btn-success" value="ADD" /></td>
								</tr>
							</table>
							</div>
						</div>
					   
					   </div>
					    <div class="col-md-6">
						   <div class="box box-info">
   						      <div class="box-body">
						        <table class="table table-striped">
								<thead>
					     <tr>
                                                 <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>                            	              
                                                 <th><a href="#"><?php echo $lang_doctor; ?></a></th> 
						 <th><a href="#"><?php echo $lang_date; ?></a></th> 
						 <th><a href="#"><?php echo $lang_visit_type; ?></a></th>  
                                                 <th><a href="#"><?php echo $lang_user; ?></a></th>   
						 <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($DocVisit)){
                               $j=1;
				for($i=0;$i<count($DocVisit);$i++) {?>
					<tr>
                                                <td><?php echo $j++;?></td>
						<td><?php echo $DocVisit[$i][2];?></td>
						<td><?php echo $DocVisit[$i][4];?></td>						
						<td><?php echo $DocVisit[$i][5];?></td>
                        <td><?php echo $DocVisit[$i][10];?></td>
						
					<?php if($DocVisit[$i][6] ==0){	?>						
						
						<td>
							 <a href="#" class="deleteVisit btn btn-danger btn-flat" id="<?php echo $DocVisit[$i][0];?>"><i class='fa fa-remove'></i></a>
					  </td>
					  <?php }else{ ?>
					           <td> <p class="text-red"><strong>Deleted</strong></p>
							   Reason:<?php echo $DocVisit[$i][9];?>
							    </td>
					<?php } ?>
                           
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
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'nursing_notes')?'active' :'';?>" id="tab_3">
                  <div class="row">
					   <div class="col-md-4">
					   
					     <div class="box box-info">
   						      <div class="box-body">
						        <table class="table table-striped">
								<tr>
								<td id="noborder"><?php echo $lang_date; ?>:</td>
								<td id="noborder" >	
									<input type="text" name="nrdate" id="nrdate"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
								</td>
                                                       </tr>

                                                       <tr>
								<td id="noborder"><?php echo $lang_nursing_notes; ?></td>
								<td id="noborder" >	
								 <textarea cols="35" rows="20" name="nursing_notes" id="nursing_notes"></textarea>
											
								</td>

                                                       </tr>
                                                       
                                                       <tr>
                                                             <td id="noborder" colspan="2" class="text-center">
									
								<input id="button1" type="button" name="add" class="addNotes btn btn-success"  value="ADD" /></td>
								</tr>
								
								</table>
						</div>
						</div>
					</div>
					 <div class="col-md-8">
						   <div class="box box-info">
   						      <div class="box-body">
						        <table class="table table-striped">
								<thead>
					     <tr>
                                                 <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>                            	              
                                                 <th><a href="#"><?php echo $lang_nursing_notes; ?></a></th> 
						 <th><a href="#"><?php echo $lang_date; ?></a></th> 						
                                                 <th><a href="#"><?php echo $lang_user; ?></a></th>   
						 <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($nurNotes)){
                               $j=1;
				for($i=0;$i<count($nurNotes);$i++) {
					$strlen=strlen($nurNotes[$i][1]);

					?>
					<tr>
                                                <td><?php echo $j++;?></td>
						<td>

						<textarea name="nursing_notes_value[]" id="nursing_notes_value_<?php echo $nurNotes[$i][0];?>" position="<?php echo $i; ?>" class="textareaNursingNote" style="height: 200px ; width: 300px"><?php echo $nurNotes[$i][1];?></textarea>

						</td>
						<td><?php echo $nurNotes[$i][2];?></td>						
						<td><?php echo $nurNotes[$i][7];?></td>
                                               
						<?php if($nurNotes[$i][3] ==0){	?>						
						
						<td>

							<a href="#" type="button" class="editNotes btn btn-success btn-flat" id="<?php echo $nurNotes[$i][0];?>"><i class='fa fa-pencil-square-o'></i></a>

							<a href="#" class="deleteNotes btn btn-danger btn-flat" id="<?php echo $nurNotes[$i][0];?>"><i class='fa fa-remove'></i></a>
							</td>
                         <?php }else{ ?>
					           <td> <p class="text-red"><strong>Deleted</strong></p>
							   Reason:<?php echo $nurNotes[$i][6];?>
							    </td>
					<?php } ?>  
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
                  </div><!-- /.tab-pane -->
				    <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'room_transfer')?'active' :'';?>" id="tab_4">
                  <div class="row">
					   <div class="col-md-4">
					   
					     <div class="box box-info">
   						      <div class="box-body">
						        <table class="table table-striped">
								<tr>
						          <td id="noborder">							
								       <?php echo $lang_room_no; ?> <span id='requiredfield'>*</span>:
							       </td>
							          <td id="noborder">
									        <select name="room" id="room">
				
										    <option value="">-----------</option>
					
									        <?php if(!empty($freeRooms)){
				
											for($i=0;$i<count($freeRooms);$i++) { ?>
						
						
												<option value="<?php echo $freeRooms[$i][0];?>"><?php echo $freeRooms[$i][1];?></option>
							
											<?php } ?>
				          
				
				
									    <?php } ?>
					
					
								     </select>
							     </td>
							</tr>
							<tr>
							   <td id="noborder">							
								   <?php echo $lang_bed_no; ?> <span id='requiredfield'>*</span>:
							   </td>
							   <td id="noborder">
								
								  <select name="bed_no" id="bed_no">
								
									
									
								  </select>
							   </td>
							   <tr>
							   <td colspan="2">	<input id="button1" type="button" name="add"  value="TRANSFER ROOM" class="transfer btn btn-success" /></td></td>
							   </tr>
							</tr>
								</table>
								<input type="hidden" name="rent" id="rent" readonly />
								<input type="hidden" name="ncharge" id="ncharge" readonly />
								<input type="hidden" name="mcharge" id="mcharge" readonly />
								</div>
							</div>
						</div>
						 <div class="col-md-6">
               
			                <div class="box box-info">
                
                                 <div class="box-body">
			                          <table class="table table-bordered table-striped"> 
									   <tr>
									     <td>SlNo</td>
										 <td><?php echo $lang_room_no; ?></td>
										 <td><?php echo $lang_bed_no; ?></td>
										 <td><?php echo $lang_from_date; ?></td>
										 <!-- <td><?php echo $lang_from_time; ?></td> -->
										 <td><?php echo $lang_to_date; ?></td>
										 <!-- <td><?php echo $lang_to_time; ?></td> -->
									   </tr>
									   <tr style="font-weight:bold;">
									    <td>1</td>
									     <td><?php echo $roomInfo['room_no'];?></td>
										 <td><?php echo $roomInfo['bed_no'];?></td>
										 <td><?php echo date("d-m-Y",strtotime($roomInfo['admission_date']))." ".$roomInfo['admission_time'];?></td>
										 <!-- <td><?php echo $roomInfo['admission_time'];?></td> -->
										 <td></td>
										 <!-- <td></td> -->
									  <input type="hidden" name="room_id" value="<?php echo $roomInfo['room_id'];?>" />
									  <input type="hidden" name="bed_id" value="<?php echo $roomInfo['bed_id'];?>" />
									  <input type="hidden" name="current_rent" value="<?php echo $roomInfo['rent'];?>" />
									  <input type="hidden" name="current_ncharge" value="<?php echo $roomInfo['ncharge'];?>" />
									  <input type="hidden" name="current_mcharge" value="<?php echo $roomInfo['mcharge'];?>" />
									  <!-- <input type="hidden" name="from_time" value="<?php echo $roomInfo['admission_time'];?>" /> -->
					             </tr>
							<?php
								   if(!empty($roomhist)){
                                    $k=2;
                                     for($i=0;$i<count($roomhist);$i++) {
                                               ?>
											   
								<tr >
									    <td><?php echo $k++;?></td>
									     <td><?php echo $roomhist[$i][7];?></td>
										 <td><?php echo $roomhist[$i][8];?></td>
										 <td><?php echo date("d-m-Y",strtotime($roomhist[$i][2]))." ".$roomhist[$i][12];?></td>
										 <!-- <td><?php echo $roomhist[$i][12];?></td> -->
										 <td><?php echo date("d-m-Y",strtotime($roomhist[$i][3]))." ".$roomhist[$i][13];?></td>
										 <!-- <td><?php echo $roomhist[$i][13];?></td> -->
									  
					             </tr>
											   
							<?php }
							   }
							  ?>
									  
									  </table>
								</div>
							</div>
						 </div>
					</div>
				</div>


                  <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'medicines')?'active' :'';?>" id="tab_5">
                  	<div class="row">
		
		 <div class="col-md-7">
				<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
							<tr>
								<td id="noborder"><?php echo $lang_date; ?>:</td>
								<td id="noborder" >	
									<input type="text" name="date" id="date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
								</td>
                                                       </tr>

				 <tr>
				   <td><?php echo $lang_medicine_prescription;?></td>
				   <td> <input name="medicines" id="medicines" type="text" size="25" onKeyUp="ajax_showOptions(this,'getMedicines',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_course)" placeholder="medicines" >
                       <input type="hidden" id="medicines_hidden" name="medicines_ID" >
				       <input name="med_course" id="med_course" type="text" size="3" onKeyUp="ajax_showOptions(this,'getMedCourse',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_days)" placeholder="course" >
				       <input type="hidden" id="med_course_hidden" name="med_course_ID" >
				       <input name="med_days" id="med_days" type="text" size="3" autocomplete="off" placeholder="duration" onkeypress="nextField(event.keyCode,qty)" >
				       <input name="qty" id="qty" type="text" size="3" autocomplete="off" placeholder="qty" onkeypress="nextField(event.keyCode,add_medicines)" >
					<!--<a href="#" class="btn btn-success btn-flat" id="med_presc_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
			
                                                             <td id="noborder">
									&nbsp;&nbsp;
								<input id="button1" type="button" name="add_medicines"  value="ADD" class="addMedicines btn btn-success" onkeypress="javascript: if(event.keyCode == 13) {save_ip_medicines()} ;" /></td>
								</tr>
                        </table>

						<table class="table" style="margin-top: 60px;background-color: lightgoldenrodyellow;">
						
						 <tbody>
						  <tr>
						     <th>Note : </th>
						     <th>
						     	<div>
						         Medicines Stock Greater than 10 <span class='glyphicon glyphicon-ok text-success'></span><br><br>
						         Medicines Stock is Less than 10 <span class='glyphicon glyphicon-ok' style='color:#d8ca5f;'></span><br><br>
						         No Medicines Stock <span class='glyphicon glyphicon-remove text-danger'></span>
						        </div>
						     </th>
					     </tr>
						</tbody>
					</table>


					</div>
				</div>
			</div>
			 <div class="col-md-5">
               
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped" id="show_medicines">                 
				          <thead>
					     <tr>
					      <th style="width: 1style="width: 27%;"%;"><a href="#"><?php echo $lang_sl_no; ?></a></th>
                          <th style="width: 49%;"><a href="#"><?php echo $lang_medicines; ?></a></th>
                          <th style="width: 5%;"><a href="#"><?php echo "COURSE"; ?></a></th> 
						  <th style="width: 5%;"><a href="#"><?php echo "DAYS"; ?></a></th> 
						  <th style="width: 13%;"><a href="#"><?php echo $lang_date; ?></a></th>
						  <th style="width: 13%;"><a href="#"><?php echo $lang_qty; ?></a></th>   
						  <th style="width: 27%;"><a href="#"><?php echo $lang_status; ?></a></th> 
						  <th style="width: 27%;"><a href="#"><?php echo $lang_action; ?></a></th>                                
                         </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($medicineInfo)){
                               $j=1;
				for($i=0;$i<count($medicineInfo);$i++) {?>
					<tr  >
                        <td><?php echo $j++;?></td>
						<td><?php if ($medicineInfo[$i][2]!=0) {
							echo $medicineInfo[$i][3];
						}else{echo $medicineInfo[$i][13];} ?></td>
						<td><?php echo $medicineInfo[$i][4];?></td>						
						<td><?php echo $medicineInfo[$i][5];?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($medicineInfo[$i][6]));?></td>
						<td><?php echo $medicineInfo[$i][15];?></td>
						<td class="text-red"><p><strong><?php echo ($medicineInfo[$i][12]!="")?'Purchased':' - '; ;?></strong></p></td>
						
					<?php if($medicineInfo[$i][14] ==0 ){	?>			
						
						<td>
							  <a href="#" class="deleteMedicines btn btn-danger btn-flat" id="<?php echo $medicineInfo[$i][0];?>"><i class='fa fa-remove'></i></a>
							</td>
					<?php }
					else{ ?>
					           <td> <p class="text-red"><strong>Deleted</strong></p>
							   Reason:<?php echo $medicineInfo[$i][10];?>
							    </td>
					<?php } ?>
                           
					</tr>
						
				
		<?php	
			}
			
			}		
		?>
					</tbody>
				</table>

				<!-- <div class="col-md-offset-5 col-md-1" style="margin-top: 20px;" ><input id="button1" type="button" name="save_medicines"  value="Save Medicines" class="save_medicines btn btn-success" /></td></div> -->

			</div>
        </div>
	</div>
        </div>
                  </div><!-- /.tab-pane -->

   <!--------------------new----------------->
                     <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'own_medicines')?'active' :'';?>" id="tab_6">
                  	<div class="row">
		
		 <div class="col-md-3">
				<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
							<tr>
								<td id="noborder"><?php echo $lang_date_time; ?>:</td>
								<td id="noborder" >	
									<input type="datetime-local" name="datetime" id="datetime"  value="" size="25"/>
								</td>
                                                       </tr>

				 <tr>
				   <td><?php echo $lang_drug;?></td>
				   <td> <input name="drug" id="drug" type="text" size="25" onKeyUp="ajax_showOptions(this,'getDrug',event)" autocomplete="off" onkeypress="nextField(event.keyCode,dose)" placeholder="drug" >
                  </td>
                   </tr>
                   <tr>
                  <td><?php echo $lang_dose;?></td>
                  <td>
				       <input name="dose" id="dose" type="text" size="25" onKeyUp="ajax_showOptions(this,'getDose',event)" autocomplete="off" onkeypress="nextField(event.keyCode,route)" placeholder="dose" >
				     
				     </td>
				      </tr>
				      <tr>
				     <td><?php echo $lang_route;?></td>
                  <td>
				       <input name="route" id="route" type="text" size="25" autocomplete="off" placeholder="route" onkeypress="nextField(event.keyCode,frequency)" onKeyUp="ajax_showOptions(this,'getRoute',event)">
				   </td>
				</tr>
				<tr>
				    <td><?php echo $lang_freq;?></td>
                  <td>
				       <input name="frequency" id="frequency" type="text" size="25" autocomplete="off" placeholder="freq" onkeypress="nextField(event.keyCode,remarks_own_medicine)" onKeyUp="ajax_showOptions(this,'getFrequency',event)">
					</td>
				</tr>

						
                              
                               <tr>
                               	<td><?php echo $lang_remarks;?></td>
                                   <td>
                                   	<textarea name="remarks_own_medicine" id="remarks_own_medicine" cols="26" rows="3"></textarea>
                                   </td>
			
                                                             
								</tr>
								<tr>

									<td id="noborder" colspan="5" align="center">
				
								<input id="button1" type="button" name="add_own_medicines"  value="ADD" class="addOwnMedicines btn btn-success btn-sm"  /></td>
								</tr>
                        </table>

						


					</div>
				</div>
			</div>
			 <div class="col-md-9">
               
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped" id="show_own_medicines">                 
				          <thead>
					     <tr>
					      <th  style="width: 1%;" ><a href="#"><?php echo $lang_sl_no; ?></a></th>
					      <th style="width: 9%;"><a href="#"><?php echo $lang_date_time; ?></a></th>
                          <th style="width: 30%;"><a href="#"><?php echo $lang_drug; ?></a></th>
                          <th style="width: 7%;"><a href="#"><?php echo $lang_dose; ?></a></th> 
						  <th style="width: 7%;"><a href="#"><?php echo $lang_route; ?></a></th> 
						  <th style="width: 10%;"><a href="#"><?php echo $lang_freq; ?></a></th>
						  <th style="width: 13%;"><a href="#"><?php echo $lang_remarks; ?></a></th>  
						  <th style="width: 13%;"><a href="#"><?php echo $lang_user; ?></a></th> 
						  <th style="width: 30%;"><a href="#"><?php echo $lang_action; ?></a></th>                                
                         </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($ownMedicines)){
                               $j=1;
				for($i=0;$i<count($ownMedicines);$i++) {?>
					<tr  >
                        <td ><?php echo $j++;?></td>
                        <td>
                        	<?php echo date("d-m-Y h:i:s a",strtotime($ownMedicines[$i][2])); ?>
                        </td>
						<td>
							<input name="drug_value[]" id="drug_value_<?php echo $ownMedicines[$i][0];?>" type="text"  onKeyUp="ajax_showOptions(this,'getDrug',event)" autocomplete="off" onkeypress="nextField(event.keyCode,dose)" placeholder="drug" value="<?php echo $ownMedicines[$i][3]; ?>" position="<?php echo $i; ?>" size="33">
						</td>
						<td>
							
							<input name="dose_value[]" id="dose_value_<?php echo $ownMedicines[$i][0];?>" type="text" size="5" onKeyUp="ajax_showOptions(this,'getDose',event)" autocomplete="off" onkeypress="nextField(event.keyCode,route)" placeholder="dose" value="<?php echo $ownMedicines[$i][4]; ?>" position="<?php echo $i; ?>">
						</td>						
						<td>
							<input name="route_value[]" id="route_value_<?php echo $ownMedicines[$i][0];?>" type="text" size="5" autocomplete="off" placeholder="route" onkeypress="nextField(event.keyCode,frequency)" onKeyUp="ajax_showOptions(this,'getRoute',event)" value="<?php echo $ownMedicines[$i][5]; ?>" position="<?php echo $i; ?>">
						</td>
						<td>
							<input name="frequency_value[]" id="frequency_value_<?php echo $ownMedicines[$i][0];?>" type="text" size="5" autocomplete="off" placeholder="freq" onkeypress="nextField(event.keyCode,remarks_own_medicine)" onKeyUp="ajax_showOptions(this,'getFrequency',event)" value="<?php echo $ownMedicines[$i][6]; ?>" position="<?php echo $i; ?>">
						</td>
						<td>
							<textarea name="remarks_own_medicine_value[]" id="remarks_own_medicine_value_<?php echo $ownMedicines[$i][0];?>" position="<?php echo $i; ?>"><?php echo $ownMedicines[$i][7];?></textarea>
						</td>
						<td><?php echo $ownMedicines[$i][11];?></td>
						
						
							
						
						<td>
							
							  <a href="#" type="button" class="editOwnMedicines btn btn-success btn-sm" id="<?php echo $ownMedicines[$i][0];?>"><i class='fa fa-pencil-square-o'></i></a>
							<a href="#" class="deleteOwnMedicines btn btn-danger btn-sm" id="<?php echo $ownMedicines[$i][0];?>"><i class='fa fa-remove'></i></a>
					
					

						</td>
			
                           
					</tr>
						
				
		<?php	
			}
			
			}		
		?>
					</tbody>
				</table>

				<!-- <div class="col-md-offset-5 col-md-1" style="margin-top: 20px;" ><input id="button1" type="button" name="save_medicines"  value="Save Medicines" class="save_medicines btn btn-success" /></td></div> -->

			</div>
        </div>
	</div>
        </div>
                  </div><!-- /.tab-pane -->
   
  <!-- ------------------------------------- -->               


                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
          

        
          <!-- END CUSTOM TABS -->
		  
<input type="hidden" name="del_details" id="del_details">
<input type="hidden" name="id" id="id">

<input type="hidden" name="ipno" id="ipno" value="<?php echo $patientInfo[0][13];?>">
<input type="hidden" name="sub_tab" id="sub_tab" value="<?php echo $subtab;?>">

<input type="hidden" name="nursing_id" id="nursing_id" value="">
<input type="hidden" name="nursing_note_data" id="nursing_note_data" value="">

<input type="hidden" name="drug_data" id="drug_data" value="">
<input type="hidden" name="dose_data" id="dose_data" value="">
<input type="hidden" name="route_data" id="route_data" value="">
<input type="hidden" name="freq_data" id="freq_data" value="">
<input type="hidden" name="remarks_data" id="remarks_data" value="">
<input type="hidden" name="own_medicine_id" id="own_medicine_id" value="">


</form>
</body>
</html>