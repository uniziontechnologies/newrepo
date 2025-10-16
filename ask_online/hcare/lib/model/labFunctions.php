<?php 
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


class LabFunctions{

	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function getCountries(){
	
			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("hcare_countries");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['country'];
					$i++;
				}	
			}
			
			return $arrList;
	}
	
	function getLabTest(){
	
	         $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_test");	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['testName'];
			$arrList[$i][2]=$row['Price'];
			$arrList[$i][3]=$row['catId'];
			$arrList[$i][4]=$row['meterial'];
			$arrList[$i][5]=$row['outside'];
			$i++;
		   }	
		}
			
	  return $arrList;
	
	}
	function getLabElements(){
	
	         $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_element");	
		 $result=$this->dbConnection->executeQuery($query);
			
		 $i=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$i][0]=$row['id'];
			$arrList[$i][1]=$row['test_name'];
			$arrList[$i][2]=$row['price'];
			$arrList[$i][3]=$row['category'];
			
			$i++;
		   }	
		}
			
	  return $arrList;
	
	}
	function getLabResult($wheredata){
	
	          $arrList=array();
	         $query=$this->dbConnection->BuiltQuery("hcare_lab_result_entry",'',$wheredata,'id','asc');
		 $result=$this->dbConnection->executeQuery($query);
			
		 $k=0;
		
		if(mysqli_num_rows($result)>0){
						
		   while($row=$result -> fetch_assoc()){
				
			$arrList[$k][0]=$row['test_name'];
			$arrList[$k][1]=$row['result'];
			$arrList[$k][2]=$row['normal'];
			$arrList[$k][3]=$row['unit'];
			$arrList[$k][4]=$row['type'];
			$arrList[$k][5]=$row['id'];
			$arrList[$k][6]=$row['catid'];
			$arrList[$k][7]=$row['nrml'];
			
			$k++;
		   }	
		}
			
	  return $arrList;
	
	}

}
?>