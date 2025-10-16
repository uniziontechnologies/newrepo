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
</script>
  <style>
	
	#bill tr.spl td 
     {

      border-top:solid 1px;
    }
    #bill tr.rowstyle td 	
          {
          	 padding-bottom: 5px;
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

$billInfo =$this->popArr['billInfo'];
$resultInfo =$this->popArr['resultInfo'];
$patientInfo =$this->popArr['patient_info'];
 // var_dump($resultInfo);
?>

<div id="wrapper">
   <div id="content" >
   
	 
	<!--  <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.JPG" width="80px"></img></td>
		</tr> 
	 
	 	<tr>
			<td id="noborder" align="center"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "CHERUVANNUR,FEROKE,KERALA-673631";?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: 0495 2483804,05,06";?></font></td>
		</tr>
		</table> -->
		<br>
	<section class="content">
		<center><h5><b><u><?php echo $lang_lab_report_heading; ?></u></b></h5></center>
	
		<table width="100%">
	
					<tr>
						
						<td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][1]." ".$patientInfo[0][2]." " .$patientInfo[0][3];?></font>
						</td>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]."/". $patientInfo[0][6];?></font>
						</td>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][52]."/". $patientInfo[0][0];?></font>
						</td>
		
				</tr>
				<tr>
				        <td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no; ?>&nbsp;:&nbsp;<?php echo "IP ".$patientInfo[0][13];?></font>
						</td>
						<td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_room_no; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][37]."/". $patientInfo[0][38];?></font>
						</td>
						<td id="noborder" >
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor.":&nbsp;"."Dr ".$patientInfo[0][17]." ". $patientInfo[0][18];?></font>
						</td>
				</tr>
				<tr>
				        <td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_addmitted_date; ?>&nbsp;:&nbsp;<?php echo date("d-m-Y", strtotime($patientInfo[0][20]));?></font>
						</td>
						<td id="noborder">
			 			 <font size="<?php echo $lang_font_size;?>"><?php echo $lang_discharged_date; ?>&nbsp;:&nbsp;<?php if($patientInfo[0][22]=='0000-00-00'||'') 
						              {
                                         /*...No display...*/
						              } 
						          else{
                                         echo date("d-m-Y", strtotime($patientInfo[0][22]));
						              } 
						    ?>  
			 			 </font>
						</td>
						<td id="noborder" >
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_print_date.":&nbsp;".date('d-m-Y');?></font>
						</td>
				</tr>
				
				
			</table>
			<br>
	            <table width="100%" id="bill">
	                <thead>
					 <tr bgcolor='' height='10' class='spl'><td colspan='7'>&nbsp;</td></tr>
						<tr>
							<th width='10%'><font size="<?php echo $lang_font_size;?>">SL NO</font></th>
							<th width='10%'><font size="<?php echo $lang_font_size;?>">BILL NO</font></th>
							<th width='15%'><font size="<?php echo $lang_font_size;?>">BILL DATE</font></th>				
							<th width='40%'><font size="<?php echo $lang_font_size;?>">TEST NAME</font></th>
							<th width='15%'><font size="<?php echo $lang_font_size;?>">RESULT</font></th>
							<th width='10%'><font size="<?php echo $lang_font_size;?>">NORMAL RANGE</font></th>
						</tr>
					 <tr bgcolor='' height='10' class='spl'><td colspan='7'>&nbsp;</td></tr>
				    </thead>
				    <tbody>
						<?php
							if(!empty($billInfo)){
								$j=1;
								 for($i=0;$i<count($billInfo);$i++) {
	                                   
				                  
								  ?>
									<tr class="rowstyle">
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $j++;?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[$i][0];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $billInfo[$i][16];?></font></td>
								<?php
                                           $labResult=  $resultInfo[$i];    
								 if(!empty($labResult)){
					                  for($r=0;$r<count($labResult);$r++) {
                                                     
					                  	if($r >0) { ?>

					                  	  <tr class="rowstyle">
					                  	      <td></td>
					                  	      <td></td>
                                              <td></td>
                                              


					           <?php       
					                         	}
     		?>
			                
										<td>
				
							                <?php echo ($labResult[$r][7] ==1 || $labResult[$r][7] ==2 || $labResult[$r][7] ==10 || $labResult[$r][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								           <?php echo ($labResult[$r][7] ==10 || $labResult[$r][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							               <?php echo ($labResult[$r][7] ==1 || $labResult[$r][7] ==2 || $labResult[$r][7] ==3)?'<b><u>':'';?>
							  
							               <font size="<?php echo $lang_font_size;?>"><?php echo $labResult[$r][3];?></font>
							               <?php echo ($labResult[$r][7] ==1 || $labResult[$r][7] ==2 || $labResult[$r][7] ==3)?'</u></b>':'';?>
					
										</td>
										<?php
							              if($labResult[$r][7] ==1 || $labResult[$r][7] ==2 || $labResult[$r][7] ==3){?>
								
								            <td></td>
									        <td></td>
								
								        <?php }else{ ?>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $labResult[$r][4];?></font></td>
										<td><font size="<?php echo $lang_font_size;?>"><?php echo $labResult[$r][5];?></font></td>
										<?php 
									               } 
                                                         
										?>
									</tr>
					<?php                  
					                            }
                                                     }
					                                          }

 								} 
 							?>
					</tbody>		
 				</table>
					<br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()"></div>
 

  
    </section>
</div>
</div>
</form>

</body>
</html>
