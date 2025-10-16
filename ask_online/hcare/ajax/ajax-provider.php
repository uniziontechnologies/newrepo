<?php session_start();


define('ROOT_PATH', $_SESSION['path']);
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


$conf=new Config();
$dbConnection=new DMLFunctions($conf);

if(isset($_GET['getMedicines']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$letters=str_replace("%20", " ", $letters);

	$wheredata[0]="(brand like '".$letters."%' or generic_name like '".$letters."%')";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_pharma_brand",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){

              $stock =0;
			  $stock =$inf["brand_stock"]+$inf["branch_stock"];

              if($stock > '0'){
                
                if($stock <= '10'){

              	    $brand_status="<span class='glyphicon glyphicon-ok' style='color:#d8ca5f;'></span>";

              	}else{

              	    $brand_status="<span class='glyphicon glyphicon-ok text-success'></span>";

              	}

              }else{

                 $brand_status="<span class='glyphicon glyphicon-remove text-danger'></span>";

              }

				echo $inf["id"]."###".$inf["brand"]."(".$inf["generic_name"].") $brand_status"."|";
			}
		}
	
}
if(isset($_GET['getMedCourse']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	// $selectData[0]="distinct course";
	
	$wheredata[0]="course like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_medicine_course",'',$wheredata,'course','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["course"]."|";
			}
		}


}
if(isset($_GET['getProcedures']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="(category_id != 2 AND category_id != 3 AND category_id != 16)";
	$wheredata[2]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}

if(isset($_GET['getNormalProcedures']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =1";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}

if(isset($_GET['getTheatreProcedure']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =4";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}
if(isset($_GET['getLabtest']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="test_name like '%".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_lab_element",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."LE".$inf["category"]."###".$inf["test_name"]."|";
			}
		}
		
	$wheredata[0]="test_name like '%".$letters."%'";
	$wheredata[1]="status =0";
	$query=$dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."LT".$inf["category"]."###".$inf["test_name"]."|";
			}
		}
		
}		
if(isset($_GET['getBillParticulars']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	
	
	$wheredata[0]="test_name like '%".$letters."%'";
	$wheredata[1]="status =0";

	
	if($_SESSION['user_type'] == "ADMIN" || $_SESSION['user_type'] == "ADMIN+DOCTOR"){
	
	  $query=$dbConnection->BuiltQuery("hcare_lab_element",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "LE -".$inf["id"]."###".$inf["test_name"]."|";
			}
		}
		
	$wheredata[0]="test_name like '%".$letters."%'";
        $wheredata[1]="status =0";
	$query=$dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "LT -".$inf["id"]."###".$inf["test_name"]."|";
			}
		}
		
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}
	}else if($_SESSION['user_type'] == "LAB ADMIN" || $_SESSION['user_type'] == "LAB USER"){
	
	$query=$dbConnection->BuiltQuery("hcare_lab_element",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "LE -".$inf["id"]."###".$inf["test_name"]."|";
			}
		}
		
	$wheredata[0]="test_name like '%".$letters."%'";
	$wheredata[1]="status =0";
	$query=$dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "LT -".$inf["id"]."###".$inf["test_name"]."|";
			}
		}




	$wheredata=array();	
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}






	}else if($_SESSION['user_type'] == "XRAY"){
	
	 $letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =2 or category_id=6";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
	}else{	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
    $wheredata[2]="(category_id !=4 and category_id !=6)";
	

	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	$wheredata=array();	
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}
	}
	
	
}
if(isset($_GET['getPlace']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$selectData[0]="distinct place";
	
	$wheredata[0]="place like '".$letters."%'";
	
	$query=$dbConnection->BuiltQuery("hcare_op_patient_info",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
	if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "0"."###".$inf["place"]."|";
			}
	}
	
}
if(isset($_GET['getIPBillParticulars']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$selectData[0]="distinct particulars";
	
	$wheredata[0]="particulars like '".$letters."%'";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_bill_items",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
	if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "0"."###".$inf["particulars"]."|";
			}
	}
	
}
if(isset($_GET['getEmployee']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$selectData[0]="id,title,first_name,last_name";
	
	$wheredata[0]="first_name like '".$letters."%'";
	
	$query=$dbConnection->BuiltQuery("hcare_emp_info",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
	if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
			
			           

                               if(!empty($inf['title'])) $name=$inf['title'].".".$inf['first_name']." ".$inf['last_name'];
                               else $name=$inf['first_name']." ".$inf['last_name'];

				echo $inf["id"]."###".$name."|";
			}
	}
	
}
if(isset($_GET['getEmployeeNotUser']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$selectData[0]="id,title,first_name,last_name";
	
	$wheredata[0]="first_name like '".$letters."%'";
	$wheredata[1]="status=0";
	
	$query=$dbConnection->BuiltQuery("hcare_emp_info",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
	if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
			
			   $select[0]="id";
	                   $where[0]="employee_id =".$inf["id"];
			   $where[1]="status=0";
			   
	                   $query1=$dbConnection->BuiltQuery("hcare_users",$select,$where);	
	                   $result1=$dbConnection->executeQuery($query1);
                          
			 if(mysqli_num_rows($result1)==0){
						  
                               if(!empty($inf['title'])) $name=$inf['title'].".".$inf['first_name']." ".$inf['last_name'];
                               else $name=$inf['first_name']." ".$inf['last_name'];

			       echo $inf["id"]."###".$name."|";
			}
		}
	}
	
}

if(isset($_GET['getRadiology']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="(category_id = 2 or category_id = 3 or category_id = 18)";
	$wheredata[2]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}

if(isset($_GET['getDrPrescription']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$selectData[0]="distinct procedure_name";
	
	$wheredata[0]="procedure_name like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure_prescribed",$selectData,$wheredata,'procedure_name','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["procedure_name"]."|";
			}
		}
	
}

if(isset($_GET['getComplaints']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct complaints";
	
	$wheredata[0]="complaints like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_presenting_complaints",$selectData,$wheredata,'complaints','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["complaints"]."|";
			}
		}


}

if(isset($_GET['getDuration']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct duration";
	
	$wheredata[0]="duration like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_presenting_complaints",$selectData,$wheredata,'duration','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["duration"]."|";
			}
		}


}

if(isset($_GET['getPasthistory']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct past_history";
	
	$wheredata[0]="past_history like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_past_history",$selectData,$wheredata,'past_history','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["past_history"]."|";
			}
		}


}


if(isset($_GET['getDiagnosis']) && isset($_GET['letters'])){

 $i=0;
	$letters = $_GET['letters'];

	$selectData[0]="distinct diagnosis";
	
	$wheredata[0]="diagnosis like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_provisional_diagnosis",$selectData,$wheredata,'diagnosis','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["diagnosis"]."|";
				$arrayList[$i]=$inf["diagnosis"];
				$i++;
			}
		}

	
	$selectData[0]="code";
	$selectData[1]="disease";
	
	$wheredata[0]="(disease like '".$letters."%' or code like '".$letters."%')";
	$wheredata[1]="(CONCAT(code,' ', disease) not in ('".implode(',',$arrayList)."'))";
	$wheredata[2]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_icd10",$selectData,$wheredata,'id','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				$disease = $inf["code"].' '.$inf["disease"];
				echo $inf["id"]."###".$disease."|";
			}
		}


}

if(isset($_GET['getFollowup']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct followup";
	
	$wheredata[0]="followup like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_followup_date",$selectData,$wheredata,'followup','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["followup"]."|";
			}
		}


}



/*if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysql_query("select * from ".$cfg_tableprefix."items inner join sale_department_stock on sale_department_stock.brand_id=sale_items.id where brand like '".$letters."%' AND sale_department_stock.item_count>0 order by brand") or die(mysql_error());
//echo $res;

	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysqli_fetch_array($res)){
		echo $inf["id"]."###".$inf["brand"]."|";
	}	
}*/



if(isset($_GET['getBillParticularsReceptionAll']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	// $wheredata[2]="(category_id !=2 and category_id !=4 and category_id !=6)";

	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	$wheredata=array();	
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}
	
	
	
}


if(isset($_GET['getBillParticularsReceptionXray']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =2";

	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	$wheredata=array();	
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}
	
	
	
}


if(isset($_GET['getBillParticularsReceptionProcedure']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="(category_id !=2 and category_id !=4)";

	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	$wheredata=array();	
	$wheredata[0]="package_name like '".$letters."%'";
	$wheredata[1]="status =0";

	

	$query=$dbConnection->BuiltQuery("hcare_healthcheckup_package",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "PACKAGE -".$inf["id"]."###".$inf["package_name"]."|";
			}
		}
	
	
	
}

if(isset($_GET['getTheatreProcedureConsumable']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =17";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}

if(isset($_GET['getTheatreProcedureAll']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$wheredata[0]="procedure_test like '".$letters."%'";
	$wheredata[1]="status =0";
	$wheredata[2]="category_id =4 or category_id =17";
	
	$query=$dbConnection->BuiltQuery("hcare_procedure",'',$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo "P -".$inf["id"]."###".$inf["procedure_test"]."|";
			}
		}
	
}


if(isset($_GET['get_ip_DrPrescription']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$selectData[0]="distinct procedure_name";
	
	$wheredata[0]="procedure_name like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_procedure_prescribed",$selectData,$wheredata,'procedure_name','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["procedure_name"]."|";
			}
		}
	
}

if(isset($_GET['get_ip_Complaints']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct complaints";
	
	$wheredata[0]="complaints like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_presenting_complaints",$selectData,$wheredata,'complaints','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["complaints"]."|";
			}
		}


}

if(isset($_GET['get_ip_Duration']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct duration";
	
	$wheredata[0]="duration like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_presenting_complaints",$selectData,$wheredata,'duration','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["duration"]."|";
			}
		}


}

if(isset($_GET['get_ip_Pasthistory']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	$selectData[0]="distinct past_history";
	
	$wheredata[0]="past_history like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_past_history",$selectData,$wheredata,'past_history','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["past_history"]."|";
			}
		}


}


if(isset($_GET['get_ip_Diagnosis']) && isset($_GET['letters'])){

 $i=0;
	$letters = $_GET['letters'];

	$selectData[0]="distinct diagnosis";
	
	$wheredata[0]="diagnosis like '".$letters."%'";
	$wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_provisional_diagnosis",$selectData,$wheredata,'diagnosis','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["diagnosis"]."|";
				$arrayList[$i]=$inf["diagnosis"];
				$i++;
			}
		}

	
	$selectData[0]="code";
	$selectData[1]="disease";
	
	$wheredata[0]="(disease like '".$letters."%' or code like '".$letters."%')";
	$wheredata[1]="(CONCAT(code,' ', disease) not in ('".implode(',',$arrayList)."'))";
	$wheredata[2]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_icd10",$selectData,$wheredata,'id','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				$disease = $inf["code"].' '.$inf["disease"];
				echo $inf["id"]."###".$disease."|";
			}
		}


}

if(isset($_GET['getMedDays']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	// $selectData[0]="distinct med_days";
	
	$wheredata[0]="med_days like '".$letters."%'";
	$wheredata[1]="status = 0";
	$wheredata[2]="wrong = 0";
	$wheredata[3]="id IN (SELECT MIN(id) FROM hcare_medicine_prescribed GROUP BY med_days)";
	
	$query=$dbConnection->BuiltQuery("hcare_medicine_prescribed",'',$wheredata,'med_days','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["med_days"]."|";
			}
		}


}

if(isset($_GET['getExamination']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	// $selectData[0]="distinct med_days";
	
	$wheredata[0]="examination like '".$letters."%'";
	$wheredata[1]="cancelled = 0";
	
	$query=$dbConnection->BuiltQuery("hcare_op_visit_info",'',$wheredata,'id','desc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["examination"]."|";
			}
		}


}

if(isset($_GET['getAdvice']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	// $selectData[0]="distinct med_days";
	
	$wheredata[0]="dr_advice like '".$letters."%'";
	$wheredata[1]="cancelled = 0";
	
	$query=$dbConnection->BuiltQuery("hcare_op_visit_info",'',$wheredata,'id','desc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["dr_advice"]."|";
			}
		}


}

if(isset($_GET['getIpMedDays']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	// $selectData[0]="distinct med_days";
	
	$wheredata[0]="med_days like '".$letters."%'";
	$wheredata[1]="status = 0";
	// $wheredata[2]="wrong = 0";
	$wheredata[2]="id IN (SELECT MIN(id) FROM hcare_ip_medicine_prescribed GROUP BY med_days)";
	
	$query=$dbConnection->BuiltQuery("hcare_ip_medicine_prescribed",'',$wheredata,'med_days','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["med_days"]."|";
			}
		}


}



if(isset($_GET['getReferalDoctor']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];

	$selectData[0]="distinct refferal_info";
	
	$wheredata[0]="refferal_info LIKE '%".$letters."%'";
	$wheredata[1]="status =0";
	// $wheredata[2]="category_id =1";
	
	$query=$dbConnection->BuiltQuery("hcare_direct_customer",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["refferal_info"]."|";
			}
		}
	
}

if(isset($_GET['getDoctors']) && isset($_GET['letters'])){

	$letters = $_GET['letters'];
	
	$selectData[0]="id,title,first_name,last_name";
	
	$wheredata[0]="first_name like '".$letters."%'";
	$wheredata[1]="status = 0";
	$wheredata[2]="title = 'Dr'";
	
	$query=$dbConnection->BuiltQuery("hcare_emp_info",$selectData,$wheredata);	
	$result=$dbConnection->executeQuery($query);
	if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
			
			           

                               if(!empty($inf['title'])) $name=$inf['title'].".".$inf['first_name']." ".$inf['last_name'];
                               else $name=$inf['first_name']." ".$inf['last_name'];

				echo $inf["id"]."###".$name."|";
			}
	}
	
}


if(isset($_GET['getDrug']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	 $selectData[0]="distinct drug";
	
	$wheredata[0]="drug like '".$letters."%'";
	// $wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_own_medicines",$selectData,$wheredata,'drug','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["drug"]."|";
			}
		}


}

if(isset($_GET['getDose']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	 $selectData[0]="distinct dose";
	
	$wheredata[0]="dose like '".$letters."%'";
	// $wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_own_medicines",$selectData,$wheredata,'dose','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["dose"]."|";
			}
		}


}
if(isset($_GET['getRoute']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

	 $selectData[0]="distinct route";
	
	$wheredata[0]="route like '".$letters."%'";
	// $wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_own_medicines",$selectData,$wheredata,'route','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["route"]."|";
			}
		}


}
if(isset($_GET['getFrequency']) && isset($_GET['letters'])){

 
	$letters = $_GET['letters'];

 $selectData[0]="distinct frequency";
	
	$wheredata[0]="frequency like '".$letters."%'";
	// $wheredata[1]="status =0";
	
	$query=$dbConnection->BuiltQuery("hcare_own_medicines",$selectData,$wheredata,'frequency','asc');	
	$result=$dbConnection->executeQuery($query);
			
		if(mysqli_num_rows($result)>0){
		
			while($inf = mysqli_fetch_array($result)){
				echo $inf["id"]."###".$inf["frequency"]."|";
			}
		}


}




?>
