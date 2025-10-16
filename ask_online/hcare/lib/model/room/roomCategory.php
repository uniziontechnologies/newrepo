<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';

class roomCategory{

	var $dbConnection;	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addRoomCategory($post){
	
		
		$field_names=array("id","category","rent","nursing_charges","maintenance","hour_charge","color","status","bystander_charge");
		$field_data=array("",$post['category'],$post['rent'],$post['ncharge'],$post['mcharge'],$post['hcharge'],$post['color'],0,$post['bcharge']);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_room_category");
		
		if($result) return true;
		else return false;
	
	}
	function updateRoomCategory($post){
	
		$id=$post['id'];		
		
		
		$field_names=array("category","rent","nursing_charges","maintenance","hour_charge","color","status","bystander_charge");
		$field_data=array($post['category'],$post['rent'],$post['ncharge'],$post['mcharge'],$post['hcharge'],$post['color'],0,$post['bcharge']);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_room_category");
		
		if($result) return true;
		else return false;
	
	}
	function deleteRoomCategory($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_room_category");
		
		if($result) return true;
		else return false;
	}
	function getRoomCategory($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_room_category",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['category'];
						$arrList[$i][2]=$row['rent'];
						$arrList[$i][3]=$row['nursing_charges'];
						$arrList[$i][4]=$row['maintenance'];
						$arrList[$i][5]=$row['status'];
						//get hour charge
						$arrList[$i][6]=$row['hour_charge'];
						$arrList[$i][7]=$row['bystander_charge'];
						
					
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	
	
	

}


?>
