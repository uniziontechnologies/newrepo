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

</style>

<?php
	$this->load->library('accountlist');

	if (!empty($print_preview)) {

		$attr=array('id'=>'form');
		echo form_open('report/balancesheet',$attr);
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

	echo "<table border=0 id='table'>";
	echo "<tr valign=\"top\">";
	$liability = new Accountlist();
	echo "<td width=\"" . $left_width . "\">";
	$liability->init(2);
	echo "<table border=0 cellpadding=5 class=\"simple-table balance-sheet-table\" width=\"100%\">";
	echo "<thead><tr><th>Liabilities and Owners Equity</th><th align=\"right\">Amount</th></tr></thead>";
	$liability->account_st_short(0);
	echo "</table>";
	echo "</td>";
	$liability_total = -$liability->total;


	$asset = new Accountlist();
	echo "<td width=\"" . $right_width . "\">";
	$asset->init(1);
	echo "<table border=0 cellpadding=5 class=\"simple-table balance-sheet-table\" width=\"100%\">";
	echo "<thead><tr><th>Assets</th><th align=\"right\">Amount</th></tr></thead>";
	$asset->account_st_short(0);
	echo "</table>";
	echo "</td>";
	$asset_total = $asset->total;
	echo "</tr>";

	$income = new Accountlist();
	$income->init(3);
	$expense = new Accountlist();
	$expense->init(4);
	$income_total = -$income->total;
	$expense_total = $expense->total;
	$pandl = float_ops($income_total, $expense_total, '-');
	$diffop = $this->Ledger_model->get_diff_op_balance();

	/* Liability side */

	$total = $liability_total;

	echo "<tr valign=\"top\" class=\"total-area\">";
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"balance-sheet-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Liability and Owners Equity Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($liability_total) . "</td>";
	echo "</tr>";

	/* If Profit then Liability side, If Loss then Asset side */
	if ($pandl != 0)
	{
		if ($pandl > 0)
		{
			$total = float_ops($total, $pandl, '+');
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Profit & Loss Account (Net Profit)</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur($pandl) . "</td>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}

	/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
	if ($diffop != 0)
	{
		if ($diffop > 0)
		{
			$total = float_ops($total, $diffop, '+');
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Diff in O/P Balance</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur($diffop) . "</td>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}

	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($total) . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";

	/* Asset side */

	$total = $asset_total;

	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"balance-sheet-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Asset Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($asset_total) . "</td>";
	echo "</tr>";

	/* If Profit then Liability side, If Loss then Asset side */
	if ($pandl != 0)
	{
		if ($pandl > 0)
		{
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		} else {
			$total = float_ops($total, -$pandl, '+');
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Profit & Loss Account (Net Loss)</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$pandl) . "</td>";
			echo "</tr>";
		}
	}

	/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
	if ($diffop != 0)
	{
		if ($diffop > 0)
		{
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		} else {
			$total = float_ops($total, -$diffop, '+');
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Diff in O/P Balance</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$diffop) . "</td>";
			echo "</tr>";
		}
	}

	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($total) . "</td>";
	echo "</tr>";
	echo "</table>";

	echo "</td>";
	echo "</tr>";
	echo "</table>";

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