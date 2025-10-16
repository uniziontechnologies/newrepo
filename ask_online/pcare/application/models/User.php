<?php



class User extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function login($username, $password)
	{
		$this->db->where(array('user_name' => $username,'password'=>md5($password), 'status'=>0));
		$this->db->where("(user_type = 8 or user_type=9)");
		
		
		 $query=$this->db->get('users');
		 // echo $this->db->last_query();

		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('user_id', $row->id);
			$this->session->set_userdata('username', $row->user_name);
			$this->session->set_userdata('user_type', $row->user_type);
			$user_type_name=$this->commonDBFunctions->getidToValue('user_type','id',$row->user_type,'hcare_user_type');;
			 $this->session->set_userdata('user_type_name', $user_type_name);
			$this->session->set_userdata('company', true);
			$employee_name=$this->commonDBFunctions->getidToValue('first_name','id',$row->employee_id,'emp_info')." ".$this->commonDBFunctions->getidToValue('last_name','id',$row->employee_id,'emp_info');
			$this->session->set_userdata('branch_id', $row->branch);
// 			$this->session->set_userdata('employee_name', $row->employee_name);
			return true;
		}
		return false;
	}
	
	
	function is_logged_in()
	{
		if($this->session->userdata('company')!=false){
			return true;
		}else return false;
		
	}
	function userExist($id = null){
	
		$user = $this->input->post('user_name');
		if(!empty($id)){
			$this->db->not_like('id',$id);
		}
		
		$this->db->where('user_name',$user);
		$this->db->where('status',0);
		
        $query = $this->db->get('users');
		return $query->result();
	}

    function getUsersCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->where('status','0');
		$this->db->where("(user_type = 8 or user_type=9)");
		$this->db->from("users");
        $count = $this->db->count_all_results();

        return $count;
		
    } 

	function getUsers($search = null,$limit=null,$offset=null)
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
		$this->db->where("(user_type = 8 or user_type=9)");

		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}
			
        $query = $this->db->get('users');
		// echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->employee_id;
			$options[$i][2] = $row->user_name;			
			$options[$i][3] = $row->user_type ;
			$options[$i][4] = $this->commonDBFunctions->getidToValue('user_type','id',$row->user_type,'user_type');;			
			$options[$i][5] = $row->status;
			$options[$i][6] = $row->branch;
			$options[$i][7]=  $this->commonDBFunctions->getidToValue('branch_name','id',$row->branch,'pharma_branch');
			
			$i++;
		}
		return $options;
		
    }
	function create(){
	
		$this->employee_id 			= 0;
	    $this->user_name   			= $this->input->post('user_name');
	    $this->password  			= md5($this->input->post('password'));
		 $this->user_type  			= $this->input->post('user_type');	
		 $this->branch  			= $this->input->post('branch');		
		$this->status   			= '0';
		
		$result=$this->db->insert('users', $this);
		
		if($result) {
			return  $this->lang->line('add_success');
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function update(){
	
		$condition				= array('id' => $this->input->post('id'));
		$this->employee_id 		= 0;
	    $this->user_name   		= $this->input->post('user_name');
	    $password  				= $this->input->post('password');
		if(!empty($password)){
			 $this->password  	= md5($password);
		}
		 $this->user_type  			= $this->input->post('user_type');	
		 $this->branch  			= $this->input->post('branch');			
		$this->status   			= '0';
		
		$result=$this->db->update('users', $this,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	
	function delete($id){
	
		$condition				= array('id' => $id);
		$this->status   		= '1';
		
		$result=$this->db->update('users', $this,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function getUsertype($search = null,$limit=null,$offset=null)
    {
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');		

		if($limit !=''){
		
		   $this->db->limit($limit,$offset);
		}
			
        $query = $this->db->get('hcare_user_type');
		//echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->user_type;
			$options[$i][2] = $row->status;			
			
			$i++;
		}
		return $options;
		
    }

}


?>