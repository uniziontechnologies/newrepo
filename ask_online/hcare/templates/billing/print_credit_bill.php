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
		@page{
			    size: auto;margin:0mm 80mm 0mm 0mm;
			  }
		html,body{
			height: 100% !important;
		}
		 *{
		 	/*font-size: 12px !important;*/
		 	/*font-family: "Courier New", Courier, monospace;*/
		 	font-family: Arial;
			font-style: normal;
			font-variant: normal;
			font-weight: 400;
			line-height: normal;
		    	/*font-size: 12px;*/
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
$billitemInfo =$this->popArr['billItemInfo'];
$creditInfo =$this->popArr['creditInfo'];
$patient_category =$this->popArr['patient_category'];
$post =$this->popArr['post'];

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
	
				
					<tr >
						<td width="70%">
			 			<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" >
		 						<font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP")?$billInfo[0][19]:$billInfo[0][2]; ?></font>
						</td>
					
						
		
					</tr>
					<tr>
						
						<td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
						</td>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_age."/".$lang_gender; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."/". $billInfo[0][5];?></font>
						</td>
						
		
				</tr>
				<tr>
						<td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][6];?></font>
						</td>
						<td id="noborder" >
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_date.":&nbsp;".$billInfo[0][16];?></font>
						</td>
				</tr>
				<?php if(!empty($billInfo[0][8])){ ?> 
				<tr>
						<td id="noborder" <?php echo (!empty($patient_category))?'':'colspan="2"'?> >
			 				 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?>
			 				 	<br>
			 				 	<?php echo $billInfo[0][49];?>

			 				 </font>
						</td>
				<?php if(!empty($patient_category)){ ?>	 
				        <td id="noborder">
				        	<font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient_category.":&nbsp;".$patient_category;?></font>  
				        </td>
				<?php }?> 	
				</tr>
				<?php } ?>
				
				
			</table>
			<br>
		
					
   					<table align="center" width="90%" class="table-bordered" id="datatable">
						<tr>
							<td><font size="<?php echo $lang_font_size;?>">SL</font></td>
							<td><font size="<?php echo $lang_font_size;?>">PARTICULARS</font></td>
							<td><font size="<?php echo $lang_font_size;?>">AMOUNT</font></td>						
							<td><font size="<?php echo $lang_font_size;?>">QTY</font></td>
							<td><font size="<?php echo $lang_font_size;?>">NET</font></td>
						</tr>
						<?php
							$total=0;
							if(!empty($billitemInfo)){
								$j=1;
								for($i=0;$i<count($billitemInfo);$i++) {
								  if($billitemInfo[$i][31] == 0) {
								  ?>
									<tr>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $j++;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billitemInfo[$i][5];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billitemInfo[$i][7]?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php if (!empty($billitemInfo[$i][35])) {
											echo $billitemInfo[$i][35];
										}else{echo "1";} ?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billitemInfo[$i][11];?></font></td>
									</tr>
					<?php
                                                                  }

 								} 
 							}?>
							
 						<tr>
 							<td colspan="3" align="right"><font size="<?php echo $lang_font_size;?>">TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][9];?></font></td>
 						</tr>
					<?php if($billInfo[0][23] >0) { ?>
						<tr>
 							<td colspan="3" align="right"><font size="<?php echo $lang_font_size;?>"><?php echo $lang_discount; ?></font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][23];?></font></td>
 						</tr>
					
						<tr>
 							<td colspan="3" align="right"><font size="<?php echo $lang_font_size;?>">NET TOTAL</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][11];?></font></td>
 						</tr>
					<?php } ?>
 						<tr>
 							<td colspan="3" align="right"><font size="<?php echo $lang_font_size;?>">AMOUNT PAID</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][13];?></font><br /></td>
 						</tr>
					<?php if($billInfo[0][21] !=0){?>
 						<tr>
 							<td colspan="3" align="right"><font size="<?php echo $lang_font_size;?>">BALANCE</font></td>
  							<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][14];?></font></td>
 						</tr>
					<?php } ?>

					</table>
					<?php if($billInfo[0][17] !=''){?>
					<div style="margin-left:35px"><font size="<?php echo $lang_font_size;?>"><?php echo $lang_remarks;?> : <?php echo $billInfo[0][17];?></font></div>
					<?php } ?>
					<div align="center"><?php echo $billInfo[0][12];?></div>
					<table align="right" width="25%"><tr><td width="25%"><font size="<?php echo $lang_font_size;?>">User : </td><td align="left"><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[0][28];?></font></td></tr>
					<tr><td><font size="<?php echo $lang_font_size;?>">Signature:</font></td><td></td></tr>
					</table>
					<br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"></div>
 

  

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
<input type="hidden" name="ref_no" value="<?php echo(!empty($post['ref_no']))?$post['ref_no']:''; ?>">

</form>

</body>
</html>
