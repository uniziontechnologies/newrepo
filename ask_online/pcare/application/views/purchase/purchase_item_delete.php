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

<form name="delete_purchase" id="delete_purchase" method="post" action="">

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
                        Purchase
                    </h2>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">

                      <div style="margin: 21px;">
                        
                        <h5 style="display:inline;">Inv No : <?php echo $purchaseInfo[0][1]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">Bill No : <?php echo $purchaseInfo[0][27]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">PO No : <?php echo $purchaseInfo[0][2]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">Date : <?php echo $purchaseInfo[0][3]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">Supplier : <?php echo $purchaseInfo[0][5]; ?></h5>

                      </div>	
				
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Mode</a></th>
				            <th class="font_th"><a href="#">Brand</a></th>
				            <th class="font_th"><a href="#">Batch</a></th>
				            <th class="font_th"><a href="#">Expiry</a></th>
				            <th class="font_th"><a href="#">Pack</a></th>
				            <th class="font_th"><a href="#">Qty</a></th>
				            <th class="font_th"><a href="#">FOC</a></th>
				            <th class="font_th"><a href="#">BuyP</a></th>
				            <th class="font_th"><a href="#">Discount</a></th>
				            <th class="font_th"><a href="#">SellP</a></th>
				            <th class="font_th"><a href="#">GST%</a></th>
				            <th class="font_th"><a href="#">SGST</a></th>
				            <th class="font_th"><a href="#">CGST</a></th>
				            <th class="font_th"><a href="#">TOT.GST</a></th>
				            <th class="font_th"><a href="#">Total</a></th>
				        </tr>
		<?php        
                if(!empty($purchaseItemInfo)){						
				    $j=1;
				    for($i=0;$i<count($purchaseItemInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++; ?></td>
							<td><?php echo $purchaseItemInfo[$i][3]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][15]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][4]; ?></td>
							<td><?php echo date("d-m-y",strtotime($purchaseItemInfo[$i][5])); ?></td>
							<td><?php echo $purchaseItemInfo[$i][6];echo ($purchaseItemInfo[$i][16]!='')?"(".$purchaseItemInfo[$i][16].")":"";  ?></td>
							<td>
							    <?php echo $purchaseItemInfo[$i][7]; ?>
								<?php echo (!empty($batch_stock_error[$i]))?"<br><div id='requiredfield'>".$batch_stock_error[$i]."</div>":'';
								?> 
							</td>
							<td><?php echo $purchaseItemInfo[$i][8]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][12]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][10]; ?> :
							<?php echo $purchaseItemInfo[$i][11]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][9]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][17]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][21]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][22]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][20]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][13]; ?></td>
				        </tr>
		<?php
		            }
		        }
		?>		
		                

					   </table>
					   <br><br>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <td>Purchsae Amount : <?php echo $purchaseInfo[0][6]; ?></td>
				            <td>SGST : <?php echo $purchaseInfo[0][9]; ?></td>
				            <td>CGST : <?php echo $purchaseInfo[0][8]; ?></td>
				            <td>TOT.GST : <?php echo $purchaseInfo[0][7]; ?></td>
				        </tr>
				        <tr>
				            <td>Frieght : <?php echo $purchaseInfo[0][10]; ?></td>
				            <td>Return : <?php echo $purchaseInfo[0][11]; ?></td>
				            <td>Bill Total : <?php echo $purchaseInfo[0][12]; ?></td>
				            <td>Discount : 
				            <?php  if(!empty($purchaseInfo[0][13]) && ($purchaseInfo[0][13]=='CASH')){
                                    echo $purchaseInfo[0][13]." ".$purchaseInfo[0][15]; 
				            }elseif (!empty($purchaseInfo[0][13]) && ($purchaseInfo[0][13]=='%')) {
				            	    echo "(".$purchaseInfo[0][14]." ".$purchaseInfo[0][13].")"." ".$purchaseInfo[0][15];
				            }else{
                                     echo $purchaseInfo[0][13];//no discount
				            }
				            ?>
				            	
				            </td>
				        </tr>
				        <tr>
				        	<?php if($purchaseInfo[0][18] == "CHEQUE") { ?>
						
							<td >Checque No : <?php echo $purchaseInfo[0][19]; ?></td>
							
							<td >Checque Amount : <?php echo $purchaseInfo[0][20]; ?></td>
						
						
						<?php } ?>		
						<?php if($purchaseInfo[0][18] == "CREDIT CARD") { ?>
						
							<td >Card Amount : <?php echo $purchaseInfo[0][21]; ?></td>
							
						<?php } ?>							
				        </tr>
				        <tr>
				            <td>Net Total : <?php echo $purchaseInfo[0][17]; ?></td>
				            <td>Payment Type : <?php echo $purchaseInfo[0][18]; ?></td>
				            <td>Amount Paid : <?php echo $purchaseInfo[0][22]; ?></td>
				            <td>Balance : <?php echo $purchaseInfo[0][23]; ?></td>
				        </tr>
				        <tr>
				            <td colspan="4">Remarks : <?php echo $purchaseInfo[0][26]; ?></td>
				        </tr>

					   </table>
					</div>
				</div>
				       <input type="hidden" name="purchase_id" id="purchase_id">
				       <input type="hidden" name="cancellation_details" id="cancellation_details">
				<div align="center">
 <?php 
      if(empty($batch_stock_change)){
?>			
                <button type="button" class="btn btn-danger" onclick="deleteConfirm('<?php echo $purchaseInfo[0][1]; ?>')" >Delete Purchase</button>
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

       var v=confirm("Do You Want To Delete!");

		if(v) {

			var details=prompt("Please Enter Cancellation Details:",""); 

			if(details!= null){

			  $('#purchase_id').val(id);
			  $('#cancellation_details').val(details);
   			
			document.delete_purchase.action='<?php echo base_url(); ?>index.php/purchase/delete';
			document.delete_purchase.submit();
			return true;

		    }else{
		    	return false;
		    }
		}else return false;
	
}

</script>