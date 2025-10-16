<?php
class Movement_model extends CI_Model {

   
	
	public $id;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
     function addMovement(){
	  
	  	$this->move_from 		= $this->input->post('from');
		$this->move_to		=$this->input->post('to');
		$this->remarks 			=$this->input->post('remarks');
	    $this->movement_date   	 	= date("Y-m-d");
	    $this->total_buyp 		=$this->input->post('total_buyp');
	    $this->total_sellp 		=$this->input->post('total_sellp');
	    $this->user_id   	 	= $this->session->userdata('user_id');
		$this->status   	 	=0;
		
		$result=$this->db->insert('pharma_movement', $this);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	  }
	  
	  function addmovementItems($item){
	  
	  	$data = array('movement_id'    => $this->id,
						'brand_id'   =>$item[0],
					   'batch_id'   =>$item[9],	                   
						'batch_no'    =>$item[2],
						'expiry '         =>date("Y-m-d-",strtotime($item[3])),
						'unit'   	   =>$item[4],		
						'quantity' 	   => $item[6],	
						'buyp' 	        => $item[15],
						'sellp' 	    => $item[16],
						'total_buyp'    => $item[17],
						'total_sellp'   => $item[18],
						'movement_date'  => date("Y-m-d")
		
				);
				
		$result=$this->db->insert('pharma_movement_items', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	  } 

	  function getMovementCount($search= null){
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_movement");
        $count = $this->db->count_all_results();

        return $count;
		
      } 
	  
	  public function searchMovement($criteria,$cancelled=null,$limit = null){

	  	if(!empty($limit)){

            $limit=explode(",",$limit);

		}
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		if (empty($cancelled)) {
			$this->db->where('status',0);
		}
      
        if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

		$query=$this->db->get('pharma_movement');
		$movementInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$movementInfo[$i][0]= $i+1;
				$movementInfo[$i][1]= $row->id;
				$movementInfo[$i][2]= $row->move_from;
				$movementInfo[$i][3]= ($row->move_from == 0)?'Main Stock':$this->commonDBFunctions->getidToValue('branch_name','id',$row->move_from,'pharma_branch');
				$movementInfo[$i][4]= $row->move_to;
				
				$movementInfo[$i][5]= ($row->move_to == 0)?'Main Stock':$this->commonDBFunctions->getidToValue('branch_name','id',$row->move_to,'pharma_branch');;;
				$movementInfo[$i][6]= $row->remarks;
				$movementInfo[$i][7]= $row->movement_date; 	
				$movementInfo[$i][8]= $row->status;
				$movementInfo[$i][9]= $row->user_id;
				$movementInfo[$i][10]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');;
				$movementInfo[$i][11]= $row->cancelled_date;
				$movementInfo[$i][12]= $row->cancelled_by;
				$movementInfo[$i][13]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');

				$i++;
				
			}
		}
		return $movementInfo;
	}
	public function searchMovementItems($criteria,$cancelled=null){
	
	
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		if (empty($cancelled)) {
			$this->db->where('status',0);
		}
		$query=$this->db->get('pharma_movement_items');
		
		$movementInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$movementInfo[$i][0]= $i+1;
				$movementInfo[$i][1]= $row->movement_id;
				$movementInfo[$i][2]= $row->brand_id;
				$movementInfo[$i][3]= $row->batch_id;
				$movementInfo[$i][4]= $row->batch_no;
				$movementInfo[$i][5]= $row->expiry;				
				$movementInfo[$i][6]= $row->unit;
				$movementInfo[$i][7]= $row->quantity;
				$movementInfo[$i][8]= $row->movement_date;
				$movementInfo[$i][9]= $row->status;						
				$movementInfo[$i][10]= $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'pharma_brand');;
				$movementInfo[$i][11]=$sellp= $this->commonDBFunctions->getidToValue('sellp','id',$row->batch_id,'pharma_batch');
				
				$totalsellp=$row->quantity*$sellp;
				
				$movementInfo[$i][12]=$totalsellp;
				$movementInfo[$i][13]= $this->commonDBFunctions->getidToValue('user_id','id',$row->movement_id,'pharma_movement');
				$movementInfo[$i][14]= $this->commonDBFunctions->getidToValue('user_name','id',$movementInfo[$i][13],'users');
				
				
				$i++;
			
			}
		}
		
		return $movementInfo;
	
	}

	function delete_movement($id){
	
		
			$condition = array('id' => $id);
			
		    $data = array('cancelled_date' => date('Y-m-d'),
		    			  'cancelled_by' => $this->session->userdata('user_id'),
		    			  'status' =>1);
			$result=$this->db->update('pharma_movement', $data,$condition);
		
		
		//$result=$this->db->delete('pharma_recievings',$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function delete_movement_items($movement_id){
	
		
		 $condition	= array('movement_id' => $movement_id);
		 $data = array( 'status' =>1);
		
		
		$result=$this->db->update('pharma_movement_items', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	  
	


}
?>
