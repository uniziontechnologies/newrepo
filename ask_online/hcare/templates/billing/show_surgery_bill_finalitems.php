<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<div  id="content">
	<form name="show_items" id="show_items"  method="post" action="" >
		<?php
		$pops=$this->popArr['pops'];
		?>
		<!-- Main content -->
		<!-- <section class="content"> -->

			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<table class="table table-bordered table-striped">
								<tr>
									<th>SL NO</th>
									<th>BILL NO</th>
									<th>BILL DATE</th>
									<th>TEST</th>
									<th></th>
									<th><th>
								</tr>
								<?php
								$tot = 0;
								if($pops){

								for($s=0;$s<sizeof($pops);$s++){
								$tot_single=0;
								?>
								<tr>
									<td rowspan="7"><?php echo $s+1;?></td>
									<td rowspan="7"><?php echo $pops[$s][0];?></td>
									<td rowspan="7"><?php echo $pops[$s][7];?></td>
									<td rowspan="7"><?php echo $pops[$s][6];?></td>
									<td>HOSPITAL AMOUNT</td><td><?php echo $pops[$s][1];$tot_single+=$pops[$s][1];?></td>
								</tr>
								<tr><td>SURGEON FEE</td><td><?php echo $pops[$s][2];$tot_single+=$pops[$s][2];?></td></tr>
								<tr><td>THEATRE CHARGE</td><td><?php echo $pops[$s][3];$tot_single+=$pops[$s][3];?></td></tr>
								<tr><td>ANASTHESIA</td><td><?php echo $pops[$s][4];$tot_single+=$pops[$s][4];?></td></tr>
								<tr><td>OTHER</td><td><?php echo $pops[$s][5];$tot_single+=$pops[$s][5];?></td></tr>
								<tr><td>ASSISTANT FEE1</td><td><?php echo $pops[$s][11];$tot_single+=$pops[$s][11];?></td></tr>
								<tr><td>ASSISTANT FEE2</td><td><?php echo $pops[$s][12];$tot_single+=$pops[$s][12];?></td></tr>
								<tr><th></th><th></th><th></th><th></th><th></th><th><?php echo $tot_single;?></th></tr>
								<?php
								$tot+=$tot_single;
								$tot_paid+=($pops[$s][13]);
								}
								?>
								<tr>
									<td colspan="4" rowspan="3"></td>
									<th>NET TOTAL</th>
									<th><?php echo $tot;?></th>
								</tr>
								<tr>
									<th>AMOUNT PAID</th>
									<th><?php echo $tot_paid;?></th>
								</tr>
								<tr>
									<th>BALANCE AMOUNT</th>
									<th><?php echo $tot-$tot_paid;?></th>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		<!-- </section> -->
	</form>
</div>