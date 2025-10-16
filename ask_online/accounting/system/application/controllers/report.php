<?php

class Report extends Controller {
	var $acc_array;
	var $account_counter;
	function __construct()
	{
		// parent::Controller();
		parent::__construct();
		$this->load->model('Ledger_model');
		$this->load->model('Group_model');

		/* Check access */
		if ( ! check_access('view reports'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('');
			return;
		}

		return;
	}
	
	function index()
	{
		$this->template->set('page_title', 'Reports');
		$this->template->load('template', 'report/index');
		return;
	}

	function balancesheet($period=NULL,$from_date=NULL,$to_date=NULL)
	{
		/* Loding Model */
		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->template->set('page_title', 'Balance Sheet');

		/* Input fields to view */
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		/* Dump data to view after redirection */
		if (!empty($period) && !empty($from_date) ) {
			$data['submit_press']=TRUE;
			$data['from_date']['value']=$period;
			$data['to_date']['value']=$from_date;
		}				

		/* Taking data from DB */
		$account_data = $this->Setting_model->get_current();
		$data['start_date']=$account_data->fy_start;
		$data['end_date']=$account_data->fy_end;

		if ($_POST)
		{
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);

			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	

			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/balancesheet/'.$a.'/'.$b);
			
		}		

		$this->template->set('nav_links', array('report/download/balancesheet/'.$period.'/'.$from_date => 'Download CSV', 'report/printpreview/balancesheet/'.$period.'/'.$from_date => 'Print Preview'));	

		$data['left_width'] = "500";
		$data['right_width'] = "500";
		$data['print_preview'] = "YES";
		$this->template->load('template', 'report/balancesheet', $data);
		return;
	}

	function profitandloss($period = NULL,$from_date=NULL,$to_date=NULL)
	{
		/* Loding Model */
		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->template->set('page_title', 'Profit And Loss Statement');

		/* Input fields to view */
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);			

		/* Dump data to view after redirection */
		if (!empty($period) && !empty($from_date) ) {
			$data['submit_press']=TRUE;
			$data['from_date']['value']=$period;
			$data['to_date']['value']=$from_date;
		}			

		/* Taking data from DB */
		$account_data = $this->Setting_model->get_current();
		$data['start_date']=$account_data->fy_start;
		$data['end_date']=$account_data->fy_end;

		if ($_POST)
		{
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);

				if (empty($a)) {
					$a=$data['start_date'];
				}
				if (empty($b)) {
					$b=$data['end_date'];
				}	

				$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
				$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));	
				
				redirect('report/profitandloss/'.$a.'/'.$b);		
		}		

		$this->template->set('nav_links', array('report/download/profitandloss/'.$period.'/'.$from_date => 'Download CSV', 'report/printpreview/profitandloss/'.$period.'/'.$from_date => 'Print Preview'));
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$data['print_preview'] = "YES";
		$this->template->load('template', 'report/profitandloss', $data);
		return;
	}

	function trialbalance($from_date=NULL,$to_date=NULL)
	{


		/* Loading Helper */
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		/* Input fields to view */
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		if (!empty($from_date) && !empty($to_date) ) {
			$data['from_date']['value']=$from_date;
			$data['to_date']['value']=$to_date;
			$data['submit_press'] = TRUE;
			$data['account_data']=$account_data = $this->Setting_model->get_current();
		}



		if ($_POST)
		{
			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['start_date']=$account_data->fy_start;
			$data['end_date']=$account_data->fy_end;			
			$ledger_id = $this->input->post('ledger_id', TRUE);
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);
			
			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	
			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/trialbalance/'.$a.'/'.$b);
		}


		$this->template->set('page_title', 'Trial Balance');
		$this->template->set('nav_links', array('report/download/trialbalance/'.$from_date.'/'.$to_date => 'Download CSV', 'report/printpreview/trialbalance/'.$from_date.'/'.$to_date => 'Print Preview'));
		$this->load->library('accountlist');
		$this->template->load('template', 'report/trialbalance',$data);
		return;
	}

	function ledgerst($ledger_id = NULL,$from_date=NULL,$to_date=NULL)
	{

		/* Loading Helper */
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		$this->template->set('page_title', 'Ledger Statement');
		
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		if (!empty($from_date) && !empty($to_date) ) {
			$data['from_date']['value']=$from_date;
			$data['to_date']['value']=$to_date;
			$data['submit_press'] = TRUE;
			$data['account_data']=$account_data = $this->Setting_model->get_current();
		}

		if ($_POST)
		{
			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['start_date']=$account_data->fy_start;
			$data['end_date']=$account_data->fy_end;			
			$ledger_id = $this->input->post('ledger_id', TRUE);
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);
			
			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	
			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/ledgerst/' . $ledger_id.'/'.$a.'/'.$b);
		}
		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;

		/* Checking for valid ledger id */
			if ($data['ledger_id'] > 0)
			{
					$this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
					if ($this->db->get()->num_rows() < 1)
					{
						$this->messages->add('Invalid Ledger account.', 'error');
						redirect('report/ledgerst');
						return;
					}
			}
			else if ($data['ledger_id'] == 0) {
				// $this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				$sql="SELECT * FROM (`ledgers`) WHERE `id` !=0";
				$query = $this->db->query($sql);

			} 
			else if ($data['ledger_id'] < 0) {
					$this->messages->add('Invalid Ledger account.', 'error');
					redirect('report/ledgerst');
					return;
			}

			if ($ledger_id != ""){

			       $this->template->set('nav_links', array('report/download/ledgerst/' . $ledger_id.'/'.$from_date.'/'.$to_date  => 'Download CSV', 'report/printpreview/ledgerst/'.$ledger_id.'/'.$from_date.'/'.$to_date => 'Print Preview'));	
			}	

			$this->template->load('template', 'report/ledgerst', $data);
			return;
	}

	function reconciliation($reconciliation_type = '', $ledger_id = 0 , $from_date=NULL,$to_date=NULL)
	{
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		$this->template->set('page_title', 'Reconciliation');

		$fr_date=isset($data['from_date'])?$data['from_date']:$from_date;

		$t_date=isset($data['to_date'])?$data['to_date']:$to_date;	
	
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => $fr_date,
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => $t_date,
		);	

		$account_data = $this->Setting_model->get_current();
		$data['start_date']=$account_data->fy_start;
		$data['end_date']=$account_data->fy_end;		

		/* Check if path is 'all' or 'pending' */
		$data['show_all'] = FALSE;
		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;

		/* Checking for valid ledger id and reconciliation status */
		if ($data['ledger_id'] > 0)
		{
			$this->db->from('ledgers')->where('id', $data['ledger_id'])->where('reconciliation', 1)->limit(1);
			if ($this->db->get()->num_rows() < 1)
			{
				$this->messages->add('Invalid Ledger account or Reconciliation is not enabled for the Ledger account.', 'error');
				redirect('report/reconciliation/' . $reconciliation_type);
				return;
			}
		} else if ($data['ledger_id'] < 0) {
			$this->messages->add('Invalid Ledger account.', 'error');
			redirect('report/reconciliation/' . $reconciliation_type);
			return;
		}

		if ($_POST)
		{
			/* Check if Ledger account is changed or reconciliation is updated */
			if ($_POST['submit'] == 'Submit')
			{
				
				$ledger_id = $this->input->post('ledger_id', TRUE);
				$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
				$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);

					if (empty($a)) {
						$a=$data['start_date'];
					}
					if (empty($b)) {
						$b=$data['end_date'];
					}
					$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
					$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));									

				if ($this->input->post('show_all', TRUE))
				{
					redirect('report/reconciliation/all/' . $ledger_id.'/'.$a.'/'.$b);
					return;
				} else {
					redirect('report/reconciliation/pending/' . $ledger_id.'/'.$a.'/'.$b);
					return;
				}
			} else if ($_POST['submit'] == 'Update') {

				$data_reconciliation_date = $this->input->post('reconciliation_date', TRUE);

				/* Form validations */
				foreach ($data_reconciliation_date as $id => $row)
				{
					/* If reconciliation date is present then check for valid date else only trim */
					if ($row)
						$this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim|required|is_date|is_date_within_range_reconcil');
					else
						$this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim');
				}

				if ($this->form_validation->run() == FALSE)
				{
					$this->messages->add(validation_errors(), 'error');
					$this->template->load('template', 'report/reconciliation', $data);
					return;
				} else {
					/* Updating reconciliation date */
					foreach ($data_reconciliation_date as $id => $row)
					{
						$this->db->trans_start();
						if ($row)
						{
							$update_data = array(
								'reconciliation_date' => date_php_to_mysql($row),
							);
						} else {
							$update_data = array(
								'reconciliation_date' => NULL,
							);
						}
						if ( ! $this->db->where('id', $id)->update('entry_items', $update_data))
						{
							$this->db->trans_rollback();
							$this->messages->add('Error updating reconciliation.', 'error');
							$this->logger->write_message("error", "Error updating reconciliation for entry item [id:" . $id . "]");
						} else {
							$this->db->trans_complete();
						}
					}
					$this->messages->add('Updated reconciliation.', 'success');
					$this->logger->write_message("success", 'Updated reconciliation.');
				}
			}
		}

		if ($reconciliation_type == 'all')
		{
			$data['reconciliation_type'] = 'all';
			$data['show_all'] = TRUE;
			if ($ledger_id > 0){
				$data['submit_press'] = TRUE;
				$this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/all'.'/'.$from_date.'/'.$to_date  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/all'.'/'.$from_date.'/'.$to_date => 'Print Preview'));
			}
		} else if ($reconciliation_type == 'pending') {
			$data['reconciliation_type'] = 'pending';
			$data['show_all'] = FALSE;
			if ($ledger_id > 0){
				$data['submit_press'] = TRUE;
				$this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/pending'.'/'.$from_date.'/'.$to_date  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/pending'.'/'.$from_date.'/'.$to_date  => 'Print Preview'));
			}
		} else {
			$this->messages->add('Invalid path.', 'error');
			redirect('report/reconciliation/pending');
			return;
		}


		$this->template->load('template', 'report/reconciliation', $data);
		return;
	}

	function download($statement, $id = NULL,$from_date=NULL,$to_date=NULL)
	{
		/********************** TRIAL BALANCE *************************/
		if ($statement == "trialbalance")
		{

			$this->load->model('Ledger_model');

			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);
			$data['from_date'] = $from_date_1;
			$data['to_date'] = $to_date_1;	

			$account_fy_start = $this->config->item('account_fy_start');
			$account_fy_end   = $this->config->item('account_fy_end');
			$account_fy_start = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_start)));
			$account_fy_end = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_end)));

			$all_ledgers = $this->Ledger_model->get_all_ledgers();
			$counter = 0;
			$trialbalance = array();
			$temp_dr_total = 0;
			$temp_cr_total = 0;

			$trialbalance[$counter] = array ("TRIAL BALANCE", "", "", "", "", "", "", "", "");
			$counter++;
			$trialbalance[$counter] = array ("FY " . $from_date_1 . " - " . $to_date_1, "", "", "", "", "", "", "", "");
			$counter++;

			$trialbalance[$counter][0]= "Ledger";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "Opening";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "Dr Total";
			$trialbalance[$counter][5]= "";
			$trialbalance[$counter][6]= "Cr Total";
			$trialbalance[$counter][7]= "";
			$trialbalance[$counter][8]= "Closing";
			$counter++;

			foreach ($all_ledgers as $ledger_id => $ledger_name)
			{
				if ($ledger_id == 0) continue;

				$trialbalance[$counter][0] = $ledger_name;

				if ($from_date_1 == $account_fy_start) {
					$search_data_1="YES";
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

					$current_total = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date_1);

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


					$op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date_1); 
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
				else if (!empty($op_balance1) && !empty($search_data_1) ) {
					$opbalance=$op_balance1[0];
					$optype=$op_balance1[1];
				}
				else{
					$opbalance=0;
					$optype=NULL;
				}


				// list ($opbal_amount, $opbal_type) = $this->Ledger_model->get_op_balance($ledger_id);
				if (float_ops($opbalance, 0, '=='))
				{
					$trialbalance[$counter][1] = "";
					$trialbalance[$counter][2] = 0;
				} else {
					$trialbalance[$counter][1] = convert_dc($optype);
					$trialbalance[$counter][2] = convert_opening($opbalance,$optype);
				}

				$clbal_amount = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date_1,$to_date_1);

				// var_dump($optype,$clbalance,$op_balance1[0]);
				// if ($optype=="D") {
				$clbal_amount=$clbal_amount+$op_balance1[0];
				// }
				// else{

				// 	$clbalance=$clbalance-$op_balance1[0];
				// }


				if (empty($clbal_amount)) {
					$clbal_amount=0;
				}


				// if ($clbal_amount>0) {
				// 	$clbal_amount = "Dr ".convert_cur($clbal_amount);
				// }
				// else if($clbal_amount<0){
				// 	$clbal_amount = "Cr ".convert_cur(abs($clbal_amount));
				// }			
				// else{
				// 	$clbal_amount = 0;
				// }



				$dr_total = $this->Ledger_model->get_dr_total_search_trial($ledger_id,$from_date_1,$to_date_1);

				// var_dump($dr_total);exit();

				if ($dr_total)
				{
					$trialbalance[$counter][3] = "Dr";
					$trialbalance[$counter][4] = convert_cur($dr_total);
					$temp_dr_total = float_ops($temp_dr_total, $dr_total, '+');
				} else {
					$trialbalance[$counter][3] = "";
					$trialbalance[$counter][4] = 0;
				}

				$cr_total = $this->Ledger_model->get_cr_total_search_trial($ledger_id,$from_date_1,$to_date_1);
				if ($cr_total)
				{
					$trialbalance[$counter][5] = "Cr";
					$trialbalance[$counter][6] = convert_cur($cr_total);
					$temp_cr_total = float_ops($temp_cr_total, $cr_total, '+');
				} else {
					$trialbalance[$counter][5] = "";
					$trialbalance[$counter][6] = 0;
				}
				

				if (float_ops($clbal_amount, 0, '=='))
				{
					$trialbalance[$counter][7] = "";
					$trialbalance[$counter][8] = 0;
				} else if ($clbal_amount < 0) {
					$trialbalance[$counter][7] = "Cr";
					$trialbalance[$counter][8] =convert_cur(abs($clbal_amount));
				} else {
					$trialbalance[$counter][7] = "Dr";
					$trialbalance[$counter][8] = convert_cur($clbal_amount);
				}

				$counter++;

			}

			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$trialbalance[$counter][5]= "";
			$trialbalance[$counter][6]= "";
			$trialbalance[$counter][7]= "";
			$trialbalance[$counter][8]= "";
			$counter++;

			$trialbalance[$counter][0]= "Total";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$trialbalance[$counter][5]= "Dr";
			$trialbalance[$counter][6]= convert_cur($temp_dr_total);
			$trialbalance[$counter][7]= "Cr";
			$trialbalance[$counter][8]= convert_cur($temp_cr_total);

			$this->load->helper('csv');
			echo array_to_csv($trialbalance, "trialbalance.csv");
			return;
		}

		/********************** LEDGER STATEMENT **********************/
		if ($statement == "ledgerst")
		{
			$this->load->model('Setting_model');
			$this->load->helper('text');
			$ledger_id = (int)$this->uri->segment(4);
			if ($ledger_id<0){
				return;
			}

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ledgerst = array();

			$ledgerst[$counter] = array ("", "", "LEDGER STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "", "");
			$counter++;
			$ledgerst[$counter] = array ("", "", "DATE : " . date('M d Y', strtotime($from_date)) . " - " . date('M d Y', strtotime($to_date)), "", "", "", "", "", "", "", "");
			$counter++;

			$ledgerst[$counter][0]= "Date";
			$ledgerst[$counter][1]= "Number";
			$ledgerst[$counter][2]= "Ledger Name";
			$ledgerst[$counter][3]= "Narration";
			$ledgerst[$counter][4]= "Type";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "Dr Amount";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "Cr Amount";
			$ledgerst[$counter][9]= "";
			$ledgerst[$counter][10]= "Balance";
			$counter++;

			/* Opening Balance */
			// list ($opbalance, $optype) = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

			$data['account_data']=$account_data = $this->Setting_model->get_current();

			$fy_start = date('Y-m-d',strtotime($account_data->fy_start));

			if ($from_date == $fy_start) {
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


				// $op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date); 
			}

			// $op_balance=$this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

			// if (!empty($op_balance->entry_items_amount)) {
			// 	$opbalance=$op_balance->entry_items_amount;
			// 	$optype=$op_balance->op_type;
			// }
			// else{
			// 	$opbalance=0;
			// 	$optype=NULL;
			// }

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


			$ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", convert_dc($optype), abs($opbalance));
			if ($optype == "D")
				$cur_balance = float_ops($opbalance, $cur_balance, '+');
			else
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			$counter++;

			if ($ledger_id != 0) {

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}
			else{

				 $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}

					
			$query = $this->db->query($sql);

			$query->result_array();		

			$ledgerst_q = $query;

			foreach ($ledgerst_q->result() as $row)
			{	
				/* Entry Type */
				$current_entry_type = entry_type_info($row->entries_entry_type);

				$ledgerst[$counter][0] = date_mysql_to_php($row->entries_date);
				$ledgerst[$counter][1] = full_entry_number($row->entries_entry_type, $row->entries_number);

				/* Opposite entry name */
				$ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->entries_id, $current_entry_type['label'], $row->entry_items_dc, 'text');
				$ledgerst[$counter][3] = $row->entries_narration;
				$ledgerst[$counter][4] = $current_entry_type['name'];

				if ($row->entry_items_dc == "D")
				{
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '+');
					$ledgerst[$counter][5] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][6] = $row->entry_items_amount;
					$ledgerst[$counter][7] = "";
					$ledgerst[$counter][8] = "";

				} else {
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '-');
					$ledgerst[$counter][5] = "";
					$ledgerst[$counter][6] = "";
					$ledgerst[$counter][7] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][8] = $row->entry_items_amount;
				}

				if (float_ops($cur_balance, 0, '=='))
				{
					$ledgerst[$counter][9] = "";
					$ledgerst[$counter][10] = 0;
				} else if ($cur_balance<0) {
					$ledgerst[$counter][9] = "Cr";
					$ledgerst[$counter][10] = convert_cur(abs($cur_balance));
				} else {
					$ledgerst[$counter][9] = "Dr";
					$ledgerst[$counter][10] =  convert_cur(abs($cur_balance));
				}
				$counter++;
			}

			$ledgerst[$counter][0]= "Closing Balance";
			$ledgerst[$counter][1]= "";
			$ledgerst[$counter][2]= "";
			$ledgerst[$counter][3]= "";
			$ledgerst[$counter][4]= "";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "";
			if ($cur_balance>0)
			{
				$ledgerst[$counter][9]= "Dr";
				$ledgerst[$counter][10]= convert_cur(abs($cur_balance));
			} else {
				$ledgerst[$counter][9]= "Cr";
				$ledgerst[$counter][10]= convert_cur(abs($cur_balance));
			}
			$counter++;

			$ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
			$counter++;

			if ($ledger_id != "0" || !empty($ledger_id)) {

				/* Final Opening and Closing Balance */
				$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date);


				// if (!empty($clbalance)) {
				// 	$clbalance=$clbalance+$op_balance1[0];
				// }
				// else{
				// 	$clbalance=0;
				// }


		// var_dump($optype,$clbalance,$op_balance1[0]);
		if ($optype=="D") {
			$clbalance=$clbalance+$op_balance1[0];
		}
		else{

			$clbalance=$clbalance-$op_balance1[0];
		}
				// if ($clbalance>0) {
				// 	$clbalance = "Dr ".convert_cur($clbalance);
				// }
				// else if($clbalance<0){
				// 	$clbalance = "Cr ".convert_cur(abs($clbalance));
				// }			
				// else{
				// 	$clbalance = 0;
				// }

				$ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), abs($opbalance), "", "", "", "", "", "", "", "");
				$counter++;

				if ($clbalance==0)
					$ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
				else if ($clbalance < 0)
					$ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(abs($clbalance)), "", "", "", "", "", "", "", "");
				else
					$ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur(abs($clbalance)), "", "", "", "", "", "", "", "");
				
			}



			$this->load->helper('csv');
			echo array_to_csv($ledgerst, "ledgerst.csv");
			return;
		}

		/********************** RECONCILIATION ************************/
		if ($statement == "reconciliation")
		{
			$ledger_id = (int)$this->uri->segment(4);
			$reconciliation_type = $this->uri->segment(5);

			if ($ledger_id < 1)
				return;
			if ( ! (($reconciliation_type == 'all') or ($reconciliation_type == 'pending')))
				return;

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ledgerst = array();

			$search_from = $this->uri->segment(6);
			$search_to= $this->uri->segment(7);			

			$ledgerst[$counter] = array ("", "", "RECONCILIATION STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "");
			$counter++;
			$ledgerst[$counter] = array ("", "", "Date : " . date('M d Y', strtotime($search_from)) . " - " . date('M d Y', strtotime($search_to)), "", "", "", "", "", "", "");
			$counter++;

			$ledgerst[$counter][0]= "Date";
			$ledgerst[$counter][1]= "Number";
			$ledgerst[$counter][2]= "Ledger Name";
			$ledgerst[$counter][3]= "Narration";
			$ledgerst[$counter][4]= "Type";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "Dr Amount";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "Cr Amount";
			$ledgerst[$counter][9]= "Reconciliation Date";
			$counter++;

			/* Opening Balance */
			// list ($opbalance, $optype) = $this->Ledger_model->get_op_balance_search($ledger_id,$search_from);

			$op_balance=$this->Ledger_model->get_op_balance_search($ledger_id,$search_from);

			if (!empty($op_balance->entry_items_amount)) {
				$opbalance=$op_balance->entry_items_amount;
				$optype=$op_balance->op_type;
			}
			else{
				$opbalance=0;
				$optype=NULL;
			}			

			if ($reconciliation_type == 'all'){

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";

			}
			else{

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.id as entry_items_id, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc, entry_items.reconciliation_date as entry_items_reconciliation_date FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`reconciliation_date` IS NULL AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC";

			}

			$query = $this->db->query($sql);

			$query->result_array();

			$ledgerst_q = $query;   

			foreach ($ledgerst_q->result() as $row)
			{
				/* Entry Type */
				$current_entry_type = entry_type_info($row->entries_entry_type);

				$ledgerst[$counter][0] = date_mysql_to_php($row->entries_date);
				$ledgerst[$counter][1] = full_entry_number($row->entries_entry_type, $row->entries_number);

				/* Opposite entry name */
				$ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->entries_id, $current_entry_type['label'], $row->entry_items_dc, 'text');
				$ledgerst[$counter][3] = $row->entries_narration;
				$ledgerst[$counter][4] = $current_entry_type['name'];

				if ($row->entry_items_dc == "D")
				{
					$ledgerst[$counter][5] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][6] = $row->entry_items_amount;
					$ledgerst[$counter][7] = "";
					$ledgerst[$counter][8] = "";

				} else {
					$ledgerst[$counter][5] = "";
					$ledgerst[$counter][6] = "";
					$ledgerst[$counter][7] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][8] = $row->entry_items_amount;
				}

				if ($row->entry_items_reconciliation_date)
				{
					$ledgerst[$counter][9] = date_mysql_to_php($row->entry_items_reconciliation_date);
				} else {
					$ledgerst[$counter][9] = "";
				}
				$counter++;
			}

			$counter++;
			$ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "");
			$counter++;

			/* Final Opening and Closing Balance */
			$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$search_from,$search_to);

			$ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "");
			$counter++;

			if (float_ops($clbalance, 0, '=='))
				$ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($clbalance, 0, '<'))
				$ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "");
			else
				$ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "");

			/************* Final Reconciliation Balance ***********/

			/* Reconciliation Balance - Dr */
			$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.dr_total) as dr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='D' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' AND `entry_items`.`reconciliation_date` IS NOT NULL ";
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
			$sql = "SELECT sum(entry_items.amount) as amount_sum,sum(entries.cr_total) as cr_total_sum FROM `entry_items` JOIN  `entries` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entry_items`.`dc`='C' AND `entries`.`date` >= '$search_from' AND `entries`.`date` <= '$search_to' AND `entry_items`.`reconciliation_date` IS NOT NULL ";
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

			$counter++;
			if (float_ops($reconciliation_pending, 0, '=='))
				$ledgerst[$counter] = array ("Reconciliation Pending", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($reconciliation_pending, 0, '<'))
				$ledgerst[$counter] = array ("Reconciliation Pending", "Cr", convert_cur(-$reconciliation_pending), "", "", "", "", "", "", "");
			else
				$ledgerst[$counter] = array ("Reconciliation Pending", "Dr", convert_cur($reconciliation_pending), "", "", "", "", "", "", "");

			$counter++;
			if (float_ops($reconciliation_total, 0, '=='))
				$ledgerst[$counter] = array ("Reconciliation Total", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($reconciliation_total, 0, '<'))
				$ledgerst[$counter] = array ("Reconciliation Total", "Cr", convert_cur(-$reconciliation_total), "", "", "", "", "", "", "");
			else
				$ledgerst[$counter] = array ("Reconciliation Total", "Dr", convert_cur($reconciliation_total), "", "", "", "", "", "", "");

			$this->load->helper('csv');
			echo array_to_csv($ledgerst, "reconciliation.csv");
			return;
		}
		
		/************************ BALANCE SHEET ***********************/
		if ($statement == "balancesheet")
		{
			$this->load->library('accountlist');
			$this->load->model('Ledger_model');

			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);
			$data['from_date'] = $from_date_1;
			$data['to_date'] = $to_date_1;			

			$liability = new Accountlist();
			$liability->init(2);
			$liability_array = $liability->build_array();
			$liability_depth = Accountlist::$max_depth;
			$liability_total = -$liability->total;

			Accountlist::reset_max_depth();

			$asset = new Accountlist();
			$asset->init(1);
			$asset_array = $asset->build_array();
			$asset_depth = Accountlist::$max_depth;
			$asset_total = $asset->total;

			$liability->to_csv($liability_array);
			Accountlist::add_blank_csv();
			$asset->to_csv($asset_array);

			$income = new Accountlist();
			$income->init(3);
			$expense = new Accountlist();
			$expense->init(4);
			$income_total = -$income->total;
			$expense_total = $expense->total;
			$pandl = float_ops($income_total, $expense_total, '-');
			$diffop = $this->Ledger_model->get_diff_op_balance();

			Accountlist::add_blank_csv();
			/* Liability side */
			$total = $liability_total;
			Accountlist::add_row_csv(array("Liabilities and Owners Equity Total", convert_cur($liability_total)));
		
			/* If Profit then Liability side, If Loss then Asset side */
			if (float_ops($pandl, 0, '!='))
			{
				if (float_ops($pandl, 0, '>'))
				{
					$total = float_ops($total, $pandl, '+');
					Accountlist::add_row_csv(array("Profit & Loss Account (Net Profit)", convert_cur($pandl)));
				}
			}

			/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
			if (float_ops($diffop, 0, '!='))
			{
				if (float_ops($diffop, 0, '>'))
				{
					$total = float_ops($total, $diffop, '+');
					Accountlist::add_row_csv(array("Diff in O/P Balance", "Dr " . convert_cur($diffop)));
				}
			}

			Accountlist::add_row_csv(array("Total - Liabilities and Owners Equity", convert_cur($total)));

			/* Asset side */
			$total = $asset_total;
			Accountlist::add_row_csv(array("Asset Total", convert_cur($asset_total)));
		
			/* If Profit then Liability side, If Loss then Asset side */
			if (float_ops($pandl, 0, '!='))
			{
				if (float_ops($pandl, 0, '<'))
				{
					$total = float_ops($total, -$pandl, '+');
					Accountlist::add_row_csv(array("Profit & Loss Account (Net Loss)", convert_cur(-$pandl)));
				}
			}
		
			/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
			if (float_ops($diffop, 0, '!='))
			{
				if (float_ops($diffop, 0, '<'))
				{
					$total = float_ops($total, -$diffop, '+');
					Accountlist::add_row_csv(array("Diff in O/P Balance", "Cr " . convert_cur(-$diffop)));
				}
			}

			Accountlist::add_row_csv(array("Total - Assets", convert_cur($total)));

			$balancesheet = Accountlist::get_csv();
			$this->load->helper('csv');
			echo array_to_csv($balancesheet, "balancesheet.csv");
			return;
		}

		/********************** PROFIT AND LOSS ***********************/
		if ($statement == "profitandloss")
		{
			$this->load->library('accountlist');
			$this->load->model('Ledger_model');

			/***************** GROSS CALCULATION ******************/

			/* Gross P/L : Expenses */
			$gross_expense_total = 0;
			$this->db->from('groups')->where('parent_id', 4)->where('affects_gross', 1);
			$gross_expense_list_q = $this->db->get();
			foreach ($gross_expense_list_q->result() as $row)
			{
				$gross_expense = new Accountlist();
				$gross_expense->init_pl($row->id);
				$gross_expense_total = float_ops($gross_expense_total, $gross_expense->total, '+');
				$gross_exp_array = $gross_expense->build_array();
				$gross_expense->to_csv($gross_exp_array);
			}
			Accountlist::add_blank_csv();

			/* Gross P/L : Incomes */
			$gross_income_total = 0;
			$this->db->from('groups')->where('parent_id', 3)->where('affects_gross', 1);
			$gross_income_list_q = $this->db->get();
			foreach ($gross_income_list_q->result() as $row)
			{
				$gross_income = new Accountlist();
				$gross_income->init_pl($row->id);
				$gross_income_total = float_ops($gross_income_total, $gross_income->total, '+');
				$gross_inc_array = $gross_income->build_array();
				$gross_income->to_csv($gross_inc_array);
			}

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Converting to positive value since Cr */
			$gross_income_total = -$gross_income_total;

			/* Calculating Gross P/L */
			$grosspl = float_ops($gross_income_total, $gross_expense_total, '-');

			/* Showing Gross P/L : Expenses */
			$grosstotal = $gross_expense_total;
			Accountlist::add_row_csv(array("Total Gross Expenses", convert_cur($gross_expense_total)));
			if (float_ops($grosspl, 0, '>'))
			{
				$grosstotal = float_ops($grosstotal, $grosspl, '+');
				Accountlist::add_row_csv(array("Gross Profit C/O", convert_cur($grosspl)));
			}
			Accountlist::add_row_csv(array("Total Expenses - Gross", convert_cur($grosstotal)));

			/* Showing Gross P/L : Incomes  */
			$grosstotal = $gross_income_total;
			Accountlist::add_row_csv(array("Total Gross Incomes", convert_cur($gross_income_total)));

			if (float_ops($grosspl, 0, '>'))
			{

			} else if (float_ops($grosspl, 0, '<')) {
				$grosstotal = float_ops($grosstotal, -$grosspl, '+');
				Accountlist::add_row_csv(array("Gross Loss C/O", convert_cur(-$grosspl)));
			}
			Accountlist::add_row_csv(array("Total Incomes - Gross", convert_cur($grosstotal)));

			/************************* NET CALCULATIONS ***************************/

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Net P/L : Expenses */
			$net_expense_total = 0;
			$this->db->from('groups')->where('parent_id', 4)->where('affects_gross !=', 1);
			$net_expense_list_q = $this->db->get();
			foreach ($net_expense_list_q->result() as $row)
			{
				$net_expense = new Accountlist();
				$net_expense->init_pl($row->id);
				$net_expense_total = float_ops($net_expense_total, $net_expense->total, '+');
				$net_exp_array = $net_expense->build_array();
				$net_expense->to_csv($net_exp_array);
			}
			Accountlist::add_blank_csv();

			/* Net P/L : Incomes */
			$net_income_total = 0;
			$this->db->from('groups')->where('parent_id', 3)->where('affects_gross !=', 1);
			$net_income_list_q = $this->db->get();
			foreach ($net_income_list_q->result() as $row)
			{
				$net_income = new Accountlist();
				$net_income->init_pl($row->id);
				$net_income_total = float_ops($net_income_total, $net_income->total, '+');
				$net_inc_array = $net_income->build_array();
				$net_income->to_csv($net_inc_array);
			}

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Converting to positive value since Cr */
			$net_income_total = -$net_income_total;

			/* Calculating Net P/L */
			$netpl = float_ops(float_ops($net_income_total, $net_expense_total, '-'), $grosspl, '+');

			/* Showing Net P/L : Expenses */
			$nettotal = $net_expense_total;
			Accountlist::add_row_csv(array("Total Expenses", convert_cur($nettotal)));

			if (float_ops($grosspl, 0, '>'))
			{
			} else if (float_ops($grosspl, 0, '<')) {
				$nettotal = float_ops($nettotal, -$grosspl, '+');
				Accountlist::add_row_csv(array("Gross Loss B/F", convert_cur(-$grosspl)));
			}
			if (float_ops($netpl, 0, '>'))
			{
				$nettotal = float_ops($nettotal, $netpl, '+');
				Accountlist::add_row_csv(array("Net Profit", convert_cur($netpl)));
			}
			Accountlist::add_row_csv(array("Total - Net Expenses", convert_cur($nettotal)));

			/* Showing Net P/L : Incomes */
			$nettotal = $net_income_total;
			Accountlist::add_row_csv(array("Total Incomes", convert_cur($nettotal)));

			if ($grosspl > 0)
			{
				$nettotal = float_ops($nettotal, $grosspl, '+');
				Accountlist::add_row_csv(array("Gross Profit B/F", convert_cur($grosspl)));
			}

			if ($netpl > 0)
			{

			} else if ($netpl < 0) {
				$nettotal = float_ops($nettotal, -$netpl, '+');
				Accountlist::add_row_csv(array("Net Loss", convert_cur(-$netpl)));
			}
			Accountlist::add_row_csv(array("Total - Net Incomes", convert_cur($nettotal)));

			$balancesheet = Accountlist::get_csv();
			$this->load->helper('csv');

			$from_date_download = $this->uri->segment(4);

			$to_date_download = $this->uri->segment(5);

			if (!empty($from_date_download) && !empty($to_date_download) ) {
				echo array_to_csv($balancesheet, "profitandloss ".date('d-m-Y',strtotime($from_date_download))." - ".date('d-m-Y',strtotime($to_date_download)).".csv");
			}
			else{
				echo array_to_csv($balancesheet, "profitandloss.csv");
			}


			
			return;
		}


		/********************** CASH BOOK **********************/
		if ($statement == "cashbook")
		{
			$this->load->model('Setting_model');
			$this->load->helper('text');
			$ledger_id = (int)$this->uri->segment(4);
			if ($ledger_id<0){
				return;
			}

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ledgerst = array();

			$ledgerst[$counter] = array ("", "", "CASH BOOK");
			$counter++;
			$ledgerst[$counter] = array ("", "", "DATE : " . date('M d Y', strtotime($from_date)) . " - " . date('M d Y', strtotime($to_date)), "", "", "", "", "", "", "", "");
			$counter++;

			$ledgerst[$counter][0]= "Date";
			$ledgerst[$counter][1]= "Number";
			$ledgerst[$counter][2]= "Ledger Name";
			$ledgerst[$counter][3]= "Narration";
			$ledgerst[$counter][4]= "Type";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "Dr Amount";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "Cr Amount";
			$ledgerst[$counter][9]= "";
			$ledgerst[$counter][10]= "Balance";
			$counter++;

			/* Opening Balance */
			// list ($opbalance, $optype) = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

			$data['account_data']=$account_data = $this->Setting_model->get_current();

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

			// $op_balance=$this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

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


			$ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
			if ($optype == "D")
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			else
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			$counter++;

			if ($ledger_id != 0) {

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}
			else{

				 $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` != 0 AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}

					
			$query = $this->db->query($sql);

			$query->result_array();		

			$ledgerst_q = $query;

			foreach ($ledgerst_q->result() as $row)
			{	
				/* Entry Type */
				$current_entry_type = entry_type_info($row->entries_entry_type);

				$ledgerst[$counter][0] = date_mysql_to_php($row->entries_date);
				$ledgerst[$counter][1] = full_entry_number($row->entries_entry_type, $row->entries_number);

				/* Opposite entry name */
				$ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->entries_id, $current_entry_type['label'], $row->entry_items_dc, 'text');
				$ledgerst[$counter][3] = $row->entries_narration;
				$ledgerst[$counter][4] = $current_entry_type['name'];

				if ($row->entry_items_dc == "D")
				{
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '+');
					$ledgerst[$counter][5] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][6] = $row->entry_items_amount;
					$ledgerst[$counter][7] = "";
					$ledgerst[$counter][8] = "";

				} else {
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '-');
					$ledgerst[$counter][5] = "";
					$ledgerst[$counter][6] = "";
					$ledgerst[$counter][7] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][8] = $row->entry_items_amount;
				}

				if (float_ops($cur_balance, 0, '=='))
				{
					$ledgerst[$counter][9] = "";
					$ledgerst[$counter][10] = 0;
				} else if (float_ops($cur_balance, 0, '<')) {
					$ledgerst[$counter][9] = "Cr";
					$ledgerst[$counter][10] = convert_cur(-$cur_balance);
				} else {
					$ledgerst[$counter][9] = "Dr";
					$ledgerst[$counter][10] =  convert_cur($cur_balance);
				}
				$counter++;
			}

			$ledgerst[$counter][0]= "Closing Balance";
			$ledgerst[$counter][1]= "";
			$ledgerst[$counter][2]= "";
			$ledgerst[$counter][3]= "";
			$ledgerst[$counter][4]= "";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "";
			if (float_ops($cur_balance, 0, '<'))
			{
				$ledgerst[$counter][9]= "Cr";
				$ledgerst[$counter][10]= convert_cur(-$cur_balance);
			} else {
				$ledgerst[$counter][9]= "Dr";
				$ledgerst[$counter][10]= convert_cur($cur_balance);
			}
			$counter++;

			$ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
			$counter++;

			if ($ledger_id != "0" || !empty($ledger_id)) {

				/* Final Opening and Closing Balance */
				$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date);

		// var_dump($optype,$clbalance,$op_balance1[0]);
		// if ($optype=="D") {
			$clbalance=$clbalance+$op_balance1[0];
		// }
		// else{

		// 	$clbalance=$clbalance-$op_balance1[0];
		// }

				$ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
				$counter++;

				if (float_ops($clbalance, 0, '=='))
					$ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
				else if ($clbalance < 0)
					$ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
				else
					$ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");
				
			}



			$this->load->helper('csv');
			echo array_to_csv($ledgerst, "cashbook.csv");
			return;
		}



		/********************** BANK BOOK **********************/
		if ($statement == "bankbook")
		{
			$this->load->model('Setting_model');
			$this->load->helper('text');
			$ledger_id = (int)$this->uri->segment(4);
			if ($ledger_id<0){
				return;
			}

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ledgerst = array();

			$ledgerst[$counter] = array ("", "", "BANK BOOK");
			$counter++;
			$ledgerst[$counter] = array ("", "", "DATE : " . date('M d Y', strtotime($from_date)) . " - " . date('M d Y', strtotime($to_date)), "", "", "", "", "", "", "", "");
			$counter++;

			$ledgerst[$counter][0]= "Date";
			$ledgerst[$counter][1]= "Number";
			$ledgerst[$counter][2]= "Ledger Name";
			$ledgerst[$counter][3]= "Narration";
			$ledgerst[$counter][4]= "Type";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "Dr Amount";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "Cr Amount";
			$ledgerst[$counter][9]= "";
			$ledgerst[$counter][10]= "Balance";
			$counter++;

			/* Opening Balance */
			// list ($opbalance, $optype) = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

			$data['account_data']=$account_data = $this->Setting_model->get_current();

			$fy_start = date('Y-m-d',strtotime($account_data->fy_start));

			if ($from_date == $fy_start) {
				$op_balance1 = $this->Ledger_model->get_op_balance($ledger_id); 
			}
			else{
				$op_balance2 = $this->Ledger_model->get_op_balance_search($ledger_id,$from_date); 
			}

			// $op_balance=$this->Ledger_model->get_op_balance_search($ledger_id,$from_date);

			if (!empty($op_balance->entry_items_amount)) {
				$opbalance=$op_balance->entry_items_amount;
				$optype=$op_balance->op_type;
			}
			else{
				$opbalance=0;
				$optype=NULL;
			}

			if (!empty($op_balance2->entry_items_amount)) {
				$opbalance=$op_balance2->entry_items_amount;
				$optype=$op_balance2->op_type;
			}
			else if (!empty($op_balance1)) {
				$opbalance=$op_balance1[0];
				$optype=$op_balance1[1];
			}
			else{
				$opbalance=0;
				$optype=NULL;
			}


			$ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
			if ($optype == "D")
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			else
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			$counter++;

			if ($ledger_id != 0) {

				$sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` =  '$ledger_id' AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}
			else{


					$sql = "SELECT * FROM `ledgers` WHERE `type`=1 AND `reconciliation`=1 ";
				    $query = $this->db->query($sql);
				    $query->result_array();	
				    $ledgerst_q = $query;

					foreach ($ledgerst_q->result() as $row )
					{

						$ledger_id_array[]=$row->id;

					}

					if (!empty($ledger_id_array)) {
						$ledger_id_array = implode(',', $ledger_id_array);
					}


				 $sql = "SELECT entries.id as entries_id, entries.number as entries_number, entries.date as entries_date, entries.narration as entries_narration, entries.entry_type as entries_entry_type, entry_items.amount as entry_items_amount, entry_items.dc as entry_items_dc FROM  `entries` JOIN  `entry_items` ON  `entries`.`id` =  `entry_items`.`entry_id` WHERE  `entry_items`.`ledger_id` in ($ledger_id_array) AND `entries`.`date` >= '$from_date' AND `entries`.`date` <= '$to_date' ORDER BY `entries`.`date` ASC, `entries`.`number` ASC ";
			}

					
			$query = $this->db->query($sql);

			$query->result_array();		

			$ledgerst_q = $query;

			foreach ($ledgerst_q->result() as $row)
			{	
				/* Entry Type */
				$current_entry_type = entry_type_info($row->entries_entry_type);

				$ledgerst[$counter][0] = date_mysql_to_php($row->entries_date);
				$ledgerst[$counter][1] = full_entry_number($row->entries_entry_type, $row->entries_number);

				/* Opposite entry name */
				$ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->entries_id, $current_entry_type['label'], $row->entry_items_dc, 'text');
				$ledgerst[$counter][3] = $row->entries_narration;
				$ledgerst[$counter][4] = $current_entry_type['name'];

				if ($row->entry_items_dc == "D")
				{
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '+');
					$ledgerst[$counter][5] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][6] = $row->entry_items_amount;
					$ledgerst[$counter][7] = "";
					$ledgerst[$counter][8] = "";

				} else {
					$cur_balance = float_ops($cur_balance, $row->entry_items_amount, '-');
					$ledgerst[$counter][5] = "";
					$ledgerst[$counter][6] = "";
					$ledgerst[$counter][7] = convert_dc($row->entry_items_dc);
					$ledgerst[$counter][8] = $row->entry_items_amount;
				}

				if (float_ops($cur_balance, 0, '=='))
				{
					$ledgerst[$counter][9] = "";
					$ledgerst[$counter][10] = 0;
				} else if (float_ops($cur_balance, 0, '<')) {
					$ledgerst[$counter][9] = "Cr";
					$ledgerst[$counter][10] = convert_cur(-$cur_balance);
				} else {
					$ledgerst[$counter][9] = "Dr";
					$ledgerst[$counter][10] =  convert_cur($cur_balance);
				}
				$counter++;
			}

			$ledgerst[$counter][0]= "Closing Balance";
			$ledgerst[$counter][1]= "";
			$ledgerst[$counter][2]= "";
			$ledgerst[$counter][3]= "";
			$ledgerst[$counter][4]= "";
			$ledgerst[$counter][5]= "";
			$ledgerst[$counter][6]= "";
			$ledgerst[$counter][7]= "";
			$ledgerst[$counter][8]= "";
			if (float_ops($cur_balance, 0, '<'))
			{
				$ledgerst[$counter][9]= "Cr";
				$ledgerst[$counter][10]= convert_cur(-$cur_balance);
			} else {
				$ledgerst[$counter][9]= "Dr";
				$ledgerst[$counter][10]= convert_cur($cur_balance);
			}
			$counter++;

			$ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
			$counter++;

			if ($ledger_id != "0" || !empty($ledger_id)) {

				/* Final Opening and Closing Balance */
				$clbalance = $this->Ledger_model->get_ledger_balance_bydate($ledger_id,$opbalance,$optype,$from_date,$to_date);

			// var_dump($optype,$clbalance,$op_balance1[0]);
			// if ($optype=="D") {
				$clbalance=$clbalance+$op_balance1[0];
			// }
			// else{

			// 	$clbalance=$clbalance-$op_balance1[0];
			// }
				

				$ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
				$counter++;

				if (float_ops($clbalance, 0, '=='))
					$ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
				else if ($clbalance < 0)
					$ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
				else
					$ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");
				
			}



			$this->load->helper('csv');
			echo array_to_csv($ledgerst, "bankbook.csv");
			return;
		}

		/********************** TRIAL BALANCE - NEW *************************/
		if ($statement == "trialbalance_new")
		{

			$this->load->model('Ledger_model');
			$this->load->model('Group_model');

			$counter = 0;
			$trialbalance = array();
			$temp_dr_total = 0;
			$temp_cr_total = 0;


			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);
			$data['from_date'] = $from_date_1;
			$data['to_date'] = $to_date_1;	

			$account_fy_start = $this->config->item('account_fy_start');
			$account_fy_end   = $this->config->item('account_fy_end');
			$account_fy_start = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_start)));
			$account_fy_end = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_end)));


			$trialbalance[$counter] = array ("TRIAL BALANCE", "", "", "");
			$counter++;
			$trialbalance[$counter] = array ("FY " . $from_date_1 . " - " . $to_date_1, "");
			$counter++;

			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";

			$counter++;


			$trialbalance[$counter][0]= "Account Name";
			$trialbalance[$counter][1]= "Type";
			$trialbalance[$counter][2]= "Debit";
			$trialbalance[$counter][3]= "Credit";

			$counter++;




			$all_groups = $this->Group_model->get_ledger_groups_main();


			foreach ($all_groups as $key => $value) {

				$groups[$key] = $value;
				
				$child_groups = $this->Group_model->get_all_groups_parent($key);

				$child_ledgers = $this->Ledger_model->get_all_ledgers_by_group($key);

				$ledgers[$key] = $child_ledgers;

				foreach ($child_groups as $key1 => $value1) {

					$groups[$key1] = $value1;
					
					$child_groups1= $this->Group_model->get_all_groups_parent($key1);

					$child_ledgers1 = $this->Ledger_model->get_all_ledgers_by_group($key1);

					$ledgers[$key1] = $child_ledgers1;


					foreach ($child_groups1 as $key2 => $value2) {

						$groups[$key2] = $value2;
						
						$child_groups2= $this->Group_model->get_all_groups_parent($key2);

						$child_ledgers2 = $this->Ledger_model->get_all_ledgers_by_group($key2);

						$ledgers[$key2] = $child_ledgers2;


						foreach ($child_groups2 as $key3 => $value3) {

							$groups[$key3] = $value3;

							$child_groups3= $this->Group_model->get_all_groups_parent($key3);

							$child_ledgers3 = $this->Ledger_model->get_all_ledgers_by_group($key3);

							$ledgers[$key3] = $child_ledgers3;

							foreach ($child_groups3 as $key4 => $value4) {

								$groups[$key4] = $value4;

								$child_ledgers4 = $this->Ledger_model->get_all_ledgers_by_group($key4);


								$ledgers[$key4] = $child_ledgers4;
							}

							
							
						}

					}

				}

			}




			foreach ($groups as $key => $value) {
				
				if ($key<=4) {
					
					$trialbalance[$counter][0] = $value;
					$trialbalance[$counter][1]= "Group Account";

				}
				else{

					$counter++;

					$trialbalance[$counter][0]= "                ".$value."";
					$trialbalance[$counter][1]= "Group Account";



				}

				


					foreach ($ledgers as $key1 => $value1) {
						

							foreach ($value1 as $key2 => $value2) {

								if ($key==$key1) {

									
									$counter++;


									$trialbalance[$counter][0]= "                        ".$value2."";
									$trialbalance[$counter][1]= "Ledger Account";


									// $clbalance_sum = $this->Ledger_model->get_ledger_balance_bydate_not_sum($key2,1,1,$data['from_date'],$data['to_date']); 

									// // $dr_sum_total += $clbalance_sum['dr_total'];

									// // $cr_sum_total += $clbalance_sum['cr_total'];


									// $trialbalance[$counter][2]= !empty($clbalance_sum['dr_total'])?$clbalance_sum['dr_total']:0;
									// $trialbalance[$counter][3]= !empty($clbalance_sum['cr_total'])?$clbalance_sum['cr_total']:0;


									$op_balance1 = $this->Ledger_model->get_op_balance($key2); 

									if (!empty($op_balance1[0])) {
										$op_balance_total = $op_balance1[0];
									}
									else{
										$op_balance_total = 0;
									}

									$current_total = $this->Ledger_model->get_op_balance_search($key2,$data['from_date']);

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
									else{
										$opbalance=0;
										$optype=NULL;
									}

									$clbalance = $this->Ledger_model->get_ledger_balance_bydate($key2,1,1,$data['from_date'],$data['to_date']);


									if ($optype=="D") {
										$clbalance=$clbalance+$op_balance1[0];
									}
									else{

										$clbalance=$clbalance-$op_balance1[0];
									}


									if (empty($clbalance)) {
										$clbalance=0;
									}



									if ($clbalance>0) {
										// echo "<td>" . convert_amount_dc($clbalance) . "</td>";
										// echo "<td>0.00</td>";


										$trialbalance[$counter][2]= $clbalance;
										$trialbalance[$counter][3]= 0.00;

										// $dr_sum_total += $clbalance;

									}
									else if ($clbalance<0) {

										$trialbalance[$counter][2]= 0.00;
										$trialbalance[$counter][3]= (-$clbalance);

										// $cr_sum_total += (-$clbalance);
									}
									else{
										$trialbalance[$counter][2]= 0.00;
										$trialbalance[$counter][3]= 0.00;
									}







								}

							}

							$counter++;





					}


				$counter++;

			}


			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";

			$counter++;

			$dr_sum = $this->Ledger_model->get_dr_total_search_sum($data['from_date'],$data['to_date']); 

			$cr_sum = $this->Ledger_model->get_cr_total_search_sum($data['from_date'],$data['to_date']);

			$trialbalance[$counter][0]= "Total";
			

			if ($dr_sum == $cr_sum) {
				
				$trialbalance[$counter][1]= "OK";

			}
			else{

				$trialbalance[$counter][1]= "Mismatch";


			}


			$trialbalance[$counter][2]= $dr_sum;
			$trialbalance[$counter][3]= $cr_sum;

			$counter++;

			$diff_dr = $dr_sum - $cr_sum;
			$diff_cr = $cr_sum - $dr_sum;

			$trialbalance[$counter][0]= "Difference";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= $diff_dr;
			$trialbalance[$counter][3]= $diff_cr;
			$counter++;

			
			



			$this->load->helper('csv');
			echo array_to_csv($trialbalance, "trialbalance.csv");

			
			return;
		}


		/********************** PROFIT AND LOSS ***********************/

		if ($statement == "profitandloss_new")
		{
			$this->load->library('accountlist');
			$this->load->model('Ledger_model');
			$this->load->model('Setting_model');


			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);

			$account_data = $this->Setting_model->get_current();
			$start_date=date("Y-m-d",strtotime($account_data->fy_start));
			$end_date=date("Y-m-d",strtotime($account_data->fy_end));	

			if (empty($from_date_1)) {
				$from_date_1 = $start_date;
			}

			if (empty($to_date_1)) {
				$to_date_1 = $end_date;
			}


			$counter = 0;

			$trialbalance[$counter] = array ("PROFIT & LOSS REPORT", "", "", "", "");
			$counter++;
			$trialbalance[$counter] = array ("FY " . date("Y-m-d",strtotime($from_date_1)) . " - " . date("Y-m-d",strtotime($to_date_1)), "");
			$counter++;


			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$counter++;

			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$counter++;


			$trialbalance[$counter][0]= "Expense";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "Income";
			$trialbalance[$counter][4]= "";

			$counter++;


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

			$trialbalance[$counter][0]= "To  Opening stock";
			$trialbalance[$counter][1]= $opening_stock_real;
			$trialbalance[$counter][2]="";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "0.00";
			$counter++;

			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "0.00";
			$trialbalance[$counter][2]="";
			$trialbalance[$counter][3]= "By Closing stock";
			$trialbalance[$counter][4]= $closing_stock_real;
			$counter++;

			if ($gross_profit_cd>0) {
				
				$trialbalance[$counter][0]= "To  Gross profit c/d";
				$trialbalance[$counter][1]= $gross_profit_cd;
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "";
				$trialbalance[$counter][4]= "0.00";
				$counter++;

				$trialbalance[$counter][0]= "";
				$trialbalance[$counter][1]= $gross_profit_cd+$opening_stock_real;
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "";
				$trialbalance[$counter][4]= $closing_stock_real;
				$counter++;

				$trialbalance[$counter][0]= "";
				$trialbalance[$counter][1]= "0.00";
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "By Gross profit b/d";
				$trialbalance[$counter][4]= $gross_profit_bd;
				$counter++;



			}
			else{

				$trialbalance[$counter][0]= "";
				$trialbalance[$counter][1]= "0.00";
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "By Gross loss c/d";
				$trialbalance[$counter][4]= abs($gross_profit_cd);
				$counter++;

				$trialbalance[$counter][0]= "";
				$trialbalance[$counter][1]= $opening_stock_real;
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "";
				$trialbalance[$counter][4]= (abs($gross_profit_cd)+$closing_stock_real);
				$counter++;

				$trialbalance[$counter][0]= "To Gross loss b/d";
				$trialbalance[$counter][1]= abs($gross_profit_bd);
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "";
				$trialbalance[$counter][4]= "0.00";
				$counter++;


			}

				$trialbalance[$counter][0]= "";
				$trialbalance[$counter][1]= "";
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "";
				$trialbalance[$counter][4]= "";
				$counter++;


			// $trialbalance[$counter][0]= "To  Gross profit c/d";
			// $trialbalance[$counter][1]= $gross_profit_cd;
			// $trialbalance[$counter][2]="";
			// $trialbalance[$counter][3]= "By  Gross profit b/d";
			// $trialbalance[$counter][4]= $gross_profit_bd;
			// $counter++;

			/***************** GROSS CALCULATION ******************/

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

			foreach ($child_ledger_q->result() as $row)
			{

				
				$total = $this->Ledger_model->get_ledger_balance_search_pl($row->id,$from_date_1,$to_date_1);

				$trialbalance[$counter][0]= "To  ".$row->name;
				$trialbalance[$counter][1]= $total;

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


				$counter++;

			}

			$total_exp_sum = $expense_sum;



			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$counter++;
			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$counter++;





			// var_dump($opening_stock_sum);
			// exit();


			$counter1 = 11;
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

			foreach ($child_ledger_q->result() as $row)
			{


				$total = $this->Ledger_model->get_ledger_balance_search_pl($row->id,$from_date_1,$to_date_1);

				$total = abs($total);

				$trialbalance[$counter1][2]="";
				$trialbalance[$counter1][3]= "By  ".$row->name;
				$trialbalance[$counter1][4]= $total;

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

				$counter1++;

			}

			$total_inc_sum = $income_sum;

			$profit = $total_inc_sum - $total_exp_sum;

			// $gross_profit_cd = 4;
			// $profit =2;

			$net_profit_cd   =  $gross_profit_cd + $profit;

			if ($net_profit_cd>0) {
			

				$trialbalance[$counter][0]= "To  Net profit b/d";
				$trialbalance[$counter][1]= $net_profit_cd;
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= " - ";
				$trialbalance[$counter][4]= "0.00";
				$counter++;


			}
			else{


				$trialbalance[$counter][0]= " - ";
				$trialbalance[$counter][1]= "0.00";
				$trialbalance[$counter][2]="";
				$trialbalance[$counter][3]= "By Net Loss b/d";
				$trialbalance[$counter][4]= abs($net_profit_cd);
				$counter++;



			}


			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= $net_profit_cd+$total_exp_sum;
			$trialbalance[$counter][2]="";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= $gross_profit_cd+$total_inc_sum;
			$counter++;

			
			$this->load->helper('csv');
			echo array_to_csv($trialbalance, "profitandloss.csv");


		return;

		}

	}

	function printpreview($statement, $id = NULL,$from_date = NULL,$to_date= NULL)
	{
		/********************** TRIAL BALANCE *************************/
		$this->load->model('Setting_model');

		if ($statement == "trialbalance")
		{


			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);

			if (!empty($from_date_1) && !empty($to_date_1) ) {

				$data['from_date'] = $from_date_1;
				$data['to_date'] = $to_date_1;

			}
			else{

				$account_data = $this->Setting_model->get_current();
				$start_date=$account_data->fy_start;
				$end_date=$account_data->fy_end;	
				$data['from_date']['value'] = $start_date;
				$data['to_date']['value'] = $end_date;				

			}

			$this->load->library('accountlist');
			$data['report'] = "report/trialbalance";
			$data['title'] = "Trial Balance";
			$data['show_search'] = "NO";
			$data['print_preview'] = "YES";
			$this->load->view('report/report_template', $data);
			return;
		}

		if ($statement == "balancesheet")
		{
			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);

			if (!empty($from_date_1) && !empty($to_date_1) ) {

				$data['from_date'] = $from_date_1;
				$data['to_date'] = $to_date_1;

			}
			else{

				$account_data = $this->Setting_model->get_current();
				$start_date=$account_data->fy_start;
				$end_date=$account_data->fy_end;	
				$data['from_date'] = $start_date;
				$data['to_date'] = $end_date;				

			}


			$data['report'] = "report/balancesheet";
			$data['title'] = "Balance Sheet";
			$data['left_width'] = "";
			$data['right_width'] = "";
			$this->load->view('report/report_template', $data);
			return;
		}

		if ($statement == "profitandloss")
		{
			$data['report'] = "report/profitandloss";
			$data['title'] = "Profit and Loss Statement";
			$data['left_width'] = "";
			$data['right_width'] = "";
			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);


			if (!empty($from_date_1) && !empty($to_date_1) ) {

				$data['from_date'] = $from_date_1;
				$data['to_date'] = $to_date_1;

			}
			else{

				$account_data = $this->Setting_model->get_current();
				$start_date=$account_data->fy_start;
				$end_date=$account_data->fy_end;	
				$data['from_date'] = $start_date;
				$data['to_date'] = $end_date;				

			}

		
			$this->load->view('report/report_template', $data);
			return;
		}
		
		if ($statement == "ledgerst")
		{
			$this->load->helper('text');

			/* Pagination setup */
			$this->load->library('pagination');

			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['ledger_id'] = $this->uri->segment(4);
			/* Checking for valid ledger id */
			if ($data['ledger_id'] == "")
			{
				$this->messages->add('Invalid Ledger account.', 'error');
				redirect('report/ledgerst');
				return;
			}

			else if ($data['ledger_id'] == 0) {
				// $this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				$sql="SELECT * FROM (`ledgers`) WHERE `id` !=0";
				$query = $this->db->query($sql);

			} 
			else{
				$this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				if ($this->db->get()->num_rows() < 1)
				{
					$this->messages->add('Invalid Ledger account.', 'error');
					redirect('report/ledgerst');
					return;
				}
			}
			

			$data['report'] = "report/ledgerst";
			$data['title'] = "Ledger Statement for '" . $this->Ledger_model->get_name($data['ledger_id']) . "'";
			$data['print_preview'] = TRUE;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$this->load->view('report/report_template', $data);
			return;
		}

		if ($statement == "reconciliation")
		{		

			$this->load->helper('text');

			$data['show_all'] = FALSE;
			$data['ledger_id'] = $this->uri->segment(4);
			$data['from_date'] = $this->uri->segment(6);
			$data['to_date'] = $this->uri->segment(7);

			/* Check if path is 'all' or 'pending' */
			if ($this->uri->segment(5) == 'all')
			{
				$data['reconciliation_type'] = 'all';
				$data['show_all'] = TRUE;
			} else if ($this->uri->segment(5) == 'pending') {
				$data['reconciliation_type'] = 'pending';
				$data['show_all'] = FALSE;
			} else {
				$this->messages->add('Invalid path.', 'error');
				redirect('report/reconciliation/pending');
				return;
			}

			/* Checking for valid ledger id and reconciliation status */
			if ($data['ledger_id'] > 0)
			{
				$this->db->from('ledgers')->where('id', $data['ledger_id'])->where('reconciliation', 1)->limit(1);
				if ($this->db->get()->num_rows() < 1)
				{
					$this->messages->add('Invalid Ledger account or Reconciliation is not enabled for the Ledger account.', 'error');
					redirect('report/reconciliation/' . $reconciliation_type);
					return;
				}
			} else if ($data['ledger_id'] < 0) {
				$this->messages->add('Invalid Ledger account.', 'error');
				redirect('report/reconciliation/' . $reconciliation_type);
				return;
			}

			$data['report'] = "report/reconciliation";
			$data['title'] = "Reconciliation Statement for '" . $this->Ledger_model->get_name($data['ledger_id']) . "'";
			$data['print_preview'] = TRUE;
			$this->load->view('report/report_template', $data);
			return;
		}

		/********************** CASH BOOK *************************/

		if ($statement == "cashbook")
		{
			$this->load->helper('text');

			/* Pagination setup */
			$this->load->library('pagination');

			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['ledger_id'] = $this->uri->segment(4);
			/* Checking for valid ledger id */
			if ($data['ledger_id'] == "")
			{
				$this->messages->add('Invalid Ledger account.', 'error');
				redirect('report/cashbook');
				return;
			}

			else if ($data['ledger_id'] == 0) {
				// $this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				$sql="SELECT * FROM (`ledgers`) WHERE `id` !=0";
				$query = $this->db->query($sql);

			} 
			else{
				$this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				if ($this->db->get()->num_rows() < 1)
				{
					$this->messages->add('Invalid Ledger account.', 'error');
					redirect('report/cashbook');
					return;
				}
			}
			

			$data['report'] = "report/cashbook";
			$data['title'] = "Cash Book";
			$data['print_preview'] = TRUE;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$this->load->view('report/report_template', $data);
			return;
		}
		/********************** BANK BOOK *************************/

		if ($statement == "bankbook")
		{
			$this->load->helper('text');

			/* Pagination setup */
			$this->load->library('pagination');

			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['ledger_id'] = $this->uri->segment(4);
			/* Checking for valid ledger id */
			if ($data['ledger_id'] == "")
			{
				$this->messages->add('Invalid Ledger account.', 'error');
				redirect('report/cashbook');
				return;
			}

			else if ($data['ledger_id'] == 0) {
				// $this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				$sql="SELECT * FROM (`ledgers`) WHERE `id` !=0";
				$query = $this->db->query($sql);

			} 
			else{
				$this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				if ($this->db->get()->num_rows() < 1)
				{
					$this->messages->add('Invalid Ledger account.', 'error');
					redirect('report/cashbook');
					return;
				}
			}
			

			$data['report'] = "report/bankbook";
			$data['title'] = "Bank Book";
			$data['print_preview'] = TRUE;
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$this->load->view('report/report_template', $data);
			return;
		}

		if ($statement == "trialbalance_new")
		{


			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);

			if (!empty($from_date_1) && !empty($to_date_1) ) {

				$data['from_date'] = $from_date_1;
				$data['to_date'] = $to_date_1;

			}
			else{

				$account_data = $this->Setting_model->get_current();
				$start_date=$account_data->fy_start;
				$end_date=$account_data->fy_end;	
				$data['from_date']['value'] = $start_date;
				$data['to_date']['value'] = $end_date;				

			}

			$this->load->library('accountlist');
			$data['report'] = "report/trialbalance_new";
			$data['title'] = "Trial Balance";
			$data['show_search'] = "NO";
			$data['print_preview'] = "YES";
			$this->load->view('report/report_template', $data);
			return;
		}


		if ($statement == "profitandloss_new")
		{
			$data['report'] = "report/profitandloss_new";
			$data['title'] = "Profit and Loss Statement";
			$data['left_width'] = "";
			$data['right_width'] = "";
			$from_date_1 = $this->uri->segment(4);
			$to_date_1 = $this->uri->segment(5);


			if (!empty($from_date_1) && !empty($to_date_1) ) {

				$data['from_date'] = $from_date_1;
				$data['to_date'] = $to_date_1;

			}
			else{

				$account_data = $this->Setting_model->get_current();
				$start_date=$account_data->fy_start;
				$end_date=$account_data->fy_end;	
				$data['from_date'] = $start_date;
				$data['to_date'] = $end_date;				

			}

		
			$this->load->view('report/report_template', $data);
			return;
		}





		return;
	}
	function cashbook($ledger_id = NULL,$from_date=NULL,$to_date=NULL)
	{

		/* Loading Helper */
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		$this->template->set('page_title', 'Cash Book');
		
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		if (!empty($from_date) && !empty($to_date) ) {
			$data['from_date']['value']=$from_date;
			$data['to_date']['value']=$to_date;
			$data['submit_press'] = TRUE;
			$data['account_data']=$account_data = $this->Setting_model->get_current();
		}

		$ledger_id = 1;
		if ($_POST)
		{
			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['start_date']=$account_data->fy_start;
			$data['end_date']=$account_data->fy_end;			
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);
			
			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	
			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/cashbook/' . $ledger_id.'/'.$a.'/'.$b);
		}



		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;


		if ($ledger_id != ""){

			$this->template->set('nav_links', array('report/download/cashbook/' . $ledger_id.'/'.$from_date.'/'.$to_date  => 'Download CSV', 'report/printpreview/cashbook/'.$ledger_id.'/'.$from_date.'/'.$to_date => 'Print Preview'));	
		}	

		$this->template->load('template', 'report/cashbook', $data);
		return;
	}

	function bankbook($ledger_id = NULL,$from_date=NULL,$to_date=NULL)
	{

		/* Loading Helper */
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		$this->template->set('page_title', 'Ledger Statement');
		
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		if (!empty($from_date) && !empty($to_date) ) {
			$data['from_date']['value']=$from_date;
			$data['to_date']['value']=$to_date;
			$data['submit_press'] = TRUE;
			$data['account_data']=$account_data = $this->Setting_model->get_current();
		}

		if ($_POST)
		{
			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['start_date']=$account_data->fy_start;
			$data['end_date']=$account_data->fy_end;			
			$ledger_id = $this->input->post('ledger_id', TRUE);
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);
			
			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	
			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/bankbook/' . $ledger_id.'/'.$a.'/'.$b);
		}
		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;

		/* Checking for valid ledger id */
			if ($data['ledger_id'] > 0)
			{
					$this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
					if ($this->db->get()->num_rows() < 1)
					{
						$this->messages->add('Invalid Ledger account.', 'error');
						redirect('report/bankbook');
						return;
					}
			}
			else if ($data['ledger_id'] == 0) {
				// $this->db->from('ledgers')->where('id', $data['ledger_id'])->limit(1);
				$sql="SELECT * FROM (`ledgers`) WHERE `id` !=0 AND `reconciliation`=1 AND `type`=1 ";
				$query = $this->db->query($sql);

			} 
			else if ($data['ledger_id'] < 0) {
					$this->messages->add('Invalid Ledger account.', 'error');
					redirect('report/bankbook');
					return;
			}

			if ($ledger_id != ""){

			       $this->template->set('nav_links', array('report/download/bankbook/' . $ledger_id.'/'.$from_date.'/'.$to_date  => 'Download CSV', 'report/printpreview/bankbook/'.$ledger_id.'/'.$from_date.'/'.$to_date => 'Print Preview'));	
			}	

			$this->template->load('template', 'report/bankbook', $data);
			return;
	}

	function trialbalance_new($from_date=NULL,$to_date=NULL)
	{


		/* Loading Helper */
		$this->load->helper('text');

		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->load->library('pagination');

		/* Input fields to view */
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		if (!empty($from_date) && !empty($to_date) ) {
			$data['from_date']['value']=$from_date;
			$data['to_date']['value']=$to_date;
			$data['submit_press'] = TRUE;
			$data['account_data']=$account_data = $this->Setting_model->get_current();
		}



		if ($_POST)
		{
			$data['account_data']=$account_data = $this->Setting_model->get_current();
			$data['start_date']=$account_data->fy_start;
			$data['end_date']=$account_data->fy_end;			
			$ledger_id = $this->input->post('ledger_id', TRUE);
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);
			
			if (empty($a)) {
				$a=$data['start_date'];
			}
			if (empty($b)) {
				$b=$data['end_date'];
			}	
			$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
			$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));

			redirect('report/trialbalance_new/'.$a.'/'.$b);
		}


		$this->template->set('page_title', 'Trial Balance');
		$this->template->set('nav_links', array('report/printpreview/trialbalance_new/'.$from_date.'/'.$to_date => 'Print Preview'));
		$this->load->library('accountlist');
		$this->template->load('template', 'report/trialbalance_new',$data);
		return;
	}
	function profitandloss_new($period = NULL,$from_date=NULL,$to_date=NULL)
	{
		/* Loding Model */
		$this->load->model('Setting_model');

		/* Pagination setup */
		$this->template->set('page_title', 'Profit And Loss Statement');

		/* Input fields to view */
		$data['from_date'] = array(
			'name' => 'from_date',
			'id' => 'from_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);	

		$data['to_date'] = array(
			'name' => 'to_date',
			'id' => 'to_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);			

		/* Dump data to view after redirection */
		if (!empty($period) && !empty($from_date) ) {
			$data['submit_press']=TRUE;
			$data['from_date']['value']=$period;
			$data['to_date']['value']=$from_date;
		}			

		/* Taking data from DB */
		$account_data = $this->Setting_model->get_current();
		$data['start_date']=$account_data->fy_start;
		$data['end_date']=$account_data->fy_end;

		if ($_POST)
		{
			$a=$data['from_date']['value'] = $this->input->post('from_date', TRUE);
			$b=$data['to_date']['value'] = $this->input->post('to_date', TRUE);

				if (empty($a)) {
					$a=$data['start_date'];
				}
				if (empty($b)) {
					$b=$data['end_date'];
				}	

				$a = date('Y-m-d', strtotime(str_replace('/', '-', $a)));
				$b = date('Y-m-d', strtotime(str_replace('/', '-', $b)));	
				
				redirect('report/profitandloss_new/'.$a.'/'.$b);		
		}		

		$this->template->set('nav_links', array('report/download/profitandloss_new
			/'.$period.'/'.$from_date => 'Download CSV', 'report/printpreview/profitandloss_new/'.$period.'/'.$from_date => 'Print Preview'));
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$data['print_preview'] = "YES";
		$this->template->load('template', 'report/profitandloss_new', $data);
		return;
	}






}



/* End of file report.php */
/* Location: ./system/application/controllers/report.php */
