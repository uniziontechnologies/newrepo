<script>
	
	  $(document).ready(function() { 

   //       $("#covid_syptoms_yes").on('ifChanged', function() {

   //       	if ( $('#covid_syptoms_yes').is(":checked") ) {
   //       		$("#covid_19_symptoms").show(); 
   //       	}
   //       	else{
   //       		$("#covid_19_symptoms").val(''); 
   //       		$("#covid_19_symptoms").hide(); 
   //       	}

		 // });

   //       $("#covid_syptoms_no").on('ifChanged', function() {

   //       	$("#covid_19_symptoms").val(''); 
   //       	$("#covid_19_symptoms").hide(); 
         	
		 // });




   //       $("#covid_syptoms_no").on('ifChanged', function() {

   //       	$("#covid_19_symptoms").val(''); 
   //       	$("#covid_19_symptoms").hide(); 
         	
		 // });


         $(".travel_abroad_class").on('ifChanged', function() {

         	if ($(this).is(":checked")) {
         		$('input.travel_abroad_class').not(this).attr('disabled', 'disabled');  
         	}
         	else{
         		$('input.travel_abroad_class').not(this).removeAttr('disabled');  
         	}

		 });

         $(".travel_contact_class").on('ifChanged', function() {

         	if ($(this).is(":checked")) {
         		$('input.travel_contact_class').not(this).attr('disabled', 'disabled');  
         	}
         	else{
         		$('input.travel_contact_class').not(this).removeAttr('disabled');  
         	}

		 });

         $(".contact_patient_class").on('ifChanged', function() {

         	if ($(this).is(":checked")) {
         		$('input.contact_patient_class').not(this).attr('disabled', 'disabled');  
         	}
         	else{
         		$('input.contact_patient_class').not(this).removeAttr('disabled');  
         	}

		 });

         $(".contact_suspect_class").on('ifChanged', function() {

         	if ($(this).is(":checked")) {
         		$('input.contact_suspect_class').not(this).attr('disabled', 'disabled');  
         	}
         	else{
         		$('input.contact_suspect_class').not(this).removeAttr('disabled');  
         	}

		 });

         $(".covid_syptoms_class").on('ifChanged', function() {

         	if ($(this).is(":checked")) {
         		$('input.covid_syptoms_class').not(this).attr('disabled', 'disabled');  
         	}
         	else{
         		$('input.covid_syptoms_class').not(this).removeAttr('disabled');  
         	}

		 });



         $("#save").bind('click', function() {
		    
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_covid_status");
   	             $("#form").submit();
		  });	
     });	

  	  
</script>

<?php
	$covidInfo=$this  ->popArr['covidInfo'];
	$covidHistory=$this  ->popArr['covidHistory'];
	 

?>
<div class="box box-info">
                
     <div class="box-body">
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
							     <input type="checkbox" name="travel_abroad_yes" id="travel_abroad_yes" value="YES" class="travel_abroad_class" <?php if ($covidInfo[0][5]=="YES") {echo "checked";} ?> >
							</td>
							<td>
							     <input type="checkbox" name="travel_abroad_no" id="travel_abroad_no" value="NO" class="travel_abroad_class" <?php if ($covidInfo[0][5]=="NO") {echo "checked";} ?> >
							</td>
				  </tr>

				  <tr>
				            <td>
							     Contact with persons who travel abroad
							</td>
				            <td>
							     <input type="checkbox" name="travel_contact_yes" id="travel_contact_yes" value="YES" class="travel_contact_class"  <?php if ($covidInfo[0][6]=="YES") {echo "checked";} ?> >
							</td>
							<td>
							     <input type="checkbox" name="travel_contact_no" id="travel_contact_no" value="NO" class="travel_contact_class"  <?php if ($covidInfo[0][6]=="NO") {echo "checked";} ?> >
							</td>
				  </tr>

				  <tr>
				            <td>
							     Contact with COVID-19 patient
							</td>
				            <td>
							     <input type="checkbox" name="contact_patient_yes" id="contact_patient_yes" value="YES" class="contact_patient_class"  <?php if ($covidInfo[0][7]=="YES") {echo "checked";} ?> >
							</td>
							<td>
							     <input type="checkbox" name="contact_patient_no" id="contact_patient_no" value="NO" class="contact_patient_class"  <?php if ($covidInfo[0][7]=="NO") {echo "checked";} ?> >
							</td>
				  </tr>

				  <tr>
				            <td>
							     Contact with persons who have suspected with COVID-19 symptoms
							</td>
				            <td>
							     <input type="checkbox" name="contact_suspect_yes" id="contact_suspect_yes" value="YES" class="contact_suspect_class"  <?php if ($covidInfo[0][8]=="YES") {echo "checked";} ?> >
							</td>
							<td>
							     <input type="checkbox" name="contact_suspect_no" id="contact_suspect_no" value="NO" class="contact_suspect_class"  <?php if ($covidInfo[0][8]=="NO") {echo "checked";} ?> >
							</td>
				  </tr>
			     
				  <tr>
				            <td>
							     Do you have COVID-19 symptoms
							</td>
				            <td>
							     <input type="checkbox" name="covid_syptoms_yes" id="covid_syptoms_yes" value="YES" class="covid_syptoms_class"  <?php if ($covidInfo[0][9]=="YES") {echo "checked";} ?>>
							</td>
							<td>
							     <input type="checkbox" name="covid_syptoms_no" id="covid_syptoms_no" value="NO" class="covid_syptoms_class"  <?php if ($covidInfo[0][9]=="NO") {echo "checked";} ?>>
							</td>
				  </tr>

				  <tr>
				            <td colspan="3">

								<textarea name="covid_19_symptoms" id="covid_19_symptoms" rows="2" cols="62" placeholder="Enter covid-19 symptoms here....."><?php if (!empty($covidInfo[0][10])) {echo $covidInfo[0][10];} ?></textarea>

							     
							</td>


				  </tr>

		
					<tr>
						<td id="noborder" colspan="3" align="center"><input type="button" id="save"  name="Save" class="btn btn-success" value="Save" class="save"/></td>
				    </tr>
		</table>
	 
	 </div>
</div>

<div class="box box-info">

<?php

    $entered_user='';
    $updated_user='';

    $update_history_list=$covidInfo[0][15];
    if(!empty($update_history_list)){

       $count=count($update_history_list);
       $entered_user_position=$count-1;

       $entered_user=$update_history_list[$entered_user_position];

       for ($i=0; $i<count($update_history_list)-1 ; $i++) { 
       	
       	    $updated_user.=$update_history_list[$i]."<br>";
       }

    }

?>
                
        <div class="box-body">
			<table class="table">
			
			 <tbody>
			  <tr>
			     <th>Entered By : </th>
			     <td><div style="background-color: #f5f5c7 !important;"><?php echo $entered_user; ?></div></td>
			 
		     </tr>
		     <tr>
		     	   <td colspan="2"></td>
		     </tr>
		     <tr>
			    
			     <th>Updated By : </th>
			     <td>
			        <div style="background-color: #f5f5c7 !important;">
			         <?php echo $updated_user; ?>
			        </div>
			     </td>
			 </tr>
			
			</tbody></table>
			
		</div>
	 	
		  
</div>

		</div>

	<div class="col-md-6">	

        <div class="box box-success direct-chat direct-chat-success">
		 
		 
		 <div class="box-header with-border">
		    <b><?php echo 'COVID-19 HISTORY';?></b>
		  </div>
		  <div class="box-body">
            <?php if(!empty($covidHistory)){

                    for($k=0;$k<count($covidHistory);$k++){
		    
		     
		    
		    ?>	    
                       <div class="box box-success collapsed-box box-solid">
                          <div class="box-header with-border">
                             <?php echo date("d-m-Y h:i A",strtotime($covidHistory[$k][4]));?> 
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
			    
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

				            		if ($covidHistory[$k][5]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class" <?php if ($covidHistory[$k][5]=="YES") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][5]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class" <?php if ($covidHistory[$k][5]=="NO") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][6]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidHistory[$k][6]=="YES") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][6]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidHistory[$k][6]=="NO") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][7]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidHistory[$k][7]=="YES") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][7]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidHistory[$k][7]=="NO") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][8]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidHistory[$k][8]=="YES") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][8]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidHistory[$k][8]=="NO") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][9]=="YES") {?>
				            			<input type="checkbox" value="YES" class="covid_history_class"  <?php if ($covidHistory[$k][9]=="YES") {echo "checked";} ?> >
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

				            		if ($covidHistory[$k][9]=="NO") {?>
				            			<input type="checkbox" value="NO" class="covid_history_class"  <?php if ($covidHistory[$k][9]=="NO") {echo "checked";} ?> >
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

								<textarea rows="2" cols="62" class="covid_history_class" ><?php if (!empty($covidHistory[$k][10])) {echo $covidHistory[$k][10];} ?></textarea>

							     
							</td>


				  </tr>

                                </table>

				
                           </div><!-- /.box-body -->
                   </div><!-- /.box -->
	<?php  }
	     }
	?>
	</div>


		</div>

	</div>
				
</div>		 

<input type="hidden" name="covid_id" id="covid_id" value="<?php echo !empty($covidInfo[0][0])?$covidInfo[0][0]:''; ?>">