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
  img.selected {
    position: absolute;
    right: 33%;
    bottom: 37%;
    width: 35%;
  }
</style>

<form name="manage_customer" id="manage_customer" method="post" action="" enctype="multipart/form-data">

    <div class="container"  id="content">

            <div class="row">

                <div class="col-md-6 col-lg-6">

                  <h2 style="padding-left: 20px;">PRINTER SETTINGS</h2>

                </div>

                <div class="col-md-6 col-lg-6 text-right">

                    <a href="<?php echo base_url(); ?>application/assets/dist/UNIZION_PRINTER_CONFIG.pdf" class="btn btn-info" download style="height: 36px;margin-top: 18px;">Download Printer Manual</a>

                </div>

            </div>

          <!-- Main content -->
          <section class="content" style="margin-top: -30px;">

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

                <div class="container" style="margin-top: 40px;">

                  

                  <div class="row">
                    
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
                        
                      <label style="font-size: 18px;">A4 PRINT</label>
                      <br>
                      <p style="font-size: 15px;font-weight: 400;">Printing in A4 size paper. size: 8.3 x 11.7 inches</p>
                      <!-- <br> -->
                      <img src="<?php echo base_url(); ?>application/assets/dist/img/a4.png" style="border: 5px solid #00c0ef;padding-bottom: 18px;">

                      <?php 

                        if (!empty($hospitalInfo[0][13]) && $hospitalInfo[0][13]==1 ) {?>

                          <img src="<?php echo base_url(); ?>application/assets/dist/img/selected.png" class="selected">

                      <?php
                        }

                      ?>

                      <br><br>
                      <button class="btn btn-danger lock_page" name="lock_page" value="1">LOCK FORMAT</button>

                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
                        
                      <label style="font-size: 18px;">DOT MATRIX PRINT - BASIC</label>
                      <br>
                      <p style="font-size: 15px;font-weight: 400;">Printing in Dot matrix size paper. size: 8 x 6 inches</p>
                      <!-- <br> -->
                      <img src="<?php echo base_url(); ?>application/assets/dist/img/dot_matrix.png" style="border: 5px solid #00c0ef;padding-top: 18px;">

                      <?php 

                        if (!empty($hospitalInfo[0][13]) && $hospitalInfo[0][13]==2 ) {?>

                          <img src="<?php echo base_url(); ?>application/assets/dist/img/selected.png" class="selected">

                      <?php
                        }

                      ?>

                      <br><br>
                      <button class="btn btn-danger lock_page" name="lock_page" value="2">LOCK FORMAT</button>

                    </div>


                  </div>



                  <div class="row" style="margin-top: 80px;">
                    
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
                        
                      <label style="font-size: 18px;">DOT MATRIX PRINT - ADVANCED</label>
                      <br>
                      <p style="font-size: 15px;font-weight: 400;">Printing in Dot matrix size paper. size: 10 x 6 inches</p>
                      <!-- <br> -->
                      <img src="<?php echo base_url(); ?>application/assets/dist/img/dot_matrix_two.png" style="border: 5px solid #00c0ef;padding-top: 18px;">

                      <?php 

                        if (!empty($hospitalInfo[0][13]) && $hospitalInfo[0][13]==3 ) {?>

                          <img src="<?php echo base_url(); ?>application/assets/dist/img/selected.png" class="selected">

                      <?php
                        }

                      ?>

                      <br><br>
                      <button class="btn btn-danger lock_page" name="lock_page" value="3">LOCK FORMAT</button>

                    </div>

                  </div>





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
      
    $(".lock_page").bind('click', function() {

      var lock_page = this.value;

      if (lock_page!="") {

          $("#manage_customer").attr("action","<?php echo base_url(); ?>index.php/admin/printer_settings_lock");
          $("#manage_customer").submit();

      }



    });



});


</script>