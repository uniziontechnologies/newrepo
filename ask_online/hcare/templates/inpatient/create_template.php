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
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>

<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#dod').datepicker();
		
	  });
	  </script>
	 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>	
<script>

$(document).ready(function() {           
           
  $("#save").click(function(){



               if($("#template_name").val() == ""){
                   showDialog('Error','Please Add Template Name','error',2);
                   return false;
               }
               else if ($("table#add_new_fields tbody").children().length == 0) {
                   showDialog('Error','Please Add Atleast One Fields','error',2);
                   return false;
               }
               else{

                    $("#create_template").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=add_new_template");
                    $("#create_template").submit();
				    return true;

			   }



  }); 


  $("#update").click(function(){

        var field_counter = $("#field_counter").val();

        if (field_counter==0) {
            $("#field_counter").val($("#row_count").val());
        }

        $("#create_template").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=update_template");
        $("#create_template").submit();
        return true;



  }); 

   	
	
			
});

function add_new_field(){

    var row_count = $("#row_count").val();

    if (row_count!="") {
        var field_counter =row_count;
    }
    else{
        var field_counter = $("#field_counter").val();
    }
    
    // var field_counter = $("#field_counter").val();
    field_counter ++;
    
    var field_name = $("#field_name").val();

    

        if (field_name=="") {
            showDialog('Error','Please Add Field Name','error',2);
        }
        else if ($("#field_type").prop("checked")==false) {

        var field_type = "TEXT_FIELD";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control'><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'><a class='red' onclick='remove_row("+field_counter+");'>X</a></td><tr>");

        $("#field_name").val("");
        $('#field_type').attr('checked', false);
        $("#field_counter").val(field_counter);

        if (row_count!="") {
            $("#row_count").val(field_counter);
        }

    }
    else if ($("#field_type").prop("checked")==true) {

        var field_type = "TINYMCE";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control'><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'><a class='red' onclick='remove_row("+field_counter+");'>X</a></td><tr>");

        $("#field_name").val("");
        $('#field_type').attr('checked', false);
        $("#field_counter").val(field_counter);

    }

    return false;
}

function remove_row(id){

    $('table#add_new_fields tr#'+id).remove();

    var row_count = $("#row_count").val();

    if (row_count!="") {
        var field_counter =row_count;
    }
    else{
        var field_counter = $("#field_counter").val();
    }
    
    // var field_counter = $("#field_counter").val();
    // field_counter ++;
    $("#field_counter").val(--field_counter);

    if (row_count!="") {
       $("#row_count").val(--row_count);
    }

   
}
function add_investigation(){

    if ($("#investigation").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "INVESTIGATION";

        var field_type = "INVESTIGATION";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#investigation_id").val(field_counter);


    }
    else{

        remove_row($("#investigation_id").val());
        $("#investigation_id").val('');
        
    }

}
function add_discharge_advice(){

    if ($("#discharge_advice").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "DISCHARGE ADVICE";

        var field_type = "DISCHARGE_ADVICE";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#discharge_advice_id").val(field_counter);


    }
    else{

        remove_row($("#discharge_advice_id").val());
        $("#discharge_advice_id").val('');
        
    }

}
function add_diet(){

    if ($("#diet").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "DIET";

        var field_type = "DIET";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#diet_id").val(field_counter);


    }
    else{

        remove_row($("#diet_id").val());
        $("#diet_id").val('');
        
    }

}
function add_followup(){

    if ($("#follow_date").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "FOLLOW UP";

        var field_type = "FOLLOW_UP";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#follow_date_id").val(field_counter);


    }
    else{

        remove_row($("#follow_date_id").val());
        $("#follow_date_id").val('');
        
    }

}
function add_remarks(){

    if ($("#remarks").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "REMARKS";

        var field_type = "REMARKS";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#remarks_id").val(field_counter);


    }
    else{

        remove_row($("#remarks_id").val());
        $("#remarks_id").val('')
        
    }

}
function add_consultant_details(){

    if ($("#consultant_details").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "CONSULTANT DETAILS";

        var field_type = "CONSULTANT_DETAILS";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#consultant_details_id").val(field_counter);


    }
    else{

        remove_row($("#consultant_details_id").val());
        $("#consultant_details_id").val('');
        
    }

}


function add_lab_reports(){

    if ($("#lab_reports").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "LAB_REPORTS";

        var field_type = "LAB_REPORTS";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#lab_reports_id").val(field_counter);


    }
    else{

        remove_row($("#lab_reports_id").val());
        $("#lab_reports_id").val('');
        
    }

}


function add_consultaion_details(){

    if ($("#consultaion_details").prop("checked")==true) {
       

        var row_count = $("#row_count").val();

        if (row_count!="") {
            var field_counter =row_count;
        }
        else{
            var field_counter = $("#field_counter").val();
        }

        field_counter ++;
        
        var field_name = "CONSULTATION_DETAILS";

        var field_type = "CONSULTATION_DETAILS";

        $("table#add_new_fields > tbody").append("<tr id='"+field_counter+"'><td width='10%'><input type='text' name='sl_no[]' value='"+field_counter+"' class='form-control'></td><td width='60%'><input type='text' name='field_name[]' value='"+field_name+"' class='form-control' readonly><td width='20%'><input type='text' name='field_type[]' value='"+field_type+"' class='form-control' readonly></td><td width='10%' class='remove'></td><tr>");

        $("#field_counter").val(field_counter);

        if (row_count!="") {
           $("#row_count").val(field_counter);
        }

        $("#consultaion_details_id").val(field_counter);


    }
    else{

        remove_row($("#consultaion_details_id").val());
        $("#consultaion_details_id").val('');
        
    }

}




</script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>



<?php

$post=$this ->popArr['postArr'];
$templates=$this ->popArr['templates'];
$template_selected_items=$this ->popArr['template_selected_items'];
$discharge_advice=$this ->popArr['discharge_advice'];
$diet=$this ->popArr['diet'];
$follow_up=$this ->popArr['follow_up'];
$remarks=$this ->popArr['remarks'];
$investigation=$this ->popArr['investigation'];
$lab_reports=$this ->popArr['lab_reports'];
$consultation_details=$this ->popArr['consultation_details'];



require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];

?>
<style type="text/css">
    a.red {
        color: red;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }
    .red{
        padding-top: 10px;
        padding-left: 20px;
    }
    input{
        text-transform: uppercase;
    }
</style>

<body id="frame" >

<div id="content">

<form id="create_template" name="create_template" method="post" action="">

                    <?php if(isset($post['message'])){?>
                    <br />
                        <div id='message' class="callout callout-success"><?php echo $post['message'];?></div>
                    <?php } ?>

<section class="content">
					 
	<div class="box box-info">

		<h4><?php if (!empty($post) && $post['action']=="EDIT_PAGE" ) {
            echo $lang_update." ".$lang_template;
        }else {echo $lang_create." ".$lang_template;} ?></h4>  

        <div class="box-body">

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Template Name</label></b>

                </div>

                <div class="col-md-8">
                    
                   <input type="text" name="template_name" id="template_name" class="form-control" value="<?php echo(!empty($templates[0][1])?$templates[0][1]:''); ?>">

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <label>Title</label>

                </div>

                <div class="col-md-5">
                    
                    <input type="text" name="field_name" id="field_name" class="form-control">

                </div>

                <div class="col-md-1">

                    <b><label>TINYMCE</label></b> :  <input type="checkbox" name="field_type" id="field_type" value="1">

                </div>

                <div class="col-md-3">
                    
                    <a href="#" class="btn btn-success btn-flat" id="add_new_field" onclick="return add_new_field();"><i class="fa fa-plus"></i></a>

                </div>


            </div>


            <div class="row" style="margin-top: 40px;">
                
                <div class="col-md-2">
                    
                   <b><label>Added Fields</label></b>

                </div>

                <div class="col-md-8">
                    
                    <table class="table table-bordered table-striped" id="add_new_fields">

                        <thead>
                            <tr>
                               <th width="10%">Sl No</th>
                               <th width="60%">Name</th>
                               <th width="20%">Field Type</th>
                               <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                if (!empty($template_selected_items)) {
                                    
                                    for ($i=0; $i < count($template_selected_items); $i++) { ?>


                                        <tr id="<?php echo $template_selected_items[$i][0]; ?>">
                                            <td width='10%'>
                                                <input type='text' name='sl_no[]' value="<?php echo $template_selected_items[$i][2] ?>" class='form-control'>
                                            </td>
                                            <td width='60%'>
                                                <input type='text' name='field_name[]' value="<?php echo $template_selected_items[$i][3] ?>" class='form-control' <?php if ($template_selected_items[$i][4]!="TEXT_FIELD" && $template_selected_items[$i][4]!="TINYMCE") {
                                                   echo "readonly";
                                                } ?>>
                                            </td>
                                            <td width='20%'>
                                               <input type='text' name='field_type[]' value="<?php echo $template_selected_items[$i][4] ?>" class='form-control' readonly>
                                            </td>
                                            <td width='10%'>
                                                <a class='red' onclick='remove_row("<?php echo $template_selected_items[$i][0] ?>");'>X</a>
                                            </td>
                                        </tr>


                                    <?php
                                    }

                                }


                             ?>

                            
                        </tbody>
                        
                    </table>

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Consultant Details</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="consultant_details" id="consultant_details" value="1" onclick="add_consultant_details();" <?php echo (!empty($consultant_details)?"checked":''); ?> <?php echo (!empty($consultant_details)?"disabled":''); ?> >

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Discharge with advice</label></b>
                    <br>
                    <span style="color: red;font-weight: 700;">( Medicines )</span>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="discharge_advice" id="discharge_advice" value="1" onclick="add_discharge_advice();" <?php echo (!empty($discharge_advice)?"checked":''); ?> <?php echo (!empty($discharge_advice)?"disabled":''); ?>>

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Diet</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="diet" id="diet" value="1" onclick="add_diet();" <?php echo (!empty($diet)?"checked":''); ?> <?php echo (!empty($diet)?"disabled":''); ?> >

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Follow-up Date</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="follow_date" id="follow_date" value="1" onclick="add_followup();" <?php echo (!empty($follow_up)?"checked":''); ?> <?php echo (!empty($follow_up)?"disabled":''); ?> >

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Remarks</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="remarks" id="remarks" value="1" onclick="add_remarks();" <?php echo (!empty($remarks)?"checked":''); ?> <?php echo (!empty($remarks)?"disabled":''); ?> >

                </div>

            </div>

            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Investigation Report</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="investigation" id="investigation" value="1" onclick="add_investigation();" <?php echo (!empty($investigation)?"checked":''); ?> <?php echo (!empty($investigation)?"disabled":''); ?>>

                </div>

            </div>



            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Lab Report</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="lab_reports" id="lab_reports" value="1" onclick="add_lab_reports();" <?php echo (!empty($lab_reports)?"checked":''); ?> <?php echo (!empty($lab_reports)?"disabled":''); ?>>

                </div>

            </div>


            <div class="row" style="margin-top: 20px;">
                
                <div class="col-md-2">
                    
                    <b><label>Consultation Detials</label></b>

                </div>

                <div class="col-md-6">
                    
                   <input type="checkbox" name="consultaion_details" id="consultaion_details" value="1" onclick="add_consultaion_details();" <?php echo (!empty($consultaion_details)?"checked":''); ?> <?php echo (!empty($consultaion_details)?"disabled":''); ?>>

                </div>

            </div>



            <div class="row" style="margin-top: 50px;">
                
                <div class="col-md-offset-2 col-md-3">
                    
                    <?php
                        if ($post['action']=="EDIT_PAGE") {?>
                            <input type="button" name="update" id="update" value="Update" class="btn btn-success">
                        <?php
                        }
                        else{?>
                            <input type="button" name="save" id="save" value="Save" class="btn btn-success">
                        <?php
                        }
                    ?>

                </div>

            </div>



		</div>

	</div>
			      

</section>
<input type="hidden" name="field_counter" id="field_counter" value="0">
<input type="hidden" name="investigation_id" id="investigation_id" value="">
<input type="hidden" name="discharge_advice_id" id="discharge_advice_id" value="">
<input type="hidden" name="diet_id" id="diet_id" value="">
<input type="hidden" name="follow_date_id" id="follow_date_id" value="">
<input type="hidden" name="remarks_id" id="remarks_id" value="">
<input type="hidden" name="remove_id" id="remove_id" value="">
<input type="hidden" name="row_count" id="row_count" value="<?php echo(!empty($template_selected_items)?count($template_selected_items):''); ?>">
<input type="hidden" name="template_id" id="template_id" value="<?php echo(!empty($templates)?$templates[0][0]:''); ?>">
<input type="hidden" name="consultant_details_id" id="consultant_details_id" value="">
<input type="hidden" name="lab_reports_id" id="lab_reports_id" value="">
<input type="hidden" name="consultaion_details_id" id="consultaion_details_id" value="">
</form>
</div>
</body>