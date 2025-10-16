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
   <script type="text/javascript">
$(document).ready(function () {
    //Disable cut copy paste
    // $('body').bind('cut copy paste', function (e) {
    //     e.preventDefault();
    // });
   
    // //Disable mouse right click
    // $("body").on("contextmenu",function(e){
    //     return false;
    // });
});

	function submitform() {
	       document.opsheet.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing";
	       document.opsheet.submit();
	}

</script>
<style type="text/css">
    	
    @media print{
    	html,body{
    		height: 100%;
    	}
    }

    <?php

    	if ($_SESSION['user_type']=="LAB ADMIN" || $_SESSION['user_type']=="LAB USER" ) {?>
    		*{
    			font-size: 8px !important;
    		}
			img.img_print {
			    height: 50px !important;
			    width: 50px !important;
			    margin-bottom: 0px !important;
			}
			.duplicate{
				padding-top: 0px !important;
			}
			.duplicate_table{
				margin-top: -25px !important;
			}
			.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
			    border: none !important;
			}

   		<?php
    	}

     ?>

    <?php

    	if ($_SESSION['user_type']=="RECEPTION") {?>
    		*{
    			font-size: 10px !important;
    		}
			img.img_print {
			    height: 50px !important;
			    width: 50px !important;
			    margin-bottom: 0px !important;
			}
			.duplicate{
				padding-top: 0px !important;
			}
			.duplicate_table{
				margin-top: -25px !important;
			}
			.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
			    border: none !important;
			}

   		<?php
    	}

     ?>




</style>
</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$address=$hinfo[2];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];
$billInfo =$this->popArr['billInfo'];
$post =$this->popArr['post'];

?>

<div id="wrapper">
   <div id="content" >
   
	 
	 <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"><img class="img_print" src="../../dist/img/logo.png" height="80" width="100" style="margin-bottom: 6px;"></img></td>
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
	 
<!-- 	 	<tr>
			<td id="noborder" align="center"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr> -->
<!-- 		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr> -->
		</table>
		<hr width="100%">
		<table width ="90%" class="duplicate_table"  align="center" style="width: 75%;margin: 0 auto;margin-left: 18%;">
	
				
					<tr >
						<td width="70%">
			 			<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" >
		 						<font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo strtoupper($billInfo[0][23])."/";echo $billInfo[0][1]; ?></font>
						</td>
					
						
		
					</tr>
					<tr>
						
						<td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][19];?></font>
						</td>

						<td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][20];?></font>
						</td>
						
		
				</tr>
				<tr>

						<td id="noborder" >
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_date.":&nbsp;".date("d-m-Y",strtotime($billInfo[0][3]));?></font>
						</td>

						<td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][22];?></font>
						</td>


				</tr>
		


				
				
			</table>
			<br>
		
					
   					<table align="center" width="90%" class="table-bordered" id="datatable" style="width: 75%;margin: 0 auto;margin-left: 18%;">
						<tr>
							<td><font size="<?php echo $lang_font_size;?>">SL</font></td>
							<td><font size="<?php echo $lang_font_size;?>">PARTICULARS</font></td>
							<td><font size="<?php echo $lang_font_size;?>">AMOUNT</font></td>						
							<td><font size="<?php echo $lang_font_size;?>">NET</font></td>
						</tr>
						<?php
							$total=0;
							$j=1;
							if(!empty($billInfo)){
							
						
								
								  ?>
									<tr>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $j++;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo "OBSERVATION BALANCE";?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][8]?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][8];?></font></td>
									</tr>
					<?php
                             

 								 
 							}?>
							
 						<!-- <tr>
 							<td colspan="4" align="right"><font size="<?php echo $lang_font_size;?>">TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][4]+$billInfo[0][8];?></font></td>
 						</tr> -->


					<!-- <div align="center"><?php echo $billInfo[0][12];?></div> -->
					<table align="right" width="25%"><tr><td width="25%"><font size="<?php echo $lang_font_size;?>">User : </td><td align="left"><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][24];?></font></td></tr>
					<tr><td><font size="<?php echo $lang_font_size;?>">Signature:</font></td><td></td></tr>
					</table>
					<br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()">&nbsp;</div>
 

  

</div>
</div>

<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="billno" value="<?php echo(!empty($post['billno']))?$post['billno']:''; ?>">
<input type="hidden" name="type" value="<?php echo(!empty($post['type']))?$post['type']:''; ?>">
<input type="hidden" name="user" value="<?php echo(!empty($post['user']))?$post['user']:''; ?>">
<input type="hidden" name="status" value="<?php echo(!empty($post['status']))?$post['status']:''; ?>">
<input type="hidden" name="id" value="<?php echo(!empty($post['id']))?$post['id']:''; ?>">
<input type="hidden" name="cancellation_details" value="<?php echo(!empty($post['cancellation_details']))?$post['cancellation_details']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">

</form>

</body>
</html>
