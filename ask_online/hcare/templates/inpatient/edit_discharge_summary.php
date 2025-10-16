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
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<script type="text/javascript" src="../../plugins/tinymce/tinymce.min.js">  </script>
<!-- <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>	 -->

<script>

	
    $(function () {
	   // Date range picker
       $('#follow_up').datepicker();
		
	});
	var nanospell_directory  = "nanospell/plugin.js";
	// Tinymce Script
	tinymce.init({
	  oninit : "setPlainText",
	  selector: '.tinymce',
      external_plugins: {"nanospell": nanospell_directory},
      nanospell_server: "php", // choose "php" "asp" "asp.net" or "java"
      nanospell_autostart:true,
	  menubar:false,
      statusbar: false,
	  height: 200,
	  theme: 'modern',
	  plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help paste',
	  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
	  image_advtab: true,
	  templates: [
	    { title: 'Test template 1', content: 'Test 1' },
	    { title: 'Test template 2', content: 'Test 2' }
	  ]
	 });
        
	//Tinymce - copy & paste
 	function setPlainText() {
        var ed = tinyMCE.get('elm1');

        ed.pasteAsPlainText = true;  

        //adding handlers crossbrowser
        if (tinymce.isOpera || /Firefox\/2/.test(navigator.userAgent)) {
            ed.onKeyDown.add(function (ed, e) {
                if (((tinymce.isMac ? e.metaKey : e.ctrlKey) && e.keyCode == 86) || (e.shiftKey && e.keyCode == 45))
                    ed.pasteAsPlainText = true;
            });
        } else {            
            ed.onPaste.addToTop(function (ed, e) {
                ed.pasteAsPlainText = true;
            });
        }
    }
           
    // Appending Text Fields 
	function add_new_data_field(name,id){
		
		var value = $("#"+name+"_"+id).val();

		var row_count = $("#"+id+"_row_count").val();

		if (value!="") {


		    if (row_count!="") {
		    	$("#"+id+"_row_count").val('');
		        var counter =row_count;
		    }
		    else{
		       var counter = $("#"+id+"_counter").val();
		    }

			counter ++;

			$("#appending_table_"+id+" > tbody").append("<tr id='"+id+"_"+counter+"'><td><input type='text' name='"+id+"[]' value='"+value+"' class='class_input'></td><td class='remove'><a class='red' onclick='remove_row("+id+","+counter+");'>X</a></td><tr>");

			$("#"+name+"_"+id).val("");
			$("#"+id+"_counter").val(counter);

	        if (row_count!="") {
	            $("#"+id+"_text_counter").val(counter);
	        }


		}
		

	}

	// Appending Medicines
	function addMedicines(name,id){
		  
		var medicines=$("#medicines").val();
		var mid=$("#medicines_hidden").val();
		var med_course=$("#med_course").val();
		var med_days=$("#med_days").val();
		    
		if(mid =='') mid=0;
		   
		if(medicines !='' && med_course!="" && med_days !=""){  

			var counter = $("#discharge_advice_counter").val();
			counter ++;

			$("#medicine_table > tbody").append("<tr id='"+id+"_"+counter+"'><td><input type='text' name='medicines[]' value='"+medicines+"' size='40'></td><td><input type='text' name='course[]' value='"+med_course+"' size='3'></td><td><input type='text' name='days[]' value='"+med_days+"' size='3'></td><td class='remove'><a class='red' onclick='remove_row_medicines("+id+","+counter+");'>X</a></td><tr>");

			$("#discharge_advice_counter").val(counter);

            $("#medicines").val('');
            $("#medicines_hidden").val('');
            $("#med_course").val('');
            $("#med_days").val('');		     
            
		   
        }
        // $("#medicines").focus();		

	}

	// Appending Diet Fields 
	function add_new_diet(name,id){
		
		var value = $("#"+name).val();

		var row_count = $("#diet_row_count").val();

		if (value!="") {

		    if (row_count!="") {
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#diet_counter").val();
		    }

			counter ++;

			$("#diet_table > tbody").append("<tr id='"+id+"_"+counter+"'><td><input type='text' name='"+id+"[]' value='"+value+"' class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_diet("+id+","+counter+");'>X</a></td><tr>");

			$("#"+name).val("");
			$("#diet_counter").val(counter);

	        if (row_count!="") {
	            $("#diet_row_count").val(counter);
	        }


		}
		
		

	}

	// Appending Remarks Fields
	function add_new_remarks(name,id){
		
		var value = $("#"+name).val();

		var row_count = $("#remarks_row_count").val();

		if (value!="") {

		    if (row_count!="") {
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#remarks_counter").val();
		    }

			counter ++;

			$("#remarks_table > tbody").append("<tr id='"+id+"_"+counter+"'><td><input type='text' name='"+id+"[]' value='"+value+"' class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_remarks("+id+","+counter+");'>X</a></td><tr>");

			$("#"+name).val("");
			$("#remarks_counter").val(counter);

	        if (row_count!="") {
	            $("#remarks_row_count").val(counter);
	        }


		}
		

	}

	// Appending Consultant Details Fields
	function add_new_consultant_details(name,id){
		
		var value = $("#"+name).val();

		var consultant_row_count = $("#consultant_row_count").val();

		if (value!="") {

			// var counter = $("#consultant_details_counter").val();

		    if (consultant_row_count!="") {
		        var counter =consultant_row_count;
		    }
		    else{
		        var counter = $("#consultant_details_counter").val();
		    }


			counter ++;

			$("#consultant_details > tbody").append("<tr id='"+id+"_"+counter+"'><td><input type='text' name='"+id+"[]' value='"+value+"' class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_consultant("+id+","+counter+");'>X</a></td><tr>");

			$("#"+name).val("");
			$("#consultant_details_counter").val(counter);

	        if (consultant_row_count!="") {
	            $("#consultant_row_count").val(counter);
	        }


		}
		

	}


$(document).ready(function() {

  $("#save_form").click(function(){

    $("#discharge_summary").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=update_discharge_summary");
    $("#discharge_summary").submit();
	return true;


  });

 });




</script>

<body id="frame" >
<form name="discharge_summary" id="discharge_summary"  method="post" action="" > 

<?php

$patientInfo=$this ->popArr['patient_info'];
$template_selected=$this ->popArr['template_selected'];
$template_selected_items=$this ->popArr['template_selected_items'];
$doctors=$this ->popArr['doctors'];
$post=$this ->popArr['postArr'];
$dischargeInfo=$this ->popArr['dischargeInfo'];
$dischargeInfoFields=$this ->popArr['dischargeInfoFields'];
$dischargeInfoValues=$this ->popArr['dischargeInfoValues'];

$ipBillDates=$this ->popArr['ipBillDates'];
$ipBillIds=$this ->popArr['ipBillIds'];
$resultEntryInfo=$this ->popArr['resultEntryInfo'];

$doctors_info=$this ->popArr['doctors_info'];

// var_dump($template_selected_items);


?>
<style type="text/css">
    a.red {
        color: red;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }
    .class_input{
    	width: 80%;
    }
   	.investigation_report {
	    background: lightblue;
	    height: 50px;
	    padding-top: 12px;
	    /* padding-bottom: 15px; */
	    text-align: center;
	    font-size: 20px;
	    text-transform: capitalize;
	    margin-bottom: 30px;
	    border-radius: 5px;
	    margin-left: 15px;
	    width: 40%;
	}
</style>

<div id="content">

<section class="content">
					 
	<div class="box box-info">
                
               <div class="box-body">
			    <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_ip_no; ?> : <input type="text" name="ip_no" value="<?php echo strtoupper($patientInfo[0][13]); ?>" id="ip_no" readonly size="10"/>
                      <!-- $patientInfo[$i][65] -->
                      <input type="hidden" name="ip_no_yr" value="<?php echo strtoupper($patientInfo[0][65]); ?>" id="ip_no_yr" readonly size="10"/>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_name; ?> : <input type="text" name="patient_name" value="<?php echo strtoupper(strtolower(($patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3]))); ?>" id="patient_name" readonly size="10"/>
                    </div>
                    <div class="col-xs-5">
					 <?php echo $lang_room_no; ?> : <input type="text" name="room_no" value="<?php echo strtoupper($patientInfo[0][37].'(BED:'.$patientInfo[0][38].')'); ?>" id="room_no" readonly size="15"/>
                   
                    </div>
                  </div>
				   <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_doa; ?> : <input type="text" name="date_of_admission" value="<?php echo strtoupper($patientInfo[0][20]); ?>" id="date_of_admission" readonly size="10"/>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_dod; ?>* : <input type="text" name="discharge_date" value="<?php echo date('d-m-Y',strtotime($dischargeInfo[0][4])) ?>" id="discharge_date" class="DatePicker"readonly size="10"/>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div>
				
			       </div>
	</div>
			       <h4><?php echo $template_selected[0][1];?></h4>


			<?php

				if (!empty($template_selected_items)) {
					
					for ($i=0; $i <count($template_selected_items) ; $i++) { 

						if ($template_selected_items[$i][4]=="CONSULTANT_DETAILS") {?>

							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
											           <th><input type="text" name="add_new_data" id="<?php echo $template_selected_items[$i][4];?>" style="width: 80%;" onkeydown="javascript: if(event.keyCode == 13) add_new_consultant_details('<?php echo $template_selected_items[$i][4];?>','<?php echo $template_selected_items[$i][0];?>');"></th>
											       	</tr>
												</thead>

										</table>

									  </div>
									</div>
								</div>

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="consultant_details">
												<thead><td><?php echo $template_selected_items[$i][3]; ?></td></thead>
												<tbody>


													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {?>

																	<tr id="<?php echo $template_selected_items[$i][0]; ?>_<?php echo $j+1; ?>"><td><input type='text' name="<?php echo $template_selected_items[$i][0]; ?>[]" value="<?php echo $dischargeInfoValues[$i][$j][$k][3]; ?>" class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_consultant("<?php echo $template_selected_items[$i][0]; ?>","<?php echo $j+1; ?>");'>X</a></td><tr>

																	
																<?php

																}
		
															}

															}

														}

													 ?>



												</tbody>
											</table>

										</div> 

										<input type="hidden" name="counter[]" id="consultant_details_counter" value="0">
										<input type="hidden" name="consultant_row_count" id="consultant_row_count" value="<?php echo(!empty($doctors)?count($doctors):''); ?>">
									  </div>
								</div>

							</div>

						<?php
						}
						else if ($template_selected_items[$i][4]=="TEXT_FIELD") {?>

							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
											           <th><input type="text" name="add_new_data" id="<?php echo $template_selected_items[$i][4];?>_<?php echo $template_selected_items[$i][0];?>" style="width: 80%;" onkeydown="javascript: if(event.keyCode == 13) add_new_data_field('<?php echo $template_selected_items[$i][4];?>','<?php echo $template_selected_items[$i][0];?>');"></th>
											       	</tr>
												</thead>

										</table>

									  </div>
									</div>
								</div>

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="appending_table_<?php echo $template_selected_items[$i][0]; ?>">
												<thead><td><?php echo $template_selected_items[$i][3]; ?></td></thead>
												<tbody>

													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {?>

																	<tr id="<?php echo $template_selected_items[$i][0]; ?>_<?php echo $k+1; ?>"><td><input type='text' name="<?php echo $template_selected_items[$i][0]; ?>[]" value="<?php echo $dischargeInfoValues[$i][$j][$k][3]; ?>" class='class_input'></td><td class='remove'><a class='red' onclick='remove_row("<?php echo $template_selected_items[$i][0]; ?>","<?php echo $k+1; ?>");'>X</a></td><tr>

																		<input type="hidden" name="consultant_row_count" id="<?php echo $template_selected_items[$i][0]; ?>_row_count" value="<?php echo(!empty($dischargeInfoValues[$i][$j])?count($dischargeInfoValues[$i][$j]):''); ?>">

																	
																<?php

																}
		
															}

															}

														}

													 ?>

				        			
												</tbody>
											</table>

										</div> 

										<input type="hidden" name="counter[]" id="<?php echo $template_selected_items[$i][0]; ?>_counter" value="0">
										<input type="hidden" name="counter[]" id="<?php echo $template_selected_items[$i][0]; ?>_text_counter" value="0">
										
									  </div>
								</div>

							</div>

						<?php
						}
						else if ($template_selected_items[$i][4]=="TINYMCE") {?>

							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="tinymce_<?php echo $template_selected_items[$i][3]; ?>">
												<thead><th><?php echo $template_selected_items[$i][3]; ?></th></thead>
												<tbody>
													<tr>
														<td>
															<textarea class="tinymce" name="<?php echo $template_selected_items[$i][0]; ?>_tinymce[]">													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {

																echo $dischargeInfoValues[$i][$j][$k][3]; 

																}
		
															}

															}

														}

													 ?></textarea>
														</td>
													</tr>
				        							
												</tbody>
											</table>

										</div> 
									  </div>
								</div>
								<input type="hidden" name="<?php echo $template_selected_items[$i][0]; ?>_tinymce_order[][]" value="<?php echo $template_selected_items[$i][2]; ?>">
							</div>


						<?php
						}
						else if ($template_selected_items[$i][4]=="DISCHARGE_ADVICE") {?>


							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
											           <th>
 														<input name="medicines" id="medicines" class="medicines" type="text" size="25" onKeyUp="ajax_showOptions(this,'getMedicines',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_course)">
                                       					<input type="hidden" id="medicines_hidden" name="medicines_ID" >
				       									<input name="med_course" id="med_course" type="text" size="3" onKeyUp="ajax_showOptions(this,'getMedCourse',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_days)">
				       									<input name="med_days" id="med_days" type="text" size="3" autocomplete="off" onkeydown="javascript: if(event.keyCode == 13) addMedicines('<?php echo $template_selected_items[$i][3];?>','<?php echo $template_selected_items[$i][0];?>');" onkeypress="nextField(event.keyCode,medicines)">



											           </th>
											          
											       	</tr>
												</thead>

										</table>

									  </div>
									</div>
								</div>

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="medicine_table">
												<thead><td><?php echo $template_selected_items[$i][3]; ?></td></thead>
												<tbody>


													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {

													$items[$i][$j][$k]=explode("#@&",$dischargeInfoValues[$i][$j][$k][3]);
													
													if (!empty($items[$i][$j][$k])) {?>



																	<tr id="<?php echo $template_selected_items[$i][0]; ?>_<?php echo $k+1; ?>"><td><input type='text' name="medicines[]" value="<?php echo $items[$i][$j][$k][0]; ?>" size="50"></td><td><input type='text' name="course[]" value="<?php echo $items[$i][$j][$k][1]; ?>" size="3"></td><td><input type='text' name="days[]" value="<?php echo $items[$i][$j][$k][2]; ?>" size="3"></td><td class='remove'><a class='red' onclick='remove_row_medicines("<?php echo $template_selected_items[$i][0]; ?>","<?php echo $k+1; ?>");'>X</a></td><tr>

																		<input type="hidden" id="medicines_row_count" value="<?php echo(!empty($dischargeInfoValues[$i][$j])?count($dischargeInfoValues[$i][$j]):''); ?>">

																	
																<?php

																}

															}
		
															}

															}

														}

													 ?>




												</tbody>
											</table>

										</div> 

										<input type="hidden" name="counter[]" id="discharge_advice_counter" value="0">
										<input type="hidden" name="medicine_order" value="<?php echo $template_selected_items[$i][2]; ?>">
										<input type="hidden" id="total_medicine_count" value="0">
									  </div>
								</div>

							</div>



					<?php	
					}
					else if ($template_selected_items[$i][4]=="DIET") {?>


							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
											           <th><textarea id="<?php echo $template_selected_items[$i][3];?>" name="diet" style="width: 80%;" onkeydown="javascript: if(event.keyCode == 13) add_new_diet('<?php echo $template_selected_items[$i][3];?>','<?php echo $template_selected_items[$i][0];?>')"></textarea></th>
											       	</tr>
												</thead>

										</table>

									  </div>
									</div>
								</div>

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="diet_table">
												<thead><td><?php echo $template_selected_items[$i][3]; ?></td></thead>
												<tbody>
				        			

													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {?>

																	<tr id="<?php echo $template_selected_items[$i][0]; ?>_<?php echo $k+1; ?>"><td><input type='text' name="<?php echo $template_selected_items[$i][0]; ?>[]" value="<?php echo $dischargeInfoValues[$i][$j][$k][3]; ?>" class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_diet("<?php echo $template_selected_items[$i][0]; ?>","<?php echo $k+1; ?>");'>X</a></td><tr>

																		<input type="hidden" id="diet_row_count" value="<?php echo(!empty($dischargeInfoValues[$i][$j])?count($dischargeInfoValues[$i][$j]):''); ?>">
																	
																<?php

																}
		
															}

															}

														}

													 ?>



												</tbody>
											</table>

										</div> 

										<input type="hidden" name="counter[]" id="diet_counter" value="0">
										<input type="hidden" id="total_diet_counter" value="0">
									  </div>
								</div>

							</div>




					<?php
					}
					else if ($template_selected_items[$i][4]=="FOLLOW_UP") {?>



							<div class="row">

								<div class="box box-info">
						                
						            <div class="box-body">

						        		<div class="col-md-3">

										     <table class="table table-bordered table-striped">

													<thead>
												     	<tr>
												           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
												       	</tr>
													</thead>

											</table>

										</div>

								        <div class="col-md-3">
											
											<input type="text" name="follow_up_date" id="follow_up" readonly="" class="DatePicker" value="<?php echo(!empty($dischargeInfo[0][6])?date('d-m-Y',strtotime($dischargeInfo[0][6])):''); ?>">

										</div>


									</div>

								</div>

							</div>



					<?php
					}
					else if ($template_selected_items[$i][4]=="REMARKS") {?>


							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo $template_selected_items[$i][3];?></th>
											           <th><textarea id="<?php echo $template_selected_items[$i][3];?>" name="diet" style="width: 80%;" onkeydown="javascript: if(event.keyCode == 13) add_new_remarks('<?php echo $template_selected_items[$i][3];?>','<?php echo $template_selected_items[$i][0];?>')"></textarea></th>
											       	</tr>
												</thead>

										</table>

									  </div>
									</div>
								</div>

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="remarks_table">
												<thead><td><?php echo $template_selected_items[$i][3]; ?></td></thead>
												<tbody>
				        			
													<?php

														if (!empty($dischargeInfoValues)) {

															for ($j=0; $j <count($dischargeInfoValues); $j++) {

																for ($k=0; $k <count($dischargeInfoValues[$i][$j]) ; $k++) { 
 

																if ($template_selected_items[$i][3]==$dischargeInfoValues[$i][$j][$k][5]) {?>

																	<tr id="<?php echo $template_selected_items[$i][0]; ?>_<?php echo $k+1; ?>"><td><input type='text' name="<?php echo $template_selected_items[$i][0]; ?>[]" value="<?php echo $dischargeInfoValues[$i][$j][$k][3]; ?>" class='class_input'></td><td class='remove'><a class='red' onclick='remove_row_remarks("<?php echo $template_selected_items[$i][0]; ?>","<?php echo $k+1; ?>");'>X</a></td><tr>

																		<input type="hidden" id="remarks_row_count" value="<?php echo(!empty($dischargeInfoValues[$i][$j])?count($dischargeInfoValues[$i][$j]):''); ?>">
																	
																<?php

																}
		
															}

															}

														}

													 ?>


												</tbody>
											</table>

										</div> 

										<input type="hidden" name="counter[]" id="remarks_counter" value="0">
										<input type="hidden" id="total_remarks_counter" value="0">
									  </div>
								</div>

							</div>



					<?php
					}
					else if ($template_selected_items[$i][4]=="INVESTIGATION") {?>

						<div class="row">
							
							<div class="col-md-4 investigation_report">
								
								<p>Investigation Report Automatically Generated</p>

							</div>

							<input type="hidden" name="investigation_report" id="investigation_report" value="<?php echo $template_selected_items[$i][2]; ?>">


						</div>

					<?php
					}
					else if ($template_selected_items[$i][4]=="LAB_REPORTS") {?>


							<div class="row">

						        <div class="col-md-6">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

											<table class="table table-striped" id="tinymce_<?php echo $template_selected_items[$i][3]; ?>">
												<thead><th><?php echo $template_selected_items[$i][3]; ?></th></thead>
												<tbody>
													<tr>
														<td>

															<textarea class="tinymce" name="<?php echo $template_selected_items[$i][0]; ?>_tinymce[]">
																

															<?php 

																if (!empty($resultEntryInfo)) {?>





																	<table>
																				
																		<tr>
																		<?php 

																			if (!empty($ipBillDates)) {
																				
																				for ($x=0; $x < count($ipBillDates) ; $x++) { ?>
																				
																					<td><?php echo date("d-m-Y",strtotime($ipBillDates[$x])); ?><br>


																						<?php 

																							for ($y=0; $y < count($ipBillIds[$x]) ; $y++) { 


																								
																								for ($z=0; $z < count($resultEntryInfo[$x][$y]) ; $z++) { 

																									if ($resultEntryInfo[$x][$y][$z][7]!=3) {?>
																										
																										<span><?php echo $resultEntryInfo[$x][$y][$z][3]."<br>"; ?></span>
																									<?php
																									}
																									
																								}

																							}

																						?>

																					</td>

																				<?php	
																				}

																			}


																		?>

																		</tr>


																	</table>



															<?php
																}


															?>


															</textarea>

														</td>
													</tr>
				        							
												</tbody>
											</table>

										</div> 
									  </div>
								</div>
								<input type="hidden" name="<?php echo $template_selected_items[$i][0]; ?>_tinymce_order[][]" value="<?php echo $template_selected_items[$i][2]; ?>">
							</div>




					<?php
					}

					else if ($template_selected_items[$i][4]=="CONSULTATION_DETAILS") {  

						for ($j=0; $j < count($dischargeInfoValues) ; $j++) { 
							
							for ($k=0; $k < count($dischargeInfoValues[$i][$j]) ; $k++) { 
								
								$doctors_array = $dischargeInfoValues[$i][$j][$k][3];

							}

						}

						$doctors_array = explode(",", $doctors_array);

						// var_dump();

						?>

							<div class="row">

						        <div class="col-md-8">
										
								     <div class="box box-info">
						                
						                <div class="box-body">

									     <table class="table table-bordered table-striped">

												<thead>
											     	<tr>
											           <th id="noborder" width="165"><?php echo "CONSULTATION DETAILS";?></th>
											       	</tr>

											       	<tr>

											       		<td>
											       			
											       			<select id="doctors_selected" name="doctors_selected[]" multiple>
											       				
											       				<!-- <option>------- Please select ------</option> -->

											       				<?php 

											       					if (!empty($doctors_info)) {
											       						
											       						for ($u=0; $u < count($doctors_info) ; $u++) { ?>
											       							
											       							<option value="<?php echo $doctors_info[$u][0]; ?>" <?php if(in_array($doctors_info[$u][0], $doctors_array)){echo "selected";} ?> ><?php echo $doctors_info[$u][1]." ".$doctors_info[$u][2]." ".$doctors_info[$u][3]; ?></option>

											       						<?php
											       						}

											       					}


											       				?>

											       			</select>

											       		</td>

											       	</tr>

												</thead>

										</table>

									  </div>
									</div>
								</div>

							</div>

							<input type="hidden" name="doctors_selected_position" id="doctors_selected_position" value="<?php echo $template_selected_items[$i][2]; ?>">

					<?php
					}






				}

			}


			 ?>




			 <div class="row">
			 	
			 	<div class="col-md-2">
			 		
			 		<input type="button" name="save" id="save_form" value="Update" class="btn btn-success">


			 	</div>

			 </div>











	</div>

</section>

<input type="hidden" name="template_id" id="template_id" value="<?php echo(!empty($dischargeInfo[0][14])?$dischargeInfo[0][14]:''); ?>">
<input type="hidden" name="discharge_id" id="discharge_id" value="<?php echo(!empty($dischargeInfo[0][0])?$dischargeInfo[0][0]:''); ?>">
<input type="hidden" name="update_history" id="update_history" value="<?php echo $_SESSION['user_id'].'|'.'UPDATE'.'|'.date('Y-m-d h:i:s A'); ?>">

<?php

	for ($i=0; $i < count($template_selected_items); $i++) { ?>

		<input type="hidden" name="post_values[]" id="<?php echo $template_selected_items[$i][3]; ?>" value="<?php echo $template_selected_items[$i][0]; ?>">

		<input type="hidden" name="post_values_order[]" id="<?php echo $template_selected_items[$i][3]; ?>" value="<?php echo $template_selected_items[$i][2]; ?>">

	<?php
	}


 ?>


</form>
          
<script type="text/javascript">
	

		function remove_row(id,counter){
			
			$('table tr#'+id+"_"+counter).remove();

		    var row_count = $("#"+id+"_row_count").val();

		    if (row_count!="") {
		    	$("#"+id+"_row_count").val('');
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#"+id+"_counter").val();
		    }

			$("#"+id+"_counter").val(--counter);

		    if (row_count!="") {
		       $("#"+id+"_text_counter").val(--row_count);
		    }

			

		}
		function remove_row_diet(id,counter){
			
			$('table tr#'+id+"_"+counter).remove();

		    var row_count = $("#diet_row_count").val();

		    if (row_count!="") {
		    	$("#diet_row_count").val('');
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#diet_counter").val();
		    }

			$("#diet_counter").val(--counter);

		    if (row_count!="") {
		       $("#total_diet_counter").val(--row_count);
		    }


		}
		function remove_row_remarks(id,counter){
			
			$('table tr#'+id+"_"+counter).remove();

		    var row_count = $("#remarks_row_count").val();

		    if (row_count!="") {
		    	$("#remarks_row_count").val('');
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#remarks_counter").val();
		    }

			$("#remarks_counter").val(--counter);

		    if (row_count!="") {
		       $("#total_remarks_counter").val(--row_count);
		    }

		}
		function remove_row_medicines(id,counter){
			
			$('table tr#'+id+"_"+counter).remove();


		    var row_count = $("#medicines_row_count").val();

		    if (row_count!="") {
		    	$("#medicines_row_count").val('');
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#discharge_advice_counter").val();
		    }

			$("#discharge_advice_counter").val(--counter);

		    if (row_count!="") {
		       $("#total_medicine_count").val(--row_count);
		    }


			// var counter = $("#discharge_advice_counter").val();
			// $("#discharge_advice_counter").val(--counter);

		}
		function remove_row_consultant(id,counter){
			
			$('table tr#'+id+"_"+counter).remove();


		    var consultant_row_count = $("#consultant_row_count").val();

		    if (consultant_row_count!="") {
		        var counter =consultant_row_count;
		    }
		    else{
		        var counter = $("#consultant_details_counter").val();
		    }

			// var counter = $("#consultant_details_counter").val();
			$("#consultant_details_counter").val(--counter);

		    if (consultant_row_count!="") {
		       $("#consultant_row_count").val(--consultant_row_count);
		    }



		}


</script>
 <script>
      $(function () {
	  
	   //Date range picker
        $('#discharge_date').datepicker();
		
		
	  });
	  </script>