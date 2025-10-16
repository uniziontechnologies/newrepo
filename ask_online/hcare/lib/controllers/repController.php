<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/model/registration/registration.php';
require_once ROOT_PATH . '/lib/model/admin/employee.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/procedure/category.php';
require_once ROOT_PATH . '/lib/model/procedure/procedure.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';
require_once ROOT_PATH . '/lib/model/doctor/doctor.php';
require_once ROOT_PATH . '/lib/common/ipFunctions.php';
require_once ROOT_PATH . '/lib/model/labFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/insurance_company.php';
require_once ROOT_PATH . '/lib/common/pagination.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/common/M_pdf.php';



class ReportController {



function viewPage($sub_module,$postArr='',$getArr='',$message=''){

$form_creator = new Form();

if(!empty ($message)){
	$form_creator ->popArr['message']=$message;
}
switch($sub_module){
	
	
	case 'index'			:
										
										$form_creator ->formPath ='/templates/reports/index.php';
										break;
	case 'daily_collection'  : 
								$rep_obj=new Report();
								$com_obj = new CommonFunctions();
								$user_obj=new User();
								$db_function=new DBFunction();
								
								
								if(isset($postArr['from_date'])){
								
								      if(!empty($postArr['from_time'])){
                                        $from_time=date("H:i:s",strtotime($postArr['from_time']));
										$to_time=date("H:i:s",strtotime($postArr['to_time']));
									   												  
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
									 }else{
									 
									    $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." 23:59:59";
									 }
								}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d")." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d")." 23:59:59";
										
										$postArr['from_date']=$com_obj->getcurrentDate("Y-m-d");
										$postArr['to_date']=$com_obj->getcurrentDate("Y-m-d");
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
										
									}
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
							    
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['daily_collection']=$rep_obj->daily_collection($fromdate,$todate,$user_id);;
	                            $form_creator ->formPath ='/templates/reports/daily_collection.php';
								break;
		case 'bill_collection'  : 
								$rep_obj=new Report();
								$com_obj = new CommonFunctions();
								$user_obj=new User();
								$db_function=new DBFunction();
								
								if(isset($postArr['from_date'])){
								
								      if(!empty($postArr['from_time'])){
                                        $from_time=date("H:i:s",strtotime($postArr['from_time']));
										$to_time=date("H:i:s",strtotime($postArr['to_time']));
									   												  
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
									 }else{
									 
									   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." 23:59:59";
									 }
								}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d")." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d")." 23:59:59";
										
										$postArr['from_date']=$com_obj->getcurrentDate("d-m-Y");
										$postArr['to_date']=$com_obj->getcurrentDate("d-m-Y");
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								$form_creator ->popArr['daily_collection']=$daily_collection=$rep_obj->daily_bill_collection($fromdate,$todate,$user_id);
								// var_dump($daily_collection);
								$form_creator ->formPath ='/templates/reports/bill_collection.php';
								break;
		case 'bill_collection_all_user': $rep_obj=new Report();
								           $com_obj = new CommonFunctions();
								           $user_obj=new User();
								           $db_function=new DBFunction();
										   
								if(isset($postArr['from_date'])){
								
								      if(!empty($postArr['from_time'])){
                                        $from_time=date("H:i:s",strtotime($postArr['from_time']));
										$to_time=date("H:i:s",strtotime($postArr['to_time']));
									   												  
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
									 }else{
									 
									   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." 23:59:59";
									 }
								}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d")." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d")." 23:59:59";
										
										$postArr['from_date']=$com_obj->getcurrentDate("d-m-Y");
										$postArr['to_date']=$com_obj->getcurrentDate("d-m-Y");
								}
								
								$user_type_info=array();
								$user_type_logged_in=$_SESSION['user_type'];
								$user_type_id=$_SESSION['user_type_id'];
								$user_id=$_SESSION['user_id'];

										
								if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR' && $user_type_logged_in !='LAB ADMIN'){
								       $user_type_info[]="id='".$user_type_id."'"; 
									   $user_data[]="id='".$user_id."'"; 
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_type_info[]="id='6' or id='7'"; 
									  
								}
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
		 
		 
		                        if(!empty($postArr['user_type'])) {
											
									$user_data[]="user_type='".$postArr['user_type']."'";
									$postArr['user_type_name']=$db_function->getidToValue("user_type","id",$postArr['user_type'],"hcare_user_type");
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_data[]="user_type='6' or user_type='7'"; 
									  
								}
								   $orderfield="user_name";
								   $alldata="all";
		                           $userInfo=$user_obj->getUser('',$user_data,$orderfield,'asc',$alldata);
		                 
								   $collectionInfo=array();
								   $k=0;
										if(!empty($userInfo)){
										   for($i=0;$i<count($userInfo);$i++){
                                            $user_id="(".$userInfo[$i][0].")";
											$dailyInfo=$rep_obj->daily_bill_collection($fromdate,$todate,$user_id);
											
											if($dailyInfo[7][1] >0 || $dailyInfo[8][1]>0){
											         
											   $collectionInfo[$k][0]=$userInfo[$i][5];
											   $collectionInfo[$k][1]=$userInfo[$i][3];
											   $collectionInfo[$k][2]=$dailyInfo;
                                               
                
											   $k++;
											}

											}
                                        }
                                    $form_creator ->popArr['post']=$postArr;													
									$form_creator ->popArr['daily_collection']=$collectionInfo;
								    $form_creator ->formPath ='/templates/reports/bill_collection_user.php';	   
		                        break;
		case 'detailed_bill_collection_report': 
		                                    $rep_obj=new Report();
								            $com_obj = new CommonFunctions();
								            $user_obj=new User();
								            $db_function=new DBFunction();

		                        if(isset($postArr['from_date'])){
								
								      if(!empty($postArr['from_time'])){
                                        $from_time=date("H:i:s",strtotime($postArr['from_time']));
										$to_time=date("H:i:s",strtotime($postArr['to_time']));
									   												  
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
									 }else{
									 
									   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." 23:59:59";
									 }
								}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d")." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d")." 23:59:59";
										
										$postArr['from_date']=$com_obj->getcurrentDate("d-m-Y");
										$postArr['to_date']=$com_obj->getcurrentDate("d-m-Y");
								}
								
								$user_type_info=array();
								$user_type_logged_in=$_SESSION['user_type'];
								$user_type_id=$_SESSION['user_type_id'];
								$user_id=$_SESSION['user_id'];

										
								if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR' && $user_type_logged_in !='LAB ADMIN'){
								       $user_type_info[]="id='".$user_type_id."'"; 
									   $user_data[]="id='".$user_id."'"; 
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_type_info[]="id='6' or id='7'"; 
									  
								}
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
		 
		 
		                        if(!empty($postArr['user_type'])) {
											
									$user_data[]="user_type='".$postArr['user_type']."'";
									$postArr['user_type_name']=$db_function->getidToValue("user_type","id",$postArr['user_type'],"hcare_user_type");
									
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_data[]="user_type='6' or user_type='7'"; 
									  
								}
								   $alldata="all";
		                           $userInfo=$user_obj->getUser('',$user_data,'','',$alldata);
                                   
								   $collectionInfo=array();
								   $user_id=array();
								   $k=0;
								if(!empty($userInfo))
								    {
										   for($i=0;$i<count($userInfo);$i++){
                                            $user_id[]=$userInfo[$i][0];
                                          
											   // $collectionInfo[$k][0]=$userInfo[$i][1];
											   // $collectionInfo[$k][1]=$userInfo[$i][3];
											  
											   $k++;
										
											}
											for($i=0;$i<count($user_id);$i++)
											   {   
											   	 $test.=$user_id[$i].",";   
											   }
							  if(!empty($postArr['user']))
								    {
									       $test_user_id="(".$postArr['user'].")";

									    	$postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");
                        /*.......Employee name......*/
									   $title=$db_function->getidToValue("title","id",$postArr['user'],"hcare_emp_info");

									   $first_name=$db_function->getidToValue("first_name","id",$postArr['user'],"hcare_emp_info");

							           $last_name=$db_function->getidToValue("last_name","id",$postArr['user'],"hcare_emp_info");

							$postArr['emp_name']=$title.".".$first_name." ".$last_name;

							        }
							    else{    		   
											$test=rtrim($test,',');  
											$test_user_id="(".$test.")";
								    }		
                                       // var_dump($test_user_id);    
											$dailyInfo=$rep_obj->detailed_bill_collection($fromdate,$todate,$test_user_id);   
											   
				
                                    }
                                   
                                   
                                  $form_creator ->popArr['user']=$user_obj->getUser('',$user_data); 

                                  $form_creator ->popArr['post']=$postArr;													
								  // $form_creator ->popArr['info']=$collectionInfo;

								  $form_creator ->popArr['daily_collection']=$dailyInfo;

								    $form_creator ->formPath ='/templates/reports/detailed_bill_collection_report.php';
		                        break; 
                         case 'Booking_Report'		:
									$bk_obj = new Booking();
									$emp_obj=new Employee();
									$db_function=new DBFunction();
									$k=0;
									if(!empty($getArr['paction']) && $getArr['paction']=='clear_form'){
									
									 	$wheredata[$k++]="booking_date >='".date("Y-m-d")."' and "."booking_date <='".date("Y-m-d")."'";
										$postArr=array();
									 }else{
									 if(!empty($postArr['from_date'])){
									 
									 	$wheredata[$k++]="booking_date >='".date("Y-m-d",strtotime($postArr['from_date']))."' and "."booking_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
									 }else $wheredata[$k++]="booking_date >='".date("Y-m-d")."' and "."booking_date <='".date("Y-m-d")."'";
									 if(!empty($postArr['doctor'])){
									 
									 	$wheredata[$k++]="doc_id ='".$postArr['doctor']."'";
										
										$first_name=$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info");

							           $last_name=$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");

							            $postArr['doctor_name']=$first_name." ".$last_name;

									 }
									 if(!empty($postArr['patient_name'])){
									 
									 	$wheredata[$k++]="patient_name like'".$postArr['patient_name']."%'";
									 }
									 if(!empty($postArr['place'])){
									 
									 	$wheredata[$k++]="place like'".$postArr['place']."%'";
									 }
									 if(!empty($postArr['phone'])){
									 
									 	$wheredata[$k++]="phone like'".$postArr['phone']."%'";
									 }
									}
									if(!empty($postArr['status'])){
									 
									 	$wheredata[$k++]="status ='".$postArr['status']."'";
									 }else{
									 	$wheredata[$k++]="status=0";
									 }
									$wheredata[$k++]="visited=0";
									$form_creator ->popArr['bookingInfo']=$bk_obj->getBookingList($wheredata);
									
									$is_field[0]= "a.title ='Dr'";
									$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
									$form_creator ->popArr['post']=$postArr;
									
									$form_creator ->formPath ='/templates/reports/booking_report.php';
								
								break;
												
	        case 'ip_payments_cancelled':  $bill_obj= new Billing(); 
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
		                    $wheredata[$k++]="(bill_status =1 or bill_status=3)";
		                               $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
		                               $form_creator ->popArr['user']=$user_obj->getUser();;
		                               $form_creator ->popArr['post']=$postArr;
		                               $form_creator ->formPath ='/templates/reports/ip_payments_cancelled.php';
						break;
case 'ip_advance_payments_report':
                                $bill_obj= new Billing();
                                $user_obj=new User();								
								$db_function =new DBFunction();
		                                  $k=0;    
						                    if(!empty($postArr['billno'])) {
								                $wheredata[$k++]="id ='".$postArr['billno']."'";
						                      }
						                    if(!empty($postArr['ipno'])) {
								                      $wheredata[$k++]="ipno='".$postArr['ipno']."'";
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
                               											

                            	                                   if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){
							   
							   //EXTRACTUSER TYPE IF LABADMIN SHOW LABUSER ELSE SHOW USERTYPE LOGGED IN

                                                                       if($user_type_id == 6 ) {
										 
                                                                                $user_type_info[]="id='".$user_type_id."' or id='7'"; 
									 
								   }else  {
								   
								     $user_type_info[]="id='".$user_type_id."'"; 
									 echo $postArr['user_type']=$user_type_id;
									}
									
									if(empty($postArr['user_type'])) {
										 
										 if($user_type_id == 6 ){
										 	$user_data[0]="user_type='".$user_type_id."'"." or "."user_type='7'";
										 }else{
										   echo $user_data[0]="user_type='".$user_type_id."'";
										 }
									}else if(!isset($postArr['user'])){
									
									      $user_data[0]="user_type='".$user_type_id."'";
										   $postArr['user']=$_SESSION['user_id'];
										   $user_id="($_SESSION[user_id])";
									}else{
										 
										     $user_data[0]="user_type='".$user_type_id."'";
											  
									}
							}					   
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$user_data);
							
								 if(empty($postArr['user_type']) && empty($postArr['user']) && $user_type_id == 6){
									
									 if(count($userInfo) >0 ) {
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
									  }
									if($user_id == "") $user_id ="(0)";	
									
									}
								if(!empty($user_id)){
							
								  $wheredata[$k++]="user_id in $user_id";
								}		

							if(!empty($postArr['from_date'])) {
					    /*........... Date and Time ..........*/    	
										 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										 $to_time=date("H:i:s",strtotime($postArr['to_time']));
							                   $wheredata[$k++]="date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
							                   $wheredata[$k++]="date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
						                    }else{
							                   $wheredata[$k++]="date >='".date("Y-m-d")." 00:00:00'";
							                   $wheredata[$k++]="date <='".date("Y-m-d")." 23:59:59'";
						                    }
											
											 if(!empty($postArr['bill_status'])) {
								                      $wheredata[$k++]="status='".$postArr['bill_status']."'";
						                  }else $wheredata[$k++]="status=0";
							if(empty($wheredata))
					            {
					            	 $wheredata[$k++]="date >='".date("Y-m-d")." 00:00:00'";
							         $wheredata[$k++]="date <='".date("Y-m-d")." 23:59:59'";
                                }			  

							             $form_creator ->popArr['post']=$postArr;

		                                 $form_creator ->popArr['billInfo']=$bill_obj->getAdvancePayments($wheredata);
                                $form_creator ->formPath ='/templates/reports/ip_advance_payments_report.php';
                        break;       								
		case 'patient_report' :	$com_obj = new CommonFunctions();
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
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate()." ".$from_time;
												$postArr['to_date']=$todate=$com_obj->getcurrentDate()." ".$to_time;
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`visit_date`>='".$fromdate."'";
								$selectCondition[]="b.`visit_date`<='".$todate."'";;
								$selectCondition[]="b.`cancelled`=0";											
								$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
								
											
								 if($postArr['action']!="CLEAR"){
									$form_creator ->popArr['post']=$postArr;
								}else $form_creator ->popArr['post']='';
											
								$is_field[0]="a.title='Dr'";													
								$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  
											
								$form_creator ->formPath ='/templates/reports/patient_report.php';
											break;
		case 'free_patient_report' :	$com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											$user_obj=new User();
								            $db_function=new DBFunction();
								
								//date check start			
											if(!empty($postArr['from_time'])){
                                                 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										         $to_time=date("H:i:s",strtotime($postArr['to_time']));
											}else{
											
											     $from_time="00:00:00";
										         $to_time="23:59:59";
											}

											if(!empty($postArr['from_date'])){

                                                 $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
											}else{
                                                 
                                                 $fromdate=$com_obj->getcurrentDate()." ".$from_time;
											}

											if(!empty($postArr['to_date'])){

                                                 $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;
											}else{
                                                 
                                                 $todate=$com_obj->getcurrentDate()." ".$to_time;
											} 
							    //date check end							
												
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`visit_date`>='".$fromdate."'";
								$selectCondition[]="b.`visit_date`<='".$todate."'";;
								$selectCondition[]="b.`cancelled`=0";
								$selectCondition[]="b.`free`=1";
																		
								$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
								
											
								$form_creator ->popArr['post']=$postArr;
								
											
								$is_field[0]="a.title='Dr'";													
								$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  
											
								$form_creator ->formPath ='/templates/reports/free_patient_report.php';
											break;
		case 'op_card_issued' :	        $com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											$user_obj=new User();
											$db_function=new DBFunction();
											
											if(isset($postArr['from_date']) && $postArr['action']!="CLEAR"){
												$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												
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
											}else{
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate();
												$postArr['to_date']=$todate=$com_obj->getcurrentDate();
											}
											
											$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
											$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
											
											$selectCondition[]="(b.`card_issued`= 'NEW' or b.`card_issued`= 'RENEW')";
											
											
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`cancelled`=0";

								$selectCondition[]="b.`card_fee`>0";
											
											$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
											$selectCondition[count($selectCondition)-1]="b.`cancelled`=1";
											  $form_creator ->popArr['cancelled_patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');						
											
											 if($postArr['action']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
											}else $form_creator ->popArr['post']='';
											
											$is_field[0]="a.title='Dr'";													
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											
											$form_creator ->formPath ='/templates/reports/op_card_issued_report.php';
											break;
		case 'age_gender_report' :			$com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											
											if(isset($postArr['from_date']) && $postArr['action']!="CLEAR"){
												$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												
												
												if(!empty($postArr["age_from"])){
													$selectCondition[]="a.`age`>=".$postArr["age_from"]."";
												}
												if(!empty($postArr["age_to"])){
													$selectCondition[]="a.`age`<=".$postArr["age_to"]."";
												}
												
												if(!empty($postArr["age_from"]) || !empty($postArr["age_to"])){
												
												
												$selectCondition[]="(a.`age` like '%".$postArr["age_type"]."')";
													
												
												}
												if(!empty($postArr["gender"])){
													$selectCondition[]="a.`gender` = '".$postArr["gender"]."'";
												}

												if(!empty($postArr["doctor"])){
													$selectCondition[]="b.`doc_id` = '".$postArr["doctor"]."'";
												}

												
											}else{
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate();
												$postArr['to_date']=$todate=$com_obj->getcurrentDate();
											}
											
											$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
											$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
											$selectCondition[]="b.`cancelled`=0";
											
											$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
											
											 if($postArr['action']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
											}else $form_creator ->popArr['post']='';
											
											$is_field[0]="a.title='Dr'";													
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  

											$form_creator ->formPath ='/templates/reports/age_gender_report.php';
											break;
		case 'cancelled_op' :	$com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											
											if(isset($postArr['from_date']) && $postArr['action']!="CLEAR"){
												$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												
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
											}else{
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate();
												$postArr['to_date']=$todate=$com_obj->getcurrentDate();
											}
											
											$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
											$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
											$selectCondition[]="b.`cancelled`=1";
											
											$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
											
											 if($postArr['action']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
											}else $form_creator ->popArr['post']='';
											
											$is_field[0]="a.title='Dr'";													
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
					 						
											$form_creator ->formPath ='/templates/reports/cancelled_op_report.php';
											break;
	    case 'op_patient_categorywise' :    
	                                       $com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											$user_obj=new User();
								            $db_function=new DBFunction();
								            $pat_cat=new PatientCategory();
								
											
											if(!empty($postArr['from_time'])){
                                                 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										         $to_time=date("H:i:s",strtotime($postArr['to_time']));
											}else{
											
											     $from_time="00:00:00";
										         $to_time="23:59:59";
											}
									   												  
											
											if(isset($postArr['from_date'])){
											
											    
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
											}else{
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate()." ".$from_time;
												$postArr['to_date']=$todate=$com_obj->getcurrentDate()." ".$to_time;
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
					/*... patient category ...*/
					            if(!empty($postArr['patient_category'])){
					            	
					            	$selectCondition[]="b.`patient_category`='".$postArr['patient_category']."'";
					            	$postArr['patient_category_name']=$db_function->getidToValue("patient_category","id",$postArr['patient_category'],"hcare_patient_category");

					            }
					/*... patient category ...*/
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);

								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`visit_date`>='".$fromdate."'";
								$selectCondition[]="b.`visit_date`<='".$todate."'";
								$selectCondition[]="b.`patient_category`>0";
								$selectCondition[]="b.`cancelled`=0";	
									
						
								$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
											
								$form_creator ->popArr['post']=$postArr;
									
								$is_field[0]="a.title='Dr'";													
								$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field); 

								$form_creator ->popArr['patient_category']=$pat_cat->getPatientCategory(); 
	                                         
	                                     $form_creator ->formPath ='/templates/reports/op_patient_categorywise_report.php'; 
	                                     break;
	
		case 'doctor_report'  :
									 $rep_obj=new Report();
									 $reg_obj= new Registration();
									 $com_obj = new CommonFunctions();
									 $emp_obj= new Employee();
									 
									 if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
									
									$selectCondition[]="b.`visit_date`>='".$fromdate." 00:00:00'";
									$selectCondition[]="b.`visit_date`<='".$todate." 23:59:59'";
									
									if(!empty($getArr['docid'])){
									$postArr['doctor']=$docid=$getArr['docid'];
									 $selectCondition[]="b.`doc_id`='".$docid."'";
									}
									if(!empty($postArr['doctor'])){
									$docid=$postArr['doctor'];
									 $selectCondition[]="b.`doc_id`='".$docid."'";
									}
									$selectCondition[]="b.`cancelled`=0";
									 $is_field[0]="a.title='Dr'";	
									 $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
									$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
									$form_creator ->popArr['post']=$postArr;											
	                            $form_creator ->formPath ='/templates/reports/doctor_report.php';
								break;
		case 'doctor_consolidated':
		
		                           $emp_obj= new Employee();
								   $com_obj = new CommonFunctions();
								   $rep_obj=new Report();
								   
								   if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
								   
								   $is_field[0]="a.title='Dr'";		
								   
								   if(!empty($postArr["doctor"])){
											$is_field[1]="a.`id`='".$postArr["doctor"]."'";
									}											
									$doctors=$emp_obj->getEmployee($is_field);
									$arrList=array();
									$j=0;
									if(count($doctors) >0 ){
									
									  for($i=0;$i<count($doctors);$i++){
									  
									    $docid=$doctors[$i][0];
										$patientInfo=$rep_obj->patient_count($docid,$fromdate,$todate);
									
										if($patientInfo[0] >0 || $patientInfo[1] >0 || $patientInfo[2]>0 || $patientInfo[3] >0 || $patientInfo[4] >0 || $patientInfo[7] >0 ) {
										
												$arrList[$j][0]=$doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];
												$arrList[$j][1]=$patientInfo[0];
												$arrList[$j][2]=$patientInfo[1];
												$arrList[$j][3]=$patientInfo[2];
												$arrList[$j][4]=$patientInfo[3];
												$arrList[$j][5]=$docid;
												$arrList[$j][6]=$patientInfo[4];
												$arrList[$j][7]=$patientInfo[6];
												$arrList[$j][8]=$patientInfo[7];
												$j++;
										}
										
									  }
									
									}
									$form_creator ->popArr['post']=$postArr;
									
									$is_field[0]="a.title='Dr'";													
									$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
											
									$form_creator ->popArr['doctor_info']=$arrList;
	                             $form_creator ->formPath ='/templates/reports/doctor_consolidate.php';
										break;
			case 'doctor_ip_visit_consolidated': $com_obj = new CommonFunctions();
							     $ip_obj= new Inpatient();
							     $rep_obj=new Report();
							     $user_obj=new User();
							     $db_function=new DBFunction();
							     
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
                               											

								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$user_data);
							
								 if(empty($postArr['user_type']) && empty($postArr['user']) && $user_type_id == 6){
									
									 if(count($userInfo) >0 ) {
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
									  }
									if($user_id == "") $user_id ="(0)";	
									
									}
									
								if(!empty($user_id)){
							
								  $wheredata[$k++]="a.user_id in $user_id";
								}
								   
								   if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
								   
								   $is_field[0]="status=0";
                                                                               $is_field[1]="date >='$fromdate' and date<='$todate'";
								   
								    if($user_id != ""){
								     $is_field[2]="user in $user_id";
								    }
								   $doctors=$ip_obj->getIpVisitDrInfo($is_field);
								   $arrList=array();
									$j=0;
									if(count($doctors) >0 ){
									
									  for($i=0;$i<count($doctors);$i++){
									  
									    $docid=$doctors[$i][0];
									    $visitInfo=$rep_obj->doctor_visit_charge($docid,$fromdate,$todate,$user_id);
									    
									    $arrList[$j][0]=$doctors[$i][1];
									    $arrList[$j][1]=($visitInfo[0] == '')?0:$visitInfo[0];
									    $arrList[$j][2]=$visitInfo[1];
									    $arrList[$j][3]=($visitInfo[2] == '')?0:$visitInfo[2];
									    $arrList[$j][4]=$visitInfo[3];
									    $arrList[$j][5]=($visitInfo[4] == '')?0:$visitInfo[4];
									    $arrList[$j][6]=$visitInfo[5];
									    $arrList[$j][7]=$docid;
									    $j++;
									    
									  }
								
								}
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['doctor_visitinfo']=$arrList;
			                                        $form_creator ->formPath ='/templates/reports/doctor_ip_visit_consolidate.php';
			                                        break;
			          case 'doctor_ip_visit_report':  $ip_obj= new Inpatient();											
								 $com_obj = new CommonFunctions();
								 $emp_obj= new Employee();
								 $db_function=new DBFunction();
								 $user_obj=new User();
									 
								if(isset($postArr['from_date'])){
								
								  $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
								  $todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
								}else{
								  $fromdate=$com_obj->getcurrentDate("Y-m-d");
								  $todate=$com_obj->getcurrentDate("Y-m-d");
								}
									
									$selectCondition[]="`date`>='".$fromdate."'";
									$selectCondition[]="`date`<='".$todate."'";
								//check report for current user
								if($getArr['login_user']){
								  $postArr['doctor']=$_SESSION['emp_id'];
								  $postArr['login_user']=$getArr['login_user'];
								}
									
									if(!empty($postArr['doctor'])){
									$docid=$postArr['doctor'];
									 $selectCondition[]="doctor='".$docid."'";
									 $postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");
									}
									if(!empty($getArr['docid'])){
									$postArr['doctor']=$docid=$getArr['docid'];
									 $selectCondition[]="doctor='".$docid."'";
									  $postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");
									
									}
									$selectCondition[]="`status`=0";
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
                               											

								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$user_data);
							
								 if(empty($postArr['user_type']) && empty($postArr['user']) && $user_type_id == 6){
									
									 if(count($userInfo) >0 ) {
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
									  }
									if($user_id == "") $user_id ="(0)";	
									
									}
									
								if(!empty($user_id)){
							
								  $selectCondition[]="user in $user_id";
								}
									 
									 $is_field[0]="a.title='Dr'";	
									 //check report for current user
								      if(!empty($getArr['login_user'])){
								        $is_field[1]="a.id='".$_SESSION['emp_id']."'";	
								     }
									 $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
									 $form_creator ->popArr['visitInfo']=$ip_obj->getDoctorVisit('',$selectCondition);
			
			                                                 $form_creator ->formPath ='/templates/reports/doctor_ip_visit_report.php';
			                                        break;
			case 'doctor_procedure_report_consolidated'  :
									 $bill_obj=new Billing();
									 $db_function=new DBFunction();
									 $com_obj = new CommonFunctions();
									 $emp_obj= new Employee();
									 
									 if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
									$post['from_date']=date("d-m-Y",strtotime($fromdate));
									$post['to_date']=date("d-m-Y",strtotime($todate));
								
									if(!empty($getArr['docid'])){
									$postArr['doctor']=$docid=$getArr['docid'];
									
									 $is_field[]="a.`id`='".$docid."'";
									}
									if(!empty($postArr['doctor'])){
									$docid=$postArr['doctor'];
									$post['doc_name']=$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");
									
									 $is_field[]="a.`id`='".$docid."'";
									}
									 $selectCondition[]="b.`cancelled`=0";
									 $is_field[]="a.title='Dr'";	
									 $form_creator ->popArr['doctors']=$doctors=$emp_obj->getEmployee($is_field);
									 
									 $arrList=array();
									 $j=0;
									 
									 if(count($doctors) >0 ){
									
									  for($i=0;$i<count($doctors);$i++){
									  
									  
									      $wheredata[0]="bill_date >='".$fromdate."'";
									      $wheredata[1]="bill_date <='".$todate."'";
										  $wheredata[3]="status=0";
									 
									   
										
										
										
										    $arrList[$i][0]="Dr ".$db_function->getidToValue("first_name","id",$doctors[$i][0],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$doctors[$i][0],"hcare_emp_info");	
											
											$wheredata[2]="doc_id ='".$doctors[$i][0]."'";
									        $select[0] ="sum(dr_amount)";
									        $docamt=$bill_obj->getDocProcedureConso($select,$wheredata);
											$arrList[$i][1]=$docamt[0][0];
											
											 $wheredata[2]="surgeon_id ='".$doctors[$i][0]."'";
									         $select[0] ="sum(surgeon_fee)";
											 $surgeon_fee=$bill_obj->getDocProcedureConso($select,$wheredata);
											 $arrList[$i][2]=$surgeon_fee[0][0];
											
											 $wheredata[2]="anesthestis ='".$doctors[$i][0]."'";
									         $select[0] ="sum(anasthesia)";
											 $anasthestis=$bill_obj->getDocProcedureConso($select,$wheredata);
											 $arrList[$i][3]=$anasthestis[0][0];
											 
											 $wheredata[2]="assistant_doc1 ='".$doctors[$i][0]."'";
									         $select[0] ="sum(assistant_fee1)";
											 $assistant_fee1=$bill_obj->getDocProcedureConso($select,$wheredata);
											 $arrList[$i][4]=$assistant_fee1[0][0];
											 
											 $wheredata[2]="assistant_doc2 ='".$doctors[$i][0]."'";
									         $select[0] ="sum(assistant_fee2)";
											 $assistant_fee2=$bill_obj->getDocProcedureConso($select,$wheredata);
											 $arrList[$i][5]=$assistant_fee2[0][0];
											 
											  $arrList[$i][6]=$doctors[$i][0];

                                            // gynec_fee
											  $wheredata[2]="doc_id ='".$doctors[$i][0]."'";
									          $select[0] ="sum(gynec_fee)";
									          $docamt=$bill_obj->getDocProcedureConso($select,$wheredata);
											  $arrList[$i][7]=$docamt[0][0];
									    
									  }
									}
									
									$form_creator ->popArr['doctor_info']=$arrList;	
									
									
									 $is_field[]="a.title='Dr'";	
									 $form_creator ->popArr['doctors']=$doctors=$emp_obj->getEmployee($is_field);
                                $form_creator ->popArr['post']=$post;	

                                if (!empty($postArr['pdf'])) {
                                	$form_creator ->popArr['pdf']=$postArr['pdf'];
                                }

	                            $form_creator ->formPath ='/templates/reports/doctor_procedure_report_consolidated.php';
								break;
				case 'doctor_procedure_report': $bill_obj=new Billing();
				                                $emp_obj= new Employee();
												 $db_function=new DBFunction();
				
				                         $k=0;
				                        if(!empty($getArr['docid'])) {
										
										      $docid=$getArr['docid'];
											  $postArr['doctor']=$docid=$getArr['docid'];
										}	
				                        if(!empty($postArr['from_date'])) {
										
											$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
											$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
										}else{
											$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
											$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
										}
										if(!empty($postArr['doctor'])){
									       $docid=$postArr['doctor'];
										   $postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");
									
									      $wheredata[$k++]="(doc_id ='".$docid."' or surgeon_id ='".$docid."' or anesthestis ='".$docid."' or assistant_doc1 ='".$docid."' or assistant_fee2 ='".$docid."')";
										
									   }
									   
									    $wheredata[$k++]="status=0";
				                        $form_creator ->popArr['billItemInfo']=$bill_obj->getBillItemsInfo($wheredata);
										$is_field[]="a.title='Dr'";	
									 $form_creator ->popArr['doctors']=$doctors=$emp_obj->getEmployee($is_field);
										 $form_creator ->popArr['post']=$postArr;
				                        $form_creator ->formPath ='/templates/reports/doctor_procedure_report.php';
										break;
										
				case 'credit_payment' :
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
										if(!empty($postArr['type'])) {
											$wheredata[$k++]="a.type ='".$postArr['type']."'";
											
										}


                                         if(!empty($postArr['status'])) {
											$wheredata[$k++]="b.status ='".$postArr['status']."'";
										}else $wheredata[$k++]="b.status ='0'";
										

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
											
											
										
											
										
										
										$wheredata[$k++]="a.status ='0'";
										$wheredata[$k++]="a.credit > 0";
										
										
										
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
										$form_creator ->popArr['billInfo']=$bill_obj->getfullCreditInfo($wheredata);
										$form_creator ->formPath ='/templates/reports/credit_payment_report.php';
										break;
		case 'itemwise_conso_bill_report'		: 		
										$bill_obj=new Billing();
										$user_obj=new User();
										$db_function =new DBFunction();
										$k=0;

										if (!empty($postArr['from_time'])) {
											$from_time = date('H:i:s',strtotime($postArr['from_time']));
										}
										else{
											$from_time = '00:00:00';
										}

										if (!empty($postArr['to_time'])) {
											$to_time = date('H:i:s',strtotime($postArr['to_time']));
										}
										else{
											$to_time = '23:59:59';
										}


										if(!empty($postArr['from_date'])) {
										
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
										}else{
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d")." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d")." ".$to_time."'";
										}


										$pInfo=explode(" -",$postArr['particulars_ID']);

										if(!empty($postArr['particulars'])){
										$ptype=$pInfo[0];
										$pid=$pInfo[1];


										$wheredata[]="b.type='".$ptype."'";


										if($ptype == "L"){

											if($db_function->isValidCatagory($item)){

												$tid=$db_function->getidToValue("tid","eid",$pid,"hcare_lab_test_element");
												$wheredata[]="(b.test_id='".$pid."' or b.test_id='".$tid."')";
	
	
	
											}else{
												$wheredata[]="b.test_id='".$pid."'";
											}
									        }else if($ptype == "LT"){
										   $wheredata[]="b.test_id='".$pid."'";
										}else if($ptype == "LE"){
										         $tid=$db_function->getidToValue("tid","eid",$pid,"hcare_lab_test_element");
											  $wheredata[]="(b.test_id='".$pid."' or b.test_id='".$tid."')";
										}else{
										      $wheredata[]="b.test_id='".$pid."'";
									        }
									}

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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
																				
										
										$form_creator ->popArr['post']=$postArr;
										$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								        $form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
										
										if(!empty($user_id)) $wheredata[]= "a.user_id in $user_id";
										
										$wheredata[]="b.status=0";
										$wheredata[]="b.heading=0";
										$bill_info=$bill_obj->getBillConsoItems($wheredata);
										
										
										$form_creator ->popArr['billInfo']=$bill_info;
										$form_creator ->formPath ='/templates/reports/billing_report_conso_items.php';
										break;
case 'bill_report_item_details'		: 		
										$bill_obj=new Billing();
										$user_obj=new User();
										$db_function =new DBFunction();
										$k=0;
										
										 if(!empty($postArr['from_time'])){
                                                 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										        
											}else{
											
											     $from_time="00:00:00";
										        
											}
											if(!empty($postArr['to_time'])){
                                               
										         $to_time=date("H:i:s",strtotime($postArr['to_time']));
											}else{
											
											   
										         $to_time="23:59:59";
											}
										if(!empty($postArr['from_date'])) {
										
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
										}else{
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d")." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d")." ".$to_time."'";
										}
										if(!empty($postArr['billno'])) {
											$wheredata[$k++]="a.id ='".$postArr['billno']."'";
										}
										if(!empty($postArr['status'])) {
											$wheredata[$k++]="a.status ='".$postArr['status']."'";
										}else $wheredata[$k++]="a.status ='0'";
										
										if(!empty($postArr['type'])) {
											$wheredata[$k++]="a.type ='".$postArr['type']."'";
											
										}
										
										//Filter data by name if name field is not empty
										if($postArr['type'] == "OP" &&  !empty($postArr['name'])) {
											$wheredata[$k++]="b.first_name like '%".$postArr['name']."%'";
											
										}elseif($postArr['type'] == "DIRECT" &&  !empty($postArr['name'])) {
											$wheredata[$k++]="c.name like '%".$postArr['name']."%'";
											
										}elseif(!empty($postArr['name'])){
										
											$wheredata[$k++]="(b.first_name like '%".$postArr['name']."%' or c.name like '%".$postArr['name']."%')";
											
										}
										
										
										/*$user_type=$_SESSION['user_type'];
										$user_type_id=$_SESSION['user_type_id'];
										
										if(!empty($postArr['user'])) {
											$wheredata[$k++]="a.user_id ='".$postArr['user']."'";

											
										}
										$user_data=="";
										
									    if(($user_type !='ADMIN' && $user_type !='ADMIN+DOCTOR')){
										
											$user_id=$_SESSION['user_id'];
											$wheredata[$k++]="a.user_id ='".$user_id."'";
											$user_data[0]="user_type='".$user_type_id."'";
											$postArr['user']=$user_id; 
										}
										$user_type_info=array();
										
									    if(($user_type !='ADMIN' && $user_type !='ADMIN+DOCTOR') ){
										
											
											
											
											//IF USER LOGGED IN IS LAB ADMIN SHOW LAB USER IN USERTYPE DROPDOWN
											if($user_type == "LAB ADMIN"){
												
												$user_type_info[]="user_type='LAB ADMIN' or user_type='LAB USER'";

											}else{
												
												$user_type_info[]="user_type='".$user_type."'";
											
											}
											
										}
										
									
										$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
										
										$form_creator ->popArr['post']=$postArr;
										$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);*/
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $wheredata[]= "a.user_id in $user_id";
										
										$bill_info=$bill_obj->getBillInfoAllField($wheredata);
										
										if(!empty($bill_info)){
										
											for($i=0;$i<count($bill_info);$i++){
											
												$billid=$bill_info[$i][0];
												$itemcondition[0]="bill_id = ".$billid;
												$itemInfo=$bill_obj->getBillItemsInfo($itemcondition);
												$items="";
												if(!empty($itemInfo)){
													for($k=0;$k<count($itemInfo);$k++){
													
														$items .=$itemInfo[$k][5]."<br>";
												
													}
												}
												$bill_info[$i][23]=$items;
											}
										}
										$form_creator ->popArr['billInfo']=$bill_info;
										$form_creator ->formPath ='/templates/reports/billing_report_item_details.php';
										break;
		case 'bill_report'		:
										$bill_obj=new Billing();
										$user_obj=new User();													
										$db_function =new DBFunction();
										$k=0;
										
										 if(!empty($postArr['from_time'])){
                                                 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										         $to_time=date("H:i:s",strtotime($postArr['to_time']));
											}else{
											
											     $from_time="00:00:00";
										         $to_time="23:59:59";
											}
											
										if(!empty($postArr['from_date'])) {
										
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
											$postArr['from_date']=date("d-m-Y",strtotime($postArr['from_date']))." ".$from_time;
										    $postArr['to_date']=date("d-m-Y",strtotime($postArr['to_date']))." ".$to_time;
										}else{
											$wheredata[$k++]="a.bill_date >='".date("Y-m-d")." ".$from_time."'";
											$wheredata[$k++]="a.bill_date <='".date("Y-m-d")." ".$to_time."'";
											$postArr['from_date']=date("d-m-Y")." ".$from_time;
										    $postArr['to_date']=date("d-m-Y")." ".$to_time;
										}
										if(!empty($postArr['billno'])) {
											$wheredata[$k++]="a.id ='".$postArr['billno']."'";
										}
										if(!empty($postArr['status'])) {
											$wheredata[$k++]="a.status ='".$postArr['status']."'";
										}else $wheredata[$k++]="a.status ='0'";
										
										if(!empty($postArr['type'])) {
											$wheredata[$k++]="a.type ='".$postArr['type']."'";
											
										}
										
										//Filter data by name if name field is not empty
										if(!empty($postArr['type']) == "OP" &&  !empty($postArr['name'])) {
											$wheredata[$k++]="b.first_name like '%".$postArr['name']."%'";
											
										}elseif(!empty($postArr['type']) == "DIRECT" &&  !empty($postArr['name'])) {
											$wheredata[$k++]="c.name like '%".$postArr['name']."%'";
											
										}elseif(!empty($postArr['name'])){
										
											$wheredata[$k++]="(b.first_name like '%".$postArr['name']."%' or c.name like '%".$postArr['name']."%')";
											
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
                               											

                            	if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){
							   
							   //EXTRACTUSER TYPE IF LABADMIN SHOW LABUSER ELSE SHOW USERTYPE LOGGED IN

                                  if($user_type_id == 6 ) {
										 
                                       $user_type_info[]="id='".$user_type_id."' or id='7'"; 
									 
								   }else  {
								   
								     $user_type_info[]="id='".$user_type_id."'"; 
									  $postArr['user_type']=$user_type_id;
									}
									
									if(empty($postArr['user_type'])) {
										 
										 if($user_type_id == 6 ){
										 	$user_data[0]="user_type='".$user_type_id."'"." or "."user_type='7'";
										 }else{
										    $user_data[0]="user_type='".$user_type_id."'";
										 }
									}else if(!isset($postArr['user'])){
									
									      $user_data[0]="user_type='".$user_type_id."'";
										   $postArr['user']=$_SESSION['user_id'];
										   $user_id="($_SESSION[user_id])";
									}else{
										 
										     $user_data[0]="user_type='".$user_type_id."'";
											  
									}
							}					   
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$user_data);
							
								 if(empty($postArr['user_type']) && empty($postArr['user']) && $user_type_id == 6){
									
									 if(count($userInfo) >0 ) {
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
									  }
									if($user_id == "") $user_id ="(0)";	
									
									}
								if(!empty($user_id)){
							
								  $wheredata[$k++]="a.user_id in $user_id";
								}
								
								
										
										$form_creator ->popArr['post']=$postArr;
										
										$form_creator ->popArr['billInfo']=$bill_obj->getBillInfoAllField($wheredata);
										$form_creator ->formPath ='/templates/reports/billing_report.php';
										break;
			case 'ip_lab_reports'     :  
			                            $emp_obj= new Employee();
									    $ip_obj= new Inpatient();
									    $com_obj = new CommonFunctions(); 
								              
										//search criterias
			                if(!empty($postArr['action']) &&  $postArr['action']=="SEARCH")  
			                    {             
								        if(!empty($postArr['admitted_on'])){

												$admitted_on=$com_obj->getcurrentDate("Y-m-d",$postArr['admitted_on']);
												$selectCondition[]="b.`admission_date`>='".$admitted_on."'";	
								        }

								        if(!empty($postArr['discharged_on'])){
								    
												$discharged_on=$com_obj->getcurrentDate("Y-m-d",$postArr['discharged_on']);
												$selectCondition[]="b.`discharge_date`<='".$discharged_on."'";
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
												
												if(!empty($postArr["place"])){
													$selectCondition[]="a.`place`='".$postArr["place"]."'";
												}
								}				
						    if(!empty($postArr['action']) &&  $postArr['action']=="CLEAR")
						        {
						        	/*... op number empty...*/
						        	$selectCondition[]="a.`id`=''";
						        }		             
									    if(empty($selectCondition)){
									    	$today=date("Y-m-d");
									    $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL OR b.`discharge_date`='".$today."')";
									    
									  
								        }

									    $selectCondition[]="b.`cancelled`=0";
								
									 //retrieve patient information
									    $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                        
										$form_creator ->popArr['post']=$postArr;
						 			    
									   	       
										$is_field[0]="a.title='Dr'";													
										$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
			                            $form_creator ->formPath ='/templates/reports/ip_lab_reports.php';
										break;
										
			case 'ip_lab_report_person'  :  
		                                $ip_obj= new Inpatient();
		                                $bill_obj= new Billing();
						                $lab_obj=new LabFunctions();
						                $lab_obj_mod=new LabModel();
		                                $ipno=$postArr['id'];//ipno
						                $selectCondition[0]="b.`id`='".$ipno."'";
						                $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
				
						                $criteria[0]="type ='IP'";
						                $criteria[1]="ref_no ='".$ipno."'";
						                $criteria[2]="lab_status =1";
						                $criteria[3]="status =0";
						                $billInfo=$bill_obj->getBillInfo($criteria);
						                $resultInfo=array();
						              if(!empty($billInfo)){
						                
						                for($i=0;$i<count($billInfo);$i++){
						                  
						                     $bill_id=$billInfo[$i][0];
						                     $result_condn[0]="bill_no =".$bill_id;
						                   
						                     $resultInfo[$i]=$lab_obj_mod->getLabresultEntryById($result_condn,"id","asc");
						              
						                        }
                                           
						    
						                 }
						               $form_creator ->popArr['billInfo']=$billInfo;
						               $form_creator ->popArr['resultInfo']=$resultInfo;
			                            $form_creator ->formPath ='/templates/reports/ip_lab_report_person.php';
			                            break;

			case 'test_consolidated' :
										$this->getConsolidatedTest($postArr);
										$form_creator ->formPath ='/templates/reports/test_consolidated.php';
										break;
		 case 'itemwise_bill_report' :
		 
		 								$cat_obj=new Category();
										$form_creator ->popArr['category']=$cat_obj->getCategory();
										
										$form_creator ->popArr['itemInfo']=array();
										
										
										$form_creator ->popArr['post']=$postArr;
										
										//if(!empty($postArr['particulars'])){
										
											
											$form_creator ->popArr['itemInfo']=$this->getitemwise_bill_report($postArr);
									//	}
									
										
										$form_creator ->formPath ='/templates/reports/itemwise_bill_report.php';
										break;
	        case 'ip_payment_report':    $bill_obj= new Billing(); 
		                              $user_obj=new User();
					      $db_function =new DBFunction();
		                  $k=0;
		                   if(!empty($postArr['from_time'])){
                                                 $from_time=date("H:i:s",strtotime($postArr['from_time']));
										         $to_time=date("H:i:s",strtotime($postArr['to_time']));
											}else{
											
											     $from_time="00:00:00";
										         $to_time="23:59:59";
											}
						if(!empty($postArr['from_date'])) {
										
							$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
							$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";

						   $postArr['from_date']=date("d-m-Y",strtotime($postArr['from_date']));
						   $postArr['to_date']=date("d-m-Y",strtotime($postArr['to_date']));
						}else{
							$wheredata[$k++]="bill_date >='".date("Y-m-d")." ".$from_time."'";
							$wheredata[$k++]="bill_date <='".date("Y-m-d")." ".$to_time."'";
							
							$postArr['from_date']=date("d-m-Y");
							$postArr['to_date']=date("d-m-Y");
						}
						if(!empty($postArr['billno'])) {
								$wheredata[$k++]="id ='".$postArr['billno']."'";
						}
						if(!empty($postArr['ipno'])) {
								$wheredata[$k++]="ipno='".$postArr['ipno']."'";
						}
						
						if(!empty($postArr['user'])) {
								$wheredata[$k++]="user_id='".$postArr['user']."'";
								$postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");														
								
						}
		                               $wheredata[$k++]="(bill_status !=1 and bill_status!=3)";
		                               $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
					       $form_creator ->popArr['post']=$postArr;
		                               $form_creator ->popArr['user']=$user_obj->getUser();;
		                               $form_creator ->formPath ='/templates/reports/ip_payment_report.php';

						break;
		case 'ip_payment_discount_report':    $bill_obj= new Billing(); 
		                              $user_obj=new User();
					      $db_function =new DBFunction();
		  
		  
		                               $k=0;
						if(!empty($postArr['from_date'])) {
										
							$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
							$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
						}else{
							$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
							$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
							
							$postArr['from_date']=date("d-m-Y");
							$postArr['to_date']=date("d-m-Y");
						}
						if(!empty($postArr['billno'])) {
								$wheredata[$k++]="id ='".$postArr['billno']."'";
						}
						if(!empty($postArr['ipno'])) {
								$wheredata[$k++]="ipno='".$postArr['ipno']."'";
						}
						
						if(!empty($postArr['user'])) {
								$wheredata[$k++]="user_id='".$postArr['user']."'";
								$postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");														
								
						}
		                               $wheredata[$k++]="(bill_status !=1 and bill_status!=3)";
									   $wheredata[$k++]="disc_amt > 0";
		                               $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
					       $form_creator ->popArr['post']=$postArr;
		                               $form_creator ->popArr['user']=$user_obj->getUser();;
		                               $form_creator ->formPath ='/templates/reports/ip_payment_discount_report.php';
									   break;
		case 'ip_payment_report_itemwise' :$bill_obj= new Billing(); 
		                                   $user_obj=new User();
						   
						   $db_function =new DBFunction();
						   $k=0;
						 if(!empty($postArr['from_date'])) {
										
							$wheredata[$k++]="a.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
							$wheredata[$k++]="a.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
						}else{
							$wheredata[$k++]="a.bill_date >='".date("Y-m-d")." 00:00:00'";
							$wheredata[$k++]="a.bill_date <='".date("Y-m-d")." 23:59:59'";
							
							$postArr['from_date']=date("d-m-Y");
							$postArr['to_date']=date("d-m-Y");
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
                               											

                            	                                if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR'){
							   
								$user_type_info[]="id='".$user_type_id."'"; 
								$postArr['user_type']=$user_type_id;
									
									
									if(empty($postArr['user_type'])) {
										
										$user_data[0]="user_type='".$user_type_id."'";
										
									}else if(!isset($postArr['user'])){
									
									      $user_data[0]="user_type='".$user_type_id."'";
									      $postArr['user']=$_SESSION['user_id'];
									      $user_id="($_SESSION[user_id])";
									}else{
										 
								         $user_data[0]="user_type='".$user_type_id."'";
											  
									}
							   }					   
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$user_data);
							
								 if(empty($postArr['user_type']) && empty($postArr['user']) && $user_type_id == 6){
									
									 if(count($userInfo) >0 ) {
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
									  }
									if($user_id == "") $user_id ="(0)";	
									
									}
								if(!empty($user_id)){
							
								  $wheredata[$k++]="a.user_id in $user_id";
								}
						
						  $billItems=$bill_obj->getIPBillItemName();  
						  $wheredata[$k++] ="(b.status =0)";
						  $billItemInfo=array();
						  $m=0;
						  if(!empty($billItems)){
						  
						    for($i=0;$i<count($billItems);$i++){
						    
						        $wheredata[$k]='b.particulars="'.$billItems[$i].'"';
							$getIPBillConsoItems=$bill_obj->getIPBillConsoItems($wheredata);
							if(!empty($getIPBillConsoItems)){
							$billItemInfo[$m][0]=$billItems[$i];
							$billItemInfo[$m][1]=$getIPBillConsoItems[0][0];
							$billItemInfo[$m][2]=$getIPBillConsoItems[0][1];
							$m++;
							}
						    }
						  
						  }
						   $form_creator ->popArr['billItemInfo']=$billItemInfo;
						  // $form_creator ->popArr['billItems']=$billItems;
						   
						   $form_creator ->formPath ='/templates/reports/ip_payments_item_report.php';
						   break;
		case 'ip_credit_report':      $bill_obj= new Billing(); 
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
		                               $form_creator ->popArr['billInfo']=$bill_obj->getIPBillInfo($wheredata);
		                               $form_creator ->popArr['user']=$user_obj->getUser();
		                               $form_creator ->popArr['post']=$postArr;
		                               $form_creator ->formPath ='/templates/reports/ip_credit_report.php';
						break;	
    case 'admitted_patient_report' : 
		                             $emp_obj= new Employee();
								     $room_obj= new Room();
								     $com_obj = new CommonFunctions();
								     $ip_obj= new Inpatient();
									 $ipfunc_obj= new IpFunctions();
									 $bill_obj= new Billing();
									 $db_function =new DBFunction();
								   
								   //search criterias
								   if(isset($postArr['from_date']) && $postArr['paction']!="CLEAR"){
								   
								                if(!empty($postArr["from_date"])){
												 $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												 $selectCondition[]="b.`admission_date`>='".$fromdate."'";
									 
												}
												if(!empty($postArr["to_date"])){
												   $to_date=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
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
													$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
												}
												if(!empty($postArr["room_no"])){
													$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
													
												}
								   }else{
												$fromdate=$com_obj->getcurrentDate();
												$todate=$com_obj->getcurrentDate();
									}
									
									  
                                    $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
									$selectCondition[]="b.`cancelled`=0";
									
									$form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
									$ipbillInfo=array();
									if(!empty($patientInfo)){
									
									  for($i=0;$i<count($patientInfo);$i++){
									  
									  if($patientInfo[$i][51] == 2){
									 
										  
										  $wheredata[0]="ipno='".$patientInfo[$i][13]."'";
                                          $wheredata[1]="(bill_status !=1 and bill_status !=3)";														
                                          $billInfo=$bill_obj->getIPBillInfo($wheredata);
										  
										   $ipbillInfo[$i][0]=$billInfo[0][4];
										   $ipbillInfo[$i][1]=$billInfo[0][5];
										   $ipbillInfo[$i][2]=$billInfo[0][8];
									  
									  }else{
									          $ipInfo['id']=$patientInfo[$i][13];
									          $billInfo=$ipfunc_obj->calculateBill($ipInfo);
										
										      $ipbillInfo[$i][0]=$billInfo['total_bill_amount'];
										      $ipbillInfo[$i][1]=$billInfo['paid_amount'];
										      $ipbillInfo[$i][2]=$billInfo['balance'];
										}
									  }
									
									}
									$form_creator ->popArr['ipbillInfo']=$ipbillInfo;
									if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
									}else $form_creator ->popArr['post']='';
								  
								  $is_field[0]="a.title='Dr'";													
								  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
								  
								 // $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails();
		                          $form_creator ->formPath ='/templates/reports/admitted_patient_report.php';
										break;									
        case 'ip_patient_report' : 
		                             $emp_obj= new Employee();
								     $room_obj= new Room();
								     $com_obj = new CommonFunctions();
								     $ip_obj= new Inpatient();
									 $ipfunc_obj= new IpFunctions();
									 $bill_obj= new Billing();
								   
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
													$selectCondition[]="a.`place`='".$postArr["place"]."'";
												}
												if(!empty($postArr["doctor"])){
													$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
													$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
												}
												if(!empty($postArr["room_no"])){
													$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
												}
												if(!empty($postArr["gender"])){
													$selectCondition[]="a.`gender`='".$postArr["gender"]."'";
												}

								   }else{
												$fromdate=$com_obj->getcurrentDate();
												$todate=$com_obj->getcurrentDate();
									}
									
									if(empty($postArr["opno"]) && empty($postArr["ipno"])){
									  $selectCondition[]="b.`admission_date`>='".$fromdate."'";
									   $selectCondition[]="b.`admission_date`<='".$todate."'";  
								   }
									$selectCondition[]="b.`cancelled`=0";
									
									$form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
									$ipbillInfo=array();
									if(!empty($patientInfo)){
									
									  for($i=0;$i<count($patientInfo);$i++){
									  
									  if($patientInfo[$i][51] == 2){
									 
										  
										  $wheredata[0]="ipno='".$patientInfo[$i][13]."'";
                                          $wheredata[1]="(bill_status !=1 and bill_status !=3)";														
                                          $billInfo=$bill_obj->getIPBillInfo($wheredata);
										  
										   $ipbillInfo[$i][0]=$billInfo[0][4];
										   $ipbillInfo[$i][1]=$billInfo[0][5];
										   $ipbillInfo[$i][2]=$billInfo[0][8];
									  
									  }else{
									          $ipInfo['id']=$patientInfo[$i][13];
									          $billInfo=$ipfunc_obj->calculateBill($ipInfo);
										
										      $ipbillInfo[$i][0]=$billInfo['total_bill_amount'];
										      $ipbillInfo[$i][1]=$billInfo['paid_amount'];
										      $ipbillInfo[$i][2]=$billInfo['balance'];
										}
									  }
									
									}
									$form_creator ->popArr['ipbillInfo']=$ipbillInfo;
									if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
									}else $form_creator ->popArr['post']='';
								  
								  $is_field[0]="a.title='Dr'";													
								  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
								  
								 // $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails();
		                          $form_creator ->formPath ='/templates/reports/ip_patient_report.php';
										break;	
case 'ip_insurance_patient_report' : 
		                             $emp_obj= new Employee();
								     $room_obj= new Room();
								     $com_obj = new CommonFunctions();
								     $ip_obj= new Inpatient();
									 $ipfunc_obj= new IpFunctions();
									 $bill_obj= new Billing();
									 $ins_obj=new InsuranceCompany();
                                     $db_function=new DBFunction();
                                     $pagi_obj = new Pagination();
								   //search criterias
						if(!empty($postArr['paction']) &&  ($postArr['paction']=="SEARCH" || $postArr['paction']=="BACK"))
						        {
								    if(!empty($postArr['from_date'])){

												$admitted_on=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$selectCondition[]="b.`admission_date`>='".$admitted_on."'";
                                /*..... insurance patient condition .....*/
												 $selectCondition[]="b.`insurance_company` >0";	
								        }

								    if(!empty($postArr['to_date'])){
								    
												$discharged_on=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												$selectCondition[]="b.`discharge_date`<='".$discharged_on."'";
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
								        }
									if(!empty($postArr["opno"])){
												$selectCondition[]="a.`id`='".$postArr["opno"]."'";
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
										}
									if(!empty($postArr["ipno"])){
												$selectCondition[]="b.`id`='".$postArr["ipno"]."'";
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
										}
									if(!empty($postArr["first_name"])){
												$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
										}
									if(!empty($postArr["place"])){
												$selectCondition[]="a.`place`='".$postArr["place"]."'";
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
										}
									if(!empty($postArr["doctor"])){
												$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
												$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
                                /*..... insurance patient condition .....*/
												$selectCondition[]="b.`insurance_company` >0";
										}
									if(!empty($postArr["insurance_company"])){
              $ins_name=$db_function->getidToValue("insurance_company","id",$postArr["insurance_company"],"hcare_insurance_company");	

											$selectCondition[]="d.`insurance_company`='".$ins_name."'";
								$postArr["insurance_company_name"]=$ins_name;
                                /*..... insurance patient condition .....*/
													 $selectCondition[]="b.`insurance_company` >0";
										}
								}
						// if(!empty($postArr['paction']) &&  $postArr['paction']=="CLEAR")
						//         {
						//         /*... op number empty...*/
						//         	$selectCondition[]="a.`id`=''";
						//         }	
						if(empty($selectCondition)){
									    $selectCondition[]="b.`insurance_company` >0";
									    
									  
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
        /*...............search inpatient...............*/                      	 
                            if(!empty($postArr['paction']) &&  ($postArr['paction']=="SEARCH" || $postArr['paction']=="BACK")){            	 
                                     
                                  if(!empty($postArr['current_page']) && $postArr['current_page']>1)
                                      {
                                      	if($postArr['paction']=="SEARCH"){
                                                $current_page =1;
                                                $limit="0,20";
                                            }
                                        else{
                                                $current_page = $postArr['current_page'];
                                                $limit=$pagi_obj->pageLimit($current_page,$perPage);  
                                            }    
                                      }
                                  else{
                                          $current_page =1;
                                          $limit="0,20";
                                      }   
                                }
                            else{
                                     $limit=$pagi_obj->pageLimit($current_page,$perPage);
                                }   

                            //dasasd
                            if (!empty($postArr['pdf'])) {
                            	$limit="";
                            }

                            $patientCount=$ip_obj->getIPPatientCount($selectCondition);
                            
                            $form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc',$limit);

                            $form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patientCount,$current_page,$perPage);

                            $form_creator ->popArr['current_page']=$current_page;

        /*...............pagination end.............*/                                 	
									
									$ipbillInfo=array();
									if(!empty($patientInfo)){
									
									  for($i=0;$i<count($patientInfo);$i++){
									  
									  if($patientInfo[$i][51] == 2){
									 
										  
										  $wheredata[0]="ipno='".$patientInfo[$i][13]."'";
                                          $wheredata[1]="(bill_status !=1 and bill_status !=3)";														
                                          $billInfo=$bill_obj->getIPBillInfo($wheredata);
										  
										   $ipbillInfo[$i][0]=$billInfo[0][4];
										   $ipbillInfo[$i][1]=$billInfo[0][5];
										   $ipbillInfo[$i][2]=$billInfo[0][8];
									  
									  }else{
									          $ipInfo['id']=$patientInfo[$i][13];
									          $billInfo=$ipfunc_obj->calculateBill($ipInfo);
										
										      $ipbillInfo[$i][0]=$billInfo['total_bill_amount'];
										      $ipbillInfo[$i][1]=$billInfo['paid_amount'];
										      $ipbillInfo[$i][2]=$billInfo['balance'];
										}
									  }
									
									}
									$form_creator ->popArr['ipbillInfo']=$ipbillInfo;
									if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
									}else $form_creator ->popArr['post']='';
								  
								  $is_field[0]="a.title='Dr'";													
								  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
								  $form_creator ->popArr['insurance_company']=$ins_obj->getInsuranceCompany();
								  
								 // $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails();
		                          $form_creator ->formPath ='/templates/reports/ip_insurance_patient_report.php';
										break;	
case 'ip_insurance_patient_bill_report'	: 
                                  $ip_obj= new Inpatient();
                                  $bill_obj= new Billing();
                                  $ipno=$postArr['id'];//ipno
						          $selectCondition[0]="b.`id`='".$ipno."'";
						          $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                              
                                    $criteria[0]="type ='IP'";
						            $criteria[1]="ref_no ='".$ipno."'";
						            $criteria[2]="status =0";
						          $billInfo=$bill_obj->getBillInfo($criteria);

                                  $form_creator ->popArr['post']=$postArr;
                                  $form_creator ->popArr['billInfo']=$billInfo;
                                  $form_creator ->formPath ='/templates/reports/ip_insurance_patient_bill_report.php';
                                  break;

case 'ip_insurance_pharma_invoice_report'	:
                                  $ip_obj= new Inpatient();
                                  $pharama_obj= new PharmaFunctions();
                                  $ipno=$postArr['id'];//ipno
                                  $selectCondition[0]="b.`id`='".$ipno."'";
						          $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
						            $criteria[0]="cust_type ='IP'";
						            $criteria[1]="ip_no ='".$ipno."'";
						            $criteria[2]="status =0";
                                 $pharmaInfo=$pharama_obj->getPharmaIpInvoice($criteria);

						          $form_creator ->popArr['post']=$postArr;
                                  $form_creator ->popArr['pharmaInfo']=$pharmaInfo; 
						          $form_creator ->formPath ='/templates/reports/ip_insurance_pharma_invoice_report.php';
                                  break; 

                    case 'ip_patient_category_report' : 
                                     $emp_obj= new Employee();
								     $room_obj= new Room();
								     $com_obj = new CommonFunctions();
								     $ip_obj= new Inpatient();
									 $ipfunc_obj= new IpFunctions();
									 $bill_obj= new Billing();
									 $pat_cat=new PatientCategory();
                                     $db_function=new DBFunction();
                                     $pagi_obj = new Pagination();
								   //search criterias
						if(!empty($postArr['paction']) &&  ($postArr['paction']=="SEARCH"))
						        {
								    if(!empty($postArr['from_date'])){

												$admitted_on=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$selectCondition[]="b.`admission_date`>='".$admitted_on."'";
                                
												 $selectCondition[]="b.`patient_category` >0";	
								        }

								    if(!empty($postArr['to_date'])){
								    
												$discharged_on=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												$selectCondition[]="b.`admission_date`<='".$discharged_on."'";
                                
												$selectCondition[]="b.`patient_category` >0";
								        }
									if(!empty($postArr["opno"])){
												$selectCondition[]="a.`id`='".$postArr["opno"]."'";
                                
												$selectCondition[]="b.`patient_category` >0";
										}
									if(!empty($postArr["ipno"])){
												$selectCondition[]="b.`id`='".$postArr["ipno"]."'";
                                
												$selectCondition[]="b.`patient_category` >0";
										}
									if(!empty($postArr["first_name"])){
												$selectCondition[]="a.`first_name` like '%".$postArr["first_name"]."%'";
                                
												$selectCondition[]="b.`patient_category` >0";
										}
									if(!empty($postArr["place"])){
												$selectCondition[]="a.`place`='".$postArr["place"]."'";
                             
												$selectCondition[]="b.`patient_category` >0";
										}
									if(!empty($postArr["doctor"])){
												$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
												$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
                               
												$selectCondition[]="b.`patient_category` >0";
										}
					/*... patient category ...*/
					        if(!empty($postArr['patient_category'])){
					            	
					            $selectCondition[]="b.`patient_category`='".$postArr['patient_category']."'";
					            $postArr['patient_category_name']=$db_function->getidToValue("patient_category","id",$postArr['patient_category'],"hcare_patient_category");

					        }
					/*... patient category ...*/
						}
							
						if(empty($selectCondition)){

									    $selectCondition[]="b.`patient_category` >0";
									   
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
        /*...............search inpatient...............*/                      	 
                            if(!empty($postArr['paction']) &&  ($postArr['paction']=="SEARCH")){            	 
                                     
                                  if(!empty($postArr['current_page']) && $postArr['current_page']>1)
                                      {
                                      	if($postArr['paction']=="SEARCH"){
                                                $current_page =1;
                                                $limit="0,20";
                                            }
                                        else{
                                                $current_page = $postArr['current_page'];
                                                $limit=$pagi_obj->pageLimit($current_page,$perPage);  
                                            }    
                                      }
                                  else{
                                          $current_page =1;
                                          $limit="0,20";
                                      }   
                                }
                            else{
                                     $limit=$pagi_obj->pageLimit($current_page,$perPage);
                                }            
                            $patientCount=$ip_obj->getIPPatientCount($selectCondition);
                            
                            $form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc',$limit);

                            $form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patientCount,$current_page,$perPage);

                            $form_creator ->popArr['current_page']=$current_page;

        /*...............pagination end.............*/                                 	
								if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
								}else $form_creator ->popArr['post']='';
								  
								  $is_field[0]="a.title='Dr'";													
								  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
								 $form_creator ->popArr['patient_category']=$pat_cat->getPatientCategory(); 
                                  $form_creator ->formPath ='/templates/reports/ip_patient_category_report.php';
                                  break;

			        case 'ip_patient_list_lab_report' : 
		                             $emp_obj= new Employee();
								     $room_obj= new Room();
								     $com_obj = new CommonFunctions();
								     $ip_obj= new Inpatient();
									 $ipfunc_obj= new IpFunctions();
									 $bill_obj= new Billing();
								   
								   //search criterias
								   if(isset($postArr['admitted_on'])){
								   
												$admitted_on=$com_obj->getcurrentDate("Y-m-d",$postArr['admitted_on']);
												$selectCondition[]="b.`admission_date`='".$admitted_on."'";
												
								   }
								    if(isset($postArr['discharged_on'])){
								    
												$discharged_on=$com_obj->getcurrentDate("Y-m-d",$postArr['discharged_on']);
												$selectCondition[]="b.`discharge_date`='".$discharged_on."'";
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
													$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
												}
												if(!empty($postArr["room_no"])){
													$selectCondition[]="c.`room_number`='".$postArr["room_no"]."'";
												}
								   
									
									if(empty($postArr["opno"]) && empty($postArr["ipno"])){
									  $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
								   }
									$selectCondition[]="b.`cancelled`=0";
									
									$form_creator ->popArr['patient_info']=$patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
									
									$form_creator ->popArr['ipbillInfo']=$ipbillInfo;
									if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
									}else $form_creator ->popArr['post']='';
								  
								  $is_field[0]="a.title='Dr'";													
								  $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
								  
								 // $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails();
		                          $form_creator ->formPath ='/templates/reports/ip_patient_list_lab_report.php';
										break;	
		case 'ip_detailed_lab_report' : $ip_obj= new Inpatient();
		                                 $bill_obj= new Billing();
						 $lab_obj=new LabFunctions();
		
		                                $ipno=$postArr['ip_no'];
						$selectCondition[0]="b.`id`='".$ipno."'";
						$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
						
						$criteria[0]="a.type ='IP'";
						$criteria[1]="a.ref_no ='".$ipno."'";
						$criteria[2]="(b.type ='L' or b.type ='LT' or b.type ='LE')";
						$criteria[0]="a.status =0";
						$billInfo=$bill_obj->getAllBillItemPatient($criteria);
						$resultInfo=array();
						if(!empty($billInfo)){
						
						  for($i=0;$i<count($billInfo);$i++){
						  
						    $bill_id=$billInfo[$i][0];
						    $result_condn[0]="bill_no =".$bill_id;
						    
						    $resultInfo[$i]=$lab_obj->getLabResult($result_condn);
						  }
						
						}
						
						$form_creator ->popArr['billInfo']=$billInfo;
						$form_creator ->popArr['resultInfo']=$resultInfo;
						
		                                $form_creator ->formPath ='/templates/reports/ip_detailed_lab_report.php';
		                                  break;
		case 'agewise_ip_patient_report' :  $com_obj = new CommonFunctions();
											$ip_obj= new Inpatient();
											$emp_obj= new Employee();
											
											if(isset($postArr['from_date']) && $postArr['action']!="CLEAR"){
												$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
												$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
												
												
												if(!empty($postArr["age_from"])){
													$selectCondition[]="a.`age`>=".$postArr["age_from"]."";
												}
												if(!empty($postArr["age_to"])){
													$selectCondition[]="a.`age`<=".$postArr["age_to"]."";
												}
												
												if(!empty($postArr["age_from"]) || !empty($postArr["age_to"])){
												
												
												$selectCondition[]="(a.`age` like '%".$postArr["age_type"]."')";
													
												
												}
												if(!empty($postArr["gender"])){
													$selectCondition[]="a.`gender` = '".$postArr["gender"]."'";
												}
												if(!empty($postArr["doctor"])){
													$selectCondition[]="b.`doc_id` = '".$postArr["doctor"]."'";
												}
												
											}else{
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate();
												$postArr['to_date']=$todate=$com_obj->getcurrentDate();
											}
											
										    $selectCondition[]="b.`admission_date`>='".$fromdate."'";
									        $selectCondition[]="b.`admission_date`<='".$todate."'";  
											$selectCondition[]="b.`cancelled`=0";
											
											$form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
											

											$is_field[0]="a.title='Dr'";													
											$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field); 

											 if($postArr['action']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
											}else {
												$form_creator ->popArr['post']='';
											}
											
											
											
											$form_creator ->formPath ='/templates/reports/ip_age_gender_report.php';
											break;
         case 'discharged_patient_report' :
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
								$selectCondition[]="a.`place`='".$postArr["place"]."'";
							}
							if(!empty($postArr["doctor"])){
								$selectCondition[]="b.`doc_id`='".$postArr["doctor"]."'";
								$postArr['doc_name']=$db_function->getidToValue("first_name","id",$postArr["doctor"],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr["doctor"],"hcare_emp_info");
												
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
                    
                                                           
                           $ipbillInfo=array();

                            if(!empty($patientInfo)){
                                for($i=0;$i<count($patientInfo);$i++){
                                                                   
                                    $ipno=$patientInfo[$i][13];
									$condition[0]="ipno ='".$ipno."'";
									$billInfo=$bill_obj->getIPBillInfo($condition);
									if(!empty($billInfo)){
										   for($j=0;$j<count($billInfo);$j++){
									       
										   $ipbillInfo[$i][0]=$billInfo[0][4];
										   $ipbillInfo[$i][1]=$billInfo[0][5];
										   $ipbillInfo[$i][2]=$billInfo[0][8];
										   $ipbillInfo[$i][3]=$billInfo[$j][0];
                                        }
                                    }
                                }


                            }
                        $is_field[0]="a.title='Dr'";                                                  													
						$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
						if(isset($postArr['paction']) && $postArr['paction']!="CLEAR"){
												$form_creator ->popArr['post']=$postArr;
						}else $form_creator ->popArr['post']='';
								  
						$form_creator ->popArr['patientInfo']=$patientInfo;
                        $form_creator ->popArr['billInfo']=$ipbillInfo;
		                $form_creator ->formPath ='/templates/reports/discharged_patient_report.php';
										break;
  case 'ip_list' :
                                   $emp_obj= new Employee();
									    $ip_obj= new Inpatient();
									    $com_obj = new CommonFunctions(); 
								              
										//search criterias
			                if(!empty($postArr['action']) &&  $postArr['action']=="SEARCH")  
			                    {             
								        if(!empty($postArr['admitted_on'])){

												$admitted_on=$com_obj->getcurrentDate("Y-m-d",$postArr['admitted_on']);
												$selectCondition[]="b.`admission_date`>='".$admitted_on."'";	
								        }

								        if(!empty($postArr['discharged_on'])){
								    
												$discharged_on=$com_obj->getcurrentDate("Y-m-d",$postArr['discharged_on']);
												$selectCondition[]="b.`discharge_date`<='".$discharged_on."'";
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
												
												if(!empty($postArr["place"])){
													$selectCondition[]="a.`place`='".$postArr["place"]."'";
												}
								}				
						    if(!empty($postArr['action']) &&  $postArr['action']=="CLEAR")
						        {
						        	/*... op number empty...*/
						        	$selectCondition[]="a.`id`=''";
						        }		             
									    if(empty($selectCondition)){
									    	$today=date("Y-m-d");
									    $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL OR b.`discharge_date`='".$today."')";
									    
									  
								        }

									    $selectCondition[]="b.`cancelled`=0";
								
									 //retrieve patient information
									    $form_creator ->popArr['patient_info']=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
                                        
										$form_creator ->popArr['post']=$postArr;
						 			    
									   	       
										$is_field[0]="a.title='Dr'";													
										$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
			                              $form_creator ->formPath ='/templates/reports/ip_list.php';
			                              break; 
                                     break;
		case 'ip_lab_report_datewise' :$ip_obj= new Inpatient();
		                               $lab_obj_mod=new LabModel();
									   $db_function =new DBFunction();
		
		                                 $ipno=$postArr['id'];//ipno
						                 $selectCondition[0]="b.`id`='".$ipno."'";
		
		                                 $form_creator ->popArr['patient_info']=$patient_info=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');
										  
										  
										   
										   //get distict category from resultInfo
										   
										   $category_condn=array();				                
     
                                           $category_condn[0]="a.`type` ='IP'";
						                   $category_condn[1]="a.`ref_no` ='".$ipno."'";
						                   $category_condn[2]="a.`lab_status` =1";
						                   $category_condn[3]="a.`status` =0";
						                   $category_condn[4]="b.`type` in(0,10,20)"; 
										   
										   $distinct_elements=$lab_obj_mod->distinct_result_elements('',$category_condn,"b.`catid`","asc");
										   
										   //distinct result date
                                          
											 $res_condn[0]="a.type ='IP'";
											 $res_condn[1]="a.ref_no ='".$ipno."'";
											$result_date=$lab_obj_mod->distinct_lab_result_date('',$res_condn,'b.result_date','desc');
											
											$category=array();
										   $elements=array();
										   //$result_value=array();
										   
										  
										   
										   if(!empty($distinct_elements) && !empty($result_date)){
											   
											    for($i=0; $i<count($distinct_elements); $i++){

												if(!in_array($distinct_elements[$i][2],$category)){
													
													$category[$i]=$distinct_elements[$i][2];
													
												   if($distinct_elements[$i][3]==''){
													   
													   $elements[$i][0]='OTHERS';
													   
												   }else $elements[$i][0]=$distinct_elements[$i][3];
												   
												}else $elements[$i][0]='';
												
														$elements[$i][1]=$distinct_elements[$i][1];
														  
														  //get result value datewise
														   //$j=2;
														   for($k = 0; $k < count($result_date); $k++){
															   
                                                            
														     $res_condn[0]="b.result_date like '".$result_date[$k]."%'";
															 $res_condn[1]="a.type ='IP'";
															 $res_condn[2]="a.ref_no ='".$ipno."'";																		 
															 $res_condn[3]="c.tid ='".$distinct_elements[$i][0]."'";
															 $res_condn[4]="c.`type` in(0,10,20)";
															 
															 $elements[$i][2][$k]=$lab_obj_mod->distinct_lab_result('',$res_condn,'c.id','desc');
													          
															 //result date
															 $elements[$i][3][$k]=$result_date[$k];
															 
														  
														  }//dateloop ends here
												
												
												}//element for loop ends here
											   
											   
											   
											}//element if condn ends here*/
											
											   //$form_creator ->popArr['category']=$category;
											   $form_creator ->popArr['elements']=$elements;
											   //$form_creator ->popArr['result_value']=$result_value;
											   $form_creator ->popArr['result_date']=$result_date;
											   /*$form_creator ->popArr['startdate']=$startdate;
											   $form_creator ->popArr['enddate']=$enddate;
											   $form_creator ->popArr['tot_days']=$tot_days;*/
											   $form_creator ->formPath ='/templates/reports/datewise_ip_lab_report.php';
		
		                                 break;

     case  'advance_payment_cancellation_report'  :
                                                    $bill_obj= new Billing();
                                                    $user_obj=new User();
								                    $db_function=new DBFunction();

		                                            $k=0;
		                                            $wheredata= array();


										  if(!empty($postArr['from_date'])) {
										
							                   $wheredata[]="date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
							                   
						                    }

						                    if(!empty($postArr['to_date'])) {
										
							                   $wheredata[]="date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
						                    }

						                    if(!empty($postArr['billno'])) {
								                $wheredata[]="id ='".$postArr['billno']."'";
						                      }
						                    if(!empty($postArr['ipno'])) {
								                      $wheredata[]="ipno='".$postArr['ipno']."'";
						                    }

						                    if(empty($wheredata)){

							                   $wheredata[]="date >='".date("Y-m-d")." 00:00:00'";
							                   $wheredata[]="date <='".date("Y-m-d")." 23:59:59'";
						                    }

						                    if(!empty($postArr['user_type'])) {

						                    	$selectuser[]="user_type='".$postArr['user_type']."'";
								                    
                                                $form_creator ->popArr['user']=$userInfo=$user_obj->getUser('',$selectuser);

						                    }else{

                                                $form_creator ->popArr['user']=$userInfo=$user_obj->getUser(); 

						                    }

						                    if(!empty($postArr['user'])){
                                                  
                                                 $userInfo=array(); 

                                                 $userInfo[][]= $postArr['user'];

						                    }

						                    if(!empty($userInfo)){
      
                                                $user_id_all='';

                                              for($i=0;$i<count($userInfo);$i++){  

	                                            $user_id_all.=$userInfo[$i][0].",";   
                                               }
                                         
                                               $user_id_all=rtrim($user_id_all,',');  
		                                       $search_user_id="user_id in (".$user_id_all.")";

		                                       $wheredata[]=$search_user_id;

                                            }
				
												
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
					    
				                        $wheredata[]="status='1'";
                                      
									    $form_creator ->popArr['post']=$postArr;
		                                $form_creator ->popArr['billInfo']=$bill_obj->getAdvancePayments($wheredata);
										$form_creator ->formPath ='/templates/reports/advance_payment_cancellation_report.php';
                                           
											 break;

/*....... pharmacy invoice reports .......*/													
	 case 'pharmacy_invoice_report' : 
                                      $pharama_obj= new PharmaFunctions();
                                      $user_obj=new User();
                                      $db_function=new DBFunction();               
                    /*........... Date and Time ..........*/                  
                        if(!empty($postArr['from_date'])) 
                           {
								$from_time=date("H:i:s",strtotime($postArr['from_time']));
								
							    $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
							    

						    }
					    if(!empty($postArr['to_date'])) 
					        {
					        	$to_time=date("H:i:s",strtotime($postArr['to_time']));

                                $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
					        } 			    
				    /*.......... Customer Name ..........*/		    
						if(!empty($postArr['name'])) 
                            {
                                $wheredata[]="`cust_name` like '%".$postArr["name"]."%'";
                            } 
                    /*.......... Customer Type ..........*/		    
						if(!empty($postArr['type'])) 
                            {
                                $wheredata[]="cust_type ="."'".$postArr["type"]."'";
                            }   
                    /*.......... User ..........*/	        
                        if(!empty($postArr['user'])) 
                            {
                                $wheredata[]="user_id ="."'".$postArr["user"]."'";

                                 $postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");
                            } 
                    /*.......... Customer Type ..........*/	        
                        if(!empty($postArr['payment_type'])) 
                            {
                                $wheredata[]="payment_mode ="."'".$postArr["payment_type"]."'";
                            }
                         /*.......... ref no ..........*/	        
                        if(!empty($postArr['patient_id'])) 
                            {
                                $wheredata[]="(op_no='".$postArr["patient_id"]."' or ip_no='".$postArr["patient_id"]."')";
                            }
                         /*.......... bill no ..........*/	        
                        if(!empty($postArr['bill_no'])) 
                            {
                                $wheredata[]="id ="."'".$postArr["bill_no"]."'";
                            } 
              
                        if(empty($wheredata))
                            {  
							    $wheredata[]="bill_date >='".date("Y-m-d")." 00:00:00'";

							    $wheredata[]="bill_date <='".date("Y-m-d")." 23:59:59'";

                            }    

                        $wheredata[]="status =0";
                 
                        
                    /*.... pharmacy invoice users ....*/   
                        $pharmaInfo=$pharama_obj->getPharmaInvoice($wheredata);
                        
                    /*...... pharmacy user ......*/         
                           $user_type[]="(user_type='8' or user_type='9')"; 
                        $pharma_user=$user_obj->getUser('',$user_type);                 
		    
						      $form_creator ->popArr['user']=$pharma_user;
                              $form_creator ->popArr['post']=$postArr; 
                              $form_creator ->popArr['pharmaInfo']=$pharmaInfo;

	                          $form_creator ->formPath ='/templates/reports/invoice_report.php';    
                              break;
     case 'pharmacy_invoice_branchwise_report' :
                                      $pharama_obj= new PharmaFunctions();
                                      $user_obj=new User();
                                      $db_function=new DBFunction();               
                    /*........... Date and Time ..........*/                  
                        if(!empty($postArr['from_date'])) 
                           {
								$from_time=date("H:i:s",strtotime($postArr['from_time']));
								
							    $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
							    

						    }
					    if(!empty($postArr['to_date'])) 
					        {
					        	$to_time=date("H:i:s",strtotime($postArr['to_time']));

                                $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
					        } 			    
				    /*.......... Customer Name ..........*/		    
						if(!empty($postArr['name'])) 
                            {
                                $wheredata[]="`cust_name` like '%".$postArr["name"]."%'";
                            } 
                    /*.......... Customer Type ..........*/		    
						if(!empty($postArr['type'])) 
                            {
                                $wheredata[]="cust_type ="."'".$postArr["type"]."'";
                            }   
                    /*.......... User ..........*/	        
                        if(!empty($postArr['user'])) 
                            {
                                $wheredata[]="user_id ="."'".$postArr["user"]."'";

                                 $postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");
                            } 
                         /*.......... ref no ..........*/	        
                        if(!empty($postArr['patient_id'])) 
                            {
                                $wheredata[]="(op_no='".$postArr["patient_id"]."' or ip_no='".$postArr["patient_id"]."')";
                            }
                         /*.......... bill no ..........*/	        
                        if(!empty($postArr['bill_no'])) 
                            {
                                $wheredata[]="id ="."'".$postArr["bill_no"]."'";
                            } 
              
                        if(empty($wheredata))
                            {  
							    $wheredata[]="bill_date >='".date("Y-m-d")." 00:00:00'";

							    $wheredata[]="bill_date <='".date("Y-m-d")." 23:59:59'";

                            }    

                        $wheredata[]="`payment_mode` = 'BRANCH'";
                        $wheredata[]="status =0";
                 
                        
                    /*.... pharmacy invoice users ....*/   
                        $pharmaInfo=$pharama_obj->getPharmaInvoice($wheredata);
                        
                    /*...... pharmacy user ......*/         
                           $user_type[]="(user_type='8' or user_type='9')"; 
                        $pharma_user=$user_obj->getUser('',$user_type);                 
		    
						      $form_creator ->popArr['user']=$pharma_user;
                              $form_creator ->popArr['post']=$postArr; 
                              $form_creator ->popArr['pharmaInfo']=$pharmaInfo;

                                  $form_creator ->formPath ='/templates/reports/invoice_branchwise_report.php';
                              break;                          
     case 'pharmacy_invoice_itemwise_report' :
                                               $db_function=new DBFunction();
                                               $pharama_obj= new PharmaFunctions();

                        if(!empty($postArr['from_date'])) 
                            {
							    $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))."'";
						    }
					    if(!empty($postArr['to_date'])) 
					        {
                                $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
					        } 			    
				    /*.......... Brand ..........*/		    
						if(!empty($postArr['brand_ID'])) 
                            {
                                $brand_id=$postArr['brand_ID'];
                                
                                 $wheredata[]="item_id ="."'".$brand_id."'";
                            }       
                        if(empty($wheredata))
                            {  
							    $wheredata[]="bill_date >='".date("Y-m-d")."'";

							    $wheredata[]="bill_date <='".date("Y-m-d")."'";
                            }   
                          $distinct_items=array();
                        if(!empty($wheredata))
                            {	
                               $distinct_items=$pharama_obj->searchdistinct_item($wheredata);	
                            }

                        $itemInfo=array();
        if(!empty($distinct_items))
           {

               for($i=0;$i<count($distinct_items);$i++)
                   {

                    $item_id=$distinct_items[$i][0];
                    $search[0]="item_id = ".$item_id;
                    $search[1]=$wheredata[0];
                    $search[2]=$wheredata[1];

                    $pack=$pharama_obj->total_quantity_sold($search,"PACK");
                    $strip=$pharama_obj->total_quantity_sold($search,"STRIP");
                    $tablet=$pharama_obj->total_quantity_sold($search,"TABLET");
                    $pack +=$pharama_obj->total_quantity_sold($search,"NOS");

			
                    $total_qty=$db_function->convert_stock_format($item_id,2,'',$pack,$strip,$tablet);
                    $stock_conv=$db_function->convert_stock_format($item_id,1,$total_qty);
                    $total_quantity=$db_function->display_in_pack($stock_conv[0],$stock_conv[1],$stock_conv[2]);

                    $total_amount=$db_function->total_amount_sold($search);

             if($total_quantity > 0 ) 
                     {			
	                   $itemInfo[$i][0]=$distinct_items[$i][1];
	                   $itemInfo[$i][1]=$total_quantity;
	                   $itemInfo[$i][2]=$db_function->to_currency($total_amount);
	                   $itemInfo[$i][3]=$item_id;
                     }
                   }
            }    
                            
           
                        $form_creator ->popArr['post']=$postArr; 

                        $form_creator ->popArr['PharmaInvoiceItems']=$itemInfo; 

                        $form_creator ->formPath ='/templates/reports/invoice_itemwise.php'; 
                              break;
    case 'itemwise_detailed_report': 
                                     $db_function=new DBFunction();
                                     $pharama_obj= new PharmaFunctions();

                            $criteria[] = "item_id = ".$_GET['item_id'];

                            $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($_GET['from_date']))."'";

                            $criteria[] = "bill_date <= '".date("Y-m-d",strtotime($_GET['to_date']))."'";

                            $itemInfo=$pharama_obj->searchBillItems($criteria);

                            $data[]=$_GET['from_date'];
                            $data[]=$_GET['to_date'];
                            $data[]=$db_function->getidToValue("brand","id",$_GET['item_id'],"hcare_pharma_brand");
                            
                            $form_creator ->popArr['itemInfo']=$itemInfo; 

                            $form_creator ->popArr['data']=$data;

                            $form_creator ->formPath ='/templates/reports/itemwise_detailed_report.php';
                              break;
    case 'pharmacy_invoice_return_report': 
                                           $db_function=new DBFunction();
                                           $pharama_obj= new PharmaFunctions();

                        $from_date=$postArr['from_date'];
                        $to_date=$postArr['to_date'];
                          
                        if(!empty($from_date))
                            {
                               $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
                            }
                        else{
                               $criteria[] = "bill_date >= '".date("Y-m-d")."'";
                            }
                        if(!empty($to_date))
                            {
                               $criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
                            }
                        else{
                               $criteria[] = "bill_date <= '".date("Y-m-d")."'";
                            }
 
                        $criteria[] ="sales_mode ='Return'";
                        $criteria[] ="status =0";
                        
                            $itemInfo=$pharama_obj->searchBillItems($criteria); 
                          
                            $form_creator ->popArr['itemInfo']=$itemInfo;

                            $form_creator ->popArr['post']=$postArr;

                            $form_creator ->formPath ='/templates/reports/invoice_return.php';
                              break;   
    case 'pharmacy_credit_payment_report': 
                                           $pharama_obj= new PharmaFunctions();
                             /*........... Date and Time ..........*/                  
                        if(!empty($postArr['from_date'])) 
                           {
								$from_date=date("Y-m-d",strtotime($postArr['from_date']));
							    if(!empty($postArr['from_time']))	
							        {
							          $from_time=date("H:i:s",strtotime($postArr['from_time']));
							          $wheredata[]="date >='".$from_date." ".$from_time."'";
							        }

							    else{
                                      $wheredata[]="date >='".$from_date." 00:00:00'";
							        }

						    }
					    if(!empty($postArr['to_date'])) 
                           {
								$to_date=date("Y-m-d",strtotime($postArr['to_date']));
							    if(!empty($postArr['to_time']))	
							        {
							          $to_time=date("H:i:s",strtotime($postArr['to_time']));
							          $wheredata[]="date <='".date("Y-m-d",strtotime($to_date))." ".$to_time."'";
							        }

							    else{
                                      $wheredata[]="date <='".date("Y-m-d",strtotime($to_date))." 23:59:59'";
							        }

						    }
						if(!empty($postArr['bill_no'])) 
                            {
                           	    $wheredata[]="bill_no ="."'".$postArr["bill_no"]."'";      
                            }
                        if($postArr['bill_status']=='0') 
                            {
                           	    $wheredata[]="status ="."'".$postArr["bill_status"]."'";  
                            }
                        if($postArr['bill_status']=='1') 
                            {
                           	    $wheredata[]="status ="."'".$postArr["bill_status"]."'";  
                            }             
						if(empty($wheredata))
                            {  
							    $wheredata[]="date >='".date("Y-m-d")." 00:00:00'";

							    $wheredata[]="date <='".date("Y-m-d")." 23:59:59'";

							     $wheredata[]="status ='0'";

                            }  

                            $billInfo= $pharama_obj->InvoiceCreditPayment($wheredata);
                            // var_dump($billInfo);
                            $form_creator ->popArr['post']=$postArr;

                            $form_creator ->popArr['billInfo']=$billInfo;

                            $form_creator ->formPath ='/templates/reports/invoice_credit_payment_report.php';

                              break;  
    case 'pharmacy_discount_report': 
                                      $pharama_obj= new PharmaFunctions();
                                      $user_obj=new User();
                                      $db_function=new DBFunction();               
                    /*........... Date and Time ..........*/                  
                        if(!empty($postArr['from_date'])) 
                           {
								$from_time=date("H:i:s",strtotime($postArr['from_time']));
								
							    $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
							    

						    }
					    if(!empty($postArr['to_date'])) 
					        {
					        	$to_time=date("H:i:s",strtotime($postArr['to_time']));

                                $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";
					        } 			    
				    /*.......... Customer Name ..........*/		    
						if(!empty($postArr['name'])) 
                            {
                                $wheredata[]="`cust_name` like '%".$postArr["name"]."%'";
                            } 
                    /*.......... Customer Type ..........*/		    
						if(!empty($postArr['type'])) 
                            {
                                $wheredata[]="cust_type ="."'".$postArr["type"]."'";
                            }   
                    /*.......... User ..........*/	        
                        if(!empty($postArr['user'])) 
                            {
                                $wheredata[]="user_id ="."'".$postArr["user"]."'";

                                 $postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");
                            } 
                    /*.......... Customer Type ..........*/	        
                        if(!empty($postArr['payment_type'])) 
                            {
                                $wheredata[]="payment_mode ="."'".$postArr["payment_type"]."'";
                            }
                         /*.......... ref no ..........*/	        
                        if(!empty($postArr['patient_id'])) 
                            {
                                $wheredata[]="(op_no='".$postArr["patient_id"]."' or ip_no='".$postArr["patient_id"]."')";
                            }
                         /*.......... bill no ..........*/	        
                        if(!empty($postArr['bill_no'])) 
                            {
                                $wheredata[]="id ="."'".$postArr["bill_no"]."'";
                            } 
              
                        if(empty($wheredata))
                            {  
							    $wheredata[]="bill_date >='".date("Y-m-d")." 00:00:00'";

							    $wheredata[]="bill_date <='".date("Y-m-d")." 23:59:59'";

                            }    
                      
                        $wheredata[] ="discount_type != ''";
                        $wheredata[]="status =0";
                 
                        
                    /*.... pharmacy invoice users ....*/   
                        $pharmaInfo=$pharama_obj->getPharmaInvoice($wheredata);
                        
                    /*...... pharmacy user ......*/         
                           $user_type[]="(user_type='8' or user_type='9')"; 
                        $pharma_user=$user_obj->getUser('',$user_type);                 
		    
						      $form_creator ->popArr['user']=$pharma_user;
                              $form_creator ->popArr['post']=$postArr; 
                              $form_creator ->popArr['pharmaInfo']=$pharmaInfo;

                            $form_creator ->formPath ='/templates/reports/invoice_discount_report.php'; 
                              break; 
/*....... end of pharmacy invoice reports .......*/

/*....... pharmacy receivings reports .......*/
    case 'pharmacy_receivings_report': 
                                        
                                        $db_function=new DBFunction();
                                        $pharama_obj= new PharmaFunctions();

                    if(!empty($postArr['from_date'])) 
                            {
							   $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))."'";
						    }	    
					if(!empty($postArr['to_date'])) 
					        {
                               $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
					        }        			    
				    /*.......... supplier ..........*/		    
					if(!empty($postArr['supplier'])) 
                            {  
                               $wheredata[]="supplier ="."'".$postArr['supplier']."'";
                            }   
                    /*.......... bill no ..........*/		    
					if(!empty($postArr['bill_no'])) 
                            {  
                               $wheredata[]="bill_no ="."'".$postArr['bill_no']."'";
                            }
                    /*.......... po no ..........*/		    
					if(!empty($postArr['po_no'])) 
                            {  
                               $wheredata[]="pono ="."'".$postArr['po_no']."'";
                            } 
                    /*.......... payment type ..........*/		    
					if(!empty($postArr['payment_type'])) 
                            {  
                               $wheredata[]="payment_mode ="."'".$postArr['payment_type']."'";
                            }                            
                    if(empty($wheredata))
                            {  
							   $wheredata[]="bill_date >='".date("Y-m-d")."'";

							   $wheredata[]="bill_date <='".date("Y-m-d")."'";
                            }  
                  
                  $wheredata[]="status =0";

                  $pharmaInfo=$pharama_obj->getPharmaReceivings($wheredata);

                  $postArr['supplier_name']=$db_function->getidToValue("supplier_name","id",$postArr['supplier'],"hcare_pharma_suppliers");

                            $supplier=$pharama_obj->getPharmaSupplier();

                            $form_creator ->popArr['supplier']=$supplier; 

                            $form_creator ->popArr['post']=$postArr; 

                            $form_creator ->popArr['pharmaInfo']=$pharmaInfo;

                            $form_creator ->formPath ='/templates/reports/receivings_report.php';
                              break;  
case 'pharmacy_receivings_itemwise_report': 
                                        $db_function=new DBFunction();
                                        $pharama_obj= new PharmaFunctions();

                        if(!empty($postArr['from_date'])) 
                            {
							    $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))."'";
						    }
					    if(!empty($postArr['to_date'])) 
					        {
                                $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
					        } 			    
				    /*.......... Brand ..........*/		    
						if(!empty($postArr['brand_ID'])) 
                            {
                                $brand_id=$postArr['brand_ID'];
                                
                                 $wheredata[]="item_id ="."'".$brand_id."'";
                            }       
                        if(empty($wheredata))
                            {  
							    $wheredata[]="bill_date >='".date("Y-m-d")."'";

							    $wheredata[]="bill_date <='".date("Y-m-d")."'";
                            }

                                $wheredata[] = "status = 0"; 

             $distinct_items=$pharama_obj->searchdistinct_item_receivings($wheredata);
             
             $itemInfo=array();
        if(!empty($distinct_items))
           {
              
               for($i=0;$i<count($distinct_items);$i++)
                   {

                    $item_id=$distinct_items[$i][0];
                    $search[0]="item_id = ".$item_id;
                    $search[1]=$wheredata[0];
                    $search[2]=$wheredata[1];

               $pack=$pharama_obj->total_quantity_sold_receivings($search,"PACK");
               $strip=$pharama_obj->total_quantity_sold_receivings($search,"STRIP");
               $tablet=$pharama_obj->total_quantity_sold_receivings($search,"TABLET");
               $pack +=$pharama_obj->total_quantity_sold_receivings($search,"NOS");
			
                    $total_qty=$db_function->convert_stock_format($item_id,2,'',$pack,$strip,$tablet);
                    $stock_conv=$db_function->convert_stock_format($item_id,1,$total_qty);
                    $total_quantity=$db_function->display_in_pack($stock_conv[0],$stock_conv[1],$stock_conv[2]);

                    $total_amount=$db_function->total_amount_sold_receivings($search);
               

	                   $itemInfo[$i][0]=$distinct_items[$i][1];
	                   $itemInfo[$i][1]=$total_quantity;
	                   $itemInfo[$i][2]=$db_function->to_currency($total_amount);
	                   $itemInfo[$i][3]=$item_id;
                     
                   }
            }    
                            
           
                        $form_creator ->popArr['post']=$postArr; 

                        $form_creator ->popArr['PharmaReceivingsItems']=$itemInfo; 
                              $form_creator ->formPath ='/templates/reports/receivings_itemwise.php';
                              break; 
case 'receivings_itemwise_detailed_report':
                                            $db_function=new DBFunction();
                                            $pharama_obj= new PharmaFunctions();

                            $criteria[] = "item_id = ".$_GET['item_id'];

                            $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($_GET['from_date']))."'";

                            $criteria[] = "bill_date <= '".date("Y-m-d",strtotime($_GET['to_date']))."'";

                            $criteria[] = "status = 0";

                            $itemInfo=$pharama_obj->searchBillItems_Receivings($criteria);

                            $data[]=$_GET['from_date'];
                            $data[]=$_GET['to_date'];
                            $data[]=$db_function->getidToValue("brand","id",$_GET['item_id'],"hcare_pharma_brand");
                            
                            $form_creator ->popArr['itemInfo']=$itemInfo; 

                            $form_creator ->popArr['data']=$data;
                        
                        $form_creator ->formPath ='/templates/reports/itemwise_receivings_detailed_report.php';
                              break;
case 'pharmacy_receivings_return_report':
                                          $db_function=new DBFunction();
                                          $pharama_obj= new PharmaFunctions();

                        $from_date=$postArr['from_date'];
                        $to_date=$postArr['to_date'];
                          
                        if(!empty($from_date))
                            {
                               $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
                            }
                        else{
                               $criteria[] = "bill_date >= '".date("Y-m-d")."'";
                            }
                        if(!empty($to_date))
                            {
                               $criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
                            }
                        else{
                               $criteria[] = "bill_date <= '".date("Y-m-d")."'";
                            }
 
                        $criteria[] ="purchase_mode ='Return'";
                        $criteria[] ="status =0";
                        
                            $itemInfo=$pharama_obj->searchBillItems_Receivings($criteria); 
                          
                            $form_creator ->popArr['itemInfo']=$itemInfo;

                            $form_creator ->popArr['post']=$postArr;

                        $form_creator ->formPath ='/templates/reports/receivings_return.php';      
                              break; 
case 'pharmacy_receivings_report_supplier':
                                           
                                            $db_function=new DBFunction();
                                            $pharama_obj= new PharmaFunctions();

                    if(!empty($postArr['from_date'])) 
                            {
							   $wheredata[]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))."'";
						    }	    
					if(!empty($postArr['to_date'])) 
					        {
                               $wheredata[]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))."'";
					        }        			    
				    /*.......... supplier ..........*/		    
					if(!empty($postArr['supplier'])) 
                            {  
                               $wheredata[]="supplier ="."'".$postArr['supplier']."'";
                            }  

                    if(empty($wheredata))
                            {  
							   $wheredata[]="bill_date >='".date("Y-m-d")."'";

							   $wheredata[]="bill_date <='".date("Y-m-d")."'";
                            }          

                    $wheredata[]="status =0";

                  $pharmaInfo=$pharama_obj->getPharmaReceivings($wheredata);

                  $postArr['supplier_name']=$db_function->getidToValue("supplier_name","id",$postArr['supplier'],"hcare_pharma_suppliers");

                            $supplier=$pharama_obj->getPharmaSupplier();

                            $form_creator ->popArr['supplier']=$supplier; 

                            $form_creator ->popArr['post']=$postArr; 

                            $form_creator ->popArr['pharmaInfo']=$pharmaInfo;

                        $form_creator ->formPath ='/templates/reports/receivings_report_supplier.php';  
                              break;



				case 'observation_payment_report' :
								                $bill_obj=new Billing();
										        $user_obj=new User();
										        $db_function=new DBFunction();
										        $k=0;



										if(!empty($postArr['from_time'])){
                                            $from_time=date("H:i:s",strtotime($postArr['from_time']));
										    $to_time=date("H:i:s",strtotime($postArr['to_time']));
										}else{
											
											$from_time="00:00:00";
										    $to_time="23:59:59";
										}


										if(!empty($postArr['from_date'])) {
										
											$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
											$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))."  ".$to_time."'";
										}else{
											$wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
											$wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
										}
										if(!empty($postArr['billno'])) {
											$wheredata[$k++]="id ='".$postArr['billno']."'";
										}													

										if(!empty($postArr['opno'])) {
											$wheredata[$k++]="opno ='".$postArr['opno']."'";
											
										}


                                        $user_data=array();
                                        //USER TYPE RESTRICTION





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
                                $postArr['user_type']=$db_function->getidToValue("user_type","id",$postArr['user_type'],"hcare_user_type");
											
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								// var_dump($postArr);
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_type_array=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								// var_dump($user_type_array);
								if(!empty($user_id)) $wheredata[$k++]= "user_id in $user_id";


								$form_creator ->popArr['billInfo']=$bill_obj->getObservationBillInfo($wheredata);
										$form_creator ->formPath ='/templates/reports/observation_payment_report.php';
										break;

			    case 'doctor_medicine_report':

                                    $rep_obj=new Report();
									$com_obj = new CommonFunctions();
									$db_function=new DBFunction();
									$emp_obj= new Employee();
									 
									if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
									
									$selectCondition[]="a.`bill_date`>='".$fromdate."  00:00:00'";
									$selectCondition[]="a.`bill_date`<='".$todate." 23:59:59'";

                                    $is_field[0]="a.title='Dr'";
									
									if(!empty($postArr['doctor'])){

			                          $is_field[1]="a.`id`='".$postArr["doctor"]."'";
									  $selectCondition[]="a.`doc_id`='".$postArr["doctor"]."'";

									  $postArr['doctor_name']=$db_function->getidToValue("title","id",$postArr['doctor'],"hcare_emp_info").".".$db_function->getidToValue("first_name","id",$postArr['doctor'],"hcare_emp_info")." ".$db_function->getidToValue("last_name","id",$postArr['doctor'],"hcare_emp_info");

									}


									$form_creator ->popArr['medicine_list']=$rep_obj->getMedicineDoctorWise($selectCondition);
									 	
									$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
						
									$form_creator ->popArr['post']=$postArr;

		                            $form_creator ->formPath ='/templates/reports/doctor_medicine_report.php';
										break;




case 'download_pdf'     :

						if (!empty($postArr['page_name'])) {

							
							if ($postArr['page_name']=="daily_collection") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("daily_collection",$postArr);

								$form_creator ->formPath ='/templates/reports/daily_collection.php';


							}
							else if ($postArr['page_name']=="bill_collection_all_user") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("bill_collection_all_user",$postArr);

								$form_creator ->formPath ='/templates/reports/bill_collection_user.php';


							}
							else if ($postArr['page_name']=="patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/patient_report.php';


							}
							else if ($postArr['page_name']=="free_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("free_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/free_patient_report.php';


							}
							else if ($postArr['page_name']=="bill_collection") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("bill_collection",$postArr);

								$form_creator ->formPath ='/templates/reports/bill_collection.php';


							}
							else if ($postArr['page_name']=="detailed_bill_collection_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("detailed_bill_collection_report",$postArr);

								$form_creator ->formPath ='/templates/reports/detailed_bill_collection_report.php';


							}
							else if ($postArr['page_name']=="booking_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("Booking_Report",$postArr);

								$form_creator ->formPath ='/templates/reports/booking_report.php';


							}
							else if ($postArr['page_name']=="doctor_consolidated") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_consolidated",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_consolidate.php';


							}
							else if ($postArr['page_name']=="doctor_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_report.php';


							}
							else if ($postArr['page_name']=="doctor_procedure_report_consolidated") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_procedure_report_consolidated",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_procedure_report_consolidated.php';


							}
							else if ($postArr['page_name']=="doctor_procedure_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_procedure_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_procedure_report.php';


							}
							else if ($postArr['page_name']=="doctor_ip_visit_consolidated") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_ip_visit_consolidated",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_ip_visit_consolidate.php';


							}
							else if ($postArr['page_name']=="doctor_ip_visit_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_ip_visit_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_ip_visit_report.php';


							}
							else if ($postArr['page_name']=="op_card_issued") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("op_card_issued",$postArr);

								$form_creator ->formPath ='/templates/reports/op_card_issued_report.php';


							}
							else if ($postArr['page_name']=="age_gender_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("age_gender_report",$postArr);

								$form_creator ->formPath ='/templates/reports/age_gender_report.php';


							}
							else if ($postArr['page_name']=="cancelled_op") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("cancelled_op",$postArr);

								$form_creator ->formPath ='/templates/reports/cancelled_op_report.php';


							}
							else if ($postArr['page_name']=="op_patients_categorywise") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("op_patient_categorywise",$postArr);

								$form_creator ->formPath ='/templates/reports/op_patient_categorywise_report.php';


							}
							else if ($postArr['page_name']=="admitted_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("admitted_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/admitted_patient_report.php';


							}
							else if ($postArr['page_name']=="agewise_ip_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("agewise_ip_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_age_gender_report.php';


							}
							else if ($postArr['page_name']=="ip_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_patient_report.php';


							}
 							else if ($postArr['page_name']=="ip_insurance_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_insurance_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_insurance_patient_report.php';


							}
 							else if ($postArr['page_name']=="ip_patient_category_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_patient_category_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_patient_category_report.php';


							}
 							else if ($postArr['page_name']=="discharged_patient_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("discharged_patient_report",$postArr);

								$form_creator ->formPath ='/templates/reports/discharged_patient_report.php';


							}
							else if ($postArr['page_name']=="advance_payment_cancellation_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("advance_payment_cancellation_report",$postArr);

								$form_creator ->formPath ='/templates/reports/advance_payment_cancellation_report.php';


							}
 							else if ($postArr['page_name']=="bill_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("bill_report",$postArr);

								$form_creator ->formPath ='/templates/reports/billing_report.php';


							}
 							else if ($postArr['page_name']=="bill_report_item_details") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("bill_report_item_details",$postArr);

								$form_creator ->formPath ='/templates/reports/billing_report_item_details.php';


							}
 							else if ($postArr['page_name']=="itemwise_bill_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("itemwise_bill_report",$postArr);

								$form_creator ->formPath ='/templates/reports/itemwise_bill_report.php';


							}
 							else if ($postArr['page_name']=="itemwise_conso_bill_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("itemwise_conso_bill_report",$postArr);

								$form_creator ->formPath ='/templates/reports/billing_report_conso_items.php';


							}
 							else if ($postArr['page_name']=="credit_payment") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("credit_payment",$postArr);

								$form_creator ->formPath ='/templates/reports/credit_payment_report.php';


							}
 							else if ($postArr['page_name']=="ip_payment_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_payment_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_payment_report.php';


							}
 							else if ($postArr['page_name']=="ip_payment_discount_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_payment_discount_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_payment_discount_report.php';


							}
 							else if ($postArr['page_name']=="ip_payment_report_itemwise") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_payment_report_itemwise",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_payments_item_report.php';


							}
 							else if ($postArr['page_name']=="ip_credit_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_credit_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_credit_report.php';


							}
 							else if ($postArr['page_name']=="ip_payments_cancelled") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_payments_cancelled",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_payments_cancelled.php';


							}
 							else if ($postArr['page_name']=="ip_advance_payments_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("ip_advance_payments_report",$postArr);

								$form_creator ->formPath ='/templates/reports/ip_advance_payments_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_invoice_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_invoice_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_invoice_branchwise_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_invoice_branchwise_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_branchwise_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_invoice_itemwise_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_invoice_itemwise_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_itemwise.php';


							}
 							else if ($postArr['page_name']=="pharmacy_invoice_return_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_invoice_return_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_return.php';


							}
 							else if ($postArr['page_name']=="pharmacy_credit_payment_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_credit_payment_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_credit_payment_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_discount_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_discount_report",$postArr);

								$form_creator ->formPath ='/templates/reports/invoice_discount_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_receivings_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_receivings_report",$postArr);

								$form_creator ->formPath ='/templates/reports/receivings_report.php';


							}
 							else if ($postArr['page_name']=="pharmacy_receivings_itemwise_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_receivings_itemwise_report",$postArr);

								$form_creator ->formPath ='/templates/reports/receivings_itemwise.php';


							}
 							else if ($postArr['page_name']=="pharmacy_receivings_return_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_receivings_return_report",$postArr);

								$form_creator ->formPath ='/templates/reports/receivings_return.php';


							}
 							else if ($postArr['page_name']=="pharmacy_receivings_report_supplier") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("pharmacy_receivings_report_supplier",$postArr);

								$form_creator ->formPath ='/templates/reports/receivings_report_supplier.php';


							}
 							else if ($postArr['page_name']=="doctor_op_payments") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_op_payments",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_op_payments.php';


							}
 							else if ($postArr['page_name']=="doctor_op_payment_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_op_payment_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_op_payment_report.php';


							}
					else if ($postArr['page_name']=="observation_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("observation_report",$postArr);

								$form_creator ->formPath ='/templates/reports/observation_report.php';


							}
					else if ($postArr['page_name']=="observation_payment_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("observation_payment_report",$postArr);

								$form_creator ->formPath ='/templates/reports/observation_payment_report.php';


							}
					else if ($postArr['page_name']=="doctor_medicine_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctor_medicine_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctor_medicine_report.php';


							}
		                else if ($postArr['page_name']=="doctors_collection_report") {


								$postArr['pdf'] = "pdf";

								$form_creator ->popArr['post']=$postArr;

								$this->viewPage("doctors_collection_report",$postArr);

								$form_creator ->formPath ='/templates/reports/doctors_collection_report.php';


							}



						}

						// $this->viewPage("daily_collection",$postArr);
	 					break;
case 'doctor_op_payments':
                                           
		                           $emp_obj= new Employee();
								   $com_obj = new CommonFunctions();
								   $rep_obj=new Report();
								   
								   if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
								   
								   $is_field[0]="a.title='Dr'";		
								   
								   if(!empty($postArr["doctor"])){
											$is_field[1]="a.`id`='".$postArr["doctor"]."'";
											$doc_id = $postArr["doctor"];
									}											
									$doctors=$emp_obj->getEmployee($is_field);											
									$arrList=array();
									$j=0;
									if(count($doctors) >0 ){
									
									  for($i=0;$i<count($doctors);$i++){

									  	if (!empty($doc_id)) {

									  		$doctorInfo = $rep_obj->getOpDocPayments($fromdate,$todate,$doc_id);
									  	}
									  	else{
									  		$doctorInfo = $rep_obj->getOpDocPayments($fromdate,$todate,$doctors[$i][0]);
									  	}



										if($doctorInfo[0] >0 ) {
										
												$arrList[$j][0]=$doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];
												$arrList[$j][1]=$doctorInfo[0];
												$arrList[$j][2]=$doctors[$i][0];

												$j++;
										}



										
									  }
									
									}

									$form_creator ->popArr['post']=$postArr;
									$form_creator ->popArr['doctorInfo']=$arrList;

									$is_field[0]="a.title='Dr'";													
									$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);

                        $form_creator ->formPath ='/templates/reports/doctor_op_payments.php';  
                              break;

		case 'doctor_op_payment_report'  :

									 $rep_obj=new Report();
									 $reg_obj= new Registration();
									 $com_obj = new CommonFunctions();
									 $emp_obj= new Employee();
									 
									 if(isset($postArr['from_date'])){
								
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date']);
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date']);
									}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d");
										$todate=$com_obj->getcurrentDate("Y-m-d");
									}
									
									$selectCondition[]="`visit_date`>='".$fromdate."'";
									$selectCondition[]="`visit_date`<='".$todate."'";
									
									if(!empty($postArr['doctor'])){
									$docid=$postArr['doctor'];
									 $selectCondition[]="`doc_id`='".$docid."'";
									}

									if(!empty($getArr['docid'])){
									$postArr['doctor']=$docid=$getArr['docid'];
									 $selectCondition[]="`doc_id`='".$docid."'";
									 // $getArr['docid']=$postArr['doctor'];
									}
									
									$selectCondition[]="`status`=0";
									 $is_field[0]="a.title='Dr'";	
									 $form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);
									// $form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
									 $form_creator ->popArr['doctorInfo']= $doctorInfo = $rep_obj->getOpDocPaymentsDetailed($selectCondition);

									$form_creator ->popArr['post']=$postArr;	

	                            $form_creator ->formPath ='/templates/reports/doctor_op_payment_report.php';
								break;


		case 'observation_report' :	$com_obj = new CommonFunctions();
											$reg_obj= new Registration();
											$emp_obj= new Employee();
											$user_obj=new User();
								            $db_function=new DBFunction();
								            $bill_obj = new Billing();
								
											
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
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate()." ".$from_time;
												$postArr['to_date']=$todate=$com_obj->getcurrentDate()." ".$to_time;
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`visit_date`>='".$fromdate."'";
								$selectCondition[]="b.`visit_date`<='".$todate."'";
								$selectCondition[]="b.`cancelled`=0";	

								$selectCondition[]="(b.`observation`='YES' or b.`observation`='DISCHARGED') ";
								// var_dump($selectCondition);
								// $selectCondition[]="b.`visit_date` like '%".date("Y-m-d")."%'";
																		
								$form_creator ->popArr['patient_info']=$p_info = $reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
								// var_dump($p_info);


								//bill details of observation
								for($i = 0;$i<sizeof($p_info);$i++){
									$where  = array();
									$where[] = "visit_id ='".$p_info[$i][13]."'";
									$popAmt[$i] = $bill_obj ->getObservationBillInfo($where);
									$popAmt[$i] = $popAmt[$i][0][10]+$popAmt[$i][0][11]+$popAmt[$i][0][12];
								}								
								$form_creator ->popArr['Amount'] = $popAmt;
											
								 if($postArr['action']!="CLEAR"){
									$form_creator ->popArr['post']=$postArr;
								}else $form_creator ->popArr['post']='';
											
								$is_field[0]="a.title='Dr'";													
								$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  
											
								$form_creator ->formPath ='/templates/reports/observation_report.php';
											break;


		case 'doctors_collection_report' : 

								$com_obj = new CommonFunctions();
								$reg_obj= new Registration();
								$emp_obj= new Employee();
								$user_obj=new User();
								$db_function=new DBFunction();
								$bill_obj=new Billing();
								$ip_obj=new Inpatient();
								$pharama_obj=new PharmaFunctions();
											
								$is_field[0]="a.title='Dr'";		
								   
								if(!empty($postArr["doctor"])){
									// $is_field[1]="a.`id`='".$postArr["doctor"]."'";
									$doctor_selected = $postArr['doctor'];
								}

								$doctors=$emp_obj->getEmployee($is_field);		


								if (!empty($postArr['doctor'])) {

									if (!empty($postArr['from_date'])) {
										$from_date = date("Y-m-d",strtotime($postArr['from_date']));
									}
									else{
										$from_date = date("Y-m-d");
										$postArr['from_date'] = date("d-m-Y",strtotime($from_date));
									}

									if (!empty($postArr['to_date'])) {
										$to_date = date("Y-m-d",strtotime($postArr['to_date']));
									}
									else{
										$to_date = date("Y-m-d");
										$postArr['to_date'] = date("d-m-Y",strtotime($to_date));
									}
									
									$data = array();

									$doc_id = $postArr['doctor'];

									// 1. Lab bill items

									$data['lab'] = $bill_obj->getDocPrescribedLab($doc_id,$from_date,$to_date);

									// 2. Procedure bill items

									$data['procedure'] = $bill_obj->getDocPrescribedProcedure($doc_id,$from_date,$to_date);

									// 3. X-ray bill items

									$data['xray'] = $bill_obj->getDocPrescribedXray($doc_id,$from_date,$to_date);

									// 4. OP Registration

									$data['registration'] = $reg_obj->getDocReg($doc_id,$from_date,$to_date);

									// 5. IP DIscharge

									// $data['ip_discharge'] = $ip_obj->getDocIpDischarge($doc_id,$from_date,$to_date);

                                   $selectCondition[]="b.`discharge_date`>='".$from_date."'";
							       $selectCondition[]="b.`discharge_date`<='".$to_date."'";
								   $selectCondition[]="(b.`discharge_date`!='0000-00-00' OR b.`discharge_date` is NOT NULL)";
							       $selectCondition[]="b.`cancelled`=0";
							       $selectCondition[]="b.`doc_id`='".$doc_id."'";
							       $patientInfo=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');

                                   $ipbillInfo=array();

                                    if(!empty($patientInfo)){
                                    	$ip_id=array();
                                    	for ($i=0; $i <count($patientInfo) ; $i++) { 
                                    		$ip_id[]=$patientInfo[$i][13];
                                    	}

                                    	$ip_id = "(".implode(",", $ip_id).")";

                                    	$data['ip_discharge'] = $ip_obj->getDocIpDischarge($ip_id);
                                    	// var_dump($data['ip_discharge']);

                                    }

									// 6. Pharmacy Collection

									$data['pharmacy'] = $pharama_obj->getPharmaInvoiceAmount($doc_id,$from_date,$to_date);		                                        
                                   												

								}


								$form_creator ->popArr['doctors']=$doctors;

								if (!empty($postArr['doctor'])) {

										$is_field[1]="a.`id`='".$postArr["doctor"]."'";

										$doctors=$emp_obj->getEmployee($is_field);

										$data['doctor_name'] = $doctors[0][1]." ".$doctors[0][2]." ".$doctors[0][3];

										// var_dump($data['doctor_name']);

								}

								$form_creator ->popArr['data']=$data;

								$form_creator ->popArr['doctor_selected']=$doctor_selected;

								$form_creator ->popArr['post']=$postArr;

								$form_creator ->formPath ='/templates/reports/doctors_collection_report.php';
											break;

		case 'profit_report': 
		                                    $rep_obj=new Report();
								            $com_obj = new CommonFunctions();
								            $user_obj=new User();
								            $db_function=new DBFunction();

		                        if(isset($postArr['from_date'])){
								
								      if(!empty($postArr['from_time'])){
                                        $from_time=date("H:i:s",strtotime($postArr['from_time']));
										$to_time=date("H:i:s",strtotime($postArr['to_time']));
									   												  
										$fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." ".$from_time;
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." ".$to_time;;
									 }else{
									 
									   $fromdate=$com_obj->getcurrentDate("Y-m-d",$postArr['from_date'])." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d",$postArr['to_date'])." 23:59:59";
									 }
								}else{
										$fromdate=$com_obj->getcurrentDate("Y-m-d")." 00:00:00";
										$todate=$com_obj->getcurrentDate("Y-m-d")." 23:59:59";
										
										$postArr['from_date']=$com_obj->getcurrentDate("d-m-Y");
										$postArr['to_date']=$com_obj->getcurrentDate("d-m-Y");
								}
								
								$user_type_info=array();
								$user_type_logged_in=$_SESSION['user_type'];
								$user_type_id=$_SESSION['user_type_id'];
								$user_id=$_SESSION['user_id'];

										
								if($user_type_logged_in !='ADMIN' && $user_type_logged_in !='ADMIN+DOCTOR' && $user_type_logged_in !='LAB ADMIN'){
								       $user_type_info[]="id='".$user_type_id."'"; 
									   $user_data[]="id='".$user_id."'"; 
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_type_info[]="id='6' or id='7'"; 
									  
								}
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
		 
		 
		                        if(!empty($postArr['user_type'])) {
											
									$user_data[]="user_type='".$postArr['user_type']."'";
									$postArr['user_type_name']=$db_function->getidToValue("user_type","id",$postArr['user_type'],"hcare_user_type");
									
								}else if($user_type_logged_in =='LAB ADMIN' ){
								
								       $user_data[]="user_type='6' or user_type='7'"; 
									  
								}
								   $alldata="all";
		                           $userInfo=$user_obj->getUser('',$user_data,'','',$alldata);
                                   
								   $collectionInfo=array();
								   $user_id=array();
								   $k=0;
								if(!empty($userInfo))
								    {
										   for($i=0;$i<count($userInfo);$i++){
                                            $user_id[]=$userInfo[$i][0];
                                          
											   // $collectionInfo[$k][0]=$userInfo[$i][1];
											   // $collectionInfo[$k][1]=$userInfo[$i][3];
											  
											   $k++;
										
											}
											for($i=0;$i<count($user_id);$i++)
											   {   
											   	 $test.=$user_id[$i].",";   
											   }
							  if(!empty($postArr['user']))
								    {
									       $test_user_id="(".$postArr['user'].")";

									    	$postArr['user_name']=$db_function->getidToValue("user_name","id",$postArr['user'],"hcare_users");
                        /*.......Employee name......*/
									   $title=$db_function->getidToValue("title","id",$postArr['user'],"hcare_emp_info");

									   $first_name=$db_function->getidToValue("first_name","id",$postArr['user'],"hcare_emp_info");

							           $last_name=$db_function->getidToValue("last_name","id",$postArr['user'],"hcare_emp_info");

							$postArr['emp_name']=$title.".".$first_name." ".$last_name;

							        }
							    else{    		   
											$test=rtrim($test,',');  
											$test_user_id="(".$test.")";
								    }		
                                       // var_dump($test_user_id);    
											$dailyInfo=$rep_obj->detailed_bill_collection($fromdate,$todate,$test_user_id);   
											   
				
                                    }
                                   
                                   
                                  $form_creator ->popArr['user']=$user_obj->getUser('',$user_data); 

                                  $form_creator ->popArr['post']=$postArr;													
								  // $form_creator ->popArr['info']=$collectionInfo;

								  $form_creator ->popArr['profit_per']=$db_function->getidToValue("profit_per","id",1,"hcare_hospital_info");

								  $form_creator ->popArr['daily_collection']=$dailyInfo;

								    $form_creator ->formPath ='/templates/reports/profit_report.php';
		                        break; 

		case 'patient_report_not_paid' :	$com_obj = new CommonFunctions();
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
												$postArr['from_date']=$fromdate=$com_obj->getcurrentDate()." ".$from_time;
												$postArr['to_date']=$todate=$com_obj->getcurrentDate()." ".$to_time;
											}
											
											if(!empty($postArr["health_checkup"])){
													$selectCondition[]="b.`health_checkup`='YES'";
											}


											if(isset($postArr["paid_status"])){
												$selectCondition[]="b.`payment_status`='".$postArr["paid_status"]."'";
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
									if(empty($postArr['user'])){
										
										$user_id="($_SESSION[user_id])";
										$user_data[]="user_type='".$user_type_id."'";
										$postArr['user']=$_SESSION['user_id'];
										
									}
								}
								
								$form_creator ->popArr['post']=$postArr;
								$form_creator ->popArr['user_type']=$user_obj->getUsertype($user_type_info);
								$form_creator ->popArr['user']=$user_obj->getUser('',$user_data);
								
								if(!empty($user_id)) $selectCondition[]= "b.user_id in $user_id";
								
								$selectCondition[]="b.`visit_date`>='".$fromdate."'";
								$selectCondition[]="b.`visit_date`<='".$todate."'";;
								$selectCondition[]="b.`cancelled`=0";											
								$form_creator ->popArr['patient_info']=$reg_obj->getOPPatientInfo('',$selectCondition,'b.visit_date','asc');
								
											
								 if($postArr['action']!="CLEAR"){
									$form_creator ->popArr['post']=$postArr;
								}else $form_creator ->popArr['post']='';
											
								$is_field[0]="a.title='Dr'";													
								$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);  
											
								$form_creator ->formPath ='/templates/reports/patient_report_not_paid.php';

}

$form_creator->display();

}

public function getitemwise_bill_report($postArr){

$bill_obj=new Billing();
$db_function =new DBFunction();
$comm_obj= new CommonFunctions();

$item=$postArr['particulars'];

if(!empty($postArr['particulars'])){
$pInfo=explode(" -",$postArr['particulars_ID']);

$ptype=$pInfo[0];
$pid=$pInfo[1];
$amount=0;
if($ptype =="LE" || $ptype=="LT") $wheredata[]="(a.`type` = 'L' or a.`type`='".$ptype."')";
else $wheredata[]="a.`type`='".$ptype."'";

    if($ptype =="LE") $wheredata[]="a.`test_type` = 0";

if($ptype == "L"){

if($db_function->isValidCatagory($item)){

	$tid=$db_function->getidToValue("tid","eid",$pid,"hcare_lab_test_element");
	$wheredata[]="(a.`test_id`='".$pid."' or a.`test_id`='".$tid."')";
	
	$amount=$db_function->getidToValue("Price","id",$pid,"hcare_lab_element");
	
}else{
	$wheredata[]="a.`test_id`='".$pid."'";
}
}else if($ptype == "LT"){							   
$wheredata[]="a.`test_id`='".$pid."'";
}else if($ptype == "LE"){

$tid=$db_function->getidToValue("tid","eid",$pid,"hcare_lab_test_element");
$wheredata[]="(a.`test_id`='".$pid."' or a.`test_id`='".$tid."')";
}else{
$wheredata[]="a.`test_id`='".$pid."'";
}
}


if (!empty($postArr['from_time'])) {
$from_time = date('H:i:s',strtotime($postArr['from_time']));
}
else{
$from_time = '00:00:00';
}

if (!empty($postArr['to_time'])) {
$to_time = date('H:i:s',strtotime($postArr['to_time']));
}
else{
$to_time = '23:59:59';
}


if(!empty($postArr['from_date'])) {
										
$wheredata[]="b.`bill_date` >='".date("Y-m-d",strtotime($postArr['from_date']))." ".$from_time."'";
$wheredata[]="b.`bill_date` <='".date("Y-m-d",strtotime($postArr['to_date']))." ".$to_time."'";

}else{
$wheredata[]="b.`bill_date` >='".date("Y-m-d")." ".$from_time."'";
$wheredata[]="b.`bill_date` <='".date("Y-m-d")." ".$to_time."'";
}

$wheredata[]="b.`status` = 0";

// var_dump($wheredata);


// $billitemInfo=$bill_obj->getBillItemsInfo($wheredata,'test_id','asc');

$billitemInfo=$bill_obj->getBillItemsInfoTime($wheredata,'test_id','asc');

$arrInfo=array();

if(!empty($billitemInfo)){

for($i=0;$i<count($billitemInfo);$i++) {

$arrInfo[$i][0]=$billitemInfo[$i][1];
 $arrInfo[$i][1]=$billitemInfo[$i][5];

$type=$db_function->getidToValue("type","id",$billitemInfo[$i][1],"hcare_bill");
$bill_date=$db_function->getidToValue("bill_date","id",$billitemInfo[$i][1],"hcare_bill");
$payment_type=$db_function->getidToValue("paid_with","id",$billitemInfo[$i][1],"hcare_bill");

$opno='';
$ipno='';

if($type == "OP"){
$visit_id=$db_function->getidToValue("ref_no","id",$billitemInfo[$i][1],"hcare_bill");
$opno=$db_function->getidToValue("opno","id",$visit_id,"hcare_op_visit_info");
$patient_name=$db_function->getidToValue("first_name","id",$opno,"hcare_op_patient_info")." ".$db_function->getidToValue("middle_name","id",$opno,"hcare_op_patient_info")." ".$db_function->getidToValue("last_name","id",$opno,"hcare_op_patient_info");

}else if($type == "IP"){
$opno=$db_function->getidToValue("opno","id",$billitemInfo[$i][1],"hcare_bill");
$ipno=$db_function->getidToValue("ref_no","id",$billitemInfo[$i][1],"hcare_bill");
$patient_name=$db_function->getidToValue("first_name","id",$opno,"hcare_op_patient_info")." ".$db_function->getidToValue("middle_name","id",$opno,"hcare_op_patient_info")." ".$db_function->getidToValue("last_name","id",$opno,"hcare_op_patient_info");

}else{

$refno=$db_function->getidToValue("ref_no","id",$billitemInfo[$i][1],"hcare_bill");
$patient_name=$db_function->getidToValue("name","id",$refno,"hcare_direct_customer");
}
$arrInfo[$i][2]=$type;
$arrInfo[$i][3]=$opno;
$arrInfo[$i][4]=$ipno;
$arrInfo[$i][5]=$patient_name;
if($amount > 0 ){
   $arrInfo[$i][6]=$amount;
}else{
  $arrInfo[$i][6]=$billitemInfo[$i][11];
}
$arrInfo[$i][7]=$bill_date;
if($payment_type == "CREDIT"){
   $arrInfo[$i][8]=$arrInfo[$i][5];
}else{
$arrInfo[$i][8]=0;
}
$arrInfo[$i][10]=$billitemInfo[$i][35];
}

}

return $arrInfo;

}
}



/*public function getConsolidatedTest($postArr){




}	*/

?>
