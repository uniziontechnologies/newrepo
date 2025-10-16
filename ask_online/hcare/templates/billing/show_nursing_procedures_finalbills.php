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

			<h4>NURSING PROCEDURES</h4>
				<div class="box box-info">
					<div class="box-body">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL NO</th>
								<th>PROCEDURE</th>
								<th>DATE</th>
								<th>NET AMOUNT</th>
							</tr>
							<?php
							$tot = 0;
							if(!empty($pops)){
								for($s=0;$s<sizeof($pops);$s++){
							?>
							<tr>
								<td><?php echo $s+1;?></td>
								<td><?php echo $pops[$s][2];?></td>
								<td><?php echo $pops[$s][4];?></td>
								<td><?php echo $pops[$s][3];?></td>
							</tr>
							<?php
							$tot = $tot+$pops[$s][3];
								}
								?>
							<tr>
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
					
		<!-- </section> -->
	</form>
</div>