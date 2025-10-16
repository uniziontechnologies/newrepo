<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class General{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addOpSettings($post){
		
		$field_names=array("id","op_validity","reg_fee","card_fee","date","card_expiry","card_expiry_type");
		$field_data=array("",$post['validity_days'],$post['reg_fee'],$post['card_fee'],date("Y-m-d"),$post['card_expiry'],$post['card_expiry_type']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_settings");
		
		if($result) return true;
		else return false;
	
	}
	function getOpSettings($selectfield = null,$condition =null ,$orderbyfield = null,$orderbytype = null){
	
			
			$arrList=array();
			
			$query=$this->dbConnection->BuiltQuery("hcare_op_settings",$selectfield,$condition,$orderbyfield,$orderbytype);	
			$result=$this->dbConnection->executeQuery($query);
			$i=0;
			if(mysqli_num_rows($result)>0){
			
				if(!empty($selectfield)){
						while($row=$result -> fetch_assoc()){
							for($j=0;$j<count($selectfield);$j++){
								$arrList[$i][$j]=$row[$selectfield[$j]];
							}
							$i++;
						}
				}else{
						while($row=$result -> fetch_assoc()){
				
								$arrList[$i][0]=$row['id'];
								$arrList[$i][1]=$row['op_validity'];
								$arrList[$i][2]=$row['reg_fee'];
								$arrList[$i][3]=$row['date'];
								$arrList[$i][4]=$row['card_fee'];
								$arrList[$i][5]=$row['card_expiry'];
								$arrList[$i][6]=$row['card_expiry_type'];
								$i++;
						}
				}
			
		}else{
								
		
		}
		return $arrList;
	}
		function updateRegEmail($post){ 

		$reg_emails = "";

		if (!empty($post['reg_emails'])) {

			for ($i=0; $i < count($post['reg_emails']) ; $i++) { 
				
				if (!empty($post['reg_emails'][$i])) {
					
					$reg_emails.=$post['reg_emails'][$i]."#";

				}

			}

			$reg_emails = rtrim($reg_emails, "#");
		}


		$fields=array('emails','daily');

		if (!empty($post['clear_reg']) && $post['clear_reg']=="YES") {
			$field_data=array(NULL,0);
		}
		else{
			$field_data=array($reg_emails,1);
		}
		
		// $result=$this->dbConnection->update($fields,$field_data,"id",1,'email_settings');
		$result=$this->dbConnection->update($fields,$field_data,"id",1,'email_settings');

		if($result) return true;
		else return false;
	
	}
		function getRegEmails($wheredata=null){

	    $db_obj=new DBFunction();

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('email_settings','',$wheredata,'id','asc',$limit);	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
				while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['reports'];
				$arrList[$i][2]=$row['emails'];

				$i++;
			}
		}
		return $arrList;
	}
	

}


?>