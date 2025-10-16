<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/room/room.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';
require_once ROOT_PATH . '/lib/common/ipFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/procedure/health_package.php';



class BillController {



function viewPage($sub_module,$postArr='',$getArr='',$message=''){

	$form_creator = new Form();
	
	if(!empty ($message)){
		$form_creator ->popArr['message']=$message;
	}
	switch($sub_module){
		
		
		case 'Select_Bill'			:
										
										$reg_obj= new Registration();
										$emp_obj= new Employee();
										$ip_obj= new Inpatient();
										$com_obj = new CommonFunctions();
                                              
                                                                                          
                                                                                          //set default type as OP
                                                                                          if(empty($postArr['type'])) {
                                                                                            
                                                                                             $postArr['type']="OP";
                                                                                          }
                                                                                          
                                                                                          $type=$postArr['type'];
                                                    
                                          if($type == "OP"){

                                          	if (empty($postArr["date"])) {
                                          		$postArr["date"] =  date("Y-m-d");
                                          	}

                                          	$today_date = date("Y-m-d",strtotime($postArr["date"]));
                                          	$yes_date = date('Y-m-d', strtotime('-1 days', strtotime($postArr["date"])));

// var_dump($today_date,$yes_date);
											
											if(!empty($postArr["opno"])){
												$selectCondition[]="a.`id`='".$postArr["opno"]."'";

												   // $selectCondition[]="b.`visit_date` >='".$yes_date." 22:00:00'";
											       // $selectCondition[]="b.`visit_date` <='".$today_date." 23:59:59'";

											}else{
											if(!empty($postArr["date"])){
												// $selectCondition[]="b.`visit_date` like '".date("Y-m-d",strtotime($postArr["date"]))."'";

											      $selectCondition[]="b.`visit_date` >='".$yes_date." 22:00:00'";
											      $selectCondition[]="b.`visit_date` <='".$today_date." 23:59:59'";

											}else{

													// $selectCondition[]="b.`visit_date` like '".date("Y-m-d")."%'";

											      $selectCondition[]="b.`visit_date` >='".$yes_date." 22:00:00'";
											      $selectCondition[]="b.`visit_date` <='".$today_date." 23:59:59'";

											} 												
											
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
												$selectCondition[]="a.`contact_no` LIKE '%".$postArr["telNo"]."%'";
											}
											if(!empty($postArr["doctor"])){
												$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
											}
											$selectCondition[]="b.`cancelled`='0'";
											$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfoNew('',$selectCondition,'b.visit_date','desc');
                                         }else if($type == "IP"){
                                            
                                            
                                                                                                    //search criterias
									            if(isset($postArr['from_date']) ){
									   
													$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
													$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												}else{
													$fromdate=$com_obj->getcurrentDate();
													$todate=$com_obj->getcurrentDate();
										       }	
													
													
													if(!empty($postArr["ipno"])){
														$selectCondition[]="b.`id`='".$postArr["ipno"]."'";
													}
													if(!empty($postArr["opno"])){
												         $selectCondition[]="a.`id`='".$postArr["opno"]."'";
											        }
													if(!empty($postArr["name"])){
														$selectCondition[]="a.`first_name` like '%".$postArr["name"]."%'";
													}
													
													if(!empty($postArr["doctor"])){
														$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
													}
													if(!empty($postArr["room_no"])){
														$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
													}
									              
										       
										       //set search conditions
										       
										      // $selectCondition[]="b.`admission_date`>='".$fromdate."'";
										      // $selectCondition[]="b.`admission_date`<='".$todate."'";
										       $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
										       $selectCondition[]="b.`cancelled`=0";
											   
										       
										       //retrieve patient information
										            $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                                                                                      $form_creator ->popArr['post']=$postArr;
                                                                                              }
											
											$is_field[0]="a.title='Dr'";	

											$form_creator ->popArr['post']=$postArr;												
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											$form_creator ->formPath ='/templates/billing/selectBill.php';
											break;
			case 'Billing_Form'			:	
			                                $db_function =new DBFunction();
			                                $bill_obj =new Billing();
			                                $reg_obj = new Registration();
			                                $ip_obj = new Inpatient();
			                                $emp_obj= new Employee();


			                                if (!empty($postArr['paction'])=="EDIT_BILL") {
			                                	
												$bill_id=$postArr['id'];

												$wheredata[0]="id = ".$bill_id;
												$billInfo=$bill_obj->getBillInfo($wheredata);

												if (!empty($billInfo)) {
													
													$wheredata[0]="bill_id = ".$bill_id;
													$wheredata[1]="status = 0";
													$billitemInfo=$bill_obj->getBillItemsInfo($wheredata);
													
													if (!empty($billitemInfo)) {
														
														for ($i=0; $i <count($billitemInfo) ; $i++) { 
															
															$postArr['particulars_ID'][$i]=$billitemInfo[$i][3]." -".$billitemInfo[$i][4];

															$postArr['particulars'][$i]=$billitemInfo[$i][5];

															$pid[$i] = $billitemInfo[$i][4];
															$ptype[$i] = $billitemInfo[$i][3];
															$particular[$i] = $billitemInfo[$i][5];
															$amount[$i] = $billitemInfo[$i][7];
															$discount_type[$i] = $billitemInfo[$i][8];
															$discount_value[$i] = $billitemInfo[$i][9];
															$final_amount[$i] = $billitemInfo[$i][11];
															$cid[$i] = $billitemInfo[$i][6];
															$test_type[$i] = $billitemInfo[$i][3];
															$null[$i] = 0;
															$dr_amount[$i] = $billitemInfo[$i][14];
															$surgeon_fee[$i] = $billitemInfo[$i][16];
															$price_type[$i] = "";
															$qty[$i] = $billitemInfo[$i][35];
															$gynec_fee[$i] = $billitemInfo[$i][36];
															$room_charges[$i] = $billitemInfo[$i][37];
															
															$postArr["items_in_array"][$i]=$pid[$i]."!$%".$particular[$i]."!$%".$amount[$i]."!$%".$discount_type[$i]."!$%".$discount_value[$i]."!$%".$final_amount[$i]."!$%".$ptype[$i]."!$%".$cid[$i]."!$%".$test_type[$i]."!$%"."0"."!$%".$dr_amount[$i]."!$%".$surgeon_fee[$i]."!$%".$price_type[$i]."!$%".$qty[$i]."!$%".$gynec_fee[$i]."!$%".$room_charges[$i];
															

														}

														$postArr['total_amount']=$billInfo[0][9];
														$postArr['dr_disc']=$billInfo[0][10];
														$postArr['net_amount']=$billInfo[0][11];
														$postArr['payment_mode']=$billInfo[0][12];
														$postArr['amount_paid']="";
														$postArr['card_amount']=$billInfo[0][15];
														$postArr['upi_amount']=$billInfo[0][55];
														// $postArr['payment_mode']=$billInfo[0][12];

														// $postArr['name']=$billInfo[0][3];
														// $postArr['place']=$billInfo[0][6];
														// $postArr['age']=$billInfo[0][4];
														// $postArr['gender']=$billInfo[0][5];
														// $postArr['contact_no']=$billInfo[0][7];
														$postArr['refferal_info']=$billInfo[0][53];
														$postArr['doctor_direct']=$billInfo[0][8];
														$postArr['doctor_direct_ID']=$billInfo[0][54];
														// $postArr['amount_paid']=$billInfo[0][13];
														// $postArr['amount_paid']=$billInfo[0][13];
														// $postArr['amount_paid']=$billInfo[0][13];
														// $postArr['remarks']=$billInfo[0][17];



													}

												}


											$type=$postArr['type_edit'];
											$pid=$postArr['id_edit'];
											 // $pid=$db_function->getidToValue("patient_category","id",$pid,"hcare_ip_info");
											// $pid=$postArr['id'];
											

											if ($type=="OP") {

												$selectCondition[0]="b.`opno`='".$pid."'";
												$patientInfo=$reg_obj->getOPPatientInfoNew('',$selectCondition,'b.id','desc');
																							
												$postArr['name']=$patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];
												$postArr['place']=$patientInfo[0][8];
												$postArr['age']=$patientInfo[0][4];
												$postArr['gender']=$patientInfo[0][6];
												$postArr['contact_no']=$patientInfo[0][10];
												$postArr['doctor']="Dr.".$patientInfo[0][15]." ".$patientInfo[0][16];	
												// for email
												$postArr['email']=$patientInfo[0][11];

												$postArr['ins_id']=$patientInfo[0][22];								
														
											}
											if ($type=="IP") {


												$selectCondition[0]="b.`id`='".$pid."'";
												// $patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');
												$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
																							
														$postArr['name']=$patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];
														$postArr['place']=$patientInfo[0][8];
														$postArr['age']=$patientInfo[0][4];
														$postArr['gender']=$patientInfo[0][6];
														$postArr['contact_no']=$patientInfo[0][10];
														$postArr['doctor']="Dr.".$patientInfo[0][17]." ".$patientInfo[0][18];
														$postArr['doc_id_prescribed']=$patientInfo[0][16];
														$postArr['ins_id']=$patientInfo[0][23];				

														// for email
														$postArr['email']=$patientInfo[0][11];

														$postArr['ins_id']=$patientInfo[0][23];

														
											}


											if ($type=="DIRECT") {
											$patientInfo = $reg_obj->getPatientOnlineInfoDirect($pid);
												$ageInfo=$patientInfo[0][2];
												$age_in=explode(" ",$ageInfo);
												$age=$age_in[0];
												$age_type=$age_in[1];
											// var_dump($patientInfo);
												$postArr['name']=$patientInfo[0][1];
												$postArr['place']=$patientInfo[0][4];
												$postArr['age']=$age;
												$postArr['age_type']=$age_type;
												$postArr['gender']=$patientInfo[0][3];
												$postArr['contact_no']=$patientInfo[0][5];
												// $postArr['doctor']="Dr.".$patientInfo[0][15]." ".$patientInfo[0][16];	
												$postArr['email']=$patientInfo[0][9];

											}

											$postArr['type']=$type;


			                                }
			                                else{


											$type=$postArr['type'];
											if (!empty($postArr['id'])) {
												$pid=$postArr['id'];
											}
											
											
											if($type == "OP") {
											
												$postArr=$this->processOP($pid);
										
												if(empty($postArr['payment_mode']) && $postArr['ins_id']>0){
													$postArr['payment_mode']="INSURANCE";
												}

                                               
												
											}
                                        //if patient type is ip
                                        if($type == "IP") {

                                         $pres_date=$postArr['ip_prescribed_date'];
                                                    
                                         $postArr=$this->processIP($pid,$pres_date);

										  if(empty($postArr['payment_mode']) && $postArr['ins_id']>0){
														$postArr['payment_mode']="INSURANCE";
										  }

                                                    
                                        }
										
							if($type == "IP") {

                                      $postArr['patient_cat_id']=$db_function->getidToValue("patient_category","id",$pid,"hcare_ip_info");

		                            $postArr['patient_cat_name']=$db_function->getidToValue("patient_category","id",$postArr['patient_cat_id'],"hcare_patient_category");
                                       
							}	

							if ($type == "DIRECT") {
								
								$is_field_doc = array();
								$is_field_doc[0]="a.title='Dr'";												
                        $form_creator ->popArr['doctorsDirect']=$emp_obj->getEmployee($is_field_doc);	

							}		



											$postArr['type']=$type;
											$postArr['paction'] = "ADD";


			                                }


											$form_creator ->popArr['post']=$postArr; 
											
											$form_creator ->formPath ='/templates/billing/billing_form.php';
											break;
			case 'Manage_Billing'		:
											$bill_obj=new Billing();
											$user_obj=new User();
											$db_function =new DBFunction();
											$reg_obj= new Registration();
											$pagi_obj = new Pagination();
											$k=0;
										
											if(!empty($postArr['from_date'])) {

												if( ($postArr['type']=='IP' || $postArr['type']=='OP')  && !empty($postArr['ref_no'])){
													$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
													$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
												
										          	} else{
												
												$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
												$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
												
										         	}
										         }

											else{
												$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
												$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
											}
										
											if(!empty($postArr['billno'])) {
												$wheredata[$k++]="id ='".$postArr['billno']."'";
											}
											if(!empty($postArr['status'])) {
												$wheredata[$k++]="status ='".$postArr['status']."'";
											}else {
                                                  $postArr['status']=0;
                                                  $wheredata[$k++]="status ='0'";
                                              }
											if(!empty($postArr['type'])) {
												$wheredata[$k++]="type ='".$postArr['type']."'";
												
											}
											if(!empty($postArr['user'])) {
												$wheredata[$k++]="user_id ='".$postArr['user']."'";
												
											}


                                 if(!empty($postArr['type']) && ($postArr['type']=='DIRECT' || $postArr['type']=='IP')) {
                                              	

										
												$wheredata[$k++]="type ='".$postArr['type']."'";
													if(!empty($postArr['ref_no'])) {
														$wheredata[$k++]="ref_no ='".$postArr['ref_no']."'";


													}
											}
											if(!empty($postArr['type']) && $postArr['type']=='OP') {
											    	$wheredata[$k++]="type ='".$postArr['type']."'";
													if(!empty($postArr['ref_no'])) {
														$wheredata[$k++]="opno ='".$postArr['ref_no']."'";														
													}
											}

											$user_type_logged_in=$_SESSION['user_type'];
											$user_type_id=$_SESSION['user_type_id'];
											$user_data=array();

											if(!empty($postArr['user_type'])) {
											
											$user_data[]="user_type='".$postArr['user_type']."'";
											}


                                    
											
											// var_dump($user_type_logged_in);

											if($user_type_logged_in !='RECEPTION'){

													if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){	

														// echo 11;

														// echo $postArr['user_type'];

														

														if($user_type_id == 6 && (empty($postArr['user_type']))){ 

															 $user_data[0]="user_type='".$user_type_id."'"." or "."user_type='7'";

														}else if(!empty($postArr['user_type']) && ($user_type_id == 6 && $postArr['user_type'] == 6)){

															$user_data[0]="user_type='".$postArr['user_type']."'";

														}else if(!empty($postArr['user_type']) && ($user_type_id == 6 && $postArr['user_type'] == 7)){ //echo 33;

															$user_data[0]="user_type='".$postArr['user_type']."'";

														}else if($user_type_id == 13 && (empty($postArr['user_type']))){ 

															 $user_data[0]="user_type='".$user_type_id."'"." or "."user_type='11'";

														}else if(!empty($postArr['user_type']) && ($user_type_id == 13 && $postArr['user_type'] == 13)){

															$user_data[0]="user_type='".$postArr['user_type']."'";

														}else if(!empty($postArr['user_type']) && ($user_type_id == 13 && $postArr['user_type'] == 11)){

															$user_data[0]="user_type='".$postArr['user_type']."'";

														}else{ 
															$user_data[0]="user_type='".$user_type_id."'";
														}

													

													 
													 }
													}
													// var_dump($user_data);


													 if($user_type_logged_in =='RECEPTION'){

													 	if(!empty($postArr['user_type']) && $postArr['user_type'] != 4) { 
													 		// echo 22;

													 	// 	if($postArr['user_type'] == 6) {
													 
													 	// 	$user_data[0]="user_type='".$postArr['user_type']."'"." or "."user_type='7'";
													 	// }
													 	// else if ($postArr['user_type'] == 11 || $postArr['user_type'] == 13) {
													 	// 	$user_data[0]="user_type='11' or user_type='13'";
													 	// }else 
													 	$user_data[]="user_type='".$postArr['user_type']."'";
											
																
														}else if(empty($postArr['user_type'])){ 
															// echo 33;
															$user_data[]="user_type='1' or user_type='2' or user_type='3' or user_type='4' or user_type='5' or user_type='6' or user_type='7' or user_type='11' or user_type='12' or user_type='13'";

														}
														
														//var_dump($userdata);
													
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
											
											
											if( $user_type_logged_in =='CASUALITY' || $user_type_logged_in =='XRAY'   ){
											    $wheredata[$k++]="user_id ='".$_SESSION['user_id']."'";
											 }


											 



											// $contact_number = "8086588640";

											$contact_number = $postArr['contact_number'];

											if (!empty($contact_number)) {

												$id_direct = array();

												$wheredata_direct = array();
												$wheredata_direct[0] = "contact_no LIKE '%".$contact_number."%'";
												
												$id_direct_array = $bill_obj->getDirectCustomers($wheredata_direct);

												if (!empty($id_direct_array)) {
													
													for ($i=0; $i < count($id_direct_array) ; $i++) { 
														
														$id_direct[]=$id_direct_array[$i][0];

													}

													$id_direct = implode(",", $id_direct);

	
												}

												$id_others = array();

												$wheredata_others = array();
												$wheredata_others[0] = "a.contact_no LIKE '%".$contact_number."%'";
												$id_others_array = $reg_obj->getOPPatientInfo('',$wheredata_others);

												if (!empty($id_others_array)) {
													
													for ($i=0; $i < count($id_others_array) ; $i++) { 
														
														$id_others[]=$id_others_array[$i][0];

													}

													$id_others = implode(",", $id_others);

	
												}

												$wheredata = array();
												$wheredata[0]="status = 0";

												if (!empty($id_direct) && !empty($id_others)) {
													$wheredata[1]="ref_no in ($id_direct) or opno in ($id_others)";
												}
												else if (!empty($id_direct) && empty($id_others)) {
													$wheredata[1]="ref_no in ($id_direct)";
												}
												else if (empty($id_direct) && !empty($id_others)) {
													$wheredata[1]="opno in ($id_others)";
												}

												


											}

											//for user type

											 $where_user_type=array();
											 if($user_type_logged_in !='RECEPTION' && $user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){
											 	if($user_type_id == 6) {
													 
													 		$where_user_type[]="id='".$user_type_id."'"." or "."id='7'";
													 	}
													 	else if ($user_type_id == 13) {
													 		$where_user_type[]="id='11' or id='13'";
													 	}else{
													 		$where_user_type[]="id='".$user_type_id."'";

													 	}
											 
											}

											 $form_creator ->popArr['user_type']=$user_obj->getUsertype($where_user_type);

											
											$user_id_selected = array();

											$form_creator ->popArr['post']=$postArr;
											$form_creator ->popArr['user']=$userSel=$user_obj->getUser('',$user_data);
											// var_dump($userSel);

											if (!empty($userSel)) {
												
												for ($i=0; $i < count($userSel) ; $i++) { 
													$user_id_selected[] = $userSel[$i][0];
												}

												$user_id_selected = implode(",", $user_id_selected);

											}

											if($user_type_logged_in =='NURSE' || $user_type_logged_in =='SUPER NURSE'){
											    $wheredata[$k++]="user_id in ($user_id_selected)";
											 }

											 if($user_type_logged_in =='LAB ADMIN' || $user_type_logged_in =='LAB USER'){
											    $wheredata[$k++]="user_id in ($user_id_selected)";
											 }

											 if(!empty($postArr['user_type'])) {
														$wheredata[$k++]="bill_entered_user_type_id ='".$postArr['user_type']."'";


													}


											 
											

											 /*...............pagination..............*/		
			                            $perPage=50;
			                            if(empty($postArr['current_page'])) 
                                            {
                                            	   $current_page =1;	
                                            }
                                        else{ 
                                            	   $current_page = $postArr['current_page']; 
                                            }

                                        $limit=$pagi_obj->pageLimit($current_page,$perPage); 

								        $next_page=explode(",",$limit);

								        $form_creator ->popArr['next_page']=$next_page[0];

                                        $bill_count=$bill_obj->getBillCountNew($wheredata);
									/*...............pagination..............*/	

									 $form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($bill_count,$current_page,$perPage);

									    $form_creator ->popArr['current_page']=$current_page;
											
									    // var_dump($bill_count);

											$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata,'id','desc','',$limit);
											 $where[0]="ipno='".$postArr['ref_no']."'";
											$form_creator ->formPath ='/templates/billing/manage_billing.php';
											break;
				case 'change_item_amount_form':
				                               $proc_obj=new Procedure();
				                               $itemid=$getArr['itemid'];
											   $post['itemid']=$itemid;
											   $post['pos']=$getArr['pos'];
											   
											   if(!empty($_SESSION['changeamt'][$post['pos']])){
											    
											   }else{
											   
											    $wheredata[0]="id=".$itemid;
												$form_creator ->popArr['procedureInfo']=$proc_obj->getProcedure('',$wheredata);
											  }
												$form_creator ->popArr['post']=$post;
				                               $form_creator ->formPath ='/templates/billing/change_item_amount_form.php';
											   break;
				                            
				case 'Credit_Billing'		:
											$bill_obj=new Billing();
											$user_obj=new User();
											$k=0;
											if(!empty($postArr['from_date'])) {
											
												$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
												$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
											}else{
												$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
												$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
											}
											if(!empty($postArr['billno'])) {
												$wheredata[$k++]="id ='".$postArr['billno']."'";
											}													
											if(!empty($postArr['type']) && ($postArr['type']=='DIRECT' || $postArr['type']=='IP')) {
												$wheredata[$k++]="type ='".$postArr['type']."'";
													if(!empty($postArr['ref_no'])) {
														$wheredata[$k++]="ref_no ='".$postArr['ref_no']."'";														
													}
											}
											if(!empty($postArr['type']) && $postArr['type']=='OP') {
												$wheredata[$k++]="type ='".$postArr['type']."'";
													if(!empty($postArr['ref_no'])) {
														$wheredata[$k++]="opno ='".$postArr['ref_no']."'";														
													}
											}
										
											/*if(!empty($postArr['patient_name'])) {
												$wheredata[$k++]="type ='".$postArr['type']."'";
												
											}*/

											
											$wheredata[$k++]="status ='0'";
											$wheredata[$k++]="credit > 0";
                                                                                                  //$wheredata[$k++]="type !='IP'";
											
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->popArr['user']=$user_obj->getUser();
											$form_creator ->popArr['billInfo']=$a=$bill_obj->getBillInfo($wheredata,'','',true);
											// var_dump($a);
											 $where[0]="ipno='".$postArr['ref_no']."'";

											
											$form_creator ->formPath ='/templates/billing/credit_billing.php';
											break;
				case 'Manage_Credit_Billing'		:
				                           $bill_obj=new Billing();
											$user_obj=new User();
											$k=0;
											if(!empty($postArr['from_date'])) {
											
												$wheredata[$k++]="b.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
												$wheredata[$k++]="b.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
											}else{
												$wheredata[$k++]="b.bill_date >='".date("Y-m-d")." 00:00:00'";
												$wheredata[$k++]="b.bill_date <='".date("Y-m-d")." 23:59:59'";
											}
											if(!empty($postArr['billno'])) {
												$wheredata[$k++]="b.bill_no ='".$postArr['billno']."'";
											}


											if(!empty($postArr['status'])) {
												$wheredata[$k++]="b.status ='".$postArr['status']."'";
											}else {
                                                  $postArr['status']=0;
                                                  $wheredata[$k++]="b.status ='0'";
                                              }


											if(!empty($postArr['type'])) {
												$wheredata[$k++]="a.type ='".$postArr['type']."'";
												
											}
											if(!empty($postArr['ref_no'])) {
												$wheredata[$k++]="a.ref_no ='".$postArr['ref_no']."'";
												
											}

                                                                                   $user_data=array();
                                                                              //USER TYPE RESTRICTION
									$user_type=$_SESSION['user_type'];

								if(!empty($postArr['user_type'])) {
												
								      $user_data[]="a.user_type='".$postArr['user_type']."'";
                                                                          }else{

                                 if(($user_type !='ADMIN' && $user_type !='ADMIN+DOCTOR')&& empty($postArr['user_type'])){
											
												
												
												
									//IF USER LOGGED IN IS LAB ADMIN SHOW LAB USER IN USERTYPE DROPDOWN
									if($user_type == "LAB ADMIN"){
													
										$user_data[]="b.user_type='LAB ADMIN' or b.user_type='LAB USER'";

									}else{
													
										$user_data[]="b.user_type='".$user_type."'";
												
									}
												
								  }

                                                                          }                                                                                                                                             
                                                                                            														
                                                            
												
								$userInfo=$user_obj->getfullUserInfo($user_data);
													
								    if(count($userInfo) >0){
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
									$wheredata[$k++]="b.user_id in $user_id";
								}else $wheredata[$k++]="b.user_id in (0)";
												
												
											
												
											
											
											// $wheredata[$k++]="a.status ='0'";
											$wheredata[$k++]="a.credit > 0";
											$wheredata[$k++]="b.status = 0";
											
											
											
											$user_type_info=array();
											
										    if(($user_type !='ADMIN' && $user_type !='ADMIN+DOCTOR') ){
											
												
												
												
												//IF USER LOGGED IN IS LAB ADMIN SHOW LAB USER IN USERTYPE DROPDOWN
												if($user_type == "LAB ADMIN"){
													
													$user_type_info[]="user_type='LAB ADMIN' or user_type='LAB USER'";

												}else{
													
													$user_type_info[]="user_type='".$user_type."'";
												
												}
												
											}
											
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
											$form_creator ->popArr['billInfo']= $creditInfo = $bill_obj->getfullCreditInfo($wheredata);
											$credit_amt=0;

											if (!empty($creditInfo)) {

                                                        for ($i=0; $i <count($creditInfo) ; $i++) { 

                                                        	$where_credit[0] = "bill_no = ".$creditInfo[$i][16];
                                                        	$where_credit[1] = "status = 0";


                                                                  
                                                        		$credit_sum[$i] = $bill_obj->getCreditBillInfo($where_credit);

                                                        		// var_dump($credit_sum[$i]);

                                                        		if (!empty($credit_sum[$i])) {
                                                        			
                                                        			for ($j=0; $j <count($credit_sum[$i]) ; $j++) { 
                                                        				
                                                        					$credit_sum_total[$i][$j] += $credit_sum[$i][$j][3];

                                                        					

                                                        			}

                                                        			$credit_sum_total[$i] = array_sum($credit_sum_total[$i]);
                                                        				
                                                        		}


                                                        }

											}


                                                       // var_dump($credit_sum_total); 
                                                         // $credit_amt=$credit_amt+$credit_amt;
											//var_dump($credit_amt);
                                                $form_creator ->popArr['credit_sum_total']=$credit_sum_total;
                                                $form_creator ->popArr['user']=$user_obj->getUser();
                                               // var_dump($credit_sum_total); 
											$form_creator ->formPath ='/templates/billing/manage_credit_billing.php';
											break;
				case 'Print_Bill'		: 
											$bill_obj=new Billing();
											$db_function =new DBFunction();
											
											if(!empty($postArr['billid'])){
												$wheredata[0]="id ='".$postArr['billid']."'";
												$wheredataitem[0]="bill_id ='".$postArr['billid']."'";
											}elseif(!empty($postArr['id'])){
												$wheredata[0]="id ='".$postArr['id']."'";
												$wheredataitem[0]="bill_id ='".$postArr['id']."'";
											}
											
											$form_creator ->popArr['billInfo']=$bill_info=$bill_obj->getBillInfo($wheredata);
                                              
                                              $patient_type=$bill_info[0][1];
                                               	
                                              if($patient_type=='OP'){

                                                 $patient_id=$db_function->getidToValue("patient_category","id",$bill_info[0][2],"hcare_op_visit_info");
                                   
                                              }
                                              if($patient_type=='IP'){
                                          
                                                 $patient_id=$db_function->getidToValue("patient_category","id",$bill_info[0][2],"hcare_ip_info");

                                              }

                                              if($patient_id>0)
                                                  {
                                                    $pat_cat_name=$db_function->getidToValue("patient_category","id",$patient_id,"hcare_patient_category");
                                                    $form_creator ->popArr['patient_category']=$pat_cat_name;
                                                  }
											$form_creator ->popArr['billitemInfo']=$bill_obj->getBillItemsInfo($wheredataitem);
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->formPath ='/templates/billing/print_bill.php';
											break;
				case  'Print_IP_Bill'           :
				                                        $bill_obj=new Billing();
				                                        $ip_obj= new Inpatient();
														$ipfunc_obj= new IpFunctions();
													 if(!empty($postArr['id'])){
													 
													     $wheredata[0]="ipno ='".$postArr['id']."'";
														 $wheredata[1]="(bill_status !=1 and bill_status !=3)";
													 }
				                                    if(!empty($postArr['billid'])){
										                 $wheredata[0]="id ='".$postArr['billid']."'";
										                 
									               }
									    $form_creator ->popArr['billInfo']=$billInfo=$bill_obj->getIPBillInfo($wheredata);
									   if(!empty($billInfo)){
									                $ipno=$billInfo[0][1];
													
													$wheredataitem[0]="billno ='".$billInfo[0][0]."'";
													
									                $selectCondition[]="b.`id`='".$ipno."'";
                                                               
										       
                                             //retrieve patient information
                                                     $form_creator ->popArr['patient_info'] =$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
													 $form_creator ->popArr['billitems']=$bill_obj->getIPBillItems($wheredataitem);
													 $form_creator ->popArr['post']=$postArr;
                                                                
                                         }
                                         if($postArr['id']){
                                         	$ipno = $postArr['id'];
                                         }
                                         else{
                                         	$ipno=$billInfo[0][1];
                                         }

										$form_creator ->popArr['s_billInfo']=$s_billInfo=$bill_obj->get_S_IPBillInfo($ipno);
                                         //THEATRE PROCEDURE Details  
													$wheredata=array();
											   $wheredata[0]="b.type = 'P'";	  
	                                           $wheredata[1]="a.type='IP'";
											   $wheredata[2]="b.category_id=4"; 
			                                   $wheredata[3]="a.ref_no='".$ipno."'"; 
	                                           $wheredata[4]="a.status=0";																	   
	                                           $groupby="b.type,b.test_id,b.category_id";                                                            
	                                           $theatre_procedure=$bill_obj->getBillTheatreProcedure_details($wheredata,$groupby);
												$form_creator ->popArr['theatre_procedure']=$theatre_procedure;    
												//specialist consultation details	
											   $docondn[0]="status = 0";
									            $docondn[1]="ipno = '".$ipno."'";
									            $specialist=$ip_obj->getDoctorVisit('',$docondn,'doctor','asc');
									            $form_creator ->popArr['doc_visits']=$specialist;   

												//nursing procedure details
												
		                                            $procondn[0]="status = 0";
										            $procondn[1]="ipno = '".$ipno."'";
										            $ipProcedure=$ip_obj->getIPProcedure('',$procondn,'procedure_test','asc');		
													$form_creator ->popArr['nurse_added_procedures_details']=$ipProcedure; 
													
													//medicine charges
											$phwhere[]="cust_type = 'IP'"; 
											$phwhere[]="ip_no = '".$ipno."'"; 
											 $phwhere[]="status = '0'";
											$pharmaInfo=$bill_obj->getpharmaBill($phwhere,'','1');
											$form_creator ->popArr['pharmaInfo']=$pharmaInfo;
                                             
											//wheather to print detailed bill
												$form_creator ->popArr['print_status'] = $postArr['print_status'];                              
                                        
							            $form_creator ->formPath ='/templates/billing/print_ip_bill.php';
											
				                                        
				                                        break;
				case 'ip_bill_items_list'  :
				                            $bill_obj=new Billing();
											$pagi_obj = new Pagination();
											
											 $wheredataitem[0]="item_id >23";
											 $wheredataitem[1]="item_type !='procedure' ";
											 $wheredataitem[2]="status =0 ";
											 
											 if(!empty($postArr['bill_no'])){
													 
													     $wheredataitem[]="billno ='".$postArr['bill_no']."'";
														
											 }
											 if(!empty($postArr['particulars'])){
													 
													     $wheredataitem[]="particulars ='".$postArr['particulars']."'";
														
											 }
											
										//pagination
									    $testCount=$bill_obj->getIPBillItemCount($wheredataitem);
										$form_creator ->popArr['perPage']=$perPage=$pagi_obj->perPage=30;//$pagi_obj->perPage;	

                                          if(empty($postArr['current_page'])) $current_page =1;			
	                                    else $current_page = $postArr['current_page'];
	
			
	                                   //set limit value for query
	                                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                         $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($testCount,$current_page);	
                                         $form_creator ->popArr['current_page']=$current_page;
											
                                             $form_creator ->popArr['post']=$postArr;
                                              $form_creator ->popArr['billitems']=$bill_obj->getIPBillItems($wheredataitem,$limit);
                                                                
                                               

                                              $form_creator ->formPath ='/templates/billing/view_ip_bill_items.php';   
				                               break; 

				case 'update_ip_addon_field'  :  
				                             $form_creator ->popArr['field_id']=$getArr['item_id'];
											 $form_creator ->popArr['particular']=$getArr['particular'];


				                           $form_creator ->formPath ='/templates/billing/update_new_field.php';
				                 break;    
				
				case 'Print_Advance_Bill'		:
											$bill_obj=new Billing();
											
											
											
											
											if(!empty($postArr['billid'])){
												$wheredata[0]="id ='".$postArr['billid']."'";
												
												$form_creator ->popArr['billInfo']=$bill_obj->getAdvancePayments($wheredata);
												
											}else $form_creator ->popArr['message'] ="Bill Does Not Exist!";
											 $form_creator ->popArr['post'] =$postArr;
											$form_creator ->formPath ='/templates/billing/print_advance_bill.php';
											break;
											
				case 'Credit_Payment_Form'		:
																							
											$form_creator ->popArr['post']=$this->processBillNo($postArr,'credit_payment_form');
											$form_creator ->formPath ='/templates/billing/credit_payment_form.php';
											break;
				case 'Add_Credit'	:
												$bill_obj=new Billing();
												
												if(empty($postArr['new_date'])) $postArr['new_date']=date("d-m-Y");
												$postArr['id']=$bill_obj->addCredit($postArr);
												
				case 'Print_Credit_Bill_New' :     $bill_obj=new Billing();  
				                                $where[0]="id ='".$postArr['id']."'";
				                                $where[1]="status=0";
				                                $form_creator ->popArr['creditInfo']=$bill_obj->getCreditBillInfo($where);
                                                  $wheredata[0]="id ='".$postArr['billid']."'";
												$form_creator ->popArr['billInfo']=$billInfo=$bill_obj->getBillInfo($wheredata);

												if (!empty($billInfo)) {

													$wheredata[0]="bill_id ='".$postArr['billid']."'";
													$form_creator ->popArr['billItemInfo']=$billItemInfo=$bill_obj->getBillItemsInfo($wheredata);

												}

												$form_creator ->popArr['post']=$postArr;
												$form_creator ->formPath ='/templates/billing/print_credit_bill.php';						
				                              break;
												
				case 'Print_Credit_Bill' :     $bill_obj=new Billing();  
				                                $where[0]="id ='".$postArr['id']."'";
				                                $where[1]="status=0";
				                                $form_creator ->popArr['creditInfo']=$bill_obj->getCreditBillInfo($where);
                                                  $wheredata[0]="id ='".$postArr['billid']."'";
												$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata);
												$form_creator ->popArr['post']=$postArr;
												$form_creator ->formPath ='/templates/billing/print_credit_bill.php';						
				                              break;



				case 'Add_Multiple_Credit'	:
												
								               $this->addMultipleCredit($postArr);
												
												
				                                                                break;
				                                                                
			      case 'IP_Search'            :                   
			                            $emp_obj= new Employee();
										$ip_obj= new Inpatient();
										$com_obj = new CommonFunctions();
			                                                          
										      

									            if(!empty($postArr['from_date']) ){
									   
													$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
													$selectCondition[]="b.`admission_date`>='".$fromdate."'";
										            
									              }else{

                                                        $postArr['from_date']='';
                                                    }


									            if(!empty($postArr['to_date']) ){
									   
													$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
										            $selectCondition[]="b.`admission_date`<='".$todate."'";
										            
									              }else{

                                                        $postArr['to_date']='';
                                                    }

													if(!empty($postArr["ipno"])){
														$selectCondition[]="b.`id`='".$postArr["ipno"]."'";
													}
													if(!empty($postArr["name"])){
														$selectCondition[]="a.`first_name` like '%".$postArr["name"]."%'";
													}
													
													if(!empty($postArr["doctor"])){
														$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
													}
													if(!empty($postArr["room_no"])){
														$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
													}


										       //set search conditions
										       
										       
										       $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
										       $selectCondition[]="b.`cancelled`=0";
										       
										       //retrieve patient information
										            $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
										            
                                                                                                      $form_creator ->popArr['post']=$postArr;
                                                                                                      
                                                                                                      $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
                                                                                                      
			                                                              $form_creator ->formPath ='/templates/billing/ip_patient_list.php';
											break;
			case 'Advance_Payment_Form'     :
			                                  $ip_obj= new Inpatient();
											  $ipfunc_obj= new IpFunctions();
                                                               
                                                                
			                                  //Patient Info
                                                                
                                                                $selectCondition[]="b.`id`='".$postArr["id"]."'";
                                                               // $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date`='')";
                                                                //$selectCondition[]="b.`cancelled`=0";
										       
                                                                //retrieve patient information
                                                                $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                                                	   
			                                   $postArr=$ipfunc_obj->calculateBill($postArr);
			                                   $form_creator ->popArr['post']=$postArr;
                                                $form_creator ->formPath ='/templates/billing/advance_payment_form.php';
                                                               
			                                          break;
			case  'Manage_Advance_Payments'  :$bill_obj= new Billing();
			                                  $k=0;
					                           
											if(!empty($postArr['billno'])) {
												$wheredata[$k++]="id ='".$postArr['billno']."'";
											}
											if(!empty($postArr['ipno'])) {
												$wheredata[$k++]="ipno='".$postArr['ipno']."'";
											}

											if(empty($wheredata)){
												if(!empty($postArr['from_date'])) {
													$wheredata[$k++]="date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
													$wheredata[$k++]="date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
												}else{
											   		$wheredata[$k++]="date >='".date("Y-m-d")." 00:00:00'";
											   		$wheredata[$k++]="date <='".date("Y-m-d")." 23:59:59'";
												}

												if(!empty($postArr['bill_status'])) {
											        $wheredata[$k++]="status='".$postArr['bill_status']."'";
												}else {
													$wheredata[$k++]="status=0";
													$postArr['bill_status']=0;
												}

											}else{
												if(!empty($postArr['bill_status'])) {
											       	$wheredata[$k++]="status='".$postArr['bill_status']."'";
												}else {
													$wheredata[$k++]="status=0";
													$postArr['bill_status']=0;
												} 
											}
											 
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->popArr['billInfo']=$bill_obj->getAdvancePayments($wheredata);
											$form_creator ->formPath ='/templates/billing/manage_advance_payments.php';

											 break;
		     case 'Prepare_Final_Bill'     :
			                                  $ip_obj= new Inpatient();
			                                  $bill_obj= new Billing();
											  $ipfunc_obj= new IpFunctions();
											
			                                  
			                                  if($postArr['id'] && $postArr['id']!=''){
			                                  		$postArr["id"]=$postArr["id"];
			                                  }
			                                  else if($postArr['ipno'] && $postArr['ipno']!=''){
			                                  		$postArr["id"]=$postArr["ipno"];
			                                  }
			                                  
			                                  //check request for json
                                                               
                                             if($postArr['paction'] == "json"){
                                                                
                                                 $this->processFinalForm($postArr);	                                                                   
                                             }else{ 
											
											 $itemName=array();
											 $itemAmount=array();
											 $pops=array();
															   
											/*	$wheredata[0]="ipno='".$postArr['id']."'";
                                                  $wheredata[1]="(bill_status !=1 and bill_status !=3)";														
                                                 $billInfo=$bill_obj->getIPBillInfo($wheredata);
												
												//check bill already prepared
												
												    if(!empty($billInfo)){
													
													 //bill prepared
													 
													 $bill_id=$billInfo[0][0];
													 
													 $wheredataitem[0]="billno='".$bill_id."'";
													 $billItemInfo=$bill_obj->getIPBillItems($wheredataitem);
													 
													 if(!empty($billItemInfo)){
													 
													   for($i=0;$i<count($billItemInfo);$i++){
													   
													     $itemName[$billItemInfo[$i][4]]=$billItemInfo[$i][2];
														 $itemAmount[$billItemInfo[$i][4]]=$billItemInfo[$i][3];
														 
														
													   
													   }
													 }
													
													
													}else{*/
													
													//bill not prepared
                                                                $total_amt=0;
			                                  //Patient Info
                                                                $postArr['bill_prepare_date']=date("d-m-Y");
                                                                $selectCondition[]="b.`id`='".$postArr["id"]."'";
                                                                //$selectCondition[]="(b.`discharge_date`!='0000-00-00' OR b.`discharge_date`!='')";
                                                                //$selectCondition[]="b.`cancelled`=0";
										       
                                                                //retrieve patient information
                                                                $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                                                
                                                                
                                                                //THEATRE PROCEDURE
															   $wheredata=array();
															   $wheredata[0]="b.type = 'P'";	  
                                                                $wheredata[1]="a.type='IP'";
															   $wheredata[2]="b.category_id=4"; 
							                                   $wheredata[3]="a.ref_no='".$postArr['id']."'"; 
                                                                 $wheredata[4]="a.status=0";
                                                                 $wheredata[5]="a.paid_with='CREDIT'";
                                                                 	   
                                                                  
                                                                
                                                                $groupby="b.type,b.test_id,b.category_id";                                                            
                                                                $theatre_procedure=$bill_obj->getBillTheatreProcedure($wheredata,$groupby);
                                                                // var_dump($theatre_procedure);

                                                if (!empty($theatre_procedure)) {

	                                               for($ss = 0; $ss<sizeof($theatre_procedure);$ss++){

	                                                if (!empty($theatre_procedure) && $theatre_procedure[$ss][10] ==0) {

																	   $itemAmount[0]+=$theatre_procedure[$ss][1];
																	   $itemAmount[1]+=$theatre_procedure[$ss][2];
																	   $itemAmount[2]+=$theatre_procedure[$ss][4];
																	   $itemAmount[3]+=$theatre_procedure[$ss][3];
																	   $itemAmount[4]+=$theatre_procedure[$ss][5];
																	   // $itemAmount[25]+=$theatre_procedure[$ss][11];
																	   // $itemAmount[26]+=$theatre_procedure[$ss][12];
																		}
																	}
                                                }

															   
															   
															   $postArr=$ipfunc_obj->calculateBill($postArr);
															   
                                                                $itemAmount[5]=$postArr['medicine_charges'];
															   $itemAmount[6]=$postArr['doc_visit_amt'];
															   
															   //xray bill item details
                                                                
                                                                $wheredata=array();
                                                                $wheredata[0]="b.type = 'P'";	  
                                                                $wheredata[1]="b.category_id=2"; 
                                                                $wheredata[2]="a.type='IP'";
							                                   $wheredata[3]="a.ref_no='".$postArr['id']."'";
																   $wheredata[4]="a.status=0";   
                                                                 
                                                                  
                                                                 $groupby="b.category_id";                                                             
                                                                // $xray=$bill_obj->getBillItemPatient($wheredata,$groupby);
                                                                   $xray=$bill_obj->getBillItemLab($wheredata);
                                                                
                                                                   	$tot_xray = 0;
                                                           for($s=0;$s<count($xray);$s++){
																				if($xray[$s][2]-$xray[$s][3]!=0){

																					$tot_xray = $tot_xray+$xray[$s][4]-$xray[$s][5];
																				}
																			}
                                                                // var_dump($xray);
                                                                
                                                                 // if(!empty($xray)) $postArr['xray_charges']=$xray[0][0];
																			  if(!empty($xray)) $postArr['xray_charges']=$tot_xray;
																
															   $itemAmount[7]=$postArr['xray_charges'];
															   
															   //lab bill item details
                                                                
                                                                 $wheredata=array();
                                                                $wheredata[0]="(b.type = 'LT' or b.type = 'LE')"; 
                                                                $wheredata[1]="a.type='IP'";
							                                   $wheredata[2]="a.ref_no='".$postArr['id']."'";  
															   $wheredata[3]="a.status=0";
                                                                	                                                                    
                                                                                                                            
                                                                // $lab=$bill_obj->getBillItemPatient($wheredata);
                                                                
                                                                // if(!empty($lab)) $postArr['lab']=$lab[0][0];

															   $lab_details=$bill_obj->getBillItemLab($wheredata);
														$lab_credit=0;
				                                          for($i=0;$i<sizeof($lab_details);$i++){
				                                          	$lab_credit+=$lab_details[$i][4]-$lab_details[$i][5];
				                                            }
															$itemAmount[8]=$lab_credit;
															   
															   // $itemAmount[8]=$postArr['lab'];
															  $itemAmount[9]=$postArr['room_rent'];
															   $itemAmount[10]=$postArr['nursing_charges'];
															   $itemAmount[11]=$postArr['maintenance'];
															   $itemAmount[12]=$postArr['nurse_added_procedures'];

															   // $itemAmount[23]=$postArr['ip_bill_visit'];
															   $itemAmount[23]=0;
															   $itemAmount[24]=$postArr['bystander_charges'];

															                   //THEATRE PROCEDURE assistant fee 1,2
															   $wheredata_assi=array();
															   $wheredata_assi[0]="b.type = 'P'";	  
                                                $wheredata_assi[1]="a.type='IP'";
															   $wheredata_assi[2]="b.category_id=4"; 
							                                   $wheredata_assi[3]="a.ref_no='".$postArr['id']."'"; 
                                                                 $wheredata_assi[4]="a.status=0";
                                                                 $wheredata_assi[5]="a.paid_with='CREDIT'";
                                                                 	   
                                                                  
                                                                
                                                                $groupby="b.type,b.test_id,b.category_id";                                                            
                                                                $theatre_procedure_assi=$bill_obj->getBillTheatreProcedure($wheredata_assi,$groupby);
                                                                // var_dump($theatre_procedure);

                                                if (!empty($theatre_procedure_assi)) {

	                                               for($ss = 0; $ss<sizeof($theatre_procedure_assi);$ss++){

	                                                if (!empty($theatre_procedure_assi) && $theatre_procedure_assi[$ss][10] ==0) {

																	  
																	   $itemAmount[25]+=$theatre_procedure_assi[$ss][11];
																	   $itemAmount[26]+=$theatre_procedure_assi[$ss][12];
																		}
																	}
                                                }

															   
                                                                //procedure bill item details
                                                                
                                                                $wheredata=array();
                                                                $wheredata[0]="b.type = 'P'";	  
                                                                $wheredata[1]="(b.category_id !=2 and b.category_id !=4)"; 
                                                                $wheredata[2]="a.type='IP'";
							                                   $wheredata[3]="a.ref_no='".$postArr['id']."'";  
                                                                $wheredata[4]="a.status=0";
                                                                //new 
                                                                 $wheredata[5]="b.package_id = 0";
                                                                 $wheredata[6]="a.paid_with = 'CREDIT'";
                                                                
                                                                $groupby="b.type,b.test_id,b.category_id";                                                            
                                                                $procedure_items=$bill_obj->getBillItemPatient($wheredata,$groupby);
															  // var_dump($procedure_items);
                                                                
																// $m=24;
                                                 $m=27;
																//for labour charges
																$gynec_charges = 0;
																$labour_room_charges = 0;
																$procedure_items_total=0;
																$count_status=0;
                                                             if(!empty($procedure_items)){
													 
													          for($i=0;$i<count($procedure_items);$i++){

		                										//for labour chargesdeliveryCharges
													          	if($procedure_items[$i][3]==16){
													          		$delivery_charges = $this->deliveryCharges($procedure_items[$i][1],$procedure_items[$i][4]);
													          		$gynec_charges +=$delivery_charges['gynec'];
													          		$labour_room_charges +=$delivery_charges['room_charge'];

													          	}
													          	else{
													          if($procedure_items[$i][10]==0){		

															     $itemName[$m]=$procedure_items[$i][2];
														         $itemAmount[$m++]=$procedure_items[$i][0];
														         $procedure_items_total=$procedure_items_total+$procedure_items[$i][0];

														         $count_status=1;
														      }
														     	}
															  }
															}
															// echo $procedure_items_total;

															if (!empty($procedure_items) && $count_status==1) {
																 $postArr['procedure_count']= count($procedure_items);

															}
															else{
																 $postArr['procedure_count']= 0;
															}

															$total_bill=$itemAmount[0]+$itemAmount[1]+$itemAmount[2]+$itemAmount[3]+$itemAmount[4]+$itemAmount[5]+$itemAmount[6]+$itemAmount[7]+$itemAmount[8]+ $itemAmount[9]+$itemAmount[10]+$itemAmount[11]+$itemAmount[12]+$itemAmount[23]+$itemAmount[24]+$gynec_charges+$labour_room_charges+$procedure_items_total+$itemAmount[25]+$itemAmount[26];
															$postArr['total_bill']=$total_bill;

															$balance=$total_bill-$postArr['advance_paid'];
															$postArr['balance_amt']=$balance;

													


                                                              
                                                                
                                                   // var_dump($itemName);             	   
			                                                 
											//}
			                                     $form_creator ->popArr['post']=$postArr;
											     $form_creator ->popArr['itemName']=$itemName;
												 $form_creator ->popArr['itemAmount']=$itemAmount;
											     $form_creator ->popArr['gynec_charges']=$gynec_charges;
												 $form_creator ->popArr['labour_room_charges']=$labour_room_charges;
                                                  $form_creator ->formPath ='/templates/billing/prepare_final_bill.php';
                                                                
                                                               
                                     }
			                        break;
				case 'Final_Payment_Form' : $ip_obj= new Inpatient();
			                                  $bill_obj= new Billing();


											  
											  $wheredata[0]="ipno='".$postArr['id']."'";
                                                $wheredata[1]="(bill_status !=1 and bill_status !=3)";														
                                                 $billInfo=$bill_obj->getIPBillInfo($wheredata);
												
												//check bill already prepared
												
												    if(!empty($billInfo)){
													  
													// echo 111;exit;
													 $form_creator ->popArr['billInfo']=$billInfo;
													 
													  //Patient Info
                                                                $postArr['dod']=date("d-m-Y h:i a");
                                                                $selectCondition[]="b.`id`='".$postArr["id"]."'";
                                                               // $selectCondition[]="(b.`discharge_date`!='0000-00-00' OR b.`discharge_date`!='')";
                                                               // $selectCondition[]="b.`cancelled`=0";
										       
											   
											                
                                                                //retrieve patient information
                                                                $form_creator ->popArr['patient_info']=$ip_pat_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                                        $form_creator ->popArr['post']=$postArr; 

                                                        //get ip category discount
                                                        		$is_field[0]="a.id ='".$ip_pat_info[0][53]."'";
                                                             $pat_cat_obj = new PatientCategory();
                                                             $discount_info = $pat_cat_obj->getPatientCategoryInfo($is_field);
                                                             $ip_discount['discount_type'] = $discount_info[0][14];
                                                             $ip_discount['discount_value'] = $discount_info[0][15];
                                                             $form_creator ->popArr['ip_discount']=$ip_discount; 
													 $form_creator ->formPath ='/templates/billing/final_payment_form.php';
													}
										break;
			  
			  case 'Manage_IP_Payments':  $bill_obj= new Billing(); 
			                              $user_obj=new User();
			  
			  
			                               $k=0;
							if(!empty($postArr['from_date'])) {
											
								$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
							}else{
								$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
							}
							if(!empty($postArr['billno'])) {
									$wheredata[$k++]="id ='".$postArr['billno']."'";
							}
							if(!empty($postArr['ipno'])) {
									$wheredata[$k++]="ipno='".$postArr['ipno']."'";
							}
							if(!empty($postArr['user'])) {
									$wheredata[$k++]="user_id='".$postArr['user']."'";
							}
			                    $wheredata[$k++]="(bill_status !=1 and bill_status!=3)";
			                               $form_creator ->popArr['billInfo']=$billInfo=$bill_obj->getIPBillInfo($wheredata);
			                               // var_dump($billInfo);exit;
			                               $form_creator ->popArr['user']=$user_obj->getUser();;
			                               $form_creator ->formPath ='/templates/billing/manage_ip_payment.php';
							break;
	    case 'Manage_IP_Credits':  $bill_obj= new Billing(); 
			                              $user_obj=new User();
			  
			  
			                               $k=0;
							if(!empty($postArr['from_date'])) {
											
								$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
							}else{
								$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
							}
							if(!empty($postArr['billno'])) {
									$wheredata[$k++]="id ='".$postArr['billno']."'";
							}
							if(!empty($postArr['ipno'])) {
									$wheredata[$k++]="ipno='".$postArr['ipno']."'";
							}
							if(!empty($postArr['user'])) {
									$wheredata[$k++]="user_id='".$postArr['user']."'";
							}
			                               $wheredata[$k++]="(bill_status !=1 and bill_status!=3)";
						       $wheredata[$k++]="payment_mode ='CREDIT'";
						       $wheredata[$k++]="balance > 0";
			                               $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
			                               $form_creator ->popArr['user']=$user_obj->getUser();;
			                               $form_creator ->formPath ='/templates/billing/manage_ip_credit.php';
							break;
	 case 'Manage_IP_Credit_Payments':  $bill_obj= new Billing(); 
			                              $user_obj=new User();
			  
			  
			                               $k=0;
							if(!empty($postArr['from_date'])) {
											
								$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
							}else{
								$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
								$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
							}
							if(!empty($postArr['billno'])) {
									$wheredata[$k++]="billid ='".$postArr['billno']."'";
							}
							if(!empty($postArr['ipno'])) {
									$wheredata[$k++]="ipno='".$postArr['ipno']."'";
							}
							if(!empty($postArr['user'])) {
									$wheredata[$k++]="user_id='".$postArr['user']."'";
							}
			                              
			                               $form_creator ->popArr['billInfo']=$bill_obj->getIPCreditPayments($wheredata);
			                               $form_creator ->popArr['user']=$user_obj->getUser();;
			                               $form_creator ->formPath ='/templates/billing/manage_ip_credit_payment.php';
							break;
                      case 'credit_bill_authentication'         :   
                                                             $form_creator ->popArr['auth_from']=$getArr['from'];
                                                             $form_creator ->formPath ='/templates/billing/authenticate_credit_bill.php';
							              break;
	   case 'show_bill_items':
					                        $bill_obj=new Billing();
											$emp_obj=new Employee();
											 $wheredata[0]="id ='".$getArr['billno']."'";
											 // $wheredata[1]="status =0'";
											 $form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata);
											 
											 $wheredata[0]="bill_id ='".$getArr['billno']."'";
											 $form_creator ->popArr['billItemInfo']=$bill_obj->getBillItemsInfo($wheredata);
											 
											  $is_field[0]="a.title='Dr'";												
                                              $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);	
											  
					                         $form_creator ->formPath ='/templates/billing/show_bill_items.php';
							              break;
		case 'show_surgery_bill_finalitems':
									$bill_obj=new Billing();
									//THEATRE PROCEDURE
									
								   $wheredata=array();
								   $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="a.type='IP'";
								   $wheredata[2]="b.category_id=4"; 
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'"; 
                                     $wheredata[4]="a.status=0";
                                     $wheredata[5]="a.paid_with='CREDIT'";																	   
                                     $groupby="b.type,b.test_id,b.category_id";                                                            
                                     $theatre_procedure=$bill_obj->getBillTheatreProcedure_details($wheredata,$groupby);
                                     // var_dump($theatre_procedure);
									$form_creator ->popArr['pops']=$theatre_procedure;

									$form_creator ->formPath ='/templates/billing/show_surgery_bill_finalitems.php';
									break;
		case 'show_medicine_finalbills':
								$bill_obj=new Billing();

								             $phwhere[]="cust_type = 'IP'";        
								              $phwhere[]="ip_no = '".$getArr['ipno']."'";  
								             $phwhere[]="status = '0'";
								              $phwhere[]="payment_mode = 'CREDIT'";
								              //new
								              $phwhere[]="sales_mode = 'Sales'";
									    $pharmaInfo=$bill_obj->getpharmaBill($phwhere);
									    $form_creator ->popArr['pops']=$pharmaInfo;											

									$form_creator ->formPath ='/templates/billing/show_medicine_finalbills.php';
									break;
		case 'show_specialist_finalbills':

				                    $ip_obj= new Inpatient();
									$docondn[0]="status = 0";
						            $docondn[1]="ipno = '".$getArr['ipno']."'";
						            $specialist=$ip_obj->getDoctorVisit('',$docondn,'doctor','asc');
						            $form_creator ->popArr['pops']=$specialist; 
									$form_creator ->formPath ='/templates/billing/show_specialist_finalbills.php';
									break;
		case 'show_xray_finalbills':
									$bill_obj=new Billing();
									$wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="b.category_id=2"; 
                                     $wheredata[2]="a.type='IP'";
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'";
									$wheredata[4]="a.status=0"; 
                                       
                                      $groupby="b.category_id";                                    
                                     $xray_details_popup=$bill_obj->getBillItemLab($wheredata);
                                      $form_creator ->popArr['pops']=$xray_details_popup;

									$form_creator ->formPath ='/templates/billing/show_xray_finalbills.php';
								   break;
		case 'show_lab_finalbills':
									$bill_obj=new Billing();
									$wheredata=array();
                                     $wheredata[0]="(b.type = 'LT' or b.type = 'LE')"; 
                                     $wheredata[1]="a.type='IP'";
                                   $wheredata[2]="a.ref_no='".$getArr['ipno']."'";  
								   $wheredata[3]="a.status=0";
                                     	                                                                    
                                                                         
                                    $lab_details_popup=$bill_obj->getBillItemLab($wheredata);

                                    
                                      $form_creator ->popArr['pops']=$lab_details_popup;

									$form_creator ->formPath ='/templates/billing/show_lab_finalbills.php';
								   break;
		case 'show_rent_finalbills':
									$ipfunc_obj= new IpFunctions();
								   $wheredata['id']=$getArr['ipno'];																	   
                                    	$rent=$ipfunc_obj->calculateBill_details($wheredata);
                                    	// var_dump($rent);

                                      $form_creator ->popArr['pops']=$rent;

									$form_creator ->formPath ='/templates/billing/show_rent_finalbills.php';
								   break;
		case 'show_nursing_procedures_finalbills':
									$ip_obj= new Inpatient();

								  	$procondn[0]="status = 0";
						            $procondn[1]="ipno = '".$getArr['ipno']."'";
						            $ipProcedure=$ip_obj->getIPProcedure('',$procondn,'procedure_test','asc');		
									$form_creator ->popArr['pops']=$ipProcedure;

									$form_creator ->formPath ='/templates/billing/show_nursing_procedures_finalbills.php';
								   break;
		case 'show_labour_charges_bills':
									$ip_obj= new Inpatient();
									$delivery_charges_details = $ip_obj->deliveryChargesDetails($getArr['ipno']);
								  	$form_creator ->popArr['pops']=$delivery_charges_details;
									$form_creator ->formPath ='/templates/billing/show_labour_charges_bills.php';
								   break;
		//show all bills
		case 'show_final_bills':	$tot = 0;
									$bill_obj=new Billing();
									//THEATRE PROCEDURE
									
								   $wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="b.category_id=4"; 
                                     $wheredata[2]="a.type='IP'";
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'";
									$wheredata[4]="a.status=0";
									$wheredata[5]="b.status=0";  
									$wheredata[6]="a.paid_with='CREDIT'";                                                           
                                     $theatre_charges=$bill_obj->getBillItemLab($wheredata);
                                    
                                     for($i=0;$i<sizeof($theatre_charges);$i++){
                                        $theatre_procedure['t_bill'][$i][0] = $theatre_charges[$i][0];
                                        $theatre_procedure['t_bill'][$i][1] = $theatre_charges[$i][1];
                                        $theatre_procedure['t_bill'][$i][2] = $theatre_charges[$i][2];
                                        $theatre_procedure['t_bill'][$i][3] = $theatre_charges[$i][3];
                                        $theatre_procedure['t_bill'][$i][4] = $theatre_charges[$i][4];

                                       	$theatre_procedure['t_bill']['net_tot']+=$theatre_charges[$i][2];
										$theatre_procedure['t_bill']['paid_tot']+=$theatre_charges[$i][3];
										$theatre_procedure['t_bill']['balance_tot']+=$theatre_charges[$i][4];

										$bill_numbers[$i]=$theatre_charges[$i][0];
                                    }

                                    $wheredata=array();  
                                     $wheredata[0]="a.status=0";
                                     $wheredata[1]="b.status=0";

                                     if($bill_numbers){
								   	$wheredata[2]="b.bill_no in('".implode("','", $bill_numbers)."')";
								   	$theatre_procedure['tc_bill'] = $bill_obj->final_credit_bill_details($wheredata);
								   }			

									
									$form_creator ->popArr['theatre_procedure']=$theatre_procedure;

									//xray
									$wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="b.category_id=2"; 
                                     $wheredata[2]="a.type='IP'";
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'";
									$wheredata[4]="a.status=0";
									$wheredata[5]="b.status=0"; 

                                     $bill_xray=$bill_obj->getBillItemLab($wheredata);
                                     for($i=0;$i<sizeof($bill_xray);$i++){
                                        $bill_xray_details['x_bill'][$i][0] = $bill_xray[$i][0];
                                        $bill_xray_details['x_bill'][$i][1] = $bill_xray[$i][1];
                                        $bill_xray_details['x_bill'][$i][2] = $bill_xray[$i][2];
                                        $bill_xray_details['x_bill'][$i][3] = $bill_xray[$i][3];
                                        $bill_xray_details['x_bill'][$i][4] = $bill_xray[$i][4];

                                       	$bill_xray_details['x_bill']['net_tot']+=$bill_xray[$i][2];
										$bill_xray_details['x_bill']['paid_tot']+=$bill_xray[$i][3];
										$bill_xray_details['x_bill']['balance_tot']+=$bill_xray[$i][4];

										$bill_numbers_x[$i]=$bill_xray[$i][0];
                                    }

                                    $wheredata=array();	  
                                     $wheredata[0]="a.status=0";
                                     $wheredata[1]="b.status=0";	
                                     if($bill_numbers_x){
									   $wheredata[2]="b.bill_no in('".implode("','", $bill_numbers_x)."')";
										$bill_xray_details['xc_bill'] = $bill_obj->final_credit_bill_details($wheredata);	
										// var_dump($bill_xray_details['xc_bill']);
									}


                                      $form_creator ->popArr['bill_xray_details']=$bill_xray_details;

								   //lab
									$wheredata=array();
                                     $wheredata[0]="(b.type = 'LT' or b.type = 'LE')"; 
                                     $wheredata[1]="a.type='IP'";
                                   $wheredata[2]="a.ref_no='".$getArr['ipno']."'";  
								   $wheredata[3]="a.status=0";
									$wheredata[4]="b.status=0";
                                                                       
                                     $bill_lab=$bill_obj->getBillItemLab($wheredata);
                                     // var_dump($bill_lab);
                                     for($i=0;$i<sizeof($bill_lab);$i++){
                                        $bill_lab_details['l_bill'][$i][0] = $bill_lab[$i][0];
                                        $bill_lab_details['l_bill'][$i][1] = $bill_lab[$i][1];
                                        $bill_lab_details['l_bill'][$i][2] = $bill_lab[$i][2];
                                        $bill_lab_details['l_bill'][$i][3] = $bill_lab[$i][3];
                                        $bill_lab_details['l_bill'][$i][4] = $bill_lab[$i][4];

                                       	$bill_lab_details['l_bill']['net_tot']+=$bill_lab[$i][2];
										$bill_lab_details['l_bill']['paid_tot']+=$bill_lab[$i][3];
										$bill_lab_details['l_bill']['balance_tot']+=$bill_lab[$i][4];

										$bill_numbers_l[$i]=$bill_lab[$i][0];
                                    }

                                    $wheredata=array();  
                                     $wheredata[0]="a.status=0";
									$wheredata[1]="b.status=0";
                                     if($bill_numbers_l){	
								   		$wheredata[2]="b.bill_no in('".implode("','", $bill_numbers_l)."')";
										$bill_lab_details['lc_bill'] = $bill_obj->final_credit_bill_details($wheredata);
										// var_dump($bill_lab_details['lc_bill']);
									}
                                      $form_creator ->popArr['bill_lab_details']=$bill_lab_details;

                                      //procedure
									$wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="(b.category_id !=2 and b.category_id !=4 and b.category_id !=16)"; 
                                     $wheredata[2]="a.type='IP'";
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'";
									$wheredata[4]="a.status=0";
									$wheredata[5]="b.status=0"; 
									 $wheredata[6]="b.package_id = 0";
									 $wheredata[7]="a.paid_with = 'CREDIT'";

                                     $bill_procedure=$bill_obj->getBillItemLab($wheredata);
                                     // var_dump($bill_procedure);

                                     for($i=0;$i<sizeof($bill_procedure);$i++){
                                        $bill_procedure_details['pro_bill'][$i][0] = $bill_procedure[$i][0];
                                        $bill_procedure_details['pro_bill'][$i][1] = $bill_procedure[$i][1];
                                        $bill_procedure_details['pro_bill'][$i][2] = $bill_procedure[$i][2];
                                        $bill_procedure_details['pro_bill'][$i][3] = $bill_procedure[$i][3];
                                        $bill_procedure_details['pro_bill'][$i][4] = $bill_procedure[$i][4];

                                       	$bill_procedure_details['pro_bill']['net_tot']+=$bill_procedure[$i][2];
										$bill_procedure_details['pro_bill']['paid_tot']+=$bill_procedure[$i][3];
										$bill_procedure_details['pro_bill']['balance_tot']+=$bill_procedure[$i][4];

										$bill_numbers_proc[$i]=$bill_procedure[$i][0];
                                    }

                                    $wheredata=array();	  
                                     $wheredata[0]="a.status=0";
									$wheredata[1]="b.status=0";

                                     if($bill_numbers_proc){	
								   		$wheredata[2]="b.bill_no in('".implode("','",$bill_numbers_proc)."')";	
								   		$bill_procedure_details['proc_bill'] = $bill_obj->final_credit_bill_details($wheredata);
								   		// var_dump($bill_procedure_details['proc_bill']);
								   	}

                                      $form_creator ->popArr['bill_procedure_details']=$bill_procedure_details;
                                      //gynec
                                      $wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="b.category_id =16"; 
                                     $wheredata[2]="a.type='IP'";
                                   $wheredata[3]="a.ref_no='".$getArr['ipno']."'";
									$wheredata[4]="a.status=0"; 
									$wheredata[5]="b.status=0";

                                     $bill_gynec=$bill_obj->getBillItemLab($wheredata);
                                     for($i=0;$i<sizeof($bill_gynec);$i++){
                                        $bill_gynec_details['g_bill'][$i][0] = $bill_gynec[$i][0];
                                        $bill_gynec_details['g_bill'][$i][1] = $bill_gynec[$i][1];
                                        $bill_gynec_details['g_bill'][$i][2] = $bill_gynec[$i][2];
                                        $bill_gynec_details['g_bill'][$i][3] = $bill_gynec[$i][3];
                                        $bill_gynec_details['g_bill'][$i][4] = $bill_gynec[$i][4];

                                       	$bill_gynec_details['g_bill']['net_tot']+=$bill_gynec[$i][2];
										$bill_gynec_details['g_bill']['paid_tot']+=$bill_gynec[$i][3];
										$bill_gynec_details['g_bill']['balance_tot']+=$bill_gynec[$i][4];

										$bill_numbers_g[$i]=$bill_gynec[$i][0];
                                    }

                                    $wheredata=array();  
                                     $wheredata[0]="a.status=0";
									$wheredata[1]="b.status=0";
                                     if($bill_numbers_g){
								   		$wheredata[2]="b.bill_no in('".implode("','", $bill_numbers_g)."')";		
								   		$bill_gynec_details['gc_bill'] = $bill_obj->final_credit_bill_details($wheredata);
								   	}

                                      $form_creator ->popArr['bill_gynec_details']=$bill_gynec_details;                                         
									$bill_advance_details = $bill_obj->final_bill_advance_details($getArr['ipno']);
									$bill_pharma_details['p_bill'] = $bill_obj->final_bill_pharma_details($getArr['ipno']);
									$bill_pharma_details['pc_bill'] = $bill_obj->final_credit_bill_pharma_details($getArr['ipno']);
									// var_dump($bill_pharma_details['pc_bill']);
								  	$form_creator ->popArr['bill_details']=$bill_details;
								  	$form_creator ->popArr['bill_advance_details']=$bill_advance_details;
								  	$form_creator ->popArr['bill_pharma_details']=$bill_pharma_details;

								  	$ip_obj= new Inpatient();
									$docondn[0]="status = 0";
						            $docondn[1]="ipno = '".$getArr['ipno']."'";
						            $specialist=$ip_obj->getDoctorVisit('',$docondn,'doctor','asc');	
						            if(!empty($specialist)){
										for($s=0;$s<sizeof($specialist);$s++){							
											$tot +=$specialist[$s][3];
										}
									}
									$form_creator ->popArr['doc_visit']=$tot;

						            $ipfunc_obj= new IpFunctions();
								   	$wheredata['id']=$getArr['ipno'];
								   	$rent=$ipfunc_obj->calculateBill_details($wheredata);
								   	$tot = 0;
									if(!empty($rent['room_history'][0])){
										for($s=0;$s<sizeof($rent['room_history']);$s++){							
											$tot+=$rent['room_history'][$s][1]*$rent['room_history'][$s][4];
											$tot+=$rent['room_history'][$s][5]*$rent['room_history'][$s][4];
											$tot+=$rent['room_history'][$s][6]*$rent['room_history'][$s][4];
											$tot+=$rent['room_history'][$s][7]*$rent['room_history'][$s][4];
										}
									}
									if(!empty($rent['room_new'])){								
										$tot+=$rent['room_new'][1]*$rent['room_new'][4];							
										$tot+=$rent['room_new'][5]*$rent['room_new'][4];							
										$tot+=$rent['room_new'][6]*$rent['room_new'][4];
										$tot+=$rent['room_new'][7]*$rent['room_new'][4];
									}
									$form_creator ->popArr['rent']=$tot;

                                      $procondn[0]="status = 0";
						            $procondn[1]="ipno = '".$getArr['ipno']."'";
						            $ipProcedure=$ip_obj->getIPProcedure('',$procondn,'procedure_test','asc');
						            $tot = 0;
									if(!empty($ipProcedure)){
										for($s=0;$s<sizeof($ipProcedure);$s++){
											$tot = $tot+$ipProcedure[$s][3];
										}
									}		
									$form_creator ->popArr['ipProcedure']=$tot;

									$form_creator ->formPath ='/templates/billing/show_final_bills.php';
								   break;
                      case 'assign_doctors':
					                        $bill_obj=new Billing();
											$emp_obj=new Employee();
											 $wheredata[0]="id ='".$getArr['billno']."'";
											 $form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata);
											 
											 $wheredata[0]="bill_id ='".$getArr['billno']."'";
											 $form_creator ->popArr['billItemInfo']=$bill_obj->getBillItemsInfo($wheredata);
											 
											  $is_field[0]="a.title='Dr'";												
                                              $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);	
											  
					                         $form_creator ->formPath ='/templates/billing/assign_doctors.php';
							              break;
	    case 'ip_credit_payment_form' : $bill_obj=new Billing();
	                                    $wheredata[0]="id ='".$getArr['billno']."'";
			                    $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
	    
	                                     $form_creator ->formPath ='/templates/billing/ip_credit_payment_form.php';
							              break;
	   case 'Add_Multiple_Credit_IP'	: $this->addMultipleCreditip($postArr);
	   
						  break;

		case 'xray_attahments'          : $bill_obj=new Billing();
										  $dr_obj  =new Doctor();
										  $user_obj  =new User();

											if (!empty($getArr)) {

												$billno = $getArr['billno'];
	                                    		$wheredata[0]="id ='".$getArr['billno']."'";
			                    				$form_creator ->popArr['billInfo']=$billInfo=$bill_obj->getBillInfo($wheredata);

			                    				$where[]="user_type = 12";
			                    				$where[]="status = 0";
			                    				$userInfo = $user_obj->getUser("",$where);

			                    				//$where_doc[]="opno = '".$billInfo[0][19]."'"; 
			                    				if(empty($billInfo[0][19])){
												$where_doc[]="direct_id = '".$billInfo[0][2]."'"; 
											    }else{
											    	$where_doc[]="opno = '".$billInfo[0][19]."'"; 
											    }
			                    				$where_doc[]="status = 0"; 

			                    				$user_id_new[]="(";
												for($i=0;$i<count($userInfo);$i++){

													$user_id_new[$i] .="update_history LIKE '%".$userInfo[$i][0]."%'";

												}
												$user_id_new[].=")";
												// $matches = implode(' or ', $user_id_new);

												if(!empty($matches)){
													$where_doc[] =$matches;
												} 
												
												$form_creator ->popArr['documentInfo']=$dr_obj->getPatient_documents('', $where_doc);
												$form_creator ->popArr['post']=$postArr;

			                    				$form_creator ->formPath ='/templates/billing/patient_documents.php';

			                    				
											}



										  break;

                      case 'updateBill':
					                        $bill_obj=new Billing();
											$emp_obj=new Employee();
											$db_function=new DBFunction();
											$pack_obj=new Health_package();

            							// echo $postArr['email'];exit;	
											if (!empty($postArr)) {


												$bill_id=$bill_obj->updateBillAmounts($postArr);

												$bill_obj->deleteBillItems($postArr);

												$post = $postArr;

												$items=$post['items'];
												
														
												if(count($items) > 0){
												
													if($post['paction'] == "EDIT_BILL"){

														

													
																												
														if($bill_id >0 ) {	
														// if(!empty($post['email'])){
														// 	$where[]=$post['email'];
														// 	$where[]=$bill_id;
														// 	$bill_obj->updateEmail($where);
														// }
	
												
															for($i=0;$i<count($items);$i++){
														
																if($items[$i][6] == "C" && $post['type'] == "OP"){
																
																	$reg_obj->updatePaidStatus($post['id'],1);
																}
																$sub_amounts=array();
																
																$post['package_id']='';
																
															if($items[$i][6] == "P"){
																
																//theatre charge entered by supernurse
																if(!empty($_SESSION['changeamt'][$i])){
																
																    $items_in_array=explode("!$%",$_SESSION['changeamt'][$i]);         
										                            $sub_amounts[0]=$items_in_array[1];
															        $sub_amounts[1]=0;
															        $sub_amounts[2]=$items_in_array[2];
															        $sub_amounts[3]=$items_in_array[6];
															        $sub_amounts[4]=$items_in_array[5];
															        $sub_amounts[5]=$items_in_array[7];
																    $sub_amounts[6]=$items_in_array[3];
															        $sub_amounts[7]=$items_in_array[4];

										                        }else{						
																    $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
																    $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
																}
																    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
																
														         }else if($items[$i][6] == "PACKAGE"){
															 
															    //add package name here heading 1
															    
															   
															     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
															     
															     //add package elements
															     
															    $package_id=$items[$i][0];
															    $hElemCondn[0]="package_id =".$package_id;
															    $hElemCondn[1]="status =0";
															    $packageElements=$pack_obj->getHealthPackageElements('',$hElemCondn);
															    
															    if(!empty($packageElements)){
															        for($k=0;$k<count($packageElements);$k++){
																
																  $post['package_id']=$package_id;
																  $test_type=$packageElements[$k][2];
																  
																  $items[$i][0]=$packageElements[$k][1];
																  $items[$i][2]=$packageElements[$k][4];
																  $items[$i][3]="";
																  $items[$i][4]="";
																  $items[$i][5]=$packageElements[$k][4];
																  $items[$i][7]=$packageElements[$k][5];
																  if($test_type == "P"){
																  
																         $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
																         $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
																     
																     $items[$i][6]="P";
																     $items[$i][8]=0;
																     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
																  }else{
																    $items[$i][6]=$test_type;
																    
																    if($test_type == "LT") $items[$i][8]=1;
																    else $items[$i][8]=0;
																    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
																    
																    
																  }
																}
															    }
															 }else{
																$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
															  }
															}
														}
														unset($_SESSION['changeamt']);


														if($post['type'] == "DIRECT"){

													
															$post['id']=$db_function->getidToValue("ref_no","id",$bill_id,"hcare_bill");
															$bill_obj->updateCustomer($post);
														}
														
													}else{

													
														$bill_id=$post['billid'];
														
														if($post['type'] == "DIRECT"){

													
															$post['id']=$db_function->getidToValue("ref_no","id",$bill_id,"hcare_bill");
															$bill_obj->updateCustomer($post);
														}
														
														$bill_obj->updateBill($post);
														$bill_obj->deleteBillItems($post);
														
														for($i=0;$i<count($items);$i++){
														
															
																$sub_amounts=array();
																
																$post['package_id']='';
																
															if($items[$i][6] == "P"){
																
																$sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
																$sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
															        $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
																
																$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
																
														         }else if($items[$i][6] == "PACKAGE"){
															 
															    //add package name here heading 1
															    
															   
															     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
															     
															     //add package elements
															     
															    $package_id=$items[$i][0];
															    $hElemCondn[0]="package_id =".$package_id;
															    $hElemCondn[1]="status =0";
															    $packageElements=$pack_obj->getHealthPackageElements('',$hElemCondn);
															    
															    if(!empty($packageElements)){
															        for($k=0;$k<count($packageElements);$k++){
																
																  $post['package_id']=$package_id;
																  $test_type=$packageElements[$k][2];
																  
																  $items[$i][0]=$packageElements[$k][1];
																  $items[$i][2]=$packageElements[$k][4];
																  $items[$i][3]="";
																  $items[$i][4]="";
																  $items[$i][5]=$packageElements[$k][4];
																  $items[$i][7]=$packageElements[$k][5];
																  if($test_type == "P"){
																  
																     $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
																     $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
															             $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
																     
																     $items[$i][6]="P";
																     $items[$i][8]=0;
																     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
																  }else{
																    $items[$i][6]=$test_type;
																    
																    if($test_type == "LT") $items[$i][8]=1;
																    else $items[$i][8]=0;
																    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
																    
																    
																  }
																}
															    }
															 }else{
																$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
															  }
															
														}
													
													}
												}

											}
											$form_creator ->popArr['post']=$post;
											// $this->viewPage('Manage_Billing',$post,'',$message);
											// $form_creator ->formPath ='/templates/billing/manage_billing.php';
											$this->viewPage('Print_Bill',$post,'',$message);
											$form_creator ->formPath ='/templates/billing/print_bill.php';
	    
	   
						  break;


				case 'observation_final' : $ip_obj= new Inpatient();
			                                  $bill_obj= new Billing();
			                                  $reg_obj= new Registration();
											  
											  $wheredata[0]="ref_no='".$postArr['id']."'";
                                                $wheredata[1]="status =0";														
                                                $billInfo=$bill_obj->getBillInfo($wheredata);


												$net_total = 0;
												$amount_paid = 0;
												$pending = 0;

												//check bill already prepared
												
												    if(!empty($billInfo)){
														
													
												    	for ($i=0; $i <count($billInfo) ; $i++) { 
												    		
												    		$data['net_total']=$net_total += $billInfo[$i][11]; 
												    		$data['amount_paid']=$amount_paid += ($billInfo[$i][13]+$billInfo[$i][15]); 
												    		$data['pending']=$pending += $billInfo[$i][14]; 


												    	}
												    	
													}
													else{



												    		$data['net_total']=0; 
												    		$data['amount_paid']=0; 
												    		$data['pending']=0;


													}
													//room rent
													$rent = $bill_obj-> calculateRoomRent($postArr['id']);
													$net_rent = $rent['net_total'];
													$data['net_total'] += $net_rent;
													$data['pending'] += $net_rent;



														$form_creator ->popArr['billInfo']=$billInfo;
													 
													  //Patient Info
                                                                $postArr['dod']=date("d-m-Y h:i a");
                                                                $selectCondition[]="b.`id`='".$postArr["id"]."'";
                                                             
											   
											                
                                                                //retrieve patient information
                                                                $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','asc');
                                                        $form_creator ->popArr['post']=$postArr;
                                                        $form_creator ->popArr['data']=$data;         
													 $form_creator ->formPath ='/templates/billing/observation_final_payment_form.php';


										break;


				case 'show_observation_bills':
									$bill_obj=new Billing();

									$db_function =new DBFunction();											
									// $reg_obj = new Registration();

									// //get observation interval
									// $wheredata=array();
     //                                 	$wheredata[0]="opno='".$getArr['opno']."'";
									// $dates = $reg_obj->getObservationInterval($wheredata);
									// var_dump($dates);


									// 'show_xray_finalbills':

									$opno=$db_function->getidToValue("opno","id",$getArr['opid'],"hcare_op_visit_info");

									$wheredata=array();
                                     $wheredata[0]="b.type = 'P'";	  
                                     $wheredata[1]="b.category_id=2"; 
                                     $wheredata[2]="a.type='OP'";
                                   $wheredata[3]="a.opno='".$opno."'";
									$wheredata[4]="a.status=0"; 
									// $wheredata[5]="a.bill_date between c."
                                       
                                      $groupby="b.category_id";                                    
                                     $xray_details_popup=$bill_obj->getBillItemLab($wheredata);
                                      $form_creator ->popArr['xray_details_popup']=$xray_details_popup;

								  
								   // 'show_lab_finalbills':
									$wheredata=array();
                                     $wheredata[0]="(b.type = 'LT' or b.type = 'LE')"; 
                                     $wheredata[1]="a.type='OP'";
                                   $wheredata[2]="a.opno='".$opno."'";  
								   $wheredata[3]="a.status=0";                                         	
								   $lab_details_popup=$bill_obj->getBillItemLab($wheredata);                                          
                                      $form_creator ->popArr['lab_details_popup']=$lab_details_popup;										   

								  
								  // 'show_nursing_procedures_finalbills':                                            
									
									$user_obj=new User();
									$where[]="user_type = 11 or user_type = 13";
			                    	$where[]="status = 0";
			                    	$userInfo = $user_obj->getUser("",$where);

									for($i=0;$i<count($userInfo);$i++){
										$user_id_new[$i] =$userInfo[$i][0];
									}

						            $wheredata=array();
                                     $wheredata[0]="b.type = 'P'"; 
                                     $wheredata[1]="a.type='OP'";
                                   $wheredata[2]="a.opno='".$opno."'";  
								   $wheredata[3]="a.status=0"; 
								   $wheredata[4]="a.user_id in ('".implode("','",$user_id_new)."')";
								   $ipProcedure=$bill_obj->getBillItemLab($wheredata);	
								   
									$form_creator ->popArr['ipProcedure']=$ipProcedure;


									//room rent																	   
                                    	$rent=$bill_obj->calculateRoomRent($getArr['opid']);

                                      $form_creator ->popArr['rent']=$rent;

									$form_creator ->formPath ='/templates/billing/show_observation_bills.php';
								   break;




				case 'discharge_observation' : $ip_obj= new Inpatient();
			                                  $bill_obj= new Billing();
			                                  $reg_obj= new Registration();
											  

			                                  if (!empty($postArr) && empty($postArr['no_action']) ) {
			                                  	
			                                  	$postArr['billid']=$bill_obj->addObservationBill($postArr);

			                                  	$reg_obj->updateObservationDischarge($postArr['visit_id'],"DISCHARGED");

			                                  }

			                                  $billInfo = $this->Print_Bill_Observation($postArr);


											$form_creator ->popArr['billInfo']=$billInfo;
								                                
											$form_creator ->popArr['post']=$postArr;
											$form_creator ->formPath ='/templates/billing/print_observation_bill.php';



										break;


case 'doctor_lab_prescription_date_ip' : 
                                      $db_function =new DBFunction();	
                                      $dr_obj=new Doctor();

                                      $get_ip_prescription_date = array();
                                      $ip_prescription_date = array();
                                      $ip_prescription_date_ordered = array();
                                      $get_ip_prescription_bill_status = array();
                                      $ip_prescription_bill_status = array();
                                      $ip_prescription_bill_status_ordered = array();
                             
                                    $ip_no=$getArr['ip_no'];
                                    $op_no=$getArr['op_no'];

                                    $firstname = $db_function->getidToValue("first_name","id",$op_no,"hcare_op_patient_info");

                                    $middlename = $db_function->getidToValue("middle_name","id",$op_no,"hcare_op_patient_info");

                                    $lastname = $db_function->getidToValue("last_name","id",$op_no,"hcare_op_patient_info");

                                    $form_creator ->popArr['patientname']=$firstname." ".$middlename." ".$lastname;

                                      $form_creator ->popArr['ipno']=$ip_no;
                                      $form_creator ->popArr['opno']=$op_no;

                                      $where[0]="ipno =".$ip_no;
                                      $where[1]="status =0";

              // $get_ip_prescription_info=$dr_obj->get_ip_Labtest_presc('',$where,'id','desc');
              $get_ip_prescription_info=$dr_obj->get_ip_Labtest_presc('',$where);
                                      
              for ($i=0; $i < count($get_ip_prescription_info); $i++) { 

                $get_ip_prescription_date[$i][0]= date("d-m-Y",strtotime($get_ip_prescription_info[$i][6]));

                 $get_ip_prescription_date[$i][1]= $get_ip_prescription_info[$i][8];
                  
              }

              $ip_prescription_date=array_unique($get_ip_prescription_date, SORT_REGULAR);

              $ip_prescription_date_ordered=array_values($ip_prescription_date);

              $form_creator ->popArr['IpPrescriptionDate']=$ip_prescription_date_ordered;
               
              $form_creator ->formPath ='/templates/billing/doctor_lab_prescription_date_ip.php';

			break;
	
	}
	
	$form_creator->display();

}

function processFinalForm($post){
  
if(count($post['item']) >0){  
   $total_bill=0;
  $balance=0;
  $amount_paid=$post['amount_paid'];
   
  
   for($i=0;$i<count($post['item']);$i++){
    
       if($post['item'][$i] > 0 ){
      
         $total_bill +=$post['item'][$i];
     
     }
   
   
   
   }
  
  $balance=((float)$total_bill-(float)$amount_paid);
  }else if(!empty($post['discount'])){

      $total_bill=$post['actual_bill'];
       $balance=$post['balance'];

			$disc_type=$post['disc_type'];
			$discount=$post['discount'];


			if($disc_type == "CASH"){
			
     			$disc_amt=$discount;
     			
			}else{
     			$disc_amt=(($balance*$discount)/100);
			}

			$balance=$balance-$disc_amt;
	}
   $data=array();
$data['total_amount']=$total_bill;
  $data['balance']=$balance;


echo json_encode($data);

}

function addMultipleCredit($postArr){

$bill_obj=new Billing();
if(!empty($postArr['paybill'])){
												
		for($i=0;$i<count($postArr['paybill']);$i++)
		{
				$arrayInfo=explode('#',$postArr['paybill'][$i]);
				$billInfo['billid']=$arrayInfo[0];
				$billInfo['amount_paid']=$arrayInfo[1];
				$billInfo['new_date']=date("Y-m-d");
				$billInfo['payment_mode']='CASH';
				$postArr['bill_no']=$bill_obj->addCredit($billInfo);
		}
}
$message="Payment Added Successfully!";
$this->viewPage('Credit_Billing',$postArr,'',$message);
}

function processBillNo($post,$action = null){

$bill_obj=new Billing();
$form_creator = new Form();
$db_function =new DBFunction();

$billid=$post['id'];

$wheredata[0]="id ='".$billid."'";

$billInfo=$bill_obj->getBillInfo($wheredata);

if(!empty($billInfo)){

	$post['billid']=$billid;
	$post['type']=$billInfo[0][1];
	$post['id']=$billInfo[0][2];
	$post['name']=$billInfo[0][3];
	$post['age']=$billInfo[0][4];
	$post['gender']=$billInfo[0][5];
	$post['place']=$billInfo[0][6];
	$post['contact_no']=$billInfo[0][7];
	
	if($billInfo[0][1] == "OP"){
		$post['doctor']=$billInfo[0][8];
		$post['ins_id']=$db_function->getidToValue("insurance_company","id",$billInfo[0][2],"hcare_op_visit_info");;
	}else{
		$post['refferal_info']=$billInfo[0][8];
	}
	$post['date']=$billInfo[0][16];
	
	$post['total_amount']=$billInfo[0][9];
	$post['dr_disc']=$billInfo[0][10];
	$post['net_amount']=$billInfo[0][11];
	$post['payment_mode']=$billInfo[0][12];
	$post['amount_paid']=$billInfo[0][13];
	$post['card_amount']=$billInfo[0][15];
	$post['ins_deduction']=$billInfo[0][20];
	$post['remarks']=$billInfo[0][17];
	$post['paction']="UPDATE";
	$post['upi_amount']=$billInfo[0][55];
	
	$wheredata[0]="bill_id ='".$billid."'";
	$wheredata[1]="package_id =0";//avoid listing subitems in package
	$billItemInfo=$bill_obj->getBillItemsInfo($wheredata);
	
	if(!empty($billItemInfo)){
	
		for($i=0;$i<count($billItemInfo);$i++) {
		
		{
			$post["items_in_array"][]=$billItemInfo[$i][4]."!$%".$billItemInfo[$i][5]."!$%".$billItemInfo[$i][7]."!$%".$billItemInfo[$i][8]."!$%".$billItemInfo[$i][9]."!$%".$billItemInfo[$i][11]."!$%".$billItemInfo[$i][3]."!$%".$billItemInfo[$i][6];
		}
	}
	
	
	
	if(!empty($action) && $action='credit_payment_form'){
	$post['balance']=$billInfo[0][14];
	return $post;
	}else{
	$form_creator ->popArr['post']=$post; 
	 $form_creator ->formPath ='/templates/billing/billing_form.php';
	}
	$form_creator ->formPath ;
	$form_creator->display();
											
}
}
}
function processIP($ipno,$docpresdate=null){

            $ip_obj= new Inpatient();
            $db_function =new DBFunction();
            $doc_obj =new Doctor();

            $total_amount=0;
          $net_amount=0;
          $dr_disc=0;

            $postArr['id']=$ipno;
  
  $selectCondition[0]="b.`id`='".$ipno."'";
  
  $patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
           
          if(!empty($patient_info)){		 
            
          $postArr['name']=$patient_info[0][1]." ".$patient_info[0][2];
		$postArr['place']=$patient_info[0][8];
		$postArr['age']=$patient_info[0][4];
		$postArr['gender']=$patient_info[0][6];
		$postArr['contact_no']=$patient_info[0][10];
		$postArr['doctor']=$patient_info[0][17]." ".$patient_info[0][18];

		$postArr['doc_id_prescribed']=$patient_info[0][16];

		// for email
		$postArr['email']=$patient_info[0][11];

		$postArr['ins_id']=$patient_info[0][23];


/***************************************** IP EMR LAB TEST AUTO BILLING STARTS ******************************************/

if(!empty($docpresdate)){

	$user_type=$_SESSION['user_type'];

          
      if ($user_type=="LAB ADMIN" || $user_type=="LAB USER") {

		$where[0]="ipno =".$ipno;
		$where[1]="date_time >='".date("Y-m-d",strtotime($docpresdate))." 00:00:00'";
		$where[2]="date_time <='".date("Y-m-d",strtotime($docpresdate))." 23:59:59'";;
		$where[3]="status =0"; 

		// $doc_prescribed_labtest = $doc_obj->get_ip_Labtest_presc('', $where,'id','desc');
		$doc_prescribed_labtest = $doc_obj->get_ip_Labtest_presc('', $where);
		
		if (!empty($doc_prescribed_labtest)) {

			$ip_labtest_pres_id = array();
				
			for ($i=0; $i <count($doc_prescribed_labtest) ; $i++) { 
				
                  $ip_labtest_pres_id[$i][0]=$doc_prescribed_labtest[$i][0];
                  $ip_labtest_pres_id[$i][1]=$doc_prescribed_labtest[$i][3]; 

				$discount_type='';
				$discount_value=0;

				$labtest=$doc_prescribed_labtest[$i][4];

				if($db_function->isValidCatagory($labtest))
				{
						
					// $tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_element");

					$new_criteria = array();
					$new_criteria[0] = "test_name = '".$labtest."'";
					$new_criteria[1] = "status = 0";

					$tid=$db_function->getIdToValueMultiple('id',$new_criteria,'hcare_lab_element');
					
					$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_element");
							//$status=$db_functions->checktestBilled($opid,$testid,"element")
							
							
					$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_element");
							
							//if($insurance_company > 0 ) {
							
					$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
					$final_amount=$discountInfo[0];
					$discount_type=$discountInfo[1];
					$discount_value=$discountInfo[2];
					$type="LE";
					$test_type=0;
							//}
						
				}
				else if($db_function->isValidTest($labtest)){
						
					// $tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_test");

					$new_criteria = array();
					$new_criteria[0] = "test_name = '".$labtest."'";
					$new_criteria[1] = "status = 0";

					$tid=$db_function->getIdToValueMultiple('id',$new_criteria,'hcare_lab_test');

					$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_test");
							//$status=$db_functions->checktestBilled($opid,$testid,"element")
					$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_test");
							
							//if($cid!=0) {
					$test_type=1;
							//}
							
							//if($insurance_company > 0 ) {
							
					$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
					$final_amount=$discountInfo[0];
					$discount_type=$discountInfo[1];
					$discount_value=$discountInfo[2];
					$type="LT";
							//}
						
				}

				$total_amount=$total_amount+$final_amount;

				$price_type='';

				$postArr['total_amount']=$total_amount;
	            $postArr['dr_disc']=$dr_disc;
	            $postArr['net_amount']= $total_amount-($total_amount*($dr_disc/100));

				$postArr["items_in_array"][]=$tid."!$%".$labtest."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%".$type."!$%".$cid."!$%".$test_type."!$%".''."!$%".''."!$%".''."!$%".$price_type."!$%".'1';


			}

			$postArr['ip_labtest_pres_id_list']=$ip_labtest_pres_id;
		}	



	}

}

/***************************************** IP EMR LAB TEST AUTO BILLING ENDS ******************************************/

		
		return $postArr;
}else echo "NO Record Found";exit();
          
         
}
function processOP($opid){

$reg_obj= new Registration();
$db_function =new DBFunction();
$doc_obj =new Doctor();

$total_amount=0;
$net_amount=0;
$dr_disc=0;

$selectCondition[0]="b.`id`='".$opid."'";
$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','desc');;
											
		$postArr['name']=$patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];
		$postArr['place']=$patientInfo[0][8];
		$postArr['age']=$patientInfo[0][4];
		$postArr['gender']=$patientInfo[0][6];
		$postArr['contact_no']=$patientInfo[0][10];
		$postArr['doctor']="Dr.".$patientInfo[0][15]." ".$patientInfo[0][16];

		// for email
		$postArr['email']=$patientInfo[0][11];

		$postArr['doc_id_prescribed']=$patientInfo[0][14];
		
		$postArr['ins_id']=$insurance_company=$patientInfo[0][22];
		$postArr['patient_cat_id']=$patientInfo[0][56];
		$postArr['patient_cat_name']=$db_function->getidToValue("patient_category","id",$patientInfo[0][56],"hcare_patient_category");
		//manage billing
		$postArr['patient_member_id']=$patientInfo[0][79];
										
			if($patientInfo[0][40] == 0){
												
				$consultaion=$patientInfo[0][17]+$patientInfo[0][18];
				$net_consultaion=$consultaion-$patientInfo[0][31];
													
					if($consultaion > 0 ) {
													
						//$discountInfo=$this->calculateInsuranceDiscount($opid,"C",$patientInfo[0][17]);						
														
														
						$postArr["items_in_array"][]="0"."!$%"."Consultation"."!$%".$consultaion."!$%"."CASH"."!$%".$patientInfo[0][31]."!$%".$net_consultaion."!$%"."C"."!$%"."0"."!$%"."0";
					}
													
							$total_amount=$total_amount+$net_consultaion;
							
			}
	$drpageInfo=$db_function->getDoctorPrescribedTest($opid);
	
	if(!empty($drpageInfo)){
	
		$dr_disc=$drpageInfo['disc_per'];
		
		if(!empty($drpageInfo['generaltest'])){					
		
			$generaltest=explode(",",$drpageInfo['generaltest']);
			for($i=0;$i<count($generaltest);$i++){
				if(!empty($generaltest[$i])){
				
					$t_name=$generaltest[$i];
					$test_id=$db_function->getidToValue("id","procedure_test",$t_name,"hcare_procedure");
					$amount=$db_function->getidToValue("amount","id",$test_id,"hcare_procedure");
					$cid=$db_function->getidToValue("category_id","id",$test_id,"hcare_procedure");
					
						//if($insurance_company > 0 ) {
						
							$discountInfo=$this->calculateInsuranceDiscount($opid,"P",$amount);
							$final_amount=$discountInfo[0];
							$discount_type=$discountInfo[1];
							$discount_value=$discountInfo[2];
						//}
					
					$total_amount=$total_amount+$final_amount;
					
					$postArr["items_in_array"][]=$test_id."!$%".$t_name."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%"."L"."!$%".$cid."!$%"."0";
				}
			}
		
		}
		if(!empty($drpageInfo['labtest'])){	
		
			$labtestpre=explode(",",$drpageInfo['labtest']);
			
			for($i=0;$i<count($labtestpre);$i++){
			
				$discount_type='';
				$discount_value=0;
			
				if(!empty($labtestpre[$i])){
				
					$labtest=$labtestpre[$i];
					
					if($db_function->isValidCatagory($labtest))
					{
					
						$tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_element");
						$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_element");
						//$status=$db_functions->checktestBilled($opid,$testid,"element")
						
						
						$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_element");
						
						//if($insurance_company > 0 ) {
						
							$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
							$final_amount=$discountInfo[0];
							$discount_type=$discountInfo[1];
							$discount_value=$discountInfo[2];
						//}
					
					}else if($db_function->isValidTest($labtest)){
					
						$tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_test");
						$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_test");
						//$status=$db_functions->checktestBilled($opid,$testid,"element")
						$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_test");
						
						//if($cid!=0) {
						$test_type=1;
						//}
						
						//if($insurance_company > 0 ) {
						
							$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
							$final_amount=$discountInfo[0];
							$discount_type=$discountInfo[1];
							$discount_value=$discountInfo[2];
						//}
					
					}
					
					$total_amount=$total_amount+$final_amount;
					
					$postArr["items_in_array"][]=$tid."!$%".$labtest."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%"."L"."!$%".$cid."!$%".$test_type;
				}
			}
		
		
		
		}
	}

/***************************************** EMR AUTO BILLING STARTS ******************************************/



	$user_type=$_SESSION['user_type'];

	if ($user_type=="RECEPTION" || $user_type=="ADMIN" || $user_type=="ADMIN+DOCTOR") {


		$where[0]="visit_id =".$opid;
		$where[1]="status =0"; 

		$doc_prescribed_proceedure = $doc_obj->getProcedure_presc('', $where);

		if (!empty($doc_prescribed_proceedure)) {
			
			for ($i=0; $i <count($doc_prescribed_proceedure) ; $i++) { 
				
				$test_id=$doc_prescribed_proceedure[$i][3];
				$t_name=$db_function->getidToValue("procedure_test","id",$test_id,"hcare_procedure");
				$amount=$db_function->getidToValue("amount","id",$test_id,"hcare_procedure");
				$cid=$db_function->getidToValue("category_id","id",$test_id,"hcare_procedure");



				$discountInfo=$this->calculateInsuranceDiscount($opid,"P",$amount);
				$final_amount=$discountInfo[0];
				$discount_type=$discountInfo[1];
				$discount_value=$discountInfo[2];

				$price_type=$db_function->getidToValue("price_type","id",$test_id,"hcare_procedure");

				$total_amount=$total_amount+$final_amount;

				$postArr["items_in_array"][]=$test_id."!$%".$t_name."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%"."P"."!$%".$cid."!$%"."0"."!$%".''."!$%".''."!$%".''."!$%".$price_type."!$%".'1';


			}


		}


	}


	if ($user_type=="LAB ADMIN" || $user_type=="LAB USER" || $user_type=="LAB" || $user_type=="ADMIN" || $user_type=="ADMIN+DOCTOR" ) {
		

		$where[0]="visit_id =".$opid;
		$where[1]="status =0"; 

		$doc_prescribed_labtest = $doc_obj->getLabtest_presc('', $where,'id','desc');
		
		if (!empty($doc_prescribed_labtest)) {
				
			for ($i=0; $i <count($doc_prescribed_labtest) ; $i++) { 
				

				$discount_type='';
				$discount_value=0;

				$labtest=$doc_prescribed_labtest[$i][4];

				if($db_function->isValidCatagory($labtest))
				{
						
					// $tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_element");

					$new_criteria = array();
					$new_criteria[0] = "test_name = '".$labtest."'";
					$new_criteria[1] = "status = 0";

					$tid=$db_function->getIdToValueMultiple('id',$new_criteria,'hcare_lab_element');
					
					$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_element");
							//$status=$db_functions->checktestBilled($opid,$testid,"element")
							
							
					$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_element");
							
							//if($insurance_company > 0 ) {
							
					$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
					$final_amount=$discountInfo[0];
					$discount_type=$discountInfo[1];
					$discount_value=$discountInfo[2];
					$type="LE";
					$test_type=0;
							//}
						
				}
				else if($db_function->isValidTest($labtest)){
						
					// $tid=$db_function->getidToValue("id","test_name",$labtest,"hcare_lab_test");

					$new_criteria = array();
					$new_criteria[0] = "test_name = '".$labtest."'";
					$new_criteria[1] = "status = 0";

					$tid=$db_function->getIdToValueMultiple('id',$new_criteria,'hcare_lab_test');

					$cid=$db_function->getidToValue("category","id",$tid,"hcare_lab_test");
							//$status=$db_functions->checktestBilled($opid,$testid,"element")
					$amount=$db_function->getidToValue("price","id",$tid,"hcare_lab_test");
							
							//if($cid!=0) {
					$test_type=1;
							//}
							
							//if($insurance_company > 0 ) {
							
					$discountInfo=$this->calculateInsuranceDiscount($opid,"L",$amount);
					$final_amount=$discountInfo[0];
					$discount_type=$discountInfo[1];
					$discount_value=$discountInfo[2];
					$type="LT";
							//}
						
				}

				$total_amount=$total_amount+$final_amount;

				$price_type='';

				$postArr["items_in_array"][]=$tid."!$%".$labtest."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%".$type."!$%".$cid."!$%".$test_type."!$%".''."!$%".''."!$%".''."!$%".$price_type."!$%".'1';


			}

		}	



	}



	if ($user_type=="RECEPTION" || $user_type=="ADMIN" || $user_type=="ADMIN+DOCTOR" || $user_type=="XRAY" ) {


		$where[0]="visit_id =".$opid;
		$where[1]="status =0"; 

		$doc_prescribed_radiology = $doc_obj->getRadiology_presc('', $where);

		if (!empty($doc_prescribed_radiology)) {
			
			for ($i=0; $i <count($doc_prescribed_radiology) ; $i++) { 
				
				$test_id=$doc_prescribed_radiology[$i][3];
				$t_name=$db_function->getidToValue("procedure_test","id",$test_id,"hcare_procedure");
				$amount=$db_function->getidToValue("amount","id",$test_id,"hcare_procedure");
				$cid=$db_function->getidToValue("category_id","id",$test_id,"hcare_procedure");



				$discountInfo=$this->calculateInsuranceDiscount($opid,"P",$amount);
				$final_amount=$discountInfo[0];
				$discount_type=$discountInfo[1];
				$discount_value=$discountInfo[2];

				$total_amount=$total_amount+$final_amount;

				$price_type='';

				$postArr["items_in_array"][]=$test_id."!$%".$t_name."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%"."P"."!$%".$cid."!$%"."0"."!$%".''."!$%".''."!$%".''."!$%".$price_type."!$%".'1';


			}


		}


	}



/***************************************** EMR AUTO BILLING ENDS ******************************************/





	$postArr['id']=$opid;
	$postArr['total_amount']=$total_amount;
	$postArr['dr_disc']=$dr_disc;
	$postArr['net_amount']= $total_amount-($total_amount*($dr_disc/100));
	
	$postArr['observation_show']=$patientInfo[0][60];

	return $postArr;

}

function process_select_bill($post){

	$form_creator = new Form();
	
	$form_creator ->popArr['post']=$post;
	$form_creator ->formPath ='/templates/billing/selectBill.php';
	$form_creator->display();
}
function calculateInsuranceDiscount($opid,$type,$amount){

$db_function =new DBFunction();

$discount_type='';
$discount_value=0;
$final_amount=$amount;

$ins_id=$db_function->getidToValue("insurance_company","id",$opid,"hcare_op_visit_info");

if($ins_id >0 && !empty($opid)){
		
		if($type == "C") {
		
			$discount_type=$db_function->getidToValue("cons_disc_type","ins_id",$ins_id,"hcare_insurance_discount_info");
			$discount_value=$db_function->getidToValue("cons_disc_value","ins_id",$ins_id,"hcare_insurance_discount_info");
			
		}else if($type == "LT" || $type=="LE"){
		
			$discount_type=$db_function->getidToValue("lab_disc_type","ins_id",$ins_id,"hcare_insurance_discount_info");
			$discount_value=$db_function->getidToValue("lab_disc_value","ins_id",$ins_id,"hcare_insurance_discount_info");
		}else{
			$discount_type=$db_function->getidToValue("test_disc_type","ins_id",$ins_id,"hcare_insurance_discount_info");
			$discount_value=$db_function->getidToValue("test_disc_value","ins_id",$ins_id,"hcare_insurance_discount_info");
		}
		
			
		if((!empty($discount_type)) && $discount_value >0) {
			
				if($discount_type == "CASH"){

				    if($amount>=$discount_value)
                          {
					      $final_amount=$amount-$discount_value;
                          }
                      else{
                            $final_amount=$amount;
                          }

				}else {
					$final_amount=$amount-($amount*($discount_value/100));
				}
		}
}
         
return array($final_amount,$discount_type,$discount_value);

}

function calculatePatientCategoryDiscount($opid,$type,$amount,$patient_type){

$db_function =new DBFunction();

$discount_type='';
$discount_value=0;
$final_amount=$amount;
if($patient_type=='OP'){

  $patient_cat_id=$db_function->getidToValue("patient_category","id",$opid,"hcare_op_visit_info");

}
if($patient_type=='IP'){

  $patient_cat_id=$db_function->getidToValue("patient_category","id",$opid,"hcare_ip_info");

}


if($patient_cat_id >0 && !empty($opid)){
		
	if($type == "C") {
		
			$discount_type=$db_function->getidToValue("cons_disc_type","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
			$discount_value=$db_function->getidToValue("cons_disc_value","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
			
	}else if($type == "LT" || $type=="LE"){
		
			$discount_type=$db_function->getidToValue("lab_disc_type","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
			$discount_value=$db_function->getidToValue("lab_disc_value","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
	}else{
			$discount_type=$db_function->getidToValue("test_disc_type","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
			$discount_value=$db_function->getidToValue("test_disc_value","patient_category_id",$patient_cat_id,"hcare_patient_category_discount_info");
	}
		
			
	if((!empty($discount_type)) && $discount_value >0) {
			
				if($discount_type == "CASH"){

				    if($amount>=$discount_value)
                          {
					      $final_amount=$amount-$discount_value;
                          }
                      else{
                            $final_amount=$amount;
                          }

				}else {
					$final_amount=$amount-($amount*($discount_value/100));
				}
	}
}
         
return array($final_amount,$discount_type,$discount_value);

}

function process_bill_form($post,$get){

$db_function =new DBFunction();
$form_creator = new Form();
$emp_obj=new Employee();

$ip_labtest_pres_id_list = array();
$ip_labtest_pres_id_list_order = array();

$total_amount=0;
$net_amount=0;

$patient_type=$post['type'];
$opid=$post["id"];

/*****ip_doctor_prescribed_medicines_array****start*****/

  $ip_labtest_pres_id=$post['ip_labtest_pres_id'];
  $remove_test_id=$post['removeitemid'];

if(!empty($ip_labtest_pres_id)){

  for ($l=0; $l <count($ip_labtest_pres_id); $l++) { 
  	
  	//removing prescription process
      if($ip_labtest_pres_id[$l][1]!=$remove_test_id){

          $ip_labtest_pres_id_list[$l][0]=$ip_labtest_pres_id[$l][0];
          $ip_labtest_pres_id_list[$l][1]=$ip_labtest_pres_id[$l][1];

      }

  }

$ip_labtest_pres_id_list_order=array_values($ip_labtest_pres_id_list);

}

  $post['ip_labtest_pres_id_list']=$ip_labtest_pres_id_list_order;

/*****ip_doctor_prescribed_medicines_array****ends*****/

// $post['ins_id']=$ins_id=$db_function->getidToValue("insurance_company","id",$opid,"hcare_op_visit_info");	
$post['patient_cat_name']=$db_function->getidToValue("patient_category","id",$post['patient_cat_id'],"hcare_patient_category");
$items=$post['items'];

if(count($items) == 0) unset($_SESSION['changeamt']);
if(count($items) > 0){
     
	unset($post['items']);
	$j=0;
	$rm=1;
	for($i=0;$i<count($items);$i++){
	
		$rm=1;
		if($get['action'] == "RM"){

 			$loc=$get['loc'];
			
			if($i==$loc){
			$rm=0;
			unset($_SESSION['changeamt'][$i]);
           }
 		}
		if($get['action'] == "INS"){

 			$loc=$get['loc'];
			
			if($i==$loc) {
			
				if($items[$i][9] == "CASH") $items[$i][9]="INSURANCE";
				else $items[$i][9]="CASH";
			}
 
 		}


		if (!empty($items[$i][13])) {
			$qty[$i]=$items[$i][13];
			$items[$i][5] = $items[$i][13]*$items[$i][2];
		}
		else{
			$qty[$i]=1;
			$items[$i][5] = $items[$i][5];
		}

		//Calculate discount
		if(!empty($items[$i][3]) && !empty($items[$i][4])){
		
			if($items[$i][3] == 'CASH'){
                  if($items[$i][2]>=$items[$i][4])
                      {
				       $items[$i][5]=$items[$i][5]-$items[$i][4];
                      }
				else{
                         $items[$i][5]=$items[$i][5];
				    }

			}else if($items[$i][3] == '%'){
				$items[$i][5]=$items[$i][5]-($items[$i][5]*($items[$i][4]/100));
			}
			
		}else $items[$i][5]=$items[$i][5];
		if($rm!=0) {				
			
			//For Mode Insurance



			
				$post["items_in_array"][$j++]=$items[$i][0]."!$%".$items[$i][1]."!$%".$items[$i][2]."!$%".$items[$i][3]."!$%".$items[$i][4]."!$%".$items[$i][5]."!$%".$items[$i][6]."!$%".$items[$i][7]."!$%".$items[$i][8]."!$%".$items[$i][9]."!$%".$items[$i][10]."!$%".$items[$i][11]."!$%".$items[$i][12]."!$%".$qty[$i]."!$%".$items[$i][14]."!$%".$items[$i][15];
		
			$total_amount=$total_amount+$items[$i][5];
			
		
	}	
	
}	
}

if(!empty($post['particulars'])){

	
	$pInfo=explode(" -",$post['particulars_ID']);
	$particular=$post['particulars'];
	
	$ptype=$pInfo[0];
	$pid=$pInfo[1];
	$test_type=0;

	$qty="1";
	
	                $hosp_amount=0;
			$dr_amount=0;
			$surgeon_fee=0;
			$theatre_charge=0;
			$anasthesia=0;
			$other_charges=0;
			$gynec_fee=0;
                                  $room_charges=0;
	
	if($pid > 0) {  
	                
		if($ptype == "LT"){
	                         
		
		  $amount=$db_function->getidToValue("price","id",$pid,"hcare_lab_test");
		  $cid=$db_function->getidToValue("category","id",$pid,"hcare_lab_test");
		  $price_type="";
		//if($cid!=0) {
			$test_type=1;
		//}
			
			
			if($post['ins_id']>0)
			     {
			        $discountInfo=$this->calculateInsuranceDiscount($opid,"LT",$amount);
		         }
		    elseif($post['patient_cat_id']>0) 
		         {   
		            $discountInfo=$this->calculatePatientCategoryDiscount($opid,"LT",$amount,$patient_type);
		         }
		    else {
		     	    $discountInfo=array();

		     	    $discountInfo[0]=$amount;
			        $discountInfo[1]='';
			        $discountInfo[2]=0;
		         }  

			$discount_type=$discountInfo[1];
			$discount_value=$discountInfo[2];
			$final_amount=$discountInfo[0];
		
		}else if($ptype == "LE"){
		     $amount=$db_function->getidToValue("price","id",$pid,"hcare_lab_element");
		     $cid=$db_function->getidToValue("category","id",$pid,"hcare_lab_element");
		     $price_type="";
		     
		    if($post['ins_id']>0)
			     {  
			        $discountInfo=$this->calculateInsuranceDiscount($opid,"LE",$amount);	
		         }
		    elseif($post['patient_cat_id']>0) 
		         {  
		            $discountInfo=$this->calculatePatientCategoryDiscount($opid,"LE",$amount,$patient_type);
		         }
		    else {
		     	    $discountInfo=array();

		     	    $discountInfo[0]=$amount;
			        $discountInfo[1]='';
			        $discountInfo[2]=0;
		         }  
		    
		    $discount_type=$discountInfo[1];
			$discount_value=$discountInfo[2];
			$final_amount=$discountInfo[0];
		
		}else if($ptype == "P"){
	
	
			$amount=$db_function->getidToValue("total","id",$pid,"hcare_procedure");
		    $dr_amount=$db_function->getidToValue("dr_amount","id",$pid,"hcare_procedure");
			$surgeon_fee=$db_function->getidToValue("surgeon_fee","id",$pid,"hcare_procedure");
			$cid=$db_function->getidToValue("category_id","id",$pid,"hcare_procedure");
			$price_type=$db_function->getidToValue("price_type","id",$pid,"hcare_procedure");

			$gynec_fee=$db_function->getidToValue("gynec_fee","id",$pid,"hcare_procedure");
			$room_charges=$db_function->getidToValue("room_charges","id",$pid,"hcare_procedure");

			if($post['ins_id']>0)
			     {
			        $discountInfo=$this->calculateInsuranceDiscount($opid,"P",$amount);	
		         }
		    elseif($post['patient_cat_id']>0) 
		         { 
		            $discountInfo=$this->calculatePatientCategoryDiscount($opid,"P",$amount,$patient_type);
		         }
		    else {
		     	    $discountInfo=array();

		     	    $discountInfo[0]=$amount;
			        $discountInfo[1]='';
			        $discountInfo[2]=0;
		         }  
			
			
			$discount_type=$discountInfo[1];
			$discount_value=$discountInfo[2];
			$final_amount=$discountInfo[0];
			
			
		}else if($ptype == "PACKAGE"){
	
	
			$amount=$db_function->getidToValue("amount","id",$pid,"hcare_healthcheckup_package");
		    	$dr_amount=$db_function->getidToValue("dr_amount","id",$pid,"hcare_healthcheckup_package");

		    	$doctor_added=$db_function->getidToValue("doctor","id",$pid,"hcare_healthcheckup_package");
			
			$cid=0;
			$discount_type="";
			$discount_value="0";
			$final_amount=$amount;
			$price_type="";
			
			
		}
	

	
		$total_amount=$total_amount+$final_amount;
	
			if (empty($doctor_added)) {
				$doctor_added=0;
			}
		
	
			$post["items_in_array"][]=$pid."!$%".$particular."!$%".$amount."!$%".$discount_type."!$%".$discount_value."!$%".$final_amount."!$%".$ptype."!$%".$cid."!$%".$test_type."!$%".$doctor_added."!$%".$dr_amount."!$%".$surgeon_fee."!$%".$price_type."!$%".$qty."!$%".$gynec_fee."!$%".$room_charges;
		
	}else $form_creator ->popArr['message']="Invalid Item Selected";
}

$net_amount= $total_amount-($total_amount*($post['dr_disc']/100));

$post['total_amount']=$total_amount;
$post['net_amount']=$net_amount;
$form_creator ->popArr['post']=$post;	

// var_dump($post);

  $is_field[0]="a.title='Dr'";												
$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);	

$form_creator ->formPath ='/templates/billing/billing_form.php';
$form_creator->display();

}
function add_changeamount_billing($post){

if (!empty($post['theatre_proceedure'])) {

  $data['total_amount']=$post['amount']+$post['surgeon_fee']+$post['assistant_fee1']+$post['assistant_fee2']+$post['anethesia_charge']+$post['theatre_charge']+$post['other_charges'];
	  $_SESSION['changeamt'][$post['pos']]=$post['procedure']."!$%".$post['amount']."!$%".$post['dr_amount']."!$%".$post['surgeon_fee']."!$%".$post['assistant_fee1']."!$%".$post['assistant_fee2']."!$%".$post['anethesia_charge']."!$%".$post['theatre_charge']."!$%".$post['other_charges']."!$%"."THEATRE PROCEDURE";
}
else{

  $data['total_amount']=$post['amount']+$post['dr_amount'];
  $_SESSION['changeamt'][$post['pos']]=$post['procedure']."!$%".$post['amount']."!$%".$post['dr_amount']."!$%".$post['surgeon_fee']."!$%".$post['assistant_fee1']."!$%".$post['assistant_fee2']."!$%".$post['anethesia_charge']."!$%".$post['theatre_charge']."!$%".$post['other_charges']."!$%"."NOT THEATRE PROCEDURE";

}


echo json_encode($data);
}
function process_billing($post){

$bill_obj=new Billing();
$db_function =new DBFunction();
$reg_obj= new Registration();
$comm_obj= new commonFunctions();
$pack_obj=new Health_package();
$dr_obj = new Doctor();

$ip_labtest_pres_id=array();

$items=$post['items'];
			
if(count($items) > 0){

	if($post['paction'] == "ADD"){
	
		if($post['type'] == "DIRECT"){
		
		     $post['prefix']=$comm_obj->getRegPrefix($post['type']);
	
			$post['id']=$bill_obj->addCustomer($post);
			$post['opno']=0;
		}else if($post['type'] == "OP"){				
		
		$post['opno']=$db_function->getidToValue("opno","id",$post['id'],"hcare_op_visit_info");				
		}else{
		  $post['opno']=$db_function->getidToValue("opno","id",$post['id'],"hcare_ip_info");
		}

		$post['billid']=$bill_id=$bill_obj->addToBill($post);

/************hcare_ip_labtest_prescribed Table Update**************/
      
  $ip_labtest_pres_id=$post['ip_labtest_pres_id'];
if(!empty($ip_labtest_pres_id)){
  for ($l=0; $l <count($ip_labtest_pres_id); $l++) { 
  	
    $result_id=$dr_obj->update_billid_ip_labtest_prescribed($bill_id,$ip_labtest_pres_id[$l][0]);

  }
}

/************hcare_ip_labtest_prescribed Table Update**************/

		if($bill_id >0 ) {		

			for($i=0;$i<count($items);$i++){
		
				if($items[$i][6] == "C" && $post['type'] == "OP"){
				
					$reg_obj->updatePaidStatus($post['id'],1);
				}
				$sub_amounts=array();
				
				$post['package_id']='';
				
			if($items[$i][6] == "P"){
				
				//theatre charge entered by supernurse
				if(!empty($_SESSION['changeamt'][$i])){
				
				    $items_in_array=explode("!$%",$_SESSION['changeamt'][$i]);         


				    if (  $_SESSION['user_type'] == "SUPER NURSE" && $post['type'] == "IP" ) {


                      	$sub_amounts[0]=$items_in_array[1];
				        $sub_amounts[1]=0;
				        $sub_amounts[2]=$items_in_array[3];
				        $sub_amounts[3]=$items_in_array[7];
				        $sub_amounts[4]=$items_in_array[6];
				        $sub_amounts[5]=$items_in_array[8];
					    $sub_amounts[6]=$items_in_array[4];
				        $sub_amounts[7]=$items_in_array[5];

				    }
				    else{

                         $sub_amounts[0]=$items_in_array[1];
				        $sub_amounts[1]=$items_in_array[2];
				        $sub_amounts[2]=$items_in_array[3];
				        $sub_amounts[3]=$items_in_array[7];
				        $sub_amounts[4]=$items_in_array[6];
				        $sub_amounts[5]=$items_in_array[8];
					    $sub_amounts[6]=$items_in_array[4];
				        $sub_amounts[7]=$items_in_array[5];


				    }





                  }else{						
				    $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
				    $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
				}
				    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
				
		         }else if($items[$i][6] == "PACKAGE"){
			 
			    //add package name here heading 1
			    
			   
			     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
			     
			     //add package elements
			     
			    $package_id=$items[$i][0];
			    $hElemCondn[0]="package_id =".$package_id;
			    $hElemCondn[1]="status =0";
			    $packageElements=$pack_obj->getHealthPackageElements('',$hElemCondn);
			    
			    if(!empty($packageElements)){
			        for($k=0;$k<count($packageElements);$k++){
				
				  $post['package_id']=$package_id;
				  $test_type=$packageElements[$k][2];
				  
				  $items[$i][0]=$packageElements[$k][1];
				  $items[$i][2]=$packageElements[$k][4];
				  $items[$i][3]="";
				  $items[$i][4]="";
				  $items[$i][5]=$packageElements[$k][4];
				  $items[$i][7]=$packageElements[$k][5];
				  if($test_type == "P"){
				  
				         $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
				         $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
				     
				     $items[$i][6]="P";
				     $items[$i][8]=0;
				     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
				  }else{
				    $items[$i][6]=$test_type;
				    
				    if($test_type == "LT") $items[$i][8]=1;
				    else $items[$i][8]=0;
				    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
				    
				    
				  }
				}
			    }
			 }else{
				$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
			  }
			}
		}
		unset($_SESSION['changeamt']);
	}else{
	
		$bill_id=$post['billid'];
		
		if($post['type'] == "DIRECT"){
	
			$post['id']=$db_function->getidToValue("ref_no","id",$bill_id,"hcare_bill");
			$bill_obj->updateCustomer($post);
		}
		
		$bill_obj->updateBill($post);
		$bill_obj->deleteBillItems($post);
		
		for($i=0;$i<count($items);$i++){
		
			
				$sub_amounts=array();
				
				$post['package_id']='';
				
			if($items[$i][6] == "P"){
				
				$sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
				$sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
			        $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
				
				$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
				
		         }else if($items[$i][6] == "PACKAGE"){
			 
			    //add package name here heading 1
			    
			   
			     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
			     
			     //add package elements
			     
			    $package_id=$items[$i][0];
			    $hElemCondn[0]="package_id =".$package_id;
			    $hElemCondn[1]="status =0";
			    $packageElements=$pack_obj->getHealthPackageElements('',$hElemCondn);
			    
			    if(!empty($packageElements)){
			        for($k=0;$k<count($packageElements);$k++){
				
				  $post['package_id']=$package_id;
				  $test_type=$packageElements[$k][2];
				  
				  $items[$i][0]=$packageElements[$k][1];
				  $items[$i][2]=$packageElements[$k][4];
				  $items[$i][3]="";
				  $items[$i][4]="";
				  $items[$i][5]=$packageElements[$k][4];
				  $items[$i][7]=$packageElements[$k][5];
				  if($test_type == "P"){
				  
				     $sub_amounts[0]=$db_function->getidToValue("amount","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[1]=$db_function->getidToValue("dr_amount","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[2]=$db_function->getidToValue("surgeon_fee","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[3]=$db_function->getidToValue("theatre_charge","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[4]=$db_function->getidToValue("anasthesia","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[5]=$db_function->getidToValue("other_charges","id",$items[$i][0],"hcare_procedure");
				     $sub_amounts[6]=$db_function->getidToValue("assistant_fee1","id",$items[$i][0],"hcare_procedure");
			             $sub_amounts[7]=$db_function->getidToValue("assistant_fee2","id",$items[$i][0],"hcare_procedure");
				     
				     $items[$i][6]="P";
				     $items[$i][8]=0;
				     $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post,$sub_amounts);
				  }else{
				    $items[$i][6]=$test_type;
				    
				    if($test_type == "LT") $items[$i][8]=1;
				    else $items[$i][8]=0;
				    $id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
				    
				    
				  }
				}
			    }
			 }else{
				$id=$bill_obj->addToBillItems($bill_id,$items[$i],$post);
			  }
			
		}
	
	}
}


// if ( !empty($post['observation_show']) && $post['observation_show']=="YES" ) {

// 	$reg_obj->updateObservation($post['id'],'NO');
// }


$this->viewPage('Print_Bill',$post,'',$result);

}

function deleteBill($post){

$bill_obj=new Billing();
$reg_obj= new Registration();
$db_function =new DBFunction();

$bill_obj->cancelBill($post);

$opid=$db_function->getidToValue("ref_no","id",$post['id'],"hcare_bill");
//$reg_obj->updatePaidStatus($opid,0);
$bill_obj->cancelBillItems($post);

$this->viewPage('Manage_Billing',$post,'',$result);
}

function add_advance_payment($post){

   $bill_obj=new Billing();
   $com_obj = new CommonFunctions();
   
   
   
   $post['curr_date_time']=$com_obj->getcurrentDate("Y-m-d H:i:s");
   $post['billid']=$bill_id=$bill_obj->add_advance_payment($post);
   
   $this->viewPage('Print_Advance_Bill',$post);
}

function add_final_payment($post){

$bill_obj=new Billing();
$com_obj = new CommonFunctions();
$room_obj=new Room();
$ip_obj=new Inpatient;
$db_function =new DBFunction();


$post['curr_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");
$post['curr_time']=$com_obj->getcurrentDate("h:i a");

if(empty($post['billid'])) {

   $post['opno']=$db_function->getidToValue("opno","id",$post['id'],"hcare_ip_info");
  $post['billid']=$bill_obj->add_ip_bill($post);

 $items=$post['item'];
 $particulars=$post['particulars'];
$item_id=$post['item_id'];

  $qty=$post['qty'];
  $price=$post['price'];

  $proce_id=$post['proce_id'];
  $item_type=$post['item_type'];

 for($i=0;$i<count($items);$i++){
 
   if($items[$i] > 0 ) {
      $result= $bill_obj->add_ip_bill_items($post['billid'],$items[$i],$particulars[$i],$item_id[$i],$qty[$i],$price[$i],$proce_id[$i],$item_type[$i]);

    }
 }
 //update bill status
$ip_obj->update_bill_status($post);

$this->viewPage('Print_IP_Bill',$post,'',$result);
}else{	

//update bill

$bill_obj->update_ip_bill($post);
// add discharge date

$ip_obj->add_discharge_date($post);

//change room status

 $bed_id=$db_function->getidToValue("bed_id","id",$post['id'],"hcare_ip_info");
 $room_obj->updateBedStatus("FREE",$bed_id);

$post['bill_status']=1;//paid
$ip_obj->update_bill_status($post);

$this->viewPage('Print_IP_Bill',$post,'',$result);
}
 
 
}
function cancel_ip_bill($post){

$bill_obj=new Billing();
$ip_obj=new Inpatient;
$com_obj = new CommonFunctions();

$post['curr_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");

if(!empty($post['id'])){
													 
     $wheredata[0]="ipno ='".$post['id']."'";
	$wheredata[1]="bill_status =2";
	
	$billInfo=$bill_obj->getIPBillInfo($wheredata);

   $bill_id=$billInfo[0][0];
   $post['billid']=$bill_id;
   $post['bill_status']=3;
   
}else if(!empty($post['billid'])){

	$bill_id=$post['billid'];
	 $post['bill_status']=1;
}

$bill_obj->cancel_ip_bill($post);
$bill_obj->cancel_ip_bill_items($post);
$ip_obj->update_bill_status($post);

 if(!empty($postArr['id'])){
  $this->viewPage('IP_Search',$post);
}else{
$this->viewPage('IP_Search',$post);
}
}

function change_doctor_billing_item($post){

 $bill_obj=new Billing();
$data=array();
$data['result']=$bill_obj->change_doctor_billing_item($post);
 echo json_encode($data);
}

function add_ip_credit_payment($post){

$bill_obj=new Billing();
$db_function =new DBFunction();
$com_obj = new CommonFunctions();

$billid=$post['billid'];

if($post['payment_mode'] == "CREDIT CARD"){

 $amount_paid =$post['cash_amount'] + $post['card_amount'];
 
}elseif($post['payment_mode'] == "UPI"){
$amount_paid =$post['cash_amount'] + $post['upi_amount'];

}else $amount_paid =$post['cash_amount'];

$credit_paid=$db_function->getidToValue("credit_paid","id",$billid,"hcare_ip_bill");
$balance=$db_function->getidToValue("balance","id",$billid,"hcare_ip_bill");

$credit_paid +=$amount_paid;
$balance -= $amount_paid;

$bill_obj->update_credit_status($billid,$credit_paid,$balance);

$post['ipno']=$db_function->getidToValue("ipno","id",$billid,"hcare_ip_bill");
$post['opno']=$db_function->getidToValue("opno","id",$billid,"hcare_ip_bill");
$post['bill_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");

$bill_obj->add_ip_credit_payment($post);

$this->viewPage('Manage_IP_Credits',$post);
}

function addMultipleCreditip($postArr){

$bill_obj=new Billing();
$db_function =new DBFunction();

if(!empty($postArr['paybill'])){
												
		for($i=0;$i<count($postArr['paybill']);$i++)
		{
				$arrayInfo=explode('#',$postArr['paybill'][$i]);
				$credit_paid=0;
				$balance=0;
				$billInfo=array();
				$billInfo['billid']=$arrayInfo[0];
				$billInfo['payment_mode']="CASH";
				$billInfo['cash_amount']=$postArr['amount'][$i];
				
				$credit_paid=$db_function->getidToValue("credit_paid","id",$billInfo['billid'],"hcare_ip_bill");
                                     

                                     $credit_paid +=$postArr['amount'][$i];
                                     $balance = 0;

                                     $bill_obj->update_credit_status($billInfo['billid'],$credit_paid,$balance);

				$billInfo['bill_date']=date("Y-m-d H:i:s");
				$billInfo['ipno']=$db_function->getidToValue("ipno","id",$arrayInfo[0],"hcare_ip_bill");
                                     $billInfo['opno']=$db_function->getidToValue("opno","id",$arrayInfo[0],"hcare_ip_bill");
				$billInfo['remarks']="";
				$bill_obj->add_ip_credit_payment($billInfo);
		}
}
$message="Payment Added Successfully!";
$this->viewPage('Manage_IP_Credits',$postArr,'',$message);
exit;
}
function procedure_amount($post)
{
$db_function =new DBFunction();
 
  $data=array();
 $data['amount']=$db_function->getidToValue("total","id",$post['procedure_ID'],"hcare_procedure");

echo json_encode($data);  
}

function update_ip_addon_field($post){
$bill_obj=new Billing();
											      
$billInfo=$bill_obj->update_newfield_bill_items($post);
 

$this->viewPage('ip_bill_items_list',$post,'','');

}
function cancel_advance_payment($post){

$bill_obj=new Billing();
$com_obj = new CommonFunctions();

$post['cancel_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");

if(!empty($post['billid'])){
													 
    $bill_obj->cancel_advance_payment($post);
   
}

$this->viewPage('Manage_IP_Payments',$post);

}
function add_patient_document($post){

  $dr_obj=new Doctor();
  $db_obj=new DBFunction();	

  $opno=$post['opno'];
  $ipno=$post['ipno'];
  $visit_id=$post['visit_id'];
  $bill_id=$post['bill_id'];
  $cust_type=$post['cust_type'];
  $direct_id=$post['direct_id'];
  $xray_status=$post['xray_status'];


  $file_name = $_FILES['document']['name'];
  $remark = $post['remark'];
  $documentInfo['opno']=$opno;
  $documentInfo['ipno']=$ipno;
  $documentInfo['visit_id']=$visit_id;
  $documentInfo['document_name']=$file_name;
  $documentInfo['remarks']=$remark;
  $documentInfo['bill_id']=$bill_id;
  $documentInfo['cust_type']=$cust_type;
  $documentInfo['direct_id']=$direct_id;
  $documentInfo['xray_status']=$xray_status;


  $allowed =  array('gif','png' ,'jpg', 'pdf', 'doc', 'docx', 'dcm');
  $file_name = $_FILES['document']['name'];
  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
  if(!empty($direct_id)){
  	  $file_path = "../../lib/patient_documents/DIRECT/".$documentInfo['direct_id']."/";
  }else{
  	  $file_path = "../../lib/patient_documents/".$documentInfo['opno']."/";
  }
 

          

    //FILE SIZE AND TYPE CHECKING      
  // if(!in_array($ext,$allowed)) {
			  		
		// 	$getArr['billno']=$post['bill_id'];
		// 	$this->viewPage('xray_attahments','',$getArr); 
		// 	echo "<script>showDialog('Error','File type not allowed','error',0);</script>";

  // }
  // else{
  			//FILE PATH CHECKING
			if (!is_dir($file_path)){

			mkdir($file_path, 0755);
			move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

												  
			}
			else{
				 
				 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
			
			}


				$dr_obj->add_patient_document($documentInfo);
				$getArr['billno']=$post['bill_id'];
    				$this->viewPage('xray_attahments',$post,$getArr); 




  // }

}

function delete_patient_document($post){

    
         $dr_obj=new Doctor();
        
        $id=$post['hidden_remove'];

        $dr_obj->delete_patient_document($id);

		$getArr['billno']=$post['bill_id'];

    		$this->viewPage('xray_attahments',$post,$getArr); 

                                
}
function Print_Bill_Observation($post){


	$bill_obj=new Billing();
	$db_function =new DBFunction();
												

	if(!empty($post['billid'])){

		$wheredata[0]="id ='".$post['billid']."'";

	}
											
	$bill_info=$bill_obj->getObservationBillInfo($wheredata);


	return $bill_info;
                                          


}

//for labour charges
function deliveryCharges($test_id,$bill_id){
$db_function =new DBFunction();
$gynec=$db_function->getidToValue("gynec_fee","id",$test_id,"hcare_procedure");		
$room_charge=$db_function->getidToValue("room_charges","id",$test_id,"hcare_procedure");			
$discount_type=$db_function->getidToValue("discount_type","bill_id",$bill_id,"hcare_bill_items");			
$discount_value=$db_function->getidToValue("discount_value","bill_id",$bill_id,"hcare_bill_items");
if($discount_type=='CASH'){
	$gynec = $gynec-($discount_value/2);
	$room_charge = $room_charge-($discount_value/2);
}
else if($discount_type=='%'){
	$gynec = $gynec-($gynec*$discount_value/100);
	$room_charge = $room_charge-($room_charge*$discount_value/100);
}
$arrayList['gynec'] = $gynec;
$arrayList['room_charge'] = $room_charge;

return $arrayList;

}


function cancel_credit_payment($post){


$bill_obj=new Billing();
$com_obj = new CommonFunctions();

//$post['cancel_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");

// var_dump($post);exit();

if(!empty($post['billid'])){
													 
    $bill_obj->deleteCreditBillpayments($post);
   
}

$this->viewPage('Manage_Credit_Billing',$post,'','');

}

function cancel_ip_discharge_bill($post){

$bill_obj=new Billing();
$ip_obj=new Inpatient;
$com_obj = new CommonFunctions();
$room_obj = new Room();

 $post['curr_date']=$com_obj->getcurrentDate("Y-m-d H:i:s");

if(!empty($post['billid'])){

	$bill_id=$post['billid'];
	// $post['cancellation_details']='CANCELLED AFTER DISCHARGE';
	$post['bill_status']=1;

     $wheredata[0]="ipno ='".$post['ip_no']."'";
	$wheredata[1]="bill_status =2";
	
	$billInfo=$bill_obj->getIPBillInfo($wheredata);

	$bed_id = $billInfo[0][32];

}
// var_dump($billInfo);exit();
 $bill_obj->cancel_ip_bill($post);
 $bill_obj->cancel_ip_bill_items($post);
 $ip_obj->update_bill_status_discharge($post);
 $room_obj->updateBedStatus('ADMITTED',$bed_id);

 $this->viewPage('IP_Search',$post);


}

}


?>
