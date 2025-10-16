<?php
      
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=purchase_itemwise-report.xls');
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

<form name="itemwise_purchase_report" id="itemwise_purchase_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1 class="main_heading">
                  ITEMWISE PURCHASE REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportPurchaseItemwise()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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

                        Brand : 
                </td>
                <td>

                      <input type="text" name="brand" id="brand" tabbindex="2" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" value="<?php echo !empty($brand_name)?$brand_name:'' ?>">
           
                      <input type="hidden" id="brand_hidden" name="brand_ID" value="<?php echo !empty($brand_ID)?$brand_ID:'' ?>">
                      <!-- <input type="hidden" id="batch_hidden" name="batch_ID" > -->
                         
                </td>
                <td>
                      Purchase Mode : 
                </td>
                <td>
                     <select name="purchase_mode" id="purchase_mode">
                            <option value="">--------------</option>
                            <option value="Recievings" <?php echo (!empty($purchase_mode) && ($purchase_mode=='Recievings'))?'selected':''; ?>>Purchase</option>
                            <option value="Return" <?php echo (!empty($purchase_mode) && ($purchase_mode=='Return'))?'selected':''; ?>>Return</option>
                        </select>
                </td>
            </tr>
            <tr>

                           <td colspan="8" align="center">
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
<?php
}  
?>
                <h3 id="print_details">

                      Itemwiese Purchase Report
              
                </h3>
                <div id="success">
                        <?php

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                            }
                            if (!empty($brand_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brand : ".$brand_name;
                            }
                            if (!empty($purchase_mode)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Purchase Mode : ";
                                echo ($purchase_mode=='Recievings')?'Purchase':'Return';
                            }else{
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Purchase Mode : ALL";
                            }
                            
                        ?>
                        
              </div>
          </div> <!--row-->

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table class="table table-striped table-bordered" style="margin: 0 auto;width: 50%;margin-top: 15px;">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Brand</a></th>
                                <th class="font_th"><a href="#">Qty</a></th>
                                <th class="font_th"><a href="#">Net Total</a></th>                    
                            </tr>
                        </thead>
                          <tbody>
                          
                          <?php
                            $net_total=0;
                             $j=1;
                            if(!empty($itemInfo)){            
                                
                              for($i=0;$i<count($itemInfo);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/reports/itemwise_detailed_report_recievings/<?php echo $itemInfo[$i][0];?>/<?php echo $from_date;?>/<?php echo $end_date;?>/<?php echo $purchase_mode;?>" 
                                    class="thickbox none" title="View Item Bill Information"><?php echo $itemInfo[$i][3];?></a></td>
                                    <td><?php echo ($purchase_mode=='Return')?(-$itemInfo[$i][1]):$itemInfo[$i][1];?></td>
                                    <td><?php echo ($purchase_mode=='Return')?(-$itemInfo[$i][2]):$itemInfo[$i][2];?></td>           
                                    
                                  </tr>
                        <?php 
                        
                                $net_total=$net_total+$itemInfo[$i][2];
                                  
                            }
                          }
                            
                            ?>
                          <tr>
                            <td colspan="3" align="right"><b>Total</b></td>
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
    <input type="hidden" name="purchase_id" id="purchase_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value="">      
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
    

$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker(); 

});
   
   function searchForm(){
      
      document.itemwise_purchase_report.action="<?php echo base_url(); ?>index.php/reports/purchase_itemwise_report";
      document.itemwise_purchase_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/purchase_itemwise_report'); ?>";
        return false;

    }
    function printInvoice(id) {
            
            $('#purchase_id').val(id);
            $('#from_path').val("invoice_report");
            document.itemwise_purchase_report.action='<?php echo base_url(); ?>index.php/purchase/print_invoice';
            document.itemwise_purchase_report.submit();
            
    }
    function viewInvoice(id) {
            

            $('#purchase_id').val(id);
            $('#from_path').val("invoice_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/purchase/print_invoice/"+$('#purchase_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.itemwise_purchase_report.action='<?php echo base_url(); ?>index.php/reports/purchase_itemwise_report';
        document.itemwise_purchase_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportPurchaseItemwise(){

       document.itemwise_purchase_report.action="<?php echo base_url(); ?>index.php/reports/purchase_itemwise_report/export";
       document.itemwise_purchase_report.submit(); 

    }

</script>
