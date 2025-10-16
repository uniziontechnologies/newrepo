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
	
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  
 <!-- date-range-picker -->

 <script language="javascript">
   $(document).ready(function () {

   	// $(".bottom_note").hide();
    //Disable cut copy paste
  /*  $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });*/
	
	$('.view_res').attr('checked', true);
		   
	       $( ".view_res" ).click(function() {
		   
		    row_id=$(this).attr('id');
		     if($(this).is(':checked') == true) {
				
					 $('.view_res_elem.res'+row_id).prop('checked', true);
                     $("tr.resRow"+row_id+" td").removeClass();
				
             } else {
				  $('.view_res_elem.res'+row_id).attr('checked', false );
                  $("tr.resRow"+row_id+" td").addClass('DONTPrint');
            }
		 });
		 
		 $('.view_res_elem').attr('checked', true);
		   
	       $( ".view_res_elem" ).click(function() {
		   
		  
		   row_id=$(this).attr('id');
			
			id_arr = row_id.split("elem");
			 row_id=id_arr[1];
			
			
		     if($(this).is(':checked') == true) {
				 
                // $( ".resRow"+row_id ).removeClass();
				 $("tr#res_elem"+row_id+" td").removeClass();
             } else {
				
                  $("tr#res_elem"+row_id+" td").addClass('DONTPrint');
            }
		 });
	
	
});
	function submitform() {
	       document.result_entry.action="../../lib/controllers/centralController.php?module=Lab&sub_module=search_lab_bill";
	       document.result_entry.submit();
	}
	function myfunction(id){

		// $("tr.resRow"+id).css("page-break-before","always");
		// $("tr.resRow"+id).addClass("page-break");
		// $("tr.resRow"+id).append("<div class='page_side' ></div><div class='page_side' style='page-break-before:always !important;'></div>");
		// $("tr.resRow"+id).find("th").append("<div></div><div style='page-break-before:always !important;'></div>");
		// $("tr.resRow"+id).find("td").append("<div></div><div style='page-break-before:always !important;'></div>");
		if ($("#page_break"+id).is(':checked')) {
			

			$("tr.resRow"+id).append("<div class='page_side' ></div><div class='page_side' style='page-break-before:always !important;'></div>");


		}
		else{
			
			$('.page_side').remove();

		}

	}

    </script>
	<script>
  $(function () {
	       
 });
</script>
	<style>
@page{margin-top: 3.5cm;}
#bill tr.spl td 
{
border-top:solid 1px;
}
#bill tr.rowstyle td 	
{
    padding-bottom: 10px;
}
table#main_heading_table td{
    font-size: 12px !important;
}
td.margin_bottom {
    padding-bottom: 5px !important;
}
td.first_row {
    width: 35% !important;
}
td.second_row {
    width: 20% !important;
}
td.third_row {
    width: 20% !important;
}
td.fourth_row {
    width: 20% !important;
}
.page-break	{  page-break-before: always !important; }
		.bottom_note{
			/*display: none;*/
		}
@media print{

	html, body{
			height: 100% !important;
		}
		.bottom_note{
			display: block;
		}
		/*.page-break	{  page-break-before: always !important; }*/
	

}
    #spacer {height: 2em;}
    #footer {
    	position: fixed;
    	bottom: 0px;
    	font-size: 16px;
    	font-weight: 700;
    	font-style: italic;
  	}
	</style>

</head>
<body id="frame">
<form name="result_entry" id="form"  method="post" action=""> 
<div id="content">
<?php
	
   require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();

$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];
$address=$hinfo[2];

$resultInfo=$this  ->popArr['resultInfo'];
$resultEntryInfo=$this  ->popArr['resultEntryInfo'];
$billInfo=$this  ->popArr['billInfo'];
$post=$this  ->popArr['post'];
	
?>

		<section class="content">
		
<!-- 			   <table width ="100%" id="main_heading_table">
	 	        <tr>
				<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="140"></img></td>
			  
		       </tr> 
				<tr>
					<td><h5 style="margin-top: -20px;font-size: 12px !important;text-align: center;"><?php echo strtoupper($address)." , Ph-".strtoupper($phone); ?></h5></td>
				</tr>
		        -->
	 
<!-- 	 	<tr>
			<td id="noborder" align="center"><h1 id="main_heading" style="font-size: 20px !important;margin-bottom: 1px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></h1></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size=""><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size=""><?php echo "Tel: ".$phone;?></font></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size=""><?php echo "Email: ".$email;?></font></td>
		</tr> -->
		<!-- </table> -->
				
				<!-- <h5 align="center" style="font-size: 14px !important;margin-top: 15px;margin-bottom: 20px;"><b><u><?php echo $lang_lab_report_heading;?></u></b></h5> -->
				
				
			   
			   <table width="100%" >
			   
			     <tr>
				    <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_patient;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][3];?></font></td>
					<td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_hosp_id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_ref_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_bill_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][0];?></font></td>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_doctor;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][8];?></font></td>
				 </tr>
				  <tr>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_recieved_date;?>&nbsp;&nbsp;&nbsp;:<?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_result_date;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo ($resultInfo[0][2]!='')?date("d-m-Y",strtotime($resultInfo[0][2])):date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td class="margin_bottom"><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_print_date;?>&nbsp;:<?php echo date("d-m-Y");?></font></td>
				  </tr>
				  
			   </table>
			   <br>
			    <table width="100%" id="bill" >
					<thead>
					<tr bgcolor='' height='5' class='spl'><td colspan='5'>&nbsp;</td></tr>
					    <tr>
					    	<th  class='DONTPrint'><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_test_select; ?></font></th>
							<th  class='DONTPrint'><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_test_select; ?></font></th>
							<th ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_test_name; ?></font></th>
							<th ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_value; ?></font></th>
							<th><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_unit; ?></font></th>
							<th ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $lang_normal_range; ?></font></th>
							
						</tr>
						<tr bgcolor='' height='5' class='spl'><td colspan='5'>&nbsp;</td></tr>
				    </thead>
					<tbody>
					<?php
					    if(!empty($resultEntryInfo)){
							$m=0;
						
						  for($i=0;$i<count($resultEntryInfo);$i++){ 
						  
						  if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3){
								  
								    if(!isset($k)) $k=0;
									else $k++;
						  }
						  ?>

                           <tr  class='resRow<?php echo $k;?> rowstyle' id="res_elem<?php echo $m;?>">





							  <th class='DONTPrint' style="padding-bottom: 10px;" > 
							  
							  <?php if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3 ){
								 
								  ?>
							                                           <input type='checkbox' name='page_break' id='page_break<?php echo $k;?>' class='page_break' onclick="myfunction('<?php echo $k;?>');" ></th>
																	  
							                         <?php } ?>
													 
													 <?php if($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20 || $resultEntryInfo[$i][7] ==2){
								 
								  ?>
							                                           </th>
																	  
							                         <?php } ?>



						   
							  <th class='DONTPrint' style="padding-bottom: 10px;" > 
							  
							  <?php if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3 ){
								 
								  ?>
							                                           <input type='checkbox' name='view' id='<?php echo $k;?>' class='view_res' ></th>
																	  
							                         <?php } ?>
													 
													 <?php if($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20 || $resultEntryInfo[$i][7] ==2){
								 
								  ?>
							                                           <input type='checkbox' name='view' id='elem<?php echo $m;?>' value="1" class="view_res_elem <?php echo "res".$k;?>" ></th>
																	  
							                         <?php } ?>
							   <td class="first_row">

							   	<?php if (!empty($resultEntryInfo[$i][11]) && $resultEntryInfo[$i][7]==0 && $cat!=$resultEntryInfo[$i][11] ) {?>
							   		<font size="<?php echo $lang_font_size_lab;?>"><?php echo "<b><u>".$resultEntryInfo[$i][11]."</u></b><br><br>";?></font>

							   	<?php
							   	$show[$i]="YES";
							   	$cat = $resultEntryInfo[$i][11];
							   	}?>
							    <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'<b><u>':'';?>
							  
							   <font size="<?php echo $lang_font_size_lab;?>"><?php if ($cat!=$resultEntryInfo[$i][3]) {
							   	echo $resultEntryInfo[$i][3];
							   } ;?></font>
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'</u></b>':'';?>
							   </td>
							 <?php
							    if($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3){?>
								
								    <td></td>
									<td></td>
								
								<?php }else{ ?>
							        <td class="second_row" <?php if (!empty($show[$i]) && $show[$i]=="YES" ) {
							        	echo "style='padding-top:30px;'";
							        } ?> ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $resultEntryInfo[$i][4];?></font></td>
									<td class="third_row" <?php if (!empty($show[$i]) && $show[$i]=="YES" ) {
							        	echo "style='padding-top:30px;'";
							        } ?> ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $resultEntryInfo[$i][6];?></font></td>
							        <td class="fourth_row" <?php if (!empty($show[$i]) && $show[$i]=="YES" ) {
							        	echo "style='padding-top:30px;'";
							        } ?> ><font size="<?php echo $lang_font_size_lab;?>"><?php echo $resultEntryInfo[$i][5];?></font></td>
								<?php } ?>
							</tr>
							
						  <?php
						  
						  $m++;
                          }						  
						}
					
					?>
					
					<tfoot>


					<tr>
					<td></td>
					<td></td>
					<td></td>
					<!-- <td></td> -->
					 <!--<td><b><br><br><br>Lab Technician<b></td>-->
					 
					 </tr>

					<tr>
					<td></td>
					<td></td>
					<td></td>
					<!-- <td></td> -->
					 <td id="spacer"><b><br><br><br></td>
					 
					 </tr>

						
					</tfoot>
				 </tbody>
				</table>
		     
				<!--<div id="footer" class="col-xs-12 bottom_note">-->
  		<!--			<p style="font-size: 10px;">NOTE : Individual laboratory investigations should not be considered as conclusive and should be used along with other relevent clinical examinations to achieve the final diagnosis. Therefor these reported results are for the information of referring clinicians only  </p>-->
				<!--</div>-->

            </section>
	
	 </div>
	 <div align="center" class="DONTPrint"><a href="#" class="print btn btn-warning btn-flat" onClick="Print()">PRINT</a>&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-danger" onclick="submitform()"></div>



<input type="hidden" name="billno" value="<?php echo(!empty($post['billno']))?$post['billno']:''; ?>">
<input type="hidden" name="type" value="<?php echo(!empty($post['type']))?$post['type']:''; ?>">
<input type="hidden" name="patient_id" value="<?php echo(!empty($post['patient_id']))?$post['patient_id']:''; ?>">
<input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">
<input type="hidden" name="patient_name" value="<?php echo(!empty($post['patient_name']))?$post['patient_name']:''; ?>">
<input type="hidden" name="id" value="<?php echo(!empty($post['id']))?$post['id']:''; ?>">
<input type="hidden" name="paction" value="SEARCH">
<input type="hidden" name="cancellation_details" value="<?php echo(!empty($post['cancellation_details']))?$post['cancellation_details']:''; ?>">

</form>	  
</body>
	</html>
	
