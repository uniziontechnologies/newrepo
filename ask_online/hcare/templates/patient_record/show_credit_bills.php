
	
<?php
	
$post=$this  ->popArr['post'];
$credit_item_info=$this  ->popArr['credit_item_info'];


	
?>

<div id="content">
	OP NO  :<?php echo $credit_item_info[0][21];?>
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
						<th ><a href="#">PAYMENT MODE</a></th>
						<th ><a href="#">CASH</a></th>
						<th ><a href="#">CARD AMOUNT</a></th>
						<th ><a href="#">TOTAL</a></th>
 
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($credit_item_info)){
						     
					for($i=0;$i<count($credit_item_info);$i++){ //var_dump($credit_item_info);?>
                     
					<tr>
						<td><?php echo $i+1;?></td>
						<td><?php echo $credit_item_info[$i][15];?></td>
						<td><?php echo $credit_item_info[$i][0];?></td>
						<td><?php echo date('d-m-Y h:i A',strtotime($credit_item_info[$i][11]));?></td>
						<td><?php echo date('d-m-Y h:i A',strtotime($credit_item_info[$i][17]));?></td>
						<td><?php echo $credit_item_info[$i][22];?></td>
						<td><?php echo $credit_item_info[$i][23];?></td>
						<td><?php echo $credit_item_info[$i][24];?></td>
						<td><?php echo $credit_item_info[$i][23]+$credit_item_info[$i][24];?></td>
					</tr>


				<?php }
				
				  }
				?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
		</div>
	</div>


