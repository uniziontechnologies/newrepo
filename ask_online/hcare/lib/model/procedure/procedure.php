<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class Procedure{

	var $dbConnection;
	var $field_names=array("id","category_id","procedure_test","total","amount","dr_amount","description","status");
	var $tablename="hcare_procedure";
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function addProcedure($post){

	   if (empty($post['price_type'])) {
	   	  $post['price_type']="NO";
	   }
	
	   if($post['category'] ==4){
	     //theatre procedure
		 $total=$post['amount']+$post['surgeon_fee']+$post['assistant_fee1']+$post['assistant_fee2']+$post['anethesia_charge']+$post['theatre_charge']+$post['other_charges'];
		 
		 $fields=array("id","category_id","procedure_test","total","amount","surgeon_fee","assistant_fee1","assistant_fee2","theatre_charge","anasthesia","other_charges","description","status","price_type");
		 $field_data=array("",$post['category'],$post['procedure'],$total,$post['amount'],$post['surgeon_fee'],$post['assistant_fee1'],$post['assistant_fee2'],$post['theatre_charge'],$post['anethesia_charge'],$post['other_charges'],$post['description'],0,$post['price_type']);
		 
	   }elseif($post['category_name'] =='LABOUR CHARGES'){

	   	 $total=$post['gynec_fee']+$post['room_charges'];

		 $fields=array("id","category_id","procedure_test","gynec_fee","room_charges","total","description","status","price_type");

		 $field_data=array("",$post['category'],$post['procedure'],$post['gynec_fee'],$post['room_charges'],$total,$post['description'],0,$post['price_type']);

	   }else{
	   
		$total=$post['amount']+$post['dr_amount'];
		$fields=array("id","category_id","procedure_test","total","amount","dr_amount","description","status","price_type");
		$field_data=array("",$post['category'],$post['procedure'],$total,$post['amount'],$post['dr_amount'],$post['description'],0,$post['price_type']);
	  }
		
		
		$result=$this->dbConnection->insert($fields,$field_data,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function updateProcedure($post){

	   if (empty($post['price_type'])) {
	   	  $post['price_type']="NO";
	   }
	
		$id=$post['id'];		
		 if($post['category'] ==4){
	     //theatre procedure
		 $total=$post['amount']+$post['surgeon_fee']+$post['assistant_fee1']+$post['assistant_fee2']+$post['anethesia_charge']+$post['theatre_charge']+$post['other_charges'];
		 
		 $fields=array("category_id","procedure_test","total","amount","surgeon_fee","assistant_fee1","assistant_fee2","theatre_charge","anasthesia","other_charges","description","status","price_type");
		 $field_data=array($post['category'],$post['procedure'],$total,$post['amount'],$post['surgeon_fee'],$post['assistant_fee1'],$post['assistant_fee2'],$post['theatre_charge'],$post['anethesia_charge'],$post['other_charges'],$post['description'],0,$post['price_type']);
		 
	   }elseif($post['category_name'] =='LABOUR CHARGES'){

	   	 $total=$post['gynec_fee']+$post['room_charges'];

		 $fields=array("category_id","procedure_test","gynec_fee","room_charges","total","description","status","price_type");

		 $field_data=array($post['category'],$post['procedure'],$post['gynec_fee'],$post['room_charges'],$total,$post['description'],0,$post['price_type']);

	   }else{
	   
		$total=$post['amount']+$post['dr_amount'];
		$fields=array("category_id","procedure_test","total","amount","dr_amount","description","status","price_type");
		$field_data=array($post['category'],$post['procedure'],$total,$post['amount'],$post['dr_amount'],$post['description'],0,$post['price_type']);
	  }
		
		
		$result=$this->dbConnection->update($fields,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	
	}
	function deleteProcedure($post){
	
		$id=$post['id'];
		
		$field_names1=array('status');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,$this->tablename);
		
		if($result) return true;
		else return false;
	}
	function getProcedure($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery($this->tablename,$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=$result -> fetch_assoc()){
					
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$this->dbConnection->idToValue("hcare_procedure_category","category","id",$row['category_id']);
						$arrList[$i][2]=$row['category_id'];
						
						$arrList[$i][3]=$row['procedure_test'];
						$arrList[$i][4]=$row['total'];
						$arrList[$i][5]=$row['amount'];
						$arrList[$i][6]=$row['dr_amount'];
						$arrList[$i][7]=$row['description'];
						$arrList[$i][8]=$row['status'];
						$arrList[$i][9]=$row['surgeon_fee'];
						$arrList[$i][10]=$row['anasthesia'];
						$arrList[$i][11]=$row['theatre_charge'];
						$arrList[$i][12]=$row['other_charges'];
						$arrList[$i][13]=$row['assistant_fee1'];
						$arrList[$i][14]=$row['assistant_fee2'];
						$arrList[$i][15]=$row['price_type'];
						$arrList[$i][16]=$row['gynec_fee'];
						$arrList[$i][17]=$row['room_charges'];
						
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

	
}


?>
