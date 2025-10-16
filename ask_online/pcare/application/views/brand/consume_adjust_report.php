<?php

  if(empty($export)){  
      $this->load->view("header");
  }

  if(!empty($export)){
 
          header('Content-type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename=Consume-report.xls');
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
      a[href]:after {
        content: none !important;
      }    
   }
   .table_style{
      width: 50%;
      margin: 0 auto;
   }

</style>

<form name="consume_adjust_report" id="consume_adjust_report" method="post" action="">

    <div class="container"  id="content">
<?php
if(empty($export)){  
?>
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  CONSUMABLES REPORT
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
                  <table width="100%" class="table table-striped ">
                
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

                          CONSUMABLES REPORT
              
                </h3>
          <div class="row">
<?php
if(empty($export)){
?>
            <div class="col-md-9" id="success">
          
            </div>
            <div class="col-md-3 DONTPrint">
             
                    <?php echo $pagination_link; ?>
              
           </div>
<?php
}
?> 
          </div> 

            <section class="content-header">
            <h1>
                  CONSUMABLES REPORT
            </h1>
           
        </section>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">
				          <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                          </div>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th">Sl No</th>
				            <th class="font_th">Brand</th>
				            <th class="font_th">Batch</th>
				            <th class="font_th">Date/Time</th>
				            <th class="font_th text-center">Qty</th>
				            <th class="font_th">Remarks</th>
				            <th class="font_th">Branch</th>
				            <th class="font_th">User</th>
				        </tr>
		<?php   
                if(!empty($adjustInfo)){	
				    
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($adjustInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
				            <td><?php echo $adjustInfo[$i][2];?></td>
					        <td><?php echo $adjustInfo[$i][4];?></td>
							<td><?php echo date('d-m-Y',strtotime($adjustInfo[$i][6]))." ".$adjustInfo[$i][7];?></td>
							<td align="center"><?php echo $adjustInfo[$i][8];?></td>
							<td><?php echo $adjustInfo[$i][13];?></td>
							<td><?php echo $adjustInfo[$i][17];?></td>
							<td><?php echo $adjustInfo[$i][15];?></td>
				        </tr>
		<?php
		            }
		        }
		?>			   
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
    <input type="hidden" name="brand_id" id="brand_id" value=""> 
    <input type="hidden" name="from_path" id="from_path" value=""> 
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">     
</form>    

<?php
      $this->load->view("footer"); 
?>

<script type="text/javascript">
  
 $(document).ready(function(){

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#consume_adjust_report").attr("action","<?php echo base_url(); ?>index.php/brand/consume_adjust_report");
                 $("#consume_adjust_report").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#consume_adjust_report").attr("action","<?php echo base_url(); ?>index.php/brand/consume_adjust_report");
                 $("#consume_adjust_report").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#consume_adjust_report").attr("action","<?php echo base_url(); ?>index.php/brand/consume_adjust_report");
                 $("#consume_adjust_report").submit();
    });

  });
   
function searchForm(){
      
    $("#current_page").val('');
    document.consume_adjust_report.action="<?php echo base_url(); ?>index.php/brand/consume_adjust_report";
    document.consume_adjust_report.submit();

}

function clearForm(){

    window.location = "<?php echo site_url('brand/consume_adjust_report'); ?>";
    return false;

}

function exportStock(){
   $("#current_page").val('');
              document.consume_adjust_report.action="<?php echo base_url(); ?>index.php/brand/consume_adjust_report/export";
              document.consume_adjust_report.submit();

}

function printForm() {
       
    window.print();

}

</script>
