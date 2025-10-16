<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class ReservedTokens{

	var $dbConnection;
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function checktokenIsReserved($token_no){
	
		$wheredata[0]="reserved_tokens ='".$token_no."'";
		
		
		$query=$this->dbConnection->BuiltQuery('hcare_reserved_tokens','',$wheredata);	
		$token_no=0;
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
		
			$token_no=1;
		}
		
		return $token_no;
	}
	function deleteTokens(){
	
		$result=$this->dbConnection->deletePermenantly('','hcare_reserved_tokens');
	
	}
	function addTokens($token_no){
	
		$field_names=array("id","reserved_tokens");
		$field_data=array("",$token_no);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_reserved_tokens");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;
		else return 0;
	
	}
	function getReservedTokens(){
	
		$query=$this->dbConnection->BuiltQuery('hcare_reserved_tokens');
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		$arrInfo=array();
		
		if(mysqli_num_rows($result) > 0){
		
			while($row=$result -> fetch_assoc()){
			
				
				$arrInfo[$i++]=$row['reserved_tokens'];
			
			}
		
		}
		
		return $arrInfo;
	}

}


?>