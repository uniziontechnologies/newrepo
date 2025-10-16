<script>
$(function () {
	$("#visit_date").bind('change', function() {
		
		var visit_id= $(this).val();
		var active_module="patient_op_bill_history";
		$("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
		$("#form").submit();
		
	});
});
</script>

<?php
$billInfo=$this  ->popArr['billInfo'];
$medicine_info=$this  ->popArr['medicine_info'];
$patient_visit_date=$this  ->popArr['patient_visit_date'];
$visit_date=$this  ->popArr['visit_date'];
?>
<!-- Main content -->
<section class="content">
	<div class="box box-info">
		<div class="row">			
			<div class="col-md-offset-7 col-md-2">				
				<select id="visit_date" name="visit_date" class="form-control">
					<option value=""> Please Select </option>
					<?php
					for ($i=0; $i <count($patient_visit_date) ; $i++) { ?>
					<option value="<?php echo $patient_visit_date[$i][0]; ?>" <?php if (!empty($visit_date) && $patient_visit_date[$i][0]==$visit_date ) {
						echo "selected";
					} ?> ><?php echo date('d-m-Y',strtotime($patient_visit_date[$i][1])); ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<!-- Default box -->
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Bill Info</h3>
			<table class="table table-bordered table-striped">				
				<thead>
					<tr>
						<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_date; ?></a></th>						
						<th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
						<th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>
						<th ><a href="#"><?php echo $lang_cash; ?></a></th>
						<th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						<th ><a href="#"><?php echo $lang_balance; ?></a></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(!empty($billInfo)){
							$tot_net = 0;
							$tot_cash = 0;
							$tot_card = 0;
							$tot_bal = 0;
						$j=1;
							for($i=0;$i<count($billInfo);$i++) {
								if ($billInfo[$i][1]=="DIRECT") {
									$id_edit[$i]=$billInfo[$i][2];
								}
								else{
									$id_edit[$i]=$billInfo[$i][19];
								}
					?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][16];?></td>						
						<td><?php echo $billInfo[$i][11]; $tot_net += $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][12];?></td>
						<td><?php echo $billInfo[$i][24];	$tot_cash +=$billInfo[$i][24];?></td>
						<td><?php echo $billInfo[$i]['card']; $tot_card +=$billInfo[$i]['card'];?></td>
						<td><?php echo $billInfo[$i][14]; $tot_bal +=$billInfo[$i][14];?></td>
					</tr>
					
					
					<?php } ?>
					<tr>
						<th colspan="3">TOTAL</th>						
						<th ><?php echo $tot_net; ?></th>
						<th ></th>
						<th ><?php echo $tot_cash; ?></th>
						<th ><?php echo $tot_card; ?></th>
						<th ><?php echo $tot_bal; ?></th>
					</tr>
					<?php }?>
					
				</tbody>
			</table>
		</div>
	</div>

	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Pharmacy Bill Info</h3>
			<table width="100%" class="table table-striped table-bordered">
				<tr>
					<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
					<th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
					<th ><a href="#"><?php echo $lang_date; ?></a></th>						
					<th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
					<th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>
					<th ><a href="#"><?php echo $lang_cash; ?></a></th>
					<th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
					<th ><a href="#"><?php echo $lang_checque_amount; ?></a></th>
					<th ><a href="#"><?php echo $lang_balance; ?></a></th>					
				</tr>
				<?php
				if(!empty($medicine_info)){
					$tot_net = 0;
					$tot_cash = 0;
					$tot_card = 0;
					$tot_bal = 0;
					$tot_cheque = 0;
					for($i=0;$i<count($medicine_info);$i++) {
				?>
				<tr>
					<td><?php echo $i+1; ?></td>					
					<td><?php echo $medicine_info[$i][1];?></td>
					<td><?php echo $medicine_info[$i][5];?></td>
					<td><?php echo $medicine_info[$i][10]; $tot_net +=$medicine_info[$i][10];?></td>
					<td><?php echo $medicine_info[$i][15];?></td>
					<td><?php echo $medicine_info[$i][19]; $tot_cash +=$medicine_info[$i][19];?></td>
					<td><?php echo $medicine_info[$i][18]; $tot_card +=$medicine_info[$i][18];?></td>
					<td><?php echo $medicine_info[$i][17]; $tot_cheque +=$medicine_info[$i][17];?></td>
					<td><?php echo $medicine_info[$i][32]; $tot_bal +=$medicine_info[$i][32];?></td>
				</tr>
				<?php } ?>
				<tr>
					<th colspan="3">TOTAL</th>						
					<th ><?php echo $tot_net; ?></th>
					<th ></th>
					<th ><?php echo $tot_cash; ?></th>
					<th ><?php echo $tot_card; ?></th>
					<th ><?php echo $tot_cheque; ?></th>
					<th ><?php echo $tot_bal; ?></th>
				</tr>
				<?php }?>
			</table>
		</div>
	</div>
</section>