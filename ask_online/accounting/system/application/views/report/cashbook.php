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

	$this->load->model('Ledger_model');
	if ( ! $print_preview)
	{
		$search_from=$from_date['value'];
		$search_to=$to_date['value'];	
		$ledger_id=1;
		$attr=array('id'=>'form');
		echo form_open('report/cashbook/' . $ledger_id,$attr);
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
		// echo form_input_ledger('ledger_id', $ledger_id);
		echo " ";
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

	/* Pagination configuration */
	if ( ! $print_preview)
	{
		$pagination_counter = $this->config->item('row_count');
		$page_count = (int)$this->uri->segment(6);
		$page_count = $this->input->xss_clean($page_count);
		if ( ! $page_count)
			$page_count = "0";
		$config['base_url'] = site_url('report/cashbook/' . $ledger_id);
		$config['num_links'] = 10;
		$config['per_page'] = $pagination_counter;
		$config['from_date'] = $search_from;
		$config['to_date'] = $search_to;
		$config['uri_segment'] = 6;

		if ($ledger_id==0) {
			$sql="SELECT * FROM `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to'";
		}
		else{
			$sql="SELECT * FROM `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to'";
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

	if ($ledger_id != "")
	{

		/* Opening Balance */
		if (!($print_preview)) {

			$fy_start = date('Y-m-d',strtotime($account_data->fy_start));

			
			
			if ($search_from == $fy_start) {
				$search_data="YES";
				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 
			}
			else{
				// $op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from); 

				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 

				if (!empty($op_balance1[0])) {
					$op_balance_total = $op_balance1[0];
				}
				else{
					$op_balance_total = 0;
				}

				$current_total = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from); 

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








			}


		}
		else{

			$fy_start = date('Y-m-d',strtotime($account_data->fy_start));

			if ($from_date == $fy_start) {
				$search_data="YES";
				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 
			}
			else{
				// $op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date); 

				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 

				if (!empty($op_balance1[0])) {
					$op_balance_total = $op_balance1[0];
				}
				else{
					$op_balance_total = 0;
				}

				$current_total = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date); 

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

					// $op_sum = $op_sum + $op_balance_total;
				
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






			}
			
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

		/* Final Closing Balance */

		if (!($print_preview)) {
			$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$search_from,$search_to); 
		}
		else{
			$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date); 
		}

		// var_dump($optype,$clbalance,$op_balance1[0]);
		// if ($optype=="D") {
			$clbalance=$clbalance+$op_balance1[0];
		// }
		// else{

		// 	$clbalance=$clbalance-$op_balance1[0];
		// }


			if (empty($clbalance)) {
				$clbalance=0;
			}


			if ($clbalance>0) {
				$clbalance = "Dr ".convert_cur($clbalance);
			}
			else if($clbalance<0){
				$clbalance = "Cr ".convert_cur(abs($clbalance));
			}			
			else{
				$clbalance = 0;
			}

		if ($ledger_id != "0" || !empty($ledger_id)) {
					echo "<table class=\"ledger-summary\" style='margin-top:60px;'>";
					echo "<tr>";
					echo "<td><b>Opening Balance</b></td><td>" . convert_opening($opbalance,$optype) . "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><b>Closing Balance</b></td><td>" . $clbalance . "</td>";
					echo "</tr>";
					echo "</table>";
					echo "<br />";
		}


		if ( ! $print_preview) {

			if ($ledger_id != 0) {

			        $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC LIMIT $page_count,$pagination_counter";
				    $query = $this->db->query($sql);
				    $query->result_array();	
				    $ledgerst_q = $query;

			}
			else{
			        $sql = "SELECT entries.id AS entries_id, entries.number AS entries_number, entries.date AS entries_date, entries.narration AS entries_narration, entries.entry_type AS entries_entry_type, entry_items.amount AS entry_items_amount, entry_items.dc AS entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE `entry_items`.`ledger_id` != 0 AND `entries`.`date` >=  '$search_from' AND  `entries`.`date` <=  '$search_to' ORDER BY  `entries`.`date` ASC ,  `entries`.`number` ASC LIMIT $page_count,$pagination_counter";

				    $query = $this->db->query($sql);
				    $query->result_array();	
				    $ledgerst_q = $query;
			}



		} else {

			$page_count = 0;

			if ($ledger_id != 0) {

			$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";
			}
			else{

			$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";

			}

				$query = $this->db->query($sql);
				$query->result_array();
				$ledgerst_q = $query;


		}

		echo "<table border=0 cellpadding=5 class=\"simple-table ledgerst-table\">";
		echo "<thead><tr><th>Date</th><th>No.</th><th>Ledger Name</th><th>Type</th><th>Dr Amount</th><th>Cr Amount</th><th>Balance</th></tr></thead>";

		$odd_even = "odd";
		$cur_balance = 0;
		$dr_sum=0;
		$cr_sum=0;


		if ($page_count <= 0)
		{
			/* Opening balance */
			if ($optype == "D")
			{
				echo "<tr class=\"tr-balance\"><td colspan=6>Opening Balance</td><td>" . convert_opening($opbalance, $optype) . "</td></tr>";
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			} else {
				echo "<tr class=\"tr-balance\"><td colspan=6>Opening Balance</td><td>" . convert_opening($opbalance, $optype) . "</td></tr>";
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			}
		} else {
			/* Opening balance */
			if ($optype == "D")
			{
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			} else {
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			}

			/* Calculating previous balance */

			if ($ledger_id != 0 ) {
				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC LIMIT 0,$page_count";
			}
			else{
				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC LIMIT 0,$page_count";
			}

			
				$query = $this->db->query($sql);
				$query->result_array();	
				$prevbal_q = $query;
			foreach ($prevbal_q->result() as $row )
			{
				if ($row->entry_items_dc == "D")
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '+');
				else
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '-');
			}

			/* Show new current total */
			echo "<tr class=\"tr-balance\"><td colspan=6>Opening</td><td>" . convert_opening_custom($cur_balance) . "</td></tr>";
		}

		foreach ($ledgerst_q->result() as $row)
		{
			$current_entry_type = entry_type_info($row->entries_entry_type);

			echo "<tr class=\"tr-" . $odd_even . "\">";
			echo "<td>";
			echo date_mysql_to_php_display($row->entries_date);
			echo "</td>";
			echo "<td>";
			echo anchor('entry/view/' . $current_entry_type['label'] . '/' . $row->entries_id, full_entry_number($row->entries_entry_type, $row->entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
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
				$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '+');
				echo "<td>";
				echo convert_dc($row->entry_items_dc);
				echo " ";
				echo $row->entry_items_amount;
				echo "</td>";
				echo "<td></td>";
			} else {
				$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '-');
				echo "<td></td>";
				echo "<td>";
				echo convert_dc($row->entry_items_dc);
				echo " ";
				echo $row->entry_items_amount;
				echo "</td>";
			}
			echo "<td>";
			echo convert_amount_dc($cur_balance);
			echo "</td>";
			echo "</tr>";
			$odd_even = ($odd_even == "odd") ? "even" : "odd";

			if ($row->entry_items_dc == "D")
			{
				$dr_sum += $row->entry_items_amount; 
			} 
			else {
				$cr_sum += $row->entry_items_amount;
			}

		}

		/* Current Page Closing Balance */
		echo "<tr class=\"tr-balance\"><td colspan=1>Closing</td><td></td><td></td><td></td><td>Dr ".$dr_sum."</td><td>Cr ".$cr_sum."</td><td style='color:#dd1136 !important;'>" .  convert_amount_dc($cur_balance) . "</td></tr>";
		echo "</table>";
		
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


	if ($('.ledger-summary').length == 0) {

	    $('.simple-table').css('margin-top', '60px');
	    // $('.tr-balance').css('display', 'none');
	    
	}
		
</script>