<?php
class Supplier extends CI_Model {

   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

   function getSupplierCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->where('status','0');
		$this->db->from("pharma_suppliers");
        $count = $this->db->count_all_results();

        return $count;
		
    } 
	
  function getSupplier($search = null,$limit=null,$offset=null)
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
		$this->db->order_by("supplier_name", "asc"); 

        if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_suppliers');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->supplier_name;
			$options[$i][2] = $row->address;
			$options[$i][3] = $row->contact_number ;
			$options[$i][4] = $row->email  ;
			$options[$i][5] = $row->opening_balance;
			$options[$i][6] = $row->credit_limit;
			$options[$i][7] = $row->status;
			$options[$i][8] = $row->tin_no;
			$options[$i][9] = $row->ledger_id;
			$options[$i][10] = $row->gst_no;
			$i++;
		}
		return $options;
		
    }
	function create($ledger_id){
	
		$this->supplier_name 	= $this->input->post('Supplier_name');
	    $this->address   	 	= $this->input->post('address');
	    $this->contact_number   = $this->input->post('contact_no');
		$this->tin_no           = $this->input->post('tin_no');
		$this->gst_no           = $this->input->post('gst_no');
		$this->email   			=$this->input->post('email');
		$this->opening_balance  =$this->input->post('opening_balance');
		$this->credit_limit   	=$this->input->post('credit_limit');
		$this->ledger_id   	    =$ledger_id;
		$this->status   		= '0';
		$result=$this->db->insert('pharma_suppliers', $this);
		
		if($result) {
			return  array($this->lang->line('add_success'),$this->db->insert_id());
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function update($ledger_id){
	
		$condition				= array('id' => $this->input->post('id'));
		$this->supplier_name 	= $this->input->post('Supplier_name');
	    $this->address   	 	= $this->input->post('address');
	    $this->contact_number   = $this->input->post('contact_no');
		$this->tin_no           = $this->input->post('tin_no');
		$this->gst_no           = $this->input->post('gst_no');
		$this->email   			=$this->input->post('email');
		$this->opening_balance  =$this->input->post('opening_balance');
		$this->credit_limit   	=$this->input->post('credit_limit');
if(!empty($ledger_id) && ($ledger_id!=0))
    {		
		$this->ledger_id   	    =$ledger_id;
	}
		$this->status   		= '0';
		
		$result=$this->db->update('pharma_suppliers', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	function delete($id){
	
		$condition				= array('id' => $id);
		$this->status   		= '1';
		
		$result=$this->db->update('pharma_suppliers', $this,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function create_supplier($ledger_id,$supplier){
	
		$this->supplier_name 	= $supplier;
	    $this->address   	 	= '';
	    $this->contact_number   = '';
		$this->tin_no           = '';
		$this->gst_no           = '';
		$this->email   			= '';
		$this->opening_balance  = '';
		$this->credit_limit   	= '';
		$this->ledger_id   	    = $ledger_id;
		$this->status   		= '0';
		$result=$this->db->insert('pharma_suppliers', $this);
		
		if($result) {
			return  array($this->lang->line('add_success'),$this->db->insert_id());
		}else{
			return  $this->lang->line('add_failed');
		}
	}


}
?>
