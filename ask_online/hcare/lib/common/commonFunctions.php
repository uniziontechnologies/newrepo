<?php //session_start();


class CommonFunctions{
	
	function getcurrentTime($format=null){
	
	     date_default_timezone_set('Asia/Calcutta');
		
		if(!empty($format)){
			$time=date("$format");
		}else $time=date("H:i:s");
		
		return $time;
	
	}
	function getcurrentDate($format=null,$date = null){
	
	date_default_timezone_set('Asia/Calcutta');
	
		
		if(!empty($format) && !empty($date)){
			$date=date("$format",strtotime($date));
		}else if(!empty($format)){
			$date=date("$format");
		}else $date=date("Y-m-d");
		
		return $date;
	
	}
	
	
	function gettimeOPtionValues($selected = null){
	
	
		echo "<option value=''></option>";
										
										
		for ($x = 12; $x < 45; $x++) { 											 
											 
			if ($selected == date("g:i a", mktime(0, $x * 30, 0, 0, 0))) {
			 echo "<option selected='selected' value='" . date("g:i a", mktime(0, $x * 30, 0, 0, 0)) . "'>" . date("g:i a", mktime(0, $x * 30, 0, 0, 0)) . "</option>"; 
			}
   			else {
 			  echo "<option value='" . date("g:i a", mktime(0, $x * 30, 0, 0, 0)) . "'>" . date("g:i a", mktime(0, $x * 30, 0, 0, 0)) . "</option>";
  			}
 		}
 										
	
	}
	function getRegPrefix($cust_type = null){
	
	$year=date("y");
	 //prefix
	   $user_type=$_SESSION['user_type'];
	   if($cust_type=='DIRECT'){
	     $prefix="JN/C/".$year;
	   }else if($user_type == 'CASUALITY'){
			
	        $prefix="JN/CA/".$year;
	   }else $prefix="JN/G/".$year;
					
	   return $prefix;
	
	}
	


}


?>