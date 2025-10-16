<style type="text/css">
	
	form{
		margin-top: -15px;
	}
	div#main-links{
		position: absolute;
		top: 198px;
	}
	p#show_all {
	    margin: 0;
	}	
	table.reconciliation-summary {
	    margin-top: 55px;
	    margin-bottom: 18px;
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

<script type="text/javascript">

	if ($('#success-box').length > 0) {
	    $('#main-links').css('top', '267px');
	    $('div#success-box').css('margin-bottom', '30px');
	}
		
</script>

<?php
	$this->load->model('Ledger_model');
	if ( ! $print_preview)
	{

			$search_from = $from_date['value'];
			$search_to = $to_date['value'];

			if (empty($search_from)) {
				$search_from=$start_date;
			}
			if (empty($search_to)) {
				$search_to=$end_date;
			}	

			$search_from = date('Y-m-d', strtotime(str_replace('/', '-', $search_from)));
			$search_to = date('Y-m-d', strtotime(str_replace('/', '-', $search_to)));	

			$attr=array('id'=>'form');
		echo form_open('report/reconciliation/' . $reconciliation_type . '/' . $ledger_id,$attr);
		echo "<p>";
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
		echo form_input_ledger('ledger_id', $ledger_id, '', $type = 'reconciliation');
		echo "</p>";
		echo "</div>";
		echo "</div>";			
		echo "<p id='show_all'>";
		echo form_checkbox('show_all', 1, $show_all) . " Show All Entries";
		echo "</p>";
		echo "<p>";
		echo form_submit($data=array('id'=>'submit','name'=>'submit','content'=>'Submit','value'=>'Submit'));
		echo "</p>";
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

	/* Pagination configuration */
	if ( ! $print_preview)
	{
		$pagination_counter = $this->config->item('row_count');
		$page_count = (int)$this->uri->segment(7);
		$page_count = $this->input->xss_clean($page_count);
		if ( ! $page_count)
			$page_count = "0";
		$config['base_url'] = site_url('report/reconciliation/' . $reconciliation_type . '/' . $ledger_id);
		$config['num_links'] = 10;
		$config['per_page'] = $pagination_counter;
		$config['from_date'] = $search_from;
		$config['to_date'] = $search_to;		
		$config['uri_segment'] = 7;
		if ($reconciliation_type == 'all'){

				$sql="SELECT * FROM `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to'";
		}
		else{

			$sql="SELECT * FROM `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' AND `entry_items`.`reconciliation_date` IS NULL";

		}
				$query = $this->db->query($sql);
				$query->result_array();	
				$ledgerst_q = $query;	


		$config['total_rows']=$ledgerst_q->num_rows;		
		$config['full_tag_open'] = '<ul id="pagination-flickr">';
		$config['full_close_open'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_link'] = 'Next &#187;';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&#171; Previous';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$this->pagination->initialize($config);
	}

	if ($ledger_id != 0)
	{	 
		 /* Opening Balance */
		if (!($print_preview)) {
			$op_balance = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from); 
		}
		else{
			$op_balance = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date); 
		}

			if (!empty($op_balance->entry_items_amount)) {
				$opbalance=$op_balance->entry_items_amount;
				$optype=$op_balance->op_type;
			}
			else{
				$opbalance=0;
				$optype=NULL;
			}		

		/* Final Closing Balance */
		if (!($print_preview)) {
			$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$search_from,$search_to); 
		}
		else{
			$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date); 
		}

			if (!empty($clbalance)) {
				$clbalance=$clbalance;
			}
			else{
				$clbalance=0;
			}		


		/* Reconciliation Balance - Dr */

		if (!($print_preview)) {

			$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.dr_total) as dr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='D' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' AND `entry_items`.`reconciliation_date` IS NOT NULL ";
		}
		else{

			$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.dr_total) as dr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='D' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`reconciliation_date` IS NOT NULL ";
		}

				$query = $this->db->query($sql);
				$query->result_array();	
				$dr_total_q = $query;	

			if (!empty($dr_total_q)) {

						foreach ($dr_total_q->result() as $row)
						{

							$reconciliation_dr_total = $row->dr_total_sum;

						}

				}
				else{
					$reconciliation_dr_total=0;
				}

		/* Reconciliation Balance - Cr */

			if (!($print_preview)) {

				$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.cr_total) as cr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='C' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' AND `entry_items`.`reconciliation_date` IS NOT NULL ";

			}
			else{

				$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.cr_total) as cr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='C' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`reconciliation_date` IS NOT NULL ";


			}

				$query = $this->db->query($sql);
				$query->result_array();	
				$cr_total_q = $query;  


			if (!empty($cr_total_q)) {

						foreach ($cr_total_q->result() as $row)
						{

							$reconciliation_cr_total = $row->cr_total_sum;

						}

				}
				else{
					$reconciliation_cr_total=0;
				}								  

		$reconciliation_total = float_ops($reconciliation_dr_total, $reconciliation_cr_total, '-');
		$reconciliation_pending = float_ops($clbalance, $reconciliation_total, '-');

		/* Ledger and Reconciliation Summary */
		echo "<table class=\"reconciliation-summary\">";
		echo "<tr>";
		echo "<td><b>Opening Balance</b></td><td>" . convert_opening($opbalance, $optype) . "</td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Reconciliation Pending</b></td><td>" . convert_amount_dc($reconciliation_pending) . "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><b>Closing Balance</b></td><td>" . convert_amount_dc($clbalance) . "</td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Reconciliation Total</b></td><td>" . convert_amount_dc($reconciliation_total) . "</td>";
		echo "</tr>";
		echo "</table>";

		echo "<br />";
		if ( ! $print_preview)
		{
		
			
			if ($reconciliation_type == 'all'){

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC LIMIT $page_count,$pagination_counter ";

			}
			else{
				 
                  $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`reconciliation_date` IS NULL AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC LIMIT $page_count,$pagination_counter ";
                  
               				
			}

			$query = $this->db->query($sql);
			$query->result_array();
			$ledgerst_q = $query;   			
			
		} else 
			{
		
			$page_count = 0;
			
			if ($reconciliation_type == 'all'){
				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";
			}
			else{
				 $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`reconciliation_date` IS NULL AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";

				} 
			$query = $this->db->query($sql);
			$query->result_array();
			$ledgerst_q = $query;  
		}

		if ( ! $print_preview)
		{
			echo form_open('report/reconciliation/' . $reconciliation_type . '/' . $ledger_id . "/" . $page_count);
		}
		echo "<table border=0 cellpadding=5 class=\"simple-table reconciliation-table\">";

		echo "<thead><tr><th>Date</th><th>No.</th><th>Ledger Name</th><th>Type</th><th>Dr Amount</th><th>Cr Amount</th><th>Reconciliation Date</th></tr></thead>";
		$odd_even = "odd";

		foreach ($ledgerst_q->result() as $row)
		{
			$current_entry_type = entry_type_info($row->entries_entry_type);

			echo "<tr class=\"tr-" . $odd_even;
			if ($row->entry_items_reconciliation_date)
				echo " tr-reconciled";
			echo "\">";
			echo "<td>";
			echo date_mysql_to_php_display($row->entries_date);
			echo "</td>";
			echo "<td>";
			echo anchor('entry/view/' . $current_entry_type['label'] . '/' . $row->entries_id, full_entry_number($row->entries_entry_type, $row->entries_number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a'));
			echo "</td>";

			/* Getting opposite Ledger name */
			echo "<td>";
			echo $this->Ledger_model->get_opp_ledger_name($row->entries_id, $current_entry_type['label'], $row->entry_items_dc, 'html');
			if ($row->entries_narration)
				echo "<div class=\"small-font\">" . character_limiter($row->entries_narration, 50) . "</div>";
			echo "</td>";

			echo "<td>";
			echo $current_entry_type['name'];
			echo "</td>";
			if ($row->entry_items_dc == "D")
			{
				echo "<td>";
				echo convert_dc($row->entry_items_dc);
				echo " ";
				echo $row->entry_items_amount;
				echo "</td>";
				echo "<td></td>";
			} else {
				echo "<td></td>";
				echo "<td>";
				echo convert_dc($row->entry_items_dc);
				echo " ";
				echo $row->entry_items_amount;
				echo "</td>";
			}

			echo "<td>";
			if ( ! $print_preview)
			{
				$reconciliation_date = array(
					'name' => 'reconciliation_date[' . $row->entry_items_id . ']',
					'id' => 'reconciliation_date',
					'maxlength' => '11',
					'size' => '11',
					'value' => '',
				);
				if ($row->entry_items_reconciliation_date)
					$reconciliation_date['value'] = date_mysql_to_php($row->entry_items_reconciliation_date);
				echo form_input_date_restrict($reconciliation_date);
			} else {
				if ($row->entry_items_reconciliation_date)
					echo date_mysql_to_php($row->entry_items_reconciliation_date);
				else
					echo "-";
			}
			echo "</td>";
			echo "</tr>";
			$odd_even = ($odd_even == "odd") ? "even" : "odd";
		}

		echo "</table>";
		if ( ! $print_preview)
		{
			echo "<p>";
			echo form_submit('submit', 'Update');
			echo "</p>";
			echo form_close();
		}
	}
?>
<?php if ( ! $print_preview) { ?>
<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
<?php } ?>


<script type="text/javascript">
	$('form').submit(function(){
    $('#form').submit();
    return false;
});
</script>