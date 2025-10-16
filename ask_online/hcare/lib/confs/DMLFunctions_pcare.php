<?php
class DMLFunctions_pcare{

	var $myHost; // server name
	var $myHostPort;
	var $userName; //db user
	var $userPassword; // db user password
	var $db_name; // database name
	var $conn; // database connection
	
	function __construct($conf) {

		$this->myHost 		= $conf ->dbhost; //reference for the Host
		$this->myHostPort	= $conf ->dbport;
		$this->userName 	= $conf ->dbuser; //reference for the Username
		$this->userPassword = $conf ->dbpass; //reference for the Password
		$this->db_name 		= $conf ->dbname; //reference for the DatabaseName
		$this->branch_id    = $conf ->branch_id;

		$this->dbConnect_pcare();
	}
	function dbConnect_pcare() {
			

			if (!@$this -> conn = mysql_connect($this->myHost .':'.$this->myHostPort, $this->userName, $this->userPassword)) {

				trigger_error("NO database Connection found", E_USER_ERROR);
			}else {

	  	 		if ($this -> conn) {
					if (mysql_select_db ($this->db_name)) {

		 	   			 return true;
		 			} else {
						trigger_error("NO database Connection found", E_USER_ERROR);
					}
				}else{
						trigger_error("NO database Connection found", E_USER_ERROR);
				}
	
	
			}
		
	}
	function BuiltQuery_pcare($tablename,$selectfield = null,$whereField = null,$orderbyfield = null,$orderby = null,$group_by=null,$selectLimit = null){
			
			if(empty($selectfield)){
				
				$query="select * from $tablename ";
			}else{
				$query="select ";
				for($i=0;$i<count($selectfield);$i++){
					
					if($i == count($selectfield)-1){
						$query .= $selectfield[$i];
					}else{
						$query .= $selectfield[$i].",";
					}
				}
				$query .=" from $tablename ";
			}
			
			if(!empty($whereField)){
				$query .= "where ";
			
				for($i=0;$i<count($whereField);$i++){
					if($i == count($whereField)-1){
						
							$query .= $whereField[$i];
						
					}else{
						
							$query .= $whereField[$i]." and ";
						
					}
				
				}
				
			}
			if(!empty($group_by)){
				$query .= " group by ";
			
				for($i=0;$i<count($group_by);$i++){
					if($i == count($group_by)-1){
						
							$query .= $group_by[$i];
						
					}else{
						
							$query .= $group_by[$i].",";
						
					}
				
				}
				
			}
			if(!empty($orderbyfield)){
			
				$query .=" order by ".$orderbyfield." ";			
			}
			if(!empty($orderby)){
			
				$query .= $orderby;			
			}
			if (!empty($selectLimit)) {
			   $query .= " LIMIT $selectLimit";
		   }
			//echo $query."<br>";
			
			return $query;
	}

	function executeQuery_pcare($query){
	
		//echo $query;
		$result=mysql_query($query);
		if(!$result) {
				echo $query;
				
				trigger_error("Query Error", E_USER_ERROR);
		}
		return $result;
	
	}

	function idToValue_pcare($tablename,$field,$where,$value){
	
		//echo "SELECT $field FROM $tablename WHERE $where=\"$value\"";
		$result = mysql_query("SELECT $field FROM $tablename WHERE $where=\"$value\"");
		if(!$result) trigger_error("Field Does Not Exist", E_USER_ERROR);
		$row = $result -> fetch_assoc();
		return $row[$field];
	}
	function update_pcare($field_names,$field_data,$update_field,$update_value,$tablename){
		
			$query="UPDATE $tablename SET $field_names[0]=\"$field_data[0]\"";
			
			for($k=1;$k< count($field_names);$k++){
			
				$query.=', '."$field_names[$k]=\"$field_data[$k]\"";		
			}
			
		    $query.=" WHERE $update_field=\"$update_value\"";
		    
		    // echo $query; 
		  
			$result=$this->executeQuery_pcare($query);;
			
			
			
			return $result;
	
	}




}



?>
