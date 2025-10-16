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
</style>

<form name="print_purchaseorder" id="print_purchaseorder" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
    <center>   
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="80px" style="margin-top: -12px;"></img>   
          <h2 style="font-size: 19px;margin-top: 1px !important;"><b><?php echo strtoupper($hospitalInfo[0][1]); ?></b></h2>
          <!-- <h4 style="margin-top: -7px;font-size: 12px;">(A unit of MAK Hospitals Pvt Ltd)</h4> -->
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo strtoupper($hospitalInfo[0][2])." , ".strtoupper($hospitalInfo[0][3]); ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "Reg No : ".$pharmacyInfo[0][3]; ?></b></h4>
          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "GST NO : ".$pharmacyInfo[0][2]; ?></b></h4>
    </center>
       
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

                	    <h5 style="display:inline;">PO No : <?php echo $purchase_order_info[0][1]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">Date : <?php echo $purchase_order_info[0][2]; ?></h5>
                	    &nbsp;&nbsp;&nbsp;&nbsp;
                	    <h5 style="display:inline;">Supplier : <?php echo $purchase_order_info[0][4]; ?></h5>

                      </div>	
				
					   <table width="100%" class="table table-striped table-bordered">

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
				        <div align="center">
             	
                             <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="print_order()">
                             <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack()">

                        </div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
<!-- hidden fields -->
<?php
    $to_day=date("d-m-Y");

    $from_date=$this->input->post("from_date");
	$end_date=$this->input->post("end_date");
	$supplier=$this->input->post("supplier");		
	$pono=$this->input->post("pono");
	$purchase_status=$this->input->post("purchase_status");
	$show_deleted=$this->input->post("show_deleted");
	$current_page=$this->input->post("current_page");

if($supplier=='' && $pono=='' && $purchase_status=='' && $show_deleted=='' && $show_deleted==''){
      
    if($from_date==$to_day && $end_date==$to_day){
      
        $from_date='';
	    $end_date='';

    }
}

?>
  <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
  <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
  <input type="hidden" name="supplier" id="supplier" value="<?php echo $supplier; ?>">
  <input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>">
  <input type="hidden" name="purchase_status" id="purchase_status" value="<?php echo $purchase_status; ?>">
  <input type="hidden" name="show_deleted" id="show_deleted" value="<?php echo $show_deleted; ?>">

  <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
<!-- hidden fields -->		        
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">

function goBack() {
      	
    document.print_purchaseorder.action="<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order";
    document.print_purchaseorder.submit();

}
	
function print_order() {
      	
    window.print();

}

</script>