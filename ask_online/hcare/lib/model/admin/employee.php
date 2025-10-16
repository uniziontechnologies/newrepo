<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/department.php';
class Employee{

	var $dbConnection;
	var $field_personal=array("id","title","first_name","last_name","contact_details","contact_number","email","status");
	var $field_job=array("id","emp_id","department_id","speciality_id","designation_id","ssn","qualification","joining_date");
	var $field_fees=array("id","emp_id","consultation","ip_visit","surgery_charge","emergency_visit","op_validity","ip_billing_dr","ip_billing");
	var $table_personal="hcare_emp_info";
	var $table_job="hcare_emp_job_info";
	var $table_doc_fee="hcare_doc_fee";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addEmployee($post){

		$field_personal=array("",$post['title'],$post['first_name'],$post['last_name'],$post['contact_details'],$post['contact_no'],$post['email'],0);
		$result=$this->dbConnection->insert($this->field_personal,$field_personal,$this->table_personal);
		
		$emp_id=$this->dbConnection->mysqli_connect->insert_id;
		
		if($result) return $emp_id;
		else return 0;
	
	}
	function updateEmployee($post){
	
		$id=$post['id'];		
		
		
		$this->field_personal=array("title","first_name","last_name","contact_details","contact_number","email","status");
		$personal_data=array($post['title'],$post['first_name'],$post['last_name'],$post['contact_details'],$post['contact_no'],$post['email'],0);	
		
		$result=$this->dbConnection->update($this->field_personal,$personal_data,"id",$id,$this->table_personal);
		if($result) return 1;
		else return 0;
	
	}
	function deleteEmployee($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->table_personal);
		
		if($result) return 1;
		else return 0;
	}
	function add_job_info($post){
		
		$emp_id=$post['id'];	
		
		$field_job=array("",$emp_id,$post['dep_id'],$post['spec_id'],$post['des_id'],$post['ssn'],$post['qualification'],$post['joining_date']);
		$result=$this->dbConnection->insert($this->field_job,$field_job,$this->table_job);
		
		if($result) return 1;
		else return 0;
	}
	function update_job_info($post){
		
		$emp_id=$post['id'];  
		$this->field_job=array("department_id","speciality_id","designation_id","ssn","qualification","joining_date");
		$job_data=array($post['dep_id'],$post['spec_id'],$post['des_id'],$post['ssn'],$post['qualification'],$post['joining_date']);	
		
		$result=$this->dbConnection->update($this->field_job,$job_data,"emp_id",$emp_id,$this->table_job);
		
		if($result) return 1;
		else return 0;
	}
	function add_doc_fee($post){
		
		$emp_id=$post['id'];	
		
		$field_fees=array("",$emp_id,$post['consultation'],$post['ip_visit'],$post['surgery'],$post['emergency'],$post['op_validity'],$post['ip_billing_dr'],$post['ip_billing']);
		$result=$this->dbConnection->insert($this->field_fees,$field_fees,$this->table_doc_fee);
		
		if($result) return 1;
		else return 0;
	}
	function update_doc_fee($post){
		
		$emp_id=$post['id'];  
		
		$this->field_fees=array("consultation","ip_visit","surgery_charge","emergency_visit","op_validity","ip_billing_dr","ip_billing");
		$fees_data=array($post['consultation'],$post['ip_visit'],$post['surgery'],$post['emergency'],$post['op_validity'],$post['ip_billing_dr'],$post['ip_billing']);
		
		$result=$this->dbConnection->update($this->field_fees,$fees_data,"emp_id",$emp_id,$this->table_doc_fee);
		
		if($result) return 1;
		else return 0;
	}
	function getEmployee($is_field =null,$dep_id = null,$spec_id = null,$des_id = null ){
	
				$arrList=array();
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`title`";
				$arrFieldList[2]= "a.`first_name`";
				$arrFieldList[3]= "a.`last_name`";
				$arrFieldList[4]= "a.`contact_details`";
				$arrFieldList[5]= "a.`contact_number`";
				$arrFieldList[6]= "a.`email`";
				$arrFieldList[7]= "a.`status`";
				$arrFieldList[8]= "b.`id`";
				$arrFieldList[9]= "b.`department_id`";
				$arrFieldList[10]= "b.`speciality_id`";
				$arrFieldList[11]= "b.`designation_id`";
				$arrFieldList[12]= "b.`ssn`";
				$arrFieldList[13]= "b.`qualification`";
				$arrFieldList[14]= "b.`joining_date`";
				$arrFieldList[15]= "c.`id`";
				$arrFieldList[16]= "c.`consultation`";
				$arrFieldList[17]= "c.`ip_visit`";
				$arrFieldList[18]= "c.`surgery_charge`";
				$arrFieldList[19]= "c.`emergency_visit`";
				$arrFieldList[20]= "c.`op_validity`";
				$arrFieldList[21]= "c.`ip_billing_dr`";
				$arrFieldList[22]= "c.`ip_billing`";
				$arrFieldList[23]= "d.`status`";
				$arrFieldList[24]= "a.`employee_signature`";
				$arrFieldList[25]= "a.`lab_in_charge_status`";
				$arrFieldList[26]= "a.`first_name`";
				$arrFieldList[27]= "a.`last_name`";
				
				  $arrTables[0] = "`hcare_emp_info` a";
       			  $arrTables[1] = "`hcare_emp_job_info` b";
       			  $arrTables[2] = "`hcare_doc_fee` c";
       			  $arrTables[3] = "`hcare_users` d";
				  
				  $joinConditions[1] = "a.`id` = b.`emp_id`";
        		  $joinConditions[2] = "a.`id` = c.`emp_id`";
        		  $joinConditions[3] = "a.`id` = d.`employee_id`";
       			
				if(!empty($dep_id)) {				
					$selectConditions[]="b.`department_id`=$dep_id";
				}
				if(!empty($spec_id)) {				
					$selectConditions[]="b.`speciality_id`=$spec_id";
				}
				if(!empty($des_id)) {				
					$selectConditions[]="b.`designation_id`=$des_id";
				}
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
								
									if($arrFieldList[$k]== "b.`department_id`"){
									
										$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_hospital_department","department","id",$row[$k]);
										
									}else if($arrFieldList[$k]== "b.`speciality_id`"){
									
										$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_speciality","speciality","id",$row[$k]);
										
									}else if($arrFieldList[$k]== "b.`designation_id`"){
									
										$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_job_designation","designation","id",$row[$k]);
									}
								
									$arrList[$i][$j++]=$row[$k];
								}
								
								$i++;
						
						}
				
				}
				
		return $arrList;		
				
	}
	function checkJobInfo($wheredata){
	
	$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->table_job,'',$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result)>0){
			
			return 1;
			
		}else{
			return 0;
	    }
	
	
	}
	function checkFeeInfo($wheredata){
	
	$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->table_doc_fee,'',$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result)>0){
			
			return 1;
			
		}else{
			return 0;
	    }
	
	
	}
	/*function getEmployee($selectfield = null,$wherefield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		$query=$this->dbConnection->BuiltQuery($this->table_personal,$selectfield,$wherefield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					$j=0;
					$emp_id=$row[$this->field_personal[0]];
					$title=$row[$this->field_personal[1]];
					$whereEmp[0]="emp_id";
					$whereEmpid[0]=$emp_id;
					
					
					//Employee Personal Info
					
					for($k=0;$k<count($this->field_personal);$k++) {
						
						$arrList[$i][$j++]=$row[$this->field_personal[$k]];
						
					}
					
					//Employee Job Info
					
						$query2=$this->dbConnection->BuiltQuery($this->table_job,'',$whereEmp,$whereEmpid);
						$result2=$this->dbConnection->executeQuery($query2);
						$jobInfo=mysql_fetch_assoc($result2);
						
						for($k=0;$k<count($this->field_job);$k++) {
						
							if($this->field_job[$k] == 'department_id'){
							
									$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_hospital_department","department","id",$jobInfo[$this->field_job[$k]]);
									
							}else if($this->field_job[$k] == 'speciality_id'){
							
									$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_speciality","speciality","id",$jobInfo[$this->field_job[$k]]);
									
							}if($this->field_job[$k] == 'designation_id'){
							
									$arrList[$i][$j++]=$this->dbConnection->idToValue("hcare_job_designation","designation","id",$jobInfo[$this->field_job[$k]]);
									
							}
							if($this->field_job[$k] != 'emp_id'){
								$arrList[$i][$j++]=$jobInfo[$this->field_job[$k]];
							}
						
						}
					
					//If doctor Doc fee Info
					
						
						
						if($title =="Dr"){
						
							$query3=$this->dbConnection->BuiltQuery($this->table_doc_fee,'',$whereEmp,$whereEmpid);
							$result3=$this->dbConnection->executeQuery($query3);
							$feeInfo=mysql_fetch_assoc($result3);
						
								for($k=0;$k<count($this->field_fees);$k++) {
						
										if($this->field_fees[$k] != 'emp_id'){
											$arrList[$i][$j++]=$feeInfo[$this->field_fees[$k]];
										}
						
								}
						
						}
						$i++;
				}
//				0->id
//				1->Title
//				2->first name
//				3->last name
//				4->contact details
//				5->contact no				
//				6->email
//				7->status
//				8->id(job)
//				9->department_name
//				10->"department_id",
//				11->speciality_name
//				12->"speciality_id",
//				13->designation
//				14->"designation_id",
//				15->"ssn"
//				16->,"qualification"
//				17->,"joiningdate"
//              18->id(doc fee)
//				19->"consultation"
//				20->,"ip_visit",
//				21->"surgery_charge",
//				22->"emergency_visit")
				
			
			}
		
		}
		return $arrList;	
	
	}
	function getEmpJobInfo($dep_id){
	
			
	
	}*/
	

}


?>
