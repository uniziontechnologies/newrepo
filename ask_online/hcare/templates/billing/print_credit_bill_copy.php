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

 <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
 <script language="javascript">
   $(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});

	function submitform() {
	       document.opsheet.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Credit_Billing";
	       document.opsheet.submit();
	}

    </script>
    <style type="text/css">
    	
    @media print{
    	html,body{
    		height: 100%;
    	}
    }

    </style>
</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];
$creditInfo =$this->popArr['creditInfo'];
$billInfo =$this->popArr['billInfo'];
$post =$this->popArr['post'];
$billitemInfo =$this->popArr['billItemInfo'];


?>
<div id="wrapper">
   <div id="content" >
   <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="80px"></img></td>
		</tr> 
	 
	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>


		<?php

			if (!empty($post['is_dupclicate'])) {?>
			
				<tr>
					<td id="noborder" class="duplicate" align="center" style="font-size: 12px;padding-top: 3px;"><label>(duplicate)</label></td>	
				</tr>
				

			<?php
			}


		?>

		
		</table>
		<hr width="100%">
   <table width ="90%"  align="center">
	<tr>
		<td id="noborder">
			 <font <?php echo $lang_font_size;?>><b><?php echo $lang_invoice_no.":&nbsp;".$creditInfo[0][0];?></b></font>
		</td>
		<td id="noborder">
		</td>
		<td id="noborder">
		<font <?php echo $lang_font_size;?>><b><?php echo $lang_date.":&nbsp;".$creditInfo[0][2];?></b></font>
		</td>
		
	</tr>
	<tr>
		<td id="noborder">
		 <font <?php echo $lang_font_size;?>>	<?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][19]; ?></font>
		</td>
		<td id="noborder">
			 <font <?php echo $lang_font_size;?>> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
		</td>
		<td id="noborder">
			 <font <?php echo $lang_font_size;?>> <?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."/ ". $billInfo[0][5];?></font>
		</td>
		<!--<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_date; ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]))." ".$patientInfo[0][19];?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"><?php echo $lang_time; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][19];?></font>
		</td>-->
	</tr>
	<tr>
		
		<td id="noborder">
			 <font <?php echo $lang_font_size;?>> <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][6];?></font>
		</td>
	
		<td id="noborder">
		 <font <?php echo $lang_font_size;?>>	 <?php echo $lang_contact_no;?>&nbsp;:&nbsp;<?php echo ($billInfo[0][7] == 0) ?'':$billInfo[0][7];?></font>
		</td>
		
		<td id="noborder">
			 <font <?php echo $lang_font_size;?>> <?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?></font>
		</td>
	
	</tr>
</table>
<br>
<table width="90%" class="table-bordered" id="datatable" align="center">
<tr>
<td><b><font <?php echo $lang_font_size;?>>SL</font></b></td>
<td><b><font <?php echo $lang_font_size;?>>TOWARDS BILL</b></font></td>
<td><b><font <?php echo $lang_font_size;?>>AMOUNT</font></b></td>
</tr>

					<tr>
						<td><font <?php echo $lang_font_size;?>>1.</font></td>
						<td><font <?php echo $lang_font_size;?>><?php echo $billInfo[0][0];?></font></td>
						<td><font <?php echo $lang_font_size;?>><?php if (!empty($creditInfo[0][8])) {
							echo "CASH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ".$creditInfo[0][8]."<br>";
						}
						if (!empty($creditInfo[0][9])) {
							echo "CREDIT CARD : ".$creditInfo[0][9];
						} ?></font></td>
						
						</tr>

 <tr>
 <td colspan="2" align="right"></td>
  <td><font <?php echo $lang_font_size;?>>TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </font><font <?php echo $lang_font_size;?>><?php echo $creditInfo[0][3];?></font></td>
 </tr>
 
</table>

<div align="center" class="DONTPrint"><input  type="button" name="but" value="Print"  class="btn btn-warning"  onClick="Print()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"></div></div>

</div>
</div>

<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="billno" value="<?php echo(!empty($post['billno']))?$post['billno']:''; ?>">
<input type="hidden" name="type" value="<?php echo(!empty($post['type']))?$post['type']:''; ?>">
<input type="hidden" name="user_type" value="<?php echo(!empty($post['user_type']))?$post['user_type']:''; ?>">
<input type="hidden" name="ref_no" value="<?php echo(!empty($post['ref_no']))?$post['ref_no']:''; ?>">
<input type="hidden" name="id" value="<?php echo(!empty($post['id']))?$post['id']:''; ?>">
<input type="hidden" name="billid" value="<?php echo(!empty($post['billid']))?$post['billid']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">

</form>

</body>
</html>
