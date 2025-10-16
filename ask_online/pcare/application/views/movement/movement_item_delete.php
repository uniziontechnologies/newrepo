<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	   font-size: 15px;
   }	
   #requiredfield{
        
       color: #FF0000;
    }
</style>

<form name="delete_movement" id="delete_movement" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->

<?php
       $stock_mismatch_error = $this->session->flashdata('stock_mismatch_error'); 
       if(!empty($stock_mismatch_error)) 
        {
?>
          <div id='message' class="callout callout-danger"><?php echo $stock_mismatch_error; ?></div>
<?php
        } 
?>
      
          <!-- Main content -->
          <section class="content">
                    <h2>
                        Movement
                    </h2>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">

                      <div style="margin: 21px;">
                        
                        <h5>Movement From <?php echo $movement_info[0][3]; ?> To <?php echo $movement_info[0][5]; ?> on <?php echo date("d-m-Y",strtotime($movement_info[0][7]));?></h5>

                      </div>	
				
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Brand</a></th>
				            <th class="font_th"><a href="#">Batch</a></th>
				            <th class="font_th"><a href="#">Expiry</a></th>
				            <th class="font_th"><a href="#">Selling Unit</a></th>
				            <th class="font_th"><a href="#">Qty</a></th>
				        </tr>
		<?php        
                if(!empty($movement_item_Info)){						
				    $j=1;
				    for($i=0;$i<count($movement_item_Info);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++; ?></td>
							<td><?php echo $movement_item_Info[$i][10]; ?></td>
							<td><?php echo $movement_item_Info[$i][4]; ?></td>
							<td><?php echo $movement_item_Info[$i][5]; ?></td>
							<td><?php echo $movement_item_Info[$i][6]; ?></td>
							<td>
							    <?php echo $movement_item_Info[$i][7]; ?>
								<?php echo (!empty($batch_stock_error[$i]))?"<br><div id='requiredfield'>".$batch_stock_error[$i]."</div>":'';
								?>
							</td>
				        </tr>
		<?php
		            }
		        }
		?>				
		                

					   </table>
					</div>
				</div>
				        <input type="hidden" name="move_id" id="move_id">
				        <div align="center">

<?php 
            if(empty($batch_stock_change)){
?>
                <button type="button" class="btn btn-danger" onclick="deleteConfirm('<?php echo $movement_info[0][1]; ?>')" >Delete Movement</button> 
<?php
            }
?>
                        </div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">
	
function deleteConfirm(id){ 

	   $('#move_id').val(id);

       var v=confirm("Do You Want To Delete!");
		if(v) {
   			
			document.delete_movement.action='<?php echo base_url(); ?>index.php/movement/delete';
			document.delete_movement.submit();
			return true;
		}else return false;
	
	

}

</script>