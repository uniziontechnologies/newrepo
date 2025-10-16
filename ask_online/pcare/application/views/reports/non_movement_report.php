<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=non_movement-report.xls');
  }

?> 
 <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/jquery-1.11.3.min.js"></script>
 <script>
 var $j = jQuery.noConflict();
 </script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/wickedpicker.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/wickedpicker.js"></script>
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

</style>

<form name="non_movement_report" id="non_movement_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  NON MOVABLE BRANDS REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportNonMovement()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                         From Date : 
                </td>
                <td>
                          <input type="text" name="from_date" id="from_date" value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true">    
                          <!-- <input type="text" id="from_time" name="from_time" class="timepicker" value="<?php echo !empty($from_time)?$from_time:'' ?>" size="10">          -->
                </td>
                <td>
                         End Date : 
                </td>
                <td>
                          <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true"> 
                          <!-- <input type="text" id="to_time" name="to_time" class="timepicker" value="<?php echo !empty($to_time)?$to_time:'' ?>" size="10">        -->
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

                      Non Movable Brands Report
              
                </h3>
          <div class="row">
<?php
if(empty($export)){  
?>
                <div class="col-md-9" id="success">
                         <?php  
                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
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
                                <th class="font_th"><a href="#">Brand</a></th>
                                <th class="font_th"><a href="#">Selling Unit</a></th>
                                <th class="font_th"><a href="#">Tablets/Pack</a></th>
                                <th class="font_th"><a href="#">Strip/Pack</a></th>
                                <th class="font_th"><a href="#">Price Type</a></th>
                                <th class="font_th"><a href="#">SellP</a></th>
                                <th class="font_th"><a href="#">BuyP</a></th>
                                <th class="font_th"><a href="#">Main Stock</a></th>
                                <th class="font_th"><a href="#">Branch Stock</a></th>
                                <th class="font_th"><a href="#">Reorder Level</a></th>
                                <!-- <th class="font_th DONTPrint"><a href="#">Action</a></th> -->
        
                        
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
                                        <td><?php echo display_in_pack($brand[$i][13],$brand[$i][14],$brand[$i][15]);;?></td>
                                        <td><?php echo display_in_pack($brand[$i][20],$brand[$i][21],$brand[$i][22]);;?></td>
                                        <td><?php echo $brand[$i][16];?></td>
                                        
                                      
                                        
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
  
 

$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker();

  /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#non_movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/non_movement_report");
                 $("#non_movement_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#non_movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/non_movement_report");
                 $("#non_movement_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#non_movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/non_movement_report");
                 $("#non_movement_report").submit();
    });

});
   
   function searchForm(){
      
      $("#current_page").val('');
      document.non_movement_report.action="<?php echo base_url(); ?>index.php/reports/non_movement_report";
      document.non_movement_report.submit();

    }
    function clearForm(){

        window.location = "<?php echo site_url('reports/non_movement_report'); ?>";
        return false;

    }
    function printForm() {
       
        window.print();

    }
    function exportNonMovement(){

         window.open('<?php echo base_url(); ?>index.php/reports/non_movement_report/export');

    }

</script>
