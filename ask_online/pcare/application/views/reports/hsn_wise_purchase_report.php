<?php
      
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=hsn_wise_purchase-report.xls');
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

<form name="hsn_wise_purchase_report" id="hsn_wise_purchase_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1 class="main_heading">
                  HSN WISE PURCHASE REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exporthsnWisePurchase()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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

                      Hsn Wise Purchase Report From <?php echo $from_date; ?> To <?php echo $end_date; ?>
              
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
                                <th class="font_th"><a href="#">HSN</a></th>
                                <th class="font_th"><a href="#">Description</a></th>
                                <th class="font_th"><a href="#">UQC</a></th>
                                <th class="font_th"><a href="#">Rate</a></th>
                                <th class="font_th"><a href="#">Total</a></th>
                                <th class="font_th"><a href="#">Taxable</a></th>
                                <th class="font_th"><a href="#">Integrated</a></th>
                                <th class="font_th"><a href="#">Central Tax</a></th>
                                <th class="font_th"><a href="#">State/UT Tax</a></th>
                                <th class="font_th"><a href="#">Cess Amount</a></th>

                            </tr>
                        </thead>
                          <tbody>
                          
                          <?php
                            $total=0;
                            $taxable=0;
                            $cgst_total=0;
                            $sgst_total=0;

                             $j=1;
                            if(!empty($itemInfo)){            
                                $j= !empty($next_page)?$next_page+1:1;
                              for($i=0;$i<count($itemInfo);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td><?php echo $itemInfo[$i][27];?></td>
                                    <td><?php echo $itemInfo[$i][15];?></td>
                                    <td>OTH-OTHERS</td>  
                                    <td><?php echo $itemInfo[$i][12];?></td>
                                    <td><?php echo $itemInfo[$i][13];?></td> 
                                    <td><?php echo $itemInfo[$i][28];?></td>
                                    <td>0.00</td>
                                    <td><?php echo $itemInfo[$i][22];?></td>  
                                    <td><?php echo $itemInfo[$i][21];?></td>
                                    <td></td>         
                                    
                                  </tr>
                        <?php 
                        
                                $total=$total+$itemInfo[$i][13];
                                $taxable=$taxable+$itemInfo[$i][28];
                                $cgst_total=$cgst_total+$itemInfo[$i][22];
                                $sgst_total=$sgst_total+$itemInfo[$i][21];
                                                                
                            }
                          }
                            
                            ?>
                          <tr>
                            <td colspan="5" align="right"><b>Total</b></td>
                            <td><b><?php echo $total;?></b></td>
                            <td><b><?php echo $taxable;?></b></td>
                            <td><b>0.00</b></td>
                            <td><b><?php echo $cgst_total;?></b></td>
                            <td><b><?php echo $sgst_total;?></b></td>
                            <td></td>
                            
                          </tr>
                          
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
                 $("#hsn_wise_purchase_report").attr("action","<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport");
                 $("#hsn_wise_purchase_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#hsn_wise_purchase_report").attr("action","<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport");
                 $("#hsn_wise_purchase_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#hsn_wise_purchase_report").attr("action","<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport");
                 $("#hsn_wise_purchase_report").submit();
    });





});
   
   function searchForm(){
      
      $("#current_page").val('');
      document.hsn_wise_purchase_report.action="<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport";
      document.hsn_wise_purchase_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/hsnWisePurchaseReport'); ?>";
        return false;

    }
    function printForm() {
       
        window.print();

    }
    function exporthsnWisePurchase(){

       $("#current_page").val('');
       document.hsn_wise_purchase_report.action="<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport/export";
       document.hsn_wise_purchase_report.submit(); 

    }

</script>
