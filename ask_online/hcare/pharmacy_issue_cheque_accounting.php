<?php 
define('ROOT_PATH',dirname(__FILE__) );

require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';


$today_date = date("Y-m-d");
$cheque_payment_date = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

// $cheque_payment_date = date("Y-m-d");

$cheque_payments = chequePayments($cheque_payment_date);

// var_dump($cheque_payments);
if (!empty($cheque_payments)) {
	
	accounting_insertion_cheque_payments($cheque_payments,$cheque_payment_date);

}


function chequePayments($cheque_payment_date){
	
	$pharma_obj=new pharmaFunctions();
 	 
 		$wheredata=array();

    	$wheredata[0]="cheque_issue_date ='".$cheque_payment_date."'";
		$wheredata[1]="status = 0";
		$wheredata[2]="payment_mode = 'CHEQUE'";
		$wheredata[3]="checque_no != '0'";
		$wheredata[4]="checque_amt != '0'"; 

		$cheque_payments_payments = $pharma_obj->getChequePayments($wheredata);

		return $cheque_payments_payments;	
}


function accounting_insertion_cheque_payments($cheque_payments,$cheque_payment_date){

	$acc_obj=new AccountingModel();

 	if (!empty($cheque_payments)) {
	
		$entry_number=$acc_obj->getEntryNumber(2);
		$entry_number=$entry_number+1;
		 
 		for ($i=0; $i <count($cheque_payments) ; $i++) { 	

 			$supplier_ledger_id=$cheque_payments[$i][7];

 			$info['number']=$entry_number++;

 			if (!empty($supplier_ledger_id)) {

 					if (!empty($cheque_payments[$i][4])) {
 							$case = " for bill No. ".$cheque_payments[$i][4]."";
 					}
 					else{
 							$case = "";
 					}

 					$info['narration']="Cheque payment issued for ".$cheque_payments[$i][6].$case.""; 

                    $info['entry_date'] = date("Y-m-d",strtotime($cheque_payments[$i][3]));
					$info['dr_total']   = $cheque_payments[$i][2];
					$info['cr_total']   = $cheque_payments[$i][2];

					$info['entry_type']=2;

					$info['rec_id'] = $cheque_payments[$i][0];
							 
					$entry_id=$acc_obj->addEntry($info);			 

					$entry_items['entry_id']=$entry_id;
					$entry_items['amount']=$cheque_payments[$i][2];	//amount paid cash	

					$entry_items['ledger_id']=$supplier_ledger_id;//purchase Medicine
					$entry_items['dc']="D";	

					$ledger_id=$acc_obj->addEntryItems($entry_items);	

					$entry_items['ledger_id']=$cheque_payments[$i][8];//supplier
					$entry_items['dc']="C";
					 
					$ledger_id=$acc_obj->addEntryItems($entry_items);



 			}

 		}

 }



}