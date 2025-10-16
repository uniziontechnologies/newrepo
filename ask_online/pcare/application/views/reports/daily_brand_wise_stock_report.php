<?php

  if(empty($export)){
      $this->load->view("header");
  }

  if(!empty($export)){
          
          date_default_timezone_set("Asia/Calcutta");
          
          $current_date = date("d-m-Y");

          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=stock-report('.$current_date.').xls');
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
   @media print{
       #print_details{
        display: block;
        margin-left: 20px;
       }
      a[href]:after {
        content: none !important;
      }    
   }
   .table_style{
      width: 50%;
      margin: 0 auto;
   }
   .st-idf{
      text-align: center;
      color: #ffffff;
      background-color: #777;
   }
   .stock_display{

      padding-right: 25px;
      font-size: 14px;

   }

</style>

<form name="daily_brand_wise_stock_report" id="daily_brand_wise_stock_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  DAILY BRAND WISE STOCK REPORT
            </h1>
            <!-- <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportStock()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
            </div> -->

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
                  <table width="100%" class="table table-striped table_style">
                
              <tr>
                <td>
                        Date : 
                </td>
                <td>
                          <input type="text" name="from_date" id="from_date" value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true">
                </td> 
                <td>
                        Brand : 
                </td>
                <td>
                    <input name="brand_ID" id="brand_hidden" tabbindex="2" value="<?php echo !empty($brand_ID)?$brand_ID:'' ?>" autocomplete="off"  >
                    
                   <!--  <input type="hidden" id="brand_hidden" name="brand_ID" >
                    <input type="hidden" id="batch_hidden" name="batch_ID" > -->
                </td>
                       
               <td>
                    <button type="button" class="btn btn-info" onclick="searchForm()"><span class="glyphicon glyphicon-search"></span> Search</button>
                    <button type="button" class="btn btn-danger" onclick="clearForm()"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
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

                          Daily Brand Wise Stock Report
              
                </h3>
          <div class="row">
<?php
if(empty($export)){
?>
            <div class="col-md-9" id="success">
          
                            <?php
                             if (!empty($brand_ID)) {
                                echo " Brand : ".$brand_ID;
                             }

                             

                            ?> 
                            
            </div>
            <div class="col-md-3 DONTPrint">
             
                    <?php echo $pagination_link; ?>
              
           </div>
<?php
}
?> 
          </div> 

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    

                    <table width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Date</a></th>
                                <th class="font_th"><a href="#">Brand</a></th>
                                <th class="font_th"><a href="#">Main Stock</a></th>
                                <th class="font_th"><a href="#">Branch Stock</a></th>
                               
                                   
                        
                            </tr>
                            
                        </thead>
                        <tbody>
                            
                          <?php 
                          // var_dump($itemInfo);

                            if(!empty($brand)){           
                               $j= !empty($next_page)?$next_page+1:1;
                              for($i=0;$i<count($brand);$i++) {
                                // if(!empty($itemInfo)){
                                    // echo count($itemInfo);exit();
                                    // for($k=0;$k<count($itemInfo);$k++) {
                                        // if(!empty($itemInfo[$i][$k])){
                                            ?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    
                                    <!-- <td><?php echo date("d-m-Y",strtotime($brand[$i][0]));?></td> -->
                                    <td><?php echo $from_date; ?></td>
                                    <td><?php echo $brand[$i][1];?></td>

                                    <?php 

                                        if (!empty($brand[$i][28])) {
                                            
                                            for ($k=0; $k < count($brand[$i][28]) ; $k++) { //var_dump($brand[$i][28][$k]);?> 
                                               
                                    <td><?php echo $brand[$i][28][$k][0];?></td>
                                    <td><?php echo $brand[$i][28][$k][1];?></td>
                                    <?php
                                            }

                                        }
                                        else{?>

                                    <td>0</td>
                                    <td>0</td>

                                        <?php
                                        }

                                    ?>

                                   
                                    
                                    

                                  </tr>
                        <?php
                    // }
                        // }     
                            // }
                          }
                      }
                            
                            ?>
                            
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
  
 $(document).ready(function(){

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#daily_brand_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport");
                 $("#daily_brand_wise_stock_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#daily_brand_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport");
                 $("#daily_brand_wise_stock_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#daily_brand_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport");
                 $("#daily_brand_wise_stock_report").submit();
    });

  });
   
function searchForm(){
      
    $("#current_page").val('');
    document.daily_brand_wise_stock_report.action="<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport";
    document.daily_brand_wise_stock_report.submit();

}

function clearForm(){

    window.location = "<?php echo site_url('reports/dailyBrandWiseStockReport'); ?>";
    return false;

}

function exportStock(){
  
    window.open('<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport/export');
  

}

function printForm() {
       
    window.print();

}
$(function () {

    //Date range picker
    $('#from_date').datepicker();
    $('#end_date').datepicker();
     
});


</script>
