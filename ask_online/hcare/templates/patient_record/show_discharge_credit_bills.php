
	
<?php
	
$post=$this  ->popArr['post'];
$credit_pharma_item_info=$this  ->popArr['credit_pharma_item_info'];


	
?>

<div id="content">
	
   <div class="box box-info">
                
            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#">INVOICE NO</a></th>
						<th ><a href="#"></a>BILL NO</th>
						<th ><a href="#">BILL DATE</a></th>
						<th ><a href="#">PAYMENT DATE</a></th>
						
						<th ><a href="#">AMOUNT</a></th>
 
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($credit_pharma_item_info)){
						     
					for($i=0;$i<count($credit_pharma_item_info);$i++){ //var_dump($credit_pharma_item_info);?>
                     
					<tr>
						<td><?php echo $i+1;?></td>
						<td><?php echo $credit_pharma_item_info[$i][0];?></td>
						<td><?php echo $credit_pharma_item_info[$i][15];?></td>
						<td><?php echo date('d-m-Y h:i A',strtotime($credit_pharma_item_info[$i][7]));?></td>
						<td><?php echo date('d-m-Y h:i A',strtotime($credit_pharma_item_info[$i][7]));?></td>
						<td><?php echo $credit_pharma_item_info[$i][4]+$credit_pharma_item_info[$i][5];?></td>
					
						
					</tr>


				<?php }
				
				  }
				?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
		</div>
	</div>


