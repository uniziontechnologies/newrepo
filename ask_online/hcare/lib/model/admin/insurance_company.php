<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class InsuranceCompany{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addInsCompany($post){
	
		
		$field_names1=array("id","insurance_company","valid_upto","address","city","state","country","zip_code","phone_no","fax","contact_person","mobile","email","status");
		$field_data=array("",$post['insurance_company'],date("Y-m-d",strtotime($post['valid_upto'])),$post['address'],$post['city'],$post['state'],$post['country'],$post['zipicode'],$post['phone_no'],$post['fax'],$post['contact_person'],$post['contact_no'],$post['email'],0);
		
		$result=$this->dbConnection->insert($field_names1,$field_data,"hcare_insurance_company");
		
		if($result){
		
				$ins_id=$this->dbConnection->mysqli_connect->insert_id;
			
		
				$field_names2=array("id","ins_id","cons_disc_type","cons_disc_value","lab_disc_type","lab_disc_value","test_disc_type","test_disc_value","pharma_disc_type","pharma_disc_value");
				$field_data2=array("",$ins_id,$post['cons_disc_type'],$post['cons_disc_value'],$post['lab_disc_type'],$post['lab_disc_value'],$post['test_disc_type'],$post['test_disc_value'],$post['pharma_disc_type'],$post['pharma_disc_value']);
		
				$result=$this->dbConnection->insert($field_names2,$field_data2,"hcare_insurance_discount_info");
		}
		
		if($result) return true;
		else return false;
	
	}
	function updateInsCompany($post){
	
		$id=$post['id'];		
		
		$field_names1=array("insurance_company","valid_upto","address","city","state","country","zip_code","phone_no","fax","contact_person","mobile","email","status");
		$field_data=array($post['insurance_company'],date("Y-m-d",strtotime($post['valid_upto'])),$post['address'],$post['city'],$post['state'],$post['country'],$post['zipicode'],$post['phone_no'],$post['fax'],$post['contact_person'],$post['contact_no'],$post['email'],0);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_insurance_company");
		
		if($result) {
		
				$field_names2=array("cons_disc_type","cons_disc_value","lab_disc_type","lab_disc_value","test_disc_type","test_disc_value","pharma_disc_type","pharma_disc_value");
				$field_data2=array($post['cons_disc_type'],$post['cons_disc_value'],$post['lab_disc_type'],$post['lab_disc_value'],$post['test_disc_type'],$post['test_disc_value'],$post['pharma_disc_type'],$post['pharma_disc_value']);
				
					$result=$this->dbConnection->update($field_names2,$field_data2,"ins_id",$id,"hcare_insurance_discount_info");
		}	
		
		
		if($result) return true;
		else return false;
	
	}
	function deleteInsCompany($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_insurance_company");
		
		if($result) return true;
		else return false;
	}
	function getInsCompany($is_field =null){
	
				$arrList=array();
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`insurance_company`";
				$arrFieldList[2]= "a.`valid_upto`";
				$arrFieldList[3]= "a.`address`";
				$arrFieldList[4]= "a.`city`";
				$arrFieldList[5]= "a.`state`";
				$arrFieldList[6]= "a.`country`";
				$arrFieldList[7]= "a.`zip_code`";
				$arrFieldList[8]= "a.`phone_no`";
				$arrFieldList[9]= "a.`fax`";				
				$arrFieldList[10]= "a.`contact_person`";
				$arrFieldList[11]= "a.`mobile`";
				$arrFieldList[12]= "a.`email`";				
				$arrFieldList[13]= "a.`status`";
				$arrFieldList[14]= "b.`id`";				
				$arrFieldList[15]= "b.`cons_disc_type`";
				$arrFieldList[16]= "b.`cons_disc_value`";
				$arrFieldList[17]= "b.`lab_disc_type`";
				$arrFieldList[18]= "b.`lab_disc_value`";
				$arrFieldList[19]= "b.`test_disc_type`";
				$arrFieldList[20]= "b.`test_disc_value`";
				$arrFieldList[21]= "b.`pharma_disc_type`";
				$arrFieldList[22]= "b.`pharma_disc_value`";
				
				 $arrTables[0] = "`hcare_insurance_company` a";
       			 $arrTables[1] = "`hcare_insurance_discount_info` b";
				 
				  $joinConditions[1] = "a.`id` = b.`ins_id`";
				  
				  
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
function getInsuranceCompany(){
	
			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("hcare_insurance_company");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['insurance_company'];
					$i++;
				}	
			}
			
			return $arrList;
	}

}


?>