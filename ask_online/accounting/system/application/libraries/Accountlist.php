<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountlist
{
	var $id = 0;
	var $name = "";
	var $total = 0;
	var $optype = "";
	var $opbalance = 0;
	var $children_groups = array();
	var $children_ledgers = array();
	var $counter = 0;
	public static $temp_max = 0;
	public static $max_depth = 0;
	public static $csv_data = array();
	public static $csv_row = 0;

	function __construct(){		 
	
		return;
	}

	function init($id)
	{
		$CI =& get_instance();
		if ($id == 0)
		{
			$this->id = 0;
			$this->name = "None";
			$this->total = 0;

		} else {
			$CI->db->from('groups')->where('id', $id)->limit(1);
			$group_q = $CI->db->get();
			$group = $group_q->row();
			$this->id = $group->id;
			$this->name = $group->name;
			$this->total = 0;
		}
		$this->add_sub_ledgers();
		$this->add_sub_groups();
	}

	function add_sub_groups()
	{
		$CI =& get_instance();
		$CI->db->from('groups')->where('parent_id', $this->id);
		$child_group_q = $CI->db->get();
		$counter = 0;
		foreach ($child_group_q->result() as $row)
		{
			$this->children_groups[$counter] = new Accountlist();
			$this->children_groups[$counter]->init($row->id);
			$this->total = float_ops($this->total, $this->children_groups[$counter]->total, '+');
			$counter++;
		}
	}
	function add_sub_ledgers()
	{
		
		$CI =& get_instance();
		$CI->load->model('Ledger_model');
		$CI->load->model('Setting_model');

			if (!empty($_SERVER['PATH_INFO'])) {

				$url = $_SERVER['PATH_INFO'];

				$url_split= explode("/", $url);
				
				if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

					$from_date = $url_split[3];
					$to_date = $url_split[4];

				}
				if(!empty($url_split[5])){

					$from_date = $url_split[4];
					$to_date = $url_split[5];

				}

			}

		$CI->db->from('ledgers')->where('group_id', $this->id);
		$child_ledger_q = $CI->db->get();
		$counter = 0;
		foreach ($child_ledger_q->result() as $row)
		{
			$this->children_ledgers[$counter]['id'] = $row->id;
			$this->children_ledgers[$counter]['name'] = $row->name;

			$ledger_id = $row->id;

			if (!empty($from_date) && !empty($to_date) ) {

				$this->children_ledgers[$counter]['total'] = $CI->Ledger_model->get_ledger_balance_search($row->id,$from_date,$to_date);

				$op_balance1 = $CI->Ledger_model->get_op_balance($ledger_id); 

				if (!empty($op_balance1[0])) {
					$op_balance_total = $op_balance1[0];
				}
				else{
					$op_balance_total = 0;
				}

				$current_total = $CI->Ledger_model->get_op_balance_search($ledger_id,$from_date); 

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
				// else if (!empty($op_balance1) && !empty($search_data) ) {
				// 	$opbalance=$op_balance1[0];
				// 	$optype=$op_balance1[1];

					
				// }
				else{
					$opbalance=0;
					$optype=NULL;
				}

				$this->children_ledgers[$counter]['opbalance'] = $opbalance;

				$this->children_ledgers[$counter]['optype']    = $optype;

				$clbalance = $CI->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date); 

				$clbalance_sum = $CI->Ledger_model->get_ledger_balance_bydate_not_sum($ledger_id,$opbalance,$optype,$from_date,$to_date); 

				if ($optype=="D") {
					$clbalance=$clbalance+$op_balance1[0];
				}
				else{

					$clbalance=$clbalance-$op_balance1[0];
				}

				$this->children_ledgers[$counter]['dr_total'] = $clbalance_sum['dr_total'];

				$this->children_ledgers[$counter]['cr_total'] = $clbalance_sum['cr_total'];




				if (empty($clbalance)) {
					$clbalance=0;
				}

				$this->children_ledgers[$counter]['total'] = $clbalance;

				// if ($clbalance>0) {
				// 	$this->children_ledgers[$counter]['optype'] = "Dr";
				// }
				// else if($clbalance<0){
				// 	$this->children_ledgers[$counter]['optype'] = "Cr";
				// }			
				// else{
				// 	$this->children_ledgers[$counter]['optype'] = "";
				// }



				$this->total = float_ops($this->total, $this->children_ledgers[$counter]['total'], '+');


				// if ($row->name=="ABDUL RAZACK MP CAPITAL A/C") {
				// 	var_dump($this->children_ledgers[$counter]['optype'],$this->children_ledgers[$counter]['total']);
				// }


			}
			else{

				$this->children_ledgers[$counter]['total'] = $CI->Ledger_model->get_ledger_balance($row->id);

				list ($this->children_ledgers[$counter]['opbalance'], $this->children_ledgers[$counter]['optype']) = $CI->Ledger_model->get_op_balance($row->id);
				$this->total = float_ops($this->total, $this->children_ledgers[$counter]['total'], '+');

			}


			$counter++;
		}
	}

	/* Display Account list in Balance sheet and Profit and Loss st */
	function account_st_short($c = 0)
	{


					if (!empty($_SERVER['PATH_INFO'])) {

						$url = $_SERVER['PATH_INFO'];

						$url_split= explode("/", $url);
						
						if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

							$from_date = $url_split[3];
							$to_date = $url_split[4];

						}
						if(!empty($url_split[5])){

							$from_date = $url_split[4];
							$to_date = $url_split[5];

						}

					}				

					$CI =& get_instance();
					$CI->load->model('Setting_model');					
					$account_data = $CI->Setting_model->get_current();
					$start_date=$account_data->fy_start;
					$end_date=$account_data->fy_end;

					if (empty($from_date)) {
						$from_date=$start_date;
					}

					if (empty($to_date)) {
						$to_date=$end_date;
					}		

				$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
				$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));	

		
		$this->counter = $c;
		if ($this->id != 0)
		{
			echo "<tr class=\"tr-group\">";
			echo "<td class=\"td-group\">";
			// echo $this->print_space($this->counter);
			echo "&nbsp;" .  $this->name;
			echo "</td>";
			echo "<td align=\"right\">" . convert_amount_dc($this->total)  . "</td>";
			echo "</tr>";
		}
		foreach ($this->children_groups as $id => $data)
		{
			$this->counter++;
			$data->account_st_short($this->counter);
			$this->counter--;
		}
		if (count($this->children_ledgers) > 0)
		{
			$this->counter++;
			foreach ($this->children_ledgers as $id => $data)
			{							

				echo "<tr class=\"tr-ledger\">";
				echo "<td class=\"td-ledger\">";
				// echo $this->print_space($this->counter);
				echo "&nbsp;" . anchor('report/ledgerst/' . $data['id'].'/'.$from_date.'/'.$to_date, $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
				echo "</td>";
				echo "<td align=\"right\">" . convert_amount_dc($data['total'])  . "</td>";
				echo "</tr>";
			}
			$this->counter--;
		}
	}

	/* Display chart of accounts view */
	function account_st_main($c = 0)
	{


					if (!empty($_SERVER['PATH_INFO'])) {

						$url = $_SERVER['PATH_INFO'];

						$url_split= explode("/", $url);
						
						if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

							$from_date = $url_split[3];
							$to_date = $url_split[4];

						}
						if(!empty($url_split[5])){

							$from_date = $url_split[4];
							$to_date = $url_split[5];

						}

					}				

					$CI =& get_instance();
					$CI->load->model('Setting_model');					
					$account_data = $CI->Setting_model->get_current();
					$start_date=$account_data->fy_start;
					$end_date=$account_data->fy_end;

					if (empty($from_date)) {
						$from_date=$start_date;
					}

					if (empty($to_date)) {
						$to_date=$end_date;
					}		

				$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
				$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));	
		
		$this->counter = $c;
		if ($this->id != 0)
		{
			echo "<tr class=\"tr-group\">";
			echo "<td class=\"td-group\">";
			echo $this->print_space($this->counter);
			if ($this->id <= 4)
				echo "&nbsp;<strong>" .  $this->name. "</strong>";
			else
				echo "&nbsp;" .  $this->name;
			echo "</td>";
			echo "<td>Group Account</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";

			if ($this->id <= 4)
			{
				echo "<td class=\"td-actions\"></tr>";
			} else {
				echo "<td class=\"td-actions\">" . anchor('group/edit/' . $this->id , "Edit", array('title' => 'Edit Group', 'class' => 'red-link'));
				echo " &nbsp;" . anchor('group/delete/' . $this->id, img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Delete group')), array('class' => "confirmClick", 'title' => "Delete Group")) . "</td>";
			}
			echo "</tr>";
		}
		foreach ($this->children_groups as $id => $data)
		{
			$this->counter++;
			$data->account_st_main($this->counter);
			$this->counter--;
		}
		if (count($this->children_ledgers) > 0)
		{
			$this->counter++;
			foreach ($this->children_ledgers as $id => $data)
			{
				echo "<tr class=\"tr-ledger\">";
				echo "<td class=\"td-ledger\">";
				echo $this->print_space($this->counter);
				echo "&nbsp;" . anchor('report/ledgerst/' . $data['id'].'/'.$from_date.'/'.$to_date, $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
				echo "</td>";
				echo "<td>Ledger Account</td>";
				echo "<td>" . convert_opening($data['opbalance'], $data['optype']) . "</td>";
				echo "<td>" . convert_amount_dc($data['total']) . "</td>";
				echo "<td class=\"td-actions\">" . anchor('ledger/edit/' . $data['id'], 'Edit', array('title' => "Edit Ledger", 'class' => 'red-link'));

				if ($data['id']!=1 && $data['id']!=373 && $data['id']!=39 && $data['id']!=37 && $data['id']!=35 && $data['id']!=84 && $data['id']!=36 ) {
					echo " &nbsp;" . anchor('ledger/delete/' . $data['id'], img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Delete Ledger')), array('class' => "confirmClick", 'title' => "Delete Ledger"));
				}
				echo "</td>";
				echo "</tr>";
			}
			$this->counter--;
		}
	}

	function print_space($count)
	{
		$html = "";
		for ($i = 1; $i <= $count; $i++)
		{
			$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $html;
	}
	
	/* Build a array of groups and ledgers */
	function build_array()
	{
		$item = array(
			'id' => $this->id,
			'name' => $this->name,
			'type' => "G",
			'total' => $this->total,
			'child_groups' => array(),
			'child_ledgers' => array(),
			'depth' => self::$temp_max,
		);
		$local_counter = 0;
		if (count($this->children_groups) > 0)
		{
			self::$temp_max++;
			if (self::$temp_max > self::$max_depth)
				self::$max_depth = self::$temp_max;
			foreach ($this->children_groups as $id => $data)
			{

				$item['child_groups'][$local_counter] = $data->build_array();
				$local_counter++;
			}
			self::$temp_max--;
		}
		$local_counter = 0;
		if (count($this->children_ledgers) > 0)
		{
			self::$temp_max++;
			foreach ($this->children_ledgers as $id => $data)
			{

				$item['child_ledgers'][$local_counter] = array(
					'id' => $data['id'],
					'name' => $data['name'],
					'type' => "L",
					'total' => $data['total'],
					'child_groups' => array(),
					'child_ledgers' => array(),
					'depth' => self::$temp_max,
				);
				$local_counter++;
			}
			self::$temp_max--;
		}
		return $item;
	}

	/* Show array of groups and ledgers as created by build_array() method */
	function show_array($data)
	{
		echo "<tr>";
		echo "<td>";
		echo $this->print_space($data['depth']);
		echo $data['depth'] . "-";
		echo $data['id'];
		echo $data['name'];
		echo $data['type'];
		echo $data['total'];
		if ($data['child_ledgers'])
		{
			foreach ($data['child_ledgers'] as $id => $ledger_data)
			{
				$this->show_array($ledger_data);
			}
		}
		if ($data['child_groups'])
		{
			foreach ($data['child_groups'] as $id => $group_data)
			{
				$this->show_array($group_data);
			}
		}
		echo "</td>";
		echo "</tr>";
	}

	function to_csv($data)
	{
		$counter = 0;
		while ($counter < $data['depth'])
		{
			self::$csv_data[self::$csv_row][$counter] = "";
			$counter++;
		}

		self::$csv_data[self::$csv_row][$counter] = $data['name'];
		$counter++;

		while ($counter < self::$max_depth + 3)
		{
			self::$csv_data[self::$csv_row][$counter] = "";
			$counter++;
		}
		self::$csv_data[self::$csv_row][$counter] = $data['type'];
		$counter++;

		if ($data['total'] == 0)
		{
			self::$csv_data[self::$csv_row][$counter] = "";
			$counter++;
			self::$csv_data[self::$csv_row][$counter] = "";
		} else if ($data['total'] < 0) {
			self::$csv_data[self::$csv_row][$counter] = "Cr";
			$counter++;
			self::$csv_data[self::$csv_row][$counter] = -$data['total'];
		} else {
			self::$csv_data[self::$csv_row][$counter] = "Dr";
			$counter++;
			self::$csv_data[self::$csv_row][$counter] = $data['total'];
		}

		if ($data['child_ledgers'])
		{
			foreach ($data['child_ledgers'] as $id => $ledger_data)
			{
				self::$csv_row++;
				$this->to_csv($ledger_data);
			}
		}
		if ($data['child_groups'])
		{
			foreach ($data['child_groups'] as $id => $group_data)
			{
				self::$csv_row++;
				$this->to_csv($group_data);
			}
		}
	}

	public static function get_csv()
	{
		return self::$csv_data;
	}
	
	public static function add_blank_csv()
	{
		self::$csv_row++;
		self::$csv_data[self::$csv_row] = array("", "");
		self::$csv_row++;
		self::$csv_data[self::$csv_row] = array("", "");
		return;
	}
	
	public static function add_row_csv($row = array(""))
	{
		self::$csv_row++;
		self::$csv_data[self::$csv_row] = $row;
		return;
	}

	public static function reset_max_depth()
	{
		self::$max_depth = 0;
		self::$temp_max = 0;
	}

	/*
	 * Return a array of sub ledgers with the object
	 * Used in CF ledgers of type Assets and Liabilities
	*/
	function get_ledger_ids()
	{
		$ledgers = array();
		if (count($this->children_ledgers) > 0)
		{
			foreach ($this->children_ledgers as $id => $data)
			{
				$ledgers[] = $data['id'];
			}
		}
		if (count($this->children_groups) > 0)
		{
			foreach ($this->children_groups as $id => $data)
			{
				foreach ($data->get_ledger_ids() as $row)
					$ledgers[] = $row;
			}
		}
		return $ledgers;
	}



	// PRIFIT & LOSS REPORT UPDATES

	function init_pl($id)
	{
		$CI =& get_instance();
		if ($id == 0)
		{
			$this->id = 0;
			$this->name = "None";
			$this->total = 0;

		} else {
			$CI->db->from('groups')->where('id', $id)->limit(1);
			$group_q = $CI->db->get();
			$group = $group_q->row();
			$this->id = $group->id;
			$this->name = $group->name;
			$this->total = 0;
		}
		$this->add_sub_ledgers_pl();
		$this->add_sub_groups_pl();
	}

	function add_sub_groups_pl()
	{
		$CI =& get_instance();
		$CI->db->from('groups')->where('parent_id', $this->id);
		$child_group_q = $CI->db->get();
		$counter = 0;
		foreach ($child_group_q->result() as $row)
		{
			$this->children_groups[$counter] = new Accountlist();
			$this->children_groups[$counter]->init_pl($row->id);
			$this->total = float_ops($this->total, $this->children_groups[$counter]->total, '+');
			$counter++;
		}
	}
	function add_sub_ledgers_pl()
	{
		
		$CI =& get_instance();
		$CI->load->model('Ledger_model');

			if (!empty($_SERVER['PATH_INFO'])) {

				$url = $_SERVER['PATH_INFO'];

				$url_split= explode("/", $url);
				
				if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

					$from_date = $url_split[3];
					$to_date = $url_split[4];

				}
				if(!empty($url_split[5])){

					$from_date = $url_split[4];
					$to_date = $url_split[5];

				}

			}

		$CI->db->from('ledgers')->where('group_id', $this->id);
		$child_ledger_q = $CI->db->get();
		$counter = 0;
		foreach ($child_ledger_q->result() as $row)
		{
			$this->children_ledgers[$counter]['id'] = $row->id;
			$this->children_ledgers[$counter]['name'] = $row->name;

			if (!empty($from_date) && !empty($to_date) ) {

				$this->children_ledgers[$counter]['total'] = $CI->Ledger_model->get_ledger_balance_search_pl($row->id,$from_date,$to_date);

			}
			else{

				$this->children_ledgers[$counter]['total'] = $CI->Ledger_model->get_ledger_balance($row->id);

			}

			// list ($this->children_ledgers[$counter]['opbalance'], $this->children_ledgers[$counter]['optype']) = $CI->Ledger_model->get_op_balance($row->id);
			$this->total = float_ops($this->total, $this->children_ledgers[$counter]['total'], '+');
			$counter++;
		}
	}


	function account_st_short_pl($c = 0)
	{


					if (!empty($_SERVER['PATH_INFO'])) {

						$url = $_SERVER['PATH_INFO'];

						$url_split= explode("/", $url);
						
						if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

							$from_date = $url_split[3];
							$to_date = $url_split[4];

						}
						if(!empty($url_split[5])){

							$from_date = $url_split[4];
							$to_date = $url_split[5];

						}

					}				

					$CI =& get_instance();
					$CI->load->model('Setting_model');					
					$account_data = $CI->Setting_model->get_current();
					$start_date=$account_data->fy_start;
					$end_date=$account_data->fy_end;

					if (empty($from_date)) {
						$from_date=$start_date;
					}

					if (empty($to_date)) {
						$to_date=$end_date;
					}		

				$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
				$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));	

		
		$this->counter = $c;
		if ($this->id != 0)
		{
			echo "<tr class=\"tr-group\">";
			echo "<td class=\"td-group\">";
			// echo $this->print_space($this->counter);
			echo "&nbsp;" .  $this->name;
			echo "</td>";
			echo "<td align=\"right\">" . convert_amount_dc($this->total)  . "</td>";
			echo "</tr>";
		}
		foreach ($this->children_groups as $id => $data)
		{
			$this->counter++;
			$data->account_st_short_pl($this->counter);
			$this->counter--;
		}
		if (count($this->children_ledgers) > 0)
		{
			$this->counter++;
			foreach ($this->children_ledgers as $id => $data)
			{							

				echo "<tr class=\"tr-ledger\">";
				echo "<td class=\"td-ledger\">";
				// echo $this->print_space($this->counter);
				echo "&nbsp;" . anchor('report/ledgerst/' . $data['id'].'/'.$from_date.'/'.$to_date, $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
				echo "</td>";
				echo "<td align=\"right\">" . convert_amount_dc($data['total'])  . "</td>";
				echo "</tr>";
			}
			$this->counter--;
		}
	}

	/* Display chart of accounts view */
	function account_st_main_new($c = 0)
	{
		$dr_sum_total = 0;
		$cr_sum_total = 0;

					if (!empty($_SERVER['PATH_INFO'])) {

						$url = $_SERVER['PATH_INFO'];

						$url_split= explode("/", $url);
						
						if (!empty($url_split[3]) && !empty($url_split[4]) && empty($url_split[5]) ) {

							$from_date = $url_split[3];
							$to_date = $url_split[4];

						}
						if(!empty($url_split[5])){

							$from_date = $url_split[4];
							$to_date = $url_split[5];

						}

					}				

					$CI =& get_instance();
					$CI->load->model('Setting_model');					
					$account_data = $CI->Setting_model->get_current();
					$start_date=$account_data->fy_start;
					$end_date=$account_data->fy_end;

					if (empty($from_date)) {
						$from_date=$start_date;
					}

					if (empty($to_date)) {
						$to_date=$end_date;
					}		

				$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
				$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));	
		
		$this->counter = $c;
		if ($this->id != 0)
		{
			echo "<tr class=\"tr-group\">";
			echo "<td class=\"td-group\">";
			echo $this->print_space($this->counter);
			if ($this->id <= 4)
				echo "&nbsp;<strong>" .  $this->name. "</strong>";
			else
				echo "&nbsp;" .  $this->name;
			echo "</td>";
			echo "<td>Group Account</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";


			echo "</tr>";
		}
		foreach ($this->children_groups as $id => $data)
		{
			$this->counter++;
			$data->account_st_main_new($this->counter);
			$this->counter--;
		}
		if (count($this->children_ledgers) > 0)
		{



			$this->counter++;
			foreach ($this->children_ledgers as $id => $data)
			{

				// $dr_sum_total += $data['dr_total'];

				// $cr_sum_total += $data['cr_total'];

				// echo "<tr class=\"tr-ledger\">";
				// echo "<td class=\"td-ledger\">";
				// echo $this->print_space($this->counter);
				// echo "&nbsp;" . anchor('report/ledgerst/' . $data['id'].'/'.$from_date.'/'.$to_date, $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
				// echo "</td>";
				// echo "<td>Ledger Account</td>";
				// echo "<td>" . convert_opening($data['dr_total'],"D") . "</td>";
				// echo "<td>" . convert_opening($data['cr_total'],"C") . "</td>";
				// echo "</tr>";


				// $sum_total += $data['total'];


				echo "<tr class=\"tr-ledger\">";
				echo "<td class=\"td-ledger\">";
				echo $this->print_space($this->counter);
				echo "&nbsp;" . anchor('report/ledgerst/' . $data['id'].'/'.$from_date.'/'.$to_date, $data['name'], array('title' => $data['name'] . ' Ledger Statement', 'style' => 'color:#000000'));
				echo "</td>";
				echo "<td>Ledger Account</td>";

				if ($data['total']>0) {
					echo "<td>" . convert_amount_dc($data['total']) . "</td>";
					echo "<td>0.00</td>";
					$dr_sum_total += $data['total'];
				}
				else if ($data['total']<0) {
					echo "<td>0.00</td>";
					echo "<td>" . convert_amount_dc($data['total']) . "</td>";
					$cr_sum_total += (-$data['total']);
				}
				else{
					echo "<td>0.00</td>";
					echo "<td>0.00</td>";
				}

				
				
				echo "</tr>";


				
			}


				echo "<tr class=\"tr-ledger\">";
				echo "<td>";
				echo $this->print_enter($this->counter);
				echo "</td>";
				echo "<td style='font-weight:700;'>TOTAL</td>";
				echo "<td style='font-weight:700;'>".convert_opening($dr_sum_total,"D")."</td>";
				echo "<td style='font-weight:700;'>".convert_opening($cr_sum_total,"C")."</td>";
				echo "<td style='font-weight:700;'></td>";
				echo "</tr>";

			$this->counter--;
		}



	}
	function print_enter($count)
	{
		$html = "";
		// for ($i = 1; $i <= $count; $i++)
		// {
			$html = nl2br ("\n");
		// }
		return $html;
	}



}

