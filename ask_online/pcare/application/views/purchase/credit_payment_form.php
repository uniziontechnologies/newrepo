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
                   
                     <td>Inv No : <?php echo $inv_no; ?></td>

                    <td>Bill No : <?php echo $billInfo[0][27]; ?></td>
            
                    <td>
                        BillDate : <?php echo $billInfo[0][3]; ?>
                    </td>
            </tr>
            <tr>
                  <td>Bill Amount : </td>

                  <td> 
                        <input type="text" name="bill_total" value="<?php echo $billInfo[0][17]; ?>" id="bill_total" autocomplete="off" readonly="1">
                  </td>
            </tr>
            <tr>            
            
                  <td>Balance: </td>

                  <td> 
                        <input  class="common" type="text" name="balance" value="<?php echo $billInfo[0][44]; ?>" id="balance" autocomplete="off" readonly="1">
                  </td>
            </tr>

            <!-- <tr>            
            
                  <td> Adjust Amount: </td>

                  <td> 
                        <input  class="common" type="text" name="adjust_amt" value="" id="adjust_amt" autocomplete="off"  >
                  </td>
            </tr> -->

              <tr>            
            
                  <td> Balance Amount: </td>

                  <td> 
                        <input  class="common" type="text" name="balance_amt" value="<?php echo $billInfo[0][44]; ?>" id="balance_amt" autocomplete="off" readonly="1">
                  </td>
            </tr>



            <tr>            
            
                  <td>Payment Type : </td>

                  <td> 


                    <select name="type" id="type" style="width: 150px;">
                          <option value="NEFT">NEFT</option>
                        <option value="CASH">CASH</option>
                        <option value="UPI">UPI</option>
                      
                    </select>
                        
                  <!--   <select name="payment_mode" id="payment_mode" onchange="show_fields();" style="width: 150px;">
            
                      <option value="CASH">CASH</option>
                      <option value="NEFT CREDIT">NEFT CREDIT</option>

                    </select>
 -->

                  </td>

            </tr>


            <tr id="cash_amt_row">

                  <td>Cash Amount <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="new_amount" value="" id="new_amount" onkeypress="nextField(event.keyCode,save)" autocomplete="off">
                  </td>
             
            </tr>
             <tr id="upi_amt_row">
                  <td>UPI Amount <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="upi_amt" value="" id="upi_amt" onkeypress="nextField(event.keyCode,save)" autocomplete="off">
                  </td>
             
            </tr>




               <tr id="neft_amt_row">
                  <td>NEFT Amount <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="neft_amt" value="" id="neft_amt" onkeypress="nextField(event.keyCode,save)" autocomplete="off">
                  </td>
             
            </tr>
            <tr id="narration_row">

          
              <td>Narationn <span id='requiredfield'>*</span> : </td>

              <td><textarea  name="remarks" id="remarks" value="" autocomplete="off"></textarea></td>
          
            </tr>
            
            <tr>
                  <td></td>
            <td>
                         <input id="save_bill" type="button" name="save" class="btn btn-success"  value="Add Payment"/>
           </td>
        </tr>

          </table>
                        <input type="hidden" name="invno" id="invno" value="<?php echo $inv_no;?>">
                      
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
  
    $("#cash_amt_row").hide();
    $("#neft_amt_row").show();
    $("#narration_row").show();
    $("#upi_amt_row").hide();



 // $("#card_amount_row").hide();

    //$("#button1").addClass('big_button');
  
  
  
    $("#save_bill").click(function(){

      $payment_type=$("#type").val();

      if($payment_type == 'CASH'){

       amount_paid = Number($("#new_amount").val());

      }else{
       amount_paid = Number($("#neft_amt").val());

      }
   total_paid_upi  = Number($("#upi_amt").val()) + amount_paid;
     //  amount_paid = Number($("#new_amount").val());

       total_paid  = Number($("#card_amount").val()) + amount_paid;

       if( ( ($("#type").val()=='CASH') &&( $("#new_amount").val()=='' || $("#new_amount").val()=='0' ) || !isNumeric($("#new_amount").val()))){
        showDialog('Error','Please Enter Valid Amount!.','error',2);
        $("#new_amount").focus();
        return false;
      }
       else if ( ($("#type").val()=='CASH' && ( amount_paid >$("#balance_amt").val()) )) {
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      }
    
      else if ( ($("#type").val()=='CREDIT CARD' && $("#card_amount").val()=='' || $("#card_amount").val()=='0') || !isNumeric($("#card_amount").val())  ) {
        showDialog('Error','Please Enter Valid Card Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      }  else if ( ($("#type").val()=='UPI' && $("#upi_amt").val()=='' || $("#upi_amt").val()=='0') || !isNumeric($("#upi_amount").val())  ) {
        showDialog('Error','Please Enter Valid UPI Amount.','error',2);
        $("#upi_amt").focus();
        return false;        
      } else if ( ($("#payment_mode").val()=='UPI' && (total_paid_upi > $("#balance_amt").val() ) ) ){
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#upi_amt").focus();
        return false;        
      } 
      else if (amount_paid > $("#balance_amt").val() ) {
        showDialog('Error','Please Check Balance Amount.','error',2);
        $("#card_amount").focus();
        return false;        
      }
      else{         
        $('#credit_amount').val($("#new_amount").val());
        $('#neft_amount').val($("#neft_amt").val());
        $('#upi_amount').val($("#upi_amt").val());

        $('#adjust_amount').val($("#adj_amt").val());
        $('#purchase_id').val($("#invno").val());
    //alert(   $('#purchase_id').val());
        $('#payment_type_selected').val($("#type").val());
        $('#card_amt').val($("#card_amount").val());
        $('#add_payment').attr('action',"<?php echo base_url(); ?>index.php/purchase/addCreditPayment");
        $('#add_payment').submit();   
      }

    });
  
    
 });

//  function show_fields() {
  
//   var payment_mode = $("#payment_mode").val();
  
//   $("#card_amount").val('');
//   $("#new_amount").val('');

//   if (payment_mode=="CREDIT CARD") {
//     $("#card_amount_row").show();
//   }
//   else{
//     $("#card_amount_row").hide();
//   }

// }





$(function(){
    
  $('#type').change(function(){
  var values = $('#type :selected').val();
 // alert("aaaaaaaaaa");
  $("#new_amount").val('');
  $("#neft_amt").val('');
  $("#remarks").val('');


  // $("#card_amount").val('');
  // $("#new_amount").val('');
  $("#upi_amt").val('');

  if (values=="NEFT") {
        $("#neft_amt_row").show();
        $("#upi_amt_row").hide();
        $("#upi_amt").val('');
    }else if (values=="UPI") {
        $("#upi_amt_row").show();
        $("#cash_amt_row").show();
        $("#narration_row").hide();
        $("#neft_amt_row").hide();
        $("#remarks").val('');
        $("#neft_amt").val('');
    }else{
         $("#cash_amt_row").show();
        $("#narration_row").hide();
        $("#upi_amt_row").hide();
        $("#neft_amt_row").hide();
        $("#remarks").val('');
        $("#upi_amt").val('');
        $("#neft_amt").val('');
    }
  

  // if (values=="NEFT") {//alert($("#neft_amount").val());
  //   $("#card_amount_row").show();
  //   $("#cash_amt_row").hide();
  //   $("#neft_amt_row").show();
    
  



  // }
  // else{
  //   $("#card_amount_row").hide();
  //   $("#cash_amt_row").show();
  //   $("#neft_amt_row").hide();
  //   // $("#neft_amount").val('');
  //   // $("#remarks").val('');


  // }

                   
        });



    
});
// function balnce(){

//    balance= $("#balance").val();
//    adj_amt= $("#adjust_amt").val();

//     $("#balance_amt").val(balance-adj_amt);

// }
    
    $('.common').change(function () {
    $('#balance_amt').val(parseFloat("0"+$('#balance').val()) - parseFloat("0"+$('#adjust_amt').val()));
});
</script>
