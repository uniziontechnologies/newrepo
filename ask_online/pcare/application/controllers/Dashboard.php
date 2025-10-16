<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
     
     
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	/**
	 * Index Page for this controller.
	
	 */
	public function index($currentMenu = null, $subMenu = null )
	{
		 //load models
		 $this->load->model('invoice_model');
		 $this->load->model('batch_model');
		 $this->load->model('brand_model');

		 $data['current_menu']=$currentMenu;
		 $data['sub_menu']=$subMenu; 
		 $data['clinic_name']=$this->commonDBFunctions->getidToValue('hospital_name','id','1','hospital_info');

		 $data['today_bill_collection']=$this->invoice_model->todayBillCollection();
		 $data['total_credit']=$this->invoice_model->totalCredit();
		 $data['expired_stock']=$this->batch_model->expiredStock();
		 $data['low_inventory']=$this->brand_model->totalLowInventory();
		 
         $search[] ="payment_mode = 'CREDIT'";
		 $search[] ="status = 0";

		 $billInfo=$this->invoice_model->searchBill($search,'credit');

		 $sum = 0;

		 if (!empty($billInfo)) {
		 	
		 	for ($i=0; $i < count($billInfo) ; $i++) { 
		 		
		 		// var_dump($billInfo[$i][32]);

		 		if ($billInfo[$i][56] != 2) {
		 			$sum+=$billInfo[$i][32];
		 		}

		 		

		 	}

		 }
		$data['total_credit']=$sum;
		 
		 $this->load->view('home',$data);	
		
	}
	public function home()
	{	
		 
		$this->load->view('home');
	}
	
	public function set_theme($theme){
	
		//$theme=$this->input->post('StyleFile');
		$this->session->set_userdata("theme",$theme);
		
		$segs = $this->uri->segment_array();
		$i=0;
		$current_menu='';
		$sub_menu='';
		
		/*foreach ($segs as $segment){
   			
			if($i==0) $current_menu=$segment;
			if($i==1) $sub_menu=$segment;
			
			$i++;
			
		}*/
		redirect("welcome/index");
		//$this->index($current_menu,$sub_menu);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
