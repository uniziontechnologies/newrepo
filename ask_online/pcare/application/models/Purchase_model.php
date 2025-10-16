<?php
class Purchase_model extends CI_Model {

   
	
	public $id;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function total_amount_sold($criteria){
	
		$this->db->select_sum('total');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		
		$query = $this->db->get('pharma_recievings_items');
		
		 $row = $query->row(); 
		 
		   return $row->total;
	}
	public function total_quantity_sold($criteria,$item_type){
	
		$this->db->select_sum('quantity');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->where('item_type',$item_type);
		$query = $this->db->get('pharma_recievings_items');
		
		$row = $query->row(); 
		 
		   return $row->quantity;
	}
      public function searchdistinct_item($criteria){
	
		
			$this->db->distinct();
			$this->db->select('item_id');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		
		$query=$this->db->get('pharma_recievings_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i][0]= $row->item_id ;
				$billInfo[$i][1]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');;
				
				
				$i++;
			}
		}
		return $billInfo;
	} 
	  
	function addPurchase($balance,$status,$auth_user_id=null){
	
		$date=$this->input->post('date');
		$bill_date=$this->input->post('bill_date');
      

        /*..... gst amount and taxable amount .....*/		
		if($balance > 0) $credit_status="CREDIT";
		else $credit_status="";
		
		if($status ==2) $from ="DRAFT BILL";
		else $from="ADD BILL";
		 date_default_timezone_set('Asia/Kolkata');
	         $update_history = $this->session->userdata('user_id')."|".$from."|". date("d-m-Y H:i a");
			 
			 $purchase_amt=$this->input->post('purchase_amt');
			 if(empty($purchase_amt)) $purchase_amt=0;
			 
			 $return_amount=$this->input->post('return_amt');
			 if(empty($return_amount)) $return_amount=0;
			 
			/*..... total_gst_purchase_amt .....*/
			 $gst=$this->input->post('gst');
			 if(empty($gst)) $gst=0;

			 $total_gst_purchase_amt=$purchase_amt+$gst;

			 /*..... checque_no ......*/
			 $checque_no=$this->input->post('checque_no');
			 if(empty($checque_no)) $checque_no=0;

			 /*..... checque_amt .....*/
			 $checque_amt=$this->input->post('checque_amt');
			 if(empty($checque_amt)) $checque_amt=0;

			 /*..... card_amt .....*/
			 $card_amt=$this->input->post('card_amt');
			 if(empty($card_amt)) $card_amt=0;
			  /*..... upi_amt .....*/
			 $upi_amt=$this->input->post('upi_amt');
			 if(empty($upi_amt)) $upi_amt=0;

			 /*..... roundstatus .....*/
			 $roundstatus=$this->input->post('roundstatus');
			 if(empty($roundstatus)) $roundstatus=0;

			 /*..... round_amt .....*/
			 $round_amt=$this->input->post('round_amt');
			 if(empty($round_amt)) $round_amt=0;

			 /*..... sanctioned_by,auth_remarks .....*/
			 $sanctioned_by=$this->input->post('sanc_by_hidden');
			 $auth_remarks=$this->input->post('auth_remarks_hidden');
			 if(empty($sanctioned_by)) $sanctioned_by='';
			 if(empty($auth_remarks)) $auth_remarks='';

			 /*..... sanctioned_by,auth_remarks .....*/
             if(empty($auth_user_id)) $auth_user_id=0;
             
             $blance=$round_net_amt-($card_amt+$amount_paid+$upi_amt);
		
		$data= array ('pono' 	          => $this->input->post('pono'),
	                  'bill_date'  	 	  => date("Y-m-d",strtotime($bill_date)),
		              'bill_no'      	  => $this->input->post('bill_no'),
	                  'entry_date'  	  => date("Y-m-d h:i:s",strtotime($date)),
	                  'supplier'          => $this->input->post('supplier'),
		              'purchase_amt'      =>$purchase_amt,
					  'return_amount'      =>  $return_amount,
		              'gst'               =>$this->input->post('gst'),
		              'cgst'  	          =>$this->input->post('cgst'),
					  'sgst'  	          =>$this->input->post('sgst'),
					  'freight' 	      => $this->input->post('frieght'),
					  'bill_total'        =>$this->input->post('bill_total'),
		              'discount_type'     =>$this->input->post('bill_disc_type'),
		              'discount_value'    =>$this->input->post('bill_disc_value'),
					  'discount_amt' 	  => $this->input->post('disc_amt'),
	                  'net_total_before'  => $this->input->post('net_total'),
	                  'net_total'         => $this->input->post('round_net_amt'),
	                  'rounded_status'    => $roundstatus,
	                  'round_amt'         => $round_amt,
		              'payment_mode'      => $this->input->post('payment_type'),
		              'checque_no'   	  =>$checque_no,
		              'checque_amt'       =>$checque_amt,
		              'card_amt'     	  =>$card_amt,
		              'amount_paid'   	  =>$this->input->post('amount_paid'),
		              'balance'      	  => $balance,
		              'total_gst_purchase_amt' => $total_gst_purchase_amt,
			          'credit_status'         => $credit_status,
	                  'remarks'           => $this->input->post('remarks'),
			          'purchase_mode'     => $this->input->post('purchase_mode_selected'),
					  'status'            => $status,
		              'user_id'  		  => $this->session->userdata('user_id'),
		              'sanctioned_by'  	  => $sanctioned_by,
		              'auth_remarks'  	  => $auth_remarks,
		              'auth_user_id'  	  => $auth_user_id,
			          'update_history'    =>$update_history,
			          'upi_amt'			=>$upi_amt
			          // 'igst'              =>$this->input->post('igst'),
			      );
			
		
		$result=$this->db->insert('pharma_recievings', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	}
    
    function UpdatePurchase($balance,$status,$auth_user_id=null){

    	$purchase_id=$this->input->post('purchase_id');
	    $condition				= array('id' => $purchase_id);


        $date=$this->input->post('date');
		$bill_date=$this->input->post('bill_date');
      

        /*..... gst amount and taxable amount .....*/		
		if($balance > 0) $credit_status="CREDIT";
		else $credit_status="";
		
		if($status ==2) $from ="UPDATE DRAFT BILL";
		else $from="UPDATE BILL";
		 date_default_timezone_set('Asia/Kolkata');

        $old_update=$this->commonDBFunctions->getidToValue('update_history','id',$purchase_id,'pharma_recievings');
        if(!empty($old_update)){

	           $update_history = $this->session->userdata('user_id')."|".$from."|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
 
               $update_history = $this->session->userdata('user_id')."|".$from."|". date("d-m-Y H:i a");
		}	 
			 $purchase_amt=$this->input->post('purchase_amt');
			 if(empty($purchase_amt)) $purchase_amt=0;
			 
			 $return_amount=$this->input->post('return_amount');
			 if(empty($return_amount)) $return_amount=0;
			 
			/*..... total_gst_purchase_amt .....*/
			 $gst=$this->input->post('gst');
			 if(empty($gst)) $gst=0;

			 $total_gst_purchase_amt=$purchase_amt+$gst;

			 /*..... checque_no ......*/
			 $checque_no=$this->input->post('checque_no');
			 if(empty($checque_no)) $checque_no=0;

			 /*..... checque_amt .....*/
			 $checque_amt=$this->input->post('checque_amt');
			 if(empty($checque_amt)) $checque_amt=0;

			 /*..... card_amt .....*/
			 $card_amt=$this->input->post('card_amt');
			 if(empty($card_amt)) $card_amt=0;

			 /*..... upi_amt .....*/
			 $upi_amt=$this->input->post('upi_amt');
			 if(empty($upi_amt)) $upi_amt=0;

			 /*..... roundstatus .....*/
			 $roundstatus=$this->input->post('roundstatus');
			 if(empty($roundstatus)) $roundstatus=0;

			 /*..... round_amt .....*/
			 $round_amt=$this->input->post('round_amt');
			 if(empty($round_amt)) $round_amt=0;

			 /*..... sanctioned_by,auth_remarks .....*/
			 $sanctioned_by=$this->input->post('sanc_by_hidden');
			 $auth_remarks=$this->input->post('auth_remarks_hidden');
			 if(empty($sanctioned_by)) $sanctioned_by='';
			 if(empty($auth_remarks)) $auth_remarks='';

             /*..... sanctioned_by,auth_remarks .....*/
             if(empty($auth_user_id)) $auth_user_id=0;
              $payment_mode=$this->input->post('payment_type');
              $round_net_amt=$this->input->post('round_net_amt');
              $amount_paid=$this->input->post('amount_paid');
              if($payment_mode=="CREDIT CARD"){
                 $blance=$round_net_amt-($card_amt+$amount_paid);
              }else if($payment_mode=="CHECQUE"){
              	$blance=$round_net_amt-($checque_amt+$amount_paid);
              }else  if($payment_mode=="UPI"){
                 $blance=$round_net_amt-($upi_amt+$amount_paid);
              }else{
              	$blance=$balance;
              }
              
              
		
		$data= array ('pono' 	          => $this->input->post('pono'),
	                  'bill_date'  	 	  => date("Y-m-d",strtotime($bill_date)),
		              'bill_no'      	  => $this->input->post('bill_no'),
	                  'entry_date'  	  => date("Y-m-d h:i:s",strtotime($date)),
	                  'supplier'          => $this->input->post('supplier'),
		              'purchase_amt'      =>$purchase_amt,
					  'return_amount'      =>  $return_amount,
		              'gst'               =>$this->input->post('gst'),
		              'cgst'  	          =>$this->input->post('cgst'),
					  'sgst'  	          =>$this->input->post('sgst'),
					  'freight' 	      => $this->input->post('frieght'),
					  'bill_total'        =>$this->input->post('bill_total'),
		              'discount_type'     =>$this->input->post('bill_disc_type'),
		              'discount_value'    =>$this->input->post('bill_disc_value'),
					  'discount_amt' 	  => $this->input->post('disc_amt'),
	                  'net_total_before'  => $this->input->post('net_total'),
	                  'net_total'         => $this->input->post('round_net_amt'),
	                  'rounded_status'    => $roundstatus,
	                  'round_amt'         => $round_amt,
		              'payment_mode'      => $this->input->post('payment_type'),
		              'checque_no'   	  =>$checque_no,
		              'checque_amt'       =>$checque_amt,
		              'card_amt'     	  =>$card_amt,
		              'amount_paid'   	  =>$this->input->post('amount_paid'),
		              'balance'      	  => $blance,
		              'total_gst_purchase_amt' => $total_gst_purchase_amt,
			          'credit_status'         => $credit_status,
	                  'remarks'           => $this->input->post('remarks'),
			          'purchase_mode'     => $this->input->post('purchase_mode_selected'),
					  'status'            => $status,
		              'user_id'  		  => $this->session->userdata('user_id'),
		              'sanctioned_by'  	  => $sanctioned_by,
		              'auth_remarks'  	  => $auth_remarks,
		              'auth_user_id'  	  => $auth_user_id,
			          'update_history'        =>$update_history,
			          'upi_amt'				=>$upi_amt
			          // 'igst'              =>$this->input->post('igst'),
			      );
			
		
		$result=$this->db->update('pharma_recievings', $data,$condition);
		
		if($result) {
			return $purchase_id;
		}else{
			return  $this->lang->line('add_failed');
		}

    }

	function addPurchaseItems($item,$buyp_foc,$status,$bill_id){
	 
		$date=$this->input->post('bill_date');
		/*.... Vat .....*/
		if(empty($item[17])){ 

		        $vat_inc=0;
		}else{

			    $vat_inc=$item[17];
		}
		     	
		/*.... Vat .....*/

//           igst
		if(empty($item[21])){ 

		        $igst=0;
		}else{

			    $igst=$item[21];
			   // var_dump($igst);
		}

          /*...... GST .......*/
        if(!empty($item[12]))
        {
		  $gst_per=$this->commonDBFunctions->getidToValue('gst','id',$item[12],'pharma_gst');
		  $sgst_per=$this->commonDBFunctions->getidToValue('sgst','id',$item[12],'pharma_gst');
		  $cgst_per=$this->commonDBFunctions->getidToValue('cgst','id',$item[12],'pharma_gst');
         if(!empty($item[21]) && ($item[21]==1))
         {
         	$igst_per=$gst_per;
         	$igst_amt=$item[13];
         }
         else{
            $igst_per='';
         	$igst_amt='';	
            }

        }	
    else{
          $gst_per='';
		  $sgst_per='';
		  $cgst_per='';
		 
        }  
/*...... GST .......*/	

/*... MM/YY format convert to DD-MM-YYYY ...*/

        $expiry_field = $item[3];

    if(!empty($expiry_field)){

										        // $expiry_field = str_replace('/', '-', $expiry_field);
										        // $newDate = explode( "-" , $expiry_field);
										        // $output = $newDate[1]."-".$newDate[0]."-".'1';
										        // $item[3]=date("t-m-Y", strtotime($output));



                    $expiry_field = $item[3];
                    $expiry_field = str_replace('/', '-', $expiry_field);
                    $newDate = explode( "-" , $expiry_field);
                    $output = $newDate[1]."-".$newDate[0]."-".'1';
							                    // $output = '1'."-".$newDate[0]."-".$newDate[1];
							                    // $item[$i][3]=date("t-m-Y", strtotime($output));

							                    // $date = date_create_from_format('d-m-Y', $output);

			        $year_obj = DateTime::createFromFormat('y', $newDate[1]);
			        $year = $year_obj->format('Y');
			        $month = $newDate[0];
			        $date_exp = "1";

			        $s = $date_exp."/".$month."/".$year;
					$date_exp = date_create_from_format('d/m/Y', $s);
					$output = $date_exp->format('Y-m-t');
					$item[3] = $output;



    }else $item[3]='';

    // var_dump($item[3]);exit();

/*... MM/YY format convert to DD-MM-YYYY ...*/	
		
		$data = array('bill_id'    => $bill_id,
	   				   'bill_date' => date("Y-m-d",strtotime($date)),
					   'item_id'   =>$item[0],
	                    'purchase_mode'   => $this->input->post('purchase_mode_selected'),
						'batch_number'    =>$item[2],
						'hsn_no'          =>$item[20],
						'expiry'         =>$item[3],
						'item_type'   	   =>$item[4],
                        'tpers'   	   =>$item[5],						
						'quantity' 	   => $item[6],
	    				'foc'            => $item[7],
						'sellp'  		   =>$item[8],
						'disc_type'       =>$item[10],
						'disc_value'      =>$item[11],		
						'buyp' 	       =>$item[9],
						'buyp_foc' 	       =>$buyp_foc,
						'vat_inc' 	       =>$vat_inc,
						'gst_id' 	       =>$item[12],
						'gst_per' 	       =>$gst_per,
						'sgst_per' 	       =>$sgst_per,
						'cgst_per' 	       =>$cgst_per,
						'gst_amt' 	       =>$item[13],
						'sgst_amt' 	       =>$item[14],
						'cgst_amt' 	       =>$item[15],
	    				'total'           => $item[16],
						'status'           => $status,
						'igst'            =>$igst,
						'igst_per'        =>$igst_per,
						'igst_amt'        =>$igst_amt
					);
						
			
		
		$result=$this->db->insert('pharma_recievings_items', $data);

		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	
	}
	function add_batchid($rec_item_id,$batch_id){
	
	  
	    $condition				= array('id' => $rec_item_id);
		
		
		$data= array ('batch_id' 	        => $batch_id,
	                 );
			
		
		$result=$this->db->update('pharma_recievings_items', $data,$condition);
		
		if($result) {
			return  $this->lang->line('add_success');
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	
	function addChequePayment($item){
	$condition				= array('id' => $item[0]);
	$data = array(
	   				   'checque_no'          => $item[2],
					   'checque_amt'         =>$item[1],
	                                   'cheque_issue_date'   => date("Y-m-d",strtotime($item[3])),
					   'balance'            =>$item[4],
					   'credit_status '     =>$item[5],
						
					);
				
		
			
		
		$result=$this->db->update('pharma_recievings', $data,$condition);
		
		if($result) {
			return  $this->lang->line('add_success');
		}else{
			return  $this->lang->line('add_failed');
		}
	
	}

    function getPurchaseCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_recievings");
        $count = $this->db->count_all_results();

        return $count;
		
    } 

	public function searchPurchase($criteria,$order_field = null,$order_by= null,$limit=null,$type=null){

		if(!empty($limit)){

            $limit=explode(",",$limit);

		}
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		if(!empty($order_field) && !empty($order_by)){ 
		     $this ->db-> order_by($order_field,$order_by);
		}

		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}
		
		$query=$this->db->get('pharma_recievings');
		// echo $this->db->last_query();

		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){

                  $credit=0;
                  $neft_amt=0;
                  $adjust_amt=0;
                  $upi_amt = 0;

                  $where=array();
			      $where[]="recievings_id = ".$row->id;
			      $where[] ="status = 0";
				
				  $creditInfo=$this->getPurchaseCreditPayment($where);
				  // var_dump($creditInfo);
				    
				  if(!empty($creditInfo)){
				
					for($k=0;$k<count($creditInfo);$k++){
					
					  $credit +=$creditInfo[$k][3]; 
					  $neft_amt +=$creditInfo[$k][12];
					  $adjust_amt +=$creditInfo[$k][13];
					  $upi_amt +=$creditInfo[$k][15];
					}
				
				  }

				  $amount_paid=$row->amount_paid;
				  $balance=$row->balance;
                  $rem_balance=$balance-($credit+$neft_amt+$adjust_amt+$upi_amt);



                if($type == 'credit' && $rem_balance>0){
				
					$status=1;
				
				}elseif($type == 'credit' && $rem_balance<=0){
				
					$status=0;
					
				}else $status=1;

   
if($status ==1){

			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->id;
				$billInfo[$i][2]= $row->pono;
				$billInfo[$i][3]= $row->bill_date;
				$billInfo[$i][4]= $row->supplier;
				$billInfo[$i][5]= $this->commonDBFunctions->getidToValue('supplier_name','id',$row->supplier,'pharma_suppliers');
				
				$billInfo[$i][6]= $row->purchase_amt;
				$billInfo[$i][7]= $row->gst;
				$billInfo[$i][8]= $row->cgst;
				$billInfo[$i][9]= $row->sgst;
				$billInfo[$i][10]= $row->freight;
				$billInfo[$i][11]= $row->return_amount;
				
				$billInfo[$i][12]= $row->bill_total;
				$billInfo[$i][13]= $row->discount_type;
				$billInfo[$i][14]= $row->discount_value;
				$billInfo[$i][15]= $row->discount_amt;
				
				
				$billInfo[$i][17]= $row->net_total;
				$billInfo[$i][18]= $row->payment_mode;
				$billInfo[$i][19]= $row->checque_no;
				$billInfo[$i][20]= $row->checque_amt;;
				$billInfo[$i][21]= $row->card_amt;;
				
				$billInfo[$i][22]= $row->amount_paid;
				$billInfo[$i][23]= $credit;//balance
				// $billInfo[$i][24]= $row->ref_id;
				// $billInfo[$i][25]= $this->commonDBFunctions->getidToValue('branch_name','id',$row->ref_id,'pharma_branch');
				$billInfo[$i][26]= $row->remarks;
				$billInfo[$i][27]= $row->bill_no;
				$billInfo[$i][28]= $row->entry_date;
				$billInfo[$i][29]= $row->user_id;
				$billInfo[$i][30]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');;
				$billInfo[$i][31]= $row->purchase_mode;
				$billInfo[$i][32]= $this->commonDBFunctions->getidToValue('tin_no','id',$row->supplier,'pharma_suppliers');
				$billInfo[$i][33]= $this->commonDBFunctions->getidToValue('gst_no','id',$row->supplier,'pharma_suppliers');
				$billInfo[$i][34]= $row->total_gst_purchase_amt ;
				$billInfo[$i][35]= $row->cheque_issue_date;
				$billInfo[$i][36]= $row->cancelled_user;
				$billInfo[$i][37]= $row->cancelled_date;
				$billInfo[$i][38]= $this->commonDBFunctions->getidToValue('user_name','id',$billInfo[$i][36],'users');
				$billInfo[$i][39]= $row->status;
				$billInfo[$i][40]= $row->rounded_status;
				$billInfo[$i][41]= $row->net_total_before;
				$billInfo[$i][42]= $row->round_amt;
				$billInfo[$i][43]= $this->commonDBFunctions->getidToValue('gst_no','id',$row->supplier,'pharma_suppliers');

			    $billInfo[$i][44]= $rem_balance;//credit paid
			    $billInfo[$i][45]= $credit;//cash amount (credit payment)
			    $billInfo[$i][48]= $neft_amt;//credit paid
			    $billInfo[$i][47]= $adjust_amt;//cash amount (credit payment)
			    $billInfo[$i][49]= $credit+$neft_amt+$upi_amt;//cash amount (credit payment)


		if($sum_gst !=$billInfo[$i][7])
                 {
			
			     $billInfo[$i][46]=$row->gst-($row->cgst +$row->sgst);}
		    else{
			    $billInfo[$i][46]=0;
			    }
			    // $billInfo[$i][45]
			 //   $billInfo[$i][46]= $row->igst;
				//$billInfo[$i][46]= $credit;
				$billInfo[$i][50]= $row->upi_amt;
				$billInfo[$i][51]= $upi_amt;;

				$i++;

}
			
			}
		}
		//var_dump($billInfo);
		return $billInfo;
	
	}

    function getPurchaseItemsCount($search= null)
    {  
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_recievings_items");
        $count = $this->db->count_all_results();
        
        return $count;
		
    } 

	public function searchPurchaseItems($criteria,$limit=null){
	    
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
		
		$query=$this->db->get('pharma_recievings_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->bill_id;
				$billInfo[$i][2]= $row->bill_date;
				$billInfo[$i][3]= $row->purchase_mode;
				$billInfo[$i][4]= $row->batch_number;
				$billInfo[$i][5]= $row->expiry;

				// $date_obj = DateTime::createFromFormat('Y-m-d', $row->expiry);
				// $output = $date_obj->format('d-m-Y');

				// var_dump($output);

				// $billInfo[$i][5] = $output;

				
				$billInfo[$i][6]= $row->item_type;
				$billInfo[$i][7]= $row->quantity;
				$billInfo[$i][8]= $row->foc;
				$billInfo[$i][9]= $row->sellp;
				$billInfo[$i][10]= $row->disc_type;
				
				$billInfo[$i][11]= $row->disc_value;
				$billInfo[$i][12]= $row->buyp;
				$billInfo[$i][13]= $row->total;
				$billInfo[$i][14]= $row->item_id;
				$billInfo[$i][15]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');;
				$billInfo[$i][16]= $row->tpers;
				$billInfo[$i][17]= $row->gst_per;
				$billInfo[$i][18]= $row->sgst_per;
				$billInfo[$i][19]= $row->cgst_per;
				$billInfo[$i][20]= $row->gst_amt;
				$billInfo[$i][21]= $row->sgst_amt;
				$billInfo[$i][22]= $row->cgst_amt;
				$billInfo[$i][23]= $row->gst_id;
				$billInfo[$i][24]= $row->vat_inc;
				$billInfo[$i][25]= $this->commonDBFunctions->getidToValue('user_id','id',$row->bill_id,'hcare_pharma_recievings');
				$billInfo[$i][26]= $this->commonDBFunctions->getidToValue('user_name','id',$billInfo[$i][25],'hcare_users');
				$billInfo[$i][27]= $row->hsn_no;
				$billInfo[$i][28]= $row->total-$row->gst_amt;//taxable_amt
				$billInfo[$i][29]= $row->batch_id;
                 $billInfo[$i][30]= $row->igst;
				
				
				$i++;
			
			}
		}
		//var_dump($billInfo);
		return $billInfo;
	
	}
	function delete_purchase($id){
	
	    date_default_timezone_set('Asia/Kolkata');
		
		$condition= array('id' => $id);
		$date=date("Y-m-d H:i");
        $cancellation_details=$this->input->post('cancellation_details');

        $old_update=$this->commonDBFunctions->getidToValue('update_history','id',$id,'pharma_recievings');

        if(!empty($old_update)){

	           $update_history = $this->session->userdata('user_id')."|DELETE BILL|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
 
               $update_history = $this->session->userdata('user_id')."|DELETE BILL|". date("d-m-Y H:i a");
		}

		      $user_id=$this->session->userdata('user_id');
		      $data = array( '`cancelled_user` ' 		=> "$user_id",
					         '`cancelled_date` ' 		=> "$date",
					         '`cancellation_details` ' 	=> "$cancellation_details",
					         '`update_history` ' 	    => "$update_history",
					         'status'					=>1
					        );
			$result=$this->db->update('pharma_recievings', $data,$condition);
		
		
		//$result=$this->db->delete('pharma_recievings',$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function delete_purchase_items($bill_id){
	
		
			$condition				= array('bill_id' => $bill_id);
		 $data = array( 'status'					=>1
						
					);
		
		
		$result=$this->db->update('pharma_recievings_items', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	function addPurchase_MultipleCrediPayment($bill_info){
//var_dump($bill_info);
	    $user_id=$this->session->userdata('user_id');
		$date=date("Y-m-d H:i:s");
		$data = array( 'recievings_id' 	=>$bill_info['recievings_id'],
						'date'	=> 		$date,
						'payment_type' =>$bill_info['payment_type'],
						'amount' => $bill_info['amount'],
						'neft_amount' => $bill_info['neft_amount'],

	    				'user_id' => $user_id,
	    				'remarks' => ''
						);
				
			$result=$this->db->insert('pharma_recievings_credit_payment', $data);

            return $this->db->insert_id();
	}

	function addPurchaseCreditPayment(){

	    $user_id=$this->session->userdata('user_id');
		$date=date("Y-m-d H:i:s");

		                $payment_type =$this->input->post('type');
						$amount = $this->input->post('new_amount');
						$neft_amount = $this->input->post('neft_amt');
						$upi_amount = $this->input->post('upi_amt');
	    				$remarks = $this->input->post('remarks');


						if($payment_type == 'NEFT'){
							$amount='';
							$upi_amount='';
						}else if($payment_type == 'UPI'){ 
							$neft_amount ='';
							$remarks ='';

						}else{
							$neft_amount ='';
							$remarks ='';
							$upi_amount='';
						}


		$data = array( 'recievings_id' 	=> $this->input->post('invno'),
						'date'	=> 		$date,
						'payment_type' =>$this->input->post('type'),
						'amount' => $amount,
						'neft_amount' => $neft_amount,

	    				'user_id' => $user_id,
	    				'remarks' => $remarks,
	    				'balance_adjust' => $this->input->post('adjust_amt'),
	    				'upi_amt' => $upi_amount


						);
				
			$result=$this->db->insert('pharma_recievings_credit_payment', $data);

            return $this->db->insert_id();
	}


	function getPurchaseCreditPaymentCount($search = null){		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		 $query = $this->db->get('pharma_recievings_credit_payment');
		 
		 return $query->num_rows();
	
	}

	function getPurchaseCreditPayment($criteria = null,$limit = null){
	
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
		
		$query=$this->db->get('pharma_recievings_credit_payment');
		// echo $this->db->last_query();
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->id;
				$billInfo[$i][2]= $row->recievings_id;
				$billInfo[$i][3]= $row->amount;
				$billInfo[$i][4]= $row->date;
				$billInfo[$i][5]= $this->commonDBFunctions->getidToValue('bill_no','id',$row->recievings_id,'pharma_recievings');
				$billInfo[$i][6]= $row->status;
				$billInfo[$i][7]= $row->cancellation_details;
				$billInfo[$i][8]= $row->cancellation_date;
				$billInfo[$i][9]= $row->user_id;
				$billInfo[$i][10]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
				$billInfo[$i][11]= $row->payment_type;
				$billInfo[$i][12]= $row->neft_amount;
				$billInfo[$i][13]= $row->balance_adjust;
				$billInfo[$i][14]= $row->remarks;
				$billInfo[$i][15]= $row->upi_amt;



				
				$i++;
			}
		}
		
		return $billInfo;
	}

    function delete_purchase_credit_payment($id,$canc_det){
	
		
			$condition				= array('id' => $id);
		
			$date=date("Y-m-d");
		
		    $data = array( 'cancellation_details' 		=> "$canc_det",
						'cancellation_date' 		=> "$date",
						'status'					=>1
						
					);
					
		
		$result=$this->db->update('pharma_recievings_credit_payment', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	public function searchdistinct_gst_purchase($criteria){
	
		
		$this->db->distinct();
		$this->db->select('sum(`gst_amt`) as `gst_sum`');
		$this->db->select('gst_per');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->order_by("gst_id", "asc"); 
		$query=$this->db->get('hcare_pharma_recievings_items');
		// echo $this->db->last_query();exit();
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i][0]= $row->gst_sum;
				$billInfo[$i][1]= $row->gst_per;
				// $billInfo[$i][2]=+$billInfo[$i][0];
				
				$i++;
			}
		}
		return $billInfo;
		//var_dump($billInfo);
	}
	public function total_quantity_sold_new($criteria){
		
		$this->db->select('item_id');
		$this->db->select_sum('quantity');
		$this->db->select_sum('total');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->group_by('item_id'); 

		$query = $this->db->get('pharma_recievings_items');


		$billInfo=array();;
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $row->item_id;
				$billInfo[$i][1]= $row->quantity;
				$billInfo[$i][2]= to_currency($row->total);
				$billInfo[$i][3]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');
				
				
				$i++;
			}
		}
		return $billInfo;

	}
function addCreditPaymentMultiple($billInfo){

	    $user_id=$this->session->userdata('user_id');
        $payment_type=$this->input->post('payment_type_selected');
		$date=date("Y-m-d H:i:s");
		// var_dump($this->input->post());exit();

		$data = array( 'recievings_id' 		=> $billInfo['bill_no'],
					   'payment_type'   =>   $payment_type,
					   
					   'amount' 		=> $billInfo['amount'],
					   'neft_amount' 		=> $billInfo['neft_amount'],
					   'date'	        => $date,
	    			   'user_id'        => $user_id,
	    			   'upi_amt' 		=> $billInfo['upi_amount'],
					);
		//var_dump($data);exit();
		$result=$this->db->insert('pharma_recievings_credit_payment', $data);

        return $this->db->insert_id();

	}
	

}
?>
