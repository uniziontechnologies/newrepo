<?php 
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config_accounting.php';


class AccountingModel{

	
	
	function __construct(){
		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function getEntryNumber($entry_type){
	
		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

	        $select[0]="number";
		    $wheredata[0]="entry_type=".$entry_type;
			$query=$this->dbConnection->BuiltQuery('entries',$select,$wheredata,'id','desc','','0,1');
			$result=$this->dbConnection->executeQuery($query);
			
			if(mysqli_num_rows($result)>0){
						
				$row=$result -> fetch_assoc();
				
				$entry_number=$row['number'];
					
				}else $entry_number=0;	

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);			
			
		return $entry_number;
	}
	function addEntry($info){
	
		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);
		$field_names=array("tag_id","entry_type","date","number","dr_total","cr_total","narration");
		$field_data=array(1,$info['entry_type'],$info['entry_date'],$info['number'],$info['dr_total'],$info['cr_total'],$info['narration']);
		
		$result=$this->dbConnection->insert($field_names,$field_data,"entries");

		$insert_id = $this->dbConnection->mysqli_connect->insert_id;
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return $insert_id;
		else return 0;
	}
	
	function addEntryItems($info){
		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);
	
		$field_names=array("entry_id","ledger_id","amount","dc");
		$field_data=array($info['entry_id'],$info['ledger_id'],$info['amount'],$info['dc']);
		// var_dump($field_names,$field_data);
		$result=$this->dbConnection->insert($field_names,$field_data,"entry_items");

		$insert_id = $this->dbConnection->mysqli_connect->insert_id;
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return $insert_id;
		else return 0;
	}
	function getLedger($supplier_ledger_id){
	     
	        $select[0]="name";
		    $wheredata[0]="id=".$supplier_ledger_id;
			$query=$this->dbConnection->BuiltQuery('ledgers',$select,$wheredata,'id','desc','','0,1');
			$result=$this->dbConnection->executeQuery($query);
			
			if(mysqli_num_rows($result)>0){
						
				$row=$result -> fetch_assoc();
				
				$ledger_name=$row['name'];
					
				}
				else{
					$ledger_name=NULL;
				} 	

			$conf=new Config();
			$this->dbConnection=new DMLFunctions($conf);

			return $ledger_name;
	}
	public function getAccountingInfo($wheredata){
	
		$arrFieldList[0]= "a.`id`";
		$arrFieldList[1]= "a.`tag_id`";
		$arrFieldList[2]= "a.`entry_type`";
		$arrFieldList[3]= "a.`number`";
		$arrFieldList[4]= "a.`date`";
		$arrFieldList[5]= "a.`dr_total`";
		$arrFieldList[6]= "a.`cr_total`";
		$arrFieldList[7]= "a.`narration`";

		$arrFieldList[8]= "b.`id` as entries_id";
		$arrFieldList[9]= "b.`entry_id`";
		$arrFieldList[10]= "b.`ledger_id`";
		$arrFieldList[11]= "b.`amount`";
		$arrFieldList[12]= "b.`dc`";
		$arrFieldList[13]= "b.`reconciliation_date`";

		$arrTables[0] = "`entries` a";
       	$arrTables[1] = "`entry_items` b";
				
		$joinConditions[1] = "a.`id` = b.`entry_id`";

		if(!empty($wheredata)) {
			for($k=0;$k<count($wheredata);$k++){
				$selectConditions[]=$wheredata[$k];
			}
		}

        $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions,$selectConditions,'','b.`ledger_id`','ASC');
			
		$result=$this->dbConnection->executeQuery($query);

			if(mysqli_num_rows($result)>0){

				$i=0;

				while($row=mysqli_fetch_array($result)){
									
					for($k=0;$k<count($arrFieldList);$k++) {						
								
						$arrList[$i][$k]=$row[$k];

					}

					$i++;
						
				}
				
			}

			$conf=new Config();
			$this->dbConnection=new DMLFunctions($conf);

			return $arrList;

	}	
	function update_accounting($post){
	
 		date_default_timezone_set('Asia/Kolkata');

		$id=$post['id'];
			
		$user_id=$_SESSION['user_id'];

		$old_update=$this->dbConnection->idToValue("entries","update_history","id",$id);

		if(!empty($old_update)){

	        $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	    }
	    else{
	        $update_history = $user_id."|". date("d-m-Y H:i a");
		}

		$field_names=array("dr_total","cr_total","update_history");
		$field_data=array($post['amount'],$post['amount'],$update_history);
	
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"entries");
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return $id;
		else return 0;
	}
	function update_accounting_entries($post){
	
		$entry_id=$post['id'];

		$field_names=array("amount");
		$field_data=array($post['amount']);
	
		$result=$this->dbConnection->update($field_names,$field_data,"entry_id",$entry_id,"entry_items");
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return $id;
		else return 0;
	}
	function getAccountingInfoPurchase($wheredata){

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('entries','',$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['tag_id'];
				$arrList[$i][2]=$row['entry_type'];
				$arrList[$i][3]=$row['number'];
				$arrList[$i][4]=$row['date'];
				$arrList[$i][5]=$row['dr_total'];
				$arrList[$i][6]=$row['cr_total'];
				$arrList[$i][7]=$row['narration'];
				// $arrList[$i][8]=$row['update_history'];

				$i++;
			}
		
		}
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		return $arrList;

	}

	function getEntryId($wheredata){

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('entries','',$wheredata,'id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i]=$row['id'];

				$i++;
			}
		
		}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		return $arrList;

	}
	function deleteEntry($id){

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);
	
		$where[0]="id ='".$id."'";
		$result=$this->dbConnection->deletePermenantly($where,"entries");
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		
		if($result) return true;
		else return false;
	}
	function deleteEntryItems($entry_id){

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);
	
		$where[0]="entry_id ='".$entry_id."'";
		$result=$this->dbConnection->deletePermenantly($where,"entry_items");
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return true;
		else return false;
	}
	function getLedgers(){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("ledgers","","","name","asc");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['group_id'];
					$arrList[$i][2]=$row['name'];
					$arrList[$i][3]=$row['op_balance'];
					$arrList[$i][4]=$row['op_balance_dc'];
					$arrList[$i][5]=$row['type'];
					$arrList[$i][6]=$row['reconciliation'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getEntries($wheredata_entry){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("entries","",$wheredata_entry,"","");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['tag_id'];
					$arrList[$i][2]=$row['entry_type'];
					$arrList[$i][3]=$row['number'];
					$arrList[$i][4]=$row['date'];
					$arrList[$i][5]=$row['dr_total'];
					$arrList[$i][6]=$row['cr_total'];
					$arrList[$i][7]=$row['narration'];
					$arrList[$i][8]=$row['update_history'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getEntriesItems($entry_id){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
		$query="select sum(amount) as amounts from `entry_items` where `entry_id`='".$entry_id."'";
		$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList=$row['amounts'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function updatePurchaseAmount($entry_id,$purchase_amount,$ledger_id){
	

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

		$query="update entry_items set amount = '".$purchase_amount."' where entry_id='".$entry_id."' and ledger_id = '".$ledger_id."'";
		$result=$this->dbConnection->executeQuery($query);
		
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		if($result) return 1;
		else return 0;
	}
	function getSettings(){

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

		$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('settings','','','id','desc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=mysqli_fetch_array($result)){
			
				$arrList=$row;

				// $i++;
			}
		
		}
	
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

		return $arrList;

	}
	function getGroupInfo($wheredata=NULL,$select=NULL){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("`groups`","","","","");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=mysqli_fetch_array($result)){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['parent_id'];
					$arrList[$i][2]=$row['name'];
					$arrList[$i][3]=$row['affects_gross'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getEntryInfo(){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("entry_types","","","","");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=mysqli_fetch_array($result)){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['label'];
					$arrList[$i][2]=$row['name'];
					$arrList[$i][3]=$row['description'];
					$arrList[$i][4]=$row['base_type'];
					$arrList[$i][5]=$row['numbering'];
					$arrList[$i][6]=$row['prefix'];
					$arrList[$i][7]=$row['suffix'];
					$arrList[$i][8]=$row['zero_padding'];
					$arrList[$i][9]=$row['bank_cash_ledger_restriction'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getTagInfo(){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("tags","","","","");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=mysqli_fetch_array($result)){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['title'];
					$arrList[$i][2]=$row['color'];
					$arrList[$i][3]=$row['background'];

					$i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getDrTotal($ledger_id){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();

			$query = "SELECT SUM(`amount`) AS drtotal FROM (`entry_items`) JOIN `entries` ON `entries`.`id` = `entry_items`.`entry_id` WHERE `entry_items`.`ledger_id` = '".$ledger_id."' AND `entry_items`.`dc` = 'D'";

			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=mysqli_fetch_array($result)){
				
					$arrList=$row['drtotal'];

					// $i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}
	function getCrTotal($ledger_id){
	     

		$conf=new Config_accounting();
		$this->dbConnection=new DMLFunctions($conf);

			$arrList=array();

			$query = "SELECT SUM(`amount`) AS crtotal FROM (`entry_items`) JOIN `entries` ON `entries`.`id` = `entry_items`.`entry_id` WHERE `entry_items`.`ledger_id` = '".$ledger_id."' AND `entry_items`.`dc` = 'C'";

			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=mysqli_fetch_array($result)){
				
					$arrList=$row['crtotal'];

					// $i++;
				}	
			}

		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);

			return $arrList;
	}




}
?>
