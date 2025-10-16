<?php 

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class User{

	var $dbConnection;
	var $field_names=array("id","employee_id","user_name","password","user_type","branch","status");
	var $tablename="hcare_users";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addUser($post){
		$password = md5($post['password']);
		
		
		$field_data=array("",$post['id'],$post['username'],$password,$post['user_type'],$post['branch'],0);
		$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
		
		if($result) return 1;
		else return 0;
	
	}
	function updateUser($post){
	
		$userid=$post['userid'];
		
		if($post['password']!=''){
		
			$password = md5($post['password']);
			$this->field_names=array("employee_id","user_name","password","user_type","branch","status");
			$field_data=array($post['id'],$post['username'],$password,$post['user_type'],$post['branch'],0);
			
		}else{
		
			$this->field_names=array("employee_id","user_name","user_type","status");
			$field_data=array($post['id'],$post['username'],$post['user_type'],0);
		}
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$userid,$this->tablename);
		
		if($result) return 1;
		else return 0;
	
	}
	function deleteUser($post){
	
		$emp_id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"employee_id",$emp_id,$this->tablename);
		
		if($result) return 1;
		else return 0;
	}
	function getUser($selectfield = null,$wherefield = null,$orderfield=null,$orderby=null,$all_data = null){
	
		$arrList=array();
		// $wherefield=array();
		    if(empty($all_data)){

				  $wherefield[]="status = '0'";
		    }
		    else{

		    	  $wherefield[]="status = '0' OR status = '1' ";
		    }
			
		  $query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wherefield,$orderfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					$j=0;
					for($k=0;$k<count($this->field_names);$k++) {
						if($this->field_names[$k]=="employee_id"){

							$empname=$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row[$this->field_names[$k]])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row[$this->field_names[$k]]);

                                                        $title=$this->dbConnection->idToValue("hcare_emp_info","title","id",$row[$this->field_names[$k]]);
							$arrList[$i][$j++]=($title!= "" )?$title.".".$empname:$empname;

						}else if($this->field_names[$k]=="user_type"){
							 
							
							 $data[0]="id='".$row[$this->field_names[$k]]."'";
							 $user_type=$this->getUsertype($data);
							 $user_name=$user_type[0][1];
							 
							$arrList[$i][$j++]=$user_name;
						}
						$arrList[$i][$j++]=$row[$this->field_names[$k]];
						
					}
						$i++;
				}
				//0->id
				//1->employee name
				//2->employeeid
				//3->username
				//4->pwd
				//5->usertype
				//6->usertypeid
				//7->status
			
			}
		
		}
		return $arrList;	
	
	}
	function checkUser($post){
	
		
		$userid=$post['userid'];
		$username_db=$this->dbConnection->idToValue($this->tablename,"user_name","id",$userid);
		$username=$post['username'];
		
		//$id=$this->dbConnection->idToValue($this->tablename,"id","user_name",$username);
		//$status=$this->dbConnection->idToValue($this->tablename,"status","id",$id);
		
		$data[0]="user_name ='".$username."'";
		$data[1]="status='0'";;
		
		
		
		$userInfo=$this->getUser('',$data);
		
		if(empty($userid) && !empty($userInfo)){
			return false;
		}else if (!empty($userid) && $username_db!=$username && !empty($userInfo)){
			return false;
		}else{
			return true;
		}
	}
	
	function login($username,$password){
	
		$password1=md5($password);
		
		$wheredata[0]="user_name = '".$username."'";
		$wheredata[1]="password ='".$password1."'";
		
		
		
		$userInfo=$this->getUser('',$wheredata);
		
		return $userInfo;
	
	}
	
	function getUsertype($wheredata = null){
	
			$arrList=array();
			$i=0;
			
			if(empty($wheredata)){
				
				$wheredata[0]="status = '0'";
			}
			$query=$this->dbConnection->BuiltQuery("hcare_user_type",'',$wheredata);
			$result=$this->dbConnection->executeQuery($query);
			
			if(mysqli_num_rows($result)>0){
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['user_type'];
					$i++;
				
				}
			
			}
			return $arrList;
	}
        function getfullUserInfo($wheredata = null) {
                
                                $arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`employee_id`";
				$arrFieldList[2]= "a.`user_name`";
				$arrFieldList[3]= "a.`password`";
				$arrFieldList[4]= "a.`user_type`";
				$arrFieldList[5]= "a.`branch`";
				$arrFieldList[6]= "a.`status`";
				$arrFieldList[7]= "b.`id`";
				$arrFieldList[8]= "b.`user_type`";
				$arrFieldList[9]= "b.`status`";

                                $arrTables[0] = "`hcare_users` a";
       			        $arrTables[1] = "`hcare_user_type` b";

                                $joinConditions[1] = "a.`user_type` = b.`id`";
                                
                               
				if(!empty($wheredata)) {
					for($k=0;$k<count($wheredata);$k++){
					
						$selectConditions[]=$wheredata[$k];
					}
				}

                              $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions);
			
				$result=$this->dbConnection->executeQuery($query);
				$i=0;
                                $arrList=array();
				
				if(mysqli_num_rows($result)>0){
								$i=0;
						while($row=mysqli_fetch_array($result)){
									
								for($k=0;$k<count($arrFieldList);$k++) {						
								
									$arrList[$i][$k]=$row[$k];
								}
                                                    $i++;
                                               }
                               }

                    return $arrList;
				

        }

        function updatePassword($post){
	
		$userid=$post['userid'];
		
		if($post['password']!=''){
		
			$password = md5($post['password']);
			
			$this->field_names=array("password");
			$field_data=array($password);
			
		}
		
		$result=$this->dbConnection->update($this->field_names,$field_data,"id",$userid,$this->tablename);
		
		if($result) return 1;
		else return 0;
	
	}



}


?>
