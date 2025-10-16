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

$purchase_date_from = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

$purchase_date_to = date('Y-m-d', strtotime( $today_date . ' -1 day' ));

// $purchase_date_from = "2025-05-19";

// $purchase_date_to = "2025-05-19";


$accounting_details =$acc_obj_new->getAccountingAutomisePharmaPurchaseReturn();

$pharma_purchase=pharma_purchase($purchase_date_from,$purchase_date_to);
// var_dump($pharma_purchase);
// exit();
$pharma_purchase_gst=pharma_purchase_gst($purchase_date_from,$purchase_date_to,$pharma_purchase);

$entry_id_array = accounting_insertion_purchase_supplier($pharma_purchase,$purchase_date_from,$purchase_date_to,$pharma_purchase_gst,$accounting_details);


function pharma_purchase($purchase_date_from,$purchase_date_to){
	
	$pharma_obj=new pharmaFunctions();
	
   $purchase_entry=array();
	
	 //purchase entry

	 $total_purchase_entry_collection=array();
 	 
 	 $wheredata=array();
     $wheredata[0]="entry_date >='".$purchase_date_from." 00:00:00'";
     $wheredata[1]="entry_date <='".$purchase_date_to." 23:59:59'";
	 $wheredata[2]="status = 0"; 
	 $wheredata[3]="online_status = 0"; 
	 $wheredata[4]="acc_entry_id = 0"; 
	 $wheredata[5]="purchase_mode = 'Return'";

	 $purchase_entry_collection=$pharma_obj->getRecievingsBill($wheredata);
	 
	
	 for ($i=0; $i <count($purchase_entry_collection) ; $i++) { 
 
	  $purchase_entry[$i]= $purchase_entry_collection[$i];

		  if (!empty($purchase_entry[$i])) {
		  	
		  	$itemInfo[$i] = $pharma_obj->getRecievingsBillItem($purchase_entry[$i][8]);

		  	if (!empty($itemInfo[$i])) {
		  		
		  		for ($j=0; $j < count($itemInfo[$i]) ; $j++) { 
		  			
		  			if ($itemInfo[$i][$j][2] > 0) {
		  				
		  				$purchase_entry[$i][24] = "YES";

		  			}

		  		}

		  	}



		  }


	 }
	 // var_dump($purchase_entry);
	 // exit();
	 
	 return $purchase_entry;	
}



function pharma_purchase_gst($purchase_date_from,$purchase_date_to,$pharma_purchase){
	
	$pharma_obj=new pharmaFunctions();
	
   $purchase_entry=array();
	
	 //purchase entry

	 $total_purchase_entry_collection=array();
 	 
 	 $wheredata=array();

	 if (!empty($pharma_purchase)) {
	 	
	 	for ($i=0; $i < count($pharma_purchase); $i++) { 
	 	
	 		$bill_id[$i] = $pharma_purchase[$i][8];

	 		$wheredata[0]="bill_id = '".$bill_id[$i]."'"; 
	 		$wheredata[1]="status = 0"; 

	 		$purchase_entry_gst[$i]=$pharma_obj->getRecievingsBillGst($bill_id[$i]);

	 		if (!empty($purchase_entry_gst[$i])) {
	 			
	 			for ($j=0; $j <count($purchase_entry_gst[$i]) ; $j++) { 
	 				
	 				$wheredata[0]="bill_id = '".$bill_id[$i]."'"; 
	 				$wheredata[1]="gst_per = '".$purchase_entry_gst[$i][$j]."'"; 
	 				$wheredata[2]="status = 0"; 
	 				// var_dump($wheredata);
	 				$pharma_purchase_gst[$i][$j] = $pharma_obj->getRecievingsBillGstAmount($bill_id[$i],$purchase_entry_gst[$i][$j]);
	 				

	 			}

	 		}



	 	}


	 }
	 
	 return $pharma_purchase_gst;	
}




function accounting_insertion_purchase_supplier($pharma_purchase,$purchase_date_from,$purchase_date_to,$pharma_purchase_gst,$accounting_details){

$acc_obj=new AccountingModel();
$pharma_obj=new pharmaFunctions();


 //purchase entry
 	if (!empty($pharma_purchase)) {

		
		 // $info['narration']="Pharmacy Medicine Purchase"; 		

		 $entry_number=$acc_obj->getEntryNumber(1);
		 $entry_number=$entry_number+1;

		 
		 
		 $entry_info=array();
		 $k=0;

 		for ($i=0; $i <count($pharma_purchase) ; $i++) { 	

 			$info['number']=$entry_number++;

 			$supplier_ledger_id=$pharma_purchase[$i][7];

 			

 			if (!empty($supplier_ledger_id)) {

 				

 						if (!empty($pharma_purchase[$i][9])) {
 							$case = " for bill No. ".$pharma_purchase[$i][9]." ";
 						}
 						else{
 							$case = "";
 						}


 						// if (!empty($pharma_purchase[$i][15]) && $pharma_purchase[$i][15]==1 ) {
 						// 	$net_amount[$i]=$pharma_purchase[$i][4];
 						// }
 						// else{
 						// 	$net_amount[$i]=$pharma_purchase[$i][17];
 						// }

 						if (!empty($pharma_purchase[$i][18])) {
 							$net_amount[$i]=$pharma_purchase[$i][20];
 						}
 						else{
 							$net_amount[$i]=$pharma_purchase[$i][4];
 						}

 						
 						if (!empty($pharma_purchase[$i][24]) && $pharma_purchase[$i][24]=="YES") {
 							$pharma_purchase[$i][21]=$pharma_purchase[$i][23];
 						}
 						else{
 							$pharma_purchase[$i][21]=$pharma_purchase[$i][21];
 						}



 						$info['narration']="Medicine purchase return for supplier ".$pharma_purchase[$i][10].$case." "; 	

						if ($pharma_purchase[$i][14]=="CASH") {

							//cash amount
                             $info['entry_date']=$pharma_purchase[$i][6];
							 $info['dr_total']=$net_amount[$i];
							 $info['cr_total']=$net_amount[$i];

                             //payment entry purchase medicine to supplier						 

							 $info['entry_type']=2;

							 $info['rec_id'] = $pharma_purchase[$i][8];
							 

							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][4];	//amount paid cash	


					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					         $entry_items['dc']="D";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);


					   		/********** PURCAHSE AMOUNT *************/

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][21];	//amount paid cash	

					  		 $entry_items['ledger_id']=$accounting_details[0][2];//purchase Medicine
					  	 	 $entry_items['dc']="C";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

						    /********** PURCAHSE AMOUNT *************/


						    /********** GST AMOUNT      *************/

						    for ($j=0; $j <count($pharma_purchase_gst[$i]) ; $j++) { 

						    	 // $cgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][5];
						    	 // $sgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][6];


						 		if ($pharma_purchase_gst[$i][$j][0][8]=="5") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][3]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][4]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="12") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][5]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][6]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="18") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][7]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][8]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="28") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][9]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][10]; 
						 		}


						    	 if (!empty($cgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][0];//cgst	

							  		 $entry_items['ledger_id']=$cgst_ledger_id[$i][$j];//purchase Medicine
							  	 	 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	
						    	 }

						    	 if (!empty($sgst_ledger_id[$i][$j])) {

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][1];//sgst	

							  		 $entry_items['ledger_id']=$sgst_ledger_id[$i][$j];//purchase Medicine
							  	 	 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);

						    	 }

	
						    }

						     /********** GST AMOUNT      *************/

					   		 /********** ROUND OFF AMOUNT *************/

							if ( $pharma_purchase[$i][14]=="CASH" && $pharma_purchase[$i][15]==1 ) {
									
									$ledger_id_1 = $accounting_details[0][11];

									if (!empty($ledger_id_1) ) {

										$entry_items['entry_id']=$entry_id;

										if (!empty($pharma_purchase[$i][18])) {

									  		 if ($pharma_purchase[$i][13]>0) {

									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=0-$pharma_purchase[$i][13];
									  		 }
									  		 else{

									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=abs($pharma_purchase[$i][13]);
									  		 }


										}
										else{


									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=$pharma_purchase[$i][13];

										}



									 	//amount paid cash	

							  			$entry_items['ledger_id']=$ledger_id_1;//purchase Medicine							  	 	 
							  	 		$ledger_id=$acc_obj->addEntryItems($entry_items);	
									}
		                           						
							}

						    /********** ROUND OFF AMOUNT *************/

					   		/********** Discount AMOUNT *************/

					   		$discount_ledger = $accounting_details[0][12];

					   		if (!empty($discount_ledger) && !empty($pharma_purchase[$i][18]) ) {
					   		

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=abs($pharma_purchase[$i][18]);	//amount paid cash	

							  		 $entry_items['ledger_id']=$discount_ledger;//purchase Medicine

									 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	


					   		}


						    /********** Discount AMOUNT *************/


					   		/********** FRIEGHT AMOUNT *************/

					   		 if (!empty($pharma_purchase[$i][22])) {

								 $entry_items['entry_id']=$entry_id;
								 $entry_items['amount']=$pharma_purchase[$i][22];	//frieght

						  		 $entry_items['ledger_id']=463;//frieght
						  	 	 $entry_items['dc']="D";	

						  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   		 }

						    /********** FRIEGHT AMOUNT *************/
						}
						if ( $pharma_purchase[$i][14]=="CREDIT CARD" ) {
							
							//card amount
                           
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$net_amount[$i];
							 $info['cr_total']=$net_amount[$i];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;

							 $info['rec_id'] = $pharma_purchase[$i][8];
							
							 $entry_id_1[0]=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id_1[0];
							 $entry_items['amount']=$pharma_purchase[$i][4];//card amount given	


					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);



					   		/********** PURCAHSE AMOUNT *************/

							 $entry_items['entry_id']=$entry_id_1[0];
							 $entry_items['amount']=$pharma_purchase[$i][21];//card amount given	

					  		 $entry_items['ledger_id']=$accounting_details[0][2];//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

						    /********** PURCAHSE AMOUNT *************/

						    /********** GST AMOUNT      *************/

						    for ($j=0; $j <count($pharma_purchase_gst[$i]) ; $j++) { 

						    	 // $cgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][5];
						    	 // $sgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][6];


						 		if ($pharma_purchase_gst[$i][$j][0][8]=="5") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][3]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][4]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="12") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][5]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][6]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="18") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][7]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][8]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="28") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][9]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][10]; 
						 		}


						    	 if (!empty($cgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][0];//cgst	

							  		 $entry_items['ledger_id']=$cgst_ledger_id[$i][$j];//purchase Medicine
							  	 	 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

						    	 if (!empty($sgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][1];//sgst amount

							  		 $entry_items['ledger_id']=$sgst_ledger_id[$i][$j];//sgst ledger
							  	 	 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

	
						    }

						     /********** GST AMOUNT      *************/

					   		 /********** ROUND OFF AMOUNT *************/

							if ( $pharma_purchase[$i][14]=="CREDIT CARD" && $pharma_purchase[$i][15]==1 ) {
									
									$ledger_id_1 = $accounting_details[0][11];

									if (!empty($ledger_id_1) ) {

										$entry_items['entry_id']=$entry_id_1[0];

										if (!empty($pharma_purchase[$i][18])) {

									  		 if ($pharma_purchase[$i][13]>0) {

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=0-$pharma_purchase[$i][13];
									  		 }
									  		 else{

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=abs($pharma_purchase[$i][13]);
									  		 }


										}
										else{


									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=$pharma_purchase[$i][13];

										}



									 	//amount paid cash	

							  			$entry_items['ledger_id']=$ledger_id_1;//purchase Medicine							  	 	 
							  	 		$ledger_id=$acc_obj->addEntryItems($entry_items);	
									}
		                           						
							}

						    /********** ROUND OFF AMOUNT *************/

							 

 					   		/********** Discount AMOUNT *************/

					   		$discount_ledger = $accounting_details[0][12];

					   		if (!empty($discount_ledger) && !empty($pharma_purchase[$i][18]) ) {
					   		

									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=abs($pharma_purchase[$i][18]);	//amount paid cash	

							  		 $entry_items['ledger_id']=$discount_ledger;//purchase Medicine

									 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	


					   		}


						    /********** Discount AMOUNT *************/

					   		/********** FRIEGHT AMOUNT *************/

					   		 if (!empty($pharma_purchase[$i][22])) {

								 $entry_items['entry_id']=$entry_id_1[0];
								 $entry_items['amount']=$pharma_purchase[$i][22];	//frieght

						  		 $entry_items['ledger_id']=463;//frieght
						  	 	 $entry_items['dc']="D";	

						  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   		 }

						    /********** FRIEGHT AMOUNT *************/
							  //payment entry purchase medicine to bank account						 

							 $info['entry_type']=2;

							 $info['dr_total'] = $pharma_purchase[$i][4];
							 $info['cr_total'] = $pharma_purchase[$i][4];

							 $info['rec_id'] = $pharma_purchase[$i][8];
							 
							 $entry_id_1[1]=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id_1[1];
							 $entry_items['amount']=$pharma_purchase[$i][4];//card amount given


					         $entry_items['ledger_id']=$accounting_details[0][13];//bank account
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);


							$entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
							$entry_items['dc']="D";
							 
							$ledger_id=$acc_obj->addEntryItems($entry_items);
											 
                           						
						}
						if ( $pharma_purchase[$i][14]=="CHEQUE" ) {
							
							//cheque amt
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$net_amount[$i];
							 $info['cr_total']=$net_amount[$i];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;

							 $info['rec_id'] = $pharma_purchase[$i][8];
							
							 $entry_id=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][4];//cheque amount given	
	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);



					        /********** Purchase Amount  *************/

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][21];//cheque amount given	

					  		 $entry_items['ledger_id']=$accounting_details[0][2];//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					        /********** Purchase Amount  *************/

					        /********** Gst Amount  *************/

						    for ($j=0; $j <count($pharma_purchase_gst[$i]) ; $j++) { 

						    	 // $cgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][5];
						    	 // $sgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][6];

						 		if ($pharma_purchase_gst[$i][$j][0][8]=="5") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][3]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][4]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="12") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][5]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][6]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="18") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][7]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][8]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="28") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][9]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][10]; 
						 		}


						    	 if (!empty($cgst_ledger_id[$i][$j])) {

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][0];//cgst amount	

							  		 $entry_items['ledger_id']=$cgst_ledger_id[$i][$j];//purchase medicine
							  	 	 $entry_items['dc']="D";		

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	
						    	 }

						    	 if (!empty($sgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][1];//sgst amount

							  		 $entry_items['ledger_id']=$sgst_ledger_id[$i][$j];//sgst ledger
							  	 	 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	
						    	 }

						    }

					        /********** Gst Amount  *************/

					   		/********** ROUND OFF AMOUNT *************/

							if ( $pharma_purchase[$i][14]=="CHEQUE" && $pharma_purchase[$i][15]==1 ) {
			 
								$ledger_id_1 = $accounting_details[0][11];

									if (!empty($ledger_id_1) ) {

										$entry_items['entry_id']=$entry_id;

										if (!empty($pharma_purchase[$i][18])) {

									  		 if ($pharma_purchase[$i][13]>0) {

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=0-$pharma_purchase[$i][13];
									  		 }
									  		 else{

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=abs($pharma_purchase[$i][13]);
									  		 }


										}
										else{


									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=$pharma_purchase[$i][13];

										}



									 	//amount paid cash	

							  			$entry_items['ledger_id']=$ledger_id_1;//purchase Medicine							  	 	 
							  	 		$ledger_id=$acc_obj->addEntryItems($entry_items);	
									}


		                           						
							}

						    /********** ROUND OFF AMOUNT *************/

 					   		/********** Discount AMOUNT *************/

					   		$discount_ledger = $accounting_details[0][12];

					   		if (!empty($discount_ledger) && !empty($pharma_purchase[$i][18]) ) {
					   		

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=abs($pharma_purchase[$i][18]);	//amount paid cash	

							  		 $entry_items['ledger_id']=$discount_ledger;//purchase Medicine

									 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	


					   		}


						    /********** Discount AMOUNT *************/                          				

					   		/********** FRIEGHT AMOUNT *************/

					   		 if (!empty($pharma_purchase[$i][22])) {

								 $entry_items['entry_id']=$entry_id;
								 $entry_items['amount']=$pharma_purchase[$i][22];	//frieght

						  		 $entry_items['ledger_id']=463;//frieght
						  	 	 $entry_items['dc']="D";	

						  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   		 }

						    /********** FRIEGHT AMOUNT *************/		 
						
			 			}
						
						if ( $pharma_purchase[$i][14]=="CREDIT" ) {
							
							//credit amount
                             $info['entry_date']=$pharma_purchase[$i][6];
							 $info['dr_total']=$net_amount[$i];
							 $info['cr_total']=$net_amount[$i];
							 
							 
                              //journal entry purchase medicine to supplier account
							  
							 $info['entry_type']=4;

							 $info['rec_id'] = $pharma_purchase[$i][8];
							   
							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][4];	
	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					         $entry_items['dc']="D";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);	


					        /********** Purchase Amount  *************/

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][21];//cheque amount given

					  		 $entry_items['ledger_id']=$accounting_details[0][2];//supplier
					  	 	 $entry_items['dc']="C";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					        /********** Purchase Amount  *************/					         
                           		
					        /********** Gst Amount  *************/

						    for ($j=0; $j <count($pharma_purchase_gst[$i]) ; $j++) { 

						    	 // $cgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][5];
						    	 // $sgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][6];


						 		if ($pharma_purchase_gst[$i][$j][0][8]=="5") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][3]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][4]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="12") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][5]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][6]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="18") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][7]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][8]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="28") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][9]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][10]; 
						 		}
						    	

						    	 if (!empty($cgst_ledger_id[$i][$j])) {

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][0];	

							  		 $entry_items['ledger_id']=$cgst_ledger_id[$i][$j];//purchase medicine
							  	 	 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

						    	 if (!empty($sgst_ledger_id[$i][$j])) {

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][1];	

							  		 $entry_items['ledger_id']=$sgst_ledger_id[$i][$j];//purchase medicine
							  	 	 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

						    }

					        /********** Gst Amount  *************/


					   		/********** ROUND OFF AMOUNT *************/

							if ( $pharma_purchase[$i][14]=="CREDIT" && $pharma_purchase[$i][15]==1 ) {
			 
								$ledger_id_1 = $accounting_details[0][11];


									if (!empty($ledger_id_1) ) {

										$entry_items['entry_id']=$entry_id;

										if (!empty($pharma_purchase[$i][18])) {

									  		 if ($pharma_purchase[$i][13]>0) {

									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=0-$pharma_purchase[$i][13];
									  		 }
									  		 else{

									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=abs($pharma_purchase[$i][13]);
									  		 }


										}
										else{


									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=$pharma_purchase[$i][13];

										}



									 	//amount paid cash	

							  			$entry_items['ledger_id']=$ledger_id_1;//purchase Medicine							  	 	 
							  	 		$ledger_id=$acc_obj->addEntryItems($entry_items);	
									}


		                           						
							}

						    /********** ROUND OFF AMOUNT *************/	

					   		/********** Discount AMOUNT *************/

					   		$discount_ledger = $accounting_details[0][12];

					   		if (!empty($discount_ledger) && !empty($pharma_purchase[$i][18]) ) {
					   		

									 $entry_items['entry_id']=$entry_id;
									 $entry_items['amount']=abs($pharma_purchase[$i][18]);	//amount paid cash	

							  		 $entry_items['ledger_id']=$discount_ledger;//purchase Medicine

									 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	


					   		}


						    /********** Discount AMOUNT *************/

					   		/********** FRIEGHT AMOUNT *************/

					   		 if (!empty($pharma_purchase[$i][22])) {

								 $entry_items['entry_id']=$entry_id;
								 $entry_items['amount']=$pharma_purchase[$i][22];	//frieght

						  		 $entry_items['ledger_id']=463;//frieght
						  	 	 $entry_items['dc']="D";	

						  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   		 }

						    /********** FRIEGHT AMOUNT *************/
						}
						// var_dump($entry_id);

						//UPI

						if ( $pharma_purchase[$i][14]=="UPI" ) {
							
							//upi amount
                           
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$net_amount[$i];
							 $info['cr_total']=$net_amount[$i];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;

							 $info['rec_id'] = $pharma_purchase[$i][8];
							
							 $entry_id_1[0]=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id_1[0];
							 $entry_items['amount']=$pharma_purchase[$i][4];//upi amount given	


					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);



					   		/********** PURCAHSE AMOUNT *************/

							 $entry_items['entry_id']=$entry_id_1[0];
							 $entry_items['amount']=$pharma_purchase[$i][21];//upi amount given	

					  		 $entry_items['ledger_id']=$accounting_details[0][2];//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

						    /********** PURCAHSE AMOUNT *************/

						    /********** GST AMOUNT      *************/

						    for ($j=0; $j <count($pharma_purchase_gst[$i]) ; $j++) { 

						    	 // $cgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][5];
						    	 // $sgst_ledger_id[$i][$j]=$pharma_purchase_gst[$i][$j][0][6];


						 		if ($pharma_purchase_gst[$i][$j][0][8]=="5") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][3]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][4]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="12") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][5]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][6]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="18") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][7]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][8]; 
						 		}
						 		else if ($pharma_purchase_gst[$i][$j][0][8]=="28") {
						 			$cgst_ledger_id[$i][$j] = $accounting_details[0][9]; 
						 			$sgst_ledger_id[$i][$j] = $accounting_details[0][10]; 
						 		}


						    	 if (!empty($cgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][0];//cgst	

							  		 $entry_items['ledger_id']=$cgst_ledger_id[$i][$j];//purchase Medicine
							  	 	 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

						    	 if (!empty($sgst_ledger_id[$i][$j])) {
									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=$pharma_purchase_gst[$i][$j][0][1];//sgst amount

							  		 $entry_items['ledger_id']=$sgst_ledger_id[$i][$j];//sgst ledger
							  	 	 $entry_items['dc']="D";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);
						    	 }

	
						    }

						     /********** GST AMOUNT      *************/

					   		 /********** ROUND OFF AMOUNT *************/

							if ( $pharma_purchase[$i][14]=="UPI" && $pharma_purchase[$i][15]==1 ) {
									
									$ledger_id_1 = $accounting_details[0][11];

									if (!empty($ledger_id_1) ) {

										$entry_items['entry_id']=$entry_id_1[0];

										if (!empty($pharma_purchase[$i][18])) {

									  		 if ($pharma_purchase[$i][13]>0) {

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=0-$pharma_purchase[$i][13];
									  		 }
									  		 else{

									  		 	$entry_items['dc']="C";	
									  		 	$entry_items['amount']=abs($pharma_purchase[$i][13]);
									  		 }


										}
										else{


									  		 	$entry_items['dc']="D";	
									  		 	$entry_items['amount']=$pharma_purchase[$i][13];

										}



									 	//amount paid cash	

							  			$entry_items['ledger_id']=$ledger_id_1;//purchase Medicine							  	 	 
							  	 		$ledger_id=$acc_obj->addEntryItems($entry_items);	
									}
		                           						
							}

						    /********** ROUND OFF AMOUNT *************/

							 

 					   		/********** Discount AMOUNT *************/

					   		$discount_ledger = $accounting_details[0][12];

					   		if (!empty($discount_ledger) && !empty($pharma_purchase[$i][18]) ) {
					   		

									 $entry_items['entry_id']=$entry_id_1[0];
									 $entry_items['amount']=abs($pharma_purchase[$i][18]);	//amount paid cash	

							  		 $entry_items['ledger_id']=$discount_ledger;//purchase Medicine

									 $entry_items['dc']="C";	

							  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	


					   		}


						    /********** Discount AMOUNT *************/

					   		/********** FRIEGHT AMOUNT *************/

					   		 if (!empty($pharma_purchase[$i][22])) {

								 $entry_items['entry_id']=$entry_id_1[0];
								 $entry_items['amount']=$pharma_purchase[$i][22];	//frieght

						  		 $entry_items['ledger_id']=463;//frieght
						  	 	 $entry_items['dc']="D";	

						  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   		 }

						    /********** FRIEGHT AMOUNT *************/
							  //payment entry purchase medicine to bank account						 

							 $info['entry_type']=2;

							 $info['dr_total'] = $pharma_purchase[$i][4];
							 $info['cr_total'] = $pharma_purchase[$i][4];

							 $info['rec_id'] = $pharma_purchase[$i][8];
							 
							 $entry_id_1[1]=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id_1[1];
							 $entry_items['amount']=$pharma_purchase[$i][4];//upi amount given


					         $entry_items['ledger_id']=$accounting_details[0][13];//bank account
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);


							$entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
							$entry_items['dc']="D";
							 
							$ledger_id=$acc_obj->addEntryItems($entry_items);
											 
                           						
						}
						//end of upi

						//commented for testing
						$pharma_obj->updaterec_online_status($pharma_purchase[$i][8],'1',$entry_id);


						$wheredata_entry[0] = "id = '".$entry_id."'";

						$entries[$i] = $acc_obj->getEntries($wheredata_entry);

						if (!empty($entries[$i])) {
							
							$entryItems[$i] = $acc_obj->getEntriesItems($entry_id);

							if ($entryItems[$i] != ($entries[$i][0][5]+$entries[$i][0][6])) {

								$diff[$i] = ($entryItems[$i])-($entries[$i][0][5]+$entries[$i][0][6]);

								if (!empty($diff[$i])) {
									$amount_to_update = ($pharma_purchase[$i][21]-$diff[$i]);
									// var_dump($entries[$i][0][0],$diff[$i]);
									$acc_obj->updatePurchaseAmount($entry_id,$amount_to_update,385);
								}

							}

						}

 			}

 			

 		}
 		



 }


}



?>
