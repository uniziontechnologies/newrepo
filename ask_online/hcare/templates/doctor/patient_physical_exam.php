<script>
	
	  $(document).ready(function() { 

	  	 $("#height").blur(function() {

                var height=$("#height").val();
                var weight=$("#weight").val();

            if(height!='' && weight!='')
                {
              	   var bmi;
              	   bmi=bmi_calculation(height,weight);
              	   $("#bmi").val(bmi);
             
                }
            else{
                   $("#bmi").val('');
                }

         });
        
         $("#weight").blur(function(){

              	var height=$("#height").val();
                var weight=$("#weight").val();

            if(height!='' && weight!='')
                {
              	   var bmi;
              	   bmi=bmi_calculation(height,weight);
              	   $("#bmi").val(bmi);

                } 
            else{
                   $("#bmi").val('');  
                }    
              
         }); 

         $("#save").bind('click', function() {
		    
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_physical_examination");
   	             $("#form").submit();
		  });	
     });	

     function  bmi_calculation(height,weight){
         
         var height_mtr;
         var bmi_value;
         var bmi;

         height_mtr=height/100;

         bmi_value=weight/(height_mtr*height_mtr);

         bmi=bmi_value.toFixed(1);
         
         return bmi;
     }	  
</script>
<?php
	$physical_examination=$this  ->popArr['physical_examination'];
	$examinatHistory=$this  ->popArr['examinatHistory'];
	 
?>
<div class="box box-info">
                
     <div class="box-body">
	  <table class="table table-striped">
	  
	              <tr>
				                <td ><?php echo $lang_temp;?></td>
								<td><?php echo $lang_pulse;?></td>
								<td><?php echo $lang_bp;?></td>
				  </tr>
				  <tr>
				             <td >
							     <input name="temp" id="temp" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][3];?>' autocomplete="off" onkeypress="nextField(event.keyCode,pulse)"/> F
							</td>
							<td >
							     <input name="pulse" id="pulse" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][4];?>' autocomplete="off" onkeypress="nextField(event.keyCode,bp)"/> bpm
							</td>
								<td >
							     <input name="bp" id="bp" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][5];?>' autocomplete="off" onkeypress="nextField(event.keyCode,height)"/> (mm/hg)
							</td>
				  </tr>
			     
						
						 <tr>
				                <td ><?php echo $lang_height;?></td>
								<td><?php echo $lang_weight;?></td>
								<td><?php echo $lang_bmi;?></td>
				        </tr>
						<tr>
							  <td id="noborder">
							     <input name="height" id="height" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][6];?>' autocomplete="off" onkeypress="nextField(event.keyCode,weight)"/> (cm)
							</td>
							<td id="noborder">
							     <input name="weight" id="weight"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][7];?>' autocomplete="off" onkeypress="nextField(event.keyCode,bmi)"/>  (kgs)
							</td>
							<td id="noborder">
							     <input name="bmi" id="bmi" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][8];?>' readonly autocomplete="off" onkeypress="nextField(event.keyCode,resp)"/>
							</td>
						</tr>
					 <tr>
				                <td ><?php echo $lang_resp_rate;?></td>
								<td colspan="2"><?php echo $lang_oxy_saturation;?></td>
							    
								
								<!--<th id="noborder">GEN.CONDITION</td>-->
					</tr>
						<tr>
							<td >
							     <input name="resp" id="resp"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][9];?>' autocomplete="off" onkeypress="nextField(event.keyCode,oxygen_satu)"/> rpm
							</td>
							<td colspan="2">
							     <input name="oxygen_satu" id="oxygen_satu"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,gen_condn)"/> %
							</td>
						</tr>
							<tr>
							  <td colspan="3"><?php echo $lang_gen_condition;?></td>
							  
							</tr>
							<tr>
							  <td colspan="3"><textarea name="gen_condn" id=name="gen_condn" rows="2" cols="55"><?php echo empty($physical_examination)?"":$physical_examination[0][11];?></textarea>
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

    $update_history_list=$physical_examination[0][13];
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
	 <div class="col-md-3">				 
                 <!--<div class="box box-warning box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_preview;?>
		    </div>
                
                    <div class="box-body">

                    </div>
    </div>-->
	</div>
	<div class="col-md-6">				 
                   <div class="box box-success direct-chat direct-chat-success">
		 
		 <div class="box-header with-border">
		    <b><?php echo $lang_examination_history;?></b>
		    </div>
		  <div class="box-body">
            <?php if(!empty($examinatHistory)){

                    for($k=0;$k<count($examinatHistory);$k++){
		    
		     
		    
		    ?>	    
                       <div class="box box-success collapsed-box box-solid">
                          <div class="box-header with-border">
                             <?php echo $examinatHistory[$k][2];?> 
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
			    
                                <!-- presenting complaints---->
			  <?php 
			     $examHis=$examinatHistory[$k][0];
			     
		             if(!empty($examHis)){?>
			       <table class="table table-striped">
				   
				  <?php
				           for($i=0;$i<count($examHis);$i++){?>
					   <tr >
					   
					     <td ><b><?php echo $lang_temp;?></b></td><td><?php echo $examHis[$i][3];?>F</td>
						<td><b><?php echo $lang_pulse;?></b></td><td><?php echo $examHis[$i][4];?>bpm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_bp;?></b></td><td><?php echo $examHis[$i][5];?>(mm/hg)</td>
						<td ><b><?php echo $lang_height;?></b></td><td><?php echo $examHis[$i][6];?>cm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_weight;?></b></td><td><?php echo $examHis[$i][7];?>kgs</td>
						<td><b><?php echo $lang_bmi;?></b></td><td><?php echo $examHis[$i][8];?></td>
					    
					 </tr>
					 <tr >
					   
					     <td colspan="2"><b><?php echo $lang_resp_rate;?></b> <?php echo $examHis[$i][9];?>rpm</td>
					 </tr>
					 <tr >
						<td colspan="2"><b><?php echo $lang_oxy_saturation;?></b> <?php echo $examHis[$i][10];?>%</td>
						
					    
					 </tr>
					 <tr>
							  <td colspan="3"><b><?php echo $lang_gen_condition;?></b></td>
							  
							</tr>
							<tr>
							  <td colspan="3"><p><?php echo $examHis[$i][11];?></p>
							  </td>
							 </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>
				
                           </div><!-- /.box-body -->
                   </div><!-- /.box -->
	<?php  }
	     }
	?>
	</div>
	</div>
	</div>
				
</div>	
<input type="hidden" name="phid" id="phid" value="<?php echo empty($physical_examination)?"":$physical_examination[0][0];?>">
					 