<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/common/smsFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/admin/department.php';
require_once ROOT_PATH . '/lib/model/booking/scheduling.php';
require_once ROOT_PATH . '/lib/model/booking/booking.php';
require_once ROOT_PATH . '/lib/model/admin/general.php';
require_once ROOT_PATH . '/lib/model/booking/reservedTokens.php';
require_once ROOT_PATH . '/config_hims.php';

class BookingController {

	var $addSuccess="Added Successfully";
	var $addfailed="Failed To Add";
	

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){
			
				case 'Booking'				:	
												$dep_obj=new Department();
												$shed_obj=new Scheduling();
												$dep_id='';
												$date='';
												
												if(!empty($postArr['department'])){
													$dep_id=$postArr['department'];
												}
												if(!empty($postArr['date'])){
													$date=$postArr['date'];
												}
												if(!empty($postArr['id'])){
													$form_creator ->popArr['dateAvaillability']=$dateAvaillability=$this->getDoctorsAvailability($postArr);
													$form_creator ->popArr['docid']=$postArr['id'];
													

													$wheredata = array();
													$wheredata[0]="doc_id = '".$postArr['id']."'";
													$wheredata[1]="status = 0";
													$wheredata[2]="blocked_date >= '".date("Y-m-d")."'";

													$blocked_dates=$shed_obj->getBlockedDate($wheredata);

													$blocked_dates_only = array();
													
													if (!empty($blocked_dates)) {
														
														for ($i=0; $i < count($blocked_dates) ; $i++) { 
															
															$blocked_dates_only[]=date("d-m-Y",strtotime($blocked_dates[$i][2]));

														}

													}

													if (!empty($blocked_dates_only)) {
														
														for ($i=0; $i < count($dateAvaillability) ; $i++) { 
															
															if (in_array($dateAvaillability[$i], $blocked_dates_only)) {
																unset($dateAvaillability[$i]);
															}

														}

														$dateAvaillability=array_values($dateAvaillability);

													}

													$form_creator ->popArr['dateAvaillability']=$dateAvaillability;


													$dbObj= new DBFunction();
													
													$form_creator ->popArr['docname']=$dbObj->getidToValue("title","id",$postArr['id'],"hcare_emp_info")." ".$dbObj->getidToValue("first_name","id",$postArr['id'],"hcare_emp_info")." ".$dbObj->getidToValue("last_name","id",$postArr['id'],"hcare_emp_info");
												}
				
												
					
												$form_creator->popArr['dep_id']=$dep_id;
												$form_creator->popArr['post']=$postArr;
												
												$form_creator ->popArr['doctors']=$doctors=$this->getDoctorOnDate($date,$dep_id);
												$form_creator ->popArr['departments']=$dep_obj->getDepartment();
												$form_creator ->formPath ='/templates/booking/selectDoctor.php';
											
											break;
				case 'Booking_Form'				:
												$gen_obj = new General();
												$emp_obj=new Employee();
												$shed_obj=new Scheduling();
												$bk_obj = new Booking();
												$reg_obj = new Registration();
												
												$opSettings= $gen_obj->getOpSettings();
												$regfee=$opSettings[0][2];
												
												$is_field[0]= "a.id ='$postArr[id]'";
												$doctorInfo=$emp_obj->getEmployee($is_field);
												
												$shedInfo=$shed_obj->getDrScheduling($postArr['id']);

												$form_creator ->popArr['doc_cons_time']=$shedInfo[0][2];
												
												$weekday = date('l', strtotime($postArr['date']));
												$weekno	=date('N', strtotime($postArr['date']));
												if($weekno == 7 ){
													$start=5;
												}else{
													$start=9+($weekno-1)*4;
												}
												$constime='';
												if(!empty($shedInfo[0][$start])){
													$constime .= $shedInfo[0][$start]."-".$shedInfo[0][$start+1];
												}
												if(!empty($shedInfo[0][$start+2])){
													$constime .= "/".$shedInfo[0][$start+2]."-".$shedInfo[0][$start+3];
												}
												$arrList[0]=$postArr['id'];
												$arrList[1]=$doctorInfo[0][1]." ".$doctorInfo[0][2]." ".$doctorInfo[0][3];
												$arrList[2]=$constime;
												$arrList[3]=$postArr['date'];
												$arrList[4]=$doctorInfo[0][19];
												$arrList[5]=$regfee;					
                                    /*.... get count of booking info ....*/
                                                $condition[]="doc_id='".$postArr['id']."'";
                                                $condition[]="booking_date='".date("Y-m-d",strtotime($postArr['date']))."'";
                                                $condition[]="status= 0";
      
                                                $datewise_booking_count=$bk_obj->getBookingListCount($condition);
                                                $booking_list=$bk_obj->getBookingList($condition);

                                                // Get tdy registered list

												$selectCondition[]="b.`doc_id`='".$postArr['id']."'";
												$selectCondition[]="b.`cancelled`= 0";
												$selectCondition[]="b.`visit_date` like '%".date("Y-m-d",strtotime($postArr['date']))."%'";
												$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);

												if (!empty($patientInfo)) {
													
													for ($i=0; $i <count($patientInfo) ; $i++) { 
														
														$booked_tokens[] = $patientInfo[$i][36];

													}

												}
												else{

													$booked_tokens[] = "";

												}

												



                                                $bookin_limit=$shedInfo[0][3];
                                    /*.... get count of booking info ....*/	            
                                        if($bookin_limit >0 && $datewise_booking_count>=$bookin_limit)
                                            {
                                            	$booking_over="BOOKING LIMIT OVER FOR ".$arrList[1]." ON ".$postArr['date'];
                                              	$this->viewPage('Booking','','',$booking_over);
                                              	$form_creator ->formPath ='/templates/booking/selectDoctor.php';
                                            }
 		                                else{

 		                                		if (empty($shedInfo[0][2])) {

	                                            	$booking_over="PLEASE ADD CONSULTAION TIME FOR ".strtoupper($arrList[1])."";
	                                              	$this->viewPage('Booking','','',$booking_over);
	                                              	$form_creator ->formPath ='/templates/booking/selectDoctor.php';

 		                                		}
 		                                		else{ 


													$form_creator ->popArr['arrList']=$arrList;
													$form_creator ->popArr['booking_list']=$booking_list;

													$reserved_tokens = array();

													$reserved_tokens = $this->getavailReservedTokens($postArr);

													$form_creator ->popArr['reserved_tokens'] = $reserved_tokens;
													$form_creator ->popArr['booked_tokens']=$booked_tokens;
													$form_creator ->popArr['shedInfo']=$shedInfo;

													$form_creator ->popArr['post']=$postArr;

													$form_creator ->formPath ='/templates/booking/booking_form.php';


 		                                		}



											}    
											break;
				case 'Booking_Report'		:
												$bk_obj = new Booking();
												$emp_obj=new Employee();
												$k=0;
												if(!empty($postArr['book_id'])){
												
												 	$wheredata[$k++]="id='".$postArr['book_id']."'";
												 }else{
												 if(!empty($postArr['from_date'])){
												 
												 	$wheredata[$k++]="booking_date >='".date("Y-m-d",strtotime($postArr['from_date']))."' and "."booking_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
												 }else $wheredata[$k++]="booking_date >='".date("Y-m-d")."' and "."booking_date <='".date("Y-m-d")."'";
												 if(!empty($postArr['doctor'])){
												 
												 	$wheredata[$k++]="doc_id ='".$postArr['doctor']."'";
												 }
												 if(!empty($postArr['patient_name'])){
												 
												 	$wheredata[$k++]="patient_name like '%".$postArr['patient_name']."%'";
												 }
												 if(!empty($postArr['place'])){
												 
												 	$wheredata[$k++]="place like '%".$postArr['place']."%'";
												 }
												 if(!empty($postArr['phone'])){
												 
												 	$wheredata[$k++]="phone like '%".$postArr['phone']."%'";
												 }
												 
												}
												if(!empty($postArr['status'])){
												 
												 	$wheredata[$k++]="status ='".$postArr['status']."'";
												 }else{
												 	$wheredata[$k++]="status=0";
												 }
												// echo $postArr['status'];
												$wheredata[$k++]="visited=0";
												//for cancel booking
												// $wheredata[$k++]="status=0";
												// var_dump($wheredata);
												$form_creator ->popArr['bookingInfo']=$bk_obj->getBookingList($wheredata);
												
												$is_field[0]= "a.title ='Dr'";
												$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
												$form_creator ->popArr['post']=$postArr;
												
												$form_creator ->formPath ='/templates/booking/booking_report.php';
											
											break;
				
				case 'Manage_Scheduling'	:
												
											$emp_obj=new Employee();
											$dep_obj=new Department();
											$shed_obj=new Scheduling();	
											
											
											
											$is_field[0]= "a.`title` ='Dr'";
											$dep_id='';
											
											if(!empty($postArr['department'])){
											
												$form_creator ->popArr['dep_id']=$dep_id=$postArr['department'];
												
											}
											
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field,$dep_id);
											$form_creator ->popArr['departments']=$dep_obj->getDepartment();
											if(!empty($postArr['doctor'])){
											
												$form_creator ->popArr['doc_id']=$postArr['doctor'];
												$is_field[0]="a.id='".$postArr['doctor']."'";

												$form_creator ->popArr['scheduling_list']=$shed_obj->getSchedulingList($is_field);
												
											}else{
												$form_creator ->popArr['scheduling_list']=$shed_obj->getSchedulingList($is_field);
											}
											$form_creator ->formPath ='/templates/booking/manage_scheduling.php';
											
											break;
				case 'Scheduling_Form'		:
											$emp_obj=new Employee();
											$shed_obj=new Scheduling();
											
											$id=$postArr['id'];

											$count=$postArr['count'];
											
											$is_field[0]= "a.id =$id";
											$form_creator ->popArr['id']=$id;
											$form_creator ->popArr['action']="UPDATE";
											$form_creator ->popArr['doctor']=$emp_obj->getEmployee($is_field);
											$form_creator ->popArr['scheduling_info']=$shed_obj->getDrScheduling($id);

											$limit_data = 10;


											if ( $limit_data <= $count ) {
												$limit = $limit_data+$count;
												
											}
											else{
												$limit = $limit_data;
												

											}

											$wheredata = array();
											$wheredata[0]="doc_id = '".$id."'";
											$wheredata[1]="status = 0";

											$form_creator ->popArr['blocked_dates']=$blocked_dates=$shed_obj->getBlockedDate($wheredata,$limit);


											if ( $limit <= count($blocked_dates) ) {
												$limit_status=1;
											}
											else{
												$limit_status=0;
											}


											// var_dump($limit_status);
											$form_creator ->popArr['message']=$message;
											// $form_creator ->popArr['count']=$limit;
											$form_creator ->popArr['limit_status']=$limit_status;
											$form_creator ->formPath ='/templates/booking/scheduling_form.php';
											
											break;
											
				/*case 'Doctors_Availability' :
												$this->getDoctorsAvailability($post);
				
												break;*/
				case 'Token_Reservation'	:
				
												$rs_obj= new ReservedTokens();
												
												$reserved_tokens = array();

												$reserved_tokens = $this->getavailReservedTokens($postArr);

												$form_creator ->popArr['reserved_tokens'] = $reserved_tokens;
												
												$form_creator ->formPath ='/templates/booking/token_reservation.php';
											
												break;
			    case 'Cancel_Booking'			:
			    								   $bk_obj = new Booking();
												   $emp_obj=new Employee();
												    // var_dump($postArr);exit;
												   $cancel_all=$postArr['cancel_all_bookings'];
												   if($cancel_all !='YES'){
													   $bk_id=$getArr['booking_id'];
													   $reason=$getArr['reason'];
													   $result_id= $this->cancelBooking($postArr,$bk_id,$reason);
													}
													else{
														$no_of_items=$getArr['no_of_items'];
														$reason=$getArr['reason'];
														$booking_selected=$postArr['select_for_cancellation'];
														for($i=0;$i<$no_of_items;$i++){
															$bk_id=$booking_selected[$i];
															$result_id= $this->cancelBooking($postArr,$bk_id,$reason);

															
														 }//i loop

													}
												   $this->viewPage('Booking_Report',$postArr,'','');
	                                              	$form_creator ->formPath ='/templates/booking/booking_report.php';
											      
											       // echo $getArr['booking_id'];exit();
												break;										
				
										
						
									
			
			}
			
			$form_creator->display();
	
	}
	function updateTokenReservation($post){
	
		$rs_obj= new ReservedTokens();
		$rs_obj->deleteTokens();
		
		if(!empty($post['tokens'])){
			
				for($i=0;$i<count($post['tokens']);$i++){
					$rs_obj->addTokens($post['tokens'][$i]);
				}
		}
		
		$this->viewPage('Token_Reservation',$post,'',"Updated Successfully");
	}
	function getavailReservedTokens($post){
	
		$rs_obj= new ReservedTokens();
		$bk_obj = new Booking();
		
		$docid=$post['id'];
		$date=$post['date'];
		$availTokens=array();
		$j=0;
		$reserved_tokens=array();
		$reserved_tokens=$rs_obj->getReservedTokens();
		
		if(!empty($reserved_tokens)){
			for($i=0;$i<count($reserved_tokens);$i++){
			
				$wheredata[0]="doc_id='".$docid."'";
				$wheredata[1]="booking_date='".date("Y-m-d",strtotime($date))."'";
				$wheredata[2]="token_no='".$reserved_tokens[$i]."'";
				//booking cancel changes
				 $wheredata[3]="status =0";
				
				$bookingInfo=$bk_obj->getBookingList($wheredata);
				if(empty($bookingInfo)){
					$availTokens[$j++]=$reserved_tokens[$i];
				}
			
			}
		
		}
		return $availTokens;
	}
	function getDoctorsAvailability($post){
	
		$shed_obj=new Scheduling();
		
		$docid=$post['id'];
		$fromdate=$post['date'];
		$i=1;
		$j=0;
		$dateInfo=array();
		while($j<=17){
		
			$nextdate=date("d-m-Y",(strtotime($fromdate)+($i*24*3600)));
			$weekday = date('l', strtotime($nextdate));
			
			$arrayInfo=$shed_obj->getDrScheduling($docid,$weekday);
			
			if(!empty($arrayInfo)){
				$dateInfo[$j]=$nextdate;
				$j++;
			}
			
			$i++;
		}
		
		return $dateInfo;
	}
	function getDoctorOnDate($date = null,$dep_id = null){
	
		
		$shed_obj=new Scheduling();
		
		if(empty($date)){
		
			$date = date('Y-m-d');
		}else $date=date('Y-m-d',strtotime($date));	
		
		
		$doctors=$shed_obj->getSchedulingByDate($date,$dep_id);
		
		return $doctors;
	}
	function changeBookingStatus($post){
	
		$shed_obj=new Scheduling();
		
		$id=$postArr['id'];
		
		$result=$shed_obj->changeBookingStatus($post);
		
			$this->viewPage('Scheduling_Form',$post,'',$result);
	}
	
	function updateSchedule($postArr){
	
			$days=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			$shed_obj=new Scheduling();
			
			$id=$postArr['id'];
			
			if(!empty($postArr['checkD'])){
			
				for($i=0;$i<count($postArr['checkD']);$i++){
					
					
					$field=strtolower(substr($postArr['checkD'][$i],0,3)); 
					$data[$postArr['checkD'][$i]]=$postArr[$field."_fs"]."/".$postArr[$field."_fe"]."/".$postArr[$field."_ss"]."/".$postArr[$field."_se"];
					
					
					
				}
				
				for($i=0;$i<count($days);$i++) {
				
						if(isset($data[$days[$i]])){
							$sheduledInfo[$i]=$data[$days[$i]];
						}else $sheduledInfo[$i]='';
				
				}
				$shedInfo=$shed_obj->getDrScheduling($id);
				if(empty($shedInfo)){
				
					$shed_obj->addSheduling($postArr,$sheduledInfo);
					
				}else{
				
					$shed_obj->updateSheduling($postArr,$sheduledInfo);
				}
				
			}
			
			$this->viewPage('Manage_Scheduling');
	}
	function booking_process($post){
	
		$comm_obj = new CommonFunctions();
		$bk_obj = new Booking();
		$sms_obj = new SmsFunctions();
		$config_obj=new Config_hims();
		$hobj=new HospitalInfo();
		$hinfo=$hobj->getHospitalInfo();
		$hospital_name=$hinfo[1];
		$post['smsStatus1']=0;
		
		
		$docid=$post['id'];
		$date=$post['booking_date'];
		
		if(!empty($post['tokens'])){
		
			for($i=0;$i<count($post['tokens']);$i++){
				$token_no=$post['tokens'][$i];
				$post['token_from']="Reserved";
			}
		}elseif(!empty($post['avl_tokens'])){
		
			for($i=0;$i<count($post['avl_tokens']);$i++){
				$token_no=$post['avl_tokens'][$i];
				$post['token_from']="Reserved";
			}
		}else{
			$token_no=$this->generateTokenNo($docid,$date);
			$post['token_from']="Normal";
		}
			
		$result=$bk_obj->addBookingInfo($token_no,$post);

		if(!empty($result)){
			$bkid=$result;
		
		 	$wheredata[0]="id='".$bkid."'";
		 
	        $bookingInfo=$bk_obj->getBookingList($wheredata);
	        $patient_name=$bookingInfo[0][6];
	        $booking_date=$bookingInfo[0][4];
	        $token_time=$bookingInfo[0][10];
	        $doctor_name=$bookingInfo[0][3];
	        $token_no=$bookingInfo[0][1];
	       
        // var_dump($bookingInfo);exit;
	//send sms
			if($bookingInfo[0][8] !=''){
			
				$message1=$sms_obj->booking_sms;
				// echo $message1; exit;
				// echo $patient_name;exit;hospital_name
				$message1=str_replace("<patient_name>",$patient_name,$message1);
				$message1=str_replace("<booked_date>",$booking_date,$message1);
				$message1=str_replace("<booking_time>",$token_time,$message1);	
				$message1=str_replace("<doctor_name>",$doctor_name,$message1);
				$message1=str_replace("<token_no>",$token_no,$message1);
				$message1=str_replace("<hospital_name>",$hospital_name,$message1);

														
				$phone = $bookingInfo[0][8];
			// echo " ".$phone;exit;
				
				if(strlen($phone) >= 10 && $phone>0){	
					
					if ($config_obj->booking_sms_status=="YES") {
						  echo $message1." "; 
						$post['smsStatus1'] = $sms_obj->sendSMS($phone, $message1);
					}
				    
				} 

			}


		}
		
		if($result >0){
		
			$post['book_id']=$result;
			$this->viewPage('Booking_Report',$post,'',"Booked Successfully");
		}else{
			$this->viewPage('Booking_Form',$post,'',"Patient Booking Failed");
		}
	
	}
	function generateTokenNo($docid,$date){
	
		$comm_obj = new CommonFunctions();
		$bk_obj = new Booking();
		$rs_obj= new ReservedTokens();
		$reg_obj= new Registration();
		
		$today=$comm_obj->getcurrentDate('d-m-Y');
		
			$token_no=1;
			if($date == $today){
				$token_no=$bk_obj->getNextRegToken($docid,$date);
			}


		
			if($token_no == 1 ){
		
				$token_no=$bk_obj->getNextToken($docid,$date);
			}

			// var_dump($token_no);exit();
			
			$check_token=$rs_obj->checktokenIsReserved($token_no);
			if($check_token == 1){
				while ($check_token == 1 ){
				
					$token_no++;
					$check_token=$rs_obj->checktokenIsReserved($token_no);
					
					
				
				}
			
			}

            // Get tdy registered list

			$selectCondition[]="b.`doc_id`='".$docid."'";
			$selectCondition[]="b.`cancelled`= 0";
			$selectCondition[]="b.`visit_date` like '%".date("Y-m-d",strtotime($date))."%'";
			$patientInfo=$reg_obj->getOPPatientInfo('',$selectCondition);

				if (!empty($patientInfo)) {
													
					for ($i=0; $i <count($patientInfo) ; $i++) { 
														
						$reg_tokens[] = $patientInfo[$i][36];

					}

				}
				else{

					$reg_tokens[] = "";

				}

        	 /*.... get count of booking info ....*/
             $condition[]="doc_id='".$docid."'";
             $condition[]="booking_date='".date("Y-m-d",strtotime($date))."'";
      
             $booking_list=$bk_obj->getBookingList($condition);

			if (!empty($booking_list)) {
													
				for ($i=0; $i <count($booking_list) ; $i++) { 
														
					$booked_tokens[] = $booking_list[$i][1];

				}

			}
			else{

				$booked_tokens[] = "";

			}

			while ( in_array($token_no, $reg_tokens) || in_array($token_no, $booked_tokens) ) {
				$token_no++;
			}


		return $token_no;
	}
	function cancelBooking($post,$bk_id=null,$reason=null){
	
		$comm_obj = new CommonFunctions();
		$bk_obj = new Booking();
		$sms_obj = new SmsFunctions();
		$config_obj=new Config_hims();
		$hobj=new HospitalInfo();
		$hinfo=$hobj->getHospitalInfo();
		$hospital_name=$hinfo[1];
		$post['smsStatus1']=0;
		
		$bkid=$bk_obj->cancelBooking($bk_id,$reason);
		// $k=0;
		if(!empty($bkid)){
		
		 	$wheredata[0]="id='".$bkid."'";
		 
        $bookingInfo=$bk_obj->getBookingList($wheredata);
        $patient_name=$bookingInfo[0][6];
        $booking_date=$bookingInfo[0][4];
        $token_time=$bookingInfo[0][10];
        $doctor_name=$bookingInfo[0][3];
        $token_no=$bookingInfo[0][1];
        $cancellation_details=$bookingInfo[0][13];
        // var_dump($bookingInfo);exit;
	//send sms
			if($bookingInfo[0][8] !=''){
			
				$message1=$sms_obj->booking_cancelled_sms;
				// echo $message1; exit;
				// echo $patient_name;exit;hospital_name
				$message1=str_replace("<patient_name>",$patient_name,$message1);
				$message1=str_replace("<appointment_date>",$booking_date,$message1);
				// $message1=str_replace("<appt_time>",$token_time,$message1);	
				$message1=str_replace("<doctor_name>",$doctor_name,$message1);
				$message1=str_replace("<token_no>",$token_no,$message1);
				$message1=str_replace("<reason>",$cancellation_details,$message1);
				$message1=str_replace("<hospital_name>",$hospital_name,$message1);

						 // echo $message1." "; 								
				$phone = $bookingInfo[0][8];
			// echo " ".$phone;exit;
				
				if(strlen($phone) >= 10 && $phone>0){	
					
					if ($config_obj->booking_cancelled_sms_status=="YES") {
						$post['smsStatus1'] = $sms_obj->sendSMS($phone, $message1);
					}
				    
				} 

			}
	}
		return $bkid;
		
		 // $this->viewPage('Booking_Report',$post,'',"Updated Successfully");
	}

	function save_blocked_date($postArr=null)
	{
		
		$shed_obj=new Scheduling();

		$result = $shed_obj->SaveBlockedDate($postArr);

		$this->viewPage('Scheduling_Form',$postArr,'',"Added Successfully");


	}	
	function delete_blocked_date($postArr=null)
	{
		
		$shed_obj=new Scheduling();

		$result = $shed_obj->deleteBlockedDate($postArr);

		$this->viewPage('Scheduling_Form',$postArr,'',"Deleted Successfully");


	}	
	function transfer_booking($post=null)
	{

		$bk_id = $post['transfer_id'];
		$reason = "BOOKING TRANSFERED";
		
		$this->cancelBooking($post,$bk_id,$reason);
		$this->booking_process($post);

		// $this->viewPage('Booking_Report',$post,'',"Successfully");


	}


	
}


?>