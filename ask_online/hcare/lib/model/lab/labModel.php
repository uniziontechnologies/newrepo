<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/speciality.php';
class LabModel{

	var $dbConnection;
	
	var $tablename="hcare_lab_element";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addElements($post){
	
		if(isset($post['outside'])) $outside=1;
		else $outside=0;
		
		$field_names=array("id","test_name","category","normal1","normal2","normal3","normal4","normal5","normal6","unit","material","price","outside");
		$field_data=array("",$post['element_name'],$post['category'],$post['normal1'],$post['normal2'],$post['normal3'],$post['normal4'],$post['normal5'],$post['normal6'],$post['unit'],$post['material_cost'],$post['price'],$outside);
		$result=$this->dbConnection->insert($field_names,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateElements($post){
	
		$id=$post['id'];

        if(isset($post['outside'])) $outside=1;
		else $outside=0;		
		
		$field_names=array("test_name","category","normal1","normal2","normal3","normal4","normal5","normal6","unit","material","price","outside");
		$field_data=array($post['element_name'],$post['category'],$post['normal1'],$post['normal2'],$post['normal3'],$post['normal4'],$post['normal5'],$post['normal6'],$post['unit'],$post['material_cost'],$post['price'],$outside);
		
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	
	function deleteElements($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('deleted_date','status');
		$field_data=array($deleted_date,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	
	function getTestElementCount($wheredata = null){
		$selectfield='';
		$orderbyfield='';
		$orderby='';
	
		$arrList=array();
		
		if(empty($wheredata)){
				//$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		
		return mysqli_num_rows($result);
	}
	function getTestElement($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null,$limit=null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				//$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wheredata,$orderbyfield,$orderby,'',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					 $arrList[$i][0]=$row['id'];
					 $arrList[$i][1]=$row['test_name'];
					 $arrList[$i][2]=$row['category'];
					 $arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_category","category","id",$row['category']);
					 $arrList[$i][4]=$row['normal1'];
					 $arrList[$i][5]=$row['normal2'];
					 $arrList[$i][6]=$row['normal3'];
					 $arrList[$i][7]=$row['normal4'];
					 $arrList[$i][8]=$row['normal5'];
					 $arrList[$i][9]=$row['normal6'];
					 $arrList[$i][10]=$row['unit'];
					 $arrList[$i][11]=$row['material'];
					 $arrList[$i][12]=$row['price'];
					 $arrList[$i][13]=$row['outside'];
					$i++;
				}
				
			
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
	function addCategory($post){
	
		$field_names=array("id","category");
		$field_data=array("",$post['category_name']);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_category");
		
		if($result) return true;
		else return false;
	
	}
	function updateCategory($post){
	
		$id=$post['id'];

        if(isset($post['outside'])) $outside=1;
		else $outside=0;		
		
		$field_names=array("category");
		$field_data=array($post['category_name']);
		
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_lab_category");
		
		if($result) return true;
		else return false;
	
	}
	
	function deleteCategory($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('deleted_date','status');
		$field_data=array($deleted_date,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_lab_category");
		
		if($result) return true;
		else return false;
	}
	
	function getCategoryCount($wheredata){
	
			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("hcare_lab_category",'',$wheredata);	
			$result=$this->dbConnection->executeQuery($query);
			
			return mysqli_num_rows($result);
	}
	function getCategory($wheredata=null,$orderbyfield = null,$orderby = null,$limit=null){
	
			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("hcare_lab_category",'',$wheredata,$orderbyfield,$orderby,'',$limit);	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['category'];
					$arrList[$i][2]=$row['status'];
					$i++;
				}	
			}
			
			return $arrList;
	}
	function addGroupTest($post){
	
		if(isset($post['outside'])) $outside=1;
		else $outside=0;
		
		$field_names=array("id","test_name","category","material","price","outside");
		$field_data=array("",$post['test_name'],$post['category'],$post['material_cost'],$post['price'],$outside);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_test");
		
		if($result) return array('true',$this->dbConnection->mysqli_connect->insert_id);
		else return array('false',0);
	
	}
	function updateGroupTest($post){
	
		$id=$post['id'];

        if(isset($post['outside'])) $outside=1;
		else $outside=0;		
		
		$field_names=array("test_name","category","material","price","outside");
		$field_data=array($post['test_name'],$post['category'],$post['material_cost'],$post['price'],$outside);
		
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_lab_test");
		
		if($result) return array('true',$id);
		else return array('false',0);
	
	}
	function addGroupTestElement($tid,$eid){
		
		$field_names=array("id","tid","eid","sid");
		$field_data=array("",$tid,$eid,0);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_test_element");
		
		if($result) return true;
		else return false;
	}
	function addTestSubCategory($tid,$sid){
		
		$field_names=array("id","tid","sid","eid");
		$field_data=array("",$tid,$sid,0);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_test_element");
		
		if($result) return true;
		else return false;
	}
	function deleteGroupTest($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('deleted_date','status');
		$field_data=array($deleted_date,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_lab_test");
		
		if($result) return true;
		else return false;
	}
	function deleteTestElement($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_lab_test_element");
		
		if($result) return true;
		else return false;
	}
	
	function getGroupTestCount($wheredata){
	
	         $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		
	  return mysqli_num_rows($result);
	
	}
	
	function getGroupTest($wheredata=null,$orderbyfield = null,$orderby = null,$limit=null){
	
	         $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata,$orderbyfield,$orderby,'',$limit);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['test_name'];
			$arrList[$i][2]=$row['price'];
			$arrList[$i][3]=$row['category'];
			$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_category","category","id",$row['category']);
			$arrList[$i][5]=$row['material'];
			$arrList[$i][6]=$row['outside'];
			$i++;
		   }	
		}
			
	  return $arrList;
	
	}
	
	
    function getGroupTestElement($whereCondn=null,$orderbyfield = null,$orderby = null,$limit=null){
		
		 $arrList=array();
	      $query=$this->dbConnection->BuiltQuery("hcare_lab_test_element",'',$whereCondn,$orderbyfield,$orderby,'',$limit);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['tid'];
			$arrList[$i][2]=$row['eid'];
			$arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['eid']);
			$arrList[$i][4]=$row['sid'];
			$arrList[$i][5]=$this->dbConnection->idToValue("hcare_lab_subcategory","subcategory","id",$row['sid']);
			
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	
	function getTestElemID($whereCondn=null){
		
		 $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_test_element",'',$whereCondn);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i]=$row['eid'];
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	function getTestElemSubcatID($whereCondn=null){
		
		 $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_test_element",'',$whereCondn);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i]=$row['sid'];
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	
	function deleteGroupTestElement($where){
		 
		 $result=$this->dbConnection->deletePermenantly($where,'hcare_lab_test_element');
		
	}
	function getSubCategoryCount($wheredata=null){
	
	     $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_subcategory",'',$wheredata);		
		 $result=$this->dbConnection->executeQuery($query);
		
	  return mysqli_num_rows($result);
	
	}
	
	function addSubCategory($post){
	
		if(isset($post['outside'])) $outside=1;
		else $outside=0;
		
		$field_names=array("id","subcategory","price");
		$field_data=array("",$post['category_name'],$post['price']);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_subcategory");
		
		if($result) return array('true',$this->dbConnection->mysqli_connect->insert_id);
		else return array('false',0);
	
	}
	function updateSubCategory($post){
	
		$id=$post['id'];
	
		
		$field_names=array("subcategory","price");
		$field_data=array($post['category_name'],$post['price']);
		
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_lab_subcategory");
		
		if($result) return array('true',$id);
		else return array('false',0);
	
	}
	function addsubCatElement($sid,$eid){
		
		$field_names=array("id","sid","eid");
		$field_data=array("",$sid,$eid);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_subcategory_element");
		
		if($result) return true;
		else return false;
	}
	function deleteSubCategory($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('deleted_date','status');
		$field_data=array($deleted_date,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_lab_subcategory");
		
		if($result) return true;
		else return false;
	}
	function deleteSubCatElement($post){
		
		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];
		
		$deleted_date=date("Y-m-d H:i");
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_lab_subcategory_element");
		
		if($result) return true;
		else return false;
	}
	function deleteSubCategoryElement($where){
		 
		 $result=$this->dbConnection->deletePermenantly($where,'hcare_lab_subcategory_element');
		
	}
	function getSubCategory($wheredata=null,$orderbyfield = null,$orderby = null,$limit=null){
	
	         $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_subcategory",'',$wheredata,$orderbyfield,$orderby,'',$limit);		
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['subcategory'];
			$arrList[$i][2]=$row['price'];
			
			$i++;
		   }	
		}
			
	  return $arrList;
	
	}
	function getSubGroupElement($whereCondn=null,$orderbyfield = null,$orderby = null){
		
		 $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_subcategory_element",'',$whereCondn,$orderbyfield,$orderby);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['sid'];
			$arrList[$i][2]=$row['eid'];
			$arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['eid']);
			
			
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	
	function getSubgpElemID($whereCondn=null){
		
		 $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_subcategory_element",'',$whereCondn);	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i]=$row['eid'];
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	function save_lab_result($resultInfo){
		
		date_default_timezone_set('Asia/Kolkata');
		$result_date=date("Y-m-d H:i");
		
	    $result_entered_by = $resultInfo[3];
		$result_verified_by = $resultInfo[2]."|". date("d-m-Y H:i a");
	
		$field_names=array("id","billno","result_date","result_verified_by","result_entered_by");
		$field_data=array("",$resultInfo[0],$resultInfo[1],$result_verified_by,$result_entered_by);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_result");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return false;
	
	}
	function update_lab_result($resultInfo){
	
		
		
		date_default_timezone_set('Asia/Kolkata');
	 //updation history
	 
	       $old_update=$this->dbConnection->idToValue("hcare_lab_result","result_verified_by","id",$resultInfo[0]);
			if(!empty($old_update)){
	   
	                       $result_verified_by = $resultInfo[1]."|".$old_update;
	   
	               }else{
	                     $result_verified_by = $resultInfo[1]."|". date("d-m-Y H:i a");
		       }
			   
			$old_update=$this->dbConnection->idToValue("hcare_lab_result","result_entered_by","id",$resultInfo[0]);
			if(!empty($old_update)){
	   
	                       $result_entered_by = $resultInfo[2]."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $result_entered_by = $resultInfo[2]."|". date("d-m-Y H:i a");
		       }
	
		
		$field_names=array("result_verified_by","result_entered_by");
		$field_data=array($result_verified_by,$result_entered_by);
		
	   // print_r($field_data);
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$resultInfo[0],"hcare_lab_result");
		
		if($result) return array('true',$id);
		else return array('false',0);
	
	}
	function save_result_entry($resultInfo,$description=null){
		$description_data = str_replace('"', "'", $description);
		
		
		$field_names=array("id","bill_no","test_name","result","normal","tid","catid","type","unit","result_id","test_range","description");
		$field_data=array("",$resultInfo[0],$resultInfo[1],str_replace('"', '\"', $resultInfo[2]),$resultInfo[3],$resultInfo[4],$resultInfo[5],$resultInfo[6],$resultInfo[7],$resultInfo[8],$resultInfo[9],$description_data);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_lab_result_entry");
		
		if($result) return true;
		else return false;
	
	}
	
	function getLabresultEntryById($wheredata=null,$orderbyfield = null,$orderby = null){
		 
		 $arrList=array();
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_result_entry",'',$wheredata,$orderbyfield,$orderby);		
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['bill_no'];
			$arrList[$i][2]=$row['tid'];
			$arrList[$i][3]=$row['test_name'];
			$arrList[$i][4]=$row['result'];
			$arrList[$i][5]=$row['normal'];
			$arrList[$i][6]=$row['unit'];
			$arrList[$i][7]=$row['type'];
			$arrList[$i][8]=$row['catid'];
			$arrList[$i][9]=$row['nrml'];
			$arrList[$i][10]=$row['result_id'];
			$arrList[$i][11]=$this->dbConnection->idToValue("hcare_lab_category","category","id",$row['catid']);
			$result_entered_by_user_id=$this->dbConnection->idToValue("hcare_lab_result","result_entered_by","id",$row['result_id']);

			$result_entered_by=$result_entered_by_user_id;
									  $employee_id_entered_by='';

                                     if(!empty($result_entered_by)){
                                         $history_split=explode("&&",$result_entered_by);
    
                                     if(!empty($history_split)){

                                        for($m=0;$m<count($history_split);$m++) {
                                              $history_info=explode("|",$history_split[$m]);
                                              // var_dump($history_info);exit();
                                              $employee_id_entered_by=$this->dbConnection->idToValue('hcare_users','employee_id','id', $history_info[0]);
                                          
                                         }
                                        }
                                        }
                $arrList[$i][12]= $employee_id_entered_by;
                $result_verified_by=$this->dbConnection->idToValue("hcare_lab_result","result_verified_by","id",$row['result_id']);
                    $verified_by_emp_id ="";
					if(!empty($result_verified_by)){
						$history_split=explode("|",$result_verified_by);

						if(!empty($history_split)){
							// var_dump($history_split);exit();

							for($m=0;$m<count($history_split)-1;$m++) {
								$verified_by_emp_id=$this->dbConnection->idToValue('hcare_users','employee_id','id', $history_split[0]);

								// $verified_by .=$user_name."<br>";
							}
						}
					}
					$arrList[$i][13]= $verified_by_emp_id; 
					$arrList[$i][14]=$this->dbConnection->idToValue("hcare_emp_info","employee_signature","id",$employee_id_entered_by);
					$arrList[$i][15]=$this->dbConnection->idToValue("hcare_emp_info","employee_signature","id",$verified_by_emp_id);
					$arrList[$i][16]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$employee_id_entered_by)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$employee_id_entered_by);
					$arrList[$i][17]=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$verified_by_emp_id)." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$verified_by_emp_id);
					$arrList[$i][18]=$row['test_range'];
					$arrList[$i][19]=$row['description'];
			
			
			$i++;
		   }	
		}
			
	  return $arrList;
		
	}
	function getLabresultInfo($billno){
		$result_id='';
		
		 $wheredata[0]="billno=".$billno;
	     $query=$this->dbConnection->BuiltQuery("hcare_lab_result",'',$wheredata,"id","desc");		
		 $result=$this->dbConnection->executeQuery($query);
		$i=0;
		$arrList=array();
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['billno'];
			$arrList[$i][2]=$row['result_date'];
			$arrList[$i][3]=$row['result_verified_by'];
			$arrList[$i][4]=$this->dbConnection->idToValue("hcare_users","user_name","id",$row['result_verified_by']);
			$arrList[$i][5]=$row['result_entered_by'];
			$arrList[$i][6]=$this->dbConnection->idToValue("hcare_users","user_name","id",$row['result_entered_by']);

			
													
			
			
			$i++;
		   }	
		}
			
	  return $arrList;
	}
	
	function delete_existing_result($where){
		 
		 $result=$this->dbConnection->deletePermenantly($where,'hcare_lab_result_entry');
		
	}
	function distinct_result_category($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit = null){
     
         $arrList=array();
         $i=0;

		 $arrFieldList[]="distinct b.`catid`";
      
             $arrTables[0] = "`hcare_bill` a";
	         $arrTables[1] = "`hcare_lab_result_entry` b";       			    
			        
					$joinConditions[1] = "a.`id` = b.`bill_no`";
			        $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectCondition,'',$orderbyfield,$oderby,$limit);
			
				$result=$this->dbConnection->executeQuery($query);
				
			if(mysqli_num_rows($result)>0){
              
                while($row=mysqli_fetch_array($result)){
				
				   $arrList[$i]=$row['catid'];					
				   $i++;				
				}

			}
		return $arrList;			
	}
	function distinct_lab_result_date($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit = null){
     
         $arrList=array();
         $i=0;

		 $arrFieldList[]="distinct (DATE(b.`result_date`)) as result_date";
      
             $arrTables[0] = "`hcare_bill` a";
	         $arrTables[1] = "`hcare_lab_result` b";       			    
			        
					$joinConditions[1] = "a.`id` = b.`billno`";
			        $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectCondition,'',$orderbyfield,$oderby,$limit);
			
				$result=$this->dbConnection->executeQuery($query);
				
			if(mysqli_num_rows($result)>0){
              
                while($row=mysqli_fetch_array($result)){
				
				  if(!empty($row['result_date'])){
				   $arrList[$i]=date("Y-m-d",strtotime($row['result_date']));					
				   $i++;
				  }				   
				}

			}
		return $arrList;			
	}
	
	function distinct_result_elements($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit = null){

         $arrList=array();
         $i=0;

		 $arrFieldList[]="distinct b.`tid`,b.`catid`";
      
             $arrTables[0] = "`hcare_bill` a";
	         $arrTables[1] = "`hcare_lab_result_entry` b";       			    
			        
		     $joinConditions[1] = "a.`id` = b.`bill_no`";
			 $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectCondition,'',$orderbyfield,$oderby,$limit);
			
				$result=$this->dbConnection->executeQuery($query);
				
			if(mysqli_num_rows($result)>0){
              
                while($row=mysqli_fetch_array($result)){
				
				   $arrList[$i][0]=$row['tid'];
				   $arrList[$i][1]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row['tid']);
                   $arrList[$i][2]=$row['catid'];
				   $arrList[$i][3]=$this->dbConnection->idToValue("hcare_lab_category","category","id",$row['catid']);				   
				   $i++;				
				}
           
			}
		return $arrList;			
	}
	
	function distinct_lab_result($selectfield = null,$selectCondition = null ,$orderbyfield = null,$oderby = null,$limit = null){
     
         $arrList=array();
         $i=0;

		 $arrFieldList[]="c.`result`";
      
             $arrTables[0] = "`hcare_bill` a";
			 $arrTables[1] = "`hcare_lab_result` b";
	         $arrTables[2] = "`hcare_lab_result_entry` c";       			    
			        
					$joinConditions[1] = "a.`id` = b.`billno`";
					$joinConditions[2] = "b.`id` = c.`result_id`";
			        $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectCondition,'',$orderbyfield,$oderby,$limit);
			
				$result=$this->dbConnection->executeQuery($query);
				
			if(mysqli_num_rows($result)>0){
              
               // while($row=mysqli_fetch_array($result)){
				$row=mysqli_fetch_array($result);
				
				   return $row['result'];					
				  // $i++;				
				//}

			}else return '';	
				
	}
	
	function getSmtpSettings($wheredata=null){

	    $db_obj=new DBFunction();

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('smtp_settings','',$wheredata,'id','asc',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
				while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['smtp_security'];
				$arrList[$i][2]=$row['smtp_host'];
				$arrList[$i][3]=$row['smtp_port'];
				$arrList[$i][4]=$row['smtp_username'];
				$arrList[$i][5]=$row['smtp_password'];

				$i++;
			}
		}
		return $arrList;
	}
	function saveSmtpSettings($post,$usage_type=null){
	
		$field_names=array("id","smtp_security","smtp_host","smtp_port","smtp_username","smtp_password","usage_type");
			
		$field_data=array("",$post['smtp_security'],$post['smtp_host'],$post['smtp_port'],$post['smtp_user_name'],$post['smtp_password'],$usage_type);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"smtp_settings");
		
		$res_id=$this->dbConnection->mysqli_connect->insert_id;
		if($result) return $res_id;
		else return 0;
	}
	function updateSmtpSettings($post,$usage_type=null){
	
		$fields=array('smtp_security','smtp_host','smtp_port','smtp_username','smtp_password');
		$field_data=array($post['smtp_security'],$post['smtp_host'],$post['smtp_port'],$post['smtp_user_name'],$post['smtp_password']);
		$result=$this->dbConnection->update($fields,$field_data,"usage_type",$usage_type,'smtp_settings');

		if($result) return true;
		else return false;
	
	}

		function updateLabInCharge($id,$status=null){
	
	  //      //updation history
			// $user_id=$_SESSION['user_id'];
			
		 //         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$id);
			
	  //              if(!empty($old_update)){
	   
	  //                      $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	  //              }else{
	  //                    $update_history = $user_id."|". date("d-m-Y H:i a");
		 //       }
		
		// $field_names1=array('status','update_history');
		// $field_data=array('1',$update_history);
		$field_names1=array('lab_in_charge_status');
		$field_data=array($status);
		
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_emp_info");
		
		if($result) return true;
		else return 0;
		
	}
		function clearLabInCharge(){
	
	  //      //updation history
			// $user_id=$_SESSION['user_id'];
			
		 //         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$id);
			
	  //              if(!empty($old_update)){
	   
	  //                      $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	  //              }else{
	  //                    $update_history = $user_id."|". date("d-m-Y H:i a");
		 //       }
		
		// $field_names1=array('status','update_history');
		// $field_data=array('1',$update_history);
		$field_names1=array('lab_in_charge_status');
		$field_data=array('0');
		
		
		$result=$this->dbConnection->update($field_names1,$field_data,"status",'0',"hcare_emp_info");
		
		if($result) return true;
		else return 0;
		
	}
		function update_signature($id,$documentInfo){
			
		
		$field_names=array("employee_signature");
		$field_data=array($documentInfo['document_name']);
		
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_emp_info");
		
		if($result) return true;
		else return false;

	}
		function remove_lab_signature($aid){
	
	  //      //updation history
			// $user_id=$_SESSION['user_id'];
			
		 //         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$aid);
			
	  //              if(!empty($old_update)){
	   
	  //                      $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	  //              }else{
	  //                    $update_history = $user_id."|". date("d-m-Y H:i a");
		 //       }
		
		// $field_names1=array('status','update_history');
		// $field_data=array('1',$update_history);
		$field_names1=array('employee_signature');
		$field_data=array('');
		
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_emp_info");
		
		if($result) return true;
		else return 0;
		
	}
	function getDescription($tid){ 
		 $query = "SELECT max(id) FROM `hcare_lab_result_entry` WHERE tid=".$tid." and description !='' ";

		$result=$this->dbConnection->executeQuery($query);		
		if(mysqli_num_rows($result) > 0){
			while($row=$result -> fetch_assoc()){
				$description=$this->dbConnection->idToValue("hcare_lab_result_entry","description","id",$row['max(id)']);
				return $description;
			}
		}
		return 0;
	}
}


?>
