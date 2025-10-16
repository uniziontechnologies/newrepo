<?php
class DMLFunctions{

	var $myHost; // server name
	var $myHostPort;
	var $userName; //db user
	var $userPassword; // db user password
	var $db_name; // database name
	var $conn; // database connection
	var $mysqli_connect; // mysqli - database connection
	
	function __construct($conf) {

		$this->myHost 		= $conf ->dbhost; //reference for the Host
		$this->myHostPort	= $conf ->dbport;
		$this->userName 	= $conf ->dbuser; //reference for the Username
		$this->userPassword = $conf ->dbpass; //reference for the Password
		$this->db_name 		= $conf ->dbname; //reference for the DatabaseName

		$this->dbConnect();
	}
	function dbConnect() {
			

			// if (!@$this -> conn = mysql_connect($this->myHost .':'.$this->myHostPort, $this->userName, $this->userPassword)) {

			// 	trigger_error("NO database Connection found", E_USER_ERROR);
			// }else {

	  // 	 		if ($this -> conn) {
			// 		if (mysql_select_db ($this->db_name)) {

		 // 	   			 return true;
		 // 			} else {
			// 			trigger_error("NO database Connection found", E_USER_ERROR);
			// 		}
			// 	}else{
			// 			trigger_error("NO database Connection found", E_USER_ERROR);
			// 	}
	
	
			// }

			$this->mysqli_connect = $mysqli = new mysqli($this->myHost .':'.$this->myHostPort,$this->userName,$this->userPassword,$this->db_name);

			// Check connection
			if ($mysqli ->connect_errno) {
			  echo "Failed to connect to MySQL: " . $mysqli ->connect_error;
			  exit();
			}

		
	}
	function BuiltQuery($tablename,$selectfield = null,$whereField = null,$orderbyfield = null,$orderby = null,$group_by=null,$selectLimit = null){
		// echo 1111;exit;
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
	function selectFromMultipleTable($arrFields, $arrTables, $joinConditions, $selectConditions = null, $joinTypes = null, $selectOrderBy = null, $selectOrder = null, $selectLimit = null, $groupBy = null) {

		if (empty($joinTypes)) {
			$joinTypes = array_fill(1, count($arrTables)-1, "LEFT");
		}

		$query = $this->_buildSelect($arrFields);

		$query .= " FROM ";

		$joins = $arrTables[0];

		for ($i=1; $i < count($arrTables); $i++) {
			$joins = "( ".$joins." ".$joinTypes[$i]." JOIN ".$arrTables[$i]." ON ( ".$joinConditions[$i]." ) ) ";
		}

		$query .= $joins;

		if (isset($selectConditions)) {
			$query .= $this->_buildWhere($selectConditions);
		}

		if (isset($groupBy)) {
			$query .= " GROUP BY $groupBy";
		}

		if (isset($selectOrderBy)) {
			$query .= " ORDER BY $selectOrderBy $selectOrder";
		}

		if (!empty($selectLimit)) {
			$query .= " LIMIT $selectLimit";
		}
//echo $query;
		return $query;
	}
	function executeQuery($query){
	
		//echo $query;
		// $result=mysql_query($query);
		// if(!$result) {
		// 		echo $query;
				
		// 		trigger_error("Query Error", E_USER_ERROR);
		// }
		// return $result;

		// Perform query
		$result =  $this->mysqli_connect -> query($query);

		if(!$result) {
				echo $query;
				
				trigger_error("Query Error");
		}
		return $result;


	
	}
	function insert($field_names,$field_data,$tablename){
	
			$query = "INSERT INTO $tablename (`$field_names[0]`";
			
			for($k=1;$k< count($field_names);$k++){

				$query.=' , '."`$field_names[$k]`";		
			}
		
			$query.=") VALUES (\"$field_data[0]\"";
			for($k=1;$k< count($field_data);$k++){
			
			$query.=', '."\"$field_data[$k]\"";
		
			}
			
			$query.=')';
			$result=$this->executeQuery($query);			
			
			
			return $result;
	
	}
	function update($field_names,$field_data,$update_field,$update_value,$tablename){
		
			$query="UPDATE $tablename SET $field_names[0]=\"$field_data[0]\"";
			
			for($k=1;$k< count($field_names);$k++){
			
				$query.=', '."$field_names[$k]=\"$field_data[$k]\"";		
			}
			
		    $query.=" WHERE $update_field=\"$update_value\"";
		     
		  
			$result=$this->executeQuery($query);;
			
			
			
			return $result;
	
	}
	function deletePermenantly($where=null,$table){
	
		$query="delete from ".$table;

		// if(!empty($where)) $query .= " where ";
		// for($i=0;$i<count($where);$i++){
		// 	$query.= $where[$i];
		// 	if($i>0 && $i<(count($where)-1)){
		// 		$query.=" and ";
		// 	}
		// }
		//echo $query;
		
		if (!empty($where)) {
			$query .= " where ";
			for($i=0;$i<count($where);$i++){
				$query.= $where[$i];
				if($i>0 && $i<(count($where)-1)){
					$query.=" and ";
				}
			}
			
		}
		
		$result=$this->executeQuery($query);;		
			
			return $result;
	}

	function idToValue($tablename,$field,$where,$value){
	
		//echo "SELECT $field FROM $tablename WHERE $where=\"$value\"";
		// $result = mysql_query("SELECT $field FROM $tablename WHERE $where=\"$value\"");
		// if(!$result) trigger_error("Field Does Not Exist", E_USER_ERROR);
		// $row = $result -> fetch_assoc();
		// return $row[$field];

		$result = $this->mysqli_connect -> query("SELECT $field FROM $tablename WHERE $where=\"$value\"");
		if(!$result) trigger_error("Field Does Not Exist", E_USER_ERROR);
		$row=$result -> fetch_assoc();
		if($row){
		return $row[$field];
	}



	}
	function _buildWhere($selectConditions) {

		$query = "WHERE ".$this->_buildList($selectConditions, " AND ");

		return $query;
	}

	function _buildSelect($arrFields) {

		$query = "SELECT ".$this->_buildList($arrFields, " , ");

		return $query;
	}

	function _buildSet($arrFields, $arrValues) {

		$query = "SET ".$this->_buildFormattedList($arrFields, $arrValues, " = ", "", ",");

		return $query;
	}

	function _buildFormattedList($arrFields, $arrValues, $strJoiner, $strPrepend = "", $strAppend = "") {

		$query = "";

		for ($i=0; $i < count($arrFields); $i++) {
			$query .= sprintf(" %s %s %s %s %s ", $strPrepend, $arrFields[$i], $strJoiner, $arrValues[$i], $strAppend);
		}

		$query = $this->_trimLastChar($query, $strAppend);

		return $query;
	}
	function _buildList($arrList, $strJoiner=" , ") {

		$query = implode($strJoiner, $arrList);

		$query = $this->_trimLastChar($query, $strJoiner);

		return $query;

	}
	function _trimLastChar($subject, $strJoiner = " , ") {

		$str = preg_replace("/".$strJoiner."$/", "", trim($subject));

		return $str;
	}

	function idToValueMultiple($field,$where_field,$table){
	
		$query .= "SELECT $field FROM $table WHERE ";

		if (!empty($where_field)) {

			for($i=0;$i<count($where_field);$i++){

				if($i == ((count($where_field))-1)){
														
					$query .=$where_field[$i];
				}else{
					$query .=$where_field[$i]." and ";
				}

			}

		}

		// $result = mysql_query($query);
		// if(!$result) trigger_error("Field Does Not Exist", E_USER_ERROR);
		// $row = $result -> fetch_assoc();
		// return $row[$field];

		$result = $this->mysqli_connect -> query($query);
		if($result){

			$row=$result -> fetch_assoc();
			return $row[$field];

		}else{
			return null;
		} 

		
		
	}



}



?>
