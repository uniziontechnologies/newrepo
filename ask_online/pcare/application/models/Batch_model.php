<?php



class Batch_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function create($batchInfo,$from = null){
	
	
	 date_default_timezone_set('Asia/Kolkata');
	 $update_history = $this->session->userdata('user_id')."|".$from."|". date("d-m-Y H:i a");
	
	
	       $data                   =array('brand_id'       => $batchInfo['brand_id'],
	                                    'batch_number'  	=> $batchInfo['batch_number'],
	                                   'expiry_date'  	=> date('Y-m-d',strtotime($batchInfo['expiry_date'])),	
	                                   // 'expiry_date'  	=> $batchInfo['expiry_date'],                                       
		                                'batch_stock'   => $batchInfo['batch_stock'],
		                                'price_type'   	=> $batchInfo['price_type'],		
		                                'sellp'         => $batchInfo['sellp'],
		                                'buyp'   	    => $batchInfo['buyp'],
		                                'supplier_id'  	=> $batchInfo['supplier_id'],
		                                'description'   => $batchInfo['description'],
		                                'gst_per'       => $batchInfo['gst_per'],
		                                'sgst_per'      => $batchInfo['sgst_per'],
		                                'cgst_per'      => $batchInfo['cgst_per'],
		                                'gst_amt'       => $batchInfo['gst_amt'],
		                                'sgst_amt'      => $batchInfo['sgst_amt'],
		                                'cgst_amt'      => $batchInfo['cgst_amt'],
		                                'gst_id'        => $batchInfo['gst_id'],
		                                'status'   	    => 0,
										'update_history'   => $update_history
		                          );
		
		$batchInfo['update_history']=$update_history;

		if(!empty($batchInfo['branch_id'])){
			$data['branch_id']  = $batchInfo['branch_id'];
		}
		if(!empty($batchInfo['purchase_id'])){
			$data['purchase_id']  = $batchInfo['purchase_id'];
		}
		if(!empty($batchInfo['rec_id'])){
			$data['purchase_id']  = $batchInfo[13];
		}
	
		$result=$this->db->insert('pharma_batch', $data);
		
		if($result) {
			return  $this->db->insert_id();
		}else{
			return  0;
		}
	}

    function update($id,$batchInfo){
	
	 //updation history
			$user_id=$this->session->userdata('user_id');
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|"."MANUAL_EDIT"."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		$condition				= array('id' => $id);
		$data                   =array('brand_id'       => $batchInfo['brand_id'],
	                                    'batch_number'  	=> $batchInfo['batch_number'],
	                                    'expiry_date'  	=> date('Y-m-d',strtotime($batchInfo['expiry_date'])),	
	                                   // 'expiry_date'  	=> $batchInfo['expiry_date'],	                                       
		                                'batch_stock'   => $batchInfo['batch_stock'],
		                                'price_type'   	=> $batchInfo['price_type'],		
		                                'sellp'         => $batchInfo['sellp'],
		                                'buyp'   	=> $batchInfo['buyp'],
		                                'supplier_id'  	=> $batchInfo['supplier_id'],
		                                'description'   => $batchInfo['description'],
		                                'gst_per'       => $batchInfo['gst_per'],
		                                'sgst_per'      => $batchInfo['sgst_per'],
		                                'cgst_per'      => $batchInfo['cgst_per'],
                                        'gst_id'        => $batchInfo['gst_id'],
		                                'status'   	=> 0,
						'update_history'   	=> $update_history
						
		                          );
		
		$result=$this->db->update('pharma_batch', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

	function update_stock($id,$stock,$from = null){
	
	
	 //updation history
			$user_id=$this->session->userdata('user_id');
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|".$from."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	
		$condition  = array('id' => $id);
		
		if($stock < 0){
		
		   $stock = 0;
		}
		
		$data       =array('batch_stock' => $stock,'update_history' => $update_history);
		
		$result=$this->db->update('pharma_batch',$data,$condition);
		//echo $this->db->last_query();
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

	function getbatch_count($criteria){
	
		$this->db->select("sum(batch_stock) as batch_stock");
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		
		$query=$this->db->get('pharma_batch');
		//echo $this->db->last_query();
		$row = $query->row(5);
		if($row->batch_stock == null) return 0;
		return $row->batch_stock;
	
	}
	function getMainStock($brand_id){
	
	  $criteria[0]="brand_id = ".$brand_id;
	  $criteria[1]="(branch_id = 0 or branch_id ='' or branch_id is NULL)";
	  $criteria[2]="status = 0";
	  $criteria[3]="batch_stock >0";
			
	  $brand_count=$this->getbatch_count($criteria);
	  
	  return $brand_count;
	}
	function getAllBranchStock($brand_id){
	
	  $criteria[0]="brand_id = ".$brand_id;
	  $criteria[1]="(branch_id > 0 )";
	  $criteria[2]="status = 0";
	  $criteria[3]="batch_stock >0";
			
          $branch_stock=$this->getbatch_count($criteria);
	  
	  return $branch_stock;
	}

    function countBatch($search = null){
	
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');
		 $query = $this->db->get('pharma_batch');
		 
		 return $query->num_rows();
	
	}

	function getBatch($search = null,$limit=null,$offset=null,$order_by=null,$order=null,$from_path=null)
    {  
		$options = array();
		$i=0;
		
		if(!empty($limit)){

            $limit=explode(",",$limit);

	   }
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');
		$this->db->order_by("batch_stock", "desc");
	    
        if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_batch');
		// echo $this->db->last_query();
		//echo $query->result();
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand_id;
			$options[$i][2] = $row->batch_number;


			$options[$i][3] = $row->expiry_date ;


            //              $date_obj = DateTime::createFromFormat('Y-m-d', $row->expiry_date);
		          //   	$output = $date_obj->format('d-m-Y');

				        // var_dump($options[$i][3]);

			            //$options[$i][3] = $output;

			$options[$i][4] = $row->batch_stock;
			$options[$i][5] = $row->price_type;
			$options[$i][6] = $row->sellp  ;
			$options[$i][7] = $row->buyp;
			$options[$i][8] = $row->supplier_id;
			$options[$i][9]=  $this->commonDBFunctions->getidToValue('supplier_name','id',$row->supplier_id,'pharma_suppliers');
			$options[$i][10] = $row->description;
			$options[$i][11] = $row->status;
			$options[$i][12] = $row->branch_id;
			$options[$i][13]=  $this->commonDBFunctions->getidToValue('branch_name','id',$row->branch_id,'pharma_branch');
			$options[$i][14]=  $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'pharma_brand');
			$options[$i][15] = $row->purchase_id;
			$options[$i][16]=  $this->commonDBFunctions->getidToValue('bill_no','id',$row->purchase_id,'pharma_recievings');
			$options[$i][27]=  $this->commonDBFunctions->getidToValue('bill_date','id',$row->purchase_id,'pharma_recievings');

			$options[$i][17]= $row->gst_id;
			
			$options[$i][18]= $row->gst_per;
			$gst_calculated = to_currency($row->buyp*$row->gst_per/100);
            $options[$i][21] = $gst_calculated;
			$options[$i][19]= $row->sgst_per;
			$options[$i][22] =to_currency($gst_calculated/2);
			$options[$i][20]= $row->cgst_per;
            $options[$i][23] = to_currency($gst_calculated/2);
			
			// for batchwise report
			
		
			$options[$i][24] = $gst_calculated*$row->batch_stock;
		    $options[$i][25] = to_currency(($gst_calculated/2)*$row->batch_stock);
		    $options[$i][26] = to_currency(($gst_calculated/2)*$row->batch_stock);
			
			$options[$i][28]=$this->commonDBFunctions->getidToValue('branch_name','id',$row->branch_id,'pharma_branch');

			$options[$i][29]=$this->commonDBFunctions->getidToValue('manufacturer','id',$row->brand_id,'pharma_brand');


			$options[$i][30]= $row->batch_status;


		if (!empty($from_path) && $from_path == "FROM_MANAGE_BATCH") {
				

			if ($row->batch_status == "M") {

				// var_dump($row->batch_number);exit();

				$new_criteria1 = array();

				$og_purchase_id = $row->purchase_id;
				$og_brand_id = $row->brand_id;
				$og_batch_number = $row->batch_number;

                // $new_criteria1[0] = "movement_id = ".$row->purchase_id;
				// $new_criteria1[1] = "brand_id =".$row->brand_id ;
				// $new_criteria1[2] = "batch_no = '".$row->batch_number."'";
		
                // $batch_id_movement = $this->commonDBFunctions->getidToValue_multiple('batch_id',$new_criteria1,'hcare_pharma_movement_items');

				$c=0;

                do{

	                $new_criteria1[0] = "movement_id = ".$og_purchase_id;
					$new_criteria1[1] = "brand_id =".$og_brand_id ;
					$new_criteria1[2] = "batch_no = '".$og_batch_number."'";
			
	                $batch_id_movement = $this->commonDBFunctions->getidToValue_multiple('batch_id',$new_criteria1,'hcare_pharma_movement_items');

	                $purchase_id_movement_id = $this->commonDBFunctions->getidToValue('purchase_id','id',$batch_id_movement,'pharma_batch');

	                $batch_id_movement_type = $this->commonDBFunctions->getidToValue('batch_status','id',$batch_id_movement,'pharma_batch');


	                $og_purchase_id = $purchase_id_movement_id;

	                // var_dump($c." || ".$og_batch_number." || ".$batch_id_movement_type);
	               

	                // if ($c==10) {
	                // 	exit();
	                // }
	                 $c++;
	                

                }
                while ( !empty($batch_id_movement_type) && ($batch_id_movement_type != "P") );


                if (!empty($batch_id_movement)) {

					$options[$i][31]=$batch_id_movement;

					$options[$i][32]=$this->commonDBFunctions->getidToValue('purchase_id','id',$options[$i][31],'hcare_pharma_batch');

					$options[$i][33]=$this->commonDBFunctions->getidToValue('bill_no','id',$options[$i][32],'hcare_pharma_recievings');

					$options[$i][34]=$this->commonDBFunctions->getidToValue('bill_date','id',$options[$i][32],'hcare_pharma_recievings');


                }

                
			}
			else if($row->batch_status == "P"){
				$options[$i][31]="";
				$options[$i][32]="";
				$options[$i][33]="";
				$options[$i][34]="";
			}
			else{

				$new_criteria1 = array();

                $new_criteria1[0] = "movement_id = ".$row->purchase_id;
				$new_criteria1[1] = "brand_id =".$row->brand_id ;
				$new_criteria1[2] = "batch_no = '".$row->batch_number."'";
		
                $batch_id_movement = $this->commonDBFunctions->getidToValue_multiple('batch_id',$new_criteria1,'hcare_pharma_movement_items');

                if (!empty($batch_id_movement)) {

					$options[$i][31]=$batch_id_movement;

					$options[$i][32]=$this->commonDBFunctions->getidToValue('purchase_id','id',$options[$i][31],'hcare_pharma_batch');

					$options[$i][33]=$this->commonDBFunctions->getidToValue('bill_no','id',$options[$i][32],'hcare_pharma_recievings');

					$options[$i][34]=$this->commonDBFunctions->getidToValue('bill_date','id',$options[$i][32],'hcare_pharma_recievings');


                }
                else{

					$new_criteria1 = array();

	                $new_criteria1[0] = "bill_id = ".$row->purchase_id;
					$new_criteria1[1] = "item_id =".$row->brand_id ;
					$new_criteria1[2] = "batch_number = '".$row->batch_number."'";
			
	                $batch_id_purchase = $this->commonDBFunctions->getidToValue_multiple('batch_id',$new_criteria1,'hcare_pharma_recievings_items');

		                if ($batch_id_purchase == $row->id) {
		                	
						$options[$i][31]=$batch_id_purchase;

						$options[$i][32]=$this->commonDBFunctions->getidToValue('purchase_id','id',$options[$i][31],'hcare_pharma_batch');

						$options[$i][33]=$this->commonDBFunctions->getidToValue('bill_no','id',$options[$i][32],'hcare_pharma_recievings');

						$options[$i][34]=$this->commonDBFunctions->getidToValue('bill_date','id',$options[$i][32],'hcare_pharma_recievings');

	                }


                }



			}

		}
		else{

				$options[$i][31]="";
				$options[$i][32]="";
				$options[$i][33]="";
				$options[$i][34]="";
			
		}

			
			$i++;
		}
		return $options;
		
    }
	function update_batch_stock($id,$stock,$update_loc){
	
		$condition= array('id' => $id);
		
		if($stock < 0){
		  $stock=0;
		}
		
			
		  $data['batch_stock']	=$stock;
		  
		  //updation history
			$user_id=$this->session->userdata('user_id');
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|".$update_loc."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|".$update_loc."|". date("d-m-Y H:i a");
		       }
		 

		$result=$this->db->update('pharma_batch', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

	function delete($id = null,$brand_id=null,$cancell_details=null){
	
		if(!empty($id)){
			$condition				= array('id' => $id);
		}
		if(!empty($brand_id)){
			$condition				= array('brand_id' => $brand_id);
		}
		
		$data=array('status'   	=>1,'cancell_details' =>$cancell_details);
		
		$result=$this->db->update('pharma_batch', $data,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	function delete_current_batch_items($purchase_id = null,$id = null,$stock = null,$p_m_status = null){
	  

	  if(!empty($purchase_id)){
		  $condition	= array('purchase_id' => $purchase_id,
		                        'batch_status' => $p_m_status  );
		  $data = array( 'status' => 1);
	  }

      if(!empty($id)){

      	  //updation history
			$user_id=$this->session->userdata('user_id');
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');
			if(!empty($old_update)){

	                $update_history = $user_id."|"."MOVEMENT_CANCEL"."|". date("d-m-Y H:i a")."&&".$old_update;
	         }else{
	                $update_history = $user_id."|"."MOVEMENT_CANCEL"."|". date("d-m-Y H:i a");
		     }

      	  $condition	= array('id' => $id);
		  $data = array( 'batch_stock' =>$stock,'update_history' =>$update_history,'status' => 1);

      }

		
		$result=$this->db->update('pharma_batch', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	function stock_adjustment($adjustInfo,$status=null){
	
		
		$this->brand_id 	= $adjustInfo[0];
	    $this->batch_id   	= $adjustInfo[1];
	    $this->date  		= $adjustInfo[2];
		$this->time   		= $adjustInfo[3];
		$this->pack   		= $adjustInfo[4];		
		$this->strips 		= $adjustInfo[5];
		$this->tablets   	= $adjustInfo[6];
		$this->brand_stock  = $adjustInfo[7];
		$this->batch_stock  = $adjustInfo[8];
		$this->branch_stock  = $adjustInfo[12];
		$this->description  = $adjustInfo[9];
		$this->user_id   	= $adjustInfo[10];
		$this->branch_id   	= $adjustInfo[11];
		$this->consume_status =$status;
		
		$result=$this->db->insert('pharma_batch_stock_adjustment', $this);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	function batchExist($batchInfo = null,$id = null,$purchase_id= null){		
		
		if(!empty($id) && $from == ""){
		
			$batch_number = $this->input->post('batch_number');
			
			if(!empty($batch_number)){
			
			  $this->db->where('batch_number',$batch_number);
		        }
			$this->db->where('id',$id);
		}
		
		/*if(!empty($id) && $from == "MOVEMENT"){
		
		   $this->db->not_like('id',$id);
		}*/
		if(!empty($batchInfo)) {
		
			$brand_id = $batchInfo[0];
			$batch_number = $batchInfo[1];
			$expiry_date = date("Y-m-d",strtotime($batchInfo[2]));
			
			//if($batchInfo[14] == "RECIEVINGS"){
				//$this->branch_id =0;
			//}
			
			$this->db->where('brand_id',$brand_id);
			$this->db->where('batch_number',$batch_number);
			$this->db->where('expiry_date',$expiry_date);
			
			/*if($batchInfo[3] > 0 ){
				$this->db->where('supplier_id',$batchInfo[3]);
			}*/
		}
		if(!empty($purchase_id)){
		$this->db->where('purchase_id',$purchase_id);
		}
		
		$this->db->where('status','0');
                $query = $this->db->get('pharma_batch');
		//echo $this->db->last_query();
		return $query->row_array();
	}

	function checkbatchExist($batchInfo = null,$purchase_id= null){		
		
		if(!empty($batchInfo)) {
		
			$brand_id = $batchInfo['brand_id'];
			$batch_number = $batchInfo['batch_number'];
			$expiry_date = date("Y-m-d",strtotime($batchInfo['expiry']));
			
			$this->db->where('brand_id',$brand_id);
			$this->db->where('batch_number',$batch_number);
			$this->db->where('expiry_date',$expiry_date);
			
			/*if($batchInfo[3] > 0 ){
				$this->db->where('supplier_id',$batchInfo[3]);
			}*/
		}
		if(!empty($purchase_id)){
		$this->db->where('purchase_id',$purchase_id);
		}
		
		$this->db->where('status','0');
                $query = $this->db->get('pharma_batch');
		//echo $this->db->last_query();
		return $query->row_array();
	}

	public function checkBatchChange($purchase_id,$brand_id,$batch_no,$expiry,$batchid=null){
	
		$this->db->select('batch_stock');

		$this->db->where('purchase_id',$purchase_id);
		$this->db->where('brand_id',$brand_id);
		$this->db->where('batch_number',$batch_no);
		$this->db->where('expiry_date',$expiry);
		$this->db->where('id',$batchid);
		$this->db->where('status','0');

		$query = $this->db->get('pharma_batch');

		$row= $query->row_array();
		if(!empty($row)) {
		
					 
			return  $row['batch_stock'];
		}else return '';
		
	
	}

	function getadjustmentDetails($search){
	
		$options = array();
		$i=0;
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
		 $query = $this->db->get('pharma_batch_stock_adjustment');
		 
		 foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand_id;
			$options[$i][2] = $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'pharma_brand');;
			$options[$i][3] = $row->batch_id;
			$options[$i][4] = $this->commonDBFunctions->getidToValue('batch_number','id',$row->batch_id,'pharma_batch');
			$options[$i][5] = $this->commonDBFunctions->getidToValue('expiry_date','id',$row->batch_id,'pharma_batch');		
			$options[$i][6] = $row->date ;
			$options[$i][7] = $row->time;
			$options[$i][8] = $row->pack;
			$options[$i][9] = $row->strips;
			$options[$i][10] = $row->tablets;
			$options[$i][11] = $row->brand_stock;
			$options[$i][12] = $row->batch_stock;
			$options[$i][13] = $row->description;
			$options[$i][14] = $row->user_id;
			$options[$i][15] =  $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
			$options[$i][16] = $row->branch_id;
			$options[$i][17] =  $this->commonDBFunctions->getidToValue('branch_name','id',$row->branch_id,'pharma_branch');


			$i++;
		}
		
		return $options;
	}

	function expiredStock(){

		$todate=date("Y-m-d");

        $sql="select sum(batch_stock) as sum from hcare_pharma_batch where expiry_date <= '$todate' and batch_stock >0 and status = 0";
        
        
		$query = $this->db->query($sql);
        
		$expired_stock=$query->row()->sum;

        return $expired_stock;
    	

	}
	
		function Update_p_m_Status($id,$status=null){
	
	
		$condition  = array('id' => $id);
	
		$data       =array('batch_status' => $status);
		
		$result=$this->db->update('pharma_batch',$data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

	function create_batch_branch($brand_id,$batch,$expiry_date,$branch_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per){

		$sql = "INSERT INTO `hcare_pharma_batch`(`brand_id`, `batch_number`, `expiry_date`, `batch_stock`, `sellp`, `buyp`, `supplier_id`, `status`, `branch_id`, `entry_date`, `update_history`, `price_type`, `gst_id`, `gst_per`, `gst_amt`, `sgst_amt`, `cgst_amt`, `sgst_per`, `cgst_per`) VALUES ('".$brand_id."','".$batch."','".$expiry_date."','".$branch_stock."','".$sellp."','".$buyp."','".$supplier_id."','0','1','".date('Y-m-d')."','".$update_history."','NOS','".$gst_id."','".$gst_per."','".$gst_amt."','".$sgst_amt."','".$cgst_amt."','".$sgst_per."','".$cgst_per."')";

		$query = $this->db->query($sql);

		return $this->db->insert_id();


	}
	function create_batch_brand($brand_id,$batch,$expiry_date,$brand_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per){

		$sql = "INSERT INTO `hcare_pharma_batch`(`brand_id`, `batch_number`, `expiry_date`, `batch_stock`, `sellp`, `buyp`, `supplier_id`, `status`, `branch_id`, `entry_date`, `update_history`, `price_type`, `gst_id`, `gst_per`, `gst_amt`, `sgst_amt`, `cgst_amt`, `sgst_per`, `cgst_per`) VALUES ('".$brand_id."','".$batch."','".$expiry_date."','".$brand_stock."','".$sellp."','".$buyp."','".$supplier_id."','0','0','".date('Y-m-d')."','".$update_history."','NOS','".$gst_id."','".$gst_per."','".$gst_amt."','".$sgst_amt."','".$cgst_amt."','".$sgst_per."','".$cgst_per."')";

		$query = $this->db->query($sql);

		return $this->db->insert_id();


	}
    function update_batches($brand_id,$batch_id,$batch,$expiry_date,$batch_stock,$sellp,$buyp){
	
	 	//updation history
		$user_id=$this->session->userdata('user_id');
		date_default_timezone_set('Asia/Kolkata');
		$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');

		if(!empty($old_update)){
	   
	        $update_history = $user_id."|"."EXCEL_UPDATE"."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	    }else{

	        $update_history = $user_id."|". date("d-m-Y H:i a");

		 }
		$condition				= array('id' => $batch_id);

		$data                   = array('batch_number'  => $batch,
	                                    'expiry_date'  	=> $expiry_date,	
		                                'batch_stock'   => $batch_stock,		
		                                'sellp'         => $sellp,
		                                'buyp'   	    => $buyp,
										'update_history'=> $update_history
						
		                           );
		
		$result=$this->db->update('pharma_batch', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}

	}


 function get_consumeCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_batch_stock_adjustment");
        $count = $this->db->count_all_results();

        return $count;
		
    }


	function update_batch_stock_clear($id,$stock,$update_loc){
	
		$condition= array('id' => $id);
		
		if($stock < 0){
		  $stock=0;
		}
		
			
		  $data['batch_stock']	=$stock;
		  $data['status']	=1;
		  
		  //updation history
			$user_id=$this->session->userdata('user_id');
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_batch');
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|".$update_loc."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|".$update_loc."|". date("d-m-Y H:i a");
		       }
		       $data['update_history']	=$update_history;
		 

		$result=$this->db->update('pharma_batch', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}

}


?>