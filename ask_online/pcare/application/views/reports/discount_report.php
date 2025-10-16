
<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=discount-report.xls');
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
      padding-top: 15px;
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

<form name="discount_report" id="discount_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  INVOICE DISCOUNT REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportDiscount()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
            </div>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $error_message = $this->session->flashdata('error_message'); 
                        if(!empty($error_message)) 
                            {
                        ?>
                              <div
                               id='message' class="callout callout-danger"><?php echo $error_message; ?></div>
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
                        <input type="text" name="customer_id" id="customer_id" value="<?php echo !empty($customer_id)?$customer_id:'' ?>" autocomplete="off">
                         
                </td>
            </tr>
            <tr>
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


                <td>

                        Payment Type : 
                </td>
                <td>
                          <select name="payment_type" id="payment_type" onkeypress="nextField(event.keyCode,Search);">
                              <option value="">----------------</option>
                              <option value="CASH"  <?php if (!empty($payment_type_selected) && $payment_type_selected =="CASH" ) {
                                echo "selected";
                            } ?> >CASH</option>
                              <option value="CHEQUE" <?php if (!empty($payment_type_selected) && $payment_type_selected =="CHEQUE" ) {
                                echo "selected";
                            } ?> >CHEQUE</option>
                              <option value="CREDIT" <?php if (!empty($payment_type_selected) && $payment_type_selected =="CREDIT" ) {
                                echo "selected";
                            } ?> >CREDIT</option>
                              <option value="CREDIT CARD" <?php if (!empty($payment_type_selected) && $payment_type_selected =="CREDIT CARD" ) {
                                echo "selected";
                            } ?> >CREDIT CARD</option>
                              <option value="BRANCH" <?php if (!empty($payment_type_selected) && $payment_type_selected =="BRANCH" ) {
                                echo "selected";
                            } ?> >BRANCH</option>
                             <option value="UPI" <?php if (!empty($payment_type_selected) && $payment_type_selected =="UPI" ) {
                                echo "selected";
                            } ?> >UPI</option>
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
          </div> <!--row-->
<?php
}
?>
                    <h3 id="print_details">

                        Invoice Discount Report
              
                    </h3>
          <div class="row">
                <div class="col-md-9" id="success">
                          <?php  

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                            }
                            if (!empty($user_type_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; User Type : ".$user_type_name;
                             }
                            if (!empty($user_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; User : ".$user_name;
                             }
                            if (!empty($payment_type_selected)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type_selected;
                             }
                            if (!empty($customer_type)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
                             }


                          ?>
                        
                </div>
                <div class="col-md-3 DONTPrint">
<?php
                    if(empty($export)){ 

                        echo $pagination_link;
                    }
?>
              
                </div>
          </div>

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table width="100%" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="font_th"><a href=""><?php echo "Sl No"; ?></a></th>
                          <th class="font_th"><a href=""><?php echo "Date";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Bill Type";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Bill No";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Customer Type" ?></a></th>
                          <th class="font_th"><a href=""><?php echo "Op/Ip No" ?></a> </th>
                          <th class="font_th"><a href=""><?php echo "Customer Name";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Payment Type" ?></a> </th>
                          <th class="font_th"><a href=""><?php echo "Total" ?></a> </th>
                          <th colspan="3" class="font_th"><a href=""><?php echo "Discount" ?></a> </th>          
                          <th class="font_th"><a href=""><?php echo "Net Total";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Card Amount";?></a></th>
                          <th class="font_th"><a href=""><?php echo "UPI Amount";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Cheque Amount";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Cash Amount";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Credit Paid";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Balance";?></a></th>
                          <th class="font_th"><a href=""><?php echo "Entered By";?></a></th>
<?php
if(empty($export)){
?>
                          <th class="DONTPrint font_th"><a href=""><?php echo "Action";?></a></th>
<?php
}
?>                          
                        </tr>
                        
                      </thead>
                      <tbody >
                      
                      <?php
                        $net_total=0;
                        $cash=0;
                        $card=0;
                        $checque=0;
                        $credit=0; 
                        $discount_total=0;
                        $credit_paid=0;
                        $upi=0;
                        if(!empty($billInfo)){            
                            $j= !empty($next_page)?$next_page+1:1;
                          for($i=0;$i<count($billInfo);$i++) {?>
                              <tr>
                                <td style="text-align: left !important;"><?php echo $j++; ?></td>
                                <td><?php echo $billInfo[$i][5];?></td>
                                <td><?php echo $billInfo[$i][37];?></td>
                                <td><?php echo $billInfo[$i][1];?></td>
                                <td><?php echo $billInfo[$i][2];?></td>
                            <?php if($billInfo[$i][2] == "OP"){?>
                            
                                    <td><?php echo $billInfo[$i][37]."/".$billInfo[$i][34];?></td>
                            <?php }else if($billInfo[$i][2] == "IP"){?>
                            
                                   <td><?php echo $billInfo[$i][34];?></td>
                            <?php }else{?>
                                    <td></td>
                            <?php } ?>
                                <td><?php echo $billInfo[$i][4];?></td>
                                <td><?php echo $billInfo[$i][15];?> 
                            <?php if($billInfo[$i][15] =="CREDIT" || $billInfo[$i][11] !=""){?>
                                
                                <br>Sanctioned By <?php echo $billInfo[$i][35];?><br>
                                Remarks:<?php echo $billInfo[$i][36];
                              }
                                ?>
                                </td>
                                <td><?php echo $billInfo[$i][10];?></td>
                                <td><?php echo $billInfo[$i][11];?></td>
                                <td><?php echo $billInfo[$i][12];?></td>
                                <td><?php echo ($billInfo[$i][37]=='Return')?(-$billInfo[$i][13]):$billInfo[$i][13]; ?></td>
                                
                                <td><?php echo ($billInfo[$i][37]=='Return')?(-$billInfo[$i][14]):$billInfo[$i][14]; ?></td>
                                <td><?php echo $billInfo[$i][18];?></td>
                                <td><?php echo $billInfo[$i][61];?></td>
                                <td><?php echo $billInfo[$i][17];?></td>
                                <td><?php echo ($billInfo[$i][37]=='Return')?(-$billInfo[$i][19]):$billInfo[$i][19]; ?></td>
                                <td><?php echo $billInfo[$i][29];?></td>
                                <td><?php echo $billInfo[$i][32];?></td>
                                <td><?php echo $billInfo[$i][25];?></td>
<?php
if(empty($export)){
?>
                                                <td class="DONTPrint">
                                                    
                                                    <div class="btn-group"> 
                                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Option
                                                          <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>   
                                                      <ul class="dropdown-menu" role="menu">    

                                                         <li><a href="#" onclick="viewInvoice('<?php echo  $billInfo[$i][1];?>')">View Bill Items</a></li>
                                               
                                                         <li ><a href="#" onclick="printInvoice('<?php echo $billInfo[$i][1]; ?>');">Print Bill Items</a></li>
                                                            
                                                      </ul>
                                                    </div>

                                                </td>                             
<?php
}
?>
                                
                              </tr>
                    <?php 
                            $discount_total_all=($billInfo[$i][37]=='Return')?(-$billInfo[$i][13]):$billInfo[$i][13];

                            $net_total_all=($billInfo[$i][37]=='Return')?(-$billInfo[$i][14]):$billInfo[$i][14];

                            $cash_all=($billInfo[$i][37]=='Return')?(-$billInfo[$i][19]):$billInfo[$i][19];

                            $discount_total=$discount_total+$discount_total_all;
                            $net_total=$net_total+$net_total_all;
                            $cash=$cash+$cash_all;
                            $card=$card+$billInfo[$i][18];
                            $checque=$checque+$billInfo[$i][17];
                            $credit=$credit+$billInfo[$i][32]; 
                            $credit_paid=$credit_paid+$billInfo[$i][29];   
                            $upi=$upi+$billInfo[$i][61];
                        }
                      }
                        
                        ?>
                      <tr>
                        <td colspan="11" align="right"><b>Total</b></td>
                        <td><b><?php echo $discount_total;?></b></td>
                        <td><b><?php echo $net_total;?></b></td>
                        <td><b><?php echo $card;?></b></td>
                        <td><b><?php echo $upi;?></b></td>
                        <td><b><?php echo $checque;?></b></td>
                        <td><b><?php echo $cash;?></b></td>
                        <td><b><?php echo $credit_paid;?></b></td>
                        <td><b><?php echo $credit;?></b></td>
                        <td colspan="2"></td>
                      </tr>
                      
                      </tbody>          
                    </table>

                        <div align="center"> 

                            <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printForm()">

                        </div>

                
                    </div>
                </div>
            </div>
            </div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
    <input type="hidden" name="bill_id" id="bill_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value=""> 
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">     
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


 
    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#discount_report").attr("action","<?php echo base_url(); ?>index.php/reports/discount_report");
                 $("#discount_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#discount_report").attr("action","<?php echo base_url(); ?>index.php/reports/discount_report");
                 $("#discount_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#discount_report").attr("action","<?php echo base_url(); ?>index.php/reports/discount_report");
                 $("#discount_report").submit();
    });



});
   
   function searchForm(){
      
      $("#current_page").val('');
      $("#discount_report"). removeAttr("target");
      document.discount_report.action="<?php echo base_url(); ?>index.php/reports/discount_report";
      document.discount_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/discount_report'); ?>";
        return false;

    }
    function printInvoice(id) {
            
            $('#bill_id').val(id);
            $('#from_path').val("invoice_report");
            $("#discount_report").attr("target", "_blank");
            document.discount_report.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
            document.discount_report.submit();
            
    }
    function viewInvoice(id) {
            

            $('#bill_id').val(id);
            $('#from_path').val("invoice_report_popup");
            $("#discount_report"). removeAttr("target");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/invoice/print_invoice/"+$('#bill_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.discount_report.action='<?php echo base_url(); ?>index.php/reports/discount_report';
        document.discount_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportDiscount(){

        $("#current_page").val('');
        $("#discount_report"). removeAttr("target");
        document.discount_report.action="<?php echo base_url(); ?>index.php/reports/discount_report/export";
        document.discount_report.submit();

    }

</script>
