<?php
class Customer extends CI_Model {

   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getCustomerCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->where('status','0');
		$this->db->from("pharma_customers");
        $count = $this->db->count_all_results();

        return $count;
		
    } 
    
    function getCustomer($search = null,$limit=null,$offset=null)
    {
    	if(!empty($limit)){

            $limit=explode(",",$limit);

		}

		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');

        if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_customers');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->customer_name;
			$options[$i][2] = $row->address;
			$options[$i][3] = $row->contact_number ;
			$options[$i][4] = $row->email  ;
			$options[$i][5] = $row->opening_balance;
			$options[$i][6] = $row->credit_limit;
			$options[$i][7] = $row->status;
			$i++;
		}
		return $options;
		
    }
	  
	function create(){
	
		$this->customer_name 	= $this->input->post('Customer_name');
	    $this->address   	 	= $this->input->post('address');
	    $this->contact_number   = $this->input->post('contact_no');
		$this->email   			=$this->input->post('email');
		$this->opening_balance  =$this->input->post('opening_balance');
		$this->credit_limit   	=$this->input->post('credit_limit');
		$this->status   		= '0';
		$result=$this->db->insert('pharma_customers', $this);
		
		if($result) {
			return  $this->lang->line('add_success');
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function update(){
	
		$condition				= array('id' => $this->input->post('id'));
		$this->customer_name 	= $this->input->post('Customer_name');
	    $this->address   	 	= $this->input->post('address');
	    $this->contact_number   = $this->input->post('contact_no');
		$this->email   			=$this->input->post('email');
		$this->opening_balance  =$this->input->post('opening_balance');
		$this->credit_limit   	=$this->input->post('credit_limit');
		$this->status   		= '0';
		
		$result=$this->db->update('pharma_customers', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	function delete($id){
	
		$condition				= array('id' => $id);
		$this->status   		= '1';
		
		$result=$this->db->update('pharma_customers', $this,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}


}
?>
