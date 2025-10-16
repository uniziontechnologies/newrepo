<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=invoice_return-report.xls');
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
/*   .table_width_style{
    width: 60%;
    margin: 0 auto;
    text-align: center;
   }*/
   #print_details{
    display: none;
   }
   input.btn.btn-info.DONTPrint{
    margin-top: 30px;
    /*width: 55px !important;*/
   }
/*  select, input {
      width: 120px;
  }*/
   @media print{
       #print_details{
        display: block;
        margin-left: 20px;
       }    
   }

</style>

<form name="invoice_return_report" id="invoice_return_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  INVOICE RETURN REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportInvoiceReturn()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                  <table width="100%" class="table table-striped table_width_style">
                
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
<!--                 <td>

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
                         
                </td> -->


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
          </div> <!--row-->
<?php
}
?>
                <h3 id="print_details">

                      Invoice Return Report
              
                </h3>
          <div class="row">

               <div class="col-md-9" id="success">
                        <?php  

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
                                <th class="font_th"><a href=""><?php echo "Sl No";?></a></th>           
                                <th class="font_th"><a href=""><?php echo "Bill No";?></a></th>
                                <th class="font_th"><a href=""><?php echo "Date";?></a></th>
                                <th class="font_th"><a href=""><?php echo "Mode" ?></a></th>  
                                <th class="font_th"><a href=""><?php echo "Brand" ?></a></th>             
                                <th class="font_th"><a href=""><?php echo "Batch" ?></a></th>
                                <th class="font_th"><a href=""><?php echo "Expiry" ?></a></th>
                                <th class="font_th"><a href=""><?php echo "Pack" ?></a></th>
                                <th class="font_th"><a href=""><?php echo "Qty" ?></a></th>                 
                                <th class="font_th"><a href=""><?php echo "Sell p" ?></a></th>
                                <th class="font_th"><a href=""><?php echo "Total" ?></a></th>
                                <th class="font_th"><a href=""><?php echo "Entered By" ?></a></th>
    
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php
                          $net_total=0;
                           $j=1;
                          if(!empty($itemInfo)){            
                              $j= !empty($next_page)?$next_page+1:1;
                            for($i=0;$i<count($itemInfo);$i++) {?>
                                <tr>
                                  <td style="text-align: left !important;"><?php echo $j++;?></td>
                                  <td><?php echo $itemInfo[$i][1];?></td>
                                  <td><?php echo $itemInfo[$i][2];?></td>
                                  <td><?php echo $itemInfo[$i][5];?></td>
                                  <td><?php echo $itemInfo[$i][12];?></td>
                                  <td><?php echo $itemInfo[$i][6];?></td>
                                  <td><?php echo $itemInfo[$i][7];?></td> 
                                  <td><?php echo $itemInfo[$i][8];?></td>                       
                                  <td><?php echo $itemInfo[$i][9];?></td> 
                                  <td><?php echo $itemInfo[$i][10];?></td>  
                                  <td><?php echo $itemInfo[$i][11];?></td> 
                                  <td><?php echo $itemInfo[$i][27];?></td>          
                                  
                                </tr>
                      <?php 
                      
                              $net_total=$net_total+$itemInfo[$i][11];
                                
                          }
                        }
                        
                          ?>
                        <tr>
                          <td colspan="10" align="right"><b>Total</b></td>
                          <td><b><?php echo $net_total;?></b></td>
                          
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
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">      
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
    

$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker();

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
                 $("#invoice_return_report").attr("action","<?php echo base_url(); ?>index.php/reports/invoice_return");
                 $("#invoice_return_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#invoice_return_report").attr("action","<?php echo base_url(); ?>index.php/reports/invoice_return");
                 $("#invoice_return_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#invoice_return_report").attr("action","<?php echo base_url(); ?>index.php/reports/invoice_return");
                 $("#invoice_return_report").submit();
    });



});
   
   function searchForm(){
      
      $("#current_page").val('');
      document.invoice_return_report.action="<?php echo base_url(); ?>index.php/reports/invoice_return";
      document.invoice_return_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/invoice_return'); ?>";
        return false;

    }
    function printInvoice(id) {
            
            $('#bill_id').val(id);
            $('#from_path').val("invoice_report");
            document.invoice_return_report.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
            document.invoice_return_report.submit();
            
    }
    function viewInvoice(id) {
            

            $('#bill_id').val(id);
            $('#from_path').val("invoice_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/invoice/print_invoice/"+$('#bill_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.invoice_return_report.action='<?php echo base_url(); ?>index.php/reports/invoice_return';
        document.invoice_return_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportInvoiceReturn(){
        
        $("#current_page").val('');
        document.invoice_return_report.action="<?php echo base_url(); ?>index.php/reports/invoice_return/export";
        document.invoice_return_report.submit();

    }
    // function change_values(){

    //   var user_type = $("#user_type").val();

    //   var url = "<?php echo site_url('reports/change_values'); ?>";

    //             $.ajax({
    //               type: 'POST',
    //               url:url,
    //               data: {user_type:user_type},
    //               success: function (data) {
    //                 $("#user_id").html(data);
    //               }
    //             });

    // }

</script>
