<?php

class Welcome extends Controller {

	function __construct()
	{
		// parent::Controller();
		parent::__construct();

		/* Check access */
		if ( ! check_access('change account settings'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('');
			return;
		}

		return;
	}

	function index()
	{
		$this->template->set('page_title', 'Settings');
		$this->template->load('template', 'setting/index');
		return;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/setting/welcome.php */
