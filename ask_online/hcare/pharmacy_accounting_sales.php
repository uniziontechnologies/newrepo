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
$sales_date = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

$sales_date_from = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

$sales_date_to = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

// $sales_date = date("Y-m-d");

// $sales_date_from = date("Y-m-d");

// $sales_date_to = date("Y-m-d");


$pharma_sales=pharma_sales($sales_date_from,$sales_date_to);

$pharma_sales_gst=pharma_sales_gst($sales_date_from,$sales_date_to);

$accounting_details =$acc_obj_new->getAccountingAutomisePharmaSales();


$gross_amt = $pharma_sales[5]-$pharma_sales_gst[1];

$total_net = $pharma_sales[5]+$pharma_sales[2];

if ( ($pharma_sales[4]+$pharma_sales[6])!=($gross_amt+$pharma_sales_gst[1]+$pharma_sales[2]) ) {
	$diff = ($pharma_sales[4]+$pharma_sales[6])-($gross_amt+$pharma_sales_gst[1]+$pharma_sales[2]);
	$diff = number_format((float)($diff), 2, '.', '');
	$gross_amt = $gross_amt + $diff;
	$total_net = $total_net + $diff;

	// var_dump($gross_amt);
}

if ($accounting_details[0][17]==1) {

	$entry_id = accounting_insertion_entry($total_net,$sales_date);

	if (!empty($entry_id)) {
		
		accounting_insertion_gross($gross_amt,$sales_date,$entry_id,$accounting_details);
		accounting_insertion_gst($pharma_sales_gst[0],$sales_date,$entry_id,$accounting_details);
		accounting_insertion_round_off($pharma_sales[2],$sales_date,$entry_id,$accounting_details);
		accounting_insertion_cr($pharma_sales[4],$sales_date,$entry_id,$accounting_details);

		if ($pharma_sales[6]>0) {
			accounting_insertion_cr_discount($pharma_sales[6],$sales_date,$entry_id,$accounting_details);
		}

	}

}



function pharma_sales($sales_date_from,$sales_date_to){
	
 //pharmacy collection
 
     $pharma_obj=new pharmaFunctions();
	 $total_pharma_collection=0;
	  
     $wheredata=array();
     $wheredata[0]="bill_date >='".$sales_date_from." 00:00:00'";
     $wheredata[1]="bill_date <='".$sales_date_to." 23:59:59'";
	 $wheredata[2]="status = 0";
	 $wheredata[3]="sales_mode = 'Sales'";
	 
	  $pharma_collection=$pharma_obj->getpharmaSaleConsolidated($wheredata);
	  
	  $pharma_cash_collection=$pharma_collection[0][0];
	  $pharma_card_collection=$pharma_collection[0][1];
	  $pharma_cheque_collection=$pharma_collection[0][2];
	  $pharma_round_0ff_collection=$pharma_collection[0][5];
	  $pharma_gst_collection=$pharma_collection[0][6];
	  $pharma_upi_collection=$pharma_collection[0][9];
	  
	  if($pharma_cash_collection == "") $pharma_cash_collection=0;
	  if($pharma_card_collection == "") $pharma_card_collection=0;
	  if($pharma_cheque_collection == "") $pharma_cheque_collection=0;
	  if($pharma_upi_collection == "") $pharma_upi_collection=0;

	  $total_pharma_collection=array();

	  $total_pharma_collection[0]=number_format((float)($pharma_collection[0][4]), 2, '.', '');
	  $total_pharma_collection[1]=number_format((float)($pharma_collection[0][5]-$pharma_round_0ff_collection-$pharma_gst_collection), 2, '.', '') ;
	  $total_pharma_collection[2]=number_format((float)($pharma_round_0ff_collection), 2, '.', '');;
	  $total_pharma_collection[4]=number_format((float)$pharma_collection[0][4], 2, '.', '');
	  $total_pharma_collection[5]=number_format((float)($pharma_collection[0][7]), 2, '.', '');
	  $total_pharma_collection[6]=number_format((float)($pharma_collection[0][8]), 2, '.', '');
	 
	 return $total_pharma_collection;	
}

function pharma_sales_gst($sales_date_from,$sales_date_to){
	
	$pharma_obj=new pharmaFunctions();

	 if (!empty($sales_date_from) && !empty($sales_date_to)) {
	 	

	 		$sales_gst_per =$pharma_obj->getSalesBillGst($sales_date_from,$sales_date_to);

	 		if (!empty($sales_gst_per)) {

	 			$total_gst = array();
	 			
	 			for ($i=0; $i <count($sales_gst_per) ; $i++) { 
	 				

	 				$pharma_sales_gst[$i] = $pharma_obj->getSalesBillGstAmount($sales_gst_per[$i],$sales_date_from,$sales_date_to);
	 	

	 				$total_gst[] = ($pharma_sales_gst[$i][0][0] + $pharma_sales_gst[$i][0][1]);

	 			}



	 		}


	 }
	 
	 
	 $data = array();

	 $data[0] = $pharma_sales_gst;
	 $data[1] = number_format((float)(array_sum($total_gst)), 2, '.', '');

	 return $data;	
}


function accounting_insertion_entry($pharma_sales,$sales_date){

$acc_obj=new AccountingModel();

 $info['entry_type']=1;
 $info['entry_date']=$sales_date;
 $info['narration']="Collection for the day";

 $collection_ledger_id = 36;

 $sum = 0;
 
	//pharmacy Sales Amount Without gst

 	if (!empty($collection_ledger_id)) {

	 	$entry_number=$acc_obj->getEntryNumber(1);
	 	$info['number']=$entry_number+1;
		$info['dr_total']=$pharma_sales;
		$info['cr_total']=$pharma_sales;

		$entry_id=$acc_obj->addEntry($info);			 

		return $entry_id;

 	}

}

function accounting_insertion_gross($pharma_sales,$sales_date,$entry_id,$accounting_details){

$acc_obj=new AccountingModel();

 $info['entry_type']=1;
 $info['entry_date']=$sales_date;
 $info['narration']="Collection for the day";

 $collection_ledger_id = $accounting_details[0][2];

 $sum = 0;
 
	//pharmacy Sales Amount Without gst

 	if (!empty($collection_ledger_id)) {


	 // 	$entry_number=$acc_obj->getEntryNumber(1);
	 // 	$info['number']=$entry_number+1;
		// $info['dr_total']=$sum_net;
		// $info['cr_total']=$sum_net;

		// $entry_id=$acc_obj->addEntry($info);			 


		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_sales;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);

		// return $entry_id;

 	}

}

function accounting_insertion_gst($pharma_sales_gst,$sales_date,$entry_id,$accounting_details){

$acc_obj=new AccountingModel();

 $collection_ledger_id = 36;

 $sum = 0;
 
	//pharmacy Sales gst

 	if (!empty($collection_ledger_id)) {

	 	for ($i=0; $i <count($pharma_sales_gst) ; $i++) {

	 		// for ($j=0; $j <count($pharma_sales_gst[$i]) ; $j++) { 


	 		if ($pharma_sales_gst[$i][0][8]=="5") {
	 			$cgst_ledger_id[$i] = $accounting_details[0][3]; 
	 			$sgst_ledger_id[$i] = $accounting_details[0][4]; 
	 		}
	 		else if ($pharma_sales_gst[$i][0][8]=="12") {
	 			$cgst_ledger_id[$i] = $accounting_details[0][5]; 
	 			$sgst_ledger_id[$i] = $accounting_details[0][6]; 
	 		}
	 		else if ($pharma_sales_gst[$i][0][8]=="18") {
	 			$cgst_ledger_id[$i] = $accounting_details[0][7]; 
	 			$sgst_ledger_id[$i] = $accounting_details[0][8]; 
	 		}
	 		else if ($pharma_sales_gst[$i][0][8]=="28") {
	 			$cgst_ledger_id[$i] = $accounting_details[0][9]; 
	 			$sgst_ledger_id[$i] = $accounting_details[0][10]; 
	 		}

		 		// $cgst_ledger_id[$i]=$pharma_sales_gst[$i][0][5];
		 		// $sgst_ledger_id[$i]=$pharma_sales_gst[$i][0][6];


		 		$cgst_amount[$i]=$pharma_sales_gst[$i][0][0];
		 		$sgst_amount[$i]=$pharma_sales_gst[$i][0][1];

		 		if (!empty($cgst_ledger_id[$i])) {

					$entry_items['entry_id']=$entry_id;
					$entry_items['amount']=$cgst_amount[$i];	

					$entry_items['ledger_id']=$cgst_ledger_id[$i];
					$entry_items['dc']="C";	

					$ledger_id=$acc_obj->addEntryItems($entry_items);	
		 			
		 		}

		 		if (!empty($sgst_ledger_id[$i])) {

					$entry_items['entry_id']=$entry_id;
					$entry_items['amount']=$sgst_amount[$i];	

					$entry_items['ledger_id']=$sgst_ledger_id[$i];
					$entry_items['dc']="C";	

					$ledger_id=$acc_obj->addEntryItems($entry_items);	
		 			
		 		}

	 		// }

	 	}


 	}

}

function accounting_insertion_round_off($pharma_sales,$sales_date,$entry_id,$accounting_details){

$acc_obj=new AccountingModel();

 $collection_ledger_id = $accounting_details[0][11];

 $sum = 0;
 
	//pharmacy Sales Amount Without gst

 	if (!empty($collection_ledger_id)) {
		 

		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_sales;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="C";

		$ledger_id=$acc_obj->addEntryItems($entry_items);

 	}

}

function accounting_insertion_cr($pharma_sales,$sales_date,$entry_id,$accounting_details){

$acc_obj=new AccountingModel();

 $info['entry_type']=1;
 $info['entry_date']=$sales_date;
 $info['narration']="Collection for the day";

 $collection_ledger_id = $accounting_details[0][12];

 $sum = 0;
 
	//pharmacy Sales Amount Without gst

 	if (!empty($collection_ledger_id)) {
	 
		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$pharma_sales;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


 	}

}

function accounting_insertion_cr_discount($discount,$sales_date,$entry_id,$accounting_details){

$acc_obj=new AccountingModel();

 $info['entry_type']=1;
 $info['entry_date']=$sales_date;
 $info['narration']="Collection for the day";

 $collection_ledger_id = $accounting_details[0][13];

 $sum = 0;
 
	//pharmacy Sales Discount

 	if (!empty($collection_ledger_id)) {
	 
		$entry_items['entry_id']=$entry_id;
		$entry_items['amount']=$discount;
		$entry_items['ledger_id']=$collection_ledger_id;
		$entry_items['dc']="D";

		$ledger_id=$acc_obj->addEntryItems($entry_items);


 	}

}





?>
