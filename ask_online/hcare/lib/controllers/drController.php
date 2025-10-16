<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/common/pagination.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/procedure/procedure.php';
require_once ROOT_PATH . '/lib/model/doctor/doctor.php';
require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/lab/labModel.php';


class DrController {

	

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){ 
	
				
				case 'OPPatient_list':			  
						       			$reg_obj= new Registration();
                                        $com_obj = new CommonFunctions();

										$fromdate=$com_obj->getcurrentDate();
										$todate=$com_obj->getcurrentDate();
										$yes_date = date('Y-m-d', strtotime('-1 days', strtotime($com_obj->getcurrentDate())));
										$selectCondition[]="b.`visit_date`>='".$yes_date." 22:00:00'";
										$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";

										//$selectCondition[]="b.`cancelled`=0";
										$selectCondition[]="b.`cons_status`=''";

										$selectCondition[]="b.`doc_id`=".$_SESSION['emp_id'];

										$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.token_no','asc');                                
										$form_creator ->formPath ='/templates/doctor/op_patients.php';
										break;
                    case 'op_case_sheet' :$reg_obj= new Registration();
					                      $dr_obj=new Doctor(); 
										  $db_obj=new DBFunction();
										   $bill_obj=new Billing();
										  
										  if(isset($postArr['opid'])) {
											  $opid=$postArr['opid'];
											  $postArr['id']=$opid;
											}else $opid=$postArr['id'];
											
										   $postArr['patient_type']="OP";
										   
										   $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
																				
											//get patient details
											$selectCondition[]="b.`id`='".$opid."'";
											$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
					                        $postArr['patient_type']="OP";
											
											if(isset($getArr['active_module'])) {
											  $postArr['active_module']=$getArr['active_module'];
											}
											
					                    switch($postArr['active_module']){
											
										  	     case 'presenting_complaints'   :
																				
																				 $form_creator ->popArr['postArr']=$postArr;
														 
													 
																				  $where[0]="visit_id =".$opid;
																				  $where[1]="status =0";  
																				 $form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
																				 $form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
																				 $form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
																				 $form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where,'id','desc');
																				 $form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
																				 $form_creator ->popArr['past_history']=$dr_obj->getPastHistory('', $where);
																				 $form_creator ->popArr['radiology_presc']=$dr_obj->getRadiology_presc('', $where);
														 
																				  //get other visit details
													  
										
														 
																					$selectCondition[0]="`opno`='".$opno."'";
																					$selectCondition[1]="`id`!='".$opid."'";
																					$visitInfo=$reg_obj->getVisitDetails($selectCondition);
																					$casesheetInfo=array();
																					if(!empty($visitInfo)){
																						for($i=0;$i<count($visitInfo);$i++){
																							$where[0]="visit_id =".$visitInfo[$i][0];
																							$where[1]="status =0";  
																							$casesheetInfo[$i][0]=$dr_obj-> getPresent_complaint('', $where);
																							$casesheetInfo[$i][1]=$dr_obj-> getProv_diagnosis('', $where);	
																							$casesheetInfo[$i][2]=$dr_obj-> getProcedure_presc('', $where);
																							$casesheetInfo[$i][3]=$dr_obj->getLabtest_presc('', $where);
																							$casesheetInfo[$i][4]=$dr_obj->getMedicine_presc('', $where);
																							$casesheetInfo[$i][8]=$dr_obj->getPastHistory('', $where);
																							$casesheetInfo[$i][9]=$dr_obj->getRadiology_presc('', $where);
																										 
																							$casesheetInfo[$i][5]=$visitInfo[$i][0];
																							$casesheetInfo[$i][6]=$visitInfo[$i][1]." ".$visitInfo[$i][2];
																							$casesheetInfo[$i][7]=$visitInfo[$i][3];
																							$casesheetInfo[$i][10]=$visitInfo[$i][4];
																						}
																					}
																					
																					 $form_creator ->popArr['casesheetInfo']=$casesheetInfo;
																				
																				break;
												case 'patient_physical_exam' :$where[0]="visit_id =".$opid;
																			  $where[1]="status =0";  
																			  $form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);
																				
																				
																				$selectCondition[0]="`opno`='".$opno."'";
																				$selectCondition[1]="`id`!='".$opid."'"; 
																				$visitInfo=$reg_obj->getVisitDetails($selectCondition);
																				$examinatHistory=array();
																					if(!empty($visitInfo)){
																						for($i=0;$i<count($visitInfo);$i++){
																							$where[0]="visit_id =".$visitInfo[$i][0];
																							$where[1]="status =0";  
																							$examinatHistory[$i][0]=$dr_obj-> getPhysicalExamination('', $where);
																							
																							$examinatHistory[$i][1]=$visitInfo[$i][0];
																							$examinatHistory[$i][2]=$visitInfo[$i][1]." ".$visitInfo[$i][2];
																							$examinatHistory[$i][3]=$visitInfo[$i][3];
																						}
																					}
																					
																					$form_creator ->popArr['examinatHistory']=$examinatHistory;
																				break;
												case 'diabetic_analysis' :   $where[0]="opno =".$opno;
																			  $where[1]="status =0";  
																			  $form_creator ->popArr['readingInfo']=$dr_obj->get_diabetic_readings('', $where);
																				 
																				break;
												case 'patient_allergies' :    $where[0]="opno =".$opno;
																			  $where[1]="status =0";  
																			  $form_creator ->popArr['allergicInfo']=$dr_obj->getPatient_allergies('', $where);
																				 
																				break;
												case 'patient_documents' : 
																				
																				$where[0]="opno =".$opno;
																				$where[1]="status =0"; 
																				$form_creator ->popArr['documentInfo']=$dr_obj->getPatient_documents('', $where);

																				break;

												case 'covid_status' :   		$where[0]="visit_id =".$opid;
																			    $where[1]="status =0";  
																			    $form_creator ->popArr['covidInfo']=$dr_obj->get_covid_info('', $where);

																				$where[0]="opno =".$opno;
																				$where[1]="visit_id !=".$opid;
																				$where[2]="status =0";
																				$covidHistory=$dr_obj->get_covid_info('',$where,'id','desc');

																				
																				$form_creator ->popArr['covidHistory']=$covidHistory;

																				 
																				break;

                                                case 'view_complete_note' :
												                                  $where[0]="visit_id =".$opid;
																				  $where[1]="status =0";  
																				 $form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
																				 $form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
																				 $form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
																				 $form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where);
																				 $form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
																				 $form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);

																				$form_creator ->popArr['past_history']=$dr_obj-> getPastHistory('', $where);	 

																				$form_creator ->popArr['radiology_presc']=$dr_obj-> getRadiology_presc('', $where);
																				 
																				 $where[0]="opno =".$opno;
																			     $where[1]="status =0";  
																			     $form_creator ->popArr['allergicInfo']=$dr_obj->getPatient_allergies('', $where);

																				$where[0]="visit_id =".$opid;
																				$where[1]="status = 0";  
																				$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where);

														 
                                                                             break;												
									case 'refer_doctor' : 
													
													$emp_obj = new Employee();						
												
													$is_field[0]="a.title='Dr'";
													$is_field[1]="a.status= 0 ";													
													$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);

													$selectCondition[]="b.`id`='".$opid."'";
													$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);


													$where[0]="visit_id =".$opid;
													$where[1]="status = 0";  
													$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where,'id','desc');


													$form_creator ->formPath ='/templates/doctor/refer_doctor.php';


												break;
											
										}

              				            
										 
										 
										 $where[0]="opno =".$opno;
										 $where[1]="status =0";  
										 $form_creator ->popArr['allergicCount']=$dr_obj->CountPatient_allergies($where);
										 
										 $wherecondn[0]="opno=".$opno;
			
			                            $form_creator ->popArr['diabetic_status']=$dr_obj->get_diabetic_status('',$wherecondn);
										
										$form_creator ->popArr['is_hyper_ten']=$dr_obj->get_hyper_tesion_status('',$wherecondn);
										
										//lab result
										$billCondn[0]="type ='OP'";
										$billCondn[1]="opno =".$opno;
										$billCondn[2]="status =0";
										$billCondn[3]="lab_status =1";
										
										$form_creator ->popArr['resultInfo']=$bill_obj->getBillInfo($billCondn,'id','desc');
																				 
                                         $form_creator ->popArr['postArr']=$postArr;
                                         $form_creator ->formPath ='/templates/doctor/op_case_sheet.php';
							                    break;
				case 'patient_allergies' :   
				                           $dr_obj=new Doctor();
										   $db_obj=new DBFunction();
										   
										   $opid=$getArr['visit_id'];
										   $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
										   
				                           $where[0]="opno =".$opno;
										   $where[1]="status =0";  
										   $form_creator ->popArr['allergicInfo']=$dr_obj->getPatient_allergies('', $where);
										   $form_creator ->formPath ='/templates/doctor/show_patient_allergies.php';									 
											break;
			    case 'view_case_sheet' : $reg_obj= new Registration();
			                             $dr_obj=new Doctor(); 
                                         $db_obj=new DBFunction();	
										  $bill_obj=new Billing();
										 
										 $postArr['active_module']=$getArr['active_module'];
										 
										 //get opid
			                              if(isset($postArr['opid'])) {
											  $opid=$postArr['opid'];
											  $postArr['id']=$opid;
											}else $opid=$postArr['id'];
											
											 $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
									
										//get casesheet id
									switch($postArr['active_module']){
									
                                    case 'current_visit': $opid_sel=$opid;

                                    case 'casesheet_history' :
									
										 if(isset($getArr['id_selected'])){
											 $opid_sel=$getArr['id_selected'];
											 $postArr['opid_selected']=$opid_sel;
										 }
						     
							            //patient information based on casesheet selected
						                 $selectCondition[0]="b.`id`='".$opid_sel."'";
						                 $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition);
						     
										   //get selected visit details
										 $where[0]="visit_id =".$opid_sel;
										  $where[1]="status =0";
                                                     
                                            $form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
                                            $form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
                                            $form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
                                            $form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where);
                                            $form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
                                            $form_creator ->popArr['past_history']=$dr_obj->getPastHistory('', $where);
                                            $form_creator ->popArr['radiology_presc']=$dr_obj->getRadiology_presc('', $where);
											$form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);
											
											$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where);

											break;
									case 'diabetic_analysis' :   $where[0]="opno =".$opno;
																 $where[1]="status =0"; 
   																 
																 $form_creator ->popArr['readingInfo']=$dr_obj->get_diabetic_readings('', $where);
																  //patient information based on casesheet selected
						                                        $selectCondition[0]="b.`id`='".$opid."'";
						                                        $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition);			 
																				break;		
									 case 'view_lab_result':$lab_obj=new LabModel();

									          if(isset($getArr['id_selected'])){
											     $billno=$getArr['id_selected'];
											     $postArr['labid_selected']=$billno;
												 	if(empty($billno)) $billno=$getArr['billno'];
															$result_id=$postArr['result_id'];
															if(empty($result_id)){
																$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
																$result_id=$resultInfo[0][0];
															}
															
															
															if(!empty($result_id)){
																
																$wheredata[0]="result_id=".$result_id;
																$form_creator ->popArr['resultEntryInfo']=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
																
																$billcondn[0]="id=".$billno;
																$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
																
															}
											
										      }
						            }
										  //get other visit details
									
										
										 
										 $selectCondition[0]="`opno`='".$opno."'";
										 $selectCondition[1]="`id`!='".$opid."'";
										 $visitInfo=$reg_obj->getVisitDetails($selectCondition);
										 $casesheetInfo=array();
										 if(!empty($visitInfo)){
										 
											 for($i=0;$i<count($visitInfo);$i++){
										 
											 $where[0]="visit_id =".$visitInfo[$i][0];
											  $where[1]="status =0"; 
											 $casesheetInfo[$i][0]=$dr_obj-> getPresent_complaint('', $where);
											 $casesheetInfo[$i][1]=$dr_obj-> getProv_diagnosis('', $where);	
											 $casesheetInfo[$i][2]=$dr_obj-> getProcedure_presc('', $where);
											 $casesheetInfo[$i][3]=$dr_obj->getLabtest_presc('', $where);
											 $casesheetInfo[$i][4]=$dr_obj->getMedicine_presc('', $where);
											 
											   $casesheetInfo[$i][5]=$visitInfo[$i][0];
											   $casesheetInfo[$i][6]=$visitInfo[$i][1];
											   $casesheetInfo[$i][7]=$visitInfo[$i][3];
											   
											   
										 }
										 }
										 $form_creator ->popArr['casesheetInfo']=$casesheetInfo;	
							 
							 //lab result
							 //lab result
										$billCondn[0]="type ='OP'";
										$billCondn[1]="opno =".$opno;
										$billCondn[2]="status =0";
										$billCondn[3]="lab_status =1";
										
										$form_creator ->popArr['labresultInfo']=$bill_obj->getBillInfo($billCondn,'id','desc');
								//diabetic status		
								      $wherecondn[0]="opno=".$opno;
			
			                            $form_creator ->popArr['diabetic_status']=$dr_obj->get_diabetic_status('',$wherecondn);

			                             $form_creator ->popArr['is_hyper_ten']=$dr_obj->get_hyper_tesion_status('',$wherecondn);
										
										  $form_creator ->popArr['postArr']=$postArr;
			                              $form_creator ->formPath ='/templates/doctor/view_case_sheet.php';
							break;
			   case 'print_prescription' : $reg_obj= new Registration();
			                             $dr_obj=new Doctor();
                                         $emp_obj=new Employee(); 										 
                                         $db_obj=new DBFunction();	

                                            if(isset($postArr['opid'])) {
											  $opid=$postArr['opid'];
											  $postArr['id']=$opid;
											}else $opid=$postArr['id'];
						     
						      $selectCondition[0]="b.`id`='".$opid."'";
						     $form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
							 
							 $dr_id=$patientInfo[0][14];
							 $dr_condn[0]="a.id=".$dr_id;
							 $form_creator ->popArr['dr_info']=$emp_obj->getEmployee($dr_condn);
						     
						       //get selected visit details
						     $where[0]="visit_id =".$opid;
							 $where[1]="status =0";
                                                     
                                                     $form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
                                                     $form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
                                                     $form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
                                                     $form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where);
                                                     $form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
						     
													 $form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);
												

						      $form_creator ->formPath ='/templates/doctor/print_prescription.php';
							break;
						     break;
			   case 'patient_history'  : $reg_obj= new Registration();
			                              $com_obj = new CommonFunctions();
										   $pagi_obj = new Pagination();
						      
						      $selectCondition=array();
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
								$selectCondition[]="a.`place`='".$postArr["place"]."'";
							}
							if(!empty($postArr["doctor"])){
								$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
							}
							if(!empty($postArr["visit_status"])){
								$selectCondition[]="b.`visit_status`='".$postArr["visit_status"]."'";
							}
							if(!empty($postArr["contact_no"])){
								$selectCondition[]="a.`contact_no`='".$postArr["contact_no"]."'";
							}
						      
			                              if(empty($selectCondition)){ 
													
								$fromdate=$com_obj->getcurrentDate();
								$todate=$com_obj->getcurrentDate();
								$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
								$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
							}
                                                        
                                                      
						      $selectCondition[]="b.`cancelled`=0";
						      $selectCondition[]="b.`cons_status`='YES'";

                               $selectCondition[]="b.`doc_id`=".$_SESSION['emp_id'];
								$patientCount=$reg_obj->getOPPatientCount($selectCondition);
                               $perPage=$pagi_obj->perPage;	

                               if(empty($postArr['current_page'])) $current_page =1;			
			                   else $current_page = $postArr['current_page'];
			
					
			                  //set limit value for query
			                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                              $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($patientCount,$current_page);	
                             $form_creator ->popArr['current_page']=$current_page;					  
						       $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc', $limit);                                
								$form_creator ->popArr['post']=$postArr;			  
											 	
							$form_creator ->formPath ='/templates/doctor/op_patient_history.php';
							break;
                 
                  case 'inpatients_list'  : 
                                        $com_obj = new CommonFunctions();
									    $ip_obj= new Inpatient();
										$selectCondition=array();	   
									
															if(!empty($postArr["from_date"])){
															   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
																$selectCondition[]="b.`admission_date`>='".$fromdate."'";
															}
															if(!empty($postArr["to_date"])){
															   $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
																$selectCondition[]="b.`admission_date`<='".$todate."'";    
															}
															
															if(!empty($postArr["opno"])){
																$selectCondition[]="a.`id`='".$postArr["opno"]."'";
															}
															if(!empty($postArr["ipno"])){
																$selectCondition[]="b.`ipno` like '%".$postArr["ipno"]."%'";
															}
															if(!empty($postArr["first_name"])){
																$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
															}
															if(!empty($postArr["place"])){
																$selectCondition[]="a.`place`='".$postArr["place"]."'";
															}
															if(!empty($postArr["doctor"])){
																$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
															}
															if(!empty($postArr["room_no"])){
																$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
															}
											  
                                                            if(empty($selectCondition)){
															
															  $fromdate=$com_obj->getcurrentDate();
															 // $selectCondition[]="b.`admission_date`>='".$fromdate."'";
															  
															  $todate=$com_obj->getcurrentDate();
															  // $selectCondition[]="b.`admission_date`<='".$todate."'";  
															}
											    $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";                                                                            
                                                
												//$selectCondition[]="b.`doc_id`='".$_SESSION["emp_id"]."'";
												$selectCondition[]="b.`cancelled`=0";
											
												$selectCondition[]="b.`doc_id`='".$_SESSION["emp_id"]."'";
												$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');

												
												if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
												}else $form_creator ->popArr['post']='';
											  
											  
					                       $form_creator ->formPath ='/templates/doctor/ip_patients_list.php';
													break;






			     case 'inpatients'  : 
                                        $com_obj = new CommonFunctions();
									    $ip_obj= new Inpatient();
										$selectCondition=array();	   
											   //search criterias
										
															if(!empty($postArr["from_date"])){
															   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
																$selectCondition[]="b.`admission_date`>='".$fromdate."'";
															}
															if(!empty($postArr["to_date"])){
															   $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
																$selectCondition[]="b.`admission_date`<='".$todate."'";    
															}
															
															if(!empty($postArr["opno"])){
																$selectCondition[]="a.`id`='".$postArr["opno"]."'";
															}
															if(!empty($postArr["ipno"])){
																$selectCondition[]="b.`id`='".$postArr["ipno"]."'";
															}
															if(!empty($postArr["first_name"])){
																$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
															}
															if(!empty($postArr["place"])){
																$selectCondition[]="a.`place`='".$postArr["place"]."'";
															}
															if(!empty($postArr["doctor"])){
																$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
															}
															if(!empty($postArr["room_no"])){
																$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
															}
											  
               //                                              if(empty($selectCondition)){
															
															//   $fromdate=$com_obj->getcurrentDate();
															//   $selectCondition[]="b.`admission_date`>='".$fromdate."'";
															  
															//    $todate=$com_obj->getcurrentDate();
															//    $selectCondition[]="b.`admission_date`<='".$todate."'";  
															// }
												//$selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date`='')";                                                                            
                                                
												// $selectCondition[]="b.`doc_id`='".$_SESSION["emp_id"]."'";
												$selectCondition[]="b.`cancelled`=0";
												$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
												if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
												}else $form_creator ->popArr['post']='';
											  
											  
					                       $form_creator ->formPath ='/templates/doctor/ip_patients_list.php';
													break;



                                 
													
			  case 'ip_case_sheet' :      $reg_obj= new Registration();
					                      $dr_obj=new Doctor(); 
										  $db_obj=new DBFunction();
										  $bill_obj=new Billing();
									      $ip_obj= new Inpatient();
     
				// var_dump($postArr);exit();						
										  if(isset($postArr['opid'])) {
											  $opid=$postArr['opid'];
											  $postArr['id']=$opid;
										  }else $opid=$postArr['id'];
											
										   $postArr['patient_type']="IP";
										   
										   $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
										   // $postArr['ipno']=$ipno=$db_obj->getidToValue("id","opno", $opid,"hcare_ip_info");
                                           
                                          if(!empty($postArr['patient_ipno'])){

                                             $postArr['ipno']=$ipno=$postArr['patient_ipno'];

                                          }elseif (!empty($postArr['ipno'])) {
                                          	
                                             $postArr['ipno']=$ipno=$postArr['ipno'];
                                          }
										//	$postArr['ref_no']=$ref_ipno=$db_obj->getidToValue("ipno","opno", $opid,"hcare_ip_info");					
											//get patient details
											$postArr['ref_no'] = 0;
											$selectCondition[]="a.`id`='".$opid."'";
											$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.id','desc');
					                        $postArr['patient_type']="IP";
												
	                                         $where[0]="ipno =".$ipno;
											 $where[1]="status =0";  
											 $form_creator ->popArr['allergicCount']=$dr_obj->Count_ip_Patient_allergies($where);



											if(isset($getArr['active_module'])) {
											  $postArr['active_module']=$getArr['active_module'];
											}
											
					                   switch($postArr['active_module']){
											
										  	case 'ip_presenting_complaints'   :
																				
											    $form_creator ->popArr['postArr']=$postArr;
														 
													 
												$where2[0]="ipno =".$ipno;
												$where2[1]="status =0";
												$where2[2]="date_time like '%".date('Y-m-d')."%'";


												$form_creator ->popArr['ip_presenting_complaints']=$dr_obj-> get_ip_Present_complaint('', $where2);
												$form_creator ->popArr['ip_prov_diagnosis']=$dr_obj-> get_ip_Prov_diagnosis('', $where2);	
												$form_creator ->popArr['ip_procedure_presc']=$dr_obj-> get_ip_Procedure_presc('', $where2);
												$form_creator ->popArr['ip_labtest_presc']=$dr_obj->get_ip_Labtest_presc('', $where2);
													$form_creator ->popArr['ip_medicine_presc']=$dr_obj->get_ip_Medicine_presc('', $where2);
												$form_creator ->popArr['ip_past_history']=$dr_obj->get_ip_PastHistory('', $where2);
												$form_creator ->popArr['ip_radiology_presc']=$dr_obj->get_ip_Radiology_presc('', $where2);

																				
                                                $where[0]="ipno =".$ipno;
											    $where[1]="status =0"; 
												$where[2]="date_time not like '%".date('Y-m-d')."%'"; 

										// $presenting_complaints=$dr_obj-> get_ip_Present_complaint('', $where);  
										 // $form_creator ->popArr['presenting_complaints']=$dr_obj-> get_ip_Present_complaint('', $where);
									    // $form_creator ->popArr['prov_diagnosis']=$dr_obj-> get_ip_Prov_diagnosis('', $where);	
										// $form_creator ->popArr['procedure_presc']=$dr_obj-> get_ip_Procedure_presc('', $where);
										 // $form_creator ->popArr['labtest_presc']=$dr_obj->get_ip_Labtest_presc('', $where);
										// $form_creator ->popArr['medicine_presc']=$dr_obj->get_ip_Medicine_presc('', $where);
										// $form_creator ->popArr['past_history']=$dr_obj->get_ip_PastHistory('', $where);
										// $form_creator ->popArr['radiology_presc']=$dr_obj->get_ip_Radiology_presc('', $where);

                                                 $selectCondition[0]="`opno`='".$opno."'";
												 $selectCondition[1]="`id`!='".$opid."'";
												 $form_creator ->popArr['visitInfo']=$visitInfo=$reg_obj->getVisitDetails($selectCondition);
												 $casesheetInfo=array();
																				
												 $casesheetInfo[0]=$dr_obj-> get_ip_Present_complaint('', $where);
												 $casesheetInfo[1]=$dr_obj-> get_ip_Prov_diagnosis('', $where);	
												 $casesheetInfo[2]=$dr_obj-> get_ip_Procedure_presc('', $where);
												 $casesheetInfo[3]=$dr_obj->get_ip_Labtest_presc('', $where);
												  // $casesheetInfo[3]=$dr_obj->get_ip_Labtest_presc('', $where,'id','desc');
												 $casesheetInfo[4]=$dr_obj->get_ip_Medicine_presc('', $where);
												 $casesheetInfo[8]=$dr_obj->get_ip_PastHistory('', $where);
												 $casesheetInfo[9]=$dr_obj->get_ip_Radiology_presc('', $where);

												 $whre[0]="ipno='".$ipno."'";
												 // $whre[1]="entered_by='".$_SESSION['user_id']."'";
												 $whre[1]="status= 0";


												 $form_creator ->popArr['ip_details']=$ip_details=  $dr_obj->get_ip_consultation_details('',$whre);
																						
												 $form_creator ->popArr['casesheetInfo']=$casesheetInfo;
																				
																				break;
												case 'ip_patient_physical_exam' :
													$where1[0]="ipno =".$ipno;
													$where1[1]="status =0";
													$where1[2]="date_time like '%".date('Y-m-d')."%'"; 
													$form_creator ->popArr['physical_examination']=$examHistory=$dr_obj-> get_ip_PhysicalExamination('', $where1);
																			
													// $postArr['ipno']=$ipno=$db_obj->getidToValue("id","opno", $opid,"hcare_ip_info");
											        //  $postArr['ref_no']=$ref_ipno=$db_obj->getidToValue("ipno","opno", $opid,"hcare_ip_info");	
													$postArr['ref_no'] = 0;
													$selectCondition[0]="`opno`='".$opno."'";
													$selectCondition[1]="`id`!='".$opid."'"; 
													$visitInfo=$reg_obj->getVisitDetails($selectCondition);
													// var_dump($visitInfo);
													$examinatHistory=array();
													//if(!empty($visitInfo)){
													// $where[0]="ipno =".$ipno;
													// $where[1]="status =0";  
													// $exHistory=$dr_obj-> get_ip_PhysicalExamination('', $where);
													// for($i=0;$i<count($exHistory);$i++){
													// $where[0]="ipno =".$ipno;
													// $where[1]="status =0";  
													// $examinatHistory[$i][0]=$dr_obj-> get_ip_PhysicalExamination('', $where);
																							
													// $examinatHistory[$i][1]=$visitInfo[$i][0];
													// $examinatHistory[$i][2]=$visitInfo[$i][1]." ".$visitInfo[$i][2];
													// $examinatHistory[$i][3]=$visitInfo[$i][3];
													// var_dump($visitInfo[$i][0]);
													// }
													// }
																					
													// $form_creator ->popArr['examinatHistory']=$examinatHistory;
                                                                                     
                                                    $where[0]="ipno =".$ipno;
													$where[1]="status =0"; 
                                                    $where[2]="date_time not like '%".date('Y-m-d')."%'";
													$form_creator ->popArr['examinatHistory']=$dr_obj->get_ip_PhysicalExamination('', $where,'id','desc');$form_creator ->popArr['post']=$postarr;
														break;
												case 'ip_diabetic_analysis' :   
												     $where[0]="ipno =".$ipno;
													 $where[1]="status =0";  
													 $form_creator ->popArr['readingInfo']=$dr_obj->get_ip_diabetic_readings('', $where,'id','desc');
																				 
													 break;
												case 'ip_patient_allergies' :   
												     $where[0]="ipno =".$ipno;
													 $where[1]="status =0";  
													 $form_creator ->popArr['allergicInfo']=$dr_obj->get_ip_Patient_allergies('', $where,'id','desc');
																				 
													 break;
												case 'ip_patient_documents' : 
																				
													 $where2[0]="ipno =".$ipno;
													 $where2[1]="status =0"; 
													 $where2[2]="xray_status !=1"; 
													 $form_creator ->popArr['documentInfo']=$dr_obj->get_ip_Patient_documents('', $where2);

													 break;
												case 'ip_patient_xray_documents' : 
																				
													 $where3[0]="ipno =".$ipno;
													 $where3[1]="status =0"; 
													 $where3[2]="xray_status =1"; 
													 $form_creator ->popArr['documentInfo']=$dr_obj->get_ip_Patient_xray_documents('', $where3);

													 break;
                                                case 'ip_view_complete_note' :

												     $where[0]="ipno =".$ipno;
													 $where[1]="status =0"; 

													 $form_creator ->popArr['presenting_complaints']=$dr_obj-> get_ip_Present_complaint('', $where);
													 $form_creator ->popArr['prov_diagnosis']=$dr_obj-> get_ip_Prov_diagnosis('', $where);	
													 $form_creator ->popArr['procedure_presc']=$dr_obj-> get_ip_Procedure_presc('', $where);
													 // $form_creator ->popArr['labtest_presc']=$dr_obj->get_ip_Labtest_presc('', $where,'id','desc');
													  $form_creator ->popArr['labtest_presc']=$dr_obj->get_ip_Labtest_presc('', $where);
													 $form_creator ->popArr['medicine_presc']=$dr_obj->get_ip_Medicine_presc('', $where);
													 $form_creator ->popArr['physical_examination']=$dr_obj-> get_ip_PhysicalExamination('', $where,'id','desc');

													 $form_creator ->popArr['past_history']=$dr_obj-> get_ip_PastHistory('', $where);	 

													 $form_creator ->popArr['radiology_presc']=$dr_obj-> get_ip_Radiology_presc('', $where);
																				 
													 $where[0]="ipno =".$ipno;
													 $where[1]="status =0";  
													 $form_creator ->popArr['allergicInfo']=$dr_obj->get_ip_Patient_allergies('', $where,'id','desc');

													 $where[0]="ipno =".$ipno;
													 $where[1]="status =0";  
													 $form_creator ->popArr['otInfo']=$ot=$dr_obj->get_ip_ot_notes('', $where,'id','desc');
													 $form_creator ->popArr['details']=$ot=$dr_obj->get_ip_consultation_details('', $where,'id','desc');
                                                                                  
													 $where[0]="visit_id =".$opid;
													 $where[1]="status = 0";  
													 $form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where);

														 
                                                                             break;		
                                               case 'ip_ot_note' : 
																				
													$where[0]="ipno =".$ipno;
													$where[1]="status =0"; 

												    $form_creator ->popArr['otInfo']=$dr_obj->get_ip_ot_notes('', $where,'id','desc');

														break;										
									// case 'refer_doctor' : 
													
									// 				$emp_obj = new Employee();						
												
									// 				$is_field[0]="a.title='Dr'";
									// 				$is_field[1]="a.status= 0 ";													
									// 				$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);

									// 				$selectCondition[]="b.`id`='".$opid."'";
									// 				$form_creator ->popArr['patient_info']=$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);


									// 				$where[0]="visit_id =".$opid;
									// 				$where[1]="status = 0";  
									// 				$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where,'id','desc');


									// 				$form_creator ->formPath ='/templates/doctor/refer_doctor.php';


									// 			break;
											
									}

							            
									 
									 
									 
									 
									 $wherecondn[0]="opno=".$opno;

					                $form_creator ->popArr['diabetic_status']=$dr_obj->get_ip_diabetic_status('',$wherecondn);
									
									$form_creator ->popArr['is_hyper_ten']=$dr_obj->get_ip_hyper_tesion_status('',$wherecondn);
									
									//lab result

									$billCondn[0]="type ='IP'";
									
									$billCondn[1]="status =0";
									$billCondn[2]="lab_status =1";
									$billCondn[3]="ref_no =".$ipno;
									$billCondn[4]="opno =".$opid;
									 // var_dump($billCondn); exit();
									
									$form_creator ->popArr['resultInfo']=$resultInfo=$bill_obj->getBillInfo($billCondn,'id','desc');
									// var_dump($resultInfo); exit();
									
																			 
					                 $form_creator ->popArr['postArr']=$postArr;
					                 $form_creator ->formPath ='/templates/doctor/ip_case_sheet.php';
						                    break;






					case 'ip_patient_allergies' :   
				                           $dr_obj=new Doctor();
										   $db_obj=new DBFunction();
										 
										   $opid=$getArr['visit_id'];
										   $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
                                            $ipno=$getArr['ipno'];
										   
				                           $where[0]="ipno =".$ipno;
										   $where[1]="status =0";  
										   $form_creator ->popArr['allergicInfo']=$dr_obj->get_ip_Patient_allergies('', $where,'id','desc');
										   $form_creator ->formPath ='/templates/doctor/show_ip_patient_allergies.php';									 
											break;
			    // case 'view_ip_case_sheet' : $reg_obj= new Registration();
			    //                          $dr_obj=new Doctor(); 
       //                                   $db_obj=new DBFunction();	
							// 			  $bill_obj=new Billing();
										 
							// 			 $postArr['active_module']=$getArr['active_module'];
										 
							// 			 //get opid
			    //                           if(isset($postArr['opid'])) {
							// 				  $opid=$postArr['opid'];
							// 				  $postArr['id']=$opid;
							// 				}else $opid=$postArr['id'];
											
							// 				 $opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
									
							// 			//get casesheet id
							// 		switch($postArr['active_module']){
									
       //                              case 'current_visit': $opid_sel=$opid;

       //                              case 'ip_casesheet_history' :
									
							// 			 if(isset($getArr['id_selected'])){
							// 				 $opid_sel=$getArr['id_selected'];
							// 				 $postArr['opid_selected']=$opid_sel;
							// 			 }
						     
							//             //patient information based on casesheet selected
						 //                 $selectCondition[0]="b.`id`='".$opid_sel."'";
						 //                 $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition);
						     
							// 			   //get selected visit details
							// 			 $where[0]="visit_id =".$opid_sel;
							// 			  $where[1]="status =0";
                                                     
       //                                      $form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
       //                                      $form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
       //                                      $form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
       //                                      $form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where);
       //                                      $form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
       //                                      $form_creator ->popArr['past_history']=$dr_obj->getPastHistory('', $where);
       //                                      $form_creator ->popArr['radiology_presc']=$dr_obj->getRadiology_presc('', $where);
							// 				$form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);
											
							// 				$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where);

							// 				break;
		case 'ip_diabetic_analysis' :   
			    $where[0]="ipno =".$ipno;
				$where[1]="status =0"; 
   																 
				$form_creator ->popArr['readingInfo']=$dr_obj->get_ip_diabetic_readings('', $where,'id','desc');
				//patient information based on casesheet selected
				$selectCondition[0]="b.`id`='".$opid."'";
				$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'id','desc');			 
				break;

		case 'previous_ip_details' :   

			    $reg_obj= new Registration();
			    $dr_obj=new Doctor(); 
				$db_obj=new DBFunction();
				$bill_obj=new Billing();
				$ip_obj= new Inpatient();
                
                $patient_info = array();
				$ip_no_list = array();
                $admission_date = array();
                $admission_time = array();
                $discharge_date = array();
                $discharge_time = array();

				$presenting_complaints = array();
                $prov_diagnosis = array();
                $procedure_presc = array();
                $labtest_presc = array();
                $medicine_presc = array();
                $physical_examination = array();
                $past_history = array();
                $radiology_presc = array();
                $allergicInfo = array();
                $otInfo = array();
                $details = array();
                $referalInfo = array();

                $op_no = $getArr['opnumb'];
                $ip_no = $getArr['ipnumb'];
                                    


				$selectCondition[]="a.`id`='".$op_no."'";
				$selectCondition[]="b.`id`!='".$ip_no."'";
				$form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.id','desc');

				$first_name=$db_obj->getidToValue("first_name","id", $op_no,"hcare_op_patient_info");
				$middle_name=$db_obj->getidToValue("middle_name","id", $op_no,"hcare_op_patient_info");
				$last_name=$db_obj->getidToValue("last_name","id", $op_no,"hcare_op_patient_info");

    if(!empty($patient_info)){

                for ($i=0; $i <count($patient_info); $i++) {

                	$ip_no_list[$i] = $patient_info[$i][13];//ip number

                	$admission_date[$i] = $patient_info[$i][20];
                	$admission_time[$i] = $patient_info[$i][19];
                	$discharge_date[$i] = $patient_info[$i][22];
                	$discharge_time[$i] = $patient_info[$i][21];

                	$where[0]="ipno =".$patient_info[$i][13];
					$where[1]="status =0"; 

                    // $presenting_complaints[$i]=$dr_obj-> get_ip_Present_complaint('', $where,'id','desc');
                    $presenting_complaints[$i]=$dr_obj-> get_ip_Present_complaint('', $where);
					$prov_diagnosis[$i]=$dr_obj-> get_ip_Prov_diagnosis('', $where);	
					$procedure_presc[$i]=$dr_obj-> get_ip_Procedure_presc('', $where);
					$labtest_presc[$i]=$dr_obj->get_ip_Labtest_presc('', $where);
					$medicine_presc[$i]=$dr_obj->get_ip_Medicine_presc('', $where);
					$physical_examination[$i]=$dr_obj-> get_ip_PhysicalExamination('', $where,'id','desc');

					$past_history[$i]=$dr_obj-> get_ip_PastHistory('', $where);	 

					$radiology_presc[$i]=$dr_obj-> get_ip_Radiology_presc('', $where);
																				 
					$where[0]="ipno =".$patient_info[$i][13];
					$where[1]="status =0";  
                    $allergicInfo[$i]=$dr_obj->get_ip_Patient_allergies('', $where,'id','desc');

					$where[0]="ipno =".$patient_info[$i][13];
					$where[1]="status =0";  
					$otInfo[$i]=$ot=$dr_obj->get_ip_ot_notes('', $where,'id','desc');
				    $details[$i]=$ot=$dr_obj->get_ip_consultation_details('', $where,'id','desc');
                                                                                  
					$where[0]="visit_id =".$patient_info[$i][0];
					$where[1]="status = 0";  
					$referalInfo[$i]=$dr_obj->getDrReferalInfo('', $where);
                                  
                }

                $form_creator ->popArr['patient_info'] = $patient_info;

                $form_creator ->popArr['patientName']=$first_name." ".$middle_name." ".$last_name;
                
                $form_creator ->popArr['ip_no_list'] = $ip_no_list;

                $form_creator ->popArr['admission_date'] = $admission_date;
                $form_creator ->popArr['admission_time'] = $admission_time;
                $form_creator ->popArr['discharge_date'] = $discharge_date;
                $form_creator ->popArr['discharge_time'] = $discharge_time;

                $form_creator ->popArr['presenting_complaints'] = $presenting_complaints;
                $form_creator ->popArr['prov_diagnosis'] = $prov_diagnosis;
                $form_creator ->popArr['procedure_presc'] = $procedure_presc;
                $form_creator ->popArr['labtest_presc'] = $labtest_presc;
                $form_creator ->popArr['medicine_presc'] = $medicine_presc;
                $form_creator ->popArr['physical_examination'] = $physical_examination;
                $form_creator ->popArr['past_history'] =  $past_history;
                $form_creator ->popArr['radiology_presc'] = $radiology_presc;
                $form_creator ->popArr['allergicInfo'] = $allergicInfo;
                $form_creator ->popArr['otInfo'] = $otInfo;
                $form_creator ->popArr['details'] = $details;
                $form_creator ->popArr['referalInfo'] = $referalInfo;

    }else{

                $form_creator ->popArr['patientName']=$first_name." ".$middle_name." ".$last_name;

    }
                          
			    $form_creator ->formPath ='/templates/doctor/previous_ip_details.php';			 
									break;

		case 'current_op_details' :

			    $reg_obj= new Registration();
			    $dr_obj=new Doctor(); 
				$db_obj=new DBFunction();
				$bill_obj=new Billing();
                
                $op_no = $getArr['opnumb'];

                $search = array();
			    $search[0] = "opno = '".$op_no."'";
			    $search[1] = "cancelled = 0";

			    $op_vist_id=$db_obj->getIdToValueMultiple('max(id)',$search,'hcare_op_visit_info');
    
                $selectCondition[]="a.`id`='".$op_no."'";
				$selectCondition[]="a.`status`=0";
				$selectCondition[]="b.`id`='".$op_vist_id."'";
				$selectCondition[]="b.`cancelled`=0";
				$form_creator ->popArr['patient_info']=$patient_info=$reg_obj->getOPPatientInfo('',$selectCondition,'b.token_no','asc');
                                    
                $first_name=$db_obj->getidToValue("first_name","id", $op_no,"hcare_op_patient_info");
				$middle_name=$db_obj->getidToValue("middle_name","id", $op_no,"hcare_op_patient_info");
				$last_name=$db_obj->getidToValue("last_name","id", $op_no,"hcare_op_patient_info");

                $form_creator ->popArr['patientName']=$first_name." ".$middle_name." ".$last_name;
                $form_creator ->popArr['op_no']=$op_no;
                $form_creator ->popArr['visit_date']=$patient_info[0][20];
                $form_creator ->popArr['visit_time']=$patient_info[0][19];

                $where[0]="visit_id =".$op_vist_id;
				$where[1]="status =0";  
				$form_creator ->popArr['presenting_complaints']=$dr_obj-> getPresent_complaint('', $where);
				$form_creator ->popArr['prov_diagnosis']=$dr_obj-> getProv_diagnosis('', $where);	
				$form_creator ->popArr['procedure_presc']=$dr_obj-> getProcedure_presc('', $where);
				$form_creator ->popArr['labtest_presc']=$dr_obj->getLabtest_presc('', $where);
				$form_creator ->popArr['medicine_presc']=$dr_obj->getMedicine_presc('', $where);
				$form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);
				$form_creator ->popArr['past_history']=$dr_obj-> getPastHistory('', $where);	 
                $form_creator ->popArr['radiology_presc']=$dr_obj-> getRadiology_presc('', $where);
																				 
				$where_allery[0]="opno =".$op_no;
				$where_allery[1]="visit_id =".$op_vist_id;
				$where_allery[2]="status =0";  
				$form_creator ->popArr['allergicInfo']=$dr_obj->getPatient_allergies('', $where_allery);

				$where[0]="visit_id =".$op_vist_id;
				$where[1]="status = 0";  
				$form_creator ->popArr['referalInfo']=$referalInfo=$dr_obj->getDrReferalInfo('', $where);

				
			    $form_creator ->formPath ='/templates/doctor/current_op_details.php';			 
									break;

					              
                                 
			}
			
			$form_creator->display();
	
	}
	
       function save_case_sheet($post){
       
           $dr_obj=new Doctor();
           $db_obj=new DBFunction();
	  
       
           $opid=$post['opid'];
	   
	  //save presenting complaints 
	   $complaints=$post['pcomp_name'];
	   $duration=$post['pduration'];
	   
	 if(count($complaints) >0 ){  
	 
	   for($i=0;$i<count($complaints);$i++){
	   
	      $dr_obj->save_present_complaint($complaints[$i],$duration[$i],$post);
	   }
	  }
	  
	  //save provisional diagnosis
	  
	  
	   $diagnosis=$post['prov_diag_arr'];
	 
	   
	 if(count($diagnosis) >0 ){  
	 
	   for($i=0;$i<count($diagnosis);$i++){
	   
	      $dr_obj->save_provisional_diagnosis($diagnosis[$i],$post);
	   }
	  }
	  
	   //save procedure
	  
	  
	   $procedure_id=$post['pid'];
	 
	   
	 if(count($procedure_id) >0 ){  
	 
	   for($i=0;$i<count($procedure_id);$i++){
	   
	      $dr_obj->save_procedure_prescribed($procedure_id[$i],$post);
	   }
	  }
	  
	  //save labtest
	  
	 //  $labtest_id=$post['testid'];
	
	 // if(count($labtest_id) >0 ){  
	 
	 //   for($i=0;$i<count($labtest_id);$i++){
	   
	 //      $lid=explode("C", $labtest_id[$i]);
	      
	 //      $test_id=$lid[0];
	 //      $cid=$lid[1];
	 //      $dr_obj->save_labtest_prescribed($test_id,$cid,$post);
	 //   }
	 //  }

  	 $labtest_id=$post['testid'];
	
	 if(count($labtest_id) >0 ){  
	 
	   for($i=0;$i<count($labtest_id);$i++){

	   	  if ( strpos($labtest_id[$i],'LE') == true ) {
	   	  	$lid=explode("LE", $labtest_id[$i]);
	   	  	$type = "LE";
	   	  }
	   	  else{
	   	  	$lid=explode("LT", $labtest_id[$i]);
	   	  	$type = "LT";
	   	  }
	      
	      $test_id=$lid[0];
	      $cid=$lid[1];
	      $dr_obj->save_labtest_prescribed($test_id,$cid,$post,$type);
	   }
	  }

	  
	   //save medicines
	  
	  
	   $mid=$post['mid'];
	   $m_course=$post['m_course'];
	   $m_days=$post['m_days'];
	   $medicines_name=$post['medicines_name'];
	 
	   
	 if(count($mid) >0 ){ 
	 
	   for($i=0;$i<count($mid);$i++){
	   
	       if($mid[$i] == 0) $brand_name=$medicines_name[$i];
		   else $brand_name='';
	      $dr_obj->save_medicine_prescribed($mid[$i],$brand_name,$m_course[$i],$m_days[$i],$post);

	    	 $check_course[$i]=$db_obj->getidToValue("id","course", $m_course[$i],"hcare_medicine_course");

	    	 if (empty($check_course[$i])) {
	    	 	
	    	 	$dr_obj->save_medicine_courses($m_course[$i]);

	    	 }

	   		

	   }
	  }
	  
	  //save remarks, status and advice
	  $remarks=$post['remarks'];
	  $advice=$post['advice'];
	  $çons_status="";
	  $followup_date=date("Y-m-d",strtotime($post['followup_date']));
	  $examination=$post['examination'];
	  
	   $dr_obj->save_consultation_details($remarks,$çons_status,$followup_date,$opid,$advice,$examination);
	   


	  // save past history
	  $past_history=$post['past_history_arr'];
	
	 if(count($past_history) >0 ){  
	 
	   for($i=0;$i<count($past_history);$i++){
	   
	      $dr_obj->save_past_history($past_history[$i],$post);
	   }
	  }	   

	   
	   //save radiology
	  
	   $radiology_id=$post['rid'];
	 
	   
	 if(count($radiology_id) >0 ){  
	 
	   for($i=0;$i<count($radiology_id);$i++){
	   
	      $dr_obj->save_radiology_prescribed($radiology_id[$i],$post);
	   }
	  }


	   $post=array();
	   $post['id']=$opid;
	   $post['active_module']="patient_physical_exam";
          $this->viewPage('op_case_sheet',$post);
       }
       function delete_casesheet_items($post){
       
            $dr_obj=new Doctor();
            $from=$post['from'];
	    $id=$post['id'];


	   
	   switch($from){
	   
	      case 'presenting_complaints':
	                                     
	                                     $dr_obj->delete_presenting_complaint($id);
	                                    break;
	      case 'provisional_diagnosis':	                                    
	                                     $dr_obj->delete_prov_diagnosis($id);
	                                    break;
              case 'procedure_prescribed':	                                    
	                                     $dr_obj->delete_procedure_presc($id);
	                                    break;
	     case 'labtest_prescribed':	                                    
	                                     $dr_obj->delete_labtest_presc($id);
	                                    break;
	     case 'medicine_prescribed':	                                    
	                                     $dr_obj->delete_medicine_presc($id);
	                                    break;
	                                    
	     case 'past_history':	        $dr_obj->delete_past_history($id);
	                                    break;   
	     case 'radiology_prescribed':	                                    
	                                     $dr_obj->delete_radiology_presc($id);
	                                    break;
	             						                
	                                     


	   }
       }


      

       
       function setDrconsulted($post,$get){
       
          $dr_obj=new Doctor();
	  
         $dr_obj->setDrconsulted($post);
		 
		 if(isset($get['active_module']) && $get['active_module'] =="print_prescription"){
			 
			 $this->viewPage('print_prescription',$post);
		 }else{
	 
	       $this->viewPage('OPPatient_list',$post);
		 }
       }
       function resetDrconsulted($post){
       
          $dr_obj=new Doctor();
	  
         $dr_obj->resetDrconsulted($post);
	 
	 $this->viewPage('patient_history',$post);
       }
	   
	   function get_med_presc_json($post){
	   
	     $dr_obj=new Doctor();
	      $presc_id=$post['id'];
		  $where[]="id=".$presc_id;
		  $medicine_presc=$dr_obj->getMedicine_presc('', $where);
		  
		   $data=array();
		  $data['med_name']=$medicine_presc[0][4];
		  $data['med_id']=$medicine_presc[0][3];
		  $data['med_course']=$medicine_presc[0][5];
		  $data['med_days']=$medicine_presc[0][6];
		  header('Content-type: application/json');
		  echo json_encode($data);
		  exit;
	   }
	   
	   function save_physical_examination($post){
		   
		   $dr_obj=new Doctor();
	       $db_obj=new DBFunction();
       
           $opid=$post['opid'];
	       $field_name=array();
		   $field_value=array();
	       $k=0;
	       if(!empty($post['temp'])){
			   
			   $field_name[$k]="temp";
			   $field_value[$k]=$post['temp'];
			   
			   $k++;
		   }
		   if(!empty($post['pulse'])){
			   
			   $field_name[$k]="pulse";
			   $field_value[$k]=$post['pulse'];
			   
			   $k++;
		   }
		   if(!empty($post['bp'])){
			   
			   $field_name[$k]="bp";
			   $field_value[$k]=$post['bp'];
			   
			   $k++;
		   }
		    if(!empty($post['height'])){
			   
			   $field_name[$k]="height";
			   $field_value[$k]=$post['height'];
			   
			   $k++;
		   }
		    if(!empty($post['weight'])){
			   
			   $field_name[$k]="weight";
			   $field_value[$k]=$post['weight'];
			   
			   $k++;
		   }
		    if(!empty($post['bmi'])){
			   
			   $field_name[$k]="bmi";
			   $field_value[$k]=$post['bmi'];
			   
			   $k++;
		   }
		    if(!empty($post['resp'])){
			   
			   $field_name[$k]="resp";
			   $field_value[$k]=$post['resp'];
			   
			   $k++;
		   }
		    if(!empty($post['oxygen_satu'])){
			   
			   $field_name[$k]="oxygen_satu";
			   $field_value[$k]=$post['oxygen_satu'];
			   
			   $k++;
		   }
		   if(!empty($post['gen_condn'])){
			   
			   $field_name[$k]="gen_condn";
			   $field_value[$k]=$post['gen_condn'];
			   
			   $k++;
		   }
		   if(!empty($field_name)){
			   
			     $field_name[$k]="opno";
			     $field_value[$k]=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			   
			   $field_name[$k]="visit_id";
			   $field_value[$k]=$opid;
			   $k++;
			   
			   $field_name[$k]="patient_type";
			   $field_value[$k]=$post['patient_type'];
			   
			   if(!empty($post['phid'])){
				   $dr_obj->update_physical_examination($field_name,$field_value,$post['phid']);
			   }else{
		          $dr_obj->save_physical_examination($field_name,$field_value);
			   }
		   }
		   
		    $post=array();
	        $post['id']=$opid;
	        $post['active_module']="patient_physical_exam";
          $this->viewPage('op_case_sheet',$post);
	   }
	   
	   function add_patient_allergy($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  
		  $allergyInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $allergyInfo['visit_id']=$opid;
		  $allergyInfo['allergic_to']=$post['allergic_to'];
		  $allergyInfo['description']=$post['description'];
	  
           $dr_obj->add_patient_allergy($allergyInfo);
	 
	        $post=array();
	        $post['id']=$opid;
	        $post['active_module']="patient_allergies";
         
	       $this->viewPage('op_case_sheet',$post);
       }
	   
	    function delete_patient_allergy($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['id'];
			$dr_obj->delete_patient_allergy($id);
	                                
		}

		function add_patient_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		  $opid=$post['opid'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $documentInfo['visit_id']=$opid;
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;




		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx', 'dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";


                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800 ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('op_case_sheet',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="patient_documents";
					       		$this->viewPage('op_case_sheet',$post); 
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
	       				$this->viewPage('op_case_sheet',$post);  




		  }

	}

function delete_patient_document($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['hidden_remove'];

	        $dr_obj->delete_patient_document($id);

	        $post['active_module']="patient_documents";
	       	
	       	$this->viewPage('op_case_sheet',$post);  

	                                
}

function save_diabetic_status($post){
       
            $dr_obj=new Doctor();
			 $db_obj=new DBFunction();
           
	        $opid=$post['opid'];
			
			if(isset($post['is_diabetic'])) $is_diabetic="YES";
			else $is_diabetic="NO";
			
			$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			
			$wherecondn[0]="opno=".$opno;
			
			$diabetic_status=$dr_obj->get_diabetic_status('',$wherecondn);

			if(!empty($diabetic_status)){
				
				 $dr_obj->update_diabetic_status($opno,$is_diabetic);
				 
			}else{
	          $dr_obj->save_diabetic_status($opno,$is_diabetic);
            }

	        $post['active_module']=$post['current_module'];
	       	
	       	$this->viewPage('op_case_sheet',$post);  

	                                
}

function save_hyper_tension_status($post){


       
            $dr_obj=new Doctor();
			 $db_obj=new DBFunction();
           
	        $opid=$post['opid'];
			
			if(isset($post['is_hyper_ten'])) $is_hyper_ten="YES";
			else $is_hyper_ten="NO";
			
			$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			
			$wherecondn[0]="opno=".$opno;
			
			$hyper_tension_status=$dr_obj->get_hyper_tesion_status('',$wherecondn);

			if(!empty($hyper_tension_status)){
				
				 $dr_obj->update_hyper_tension_statuss($opno,$is_hyper_ten);
				 
			}else{
	          $dr_obj->save_hyper_tension_status($opno,$is_hyper_ten);
            }

	        $post['active_module']=$post['current_module'];
	       	
	       	$this->viewPage('op_case_sheet',$post);  

	                                
}

function add_diabetic_reading($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  
		  $readingInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $readingInfo['visit_id']=$opid;
		  $readingInfo['sugar_level']=$post['sugar_level'];
		  $readingInfo['reading_type']=$post['reading_type'];
		  $readingInfo['reading_date']=date("Y-m-d H:i:s",strtotime($post['reading_date']));
	  
           $dr_obj->add_diabetic_reading($readingInfo);
	 
	        $post=array();
	        $post['id']=$opid;
	        $post['active_module']="diabetic_analysis";
         
	       $this->viewPage('op_case_sheet',$post);
       }

function delete_diabetic_reading($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['id'];
			$dr_obj->delete_diabetic_reading($id);
	                                
		}




function addReferalInfo($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  
		  $referalInfo['visit_id']=$opid;
		  $referalInfo['date']=date("Y-m-d H:i:s");
		  $referalInfo['refering_doc']=$post['refering_doc'];
		  $referalInfo['refered_doc']=$post['refered_doc'];
		  $referalInfo['remarks']=$post['remarks'];
		  $referalInfo['ref_type']=$post['ref_type'];
	  
          $dr_obj->add_referal_info($referalInfo);
	 
	        $post=array();
	        $post['id']=$opid;
	        $post['active_module']="refer_doctor";
         
	       $this->viewPage('op_case_sheet',$post);

}
function delete_referal_info($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['hidden_remove'];

	        $dr_obj->delete_referal_info($id);

	        $post['active_module']="refer_doctor";
	       	
	       	$this->viewPage('op_case_sheet',$post);

	                                
}
 

 //=========================================================================================================================
//                                   inpatient emr
//==========================================================================================================================



       function save_ip_case_sheet($post){
    
           $dr_obj=new Doctor();
           $db_obj=new DBFunction();
	  
     
           $opid=$post['opid'];
	   
	  //save presenting complaints 
	   $complaints=$post['pcomp_name'];
	   $duration=$post['pduration'];
	   
	 if(count($complaints) >0 ){  
	 
	   for($i=0;$i<count($complaints);$i++){
	   
	      $dr_obj->save_ip_present_complaint($complaints[$i],$duration[$i],$post);
	   }
	  }
	  
	  //save provisional diagnosis
	  
	  
	   $diagnosis=$post['prov_diag_arr'];
	 
	   
	 if(count($diagnosis) >0 ){  
	 
	   for($i=0;$i<count($diagnosis);$i++){
	   
	      $dr_obj->save_ip_provisional_diagnosis($diagnosis[$i],$post);
	   }
	  }
	  
	   //save procedure
	  
	  
	   $procedure_id=$post['pid'];
	 
	   
	 if(count($procedure_id) >0 ){  
	 
	   for($i=0;$i<count($procedure_id);$i++){
	   
	      $dr_obj->save_ip_procedure_prescribed($procedure_id[$i],$post);
	   }
	  }
	  
	  //save labtest
	  
	  $labtest_id=$post['testid'];
	  // var_dump($labtest_id);
	
	 if(count($labtest_id) >0 ){  
	 
	   for($i=0;$i<count($labtest_id);$i++){
	   
	      // $lid=explode("C", $labtest_id[$i]);
	      
	      // $test_id=$lid[0];
	      // $cid=$lid[1];
	      // $dr_obj->save_ip_labtest_prescribed($test_id,$cid,$post);
	   	if ( strpos($labtest_id[$i],'LE') == true ) {
	   	  	$lid=explode("LE", $labtest_id[$i]);
	   	  	$type = "LE";
	   	  }
	   	  else{
	   	  	$lid=explode("LT", $labtest_id[$i]);
	   	  	$type = "LT";
	   	  }

	      
	      $test_id=$lid[0];
	      $cid=$lid[1];
	      $dr_obj->save_ip_labtest_prescribed($test_id,$cid,$post,$type);
	   }
	  }
	  
	   //save medicines
	  
	  
	   $mid=$post['mid'];
	   $m_course=$post['m_course'];
	   $m_days=$post['m_days'];
	   $medicines_name=$post['medicines_name'];
	 
	   
	 if(count($mid) >0 ){ 
	 
	   for($i=0;$i<count($mid);$i++){
	   
	       if($mid[$i] == 0) $brand_name=$medicines_name[$i];
		   else $brand_name='';
	      $dr_obj->save_ip_medicine_prescribed($mid[$i],$brand_name,$m_course[$i],$m_days[$i],$post);

	    	 $check_course[$i]=$db_obj->getidToValue("id","course", $m_course[$i],"hcare_medicine_course");

	    	 if (empty($check_course[$i])) {
	    	 	
	    	 	$dr_obj->save_ip_medicine_courses($m_course[$i]);

	    	 }

	   		

	   }
	  }
	  
	  //save remarks, status and advice
	  $remarks=$post['remarks'];
	  $advice=$post['advice'];
	  $çons_status="";
	  $followup_date=date("Y-m-d",strtotime($post['followup_date']));
       
       $whre[0]="ipno='".$post['ipno']."'";
       // $whre[1]="entered_by='".$_SESSION['user_id']."'";
       $whre[1]="status= 0";


	 $ip_details=  $dr_obj->get_ip_consultation_details('',$whre);

	 if(!empty($ip_details)){
            // var_dump($ip_details);
	 	  $dr_obj->update_ip_consultation_details($post,$ip_details[0][0]);
	 }else{

	 	 $dr_obj->save_ip_consultation_details($post);
	 }
	  
	  
	   


	  // save past history
	  $past_history=$post['past_history_arr'];
	
	 if(count($past_history) >0 ){  
	 
	   for($i=0;$i<count($past_history);$i++){
	   
	      $dr_obj->save_ip_past_history($past_history[$i],$post);
	   }
	  }	   

	   
	   //save radiology
	  
	   $radiology_id=$post['rid'];
	 
	   
	 if(count($radiology_id) >0 ){  
	 
	   for($i=0;$i<count($radiology_id);$i++){
	   
	      $dr_obj->save_ip_radiology_prescribed($radiology_id[$i],$post);
	   }
	  }
       
       $ip_no = $post['ipno'];
       
	   $post=array();
	   $post['id']=$opid;
	   $post['ipno']=$ip_no;
	   $post['active_module']="ip_patient_physical_exam";
          $this->viewPage('ip_case_sheet',$post);
       }
       function delete_ip_casesheet_items($post){
       
            $dr_obj=new Doctor();
            $from=$post['from'];
	    $id=$post['id'];


	   
	   switch($from){
	   
	      case 'ip_presenting_complaints':
	                                     
	                                     $dr_obj->delete_ip_presenting_complaint($id);
	                                    break;
	      case 'ip_provisional_diagnosis':	                                    
	                                     $dr_obj->delete_ip_prov_diagnosis($id);
	                                    break;
              case 'ip_procedure_prescribed':	                                    
	                                     $dr_obj->delete_ip_procedure_presc($id);
	                                    break;
	     case 'ip_labtest_prescribed':	                                    
	                                     $dr_obj->delete_ip_labtest_presc($id);
	                                    break;
	     case 'ip_medicine_prescribed':	                                    
	                                     $dr_obj->delete_ip_medicine_presc($id);
	                                    break;
	                                    
	     case 'ip_past_history':	        $dr_obj->delete_ip_past_history($id);
	                                    break;   
	     case 'ip_radiology_prescribed':	                                    
	                                     $dr_obj->delete_ip_radiology_presc($id);
	                                    break;
	             						                
	                                     


	   }
       }


       
  //      function setDrconsulted($post,$get){
       
  //         $dr_obj=new Doctor();
	  
  //        $dr_obj->setDrconsulted($post);
		 
		//  if(isset($get['active_module']) && $get['active_module'] =="print_prescription"){
			 
		// 	 $this->viewPage('print_prescription',$post);
		//  }else{
	 
	 //       $this->viewPage('OPPatient_list',$post);
		//  }
  //      }
  //      function resetDrconsulted($post){
       
  //         $dr_obj=new Doctor();
	  
  //        $dr_obj->resetDrconsulted($post);
	 
	 // $this->viewPage('patient_history',$post);
  //      }
	   
	   function get_ip_med_presc_json($post){
	   
	     $dr_obj=new Doctor();
	      $presc_id=$post['id'];
		  $where[]="id=".$presc_id;
		  $medicine_presc=$dr_obj->get_ip_Medicine_presc('', $where);
		  
		   $data=array();
		  $data['med_name']=$medicine_presc[0][4];
		  $data['med_id']=$medicine_presc[0][3];
		  $data['med_course']=$medicine_presc[0][5];
		  $data['med_days']=$medicine_presc[0][6];
		  header('Content-type: application/json');
		  echo json_encode($data);
		  exit;
	   }
	   
	   function save_ip_physical_examination($post){
		   
		   $dr_obj=new Doctor();
	       $db_obj=new DBFunction();
       
           $opid=$post['opid'];
	       $field_name=array();
		   $field_value=array();
	       $k=0;
	       if(!empty($post['temp'])){
			   
			   $field_name[$k]="temp";
			   $field_value[$k]=$post['temp'];
			   
			   $k++;
		   }
		   if(!empty($post['pulse'])){
			   
			   $field_name[$k]="pulse";
			   $field_value[$k]=$post['pulse'];
			   
			   $k++;
		   }
		   if(!empty($post['bp'])){
			   
			   $field_name[$k]="bp";
			   $field_value[$k]=$post['bp'];
			   
			   $k++;
		   }
		    if(!empty($post['height'])){
			   
			   $field_name[$k]="height";
			   $field_value[$k]=$post['height'];
			   
			   $k++;
		   }
		    if(!empty($post['weight'])){
			   
			   $field_name[$k]="weight";
			   $field_value[$k]=$post['weight'];
			   
			   $k++;
		   }
		    if(!empty($post['bmi'])){
			   
			   $field_name[$k]="bmi";
			   $field_value[$k]=$post['bmi'];
			   
			   $k++;
		   }
		    if(!empty($post['resp'])){
			   
			   $field_name[$k]="resp";
			   $field_value[$k]=$post['resp'];
			   
			   $k++;
		   }
		    if(!empty($post['oxygen_satu'])){
			   
			   $field_name[$k]="oxygen_satu";
			   $field_value[$k]=$post['oxygen_satu'];
			   
			   $k++;
		   }
		   if(!empty($post['gen_condn'])){
			   
			   $field_name[$k]="gen_condn";
			   $field_value[$k]=$post['gen_condn'];
			   
			   $k++;
		   }
		   if(!empty($field_name)){
			   
			     $field_name[$k]="opno";
			     $field_value[$k]=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			    $k++;
			   $field_name[$k]="visit_id";
			   $field_value[$k]=$opid;
			   $k++;
			    if(!empty($post['patient_type'])){
			   $field_name[$k]="patient_type";
			   $field_value[$k]=$post['patient_type'];
               $k++;
               }

           if(!empty($post['ipno'])){
			   $field_name[$k]="ipno";
			   $field_value[$k]=$post['ipno'];

               $k++;

	               if(empty($post['phid'])){

					   $field_name[$k]="id";
					   $field_value[$k]="";
					   $k++;

	               }

			}


			   if(!empty($post['phid'])){
				   $dr_obj->update_ip_physical_examination($field_name,$field_value,$post['phid']);
			   }else{

			   $field_name[$k]="date_time";
			   $field_value[$k]=date("Y-m-d H:i:s");

               $k++;
               $field_name[$k]="entered_by";
			   $field_value[$k]=$_SESSION['user_id'];

               $k++;
		          $dr_obj->save_ip_physical_examination($field_name,$field_value);
			   }
		   }

		    $ip_no = $post['ipno'];
		   
		    $post=array();
	        $post['id']=$opid;
	        $post['ipno']=$ip_no;
	        $post['active_module']="ip_patient_physical_exam";
          $this->viewPage('ip_case_sheet',$post);
	   }
	   
	   function add_ip_patient_allergy($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  
		  $allergyInfo['opno']=$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $allergyInfo['visit_id']=$opid;
		  $allergyInfo['allergic_to']=$post['allergic_to'];
		  $allergyInfo['description']=$post['description'];
		  $allergyInfo['ipno']=$post['ipno'];
		  // $ipno=$db_obj->getidToValue("id","opno", $opid,"hcare_ip_info");
		  // $allergyInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $ipno,"hcare_ip_info");
	  	 $allergyInfo['ref_ipno']=0;
           $dr_obj->add_ip_patient_allergy($allergyInfo);

            $ip_no = $post['ipno'];
	 
	        $post=array();
	        $post['id']=$opid;
	        $post['ipno']=$ip_no;
	        $post['active_module']="ip_patient_allergies";
         
	       $this->viewPage('ip_case_sheet',$post);
       }
	   
	    function delete_ip_patient_allergy($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['id'];
			$dr_obj->delete_ip_patient_allergy($id);
	                                
		}

		function add_ip_patient_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		  $opid=$post['opid'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $documentInfo['visit_id']=$opid;
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;

		  $documentInfo['ipno']=$post['ipno'];

          $documentInfo['cust_type']=$post['patient_type'];
         // $documentInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $post['ipno'],"hcare_ip_info");;
          $postArr['ref_no'] = 0;





		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx', 'dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);

		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";


                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800 ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('op_case_sheet',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="ip_patient_documents";
					       		$this->viewPage('ip_case_sheet',$post); 
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
                        $ip_no = $documentInfo['ipno'];
                       
						$dr_obj->add_ip_patient_document($documentInfo);
	        			$post=array();
	        			$post['id']=$opid;
	        			$post['ipno']=$ip_no;
	        			$post['active_module']="ip_patient_documents";
	       				$this->viewPage('ip_case_sheet',$post);  




		  }

	}

function delete_ip_patient_document($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['hidden_remove'];

	        $dr_obj->delete_ip_patient_document($id);

	        $post['active_module']="ip_patient_documents";
	       	
	       	$this->viewPage('ip_case_sheet',$post);  

	                                
}


		function add_ip_patient_xray_document($post){

		  $dr_obj=new Doctor();
		  $db_obj=new DBFunction();	

		  $opid=$post['opid'];
		  $file_name = $_FILES['document']['name'];
		  $remark = $post['remark'];
		  $documentInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $documentInfo['visit_id']=$opid;
		  $documentInfo['document_name']=$file_name;
		  $documentInfo['remarks']=$remark;

		  $documentInfo['ipno']=$post['ipno'];

          $documentInfo['cust_type']=$post['patient_type'];
        //  $documentInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $post['ipno'],"hcare_ip_info");;

          $postArr['ref_no'] = 0;




		  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx', 'dcm');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);

		  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";


                

          //FILE SIZE AND TYPE CHECKING      
		  if( $_FILES['document']['size'] > 52428800 ) {



					  		// if (!in_array($ext,$allowed)) {
					  					  		
						  		
						  	// 	$post['active_module']="patient_documents";
					    //    		$this->viewPage('op_case_sheet',$post); 
					    //    		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

					  		// }
					  		// else{			  				

						  		
						  		$post['active_module']="ip_patient_xray_documents";
					       		$this->viewPage('ip_case_sheet',$post); 
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
                        $ip_no = $post['ipno'];

						$dr_obj->add_ip_patient_xray_document($documentInfo);
	        			$post=array();
	        			$post['id']=$opid;
	        			$post['ipno']=$ip_no;
	        			$post['active_module']="ip_patient_xray_documents";
	       				$this->viewPage('ip_case_sheet',$post);  




		  }

	}

function delete_ip_patient_xray_document($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['hidden_remove'];

	        $dr_obj->delete_ip_patient_xray_document($id);

	        $post['active_module']="ip_patient_xray_documents";
	       	
	       	$this->viewPage('ip_case_sheet',$post);  

	                                
}

function save_ip_diabetic_status($post){
       
            $dr_obj=new Doctor();
			$db_obj=new DBFunction();
           
	        $opid=$post['opid'];
			
			if(isset($post['is_diabetic'])) $is_diabetic="YES";
			else $is_diabetic="NO";
			
			$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			
			$wherecondn[0]="opno=".$opno;
			
			$diabetic_status=$dr_obj->get_ip_diabetic_status('',$wherecondn);

			if(!empty($diabetic_status)){
				
				 $dr_obj->update_ip_diabetic_status($opno,$is_diabetic);
				 
			}else{
	          $dr_obj->save_ip_diabetic_status($opno,$is_diabetic);
            }

	        $post['active_module']=$post['current_module'];
	       	
	       	$this->viewPage('ip_case_sheet',$post);  

	                                
}

function save_ip_hyper_tension_status($post){


       
            $dr_obj=new Doctor();
			 $db_obj=new DBFunction();
           
	        $opid=$post['opid'];
			// var_dump($post);
			if(isset($post['is_hyper_ten'])) $is_hyper_ten="YES";
			else $is_hyper_ten="NO";
			
			$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
			
			$wherecondn[0]="opno=".$opno;
			
			$hyper_tension_status=$dr_obj->get_ip_hyper_tesion_status('',$wherecondn);

			if(!empty($hyper_tension_status)){
				
				 $dr_obj->update_ip_hyper_tension_statuss($opno,$is_hyper_ten);
				 
			}else{
	          $dr_obj->save_ip_hyper_tension_status($opno,$is_hyper_ten);
            }

	        $post['active_module']=$post['current_module'];
	       	
	       	$this->viewPage('ip_case_sheet',$post);  

	                                
}

function add_ip_diabetic_reading($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  
		  $readingInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $readingInfo['visit_id']=$opid;
		  $readingInfo['sugar_level']=$post['sugar_level'];
		  $readingInfo['reading_type']=$post['reading_type'];
		  $readingInfo['reading_date']=date("Y-m-d H:i:s ",strtotime($post['reading_date']));
	      $readingInfo['ipno']=$ipno=$post['ipno'];
	    //  $readingInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $ipno,"hcare_ip_info");
	      $postArr['ref_no'] = 0;
           $dr_obj->add_ip_diabetic_reading($readingInfo);

            $ip_no = $post['ipno'];
	 
	        $post=array();
	        $post['id']=$opid;
	        $post['ipno']=$ip_no;
	        $post['active_module']="ip_diabetic_analysis";
         
	       $this->viewPage('ip_case_sheet',$post);
       }

function delete_ip_diabetic_reading($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['id'];
			$dr_obj->delete_ip_diabetic_reading($id);
	                                
		}

	   function add_ip_ot_note($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  $otInfo['patient_type']="IP";
		  
		  $otInfo['opno']=$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  // $otInfo['visit_id']=$opno;

		  $otInfo['visit_id']=$opid;

		  $otInfo['ot_note']=$post['ot_note'];
		  $otInfo['ipno']=$ipno=$db_obj->getidToValue("id","opno", $opno,"hcare_ip_info");
		  //$otInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $ipno,"hcare_ip_info");
 	
		  $otInfo['ipno']=$post['ipno'];
          $ip_no = $post['ipno'];

          $dr_obj->save_ip_ot_note($otInfo);

          $post=array();
          $post['id']=$opid;
          $post['ipno']=$ip_no;
          $post['active_module']="ip_ot_note";
         
	       $this->viewPage('ip_case_sheet',$post);
       }
	   
	    function delete_ip_ot_note($post){
       
            $dr_obj=new Doctor();
           
	        $id=$post['id'];
			$dr_obj->delete_ip_ot_note($id);
	                                
		}
       function edit_ip_ot_note($post){


            $dr_obj=new Doctor();
           
	        $id=$post['id'];

	      $dr_obj=new Doctor();
		  $db_obj=new DBFunction();
		  
		  $opid=$post['opid'];
		  $otInfo['patient_type']="IP";
		  
		  $otInfo['opno']=$opno=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $otInfo['visit_id']=$opno;
		
		  $otInfo['ot_note_update']=$post['ot_note_update'];
		  $otInfo['ipno']=$ipno=$db_obj->getidToValue("id","opno", $opno,"hcare_ip_info");
		//  $otInfo['ref_ipno']=$db_obj->getidToValue("ipno","id", $ipno,"hcare_ip_info");
          $postArr['ref_no'] = 0;
			$dr_obj->edit_ip_ot_note($post);
            
            $ip_no = $post['ipno'];

			$post=array();
	        $post['id']=$opid;
	        $post['ipno']=$ip_no;
	        $post['active_module']="ip_ot_note";
         
	       $this->viewPage('ip_case_sheet',$post);
	                                
		}
	   function save_covid_status($post){
       
          $dr_obj=new Doctor();
		  $db_obj=new DBFunction();


		  
		  $opid=$post['opid'];

		  $covidInfo['patient_type']=$post['patient_type'];
		  
		  $covidInfo['opno']=$db_obj->getidToValue("opno","id", $opid,"hcare_op_visit_info");
		  $covidInfo['visit_id']=$opid;

		  if (!empty($post['travel_abroad_yes'])) {
		  	$covidInfo['travel_abroad'] = $post['travel_abroad_yes'];
		  }

		  if (!empty($post['travel_abroad_no'])) {
		  	$covidInfo['travel_abroad'] = $post['travel_abroad_no'];
		  }

		  if (!empty($post['travel_contact_yes'])) {
		  	$covidInfo['travel_contact'] = $post['travel_contact_yes'];
		  }

		  if (!empty($post['travel_contact_no'])) {
		  	$covidInfo['travel_contact'] = $post['travel_contact_no'];
		  }

		  if (!empty($post['contact_patient_yes'])) {
		  	$covidInfo['contact_patient'] = $post['contact_patient_yes'];
		  }

		  if (!empty($post['contact_patient_no'])) {
		  	$covidInfo['contact_patient'] = $post['contact_patient_no'];
		  }

		  if (!empty($post['contact_suspect_yes'])) {
		  	$covidInfo['contact_suspect'] = $post['contact_suspect_yes'];
		  }

		  if (!empty($post['contact_suspect_no'])) {
		  	$covidInfo['contact_suspect'] = $post['contact_suspect_no'];
		  }

		  if (!empty($post['covid_syptoms_yes'])) {
		  	$covidInfo['covid_syptoms'] = $post['covid_syptoms_yes'];
		  }

		  if (!empty($post['covid_syptoms_no'])) {
		  	$covidInfo['covid_syptoms'] = $post['covid_syptoms_no'];
		  }

		  $covidInfo['covid_19_symptoms'] = $post['covid_19_symptoms'];

          // $dr_obj->add_covid_status($covidInfo);

          // var_dump($covidInfo);exit();

		  if(!empty($post['covid_id'])){
			$dr_obj->update_covid_status($covidInfo,$post['covid_id']);
		  }else{
		    $dr_obj->add_covid_status($covidInfo);
		  }

	 
	      $post=array();
	      $post['id']=$opid;
	      $post['active_module']="covid_status";
         
	      $this->viewPage('op_case_sheet',$post);



       }

}

?>
