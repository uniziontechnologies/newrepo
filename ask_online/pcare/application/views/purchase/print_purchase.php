<?php 
	  if (empty($popup_path)) {
	  	$this->load->view("header");
	  }
   
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        color: #006633;   
   }	
<?php if (!empty($from_path)) {?>
	.content{
		margin-top: 60px;
	}
<?php
} ?> 
</style>

<form name="print_purchase" id="print_purchase" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
	    <?php if (empty($from_path) && empty($popup_path) ) {?>

		    <center>   
		          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="80px" style="margin-top: -12px;"></img>   
		          <h2 style="font-size: 19px;margin-top: 1px !important;"><b><?php echo strtoupper($hospitalInfo[0][1]); ?></b></h2>
		          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo strtoupper($hospitalInfo[0][2])." , ".strtoupper($hospitalInfo[0][3]); ?></b></h4>
		          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h4>
		          <h4 style="margin-top: -7px;font-size: 12px;"><b><?php echo "Reg No : ".$pharmacyInfo[0][3]; ?></b></h4>
                  <!-- <h4 style="margin-top: -7px;font-size: 12px;"><b><?php //echo "GST NO : ".$pharmacyInfo[0][2]; ?></b></h4> -->
		    </center>

	    <?php
	    } ?>  


      
          <!-- Main content -->
          <section class="content">
                    <h2>
                        Purchase
                    </h2>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">

                      <div style="margin-top: 9px;margin-bottom: 15px;">
                        
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
				            <th class="font_th"><a href="#">Rate</a></th>
				            <th class="font_th"><a href="#">Discount</a></th>
				            <th class="font_th"><a href="#">M.R.P</a></th>
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
				            <td ><?php echo $j++; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][3]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][15]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][4]; ?></td>
							<td ><?php echo date("d-m-y",strtotime($purchaseItemInfo[$i][5])); ?></td>
							<td ><?php echo $purchaseItemInfo[$i][6];echo ($purchaseItemInfo[$i][16]!='')?"(".$purchaseItemInfo[$i][16].")":"";  ?></td>
							<td ><?php echo $purchaseItemInfo[$i][7]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][8]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][12]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][10]; ?> :
							<?php echo $purchaseItemInfo[$i][11]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][9]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][17]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][21]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][22]; ?></td>
							<td><?php echo $purchaseItemInfo[$i][20]; ?></td>
							<td ><?php echo $purchaseItemInfo[$i][13]; ?></td>
				        </tr>
		<?php
		            }
		        }
		?>		
		                

					   </table>
					   <br><br>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <td>
                            <?php 
                               if(!empty($purchaseInfo[0][31]) && $purchaseInfo[0][31]=='Recievings'){ 

                                 	echo "Purchsae Amount : ".$purchaseInfo[0][6]; 
                               }elseif(!empty($purchaseInfo[0][31]) && $purchaseInfo[0][31]=='Return'){ 

                                 	echo "Return Amount : ".$purchaseInfo[0][11]; 
                               }else{
                                      
                                    echo "Purchsae Amount : ".$purchaseInfo[0][6]; 
                               }
                            ?>
				                 
				            </td>
				            <td>SGST : <?php echo $purchaseInfo[0][9]; ?></td>
				            <td>CGST : <?php echo $purchaseInfo[0][8]; ?></td>
				            <td>TOT.GST : <?php echo $purchaseInfo[0][7]; ?></td>
				        </tr>
				        <tr>
				            <!-- <td>Frieght : <?php echo $purchaseInfo[0][10]; ?></td> -->
				            <td>Return : <?php echo $purchaseInfo[0][11]; ?></td>
				            <td>Bill Total : <?php echo $purchaseInfo[0][12]; ?></td>
				            <td >Discount : 
				            <?php  if(!empty($purchaseInfo[0][13]) && ($purchaseInfo[0][13]=='CASH')){
                                    echo $purchaseInfo[0][13]." ".$purchaseInfo[0][15]; 
				            }elseif (!empty($purchaseInfo[0][13]) && ($purchaseInfo[0][13]=='%')) {
				            	    echo "(".$purchaseInfo[0][14]." ".$purchaseInfo[0][13].")"." ".$purchaseInfo[0][15];
				            }else{
                                     echo $purchaseInfo[0][13];//no discount
				            }
				            ?>
				            	
				            </td>
				            <td></td>
				        </tr>
				        <tr>
				        	<?php if($purchaseInfo[0][18] == "CHEQUE") { ?>
						
							<td >Checque No : <?php echo $purchaseInfo[0][19]; ?></td>
							
							<td >Checque Amount : <?php echo $purchaseInfo[0][20]; ?></td>
						
						
						<?php } ?>		
						<?php if($purchaseInfo[0][18] == "CREDIT CARD") { ?>
						
							<td >Card Amount : <?php echo $purchaseInfo[0][21]; ?></td>
							
						<?php } ?>	
						<?php if($purchaseInfo[0][18] == "UPI") { ?>
						
							<td >UPI Amount : <?php echo $purchaseInfo[0][50]; ?></td>
							
						<?php } ?>					
				        </tr>
				        <tr>
				            <td>Net Total : <?php echo $purchaseInfo[0][17]; ?></td>
				            <td>R/O : <?php echo $purchaseInfo[0][42]; ?></td>	
				            <td>Payment Type : <?php echo $purchaseInfo[0][18]; ?></td>
				            <td>Amount Paid : <?php echo $purchaseInfo[0][22]; ?></td>
				        </tr>
				        <tr>
				            <td>Balance : <?php echo $purchaseInfo[0][44]; ?>
				            	<!-- <?php echo $purchaseInfo[0][23]; ?> -->
				            		
				            	</td>
				            <td colspan="3">Remarks : <?php echo $purchaseInfo[0][26]; ?></td>
				        </tr>

					   </table>
					</div>
				</div>
				        <div align="center">
             	
             			<?php 

             			  if (empty($popup_path)) {?>

                             	<input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printpurchase()">
                        <?php
                            $issue_cheque_list_page=$this->input->post("issue_cheque_list_page");
                            if(!empty($issue_cheque_list_page) && $issue_cheque_list_page=='YES'){
                             
                               $path=base_url()."index.php/purchase/issue_cheque";

                            }else{

                               $path=base_url()."index.php/purchase/manage_purchase";

                            }


                                if (empty($from_path) ){  
             				
                        ?>
                                      <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack('<?php echo $path; ?>')">
                        <?php
             				    }elseif(!empty($from_path)){
             		    ?>
             				          <input type="button" name="but" value="Close" class="btn btn-danger DONTPrint" onclick="closeTab()">    
             			
             		    <?php
             		            }
             			  }

             		    ?>
                             



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
	$bill_no=$this->input->post("bill_no");
	$pono=$this->input->post("pono");
	$payment_type=$this->input->post("payment_type");
    $current_page=$this->input->post("current_page");

	if($supplier=='' && $bill_no=='' && $pono=='' && $payment_type==''){
      
        if($from_date==$to_day && $end_date==$to_day){
      
          $from_date='';
	      $end_date='';

        } 

	}
?>
   <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
   <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
   <input type="hidden" name="supplier" id="supplier" value="<?php echo $supplier; ?>">
   <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no; ?>">
   <input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>">
   <input type="hidden" name="payment_type" id="payment_type" value="<?php echo $payment_type; ?>">
   <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
<!-- hidden fields -->		        
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">
	
function goBack(path) {
      	
    document.print_purchase.action=path;
    document.print_purchase.submit();

 }

function closeTab(){

	window.top.close();

 }

function printpurchase() {
      	
    window.print();

}

</script>