<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=credit_payment-report.xls');
  }

?>
<style type="text/css">
    
   .font_th{

        font-size: 15px;
   }
   .margin_10{
    margin-top: 10px;
   }
   #success{
      margin-left: 20px;
      font-size: 14px;   
   }
   #print_details{
    display: none;
   }
   input.btn.btn-info.DONTPrint{
    margin-top: 30px;
    width: 55px !important;
   }
  select, input {
      width: 120px;
  }
   @media print{
       #print_details{
        display: block;
        margin-left: 20px;
       }    
   }

</style>

<form name="credit_payment" id="credit_payment" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  INVOICE CREDIT PAYMENT REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportCreditPayment()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
            </div>
           
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
            <div class="box box-info DONTPrint">
            
               <div class="box-body">
                  <table width="100%" class="table table-striped">
                
              <tr>
                <td>
                        From Date : 
                </td>
                <td>
                        <input type="text" name="from_date" id="from_date" value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true"> 
                        <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="5" value="<?php echo !empty($from_time)?$from_time:'' ?>"></span>
                </td>
                <td>
                        End Date : 
                </td>
                <td>
                        <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true">
                        <span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="5" value="<?php echo !empty($to_time)?$to_time:'' ?>"></span>      
                </td>
                <td>
                         Bill No : 
                </td>
                <td>
                        <input type="text" name="bill_no" id="bill_no" value="<?php echo !empty($bill_no)?$bill_no:'' ?>" autocomplete="off">
                         
                </td>

                <td>

                        Bill Status : 
                </td>
                <td>
                        <select name="bill_status" id="bill_status" onkeypress="nextField(event.keyCode,Search);">
                            <option value="0" <?php if (!empty($bill_status) && $bill_status =="0" ) {
                                echo "selected";
                            } ?> >ACTIVE</option>
                            <option value="1" <?php if (!empty($bill_status) && $bill_status =="1" ) {
                                echo "selected";
                            } ?>>CANCELLED</option>

                        </select>
                         
                </td>
            </tr>
            <tr>

                <td>

                        Cust Type : 
                </td>
                <td>
                        <select name="customer_type" id="customer_type" onkeypress="nextField(event.keyCode,Search);">
                            <option value="">----------</option>
                            <option value="DIRECT" <?php if (!empty($customer_type) && $customer_type =="DIRECT" ) {
                                echo "selected";
                            } ?> >DIRECT</option>
                            <option value="OP" <?php if (!empty($customer_type) && $customer_type =="OP" ) {
                                echo "selected";
                            } ?>>OP</option>
                            <option value="IP" <?php if (!empty($customer_type) && $customer_type =="IP" ) {
                                echo "selected";
                            } ?>>IP</option>
                        </select>
                         
                </td>

                <td>
                         Customer Id : 
                </td>
                <td>
                        <input type="text" name="customer_id" id="customer_id" value="<?php echo !empty($customer_id)?$customer_id:'' ?>" autocomplete="off" >
                         
                </td>

                <td>

                        User Type : 
                </td>
                <td>
                        <select name="user_type" id="user_type" onkeypress="nextField(event.keyCode,Search);">
                            <option value="">----------------</option>
                            <?php
                                if (!empty($userTypeInfo)) {

                                    for ($i=0; $i <count($userTypeInfo) ; $i++) { ?>
                                        <option value="<?php echo $userTypeInfo[$i][0] ?>" <?php if (!empty($user_type) && $user_type ==$userTypeInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $userTypeInfo[$i][1]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>

                <td>

                        User : 
                </td>
                <td>
                        <select name="user_id" id="user_id" onkeypress="nextField(event.keyCode,Search);">
                            <option value="">----------</option>
                            <?php
                                if (!empty($user_info)) {

                                    for ($i=0; $i <count($user_info) ; $i++) { ?>
                                        <option value="<?php echo $user_info[$i][0] ?>" <?php if (!empty($user_id) && $user_id ==$user_info[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $user_info[$i][2]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>



            </tr>
            <tr>

                           <td colspan="12" align="center">
                              <button type="button" class="btn btn-info margin_10" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>
                              <button type="button" class="btn btn-danger margin_10" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                              </button>
                           </td>
            </tr>
                   
                  </table>
               </div><!--boxbody-->
              </div><!--boxinfo-->
            </div><!--col-md-12-->
<?php
}
?>
                  <h3 id="print_details">

                       Invoice Credit Payment Report
              
                  </h3>
                  <div id="success"><?php  

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                            }
                            if (!empty($user_type_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User Type : ".$user_type_name;
                             }
                            if (!empty($user_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : ".$user_name;
                             }
                            // if (!empty($payment_type_selected)) {
                            //     echo "Payment Type : ".$payment_type_selected."&nbsp&nbsp&nbsp";
                            //  }
                            if (!empty($customer_type)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
                             }


                             ?>
                        
                  </div>
          </div> <!--row-->

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table width="100%" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th class="font_th"><a href=""><?php echo "Sl No";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Date";?></a></th>                 
                              <th class="font_th"><a href=""><?php echo"Bill No";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Customer Type";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Customer Name";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Payment Type";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Amount Paid";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Card Amount";?></a></th>
                              <th class="font_th"><a href=""><?php echo "UPI Amount";?></a></th>
                        <?php   if($bill_status == '1'){?>
                        
                              <th class="font_th"><a href=""><?php echo "Cancellation Details";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Cancellation Date";?></a></th>
                        <?php }?>
                              <th class="font_th"><a href=""><?php echo "Entered By";?></a></th>
                        
                            </tr>
                          </thead>
                          <tbody>
                          
                          <?php 
                          
                          $amount=0;
                          $card_amount=0;
                          $upi_amount=0;
                            if(!empty($billInfo) && empty($billInfo_extra)){            
                                
                              
                              for($i=0;$i<count($billInfo);$i++) {
                                ?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $billInfo[$i][0];?></td>
                                    <td><?php echo $billInfo[$i][4];?></td>
                                    <td><?php echo $billInfo[$i][2];?></td>
                                    <td><?php echo $billInfo[$i][11] ?></td>
                                    <td><?php echo $billInfo[$i][5];?></td>
                                    <td><?php echo $billInfo[$i][12];?></td>
                                    <td><?php echo $billInfo[$i][3];?></td>
                                    <td><?php echo $billInfo[$i][13];?></td>
                                    <td><?php echo $billInfo[$i][14];?></td>
                                  <?php   if($billInfo[$i][6] == 1){?>
                          
                          
                                    <td><?php echo $billInfo[$i][7];?></td>
                                    <td><?php echo $billInfo[$i][8];?></td>
                          <?php }?> 
                                    
                                  <td><?php echo $billInfo[$i][10];?></td>  
                                    
                                      
                              <?php
                              
                                $amount +=$billInfo[$i][3];
                                $card_amount +=$billInfo[$i][13];
                                 $upi_amount +=$billInfo[$i][14];
                              
                              ?>        
                          
                          
                        
                                      
                            
                                    
                                    
                                  </tr>
                        <?php     
                            }
                          }
                          else if (!empty($billInfo_extra)) {        
                                  
                                
                                for($i=0;$i<count($billInfo_extra);$i++) {
                           
                                  ?>
                                    <tr>
                                      <td><?php echo $billInfo_extra[$i][0][0];?></td>
                                      <td><?php echo $billInfo_extra[$i][0][4];?></td>
                                      <td><?php echo $billInfo_extra[$i][0][2];?></td>
                                      <td><?php echo $billInfo_extra[$i][0][11] ?></td>
                                      <td><?php echo $billInfo_extra[$i][0][5];?></td>
                                      <td><?php echo $billInfo_extra[$i][0][3];?></td>
                                    <?php   if($billInfo_extra[$i][0][6] == 1){?>
                            
                            
                                      <td><?php echo $billInfo_extra[$i][0][7];?></td>
                                      <td><?php echo $billInfo_extra[$i][0][8];?></td>
                            <?php }?> 
                                      
                                    <td><?php echo $billInfo_extra[$i][0][10];?></td>  
                                      
                                        
                                <?php
                                
                                  $amount +=$billInfo_extra[$i][0][3];
                                
                                ?>        
                            
                            
                          
                                        
                              
                                      
                                      
                                    </tr>
                          <?php     
                              }



                          }
                          else{

                          }



                            
                            ?>
                          
                          
                          <tr style="font-size: 18px;">
                            <td colspan="6" align="right"><b>Total</b></td>
                            <td><b><?php echo $amount;?></b></td>
                            <td><b><?php echo $card_amount;?></b></td>
                             <td><b><?php echo $upi_amount;?></b></td>
                            <td></td>
                            <td></td>
                            
                          </tr>
                          </tbody>         
                    </table>
<?php
      if(empty($export)){
?>
                        <div align="center"> 

                            <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printForm()">

                        </div>
<?php
      }
?>                
                    </div>
                </div>
            </div>
            </div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
    <input type="hidden" name="bill_id" id="bill_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value="">      
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">

$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker();
    $(".timepicker").timepicker({showInputs: false,defaultTime: false});

    if ( $( "#customer_type" ).val()=="OP" || $( "#customer_type" ).val()=="IP" ) {
            $("#customer_id").removeAttr('readonly');
    }
    else{
            $("#customer_id").attr('readonly','readonly');
            $("#customer_id").val('');
    }

    $( "#customer_type" ).change(function() {
        
        if ( $( "#customer_type" ).val()=="OP" || $( "#customer_type" ).val()=="IP" ) {
            $("#customer_id").removeAttr('readonly');
        }
        else{
            $("#customer_id").attr('readonly','readonly');
            $("#customer_id").val('');
        }

    });  

});
   
   function searchForm(){
      
      document.credit_payment.action="<?php echo base_url(); ?>index.php/reports/credit_payment_report";
      document.credit_payment.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/credit_payment_report'); ?>";
        return false;


    }
    function printInvoice(id) {
            
            $('#bill_id').val(id);
            $('#from_path').val("invoice_report");
            document.credit_payment.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
            document.credit_payment.submit();
            
    }
    function viewInvoice(id) {
            

            $('#bill_id').val(id);
            $('#from_path').val("invoice_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/invoice/print_invoice/"+$('#bill_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.credit_payment.action='<?php echo base_url(); ?>index.php/reports/credit_payment_report';
        document.credit_payment.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportCreditPayment(){

        document.credit_payment.action="<?php echo base_url(); ?>index.php/reports/credit_payment_report/export";
        document.credit_payment.submit();

    }

</script>
