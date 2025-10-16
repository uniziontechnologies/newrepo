<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';

class HospitalInfo{

	var $dbConnection;
	var $field_names=array("id","hospital_name","address","city","state","country","zip_code","phone","fax","email","website","logo","currency","online_id","lock_page");
	var $tablename="hcare_hospital_info";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	
	function updateHospitalInfo($post){
	
		$id=$post['id'];
		
			$this->field_names=array("hospital_name","address","city","state","country","zip_code","phone","fax","email","website","logo","currency");
			$field_data=array($post['hospital_name'],$post['address'],$post['city'],$post['state'],$post['country'],$post['zipicode'],$post['phone_no'],$post['fax'],$post['email'],$post['website'],$post['logo'],$post['currency']);
		
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	
	function getHospitalInfo(){
	
		$arrList=array();
		$query=$this->dbConnection->BuiltQuery($this->tablename);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				$row=$result -> fetch_assoc();
					$j=0;
					for($k=0;$k<count($this->field_names);$k++) {

						 $arrList[$k]=$row[$this->field_names[$k]];
						
					}
						
								
			
			}
		
		}
		return $arrList;	
	
	}
	


}


?>