
	<style>
	
	#bill tr.spl td 
{

border-top:solid 1px;
}
	</style>



<?php
	
	$resultInfo=$this  ->popArr['resultInfo'];
	$resultEntryInfo=$this  ->popArr['resultEntryInfo'];
	$billInfo=$this  ->popArr['billInfo'];
	
	
?>
 
				<h5 align="center"><b><u><?php echo $lang_lab_report_heading;?></u></b></h5>
				
				
			   
			   <table width="100%" >
			   
			     <tr>
				    <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][3];?></font></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_bill_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][0];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][8];?></font></td>
				 </tr>
				  <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_recieved_date;?>&nbsp;&nbsp;&nbsp;:<?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_result_date;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo date("d-m-Y",strtotime($resultInfo[0][2]));?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_print_date;?>&nbsp;:<?php echo date("d-m-Y");?></font></td>
				  </tr>
				  
			   </table>
			   <br>
			    <table width="100%" id="bill">
					<thead>
					<tr bgcolor='' height='25' class='spl'><td colspan='5'>&nbsp;</td></tr>
					    <tr>
							<th width='50%'><font size="<?php echo $lang_font_size;?>"><?php echo $lang_test_name; ?></font></th>
							<th width='30%'><font size="<?php echo $lang_font_size;?>"><?php echo $lang_value; ?></font></th>
							<th><font size="<?php echo $lang_font_size;?>"><?php echo $lang_normal_range; ?></font></th>
							
						</tr>
						<tr bgcolor='' height='25' class='spl'><td colspan='5'>&nbsp;</td></tr>
				    </thead>
					<tbody>
					<?php
					    if(!empty($resultEntryInfo)){
						
						  for($i=0;$i<count($resultEntryInfo);$i++){ 
						  
						  if($resultEntryInfo[$i][7] ==0 || $resultEntryInfo[$i][7] ==3){
								  
								    if(!isset($k)) $k=0;
									else $k++;
						  }
						  ?>

                           <tr  class='resRow<?php echo $k;?>' >
						   
							   <td >
							    <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($resultEntryInfo[$i][7] ==10 || $resultEntryInfo[$i][7] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'<b><u>':'';?>
							  
							   <font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][3];?></font>
							   <?php echo ($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3)?'</u></b>':'';?>
							   </td>
							 <?php
							    if($resultEntryInfo[$i][7] ==1 || $resultEntryInfo[$i][7] ==2 || $resultEntryInfo[$i][7] ==3){?>
								
								    <td></td>
									<td></td>
								
								<?php }else{ ?>
							        <td><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][4];?></font></td>
							        <td><font size="<?php echo $lang_font_size;?>"><?php echo $resultEntryInfo[$i][5];?></font></td>
								<?php } ?>
							</tr>
							
						  <?php
                          }						  
						}
					
					?>
					
					
					
				 </tbody>
				</table>
		
         
	
