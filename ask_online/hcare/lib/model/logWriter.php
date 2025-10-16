<?php 
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

class LogWriter{

	var $logtable = "hcare_user_logs";
	var $log_fields = array("id","user_id","login_date","login_time");
	var $activitytable = "hcare_log_activities";
	var $activity_fields = array("id","log_id","activity","table_name","ref_id");
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addLog($user_id){
	
			$common_function =new CommonFunctions();
			
			$date=$common_function->getcurrentDate();
			$time=$common_function->getcurrentTime();
			
			$field_data=array("",$user_id,$date,$time);echo $this->log_fields[0];
			
			$result=$this->dbConnection->insert($this->log_fields,$field_data,$this->logtable);
		
	
	}

}
?>