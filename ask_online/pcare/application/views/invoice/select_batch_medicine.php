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
								 <?php if(!empty($allergy_item)){	

						 	
							
										$j=1;
									for($i=0;$i<count($allergy_item);$i++) {

						
                                        if(strtoupper($allergy_item[$i])==strtoupper($item_name) || strtoupper($allergy_item[$i])==strtoupper($generic_name) )
                                        { ?>
                                        	<div class="alert alert-danger" style="font-size: 15px;">
                                           <strong>Alert !........</strong>Some Contents of this medicine is <b>allergic </b>to this patiient .
                                            </div>
                                    <?php   
                                      }
                                  }
                              }
						?>
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
										<?//php if(((!empty($batchInfo)) && in_array($batch[$i][0],$batchInfo))||(!empty($batch_drafted)) && in_array($batch[$i][0],$batch_drafted)){ ?>



                                           <div id='required'>Batch Already Selected</div>
                                    <?php }else{ ?>									
												<input id="<?php echo 'batch_id'.$i;?>" type="hidden" value='<?php echo $batch[$i][0];?>' />
												<input type="button" name="addbatch" value="Select" id="addbatch" class="save_bill btn btn-xs btn-info"  onclick="addbatch('<?php echo $batch[$i][0];?>','<?php echo $item_pos; ?>')"/>
										       
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
	  <script>
	  function addbatch(batch_id,item_pos){
	

	$('#batch_hidden').val(batch_id);
	$('#select_batch_position').val(item_pos);
	$('#item_focus').val("qty");
	$('#invoice_form').attr('action',"<?php echo base_url(); ?>index.php/invoice/invoice_form");
	$('#invoice_form').submit();
	

     //tb_remove();
	//alert(batch_id);
}
</script>
<?php
			 $this->load->view("footer"); 
	       ?>
		
