<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" type="text/css" href="../../css/theme.css" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<script>
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
  
   document.writeln('<link rel="stylesheet" type="text/css" href="../../css/' + StyleFile + '">');
 </script>
 <script type="text/javascript" src="../../js/common_functions.js">  </script>

</head>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 


<?php


	$billInfo =$this->popArr['billInfo'];
$billitemInfo =$this->popArr['billitemInfo'];

?>
<div id="wrapper">
   <div id="content" align="center">
   <div align="center"><h2>KOYAS HOSPITAL</h2s></div>
   <div align="center"><h2>CHERUVANNUR ,CALICUT</h2s></div>
   <table width ="30%">
	<tr>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"><b><?php echo $lang_invoice_no.":&nbsp;".$billInfo[0][0];?></b></font>
		</td>
		<td id="noborder">
		</td>
		<td id="noborder">
		<font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="-1"><b><?php echo $lang_date.":&nbsp;".$billInfo[0][16];?></b></font>
		</td>
		
	</tr>
	<tr>
		<td id="noborder">
		 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1">	<?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo $billInfo[0][19]; ?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
		</td>
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."/ ". $billInfo[0][5];?></font>
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
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][6];?></font>
		</td>
	
		<td id="noborder">
		 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1">	 <?php echo $lang_contact_no;?>&nbsp;:&nbsp;<?php echo ($billInfo[0][7] == 0) ?'':$billInfo[0][7];?></font>
		</td>
		
		<td id="noborder">
			 <font style="font-family:Verdana, Arial, Helvetica, sans-serif" size="+1"> <?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][8];?></font>
		</td>
	
	</tr>
</table>

<table width="30%" cols="rows">
<tr>
<td><b>SL</b></td>
<td><b>PARTICULARS</b></td>
<td><b>AMOUNT</b></td>
<td><b>DISC</b></td>
<td><b>NET AMOUNT</b></td>
</tr>
<?php
$total=0;
if(!empty($billitemInfo)){
			$j=1;
				for($i=0;$i<count($billitemInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billitemInfo[$i][5];?></td>
						<td><?php echo $billitemInfo[$i][7]?></td>
						<td><?php echo $billitemInfo[$i][10]?></td>
						<td><?php echo $billitemInfo[$i][11];?></td>
						</tr>
<?php


 } 
 }?>
 <tr>
 <td colspan="4" align="right">TOTAL</td>
  <td><?php echo $billInfo[0][9];?></td>
 </tr>
 <tr>
 <td colspan="4" align="right">AMOUNT PAID</td>
  <td><?php echo $billInfo[0][13];?></td>
 </tr>
 <tr>
 <td colspan="4" align="right">BALANCE</td>
  <td><?php echo $billInfo[0][21];?></td>
 </tr>
</table>

<div align="center" class="DONTPrint"><input  type="button" name="but" value="Print"   onClick="Print()"></div>

</div>
</div>
</form>

</body>
</html>
