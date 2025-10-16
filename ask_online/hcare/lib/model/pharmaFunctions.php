<?php 
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


class PharmaFunctions{

	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

    public function getPharmaCreditPayments($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_bill_payments','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['bill_no'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['amount'];
				$arrList[$i][4]=$row['user_id'];
				$arrList[$i][5]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][6]=$row['bill_time'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}

	 public function InvoiceCreditPayment($wheredata){

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_credit_payment','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$i+1;
				$arrList[$i][1]=$row['id'];
				$arrList[$i][2]=$row['bill_no'];
				$arrList[$i][3]=$row['amount'];
				$arrList[$i][4]=$row['date'];
				$arrList[$i][5]=$this->dbConnection->idToValue('hcare_pharma_invoice','cust_name','id',$row['bill_no']);
				$arrList[$i][6]=$row['status'];
				$arrList[$i][7]=$row['cancellation_details'];
				$arrList[$i][8]=$row['cancellation_date'];
				$arrList[$i][9]=$row['user_id'];
				$arrList[$i][10]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][11]=$row['card_amt'];
				$arrList[$i][12]=$row['upi_amt'];
				$new_amount=$row['upi_amt']+$row['amount']+$row['card_amt'];
				$arrList[$i][13]=$new_amount;
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	// function getPharmaBillInfo($wheredata = null ,$orderbyfield = null,$oderby = null,$credit = false,$limit=null ){
	
	// 	$arrList=array();
	// 	$i=0;
	// 	$data=true;
	// 	$query=$this->dbConnection->BuiltQuery('pharma_invoice','',$wheredata,'id','asc','',$limit);	
	// 	$result=$this->dbConnection->executeQuery($query);
	// 	//echo $query;
	// 	if(mysqli_num_rows($result) > 0){
	// 		$p=1;
	// 		while($row=$result -> fetch_assoc()){
	// 		$data=true;
 //            $ip_card_amount=0;
 //            $ip_cash_amount=0;
	//         $bill_status=0;
	// 	    $where[0]="bill_no='".$row['id']."'";
	// 		$creditInfo=$this->getPharmaCreditPayments($where);

	// 		$creditPayment=0;
	// 			if(!empty($creditInfo)){
					 
	// 				for($k=0;$k<count($creditInfo);$k++){
					
	// 					$creditPayment=$creditPayment+$creditInfo[$k][3];
	// 				}
	// 			}
				
	// 			$credit_amount=$row['credit']-$creditPayment;
	// 			if($credit == true && $credit_amount <= 0){ 
	// 			 $data=false; 
	// 			}
			
	// 		if($data){
	// 			$arrList[$i][0]=$row['id'];
	// 			$arrList[$i][1]=$row['type'];
	// 			$arrList[$i][2]=$row['ref_no'];
 //                                $credit_amt=$row['credit'];
				
	// 			if($row['type'] == "OP" || $row['type'] == "IP") {
					
 //                    if($row['type'] == "OP") {
	// 				$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$row['ref_no']);
 //                                        $doc_id=$this->dbConnection->idToValue("hcare_op_visit_info","doc_id","id",$row['ref_no']);
 //                                        $prefix=$this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$opno);		      
 //                   }else if($row['type'] == "IP") {

	// 				$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ref_no']);
	// 				$bill_status=$this->dbConnection->idToValue("hcare_ip_info","bill_status","id",$row['ref_no']);
 //                                        $doc_id=$this->dbConnection->idToValue("hcare_ip_info","doc_id","id",$row['ref_no']);	
 //                                       $prefix='';
 //                                        $discharge_date=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ref_no']);

 //                                        if($discharge_date !='' && $discharge_date !=="0000-00-00"){
                                            
 //                                           if($payment_mode =="CREDIT CARD") $ip_card_amount=$row['credit'];
 //                                           else $ip_cash_amount=$row['credit'];;

 //                                           $credit_amt=0;
 //                                           $creditPayment=0;

 //                                        }
 //                   }
					
	// 			       $arrList[$i][3]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
	// 				$arrList[$i][4]=$this->dbConnection->idToValue("hcare_op_patient_info","age","id",$opno);
	// 				$arrList[$i][5]=$this->dbConnection->idToValue("hcare_op_patient_info","gender","id",$opno);
	// 				$arrList[$i][6]=$this->dbConnection->idToValue("hcare_op_patient_info","place","id",$opno);
	// 				$arrList[$i][7]=$this->dbConnection->idToValue("hcare_op_patient_info","contact_no","id",$opno);
									
	// 				$arrList[$i][8]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$doc_id);
	// 			}else{
				
	// 				$opno='';
	// 				$prefix=$this->dbConnection->idToValue("hcare_direct_customer","prefix","id",$row['ref_no']);
	// 				$arrList[$i][3]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ref_no']);
					
	// 				$arrList[$i][4]=$this->dbConnection->idToValue("hcare_direct_customer","age","id",$row['ref_no']);
	// 				$arrList[$i][5]=$this->dbConnection->idToValue("hcare_direct_customer","gender","id",$row['ref_no']);
	// 				$arrList[$i][6]=$this->dbConnection->idToValue("hcare_direct_customer","place","id",$row['ref_no']);
	// 				$arrList[$i][7]=$this->dbConnection->idToValue("hcare_direct_customer","contact_no","id",$row['ref_no']);				
	// 				$arrList[$i][8]=$this->dbConnection->idToValue("hcare_direct_customer","refferal_info","id",$row['ref_no']);
	// 			}
				
	// 			$arrList[$i][9]=$row['total_amount'];
	// 			$arrList[$i][10]=$row['dr_disc'];
	// 			$arrList[$i][11]=$row['net_total'];
	// 			$arrList[$i][12]=$row['paid_with'];
	// 			$arrList[$i][13]=$row['cash']+$creditPayment+$ip_cash_amount;
	// 			$arrList[$i][14]=$credit_amt-$creditPayment;
	// 			$arrList[$i][15]=$row['credit_card']+$ip_card_amount;
	// 			$arrList[$i][16]=date("Y-m-d",strtotime($row['bill_date']));
	// 			$arrList[$i][17]=$row['remarks'];
	// 			$arrList[$i][18]=$row['user_id'];
	// 			$arrList[$i][19]=$opno;
	// 			$arrList[$i][20]=$row['insurance'];
	// 			$arrList[$i][21]=$row['credit'];
	// 			$arrList[$i][22]=$row['lab_status'];
				
	// 			$arrList[$i][23]=$dr_disc_amt=($row['total_amount']*($row['dr_disc']/100));
	// 			$arrList[$i][24]=$row['cancellation_details'];

 //                               if($row['type'] == "IP") {
                                    
 //                                 $arrList[$i][25]=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ref_no']);
 //                               }else $arrList[$i][25]='';
			       
	// 		       $arrList[$i][26]=$prefix;
	// 		        //split updation history
	// 	                                                $update_history='';
			
	// 		                                         if(!empty($row['update_history'])){
	// 		                                             $history_split=explode("&&",$row['update_history']);
				    
	// 		                                         if(!empty($history_split)){
			
	// 		                                            for($m=0;$m<count($history_split);$m++) {
	// 		                                                  $history_info=explode("|",$history_split[$m]);
	// 		                                                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
	// 		                                                  $datetime=$history_info[1];
	// 				                                  $update_history .=$user_name.":".$datetime."<br>";
	// 		                                             }
	// 		                                         }
	// 	                                                }
	// 		                                        $arrList[$i][27]= $update_history;
	// 												 $employee_id= $this->dbConnection->idToValue("hcare_users","employee_id","id",$row['user_id']);
	// 												 $arrList[$i][28]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$employee_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$employee_id);
	// 												 $arrList[$i][29]=$bill_status;
	// 			$i++;
	// 		}
	// 		}
		
	// 	}
	
	// 	return $arrList;
	// }

	function getPharmaInvoice($wheredata = null ,$orderbyfield = null,$oderby = null,$credit = false,$limit=null ){
	
		if (empty($oderby)) {
			$oderby='asc';
		}

		$arrList=array();
		$i=0;
		$data=true;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice','',$wheredata,'id',$oderby,'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		// echo $query;
		if(mysqli_num_rows($result) > 0){

			while($row=$result -> fetch_assoc()){
			$data=true;
            $ip_card_amount=0;
            $ip_cash_amount=0;
             $ip_upi_amount=0;
	        $bill_status=0;
	        $where=array();
		    $where[0]="bill_no='".$row['id']."'";
			$creditInfo=$this->InvoiceCreditPayment($where);
            
			$credit=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$credit+=($creditInfo[$k][3]+$creditInfo[$k][11]+$creditInfo[$k][12]);
					}
				} 
				$amount_paid=$row['amount_paid'];
				$balance=$row['balance'];

				     $rem_balance=$balance-$credit;
                     $new_amount=$amount_paid+$credit;

			    if($row['cust_type'] == "IP"){
	
				   $discharge_date=$this->dbConnection->idToValue('hcare_ip_info','discharge_date','id',$row['ip_no']);
				}else $discharge_date='0000-00-00';

			if($data){
				$arrList[$i][0]=$i+1;;
				$arrList[$i][1]=$row['id'];
				$arrList[$i][2]=$row['cust_type'];
				$arrList[$i][3]=$row['op_visit_id'];
	     
				$arrList[$i][4]=$row['cust_name'];
				$arrList[$i][5]=$row['bill_date'];
				$arrList[$i][6]=$row['sales_amt'];
				$arrList[$i][7]=$row['tax'];
				$arrList[$i][8]=$row['cess'];
				$arrList[$i][9]=$row['return_amount'];
				$arrList[$i][10]=$row['bill_total'];
				$arrList[$i][11]=$row['discount_type'];
				$arrList[$i][12]=$row['discount_value'];
				$arrList[$i][13]=$row['discount_amt'];

				$arrList[$i][14]=$row['net_total'];
				$arrList[$i][15]=$row['payment_mode'];
				$arrList[$i][16]=$row['checque_no'];
                $arrList[$i][17]=$row['checque_amt'];
				$arrList[$i][18]=$row['card_amt'];
				$arrList[$i][19]=$amount_paid;
				$arrList[$i][20]=$balance;
				$arrList[$i][21]=$row['ref_id'];
			    $arrList[$i][22]=$this->dbConnection->idToValue('hcare_pharma_branch','branch_name','id',$row['ref_id']);
                $arrList[$i][23]=$row['remarks'];
				$arrList[$i][24]=$row['user_id'];
				$arrList[$i][25]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
                $arrList[$i][26]=$row['cancellation_details'];
				$arrList[$i][27]=$row['cancellation_date'];
				$arrList[$i][28]=$row['status'];
                $arrList[$i][29]=$credit;
           
				$doc_id=$this->dbConnection->idToValue('hcare_op_visit_info','doc_id','id',$row['op_visit_id']);
                
                if($row['cust_type']=="OP"){
				$arrList[$i][30]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$doc_id)." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$doc_id)." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$doc_id);
				}else{
				$arrList[$i][30]=$row['doctor'];
				}
                      $arrList[$i][31]=$new_amount;
                      $arrList[$i][32]=$rem_balance;
                      $arrList[$i][33]=$row['ip_no'];

                if($row['cust_type'] == "OP") {
					$arrList[$i][34]= $opno=$this->dbConnection->idToValue('hcare_op_visit_info','opno','id',$row['op_visit_id']);
				        $arrList[$i][37]=$this->dbConnection->idToValue('hcare_op_patient_info','prefix','id',$opno);
				}else{
                                  $arrList[$i][34]=$row['op_no'];
				                  $arrList[$i][37]="";
				     }   
				         $arrList[$i][35]= $row['sanctioned_by'];
						 $arrList[$i][36]= $row['auth_remarks'];
						 $arrList[$i][37]= $row['sales_mode']; 
						 $arrList[$i][38]=$row['upi_amt'];  
				$i++;
			
			}
		
		}
	
		return $arrList;
	}
	}
	
	function getPharmaIpInvoice($wheredata = null ,$orderbyfield = null,$oderby = null,$credit = false,$limit=null ){
	
		$arrList=array();
		$i=0;
		$data=true;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice','',$wheredata,'id','asc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		//echo $query;
		if(mysqli_num_rows($result) > 0){
			$p=1;
			while($row=$result -> fetch_assoc()){
			$data=true;
            $ip_card_amount=0;
            $ip_cash_amount=0;
	        $bill_status=0;
		    $where[0]="bill_no='".$row['id']."'";
			$creditInfo=$this->getPharmaCreditPayments($where);
            
			$creditPayment=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$creditPayment=$creditPayment+$creditInfo[$k][3];
					}
				}
				
				$credit_amount=$row['balance']-$creditPayment;
				if($credit == true && $credit_amount <= 0){ 
				 $data=false; 
				}
			
			if($data){
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['cust_type'];
				$arrList[$i][2]=$row['ip_no'];
                                $credit_amt=$row['balance'];
						      
                if($row['cust_type'] == "IP") {

					$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ip_no']);
					$bill_status=$this->dbConnection->idToValue("hcare_ip_info","bill_status","id",$row['ip_no']);
                                        $doc_id=$this->dbConnection->idToValue("hcare_ip_info","doc_id","id",$row['ip_no']);	
                                       $prefix='';
                                        $discharge_date=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ip_no']);

                                        if($discharge_date !='' && $discharge_date !=="0000-00-00"){
                                            
                                           if($payment_mode =="CREDIT CARD") $ip_card_amount=$row['balance'];
                                           else $ip_cash_amount=$row['balance'];;

                                           $credit_amt=0;
                                           $creditPayment=0;

                                        }
					
				       $arrList[$i][3]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
					$arrList[$i][4]=$this->dbConnection->idToValue("hcare_op_patient_info","age","id",$opno);
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_op_patient_info","gender","id",$opno);
					$arrList[$i][6]=$this->dbConnection->idToValue("hcare_op_patient_info","place","id",$opno);
					$arrList[$i][7]=$this->dbConnection->idToValue("hcare_op_patient_info","contact_no","id",$opno);
									
					$arrList[$i][8]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$doc_id);
				}else{
				
					$opno='';
					$prefix=$this->dbConnection->idToValue("hcare_direct_customer","prefix","id",$row['ip_no']);
					$arrList[$i][3]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ip_no']);
					
					$arrList[$i][4]=$this->dbConnection->idToValue("hcare_direct_customer","age","id",$row['ip_no']);
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_direct_customer","gender","id",$row['ip_no']);
					$arrList[$i][6]=$this->dbConnection->idToValue("hcare_direct_customer","place","id",$row['ip_no']);
					$arrList[$i][7]=$this->dbConnection->idToValue("hcare_direct_customer","contact_no","id",$row['ip_no']);				
					$arrList[$i][8]=$this->dbConnection->idToValue("hcare_direct_customer","refferal_info","id",$row['ip_no']);
				}
				
				$arrList[$i][9]=$row['doctor'];
				$arrList[$i][10]=$row['cust_name'];
				$arrList[$i][11]=date("Y-m-d",strtotime($row['bill_date']));
				$arrList[$i][12]=$row['sales_amt'];
				$arrList[$i][13]=$row['return_amount'];
				$arrList[$i][14]=$row['bill_total'];
				$arrList[$i][15]=$row['discount_value'];
				$arrList[$i][16]=$row['discount_amt'];
				$arrList[$i][17]=$row['net_total'];
				$arrList[$i][18]=$opno;
				$arrList[$i][19]=$row['payment_mode'];
				$arrList[$i][20]=$row['checque_no'];
				$arrList[$i][21]=$row['checque_amt'];
				$arrList[$i][22]=$row['card_amt']+$ip_card_amount;
				$arrList[$i][23]=$row['amount_paid']+$creditPayment+$ip_cash_amount;;
				$arrList[$i][24]=$row['balance'];
				$arrList[$i][25]=$credit_amt-$creditPayment;
		        $arrList[$i][26]=$creditPayment;
				
				$arrList[$i][27]=$dr_disc_amt=($row['bill_total']*($row['discount_value']/100));
				$arrList[$i][28]=$row['remarks'];
				$arrList[$i][29]=$row['cancellation_details'];
				$arrList[$i][30]=$row['cancellation_date'];
				$arrList[$i][31]=$row['sanctioned_by'];
				$arrList[$i][32]=$row['auth_remarks'];
				$arrList[$i][33]=$row['sales_mode'];

                               if($row['cust_type'] == "IP") {
                                    
                                 $arrList[$i][34]=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ip_no']);
                               }else $arrList[$i][34]='';
			       
			       $arrList[$i][35]=$prefix;
			     
		                                             
													 $employee_id= $this->dbConnection->idToValue("hcare_users","employee_id","id",$row['user_id']);
													 $arrList[$i][36]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$employee_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$employee_id);
													 $arrList[$i][37]=$bill_status;
				$i++;
			}
			}
		
		}
	
		return $arrList;
	}
	
	function getpharmaSaleConsolidated($wheredata = null){
	
	   $arrFieldList[0]="sum(amount_paid)";
	   $arrFieldList[1]="sum(card_amt)";
	   $arrFieldList[2]="sum(checque_amt)";
	   $arrFieldList[3]="sum(balance)";
	   $arrFieldList[4]="sum(net_total)";
	   $arrFieldList[5]="sum(round_amt)";
	   $arrFieldList[6]="sum(gst)";
	   $arrFieldList[7]="sum(bill_total)";
	   $arrFieldList[8]="sum(discount_amt)";
	   $arrFieldList[9]="sum(upi_amt)";
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice',$arrFieldList,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['sum(amount_paid)'];
						  $arrList[$i][1]=$row['sum(card_amt)'];
						  $arrList[$i][2]=$row["sum(checque_amt)"];
	                 $arrList[$i][3]=$row["sum(balance)"];
						  $arrList[$i][4]=$row["sum(net_total)"];
						  $arrList[$i][5]=$row["sum(round_amt)"];
						  $arrList[$i][6]=$row["sum(gst)"];
						  $arrList[$i][7]=$row["sum(bill_total)"];
						  $arrList[$i][8]=$row["sum(discount_amt)"];
						  $arrList[$i][9]=$row["sum(upi_amt)"];
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}
	
	function getPharmaBranch(){
	
			$arrList=array();
			$wheredata[0]="status=0";
			$query=$this->dbConnection->BuiltQuery("hcare_pharma_branch",'',$wheredata,'branch_name','asc');
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['branch_name'];
					$i++;
				}	
			}
			
			return $arrList;
	}
	public function total_quantity_sold($search,$selling_unit){

		$select_field[]="sum(quantity)";
        $search[]="selling_unit="."'".$selling_unit."'";
        $search[]="status =0";
      
	    $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice_items',$select_field,$search,'id','asc','',$limit);

	    $result=$this->dbConnection->executeQuery($query);

	    $row=$result -> fetch_assoc();
          
		   return $row['sum(quantity)'];
    }
    public function total_quantity_sold_receivings($search,$item_type){

		$select_field[]="sum(quantity)";
        $search[]="item_type="."'".$item_type."'";
      
	    $query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings_items',$select_field,$search,'id','asc','',$limit);

	    $result=$this->dbConnection->executeQuery($query);

	    $row=$result -> fetch_assoc();
          
		   return $row['sum(quantity)'];
    }
	function searchdistinct_item($wheredata){
        	
		    $select_field[]="distinct item_id";

		    $arrList=array();
		    $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice_items',$select_field,$wheredata,'id','asc','',$limit);

		$result=$this->dbConnection->executeQuery($query);
		
		$i=0;
		
		if(mysqli_num_rows($result)>0){
		
			while($row=$result -> fetch_assoc()){
			
				
				$arrList[$i][0]=$row['item_id'];
				$arrList[$i][1]=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$row['item_id']);
				
				
				$i++;
			}
		}
		return $arrList;
	}
	function searchdistinct_item_receivings($wheredata){
        	
		    $select_field[]="distinct item_id";

		    $arrList=array();
		    $query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings_items',$select_field,$wheredata,'id','asc','',$limit);

		$result=$this->dbConnection->executeQuery($query);
		
		$i=0;
		
		if(mysqli_num_rows($result)>0){
		
			while($row=$result -> fetch_assoc()){
			
				
				$arrList[$i][0]=$row['item_id'];
				$arrList[$i][1]=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$row['item_id']);
				
				
				$i++;
			}
		}
		return $arrList;
	}
	function getPharmaInvoiceItems($wheredata){

		    $arrList=array();
		    $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice_items','',$wheredata,'id','asc','',$limit);
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
		/*... brand ...*/		   
                $brand=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$row['item_id']);

                $brand_name=$brand;

					$arrList[$i][0]=$brand_name;
					$arrList[$i][1]=$row['quantity'];
					$arrList[$i][2]=$row['total'];
					$arrList[$i][3]=$this->dbConnection->idToValue('hcare_pharma_invoice','cust_type','id',$row['bill_id']);
					$arrList[$i][4]=$row['bill_date'];
					$i++;
				}	
			}
			
			 return $arrList;
			
	}
	public function searchBillItems($criteria){

            $billInfo=array();

		    $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice_items','',$criteria,'id','asc','',$limit);

		    $result=$this->dbConnection->executeQuery($query);

		    $i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){

			    $billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row['bill_id'];
				$billInfo[$i][2]= $row['bill_date'];
				$billInfo[$i][3]= $row['item_id'];
				$billInfo[$i][4]= $row['batch_id'];
				$billInfo[$i][5]= $row['sales_mode'];				
				$billInfo[$i][6]= $row['batch_no'];
				$billInfo[$i][7]= $row['expiry'];
				$billInfo[$i][8]= $row['selling_unit'];
				$billInfo[$i][9]= $row['quantity'];
				$billInfo[$i][10]= $row['sellp'];				
				$billInfo[$i][11]= $row['total'];	

				$billInfo[$i][12]= $this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$row['item_id']);
				$billInfo[$i][13]= $this->dbConnection->idToValue('hcare_pharma_brand','manufacturer','id',$row['item_id']);
				
				
				$i++;
			
	           }	
			}
      
	    return $billInfo;	

    }
    public function searchBillItems_Receivings($criteria){

            $billInfo=array();

		    $query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings_items','',$criteria,'id','asc','',$limit);

		    $result=$this->dbConnection->executeQuery($query);

		    $i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){

			    $billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row['bill_id'];
				$billInfo[$i][2]= $row['bill_date'];
				$billInfo[$i][3]= $row['purchase_mode'];
				$billInfo[$i][4]= $row['batch_number'];
				$billInfo[$i][5]= $row['expiry'];				
				$billInfo[$i][6]= $row['item_type'];
				$billInfo[$i][7]= $row['quantity'];
				$billInfo[$i][8]= $row['foc'];
				$billInfo[$i][9]= $row['sellp'];
				$billInfo[$i][10]= $row['disc_type'];				
				$billInfo[$i][11]= $row['disc_value'];
				$billInfo[$i][12]= $row['buyp'];
				$billInfo[$i][13]= $row['total'];
				$billInfo[$i][14]= $row['item_id'];					

				$billInfo[$i][15]= $this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$row['item_id']);

				$billInfo[$i][16]= $row['tpers'];
				
				
				$i++;
			
	           }	
			}
      
	    return $billInfo;	

    }
    function getPharmaReceivings($wheredata = null ,$orderbyfield = null,$oderby = null,$credit = false,$limit=null ){
	
		$billInfo=array();
		
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings','',$wheredata,'id','asc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		$i=0;

		if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){

			    $billInfo[$i][0]= $i+1;
				$billInfo[$i][1]= $row['id'];
				$billInfo[$i][2]= $row['pono'];
				$billInfo[$i][3]= $row['bill_date'];
				$billInfo[$i][4]= $row['supplier'];
				$billInfo[$i][5]= $this->dbConnection->idToValue('hcare_pharma_suppliers','supplier_name','id',$row['supplier']);				
				$billInfo[$i][6]= $row['purchase_amt'];
				$billInfo[$i][7]= $row['tax'];
				$billInfo[$i][8]= $row['cess'];
				$billInfo[$i][9]= $row['freight'];
				$billInfo[$i][10]= $row['return_amount'];				
				$billInfo[$i][11]= $row['bill_total'];	

				$billInfo[$i][12]= $row['discount_type'];
				$billInfo[$i][13]= $row['discount_value'];
				$billInfo[$i][14]= $row['discount_amt'];
				$billInfo[$i][15]= $row['net_total'];
				$billInfo[$i][16]= $row['payment_mode'];
				$billInfo[$i][17]= $row['checque_no'];

				$billInfo[$i][18]= $row['checque_amt'];
				$billInfo[$i][19]= $row['card_amt'];
				$billInfo[$i][20]= $row['amount_paid'];
				$billInfo[$i][21]= $row['balance'];
				$billInfo[$i][22]= $row['ref_id'];
				$billInfo[$i][23]= $this->dbConnection->idToValue('hcare_pharma_branch','branch_name','id',$row['ref_id']);

				$billInfo[$i][24]= $row['remarks'];
				$billInfo[$i][25]= $row['bill_no'];
				$billInfo[$i][26]= $row['entry_date'];
				$billInfo[$i][27]= $row['user_id'];
				$billInfo[$i][28]= $this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);

				$billInfo[$i][29]= $row['purchase_mode'];
				$billInfo[$i][30]= $this->dbConnection->idToValue('hcare_pharma_suppliers','tin_no','id',$row['supplier']);

				$billInfo[$i][31]= $this->dbConnection->idToValue('hcare_pharma_suppliers','gst_no','id',$row['supplier']);
				$billInfo[$i][32]= $row['upi_amt'];
				
				$i++;
			
	           }	
			}
      
	    return $billInfo;	
	}   
function getPharmaSupplier($selectfield = null,$wherefield = null){
	
		$arrList=array();

		    $wherefield[]="status = '0'";

			$query=$this->dbConnection->BuiltQuery("hcare_pharma_suppliers",'',$wherefield,'supplier_name','asc');	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['supplier_name'];
					$i++;
				}	
			}
	
			return $arrList;
	}	
	function getRecievingsBill($wheredata = null){
	
	   $arrFieldList[0]="amount_paid";
	   $arrFieldList[1]="card_amt";
	   $arrFieldList[2]="checque_amt";
	   $arrFieldList[3]="balance";
	   $arrFieldList[4]="net_total";
	   $arrFieldList[5]="supplier";
	   $arrFieldList[6]= 'bill_date';
	   $arrFieldList[7]= 'id';
	   $arrFieldList[8]= 'bill_no';
	   $arrFieldList[9]= 'gst';
	   $arrFieldList[10]= 'net_total';
	   $arrFieldList[11]= 'round_amt';
	   $arrFieldList[12]= 'payment_mode';
	   $arrFieldList[13]= 'rounded_status';
	   $arrFieldList[14]= 'purchase_amt';
	   $arrFieldList[15]= 'net_total_before';
	   $arrFieldList[16]= 'discount_amt';
	   // $arrFieldList[17]= 'ledger_id';
	   $arrFieldList[17]= 'bill_total';
	   $arrFieldList[18]= 'return_amount';
	   $arrFieldList[19]= 'freight';
	   $arrFieldList[20]= 'upi_amt';
	   
	   
	 
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings',$arrFieldList,$wheredata,'id','asc');
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

						
							
						
						  $arrList[$i][0]=$row['amount_paid'];
						  $arrList[$i][1]=$row['card_amt'];
						  $arrList[$i][2]=$row["checque_amt"];
	                      $arrList[$i][3]=$row["balance"];
						  $arrList[$i][4]=$row["net_total"];
						  $arrList[$i][5]=$row["supplier"];
						  $arrList[$i][6]= $row['bill_date'];
						  $arrList[$i][7]= $this->dbConnection->idToValue('hcare_pharma_suppliers','ledger_id','id',$row['supplier']);
						  $arrList[$i][8]= $row['id'];
						  $arrList[$i][9]= $row['bill_no'];
						  $arrList[$i][10]= $this->dbConnection->idToValue('hcare_pharma_suppliers','supplier_name','id',$row['supplier']);
						  $arrList[$i][11]= $row['gst'];
						  $arrList[$i][12]= $row['net_total'];
						  $arrList[$i][13]= $row['round_amt'];
						  $arrList[$i][14]= $row['payment_mode'];
						  $arrList[$i][15]= $row['rounded_status'];
						  $arrList[$i][16]= $row['purchase_amt'];
						  $arrList[$i][17]= $row['net_total_before'];
						  $arrList[$i][18]= $row['discount_amt'];
						  // $arrList[$i][19]= $row['ledger_id'];
						  $arrList[$i][20]= $row['bill_total'];
						  $arrList[$i][21]= $row['return_amount'];
						  $arrList[$i][22]= $row['freight'];
						  $arrList[$i][23]= $this->getItemDiscount($row['id']);
						  $arrList[$i][24]= '';
						  $arrList[$i][25]=$row['upi_amt'];
						  // $arrList[$i][26]= 0;
	                									
						  $i++;
						
						}
						
			       }
			       // var_dump($arrList);
			       
			       return $arrList;
	   
	}
function updaterec_online_status($rec_id,$online_status,$acc_entry_id){
		
		
		$field_names1=array('online_status','acc_entry_id');
		$field_data=array($online_status,$acc_entry_id);
	
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$rec_id,"hcare_pharma_recievings");
		
		if($result) return true;
		else return false;
	}	


	function getRecievingsBillGst($bill_id = null){
	

		$query = "SELECT DISTINCT `gst_per` FROM `hcare_pharma_recievings_items` WHERE `bill_id`='$bill_id' AND `status`=0 ORDER BY `id` DESC ";
		$result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i]=$row['gst_per'];
	                    
					
				
						  $i++;
						
						}
						
			       }
			       // var_dump($arrList);
			     
				$conf=new Config();
				$this->dbConnection=new DMLFunctions($conf);

			       return $arrList;
	   
	}
	function getRecievingsBillGstAmount($bill_id,$purchase_entry_gst){

	
	  $query = "SELECT sum(sgst_amt),sum(cgst_amt),gst_id FROM `hcare_pharma_recievings_items` WHERE `bill_id` = '$bill_id' AND `gst_per`='$purchase_entry_gst' AND `status` = 0 ";

	  $result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i][0]=number_format((float)$row['sum(cgst_amt)'], 2, '.', '');
						  $arrList[$i][1]=number_format((float)$row['sum(sgst_amt)'], 2, '.', '');
						  $arrList[$i][2]=$row['gst_id'];
						  $arrList[$i][3]= $this->dbConnection->idToValue('hcare_pharma_recievings','payment_mode','id',$bill_id);
						  $arrList[$i][4]= $this->dbConnection->idToValue('hcare_pharma_recievings','bill_no','id',$bill_id);
						  // $arrList[$i][5]= $this->dbConnection->idToValue('hcare_pharma_gst','cgst_ledger_id','id',$row['gst_id']);
						  // $arrList[$i][6]= $this->dbConnection->idToValue('hcare_pharma_gst','sgst_ledger_id','id',$row['gst_id']);
						  $arrList[$i][7]= $this->dbConnection->idToValue('hcare_pharma_recievings','bill_date','id',$bill_id);
						  $arrList[$i][8]=$purchase_entry_gst;
	                    
					
				
						  $i++;
						
						}
						
			       }
			     

			       return $arrList;




	   
	}

	function getSalesBillGst($sales_date_from,$sales_date_to){
	

		$query = "SELECT DISTINCT `gst_per` FROM `hcare_pharma_invoice_items` WHERE `bill_date`>='$sales_date_from' AND `bill_date`<='$sales_date_to' AND `sales_mode`='Sales' AND `status`=0 ORDER BY `id` ASC";
		$result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i]=$row['gst_per'];
	                    
					
				
						  $i++;
						
						}
						
			       }


			       return $arrList;
	   
	}
	function getSalesBillGstAmount($sales_gst_per,$sales_date_from,$sales_date_to){
	

	  $query = "SELECT sum(total_sgst),sum(total_cgst),gst_id FROM `hcare_pharma_invoice_items` WHERE `bill_date`>='$sales_date_from' AND `bill_date`<='$sales_date_to' AND `sales_mode`='Sales' AND `gst_per`='$sales_gst_per' AND `status` = 0 ";

	  $result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i][0]=number_format((float)$row['sum(total_cgst)'], 2, '.', '');
						  $arrList[$i][1]=number_format((float)$row['sum(total_sgst)'], 2, '.', '');
						  $arrList[$i][2]=$row['gst_id'];
						  $arrList[$i][3]= $this->dbConnection->idToValue('hcare_pharma_invoice','payment_mode','id',$bill_id);
						  $arrList[$i][4]= $this->dbConnection->idToValue('hcare_pharma_invoice','id','id',$bill_id);
						  // $arrList[$i][5]= $this->dbConnection->idToValue('hcare_pharma_gst','cgst_sales_ledger_id','id',$row['gst_id']);
						  // $arrList[$i][6]= $this->dbConnection->idToValue('hcare_pharma_gst','sgst_sales_ledger_id','id',$row['gst_id']);
						  $arrList[$i][7]= $this->dbConnection->idToValue('hcare_pharma_invoice','bill_date','id',$bill_id);
						  $arrList[$i][8]= $sales_gst_per;
	                    
					
				
						  $i++;
						
						}
						
			       }
			       
			       return $arrList;



	   
	}




	function getSalesBillGstReturn($sales_date_from,$sales_date_to){
	


		$query = "SELECT DISTINCT `gst_per` FROM `hcare_pharma_invoice_items` WHERE `bill_date`>='$sales_date_from' AND `bill_date`<='$sales_date_to' AND `sales_mode`='Return' AND `status`=0 ORDER BY `id` ASC ";
		$result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i]=$row['gst_per'];
	                    
					
				
						  $i++;
						
						}
						
			       }


			       return $arrList;
	   
	}
	function getSalesBillGstAmountReturn($sales_gst_per,$sales_date_from,$sales_date_to){
	

	  $query = "SELECT sum(total_sgst),sum(total_cgst),gst_id FROM `hcare_pharma_invoice_items` WHERE `bill_date`>='$sales_date_from' AND `bill_date`<='$sales_date_to' AND `sales_mode`='Return' AND `gst_per`='$sales_gst_per' AND `status` = 0 ";

	  $result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

					
						  $arrList[$i][0]=number_format((float)$row['sum(total_cgst)'], 2, '.', '');
						  $arrList[$i][1]=number_format((float)$row['sum(total_sgst)'], 2, '.', '');
						  $arrList[$i][2]=$row['gst_id'];
						  $arrList[$i][3]= $this->dbConnection->idToValue('hcare_pharma_invoice','payment_mode','id',$bill_id);
						  $arrList[$i][4]= $this->dbConnection->idToValue('hcare_pharma_invoice','id','id',$bill_id);
						  // $arrList[$i][5]= $this->dbConnection->idToValue('hcare_pharma_gst','cgst_return_ledger_id','id',$row['gst_id']);
						  // $arrList[$i][6]= $this->dbConnection->idToValue('hcare_pharma_gst','sgst_return_ledger_id','id',$row['gst_id']);
						  $arrList[$i][7]= $this->dbConnection->idToValue('hcare_pharma_invoice','bill_date','id',$bill_id);
						  $arrList[$i][8]=$sales_gst_per;
	                    
					
				
						  $i++;
						
						}
						
			       }
			       
			       return $arrList;



	   
	}
	 public function InvoiceCreditPaymentSales($wheredata){


		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_credit_payment','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['inv_no'];
				$arrList[$i][2]=$row['bill_no'];
				$arrList[$i][3]=$row['amount'];
				$arrList[$i][4]=$row['status'];
				$arrList[$i][5]=$row['cancellation_details'];
				$arrList[$i][6]=$row['cancellation_date'];
				$arrList[$i][7]=$row['user_id'];
				$arrList[$i][8]=$row['branch_id'];
				$arrList[$i][9]=$row['card_amt'];
				$arrList[$i][10]=$row['upi_amt'];
				
				$i++;
			}
			
		}


		return $arrList;
	
	}
    public function getChequePayments($wheredata){

	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['checque_no'];
				$arrList[$i][2]=$row['checque_amt'];
				$arrList[$i][3]=($row['cheque_issue_date']!="0000-00-00")?$row['cheque_issue_date']:'';
				$arrList[$i][4]=$row['bill_no'];
				$arrList[$i][5]=$row['supplier'];
				$arrList[$i][6]= $this->dbConnection->idToValue('hcare_pharma_suppliers','supplier_name','id',$row['supplier']);
				$arrList[$i][7]= $this->dbConnection->idToValue('hcare_pharma_suppliers','ledger_id','id',$row['supplier']);
				$arrList[$i][8]=$row['ledger_id'];

				
				$i++;
			}
			
		}
	
		return $arrList;
	
	}
    public function getCreditPayments($wheredata){

	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings_credit_payment','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['recievings_id'];
				$arrList[$i][2]=$row['amount'];
				$arrList[$i][3]=$row['date'];
				$arrList[$i][4]=$row['status'];
				$arrList[$i][5]=$row['cancellation_details'];
				$arrList[$i][6]=($row['cancellation_date']!="0000-00-00")?$row['cancellation_date']:'';
				$arrList[$i][7]=$row['user_id'];
				$arrList[$i][8]= $this->dbConnection->idToValue('hcare_pharma_recievings','bill_no','id',$row['recievings_id']);
				$arrList[$i][9]= $this->dbConnection->idToValue('hcare_pharma_recievings','supplier','id',$row['recievings_id']);
				$arrList[$i][10]= $this->dbConnection->idToValue('hcare_pharma_suppliers','supplier_name','id',$arrList[$i][9]);
				$arrList[$i][11]= $this->dbConnection->idToValue('hcare_pharma_suppliers','ledger_id','id',$arrList[$i][9]);
				$arrList[$i][12]=$this->dbConnection->idToValue('hcare_pharma_recievings','acc_entry_id','id',$row['recievings_id']);
				$arrList[$i][13]=$this->dbConnection->idToValue('hcare_pharma_recievings','purchase_mode','id',$row['recievings_id']);
				$arrList[$i][14]=$row['payment_type'];
				$arrList[$i][15]=$row['neft_amount'];
				$arrList[$i][16]=$row['upi_amt'];

				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}




	function brandStocks_and_price($wheredata = null){
	   
		
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_brand','',$wheredata,'brand','asc');

		$result=$this->dbConnection->executeQuery($query);
		
		$i=0;
        $options=array();

		$total_brand_stock=0;
        $total_brand_stock_sellp=0;
        $total_brand_stock_buyp=0;

		$total_branch_stock=0;
		$total_branch_stock_sellp=0;
		$total_branch_stock_buyp=0;
      
		if(mysqli_num_rows($result)>0){
						
			while($row=$result -> fetch_assoc()){

                $sellp = $row['sellp'];
			    $buyp = $row['buyp'];
			
			    $brand_stock = $row['brand_stock'];
			    $total_brand_stock += $brand_stock;
			    $total_brand_stock_sellp += ($brand_stock * $sellp);
			    $total_brand_stock_buyp += ($brand_stock * $buyp);

			    $branch_stock = $row['branch_stock'];
			    $total_branch_stock += $branch_stock;
			    $total_branch_stock_sellp += ($branch_stock * $sellp);
			    $total_branch_stock_buyp += ($branch_stock * $buyp);
				
				
				$i++;
			
	        }	
		}

		$options[0]= $total_brand_stock;
		$options[1]= $total_brand_stock_sellp;
		$options[2]= $total_brand_stock_buyp;
		$options[3]= $total_branch_stock;
		$options[4]= $total_branch_stock_sellp;
		$options[5]= $total_branch_stock_buyp;
      
	    return $options;	
	}  

	// function pharma_daily_stock_history($insert_date,$stock_history){

	// 	$main_stock = $stock_history[0];
	// 	$main_stock_sellp = $stock_history[1];
	// 	$main_stock_buyp = $stock_history[2];
	// 	$branch_stock = $stock_history[3];
	// 	$branch_stock_sellp = $stock_history[4];
	// 	$branch_stock_buyp = $stock_history[5];

 //        $field_names=array("id","date","main_stock","main_stock_sellp","main_stock_buyp","branch_stock","branch_stock_sellp","branch_stock_buyp");
			
	// 	$field_data=array("",$insert_date,$main_stock,$main_stock_sellp,$main_stock_buyp,$branch_stock,$branch_stock_sellp,$branch_stock_buyp);
	
	// 	$result=$this->dbConnection->insert($field_names,$field_data,"hcare_pharma_daily_stock_history");
		
	// 	if($result) return $this->dbConnection->mysqli_connect->insert_id;
	// 	else return 0;

	// } 
	function getPharmaInvoiceAmount($doc_id,$from_date,$to_date){

		$query = "SELECT sum(net_total) as amount FROM  `hcare_pharma_invoice` WHERE  `doc_id` =  '".$doc_id."' AND `bill_date` >=  '".$from_date." 00:00:00' AND  `bill_date` <=  '".$to_date." 23:59:59' AND  `status` =0 AND `sales_mode`='Sales'";

		$result=$this->dbConnection->executeQuery($query);

		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
				
				$amount = $row['amount'];

			}

			return $amount;
			
		}
		else{
			return 0;
		}


	}

	function pharma_get_batch_details($wheredata=null){



	    $query=$this->dbConnection->BuiltQuery('hcare_pharma_batch','',$wheredata,'id','asc');
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

						  $arrList[$i][0]=$row['id'];
						  $arrList[$i][1]=$row['sellp'];
						  $arrList[$i][2]=$row["buyp"];
	                      $arrList[$i][3]=$row["status"];
	                      $arrList[$i][4]=$row["branch_id"];
	                      $arrList[$i][5]=$row["batch_stock"];
	                      $arrList[$i][6]=$row["price_type"];

				
						  $i++;
						
						}
						
			       }

	    return $arrList;

	} 

	function pharma_daily_stock_history($insert_date,$main_stock,$main_sellp,$main_buyp,$branch_stock,$branch_sellp,$branch_buyp){


        $field_names=array("id","date","main_stock","main_stock_sellp","main_stock_buyp","branch_stock","branch_stock_sellp","branch_stock_buyp");
			
		$field_data=array("",$insert_date,$main_stock,$main_sellp,$main_buyp,$branch_stock,$branch_sellp,$branch_buyp);
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_pharma_daily_stock_history");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;

	} 
	public function getItemDiscount($bill_no=null)
	{
		
		$return = 0;

		$query="select  SUM( total ) as total , SUM( gst_amt ) as gst_amt from `hcare_pharma_recievings_items` where `bill_id`='".$bill_no."' and `status`=0 and `disc_type` != '' and `disc_value` !=''";
		$result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

						  $arrList[0]=$row['total'];
						  $arrList[1]=$row['gst_amt'];



				
						  $i++;
						
						}
						
			       }

			       if (!empty($arrList)) {
			       	$return = $arrList[0]-$arrList[1];
			       }
			       else{
			       	$return=0;
			       }

			       // var_dump($return);
	    return $return;


	}
	public function getRecievingsBillItem($bill_no=null)
	{
		
		$return = 0;
		$discout_value = 0;

		$query="select  id, disc_type, disc_value, total from `hcare_pharma_recievings_items` where `bill_id`='".$bill_no."' and `status`=0";
		$result=$this->dbConnection->executeQuery($query);

		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

						  $arrList[$i][0]=$row['id'];
						  $arrList[$i][1]=$row['disc_type'];
						  $arrList[$i][2]=$row['disc_value'];
						  $arrList[$i][3]=$row['total'];

						  if( !empty($row['disc_type']) && !empty($row['disc_value']) ){

						  		if ($row['disc_type'] == 'CASH') {
						  			$discout_value = $row['disc_value'];
						  		}
						  		else{
						  			$discout_value = $row['total'] * ($row['disc_value'] / 100);
						  		}

						  }

						  $arrList[$i][4]+=floatval($discout_value);

				
						  $i++;
						
						}
						
			       }

			       // if (!empty($arrList)) {
			       // 	$return = $arrList[0]-$arrList[1];
			       // }
			       // else{
			       // 	$return=0;
			       // }

			       // var_dump($return);
	    return $arrList;


	}
	

}
?>
