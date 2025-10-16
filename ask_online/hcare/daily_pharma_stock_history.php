<?php 



define('ROOT_PATH', dirname( dirname(__FILE__) )."/hcare");

require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';

$today_date = date("Y-m-d");
$insert_date= date('Y-m-d', strtotime( $today_date . ' -1 day' ));
//$collection_date="2016-12-17";

// $insert_date= date('Y-m-d');

$pharma = new PharmaFunctions();

$main_stock = 0;
$main_buyp = 0;
$main_sellp = 0;

$branch_stock = 0;
$branch_buyp = 0;
$branch_sellp = 0;

$wheredata=array();
$wheredata[0]="batch_stock >0";
$wheredata[1]="status =0";

$batch_stock = $pharma->pharma_get_batch_details($wheredata);

if (!empty($batch_stock)) {
	
	for ($i=0; $i < count($batch_stock) ; $i++) { 
		
		if ($batch_stock[$i][4] > 0) {
		

			$branch_stock += $batch_stock[$i][5];

			$branch_buyp += ($batch_stock[$i][2]*$batch_stock[$i][5]);

			$branch_sellp += ($batch_stock[$i][1]*$batch_stock[$i][5]);



		}
		else{


			$main_stock += $batch_stock[$i][5];

			$main_buyp += ($batch_stock[$i][2]*$batch_stock[$i][5]);

			$main_sellp += ($batch_stock[$i][1]*$batch_stock[$i][5]);


		}

	}

	$pharma->pharma_daily_stock_history($insert_date,$main_stock,$main_sellp,$main_buyp,$branch_stock,$branch_sellp,$branch_buyp);

}



