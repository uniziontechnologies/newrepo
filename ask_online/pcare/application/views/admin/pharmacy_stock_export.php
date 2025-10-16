<?php
$branch_id=$this->session->userdata('branch_id');
$login_user_type=$this->session->userdata('user_type');

if(empty($export)){
$this->load->view("header");
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
</style>
<form name="pharmacy_stock_export" id="pharmacy_stock_export" method="post" action="">
  <div class="container"  id="content">
    <?php
    if(empty($export)){
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      BATCH STOCK REPORT
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
                    Expiry Date :
                  </td>
                  <td>
                    <input type="text" name="expiry_date" id="expiry_date" value="<?php echo !empty($expiry_date)?$expiry_date:'' ?>" autocomplete="off" readonly="true">
                  </td>
                  <td>
                    Brand Name :
                  </td>
                  <td>
                    <input name="brand" id="brand" tabbindex="2" value="<?php echo !empty($brand)?$brand:'' ?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
                    <input type="hidden" id="brand_hidden" name="brand_ID" value="<?php echo !empty($brand_ID)?$brand_ID:'' ?>" >
                    
                  </td>
                  <td>
                    Batch Name :
                  </td>
                  <td>
                    <input type="text" name="batch" id="batch" value="<?php echo !empty($batch)?$batch:'' ?>" autocomplete="off">
                    
                  </td>
              
                  <td>
                    Supplier :
                  </td>
                  <td>
                    <select name="supplier" id="supplier" onkeypress="nextField(event.keyCode,Search);">
                      <option value="">----------------</option>
                      <?php
                      if (!empty($suppliers)) {
                      for ($i=0; $i <count($suppliers) ; $i++) { ?>
                      <option value="<?php echo $suppliers[$i][0] ?>" <?php if (!empty($supplier) && $supplier ==$suppliers[$i][0] ) {
                        echo "selected";
                      } ?>><?php echo $suppliers[$i][1]; ?></option>
                      <?php
                      }
                      
                      }
                      ?>
                    </select>
                    
                  </td>

                   <td>
                    Branch :
                  </td>
                  <td>
                    <select name="branch" id="branch" onkeypress="nextField(event.keyCode,Search);">
                      <option value="">----------------</option>
                       <option value="MAIN STOCK" <?php echo ($branch == 'MAIN STOCK')?'selected' :'';?>>MAIN STOCK</option>
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
                <tr>
                  <td colspan="8" align="center">
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
             Supplier wise Batch Stock Report           
              </h3>
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
                            <th class="font_th"><a href="#">Batch Stock</a></th>
                            <th class="font_th"><a href="#">Price Type</a></th>
                            <th class="font_th"><a href="#">Sellp</a></th>
                            <th class="font_th"><a href="#">Buyp</a></th>
                           <!--  <th class="font_th"><a href="#">ptr</a></th>
                            <th class="font_th"><a href="#">pcost</a></th> -->
                            <th class="font_th"><a href="#">Gst%</a></th>
                            <th class="font_th"><a href="#">Gst Amt</a></th>
                            <th class="font_th"><a href="#">Total Gst Amt</a></th>
                            <th class="font_th"><a href="#">Cgst%</a></th>
                            <th class="font_th"><a href="#">Cgst Amt</a></th>
                            <th class="font_th"><a href="#">Total Cgst Amt</a></th>
                            <th class="font_th"><a href="#">Sgst%</a></th>
                            <th class="font_th"><a href="#">Sgst Amt</a></th>
                            <th class="font_th"><a href="#">Total Sgst Amt</a></th>
                           
                            <th class="font_th"><a href="#">Supplier Name</a></th>
                            <th class="font_th"><a href="#">Branch</a></th>

                                                      
                          </tr>
                        </thead>
                        <tbody>
                          
                          <?php
                          if(!empty($batchInfo)){
                          $j= !empty($next_page)?$next_page+1:1;
                          for($i=0;$i<count($batchInfo);$i++) {?>
                          <tr>
                            <td style="text-align: left !important;"><?php echo $j++; ?></td>
                            <td><?php echo $batchInfo[$i][14];?></td>
                            <td><?php echo $batchInfo[$i][2];?></td>
                            <td><?php echo date('d-m-Y',strtotime($batchInfo[$i][3]));?></td>
                            <td><?php echo $batchInfo[$i][4];?></td>
                            <td><?php echo $batchInfo[$i][5];?></td>
                            <td><?php echo $batchInfo[$i][6];?></td>
                            <td><?php echo $batchInfo[$i][7];?></td>
                           <!--  <td><?php// echo $batchInfo[$i][7];?></td>
                            <td><?php// echo $batchInfo[$i][19];?></td> -->
                            <td><?php echo $batchInfo[$i][18];?></td>
                            <td><?php echo $batchInfo[$i][21];?></td>
                            <td><?php echo $batchInfo[$i][24];?></td>
                            <td><?php echo $batchInfo[$i][20];?></td>
                            <td><?php echo $batchInfo[$i][23];?></td>
                            <td><?php echo $batchInfo[$i][26];?></td>
                            <td><?php echo $batchInfo[$i][19];?></td>
                            <td><?php echo $batchInfo[$i][22];?></td>
                            <td><?php echo $batchInfo[$i][25];?></td>
                           
                            <td><?php echo $batchInfo[$i][9];?></td>
                            <td><?php echo !empty($batchInfo[$i][28])?$batchInfo[$i][28]:"MAIN STOCK";?></td>
                            
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
              
              $('#expiry_date').datepicker();
              
              
              /*......pagination......*/
              
              $(".next_page").bind('click', function() {
              var current_page= $("#current_page").val();
              current_page++;
              $("#current_page").val(current_page);
              $("#pharmacy_stock_export").attr("action","<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export");
              $("#pharmacy_stock_export").submit();
              });
              $(".prev_page").bind('click', function() {
              
              var current_page= $("#current_page").val();
              current_page--;
              $("#current_page").val(current_page);
              $("#pharmacy_stock_export").attr("action","<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export");
              $("#pharmacy_stock_export").submit();
              });
              $(".change_page").bind('click', function() {
              
              var current_page= $(this).attr("id");
              $("#current_page").val(current_page);
              $("#pharmacy_stock_export").attr("action","<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export");
              $("#pharmacy_stock_export").submit();
              });
              });
              
              function searchForm(){
              
              $("#current_page").val('');
              $("#pharmacy_stock_export"). removeAttr("target");
              document.pharmacy_stock_export.action="<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export";
              document.pharmacy_stock_export.submit();
              }
              function clearForm(){
              window.location = "<?php echo site_url('admin/pharmacy_stock_export'); ?>";
              return false;
              }
              function printForm() {
              
              window.print();
              }
              function exportInvoice(){ 
              
              $("#current_page").val('');
              document.pharmacy_stock_export.action="<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export/export";
              document.pharmacy_stock_export.submit();
              }
              </script>