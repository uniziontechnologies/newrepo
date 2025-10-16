<?php
class Purchase_order_model extends CI_Model {

   
	
	public $id;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function addPurchaseOrders(){

	
		$date=$this->input->post('date');

		date_default_timezone_set('Asia/Kolkata');
	    $update_history = $this->session->userdata('user_id')."|ADD PURCHASE ORDER|". date("d-m-Y H:i a");
		
		
	    $this->date   	 	= date("Y-m-d",strtotime($date));
	    $this->supplier   = $this->input->post('supplier');
		
	    $this->remarks   = $this->input->post('remarks');	
			
		$this->net_total   = $this->input->post('net_total');

		$this->update_history   = $update_history;

		$result=$this->db->insert('pharma_purchase_orders', $this);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function updatePurchaseOrders(){

		$id=$this->input->post('order_id');

		$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_purchase_orders');

        if(!empty($old_update)){

	           $update_history = $this->session->userdata('user_id')."|UPDATE PURCHASE ORDER|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
 
               $update_history = $this->session->userdata('user_id')."|UPDATE PURCHASE ORDER|". date("d-m-Y H:i a");
		}	 

		$condition				= array('id' => $id);
	
		$date=$this->input->post('date');

		$data= array ('date' 	      => date("Y-m-d",strtotime($date)),
	                  'supplier'  	  => $this->input->post('supplier'),
		              'remarks'       => $this->input->post('remarks'),
	                  'net_total'  	  =>  $this->input->post('net_total'),
	                  'update_history'=> $update_history 
			      );
			

		$result=$this->db->update('pharma_purchase_orders', $data,$condition);
		
		if($result) {
			return $id;
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function updateEmailStatus($id,$email_status,$email_id=null){

		$condition				= array('id' => $id);


		    $old_email=$this->commonDBFunctions->getidToValue('send_emails','id',$id,'pharma_purchase_orders');
		if(!empty($email_id)){

            if(!empty($old_email)){

	           $email_list = $email_id.",".$old_email;
		    }else{
 
               $email_list = $email_id;
		    }
		}else{

            if(!empty($old_email)){

	           $email_list = $old_email;
		    }else{
 
               $email_list = '';
		    }

		}	
       

		$data= array( 'send_emails'=> $email_list,
			          'email_status'=> $email_status
			        );
		
			

		$result=$this->db->update('pharma_purchase_orders', $data,$condition);
		
		if($result) {
			return $id;
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function addPurchaseorderItems($item){
	
		$date=$this->input->post('date');
        
        if(empty($item[3])){

        	$item[3]=0;
        }

       if ( !empty($item[5]) && !empty($item[3]) ) {
				
				$strip_qty = $item[3] * $item[4];

				$foc_quantity = $item[5] * $item[3];

				$total_qty = $strip_qty + $foc_quantity;				

			}
			elseif ( !empty($item[5]) && empty($item[3]) ) {

				$strip_qty = $item[4];

				$foc_quantity = $item[5];

				$total_qty = $item[5] + $item[4];

			}
			elseif (!empty($item[3]) && empty($item[5])) {

				$strip_qty = $item[3] * $item[4];

				$foc_quantity = 0;

				$total_qty = $strip_qty;

			}
			else{

				$strip_qty = $item[4];

				$foc_quantity = 0;

				$total_qty = $item[4];
			}
		
		$data = array(

					 'order_id'    => $this->id,
	   				 'date' => date("Y-m-d",strtotime($date)),
					 'item_id'   =>$item[0],	
					 'item_type' =>   $item[2], 
					 'tablets_per_pack' =>   $item[3],               	
					 'quantity' 	   => $item[4],
					 'buyp' 	   => $item[6],
					 'foc' 	   => $item[5],
					 'qty_in_unit' 	   => $strip_qty,
					 'foc_quantity' 	   => $foc_quantity,
					 'total_qty' 	   => $total_qty,
					 'total_amount' 	   => $item[7]	    				
					);

			
		$result=$this->db->insert('pharma_purchase_order_items', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	
	}

	function getPurchaseOrderCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_purchase_orders");
        $count = $this->db->count_all_results();

        return $count;
		
    } 

	public function searchPurchaseOrder($criteria,$purchase_status= null,$limit=null,$offset=null){

		if(!empty($limit)){

            $limit=explode(",",$limit);

		}
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}
		
		$query=$this->db->get('pharma_purchase_orders');
		// echo $this->db->last_query();
		$orderInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){

$purchase_no= $this->commonDBFunctions->getidToValue('id','pono',$row->id,'pharma_recievings');

if(!empty($purchase_status) && $purchase_status=='PENDING'){
	if(empty($purchase_no)){

		        $orderInfo[$i][0]= $i+1;
				$orderInfo[$i][1]= $row->id;
				
				$orderInfo[$i][2]= $row->date;
				$orderInfo[$i][3]= $row->supplier;
				$orderInfo[$i][4]= $this->commonDBFunctions->getidToValue('supplier_name','id',$row->supplier,'pharma_suppliers');				
				$orderInfo[$i][5]= $row->remarks;
				// $orderInfo[$i][6]= $this->commonDBFunctions->getidToValue('id','pono',$row->id,'pharma_recievings');

				$condition[0] = "pono = '".$row->id."'";
				$condition[1] = "status = 0";

				$orderInfo[$i][6]= $this->commonDBFunctions->getidToValue_multiple('id',$condition,'pharma_recievings');

				$orderInfo[$i][7]= $row->net_total;
				$orderInfo[$i][8]= $row->cancelled_by;
				$orderInfo[$i][9]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');
				$orderInfo[$i][10]= $row->cancellation_date;
				$orderInfo[$i][11]= $row->cancellation_details;
				$orderInfo[$i][12]= $row->status;
				$orderInfo[$i][13]= $this->commonDBFunctions->getidToValue('email','id',$row->supplier,'pharma_suppliers');
				$orderInfo[$i][14]= $row->email_status;
				$orderInfo[$i][15]= $row->send_emails;

				$i++;

	}
}elseif(!empty($purchase_status) && $purchase_status=='RECIEVED'){
	if(!empty($purchase_no)){

                $orderInfo[$i][0]= $i+1;
				$orderInfo[$i][1]= $row->id;
				
				$orderInfo[$i][2]= $row->date;
				$orderInfo[$i][3]= $row->supplier;
				$orderInfo[$i][4]= $this->commonDBFunctions->getidToValue('supplier_name','id',$row->supplier,'pharma_suppliers');				
				$orderInfo[$i][5]= $row->remarks;
				// $orderInfo[$i][6]= $this->commonDBFunctions->getidToValue('id','pono',$row->id,'pharma_recievings');

				$condition[0] = "pono = '".$row->id."'";
				$condition[1] = "status = 0";

				$orderInfo[$i][6]= $this->commonDBFunctions->getidToValue_multiple('id',$condition,'pharma_recievings');

				$orderInfo[$i][7]= $row->net_total;
				$orderInfo[$i][8]= $row->cancelled_by;
				$orderInfo[$i][9]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');
				$orderInfo[$i][10]= $row->cancellation_date;
				$orderInfo[$i][11]= $row->cancellation_details;
				$orderInfo[$i][12]= $row->status;
				$orderInfo[$i][13]= $this->commonDBFunctions->getidToValue('email','id',$row->supplier,'pharma_suppliers');
				$orderInfo[$i][14]= $row->email_status;
				$orderInfo[$i][15]= $row->send_emails;


				$i++;

	}
}else{

                $orderInfo[$i][0]= $i+1;
				$orderInfo[$i][1]= $row->id;
				
				$orderInfo[$i][2]= $row->date;
				$orderInfo[$i][3]= $row->supplier;
				$orderInfo[$i][4]= $this->commonDBFunctions->getidToValue('supplier_name','id',$row->supplier,'pharma_suppliers');				
				$orderInfo[$i][5]= $row->remarks;
				// $orderInfo[$i][6]= $this->commonDBFunctions->getidToValue('id','pono',$row->id,'pharma_recievings');

				$condition[0] = "pono = '".$row->id."'";
				$condition[1] = "status = 0";

				$orderInfo[$i][6]= $this->commonDBFunctions->getidToValue_multiple('id',$condition,'pharma_recievings');
				
				$orderInfo[$i][7]= $row->net_total;
				$orderInfo[$i][8]= $row->cancelled_by;
				$orderInfo[$i][9]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');
				$orderInfo[$i][10]= $row->cancellation_date;
				$orderInfo[$i][11]= $row->cancellation_details;
				$orderInfo[$i][12]= $row->status; 
				$orderInfo[$i][13]= $this->commonDBFunctions->getidToValue('email','id',$row->supplier,'pharma_suppliers');
				$orderInfo[$i][14]= $row->email_status;
				$orderInfo[$i][15]= $row->send_emails;


				$i++;              
 
}
			
			
			}
		}

		return $orderInfo;
	
	}
	public function searchPurchaseOrderItems($criteria){
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		
		$this->db->where('status','0');
		$query=$this->db->get('pharma_purchase_order_items');
	   
		$orderInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$orderInfo[$i][0]= $i+1;
				$orderInfo[$i][1]= $row->order_id;
				$orderInfo[$i][2]= $row->date;				
				$orderInfo[$i][3]= $row->item_type;
				$orderInfo[$i][4]= $row->quantity;				
				$orderInfo[$i][5]= $row->item_id;
				$orderInfo[$i][6]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');;
				$orderInfo[$i][7]= $row->tablets_per_pack;
				$orderInfo[$i][8]= $row->buyp;
				$orderInfo[$i][9]= $row->foc;
				$orderInfo[$i][10]= $row->total_amount;
				
				
				$i++;
			
			}
		}
		
		return $orderInfo;
	
	}
	function delete_purchase_order($id){

		$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_purchase_orders');

        if(!empty($old_update)){

	           $update_history = $this->session->userdata('user_id')."|DELETE PURCHASE ORDER|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
 
               $update_history = $this->session->userdata('user_id')."|DELETE PURCHASE ORDER|". date("d-m-Y H:i a");
		}

		$date=date("Y-m-d H:i");	

		$cancellation_details=$this->input->post('cancellation_details');
	
		
		$condition				= array('id' => $id);
		
		$data=array( 'status'   	        =>1,
                     'cancelled_by'   	    =>$this->session->userdata('user_id'),
                     'cancellation_details' =>$cancellation_details,
                     'cancellation_date'    =>$date,
                     'update_history'       =>$update_history,
			       );
		
		$result=$this->db->update('pharma_purchase_orders', $data,$condition);
		
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function delete_order_items($order_id){
	
		
			$condition				= array('order_id' => $order_id);
		
		$data=array('status'   	=>1);
		
		$result=$this->db->update('pharma_purchase_order_items', $data,$condition);
		
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function searchItemHistory($criteria){



		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		
		$this->db->where('status','0');
		$this->db->order_by("id", "desc"); 
		$query=$this->db->get('hcare_pharma_recievings_items');
	   
		$orderInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$orderInfo[$i][0]= $i+1;
				$orderInfo[$i][1]= $row->bill_id;
				$orderInfo[$i][6]= $this->commonDBFunctions->getidToValue('bill_no','id',$row->bill_id,'hcare_pharma_recievings');;
				$orderInfo[$i][2]= $row->batch_number;				
				$orderInfo[$i][3]= $row->expiry;
				// pack===========
				$orderInfo[$i][4]= $row->quantity;				
				$orderInfo[$i][5]= $row->foc;
				$orderInfo[$i][7]= $row->buyp;
				$orderInfo[$i][8]= $row->sellp;
				$orderInfo[$i][9]= $row->gst_per;
				$orderInfo[$i][10]= $row->sgst_amt;
				$orderInfo[$i][11]= $row->cgst_amt;
				$orderInfo[$i][12]= $row->total;
				$orderInfo[$i][13]= $row->bill_date;
				$orderInfo[$i][14]= $row->item_type;
				$orderInfo[$i][15]= $row->gst_amt;
				$orderInfo[$i][16]= $this->commonDBFunctions->getidToValue('supplier','id',$row->bill_id,'hcare_pharma_recievings');;
				$orderInfo[$i][17]= $this->commonDBFunctions->getidToValue('supplier_name','id',$orderInfo[$i][16],'pharma_suppliers');;






				
				
				$i++;
			
			}
		}
		// var_dump($orderInfo);
		
		return $orderInfo;
	
		
			
	}


}
?>
