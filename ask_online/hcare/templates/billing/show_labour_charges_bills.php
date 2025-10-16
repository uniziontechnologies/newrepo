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
			<h4>Labour Bills</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>BILL NO</th>
								<th>TEST NO</th>
								<th>PROCEDURE</th>
								<th>GYNEC FEE</th>
								<th>ROOM CHARGES</th>
								<th>TEST AMOUNT</th>
								<th>DISCOUNT</th>
								<th>GYNEC FEE/D</th>
								<th>ROOM CHARGES/D</th>
								<th>NET AMOUNT</th>
								<th>AMOUNT PAID</th>
								<th>BALANCE AMOUNT</th>
							</tr>
							<?php
							$tot = 0;
							if(!empty($pops)){
								for($s=0;$s<sizeof($pops);$s++){
									if($pops[$s][2]-$pops[$s][3]!=0){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $pops[$s][0];?></td>
								<td><?php echo $pops[$s][1];?></td>
								<td><?php echo $pops[$s][7];?></td>
								<td><?php echo $pops[$s][8];?></td>
								<td><?php echo $pops[$s][9];?></td>
								<td><?php echo $pops[$s][2];?></td>
								<td><?php echo $pops[$s][5];?></td>
								<?php
									$g_d = $pops[$s][8]-($pops[$s][5]/2);
									$r_d = $pops[$s][9]-($pops[$s][5]/2);
								?>
								<td><?php echo $g_d;?></td>
								<td><?php echo $r_d;?></td>
								<td><?php echo $pops[$s][6];?></td>
								<td><?php echo $pops[$s][10];?></td>
								<td><?php echo $pops[$s][11];?></td>
							</tr>
							<?php
							$tot_g_d += $g_d;
							$tot_r_d += $r_d;
							$tot = $tot+$pops[$s][11];
								}
								}
								?>
							<tr>
								<td colspan="7"></td>
								<th>Total</th>
								<th><?php echo $tot_g_d;?></th>
								<th><?php echo $tot_r_d;?></th>
								<td colspan="2"></td>
								<th><?php echo $tot;?></th>
							</tr>
								<?php
							}
							?>
						</table>
					</div>
				</div>
					
		<!-- </section> -->
	</form>
</div>