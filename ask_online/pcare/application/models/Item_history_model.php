<?php
class Item_history_model extends CI_Model {

   
	
	public $id;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
       
	  
	public function add_history($info){
	
			
			$data = array(
   					'brand_id' => $info['brand_id'] ,
   					'batch_id' => $info['batch_id'],
					'type' => $info['type'],
					'quantity' => $info['quantity'],
					'old_stock_batch' => $info['old_stock_batch'],
					'new_stock_batch' => $info['new_stock_batch'],
					'old_stock_brand' => $info['old_stock_brand'],
					'new_stock_brand' => $info['new_stock_brand'],
					'action' => $info['action'],
					'mode' => $info['mode'],
					'reference_id' => $info['reference_id'],
					'date' => date("Y-m-d H:i"),
					'user_id' => $this->session->userdata('user_id'),
                    'expiry_date' 	=> $info['expiry_date'],
                    'new_expiry_date ' 	=> $info['new_expiry_date'],
					'branch_id' 	=> $info['branch_id'],
					'old_stock_branch' => $info['old_stock_branch'],
					'new_stock_branch' => $info['new_stock_branch'],
					'brand_name' => $info['brand_name'],
					'batch_number' => $info['batch_number']
					);
        $info['date']=date("Y-m-d H:i");
		$this->db->insert('pharma_item_history', $data); 
	
	}

}
?>
