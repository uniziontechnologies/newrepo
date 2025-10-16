<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class Health_package{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addHealthPackage($post){
	

		 $fields=array("id","package_name","amount","dr_amount","description","status","doctor");
		 $field_data=array("",$post['package'],$post['amount'],$post['dr_amount'],$post['description'],0,$post['doctor']);
		
		
		$result=$this->dbConnection->insert($fields,$field_data,"hcare_healthcheckup_package");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;
	
	}
	function updateHealthPackage($post){
	
		$id=$post['id'];		
		
		 $fields=array("package_name","amount","dr_amount","description","status","doctor");
		 $field_data=array($post['package'],$post['amount'],$post['dr_amount'],$post['description'],0,$post['doctor']);
		

		$result=$this->dbConnection->update($fields,$field_data,"id",$id,"hcare_healthcheckup_package");
		
		if($result) return true;
		else return false;
	
	}
	function addPackageElements($test_id,$test_type,$package_id){
	
		
		 $fields=array("id","package_id","test_id","test_type","status");
		 $field_data=array("",$package_id,$test_id,$test_type,0);
		
		
		$result=$this->dbConnection->insert($fields,$field_data,"hcare_healthpackage_elements");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;
	
	}
	function deleteHealthPackage($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_healthcheckup_package");
		
		if($result) return true;
		else return false;
	}
	function deleteHPackageElements($post){
	
		$package_id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"package_id",$package_id,"hcare_healthpackage_elements");
		
		if($result) return true;
		else return false;
	}
	function getHealthPackage($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_healthcheckup_package",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['package_name'];
						$arrList[$i][2]=$row['amount'];
						$arrList[$i][3]=$row['description'];
						$arrList[$i][4]=$row['dr_amount'];
						$arrList[$i][5]=$row['status'];
						$arrList[$i][6]=$row['doctor'];
						
						
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function getHealthPackageElements($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_healthpackage_elements",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['test_id'];
						$arrList[$i][2]=$row['test_type'];
						
					if($row['test_type'] == "LT"){
					
					      $arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
					      $arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","price","id",$row['test_id']);
					       $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row['test_id']);
					      
					}else if($row['test_type'] == "LE"){
					
					      $arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
					      $arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","price","id",$row['test_id']);
					       $arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_element","category","id",$row['test_id']);
					      
					}else{
					
					      $arrList[$i][3]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
					      $arrList[$i][4]=$this->dbConnection->idToValue("hcare_procedure","total","id",$row['test_id']);
					       $arrList[$i][5]=$this->dbConnection->idToValue("hcare_procedure","category_id","id",$row['test_id']);
					      
					}
						
						$arrList[$i][6]=$row['status'];
						
						
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function getPackageElementId($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_healthpackage_elements",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					
						
						
						$arrList[$i][0]=$row['test_id'];
						$arrList[$i][1]=$row['test_type'];

						if ($row['test_type']=="LE") {
							$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['test_id']);
						}
						else if ($row['test_type']=="LT") {
							$arrList[$i][2]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row['test_id']);
						}
						else if ($row['test_type']=="P") {
							$arrList[$i][2]=$this->dbConnection->idToValue("hcare_procedure","procedure_test","id",$row['test_id']);
						}

						$arrList[$i][3]=$row['order_no'];
						$arrList[$i][4]=$row['id'];
						
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function healthCheckupPackageOrderUpdate($id,$test_id,$order_no){
		
		
		 $fields=array("order_no");
		 $field_data=array($order_no);
		

		$result=$this->dbConnection->update($fields,$field_data,"id",$id,"hcare_healthpackage_elements");
		
		if($result) return true;
		else return false;
	
	}

	
}


?>
