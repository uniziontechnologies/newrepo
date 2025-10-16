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
    </script>
    <style>
	
	body{
	 text-transform :capitalize;
	}	
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
$billInfo =$this->popArr['billInfo'];
$billitems=$this->popArr['billitems'];
$patientInfo=$this->popArr['patient_info'];

?>

<div id="wrapper">
   <div id="content" >
   
	 
	 <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="80px"></img></td>
		</tr> 
	 
	 	<tr>
		</tr>

		<?php

			if (!empty($post['is_dupclicate'])) {?>

				<td id="noborder" align="center" style="font-size: 12px;padding-top: 3px;"><label>(duplicate)</label></td>	

			<?php
			}


		?>

 	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>
		</table>
		<hr width="100%">
		<table width ="90%"  align="center">
	
				<tr>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" align="right">
		 					<font size="<?php echo $lang_font_size;?>">	<?php echo $lang_ip_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][1]; ?></font>
						</td>
					
						
		
					</tr>
					<tr>
						
						<td id="noborder" colspan="2">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?></font>
						</td>
						
		
				</tr>
				<tr>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_room_no; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][9]?></font>
						</td>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"> <?php echo $lang_date; ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($billInfo[0][6]));?></font>
						</td>
				</tr>
			</table>
			<br>
		
					
   					<table align="center" width="90%" class="table-bordered" id="datatable">
						<tr>
							
							<td><font size="<?php echo $lang_font_size;?>">PARTICULARS</font></td>
							<td><font size="<?php echo $lang_font_size;?>">AMOUNT</font></td>							
							
						</tr>
						<tr>
						     <td><font size="<?php echo $lang_font_size;?>">ADVANCE AMOUNT</font></td>
						      <td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][3]+$billInfo[0][4]+$billInfo[0][20];?></font></td>
						     
						 </tr>
						
 						<tr>
 							<td colspan="1" align="right"><font size="<?php echo $lang_font_size;?>">TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][3]+$billInfo[0][4]+$billInfo[0][20];?></font></td>
 						</tr></table>
					<br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()"></div>
 

  

</div>
</div>
</form>

</body>
</html>
