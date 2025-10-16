<?php 
define('ROOT_PATH',dirname(__FILE__) );

require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';


$today_date = date("Y-m-d");
$credit_payment_date = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

// $credit_payment_date = "2025-05-19";

$pharma_credit_payments = creditPpayments($credit_payment_date);


if (!empty($pharma_credit_payments)) {
	
	accounting_insertion_credit_payments($pharma_credit_payments,$credit_payment_date);

}


function creditPpayments($credit_payment_date){
	
	$pharma_obj=new pharmaFunctions();
 	 
 		$wheredata=array();
    	$wheredata[0]="date LIKE '%".$credit_payment_date."%'";
		$wheredata[1]="status = 0"; 

		$purchase_credit_payments = $pharma_obj->getCreditPayments($wheredata);

		return $purchase_credit_payments;	
}


function accounting_insertion_credit_payments($pharma_credit_payments,$credit_payment_date){

	$acc_obj=new AccountingModel();

 	if (!empty($pharma_credit_payments)) {
	
		$entry_number=$acc_obj->getEntryNumber(2);
		$entry_number=$entry_number+1;
		 

 		for ($i=0; $i <count($pharma_credit_payments) ; $i++) { 

 			if ($pharma_credit_payments[$i][13]=="Recievings") {


 			$supplier_ledger_id=$pharma_credit_payments[$i][11];

 			$info['number']=$entry_number++;

 			if (!empty($supplier_ledger_id)) {

 					if (!empty($pharma_credit_payments[$i][8])) {
 							$case = " for bill No. ".$pharma_credit_payments[$i][8]."";
 					}
 					else{
 							$case = "";
 					}

 					$info['narration']="Credit paid for ".$pharma_credit_payments[$i][10].$case.""; 

                    $info['entry_date'] = date("Y-m-d",strtotime($credit_payment_date));
					$info['dr_total']   = $pharma_credit_payments[$i][2]+$pharma_credit_payments[$i][15]+$pharma_credit_payments[$i][16];
					$info['cr_total']   = $pharma_credit_payments[$i][2]+$pharma_credit_payments[$i][15]+$pharma_credit_payments[$i][16];

					$info['entry_type']=2;

					$info['rec_id'] = $pharma_credit_payments[$i][1];
							 
					$entry_id=$acc_obj->addEntry($info);			 

					$entry_items['entry_id']=$entry_id;
					$entry_items['amount']=$pharma_credit_payments[$i][2]+$pharma_credit_payments[$i][15]+$pharma_credit_payments[$i][16];	//amount paid cash	

					// $entry_items['ledger_id']=$supplier_ledger_id;//purchase Medicine

					if ($pharma_credit_payments[$i][14]=="CASH") {
						$entry_items['ledger_id']=1;
					}
					else{
						$entry_items['ledger_id']=394;//bank account
					}


					$entry_items['dc']="C";	

					$ledger_id=$acc_obj->addEntryItems($entry_items);	

					$entry_items['ledger_id']=$supplier_ledger_id;//supplier
					$entry_items['dc']="D";
					 
					$ledger_id=$acc_obj->addEntryItems($entry_items);

					// var_dump($pharma_credit_payments[$i]);

 			}

 		}


 	}

 }



}