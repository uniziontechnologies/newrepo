<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<div  id="content">
	<form name="show_items" id="show_items"  method="post" action="" >
		<?php
		$xray_details_popup=$this ->popArr['xray_details_popup'];
		$lab_details_popup=$this ->popArr['lab_details_popup'];
		$ipProcedure=$this ->popArr['ipProcedure'];
		$rent=$this ->popArr['rent'];
		$to = date('d-m-Y / h:i:s A');
		// var_dump($xray_details_popup);
		?>
		<!-- Main content -->
		<!-- <section class="content"> -->

			
			<h4>Xray Bills</h4>
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
						$tot = 0;
						if(!empty($xray_details_popup)){
							for($s=0;$s<sizeof($xray_details_popup);$s++){
						?>
						<tr>
							<td><?php echo $s+1;?></td>
							<td><?php echo $xray_details_popup[$s][0];?></td>
							<td><?php echo $xray_details_popup[$s][1];?></td>
							<td><?php echo $xray_details_popup[$s][2];?></td>
							<td><?php echo $xray_details_popup[$s][3]+$xray_details_popup[$s][5];?></td>
							<td><?php echo $xray_details_popup[$s][4]-$xray_details_popup[$s][5];?></td>
						</tr>
						<?php
						$tot = $tot+$xray_details_popup[$s][4]-$xray_details_popup[$s][5];
							}
							?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<th>Total</th>
							<th><?php echo $tot;?></th>
						</tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
			<h4>Lab Bills</h4>
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
							$tot = 0;
							if(!empty($lab_details_popup)){
								for($s=0;$s<sizeof($lab_details_popup);$s++){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $lab_details_popup[$s][0];?></td>
								<td><?php echo $lab_details_popup[$s][1];?></td>
								<td><?php echo $lab_details_popup[$s][2];?></td>
								<td><?php echo $lab_details_popup[$s][3]+$lab_details_popup[$s][5];?></td>
								<td><?php echo $lab_details_popup[$s][4]-$lab_details_popup[$s][5];?></td>
							</tr>
							<?php
							$tot = $tot+$lab_details_popup[$s][4]-$lab_details_popup[$s][5];
								}
								?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th>Total</th>
								<th><?php echo $tot;?></th>
							</tr>
								<?php
							}
							?>
						</table>
					</div>
				</div>
			<h4>NURSING PROCEDURES</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>BILL DATE</th>
								<!-- <th>PROCEDURE</th> -->
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
							$tot = 0;
							if(!empty($ipProcedure)){
								for($s=0;$s<sizeof($ipProcedure);$s++){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $ipProcedure[$s][0];?></td>
								<td><?php echo $ipProcedure[$s][1];?></td>
								<!-- <td><?php //echo $ipProcedure[$s][0];?></td> -->
								<td><?php echo $ipProcedure[$s][2];?></td>
								<td><?php echo $ipProcedure[$s][3];?></td>
								<td><?php echo $ipProcedure[$s][4];?></td>
							</tr>
							<?php
							$tot = $tot+$ipProcedure[$s][4];
								}
								?>
							<tr>
								<td colspan="4"></td>
								<th>Total</th>
								<th><?php echo $tot;?></th>
							</tr>
								<?php
							}
							?>
						</table>
					</div>
				</div>
				<h4>ROOM RENT</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<!-- <th>SL NO</th> -->
								<th>CATEGORY</th>
								<th>ROOM NUMBER</th>
								<!-- <th>PROCEDURE</th> -->
								<th>BED NUMBER</th>
								<th>FROM</th>
								<th>TO</th>
								<th>TOTAL HOURS</th>
								<th>RENT/HOUR</th>
								<th>NET AMOUNT</th>
							</tr>
							<?php
							$tot = 0;
							if(!empty($rent)){
								// for($s=0;$s<sizeof($rent);$s++){
							?>
							<tr>
								<!-- <td><?php //echo $s+1;?></td> -->
								<td><?php echo $rent['category'];?></td>
								<td><?php echo $rent['room_number'];?></td>
								<!-- <td><?php //echo $ipProcedure[$s][0];?></td> -->
								<td><?php echo $rent['bed_number'];?></td>
								<td><?php  echo $rent['from'];?></td>
								<td><?php  echo $rent['to'];?></td>
								<td><?php  echo $rent['difference'];?></td>
								<td><?php echo $rent['hcharge'];?></td>
								<td><?php  echo $rent['net_total'];?></td>
							</tr>
							<?php
							// $tot = $tot+$ipProcedure[$s][4];
								// }
								?>
							<!-- <tr>
								<td colspan="6"></td>
								<th>Total</th>
								<th><?php //echo $tot;?></th>
							</tr> -->
								<?php
							}
							?>
						</table>
					</div>
				</div>
		<!-- </section> -->
	</form>
</div>