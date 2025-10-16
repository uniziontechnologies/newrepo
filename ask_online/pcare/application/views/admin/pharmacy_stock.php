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
  ul.list_style {
      padding-left: 15px;
  }
  ul.list_style li {
    line-height: 25px;
    font-size: 15px;
    font-weight: 400;
  }
</style>

<form name="manage_customer" id="manage_customer" method="post" action="" enctype="multipart/form-data">

    <div class="container"  id="content">

            <div class="row">

                <div class="col-md-6">

                  <input type="button" name="details" id="details" class="btn btn-success" value="Import History" style="    margin-top: 8px;" onclick="show_history();" />
                </div>
                

                <div class="col-md-6 text-right">

                    <a href="<?php echo base_url(); ?>application/assets/dist/unizion_format.xlsx" class="btn btn-success" download><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%">&nbsp;&nbsp;Download Sample Format</a>

                </div>

            </div>

          <!-- Main content -->
          <section class="content">

                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $delete_success = $this->session->flashdata('delete_success'); 
                         $error_detected = $this->session->flashdata('error_detected');

                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>
                        <?php
                            }
                        if(!empty($delete_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo $delete_success; ?></div>
                        <?php
                            }

                            if (!empty($error_detected)) {
                              
                              for ($i=0; $i < count($error_detected) ; $i++) { ?>
                                  
                                  <b><div id='message' class="callout callout-danger" style="font-size: 15px !important;margin: 0 0 15px 0 !important;padding: 5px 5px 5px 5px !important;"><?php echo $error_detected[$i]; ?></div></b>

                              <?php
                              }

                            }


                        ?>

        <div class="row">

          <div class="col-md-12">

            <div class="box box-info">
                
              <div class="box-body">

                <div class="container" align="center">
                 <h3 >Import Excel Stock to Pharmacy Stock</h3><br />
                 <form method="post" enctype="multipart/form-data">
                  <!-- <label>Select Excel File</label> -->
                  <input type="file" name="excel" id="excel" /><br><div style="margin-top: -5px;margin-left: -135px;"><label>Max File size : 10 MB</label></div>
                  <br />
                  <input type="button" name="import" id="import" class="btn btn-info" value="New Stock Import" style="margin-left: -11%;" />
                  <!-- &nbsp;&nbsp;<input type="button" name="clear_update" id="clear_update" class="btn btn-danger" value="Clear & Stock Update"/> -->
                  <br><br><br>
                   <div id ="emailSentLoading" style="display:none;text-align: center;">Processing.....Please wait !!!<br><img id = "myImage" src ="<?php echo base_url(); ?>application/assets/dist/img/loop_loader.gif"></div>
                 </form>
                 <br />
                 <br />
                 <?php
                 // echo $output;
                 ?>
                </div>

              </div><!--boxbody-->

            </div><!--boxinfo-->

          </div><!--col-md-12-->

        </div> <!--row-->




        <div class="row">

          <div class="col-md-12">

            <div class="box box-info">
                
              <div class="box-body">

                <div class="container">

                 <h4>Excel File used to import stock should meet the following requirements :</h4>

                 <ul class="list_style">
                   <li>Excel file format must be same as in sample format (You can download our format in right side top of the page)</li>
                   <!-- <li>File format allowed - xlsx, xls, csv</li> -->
                   <!-- <li>File size must be less than 10 MB</li> -->
                   <li>Donot merge cells in excel file</li>
                   <!-- <li>After pressing import button, should wait to complete processing. Donot close or refresh page</li> -->
                   <li>Brand name, Batch no, Expiry date, Supplier, Buyp, GST, MRP, Branch & Godown stock fields cannot be empty</li>
                   <li>Expiry date should enter in excel as dd-mm-yyyy format. It will show in as mm-yy format (Date format). <br>Eg :- If you ertered 01-05-2022 as date, it shows 05-22 in excel</li>
                   <li>if any of Buyp, MRP, GST, Branch stock, Godown stock is zero, should enter zero instead of blank column</li>
                   <li>Buyp, MRP, GST, Branch stock, Godown stock Must contain only numbers</li>
                 </ul>

                </div>

              </div><!--boxbody-->

            </div><!--boxinfo-->

          </div><!--col-md-12-->

        </div> <!--row-->



          </section><!-- /.content -->
    </div><!-- /.container -->
            
</form>    

<?php
    $this->load->view("footer"); 
?>

<script type="text/javascript">

$(document).ready(function(){
      
    $("#import").bind('click', function() {

        var ext = $('#excel').val().split('.').pop().toLowerCase();

        var fileExtension = ['xls', 'xlsx', 'csv'];

        if($.inArray(ext, fileExtension) == -1) {
          alert('invalid extension or no file to import !!');
          return false;
        }
        else if( document.getElementById("excel").files[0].size/1024/1024 > 10 ) {
          alert('File size must be less than 10 MB !!');
          return false;
        }
        else{

          var a = confirm("Please press ok to confirm !");

            if (a==true) {

             $("#import").attr('disabled',true);

             document.getElementById("emailSentLoading").style.display="block";
             
              $("#manage_customer").attr("action","<?php echo base_url(); ?>index.php/admin/pharmacy_stock_upload");
              $("#manage_customer").submit();
            }
            else{
              return false;
            }


        }



    });



});


    function show_history(){

        tb_show('IMPORT HISTORY',"<?php echo base_url(); ?>index.php/admin/show_history/1");
    }

    function tb_remove(){

        document.manage_customer.action='<?php echo base_url(); ?>index.php/admin/pharmacy_stock';
        document.manage_customer.submit();
    }


</script>