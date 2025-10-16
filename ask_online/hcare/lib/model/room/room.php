<?php
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';

class Room{

	var $dbConnection;	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	
	
	function addRoom($post){
	
		
		$field_names=array("id","room_category","room_number","bed_capacity","total_bed_no");
		$field_data=array("",$post['category'],$post['roomno'],$post['bed_capacity'],$post["total_bed_no"]);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_rooms");
		$room_id=$this->dbConnection->mysqli_connect->insert_id;
		if($result) return $room_id;
		else return 0;
	
	}
	function updateRoom($post){
	
		$id=$post['id'];		
		
		
		$field_names=array("room_category","room_number","bed_capacity","total_bed_no");
		$field_data=array($post['category'],$post['roomno'],$post['bed_capacity'],$post["total_bed_no"]);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_rooms");
		
		if($result) return true;
		else return false;
	
	}
	function updateBedStatus($status,$id){
	
	    $field_names=array("bed_status");
		$field_data=array($status);
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_room_beds");
		
		if($result) return true;
		else return false;
	}
        function deleteRoom($post){
		$id=$post['id'];
		
				
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_rooms");
		
		#$result=$this->dbConnection->deletePermenantly($where,"hcare_op_visit_info");
	}
	function addBeds($post){
	
		$total_bed_number=$post["total_bed_no"];
		
		for($i=0;$i<$total_bed_number;$i++){
		
			$k=$i;
			++$k;
			$field_names=array("id","room_id","bed_number","bed_status");
			$field_data=array("",$post["id"],$k,"FREE");
			$result=$this->dbConnection->insert($field_names,$field_data,"hcare_room_beds");
		}
		
		if($result) return true;
		else return false;
	
	}
	
	function getRoomDetails($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		
		$query=$this->dbConnection->BuiltQuery("hcare_rooms",$selectfield,$wheredata,$orderbyfield,$orderby);	
		
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
						$arrList[$i][5]=$this->dbConnection->idToValue("hcare_room_category","category","id",$row[1]);
						//$arrList[$i][6]=$row[5];
						$arrList[$i][6]=$this->dbConnection->idToValue("hcare_room_category","rent","id",$row[1]);
                        $arrList[$i][7]=$row[6];
						$arrList[$i][8]=$this->dbConnection->idToValue("hcare_room_category","nursing_charges","id",$row[1]);
						$arrList[$i][9]=$this->dbConnection->idToValue("hcare_room_category","maintenance","id",$row[1]);
                        $arrList[$i][10]=$this->dbConnection->idToValue("hcare_room_category","hour_charge","id",$row[1]); 
                        $arrList[$i][11]=$this->dbConnection->idToValue("hcare_room_category","bystander_charge","id",$row[1]);                       
						
					
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	
	function getBedInfo($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		
		$query=$this->dbConnection->BuiltQuery("hcare_room_beds",$selectfield,$wheredata,$likefield,$orderbyfield,$orderby);	
		
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						
						
					
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	
	function addNursingStation($post){
	
		
		$field_names=array("id","station_name","status");
		$field_data=array("",$post['station_name'],0);
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_nursing_stations");
		$id=$this->dbConnection->mysqli_connect->insert_id;
		
		if($result) return $id;
		else return false;
	
	}
        function updateStationName($id,$station_name){
	
		//$id=$post['id'];		
		
		
		$field_names=array("station_name");
		$field_data=array($station_name);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_nursing_stations");
		
		if($result) return true;
		else return false;
	
	}

        function deleteStation($id){
	
		//$id=$post['id'];		
		
		
		$field_names=array("status");
		$field_data=array(1);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"hcare_nursing_stations");
		
		if($result) return true;
		else return false;
	
	}

        function addStationRoom($roomid,$station_id){
	
		//$id=$post['id'];		
		
		
		$field_names=array("station_id");
		$field_data=array($station_id);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$roomid,"hcare_rooms");
		
		if($result) return true;
		else return false;
	
	}

        function deleteStationRoom($sid){
	
		//$id=$post['id'];		
		
		
		$field_names=array("station_id");
		$field_data=array(0);
	
		
		$result=$this->dbConnection->update($field_names,$field_data,"station_id",$sid,"hcare_rooms");
		
		if($result) return true;
		else return false;
	
	}

        function getNursingStation($wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		
		$query=$this->dbConnection->BuiltQuery("hcare_nursing_stations",'',$wheredata,'',$orderbyfield,$orderby);	
		
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						
						
						
					
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

    function deleteBeds($post){

    	$query = "DELETE FROM `hcare_room_beds` WHERE `room_id`=".$post['id']." ";

    	$result=$this->dbConnection->executeQuery($query);

		
		
	}
	
	

}


?>
