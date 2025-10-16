<?php 
define('ROOT_PATH',dirname(__FILE__) );

require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';
require_once ROOT_PATH . '/lib/model/admin/accounting.php';

$acc_obj_new = new Accounting();


$today_date = date("Y-m-d");
$sales_date = date('Y-m-d', strtotime( $today_date . ' -1 day' ));//this only
// $sales_date = date("Y-m-d");

$accounting_details =$acc_obj_new->getAccountingAutomisePharmaSales();


// $sales_date = date('Y-m-d');
 //$sales_date="2019-10-31";

$pharma_total_credit = pharma_total_credit($sales_date);

$pharma_credit_sales = pharma_credit_sales($sales_date);

$total_credit = $pharma_total_credit - $pharma_credit_sales;

if ($accounting_details[0][17]==1) {

	if ($pharma_total_credit>0) {
		accounting_insertion_journal($pharma_total_credit,$sales_date,$accounting_details);
	}

	if ($pharma_credit_sales>0) {
		accounting_insertion_reciept($pharma_credit_sales,$sales_date,$accounting_details);
	}

}



function pharma_credit_sales($sales_date){
	
 //pharmacy collection
 
     $pharma_obj=new pharmaFunctions();

	 $total_pharma_collection=0;
	  
     $wheredata=array();
     $wheredata[0]="date >='".$sales_date." 00:00:00'";
     $wheredata[1]="date <='".$sales_date." 23:59:59'";
	 $wheredata[2]="status = 0";
	 // $wheredata[3]="branch_id = 1";
	 
	 $pharma_collection_credit=$pharma_obj->InvoiceCreditPaymentSales($wheredata);

	 if (!empty($pharma_collection_credit)) {
	 	
	 	for ($i=0; $i <count($pharma_collection_credit) ; $i++) { 
	 		
	 		$total_pharma_collection+=($pharma_collection_credit[$i][3]+$pharma_collection_credit[$i][9]+$pharma_collection_credit[$i][10]);

	 	}

	 }
	 
	 return $total_pharma_collection;	

}

function pharma_total_credit($sales_date){
	
 //pharmacy collection
 
     $pharma_obj=new pharmaFunctions();

	 $total_pharma_collection=0;
	  
     $wheredata=array();
     $wheredata[0]="bill_date >='".$sales_date." 00:00:00'";
     $wheredata[1]="bill_date <='".$sales_date." 23:59:59'";
	 $wheredata[2]="payment_mode = 'CREDIT'";
	 // $wheredata[3]="branch_id = 1";
	 $wheredata[3]="status = 0";
	 
	 $pharma_collection_credit=$pharma_obj->getpharmaSaleConsolidated($wheredata);


	 if (!empty($pharma_collection_credit)) {
	 	
	 	$total_pharma_collection=number_format((float)($pharma_collection_credit[0][3]), 2, '.', '');

	 }
	 
	 return $total_pharma_collection;	

}


function accounting_insertion_reciept($pharma_credit_sales,$sales_date,$accounting_details){

	$acc_obj=new AccountingModel();

	$info['entry_type']=1;
	$info['entry_date']=$sales_date;
	$info['narration']="Collection for the day";

	$collection_ledger_id = $accounting_details[0][18];

 	if (!empty($collection_ledger_id)) {

	 	$entry_number=$acc_obj->getEntryNumber(1);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$pharma_credit_sales;
		$info['cr_total']=$pharma_credit_sales;

		$entry_id=$acc_obj->addEntry($info);	

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_credit_sales;
		$entry_items['ledger_id']=$accounting_details[0][12];
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


 	}


}


function accounting_insertion_journal($total_credit,$sales_date,$accounting_details){

	$acc_obj=new AccountingModel();

	$info['entry_type']=4;
	$info['entry_date']=$sales_date;
	$info['narration']="Collection for the day";

	$collection_ledger_id = $accounting_details[0][18];

 	if (!empty($collection_ledger_id)) {

	 	$entry_number=$acc_obj->getEntryNumber(4);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$total_credit;
		$info['cr_total']=$total_credit;

		$entry_id=$acc_obj->addEntry($info);	

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$total_credit;
		$entry_items['ledger_id']=$accounting_details[0][12];
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$total_credit;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);




 	}


}



?>