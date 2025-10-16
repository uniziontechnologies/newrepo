<?php
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        margin-left: 14px;
        font-size: 14px;   
   }	
   .single{
            display:inline;
   }
</style>

<form name="credit_payment" id="credit_payment" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  CREDIT BILL LIST
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $error_message = $this->session->flashdata('error_message'); 
                        if(!empty($error_message)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $error_message; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
            
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>
                         From Date : 
                </td>
                <td>
                          <input type="text" name="from_date" id="from_date" value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true">             
                </td>
                <td>
                         End Date : 
                </td>
                <td>
                          <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true">       
                </td>
                <td>

                        Cust Type : 
                </td>
                <td>
                        <select name="customer_type" id="customer_type" onkeypress="nextField(event.keyCode,Search);">
                            <option value="" selected="selected">----------</option>
                            <option value="DIRECT" <?php echo (!empty($cust_type_select) && $cust_type_select=='DIRECT')?'selected':'' ?> >DIRECT</option>
                            <option value="OP" <?php echo (!empty($cust_type_select) && $cust_type_select=='OP')?'selected':'' ?> >OP</option>
                            <option value="IP" <?php echo (!empty($cust_type_select) && $cust_type_select=='IP')?'selected':'' ?> >IP</option>
                        </select>
                         
                </td>

            </tr>
            <tr>

                <td>

                        Bill No : 
                </td>
                <td>
                          <input type="text" name="bill_no" id="bill_no" value="<?php echo !empty($bill_no)?$bill_no:'' ?>" autocomplete="off"> 
                         
                </td>
                <td>

                        Payment Type : 
                </td>
                <td>
                          <select name="payment_type" id="payment_type" onkeypress="nextField(event.keyCode,Search);">
                              <option value="" selected="selected">----------------</option>
                              <option value="CASH" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CASH') )?'selected':''; ?> >CASH</option>
                              <option value="CHEQUE" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CHEQUE') )?'selected':''; ?> >CHEQUE</option>
                              <option value="CREDIT CARD" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CREDIT CARD') )?'selected':''; ?> >CREDIT CARD</option>
                              <option value="BRANCH" <?php echo (!empty($payment_type_select) && ($payment_type_select=='BRANCH') )?'selected':''; ?> >BRANCH</option>
                              <option value="UPI" <?php echo (!empty($payment_type_select) && ($payment_type_select=='UPI') )?'selected':''; ?> >UPI</option>
                          </select> 
                         
                </td>
                
            </tr>
            <tr>
                           <td colspan="6" align="center">
                              <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>
                              <button type="button" class="btn btn-danger" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                              </button>
                           </td>
            </tr>
                   
				  </table>
                     <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                     </div>
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
        <div id="success"><?php echo !empty($message)?$message:''; ?></div>
		  </div> <!--row-->

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">
				          <div id="pagination" align="right">
                              <!-- <?php //echo $this->pagination->create_links(); ?> -->
                          </div>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Bill No</a></th>
                     <th class="font_th"><a href="#">Cust Type</a></th>
                     <th class="font_th"><a href="#">OP/IP No</a></th>

                    <th class="font_th"><a href="#">Customer Name</a></th>
				            <th class="font_th"><a href="#">Payment Type</a></th>
                    <th class="font_th"><a href="#">Net Total</a></th>
                    <th class="font_th"><a href="#">Card Amount</a></th>
                    <th class="font_th"><a href="#">UPI Amount</a></th>
                    <th class="font_th"><a href="#">Checque Amount</a></th>
				            <th class="font_th"><a href="#">Cash Amount</a></th>
                    <th class="font_th"><a href="#">Balance</a></th>
                    <th class="font_th"><a href="#">Action</a></th>
				    
				        </tr>
		<?php        
                if(!empty($billInfo)){						
				          $j= 1;
				    for($i=0;$i<count($billInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++; ?></td>
                        
                    <td><?php echo $billInfo[$i][5];?></td>
                    <td><?php echo $billInfo[$i][1];?></td>

                     <td><?php echo $billInfo[$i][2];?></td>
                        <?php if($billInfo[$i][2] == "OP"){?>
                    
                            <td><?php echo $billInfo[$i][43]."/".$billInfo[$i][34];?></td>
                    <?php }else if($billInfo[$i][2] == "IP"){?>
                    
                           <td><?php echo $billInfo[$i][33];?></td>
                    <?php }else{?>
                            <td></td>
                    <?php } ?>

                    <td><?php echo $billInfo[$i][4];?></td>
                    <td><?php echo $billInfo[$i][15];?></td>
                    <td><?php echo $billInfo[$i][14];?></td>
                    <td><?php echo $billInfo[$i][18];?></td>
                    <td><?php echo $billInfo[$i][61];?></td>
                    <td><?php echo $billInfo[$i][17];?></td>
                    <td><?php echo $billInfo[$i][31];?></td>
                    <td><?php echo ($billInfo[$i][32]);?></td>
        
						      <td>
<?php
       if($billInfo[$i][56] == 2){
?>
                <span class="text-red" ><b>BILL PREPARED</b></span></td>
<?php  }else{
?>
                <a href="#"   class="add_payment" id="<?php echo $billInfo[$i][1];?>">Add payment</a> 
<?php
       }
?>
						      </td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
                <input type="hidden" name="bill_id" id="bill_id">
                <input type="hidden" name="credit_amount" id="credit_amount">
                <input type="hidden" name="payment_type_selected" id="payment_type_selected">
                <input type="hidden" name="card_amt" id="card_amt">
                <input type="hidden" name="upi_amt" id="upi_amt">

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

<script type="text/javascript">
$(function () {
   
    //Date range picker
    $('#from_date').datepicker();
    $('#end_date').datepicker();
     
});

$(document).ready(function(){

    $(".add_payment").bind('click', function() {
    
      var id=$(this).attr("id");
      
      tb_show('Add Credit Payment',"<?php echo base_url(); ?>index.php/invoice/credit_payment_form/"+id);
    });

});

function tb_remove(){
  
  document.credit_payment.action='<?php echo base_url(); ?>index.php/invoice/credit_payment';
  document.credit_payment.submit();
}

function searchForm(){
      
      document.credit_payment.action="<?php echo base_url(); ?>index.php/invoice/credit_payment";
      document.credit_payment.submit();

}

function clearForm(){

      window.location = "<?php echo site_url('invoice/credit_payment'); ?>";
      return false;

}

</script>