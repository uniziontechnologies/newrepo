
<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';

class Scheduling{

	var $field_names=array("id","doc_id","cons_time","booking_limit","booking_status","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	var $tablename="hcare_doc_scheduling";
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}
	function changeBookingStatus($post){
	
		$field_names=array("booking_status");
		
		 $status = $post['status'];
		 
		 if($status == "Active") $status="Blocked";
		 else $status="Active";
		
		$field_data=array($status);
		
		$result=$this->dbConnection->update($field_names,$field_data,"doc_id",$post['id'],$this->tablename);
			
			if($status == "Active") $status="Activated";
			if($result) return "$status Successfully!";
			else return "Failed To $status Doctor";
	}

	function addSheduling($postArr,$sheduledInfo){
	
		$status="Active";
	
	
	$field_data=array('',$postArr['id'],$postArr['cons_time'],$postArr['bk_limit'],$status,$sheduledInfo[0],$sheduledInfo[1],$sheduledInfo[2],$sheduledInfo[3],$sheduledInfo[4],$sheduledInfo[5],$sheduledInfo[6]);
	
	$result=$this->dbConnection->insert($this->field_names,$field_data,$this->tablename);
			
			if($result) return true;
			else return false;
	
	}
	function updateSheduling($postArr,$sheduledInfo){
	
	
		$status=$postArr['status'];	
		$field_names=array("cons_time","booking_limit","booking_status","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	
	$field_data=array($postArr['cons_time'],$postArr['bk_limit'],$status,$sheduledInfo[0],$sheduledInfo[1],$sheduledInfo[2],$sheduledInfo[3],$sheduledInfo[4],$sheduledInfo[5],$sheduledInfo[6]);
	
	
			
			
			$result=$this->dbConnection->update($field_names,$field_data,"doc_id",$postArr['id'],$this->tablename);
			
			
			if($result) return true;
			else return false;
	
	}
	function getSchedulingByDate($date,$dep_id = null){
	
		$arrList=array();
		$i=0;
		
		$weekday = date('l', strtotime($date));
		$weekno	=date('N', strtotime($date));
		
		if($weekno == 7 ){
			$start=5;
		}else{
			$start=9+($weekno-1)*4;
		}
		$emp_obj=new Employee();
		
		$is_field[0]= "a.title ='Dr'";
		if(!empty($dep_id)){
		
			$is_field[1]= "b.department_id ='".$dep_id."'";
		}
		$doctors=$emp_obj->getEmployee($is_field);
		
		if(!empty($doctors)){
		
			for($k=0;$k<count($doctors);$k++){ 
				$docid=$doctors[$k][0];

				$drScheduling=$this->getDrScheduling($docid,$weekday);

				$wheredataBlocked[0]="doc_id = '".$docid."'";
				$wheredataBlocked[1]="status = 0";
				$wheredataBlocked[2]="blocked_date = '".$date."'";

				$drBookingBlocked=$this->getBlockedDate($wheredataBlocked);

				// var_dump($drBookingBlocked[0][0]);


				if(!empty($drScheduling)){
				
					if($drScheduling[0][4] == "Active" && empty($drBookingBlocked[0][0])) { 
						$arrList[$i][0]=$docid;
						$arrList[$i][1]=$doctors[$k][1]." ".$doctors[$k][2]." ".$doctors[$k][3];
						$arrList[$i][2]=$drScheduling[0][$start];
						$arrList[$i][3]=$drScheduling[0][$start+1];
						$arrList[$i][4]=$drScheduling[0][$start+2];
						$arrList[$i][5]=$drScheduling[0][$start+3];
						$i++;
					}
					
				}
			}
		}
		
		return $arrList;
	
	}
	
	function getDrScheduling($docid,$shed_day = null){
	
		$arrList=array();
		$i=0;
		$l=0;
		
			$wheredata[$l++] = "doc_id =$docid";
		
		if(!empty($shed_day)){
			$wheredata[$l++] = "$shed_day != ''";
		}
		
		$query=$this->dbConnection->BuiltQuery($this->tablename,'',$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result)>0){
			
			while($row=$result -> fetch_assoc()){
				$j=0;
				for($m=0;$m<count($this->field_names);$m++) {
				
					if($m >= 5){
					
					
						$data=explode("/",$row[$this->field_names[$m]]);
						if(count($data) > 1 ){
							for($h=0;$h<count($data);$h++){
								$arrList[$i][$j++]=$data[$h];
							}
						}else{
						
							for($h=0;$h<4;$h++){
								$arrList[$i][$j++]='';
							}
						}
					}else {
						$arrList[$i][$j++]=$row[$this->field_names[$m]];
					}
				}
				
				$i++;
			
			}
		
		} 
			return $arrList;
	}
	function getSchedulingList($is_field = null ){
	
		$arrList=array();
		$i=0;
		$emp_obj=new Employee();
		$doctors=$emp_obj->getEmployee($is_field);
		
		if(!empty($doctors)){
		
			for($k=0;$k<count($doctors);$k++){ 
				$docid=$doctors[$k][0];
				
				$wheredata[0] = "doc_id =$docid";		
				$arrList[$i][0]=$docid;
				$arrList[$i][1]=$doctors[$k][1]." ".$doctors[$k][2]." ".$doctors[$k][3];
				
				$query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wheredata,$orderbyfield,$orderby);	
				$result=$this->dbConnection->executeQuery($query);
		
		
				if(mysqli_num_rows($result)>0){
					if(empty($selectfield)){
						while($row=$result -> fetch_assoc()){
							$j=2;
							for($m=0;$m<count($this->field_names);$m++) {
						
								
								$arrList[$i][$j++]=$row[$this->field_names[$m]];
						
							}
							
						}
				//0->id
				//1->department name
				//2->employee_name
				//3->department in charge_id
				//4->phone				
				//5->status
			
					}
		
				}
				$i++;
			}
		
		}
		
		return $arrList;	
	
	}
	function SaveBlockedDate($post=null){

		date_default_timezone_set('Asia/Kolkata');

		$user_id=$_SESSION['user_id'];
		$added_on=date("Y-m-d H:i:s");

		$post['blocked_date'] = date("Y-m-d",strtotime($post['blocked_date']));
	
	
		$field_names=array("id","doc_id","blocked_date","remarks","user_id","added_on","cancelled_by","cancellation_reason","cancelled_on","status");
		$field_data=array("",$post['id'],$post['blocked_date'],$post['blocked_remarks'],$user_id,$added_on,"","","",0);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_booking_blocked_dates");
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	
	}

	function getBlockedDate($wheredata=null,$limit=null){

	    $db_obj=new DBFunction();

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_booking_blocked_dates','',$wheredata,'id','desc','',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
				while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['doc_id'];
				$arrList[$i][2]=$row['blocked_date'];
				$arrList[$i][3]=$row['remarks'];
				$arrList[$i][4]=$row['user_id'];
				$arrList[$i][5]=$row['added_on'];
				$arrList[$i][6]=$row['cancelled_by'];
				$arrList[$i][7]=$row['cancellation_reason'];
				$arrList[$i][8]=$row['cancelled_on'];
				$arrList[$i][9]=$row['status'];

				$i++;
			}
		}
		return $arrList;
	}
	function deleteBlockedDate($post=null)
	{

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['delete_id'];

		$cancellation_reason = $post['cancellation_details'];

        $cancelled_on = date("Y-m-d H:i:s");

		$cancelled_by = $_SESSION['user_id'];
		
		$field_names1=array('status','cancellation_reason','cancelled_on','cancelled_by');
		$field_data=array('1',"$cancellation_reason"," $cancelled_on","$cancelled_by");
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_booking_blocked_dates");
		
		if($result) return true;
		else return false;

	}
	
	

}


?>
