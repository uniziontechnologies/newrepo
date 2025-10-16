<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<div  id="content">
	<form name="show_items" id="show_items"  method="post" action="" >
		<?php
		$pops=$this->popArr['pops'];
		// var_dump($pops);exit;
		?>
		<!-- Main content -->
		<!-- <section class="content"> -->

			<h4>Room Rent Credit Bills</h4>
				<div class="box box-info">
					<div class="box-body">
						
						<table class="table table-bordered table-striped">
							<tr>
								<td colspan="2"><h4>ADMITTED DATE : <?php if($pops['room_history'][0][2]){ echo ($pops['room_history'][0][2]->format('d-m-Y'));}?></h4>
								</td>
								<td colspan="2"><h4>CURRENT DATE : <?php if($pops['room_new'][3]){ echo ($pops['room_new'][3]->format('d-m-Y'));}?></h4>
								</td>
							</tr>
							<tr>
								<th>PARTICULAR</th>
								<th>AMOUNT/DAY</th>
								<th>TOTAL DAYS</th>
								<th>NET AMOUNT</th>
							</tr>
							<?php 
							$tot = 0;
								if(!empty($pops['room_history'][0])){
									for($s=0;$s<sizeof($pops['room_history']);$s++){
									?>
							<tr>
								<th colspan="2">FROM : <?php if($pops['room_history'][$s][2]){ echo ($pops['room_history'][0][2]->format('d-m-Y'));}?>
								</th>
								<th colspan="2">TO : <?php if($pops['room_history'][$s][3]){ echo ($pops['room_history'][$s][3]->format('d-m-Y'));}?>
								</th>
							</tr>
							<tr>
								<td>ROOM RENT(<?php echo $pops['room_history'][$s][0];?>)</td>
								<td><?php echo $pops['room_history'][$s][1];?></td>
								<td><?php echo $pops['room_history'][$s][4];?></td>
								<td><?php echo $pops['room_history'][$s][1]*$pops['room_history'][$s][4];
								$tot+=$pops['room_history'][$s][1]*$pops['room_history'][$s][4];
								?></td>
							</tr>
							<tr>
								<td>NURSING CHARGE</td>
								<td><?php echo $pops['room_history'][$s][5];?></td>
								<td><?php echo $pops['room_history'][$s][4];?></td>
								<td><?php echo $pops['room_history'][$s][5]*$pops['room_history'][$s][4];
								$tot+=$pops['room_history'][$s][5]*$pops['room_history'][$s][4];
								?></td>
							</tr>
							<tr>
								<td>MAINTENANCE</td>
								<td><?php echo $pops['room_history'][$s][6];?></td>
								<td><?php echo $pops['room_history'][$s][4];?></td>
								<td><?php echo $pops['room_history'][$s][6]*$pops['room_history'][$s][4];
								$tot+=$pops['room_history'][$s][6]*$pops['room_history'][$s][4];
								?></td>
							</tr>
							<?php if($pops['room_history'][8]==1){?>
							<tr>
								<td><?php echo $lang_bystander_charge?></td>
								<td><?php echo $pops['room_history'][$s][7];?></td>
								<td><?php echo $pops['room_history'][$s][4];?></td>
								<td><?php echo $pops['room_history'][$s][7]*$pops['room_history'][$s][4];
								$tot+=$pops['room_history'][$s][7]*$pops['room_history'][$s][4];
								?></td>
							</tr>
						<?php } }}

								if(!empty($pops['room_new'])){
									?>
							<tr>
								<th colspan="2">FROM : <?php if($pops['room_new'][2]){ echo ($pops['room_new'][2]->format('d-m-Y'));}?>
								</th>
								<th colspan="2">TO : <?php if($pops['room_new'][3]){ echo ($pops['room_new'][3]->format('d-m-Y'));}?>
								</th>
							</tr>
							<tr>
								<td>ROOM RENT(<?php echo $pops['room_new'][0];?>)</td>
								<td><?php echo $pops['room_new'][1];?></td>
								<td><?php echo $pops['room_new'][4];?></td>
								<td><?php echo $pops['room_new'][1]*$pops['room_new'][4];
								$tot+=$pops['room_new'][1]*$pops['room_new'][4];
								?></td>
							</tr>
							<tr>
								<td>NURSING CHARGE</td>
								<td><?php echo $pops['room_new'][5];?></td>
								<td><?php echo $pops['room_new'][4];?></td>
								<td><?php echo $pops['room_new'][5]*$pops['room_new'][4];
								$tot+=$pops['room_new'][5]*$pops['room_new'][4];
								?></td>
							</tr>
							<tr>
								<td>MAINTENANCE</td>
								<td><?php echo $pops['room_new'][6];?></td>
								<td><?php echo $pops['room_new'][4];?></td>
								<td><?php echo $pops['room_new'][6]*$pops['room_new'][4];
								$tot+=$pops['room_new'][6]*$pops['room_new'][4];
								?></td>
							</tr>
							<?php if($pops['room_new'][8]==1){?>
							<tr>
								<td><?php echo $lang_bystander_charge?></td>
								<td><?php echo $pops['room_new'][7];?></td>
								<td><?php echo $pops['room_new'][4];?></td>
								<td><?php echo $pops['room_new'][7]*$pops['room_new'][4];
								$tot+=$pops['room_new'][7]*$pops['room_new'][4];
								?></td>
							</tr>
						<?php } }?>
						<tr>
							<td></td>
							<td></td>
							<th>TOTAL</th>
							<th><?php 
							echo $tot;
							$tot = 0;?>												
							</th>
						</tr>
						</table>
					</div>
				</div>
		<!-- </section> -->
	</form>
</div>