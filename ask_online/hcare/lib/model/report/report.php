<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class Report{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function daily_collection($fromdate,$todate=null,$user_id=null){
	
		$arrayList=array();

		$query="select sum(ref_balance) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CASH'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[4][0]="ref balance Fee";	
		$arrayList[4][1]=$result->fetch_assoc()['sum(ref_balance)'];

		
		$query="select sum(doc_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CASH'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[0][0]="Consultation";
		$arrayList[0][1]=$result->fetch_assoc()['sum(doc_fee)'];
		
		$query="select sum(reg_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CASH'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[1][0]="Reg Fee";	
		$arrayList[1][1]=$result->fetch_assoc()['sum(reg_fee)'];
		
		$query="select sum(card_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CASH'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[2][0]="Card Fee";	
		$arrayList[2][1]=$result->fetch_assoc()['sum(card_fee)'];

		$query="select sum(amount_paid) from hcare_op_dr_payments where visit_date >='".date('Y-m-d',strtotime($fromdate))."' and visit_date<='".date('Y-m-d',strtotime($todate))."' and status=0";
		// if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[3][0]="Doctor Fee Paid";	
		$arrayList[3][1]=$result->fetch_assoc()['sum(amount_paid)'];
		
		$arrayList[3][5]=$arrayList[3][1];

		//credit card
		$query="select sum(ref_balance) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CREDIT CARD'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[4][0]="ref balance Fee";	
		$arrayList[4][2]=$result->fetch_assoc()['sum(ref_balance)'];

		$query="select sum(doc_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CREDIT CARD'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[0][0]="Consultation";
		$arrayList[0][2]=$result->fetch_assoc()['sum(doc_fee)'];

		$arrayList[0][3]=$arrayList[0][1]+$arrayList[0][2];

		$query="select sum(reg_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CREDIT CARD'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[1][0]="Reg Fee";	
		$arrayList[1][2]=$result->fetch_assoc()['sum(reg_fee)'];
		$arrayList[1][3]=$arrayList[1][1]+$arrayList[1][2];

		
		$query="select sum(card_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='CREDIT CARD'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[2][0]="Card Fee";	
		$arrayList[2][2]=$result->fetch_assoc()['sum(card_fee)'];
		$arrayList[2][3]=$arrayList[2][1]+$arrayList[2][2];

		//----------------------------UPI----------------------------------


		$query="select sum(doc_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='UPI'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[0][0]="Consultation";
		$arrayList[0][4]=$result->fetch_assoc()['sum(doc_fee)'];

		$arrayList[0][5]=$arrayList[0][3]+$arrayList[0][4];

		
		$query="select sum(reg_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='UPI'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[1][0]="Reg Fee";	
		$arrayList[1][4]=$result->fetch_assoc()['sum(reg_fee)'];
		$arrayList[1][5]=$arrayList[1][4]+$arrayList[1][3];

		
		$query="select sum(card_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and cancelled=0 and payment_mode ='UPI'";
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		$result=$this->dbConnection->executeQuery($query);	
		$arrayList[2][0]="Card Fee";	
		$arrayList[2][4]=$result->fetch_assoc()['sum(card_fee)'];
		$arrayList[2][5]=$arrayList[2][3]+$arrayList[2][4];
		

		return $arrayList;
	}
	function detailed_bill_collection($fromdate,$todate,$user_id = null){
	        
		$arrayList=array();
		
	//---------------------------------hcare_bill----------------------------------------------
	    $query="select sum(cash),sum(credit_card),sum(insurance),sum(credit),sum(net_total),sum(upi) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

        $net_total=$row['sum(net_total)'];
        $arrayList[0][0]="Bill";
		$arrayList[0][1]=$row['sum(cash)'];
		$arrayList[0][2]=$row['sum(credit_card)'];
		$arrayList[0][3]=$row['sum(credit)'];
		$arrayList[0][4]=$row['sum(insurance)'];
		$arrayList[0][5]=0;
		$arrayList[0][16]=$row['sum(upi)'];
//----------------------------------CREDIT PAYMENT----------------------------------------------
		$query="select sum(amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);
		// Credit Payment
		$arrayList[0][6]=$result->fetch_assoc()['sum(amount)'];



		$query="select sum(amount_paid) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";		
		
		$result=$this->dbConnection->executeQuery($query);
		// Credit Payment
		$arrayList[0][9]=$result->fetch_assoc()['sum(amount_paid)'];

		$query="select sum(card_amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);
		// Credit card Payment
		$arrayList[0][10]=$result->fetch_assoc()['sum(card_amount)'];

//upi
		$query="select sum(upi_amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);
		// Credit Payment
		$arrayList[0][17]=$result->fetch_assoc()['sum(upi_amount)'];



		$arrayList[0][7]=$net_total;
		$arrayList[0][8]=$arrayList[0][1]+$arrayList[0][2]+$arrayList[0][4]+$arrayList[0][9]+$arrayList[0][10]+$arrayList[0][16]+$arrayList[0][17];

		//pharmacy return bill
        $query="select sum(abs(amount_paid)),sum(abs(card_amt)),sum(abs(checque_amt)),sum(abs(balance)),sum(abs(net_total)),sum(abs(bill_total)),sum(abs(upi_amt)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

        $cash_return=$row['sum(abs(amount_paid))'];
        $net_total_return=$row['sum(abs(net_total))'];
        $card_return=$row['sum(abs(card_amt))'];
        $cheque_return=$row['sum(abs(checque_amt))'];
        $credit_return=$row['sum(abs(balance))'];
         $upi_return=$row['sum(abs(upi_amt))'];
		
		//pharmacy invoice 
		$query="select sum(amount_paid),sum(card_amt),sum(checque_amt),sum(balance),sum(net_total),sum(bill_total),sum(upi_amt) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

		$net_total=$row['sum(net_total)']-$net_total_return;

		$arrayList[1][0]="Pharmacy";
		$arrayList[1][1]=$row['sum(amount_paid)']-$cash_return;
		$arrayList[1][2]=$row['sum(card_amt)']-$card_return;
		$arrayList[1][3]=$row['sum(balance)']-$credit_return;
		$arrayList[1][4]=0;
		$arrayList[1][5]=$row['sum(checque_amt)']-$cheque_return;
		$arrayList[1][16]=$row['sum(upi_amt)']-$upi_return;
//pharma credit payment
		$query="select sum(amount) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[1][6]=$result->fetch_assoc()['sum(amount)'];


//pharma credit payment
		$query="select sum(card_amt) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[1][10]=$result->fetch_assoc()['sum(card_amt)'];

			//upi

		$query="select sum(upi_amt) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[1][17]=$result->fetch_assoc()['sum(upi_amt)'];

		//upi
		//$arrayList[1][17]=0;	


		$arrayList[1][7]=$net_total;
		$arrayList[1][8]=$arrayList[1][1]+$arrayList[1][2]+$arrayList[1][5]+$arrayList[1][6]+$arrayList[1][10]+$arrayList[1][17]+$arrayList[1][16];
		
    //ip advance payments
	
	$query="select sum(cash) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CASH' || payment_mode='CREDIT CARD' || payment_mode='UPI') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[2][0]="IP Advance Payment";
		$arrayList[2][1]=$result->fetch_assoc()['sum(cash)'];
//card amount		
$query="select sum(card_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CREDIT CARD') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[2][2]=$result->fetch_assoc()['sum(card_amount)'];
		$arrayList[2][3]=0;
		$arrayList[2][4]=0;

//upi
		
$query="select sum(upi_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='UPI') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		// $arrayList[2][9]=$result->fetch_assoc()['sum(upi_amount)'];
		$arrayList[2][9]=0;
		$arrayList[2][10]=0;
		$arrayList[2][16]=$result->fetch_assoc()['sum(upi_amount)'];;		
/*... total collection hcare advance payments ...*/
     
	 $query="select sum(cash),sum(card_amount),sum(upi_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();
		
		$cash=$row['sum(cash)'];
		$card_amount=$row['sum(card_amount)'];
		$upi_amount=$row['sum(upi_amount)'];

/*... end of total collection hcare advance payments ...*/		
// cheque		
$query="select sum(cash),sum(card_amount),sum(upi_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CHEQUE') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		
		$arrayList[2][5]=$result->fetch_assoc()['sum(cash)'];
		// $arrayList[2][12]=$result->fetch_assoc()['sum(upi_amount)'];
		$arrayList[2][6]=0;
		$arrayList[2][7]=$cash+$card_amount+$upi_amount;
		$arrayList[2][8]=$arrayList[2][1]+$arrayList[2][2]+$arrayList[2][5]+$arrayList[2][16];

	//ip final bill
	
	$query="select sum(amount),sum(credit_paid),sum(net_amount),sum(card_amount),sum(cheque_amt),sum(balance),sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

		$arrayList[3][0]="Discharge Bills";
		$arrayList[3][1]=$row['sum(amount)'];
		// $arrayList[3][3]=$row['sum(balance)'];		
 	    $net_amt=$row['sum(net_amount)'];	    	
		$arrayList[3][4]=0;		
		$arrayList[3][6]=$row['sum(credit_paid)'];
		
        //card amt
        $query="select sum(card_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='CREDIT CARD'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[3][2]=$result->fetch_assoc()['sum(card_amount)'];
		//upi

        $query="select sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='UPI'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[3][16]=$result->fetch_assoc()['sum(upi_amount)'];
		//cheque amt
		$query="select sum(cheque_amt) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='CHEQUE'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[3][5]=$result->fetch_assoc()['sum(cheque_amt)'];


        /* ************* */
	// var_dump($arrayList[3][1],$arrayList[3][2],$arrayList[3][16],$net_amt);
		 $query="select sum(net_amount),sum(balance),sum(amount),sum(card_amount),sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and payment_mode = 'CREDIT' and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

// var_dump($row['sum(net_amount)'],$row['sum(amount)']);
		$arrayList[3][3]=$row['sum(net_amount)']-$row['sum(amount)'];	

		 /* ************* */

		$arrayList[3][7]=$arrayList[3][1]+$arrayList[3][2]+$arrayList[3][5]+$arrayList[3][3]+$arrayList[3][16];
		$arrayList[3][8]=$arrayList[3][1]+$arrayList[3][2]+$arrayList[3][5]+$arrayList[3][6]+$arrayList[3][16];
        $arrayList[3][15]=$arrayList[3][2];
         $arrayList[3][18]=$arrayList[3][16];



	//ip credit payments newly added
	
	   $query="select sum(amount_paid),sum(card_amount),sum(upi_amount) from hcare_ip_credit_payments where bill_date >='$fromdate' and bill_date<='$todate'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();
		
		$arrayList[3][11] ="IP credit payments - CASH";
		$arrayList[3][12] =$row['sum(amount_paid)'];
		$arrayList[3][13] ="IP credit payments - CREDIT CARD";
		$arrayList[3][14] =$row['sum(card_amount)'];
		$arrayList[3][19] ="IP credit payments - UPI";
		$arrayList[3][20] =$row['sum(upi_amount)'];


  		// $arrayList[3][3]=$arrayList[3][3]-$arrayList[3][12]-$arrayList[3][14];
// var_dump($arrayList);




	//--------------------------------- OP COLLECTION ----------------------------------------------

	    $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='CASH'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $net_total_cash=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];

        $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='CREDIT CARD'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $net_total_credit_card=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];

         $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='UPI'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $net_total_upi=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];

        $arrayList[4][0]="OP Collection";
		$arrayList[4][1]=$net_total_cash;
		$arrayList[4][2]=$net_total_credit_card;
		$arrayList[4][3]=0;
		$arrayList[4][4]=0;
		$arrayList[4][5]=0;

		// $query="select sum(amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate'";
		
		// if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		// $result=$this->dbConnection->executeQuery($query);
		// Credit Payment
		$arrayList[4][6]=0;
		$arrayList[4][16]=$net_total_upi;
		$arrayList[4][7]=$net_total_cash+$net_total_credit_card+$net_total_upi+$arrayList[4][6];
		$arrayList[4][8]=$arrayList[4][1]+$arrayList[4][2]+$arrayList[4][6]+$arrayList[4][16];

		//doctror pay+
		$query="select sum(amount_paid) from hcare_op_dr_payments where payment_date >='$fromdate' and payment_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);

		$amount_paid_dr = $result->fetch_assoc()['sum(amount_paid)'];

		$arrayList[4][1]-=$amount_paid_dr;
		$arrayList[4][7]-=$amount_paid_dr;
		$arrayList[4][8]-=$amount_paid_dr;

	//--------------------------------- OBSERVATION COLLECTION ----------------------------------------------

	    $query="select sum(cash_amount),sum(card_amount),sum(cheque_amt),sum(upi_amount) from hcare_op_observation_bills where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";

		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

        $cash_amount=$row['sum(cash_amount)'];
        $card_amount=$row['sum(card_amount)'];
        $cheque_amt=$row['sum(cheque_amt)'];
        $upi_amt=$row['sum(upi_amount)'];

        $net_total = $cash_amount+$card_amount+$cheque_amt+$upi_amt;

        $arrayList[5][0]="Observation Discharge<br><span class='text-red'>(Credit From billing)</span>";
		$arrayList[5][1]=0;
		$arrayList[5][2]=0;
		$arrayList[5][3]=($cash_amount+$card_amount+$upi_amt);
		$arrayList[5][4]=0;
		$arrayList[5][5]=$cheque_amt;
		
		

		// $query="select sum(amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate'";
		
		// if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		// $result=$this->dbConnection->executeQuery($query);
		// Credit Payment
		$arrayList[5][6]=$cash_amount;
		$arrayList[5][7]=$net_total;
		$arrayList[5][8]=$net_total;
		$arrayList[5][10]=$card_amount;
		$arrayList[5][16]=0;
		$arrayList[5][17]=$upi_amt;

// var_dump($arrayList[3]);
		// minus observation charge - from bill credit
		// $arrayList[0][8]=$net_total;
		// $arrayList[0][3]-=$net_total;
  
		return $arrayList;
    }
	function daily_bill_collection($fromdate,$todate,$user_id = null){
	                      
		$arrayList=array();
		
	//--------------------------------------CASH COLLECTION---------------------------------------------------------------
	    $query="select sum(cash) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[0][0]="Cash";
		$arrayList[0][1]=$result->fetch_assoc()['sum(cash)'];
        
        //pharmacy return bill
        $query="select sum(abs(amount_paid)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
        $cash_return=$result->fetch_assoc()['sum(abs(amount_paid))'];


		//pharmacy invoice cash
		
		$query="select sum(amount_paid) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[0][1] +=(($result->fetch_assoc()['sum(amount_paid)'])-$cash_return);
    //ip advance payments
	
	    $query="select sum(cash) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CASH' || payment_mode='CREDIT CARD' || payment_mode='UPI') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[0][1] +=($result->fetch_assoc()['sum(cash)']);
		
	//ip final bill
	
	    $query="select sum(amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[0][1] +=($result->fetch_assoc()['sum(amount)']);

		//OP COLLECTION

	    $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='CASH'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $op_collection_cash=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];

        //credit card

        $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='CREDIT CARD'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $op_collection_credit_card=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];

        //upi

        $query="select sum(doc_fee+reg_fee+card_fee) from hcare_op_visit_info where visit_date >='$fromdate' and visit_date<='$todate' and cancelled=0 and payment_mode ='UPI'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

        $op_collection_upi=$result->fetch_assoc()['sum(doc_fee+reg_fee+card_fee)'];



        //doctror pay
		$query="select sum(amount_paid) from hcare_op_dr_payments where payment_date >='$fromdate' and payment_date<='$todate' and status=0";

		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$op_dr_payment=($result->fetch_assoc()['sum(amount_paid)']);
		 


        $arrayList[0][1] +=$op_collection_cash;

        $arrayList[0][1] -=$op_dr_payment;
	
	//-------------------CREDIT CARD COLLECTION------------------------------------------------	
	//credit card	
		$query="select sum(credit_card) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[1][0]="Credit Card";
		$arrayList[1][1]=($result->fetch_assoc()['sum(credit_card)']);
		//OP COLLECTION CREDIT CARD 

		$arrayList[1][1] +=$op_collection_credit_card;
		
		//pharmacy invoice creditcard

        $query="select sum(abs(card_amt)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
        $card_return=$result->fetch_assoc()['sum(abs(card_amt))'];

		
		$query="select sum(card_amt) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[1][1] +=($result->fetch_assoc()['sum(card_amt)']-$card_return);
		
		//ip advance payments
	
	   $query="select sum(card_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CREDIT CARD') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[1][1] +=($result->fetch_assoc()['sum(card_amount)']);
		
		//ip final bill
	
	$query="select sum(card_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and (payment_mode ='CREDIT CARD') and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[1][1] +=($result->fetch_assoc()['sum(card_amount)']);



		//-------------------UPI COLLECTION------------------------------------------------	
	//upi	
		$query="select sum(upi) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[2][0]="UPI";
		$arrayList[2][1]=($result->fetch_assoc()['sum(upi)']);

		//OP COLLECTION UPI 

		$arrayList[2][1] +=$op_collection_upi;
		
		//pharmacy invoice upi

        $query="select sum(abs(upi_amt)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
        $upi_return=$result->fetch_assoc()['sum(abs(upi_amt))'];

		
		$query="select sum(upi_amt) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[2][1] +=($result->fetch_assoc()['sum(upi_amt)']-$upi_return);
		
		// //ip advance payments
	
	   $query="select sum(upi_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='UPI') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[2][1] +=($result->fetch_assoc()['sum(upi_amount)']);
		
		//ip final bill
	
	$query="select sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and (payment_mode ='UPI') and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[2][1] +=($result->fetch_assoc()['sum(upi_amount)']);

	//-------------------CREDIT COLLECTION----------------------------------------
	//credit
		
		$query="select sum(credit) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[3][0]="Credit";
		$arrayList[3][1]=($result->fetch_assoc()['sum(credit)']);
		//pharmacy invoice credit

		$query="select sum(abs(balance)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$return_credit=$result->fetch_assoc()['sum(abs(balance))'];
		
		$query="select sum(balance) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[3][1] +=($result->fetch_assoc()['sum(balance)']-$return_credit);
		//ip final bill
	
	    $query="select sum(balance),sum(net_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and (payment_mode ='CREDIT') and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		// $arrayList[2][1] +=($result->fetch_assoc()['sum(balance)']);



        /* ************* */
	
		$query="select sum(net_amount),sum(balance),sum(amount),sum(card_amount),sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and payment_mode = 'CREDIT' and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

		$row_ip_balance = $row['sum(net_amount)']-$row['sum(amount)'];

		$arrayList[3][1] +=$row_ip_balance;	


		 /* ************* */


	//---------------------INSURANCE------------------------------------------------------------------------------------------	
		$query="select sum(insurance) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0  and paid_with = 'INSURANCE'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[4][0]="Insurance";
		$arrayList[4][1]=($result->fetch_assoc()['sum(insurance)']);
		
		
	//----------------------------CHEQUE AMOUNT COLLECTION--------------------------------------------------------	
		//pharmacy invoice cheque
		

		$query="select sum(checque_amt) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$return_cheque=$result->fetch_assoc()['sum(checque_amt)'];


		$query="select sum(checque_amt) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[5][0]="Cheque";
		$arrayList[5][1] =($result->fetch_assoc()['sum(checque_amt)']-$return_cheque);
		
		//ip advance payments
	
	   $query="select sum(cash) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and (payment_mode='CHEQUE') and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[5][1] +=($result->fetch_assoc()['sum(cash)']);
		
		//ip final bill
	
	$query="select sum(cheque_amt) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and (payment_mode ='CHEQUE') and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[5][1] +=($result->fetch_assoc()['sum(cheque_amt)']);
		
	//----------------------------------CREDIT PAYMENTS----------------------------------------------
		// $query="select sum(amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		// if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		// $result=$this->dbConnection->executeQuery($query);
		// $arrayList[5][0]="Credit Payment";
		// $arrayList[5][1]=(mysql_result($result,0,'sum(amount)'));
        $arrayList[6][1]=0;


		$query="select sum(amount_paid) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);

		$amount_paid_bill = $result->fetch_assoc()['sum(amount_paid)'];

		$arrayList[6][2]="Credit Payment - CASH";
		$arrayList[6][3]=$amount_paid_bill;
		$arrayList[6][1]+=$amount_paid_bill;

		$query="select sum(card_amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";		
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);

		$card_paid_bill = $result->fetch_assoc()['sum(card_amount)'];

		$arrayList[6][4]="Credit Payment - CARD AMOUNT";
		$arrayList[6][5]=$card_paid_bill;
		$arrayList[6][1]+=$card_paid_bill;

		//upi

		$query="select sum(upi_amount) from hcare_bill_payments where bill_date >='$fromdate' and bill_date<='$todate' and status=0";		
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";

		$result=$this->dbConnection->executeQuery($query);

		$upi_paid_bill = $result->fetch_assoc()['sum(upi_amount)'];

		$arrayList[6][10]="Credit Payment - UPI AMOUNT";
		$arrayList[6][11]=$upi_paid_bill;
		$arrayList[6][1]+=$upi_paid_bill;




		
		//pharma credit payment
		$query="select sum(amount) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$amount_paid_pharma = $result->fetch_assoc()['sum(amount)'];
		
		$arrayList[6][1]+=$amount_paid_pharma;
		$arrayList[6][3]+=$amount_paid_pharma;


		//pharma credit payment
		$query="select sum(card_amt) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$card_paid_pharma = $result->fetch_assoc()['sum(card_amt)'];
		
		$arrayList[6][1]+=($card_paid_pharma);
		$arrayList[6][5]+=($card_paid_pharma);

		//pharma credit payment upi
		$query="select sum(upi_amt) from hcare_pharma_credit_payment where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$upi_paid_pharma = $result->fetch_assoc()['sum(upi_amt)'];
		
		$arrayList[6][1]+=($upi_paid_pharma);
		$arrayList[6][11]+=($upi_paid_pharma);



	//ip final bill
	 //    $query="select sum(credit_paid),sum(net_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3)";
		
		// if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		// $result=$this->dbConnection->executeQuery($query);
		
		// $arrayList[5][1]+=(mysql_result($result,0,'sum(credit_paid)'));


	    $query="select sum(cash_amount),sum(card_amount),sum(cheque_amt),sum(upi_amount) from hcare_op_observation_bills where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";

		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();

        $cash_amount=($row['sum(cash_amount)']);
        $card_amount=($row['sum(card_amount)']);
        $cheque_amt=($row['sum(cheque_amt)']);
        $upi_amount=($row['sum(upi_amount)']);

        $net_total_obs = $cash_amount+$card_amount+$cheque_amt+$upi_amount;

        $arrayList[6][1]+=($net_total_obs-$cheque_amt);//both [5][1] and [4][1] adds $cheque_amt, we cant remove it from [4][1]
        $arrayList[6][3]+=$cash_amount;
        $arrayList[6][5]+=$card_amount;
        $arrayList[6][11]+=$upi_amount;

        $arrayList[5][1] +=$cheque_amt;


        // NEW CAHNGES - CREDIT : ADD OBSERVATION CREDIT //
         $arrayList[3][1] +=($cash_amount+$card_amount+$upi_amount);

		
	// ----------------------------------TOTAL BILL COLLECTION------------------------------------------------------------------
		$query="select sum(net_total) from hcare_bill where bill_date >='$fromdate' and bill_date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		$arrayList[7][0]="Total Collection";
		$arrayList[7][1]=($result->fetch_assoc()['sum(net_total)']);

     //total pharma bill return
        $query="select sum(abs(net_total)) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Return'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
        $net_total_return=$result->fetch_assoc()['sum(abs(net_total))'];

		
	//total pharma bill
	
	   $query="select sum(net_total) from hcare_pharma_invoice where bill_date >='$fromdate' and bill_date<='$todate' and status=0 and sales_mode='Sales'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
		
		$result=$this->dbConnection->executeQuery($query);
		
		$arrayList[7][1] +=($result->fetch_assoc()['sum(net_total)']-$net_total_return);

	//total ip advance payments
	
	 $query="select sum(cash),sum(card_amount),sum(upi_amount) from hcare_advance_payments where date >='$fromdate' and date<='$todate' and status=0";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();
		
		$arrayList[7][1] +=($row['sum(cash)']);
		$arrayList[7][1] +=($row['sum(card_amount)']);
		$arrayList[7][1] +=($row['sum(upi_amount)']);

	  $query="select sum(amount),sum(balance),sum(net_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and (bill_status!=1 and bill_status!=3)";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();
		
		$arrayList[7][1] +=($row['sum(amount)']);

		// $arrayList[6][1] +=($row['sum(balance)']);
		// $arrayList[6][1] +=$arrayList[3][1];
		$arrayList[7][1] +=$op_collection_cash+$op_collection_credit_card+$op_collection_upi-$op_dr_payment;

		$arrayList[7][1] +=$net_total_obs;

		$arrayList[7][1] +=$row_ip_balance;


		//card amt
        $query="select sum(card_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='CREDIT CARD'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[7][1] +=($result->fetch_assoc()['sum(card_amount)']);

		//cheque amt
		$query="select sum(cheque_amt) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='CHEQUE'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[7][1] +=($result->fetch_assoc()['sum(cheque_amt)']);

		//upi amt

        $query="select sum(upi_amount) from hcare_ip_bill where bill_date >='$fromdate' and bill_date<='$todate' and  (bill_status!=1 and bill_status!=3) and payment_mode='UPI'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$arrayList[7][1] +=($result->fetch_assoc()['sum(upi_amount)']);


		
		//ip credit payments newly added
	   $query="select sum(amount_paid),sum(card_amount),sum(upi_amount) from hcare_ip_credit_payments where bill_date >='$fromdate' and bill_date<='$todate'";
		
		if(!empty($user_id)) $query .= " and user_id in $user_id";
		
		$query .= " order by id";
				
		$result=$this->dbConnection->executeQuery($query);

		$row = $result->fetch_assoc();


		

		
		$arrayList[6][6] ="IP credit payments - CASH";
		$arrayList[6][7] =($row['sum(amount_paid)']);
		$arrayList[6][8] ="IP credit payments - CREDIT CARD";
		$arrayList[6][9] =($row['sum(card_amount)']);
		$arrayList[6][12] ="IP credit payments - UPI";
		$arrayList[6][13] =($row['sum(upi_amount)']);

		$arrayList[8][1] +=$row['sum(amount_paid)'];
		$arrayList[8][1] +=$row['sum(card_amount)'];
		$arrayList[8][1] +=$row['sum(upi_amount)'];


		//$arrayList[6][1]+=($arrayList[5][7]+$arrayList[5][9]);

		// total net cash credit payment
		//$arrayList[5][1]-=$arrayList[5][5];
		$arrayList[6][1]+=$arrayList[6][7];
		$arrayList[6][1]+=$arrayList[6][9];
		$arrayList[6][1]+=$arrayList[6][13];
		$arrayList[6][3]+=$arrayList[6][7];
		// total net credit card payment
		$arrayList[6][5]+=$arrayList[6][9];
		//upi
		$arrayList[6][11]+=$arrayList[6][13];


	//-------------------------------AMOUNT COLLECTED EXCLUDED CREDIT------------------------------------------------------------------------	
		$arrayList[8][0]="Total Amount Recieved";
		$arrayList[8][1]=$arrayList[0][1]+$arrayList[1][1]+$arrayList[4][1]+$arrayList[5][1]+$arrayList[6][1]+$arrayList[2][1];
// var_dump($arrayList[0][1]+$arrayList[1][1]+$arrayList[3][1]+$arrayList[4][1]+$arrayList[5][1]);
		return $arrayList;
		
	}
	function patient_count($docid,$fromdate,$todate){
	
			$query1="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and (visit_status='NEW'  and free=0 and health_checkup='NO') and cancelled=0";
			if(!empty($docid)) $query1 .= " and doc_id='$docid'";
			$result1=$this->dbConnection->executeQuery($query1);
			$new=$result1->fetch_assoc()['count(*)'];
			
			$query2="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and ( visit_status='RENEW' and free=0) and cancelled =0";
			if(!empty($docid)) $query2 .= " and doc_id='$docid'";
			$result2=$this->dbConnection->executeQuery($query2);
			$renew=$result2->fetch_assoc()['count(*)'];
			
			$query3="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and visit_status='VISIT' and free=0 and cancelled=0";
			if(!empty($docid)) $query3 .= " and doc_id='$docid'";
			$result3=$this->dbConnection->executeQuery($query3);
			$visit=$result3->fetch_assoc()['count(*)'];
			
			
			$query4="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and free=1 and cancelled=0";
			if(!empty($docid)) $query4.= " and doc_id='$docid'";
			$result4=$this->dbConnection->executeQuery($query4);
			$free=$result4->fetch_assoc()['count(*)'];
			
			
			$query5="select sum(doc_fee) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and visit_status!='FREE' and cancelled=0";
			if(!empty($docid)) $query5 .= " and doc_id='$docid'";
			$result5=$this->dbConnection->executeQuery($query5);
			$paid=$result5->fetch_assoc()['sum(doc_fee)'];

			
			$query6="select count(*) from hcare_ip_info where admission_date >='$fromdate' and admission_date<='$todate' and cancelled=0";
			if(!empty($docid)) $query6 .= " and doc_id='$docid'";
			$result6=$this->dbConnection->executeQuery($query6);
			$ip_count=$result6->fetch_assoc()['count(*)'];
			
			$query4="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and health_checkup='YES' and cancelled=0";
			if(!empty($docid)) $query4.= " and doc_id='$docid'";
			$result4=$this->dbConnection->executeQuery($query4);
			$health_checkup=$result4->fetch_assoc()['count(*)'];

			$query8="select count(*) from hcare_op_visit_info where visit_date >='$fromdate 00:00:00' and visit_date<='$todate 23:59:59' and visit_status='REVISIT' and free=0 and cancelled=0";
			if(!empty($docid)) $query8 .= " and doc_id='$docid'";
			$result8=$this->dbConnection->executeQuery($query8);
			$revisit=$result8->fetch_assoc()['count(*)'];

			
			return array($new,$visit,$free,$paid,$renew,$ip_count,$health_checkup,$revisit);
		
	
	
	}
	
	function doctor_visit_charge($docid,$fromdate,$todate,$user_id){
	
			$query1="select sum(visit_charge),count(*) from hcare_ip_doctor_visit where date >='$fromdate' and date<='$todate' and visit_type='E' and status=0";
			if(!empty($docid)) $query1 .= " and doctor='$docid'";
			if(!empty($user_id)) $query1 .= " and user in $user_id";
			$result1=$this->dbConnection->executeQuery($query1);
		    $evisit=$result1->fetch_assoc()['sum(visit_charge)'];
			$evisit_count=$result1->fetch_assoc()['count(*)'];
			
			$query1="select sum(visit_charge),count(*) from hcare_ip_doctor_visit where date >='$fromdate' and date<='$todate' and visit_type='V' and status=0";
			if(!empty($docid)) $query1 .= " and doctor='$docid'";
			if(!empty($user_id)) $query1 .= " and user in $user_id";
			$result1=$this->dbConnection->executeQuery($query1);
			$visit=$result1->fetch_assoc()['sum(visit_charge)'];
			$visit_count=$result1->fetch_assoc()['count(*)'];
			
			$query1="select sum(visit_charge),count(*) from hcare_ip_doctor_visit where date >='$fromdate' and date<='$todate' and visit_type='IP BILL' and status=0";
			if(!empty($docid)) $query1 .= " and doctor='$docid'";
			if(!empty($user_id)) $query1 .= " and user in $user_id";
			$result1=$this->dbConnection->executeQuery($query1);
			$billvisit=$result1->fetch_assoc()['sum(visit_charge)'];
			$billvisit_count=$result1->fetch_assoc()['count(*)'];
			
			return array($evisit,$evisit_count,$visit,$visit_count,$billvisit,$billvisit_count);
		
	
	
	}
    function getOpDocPayments($fromdate,$todate,$doc_id){
	

			 $query5="select sum(amount_paid) from hcare_op_dr_payments where visit_date >='$fromdate' and visit_date<='$todate' and status=0";
			if(!empty($doc_id)) $query5 .= " and doc_id='$doc_id'";
			$result5=$this->dbConnection->executeQuery($query5);
			$paid=$result5->fetch_assoc()['sum(amount_paid)'];
			
			return array($paid);


	} 

	function getOpDocPaymentsDetailed($wheredata){
	
	
	$arrList=array();
		$i=0;
		$query=$this->dbConnection->BuiltQuery('hcare_op_dr_payments','',$wheredata,'id','asc');	
		$result=$this->dbConnection->executeQuery($query);
		
		if(mysqli_num_rows($result) > 0){
			
			while($row=$result -> fetch_assoc()){
			
				$arrList[$i][0]=$row['id'];
				$arrList[$i][1]=$row['doc_id'];
				$arrList[$i][2]=$row['visit_date'];
				$arrList[$i][3]=$row['payment_date'];
				$arrList[$i][4]=$row['doc_fee'];
				$arrList[$i][5]=$row['amount_paid'];
				$arrList[$i][6]=$row['staus'];
				$arrList[$i][7]=$row['balance'];
				$arrList[$i][8]=$row['action'];
				
				$i++;
			}
			
		}
		
		return $arrList;
	
	}

	function getMedicineDoctorWise($is_field =null ){
	
				$arrList=array();
				$arrFieldList[0]= "a.`id`";
				$arrFieldList[1]= "a.`cust_type`";
				$arrFieldList[2]= "a.`doctor`";
				$arrFieldList[3]= "a.`doc_id`";
				$arrFieldList[4]= "a.`cust_name`";
				$arrFieldList[5]= "b.`id`";
				$arrFieldList[6]= "b.`bill_date`";
				$arrFieldList[7]= "b.`item_id`";
				$arrFieldList[8]= "b.`batch_id`";
				$arrFieldList[9]= "b.`sales_mode`";
				$arrFieldList[10]= "b.`batch_no`";
				$arrFieldList[11]= "b.`hsn_no`";
				$arrFieldList[12]= "b.`expiry`";
				$arrFieldList[13]= "b.`selling_unit`";
				$arrFieldList[14]= "b.`quantity`";
				$arrFieldList[15]= "b.`sellp`";
				$arrFieldList[16]= "b.`mrp`";
				$arrFieldList[17]= "b.`gst_per`";
				$arrFieldList[18]= "b.`total`";
			
				
				$arrTables[0] = "`hcare_pharma_invoice` a";
       			$arrTables[1] = "`hcare_pharma_invoice_items` b";
				  
				$joinConditions[1] = "a.`id` = b.`bill_id`";
       			
				if(!empty($is_field)) {
					for($k=0;$k<count($is_field);$k++){
					
						$selectConditions[]=$is_field[$k];
					}
				}

				$selectConditions[]="a.`status`=0";
				$selectConditions[]="a.`doc_id`>0";

				if(empty($orderbyfield)){
				  $orderbyfield="b.id";
				   $orderby="asc";
			    }

			    $query=$this->dbConnection->selectFromMultipleTable($arrFieldList, $arrTables, $joinConditions, $selectConditions,'',$orderbyfield,$orderby,$limit,$group_by);
				
				$result=$this->dbConnection->executeQuery($query);
				
	            if(mysqli_num_rows($result)>0){
								$i=0;
				  while($row=mysqli_fetch_array($result)){

				  	for($k=0;$k<=18;$k++) {						
								
					   $arrList[$i][$k]=$row[$k];
					}
									

			        $arrList[$i][19]=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id',$arrList[$i][7]);

				    $i++;
				  }
			    }
	    		
		return $arrList;		
				
	}
	function updateEmailStatus($mail_date,$send_date,$id=null){
		
		$field_names=array("mail_date", "send_date", "status");
			
		$field_data=array($mail_date,$send_date,1);
		
		$result=$this->dbConnection->update($field_names,$field_data,"id",$id,"email_status");
		
		if($result) return $this->dbConnection->mysqli_connect->insert_id;

		else return 0;

	}



}


?>
