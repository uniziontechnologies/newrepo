<?php
     
      if(empty($export)){  
         $this->load->view("header");
     }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=daily-collection-pharma-report.xls');
  }

      $branch_id=$this->session->userdata('branch_id');
      $login_user_type=$this->session->userdata('user_type');

?> 
 
 <style>   
  .font_th{

        font-size: 15px;
        width: 50%;
   }
    .font_ths{

        font-size: 20px;
        width: 50%;
        font-weight: 800px;
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

<form name="bill_collection_report" id="bill_collection_report" method="post" action="">

    <div class="container"  id="content">
	
	<?php
if(empty($export)){  
?>

          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                <?php echo !empty($branch_select_name)?$branch_select_name:'ALL' ?> BRANCH DAILY COLLECTION REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportStock()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                        <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="5" value="<?php echo !empty($from_time)?$from_time:'' ?>"></span>   
                </td>
                <td>
                        End Date : 
                </td>
                <td>
                        <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true"> 
                        <span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="5" value="<?php echo !empty($to_time)?$to_time:'' ?>"></span>    
                </td>

            </tr>
            <tr>

                <td>

                        User Type : 
                </td>
                <td>
                        <select name="user_type" id="user_type" onchange="searchUserType()" >
                            <option value="">----------------</option>
                            <?php
                                if (!empty($userTypeInfo)) {

                                    for ($i=0; $i <count($userTypeInfo) ; $i++) { ?>
                                        <option value="<?php echo $userTypeInfo[$i][0] ?>" <?php if (!empty($user_type) && $user_type ==$userTypeInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $userTypeInfo[$i][1]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>

                <td>

                        User : 
                </td>
                <td>
                        <select name="user_id" id="user_id" onkeypress="nextField(event.keyCode,Search);">
                            <option value="">----------</option>
                            <?php
                                if (!empty($user_info)) {

                                    for ($i=0; $i <count($user_info) ; $i++) { ?>
                                        <option value="<?php echo $user_info[$i][0] ?>" <?php if (!empty($user_id) && $user_id ==$user_info[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $user_info[$i][2]; ?></option>
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
<?php } ?>

                <h3 id="print_details">

                          DAILY COLLECTION PHARMA REPORT
              
               </h3>

               <div id="success">
                        <?php

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                             }
                            if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                             }
                            if (!empty($user_type_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User Type : ".$user_type_name;
                             }
                            if (!empty($user_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : ".$user_name;
                             }


                        ?>
                        
                         </div>
 
          </div> <!--row-->

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table width="100%" class="table table-striped table-bordered">
              
                            <tr>
                                <th class="font_th"><a href="#">Cash</a></th>
                                <th><?php echo $collectionInfo[0]; ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Credit Card</a></th>
                                <th><?php echo $collectionInfo[1]; ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">UPI</a></th>
                                <th><?php echo round($collectionInfo[11]); ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Credit</a></th>
                                <th><?php echo $collectionInfo[2]; ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Cheque</a></th>
                                <th><?php echo $collectionInfo[3]; ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Credit Payment - CASH</a></th>
                                <th><?php echo $collectionInfo[9]; ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Credit Payment - CARD</a></th>
                                <th><?php echo $collectionInfo[10]; ?></th>
                            </tr>
                             <tr>
                                <th class="font_th"><a href="#">Credit Payment - UPI</a></th>
                                <th><?php echo round($collectionInfo[12]); ?></th>
                            </tr>
                            <tr>
                                <th class="font_th"><a href="#">Total Collection</a></th>
                                <th><?php echo $collectionInfo[5]; ?></th>
                            </tr>
                            
                       
                    </table>

                    <br><br>
                    <table width="100%" class="table table-striped table-bordered">

                       <tr>
                              <th class="font_th"><a href="#">Total Collection (Sales)</a></th>
                              <th><?php echo $collectionInfo[8]; ?></th>
                        </tr>
                        <tr>
                              <th class="font_th"><a href="#">Total Return Amount</a></th>
                              <th><?php echo (-$collectionInfo[7]); ?></th>
                        </tr>
                    </table>
                    <br>
                      <table width="100%" class="table table-striped table-bordered">
                       <br>
                        <tr>
                                <th class="font_ths"><a href="#">Total Amount Received</a></th>
                                <th class="font_ths"><?php echo $collectionInfo[6]; ?></th>
                      </tr>
                          
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
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
  
$(document).ready(function() {
      
    $('#from_date').datepicker();
    $('#end_date').datepicker();
    $(".timepicker").timepicker({showInputs: false,defaultTime: false});

   

});
   
   function searchForm(){
      
      document.bill_collection_report.action="<?php echo base_url(); ?>index.php/reports/dailyBillCollection";
      document.bill_collection_report.submit();

   }

   function searchUserType(){

      $("#user_id").val('');
      
      document.bill_collection_report.action="<?php echo base_url(); ?>index.php/reports/dailyBillCollection";
      document.bill_collection_report.submit();

   }

    function clearForm(){

        window.location = "<?php echo site_url('reports/dailyBillCollection'); ?>";
        return false;

    }
    function exportStock(){
  
    window.open('<?php echo base_url(); ?>index.php/reports/dailyBillCollection/export');
  

}
   
    function printForm() {
       
        window.print();

    }
   

</script>
