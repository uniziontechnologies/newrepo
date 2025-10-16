
	
<?php
	
$post=$this  ->popArr['post'];
$medicine_item_info=$this  ->popArr['medicine_item_info'];


	
?>

<div id="content">
   <div class="box box-info">
                
            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#"><?php echo $lang_medicines; ?></a></th>
						<th ><a href="#"><?php echo $lang_qty; ?></a></th>
 
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($medicine_item_info)){
						     
					for($i=0;$i<count($medicine_item_info);$i++){?>

					<tr>
						<td><?php echo $i+1;?></td>
						<td><?php echo $medicine_item_info[$i][0];?></td>
						<td><?php echo $medicine_item_info[$i][1];?></td>
					</tr>


				<?php }
				
				  }
				?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
		</div>
	</div>


