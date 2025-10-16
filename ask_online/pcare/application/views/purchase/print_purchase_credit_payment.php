<!-- print for A4 page -->
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

<form name="print_credit_payment" id="print_credit_payment" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
    <center>   
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="80px" style="margin-top: -12px;"></img>   
          <h2 style="margin-top: 1px;"><b><?php echo strtoupper($hospitalInfo[0][1]); ?></b></h2>
          <h4 style="margin-top: -7px"><b><?php echo strtoupper($hospitalInfo[0][2])." , ".strtoupper($hospitalInfo[0][3]); ?></b></h4>
          <h4 style="margin-top: -7px"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h4>
          <h4 style="margin-top: -7px"><b><?php echo "DL NO : ".$pharmacyInfo[0][3]; ?> , <?php echo "GST NO : ".$pharmacyInfo[0][2]; ?></b></h4>
    </center>
      
          <!-- Main content -->
          <section class="content">
                   <h2 align="center" style="margin-top: -9px;"><b><u>Purchase Credit Payment</u></b></h2>
                   <table width="100%">
                    <tr style="height: 18px;">
						<td>
			 				 INV NO : <?php echo $billInfo[0][1];?>
						</td>
		
						
						<td align="right">
			 			  Date : <?php echo date("d-m-Y",strtotime($billInfo[0][4]));?>
						</td>
						
		
				    </tr>
					<tr style="height: 18px;">
						
						<td>
		 						NAME : <?php echo $billInfo[0][5]; ?>
						</td>
					</tr>
                    </table>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">
				
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">SL</a></th>
				            <th class="font_th"><a href="#">TOWARDS BILL</a></th>
				            <th class="font_th"><a href="#">PAYMENT TYPE</a></th>

				            <th class="font_th"><a href="#">CASH AMOUNT</a></th>
				            <th class="font_th"><a href="#">NEFT AMOUNT</a></th>
				            <th class="font_th"><a href="#">UPI AMOUNT</a></th>

				            <th class="font_th"><a href="#">ADJUST AMOUNT</a></th>

	               	<?php if($billInfo[0][11] == 'NEFT'){ ?>

				            <th class="font_th"><a href="#">Narration</a></th>

                    <?php }?>



				        </tr>
		<?php        
                if(!empty($billInfo)){	//var_dump($billInfo);					
				    $j=1;
				    for($i=0;$i<count($billInfo);$i++) {
		?>						
				        <tr>
				            <td ><?php echo $j++; ?></td>
							<td ><?php echo $billInfo[$i][2]; ?></td>
							<td ><?php echo $billInfo[$i][11]; ?></td>

							<td ><?php echo $billInfo[$i][3]; ?></td>
							<td ><?php echo $billInfo[$i][12]; ?></td>
							<td ><?php echo $billInfo[$i][15]; ?></td>
							<td ><?php echo $billInfo[$i][13]; ?></td>


		<?php if($billInfo[$i][11] == 'NEFT'){ ?>

                    <td><?php echo $billInfo[$i][14];?></td>
<?php }?>

				        </tr>
		<?php
		            }
		        }
		?>		 
		                <tr>
		                     <td colspan="3" align="right">TOTAL</td>
                             <td><?php echo $billInfo[0][3];?></td>
                             <td><?php echo $billInfo[0][12];?></td>
                             <td><?php echo $billInfo[0][15];?></td>

                        </tr>
                       </table>
					</div>
				</div>
				        <div align="center">
             	
                             <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printCreditPayment()">
                             <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack()">

                        </div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
   <?php
       $from_date=$this->input->post("from_date");
	   $end_date=$this->input->post("end_date");
	   $inv_no=$this->input->post("inv_no");
	   $bill_status=$this->input->post("bill_status");
	   $current_page=$this->input->post("current_page");
?>
    <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
    <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
    <input type="hidden" name="inv_no" id="inv_no" value="<?php echo $inv_no; ?>">
    <input type="hidden" name="bill_status" id="bill_status" value="<?php echo $bill_status; ?>">

    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">

<!-- hidden fields -->        
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">
	
function goBack() {
      	
   document.print_credit_payment.action="<?php echo base_url(); ?>index.php/purchase/manage_purchase_credit_payment";
   document.print_credit_payment.submit();

}

function printCreditPayment() {
      	
    window.print();

}

</script>