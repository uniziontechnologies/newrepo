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
		echo form_open('report/profitandloss',$attr);
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
	$gross_expense_total = 0;
	$this->db->from('groups')->where('parent_id', 4)->where('affects_gross', 1);
	$gross_expense_list_q = $this->db->get();
	echo "<td width=\"" . $left_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Expenses (Gross)</th><th align=\"right\">Amount</th></tr></thead>";
	foreach ($gross_expense_list_q->result() as $row)
	{
		$gross_expense = new Accountlist();
		$gross_expense->init_pl($row->id);
		$gross_expense->account_st_short_pl(0);
		$gross_expense_total = float_ops($gross_expense_total, $gross_expense->total, '+');
	}
	echo "</table>";
	echo "</td>";

	/* Gross P/L : Incomes */
	$gross_income_total = 0;
	$this->db->from('groups')->where('parent_id', 3)->where('affects_gross' , 1);
	$gross_income_list_q = $this->db->get();
	echo "<td width=\"" . $right_width . "\">";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Incomes (Gross)</th><th align=\"right\">Amount</th></tr></thead>";
	foreach ($gross_income_list_q->result() as $row)
	{
		$gross_income = new Accountlist();
		$gross_income->init_pl($row->id);
		$gross_income->account_st_short_pl(0);
		$gross_income_total = float_ops($gross_income_total, $gross_income->total, '+');
	}
	echo "</table>";
	echo "</td>";
	$gross_income_total = -$gross_income_total; /* Converting to positive value since Cr */

	echo "</tr>";

	/* Calculating Gross P/L */
	$grosspl = float_ops($gross_income_total, $gross_expense_total, '-');

	/* Showing Gross P/L : Expenses */
	$grosstotal = $gross_expense_total;
	echo "<tr valign=\"top\" class=\"total-area\">";
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Total Gross Expenses</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($gross_expense_total) . "</td>";
	echo "</tr>";
	if ($grosspl > 0)
	{
		$grosstotal = float_ops($grosstotal, $grosspl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Gross Profit C/O</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur($grosspl) . "</td>";
		echo "</tr>";
	} else if ($grosspl < 0) {
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";

	}
	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($grosstotal) . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";

	/* Showing Gross P/L : Incomes  */
	$grosstotal = $gross_income_total;
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Total Gross Incomes</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($gross_income_total) . "</td>";
	echo "</tr>";
	if ($grosspl > 0)
	{
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";
	} else if ($grosspl < 0) {
		$grosstotal = float_ops($grosstotal, -$grosspl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Gross Loss C/O</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$grosspl) . "</td>";
		echo "</tr>";
	}
	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($grosstotal) . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";
	echo "</tr>";

	echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

	/**********************************************************************/
	/************************* NET CALCULATIONS ***************************/
	/**********************************************************************/

	/* Net P/L : Expenses */
	$net_expense_total = 0;
	$this->db->from('groups')->where('parent_id', 4)->where('affects_gross !=', 1);
	$net_expense_list_q = $this->db->get();
	echo "<tr valign=\"top\">";
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Expenses (Net)</th><th align=\"right\">Amount</th></tr></thead>";
	foreach ($net_expense_list_q->result() as $row)
	{
		$net_expense = new Accountlist();
		$net_expense->init_pl($row->id);
		$net_expense->account_st_short_pl(0);
		$net_expense_total = float_ops($net_expense_total, $net_expense->total, '+');
	}
	echo "</table>";
	echo "</td>";

	/* Net P/L : Incomes */
	$net_income_total = 0;
	$this->db->from('groups')->where('parent_id', 3)->where('affects_gross !=', 1);
	$net_income_list_q = $this->db->get();
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-table\" width=\"100%\">";
	echo "<thead><tr><th>Incomes (Net)</th><th align=\"right\">Amount</th></tr></thead>";
	foreach ($net_income_list_q->result() as $row)
	{	
		$net_income = new Accountlist();
		$net_income->init_pl($row->id);
		$net_income->account_st_short_pl(0);
		$net_income_total = float_ops($net_income_total, $net_income->total, '+');
	}
	echo "</table>";
	echo "</td>";
	$net_income_total = -$net_income_total; /* Converting to positive value since Cr */

	echo "</tr>";

	/* Calculating Net P/L */
	$netpl = float_ops(float_ops($net_income_total, $net_expense_total, '-'), $grosspl, '+');

	/* Showing Net P/L : Expenses */
	$nettotal = $net_expense_total;
	echo "<tr valign=\"top\" class=\"total-area\">";
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Total Expenses</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($nettotal) . "</td>";
	echo "</tr>";
	if ($grosspl > 0)
	{
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";
	} else if ($grosspl < 0) {
		$nettotal = float_ops($nettotal, -$grosspl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Gross Loss B/F</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$grosspl) . "</td>";
		echo "</tr>";
	}
	if ($netpl > 0)
	{
		$nettotal = float_ops($nettotal, $netpl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Net Profit</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur($netpl) . "</td>";
		echo "</tr>";
	} else if ($netpl < 0) {
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";

	}
	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($nettotal) . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";

	/* Showing Net P/L : Incomes */
	$nettotal = $net_income_total;
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"simple-table profit-loss-total-table\" width=\"100%\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Total Incomes</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($nettotal) . "</td>";
	echo "</tr>";
	if ($grosspl > 0)
	{
		$nettotal = float_ops($nettotal, $grosspl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Gross Profit B/F</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur($grosspl) . "</td>";
		echo "</tr>";

	} else if ($grosspl < 0) {
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";
	}
	if ($netpl > 0)
	{
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";
	} else if ($netpl < 0) {
		$nettotal = float_ops($nettotal, -$netpl, '+');
		echo "<tr valign=\"top\">";
		echo "<td class=\"bold\">Net Loss</td>";
		echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$netpl) . "</td>";
		echo "</tr>";
	}
	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($nettotal) . "</td>";
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