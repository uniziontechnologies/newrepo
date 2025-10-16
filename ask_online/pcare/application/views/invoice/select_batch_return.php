<?php

$batchInfo=$this->session->userdata('batchidInfo');


?>
 <div id="wrapper">
            <div id="content">
       			<div class="row">
                  
		           <div class="box box-info">
                
                      <div class="box-body">
			            <table width="100%" class="table table-striped">
						
						<tr>
								<td ><b><?php echo $this->lang->line('brand'); ?> : <?php echo $brand_name;?></b></td>
								<td ><b><?php echo $this->lang->line('shelf_number'); ?> : <?php echo $shelf_number;?></b></td>
																
					    </tr>
						</table>
						</div>
				 </div>
				 <div class="box box-info">
                
                      <div class="box-body">
					    <table width="100%" class="table table-striped">
							<thead>
								<tr>
									<th>Sl No</th>
									<th><?php echo $this->lang->line('batch');?></th>									
									<th><?php echo $this->lang->line('expiry_date');?></th>
									<th><?php echo $this->lang->line('quantity');?></th>				
									<th>M.R.P</th>		
									<th><?php echo $this->lang->line('action');?></th>
								</tr>
							</thead>
							<tbody>
							
							<?php 
								if(!empty($batch)){						
										$j=1;
									for($i=0;$i<count($batch);$i++) {?>
											<tr>
												<td><?php echo $j++;?></td>
												<td><?php echo $batch[$i][2];?></td>
												<td><?php echo $batch[$i][3];?></td>
												<td><?php echo $batch[$i][4];?></td>
												<td><?php echo $batch[$i][6];?></td>
												<td>
												
									<?php if((!empty($batchInfo)) && in_array($batch[$i][0],$batchInfo)){ ?>

                                           <div id='required'>Batch Already Selected</div>
                                    <?php }else{ ?>									
											<input id="<?php echo 'batch_id'.$i;?>" type="hidden" value='<?php echo $batch[$i][0];?>' />
											<input type="button" name="addbatch" value="Select" id="addbatch<?php echo $i; ?>" class="save_bill btn btn-xs btn-info"  onclick="addbatch('<?php echo $batch[$i][0];?>')" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','addbatch','','')" onkeypress="if(event.keyCode== 13){return addbatch('<?php echo $batch[$i][0];?>');}"/>
										       
									<?php } ?>			

						

				
												</td>
												
											</tr>
						<?php			
								}
							}
								
								?>
							
							</tbody>
						</table>
						<input id='batch_count' type="hidden" value='<?php echo count($batch);?>' />
						<input id='selected_id' type="hidden" value='0' />
					</div>
				 </div>
			</div>
					
				
			
				
            </div>
           
      </div>
<?php
	  $this->load->view("footer"); 
?>
<script>

$(document).ready(function(){

   $("#addbatch0").focus();   

});

function addbatch(batch_id){

	$('#batch_hidden').val(batch_id);
	$('#item_focus').val("qty");
	$('#invoice_form').attr('action',"<?php echo base_url(); ?>index.php/invoice/invoice_return_form");
	$('#invoice_form').submit();
	

     //tb_remove();
	//alert(batch_id);
}
</script>

		
