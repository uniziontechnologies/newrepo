<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class PatientCategory{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addPatientCategory($post){
		//add member category		
		$mem_cat = 'NO';
		if(isset($post['member_category'])){
			$mem_cat = 'YES';
		}
		$field_names1=array("id","patient_category","description","member_category","status");
		$field_data=array("",$post['patient_category'],$post['description'],$mem_cat,0);
		
		$result=$this->dbConnection->insert($field_names1,$field_data,"hcare_patient_category");
		
		if($result){
		
				$ins_id=$this->dbConnection->mysqli_connect->insert_id;
			
		
				$field_names2=array("id","patient_category_id","cons_disc_type","cons_disc_value","lab_disc_type","lab_disc_value","test_disc_type","test_disc_value","pharma_disc_type","pharma_disc_value","ip_disc_type","ip_disc_value","regfee_disc_type","regfee_disc_value","cardfee_disc_type","cardfee_disc_value");
				$field_data2=array("",$ins_id,$post['cons_disc_type'],$post['cons_disc_value'],$post['lab_disc_type'],$post['lab_disc_value'],$post['test_disc_type'],$post['test_disc_value'],$post['pharma_disc_type'],$post['pharma_disc_value'],$post['ip_disc_type'],$post['ip_disc_value'],$post['reg_disc_type'],$post['reg_disc_value'],$post['card_disc_type'],$post['card_disc_value']);
		
				$result=$this->dbConnection->insert($field_names2,$field_data2,"hcare_patient_category_discount_info");
		}
		
		if($result) return true;
		else return false;
	
	}
	function updatePatientCategory($post){
	
		$id=$post['id'];		
		//add member category		
		$mem_cat = 'NO';
		if(isset($post['member_category'])){
			$mem_cat = 'YES';
		}
		$field_names1=array("patient_category","description","member_category","status");
		$field_data=array($post['patient_category'],$post['description'],$mem_cat,0);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_patient_category");
		
		if($result) {
		
				$field_names2=array("cons_disc_type","cons_disc_value","lab_disc_type","lab_disc_value","test_disc_type","test_disc_value","pharma_disc_type","pharma_disc_value","ip_disc_type","ip_disc_value","regfee_disc_type","regfee_disc_value","cardfee_disc_type","cardfee_disc_value");
				$field_data2=array($post['cons_disc_type'],$post['cons_disc_value'],$post['lab_disc_type'],$post['lab_disc_value'],$post['test_disc_type'],$post['test_disc_value'],$post['pharma_disc_type'],$post['pharma_disc_value'],$post['ip_disc_type'],$post['ip_disc_value'],$post['reg_disc_type'],$post['reg_disc_value'],$post['card_disc_type'],$post['card_disc_value']);
				
					$result=$this->dbConnection->update($field_names2,$field_data2,"patient_category_id",$id,"hcare_patient_category_discount_info");
		}	
		
		
		if($result) return true;
		else return false;
	
	}
	function deletePatientCategory($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_patient_category");
		
		if($result) return true;
		else return false;
	}
	function getPatientCategoryInfo($is_field =null){
	
				$arrList=array();
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`patient_category`";
				$arrFieldList[2]= "a.`description`";
				$arrFieldList[3]= "a.`status`";
				$arrFieldList[4]= "b.`id`";				
				$arrFieldList[5]= "b.`cons_disc_type`";
				$arrFieldList[6]= "b.`cons_disc_value`";
				$arrFieldList[7]= "b.`lab_disc_type`";
				$arrFieldList[8]= "b.`lab_disc_value`";
				$arrFieldList[9]= "b.`test_disc_type`";
				$arrFieldList[10]= "b.`test_disc_value`";
				$arrFieldList[11]= "b.`pharma_disc_type`";
				$arrFieldList[12]= "b.`pharma_disc_value`";
				//member category
				$arrFieldList[13]= "a.`member_category`";
				//ip discount
				$arrFieldList[14]= "b.`ip_disc_type`";
				$arrFieldList[15]= "b.`ip_disc_value`";
				//regfee cardfee discount
				$arrFieldList[16]= "b.`regfee_disc_type`";
				$arrFieldList[17]= "b.`regfee_disc_value`";
				$arrFieldList[18]= "b.`cardfee_disc_type`";
				$arrFieldList[19]= "b.`cardfee_disc_value`";

				 $arrTables[0] = "`hcare_patient_category` a";
       			 $arrTables[1] = "`hcare_patient_category_discount_info` b";
				 
				  $joinConditions[1] = "a.`id` = b.`patient_category_id`";
				  
				  
				if(!empty($is_field)) {
					for($k=0;$k<count($is_field);$k++){				
						
							$selectConditions[]=$is_field[$k];
						
					}
				}
        	$selectConditions[]="a.`status`=0";	 
				
			$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions);
				
			$result=$this->dbConnection->executeQuery($query);
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_array($result)){
							$j=0;
								for($k=0;$k<count($arrFieldList);$k++) {
								
									$arrList[$i][$j++]=$row[$k];
								
								}
						$i++;
						}
			}
					
		return $arrList;	
	
	}
function getPatientCategory(){
	
			$arrList=array();

            $where[]="status=0";

			$query=$this->dbConnection->BuiltQuery("hcare_patient_category","",$where);	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['patient_category'];
					//for member category
					$arrList[$i][2]=$row['member_category'];
					$i++;
				}	
			}
			
			return $arrList;
	}
//for member category
	function addCategoryMember($post,$action){
		$user_id=$_SESSION['user_id'];
		$update_history = $user_id."|". date("d-m-Y H:i a");
		if($action =='ADD_MEMBER'){
			$patient_ref_id = $post['id'];
		}else{
			$field_names1=array("patient_id", "category_id", "update_history", "status");
			$field_data1=array($post['patient_id'],$post['id'],$update_history,0);
		
			$result=$this->dbConnection->insert($field_names1,$field_data1,"hcare_patient_category_ids");
			if($result){
				$patient_ref_id = $this->dbConnection->mysqli_connect->insert_id;
			}else{
				return false;
			}
		}

		$field_names2=array("first_name", "last_name", "place", "age", "age_type", "gender", "contact", "remark", "patient_ref_id", "update_history", "status");
		$field_data2=array($post['f_name'],$post['l_name'],$post['place'],$post['age'],$post['age_type'],$post['gender'],$post['phone'],$post['remark'],$patient_ref_id,$update_history,0);
		
		$result=$this->dbConnection->insert($field_names2,$field_data2,"hcare_patient_category_members");
		if($result){
			return true;
		}else{
			return false;
		}	

	}

	function CategoryMemberInfo($is_field =null){

		$arrList=array();
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`patient_id`";
				$arrFieldList[2]= "b.`first_name`";
				$arrFieldList[3]= "b.`last_name`";
				$arrFieldList[4]= "b.`place`";				
				$arrFieldList[5]= "b.`age`";
				$arrFieldList[6]= "b.`gender`";
				$arrFieldList[7]= "b.`contact`";
				$arrFieldList[8]= "b.`id` as b_id";
				$arrFieldList[9]= "b.`remark`";
				$arrFieldList[10]= "a.`category_id`";				
				$arrFieldList[11]= "b.`age_type`";
				


				 $arrTables[0] = "`hcare_patient_category_ids` a";
       			 $arrTables[1] = "`hcare_patient_category_members` b";
				 
				  $joinConditions[1] = "a.`id` = b.`patient_ref_id`";
				  
				  
				if(!empty($is_field)) {
					for($k=0;$k<count($is_field);$k++){				
						
							$selectConditions[]=$is_field[$k];
						
					}
				}
        	$selectConditions[]="a.`status`=0";	 
        	$selectConditions[]="b.`status`=0";	 
				
			$query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'','a.`patient_id`','asc');
			
			$result=$this->dbConnection->executeQuery($query);
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_array($result)){
							$j=0;
								for($k=0;$k<count($arrFieldList);$k++) {
								
									$arrList[$i][$j++]=$row[$k];
								
								}
						$i++;
						}
			}				
		return $arrList;	

	}
	function deleteCategoryID($id){

		$user_id=$_SESSION['user_id'];
		$old_update=$this->dbConnection->idToValue("hcare_patient_category_ids","update_history","id",$id);
		if(!empty($old_update)){
			$update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
			$update_history = $user_id."|". date("d-m-Y H:i a");
		}
		
		$field_names1=array('update_history','status');
		$field_data=array($update_history,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_patient_category_ids");
		
		if($result) return true;
		else return false;
	}
	function deleteMemberID($id){

		$user_id=$_SESSION['user_id'];
		$old_update=$this->dbConnection->idToValue("hcare_patient_category_members","update_history","id",$id);
		if(!empty($old_update)){
			$update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
			$update_history = $user_id."|". date("d-m-Y H:i a");
		}
		
		$field_names1=array('update_history','status');
		$field_data=array($update_history,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_patient_category_members");
		
		if($result) return true;
		else return false;
	}
	function updateMember($post,$id){
		$user_id=$_SESSION['user_id'];
		$old_update=$this->dbConnection->idToValue("hcare_patient_category_members","update_history","id",$id);
		if(!empty($old_update)){
			$update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
		}else{
			$update_history = $user_id."|". date("d-m-Y H:i a");
		}
		$field_names1=array("first_name", "last_name", "place", "age", "age_type", "gender", "contact", "remark", "update_history");
		$field_data1=array($post['f_name'],$post['l_name'],$post['place'],$post['age'],$post['age_type'],$post['gender'],$post['phone'],$post['remark'],$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data1,"id",$id,"hcare_patient_category_members");
	
		if($result) return true;
		else return false;
	
	}

}


?>