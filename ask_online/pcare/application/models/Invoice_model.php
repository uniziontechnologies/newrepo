<?php
class Invoice_model extends CI_Model {

   
	
	public $id;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
       
	function updateBill($balance,$auth_user_id){
	
		$condition				= array('id' => $this->input->post('billid'));
		
		$date=$this->input->post('date');
		$bill_id=$this->input->post('billid');
		$cust_type= $this->input->post('customer_type');
		$payment_type= $this->input->post('payment_type');
			  $user_id=$this->session->userdata('user_id');

		
      $old_update=$this->commonDBFunctions->getidToValue('update_history','id',$bill_id,'pharma_invoice');
        if(!empty($old_update)){

	           $update_history = $this->session->userdata('user_id')."||". date("d-m-Y H:i a")."&&".$old_update;
		}else{
 
               $update_history = $this->session->userdata('user_id')."||". date("d-m-Y H:i a");
		}	 
		

		if($cust_type == 'OP') $opno=$this->input->post('op_no');
		else $opno=0;
		
		  if(($cust_type == 'DIRECT' || $cust_type == 'OP') && $payment_type == "CREDIT"){
		  
		      $sanctioned_by=$this->input->post('sanc_by_hidden');
			  $auth_remarks=$this->input->post('auth_remarks_hidden');
			  $user_id=$auth_user_id;
		  }else{
		      $sanctioned_by='';
			  $auth_remarks='';
			  $user_id=$this->session->userdata('user_id');
			  if($cust_type == 'IP'){
			  $ipno=$this->input->post('ip_no');
			 $opno= $this->commonDBFunctions->getidToValue('opno','id',$ipno,'ip_info');
			}
		  }

		    $free_bill=$this->input->post('free_bill');
		  if( empty($free_bill)){
		  	$free_bill=0;
           }

         /*..... roundstatus .....*/
			 $roundstatus=$this->input->post('roundstatus');
			 if(empty($roundstatus)) $roundstatus=0;

			 /*..... round_amt .....*/
			 $round_amt=$this->input->post('round_amt');
			 if(empty($round_amt)) $round_amt=0;
		 
		
		$data = array( 'cust_type' 		=> $this->input->post('customer_type'),
						'op_visit_id'	=> $this->input->post('op_id'),
						'op_no' 		=> $opno,
	    				'cust_name'   	 	=> $this->input->post('cust_name'),
						'doctor' 		=> $this->input->post('doctor'),
						// 'bill_date '  	 	=> date("Y-m-d h:i:s",strtotime($date))." ".date("H:i:s"),	   
						'sales_amt'   		=>$this->input->post('sales_amt'),
						'gst' 			    => $this->input->post('tot_gst'),
		                'cgst'   		    => $this->input->post('tot_cgst'),
		                'sgst'   		    => $this->input->post('tot_sgst'),		
	    				'return_amount'   	=> $this->input->post('return_amt'),
						'bill_total'   	=>$this->input->post('bill_total'),
						'discount_type'  	=>!empty($this->input->post('bill_disc_type'))?$this->input->post('bill_disc_type'):'',
						'discount_value'   =>$this->input->post('bill_disc_value'),		
						'discount_amt' 	=> $this->input->post('disc_amt'),
						'net_total_before'  => $this->input->post('net_total'),
	    				'net_total'   		=> $this->input->post('round_net_amt'),
	    				'rounded_status'    => $roundstatus,
	                    'round_amt'         => $round_amt,
						'payment_mode'  	=> $this->input->post('payment_type'),
						'checque_no'   	=>$this->input->post('checque_no'),
						'checque_amt'  	=>$this->input->post('checque_amt'),
						'card_amt'   		=>$this->input->post('card_amt'),
						'amount_paid'   	=>$this->input->post('amount_paid'),
						'balance'   		=> $balance,		
						'ref_id '			=> $this->input->post('branch'),
	    				'remarks'   		=> $this->input->post('remarks'),
						'sanctioned_by'   		=> $sanctioned_by,
						'auth_remarks'   		=> $auth_remarks,
		                // 'user_id'   		=> $user_id,
		                'update_history'    => $update_history,
		                'flood_cess'   		=> $this->input->post('tot_flood_cess'),
		                'free_bill'         => $free_bill,
		                'upi_amt'   		=>$this->input->post('upi_amt'),
					);
		
		$result=$this->db->update('pharma_invoice', $data,$condition);
		//echo $this->db->last_query();
		if($result) {
			return $this->input->post('billid');
		}else{
			return  $this->lang->line('updation_failed');
		}
	}
	function addUpdationhistory($info){
		 date_default_timezone_set('Asia/Kolkata');
		 $user_id=$this->session->userdata('user_id');
			$date=$this->input->post('date');
	
		$data = array( 'billid' 		    => $info[0],
						'date'	            => date("Y-m-d H:i:s"),
						'net_prev' 		    => $info[2],
	    				'balance_prev'   	=> $info[3],
						'net_total '  	 	=> $info[4],	   
						'balance'   		=> $info[5],
						'user_id'  			=> $user_id
						);
						
			$result=$this->db->insert('pharma_invoice_updations', $data);
	}
	function addBill($balance,$auth_user_id = null){
	
		$date=$this->input->post('date');
		 date_default_timezone_set('Asia/Kolkata');
		 
		$cust_type= $this->input->post('customer_type');
		$payment_type= $this->input->post('payment_type');
		$discount_type=$this->input->post('bill_disc_type');
		$bill_disc_value=$this->input->post('bill_disc_value');
		 $return_billid= $this->input->post('return_bill');
			  $user_id=$this->session->userdata('user_id');

		 if(!empty($draft)){
        	$draft_id=$this->input->post('billid');
        }
		else{
			$draft_id='0';
		}
		
		if($cust_type == 'OP'){ $opno=$this->input->post('op_no');
		}else{ $opno=0;}
		
		  if(($cust_type == 'DIRECT' || $cust_type == 'OP') && $payment_type == "CREDIT"){
		  
		      $sanctioned_by=$this->input->post('sanc_by_hidden');
			  $auth_remarks=$this->input->post('auth_remarks_hidden');
			  $user_id=$this->session->userdata('user_id');
		   }
			 // else if($discount_type !="" && $bill_disc_value>10){
		  
		  //     $sanctioned_by=$this->input->post('sanc_by_hidden');
			 //  $auth_remarks=$this->input->post('auth_remarks_hidden');
			 //  $user_id=$auth_user_id;
		  // }
			  else{
		      $sanctioned_by='';
			  $auth_remarks='';
			  $user_id=$this->session->userdata('user_id');
			if($cust_type == 'IP'){
			  $ipno=$this->input->post('ip_no');
			 $opno= $this->commonDBFunctions->getidToValue('opno','id',$ipno,'ip_info');
			}
		  }

		  /*..... sales_amt ......*/
			 $sales_amt=$this->input->post('sales_amt');
			 if(empty($sales_amt)) $sales_amt=0;

          /*..... return_amt ......*/
			 $return_amt=$this->input->post('return_amt');
			 if(empty($return_amt)) $return_amt=0;


		  /*..... checque_no ......*/
			 $checque_no=$this->input->post('checque_no');
			 if(empty($checque_no)) $checque_no=0;

			 /*..... checque_amt .....*/
			 $checque_amt=$this->input->post('checque_amt');
			 if(empty($checque_amt)) $checque_amt=0;

			 /*..... card_amt .....*/
			 $card_amt=$this->input->post('card_amt');
			 if(empty($card_amt)) $card_amt=0;

			 /*..... card_amt .....*/
			 $ref_id=$this->input->post('branch');
			 if(empty($ref_id)) $ref_id=0;

			 /*..... upi_amt .....*/
			 $upi_amt=$this->input->post('upi_amt');
			 if(empty($upi_amt)) $upi_amt=0;

			 /*..... roundstatus .....*/
			 $roundstatus=$this->input->post('roundstatus');
			 if(empty($roundstatus)) $roundstatus=0;

			 /*..... round_amt .....*/
			 $round_amt=$this->input->post('round_amt');
			 if(empty($round_amt)) $round_amt=0;

			 /*..... doc_id .....*/
			 $doc_id=$this->input->post('doc_id');
			 if(empty($doc_id)) $doc_id=0;

			 $sales_mode_selected= $this->input->post('sales_mode_selected');
		if($sales_mode_selected == 'Return'){
			if(!empty($return_billid)){
				$return_billid=$return_billid;
			}
			else{
					$return_billid=0;
			}
			
		  }else{
		  	$return_billid=0;
		  }
		  $free_bill=$this->input->post('free_bill');
		  if( empty($free_bill)){
		  	$free_bill=0;
           }
		 

		$data =   array('cust_type' 		=> $this->input->post('customer_type'),
		                'op_visit_id'		=>$this->input->post('op_id'),
		                'op_no'			    =>$opno,
                        'ip_no'			    =>$this->input->post('ip_no'),
	                    'cust_name'   	 	=> $this->input->post('cust_name'),
		                'doctor' 		    => $this->input->post('doctor'),
		                'doc_id' 		    => $doc_id,
		                'bill_date'   	 	=> date("Y-m-d H:i:s"),
						'sales_amt'   		=> $sales_amt,
		                'gst' 			    => $this->input->post('tot_gst'),
		                'cgst'   		    => $this->input->post('tot_cgst'),
		                'sgst'   		    => $this->input->post('tot_sgst'),		
	                    'return_amount'   	=> $return_amt,
		                'bill_total'   		=> $this->input->post('bill_total'),
		                'discount_type'  	=> !empty($this->input->post('bill_disc_type'))?$this->input->post('bill_disc_type'):'',
		                'discount_value'   	=> $this->input->post('bill_disc_value'),		
		                'discount_amt' 		=> $this->input->post('disc_amt'),
	                    'net_total_before'  => $this->input->post('net_total'),
	                    'net_total'         => $this->input->post('round_net_amt'),
	                    'rounded_status'    => $roundstatus,
	                    'round_amt'         => $round_amt,
		                'payment_mode'   	=> $this->input->post('payment_type'),
		                'checque_no'   		=> $checque_no,
		                'checque_amt'  		=> $checque_amt,
		                'card_amt'   		=> $card_amt,
		                'amount_paid'   	=> $this->input->post('amount_paid'),
		                'balance'   		=> $balance,		
		                'ref_id' 		    => $ref_id,
	                    'remarks'   		=> $this->input->post('remarks'),
			            'sales_mode' 		=> $this->input->post('sales_mode_selected'),
						'sanctioned_by'   	=> $sanctioned_by,
						'auth_remarks'   	=> $auth_remarks,
		                'user_id'   		=> $user_id,
		                'flood_cess'   		=> $this->input->post('tot_flood_cess'),
		                 'draft_id'          => $draft_id,
		                'return_billid'     =>$return_billid,
		                'free_bill'          =>$free_bill,
		                'upi_amt'         =>$upi_amt
		              );
			
		
		$result=$this->db->insert('pharma_invoice', $data);
		//echo $this->db->last_query();
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function addBillItems($item,$bill_id,$invoice_bill_date=null){
	   
		$date=$this->input->post('date');
		$return_billid=$this->input->post('return_bill');
         
          if(!empty($draft)){
        	$draft_id=$this->input->post('billid');
        }
		else{
			$draft_id='0';
		}
		

		if(!empty($item[11]) && !empty($item[12]))
		    {
		      $total_gst= $item[20];
              $total_sgst= $item[21];
              $total_cgst= $item[22];
              $total_sellp= $item[6]*$item[8];
              $total_flood_cess= $item[25];//flood cess 1%
		    }
		else{
			  $total_gst='';
              $total_sgst='';
              $total_cgst='';
              $total_sellp= '';
              $total_flood_cess=''; 
		    }
		
		if($item[1]=='Return'){
		 		$return_billid=$return_billid;
		 	}else{
		 		$return_billid=0;
		 	}


		 	if (!empty($invoice_bill_date)) {
		 		$bill_date = date("Y-m-d",strtotime($invoice_bill_date));
		 	}
		 	else{
		 		$bill_date = date("Y-m-d",strtotime($date));
		 	}

		$data = array('bill_id'    => $bill_id,
	   		      'bill_date' => $bill_date,
			      'item_id'   =>$item[0],
			      'batch_id'   =>$item[18],
	              'sales_mode'   => $item[1],
			      'batch_no'    =>$item[3],
			      'hsn_no'     =>$item[19],
			      'expiry'         =>date("Y-m-d",strtotime($item[4])),
			      'selling_unit'   	   =>$item[5],		
			      'quantity' 	   => $item[6],	    				
			      'sellp'  		   =>$item[8],
			      'total_sellp'    =>$total_sellp,	
			      'gst_id'  	   =>$item[11],
			      'gst_per'  	   =>$item[12],
			      'sgst_per'  	   =>$item[13],
			      'cgst_per'       =>$item[14],
			      'gst_amt'        =>to_currency($item[15]),
			      'total_gst'      =>$total_gst,
			      'sgst_amt'       =>to_currency($item[16]),
			      'total_sgst'     =>$total_sgst,
			      'cgst_amt'       =>to_currency($item[17]),	
			      'total_cgst'     =>$total_cgst,
			      'mrp'  		   =>$item[7],				
	    		  'total'          => $item[9],
	    		  'flood_cess_amt'       =>to_currency($item[24]),
	    		  'total_flood_cess'     =>$total_flood_cess,
	    		  'draft_id'             => $draft_id,
	    		  'return_billid'        => $return_billid
			);
				
			
		
		$result=$this->db->insert('pharma_invoice_items', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	
	}
	public function searchupdationHistory($criteria){
	
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$billInfo=array();
		$i=0;
		$query=$this->db->get('pharma_invoice_updations');
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->id;
				$billInfo[$i][2]= $row->billid;
				$billInfo[$i][3]= $row->date;
				$billInfo[$i][4]= $row->net_prev;
				$billInfo[$i][5]= $row->balance_prev;				
				$billInfo[$i][6]= $row->net_total;
				$billInfo[$i][7]= $row->balance;
				$billInfo[$i][8]= $row->user_id;
				
				$billInfo[$i][9]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');;
				$billInfo[$i][10]= $this->commonDBFunctions->getidToValue('cust_name','id',$row->billid,'hcare_pharma_invoice');;
				$billInfo[$i][11]= $this->commonDBFunctions->getidToValue('op_visit_id','id',$row->billid,'hcare_pharma_invoice');;
				$billInfo[$i][12]= $this->commonDBFunctions->getidToValue('payment_mode','id',$row->billid,'hcare_pharma_invoice');;

			    $billInfo[$i][13]=$this->commonDBFunctions->getidToValue('opno','id',$billInfo[$i][11],'op_visit_info');
				$billInfo[$i][14]=$this->commonDBFunctions->getidToValue('cust_type','id',$row->billid,'hcare_pharma_invoice');




              $billInfo[$i][15]=$this->commonDBFunctions->getidToValue('update_history','id',$row->billid,'hcare_pharma_invoice');

                   $update_history = "";


                        if(!empty($billInfo[$i][15])){
			                                            $history_split=explode("&&",$billInfo[$i][15]);
				                                     
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("||",$history_split[$m]);
			                                                   
			                                                  $user_name=$this->commonDBFunctions->getidToValue('user_name','id',$history_info[0],'users');
			                                                
			                                                  $datetime=$history_info[1];
			                                                 
			                              
					                                  $update_history   .=$user_name.":".$datetime."<br>";

			                                                  // var_dump($history_info);
			                                             }
			                                               }
		                                                }

		                                               $billInfo[$i][16]=$update_history;
                                                       $billInfo[$i][17]=$this->commonDBFunctions->getidToValue('invoice_id','id',$row->billid,'hcare_pharma_invoice');    







		                                               $i++;



		}
		}
		return $billInfo;
	}

    function getInvoiceCount($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_invoice");
        $count = $this->db->count_all_results();

        return $count;
		
    } 

	public function searchBill($criteria,$type = null,$limit=null,$offset=null){

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
		
		$query=$this->db->get('pharma_invoice');
		
		$billInfo=array();
		$ip_bill_status=0;
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){

			$ip_bill_status=0;
			
			$where=array();
			$where[]="bill_no = ".$row->id;
			$where[] ="status = 0";
				
				$creditInfo=$this->getCreditPayment($where);
				$credit=0;
				$card_amount = 0;
				$upi_amount = 0;
				if(!empty($creditInfo)){
				
					for($k=0;$k<count($creditInfo);$k++){
					
						$credit +=($creditInfo[$k][3]+$creditInfo[$k][13]+$creditInfo[$k][14]);

						$card_amount += $creditInfo[$k][13];
						$upi_amount += $creditInfo[$k][14];
					}
				
				}
				
				$amount_paid=$row->amount_paid;
				$balance=$row->balance;
                                $rem_balance=$balance-$credit;
                                $new_amount=($amount_paid+$credit)-($card_amount+$upi_amount);
				
				if($row->cust_type == "IP"){
				
				   $discharge_date=$this->commonDBFunctions->getidToValue('discharge_date','id',$row->ip_no,'ip_info');
                   $ip_bill_status=$this->commonDBFunctions->getidToValue('bill_status','id',$row->ip_no,'ip_info');

				}else $discharge_date='0000-00-00';
			
				if($type == 'credit' && $rem_balance>0){
				
					$status=1;
				
				}else if($type == 'credit' && $rem_balance<=0){
				
					$status=0;
					
				}else $status=1;
				
				if($type == 'credit' && $discharge_date!='0000-00-00'){
				   $status=0;
				}
				
				if($status ==1) {
				
				
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->id;
				$billInfo[$i][2]= $row->cust_type;
				$billInfo[$i][3]= $row->op_visit_id;
				$billInfo[$i][4]= $row->cust_name;
				$billInfo[$i][5]= $row->bill_date;
				
				$billInfo[$i][6]= $row->sales_amt;				
				$billInfo[$i][9]= $row->return_amount;
				
				$billInfo[$i][10]= $row->bill_total;
				$billInfo[$i][11]= $row->discount_type;
				$billInfo[$i][12]= $row->discount_value;
				$billInfo[$i][13]= $row->discount_amt;
				
				
				
				$billInfo[$i][14]= $row->net_total;
				$billInfo[$i][15]= $row->payment_mode;
				$billInfo[$i][16]= $row->checque_no;
				$billInfo[$i][17]= $row->checque_amt;;
				$billInfo[$i][18]= $row->card_amt;;
				
				$billInfo[$i][19]= $amount_paid;
				$billInfo[$i][20]= $balance;
				$billInfo[$i][21]= $row->ref_id;
				$billInfo[$i][22]= $this->commonDBFunctions->getidToValue('branch_name','id',$row->ref_id,'pharma_branch');
				$billInfo[$i][23]= $row->remarks;
				$billInfo[$i][24]= $row->user_id;
				$billInfo[$i][25]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
				$billInfo[$i][26]= $row->cancellation_details;
				$billInfo[$i][27]= $row->cancellation_date;
				$billInfo[$i][28]= $row->status;
								
				$billInfo[$i][29]= $credit;
				
				$doc_id= $this->commonDBFunctions->getidToValue('doc_id','id',$row->op_visit_id,'op_visit_info');
				if($row->cust_type=="OP"){
				$billInfo[$i][30]=$this->commonDBFunctions->getidToValue('title','id',$doc_id,'hcare_emp_info')." ".$this->commonDBFunctions->getidToValue('first_name','id',$doc_id,'hcare_emp_info')." ".$this->commonDBFunctions->getidToValue('last_name','id',$doc_id,'hcare_emp_info');
				}else{
				$billInfo[$i][30]= $row->doctor;
				}
                                $billInfo[$i][31]=$new_amount;
                                $billInfo[$i][32]=$rem_balance;
                                $billInfo[$i][33]= $row->ip_no;
				if($row->cust_type == "OP") {
					$billInfo[$i][34]= $opno=$this->commonDBFunctions->getidToValue('opno','id',$row->op_visit_id,'op_visit_info');
				        $billInfo[$i][43]=$this->commonDBFunctions->getidToValue('prefix','id',$opno,'op_patient_info');
				}else{
                                   $billInfo[$i][34]= $row->op_no;
				   $billInfo[$i][37]="";
				}
				   $billInfo[$i][35]= $row->sanctioned_by;
				   $billInfo[$i][36]= $row->auth_remarks;
				   $billInfo[$i][37]= $row->sales_mode;
				   $billInfo[$i][38]= $row->cancelled_by;
				   $billInfo[$i][39]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');

				   $billInfo[$i][40]= $row->rounded_status;
				   $billInfo[$i][41]= $row->net_total_before;
				   $billInfo[$i][42]= $row->round_amt;
				   $billInfo[$i][44]= $row->gst;
				   $billInfo[$i][45]= $row->cgst;
				   $billInfo[$i][46]= $row->sgst;
				   $billInfo[$i][47]= $ip_bill_status;
				   $billInfo[$i][48]= $row->doc_id;

                   
                   $billInfo[$i][51]=$row->update_history;

                   $update_history = "";


                        if(!empty($row->update_history)){
			                                             $history_split=explode("&&",$row->update_history);
				    
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("||",$history_split[$m]);
			                                                   
			                                                  $user_name=$this->commonDBFunctions->getidToValue('user_name','id',$history_info[0],'users');
			                                                  // var_dump($history_info[0]);
			                                                  $datetime=$history_info[1];
			                                                 
			                              
					                                  $update_history   .=$user_name.":".$datetime."<br>";

			                                                  // var_dump($history_info);
			                                             }
			                                         }
		                                                }

		                                               $billInfo[$i][52]=$update_history;
		                                               $billInfo[$i][53]=0;
                                                       $billInfo[$i][54]= $row->flood_cess;//flood cess 1%
                                                        $billInfo[$i][55]= $card_amount;
							 $billInfo[$i][56]= $ip_bill_status;

							 $billInfo[$i][57]= $draft_id;
				             $billInfo[$i][58]= $row->return_billid;
				             $billInfo[$i][59]= $row->free_bill;
				             $billInfo[$i][60]= $this->commonDBFunctions->getidToValue('payment_status','id',$row->op_visit_id,'op_visit_info');
				             $billInfo[$i][61]= $row->upi_amt;
				             $billInfo[$i][62]=$upi_amount;

														
				$i++;
			  }
			
			}
		}
		
		return $billInfo;
	
	}
	public function total_amount_sold($criteria){
	
		$this->db->select_sum('total');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->where('status',0);
		$query = $this->db->get('pharma_invoice_items');
		
		 $row = $query->row(); 
		 
		   return $row->total;
	}
	public function total_quantity_sold($criteria,$selling_unit){
	
		$this->db->select_sum('quantity');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->where('selling_unit',$selling_unit);
		$this->db->where('status',0);
		$query = $this->db->get('pharma_invoice_items');

		$row = $query->row(); 
		 
		   return $row->quantity;
	}
public function searchdistinct_item($criteria,$limit=null){
	
		
			$this->db->distinct();
			$this->db->select('item_id');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
// var_dump($limit);
		if($limit !=''){

			$limit1= explode(",", $limit);

			// var_dump($limit1);
		
		   $this->db->limit($limit1[1],$limit1[0]);
		}

		
		$query=$this->db->get('pharma_invoice_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i][0]= $row->item_id ;
				$billInfo[$i][1]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');
				
				
				$i++;
			}
		}
		return $billInfo;
	}

    function searchBillItemsCount($search = null){
	
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		 $query = $this->db->get('pharma_invoice_items');
		 
		 return $query->num_rows();
	
	}

	public function searchBillItems($criteria,$limit=null,$sales_mode=null){
	
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
		
		$query=$this->db->get('pharma_invoice_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->bill_id;
				$billInfo[$i][2]= $row->bill_date;
				$billInfo[$i][3]= $row->item_id;
				$billInfo[$i][4]= $row->batch_id;
				$billInfo[$i][5]= $row->sales_mode;				
				$billInfo[$i][6]= $row->batch_no;
				$billInfo[$i][7]= $row->expiry;
				$billInfo[$i][8]= $row->selling_unit;
				$billInfo[$i][9]= $row->quantity;
				$billInfo[$i][10]= $row->sellp;			
				$billInfo[$i][11]= $row->total;				
				$billInfo[$i][12]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');;
				$billInfo[$i][13]= $this->commonDBFunctions->getidToValue('manufacturer','id',$row->item_id,'pharma_brand');;
				$billInfo[$i][14]= $row->gst_per;
				$billInfo[$i][15]= $row->sgst_per;
				$billInfo[$i][16]= $row->cgst_per;
				$billInfo[$i][17]= $row->gst_amt;
				$billInfo[$i][18]= $row->sgst_amt;
				$billInfo[$i][19]= $row->cgst_amt;
				$billInfo[$i][20]= $row->mrp;
				$billInfo[$i][21]= $row->gst_id;
				$billInfo[$i][22]= $row->total_sellp;
				$billInfo[$i][23]= $row->total_gst;
				$billInfo[$i][24]= $row->total_sgst;
				$billInfo[$i][25]= $row->total_cgst;
				$billInfo[$i][26]= $this->commonDBFunctions->getidToValue('user_id','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][27]= $this->commonDBFunctions->getidToValue('user_name','id',$billInfo[$i][26],'hcare_users');
				$billInfo[$i][28]= $row->hsn_no;
				$billInfo[$i][29]= $row->total-$row->total_gst;//taxable_amt
				$billInfo[$i][30]= $this->commonDBFunctions->getidToValue('cust_name','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][31]= $this->commonDBFunctions->getidToValue('net_total_before','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][32]= $this->commonDBFunctions->getidToValue('cust_type','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][33]= $this->commonDBFunctions->getidToValue('op_no','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][34]= $this->commonDBFunctions->getidToValue('ip_no','id',$row->bill_id,'hcare_pharma_invoice');

							$new_criteria[0] = "brand_id = ".$row->item_id;
							$new_criteria[1] = "batch_number LIKE '%".$row->batch_no."%' ";

				$billInfo[$i][35]=$this->commonDBFunctions->getidToValue_multiple('buyp',$new_criteria,'pharma_batch');
				$billInfo[$i][36]=0;


		//....flood cess 1%
				$billInfo[$i][37]= $row->flood_cess_amt;
				$billInfo[$i][38]= $row->total_flood_cess;
		//....flood cess 1%

				 $billInfo[$i][39]= $row->draft_id;

                 if($sales_mode=='Return'){
                            $new_criteria1[0] = "return_billid = ".$row->bill_id;
							$new_criteria1[1] = "batch_id =".$row->batch_id ;
							$new_criteria1[2] = "status=0";
							$new_criteria1[3] = "sales_mode= 'Return'";
							$new_criteria1[4] = "item_id= ".$row->item_id;
		
                 $billInfo[$i][40]=$this->commonDBFunctions->getidToValue_multiple('sum(quantity)',$new_criteria1,'pharma_invoice_items');
                    

				 }else{
				 	$billInfo[$i][40]='';
				 }
				


				
				
				
				$i++;
			
			}
		}
		
		return $billInfo;
	
	}

	function delete_invoice($id,$canc_det){
	
		
			$condition				= array('id' => $id);
		
		
			$date=date("Y-m-d");

			$user_id=$this->session->userdata('user_id');
		
		    $data = array( 'cancellation_details' => "$canc_det",
				           'cancellation_date' 	  => "$date",
				           'cancelled_by' 	      => "$user_id",
				           'status'				  =>1
						
					);
					
		//$result=$this->db->delete('pharma_invoice',$condition);
		
		$result=$this->db->update('pharma_invoice', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function delete_invoice_items($bill_id){
	
		
			$condition				= array('bill_id' => $bill_id);
		
		$data = array( 'status'	=>1	);
		
		
		$result=$this->db->update('pharma_invoice_items', $data,$condition);
		//$result=$this->db->delete('pharma_invoice_items',$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function addCreditPayment(){
		// $upi=$this->input->post('upi_amt');

		// echo $upi;exit;
	     $user_id=$this->session->userdata('user_id');
		$date=date("Y-m-d H:i:s");
		$data = array( 'bill_no' 		=> $this->input->post('bill_id'),
						'date'	=> 		$date,
						'payment_type'  => $this->input->post('payment_type_selected'),
						'amount' 		=> $this->input->post('credit_amount'),
						'card_amt' 		=> $this->input->post('card_amt'),
	    				'user_id' => $user_id,
	    				'upi_amt' 		=> $this->input->post('upi_amt')
						);
			$result=$this->db->insert('pharma_credit_payment', $data);

                return $this->db->insert_id();
	}

	function getCreditPaymentCount($search = null){		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		 $query = $this->db->get('pharma_credit_payment');
		 
		 return $query->num_rows();
	
	}
	
	function getCreditPayment($criteria = null,$limit = null){
	
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
		
		$query=$this->db->get('pharma_credit_payment');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->id;
				$billInfo[$i][2]= $row->bill_no;
				$billInfo[$i][3]= $row->amount;
				$billInfo[$i][4]= $row->date;
				$billInfo[$i][5]= $this->commonDBFunctions->getidToValue('cust_name','id',$row->bill_no,'pharma_invoice');;
				$billInfo[$i][6]= $row->status;
				$billInfo[$i][7]= $row->cancellation_details;
				$billInfo[$i][8]= $row->cancellation_date;
				$billInfo[$i][9]= $row->user_id;
				$billInfo[$i][10]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
				$billInfo[$i][11]= $this->commonDBFunctions->getidToValue('cust_type','id',$row->bill_no,'hcare_pharma_invoice');
				$billInfo[$i][12]= $row->payment_type;
				$billInfo[$i][13]= $row->card_amt;
				$billInfo[$i][14]= $row->upi_amt;
				$i++;
			}
		}
		
		return $billInfo;
	}
	
	function delete_credit_payment($id,$canc_det){
	
		
			$condition				= array('id' => $id);
		
		
			$date=date("Y-m-d");
		
		$data = array( 'cancellation_details' 		=> "$canc_det",
						'cancellation_date' 		=> "$date",
						'status'					=>1
						
					);
					
		//$result=$this->db->delete('pharma_invoice',$condition);
		
		$result=$this->db->update('pharma_credit_payment', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	public function getPrescription($criteria=null){
	
   		$this->db->select("a.`id` , a.`patient_type` , a.`visit_id` , a.`brand_id` , a.`brand_name` , a.`med_course` , a.`med_days` , a.`date_time` , a.`update_history` , a.`status` , a.`invoice_id` , b.`id` as opid , b.`doc_id` , c.`first_name` as doc_first_name , c.`last_name` as doc_last_name, d.`first_name` as patient_first_name, d.`middle_name` as patient_middle_name, d.`last_name` as patient_last_name");


		$this->db->from('hcare_medicine_prescribed a');
		
		$this->db->join('hcare_op_visit_info b', 'a.visit_id = b.id','left');
		$this->db->join('emp_info c', 'b.doc_id = c.`id`','left');
		$this->db->join('hcare_op_patient_info d', 'b.opno = d.`id`','left');
		
		if(!empty($criteria)){
				for($k=0;$k<count($criteria);$k++){
				
					$this->db->where($criteria[$k]);
				
				}
			} 
		$this->db->where('a.status','0');
		$this->db->order_by("a.id", "asc");
		
		$query = $this->db->get();
		
		$options = array();
		$i=0;

		foreach ($query->result() as $row)
		{

			$options[$i][0] = $row->id;
			$options[$i][1] = $row->patient_type;
			$options[$i][2] = $row->visit_id;
			$options[$i][3] = $row->brand_id ;
			$options[$i][4] = $row->brand_name  ;
			$options[$i][5] = $row->med_course;
			$options[$i][6] = $row->med_days;
			$options[$i][7] = $row->date_time;
			$options[$i][8] = $row->update_history;
			$options[$i][9] = $row->status;
			$options[$i][10] = $row->opid;
			$options[$i][11] = $row->doc_id;
			$options[$i][12] = $row->doc_first_name;
			$options[$i][13] = $row->doc_last_name;
			$options[$i][14] = $row->patient_first_name;
			$options[$i][15] = $row->patient_middle_name;
			$options[$i][16] = $row->patient_last_name;
			$options[$i][17]= $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'hcare_pharma_brand');
			$options[$i][18] = $row->invoice_id;

		

		//	$options[$i][19] =$this->commonDBFunctions->getidToValue('id','op_visit_id',$row->visit_id,'hcare_pharma_invoice_draft');

		//	$options[$i][20] =$this->commonDBFunctions->getidToValue('status','bill_id',$options[$i][19],'hcare_pharma_invoice_draft_items'); 
			
			$i++;
		}			 		

		return $options;
	}

	public function todayBillCollection(){

		$fromdate=date("Y-m-d")." 00:00:00";
		$todate=date("Y-m-d")." 23:59:59";

	//hcare_pharma_invoive(return) 
		$sql="select sum(net_total) as sum, sum(amount_paid) as amount_paid,sum(card_amt) as card_amt, sum(checque_amt) as checque_amt from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
        
        $query = $this->db->query($sql);

        $net_total_return=$query->row()->sum;
        $amount_paid_return=$query->row()->amount_paid;
        $card_amt_return=$query->row()->card_amt;
        $checque_amt_return=$query->row()->checque_amt;

        $total_return=$amount_paid_return+$card_amt_return+$checque_amt_return;


    //hcare_pharma_invoive 
		$sql="select sum(net_total) as sum, sum(amount_paid) as amount_paid,sum(card_amt) as card_amt, sum(checque_amt) as checque_amt  from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
        
		$query = $this->db->query($sql);

		 $amount_paid_sales=$query->row()->amount_paid;
        $card_amt_sales=$query->row()->card_amt;
        $checque_amt_sales=$query->row()->checque_amt;
        $total_sales=$amount_paid_sales+$card_amt_sales+$checque_amt_sales;
        
		// $net_total=$query->row()->sum-$net_total_return;
		$net_total=$total_sales-$total_return;
		$today_invoice_collection=to_currency($net_total);

    //hcare_pharma_credit_payment
		$sql="select sum(amount) as sum, sum(card_amt) as card_amt from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";

		$query = $this->db->query($sql);
        
		$amount=$query->row()->sum;
		$card_amt=$query->row()->card_amt;
		$today_credit_amount=to_currency($amount+$card_amt);
        

         $today_total_bill_collection=$today_invoice_collection+$today_credit_amount;
        
        
        return $today_total_bill_collection;
    }

    public function oneWeekBillCollection($bill_date){

		$fromdate=$bill_date." 00:00:00";
		$todate=$bill_date." 23:59:59";

	//hcare_pharma_invoive(return) 
		$sql="select sum(net_total) as sum from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";

        $query = $this->db->query($sql);

        $net_total_return=$query->row()->sum;

    //hcare_pharma_invoive 
		$sql="select sum(net_total) as sum from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
        
        
		$query = $this->db->query($sql);
        
		$net_total=$query->row()->sum-$net_total_return;
		$today_invoice_collection=to_currency($net_total);

    //hcare_pharma_credit_payment
		$sql="select sum(amount) as sum from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate'";

		$query = $this->db->query($sql);
        
		$amount=$query->row()->sum;
		$today_credit_amount=to_currency($amount);
        

        $today_total_bill_collection=$today_invoice_collection+$today_credit_amount;
        
        return $today_total_bill_collection;
    }
    public function todayDetailedBillCollection(){

    	  $fromdate=date("Y-m-d")." 00:00:00";
		  $todate=date("Y-m-d")." 23:59:59";

//hcare_pharma_invoive(return)
          $sql="select sum(amount_paid) as amount_paid from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
          
          $query = $this->db->query($sql);

          $cash_return=$query->row()->amount_paid;


//hcare_pharma_invoive
          $sql="select sum(amount_paid) as amount_paid,sum(card_amt) as card_amt,sum(balance) as balance from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";

          $query = $this->db->query($sql);

          $cash=$query->row()->amount_paid-$cash_return;
          $cash=to_currency($cash);

          $card_amount=$query->row()->card_amt;
          $card_amount=to_currency($card_amount);

          $credit_amount=$query->row()->balance;
          $credit_amount=to_currency($credit_amount);


//hcare_pharma_credit_payment
		$sql="select sum(amount) as sum from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate'";

		$query = $this->db->query($sql);
        
		$amount=$query->row()->sum;
		$credit_payment=to_currency($amount);

        return array($cash,$card_amount,$credit_amount,$credit_payment);
    }

    public function totalCredit(){

         $sql="select sum(balance) as balance from hcare_pharma_invoice where payment_mode ='CREDIT' and balance >0 and status=0";

         $query = $this->db->query($sql);

         $balance=$query->row()->balance;
         $balance=to_currency($balance);


         $sql="select sum(amount) as sum, sum(card_amt) as card_amt from hcare_pharma_credit_payment where status=0";

		$query = $this->db->query($sql);
        
		$amount=$query->row()->sum;
		$card_amt=$query->row()->card_amt;
		$credit_amount=to_currency($amount+$card_amt);

         // $sql="select sum(amount) as credit_pay from hcare_pharma_credit_payment where status=0";
          
         // $sql="SELECT SUM(b.`amount`) AS credit_pay FROM `hcare_pharma_invoice` `a` JOIN `hcare_pharma_credit_payment` `b` ON `a`.`id` = `b`.`bill_no` WHERE `a`.`cust_type` != 'IP' AND `a`.`payment_mode`!='BRANCH' AND `a`.`balance` > '0' AND `a`.`status` = '0' AND `b`.`status` = '0'";

         //  $query = $this->db->query($sql);

         //  $credit_pay=$query->row()->credit_pay;
         //  $credit_pay=to_currency($credit_pay);

          $balance_total=$balance-$credit_amount;
          $balance_total=to_currency($balance_total);

          return $balance_total;

    }

    public function daily_bill_collection($fromdate,$todate,$user_id = null){


//hcare_pharma_invoive(return)
          $sql="select sum(amount_paid) as amount_paid,sum(card_amt) as card_amt,sum(balance) as balance,sum(checque_amt) as checque_amt,sum(net_total) as net_total,sum(upi_amt) as upi_amt from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";

          if(!empty($user_id)) $sql .= " and ".$user_id;

          $query = $this->db->query($sql);

          $cash_return=$query->row()->amount_paid;
          $card_return=$query->row()->card_amt;
          $credit_return=$query->row()->balance;
          $cheque_return=$query->row()->checque_amt;
          $upi_return=$query->row()->upi_amt;

          $net_total_return=$query->row()->net_total;

//hcare_pharma_invoive
          $sql="select sum(amount_paid) as amount_paid,sum(card_amt) as card_amt,sum(balance) as balance,sum(checque_amt) as checque_amt,sum(net_total) as net_total,sum(upi_amt) as upi_amt from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";

          if(!empty($user_id)) $sql .= " and ".$user_id;

          $query = $this->db->query($sql);

          $cash=$query->row()->amount_paid-$cash_return;
          $cash=to_currency($cash);

          $card_amount=$query->row()->card_amt-$card_return;
          $card_amount=to_currency($card_amount);

          $credit_amount=$query->row()->balance-$credit_return;
          $credit_amount=to_currency($credit_amount);

          $checque_amount=$query->row()->checque_amt-$cheque_return;
          $checque_amount=to_currency($checque_amount);

           $upi_amount=$query->row()->upi_amt-$upi_return;
          $upi_amount=to_currency($upi_amount);

          $net_total=$query->row()->net_total-$net_total_return;
          $net_total=to_currency($net_total);

/*... net total including returns ...*/
          $net_total_inc_return=$query->row()->net_total;
          $net_total_inc_return=to_currency($net_total_inc_return);
/*... net total including returns ...*/


//hcare_pharma_credit_payment
		$sql="select sum(amount) as sum, sum(card_amt) as card_amt,sum(upi_amt) as upi_amt from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";

		if(!empty($user_id)) $sql .= " and ".$user_id;

		$query = $this->db->query($sql);
        
		$amount=$query->row()->sum;
		$card_amt=$query->row()->card_amt;
		$upi_amt=$query->row()->upi_amt;
		$credit_payment=to_currency($amount+$card_amt+$upi_amt);

		// $total_collection=$net_total+$credit_payment;
		 $total_collection=$net_total;

		$total_collection=to_currency($total_collection);

		$total_amount_received=$cash+$card_amount+$checque_amount+$upi_amount+$credit_payment;
		$total_amount_received=to_currency($total_amount_received);

/*... total collection incliding returns ...*/
		$total_collection_inc_return=$net_total_inc_return;
		$total_collection_inc_return=to_currency($total_collection_inc_return);
/*... total collection incliding returns ...*/

        return array($cash,$card_amount,$credit_amount,$checque_amount,$credit_payment,$total_collection,$total_amount_received,$net_total_return,$total_collection_inc_return,$amount,$card_amt,$upi_amount,$upi_amt);

    }

    public function searchdistinct_gst($criteria){
	
		
		$this->db->distinct();
		$this->db->select('gst_id');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->order_by("gst_id", "asc"); 
		$query=$this->db->get('hcare_pharma_invoice_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i]= $row->gst_id;
				
				
				$i++;
			}
		}
		return $billInfo;
	}

    // public function seprated_gst_total($bill_no=null,$gst_id=null,$sales_mode=null){

    //      //hcare_pharma_invoice
    //       $sql="select sum(total) as total,sum(total_gst) as gst_amt,sum(total_cgst) as cgst_amt,sum(total_sgst) as sgst_amt ,sum(total_flood_cess) as flood_cess_amt from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and gst_id='$gst_id' and sales_mode='".$sales_mode."'";

    //       $query = $this->db->query($sql);

    //       //gst percentage
    //      $sql_sales="select gst_per from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and gst_id='$gst_id' and sales_mode='Sales'";

    //       $query_sales = $this->db->query($sql_sales);
          

    //       $total=$query->row()->total;
    //       $total=to_currency($total);

    //       $gst_amt=$query->row()->gst_amt;
    //       $gst_amt=to_currency($gst_amt);

    //       $cgst_amt=$query->row()->cgst_amt;
    //       $cgst_amt=to_currency($cgst_amt);

    //       $sgst_amt=$query->row()->sgst_amt;
    //       $sgst_amt=to_currency($sgst_amt);

    //        //flood cess
    //       $flood_cess_amt=$query->row()->flood_cess_amt;
    //       $flood_cess_amt=to_currency($flood_cess_amt);
    //       //flood cess

    //        $taxable_value=$total-($gst_amt+$flood_cess_amt);
    //       $taxable_value=to_currency($taxable_value);
    //       if (!empty($query_sales->row()->gst_per)) {
    //       	$gst_per=$query_sales->row()->gst_per;
    //       }
    //       else{
    //       	$gst_per="";
    //       }
          


    //       return array($taxable_value,$gst_id,$gst_per,$cgst_amt,$sgst_amt,$flood_cess_amt);

    // }

    // public function seprated_net_gst_total($bill_no=null,$gst_id=null){

    //      //hcare_pharma_invoive Sales
    //       $sql="select sum(total) as sales_total,sum(total_gst) as sales_gst_amt,sum(total_cgst) as sales_cgst_amt,sum(total_sgst) as sales_sgst_amt,gst_per,sum(total_flood_cess) as sales_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and gst_id='$gst_id' and sales_mode='Sales'";

    //       $query = $this->db->query($sql);

    //       $sales_total=$query->row()->sales_total;
    //       $sales_total=to_currency($sales_total);

    //       $sales_gst_amt=$query->row()->sales_gst_amt;
    //       $sales_gst_amt=to_currency($sales_gst_amt);

    //       $sales_cgst_amt=$query->row()->sales_cgst_amt;
    //       $sales_cgst_amt=to_currency($sales_cgst_amt);

    //       $sales_sgst_amt=$query->row()->sales_sgst_amt;
    //       $sales_sgst_amt=to_currency($sales_sgst_amt);
    //     //food cess
    //       $sales_flood_cess=$query->row()->sales_flood_cess;
    //       $sales_flood_cess=to_currency($sales_flood_cess);
    //     //flood cess
    //       $sales_taxable_value=$sales_total-($sales_gst_amt+$sales_flood_cess);
    //       $sales_taxable_value=to_currency($sales_taxable_value);

    //       $gst_per=$query->row()->gst_per;


    //       //hcare_pharma_invoive Return
    //       $sql="select sum(total) as return_total,sum(total_gst) as return_gst_amt,sum(total_cgst) as return_cgst_amt,sum(total_sgst) as return_sgst_amt,sum(total_flood_cess) as return_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and gst_id='$gst_id' and sales_mode='Return'";

    //       $query = $this->db->query($sql);

    //       $return_total=$query->row()->return_total;
    //       $return_total=to_currency($return_total);

    //       $return_gst_amt=$query->row()->return_gst_amt;
    //       $return_gst_amt=to_currency($return_gst_amt);

    //       $return_cgst_amt=$query->row()->return_cgst_amt;
    //       $return_cgst_amt=to_currency($return_cgst_amt);

    //       $return_sgst_amt=$query->row()->return_sgst_amt;
    //       $return_sgst_amt=to_currency($return_sgst_amt);

    //     //food cess
    //       $return_flood_cess=$query->row()->return_flood_cess;
    //       $return_flood_cess=to_currency($return_flood_cess);
    //     //flood cess

    //       $return_taxable_value=$return_total-($return_gst_amt+$return_flood_cess);
    //       $return_taxable_value=to_currency($return_taxable_value);


    //       $net_taxable_value=$sales_taxable_value-$return_taxable_value;
    //       $net_cgst_amt=$sales_cgst_amt-$return_cgst_amt;
    //       $net_sgst_amt=$sales_sgst_amt-$return_sgst_amt;

    //       $net_flood_cess=$sales_flood_cess-$return_flood_cess;//flood cess


    //       return array($net_taxable_value,$gst_id,$gst_per,$net_cgst_amt,$net_sgst_amt,$net_flood_cess);

    // }


    public function seprated_gst_total($criteria=null,$gst_id=null,$sales_mode=null){



 		$this->db->select('sum(total) as total');
 		$this->db->select('sum(total_gst) as gst_amt');
 		$this->db->select('sum(total_cgst) as cgst_amt');
 		$this->db->select('sum(total_sgst) as sgst_amt');
 		$this->db->select('sum(total_flood_cess) as flood_cess_amt');


		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->where('sales_mode',$sales_mode);

		$query=$this->db->get('hcare_pharma_invoice_items');


		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){


	          $total=$row->total;
	          $total=to_currency($total);

	          $gst_amt=$row->gst_amt;
	          $gst_amt=to_currency($gst_amt);

	          $cgst_amt=$row->cgst_amt;
	          $cgst_amt=to_currency($cgst_amt);

	          $sgst_amt=$row->sgst_amt;
	          $sgst_amt=to_currency($sgst_amt);

	          $flood_cess_amt=$row->flood_cess_amt;
	          $flood_cess_amt=to_currency($flood_cess_amt);

	          $taxable_value=$total-($gst_amt+$flood_cess_amt);
	          $taxable_value=to_currency($taxable_value);

	          $gst_per = $this->commonDBFunctions->getidToValue('gst','id',$gst_id,'pharma_gst');


				$billInfo[0]= $taxable_value;
				$billInfo[1]= $gst_id;
				$billInfo[2]= $gst_per;
				$billInfo[3]= $cgst_amt;
				$billInfo[4]= $sgst_amt;
				$billInfo[5]= $flood_cess_amt;
				
				$i++;
			}
		}
		
		return $billInfo;


    }


    public function seprated_net_gst_total($criteria=null,$gst_id=null){


 		$this->db->select('sum(total) as sales_total');
 		$this->db->select('sum(total_gst) as sales_gst_amt');
 		$this->db->select('sum(total_cgst) as sales_cgst_amt');
 		$this->db->select('sum(total_sgst) as sales_sgst_amt');
 		$this->db->select('sum(total_flood_cess) as sales_flood_cess');

 	


		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->where('sales_mode','Sales');

		$query=$this->db->get('hcare_pharma_invoice_items');


		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){


	          $sales_total=$row->sales_total;
	          $sales_total=to_currency($sales_total);

	          $sales_gst_amt=$row->sales_gst_amt;
	          $sales_gst_amt=to_currency($sales_gst_amt);

	          $sales_cgst_amt=$row->sales_cgst_amt;
	          $sales_cgst_amt=to_currency($sales_cgst_amt);

	          $sales_sgst_amt=$row->sales_sgst_amt;
	          $sales_sgst_amt=to_currency($sales_sgst_amt);

	          $sales_flood_cess=$row->sales_flood_cess;
	          $sales_flood_cess=to_currency($sales_flood_cess);

	          $sales_taxable_value=$sales_total-($sales_gst_amt+$sales_flood_cess);
	          $sales_taxable_value=to_currency($sales_taxable_value);

	          $gst_per = $this->commonDBFunctions->getidToValue('gst','id',$gst_id,'pharma_gst');

			}
		}


 		$this->db->select('sum(total) as return_total');
 		$this->db->select('sum(total_gst) as return_gst_amt');
 		$this->db->select('sum(total_cgst) as return_cgst_amt');
 		$this->db->select('sum(total_sgst) as return_sgst_amt');
	    $this->db->select('sum(total_flood_cess) as return_flood_cess');

		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->where('sales_mode','Return');

		$query=$this->db->get('hcare_pharma_invoice_items');


		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){


	          $return_total=$row->return_total;
	          $return_total=to_currency($return_total);

	          $return_gst_amt=$row->return_gst_amt;
	          $return_gst_amt=to_currency($return_gst_amt);

	          $return_cgst_amt=$row->return_cgst_amt;
	          $return_cgst_amt=to_currency($return_cgst_amt);

	          $return_sgst_amt=$row->return_sgst_amt;
	          $return_sgst_amt=to_currency($return_sgst_amt);

	          $return_flood_cess=$row->return_flood_cess;
	          $return_flood_cess=to_currency($return_flood_cess);

	          $return_taxable_value=$return_total-($return_gst_amt+$return_flood_cess);
	          $return_taxable_value=to_currency($return_taxable_value);

	          $gst_per = $this->commonDBFunctions->getidToValue('gst','id',$gst_id,'pharma_gst');

			}
		}


          $net_taxable_value=$sales_taxable_value-$return_taxable_value;
          $net_cgst_amt=$sales_cgst_amt-$return_cgst_amt;
          $net_sgst_amt=$sales_sgst_amt-$return_sgst_amt;
          $net_flood_cess=$sales_flood_cess-$return_flood_cess;//flood cess


		    $billInfo[0]= $net_taxable_value;
		    $billInfo[1]= $gst_id;
			$billInfo[2]= $gst_per;
			$billInfo[3]= $net_cgst_amt;
			$billInfo[4]= $net_sgst_amt;
			$billInfo[5]= $net_flood_cess;



          return $billInfo;

    }





    public function searchdistinct_h1n_shld_x_item($search){
	
	    $this->db->distinct();
		$this->db->select("a.`id` , b.`item_id`");
	
	$this->db->from('pharma_brand a');
	
	$this->db->join('pharma_invoice_items b', 'a.id = b.item_id','left');
	
	if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
		$this->db->order_by("b.item_id", "desc"); 
		
		$query = $this->db->get();
	
		$options = array();
		$i=0;
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->item_id;
			$options[$i][2]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');
			
			$i++;
		}

		return $options;
	
	}
	public function getPrescriptionIp($criteria=null){
	
   		$this->db->select("a.`id` , a.`ipno` , a.`brand_id` , a.`brand_name` , a.`med_course` , a.`med_days` , a.`date_time` , a.`user`, a.`update_history` , a.`status` , a.`invoice_id` , b.`doc_id` , d.`first_name` as doc_first_name , d.`last_name` as doc_last_name, c.`first_name` as patient_first_name, c.`middle_name` as patient_middle_name, c.`last_name` as patient_last_name,a.`qty`");


		$this->db->from('hcare_ip_medicines_prescribed a');
		$this->db->join('hcare_ip_info b', 'a.ipno = b.id','left');
		$this->db->join('hcare_op_patient_info c', 'b.opno = c.`id`','left');
		$this->db->join('emp_info d', 'b.doc_id = d.`id`','left');
		
		
		if(!empty($criteria)){
				for($k=0;$k<count($criteria);$k++){
				
					$this->db->where($criteria[$k]);
				
				}
			} 
		$this->db->where('a.status','0');
		$this->db->order_by("a.id", "asc");
		
		$query = $this->db->get();
	
		$options = array();
		$i=0;

		foreach ($query->result() as $row)
		{

			$options[$i][0] = $row->id;
			$options[$i][1] = $row->ipno;
			$options[$i][2] = $row->brand_id;
			$options[$i][3] = $row->brand_name ;
			$options[$i][4] = $row->med_course  ;
			$options[$i][5] = $row->med_days;
			$options[$i][6] = $row->date_time;
			$options[$i][7] = $row->user;
			$options[$i][8] = $row->update_history;
			$options[$i][9] = $row->status;
			$options[$i][10] = "";
			$options[$i][11] = $row->doc_id;
			$options[$i][12] = $row->doc_first_name;
			$options[$i][13] = $row->doc_last_name;
			$options[$i][14] = $row->patient_first_name;
			$options[$i][15] = $row->patient_middle_name;
			$options[$i][16] = $row->patient_last_name;
			$options[$i][17]= $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'hcare_pharma_brand');
			$options[$i][18] = $row->invoice_id;
			$options[$i][19] = $row->qty;
			
			$i++;
		}			 		

		return $options;
	}

	function update_ip_prescribed($id,$bill_id){
	
		
			$condition	= array('id' => $id);
		
		    $data = array( 'invoice_id' => "$bill_id");
		
			$result=$this->db->update('hcare_ip_medicines_prescribed', $data,$condition);

			if($result) {
				return  $this->lang->line('success');
			}else{
				return  $this->lang->line('failed');
			}

	}

	public function purchased_medicines_list($criteria=null){
	
   		$this->db->select("a.`id` , a.`cust_type` , a.`op_visit_id` , a.`op_no` , a.`ip_no` , a.`doctor` , a.`cust_name` , a.`bill_date`, b.`id` as billItemId, b.`bill_id`, b.`bill_date`, b.`item_id`, b.`batch_id`, b.`sales_mode`, b.`batch_no`, b.`expiry`, b.`quantity`, c.`brand`");


		$this->db->from('hcare_pharma_invoice a');
		$this->db->join('hcare_pharma_invoice_items b', 'a.id = b.bill_id','left');
		$this->db->join('hcare_pharma_brand c', 'c.id = b.item_id','left');
		
		if(!empty($criteria)){
				for($k=0;$k<count($criteria);$k++){
				
					$this->db->where($criteria[$k]);
				
				}
			} 
		$this->db->where('a.status','0');
		$this->db->order_by("c.brand", "asc");
		
		$query = $this->db->get();
		
		$options = array();
		$i=0;

		foreach ($query->result() as $row)
		{

			$options[$i][0] = $row->id;
			$options[$i][1] = $row->bill_date;
			$options[$i][2] = $row->item_id;
			$options[$i][3]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'hcare_pharma_brand');
			$options[$i][4] = $row->batch_id;
			$options[$i][5] = $row->batch_no ;
			$options[$i][6] = $row->expiry;
			$options[$i][7] = $row->billItemId;
			$options[$i][8] = $row->quantity;
			
			$i++;
		}			 		

		return $options;
	}

	public function searchdistinct_hsn_no($criteria){
	
		$this->db->distinct();
		$this->db->select('hsn_no');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->where("hsn_no !=", "");

		$this->db->order_by("id", "asc"); 
		$query=$this->db->get('hcare_pharma_invoice_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
				
				$billInfo[$i]= $row->hsn_no;	
				
				$i++;
			}
		}
		return $billInfo;
	}
   
    // public function searchdistinct_hsn_no_base_details($bill_no,$hsn_no,$sales_mode){


    //      $sql="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and hsn_no='".$hsn_no."' and sales_mode='".$sales_mode."'";

    //      $query = $this->db->query($sql);

    //      $billInfo=array();

    //      $taxable_amt= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

    //      $billInfo[0]=$hsn_no;
    //      $billInfo[1]=$this->commonDBFunctions->getidToValue('description','hsn_code',$hsn_no,'hcare_pharma_hsn_codes');
    //      $billInfo[2]=$query->row()->quantity;
    //      $billInfo[3]=to_currency($query->row()->total);
    //      $billInfo[4]=to_currency($taxable_amt);
    //      $billInfo[5]=to_currency($query->row()->total_cgst);
    //      $billInfo[6]=to_currency($query->row()->total_sgst);
    //      $billInfo[7]=to_currency($query->row()->total_flood_cess);

    //      return $billInfo;

    // }

    public function searchdistinct_brand_no_hsn_no($criteria){
	
		$this->db->distinct();
		$this->db->select('item_id');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}

		$this->db->where("hsn_no =", "");

		$this->db->order_by("id", "asc"); 
		$query=$this->db->get('hcare_pharma_invoice_items');

		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
				
				$billInfo[$i]= $row->item_id;
					
				$i++;
			}
		}
		return $billInfo;
	}

	// public function searchdistinct_brand_no_hsn_no_base_details($bill_no,$item_id,$sales_mode){


 //         $sql="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and item_id='".$item_id."' and sales_mode='".$sales_mode."' and hsn_no=''";

 //         $query = $this->db->query($sql);

 //         $billInfo=array();

 //         $taxable_amt= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

 //         $billInfo[0]='';
 //         $billInfo[1]=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'hcare_pharma_brand');
 //         $billInfo[2]=$query->row()->quantity;
 //         $billInfo[3]=to_currency($query->row()->total);
 //         $billInfo[4]=to_currency($taxable_amt);
 //         $billInfo[5]=to_currency($query->row()->total_cgst);
 //         $billInfo[6]=to_currency($query->row()->total_sgst);
 //         $billInfo[7]=to_currency($query->row()->total_flood_cess);

 //         return $billInfo;

 //    }

    // public function searchdistinct_hsn_no_base_details_summary($bill_no,$hsn_no){


    //      $sql="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and hsn_no='".$hsn_no."' and sales_mode='Sales'";

    //      $query = $this->db->query($sql);

    //      $billInfo=array();

    //      $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

    //      $billInfo[0]=$hsn_no;
    //      $billInfo[1]=$this->commonDBFunctions->getidToValue('description','hsn_code',$hsn_no,'hcare_pharma_hsn_codes');


    //      $sql1="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and hsn_no='".$hsn_no."' and sales_mode='Return'";

    //      $query1 = $this->db->query($sql1);

    //      $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));



    //      $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
    //      $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
    //      $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
    //      $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
    //      $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
    //      $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);

    //      return $billInfo;

    // }

    // public function searchdistinct_brand_no_hsn_no_base_details_summary($bill_no,$item_id){


    //      $sql="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and item_id='".$item_id."' and sales_mode='Sales' and hsn_no = ''";

    //      $query = $this->db->query($sql);

    //      $billInfo=array();

    //      $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

    //      $billInfo[0]='';
    //      $billInfo[1]=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'hcare_pharma_brand');

    //      $sql1="select sum(quantity) as quantity,sum(total) as total,sum(total_gst) as total_gst,sum(total_cgst) as total_cgst,sum(total_sgst) as total_sgst,sum(total_flood_cess) as total_flood_cess from hcare_pharma_invoice_items where  status=0 and ".$bill_no." and item_id='".$item_id."' and sales_mode='Return' and hsn_no = ''";

    //      $query1 = $this->db->query($sql1);

    //      $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));


    //      $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
    //      $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
    //      $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
    //      $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
    //      $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
    //      $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);


    //      return $billInfo;

    // }

	function update_op_prescribed($id,$bill_id){
	
		
			$condition	= array('id' => $id);
		
		    $data = array( 'invoice_id' => "$bill_id");
		
			$result=$this->db->update('hcare_medicine_prescribed', $data,$condition);

			if($result) {
				return  $this->lang->line('success');
			}else{
				return  $this->lang->line('failed');
			}

	}
public function sales_total($criteria){
	
		
		
		$this->db->select('sum(`net_total`) as `sales_sum`');
		
		
		if(!empty($criteria)){
		// var_dump($criteria);
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		 
		$query=$this->db->get('hcare_pharma_invoice');
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i][0]= $row->sales_sum;
				
				$i++;
			}
		}
		return $billInfo;
	}
function searchBillItemsDistinctCount($search = null){
	
		
    	$this->db->distinct();
    	$this->db->select('item_id');

		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		 $query = $this->db->get('pharma_invoice_items');
		 // echo $this->db->last_query();
		 return $query->num_rows();
	
	}



function add_DraftBill($balance,$auth_user_id = null){
	
		$date=$this->input->post('date');
		 date_default_timezone_set('Asia/Kolkata');
		 
		$cust_type= $this->input->post('customer_type');
		$payment_type= $this->input->post('payment_type');
		$discount_type=$this->input->post('bill_disc_type');
		$bill_disc_value=$this->input->post('bill_disc_value');
			  $user_id=$this->session->userdata('user_id');

	//var_dump($user_id)	;exit();
		if($cust_type == 'OP'){ $opno=$this->input->post('op_no');
		}else{ $opno=0;}
		
		  // if(($cust_type == 'DIRECT' || $cust_type == 'OP') && $payment_type == "CREDIT"){
		  
		  //     $sanctioned_by=$this->input->post('sanc_by_hidden');
			 //  $auth_remarks=$this->input->post('auth_remarks_hidden');
			 //  $user_id=$auth_user_id;
		  // }else if($discount_type !="" && $bill_disc_value>10){
		  
		  //     $sanctioned_by=$this->input->post('sanc_by_hidden');
			 //  $auth_remarks=$this->input->post('auth_remarks_hidden');
			 //  $user_id=$auth_user_id;
		  // }else{
		  //     $sanctioned_by='';
			 //  $auth_remarks='';
			 //  $user_id=$this->session->userdata('user_id');
			if($cust_type == 'IP'){
			  $ipno=$this->input->post('ip_no');
			 $opno= $this->commonDBFunctions->getidToValue('opno','id',$ipno,'ip_info');
			}
		  // }

		  /*..... sales_amt ......*/
			 $sales_amt=$this->input->post('sales_amt');
			 if(empty($sales_amt)) $sales_amt=0;

          /*..... return_amt ......*/
			 $return_amt=$this->input->post('return_amt');
			 if(empty($return_amt)) $return_amt=0;


		  /*..... checque_no ......*/
			 $checque_no=$this->input->post('checque_no');
			 if(empty($checque_no)) $checque_no=0;

			 /*..... checque_amt .....*/
			 $checque_amt=$this->input->post('checque_amt');
			 if(empty($checque_amt)) $checque_amt=0;

			 /*..... card_amt .....*/
			 $card_amt=$this->input->post('card_amt');
			 if(empty($card_amt)) $card_amt=0;

			 /*..... card_amt .....*/
			 $ref_id=$this->input->post('branch');
			 if(empty($ref_id)) $ref_id=0;

			 /*..... roundstatus .....*/
			 $roundstatus=$this->input->post('roundstatus');
			 if(empty($roundstatus)) $roundstatus=0;

			 /*..... round_amt .....*/
			 $round_amt=$this->input->post('round_amt');
			 if(empty($round_amt)) $round_amt=0;

			 /*..... doc_id .....*/
			 $doc_id=$this->input->post('doc_id');
			 if(empty($doc_id)) $doc_id=0;
			 $free_bill= $this->input->post('free_bill');
			 if(empty($free_bill)){
			 	$free_bill=0;
			 }
			  /*..... upi_amt .....*/
			 $upi_amt=$this->input->post('upi_amt');
			 if(empty($upi_amt)) $upi_amt=0;
	//	var_dump($user_id);exit() ;

		$data =   array('cust_type' 		=> $this->input->post('customer_type'),
		                'op_visit_id'		=>$this->input->post('op_id'),
		                'op_no'			    =>$opno,
                        'ip_no'			    =>$this->input->post('ip_no'),
	                    'cust_name'   	 	=> $this->input->post('cust_name'),
		                'doctor' 		    => $this->input->post('doctor'),
		                'doc_id' 		    => $doc_id,
		                'bill_date'   	 	=> date("Y-m-d H:i:s"),
						'sales_amt'   		=> $sales_amt,
		                'gst' 			    => $this->input->post('tot_gst'),
		                'cgst'   		    => $this->input->post('tot_cgst'),
		                'sgst'   		    => $this->input->post('tot_sgst'),		
	                    'return_amount'   	=> $return_amt,
		                'bill_total'   		=> $this->input->post('bill_total'),
		                'discount_type'  	=> !empty($this->input->post('bill_disc_type'))?$this->input->post('bill_disc_type'):'',
		                'discount_value'   	=> $this->input->post('bill_disc_value'),		
		                'discount_amt' 		=> $this->input->post('disc_amt'),
	                    'net_total_before'  => $this->input->post('net_total'),
	                    'net_total'         => $this->input->post('round_net_amt'),
	                    'rounded_status'    => $roundstatus,
	                    'round_amt'         => $round_amt,
		                'payment_mode'   	=> $this->input->post('payment_type'),
		                'checque_no'   		=> $checque_no,
		                'checque_amt'  		=> $checque_amt,
		                'card_amt'   		=> $card_amt,
		                'amount_paid'   	=> $this->input->post('amount_paid'),
		                'balance'   		=> $balance,		
		                'ref_id' 		    => $ref_id,
	                    'remarks'   		=> $this->input->post('remarks'),
			            'sales_mode' 		=> $this->input->post('sales_mode_selected'),
						// 'sanctioned_by'   	=> $sanctioned_by,
						// 'auth_remarks'   	=> $auth_remarks,
		                'user_id'   		=> $user_id,
		                 'flood_cess'       => $this->input->post('tot_flood_cess'),
		                 'free_bill'        => $free_bill,
		                 'upi_amt'   		=> $upi_amt,
 
		              );
			
		
		$result=$this->db->insert('pharma_invoice_draft', $data);
		//echo $this->db->last_query();
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	}
	function add_DraftBillItems($item,$bill_id){


	   
		$date=$this->input->post('date');

		if(!empty($item[11]) && !empty($item[12]))
		    {
		      $total_gst= $item[20];
              $total_sgst= $item[21];
              $total_cgst= $item[22];
              $total_sellp= $item[6]*$item[8];
              $total_flood_cess= $item[25];//flood cess 1%
 
		    }
		else{
			  $total_gst='';
              $total_sgst='';
              $total_cgst='';
              $total_sellp= ''; 
              $total_flood_cess='';
		    }
		

  $expiry_field = $item[4];

    // if(!empty($expiry_field)){

				// 						        // $expiry_field = str_replace('/', '-', $expiry_field);
				// 						        // $newDate = explode( "-" , $expiry_field);
				// 						        // $output = $newDate[1]."-".$newDate[0]."-".'1';
				// 						        // $item[3]=date("t-m-Y", strtotime($output));



    //                 $expiry_field = $item[4];
    //                 $expiry_field = str_replace('/', '-', $expiry_field);
    //                 $newDate = explode( "-" , $expiry_field);
    //                 $output = $newDate[1]."-".$newDate[0]."-".'1';
				// 			                    // $output = '1'."-".$newDate[0]."-".$newDate[1];
				// 			                    // $item[$i][3]=date("t-m-Y", strtotime($output));

				// 			                    // $date = date_create_from_format('d-m-Y', $output);

			 //        $year_obj = DateTime::createFromFormat('y', $newDate[1]);
			 //        $year = $year_obj->format('Y');
			 //        $month = $newDate[0];
			 //        $date_exp = "1";

			 //        $s = $date_exp."/".$month."/".$year;
				// 	$date_exp = date_create_from_format('d/m/Y', $s);
				// 	$output = $date_exp->format('Y-m-t');
				// 	$item[4] = $output;



    // }else $item[4]='';




		
		$data = array('bill_id'    => $bill_id,
	   		      'bill_date' => date("Y-m-d",strtotime($date)),
			      'item_id'   =>$item[0],
			      'batch_id'   =>$item[18],
	              'sales_mode'   => $item[1],
			      'batch_no'    =>$item[3],
			      'hsn_no'     =>$item[19],
			      'expiry '         =>date("Y-m-d",strtotime($item[4])),
			      'selling_unit'   	   =>$item[5],		
			      'quantity' 	   => $item[6],	    				
			      'sellp'  		   =>$item[8],
			      'total_sellp'    =>$total_sellp,	
			      'gst_id'  	   =>$item[11],
			      'gst_per'  	   =>$item[12],
			      'sgst_per'  	   =>$item[13],
			      'cgst_per'       =>$item[14],
			      'gst_amt'        =>to_currency($item[15]),
			      'total_gst'      =>$total_gst,
			      'sgst_amt'       =>to_currency($item[16]),
			      'total_sgst'     =>to_currency($item[16]),
			      'cgst_amt'       =>to_currency($item[17]),	
			      'total_cgst'     =>to_currency($item[17]),
			      'mrp'  		   =>$item[7],				
	    		  'total'          => $item[9],
	    		  'flood_cess_amt'       =>to_currency($item[24]),
	    		  'total_flood_cess'     =>$total_flood_cess,
			);

		// var_dump($data);exit();
				
			
		
		$result=$this->db->insert('pharma_invoice_draft_items', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
	
	}

	public function search_DraftBill($criteria,$type = null,$limit=null,$offset=null){

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
		
		$query=$this->db->get('pharma_invoice_draft');
		
		$daft_billInfo=array();
		$ip_bill_status=0;
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
			$where=array();
			$where[]="bill_no = ".$row->id;
			$where[] ="status = 0";
				
				$creditInfo=$this->getCreditPayment($where);
				$credit=0;
				if(!empty($creditInfo)){
				
					for($k=0;$k<count($creditInfo);$k++){
					
						$credit +=$creditInfo[$k][3];
					}
				
				}
				
				$amount_paid=$row->amount_paid;
				$balance=$row->balance;
                                $rem_balance=$balance-$credit;
                                $new_amount=$amount_paid+$credit;
				
				if($row->cust_type == "IP"){
				
				   $discharge_date=$this->commonDBFunctions->getidToValue('discharge_date','id',$row->ip_no,'ip_info');
                   $ip_bill_status=$this->commonDBFunctions->getidToValue('bill_status','id',$row->ip_no,'ip_info');

				}else $discharge_date='0000-00-00';
			
				if($type == 'credit' && $rem_balance>0){
				
					$status=1;
				
				}else if($type == 'credit' && $rem_balance<=0){
				
					$status=0;
					
				}else $status=1;
				
				if($type == 'credit' && $discharge_date!='0000-00-00'){
				   $status=0;
				}
				
				if($status ==1) {
				
				
			
				$daft_billInfo[$i][0]= $i+1;
				$daft_billInfo[$i][1]= $row->id;
				$daft_billInfo[$i][2]= $row->cust_type;
				$daft_billInfo[$i][3]= $row->op_visit_id;
				$daft_billInfo[$i][4]= $row->cust_name;
				$daft_billInfo[$i][5]= $row->bill_date;
				
				$daft_billInfo[$i][6]= $row->sales_amt;				
				$daft_billInfo[$i][9]= $row->return_amount;
				
				$daft_billInfo[$i][10]= $row->bill_total;
				$daft_billInfo[$i][11]= $row->discount_type;
				$daft_billInfo[$i][12]= $row->discount_value;
				$daft_billInfo[$i][13]= $row->discount_amt;
				
				
				
				$daft_billInfo[$i][14]= $row->net_total;
				$daft_billInfo[$i][15]= $row->payment_mode;
				$daft_billInfo[$i][16]= $row->checque_no;
				$daft_billInfo[$i][17]= $row->checque_amt;;
				$daft_billInfo[$i][18]= $row->card_amt;;
				
				$daft_billInfo[$i][19]= $amount_paid;
				$daft_billInfo[$i][20]= $balance;
				$daft_billInfo[$i][21]= $row->ref_id;
				$daft_billInfo[$i][22]= $this->commonDBFunctions->getidToValue('branch_name','id',$row->ref_id,'pharma_branch');
				$daft_billInfo[$i][23]= $row->remarks;
				$daft_billInfo[$i][24]= $row->user_id;
				$daft_billInfo[$i][25]= $this->commonDBFunctions->getidToValue('user_name','id',$row->user_id,'users');
				$daft_billInfo[$i][26]= $row->cancellation_details;
				$daft_billInfo[$i][27]= $row->cancellation_date;
				$daft_billInfo[$i][28]= $row->status;
								
				$daft_billInfo[$i][29]= $credit;
				
				$doc_id= $this->commonDBFunctions->getidToValue('doc_id','id',$row->op_visit_id,'op_visit_info');
				if($row->cust_type=="OP"){
				$daft_billInfo[$i][30]=$this->commonDBFunctions->getidToValue('title','id',$doc_id,'hcare_emp_info')." ".$this->commonDBFunctions->getidToValue('first_name','id',$doc_id,'hcare_emp_info')." ".$this->commonDBFunctions->getidToValue('last_name','id',$doc_id,'hcare_emp_info');
				}else{
				$daft_billInfo[$i][30]= $row->doctor;
				}
                                $daft_billInfo[$i][31]=$new_amount;
                                $daft_billInfo[$i][32]=$rem_balance;
                                $daft_billInfo[$i][33]= $row->ip_no;
				if($row->cust_type == "OP") {
					$daft_billInfo[$i][34]= $opno=$this->commonDBFunctions->getidToValue('opno','id',$row->op_visit_id,'op_visit_info');
				        $daft_billInfo[$i][43]=$this->commonDBFunctions->getidToValue('prefix','id',$opno,'op_patient_info');
				}else{
                                   $daft_billInfo[$i][34]= $row->op_no;
				   $daft_billInfo[$i][37]="";
				}
				   $daft_billInfo[$i][35]= $row->sanctioned_by;
				   $daft_billInfo[$i][36]= $row->auth_remarks;
				   $daft_billInfo[$i][37]= $row->sales_mode;
				   $daft_billInfo[$i][38]= $row->cancelled_by;
				   $daft_billInfo[$i][39]= $this->commonDBFunctions->getidToValue('user_name','id',$row->cancelled_by,'users');

				   $daft_billInfo[$i][40]= $row->rounded_status;
				   $daft_billInfo[$i][41]= $row->net_total_before;
				   $daft_billInfo[$i][42]= $row->round_amt;
				   $daft_billInfo[$i][44]= $row->gst;
				   $daft_billInfo[$i][45]= $row->cgst;
				   $daft_billInfo[$i][46]= $row->sgst;
				   $daft_billInfo[$i][47]= $ip_bill_status;
				   $daft_billInfo[$i][48]= $row->doc_id;
				   $daft_billInfo[$i][49]= $row->flood_cess;
				   $daft_billInfo[$i][50]= $row->free_bill;
				   $daft_billInfo[$i][51]= $this->commonDBFunctions->getidToValue('payment_status','id',$row->op_visit_id,'op_visit_info');


														
				$i++;
			  }
			
			}
		}
		
		return $daft_billInfo;
	
	}
	public function search_DraftBillItems($criteria,$limit=null){
	
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
		
		$query=$this->db->get('pharma_invoice_draft_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row->bill_id;
				$billInfo[$i][2]= $row->bill_date;
				$billInfo[$i][3]= $row->item_id;
				$billInfo[$i][4]= $row->batch_id;
				$billInfo[$i][5]= $row->sales_mode;				
				$billInfo[$i][6]= $row->batch_no;
				$billInfo[$i][7]= $row->expiry;
				$billInfo[$i][8]= $row->selling_unit;
				$billInfo[$i][9]= $row->quantity;
				$billInfo[$i][10]= $row->sellp;			
				$billInfo[$i][11]= $row->total;				
				$billInfo[$i][12]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');;
				$billInfo[$i][13]= $this->commonDBFunctions->getidToValue('manufacturer','id',$row->item_id,'pharma_brand');;
				$billInfo[$i][14]= $row->gst_per;
				$billInfo[$i][15]= $row->sgst_per;
				$billInfo[$i][16]= $row->cgst_per;
				$billInfo[$i][17]= $row->gst_amt;
				$billInfo[$i][18]= $row->sgst_amt;
				$billInfo[$i][19]= $row->cgst_amt;
				$billInfo[$i][20]= $row->mrp;
				$billInfo[$i][21]= $row->gst_id;
				$billInfo[$i][22]= $row->total_sellp;
				$billInfo[$i][23]= $row->total_gst;
				$billInfo[$i][24]= $row->total_sgst;
				$billInfo[$i][25]= $row->total_cgst;
				$billInfo[$i][26]= $this->commonDBFunctions->getidToValue('user_id','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][27]= $this->commonDBFunctions->getidToValue('user_name','id',$billInfo[$i][26],'hcare_users');
				$billInfo[$i][28]= $row->hsn_no;
				$billInfo[$i][29]= $row->total-$row->total_gst;//taxable_amt
				$billInfo[$i][30]= $this->commonDBFunctions->getidToValue('cust_name','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][31]= $this->commonDBFunctions->getidToValue('net_total_before','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][32]= $this->commonDBFunctions->getidToValue('cust_type','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][33]= $this->commonDBFunctions->getidToValue('op_no','id',$row->bill_id,'hcare_pharma_invoice');
				$billInfo[$i][34]= $this->commonDBFunctions->getidToValue('ip_no','id',$row->bill_id,'hcare_pharma_invoice');

							$new_criteria[0] = "brand_id = ".$row->item_id;
							$new_criteria[1] = "batch_number LIKE '%".$row->batch_no."%' ";

				$billInfo[$i][35]=$this->commonDBFunctions->getidToValue_multiple('buyp',$new_criteria,'pharma_batch');

		        $billInfo[$i][36]=$this->commonDBFunctions->getidToValue('op_visit_id','id',$row->bill_id,'hcare_pharma_invoice_draft');
		          $criteria[0]="visit_id = ".$billInfo[$i][36];
		          $criteria[1]="brand_id = ".$row->item_id;

               $billInfo[$i][37]=$this->commonDBFunctions->getidToValue_multiple('id',$criteria,'hcare_medicine_prescribed');
	
                                $billInfo[$i][38]= $row->flood_cess_amt;
				$billInfo[$i][39]= $row->total_flood_cess;


				
				
				
				$i++;
			
			}
		}
		
		return $billInfo;
	
	}
	
function delete_invoice_draft($id,$canc_det){
	
		
			$condition				= array('id' => $id);
		
		
			$date=date("Y-m-d");

			$user_id=$this->session->userdata('user_id');
		
		    $data = array( 'cancellation_details' => "$canc_det",
				           'cancellation_date' 	  => "$date",
				           'cancelled_by' 	      => "$user_id",
				           'status'				  =>1
						
					);
					
		//$result=$this->db->delete('pharma_invoice',$condition);
		
		$result=$this->db->update('pharma_invoice_draft', $data,$condition);
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function delete_invoice_draft_items($bill_id,$status){
	
		
			$condition				= array('bill_id' => $bill_id);
		
		$data = array( 'status'	=>1	);
		
		
		$result=$this->db->update('pharma_invoice_draft_items', $data,$condition);
		//$result=$this->db->delete('pharma_invoice_items',$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}
	function update_invoice_draft_items($bill_id){
	
		
			$condition				= array('bill_id' => $bill_id);
		
		$data = array( 'status'	=>2	);
		
		
		$result=$this->db->update('pharma_invoice_draft_items', $data,$condition);
	//echo ($this->db->last_query());exit();
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}


	function update_DraftBill($balance,$auth_user_id,$status){

	
		$condition				= array('id' => $this->input->post('billid'));
		
		$date=$this->input->post('date');
		
		$cust_type= $this->input->post('customer_type');
		$payment_type= $this->input->post('payment_type');
		
		if($cust_type == 'OP') $opno=$this->input->post('op_no');
		else $opno=0;
		
		  if(($cust_type == 'DIRECT' || $cust_type == 'OP') && $payment_type == "CREDIT"){
		  
		      $sanctioned_by=$this->input->post('sanc_by_hidden');
			  $auth_remarks=$this->input->post('auth_remarks_hidden');
			  $user_id=$auth_user_id;
		  }else{
		      $sanctioned_by='';
			  $auth_remarks='';
			  $user_id=$this->session->userdata('user_id');
			  if($cust_type == 'IP'){
			  $ipno=$this->input->post('ip_no');
			 $opno= $this->commonDBFunctions->getidToValue('opno','id',$ipno,'ip_info');
			}
		  }
		  $free_bill=$this->input->post('free_bill');
		  if(empty($free_bill)){
		  	$free_bill=0;
		  }
		

		$data = array( 'cust_type' 		=> $this->input->post('customer_type'),
						'op_visit_id'	=> $this->input->post('op_id'),
						'op_no' 		=> $opno,
	    				'cust_name'   	 	=> $this->input->post('cust_name'),
						'doctor' 		=> $this->input->post('doctor'),
						//'bill_date '  	 	=> date("Y-m-d h:i:s",strtotime($date))." ".date("H:i:s"),	   
						'sales_amt'   		=>$this->input->post('sales_amt'),
						'gst' 			    => $this->input->post('tot_gst'),
		                'cgst'   		    => $this->input->post('tot_cgst'),
		                'sgst'   		    => $this->input->post('tot_sgst'),		
	    				'return_amount'   	=> $this->input->post('return_amt'),
						'bill_total'   	=>$this->input->post('bill_total'),
						'discount_type'  	=>!empty($this->input->post('bill_disc_type'))?$this->input->post('bill_disc_type'):'',
						'discount_value'   =>$this->input->post('bill_disc_value'),		
						'discount_amt' 	=> $this->input->post('disc_amt'),
	    				'net_total'   		=> $this->input->post('net_total'),
						'payment_mode'  	=> $this->input->post('payment_type'),
						'checque_no'   	=>$this->input->post('checque_no'),
						'checque_amt'  	=>$this->input->post('checque_amt'),
						'card_amt'   		=>$this->input->post('card_amt'),
						'amount_paid'   	=>$this->input->post('amount_paid'),
						'balance'   		=> $balance,		
						'ref_id '			=> $this->input->post('branch'),
	    				'remarks'   		=> $this->input->post('remarks'),
						'sanctioned_by'   		=> $sanctioned_by,
						'auth_remarks'   		=> $auth_remarks,
		                'user_id'   		=> $user_id,
		                'status'            =>$status,
		                'free_bill'         =>$free_bill,
		                'upi_amt'		=>$this->input->post('upi_amt')
					);
		
		$result=$this->db->update('pharma_invoice_draft', $data,$condition);
		//echo $this->db->last_query();
		if($result) {
			return $this->input->post('billid');
		}else{
			return  $this->lang->line('updation_failed');
		}
	}


	function update_op_prescribed_drafted($id,$status){
	
		
			$condition	= array('id' => $id);
		
		    $data = array( 'draft_status' => 1);
		
			$result=$this->db->update('hcare_medicine_prescribed', $data,$condition);

			if($result) {
				return  $this->lang->line('success');
			}else{
				return  $this->lang->line('failed');
			}

	}
	 function getInvoice_draft_Count($search= null)
    {
		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->from("pharma_invoice_draft");
        $count = $this->db->count_all_results();

        return $count;
		
    } 

   function get_patient_allergies($search1)
    {
		$options = array();
		$i=0;
		if(!empty($search1)){
			for($k=0;$k<count($search1);$k++){
			
				$this->db->where($search1[$k]);
			
			}
		}

      
		//$this->db->where('status','0');
	
        $query = $this->db->get('hcare_patient_allergies');
        // echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->opno;			
			$options[$i][2] = $row->visit_id;
            $options[$i][3] = $row->allergic_to;
            $options[$i][4] = $row->description;

			$i++;
		}
		return $options;
		
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

		$query = $this->db->get('pharma_invoice_items');


		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				$billInfo[$i][0]= $row->item_id;
				$billInfo[$i][1]= $row->quantity;
				$billInfo[$i][2]= to_currency($row->total);
				$billInfo[$i][3]= $this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'pharma_brand');
				$billInfo[$i][4] =$this->commonDBFunctions->getidToValue('brand_stock','id', $row->item_id,'hcare_pharma_brand');
				
				
				$i++;
			}
		}
		return $billInfo;

	}
    public function searchdistinct_hsn_no_base_details($criteria=null){
  
       $billInfo=array();
      
	   $sql="select sum( hcare_pharma_invoice_items.quantity) as quantity,sum( hcare_pharma_invoice_items.total) as total,sum( hcare_pharma_invoice_items.total_gst) as total_gst,sum( hcare_pharma_invoice_items.total_cgst) as total_cgst,sum( hcare_pharma_invoice_items.total_sgst) as total_sgst,sum( hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess, hcare_pharma_invoice_items.hsn_no as hsn_no from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and hcare_pharma_invoice.status = 0 and hcare_pharma_invoice_items.status = 0 and (hcare_pharma_invoice_items.hsn_no IS NOT NULL and hcare_pharma_invoice_items.hsn_no != '') group by hcare_pharma_invoice_items.hsn_no";

	       $i=0;

	       

	        $query = $this->db->query($sql); 

	        // if ($query->num_rows() > 0){
			
				foreach ($query->result() as $row){
					
					$taxable_amt[$i]= ($row->total -  ($row->total_gst+$row->total_flood_cess));

	         $billInfo[$i][0]=$row->hsn_no;
	         $billInfo[$i][1]=$this->commonDBFunctions->getidToValue('description','hsn_code',$row->hsn_no,'hcare_pharma_hsn_codes');
	         $billInfo[$i][2]=$row->quantity;
	         $billInfo[$i][3]=to_currency($row->total);
	         $billInfo[$i][4]=to_currency($taxable_amt[$i]);
	         $billInfo[$i][5]=to_currency($row->total_cgst);
	         $billInfo[$i][6]=to_currency($row->total_sgst);
	         $billInfo[$i][7]=to_currency($row->total_flood_cess);
				$i++;
			}

			// } 
         return $billInfo;

      }
	public function searchdistinct_brand_no_hsn_no_base_details($criteria){

		$billInfo=array();

      $sql=" select sum( hcare_pharma_invoice_items.quantity) as quantity,sum( hcare_pharma_invoice_items.total) as total,sum( hcare_pharma_invoice_items.total_gst) as total_gst,sum( hcare_pharma_invoice_items.total_cgst) as total_cgst,sum( hcare_pharma_invoice_items.total_sgst) as total_sgst,sum( hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.item_id as item_id from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and hcare_pharma_invoice.status = 0 and hcare_pharma_invoice_items.status = 0 and (hcare_pharma_invoice_items.hsn_no IS NULL or hcare_pharma_invoice_items.hsn_no = '') group by hcare_pharma_invoice_items.item_id";

 

        $i=0;


         $query = $this->db->query($sql); 

         // if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
				
				$taxable_amt[$i]= ($row->total -  ($row->total_gst+$row->total_flood_cess));

		          $billInfo[$i][0]='';//$row->item_id
		          $billInfo[$i][1]=$this->commonDBFunctions->getidToValue('brand','id',$row->item_id,'hcare_pharma_brand');
		          $billInfo[$i][2]=$row->quantity;
		          $billInfo[$i][3]=to_currency($row->total);
		          $billInfo[$i][4]=to_currency($taxable_amt[$i]);
		          $billInfo[$i][5]=to_currency($row->total_cgst);
		          $billInfo[$i][6]=to_currency($row->total_sgst);
		          $billInfo[$i][7]=to_currency($row->total_flood_cess);

				$i++;
			}
		 // }
         return $billInfo;

    }
    public function searchdistinct_hsn_no_base_details_summary($criteria,$hsn_no){


        $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Sales' and hcare_pharma_invoice_items.hsn_no ='".$hsn_no."'";
   

        $query = $this->db->query($sql);

         $billInfo=array();

         $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));
          
         $billInfo[0]=$hsn_no;
         $billInfo[1]=$this->commonDBFunctions->getidToValue('description','hsn_code',$hsn_no,'hcare_pharma_hsn_codes');


      $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Return' and hcare_pharma_invoice_items.hsn_no ='".$hsn_no."'";



         $query1 = $this->db->query($sql1);

         $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));



         $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
         $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
         $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
         $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
         $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
         $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);

         return $billInfo;

    }
    public function searchdistinct_brand_no_hsn_no_base_details_summary($criteria,$item_id){

       
        $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Sales' and hcare_pharma_invoice_items.hsn_no=''";
   

            $query = $this->db->query($sql);

            $billInfo=array();

            $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

            $billInfo[0]='';
            $billInfo[1]=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'hcare_pharma_brand');


        $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Return' and hcare_pharma_invoice_items.hsn_no=''";



             $query1 = $this->db->query($sql1);

	         $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));


	         $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
	         $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
	         $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
	         $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
	         $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
	         $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);

         return $billInfo;

    }

    public function getDoctorPrescriptionIp($criteria=null,$order=null,$order_by=null){
	
   		$this->db->select("a.`id` , a.`ipno` , a.`brand_id` , a.`brand_name` , a.`med_course` , a.`med_days` , a.`date_time` , a.`update_history` , a.`status` , a.`invoice_id` , b.`doc_id` , d.`first_name` as doc_first_name , d.`last_name` as doc_last_name, c.`first_name` as patient_first_name, c.`middle_name` as patient_middle_name, c.`last_name` as patient_last_name");


		$this->db->from('hcare_ip_medicine_prescribed a');
		$this->db->join('hcare_ip_info b', 'a.ipno = b.id','left');
		$this->db->join('hcare_op_patient_info c', 'b.opno = c.`id`','left');
		$this->db->join('emp_info d', 'b.doc_id = d.`id`','left');
		
		
		if(!empty($criteria)){
				for($k=0;$k<count($criteria);$k++){
				
					$this->db->where($criteria[$k]);
				
				}
			} 
		$this->db->where('a.status','0');

		if (!empty($order)) {
			$this->db->order_by($order, $order_by);
		}
		else{
			$this->db->order_by("a.id", "asc");
		}

		
		
		$query = $this->db->get();
	
		$options = array();
		$i=0;

		foreach ($query->result() as $row)
		{

			$options[$i][0] = $row->id;
			$options[$i][1] = $row->ipno;
			$options[$i][2] = $row->brand_id;
			$options[$i][3] = $row->brand_name;
			$options[$i][4] = $row->med_course ;
			$options[$i][5] = $row->med_days;
			$options[$i][6] = $row->date_time;
			$options[$i][7] = $row->update_history;
			$options[$i][8] = $row->status;
			$options[$i][9] = "";
			$options[$i][10] = $row->doc_id;
			$options[$i][11] = $row->doc_first_name;
			$options[$i][12] = $row->doc_last_name;
			$options[$i][13] = $row->patient_first_name;
			$options[$i][14] = $row->patient_middle_name;
			$options[$i][15] = $row->patient_last_name;
			$options[$i][16]= $this->commonDBFunctions->getidToValue('brand','id',$row->brand_id,'hcare_pharma_brand');
			$options[$i][17] = $row->invoice_id;
			$options[$i][18] = $row->qty;
			
			$i++;
		}			 		

		return $options;
	}

	function update_ip_doctor_prescribed($id,$bill_id){
	
		
			$condition	= array('id' => $id);
		
		    $data = array( 'invoice_id' => "$bill_id");
		
			$result=$this->db->update('hcare_ip_medicine_prescribed', $data,$condition);

			if($result) {
				return  $this->lang->line('success');
			}else{
				return  $this->lang->line('failed');
			}

	}
	 public function searchdistinct_gst_percentage($criteria){
	
		
		$this->db->distinct();
		$this->db->select('gst_per');
		
		if(!empty($criteria)){
		
			for($i=0;$i<count($criteria);$i++){
				
				$this->db->where($criteria[$i]);
			}
		}
		$this->db->order_by("gst_id", "asc"); 
		$query=$this->db->get('hcare_pharma_invoice_items');
		
		$billInfo=array();
		$i=0;
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row){
			
				
				$billInfo[$i]= $row->gst_per;
				
				
				$i++;
			}
		}
		return $billInfo;
	}
		public function searchdistinct_hsn_no_base_details_hsnWiseSummaryPercentageWise($criteria,$hsn_no_search,$gst_per,$hsn_no){
		// echo $gst_per;
		// var_dump($criteria);exit();


         $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Sales' and $hsn_no_search and   hcare_pharma_invoice_items.gst_per='$gst_per'";
		// $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Sales' and $hsn_no_search ";
   

        $query = $this->db->query($sql);
// echo $this->db->last_query();exit();
         $billInfo=array();

         $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));
          
         $billInfo[0]=$hsn_no;
         $billInfo[1]=$this->commonDBFunctions->getidToValue('description','hsn_code',$hsn_no,'hcare_pharma_hsn_codes');
// exit();

      $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Return' and $hsn_no_search and   hcare_pharma_invoice_items.gst_per='".$gst_per."' ";
         // $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.sales_mode='Return' and $hsn_no_search  ";



         $query1 = $this->db->query($sql1);

         $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));



         $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
         $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
         $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
         $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
         $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
         $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);
         $billInfo[8]=$query->row()->gst_per;
         $billInfo[9]=to_currency($query->row()->total_gst - $query1->row()->total_gst);

         return $billInfo;

    }
    public function searchdistinct_brand_no_hsn_no_base_details_hsnWiseSummaryPercentageWise($criteria,$item_id,$gst_per){

       
        $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Sales' and hcare_pharma_invoice_items.hsn_no = '' and hcare_pharma_invoice_items.gst_per = '".$gst_per."'";
        // $sql="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Sales' and hcare_pharma_invoice_items.hsn_no = '' ";
   

            $query = $this->db->query($sql);

            $billInfo=array();

            $taxable_amt_sales= ($query->row()->total -  ($query->row()->total_gst+$query->row()->total_flood_cess));

            $billInfo[0]='';
            $billInfo[1]=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'hcare_pharma_brand');


        $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Return' and hcare_pharma_invoice_items.hsn_no = '' and hcare_pharma_invoice_items.gst_per = '".$gst_per."'";
            // $sql1="select sum(hcare_pharma_invoice_items.quantity) as quantity,sum(hcare_pharma_invoice_items.total) as total,sum(hcare_pharma_invoice_items.total_gst) as total_gst, sum(hcare_pharma_invoice_items.total_cgst) as total_cgst, sum(hcare_pharma_invoice_items.total_sgst) as total_sgst, sum(hcare_pharma_invoice_items.total_flood_cess) as total_flood_cess,hcare_pharma_invoice_items.gst_per from hcare_pharma_invoice join hcare_pharma_invoice_items on hcare_pharma_invoice.id = hcare_pharma_invoice_items.bill_id where hcare_pharma_invoice.".$criteria[0]." and hcare_pharma_invoice.".$criteria[1]." and hcare_pharma_invoice.".$criteria[2]." and  hcare_pharma_invoice_items.status=0 and hcare_pharma_invoice_items.item_id='".$item_id."' and hcare_pharma_invoice_items.sales_mode='Return' and hcare_pharma_invoice_items.hsn_no = '' ";



             $query1 = $this->db->query($sql1);

	         $taxable_amt_return= ($query1->row()->total -  ($query1->row()->total_gst+$query1->row()->total_flood_cess));


	         $billInfo[2]=($query->row()->quantity - $query1->row()->quantity);
	         $billInfo[3]=to_currency($query->row()->total - $query1->row()->total);
	         $billInfo[4]=to_currency($taxable_amt_sales - $taxable_amt_return);
	         $billInfo[5]=to_currency($query->row()->total_cgst - $query1->row()->total_cgst);
	         $billInfo[6]=to_currency($query->row()->total_sgst - $query1->row()->total_sgst);
	         $billInfo[7]=to_currency($query->row()->total_flood_cess - $query1->row()->total_flood_cess);
	         $billInfo[8]=$query->row()->gst_per;
        	 $billInfo[9]=to_currency($query->row()->total_gst - $query1->row()->total_gst);

         return $billInfo;

    }


}
?>
