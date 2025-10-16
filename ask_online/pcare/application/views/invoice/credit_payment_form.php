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
                 Credit Payment
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
            
                    <td>Bill No : <?php echo $bill_no; ?></td>
            
                    <td>
                        BillDate : <?php echo $billInfo[0][5]; ?>
                    </td>
            </tr>
            <tr>
                  <td>Bill Amount : </td>

                  <td> 
                        <input type="text" name="bill_total" value="<?php echo $billInfo[0][14]; ?>" id="bill_total" autocomplete="off" readonly="1">
                  </td>
            </tr>
            <tr>            
            
                  <td>Balance Amount : </td>

                  <td> 
                        <input type="text" name="balance_amt" value="<?php echo $billInfo[0][32]; ?>" id="balance_amt" autocomplete="off" readonly="1">
                  </td>
            </tr>

            <tr>            
            
                  <td>Payment Type : </td>

                  <td> 
                        
                    <select name="payment_mode" id="payment_mode" onchange="show_fields();" style="width: 150px;">
            
                      <option value="CASH">CASH</option>
                      <option value="CREDIT CARD">CREDIT CARD</option>
                       <option value="UPI">UPI</option>

                    </select>


                  </td>

            </tr>


            <tr>
                  <td>Cash Amount <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="new_amount" value="" id="new_amount" onkeypress="nextField(event.keyCode,save)" autocomplete="off">
                  </td>
             
            </tr>

            <tr id="card_amount_row">
          
              <td>Card Amount <span id='requiredfield'>*</span> : </td>

              <td><input name="card_amount" id="card_amount" value="" autocomplete="off"/></td>
          
            </tr>
            <tr id="upi_amount_row">
          
              <td>UPI Amount <span id='requiredfield'>*</span> : </td>

              <td><input name="upi_amount" id="upi_amount" value="" autocomplete="off"/></td>
          
            </tr>
            
            <tr>
                  <td></td>
            <td>
                         <input id="save_bill" type="button" name="save" class="btn btn-success"  value="Add Payment"/>
           </td>
        </tr>

          </table>
                        <input type="hidden" name="billid" id="billid" value="<?php echo $bill_no;?>">
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
   $("#upi_amount_row").hide();

    //$("#button1").addClass('big_button');
  
  
  
    $("#save_bill").click(function(){
   
       amount_paid = Number($("#new_amount").val());

       total_paid_card  = Number($("#card_amount").val()) + amount_paid;
        total_paid_upi  = Number($("#upi_amount").val()) + amount_paid;

       if( ( ($("#payment_mode").val()=='CASH') &&( $("#new_amount").val()=='' || $("#new_amount").val()=='0' ) || !isNumeric($("#new_amount").val()))){
        showDialog('Error','Please Enter Valid Amount!.','error',2);
        $("#new_amount").focus();
        return false;
      }
       else if ( ($("#payment_mode").val()=='CASH' && ( amount_paid >$("#balance_amt").val()) )) {
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      }
      else if ($("#payment_mode").val()=='') {
        showDialog('Error','Please Select Payment Mode.','error',2);
        $("#payment_mode").focus();
        return false;        
      }
      else if ( ($("#payment_mode").val()=='CREDIT CARD' && $("#card_amount").val()=='' || $("#card_amount").val()=='0') || !isNumeric($("#card_amount").val())  ) {
        showDialog('Error','Please Enter Valid Card Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      } 
      else if ( ($("#payment_mode").val()=='CREDIT CARD' && (total_paid_card > $("#balance_amt").val() ) ) ){
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      }else if ( ($("#payment_mode").val()=='UPI' && $("#upi_amount").val()=='' || $("#upi_amount").val()=='0') || !isNumeric($("#upi_amount").val())  ) {
        showDialog('Error','Please Enter Valid UPI Amount.','error',2);
        $("#upi_amount").focus();
        return false;        
      } 
      else if ( ($("#payment_mode").val()=='UPI' && (total_paid_upi > $("#balance_amt").val() ) ) ){
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#upi_amount").focus();
        return false;        
      }
      else{    
      var upi=$("#upi_amount").val();
      // alert(upi);   
        $('#credit_amount').val($("#new_amount").val());
        $('#bill_id').val($("#billid").val());
        $('#payment_type_selected').val($("#payment_mode").val());
        $('#card_amt').val($("#card_amount").val());
        $('#upi_amt').val($("#upi_amount").val());
        $('#credit_payment').attr('action',"<?php echo base_url(); ?>index.php/invoice/addCreditPayment");
        $('#credit_payment').submit();   
      }

    });
  
    
 });

 function show_fields() {
  
  var payment_mode = $("#payment_mode").val();
  
  $("#card_amount").val('');
  $("#new_amount").val('');
  $("#upi_amount").val('');

  if (payment_mode=="CREDIT CARD") {
        $("#card_amount_row").show();
        $("#upi_amount_row").hide();
        $("#upi_amount").val('');
    }else if (payment_mode=="UPI") {
        $("#upi_amount_row").show();
        $("#card_amount_row").hide();
        $("#card_amount").val('');
    }else{
        $("#card_amount_row").hide();
        $("#upi_amount_row").hide();
        $("#card_amount").val('');
        $("#upi_amount").val('');
    }

  // if (payment_mode=="CREDIT CARD") {
  //   $("#card_amount_row").show();
  // }
  // else{
  //   $("#card_amount_row").hide();
  // }

}
    
</script>
