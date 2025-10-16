<?php

class Admin_model extends CI_Model {

	 function __construct()
     {
        // Call the Model constructor
        parent::__construct();
     }

	function getHospitalInfo($search = null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
        $query = $this->db->get('hospital_info');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->hospital_name ;
			$options[$i][2] = $row->address ;
			$options[$i][3] = $row->city ;
			$options[$i][4] = $row->state ;
			$options[$i][5] = $row->country   ;
			$options[$i][6] = $row->zip_code;
			$options[$i][7] = $row->phone;
			$options[$i][8] = $row->fax;
			$options[$i][9] = $row->email;
			$options[$i][10] = $row->website;
			$options[$i][11] = $row->logo;
			$options[$i][12] = $row->currency;
			$options[$i][13] = $row->lock_page;
			
			$i++;
		}
		return $options;
		
    }

    function updateHospitalInfo(){

		$condition				= array('id' => 1);
		$this->hospital_name 	=$this->input->post('hospital_name');
	    $this->address   	 	=$this->input->post('address');
	    $this->city   			=$this->input->post('city');
		$this->state   			=$this->input->post('state');
		$this->country  		=$this->input->post('country');
		$this->zip_code   		=$this->input->post('zipcode');
		$this->phone   			=$this->input->post('phone_no');
		$this->fax   			=$this->input->post('fax');
		$this->email   			=$this->input->post('email');
		$this->website   		=$this->input->post('website');
		$this->logo   			=$this->input->post('logo');
		$this->currency   		=$this->input->post('currency');
		
		$result=$this->db->update('hospital_info', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}

	}

	function getPharmacyInfo($search = null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
        $query = $this->db->get('pharma_config');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->pharmacy_name;
			$options[$i][2] = $row->gst_no; 
			$options[$i][3] = $row->dl_no;
			$options[$i][4] = $row->sales_privilege;
			$options[$i][5] = $row->tax;
			$options[$i][6] = $row->cess;
			$options[$i][7] = $row->email_with_cc;
			
			$i++;
		}
		return $options;
		
    }

    function updatePharmacyInfo(){

		$condition				=array('id' => 1);
		$this->pharmacy_name   	=$this->input->post('pharmacy_name');
		$this->gst_no   		=$this->input->post('gst_no');
		$this->dl_no   		    =$this->input->post('dl_no');

		$email_list   	=$this->input->post('cc_email_list');
		$cc_emails='';
        
        if(!empty($email_list)){
		   $cc_emails= implode(",",$email_list);
        }

		$this->email_with_cc   	=$cc_emails;

		
		
		$result=$this->db->update('pharma_config', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}

	}
	function addStatus($type,$user_id){
	
		$data = array('date'          => date("Y-m-d H:i:s"),
	                  'type'  	      => $type,
	                  'user_id'       => $user_id,
		            );
	
		$result=$this->db->insert('hcare_pharma_import', $data);
		
		if($result) {
			return  $this->db->insert_id();
		}else{
			return  0;
		}
	}
	function showHistory($type=null)
    {
		$options = array();

		if (!empty($type)) {
			
			$this->db->where('type',$type);

		}

		$i=0;
		
        $query = $this->db->get('hcare_pharma_import');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->date;
			$options[$i][2] = $row->type; 
			$options[$i][3] = $row->user_id;
			$options[$i][4] = $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
			
			$i++;
		}
		return $options;
		
    }
	function updatePrinterSettings($lock_page){
		
			$condition	= array('id' => 1);
		
		    $data = array( 'lock_page' => $lock_page);
		
			$result=$this->db->update('hcare_hospital_info', $data,$condition);

			if($result) {
				return  $this->lang->line('success');
			}else{
				return  $this->lang->line('failed');
			}

	}


      
}	

?>