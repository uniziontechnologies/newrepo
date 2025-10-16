<?php 

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/department.php';
require_once ROOT_PATH . '/lib/model/admin/insurance_company.php';
require_once ROOT_PATH . '/lib/model/admin/general.php';
require_once ROOT_PATH . '/lib/model/admin/op_reset_no.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/common/smsFunctions.php';
require_once ROOT_PATH . '/lib/model/booking/booking.php';
require_once ROOT_PATH . '/lib/controllers/bookingController.php';
require_once ROOT_PATH . '/lib/common/pagination.php';
require_once ROOT_PATH . '/lib/model/doctor/doctor.php';
require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';
require_once ROOT_PATH . '/lib/model/admin/patient_category.php';
require_once ROOT_PATH . '/config_hims.php';

class RegistrationController {

	

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){
				
				case 'patient_re_registeration'	:   $postArr = array(); 
													$postArr['paction']="REREG_FORM"; 
													
				case 'patient_registeration'	:   
													$db_obj=new DBFunction();
													$emp_obj=new Employee();
													$dep_obj=new Department();
													$bk_obj = new Booking();
													$gen_obj = new General();
													$pati_cat_obj = new PatientCategory();
													
													$where[]="id = (SELECT MAX(id) FROM hcare_op_settings)";

													$validity_info= $gen_obj->getOpSettings('',$where,'','');
													// var_dump($validity_info);
													if($validity_info[0][6]=='Y'){
														$no_of_year=$validity_info[0][5];
													$y = strtotime("+$no_of_year year");
													$post['card_expiry']=date('d-m-Y', "+$y");
													 // echo "Years : ".$years = date('Y-m-d', "+$y years");
									    				// exit;

												}else{
													$no_of_year=$validity_info[0][5];
													 $m = strtotime("+$no_of_year month");
													 // echo "Months : ".$months = date('Y-m-d', "+$m months");
													 // exit;
													 $post['card_expiry'] =date('d-m-Y', "+$m");
												}
													// $post['card_expiry'] =date('d-m-Y', strtotime('+1 year'));
													if(isset($postArr['paction']) && $postArr['paction']="REREG_FORM"){
														
														$form_creator ->popArr['status']="RENEW";
													}else{
														$form_creator ->popArr['status']="NEW";
														
													}
													if(!empty($getArr['bk_id'])){
													
														$form_creator ->popArr['bk_id']=$getArr['bk_id'];
														$wheredata[0]="id='".$getArr['bk_id']."'";
														
														$bkInfo=$bk_obj->getBookingList($wheredata);													
														
														
														$is_field[0]="a.id ='".$bkInfo[0][2]."'";
					
														$docinfo=$emp_obj->getEmployee($is_field);
														
														$docfee=$docinfo[0][19];
														$post['validity_days']=$docinfo[0][23];
														//registration fees
														$selectfield[0]="reg_fee";
														$selectfield[1]="card_fee";
														$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
														$regfee=$reg_fee[0][0];
														$cardfee=$reg_fee[0][1];
														
														$post['bk_id']=$bkInfo[0][0];
														$post['token']=$bkInfo[0][1];
														$post['doctor']=$bkInfo[0][2];
														$post['first_name']=$bkInfo[0][6];
														$post['place']=$bkInfo[0][7];
														$post['contact_no']=$bkInfo[0][8];
														$post['docfee']=$docfee;
														$post['regfee']=$regfee;
														$post['cardfee']=$cardfee;
														
														
														$form_creator ->popArr['status']="NEW";
														$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
														
													}else{
													
														$is_field[0]="a.title='Dr'";												
														$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
													}
													
													$form_creator ->popArr['post']=$post;
													$form_creator ->popArr['action']="REGISTRATION";
													$form_creator ->popArr['departments']=$dep_obj->getDepartment();
													$form_creator ->popArr['countries']=$db_obj->getCountries();
                                                     
                                                    $form_creator ->popArr['patient_category']=$pati_cat_obj->getPatientCategory();
           
													$form_creator ->formPath ='/templates/registration/registration_form.php';
													break;
				case 'Print_OP_Sheet'			:
													$reg_obj= new Registration();
													$emp_obj= new Employee();
													
													if(!empty($postArr['reg_id'])) $postArr['id']=$postArr['reg_id'];
													$id=$postArr['id'];
													
													$selectCondition[]="b.`id`='".$id."'";
													$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
													
													$is_field[0]="a.id='".$patientInfo[0][14]."'";
													$form_creator ->popArr['empInfo']=$emp_obj->getEmployee($is_field);
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->formPath ='/templates/registration/print_op_sheet.php';
													break;
				case 'ManagePatients'			: 
														$com_obj = new CommonFunctions();
														$reg_obj= new Registration();
														$emp_obj= new Employee();
														$selectCondition=array();
														$pagi_obj = new Pagination();
														
														if(isset($postArr['paction']) && $postArr['paction']=="SEARCH"){
														
														    if(!empty($postArr["from_date"])){
															  $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
															  $selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
														    }
														   if(!empty($postArr["to_date"])){
															   $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
															   $selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
														   }															
															if(!empty($postArr["opno"])){
																$selectCondition[]="a.`id`='".$postArr["opno"]."'";
															}
															if(!empty($postArr["first_name"])){
																$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
															}
															if(!empty($postArr["place"])){
																$selectCondition[]="a.`place` LIKE '%".$postArr["place"]."%'";
															}
															if(!empty($postArr["doctor"])){
																$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
															}
															if(!empty($postArr["contact_no"])){
																$selectCondition[]="a.`contact_no` LIKE '%".$postArr["contact_no"]."%'";
															}
															
														}
														
													if(empty($selectCondition)){ 
													
													   $fromdate=$com_obj->getcurrentDate();
													   $todate=$com_obj->getcurrentDate();
														$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
														$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
													}
														$selectCondition[]="b.`cancelled`=0";
														
											/*...............pagination..............*/		
					                            $perPage=20;
					                            if(empty($postArr['current_page'])) 
                                                    {
                                                    	   $current_page =1;	
                                                    }
                                                else{ 
                                                    	   $current_page = $postArr['current_page']; 
                                                    }

                                                $limit=$pagi_obj->pageLimit($current_page,$perPage);   

                                                $patient_count=$reg_obj->getOPPatientCount($selectCondition,'b.visit_date','desc');
											/*...............pagination..............*/		
                                            
														$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','desc',$limit);

												$form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patient_count,$current_page,$perPage);

												$form_creator ->popArr['current_page']=$current_page;
														
													if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
													}else $form_creator ->popArr['post']='';
														
														$is_field[0]="a.title='Dr'";			
                                                     
                                              
													$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
														
														$form_creator ->formPath ='/templates/registration/manage_op_patients.php';
														break;
				case 'search_op_patient'    :           $com_obj = new CommonFunctions();
														$reg_obj= new Registration();
														$emp_obj= new Employee();
														
														  $selectCondition[]="b.`visit_date`>='".$com_obj->getcurrentDate()." 00:00:00'";
														  $selectCondition[]="b.`visit_date`<='".$com_obj->getcurrentDate()." 23:59:59'";
														  
														  $selectCondition[]="b.`cancelled`=0";
														  
														  $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfoProcessOPSearch('',$selectCondition,'b.visit_date','desc');
														  
														  $is_field[0]="a.title='Dr'";													
														  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
														
														  $form_creator ->formPath ='/templates/registration/op_search.php';
														
														
														
														
														if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
														}else $form_creator ->popArr['post']='';
														
														
														break;
					case 'print_op_card';		    $reg_obj= new Registration();
													$emp_obj= new Employee();
													
													$id=$postArr['id'];
													
													$selectCondition[]="b.`id`='".$id."'";
													$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
													
													$is_field[0]="a.id='".$patientInfo[0][14]."'";
													$form_creator ->popArr['empInfo']=$emp_obj->getEmployee($is_field);
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->formPath ='/templates/registration/print_op_card.php';			
						
									           break;
				   case 'print_registration';		$reg_obj= new Registration();
													$emp_obj= new Employee();
													
													$id=$postArr['id'];
													
													$selectCondition[]="b.`id`='".$id."'";
													$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
													
													$is_field[0]="a.id='".$patientInfo[0][14]."'";
													$form_creator ->popArr['empInfo']=$emp_obj->getEmployee($is_field);
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->formPath ='/templates/registration/print_registration.php';			
						
									           break;
					case 'Patient_Records' :$reg_obj= new Registration();
										   $pagi_obj = new Pagination();
										   
										   $selectCondition=array();
										   if(!empty($postArr["opno"])){
																$selectCondition[]="`id`='".$postArr["opno"]."'";
											}
											if(!empty($postArr["first_name"])){
												$selectCondition[]="`first_name` like '%".$postArr["first_name"]."%'";
											}
											if(!empty($postArr["place"])){
												$selectCondition[]="`place`='".$postArr["place"]."'";
											}
											if(!empty($postArr["contact_no"])){
												$selectCondition[]="`contact_no`='".$postArr["contact_no"]."'";
											}
										   
										   //pagination
										   
										   $patientCount=$reg_obj->getAllOPCount($selectCondition);
                                           $perPage=$pagi_obj->perPage;	

                                          if(empty($postArr['current_page'])) $current_page =1;			
			                              else $current_page = $postArr['current_page'];
			
					
			                              //set limit value for query
			                              $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                          $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page);	
                                          $form_creator ->popArr['current_page']=$current_page;	
                                          $form_creator ->popArr['perPage']=$perPage;											  
					                      $form_creator ->popArr['patient_info']=$reg_obj->getAllOPPatients('',$selectCondition,'id','desc', $limit); 
					                      $form_creator ->formPath ='/templates/patient_record/patient_list.php';			
						
									           break;
			          case 'View_Patient_Record' :$reg_obj= new Registration();
					                              $dr_obj=new Doctor(); 
												  $bill_obj=new Billing();
												  $ip_obj= new Inpatient();
												  $lab_obj= new LabModel();
												  $pagi_obj = new Pagination();
												  $pharma_obj=new pharmaFunctions();
												  
					                               $patient_id=$postArr['id'];
					                               $form_creator ->popArr['patient_id']=$patient_id;

												   
												 
											if(isset($getArr['active_module'])) {
											  $postArr['active_module']=$getArr['active_module'];
											}
											else if (isset($postArr['summary'])) {
												 $postArr['active_module']=$postArr['summary'];
											}
											$selectCondition[0]="a.`id`='". $patient_id."'";
											$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');

					                    switch($postArr['active_module']){

					                    		case 'summary' : 

												//visit details
												   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc',"0,3");
												   
												//last case sheet details
												   $last_visit_id=$patientInfo[0][13];
												   $where[0]="visit_id =".$last_visit_id;
							                       $where[1]="status =0";  
							                       $casesheetInfo[0]=$dr_obj-> getPresent_complaint('', $where);
                                                   $casesheetInfo[1]=$dr_obj-> getProv_diagnosis('', $where);	
                                                   $casesheetInfo[2]=$dr_obj-> getProcedure_presc('', $where);
                                                   $casesheetInfo[3]=$dr_obj->getLabtest_presc('', $where);
                                                   $casesheetInfo[4]=$dr_obj->getMedicine_presc('', $where);
                                                   $casesheetInfo[5]=$dr_obj->getRadiology_presc('', $where);
												   $form_creator ->popArr['casesheetInfo']=$casesheetInfo;
												   
												//credit bill info
												
												   $wheredata[0]="opno ='".$patient_id."'";
												   $wheredata[1]="status ='0'";
												   $wheredata[2]="credit > 0";
												
												   $form_creator ->popArr['creditInfo']=$bill_obj->getBillInfo($wheredata,'','',true,"0,3");
												
											  //pharma credit Bill
											  
											      $phwhere[]="op_no = '".$patient_id."'";  
                                                  $phwhere[]="status = '0'";
											      $phwhere[]="payment_mode = 'CREDIT'";
	                                              $form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($phwhere,"0,3");
											  
											      $selectCondition[]="a.`id`='".$patient_id."'";  
											      $selectCondition[]="b.`cancelled`=0";
											      $form_creator ->popArr['ipInfo']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',"0,3");

					                    		       break;
											
										  	    case 'patient_documents'   :
																
													$where_doc[0]="opno = '".$patient_id."'"; 
													$where_doc[1]="status =0"; 
													$where_doc[2]="Cust_type != 'IP'"; 
													$form_creator ->popArr['documentInfo']=$dr_obj->getPatient_documents('', $where_doc);
													$postArr['current_module']=$postArr['active_module'];

																				
												break;

												case 'patient_visits'      :

												   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');

												   if (!empty($patientInfo)) {

												   	for ($i=0; $i <count($patientInfo) ; $i++) { 

												      $selectCondition[0]="a.`id`='".$patientInfo[$i][0]."'"; 
												      $selectCondition[1]="b.`visit_id`='".$patientInfo[$i][13]."'";
												      $selectCondition[2]="b.`cancelled`=0";
												      $ip_info[$i]=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');				

												   	}

								   	
												   }

												   if (!empty($ip_info)) {
												   	 $form_creator ->popArr['ip_info']=$ip_info;
												   }



												break;

												case 'patient_lab_results'      :

												   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');


													$billCondn[0]="type ='OP'";
													$billCondn[1]="opno =".$patient_id;
													$billCondn[2]="status =0";
													$billCondn[3]="lab_status =1";
													
													$form_creator ->popArr['resultInfo']=$bill_obj->getBillInfo($billCondn,'id','desc');

												break;

							case 'case_sheets'      :



												   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['patient_info_dropdown']=$patient_info_dropdown=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');

												   $patientCount = count($patient_info_dropdown);

												   $perPage=1;	

		                                          if(empty($postArr['current_page'])) $current_page =1;			
					                              else $current_page = $postArr['current_page'];
												
							
					                              //set limit value for query
					                              $limit=$pagi_obj->pageLimit($current_page,$perPage);	
		                                          $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page,$perPage);	
		                                          $form_creator ->popArr['current_page']=$current_page;	
		                                          $form_creator ->popArr['perPage']=$perPage;											  
		                                          if (empty($postArr['visit_date'])) {
		                                          	$selectCondition[0]="a.`id`='". $patient_id."'";
		                                          }
		                                          else{
		                                          	$selectCondition[0]="a.`id`='". $patient_id."'";
		                                          	$selectCondition[1]="b.`id`='". $postArr['visit_date']."'";
		                                          	$form_creator ->popArr['date_selected']=$postArr['visit_date'];
		                                          }

												  
												   $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc',$limit);


												   if (!empty($patientInfo)) {
	
													   for ($i=0; $i <count($patientInfo) ; $i++) { 

															$where[0]="visit_id =".$patientInfo[$i][13];
															$where[1]="status =0"; 

															$casesheetInfo[$i][0]=$dr_obj-> getPresent_complaint('', $where);
															$casesheetInfo[$i][1]=$dr_obj-> getProv_diagnosis('', $where);
															$casesheetInfo[$i][2]=$dr_obj-> getProcedure_presc('', $where);
															$casesheetInfo[$i][3]=$dr_obj->getLabtest_presc('', $where);
															$casesheetInfo[$i][4]=$dr_obj->getMedicine_presc('', $where);
															$casesheetInfo[$i][8]=$dr_obj->getPastHistory('', $where);
															$casesheetInfo[$i][5]=$patientInfo[$i][13];

															$casesheetInfo[$i][9]=$dr_obj-> getPhysicalExamination('', $where);

															$casesheetInfo[$i][11]=$dr_obj-> getRadiology_presc('', $where);

															$where[0]="opno =".$patient_id;
															$where[1]="status =0";  
															$casesheetInfo[$i][10]=$dr_obj->getPatient_allergies('', $where);





													   }

												   }

												   $form_creator ->popArr['casesheetInfo']=$casesheetInfo;

												break;

												case 'patient_medicines'      :

													$selectCondition[0]="a.`id`='". $patient_id."'";
													$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');


													$where[0]="op_no =".$patient_id;
													$where[1]="status =0"; 


													$form_creator ->popArr['medicine_info']=$medicine_info=$pharma_obj-> getPharmaInvoice($where,'id','desc');												
												break;

												// case 'patient_ip_history'      :

												//       $selectCondition[]="a.`id`='".$patient_id."'";  
												//       $selectCondition[]="b.`cancelled`=0";
												//       $form_creator ->popArr['patientIpInfo']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');

											
												// break;
												// patient op bill record
												case 'patient_op_bill_history'      : 
												$db_obj=new DBFunction();
												$pharma_obj = new PharmaFunctions();

												$patient_visit_date=$reg_obj->getVisitDate($patient_id);
												$form_creator ->popArr['patient_visit_date'] = $patient_visit_date;
												
												$patient_visit_id=$postArr['visit_date'];
												$form_creator ->popArr['visit_date'] = $patient_visit_id;
												if($postArr['visit_date']){

													$Condition = array();
													$Condition[0]="a.`ref_no` = ".$patient_visit_id;
													$Condition[1]="a.`type` = 'OP'";
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfoAllField($Condition);


													$Condition = array();
													$Condition[0]="op_visit_id =".$patient_visit_id;
													$Condition[1]="status = 0";
													$Condition[2]="cust_type = 'OP'";
													$form_creator ->popArr['medicine_info']=$medicine_info=$pharma_obj->getPharmaInvoice($Condition);
												}
											
												break;

												// patient ip bill record
												// case 'patient_ip_bill_history'      : 
												// $db_obj=new DBFunction();
												// $pharma_obj = new PharmaFunctions();

												// $patient_ipno=$reg_obj->getipno($patient_id);
												// $form_creator ->popArr['patient_ipno'] = $patient_ipno;
												// $form_creator ->popArr['all_ipno_ref']= $all_ipno_ref = $reg_obj->getipno_ref($patient_id); 

												
												// $patient_ipno=$postArr['ipno'];
												// $form_creator ->popArr['ipno'] = $patient_ipno;
												// if($postArr['ipno']){

												// 	$Condition = '';
												// 	$Condition[0]="a.`ref_no` = ".$patient_ipno;
												// 	$Condition[1]="a.`type` = 'IP'";
												// 	$form_creator ->popArr['billInfo']=$bill_obj->getBillInfoAllField($Condition);


												// 	$Condition = '';
												// 	$Condition[0]="ip_no =".$patient_ipno;
												// 	$Condition[1]="status = 0";
												// 	$Condition[2]="cust_type = 'IP'";
												// 	$form_creator ->popArr['medicine_info']=$medicine_info=$pharma_obj->getPharmaInvoice($Condition);

												// 	$Condition = '';
												// 	$Condition[0]="ipno=".$patient_ipno;
            //                                         $Condition[1]="(bill_status !=1 and bill_status !=3)";														
	           //                                      $form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
												// }
											
												// break;


										     case 'patient_op_credits'      :



                                                   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['op_visit_date']=$op_visit_date=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');
												  
                                                               
												   $patientCount = count($op_visit_date);

												   $perPage=100;	

		                                          if(empty($postArr['current_page'])) $current_page =1;			
					                              else $current_page = $postArr['current_page'];
												
							 
					                              //set limit value for query
					                              $limit=$pagi_obj->pageLimit($current_page,$perPage);	

		                                          $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page,$perPage);	
		                                          $form_creator ->popArr['current_page']=$current_page;	
		                                          $form_creator ->popArr['perPage']=$perPage;											  
		                                          
		                                          	$selectCondition[0]="`type`='OP'";
		                                          	$selectCondition[1]="`opno`='". $patient_id."'";
		                                          	$selectCondition[2]="`status`=0";
		                                            $selectCondition[3]="`paid_with`='CREDIT'";

		                                            $total_opcreditInfo=$bill_obj->get_patientCreditBill($selectCondition);
		                                            $total_opcredit=0;
		                                            for($i=0;$i<count($total_opcreditInfo);$i++){
		                                            	$total_opcredit+=$total_opcreditInfo[$i][13];
		                                            }
													$form_creator ->popArr['total_opcredit'] = $total_opcredit;


		                                          	if (!empty($postArr['visit_date'])) {
		                                          		$selectCondition[4]="`ref_no`='". $postArr['visit_date']."'";
		                                          		$form_creator ->popArr['date_selected']=$postArr['visit_date'];
		                                          	}
		                                          	else{
		                                          		$selectCondition[4]="`ref_no`='". $op_visit_date[0][13]."'";
		                                          		$form_creator ->popArr['date_selected']= $op_visit_date[0][13];
		                                          	}
		                                          	
												     $form_creator ->popArr['opcreditInfo']=$opcreditInfo=$bill_obj->get_patientCreditBill($selectCondition,'id','desc',$limit);



                                                  $phwhere[]="op_no = '".$patient_id."'";  
                                                  $phwhere[]="status = '0'";
											      $phwhere[]="payment_mode = 'CREDIT'";


											      $total_pharmaCreditInfo=$bill_obj->getpharmaBill($phwhere);
		                                            $total_pharmaCredit=0;
		                                            for($i=0;$i<count($total_pharmaCreditInfo);$i++){
		                                            	$total_pharmaCredit+=$total_pharmaCreditInfo[$i][11];
		                                            }
													$form_creator ->popArr['total_pharmaCredit'] = $total_pharmaCredit;


											      	if (!empty($postArr['visit_date'])) {
		                                          		$phwhere[]="`op_visit_id`='". $postArr['visit_date']."'";
		                                          		$form_creator ->popArr['date_selected']=$postArr['visit_date'];
		                                          	}
		                                          	else{
		                                          		$phwhere[]="`op_visit_id`='". $op_visit_date[0][13]."'";
		                                          		$form_creator ->popArr['date_selected']= $op_visit_date[0][13];
		                                          	}
	                                              $form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($phwhere,'');
												     
												   
												break;


												// case 'patient_ip_credits'      :

												// $form_creator ->popArr['all_ipno']= $all_ipno = $reg_obj->getipno($patient_id); 
												// $form_creator ->popArr['all_ipno_ref']= $all_ipno_ref = $reg_obj->getipno_ref($patient_id); 
                                                

												// $size = sizeof($all_ipno);						  

												// $Condition[0]="`type`='IP'";
												// $Condition[1]="`status`=0";
												// $Condition[2]="`paid_with`='CREDIT'";
												// if($size>0){ 
												// 	$Condition[3]="`ref_no` in (".implode(",",$all_ipno).")";

												//     $total_ipCreditInfo=$bill_obj->get_patientCreditBill($Condition);
		          //                                   $total_ipcredit=0;
		          //                                   for($i=0;$i<count($total_ipCreditInfo);$i++){
		          //                                   	$total_ipcredit+=$total_ipCreditInfo[$i][13];
		          //                                   }
												// 	$form_creator ->popArr['total_ipcredit'] = $total_ipcredit;
												// }else{
												// 	$form_creator ->popArr['total_ipcredit'] = 0;
												// }
												// if (!empty($postArr['ipno'])) {
												// 	$Condition[3]="`ref_no`='". $postArr['ipno']."'";
												// 	$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
												// 	$form_creator ->popArr['ipcreditInfo']=$bill_obj->get_patientCreditBill($Condition);
												// }
												// else if($size>0){ 
												// 	$Condition[3]="`ref_no`='".$all_ipno[$size-1]."'";
												// 	$form_creator ->popArr['ipno_selected']= $all_ipno[$size-1];
												// 	$form_creator ->popArr['ipcreditInfo']=$bill_obj->get_patientCreditBill($Condition);
												// } 												
												

												// $Condition = '';
            //                                     $Condition[0]="cust_type ='IP'";
            //                                     $Condition[1]="status = '0'";
											 //    $Condition[2]="payment_mode = 'CREDIT'";
											 //    if($size>0){ 
												// 	$Condition[3]="`ip_no` in (".implode(",",$all_ipno).")";

												//     $total_ippharmaCreditInfo=$bill_obj->getpharmaBill($Condition);
		          //                                   $total_ippharmacredit=0;
		          //                                   for($i=0;$i<count($total_ippharmaCreditInfo);$i++){
		          //                                   	$total_ippharmacredit+=$total_ippharmaCreditInfo[$i][11];
		          //                                   }
												// 	$form_creator ->popArr['total_ippharmacredit'] = $total_ippharmacredit;
												// }else{
												// 	$form_creator ->popArr['total_ippharmacredit'] = 0;
												// }


										  //     	if (!empty($postArr['ipno'])) {
	           //                                		$Condition[3]="`ip_no`='". $postArr['ipno']."'";
	           //                                		$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
	           //                                		$form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($Condition);
	           //                                	}
	           //                                	else if($size>0){
	           //                                	 	$Condition[3]="`ip_no`='". $all_ipno[$size-1]."'";
												// 	$form_creator ->popArr['ipno_selected']= $all_ipno[$size-1];
												// 	$form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($Condition);
	           //                                	}
	                                            

	           //                                  $Condition = '';
            //                                     $Condition[0]="(bill_status !=1 and bill_status !=3)";
            //                                     if($size>0){ 
												// 	$Condition[1]="`ipno` in (".implode(",",$all_ipno).")";

	           //                                      $total_dischargeCreditInfo=$bill_obj->getIPBillInfo($Condition);
		          //                                   $total_dischargepharmacredit=0;
		          //                                   for($i=0;$i<count($total_dischargeCreditInfo);$i++){
		          //                                   	$total_dischargepharmacredit+=$total_dischargeCreditInfo[$i][24];
		          //                                   }
												// 	$form_creator ->popArr['total_dischargepharmacredit'] = $total_dischargepharmacredit;
												// }else{
												// 	$form_creator ->popArr['total_dischargepharmacredit'] = 0;
												// }

            //                                     if (!empty($postArr['ipno'])) {
	           //                                		$Condition[1]="`ipno`='". $postArr['ipno']."'";
	           //                                		$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
	           //                                		$form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
	           //                                	}
	           //                                	else if($size>0){
	           //                                	 	$Condition[1]="`ipno`='". $all_ipno[$size-1]."'";
												// 	$form_creator ->popArr['ipno_selected']= $all_ipno[$size-1];
												// 	$form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
	           //                                	}
												     
												// break;


case 'patient_allergies'      :
                                                           
					                                    $selectCondition[0]="opno='". $patient_id."'";

		                                            	$selectCondition[1]="status=0";

		                                            	
												        $form_creator ->popArr['allergyInfo']=$allergyInfo=$dr_obj->getPatient_allergies('', $selectCondition);

                                                        
                                                         

												break;

							case 'covid_status'      :



												   $selectCondition[0]="a.`id`='". $patient_id."'";
												   $form_creator ->popArr['patient_info_dropdown']=$patient_info_dropdown=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');

												   $patientCount = count($patient_info_dropdown);

												   $perPage=1;	

		                                          if(empty($postArr['current_page'])) $current_page =1;			
					                              else $current_page = $postArr['current_page'];
												
							
					                              //set limit value for query
					                              $limit=$pagi_obj->pageLimit($current_page,$perPage);	
		                                          $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page,$perPage);	
		                                          $form_creator ->popArr['current_page']=$current_page;	
		                                          $form_creator ->popArr['perPage']=$perPage;											  
		                                          if (empty($postArr['visit_date'])) {
		                                          	$selectCondition[0]="a.`id`='". $patient_id."'";
		                                          }
		                                          else{
		                                          	$selectCondition[0]="a.`id`='". $patient_id."'";
		                                          	$selectCondition[1]="b.`id`='". $postArr['visit_date']."'";
		                                          	$form_creator ->popArr['date_selected']=$postArr['visit_date'];
		                                          }

												  
												   $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc',$limit);


												   if (!empty($patientInfo)) {
	
													   for ($i=0; $i <count($patientInfo) ; $i++) { 

															$where[0]="visit_id =".$patientInfo[$i][13];
															$where[1]="status =0"; 

															 $covidInfo[$i]=$dr_obj->get_covid_info('', $where);


													   }

												   }

												   $form_creator ->popArr['covidInfo']=$covidInfo;

												break;


													}								


												   $form_creator ->popArr['postArr']=$postArr;
					                               $form_creator ->formPath ='/templates/patient_record/view_patient_record.php';	
					                          break;

					                      case 'show_creditBills' :

												$bill_obj=new Billing();

												if (!empty($getArr['id'])) {
													$where[0]="b.`bill_no` =".$getArr['id'];
													$where[1]="b.`status` =0";  
													$form_creator ->popArr['credit_item_info']=$credit_item_info=$bill_obj-> getfullCreditInfo($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/show_credit_bills.php';	

											break;
											 case 'show_pharmacreditBills' :
                        
												$bill_obj=new Billing();
                                                  
												if (!empty($getArr['id'])) {
													$where[0]="`bill_no` =".$getArr['id'];
													$where[1]="`status` =0";  
													$form_creator ->popArr['credit_pharma_item_info']=$credit_pharma_item_info=$bill_obj-> getpharmaCreditPayment($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/show_pharma_credit_bills.php';	

											break;

											case 'show_dischargecreditBills' :
                        
												$bill_obj=new Billing();
                                                  
												if (!empty($getArr['id'])) {
													$where=array();
													$where[0]="`billid` =".$getArr['id']; 
													$form_creator ->popArr['credit_pharma_item_info']=$credit_pharma_item_info=$bill_obj-> getIPCreditPayments($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/show_discharge_credit_bills.php';	

											break;
											


											case 'show_medicines' :

												$pharma_obj=new pharmaFunctions();

												if (!empty($getArr['id'])) {

													$where[0]="bill_id =".$getArr['id'];
													$where[1]="status =0";  
													$form_creator ->popArr['medicine_item_info']=$medicine_item_info=$pharma_obj-> getPharmaInvoiceItems($where);

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/show_medicines.php';	

											break;
											
											
											
		case 'op_doctor_collection'		:
													$bill_obj=new Billing();
													$user_obj=new User();
													$emp_obj=new Employee();
													$reg_obj=new Registration();

													$is_field[0]="a.title ='Dr'";
													$is_field[1]="a.status = 0";
													$form_creator ->popArr['doctors']=$doctors=$emp_obj->getEmployee($is_field);

													$k=0;

													if(!empty($postArr['date'])) {
													
														$visit_date = date("Y-m-d",strtotime($postArr['date']));
													}
													else{

														$visit_date = date("Y-m-d");
													}

													if(!empty($postArr['doctor'])) {
														$doc_id=$postArr['doctor'];
													}	
													else{
														$doc_id="";
													}
	
													$wheredata[$k++]="cancelled ='0'";

													if (!empty($doctors)) {

														for ($i=0; $i <count($doctors) ; $i++) { 
															
															if (!empty($doc_id)) {

																$billInfo[$i] = $reg_obj->getOpDoctorPayments($visit_date,$doc_id);
																break; 
															}
															else if(empty($doc_id)){

																$billInfo[$i] = $reg_obj->getOpDoctorPayments($visit_date,$doctors[$i][0]);
															}
															
															

														}
													}
													
													$form_creator ->popArr['billInfo']=$billInfo;
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->formPath ='/templates/registration/op_doctor_collection.php';
													break;

						case 'op_doctor_payment_Form'		:
																
													$reg_obj = new Registration();

													$wheredata[0] = " doc_id = '".$postArr['doc_id']."' ";
													$wheredata[1] = " visit_date = '".$postArr['visit_date']."' ";

													$doc_payment_info = $reg_obj->getOpDoctorCollection($wheredata);

													if (empty($doc_payment_info)) {
														// $postArr['paction'] = "SAVE";
														$postArr['balance'] = $postArr['doc_fee'];
													}
													else{
														// $postArr['paction'] = "UPDATE";
														$postArr['balance'] = $postArr['balance'];
													}

													$form_creator ->popArr['post']=$postArr;
													$form_creator ->formPath ='/templates/registration/op_doctor_payment_Form.php';
													break;
						case 'add_dr_payment'		:
																							
													$reg_obj = new Registration();

													$reg_obj->addDrPayments($postArr);
													$postArr['date']=$postArr['visit_date'];
													$postArr['message']="Payment Added Successfully!";
													$this->viewPage('op_doctor_collection',$postArr,'',$message);
													$form_creator ->formPath ='/templates/registration/op_doctor_collection.php';

													break;

						case 'add_multilple_dr_collection'		:
															

													$reg_obj=new Registration();
													if(!empty($postArr['paybill'])){
																									
															for($i=0;$i<count($postArr['paybill']);$i++)
															{
																	$arrayInfo=explode('#',$postArr['paybill'][$i]);

																	$billInfo['visit_date']=$arrayInfo[0];
																	$billInfo['doc_fee']=$arrayInfo[1];
																	$billInfo['doc_id']=$arrayInfo[2];
																	$billInfo['amount_paid']=$arrayInfo[3];
																	$billInfo['amount_paid_so_far']=$arrayInfo[4]+$arrayInfo[3];
																	$billInfo['balance']=0;
																	$billInfo['payment_date']=date('Y-m-d');
																	$reg_obj->addDrPayments($billInfo);

															}
													}

													$postArr['message']="Payment Added Successfully!";
													$this->viewPage('op_doctor_collection',$postArr,'',$message);
													$form_creator ->formPath ='/templates/registration/op_doctor_collection.php';

													break;
													
													
													
													
					case 'OP_consultation_status' :
														// $postArr['message']="Payment Added Successfully!";
														$bk_obj = new Booking();
															
															// $wheredata[]="visited=0";
															$booking_list = $bk_obj->OP_consultation_status($wheredata);

															$form_creator ->postarr['consultation']=$booking_list;
													$form_creator ->formPath ='/templates/registration/op_consultation_status.php';
														break;

						case 'update_observation_status' :

													$reg_obj=new Registration();


													// if (!empty($postArr['observation_status'])) {
														
															
													// 	$reg_obj->updateObservation($postArr['id'],$postArr['observation_status']);

													// 	if (empty($postArr['from_observation'])) {
													// 		$this->viewPage('ManagePatients',$postArr,'',$message);
													// 	$form_creator ->formPath ='/templates/registration/manage_op_patients.php';
													// 	}


													// }
													if (!empty($postArr['observation_status'])) {														
															
														$reg_obj->updateObservation($postArr['id'],$postArr['observation_status'],$postArr['room'],$postArr['bed_no']);
													}
													$this->viewPage('ManagePatients',$postArr,'',$message);
													$form_creator ->formPath ='/templates/registration/manage_op_patients.php';
												break;

				// for member category
				case 'show_members' :
							                    $reg_obj=new Registration();
												$pat_cat_obj=new PatientCategory();
												$db_obj=new DBFunction();
												$id=$getArr['cat_id'];
												
												$is_field[0]="a.id ='".$id."'";
												$form_creator ->popArr['PatientCategoryInfo']=$pat_cat_obj->getPatientCategoryInfo($is_field);
												$where[0]="a.category_id ='".$id."'";

												if($getArr['patient_id'] && $getArr['patient_id']!=''){
													$where[]="a.patient_id ='".$getArr['patient_id']."'";
												}
												if($getArr['m_name'] && $getArr['m_name']!=''){
													$where[]="b.first_name like '%".$getArr['m_name']."%' or b.last_name like '%".$getArr['m_name']."%'";
												}
												if($getArr['age'] && $getArr['age']!=''){
													$where[]="b.age ='".$getArr['age']."'";
												}
												if($getArr['phone'] && $getArr['phone']!=''){
													$where[]="b.contact ='".$getArr['phone']."'";
												}
												if($getArr['gender'] && $getArr['gender']!=''){
													$where[]="b.gender ='".$getArr['gender']."'";
												}

										 		$form_creator ->popArr['CategoryMemberInfo']=$pat_cat_obj->CategoryMemberInfo($where);
										 		$form_creator ->popArr['Search']=$getArr;
												$form_creator ->formPath ='/templates/registration/show_members.php';
											break;
			//...........................................................................................................
			//                                          IP PATIENT RECORDS		
			//...........................................................................................................				
			case 'ip_Patient_Records' :        $reg_obj= new Registration();
											   $pagi_obj = new Pagination();
										       $db_obj=new DBFunction();
											   $ip_obj= new Inpatient();
                                      
											
											   $selectCondition=array();
											   if(!empty($postArr["ipno"])){
																	$selectCondition[]="b.`id` like '%".$postArr["ipno"]."%'";
												}
												if(!empty($postArr["first_name"])){
													$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
												}
												if(!empty($postArr["place"])){
													$selectCondition[]="a.`place` LIKE '%".$postArr["place"]."%'";
												}
												if(!empty($postArr["contact_no"])){
													$selectCondition[]="a.`contact_no` LIKE '%".$postArr["contact_no"]."%'";
												}
											   
											   //pagination
											   
											   //$patientCount=$reg_obj->getAllOPCount($selectCondition);
											    $selectCondition[]="b.`cancelled`=0";
	                                            $patientCount=$ip_obj->getIPPatientCount($selectCondition,'b.admission_date','asc');
	                                            $perPage=$pagi_obj->perPage;	

	                                           if(empty($postArr['current_page'])) $current_page =1;			
				                               else $current_page = $postArr['current_page'];
				
						
				                               //set limit value for query
				                               $limit=$pagi_obj->pageLimit($current_page,$perPage);	
	                                           $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page);	
	                                           $form_creator ->popArr['current_page']=$current_page;	
	                                           $form_creator ->popArr['perPage']=$perPage;											  
						                       $form_creator ->popArr['post']=$postArr;
											    
											   $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',$limit);

						                       $form_creator ->formPath ='/templates/patient_record/ip_patient_list.php';			
							
										           break; 

                // case 'print_ip_casesheet ':		    $reg_obj= new Registration();
													

		     case 'ip_View_Patient_Record' :

		                                      $reg_obj= new Registration();
				                              $dr_obj=new Doctor(); 
											  $bill_obj=new Billing();
											  $ip_obj= new Inpatient();
											  $lab_obj= new LabModel();
											  $pagi_obj = new Pagination();
											  $pharma_obj=new pharmaFunctions();
											  
				                               $patient_id=$postArr['id'];
				                               $form_creator ->popArr['patient_id']=$patient_id;

										      if(isset($getArr['active_module'])) {
										      $postArr['active_module']=$getArr['active_module'];
										      }
										      else if (isset($postArr['summary'])) {
											    $postArr['active_module']=$postArr['summary'];
									          }
										      $selectCondition[0]="b.`id`='". $patient_id."'";
										      $selectCondition[1]="b.`cancelled`=0";
										      $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');

					        switch($postArr['active_module']){

					          case 'ip_summary' : 

											//visit details
											  $selectCondition[0]="b.`id`='". $patient_id."'";
										      $selectCondition[1]="b.`cancelled`=0";
										      $form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc','0,3');
											 
											   
											//last case sheet details
											   $last_visit_id=$patientInfo[0][13];
											   $where[0]="ipno =".$last_visit_id;
						                       $where[1]="status =0";  
						                       $casesheetInfo[0]=$dr_obj-> get_ip_Present_complaint('', $where);
                                               $casesheetInfo[1]=$dr_obj-> get_ip_Prov_diagnosis('', $where);	
                                               $casesheetInfo[2]=$dr_obj-> get_ip_Procedure_presc('', $where);
                                               $casesheetInfo[3]=$dr_obj->get_ip_Labtest_presc('', $where);
                                               $casesheetInfo[4]=$dr_obj->get_ip_Medicine_presc('', $where);
                                               $casesheetInfo[5]=$dr_obj->get_ip_Radiology_presc('', $where);
                                               $casesheetInfo[6]=$b=$dr_obj->get_ip_consultation_details('', $where,"id",'desc');

											   $form_creator ->popArr['casesheetInfo']=$casesheetInfo;
											   
											//credit bill info
											
											   $wheredata[0]="opno ='".$patient_id."'";
											   $wheredata[1]="status ='0'";
											   $wheredata[2]="credit > 0";
											
											   $form_creator ->popArr['creditInfo']=$bill_obj->getBillInfo($wheredata,'','',true,"0,3");
											
										    //pharma credit Bill
										  
										       $phwhere[]="op_no = '".$patient_id."'";  
                                               $phwhere[]="status = '0'";
										       $phwhere[]="payment_mode = 'CREDIT'";
                                               $form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($phwhere,"0,3");

                                             // ALLERGY INFO  
                                               $selectConditionALL[0]="ipno='". $patient_id."'";
		                                        $selectConditionALL[1]="status=0";

												$form_creator ->popArr['allergyInfo']=$allergyInfo=$dr_obj->get_ip_Patient_allergies('', $selectConditionALL);
											//OT NOTES
                                                $selectConditionOP[0]="ipno='". $patient_id."'";
		                                        $selectConditionOP[1]="status=0";

												$form_creator ->popArr['otInfo']=$otInfo=$dr_obj->get_ip_ot_notes('', $selectConditionOP);

                                                $selectConditionPHY[0]="ipno='". $patient_id."'";
		                                        $selectConditionPHY[1]="status=0";


                                                $form_creator ->popArr['physical_examination']=$physical_examination=$dr_obj-> get_ip_PhysicalExamination('', $selectConditionPHY,"id",'desc');
										  
										       $selectCondition[]="a.`id`='".$patient_id."'";  
										       $selectCondition[]="b.`cancelled`=0";
										       $form_creator ->popArr['ipInfo']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',"0,3");

				                    		       break;
											
							 case 'ip_patient_documents'   :
																
												$where_doc[0]="ipno = '".$patient_id."'"; 
												$where_doc[1]="status =0"; 
												$where_doc[2]="xray_status != 1"; 
												$where_doc[3]="cust_type = 'IP'"; 

												$form_creator ->popArr['documentInfo']=$dr_obj->get_ip_Patient_documents('', $where_doc);
												$postArr['current_module']=$postArr['active_module'];

																			
												break;
							  case 'ip_patient_xray_documents'   :
																
												$where_doc[0]="ipno = '".$patient_id."'"; 
												$where_doc[1]="status =0"; 
												$where_doc[2]="xray_status = 1"; 
												$where_doc[3]="cust_type = 'IP'"; 
												$form_creator ->popArr['documentInfo']=$dr_obj->get_ip_Patient_xray_documents('', $where_doc);
												$postArr['current_module']=$postArr['active_module'];

																			
												break;

				

							 case 'ip_patient_lab_results'      :

											   $selectCondition[0]="b.`id`='". $patient_id."'";
											   // $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');
											      $selectCondition[]="b.`cancelled`=0";
										       $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');


												$billCondn[0]="type ='IP'";
												$billCondn[1]="ref_no =".$patient_id;
												$billCondn[2]="status =0";
												$billCondn[3]="lab_status =1";
												
												$form_creator ->popArr['resultInfo']=$bill_obj->getBillInfo($billCondn,'id','desc');

												break;

							 case 'ip_case_sheets'      :


                                              $selectCondition[0]="b.`id`='". $patient_id."'";
										      $selectCondition[1]="b.`cancelled`=0";
										      $form_creator ->popArr['patient_info_dropdown']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');

											   $patientCount = count($patient_info_dropdown);

											   $perPage=1;	

	                                           if(empty($postArr['current_page'])) $current_page =1;			
				                               else $current_page = $postArr['current_page'];
											
						
				                              //set limit value for query
				                              $limit=$pagi_obj->pageLimit($current_page,$perPage);	
	                                          $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page,$perPage);	
	                                          $form_creator ->popArr['current_page']=$current_page;	
	                                          $form_creator ->popArr['perPage']=$perPage;											  
	                                          if (empty($postArr['visit_date'])) {
	                                          	$selectCondition[0]="b.`id`='". $patient_id."'";
	                                          }
	                                          else{
	                                          	$selectCondition[0]="b.`id`='". $patient_id."'";
	                                          	// $selectCondition[1]="b.`id`='". $postArr['visit_date']."'";
	                                          	$form_creator ->popArr['date_selected']=$postArr['visit_date'];
	                                          }

											  
											     $form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',$limit);
											   

											   if (!empty($patientInfo)) {

												   for ($i=0; $i <count($patientInfo) ; $i++) { 

														$where[0]="ipno =".$patientInfo[$i][13];
														$where[1]="status =0"; 

														$casesheetInfo[$i][0]=$dr_obj-> get_ip_Present_complaint('', $where,"id",'asc');
														$casesheetInfo[$i][1]=$dr_obj-> get_ip_Prov_diagnosis('', $where,"id",'asc');
														$casesheetInfo[$i][2]=$dr_obj-> get_ip_Procedure_presc('', $where,"id",'asc');
														$casesheetInfo[$i][3]=$dr_obj->get_ip_Labtest_presc('', $where,"id",'asc');
														
														$casesheetInfo[$i][4]=$dr_obj->get_ip_Medicine_presc('', $where,"id",'asc');
														$casesheetInfo[$i][8]=$dr_obj->get_ip_PastHistory('', $where,"id",'asc');
														$casesheetInfo[$i][5]=$patientInfo[$i][13];
														$casesheetInfo[$i][9]=$dr_obj-> get_ip_PhysicalExamination('', $where,"id",'asc');
														$casesheetInfo[$i][11]=$dr_obj-> get_ip_Radiology_presc('', $where,"id",'asc');
														$casesheetInfo[$i][10]=$dr_obj->get_ip_Patient_allergies('', $where,"id",'asc');
                                                        $casesheetInfo[$i][12]=$a=$dr_obj->get_ip_ot_notes('', $where,"id",'asc');
                                                        $casesheetInfo[$i][13]=$b=$dr_obj->get_ip_consultation_details('', $where,"id",'asc');
                                                        
												   }

											   }

											   $form_creator ->popArr['casesheetInfo']=$casesheetInfo;
                           
												break;


				             case 'ip_patient_medicines'      :

												$selectCondition[0]="b.`id`='". $patient_id."'";
												$selectCondition[1]="b.`cancelled`=0";
										        $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');


												$where[0]="ip_no =".$patient_id;
												$where[1]="status =0"; 


												$form_creator ->popArr['medicine_info']=$medicine_info=$pharma_obj-> getPharmaInvoice($where,'id','desc');												
												break;

				             case 'patient_ip_history'      :

										       $selectCondition[]="b.`id`='".$patient_id."'";  
										       $selectCondition[]="b.`cancelled`=0";
										       $form_creator ->popArr['patientIpInfo']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc');

											
												break;

												// patient ip bill record
			                 case 'patient_ip_bill_history'      : 
												$db_obj=new DBFunction();
												$pharma_obj = new PharmaFunctions();

												$patient_ipno=$patient_id;
												$form_creator ->popArr['patient_ipno'] = $patient_ipno;
											//	$form_creator ->popArr['all_ipno_ref']= $all_ipno_ref = $reg_obj->getipno_ref($patient_id); 

												
												// $patient_ipno=$postArr['ipno'];
												$form_creator ->popArr['ipno'] = $patient_id;
												// var_dump($postArr['ipno']);
												// if($postArr['ipno']){

													$Condition = array();
													$Condition[0]="a.`ref_no` = ".$patient_id;
													$Condition[1]="a.`type` = 'IP'";
													$form_creator ->popArr['billInfo']= $a=$bill_obj->getBillInfoAllField($Condition);

                                                 
													$Condition = array();
													$Condition[0]="ip_no =".$patient_id;
													$Condition[1]="status = 0";
													$Condition[2]="cust_type = 'IP'";
													$form_creator ->popArr['medicine_info']=$medicine_info=$pharma_obj->getPharmaInvoice($Condition);

													$Condition = array();
													$Condition[0]="ipno=".$patient_id;
                                                    $Condition[1]="(bill_status !=1 and bill_status !=3)";														
	                                                $form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
												// }
											
												break;



						      case 'patient_ip_credits'      :

												$form_creator ->popArr['all_ipno']= $all_ipno = $patient_id; 
											//	$form_creator ->popArr['all_ipno_ref']= $all_ipno_ref = $reg_obj->getipno_ref($patient_id); 
                                                

												$size = sizeof($all_ipno);						  

												$Condition[0]="`type`='IP'";
												$Condition[1]="`status`=0";
												$Condition[2]="`paid_with`='CREDIT'";
												if($size>0){ 
													// $Condition[3]="`ref_no` in (".implode(",",$all_ipno).")";
													$Condition[3]="`ref_no` = ".$patient_id;
                                                    
												    $total_ipCreditInfo=$form_creator ->popArr['ipcreditInfo']=$bill_obj->get_patientCreditBill($Condition);
		                                            $total_ipcredit=0;
		                                            for($i=0;$i<count($total_ipCreditInfo);$i++){
		                                            	$total_ipcredit+=$total_ipCreditInfo[$i][13];
		                                            }
													$form_creator ->popArr['total_ipcredit'] = $total_ipcredit;
												}else{
													$form_creator ->popArr['total_ipcredit'] = 0;
												}
												// if (!empty($postArr['ipno'])) {
												// 	$Condition[3]="`ref_no`='". $postArr['ipno']."'";
												// 	$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
												// 	$form_creator ->popArr['ipcreditInfo']=$bill_obj->get_patientCreditBill($Condition);
												// }
												// else if($size>0){ 
												// 	$Condition[3]="`ref_no`='".$all_ipno[$size-1]."'";
												// 	$form_creator ->popArr['ipno_selected']= $all_ipno[$size-1];
												// 	$form_creator ->popArr['ipcreditInfo']=$bill_obj->get_patientCreditBill($Condition);
												// } 												
												

												$Condition = array();
                                                $Condition[0]="cust_type ='IP'";
                                                $Condition[1]="status = '0'";
											    $Condition[2]="payment_mode = 'CREDIT'";
											    if($size>0){ 
													$Condition[3]="`ip_no`  = ".$patient_id;

												    $total_ippharmaCreditInfo=$form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($Condition);
		                                            $total_ippharmacredit=0;
		                                            for($i=0;$i<count($total_ippharmaCreditInfo);$i++){
		                                            	$total_ippharmacredit+=$total_ippharmaCreditInfo[$i][11];
		                                            }
													$form_creator ->popArr['total_ippharmacredit'] = $total_ippharmacredit;
												}else{
													$form_creator ->popArr['total_ippharmacredit'] = 0;
												}


										   //    	if (!empty($postArr['ipno'])) {
	            //                               		$Condition[3]="`ip_no`='". $postArr['ipno']."'";
	            //                               		$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
	            //                               		$form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($Condition);
	            //                               	}
	            //                               	else if($size>0){
	            //                               	 	$Condition[3]="`ip_no`='". $all_ipno[$size-1]."'";
													// $form_creator ->popArr['ipno_selected']= $all_ipno[$size-1];
													// $form_creator ->popArr['pharmaCreditInfo']=$bill_obj->getpharmaBill($Condition);
	            //                               	}
	                                            

	                                            $Condition = array();
                                                $Condition[0]="(bill_status !=1 and bill_status !=3)";
                                                if($size>0){ 
													$Condition[1]="`ipno`  = ".$patient_id;

	                                                $total_dischargeCreditInfo=$form_creator ->popArr['IPbillInfo']=$bill_obj->getIPBillInfo($Condition);
		                                            $total_dischargepharmacredit=0;
		                                            for($i=0;$i<count($total_dischargeCreditInfo);$i++){
		                                            	$total_dischargepharmacredit+=$total_dischargeCreditInfo[$i][24];
		                                            }
													$form_creator ->popArr['total_dischargepharmacredit'] = $total_dischargepharmacredit;
												}else{
													$form_creator ->popArr['total_dischargepharmacredit'] = 0;
												}

             //                                    if (!empty($postArr['ipno'])) {
	            //                               		$Condition[1]="`ipno`='". $postArr['ipno']."'";
	            //                               		$form_creator ->popArr['ipno_selected']=$postArr['ipno'];
	            //                               		$form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
	            //                               		var_dump("sssssssssssss");
	            //                               	}
	            //                               	else if($size>0){
	            //                               	 	$Condition[1]="`ipno`='". $all_ipno[$size-1]."'";
													// $form_creator ->popArr['ipno_selected']= $patient_id;
	                                          	
													// $form_creator ->popArr['IPbillInfo']=$IPbillInfo=$bill_obj->getIPBillInfo($Condition);
	            //                               	}
												     
												break;


                             case 'ip_patient_allergies'      :
                                                           
					                                    $selectCondition[0]="ipno='". $patient_id."'";

		                                            	$selectCondition[1]="status=0";

		                                            	
												        $form_creator ->popArr['allergyInfo']=$allergyInfo=$dr_obj->get_ip_Patient_allergies('', $selectCondition);

                                                        
                                                         

							                        break;

							   case 'ip_Ot_notes'      :
                                                           
					                                    $selectCondition[0]="ipno='". $patient_id."'";

		                                            	$selectCondition[1]="status=0";

		                                            	
												        $form_creator ->popArr['otInfo']=$otInfo=$dr_obj->get_ip_ot_notes('', $selectCondition);

                                                        
                                                         

							                        break;

							   case 'ip_physical_examination'      : 

				                                     $dr_obj=new Doctor();

                                                    $selectConditionPHY[0]="ipno='". $patient_id."'";
		                                            $selectConditionPHY[1]="status=0";

                                                    $form_creator ->popArr['physical_examination']=$physical_examination=$dr_obj-> get_ip_PhysicalExamination('', $selectConditionPHY,"id",'desc');      
                                                         

							                        break;



								     }								
                              

												   $form_creator ->popArr['postArr']=$postArr;
					                               $form_creator ->formPath ='/templates/patient_record/ip_view_patient_record.php';	
					                          break;

					    case 'ip_show_creditBills' :

												$bill_obj=new Billing();

												if (!empty($getArr['id'])) {
													$where[0]="b.`bill_no` =".$getArr['id'];
													$where[1]="b.`status` =0";  
													$form_creator ->popArr['credit_item_info']=$credit_item_info=$bill_obj-> getfullCreditInfo($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/ip_show_credit_bills.php';	

											break;
					     case 'ip_show_pharmacreditBills' :
                        
												$bill_obj=new Billing();
                                                  
												if (!empty($getArr['id'])) {
													$where[0]="`bill_no` =".$getArr['id'];
													$where[1]="`status` =0";  
													$form_creator ->popArr['credit_pharma_item_info']=$credit_pharma_item_info=$bill_obj-> getpharmaCreditPayment($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/ip_show_pharma_credit_bills.php';	

											break;

						 case 'ip_show_dischargecreditBills' :
                        
												$bill_obj=new Billing();
                                                  
												if (!empty($getArr['id'])) {
													$where=array();
													$where[0]="`billid` =".$getArr['id']; 
													$form_creator ->popArr['credit_pharma_item_info']=$credit_pharma_item_info=$bill_obj-> getIPCreditPayments($where);

													

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/ip_show_discharge_credit_bills.php';	

											break;
											


					     case 'ip_show_medicines' :

												$pharma_obj=new pharmaFunctions();

												if (!empty($getArr['id'])) {

													$where[0]="bill_id =".$getArr['id'];
													$where[1]="status =0";  
													$form_creator ->popArr['medicine_item_info']=$medicine_item_info=$pharma_obj-> getPharmaInvoiceItems($where);

												}

												$form_creator ->popArr['postArr']=$postArr;
												$form_creator ->formPath ='/templates/patient_record/ip_show_medicines.php';	

											break;




																		
//...........................................................................................................................
			}
			
			$form_creator->display();
	
	}
	
function print_ip_casesheet($getArr=null){

	  $reg_obj= new Registration();
      $dr_obj=new Doctor(); 
	  $bill_obj=new Billing();
	  $ip_obj= new Inpatient();
	  $lab_obj= new LabModel();
	  $pagi_obj = new Pagination();
	  $pharma_obj=new pharmaFunctions();
	  $com_obj = new CommonFunctions();
	  $form_creator = new Form();
      $gen_obj = new General();

      $patient_id = $getArr['id'];

     

  	$selectCondition[0]="b.`id`='". $patient_id."'";
  	$selectCondition[1]="b.`cancelled`= 0";
  
  
     $form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',$limit);

// var_dump(expression)
   if (!empty($patientInfo)) {

	   for ($i=0; $i <count($patientInfo) ; $i++) { 

			$where[0]="ipno =".$patient_id;
			$where[1]="status =0"; 

			$casesheetInfo[$i][0]=$dr_obj-> get_ip_Present_complaint('', $where);
			$casesheetInfo[$i][1]=$dr_obj-> get_ip_Prov_diagnosis('', $where);
			$casesheetInfo[$i][2]=$dr_obj-> get_ip_Procedure_presc('', $where);
			// $casesheetInfo[$i][3]=$dr_obj->get_ip_Labtest_presc('', $where,"id",'desc');
			$casesheetInfo[$i][3]=$dr_obj->get_ip_Labtest_presc('', $where);

			$casesheetInfo[$i][4]=$dr_obj->get_ip_Medicine_presc('', $where);
			$casesheetInfo[$i][8]=$dr_obj->get_ip_PastHistory('', $where);
			$casesheetInfo[$i][5]=$patient_id;
			$casesheetInfo[$i][9]=$dr_obj-> get_ip_PhysicalExamination('', $where,"id",'desc');
			$casesheetInfo[$i][11]=$dr_obj-> get_ip_Radiology_presc('', $where);
			$casesheetInfo[$i][10]=$dr_obj->get_ip_Patient_allergies('', $where,"id",'desc');
            $casesheetInfo[$i][12]=$a=$dr_obj->get_ip_ot_notes('', $where,"id",'desc');
            $casesheetInfo[$i][13]=$b=$dr_obj->get_ip_consultation_details('', $where,"id",'desc');
            
	   }

   }

     $form_creator ->popArr['casesheetInfo']=$casesheetInfo;        

$form_creator ->formPath ='/templates/patient_record/print_ip_casesheet.php';
			$form_creator->display();


}




	function processOPSearch($postArr){
	
	 $com_obj = new CommonFunctions();
		$reg_obj= new Registration();
			
	    $selectCondition=array();											
		 if(!empty($postArr['from_date'])){
														  
			$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
															
			$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
														
	    }
		if(!empty($postArr['to_date'])){
														   
			$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);												
			$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";												
		 }													 											  
		  if(!empty($postArr["name"])){												  
														
			$selectCondition[]="a.`first_name` like '%".$postArr["name"]."%'";													
		}													
		if(!empty($postArr["place"])){													
																
			$selectCondition[]="a.`place`='".$postArr["place"]."'";		
        }			
															
		if(!empty($postArr["doctor"])){													
															
				$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";	
        }
		if(!empty($postArr["telNo"])){												  
														
			$selectCondition[]="a.`contact_no` = '".$postArr["telNo"]."'";													
		}	

		$selectCondition[]="b.`cancelled`= 0";

		if(!empty($selectCondition)){
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','desc');
				$tablerow =	'';									   
			if(!empty($patientInfo)){
				$j=1;
				for($i=0;$i<count($patientInfo);$i++){
				
					$patient_name=$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];
					
					$tablerow.= "<tr>";
					
					$tablerow.="<td>";
					$tablerow.= $j++;
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][0];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$function='redirect("'.$patientInfo[$i][0].'")';
					$tablerow.= "<a href='#' onclick='$function'>$patient_name</a>";
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][4];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][6];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][8];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= date("d-m-Y",strtotime($patientInfo[$i][20]));
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][19];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][23];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= "DR. ".$patientInfo[$i][15]." ".$patientInfo[$i][16];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][32];
					$tablerow.="</td>";
					
					
				
				}
			
			}
		}
			echo $tablerow;
			//$data['tableInfo']=$tablerow;
			
			//echo json_encode($data);
	}
	function processOPNo($post,$get = null){ 

		$form_creator = new Form();
		
		$reg_obj= new Registration();
		$emp_obj= new Employee();
		$inc_obj= new InsuranceCompany();
		$db_obj=new DBFunction();
		$dep_obj=new Department();		
		$com_obj = new CommonFunctions();
		$gen_obj = new General();
		$bk_obj = new Booking();
		$bill_obj=new Billing();
		$ip_obj= new Inpatient();
		$pati_cat_obj = new PatientCategory();
		
		$todate =$com_obj->getcurrentDate();

		$booking_status="0";
		
		if(!empty($post['id'])){
			$opid=$post['id'];
			$selectCondition[0]="b.`id`='".$opid."'";
		}else{
			$opno=$post['opno'];
			$selectCondition[0]="a.`id`='".$opno."'";
		}
		
		if(!empty($get['bk_id'])){
			
			$wheredata[0]="id='".$get['bk_id']."'";
			$bkInfo=$bk_obj->getBookingList($wheredata);
			$docid=$bkInfo[0][2];
			$post['bk_id']=$bkInfo[0][0];
			$post['token']=$bkInfo[0][1];
			$selectCondition[1]="b.`doc_id`='".$docid."'";
			$selectCondition[2]="b.`cancelled`='0'"; //new
			
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'visit_date','desc');
			
			if(empty($patientInfo)){
				$booking_status="0";
			}else $booking_status=1;
			
			unset($selectCondition[1]);
		
		}
		$selectCondition[1]="b.`cancelled`='0'";
		
		if($booking_status == 0 ) {
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'visit_date','desc');
		}
		// var_dump($patientInfo);
		if(!empty($patientInfo)){
		
			$post['opno']=$opno=$patientInfo[0][0];			
			$validity = $patientInfo[0][21];
			$age_patient=$patientInfo[0][4];



                  
                                                          //for age increasing 
		
			                 if(empty($post['dob'])){
				                $age_in=explode(" ",$age_patient);
								$age1=$age_in[0];
								$age_type=$age_in[1];
				             
							    $vInfo[0]="opno =".$opno;	
				                $first_visit=$reg_obj->getfirstVisit($vInfo);


                               
				                if($age_type=='Y'){

				                	$today=date("Y");
				                	//$visit_d=date("Y",strtotime($first_visit[0][1]));
				                     $last_v=date("Y",strtotime($patientInfo[0][20]));
                                     $dif=$today-$last_v;
                                  
 
					                if($dif==0)
					                   {
					                   	$age=$age1;
					                   }
					                   else{
					                   	$age=$age1+$dif;
					                   }
					               
				                }
				                elseif ($age_type=='M') {
				      	
				                	$today=date("Y-m-d");
				                	//$visit_d =date("Y-m-d",strtotime($first_visit[0][1]));
                                    $last_v=date("Y-m-d",strtotime($patientInfo[0][20]));
			               
									 $date1 = new DateTime($last_v);
									 $today_date = new DateTime($today);
									 $date2 = $date1->diff($today_date);

								

							            $d=$date2->days.'Total days'."\n";
									    $yr=$date2->y.' years'."\n";
							            $months= $date2->m.' months'."\n";

                                            if($yr!=0){
									         $mnth=floor(($yr*12)+$age1); "\n";
									         }
									         else{
									         	
									         $mnth=floor($months+$age1); "\n";
									         }
                                         
									    
									       $yr= floor($d/365);
                                    if($today==$last_v)
                                    {
                                    $age=$age1;	
                                    }
                                    else{
	                                    if($mnth<12){
	                                    $age=$mnth;
	                                    $age_type='M';
	                                    }
						               
						                else{
						                	
						              	$age=floor($mnth/12);
						              	$age_type='Y';
						              
						               }
					               }
				                }
				                else{
				                	
				                	$today=date("Y-m-d");
				              
				                    $last_v=date("Y-m-d",strtotime($patientInfo[0][20]));

				                      $date1 = new DateTime($last_v);
									  $date2 = $date1->diff(new DateTime($today));
									  $dy=$date2->days.'Total days'."\n";
									  $date2->y.' years'."\n";
									  $months= $date2->m.' months'."\n";
									  $date2->d.' days'."\n";
									 
									   $s=$dy+$age1;
									   $mnth= floor($s/30);echo "\n";
									   $yr= floor($mnth/12);
                                       $day=$dy+$age1;

                                    if($today==$last_v)
                                    {
                                    $age=$age1;	
                                    }
                                    else{
	                                    if($s<=31){	
	                                    $age=$s;
	                                   
	                                    $age_type='D';
	                                    }
	                                    else{
	                                    	if($s>31 && $s<365)
	                                    	{
	                                    		$age=$mnth;
	                                    		$age_type='M';
	                                    	}
	                                    	else
	                                    	{
	                                    		$age=$yr;
	                                    		$age_type='Y';
	                                    	}
	                                     }
						               
					                  }
					              }
				                }
				                $post['age_type']=$age_type;
		   

            //for age increasing 



			$dob=$patientInfo[0][5];
			$visit_date=date("Y-m-d",strtotime($patientInfo[0][20]));
			//$free =$patientInfo[0][41];
			
			//if($free == 1) $post['free']=1;
			
			if($booking_status ==0 && empty($get['bk_id'])){
			
				$docid=$patientInfo[0][14];			
				
			}else $validity =date("Y-m-d");
			
			//check for patient credit
			
			//credit bill info
												
			$wheredata[0]="opno ='".$opno."'";
			$opbill_credit=$bill_obj->getOPCreditBillAmt($wheredata);
												
			//pharma credit Bill
											  
			$phwhere[]="op_no = '".$opno."'";
			$oppharma_credit=$bill_obj->getOPPharmaCreditAmt($phwhere,"0,3");
			
			//ip credit Bill
											  
			$ipwhere[]="opno = '".$opno."'";
			$ip_credit=$bill_obj->getIPCreditAmt($ipwhere);
			
			$total_credit=$opbill_credit+$oppharma_credit+$ip_credit;
			
			$post['total_credit'] =$total_credit;
			
			if(!empty($post['id'])){ 
				
				$status =$patientInfo[0][32];
				
				//$docfee=$patientInfo[0][17];

				if ( !empty($post['revisit']) && $post['revisit']=="REVISIT" ) { 
					$docfee=0;
					$reg_fee=0;
					$cardfee=0;
				}
				else{
					$docfee=$patientInfo[0][17];
					$regfee=$patientInfo[0][18];
					$cardfee=$patientInfo[0][52];
				}

				
				
				$card_expiry=$patientInfo[0][53];
				$card_issued=$patientInfo[0][54];
				
				$age_in=explode(" ",$age);
				$age=$age_in[0];
				$age_type=$age_in[1];
				
				/*..... health checkup.....*/	
                  $post['health_checkup']=$patientInfo[0][58];
		  		// for free
                   $post['free']=$patientInfo[0][83];
				
				if ( !empty($post['revisit']) && $post['revisit']=="REVISIT" ) {
					$form_creator ->popArr['action']="REG_UPDATE";
					$status ="REVISIT";
				}
				else{
					$form_creator ->popArr['action']="REG_UPDATE";
				}

				
				$post['refferal_info']=$patientInfo[0][34];
			}else{ 
			
					if($visit_date == $todate && empty($get['bk_id'])) {
						 $status ="REVISIT";
					}

					//for booking
					if(!empty($get['bk_id'])){		
						$wheredata[0]="id='".$get['bk_id']."'";
						$bkInfo=$bk_obj->getBookingList($wheredata);
						$docid1=$bkInfo[0][2];
						$docid2=$reg_obj->duplicateDoc($todate,$opno,$docid1);	
						if($docid1==$docid2){
						 // echo "rev:";
							$status ="REVISIT";
						}
						else{
						 // echo 1111;
							$docid=$docid1;
							$max_validity = $reg_obj->getValidity($opno,$docid);
							if(!empty($max_validity) && $max_validity!=0){
								$validity = $max_validity;
							}
							else{
								$validity = "0000:00:00";
							}
							// echo "Validity:".$validity;exit;
						}
					} 
					// echo "Validity:".$validity;
					// echo "todate:".$todate;

					if($validity < $todate){ 
					
						if($status!='REVISIT')
							$status ="RENEW";
						// echo "renew";
				
						//doctor fee
				
						$is_field[0]="a.id ='".$docid."'";
					
						$docinfo=$emp_obj->getEmployee($is_field);
						$docfee=$docinfo[0][19];
						$post['validity_days']=$docinfo[0][23];
				
						//registration fees
						$selectfield[0]="reg_fee";
						$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
						$regfee=$reg_fee[0][0];
				
					}else { //echo 11; //new->visit,visit -> renew
						if($status!='REVISIT'){ //visit -> renew
							//echo 22;

											$opno=$post['opno'];
											
											$selectConditions[0]="a.`id`='".$opno."'";
											$selectConditions[1]="b.`doc_id`='".$docid."'";
											if(!empty($post['id'])){
												$selectConditions[2]="b.`id`<'".$post['id']."'";
											}
											$selectConditions[]="b.`cancelled`='0'";
											$selectConditions[]="b.`visit_status`='VISIT'";
											// var_dump($selectCondition);exit;
											$patientInfo_visit_check=$reg_obj->getOPPatientInfo('',$selectConditions,'','');
											$visit_count=count($patientInfo_visit_check);
											//echo "visit count"."".$visit_count;
										  // var_dump($patientInfo_visit_check);exit;
											$op_validity_status=$post['op_validity_status'];
											
											// if($visit_count < 1){
											// 	$status ="VISIT";
											// 	$docfee=0;
											// 	$regfee=0;

											// }else{
											// 	$status="RENEW";
											// 	$is_field[0]="a.id ='".$docid."'";
					
											// 	$docinfo=$emp_obj->getEmployee($is_field);
											// 	$docfee=$docinfo[0][19];
											// 	$post['validity_days']=$docinfo[0][23];
										
											// 	//registration fees
											// 	$selectfield[0]="reg_fee";
											// 	$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
											// 	$regfee=$reg_fee[0][0];
												
											// }
											//One time free within validity

											//echo 'status'."".$patientInfo[0][32];
											//echo 'op_validity_status'." ".$op_validity_status;

										if($op_validity_status == 'ONE TIME FREE'){ 
											//echo 33; 
											if($visit_count < 1){
												$status ="VISIT";
												$docfee=0;
												$regfee=0;

											}else{
												$prev_status=$patientInfo[0][32];
												if($prev_status=='REVISIT'){
													$db_function =new DBFunction();
										$wheredata_mul=array();
										$wheredata_mul[0] = "cancelled = 0";
										$wheredata_mul[1] = "opno = '".$opno."'";
										$wheredata_mul[2] ="visit_status != 'REVISIT'";

										$prev_status_id=$db_function->getIdToValueMultiple("max(id)",$wheredata_mul,"hcare_op_visit_info");
										// var_dump($prev_status_id);
										$prev_status=$db_function->getidToValue("visit_status","id",$prev_status_id,"hcare_op_visit_info");
												}
												if(($prev_status!='RENEW') && $visit_count >= 1){
													//echo 'after one visit';
													$status="RENEW";
												$is_field[0]="a.id ='".$docid."'";
					
												$docinfo=$emp_obj->getEmployee($is_field);
												$docfee=$docinfo[0][19];
												$post['validity_days']=$docinfo[0][23];
										
												//registration fees
												$selectfield[0]="reg_fee";
												$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
												$regfee=$reg_fee[0][0];

												}else if($prev_status=='RENEW'){ //echo 'prev renw';
													$status ="VISIT";
												$docfee=0;
												$regfee=0;
												}

	
											}
										}
										//All time free within validity	
									if($op_validity_status == 'FULL FREE'){ //echo 44;
										
												$status ="VISIT";
												$docfee=0;
												$regfee=0;

											

										}
											
						}
						// 	$status ="VISIT";
						// $docfee=0;
						// $regfee=0;
					}
					$card_issued='';
			$where_card_expiry[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
			$validity_info= $gen_obj->getOpSettings('',$where_card_expiry,'','');
			 // var_dump($validity_info);		
			
			$card_expiry=$db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
			
			if($card_expiry == '0000-00-00' || $card_expiry == '1970-01-01'){
			
			    $vInfo[0]="opno =".$opno;
			    $first_visit=$reg_obj->getfirstVisit($vInfo);
			    if($validity_info[0][6]=='Y'){
					$no_of_year=$validity_info[0][5];
					$y = strtotime("+$no_of_year year");
					$card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+y"));
					// $y = strtotime("$no_of_year year");
					// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + $no_of_year year"));
				}else{
					$no_of_year=$validity_info[0][5];
						$m = strtotime("+$no_of_year month");
				    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+m"));
					// $m = strtotime("$no_of_year month");
				 //    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " +$no_of_year month"));

				}
				// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + 1 year"));
			}
			
			if(strtotime($card_expiry) < strtotime($todate)){ 
				$selectfield[0]="card_fee";
				$card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');;
				$cardfee=$card_fee[0][0];
				if($validity_info[0][6]=='Y'){
					$no_of_year=$validity_info[0][5];
					$y = strtotime("+$no_of_year year");
					$card_expiry= date('d-m-Y', "+$y");
					// $y = strtotime("$no_of_year year");
					// $card_expiry= date('d-m-Y', "+$y years");
				}else{
					$no_of_year=$validity_info[0][5];
					$m = strtotime("+$no_of_year month");
					$card_expiry =date('d-m-Y', "+$m");
					// $m = strtotime("$no_of_year month");
					// $card_expiry =date('d-m-Y', "+$m months");

				}
				// $card_expiry =date('Y-m-d', strtotime('+1 year'));
				$card_issued ="RENEW";
			}else $cardfee=0;
			//Calculate age
		
			//$ageInfo=$this->calculateAge($dob,$age);
			//$age=$ageInfo[0];
			//$age_type=$ageInfo[1];
			
			$age_in=explode(" ",$age);
			$age=$age_in[0];
			$age_type=$age_in[1];
			
			$form_creator ->popArr['action']="REGISTRATION";
		}
		// echo $card_expiry; echo 111;
			
			
			$post['card_expiry']=date("d-m-Y",strtotime($card_expiry));
			$post['card_issued'] =$card_issued;
			$post['first_name']=$patientInfo[0][1];
			$post['middle_name']=$patientInfo[0][2];
			$post['last_name']=$patientInfo[0][3];
			$post['age']=$age;
			//$post['age_type']=$age_type;
		
			$post['gender']=$patientInfo[0][6];
			$post['marital_status']=$patientInfo[0][7];
			$post['place']=$patientInfo[0][8];
			$post['nationality']=$patientInfo[0][9];
			$post['contact_no']=$patientInfo[0][10];
			$post['email']=$patientInfo[0][11];
			$post['doctor']=$docid;
			$post['docfee']=$docfee;
			$post['regfee']=$regfee;
			$post['cardfee']=$cardfee;
			//for fee discount
			$post['regfee_disc']=$patientInfo[0][83];
			$post['cardfee_disc']=$patientInfo[0][85];

			$post['insurance_company']=$patientInfo[0][22];
			$post['policy_no']=$patientInfo[0][24];
			$post['claim']=$patientInfo[0][25];
			$post['company_name']=$patientInfo[0][26];
			$post['company_id']=$patientInfo[0][27];
			$post['relation']=$patientInfo[0][28];

			$post['guardian_type']=$patientInfo[0][60];
			$post['guardian']=$patientInfo[0][61];
			$post['house_name']=$patientInfo[0][59];
			$post['aadhar']=$patientInfo[0][62];
			$post['address']=$patientInfo[0][63];
			$post['contact_no2']=$patientInfo[0][64];

			//for member category
			$post['member_patient_id']=$patientInfo[0][79];
			$post['member_id']=$patientInfo[0][80];

			$post['member_patient_id_name']= $patientInfo[0][81];
			$post['member_name']= $patientInfo[0][82];
			$post['payment_mode']= $patientInfo[0][95];


			if($patientInfo[0][29] !='0000-00-00' && $patientInfo[0][30] !='0000-00-00'){
				$post['date_issue']=date("d-m-Y",strtotime($patientInfo[0][29]));
				$post['date_expiry']=date("d-m-Y",strtotime($patientInfo[0][30]));
			}
			if($patientInfo[0][5] !='0000-00-00' && $patientInfo[0][5] !="1970-01-01"){
					$post['dob']=date("d-m-Y",strtotime($patientInfo[0][5]));
			}
			
			if($post['insurance_company']>0){
				$post['inc']="insurance";
			}
			if(!empty($patientInfo[0][38] )){
			
					$post['mlc']="mlc";
					$post['mlc_date']=$patientInfo[0][20];
					$post['mlc_time']=$patientInfo[0][19];
					$post['mlc_summary']=$patientInfo[0][38];
			}
					
			
			if($patientInfo[0][22] >0 ){
			
					$is_field[0]="a.valid_upto >='".$todate."'";
					$form_creator ->popArr['insurance_company']=$inc_obj->getInsCompany($is_field);
			}
/*..... ip_discharge .....*/	
            $selectCondition[]="b.`opno` ='".$opno."'";

		    $select_field[]="b.`discharge_date`";
        
            $limit=1;
            
            $ip_discharge=$ip_obj->getIPPatientInfo($select_field,$selectCondition,'b.id','desc',$limit);

			$post['ip_discharge']=$ip_discharge[0][0];	
/*..... ip_discharge .....*/	

/*..... patient categroy .....*/	
            $post['patient_category']=$patientInfo[0][56];

/*..... observation status .....*/	
            $post['observation_status_op']=$patientInfo[0][62];
			
			$post['patient_address']= $patientInfo[0][92];
/*..... patient categroy .....*/	
			$form_creator ->popArr['post']=$post;		
		    
		}else {
		
			$form_creator ->popArr['message1']="Invalid OP Number";
			if(!empty($get['bk_id'])){
				$form_creator ->formPath ='/templates/booking/booking_report.php';
				$form_creator->display();
				exit();
			}
		}
			$is_field[0]="a.title ='Dr'";
			if(!empty($get['bk_id'])){
				$is_field[1]="a.id ='".$bkInfo[0][2]."'";
			}
			$form_creator ->popArr['doctors']=$docinfo=$emp_obj->getEmployee($is_field);
			$form_creator ->popArr['departments']=$dep_obj->getDepartment();
			$form_creator ->popArr['countries']=$db_obj->getCountries();
			$form_creator ->popArr['patient_category']=$pati_cat_obj->getPatientCategory();
			$form_creator ->popArr['status']=$status;
			

			$form_creator ->popArr['post']=$post;	
			// echo $status;exit;


			$form_creator ->formPath ='/templates/registration/registration_form.php';
			$form_creator->display();
	
	}
	function calculateAge($dob = null ,$age = null ){
	
			if($dob !='0000-00-00'){
			
				$value = ((time() - strtotime($dob)) / 31556926);
				if($value < 1) {
					$age_value = (round(((time() - strtotime($dob)) / 31556926),2)*10);
					if($age_value < 1){
					
								
						$age = ($age_value+.1)*30;
						$age_type="D";
						
					}else{
						$age=ceil($age_value);
						$age_type="M";
					}
					
				}else{
					$age = floor((time() - strtotime($dob)) / 31556926);
					$age_type="Y";
				}
				
			}else if($age !=''){
			
				$age_in=explode(" ",$age);
				$age=$age_in[0];
				if($age_in[1] == "Y"){
					$age_type="year";
				}else if($age_in[1] == "M"){
					$age_type="month";
				}else $age_type ="days";
				
				$dob_exp=date("Y-m-d",strtotime("-".$age."$age_type"));
				
				$age = floor((time() - strtotime($dob_exp)) / 31556926);
				$age_type=$age_in[1];
			}else {
				$age_in=explode(" ",$age);
				$age=$age_in[0];
				$age_type=$age_in[1];
			}
			
		return array($age,$age_type);	
	}
	function processRegForm($post){ 
	  
			$form_creator = new Form();
			$emp_obj= new Employee();
			$inc_obj= new InsuranceCompany();
			$db_obj=new DBFunction();
			$dep_obj=new Department();
			$gen_obj = new General();
			$com_obj = new CommonFunctions();
			$reg_obj= new Registration();
			$pati_cat_obj = new PatientCategory();
			
			$dep_id=$post['department'];
			$inc=$post['inc'];
			$mlc=$post['mlc'];
			$inc_company=$post['insurance_company'];
			$pat_category=$post['patient_category'];
			$docid=$post['doctor'];
			$status=$post['status'];
			$action=$post['paction'];
			$todate =$com_obj->getcurrentDate();
			$docfee=0;
			$reg_fee=0;

			//for member category
			$member_id = $post['member_id'];
			$member_patient_id = $db_obj->getidToValue('patient_ref_id','id', $member_id,'hcare_patient_category_members');
			$post['member_patient_id']=$member_patient_id;
			if($member_id){
				$post['member_details'] = $reg_obj->getMemberDetails($member_id);
				$post['member_patient_id_name'] = $db_obj->getidToValue('patient_id','id', $member_patient_id,'hcare_patient_category_ids');
			}

			//if department selected show doctors in selected department else show all doctors
			if($dep_id !='') {
				$is_field[0]="a.title ='Dr'";
				$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field,$dep_id);
			}else{
				$is_field[0]="a.title ='Dr'";
				$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
			}
			
			//If insurance checked true then show insurance companies
			if($inc != ''){
				$is_field[0]="a.valid_upto >='".$todate."'";
				$form_creator ->popArr['insurance_company']=$inc_obj->getInsCompany($is_field);
			}

			//if doctor selected then get doc fee and reg fee
			if($docid!=''){
					$is_field=array();					
					$is_field[0]="a.id ='".$docid."'";					
					$docinfo=$emp_obj->getEmployee($is_field);

					$post['validity_days']=$docinfo[0][23];

					
					if(!empty($post['opno']) && $status!="NEW"){
					
						$opno=$post['opno'];
						$selectCondition[0]="a.`id`='".$opno."'";
						$selectCondition[1]="b.`doc_id`='".$docid."'";
						if(!empty($post['id'])){
							$selectCondition[2]="b.`id`<'".$post['id']."'";
						}
						$selectCondition[]="b.`cancelled`='0'";
						$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','desc');

						//edit
						$opno=$post['opno'];
						$selectCondition[0]="a.`id`='".$opno."'";
						if(!empty($post['id'])){
							$selectCondition[1]="b.`id`<'".$post['id']."'";
						}
						$selectCondition[]="b.`cancelled`='0'";
						$count1=$reg_obj->getOPPatientCount($selectCondition);
						$docid2=$reg_obj->duplicateDoc($todate,$opno,$docid);
						//end edit	
						if(!empty($patientInfo)){
												
							$validity = $patientInfo[0][21];
							// echo $validity;
							$visit_date=date("Y-m-d",strtotime($patientInfo[0][20]));
							// echo " ".$visit_date;
							// if($visit_date == $todate) $form_creator ->popArr['message1']="Patient Already Registered for Selected Doctor!";
							if($visit_date == $todate) {
								$status ="REVISIT";
							}
							
							if ($status=="REVISIT") {
								$status ="REVISIT";
							}
							else if( (strtotime($validity) < strtotime($todate)) && ($status!="REVISIT" && $status!="VISIT") ){				
								$status ="RENEW"; 
							}
							else if ((strtotime($validity) > strtotime($todate)) && ($status!="REVISIT" && $status!="VISIT") && $post['paction']=="REG_UPDATE" ) {
								$status ="RENEW"; 
							}
							else{
											$opno=$post['opno'];
											
											$selectCondition[0]="a.`id`='".$opno."'";
											$selectCondition[1]="b.`doc_id`='".$docid."'";
											if(!empty($post['id'])){
												$selectCondition[2]="b.`id`<'".$post['id']."'";
											}
											$selectCondition[]="b.`cancelled`='0'";
											$selectCondition[]="b.`visit_status`='VISIT'";
											$patientInfo_visit_check=$reg_obj->getOPPatientInfo('',$selectCondition,'','');
											$visit_count=count($patientInfo_visit_check);
											// echo $visit_count;
											//  var_dump($patientInfo_visit_check);
											//old
											// if($visit_count < 1 ){
											// 	$status ="VISIT";

											// }else{
											// 	$status="RENEW";
											// }
										//new
											$prev_status=$patientInfo[0][32];
											if($prev_status=='REVISIT'){
													$db_function =new DBFunction();
										$wheredata_mul=array();
										$wheredata_mul[0] = "cancelled = 0";
										$wheredata_mul[1] = "opno = '".$opno."'";
										$wheredata_mul[2] ="visit_status != 'REVISIT'";

										$prev_status_id=$db_function->getIdToValueMultiple("max(id)",$wheredata_mul,"hcare_op_visit_info");
										// var_dump($prev_status_id);
										$prev_status=$db_function->getidToValue("visit_status","id",$prev_status_id,"hcare_op_visit_info");
												}

											if(($visit_count < 1 ) && (strtotime($validity) >= strtotime($todate))){
												$status ="VISIT";

											}else if(($visit_count >= 1) && (strtotime($validity) >= strtotime($todate)) && $post['op_validity_status']=="FULL FREE"){
												//echo 'aaa';
												//echo $validity;
												$status ="VISIT";

											}else if(($visit_count >= 1) && (strtotime($validity) >= strtotime($todate)) && ($prev_status !='RENEW') && $post['op_validity_status']=="ONE TIME FREE"){
												//echo 'prev not renew';
												//echo $validity;
												$status ="RENEW";

											}else if(($visit_count >= 1) && (strtotime($validity) >= strtotime($todate)) && ($prev_status =='RENEW') && $post['op_validity_status']=="ONE TIME FREE"){
												//echo 'prev renew';
												//echo $validity;
												$status ="VISIT";

											}else{
												//echo 'b else';//exit;
												$status="RENEW";
											}
							}
						
						}//edit
						else if($action=='REG_UPDATE' && empty($patientInfo) && $count1>0){
							$status ="RENEW"; 
						}
						else if($action=='REG_UPDATE' && empty($patientInfo)){
							$status ="NEW"; 
						}
						else if($action=='REGISTRATION' && empty($patientInfo) && $docid == $docid2){
							$status ="REVISIT"; 
						}
						else{
							$status ="RENEW";
						}
						//end of edit
					}else {
						$status ="NEW";
					}

										
					switch($status) {
					
						case 'VISIT'	: 	 
											// echo $validity;
											// echo " ".$visit_date;
											$docfee=0;
							           		$regfee=0;
							           		$cardfee= $db_obj->getidToValue('cardfee_before_disc','id', $post['id'],'hcare_op_visit_info')-$db_obj->getidToValue('cardfee_disc','id', $post['id'],'hcare_op_visit_info');
											break;

						case 'REVISIT'	: 	$docfee=0;
							           		$regfee=0;
								       		$cardfee=0;
								       		break;

						default	 		:
							   				$docfee=$docinfo[0][19];
										
							    			if($action == "REG_UPDATE"){
							    	 			//registration fees
										        $selectfield[0]="reg_fee";										
							        			$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
							        			$regfee=$reg_fee[0][0]; 
						                        // $regfee=$post['regfee'];									

										        $cardfee= $db_obj->getidToValue('cardfee_before_disc','id', $post['id'],'hcare_op_visit_info')-$db_obj->getidToValue('cardfee_disc','id', $post['id'],'hcare_op_visit_info');
						                        //$cardfee=$post['cardfee'];

			                        
			                     			}else { 
			                     				//registration fees
							        			$selectfield[0]="reg_fee";		
							        			// $where[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
							        			// $reg_fee= $gen_obj->getOpSettings($selectfield,$where,'','');								
							        			$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
							        			$regfee=$reg_fee[0][0]; 
											    if($status == "NEW"){
												    $selectfield[0]="card_fee";
												    // $where[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
							        	// 		$card_fee= $gen_obj->getOpSettings($selectfield,$where,'','');
												    $card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
												    $cardfee=$card_fee[0][0];
											    }
					                
											}
											break;
					
					}	

					
					$emp_depid=$docinfo[0][10];
					
					
					if($dep_id!='' && $dep_id!=$emp_depid){
						$docfee='';
					}
					
					
			}




			$post['docfee_actual']=$docfee;

			$ins_cons_disc_type='';
			$ins_cons_disc_value='';
			$pcat_cons_disc_type='';
			$pcat_cons_disc_value='';

			//If insurance company selected then get doctor fee after insurance deduction
           
			if(!empty($inc_company) && !empty($inc)){

				$disc_info=$this->getinsuranceDeduction($inc_company,"CONSULTATION",$docfee);
			   
				$docfee =$docfee - $disc_info[2];
				$ins_cons_disc_type=$disc_info[0];
				$ins_cons_disc_value=$disc_info[1];	
			}

			//health checkup
			if(!empty($post['free'])){
				$docfee=0;
                $regfee=0;
	      	}


			if($status!='NEW'){ 
				$card_ex = $db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
			}

			if(!empty($post['health_checkup'])){									  
			  	$docfee=0;
               	$regfee=0;
               	$cardfee=0;									  
		  	}
			if(empty($post['health_checkup']) && ($card_ex < $todate)){ 
				// $regfee=$post['regfee']; 
		        $selectfield[0]="card_fee";
		  //        $selectfield[0]="card_fee";
				//  $where[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
				// $card_fee1= $gen_obj->getOpSettings($selectfield,$where,'','');
			    $card_fee1=$gen_obj->getOpSettings($selectfield,'','id','desc');;
			    $cardfee=$card_fee1[0][0];
			}	

            //patient category deduction
			if(!empty($pat_category)){
				$selectfield[0]="reg_fee";
				$selectfield[1]="card_fee";
				$disc_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
				$regfee_actual=$disc_fee[0][0];
				$cardfee_actual=$disc_fee[0][1];

				$disc_array = array('category'=>$pat_category,
									'type' =>"CONSULTATION",
									'doc_fee_value'=>$docfee,
									'reg_fee_value'=>$regfee_actual,
									'card_fee_value'=>$cardfee_actual);
			    $disc_info=$this->getpatientcategoryDeduction($disc_array);

				$docfee =$docfee - $disc_info[0][2];

				$pcat_cons_disc_type=$disc_info[0][0];
				$pcat_cons_disc_value=$disc_info[0][1];

				$regfee =$regfee - $disc_info[1][2];

				$pcat_reg_disc_type=$disc_info[1][0];
				$pcat_reg_disc_value=$disc_info[1][1];

				$cardfee =$cardfee - $disc_info[2][2];

				$pcat_card_disc_type=$disc_info[2][0];
				$pcat_card_disc_value=$disc_info[2][1];
			}
          			
			if($post['dob']!=''){
				$ageInfo=$this->calculateAge($post['dob']);				
				
				$post['age']=$ageInfo[0];
				$post['age_type']=$ageInfo[1];
			}
			// patient category members id	
			if($pat_category){		
				$patient_ids = $reg_obj->iftherepatientids($pat_category);
				if($patient_ids){
					$post['patient_ids']=1;
				}
				else{					
					$post['member_id'] = null;
					$post['member_patient_id'] = null;
				}
			}
/*.... Discont Details ....*/
			$post['ins_cons_disc_type']=$ins_cons_disc_type;
			$post['ins_cons_disc_value']=$ins_cons_disc_value;
			$post['pcat_cons_disc_type']=$pcat_cons_disc_type;
			$post['pcat_cons_disc_value']=$pcat_cons_disc_value;
/*.... Discont Details ....*/			
			
			$post['docfee']=$docfee;
			if($regfee>0){
				$post['regfee']=$regfee;
			}
			else{
				$post['regfee']=0;
			}
			if($cardfee>0){
				$post['cardfee']=$cardfee;
			}
			else{
				$post['cardfee']=0;
			}
			
		if($post['paction2'] == "SAVE"){
           	$post['paction']=$action;
			$post['status']=$status;
			
          	$this->processRegistration($post);
        }else{		
			$form_creator ->popArr['departments']=$dep_obj->getDepartment();
			$form_creator ->popArr['countries']=$db_obj->getCountries();
            $form_creator ->popArr['patient_category']=$pati_cat_obj->getPatientCategory();
			$form_creator ->popArr['post']=$post;
			
			$form_creator ->formPath ='/templates/registration/registration_form.php';
			$form_creator ->popArr['action']=$action;
			$form_creator ->popArr['status']=$status;
			$form_creator->display();
		}											
	
	}
	function getinsuranceDeduction($ins_id,$type,$field_value){
	
			$inc_obj= new InsuranceCompany();
			
			$is_field[0]="a.id ='".$ins_id."'";
					
			$incInfo=$inc_obj->getInsCompany($is_field);
			
			if($type == "CONSULTATION") {
			
				$disc_type=$incInfo[0][15];
				$disc_value=$incInfo[0][16];
			}
		
			if($disc_type =="CASH"  && $disc_value>0 && $field_value>0){
												
					$disc_amt=$disc_value;
								
			}else if($disc_type =="%"  && $disc_value>0 && $field_value>0){
							
					$disc_amt=($field_value*$disc_value/100);
			}else{
					$disc_amt =0;
			}
	   
	    return array($disc_type,$disc_value,$disc_amt);
	}
	function getpatientcategoryDeduction($disc_array){
             $pat_cat_obj= new PatientCategory();

             $is_field[0]="a.id ='".$disc_array['category']."'";

             $pat_cat_info=$pat_cat_obj->getPatientCategoryInfo($is_field);

             if($disc_array['type'] == "CONSULTATION") {
			
				$disc_type=$pat_cat_info[0][5];
				$disc_value=$pat_cat_info[0][6];
				//for fee discount
				$reg_disc_type=$pat_cat_info[0][16];
				$reg_disc_value=$pat_cat_info[0][17];
				$card_disc_type=$pat_cat_info[0][18];
				$card_disc_value=$pat_cat_info[0][19];
			}
		
			if($disc_type =="CASH"  && $disc_value>0 && $disc_array['doc_fee_value']>0){
												
					$disc_amt=$disc_value;
								
			}else if($disc_type =="%"  && $disc_value>0 && $disc_array['doc_fee_value']>0){
							
					$disc_amt=($disc_array['doc_fee_value']*$disc_value/100);
			}else{
					$disc_amt =0;
			}

			//for fee discount
			if($reg_disc_type =="CASH"  && $reg_disc_value>0 && $disc_array['reg_fee_value']>0){
												
					$reg_disc_amt=$reg_disc_value;
								
			}else if($reg_disc_type =="%"  && $reg_disc_value>0 && $disc_array['reg_fee_value']>0){
							
					$reg_disc_amt=($disc_array['reg_fee_value']*$reg_disc_value/100);
			}else{
					$reg_disc_amt =0;
			}

			if($card_disc_type =="CASH"  && $card_disc_value>0 && $disc_array['card_fee_value']>0){
												
					$card_disc_amt=$card_disc_value;
								
			}else if($card_disc_type =="%"  && $card_disc_value>0 && $disc_array['card_fee_value']>0){
							
					$card_disc_amt=($disc_array['card_fee_value']*$card_disc_value/100);
			}else{
					$card_disc_amt =0;
			}

			$arrayList[0][0] =$disc_type;
			$arrayList[0][1] =$disc_value;
			$arrayList[0][2] =$disc_amt;

			$arrayList[1][0] =$reg_disc_type;
			$arrayList[1][1] =$reg_disc_value;
			$arrayList[1][2] =$reg_disc_amt;

			$arrayList[2][0] =$card_disc_type;
			$arrayList[2][1] =$card_disc_value;
			$arrayList[2][2] =$card_disc_amt;

       return $arrayList;
	}
	function processRegistration($post){ 
	  
		$gen_obj = new General();
		$com_obj = new CommonFunctions();
		$sms_obj = new SmsFunctions();
		$reg_obj= new Registration();
		$restOp_obj= new OPResetNo();
		$db_obj=new DBFunction();
		$config_obj=new Config_hims();
		$opno=0;
	
		$action =$post['paction'];
		
		$status =$post['status'];
		
		$selectfield[0]="op_validity";
		
		$validity_days=$post['validity_days'];
		
	
		if($validity_days==0){
		  $opSettings=$gen_obj->getOpSettings($selectfield,'','id','desc');
		  $validity_days=$opSettings[0][0];
		  $validity_days =$validity_days-1;
		}else $validity_days =$validity_days-1;
		
		if($validity_days==0){$validity_days=1;}
		
		
		
		$post['visit_time']=$com_obj->getcurrentTime('h:i a');
		$post['visit_date'] =$com_obj->getcurrentDate("Y-m-d H:i:s");
		
		$inc_company=$post['insurance_company'];
		$pat_category=$post['patient_category'];

        $post['ins_cons_disc_amt']=0;
		$post['pcat_cons_disc_amt']=0;
		if(!empty($inc_company)){
		
		        $disc_info=$this->getinsuranceDeduction($inc_company,"CONSULTATION",$post['docfee_actual']);

				$post['ins_cons_disc_amt']=$disc_info[2];
				
		}elseif(!empty($pat_category)){

				$selectfield[0]="reg_fee";
				$selectfield[1]="card_fee";
				$disc_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
				$regfee_actual=$disc_fee[0][0];
				$cardfee_actual=$disc_fee[0][1];

				$disc_array = array('category'=>$pat_category,
									'type' =>"CONSULTATION",
									'doc_fee_value'=>$post['docfee_actual'],
									'reg_fee_value'=>$regfee_actual,
									'card_fee_value'=>$cardfee_actual);
			    $disc_info=$this->getpatientcategoryDeduction($disc_array);
		
				$post['pcat_cons_disc_amt']=$disc_info[0][2];
				$post['pcat_reg_disc_amt']=$disc_info[1][2];
				$post['pcat_card_disc_amt']=$disc_info[2][2];
				
		}else {
		
			$post['ins_cons_disc_amt']=0;
			$post['pcat_cons_disc_amt']=0;
			$post['pcat_reg_disc_amt']=0;
			$post['pcat_card_disc_amt']=0;
			$post['insurance_company']='';
			$post['policy_no']='';
			$post['claim']='';
			$post['company_name']='';
			$post['company_id']='';
			$post['relation']='';
			$post['date_issue']='';
			$post['date_expiry']='';
		}
	
		if(empty($post['mlc'])){
		
					
			$post['mlc_date']='';
			$post['mlc_time']='';
			$post['mlc_summary']='';
			
		}else {
			$post['visit_time']=$post['mlc_time'];
		}
		
		$post['smsStatus1']=0;
		$post['smsStatus2']=0;
		$old_expiry='';
		$card_expiry_change=0;
		$card_expiry_lock=0;
		switch($status){
		
			case 'NEW'		:								
										$post['validity'] =date("Y-m-d",strtotime("+".$validity_days." day"));
										if($action =="REGISTRATION"){
										    $post['prefix']=$com_obj->getRegPrefix($post['type']);
										    // var_dump($post);
										    // exit;
										    
											// $post['card_expiry'] =date('Y-m-d', strtotime('+1 year'));
											$post['card_issued'] ="NEW";
											$post['opno']=$opno=$reg_obj->addPatientinfo($post);
											
										    //send sms
											if($post['contact_no'] !=''){											
											
											$message1=$sms_obj->thank_reg_sms;
											$message1=str_replace("<prefix><opno>",$post['prefix']."/".$opno,$message1);											
											$phone = $post['contact_no'];
												if(strlen($phone) >= 10 && $phone>0){	

													if ($config_obj->sms_status=="YES") {
														
														$post['smsStatus1'] = $sms_obj->sendSMS($phone, $message1);

													}

												    
												}
											}
											
										}else {
											// echo 11111111;exit;

											$post['card_expiry']=$db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
											$post['card_issued'] ="NEW";
											$opno=$reg_obj->updatePatientinfo($post);
										}
									
										
										break;
			case  'VISIT'			:	
										
										$opno=$post['opno'];
										$docid=$post['doctor'];
										$selectCondition[0]="a.`id`='".$opno."'";
										$selectCondition[1]="b.`doc_id`='".$docid."'";
										//new
										$selectCondition[2]="b.`cancelled`='0'";
										$selectField[0]="b.`validity_expiry`";
										
										$patientInfo=$reg_obj->getOPPatientInfo($selectField,$selectCondition,'b.visit_date','desc');
										$post['validity'] =	$patientInfo[0][0];	
										
																		 
										$opno=$reg_obj->updatePatientinfo($post);
										break;
			case   'RENEW'		:
										
										
										$post['validity'] =date("Y-m-d",strtotime("+".$validity_days." days"));
										
										$opno=$reg_obj->updatePatientinfo($post);
										break;

			case  'REVISIT'			:	
										
										$opno=$post['opno'];
										$docid=$post['doctor'];
										$selectCondition[0]="a.`id`='".$opno."'";
										$selectCondition[1]="b.`doc_id`='".$docid."'";
										$selectCondition[1]="b.`cancelled`=0";
										$selectField[0]="b.`validity_expiry`";
										
										$patientInfo=$reg_obj->getOPPatientInfo($selectField,$selectCondition,'b.visit_date','desc');
										$post['validity'] =	$patientInfo[0][0];	
										
																		 
										$opno=$reg_obj->updatePatientinfo($post);
										break;

		
		}
		
		//Generate Token Number
			
			if(empty($post['token'])){
			
				$docid=$post['doctor'];
				$bk_obj = new BookingController();
				$post['token']=$bk_obj->generateTokenNo($docid,date("d-m-Y"));
			}
		               if($action =="REGISTRATION" && $post['contact_no'] !=''){
		                                $dr_name=$db_obj->getidToValue('first_name','id', $post['doctor'],'hcare_emp_info')." ".$db_obj->getidToValue('last_name','id', $post['doctor'],'hcare_emp_info');										
                                        $message2=$sms_obj->thank_reg_dr_sms;
										$message2=str_replace("<doctor_name>",$dr_name,$message2);
										$message2=str_replace("<visit_date>",date("d-m-Y",strtotime($post['visit_date'])),$message2);
										$message2=str_replace("<opno>",$opno,$message2);
										$message2=str_replace("<token>",$post['token'],$message2);
										
										$phone = $post['contact_no'];

										if(strlen($phone) >= 10 && $phone>0){

											if ($config_obj->sms_status=="YES") {
															
												$post['smsStatus2'] = $sms_obj->sendSMS($phone, $message2);

											}

										}

										
						}
		
		if($opno > 0 ){
		
			
			$post['opno']=$opno;
			
			/*//uploadphoto
			
			$fName=$_POST['multiFiles'];
			//$upload_base = 'E:\wamp\www\koyas_new\templates\registration\patient_photo';
			
			$upload_base = '..\..\templates\registration\patient_photo';
			
			if(!empty($fName)){
			$id=$opno;
			$file_name = basename($_FILES[$fName]['name']); 
		    $file_type = $_FILES[$fName]['type'];
		    $file_size = $_FILES[$fName]['size'];
		    $file_temp = $_FILES[$fName]['tmp_name'];
			
			$fname = "photo.jpg";			
			$fpath = $upload_base;
			
			if(file_exists($fpath."/".$id))	
			{
				if(file_exists($fpath."/".$id."/".$fname))	
				{
						@unlink($fpath."/".$id."/".$fname);	
						@unlink($fpath."/".$id."/".$fname);	
					
				}
					
			}
			else
			{
				mkdir($fpath."/".$id,0777); 
			}
			
						
				if(move_uploaded_file($file_temp, $fpath."/".$id."/".$fname)){
					$success = $file_name."<!--seperator-->";						
				}
			
			}*/
			
			
			   
			
			if($action =="REGISTRATION"){ 
			
				$post['reset_op_no']=$restOp_obj->nextResetOPNO();
				
				$opid=$reg_obj->addVisitInfo($post);
				
				$restOp_obj->updateResetOPNO($post['reset_op_no']);
				
				if(!empty($post['token'])){
					$bk_obj = new Booking();
					$bk_obj->updateToVisit($post['bk_id']);	
				}
			}else{
				$opid=$reg_obj->updateVisitInfo($post);
			}
		
		}else $opid=0;
		
		if($opid >0 ){
			$post['id']=$opid;
			
			if($action =="REGISTRATION"){
			        $post['module_name']="Print_OP_Sheet";
			        // $this->captureImage($post);
				$this->viewPage("Print_OP_Sheet",$post);
			}else if($action =="REG_UPDATE" && empty($post['upload_status'])){
			      
				$this->viewPage("ManagePatients",$post);
			}else{
			$post['module_name']="print_registration";
			$this->viewPage("print_registration",$post);
			 // $this->captureImage($post);
			}
		
		}else{
		
			$this->viewPage("patient_registeration");
		}
	
	}
	function captureImage($post){
		$form_creator = new Form();
		//$post['module_name']="Registration";
		$form_creator ->popArr['opno']=$post['opno'];
		$form_creator ->popArr['id']=$post['id'];
		$form_creator ->popArr['module_name']=$post['module_name'];
		$form_creator ->formPath ='/templates/registration/capture.php';
		$form_creator->display();
	}
	function saveImage($post){
	
	 $module_name=$post['module_name'];
	  if(isset($post['imageData'])){
	  
			$imgData = str_replace(' ','+',$post['imageData']);
			$imgData =  substr($imgData,strpos($imgData,",")+1);
			$imgData = base64_decode($imgData);
			// Path where the image is going to be saved
			
			$fname = "photo.jpg";			
			$fpath = $filePath;
			$id=$post['opno'];
			
			$filePath =  "../../templates/registration/patient_photo";
			$fpath = $filePath."/".$id;

			
			if(file_exists($fpath))	
			{
				if(file_exists($fpath."/".$fname))	
				{
						@unlink($fpath."/".$fname);	
						@unlink($fpath."/".$fname);	
					
				}
					
			}
			else
			{
				mkdir($fpath,0777); 
			}
			$fpath .="/".$fname;
			
			// Write $imgData into the image file
			$file = fopen($fpath, 'w');
			fwrite($file, $imgData);
			fclose($file);
			
			$this->viewPage($module_name,$post);
			
	  }else {
	  
	    
	    $this->captureImage($post);	
	  }
	}
	function deleteRegistration($post){
	
		$reg_obj= new Registration();
		
		$reg_obj->deleteLab_result($post);
		$reg_obj->deleteMedical_result($post);
		$reg_obj->deleteRegistration($post);
		
		$this->viewPage("ManageRegistration",$post,"Deleted Successfully!");
	}
	
	function deletePatientVisit($post){
	
		$reg_obj= new Registration();
		
		$status=$reg_obj->deletePatientVisit($post);
		$this->viewPage("ManagePatients",$post);
	}
		function add_patient_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		  $opid=$post['id'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$post['id'];
		  $documentInfo['visit_id']="";
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;

		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx','dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";
                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800   ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('View_Patient_Record',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="patient_documents";
					       		$this->viewPage('View_Patient_Record',$post); 
					       		echo "<script>showDialog('Error','File size must be less than 50 MB','error',2);</script>";
					  		// }




		  }
		  else{
		  			//FILE PATH CHECKING
					if (!is_dir($file_path)){

					mkdir($file_path, 0755);
					move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

														  
					}
					else{
						 
						 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
					
					}


						$dr_obj->add_patient_document($documentInfo);
	        			$post=array();
	        			$post['id']=$opid;
	        			$post['active_module']="patient_documents";
	       				$this->viewPage('View_Patient_Record',$post);  




		  }

	}
	function delete_patient_document($post){
	       
	            $dr_obj=new Doctor();
	           
		        $id=$post['hidden_remove'];

		        $dr_obj->delete_patient_document($id);

		        $post['active_module']="patient_documents";
		       	
		       	$this->viewPage('View_Patient_Record',$post);  

		                                
	}



	function add_ip_patient_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		 $opid=$post['id'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $documentInfo['visit_id']=$opid;
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;

		  $documentInfo['ipno']=$post['id'];

          $documentInfo['cust_type']='IP';

          // $documentInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $post['ipno'],"hcare_ip_info");;
          $documentInfo['ref_ipno']=0;

		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx','dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";
                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800   ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('View_Patient_Record',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="patient_documents";
					       		$this->viewPage('View_Patient_Record',$post); 
					       		echo "<script>showDialog('Error','File size must be less than 50 MB','error',2);</script>";
					  		// }




		  }
		  else{
		  			//FILE PATH CHECKING
					if (!is_dir($file_path)){

					mkdir($file_path, 0755);
					move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

														  
					}
					else{
						 
						 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
					
					}


						$dr_obj->add_ip_patient_document($documentInfo);
	        			$post=array();
	        			$post['id']=$opid;
	        			$post['active_module']="ip_patient_documents";
	       				$this->viewPage('ip_View_Patient_Record',$post);  




		  }

	}
	function delete_ip_patient_document($post){
	       
	            $dr_obj=new Doctor();
	           
		        $id=$post['hidden_remove'];

		        $dr_obj->delete_ip_patient_document($id);

		        $post['active_module']="ip_patient_documents";
		       	
		       	$this->viewPage('ip_View_Patient_Record',$post);  

		                                
	}


function add_ip_patient_xray_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		  $opid=$post['id'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $documentInfo['visit_id']=$opid;
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;

		  $documentInfo['ipno']=$post['id'];

          $documentInfo['cust_type']='IP';

          // $documentInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $post['id'],"hcare_ip_info");;
          $documentInfo['ref_ipno']=0;
          
		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx','dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";
                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800   ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('View_Patient_Record',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="ip_patient_xray_documents";
					       		$this->viewPage('ip_View_Patient_Record',$post); 
					       		echo "<script>showDialog('Error','File size must be less than 50 MB','error',2);</script>";
					  		// }




		  }
		  else{
		  			//FILE PATH CHECKING
					if (!is_dir($file_path)){

					mkdir($file_path, 0755);
					move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

														  
					}
					else{
						 
						 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
					
					}


						$dr_obj->add_ip_patient_xray_document($documentInfo);
	        			$post=array();
	        			$post['id']=$opid;
	        			$post['active_module']="ip_patient_xray_documents";
	       				$this->viewPage('ip_View_Patient_Record',$post);  




		  }

	}
	function delete_ip_patient_xray_document($post){
	       
	            $dr_obj=new Doctor();
	           
		        $id=$post['hidden_remove'];

		        $dr_obj->delete_ip_patient_xray_document($id);

		        $post['active_module']="ip_patient_xray_documents";
		       	
		       	$this->viewPage('ip_View_Patient_Record',$post);  

		                                
	}


function processOPNo_ref($post,$get = null){ //var_dump($post);
		

		$form_creator = new Form();
		
		$reg_obj= new Registration();
		$emp_obj= new Employee();
		$inc_obj= new InsuranceCompany();
		$db_obj=new DBFunction();
		$dep_obj=new Department();		
		$com_obj = new CommonFunctions();
		$gen_obj = new General();
		$bk_obj = new Booking();
		$bill_obj=new Billing();
		$ip_obj= new Inpatient();
		$pati_cat_obj = new PatientCategory();
		$dr_obj = new Doctor();
		
		$todate =$com_obj->getcurrentDate();
		$where_card_expiry[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
		$validity_info= $gen_obj->getOpSettings('',$where_card_expiry,'','');
			 // var_dump($validity_info);
		$booking_status="0";
		
		if(!empty($post['id'])){
			$opid=$post['id'];
			$selectCondition[0]="b.`id`='".$opid."'";
		}else{
			$opno=$post['opno'];
			$selectCondition[0]="a.`id`='".$opno."'";
		}
		
		if(!empty($get['bk_id'])){
			
				$wheredata[0]="id='".$get['bk_id']."'";
				$bkInfo=$bk_obj->getBookingList($wheredata);
				$docid=$bkInfo[0][2];
				$post['bk_id']=$bkInfo[0][0];
				$post['token']=$bkInfo[0][1];
				$selectCondition[1]="b.`doc_id`='".$docid."'";
				
				$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'visit_date','desc');
				
				if(empty($patientInfo)){
					$booking_status="0";
				}else $booking_status=1;
				
				unset($selectCondition[1]);
		
		}
		$selectCondition[1]="b.`cancelled`='0'";
		
		if($booking_status == 0 ) {
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'visit_date','desc');
		}
		
		if(!empty($patientInfo)){
		
			$post['opno']=$opno=$patientInfo[0][0];			
			$validity = $patientInfo[0][21];
			$age=$patientInfo[0][4];
			$dob=$patientInfo[0][5];
			$visit_date=date("Y-m-d",strtotime($patientInfo[0][20]));
			//$free =$patientInfo[0][41];
			
			//if($free == 1) $post['free']=1;
			
			if($booking_status ==0 && empty($get['bk_id'])){
			
				$docid=$patientInfo[0][14];			
				
			}else $validity =date("Y-m-d");
			
			//check for patient credit
			
			//credit bill info
												
			$wheredata[0]="opno ='".$opno."'";
			$opbill_credit=$bill_obj->getOPCreditBillAmt($wheredata);
												
			//pharma credit Bill
											  
			$phwhere[]="op_no = '".$opno."'";
			$oppharma_credit=$bill_obj->getOPPharmaCreditAmt($phwhere,"0,3");
			
			//ip credit Bill
											  
			$ipwhere[]="opno = '".$opno."'";
			$ip_credit=$bill_obj->getIPCreditAmt($ipwhere);
			
			$total_credit=$opbill_credit+$oppharma_credit+$ip_credit;
			
			$post['total_credit'] =$total_credit;
			
			if(!empty($post['id'])){
				
				$status =$patientInfo[0][32];
				
				//$docfee=$patientInfo[0][17];

				if ( !empty($post['revisit']) && $post['revisit']=="REVISIT" ) {
					$docfee=0;
					$reg_fee=0;
					$cardfee=0;
				}
				else{
					$docfee=$patientInfo[0][17];
					$regfee=$patientInfo[0][18];
					$cardfee=$patientInfo[0][52];
				}

				if ($post['paction']=="CANCEL_REFER" || $post['paction']=="REFER" ) {


					$select_ref[0] = "visit_id = '".$post['id']."' ";
					$select_ref[1] = "status = 0";

					$refInfo = $dr_obj->getDrReferalInfo('',$select_ref);

					if (!empty($refInfo)) {
						$docid = $refInfo[0][4];
						$post['refferal_info']=$refInfo[0][8];


						//doctor fee
				
						$is_field[0]="a.id ='".$docid."'";
					
						$docinfo=$emp_obj->getEmployee($is_field);
						$docfee=$docinfo[0][19];
						$post['validity_days']=$docinfo[0][23];
				
						//registration fees
						$selectfield[0]="reg_fee";
						$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
						$regfee=0;

						$card_expiry=$patientInfo[0][53];
						$card_issued=$patientInfo[0][54];

						if(strtotime($card_expiry) < strtotime($todate)){
							$selectfield[0]="card_fee";
							$card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');;
							$cardfee=$card_fee[0][0];
							if($validity_info[0][6]=='Y'){
								$no_of_year=$validity_info[0][5];
								$y = strtotime("+$no_of_year year");
								$card_expiry= date('Y-m-d', "+$y");
								// $y = strtotime("$no_of_year year");
								// $card_expiry= date('Y-m-d', "+$y years");
							}else{
								$no_of_year=$validity_info[0][5];
								$m = strtotime("+$no_of_year month");
								$card_expiry =date('Y-m-d', "+$m");
								// $m = strtotime("$no_of_year month");
								// $card_expiry =date('Y-m-d', "+$m months");

							}
							// $card_expiry =date('Y-m-d', strtotime('+1 year'));
							$card_issued ="RENEW";
						}else $cardfee=0;



						// if ( $status!="VISIT" && $status!="REVISIT" ) {
						// 	$post['doctor_perc']=($docfee*$docinfo[0][26])/100;
						// 	$post['hospital_perc']=($docfee*$docinfo[0][27])/100;
						// }
						// else{
						// 	$post['doctor_perc']="";
						// 	$post['hospital_perc']="";
						// }


						$opno=$post['opno'];
						$selectCondition_ref[0]="a.`id`='".$opno."'";
						$selectCondition_ref[1]="b.`doc_id`='".$refInfo[0][3]."'";
						if(!empty($post['id'])){
							$selectCondition_ref[2]="b.`id`='".$post['id']."'";
						}
						$selectCondition_ref[]="b.`cancelled`='0'";
						
						$patientInfo_ref=$reg_obj->getOPPatientInfo('',$selectCondition_ref,'b.visit_date','desc');


						if (!empty($patientInfo_ref) && $refInfo[0][10]=="CANCEL_REFER" ) {

							if ($post['old_status']=="NEW") {
								
								$regfee = $patientInfo_ref[0][18];
								$cardfee= $patientInfo_ref[0][52];

							}
							
							$referal_fee_net = $docfee+$regfee+$cardfee;

							$before_fee_net = $patientInfo_ref[0][17]+$patientInfo_ref[0][18]+$patientInfo_ref[0][52];

							$post['ref_balance']=$referal_fee_net-$before_fee_net;

						}
						else if (!empty($patientInfo_ref) && $refInfo[0][10]=="REFER" ) {
							
							$referal_fee_net = $docfee+$regfee+$cardfee;

							$post['ref_balance']=$referal_fee_net;

						}
						else{
							$post['ref_balance']=0;
						}


					}



				}
				
				
				$card_expiry=$patientInfo[0][53];
				$card_issued=$patientInfo[0][54];
				
				$age_in=explode(" ",$age);
				$age=$age_in[0];
				$age_type=$age_in[1];
				
				/*..... health checkup.....*/	
                  $post['health_checkup']=$patientInfo[0][58];
				// for free
                   $post['free']=$patientInfo[0][83];
				
				if ( !empty($post['revisit']) && $post['revisit']=="REVISIT" ) {
					$form_creator ->popArr['action']="REG_UPDATE";
					$status ="REVISIT";
				}
				else if ( !empty($post['paction']) && $post['paction']=="CANCEL_REFER" ) {
					$form_creator ->popArr['action']="REFER";
					$status ="CANCEL_REFER";
				}
				else if ( !empty($post['paction']) && $post['paction']=="REFER" ) {
					$form_creator ->popArr['action']="REFER";
					$status ="REFER";
				}
				else{
					$form_creator ->popArr['action']="REG_UPDATE";
				}




				if (!empty($refInfo)) {
						$post['refferal_info']=$refInfo[0][8];
						$post['refering_doc_id']=$refInfo[0][3];
				}
				else if (!empty($post['revisit']) && $post['revisit']=="REVISIT") {
					$post['refferal_info']='';
					$post['refering_doc_id']='';
				}
				else{
					$post['refferal_info']="Dr.".$patientInfo[0][15]." ".$patientInfo[0][16];
					$post['refering_doc_id']=$patientInfo[0][14];
				}
				
			}else{
			
					if($visit_date == $todate && empty($get['bk_id'])) {
						 $form_creator ->popArr['message1']="Patient Already Registered for Selected Doctor!";
					}
					if($validity < $todate){
				
						$status ="RENEW";
				
						//doctor fee
				
						$is_field[0]="a.id ='".$docid."'";
					
						$docinfo=$emp_obj->getEmployee($is_field);
						$docfee=$docinfo[0][19];
						$post['validity_days']=$docinfo[0][23];
				
						//registration fees
						$selectfield[0]="reg_fee";
						$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
						$regfee=0;


						// if ( $status!="VISIT" && $status!="REVISIT" ) {
						// 	$post['doctor_perc']=($docfee*$docinfo[0][26])/100;
						// 	$post['hospital_perc']=($docfee*$docinfo[0][27])/100;
						// }
						// else{
						// 	$post['doctor_perc']="";
						// 	$post['hospital_perc']="";
						// }

						
				
					}else {
						$opno=$post['opno'];
											
											$selectConditions[0]="a.`id`='".$opno."'";
											$selectConditions[1]="b.`doc_id`='".$docid."'";
											if(!empty($post['id'])){
												$selectConditions[2]="b.`id`<'".$post['id']."'";
											}
											$selectConditions[]="b.`cancelled`='0'";
											$selectConditions[]="b.`visit_status`='VISIT'";
											// var_dump($selectCondition);exit;
											$patientInfo_visit_check=$reg_obj->getOPPatientInfo('',$selectConditions,'','');
											$visit_count=count($patientInfo_visit_check);
											// echo $visit_count;
										  // var_dump($patientInfo_visit_check);exit;
											if($visit_count < 1){
												$status ="VISIT";
												$docfee=0;
												$regfee=0;

											}else{
												$status="RENEW";
												$is_field[0]="a.id ='".$docid."'";
					
												$docinfo=$emp_obj->getEmployee($is_field);
												$docfee=$docinfo[0][19];
												$post['validity_days']=$docinfo[0][23];
										
												//registration fees
												$selectfield[0]="reg_fee";
												$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
												$regfee=$reg_fee[0][0];
											}
			
						// $status ="VISIT";
						// $docfee=0;
						// $regfee=0;
					}
			
			$card_expiry=$db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
			$card_issued='';
			if($card_expiry == '0000-00-00' || $card_expiry == '1970-01-01'){
			
			    $vInfo[0]="opno =".$opno;
			    $first_visit=$reg_obj->getfirstVisit($vInfo);
			    if($validity_info[0][6]=='Y'){
					$no_of_year=$validity_info[0][5];
					$y = strtotime("+$no_of_year year");
					$card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+$y"));
					// $y = strtotime("$no_of_year year");
					// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + $no_of_year year"));
				}else{
					$no_of_year=$validity_info[0][5];
					$m = strtotime("+$no_of_year month");
				    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+m"));
					// $m = strtotime("$no_of_year month");
				 //    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " +$no_of_year month"));

				}
				// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + 1 year"));
			}
			
				if(strtotime($card_expiry) < strtotime($todate)){
					$selectfield[0]="card_fee";
					$card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');;
					$cardfee=$card_fee[0][0];
					if($validity_info[0][6]=='Y'){
								$no_of_year=$validity_info[0][5];
								$y = strtotime("+$no_of_year year");
								$card_expiry= date('Y-m-d', "+$y");
								// $y = strtotime("$no_of_year year");
								// $card_expiry= date('Y-m-d', "+$y years");
					}else{
								$no_of_year=$validity_info[0][5];
								$m = strtotime("+$no_of_year month");
								$card_expiry =date('Y-m-d', "+$m");
								// $m = strtotime("$no_of_year month");
								// $card_expiry =date('Y-m-d', "+$m months");

							}
					// $card_expiry =date('Y-m-d', strtotime('+1 year'));
					$card_issued ="RENEW";
				}else $cardfee=0;
			//Calculate age
		
			//$ageInfo=$this->calculateAge($dob,$age);
			//$age=$ageInfo[0];
			//$age_type=$ageInfo[1];
			
			$age_in=explode(" ",$age);
				$age=$age_in[0];
				$age_type=$age_in[1];
			
			$form_creator ->popArr['action']="REGISTRATION";
		}
			
			
			$post['card_expiry']=date("d-m-Y",strtotime($card_expiry));
			$post['card_issued'] =$card_issued;
			$post['first_name']=$patientInfo[0][1];
			$post['middle_name']=$patientInfo[0][2];
			$post['last_name']=$patientInfo[0][3];
			$post['age']=$age;
			$post['age_type']=$age_type;
		
			$post['gender']=$patientInfo[0][6];
			$post['marital_status']=$patientInfo[0][7];
			$post['place']=$patientInfo[0][8];
			$post['nationality']=$patientInfo[0][9];
			$post['contact_no']=$patientInfo[0][10];
			$post['email']=$patientInfo[0][11];
			$post['whithout_refer']=$post['whithout_refer'];
			$post['old_status']=$post['old_status'];
			$post['old_doctor']=$post['old_doctor'];

			if (!empty($post['whithout_refer']) && $post['whithout_refer']=="YES"  ) {

				$post['doctor']='';
				$post['docfee']='';
				$post['regfee']='';
				$post['cardfee']='';


			}
			else{

				$post['doctor']=$docid;
				$post['docfee']=$docfee;
				$post['regfee']=$regfee;
				$post['cardfee']=$cardfee;


			}

			if ($post['old_status']=="NEW") {

				$post['regfee_old']=$patientInfo[0][18];
				$post['cardfee_old']=$patientInfo[0][52];
			}


			$post['insurance_company']=$patientInfo[0][22];
			$post['policy_no']=$patientInfo[0][24];
			$post['claim']=$patientInfo[0][25];
			$post['company_name']=$patientInfo[0][26];
			$post['company_id']=$patientInfo[0][27];
			$post['relation']=$patientInfo[0][28];
			$post['status_select']=$post['status_type'];
			$post['ref_id']=$post['ref_id'];

			if($patientInfo[0][29] !='0000-00-00' && $patientInfo[0][30] !='0000-00-00'){
				$post['date_issue']=date("d-m-Y",strtotime($patientInfo[0][29]));
				$post['date_expiry']=date("d-m-Y",strtotime($patientInfo[0][30]));
			}
			if($patientInfo[0][5] !='0000-00-00' && $patientInfo[0][5] !="1970-01-01"){
					$post['dob']=date("d-m-Y",strtotime($patientInfo[0][5]));
			}
			
			if($post['insurance_company']>0){
				$post['inc']="insurance";
			}
			if(!empty($patientInfo[0][38] )){
			
					$post['mlc']="mlc";
					$post['mlc_date']=$patientInfo[0][20];
					$post['mlc_time']=$patientInfo[0][19];
					$post['mlc_summary']=$patientInfo[0][38];
			}
					
			
			if($patientInfo[0][22] >0 ){
			
					$is_field[0]="a.valid_upto >='".$todate."'";
					$form_creator ->popArr['insurance_company']=$inc_obj->getInsCompany($is_field);
			}
/*..... ip_discharge .....*/	
             $selectCondition[]="b.`opno` ='".$opno."'";

		     $select_field[]="b.`discharge_date`";
        
             $limit=1;
            
            $ip_discharge=$ip_obj->getIPPatientInfo($select_field,$selectCondition,'b.id','desc',$limit);

			$post['ip_discharge']=$ip_discharge[0][0];	
/*..... ip_discharge .....*/	

/*..... patient categroy .....*/	
            $post['patient_category']=$patientInfo[0][56];

/*..... observation status .....*/	
            $post['observation_status_op']=$patientInfo[0][62];
			
			
/*..... patient categroy .....*/	
			$form_creator ->popArr['post']=$post;		
		    
		}else {
		
			$form_creator ->popArr['message1']="Invalid OP Number";
			if(!empty($get['bk_id'])){
				$form_creator ->formPath ='/templates/booking/booking_report.php';
				$form_creator->display();
				exit();
			}
		}
			$is_field[0]="a.title ='Dr'";
			if(!empty($get['bk_id'])){
				$is_field[1]="a.id ='".$bkInfo[0][2]."'";
			}
			$form_creator ->popArr['doctors']=$docinfo=$emp_obj->getEmployee($is_field);
			$form_creator ->popArr['departments']=$dep_obj->getDepartment();
			$form_creator ->popArr['countries']=$db_obj->getCountries();
			$form_creator ->popArr['patient_category']=$pati_cat_obj->getPatientCategory();
			$form_creator ->popArr['status']=$status;
			

			$form_creator ->popArr['post']=$post;	
			$form_creator ->popArr['refInfo']=$refInfo;


			$form_creator ->formPath ='/templates/registration/registration_form_ref.php';
			$form_creator->display();


	}
	function doc_fee_change($post){

		
		$reg_obj= new Registration();
		$db_obj= new DBFunction();
		$com_obj= new CommonFunctions();
		$emp_obj= new Employee();
		$gen_obj = new General();
		$where_card_expiry[]="id = (SELECT MAX(id) FROM hcare_op_settings)";
		$validity_info= $gen_obj->getOpSettings('',$where_card_expiry,'','');
			 // var_dump($validity_info);
		$disc_type=$post['discount_type'];
		$disc_val=$post['discount_val'];

		if (!empty($post['docid'])) {
		
			$docid = $post['docid'];
			$ref_doc_id = $post['ref_doc_id'];


						//doctor fee
				
						$is_field[0]="a.id ='".$docid."'";
					
						$docinfo=$emp_obj->getEmployee($is_field);
						$docfee=$docinfo[0][19];
						// $post['validity_days']=$docinfo[0][23];
						// ===========
						// =======
				
						//registration fees
						$selectfield[0]="reg_fee";
						$reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
						$regfee=0;

						$card_expiry=$patientInfo[0][53];
						$card_issued=$patientInfo[0][54];

						$todate =$com_obj->getcurrentDate();

						$card_expiry=$db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
						$card_issued='';

						if($card_expiry == '0000-00-00' || $card_expiry == '1970-01-01'){
						
						    $vInfo[0]="opno =".$opno;
						    $first_visit=$reg_obj->getfirstVisit($vInfo);
						    if($validity_info[0][6]=='Y'){
							$no_of_year=$validity_info[0][5];
							$y = strtotime("+$no_of_year year");
							$card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+y"));
							// $y = strtotime("$no_of_year year");
							// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + $no_of_year year"));
							}else{
								$no_of_year=$validity_info[0][5];
								$m = strtotime("+$no_of_year month");
							    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . "+$m"));
								// $m = strtotime("$no_of_year month");
							 //    $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " +$no_of_year month"));

							}
							// $card_expiry= date("Y-m-d", strtotime(date("Y-m-d", strtotime($first_visit[0][1])) . " + 1 year"));
						}

						if(strtotime($card_expiry) < strtotime($todate)){
							$selectfield[0]="card_fee";
							$card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');;
							$cardfee=$card_fee[0][0];
							if($validity_info[0][6]=='Y'){
								$no_of_year=$validity_info[0][5];
								$y = strtotime("+$no_of_year year");
								$card_expiry= date('Y-m-d', "+$y");
								// $y = strtotime("$no_of_year year");
								// $card_expiry= date('Y-m-d', "+$y years");
							}else{
										$no_of_year=$validity_info[0][5];
										$m = strtotime("+$no_of_year month");
										$card_expiry =date('Y-m-d', "+$m");
										// $m = strtotime("$no_of_year month");
										// $card_expiry =date('Y-m-d', "+$m months");

									}
							// $card_expiry =date('Y-m-d', strtotime('+1 year'));
							$card_issued ="RENEW";
						}else $cardfee=0;

						$opno=$post['opno'];
						$selectCondition_ref[0]="a.`id`='".$opno."'";
						$selectCondition_ref[1]="b.`doc_id`='".$ref_doc_id."'";
						if(!empty($post['id'])){
							$selectCondition_ref[2]="b.`id`='".$post['id']."'";
						}
						$selectCondition_ref[]="b.`cancelled`='0'";
						
						$patientInfo_ref=$reg_obj->getOPPatientInfo('',$selectCondition_ref,'b.visit_date','desc');

						if ($post['whithout_refer']=="NO") {
						
							if (!empty($patientInfo_ref) && $post['referal_type']=="CANCEL_REFER" ) {


								if ($post['old_status']=="NEW" || $post['old_status']=="RENEW" ) {
									
									$regfee = $patientInfo_ref[0][18];
									$cardfee= $patientInfo_ref[0][52];

								}
								
								$referal_fee_net = $docfee+$regfee+$cardfee;
								// $referal_fee_net_before_discount=$referal_fee_net;
								
								// $referal_fee_net=$referal_fee_net-$disc_amt;

								$before_fee_net = $patientInfo_ref[0][17]+$patientInfo_ref[0][18]+$patientInfo_ref[0][52];
								$referal_fee_net_before_discount=$referal_fee_net-$before_fee_net;

								if($disc_type =='CASH'){
									
									 $disc_amt=$disc_val;
								}else if($disc_type =='%'){
									$disc_amt=abs($referal_fee_net_before_discount)*$disc_val/100;

								}else{
									$disc_amt=0;
								}

								$post['ref_balance']=$referal_fee_net-$before_fee_net-$disc_amt;



							}
							else if (!empty($patientInfo_ref) && $post['referal_type']=="REFER" ) {
								
								$referal_fee_net = $docfee+$regfee+$cardfee;
								$referal_fee_net_before_discount=$referal_fee_net;
								if($disc_type =='CASH'){
									
									 $disc_amt=$disc_val;
								}else if($disc_type =='%'){
									$disc_amt=$referal_fee_net*$disc_val/100;

								}else{
									$disc_amt=0;
								}
								$referal_fee_net=$referal_fee_net-$disc_amt;

								$post['ref_balance']=$referal_fee_net;

							}
							else{
								$post['ref_balance']=0;
							}

						}
						else if($post['whithout_refer']=="YES"){



							if (!empty($patientInfo_ref) && $post['referal_type']=="CANCEL_REFER" ) {
								

								if ($post['old_status']=="NEW" || $post['old_status']=="RENEW" ) {
									
									$regfee = $patientInfo_ref[0][18];
									$cardfee= $patientInfo_ref[0][52];

								}
								
								$referal_fee_net = $docfee+$regfee+$cardfee;
								// $referal_fee_net_before_discount=$referal_fee_net;
								
								// $referal_fee_net=$referal_fee_net-$disc_amt;

								$before_fee_net = $patientInfo_ref[0][17]+$patientInfo_ref[0][18]+$patientInfo_ref[0][52];
								$referal_fee_net_before_discount=$referal_fee_net-$before_fee_net;
								if($disc_type =='CASH'){
									
									 $disc_amt=$disc_val;
								}else if($disc_type =='%'){
									$disc_amt=abs($referal_fee_net_before_discount)*$disc_val/100;

								}else{
									$disc_amt=0;
								}


								$post['ref_balance']=$referal_fee_net-$before_fee_net-$disc_amt;
								// $referal_fee_net_before_discount=$post['ref_balance'];


							}
							else if (!empty($patientInfo_ref) && $post['referal_type']=="REFER" ) {
								
								$referal_fee_net = $docfee+$regfee+$cardfee;
								$referal_fee_net_before_discount=$referal_fee_net;
								if($disc_type =='CASH'){
									
									 $disc_amt=$disc_val;
								}else if($disc_type =='%'){
									$disc_amt=$referal_fee_net*$disc_val/100;

								}else{
									$disc_amt=0;
								}
								$referal_fee_net=$referal_fee_net-$disc_amt;

								$post['ref_balance']=$referal_fee_net;

							}
							else{
								$post['ref_balance']=0;
							}

						}
						else{
							$post['ref_balance']=0;
						}

						$post['ref_balance_before_discount']=$referal_fee_net_before_discount;
						$data=$docfee.":".$regfee.":".$cardfee.":".$post['ref_balance'].":".$post['referal_type'].":".$disc_amt.":".$post['ref_balance_before_discount'];

						echo $data;

				}

	}

function processRegForm_ref($post){

	  
			$form_creator = new Form();
			$emp_obj= new Employee();
			$inc_obj= new InsuranceCompany();
			$db_obj=new DBFunction();
			$dep_obj=new Department();
			$gen_obj = new General();
			$com_obj = new CommonFunctions();
			$reg_obj= new Registration();
			$pati_cat_obj = new PatientCategory();
			
			$dep_id=$post['department'];
			$inc=$post['inc'];
			$mlc=$post['mlc'];
			$inc_company=$post['insurance_company'];
			$pat_category=$post['patient_category'];
			$docid=$post['doctor'];
			$status=$post['status'];
			$action=$post['paction'];
			$todate =$com_obj->getcurrentDate();
			$docfee=0;
			$reg_fee=0;


			if(!empty($post['free'])){
				$status="FREE";
			}
			
			
			
			//if department selected show doctors in selected department else show all doctors
			if($dep_id !='') {
			
					$is_field[0]="a.title ='Dr'";
					
					$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field,$dep_id);
			
			}else{
					$is_field[0]="a.title ='Dr'";
					
					$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
			
			}
			
			//If insurance checked true then show insurance companies
			if($inc != ''){
					$is_field[0]="a.valid_upto >='".$todate."'";
					$form_creator ->popArr['insurance_company']=$inc_obj->getInsCompany($is_field);
			
			}
			
			//if doctor selected then get doc fee and reg fee
			if($docid!=''){
					$is_field=array();
					
					$is_field[0]="a.id ='".$docid."'";
					
					$docinfo=$emp_obj->getEmployee($is_field);

					$post['validity_days']=$docinfo[0][23];
					
					if(!empty($post['opno']) && $status!="NEW"){
					
						$opno=$post['opno'];
						$selectCondition[0]="a.`id`='".$opno."'";
						$selectCondition[1]="b.`doc_id`='".$docid."'";
						if(!empty($post['id'])){
							$selectCondition[2]="b.`id`='".$post['id']."'";
						}
						$selectCondition[]="b.`cancelled`='0'";
						$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','desc');
						
						if(!empty($patientInfo)){
												
							$validity = $patientInfo[0][21];
							$visit_date=date("Y-m-d",strtotime($patientInfo[0][20]));
							
							
							
								if($visit_date == $todate) $form_creator ->popArr['message1']="Patient Already Registered for Selected Doctor!";
							

							
							if ( $status=="REVISIT" ) {
								$status ="REVISIT";
							}
							else if( (strtotime($validity) < strtotime($todate)) && ($status!="REVISIT" && $status!="VISIT") ){
				
								$status ="RENEW";
								
								
							}else{
								$opno=$post['opno'];
											
											$selectCondition[0]="a.`id`='".$opno."'";
											$selectCondition[1]="b.`doc_id`='".$docid."'";
											if(!empty($post['id'])){
												$selectCondition[2]="b.`id`<'".$post['id']."'";
											}
											$selectCondition[]="b.`cancelled`='0'";
											$selectCondition[]="b.`visit_status`='VISIT'";
											$patientInfo_visit_check=$reg_obj->getOPPatientInfo('',$selectCondition,'','');
											$visit_count=count($patientInfo_visit_check);
											// echo $visit_count;
											//  var_dump($patientInfo_visit_check);
											if($visit_count < 1){
												$status ="VISIT";

											}else{
												$status="RENEW";
											}
								
							
								// $status ="VISIT";
								
							}
						
						}else{
						
								$status ="RENEW";
								
						}
					}else {
					
							
								$status ="NEW";
						
					}

	
					switch($status) {
					
						case 'VISIT' : $docfee=0;
							           $regfee=0;
								       $cardfee=$post['cardfee'];
								 
										break;

						case 'REVISIT' : $docfee=0;
							           	 $regfee=0;
								       	 $cardfee=$post['cardfee'];
								 
										break;

						default	 :
							   $docfee=$docinfo[0][19];
										
							    if($action == "REFER"){
			                            $regfee=$post['regfee'];
			                             $cardfee=$post['cardfee'];

			                     }else {
							   
							      if(!empty($post['free'])){
					
						                   $docfee=0;
						                   $regfee=0;
							      }else if(!empty($post['health_checkup'])){
									  
									  $docfee=0;
						               $regfee=0;
									  
								  }else{
							        	                                                      
							        //registration fees
							        $selectfield[0]="reg_fee";
										
							        $reg_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
							        $regfee=$reg_fee[0][0];
							      
							       } 
							      if($status == "NEW"){
								     $selectfield[0]="card_fee";
								     $card_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');;
								     $cardfee=$card_fee[0][0];
							     }else{
								     $cardfee=$post['cardfee'];
								 }
								 
								 //health check up card fee=0
								 if(!empty($post['health_checkup'])){
									 
									    $cardfee=0;
								  }
					                
						}
							break;
					
					}
					
					if(!empty($post['free'])){
					
						$docfee=0;
						$regfee=0;
					}
					
					$emp_depid=$docinfo[0][10];
					
					
					if($dep_id!='' && $dep_id!=$emp_depid){
						$docfee='';
					}
					
					
			}




			$post['docfee_actual']=$docfee;

			// if ( $status!="VISIT" && $status!="REVISIT" ) {
			// 	$post['doctor_perc']=($docfee*$docinfo[0][26])/100;
			// 	$post['hospital_perc']=($docfee*$docinfo[0][27])/100;
			// }
			// else{
			// 	$post['doctor_perc']="";
			// 	$post['hospital_perc']="";
			// }


			$ins_cons_disc_type='';
			$ins_cons_disc_value='';
			$pcat_cons_disc_type='';
			$pcat_cons_disc_value='';

			//If insurance company selected then get doctor fee after insurance deduction
           
			if(!empty($inc_company)){

				$disc_info=$this->getinsuranceDeduction($inc_company,"CONSULTATION",$docfee);
			   
				$docfee =$docfee - $disc_info[2];

				$ins_cons_disc_type=$disc_info[0];
				$ins_cons_disc_value=$disc_info[1];	
			}
            //patient category deduction
			if(!empty($pat_category)){

				$selectfield[0]="reg_fee";
				$selectfield[1]="card_fee";
				$disc_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
				$regfee_actual=$disc_fee[0][0];
				$cardfee_actual=$disc_fee[0][1];

				$disc_array = array('category'=>$pat_category,
									'type' =>"CONSULTATION",
									'doc_fee_value'=>$docfee,
									'reg_fee_value'=>$regfee_actual,
									'card_fee_value'=>$cardfee_actual);
			    $disc_info=$this->getpatientcategoryDeduction($disc_array);	
				

				$docfee =$docfee - $disc_info[0][2];

				$pcat_cons_disc_type=$disc_info[0][0];
				$pcat_cons_disc_value=$disc_info[0][1];
			}
          			
			if($post['dob']!=''){
				$ageInfo=$this->calculateAge($post['dob']);
				
				
				$post['age']=$ageInfo[0];
				$post['age_type']=$ageInfo[1];
			}
/*.... Discont Details ....*/
			$post['ins_cons_disc_type']=$ins_cons_disc_type;
			$post['ins_cons_disc_value']=$ins_cons_disc_value;
			$post['pcat_cons_disc_type']=$pcat_cons_disc_type;
			$post['pcat_cons_disc_value']=$pcat_cons_disc_value;
/*.... Discont Details ....*/			
			
			$post['docfee']=$docfee;

			if ($status=="RENEW") {
				$post['regfee']=0;
			}
			else{
				$post['regfee']=$regfee;
			}

			$post['cardfee']=$cardfee;
			
		if($post['paction2'] == "SAVE"){
           $post['paction']=$action;
			$post['status']=$status;

			if ($post['referal_type']=="CANCEL_REFER") {
				$reg_obj->cancelOp($post['id'],$post['doctor']);
			}

          $this->processRegistration_ref($post);
        }else{		
			$form_creator ->popArr['departments']=$dep_obj->getDepartment();
			$form_creator ->popArr['countries']=$db_obj->getCountries();
            $form_creator ->popArr['patient_category']=$pati_cat_obj->getPatientCategory();
			$form_creator ->popArr['post']=$post;
			
			$form_creator ->formPath ='/templates/registration/registration_form_ref.php';
			$form_creator ->popArr['action']=$action;
			$form_creator ->popArr['status']=$status;
			$form_creator->display();
		}											
	
	}

	function processRegistration_ref($post){
	
	  
		$gen_obj = new General();
		$com_obj = new CommonFunctions();
		$sms_obj = new SmsFunctions();
		$reg_obj= new Registration();
		$restOp_obj= new OPResetNo();
		$db_obj=new DBFunction();
		$config_obj = new Config_hims();
		$opno=0;
	
		$action =$post['paction'];
		
		$status =$post['status'];
		
		$selectfield[0]="op_validity";
		
		$validity_days=$post['validity_days'];
		
	
		if($validity_days==0){
		  $opSettings=$gen_obj->getOpSettings($selectfield,'','id','desc');
		  $validity_days=$opSettings[0][0];
		  $validity_days =$validity_days-1;
		}else $validity_days =$validity_days-1;
		
		if($validity_days==0){$validity_days=1;}
		
		
		
		$post['visit_time']=$com_obj->getcurrentTime('h:i a');
		$post['visit_date'] =$com_obj->getcurrentDate("Y-m-d H:i:s");
		
		$inc_company=$post['insurance_company'];
		$pat_category=$post['patient_category'];

        $post['ins_cons_disc_amt']=0;
		$post['pcat_cons_disc_amt']=0;
		if(!empty($inc_company)){
		
		        $disc_info=$this->getinsuranceDeduction($inc_company,"CONSULTATION",$post['docfee_actual']);

				$post['ins_cons_disc_amt']=$disc_info[2];
				
		}elseif(!empty($pat_category)){

				$selectfield[0]="reg_fee";
				$selectfield[1]="card_fee";
				$disc_fee=$gen_obj->getOpSettings($selectfield,'','id','desc');
				$regfee_actual=$disc_fee[0][0];
				$cardfee_actual=$disc_fee[0][1];

				$disc_array = array('category'=>$pat_category,
									'type' =>"CONSULTATION",
									'doc_fee_value'=>$post['docfee_actual'],
									'reg_fee_value'=>$regfee_actual,
									'card_fee_value'=>$cardfee_actual);
			    $disc_info=$this->getpatientcategoryDeduction($disc_array);		
				$post['pcat_cons_disc_amt']=$disc_info[0][2];
				
		}else {
		
			$post['ins_cons_disc_amt']=0;
			$post['pcat_cons_disc_amt']=0;
			$post['insurance_company']='';
			$post['policy_no']='';
			$post['claim']='';
			$post['company_name']='';
			$post['company_id']='';
			$post['relation']='';
			$post['date_issue']='';
			$post['date_expiry']='';
		}
	
		if(empty($post['mlc'])){
		
					
			$post['mlc_date']='';
			$post['mlc_time']='';
			$post['mlc_summary']='';
			
		}else {
			$post['visit_time']=$post['mlc_time'];
		}
		
		$post['smsStatus1']=0;
		$post['smsStatus2']=0;
		$old_expiry='';
		$card_expiry_change=0;
		$card_expiry_lock=0;
		switch($status){
		
			case 'NEW'		:								
										$post['validity'] =date("Y-m-d",strtotime("+".$validity_days." day"));
										if($action =="REFER"){
										    $post['prefix']=$com_obj->getRegPrefix($post['type']);
										    $where[]="id = (SELECT MAX(id) FROM hcare_op_settings)";

											$validity_info= $gen_obj->getOpSettings('',$where,'','');
											if($validity_info[0][6]=='Y'){
														$no_of_year=$validity_info[0][5];
													$y = strtotime("+$no_of_year year");
													$post['card_expiry']=date('d-m-Y', "+$y");
													 // echo "Years : ".$years = date('Y-m-d', "+$y years");
									    				// exit;

												}else{
													$no_of_year=$validity_info[0][5];
													 $m = strtotime("+$no_of_year month");
													 // echo "Months : ".$months = date('Y-m-d', "+$m months");
													 // exit;
													 $post['card_expiry'] =date('d-m-Y', "+$m");
												}
											// $post['card_expiry'] =date('Y-m-d', strtotime('+1 year'));
											$post['card_issued'] ="NEW";
											$post['opno']=$opno=$reg_obj->addPatientinfo($post);
											
										    //send sms
											if($post['contact_no'] !=''){											
											
											$message1=$sms_obj->thank_reg_sms;
											$message1=str_replace("<prefix><opno>",$post['prefix']."/".$opno,$message1);											
											$phone = $post['contact_no'];
												if(strlen($phone) >= 10 && $phone>0){	


													if ($config_obj->sms_status=="YES") {
														
														$post['smsStatus1'] = $sms_obj->sendSMS($phone, $message1);
														
													}


												    
												}
											}
											
										}else {
											$post['card_expiry']=$db_obj->getidToValue('card_expiry','id', $post['opno'],'hcare_op_patient_info');
											$post['card_issued'] ="NEW";
											$opno=$reg_obj->updatePatientinfo_ref($post);
										}
									
										
										break;
			case  'VISIT'			:	
										
										$opno=$post['opno'];
										$docid=$post['doctor'];
										$selectCondition[0]="a.`id`='".$opno."'";
										$selectCondition[1]="b.`doc_id`='".$docid."'";
										$selectField[0]="b.`validity_expiry`";
										
										$patientInfo=$reg_obj->getOPPatientInfo($selectField,$selectCondition,'b.visit_date','desc');
										$post['validity'] =	$patientInfo[0][0];	
										
																		 
										$opno=$reg_obj->updatePatientinfo_ref($post);
										break;
			case   'RENEW'		:
										
										
										$post['validity'] =date("Y-m-d",strtotime("+".$validity_days." days"));
										
										$opno=$reg_obj->updatePatientinfo_ref($post);
										break;

			case  'REVISIT'			:	
										
										$opno=$post['opno'];
										$docid=$post['doctor'];
										$selectCondition[0]="a.`id`='".$opno."'";
										$selectCondition[1]="b.`doc_id`='".$docid."'";
										$selectField[0]="b.`validity_expiry`";
										
										$patientInfo=$reg_obj->getOPPatientInfo($selectField,$selectCondition,'b.visit_date','desc');
										$post['validity'] =	$patientInfo[0][0];	
										
																		 
										$opno=$reg_obj->updatePatientinfo_ref($post);
										break;

		
		}
		
		//Generate Token Number
			
			if(empty($post['token'])){
			
				$docid=$post['doctor'];
				$bk_obj = new BookingController();
				$post['token']=$bk_obj->generateTokenNo($docid,date("d-m-Y"));
			}
		               if($action =="REFER" && $post['contact_no'] !=''){
		                                $dr_name=$db_obj->getidToValue('first_name','id', $post['doctor'],'hcare_emp_info')." ".$db_obj->getidToValue('last_name','id', $post['doctor'],'hcare_emp_info');										
                                        $message2=$sms_obj->thank_reg_dr_sms;
										$message2=str_replace("<doctor_name>",$dr_name,$message2);
										$message2=str_replace("<visit_date>",date("d-m-Y",strtotime($post['visit_date'])),$message2);
										$message2=str_replace("<opno>",$opno,$message2);
										$message2=str_replace("<token>",$post['token'],$message2);
										
										$phone = $post['contact_no'];

										if(strlen($phone) >= 10 && $phone>0){

											if ($config_obj->sms_status=="YES") {
														
												$post['smsStatus2'] = $sms_obj->sendSMS($phone, $message2);

											}
										}

										
						}
		
		if($opno > 0 ){
		
			
			$post['opno']=$opno;
			
			/*//uploadphoto
			
			$fName=$_POST['multiFiles'];
			//$upload_base = 'E:\wamp\www\koyas_new\templates\registration\patient_photo';
			
			$upload_base = '..\..\templates\registration\patient_photo';
			
			if(!empty($fName)){
			$id=$opno;
			$file_name = basename($_FILES[$fName]['name']); 
		    $file_type = $_FILES[$fName]['type'];
		    $file_size = $_FILES[$fName]['size'];
		    $file_temp = $_FILES[$fName]['tmp_name'];
			
			$fname = "photo.jpg";			
			$fpath = $upload_base;
			
			if(file_exists($fpath."/".$id))	
			{
				if(file_exists($fpath."/".$id."/".$fname))	
				{
						@unlink($fpath."/".$id."/".$fname);	
						@unlink($fpath."/".$id."/".$fname);	
					
				}
					
			}
			else
			{
				mkdir($fpath."/".$id,0777); 
			}
			
						
				if(move_uploaded_file($file_temp, $fpath."/".$id."/".$fname)){
					$success = $file_name."<!--seperator-->";						
				}
			
			}*/
			
			
			   
			
			if($action =="REFER"){
			
				$post['reset_op_no']=$restOp_obj->nextResetOPNO();

				if ($status=="RENEW") {
					$post['regfee']=0;
				}

				if ($post['old_status']=="NEW" && $post['referal_type']=="CANCEL_REFER" ) {
					$post['regfee']=$post['regfee_old'];
					$post['cardfee']=$post['cardfee_old'];
					$reg_obj->updateFeeInfo($post);
				}
				
				$opid=$reg_obj->addVisitInfo($post);
				
				$restOp_obj->updateResetOPNO($post['reset_op_no']);

				$reg_obj->updateRefInfo($post['ref_id'],$opid);
				
				if(!empty($post['token'])){
					$bk_obj = new Booking();
					$bk_obj->updateToVisit($post['bk_id']);	
				}
			}else{
				$opid=$reg_obj->updateVisitInfo($post);
			}
		
		}else $opid=0;
		
		if($opid >0 ){
			$post['id']=$opid;
			
			if($action =="REFER"){
			        $post['module_name']="print_registration";
			        // $this->captureImage($post);
				$this->viewPage("print_registration",$post);
			}if($action =="REG_UPDATE" && empty($post['upload_status'])){
			      
				$this->viewPage("ManagePatients",$post);
			}else{
			$post['module_name']="print_registration";
			$this->viewPage("print_registration",$post);
			 // $this->captureImage($post);
			}
		
		}else{
		
			$this->viewPage("patient_registeration");
		}
	
	}
	public function save_payment_status($post)
	{
		
        $reg_obj = new Registration();
           
	    $id=$post['id'];
	    $value=$post['value'];
	    $checked=$post['checked'];

	    $reg_obj->update_save_payment_status($id,$value,$checked);


	}




	
	
}


?>
