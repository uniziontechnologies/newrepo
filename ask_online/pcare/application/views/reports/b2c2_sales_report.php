<?php
      
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');

      if(!empty($show_report) && $show_report=='return'){
          header('Content-Disposition: attachment; filename=b2c2_sales_return-report.xls');
      }elseif(!empty($show_report) && $show_report=='b2c2summary'){
          header('Content-Disposition: attachment; filename=b2c2_summary-report.xls');
      }else{
          header('Content-Disposition: attachment; filename=b2c2_sales-report.xls');
      }
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

<form name="sales_report" id="sales_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1 class="main_heading">

<?php
                  if(!empty($show_report) && $show_report=='return'){
                         echo "B2C2 SALES RETURN REPORT";
                  }elseif(!empty($show_report) && $show_report=='b2c2summary'){
                         echo "B2C2 SUMMARY REPORT";
                  }else{
                         echo "B2C2 SALES REPORT";
                  }
?>
       
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportB2C2Sales()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                         Show Report : 
                </td>
                <td>
                         <select name="show_report" id="show_report">
                            <option value="">-------------</option>
                            <option value="sales" <?php echo (!empty($show_report) && $show_report=='sales')?'selected':'';  ?>> Sales </option>
                            <option value="return" <?php echo (!empty($show_report) && $show_report=='return')?'selected':'';  ?>> Return </option>
                            <option value="b2c2summary" <?php echo (!empty($show_report) && $show_report=='b2c2summary')?'selected':'';  ?>> Summary </option>
                         </select>       
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
<?php
                  if(!empty($show_report) && $show_report=='return'){
                         echo "B2C2 Sales Return Report";
                  }elseif(!empty($show_report) && $show_report=='b2c2summary'){
                         echo "B2C2 Summary Report";
                  }else{
                         echo "B2C2 Sales Report";
                  }
                         echo " From ".$from_date." To ".$end_date;
?>

              
                </h3>
          <div class="row">

               <div class="col-md-12" id="success">
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
              
          </div>

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
<?php
if(empty($show_report) || $show_report=='sales' || $show_report=='b2c2summary'){
?>
                    <h4 style="margin: 2px;">SALES REPORT</h4>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Type</a></th>
                                <th class="font_th"><a href="#">Place of Supply</a></th>
                                <th class="font_th"><a href="#">Rate</a></th>
                                <th class="font_th"><a href="#">Taxable Value</a></th>
                                <th class="font_th"><a href="#">Tax Rate Cgst</a></th>
                                <th class="font_th"><a href="#">Tax Rate Sgst</a></th>
                                <th class="font_th"><a href="#">Flood Cess Amount1%</a></th>
                                <th class="font_th"><a href="#">Cess Amount</a></th>
                                <th class="font_th"><a href="#">E-Commerce GSTIN</a></th>
                                
                            </tr>
                        </thead>
                          <tbody>
                              
                        <?php

                             $taxable_value=0;
                             $tax_rate_cgst=0;
                             $tax_rate_sgst=0;
                             $f_cess=0;

                             $j=1;
                            if(!empty($itemInfo_sales)){            
                                $j= 1;
                              for($i=0;$i<count($itemInfo_sales);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td>OE</td>
                                    <td></td>  
                                    <td>
                                          <?php echo empty($itemInfo_sales[$i][2])?'0':$itemInfo_sales[$i][2];?> 
                                    </td>
                                    <td><?php echo $itemInfo_sales[$i][0];?></td> 
                                    <td><?php echo $itemInfo_sales[$i][3];?></td>
                                    <td><?php echo $itemInfo_sales[$i][4];?></td>
                                    <td><?php echo $itemInfo_sales[$i][5];?></td>
                                    <td></td>
                                    <td></td>     
                                    
                                  </tr>
                        <?php 

                                    $taxable_value=$taxable_value+$itemInfo_sales[$i][0];
                                    $tax_rate_cgst=$tax_rate_cgst+$itemInfo_sales[$i][3];
                                    $tax_rate_sgst=$tax_rate_sgst+$itemInfo_sales[$i][4];
                                    $f_cess=$f_cess+$itemInfo_sales[$i][5];
                                                                
                            }
                          }
                            
                            ?>

                                  <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td><b><?php echo $taxable_value;?></b></td>
                                    <td><b><?php echo $tax_rate_cgst;?></b></td>
                                    <td><b><?php echo $tax_rate_sgst;?></b></td>
                                    <td><b><?php echo $f_cess;?></b></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                          
                          </tbody>      
                    </table>
                    <br>
<?php

}
if(!empty($show_report) && ($show_report=='return' || $show_report=='b2c2summary')){

?>

                     <h4 style="margin: 2px;">SALES RETURN REPORT</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Type</a></th>
                                <th class="font_th"><a href="#">Place of Supply</a></th>
                                <th class="font_th"><a href="#">Rate</a></th>
                                <th class="font_th"><a href="#">Taxable Value</a></th>
                                <th class="font_th"><a href="#">Tax Rate Cgst</a></th>
                                <th class="font_th"><a href="#">Tax Rate Sgst</a></th>
                                <th class="font_th"><a href="#">Flood Cess Amount1%</a></th>
                                <th class="font_th"><a href="#">Cess Amount</a></th>
                                <th class="font_th"><a href="#">E-Commerce GSTIN</a></th>
                                
                            </tr>
                        </thead>
                          <tbody>
                              
                        <?php

                             $taxable_value=0;
                             $tax_rate_cgst=0;
                             $tax_rate_sgst=0;
                             $f_cess=0;

                             $j=1;
                            if(!empty($itemInfo_return)){            
                                $j= 1;
                              for($i=0;$i<count($itemInfo_return);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td>OE</td>
                                    <td></td>  
                                    <td>
                                          <?php echo empty($itemInfo_return[$i][2])?'0':$itemInfo_return[$i][2];?> 
                                    </td>
                                    <td><?php echo $itemInfo_return[$i][0];?></td> 
                                    <td><?php echo $itemInfo_return[$i][3];?></td>
                                    <td><?php echo $itemInfo_return[$i][4];?></td>
                                    <td><?php echo $itemInfo_return[$i][5];?></td>
                                    <td></td>
                                    <td></td>     
                                    
                                  </tr>
                        <?php 

                                    $taxable_value=$taxable_value+$itemInfo_return[$i][0];
                                    $tax_rate_cgst=$tax_rate_cgst+$itemInfo_return[$i][3];
                                    $tax_rate_sgst=$tax_rate_sgst+$itemInfo_return[$i][4];
                                    $f_cess=$f_cess+$itemInfo_return[$i][5];

                                                                
                            }
                          }
                            
                            ?>

                                  <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td><b><?php echo $taxable_value;?></b></td>
                                    <td><b><?php echo $tax_rate_cgst;?></b></td>
                                    <td><b><?php echo $tax_rate_sgst;?></b></td>
                                    <td><b><?php echo $f_cess;?></b></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                          
                          </tbody>      
                    </table>

<?php

}

if(!empty($show_report) && $show_report=='b2c2summary'){

?>

                    <br>
                     <h4 style="margin: 2px;">NET SALES REPORT</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Type</a></th>
                                <th class="font_th"><a href="#">Place of Supply</a></th>
                                <th class="font_th"><a href="#">Rate</a></th>
                                <th class="font_th"><a href="#">Taxable Value</a></th>
                                <th class="font_th"><a href="#">Tax Rate Cgst</a></th>
                                <th class="font_th"><a href="#">Tax Rate Sgst</a></th>
                                <th class="font_th"><a href="#">Flood Cess Amount1%</a></th>
                                <th class="font_th"><a href="#">Cess Amount</a></th>
                                <th class="font_th"><a href="#">E-Commerce GSTIN</a></th>
                                
                            </tr>
                        </thead>
                          <tbody>
                              
                        <?php

                             $taxable_value=0;
                             $tax_rate_cgst=0;
                             $tax_rate_sgst=0;
                             $f_cess=0;

                             $j=1;
                            if(!empty($itemInfo_netsales)){            
                                $j= 1;
                              for($i=0;$i<count($itemInfo_netsales);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td>OE</td>
                                    <td></td>  
                                    <td>
                                          <?php echo empty($itemInfo_netsales[$i][2])?'0':$itemInfo_netsales[$i][2];?> 
                                    </td>
                                    <td><?php echo $itemInfo_netsales[$i][0];?></td> 
                                    <td><?php echo $itemInfo_netsales[$i][3];?></td>
                                    <td><?php echo $itemInfo_netsales[$i][4];?></td>
                                    <td><?php echo $itemInfo_netsales[$i][5];?></td>
                                    <td></td>
                                    <td></td>     
                                    
                                  </tr>
                        <?php 

                                    $taxable_value=$taxable_value+$itemInfo_netsales[$i][0];
                                    $tax_rate_cgst=$tax_rate_cgst+$itemInfo_netsales[$i][3];
                                    $tax_rate_sgst=$tax_rate_sgst+$itemInfo_netsales[$i][4];
                                    $f_cess=$f_cess+$itemInfo_netsales[$i][5];
                                                                
                            }
                          }
                            
                            ?>

                                  <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td><b><?php echo $taxable_value;?></b></td>
                                    <td><b><?php echo $tax_rate_cgst;?></b></td>
                                    <td><b><?php echo $tax_rate_sgst;?></b></td>
                                    <td><b><?php echo $f_cess;?></b></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                          
                          </tbody>      
                    </table>
<?php
}
?>
                        
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

});
   
   function searchForm(){
      
      document.sales_report.action="<?php echo base_url(); ?>index.php/reports/salesReportCtwoBtwo";
      document.sales_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/salesReportCtwoBtwo'); ?>";
        return false;

    }
    function printForm() {
       
        window.print();

    }
    function exportB2C2Sales(){

       $("#current_page").val('');
       document.sales_report.action="<?php echo base_url(); ?>index.php/reports/salesReportCtwoBtwo/export";
       document.sales_report.submit(); 

    }

</script>
