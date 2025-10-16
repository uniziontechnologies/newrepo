<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/procedure/procedure.php';
require_once ROOT_PATH . '/lib/model/room/room.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/doctor/doctor.php';


class NurseController {

	

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){ 
				
				
				case 'in_patient_list':  $emp_obj= new Employee();								 
								   $com_obj = new CommonFunctions();
								   $ip_obj= new Inpatient();
                                       $room_obj=new room();
									

                                   //if patient is selected then unset

                                                  $_SESSION['patient_selected']='';                  		   
											   //search criterias
							           if(isset($postArr['from_date']) && $postArr['paction']!="CLEAR"){
											   
									$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
									$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
															
									if(!empty($postArr["opno"])){
										$selectCondition[]="a.`id`='".$postArr["opno"]."'";
									}
									if(!empty($postArr["ipnum"])){
										$selectCondition[]="b.`id`='".$postArr["ipnum"]."'";
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
								}else{
										$fromdate=$com_obj->getcurrentDate();
										$todate=$com_obj->getcurrentDate();
								}
								if ($_SESSION['user_type'] == "NURSE"){

                                                                $station_id=$_SESSION['station_id'];

                                                                $srooms="";
                                                                $wheredata[0]="station_id=".$station_id;
                                                                $wheredata[1]="status =0 ";
                                                                $roomInfo=$room_obj->getRoomDetails('',$wheredata);

                                                                        if(!empty($roomInfo)){

                                                                           for($j=0;$j<count($roomInfo);$j++) {

                                                                              $srooms .=$roomInfo[$j][0];

                                                                               if($j < (count($roomInfo)-1)) $srooms .="," ;
                                                                           }
                                                                        }
												
												
                                                                
                                                               $selectCondition[]="b.`room_id` in ($srooms)";   

                                 }
                                                                                  
                                 $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)"; 
								$selectCondition[]="b.`cancelled`=0";
								$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
								if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
										$form_creator ->popArr['post']=$postArr;
								}else $form_creator ->popArr['post']='';
											  
								
                                                          $is_field[0]="a.title='Dr'";
										
				                          $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											  
											 	
							               $form_creator ->formPath ='/templates/nurse/in_patient_list.php';
							                break;
							case 'ip_case_sheet' :
							                       $proc_obj=new Procedure();
                                                   $ip_obj=new Inpatient();
												   $emp_obj= new Employee();
												   $ip_obj=new Inpatient();
												   $room_obj= new Room();
												   
												   //patient info
                                                   $selectCondition[]="b.`id`='".$postArr['ipno']."'";
                                                   $form_creator ->popArr['patientInfo']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
							                      //procedure list
												  
												   $wheredata[0]="status = 0";
                                                   $wheredata[1]="category_id = 1";
							                       $form_creator ->popArr['procedureInfo']=$proc_obj->getProcedure('',$wheredata);

                                                   $pr_where[0]="ipno = '".$postArr['ipno']."'";
														 
                                                  $form_creator ->popArr['ipProcedure']=$ip_obj->getIPProcedure('',$pr_where,'status','asc');
												  
												  //doctor visit details
												  
												        
                                                         $vs_where[0]="ipno = '".$postArr['ipno']."'";
                                                         $form_creator ->popArr['DocVisit']= $ip_obj->getDoctorVisit('',$vs_where,'status','asc');
                                                     

                                                         $is_field[0]="a.title='Dr'";                                                  													
							                              $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
												//nursing notes
												
                                                 $nr_where[0]="ipno = '".$postArr['ipno']."'";
                                                 $form_creator ->popArr['nurNotes']=$ip_obj->getIPNursingNotes('',$nr_where,'date','asc');
												 
												//room history
												$where[]= "ipno = ".$postArr['ipno'];
                                                $form_creator ->popArr['roomhist'] =$roomhis= $ip_obj->getRoomhistory('',$where);
												
												 $selectCondition[]="b.`id`='".$postArr['ipno']."'";
		                                         $patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
		                                         // var_dump($patientInfo);
												 
												 $roomInfo['room_no']=$patientInfo[0][37];
			                                     $roomInfo['bed_no']=$patientInfo[0][38];
			                                     $roomInfo['rent']=$patientInfo[0][35];
			                                     $roomInfo['ncharge']=$patientInfo[0][49];
			                                     $roomInfo['mcharge']=$patientInfo[0][50];
                                                 $roomInfo['room_id']=$patientInfo[0][33];
			                                     $roomInfo['bed_id']=$patientInfo[0][34];
			                                     if(empty($roomhis)){
			                                     	$roomInfo['admission_date']=$patientInfo[0][20];
			                                     $roomInfo['admission_time']=$patientInfo[0][19];

			                                     }else{
			                                     	$count = count($roomhis);
			                                     	// var_dump($roomhis);exit;
																$roomInfo['admission_date']= $roomhis[$count-1][3];
																$roomInfo['admission_time']= $roomhis[$count-1][13];

			                                     }
			                                     
												 
												 $form_creator ->popArr['roomInfo'] = $roomInfo;
												 
												//free rooms list
												$roomInfo=array();
												$roomCondn[]="status =0 ";
		                                        $roomInfo=$room_obj->getRoomDetails('',$roomCondn);
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
					                                    $k++;
				                                  }
			
			                                    }
		
		                                    }


                                                $med_where[0]="ipno = '".$postArr['ipno']."'";
														 
                                                $form_creator ->popArr['ipMedicines']=$ip_obj->getIpMedicines('',$med_where,'status','asc');

                                                $own_med_where[0]="ip_no = '".$postArr['ipno']."'";
                                                $own_med_where[1]="status = 0";

														 
                                                $form_creator ->popArr['ownMedicines']=$ip_obj->getIpOwnMedicines('',$own_med_where,'id','asc');





												 $form_creator ->popArr['freeRooms']=$rooms;
												 
												  $form_creator ->popArr['subtab']=$postArr['subtab'];
												  //for final bill
												   $form_creator ->popArr['type']=$postArr['type'];
							                      $form_creator ->formPath ='/templates/nurse/ip_case_sheet.php';
							                      break;

                                
			       case 'Select_Station' : 
                                                       $room_obj=new room();

                                                       $condition[] = "status=0";
                                                       $stationInfo=$room_obj->getNursingStation($condition);

                                                       $form_creator ->popArr['stationInfo']=$stationInfo;

                                                       $form_creator ->formPath ='/templates/nurse/select_station.php';
							 break;

				   case 'op_patient_list' :

                            $reg_obj= new Registration();
                            $com_obj = new CommonFunctions();
                            $emp_obj= new Employee();

                            $fromdate=$com_obj->getcurrentDate();
				            $todate=$com_obj->getcurrentDate();
                                                        
                            $selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
						    $selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
						    $selectCondition[]="b.`cancelled`=0";

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
                      
							$form_creator ->popArr['post']=$postArr;
						
						    $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.token_no','asc');
                         
                            $is_field[0]="a.title='Dr'";
						    $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);                                
											  
											 	
							$form_creator ->formPath ='/templates/nurse/op_patients_list.php';
							break;

				case 'op_case_sheet' :

				            $reg_obj= new Registration();
				            $dr_obj=new Doctor();

				            $selectCondition[]="a.`id`='".$postArr['pid']."'";
				            $selectCondition[]="b.`doc_id`='".$postArr['doc_id']."'";
				            $selectCondition[]="b.`id`='".$postArr['op_visit_id']."'";

				            $form_creator ->popArr['patientInfo']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.token_no','asc');

				            $where[0]="visit_id =".$postArr['op_visit_id'];
					        $where[1]="status =0";  
						    $form_creator ->popArr['physical_examination']=$dr_obj-> getPhysicalExamination('', $where);

                            $postArr['patient_type']="OP";
						    $form_creator ->popArr['post']=$postArr;
						    $form_creator ->popArr['subtab']=$postArr['subtab'];
                            
                            $form_creator ->formPath ='/templates/nurse/op_case_sheet.php';

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
												$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
												if(isset($postArr['action']) && $postArr['action']!="CLEAR"){
															$form_creator ->popArr['post']=$postArr;
												}else $form_creator ->popArr['post']='';
											  
											  
					                       $form_creator ->formPath ='/templates/doctor/ip_patients_list.php';
													break;



							case 'ip_Patient_Records' :        $reg_obj= new Registration();
											   $pagi_obj = new Pagination();
										       $db_obj=new DBFunction();
											   $ip_obj= new Inpatient();

											
											   $selectCondition=array();
											   if(!empty($postArr["ipno"])){
																	$selectCondition[]="b.`ipno` like '%".$postArr["ipno"]."%'";
												}
												if(!empty($postArr["first_name"])){
													$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
												}
												if(!empty($postArr["place"])){
													$selectCondition[]="a.`place`='".$postArr["place"]."'";
												}
												if(!empty($postArr["contact_no"])){
													$selectCondition[]="a.`contact_no`='".$postArr["contact_no"]."'";
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
						                      
											    
											   $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','desc',$limit);

						                       $form_creator ->formPath ='/templates/patient_record/ip_patient_list.php';			
							
										           break;
							case 'add_ot_schedule'	:
													$reg_obj= new Registration();
											   	$pagi_obj = new Pagination();
										       	$db_obj=new DBFunction();
										       	$emp_obj = new Employee();

										       	$is_field[0]="a.title='Dr'";
													$is_field[1]="a.status= 0 ";	

													$form_creator ->popArr['doctors_info']=$doctors_info=$emp_obj->getEmployee($is_field);


													$form_creator ->formPath ='/templates/nurse/add_ot_schedule.php';			
							
										           break;

							case 'manage_ot_schedule'	:
													$reg_obj= new Registration();
											   	$pagi_obj = new Pagination();
										       	$db_obj=new DBFunction();
										       	
										       	$com_obj = new CommonFunctions();
										       	$search=array();
										       	// $search1=array();

										       	if(!empty($postArr["from_date"])){
													  $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
													  $search[]="`surgery_started_date_time`>='".$fromdate." 00:00:00'";
												    }else{
												    	$fromdate=$com_obj->getcurrentDate();
												    	$search[]="`surgery_started_date_time`>='".$fromdate." 00:00:00'";

												    }
												   if(!empty($postArr["to_date"])){
													   $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
													   $search[]="`surgery_ended_date_time`<='".$todate." 23:59:59'";
												   }else{
												    	$todate=$com_obj->getcurrentDate();
												    	$search[]="`surgery_started_date_time`>='".$todate." 00:00:00'";

												    }

										       	if(!empty($postArr["ref_no"])){
										       		$ref_no=$postArr["ref_no"];
										       		$search[]="`ref_no`='".$postArr["ref_no"]."'";
													
													}
													if(!empty($postArr["type"]) ){
														$type=$postArr["type"];
														$search[]="`type`='".$postArr["type"]."'";
													}

													if(!empty($postArr["surgery_status"])){
														$surgery_status=$postArr["surgery_status"];
														$search[]="`surgery_status`='".$postArr["surgery_status"]."'";
													}

													$search[]="status= 0";

													// var_dump($search);

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

                                                $patient_count=$reg_obj->getOtScheduleCount($search);

                                                // echo $patient_count;exit();
											/*...............pagination..............*/	

															// var_dump($search);exit;
																$form_creator ->popArr['patient_info']=$patient_info=$reg_obj->getOtSchedule($search,$limit);
																  // var_dump($patient_info);

																if(!empty($patient_info)){
																	for ($i=0; $i <count($patient_info) ; $i++) { 

																		$schedule_id=$patient_info[$i][0];

																		$search1[0]="`ot_schedule_id`='".$schedule_id."'";
																		$search1[1]="status =0";
																		

																		$doctorInfo[$i]=$reg_obj->getOtScheduleDoctors($search1);
																		


																		
																	}
																}


																$form_creator ->popArr['doctorInfo']=$doctorInfo;
																

																$form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patient_count,$current_page,$perPage);

																$form_creator ->popArr['current_page']=$current_page;	
																$form_creator ->popArr['perPage']=$perPage;	
				                                    $form_creator ->popArr['post']=$postArr;        

													
													
																$form_creator ->formPath ='/templates/nurse/manage_ot_schedule.php';			
																
																			           break;			 
							case 'search_patient'	:
													$reg_obj= new Registration();
											   	// $pagi_obj = new Pagination();
										       	// $db_obj=new DBFunction();
										       	$ip_obj = new Inpatient();
										       	$emp_obj = new Employee();

										       	// var_dump($postArr);exit;

										       	if(!empty($postArr["doctor_name"])){
										       		$id=$postArr['id'];
										       		 $wheredata1[0]="ot_schedule_id ='".$id."'";
													     $wheredata1[1]="status =0";

													$form_creator ->popArr['doctors_list']=$doctors_list=$reg_obj->getOtScheduleDoctors($wheredata1);
										       	}






										       	// echo 1111111111;exit;
										       	
										       	if(!empty($postArr["ref_no"])){
										       		$ref_no=$postArr["ref_no"];
													
												}
												if(!empty($postArr["patient_type"])){
													$type=$postArr["patient_type"];
												}
												 // echo $type;exit;
												if ($type=="OP") {

												$selectCondition[0]="a.`id`='".$ref_no."'";

												$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);
												 // var_dump($patientInfo);
																							
												// $postArr['name']=$patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];

												$postArr['first_name']=$patientInfo[0][1];
												$postArr['middle_name']=$patientInfo[0][2];
												$postArr['last_name']=$patientInfo[0][3];

												// $postArr['place']=$patientInfo[0][8];
												// $postArr['age']=$patientInfo[0][4];
												$postArr['gender']=$patientInfo[0][6];
												$postArr['address']=$patientInfo[0][92];
												$postArr['contact_no']=$patientInfo[0][10];
												// $postArr['doctor']="Dr.".$patientInfo[0][15]." ".$patientInfo[0][16];	
												// for email
												// $postArr['email']=$patientInfo[0][11];
												$age_patient=$patientInfo[0][4];
												$age_in=explode(" ",$age_patient);
												$postArr['age']=$age=$age_in[0];
												$postArr['age_type']=$age_type=$age_in[1];
								
														
											}
											if ($type=="IP") {

												// echo 2222;


												$selectCondition[0]="b.`id`='".$ref_no."'";
												// $patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');
												$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition);
												// var_dump($patientInfo);exit;
																							
														// $postArr['name']=$patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];

														$postArr['first_name']=$patientInfo[0][1];
														$postArr['middle_name']=$patientInfo[0][2];
														$postArr['last_name']=$patientInfo[0][3];
														$postArr['place']=$patientInfo[0][8];
														// $postArr['age']=$patientInfo[0][4];
														$postArr['gender']=$patientInfo[0][6];
														$postArr['address']=$patientInfo[0][46];
														$postArr['contact_no']=$patientInfo[0][10];
														// $postArr['doctor']="Dr.".$patientInfo[0][17]." ".$patientInfo[0][18];
																	

														// for email
														// $postArr['email']=$patientInfo[0][11];

														$age_patient=$patientInfo[0][4];
														$age_in=explode(" ",$age_patient);
														$postArr['age']=$age=$age_in[0];
														$postArr['age_type']=$age_type=$age_in[1];

													

														
											}

											$is_field[0]="a.title='Dr'";
											$is_field[1]="a.status= 0 ";	

									$form_creator ->popArr['doctors_info']=$doctors_info=$emp_obj->getEmployee($is_field);



												$form_creator ->popArr['post']=$postArr;

											$form_creator ->formPath ='/templates/nurse/add_ot_schedule.php';			
							
										           break;	





							

                                 


			}
			
			$form_creator->display();
	
	}
	
       
      function save_nursing_station($post) {

              $db_function =new DBFunction();

              $_SESSION['station_id']=$post['station'];
              $_SESSION['station_name']=$db_function->getidToValue("station_name","id",$post['station'],"hcare_nursing_stations");

              $_SESSION['select_station']="";

              $this->viewPage('in_patient_list');
      }
     function add_procedure($post){
              
            $ip_obj=new Inpatient();
             $db_function =new DBFunction();

             $test_id=$post['procedure'];
             $post['test_amount']=$db_function->getidToValue("total","id",$test_id,"hcare_procedure");
             $result = $ip_obj->addIPProcedure($post);

            if($result) { $message="Added Successfully!";}
            else  $message="Failed To Add!";
			
			$postArr['subtab']="ip_procedure";
			$postArr['ipno']=$post['ipno'];
			$postArr['type']=$post['type'];

             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }

     
     function delete_procedure($post){
              
            $ip_obj=new Inpatient();
             
             $result=$ip_obj->deleteIPProcedure($post);

            if($result) { $message="Deleted Successfully!";}
            else  $message="Failed To Delete!";
			
			$postArr['subtab']="ip_procedure";
			$postArr['ipno']=$post['ipno'];
			$postArr['type']=$post['type'];

             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }
     function add_doctor_visit($post){
              
             $ip_obj=new Inpatient();           
             $db_function =new DBFunction();
             
             $post['amount']=0;
             if($post['visit_type'] == "E"){
              
                $post['amount']=$db_function->getidToValue("emergency_visit","emp_id",$post['doctor'],"hcare_doc_fee");

             }else if($post['visit_type'] == "V"){
       
               $post['amount']=$db_function->getidToValue("ip_visit","emp_id",$post['doctor'],"hcare_doc_fee");

             }else if($post['visit_type'] == "S"){

               $post['amount']=$db_function->getidToValue("surgery_charge","emp_id",$post['doctor'],"hcare_doc_fee");
             }else if($post['visit_type'] == "IP BILL"){

               $post['amount']=$db_function->getidToValue("ip_billing_dr","emp_id",$post['doctor'],"hcare_doc_fee");
	       $post['hosp_amt']=$db_function->getidToValue("ip_billing","emp_id",$post['doctor'],"hcare_doc_fee");
             }
           
                $result = $ip_obj->add_doctor_visit($post);

            if($result) { $message="Added Successfully!";}
            else  $message="Failed To Add!";
			
			$postArr['subtab']="doctor_visit";
			$postArr['ipno']=$post['ipno'];
			$postArr['type']=$post['type'];

             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }

     
     function delete_doctor_visit($post){
             $ip_obj=new Inpatient(); 
             
             $result=$ip_obj->delete_doctor_visit($post);

            if($result) { $message="Deleted Successfully!";}
            else  $message="Failed To Delete!";
			
			$postArr['subtab']="doctor_visit";
			$postArr['ipno']=$post['ipno'];
			$postArr['type']=$post['type'];

             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }
    function add_nursing_notes($post){
              
             $ip_obj=new Inpatient();
             $result = $ip_obj->add_nursing_notes($post);

            if($result) { $message="Added Successfully!";}
            else  $message="Failed To Add!";
			
			$postArr['subtab']="nursing_notes";
			$postArr['ipno']=$post['ipno'];

             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }
     
     function delete_nursing_notes($post){
             $ip_obj=new Inpatient();              
             $result=$ip_obj->delete_nursing_notes($post);

            if($result) { $message="Deleted Successfully!";}
            else  $message="Failed To Delete!";
			
            $postArr['subtab']="nursing_notes";
			$postArr['ipno']=$post['ipno'];
             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }
	 
	 function add_room_transfer($post){
	 
	      $ip_obj=new Inpatient(); 
         $com_obj = new CommonFunctions();
	      $room_obj= new Room();
         $db_function =new DBFunction();
		  
         $ipno=$post['ipno'];

         if(!empty($post['room']) && !empty($post['bed_no'])){
        
                                    //check for history
				     $where[]= "ipno = ".$ipno;
                     $roomhist = $ip_obj->getRoomhistory('',$where);

                     // var_dump($roomhist);exit;

				     if(!empty($roomhist)){

					$count = count($roomhist);
					$startdate= $roomhist[$count-1][3];
					$post["startdate"]=$startdate;
					$post["from_time"]=$roomhist[$count-1][13];

                                        
				     }else{

                        $post["startdate"]=$db_function->getidToValue("admission_date","id",$ipno,"hcare_ip_info");

                        //new
                        $post["from_time"]=$db_function->getidToValue("admission_time","id",$ipno,"hcare_ip_info");    

				     }

                                     $post['enddate']=$com_obj->getcurrentTime('h:i a');

                                     //new
                                     $post['to_time']=$com_obj->getcurrentTime('h:i a');
				                     $ip_obj->addIProomHistory($post);

                                     $room_obj->updateBedStatus('FREE',$post['bed_id']);
                                     $room_obj->updateBedStatus('ADMITTED',$post['bed_no']);
               }

             $ip_obj->updateIPRoomInfo($post);			   
	 
	    $postArr['subtab']="room_history";
	    $postArr['ipno']=$post['ipno'];
        $this->viewPage('ip_case_sheet',$post,'',$message);
	 }
     
     function save_physical_examination($post){
		   
		   $dr_obj=new Doctor();
       
           $opno=$post['pid'];
           $doc_id=$post['doc_id'];
           $opid=$post['op_visit_id'];
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
			    $field_value[$k]=$opno;
			    $k++;
			   
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
		  
		    $postArr=array();
	        $postArr['pid']=$opno;
	        $postArr['op_visit_id']=$opid;
	        $postArr['doc_id']=$doc_id;
	        $postArr['subtab']="physical_exam";
            $this->viewPage('op_case_sheet',$postArr);

	 }
     function save_ip_medicines($post){
       
           $dr_obj=new Inpatient();
           $db_obj=new DBFunction();
	  
       
           $ipno=$post['ipno'];
	  
	   	   //save medicines

	   	   // var_dump($post);exit();
	  
		   $mid=$post['medicines_ID'];
		   $m_course=$post['med_course'];
		   $m_days=$post['med_days'];
		   $medicines_name=$post['medicines'];
	   
			 if(count($mid) >0 ){ 
			 
			       if($mid == 0) {
			       		$brand_name=$medicines_name;
			       		$mid = 0;
			       }
				   else{
				   		$brand_name='';
				   } 

			       $dr_obj->save_ip_medicine_prescribed($mid,$brand_name,$m_course,$m_days,$post);


			}


		    $postArr=array();
	        $postArr['ipno']=$ipno;
	        $postArr['subtab']="medicines";
            $this->viewPage('ip_case_sheet',$postArr);
	       }

	     function delete_medicines($post){
	              
	            $ip_obj=new Inpatient();
	             
	             $result=$ip_obj->deleteMedicines($post);

	            if($result) { $message="Deleted Successfully!";}
	            else  $message="Failed To Delete!";
				
				$postArr['subtab']="medicines";
				$postArr['ipno']=$post['ipno'];

	            $this->viewPage('ip_case_sheet',$postArr,'',$message);
	     }

	     	    function edit_nursing_notes($post){
	              
	             $ip_obj=new Inpatient();
	             $result = $ip_obj->edit_nursing_notes($post);

	            if($result) { $message="Added Successfully!";}
	            else  $message="Failed To Add!";
				
				$postArr['subtab']="nursing_notes";
				$postArr['ipno']=$post['ipno'];

	             $this->viewPage('ip_case_sheet',$postArr,'',$message);
	     }


	     function save_ot_schedule($post){
              
             $db_function =new DBFunction();
             $reg_obj= new Registration();

             $doctor_id=$post['doctor_id'];
             $doctor_name=$post['doctor_name'];

             // var_dump($doctors);exit;

             $result = $reg_obj->addOtSchedule($post);

            if($result) { $message="Added Successfully!";}
            else  $message="Failed To Add!";

            if($result !=0){

            	$otInfo[0]=$result;

            if(!empty($doctor_id)){

            	for ($i=0; $i < count($doctor_id); $i++) { 

            		$otInfo[1]=$doctor_id[$i];
            		$otInfo[2]=$doctor_name[$i];
            		
            
            	$result = $reg_obj->addOtScheduleDoctors($otInfo);

            }
            }
         }

         // $postArr['ipno']=$post['ipno'];




             $this->viewPage('manage_ot_schedule',$postArr,'',$message);

             
     }

     function processOtScheduleData($post=null){

     	 // var_dump($post);exit;

     	$reg_obj= new Registration();
     	$form_creator = new Form();
     	 $emp_obj = new Employee();

     	$id=$post['id'];

     	$wheredata[0]="id ='".$id."'";

		$otScheduleInfo=$reg_obj->getOtSchedule($wheredata);

		if(!empty($otScheduleInfo)){

			$post['id']=$id;

			$post['first_name']=$otScheduleInfo[0][3];
			$post['middle_name']=$otScheduleInfo[0][4];
			$post['last_name']=$otScheduleInfo[0][5];
			$age_patient=$otScheduleInfo[0][8];

			$age_in=explode(" ",$age_patient);
								$age1=$age_in[0];
								$age_type=$age_in[1];

			$post['age']=$age1;
			$post['age_type']=$age_type;
			$post['gender']=$otScheduleInfo[0][9];
			$post['contact_no']=$otScheduleInfo[0][7];
			$post['address']=$otScheduleInfo[0][6];
			$post['surgery_name']=$otScheduleInfo[0][1];
			$post['surgery_details']=$otScheduleInfo[0][2];
			$post['surgery_strated_date_time']=$otScheduleInfo[0][10];
			$post['surgery_ended_date_time']=$otScheduleInfo[0][11];
			$post['surgery_status']=$otScheduleInfo[0][12];
			$post['remarks']=$otScheduleInfo[0][13];
			$post['patient_type']=$otScheduleInfo[0][16];
			$post['ref_no']=$otScheduleInfo[0][17];

			// $post['doctors']=$otScheduleInfo[0][1];




		     }

		     $wheredata1[0]="ot_schedule_id ='".$id."'";
		     $wheredata1[1]="status =0";

		$form_creator ->popArr['doctors_list']=$doctors_list=$reg_obj->getOtScheduleDoctors($wheredata1);

	// 	if(!empty($otScheduleDoctorsInfo)){
	
	// 	for($i=0;$i<count($otScheduleDoctorsInfo);$i++) {
		
	// 	{
	// 		$post["doctors_list"][]=$otScheduleDoctorsInfo[$i][0]."/".$otScheduleDoctorsInfo[$i][1]."/".$otScheduleDoctorsInfo[$i][2]."/".$otScheduleDoctorsInfo[$i][3];
	// 	}
	// }


	// 	 }  



 	$is_field[0]="a.title='Dr'";
	$is_field[1]="a.status= 0 ";	

	$form_creator ->popArr['doctors_info']=$doctors_info=$emp_obj->getEmployee($is_field);


		 $form_creator ->popArr['post']=$post;
	 $form_creator ->formPath ='/templates/nurse/add_ot_schedule.php';

	 $form_creator ->formPath ;
	$form_creator->display();  
	}


	function update_ot_schedule($post=null){

		$reg_obj= new Registration();
	 	$ip_obj = new Inpatient();
	 	$emp_obj = new Employee();


   	$doctor_id=$post['doctor_id'];
      $doctor_name=$post['doctor_name'];
      $id=$post['id'];	

	 	$result=$reg_obj->updateOtSchedule($post);

	 	if($result) { 

	 		$message="Successfully Updated!";

	 		$reg_obj->updateOtScheduleDoctors($id);

	 		$otInfo[0]=$id;
	 		if(!empty($doctor_id)){

            	for ($i=0; $i < count($doctor_id); $i++) { 

            		$otInfo[1]=$doctor_id[$i];
            		$otInfo[2]=$doctor_name[$i];

            		$result1 = $reg_obj->addOtScheduleDoctors($otInfo);

            }
            }



	 }else{
	 	$message="Update Failed!";

	 }  

	 $this->viewPage('manage_ot_schedule',$postArr,'',$message);
	}

	function delete_ot_schedule_info($post=null){

		$reg_obj= new Registration();

      $id=$post['id'];	

	 	$result=$reg_obj->deleteOtSchedule($post);

	 	if($result !=0) { 

	 		$message="Data Deleted!";

	 		$reg_obj->deleteOtScheduleDoctors($id);

	 		


	 }else{
	 	$message=" Failed!";

	 }  

	 $this->viewPage('manage_ot_schedule',$postArr,'',$message);

	}

	function add_own_medicines($post){
       
           
           $db_obj=new DBFunction();
           $ip_obj=new Inpatient(); 
	  
       
           $ipno=$post['ipno'];

	   	   // var_dump($post);exit();
	  
		   $drug=$post['drug'];
		   $dose=$post['dose'];
		   $route=$post['route'];
		   $frequency=$post['frequency'];
	   
		

			       $ip_obj->add_own_medicines($drug,$dose,$route,$frequency,$post);


			


		    $postArr=array();
	        $postArr['ipno']=$ipno;
	        $postArr['subtab']="own_medicines";
            $this->viewPage('ip_case_sheet',$postArr);
	       }

	        function edit_own_medicines($post){
	              
	             $ip_obj=new Inpatient();
	             $result = $ip_obj->edit_own_medicines($post);

	            if($result) { $message="Added Successfully!";}
	            else  $message="Failed To Add!";
				
				$postArr['subtab']="own_medicines";
				$postArr['ipno']=$post['ipno'];

	             $this->viewPage('ip_case_sheet',$postArr,'',$message);
	     }

	     function delete_own_medicines($post){
             $ip_obj=new Inpatient();              
             $result=$ip_obj->delete_own_medicines($post);

            if($result) { $message="Deleted Successfully!";}
            else  $message="Failed To Delete!";
			
            $postArr['subtab']="own_medicines";
			$postArr['ipno']=$post['ipno'];
             $this->viewPage('ip_case_sheet',$postArr,'',$message);
     }
	








	
}



?>
