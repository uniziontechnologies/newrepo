<?php 

  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 
  
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/common/ipFunctions.php';

class Billing{

	
	
	function __construct(){		 
		 date_default_timezone_set('Asia/Kolkata');
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}
	
	function addCustomer($post){
	
		$field_names=array("id","name","age","gender","place","contact_no","refferal_info","prefix");
		$field_data=array("",$post['name'],$post['age'],$post['gender'],$post['place'],$post['contact_no'],$post['refferal_info'],$post['prefix']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_direct_customer");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function addCredit($post){

	    date_default_timezone_set('Asia/Kolkata');
	    $user_id=$_SESSION['user_id'];
	     $update_history = $user_id."|". date("d-m-Y H:i a");

	    $total_amount = $post['amount_paid'] + $post['card_amount'];
			 
		$time=date("H:i:s");
		$field_names=array("id","bill_no","bill_date","bill_time","amount","user_id","payment_mode","amount_paid","card_amount");
		$field_data=array("",$post['billid'],date('Y-m-d',strtotime($post['new_date']))." ".$time,date("h:i a"),$total_amount,$_SESSION['user_id'],$post['payment_mode'],$post['amount_paid'],$post['card_amount']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_bill_payments");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}




	function updateCustomer($post){
	
			$id=$post['id'];
			
		$field_names=array("name","age","gender","place","contact_no","refferal_info","prefix");
		$field_data=array($post['name'],$post['age'],$post['gender'],$post['place'],$post['contact_no'],$post['refferal_info'],$post['prefix']);
			
	
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_direct_customer");
		
		if($result) return $id;
		else return 0;
	}
	function addUpdateHistory($post,$netamt){
		
			$field_names=array("bill_id","updated_on","test_id","test_type","amount","bill_amt_bef","bill_amt_aft","action","user_id");
			
			for($i=0;$i<count($_SESSION["items_updated"]);$i++){
			
				$items_in_array=explode("!$%",$_SESSION["items_updated"][$i]);
				
				if($items_in_array[3] == "Removed"){
					$netamt_aft=$netamt-$items_in_array[1];
				}else{
					$netamt_aft=$netamt+$items_in_array[1];
				}
				
				$field_data=array($post['billid'],date("Y-m-d h:i a"),$items_in_array[0],$items_in_array[2],$items_in_array[1],$netamt,$netamt_aft,$items_in_array[3],$_SESSION['user_id']);
				
				$result=$this->dbConnection->insert($field_names,$field_data,"hcare_bill_updations");
				
				$netamt=$netamt_aft;
			
			} 
	}
	function addtoBill($post){
	
		if(!empty($post['card_amount'])){
			$credit_card=$post['card_amount'];
		}else $credit_card=0;
		
		if(!empty($post['ins_deduction'])){
			$ins_deduction=$post['ins_deduction'];
		}else $ins_deduction=0;
		
		if($post['payment_mode'] == "CREDIT" && $post['type']){
		
		  $user_id=$_SESSION['user_id'];
		  $sanc_by="";
		  $auth_remarks="";
		
		}else{
		  $user_id=$_SESSION['user_id'];
		  $sanc_by="";
		  $auth_remarks="";
		}
	  
	        date_default_timezone_set('Asia/Kolkata');
	        $update_history = $user_id."|". date("d-m-Y H:i a")."|ADD";
			
		$amount_paid=$post['amount_paid']+$credit_card+$ins_deduction;
		$credit=$post['net_amount']-$amount_paid;
	    $time=date("H:i:s");
		
		// for email
		if($post['type']=='OP'){ 
			$opno = $this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$post['id']);			
			$r=$this->dbConnection->update(array("email"),array($post['email']),"id",$opno,"hcare_op_patient_info");
		}
		if($post['type']=='IP'){ 
			$opno = $this->dbConnection->idToValue("hcare_ip_info","opno","id",$post['id']);			
			$r=$this->dbConnection->update(array("email"),array($post['email']),"id",$opno,"hcare_op_patient_info");
		}

		
		$field_names=array("id","type","ref_no","total_amount","dr_disc","net_total","paid_with","cash","credit","credit_card","insurance","bill_date","remarks","user_id","opno","update_history","sanctioned_by","sanctioned_remarks","category_id","member_id","email","bill_type");
		$field_data=array("",$post['type'],$post['id'],$post['total_amount'],$post['dr_disc'],$post['net_amount'],$post['payment_mode'],$post['amount_paid'],$credit,$credit_card,$ins_deduction,date("Y-m-d",strtotime($post['date']))." ".$time,$post['remarks'],$_SESSION['user_id'],$post['opno'],$update_history,$sanc_by,$auth_remarks,$post['patient_cat_id'],$post['patient_member_id'],$post['email'],$post['bill_type']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_bill");

		
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	
	}
	function add_advance_payment($post){
	
	     date_default_timezone_set('Asia/Kolkata');
	
	    $field_names=array("id","ipno","payment_mode","cash","card_amount","cheque_no","date","remarks","user_id");
	    $field_data=array("",$post["id"],$post["payment_mode"],$post["advance_amount"],$post["card_amount"],$post["cheque_no"],$post['curr_date_time'],$post['remarks'],$_SESSION['user_id']);
	    
	    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_advance_payments");
		
	   if($result) return $this->dbConnection->mysqli_connect->insert_id;
	   else return 0;
	
	}
	function add_ip_bill($post){
	
	  $user_id=$_SESSION['user_id'];
	  
	  date_default_timezone_set('Asia/Kolkata');
	  $update_history = $user_id."|". date("d-m-Y H:i a");
	  $time=date("H:i:s");
	/*  if($bill_status == 2){*/
	  //bill prepared
	    $field_names=array("id", "ipno","opno","total_amount", "amount_paid","net_amount","remarks","user_id","update_history","bill_status","bill_prepared_date");
	   
	    $field_data=array("", $post['id'],$post['opno'], $post['total_amount'], $post['amount_paid'], $post['balance'],$post['remarks'],$_SESSION['user_id'],$update_history,$post['bill_status'],date("Y-m-d",strtotime($post['bill_prepare_date']))." ".$time);
	
	 /* }else{
	
	   $field_names=array("id", "ipno", "bill_date", "bill_time", "total_amount", "amount_paid", "disc_type", "disc_amt", "balance", "payment_mode", "amount", "card_amount", "cheque_no", "remarks","user_id","update_history");
	   
	    $field_data=array("", $post['id'], $post['curr_date'],$post['curr_time'], $post['total_amount'], $post['amount_paid'], $post['disc_type'], $post['discount'], $post['balance'], $post['payment_mode'], $post['final_amount'], $post['card_amount'],$post['cheque_no'], $post['remarks'],$_SESSION['user_id'],$update_history);
	 }   */
	    
	    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_bill");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	  
	
	}
	function update_ip_bill($post){
	
	  $user_id=$_SESSION['user_id'];
	  
	  date_default_timezone_set('Asia/Kolkata');
	 //updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_ip_bill","update_history","id",$post['billid']);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			   
			   if(!empty($post['auth_user_id'])) 	$update_history = $post['auth_user_id']."|". date("d-m-Y H:i a");	 
		       
	if(!empty($post['auth_user_id'])) $user_id=$post['auth_user_id'];
	
	if($post['payment_mode'] == "CREDIT") {
	
	  $credit_amount=$post['balance']-$post['final_amount'];
	}else $credit_amount=0;
	
	   $field_names=array( "bill_date","disc_type", "disc_amt", "net_amount", "payment_mode", "amount", "card_amount","balance","cheque_amt","cheque_no", "remarks","user_id","update_history","auth_sanc_by","auth_remarks");
	   
	   $field_data=array($post['curr_date'],$post['disc_type'], $post['discount'], $post['balance'], $post['payment_mode'], $post['final_amount'], $post['card_amount'],$credit_amount,$post['cheque_amount'],$post['cheque_no'], $post['remarks'],$_SESSION['user_id'],$update_history,$post['auth_sanc_by'],$post['auth_remarks']);
	
	
	   	$result=$this->dbConnection->update($field_names,$field_data,"id",$post['billid'],"hcare_ip_bill");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	  
	
	}
	
	function add_ip_bill_items($billid,$items,$particulars,$item_id,$qty=null,$price=null,$proce_id=null,$item_type=null){
	  
		$user_id=$_SESSION['user_id'];
		date_default_timezone_set('Asia/Kolkata');
		$update_history = $user_id."|". date("d-m-Y H:i a");
	  
	  if(!empty($qty) && !empty($price) && !empty($proce_id))
	      {
             $field_names=array("id", "billno", "particulars","qty","price", "amount","item_id","proce_id","item_type","update_history");
	         $field_data=array("", $billid, $particulars,$qty,$price, $items,$item_id,$proce_id,$item_type,$update_history);
	      }
      else{
             $field_names=array("id", "billno", "particulars","qty","price", "amount","item_id","proce_id","item_type","update_history");
	         $field_data=array("", $billid, $particulars,1,$items, $items,$item_id,0,$item_type,$update_history);
          }
	    // $field_names=array("id", "billno", "particulars", "amount","item_id");
	    // $field_data=array("", $billid, $particulars, $items,$item_id);
	   
	   
	   $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_bill_items");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	
	}

	function update_newfield_bill_items($post){
		
		$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_ip_bill_items","update_history","id",$post['item_id_update']);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }

		$id=$post['item_id_update'];
			
		$field_names=array("particulars","update_history");
		$field_data=array($post['particular_update'],$update_history);

        

		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_ip_bill_items");
		
		if($result) return $id;
		else return 0;

	}
	
	function updateBill($post){

		// echo $post['email'];exit();

	
			$id=$post['billid'];
			
		if(!empty($post['card_amount'])){
			$credit_card=$post['card_amount'];
		}else $credit_card=0;		
		
		if(!empty($post['ins_deduction'])){
			$ins_deduction=$post['ins_deduction'];
		}else $ins_deduction=0;
		
		//updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_bill","update_history","id",$id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		       
		$amount_paid=$post['amount_paid']+$credit_card+$ins_deduction;
		$credit=$post['net_amount']-$amount_paid;
	
		$field_names=array("type","ref_no","total_amount","dr_disc","net_total","paid_with","cash","credit","credit_card","insurance","bill_date","remarks","update_history");
		$field_data=array($post['type'],$post['id'],$post['total_amount'],$post['dr_disc'],$post['net_amount'],$post['payment_mode'],$post['amount_paid'],$credit,$credit_card,$ins_deduction,date("Y-m-d",strtotime($post['date'])),$post['remarks'],$update_history);
			
	
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_bill");
		
		if($result) return $id;
		else return 0;
	}
	function addToBillItems($bill_id,$items,$post,$sub_amounts = NULL){
	
		if (!empty($items[4])) {
			$discount=$items[5]-$items[4];
		}
		
		if($items[6] == "P"){
		if($sub_amounts[2] > 0){
		  $field_names=array("id","bill_id","bill_date","type","test_type","test_id","category_id","qty","test_amount","hosp_amount","dr_amount","surgeon_fee","theatre_charge","anasthesia","other_charges","assistant_fee1","assistant_fee2","discount_type","discount_value","discount","net_amount","surgeon_id","doc_id_prescribed");
		}else{
		 $field_names=array("id","bill_id","bill_date","type","test_type","test_id","category_id","qty","test_amount","hosp_amount","dr_amount","surgeon_fee","theatre_charge","anasthesia","other_charges","assistant_fee1","assistant_fee2","discount_type","discount_value","discount","net_amount","doc_id","doc_id_prescribed");
		
		}
		$field_data=array("",$bill_id,date("Y-m-d",strtotime($post['date'])),$items[6],$items[8],$items[0],$items[7],$items[13],$items[2],$sub_amounts[0],$sub_amounts[1],$sub_amounts[2],$sub_amounts[3],$sub_amounts[4],$sub_amounts[5],$sub_amounts[6],$sub_amounts[7],$items[3],$items[4],$discount,$items[5],$items[9],$post['doc_id_prescribed']);
		
		}else{
		
		$field_names=array("id","bill_id","bill_date","type","test_type","test_id","category_id","qty","test_amount","discount_type","discount_value","discount","net_amount","doc_id_prescribed");
		$field_data=array("",$bill_id,date("Y-m-d",strtotime($post['date'])),$items[6],$items[8],$items[0],$items[7],$items[13],$items[2],$items[3],$items[4],$discount,$items[5],$post['doc_id_prescribed']);
		  if($items[6] == "PACKAGE"){
		     $field_names[]="heading";
		     $field_data[]=1;
		     
		     if($items[10] > 0){
		        $field_names[]="dr_amount";
			$field_data[]=$items[10];
			
			$field_names[]="doc_id";
		        $field_data[]=$items[9];
			
		     }
		  }
		
		}
	        if(!empty($post['package_id'])){
		
		     $field_names[]="package_id";
		     $field_data[]=$post['package_id'];
		}
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_bill_items");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function deleteBillItems($post){
	
		$id=$post['billid'];
		$where[0]="bill_id ='".$id."'";
		$result=$this->dbConnection->deletePermenantly($where,"hcare_bill_items");
		
		if($result) return true;
		else return false;
	}
	public function getCreditBillInfo($wheredata){
	
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
				$arrList[$i][7]=$row['payment_mode'];
				$arrList[$i][8]=$row['amount_paid'];
				$arrList[$i][9]=$row['card_amount'];
				$arrList[$i][10]=$row['status'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
		public function getCreditBillInfo2($wheredata){
	
		$arrList=array();
		$i=0;
		$selectdata[]='amount';
		$selectdata[]='status=0';
		$query=$this->dbConnection->BuiltQuery('hcare_bill_payments',$selectdata,$wheredata,'','');
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][3]=$row['amount'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}

	public function getIPBillInfo($wheredata=null){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_ip_bill','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['ipno'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['bill_time'];
				$arrList[$i][4]=$row['total_amount'];
				$arrList[$i][5]=$row['amount_paid'];
				$arrList[$i][6]=$row['disc_type'];
				$arrList[$i][7]=$row['disc_amt'];
				$arrList[$i][8]=$row['net_amount'];
				$arrList[$i][9]=$row['payment_mode'];
				$arrList[$i][10]=$row['amount'];
				$arrList[$i][11]=$row['card_amount'];
				$arrList[$i][12]=$row['cheque_no'];
				$arrList[$i][13]=$row['remarks'];
				$arrList[$i][14]=$row['user_id'];
				
				
				
				$opno= $this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ipno']);
				$room_id= $this->dbConnection->idToValue("hcare_ip_info","room_id","id",$row['ipno']);

				// $wherefield[0] = "id = '".$row['ipno']."'";
				// $wherefield[1] = "cancelled = 0";

				// $room_id= $this->dbConnection->idToValueMultiple("id",$wherefield,"hcare_ip_info");

                $roomno= $this->dbConnection->idToValue("hcare_rooms","room_number","id",$room_id);
				
				
				$arrList[$i][15]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);

                                $arrList[$i][16]=$roomno;
				 //split updation history
		                $update_history='';
			
			        if(!empty($row['update_history'])){
			            $history_split=explode("&&",$row['update_history']);
				    
			            if(!empty($history_split)){
			
			              for($m=0;$m<count($history_split);$m++) {
			                 $history_info=explode("|",$history_split[$m]);
			                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                  $datetime=$history_info[1];
					  $update_history .=$user_name.":".$datetime."<br>";
			             }
			           }
		                }
			           $arrList[$i][17]= $update_history;
					    $employee_id= $this->dbConnection->idToValue("hcare_users","employee_id","id",$row['user_id']);
						$arrList[$i][18]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$employee_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$employee_id);
				        $arrList[$i][19]=$row['bill_status'];
						$arrList[$i][20]=$row['bill_prepared_date'];
						$arrList[$i][21]=$row['auth_sanc_by'];
						$arrList[$i][22]=$row['auth_remarks'];
						$arrList[$i][23]=$opno;
						$arrList[$i][24]=$row['balance'];
						
						$total_amount_paid=$row['amount_paid']+$row['amount']+$row['card_amount']+$row['cheque_amt'];
						$arrList[$i][25]=$total_amount_paid;
						$arrList[$i][26]=$row['credit_paid'];
						$arrList[$i][27]=$row['cancellation_details'];
						$arrList[$i][28]=$row['cheque_amt'];
						$arrList[$i][29]=$room_id;
						$arrList[$i][30]= $this->dbConnection->idToValue("hcare_room_beds","id","room_id",$room_id);
						$arrList[$i][31]= $this->dbConnection->idToValue("hcare_room_beds","bed_status","id",$arrList[$i][30]);
						$arrList[$i][32]= $this->dbConnection->idToValue("hcare_ip_info","bed_id","id",$arrList[$i][1]);
						$arrList[$i][33]= $this->dbConnection->idToValue("hcare_room_beds","bed_status","id",$arrList[$i][32]);

				               	
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	public function get_S_IPBillInfo($ipno=null){
	
		
		$wheredata=array();
       $wheredata[0]="b.type = 'P'";	  
       $wheredata[1]="b.category_id=2"; 
       $wheredata[2]="a.type='IP'";
       $wheredata[3]="a.ref_no='".$ipno."'";
		$wheredata[4]="a.status=0";   

       $groupby="b.category_id";     
       $details['xray']=$this->getBillItemLab($wheredata,$groupby);



       $wheredata=array();
       $wheredata[0]="(b.type = 'LT' or b.type = 'LE')"; 
       $wheredata[1]="a.type='IP'";
       $wheredata[2]="a.ref_no='".$ipno."'";  
	   $wheredata[3]="a.status=0";                                                                    
       $details['lab']=$this->getBillItemLab($wheredata);
		return $details;
	
	}
	function getIPBillItemCount($wheredata = null){
	
		$arrList=array();
		
		
		$query=$this->dbConnection->BuiltQuery('hcare_ip_bill_items','',$wheredata,'item_id','asc');		
		$result=$this->dbConnection->executeQuery($query);
		
		return mysqli_num_rows($result);
	}
	public function getIPBillItems($wheredata,$limit =null){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_ip_bill_items','',$wheredata,'item_id','asc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['billno'];
				$arrList[$i][2]=$row['particulars'];
				$arrList[$i][3]=$row['amount'];
				$arrList[$i][4]=$row['item_id'];

			    //split updation history
		        $update_history='';
			
			    if(!empty($row['update_history'])){

			        $history_split=explode("&&",$row['update_history']);
				    
			            if(!empty($history_split)){
			
			                for($m=0;$m<count($history_split);$m++) {
			                    $history_info=explode("|",$history_split[$m]);
			                    $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                    $datetime=$history_info[1];
					            $update_history .=$user_name.":".$datetime."<br>";
			                }
			             }
		        }


				$arrList[$i][5]=$update_history;
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function cancel_advance_payment($post){
	
		$id=$post['billid'];
		
		$cancellation_details=$post['cancellation_details'];
		$user_id=$_SESSION['user_id'];
		
		$field_names1=array('status','cancellation_details','cancellation_date','cancelled_by');
		$field_data=array('1',"$cancellation_details",$post['cancel_date'],$user_id);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_advance_payments");
		
		if($result) return true;
		else return false;
	}
	function getAdvancePayments($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_advance_payments','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['ipno'];
				$arrList[$i][2]=$row['payment_mode'];
				$arrList[$i][3]=$row['cash'];
				$arrList[$i][4]=$row['card_amount'];
				
				$arrList[$i][5]=$row['cheque_no'];
				$arrList[$i][6]=$row['date'];
				
				$arrList[$i][7]=$row['user_id'];
				
				
				
				$opno= $this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ipno']);
				$prefix= $this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$opno);
				$room_id= $this->dbConnection->idToValue("hcare_ip_info","room_id","id",$row['ipno']);
                $roomno= $this->dbConnection->idToValue("hcare_rooms","room_number","id",$room_id);
				
				
				$arrList[$i][8]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);

                $arrList[$i][9]=$roomno;

                                $arrList[$i][10]=$row['remarks'];
                                $arrList[$i][11]=$row['user_id'];
								$arrList[$i][12]=$opno;
								$arrList[$i][13]=$prefix;
								$arrList[$i][14]=$row['status'];
								$arrList[$i][15]=$row['cancellation_details'];
								$arrList[$i][16]=$row['cancellation_date'];
								$arrList[$i][17]=$row['cancelled_by'];
								$arrList[$i][18]=$this->dbConnection->idToValue('hcare_users','user_name','id', $row['cancelled_by']);
								
								$arrList[$i][19]=$this->dbConnection->idToValue('hcare_users','user_name','id', $row['user_id']);
			                                                  
				
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
		 	 	 	 	 	 	 	 	 	 	  	 	 	 	 	 	 	 	
	public function getfullCreditInfo($wheredata){   
	
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`type`";
				$arrFieldList[2]= "a.`ref_no`";
				$arrFieldList[3]= "a.`total_amount`";
				$arrFieldList[4]= "a.`dr_disc`";
				$arrFieldList[5]= "a.`net_total`";
				$arrFieldList[6]= "a.`paid_with`";
				$arrFieldList[7]= "a.`cash`";
				$arrFieldList[8]= "a.`credit`";
				$arrFieldList[9]= "a.`credit_card`";
				$arrFieldList[10]= "a.`insurance`";
				$arrFieldList[11]= "a.`bill_date`";
				$arrFieldList[12]= "a.`remarks`";
				$arrFieldList[13]= "a.`user_id`";
				$arrFieldList[14]= "a.`status`";
				
				$arrFieldList[15]= "b.`id`";
				$arrFieldList[16]= "b.`bill_no`";
				$arrFieldList[17]= "b.`bill_date`";
				$arrFieldList[18]= "b.`amount`";
				$arrFieldList[19]= "b.`user_id`";
				
				$arrTables[0] = "`hcare_bill` a";
       			        $arrTables[1] = "`hcare_bill_payments` b";
				
				$joinConditions[1] = "a.`id` = b.`bill_no`";
				
				if(!empty($wheredata)) {
					for($k=0;$k<count($wheredata);$k++){
					
						$selectConditions[]=$wheredata[$k];
					}
				}
				
        		$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions);
			
				$result=$this->dbConnection->executeQuery($query);
				$i=0;
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
									
								for($k=0;$k<count($arrFieldList);$k++) {						
								
									$arrList[$i][$k]=$row[$k];
								}
								if($row[1] == "OP" || $row[1] == "IP"){
								
								if($row[1] == "IP"){
									$bill_status=$this->dbConnection->idToValue("hcare_ip_info","bill_status","id",$row[2]);
					                             
					                               $opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row[2]);
					                        }else{
								        $opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$row[2]);
								}
                                                                      
									$arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
								}else{
									$arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row[2]);
                                                                       $opno=0;
								}

                                $arrList[$i][$k++]=$opno;

                                $arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_bill_payments","payment_mode","id",$row[15]);
                                $arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_bill_payments","amount_paid","id",$row[15]);
                                $arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_bill_payments","card_amount","id",$row[15]);

                                $arrList[$i][$k++]=$total[$i]=$this->dbConnection->idToValue("hcare_bill_payments","sum(amount)","id",$row[15]);
                                 $arrList[$i][$k++]=$a[$i]=$this->dbConnection->idToValue("hcare_bill_payments","cancellation_details","id",$row[15]);

                

                               $arrList[$i]['name']=$this->dbConnection->idToValue('hcare_users','user_name','id', $row[19]);
                               $arrList[$i][$k++]=$bill_status;
                             
                             // $arrList[$i][$k++]=$a[$i]=$this->dbConnection->idToValue("hcare_bill_payments","cancellation_details","id",$row[15]);
							
	                     

								$i++;
						
						}
				
				}
			return $arrList;
				
				
				
	}
	/*function getIPBillFieldInfo($selectField,$wheredata){
	
	           
		   
		   
		   $query=$this->dbConnection->BuiltQuery('hcare_bill',$selectField,$wheredata);	
		   $result=$this->dbConnection->executeQuery($query);
		   
		   $i=0;
		   
			if(mysqli_num_rows($result) > 0){
			
			  while($row=$result -> fetch_assoc()){
			
			         for($k=0;$k<count($wheredata);$k++){
			         
			             $arrList[$i][$k]=$row[$selectField[$k]];
			         }
			         
			         $i++;
			   }
			}
			
			return $arrList;
	}*/
	
	
	function getBillConsoItems($wheredata = null ){
	
	
			$selectField[0]="sum(b.net_amount)";
			$selectField[1]="count(b.test_id)";
			$selectField[2]="b.type";
			$selectField[3]="b.test_id";
			$selectField[4]="b.test_type";
			$selectField[5]="b.category_id";
			$selectField[6]="sum(b.qty)";
			
			$arrTables[0] = "`hcare_bill` a";
       	    $arrTables[1] = "`hcare_bill_items` b";
				
			$joinConditions[1] = "a.`id` = b.`bill_id`";
				
			
			$group_by="b.type,b.test_id,b.category_id";
			
			
			if(!empty($wheredata)) {
					for($k=0;$k<count($wheredata);$k++){
					
						$selectConditions[]=$wheredata[$k];
					}
				}
				
        	
			$query=$this->dbConnection->selectFromMultipleTable($selectField, $arrTables, $joinConditions, $selectConditions,'','b.id','asc','',$group_by);
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
			if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['sum(b.net_amount)'];
				$arrList[$i][1]=$row['count(b.test_id)'];
				$arrList[$i][2]=$row['type'];
				$arrList[$i][3]=$row['test_id'];
				$arrList[$i][4]=$row['test_type'];
				
				if($row['type'] == "C") {
				
					$arrList[$i][5]="Consultation";
					
				}else if($row['type'] == "P") {
				
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					
				}else if($row['type'] == "L") {
				
					$cid=$row['category_id'];
					$check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					if($cid == $check_catid){
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					}else {
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					}
				}else if($row['type'] == "LT") {
				
					
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				}else if($row['type'] == "LE") {
				
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				}

				$arrList[$i][6]=$row['sum(b.qty)'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function getAllBillItemPatient($wheredata = null,$groupby= null ){
	
	
	  $arrFieldList[0]= "a.`id`";
	  $arrFieldList[1]="b.test_id";
	  $arrFieldList[2]="b.type";
	  
	  
	  $arrTables[0] = "`hcare_bill` a";
          $arrTables[1] = "`hcare_bill_items` b";
          
          $joinConditions[1] = "a.`id` = b.`bill_id`";
          
          
         $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby,'',$groupby);
				
	$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['id'];
						  $arrList[$i][1]=$row['test_id'];
						  
						  
						  
						  if($row['type'] == "C") {
				
					               $arrList[$i][2]="Consultation";
					
				                 }else if($row['type'] == "P") {
				
					              $arrList[$i][2]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					
				                  }else if($row['type'] == "L") {
				
					                   $cid=$row['category_id'];
					                   $check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					                   
					                   if($cid == $check_catid){
					                   
								$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
							}else {
								$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
							}
						}else if($row['type'] == "LT") {
				
					
						      $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				                }else if($row['type'] == "LE") {
				
						     $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				                }
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	
	}
	function getBillItemPatient($wheredata = null,$groupby= null ){
	
	
	  $arrFieldList[0]= "a.`id`";
	  $arrFieldList[1]="sum(b.net_amount)";
	  $arrFieldList[2]="b.test_id";
	  $arrFieldList[3]="b.type";
	  $arrFieldList[4]="c.status";
	  
	  
	  
	      $arrTables[0] = "`hcare_bill` a";
          $arrTables[1] = "`hcare_bill_items` b";
          $arrTables[2] = "`hcare_bill_payments` c";
          
          $joinConditions[1] = "a.`id` = b.`bill_id` ";
          $joinConditions[2] = "a.`id` = c.`bill_no`";
          
         $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby,'',$groupby);
        
				
	$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
					
						  $arrList[$i][0]=$row['sum(b.net_amount)'];
						  $arrList[$i][1]=$row['test_id'];

						  
						  
						  
						  if($row['type'] == "C") {
				
					               $arrList[$i][2]="Consultation";
					
				                 }else if($row['type'] == "P") {
				
					              $arrList[$i][2]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					
				                  }else if($row['type'] == "L") {
				
					                   $cid=$row['category_id'];
					                   $check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					                   
					                   if($cid == $check_catid){
					                   
								$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
							}else {
								$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
							}
						}else if($row['type'] == "LT") {
				
					
						      $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				                }else if($row['type'] == "LE") {
				
						     $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				                }
				                //category id for labour charges
				                $arrList[$i][3]=$row['category_id'];
				                $arrList[$i][4]=$row['bill_id'];
				
							$i++;
						
						}
						
			       }

			       return $arrList;
	
	}

		function getBillItemLab($wheredata = null,$groupby= null ){
	
	
	  	
	  $arrFieldList[0]= "distinct(a.`id`)";
	  $arrFieldList[1]="a.bill_date";
	  $arrFieldList[2]="a.net_total";
	  $arrFieldList[3]="a.cash";
	  $arrFieldList[4]="a.credit";
	  $arrFieldList[5]="a.credit_card";
	  $arrFieldList[6]="a.insurance";
	  
	  
	  $arrTables[0] = "`hcare_bill` a";
	  $arrTables[1] = "`hcare_bill_items` b";
          
      $joinConditions[1] = "a.`id` = b.`bill_id`";
          
          
         $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby,'',$groupby);
       
	$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
							$arrList[$i][0]=$row['id'];
							$arrList[$i][1] = $row['bill_date'];
							$arrList[$i][2] = $row['net_total'];			  	
							$arrList[$i][3]= $row['cash']+$row['credit_card']+$row['insurance'];
							$arrList[$i][4]=$row["credit"];
							$arrList[$i][5] = $this->getBillItemLabCredit($row['id']);
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	
	}

	function getBillTheatreProcedure($wheredata = null,$groupby= null ){
	
	
	  $arrFieldList[0]= "a.id";
	  $arrFieldList[1]="b.hosp_amount";
	  $arrFieldList[2]="b.surgeon_fee";
	  $arrFieldList[3]="b.theatre_charge";
	  $arrFieldList[4]="b.anasthesia";
	  $arrFieldList[5]="b.other_charges";
	  $arrFieldList[6]="b.test_id";
	  $arrFieldList[7]="c.status";
	  
	  
	  
	      $arrTables[0] = "`hcare_bill` a";
          $arrTables[1] = "`hcare_bill_items` b";
           $arrTables[2] = "`hcare_bill_payments` c";
          
          $joinConditions[1] = "a.`id` = b.`bill_id`";
           $joinConditions[2] = "a.`id` = c.`bill_no`";

          
		  $wheredata[]= "b.category_id =4";
          
          $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby,'',$groupby);
				
	$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['id'];
						  $arrList[$i][1]=$row['hosp_amount'];
						  $arrList[$i][2]=$row["surgeon_fee"];
	                      $arrList[$i][3]=$row["theatre_charge"];
	                      $arrList[$i][4]=$row["anasthesia"];
	                     $arrList[$i][5]=$row["other_charges"];
						 $arrList[$i][6]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
						 $i++;
						
						}
						
			       }
			       return $arrList;
	
	}
function getBillTheatreProcedure_details($wheredata = null,$groupby= null ){
	
	
	  $arrFieldList[0]= "a.id";
	  $arrFieldList[1]="b.hosp_amount";
	  $arrFieldList[2]="b.surgeon_fee";
	  $arrFieldList[3]="b.theatre_charge";
	  $arrFieldList[4]="b.anasthesia";
	  $arrFieldList[5]="b.other_charges";
	  $arrFieldList[6]="b.test_id";
	  $arrFieldList[7]= "a.bill_date";
	  $arrFieldList[8]="a.net_total";
	  $arrFieldList[9]="a.cash";
	  $arrFieldList[10]="a.credit";
	  $arrFieldList[11]="a.credit_card";
	  $arrFieldList[12]="a.insurance";
	  
	  
	  
	      $arrTables[0] = "`hcare_bill` a";
          $arrTables[1] = "`hcare_bill_items` b";
          
          $joinConditions[1] = "a.`id` = b.`bill_id`";
          
		  $wheredata[]= "b.category_id =4";
          
          $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby,'',$groupby);
          
	$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['id'];
						  $arrList[$i][1]=$row['hosp_amount'];
						  $arrList[$i][2]=$row["surgeon_fee"];
	                      $arrList[$i][3]=$row["theatre_charge"];
	                      $arrList[$i][4]=$row["anasthesia"];
	                     $arrList[$i][5]=$row["other_charges"];
						 $arrList[$i][6]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
						 $arrList[$i][7]=$row["bill_date"];
						 $arrList[$i][8]=$row["net_total"];
						 $arrList[$i][9]=$row["cash"]+$row["credit_card"]+$row["insurance"];
						 $arrList[$i][10]=$row["credit"];
						 $i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	
	}
	function getBillConsolidated($wheredata = null){
	
	   $arrFieldList[0]="sum(cash)";
	   $arrFieldList[1]="sum(credit)";
	   $arrFieldList[2]="sum(credit_card)";
	   $arrFieldList[3]="sum(net_total)";
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_bill',$arrFieldList,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['sum(cash)'];
						  $arrList[$i][1]=$row['sum(credit)'];
						  $arrList[$i][2]=$row["sum(credit_card)"];
	                      $arrList[$i][3]=$row["sum(net_total)"];
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}
	function getBillInfoAllField($wheredata = null ,$orderbyfield = null,$oderby = null,$credit_status = false){
		$arrList=array();
	
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`type`";
				$arrFieldList[2]= "a.`ref_no`";
				$arrFieldList[3]= "a.`total_amount`";
				$arrFieldList[4]= "a.`dr_disc`";
				$arrFieldList[5]= "a.`net_total`";
				$arrFieldList[6]= "a.`paid_with`";
				$arrFieldList[7]= "a.`cash`";
				$arrFieldList[8]= "a.`credit`";
				$arrFieldList[9]= "a.`credit_card`";
				$arrFieldList[10]= "a.`insurance`";
				$arrFieldList[11]= "a.`bill_date`";
				$arrFieldList[12]= "a.`remarks`";
				$arrFieldList[13]= "a.`user_id`";
				$arrFieldList[14]= "a.`status`";
				$arrFieldList[15]= "a.`lab_status`";
				$arrFieldList[16]= "b.`id`";
				$arrFieldList[17]= "b.`first_name`";
				$arrFieldList[18]= "b.`middle_name`";
				$arrFieldList[19]= "b.`last_name`";
				$arrFieldList[20]= "b.`age`";
				$arrFieldList[21]= "b.`gender`";
				$arrFieldList[22]= "b.`place`";
				$arrFieldList[23]= "b.`contact_no`";
				$arrFieldList[24]= "c.`name`";
				$arrFieldList[25]= "c.`age`";
				$arrFieldList[26]= "c.`gender`";
				$arrFieldList[27]= "c.`place`";
				$arrFieldList[28]= "c.`contact_no`";
				$arrFieldList[29]= "c.`refferal_info`";
				$arrFieldList[30]= "a.`cancellation_details`";
				$arrFieldList[31]= "a.`update_history`";
				$arrFieldList[32]= "a.`sanctioned_by`";
				$arrFieldList[33]= "a.`sanctioned_remarks`";
				$arrFieldList[34]= "a.`result_verified_by`";

				//for mail
				$arrFieldList[35]= "a.`email`";
				$arrFieldList[36]= "a.`email_status`";
				
				$arrTables[0] = "`hcare_bill` a";
       			        $arrTables[1] = "`hcare_op_patient_info` b";
       			        $arrTables[2] = "`hcare_direct_customer` c";	
       			       			    
					
				$joinConditions[1] = "a.`opno` = b.`id`";
        		$joinConditions[2] = "a.`ref_no` = c.`id`";
        		         
					
				
				
				$orderbyfield="a.id";
				$orderby="asc";
				
				$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $wheredata,'',$orderbyfield,$oderby);
				
				$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){

                                                       $ip_card_amount=0;
                                                       $ip_cash_amount=0;
						
						
							//Calculating Credit Balance amount
							$data=true;
							$where[0]="bill_no='".$row[0]."'";
							$where[1]="status=0";

							$creditInfo=$this->getCreditBillInfo($where);

							$creditPayment=0;
							if(!empty($creditInfo)){
					 
								for($k=0;$k<count($creditInfo);$k++){
					
									$creditPayment=$creditPayment+$creditInfo[$k][3];
									//var_dump($creditPayment);
								}
							}
				
							$credit_amount=$row['credit']-$creditPayment;
							
							if($credit_status == true && $credit_amount <= 0){ 
				 				$data=false; 
							}
			
							if($data) {

								$arrList[$i][0]=$row[0];
								$arrList[$i][1]=$row[1];
								$arrList[$i][2]=$row[2];

                                                                $credit=$row['credit'];
				
								if($row[1] == "OP" || $row[1] == "IP"){
					
					                             if($row[1] == "IP"){
					                             
					                               $opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row[2]);
					                               //get doc id from patient visit info
									$doc_id=$this->dbConnection->idToValue("hcare_ip_info","doc_id","id",$row[2]);

                                                                       $discharge_date=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ref_no']);

                                        if($discharge_date !='' && $discharge_date !=="0000-00-00"){
                                            
                                           if($payment_mode =="CREDIT CARD") $ip_card_amount=$row['credit'];
                                           else $ip_cash_amount=$row['credit'];;
                                           /*patient recod ip bill info balance mismatch because of the following two lines
                                           $credit=0;
                                           $creditPayment=0;*/
                                           $credit=0;
                                           $creditPayment=0;

                                        }

                                      //for member category
				                    $cat_id=$this->dbConnection->idToValue("hcare_ip_info","patient_category","id",$row[2]);
				                    $pat_id=$this->dbConnection->idToValue("hcare_ip_info","member_patient_id","id",$row[2]);

				                    $arrList[$i][35] = $this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$cat_id);
				                    $arrList[$i][36] = $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$pat_id);
										}else{
									$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$row[2]);
									//get doc id from patient visit info
									$doc_id=$this->dbConnection->idToValue("hcare_op_visit_info","doc_id","id",$row[2]);
									//for member category
				                    $cat_id=$this->dbConnection->idToValue("hcare_op_visit_info","patient_category","id",$row[2]);
				                    $pat_id=$this->dbConnection->idToValue("hcare_op_visit_info","member_patient_id","id",$row[2]);

				                    $arrList[$i][35] = $this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$cat_id);
				                    $arrList[$i][36] = $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$pat_id);
								     }
					
									$arrList[$i][3]=$row[17]." ".$row[18]." ".$row[19];
					
									$arrList[$i][4]=$row[20];
									$arrList[$i][5]=$row[21];
									$arrList[$i][6]=$row[22];
									$arrList[$i][7]=$row[23];
									
										
													
									$arrList[$i][8]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$doc_id);
									
								}else{
				
									$opno=0;
									$arrList[$i][3]=$row[24];
					
									$arrList[$i][4]=$row[25];
									$arrList[$i][5]=$row[26];
									$arrList[$i][6]=$row[27];
									$arrList[$i][7]=$row[28];			
									$arrList[$i][8]=$row[29];
								}
				
								$arrList[$i][9]=$row[3];
								$arrList[$i][10]=$row[4];
								$arrList[$i][11]=$row[5];
								$arrList[$i][12]=$row[6];
								$arrList[$i][13]=$row[7]+$creditPayment+$ip_cash_amount;
								$arrList[$i][14]=$credit-$creditPayment;
								$arrList[$i][15]=$row[9]+$ip_card_amount;
								$arrList[$i][16]=date("Y-m-d",strtotime($row[11]));
								$arrList[$i][17]=$row[12];
								$arrList[$i][18]=$row[13];
								$arrList[$i][19]=$opno;
								$arrList[$i][20]=$row[10];
								$arrList[$i][21]=$row[8];
								$arrList[$i][22]=$row[14];
								$arrList[$i][23]=$row[30];
								$arrList[$i][24]=$row[7];
								$arrList[$i][25]=$creditPayment;
								$arrList[$i][26]=$row[32];
								$arrList[$i][27]=$row[33];
								$arrList[$i][28]=$row[15];

								//mamge billing

									$arrList[$i][37] = $this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$row[35]);
				                    $arrList[$i][38] = $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$row[36]);
								
								if($row[34] > 0){
														 
									 $arrList[$i][29]=$row[34];
									 $arrList[$i][30]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row[34]);
								}else{
														 $result_verified_by=$this->dbConnection->idToValue("hcare_lab_result","result_verified_by","billno",$row[0]);
														 $verified_by ="";
														 if(!empty($result_verified_by)){
			                                                  $history_split=explode("|",$result_verified_by);
				    
			                                                    if(!empty($history_split)){
			
			                                                         for($m=0;$m<count($history_split);$m++) {
			                                                              $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_split[$m]);
			                                                  
					                                                       $verified_by .=$user_name."<br>";
														             }
			                                                    }
														 }
														  $arrList[$i][29]=$result_verified_by;
														 $arrList[$i][30]=$verified_by;
													 }
			                                        
													
													  $result_entered_by=$this->dbConnection->idToValue("hcare_lab_result","result_entered_by","billno",$row[0]);
													  $entered_by='';
			
			                                         if(!empty($result_entered_by)){
			                                             $history_split=explode("&&",$result_entered_by);
				    
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("|",$history_split[$m]);
			                                                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                                  $datetime = isset($history_info[1]) ? $history_info[1] : null;
			                                                  // $datetime=$history_info[1];
					                                         $entered_by .=$user_name.":".$datetime."<br>";
			                                             }
			                                            }
		                                                }
														
														$arrList[$i][31]=$entered_by;
														$arrList[$i][32]=$this->dbConnection->idToValue("hcare_lab_result","result_date","billno",$row[0]);




			       										 //split updation history
		                                                $update_history='';
			
			                                         if(!empty($row[31])){
			                                             $history_split=explode("&&",$row['update_history']);
				    
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("|",$history_split[$m]);
			                                                  // var_dump($history_info);
			                                                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                                  $datetime=$history_info[1];
			                                                  $action=$history_info[2];
			                                                  if (!empty($action)) {
			                                                  	$paction=$action." | ";
			                                                  }
			                                                  else{
			                                                  	$paction="";
			                                                  }

					                                  $update_history .=$paction.$user_name.":".$datetime."<br>";
			                                             }
			                                         }
		                                                }

		                                                $arrList[$i][33]=$update_history;


						$sql1 = "select sum(amount_paid),sum(card_amount) from `hcare_bill_payments` where `bill_no`='".$row[0]."' and status=0";

														$result1=$this->dbConnection->executeQuery($sql1);

														if(mysqli_num_rows($result1) > 0){
			
															while($row1=mysqli_fetch_array($result1)){

																$arrList[$i][34]=$row1['sum(amount_paid)'];
																$arrList[$i][35]=$row1['sum(card_amount)'];

															}

														}
								$arrList[$i]['card']=$row[9];
								//for mail
								$arrList[$i]['email']=$row[35];
								$arrList[$i]['email_status']=$row[36];

								$i++;
								
							}
			
								
						}
				
				}
			return $arrList;
				
	}
	function getBillCount($wheredata){
	
	    $query=$this->dbConnection->BuiltQuery('hcare_bill','',$wheredata,'','','','');	
		$result=$this->dbConnection->executeQuery($query);
				return mysqli_num_rows($result);
	}
	function getBillInfo($wheredata = null ,$orderbyfield = 'id',$oderby = 'asc',$credit = false,$limit=null ){
	
		$arrList=array();
		$ip_visit_id='';
		$i=0;
		$data=true;
		$query=$this->dbConnection->BuiltQuery('hcare_bill','',$wheredata,$orderbyfield,$oderby,'',$limit);	
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
			    $where[1]="status=0";
				$creditInfo=$this->getCreditBillInfo($where);

				$creditPayment=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$creditPayment=$creditPayment+$creditInfo[$k][3];
					}
				}
			
				
				$credit_amount=$row['credit']-$creditPayment;
				if($credit == true && $credit_amount <= 0){ 
				 $data=false; 
				}
			
			if($data){
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['type'];
				$arrList[$i][2]=$row['ref_no'];
                                $credit_amt=$row['credit'];
				
				if($row['type'] == "OP" || $row['type'] == "IP") {
					
                    if($row['type'] == "OP") {
					$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$row['ref_no']);
                    $doc_id=$this->dbConnection->idToValue("hcare_op_visit_info","doc_id","id",$row['ref_no']);
                    $prefix=$this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$opno);

                    //for member category
                    $cat_id=$this->dbConnection->idToValue("hcare_op_visit_info","patient_category","id",$row['ref_no']);
                    $pat_id=$this->dbConnection->idToValue("hcare_op_visit_info","member_patient_id","id",$row['ref_no']);

                    $arrList[$i][43] = $this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$cat_id);
                    $arrList[$i][44] = $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$pat_id);

                   }else if($row['type'] == "IP") {

					$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ref_no']);
					$bill_status=$this->dbConnection->idToValue("hcare_ip_info","bill_status","id",$row['ref_no']);
                                        $doc_id=$this->dbConnection->idToValue("hcare_ip_info","doc_id","id",$row['ref_no']);	
                                       $prefix='';
                                        $discharge_date=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ref_no']);

                                        if($discharge_date !='' && $discharge_date !=="0000-00-00"){
                                        	$payment_mode='';
                                            
                                           if($payment_mode =="CREDIT CARD") $ip_card_amount=$row['credit'];
                                           else $ip_cash_amount=$row['credit'];;

                                           $credit_amt=0;
                                           $creditPayment=0;

                                        }
                    $ip_visit_id=$this->dbConnection->idToValue("hcare_ip_info","visit_id","id",$row['ref_no']);

                    //for member category
                    $cat_id=$this->dbConnection->idToValue("hcare_ip_info","patient_category","id",$row['ref_no']);
                    $pat_id=$this->dbConnection->idToValue("hcare_ip_info","member_patient_id","id",$row['ref_no']);

                    $arrList[$i][43] = $this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$cat_id);
                    $arrList[$i][44] = $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$pat_id);
                   }
					
				       $arrList[$i][3]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
					$arrList[$i][4]=$this->dbConnection->idToValue("hcare_op_patient_info","age","id",$opno);
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_op_patient_info","gender","id",$opno);
					$arrList[$i][6]=$this->dbConnection->idToValue("hcare_op_patient_info","place","id",$opno);
					$arrList[$i][7]=$this->dbConnection->idToValue("hcare_op_patient_info","contact_no","id",$opno);
									
					$arrList[$i][8]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$doc_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$doc_id);

					
                         $query1 = "select age from `hcare_op_visit_info` where opno='".$opno."' and cancelled=0 order by id desc limit 1";

				          $result1=$this->dbConnection->executeQuery($query1);

				           if(mysqli_num_rows($result1)>0){

				           while($row1=mysqli_fetch_array($result1)){
						
					       $arrList[$i][48]=$row1['age'];
									
				                 }	
				            }

				              if (!empty($arrList[$i][48])) {
            	              $arrList[$i][4] = $arrList[$i][48];
                              }


				}else{
				
					$opno='';
					$prefix=$this->dbConnection->idToValue("hcare_direct_customer","prefix","id",$row['ref_no']);
					$arrList[$i][3]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ref_no']);
					
					$arrList[$i][4]=$this->dbConnection->idToValue("hcare_direct_customer","age","id",$row['ref_no']);
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_direct_customer","gender","id",$row['ref_no']);
					$arrList[$i][6]=$this->dbConnection->idToValue("hcare_direct_customer","place","id",$row['ref_no']);
					$arrList[$i][7]=$this->dbConnection->idToValue("hcare_direct_customer","contact_no","id",$row['ref_no']);				
					$arrList[$i][8]=$this->dbConnection->idToValue("hcare_direct_customer","refferal_info","id",$row['ref_no']);
				}
				
				$arrList[$i][9]=$row['total_amount'];
				$arrList[$i][10]=$row['dr_disc'];
				$arrList[$i][11]=$row['net_total'];
				$arrList[$i][12]=$row['paid_with'];
				$arrList[$i][13]=$row['cash']+$creditPayment+$ip_cash_amount;
				$arrList[$i][14]=$credit_amt-$creditPayment;
				$arrList[$i][15]=$row['credit_card']+$ip_card_amount;
				$arrList[$i][16]=date("Y-m-d",strtotime($row['bill_date']));
				$arrList[$i][17]=$row['remarks'];
				$arrList[$i][18]=$row['user_id'];
				$arrList[$i][19]=$opno;
				$arrList[$i][20]=$row['insurance'];
				$arrList[$i][21]=$row['credit'];
				$arrList[$i][22]=$row['lab_status'];
				
				$arrList[$i][23]=$dr_disc_amt=($row['total_amount']*($row['dr_disc']/100));
				$arrList[$i][24]=$row['cancellation_details'];

                               if($row['type'] == "IP") {
                                    
                                 $arrList[$i][25]=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ref_no']);
                               }else $arrList[$i][25]='';
			       
			       $arrList[$i][26]=$prefix;
			        //split updation history
		                                                $update_history='';
			
			                                         if(!empty($row['update_history'])){
			                                             $history_split=explode("&&",$row['update_history']);
				    
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("|",$history_split[$m]);
			                                                  // var_dump($history_info);
			                                                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                                  $datetime=$history_info[1];
			                                                  $action=$history_info[2];
			                                                  if (!empty($action)) {
			                                                  	$paction=$action." | ";
			                                                  }
			                                                  else{
			                                                  	$paction="";
			                                                  }

					                                  $update_history .=$paction.$user_name.":".$datetime."<br>";
			                                             }
			                                         }
		                                                }
			                                        $arrList[$i][27]= $update_history;
													 $employee_id= $this->dbConnection->idToValue("hcare_users","employee_id","id",$row['user_id']);
													 $arrList[$i][28]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$employee_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$employee_id);
													 $arrList[$i][29]=$bill_status;
													 
													 if($row['result_verified_by'] > 0){
														 
													   $arrList[$i][30]=$row['result_verified_by'];
											           $arrList[$i][31]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row['result_verified_by']);
													 }else{
														 $result_verified_by=$this->dbConnection->idToValue("hcare_lab_result","result_verified_by","billno",$row['id']);
														 $verified_by ="";
														 if(!empty($result_verified_by)){
			                                                  $history_split=explode("|",$result_verified_by);
				    
			                                                    if(!empty($history_split)){
			
			                                                         for($m=0;$m<count($history_split);$m++) {
			                                                              $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_split[$m]);
			                                                  
					                                                       $verified_by .=$user_name."<br>";
														             }
			                                                    }
														 }
														  $arrList[$i][30]=$result_verified_by;
														 $arrList[$i][31]=$verified_by;
													 }
			                                        
													 $arrList[$i][32]=$row['sanctioned_by'];
													 $arrList[$i][33]=$row['sanctioned_remarks'];
													 
													  $result_entered_by=$this->dbConnection->idToValue("hcare_lab_result","result_entered_by","billno",$row['id']);
													  $entered_by='';
			
			                                         if(!empty($result_entered_by)){
			                                             $history_split=explode("&&",$result_entered_by);
				    
			                                         if(!empty($history_split)){
			
			                                            for($m=0;$m<count($history_split);$m++) {
			                                                  $history_info=explode("|",$history_split[$m]);
			                                                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                                  $datetime=$history_info[1];
					                                         $entered_by .=$user_name.":".$datetime."<br>";
			                                             }
			                                            }
		                                                }
														
														$arrList[$i][34]=$entered_by;
														$arrList[$i][35]=$this->dbConnection->idToValue("hcare_lab_result","result_date","billno",$row['id']);
														$arrList[$i][36]=$ip_visit_id;

														$arrList[$i][37]= $this->dbConnection->idToValue("hcare_lab_result","id","billno",$row['id']);

														$arrList[$i][38]=$this->dbConnection->idToValue("hcare_op_visit_info","observation","id",$row['ref_no']);
														$sql1 = "select sum(amount_paid),sum(card_amount) from `hcare_bill_payments` where `bill_no`='".$row['id']."' and status=0";

														$result1=$this->dbConnection->executeQuery($sql1);

														if(mysqli_num_rows($result1) > 0){
			
															while($row1=mysqli_fetch_array($result1)){

																$arrList[$i][40]=$row1['sum(amount_paid)'];
																$arrList[$i][41]=$row1['sum(card_amount)'];

															}

														}
														$arrList[$i][42]=$this->dbConnection->idToValue("hcare_op_visit_info","observation","id",$row['ref_no']);

														$arrList[$i][43]=$this->dbConnection->idToValue("hcare_bill_items","type","bill_id",$row['id']);
														$arrList[$i][44]=$this->dbConnection->idToValue("hcare_user_type","id","id",$row['user_id']);

														$arrList[$i][45]=$this->dbConnection->idToValue("hcare_users","user_type","id",$row['user_id']);
													 $arrList[$i][49]=$row['email'];
													


												

													  
				$i++;
				
			}
			}
			
		
		}
	
		return $arrList;
	}
	function getBillInfo2($wheredata = null ,$selectdata=null,$orderbyfield = 'id',$oderby = 'asc',$credit = false,$limit=null ){
	
		$arrList=array();
		$i=0;
		$data=true;
		$query=$this->dbConnection->BuiltQuery('hcare_bill',$selectdata,$wheredata,$orderbyfield,$oderby,'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		//echo $query;
		if(mysqli_num_rows($result) > 0){
			$p=1;
			while($row=$result -> fetch_assoc()){
			$data=true;
                        $ip_card_amount=0;
                        $ip_cash_amount=0;
				$where[0]="bill_no='".$row['id']."'";
				$where[1]="status=0";
				$creditInfo=$this->getCreditBillInfo2($where);

				$creditPayment=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$creditPayment=$creditPayment+$creditInfo[$k][3];
					}
				}
				
				$credit_amount=$row['credit']-$creditPayment;
				if($credit == true && $credit_amount <= 0){ 
				 $data=false; 
				}
			
			if($data){
			
				
				$arrList[$i][11]=$row['net_total'];
				$arrList[$i][13]=$row['cash']+$creditPayment+$ip_cash_amount;
				$arrList[$i][15]=$row['credit_card']+$ip_card_amount;
				$i++;
				
			}
			}
		
		}
		return $arrList;
	}
	
	public function getBillItemsInfo($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_bill_items','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
				
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['bill_id'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['type'];
				$arrList[$i][4]=$row['test_id'];
				
				if($row['type'] == "C") {
				
					$arrList[$i][5]="Consultation";
					
				}else if($row['type'] == "P") {
				
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					
				}else if($row['type'] == "PACKAGE") {
				
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_healthcheckup_package","package_name","id",$row['test_id']);
					
				}else if($row['type'] == "L") {
				
				     $cid=$row['category_id'];
					$check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					if($cid == $check_catid){
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					}else {
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					}
				}else if($row['type'] == "LT") {
				
					
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				}else if($row['type'] == "LE") {
				
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				}
				$arrList[$i][6]=$row['category_id'];
				$arrList[$i][7]=$row['test_amount'];
				$arrList[$i][8]=$row['discount_type'];
				$arrList[$i][9]=$row['discount_value'];
				$arrList[$i][10]=$row['discount'];
				$arrList[$i][11]=$row['net_amount'];
				$arrList[$i][12]=$row['doc_id'];
				$arrList[$i][13]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doc_id']);
				$arrList[$i][14]=$row['dr_amount'];
				$arrList[$i][15]=$row['hosp_amount'];
				$arrList[$i][16]=$row['surgeon_fee'];
				$arrList[$i][17]=$row['theatre_charge'];
				$arrList[$i][18]=$row['anasthesia'];
				$arrList[$i][19]=$row['other_charges'];
				$arrList[$i][20]=$row['assistant_fee1'];
				$arrList[$i][21]=$row['assistant_fee2'];
				$arrList[$i][22]=$row['surgeon_id'];
				$arrList[$i][23]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['surgeon_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['surgeon_id']);
				
				$arrList[$i][24]=$row['anesthestis'];
				$arrList[$i][25]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['anesthestis'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['anesthestis']);
				
				$arrList[$i][26]=$row['assistant_doc1'];
				$arrList[$i][27]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['assistant_doc1'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['assistant_doc1']);
				
				$arrList[$i][28]=$row['assistant_doc2'];
				$arrList[$i][29]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['assistant_doc2'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['assistant_doc2']);
				$arrList[$i][30]=$row['heading'];
				$arrList[$i][31]=$row['package_id'];
				
				$ptype=$this->dbConnection->idToValue("hcare_bill","type","id",$row['bill_id']);
				$refno=$this->dbConnection->idToValue("hcare_bill","type","id",$row['ref_no']);
				
				$arrList[$i][32]=$ptype;
				$arrList[$i][33]=$refno;
				if($row['type'] == "OP") {
					$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$refno);
					 $arrList[$i][34]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else if($row['type'] == "IP") {

					$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ref_no']);
					 $arrList[$i][34]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else {
				  $arrList[$i][34]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ref_no']);
				}

				$arrList[$i][35]=$row['qty'];

				$arrList[$i][36]=$row['gynec_fee'];
				$arrList[$i][37]=$row['room_charges'];
				
				$i++;
			}
		}
		return $arrList;
	}
	public function getLabBillItems($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_bill_items','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
				
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['bill_id'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['type'];
				$arrList[$i][4]=$row['test_id'];
				
				 if($row['type'] == "L") {
				
				     $cid=$row['category_id'];
					$check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					if($cid == $check_catid){
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					}else {
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					}
				}else if($row['type'] == "LT") {
				
					
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				}else if($row['type'] == "LE") {
				
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				}
				$arrList[$i][6]=$row['category_id'];
				$arrList[$i][7]=$this->dbConnection->idToValue("hcare_lab_category","category","id",$row['category_id']);
				
				
				$ptype=$this->dbConnection->idToValue("hcare_bill","type","id",$row['bill_id']);
				$refno=$this->dbConnection->idToValue("hcare_bill","type","id",$row['ref_no']);
				
				$arrList[$i][8]=$ptype;
				$arrList[$i][9]=$refno;
				if($row['type'] == "OP") {
					$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$refno);
					 $arrList[$i][10]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else if($row['type'] == "IP") {

					$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ref_no']);
					 $arrList[$i][10]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else {
				  $arrList[$i][10]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ref_no']);
				}
				
				$i++;
			}
		}
		return $arrList;
	}
	public function getDocProcedureConso($select,$wheredata = null){
	    $arrList=array();
		$i=0;
		
		$query=$this->dbConnection->BuiltQuery('hcare_bill_items',$select,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=mysqli_fetch_array($result)){
			
			      $arrList[$i][0]=$row[0];
				 
				  
				  $i++;
				}
			}
		
			return $arrList;
		}
	
	
        public function getpharmaBill($wheredata = null,$limit =null){
                        
             
		$billInfo=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice','',$wheredata,'id','desc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);

        if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){

                 $where=array();
			     $where[]="bill_no = ".$row['id'];
			     $where[]="status = 0 ";
                 $creditInfo=$this->getpharmaCreditPayment($where);
			     $credit=0;

				if(!empty($creditInfo)){
				
					for($k=0;$k<count($creditInfo);$k++){
					
						$credit +=($creditInfo[$k][2]+$creditInfo[$k][5]);
					}
				
				}
                if($row['cust_type'] == "IP") {
				$discharge_date=$this->dbConnection->idToValue("hcare_ip_info","discharge_date","id",$row['ip_no']);
				if($discharge_date !='' && $discharge_date !=="0000-00-00"){
				 /*patient recod ip pharmacy bill info balance mismatch because of the following line
                   $rem_balance=0;*/
				   $rem_balance=0;
				   
				}else $rem_balance=$row['balance']-$credit;
				
				}else{
                               
                                $rem_balance=$row['balance']-$credit;
                                
				}
                        
								$card_amt=$row['card_amt'];

						        $amount_paid=$row['amount_paid'];
				                $balance=$row['balance'];
								$new_amount=$amount_paid+$credit+$card_amt;
								
                                $billInfo[$i][1]= $row['id'];
                                $billInfo[$i][2]= $row['net_total'];
				                $billInfo[$i][3]= $row['payment_mode'];
				                $billInfo[$i][4]= $row['checque_no'];
				                $billInfo[$i][5]= $row['checque_amt'];;
				                $billInfo[$i][6]= $row['card_amt'];;
                                $billInfo[$i][7]= $amount_paid;
				                $billInfo[$i][8]= $balance;
                                $billInfo[$i][9]= $credit;
                                $billInfo[$i][10]=$new_amount;
                                $billInfo[$i][11]=$rem_balance;
                                $billInfo[$i][12]= $row['ip_no'];
                                $billInfo[$i][13]= $row['op_no'];
								$billInfo[$i][14]= $row['cust_type'];
								$billInfo[$i][15]= $row['bill_date'];
								$billInfo[$i][16]= $row['op_visit_id'];
								
                              $i++;
						
                      }
              }
		      return $billInfo;  

       }
       public function getpharmaCreditPayment($wheredata = null){

                $billInfo=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_credit_payment','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);

               if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){

                                
				$billInfo[$i][0]= $row['id'];
				$billInfo[$i][1]= $row['bill_no'];
				$billInfo[$i][2]= $row['amount'];

				$billInfo[$i][3]= $row['date'];

				$billInfo[$i][4]=$this->dbConnection->idToValue("hcare_pharma_invoice","bill_date","id",$row['bill_no']);
				$billInfo[$i][5]= $row['card_amt'];
				
				$billInfo[$i][6]= $row['bill_no'];
                $billInfo[$i][7]= $row['disc_type'];
                $billInfo[$i][8]= $row['disc_amt'];
                $billInfo[$i][9]= $row['disc_value'];

                $i++;
                      }
              }
		      
                return $billInfo;  
       }
	function cancelBill($post){
	
		$id=$post['id'];
		
		$cancellation_details=$post['cancellation_details'];
		



		//updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_bill","update_history","id",$id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."|DELETE"."&&".$old_update;
	   
	        }

		
		$field_names1=array('status','cancellation_details','update_history');
		$field_data=array('1',"$cancellation_details",$update_history);

		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_bill");
		
		if($result) return true;
		else return false;
	}
	
	function cancelBillItems($post){
	
		$id=$post['id'];
		
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"bill_id",$id,"hcare_bill_items");
		
		if($result) return true;
		else return false;
	}
	function cancel_ip_bill($post){
	
		$id=$post['billid'];
		
		$cancellation_details=$post['cancellation_details'];
		$bill_status=$post['bill_status'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_ip_bill","update_history","id",$id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('bill_date','bill_status','cancellation_details','update_history');
		$field_data=array($post['curr_date'],$bill_status,$cancellation_details,$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_ip_bill");
		
		if($result) return true;
		else return false;
	}
	function cancel_ip_bill_items($post){
	
		$id=$post['billid'];
		$bill_status=$post['bill_status'];
		
		$field_names1=array('status');
		$field_data=array($bill_status);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"billno",$id,"hcare_ip_bill_items");
		
		if($result) return true;
		else return false;
	}
	function change_doctor_billing_item($post){
	
		$id=$post['billid'];
	
		
		$field_names1=array($post['field_name']);
		$field_data=array($post['doc_id']);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_bill_items");
		
		if($result) return true;
		else return false;
	}
	
	function getOPCreditBillAmt($wheredata){
	
	    $wheredata[]="type ='OP'";
		$wheredata[]="paid_with ='CREDIT'";
		$wheredata[]="status ='0'";
	    $wheredata[]="credit > 0";
		
		$query=$this->dbConnection->BuiltQuery('hcare_bill','',$wheredata,'id','asc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		//echo $query;
		
		$credit_amt=0;
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
			   $where[0]="bill_no='".$row['id']."'";
			   $where[1]="status=0";
				$creditInfo=$this->getCreditBillInfo($where);

				$creditPayment=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$creditPayment=$creditPayment+$creditInfo[$k][3];
					}
					
					
				}
				
				$credit_amt +=$row['credit']-$creditPayment;
			}
		}
		
		return $credit_amt;
	}
	
	public function getOPPharmaCreditAmt($wheredata = null,$limit =null){
       
		$wheredata[]="cust_type ='OP'";
		$wheredata[]="payment_mode ='CREDIT'";
		$wheredata[]="status ='0'";
	    $wheredata[]="balance > 0";
		
		$query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice','',$wheredata,'id','desc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
        $rem_balance=0;
        if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){

                 $where=array();
			     $where[]="bill_no = ".$row['id'];
			     $where[]="status = 0 ";
                 $creditInfo=$this->getpharmaCreditPayment($where);
			     $credit=0;

				if(!empty($creditInfo)){
				
					for($k=0;$k<count($creditInfo);$k++){
					
						$credit +=($creditInfo[$k][2]+$creditInfo[$k][5]);
					}
				
				}
				
				$rem_balance +=$row['balance']-$credit;
               
						
               }
           }
		      
                return $rem_balance;  

       }
	public function getIPCreditAmt($wheredata = null){
       
		
		$wheredata[]="payment_mode ='CREDIT'";
		$wheredata[]="(bill_status !='1' or bill_status !='3')";
	    $wheredata[]="balance > 0";
		
		$query=$this->dbConnection->BuiltQuery('hcare_ip_bill','',$wheredata,'id','desc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
        $rem_balance=0;
        if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){

                 
				
				$rem_balance +=$row['balance'];
               
						
               }
           }
		      
                return $rem_balance;  

       }
       public function getIPBillItemName(){
       
	        $select[0]="distinct(particulars)";
		$wheredata[0]="status=0";
		$query=$this->dbConnection->BuiltQuery('hcare_ip_bill_items',$select,$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
        $arrList=array();
	$i=0;
        if(mysqli_num_rows($result) > 0){
			//print_r($result -> fetch_assoc());
			while($row=$result -> fetch_assoc()){
                      
                 
				
				$arrList[$i] =$row['particulars'];
                                $i++;
						
               }
           }
		      
                return $arrList;  

       }
       function getIPBillConsoItems($wheredata = null ){
	
	
			$selectField[0]="sum(b.amount)";
			$selectField[1]="count(b.item_id)";
			
			$arrTables[0] = "`hcare_ip_bill` a";
       	                $arrTables[1] = "`hcare_ip_bill_items` b";
				
			$joinConditions[1] = "a.`id` = b.`billno`";
				
			
			$group_by="b.particulars";
			
			
			if(!empty($wheredata)) {
					for($k=0;$k<count($wheredata);$k++){
					
						$selectConditions[]=$wheredata[$k];
					}
				}
				
        	
			$query=$this->dbConnection->selectFromMultipleTable($selectField, $arrTables, $joinConditions, $selectConditions,'','b.id','asc','',$group_by);
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
			if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['sum(b.amount)'];
				$arrList[$i][1]=$row['count(b.item_id)'];
				
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
       function update_credit_status($billid,$credit_paid,$balance){
	
		$id=$post['billid'];
	
		
		$field_names1=array('credit_paid','balance');
		$field_data=array($credit_paid,$balance);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$billid,"hcare_ip_bill");
		
		if($result) return true;
		else return false;
	}
	function add_ip_credit_payment($post){
	
		$field_names=array("id","billid","ipno","opno","payment_mode","amount_paid","card_amount","cheque_no","bill_date","remarks","user_id");
		$field_data=array("",$post['billid'],$post['ipno'],$post['opno'],$post['payment_mode'],$post['cash_amount'],$post['card_amount'],$post['cheque_no'],$post['bill_date'],$post['remarks'],$_SESSION['user_id']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_credit_payments");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function getIPCreditPayments($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_ip_credit_payments','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['ipno'];
				$arrList[$i][2]=$row['opno'];
				$arrList[$i][3]=$row['payment_mode'];
				$arrList[$i][4]=$row['amount_paid'];
				$arrList[$i][5]=$row['card_amount'];
				$arrList[$i][6]=$row['cheque_no'];
				$arrList[$i][7]=$row['bill_date'];
				$arrList[$i][8]=$row['remarks'];
				$arrList[$i][9]=$row['user_id'];
				
				
				
				$opno= $row['opno'];
				$prefix= $this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$opno);
				$room_id= $this->dbConnection->idToValue("hcare_ip_info","room_id","id",$row['ipno']);
                $roomno= $this->dbConnection->idToValue("hcare_rooms","room_number","id",$room_id);
				
				
				$arrList[$i][10]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
                                $arrList[$i][11]=$roomno;
				$arrList[$i][12]=$row['remarks'];
                                $arrList[$i][13]=$row['user_id'];
				$arrList[$i][14]=$prefix;
				$arrList[$i][15]=$row['billid'];
				
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	 function update_lab_status($billid){
	
		
	
		
		$field_names1=array('lab_status');
		$field_data=array("1");
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$billid,"hcare_bill");
		
		if($result) return true;
		else return false;
	}
	function update_sms_status($billid,$sms_status){
	
		
		$field_names1=array('sms_status');
		$field_data=array($sms_status);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$billid,"hcare_bill");
		
		if($result) return true;
		else return false;
	}
	function getBillId($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_bill','',$wheredata,'id','DESC');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['bill_date'];
				
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	
	function updateBillAmounts($post){


	
			$id=$post['billid'];
			
		if(!empty($post['card_amount'])){
			$credit_card=$post['card_amount'];
		}else $credit_card=0;		
		
		if(!empty($post['ins_deduction'])){
			$ins_deduction=$post['ins_deduction'];
		}else $ins_deduction=0;
		
		//updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_bill","update_history","id",$id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."|EDIT"."&&".$old_update;
	   
	        }
		       
		$amount_paid=$post['amount_paid']+$credit_card+$ins_deduction;
		$credit=$post['net_amount']-$amount_paid;
	
		$field_names=array("total_amount","dr_disc","net_total","cash","credit","credit_card","insurance","update_history");
		$field_data=array($post['total_amount'],$post['dr_disc'],$post['net_amount'],$post['amount_paid'],$credit,$credit_card,$ins_deduction,$update_history);
			
	
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_bill");
		
		if($result) return $id;
		else return 0;
	}


	function addObservationBill($post){

	
		// var_dump($post);exit();

	  $user_id=$_SESSION['user_id'];
	  
	  date_default_timezone_set('Asia/Kolkata');
	  $update_history = $user_id."|". date("d-m-Y H:i a");
	  $time=date("H:i:s");

	    $field_names=array("id","opno","visit_id","bill_date", "total_amount","amount_paid","disc_type","disc_amt","balance","payment_mode","cash_amount","card_amount","cheque_amt","cheque_no","remarks","user_id","update_history","cancellation_details","status");
	   
	    $field_data=array("",$post['opno'],$post['visit_id'],date("Y-m-d",strtotime($post['dod']))." ".$time,$post['total_amount'], $post['amount_paid'],$post['disc_type'],$post['discount'],$post['balance'],$post['payment_mode'],$post['cash_amount'],$post['card_amount'],$post['cheque_amount'],$post['cheque_no'],$post['remarks'],$user_id,$update_history,'',0);
	
	  
	    
	    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_observation_bills");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	  
	
	}
	function getObservationBillInfo($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_op_observation_bills','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['opno'];
				$arrList[$i][2]=$row['visit_id'];
				$arrList[$i][3]=$row['bill_date'];
				$arrList[$i][4]=$row['total_amount'];
				$arrList[$i][5]=$row['amount_paid'];
				$arrList[$i][6]=$row['disc_type'];
				$arrList[$i][7]=$row['disc_amt'];
				$arrList[$i][8]=$row['balance'];
				$arrList[$i][9]=$row['payment_mode'];
				$arrList[$i][10]=$row['cash_amount'];
				$arrList[$i][11]=$row['card_amount'];
				$arrList[$i][12]=$row['cheque_amt'];
				$arrList[$i][13]=$row['cheque_no'];
				$arrList[$i][14]=$row['remarks'];
				$arrList[$i][15]=$row['user_id'];
				$arrList[$i][16]=$row['update_history'];
				$arrList[$i][17]=$row['cancellation_details'];
				$arrList[$i][18]=$row['status'];


				$arrList[$i][19] = $this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$row['opno'])." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$row['opno'])." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$row['opno']);

				$arrList[$i][20] = $this->dbConnection->idToValue("hcare_op_patient_info","place","id",$row['opno']);

				$arrList[$i][21] = $this->dbConnection->idToValue("hcare_op_visit_info","doc_id","id",$row['visit_id']);

				$arrList[$i][22] = $this->dbConnection->idToValue("hcare_emp_info","title","id",$arrList[$i][21])." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$arrList[$i][22])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$arrList[$i][21]);

				$arrList[$i][23]= $this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$row['opno']);

				$arrList[$i][24]= $this->dbConnection->idToValue("hcare_users","user_name","id",$user_id);


				 //split updation history
		                $update_history='';
			
			        if(!empty($row['update_history'])){
			            $history_split=explode("&&",$row['update_history']);
				    
			            if(!empty($history_split)){
			
			              for($m=0;$m<count($history_split);$m++) {
			                 $history_info=explode("|",$history_split[$m]);
			                  $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                  $datetime=$history_info[1];
					  $update_history .=$user_name.":".$datetime."<br>";
			             }
			           }
		                }
			    $arrList[$i][25]= $update_history;


				$i++;
			}
			
		}
		
		return $arrList;
	
	}


	public function getBillItemsInfoTime($wheredata){
	

			    $arrFieldList[0]= "a.`id`";
			    $arrFieldList[1]= "a.`bill_id`";
			    $arrFieldList[2]= "a.`bill_date`";
			    $arrFieldList[3]= "a.`type`";
			    $arrFieldList[4]= "a.`test_id`";
			    $arrFieldList[5]= "a.`category_id`";
			    $arrFieldList[6]= "a.`test_amount`";
			    $arrFieldList[7]= "a.`discount_type`";
			    $arrFieldList[8]= "a.`discount_value`";
			    $arrFieldList[9]= "a.`discount`";
			    $arrFieldList[10]= "a.`net_amount`";
			    $arrFieldList[11]= "a.`doc_id`";
			    $arrFieldList[12]= "a.`dr_amount`";
			    $arrFieldList[13]= "a.`hosp_amount`";
			    $arrFieldList[14]= "a.`surgeon_fee`";
			    $arrFieldList[15]= "a.`theatre_charge`";
			    $arrFieldList[16]= "a.`anasthesia`";
			    $arrFieldList[17]= "a.`other_charges`";
			    $arrFieldList[18]= "a.`assistant_fee1`";
			    $arrFieldList[19]= "a.`assistant_fee2`";
			    $arrFieldList[20]= "a.`surgeon_id`";
			    // $arrFieldList[21]= "a.`qty`";
			    $arrFieldList[21]= "a.`gynec_fee`";
			    $arrFieldList[22]= "a.`room_charges`";
			    $arrFieldList[23]= "b.`bill_date`";

				
				$arrTables[0] = "`hcare_bill_items` a";
       			$arrTables[1] = "`hcare_bill` b";
				
				$joinConditions[1] = "a.`bill_id` = b.`id`";
				
				if(!empty($wheredata)) {
					for($k=0;$k<count($wheredata);$k++){
					
						$selectConditions[]=$wheredata[$k];
					}
				}
				
        		$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions);
			
				$result=$this->dbConnection->executeQuery($query);
				$i=0;
				
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
				
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['bill_id'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['type'];
				$arrList[$i][4]=$row['test_id'];
				
				if($row['type'] == "C") {
				
					$arrList[$i][5]="Consultation";
					
				}else if($row['type'] == "P") {
				
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					
				}else if($row['type'] == "PACKAGE") {
				
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_healthcheckup_package","package_name","id",$row['test_id']);
					
				}else if($row['type'] == "L") {
				
				     $cid=$row['category_id'];
					$check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					if($cid == $check_catid){
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					}else {
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					}
				}else if($row['type'] == "LT") {
				
					
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					
				}else if($row['type'] == "LE") {
				
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					
				}
				$arrList[$i][6]=$row['category_id'];
				$arrList[$i][7]=$row['test_amount'];
				$arrList[$i][8]=$row['discount_type'];
				$arrList[$i][9]=$row['discount_value'];
				$arrList[$i][10]=$row['discount'];
				$arrList[$i][11]=$row['net_amount'];
				$arrList[$i][12]=$row['doc_id'];
				$arrList[$i][13]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doc_id']);
				$arrList[$i][14]=$row['dr_amount'];
				$arrList[$i][15]=$row['hosp_amount'];
				$arrList[$i][16]=$row['surgeon_fee'];
				$arrList[$i][17]=$row['theatre_charge'];
				$arrList[$i][18]=$row['anasthesia'];
				$arrList[$i][19]=$row['other_charges'];
				$arrList[$i][20]=$row['assistant_fee1'];
				$arrList[$i][21]=$row['assistant_fee2'];
				$arrList[$i][22]=$row['surgeon_id'];
				$arrList[$i][23]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['surgeon_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['surgeon_id']);
				
				$arrList[$i][24]=$row['anesthestis'];
				$arrList[$i][25]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['anesthestis'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['anesthestis']);
				
				$arrList[$i][26]=$row['assistant_doc1'];
				$arrList[$i][27]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['assistant_doc1'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['assistant_doc1']);
				
				$arrList[$i][28]=$row['assistant_doc2'];
				$arrList[$i][29]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['assistant_doc2'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['assistant_doc2']);
				$arrList[$i][30]=$row['heading'];
				$arrList[$i][31]=$row['package_id'];
				
				$ptype=$this->dbConnection->idToValue("hcare_bill","type","id",$row['bill_id']);
				$refno=$this->dbConnection->idToValue("hcare_bill","type","id",$row['ref_no']);
				
				$arrList[$i][32]=$ptype;
				$arrList[$i][33]=$refno;
				if($row['type'] == "OP") {
					$opno=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$refno);
					 $arrList[$i][34]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else if($row['type'] == "IP") {

					$opno=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ref_no']);
					 $arrList[$i][34]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
					
				}else {
				  $arrList[$i][34]=$this->dbConnection->idToValue("hcare_direct_customer","name","id",$row['ref_no']);
				}

				$arrList[$i][35]=$row['qty'];

				$arrList[$i][36]=$row['gynec_fee'];
				$arrList[$i][37]=$row['room_charges'];;
				
				$i++;
			}
		}
		return $arrList;
				
				






	}
	function getDocPrescribedLab($doc_id,$from_date,$to_date){

		$query = "SELECT sum(net_amount) as amount FROM `hcare_bill_items` WHERE `bill_date`>='".$from_date."' AND `bill_date`<='".$to_date."' AND `doc_id_prescribed`='".$doc_id."' AND `status`=0 AND (`type`='LE' OR `type`='LT')";

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
	function getDocPrescribedProcedure($doc_id,$from_date,$to_date){

		$query = "SELECT sum(net_amount) as amount FROM `hcare_bill_items` WHERE `bill_date`>='".$from_date."' AND `bill_date`<='".$to_date."' AND `doc_id_prescribed`='".$doc_id."' AND `status`=0 AND `type`='P' AND `category_id`!='2'";

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
	function getDocPrescribedXray($doc_id,$from_date,$to_date){

		$query = "SELECT sum(net_amount) as amount FROM `hcare_bill_items` WHERE `bill_date`>='".$from_date."' AND `bill_date`<='".$to_date."' AND `doc_id_prescribed`='".$doc_id."' AND `status`=0 AND `type`='P' AND `category_id`='2'";

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

function calculateRoomRent($ipid){

	$arrayList = array();
	
	$difference = 0;
	$net_total = 0;

	$from =  $this->dbConnection->idToValue("hcare_op_visit_info","obs_start","id",$ipid);
	$to = date('Y-m-d H:i:s');

	$d1 = new DateTime($to);
	$d2 = new DateTime($from);

	$difference = (strtotime($to)-strtotime($from))/3600;

	$interval = date_diff($d1,$d2);
    
    $difference_inhours = $interval->format('%h : %i : %s'); 

	
	$from =  date('d-m-Y / h:i:s A',strtotime($from));
	$to = date('d-m-Y / h:i:s A',strtotime($to));

	$bed_id =  $this->dbConnection->idToValue("hcare_op_visit_info","obs_bed","id",$ipid);	
	$bed_number =   $this->dbConnection->idToValue("hcare_room_beds","bed_number","id",$bed_id);

	$room_id =  $this->dbConnection->idToValue("hcare_op_visit_info","obs_room","id",$ipid);	
	$room_number =   $this->dbConnection->idToValue("hcare_rooms","room_number","id",$room_id);

	$category_id =   $this->dbConnection->idToValue("hcare_rooms","room_category","id",$room_id);

	$wheredata[] = "id ='".$category_id."'";
	$selectField[] = 'hour_charge';
	$selectField[] = 'category';
	$query=$this->dbConnection->BuiltQuery('hcare_room_category',$selectField,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
				$hcharge = $row['hour_charge'];
				$category = $row['category'];
			}
		}

		$net_total = $difference*$hcharge;

		$arrList['bed_number'] = $bed_number;
		$arrList['room_number'] =$room_number;
		$arrList['hcharge'] = $hcharge;
		$arrList['category'] = $category;		
		$arrList['from'] = $from;
		$arrList['to'] = $to;
		$arrList['difference'] = $difference_inhours;
		$arrList['net_total'] = round($net_total);

		return $arrList;
}

	function getOpDrPaymentsConsolidated($wheredata = null){
	
	   $arrFieldList[0]="sum(amount_paid)";
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_op_dr_payments',$arrFieldList,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i]=$row['sum(amount_paid)'];
	                    
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}

	function deleteCreditBillpayments($post){
	

	
		$id=$post['credit_id'];
		// var_dump($id);
		date_default_timezone_set('Asia/Kolkata');
		$cancellation_details=$post['cancellation_details'];

      $curr_date= $post['curr_date']=Date("Y-m-d");

		$user_id=$_SESSION['user_id'];
		
		$field_names1=array('status','cancellation_details','cancellation_date','cancelled_by');
		$field_data=array('1',"$cancellation_details"," $curr_date","$user_id");
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_bill_payments");
		
		if($result) return true;
		else return false;
	}
function final_credit_bill_details($selectConditions=null){
	$arrList=array();
	$net_tot = 0;
	$paid_tot = 0;
	$balance_tot = 0;
	$new_bal = 0;

	$arrFieldList[0] = "a.`id`";
	$arrFieldList[1] = "a.`net_total`";
	$arrFieldList[2] = "a.`cash`";
	$arrFieldList[3] = "a.`credit`";
	$arrFieldList[4] = "a.`credit_card`";
	$arrFieldList[5] = "a.`insurance`";
	$arrFieldList[6] = "a.`bill_date`";
	$arrFieldList[7] = "a.`status`";

	$arrFieldList[8] = "b.`bill_date` as b_bill_date";
	$arrFieldList[9] = "b.`amount_paid`";
	$arrFieldList[10] = "b.`id` as b_id";
	$arrFieldList[11] = "b.`status` as b_status";
	$arrFieldList[12] = "b.`bill_no`";
	$arrFieldList[13] = "b.`card_amount`";

	$arrTables[0] = "`hcare_bill` a";
	$arrTables[1] = "`hcare_bill_payments` b";

	$joinConditions[1] = "a.`id` = b.`bill_no`";

	$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions,'',"a.`id`","asc");
	
	$result=$this->dbConnection->executeQuery($query);
	$i=0;
	if(mysqli_num_rows($result) > 0){			
		while($row=$result -> fetch_assoc()){
			if($i==0){
				$bill_no_now = $row["bill_no"];
			}
			if ($row["b_id"]) {
				$arrList[$i][0] = $row["b_id"];
				$arrList[$i][1] = $row["b_bill_date"];
				$arrList[$i][2] = $row["bill_no"];
				$arrList[$i][3] = $row["amount_paid"]+$row["card_amount"];

				$bill_no_old = $bill_no_now;
				$bill_no_now = $row["bill_no"];
				
				if($new_bal == 0 && $bill_no_old == $bill_no_now){
					$new_bal = $row["credit"]-($row["amount_paid"]+$row["card_amount"]);
				}
				else if($bill_no_old == $bill_no_now){			
					$new_bal -= ($row["amount_paid"]+$row["card_amount"]);
				}
				else{
					$new_bal = $row["credit"]-($row["amount_paid"]+$row["card_amount"]);
				}
				$arrList[$i][4] = $new_bal;
				$paid_tot += ($row["amount_paid"]+$row["card_amount"]);
				$balance_tot -= ($row["amount_paid"]+$row["card_amount"]);
			}
			$i++;
		}
	}

	
	$arrList['net_tot'] = $net_tot;
	$arrList['paid_tot'] = $paid_tot;
	$arrList['balance_tot'] = $balance_tot;
	return $arrList;
}


function final_bill_advance_details($ip_no){
	$arrList=array();
	$net_tot = 0;
	$paid_tot = 0;
	$balance_tot = 0;

	$arrFieldList[0] = "`id`";
	$arrFieldList[1] = "`cash`";
	$arrFieldList[2] = "`card_amount`";
	$arrFieldList[3] = "`cheque_no`";
	$arrFieldList[4] = "`date`";
	$arrFieldList[5] = "`status`";

	$selectConditions[0] = "ipno='".$ip_no."'";

	$query=$this->dbConnection->BuiltQuery('hcare_advance_payments',$arrFieldList,$selectConditions,'','');
		
	$result=$this->dbConnection->executeQuery($query);
	$i=0;
	if(mysqli_num_rows($result) > 0){			
		while($row=$result -> fetch_assoc()){
			$arrList[$i][0] = $row["id"];
			$arrList[$i][1] = $row["date"];
			$arrList[$i][3] = $row["cash"]+$row["card_amount"];
			$paid_tot += ($row["cash"]+$row["card_amount"]);
			$i++;
		}
	}

	
	$arrList['net_tot'] = $net_tot;
	$arrList['paid_tot'] = $paid_tot;
	$arrList['balance_tot'] = $balance_tot;

	return $arrList;
}

function final_bill_pharma_details($ip_no){
	$arrList=array();
	$net_tot = 0;
	$paid_tot = 0;
	$balance_tot = 0;		
	$arrFieldList[0] = "`id`";
	$arrFieldList[1] = "`bill_date`";
	$arrFieldList[2] = "`net_total`";
	$arrFieldList[3] = "`checque_amt`";
	$arrFieldList[4] = "`card_amt`"; 
	$arrFieldList[5] = "`amount_paid`";
	$arrFieldList[6] = "`balance`";
	$arrFieldList[7] = "`status`"; 

	$selectConditions[0] = "ip_no='".$ip_no."'";

	$query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice',$arrFieldList,$selectConditions,'','');
	
	$result=$this->dbConnection->executeQuery($query);
	$i=0;
	if(mysqli_num_rows($result) > 0){			
		while($row=$result -> fetch_assoc()){
			$arrList[$i][0] = $row["id"];
			$arrList[$i][1] = $row["bill_date"];
			$arrList[$i][2] = $row["net_total"];
			$arrList[$i][3] = $row["checque_amt"]+$row["card_amt"]+$row["amount_paid"];
			$arrList[$i][4] = $row["balance"];
			$net_tot += $row["net_total"];
			$paid_tot += ($row["checque_amt"]+$row["card_amt"]+$row["amount_paid"]);
			$balance_tot += $row["balance"];
			$i++;
		}
	}
	$arrList['net_tot'] = $net_tot;
	$arrList['paid_tot'] = $paid_tot;
	$arrList['balance_tot'] = $balance_tot;

	return $arrList;
}


function final_credit_bill_pharma_details($ip_no){
	$arrList=array();
	$net_tot = 0;
	$paid_tot = 0;
	$balance_tot = 0;	
	$new_bal = 0;

	$arrFieldList[0] = "a.`id`";
	$arrFieldList[1] = "a.`bill_date`";
	$arrFieldList[2] = "a.`net_total`";
	$arrFieldList[3] = "a.`checque_amt`";
	$arrFieldList[4] = "a.`card_amt`"; 
	$arrFieldList[5] = "a.`amount_paid`";
	$arrFieldList[6] = "a.`balance`";
	$arrFieldList[7] = "a.`status`"; 

	$arrFieldList[8] = "b.`amount`";
	$arrFieldList[9] = "b.`date`";
	$arrFieldList[10] = "b.`status` as b_status";
	$arrFieldList[11] = "b.`id` as b_id";
	$arrFieldList[12] = "b.`bill_no`";

	$arrTables[0] = "`hcare_pharma_invoice` a";
	$arrTables[1] = "`hcare_pharma_credit_payment` b";
	
	$joinConditions[1] = "a.`id` = b.`bill_no`";

	$selectConditions[0] = "a.ip_no='".$ip_no."'";

	$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions);
	$result=$this->dbConnection->executeQuery($query);
	$i=0;
	if(mysqli_num_rows($result) > 0){			
		while($row=$result -> fetch_assoc()){
			if($i==0){
				$bill_no_now = $row["bill_no"];
			}
			if($row["b_id"]){			
				$arrList[$i][0] = $row["b_id"];
				$arrList[$i][1] = $row["date"];
				$arrList[$i][2] = $row["bill_no"];
				$arrList[$i][3] = $row["amount"];

				$bill_no_old = $bill_no_now;
				$bill_no_now = $row["bill_no"];
				
				if($new_bal == 0 && $bill_no_old == $bill_no_now){
					$new_bal = $row["balance"]-$row["amount"];
				}
				else if($bill_no_old == $bill_no_now){			
					$new_bal -= $row["amount"];
				}
				else{
					$new_bal = $row["balance"]-$row["amount"];
				}

				$arrList[$i][4] = $new_bal;
				$paid_tot += $row["amount"];
				$balance_tot -= $row["amount"];
			}
			$i++;
		}
	}
	$arrList['net_tot'] = $net_tot;
	$arrList['paid_tot'] = $paid_tot;
	$arrList['balance_tot'] = $balance_tot;

	return $arrList;
}
function getBillItemLabCredit($bill_no){
		$paid_amount=0;
		$arrFieldList[0] = "`amount_paid`";
		$arrFieldList[1] = "`card_amount`"; 

		$selectConditions[0] = "bill_no='".$bill_no."'";

		$query=$this->dbConnection->BuiltQuery('hcare_bill_payments',$arrFieldList,$selectConditions,'','');
		
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		if(mysqli_num_rows($result) > 0){			
			while($row=$result -> fetch_assoc()){
				$paid_amount+=$row['amount_paid'];
				$paid_amount+=$row['card_amount'];
				$i++;
			}
		}
		return $paid_amount;
	}


public function get_patientCreditBill($wheredata = null ,$orderbyfield = 'id',$oderby = 'asc',$limit=null ){
	
		$arrList=array();
		$i=0;
	    $query=$this->dbConnection->BuiltQuery('hcare_bill','',$wheredata,$orderbyfield,$oderby,'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['ref_no'];
				$arrList[$i][2]=$row['bill_date'];
				$arrList[$i][3]=$row['type'];
				$arrList[$i][4]=$row['user_id'];
				$arrList[$i][5]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][6]=$row['credit_card'];
				$arrList[$i][7]=$row['net_total'];
				$arrList[$i][8]=$row['cash'];
				$arrList[$i][9]=$row['credit'];
				$arrList[$i][10]=$row['status'];
				$arrList[$i][11]=$row['paid_with'];
				$arrList[$i][12]=$row['opno'];
				
	
				$where[0]="bill_no='".$row['id']."'";
			    $where[1]="status=0";
				$creditInfo=$this->getCreditBillInfo($where);

				$creditPayment=0;
				if(!empty($creditInfo)){
					 
					for($k=0;$k<count($creditInfo);$k++){
					
						$creditPayment=$creditPayment+$creditInfo[$k][3];
					}
				}
			
				
				$credit_amount=$row['credit']-$creditPayment;
			  //var_dump($creditPayment);

	         $arrList[$i][13]=$credit_amount;		
$i++;
				
		
	
	}


}
return $arrList;
}


	//for email
	function updateEmailStatus($email_status,$billno){				
		$r=$this->dbConnection->update(array("email_status"),array($email_status),"id",$billno,"hcare_bill");
		return $r;		
	}


	function getIPBillConsolidated($wheredata = null){
	
	   $arrFieldList[0]="sum(amount)";
	   $arrFieldList[1]="sum(card_amount)";
	   $arrFieldList[2]="sum(cheque_amt)";
	   $arrFieldList[3]="sum(balance)";
	   $arrFieldList[4]="sum(net_amount)";
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_ip_bill',$arrFieldList,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['sum(amount)'];
						  $arrList[$i][1]=$row['sum(card_amount)'];
						  $arrList[$i][2]=$row["sum(cheque_amt)"];
	                      $arrList[$i][3]=$row["sum(balance)"];
	                      $arrList[$i][4]=$row["sum(net_amount)"];
	                     
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}
	function getAdvanceBillConsolidated($wheredata = null){
	
	   $arrFieldList[0]="sum(cash)";
	   $arrFieldList[1]="sum(card_amount)";
	   
	   $query=$this->dbConnection->BuiltQuery('hcare_advance_payments',$arrFieldList,$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i][0]=$row['sum(cash)'];
						  $arrList[$i][1]=$row['sum(card_amount)'];
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}

	function getDistictBillDates($ipno){
	
	   
	    $query = "SELECT  DISTINCT(DATE(bill_date)) FROM `hcare_bill` WHERE `type` = 'IP' AND `ref_no` = '$ipno'";
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i]=$row['(DATE(bill_date))'];
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}
	function getIpBIllIds($bill_date,$ipno){
	
	   
	    $query = "SELECT  id FROM `hcare_bill` WHERE `type` = 'IP' AND `ref_no` = '$ipno' AND `bill_date` LIKE '%$bill_date%'";
		$result=$this->dbConnection->executeQuery($query);
		$arrList=array();
		if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						
						  $arrList[$i]=$row['id'];
	                    
					
				
							$i++;
						
						}
						
			       }
			       
			       
			       return $arrList;
	   
	}
	function updateEmail($post){
	  
	  $email=$post[0];
		$id=$post[1];
		
		



		//updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_bill","update_history","id",$id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."|CHANGED EMAIL"."&&".$old_update;
	   
	        }

		
		$field_names1=array('email','update_history');
		$field_data=array("$email",$update_history);

		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_bill");
		
		if($result) return true;
		else return false;
	}

	function editEmail($email=null,$billno=null){				
		$r=$this->dbConnection->update(array("email"),array($email),"id",$billno,"hcare_bill");
		return $r;		
	}

	
}


?>
