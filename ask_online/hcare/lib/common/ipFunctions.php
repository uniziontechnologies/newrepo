<?php 

  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 

/*require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/billing/billing.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/model/inpatient/inpatient.php';*/

class IpFunctions{
	
	function calculateBill($post){
	
	
	    $bill_obj=new Billing();  
	    $db_function =new DBFunction(); 
	    $com_obj = new CommonFunctions();
        $ip_obj= new Inpatient();
	    
	     
	   // $total_balance=0;
	    $total_bill=0;
	    $total_paid=0;
	    $advance_paid=0;
	    
	  
	     $ipno=$post['id'];
	     $bystander_status=$db_function->getidToValue("bystander_status","id",$ipno,"hcare_ip_info");
	     
	      //room rent calculation

             $where[]= "ipno = ".$ipno;
             $roomhist = $ip_obj->getRoomhistory('',$where);
             // var_dump($roomhist);
             $room_total_rent=0;
			 $nrcharge_total=0;
			 $maintenance_total=0;
             $cur_ad_date='';
             $bystander_total=0;

              if(!empty($roomhist)){

                 for($i=0;$i<count($roomhist);$i++) {
                      
                   
                    $rent=$roomhist[$i][6];
					$ncharge=$roomhist[$i][9];
					$mcharge=$roomhist[$i][10];
					$bcharge=$roomhist[$i][11];

                    $sdate = new DateTime($roomhist[$i][2]);

                    $prev_date = date('Y-m-d', strtotime($roomhist[$i][3] .' -1 day'));
 
                    $edate = new DateTime($roomhist[$i][3]);
 
                    $difference = $sdate->diff($edate);
              
                    $ndays=$difference->days;

                   //if($ndays ==0) $ndays=1;
                   $room_total_rent +=($ndays* $rent);
				   $nrcharge_total +=($ndays* $ncharge);
				   $maintenance_total +=($ndays* $mcharge);
				   if($bystander_status == 1){
				   	$bystander_total +=($ndays* $bcharge);

				   }else{
				   	$bystander_total +=0;

				   }

                    if($i==(count($roomhist)-1)){

                       $cur_ad_date=$roomhist[$i][3];

                    }
                 }


             }//echo $room_total_rent;
	     
	      $room_rent=$db_function->getidToValue("room_rent","id",$ipno,"hcare_ip_info"); 
		  $nursing_charge=$db_function->getidToValue("nursing_charge","id",$ipno,"hcare_ip_info"); 
		  $maintenance=$db_function->getidToValue("maintenance","id",$ipno,"hcare_ip_info"); 
	      $admission_Date=$db_function->getidToValue("admission_date","id",$ipno,"hcare_ip_info");      
	      $curr_date=$com_obj->getcurrentDate("Y-m-d");
	      $bystander_charge=$db_function->getidToValue("bystander_charge","id",$ipno,"hcare_ip_info");
	      
	      //echo $ad_days=floor((strtotime($curr_date)-strtotime($admission_date))/86400);
	      
              if(!empty($cur_ad_date)){

                     $datetime1 = new DateTime($cur_ad_date);
              }else {
	              $datetime1 = new DateTime($admission_Date);
              }
 
              $datetime2 = new DateTime($curr_date);
 
              $difference = $datetime1->diff($datetime2);
              
              $ad_days=$difference->days+1;

             if($ad_days ==0) {
             	$ad_days=1;
             }
             	
             
              $room_total_rent+=$room_rent*$ad_days;
			 $nrcharge_total+=$nursing_charge*$ad_days;
			  $maintenance_total+=$maintenance*$ad_days;
			  if($bystander_status == 1){ 
			   $bystander_total+=$bystander_charge*$ad_days;
			  }else{
				$bystander_total+=0;
			  }

			  // echo $bystander_total;exit;


            
              
              $total_bill +=($room_total_rent+$nrcharge_total+$maintenance_total+$bystander_total);
             // echo "room_total_rent".$room_total_rent."<br>total ".$total_bill."<br>nrcharge_total ".$nrcharge_total."<br>maintenance_total".$maintenance_total."<br>bystander_total".$bystander_total;
              //$total_balance +=($room_total_rent+$nrcharge_total+$maintenance_total);
	    
	    //bill calcultation
	    $wheredata[]="status ='0'";
	    $wheredata[]="type = 'IP'";
	    $wheredata[]="ref_no = '".$ipno."'";

	    $selectdata[] = "id";
	    $selectdata[] = "credit";
	    $selectdata[] = "net_total";
	    $selectdata[] = "cash";
	    $selectdata[] = "credit_card";
	    $selectdata[] = "upi";

	    
	    $billInfo=$bill_obj->getBillInfo2($wheredata,$selectdata);
	    
	   
	    // var_dump($billInfo);
	    
	   if(!empty($billInfo)){
	    
	         for($i=0;$i<count($billInfo);$i++){
	         
	         //total bill
	         
	             $total_bill+=$billInfo[$i][11];
	             
	         //total paid amount
	          $total_paid+=$billInfo[$i][13]+$billInfo[$i][15]+$billInfo[$i][16];
	             
	         
	            /*$balanceAmt=$billInfo[$i][14];
	            
	            if($balanceAmt>0){
	            
	              $total_balance=$total_balance+$balanceAmt;
	            }*/
	         
	         
	         }
	    }
           //procedure bill from nurse entry
            $procondn[0]="status = 0";
            $procondn[1]="ipno = '".$ipno."'";
            $ipProcedure=$ip_obj->getIPProcedure('',$procondn,'date','asc');
           

            $procedureAmt=0;
           if(!empty($ipProcedure)){
	    
	         for($i=0;$i<count($ipProcedure);$i++){
                      
                   $procedureAmt += $ipProcedure[$i][3];
                 }
           }

           $total_bill += $procedureAmt;

           //doctor visit bill from nurse entry
            $docondn[0]="status = 0";
            $docondn[1]="ipno = '".$ipno."'";
            $doctorVisit=$ip_obj->getDoctorVisit('',$docondn,'date','asc');

            $doc_visit_amt=0;
           if(!empty($doctorVisit)){
	    
	         for($i=0;$i<count($doctorVisit);$i++){
                      
                   $doc_visit_amt += $doctorVisit[$i][3];
                 }
           }

           $total_bill += $doc_visit_amt;
		   //$total_balance +=$doc_visit_amt;

	   //pharmacy credits

              $total_pharma_bill=0;
              $total_phamt_paid=0;

             $phwhere[]="cust_type = 'IP'";        
              $phwhere[]="ip_no = '".$ipno."'";  
              $phwhere[]="sales_mode = 'Sales'";
             $phwhere[]="status = '0'";
             //new
             $phwhere[]="payment_mode = 'CREDIT'";
	    $pharmaInfo=$bill_obj->getpharmaBill($phwhere);

             if(!empty($pharmaInfo)){ //var_dump($pharmaInfo);
	    
	         for($i=0;$i<count($pharmaInfo);$i++){

                   //total bill
	         
	             $total_pharma_bill+=$pharmaInfo[$i][2];
	             
	         //total paid amount
	          $total_phamt_paid+=$pharmaInfo[$i][10];
	             
	         
	           /* $phbalanceAmt=$pharmaInfo[$i][11];
	            
	            if($phbalanceAmt>0){
	            
	              $total_balance=$total_balance+$phbalanceAmt;
	            }*/

                 }
             }
              /* pharmacy return bill */
                $rt_total_pharma_bill=0;
                $rt_total_phamt_paid=0;

              $phwhere_rt[]="cust_type = 'IP'";        
              $phwhere_rt[]="ip_no = '".$ipno."'";
              $phwhere_rt[]="sales_mode = 'Return'";  
             $phwhere_rt[]="status = '0'";
	    $pharmaInfo_rt=$bill_obj->getpharmaBill($phwhere_rt);

             if(!empty($pharmaInfo_rt)){ //var_dump($pharmaInfo_rt);
	    
	         for($i=0;$i<count($pharmaInfo_rt);$i++){

                   //total bill
	         
	             // $rt_total_pharma_bill+=$pharmaInfo_rt[$i][2];
	         	 $rt_total_pharma_bill=0;
	             
	         //total paid amount
	          // $rt_total_phamt_paid+=$pharmaInfo_rt[$i][10];
	         	  $rt_total_phamt_paid=0;
	             
	         
	           /* $phbalanceAmt=$pharmaInfo[$i][11];
	            
	            if($phbalanceAmt>0){
	            
	              $total_balance=$total_balance+$phbalanceAmt;
	            }*/

                 }
             }

             $total_pharma_bill=$total_pharma_bill;
             $total_phamt_paid=$total_phamt_paid-$rt_total_phamt_paid;
             //removed paid details of pharma bill from final bill
            // $total_bill+= $total_pharma_bill;
             $total_paid+=$rt_total_pharma_bill;
             $total_bill+= $total_pharma_bill-$total_phamt_paid;
             //end of removed paid details of pharma bill from final bill
	    //advance calculation
	     
	    $where[0]="ipno='".$ipno."'";
		$where[1]="status='0'";
	    $advaneInfo=$bill_obj->getAdvancePayments($where);
	    
	     if(!empty($advaneInfo)){
	    
	         for($i=0;$i<count($advaneInfo);$i++){
	         
	             $advance_paid+=$advaneInfo[$i][3]+$advaneInfo[$i][4]+$advaneInfo[$i][20];
	         }
	     }
	     
	     // $total_paid+=$advance_paid;
	     //$total_balance -=$advance_paid;
	    
	     
	     
	    //ip bill visit
	    
	    $vs_where[0]="ipno = '".$ipno."'";
	    $vs_where[1]="visit_type = 'IP BILL'";
	    $vs_where[2]="STATUS = 0";
            $docVisit= $ip_obj->getDoctorVisit('',$vs_where,'status','asc');
	    $ip_bill_visit=0;
	    if(!empty($docVisit)){
	    
	         for($i=0;$i<count($docVisit);$i++){
	         
	             $ip_bill_visit+=$docVisit[$i][14];
	         }
	     }
	     
	     //new $total_bill+= $ip_bill_visit;

	     //new

	     $total_bill=$total_bill-$total_paid;
	     
	      // $total_balance=$total_bill-$total_paid;

	     //new
	     $total_balance=$total_bill-$advance_paid;
	      // echo $total_bill;exit;
	    
	    $post['room_rent']=$room_total_rent;
		$post['nursing_charges']=$nrcharge_total;
		$post['maintenance']=$maintenance_total;
	    $post['advance_paid']=$advance_paid;
        // $post['medicine_charges']=$total_pharma_bill;
         $post['medicine_charges']=$total_pharma_bill-$total_phamt_paid;
	    $post['balance']=$total_balance;
	    $post['paid_amount']=$total_paid;
		$post['total_bill_amount']=$total_bill;
		$post['nurse_added_procedures']=$procedureAmt;
        $post['doc_visit_amt']=$doc_visit_amt;
	 $post['ip_bill_visit']=$ip_bill_visit;
	 $post['bystander_charges']=$bystander_total;
	    
	    return $post;
	
	}

function calculateBill_details($post){
	
	
	    $bill_obj=new Billing();  
	    $db_function =new DBFunction(); 
	    $com_obj = new CommonFunctions();
        $ip_obj= new Inpatient();
	    
	     
	   // $total_balance=0;
	    $total_bill=0;
	    $total_paid=0;
	    $advance_paid=0;
	    
	  
	     $ipno=$post['id'];
	     
	      //room rent calculation

             $where[]= "ipno = ".$ipno;
             $roomhist = $ip_obj->getRoomhistory('',$where);
             $b_status=$db_function->getidToValue("bystander_status","id",$ipno,"hcare_ip_info");
             $room_total_rent=0;
			 $nrcharge_total=0;
			 $maintenance_total=0;
             $cur_ad_date='';
             $bystander_charge_total=0;
              if(!empty($roomhist)){

                 for($i=0;$i<count($roomhist);$i++) {
                      
                   $room_name=$roomhist[$i][7];
                    $rent=$roomhist[$i][6];
					$ncharge=$roomhist[$i][9];
					$mcharge=$roomhist[$i][10];
					if($b_status==1){
						$bcharge=$roomhist[$i][11];

					}else{
						$bcharge=0;

					}
					

                    $sdate = new DateTime($roomhist[$i][2]);

                    $prev_date = date('Y-m-d', strtotime($roomhist[$i][3] .' -1 day'));
 
                    $edate = new DateTime($roomhist[$i][3]);
 
                    $difference = $sdate->diff($edate);
              
                    $ndays=$difference->days;

                    //show all old room details
                    $room_old[$i][0]=$room_name;
				   	$room_old[$i][1]=$rent;
			       	$room_old[$i][2]= $sdate;
				   	$room_old[$i][3]=$edate;
				   	$room_old[$i][4]= $ndays;
				   	$room_old[$i][5]=$ncharge;
					$room_old[$i][6]=$mcharge;
					$room_old[$i][7]=$bcharge;
					
					$room_old[$i][8]=$b_status;

                   //if($ndays ==0) $ndays=1;
                   $room_total_rent +=($ndays* $rent);
				   $nrcharge_total +=($ndays* $ncharge);
				   $maintenance_total +=($ndays* $mcharge);
				   $bystander_charge_total+=($ndays* $bcharge);
				   
				             		
                    if($i==(count($roomhist)-1)){

                       $cur_ad_date=$roomhist[$i][3];

                    }
                 }


             }
             $post['room_history']=$room_old;
             //echo $room_total_rent;
	     
	      $room_rent=$db_function->getidToValue("room_rent","id",$ipno,"hcare_ip_info"); 
	      $room_id=$db_function->getidToValue("room_id","id",$ipno,"hcare_ip_info"); 
	      $room_name=$db_function->getidToValue("room_number","id",$room_id,"hcare_rooms"); 
		  $nursing_charge=$db_function->getidToValue("nursing_charge","id",$ipno,"hcare_ip_info"); 
		  $maintenance=$db_function->getidToValue("maintenance","id",$ipno,"hcare_ip_info"); 
	      $admission_Date=$db_function->getidToValue("admission_date","id",$ipno,"hcare_ip_info");      
	      $curr_date=$com_obj->getcurrentDate("Y-m-d");
	     
	       $bystander_status=$db_function->getidToValue("bystander_status","id",$ipno,"hcare_ip_info");
	      $bystander_charge=$db_function->getidToValue("bystander_charge","id",$ipno,"hcare_ip_info");

	      if($bystander_status==1){
						$bystander_charge=$bystander_charge;

					}else{
						$bystander_charge=0;

					}
	      
	      //echo $ad_days=floor((strtotime($curr_date)-strtotime($admission_date))/86400);
	      
              if(!empty($cur_ad_date)){

                     $datetime1 = new DateTime($cur_ad_date);
              }else {
	              $datetime1 = new DateTime($admission_Date);
              }
 
              $datetime2 = new DateTime($curr_date);
 
              $difference = $datetime1->diff($datetime2);
              
              $ad_days=$difference->days+1;

             if($ad_days ==0) $ad_days=1;
             
              $room_total_rent+=$room_rent*$ad_days;
			 $nrcharge_total+=$nursing_charge*$ad_days;
			  $maintenance_total+=$maintenance*$ad_days;
			  $bystander_charge_total+=$bystander_charge*$ad_days;	

			  //show last room details		  
	        		$room_new[0]=$room_name;
				   	$room_new[1]=$room_rent;
			       	$room_new[2]= $datetime1;
				   	$room_new[3]=$datetime2;
				   	$room_new[4]= $ad_days;
				   	$room_new[5]=$nursing_charge;
					$room_new[6]=$maintenance;
					$room_new[7]=$bystander_charge;
					$room_new[8]=$bystander_status;
					$post['room_new']=$room_new;
				
              
               $total_bill +=($room_total_rent+$nrcharge_total+$maintenance_total+$bystander_charge_total);
              //$total_balance +=($room_total_rent+$nrcharge_total+$maintenance_total);
	    
	    //bill calcultation
	    $wheredata[]="status ='0'";
	    $wheredata[]="type = 'IP'";
	    $wheredata[]="ref_no = '".$ipno."'";
	    
	    $billInfo=$bill_obj->getBillInfo2($wheredata);
	    
	   
	   
	    
	   if(!empty($billInfo)){
	    
	         for($i=0;$i<count($billInfo);$i++){
	         
	         //total bill
	         
	             $total_bill+=$billInfo[$i][11];
	             
	         //total paid amount
	          $total_paid+=$billInfo[$i][13]+$billInfo[$i][15]+$billInfo[$i][16];
	             
	         
	            /*$balanceAmt=$billInfo[$i][14];
	            
	            if($balanceAmt>0){
	            
	              $total_balance=$total_balance+$balanceAmt;
	            }*/
	         
	         
	         }
	    }
           //procedure bill from nurse entry
            $procondn[0]="status = 0";
            $procondn[1]="ipno = '".$ipno."'";
            $ipProcedure=$ip_obj->getIPProcedure('',$procondn,'date','asc');

            $procedureAmt=0;
           if(!empty($ipProcedure)){
	    
	         for($i=0;$i<count($ipProcedure);$i++){
                      
                   $procedureAmt += $ipProcedure[$i][3];
                 }
           }

           $total_bill += $procedureAmt;

           //doctor visit bill from nurse entry
            $docondn[0]="status = 0";
            $docondn[1]="ipno = '".$ipno."'";
            $doctorVisit=$ip_obj->getDoctorVisit('',$docondn,'date','asc');
            $doc_visit_amt=0;
           if(!empty($doctorVisit)){
	    
	         for($i=0;$i<count($doctorVisit);$i++){
                      
                   $doc_visit_amt += $doctorVisit[$i][3];
                 }
           }

           $total_bill += $doc_visit_amt;
		   //$total_balance +=$doc_visit_amt;

	   //pharmacy credits

            /* pharmacy sales bill */
              $total_pharma_bill=0;
              $total_phamt_paid=0;

             $phwhere[]="cust_type = 'IP'";        
              $phwhere[]="ip_no = '".$ipno."'";
              $phwhere[]="sales_mode = 'Sales'";  
             $phwhere[]="status = '0'";
	    $pharmaInfo=$bill_obj->getpharmaBill($phwhere);

             if(!empty($pharmaInfo)){
	    
	         for($i=0;$i<count($pharmaInfo);$i++){

                   //total bill
	         
	             $total_pharma_bill+=$pharmaInfo[$i][2];
	             
	         //total paid amount
	          $total_phamt_paid+=$pharmaInfo[$i][10];
	             
	         
	           /* $phbalanceAmt=$pharmaInfo[$i][11];
	            
	            if($phbalanceAmt>0){
	            
	              $total_balance=$total_balance+$phbalanceAmt;
	            }*/

                 }
             }
              
              /* pharmacy return bill */
                $rt_total_pharma_bill=0;
                $rt_total_phamt_paid=0;

              $phwhere_rt[]="cust_type = 'IP'";        
              $phwhere_rt[]="ip_no = '".$ipno."'";
              $phwhere_rt[]="sales_mode = 'Return'";  
             $phwhere_rt[]="status = '0'";
	    $pharmaInfo_rt=$bill_obj->getpharmaBill($phwhere_rt);

             if(!empty($pharmaInfo_rt)){
	    
	         for($i=0;$i<count($pharmaInfo_rt);$i++){

                   //total bill
	         
	             // $rt_total_pharma_bill+=$pharmaInfo_rt[$i][2];
	             
	         //total paid amount
	          // $rt_total_phamt_paid+=$pharmaInfo_rt[$i][10];
	         	$rt_total_pharma_bill=0;
	         	$rt_total_phamt_paid=0;
	             
	         
	           /* $phbalanceAmt=$pharmaInfo[$i][11];
	            
	            if($phbalanceAmt>0){
	            
	              $total_balance=$total_balance+$phbalanceAmt;
	            }*/

                 }
             }

             $total_pharma_bill=$total_pharma_bill-$rt_total_pharma_bill;
             $total_phamt_paid=$total_phamt_paid-$rt_total_phamt_paid;

            $total_bill+= $total_pharma_bill;
             $total_paid+=$total_phamt_paid;

	    //advance calculation
	     
	    $where[0]="ipno='".$ipno."'";
		$where[1]="status='0'";
	    $advaneInfo=$bill_obj->getAdvancePayments($where);
	    
	     if(!empty($advaneInfo)){
	    
	         for($i=0;$i<count($advaneInfo);$i++){
	         
	             $advance_paid+=$advaneInfo[$i][3]+$advaneInfo[$i][4]+$advaneInfo[$i][20];
	         }
	     }
	     
	     $total_paid+=$advance_paid;
	     //$total_balance -=$advance_paid;
	    
	     
	     
	    //ip bill visit
	    
	    $vs_where[0]="ipno = '".$ipno."'";
	    $vs_where[1]="visit_type = 'IP BILL'";
	    $vs_where[2]="STATUS = 0";
            $docVisit= $ip_obj->getDoctorVisit('',$vs_where,'status','asc');
	    $ip_bill_visit=0;
	    if(!empty($docVisit)){
	    
	         for($i=0;$i<count($docVisit);$i++){
	         
	             $ip_bill_visit+=$docVisit[$i][14];
	         }
	     }
	     
	     $total_bill+= $ip_bill_visit;
	     
	      $total_balance=$total_bill-$total_paid;
	    
	    $post['room_rent']=$room_total_rent;
		$post['nursing_charges']=$nrcharge_total;
		$post['maintenance']=$maintenance_total;
	    $post['advance_paid']=$advance_paid;
        $post['medicine_charges']=$total_pharma_bill;
	    $post['balance']=$total_balance;
	    $post['paid_amount']=$total_paid;
		$post['total_bill_amount']=$total_bill;
		$post['nurse_added_procedures']=$procedureAmt;
        $post['doc_visit_amt']=$doc_visit_amt;
	 	$post['ip_bill_visit']=$ip_bill_visit;
	 	$post['bystander_charges']=$bystander_charge_total;
	 	
	    return $post;
	
	}

}


?>