  <!-- date-range-picker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="../../dist/css/ajax.css">
  <script type="text/javascript" src="../../ajax/ajax.js"></script>
  <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
  <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />

  <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
  <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="../../dist/js/thickbox.js"></script>
  <script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
  <script>

  $(document).ready(function(){
	  
	  $(".show_details").bind('click', function() {

        var id=$(this).attr("id");
        tb_show('CREDIT BILLS',"../../lib/controllers/centralController.php?module=Registration&sub_module=ip_show_creditBills&id="+id,'',750,550);
    });

	});

  $(document).ready(function(){
	  
	  $(".show_details1").bind('click', function() {

        var id=$(this).attr("id");
        tb_show('PHARMA CREDIT BILLS',"../../lib/controllers/centralController.php?module=Registration&sub_module=ip_show_pharmacreditBills&id="+id,'',750,550);
    });

	});

   $(document).ready(function(){
	  
	  $(".show_details2").bind('click', function() {

        var id=$(this).attr("id");
        tb_show('DISCHARGE CREDIT BILLS',"../../lib/controllers/centralController.php?module=Registration&sub_module=ip_show_dischargecreditBills&id="+id,'',750,550);
    });

	});
  </script>
<?php
	
$ipcreditInfo=$this  ->popArr['ipcreditInfo'];
$IPbillInfo=$this  ->popArr['IPbillInfo'];
$all_ipno=$this  ->popArr['all_ipno'];
$ipno_selected=$this  ->popArr['ipno_selected'];

$pharmaCreditInfo=$this  ->popArr['pharmaCreditInfo'];
$total_ipcredit=$this  ->popArr['total_ipcredit'];
$total_ippharmacredit=$this  ->popArr['total_ippharmacredit']; 
$total_dischargepharmacredit=$this  ->popArr['total_dischargepharmacredit']; 
?>

 <section class="content">


    <div class="box box-info">

   	  <div class="row">
   	  	
   	  	<div class="col-md-offset-1 col-md-2">
   	  		<h4><b>HCARE : <font color="red"><?php echo $total_ipcredit;?></font></b></h4>
   	  	</div>
   	  	<div class="col-md-2">
   	  		<h4><b>PCARE : <font color="red"><?php echo $total_ippharmacredit;?></font></b></h4>
   	  	</div>
   	  	<div class="col-md-2">
   	  		<h4><b>DISCHARGE : <font color="red"><?php echo $total_dischargepharmacredit;?></font></b></h4>
   	  	</div>
   	  	<div class="col-md-2">
   	  		
   	  		<!-- <select id="ipno" name="ipno" class="form-control">
   	  			<option value=""> Please Select </option>
   	  		
              	<?php

   	  				for ($i=0; $i <count($all_ipno) ; $i++) { ?>
   	  					<option value="<?php echo $all_ipno[$i]; ?>" <?php if (!empty($all_ipno[$i]) && $all_ipno[$i]==$ipno_selected ) {
   	  						echo "selected";
   	  					} ?>><?php echo $all_ipno[$i]; ?></option>
   	  				<?php
   	  				}

   	  			?>

                


   	  		</select>
 -->
   	  	</div>

   	  	<div class="col-md-3">
   	  		<?php echo $pagination;?>
   	  	</div>

   	  </div>
   </div>

<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">IP Bill Credits</h3>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#">VISIT ID </a></th>
						<th ><a href="#" >VISIT DATE</a></th>
						<th ><a href="#">BILL NO </a></th>
						<th><a href="#">NET AMT</a></th>
						<th><a href="#">CREDIT AMT</a></th>
						<th><a href="#">BALANCE</a></th>
					</tr>
				</thead>
				<tbody>
					
					<?php
								
								if(!empty($ipcreditInfo)){
									$total_amt=0;
									$total_credit=0;
									$total_balance=0;
									$j=(($current_page-1)*$perPage)+1;
											
										for($i=0;$i<count($ipcreditInfo);$i++){
					?>
					<tr>
						<td><?php echo $i+1;?></td>
						<td><?php echo $ipcreditInfo[$i][1];?></td>
						<td ><?php echo date("d-m-Y",strtotime($ipcreditInfo[$i][2]));?></td>
						<td><a href="#" class="show_details" id="<?php echo $ipcreditInfo[$i][0];?>" ><?php echo $ipcreditInfo[$i][0];?></a></td>
						<td><?php  echo $ipcreditInfo[$i][7];?></td>
						<td><?php  echo $ipcreditInfo[$i][9];?></td>
						<td><?php  echo $ipcreditInfo[$i][13];?></td>
					</tr>
					
					
					<?php
					$total_amt=$total_amt+$ipcreditInfo[$i][7];
					$total_credit=$total_credit+$ipcreditInfo[$i][9];
					$total_balance=$total_balance+$ipcreditInfo[$i][13];
					}
					
					}
					?>
					<tr>
						<td colspan="4" align="right"><b>total</b></td>
						<td><b><?php  echo $total_amt;?></b></td>
						<td><b><?php  echo $total_credit;?></b></td>
						<td><b><?php  echo $total_balance;?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">IP Pharmacy Credits</h3>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
							<th ><a href="#">VISIT ID </a></th>
							<th ><a href="#" >VISIT DATE</a></th>
							<th ><a href="#">BILL NO </a></th>
							<th><a href="#">NET AMT</a></th>
							<th><a href="#">CREDIT AMT</a></th>
							<th><a href="#">BALANCE</a></th>
						</tr>
					</thead>
					<tbody>
						
						<?php
									
									if(!empty($pharmaCreditInfo)){
										$total_pharma_amt=0;
										$total_pharma_credit=0;
										$total_pharma_balance=0;
										$j=(($current_page-1)*$perPage)+1;
												
											for($i=0;$i<count($pharmaCreditInfo);$i++){
						?>
						<tr>
							<td><?php echo $i+1;?></td>
							<td><?php echo $pharmaCreditInfo[$i][16];?></td>
							<td ><?php echo date("d-m-Y",strtotime($pharmaCreditInfo[$i][15]));?></td>
							<td><a href="#" class="show_details1" id="<?php echo $pharmaCreditInfo[$i][1];?>" ><?php echo $pharmaCreditInfo[$i][1];?></a></td>
							
							<td><?php  echo $pharmaCreditInfo[$i][2];?></td>
							<td><?php  echo $pharmaCreditInfo[$i][8];?></td>
							<td><?php  echo $pharmaCreditInfo[$i][11];?></td>
						</tr>
						
						
						<?php
						$total_pharma_amt=$total_pharma_amt+$pharmaCreditInfo[$i][2];
						$total_pharma_credit=$total_pharma_credit+$pharmaCreditInfo[$i][8];
						$total_pharma_balance=$total_pharma_balance+$pharmaCreditInfo[$i][11];
						}
						
						}
						?>
						<tr>
							<td colspan="4" align="right"><b>total</b></td>
							<td><b><?php  echo $total_pharma_amt;?></b></td>
							<td><b><?php  echo $total_pharma_credit;?></b></td>
							<td><b><?php  echo $total_pharma_balance;?></b></td>
						</tr>
					</tbody>
				</table>
				
				</div><!-- /.box-body -->
			</div>

	    <div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Discharge Bill Credits</h3>

			<table class="table table-bordered table-striped">
				
				<thead>
					<tr>
						<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_date; ?></a></th>
						<th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
						<th ><a href="#"><?php echo $lang_amount_paid; ?></a></th>
						<th ><a href="#"><?php echo $lang_discount; ?></a></th>
						<th ><a href="#"><?php echo $lang_net_amount; ?></a></th>
						<th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>
						<th ><a href="#">CREDIT AMT</a></th>
						<th ><a href="#">CREDIT PAID</a></th>
						<th ><a href="#"><?php echo $lang_balance; ?></a></th>					
					</tr>
				</thead>
				<tbody>
					<?php
						if(!empty($IPbillInfo)){
						$j=1;
					for($i=0;$i<count($IPbillInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><a href="#" class="show_details2" id="<?php echo $IPbillInfo[$i][0];?>" ><?php echo $IPbillInfo[$i][0];?></a></td>
						<td><?php echo	date('d-m-Y',strtotime($IPbillInfo[$i][2]))." ".date('h:i A',strtotime($IPbillInfo[$i][3]));?></td>						
						<td><?php echo $IPbillInfo[$i][4];?></td>
						<td><?php echo $IPbillInfo[$i][5];?></td>
						<td><?php echo ($IPbillInfo[$i][6] == "CASH")?Rs.$IPbillInfo[$i][7]:$IPbillInfo[$i][7]." ".$IPbillInfo[$i][6];?></td>
						<td><?php echo $IPbillInfo[$i][8];?></td>
						<td><?php echo $IPbillInfo[$i][9];?>
							
							<?php if($IPbillInfo[$i][9] == "CREDIT"){?>
							
							<br>
							Sanc By:<?php echo $IPbillInfo[$i][21];?>
							<br>
							Remarks:<?php echo $IPbillInfo[$i][22];?>
							<?php } ?>
						</td>
						<td><?php echo $IPbillInfo[$i][24]+$IPbillInfo[$i][26];?></td>
						<td><?php echo $IPbillInfo[$i][26];?></td>						
						<td><?php echo $IPbillInfo[$i][24];?></td>						
					</tr>
					
					
					<?php	}
					
							}
					?>
				</tbody>
			</table>
		</div>
	</div>

</section>




<script type="text/javascript">
	

      $(function () {
	  
	  	 
		   	$("#ipno").bind('change', function() {
			    var active_module="patient_ip_credits";
			    $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
			    $("#form").submit();			  		
					
			});	

	  });


</script>


