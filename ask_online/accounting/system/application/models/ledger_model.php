<?php

class Ledger_model extends Model {

	function __construct()
	{
		// parent::Model();
		parent::__construct();
	}

	function get_all_ledgers()
	{
		$options = array();
		$options[0] = "(Select All Ledgers)";
		$this->db->from('ledgers')->order_by('name', 'asc');
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{

			$options[$row->id] = $row->name;
		}
		return $options;
	}

	function get_all_ledgers_bankcash()
	{
		$options = array();
		$options[0] = "(Please Select)";
		$this->db->from('ledgers')->where('type', 1)->order_by('name', 'asc');
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{
			$options[$row->id] = $row->name;
		}
		return $options;
	}

	function get_all_ledgers_nobankcash()
	{
		$options = array();
		$options[0] = "(Please Select)";
		$this->db->from('ledgers')->where('type !=', 1)->order_by('name', 'asc');
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{
			$options[$row->id] = $row->name;
		}
		return $options;
	}

	function get_all_ledgers_reconciliation()
	{
		$options = array();
		$options[0] = "(Please Select)";
		$this->db->from('ledgers')->where('reconciliation', 1)->order_by('name', 'asc');
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{
			$options[$row->id] = $row->name;
		}
		return $options;
	}

	function get_name($ledger_id)
	{
		$this->db->from('ledgers')->where('id', $ledger_id)->limit(1);
		$ledger_q = $this->db->get();
		if ($ledger = $ledger_q->row())
			return $ledger->name;
		else if ($ledger_id==0) {
			return "All";
		}
		else
			return "(Error)";
	}

	function get_entry_name($entry_id, $entry_type_id)
	{
		/* Selecting whether to show debit side Ledger or credit side Ledger */
		$current_entry_type = entry_type_info($entry_type_id);
		$ledger_type = 'C';

		if ($current_entry_type['bank_cash_ledger_restriction'] == 3)
			$ledger_type = 'D';

		$this->db->select('ledgers.name as name');
		$this->db->from('entry_items')->join('ledgers', 'entry_items.ledger_id = ledgers.id')->where('entry_items.entry_id', $entry_id)->where('entry_items.dc', $ledger_type);
		$ledger_q = $this->db->get();
		if ( ! $ledger = $ledger_q->row())
		{
			return "(Invalid)";
		} else {
			$ledger_multiple = ($ledger_q->num_rows() > 1) ? TRUE : FALSE;
			$html = '';
			if ($ledger_multiple)
				$html .= anchor('entry/view/' . $current_entry_type['label'] . "/" . $entry_id, "(" . $ledger->name . ")", array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a'));
			else
				$html .= anchor('entry/view/' . $current_entry_type['label'] . "/" . $entry_id, $ledger->name, array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a'));
			return $html;
		}
		return;
	}

	function get_opp_ledger_name($entry_id, $entry_type_label, $ledger_type, $output_type)
	{
		$output = '';
		if ($ledger_type == 'D')
			$opp_ledger_type = 'C';
		else
			$opp_ledger_type = 'D';
		$this->db->from('entry_items')->where('entry_id', $entry_id)->where('dc', $opp_ledger_type);
		$opp_entry_name_q = $this->db->get();
		if ($opp_entry_name_d = $opp_entry_name_q->row())
		{
			$opp_ledger_name = $this->get_name($opp_entry_name_d->ledger_id);
			if ($opp_entry_name_q->num_rows() > 1)
			{
				if ($output_type == 'html')
					$output = anchor('entry/view/' . $entry_type_label . '/' . $entry_id, "(" . $opp_ledger_name . ")", array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
				else
					$output = "(" . $opp_ledger_name . ")";
			} else {
				if ($output_type == 'html')
					$output = anchor('entry/view/' . $entry_type_label . '/' . $entry_id, $opp_ledger_name, array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
				else
					$output = $opp_ledger_name;
			}
		}
		return $output;
	}

	function get_ledger_balance($ledger_id)
	{
		list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);

		$dr_total = $this->get_dr_total($ledger_id);
		$cr_total = $this->get_cr_total($ledger_id);

		$total = float_ops($dr_total, $cr_total, '-');
		if ($op_bal_type == "D")
			$total = float_ops($total, $op_bal, '+');
		else
			$total = float_ops($total, $op_bal, '-');

		return $total;
	}

	function get_op_balance($ledger_id)
	{
		$this->db->from('ledgers')->where('id', $ledger_id)->limit(1);
		$op_bal_q = $this->db->get();
		if ($op_bal = $op_bal_q->row())
			return array($op_bal->op_balance, $op_bal->op_balance_dc);
		else
			return array(0, "D");
	}

	function get_diff_op_balance()
	{
		/* Calculating difference in Opening Balance */
		$total_op = 0;
		$this->db->from('ledgers')->order_by('id', 'asc');
		$ledgers_q = $this->db->get();
		foreach ($ledgers_q->result() as $row)
		{
			list ($opbalance, $optype) = $this->get_op_balance($row->id);
			if ($optype == "D")
			{
				$total_op = float_ops($total_op, $opbalance, '+');
			} else {
				$total_op = float_ops($total_op, $opbalance, '-');
			}
		}
		return $total_op;
	}

	/* Return debit total as positive value */
	function get_dr_total($ledger_id)
	{
		$this->db->select_sum('amount', 'drtotal')->from('entry_items')->join('entries', 'entries.id = entry_items.entry_id')->where('entry_items.ledger_id', $ledger_id)->where('entry_items.dc', 'D');
		$dr_total_q = $this->db->get();
		if ($dr_total = $dr_total_q->row())
			return $dr_total->drtotal;
		else
			return 0;
	}

	/* Return credit total as positive value */
	function get_cr_total($ledger_id)
	{
		$this->db->select_sum('amount', 'crtotal')->from('entry_items')->join('entries', 'entries.id = entry_items.entry_id')->where('entry_items.ledger_id', $ledger_id)->where('entry_items.dc', 'C');
		$cr_total_q = $this->db->get();
		if ($cr_total = $cr_total_q->row())
			return $cr_total->crtotal;
		else
			return 0;
	}

	/* Delete reconciliation entries for a Ledger account */
	function delete_reconciliation($ledger_id)
	{
		$update_data = array(
			'reconciliation_date' => NULL,
		);
		$this->db->where('ledger_id', $ledger_id)->update('entry_items', $update_data);
		return;
	}
	function get_ledger_balance_search($ledger_id,$from_date,$to_date)
	{
		$op_balance = $this->get_op_balance_search($ledger_id,$from_date);

			if (!empty($op_balance->entry_items_amount)) {
				$op_bal=$op_balance->entry_items_amount;
				$op_bal_type=$op_balance->op_type;
			}
			else{
				$op_bal=0;
				$op_bal_type=NULL;
			}		

		$dr_total = $this->get_dr_total_search($ledger_id,$from_date,$to_date);
		$cr_total = $this->get_cr_total_search($ledger_id,$from_date,$to_date);

		$total = float_ops($dr_total, $cr_total, '-');
		if ($op_bal_type == "D")
			$total = float_ops($total, $op_bal, '+');
		else
			$total = float_ops($total, $op_bal, '-');

		return $total;
	}
	function get_dr_total_search($ledger_id,$from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }

	    

				$query = $this->db->query($sql);

				$query->result_array();

				$dr_total_q = $query;   

				if (!empty($dr_total_q)) {
					foreach ($dr_total_q->result() as $row)
					{
						return $row->dr_total;
					}
					
				}
				else{
					return 0;
				}

	}

	function get_cr_total_search($ledger_id,$from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
	    

				$query = $this->db->query($sql);

				$query->result_array();

				$cr_total_q = $query;   

				if (!empty($cr_total_q)) {
					foreach ($cr_total_q->result() as $row)
					{
						return $row->cr_total;
					}
					
				}
				else{
					return 0;
				}			

	}

    function get_op_balance_search($ledger_id,$from_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT entries.id as entries_id, entry_items.amount as entry_items_amount, entry_items.dc as op_type  FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` JOIN  `ledgers` ON  `entry_items`.`ledger_id` =  `ledgers`.`id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` < '$from_date' "; 
		// }
		// else{
		// 	$sql = "SELECT sum(entries.id) as entries_id, sum(entry_items.amount) as entry_items_amount, ledgers.op_balance_dc as op_type  FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` JOIN  `ledgers` ON  `entry_items`.`ledger_id` =  `ledgers`.`id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` < '$from_date' "; 
		// }


	    

			$query = $this->db->query($sql);
			$query->result_array();	
			$ledgerst_q = $query;	

				if (!empty($ledgerst_q)) {
					$data=array();
					foreach ($ledgerst_q->result() as $row)
					{
						$data[]=$row;
						
					}

					return $data;
					
				}
				else{
					return 0;
				}

	}

	function get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date)
	{

		$dr_total = $this->get_dr_total_search($ledger_id,$from_date,$to_date);
		$cr_total = $this->get_cr_total_search($ledger_id,$from_date,$to_date);

		$total = float_ops($dr_total, $cr_total, '-');


	

		return $total;
	}	
	function get_all_ledgers_reconciliation_bankbook()
	{
		$options = array();
		$options[0] = "Select All";
		$this->db->from('ledgers')->where('type', 1)->where('reconciliation', 1)->order_by('name', 'asc');
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{
			$options[$row->id] = $row->name;
		}
		return $options;
	}
	function get_dr_total_search_trial($ledger_id,$from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }

	    

				$query = $this->db->query($sql);

				$query->result_array();

				$dr_total_q = $query;   

				if (!empty($dr_total_q)) {
					foreach ($dr_total_q->result() as $row)
					{
						return $row->dr_total;
					}
					
				}
				else{
					return 0;
				}

	}

	function get_cr_total_search_trial($ledger_id,$from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
	    

				$query = $this->db->query($sql);

				$query->result_array();

				$cr_total_q = $query;   

				if (!empty($cr_total_q)) {
					foreach ($cr_total_q->result() as $row)
					{
						return $row->cr_total;
					}
					
				}
				else{
					return 0;
				}			

	}

	// PROFIT & LOSS REPORT UPDATES


	function get_ledger_balance_search_pl($ledger_id,$from_date,$to_date)
	{
		// $op_balance = $this->get_op_balance_search($ledger_id,$from_date);

		$op_balance = 0;

			// if (!empty($op_balance->entry_items_amount)) {
			// 	$op_bal=$op_balance->entry_items_amount;
			// 	$op_bal_type=$op_balance->op_type;
			// }
			// else{
			// 	$op_bal=0;
			// 	$op_bal_type=NULL;
			// }		

		$dr_total = $this->get_dr_total_search_pl($ledger_id,$from_date,$to_date);
		$cr_total = $this->get_cr_total_search_pl($ledger_id,$from_date,$to_date);

		$total = float_ops($dr_total, $cr_total, '-');
		// if ($op_bal_type == "D")
		// 	$total = float_ops($total, $op_bal, '+');
		// else
		// 	$total = float_ops($total, $op_bal, '-');

		return $total;
	}

	function get_dr_total_search_pl($ledger_id,$from_date,$to_date)
	{

			$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";


	    

				$query = $this->db->query($sql);

				$query->result_array();

				$dr_total_q = $query;   

				if (!empty($dr_total_q)) {
					foreach ($dr_total_q->result() as $row)
					{
						return $row->dr_total;
					}
					
				}
				else{
					return 0;
				}

	}

	function get_cr_total_search_pl($ledger_id,$from_date,$to_date)
	{

			$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
	    

				$query = $this->db->query($sql);

				$query->result_array();

				$cr_total_q = $query;   

				if (!empty($cr_total_q)) {
					foreach ($cr_total_q->result() as $row)
					{
						return $row->cr_total;
					}
					
				}
				else{
					return 0;
				}			

	}


	
	function get_ledger_balance_bydate_not_sum($ledger_id,$opbalance,$optype,$from_date,$to_date)
	{

		$dr_total = $this->get_dr_total_search_trial($ledger_id,$from_date,$to_date);
		$cr_total = $this->get_cr_total_search_trial($ledger_id,$from_date,$to_date);

		// $total = float_ops($dr_total, $cr_total, '-');

		$data['dr_total'] = $dr_total;
		$data['cr_total'] = $cr_total;
	

		return $data;
	}


	function get_dr_total_search_sum($from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as dr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'D' ";
		// }

	    

				$query = $this->db->query($sql);

				$query->result_array();

				$dr_total_q = $query;   

				if (!empty($dr_total_q)) {
					foreach ($dr_total_q->result() as $row)
					{
						return $row->dr_total;
					}
					
				}
				else{
					return 0;
				}

	}
	function get_cr_total_search_sum($from_date,$to_date)
	{

		// if ($ledger_id != 0) {
			$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
		// else{
		// 	$sql = "SELECT Sum(entry_items.amount) as cr_total FROM  `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' AND `entry_items`.`dc` = 'C' ";
		// }
	    

				$query = $this->db->query($sql);

				$query->result_array();

				$cr_total_q = $query;   

				if (!empty($cr_total_q)) {
					foreach ($cr_total_q->result() as $row)
					{
						return $row->cr_total;
					}
					
				}
				else{
					return 0;
				}				

	}
	function get_all_ledgers_by_group($group_id)
	{
		$options = array();
		$this->db->from('ledgers')->where('id >', 0)->where('group_id', $group_id);
		$ledger_q = $this->db->get();
		foreach ($ledger_q->result() as $row)
		{

			$options[$row->id] = $row->name;
		}
		return $options;
	}




}
