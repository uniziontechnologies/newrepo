<?php

$batchInfo=$this->session->userdata('batchidInfo');

?>
<form name="ip_prescription" id="ip_prescription"  method="post" action="">
 <div id="wrapper">
            <div id="content">
            <div class="row">
                  <h3>MEDICINES LIST</h3>
               <div class="box box-info">
          
                      <div class="box-body">
 
            <table width="100%" class="table table-striped">

                    <?php

			            if (!empty($prescription_info)) {
				
				          for ($i=0; $i <count($prescription_info) ; $i++) { 
					
					        $doctor_name = "Dr"." . ".$prescription_info[$i][11]."".$prescription_info[$i][12]; 
				          }


			            }
                    ?>
            
               <tr>

                 <td>
                     IP NO : <?php echo $ip_no; ?>
                 </td>
                 <td>
                      
                 </td>
                 <td>
                    Doctor Name : <?php 
                                    if (!empty($doctor_name)) {

		 		                      echo $doctor_name;
		 	                        } 
		 	          ?> 
                 </td>
                 <td>
                 	Date : 
                 </td>
                 <td>	
                 	<select id="prescription_date" name="prescription_date">
										  
										  	<?php
											  if (!empty($doctor_presc_date)) {
												for ($i=0; $i < count($doctor_presc_date); $i++) { ?>
												  <option value="<?php echo $doctor_presc_date[$i]; ?>" <?php if (!empty($prescription_date) && $prescription_date == $doctor_presc_date[$i] ) {
										  					echo "selected";
										  				} ?>>
										  				<?php echo $doctor_presc_date[$i]; ?>
										  					
										  		  </option>
												  			<?php
												}
											  }
											?>
					</select>
                 </td>
              </tr>
            </table>
            </div>
         </div>
         <div class="box box-info">
                
                      <div class="box-body">
              <table width="100%" class="table table-striped table-bordered" id="iplistData">
              <thead>
                <tr>
                    <th class="font_th"><a href="#">Sl no</a></th>
                    <th class="font_th"><a href="#">Brand Name</a></th>
                    <th class="font_th"><a href="#">Medical Course</a></th>
                    <th class="font_th"><a href="#">Medical Days</a></th>
                    <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Status</a></th>
                    <th class="font_th"><a href="#">Select Medicine</a></th>
                </tr>
              </thead>
                    <div style="float: right;margin-right: 26px;padding: 10px;">

					  <label style="font-size: 14px;">Select / Deselect all</label> <input type='checkbox' id='checkAll'/>
					
				    </div>
               <tbody>
        <?php if(!empty($prescription_info)){
				 $j=1;
				 for($i=0;$i<count($prescription_info);$i++){
		 
						$patient_name=$prescription_info[$i][1]." ".$prescription_info[$i][2]." ".$prescription_info[$i][3];
								
		?>
							
						<tr <?php echo empty($prescription_info[$i][2])?'style=background-color:#FF9999;':''?>>
							<td><?php echo $j++;?></td>

                            <!-- presccribe outside medicines checking -->
							<td><?php echo !empty($prescription_info[$i][2])?$prescription_info[$i][16]:$prescription_info[$i][3];?></td>

							<td><?php echo $prescription_info[$i][4];?></td>
							<td><?php echo $prescription_info[$i][5];?></td>
							<td><?php echo date('d-m-Y h:i A', strtotime($prescription_info[$i][6]));?></td>

							<td style="text-align: center;">

                            <!-- presccribe outside medicines checking -->
							<?php 
							    if(!empty($prescription_info[$i][2])){

								    if (!empty($prescription_info[$i][17])) {
									      echo '<label style="color:red;">Solded</label>';
								    }
								     elseif (!empty($prescription_info[$i][19]) && $draft!='') {
								    	echo '<label style="color:green;">drafted</label>';
								    }
								    else{
										  echo '<label>Not Solded</label>';
								    }
								}else{

                                         echo 'OUTSIDE MEDICINE';  

								}
							?>


							</td>
							<td style="text-align: center;">
                            
                             <!-- presccribe outside medicines checking -->
							<?php 
							if(!empty($prescription_info[$i][2])){

							?>
						
								<input type="checkbox" name="select_medicines[]" id="<?php echo $prescription_info[$i][0]; ?>" class="select_medicines" class="selectone" value="<?php echo $prescription_info[$i][2]; ?>">
							
							<?php
						    }else{
						    	     //no data
						    }
							?>	
							</td>								

								
							
						</tr>
						
									
								
					<?php
						
						

								}
							}
						
					?>
			</tbody>
            </table>
                    <br>
                    <input type="hidden" name="ipno" id="ipno" value="<?php echo $ip_no; ?>">
                    <input type="hidden" name="doct_presc" id="doct_presc" value="">
                    <div align="right">
                    	 <input type="button" name="submit" value="Select Medicines" class="btn btn-info" id="submit"  />	
                    </div>
          </div>
         </div>
      </div>
              
        
            </div>
           
      </div>
</form>  

<?php
       $this->load->view("footer"); 
?>

<script type="text/javascript">

$(document).ready(function() {
	 
	 $('#checkAll').click(function(){

	  if ($("#checkAll").is(':checked')) {

		  	var checked_status = this.checked;
		  	$("input[name='select_medicines[]']").each(function(){
	        this.checked = checked_status;
	  		});

	  }
	  else{

	  	  	var checked_status = this.unchecked;
		  	$("input[name='select_medicines[]']").each(function(){
		    this.checked = checked_status;
		  	});

	  }
});
	
$("#submit").click(function(event){
    
	var checked=false;
		 med_list =new Array();
		 var k=0;

	     var elements = document.getElementsByName("select_medicines[]");

	     for(var i=0; i < elements.length; i++){

		    if(elements[i].checked) {

			   checked = true;
               med_list.push(elements[i].id);
			   
			 //add input box
             jQuery('#doctor_prescriptions').append('<input type="hidden" name="med_presc[]" value='+elements[i].value+' >');
			   k++;
		    }

	     }

	 	$("#ip_medicines_id").val(med_list);

	    if (!checked) {

		   showDialog('Error','Please Select atleast One item!','error', 2);
    	   return false;

	    }else{
	   
          $('#doct_presc').val('1');

          $('#invoice_form').attr('action',"<?php echo base_url(); ?>index.php/invoice/invoice_form");
	      $('#invoice_form').submit();
		  return true;
		}
	
        });	
	 
});

$('#prescription_date').change(function(){
    
   $.post("<?php echo base_url(); ?>index.php/invoice/get_doctor_prescription_ip", $("#ip_prescription").serialize(),function(data){ 

   	// alert(data['tableInfo']);return false;
    
   $("table#iplistData tbody").html(data['tableInfo']);
    },"json");

});       

</script>

