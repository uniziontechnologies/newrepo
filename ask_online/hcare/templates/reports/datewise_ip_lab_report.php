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
        //e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
       // return false;
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
		  
		  #result_table
     {

      font-size:9px;
    }
    @media print{

  html, body {

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

$patientInfo =$this->popArr['patient_info'];
$category =$this->popArr['category'];
$elements =$this->popArr['elements'];
$result_value =$this->popArr['result_value'];
$result_date =$this->popArr['result_date'];
/*$startdate =$this->popArr['startdate'];
$enddate =$this->popArr['enddate'];
$tot_days =$this->popArr['tot_days'];*/

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
	
		<table width="100%" >
	
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
			 <div class="box box-info">
                
               <div class="box-body">
	            <table  class="table table-bordered table-striped" id="result_table">
	                <thead>
					  <tr>
					    <th></th>
						<th ><?php echo $lang_date; ?></th>
						
						<?php
						if(!empty($result_date)){ 
						for($k = 0; $k < count($result_date); $k++){
							
							$display_date= $result_date[$k];
                                                                      
							?>
							
							<th><?php echo $display_date;?></th>
						<?php }}
						?>
						</tr>
				    </thead>
				    <tbody>
				<?php
				
				       if(!empty($elements)){ 
					   
					   
						   for($i=0; $i<count($elements); $i++){ ?>
						   
						      <tr>
							  
						       <td style="font-size:9px;"><?php echo $elements[$i][0];?></td>
							   <td style="font-size:9px;"><?php echo $elements[$i][1];?></td>
							  
							   
							   <?php
						        if(!empty($result_date)){ 
						             for($k = 0; $k < count($result_date); $k++){
								// 		 $j=2;
										 ?>
									 
									  <td style="font-size:9px;"><?php echo ($result_date[$k]==$elements[$i][3][$k])?$elements[$i][2][$k]:'';?></td>
						   <?php }
						   
								 }
						   }
					   }
						/*if(!empty($category)){ 
  						   for($i=0; $i<count($category); $i++){ ?>
						   
						     <tr>
							    <td rowspan="<?php echo count($elements[$i])+1;?>" style="font-size:9px;"><?php echo ($category[$i]!='')?$category[$i]:'OTHERS';?></td>
								
						<?php  
						   for($j=0; $j<count($elements[$i]); $j++){ ?>
						       <tr>
							  
						       <td style="font-size:9px;"><?php echo $elements[$i][$j];?></td>
							   
						<?php
						    for($k = 0; $k < count($result_date); $k++){
								
								 for($l = 0; $l < count($result_value[$i][$j][$k]); $l++){?>
							
							<td><?php echo $result_value[$i][$j][$k][$l];?></td>
							
							<?php }
							}							?>
							   
							   </tr>
						
						<?php  } ?>
						   
						   
						   </tr>
						   <?php      }
						}*/
					?>
					</tbody>		
 				</table>
			</div>
			</div>
					<br>
			
				<div align="center" class="DONTPrint"><input  type="button" name="but" class="btn btn-warning" value="Print"   onClick="Print()"></div>
 

  
    </section>
</div>
</div>
</form>

</body>
</html>
