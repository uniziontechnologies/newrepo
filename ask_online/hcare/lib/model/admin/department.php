<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/speciality.php';
class Department{

	var $dbConnection;
	var $field_names=array("id","department","department_in_charge","phone","status");
	var $tablename="hcare_hospital_department";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addDepartment($post){
	
		
		
		$field_data=array("",$post['dep_name'],$post['dep_in_charge_ID'],$post['phone'],0);
		$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateDepartment($post){
	
		$id=$post['id'];		
		
		
		$this->field_names=array("department","department_in_charge","phone","status");
		$field_data=array($post['dep_name'],$post['dep_in_charge_ID'],$post['phone'],0);
	
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function deleteDepartment($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	function getDepartment($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
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
						if($this->field_names[$k]=="department_in_charge"){
							
							$empname=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row[$this->field_names[$k]])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row[$this->field_names[$k]]);

                            $title=$this->dbConnection->idToValue("hcare_emp_info","title","id",$row[$this->field_names[$k]]);
							$arrList[$i][$j++]=($title!= "" )?$title.".".$empname:$empname;

						}
						$arrList[$i][$j++]=$row[$this->field_names[$k]];
						
					}
						$i++;
				}
				//0->id
				//1->department name
				//2->employee_name
				//3->department in charge_id
				//4->phone				
				//5->status
			
			}
		
		}
		return $arrList;	
	
	}
	function checkDepartment($post){
	
		$id=$post['id'];
		$emp_obj = new Employee();
		$spec_obj = new Speciality();
		
		$empInfo=$emp_obj->getEmployee('',$id);
		
		$wheredata[0]="department_id ='".$id."'";
	
		$specialityInfo=$spec_obj->getSpeciality('',$wheredata);
		
		
		if(!empty($empInfo)){
			return false;
		}else if(!empty($specialityInfo)){
			return false;
		}else return true;
	
	
	}
	

}


?>
