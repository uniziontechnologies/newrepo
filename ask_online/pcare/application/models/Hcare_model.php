<?php
class Hcare_model extends CI_Model {

   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   function getOPPatientInfo($search = null){
   
   		$this->db->select("a.`id` , a.`first_name` , a.`middle_name` , a.`last_name` , a.`age` , a.`dob` , a.`gender` , a.`marital_status` , a.`place` , a.`nationality` , a.`contact_no` , a.`email` , a.`status` , b.`id` as opid , b.`doc_id` , c.`first_name` as doc_first_name , c.`last_name` as doc_last_name , b.`doc_fee` , b.`reg_fee` , b.`visit_time` , b.`visit_date` , b.`validity_expiry` , b.`insurance_company` , d.`insurance_company` , b.`policy_no` , b.`claim_no` , b.`company_name` , b.`company_id` , b.`relation` , b.`ins_date_issue` , b.`ins_date_expiry` , b.`ins_cons_disc_amt` , b.`visit_status` , b.`remarks` , b.`refferal_info` , b.`user_id` , b.`token_no` , b.`reg_from` , b.`mlc_summary` , b.`op_reset_no` , b.`paid_status` , b.`free` , b.`cancelled` , b.`cancellation_details` , b.`observation`, b.`card_fee`, b.`payment_status`");
	
	$this->db->from('op_patient_info a');
	
	$this->db->join('op_visit_info b', 'a.id = b.opno','left');
	$this->db->join('emp_info c', 'b.doc_id = c.`id`','left');
	$this->db->join('insurance_company d', 'b.insurance_company = d.id','left');
	
	if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');

		$this->db->where('b.cancelled','0');
		
		$this->db->order_by("b.id", "desc"); 
		
		$query = $this->db->get();
		
		$options = array();
		$new_criteria = array();
		$i=0;
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->first_name;
			$options[$i][2] = $row->middle_name;
			$options[$i][3] = $row->last_name ;
			$options[$i][4] = $row->age  ;
			$options[$i][5] = $row->dob;
			$options[$i][6] = $row->gender;
			$options[$i][7] = $row->marital_status;
			$options[$i][8] = $row->place;
			$options[$i][9] = $row->nationality;
			$options[$i][10] = $row->contact_no;
			$options[$i][11] = $row->email;
			$options[$i][12] = $row->status;
			$options[$i][13] = $row->opid;
			$options[$i][14] = $row->doc_id;
			$options[$i][15] = $row->doc_first_name;
			$options[$i][16] = $row->doc_last_name;
			$options[$i][17] = $row->doc_fee;
			$options[$i][18] = $row->reg_fee;
			$options[$i][19] = $row->visit_time;
			$options[$i][20] = $row->visit_date;
			$options[$i][21] = $row->validity_expiry;
			$options[$i][22] = $row->insurance_company;
			$options[$i][23] = $row->insurance_company;
			$options[$i][24] = $row->policy_no;
			$options[$i][25] = $row->claim_no;
			$options[$i][26] = $row->company_name;
			$options[$i][27] = $row->company_id;
			$options[$i][28] = $row->relation;
			$options[$i][29] = $row->ins_date_issue;
			$options[$i][30] = $row->ins_date_expiry;
			$options[$i][31] = $row->ins_cons_disc_amt;
			$options[$i][32] = $row->visit_status;
			$options[$i][33] = $row->remarks;
			$options[$i][34] = $row->refferal_info;
			$options[$i][35] = $row->user_id;
			$options[$i][36] = $row->token_no;
			$options[$i][37] = $row->reg_from;
			$options[$i][38] = $row->mlc_summary;
			$options[$i][39] = $row->op_reset_no;
			$options[$i][40] = $row->paid_status;
			$options[$i][41] = $row->free;
			$options[$i][42] = $row->cancelled;
			$options[$i][43] = $row->cancellation_details;
			$options[$i][44] = $row->observation;

			$new_criteria[0] = "visit_id = ".$row->opid;
			$new_criteria[1] = "status = 0";

			$options[$i][45]=$this->commonDBFunctions->getidToValue_multiple('id',$new_criteria,'medicine_prescribed');

			$options[$i][46] = $row->card_fee;
			$options[$i][47] = $row->payment_status;
			// $options[$i][45] = $this->commonDBFunctions->getidToValue('id','visit_id',$row->opid,'medicine_prescribed');
			$i++;
		}
		return $options;
	
   
   }
function getIPPatientInfo($search = null ){
	
              
   		$this->db->select("a.`id` , a.`first_name` , a.`middle_name` , a.`last_name` , a.`age` , a.`dob` , a.`gender` , a.`marital_status` , a.`place` , a.`nationality` , a.`contact_no` , a.`email` , a.`status` , b.`id` as ipno ,b.`visit_id`,b.`opno`, b.`doc_id` , f.`first_name` as doc_first_name , f.`last_name` as doc_last_name , b.`admission_time` ,b.`admission_date` , b.`discharge_time` , b.`discharge_date` , b.`insurance_company` , d.`insurance_company` , b.`policy_no` , b.`claim_no` , b.`company_name` , b.`company_id` , b.`relation` , b.`ins_date_issue` , b.`ins_date_expiry` ,  b.`room_id` , b.`bed_id` , b.`room_rent` , c.`room_category` , c.`room_number` , e.`bed_number` , b.`remarks`");
	
	$this->db->from('hcare_ip_info b');
	
	$this->db->join('hcare_op_patient_info a', 'b.opno = a.`id`','left');
	$this->db->join('hcare_rooms c', 'b.room_id = c.`id`','left');
	$this->db->join('hcare_room_beds e', 'b.bed_id = e.`id`','left');
        $this->db->join('hcare_emp_info f', 'b.doc_id = f.`id`','left');
         $this->db->join('hcare_insurance_company d', 'b.insurance_company = d.`id`','left');

               if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');
		
		$this->db->order_by("b.id", "asc"); 
		
		$query = $this->db->get();
		// echo $this->db->last_query();
		$options = array();
		$new_criteria = array();
		$i=0;
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->first_name;
			$options[$i][2] = $row->middle_name;
			$options[$i][3] = $row->last_name ;
			$options[$i][4] = $row->age  ;
			$options[$i][5] = $row->dob;
			$options[$i][6] = $row->gender;
			$options[$i][7] = $row->marital_status;
			$options[$i][8] = $row->place;
			$options[$i][9] = $row->nationality;
			$options[$i][10] = $row->contact_no;
			$options[$i][11] = $row->email;
			$options[$i][12] = $row->status;
			$options[$i][13] = $row->ipno;
                        $options[$i][14] = $row->visit_id;
                        $options[$i][15] = $row->opno;
			$options[$i][16] = $row->doc_id;
			$options[$i][17] = $row->doc_first_name;
			$options[$i][18] = $row->doc_last_name;
			$options[$i][19] = $row->admission_time;
			$options[$i][20] = $row->admission_date;
			$options[$i][21] = $row->discharge_time;
			$options[$i][22] = $row->discharge_date;			
			$options[$i][23] = $row->insurance_company;
			$options[$i][24] = $row->insurance_company;
			$options[$i][25] = $row->policy_no;
			$options[$i][26] = $row->claim_no;
			$options[$i][27] = $row->company_name;
			$options[$i][28] = $row->company_id;
			$options[$i][29] = $row->relation;
			$options[$i][30] = $row->ins_date_issue;
			$options[$i][31] = $row->ins_date_expiry;
			$options[$i][32] = $row->room_id;
			$options[$i][33] = $row->bed_id;
			$options[$i][34] = $row->room_rent;
			$options[$i][35] = $row->room_category;
			$options[$i][36] = $row->room_number;
			$options[$i][37] = $row->bed_number;
			$options[$i][38] = $row->remarks;
			
			$new_criteria[0] = "ipno = ".$row->ipno;
			$new_criteria[1] = "status = 0";

			$options[$i][39]=$this->commonDBFunctions->getidToValue_multiple('id',$new_criteria,'ip_medicines_prescribed');
			$options[$i][40]=$this->commonDBFunctions->getidToValue_multiple('id',$new_criteria,'ip_medicine_prescribed');

			$i++;
		}
		return $options;
	
   

	     
	
	}
    function getDoctors($search = null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

        $this->db->where('title','Dr');
		$this->db->where('status','0');
		$this->db->order_by('first_name','asc');
        $query = $this->db->get('emp_info');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->title;			
			$options[$i][2] = $row->first_name;
            $options[$i][3] = $row->last_name;
            $options[$i][4] = $row->title." ".$row->first_name." ".$row->last_name;

			$i++;
		}
		return $options;
		
    }	
	function updateOpPayment(){
	
		
			$condition				= array('id' => $this->input->post('op_id'));
		
			$date=date("Y-m-d H:i:s");

			$user_id=$this->session->userdata('user_id');

			$op_payment = $this->input->post('op_payment');

			if (!empty($op_payment)) {

			    $data = array( 'payment_status'  => 1,
					           'payment_date' 	 => "$date",
					           'payment_user' 	 => "$user_id",
							
				);

			}
			else{

		    	$data = array( 'payment_status'  => 0,
				           'payment_date' 	 => '',
				           'payment_user' 	 => '',
						
				);

			}
		

					
		//$result=$this->db->delete('pharma_invoice',$condition);
		
		$result=$this->db->update('op_visit_info', $data,$condition);
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

}
?>
