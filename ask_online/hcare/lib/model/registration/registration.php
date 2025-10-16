<?php 

  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


class Registration{

	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
		date_default_timezone_set('Asia/Calcutta');
	}
	function addPatientinfo($post){
	
			$age=$post['age']." ".$post['age_type'];
			$dob = date("Y-m-d",strtotime($post['dob']));
			
			
			
			$field_names=array("id","first_name","middle_name","last_name","age","dob","gender","marital_status","place","nationality","contact_no","email","prefix","card_expiry","patient_address");
			
			$field_data=array("",$post['first_name'],$post['middle_name'],$post['last_name'],$age,$dob,$post['gender'],$post['marital_status'],$post['place'],$post['nationality'],$post['contact_no'],$post['email'],$post['prefix'],date("Y-m-d",strtotime($post['card_expiry'])),$post['patient_address']);
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_patient_info");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function updatePatientinfo($post){ 
	
			$id=$post['opno'];
			$dob = date("Y-m-d",strtotime($post['dob']));

			//for health checkup
			if(!empty($post['health_checkup'])){
				$field_names=array("first_name","middle_name","last_name","dob","gender","marital_status","place","nationality","contact_no","email","patient_address");
				$field_data=array($post['first_name'],$post['middle_name'],$post['last_name'],$dob,$post['gender'],$post['marital_status'],$post['place'],$post['nationality'],$post['contact_no'],$post['email'],$post['patient_address']);//,"age"    ,$post['age']." ".$post['age_type']
				
			}else {
				
				$field_names=array("first_name","middle_name","last_name","dob","gender","marital_status","place","nationality","contact_no","email","card_expiry","patient_address");
				$field_data=array($post['first_name'],$post['middle_name'],$post['last_name'],$dob,$post['gender'],$post['marital_status'],$post['place'],$post['nationality'],$post['contact_no'],$post['email'],date("Y-m-d",strtotime($post['card_expiry'])),$post['patient_address']);//,$post['age']." ".$post['age_type']
				
			}

			

                      if(!empty($post['c_of'])){
                         
                        $field_names[]="care_of";
                        $field_data[]=$post['c_of'];
                     }
                     if(!empty($post['address'])){
                         
                        $field_names[]="address";
                        $field_data[]=$post['address'];
                     }
                     if(!empty($post['mobile_no'])){
                         
                        $field_names[]="mobile";
                        $field_data[]=$post['mobile_no'];
                     }
			
	
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_op_patient_info");
		
		if($result) return $id;
		else return 0;
	}
	function addVisitInfo($post){ //var_dump($post);
			$gen_obj = new General();
			 $age=$post['age']." ".$post['age_type'];
			if(!empty($post['bk_id'])){
				$reg_from = "Booking";
			}else $reg_from ="Registration";
			
			if(!empty($post['free'])){
				$free=1;
			}else $free=0;
			
			if(!empty($post['health_checkup'])){
				$health_checkup="YES";
				
			}else {
				
				$health_checkup="NO";
				
			}
			
			$user_id=$_SESSION['user_id'];
	  
	                date_default_timezone_set('Asia/Kolkata');
	                $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","opno","doc_id","doc_fee","reg_fee","regfee_disc","regfee_before_disc","card_fee","cardfee_disc","cardfee_before_disc","visit_time","visit_date","validity_expiry","insurance_company","policy_no","claim_no","company_name","company_id","relation","ins_date_issue","ins_date_expiry","ins_cons_disc_type","ins_cons_disc_value","ins_cons_disc_amt","visit_status","remarks","refferal_info","user_id","token_no","reg_from","mlc_summary","op_reset_no","paid_status","free","update_history","card_issued","sms_status1","sms_status2","patient_category","pcat_cons_disc_type","pcat_cons_disc_value","pcat_cons_disc_amt","health_checkup","ref_balance","member_patient_id","member_id","age","payment_status","discount_type","discount_value","discount_amount","payment_mode");
			if(!empty($post['date_issue'])){
				$post['date_issue']=date("Y-m-d",strtotime($post['date_issue']));
				$post['date_expiry']=date("Y-m-d",strtotime($post['date_expiry']));
			}
			
			$selectfield[0]="reg_fee";
			$selectfield[1]="card_fee";
			$fee_actual=$gen_obj->getOpSettings($selectfield,'','date','desc');
			$regfee=$fee_actual[0][0];
			$cardfee=$fee_actual[0][1];
			$regfee_disc = $regfee-$post['regfee'];
			$cardfee_disc = $cardfee-$post['cardfee'];

			$field_data=array("",$post['opno'],$post['doctor'],$post['docfee'],$post['regfee'],$regfee_disc,$regfee,$post['cardfee'],$cardfee_disc,$cardfee,$post['visit_time'],$post['visit_date'],$post['validity'],$post['insurance_company'],$post['policy_no'],$post['claim'],$post['company_name'],$post['company_id'],$post['relation'],$post['date_issue'],$post['date_expiry'],$post['ins_cons_disc_type'],$post['ins_cons_disc_value'],$post['ins_cons_disc_amt'],$post['status'],$post['remarks'],$post['refferal_info'],$_SESSION['user_id'],$post['token'],$reg_from,$post['mlc_summary'],$post['reset_op_no'],"1",$free,$update_history,$post['card_issued'],$post['smsStatus1'],$post['smsStatus2'],$post['patient_category'],$post['pcat_cons_disc_type'],$post['pcat_cons_disc_value'],$post['pcat_cons_disc_amt'],$health_checkup,$post['ref_balance'],$post['member_patient_id'],$post['member_id'],$age,0,$post['bill_disc_type'],$post['bill_disc_value'],$post['disc_amt'],$post['payment_mode']);
			
			$result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_visit_info");
			
			if($result) return $this->dbConnection->mysqli_connect->insert_id;
			else return 0;
			
	}
	function updateVisitInfo($post){
		 $age=$post['age']." ".$post['age_type'];
		//for health checkup
			if(!empty($post['health_checkup'])){
				$health_checkup="YES";
				
			}else {
				
				$health_checkup="NO";
				
			}
	          
			$id=$post['id'];
			
			if(!empty($post['free'])){
				$free=1;
			}else $free=0;
			
			//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			
			$field_names=array("doc_id","doc_fee","reg_fee","card_fee","insurance_company","policy_no","claim_no","company_name","company_id","relation","ins_date_issue","ins_date_expiry","ins_cons_disc_type","ins_cons_disc_value","ins_cons_disc_amt","visit_status","remarks","refferal_info","user_id","mlc_summary","free","update_history","patient_category","pcat_cons_disc_type","pcat_cons_disc_value","pcat_cons_disc_amt","member_patient_id","member_id","health_checkup","age","discount_type","discount_value","discount_amount","payment_mode");
			if(!empty($post['date_issue'])){
				$post['date_issue']=date("Y-m-d",strtotime($post['date_issue']));
				$post['date_expiry']=date("Y-m-d",strtotime($post['date_expiry']));
			}
			
			$field_data=array($post['doctor'],$post['docfee'],$post['regfee'],$post['cardfee'],$post['insurance_company'],$post['policy_no'],$post['claim'],$post['company_name'],$post['company_id'],$post['relation'],$post['date_issue'],$post['date_expiry'],$post['ins_cons_disc_type'],$post['ins_cons_disc_value'],$post['ins_cons_disc_amt'],$post['status'],$post['remarks'],$post['refferal_info'],$_SESSION['user_id'],$post['mlc_summary'],$free,$update_history,$post['patient_category'],$post['pcat_cons_disc_type'],$post['pcat_cons_disc_value'],$post['pcat_cons_disc_amt'],$post['member_patient_id'],$post['member_id'],$health_checkup,$age,$post['bill_disc_type'],$post['bill_disc_value'],$post['disc_amt'],$post['payment_mode']);
			
			
			$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_op_visit_info");
			
			if($result) return $id;
			else return 0;
			
	}
	function deletePatientVisit($post){
		$id=$post['id'];
		$details=$post['cancellation_details'];
		
		
		//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		$field_names1=array('cancelled','cancellation_details',"update_history");
		$field_data=array('1',$details,$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_op_visit_info");
		
		#$result=$this->dbConnection->deletePermenantly($where,"hcare_op_visit_info");
	}
	function updatePaidStatus($opid,$status){
	
		$field_names1=array('paid_status');
		$field_data=array($status);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$opid,"hcare_op_visit_info");
		
		if($result) return true;
		else return false;
	
	}
	public function getVisitDetails($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_op_visit_info','',$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['visit_date'];
				$arrList[$i][2]=$row['visit_time'];
				$arrList[$i][3]=$row['dr_remarks'];
				$arrList[$i][4]=$row['dr_advice'];
				
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	public function getfirstVisit($wheredata){
	
		$arrList=array();
		$query=$this->dbConnection->BuiltQuery('hcare_op_visit_info','',$wheredata,'visit_date','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			$row=$result -> fetch_assoc();
			
				$arrList[0][0]=$row['id'];
				$arrList[0][1]=$row['visit_date'];
				$arrList[0][2]=$row['visit_time'];
				$arrList[0][3]=$row['dr_remarks'];
			
		}
		
		return $arrList;
	
	}
	function getOPPatientCount($selectCondition = null,$orderbyfield = null,$oderby = null ){
	
	   $arrFieldList[0]= "a.`id`";
	   $arrTables[0] = "`hcare_op_patient_info` a";
       			    $arrTables[1] = "`hcare_op_visit_info` b";
       			    $arrTables[2] = "`hcare_emp_info` c";
				    $arrTables[3] = "`hcare_insurance_company` d";
					
					$joinConditions[1] = "a.`id` = b.`opno`";
        		    $joinConditions[2] = "b.`doc_id` = c.`id`";
					$joinConditions[3] = "b.`insurance_company` = d.`id`";
					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
				$orderbyfield="b.op_reset_no";
				$orderby="asc";
				$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit);
								$result=$this->dbConnection->executeQuery($query);
				
				return mysqli_num_rows($result);
	}
	function getOPPatientInfo($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit=null,$group_by=null ){
	
				$arrList=array();
				$new_criteria=array();
			if(empty($selectfield)) {
			
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`first_name`";
				$arrFieldList[2]= "a.`middle_name`";
				$arrFieldList[3]= "a.`last_name`";
				$arrFieldList[4]= "a.`age`";
				$arrFieldList[5]= "a.`dob`";
				$arrFieldList[6]= "a.`gender`";
				$arrFieldList[7]= "a.`marital_status`";
				$arrFieldList[8]= "a.`place`";
				$arrFieldList[9]= "a.`nationality`";
				$arrFieldList[10]= "a.`contact_no`";
				$arrFieldList[11]= "a.`email`";
				$arrFieldList[12]= "a.`status`";
				$arrFieldList[13]= "b.`id`";
				$arrFieldList[14]= "b.`doc_id`";
				$arrFieldList[15]= "c.`first_name`";
				$arrFieldList[16]= "c.`last_name`";
				$arrFieldList[17]= "b.`doc_fee`";
				$arrFieldList[18]= "b.`reg_fee`";
				$arrFieldList[19]= "b.`visit_time`";
				$arrFieldList[20]= "b.`visit_date`";
				$arrFieldList[21]= "b.`validity_expiry`";
				$arrFieldList[22]= "b.`insurance_company`";
				$arrFieldList[23]= "d.`insurance_company`";
				$arrFieldList[24]= "b.`policy_no`";
				$arrFieldList[25]= "b.`claim_no`";
				$arrFieldList[26]= "b.`company_name`";
				$arrFieldList[27]= "b.`company_id`";
				$arrFieldList[28]= "b.`relation`";
				$arrFieldList[29]= "b.`ins_date_issue`";
				$arrFieldList[30]= "b.`ins_date_expiry`";
				$arrFieldList[31]= "b.`ins_cons_disc_amt`";
				$arrFieldList[32]= "b.`visit_status`";
				$arrFieldList[33]= "b.`remarks`";
				$arrFieldList[34]= "b.`refferal_info`";
				$arrFieldList[35]= "b.`user_id`";
				$arrFieldList[36]= "b.`token_no`";
				$arrFieldList[37]= "b.`reg_from`";
				$arrFieldList[38]= "b.`mlc_summary`";
				$arrFieldList[39]= "b.`op_reset_no`";
				$arrFieldList[40]= "b.`paid_status`";
				$arrFieldList[41]= "b.`free`";
				$arrFieldList[42]= "b.`cancelled`";
				$arrFieldList[43]= "b.`cancellation_details`";
                $arrFieldList[44]= "a.`care_of`";
				$arrFieldList[45]= "a.`address`";
				$arrFieldList[46]= "a.`mobile`";
				$arrFieldList[47]= "a.`prefix`";
				$arrFieldList[48]= "b.`update_history`";
				$arrFieldList[49]= "b.`dr_remarks`";
				$arrFieldList[50]= "b.`cons_status`";
				$arrFieldList[51]= "b.`card_fee`";
				$arrFieldList[52]= "a.`card_expiry`";
				$arrFieldList[53]= "b.`card_issued`";
				$arrFieldList[54]= "b.`followup_date`";
				$arrFieldList[55]= "b.`patient_category`";
				$arrFieldList[56]= "b.`health_checkup`";
				
				$arrFieldList[57]= "b.`observation`";
				$arrFieldList[58]= "b.`obs_start`";
				$arrFieldList[59]= "b.`obs_end`";
				$arrFieldList[60]= "b.`ref_balance`";
			//observation room
		$arrFieldList[61]= "e.`room_number`";
		$arrFieldList[62]= "f.`bed_number`";
		//member category
		$arrFieldList[69]="b.`member_patient_id`" ;
		$arrFieldList[70]="b.`member_id`";
		$arrFieldList[71]="b.`age`";
		$arrFieldList[72]="b.`dr_advice`";
		$arrFieldList[73]="b.`payment_status`";
		$arrFieldList[74]= "a.`patient_address`";
		// $arrFieldList[75]= "b.`discount_type`";
		// $arrFieldList[76]= "b.`discount_amount`";
		$arrFieldList[75]="b.`payment_mode`";




				
			}else {
			
				for($k=0;$k<count($selectfield);$k++){
					
						$arrFieldList[]=$selectfield[$k];
					}
			
			}
			
			 		$arrTables[0] = "`hcare_op_patient_info` a";
       			    $arrTables[1] = "`hcare_op_visit_info` b";
       			    $arrTables[2] = "`hcare_emp_info` c";
				    $arrTables[3] = "`hcare_insurance_company` d";
			//observation room
				    $arrTables[4] = "`hcare_rooms` e";
				    $arrTables[5] = "`hcare_room_beds` f";
					
					$joinConditions[1] = "a.`id` = b.`opno`";
        		    $joinConditions[2] = "b.`doc_id` = c.`id`";
					$joinConditions[3] = "b.`insurance_company` = d.`id`";
			//observation room
					$joinConditions[4] = "b.`obs_room` = e.`id`";
					$joinConditions[5] = "b.`obs_bed` = f.`id`";
					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
			if(empty($orderbyfield)){
				$orderbyfield="b.op_reset_no";
				$orderby="asc";
			}
				 $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit,$group_by);
				
				$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){ 
								$i=0;
						while($row=mysqli_fetch_array($result)){
									
								for($k=0;$k<=47;$k++) {						
								
								    if($k == 20) $arrList[$i][$k]=date("Y-m-d",strtotime($row[$k]));
									else $arrList[$i][$k]=$row[$k];
								}
                                //ipno
                             
                               $arrList[$i][48]= $this->dbConnection->idToValue("hcare_ip_info","id","visit_id",$arrList[$i][13]);
				
		//split updation history
		 $update_history='';
			
			if(!empty($row[48])){
			$history_split=explode("&&",$row[48]);
			
			
			
			if(!empty($history_split)){
			
			  for($m=0;$m<count($history_split);$m++) {
			  $history_info=explode("|",$history_split[$m]);
			   
			   $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			   $datetime=$history_info[1];
			   
			   $update_history .=$user_name.":".$datetime."<br>";
			   if($row[42] == 1) break;
			  }
			}
		    }
			$arrList[$i][49]= $update_history;
			$arrList[$i][50]=$row[49];
			$arrList[$i][51]=$row[50];
			$arrList[$i][52]=$row[51];
			$arrList[$i][53]=$row[52];
			$arrList[$i][54]=$row[53];
			$arrList[$i][55]=($row[54] != '0000-00-00' && $row[54]!='1970-01-01')?date("d-m-Y",strtotime($row[54])):'';
			$arrList[$i][56]=$row[55];
			$arrList[$i][57]=$this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$row[55]);
			$arrList[$i][58]=$row[56];
			$arrList[$i][59]=$row[57];
			$arrList[$i][60]=$row[58];
			$arrList[$i][61]=$row[59];
			$arrList[$i][62]=$row[60];
			$arrList[$i][63]=$row[61];
			$arrList[$i][64]=$row[62];

			$arrList[$i][65]=$this->dbConnection->idToValue('hcare_op_observation_bills','id','visit_id',$row[13]);

			if (!empty($arrList[$i][13])) {
				
				$query1 = "select * from `hcare_doctor_referal_info` where visit_id='".$arrList[$i][13]."' and status = 0 ";

				$result1=$this->dbConnection->executeQuery($query1);

				 if(mysqli_num_rows($result1)>0){


								
				   while($row1=mysqli_fetch_assoc($result1)){
						
					  $arrList[$i][66]=$row1['id'];
					  $arrList[$i][67]=$row1['new_visit_id'];
					  $arrList[$i][68]=$row1['ref_type'];
					  $arrList[$i][69]=$row1['status'];

															
				   }	
				}



			}

			$arrList[$i][70]=$row[63];
			$arrList[$i][71]=$this->dbConnection->idToValue('hcare_op_observation_bills','sum(cash_amount+card_amount+cheque_amt)','visit_id',$row[13]);
			//observation room
			$arrList[$i][77]=$row[62];
			$arrList[$i][78]=$row[63];
			//member category
			$arrList[$i][79]=$row[63];
			$arrList[$i][80]=$row[64];
			$arrList[$i][81]= $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$row[63]);
			$arrList[$i][82]= $this->dbConnection->idToValue('hcare_patient_category_members','first_name','id',$row[64]).' '.$this->dbConnection->idToValue('hcare_patient_category_members','last_name','id',$row[64]);
			
			//for free
			$arrList[$i][83]=$row[41];

			$arrList[$i][84]=0;

             $arrList[$i][85]=$row[65];

            if (!empty($arrList[$i][85])) {
            	$arrList[$i][4] = $arrList[$i][85];
            }

            $arrList[$i][86]=$row[61];
            
            $arrList[$i][87]=$row[62];

            $arrList[$i][88]=$this->dbConnection->idToValue('hcare_op_visit_info','dr_advice','id',$arrList[$i][13]);
            $arrList[$i][89]=$this->dbConnection->idToValue('hcare_op_visit_info','examination','id',$arrList[$i][13]);

			$new_criteria[0] = "visit_id = ".$arrList[$i][13];
			$new_criteria[1] = "status = 0";

			$arrList[$i][90]=$this->dbConnection->idToValueMultiple('id',$new_criteria,'hcare_labtest_prescribed');

			$arrList[$i][91]=$this->dbConnection->idToValue('hcare_op_visit_info','payment_status','id',$arrList[$i][13]);

			$arrList[$i][92]=$this->dbConnection->idToValue('hcare_op_patient_info','patient_address','id',$arrList[$i][0]);
			$arrList[$i][93]=$this->dbConnection->idToValue('hcare_op_visit_info','discount_type','id',$arrList[$i][13]);
			$arrList[$i][94]=$this->dbConnection->idToValue('hcare_op_visit_info','discount_amount','id',$arrList[$i][13]);
			$arrList[$i][95]=$this->dbConnection->idToValue('hcare_op_visit_info','payment_mode','id',$arrList[$i][13]);


			$i++;
						
						}
				    
				}
			return $arrList;
	}
	function getAllOPCount($selectCondition = null ){
	
	  $query=$this->dbConnection->BuiltQuery('hcare_op_patient_info','',$wheredata,'id','asc');	
	  $result=$this->dbConnection->executeQuery($query);
	  return mysqli_num_rows($result);
	}
	function getAllOPPatients($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit=null ){
	
	
	$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_op_patient_info','',$selectCondition,$orderbyfield,$oderby,'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['first_name'];
				$arrList[$i][2]=$row['middle_name'];
				$arrList[$i][3]=$row['last_name'];
				$arrList[$i][4]=$row['age'];
				$arrList[$i][5]=$row['dob'];
				$arrList[$i][6]=$row['gender'];
				$arrList[$i][7]=$row['marital_status'];
				$arrList[$i][8]=$row['place'];
				$arrList[$i][9]=$row['nationality'];
				$arrList[$i][10]=$row['contact_no'];
				$arrList[$i][11]=$row['email'];
				$arrList[$i][12]=$row['status'];
				$arrList[$i][13]=$row['care_of'];
				$arrList[$i][14]=$row['address'];
				$arrList[$i][15]=$row['mobile'];
				$arrList[$i][16]=$row['prefix'];
				$arrList[$i][17]=$row['card_expiry'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	public function getOpDoctorPayments($visit_date,$doc_id){
	
		$arrList=array();
		$query="select sum(doc_fee) from hcare_op_visit_info where visit_date like '%$visit_date%' and cancelled=0";

		if (!empty($doc_id)) {
			$query .= " and doc_id = '$doc_id'";
		}

		$result=$this->dbConnection->executeQuery($query);

		$arrayList[0]=$visit_date;
		$arrayList[1]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$doc_id)." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$doc_id)." ".$this->dbConnection->idToValue('hcare_emp_info','last_name','id',$doc_id);
		$arrayList[2]=$result->fetch_assoc()['sum(doc_fee)'];
		$arrayList[3]=$doc_id;

		$query = "select * from hcare_op_dr_payments where doc_id = '$doc_id' and visit_date = '$visit_date' " ;
		$result=$this->dbConnection->executeQuery($query);

		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrayList[4]= $row['balance'];
				$arrayList[5]= $row['amount_paid_so_far'];

			}
			
		}
		
		return $arrayList;

	}
	function addDrPayments($post){
	
			
			$field_names=array("id","doc_id","visit_date","payment_date","doc_fee","amount_paid","amount_paid_so_far","balance","status","user_id");
			
			$field_data=array("",$post['doc_id'],$post['visit_date'],$post['payment_date'],$post['doc_fee'],$post['amount_paid'],$post['amount_paid_so_far'],$post['balance'],0,$_SESSION['user_id']);
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_dr_payments");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function getOpDoctorCollection($wheredata){
	
	
	$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_op_dr_payments','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['doc_id'];
				$arrList[$i][2]=$row['visit_date'];
				$arrList[$i][3]=$row['payment_date'];
				$arrList[$i][4]=$row['doc_fee'];
				$arrList[$i][5]=$row['amount_paid'];
				$arrList[$i][6]=$row['staus'];
				$arrList[$i][7]=$row['balance'];
				$arrList[$i][8]=$row['action'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function getPatientOnlineInfoDirect($id){

		 $wheredata[0]="id=".$id;
	     $query=$this->dbConnection->BuiltQuery("hcare_direct_customer",'',$wheredata,"id","desc");		
		 $result=$this->dbConnection->executeQuery($query);
		 $i=0;
		 $arrList=array();
		 if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['name'];
			$arrList[$i][2]=$row['age'];
			$arrList[$i][3]=$row['gender'];
			$arrList[$i][4]=$row['place'];
			$arrList[$i][5]=$row['contact_no'];
			$arrList[$i][6]=$row['refferal_info'];
			$arrList[$i][7]=$row['prefix'];
			$arrList[$i][8]=$row['status'];
			$arrList[$i][9]=$this->dbConnection->idToValue("hcare_bill","email","ref_no",$id);

													
			
			
			$i++;
		   }	
		}
			
	  return $arrList;

	}
	function updateObservation($id,$observation_status,$room,$bed){
			 $room_obj= new Room();
		//updation history
			$user_id=$_SESSION['user_id'];
		      if(!$bed) {
		      		$bed=$this->dbConnection->idToValue("hcare_op_visit_info","obs_bed","id",$id);
		      }
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		$field_names1=array("update_history","observation","obs_start","obs_room","obs_bed");
		$field_names2=array("update_history","observation","obs_end");
		$field_data1=array($update_history,$observation_status,date("Y-m-d H:i:s"),$room,$bed);
		$field_data2=array($update_history,$observation_status,date("Y-m-d H:i:s"));
		$condition_fields=array("room_id","bed_number");
		$condition=array($room,$bed);

		if($observation_status=='YES'){
			$result=$this->dbConnection->update($field_names1,$field_data1,"id",$id,"hcare_op_visit_info");
			$room_obj->updateBedStatus('ADMITTED',$bed);
		}
		else{
			$result=$this->dbConnection->update($field_names2,$field_data2,"id",$id,"hcare_op_visit_info");
			$room_obj->updateBedStatus('FREE',$bed);
		}
		
		
	}
	function updateObservationDischarge($id,$observation_status){
		$room_obj= new Room();
		//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		$field_names1=array("update_history","observation","obs_end");
		
		$field_data=array($update_history,$observation_status,date("Y-m-d H:i:s"));
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_op_visit_info");
		$bed=$this->dbConnection->idToValue("hcare_op_visit_info","obs_bed","id",$id);
		$room_obj->updateBedStatus('FREE',$bed);
		
	}
	function cancelOp($id,$docid){
		
		//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }

		        $doctor=$this->dbConnection->idToValue("hcare_emp_info","title","id",$docid)." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$docid)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$docid); 

		       $cancellation_details = "Refered to ".$doctor."";

		$field_names1=array("update_history","cancelled","cancellation_details");
		$field_data=array($update_history,1,$cancellation_details);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_op_visit_info");
		
	}
	function updateRefInfo($ref_id,$new_visit_id){
		
		$field_names1=array("new_visit_id");
		$field_data=array($new_visit_id);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$ref_id,"hcare_doctor_referal_info");
		
	}
	function updateFeeInfo($post){
		
		$field_names1=array("reg_fee","card_fee");
		$field_data=array(0,0);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$post['id'],"hcare_op_visit_info");
		
	}
	function updatePatientinfo_ref($post){ 
	
			$id=$post['opno'];
			$dob = date("Y-m-d",strtotime($post['dob']));

			$field_names=array("card_expiry");
			$field_data=array(date("Y-m-d",strtotime($post['card_expiry'])));

                      if(!empty($post['c_of'])){
                         
                        $field_names[]="care_of";
                        $field_data[]=$post['c_of'];
                     }
                     if(!empty($post['address'])){
                         
                        $field_names[]="address";
                        $field_data[]=$post['address'];
                     }
                     if(!empty($post['mobile_no'])){
                         
                        $field_names[]="mobile";
                        $field_data[]=$post['mobile_no'];
                     }
			
	
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_op_patient_info");
		
		if($result) return $id;
		else return 0;
	}
	function getDocReg($doc_id,$from_date,$to_date){

		$query = "SELECT sum(doc_fee+card_fee+reg_fee) as amount FROM `hcare_op_visit_info` WHERE `visit_date`>='".$from_date." 00:00:00' AND `visit_date`<='".$to_date." 23:59:59' AND `doc_id`='".$doc_id."' AND `cancelled`=0";

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
//for member category
	function iftherepatientids($category_id){
		$query = "SELECT `id` FROM `hcare_patient_category_ids` WHERE `status`=0 and `category_id`=".$category_id;

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			
			return true;			
			
		}
		return false;
	}

	function getMemberDetails($member_id){
		 $query = "SELECT * FROM `hcare_patient_category_members` WHERE `status`=0 and `id`=".$member_id;

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				$arrayList[0] = $row['first_name'];
				$arrayList[1] = $row['last_name'];
				$arrayList[2] = $row['place'];
				$arrayList[3] = $row['age'];
				$arrayList[4] = $row['age_type'];
				$arrayList[5] = $row['gender'];
				$arrayList[6] = $row['contact'];
			}	
			
		}
		return $arrayList;

	}


	//for booking
	function duplicateDoc($today,$opno,$docid1){
		$query = "SELECT doc_id FROM `hcare_op_visit_info` WHERE `visit_date` like '%".$today."%' and opno=".$opno." and doc_id=".$docid1." and `cancelled`=0";

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				return $row['doc_id'];
			}				
		}
		return 0;
	}
	function getValidity($opno,$docid){
		$query = "SELECT max(validity_expiry) FROM `hcare_op_visit_info` WHERE opno=".$opno." and doc_id=".$docid." and `cancelled`=0";

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				return $row['max(validity_expiry)'];
			}
		}
		return 0;
	}
	//end of for booking
	
	
	
	
	//for patient op bill record
	function getVisitDate($opno){
		$i=0;
		$query = "SELECT id,visit_date FROM `hcare_op_visit_info` WHERE `opno`=".$opno;

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				$arrayList[$i][0] = $row['id'];
				$arrayList[$i][1] = $row['visit_date'];
				$i++;
			}	
			
		}
		return $arrayList;
	}
	//for patient ip bill record
	function getipno($opno){
		$i=0;
		$query = "SELECT id FROM `hcare_ip_info` WHERE `opno`=".$opno;

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				$arrayList[$i] = $row['id'];
				$i++;
			}	
			
		}
		return $arrayList;
	}
   function update_save_payment_status($id,$value,$checked){
		
		//updation history
			

			if ($checked==1) {

				$payment_status = 1;
				$date           = date("Y-m-d H:i:s");
				$user_id        = $_SESSION['user_id'];
			}
			else{
	
				$payment_status = 0;
				$date           = '';
				$user_id        = '';
			}
	
	        $field_names=array("payment_status","payment_date","payment_user");
			
			$field_data=array($payment_status,$date,$user_id);
			
	  		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_op_visit_info");
		
		if($result) return $id;
		else return 0;
	
	}

	function addOtSchedule($post){
		date_default_timezone_set('Asia/Kolkata');
	
			$age=$post['age']." ".$post['age_type'];
			$surgery_started_date_time = date("Y-m-d H:i:s",strtotime($post['surgery_strated_date_time']));
			$surgery_ended_date_time = date("Y-m-d H:i:s",strtotime($post['surgery_ended_date_time']));
			// echo $surgery_started_date_time;exit();



			$user_id=$_SESSION['user_id'];
	  
      
      $update_history = $user_id."|". date("d-m-Y H:i a");

			
			
			$field_names=array("id","surgery_name","surgery_details","first_name","middle_name","last_name","patient_address","patient_contact","patient_age","patient_gender","surgery_started_date_time","surgery_ended_date_time","surgery_status","remarks","status","update_history","type","ref_no");
			
			$field_data=array("",$post['surgery_name'],$post['surgery_details'],$post['first_name'],$post['middle_name'],$post['last_name'],$post['address'],$post['mobile_no'],$age,$post['gender'],$surgery_started_date_time,$surgery_ended_date_time,$post['surgery_status'],$post['remarks'],0,$update_history,$post['patient_type'],$post['ref_no']);
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ot_schedule");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}

	function addOtScheduleDoctors($otInfo=null,$id=null){

		$field_names=array("id","ot_schedule_id","doctor_id","doctor_name","status");
			
			$field_data=array("",$otInfo[0],$otInfo[1],$otInfo[2],0);
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ot_schedule_doctors");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;



	}

		function getOtScheduleCount($wheredata = null ){
	
	  $query=$this->dbConnection->BuiltQuery('hcare_ot_schedule','',$wheredata,'id','asc');	
	  $result=$this->dbConnection->executeQuery($query);
	  return mysqli_num_rows($result);
	}
	function getOtSchedule($wheredata = null,$limit=null){

		 
	     $query=$this->dbConnection->BuiltQuery("hcare_ot_schedule",'',$wheredata,"id","desc",'',$limit);		
		 $result=$this->dbConnection->executeQuery($query);
		 $i=0;
		 $arrList=array();
		 if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['surgery_name'];
			$arrList[$i][2]=$row['surgery_details'];
			$arrList[$i][3]=$row['first_name'];
			$arrList[$i][4]=$row['middle_name'];
			$arrList[$i][5]=$row['last_name'];
			$arrList[$i][6]=$row['patient_address'];
			$arrList[$i][7]=$row['patient_contact'];
			$arrList[$i][8]=$row['patient_age'];
			$arrList[$i][9]=$row['patient_gender'];
			$arrList[$i][10]=$row['surgery_started_date_time'];
			$arrList[$i][11]=$row['surgery_ended_date_time'];
			$arrList[$i][12]=$row['surgery_status'];
			$arrList[$i][13]=$row['remarks'];
			$arrList[$i][14]=$row['status'];
			$arrList[$i][15]=$row['update_history'];
			$arrList[$i][16]=$row['type'];
			$arrList[$i][17]=$row['ref_no'];
			
			

													
			
			
			$i++;
		   }	
		}
			
	  return $arrList;

	}

	function getOtScheduleDoctors($wheredata=null){

		  $query=$this->dbConnection->BuiltQuery("hcare_ot_schedule_doctors",'',$wheredata,"id","asc",'',$limit);		
		 $result=$this->dbConnection->executeQuery($query);
		 $i=0;
		 $arrList=array();
		 if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['ot_schedule_id'];
			$arrList[$i][2]=$row['doctor_id'];
			$arrList[$i][3]=$row['doctor_name'];
			$arrList[$i][4]=$row['status'];
			
			
			$i++;
		   }	
		}
			
	  return $arrList;


	}

	function updateOtSchedule($post=null){


		date_default_timezone_set('Asia/Kolkata');

		$id=$post['id'];
	
			$age=$post['age']." ".$post['age_type'];
			$surgery_started_date_time = date("Y-m-d H:i:s",strtotime($post['surgery_strated_date_time']));
			$surgery_ended_date_time = date("Y-m-d H:i:s",strtotime($post['surgery_ended_date_time']));


		//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }


		       $field_names=array("surgery_name","surgery_details","first_name","middle_name","last_name","patient_address","patient_contact","patient_age","patient_gender","surgery_started_date_time","surgery_ended_date_time","surgery_status","remarks","update_history","type","ref_no");
			
			$field_data=array($post['surgery_name'],$post['surgery_details'],$post['first_name'],$post['middle_name'],$post['last_name'],$post['address'],$post['mobile_no'],$age,$post['gender'],$surgery_started_date_time,$surgery_ended_date_time,$post['surgery_status'],$post['remarks'],$update_history,$post['patient_type'],$post['ref_no']);

			$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_ot_schedule");
		
			if($result) return $id;
			else return 0;
	

	}

	function updateOtScheduleDoctors($id=null){

		// echo $id;exit;

			$field_names=array("status");
			
			$field_data=array(1);

			$result=$this->dbConnection->update($field_names,$field_data,"ot_schedule_id",$id,"hcare_ot_schedule_doctors");
		
			if($result) return $id;
			else return 0;


	}

	function deleteOtSchedule($post=null){
			$id=$post['id'];
		$details=$post['cancellation_details'];
		
		
		//updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		$field_names1=array('status','cancellation_details',"update_history");
		$field_data=array('1',$details,$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_ot_schedule");

		if($result) return $id;
			else return 0;
	}

	function deleteOtScheduleDoctors($id=null){

			
		
		$field_names1=array('status','cancelled');
		$field_data=array('1',1);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"ot_schedule_id",$id,"hcare_ot_schedule_doctors");
		if($result) return $id;
			else return 0;

	}

		function getOPPatientInfoProcessOPSearch($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit=null,$group_by=null ){
	
				$arrList=array();
			if(empty($selectfield)) {
			$arrFieldList[0]= "a.`id`";
	  		$arrFieldList[1]= "a.`first_name`";
				$arrFieldList[2]= "a.`middle_name`";
				$arrFieldList[3]= "a.`last_name`";
				$arrFieldList[4]= "a.`age`";
				$arrFieldList[5]= "a.`gender`";
				$arrFieldList[6]= "a.`place`";
				$arrFieldList[7]= "c.`first_name`";
				$arrFieldList[8]= "c.`last_name`";
				$arrFieldList[9]= "b.`visit_time`";
				$arrFieldList[10]= "b.`visit_date`";
				$arrFieldList[11]= "b.`insurance_company`";
				$arrFieldList[12]= "d.`insurance_company`";
				$arrFieldList[13]= "b.`visit_status`";

				$arrFieldList[14]= "b.`free`";

				
			}else {
			
				for($k=0;$k<count($selectfield);$k++){
					
						$arrFieldList[]=$selectfield[$k];
					}
			
			}
			
			 		$arrTables[0] = "`hcare_op_patient_info` a";
       			    $arrTables[1] = "`hcare_op_visit_info` b";
       			    $arrTables[2] = "`hcare_emp_info` c";
				    $arrTables[3] = "`hcare_insurance_company` d";

					
					$joinConditions[1] = "a.`id` = b.`opno`";
        		    $joinConditions[2] = "b.`doc_id` = c.`id`";
					$joinConditions[3] = "b.`insurance_company` = d.`id`";

					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
			// if(empty($orderbyfield)){
			// 	$orderbyfield="b.op_reset_no";
			// 	$orderby="asc";
			// }
				$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit,$group_by);
				
				$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						


	
							$arrList[$i][0]=$row[0];
							$arrList[$i][1]=$row[1];
							$arrList[$i][2]=$row[2];
							$arrList[$i][3]=$row[3];
							$arrList[$i][4]=$row[4];
							$arrList[$i][5]=$row[5];
							$arrList[$i][6]=$row[6];
							$arrList[$i][7]=$row[7];
							$arrList[$i][8]=$row[8];
							$arrList[$i][9]=$row[9];
							$arrList[$i][10]=$row[10];
							$arrList[$i][11]=$row[11];
							$arrList[$i][12]=$row[12];
							$arrList[$i][13]=$row[13];
							$arrList[$i][14]=$row[14];
			
	
		
             
			$i++;
			
						}
				    
				} 
				
			
			return $arrList;
	}

	function getOPPatientInfoNew($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit=null,$group_by=null ){
	
				$arrList=array();
			if(empty($selectfield)) {
			$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`first_name`";
				$arrFieldList[2]= "a.`middle_name`";
				$arrFieldList[3]= "a.`last_name`";
				$arrFieldList[4]= "a.`age`";
				$arrFieldList[5]= "a.`dob`";
				$arrFieldList[6]= "a.`gender`";
				$arrFieldList[7]= "a.`marital_status`";
				$arrFieldList[8]= "a.`place`";
				$arrFieldList[9]= "a.`nationality`";
				$arrFieldList[10]= "a.`contact_no`";
				$arrFieldList[11]= "a.`email`";
				$arrFieldList[12]= "a.`status`";
				$arrFieldList[13]= "b.`id`";
				$arrFieldList[14]= "b.`doc_id`";
				$arrFieldList[15]= "c.`first_name`";
				$arrFieldList[16]= "c.`last_name`";
				$arrFieldList[17]= "b.`doc_fee`";
				$arrFieldList[18]= "b.`reg_fee`";
				$arrFieldList[19]= "b.`visit_time`";
				$arrFieldList[20]= "b.`visit_date`";
				$arrFieldList[21]= "b.`validity_expiry`";
				$arrFieldList[22]= "b.`insurance_company`";
				$arrFieldList[23]= "d.`insurance_company`";
				$arrFieldList[24]= "b.`policy_no`";
				$arrFieldList[25]= "b.`claim_no`";
				$arrFieldList[26]= "b.`company_name`";
				$arrFieldList[27]= "b.`company_id`";
				$arrFieldList[28]= "b.`relation`";
				$arrFieldList[29]= "b.`ins_date_issue`";
				$arrFieldList[30]= "b.`ins_date_expiry`";
				$arrFieldList[31]= "b.`ins_cons_disc_amt`";
				$arrFieldList[32]= "b.`visit_status`";
				$arrFieldList[33]= "b.`remarks`";
				$arrFieldList[34]= "b.`refferal_info`";
				$arrFieldList[35]= "b.`user_id`";
				$arrFieldList[36]= "b.`token_no`";
				$arrFieldList[37]= "b.`reg_from`";
				$arrFieldList[38]= "b.`mlc_summary`";
				$arrFieldList[39]= "b.`op_reset_no`";
				$arrFieldList[40]= "b.`paid_status`";
				$arrFieldList[41]= "b.`free`";
				$arrFieldList[42]= "b.`cancelled`";
				$arrFieldList[43]= "b.`cancellation_details`";
                $arrFieldList[44]= "a.`care_of`";
				$arrFieldList[45]= "a.`address`";
				$arrFieldList[46]= "a.`mobile`";
				$arrFieldList[47]= "a.`prefix`";
				$arrFieldList[48]= "b.`update_history`";
				$arrFieldList[49]= "b.`dr_remarks`";
				$arrFieldList[50]= "b.`cons_status`";
				$arrFieldList[51]= "b.`card_fee`";
				$arrFieldList[52]= "a.`card_expiry`";
				$arrFieldList[53]= "b.`card_issued`";
				$arrFieldList[54]= "b.`followup_date`";
				$arrFieldList[55]= "b.`patient_category`";
				$arrFieldList[56]= "b.`health_checkup`";
				
				$arrFieldList[57]= "b.`observation`";
				$arrFieldList[58]= "b.`obs_start`";
				$arrFieldList[59]= "b.`obs_end`";
				$arrFieldList[60]= "b.`ref_balance`";
			//observation room
		$arrFieldList[61]= "e.`room_number`";
		$arrFieldList[62]= "f.`bed_number`";
		//member category
		$arrFieldList[69]="b.`member_patient_id`" ;
		$arrFieldList[70]="b.`member_id`";
		$arrFieldList[71]="b.`age`";
		$arrFieldList[72]="b.`dr_advice`";
		$arrFieldList[73]="b.`payment_status`";
		$arrFieldList[74]= "a.`patient_address`";

				
			}else {
			
				for($k=0;$k<count($selectfield);$k++){
					
						$arrFieldList[]=$selectfield[$k];
					}
			
			}
			$arrTables[0] = "`hcare_op_patient_info` a";
       			    $arrTables[1] = "`hcare_op_visit_info` b";
       			    $arrTables[2] = "`hcare_emp_info` c";
				    $arrTables[3] = "`hcare_insurance_company` d";
			//observation room
				    $arrTables[4] = "`hcare_rooms` e";
				    $arrTables[5] = "`hcare_room_beds` f";
					
					$joinConditions[1] = "a.`id` = b.`opno`";
        		    $joinConditions[2] = "b.`doc_id` = c.`id`";
					$joinConditions[3] = "b.`insurance_company` = d.`id`";
			//observation room
					$joinConditions[4] = "b.`obs_room` = e.`id`";
					$joinConditions[5] = "b.`obs_bed` = f.`id`";

					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
			if(empty($orderbyfield)){
				$orderbyfield="b.op_reset_no";
				$orderby="asc";
			}
				$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit,$group_by);
				
				$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
						


	
							$arrList[$i][0]=$row[0];
							$arrList[$i][1]=$row[1];
							$arrList[$i][2]=$row[2];
							$arrList[$i][3]=$row[3];
							$arrList[$i][4]=$row[4];
							// $arrList[$i][5]=$row[5];
							$arrList[$i][6]=$row[6];
							// $arrList[$i][7]=$row[7];
							$arrList[$i][8]=$row[8];
							// $arrList[$i][9]=$row[9];
							// $arrList[$i][10]=$row[10];
							$arrList[$i][11]=$row[11];
							// $arrList[$i][12]=$row[12];
							$arrList[$i][13]=$row[13];
							$arrList[$i][14]=$row[14];
							$arrList[$i][15]=$row[15];
							$arrList[$i][16]=$row[16];
							$arrList[$i][19]=$row[19];
							$arrList[$i][20]=$row[20];
							$arrList[$i][22]=$row[22];
							$arrList[$i][23]=$row[23];
							$arrList[$i][32]=$row[32];
							$arrList[$i][47]=$row[47];
							$arrList[$i][48]= $this->dbConnection->idToValue("hcare_ip_info","id","visit_id",$arrList[$i][13]);
							$arrList[$i][53]=$row[52];
							$arrList[$i][54]=$row[53];
							$arrList[$i][57]=$this->dbConnection->idToValue('hcare_patient_category','patient_category','id',$row[55]);
							$arrList[$i][58]=$row[56];
							$arrList[$i][59]=$row[57];
							$arrList[$i][61]=$row[59];
							$arrList[$i][63]=$row[61];
							$arrList[$i][81]= $this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id',$row[63]);

							$new_criteria[0] = "visit_id = ".$arrList[$i][13];
							$new_criteria[1] = "status = 0";

							$arrList[$i][90]=$this->dbConnection->idToValueMultiple('id',$new_criteria,'hcare_labtest_prescribed');
			
	
		
             
			$i++;
			
						}
				    
				} 
				
			
			return $arrList;
	}


}
?>
