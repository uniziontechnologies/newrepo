<?php 
define('ROOT_PATH', dirname(__FILE__));

require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';
require_once ROOT_PATH . '/lib/model/admin/accounting.php';

$acc_obj_new = new Accounting();

$today_date = date("Y-m-d");

$collection_date= date('Y-m-d', strtotime( $today_date . ' -1 day' ));

$collection_date_from = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

$collection_date_to = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

// $collection_date=$today_date;
// $collection_date_from = $today_date;
// $collection_date_to= $today_date;

 $daily_collection=daily_collection($collection_date_from,$collection_date_to);
 

 
 // CREDIT SECTION

 $lab_credit_bills = credit_bills($collection_date_from,$collection_date_to,"LAB");

 $lab_credit_paid  = credit_paid($collection_date_from,$collection_date_to,$lab_credit_bills);


 $xray_credit_bills = credit_bills($collection_date_from,$collection_date_to,"XRAY");

 $xray_credit_paid  = credit_paid($collection_date_from,$collection_date_to,$xray_credit_bills);


 $procedure_credit_bills = credit_bills($collection_date_from,$collection_date_to,"PROCEDURE");

 $procedure_credit_paid  = credit_paid($collection_date_from,$collection_date_to,$procedure_credit_bills);


 $theater_credit_bills = credit_bills($collection_date_from,$collection_date_to,"THEATER");

 $theater_credit_paid  = credit_paid($collection_date_from,$collection_date_to,$theater_credit_bills);


 $xray_credit_bills_user = credit_bills($collection_date_from,$collection_date_to,"XRAY_USER");

 $xray_credit_paid_user  = credit_paid($collection_date_from,$collection_date_to,$xray_credit_bills_user);

 $xray_credit_paid = $xray_credit_paid+$xray_credit_paid_user;

 $nurse_credit_bills = credit_bills($collection_date_from,$collection_date_to,"NURSE");

 $nurse_credit_paid  = credit_paid($collection_date_from,$collection_date_to,$nurse_credit_bills);

  $all_credit_bills = credit_bills($collection_date_from,$collection_date_to,"ALL");
 $previos_days_credit_paid  = credit_paid_previous($collection_date_from,$collection_date_to,$all_credit_bills);


 // IP CREDIT COLLECTION
 $ip_credit_bills = ip_credit_bills($collection_date_from,$collection_date_to);
 $ip_credit_paid  = ip_credit_paid($collection_date_from,$collection_date_to,$ip_credit_bills);

 $previos_days_credit_paid_ip  = ip_credit_paid_previous($collection_date_from,$collection_date_to,$ip_credit_bills);

 
 // var_dump($ip_credit_bills);
 // var_dump($ip_credit_paid);
 // var_dump($previos_days_credit_paid_ip);
 // exit;


 $accounting_details =$acc_obj_new->getAccountingAutomise();

 accounting_insertion($daily_collection,$collection_date,$accounting_details);


  // CREDIT INSERTION

  if ($accounting_details[7][7]==1) {


	 if ($daily_collection['lab_credit_total']>0) {
	 	accounting_insertion_journal($daily_collection['lab_credit_total'],$collection_date,"LAB",$accounting_details);
	 }

	 if ($lab_credit_paid>0) {
	 	accounting_insertion_reciept($lab_credit_paid,$collection_date,"LAB",$accounting_details);
	 }

 }


  if ($accounting_details[8][7]==1) {

	 if ($daily_collection['total_reception_xray_collection_credit']>0) {
	 	accounting_insertion_journal($daily_collection['total_reception_xray_collection_credit'],$collection_date,"XRAY",$accounting_details);
	 }

	 if ($xray_credit_paid>0) {
	 	accounting_insertion_reciept($xray_credit_paid,$collection_date,"XRAY",$accounting_details);
	 }


 }


  if ($accounting_details[9][7]==1) {

	 if ($daily_collection['total_reception_proc_collection_credit']>0) {
	 	accounting_insertion_journal($daily_collection['total_reception_proc_collection_credit'],$collection_date,"PROCEDURE",$accounting_details);
	 }

	 if ($procedure_credit_paid>0) {
	 	accounting_insertion_reciept($procedure_credit_paid,$collection_date,"PROCEDURE",$accounting_details);
	 }


 }


  if ($accounting_details[10][7]==1) {

	 if ($daily_collection['theatre_credit_total']>0) {
	 	accounting_insertion_journal($daily_collection['theatre_credit_total'],$collection_date,"THEATER",$accounting_details);
	 }

	 if ($theater_credit_paid>0) {
	 	accounting_insertion_reciept($theater_credit_paid,$collection_date,"THEATER",$accounting_details);
	 }


 }


  if ($accounting_details[13][7]==1) {

	 if ($daily_collection['nurse_credit_total']>0) {
	 	accounting_insertion_journal($daily_collection['nurse_credit_total'],$collection_date,"NURSE",$accounting_details);
	 }

	 if ($nurse_credit_paid>0) {
	 	accounting_insertion_reciept($nurse_credit_paid,$collection_date,"NURSE",$accounting_details);
	 }


 }


  if ($previos_days_credit_paid>0) {
	 
	 accounting_insertion_reciept_previous_days($previos_days_credit_paid,$collection_date,"LAB",$accounting_details);
	}



  if ($accounting_details[14][7]==1) {

	 if ($daily_collection['ip_credit_total']>0) {
	 	accounting_insertion_journal($daily_collection['ip_credit_total'],$collection_date,"IP_CREDIT",$accounting_details);
	 }

	 if ($ip_credit_paid>0) {
	 	accounting_insertion_reciept($ip_credit_paid,$collection_date,"IP_CREDIT",$accounting_details);
	 }


 }

   // if ($previos_days_credit_paid_ip>0) {
	 
	//  accounting_insertion_reciept_previous_days($previos_days_credit_paid_ip,$collection_date,"IP_CREDIT",$accounting_details);
	// }






function daily_collection($collection_date_from,$collection_date_to){

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
      $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
      $wheredata[2]="user_id in $user_id";
	  $wheredata[3]="status =0";
	  
	  $lab_collection=$bill_obj->getBillConsolidated($wheredata);

	  // var_dump($lab_collection);exit();
	  
	  $lab_cash_collection=$lab_collection[0][0];
	  $lab_card_collection=$lab_collection[0][2];
	  $lab_credit_collection=$lab_collection[0][1];
	  $lab_upi_collection=$lab_collection[0][4];
	  
	  if($lab_cash_collection == "") $lab_cash_collection=0;
	  if($lab_card_collection == "") $lab_card_collection=0;
	  if($lab_credit_collection == "") $lab_credit_collection=0;
	  if($lab_upi_collection == "") $lab_upi_collection=0;
	  
	  $total_lab_collection=$lab_cash_collection+$lab_card_collection+$lab_credit_collection+$lab_upi_collection;

	  $lab_credit_total = $lab_collection[0][1]; 
  }
  $collections['lab']= $total_lab_collection;
  $collections['lab_credit_total']= $lab_credit_total;



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
      $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
      $wheredata[2]="user_id in $user_id";
	  $wheredata[3]="status =0";
	  $wheredata[4]="type ='IP'";
	  
	  $theatre_collection=$bill_obj->getBillConsolidated($wheredata);
	  
	  $theatre_cash_collection=$theatre_collection[0][0];
	  $theatre_card_collection=$theatre_collection[0][2];
	  $theatre_upi_collection=$theatre_collection[0][4];
	  $theatre_credit_collection=$theatre_collection[0][1];

	  
	  if($theatre_cash_collection == "") $theatre_cash_collection=0;
	  if($theatre_card_collection == "") $theatre_card_collection=0;
	  if($theatre_upi_collection == "") $theatre_upi_collection=0;
	  if($theatre_credit_collection == "") $theatre_credit_collection=0;
	  
	  $total_theatre_collection=$theatre_cash_collection+$theatre_card_collection+$theatre_upi_collection+$theatre_credit_collection;

	  $theatre_credit_total = $theatre_collection[0][1];
  }
  $collections['theatre']= $total_theatre_collection;

  $collections['theatre_credit_total']= $theatre_credit_total;


	  

//ip collection

      $wheredata=array();
      $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
      $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	  $wheredata[2]="(bill_status!=1 and bill_status!=3)";
	 
	  
	  $ip_collection=$bill_obj->getIPBillConsolidated($wheredata);

	  $ip_cash_collection=$ip_collection[0][0];
	  $ip_card_collection=$ip_collection[0][1];
	  $ip_cheque_collection=$ip_collection[0][2];
	  $ip_upi_collection=$ip_collection[0][5];
	  
	  if($ip_cash_collection == "") $ip_cash_collection=0;
	  if($ip_card_collection == "") $ip_card_collection=0;
	  if($ip_cheque_collection == "") $ip_cheque_collection=0;
	  if($ip_upi_collection == "") $ip_upi_collection=0;
	  $ip_credit_total = 0;

		

	  $total_ip_collection=$ip_cash_collection+$ip_card_collection+$ip_cheque_collection+$ip_upi_collection;

	  $ip_credit_total = $ip_collection[0][4]-$total_ip_collection; 

	  $collections['ip_collection']= $total_ip_collection+$ip_credit_total;

		$collections['ip_credit_total']= $ip_credit_total;



	  //op collection
	  
	  $op_collection=$report_obj->daily_collection($collection_date_from,$collection_date_to);

	  $op_cash = 0;
	  $op_card = 0;
	  $op_upi = 0;
	 
	  $op_cash = $op_collection[0][1]+$op_collection[1][1]+$op_collection[2][1];
	  $op_card = $op_collection[0][2]+$op_collection[1][2]+$op_collection[2][2];
	  $op_upi = $op_collection[0][4]+$op_collection[1][4]+$op_collection[2][4];

	  $total_op_collection=$op_cash+$op_card+$op_upi;
	  $collections['op_collection']=$total_op_collection;


      $wheredata=array();
      $wheredata[0]="payment_date >='".$collection_date_from."'";
      $wheredata[1]="payment_date <='".$collection_date_to."'";
	  $wheredata[2]="status =0";
	  
	  $op_dr_payments=$bill_obj->getOpDrPaymentsConsolidated($wheredata);
	  $collections['op_dr_payments']=$op_dr_payments[0];



 	// RECEPTION COLLECTION

  	$user_data=array();
  	$user_data[]="user_type='4'";
  
  	$userInfo=$user_obj->getUser('',$user_data);

  	$total_reception_xray_collection = 0;

  	$total_reception_proc_collection = 0;
  
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
	}


	// RECEPTION PROCEDURE

    $wheredata=array();

    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
    $wheredata[2]="user_id in $user_id";
	$wheredata[3]="status = 0";
	$wheredata[4]="bill_type = 1";
	  
	$total_reception_proc_collection = $bill_obj->getBillConsolidated($wheredata);

	$total_reception_proc_collection_cash = $total_reception_proc_collection[0][0];
	$total_reception_proc_collection_card = $total_reception_proc_collection[0][2];
	$total_reception_proc_collection_credit = $total_reception_proc_collection[0][1];
	$total_reception_proc_collection_upi = $total_reception_proc_collection[0][4];
	  
	if($total_reception_proc_collection_cash == "") $total_reception_proc_collection_cash=0;
	if($total_reception_proc_collection_card == "") $total_reception_proc_collection_card=0;
	if($total_reception_proc_collection_credit == "") $total_reception_proc_collection_credit=0;
	if($total_reception_proc_collection_upi == "") $total_reception_proc_collection_upi=0;
	  
	$total_reception_proc_collection = $total_reception_proc_collection_cash + $total_reception_proc_collection_card + $total_reception_proc_collection_credit+$total_reception_proc_collection_upi;



	// RECEPTION X-RAY

    $wheredata=array();

    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
    $wheredata[2]="user_id in $user_id";
	$wheredata[3]="status = 0";
	$wheredata[4]="bill_type = 2";
	  
	$total_reception_xray_collection = $bill_obj->getBillConsolidated($wheredata);

	$total_reception_xray_collection_cash = $total_reception_xray_collection[0][0];
	$total_reception_xray_collection_card = $total_reception_xray_collection[0][2];
	$total_reception_xray_collection_credit = $total_reception_xray_collection[0][1];
	$total_reception_xray_collection_upi = $total_reception_xray_collection[0][4];
	  
	if($total_reception_xray_collection_cash == "") $total_reception_xray_collection_cash=0;
	if($total_reception_xray_collection_card == "") $total_reception_xray_collection_card=0;
	if($total_reception_xray_collection_credit == "") $total_reception_xray_collection_credit=0;
	if($total_reception_xray_collection_upi == "") $total_reception_xray_collection_upi=0;
	  
	$total_reception_xray_collection = $total_reception_xray_collection_cash + $total_reception_xray_collection_card + $total_reception_xray_collection_credit+$total_reception_xray_collection_upi;

	$collections['total_reception_xray_collection_credit']= $total_reception_xray_collection_credit;

	$collections['total_reception_proc_collection_credit']= $total_reception_proc_collection_credit;

    $collections['total_reception_xray_collection']= $total_reception_xray_collection;

    $collections['total_reception_proc_collection']= $total_reception_proc_collection;


	  //ip advance collection

      $wheredata=array();
      $wheredata[0]="date >='".$collection_date_from." 00:00:00'";
      $wheredata[1]="date <='".$collection_date_to." 23:59:59'";
	  $wheredata[2]="status = 0";
	 
	  
	  $ip_collection=$bill_obj->getAdvanceBillConsolidated($wheredata);

	  $ip_advance_cash_collection=$ip_collection[0][0];
	  $ip_advance_card_collection=$ip_collection[0][1];
	  $ip_advance_upi_collection=$ip_collection[0][2];
	  
	  if($ip_advance_cash_collection == "") $ip_advance_cash_collection=0;
	  if($ip_advance_card_collection == "") $ip_advance_card_collection=0;
	  if($ip_advance_upi_collection == "") $ip_advance_upi_collection=0;
	  
	  $total_ip_advance_collection=$ip_advance_cash_collection+$ip_advance_card_collection+$ip_advance_upi_collection;

	  $collections['ip_advance_collection']= $total_ip_advance_collection;



	// X-RAY USER COLLECTION

  	$user_data=array();

  	$user_data[]="user_type='12'";
  
  	$userInfo=$user_obj->getUser('',$user_data);

  	$total_reception_xray_collection = 0;

  	$total_reception_proc_collection = 0;
  
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
	}

    $wheredata=array();
    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
    $wheredata[2]="user_id in $user_id";
	$wheredata[3]="status =0";
	  
	$xray_collection=$bill_obj->getBillConsolidated($wheredata);

	$xray_cash_collection   = $xray_collection[0][0];
	$xray_card_collection   = $xray_collection[0][2];
	$xray_credit_collection = $xray_collection[0][1];
	$xray_upi_collection = $xray_collection[0][4];

	if($xray_cash_collection   == "") $xray_cash_collection=0;
	if($xray_card_collection   == "") $xray_card_collection=0;
	if($xray_credit_collection == "") $xray_credit_collection=0;
	if($xray_upi_collection == "") $xray_upi_collection=0;

	$total_xray_collection=$xray_cash_collection+$xray_card_collection+$xray_credit_collection+$xray_upi_collection;

	$xray_credit_total = $xray_collection[0][1];

  	$collections['total_reception_xray_collection'] = $collections['total_reception_xray_collection']+$total_xray_collection;

  	$collections['total_reception_xray_collection_credit'] = $collections['total_reception_xray_collection_credit']+$xray_credit_total;



	  //nurse procedure
	 
	  $user_data=array();
	  $user_data[]="user_type='11' or user_type='13'";
	  
	  $userInfo=$user_obj->getUser('',$user_data);
	  $total_nurse_collection=0;
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
	      $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	      $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	      $wheredata[2]="user_id in $user_id";
		  $wheredata[3]="status =0";
		  $wheredata[4]="type !='IP'";

		  
		  $nurse_collection=$bill_obj->getBillConsolidated($wheredata);

		  $nurse_cash_collection=$nurse_collection[0][0];
		  $nurse_card_collection=$nurse_collection[0][2];
		  $nurse_upi_collection=$nurse_collection[0][4];
		  $nurse_credit_collection=$nurse_collection[0][1];

		  
		  if($nurse_cash_collection == "") $nurse_cash_collection=0;
		  if($nurse_card_collection == "") $nurse_card_collection=0;
		  if($nurse_upi_collection == "") $nurse_upi_collection=0;
		  if($nurse_credit_collection == "") $nurse_credit_collection=0;
		  
		  $total_nurse_collection=$nurse_cash_collection+$nurse_card_collection+$nurse_upi_collection+$nurse_credit_collection;

		  $nurse_credit_total = $nurse_collection[0][1];
	  }
	  $collections['nurse']= $total_nurse_collection;

	  $collections['nurse_credit_total']= $nurse_credit_total;


	 return $collections;
	  

}

function lab_credit_paid($collection_date_from,$collection_date_to){

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
	  // $wheredata[3]="status =0";

	  $lab_credit_paid=$bill_obj->getCreditBillInfo($wheredata);

	  $sum = 0;

	  if (!empty($lab_credit_paid)) {

	  	
	  	for ($i=0; $i <count($lab_credit_paid) ; $i++) { 
	  		$sum += $lab_credit_paid[$i][3];
	  	}

	  }  

  }

  return $sum;


}

function credit_bills($collection_date_from,$collection_date_to,$type){

	$bill_obj= new Billing();
	$user_obj=new User();

    $wheredata=array();


    $user_data=array();

    if ($type=="XRAY") {
    	$user_data[]="user_type='4'";
    }
    else if ($type=="LAB") {
    	$user_data[]="user_type='6' or user_type='7'";
    }
    else if ($type=="PROCEDURE") {
    	$user_data[]="user_type='4'";
    }
    else if ($type=="THEATER") {
    	$user_data[]="user_type='13'";
    }
    else if ($type=="XRAY_USER") {
    	$user_data[]="user_type='12'";
    }
    else if ($type=="NURSE") {
    	$user_data[]="user_type='11' or user_type='13'";
    }


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


	}

	if (!empty($user_id)) {

		    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
		    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
		    $wheredata[2]="user_id in $user_id";
		    $wheredata[3]="paid_with = 'CREDIT'";
			$wheredata[4]="status =0";
			  
			if ($type=='XRAY') {
				$wheredata[5]="bill_type = 2";
			}
			else if ($type=='PROCEDURE') {
				$wheredata[5]="bill_type = 1";
			}
			else if ($type=='THEATER') {
				$wheredata[5]="type = 'IP'";
			}
			else if ($type=='NURSE') {
				$wheredata[5]="type != 'IP'";
			}

			$credit_bills=$bill_obj->getBillInfo($wheredata);

			$bills="";

			if (!empty($credit_bills)) {


			 	for ($i=0; $i <count($credit_bills) ; $i++) { 
			 		
					if($i == 0 ){
						$bills .="(";
					}
																
					if($i == ((count($credit_bills))-1)){
																
						$bills .=$credit_bills[$i][0].")";
					}else{
						$bills .=$credit_bills[$i][0].",";
					}

			 	}

			}



	}
	else{
		$bills="";
	}



	// var_dump($bills);exit();
	return $bills;


}

function credit_paid($collection_date_from,$collection_date_to,$bill_no){

   $bill_obj= new Billing();
   $user_obj=new User();
   $report_obj=new Report();
   
   $collections=array();

   if (!empty($bill_no)) {

	    $wheredata=array();
	    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	    $wheredata[2]="bill_no in $bill_no";
	    $wheredata[3]="status = 0";

		$credit_paid=$bill_obj->getCreditBillInfo($wheredata);

		$sum = 0;

		  if (!empty($credit_paid)) {

		  	
		  	for ($i=0; $i <count($credit_paid) ; $i++) { 
		  		$sum += $credit_paid[$i][8];
		  		$sum += $credit_paid[$i][9];
		  		$sum += $credit_paid[$i][11];
		  	}

		  }  


   }
   else{
   	$sum=0;
   }




  // var_dump($sum);exit();

  return $sum;


}




function accounting_insertion($collection,$collection_date,$accounting_details){

$acc_obj=new AccountingModel();

 $info['entry_type']=1;
 $info['entry_date']=$collection_date;
 $info['narration']="Collection for the day";


// var_dump($collection);
// var_dump($accounting_details);
// exit();


  //op collection
 if($collection['op_collection'] > 0) {

 	 if ($accounting_details[0][7]==1) {

		 $entry_number=$acc_obj->getEntryNumber(1);
		 $info['number']=$entry_number+1;
		 $info['dr_total']=$collection['op_collection'];
		 $info['cr_total']=$collection['op_collection'];
		 
		 $entry_id=$acc_obj->addEntry($info);
		 
		 $entry_items['entry_id']=$entry_id;
		 $entry_items['amount']=$collection['op_collection'];
		 
		 
		  $entry_items['ledger_id']=$accounting_details[0][3];//cash in hand
		  $entry_items['dc']="D";
		 
		  $ledger_id=$acc_obj->addEntryItems($entry_items);
		  
		  $entry_items['ledger_id']=$accounting_details[0][2];//op Collection
		  $entry_items['dc']="C";
		 
		  $ledger_id=$acc_obj->addEntryItems($entry_items);


 	 }

  }

 //Lab
 if($collection['lab'] > 0) {

 	if ($accounting_details[1][7]==1) {

	 $entry_number=$acc_obj->getEntryNumber(1);
	 $info['number']=$entry_number+1;
	 $info['dr_total']=$collection['lab'];
	 $info['cr_total']=$collection['lab'];
	 
	 $entry_id=$acc_obj->addEntry($info);
	 
	 $entry_items['entry_id']=$entry_id;
	 $entry_items['amount']=$collection['lab'];
	 
	 
	  $entry_items['ledger_id']=$accounting_details[1][3];//cash in hand
	  $entry_items['dc']="D";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);
	  
	  $entry_items['ledger_id']=$accounting_details[1][2];//Lab Collection
	  $entry_items['dc']="C";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);

	}

  }

   // Reception x-ray
 	if($collection['total_reception_xray_collection'] > 0) {

 		if ($accounting_details[2][7]==1) {

			 $entry_number=$acc_obj->getEntryNumber(1);
			 $info['number']=$entry_number+1;
			 $info['dr_total']=$collection['total_reception_xray_collection'];
			 $info['cr_total']=$collection['total_reception_xray_collection'];
			 
			 $entry_id=$acc_obj->addEntry($info);
			 
			 $entry_items['entry_id']=$entry_id;
			 $entry_items['amount']=$collection['total_reception_xray_collection'];
			 
			 
			  $entry_items['ledger_id']=$accounting_details[2][3];//cash in hand
			  $entry_items['dc']="D";
			 
			  $ledger_id=$acc_obj->addEntryItems($entry_items);
			  
			  $entry_items['ledger_id']=$accounting_details[2][2];;//Xray Collection
			  $entry_items['dc']="C";
			 
			  $ledger_id=$acc_obj->addEntryItems($entry_items);

		}

  	}

   // Reception procedure
 	if($collection['total_reception_proc_collection'] > 0) {

 		if ($accounting_details[3][7]==1) {

			 $entry_number=$acc_obj->getEntryNumber(1);
			 $info['number']=$entry_number+1;
			 $info['dr_total']=$collection['total_reception_proc_collection'];
			 $info['cr_total']=$collection['total_reception_proc_collection'];
			 
			 $entry_id=$acc_obj->addEntry($info);
			 
			 $entry_items['entry_id']=$entry_id;
			 $entry_items['amount']=$collection['total_reception_proc_collection'];
			 
			 
			  $entry_items['ledger_id']=$accounting_details[3][3];//cash in hand
			  $entry_items['dc']="D";
			 
			  $ledger_id=$acc_obj->addEntryItems($entry_items);
			  
			  $entry_items['ledger_id']=$accounting_details[3][2];//procedure Collection
			  $entry_items['dc']="C";
			 
			  $ledger_id=$acc_obj->addEntryItems($entry_items);

		}

  	}


 //ip collection
 if($collection['ip_collection'] > 0) {

 	if ($accounting_details[4][7]==1) {

	 $entry_number=$acc_obj->getEntryNumber(1);
	 $info['number']=$entry_number+1;
	 $info['dr_total']=$collection['ip_collection'];
	 $info['cr_total']=$collection['ip_collection'];
	 
	 $entry_id=$acc_obj->addEntry($info);
	 
	 $entry_items['entry_id']=$entry_id;
	 $entry_items['amount']=$collection['ip_collection'];
	 
	 
	  $entry_items['ledger_id']=$accounting_details[4][3];//cash in hand
	  $entry_items['dc']="D";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);
	  
	  $entry_items['ledger_id']=$accounting_details[4][2];//Casuality Collection
	  $entry_items['dc']="C";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);

	}

  }

 //theatre
 if($collection['theatre'] > 0) {

 	if ($accounting_details[5][7]==1) {

	 $entry_number=$acc_obj->getEntryNumber(1);
	 $info['number']=$entry_number+1;
	 $info['dr_total']=$collection['theatre'];
	 $info['cr_total']=$collection['theatre'];
	 
	 $entry_id=$acc_obj->addEntry($info);
	 
	 $entry_items['entry_id']=$entry_id;
	 $entry_items['amount']=$collection['theatre'];
	 
	 
	  $entry_items['ledger_id']=$accounting_details[5][3];//cash in hand
	  $entry_items['dc']="D";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);
	  
	  $entry_items['ledger_id']=$accounting_details[5][2];//Reception Collection
	  $entry_items['dc']="C";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);

	}

  }


 //OP Dr payments
 if($collection['op_dr_payments'] > 0) {

 	if ($accounting_details[6][7]==1) {

	 $entry_number=$acc_obj->getEntryNumber(1);
	 $info['number']=$entry_number+1;
	 $info['dr_total']=$collection['op_dr_payments'];
	 $info['cr_total']=$collection['op_dr_payments'];
	 
	 $entry_id=$acc_obj->addEntry($info);
	 
	 $entry_items['entry_id']=$entry_id;
	 $entry_items['amount']=$collection['op_dr_payments'];
	 
	 
	  $entry_items['ledger_id']=$accounting_details[6][3];//OP Dr payments
	  $entry_items['dc']="D";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);
	  
	  $entry_items['ledger_id']=$accounting_details[6][2];//cash in hand
	  $entry_items['dc']="C";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);

	}

  }


  //ip advance collection
 if($collection['ip_advance_collection'] > 0) {

 	 if ($accounting_details[11][7]==1) {

		 $entry_number=$acc_obj->getEntryNumber(1);
		 $info['number']=$entry_number+1;
		 $info['dr_total']=$collection['ip_advance_collection'];
		 $info['cr_total']=$collection['ip_advance_collection'];
		 
		 $entry_id=$acc_obj->addEntry($info);
		 
		 $entry_items['entry_id']=$entry_id;
		 $entry_items['amount']=$collection['ip_advance_collection'];
		 
		 
		  $entry_items['ledger_id']=$accounting_details[11][3];//cash in hand
		  $entry_items['dc']="D";
		 
		  $ledger_id=$acc_obj->addEntryItems($entry_items);
		  
		  $entry_items['ledger_id']=$accounting_details[11][2];//ip advance Collection
		  $entry_items['dc']="C";
		 
		  $ledger_id=$acc_obj->addEntryItems($entry_items);


 	 }

  }


 //nurse collection
 if($collection['nurse'] > 0) {

 	if ($accounting_details[12][7]==1) {

	 $entry_number=$acc_obj->getEntryNumber(1);
	 $info['number']=$entry_number+1;
	 $info['dr_total']=$collection['nurse'];
	 $info['cr_total']=$collection['nurse'];
	 
	 $entry_id=$acc_obj->addEntry($info);
	 
	 $entry_items['entry_id']=$entry_id;
	 $entry_items['amount']=$collection['nurse'];
	 
	 
	  $entry_items['ledger_id']=$accounting_details[12][3];//cash in hand
	  $entry_items['dc']="D";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);
	  
	  $entry_items['ledger_id']=$accounting_details[12][2];//nurse Collection
	  $entry_items['dc']="C";
	 
	  $ledger_id=$acc_obj->addEntryItems($entry_items);

	}

  }





}

function accounting_insertion_journal($total_credit,$sales_date,$type,$accounting_details){

	$acc_obj=new AccountingModel();

	$info['entry_type']=4;
	$info['entry_date']=$sales_date;
	$info['narration']="Collection for the day";

	if ($type=="LAB") {
		$cr = $accounting_details[7][2];
		$dr = $accounting_details[7][3];
	}
	else if ($type=="XRAY") {
		$cr = $accounting_details[8][2];
		$dr = $accounting_details[8][3];
	}
	else if ($type=="PROCEDURE") {
		$cr = $accounting_details[9][2];
		$dr = $accounting_details[9][3];
	}
	else if ($type=="THEATER") {
		$cr = $accounting_details[10][2];
		$dr = $accounting_details[10][3];
	}
	else if ($type=="NURSE") {
		$cr = $accounting_details[13][2];
		$dr = $accounting_details[13][3];
	}
	else if ($type=="IP_CREDIT") {
		$cr = $accounting_details[14][2];
		$dr = $accounting_details[14][3];
	}


	

 	if (!empty($cr) && !empty($dr) ) {

	 	$entry_number=$acc_obj->getEntryNumber(4);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$total_credit;
		$info['cr_total']=$total_credit;

		$entry_id=$acc_obj->addEntry($info);	

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$total_credit;
		$entry_items['ledger_id']=$cr;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$total_credit;
		$entry_items['ledger_id']=$dr;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);




 	}


}


function accounting_insertion_reciept($pharma_credit_sales,$sales_date,$type,$accounting_details){

	$acc_obj=new AccountingModel();

	$info['entry_type']=1;
	$info['entry_date']=$sales_date;
	$info['narration']="Collection for the day";

	if ($type=="LAB") {
		$dr = $accounting_details[7][2];
		$cr = $accounting_details[7][3];
	}
	else if ($type=="XRAY") {
		$dr = $accounting_details[8][2];
		$cr = $accounting_details[8][3];
	}
	else if ($type=="PROCEDURE") {
		$dr = $accounting_details[9][2];
		$cr = $accounting_details[9][3];
	}
	else if ($type=="THEATER") {
		$dr = $accounting_details[10][2];
		$cr = $accounting_details[10][3];
	}
	else if ($type=="NURSE") {
		$dr = $accounting_details[13][2];
		$cr = $accounting_details[13][3];
	}
	else if ($type=="IP_CREDIT") {
		$dr = $accounting_details[14][2];
		$cr = $accounting_details[14][3];
	}


	

 	if ( !empty($cr) && !empty($dr) ) {

	 	$entry_number=$acc_obj->getEntryNumber(1);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$pharma_credit_sales;
		$info['cr_total']=$pharma_credit_sales;

		$entry_id=$acc_obj->addEntry($info);	

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$cr;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$dr;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


 	}


}


function credit_paid_previous($collection_date_from,$collection_date_to,$bill_no){

   $bill_obj= new Billing();
   $user_obj=new User();
   $report_obj=new Report();
   
   $collections=array();

   if (!empty($bill_no)) {

	    $wheredata=array();
	    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	    $wheredata[2]="bill_no not in $bill_no";
	    $wheredata[3]="status = 0";

		$credit_paid=$bill_obj->getCreditBillInfo($wheredata);

		$sum = 0;

		  if (!empty($credit_paid)) {

		  	
		  	for ($i=0; $i <count($credit_paid) ; $i++) { 
		  		$sum += $credit_paid[$i][8];
		  		$sum += $credit_paid[$i][9];
		  		$sum += $credit_paid[$i][11];
		  	}

		  }  


   }
   else{
   	$sum=0;
   }




  // var_dump($sum);exit();

  return $sum;


}

function accounting_insertion_reciept_previous_days($pharma_credit_sales,$sales_date,$type,$accounting_details){

	$acc_obj=new AccountingModel();

	$info['entry_type']=1;
	$info['entry_date']=$sales_date;
	$info['narration']="Previous days credit paid today";

	if ($type=="LAB") {
		$dr = $accounting_details[7][2];
		$cr = $accounting_details[7][3];
	}
	else if ($type=="XRAY") {
		$dr = $accounting_details[8][2];
		$cr = $accounting_details[8][3];
	}
	else if ($type=="PROCEDURE") {
		$dr = $accounting_details[9][2];
		$cr = $accounting_details[9][3];
	}
	else if ($type=="THEATER") {
		$dr = $accounting_details[10][2];
		$cr = $accounting_details[10][3];
	}
	else if ($type=="IP_CREDIT") {
		$dr = $accounting_details[14][2];
		$cr = $accounting_details[14][3];
	}


	

 	if ( !empty($cr) && !empty($dr) ) {

	 	$entry_number=$acc_obj->getEntryNumber(1);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$pharma_credit_sales;
		$info['cr_total']=$pharma_credit_sales;

		$entry_id=$acc_obj->addEntry($info);	

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$cr;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$dr;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


 	}


}

function ip_credit_bills($collection_date_from,$collection_date_to){

	$bill_obj= new Billing();
	$user_obj=new User();

    $wheredata=array();

	  $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	  $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	  $wheredata[2]="payment_mode = 'CREDIT'";
	  $wheredata[3]="(bill_status !=1 and bill_status!=3)";		  


		$credit_bills=$bill_obj->getIPBillInfo($wheredata);

			$bills="";

			if (!empty($credit_bills)) {


			 	for ($i=0; $i <count($credit_bills) ; $i++) { 
			 		
					if($i == 0 ){
						$bills .="(";
					}
																
					if($i == ((count($credit_bills))-1)){
																
						$bills .=$credit_bills[$i][0].")";
					}else{
						$bills .=$credit_bills[$i][0].",";
					}

			 	}

			}
			else{
				$bills="";
			}



	// var_dump($bills);exit();
	return $bills;

}


function ip_credit_paid($collection_date_from,$collection_date_to,$bill_no){

   $bill_obj= new Billing();
   $user_obj=new User();
   $report_obj=new Report();
   
   $collections=array();

   if (!empty($bill_no)) {

	    $wheredata=array();
	    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	    $wheredata[2]="billid in $bill_no";
	    // $wheredata[3]="status = 0";

		$credit_paid=$bill_obj->getIPCreditPayments($wheredata);

		$sum = 0;

		  if (!empty($credit_paid)) {

		  	
		  	for ($i=0; $i <count($credit_paid) ; $i++) { 
		  		$sum += $credit_paid[$i][4];
		  		$sum += $credit_paid[$i][5];
		  		$sum += $credit_paid[$i][16];
		  	}

		  }  


   }
   else{
   	$sum=0;
   }




  // var_dump($sum);exit();

  return $sum;


}

function ip_credit_paid_previous($collection_date_from,$collection_date_to,$bill_no){

   $bill_obj= new Billing();
   $user_obj=new User();
   $report_obj=new Report();
   
   $collections=array();

   if (!empty($bill_no)) {

	    $wheredata=array();
	    $wheredata[0]="bill_date >='".$collection_date_from." 00:00:00'";
	    $wheredata[1]="bill_date <='".$collection_date_to." 23:59:59'";
	    $wheredata[2]="billid not in $bill_no";
	    // $wheredata[3]="status = 0";

		$credit_paid=$bill_obj->getIPCreditPayments($wheredata);

		$sum = 0;

		  if (!empty($credit_paid)) {

		  	
		  	for ($i=0; $i <count($credit_paid) ; $i++) { 
		  		$sum += $credit_paid[$i][4];
		  		$sum += $credit_paid[$i][5];
		  		$sum += $credit_paid[$i][16];
		  	}

		  }  


   }
   else{
   	$sum=0;
   }




  // var_dump($sum);exit();

  return $sum;


}


