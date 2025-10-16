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

</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php

require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];

$billInfo =$this->popArr['billInfo'];
$billitemInfo =$this->popArr['billitemInfo'];

?>

<div id="wrapper">
   <div id="content" align="center">
   
	 
	 <table width ="100%" align="center">
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.JPG" width="120px"></img></td>
		</tr> 
	 
	 	<tr>
			<td id="noborder" align="center"><h2> <?php echo strtoupper($clinic_name);?></h2>
		<h4> <?php echo "CHERUVANNUR,FEROKE,KERALA-673631";?></h4>
		<h4> <?php echo "TEL: 0495 2483804,05,06";?></h4></td>
		</tr>
	
		<tr align="center">
		
		<td id="noborder" align="center">
		
				<table width ="100%" >
					<tr >
						<td id="noborder">
			 				<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" >
		 					<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1">	<?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP")?$billInfo[0][19]:$billInfo[0][2]; ?></font>
						</td>
					
						
		
					</tr>
					<tr>
						
						<td id="noborder" >
			 				<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
						</td>
						<td id="noborder">
			 				<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."". $billInfo[0][5];?></font>
						</td>
						
		
				</tr>
				<tr>
						<td id="noborder">
			 				<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][6];?></font>
						</td>
						<td id="noborder" >
							<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"><?php echo $lang_date.":&nbsp;".$billInfo[0][16];?></font>
						</td>
				</tr>
				<?php if(!empty($billInfo[0][8])){ ?>
				<tr>
						<td id="noborder" colspan="2">
			 				<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?></font>
						</td>
				</tr>
				<?php } ?>
				<tr>
		
						
	
						
				</tr>
				
			</table>
		
		</td>
		
		</tr>
		<tr>
		
			<td id="noborder">
					
   					<table width="90%"  align="center">
						<tr>
							<td><font size="+1">SL</font></td>
							<td><font size="+1">PARTICULARS</font></td>
							<td><font size="+1">AMOUNT</font></td>							
							<td><font size="+1">NET</font></td>
						</tr>
						<?php
							$total=0;
							if(!empty($billitemInfo)){
								$j=1;
								for($i=0;$i<count($billitemInfo);$i++) {?>
									<tr>
										<td><font size="+1"><?php echo $j++;?></font></td>
										<td><font size="+1"><?php echo $billitemInfo[$i][5];?></font></td>
										<td><font size="+1"><?php echo $billitemInfo[$i][7]?></font></td>
										<td><font size="+1"><?php echo $billitemInfo[$i][11];?></font></td>
									</tr>
					<?php


 								} 
 							}?>
 						<tr>
 							<td colspan="3" align="right"><font size="+1">TOTAL</font></td>
  							<td><font size="+1"><?php echo $billInfo[0][9];?></font></td>
 						</tr>
					<?php if($billInfo[0][23] >0) { ?>
						<tr>
 							<td colspan="3" align="right"><font size="+1"><?php echo $lang_discount; ?></font></td>
  							<td><font size="+1"><?php echo $billInfo[0][23];?></font></td>
 						</tr>
					
						<tr>
 							<td colspan="3" align="right"><font size="+1">NET TOTAL</font></td>
  							<td><font size="+1"><?php echo $billInfo[0][11];?></font></td>
 						</tr>
					<?php } ?>
 						<tr>
 							<td colspan="3" align="right"><font size="+1">AMOUNT PAID</font></td>
  							<td><font size="+1"><?php echo $billInfo[0][13];?></font><br /></td>
 						</tr>
 						<tr>
 							<td colspan="3" align="right"><font size="+1">BALANCE</font></td>
  							<td><font size="+1"><?php echo $billInfo[0][21];?></font></td>
 						</tr>

					</table>
			</td>
		
		</tr>
		<tr>
			<td id="noborder" align="center">
			<br />..........
			</td>
		</tr>
		<tr>
			<td id="noborder">
				<div align="center" class="DONTPrint"><input  type="button" name="but" value="Print"   onClick="Print()" class="btn btn-warning"></div>
 

			</td>
		</tr>
	 
	 
	 </table>
   <!--<table width ="30%" align="left">
	<tr>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2"><b><?php echo $lang_invoice_no.":&nbsp;".$billInfo[0][0];?></b></font>
		</td>
		<td id="noborder">
		</td>
		<td id="noborder">
		<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2"><b><?php echo $lang_date.":&nbsp;".$billInfo[0][16];?></b></font>
		</td>
		
	</tr>
	<tr>
		<td id="noborder">
		 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2">	<?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][19]; ?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2"> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2"> <?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."/ ". $billInfo[0][5];?></font>
		</td>-->
		<!--<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_date; ?>&nbsp;:&nbsp;<?php echo date("d-m-Y",strtotime($patientInfo[0][20]))." ".$patientInfo[0][19];?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"><?php echo $lang_time; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][19];?></font>
		</td>-->
	<!--</tr>
	<tr>
		
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2"> <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][6];?></font>
		</td>
	
		<td id="noborder">
		 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+2">	 <?php echo $lang_contact_no;?>&nbsp;:&nbsp;<?php echo ($billInfo[0][7] == 0) ?'':$billInfo[0][7];?></font>
		</td>
		
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?></font>
		</td>
	
	</tr>
</table>

  
  <br />
   <table width="30%" cols="rows" align="left">
<tr>
<td><b><font size="+2">SL</font></b></td>
<td><b><font size="+2">PARTICULARS</font></b></td>
<td><b><font size="+2">AMOUNT</font></b></td>
<td><b><font size="+2">DISC</font></b></td>
<td><b><font size="+2">NET AMOUNT</font></b></td>
</tr>
<?php
$total=0;
if(!empty($billitemInfo)){
			$j=1;
				for($i=0;$i<count($billitemInfo);$i++) {?>
					<tr>
						<td><font size="+2"><?php echo $j++;?></font></td>
						<td><font size="+2"><?php echo $billitemInfo[$i][5];?></font></td>
						<td><font size="+2"><?php echo $billitemInfo[$i][7]?></font></td>
						<td><font size="+2"><?php echo $billitemInfo[$i][10]?></font></td>
						<td><font size="+2"><?php echo $billitemInfo[$i][11];?></font></td>
		</tr>
<?php


 } 
 }?>
 <tr>
 <td colspan="4" align="right"><font size="+2">TOTAL</font></td>
  <td><font size="+2"><?php echo $billInfo[0][9];?></font></td>
 </tr>
 <tr>
 <td colspan="4" align="right"><font size="+2">AMOUNT PAID</font></td>
  <td><font size="+2"><?php echo $billInfo[0][13];?></font><br />
</td>
 </tr>
 <tr>
 <td colspan="4" align="right"><font size="+2">BALANCE</font></td>
  <td><font size="+2"><?php echo $billInfo[0][21];?></font></td>
 </tr>
</table>-->



</div>
</div>
</form>

</body>
</html>
