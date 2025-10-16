<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class Speciality{

	var $dbConnection;
	var $field_names=array("id","department_id","speciality","status");
	var $tablename="hcare_speciality";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addSpeciality($post){
	
		
		
		$field_data=array("",$post['dep_id'],$post['spec_name'],0);
		$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateSpeciality($post){
	
		$id=$post['id'];		
		
		
		$this->field_names=array("department_id","speciality","status");
		$field_data=array($post['dep_id'],$post['spec_name'],0);
	
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function deleteSpeciality($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	function getSpeciality($selectfield = null,$wheredata = null,$likefield = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					$j=0;
					for($k=0;$k<count($this->field_names);$k++) {
					
						if($this->field_names[$k] == "department_id"){
							
							$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_hospital_department","department","id",$row[$this->field_names[$k]]);
						}
						
						$arrList[$i][$j++]=$row[$this->field_names[$k]];
						
					}
						$i++;
				}
				//0->id
				//1->Department name
				//2->Department id
				//4->Speciality								
				//5->status
			
			}
		
		}
		return $arrList;	
	
	}
	

}


?>
