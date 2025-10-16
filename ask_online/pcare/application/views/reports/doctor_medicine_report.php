<?php
     
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=doctor-medicine-report.xls');
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

<form name="doctor_medicine_report" id="doctor_medicine_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  DOCTOR MEDICINE REPORT
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

                        Brand : 
                </td>
                <td>

                      <input type="text" name="brand" id="brand" tabbindex="2" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" value="<?php echo !empty($brand_name)?$brand_name:'' ?>" style="width:300px">
           
                      <input type="hidden" id="brand_hidden" name="brand_ID" value="<?php echo !empty($brand_ID)?$brand_ID:'' ?>">
                      <!-- <input type="hidden" id="batch_hidden" name="batch_ID" > -->
                         
                </td>
                   <td>
                      Doctor : 
                </td>
                <td colspan="2">
                      <select name="doctor" id="doctor" style="width:300px">
                           <option value=''>------------------------------</option>


                           <?php for($i=0;$i<count($doctors);$i++){ 
                                                                                        
                                                    if(!empty($doctor) && $doctor==$doctors[$i][0]) { 
                                                    
                                                    ?>
                                                    
                                                        <option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
                                        <?php       }else {?>
                                        
                                                        <option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
                                                
                                        <?php       } 
                                                } ?>
                            
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

                          Doctor Medicine Report
              
               </h3>
          <div class="row">

              <div class="col-md-9" id="success">
                        <?php

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                             }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                             }
                            if (!empty($brand_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Brand : ".$brand_name;
                             }
                            if (!empty($doctor_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Doctor : ".$doctor_name;
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
                                <th class="font_th"><a href="#"><?php echo "Sl No"; ?></a></th>
                                <th class="font_th"><a href="#"><?php echo "Bill No"; ?></a></th>
                                 <th class="font_th"><a href="#">Cust Type</a></th>
                                 <th class="font_th"><a href="#">Op/Ip No</a></th>
                                <th class="font_th"><a href="#"><?php echo "Customer Name"; ?></a></th>
                                <th class="font_th"><a href="#"><?php echo "Doctor"; ?></a></th>
                                <th class="font_th"><a href="#"><?php echo "Bill Date"; ?></a></th>
                                 <th class="font_th"><a href="#"><?php echo "Mode"; ?></a></th>
                                 <th class="font_th"><a href="#"><?php echo "Brand"; ?></a></th>
                                <th class="font_th"><a href="#"><?php echo "Batch"; ?></a></th>
                                 <th class="font_th"><a href="#"><?php echo "Expiry"; ?></a></th>
                               <th class="font_th"><a href="#"> <?php echo "Qty"; ?>; </a></th>
                                 <th class="font_th"><a href="#">MRP</a></th>
                                 <th class="font_th"><a href="#"><?php echo "Total"; ?></a></th>

    
                        
                            </tr>
                        </thead>
                        <tbody>
                        <?php
            if(!empty($medicine_list)){
             $j= !empty($next_page)?$next_page+1:1;
                for($i=0;$i<count($medicine_list);$i++) {?>
                        
                            <tr>
                            <td style="text-align: left !important;"><?php echo $j++; ?>
                                
                            </td>
                            <td><?php echo $medicine_list[$i][0];?></td>
                            <td><?php echo $medicine_list[$i][1];?></td>
                            <?php if($medicine_list[$i][1] == "OP"){?>
                            <td><?php echo $medicine_list[$i][20];?></td>
                        <?php }elseif ($medicine_list[$i][1] == "IP") {?>
                             <td><?php echo $medicine_list[$i][21];?></td>
                        <?PHP }else{?>
                            <td></td>
                        <?php }?>
                            <td><?php echo $medicine_list[$i][4];?></td>
                            <td><?php echo $medicine_list[$i][2];?></td>
                            <td><?php echo $medicine_list[$i][6];?></td>
                            <td><?php echo $medicine_list[$i][9];?></td>
                            <td><?php echo $medicine_list[$i][19];?></td>
                            <td><?php echo $medicine_list[$i][10];?></td>
                            <td><?php echo $medicine_list[$i][12];?></td>
                            <td><?php echo $medicine_list[$i][14];?></td>
                            <td><?php echo $medicine_list[$i][16];?></td>
                            <td><?php echo $medicine_list[$i][18];?></td>
                        </tr>

        <?php   }
            
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
    $(".timepicker").timepicker({showInputs: false,defaultTime: false});

  

  


  /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#doctor_medicine_report").attr("action","<?php echo base_url(); ?>index.php/reports/doctor_medicine_report");
                 $("#doctor_medicine_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#doctor_medicine_report").attr("action","<?php echo base_url(); ?>index.php/reports/doctor_medicine_report");
                 $("#doctor_medicine_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#doctor_medicine_report").attr("action","<?php echo base_url(); ?>index.php/reports/doctor_medicine_report");
                 $("#doctor_medicine_report").submit();
    });


});
   
   function searchForm(){
    var brand=$("#brand").val();
    if(brand == ""){
        $("#brand_hidden").val('');

    }
      
      $("#current_page").val('');
      $("#doctor_medicine_report"). removeAttr("target");
      document.doctor_medicine_report.action="<?php echo base_url(); ?>index.php/reports/doctor_medicine_report";
      document.doctor_medicine_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/doctor_medicine_report'); ?>";
        return false;

    }
 
 

    function printForm() {
       
        window.print();

    }
    function exportInvoice(){
        
        $("#current_page").val('');
        document.doctor_medicine_report.action="<?php echo base_url(); ?>index.php/reports/doctor_medicine_report/export";
        document.doctor_medicine_report.submit();
    }

</script>
