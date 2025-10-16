
<script type="text/javascript">
	
	  $(document).ready(function() {  	
	
	    $('#inner-content-div').slimScroll({
	        height: '400px'
	    });

	    $('#inner-content-div h4').css('font-size','17px');

	   });

      $(function () {
	  
	  	  $(".next_page").bind('click', function() {

	  	  		 $("#visit_date").val("");
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				 var active_module="covid_status";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");

			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				 var active_module="covid_status";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");

			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				 var active_module="covid_status";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });	

			   $("#visit_date").bind('change', function() {
			  	
			  		var visit_id= $(this).val();

			  		$("#current_page").val("");

			  		$(".pagination").val("");

					 var active_module="covid_status";
					  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
					 $("#form").submit();

			  		
					
			  });	

	  });


</script>



<?php
	
$patient_info_dropdown=$this  ->popArr['patient_info_dropdown'];
$covidInfo=$this  ->popArr['covidInfo'];
$pagination=$this  ->popArr['pagination'];
$current_page=$this  ->popArr['current_page'];
$perPage=$this  ->popArr['perPage'];
$date_selected=$this  ->popArr['date_selected'];

	
?>

<style type="text/css">

ul.pagination.pagination-sm.no-margin.pull-right {
    float: left !important;
}

</style>

    <!-- Main content -->
    <section class="content">


    <div class="box box-info">

   	  <div class="row">
   	  	
   	  	<div class="col-md-offset-7 col-md-2">
   	  		
   	  		<select id="visit_date" name="visit_date" class="form-control">
   	  			<option value=""> Please Select </option>
   	  			<?php

   	  				for ($i=0; $i <count($patient_info_dropdown) ; $i++) { ?>
   	  					<option value="<?php echo $patient_info_dropdown[$i][13]; ?>" <?php if (!empty($patient_info_dropdown[$i]) && $patient_info_dropdown[$i][13]==$date_selected ) {
   	  						echo "selected";
   	  					} ?> ><?php echo $patient_info_dropdown[$i][20]; ?></option>
   	  				<?php
   	  				}

   	  			?>
   	  		</select>

   	  	</div>

   	  	<div class="col-md-3">
   	  		<?php echo $pagination;?>
   	  	</div>

   	  </div>
   </div>


    <div class="row">


        <div class="col-md-4">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Visit Info</h3>
            
            </div>
            <div class="box-body">
            <div class="row">

			 <table class="table">
			<?php

				for ($i=0; $i <count($covidInfo) ; $i++) { ?>

					<tr>
					    <td rowspan="1" style="text-align: center;"><?php						
								if(file_exists("../../templates/registration/patient_photo/".$patientInfo[$i][0]."/photo.jpg")){
								?>
								
								<img src="../../templates/registration/patient_photo/<?php echo $patientInfo[$i][0];?>/photo.jpg" width="80" height="80">
								<?php
								 }else{						
								?>
								<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
								<?php } ?>
					   </td>
					   <td>
					   	<td style="line-height: 40px;">
					   		<?php echo ucwords(strtolower($lang_doctor)); ?>:<?php echo "Dr ".strtoupper($patientInfo[$i][15])." ".$patientInfo[$i][16];?><br>
					   		<?php echo ucwords(strtolower($lang_date)); ?>:<?php echo ucwords(strtolower(($patientInfo[$i][20])));?>
					   		
					   	</td>
					   </td>							
					</tr>

					<tr>

						<td style="text-align: center;padding-top: 30px;">
							<?php echo ucwords(strtolower($lang_name)); ?>:<?php echo strtoupper($patientInfo[$i][1])." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>

					</tr>
					<tr>
						<td style="text-align: center;padding-top: 10px;">
							<?php echo ucwords(strtolower($lang_age)); ?>:<?php echo $patientInfo[$i][4]."/".$patientInfo[$i][6];?>
						</td>
					</tr>


				<?php
			}
			?>
			</table>



            </div>
            </div><!-- /.box-body -->
            <!--<div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		  
		</div><!---col-md-6---->
		
		 <div class="col-md-8">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Covid -19 Details</h3>
            
            </div>
            <div class="box-body" id="inner-content-div">

		        <?php

					if(!empty($covidInfo)){

						$j=(($current_page-1)*$perPage)+1;

                    	for($k=0;$k<count($covidInfo);$k++){?>


                                <table class="table table-striped">
                                	
	              <tr>
				                <td ><?php echo "";?></td>
								<td><?php echo "YES";?></td>
								<td><?php echo "NO";?></td>
				  </tr>
				  <tr>
				            <td>
							     Travel abroad
							</td>
				            <td>

				            	<?php 

				            		if ($covidInfo[$k][0][5]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class" <?php if ($covidInfo[$k][0][5]=="YES") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" value="YES" class="covid_history_class" disabled>
				            		<?php
				            		}

				            	?>
							     
							</td>
							<td>

				            	<?php 

				            		if ($covidInfo[$k][0][5]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class" <?php if ($covidInfo[$k][0][5]=="NO") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							</td>
				  </tr>

				  <tr>
				            <td>
							     Contact with persons who travel abroad
							</td>
				            <td>

				            	<?php 

				            		if ($covidInfo[$k][0][6]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidInfo[$k][0][6]=="YES") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>
							<td>

				            	<?php 

				            		if ($covidInfo[$k][0][6]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidInfo[$k][0][6]=="NO") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>
				  </tr>

				  <tr>
				            <td>
							     Contact with COVID-19 patient
							</td>

				            <td>

				            	<?php 

				            		if ($covidInfo[$k][0][7]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidInfo[$k][0][7]=="YES") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>
							<td>

				            	<?php 

				            		if ($covidInfo[$k][0][7]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidInfo[$k][0][7]=="NO") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>

				  </tr>

				  <tr>
				            <td>
							     Contact with persons who have suspected with COVID-19 symptoms
							</td>


				            <td>

				            	<?php 

				            		if ($covidInfo[$k][0][8]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidInfo[$k][0][8]=="YES") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>
							<td>

				            	<?php 

				            		if ($covidInfo[$k][0][8]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidInfo[$k][0][8]=="NO") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>

				  </tr>
			     
				  <tr>
				            <td>
							     Do you have COVID-19 symptoms
							</td>


				            <td>

				            	<?php 

				            		if ($covidInfo[$k][0][9]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidInfo[$k][0][9]=="YES") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>
							<td>

				            	<?php 

				            		if ($covidInfo[$k][0][9]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidInfo[$k][0][9]=="NO") {echo "checked";} ?> >
				            		<?php
				            		}
				            		else{?>
				            			<input type="checkbox" disabled>
				            		<?php
				            		}

				            	?>

							     
							</td>

				  </tr>

				  <tr>
				            <td colspan="3">

								<textarea rows="2" cols="62" class="covid_history_class" ><?php if (!empty($covidInfo[$k][0][10])) {echo $covidInfo[$k][0][10];} ?></textarea>

							     
							</td>


				  </tr>

                                </table>




                    	<?php
						}

					}

				?>



            </div><!-- /.box-body -->

          </div><!-- /.box -->

		</div><!---col-md-6---->
	</div><!---row---->

</section><!-- /.content -->


<input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
