<?php
$branch_id=$this->session->userdata('branch_id');
$login_user_type=$this->session->userdata('user_type');

if(empty($export)){
$this->load->view("header");
}
if(!empty($export)){

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=Branch-stock-Consumables.xls');
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
select, input {
width: 120px;
}
@media print{
#print_details{
display: block;
margin-left: 20px;
}
}

.watermark {
    opacity: 0.2;
    color: BLACK;
    position: absolute;
    bottom: 0px;
    right: 38%;
    top: 59%;
    font-size: 44px;
}
</style>
<form name="branch_wise_stock_report" id="branch_wise_stock_report" method="post" action="">
  <div class="container"  id="content">
    <?php
    if(empty($export)){
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      BRANCH - CONSUMABLES
      </h1>
      <div style="text-align: right">
        <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportInvoice()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                    Brand Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <!--    </td>
                  <td > -->
                    <input name="brand" id="brand" tabbindex="2" value="<?php echo !empty($brand)?$brand:'' ?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" style="width: 200px;" >
                    <input type="hidden" id="brand_hidden" name="brand_ID" value="<?php echo !empty($brand_ID)?$brand_ID:'' ?>" >
                    
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Branch :
                  <!-- </td>
                  <td > -->
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="branch" id="branch" onkeypress="nextField(event.keyCode,Search);" style="width: 200px;">
                      <option value="">----------------</option>
                       
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
                    
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-info " onclick="searchForm()">
                    <span class="glyphicon glyphicon-search"></span> Search
                    </button>
                    <button type="button" class="btn btn-danger " onclick="clearForm()">
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
             Branch wise Stock Report           
              </h3>
               <?php  if(!empty($branch)){?>
              <div class="row">
                <div class="col-md-9" id="success">
                  <?php
                  if (!empty($expiry_date)) {
                  echo "Expiry date : ".$expiry_date;
                  }
                  

                  if (!empty($brand_name)) {
                   echo " Brand : ".$brand_name;
                  }
                  if (!empty($supplier_name)) {
                   echo " Supplier: ".$supplier_name;
                  }
                  if (!empty($branch_name)) {
                   echo " Branch : ".$branch_name;
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
                          <table width="100%" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="font_th"><a href="#">Sl No</a></th>
                            <th class="font_th"><a href="#">Brand</a></th>
                            <th class="font_th"><a href="#">Batch Number</a></th>
                            <th class="font_th"><a href="#">Expiry Date</a></th>
                            <th class="font_th"><a href="#">Supplier Name</a></th>
                            <th class="font_th"><a href="#">Branch</a></th>
                            <th class="font_th"><a href="#">Batch Stock</a></th>
                            <th class="font_th"><a href="#">Action</a></th>

                                                      
                          </tr>
                        </thead>
                        <tbody>
                          
                          <?php
                          if(!empty($batchInfo)){
                          $j= !empty($next_page)?$next_page+1:1;
                          for($i=0;$i<count($batchInfo);$i++) {
                             
                             // if($batchInfo[$i][12] != '1' &&  $batchInfo[$i][12] != '0' && $batchInfo[$i][12] != ''){

                            ?>
                          <tr>
                            <td style="text-align: left !important;"><?php echo $j++; ?></td>
                            <td><?php echo $batchInfo[$i][14];?></td>
                            <td><?php echo $batchInfo[$i][2];?></td>
                            <td><?php echo date('d-m-Y',strtotime($batchInfo[$i][3]));?></td>
                             <td><?php echo $batchInfo[$i][9];?></td>
                            <td><?php echo !empty($batchInfo[$i][28])?$batchInfo[$i][28]:"MAIN STOCK";?></td>
                            <td><?php echo $batchInfo[$i][4];?></td>
                            <td>

                        <input type="button" id="stock_adjust"  name="but" value="CONSUME" class="btn btn-primary DONTPrint" onclick="AdjustStock('<?php echo $batchInfo[$i][0]; ?>')">
                             
                              
                              
                            </button></td>  
                            
                          </tr>
                          <?php
                          }
                          }
                          // }
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
              <?php } else{?>

                  <div class="watermark">
                        Choose a Branch.....!
                  </div>

              <?php }?>
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
              
              $('#expiry_date').datepicker();
              
              
              /*......pagination......*/
              
              $(".next_page").bind('click', function() {
              var current_page= $("#current_page").val();
              current_page++;
              $("#current_page").val(current_page);
              $("#branch_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report");
              $("#branch_wise_stock_report").submit();
              });
              $(".prev_page").bind('click', function() {
              
              var current_page= $("#current_page").val();
              current_page--;
              $("#current_page").val(current_page);
              $("#branch_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report");
              $("#branch_wise_stock_report").submit();
              });
              $(".change_page").bind('click', function() {
              
              var current_page= $(this).attr("id");
              $("#current_page").val(current_page);
              $("#branch_wise_stock_report").attr("action","<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report");
              $("#branch_wise_stock_report").submit();
              });
              });
              
              function searchForm(){
              
              $("#current_page").val('');
              $("#branch_wise_stock_report"). removeAttr("target");
              document.branch_wise_stock_report.action="<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report";
              document.branch_wise_stock_report.submit();
              }
              function clearForm(){
              window.location = "<?php echo site_url('brand/branch_wise_stock_report'); ?>";
              return false;
              }
              function printInvoice(id) {
              
              $('#bill_id').val(id);
              $('#from_path').val("branch_wise_stock_report");
              $("#branch_wise_stock_report").attr("target", "_blank");
              document.branch_wise_stock_report.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
              document.branch_wise_stock_report.submit();
              
              }
              function viewInvoice(id) {
              
              $('#bill_id').val(id);
              $('#from_path').val("branch_wise_stock_report_popup");
              $("#branch_wise_stock_report"). removeAttr("target");
              tb_show('Bill Items',"<?php echo base_url(); ?>index.php/invoice/print_invoice/"+$('#bill_id').val()+"/"+$('#from_path').val());
              
              }
              function tb_remove(){
              
              // document.movement_form.item_focus.value='brand';
              document.branch_wise_stock_report.action='<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report';
              document.branch_wise_stock_report.submit();
              }
              function printForm() {
              
              window.print();
              }
              function exportInvoice(){ 
              
              $("#current_page").val('');
              document.branch_wise_stock_report.action="<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report/export";
              document.branch_wise_stock_report.submit();
              }
             
              function AdjustStock(id) {
               branch = $('#branch').val();
               brand = $('#brand_hidden').val();
              tb_show('Consumables',"<?php echo base_url(); ?>index.php/brand/stock_adjust_form/"+id+"/"+branch+"/"+brand);
   
             }




              </script>