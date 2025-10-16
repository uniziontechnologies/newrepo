<?php
  
  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=movement-report.xls');
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

<form name="movement_report" id="movement_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  MOVEMENT REPORT
            </h1>
            <div style="text-align: right">
                <button type="button" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-success" onclick="exportMovement()" ><img src="<?php echo base_url(); ?>application/assets/dist/img/Excel-icon.png" width="10%" height="10%"> Export to Excel</button>
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

                    Movement Report
              
                </h3>
          <div class="row">
                <div class="col-md-9" id="success">
                          <?php  

                            if (!empty($from_date)) {
                                echo "From date : ".$from_date;
                             }
                              if (!empty($end_date)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; End date : ".$end_date;
                             }
                            if (!empty($user_type_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; User Type : ".$user_type_name;
                             }
                            if (!empty($user_name)) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp; User : ".$user_name;
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
                          <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                          </div>

                    <table width="100%" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="font_th"><a href="#">Sl No</a></th>
                                <th class="font_th"><a href="#">Date</a></th>
                                <th class="font_th"><a href="#">Move From</a></th>
                                <th class="font_th"><a href="#">Move To</a></th>
                                <th class="font_th"><a href="#">Remarks</a></th>
                                <th class="font_th"><a href="#">Entered By</a></th>
<?php
if(empty($export)){  
?>  
                                <th class="font_th DONTPrint"><a href="#">Action</a></th>
<?php
}  
?>       
                        
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
                          
                          if(!empty($movement)){            
                              $j= !empty($next_page)?$next_page+1:1;
                            for($i=0;$i<count($movement);$i++) {?>
                                <tr>
                                  <td style="text-align: left !important;"><?php echo $j++; ?></td>
                                  <td><?php echo $movement[$i][7];?></td>
                                  <td><?php echo $movement[$i][3];?></td>
                                  <td><?php echo $movement[$i][5];?></td>
                                  <td><?php echo $movement[$i][6];?></td>
                                  <td><?php echo $movement[$i][10];?></td>
<?php
if(empty($export)){  
?>
                                  <td class="DONTPrint">
                                                    
                                      <div class="btn-group"> 
                                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Option
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                          </button>   
                                          <ul class="dropdown-menu" role="menu">    

                                            <li><a href="#" onclick="viewMovement('<?php echo  $movement[$i][1];?>')">View Bill Items</a></li>
                                               
                                            <li ><a href="#" onclick="printPurchase('<?php echo $movement[$i][1]; ?>');">Print Bill Items</a></li>
                                                            
                                          </ul>
                                      </div>

                                </td>
<?php
}  
?>                                  
                                  
                                  
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
    <input type="hidden" name="move_id" id="move_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value="">
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">      
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

    

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/movement_report");
                 $("#movement_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/movement_report");
                 $("#movement_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#movement_report").attr("action","<?php echo base_url(); ?>index.php/reports/movement_report");
                 $("#movement_report").submit();
    });




});
   
   function searchForm(){
      
      $("#current_page").val('');
      $("#movement_report"). removeAttr("target");
      document.movement_report.action="<?php echo base_url(); ?>index.php/reports/movement_report";
      document.movement_report.submit();

    }

    function clearForm(){

        window.location = "<?php echo site_url('reports/movement_report'); ?>";
        return false;

    }
    function printPurchase(id) {
            
            $('#move_id').val(id);
            $('#from_path').val("recieving_report_popup");
            $("#movement_report").attr("target", "_blank");
            document.movement_report.action='<?php echo base_url(); ?>index.php/movement/printMovement';
            document.movement_report.submit();
            
    }
    function viewMovement(id) {
            

            $('#move_id').val(id);
            $('#from_path').val("movement_report_popup");
            $("#movement_report"). removeAttr("target");
            tb_show('Bill Items',"<?php echo base_url(); ?>index.php/movement/printMovement/"+$('#move_id').val()+"/"+$('#from_path').val());
            
    }
    function tb_remove(){
        
        // document.movement_form.item_focus.value='brand';
        document.movement_report.action='<?php echo base_url(); ?>index.php/reports/movement_report';
        document.movement_report.submit();
    }
    function printForm() {
       
        window.print();

    }
    function exportMovement(){
        
        $("#current_page").val('');
        $("#movement_report"). removeAttr("target");
        document.movement_report.action="<?php echo base_url(); ?>index.php/reports/movement_report/export";
        document.movement_report.submit();

    }

</script>
