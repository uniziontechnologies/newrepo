<?php

  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=expiry-report.xls');
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
   }
   .text_right{
      text-align: right;
   }
   .table_style{
      /*width: 60%;*/
      /*margin: 0 auto;*/
   }

</style>

<form name="expired_medicines_report" id="expired_medicines_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  MEDICINE EXPIRY REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportExpiry()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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

                <td class="text_right">
                        Brand :
                </td>
                <td>

                    <input name="brand" id="brand" tabbindex="2" onkeypress="if(event.keyCode== 13){searchForm();}" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" value="<?php echo !empty($brand_name)?$brand_name:'' ?>">
                    
                    <input type="hidden" id="brand_hidden" name="brand_ID" value="<?php echo !empty($brand_id)?$brand_id:'' ?>">


                </td>
                <td class="text_right">
                        Batch :
                </td>
                <td>

                    <input name="batch_no" id="batch_no" value="<?php echo !empty($batch_no)?$batch_no:'' ?>" onkeypress="if(event.keyCode== 13){searchForm();}" >


                </td>
                <td class="text_right">
                        Expiry Date :
                </td>
                <td>

                    <input type="text" name="expired_date" id="expired_date" value="<?php echo !empty($expired_date)?$expired_date:'' ?>">


                </td>
                <td class="text_right">

                        Branch : 
                </td>
                <td>
                        <select name="branch" id="branch" onkeypress="nextField(event.keyCode,Search);" onchange="searchForm();">
                            <option value="">----------</option>
                            <option value="main_branch" <?php if (isset($branch_selected) && $branch_selected =="main_branch" ) {
                                echo "selected";
                            } ?>>Main Branch</option>
                            <?php
                                if (!empty($branchInfo)) {

                                    for ($i=0; $i <count($branchInfo) ; $i++) { ?>
                                        <option value="<?php echo $branchInfo[$i][0] ?>" <?php if (!empty($branch_selected) && $branch_selected ==$branchInfo[$i][0] ) {
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

                      MEDICINE EXPIRY REPORT
              
                </h3>
          <div class="row">
<?php
if(empty($export)){  
?>
                <div class="col-md-9" id="success">

                          <?php  
                            if (!empty($brand_name)) {
                                echo "Brand : ".$brand_name;
                             }
                            if (!empty($batch_no)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Batch : ".$batch_no;
                             }
                            if (!empty($expired_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Expiry Date : ".$expired_date;
                             }
                            if (!empty($branch_selected_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Branch : ".$branch_selected_name;
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
                              <th class="font_th"><a href=""><?php echo "Sl No"; ?></a></th>
                              <th class="font_th"><a href=""><?php echo "Brand";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Batch";?></a></th>                 
                              <th class="font_th"><a href=""><?php echo "Expiry Date";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Stock";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Price Type";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Sellp";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Buyp";?></a></th>                          
                              <th class="font_th"><a href=""><?php echo "Supplier";?></a></th>
                              <th class="font_th"><a href=""><?php echo "Branch";?></a></th>
                            </tr>
                        </thead>
                          <tbody>
                          
                          <?php 
                            if(!empty($batch)){           
                                $j= !empty($next_page)?$next_page+1:1;
                              for($i=0;$i<count($batch);$i++) {?>
                                  <tr>
                                    <td style="text-align: left !important;"><?php echo $j++;?></td>
                                    <td><?php echo $batch[$i][14];?></td>
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
  
  $("#expired_date").datepicker();

$(document).ready(function(){

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#expired_medicines_report").attr("action","<?php echo base_url(); ?>index.php/reports/expired_medicines_report");
                 $("#expired_medicines_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#expired_medicines_report").attr("action","<?php echo base_url(); ?>index.php/reports/expired_medicines_report");
                 $("#expired_medicines_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#expired_medicines_report").attr("action","<?php echo base_url(); ?>index.php/reports/expired_medicines_report");
                 $("#expired_medicines_report").submit();
    });

  });
   
   function searchForm(){
      
      $("#current_page").val('');
      document.expired_medicines_report.action="<?php echo base_url(); ?>index.php/reports/expired_medicines_report";
      document.expired_medicines_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/expired_medicines_report'); ?>";
        return false;

    }
    function printForm() {
       
        window.print();

    }
    function select_branch(){

        document.expired_medicines_report.action='<?php echo base_url(); ?>index.php/reports/expired_medicines_report/';
        document.expired_medicines_report.submit();
      
    }
    function exportExpiry(){
  
        window.open('<?php echo base_url(); ?>index.php/reports/expired_medicines_report/export');
  

    }
</script>
