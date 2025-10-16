
<body>
<script>

 $(document).ready(function() {
 
  // $(".date_cal").datepicker({ picker: "<img class='picker' align='middle' src='../../img/cal.gif' alt=''/>" });
			
  });
function searchForm(){

document.op_search.paction.value="Search";

$.post("../../lib/controllers/centralController.php?module=Registration&sub_module=search_op_patient", $("#op_search").serialize(),function(data){
		
		$("#oplist").html(data);
		
		});
}

function redirect(opno){
	
	
		$('#opno').val(opno);
		
		$('#form').attr('action',"../../lib/controllers/centralController.php?module=Registration&sub_module=patient_registeration&paction=PROCESS_OP_NO");
		$('#form').submit();
		
	}
</script>
<form name="op_search" id="op_search"  method="post" action=""> 

<?php

$doctors=$this->popArr['doctors'];
$patientInfo=$this  ->popArr['patient_info'];
?>
 <section class="content-header">
          <h4><?php echo $lang_search." ".$lang_op_patients; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">				
							
			
					
							<tr>
							
							    <td id="noborder"><?php echo $lang_from_date; ?>:</td>
							    <td id="noborder" >	
									<input type="text" name="from_date" id="from_date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
								</td>
						
											
										
								<td id="noborder"><?php echo $lang_to_date; ?>:</td>
								<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="date_cal" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
										
								<td id="noborder"> FIRST NAME:</td>
								<td id="noborder"><input type="text" name="name"   value="" onkeypress="nextField(event
.keyCode,place)" /></td>

																
								
							</tr>
							<tr>
							<td id="noborder"> PLACE:</td>
								<td id="noborder"><input type="text" name="place" value="" onkeypress="nextField(event
.keyCode,lname)" /></td>
								<td id="noborder">PHONE:</td>
								<td id="noborder"><input type="text" name="telNo" value=""  onkeypress="nextField(event
.keyCode,lname)" /></td>	
								
							
								
								<td id="noborder">DOCTOR </td>
								<td id="noborder">
								
							     <select name="doctor" id="doctor" onchange="searchForm()">
								  <option value=''>---------------</option>
								  <?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
								 </select>
											
									
							</td>	
							
							</tr>	
							<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button"  class="btn btn-success" name="Search" id="search" value="Search" onclick="searchForm();"/>
									
									
									
									</td>
								</tr>	
				
				</table>
				</div>
			</div>
				
	
			
       			<div id="rightnow">
                	<h3 class="reallynow">
						OP PATIENTS LIST						
						
                       
					
					</h3>
										<br />
			<div align="center">
			
					
			<table width="95%">
				<thead>
					<tr>
                          <th ><a href="#">SL NO</a></th>
						 <th ><a href="#">OP NO</a></th>
						 <th><a href="#">PATIENT NAME</a></th>
						 <th width="3%"><a href="#">AGE</a></th>	
						 <th width="3%"><a href="#">GENDER</a></th>   					  
                           <th><a href="#">PLACE</a></th>
						    <th width="5%"><a href="#">DATE</a></th>
							<th width="6%"><a href="#">TIME</a></th>
							<th><a href="#">INSURANCE COMPANY</a></th>							
						    <th><a href="#">DOCTOR</a></th>							 
							  <th width="5%"><a href="#">VISIT STATUS</a></th>                           
							                                
                                
                          </tr>
				</thead>
				<tbody id="oplist">
				
						
							<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][0];?></td>
						<td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][0];?>')"><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][5];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][10];?></td>
						<td><?php echo $patientInfo[$i][9];?></td>
						<td><?php echo $patientInfo[$i][12];?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][7]." ".$patientInfo[$i][8];?></td>
						
						<td>
							<?php if($patientInfo[$i][14] == 1) echo "FREE";
									else echo $patientInfo[$i][13];?></td>
						
						
										
						
					
					</tr>
						
				
		<?php	}
			
			}		
		?>		
								
										
						</tbody>
						
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="paction" id="paction" />
	   <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
	
</form>	  

</body>