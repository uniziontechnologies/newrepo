<?php
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

      font-size: 15px;
   }
   #success{
        padding-top: 15px;
        font-size: 14px;   
   }  
   #print_details{
    display: none;
   }
   @media print{
       #print_details{
        display: block;
        margin-left: 20px;
       }    
   }
</style>

<form name="daily_stock_report" id="daily_stock_report" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  DAILY STOCK REPORT
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $delete_msg = $this->session->flashdata('delete_msg'); 
                        if(!empty($delete_msg)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $delete_msg; ?></div>
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
                    <button type="button" class="btn btn-info" onclick="searchForm()"><span class="glyphicon glyphicon-search"></span> Search</button>
                    <button type="button" class="btn btn-danger" onclick="clearForm()"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                </td>

            </tr>
                   
          </table>
         </div><!--boxbody-->
        </div><!--boxinfo-->
      </div><!--col-md-12-->
      </div> <!--row-->
      <div class="row">
            <h3 id="print_details">

                    DAILY STOCK REPORT
              
            </h3>
            <div class="col-md-9" id="success">
              <?php

                if (!empty($from_date)) {
                    echo " From date : ".$from_date;
                }

                if (!empty($end_date)) {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                }
                             
              ?> 
            </div>
            <div class="col-md-3 DONTPrint">

            </div>
      </div>

      <div class="row">
       <div class="col-md-12">
        <div class="box box-info">
                         
                    <div class="box-body">
                  <div id="pagination" align="right">
                              <!-- <?php //echo $this->pagination->create_links(); ?> -->
                          </div>
             <table width="100%" class="table table-striped table-bordered">

              <tr>
                    <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Main Stock</a></th>
                    <th class="font_th"><a href="#">Total SellP(Main Stock)</a></th>
                    <th class="font_th"><a href="#">Total BuyP(Main Stock)</a></th>
                    <th class="font_th"><a href="#">Branch Stock</a></th>
                    <th class="font_th"><a href="#">Total SellP(Branch Stock)</a></th>
                    <th class="font_th"><a href="#">Total BuyP(Branch Stock)</a></th>



                </tr>
    <?php        
                if(!empty($stockInfo)){            
                  $j = 1;
            for($i=0;$i<count($stockInfo);$i++) {
    ?>            
                <tr>
                    <td><?php echo $j++; ?></td>
                        
                    <td><?php echo date("d-m-Y",strtotime($stockInfo[$i][0]));?></td>
                    <td><?php echo $stockInfo[$i][1];?></td>
                    <td><?php echo $stockInfo[$i][2];?></td>
                    <td><?php echo $stockInfo[$i][3];?></td>
                    <td><?php echo $stockInfo[$i][4];?></td>
                    <td><?php echo $stockInfo[$i][5];?></td>
                    <td><?php echo $stockInfo[$i][6];?></td>
                </tr>
    <?php
                }
            }
    ?>         
             </table>
             <br>
             <div align="center"> 

                <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printForm()">

             </div>
                       
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
$(function () {

    //Date range picker
    $('#from_date').datepicker();
    $('#end_date').datepicker();
     
});

function searchForm(){
      
    document.daily_stock_report.action="<?php echo base_url(); ?>index.php/reports/daily_stock_report";
    document.daily_stock_report.submit();

}

function clearForm(){

    window.location = "<?php echo site_url('reports/daily_stock_report'); ?>";
    return false;

}

function printForm() {
       
    window.print();

}



</script>