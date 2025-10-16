<?php 
	  if (empty($popup_path)) {
	  	$this->load->view("header");
	  }
   
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        color: #006633;   
   }	
<?php if (!empty($from_path)) {?>
	.content{
		margin-top: 90px;
	}
<?php
} ?> 
</style>

<form name="print_movement" id="print_movement" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
     <?php if (empty($from_path) && empty($popup_path) ) {?>
    <center>   
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="80px" style="margin-top: -12px;"></img>   
          <h2 style="margin-top: -1px;"><b><?php echo strtoupper($pharmacyInfo[0][1]); ?></b></h2>
          <h4 style="margin-top: -7px"><b><?php echo strtoupper($hospitalInfo[0][2])." , ".strtoupper($hospitalInfo[0][3]); ?></b></h4>
          <h4 style="margin-top: -7px"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h4>
          <h4 style="margin-top: -7px"><b><?php echo "DL NO : ".$pharmacyInfo[0][3]; ?> , <?php echo "GST NO : ".$pharmacyInfo[0][2]; ?></b></h4>
    </center>
    <?php
    } ?>  
      
          <!-- Main content -->
          <section class="content">
                    <h2>
                        Movement
                    </h2>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                
                    <div class="box-body">

                      <div style="margin-top: 9px;margin-bottom: 15px;">
                        
                        <h5>Movement From <?php echo $movement_info[0][3]; ?> To <?php echo $movement_info[0][5]; ?> on <?php echo date("d-m-Y",strtotime($movement_info[0][7]));?></h5>

                      </div>	
				
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Brand</a></th>
				            <th class="font_th"><a href="#">Batch</a></th>
				            <th class="font_th"><a href="#">Expiry</a></th>
				            <th class="font_th"><a href="#">Selling Unit</a></th>
				            <th class="font_th"><a href="#">Qty</a></th>
				        </tr>
		<?php        
                if(!empty($movement_item_Info)){						
				    $j=1;
				    for($i=0;$i<count($movement_item_Info);$i++) {
		?>						
				        <tr>
				            <td ><?php echo $j++; ?></td>
							<td ><?php echo $movement_item_Info[$i][10]; ?></td>
							<td ><?php echo $movement_item_Info[$i][4]; ?></td>
							<td ><?php echo $movement_item_Info[$i][5]; ?></td>
							<td><?php echo $movement_item_Info[$i][6]; ?></td>
							<td ><?php echo $movement_item_Info[$i][7]; ?></td>
				        </tr>
		<?php
		            }
		        }
		?>				
		                

					   </table>
					</div>
				</div>
				        <div align="center">

							<?php 

             				 	if (empty($popup_path)) {?>
             				 		<input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printmovement()">
             				 <?php
             				        if (empty($from_path) ){
             				  ?>
             				 		        <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack()">
                      <?php
                            }elseif(!empty($from_path)){
                      ?>
                                <input type="button" name="but" value="Close" class="btn btn-danger DONTPrint" onclick="closeTab()">  
             				 	<?php
             				 	      }
             				 	}

             				  ?>
             	
                             

                        </div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
<!-- hidden fields -->
<?php

  $from_date=$this->input->post("from_date");
	$end_date=$this->input->post("end_date");
	$from_branch=$this->input->post('from');
	$to_branch=$this->input->post('to');
  $bill_no=$this->input->post('bill_no');
  $current_page=$this->input->post("current_page");

?>	
    <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
    <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
    <input type="hidden" name="from" id="from" value="<?php echo $from_branch; ?>">
    <input type="hidden" name="to" id="to" value="<?php echo $to_branch; ?>">
    <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no; ?>">
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
<!-- hidden fields -->	        
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">
function goBack() {
      	
    document.print_movement.action="<?php echo base_url(); ?>index.php/movement/manage_movement";
    document.print_movement.submit();

 }

function closeTab(){

  window.top.close();

}
	
function printmovement() {
      	
    window.print();

}

</script>