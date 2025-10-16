<script>
$(function () {
	$("#ipno").bind('change', function() {
		
		var visit_id= $(this).val();
		var active_module="patient_ip_bill_history";
		$("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record&active_module="+active_module);
		$("#form").submit();
		
	});
});
</script>

<?php
$billInfo=$this  ->popArr['billInfo'];
$medicine_info=$this  ->popArr['medicine_info'];
$IPbillInfo=$this  ->popArr['IPbillInfo'];
$patient_ipno=$this  ->popArr['patient_ipno'];
$ipno=$this  ->popArr['ipno'];
?>
<!-- Main content -->
<section class="content">
	<div class="box box-info">
		<div class="row">			
			<div class="col-md-offset-7 col-md-2">	
			<input type="hidden" name="ipno" value="<?php echo $patient_ipno; ?>">			
			<!-- 	<select id="ipno" name="ipno" class="form-control">
					<option value=""> Please Select </option>
					<?php
					for ($i=0; $i <count($patient_ipno) ; $i++) { ?>
					<option value="<?php echo $patient_ipno; ?>" <?php if (!empty($ipno) && $patient_ipno==$ipno ) {
						echo "selected";
					} ?> ><?php echo $patient_ipno; ?></option>
					<?php
					}
					?>
				</select> -->
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
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Discharge Bill Info</h3>

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
						<th ><a href="#"><?php echo $lang_cash; ?></a></th>
						<th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						<th ><a href="#"><?php echo $lang_cheque_amount; ?></a></th>
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
						<td><?php echo $IPbillInfo[$i][0];?></td>
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
						<td><?php echo $IPbillInfo[$i][10];?></td>
						<td><?php echo $IPbillInfo[$i][11];?></td>						
						<td><?php echo $IPbillInfo[$i][28];?></td>
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