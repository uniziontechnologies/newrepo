
 <div id="wrapper">
            <div id="content">
       			<div class="row">

				 <div class="box box-info">
                
                      <div class="box-body">
					    <table width="100%" class="table table-striped">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>DATE</th>									
									<th>TYPE</th>
									<th>USER</th>		
								</tr>
							</thead>
							<tbody>
							
									<?php 
										    if(!empty($history)){			
											    $j=1;
											    for($i=0;$i<count($history);$i++) { 
									?>
											    <tr>
												    <td><?php echo $j++;?></td>
												    <td><?php echo date("d-m-Y h:i A",strtotime($history[$i][1]));?></td>
												    <td><?php if ($history[$i][2]==1) {
												    	echo "New Stock Import";
												    }else if ($history[$i][2]==2) {
												    	echo "Clear Stock & Import";
												    }else if ($history[$i][2]==3) {
												    	echo "Stock Update";
												    };?></td>
												    <td><?php echo $history[$i][4];?></td>									
										        </tr>
									<?php			
												}
											}
									?>
							
							</tbody>

						</table>
						
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
	$('#purchase_return_form').attr('action',"<?php echo base_url(); ?>index.php/purchase/purchase_return_form");
	$('#purchase_return_form').submit();
	

     //tb_remove();
	//alert(batch_id);
}
</script>

		
