<?php
$batchInfo=$this->session->userdata('batchidInfo');

?> 
<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .font_th{

      font-size: 15px;
   }    
</style>

<form name="add_payment" id="add_payment" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
               Multiple Credits
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
          <div class="row">
            <div class="col-md-6">
          <div class="callout callout-info">Fields Marked With * Are Required</div>
      </div>
      </div>
            <div class="row">
          <div class="col-md-6">
        <div class="box box-info">

                
               <div class="box-body">
            <table width="100%" class="table table-striped">
           
       
            <tr>            
            
                  <td>Balance Amount : </td>

                  <td> 
                        <input type="text" name="balance_amt" value="<?php echo $amount; ?>" id="balance_amt" autocomplete="off" readonly="">
                  </td>
            </tr>
           

            <tr>            
            
                  <td>Payment Type : </td>

                  <td> 
                        
                    <select name="payment_mode" id="payment_mode" style="width: 150px;">
            
                      <option value="NEFT">NEFT</option>
                      <option value="CASH">CASH</option>
                      <option value="UPI">UPI</option>
                    

                    </select>


                  </td>

            </tr>


           
            <tr>
                  <td></td>
            <td>
                         <input id="save_bill" type="button" name="save" class="btn btn-success"  value="Add Payment"/>
           </td>
        </tr>

          </table>
                       
         </div><!--boxbody-->
        </div><!--boxinfo-->
      </div><!--col-md-12-->
      </div> <!--row-->

      
          </section><!-- /.content -->
    </div><!-- /.container -->
    
            
</form>    

<?php
    $this->load->view("footer"); 
?>

<script type="text/javascript">

 $(document).ready(function() {


  $("#card_amount_row").hide();

  
    $("#save_bill").click(function(){
        $('#payment_type_selected').val($("#payment_mode").val());
   //  alert("ssssssss");

        $('#credit_payments_list').attr('action',"<?php echo base_url(); ?>index.php/purchase/add_multiple_credits");
       
      // $('#add_payment').attr('action',"<?php echo base_url(); ?>index.php/purchase/add_MultipleCreditPayment");
        $('#credit_payments_list').submit();   
      //}

    });
  
    
 });


    
</script>
