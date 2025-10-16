<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/speciality.php';
class Category{

	var $dbConnection;
	var $field_names=array("id","category","description","status");
	var $tablename="hcare_procedure_category";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addCategory($post){
	
		
		
		$field_data=array("",$post['category'],$post['description'],0);
		$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateCategory($post){
	
		$id=$post['id'];		
		
		
		$this->field_names=array("category","description");
		$field_data=array($post['category'],$post['description']);
	
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function deleteCategory($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	function getCategory($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="(status = 0 or status=2)";
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
				
			
			}
		
		}
		return $arrList;	
	
	}
	function checkCategory($post){
	
		$id=$post['id'];
		
		$proc_obj = new Procedure();
		
				
		$wheredata[0]="category_id ='".$id."'";
		$wheredata[1]="status = 0";
	
		$procedureInfo=$proc_obj->getProcedure('',$wheredata);
		
		
		if(!empty($procedureInfo)){
			return false;
		}else return true;
	
	
	}
	

}


?>
