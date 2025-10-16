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
           
  $("#select").click(function(){


			   if($("#select_template").val() == ""){
				   showDialog('Error','Please Select A Template','error',2);
			      return false;
			   }else{

                 $("#template_id").val($("#select_template").val());

		         $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=discharge_summary");
   	             $("#form").submit();
				 return true;

			   }



  });  

 //  $("#add_template").click(function(){

	// $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=create_template");
 //   	$("#form").submit();
	// return true;	

 //  });      
	
	
			
});




</script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>

<body id="frame" >
<form name="discharge_summary" id="form"  method="post" action="" > 

<?php

$post=$this ->popArr['postArr'];
$templates=$this ->popArr['templates'];



?>
<style type="text/css">
    a.red {
        color: red;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }
</style>
<div id="content">

<form id="template_select" name="template_select" method="post" action="">
 
<!-- <section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" id="add_template"><i class="fa fa-plus"></i><?php echo $lang_add." ".$lang_template;?></font></button>
           
          </ol>
</section> -->


<section class="content">
					 
	<div class="box box-info">

		<h4><?php echo $lang_discharge_summary_template;?></h4>  

        <div class="box-body">

        	<div class="row">
        		
        		<div class="col-md-2">
        			
					<label>Select Template : </label>

        		</div>

        		<div class="col-md-3">
        			
        			<select id="select_template" name="select_template" class="form-control">

        				<option value="">---- Please Select ---</option>
        				<?php

        					if (!empty($templates)) {
        						
        						for ($i=0; $i <count($templates) ; $i++) { ?>
        							<option value="<?php echo $templates[$i][0]; ?>"><?php echo $templates[$i][1]; ?></option>
        						<?php
        						}

        					}

        				 ?>
        				
        			</select>

        		</div>


        	</div>

        	<div class="row" style="margin-top: 20px;">
        		
        		<div class="col-md-offset-2 col-md-2">
        			
					<input type="button" name="select" id="select" class="btn btn-success" value="Select">

        		</div>

        	</div>


		</div>

	</div>
			      

</section>
<input type="hidden" name="ip_id" id="ip_id" value="<?php if(!empty($post['id'])){echo $post['id'];} ?>">
<input type="hidden" name="template_id" id="template_id" value="">
</form>