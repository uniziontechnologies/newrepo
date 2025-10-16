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

<form name="manage_credit_payment" id="manage_credit_payment" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  CREDIT PAYMENT LIST
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $delete_msg = $this->session->flashdata('delete_msg'); 
                        if(!empty($delete_msg)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $delete_msg; ?></div>
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

                        Bill No : 
                </td>
                <td>
                          <input type="text" name="bill_no" id="bill_no" value="<?php echo !empty($bill_no)?$bill_no:'' ?>" autocomplete="off"> 
                         
                </td>

                <td>
                        Payment Type : 
                </td>
                <td>
                        <select name="payment_type" id="payment_type">
                            <option value="">--------</option>
                            <option value="CASH" <?php echo (!empty($payment_type) && ($payment_type=="CASH") )?'selected':''; ?> >CASH</option>
                            <option value="CREDIT CARD" <?php echo (!empty($payment_type) && ($payment_type=="CREDIT CARD") )?'selected':''; ?> >CREDIT CARD</option>
                            <option value="UPI" <?php echo (!empty($payment_type) && ($payment_type=="UPI") )?'selected':''; ?> >UPI</option>
                        </select>
                </td>

                <td>
                        Bill Status : 
                </td>
                <td>
                        <select name="bill_status" id="bill_status" onkeypress="nextField(event.keyCode,Search);">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="CANCELLED" <?php echo (!empty($bill_status) && ($bill_status==1) )?'selected':''; ?> >CANCELLED</option>
                        </select>
                </td>
                
            </tr>
            <tr>
                           <td colspan="9" align="center">
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
            <div class="col-md-3 DONTPrint">
                 <?php echo $pagination_link; ?>
            </div>
      </div>

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
                    <th class="font_th"><a href="#">Customer Name</a></th>
                    <th class="font_th"><a href="#">Payment Mode</a></th>
                    <th class="font_th"><a href="#">Amount Paid</a></th>
                    <th class="font_th"><a href="#">Card Amount</a></th>
                     <th class="font_th"><a href="#">UPI Amount</a></th>

<?php   if(!empty($bill_status) && $bill_status == 1){?>
                    <th class="font_th"><a href="#">Cancellation Details</a></th>
                    <th class="font_th"><a href="#">Cancellation Date</a></th>
<?php   }?>

<?php   if(empty($bill_status)){?>

                    <th class="font_th"><a href="#">Action</a></th>
<?php }?>   

                </tr>
    <?php        
                if(!empty($billInfo)){            
                  $j= !empty($next_page)?$next_page+1:1;
            for($i=0;$i<count($billInfo);$i++) {
    ?>            
                <tr>
                    <td><?php echo $j++; ?></td>
                        
                    <td><?php echo $billInfo[$i][4];?></td>
                    <td><?php echo $billInfo[$i][2];?></td>
                    <td><?php echo $billInfo[$i][5];?></td>
                    <td><?php echo $billInfo[$i][12];?></td>
                    <td><?php echo $billInfo[$i][3];?></td>
                    <td><?php echo $billInfo[$i][13];?></td>
                    <td><?php echo $billInfo[$i][14];?></td>

<?php   if($billInfo[$i][6] == 1){?>
              
              
                        <td><?php echo $billInfo[$i][7];?></td>
                        <td><?php echo $billInfo[$i][8];?></td>
<?php   }?> 

<?php   if(empty($bill_status)){?> 
                  <td>
                         <button class="btn btn-primary btn-xs" data-title="Print" data-toggle="modal" data-target="#print" onclick="printCreditPayment('<?php echo $billInfo[$i][1]; ?>')"><span class="glyphicon glyphicon-print"></span></button>
               
                         <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteCreditPayment('<?php echo $billInfo[$i][1]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                  </td>
<?php   }?>
                </tr>
    <?php
                }
            }
    ?>         
             </table>
                       <input type="hidden" name="credit_id" id="credit_id" >
                       <input type="hidden" name="cancellation_details">
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



$(document).ready(function() {


    $(".next_page").bind('click', function() {

          var current_page= $("#current_page").val();
          current_page++;
          $("#current_page").val(current_page);
          $("#manage_credit_payment").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_credit_payment");
          $("#manage_credit_payment").submit();
    });

    $(".prev_page").bind('click', function() {
              
          var current_page= $("#current_page").val();
          current_page--;
          $("#current_page").val(current_page);
          $("#manage_credit_payment").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_credit_payment");
          $("#manage_credit_payment").submit();
    });

    $(".change_page").bind('click', function() {
              
          var current_page= $(this).attr("id");
          $("#current_page").val(current_page);
          $("#manage_credit_payment").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_credit_payment");
          $("#manage_credit_payment").submit();
    });


});


function searchForm(){
      
    $("#current_page").val('');
    document.manage_credit_payment.action="<?php echo base_url(); ?>index.php/invoice/manage_credit_payment";
    document.manage_credit_payment.submit();

}

function clearForm(){

    window.location = "<?php echo site_url('invoice/manage_credit_payment'); ?>";
    return false;

}

function printCreditPayment(id){
   
   $('#credit_id').val(id);
   
   document.manage_credit_payment.action='<?php echo base_url(); ?>index.php/invoice/print_credit_payment';
   document.manage_credit_payment.submit();

}

function deleteCreditPayment(id){

   var v=confirm("Do You Want To Delete!");
    if(v) {
    
      var details=prompt("Please Enter Cancellation Details:","");
        
        if(details!= null){
          
          document.manage_credit_payment.cancellation_details.value=details;
          document.manage_credit_payment.action='<?php echo base_url(); ?>index.php/invoice/delete_credit_payment/'+id;
          document.manage_credit_payment.submit();
          return true;
          
        }else{
          return false;
        }
        
      
      
    }else return false;

}

</script>