<?php

  if(empty($export)){
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=stock-report.xls');
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

<form name="stock_report" id="stock_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  STOCK REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportStock()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                  <table width="100%" class="table table-striped table_style">
                
              <tr>

                <td>
                         Brand Name : 
                </td>
                <td>

                    <input name="brand_name" id="brand_name" tabbindex="2" value="<?php echo !empty($brand_name)?$brand_name:'' ?>" onkeypress="if(event.keyCode == 13)searchForm();">
                    
                    <input type="hidden" id="brand_name_hidden" name="brand_name_ID" >
                    <input type="hidden" id="batch_hidden" name="batch_ID" >   
        
                </td>

                <td>
                         Category : 
                </td>
                <td>

                    <select name="category" id="category" onkeypress="nextField(event.keyCode,Search);" onchange="searchForm();">
                            <option value="">----------------</option>
                            <?php
                                if (!empty($categoryInfo)) {

                                    for ($i=0; $i <count($categoryInfo) ; $i++) { ?>
                                        <option value="<?php echo $categoryInfo[$i][0] ?>" <?php if (!empty($category) && $category ==$categoryInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $categoryInfo[$i][1]; ?></option>
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

                          Stock Report
              
                </h3>
          <div class="row">
<?php
if(empty($export)){
?>
            <div class="col-md-9" id="success">
          
                            <?php
                             if (!empty($brand_name)) {
                                echo " Brand : ".$brand_name;
                             }

                             if (!empty($category_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Categoty Name : ".$category_name;
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

                    <span class="stock_display">Main Stock : <?php echo $stock_history[0]; ?></span>
                    <span class="stock_display">SellP : <?php echo $stock_history[1]; ?></span> 
                    <span class="stock_display">BuyP : <?php echo $stock_history[2]; ?></span>

                    <span class="stock_display">Branch Stock : <?php echo $stock_history[3]; ?></span> 
                    <span class="stock_display">SellP : <?php echo $stock_history[4]; ?></span> 
                    <span class="stock_display">BuyP : <?php echo $stock_history[5]; ?></span>

                    <table width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Brand</a></th>
                                <th class="font_th"><a href="#">Selling Unit</a></th>
                                <th class="font_th"><a href="#">Tablets/Pack</a></th>
                                <th class="font_th"><a href="#">Strip/Pack</a></th>
                                <th class="font_th"><a href="#">Price Type</a></th>
                                <th class="font_th"><a href="#">SellP</a></th>
                                <th class="font_th"><a href="#">BuyP</a></th>
                                <th class="font_th st-idf" colspan="3">Main Stock</th>
                                <th class="font_th st-idf" colspan="3">Branch Stock</th>
                                <th class="font_th"><a href="#">Reorder Level</a></th>
<?php
      if(empty($export)){ 
?>                                
                                <th class="font_th DONTPrint"><a href="#">Action</a></th>
<?php
      }
?>        
                        
                            </tr>
                            <tr>
                              <!-- main stock -->
                              <th colspan="8"></th>
                              <th class="font_th"><a href="#">Stock</a></th>
                              <th class="font_th"><a href="#">Total SellP</a></th>
                              <th class="font_th"><a href="#">Total BuyP</a></th>

                              <!-- branch stock -->
                              <th class="font_th"><a href="#">Stock</a></th>
                              <th class="font_th"><a href="#">Total SellP</a></th>
                              <th class="font_th"><a href="#">Total BuyP</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                          <?php 
                            if(!empty($brand)){           
                               $j= !empty($next_page)?$next_page+1:1;
                              for($i=0;$i<count($brand);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td><?php echo $brand[$i][1];?></td>
                                    <td><?php echo $brand[$i][6];?></td>
                                    <td><?php echo $brand[$i][7];?></td>
                                    <td><?php echo $brand[$i][8];?></td>
                                    <td><?php echo $brand[$i][9];?></td>
                                    <td><?php echo $brand[$i][10];?></td>
                                    <td><?php echo $brand[$i][11];?></td>

                                    <td><span class="badge"><?php echo $main_stock=display_in_pack($brand[$i][13],$brand[$i][14],$brand[$i][15]);;?></span></td>
                                    <td><?php echo $main_stock*$brand[$i][10]; ?></td>
                                    <td><?php echo $main_stock*$brand[$i][11]; ?></td>

                                    <td><span class="badge"><?php echo $branch_stock=display_in_pack($brand[$i][20],$brand[$i][21],$brand[$i][22]);;?></span></td>
                                    <td><?php echo $branch_stock*$brand[$i][10]; ?></td>
                                    <td><?php echo $branch_stock*$brand[$i][11]; ?></td>
                                    <td><?php echo $brand[$i][16];?></td>
<?php
      if(empty($export)){ 
?>     
                                    <td class="DONTPrint">

                                         <a href="<?php echo base_url(); ?>index.php/reports/batch_report/<?php echo $brand[$i][0];?>" target="_blanck">
                                          
                                          <i class="fa fa-external-link-square" style="font-size:25px;color:#00a65a;"></i>

                                         </a>
                                      
                                    </td>
<?php
      }
?> 
                                  </tr>
                        <?php     
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
                 $("#stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/stock_report");
                 $("#stock_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/stock_report");
                 $("#stock_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#stock_report").attr("action","<?php echo base_url(); ?>index.php/reports/stock_report");
                 $("#stock_report").submit();
    });

  });
   
function searchForm(){
      
    $("#current_page").val('');
    document.stock_report.action="<?php echo base_url(); ?>index.php/reports/stock_report";
    document.stock_report.submit();

}

function clearForm(){

    window.location = "<?php echo site_url('reports/stock_report'); ?>";
    return false;

}

function exportStock(){
  
    window.open('<?php echo base_url(); ?>index.php/reports/stock_report/export');
  

}

function printForm() {
       
    window.print();

}

</script>
