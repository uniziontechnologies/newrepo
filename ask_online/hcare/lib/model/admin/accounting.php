<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/speciality.php';

class Accounting{

	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}


	function getAccountingAutomise(){
	
		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('z_accounting_daily_collection','','','id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['label'];
				$arrList[$i][2]=$row['cr_ledger'];
				$arrList[$i][3]=$row['dr_ledger'];
				$arrList[$i][4]=$row['user_id'];
				$arrList[$i][5]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][6]=$row['date'];
				$arrList[$i][7]=$row['lock_status'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}

	function add_op_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['op_ledger_cr'],$post['op_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}

	function add_lab_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['lab_ledger_cr'],$post['lab_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_xray_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['xray_ledger_cr'],$post['xray_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_lab_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['lab_credit_ledger_cr'],$post['lab_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_xray_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['xray_credit_ledger_cr'],$post['xray_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_pharmacy_sales_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("pharma_ledger","cgst_5","sgst_5","cgst_12","sgst_12","cgst_18","sgst_18","cgst_28","sgst_28","round_off","cash_in_hand","discount","user_id","date","lock_status","sales_credit");
		$field_data=array($post['pharma_ledger'],$post['cgst_5'],$post['sgst_5'],$post['cgst_12'],$post['sgst_12'],$post['cgst_18'],$post['sgst_18'],$post['cgst_28'],$post['sgst_28'],$post['round_off'],$post['cash_in_hand'],$post['discount'],$user_id,$date,1,$post['sales_credit']);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_pharma_sales");
		
		if($result) return true;
		else return false;
	
	}
	function add_pharmacy_purchase_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("purchase_medicine","cgst_5","sgst_5","cgst_12","sgst_12","cgst_18","sgst_18","cgst_28","sgst_28","round_off","discount","bank_ledger","user_id","date","lock_status");
		$field_data=array($post['purchase_medicine'],$post['cgst_5'],$post['sgst_5'],$post['cgst_12'],$post['sgst_12'],$post['cgst_18'],$post['sgst_18'],$post['cgst_28'],$post['sgst_28'],$post['round_off'],$post['discount'],$post['bank_ledger'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_pharma_purchase");
		
		if($result) return true;
		else return false;
	
	}
	function add_pharmacy_purchase_return_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("purchase_medicine","cgst_5","sgst_5","cgst_12","sgst_12","cgst_18","sgst_18","cgst_28","sgst_28","round_off","discount","bank_ledger","user_id","date","lock_status");
		$field_data=array($post['purchase_medicine'],$post['cgst_5'],$post['sgst_5'],$post['cgst_12'],$post['sgst_12'],$post['cgst_18'],$post['sgst_18'],$post['cgst_28'],$post['sgst_28'],$post['round_off'],$post['discount'],$post['bank_ledger'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_pharma_purchase_return");
		
		if($result) return true;
		else return false;
	
	}
	function getAccountingAutomisePharmaSales(){
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('z_accounting_pharma_sales','','','id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['label'];
				$arrList[$i][2]=$row['pharma_ledger'];
				$arrList[$i][3]=$row['cgst_5'];
				$arrList[$i][4]=$row['sgst_5'];
				$arrList[$i][5]=$row['cgst_12'];
				$arrList[$i][6]=$row['sgst_12'];
				$arrList[$i][7]=$row['cgst_18'];
				$arrList[$i][8]=$row['sgst_18'];
				$arrList[$i][9]=$row['cgst_28'];
				$arrList[$i][10]=$row['sgst_28'];
				$arrList[$i][11]=$row['round_off'];
				$arrList[$i][12]=$row['cash_in_hand'];
				$arrList[$i][13]=$row['discount'];
				$arrList[$i][14]=$row['user_id'];
				$arrList[$i][15]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][16]=$row['date'];
				$arrList[$i][17]=$row['lock_status'];
				$arrList[$i][18]=$row['sales_credit'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function getAccountingAutomisePharmaPurchase(){
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('z_accounting_pharma_purchase','','','id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['label'];
				$arrList[$i][2]=$row['purchase_medicine'];
				$arrList[$i][3]=$row['cgst_5'];
				$arrList[$i][4]=$row['sgst_5'];
				$arrList[$i][5]=$row['cgst_12'];
				$arrList[$i][6]=$row['sgst_12'];
				$arrList[$i][7]=$row['cgst_18'];
				$arrList[$i][8]=$row['sgst_18'];
				$arrList[$i][9]=$row['cgst_28'];
				$arrList[$i][10]=$row['sgst_28'];
				$arrList[$i][11]=$row['round_off'];
				$arrList[$i][12]=$row['discount'];
				$arrList[$i][13]=$row['bank_ledger'];
				$arrList[$i][14]=$row['user_id'];
				$arrList[$i][15]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][16]=$row['date'];
				$arrList[$i][17]=$row['lock_status'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function add_pharmacy_sales_return_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("pharma_return_ledger","cgst_5","sgst_5","cgst_12","sgst_12","cgst_18","sgst_18","cgst_28","sgst_28","round_off","cash_in_hand","discount","user_id","date","lock_status");
		$field_data=array($post['pharma_return_ledger'],$post['cgst_5'],$post['sgst_5'],$post['cgst_12'],$post['sgst_12'],$post['cgst_18'],$post['sgst_18'],$post['cgst_28'],$post['sgst_28'],$post['round_off'],$post['cash_in_hand'],$post['discount'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_pharma_sales_return");
		
		if($result) return true;
		else return false;
	
	}
	function getAccountingAutomisePharmaSalesReturn(){
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('z_accounting_pharma_sales_return','','','id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['label'];
				$arrList[$i][2]=$row['pharma_return_ledger'];
				$arrList[$i][3]=$row['cgst_5'];
				$arrList[$i][4]=$row['sgst_5'];
				$arrList[$i][5]=$row['cgst_12'];
				$arrList[$i][6]=$row['sgst_12'];
				$arrList[$i][7]=$row['cgst_18'];
				$arrList[$i][8]=$row['sgst_18'];
				$arrList[$i][9]=$row['cgst_28'];
				$arrList[$i][10]=$row['sgst_28'];
				$arrList[$i][11]=$row['round_off'];
				$arrList[$i][12]=$row['cash_in_hand'];
				$arrList[$i][13]=$row['discount'];
				$arrList[$i][14]=$row['user_id'];
				$arrList[$i][15]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][16]=$row['date'];
				$arrList[$i][17]=$row['lock_status'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function add_procedure_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['procedure_ledger_cr'],$post['procedure_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_procedure_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['procedure_credit_ledger_cr'],$post['procedure_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_ip_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['ip_ledger_cr'],$post['ip_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_theater_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['theater_credit_ledger_cr'],$post['theater_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_theater_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['theater_ledger_cr'],$post['theater_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_super_nurse_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['super_nurse_credit_ledger_cr'],$post['super_nurse_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_nurse_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['nurse_ledger_cr'],$post['nurse_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_nurse_credit_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['nurse_credit_ledger_cr'],$post['nurse_credit_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function add_op_dr_payments_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['op_dr_payments_cr'],$post['op_dr_payments_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	function getAccountingAutomisePharmaPurchaseReturn(){
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('z_accounting_pharma_purchase_return','','','id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['label'];
				$arrList[$i][2]=$row['purchase_medicine'];
				$arrList[$i][3]=$row['cgst_5'];
				$arrList[$i][4]=$row['sgst_5'];
				$arrList[$i][5]=$row['cgst_12'];
				$arrList[$i][6]=$row['sgst_12'];
				$arrList[$i][7]=$row['cgst_18'];
				$arrList[$i][8]=$row['sgst_18'];
				$arrList[$i][9]=$row['cgst_28'];
				$arrList[$i][10]=$row['sgst_28'];
				$arrList[$i][11]=$row['round_off'];
				$arrList[$i][12]=$row['discount'];
				$arrList[$i][13]=$row['bank_ledger'];
				$arrList[$i][14]=$row['user_id'];
				$arrList[$i][15]=$this->dbConnection->idToValue('hcare_users','user_name','id',$row['user_id']);
				$arrList[$i][16]=$row['date'];
				$arrList[$i][17]=$row['lock_status'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}
	function add_ip_advance_payments_details($post){

		date_default_timezone_set('Asia/Kolkata');
	
		$id=$post['id'];

		$user_id=$_SESSION['user_id'];	

		$date = date("Y-m-d H:i:s");	
		
		$field_names=array("cr_ledger","dr_ledger","user_id","date","lock_status");
		$field_data=array($post['ip_advance_ledger_cr'],$post['ip_advance_ledger_dr'],$user_id,$date,1);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"z_accounting_daily_collection");
		
		if($result) return true;
		else return false;
	
	}
	

}


?>
