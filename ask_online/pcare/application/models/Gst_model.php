<?php



class Gst_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	function getGstInfo($search = null)
    {
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');		
			
        $query = $this->db->get('pharma_gst');
		//echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->gst;
			$options[$i][2] = $row->sgst;			
			$options[$i][3] = $row->cgst;			
			$options[$i][4] = $row->igst;
			$options[$i][5] = $row->status;
			
			$i++;
		}
		return $options;
		
    }
	function create(){  
	       
	     $this->gst   			= $this->input->post('gst_per');
	     $this->sgst  			= $this->input->post('sgst_per');
		 $this->cgst  			= $this->input->post('cgst_per');	
		 $this->igst  			= $this->input->post('igst_per');		
		 $this->status   		= '0';
		
		$result=$this->db->insert('pharma_gst', $this);

		if($result) {
			return  $this->lang->line('add_success');
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function update(){
	                   
		$condition				= array('id' => $this->input->post('gstid'));
	    $this->gst   			= $this->input->post('gst_per');
	    $this->sgst  			= $this->input->post('sgst_per');
		$this->cgst  			= $this->input->post('cgst_per');	
		$this->igst  			= $this->input->post('igst_per');		
		$this->status   		= '0';
		
		$result=$this->db->update('pharma_gst', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	
	function delete($id){
	                     
		$condition				= array('id' => $id);
		$this->status   		= '1';
		
		$result=$this->db->update('pharma_gst', $this,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	

	function Gst_dropdown_amt($gst_per = null){

		$options = array();
		
		if(!empty($gst_per)){
			   $this->db->where('gst',$gst_per);
		}
		else{
               $options[''] = '---';  
		}
		$this->db->where('status','0');
		$this->db->order_by("gst", "asc"); 
        $query = $this->db->get('pharma_gst');
		
		foreach ($query->result() as $row)
		{
		
			$options[$row->gst] = $row->gst;
			
		}
		
		return $options;
	}


}


?>