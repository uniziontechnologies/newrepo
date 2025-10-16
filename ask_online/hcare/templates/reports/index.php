<?php require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" type="text/css" href="../../css/theme.css" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link rel="stylesheet" type="text/css" href="../../css/dialog_box.css" />
<script type="text/javascript" src="../../js/dialog_box.js"></script>
<script type="text/javascript" src="../../js/common_functions.js"></script>
<script type="text/javascript" src="../../js/mootools.v1.11.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/dialog_box.css" />
<script type="text/javascript" src="../../js/dialog_box.js"></script>
<script type="text/javascript" src="../../js/DatePicker.js"></script>

<script>

function submitForm(action){

	
	document.report.action="../../lib/controllers/centralController.php?module=Report&sub_module="+action;
	document.report.submit();
}


</script>

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame" >
<form name="report" id="form"  method="post" action="" > 

<?php

//$post=$this->popArr['post'];
?>

 <div id="wrapper">
            <div id="content">
       			<div id="rightnow">
                	<h3 class="reallynow"><?php echo $lang_report; ?></h3>
					
					<?php if(isset($this->popArr['message'])){?>
								<br /><br />
								<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					
			<br />	
			<ul>

			
			     <li><a href="#" onclick="submitForm('daily_collection')">Daily Collection Report</a></li><br />
				 <li><a href="#" onclick="submitForm('bill_collection')">Daily Bill Collection Report</a></li><br />
				  <li><a href="#" onclick="submitForm('doctor_consolidated')">Doctors Report</a></li><br />
				   <li><a href="#" onclick="submitForm('patient_report')">OP Patient Report</a></li><br />
				   <li><a href="#" onclick="submitForm('age_gender_report')">Agewise Patient Report</a></li><br />
				    <li><a href="#" onclick="submitForm('cancelled_op')">OP Cancellation Report</a></li><br />
					<li><a href="#" onclick="submitForm('bill_report')">Bill Report</a></li><br />
					<li><a href="#" onclick="submitForm('bill_report_item_details')">Bill Report [Item Deltails]</a></li><br />
					<li><a href="#" onclick="submitForm('itemwise_bill_report')">Itemwise Bill Report</a></li><br />
					<li><a href="#" onclick="submitForm('itemwise_conso_bill_report')">Itemwise Consolidated Bill Report</a></li><br />
					<li><a href="#" onclick="submitForm('credit_payment')">Credit Payment Report</a></li><br />
				   
			</ul>
			<br />
			<br />
			<br />
		</div>
	</div>
				
 </div>
 

   
    
</form>
</body>
	</html>
	
