<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<div  id="content">
	<form name="show_items" id="show_items"  method="post" action="" >
		<?php
		$theatre_procedure=$this ->popArr['theatre_procedure'];
		$bill_xray_details=$this ->popArr['bill_xray_details'];
		$bill_lab_details=$this ->popArr['bill_lab_details'];
		$bill_procedure_details=$this ->popArr['bill_procedure_details'];
		$bill_gynec_details=$this ->popArr['bill_gynec_details'];
		$bill_advance_details=$this ->popArr['bill_advance_details'];
		$bill_pharma_details=$this ->popArr['bill_pharma_details'];
		$specialist=$this ->popArr['doc_visit'];
		$rent=$this ->popArr['rent'];
		// var_dump($rent);
		$ipProcedure=$this ->popArr['ipProcedure'];
		$net_tot = 0;
		$paid_tot = 0;
		$balance_tot = 0;
		?>
		<!-- Main content -->
		<!-- <section class="content"> -->		
			<?php
				if(!empty($theatre_procedure['t_bill'][0])){
			?>
			<h4>SURGERY BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($theatre_procedure['t_bill']);$s++){
									if($theatre_procedure['t_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $theatre_procedure['t_bill'][$s][0];?></td>
								<td><?php echo $theatre_procedure['t_bill'][$s][1];?></td>
								<td><?php echo $theatre_procedure['t_bill'][$s][2];?></td>
								<td><?php echo $theatre_procedure['t_bill'][$s][3];?></td>
								<td><?php echo $theatre_procedure['t_bill'][$s][4];?></td>				
							</tr>
							<?php						
								}
							}
							$net_tot += $theatre_procedure['t_bill']['net_tot'];
							$paid_tot += $theatre_procedure['t_bill']['paid_tot'];
							$balance_tot += $theatre_procedure['t_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $theatre_procedure['t_bill']['net_tot'];?></b></td>
								<td><b><?php echo $theatre_procedure['t_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $theatre_procedure['t_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }	
			if(!empty($theatre_procedure['tc_bill'][0])){
			?>
			<h4>SURGERY CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($theatre_procedure['tc_bill']);$s++){
									if($theatre_procedure['tc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $theatre_procedure['tc_bill'][$s][0];?></td>
								<td><?php echo $theatre_procedure['tc_bill'][$s][1];?></td>
								<td><?php echo $theatre_procedure['tc_bill'][$s][2];?></td>
								<td><?php echo $theatre_procedure['tc_bill'][$s][3];?></td>
								<td><?php echo $theatre_procedure['tc_bill'][$s][4];?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $theatre_procedure['tc_bill']['net_tot'];
							$paid_tot += $theatre_procedure['tc_bill']['paid_tot'];
							$balance_tot += $theatre_procedure['tc_bill']['balance_tot'];
							?>							
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $theatre_procedure['tc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $theatre_procedure['tc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $theatre_procedure['tc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }
			if(!empty($bill_xray_details['x_bill'][0])){
			?>
			<h4>XRAY BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_xray_details['x_bill']);$s++){
									if($bill_xray_details['x_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_xray_details['x_bill'][$s][0];?></td>
								<td><?php echo $bill_xray_details['x_bill'][$s][1];?></td>
								<td><?php echo $bill_xray_details['x_bill'][$s][2];?></td>
								<td><?php echo $bill_xray_details['x_bill'][$s][3];?></td>
								<td><?php echo $bill_xray_details['x_bill'][$s][4];
							?></td>				
							</tr>
							<?php						
								}
							}
							$net_tot += $bill_xray_details['x_bill']['net_tot'];
							$paid_tot += $bill_xray_details['x_bill']['paid_tot'];
							$balance_tot += $bill_xray_details['x_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_xray_details['x_bill']['net_tot'];?></b></td>
								<td><b><?php echo $bill_xray_details['x_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $bill_xray_details['x_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }	
			if(!empty($bill_xray_details['xc_bill'][0])){
			?>
			<h4>XRAY CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_xray_details['xc_bill']);$s++){
									if($bill_xray_details['xc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_xray_details['xc_bill'][$s][0];?></td>
								<td><?php echo $bill_xray_details['xc_bill'][$s][1];?></td>
								<td><?php echo $bill_xray_details['xc_bill'][$s][2];?></td>
								<td><?php echo $bill_xray_details['xc_bill'][$s][3];?></td>
								<td><?php echo $bill_xray_details['xc_bill'][$s][4];?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_xray_details['xc_bill']['net_tot'];
							$paid_tot += $bill_xray_details['xc_bill']['paid_tot'];
							$balance_tot += $bill_xray_details['xc_bill']['balance_tot'];
							?>
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $bill_xray_details['xc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $bill_xray_details['xc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $bill_xray_details['xc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }				
				if(!empty($bill_lab_details['l_bill'][0])){
			?>
			<h4>LABORATORY BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_lab_details['l_bill']);$s++){
									if($bill_lab_details['l_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_lab_details['l_bill'][$s][0];?></td>
								<td><?php echo $bill_lab_details['l_bill'][$s][1];?></td>
								<td><?php echo $bill_lab_details['l_bill'][$s][2];?></td>
								<td><?php echo $bill_lab_details['l_bill'][$s][3];?></td>
								<td><?php echo $bill_lab_details['l_bill'][$s][4];
							?></td>				
							</tr>
							<?php						
								}
							}
							$net_tot += $bill_lab_details['l_bill']['net_tot'];
							$paid_tot += $bill_lab_details['l_bill']['paid_tot'];
							$balance_tot += $bill_lab_details['l_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_lab_details['l_bill']['net_tot'];?></b></td>
								<td><b><?php echo $bill_lab_details['l_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $bill_lab_details['l_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_lab_details['lc_bill'][0])){
			?>
			<h4>LABOROTARY CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_lab_details['lc_bill']);$s++){
									if($bill_lab_details['lc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_lab_details['lc_bill'][$s][0];?></td>
								<td><?php echo $bill_lab_details['lc_bill'][$s][1];?></td>
								<td><?php echo $bill_lab_details['lc_bill'][$s][2];?></td>
								<td><?php echo $bill_lab_details['lc_bill'][$s][3];?></td>
								<td><?php echo $bill_lab_details['lc_bill'][$s][4];?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_lab_details['lc_bill']['net_tot'];
							$paid_tot += $bill_lab_details['lc_bill']['paid_tot'];
							$balance_tot += $bill_lab_details['lc_bill']['balance_tot'];
							?>
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $bill_lab_details['lc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $bill_lab_details['lc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $bill_lab_details['lc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_pharma_details['p_bill'][0])){
			?>
			<h4>PHARMACY BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_pharma_details['p_bill']);$s++){
									if($bill_pharma_details['p_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_pharma_details['p_bill'][$s][0];?></td>
								<td><?php echo $bill_pharma_details['p_bill'][$s][1];?></td>
								<td><?php echo $bill_pharma_details['p_bill'][$s][2];?></td>
								<td><?php echo $bill_pharma_details['p_bill'][$s][3];?></td>
								<td><?php echo $bill_pharma_details['p_bill'][$s][4];
						?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_pharma_details['p_bill']['net_tot'];
							$paid_tot += $bill_pharma_details['p_bill']['paid_tot'];
							$balance_tot += $bill_pharma_details['p_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_pharma_details['p_bill']['net_tot'];?></b></td>
								<td><b><?php echo $bill_pharma_details['p_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $bill_pharma_details['p_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_pharma_details['pc_bill'][0])){
			?>
			<h4>PHARMACY CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_pharma_details['pc_bill']);$s++){
									if($bill_pharma_details['pc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_pharma_details['pc_bill'][$s][0];?></td>
								<td><?php echo $bill_pharma_details['pc_bill'][$s][1];?></td>
								<td><?php echo $bill_pharma_details['pc_bill'][$s][2];?></td>
								<td><?php echo $bill_pharma_details['pc_bill'][$s][3];?></td>
								<td><?php echo $bill_pharma_details['pc_bill'][$s][4];
							?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_pharma_details['pc_bill']['net_tot'];
							$paid_tot += $bill_pharma_details['pc_bill']['paid_tot'];
							$balance_tot += $bill_pharma_details['pc_bill']['balance_tot'];
							?>
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $bill_pharma_details['pc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $bill_pharma_details['pc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $bill_pharma_details['pc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }
			if(!empty($bill_procedure_details['pro_bill'][0])){
			?>
			<h4>PROCEDURE BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_procedure_details['pro_bill']);$s++){
									if($bill_procedure_details['pro_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_procedure_details['pro_bill'][$s][0];?></td>
								<td><?php echo $bill_procedure_details['pro_bill'][$s][1];?></td>
								<td><?php echo $bill_procedure_details['pro_bill'][$s][2];?></td>
								<td><?php echo $bill_procedure_details['pro_bill'][$s][3];?></td>
								<td><?php echo $bill_procedure_details['pro_bill'][$s][4];
							?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_procedure_details['pro_bill']['net_tot'];
							$paid_tot += $bill_procedure_details['pro_bill']['paid_tot'];
							$balance_tot += $bill_procedure_details['pro_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_procedure_details['pro_bill']['net_tot'];?></b></td>
								<td><b><?php echo $bill_procedure_details['pro_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $bill_procedure_details['pro_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_procedure_details['proc_bill'][0])){
			?>
			<h4>PROCEDURE CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_procedure_details['proc_bill']);$s++){
									if($bill_procedure_details['proc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_procedure_details['proc_bill'][$s][0];?></td>
								<td><?php echo $bill_procedure_details['proc_bill'][$s][1];?></td>
								<td><?php echo $bill_procedure_details['proc_bill'][$s][2];?></td>
								<td><?php echo $bill_procedure_details['proc_bill'][$s][3];?></td>
								<td><?php echo $bill_procedure_details['proc_bill'][$s][4];?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_procedure_details['proc_bill']['net_tot'];
							$paid_tot += $bill_procedure_details['proc_bill']['paid_tot'];
							$balance_tot += $bill_procedure_details['proc_bill']['balance_tot'];
							?>
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $bill_procedure_details['proc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $bill_procedure_details['proc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $bill_procedure_details['proc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }
			if(!empty($bill_gynec_details['g_bill'][0])){
			?>
			<h4>DELIVERY/D&C BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_gynec_details['g_bill']);$s++){
									if($bill_gynec_details['g_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_gynec_details['g_bill'][$s][0];?></td>
								<td><?php echo $bill_gynec_details['g_bill'][$s][1];?></td>
								<td><?php echo $bill_gynec_details['g_bill'][$s][2];?></td>
								<td><?php echo $bill_gynec_details['g_bill'][$s][3];?></td>
								<td><?php echo $bill_gynec_details['g_bill'][$s][4];
							?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_gynec_details['g_bill']['net_tot'];
							$paid_tot += $bill_gynec_details['g_bill']['paid_tot'];
							$balance_tot += $bill_gynec_details['g_bill']['balance_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_gynec_details['g_bill']['net_tot'];?></b></td>
								<td><b><?php echo $bill_gynec_details['g_bill']['paid_tot'];?></b></td>
								<td><b><?php echo $bill_gynec_details['g_bill']['balance_tot'];
							?></b></td>				
							</tr>
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_gynec_details['gc_bill'][0])){
			?>
			<h4>DELIVERY/D&C CREDIT BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>TOWARDS BILL NO</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_gynec_details['gc_bill']);$s++){
									if($bill_gynec_details['gc_bill'][$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_gynec_details['gc_bill'][$s][0];?></td>
								<td><?php echo $bill_gynec_details['gc_bill'][$s][1];?></td>
								<td><?php echo $bill_gynec_details['gc_bill'][$s][2];?></td>
								<td><?php echo $bill_gynec_details['gc_bill'][$s][3];?></td>
								<td><?php echo $bill_gynec_details['gc_bill'][$s][4];?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_gynec_details['gc_bill']['net_tot'];
							$paid_tot += $bill_gynec_details['gc_bill']['paid_tot'];
							$balance_tot += $bill_gynec_details['gc_bill']['balance_tot'];
							?>
							<!-- <tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php //echo $bill_gynec_details['gc_bill']['net_tot'];?></b></td>
								<td><b><?php //echo $bill_gynec_details['gc_bill']['paid_tot'];?></b></td>
								<td><b><?php //echo $bill_gynec_details['gc_bill']['balance_tot'];?></b></td>				
							</tr> -->
						</table>
					</div>
				</div>
			<?php }
				if(!empty($bill_advance_details[0])){
			?>
			<h4>ADVANCE BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
								for($s=0;$s<sizeof($bill_advance_details);$s++){
									if($bill_advance_details[$s]){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $bill_advance_details[$s][0];?></td>
								<td><?php echo $bill_advance_details[$s][1];?></td>
								<td><?php echo $bill_advance_details[$s][2];?></td>
								<td><?php echo $bill_advance_details[$s][3];?></td>
								<td><?php echo $bill_advance_details[$s][4];
							?></td>								
							</tr>
							<?php
								}
							}
							$net_tot += $bill_advance_details['net_tot'];
							$paid_tot += $bill_advance_details['paid_tot'];
							$balance_tot -= $bill_advance_details['paid_tot'];
							?>
							<tr>
								<td></td>
								<td></td>
								<th>TOTAL</th>
								<td><b><?php echo $bill_advance_details['net_tot'];?></b></td>
								<td><b><?php echo $bill_advance_details['paid_tot'];?></b></td>
								<td><b><?php echo $bill_advance_details['balance_tot'];
							?></b></td>				
							</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
				<h4>ALL OTHER BILLS</h4>
				<div class="box box-info">
					<div class="box-body">
							<table class="table table-bordered table-striped">
								<tr>
									<th>SL NO</th>
									<th>PARTICULAR</th>
									<th></th>
									<th>NET AMOUNT</th>
									<th>AMOUNT PAID</th>
									<th>BALANCE AMOUNT</th>
								</tr>
								<tr>									
									<td>1</td>
									<td>Room Rent Credit Bills</td>
									<td>:</td>
									<td>
										<?php 
											echo $rent;
											$net_tot+=$rent;										
											$balance_tot+=$rent;
										?>									
									</td>
									<td>0</td>
									<td>
										<?php echo $rent;
										?>											
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td>Specialist consultation</td>
									<td>:</td>
									<td>
										<?php 
											echo $specialist;
											$net_tot+=$specialist;										
											$balance_tot+=$specialist;
										?>											
									</td>
									<td>0</td>
									<td>
										<?php echo $specialist;
										?>											
									</td>
								</tr>
								<tr>
									<td>3</td>
									<td>NURSING PROCEDURES</td>
									<td>:</td>
									<td>
										<?php 
											echo $ipProcedure;								
											$net_tot+=$ipProcedure;										
											$balance_tot+=$ipProcedure;
										?>											
									</td>
									<td>0</td>
									<td>
										<?php echo $ipProcedure;
										
										?>											
									</td>
								</tr>
			
							<?php
								if($net_tot!=0 || $paid_tot!=0 || $balance_tot!=0){
							?>
							<tr>
								<td></td>
								<td></td>
								<th>Total</th>
								<td><b><?php echo $net_tot;?></b></td>
								<td><b><?php echo $paid_tot;?></b></td>
								<td><b><?php echo $balance_tot;?></b></td>
							</tr>
						<?php }?>
							</table>
						</div>
					</div>
					
		<!-- </section> -->
	</form>
</div>