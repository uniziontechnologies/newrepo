<?php 
define('ROOT_PATH',dirname(__FILE__) );

require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/model/pharmaFunctions.php';
require_once ROOT_PATH . '/lib/model/admin/user.php';
require_once ROOT_PATH . '/lib/model/report/report.php';
require_once ROOT_PATH . '/lib/model/accountingModel.php';

$from_date = date("Y-m-d");//date("Y-m-d");
$to_date = date("Y-m-d");
// ECHO $from_date;exit;

$pharma_purchase=pharma_purchase($from_date,$to_date);
// var_dump($pharma_purchase);exit;
accounting_insertion($pharma_purchase,$from_date,$to_date);

function pharma_purchase($from_date,$to_date){
	
	$pharma_obj=new pharmaFunctions();
	
   $purchase_entry=array();
	
	 //purchase entry

	 $total_purchase_entry_collection=array();
 	 
 	 $wheredata=array();
     $wheredata[0]="entry_date >='".$from_date." 00:00:00'";
     $wheredata[1]="entry_date <='".$to_date." 23:59:59'";;
	 $wheredata[2]="status =0";
	 $wheredata[3]="purchase_mode = 'Recievings' ";  

	 $purchase_entry_collection=$pharma_obj->getRecievingsBill($wheredata);
	 // var_dump($purchase_entry_collection);exit;
	 
	

	 for ($i=0; $i <count($purchase_entry_collection) ; $i++) { 
 
	  $purchase_entry[$i]= $purchase_entry_collection[$i];


	 }
	 
	 return $purchase_entry;	
}

function accounting_insertion($pharma_purchase,$from_date,$to_date){

$acc_obj=new AccountingModel();


 //purchase entry
 	if (!empty($pharma_purchase)) {

		
		 // $info['narration']="Collection for the day"; 		

		 $entry_number=$acc_obj->getEntryNumber(1);
		 $entry_number=$entry_number+1;
		 
		 $entry_info=array();
		 $k=0;

 		for ($i=0; $i <count($pharma_purchase) ; $i++) { 	

 			$info['number']=$entry_number++;

 			$supplier_ledger_id=$pharma_purchase[$i][7];

 			

 			if (!empty($supplier_ledger_id)) {echo $i."<br>";


 						if (!empty($pharma_purchase[$i][9])) {
 							$case = " for bill No. ".$pharma_purchase[$i][9]." ";
 						}
 						else{
 							$case = "";
 						}


 						$info['narration']="Medicine purchase for supplier ".$pharma_purchase[$i][10].$case." "; 




						if (!empty($pharma_purchase[$i][0]) ) {
							
							//cash amount
                             $info['entry_date']=$pharma_purchase[$i][6];
							 $info['dr_total']=$pharma_purchase[$i][0];
							 $info['cr_total']=$pharma_purchase[$i][0];
							 

                            //journal entry cash in hand to purchase medicine

        //                       $info['entry_type']=4;							

							 // $entry_id=$acc_obj->addEntry($info);

							 // $entry_items['entry_id']=$entry_id;
							 // $entry_items['amount']=$pharma_purchase[$i][0];//amount paid cash	
							 
					  	// 	 $entry_items['ledger_id']=1;//cash in hand
					  	//  	 $entry_items['dc']="D";	

					  	//  	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					   //       $entry_items['ledger_id']=84;//purchase Medicine
					   //       $entry_items['dc']="C";
					 
					   //       $ledger_id=$acc_obj->addEntryItems($entry_items);

                             //payment entry purchase medicine to supplier						 

							 $info['entry_type']=2;
							 

							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][0];	//amount paid cash	

					  		 $entry_items['ledger_id']=84;//purchase Medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=1;//supplier
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);

                            	$entry_info[$k][0]=$entry_id;
                                $entry_info[$k][1]=$pharma_purchase[$i][8];//rec_id								
                                $k++;
						}
						if (!empty($pharma_purchase[$i][1]) ) {
							
							//card amount
                           
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$pharma_purchase[$i][1];
							 $info['cr_total']=$pharma_purchase[$i][1];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;
							
							 $entry_id=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][1];//card amount given	

					  		 $entry_items['ledger_id']=84;//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							  //payment entry purchase medicine to bank account						 

							 $info['entry_type']=2;
							 
							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][1];//card amount given

					  		 $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=633;//bank account
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							 $entry_info[$k][0]=$entry_id;
                             $entry_info[$k][1]=$pharma_purchase[$i][8];//rec_id
							 $k++;
                           						
						}
						if (!empty($pharma_purchase[$i][2]) ) {
							
							//cheque amt
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$pharma_purchase[$i][2];
							 $info['cr_total']=$pharma_purchase[$i][2];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;
							
							 $entry_id=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][2];//cheque amount given	

					  		 $entry_items['ledger_id']=84;//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							  //payment entry purchase medicine to bank account						 

							 $info['entry_type']=2;
							 
							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][2];//cheque amount given

					  		 $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=633;//bank account
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							 $entry_info[$k][0]=$entry_id;
                             $entry_info[$k][1]=$pharma_purchase[$i][8];//rec_id
							 $k++;
                           						 
						
			 			}
						
						if (!empty($pharma_purchase[$i][3]) ) {
							
							//credit amount
                             $info['entry_date']=$pharma_purchase[$i][6];
							 $info['dr_total']=$pharma_purchase[$i][3];
							 $info['cr_total']=$pharma_purchase[$i][3];
							 
							 
                              //journal entry purchase medicine to supplier account
							  
							   $info['entry_type']=4;
							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][3];	

					  		 $entry_items['ledger_id']=84;//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);	
                           		
                             $entry_info[$k][0]=$entry_id;
                             $entry_info[$k][1]=$pharma_purchase[$i][8];//rec_id								
                             $k++;
						}

						if (!empty($pharma_purchase[$i][25]) ) {
							
							//upi amount
                           
						
                             $info['entry_date']=$pharma_purchase[$i][6];							
							 $info['dr_total']=$pharma_purchase[$i][25];
							 $info['cr_total']=$pharma_purchase[$i][25];
							
							 
                            //journal entry purchase medicine to supplier account
							
							 $info['entry_type']=4;
							
							 $entry_id=$acc_obj->addEntry($info);

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][25];//upi amount given	

					  		 $entry_items['ledger_id']=84;//purchase medicine
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier ledger_id
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							  //payment entry purchase medicine to bank account						 

							 $info['entry_type']=2;
							 
							 $entry_id=$acc_obj->addEntry($info);			 

							 $entry_items['entry_id']=$entry_id;
							 $entry_items['amount']=$pharma_purchase[$i][25];//upi amount given

					  		 $entry_items['ledger_id']=$pharma_purchase[$i][7];//supplier
					  	 	 $entry_items['dc']="D";	

					  	 	 $ledger_id=$acc_obj->addEntryItems($entry_items);	

					         $entry_items['ledger_id']=633;//bank account
					         $entry_items['dc']="C";
					 
					         $ledger_id=$acc_obj->addEntryItems($entry_items);
							 
							 $entry_info[$k][0]=$entry_id;
                             $entry_info[$k][1]=$pharma_purchase[$i][8];//rec_id
							 $k++;
                           						
						}


 			}

 		}

 }

 if(!empty($entry_info)){
	 $pharma_obj=new pharmaFunctions();
	 
	 for($k=0;$k<count($entry_info);$k++){
 
       $pharma_obj->updaterec_online_status($entry_info[$k][1],'1',$entry_info[$k][0]);
       
	 }
 }

}

?>