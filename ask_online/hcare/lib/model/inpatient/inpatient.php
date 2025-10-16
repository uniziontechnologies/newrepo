<?php 

  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 
  
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


class Inpatient{

	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
		 date_default_timezone_set('Asia/Kolkata');
	}
	function addIpPatient($post){
	
			$age=$post['age']." ".$post['age_type'];
			$dob = date("Y-m-d",strtotime($post['dob']));
			
			$user_id=$_SESSION['user_id'];
	  
	                date_default_timezone_set('Asia/Kolkata');
	                $update_history = $user_id."|". date("d-m-Y H:i a");
			
			$field_names=array( 'id' ,'visit_id' ,'opno' ,'doc_id' ,'admission_time' ,'admission_date'  ,'insurance_company' ,'patient_category','member_patient_id', 'member_id','policy_no' ,'claim_no' ,'company_name' ,'company_id' ,'relation' ,'ins_date_issue' ,'ins_date_expiry' ,'referral_info' ,'room_id' ,'bed_id' ,'room_rent' ,'nursing_charge','maintenance','remarks' ,'user_id',"update_history","bystander_status","bystander_charge" );
			$field_data=array("",$post['id'],$post['opno'],$post['doctor'],$post['admission_time'],$post['admission_date'],$post['insurance_company'],$post['patient_category'],$post['member_patient_id'], $post['member_id'],$post['policy_no'],$post['claim'],$post['company_name'],$post['company_id'],$post['relation'],$post['date_issue'],$post['date_expiry'],$post['refferal_info'],$post['room'],$post['bed_no'],$post['rent'],$post['ncharge'],$post['mcharge'],$post['remarks'],$_SESSION['user_id'],$update_history,$post['bystander_status'],$post['bcharge']);
		
        
        $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_info");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	}
	function add_discharge_date($post){
	
	  $field_names=array( 'discharge_time' ,'discharge_date');
	  $field_data=array($post['curr_time'],date("Y-m-d",strtotime($post['dod'])));
	  
	  $result=$this->dbConnection->update($field_names,$field_data,"id",$post['id'],"hcare_ip_info");
		
		if($result) return $id;
		else return 0;
	
	}
	function update_bill_status($post){
	
	  $field_names=array( 'bill_status');
	  $field_data=array($post['bill_status']);
	  
	  $result=$this->dbConnection->update($field_names,$field_data,"id",$post['id'],"hcare_ip_info");
		
		if($result) return $id;
		else return 0;
	
	}
	function updateIpPatient($post){
	
	   $id=$post['ipno'];
	   
	   //updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_ip_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	   
	                $field_names=array( 'doc_id' ,'insurance_company' ,'patient_category', 'policy_no' ,'claim_no' ,'company_name' ,'company_id' ,'relation' ,'ins_date_issue' ,'ins_date_expiry' ,'referral_info' ,'remarks',"update_history","bystander_status");
			$field_data=array($post['doctor'],$post['insurance_company'],$post['patient_category'],$post['policy_no'],$post['claim'],$post['company_name'],$post['company_id'],$post['relation'],$post['date_issue'],$post['date_expiry'],$post['refferal_info'],$post['remarks'],$update_history,$post['bystander_status']);

                        if(!empty($post['room']) && !empty($post['bed_no'])){

                                $field_names[]='room_id';
                                $field_names[]='bed_id'; 
                                $field_names[]='room_rent' ;
								$field_names[]='nursing_charge' ;
								$field_names[]='maintenance' ;
								$field_names[]='bystander_charge' ;


                               $field_data[]=$post['room'];
                               $field_data[]=$post['bed_no']; 
                               $field_data[]=$post['rent'] ;
							   $field_data[]=$post['ncharge'] ;
							   $field_data[]=$post['mcharge'] ;
							   $field_data[]=$post['bcharge'] ;

                        }
			
			$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_ip_info");
		
		if($result) return $id;
		else return 0;
		
	
	}
        function addIProomHistory($post){
               
                
	  $field_names=array( 'ipno' ,'start_date','end_date','room_id','bed_id','rent','nursing_charge','maintenance','bystander_charge','from_time','to_time');
	  $field_data=array($post['ipno'],date("Y-m-d",strtotime($post['startdate'])),date("Y-m-d",strtotime($post['enddate'])),$post['room_id'],$post['bed_id'],$post['current_rent'],$post['current_ncharge'],$post['current_mcharge'],$post['current_bcharge'],$post['from_time'],$post['to_time']);
	  
	  $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_room_history");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;

        }
		
		function updateIPRoomInfo($post){
		
		$id=$post['ipno'];
	   
	   //updation history
			$user_id=$_SESSION['user_id'];
		       
	  
	                date_default_timezone_set('Asia/Kolkata');
	   
	                $old_update=$this->dbConnection->idToValue("hcare_ip_info","update_history","id",$id);
			
			
	   
	 
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	   
	        
                                $field_names[0]='room_id';
                                $field_names[1]='bed_id'; 
                                $field_names[2]='room_rent' ;
								$field_names[3]='nursing_charge' ;
								$field_names[4]='maintenance' ;

                               $field_data[0]=$post['room'];
                               $field_data[1]=$post['bed_no']; 
							   $field_data[2]=$post['rent'] ;
							   $field_data[3]=$post['ncharge'] ;
							   $field_data[4]=$post['mcharge'] ;
                
			
			$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_ip_info");
		
		if($result) return $id;
		else return 0;
		}
function getRoomhistory($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		
		$query=$this->dbConnection->BuiltQuery("hcare_ip_room_history",$selectfield,$wheredata,$orderbyfield,$orderby);	
		
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){

				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
                        $arrList[$i][5]=$row[5];
                        $arrList[$i][6]=$row[6];
						$arrList[$i][7]=$this->dbConnection->idToValue("hcare_rooms","room_number","id",$row[4]);
						
						$arrList[$i][8]=$this->dbConnection->idToValue("hcare_room_beds","bed_number","id",$row[5]);
					    $arrList[$i][9]=$row[7];
             $arrList[$i][10]=$row[8];
             $arrList[$i][11]=$row[9];
             $arrList[$i][12]=$row[10];
             $arrList[$i][13]=$row[11];
					
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function getIPPatientCount($selectCondition = null,$orderbyfield = null,$oderby = null ){
	
	   $arrFieldList[0]= "b.`id`";
	    $arrTables[0] = "`hcare_ip_info` b";
	                $arrTables[1] = "`hcare_op_patient_info` a";       			    
       			    $arrTables[2] = "`hcare_rooms` c";
					$arrTables[3] = "`hcare_room_beds` e";
					$arrTables[4] = "`hcare_emp_info` f";
				    $arrTables[5] = "`hcare_insurance_company` d";
			        
					$joinConditions[1] = "b.`opno` = a.`id`";
					$joinConditions[2] = "b.`room_id` = c.`id`";
					$joinConditions[3] = "b.`bed_id` = e.`id`";
        		    $joinConditions[4] = "b.`doc_id` = f.`id`";
					$joinConditions[5] = "b.`insurance_company` = d.`id`";
					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
				$orderbyfield="b.id";
				$orderby="desc";
				$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit);
								$result=$this->dbConnection->executeQuery($query);
				
				return mysqli_num_rows($result);
	}
	
	function getIPPatientInfo($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit = null ){
	
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
				$arrFieldList[14]= "b.`visit_id`";
				$arrFieldList[15]= "b.`opno`";
				$arrFieldList[16]= "b.`doc_id`";
				$arrFieldList[17]= "f.`first_name`";
				$arrFieldList[18]= "f.`last_name`";
				$arrFieldList[19]= "b.`admission_time`";
				$arrFieldList[20]= "b.`admission_date`";
				$arrFieldList[21]= "b.`discharge_time`";
				$arrFieldList[22]= "b.`discharge_date`";
				$arrFieldList[23]= "b.`insurance_company`";
				$arrFieldList[24]= "d.`insurance_company`";
				$arrFieldList[25]= "b.`policy_no`";
				$arrFieldList[26]= "b.`claim_no`";
				$arrFieldList[27]= "b.`company_name`";
				$arrFieldList[28]= "b.`company_id`";
				$arrFieldList[29]= "b.`relation`";
				$arrFieldList[30]= "b.`ins_date_issue`";
				$arrFieldList[31]= "b.`ins_date_expiry`";
				$arrFieldList[32]= "b.`referral_info`";
				$arrFieldList[33]= "b.`room_id`";
				$arrFieldList[34]= "b.`bed_id`";
				$arrFieldList[35]= "b.`room_rent`";
				$arrFieldList[36]= "c.`room_category`";
				$arrFieldList[37]= "c.`room_number`";
				$arrFieldList[38]= "e.`bed_number`";
				$arrFieldList[39]= "e.`bed_status`";
				$arrFieldList[40]= "b.`remarks`";
				$arrFieldList[41]= "b.`payment_status`";
				$arrFieldList[42]= "b.`cancelled`";
				$arrFieldList[43]= "b.`cancellation_details`";
				$arrFieldList[44]= "b.`user_id`";
                $arrFieldList[45]= "a.`care_of`";
				$arrFieldList[46]= "a.`address`";
				$arrFieldList[47]= "a.`mobile`";
				$arrFieldList[48]= "b.`update_history`";
				$arrFieldList[49]="b.`nursing_charge`";
				$arrFieldList[50]= "b.`maintenance`";
				$arrFieldList[51]= "b.`bill_status`";
				$arrFieldList[52]= "a.`prefix`";
				$arrFieldList[53]= "b.`patient_category`";
				$arrFieldList[54]= "b.`discharge_summ_status`";

				// $arrFieldList[55]="a.`guardian_type`";
				// $arrFieldList[56]= "a.`guardian`";
				// $arrFieldList[57]="a.`house_name`";
			 //    $arrFieldList[58]= "a.`aadhar_no`";
			    //for member category
			    $arrFieldList[59]="b.`member_patient_id`";
			    $arrFieldList[60]="b.`member_id`";
				$arrFieldList[61]= "a.`card_expiry`";
				 $arrFieldList[62]= "b.`bystander_status`";

				
				
				
		}else {
			
				for($k=0;$k<count($selectfield);$k++){
					
						$arrFieldList[]=$selectfield[$k];
					}
			
	   }
	   
	                $arrTables[0] = "`hcare_ip_info` b";
	                $arrTables[1] = "`hcare_op_patient_info` a";       			    
       			    $arrTables[2] = "`hcare_rooms` c";
					$arrTables[3] = "`hcare_room_beds` e";
					$arrTables[4] = "`hcare_emp_info` f";
				    $arrTables[5] = "`hcare_insurance_company` d";
			        
					$joinConditions[1] = "b.`opno` = a.`id`";
					$joinConditions[2] = "b.`room_id` = c.`id`";
					$joinConditions[3] = "b.`bed_id` = e.`id`";
        		    $joinConditions[4] = "b.`doc_id` = f.`id`";
					$joinConditions[5] = "b.`insurance_company` = d.`id`";
					
					
					if(!empty($selectCondition)) {
					for($k=0;$k<count($selectCondition);$k++){
					
						$selectConditions[]=$selectCondition[$k];
					}
				}
				$selectConditions[]="a.`status`=0";
				//$orderbyfield="b.id";
				//$orderby="asc";
				
			   $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit);
				
				$result=$this->dbConnection->executeQuery($query);
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
									
								for($k=0;$k<=47;$k++) {						
								
									$arrList[$i][$k]=$row[$k];
								}
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
			             }
			           }
		                }
			           $arrList[$i][$k++]= $update_history;
					   $arrList[$i][$k++]=$row[49];
					    $arrList[$i][$k++]=$row[50];
						$arrList[$i][$k++]=$row[51];
						$arrList[$i][$k++]=$row[52];
						$arrList[$i][$k++]=$row[53];
						$arrList[$i][$k++]=$this->dbConnection->idToValue('hcare_patient_category','patient_category','id', $row[53]);
						$arrList[$i][$k++]=$row[54];

						$arrList[$i][$k++]=$row[55];
						$arrList[$i][$k++]=$row[56];
						$arrList[$i][$k++]=$row[57];
						$arrList[$i][$k++]=$row[58];
						$arrList[$i][$k++]=$row[59];
						$arrList[$i][$k++]=$row[60];
						$arrList[$i][$k++]=$this->dbConnection->idToValue('hcare_patient_category_ids','patient_id','id', $row[59]);
						$arrList[$i][$k++]=$row[61];
				    // $arrList[$i][$k++]=$row[62];
					


                          $query1 = "select age from `hcare_op_visit_info` where opno='".$row[0]."' and cancelled=0 order by id desc limit 1";

				          $result1=$this->dbConnection->executeQuery($query1);

				           if(mysqli_num_rows($result1)>0){

				           while($row1=mysqli_fetch_assoc($result1)){
						
					       $arrList[$i][$k++]=$row1['age'];
									
				                 }	
				            }

				              if (!empty($arrList[$i][64])) {
            	                               $arrList[$i][4] = $arrList[$i][64];
                                              }
              
                            $new_criteria[0] = "ipno = ".$arrList[$i][13];
			                $new_criteria[1] = "status = 0";

			    $arrList[$i][$k++]=$this->dbConnection->idToValueMultiple('id',$new_criteria,'hcare_ip_labtest_prescribed');

			    									$new_criteria=array();
                            $new_criteria[0] = "id = ".$arrList[$i][13];
			                $new_criteria[1] = "cancelled = 0";

			     $arrList[$i][$k++]=$this->dbConnection->idToValueMultiple('bystander_status',$new_criteria,'hcare_ip_info');
			       $arrList[$i][$k++]=$this->dbConnection->idToValueMultiple('bystander_charge',$new_criteria,'hcare_ip_info');

			       $department_id=$this->dbConnection->idToValue("hcare_emp_job_info","department_id","emp_id",$row[16]);

			       $arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_emp_job_info","qualification","emp_id",$row[16])." ".$this->dbConnection->idToValue("hcare_hospital_department","department","id",$department_id);


			       $arrList[$i][$k++]=$this->dbConnection->idToValue("hcare_room_category","category","id",$row[36]);
			       

						     $i++;
						}
				    
				}
	  // var_dump($arrList);
			return $arrList;
	
	}
        function addIPProcedure($post){
	
		$user_id=$_SESSION['user_id'];
	    $update_history = $user_id."|". date("d-m-Y H:i a");
		
		$field_names=array("id","ipno","procedure_test","amount","date","user","status","update_history");
		$field_data=array("",$post['ipno'],$post['procedure'],$post['test_amount'],date("Y-m-d",strtotime($post['date'])),$_SESSION['user_id'],0,$update_history);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_ip_procedure');
		
		if($result) return true;
		else return false;
	
	}
        function deleteIPProcedure($post){
	
		$id=$post['id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_ip_procedure","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array('status','cancellation_details',"update_history");
		$field_data=array('1',$post['del_details'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_procedure');
		
		if($result) return true;
		else return false;
	}
	function getIPProcedure($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null,$group_by=null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery('hcare_ip_procedure',$selectfield,$wheredata,$orderbyfield,$orderby,$group_by);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		

		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
				    $arrList[$i][1]=$row['procedure_test'];
                                        $arrList[$i][2]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['procedure_test']);
                                        $arrList[$i][3]=$row['amount'];
				        $arrList[$i][4]=date("d-m-Y",strtotime($row['date']));
				        $arrList[$i][5]=$row['status'];
				        $arrList[$i][6]=$row['user'];
                        $arrList[$i][7]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row['user']);
						
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
						 $arrList[$i][8]= $update_history;
						  $arrList[$i][9]=$row['cancellation_details'];
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

        function add_doctor_visit($post){
	
		$user_id=$_SESSION['user_id'];
	        $update_history = $user_id."|". date("d-m-Y H:i a");
		$field_names=array("id","ipno","doctor","visit_charge","date","visit_type","user","status","update_history");
		$field_data=array("",$post['ipno'],$post['doctor'],$post['amount'],date("Y-m-d",strtotime($post['vdate'])),$post['visit_type'],$_SESSION['user_id'],0,$update_history);
		if(!empty($post['hosp_amt'])){
		   $field_names[]="hosp_amt";
		   $field_data[]=$post['hosp_amt'];
		   
		}
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_ip_doctor_visit');
		
		if($result) return true;
		else return false;
	
	}
        function delete_doctor_visit($post){
	
		$id=$post['id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_ip_doctor_visit","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		
		$field_names1=array('status','cancellation_details',"update_history");
		$field_data=array('1',$post['del_details'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_doctor_visit');
		
		if($result) return true;
		else return false;
	}
        function getDoctorVisit($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery('hcare_ip_doctor_visit',$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		

		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
				        $arrList[$i][1]=$row['doctor'];
                                        $arrList[$i][2]="Dr. ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doctor'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doctor']);
                                        $arrList[$i][3]=$row['visit_charge'];
				        $arrList[$i][4]=date("d-m-Y",strtotime($row['date']));
                                        $arrList[$i][5]=$row['visit_type'];
				        $arrList[$i][6]=$row['status'];
				        $arrList[$i][7]=$row['user'];
                                        $arrList[$i][8]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row['user']);
                                        $arrList[$i][9]=$row['cancellation_details'];
										
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
						 $arrList[$i][10]= $update_history;
						 $arrList[$i][11]=$row['ipno'];
						 $opno= $this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ipno']);;
				                 //$prefix= $this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$opno);
				                 $room_id= $this->dbConnection->idToValue("hcare_ip_info","room_id","id",$row['ipno']);
                                                 $roomno= $this->dbConnection->idToValue("hcare_rooms","room_number","id",$room_id);
				
				
				                 $arrList[$i][12]=$this->dbConnection->idToValue("hcare_op_patient_info","first_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","middle_name","id",$opno)." ".$this->dbConnection->idToValue("hcare_op_patient_info","last_name","id",$opno);
                                                 $arrList[$i][13]=$roomno;
						 $arrList[$i][14]=$row['hosp_amt'];
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	public function getIpVisitDrInfo($wheredata){
       
	        $select[0]="distinct(doctor)";
		$wheredata[0]="status=0";
		$query=$this->dbConnection->BuiltQuery('hcare_ip_doctor_visit',$select,$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
        $arrList=array();
	$i=0;
        if(mysqli_num_rows($result) > 0){
			//print_r($result -> fetch_assoc());
			while($row=$result -> fetch_assoc()){
                      
                 
				
				$arrList[$i][0] =$row['doctor'];
				$arrList[$i][1]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$row['doctor'])." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doctor'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doctor']);
                                        
                                $i++;
						
               }
           }
		      
                return $arrList;  

       }
        function add_nursing_notes($post){
	
		$user_id=$_SESSION['user_id'];
	    $update_history = $user_id."|". date("d-m-Y H:i a");
		$field_names=array("id","ipno","nursing_notes","date","user","status","update_history");
		$field_data=array("",$post['ipno'],$post['nursing_notes'],date("Y-m-d",strtotime($post['nrdate'])),$_SESSION['user_id'],0,$update_history);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_ip_nursing_notes');
		
		if($result) return true;
		else return false;
	
	}
        function delete_nursing_notes($post){
	
		$id=$post['id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_ip_nursing_notes","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array('status','cancellation_details',"update_history");
		$field_data=array('1',$post['del_details'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_nursing_notes');
		
		if($result) return true;
		else return false;
	}
        function getIPNursingNotes($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery('hcare_ip_nursing_notes',$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		

		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
				        $arrList[$i][1]=$row['nursing_notes'];                                        
				        $arrList[$i][2]=date("d-m-Y",strtotime($row['date']));                                       
				        $arrList[$i][3]=$row['status'];
				        $arrList[$i][4]=$row['user'];
                                        $arrList[$i][5]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row['user']);
                                        $arrList[$i][6]=$row['cancellation_details'];
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
						 $arrList[$i][7]= $update_history;
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function addNewTemplate($post){


		$field_names=array("id","template_name","status");
		$field_data=array("",strtoupper($post['template_name']),0);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_discharge_templates');

		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;

	}
	function addTemplateItems($temp_id,$sl_no,$field_name,$field_type){


		$field_names=array("id","temp_id","sl_no","field_name","field_type","status");
		$field_data=array("",$temp_id,$sl_no,strtoupper($field_name),$field_type,0);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_discharge_template_items');

		if($result) return true;
		else return false;

	}
	function getTemplates($wheredata){
       
		$query=$this->dbConnection->BuiltQuery('hcare_discharge_templates',"",$wheredata,"id","desc");	
		$result=$this->dbConnection->executeQuery($query);
        $arrList=array();
		$i=0;
        if(mysqli_num_rows($result) > 0){
			//print_r($result -> fetch_assoc());
			while($row=$result -> fetch_assoc()){
                      				
				$arrList[$i][0] =$row['id'];
				$arrList[$i][1] =$row['template_name'];
				$arrList[$i][2] =$row['status'];
				                         
                $i++;
						
               }
           }
		      
                return $arrList;  

     }
	function getTemplateItems($wheredata){
       
		$query=$this->dbConnection->BuiltQuery('hcare_discharge_template_items',"",$wheredata,"sl_no","asc");	
		$result=$this->dbConnection->executeQuery($query);
        $arrList=array();
		$i=0;
        if(mysqli_num_rows($result) > 0){
			//print_r($result -> fetch_assoc());
			while($row=$result -> fetch_assoc()){
                      				
				$arrList[$i][0] =$row['id'];
				$arrList[$i][1] =$row['temp_id'];
				$arrList[$i][2] =$row['sl_no'];
				$arrList[$i][3] =$row['field_name'];
				$arrList[$i][4] =$row['field_type'];
				$arrList[$i][5] =$row['status'];
				                         
                $i++;
						
               }
           }
		      
                return $arrList;  

     }
     function save_discharge_summary($post){

     	$template_name = $this->dbConnection->idToValue('hcare_discharge_templates','template_name','id', $post['template_id']);

		$field_names=array("id","ipno","patient_name","doa","dod","temp_id","temp_name","room_no","follow_up_date","update_history","status");
		$field_data=array("",$post['ip_no'],$post['patient_name'],$post['date_of_admission'],date("Y-m-d",strtotime($post['discharge_date'])),$post['template_id'],$template_name,$post['room_no'],date("Y-m-d",strtotime($post['follow_up_date'])),$post['update_history'],0);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_discharge_summary');

		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;

     }
     function save_discharge_summary_fields($summ_id,$field_id,$field_name=null,$field_order=null){ 

     	if (empty($field_name)) {
     		$field_name = $this->dbConnection->idToValue('hcare_discharge_template_items','field_name','id', $field_id);
     	}

		$field_names=array("id","summ_id","field_name","field_order","status");
		$field_data=array("",$summ_id,$field_name,$field_order,0);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_discharge_summary_fields');

		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;

     }
     function save_discharge_summary_items($summ_id,$summ_field_id,$data){

     	$field_name = $this->dbConnection->idToValue('hcare_discharge_template_items','field_name','id', $field_id);

		$field_names=array("id","summ_id","summ_field_id","field_value","status");
		$field_data=array("",$summ_id,$summ_field_id,$data,0);
		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_discharge_summary_values');

		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;

     }
     function getDischargeInfo($wheredata = null,$limit =null){
	
		$arrList=array();
		// $arrList='';
		$query=$this->dbConnection->BuiltQuery('hcare_discharge_summary',$selectfield,$wheredata,"id","desc",'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['ipno'];
					$arrList[$i][2]=$row['patient_name'];
					$arrList[$i][3]=$row['doa'];
					$arrList[$i][4]=$row['dod'];
					$arrList[$i][5]=$row['temp_name'];
					$arrList[$i][6]=$row['follow_up_date'];
					$arrList[$i][7]=$row['status'];
					$arrList[$i][8]=$this->dbConnection->idToValue("hcare_ip_info","opno","id",$row['ipno']);
					$arrList[$i][9]=$this->dbConnection->idToValue("hcare_op_patient_info","prefix","id",$arrList[$i][8]);
					$arrList[$i][10]=$this->dbConnection->idToValue("hcare_op_patient_info","age","id",$arrList[$i][8]);
					$arrList[$i][11]=$this->dbConnection->idToValue("hcare_op_patient_info","place","id",$arrList[$i][8]);
					$arrList[$i][12]=$this->dbConnection->idToValue("hcare_ip_info","room_id","id",$row['ipno']);
					$arrList[$i][13]=$row['room_no'];
					$arrList[$i][14]=$row['temp_id'];
					$arrList[$i][15]=$this->dbConnection->idToValue("hcare_ip_info","bill_status","id",$row['ipno']);
					$arrList[$i][16]=0;
					$arrList[$i][17]=$this->dbConnection->idToValue("hcare_op_patient_info","gender","id",$arrList[$i][8]);


					$i++;
				       
				
				}
		
			}

		}
		return $arrList;	
	
	}
    function getDischargeInfoFields($wheredata = null){
	
		$arrList=array();

		$query=$this->dbConnection->BuiltQuery('hcare_discharge_summary_fields',"",$wheredata,"field_order + 0","asc");	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['summ_id'];
					$arrList[$i][2]=$row['field_name'];
					$arrList[$i][3]=$row['field_order'];
					$arrList[$i][4]=$row['status'];
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_discharge_template_items","field_type","field_name",$row['field_name']);
				       
				$i++;
				}

		
			}


		}
		return $arrList;	
	
	}
    function getDischargeInfoValues($wheredata = null){
	
		$arrList=array();

		$query=$this->dbConnection->BuiltQuery('hcare_discharge_summary_values',"",$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['summ_id'];
					$arrList[$i][2]=$row['summ_field_id'];
					$arrList[$i][3]=$row['field_value'];
					$arrList[$i][4]=$row['status'];
					$arrList[$i][5]=$this->dbConnection->idToValue("hcare_discharge_summary_fields","field_name","id",$row['summ_field_id']);
				       
					$i++;
				}
		
			}

		}
		return $arrList;	
	
	}
    function remove_field($id){
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_template_items');
		
		if($result) return true;
		else return false;
	}
    function updateTemplateName($id,$template_name){
		
		$field_names1=array('template_name');
		$field_data=array(strtoupper($template_name));
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_templates');
		
		if($result) return true;
		else return false;
	}
    function delete_template($id){
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_templates');
		
		if($result) return true;
		else return false;
	}
    function update_discharge_summary_status($id){
		
		$field_names1=array('discharge_summ_status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_info');
		
		if($result) return true;
		else return false;
	}
    function deleteDischargeSummary($id){
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_summary');
		
		if($result) return true;
		else return false;
	}
    function deleteDischargeInfoFields($id){
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_summary_fields');
		
		if($result) return true;
		else return false;
	}
    function deleteDischargeInfoValues($id){
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_discharge_summary_values');
		
		if($result) return true;
		else return false;
	}
    function save_ip_medicine_prescribed($mid,$medicine_name,$course,$days,$post){
	
		$user_id=$_SESSION['user_id'];
		$update_history = $user_id."|". date("d-m-Y H:i a");
			 
		$field_names=array("id","ipno","brand_id","brand_name","med_course","med_days","qty","date_time","user","status","cancellation_details","update_history","invoice_id");
			
		$field_data=array("",$post['ipno'],$mid,$medicine_name,$course,$days,$post['qty'],date("Y-m-d H:i:s a"),$user_id,0,'',$update_history,'');


		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_ip_medicines_prescribed');
		
		if($result) return true;
		else return false;
	
	}

	function getIpMedicines($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null,$group_by=null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery('hcare_ip_medicines_prescribed',$selectfield,$wheredata,$orderbyfield,$orderby,$group_by);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		

		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

					$arrList[$i][0]=$row['id'];
				    $arrList[$i][1]=$row['ipno'];
				    $arrList[$i][2]=$row['brand_id'];
                    $arrList[$i][3]=$this->dbConnection->idToValue("hcare_pharma_brand","brand","id",$row['brand_id']);
                    $arrList[$i][4]=$row['med_course'];
                    $arrList[$i][5]=$row['med_days'];
				    $arrList[$i][6]=$row['date_time'];
				    $arrList[$i][7]=$row['user'];
                    $arrList[$i][8]= $this->dbConnection->idToValue("hcare_users","user_name","id",$row['user']);
					$arrList[$i][9]=$row['user'];
					$arrList[$i][10]=$row['cancellation_details'];	
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
					$arrList[$i][11]= $update_history;
					$arrList[$i][12]=$row['invoice_id'];
					$arrList[$i][13]=$row['brand_name'];
					$arrList[$i][14]=$row['status'];
					$arrList[$i][15]=$row['qty'];

					$i++;

				}
				
			
			}
		
		}
		return $arrList;	
	
	}
    function deleteMedicines($post){
	
		$id=$post['id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_ip_medicines_prescribed","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array('status','cancellation_details',"update_history");
		$field_data=array('1',$post['del_details'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_medicines_prescribed');
		
		if($result) return true;
		else return false;
	}
	function getDocIpDischarge($ip_id){

		$query = "SELECT sum(total_amount) as amount FROM `hcare_ip_bill` WHERE `ipno` IN ".$ip_id." AND (`bill_status`= 0 or `bill_status`= 2)";

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

	//for labour charges
	function deliveryChargesDetails($ip_no){
		$arrFieldList[0]= "a.`id`";
		$arrFieldList[1]= "b.`test_id`";
		$arrFieldList[2]= "b.`test_amount`";
		$arrFieldList[3]= "b.`discount_type`";
		$arrFieldList[4]= "b.`discount_value`";
		$arrFieldList[5]= "b.`discount`";
		$arrFieldList[6]= "b.`net_amount`";
		$arrFieldList[7]= "c.`procedure_test`";
		$arrFieldList[8]= "c.`gynec_fee`";
		$arrFieldList[9]= "c.`room_charges`";
		$arrFieldList[10]= "a.`cash`";
		$arrFieldList[11]= "a.`credit`";	
					
        $arrTables[0] = "`hcare_bill` a";
        $arrTables[1] = "`hcare_bill_items` b";       			    
		$arrTables[2] = "`hcare_procedure` c";
        
		$joinConditions[1] = "a.`id` = b.`bill_id`";
		$joinConditions[2] = "b.`test_id` = c.`id`";
	
		$selectConditions[]="a.`status`=0";
		$selectConditions[]="a.`ref_no`='".$ip_no."'";
		// $selectConditions[]="b.`category_id`=16";
		// $selectConditions[]="c.`category_id`=16";
		
		$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$oderby,$limit);
		
		$result=$this->dbConnection->executeQuery($query);
				
		if(mysqli_num_rows($result)>0){
				$i=0;
				while($row=mysqli_fetch_array($result)){
					$arrList[$i][0]= $row["id"];
					$arrList[$i][1]= $row["test_id"];
					$arrList[$i][2]= $row["test_amount"];
					$arrList[$i][3]= $row["discount_type"];
					$arrList[$i][4]= $row["discount_value"];
					$arrList[$i][5]= $row["discount"];
					$arrList[$i][6]= $row["net_amount"];
					$arrList[$i][7]= $row["procedure_test"];
					$arrList[$i][8]= $row["gynec_fee"];
					$arrList[$i][9]= $row["room_charges"];	
					$arrList[$i][10]= $row["cash"];
					$arrList[$i][11]= $row["credit"];		
					$i++;
				}
		    
		}
		return $arrList;
	
	}
	function update_bill_status_discharge($post){
	
	  $field_names=array( 'bill_status','discharge_date','discharge_time');
	  $field_data=array(0,'0000-00-00','');
	  
	  $result=$this->dbConnection->update($field_names,$field_data,"id",$post['ip_no'],"hcare_ip_info");
		
		if($result) return $id;
		else return 0;
	
	}	
	function getDischargeInfoCount($wheredata = null){
	
		$arrList='';
		
		
		$query=$this->dbConnection->BuiltQuery('hcare_discharge_summary','',$wheredata,'','');		
		$result=$this->dbConnection->executeQuery($query);
		
		return mysqli_num_rows($result);
	}
  function edit_nursing_notes($post){
	
		$id=$post['nursing_id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_ip_nursing_notes","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array("nursing_notes","update_history");
		$field_data=array($post['nursing_note_data'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_ip_nursing_notes');
		
		if($result) return true;
		else return false;
	}

	function add_own_medicines($drug=null,$dose=null,$route=null,$frequency=null,$post=null){

		$user_id=$_SESSION['user_id'];
		$update_history = $user_id."|". date("d-m-Y H:i a");
			 
		$field_names=array("id","date_time","drug","dose","route","frequency","remarks","update_history","status","ip_no","cancellation_details","cancelled_user");
			
		$field_data=array("",$post['datetime'],$drug,$dose,$route,$frequency,$post['remarks_own_medicine'],$update_history,0,$post['ipno'],"","");


		$result=$this->dbConnection->insert($field_names,$field_data,'hcare_own_medicines');
		
		if($result) return true;
		else return false;

	}

	function getIpOwnMedicines($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null,$group_by=null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery('hcare_own_medicines',$selectfield,$wheredata,$orderbyfield,$orderby,$group_by);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		

		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){

						$arrList[$i][0]=$row['id'];
				    $arrList[$i][1]=$row['ipno'];
				    $arrList[$i][2]=$row['date_time'];
				    $arrList[$i][3]=$row['drug'];
				    $arrList[$i][4]=$row['dose'];
				    $arrList[$i][5]=$row['route'];
				    $arrList[$i][6]=$row['frequency'];
				    $arrList[$i][7]=$row['remarks'];
				    $arrList[$i][8]=$row['status'];
				    $arrList[$i][9]=$row['ip_no'];
				    $arrList[$i][10]=$row['update_history'];
                  
				    
						//split updation history
		                $update_history='';
			
			            if(!empty($row['update_history'])){
			              $history_split=explode("&&",$row['update_history']);
			
			               if(!empty($history_split)){
			
			                  for($m=0;$m<count($history_split);$m++) {
			                         $history_info=explode("|",$history_split[$m]);
									 $user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                         $datetime=$history_info[1];
			                         // echo $datetime;exit;
									 $update_history .=$user_name.":".$datetime."<br>";
			                  }
			                }
		                 }
					$arrList[$i][11]= $update_history;
					

					$i++;

				}
				
			
			}
		
		}
		return $arrList;	
	
	}

	function edit_own_medicines($post){
	
		$id=$post['own_medicine_id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_own_medicines","update_history","id",$id);


	                if(!empty($old_update)){
	             
	                	// echo 11111111;exit;
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	               	// echo 2222222222;exit;
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array("drug","dose","route","frequency","remarks","update_history");
		$field_data=array($post['drug_data'],$post['dose_data'],$post['route_data'],$post['freq_data'],$post['remarks_data'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_own_medicines');
		
		if($result) return true;
		else return false;
	}

 function delete_own_medicines($post){
	
		$id=$post['id'];
		
		//updation history
			$user_id=$_SESSION['user_id'];
			$old_update=$this->dbConnection->idToValue("hcare_own_medicines","update_history","id",$id);
	                if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		          }
		
		$field_names1=array('status','cancellation_details',"update_history","cancelled_user");
		$field_data=array('1',$post['del_details'],$update_history,$user_id);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,'hcare_own_medicines');
		
		if($result) return true;
		else return false;
	}

	
}
?>
