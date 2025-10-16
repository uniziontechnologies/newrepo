<?php
      $this->load->view("header");
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
        color: #006633;   
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
        font-size: 12px;
       }    
   }

</style>

<form name="batch_report" id="batch_report" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  BATCH REPORT - <?php if (!empty($brand_name)) {
                    echo $brand_name;
                  } ?>
            </h1>
           
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

                <td style="text-align: right;">

                        Show Stock From : 
                </td>
                <td>
                        <select name="branch" id="branch" onkeypress="nextField(event.keyCode,Search);" onchange="select_branch();">
                            <option value="">----------</option>
                            <option value="main_branch" <?php if (!empty($branch) && $branch =="main_branch" ) {
                                echo "selected";
                            } ?>>Main Branch</option>
                            <?php
                                if (!empty($branchInfo)) {

                                    for ($i=0; $i <count($branchInfo) ; $i++) { ?>
                                        <option value="<?php echo $branchInfo[$i][0] ?>" <?php if (!empty($branch) && $branch ==$branchInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $branchInfo[$i][1]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>



            </tr>
<!--             <tr>

                           <td colspan="12" align="center">
                              <button type="button" class="btn btn-info margin_10" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>
                              <button type="button" class="btn btn-danger margin_10" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                              </button>
                           </td>
            </tr> -->
                   
                  </table>
               </div><!--boxbody-->
              </div><!--boxinfo-->
            </div><!--col-md-12-->
          </div> <!--row-->

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                         <div id="print_details"><?php  

                           echo "<h4>Batch Report - ".$brand_name."</h4>"."<br>";

                             ?>
                        
                         </div>
                    <div class="box-body">
                          <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                          </div>

                    <table width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                  <th>Sl No</th>
                  <th><?php echo $this->lang->line('batch');?></th>                 
                  <th><?php echo $this->lang->line('expiry_date');?></th>
                  <th><?php echo $this->lang->line('quantity');?></th>
                  <th><?php echo $this->lang->line('price_type');?></th>
                  <th><?php echo $this->lang->line('sellp');?></th>
                  <th><?php echo $this->lang->line('buyp');?></th>                   
                  <th><?php echo $this->lang->line('supplier');?></th>
                  <th><?php echo $this->lang->line('branch');?></th>
        
                        
                            </tr>
                        </thead>
              <tbody>
              
              <?php 
                if(!empty($batch)){           
                    $j=1;
                  for($i=0;$i<count($batch);$i++) {?>
                      <tr>
                        <td><?php echo $j++;?></td>
                        <td><?php echo $batch[$i][2];?></td>
                        <td><?php echo $batch[$i][3];?></td>
                        <td><?php echo $batch[$i][4];?></td>
                        <td><?php echo $batch[$i][5];?></td>
                        <td><?php echo $batch[$i][6];?></td>
                        <td><?php echo $batch[$i][7];?></td>
                        <td><?php echo $batch[$i][9];?></td>
                        <td><?php echo empty($batch[$i][13])?"Main Branch":$batch[$i][13];?></td>
                        
                        
                        
                        
                      </tr>
            <?php     
                }
              }
                
                ?>
              
              </tbody>         
                    </table>

                        <div align="center"> 

                            <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printForm()">

                        </div>

                
                    </div>
                </div>
            </div>
            </div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
    <input type="hidden" name="bill_id" id="bill_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value="">      
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
  
  $j('.timepicker').wickedpicker({now: '00:00', twentyFour: true, title:
                    'Choose Time', showSeconds: true});   

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

});
   
   function searchForm(){
      
      document.invoice_report.action="<?php echo base_url(); ?>index.php/reports/invoice_report";
      document.invoice_report.submit();

    }

    function clearForm(){

       $("#from_date").val('');
       $("#end_date").val('');
       $("#customer_type").val('');
       $("#customer_id").val('');
       $("#user_id").val('');
       $("#payment_type").val('');
       $("#from_time").val('');
       $("#to_time").val('');
       $("#user_type").val('');

    }
    function printInvoice(id) {
            
            $('#bill_id').val(id);
            $('#from_path').val("invoice_report");
            document.invoice_report.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
            document.invoice_report.submit();
            
    }
    function viewInvoice(id) {
            

            $('#bill_id').val(id);
            $('#from_path').val("invoice_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/invoice/print_invoice/"+$('#bill_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.invoice_report.action='<?php echo base_url(); ?>index.php/reports/invoice_report';
        document.invoice_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function select_branch(){

      
        document.batch_report.action='<?php echo base_url(); ?>index.php/reports/batch_report/'+<?php echo $brand_id;?>;
          document.batch_report.submit();
      
    }
</script>
