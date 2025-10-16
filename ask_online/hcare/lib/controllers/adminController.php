<?php //session_start();


require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';
require_once ROOT_PATH . '/lib/model/admin/department.php';
require_once ROOT_PATH . '/lib/model/admin/designation.php';
require_once ROOT_PATH . '/lib/model/admin/speciality.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/insurance_company.php';
require_once ROOT_PATH . '/lib/model/admin/patient_category.php';
require_once ROOT_PATH . '/lib/model/admin/general.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';
require_once ROOT_PATH . '/lib/model/admin/accounting.php';

class AdminController {

	var $addSuccess="Added Successfully";
	var $addfailed="Failed To Add";
	var $updateSuccess="Updated Successfully";
	var $updatefailed="Failed To Update";
	var $deleteSuccess="Deleted Successfully";
	var $deletefailed="Failed To Delete";

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){
				case 'HospitalInfo'		:
											$hosp_obj= new HospitalInfo();
											$db_obj=new DBFunction();
											
											$form_creator ->popArr['hospitalInfo']=$hosp_obj->getHospitalInfo();
											$form_creator ->popArr['countries']=$db_obj->getCountries();
											
											$form_creator ->formPath ='/templates/admin/hospital/hospitalInfo.php';
											break;
				case 'User'				: 
											$user_obj=new User();
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
												
												$form_creator ->formPath ='/templates/admin/user/user_form.php';
												
												
												$form_creator ->popArr['user_type']=$user_obj->getUsertype();
												
												if($postArr['action']=="CREATE_PAGE"){
												
													$form_creator ->popArr['action']="ADD";
													
												}else {								
													
													
													$form_creator ->popArr['action']="UPDATE";
													
													$id=$postArr['id'];
													$wheredata[0]="id=".$id;
													
													$form_creator ->popArr['userInfo']=$user_obj->getUser('',$wheredata);
													
												}
											}else	{
												$k=0;
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){								
													
													
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['username'])){
													
														$message .= " USER NAME  -  ".$postArr['username'] ." ";
														$wheredata[$k]="user_name like '%".$postArr['username']."%'";
														
														$k++;
													}
													if(!empty($postArr['user_type'])){
													
														
														$data[0]="id='".$postArr['user_type']."'";
														$type=$user_obj->getUsertype($data);
														$message .= " &nbsp;USER TYPE -".$type[0][1];
														
														$wheredata[$k]="user_type ='".$postArr['user_type']."'";
														$k++;
													}
													$form_creator ->popArr['message']=$message;
												}
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
													
													$wheredata[$k]="id='".$postArr['id']."'";
													
												}	
													$wheredata[$k]="status = 0";
												$form_creator ->popArr['user_type']=$user_obj->getUsertype();
												$form_creator ->popArr['users']	=$user_obj->getUser('',$wheredata);
												$form_creator ->formPath ='/templates/admin/user/users.php';
											}
											
												
													break;
											
				case 'Department'	   :
				
											$dep_obj=new Department();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/admin/department/department_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['DepartmentInfo']=$dep_obj->getDepartment('',$wheredata);
													
													}
											
											}else{
											
												$k=0;
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['dep_name'])){
													
														$message .= " DEPARTMENT NAME  -  ".$postArr['dep_name'] ." ";
														
														$wheredata[$k]="department like '%".$postArr['dep_name']."%'";
														$k++;
													
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status = 0";
											
												$form_creator ->popArr['department']	=$dep_obj->getDepartment('',$wheredata);
												$form_creator ->formPath ='/templates/admin/department/departments.php';
											}
											
													break;
					case 'Designation'	   :
				
											$des_obj=new Designation();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/admin/job/designation_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['DesignationInfo']=$des_obj->getDesignation('',$wheredata);
													
													}
											
											}else{
											
												$k=0;
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
													
													$wheredata=array();
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['des_name'])){
													
														$message .= " DESIGNATION  -  ".$postArr['des_name'] ." ";
														
														$wheredata[$k]="designation like '%".$postArr['des_name']."%'";
														$k++;
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
													$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
													
												}
												$wheredata[$k]="status = 0";
												$form_creator ->popArr['DesignationInfo']	=$des_obj->getDesignation('',$wheredata);
												$form_creator ->formPath ='/templates/admin/job/designations.php';
											}
											
													break;
					case 'Speciality'	   :
				
											$spec_obj=new Speciality();
											$dep_obj=new Department();
											
											
											
											$form_creator ->popArr['department']=$dep_obj->getDepartment();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/admin/speciality/speciality_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['SpecialityInfo']=$spec_obj->getSpeciality('',$wheredata);
													
													}
													
											
												
													
											
											}else{
											
												$k=0;
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
													$likefield=array();
													$wheredata=array();
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['dep_id'])){
													
														$message .= " DEPARTMENT  -  ".$postArr['dep_id'] ." ";
														
														$wheredata[$k]="department_id = '".$postArr['dep_id']."'";
														$k++;
													}if(!empty($postArr['spec_name'])){
													
														$message .= " SPECIALITY  -  ".$postArr['spec_name'] ." ";
														
														$wheredata[$k]="speciality like '%".$postArr['spec_name']."%'";
														$k++;
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
													$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
													
												}
												$wheredata[$k]="status = 0";
												$form_creator ->popArr['SpecialityInfo']	=$spec_obj->getSpeciality('',$wheredata);
												$form_creator ->formPath ='/templates/admin/speciality/specialities.php';
											}
											
													break;
				case 'Employee':
										$spec_obj=new Speciality();
										$dep_obj=new Department();
										$des_obj=new Designation();
										$emp_obj=new Employee();
										$user_obj=new User();

										
										
																					
										$form_creator ->popArr['department']=$depInfo= $dep_obj->getDepartment();										
										$form_creator ->popArr['SpecialityInfo']	= $spec_obj->getSpeciality();
										$form_creator ->popArr['DesignationInfo']	= $des_obj->getDesignation();
										
										if(isset($postArr['paction']) && ($postArr['paction']=="CREATE_PAGE" || $postArr['paction']=="EDIT_PAGE")){
												
													$form_creator ->formPath ='/templates/admin/employee/employee_form.php';
											
													if($postArr['paction']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
														
														if(!empty($depInfo)){
														
															$wheredep[0]="department_id ='".$depInfo[0][0]."'";
															$wheredep[1]="status =0";
															$form_creator ->popArr['SpecialityInfo']	=$SpecialityInfo= $spec_obj->getSpeciality('',$wheredep);
															// var_dump($SpecialityInfo);exit;
															//$form_creator ->popArr['dep_id']	= $depInfo[0][0];
														}
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$is_field[0]="a.id ='".$id."'";
														
														$form_creator ->popArr['EmployeeInfo']=$empInfo=$emp_obj->getEmployee($is_field);
														$dep_id=$empInfo[0][10];
														
														$wheredep[0]="department_id ='".$dep_id."'";
														$wheredep[1]="status =0";
														
														
														$form_creator ->popArr['SpecialityInfo']= $spec_obj->getSpeciality('',$wheredep);
														
														$id=$postArr['id'];
													    $wheredata[0]="employee_id=".$id;
													
													    $form_creator ->popArr['userInfo']=$user_obj->getUser('',$wheredata);
														
														$wheredata[$k]="status = 0";
												        $form_creator ->popArr['user_type']=$user_obj->getUsertype();
													
													}
													
										           $form_creator ->popArr['post']=$postArr;
										}else{

												$where_data_search=array();
										
												if(isset($postArr['paction']) && ($postArr['paction']=="SEARCH")){
												
													if(isset($postArr['search_by'])){
														$searchby=$postArr['search_by'];
														
														if(!empty($postArr['search_for'])){
														
														  $search_for=$postArr['search_for'];
														}
													}

													

													if (!empty($searchby) && $searchby=="first_name" ) {
														
														$where_data_search[0]="first_name LIKE '%".$search_for."%'";

													}
													else if (!empty($searchby) && $searchby=="last_name" ) {
														
														$where_data_search[0]="last_name LIKE '%".$search_for."%'";

													}

												
												}


												$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($where_data_search);
												$userInfo=array();
												if(!empty($empInfo)){
													for($i=0;$i<count($empInfo);$i++){
														$empid=$empInfo[$i][0];
													    $wheredata[0]="employee_id=".$empid;
													
													    $userInfo[$i]=$user_obj->getUser('',$wheredata);
													}
												}
										        $form_creator ->popArr['userInfo']=$userInfo;

										        $form_creator ->popArr['post']=$postArr;
										        
												$form_creator ->formPath ='/templates/admin/employee/employees.php';
										}
										
												break;
								
				case 'Insurance'	:
										$ins_obj=new InsuranceCompany();
										$db_obj=new DBFunction();
										
										if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/admin/insurance_company/insurance_company_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
														$form_creator ->popArr['countries']=$db_obj->getCountries();
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$is_field[0]="a.id ='".$id."'";
														
														
														$form_creator ->popArr['countries']=$db_obj->getCountries();
														$form_creator ->popArr['InsuranceCompanyInfo']=$ins_obj->getInsCompany($is_field);
													
													}
											
											}else{
													$is_field= NULL ;
													if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
													
														$message ="SEARCH RESULT FOR:";
														
														if(!empty($postArr['ins_company'])){
													
														$message .= " INSURANCE COMPANY  -  ".$postArr['ins_company'] ." ";
														$is_field[0]="a.insurance_company like '%".$postArr['ins_company']."%'";
													
														
														}
														$form_creator ->popArr['message']=$message;
													}
												$form_creator ->popArr['InsuranceCompanyInfo']= $ins_obj->getInsCompany($is_field);
												$form_creator ->formPath ='/templates/admin/insurance_company/insurance_companies.php';
											}
											break;

				case 'patient_category'	: 
										 $pat_cat_obj=new PatientCategory();
										 $db_obj=new DBFunction();
										
										if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
												$form_creator ->formPath ='/templates/admin/patient_category/patient_category_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$is_field[0]="a.id ='".$id."'";
														
														
													    $form_creator ->popArr['PatientCategoryInfo']=$pat_cat_obj->getPatientCategoryInfo($is_field);
													
													}
											
											}
											//member category
											else if(isset($postArr['action']) && ($postArr['action']=="MEMBER" || $postArr['action']=="SEARCH_MEMBER" || $postArr['action']=="CLEAR_MEMBER")){
												
												$id=$postArr['id'];
												if($postArr['action']=='SEARCH_MEMBER' || $postArr['action']=="CLEAR_MEMBER"){
													$id = $postArr['category_id'];
												}
												$is_field[0]="a.id ='".$id."'";
												$form_creator ->popArr['PatientCategoryInfo']=$pat_cat_obj->getPatientCategoryInfo($is_field);
												$where[0]="a.category_id ='".$id."'";

												if($postArr['patient_id']){
													$where[]="a.patient_id ='".$postArr['patient_id']."'";
												}
												if($postArr['m_name']){
													$where[]="b.first_name like '%".$postArr['m_name']."%' or b.last_name like '%".$postArr['m_name']."%'";
												}
												if($postArr['age']){
													$where[]="b.age ='".$postArr['age']."'";
												}
												if($postArr['phone']){
													$where[]="b.contact ='".$postArr['phone']."'";
												}
												if($postArr['gender']){
													$where[]="b.gender ='".$postArr['gender']."'";
												}

										 		$form_creator ->popArr['CategoryMemberInfo']=$pat_cat_obj->CategoryMemberInfo($where);
										 		$form_creator ->popArr['Search']=$postArr;
												$form_creator ->formPath ='/templates/admin/patient_category/patient_category_member.php';	
											}


											else{
													$is_field= NULL ;
													if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
													
														$message ="SEARCH RESULT FOR:";
														
														if(!empty($postArr['pati_category'])){
													
														$message .= " INSURANCE COMPANY  -  ".$postArr['pati_category'] ." ";
														$is_field[0]="a.patient_category like '%".$postArr['pati_category']."%'";
													
														
														}
														$form_creator ->popArr['message']=$message;
													}
												$form_creator ->popArr['PatientCategoryInfo']= $pat_cat_obj->getPatientCategoryInfo($is_field);
												$form_creator ->formPath ='/templates/admin/patient_category/patient_category.php';
											}
											break;							
										
										
				case 'OPSettings'	:
											$gen_obj = new General();

											$form_creator ->popArr['opSettingsinfo']= $gen_obj->getOpSettings('','','id','desc');
											$form_creator ->formPath ='/templates/admin/general/op_settings.php';
											break;
											
				

				case 'accounting_reposting' :  

											$db_obj  = new DBFunction();
											$acc_obj=new AccountingModel();

											if (!empty($postArr['date'])) {
												$date = date("Y-m-d",strtotime($postArr['date']));
											}
											else{
												$date = date("Y-m-d");
											}
											
											$wheredata[0] = "a.`date` >= '".$date." 00:00:00'";
											$wheredata[1] = "a.`date` <= '".$date." 23:59:59'";
											$wheredata[2] = "b.`ledger_id` != 1";

											$accountingInfo = $acc_obj->getAccountingInfo($wheredata);

											$form_creator ->popArr['accountingInfo']= $accountingInfo;

											$collection_date = $date;

											$daily_collection=$this->daily_collection($collection_date);

											$form_creator ->popArr['daily_collection']= $daily_collection;

											$form_creator ->popArr['post']= $postArr;

											$form_creator ->formPath ='/templates/admin/accounting_reposting.php';

							                break;	
				case 'accounting_automise' :  

											$db_obj  = new DBFunction();
											$acc_mod_obj = new AccountingModel();
											$acc_obj = new Accounting();

											$ledgers =$acc_mod_obj->getLedgers();

											$accounting_details =$acc_obj->getAccountingAutomise();

											$form_creator ->popArr['ledgers']= $ledgers;

											if (!empty($message)) {
												$form_creator ->popArr['message']=$message;
											}


											$form_creator ->popArr['post']=$postArr;

											$form_creator ->popArr['accounting_details']=$accounting_details;

											$form_creator ->formPath ='/templates/admin/accounting_automise.php';

							                break;

				case 'accounting_automise_sales' :  

											$db_obj  = new DBFunction();
											$acc_mod_obj = new AccountingModel();
											$acc_obj = new Accounting();

											$ledgers =$acc_mod_obj->getLedgers();

											$accounting_details =$acc_obj->getAccountingAutomisePharmaSales();

											$form_creator ->popArr['ledgers']= $ledgers;

											if (!empty($message)) {
												$form_creator ->popArr['message']=$message;
											}


											$form_creator ->popArr['post']=$postArr;

											$form_creator ->popArr['accounting_details']=$accounting_details;

											$form_creator ->formPath ='/templates/admin/accounting_automise_sales.php';

							                break;


				case 'accounting_automise_purchase' :  

											$db_obj  = new DBFunction();
											$acc_mod_obj = new AccountingModel();
											$acc_obj = new Accounting();

											$ledgers =$acc_mod_obj->getLedgers();

											$accounting_details =$acc_obj->getAccountingAutomisePharmaPurchase();

											// var_dump($accounting_details);

											$form_creator ->popArr['ledgers']= $ledgers;

											if (!empty($message)) {
												$form_creator ->popArr['message']=$message;
											}


											$form_creator ->popArr['post']=$postArr;

											$form_creator ->popArr['accounting_details']=$accounting_details;

											$form_creator ->formPath ='/templates/admin/accounting_automise_purchase.php';

							                break;

				case 'accounting_automise_sales_return' :  

											$db_obj  = new DBFunction();
											$acc_mod_obj = new AccountingModel();
											$acc_obj = new Accounting();

											$ledgers =$acc_mod_obj->getLedgers();

											$accounting_details =$acc_obj->getAccountingAutomisePharmaSalesReturn();

											$form_creator ->popArr['ledgers']= $ledgers;

											if (!empty($message)) {
												$form_creator ->popArr['message']=$message;
											}


											$form_creator ->popArr['post']=$postArr;

											$form_creator ->popArr['accounting_details']=$accounting_details;

											$form_creator ->formPath ='/templates/admin/accounting_automise_sales_return.php';

							                break;


	//add new patientid under category						
				case 'add_member_category_patient_id':	$pat_cat_obj=new PatientCategory();
										 				$db_obj=new DBFunction();
										 				if($postArr['action'] && $postArr['action']=='ADD_MEMBER'){
										 					$addmember['id'] = $postArr['id'];
										 					$addmember['patient_ref_id'] = $postArr['patient_ref_id'];
										 				}
										 				$category_id = $postArr['category_id'];
										 				$is_field[0]="a.id ='".$category_id."'";
										 				$form_creator ->popArr['PatientCategoryInfo']=$pat_cat_obj->getPatientCategoryInfo($is_field);
										 				$form_creator ->popArr['addmember']=$addmember;
										 				
										 				$form_creator ->formPath ='/templates/admin/patient_category/add_member_category_patient_id.php';

														break;	
				case 'add_category_member' : $pat_cat_obj=new PatientCategory();
							 				$db_obj=new DBFunction();

							 				$id = $postArr['id'];
							 				$action = $postArr['action'];
							 				if($action=='ADD' || $action=='ADD_MEMBER'){
												$is_field[0]="a.id ='".$id."'";			
												$form_creator ->popArr['PatientCategoryInfo']=$pat_cat_obj->getPatientCategoryInfo($is_field);

								 				$patient_id=$db_obj->getidToValue("patient_id","patient_id",$postArr['patient_id'],"hcare_patient_category_ids");
								 				if($patient_id && $action!='ADD_MEMBER'){
								 					$form_creator ->popArr['message'] = "Patient id already exists...";
								 					$form_creator ->formPath ='/templates/admin/patient_category/add_member_category_patient_id.php';
								 				}
								 				else{							 					
								 					$result=$pat_cat_obj->addCategoryMember($postArr,$action);
								 					if($result)
								 						$message = "Member Added Successfully";
								 					if($action=='ADD'){
									 					$postArr['id']=$id;
												 		$postArr['action']="MEMBER";
												 		$this->viewPage('patient_category',$postArr,'',$message);									 
												 		$form_creator ->formPath ='/templates/admin/patient_category/patient_category_member.php';
												 	}else if($action=='ADD_MEMBER'){
									 					$postArr['id'] = $id;
										 				$postArr['action']="VIEW_MEMBER";
										 				$this->viewPage('patient_category_id_action',$postArr,'',$message);
										 				$form_creator ->formPath ='/templates/admin/patient_category/patient_category_ID_member.php';
												 	}

												}
											}else if($action=='EDIT'){	
												$result=$pat_cat_obj->updateMember($postArr,$id);
												if($result)
								 						$message = "Member Updated Successfully";
								 				$patient_id=$db_obj->getidToValue("patient_ref_id","id",$id,"hcare_patient_category_members");
								 				$postArr['id'] = $patient_id;
								 				$postArr['action']="VIEW_MEMBER";
								 				$this->viewPage('patient_category_id_action',$postArr,'',$message);
								 				$form_creator ->formPath ='/templates/admin/patient_category/patient_category_ID_member.php';
											}
											break;
				case 'patient_category_id_action' : $pat_cat_obj=new PatientCategory();
										 			$db_obj=new DBFunction();

													$id = $postArr['id'];
													$action = $postArr['action'];
													if($action == 'DELETE_ID'){
										 				$result=$pat_cat_obj->deleteCategoryID($id);
										 				if($result)
										 					$form_creator ->popArr['message'] = 'Deleted Successfully';
										 				$postArr['id']=$db_obj->getidToValue("category_id","id",$id,"hcare_patient_category_ids");
										 				$postArr['action']="MEMBER";
										 				$this->viewPage('patient_category',$postArr);
										 				$form_creator ->formPath ='/templates/admin/patient_category/patient_category_member.php';

													}else if($action == 'VIEW_MEMBER'){
														$is_field[]="a.id ='".$id."'";
										 				$form_creator ->popArr['CategoryMemberInfo']=$CategoryMemberInfo=$pat_cat_obj->CategoryMemberInfo($is_field);
										 				$form_creator ->popArr['category']=$db_obj->getidToValue("patient_category","id",$CategoryMemberInfo[0][10],"hcare_patient_category");
														$form_creator ->formPath ='/templates/admin/patient_category/patient_category_ID_member.php';
													}
													break;
				case 'patient_category_id_member_action' : $pat_cat_obj=new PatientCategory();
										 			$db_obj=new DBFunction();

													$id = $postArr['id'];
													$action = $postArr['action'];
													// var_dump($postArr);exit();
													if($action == 'DELETE_MEMBER'){
										 				$result=$pat_cat_obj->deleteMemberID($id);
										 				if($result)
										 					$form_creator ->popArr['message'] = 'Deleted Successfully';
										 				$patient_id=$db_obj->getidToValue("patient_ref_id","id",$id,"hcare_patient_category_members");
										 				$postArr['id'] = $patient_id;
										 				$postArr['action']="VIEW_MEMBER";
										 				$this->viewPage('patient_category_id_action',$postArr);
										 				$form_creator ->formPath ='/templates/admin/patient_category/patient_category_ID_member.php';

													}else if($action == 'EDIT_MEMBER'){
														$pat_cat_obj=new PatientCategory();
										 				$db_obj=new DBFunction();
										 				$category_id = $postArr['category_id'];
										 				$is_field[0]="b.id ='".$id."'";
										 				$form_creator ->popArr['MemberInfo']=$pat_cat_obj->CategoryMemberInfo($is_field);
										 				$form_creator ->formPath ='/templates/admin/patient_category/add_member_category_patient_id.php';
													}
													break;

				case 'accounting_automise_purchase_return' :  

											$db_obj  = new DBFunction();
											$acc_mod_obj = new AccountingModel();
											$acc_obj = new Accounting();

											$ledgers =$acc_mod_obj->getLedgers();

											$accounting_details =$acc_obj->getAccountingAutomisePharmaPurchaseReturn();

											// var_dump($accounting_details);

											$form_creator ->popArr['ledgers']= $ledgers;

											if (!empty($message)) {
												$form_creator ->popArr['message']=$message;
											}


											$form_creator ->popArr['post']=$postArr;

											$form_creator ->popArr['accounting_details']=$accounting_details;

											$form_creator ->formPath ='/templates/admin/accounting_automise_purchase_return.php';

							                break;

				case 'manage_medicine_days'	   :
				
											// $db_obj  = new DBFunction();
											$dr_obj  = new Doctor();

											$where = array();	
											$where[0]="status =0"; 
											$where[1]="wrong = 0"; 

											// $select_data[0] = 'distinct med_days';

											$where[2]="id IN (SELECT MIN(id) FROM hcare_medicine_prescribed GROUP BY med_days)"; 

											if (!empty($postArr['medicine_days'])) {
												$where[3]="med_days LIKE '".$postArr['medicine_days']."%'"; 
											}

											$form_creator ->popArr['medicine_presc']=$a=$dr_obj->getMedicine_presc('', $where,'med_days','asc');

											// var_dump($a);

											$form_creator ->popArr['post']=$postArr;

											$form_creator ->formPath ='/templates/admin/manage_medicine_days.php';
											
											break;
		case 'email_settings_report'	:
											$gen_obj = new General();
											$lab_obj=new LabModel();
											$wheredata=array();
			 								$wheredata[0]="id = 1";
			 								$form_creator ->popArr['regEmails']=$regEmails=$gen_obj->getRegEmails($wheredata);
			 								
											$wheredata_smtp=array();
											$wheredata_smtp[0]="usage_type = 'REPORT'";
											$form_creator ->popArr['smtpInfo']=$smtpInfo=$lab_obj->getSmtpSettings($wheredata_smtp);
			 								
											$form_creator ->formPath ='/templates/admin/email settings/email_reports.php';
											break;
		  case 'change_password' 		:	
		  								$spec_obj=new Speciality();
										$dep_obj=new Department();
										$des_obj=new Designation();
										$emp_obj=new Employee();
										$user_obj=new User();	

										$form_creator ->formPath ='/templates/admin/change_password.php';

										break;	

		  									



			}
			
			$form_creator->display();
	
	}
	
	function updateHospitalInfo($post){
	
			$hosp_obj= new HospitalInfo();
			
			$status=$hosp_obj->updateHospitalInfo($post);
			if($status){
				
					$message='Update Successfully';
			}else {	
							
					$message='Failed To Update';				
			}
			
			$this->viewPage('HospitalInfo','','',$message);
	}
	function manageUser($post){
	
			$user_obj=new User();
			
			$action=$post['action'];
			$error_message='';
			if($action =="ADD" || $action == "UPDATE"){
			
				$check_user=$user_obj->checkUser($post);
				
					if($check_user){
							
					     if($action =="ADD"){
								
						$status=$user_obj->addUser($post);
								
					    }else{
						$status=$user_obj->updateUser($post);
					   }
				
					}else{
						$error_message='User Already Exist!';
					}
			
			}else{
			
				$status=$user_obj->deleteUser($post);
			}
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message ="Failed :";
				$message .=$error_message;
			}
			$this->viewPage('User',$post,'',$message);
	}
	
	function manageDepartment($post){
	
			$dep_obj=new Department();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$dep_obj->addDepartment($post);
								
					}else{
					
						$status=$dep_obj->updateDepartment($post);
					}
			
			}else{
			
				$is_dep_in_use=$dep_obj->checkDepartment($post);
				if($is_dep_in_use){
					$status=$dep_obj->deleteDepartment($post);
				}else {
				
					$message ="Department Already in Use";
					$this->viewPage('Department',$post,'',$message);
					exit();
				}
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Department',$post,'',$message);
	
	
	}
	function manageDesignation($post){
	
			$des_obj=new Designation();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$des_obj->addDesignation($post);
								
					}else{
					
						$status=$des_obj->updateDesignation($post);
					}
			
			}else{
				$is_des_in_use=$des_obj->checkDesignation($post);
				
				if($is_des_in_use){
				
					$status=$des_obj->deleteDesignation($post);
				}else {
				
					$message ="Designation Already in Use";
					$this->viewPage('Designation',$post,'',$message);
					exit();
				}
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Designation',$post,'',$message);
	
	
	}
	function manageSpeciality($post){
	
			$spec_obj=new Speciality();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$spec_obj->addSpeciality($post);
								
					}else{
					
						$status=$spec_obj->updateSpeciality($post);
					}
			
			}else{
			
				$status=$spec_obj->deleteSpeciality($post);
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Speciality',$post,'',$message);
	
	
	}
	function manageEmployee($post,$get){
	
		$emp_obj=new Employee();
		$user_obj=new User();
			
			$action=$post['paction'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
			 if(isset($get['active_module'])) {
				$post['active_module']=$get['active_module'];
			}
			
			 switch($post['active_module']){
				 
				 case 'personal_info'   :
				 
				                          if($action =="ADD"){
								
						                       $emp_id=$emp_obj->addEmployee($post);
											   if($emp_id > 0) {
								                 $post['id']=$emp_id;
												 $status=1;
											   }else $status=0;
					                      }else{
					
						                       $status=$emp_obj->updateEmployee($post);
					                       }
				 
				                           break;
				case 'job_info'   :
				                          $jobCondn[0]="emp_id=".$post['id'];
										  
				                          $jobStatus=$emp_obj->checkJobInfo($jobCondn);
										  if($jobStatus ==0){
											 $status=$emp_obj->add_job_info($post);
										  }else{
											 $status=$emp_obj->update_job_info($post);
										  }
				                           break; 
				 
				 case 'doc_fee_info'   :
				                          $feeCondn[0]="emp_id=".$post['id'];
										  
				                          $jobStatus=$emp_obj->checkFeeInfo($feeCondn);
										  if($jobStatus ==0){
											 $status=$emp_obj->add_doc_fee($post);
										  }else{
											 $status=$emp_obj->update_doc_fee($post);
										  }
				                           break;
                 case 'user_info'   :	
											$check_user=$user_obj->checkUser($post);
											
												if($check_user){
														
													 if($post['userid'] == ''){
															
													$status=$user_obj->addUser($post);
															
													}else{
													$status=$user_obj->updateUser($post);
												   }
											
												}else{
													$status="user_exist";
												}
										
										

                                        break;


				 
			 }
			 if($status ==1 || $status == "user_exist"){
			    $post['paction']="EDIT_PAGE";
			 }	
			
			}else{
			
				$status=$emp_obj->deleteEmployee($post);
				$status=$user_obj->deleteUser($post);
				
				
			
			}
			
		         if($status == "user_exist"){
			         $message="User Already Exist";
		         }else if($status == 1){
					$message=strtolower($action)."Success";
					$message=$this->$message; 
				}else{
					$message=strtolower($action)."failed";
					$message=$this->$message;
				}
		$this->viewPage('Employee',$post,'',$message);
	
	
	}
	function manageInsCompany($post){
	
			$ins_obj=new InsuranceCompany();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$ins_obj->addInsCompany($post);
								
					}else{
					
						$status=$ins_obj->updateInsCompany($post);
					}
			
			}else{
			
				$status=$ins_obj->deleteInsCompany($post);
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Insurance',$post,'',$message);
	
	
	}
	function managePatientCategory($post){
         
         $pat_cat_obj=new PatientCategory();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$pat_cat_obj->addPatientCategory($post);
								
					}else{
					
						$status=$pat_cat_obj->updatePatientCategory($post);
					}
			
			}else{
			
				$status=$pat_cat_obj->deletePatientCategory($post);
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('patient_category',$post,'',$message);
	
	
	}
	function manageOPSettings($post){
	
			$gen_obj=new General();
			
			$action=$post['action'];
			
			
			if($action =="ADD" ){
			
					if($action =="ADD"){
								
						$status=$gen_obj->addOpSettings($post);
								
					}
			
		}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('OPSettings',$post,'',$message);
	
	
	}
	
	function autheticate_user_json($post){
	
	  $user = new User();
	  
	  $user_name=$_POST['username'];
	  $password1=$_POST['password'];
	  $auth_from=$_POST['auth_from'];
			
			$isLogin=$user->login($user_name,$password1);
			
			if(!empty($isLogin)){
			 
			 if($auth_from=="verify_lab_result" && ($_SESSION['user_id'] ==$isLogin[0][0])){
			    $status="login_another_user";
			 }else{
			    $status="Success";
			 }
			}else $status="Failed";
			
			$data=array();
			$data['status']=$status;
			$data['user_id']=$isLogin[0][0];
			
			echo json_encode($data);
	}
	
	function show_pharma_branch($post){
		
		$pharma_obj=new PharmaFunctions();
		
		$data['pharma_branch']=$pharma_obj->getPharmaBranch();
		
		echo json_encode($data);
		
	}
	
	function show_dep_speciality($post){
		
		$spec_obj=new Speciality();
		
		$wheredep[0]="department_id ='".$post['dep_id']."'";
		$wheredep[1]="status=0";
		// var_dump($wheredep);exit;
	    $data['SpecialityInfo']	=$SpecialityInfo= $spec_obj->getSpeciality('',$wheredep);
	    // var_dump($SpecialityInfo);exit;


															
		
		echo json_encode($data);
		
	}
function daily_collection($collection_date){
   $bill_obj= new Billing();
   $user_obj=new User();
   $report_obj=new Report();
  
   
  
   $collections=array();
   
   
  //lab collection
  $user_data=array();
  $user_data[]="user_type='6' or user_type='7'";
  
  $userInfo=$user_obj->getUser('',$user_data);
  
  $total_lab_collection=0;
  
  if(!empty($userInfo)){
  
     $user_id="";
        for($i=0;$i<count($userInfo);$i++){
														
			if($i == 0 ){
				$user_id .="(";
			}
														
			if($i == ((count($userInfo))-1)){
														
				$user_id .=$userInfo[$i][0].")";
			}else{
				$user_id .=$userInfo[$i][0].",";
			}
		}
      $wheredata=array();
      $wheredata[0]="bill_date >='".$collection_date." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date." 23:59:59'";
      $wheredata[2]="user_id in $user_id";
	  $wheredata[3]="status =0";
	  
	  $lab_collection=$bill_obj->getBillConsolidated($wheredata);
	  
	  $lab_cash_collection=$lab_collection[0][0];
	  $lab_card_collection=$lab_collection[0][1];
	  
	  if($lab_cash_collection == "") $lab_cash_collection=0;
	  if($lab_card_collection == "") $lab_card_collection=0;
	  
	  $total_lab_collection=$lab_cash_collection+$lab_card_collection;
  }
  $collections['lab']= $total_lab_collection;
  //xray
  
  
  $user_data=array();
  $user_data[]="user_type='12'";
  
  $userInfo=$user_obj->getUser('',$user_data);
  $total_xray_collection=0;
  if(!empty($userInfo)){
  
     $user_id="";
        for($i=0;$i<count($userInfo);$i++){
														
			if($i == 0 ){
				$user_id .="(";
			}
														
			if($i == ((count($userInfo))-1)){
														
				$user_id .=$userInfo[$i][0].")";
			}else{
				$user_id .=$userInfo[$i][0].",";
			}
		}
      $wheredata=array();
      $wheredata[0]="bill_date >='".$collection_date." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date." 23:59:59'";
      $wheredata[2]="user_id in $user_id";
	  $wheredata[3]="status =0";
	  
	  $xray_collection=$bill_obj->getBillConsolidated($wheredata);
	  
	  $xray_cash_collection=$xray_collection[0][0];
	  $xray_card_collection=$xray_collection[0][1];
	  
	  if($xray_cash_collection == "") $xray_cash_collection=0;
	  if($xray_card_collection == "") $xray_card_collection=0;
	  
	  $total_xray_collection=$xray_cash_collection+$xray_card_collection;
  }
  $collections['xray']= $total_xray_collection;
  //theatre procedure
 
  $user_data=array();
  $user_data[]="user_type='13'";
  
  $userInfo=$user_obj->getUser('',$user_data);
  $total_theatre_collection=0;
  if(!empty($userInfo)){
  
     $user_id="";
        for($i=0;$i<count($userInfo);$i++){
														
			if($i == 0 ){
				$user_id .="(";
			}
														
			if($i == ((count($userInfo))-1)){
														
				$user_id .=$userInfo[$i][0].")";
			}else{
				$user_id .=$userInfo[$i][0].",";
			}
		}
      $wheredata=array();
      $wheredata[0]="bill_date >='".$collection_date." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date." 23:59:59'";
      $wheredata[2]="user_id in $user_id";
	  $wheredata[3]="status =0";
	  $wheredata[4]="type ='IP'";
	  
	  $theatre_collection=$bill_obj->getBillConsolidated($wheredata);
	  
	  $theatre_cash_collection=$theatre_collection[0][0];
	  $theatre_card_collection=$theatre_collection[0][1];
	  
	  if($theatre_cash_collection == "") $theatre_cash_collection=0;
	  if($theatre_card_collection == "") $theatre_card_collection=0;
	  
	  $total_theatre_collection=$theatre_cash_collection+$theatre_card_collection;
  }
  $collections['theatre']= $total_theatre_collection;
  

	  
	  
	  //op collection
	  
	  
	  
	  $op_collection=$report_obj->daily_collection($collection_date,$collection_date);
	  $total_op_collection=$op_collection[0][1]+$op_collection[1][1]+$op_collection[2][1];
	  $collections['op_collection']=$total_op_collection;
	  
	  
	  
	  return $collections;
	  

}

function update_accounting($post){
		
	$acc_obj = new AccountingModel();
		
	$result = $acc_obj->update_accounting($post);
		
	if($result){

		$acc_obj->update_accounting_entries($post);

		$message="Success";
		$message=$this->$message; 
	}else{
		$message="failed";
		$message=$this->$message;
	}
	$this->viewPage('accounting_reposting',$post,'',$message);

}
	
	



function lock_op_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 1;

	$result = $acc_obj->add_op_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}

function lock_lab_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 2;

	$result = $acc_obj->add_lab_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_xray_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 3;

	$result = $acc_obj->add_xray_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_lab_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 8;

	$result = $acc_obj->add_lab_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_xray_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 9;

	$result = $acc_obj->add_xray_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_pharmacy_sales_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 1;

	$result = $acc_obj->add_pharmacy_sales_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise_sales',$post,'',$message);



}
function lock_pharmacy_purchase_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 1;

	$result = $acc_obj->add_pharmacy_purchase_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise_purchase',$post,'',$message);



}
function lock_pharmacy_purchase_data_return($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 1;

	$result = $acc_obj->add_pharmacy_purchase_return_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise_purchase_return',$post,'',$message);



}
function lock_pharmacy_sales_return_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 1;

	$result = $acc_obj->add_pharmacy_sales_return_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise_sales_return',$post,'',$message);



}
function lock_procedure_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 4;

	$result = $acc_obj->add_procedure_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_procedure_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 10;

	$result = $acc_obj->add_procedure_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_ip_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 5;

	$result = $acc_obj->add_ip_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_theater_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 11;

	$result = $acc_obj->add_theater_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_theater_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 6;

	$result = $acc_obj->add_theater_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_super_nurse_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 11;

	$result = $acc_obj->add_super_nurse_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_nurse_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 12;

	$result = $acc_obj->add_nurse_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_nurse_credit_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 13;

	$result = $acc_obj->add_nurse_credit_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_op_dr_payments_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 7;

	$result = $acc_obj->add_op_dr_payments_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function lock_ip_advance_data($post)
{
	
	$acc_obj = new Accounting();

	$post['id'] = 12;

	$result = $acc_obj->add_ip_advance_payments_details($post);

	$message = "Successfully Added";

	$this->viewPage('accounting_automise',$post,'',$message);



}
function delete_med_days($post)
{
	
	$dr_obj = new Doctor();

	$result = $dr_obj->delete_med_days($post);

	$message = "Successfully Deleted";

	$this->viewPage('manage_medicine_days',$post,'',$message);



}
function saveRegEmail($post)
	{

		
		$gen_obj = new General();
		$wheredata=array();
		// $wheredata[0]="reports ='".$post['report_name']."'";
		// // $wheredata[0]="reports = 1";
		// $regEmails=$gen_obj->getRegEmails($wheredata);
		// if(!empty($$regEmails)){

		$result = $gen_obj->updateRegEmail($post);
		// }

		if($result){
			$message="Successfully Added"; 
		}else{
			$message="Failed";
		}

		$this->viewPage('email_settings_report',$post,'',$message);


	}

	function changePassword($post)
	{

		
		$emp_obj=new Employee();
		$user_obj=new User();
		$form_creator = new Form();


		$result = $user_obj->updatePassword($post);
		// }

		if($result =1){
			$message="Password Successfully Changed !"; 

		}else{
			$message="Failed";
			
		}

		 $this->viewPage('change_password',$post,'',$message);


	}


	
	
}


?>
