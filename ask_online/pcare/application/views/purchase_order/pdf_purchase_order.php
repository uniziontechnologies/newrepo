<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        color: #006633;   
   }
table.bill_info td, th{
	padding: 5px !important;
}
</style>

<form name="print_purchaseorder" id="print_purchaseorder" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
   <div style="text-align: center;">
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.JPG" width="120px" style="margin-top: -75;"></img>   
          <h2 style="font-size: 19px;margin-top: 1px !important;"><b><?php echo strtoupper($hospitalInfo[0][1]); ?></b></h2>
          <h4 style="margin-top: -7px;font-size: 12px;">(A unit of MAK Hospitals Pvt Ltd)</h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo strtoupper($hospitalInfo[0][3])." , ".strtoupper($hospitalInfo[0][4]); ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "Reg No : ".$pharmacyInfo[0][3]; ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "GST NO : ".$pharmacyInfo[0][2]; ?></b></h4>
    </div>
       
          <!-- Main content -->
          <section class="content">
                <h2>
                    Purchase Order 
                </h2>
		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">

                     <div style="margin-top: 9px;margin-bottom: 15px;">
                       <table>
                        <tr>
                	       <td>PO No : <?php echo $purchase_order_info[0][1]; ?>&nbsp;&nbsp;&nbsp;</td>
                	    
                	       <td>Date : <?php echo $purchase_order_info[0][2]; ?>&nbsp;&nbsp;&nbsp;</td>
                	   
                	       <td>Supplier : <?php echo $purchase_order_info[0][4]; ?></td>
                        </tr>
                       </table>
                      </div>	
				
					   <table width="100%" class="table table-striped table-bordered bill_info">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Brand</a></th>
				            <th class="font_th"><a href="#">Pack</a></th>
				            <th class="font_th"><a href="#">tablets/pack</a></th>
				            <th class="font_th"><a href="#">Qty</a></th>
				            <th class="font_th"><a href="#">FOC</a></th>
				            <th class="font_th"><a href="#">BuyP</a></th>
				            <th class="font_th"><a href="#">Total</a></th>
				        </tr>
		<?php        
                if(!empty($purchase_order_item_Info)){						
				    $j=1;
				    for($i=0;$i<count($purchase_order_item_Info);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $purchase_order_item_Info[$i][6];?></td>
						    <td><?php echo $purchase_order_item_Info[$i][3];?></td>
							<td><?php echo $purchase_order_item_Info[$i][7];?></td>
							<td><?php echo $purchase_order_item_Info[$i][4];?></td>
						    <td><?php echo $purchase_order_item_Info[$i][9];?></td>
							<td><?php echo $purchase_order_item_Info[$i][8];?></td>
						    <td><?php echo $purchase_order_item_Info[$i][10];?></td>
				        </tr>
		<?php
		            }
		        }
		?>		
		                <tr>
		                	   <td colspan="8">Remarks : <?php echo $purchase_order_info[0][5]; ?></td>
		                </tr>

					   </table>
					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->	        
</form>    

<?php
	  $this->load->view("footer"); 
?>