<?php

  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=sales_file-report.xls');
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
   }
   @media print{
       #print_details{
        display: block;
        margin-left: 20px;
       }    
      a[href]:after {
        content: none !important;
      }
      table{
        width: 100% !important;
      }
   }

</style>

<form name="sales_file_report" id="sales_file_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1 class="main_heading">
                 SALES FILE REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportSalesFile()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                </td>
                <td>
                         End Date : 
                </td>
                <td>
                          <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true">       
                </td>


                           <td>
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
<?php
}  
?>
                <h3 id="print_details">

                  Sales Files Report From <?php echo $from_date; ?> To <?php echo $end_date; ?>
              
                </h3>
          <div class="row">

               <div class="col-md-9" id="success">
<?php
if(empty($export)){ 
                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                            }
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

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Invoice Type</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">Is this an Original Invoice or Ammendment Invoice</a></th>

                                <th class="font_th"><a href="#">Is this Advance received without you having given an Invoice for this supply</a></th>

                                <th class="font_th"><a href="#">Is this Advance amount received in earlier tax period and adjusted against the supplies being shown in this tax period</a></th>

                                <th class="font_th"><a href="#">Is this a Zero Rated Supply or Deemed Export Including Exports out of India, Supplies to SEZ unit/ and SEZ developer, Deemed Exports</a></th>

                                <th class="font_th"><a href="#">Is this supply related to E-Commerce Operator?</a></th>

                                <th class="font_th"><a href="#">Is this a Credit Note / Debit Note / Refund Voucher?</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">Name of Receipient</a></th>
                                <th class="font_th"><a href="#">Nature of Supply</a></th>
                                <th class="font_th"><a href="#">Invoice number</a></th>
                                <th class="font_th"><a href="#">Invoice date</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">GSTIN / UIN of recipient</a></th>
                                <th class="font_th"><a href="#">State of receipient of Invoice</a></th>
                                <th class="font_th"><a href="#">State of supply of goods / services</a></th>
                                <th class="font_th"><a href="#">Is reverse charge mechanism applicable?</a></th>
                                <th class="font_th"><a href="#">Is Provisional assessment Applicable</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">Invoice Value</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">Original Invoice Number</a></th>
                                <th class="font_th"><a href="#">Original Invoice Date</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">Sr No for Item Details</a></th>
                                <th class="font_th"><a href="#">Taxable value</a></th>
                                <th class="font_th"><a href="#">Rate</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">IGST Rate</a></th>
                                <th class="font_th"><a href="#">IGST Tax Amount</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">CGST Rate</a></th>
                                <th class="font_th"><a href="#">CGST Tax Amount</a></th>
                                <th class="font_th"><a href="#">SGST Rate</a></th>
                                <th class="font_th"><a href="#">SGST Tax Amount</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">Cess Rate</a></th>
                                <th class="font_th"><a href="#">Cess Amount</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">HSN or SAC of Goods or Services</a></th>
                                <th class="font_th"><a href="#">Description of goods sold</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">UQC (Unit of Measure) of goods sold</a></th>
<?php
}
?>
                                <th class="font_th"><a href="#">Quantity of goods sold</a></th>
<?php
if(!empty($export)){
?>
                                <th class="font_th"><a href="#">GSTIN of E-commerce Operator (if applicable)</a></th>
                                <th class="font_th"><a href="#">Amount of Advance received</a></th>
                                <th class="font_th"><a href="#">Amount of Advance to be adjusted</a></th>
                                <th class="font_th"><a href="#">With/Without payment of GST</a></th>
                                <th class="font_th"><a href="#">Shipping Bill No. or Bill of Export No</a></th>
                                <th class="font_th"><a href="#">Shipping Bill Date. or Bill of Export Date</a></th>
                                <th class="font_th"><a href="#">Credit or Debit or Refund Voucher?</a></th>
                                <th class="font_th"><a href="#">Credit / Debit Note Number</a></th>
                                <th class="font_th"><a href="#">Credit / Debit Note Date</a></th>
<?php
}
?>

                            </tr>
                        </thead>
                          <tbody>
                               
                          <?php

                             $taxable_value=0;
                             $cgst_amt=0;
                             $sgst_amt=0;

                             $j=1;
                             $sr_no=1;
                             $m=0;

                            if(!empty($itemInfo)){            
                                $j= !empty($next_page)?$next_page+1:1;
                              for($i=0;$i<count($itemInfo);$i++) {

                                ?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td>
                                      <?php 
                                        if($itemInfo[$i][5]=='Sales'){
                                          echo "R- Regular B2B Invoices";
                                        }elseif($itemInfo[$i][5]=='Return'){
                                          echo "R- Regular B2B Invoices(Return)";
                                        }
                                            
                                      ?>
                                    </td>
<?php
if(!empty($export)){
?>
                                    <td>O - Original</td>  
                                    <td>No</td>
                                    <td>No</td> 
                                    <td>No</td>
                                    <td>No</td>
                                    <td>No</td>
<?php
}
?>
                                    <td><?php echo $itemInfo[$i][30]; ?></td> 
                                    <td>Goods</td>    
                                    <td><?php echo $itemInfo[$i][1]; ?></td>
                                    <td><?php echo $itemInfo[$i][2]; ?></td>
<?php
if(!empty($export)){
?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>No</td>
                                    <td>No</td>
<?php
}
?>
                                    <td><?php echo $itemInfo[$i][31]; ?></td>
<?php
if(!empty($export)){
?>
                                    <td></td>
                                    <td></td>
<?php
}
?>
                                    <td>
                                    <?php 
                                      // echo $bill_no;
                                      if(!empty($bill_no) && ($bill_no==$itemInfo[$i][1])){
                                        $sr_no++;
                                      }else{
                                        $sr_no=1;
                                      }
                                      echo $sr_no;
                                      $bill_no=$itemInfo[$i][1];
                                      
                                    ?>
                                    </td>

                                    <td><?php echo $itemInfo[$i][29]; ?></td>
                                    <td><?php echo $itemInfo[$i][14]; ?></td>
<?php
if(!empty($export)){
?>
                                    <td>0</td>
                                    <td>0</td>
<?php
}
?>
                                    <td><?php echo $itemInfo[$i][16]; ?></td>
                                    <td><?php echo ($itemInfo[$i][19]*$itemInfo[$i][9]); ?></td>
                                    <td><?php echo $itemInfo[$i][15]; ?></td>
                                    <td><?php echo ($itemInfo[$i][18]*$itemInfo[$i][9]); ?></td>
<?php
if(!empty($export)){
?>
                                    <td>0</td>
                                    <td>0</td>
<?php
}
?>
                                    <td><?php echo $itemInfo[$i][28]; ?></td>
                                    <td><?php echo $itemInfo[$i][12]; ?></td>
<?php
if(!empty($export)){
?>
                                    <td></td>
<?php
}
?>
                                    <td><?php echo $itemInfo[$i][9]; ?></td>
<?php
if(!empty($export)){
?>
                                    <td></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
<?php
}
?>
                                  </tr>
                        <?php 

                                  $taxable_value=$taxable_value+$itemInfo[$i][29];
                                  $cgst_amt=$cgst_amt+$itemInfo[$i][19];
                                  $sgst_amt=$sgst_amt+$itemInfo[$i][18];
                                                                
                            }
                          }
                            
                            ?>

<?php
if(!empty($export)){
?>

                            <tr>
                              <td colspan="21" align="right"><b>Total</b></td>
                              <td><?php echo $taxable_value; ?></td>
                              <td colspan="4"></td>
                              <td><?php echo $cgst_amt; ?></td>
                              <td></td>
                              <td><?php echo $sgst_amt; ?></td>
                              <td colspan="15"></td>
                                   
                            </tr>

<?php
}else{
?>
                  
                            <tr>
                              <td colspan="8" align="right"><b>Total</b></td>
                              <td><?php echo $taxable_value; ?></td>
                              <td></td>
                              <td></td>
                              <td><?php echo $cgst_amt; ?></td>
                              <td></td>
                              <td><?php echo $sgst_amt; ?></td>
                              <td colspan="3"></td>
                                   
                            </tr>

<?php
}
?>
                          
                          </tbody>      
                    </table>
                    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">     
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
     
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
    

$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker(); 



  /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#sales_file_report").attr("action","<?php echo base_url(); ?>index.php/reports/salesFile");
                 $("#sales_file_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#sales_file_report").attr("action","<?php echo base_url(); ?>index.php/reports/salesFile");
                 $("#sales_file_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#sales_file_report").attr("action","<?php echo base_url(); ?>index.php/reports/salesFile");
                 $("#sales_file_report").submit();
    });





});
   
   function searchForm(){
      
      $("#current_page").val('');
      document.sales_file_report.action="<?php echo base_url(); ?>index.php/reports/salesFile";
      document.sales_file_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/salesFile'); ?>";
        return false;

    }
    function printForm() {
       
        window.print();

    }
    function exportSalesFile(){

       $("#current_page").val('');
       document.sales_file_report.action="<?php echo base_url(); ?>index.php/reports/salesFile/export";
       document.sales_file_report.submit(); 

    }

</script>
