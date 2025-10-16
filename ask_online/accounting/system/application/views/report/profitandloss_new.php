<style type="text/css">
	
	div#main-links{
		position: absolute;
		top: 100px;
	}	
	table#table {
	    margin-top: 55px;
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
	td.td-ledger {
		    padding-left: 50px;
		}
	span.tooltiptext {
	    margin-top: 80px !important;
	}	
	th{
		font-weight: 700 !important;
	}			

</style>


<?php
	$this->load->library('accountlist');

	$this->load->model('Setting_model');

	$account_data = $this->Setting_model->get_current();
	$start_date=date("Y-m-d",strtotime($account_data->fy_start));
	$end_date=date("Y-m-d",strtotime($account_data->fy_end));

	$from_date_1 = "";
	$to_date_1   = "";	


	if (!empty($print_preview)) {

		if (empty($from_date['value'])) {
			$from_date_1 = $start_date;
		}
		else{
			$from_date_1 = $from_date['value'];
		}

		if (empty($to_date['value'])) {
			$to_date_1 = $end_date;
		}
		else{
			$to_date_1 = $to_date['value'];
		}

	}
	else{


		if (empty($from_date)) {
			$from_date_1 = $start_date;
		}
		else{
			$from_date_1 = $from_date;
		}

		if (empty($to_date)) {
			$to_date_1 = $end_date;
		}
		else{
			$to_date_1 = $to_date;
		}





	}

	if (!empty($print_preview)) {
		
		$attr=array('id'=>'form');
		echo form_open('report/profitandloss_new',$attr);
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
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";	
		echo "<div>";				
		echo form_submit($data=array('id'=>'submit','name'=>'submit','content'=>'show','value'=>'show'));
		echo "</div>";
		echo "</div>";
		echo form_close();	

		if (!empty($submit_press)) {

			echo "<div id='date_display'>";
				if (!empty($from_date) && !empty($from_date) ) {

					$search_from_display = date('M d Y', strtotime($from_date['value']));
					$search_to_display = date('M d Y', strtotime($to_date['value']));				
					
					echo "<div style='margin-top:20px;font-family: sans-serif;'>";
					echo "Start date : <b style='font-size:15px;color:#dd1136'>".$search_from_display."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
					echo "End date : <b style='font-size:15px;color:#dd1136'>".$search_to_display."</b>";
					echo "</div>";

				}
			echo "</div>";
		}


	}

	echo "<table id='table'>";
	echo "<tr valign=\"top\">";

	/**********************************************************************/
	/*********************** GROSS CALCULATIONS ***************************/
	/**********************************************************************/

	/* Gross P/L : Expenses */




	$ledger_id = 84;

	$total_stock = $this->Ledger_model->get_ledger_balance_search_pl($ledger_id,$from_date_1,$to_date_1);


	$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 

	if (!empty($op_balance1[0])) {
		$op_balance_total = $op_balance1[0];
	}
	else{
		$op_balance_total = 0;
	}

	$current_total = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date_1); 

	if (!empty($current_total)) {

		$op_sum=0;
					
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

	if ($ledger_id == 84) {

		$opening_stock_real = $op_sum;

		$closing_stock_real = $op_sum+$total_stock;

	}

	// $opening_stock_real = 4;
	// $closing_stock_real = 2;

	$gross_profit_cd = $closing_stock_real - $opening_stock_real;

	$gross_profit_bd = $gross_profit_cd;


	$expense_id[] = 4;
	$group_id[]   = 4;

	$expense_sum = 0;
	$income_sum  = 0;
	$opening_stock_sum = 0;

	$opening_stock= "";


	$this->db->from('groups')->where('parent_id', 4);
	$expense_list_q = $this->db->get();
	foreach ($expense_list_q->result() as $row)
	{
		$expense_id[] = $row->id;
	}


	$this->db->from('groups')->where_in('parent_id', $expense_id);
	$expense_list_q = $this->db->get();

	foreach ($expense_list_q->result() as $row)
	{
		$group_id[] = $row->id;
	}

	$this->db->from('ledgers')->where_in('group_id', $group_id);
	$child_ledger_q = $this->db->get();

	echo "<td width=\"" . $left_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Expenses</th><th align=\"right\">Amount</th></tr></thead>";

	echo "<tr class=\"tr-ledger\">";
	echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
	echo "&nbsp;" . anchor('#',"To &nbsp;  Opening stock", array('title' => "Opening stock" . ' Opening stock', 'style' => 'color:#000000'));
	echo "</td>";
	echo "<td align=\"right\">" . $opening_stock_real  . "</td>";
	echo "</tr>";

	echo "<tr class=\"tr-ledger\">";
	echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
	echo "";
	echo "</td>";
	echo "<td align=\"right\">" . "0.00"  . "</td>";
	echo "</tr>";

	if ($gross_profit_cd>0) {

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('#',"To &nbsp;  Gross profit c/d", array('title' => "Gross profit c/d" . ' Gross profit c/d', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . $gross_profit_cd  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . ($gross_profit_cd+$opening_stock_real)  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . "0.00"  . "</td>";
		echo "</tr>";



	}
	else{


		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . "0.00"  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . $opening_stock_real  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('#',"To &nbsp;  Gross loss b/d", array('title' => "Gross profit b/d" . ' Gross profit b/d', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . abs($gross_profit_bd)  . "</td>";
		echo "</tr>";



	}


		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\"></td>";
		echo "</tr>";


	foreach ($child_ledger_q->result() as $row)
	{

		$total = $this->Ledger_model->get_ledger_balance_search_pl($row->id,$from_date_1,$to_date_1);

		$expense_sum += $total;

		$op_balance1 = $this->Ledger_model->get_op_balance($row->id); 

		if (!empty($op_balance1[0])) {
			$op_balance_total = $op_balance1[0];
		}
		else{
			$op_balance_total = 0;
		}

		$current_total = $this->Ledger_model->get_op_balance_search($row->id,$from_date_1); 

		if (!empty($current_total)) {

			$op_sum=0;
					
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

		$opening_stock_sum += $op_sum;

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('report/ledgerst/' . $row->id.'/'.$from_date_1.'/'.$to_date_1, "To &nbsp;&nbsp;".$row->name, array('title' => $row->name . ' Ledger Statement', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . $total  . "</td>";
		echo "</tr>";



	}

	echo "</table>";
	echo "</td>";


	$counter1 = 7;
	$income_id[]         = 3;
	$group_id_income[]   = 3;
	$op_sum_expense = 0;
	$closing_stock_sum = 0;

	$this->db->from('groups')->where('parent_id', 3);
	$income_list_q = $this->db->get();
	foreach ($income_list_q->result() as $row)
	{
		$income_id[] = $row->id;
	}


	$this->db->from('groups')->where_in('parent_id', $income_id);
	$income_list_q = $this->db->get();
	foreach ($income_list_q->result() as $row)
	{
		$group_id_income[] = $row->id;

	}

	$this->db->from('ledgers')->where_in('group_id', $group_id_income);
	$child_ledger_q = $this->db->get();
	echo "<td width=\"" . $right_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Incomes</th><th align=\"right\">Amount</th></tr></thead>";


	echo "<tr class=\"tr-ledger\">";
	echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
	echo "";
	echo "</td>";
	echo "<td align=\"right\">" . "0.00"  . "</td>";
	echo "</tr>";

	echo "<tr class=\"tr-ledger\">";
	echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
	echo "&nbsp;" . anchor('#',"By &nbsp;  Closing stock", array('title' => "Closing stock" . ' Closing stock', 'style' => 'color:#000000'));
	echo "</td>";
	echo "<td align=\"right\">" . $closing_stock_real  . "</td>";
	echo "</tr>";

	if ($gross_profit_cd<0) {

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('#',"By &nbsp;  Gross loss c/d", array('title' => "Gross loss c/d" . ' Gross loss c/d', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . abs($gross_profit_cd)  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . (abs($gross_profit_cd)+$closing_stock_real)  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . "0.00"  . "</td>";
		echo "</tr>";



	}
	else{


		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . "0.00"  . "</td>";
		echo "</tr>";

		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\">" . $closing_stock_real  . "</td>";
		echo "</tr>";


		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('#',"By &nbsp;  Gross profit b/d", array('title' => "Gross profit b/d" . ' Gross profit b/d', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . abs($gross_profit_bd)  . "</td>";
		echo "</tr>";


	}


		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
			// echo $this->print_space($this->counter);
		echo "";
		echo "</td>";
		echo "<td align=\"right\"></td>";
		echo "</tr>";



	foreach ($child_ledger_q->result() as $row)
	{

		$total = $this->Ledger_model->get_ledger_balance_search_pl($row->id,$from_date_1,$to_date_1);

		$total = abs($total);

		$income_sum += $total;

		$op_balance1 = $this->Ledger_model->get_op_balance($row->id); 

		if (!empty($op_balance1[0])) {
			$op_balance_total_income = $op_balance1[0];
		}
		else{
			$op_balance_total_income = 0;
		}

		$current_total = $this->Ledger_model->get_op_balance_search($row->id,$from_date_1); 

		if (!empty($current_total)) {

			$op_sum_expense=0;
					
			foreach ($current_total as $key => $value) {
						
				if ($value->op_type=="C") {
					$op_sum_expense = $op_sum_expense-$value->entry_items_amount;
				}
				else if ($value->op_type=="D") {
					$op_sum_expense = $op_sum_expense+$value->entry_items_amount;
				}
				else{
					$op_sum_expense = 0;
				}

			}			
					

		}
		else{
			$op_sum_expense = 0;
		}

		if ($op_balance1[1]=="D") {
			$op_sum_expense = $op_sum_expense + $op_balance_total_income;
		}
		else{
			$op_sum_expense = $op_sum_expense - $op_balance_total_income;
		}

		$closing_stock_sum += $op_sum;



		echo "<tr class=\"tr-ledger\">";
		echo "<td class=\"td-ledger\">";
		// echo $this->print_space($this->counter);
		echo "&nbsp;" . anchor('report/ledgerst/' . $row->id.'/'.$from_date_1.'/'.$to_date_1, "By  &nbsp;&nbsp;".$row->name, array('title' => $row->name . ' Ledger Statement', 'style' => 'color:#000000'));
		echo "</td>";
		echo "<td align=\"right\">" . $total  . "</td>";
		echo "</tr>";




	}


	$profit = $income_sum - $expense_sum;

	// $gross_profit_cd = 4;
	// $profit =2;

	$net_profit_cd   =  $gross_profit_cd + $profit;



	echo "</table>";
	echo "</td>";


	if ($net_profit_cd<0) {

		echo "<tr valign=\"top\">";

		echo "<td width=\"" . $right_width . "\">";
		echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
		echo "<thead><tr><th> - </th><th align=\"right\"> 0.00 </th></tr></thead>";
		echo "</table>";
		echo "</td>";

		echo "<td width=\"" . $left_width . "\">";
		echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
		echo "<thead><tr><th>By Net Loss b/d</th><th align=\"right\">".abs($net_profit_cd)."</th></tr></thead>";
		echo "</table>";
		echo "</td>";

		echo "</tr>";

	}
	else{


		echo "<tr valign=\"top\">";
		echo "<td width=\"" . $left_width . "\">";
		echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
		echo "<thead><tr><th>To Net profit b/d</th><th align=\"right\">".$net_profit_cd."</th></tr></thead>";
		echo "</table>";
		echo "</td>";


		echo "<td width=\"" . $right_width . "\">";
		echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
		echo "<thead><tr><th> - </th><th align=\"right\"> 0.00 </th></tr></thead>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";



	}





	echo "<tr valign=\"top\">";
	echo "<td width=\"" . $left_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th></th><th align=\"right\">".($net_profit_cd+$expense_sum)."</th></tr></thead>";
	echo "</table>";
	echo "</td>";


	echo "<td width=\"" . $right_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th></th><th align=\"right\">".($gross_profit_cd+$income_sum)."</th></tr></thead>";
	echo "</table>";
	echo "</td>";
	echo "</tr>";











	echo "</table>";
	



	// echo "<tr valign=\"top\" class=\"total-area\">";
	// echo "<td>";
	// echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	// echo "<tr valign=\"top\">";
	// echo "<td class=\"bold\">Net profit c/d</td>";
	// echo "<td align=\"right\" class=\"bold\">" . convert_cur($net_profit_cd) . "</td>";
	// echo "</tr>";
	// echo "</td>";

	// echo "<td>";
	// echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	// echo "<tr valign=\"top\">";
	// echo "<td class=\"bold\"></td>";
	// echo "<td align=\"right\" class=\"bold\"></td>";
	// echo "</tr>";




	


?>
<script type="text/javascript">

if ( $('#date_display').length ) {
    $('div#main-links').css('top', '135px');
}

$('form').submit(function(){
    $('#form').submit();
    return false;
});


</script>