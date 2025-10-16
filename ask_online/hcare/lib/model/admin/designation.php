<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
class Designation{

	var $dbConnection;
	var $field_names=array("id","designation","description","status");
	var $tablename="hcare_job_designation";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addDesignation($post){
	
		
		
		$field_data=array("",$post['des_name'],$post['description'],0);
		$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateDesignation($post){
	
		$id=$post['id'];		
		
		
		$this->field_names=array("designation","description","status");
		$field_data=array($post['des_name'],$post['description'],0);
	
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function deleteDesignation($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	function getDesignation($selectfield = null,$wheredata = null,$likefield = null,$orderbyfield = null,$orderby = null){
	
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
						
						$arrList[$i][$j++]=$row[$this->field_names[$k]];
						
					}
						$i++;
				}
				//0->id
				//1->Designation name
				//2->Description								
				//3->status
			
			}
		
		}
		return $arrList;	
	
	}
	function checkDesignation($post){
	
		$id=$post['id'];
		$emp_obj = new Employee();
		
		
		$empInfo=$emp_obj->getEmployee('','','',$id);
		
		
		
		
		if(!empty($empInfo)){
			return false;
		}else return true;
	
	
	}
	

}


?>
