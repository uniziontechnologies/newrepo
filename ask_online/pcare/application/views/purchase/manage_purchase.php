<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        padding-top: 15px;
        font-size: 14px;    
   }	
   .single{
            display:inline;
   }
</style>

<form name="manage_purchase" id="manage_purchase" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  PURCHASE LIST
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
                         Supplier : 
                </td>
                <td>
                         <select name="supplier" id="supplier">
                            <option value="" selected="selected">------select-----</option>

        <?php
                for($i=0; $i<count($suppliers); $i++) 
                    { 
        ?>
                           <option value="<?php echo $suppliers[$i][0]; ?>" <?php echo (!empty($supplier_selected) && ($supplier_selected==$suppliers[$i][0]) )?'selected':''; ?> ><?php echo $suppliers[$i][1]; ?></option>         
        <?php
                    }
        ?>                    

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

                        PO No : 
                </td>
                <td>
                          <input type="text" name="pono" id="pono" value="<?php echo !empty($pono)?$pono:'' ?>" autocomplete="off"> 
                         
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
                                <option value=" NEFT" <?php if (!empty($payment_type_selected) && $payment_type_selected ==" NEFT" ) {
                                echo "selected";
                            } ?> > NEFT</option>
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
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
		  </div> <!--row-->
        <div class="row">

           <div class="col-md-9" id="success">
              <?php echo !empty($message)?$message:''; ?>
             
           </div>

           <div class="col-md-3">
             
                    <?php echo $pagination_link; ?>
              
           </div>
        </div>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">
				          <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                          </div>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Bill Type</a></th>
                    <th class="font_th"><a href="#">Inv No</a></th>
                    <th class="font_th"><a href="#">Bill No</a></th>
                    <th class="font_th"><a href="#">PO No</a></th>
				            <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Entry Date</a></th>
				            <th class="font_th"><a href="#">Supplier</a></th>
                    <th class="font_th"><a href="#">Payment Type</a></th>
				            <th class="font_th"><a href="#">Net Total</a></th>
				            <th class="font_th"><a href="#">Card Amount</a></th>
                            <th class="font_th"><a href="#">UPI Amount</a></th>
                    <th class="font_th"><a href="#">Checque Amount</a></th>
                    <th class="font_th"><a href="#">Cash Amount</a></th>
                    <th class="font_th"><a href="#">Credit Paid</a></th>
                    <th class="font_th"><a href="#">Adjust Amount</a></th>

                    <th class="font_th"><a href="#">Balance</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				    
				        </tr>
		<?php        
                if(!empty($purchaseInfo)){	//var_dump($purchaseInfo);					
				          $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($purchaseInfo);$i++) {
		?>						
				        <tr>
				          <td><?php echo $j++;?></td>
                  <td><?php echo $purchaseInfo[$i][31];?></td>
					        <td><?php echo $purchaseInfo[$i][1];?></td>
							    <td><?php echo $purchaseInfo[$i][27];?></td>
							    <td><?php echo $purchaseInfo[$i][2];?></td>
							    <td><?php echo $purchaseInfo[$i][3];?></td>
                  <td><?php echo date("d-m-Y",strtotime($purchaseInfo[$i][28]));?></td>
                  <td><?php echo $purchaseInfo[$i][5];?></td>
                  <td><?php echo $purchaseInfo[$i][18];?></td>
                  <td><?php echo $purchaseInfo[$i][17];?></td>
                  <td><?php echo $purchaseInfo[$i][21];?></td>
                   <td><?php echo $purchaseInfo[$i][50];?></td>
                  <td><?php echo $purchaseInfo[$i][20];?></td>
                  <td><?php echo $purchaseInfo[$i][22];?></td>
                  <td><?php echo $purchaseInfo[$i][49];?></td>

                  <td><?php echo $purchaseInfo[$i][47];?></td>
                  <td><?php echo $purchaseInfo[$i][44];?></td>
							
						    <td>

            

                <button class="btn btn-primary btn-xs" data-title="Print" data-toggle="modal" data-target="#print" onclick="printPurrchase('<?php echo $purchaseInfo[$i][1]; ?>')"><span class="glyphicon glyphicon-print"></span></button>
<?php if($purchaseInfo[$i][31] !="Return")
        {
?>
                <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updatePurchase('<?php echo $purchaseInfo[$i][1]; ?>')" title="Go To Purchase"><span class="glyphicon glyphicon-pencil"></span></button>
<?php
        }
?>
        
<?php 
if( $_SESSION['user_type'] == "8"){
 ?> 

                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deletePurrchase('<?php echo $purchaseInfo[$i][1]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>

                     
						    </td>
				        </tr>
		<?php }
		            }
		        }
		?>			   
					   </table>
                <input type="hidden" name="purchase_id" id="purchase_id">
                <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">

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

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#manage_purchase").attr("action","<?php echo base_url(); ?>index.php/purchase/manage_purchase");
                 $("#manage_purchase").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_purchase").attr("action","<?php echo base_url(); ?>index.php/purchase/manage_purchase");
                 $("#manage_purchase").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_purchase").attr("action","<?php echo base_url(); ?>index.php/purchase/manage_purchase");
                 $("#manage_purchase").submit();
    });

  });

function searchForm(){
      
      $("#current_page").val('');
      document.manage_purchase.action="<?php echo base_url(); ?>index.php/purchase/manage_purchase";
      document.manage_purchase.submit();

}

function clearForm(){

      window.location = "<?php echo site_url('purchase/manage_purchase'); ?>";
      return false;

}

function printPurrchase(id) {
 
        $('#purchase_id').val(id);
        
        document.manage_purchase.action='<?php echo base_url(); ?>index.php/purchase/print_purchase';
        document.manage_purchase.submit();
        
}

function updatePurchase(id){

        $('#purchase_id').val(id);
        
        document.manage_purchase.action='<?php echo base_url(); ?>index.php/purchase/update_purchase';
        document.manage_purchase.submit();

}

function deletePurrchase(id) {

        $('#purchase_id').val(id);
        
        document.manage_purchase.action='<?php echo base_url(); ?>index.php/purchase/purchase_item_delete';
        document.manage_purchase.submit();
       
     }

</script>