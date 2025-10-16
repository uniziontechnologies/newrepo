<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=movement_item-report.xls');
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

<form name="movement_item_report" id="movement_item_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  MOVEMENT ITEMWISE REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportMovementItem()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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
                          <!-- <input type="text" id="from_time" name="from_time" class="timepicker" size="6" value="<?php echo !empty($from_time)?$from_time:'' ?>" size="6">          -->
                </td>
                <td>
                         End Date : 
                </td>
                <td>
                          <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true"> 
                          <!-- <input type="text" id="to_time" name="to_time" class="timepicker" size="6" value="<?php echo !empty($to_time)?$to_time:'' ?>" size="6">        -->
                </td>

                <td>

                        Move From : 
                </td>
                <td>
                        <select name="move_from" id="move_from" onkeypress="nextField(event.keyCode,Search);" >
                            <option value="">----------</option>
                            <?php
                                if (!empty($branchInfo)) {

                                    for ($i=0; $i <count($branchInfo) ; $i++) { ?>
                                        <option value="<?php echo $branchInfo[$i][0] ?>" <?php if (!empty($move_from) && $move_from ==$branchInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $branchInfo[$i][1]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>

                <td>

                        Move To : 
                </td>
                <td>
                        <select name="move_to" id="move_to" onkeypress="nextField(event.keyCode,Search);" >
                            <option value="">----------</option>
                            <?php
                                if (!empty($branchInfo)) {

                                    for ($i=0; $i <count($branchInfo) ; $i++) { ?>
                                        <option value="<?php echo $branchInfo[$i][0] ?>" <?php if (!empty($move_to) && $move_to ==$branchInfo[$i][0] ) {
                                echo "selected";
                            } ?>><?php echo $branchInfo[$i][1]; ?></option>
                                    <?php
                                    }
                                
                                }
                             ?>
                        </select>
                         
                </td>

<!--                 <td>

                        User Type : 
                </td>
                <td>
                        <select name="user_type" id="user_type" onkeypress="nextField(event.keyCode,Search);">
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
                         
                </td> -->




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
<?php
} 
?>
                <h3 id="print_details">

                      Movement Itemwise Report
              
                </h3>
                <div id="success">
                          <?php  

                             if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                             }
                              if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                             }



                          ?>
                        
                </div>
          </div> <!--row-->

          <div class="row">
             <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">

                    <table width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Brand</a></th>
                                <th class="font_th"><a href="#">Batch</a></th>
                                <th class="font_th"><a href="#">Expiry</a></th>
                                <th class="font_th"><a href="#">Selling Unit</a></th>
                                <th class="font_th"><a href="#">Qty</a></th>
                                <th class="font_th"><a href="#">Price</a></th>
                                <th class="font_th"><a href="#">Move From</a></th>
                                <th class="font_th"><a href="#">Move To</a></th>
                                <th class="font_th"><a href="#">Entered By</a></th>
        
                        
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php  
                              $totalsellp=0;
                           if(!empty($movementInfo)){ 
                            $j=1;
                            
                          for($k=0;$k<count($movementInfo);$k++){
                          
                            for($i=0;$i<count($movementInfo[$k]);$i++){
                            
                            if(!empty($movementInfo[$k])){
                        ?>
                            <tr>
                            <td style="text-align: left !important;"><?php echo $j++; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][10]; ?></td>              
                            <td ><?php echo $movementInfo[$k][$i][4]; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][5]; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][6]; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][7]; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][12]; ?></td>
                            <td ><?php echo $mainInfo[$k][1]; ?></td>
                            <td ><?php echo $mainInfo[$k][3]; ?></td>
                            <td ><?php echo $movementInfo[$k][$i][14]; ?></td>
                            
                            
                            
                            
                                                  
                                
                            </tr>             
                        <?php    
                              $totalsellp +=$movementInfo[$k][$i][12];
                                }
                                 }
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
    <input type="hidden" name="move_id" id="move_id" value=""> 
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

    // if ( $( "#customer_type" ).val()=="OP" || $( "#customer_type" ).val()=="IP" ) {
    //         $("#customer_id").removeAttr('readonly');
    // }
    // else{
    //         $("#customer_id").attr('readonly','readonly');
    //         $("#customer_id").val('');
    // }

    // $( "#customer_type" ).change(function() {
        
    //     if ( $( "#customer_type" ).val()=="OP" || $( "#customer_type" ).val()=="IP" ) {
    //         $("#customer_id").removeAttr('readonly');
    //     }
    //     else{
    //         $("#customer_id").attr('readonly','readonly');
    //         $("#customer_id").val('');
    //     }

    // });  

});
   
   function searchForm(){
      
      document.movement_item_report.action="<?php echo base_url(); ?>index.php/reports/movement_item_report";
      document.movement_item_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/movement_item_report'); ?>";
        return false;
    }
    function printPurchase(id) {
            
            $('#move_id').val(id);
            $('#from_path').val("recieving_report_popup");
            document.movement_item_report.action='<?php echo base_url(); ?>index.php/purchase/print_purchase';
            document.movement_item_report.submit();
            
    }
    function viewPurchase(id) {
            

            $('#move_id').val(id);
            $('#from_path').val("recieving_report_popup");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/purchase/print_purchase/"+$('#move_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.movement_item_report.action='<?php echo base_url(); ?>index.php/reports/movement_item_report';
        document.movement_item_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportMovementItem(){

        document.movement_item_report.action="<?php echo base_url(); ?>index.php/reports/movement_item_report/export";
        document.movement_item_report.submit();

    }

</script>
