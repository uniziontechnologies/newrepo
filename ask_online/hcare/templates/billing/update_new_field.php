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
    <link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
     
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
   <script type="text/javascript" src="../../dist/js/thickbox.js"></script>
   <script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
       
    function form_submit(){	

		document.form_submit.action="../../lib/controllers/centralController.php?module=Billing&sub_module=update_field_values";
		document.form_submit.submit();
	}
     
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="form_submit" id="form_submit"  method="post" action="../../lib/controllers/centralController.php?module=Billing&sub_module=update_field_values"> 
<?php
			
   $field_id =$this->popArr['field_id'];
   $particular =$this->popArr['particular'];
 
?>
<section class="content-header">
          <h4><?php echo $lang_update." ".$lang_bill_items; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
					<input type="text" name="particular_update" value="<?php echo $particular; ?>" autocomplete="off">
					<input type="hidden" name="item_id_update" value="<?php echo $field_id; ?>">
					
					<input type="submit" name="submit" class="btn btn-success">
				</div>
			</div>
				
					
			<div class="box box-info">
                
               <div class="box-body">
			       
                        
                         
           
          
			</div>
				</div>
				
				
				 </div>
           
      </div>

	     
</form>	  
</body>
	</html>
                
