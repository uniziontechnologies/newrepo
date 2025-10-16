
<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';

class Booking{

	var $field_names=array("id","doc_id","cons_time","booking_limit","active","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	var $tablename="hcare_doc_scheduling";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}
	
	function getNextRegToken($docid,$date){
	
		$selectfield[0]="token_no";
		
		$wheredata[0]="doc_id ='".$docid."'";
		$wheredata[1]="visit_date like '".date("Y-m-d",strtotime($date))."%'";
		$wheredata[2]="reg_from ='registration'";
		
		$query=$this->dbConnection->BuiltQuery('hcare_op_visit_info',$selectfield,$wheredata,'visit_date','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
		
			$token_no = $result->fetch_assoc()['token_no']+1;
			
			
			$booktoken=$this->getNextToken($docid,$date);
			if($booktoken == 1) $bookcount=0;
			
			if($token_no <$booktoken) $token_no=$booktoken;
			
		}else $token_no=1;
		
		return $token_no;
	
	}
	function getNextToken($docid,$date){
	
		$selectfield[0]="token_no";
		$wheredata[0]="doc_id ='".$docid."'";
		$wheredata[1]="booking_date ='".date("Y-m-d",strtotime($date))."'";
		$wheredata[2]="token_from ='Normal'";
		
		$query=$this->dbConnection->BuiltQuery('hcare_booking_info',$selectfield,$wheredata,'id','desc');	
		$token_no=1;
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
		
			$token_no = $result->fetch_assoc()['token_no']+1;
		}else $token_no=1;
		
		return $token_no;
	
	}
	
	function addBookingInfo($token_no,$post){

		$split_token_no=explode("/", $token_no);

		$token_no=$split_token_no[0];
		$token_time=$split_token_no[1];
	
		$field_names=array("id","token_no","token_time","doc_id","booking_date","booked_on","patient_name","place","phone","token_from");
		$field_data=array("",$token_no,$token_time,$post['id'],date("Y-m-d",strtotime($post['booking_date'])),date('Y-m-d'),$post['patient_name'],$post['place'],$post['phone'],$post['token_from']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_booking_info");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	
	}
	function getBookingList($wheredata){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_booking_info','',$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['token_no'];
				$arrList[$i][2]=$row['doc_id'];
				$arrList[$i][3]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doc_id']);
				$arrList[$i][4]=date("d-m-Y",strtotime($row['booking_date']));
				$arrList[$i][5]=$row['booked_on'];
				$arrList[$i][6]=$row['patient_name'];
				$arrList[$i][7]=$row['place'];
				$arrList[$i][8]=$row['phone'];
				$arrList[$i][9]=$row['status'];
				$arrList[$i][10]=$row['token_time'];
				// $emp_id=$this->dbConnection->idToValue('hcare_users','employee_id','id',$row['cancelled_by']);
				// $arrList[$i][11]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$emp_id)." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$emp_id);
				 $arrList[$i][11]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['cancelled_by']);
				$arrList[$i][12]=$row['cancellation_date'];
				$arrList[$i][13]=$row['cancellation_reason'];
				$i++;
			}
		
		}
	
		return $arrList;
	}
	function getBookingListCount($wheredata){
        
        $query=$this->dbConnection->BuiltQuery('hcare_booking_info','',$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		return mysqli_num_rows($result);

	}
	function updateToVisit($bk_id){
	
		$field_names=array("visited");
		$field_data=array("1");
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$bk_id,"hcare_booking_info");
	
	}

	function OP_consultation_status(){
		$bk_obj = new Booking();
		$arrList=null;
		$doctors=null;
		$tot_registration = null;
		$tot_booking = null;
		$tot_consulted = null;
		$next_token = null;
		$result_array = null;

		$i=0;
		$j=-1;
		$b = -1;


		$wheredata  = array();
		$wheredata[]="visit_date like '".date("Y-m-d")."%'";
		$query=$this->dbConnection->BuiltQuery('hcare_op_visit_info','',$wheredata,'doc_id','');
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){			
			while($row=$result -> fetch_assoc()){

				$arrList[$i][0]=$row['token_no'];
				$arrList[$i][1]=$this->dbConnection->idToValue("hcare_emp_info","title","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","first_name","id",$row['doc_id'])." ".$this->dbConnection->idToValue("hcare_emp_info","last_name","id",$row['doc_id']);
				$arrList[$i][3]=$row['cons_status'];

				if($doctors[$j] != $arrList[$i][1]){
					$j++;
					$doctors[$j] = $arrList[$i][1];
					$tot_consulted[$j] = 0;
					$where = array();
					$where[] = "doc_id = '".$row['doc_id']."'";
					$where[]="booking_date ='".date("Y-m-d")."'";
					$where[]="status = 0";
					$tot_booking[$j] = $bk_obj->getBookingListCount($where);
					$tot_registration[$j] = 1;
					if($arrList[$i][3]=='YES'){
						$tot_consulted[$j] = 1;
					}
					if($arrList[$i][3]!='YES'){
					$next_token[$j] = $arrList[$i][0];	
					}			
					
				}
				else{
					$tot_registration[$j] += 1;
					if($arrList[$i][3]=='YES'){
						$tot_consulted[$j] += 1;
					}	
					if($arrList[$i][3]!='YES'){
						if($next_token[$j]>$arrList[$i][0] || $next_token[$j]==null){
							$next_token[$j] = $arrList[$i][0];
						}
					}				
				}
				$i++;
			}
		
		}
		$result_array['doctors']=$doctors;
		$result_array['tot_registration']=$tot_registration;
		$result_array['tot_booking']=$tot_booking;
		$result_array['tot_consulted']=$tot_consulted;
		$result_array['next_token']=$next_token;
		return $result_array;
	}
	function cancelBooking($bk_id=null,$reason=null){
	  
        date_default_timezone_set('Asia/Kolkata');
        $cancellation_date = date("Y-m-d H:i:s");
         // echo $cancellation_date;exit();
        $user_id=$_SESSION['user_id'];
		
		$field_names=array("status","cancelled_by","cancellation_date","cancellation_reason");
		$field_data=array(1,$user_id,$cancellation_date,$reason);
		$result=$this->dbConnection->update($field_names,$field_data,"id",$bk_id,"hcare_booking_info");
			
			if($result) return $bk_id;
		else return 0;
	
	}

}


?>