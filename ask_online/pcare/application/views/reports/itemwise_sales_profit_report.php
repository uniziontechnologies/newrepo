<?php
      
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=itemwise_sales_profit-report.xls');
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

<form name="itemwise_profit_report" id="itemwise_profit_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1 class="main_heading">
                  ITEMWISE SALES PROFIT REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportItemwiseprofit()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                          <input type="text" name="from_date" id="from_date"  value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true">             
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
                      <input type="hidden" id="batch_hidden" name="batch_ID" >
                         
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
  <table width="80%" >
                <thead>
                    <tr>
                         <th ><a href="#"></a></th>
                    </tr>
                </thead>
                <tbody id="show_total">
                    
                </tbody>
                </table>
      <div class="col-md-12 DONTPrint" align="right" >
<?php
                if(empty($export)){ 

                   echo $pagination_link;
                }
?>
          </div> <!--row-->
                <h3 id="print_details">

                      Itemwise sales Profit Report
              
                </h3>
                <div id="success">
                        <?php

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                            }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                            }
                         if(!empty($brand_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brand : ".$brand_name;
                            }
                            
                        ?>
                        
              </div>
                  </div><br>
                 
        

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Brand</a></th>
                               <!--   <th class="font_th"><a href="#">Batch</a></th>
                              -->
                              
                                  <th class="font_th"><a href="#">Net Sales</a></th>
                               
                                 <th class="font_th"><a href="#">Tot Sellp</a></th>
                                  <th class="font_th"><a href="#">Tot buyp</a></th>
                                   <th class="font_th"><a href="#">Tot gst</a></th>
                                <th class="font_th"><a href="#">Profit</a></th>                    
                            </tr>
                        </thead>
                          <tbody>
                          
                       <?php
                         $total_qty=0;
                         $selp=0;
                         $t_gst =0;
                         $t_buy_p=0;
                         $prfit  =0;
                         $total_profit=0;

                            $j=1;

                           if(!empty($sales)){            
                                $j= !empty($next_page)?$next_page+1:1; 
                              
                              for($i=0;$i<count($sales);$i++) {?>
                                  <tr>
                                  <td><?php echo $j++;?></td>
                                  <td><?php echo $sales[$i][1];?></td> 

                                 <!--  <td><?php //echo $sales[$i][3];?></td>  -->
                               
                                  <td><?php echo !empty($total_quantity[$i])?$total_quantity[$i]:0;?></td>
                            
                                  <td><?php echo !empty($sellp[$i])?$sellp[$i]:0;?></td>
                                 
                                  <td><?php echo !empty($tot_buy_p[$i])?$tot_buy_p[$i]:0;?></td>

                                  <td><?php echo !empty($tot_gst[$i])?$tot_gst[$i]:0;?></td>
                                  
                                   <td><?php echo !empty($profit[$i])?$profit[$i]:0;?></td>
                                  </tr>
                        <?php 

                       
                            $total_profit +=$profit[$i];
          
                                  
                           }

                         }
                            
                           
                            ?>
                          

                        <tr>
                         <td colspan="2" align="right"style=" font-size: large;font-weight: 300;padding-top: 30px;
                          padding-bottom: 30px;text-align: center;">Total</td>
                            
                            <td style=" font-size: large;font-weight: 300;padding-top: 30px;
                             padding-bottom: 30px;"><b>

                    


 
                            <?php if (!empty($prev_gross_sales)) {
                              echo $prev_gross_sales;
                            }else{echo !empty($total_qty);}?></b></td>


                            <td style=" font-size: large;font-weight: 300;padding-top: 30px;
                             padding-bottom: 30px;"><b>

                            <?php if (!empty($prev_sellp)) {
                              echo $prev_sellp;
                            }else{echo $selp;}?></b></td>


                            <td style=" font-size: large;font-weight: 300;padding-top: 30px;
                            padding-bottom: 30px;"><b>

                            <?php if (!empty($prev_buyp)) {
                              echo $prev_buyp;
                            }else{echo $t_buy_p;}?></b></td>


                            <td style=" font-size: large;font-weight: 300;padding-top: 30px;
                            padding-bottom: 30px;"><b>

                            <?php if (!empty($prev_gst)) {
                              echo $prev_gst;
                            }else{echo $t_gst;}?></b></td>


                            <td style=" font-size: large;font-weight: 300;padding-top: 30px;
                            padding-bottom: 30px;"><b>

                             <?php if (!empty($prev_net)) {
                              echo $prev_net;
                            }else{echo $prfit;}?></b></td> 

                            
                          </tr>
                            
                          </tbody>      
                    </table>


                       
<?php
if(empty($export)){
?>
 

<h3 align="center" style="font-style: initial;font-weight: 800;font: bold;">TOTAL PROFIT : <?php if (!empty($prev_net)) {
                              echo $prev_net;
                            }else{echo round($prfit, 2);}?> </h3> 

  <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">

  <input type="hidden" name="prev_gross_sales" id="prev_gross_sales" value="<?php echo(!empty($prev_gross_sales))?$prev_gross_sales:''; ?>">


  <input type="hidden" name="prev_net" id="prev_net" value="<?php echo(!empty($prev_net))?$prev_net:''; ?>">

   <input type="hidden" name="prev_sellp" id="prev_sellp" value="<?php echo(!empty($prev_sellp))?$prev_sellp:''; ?>">

   <input type="hidden" name="prev_buyp" id="prev_buyp" value="<?php echo(!empty($prev_buyp))?$prev_buyp:''; ?>">

   <input type="hidden" name="prev_gst" id="prev_gst" value="<?php echo(!empty($prev_gst))?$prev_gst:''; ?>">

   <input type="hidden" name="total_profit" id="total_profit" value="<?php echo $total_profit;?>"/>





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

     var new_row="<tr><td><b>TOTAL PROFIT:&nbsp;&nbsp;"+$('#total_profit').val()+"</b></td></tr>";
          $( "#show_total" ).append(new_row);


     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#itemwise_profit_report").attr("action","<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report");
                 $("#itemwise_profit_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#itemwise_profit_report").attr("action","<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report");
                 $("#itemwise_profit_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#itemwise_profit_report").attr("action","<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report");
                 $("#itemwise_profit_report").submit();
    });

});
   
   function searchForm(){
      
      document.itemwise_profit_report.action="<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report";
      document.itemwise_profit_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/itemwise_sales_profit_report'); ?>";
        return false;

    }
    function printInvoice(id) {
            
            $('#purchase_id').val(id);
            $('#from_path').val("invoice_report");
            document.itemwise_profit_report.action='<?php echo base_url(); ?>index.php/purchase/print_invoice';
            document.itemwise_profit_report.submit();
            
    }
    function viewInvoice(id) {
            

            $('#purchase_id').val(id);
            $('#from_path').val("invoice_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/purchase/print_invoice/"+$('#purchase_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.itemwise_profit_report.action='<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report';
        document.itemwise_profit_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportItemwiseprofit(){

       document.itemwise_profit_report.action="<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report/export";
       document.itemwise_profit_report.submit(); 

    }

</script>
