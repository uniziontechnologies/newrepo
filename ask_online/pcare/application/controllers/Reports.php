<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	public function invoice_report($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		
		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));

		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(!empty($payment_type)){
			
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";

		}
		
		$criteria[] ="status = 0";


/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);

		$data['billInfo']=$this->invoice_model->searchBill($criteria,'',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_invoice,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		$this->load->view("reports/invoice_report",$data);

	}
	public function invoice_return_report($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));

		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(!empty($payment_type)){
			
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";

		}
		
		$criteria[] ="sales_mode = 'Return'";
		$criteria[] ="status = 0";


/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);

		$data['billInfo']=$this->invoice_model->searchBill($criteria,'',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_invoice,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		$this->load->view("reports/invoice_return_report",$data);

	}
	public function branchwise_report($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);


		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));
		
		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
		
		}
		$criteria[] = "payment_mode = 'BRANCH'";
		$criteria[] ="status = 0";

		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);

		$data['billInfo']=$this->invoice_model->searchBill($criteria,'',$limit);	

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_invoice,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view("reports/branchwise_report",$data);

	}
	public function invoice_return_itemwise($export=null){

		$this->load->model('invoice_model');

		$count_items=0;

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);


		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$from_time=$this->input->post("from_time");
		$from_time = str_replace(' ','',$from_time);
		if (empty($from_time)) {
			$from_time = " 00:00:00";
		}
		$to_time=$this->input->post("to_time");
		$to_time = str_replace(' ','',$to_time);
		if (empty($to_time)) {
			$to_time = " 23:59:59";
		}
		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(empty($criteria) && empty($user_type)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
		}
		$criteria[] = "sales_mode = 'Return'";
		$criteria[] ="status = 0";

		/*... pagination start ...*/
        
		    $this->load->helper('pagination');

		    $perPage=50; 
            if(empty($current_page)){
                    $current_page =1;	
            }else{ 
                    $current_page = $current_page; 
            }  

		    $limit=pageLimit($current_page,$perPage);
        
            $next_page=explode(",",$limit);
            $data['next_page']=$next_page[0];
        
            if(!empty($export)){

        	    $limit='';
            }

		if(!empty($user_type) || !empty($user_id)){

			if (!empty($user_type)) {

				$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
				$data['user_type']=$user_type;
				$search[] = "user_type =".$user_type;
				$data['user_info'] = $userInfo = $this->user->getUsers($search);
					if (!empty($userInfo)) {

						for($i=0;$i<count($userInfo);$i++){

							$user_id_new[] =$userInfo[$i][0];

						}
						$matches = implode(',', $user_id_new);
						if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
					}

			}
			// else{
				$data['billInfo']=$billInfo=$this->invoice_model->searchBill($criteria);
			// }
            

			if (!empty($billInfo)) {

				$search_final = array();
				$search_final[0] ="sales_mode = 'Return'";
				for ($i=0; $i <count($billInfo) ; $i++) { 

					$bill_id_new[] =$billInfo[$i][1];
				
				}
				$matches = implode(',', $bill_id_new);
				if(!empty($matches)) $criteria1[] ="bill_id "." "."in ( $matches )";
				$count_items=$this->invoice_model->searchBillItemsCount($criteria1);
				$data['itemInfo']=$itemInfo=$this->invoice_model->searchBillItems($criteria1,$limit);
                
			}

		}
		else{
			$count_items=$this->invoice_model->searchBillItemsCount($criteria);
			$data['itemInfo']=$itemInfo=$this->invoice_model->searchBillItems($criteria,$limit);
		}
		
            $data['export']=$export;

        if(empty($export)){
           $data['pagination_link']=printPageLinks($count_items,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view("reports/invoice_return_itemwise",$data);

	}
	// public function itemwise_report($export=null){

	// 	$this->load->model('invoice_model');

	// 	// $data['user_info'] = $userInfo = $this->user->getUsers();

	// 	$from_date=$this->input->post("from_date");
	// 	$end_date=$this->input->post("end_date");
	// 	$brand=$this->input->post("brand");
	// 	$brand_ID=$this->input->post("brand_ID");
	// 	$invoice_mode=$this->input->post("invoice_mode");
		
	// 	$criteria=array();
	// 	$info=array();

	// 	if(!empty($from_date)){
	// 	    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
	// 		$data['from_date']=$from_date;
			
			
	// 	}
		
	// 	if(!empty($end_date)){
	// 		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
	// 		$data['end_date']=$end_date;
			
			
	// 	}
	// 	if(!empty($brand_ID)){
	// 		$criteria[] = "item_id = ".$brand_ID;
	// 		$data['brand_name']=$brand;
	// 		$data['brand_ID']=$brand_ID;
	// 	}
		
	// 	if(empty($criteria)){
		
	// 		$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
	// 		$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
	// 		$data['from_date']=date("d-m-Y");
			
	// 		$data['end_date']=date("d-m-Y");
	// 	}

	// 	$criteria[] = "status = 0";

	// 	if(!empty($invoice_mode)){
		
	// 		$criteria[] = "sales_mode = '".$invoice_mode."'";
			
	// 		$data['invoice_mode']=$invoice_mode;

	// 	}else{
   
 //            $data['invoice_mode']='';

 //            $data['invoice_mode']='Sales';
	// 	}


 //        $distinct_items="";
	// 	if(!empty($criteria)){	
	// 	 $distinct_items=$this->invoice_model->searchdistinct_item($criteria);

	// 	}

	// 	// var_dump($distinct_items);exit();

	// 	$itemInfo=array();

	// 	if (empty($invoice_mode) || $invoice_mode=="Sales" ) {
			
	// 		$search[0]=$criteria[0];

	// 		$search[1]=$criteria[1];

	// 		$search[2] = "status = 0";

	// 		$search[3] = "sales_mode = 'Sales'";

	// 		if (!empty($brand_ID)) {
	// 			$search[4] = "item_id = '".$brand_ID."'";
	// 		}

	// 		$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



	// 	}
	// 	else if ($invoice_mode=="Return") {

	// 		$search[0]=$criteria[0];

	// 		$search[1]=$criteria[1];

	// 		$search[2] = "status = 0";

	// 		$search[3] = "sales_mode = 'Return'";

	// 		if (!empty($brand_ID)) {
	// 			$search[4] = "item_id = '".$brand_ID."'";
	// 		}
			

	// 		$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



	// 	}


	
	// 	if (!empty($itemInfo)) {
	// 		$data['itemInfo']=array_values($itemInfo);
	// 	}
	// 	else{
	// 		$data['itemInfo']="";
	// 	}
            
		

	// 	$data['export']=$export;

	// 	$this->load->view("reports/itemwise_report",$data);

	// }
    


    	public function itemwise_report($export=null){

		$this->load->model('invoice_model');

		// $data['user_info'] = $userInfo = $this->user->getUsers();

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");
		$invoice_mode=$this->input->post("invoice_mode");
		
		$criteria=array();
		$info=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($brand_ID)){
			$criteria[] = "item_id = ".$brand_ID;
			$data['brand_name']=$brand;
			$data['brand_ID']=$brand_ID;
		}
		
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
			$data['from_date']=date("d-m-Y");
			
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "status = 0";

		if(!empty($invoice_mode)){
		
			$criteria[] = "sales_mode = '".$invoice_mode."'";
			
			$data['invoice_mode']=$invoice_mode;

		}else{
   
            $data['invoice_mode']='';

            $data['invoice_mode']='Sales';
		}


        $distinct_items="";
		if(!empty($criteria)){	
		 $distinct_items=$this->invoice_model->searchdistinct_item($criteria);

		}

		// var_dump($distinct_items);exit();

		$itemInfo=array();

		if (empty($invoice_mode) || $invoice_mode=="Sales" ) {
			
			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "sales_mode = 'Sales'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}

			$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



		}
		else if ($invoice_mode=="Return") {

			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "sales_mode = 'Return'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}
			

			$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



		}


	
		if (!empty($itemInfo)) {
			$data['itemInfo']=array_values($itemInfo);
		}
		else{
			$data['itemInfo']="";
		}
            
		

		$data['export']=$export;

		$this->load->view("reports/itemwise_report",$data);

	}


	public function itemwise_detailed_report($item_id,$from_date,$to_date,$invoice_mode=null){

		$this->load->model('invoice_model');
	
		$criteria[] = "item_id = ".$item_id;
		$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
		$criteria[] = "status = 0";

		if(!empty($invoice_mode)) $criteria[] ="sales_mode='".$invoice_mode."'";
		
		$data['itemInfo']=$this->invoice_model->searchBillItems($criteria);	
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		
		
		$this->load->view('reports/itemwise_detailed_report',$data);
	
	}
	public function credit_payment_report($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$bill_status=$this->input->post("bill_status");
		$bill_no=$this->input->post("bill_no");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));

		$user_type=$this->input->post("user_type");

		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['from_date']="";			
		$data['end_date']="";
		
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
		}
		else{
			$criteria[] = "date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
		}
		
		if(!empty($end_date)){
			$criteria[] = "date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
			
		}
		else{
			$criteria[] = "date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");

		}
	
		if($bill_status != '') {
			
			$criteria[] ="status =".$bill_status;
		}else{
		
			$criteria[] ="status =0";
			
		}	

		if(!empty($bill_no)){
			$criteria[] = "bill_no = ".$bill_no;
			$data['bill_no']=$bill_no;
		}

		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		$data['bill_status']=$bill_status;

		$billInfo=$this->invoice_model->getCreditPayment($criteria);

		if (!empty($billInfo)) {

			$criteria1 = array();



			if(!empty($customer_type)){
				$criteria1[0] = "cust_type = '".$customer_type."'";
				$data['customer_type']=$customer_type;

			}
			else{
				unset($criteria1[0]);
			}

			if(!empty($customer_id)){
				
				if ($customer_type=="OP") {
					$criteria1[1] = "op_no = ".$customer_id;
				}
				else if ($customer_type=="IP") {
					$criteria1[1] = "ip_no = ".$customer_id;
				}

				$data['customer_id']=$customer_id;

			}
			else{
				unset($criteria1[1]);
			}

			if (!empty($criteria1)) {
	
				for ($i=0; $i <count($billInfo) ; $i++) { 
					$criteria1[2] = "id = ".$billInfo[$i][2]."";	
					$datas[$i]=$this->invoice_model->searchBill(array_values($criteria1));
					if (!empty($datas[$i])) {
						$final_data[0] = "bill_no = '".$datas[$i][0][1]."'";
						$billInfo_extra[$i]=$this->invoice_model->getCreditPayment($final_data);
					}

				}


			}


		}


		if (!empty($datas)) {
			$data['datas']=$datas;
			
		}
		if (!empty($billInfo_extra)) {

			$data['billInfo_extra']=array_values($billInfo_extra);

		}
		if (empty($criteria1)) {
			$data['billInfo']=$billInfo;
		}

		    $data['export']=$export;

		$this->load->view("reports/credit_payment_report",$data);

	}
	public function discount_report($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));

		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(!empty($payment_type)){
			
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
		}

		$criteria[] ="discount_type != ''";
		$criteria[] ="status = 0";

        /*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);
        
		$data['billInfo']=$this->invoice_model->searchBill($criteria,'',$limit);

		$data['export']=$export;	

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_invoice,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view("reports/discount_report",$data);

	}
	public function cancelled_bill($export=null){

		$this->load->model('invoice_model');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));
		
		$user_id=$this->input->post("user_id");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$customer_id=$this->input->post("customer_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');

		$data['payment_type_selected']="ALL";
		$data['user_name']="ALL";
		$data['cust_type']="ALL";
		$data['start_date']="";			
		$data['to_date']="";
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." ".$from_time."'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." ".$to_time."'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($customer_type)){
			$criteria[] = "cust_type = '".$customer_type."'";
			$data['customer_type']=$customer_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="cancelled_by "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "cancelled_by = ".$user_id;
		}
		if(!empty($customer_id)){
			
			if ($customer_type=="OP") {
				$criteria[] = "op_no = ".$customer_id;
			}
			else if ($customer_type=="IP") {
				$criteria[] = "ip_no = ".$customer_id;
			}
			$data['customer_id']=$customer_id;

		}		
		if(!empty($payment_type)){
			
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
		}

		$criteria[] ="status = 1";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);

		$data['billInfo']=$billInfo=$this->invoice_model->searchBill($criteria,'',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_invoice,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		$this->load->view("reports/cancelled_bill",$data);

	}
	public function purchase_report($export=null){
	
		$this->load->model('purchase_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}
		if(!empty($bill_no)){
			$criteria[] = "bill_no LIKE '%".$bill_no."%'";
			$data['bill_no']=$bill_no;
			
		}
		if(!empty($pono)){
			$criteria[] = "pono = '".$pono."'";
			$data['pono']=$pono;
		}
		
		if(!empty($payment_type)){
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "bill_date >= '".date("Y-m-d")."'";

			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
	
		}
		
		$criteria[] = "status = 0";

		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_purchase=$this->purchase_model->getPurchaseCount($criteria);

		$data['billInfo']=$this->purchase_model->searchPurchase($criteria,'','',$limit);

		$data['export']=$export;

		 if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/purchase_report',$data);
	}
	// public function purchase_itemwise_report($export=null){

	// 	$this->load->model('purchase_model');
		
	// 	$from_date=$this->input->post("from_date");
	// 	$end_date=$this->input->post("end_date");
	// 	$brand=$this->input->post("brand");
	// 	$brand_ID=$this->input->post("brand_ID");
	// 	$purchase_mode=$this->input->post("purchase_mode");

	// 	if(!empty($from_date)){
	// 		$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
	// 		$data['from_date']=$from_date;
			
			
	// 	}else{
	// 		$criteria[] = "bill_date >= '".date("Y-m-d")."'";
	// 		$data['from_date']=date("d-m-Y");
			
	// 	}
		
	// 	if(!empty($end_date)){
	// 		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
	// 		$data['end_date']=$end_date;
			
	// 	}else{
		
	// 		$criteria[] = "bill_date <= '".date("Y-m-d")."'";
	// 		$data['end_date']=date("d-m-Y");
	// 	}
	// 	if(!empty($brand_ID)){
		
	// 		$data['brand_name']=$brand;
	// 		// $data['brand_ID']=$brand_ID;
	// 		$criteria[] = "item_id = ".$brand_ID;
	// 	}

 //        $criteria[] = "status = 0";

	// 	if(!empty($purchase_mode)){

	// 		$data['purchase_mode']=$purchase_mode;
			
	// 		$criteria[] = "purchase_mode = '".$purchase_mode."'";

	// 	}else{
	// 		$data['purchase_mode']="";
	// 	}

	// 	$distinct_items=$this->purchase_model->searchdistinct_item($criteria);	
	
	// 	$itemInfo=array();
	
	// 	if(!empty($distinct_items)){
		
	// 		for($i=0;$i<count($distinct_items);$i++){
			
	// 			$item_id=$distinct_items[$i][0];
	// 			$search[0]="item_id = ".$item_id;
	// 			$search1[0]="item_id = ".$item_id;

	// 			$search[1]=$criteria[0];
	// 			$search1[1]=$criteria[0];

	// 			$search[2]=$criteria[1];
	// 			$search1[2]=$criteria[1];

	// 			$search[3] = "status = 0";
	// 			$search1[3] = "status = 0";

	// 			$search[4] = "purchase_mode = 'Recievings'";
	// 			if(!empty($purchase_mode)) $search[4] = "purchase_mode = '".$purchase_mode."'";

	// 			$search1[4] = "purchase_mode = 'Return'";

	// 			$pack=$this->purchase_model->total_quantity_sold($search,"PACK");
	// 			$pack1=$this->purchase_model->total_quantity_sold($search1,"PACK");

	// 			$strip=$this->purchase_model->total_quantity_sold($search,"STRIP");
	// 			$strip1=$this->purchase_model->total_quantity_sold($search1,"STRIP");

	// 			$tablet=$this->purchase_model->total_quantity_sold($search,"TABLET");
	// 			$tablet1=$this->purchase_model->total_quantity_sold($search1,"TABLET");

	// 			$pack +=$this->purchase_model->total_quantity_sold($search,"NOS");
	// 			$pack1 +=$this->purchase_model->total_quantity_sold($search1,"NOS");

							
	// 			$total_qty=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack,$strip,$tablet);
	// 			$total_qty1=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack1,$strip1,$tablet1);

	// 			$stock_conv=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty);
	// 			$stock_conv1=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty1);

	// 			$total_quantity=display_in_pack($stock_conv[0],$stock_conv[1],$stock_conv[2]);
	// 			$total_quantity1=display_in_pack($stock_conv1[0],$stock_conv1[1],$stock_conv1[2]);
				
	// 			$total_amount=$this->purchase_model->total_amount_sold($search);
	// 			$total_amount1=$this->purchase_model->total_amount_sold($search1);
				
	// 		    if(empty($purchase_mode)){

	// 			    $itemInfo[$i][0]=$distinct_items[$i][1];
	// 			    $itemInfo[$i][1]=$total_quantity-$total_quantity1;
	// 			    $itemInfo[$i][2]=to_currency($total_amount-$total_amount1);
	// 			    $itemInfo[$i][3]=$item_id;

	// 			}else{

 //                    $itemInfo[$i][0]=$distinct_items[$i][1];
	// 			    $itemInfo[$i][1]=$total_quantity;
	// 			    $itemInfo[$i][2]=to_currency($total_amount);
	// 			    $itemInfo[$i][3]=$item_id;

	// 			}
	// 		}
	// 	}
	// 	$data['itemInfo']=array_values($itemInfo);	

	// 	$data['export']=$export;

	// 	$this->load->view('reports/purchase_itemwise_report',$data);

	// }
	public function itemwise_detailed_report_recievings($item_id,$from_date,$to_date,$purchase_mode=null){
		
		$this->load->model('purchase_model');

		$criteria[] = "item_id = ".$item_id;
		$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
		$criteria[] = "status = 0";

		if(!empty($purchase_mode)) $criteria[] = "purchase_mode = '".$purchase_mode."'";
		
		$data['itemInfo']=$this->purchase_model->searchPurchaseItems($criteria);	
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		
		
		$this->load->view('reports/itemwise_detailed_report_recievings',$data);
	
	}
	public function purchase_return($export=null){

		$this->load->model('purchase_model');

        $count_items=0;

		$data['user_info'] = $userInfo = $this->user->getUsers();
		// $data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")."'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=date("d-m-Y");
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
			$data['end_date']=date("d-m-Y");
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}
		
		$criteria[] ="purchase_mode ='Return'";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }
		
		// $data['itemInfo']=$this->purchase_model->searchPurchaseItems($criteria);


		if(!empty($user_type) || !empty($user_id) ){

			if (!empty($user_type)) {
	
				$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
				$data['user_type']=$user_type;
				$search[] = "user_type =".$user_type;
				$data['user_info'] = $userInfo = $this->user->getUsers($search);
				for($i=0;$i<count($userInfo);$i++){

					$user_id_new[] =$userInfo[$i][0];

				}
				$matches = implode(',', $user_id_new);
				if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";

			}
			
           
			$data['billInfo']=$billInfo=$this->purchase_model->searchPurchase($criteria);

	

			if (!empty($billInfo)) {

				$search_final = array();
				$search_final[0] ="purchase_mode = 'Return'";
				for ($i=0; $i <count($billInfo) ; $i++) { 

					$bill_id_new[] =$billInfo[$i][1];
				
				}
				$matches = implode(',', $bill_id_new);

				if(!empty($matches)) $criteria1[] ="bill_id "." "."in ( $matches )";
				$count_items=$this->purchase_model->getPurchaseItemsCount($criteria1);
				$data['itemInfo']=$itemInfo=$this->purchase_model->searchPurchaseItems($criteria1,$limit);

			}

		}
		else{
			$count_items=$this->purchase_model->getPurchaseItemsCount($criteria);
			$data['itemInfo']=$itemInfo=$this->purchase_model->searchPurchaseItems($criteria,$limit);
		}

            $data['export']=$export;

        if(empty($export)){
           $data['pagination_link']=printPageLinks($count_items,$current_page,$perPage);
        }
       
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/purchase_return',$data);
	}
	public function supplier_purchase_report($export=null){
		
		$this->load->model('purchase_model');
		$this->load->model('supplier');

		$data['suppliers']=$this->supplier->getSupplier();
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}

		if(empty($criteria)){

			$criteria[] = "bill_date >= '".date("Y-m-d")."'";

			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
		
		}

		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_purchase=$this->purchase_model->getPurchaseCount($criteria);
	
		$data['billInfo']=$this->purchase_model->searchPurchase($criteria,'','',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/supplier_purchase_report',$data);
	}
	public function issue_cheque_report($export=null){

		$this->load->model('purchase_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$data['suppliers']=$this->supplier->getSupplier();

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');


		if(!empty($from_date)){
			$criteria[] = "cheque_issue_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "cheque_issue_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}
		if(!empty($bill_no)){
			$criteria[] = "bill_no = ".$bill_no;
			$data['bill_no']=$bill_no;
			
		}
		if(!empty($pono)){
			$criteria[] = "pono = '".$pono."'";
			$data['pono']=$pono;
		}
		
		if(!empty($payment_type)){
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "cheque_issue_date >= '".date("Y-m-d")."'";
		
			$criteria[] = "cheque_issue_date <= '".date("Y-m-d")."'";

		}

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_purchase=$this->purchase_model->getPurchaseCount($criteria);
	
		$data['billInfo']=$this->purchase_model->searchPurchase($criteria,'','',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		$this->load->view('reports/issue_cheque_report',$data);
	}
	public function purchase_cancelled_report($export=null){
	
		$this->load->model('purchase_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}
		if(!empty($bill_no)){
			$criteria[] = "bill_no = ".$bill_no;
			$data['bill_no']=$bill_no;
			
		}
		if(!empty($pono)){
			$criteria[] = "pono = '".$pono."'";
			$data['pono']=$pono;
		}
		
		if(!empty($payment_type)){
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="cancelled_user "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "cancelled_user = ".$user_id;
		}

        if(empty($criteria)){

			$criteria[] = "bill_date >= '".date("Y-m-d")."'";
		
			$criteria[] = "bill_date <= '".date("Y-m-d")."'";

        }

		$criteria[] = "status = 1";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_purchase=$this->purchase_model->getPurchaseCount($criteria);
	
		$data['billInfo']=$this->purchase_model->searchPurchase($criteria,'','',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	
		
		$this->load->view('reports/purchase_cancelled_report',$data);
	}
	public function movement_item_report($export=null){

		$this->load->model('movement_model');

		$this->load->model('branch');
		
	    $data['branchInfo']=$this->branch->getBranch(); 

		$data['user_info'] = $userInfo = $this->user->getUsers();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$move_from=$this->input->post('move_from');
		$move_to=$this->input->post('move_to');
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

			if(!empty($from_date)){
				$criteria[] = "movement_date >= '".date("Y-m-d",strtotime($from_date))."'";
				$data['from_date']=$from_date;
			}else{
				$criteria[] = "movement_date >= '".date("Y-m-d")."'";
				$data['from_date']=date("d-m-Y");
			} 
		
			if(!empty($end_date)){
				$criteria[] = "movement_date <= '".date("Y-m-d",strtotime($end_date))."'";
				$data['end_date']=$end_date;
			}else{
				$criteria[] = "movement_date <= '".date("Y-m-d")."'";
				$data['end_date']=date("d-m-Y");
			} 
		
			if(!empty($move_from)){
				$criteria[] = "move_from = '".$move_from."'";
				$data['move_from']=$move_from;
			}
				
			if(!empty($move_to)){
				$criteria[] = "move_to = '".$move_to."'";
				$data['move_to']=$move_to;
			}
			
			$movement=$this->movement_model->searchMovement($criteria);
			$movementInfo=array();
			$mainInfo=array();
			if(!empty($movement)){
			
				for($i=0;$i<count($movement);$i++){
				
					$movement_id=$movement[$i][1];
					
					$criteria1[0] = "movement_id = ".$movement_id;
					$movementInfo[$i]=$itemInfo=$this->movement_model->searchMovementItems($criteria1);
					
					//echo $i;
					
					$mainInfo[$i][0]=$movement[$i][2];
					$mainInfo[$i][1]=$movement[$i][3];
					$mainInfo[$i][2]=$movement[$i][4];
					$mainInfo[$i][3]=$movement[$i][5];					
					$mainInfo[$i][4]=$movement[$i][6];
				
				}
			}

		$data['movementInfo']=$movementInfo;
		$data['mainInfo']=$mainInfo;

        $data['export']=$export;

		$this->load->view('reports/movement_item_report',$data);
	}
	public function movement_report($export=null){
	
		$this->load->model('movement_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "movement_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "movement_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "movement_date >= '".date("Y-m-d")."'";
	
			$criteria[] = "movement_date <= '".date("Y-m-d")."'";

		}
		
		$criteria[] = "status = 0";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_movement=$this->movement_model->getMovementCount($criteria);

		$data['movement']=$movement=$this->movement_model->searchMovement($criteria,'',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_movement,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	
		
		$this->load->view('reports/movement_report',$data);
	}
	public function cancelled_movement_reports($export=null){
	
		$this->load->model('movement_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "movement_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "movement_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="cancelled_by "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "cancelled_by = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "movement_date >= '".date("Y-m-d")."'";

			$criteria[] = "movement_date <= '".date("Y-m-d")."'";

		}
		
		$criteria[] = "status = 1";
		$cancelled = "cancelled";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_movement=$this->movement_model->getMovementCount($criteria);

		$data['movement']=$movement=$this->movement_model->searchMovement($criteria,$cancelled,$limit);

		$data['export']=$export;

		if(empty($export)){
            $data['pagination_link']=printPageLinks($count_movement,$current_page,$perPage);
        }
       
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/cancelled_movement_reports',$data);
	}
	public function stock_report($export= null){

		$this->load->model('brand_model');

		$data['categoryInfo']= $categoryInfo=$this->brand_model->getCategory();

		$data['brand_name']=$brand_name=$this->input->post('brand_name');
		$brand_ID=$this->input->post('brand_ID');
		$category=$this->input->post('category');

		$current_page=$this->input->post('current_page');

		$search=array();
        $limit="";
		$k=0;
		$message='';

		if(!empty($brand_name)){
			$search[$k++]="brand like '%".$brand_name."%'";
			
		}
		if(!empty($category)){
			$search[$k++]="category_id = ".$category;
			$data['category_name']=$category_name=$this->commonDBFunctions->getidToValue('category','id',$category,'pharma_brand_category');
			$data['category']=$category;
			
		}
		
		$search[$k++]="(brand_stock >0 OR branch_stock>0)";

		$search[$k++]="status = 0";


/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

		$countbrand=$this->brand_model->countBrand($search);

        $data['brand']=$this->brand_model->getBrand($search,$limit);

        $data['stock_history']=$this->brand_model->brandStocks_and_price($search);

        $data['export']=$export;

        if(empty($export)){
           $data['pagination_link']=printPageLinks($countbrand,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view('reports/stock_report',$data);
	}

	public function batch_report($brand_id){

		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('branch');

		$data['brand_id'] = $brand_id;

		$data['brand_name'] =  $this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			
		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;
		$search[1]="expiry_date >'".$newDate."'";
		$search[2]="batch_stock >0";

		$branch_selected=$this->input->post("branch");
		
		if(!empty($branch_selected)){
			
			if($branch_selected == "main_branch"){
			
				$search[]="branch_id =0";
			}else{
				$search[]="branch_id = ".$branch_selected;
			}

			$data['branch'] = $branch_selected;
		}
		
		$data['batch']=$this->batch_model->getBatch($search);

		$data['branchInfo']=$this->branch->getBranch(); 
					
		$this->load->view('reports/batch_report',$data);
	
	}
	public function low_inventory_report($export= null){

		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('branch');

		$data['branchInfo']=$this->branch->getBranch(); 
			
			$generic_name=$this->input->post("generic_name");
			$branch_selected=$this->input->post("branch");
			$brand_id=$this->input->post("brand_ID");
			$brand_name=$this->input->post("brand");

			$current_page=$this->input->post('current_page');
		
		    if(!empty($brand_id)){
		
		      $search[]="a.id ='".$brand_id."'";
		      $data['brand_id']=$brand_id;
		      $data['brand_name']=$brand_name;
		      
		   }
		   if(!empty($generic_name)){
		
		      $search[]="a.generic_name ='".$generic_name."'";
		      $data['generic_name']=$generic_name;
		      
		   }
		   if(!empty($branch_selected)){
			
				if($branch_selected == "main_branch"){
				
					$search[]="(a.brand_stock < a.re_order_level or a.brand_stock =0)";
					$search[]="b.branch_id =0";
					$data['branch_selected']=0;
				}else{
					$search[]="a.branch_stock < a.re_order_level or a.branch_stock =0";
					$data['branch_selected']=$branch_selected;
					$search[]="b.branch_id ='".$branch_selected."'";
					
				}
				
			}else {
		
			  $search[]="(a.brand_stock < a.re_order_level or a.brand_stock =0)";
			  $data['branch_selected']=0;
			  $search[]="b.branch_id =0";
			}
			$data['branch_selected_name'] = $this->commonDBFunctions->getidToValue('branch_name','id',$branch_selected,'pharma_branch');

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }
			
		$countbrand=$this->brand_model->countLowInventory($search);

        $data['brand']=$this->brand_model->getLowInventory($search,$limit);

        $data['export']=$export;

         if(empty($export)){
           $data['pagination_link']=printPageLinks($countbrand,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
 
		$this->load->view('reports/low_inventory_report',$data);
		
	}
	public function expired_medicines_report($export= null){
	
		
		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('branch');
		
		$data['branchInfo']=$this->branch->getBranch(); 

		$expired_date=$this->input->post("expired_date");
		
		if((empty($expired_date))){
			$expired_date = date("Y-m-d",strtotime("+30 day"));
		}
		$data['expired_date'] = date("d-m-Y",strtotime($expired_date));

		$brand_id=$this->input->post("brand_ID");
		$brand_name=$this->input->post("brand");

		$current_page=$this->input->post('current_page');
		
		if(!empty($brand_id)){
		
		  $search[]="brand_id ='".$brand_id."'";
		  $data['brand_id'] = $brand_id;
		  $data['brand_name'] = $brand_name;
		  $status = 1;

		}
		
		$batch_no=$this->input->post("batch_no");
		
		if(!empty($batch_no)){
		
		  $search[]="batch_number like '%".$batch_no."%'";
		  $data['batch_no'] = $batch_no;
		  $status = 1;

		}
		
		$search[]="expiry_date <='".date("Y-m-d",strtotime($expired_date))."'";
		
		$branch_selected=$this->input->post("branch");
		
		if(!empty($branch_selected)){
			
			if($branch_selected == "main_branch"){
			
				$search[]="branch_id =0";
			}else{
				$search[]="branch_id = ".$branch_selected;
			}
			$data['branch_selected'] = $branch_selected;
			$data['branch_selected_name'] = $this->commonDBFunctions->getidToValue('branch_name','id',$branch_selected,'pharma_branch');
			$status = 1;
		}
		$search[]="batch_stock > 0";

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];

        if(!empty($export)){

        	 $limit='';
        }

		$countBatch=$this->batch_model->countBatch($search);
       
        $data['batch']=$this->batch_model->getBatch($search,$limit);

        $data['export']=$export;

        if(empty($export)){
           $data['pagination_link']=printPageLinks($countBatch,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
        
		$this->load->view('reports/expiry_report',$data);
	}
public function non_movement_report($export= null){
	
		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('branch');

		$search='';
		$k=0;
		$message='';

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			$status = 1;
			
		}else{
			$time = strtotime(date("Y-m-d"));
		    $from	=	date("Y-m-d", strtotime("-3 month", $time)); 
			$criteria[] = "bill_date >= '".$from."'";
			$data['from_date']=date("d-m-Y", strtotime($from));
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=date("d-m-Y");
			$status = 1;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
			$data['end_date']=date("d-m-Y");
		}

/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

		$count_rows=$this->brand_model->CountNonMovBrand($criteria);

		$data['brand']=$this->brand_model->getNonMovBrand($criteria,$limit);
		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_rows,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/non_movement_report',$data);
	}


    function getBillCollections_graph(){

        $this->load->model('invoice_model');
	    
	    $start_date=date("Y-m-d");
	    for($k=0;$k<7;$k++){
	          
		     
            $prev_date=date("Y-m-d",strtotime("-1 day",strtotime($start_date)));
		  
		    $info["x"]=date("d-m-Y",strtotime($start_date));
		    $info["y"]=$this->invoice_model->oneWeekBillCollection($start_date);
			
			 $start_date=$prev_date;
		  
		    $data[$k]=$info;
		}

		echo json_encode($data);

	}

	function getDetailedBillCollection_graph(){

		$this->load->model('invoice_model');

        $today_collection=$this->invoice_model->todayDetailedBillCollection();

        $info["cash"]=$today_collection[0];
        $info["card_amount"]=$today_collection[1];
        $info["credit_amont"]=$today_collection[2];
        $info["credit_payment"]=$today_collection[3];
      
       echo json_encode($info);
	}

	function dailyBillCollection($export= null){ 

		$this->load->model('invoice_model');

                	$data['export']=$export;
		$user_type_search[] = "id = 8 or id= 9";

		$data['userTypeInfo'] = $this->user->getUsertype($user_type_search);

		$search_user_id='';

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$user_type=$this->input->post("user_type");
		$user_id=$this->input->post("user_id");

		$data['from_time']=$from_time=$this->input->post("from_time");
		if (empty($from_time)) {
			$from_time = "00:00:00";
		}
	    $from_time=date("H:i:s",strtotime($from_time));
    
		$data['to_time']=$to_time=$this->input->post("to_time");
		if (empty($to_time)) {
			$to_time = "23:59:59";
		}
	    $to_time=date("H:i:s",strtotime($to_time));


		if(!empty($from_date)){
		    $fromdate = date("Y-m-d",strtotime($from_date))." ".$from_time;
			$data['from_date']=$from_date;
			
		}else{
            $fromdate = date("Y-m-d")." 00:00:00";
            $data['from_date']=date("d-m-Y");
		}
		
		if(!empty($end_date)){
			$todate = date("Y-m-d",strtotime($end_date))." ".$to_time;
			$data['end_date']=$end_date;
			
		}else{
            $todate = date("Y-m-d")." 23:59:59";
            $data['end_date']=date("d-m-Y");
		}
    
       
		if(!empty($user_type)){
		      $search_type[]="user_type =".$user_type;
		      $data['user_type']=$user_type;
		      $data['user_type_name']=$this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');

		      $data['user_info'] =$userInfo= $this->user->getUsers($search_type);
		      if(!empty($userInfo)){
                  
                  $user_id_all='';

                  for($i=0;$i<count($userInfo);$i++){  

				       $user_id_all.=$userInfo[$i][0].",";   
	              }

	                   $user_id_all=rtrim($user_id_all,',');  
					   $search_user_id="user_id in (".$user_id_all.")";

		      }

		}else{

              $data['user_info'] =$userInfo= $this->user->getUsers();
		}

		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$search_user_id = "user_id = ".$user_id;
		}

		$data['collectionInfo']=$this->invoice_model->daily_bill_collection($fromdate,$todate,$search_user_id);

        
       $this->load->view('reports/daily_bill_collection_report',$data);
	}
    
    function gstPurchaseReport($export = null){

    	$this->load->model('purchase_model');
		$this->load->model('supplier');

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}
		if(!empty($bill_no)){
			$criteria[] = "bill_no = ".$bill_no;
			$data['bill_no']=$bill_no;
			
		}
		if(!empty($pono)){
			$criteria[] = "pono = '".$pono."'";
			$data['pono']=$pono;
		}
		
		if(!empty($payment_type)){
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "bill_date >= '".date("Y-m-d")."'";

			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
	
		}
		
		$criteria[] = "status = 0";

		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_purchase=$this->purchase_model->getPurchaseCount($criteria);

		$data['billInfo']=$this->purchase_model->searchPurchase($criteria,'','',$limit);

		$data['export']=$export;

		 if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/gst_purchase_report',$data);

    }

    function hsnWisePurchaseReport($export=null){

        $this->load->model('purchase_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$current_page=$this->input->post('current_page');

		$count_items=0;
	

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")."'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "status = 0";

        /*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

		$billInfo=$this->purchase_model->searchPurchase($criteria);

		if(!empty($billInfo)){

            for ($i=0; $i <count($billInfo) ; $i++) { 

				$bill_id_new[] =$billInfo[$i][1];
				
			}
			$matches = implode(',', $bill_id_new);

			if(!empty($matches)) $criteria1[] ="bill_id "." "."in ( $matches )";
			$criteria1[]="status = 0";
			$count_items=$this->purchase_model->getPurchaseItemsCount($criteria1);
			$data['itemInfo']=$this->purchase_model->searchPurchaseItems($criteria1,$limit);


		}else{

            $data['itemInfo']='';

		}

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_items,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		
		$data['export']=$export;
		
		$this->load->view('reports/hsn_wise_purchase_report',$data);

    }

  //   function hsnWiseSalesReport($export=null){

  //       $this->load->model('invoice_model');
		
		// $from_date=$this->input->post("from_date");
		// $end_date=$this->input->post("end_date");

		// if(!empty($from_date)){
		// 	$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
		// 	$data['from_date']=$from_date;
			
			
		// }else{
		// 	$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
		// 	$data['from_date']=date("d-m-Y");
			
		// }
		
		// if(!empty($end_date)){
		// 	$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
		// 	$data['end_date']=$end_date;
			
		// }else{
		
		// 	$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
		// 	$data['end_date']=date("d-m-Y");
		// }

  //       $criteria[] = "sales_mode = 'Sales'";
		// $criteria[] = "status = 0";

  //       $hsn_base_bill_details=array();

		// $billInfo=$this->invoice_model->searchBill($criteria);

		// if(!empty($billInfo)){

  //           for ($i=0; $i <count($billInfo) ; $i++) { 

		// 		$bill_id_new[] =$billInfo[$i][1];
				
		// 	}
		// 	$matches = implode(',', $bill_id_new);

		// 	if(!empty($matches)){

		// 		$criteria1[] ="bill_id "." "."in ( $matches )";
		// 		$criteria1[] ="status = 0";
		// 		$search_bill_wise ="bill_id "." "."in ( $matches )";

		// 	}
           
  //       // hsn base details   
  //           $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria1);

  //         if(!empty($hsn_no)){
            
  //           for($i=0; $i<count($hsn_no); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_hsn_no_base_details($search_bill_wise,$hsn_no[$i],"Sales");
  //           }

  //         }

  //       // brand with no hsn_no details 
  //           $brand_id=$this->invoice_model->searchdistinct_brand_no_hsn_no($criteria1);

  //         if(!empty($brand_id)){
            
  //           for($i=0; $i<count($brand_id); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details($search_bill_wise,$brand_id[$i],"Sales");
  //           }

  //         }


		//   $data['itemInfo']=array_values($hsn_base_bill_details);


		// }else{

  //           $data['itemInfo']='';

		// }

		
		// $data['export']=$export;
		
		// $this->load->view('reports/hsn_wise_sales_report',$data);

  //   }

  //   function hsnWiseSalesReturnReport($export=null){

  //      $this->load->model('invoice_model');
		
		// $from_date=$this->input->post("from_date");
		// $end_date=$this->input->post("end_date");

		// if(!empty($from_date)){
		// 	$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
		// 	$data['from_date']=$from_date;
			
			
		// }else{
		// 	$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
		// 	$data['from_date']=date("d-m-Y");
			
		// }
		
		// if(!empty($end_date)){
		// 	$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
		// 	$data['end_date']=$end_date;
			
		// }else{
		
		// 	$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
		// 	$data['end_date']=date("d-m-Y");
		// }

  //       $criteria[] = "sales_mode = 'Return'";
		// $criteria[] = "status = 0";

  //       $hsn_base_bill_details=array();

		// $billInfo=$this->invoice_model->searchBill($criteria);

		// if(!empty($billInfo)){

  //           for ($i=0; $i <count($billInfo) ; $i++) { 

		// 		$bill_id_new[] =$billInfo[$i][1];
				
		// 	}
		// 	$matches = implode(',', $bill_id_new);

		// 	if(!empty($matches)){

		// 		$criteria1[] ="bill_id "." "."in ( $matches )";
		// 		$criteria1[] ="status = 0";
		// 		$search_bill_wise ="bill_id "." "."in ( $matches )";

		// 	}
           
  //       // hsn base details   
  //           $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria1);

  //         if(!empty($hsn_no)){
            
  //           for($i=0; $i<count($hsn_no); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_hsn_no_base_details($search_bill_wise,$hsn_no[$i],"Return");
  //           }

  //         }

  //       // brand with no hsn_no details 
  //           $brand_id=$this->invoice_model->searchdistinct_brand_no_hsn_no($criteria1);

  //         if(!empty($brand_id)){
            
  //           for($i=0; $i<count($brand_id); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details($search_bill_wise,$brand_id[$i],"Return");
  //           }

  //         }


		//   $data['itemInfo']=array_values($hsn_base_bill_details);


		// }else{

  //           $data['itemInfo']='';

		// }

		
		// $data['export']=$export;
		
		// $this->load->view('reports/hsn_wise_sales_return_report',$data);

  //   }

  //   function hsnWiseSummaryReport($export=null){

  //       $this->load->model('invoice_model');
		
		// $from_date=$this->input->post("from_date");
		// $end_date=$this->input->post("end_date");

		// if(!empty($from_date)){
		// 	$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
		// 	$data['from_date']=$from_date;
			
			
		// }else{
		// 	$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
		// 	$data['from_date']=date("d-m-Y");
			
		// }
		
		// if(!empty($end_date)){
		// 	$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
		// 	$data['end_date']=$end_date;
			
		// }else{
		
		// 	$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
		// 	$data['end_date']=date("d-m-Y");
		// }

		// $criteria[] = "status = 0";

  //       $hsn_base_bill_details=array();

		// $billInfo=$this->invoice_model->searchBill($criteria);

		// if(!empty($billInfo)){

  //           for ($i=0; $i <count($billInfo) ; $i++) { 

		// 		$bill_id_new[] =$billInfo[$i][1];
				
		// 	}
		// 	$matches = implode(',', $bill_id_new);

		// 	if(!empty($matches)){

		// 		$criteria1[] ="bill_id "." "."in ( $matches )";
		// 		$criteria1[] ="status = 0";
		// 		$search_bill_wise ="bill_id "." "."in ( $matches )";

		// 	}
           
  //       // hsn base details   
  //           $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria1);

  //         if(!empty($hsn_no)){
            
  //           for($i=0; $i<count($hsn_no); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_hsn_no_base_details_summary($search_bill_wise,$hsn_no[$i]);
  //           }

  //         }

  //       // brand with no hsn_no details 
  //           $brand_id=$this->invoice_model->searchdistinct_brand_no_hsn_no($criteria1);

  //         if(!empty($brand_id)){
            
  //           for($i=0; $i<count($brand_id); $i++){

  //                $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details_summary($search_bill_wise,$brand_id[$i]);
  //           }

  //         }


		//   $data['itemInfo']=array_values($hsn_base_bill_details);


		// }else{

  //           $data['itemInfo']='';

		// }

		
		// $data['export']=$export;

  //       $this->load->view('reports/hsn_wise_summary_report',$data);
  //   }


      function salesReportCtwoBtwo($export=null){

        $this->load->model('invoice_model');
        $this->load->model('gst_model');

        $gst_id='';
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$show_report=$this->input->post("show_report");

		if(!empty($from_date)){
			$criteria[0] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[0] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[1] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[1] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

		if(!empty($show_report)){
			
			$data['show_report']=$show_report;
			
		}

		$criteria[2] = "status = 0";


			$gst_id=$this->invoice_model->searchdistinct_gst($criteria);

            if(!empty($gst_id)){

              for ($i=0; $i <count($gst_id) ; $i++) { 

				
              	$criteria[3] = "gst_id = '".$gst_id[$i]."'";

              	$gst_sales_details[$i]=$this->invoice_model->seprated_gst_total($criteria,$gst_id[$i],'Sales');

              	$gst_return_details[$i]=$this->invoice_model->seprated_gst_total($criteria,$gst_id[$i],'Return');

              	$gst_netsales_details[$i]=$this->invoice_model->seprated_net_gst_total($criteria,$gst_id[$i]);




			  }


				$data['itemInfo_sales']=$gst_sales_details;
				$data['itemInfo_return']=$gst_return_details;
				$data['itemInfo_netsales']=$gst_netsales_details;
			}
			else{


				$data['itemInfo_sales']="";
				$data['itemInfo_return']="";
				$data['itemInfo_netsales']="";

			}





		$data['export']=$export;

        $this->load->view('reports/b2c2_sales_report',$data);
    }

    

    function salesFile($export=null){
        
        $this->load->model('invoice_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$current_page=$this->input->post('current_page');
		
		$count_items=0;
	

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "status = 0";

        /*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }
        
        $count_invoice=$this->invoice_model->getInvoiceCount($criteria);
		$billInfo=$this->invoice_model->searchBill($criteria);

		if(!empty($billInfo)){

            for ($i=0; $i <count($billInfo) ; $i++) { 

				$bill_id_new[] =$billInfo[$i][1];
				
			}
			$matches = implode(',', $bill_id_new);

			if(!empty($matches)) $criteria1[] ="bill_id "." "."in ( $matches )";
			$criteria1[]="status = 0";
			$count_items=$this->invoice_model->searchBillItemsCount($criteria1);
			$data['itemInfo']=$this->invoice_model->searchBillItems($criteria1,$limit);

		}else{

            $data['itemInfo']='';

		}

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_items,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$data['export']=$export;

        $this->load->view('reports/sales_file_report',$data);
    }

    public function h1n_sheduled_x($export=null){

		$this->load->model('invoice_model');

		// $data['user_info'] = $userInfo = $this->user->getUsers();

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");
		$invoice_mode=$this->input->post("invoice_mode");
		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "b.`bill_date` >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
		    $criteria1[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
				
		}
		
		if(!empty($end_date)){
			$criteria[] = "b.`bill_date` <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$criteria1[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
				
		}
		if(!empty($brand_ID)){
			$criteria[] = "b.`item_id` = ".$brand_ID;
			$data['brand_name']=$brand;
			$data['brand_ID']=$brand_ID;
		}
		
		if(empty($criteria)){
		
			$criteria[] = "b.`bill_date` >= '".date("Y-m-d")." 00:00:00'";
			$criteria1[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "b.`bill_date` <= '".date("Y-m-d")." 23:59:59'";
			$criteria1[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
			$data['from_date']=date("d-m-Y");
			
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "a.`h1n_sheduled_x` = 1";
		$criteria[] = "a.`status` = 0";
		$criteria[] = "b.`status` = 0";

		if(!empty($invoice_mode)){
		
			$criteria[] = "sales_mode = '".$invoice_mode."'";
			
			$data['invoice_mode']=$invoice_mode;

		}else{
   
            $data['invoice_mode']='';
		}


        $distinct_items="";
		if(!empty($criteria)){	
		 $distinct_items=$this->invoice_model->searchdistinct_h1n_shld_x_item($criteria);

		}

		$itemInfo=array();
	
		if(!empty($distinct_items)){
		
			for($i=0;$i<count($distinct_items);$i++){
			
				$item_id=$distinct_items[$i][0];
				$bill_no=$distinct_items[$i][2];

				$search[0]="item_id = ".$item_id;
				$search1[0]="item_id = ".$item_id;

				$search[1]=$criteria1[0];
				$search1[1]=$criteria1[0];

				$search[2]=$criteria1[1];
				$search1[2]=$criteria1[1];

				$search[3] = "status = 0";
				$search1[3] = "status = 0";

				$search[4] = "sales_mode = 'Sales'";
                if(!empty($invoice_mode)) $search[4] ="sales_mode = '".$invoice_mode."'";

				$search1[4] = "sales_mode = 'Return'";
             
				$pack=$this->invoice_model->total_quantity_sold($search,"PACK");
				$pack1=$this->invoice_model->total_quantity_sold($search1,"PACK");

				$strip=$this->invoice_model->total_quantity_sold($search,"STRIP");
				$strip1=$this->invoice_model->total_quantity_sold($search1,"STRIP");

				$tablet=$this->invoice_model->total_quantity_sold($search,"TABLET");
				$tablet1=$this->invoice_model->total_quantity_sold($search1,"TABLET");

				$pack +=$this->invoice_model->total_quantity_sold($search,"NOS");
				$pack1 +=$this->invoice_model->total_quantity_sold($search1,"NOS");
				
							
				$total_qty=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack,$strip,$tablet);
				$total_qty1=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack1,$strip1,$tablet1);

				$stock_conv=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty);
				$stock_conv1=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty1);

				$total_quantity=display_in_pack($stock_conv[0],$stock_conv[1],$stock_conv[2]);
				$total_quantity1=display_in_pack($stock_conv1[0],$stock_conv1[1],$stock_conv1[2]);
				
				$total_amount=$this->invoice_model->total_amount_sold($search);
				$total_amount1=$this->invoice_model->total_amount_sold($search1);
				
				if(empty($invoice_mode)){
				
					$itemInfo[$i][0]=$distinct_items[$i][2];
					$itemInfo[$i][1]=$total_quantity-$total_quantity1;
					$itemInfo[$i][2]=to_currency($total_amount-$total_amount1);
					$itemInfo[$i][3]=$item_id;

				}else{

                   if($total_quantity > 0 ) {

                      $itemInfo[$i][0]=$distinct_items[$i][2];
					  $itemInfo[$i][1]=$total_quantity;
					  $itemInfo[$i][2]=to_currency($total_amount);
					  $itemInfo[$i][3]=$item_id;

				   }

				}
			}
		}
            
		$data['itemInfo']=array_values($itemInfo);
       
		$data['export']=$export;

		$this->load->view("reports/h1n_sheduled_x_report",$data);

	}

	public function h1n_sheduled_x_detailed_report($item_id,$from_date,$to_date,$invoice_mode=null){

		$this->load->model('invoice_model');
	
		$criteria[] = "item_id = ".$item_id;
		$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
		$criteria[] = "status = 0";

		if(!empty($invoice_mode)) $criteria[] ="sales_mode='".$invoice_mode."'";
		
		$data['itemInfo']=$this->invoice_model->searchBillItems($criteria);	
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		
		
		$this->load->view('reports/h1n_sheduled_x_detailed_report',$data);
	
	}

	// public function FastMovingMedicineReport($export=null){

	// 	$this->load->model('invoice_model');

	// 	// $data['user_info'] = $userInfo = $this->user->getUsers();

	// 	$from_date=$this->input->post("from_date");
	// 	$end_date=$this->input->post("end_date");
	// 	$brand=$this->input->post("brand");
	// 	$brand_ID=$this->input->post("brand_ID");
	// 	$invoice_mode=$this->input->post("invoice_mode");
		
	// 	$criteria=array();

	// 	if(!empty($from_date)){
	// 	    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
	// 		$data['from_date']=$from_date;
			
			
	// 	}
		
	// 	if(!empty($end_date)){
	// 		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
	// 		$data['end_date']=$end_date;
			
			
	// 	}
	// 	if(!empty($brand_ID)){
	// 		$criteria[] = "item_id = ".$brand_ID;
	// 		$data['brand_name']=$brand;
	// 		$data['brand_ID']=$brand_ID;
	// 	}
		
	// 	if(empty($criteria)){
		
	// 		$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
	// 		$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
	// 		$data['from_date']=date("d-m-Y");
			
	// 		$data['end_date']=date("d-m-Y");
	// 	}

	// 	$criteria[] = "status = 0";

	// 	if(!empty($invoice_mode)){
		
	// 		$criteria[] = "sales_mode = '".$invoice_mode."'";
			
	// 		$data['invoice_mode']=$invoice_mode;

	// 	}else{
   
 //            $data['invoice_mode']='';
	// 	}


 //        $distinct_items="";
	// 	if(!empty($criteria)){	
	// 	 $distinct_items=$this->invoice_model->searchdistinct_item($criteria);

	// 	}

	// 	$itemInfo=array();
	
	// 	if(!empty($distinct_items)){
		
	// 		for($i=0;$i<count($distinct_items);$i++){
			
	// 			$item_id=$distinct_items[$i][0];
	// 			$search[0]="item_id = ".$item_id;
	// 			$search1[0]="item_id = ".$item_id;

	// 			$search[1]=$criteria[0];
	// 			$search1[1]=$criteria[0];

	// 			$search[2]=$criteria[1];
	// 			$search1[2]=$criteria[1];

	// 			$search[3] = "status = 0";
	// 			$search1[3] = "status = 0";

	// 			$search[4] = "sales_mode = 'Sales'";
 //                if(!empty($invoice_mode)) $search[4] ="sales_mode = '".$invoice_mode."'";

	// 			$search1[4] = "sales_mode = 'Return'";

	// 			$pack=$this->invoice_model->total_quantity_sold($search,"PACK");
	// 			$pack1=$this->invoice_model->total_quantity_sold($search1,"PACK");

	// 			$strip=$this->invoice_model->total_quantity_sold($search,"STRIP");
	// 			$strip1=$this->invoice_model->total_quantity_sold($search1,"STRIP");

	// 			$tablet=$this->invoice_model->total_quantity_sold($search,"TABLET");
	// 			$tablet1=$this->invoice_model->total_quantity_sold($search1,"TABLET");

	// 			$pack +=$this->invoice_model->total_quantity_sold($search,"NOS");
	// 			$pack1 +=$this->invoice_model->total_quantity_sold($search1,"NOS");
				
							
	// 			$total_qty=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack,$strip,$tablet);
	// 			$total_qty1=$this->commonDBFunctions->convert_stock_format($item_id,2,'',$pack1,$strip1,$tablet1);

	// 			$stock_conv=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty);
	// 			$stock_conv1=$this->commonDBFunctions->convert_stock_format($item_id,1,$total_qty1);

	// 			$total_quantity=display_in_pack($stock_conv[0],$stock_conv[1],$stock_conv[2]);
	// 			$total_quantity1=display_in_pack($stock_conv1[0],$stock_conv1[1],$stock_conv1[2]);
				
	// 			$total_amount=$this->invoice_model->total_amount_sold($search);
	// 			$total_amount1=$this->invoice_model->total_amount_sold($search1);
				
	// 			if(empty($invoice_mode)){
				
	// 				$itemInfo[$i][0]=$distinct_items[$i][1];
	// 				$itemInfo[$i][1]=$total_quantity-$total_quantity1;
	// 				$itemInfo[$i][2]=to_currency($total_amount-$total_amount1);
	// 				$itemInfo[$i][3]=$item_id;

	// 			}else{

 //                   if($total_quantity > 0 ) {

 //                      $itemInfo[$i][0]=$distinct_items[$i][1];
	// 				  $itemInfo[$i][1]=$total_quantity;
	// 				  $itemInfo[$i][2]=to_currency($total_amount);
	// 				  $itemInfo[$i][3]=$item_id;

	// 			   }

	// 			}
	// 		}
	// 	}
            
	// 	$itemInfo=array_values($itemInfo);

	// 	$itemInfo=fast_move_medicines_sort($itemInfo);

	// 	$data['itemInfo']=$itemInfo;

	// 	$data['export']=$export;

	// 	$this->load->view("reports/fast_moving_medicine_report",$data);

	// }

		public function FastMovingMedicineReport($export=null){

		$this->load->model('invoice_model');

		// $data['user_info'] = $userInfo = $this->user->getUsers();

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");
		$invoice_mode=$this->input->post("invoice_mode");


		
		$criteria=array();

		if(!empty($from_date)){
		    $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
			
		}
		if(!empty($brand_ID)){
			$criteria[] = "item_id = ".$brand_ID;
			$data['brand_name']=$brand;
			$data['brand_ID']=$brand_ID;
		}
		
		if(empty($criteria)){
		
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			
			$data['from_date']=date("d-m-Y");
			
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "status = 0";

		if(!empty($invoice_mode)){
		
			$criteria[] = "sales_mode = '".$invoice_mode."'";
			
			$data['invoice_mode']=$invoice_mode;

		}else{
   
            $data['invoice_mode']='';
		}


	
		  $distinct_items="";
		if(!empty($criteria)){	
		 $distinct_items=$this->invoice_model->searchdistinct_item($criteria);

		}

		// var_dump($distinct_items);exit();

		$itemInfo=array();

		if(!empty($distinct_items)){

		if (empty($invoice_mode) || $invoice_mode=="Sales" ) {
			
			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "sales_mode = 'Sales'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}

			$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



		}
		else if ($invoice_mode=="Return") {

			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "sales_mode = 'Return'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}
			

			$itemInfo = $this->invoice_model->total_quantity_sold_new($search);	



		}
      }      
		$itemInfo=array_values($itemInfo);

		$itemInfo=fast_move_medicines_sort($itemInfo);

		$data['itemInfo']=$itemInfo;

		$data['export']=$export;

		$this->load->view("reports/fast_moving_medicine_report",$data);

	}


	public function fast_moving_medicines_detailed_report($item_id,$from_date,$to_date,$invoice_mode=null){

		$this->load->model('invoice_model');
	
		$criteria[] = "item_id = ".$item_id;
		$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
		$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
		$criteria[] = "status = 0";

		if(!empty($invoice_mode)) $criteria[] ="sales_mode='".$invoice_mode."'";
		
		$data['itemInfo']=$this->invoice_model->searchBillItems($criteria);	
		$data['from_date']=$from_date;
		$data['to_date']=$to_date;
		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		
		
		$this->load->view('reports/fast_moving_medicines_detailed_report',$data);
	
	}
	
	function daily_stock_report(){
        
              $this->load->model('brand_model');
		
	      $from_date=$this->input->post("from_date");
	      $end_date=$this->input->post("end_date");

               if(!empty($from_date)){
			$criteria[] = "date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "date >= '".date("Y-m-d")."'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "date <= '".date("Y-m-d")."'";
			$data['end_date']=date("d-m-Y");
		}

                $data['stockInfo']=$this->brand_model->searchDailyStock($criteria);

                $this->load->view('reports/daily_stock_report',$data);
         }
	



function itemwise_sales_profit_report($export = null){

     	$this->load->model('invoice_model');
   //   	$this->load->model('batch_model');
		 // $this->load->model('purchase_model');

		  
        $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");

		$current_page=$this->input->post('current_page');

		$prev_net=$this->input->post('prev_net');

		$prev_sellp=$this->input->post('prev_sellp');


		$prev_buyp=$this->input->post('prev_buyp');


		$prev_gst=$this->input->post('prev_gst');

		$prev_qty=$this->input->post('prev_qty');

		$prev_qty_return=$this->input->post('prev_qty_return');
		//tot_qty_return
		$prev_gross_sales=$this->input->post('prev_gross_sales');
		//tot_gross_sales
		$count_items=0;
	      

				if(!empty($from_date)){
					$criteria[0] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
					$data['from_date']=$from_date;
					$from_date1= "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
					
					
				}else{
					$criteria[0] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
					$data['from_date']=date("d-m-Y");
					$from_date1= "bill_date >= '".date("Y-m-d")." 00:00:00'";
					
				}
				
				if(!empty($end_date)){
					$criteria[1] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
					$data['end_date']=$end_date;
					$to_date1= "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
					
				}else{
				
					$criteria[1]  ="bill_date <= '".date("Y-m-d")." 23:59:59'";
					$to_date1= "bill_date <= '".date("Y-m-d")." 23:59:59'";
					$data['end_date']=date("d-m-Y");
				}
		  
				if(!empty($brand_ID)){
					$criteria[3]= "item_id = ".$brand_ID;
					$data['brand_name']=$brand;
					$data['brand_ID']=$brand_ID;
					$item_id1= "item_id = ".$brand_ID;

				}

				if(empty($criteria)){

					$criteria[0] = "bill_date >= '".date("Y-m-d")."'";

					$from_date1= "bill_date >= '".date("Y-m-d")."'";

					$criteria[1] = "bill_date <= '".date("Y-m-d")."'";
					$to_date1= "bill_date <= '".date("Y-m-d")."'";
			
				}
				 $criteria[2] = "status = 0";
				// $criteria[3] = "sales_mode= 'Sales'";

		// var_dump($criteria);

    $this->load->helper('pagination');

				$perPage=5; 
		        if(empty($current_page)){
		            $current_page =1;	
		        }else{ 
		            $current_page = $current_page; 
		        }  




				$limit=pageLimit($current_page,$perPage);
		        
		        $next_page=explode(",",$limit);
		        $data['next_page']=$next_page[0];
		       
		        if(!empty($export)){

		        	 $limit='';
		        }
    

// $total_quantity=array();
// $total_quantity_r=0;
// $sellp=0;
// $tot_gst=0;
// $tot_buy_p=0;
// $profit =0;


						
	  $qty=0;
        $sell_p=0;
        $gs_t=0;
        $buy_p=0;
        $net_profit=0;  

 $total_qty=array();
 $total_qty_s=array();
   $selp     =array();
   $t_gst    =array();
   $t_buy_p  =array();
   $prfit    =array();					// $buy_p[]=array();

  
          $count_items=$this->invoice_model->searchBillItemsDistinctCount($criteria);


       
         // $distinct_sales=$this->invoice_model->searchdistinct_item($criteria,$limit);
        $distinct_sales=$this->invoice_model->searchdistinct_item($criteria);
 
   if(!empty($distinct_sales))	{

   	for ($i=0; $i <count($distinct_sales) ; $i++) { 

	$total_quantity = 0;
	$sellp=0;
	$tot_gst=0;
	$tot_buy_p=0;
	$profit =0;

            $criteria1[0]=$criteria[0];
            $criteria1[1]=$criteria[1];
            $criteria1[2]=$criteria[2];
            $criteria1[3] = "item_id = ".$distinct_sales[$i][0];
          
           $distinct_sales_items[$i]=$this->invoice_model->searchBillItems($criteria1,''); 
        
										   	    

        for ($j=0; $j <count($distinct_sales_items[$i]) ; $j++) 
           {
           	

               if($distinct_sales_items[$i][$j][5]=='Sales')       
                {
                 

                    $total_quantity   +=$distinct_sales_items[$i][$j][9];//total qty sold
             
                    $sellp           +=($distinct_sales_items[$i][$j][20]*$distinct_sales_items[$i][$j][9]);//total sellp of sold items
                    $tot_gst         +=($distinct_sales_items[$i][$j][17]*$distinct_sales_items[$i][$j][9]);//total gst of sold items
                  
                    $tot_buy_p       +=($distinct_sales_items[$i][$j][35]*$distinct_sales_items[$i][$j][9]);//total buyp of sold items
                    
                    $profit          +=($distinct_sales_items[$i][$j][20]*$distinct_sales_items[$i][$j][9])-(($distinct_sales_items[$i][$j][35]*$distinct_sales_items[$i][$j][9])+($distinct_sales_items[$i][$j][17]*$distinct_sales_items[$i][$j][9]));
                                              // total profit of sold items


                                                   
 //.....................................net qty = total qty sales-total qty return
//......................................... profit =net qty*sellp - net qty*buyp + net qty*gst
                }
                else
                { 
                       
                  
                     $total_quantity  -=$distinct_sales_items[$i][$j][9];//total qty of sales return items
                  
                     $sellp           -=($distinct_sales_items[$i][$j][20]*$distinct_sales_items[$i][$j][9]);//total sellp of sales return items
                     $tot_gst        -=($distinct_sales_items[$i][$j][17]*$distinct_sales_items[$i][$j][9]);//total gst of sales return items
                  
                     $tot_buy_p       -=($distinct_sales_items[$i][$j][35]*$distinct_sales_items[$i][$j][9]);//total buyp of sales return items
                    
                     $profit          -=($distinct_sales_items[$i][$j][20]*$distinct_sales_items[$i][$j][9])-(($distinct_sales_items[$i][$j][35]*$distinct_sales_items[$i][$j][9])+($distinct_sales_items[$i][$j][17]*$distinct_sales_items[$i][$j][9]));
                                                          //total profit return
                                                     

                  
                }
//echo 
      
            }
                 $total_qty[$i] = $total_quantity;
                 $selp[$i]=$sellp;
                 $t_gst[$i]= round($tot_gst, 2); 
                 $t_buy_p[$i]  = $tot_buy_p;
                 $prfit[$i]= round($profit, 2);

                 $qty        += $total_qty[$i];
                 $sell_p     +=$selp[$i];
                 $gs_t       +=$t_gst[$i];
                 $buy_p      +=$t_buy_p[$i];
                 $net_profit +=$prfit[$i];

}

// $qty +=array_sum($total_qty);




        $data['sales']=$distinct_sales;
       
        $data['total_quantity']=$total_qty;
        $data['sellp']=$selp;
        $data['tot_gst']=$t_gst;
        $data['tot_buy_p']=$t_buy_p;
        $data['profit']=$prfit;


       
 $data['total_qty'] =$qty;
 
$data['selp']      =$sell_p;

$data['t_gst']    =$gs_t;
   
$data['t_buy_p']   =$buy_p;
 
$data['prfit']    =$net_profit;
       
//..........................sum of each page total .....................................
       
                          
 
				        if ($current_page!=1) {
				        	
				        	$prev_net +=$net_profit ;
				        	$data['prev_net']= $prev_net;

				     
				        }
				        else{
				        	$data['prev_net']= $net_profit;
				        }



				if ($current_page!=1) {
				        	
				        	$prev_sellp += $sell_p;

				        	$data['prev_sellp']= $prev_sellp;

				       
				        }
				        else{
				        	$data['prev_sellp']= $sell_p;
				        }




				if ($current_page!=1) {
				        	
				        	$prev_buyp += $buy_p;

				        	$data['prev_buyp']= $prev_buyp;

				        }
				        else{
				        	$data['prev_buyp']= $buy_p;
				        }


				        

				if ($current_page!=1) {
				        	
				        	$prev_gst += $gs_t;

				        	$data['prev_gst']= $prev_gst;

				     

				        }
				        else{
				        	$data['prev_gst']= $gs_t;
				        }




				

				 if ($current_page!=1) {
				        	
				        	$prev_gross_sales += $qty;

				        	$data['prev_gross_sales']= $prev_gross_sales;

				        	
				        }
				       else{
				        	$data['prev_gross_sales']= $qty;
				        }

 //.........................sum of each page total .....................................

}

     
       if(empty($export)){
     
           // $data['pagination_link']=printPageLinks($count_items,$current_page,$perPage);
        }

       
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$data['export']=$export;
// var_dump($data);

		$this->load->view('reports/itemwise_sales_profit_report',$data);




		}

function gstwisePurchaseReport($export = null){

    	$this->load->model('purchase_model');
		$this->load->model('supplier');
        $this->load->model('gst_model');

         $search_gst[0]="status = 0";

		$data['gstInfo'] =$gstInfo=$this->gst_model->getGstInfo($search_gst); 

		$data['user_info'] = $userInfo = $this->user->getUsers();
		$data['suppliers']=$this->supplier->getSupplier();

		$user_type_search[] = "id = 8 or id= 9";
		$data['userTypeInfo'] = $userTypeInfo = $this->user->getUsertype($user_type_search);
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");
		$bill_no=$this->input->post("bill_no");
		$pono=$this->input->post("pono");
		$payment_type=$this->input->post("payment_type");
		$user_id=$this->input->post("user_id");
		$user_type=$this->input->post("user_type");

		$data['gst'] = $gst=$this->input->post("gst");

		$current_page=$this->input->post('current_page');
		
		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$criteria[] = "supplier = ".$supplier;
			$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
			$data['supplier']=$supplier;
		}
		if(!empty($bill_no)){
			$criteria[] = "bill_no = ".$bill_no;
			$data['bill_no']=$bill_no;
			
		}
		if(!empty($pono)){
			$criteria[] = "pono = '".$pono."'";
			$data['pono']=$pono;
		}
		
		if(!empty($payment_type)){
			$criteria[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_selected']=$payment_type;
		}
		if(!empty($user_type)){
			$data['user_type_name']= $this->commonDBFunctions->getidToValue('user_type','id',$user_type,'hcare_user_type');
			$data['user_type']=$user_type;
			$search[] = "user_type =".$user_type;
			$data['user_info'] = $userInfo = $this->user->getUsers($search);
			for($i=0;$i<count($userInfo);$i++){

				$user_id_new[] =$userInfo[$i][0];

			}
			$matches = implode(',', $user_id_new);
			if(!empty($matches)) $criteria[] ="user_id "." "."in ( $matches )";
		}
		if(!empty($user_id)){
			$data['user_name']= $this->commonDBFunctions->getidToValue('user_name','id',$user_id,'users');
			$data['user_id']=$user_id;
			$criteria[] = "user_id = ".$user_id;
		}

		if(empty($criteria)){

			$criteria[] = "bill_date >= '".date("Y-m-d")."'";

			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
	
		}

		$criteria[] = "gst > 0";
		
		$criteria[] = "status = 0";

		/*... pagination start ...*/
        
		$this->load->helper('pagination');
        $perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        /*... pagination End ...*/



       $data['billInfo']=$purchaseInfo=$this->purchase_model->searchPurchase($criteria,'','',$limit);

       if (!empty($purchaseInfo)) {

         for ($i=0; $i <count($purchaseInfo) ; $i++) { 

			$criteriaz[0] = "bill_id = ".$purchaseInfo[$i][1];
			$criteriaz[1] = "status = 0";

			for ($j=0; $j <count($gstInfo) ; $j++) { 

				if(!empty($gst)){
				
					$criteriaz[2] = "gst_per = '".$gst."'";

					$data['gst']=$gst;
				}
				else{

					$criteriaz[2] = "gst_per = '".$gstInfo[$j][1]."'";
					
				}

				 $purchaseItemInfo[$i][$j]=$this->purchase_model->searchdistinct_gst_purchase($criteriaz);

			}


          
         }


       }

			 if (!empty($purchaseItemInfo)) {
			 
			 	$data['billInfogst']=$purchaseItemInfo;

			}

       
 
/*... pagination start ...*/
        
         $count_purchase=$this->purchase_model->getPurchaseCount($criteria);

     
		$data['export']=$export;

		 if(empty($export)){
           $data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('reports/gst_wise_purchase_report',$data);

    }


	public function supplier_wise_stock_report($export= null){

        $this->load->model('Batch_model');
		$this->load->model('branch');
	    $this->load->model('supplier');

		$branch_id=$this->session->userdata('branch_id');

	    $data['branchInfo']=$this->branch->getBranch();	

		$data['suppliers']=$this->supplier->getSupplier();	

		$expiry_date=$this->input->post("expiry_date");
		$brand_ID=$this->input->post("brand_ID");
		$brand=$this->input->post("brand");
		$batch=$this->input->post("batch");
		$supplier=$this->input->post("supplier");
		$branch=$this->input->post("branch");

		$current_page=$this->input->post('current_page');		
		
		$criteria=array();

		if(!empty($expiry_date)){
		    $criteria[] = "expiry_date <= '".date("Y-m-d",strtotime($expiry_date))."'";
			$data['expiry_date']=$expiry_date;
		}

		if(!empty($batch)){
		    $criteria[] = "batch_number like '%".$batch."%'";
			$data['batch']=$batch;
		}

		if(!empty($supplier)){
			$data['supplier_name']=$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'pharma_suppliers');
		    $criteria[] = "supplier_id = '".$supplier."'";
			$data['supplier']=$supplier;
		}

		if(!empty($branch)){
		   

		    if($branch=='MAIN STOCK'){
             $criteria[] = "branch_id  = 0";
		     $data['branch']="MAIN STOCK";	

		    }else{
		    	$data['branch_name']=$branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$supplier,'pharma_branch');
             $criteria[] = "branch_id  = '".$branch."'";
		     $data['branch']=$branch;	

		    }
			
		}

		if(!empty($brand_ID)){
			$data['brand_name']=$branch_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_ID,'pharma_brand');
		    $criteria[] = "brand_id = '".$brand_ID."'";
			$data['brand_ID']=$brand_ID;
		}

		if(!empty($brand)){
			$data['brand']=$brand;
		}
		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit=''; 
        }        

		$data['batchInfo'] = $this->Batch_model->getBatch($criteria,$limit);
        $count_batch = $this->Batch_model->countBatch($criteria);

		if(empty($export)){
        	$data['pagination_link']=printPageLinks($count_batch,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		$data['export']=$export;

/*... pagination end ...*/

		$this->load->view('reports/supplier_wise_stock_report',$data);
	}

public function itemwise_detailed_report_invoice($item_id,$return_billid,$invoice_mode=null){

		$this->load->model('invoice_model');
	
		$criteria[] = "item_id = ".$item_id;
	    $criteria[] = "return_billid = ".$return_billid;
		// $criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
		// $criteria[] = "bill_date <= '".date("Y-m-d",strtotime($to_date))."'";
		$criteria[] = "status = 0";

		 if(!empty($invoice_mode)) $criteria[] ="sales_mode='".$invoice_mode."'";
		
		$data['itemInfo']=$itemInfo=$this->invoice_model->searchBillItems($criteria);	
// var_dump($itemInfo);
		// $data['from_date']=$from_date;
		// $data['to_date']=$to_date;
		 $data['bill_id']=$return_billid;

		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		
		
		$this->load->view('reports/itemwise_detailed_report',$data);
	
	}
	function hsnWiseSalesReport($export=null){

        $this->load->model('invoice_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

        $criteria[] = "sales_mode = 'Sales'";
		$criteria[] = "status = 0";
		// $criteria[] = "cust_type = 'OP'";

        $hsn_base_bill_details=array();

         $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria);


       
          $hsn_base_bill_details=$this->invoice_model->searchdistinct_hsn_no_base_details($criteria);

          // var_dump($hsn_base_bill_details);
       
           $hsn_base_bill_details_2=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details($criteria);

         
		 $datas=array_merge((array)$hsn_base_bill_details,(array)$hsn_base_bill_details_2);

		  $data['itemInfo']=$datas;
		  // $data['itemInfo_2']=$hsn_base_bill_details_2;
		
		$data['export']=$export;

		$this->load->view('reports/hsn_wise_sales_report',$data);


	}
      function hsnWiseSalesReturnReport($export=null){

       $this->load->model('invoice_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

        $criteria[] = "sales_mode != 'Sales'";
		$criteria[] = "status = 0";
		// $criteria[] = "cust_type = 'OP'";


            $hsn_base_bill_details=$this->invoice_model->searchdistinct_hsn_no_base_details($criteria);
        
     
            $hsn_base_bill_details_1=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details($criteria);
// var_dump($hsn_base_bill_details);
// var_dump($hsn_base_bill_details_1);
		$data['itemInfo']=array_merge((array)$hsn_base_bill_details,(array)$hsn_base_bill_details_1);


		
		$data['export']=$export;
		
		$this->load->view('reports/hsn_wise_sales_return_report',$data);

    }
    function hsnWiseSummaryReport($export=null){

        $this->load->model('invoice_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
 
		if(!empty($from_date)){
			$criteria[] =$criteria1[]= "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] =$criteria1[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] =$criteria1[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] =$criteria1[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] =$criteria1[] = "status = 0";
		
 

        // $hsn_base_bill_details=array();
           $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria);
          

           if(!empty($hsn_no)){
           	 // $criteria[] = "cust_type = 'OP'";
            // $criteria[] = "sales_mode = 'Sales'";
            for($i=0; $i<count($hsn_no); $i++){
                 
                   
                 $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_hsn_no_base_details_summary($criteria,$hsn_no[$i]);

            }

          }
       
             $brand_id=$this->invoice_model->searchdistinct_brand_no_hsn_no($criteria1);


          if(!empty($brand_id)){

          	 // $criteria[] = "cust_type = 'OP'";
            // $criteria[] = "sales_mode = 'Return'";
            for($i=0; $i<count($brand_id); $i++){
                  
                 $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details_summary($criteria,$brand_id[$i]);
            }

          }

       
            
         $data['itemInfo']=array_values($hsn_base_bill_details);
		  // $data['itemInfo']=$hsn_base_bill_details;


		$data['export']=$export;

        $this->load->view('reports/hsn_wise_summary_report',$data);
    }
	public function purchase_itemwise_report($export=null){

		$this->load->model('purchase_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");
		$purchase_mode=$this->input->post("purchase_mode");

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")."'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")."'";
			$data['end_date']=date("d-m-Y");
		}
		if(!empty($brand_ID)){
		
			$data['brand_name']=$brand;
			// $data['brand_ID']=$brand_ID;
			$criteria[] = "item_id = ".$brand_ID;
		}

        $criteria[] = "status = 0";

		if(!empty($purchase_mode)){

			$data['purchase_mode']=$purchase_mode;
			
			$criteria[] = "purchase_mode = '".$purchase_mode."'";

		}else{
			$data['purchase_mode']="Recievings";
		}

		$distinct_items=$this->purchase_model->searchdistinct_item($criteria);	
	
		$itemInfo=array();

		if ( empty($purchase_mode) || $purchase_mode=="Recievings" ) {
			
			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "purchase_mode = 'Recievings'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}

			$itemInfo = $this->purchase_model->total_quantity_sold_new($search);	


		}
		else{

			$search[0]=$criteria[0];

			$search[1]=$criteria[1];

			$search[2] = "status = 0";

			$search[3] = "purchase_mode = 'Return'";

			if (!empty($brand_ID)) {
				$search[4] = "item_id = '".$brand_ID."'";
			}

			$itemInfo = $this->purchase_model->total_quantity_sold_new($search);	


		}



		$data['itemInfo']=array_values($itemInfo);	

		$data['export']=$export;

		$this->load->view('reports/purchase_itemwise_report',$data);

	}
	function dailyBrandWiseStockReport($export= null){
         	date_default_timezone_set('Asia/Kolkata');
         	$this->load->model('brand_model');
         	$this->load->model('item_history_model');
			$from_date=$this->input->post("from_date");
			$brand_name=$this->input->post("brand");
			$brand_ID=$this->input->post("brand_ID");
			 // echo $brand_ID;exit();
			if(!empty($brand_ID)){
				$data['brand_ID']=$brand_ID;
			}


			if(!empty($from_date)){
				$date=date("Y-m-d",strtotime($from_date));
				$data['from_date']=$from_date;
			}else{

				$date=date("Y-m-d");
				$data['from_date']=date("d-m-Y");
			}
			$search=array();
       		$limit="";
			$k=0;
			$message='';
			$current_page=$this->input->post('current_page');
			/*... pagination start ...*/
        
			$this->load->helper('pagination');

			$perPage=50; 
	        if(empty($current_page)){
	            $current_page =1;	
	        }else{ 
	            $current_page = $current_page; 
	        }  

			$limit=pageLimit($current_page,$perPage);
	        
	        $next_page=explode(",",$limit);
	        $data['next_page']=$next_page[0];
	        
	        if(!empty($export)){

	        	 $limit='';
	        }

	        if(!empty($brand_ID)){
	        	$search[0]="brand like '%".$brand_ID."%'";
	        	$search[1] = "( (status = 0) or (status = 1 and cancellation_date > '".$date."') )";

	        	$countbrand=$this->brand_model->countBrandAll($search);
	        	// echo $countbrand;exit;
	        	$data['brand']=$brand=$this->brand_model->getBrandAll($search,$limit,'',$date);

	     

	        }else{

	        	$search = array();
	        	

	        	$search[0] = "( (status = 0) or (status = 1 and cancellation_date > '".$date."') )";
	        	$countbrand=$this->brand_model->countBrandAll($search);
	        	$data['brand']=$brand=$this->brand_model->getBrandAll($search,$limit,'',$date);
	        	// var_dump($data['brand']);exit;
	        }


	        $data['export']=$export;

	        if(empty($export)){
	           $data['pagination_link']=printPageLinks($countbrand,$current_page,$perPage);
	        }
	        
	        $data['current_page']=$current_page;

	/*... pagination end ...*/

	 
				$this->load->view('reports/daily_brand_wise_stock_report',$data);

	         }
	function hsnWiseSummaryReportPercentageWiseNew($export=null){

        $this->load->model('invoice_model');
		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");

		if(!empty($from_date)){
			$criteria[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

		$criteria[] = "status = 0";

        $hsn_base_bill_details=array();

		
           
        // hsn base details   
            $hsn_no=$this->invoice_model->searchdistinct_hsn_no($criteria);
             $gstInfo=$this->invoice_model->searchdistinct_gst_percentage($criteria);
             // var_dump($gstInfo);exit();
           

          if(!empty($hsn_no)){
            
            for($i=0; $i<count($hsn_no); $i++){

            	
            	// // var_dump($gstInfo);exit();
            	 if(!empty($gstInfo)){

                  for ($j=0; $j <count($gstInfo) ; $j++) { 

				
              	 $gst_per = $gstInfo[$j];
              	$hsn_no_search="hcare_pharma_invoice_items.hsn_no ="."'".$hsn_no[$i]."'";
              	
              	
              	// $gst_per='';

                 $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_hsn_no_base_details_hsnWiseSummaryPercentageWise($criteria,$hsn_no_search,$gst_per,$hsn_no[$i]);
             }
         }
            }
            


          }

        // brand with no hsn_no details 
            $brand_id=$this->invoice_model->searchdistinct_brand_no_hsn_no($criteria);
            // $hsns_brands[]=$brand_id;

          if(!empty($brand_id)){
            
            for($i=0; $i<count($brand_id); $i++){
            	
            	

            	if(!empty($gstInfo)){

                 for ($j=0; $j <count($gstInfo) ; $j++) { 

				
              	$gst_per = $gstInfo[$j];
            	// $gst_per='';

                 $hsn_base_bill_details[]=$this->invoice_model->searchdistinct_brand_no_hsn_no_base_details_hsnWiseSummaryPercentageWise($criteria,$brand_id[$i],$gst_per);
              }
             }

            }
             // var_dump($hsn_base_bill_details);

          }


		  $data['itemInfo']=array_values($hsn_base_bill_details);
		  // $data['hsns_brands']=array_values($hsns_brands);

		$data['export']=$export;

        $this->load->view('reports/hsn_wise_summary_report_percentage_wise_new',$data);
    }

 public function doctor_medicine_report($export=null){

		$this->load->model('hcare_model');
		$this->load->model('brand_model');

		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$brand=$this->input->post("brand");
		$brand_ID=$this->input->post("brand_ID");
		$doctor=$this->input->post("doctor");

		$current_page=$this->input->post('current_page');

		if(!empty($from_date)){
			$criteria[] = "a.bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$data['from_date']=$from_date;
			
			
		}else{
			$criteria[] = "a.bill_date >= '".date("Y-m-d")." 00:00:00'";
			$data['from_date']=date("d-m-Y");
			
		}
		
		if(!empty($end_date)){
			$criteria[] = "a.bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$data['end_date']=$end_date;
			
		}else{
		
			$criteria[] = "a.bill_date <= '".date("Y-m-d")." 23:59:59'";
			$data['end_date']=date("d-m-Y");
		}

		if(!empty($brand_ID)){
			$criteria[] = "b.item_id = ".$brand_ID;
			$data['brand_name']=$brand;
			$data['brand_ID']=$brand_ID;
		}

		if(!empty($doctor)){
			$data['doctor_name']= $this->commonDBFunctions->getidToValue('title','id',$doctor,'emp_info')." ".$this->commonDBFunctions->getidToValue('first_name','id',$doctor,'emp_info').$this->commonDBFunctions->getidToValue('last_name','id',$doctor,'emp_info');

			$data['doctor']=$doctor;
			
			$criteria1[] = "id = '".$doctor."'";
			$criteria[] = "a.doc_id = '".$doctor."'";
		}

		/*... pagination start ...*/
        
		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        
        if(!empty($export)){

        	 $limit='';
        }

        $count_medicines=$this->brand_model->countMedicineDoctorWise($criteria);
        // var_dump($count_medicines);

        $data['medicine_list']=$medicine_list=$this->brand_model->getMedicineDoctorWise($criteria,$limit);

		// $data['billInfo']=$this->invoice_model->searchBill($criteria,'',$limit);

		$data['export']=$export;

		if(empty($export)){
           $data['pagination_link']=printPageLinks($count_medicines,$current_page,$perPage);
        }
        
        $data['current_page']=$current_page;

/*... pagination end ...*/	

		

		$data['doctors']=$doctors=$this->hcare_model->getDoctors($criteria1);
		
		// var_dump($doctors);




		$data['export']=$export;
		$this->load->view("reports/doctor_medicine_report",$data);
	
	}   
	public function itemwise_previous_purchase_history_report_purchase($item_id){


	// ($item_id,$return_billid,$invoice_mode=null){

		$this->load->model('purchase_order_model');
	
		$criteria[] = "item_id = ".$item_id;
		
	 $data['itemInfo']=$itemInfo=$this->purchase_order_model->searchItemHistory($criteria);	


		$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$item_id,'pharma_brand');
		// echo $data['brand_name'];exit;
		
		
		// $this->load->view('reports/itemwise_previous_purchase_history_report',$data);
		$this->load->view('reports/itemwise_previous_purchase_history_report',$data);
	
	}
	     





	
}


