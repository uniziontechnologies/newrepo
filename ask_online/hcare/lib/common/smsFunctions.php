<?php

  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 

require_once ROOT_PATH . '/config_hims.php';
require_once ROOT_PATH . '/lib/common/textlocal.class.php';
// require('../textlocal.class.php');
class SmsFunctions{

	public $thank_reg_sms="Thank You For Registering With JANATHA HOSPITAL. Your Registration Number is <prefix><opno>.";
	public $thank_reg_dr_sms="Thank You For Having Registered For Dr.<doctor_name> on <visit_date>. Your OP No is <opno> and Token No is <token>.";
	public $lab_report_ready_sms="Thank You For Using Our Services. Your Lab Report Is Ready.";
	public $dr_opcount_sms="Dear Dr.<doctor_name>, Your total OP for <date> is NEW: <new_count> REVIEW: <review_count> RENEW:<revisit_count> FREE: <free_count> ip: <ip_count>";
	public $total_collection_sms="Bill Collection for <date> is Rs.<amount>";
	public $total_opcount_sms="Total OPD count for <date> is NEW: <new_count> REVIEW: <review_count> RENEW:<revisit_count> DAILY-REVISIT: <daily_revisit_count> free: <free_count>";
	public $booking_cancelled_sms="Dear <patient_name>,Your appointment with <doctor_name> on <appointment_date> and Token No:<token_no> has been cancelled due to <reason>. <hospital_name>.";
	public $booking_sms="Dear <patient_name>, Your Booking is confirmed with <hospital_name>. Your Token Number is <token_no> for Doctor <doctor_name> on <booked_date> @ <booking_time>.\r\n <hospital_name>.";
	
	function sendSMS($phone=NULL, $msg="NULL"){
		 // echo $phone." ".$msg; exit;

		$config_obj = new Config_hims();

		if ($config_obj->sms_root=="NORMAL") {


				$url = "http://sms.hspsms.com:/sendSMS";

				$postfields = array(
					'username' => "uniziontech",
					'message' => "$msg",
					'sendername' => "UNZTCH",
					'smstype' => "TRANS",
					'numbers' => "$phone",
					'apikey' => "996f4254-7e6f-4961-97ba-6111824c0153"
				);



				$url = "http://sms.hspsms.com:/sendSMS";
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_NOBODY, true);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1); 
				curl_setopt($curl, CURLOPT_TIMEOUT, 1);
				$result = curl_exec($curl);

				if ($result !== false) 
				{

					if (!$curld = curl_init()) {
							exit;
					}

					$url = "http://sms.hspsms.com:/sendSMS";

					curl_setopt($curld, CURLOPT_POST, true);
					curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
					curl_setopt($curld, CURLOPT_URL,$url);
					curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

					$output = curl_exec($curld);

					curl_close ($curld);
					
					$created = date('Y-m-d H:i:s');
					
					$result = explode(';',$output);

					if ($result[0] == "Error") {
						return 0;

					} else {
						return 1;
					}

				}
				else
				{
				  return 0;
				}



		}
		elseif ($config_obj->sms_root=="OTP") {


			$textlocal = new Textlocal('vipin@uniziontechnologies.com ', 'Unizion@123');

			$numbers = array($phone);
			$sender = 'TXTLCL';
			$message = $msg;

			try {
			    $result = $textlocal->sendSms($numbers, $message, $sender);
			    // print_r($result);
			} 
			catch (Exception $e) {
			    return 0;
			}


		}
	




			
	}
	

}


?>