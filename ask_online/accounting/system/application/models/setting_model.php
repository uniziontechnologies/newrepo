<?php

class Setting_model extends Model {

	function __construct()
	{
		// parent::Model();
		parent::__construct();
	}

	function get_current()
	{
		$this->db->from('settings')->where('id', 1);
		$account_q = $this->db->get();
		return $account_q->row();
	}
}
