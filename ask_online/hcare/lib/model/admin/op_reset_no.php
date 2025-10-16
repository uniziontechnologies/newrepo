<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class OPResetNo{

	var $dbConnection;
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function nextResetOPNO(){
	
		
		
		$query=$this->dbConnection->BuiltQuery('hcare_op_reset_no');	
		$token_no=1;
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
		
			$row=$result -> fetch_assoc();
			
			$reset_no =$row['op_no']+1;
		}else $reset_no=1;
		
		return $reset_no;
	}
	
	function updateResetOPNO($opno){
	
			$field_names = array('op_no');
			$field_data = array($opno);
			
			$result=$this->dbConnection->update($field_names,$field_data,"id",'1',"hcare_op_reset_no");
	}

}


?>