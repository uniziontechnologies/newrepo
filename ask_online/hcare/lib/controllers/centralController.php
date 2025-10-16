<?php session_start();
define('ROOT_PATH', $_SESSION['path']);


require_once ROOT_PATH . '/lib/controllers/adminController.php';
require_once ROOT_PATH . '/lib/controllers/roomController.php';
require_once ROOT_PATH . '/lib/controllers/registrationController.php';
require_once ROOT_PATH . '/lib/controllers/ipController.php';
require_once ROOT_PATH . '/lib/controllers/bookingController.php';
require_once ROOT_PATH . '/lib/controllers/procedureController.php';
require_once ROOT_PATH . '/lib/controllers/billController.php';
require_once ROOT_PATH . '/lib/controllers/repController.php';
require_once ROOT_PATH . '/lib/controllers/nurseController.php';
require_once ROOT_PATH . '/lib/controllers/drController.php';
require_once ROOT_PATH . '/lib/controllers/labController.php';

require ROOT_PATH . '/language/language.php';

$module=$_GET['module'];
$sub_module=$_GET['sub_module'];

switch ($module) {

case 'Admin'	: 
$admin_controller=new AdminController();

if(isset($_GET['View'])){
$admin_controller->viewPage($sub_module);
break;
}
switch($sub_module){

case 'HospitalInfo'		:		if(isset($_POST['action']) && $_POST['action']==$lang_update){

									$admin_controller->updateHospitalInfo($_POST);
							}
									break;
case 'User'				:	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageUser($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST);	
							}
									break;
									
case 'Department'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageDepartment($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST);	
							}
									break;
								
case 'Designation'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageDesignation($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST);	
							}
									break;
case 'Speciality'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageSpeciality($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST);	
							}
									break;
case 'Employee'	    :	
							$action=$_POST['paction'];
							 if(isset($_POST['paction']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageEmployee($_POST,$_GET);
							}else{
									$admin_controller->viewPage($sub_module,$_POST,$_GET);	
							}
									break;
case 'Insurance'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->manageInsCompany($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST,$_GET);	
							}
									break;
case 'patient_category'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$admin_controller->managePatientCategory($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST,$_GET);	
							}
									break;										
case 'OPSettings'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add )){
									$admin_controller->manageOPSettings($_POST);
							}else{
									$admin_controller->viewPage($sub_module,$_POST,$_GET);	
							}
									break;
case 'change_password'	    :	
							$action=$_POST['paction'];
							 if(isset($_POST['paction']) && ($action == $lang_add )){
							 	     $admin_controller->changePassword($_POST,$_GET);
									// $admin_controller->manageEmployee($_POST,$_GET);
							}else{
									$admin_controller->viewPage($sub_module,$_POST,$_GET);	
							}
									break;										
case 'show_pharma_branch' :$admin_controller->show_pharma_branch($_POST);
                      break;
case 'show_dep_speciality' :$admin_controller->show_dep_speciality($_POST);
                      break;
case 'update_accounting'   :$admin_controller->update_accounting($_POST);
                      break;

case 'lock_op_data'         : $admin_controller->lock_op_data($_POST);
                      break;
case 'lock_lab_data'         : $admin_controller->lock_lab_data($_POST);
                      break;
case 'lock_xray_data'         : $admin_controller->lock_xray_data($_POST);
                      break;
case 'lock_lab_credit_data'   : $admin_controller->lock_lab_credit_data($_POST);
                      break;
case 'lock_xray_credit_data'   : $admin_controller->lock_xray_credit_data($_POST);
                      break;
case 'lock_pharmacy_sales_data' : $admin_controller->lock_pharmacy_sales_data($_POST);
                      break;
case 'lock_pharmacy_purchase_data' : $admin_controller->lock_pharmacy_purchase_data($_POST);
                      break;
case 'lock_pharmacy_purchase_data_return' : $admin_controller->lock_pharmacy_purchase_data_return($_POST);
                      break;

case 'lock_pharmacy_sales_return_data' : $admin_controller->lock_pharmacy_sales_return_data($_POST);

case 'lock_procedure_data'         : $admin_controller->lock_procedure_data($_POST);
                      break;
case 'lock_procedure_credit_data'   : $admin_controller->lock_procedure_credit_data($_POST);
                      break;
case 'lock_ip_data'         : $admin_controller->lock_ip_data($_POST);
                      break;
case 'lock_theater_credit_data'  : $admin_controller->lock_theater_credit_data($_POST);
                      break;
case 'lock_theater_data'       : $admin_controller->lock_theater_data($_POST);
                      break;
case 'lock_super_nurse_credit_data'  : $admin_controller->lock_super_nurse_credit_data($_POST);
                      break;
case 'lock_nurse_data'       : $admin_controller->lock_nurse_data($_POST);
                      break;
case 'lock_nurse_credit_data'  : $admin_controller->lock_nurse_credit_data($_POST);
                      break;
case 'lock_op_dr_payments_data'  : $admin_controller->lock_op_dr_payments_data($_POST);
                      break;
case 'lock_ip_advance_data'  : $admin_controller->lock_ip_advance_data($_POST);
                      break;
case 'delete_med_days'       : $admin_controller->delete_med_days($_POST);
                       break;
case 'email_settings_report'	    :	
							
						$admin_controller->viewPage($sub_module,$_POST);	
							
							break;
case 'saveRegEmail'  : 
				$admin_controller->saveRegEmail($_POST);
					break;									                            


            default   :$admin_controller->viewPage($sub_module,$_POST,$_GET);
						break;						                       

}


break;
case 'Room'	: 
$room_controller=new RoomController();

if(isset($_GET['View'])){
$room_controller->viewPage($sub_module);
break;
}
switch($sub_module){


									
case 'RoomCategory'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$room_controller->manageRoomCategory($_POST);
							}else{
									$room_controller->viewPage($sub_module,$_POST);	
							}
									break;
case 'Room'				:         $action=$_POST['action'];

						if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$room_controller->manageRooms($_POST);
							}else{
								
							
								$room_controller->viewPage($sub_module,$_POST);	
							}
							break;
               case 'delete_room'                       :  $room_controller->deleteRoom($_POST);

                                                            break;

               case 'check_room_status'                       :  $room_controller->check_room_status($_POST);

                                                            break;

               case 'check_category_status'                       :  $room_controller->check_category_status($_POST);

                                                            break;                                                             
               case 'Process_Station'              :

                                                       $room_controller->processStation($_POST);
                                                       break;
               case 'Check_Station_Name'          :

                                                       $room_controller->check_station_name($_GET);
                                                       break;

               default				:	$room_controller->viewPage($sub_module,$_POST);
				break;	



}
break;

case 'Booking':
$bk_controller=new BookingController();

if(isset($_GET['View'])){
$bk_controller->viewPage($sub_module,$_POST);
break;
}
switch($sub_module){

case 'Scheduling_Form'			:

									if(isset($_GET['action']) && ($_GET['action'] == $lang_block)){
												
										$bk_controller->changeBookingStatus($_POST);
									}
									else if(isset($_POST['action']) && ($_POST['action'] == $lang_update)){
												
										$bk_controller->updateSchedule($_POST);
									}else{
									
										$bk_controller->viewPage($sub_module,$_POST);
									}
									break;
case 'Booking_Form'			:

									if(isset($_POST['action']) && ($_POST['action'] == $lang_add)){
										 // echo $_POST['action'];exit;
												
										$bk_controller->booking_process($_POST);
									}else{

									
										$bk_controller->viewPage($sub_module,$_POST);
									}
									break;
case 'Booking_Report'			:
									$bk_controller->viewPage($sub_module,$_POST);
									break;
case 'Token_Reservation'			:
									$bk_controller->updateTokenReservation($_POST);
									break;
case 'Cancel_Booking'			:
									$bk_controller->viewPage($sub_module,$_POST,$_GET);
									break;									
/*case 'Doctors_Availability'     :
									$bk_controller->viewPage($sub_module,$_POST);
									break;*/

case 'save_blocked_date'          :          $bk_controller->save_blocked_date($_POST);
		
									break;

case 'delete_blocked_date'          :          $bk_controller->delete_blocked_date($_POST);


case 'transfer_booking'          :          $bk_controller->transfer_booking($_POST);

		
									break;
									

default							:	$bk_controller->viewPage($sub_module,$_POST);
										break;

}
break;
case 'Registration':
$reg_controller=new RegistrationController();
$nurse_controller = new NurseController(); 

if(isset($_GET['View'])){
if($sub_module=='op_patient_list'){
   $nurse_controller->viewPage($sub_module);
}else $reg_controller->viewPage($sub_module);

break;
}

switch($sub_module){

case 'patient_registeration'	:	

										if(isset($_GET['paction']) && ($_GET['paction'] == $lang_process_form)){ 
											// echo 11;exit();  
										$reg_controller->processRegForm($_POST);
										}else if((isset($_GET['paction']) && $_GET['paction'] == $lang_process_OPNo) || (isset($_POST['paction']) && $_POST['paction'] == $lang_edit_page) || (isset($_POST['paction']) && $_POST['paction'] == $lang_revisit) ){ 
											


										$reg_controller->processOPNo($_POST,$_GET);
										}else if(isset($_POST['paction']) && ($_POST['paction'] == $lang_registration || $_POST['paction'] == $lang_regupdate)){
										// echo 33;exit();  
										$reg_controller->processRegistration($_POST);
										}else if(isset($_POST['paction']) && ($_POST['paction'] == $lang_delete)){
											// echo 44;exit(); 
										
										$reg_controller->deletePatientVisit($_POST);
										}else{
											// echo 55;exit(); 
										$reg_controller->viewPage($sub_module,$_POST,$_GET);	
										}
										break;
case 'search_op_patient'        : if(isset($_POST['paction']) && ($_POST['paction'] == 'Search')){

											$reg_controller->processOPSearch($_POST);
								  }else{
											$reg_controller->viewPage($sub_module,$_POST,$_GET);	
										}

                                                                  break;	
                           case 'save_image'              :  $reg_controller->saveImage($_POST);
								break;		


case 'attach_patient_documents' : 
						$reg_controller->add_patient_document($_POST);
					break;		
case 'delete_patient_document' : 
						$reg_controller->delete_patient_document($_POST);

                	break;

case 'attach_ip_patient_documents' : 
						$reg_controller->add_ip_patient_document($_POST);
					break;

case 'delete_ip_patient_document' : 
						$reg_controller->delete_ip_patient_document($_POST);

                	break;

case 'attach_ip_patient_xray_documents' : 
						$reg_controller->add_ip_patient_xray_document($_POST);
					break;
					
case 'delete_ip_patient_xray_document' : 
						$reg_controller->delete_ip_patient_xray_document($_POST);

                	break;



case 'referal_cases'	:	

										if (isset($_GET['paction']) && ($_GET['paction'] == 'DOC_FEE')) { 
										
											$reg_controller->doc_fee_change($_POST);
										}
										else if( ($_POST['paction'] == 'REFER') && empty($_GET['paction']) ){ 
											// var_dump($_POST);exit;
												$reg_controller->processOPNo_ref($_POST);
										}
										else if (isset($_GET['paction']) && ($_GET['paction'] == $lang_process_form)) {

											$reg_controller->processRegForm_ref($_POST);
										}

										break;
case 'print_ip_casesheet'              :  $reg_controller->print_ip_casesheet($_GET);
							        	break;	

case 'save_payment_status'              :  $reg_controller->save_payment_status($_POST);
							        	break;	
							        		

										
			default				:		$reg_controller->viewPage($sub_module,$_POST,$_GET);
										break;



}
break;
case 'IP'   :


$ip_controller=new ipController();

if(isset($_GET['View'])){
                              if($sub_module == "Discharge") {

                                   $bill_controller = new BillController();
                                   $_POST['request_from']="Discharge";
                                   $bill_controller->viewPage("IP_Search",$_POST);

                              }else{
	$ip_controller->viewPage($sub_module);
                              }
	break;
}

switch($sub_module){

		/*case 'admit_form'	:
									$ip_controller->admit_form($_POST,$_GET);
									break;*/
                                     
		case 'patient_admission'	:		
										if(isset($_POST['paction']) && ($_POST['paction'] == 'SAVE' || $_POST['paction'] == 'UPDATE')){ 
												$ip_controller->processAdmission($_POST);
										}
                                        break;
		case 'process_room'  :
									$ip_controller->processRoom($_POST);
									break;

		case 'add_new_template'      :

									$ip_controller->add_new_template($_POST);
									break;

		case 'update_template'      :

									$ip_controller->update_template($_POST);
									break;

		case 'delete_template'      :
		
									$ip_controller->delete_template($_POST);
									break;

		default				:		$ip_controller->viewPage($sub_module,$_POST,$_GET);
										break;
}

break;	
case 'Procedures':
$proc_controller = new ProcedureController();

if(isset($_GET['View'])){
$proc_controller->viewPage($sub_module);
break;
}
switch($sub_module){

	case 'Manage_Category'	    :	
								$action=$_POST['action'];
								 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$proc_controller->manageCategory($_POST);
								}else{
									$proc_controller->viewPage($sub_module,$_POST);	
								}
									break;
	case 'Manage_Procedure'	    :	
								$action=$_POST['action'];
								 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$proc_controller->manageProcedure($_POST);
								}else{
									$proc_controller->viewPage($sub_module,$_POST);	
								}
									break;
	case 'health_checkup_package'	    :	
								$action=$_POST['action'];
								 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$proc_controller->manageHealthPackage($_POST);
								}else{
									$proc_controller->viewPage($sub_module,$_POST);	
								}
									break;

case 'health_checkup_package_order'	:
								$proc_controller->healthCheckupPackageOrder($_POST);
								break;

	default				:		$proc_controller->viewPage($sub_module,$_POST);
										break;

}
break;

case 'Billing':
$bill_controller = new BillController();

if(isset($_GET['View'])){
$bill_controller->viewPage($sub_module);
break;
}

switch($sub_module){
                      
case 'customer_bill'	:	$_POST['type']="DIRECT";	
                            $bill_controller->viewPage('Billing_Form',$_POST);
										break;	                                
    case 'op_bill'	         :	$_POST['type']="OP";	
                            $bill_controller->viewPage('Select_Bill',$_POST);
										break;	
case 'ip_bill'	         :	$_POST['type']="IP";	
                            $bill_controller->viewPage('Select_Bill',$_POST);
										break;																			

case 'Process_Select_Bill'	: $bill_controller->process_select_bill($_POST);
									break;
									
case 'Process_Bill_Form'	: $bill_controller->process_bill_form($_POST,$_GET);
									break;
case 'add_changeamount_billing'	: $bill_controller->add_changeamount_billing($_POST,$_GET);
									break;
case 'Process_Billing'		: $bill_controller->process_billing($_POST);
									break;
   case 'Add_Advance_Payment'     : $bill_controller->add_advance_payment($_POST);
									break;
     case 'Add_Final_Payment'     : $bill_controller->add_final_payment($_POST);
									break;
 case 'Save_Prepare_Bill'     : 
                                  
                                   $bill_controller->add_final_payment($_POST);
									break;
case 'Cancel_IP_Bill'     : 
                                  
                                   $bill_controller->cancel_ip_bill($_POST);
									break;
case 'Cancel_Advance_Payments'     : 
                                  
                                   $bill_controller->cancel_advance_payment($_POST);
									break;

case 'Prepare_Final_Bill'       :  if(isset($_POST['paction']) && $_POST['paction']== "json"){

                                        $bill_controller->processFinalForm($_POST);
                                   }else{
                                  
                                  	$bill_controller->viewPage($sub_module,$_POST);
											
                                  }
                                  
case 'Final_Payment_Form'       :  if(isset($_POST['paction']) && $_POST['paction']== "json"){ 

					
					                          $bill_controller->processFinalForm($_POST);
										

                                  }else{
                                  
                                  	$bill_controller->viewPage($sub_module,$_POST);
											
                                  }
                                  
                                  break;
case 'procedure_amount'           :  if(isset($_POST['paction']) && $_POST['paction']== "json"){
	                                $bill_controller->procedure_amount($_POST);  
                        }
                                  break;                       
case 'change_doctor_billing_item' : $bill_controller->change_doctor_billing_item($_POST);
									break;
case 'Manage_Billing'		: if((isset($_POST['paction']) && $_POST['paction'] == $lang_edit_page) ){
									$bill_controller->processBillNo($_POST);
									break;
								}else if((isset($_POST['paction']) && $_POST['paction'] == $lang_delete) ){
									$bill_controller->deleteBill($_POST);
									break;
								}else{
								     $bill_controller->viewPage($sub_module,$_POST,$_GET);
										break;	
								}
 case 'add_ip_credit_payment'     : 
                                  
                                   $bill_controller->add_ip_credit_payment($_POST);
				    break;
 case 'update_field_values'  :$bill_controller->update_ip_addon_field($_POST);
                              break;
 case 'attach_patient_documents' : 
							  $bill_controller->add_patient_document($_POST);
							  break;
 case 'delete_patient_document' : 
							  $bill_controller->delete_patient_document($_POST);
							  break;


case 'delete_Credit'          : 

							$bill_controller->cancel_credit_payment($_POST);
							 
							  break;										    	

 case 'cancel_ip_discharge_bill' : 
							  $bill_controller->cancel_ip_discharge_bill($_POST);
							  break;		 


									
default						:		$bill_controller->viewPage($sub_module,$_POST,$_GET);
										break;					



}
break;

case 'Nurse' :
$nurse_controller = new NurseController();


if(isset($_GET['View'])){

if($sub_module=='op_patient_list'){

$sub_module=='op_patient_list';

}
else if ($sub_module=='inpatients') {

$sub_module=='inpatients';

}else if ($sub_module=='ip_Patient_Records') {

$sub_module=='ip_Patient_Records';

}else if ($sub_module=='add_ot_schedule') {

$sub_module=='add_ot_schedule';

}else if ($sub_module=='manage_ot_schedule') {

$sub_module=='manage_ot_schedule';

}else if ($sub_module=='search_patient') { 

$sub_module=='search_patient';

}
else{
    
if(!empty( $_SESSION['select_station'])) $sub_module ="Select_Station";
else if(!empty( $_SESSION['current_menu'])) $sub_module =$_SESSION['current_menu'];
}

$nurse_controller->viewPage($sub_module);
   
break;
}

switch($sub_module){

        case 'select_ip_patient' : 

                                   $nurse_controller->select_ip_patient($_POST);

                                    break;
        
        case 'add_procedure' : 

                                   $nurse_controller->add_procedure($_POST);

                                    break;
       case 'delete_procedure' : 

                                   $nurse_controller->delete_procedure($_POST);

                                    break;
       case 'add_doctor_visit' : 

                                   $nurse_controller->add_doctor_visit($_POST);

                                    break;
       case 'delete_doctor_visit' : 

                                   $nurse_controller->delete_doctor_visit($_POST);

                                    break;
       case 'add_nursing_notes' : 

                                   $nurse_controller->add_nursing_notes($_POST);

                                    break;
       case 'delete_nursing_notes' : 

                                   $nurse_controller->delete_nursing_notes($_POST);

                                    break;
       case 'save_nursing_station' :

                                     $nurse_controller->save_nursing_station($_POST);
											 break;

        case 'add_room_transfer' :

                                     $nurse_controller->add_room_transfer($_POST);

                                      break;   

        case 'save_physical_examination' : $nurse_controller->save_physical_examination($_POST);
                                      break;   
				
        case 'save_ip_medicines' : 

        							  $nurse_controller->save_ip_medicines($_POST);
        							  
                                      break;  
				case 'delete_medicines' : 

                                   $nurse_controller->delete_medicines($_POST);

                                    break;
			      



       case 'edit_nursing_notes' : 

                                   $nurse_controller->edit_nursing_notes($_POST);

                                    break;			      
			      
			      
			      
			      
			      
			      
			      
			      
         case 'save_ot_schedule' :
         						$nurse_controller->save_ot_schedule($_POST);
         						break;
         case 'manage_ot_schedule_info':
         							if((isset($_POST['paction']) && $_POST['paction'] == $lang_edit_page) ){
									$nurse_controller->processOtScheduleData($_POST);
									break;
								}
	     case 'update_ot_schedule' :
         						$nurse_controller->update_ot_schedule($_POST);
         						break;	
          case 'delete_ot_schedule_info' :
         						$nurse_controller->delete_ot_schedule_info($_POST);
         						break;
         	case 'add_own_medicines' :

                                     $nurse_controller->add_own_medicines($_POST);

                                      break;   
          case 'edit_own_medicines' : 

                                   $nurse_controller->edit_own_medicines($_POST);

                                    break;
          case 'delete_own_medicines' : 

                                   $nurse_controller->delete_own_medicines($_POST);

                                    break;                          		                            												
											

         

         						                          



         default		  :  $nurse_controller->viewPage($sub_module,$_POST);
                                       break;
										break;					
}
break;
case 'Doctor' :
$dr_controller = new DrController();




if(isset($_GET['View'])){

    
$dr_controller->viewPage($sub_module);
   
break;
}


 switch($sub_module){
     
case 'save_case_sheet' : $dr_controller->save_case_sheet($_POST);
                break;
case 'delete_casesheet_items' : $dr_controller->delete_casesheet_items($_POST);
                break;
case 'dr_consulted' : $dr_controller->setDrconsulted($_POST,$_GET);
                break;
case 'reset_dr_consulted' : $dr_controller->resetDrconsulted($_POST);
                break;
case 'get_med_presc_json' : $dr_controller->get_med_presc_json($_POST);
                break;
case 'save_physical_examination' : $dr_controller->save_physical_examination($_POST);
                break;
case 'add_patient_allergy' : $dr_controller->add_patient_allergy($_POST);
                break;
case 'delete_patient_allergy' : 
				$dr_controller->delete_patient_allergy($_POST);
                break;                          
case 'attach_patient_documents' : 
						$dr_controller->add_patient_document($_POST);
					break;
case 'delete_patient_document' : 
						$dr_controller->delete_patient_document($_POST);

                	break;
case 'save_diabetic_status' : $dr_controller->save_diabetic_status($_POST);
                break;
case 'save_hyper_tension_status' : $dr_controller->save_hyper_tension_status($_POST);
                break;													
case 'add_diabetic_reading' : $dr_controller->add_diabetic_reading($_POST);
                break;
case 'delete_diabetic_reading' : $dr_controller->delete_diabetic_reading($_POST);
                break;
case 'save_consultation_status' : $dr_controller->setDrconsulted($_POST);
                break;
case 'add_referal_info' : $dr_controller->addReferalInfo($_POST);
                break;
case 'delete_referal_info' : 
				$dr_controller->delete_referal_info($_POST);
                break;

//========================================================================================================================
//  inpatient emr
//========================================================================================================================

case 'save_ip_case_sheet' : $dr_controller->save_ip_case_sheet($_POST);
                break;
case 'delete_ip_casesheet_items' : $dr_controller->delete_ip_casesheet_items($_POST);
//                            break;
//                case 'dr_consulted' : $dr_controller->setDrconsulted($_POST,$_GET);
//                            break;
// case 'reset_dr_consulted' : $dr_controller->resetDrconsulted($_POST);
                break;
case 'get_ip_med_presc_json' : $dr_controller->get_ip_med_presc_json($_POST);
                break;
case 'save_ip_physical_examination' : $dr_controller->save_ip_physical_examination($_POST);
                break;
case 'add_ip_patient_allergy' : $dr_controller->add_ip_patient_allergy($_POST);
                break;
case 'delete_ip_patient_allergy' : 
				$dr_controller->delete_ip_patient_allergy($_POST);
                break;                          
case 'attach_ip_patient_documents' :
						$dr_controller->add_ip_patient_document($_POST);
					break;
case 'delete_ip_patient_document' : 
						$dr_controller->delete_ip_patient_document($_POST);

                	break;
case 'attach_ip_patient_xray_documents' : 
						$dr_controller->add_ip_patient_xray_document($_POST);
					break;
case 'delete_ip_patient_xray_document' : 
						$dr_controller->delete_ip_patient_xray_document($_POST);

                	break;
case 'save_ip_diabetic_status' : $dr_controller->save_ip_diabetic_status($_POST);
                break;
case 'save_ip_hyper_tension_status' : $dr_controller->save_ip_hyper_tension_status($_POST);
                break;													
case 'add_ip_diabetic_reading' : $dr_controller->add_ip_diabetic_reading($_POST);
                break;
case 'delete_ip_diabetic_reading' : $dr_controller->delete_ip_diabetic_reading($_POST);
           break;
case 'add_ip_ot_note' : $dr_controller->add_ip_ot_note($_POST);
                
                break;
case 'delete_ip_ot_note' : $dr_controller->delete_ip_ot_note($_POST);
                break;

case 'edit_ip_ot_note' : $dr_controller->edit_ip_ot_note($_POST);
                break;
// case 'save_ip_consultation_status' : $dr_controller->setDrconsulted($_POST);
    //             break;
// case 'add_referal_info' : $dr_controller->addReferalInfo($_POST);
//                            break;
// case 'delete_referal_info' : 
//                							$dr_controller->delete_referal_info($_POST);
//                            break;

case 'save_covid_status' : $dr_controller->save_covid_status($_POST);
                break;

default		  :  $dr_controller->viewPage($sub_module,$_POST,$_GET);
                                       break;

 }

break;
case 'Report' :

$rep_controller = new ReportController();


$rep_controller->viewPage($sub_module,$_POST,$_GET);
break;


case 'User_Authenticate' :
$admin_controller=new AdminController();
switch($sub_module){
  
  case 'authenticate_json' : $admin_controller->autheticate_user_json($_POST);
                break;
  
  }
  break;
case 'Lab'    :
$lab_controller=new LabController();

if(isset($_GET['View'])){
  $lab_controller->viewPage($sub_module);
	break;
}
switch($sub_module){
     
case 'Elements'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$lab_controller->manageElements($_POST);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
									break;
case 'Category'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$lab_controller->manageCategory($_POST);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
									break;
case 'Group_test'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$lab_controller->manageGroupTest($_POST);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
									break;	
case 'SubCategory'	    :	
							$action=$_POST['action'];
							 if(isset($_POST['action']) && ($action == $lang_add ||$action == $lang_update || $action == $lang_delete)){
									$lab_controller->manageSubcategory($_POST);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
									break;
									
case 'Save_result_entry' :     $lab_controller->save_result_entry($_POST,$_GET);
                                       break;
case 'updateMailStatus' :     $lab_controller->updateMailStatus($_POST,$_GET);
                                       break;

case 'email_settings_lab'	    :	
							$action=$_POST['paction'];
							if(isset($_POST['paction']) && ($action == $lang_add )){
								$usage_type='LAB';
								 $lab_controller->saveSmtpSettings($_POST,$usage_type);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
							break;
case 'smtp_settings_reports'	    :	
							$action=$_POST['paction'];
							if(isset($_POST['paction']) && ($action == $lang_add )){
								$usage_type='REPORT';
								 $lab_controller->saveSmtpSettings($_POST,$usage_type);
							}else{
									$lab_controller->viewPage($sub_module,$_POST);	
							}
							break;
// new lab changes
case 'Lab_employees':      
                   	$action=$_POST['paction'];
						 if(isset($_POST['paction']) && ($action == 'LAB IN CHARGE')){
						 	$a=$_POST['id'];
						 	$lab_in_status=$_POST['lab_in_status'];
						 	
						 		$lab_controller->labInChargeUpdate($_POST,$_GET);


						}else{
								$lab_controller->viewPage($sub_module,$_POST,$_GET);	
						}
						
						break;
case 'Lab_signature':
							$lab_controller->viewPage($sub_module,$_POST,$_GET);
							break;
case 'attach_lab_signature' : 
					$lab_controller->add_lab_signature($_POST);
				break;
case 'delete_lab_signature' : 
					$lab_controller->remove_lab_signature($_POST);

           		break;
case 'update_patient_info' :     $lab_controller->update_patient_info($_POST,$_GET);
                                       break;                     																																									

							

// case 'saveSmtpSettings'  : $settings_controller->saveSmtpSettings($_POST);										


default		  :              $lab_controller->viewPage($sub_module,$_POST,$_GET);
                                       break;																	
}



}


?>
