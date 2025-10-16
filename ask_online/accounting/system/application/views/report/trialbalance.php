<style type="text/css">

	div#main-links{
		position: absolute;
		top: 135px;
	}
	.tooltip {
	    position: relative;
	    display: inline-block;
	}

	.tooltip .tooltiptext {
	    visibility: hidden;
	    width: 315px;
	    background-color: black;
	    color: #fff;
	    text-align: center;
	    border-radius: 6px;
	    padding: 15px 0;
	    position: absolute;
	    z-index: 1;
	    top: 150%;
	    left: 50%;
	    margin-left: -60px;
	}

	.tooltip .tooltiptext::after {
	    /*content: "";*/
	    position: absolute;
	    bottom: 100%;
	    left: 20%;
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: transparent transparent black transparent;
	}

	.tooltip:hover .tooltiptext {
	    visibility: visible;
	}
	span.tooltiptext {
	    margin-top: 80px !important;
	}	

</style>

<?php
	$temp_dr_total = 0;
	$temp_cr_total = 0;
	$account_fy_start = $this->config->item('account_fy_start');
	$account_fy_end   = $this->config->item('account_fy_end');
	$account_fy_start = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_start)));
	$account_fy_end = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_end)));


		$search_from=$from_date['value'];
		$search_to=$to_date['value'];

		if (empty($show_search)) {

			$attr=array('id'=>'form');
			echo form_open('report/trialbalance',$attr);
			echo "<div style='display:flex;'>";
			echo "<div>";
			echo form_label('Start Date', 'from_date');
			echo " ";
			echo form_input_date_restrict($from_date);
			echo "<div class='tooltip'>";?>
			<img src="<?php echo asset_url(); ?>images/icons/info_icon.png" width="15" height="15" style="margin-left: 5px;">
			<?php
			echo "<span class='tooltiptext'>Note : Leave start date as empty if you want statement from the start of the financial year.</span>";
			echo "</div>";
			echo "</div>";
			echo "&nbsp;&nbsp;&nbsp;";
			echo "<div>";
			echo form_label('End Date', 'to_date');
			echo " ";	
			echo form_input_date_restrict($to_date);
			echo "<div class='tooltip'>";?>
			<img src="<?php echo asset_url(); ?>images/icons/info_icon.png" width="15" height="15" style="margin-left: 5px;">
			<?php
			echo "<span class='tooltiptext'>Note : Leave end date as empty if you want statement till the end of the financial year.</span>";
			echo "</div>";
			echo "</div>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
			echo "<div>";				
			echo form_submit($data=array('id'=>'submit','name'=>'submit','content'=>'show','value'=>'show'));
			echo "</div>";
			echo "</div>";
			echo form_close();

			if (!empty($submit_press)) {

				if (!empty($search_from) && !empty($search_to) ) {

					$search_from_display = date('M d Y', strtotime($search_from));
					$search_to_display = date('M d Y', strtotime($search_to));				
							
					echo "<div style='margin-top:20px;font-family: sans-serif;'>";
					echo "Start date : <b style='font-size:15px;color:#dd1136'>".$search_from_display."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
					echo "End date : <b style='font-size:15px;color:#dd1136'>".$search_to_display."</b>";
					echo "</div>";

				}
			}

		}		


	echo "<table border=0 cellpadding=5 class=\"simple-table trial-balance-table\" style='margin-top:70px;'>";
	echo "<thead><tr><th>Ledger Account</th><th>O/P Balance</th><th>Dr Total</th><th>Cr Total</th><th>C/L Balance</th></tr></thead>";
	$this->load->model('Ledger_model');
	$all_ledgers = $this->Ledger_model->get_all_ledgers();
	$odd_even = "odd";

	foreach ($all_ledgers as $ledger_id => $ledger_name)
	{
		if ($ledger_id == 0) continue;
		echo "<tr class=\"tr-" . $odd_even . "\">";

		echo "<td>";
		echo  anchor('report/ledgerst/' . $ledger_id.'/'.$search_from.'/'.$search_to, $ledger_name, array('title' => $ledger_name . ' Ledger Statement', 'class' => 'anchor-link-a'));
		echo "</td>";

		echo "<td>";

			if ($search_from == $account_fy_start) {
				$search_data="YES";
				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 
			}
			else{

				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 

				if (!empty($op_balance1[0])) {
					$op_balance_total = $op_balance1[0];
				}
				else{
					$op_balance_total = 0;
				}

				$current_total = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from); 

				$op_sum=0;

				if (!empty($current_total)) {

					
					foreach ($current_total as $key => $value) {
						
						if ($value->op_type=="C") {
							$op_sum = $op_sum-$value->entry_items_amount;
						}
						else if ($value->op_type=="D") {
							$op_sum = $op_sum+$value->entry_items_amount;
						}
						else{
							$op_sum = 0;
						}

					}

				}
				else{
					$op_sum = 0;
				}


				if ($op_balance1[1]=="D") {
					$op_sum = $op_sum + $op_balance_total;
				}
				else{
					$op_sum = $op_sum - $op_balance_total;
				}

				$op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from); 
			}

			if (!empty($op_sum)) {
				$opbalance=$op_sum;
				// $optype=$op_balance2->op_type;
				if ($opbalance>0) {
					$optype="D";
				}
				else if ($opbalance<0) {
					$optype="C";
				}

				$opbalance = abs($opbalance);

			}
			else if (!empty($op_balance1) && !empty($search_data) ) {
				$opbalance=$op_balance1[0];
				$optype=$op_balance1[1];
			}
			else{
				$opbalance=0;
				$optype=NULL;
			}

		// list ($opbal_amount, $opbal_type) = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from);
		echo convert_opening($opbalance,$optype);
		echo "</td>";


		echo "<td>";
		$dr_total = $this->Ledger_model->get_dr_total_search_trial($ledger_id,$search_from,$search_to);
		if ($dr_total)
		{
			echo $dr_total;
			$temp_dr_total = float_ops($temp_dr_total, $dr_total, '+');
		} else {
			echo "0";
		}
		echo "</td>";
		echo "<td>";
		$cr_total = $this->Ledger_model->get_cr_total_search_trial($ledger_id,$search_from,$search_to);
		if ($cr_total)
		{
			echo $cr_total;
			$temp_cr_total = float_ops($temp_cr_total, $cr_total, '+');
		} else {
			echo "0";
		}
		echo "</td>";



		echo "<td>";
		// $clbal_amount = $this->Ledger_model->get_ledger_balance($ledger_id);
		$clbal_amount = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$search_from,$search_to); 

		if ($optype=="D") {
			$clbal_amount=$clbal_amount+$op_balance1[0];
		}
		else{

			$clbal_amount=$clbal_amount-$op_balance1[0];
		}


			if (empty($clbal_amount)) {
				$clbal_amount=0;
			}


			if ($clbal_amount>0) {
				$clbal_amount = "Dr ".convert_cur($clbal_amount);
			}
			else if($clbal_amount<0){
				$clbal_amount = "Cr ".convert_cur(abs($clbal_amount));
			}			
			else{
				$clbal_amount = 0;
			}

		echo $clbal_amount;
		echo "</td>";


		echo "</tr>";
		$odd_even = ($odd_even == "odd") ? "even" : "odd";
	}
	echo "<tr class=\"tr-total\"><td colspan=3>TOTAL ";
	if (float_ops($temp_dr_total, $temp_cr_total, '=='))
		echo "<img src=\"" . asset_url() . "images/icons/match.png\">";
	else
		echo "<img src=\"" . asset_url() . "images/icons/nomatch.png\">";
	echo "</td><td>Dr " . convert_cur($temp_dr_total) . "</td><td>Cr " . convert_cur($temp_cr_total) . "</td></tr>";
	echo "</table>";

