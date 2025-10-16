<?php //session_start();
require_once ROOT_PATH . '/lib/model/room/room.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/pagination.php';

class IpController {

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
				
				case 'OP_Search'	   : 
													$com_obj = new CommonFunctions();
													$reg_obj= new Registration();
													$emp_obj= new Employee();
													
													if(!empty($postArr["opno"])){
														$selectCondition[]="a.`id`='".$postArr["opno"]."'";
														$selectCondition[]="b.`visit_date` like '".date("Y-m-d")."%'";
													}else{
													if(!empty($postArr["date"])){
														$selectCondition[]="b.`visit_date` like '".date("Y-m-d",strtotime($postArr["date"]))."%'";
													}else $selectCondition[]="b.`visit_date` like '".date("Y-m-d")."%'";												
													
													}
													if(!empty($postArr["name"])){
														$selectCondition[]="a.`first_name` like '%".$postArr["name"]."%'";
													}
													if(!empty($postArr["mname"])){
														$selectCondition[]="a.`middle_name` like '%".$postArr["mname"]."%'";
													}
													if(!empty($postArr["lname"])){
														$selectCondition[]="a.`last_name` like '%".$postArr["lname"]."%'";
													}
													if(!empty($postArr["place"])){
														$selectCondition[]="a.`place` LIKE '%".$postArr["place"]."%'";
													}
													
													if(!empty($postArr["telNo"])){
														$selectCondition[]="a.`contact_no`='".$postArr["telNo"]."'";
													}
													if(!empty($postArr["doctor"])){
														$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
													}
													
													$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc','','opno');
													
													$is_field[0]="a.title='Dr'";													
													$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
													
													$form_creator ->formPath ='/templates/inpatient/op_search.php';
													break;
					case 'Admission_Form'			:												
													
													//create objects
													$db_obj=new DBFunction();
													$emp_obj=new Employee();
													$dep_obj=new Department();
													$room_obj= new Room();
                                                    $ip_obj= new Inpatient();	
													$form_creator ->popArr['observation']=$postArr['observation'];
													//check ip patient updation or ip patiet admission
													if(isset($postArr['paction']) && $postArr['paction'] == "EDIT_PAGE"){
												
													     $ipno=$postArr['id'];													
													     $postArr=$this->processIP($ipno);
													    $action = "UPDATE";

                                                                                                           //room history informations

													  $where[]= "ipno = ".$ipno;
                                                      $form_creator ->popArr['roomhist'] = $ip_obj->getRoomhistory('',$where);
													}else{
													
													   //get op details
													   $opid=$postArr['id'];													
													   $postArr=$this->processOP($opid);
													
													   //set action										
													
													        $action = "SAVE";
													}
												
													
											//set form element values
													$is_field[0]="a.title='Dr'";												
													$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->popArr['departments']=$dep_obj->getDepartment();
													$form_creator ->popArr['countries']=$db_obj->getCountries();
													
													
													$form_creator ->popArr['roomInfo']=$this->getFreeRooms();
													$form_creator ->popArr['action']=$action;
												
											//set the page	
													$form_creator ->formPath ='/templates/inpatient/admission_form.php';
													break;


					case 'Observation_add_up_del'			:												
													
													//create objects
													$db_obj=new DBFunction();
													$emp_obj=new Employee();
													$dep_obj=new Department();
													$room_obj= new Room();
                                                    $ip_obj= new Inpatient();	
													
													
													   $opid=$postArr['id'];
													
													   //set action										
													
													        $action = "SAVE";
													//}
												
													
													
													
													
													
											//set form element values
													
													$form_creator ->popArr['roomInfo']=$this->getFreeRooms();
													$form_creator ->popArr['action']=$action;
													$form_creator ->popArr['opid']=$opid;
													$form_creator ->popArr['post']=$postArr;


														$form_creator ->popArr['observation_status']=$postArr['observation_status'];
														$form_creator ->formPath ='/templates/inpatient/admission_observation.php';						break;


					case 'manageInpatient' : 
					                           $emp_obj= new Employee();
											   $room_obj= new Room();
											   $com_obj = new CommonFunctions();
											   $ip_obj= new Inpatient();
											   $pagi_obj = new Pagination();
											   
											   //search criterias
											   if(isset($postArr['from_date']) && $postArr['paction']!="CLEAR"){
											   
															$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
															$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
															
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
																$selectCondition[]="a.`place` LIKE '%".$postArr["place"]."%'";
															}
															if(!empty($postArr["doctor"])){
																$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
															}
															if(!empty($postArr["room_no"])){
																$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
															}
											   }else{
															$fromdate=$com_obj->getcurrentDate();
															$todate=$com_obj->getcurrentDate();
												}
												
												//$selectCondition[]="b.`admission_date`>='".$fromdate."'";
												//$selectCondition[]="b.`admission_date`<='".$todate."'";       
                                                                                                $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";                                                                            

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

                                                $patient_count=$ip_obj->getIPPatientCount($selectCondition,'b.admission_date','asc');
											/*...............pagination..............*/		

												$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc',$limit);

												$form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patient_count,$current_page,$perPage);

												$form_creator ->popArr['current_page']=$current_page;
												
												if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
												}else $form_creator ->popArr['post']='';
											  
											  $is_field[0]="a.title='Dr'";													
											  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											  
											 // $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails();
					                                                  $form_creator ->formPath ='/templates/inpatient/manage_ip_patient.php';
													break;

                                        case 'Discharged_patients' :

                                                                      $com_obj = new CommonFunctions();
                                                                      $emp_obj= new Employee();
                                                                      $bill_obj= new Billing();
                                                                       $ip_obj= new Inpatient();
//search criterias
									if(isset($postArr['from_date']) && $postArr['paction']!="CLEAR"){
											   
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
															
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
											$selectCondition[]="a.`place` LIKE '%".$postArr["place"]."%'";
										}
										if(!empty($postArr["doctor"])){
											$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
										}
										if(!empty($postArr["room_no"])){
											$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
										}
									}else{
											$fromdate=$com_obj->getcurrentDate();
											$todate=$com_obj->getcurrentDate();
									}

                                                                       $selectCondition[]="b.`discharge_date`>='".$fromdate."'";
								       $selectCondition[]="b.`discharge_date`<='".$todate."'";       

                                                                      $selectCondition[]="(b.`discharge_date`!='0000-00-00' OR b.`discharge_date` is NOT NULL)";
								      $selectCondition[]="b.`cancelled`=0";
								      $patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                
                                                                       
                                                                      $bill_details=array();

                                                                       if(!empty($patientInfo)){
                                                                          for($i=0;$i<count($patientInfo);$i++){
                                                                               
                                                                               $ipno=$patientInfo[$i][13];

                                                                                $condition[0]="ipno ='".$ipno."'";

                                                                                $billInfo=$bill_obj->getIPBillInfo($condition);

                                                                                if(!empty($billInfo)){
                                                                                       for($j=0;$j<count($billInfo);$j++){
                                                                                          
                                                                                          $billno=$billInfo[$j][0];
                                                                                          $total_amount=$billInfo[$j][4];

                                                                                            $bill_details[$i][0]=$billno;
                                                                                            $bill_details[$i][1]=$total_amount;
                                                                                      }
                                                                                }
                                                                          }
     

                                                                       }
                                                                         $is_field[0]="a.title='Dr'";                                                  													
									$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											  
									$form_creator ->popArr['patientInfo']=$patientInfo;

									$form_creator ->popArr['post']=$postArr;

                                                                        $form_creator ->popArr['billInfo']=$bill_details;
					                                $form_creator ->formPath ='/templates/inpatient/discharge_patient_list.php';
													break;
                                                                                   


                                case 'create_template' :

                                		$form_creator ->popArr['postArr']=$postArr;

                                	  	$form_creator ->formPath ='/templates/inpatient/create_template.php';

                                	  break;


								case 'manage_templates' :

										$ip_obj= new Inpatient();

										$k=0;

                                		if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){

											$wheredata[$k]="template_name like '%".$postArr['temp_name']."%'";
											$k++;
                                			
                                		}

                                		$wheredata[] = "status = 0";

                                		$form_creator ->popArr['templates'] = $templates = $ip_obj->getTemplates($wheredata);

                                		$form_creator ->popArr['postArr'] = $postArr;

                                	  	$form_creator ->formPath ='/templates/inpatient/manage_templates.php';

                                	  break;

                                case 'edit_template' :

                                	  $ip_obj= new Inpatient();

									  if(isset($postArr['action']) && ($postArr['action']=="EDIT_PAGE")){

										   $wheredata[] = "id = ".$postArr['id'];
										   $wheredata[] = "status = 0";
										   $form_creator ->popArr['templates'] = $templates = $ip_obj->getTemplates($wheredata);

										if (!empty($templates)) {

	                                		$select[] = "temp_id = ".$templates[0][0];
                                			$select[] = "status = 0";
                                			$form_creator ->popArr['template_selected_items'] = $template_selected_items = $ip_obj->getTemplateItems($select);	


                                			// Check if Discharge advice is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'DISCHARGE_ADVICE'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['discharge_advice'] = $discharge_advice = $ip_obj->getTemplateItems($where);

                                			// Check if Diet is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'DIET'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['diet'] = $diet = $ip_obj->getTemplateItems($where);

                                			// Check if Diet is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'FOLLOW_UP'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['follow_up'] = $follow_up = $ip_obj->getTemplateItems($where);

                                			// Check if Remarks is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'REMARKS'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['remarks'] = $remarks = $ip_obj->getTemplateItems($where);

                                			// Check if Investigation is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'INVESTIGATION'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['investigation'] = $investigation = $ip_obj->getTemplateItems($where);

                                			// Check if Lab reports is present
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'LAB_REPORTS'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['lab_reports'] = $lab_reports = $ip_obj->getTemplateItems($where);

                                			// Check if cunsultation details is checked
	                                		$where[0] = "temp_id = ".$templates[0][0];
	                                		$where[1] = "field_type = 'CONSULTATION_DETAILS'";
                                			$where[2] = "status = 0";
                                			$form_creator ->popArr['consultation_details'] = $consultation_details = $ip_obj->getTemplateItems($where);


             
										}								


									}


                                	$form_creator ->popArr['postArr']=$postArr;

                                	$form_creator ->formPath ='/templates/inpatient/create_template.php';

                                	  break;


                                case 'discharge_summary_templates' :


                                		$ip_obj= new Inpatient();

                                		$where[] = "status = 0";

                                		$form_creator ->popArr['templates'] = $templates = $ip_obj->getTemplates($where);

                                		$form_creator ->popArr['postArr']=$postArr;

                                	  	$form_creator ->formPath ='/templates/inpatient/discharge_summary_templates.php';

                                	  break;

                            	case 'discharge_summary' :


                            		$ip_obj= new Inpatient();
                            		$dr_obj= new Doctor();
                            		$bill_obj= new Billing();
                            		$lab_obj= new LabModel();
                            		$emp_obj= new Employee();

									$selectCondition[]="b.`id`='".$postArr['ip_id']."'";
	                                                                     
	                                $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition);

	                                if (!empty($postArr['select_template'])) {


	                                	$ipBillDates = $bill_obj->getDistictBillDates($patient_info[0][13]);

	                                	if (!empty($ipBillDates)) {
	                                		
	                                		for ($i=0; $i < count($ipBillDates) ; $i++) { 
	                                			
	                                			$ipBillIds[$i] = $bill_obj->getIpBIllIds($ipBillDates[$i],$patient_info[0][13]);

	                                			if ($ipBillIds[$i]) {
	                                				
	                                				for ($j=0; $j < count($ipBillIds[$i]) ; $j++) { 
	                                					
													$lab_data[0]="bill_no=".$ipBillIds[$i][$j];
													$lab_data[1]="(result_id = (SELECT MAX(result_id) FROM hcare_lab_result_entry WHERE bill_no = '".$ipBillIds[$i][$j]."'))";
													$resultEntryInfo[$i][$j]=$lab_obj->getLabresultEntryById($lab_data,"id","asc");
													

	                                				}

	                                			}

	                                		}

	                                	}



	                                	$where[] = "id = ".$postArr['select_template'];
                                		$where[] = "status = 0";

                                		$form_creator ->popArr['template_selected'] = $template_selected = $ip_obj->getTemplates($where);

	                                	$select[] = "temp_id = ".$postArr['select_template'];
                                		$select[] = "status = 0";

                                		$form_creator ->popArr['template_selected_items'] = $template_selected_items = $ip_obj->getTemplateItems($select);

                                		$wheredata[1] = "ipno = ".$postArr['ip_id'];

                                		$form_creator ->popArr['doctors']=$doctors=$ip_obj->getIpVisitDrInfo($wheredata);

                                		$form_creator ->popArr['postArr']=$postArr;

                                		$form_creator ->popArr['ipBillDates']=$ipBillDates;

                                		$form_creator ->popArr['ipBillIds']=$ipBillIds;

                                		$form_creator ->popArr['resultEntryInfo']=$resultEntryInfo;

										$is_field[0]="a.title='Dr'";
										$is_field[1]="a.status= 0 ";	

										$form_creator ->popArr['doctors_info']=$doctors_info=$emp_obj->getEmployee($is_field);
                                		

                                		$form_creator ->formPath ='/templates/inpatient/discharge_summary.php';

	                                }

                            		

                            		break;

                            	case 'save_discharge_summary' :

                            		$ip_obj= new Inpatient();
                            		$bill_obj= new Billing();
                            		$lab_obj= new LabModel();


                            		if (!empty($postArr)) {

									    $selectCondition[]="b.`id`='".$postArr['ip_no']."'";
									    $patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');

									    if (empty($patientInfo[0][55])) {
									    	

	                            			$summ_id = $ip_obj->save_discharge_summary($postArr);

	                            			for ($i=0; $i <count($postArr['post_values']) ; $i++) { 

	                            				if (!empty($postArr[''.$postArr['post_values'][$i].''])) {

	                            					$summ_field_id[$i]=$ip_obj->save_discharge_summary_fields($summ_id,$postArr['post_values'][$i],"",$postArr['post_values_order'][$i]);

	                            				}
	                            				
	                            				

	                            				for ($j=0; $j <count($postArr[''.$postArr['post_values'][$i].'']) ; $j++) { 

	                            					$ip_obj->save_discharge_summary_items($summ_id,$summ_field_id[$i],$postArr[''.$postArr['post_values'][$i].''][$j]);

	                            					
	                            				}

	                            				if (!empty($postArr[''.$postArr["post_values"][$i]."_tinymce".''])) {
	                            					$summ_field_id_tinymce[$i]=$ip_obj->save_discharge_summary_fields($summ_id,$postArr["post_values"][$i],"",$postArr[''.$postArr["post_values"][$i]."_tinymce_order".''][0][0]);

	                            				}

		                            			for ($j=0; $j <count($postArr[''.$postArr["post_values"][$i]."_tinymce".'']) ; $j++) { 
		                            				
		                            				$ip_obj->save_discharge_summary_items($summ_id,$summ_field_id_tinymce[$i],$postArr[''.$postArr["post_values"][$i]."_tinymce".''][$j]);

		                            			}


                                         
	                            			}

	                            			if (!empty($postArr['medicines'])) {

	                            				$summ_field_medicine_id=$ip_obj->save_discharge_summary_fields($summ_id,"","DISCHARGE ADVICE",$postArr["medicine_order"]);
	                            				
	                            				for ($i=0; $i <count($postArr['medicines']); $i++) { 


	                            					$medical_advice[$i] =implode("#@&", array($postArr['medicines'][$i],$postArr['course'][$i],$postArr['days'][$i]) );

	                            					$ip_obj->save_discharge_summary_items($summ_id,$summ_field_medicine_id,$medical_advice[$i]);


	                            				}

	                            			}

	                            			if (!empty($postArr['investigation_report'])) {
	                            				$summ_field_investigation_id=$ip_obj->save_discharge_summary_fields($summ_id,"","INVESTIGATION",$postArr["investigation_report"]);
	                            				$ip_obj->save_discharge_summary_items($summ_id,$summ_field_investigation_id,"INVESTIGATION");
	                            			}


		                            		if (!empty($postArr['doctors_selected'])) {

		                            			$doctors_selected = array();

		                            			$doctors_selected = implode(",", $postArr['doctors_selected']);

		                            			$summ_field_doctors_selected=$ip_obj->save_discharge_summary_fields($summ_id,"","CONSULTATION_DETAILS",$postArr["doctors_selected_position"]);

		                            			$ip_obj->save_discharge_summary_items($summ_id,$summ_field_doctors_selected,$doctors_selected);

		                            		}

	                            			// $ip_obj->update_discharge_summary_status($summ_id);


	                            			$data=$this->print_discharge_summary($summ_id);






	                                		$form_creator ->popArr['ipBillDates']=$ipBillDates;

	                                		$form_creator ->popArr['ipBillIds']=$ipBillIds;

	                                		$form_creator ->popArr['resultEntryInfo']=$resultEntryInfo;

	                                		$form_creator ->popArr['postArr']=$postArr;

	                                		$form_creator ->popArr['data']=$data;

	                                		$form_creator ->formPath ='/templates/inpatient/print_discharge_summary.php';   


									    }									    

                            		}

                            		break;


                            	case 'manage_discharge_summary' :	

                            			$ip_obj= new Inpatient();
                            			$pagi_obj = new Pagination();

										$k=0;

                                		if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){

                                			if (!empty($postArr['temp_name'])) {
												$wheredata[$k]="temp_name like '%".$postArr['temp_name']."%'";
												$k++;
                                			}
                                			else if (!empty($postArr['patient_name'])) {
												$wheredata[$k]="patient_name like '%".$postArr['patient_name']."%'";
												$k++;
                                			}                
                                			else if (!empty($postArr['ipno'])) {
												$wheredata[$k]="ipno = ".$postArr['ipno'];
												$k++;
                                			}
                                			else if (!empty($postArr['doa'])) {
												$wheredata[$k]="doa >= '".date('Y-m-d',strtotime($postArr['doa']))."'";
												$k++;
                                			}
                                			else if (!empty($postArr['dod'])) {
												$wheredata[$k]="dod <= '".date('Y-m-d',strtotime($postArr['dod']))."'";
												$k++;
                                			}


                                			
                                		}

                            			$wheredata[] = "status = 0";
                            			$discharge_summary_count = $ip_obj->getDischargeInfoCount($wheredata);
                            			// echo $discharge_summary_count;exit();

 					                     $perPage=20;
 					                      if(empty($postArr['current_page'])) 
                                             {
                                                 $current_page =1;	
                                             }
                                         else{ 
                                                 $current_page = $postArr['current_page']; 
                                             }

                                         $limit=$pagi_obj->pageLimit($current_page,$perPage); 

										$form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($discharge_summary_count,$current_page,$perPage);	

										$form_creator ->popArr['current_page']=$current_page;

										$form_creator ->popArr['perPage']=$perPage;


                            			$form_creator ->popArr['discharge_summary']=$discharge_summary = $ip_obj->getDischargeInfo($wheredata,$limit);
                            			// var_dump($discharge_summary);exit();

                                		$form_creator ->popArr['postArr']=$postArr;

                                		$form_creator ->formPath ='/templates/inpatient/manage_discharge_summary.php';   

                                	break;

                            	case 'print_discharge_summary' :	

                            			$ip_obj= new Inpatient();

                            			$data=$this->print_discharge_summary($postArr['id']);

                                		$form_creator ->popArr['postArr']=$postArr;

                                		$form_creator ->popArr['data']=$data;

                                		$form_creator ->formPath ='/templates/inpatient/print_discharge_summary.php'; 


                                	break;

                                case 'template_preview'        :

                                		$ip_obj= new Inpatient();

		                                if (!empty($getArr['id'])) {

		                                	$where[] = "id = ".$getArr['id'];
	                                		$where[] = "status = 0";

	                                		$form_creator ->popArr['template_selected'] = $template_selected = $ip_obj->getTemplates($where);

		                                	$select[] = "temp_id = ".$getArr['id'];
	                                		$select[] = "status = 0";

	                                		$form_creator ->popArr['template_selected_items'] = $template_selected_items = $ip_obj->getTemplateItems($select);

	                                		$form_creator ->popArr['postArr']=$getArr;


		                                }
		                                $form_creator ->formPath ='/templates/inpatient/template_preview.php';

                                	break;

                                case 'edit_discharge_summary'    :

                            		$ip_obj= new Inpatient();
                            		$dr_obj= new Doctor();
                            		$bill_obj= new Billing();
                            		$lab_obj= new LabModel();
                            		$emp_obj = new Employee();


									$selectCondition[]="b.`id`='".$postArr['id']."'";
	                                                                     
	                                $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition);



	                                if (!empty($postArr['action'])) {


										$search[] = "ipno = ".$patient_info[0][13];
										$search[] = "status = 0";
										$data['dischargeInfo'] = $dischargeInfo = $ip_obj->getDischargeInfo($search);

										

	                                	$where[] = "id = ".$postArr['action'];
                                		$where[] = "status = 0";

                                		$form_creator ->popArr['template_selected'] = $template_selected = $ip_obj->getTemplates($where);



	                                	$select[] = "temp_id = ".$postArr['action'];
                                		$select[] = "status = 0";

                                		$form_creator ->popArr['template_selected_items'] = $template_selected_items = $ip_obj->getTemplateItems($select);



                                		$wheredata[1] = "ipno = ".$postArr['id'];

                                		$form_creator ->popArr['doctors']=$doctors=$ip_obj->getIpVisitDrInfo($wheredata);

                                		for ($i=0; $i <count($template_selected_items) ; $i++) { 
                                			

											$wheredata[0] = "summ_id = ".$dischargeInfo[0][0];
											$wheredata[1] = "field_order = ".$template_selected_items[$i][2];
											$wheredata[2] = "status = 0";
											$dischargeInfoFields[$i] = $ip_obj->getDischargeInfoFields($wheredata);


											if (!empty($dischargeInfoFields[$i])) {

												for ($j=0; $j < count($dischargeInfoFields[$i]); $j++) { 
													
													$wheredata[0] = "summ_id = ".$dischargeInfo[0][0];
													$wheredata[1] = "summ_field_id = ".$dischargeInfoFields[$i][$j][0];
													$wheredata[2] = "status = 0";

													$dischargeInfoValues[$i][$j] = $ip_obj->getDischargeInfoValues($wheredata);


												}


											}

                                		}


		                                	$ipBillDates = $bill_obj->getDistictBillDates($dischargeInfo[0][1]);

		                                	if (!empty($ipBillDates)) {
		                                		
		                                		for ($i=0; $i < count($ipBillDates) ; $i++) { 
		                                			
		                                			$ipBillIds[$i] = $bill_obj->getIpBIllIds($ipBillDates[$i],$dischargeInfo[0][1]);

		                                			if ($ipBillIds[$i]) {
		                                				
		                                				for ($j=0; $j < count($ipBillIds[$i]) ; $j++) { 
		                                					
														$lab_data[0]="bill_no=".$ipBillIds[$i][$j];
														$resultEntryInfo[$i][$j]=$lab_obj->getLabresultEntryById($lab_data,"id","asc");
														

		                                				}

		                                			}

		                                		}

		                                	}











	                                }

	                                $form_creator ->popArr['dischargeInfoValues']=$dischargeInfoValues;
	                                $form_creator ->popArr['dischargeInfoFields']=$dischargeInfoFields;
	                                $form_creator ->popArr['dischargeInfo']=$dischargeInfo;

		                            $form_creator ->popArr['ipBillDates'] = $ipBillDates;
		                            $form_creator ->popArr['ipBillIds']  = $ipBillIds;
		                            $form_creator ->popArr['resultEntryInfo']  = $resultEntryInfo;

									$is_field[0]="a.title='Dr'";
									$is_field[1]="a.status= 0 ";	

									$form_creator ->popArr['doctors_info']=$doctors_info=$emp_obj->getEmployee($is_field);


	                                $form_creator ->popArr['postArr']=$postArr;

	                                $form_creator ->formPath ='/templates/inpatient/edit_discharge_summary.php';   

                                	break;


								case 'update_discharge_summary'  :

									$ip_obj= new Inpatient();

									$this->delete_discharge_summary($postArr['discharge_id']);

									$this->viewPage("save_discharge_summary",$postArr);
									$form_creator ->formPath ='/templates/inpatient/print_discharge_summary.php';  

									break;	

								case 'delete_patient_discharge_summary'  :

									$ip_obj= new Inpatient();

									$this->delete_discharge_summary($postArr['id']);

									$postArr['message'] = "Discharge Summary deleted successfully";

									$this->viewPage("manage_discharge_summary",$postArr);
									$form_creator ->formPath ='/templates/inpatient/manage_discharge_summary.php';  

									break;	

				case 'OP_Search_observation'	   : 
													$com_obj = new CommonFunctions();
													$reg_obj= new Registration();
													$emp_obj= new Employee();
													$comm_obj= new CommonFunctions();
													
													if(!empty($postArr["opno"])){
														$selectCondition[]="a.`id`='".$postArr["opno"]."'";
														$selectCondition[]="b.`visit_date` like '%".date("Y-m-d")."%'";
													}else{
													if(!empty($postArr["date"])){
														$selectCondition[]="b.`visit_date` like '%".date("Y-m-d",strtotime($postArr["date"]))."%'";
													}else $selectCondition[]="b.`visit_date` like '%".date("Y-m-d")."%'";												
													
													}
													if(!empty($postArr["name"])){
														$selectCondition[]="a.`first_name` like '%".$postArr["name"]."%'";
													}
													if(!empty($postArr["mname"])){
														$selectCondition[]="a.`middle_name` like '%".$postArr["mname"]."%'";
													}
													if(!empty($postArr["lname"])){
														$selectCondition[]="a.`last_name` like '%".$postArr["lname"]."%'";
													}
													if(!empty($postArr["place"])){
														$selectCondition[]="a.`place`='".$postArr["place"]."'";
													}
													
													if(!empty($postArr["telNo"])){
														$selectCondition[]="a.`contact_no` LIKE '%".$postArr["telNo"]."%'";
													}
													if(!empty($postArr["doctor"])){
														$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
													}

													$selectCondition[]="b.`cancelled`= 0";

													if (empty($postArr)) {
													
														$selectCondition[]="b.`observation`='YES' or b.`observation`='DISCHARGED' ";
														$selectCondition[]="b.`visit_date` like '%".date("Y-m-d")."%'";
													}
													
													$selectCondition[]="(b.`observation`='YES' or b.`observation`='DISCHARGED') ";

													// var_dump($selectCondition);
													$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');
													
													$is_field[0]="a.title='Dr'";													
													$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
													
													$form_creator ->formPath ='/templates/inpatient/op_search_observation.php';
													break;


					case 'manage_observation' :	$com_obj = new CommonFunctions();
														$reg_obj= new Registration();
														$emp_obj= new Employee();
														$user_obj=new User();
											            $db_function=new DBFunction();
											
														
														 if(!empty($postArr['from_time'])){
                                                             $from_time=date("H:i:s",strtotime($postArr['from_time']));
													         $to_time=date("H:i:s",strtotime($postArr['to_time']));
														}else{
														
														     $from_time="00:00:00";
													         $to_time="23:59:59";
														}
												   												  
														
														if(isset($postArr['from_date']) && $postArr['action']!="CLEAR"){
														
														    
															$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
															$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
															
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
															if(!empty($postArr["gender"])){
																$selectCondition[]="a.`gender`='".$postArr["gender"]."'";
															}
														}else{
															$fromdate=$com_obj->getcurrentDate()." ".$from_time;
															$todate=$com_obj->getcurrentDate()." ".$to_time;
														}
														
														if(!empty($postArr["health_checkup"])){
																$selectCondition[]="b.`health_checkup`='YES'";
														}
														
														
														
														//Extract by user id and user type
											
											$user_type_logged_in=$_SESSION['user_type'];
											$user_type_id=$_SESSION['user_type_id'];
											$user_data=array();
											$user_type="";
											$user_id="";
											
											if(!empty($postArr['user_type'])) {
														
												$user_data[]="user_type='".$postArr['user_type']."'";
												
												if(empty($postArr['user'])) {
														
													$userInfo=$user_obj->getUser('',$user_data);
													
													for($i=0;$i<count($userInfo);$i++){
														
														if($i == 0 ){
															$user_id .="(";
														}
														//echo (count($userInfo));
														if($i == ((count($userInfo))-1)){
														
															$user_id .=$userInfo[$i][0].")";
														}else{
															$user_id .=$userInfo[$i][0].",";
														}
													}
												if($user_id == "") $user_id ="(0)";	
														
												}
                                            $postArr['user_type_name']=$db_function->getidToValue("user_type","id",$postArr['user_type'],"hcare_user_type");
														
											}		
											if(!empty($postArr['user'])) {
														
												$user_id="($postArr[user])";
												
												if($user_id == "") $user_id ="(0)";	

                                                $postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");														
											}
											
											$user_type_info=array();
													
											if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){
											$user_type_info[]="id='".$user_type_id."'"; 
												
												if(empty($postArr['user_type'])){
												
													$postArr['user_type']=$user_type_id;
													
													
													//$user_type[]="id='".$user_type_id."'";
												}
												// if(empty($postArr['user'])){
													
												// 	$user_id="($_SESSION[user_id])";
												// 	$user_data[]="user_type='".$user_type_id."'";
												// 	$postArr['user']=$_SESSION['user_id'];
													
												// }
											}
											
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
											$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
											
											if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
											
											$selectCondition[]="b.`visit_date`>='".$fromdate."'";
											$selectCondition[]="b.`visit_date`<='".$todate."'";;
											$selectCondition[]="b.`cancelled`=0";											
											$selectCondition[]="(b.`observation`='YES' or b.`observation`='DISCHARGED' or b.`observation`='ADMITTED') ";
											// $selectCondition[]="b.`visit_date` like '%".date("Y-m-d")."%'";
											
											$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
											
														
											 if( isset($postArr['action']) && $postArr['action']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
											}else {
												$form_creator ->popArr['post']='';
											}
														
											$is_field[0]="a.title='Dr'";	
											
																							
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  
														
											$form_creator ->formPath ='/templates/inpatient/manage_observation.php';
														break;

					//for observation bills clear
					case 'clearAllBills' :  $bill_obj = new Billing();
											$visit_id = $postArr['id'];
											//credit bill info
												
											$wheredata[0]="ref_no ='".$visit_id."'";
											$opbill_credit=$bill_obj->getOPCreditBillAmt($wheredata);
																				
											//pharma credit Bill
																			  
											$phwhere[]="op_visit_id = '".$visit_id."'";
											$oppharma_credit=$bill_obj->getOPPharmaCreditAmt($phwhere,"0,3");
																						
											$total_credit=$opbill_credit+$oppharma_credit+$ip_credit;
											
											echo json_encode($total_credit);exit();



			
			}
			
			$form_creator->display();
	
	}
	function processIP($ipno){
	     $ip_obj= new Inpatient();
		 $inc_obj= new InsuranceCompany();
		 $com_obj = new CommonFunctions();
		 $pat_cat = new PatientCategory();	
		 
		 $selectCondition[]="b.`id`='".$ipno."'";
		 $patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
		 
		    $post['opno']=$opno=$patientInfo[0][0];												
			$post['first_name']=$patientInfo[0][1];
			$post['middle_name']=$patientInfo[0][2];
			$post['last_name']=$patientInfo[0][3];
			
			$age=$patientInfo[0][4];
				
			$age_in=explode(" ",$age);
			$age=$age_in[0];
			$age_type=$age_in[1];
				
				
			$post['age']=$age;
			$post['age_type']=$age_type;
		
			$post['gender']=$patientInfo[0][6];
			$post['marital_status']=$patientInfo[0][7];
			$post['place']=$patientInfo[0][8];
			$post['nationality']=$patientInfo[0][9];
			$post['contact_no']=$patientInfo[0][10];
			$post['email']=$patientInfo[0][11];
                        $post['c_of']=$patientInfo[0][45];
			$post['address']=$patientInfo[0][46];
			$post['mobile_no']=$patientInfo[0][47];
			$post['doctor']=$patientInfo[0][16];
			
			$post['insurance_company']=$patientInfo[0][23];
			$post['policy_no']=$patientInfo[0][25];
			$post['claim']=$patientInfo[0][26];
			$post['company_name']=$patientInfo[0][27];
			$post['company_id']=$patientInfo[0][28];
			$post['relation']=$patientInfo[0][29];
			$post['patient_category']=$patientInfo[0][53];

			$post['guardian_type']=$patientInfo[0][56];
			$post['guardian']=$patientInfo[0][57];
			$post['house_name']=$patientInfo[0][58];
			$post['aadhar']=$patientInfo[0][59];

			 //for member category
            $post['member_patient_id']=$patientInfo[0][60];
            $post['member_id']=$patientInfo[0][61];
            if($post['member_id']){
				// $post['member_details'] = $reg_obj->getMemberDetails($post['member_id']);
				$post['member_patient_id_name'] = $patientInfo[0][62];
			}


		
			
			if($patientInfo[0][30] !='0000-00-00' && $patientInfo[0][31] !='0000-00-00'){
				$post['date_issue']=date("d-m-Y",strtotime($patientInfo[0][30]));
				$post['date_expiry']=date("d-m-Y",strtotime($patientInfo[0][31]));
			}
			
			if($patientInfo[0][5] !='0000-00-00' && $patientInfo[0][5] !="1970-01-01"){
					$post['dob']=date("d-m-Y",strtotime($patientInfo[0][5]));
			}
			
			if($post['insurance_company']>0){
				$post['inc']="insurance";
			}
			
			
			$todate =$com_obj->getcurrentDate();
			
			//if($patientInfo[0][22] >0 ){
			
					$is_field[0]="a.valid_upto >='".$todate."'";
					$post['inc_company']=$inc_obj->getInsCompany($is_field);
			//}
/*..... patient category details .....*/
                    $post['pat_cat_list']=$pat_cat->getPatientCategoryInfo();
/*..... patient category details .....*/ 	
			
			$post['refferal_info']=$patientInfo[0][32];
			
			$post['room_no']=$patientInfo[0][37];
			$post['bed_no']=$patientInfo[0][38];
			$post['rent']=$patientInfo[0][35];
			$post['ncharge']=$patientInfo[0][49];
			$post['mcharge']=$patientInfo[0][50];
            $post['room_id']=$patientInfo[0][33];
			$post['bed_id']=$patientInfo[0][34];
			$post['admission_date']=$patientInfo[0][20];
                       
			
			$post['ipno']=$ipno;
			//1970 card issue
			$post['card_expiry']=$patientInfo[0][58];	
			$post['bystander_status']=$patientInfo[0][66];
			$post['bcharge']=$patientInfo[0][67];		
			
			return $post;
	}
	function processOP($opid){
	
			$reg_obj= new Registration();			
			$inc_obj= new InsuranceCompany();
			$com_obj = new CommonFunctions();	
			$pat_cat = new PatientCategory();
			$db_function =new DBFunction();
	
			$selectCondition[0]="b.`id`='".$opid."'";
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');;
			
			$post['opno']=$opno=$patientInfo[0][0];												
			$post['first_name']=$patientInfo[0][1];
			$post['middle_name']=$patientInfo[0][2];
			$post['last_name']=$patientInfo[0][3];
				
			$age=$patientInfo[0][4];
				
			$age_in=explode(" ",$age);
			$age=$age_in[0];
			$age_type=$age_in[1];
				
				
			$post['age']=$age;
			$post['age_type']=$age_type;
		
			$post['gender']=$patientInfo[0][6];
			$post['marital_status']=$patientInfo[0][7];
			$post['place']=$patientInfo[0][8];
			$post['nationality']=$patientInfo[0][9];
			$post['contact_no']=$patientInfo[0][10];
			$post['email']=$patientInfo[0][11];
                        $post['c_of']=$patientInfo[0][44];
			$post['address']=$patientInfo[0][45];
			$post['mobile_no']=$patientInfo[0][46];
			$post['doctor']=$patientInfo[0][14];
			
			$post['insurance_company']=$patientInfo[0][22];
			$post['policy_no']=$patientInfo[0][24];
			$post['claim']=$patientInfo[0][25];
			$post['company_name']=$patientInfo[0][26];
			$post['company_id']=$patientInfo[0][27];
			$post['relation']=$patientInfo[0][28];
            $post['patient_category']=$patientInfo[0][56];
            //for member category
            $post['member_patient_id']=$patientInfo[0][79];
            $post['member_id']=$patientInfo[0][80];
            if($post['member_id']){
				// $post['member_details'] = $reg_obj->getMemberDetails($post['member_id']);
				$post['member_patient_id_name'] = $db_function->getidToValue('patient_id','id', $post['member_patient_id'],'hcare_patient_category_ids');
			}

			$post['guardian_type']=$patientInfo[0][60];
			$post['guardian']=$patientInfo[0][61];
			$post['house_name']=$patientInfo[0][59];
			$post['aadhar']=$patientInfo[0][62];

          
                        
				
			
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
			
			
			$todate =$com_obj->getcurrentDate();
			
			//if($patientInfo[0][22] >0 ){
			
					$is_field[0]="a.valid_upto >='".$todate."'";
					$post['inc_company']=$inc_obj->getInsCompany($is_field);
			//}
/*..... patient category details .....*/
                    $post['pat_cat_list']=$pat_cat->getPatientCategoryInfo();
/*..... patient category details .....*/ 			
			$post['id']=$opid;
			// 1970 card_expiry issue
			$post['card_expiry']=$patientInfo[0][53];
			return $post;
	
	}
    
    /*
       ADMIT PATIENT
           Save admission info of selected patient    
    
    */
	function processAdmission($postArr){ 
	
	       $com_obj = new CommonFunctions();
               $reg_obj= new Registration();
               $ip_obj= new Inpatient();
	       $room_obj= new Room();
               $db_function =new DBFunction();
           
	       $action=$postArr['paction'];
			
			switch($action){
		
				case 'SAVE' :
				
								$opno=$postArr['opno'];
								
                                //update patient info
                                   $opno=$reg_obj->updatePatientinfo($postArr);
                                   
                                //admit a patient
                                
                                   $postArr['admission_time']=$com_obj->getcurrentTime('h:i a');
                                   $postArr['admission_date'] =$com_obj->getcurrentDate();
                                   
                                   $ipno=$ip_obj->addIpPatient($postArr);
								//update bed status free to ADMITTED
				                 $room_obj->updateBedStatus('ADMITTED',$postArr['bed_no']);							  
						     	if($postArr['observation']=='YES'){
								 $reg_obj->updateObservation($postArr['id'],'ADMITTED',null,null);
								}
								   break;
			 case 'UPDATE' :
			                     $ipno=$postArr['ipno'];

                                //check room for room transfer

                if(!empty($postArr['room']) && !empty($postArr['bed_no'])){
        
                                    //check for history
				     $where[]= "ipno = ".$ipno;
                                     $roomhist = $ip_obj->getRoomhistory('',$where);

				     if(!empty($roomhist)){

					$count = count($roomhist);
					$startdate= $roomhist[$count-1][3];
					$postArr["startdate"]=$startdate;

                                        
				     }else{

					//$postArr["startdate"]=$postArr["adate"];
                                         $postArr["startdate"]=$db_function->getidToValue("admission_date","id",$ipno,"hcare_ip_info");     

				     }

                                     $postArr['enddate']=$com_obj->getcurrentTime('h:i a');
				                     $ip_obj->addIProomHistory($postArr);

                                     $room_obj->updateBedStatus('FREE',$postArr['bed_id']);
                                     $room_obj->updateBedStatus('ADMITTED',$postArr['bed_no']);
               }
								 
				//update patient info
                  $opno=$reg_obj->updatePatientinfo($postArr);								 
				 $ipno=$ip_obj->updateIpPatient($postArr);
			}

			//photo upload

            if($opno > 0 ){
		
			
			$post['opno']=$opno;
			
			//uploadphoto
			
			$fName=$_POST['multiFiles'];
			$upload_base = 'E:\wamp\www\hcare\templates\registration\patient_photo';
			
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
			
			}	
      }			
            $this->viewPage("manageInpatient",$post);
	}
	public function getFreeRooms(){
	
		$room_obj= new Room();
		
		//$is_field[0]="room_status='FREE'";
                $wheredata[]="status =0 ";
		$roomInfo=$room_obj->getRoomDetails('',$wheredata);
		// var_dump($roomInfo);
		$rooms=array();
		$k=0;
		if(!empty($roomInfo)){
		
			for($i=0;$i<count($roomInfo);$i++){
				$condition=array();
				$room_id=$roomInfo[$i][0];
				
				$condition[] = "room_id=".$room_id;
				$condition[] = "bed_status='FREE'";
                                
			
				$bedInfo=$room_obj->getBedInfo('',$condition);
				
				if(!empty($bedInfo)){
				
					$rooms[$k][0]=$roomInfo[$i][0];
					$rooms[$k][1]=$roomInfo[$i][2];
					$rooms[$k][2]=$roomInfo[$i][10];
					$k++;
				}
			
			}
		
		}
		
		return $rooms;
	
	}
	
	public function processRoom($post){
	

	
		//create instance
		
		$room_obj= new Room();	
	
		//get room id
		$room_id=$post['id'];
		
		
		//set the conditions to get room details
		
		$is_field[0]="id=".$room_id;
		$roomInfo=$room_obj->getRoomDetails('',$is_field);
		
		//get room details
		$total_bed_no=$roomInfo[0][4];
		$room_category=$roomInfo[0][1];
		$rent=$roomInfo[0][6];
		$ncharge=$roomInfo[0][8];
		$mcharge=$roomInfo[0][9];
		$hcharge=$roomInfo[0][10];
		$bcharge=$roomInfo[0][11];
		
		//get bed info
		$beds=array();
		
		$condition[] = "room_id=".$room_id;
		$condition[] = "bed_status='FREE'";
			
		$bedInfo=$room_obj->getBedInfo('',$condition);
			
			
			for($i=0;$i<count($bedInfo);$i++){
			
				$beds[$i][0]=$bedInfo[$i][0];
				$beds[$i][1]=$bedInfo[$i][2];
			}
			
	
		$data=array();
		$data['bedInfo']=$beds;
		$data['room_rent']=$rent;
		$data['ncharges']=$ncharge;
		$data['mcharges']=$mcharge;		
		$data['hcharges']=$hcharge;
		$data['bcharges']=$bcharge;
		 echo json_encode($data);
		
	}
	public function add_new_template($post){

		$ip_obj= new Inpatient();	
		
		if (!empty($post)) {
			
			$template_id = $ip_obj->addNewTemplate($post);

			if (!empty($template_id)) {
				
				for ($i=0; $i < $post['field_counter'] ; $i++) { 
					$ip_obj->addTemplateItems($template_id,$post['sl_no'][$i],$post['field_name'][$i],$post['field_type'][$i]);
				}

			}
			$post['message'] = "Temaplate Added Successfully";

		}

		$this->viewPage("manage_templates",$post);

	}
	public function print_discharge_summary($id){

		$ip_obj = new Inpatient();
		$bill_obj = new Billing();
		$lab_obj = new LabModel();

		$search[] = "id = ".$id;
		$search[] = "status = 0";
		$data['dischargeInfo'] = $dischargeInfo = $ip_obj->getDischargeInfo($search);



		if (!empty($dischargeInfo)) {
			
			$where[] = "summ_id = ".$dischargeInfo[0][0];
			$where[] = "status = 0";
			$dischargeInfoFields = $ip_obj->getDischargeInfoFields($where);


			if (!empty($dischargeInfoFields)) {

				$data['dischargeInfoFields'] = $dischargeInfoFields; 
			
				for ($i=0; $i < count($dischargeInfoFields); $i++) { 
					
					$wheredata[0] = "summ_id = ".$id;
					$wheredata[1] = "summ_field_id = ".$dischargeInfoFields[$i][0];
					$wheredata[2] = "status = 0";

					$dischargeInfoValues[$i] = $ip_obj->getDischargeInfoValues($wheredata);

					

				}

				if (!empty($dischargeInfoValues)) {
					$data['dischargeInfoValues'] = $dischargeInfoValues;
				}



				

			}
			

		                                	$ipBillDates = $bill_obj->getDistictBillDates($dischargeInfo[0][1]);

		                                	if (!empty($ipBillDates)) {
		                                		
		                                		for ($i=0; $i < count($ipBillDates) ; $i++) { 
		                                			
		                                			$ipBillIds[$i] = $bill_obj->getIpBIllIds($ipBillDates[$i],$dischargeInfo[0][1]);

		                                			if ($ipBillIds[$i]) {
		                                				
		                                				for ($j=0; $j < count($ipBillIds[$i]) ; $j++) { 
		                                					
														$lab_data[0]="bill_no=".$ipBillIds[$i][$j];
														$resultEntryInfo[$i][$j]=$lab_obj->getLabresultEntryById($lab_data,"id","asc");
														

		                                				}

		                                			}

		                                		}

		                                	}


		                                	$data['ipBillDates'] = $ipBillDates;

		                                	$data['ipBillIds'] = $ipBillIds;

		                                	$data['resultEntryInfo'] = $resultEntryInfo;




		}

		return $data;

	}
	public function update_template($post){

		if (!empty($post)) {

			$ip_obj = new Inpatient();
				
			$template_id = $post['template_id'];

			$ip_obj->updateTemplateName($template_id,$post['template_name']);

			if (!empty($template_id)) {

	            $select[] = "temp_id = ".$template_id;
                $select[] = "status = 0";
              	$template_selected_items = $ip_obj->getTemplateItems($select);	

              	for ($i=0; $i <count($template_selected_items) ; $i++) { 
              		
              		$ip_obj->remove_field($template_selected_items[$i][0]);

              	}

			}

			for ($i=0; $i < $post['field_counter'] ; $i++) { 

				$ip_obj->addTemplateItems($template_id,$post['sl_no'][$i],$post['field_name'][$i],$post['field_type'][$i]);
			}


		}


		$post['message'] = "Temaplate Updated Successfully";
		$this->viewPage("manage_templates",$post);

	}
	public function delete_template($post){

		if (!empty($post)) {

			$ip_obj = new Inpatient();
			
			$id = $post['id'];

			$ip_obj->delete_template($id);

			if (!empty($id)) {

	            $select[] = "temp_id = ".$id;
                $select[] = "status = 0";
              	$template_selected_items = $ip_obj->getTemplateItems($select);	

              	for ($i=0; $i <count($template_selected_items) ; $i++) { 
              		
              		$ip_obj->remove_field($template_selected_items[$i][0]);

              	}

			}





		}

		$post['message'] = "Temaplate Deleted Successfully";
		$this->viewPage("manage_templates",$post);


	}
	public function delete_discharge_summary($id){

		$ip_obj = new Inpatient();

		$ip_obj->deleteDischargeSummary($id);

		$wheredata[0] = "summ_id = ".$id;
		$wheredata[1] = "status = 0";
		$dischargeInfoFields = $ip_obj->getDischargeInfoFields($wheredata);

			if (!empty($dischargeInfoFields)) {

				for ($i=0; $i <count($dischargeInfoFields) ; $i++) { 
											
					$ip_obj->deleteDischargeInfoFields($dischargeInfoFields[$i][0]);

					$wheredata[0] = "summ_id = ".$id;
					$wheredata[1] = "summ_field_id = ".$dischargeInfoFields[$i][0];
					$wheredata[2] = "status = 0";	

					$dischargeInfoValues[$i]= $ip_obj->getDischargeInfoValues($wheredata);										
					if (!empty($dischargeInfoValues[$i])) {
												
						for ($j=0; $j <count($dischargeInfoValues[$i]) ; $j++) { 
													
							$ip_obj->deleteDischargeInfoValues($dischargeInfoValues[$i][$j][0]);

						}

					}


				}

			}

			return;


	}


	
}
?>