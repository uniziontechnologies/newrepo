<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {
  
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }


	function invoice_form()
	{
		//process data
		$data=$this->processInvoiceForm();
		 
		
		$data['paction']=isset($data['paction'])?$data['paction']:'Save';
		//$data['recid']=isset($data['recid'])?$data['recid']:'';
		$data['itemfocus']=$this->input->post('item_focus');

		//branch info
		$this->load->model('branch');
		$data['branchInfo']=$this->branch->getBranch();


		$this->load->model('hcare_model');

		$data['op_id']=$op_id=$this->input->post('op_id');

		$selectCondition[]="b.`id` ='".$op_id."'";
		$selectCondition[]="b.`visit_date` like '".date('Y-m-d')."%'";

		$patientInfo=$this->hcare_model->getOPPatientInfo($selectCondition);

		$data['payment_status'] = $payment_status = $patientInfo[0][47];
		$data['op_reg_amount']  = $op_reg_amount  = $patientInfo[0][17]+$patientInfo[0][18]+$patientInfo[0][46];



		$data['error_message']='';//$error_message;
		
		//invoice form view
		$this->load->view('invoice/invoice_form',$data);
	}

	function invoice_return_form()
	{
		//process data
		$data=$this->processInvoiceForm();
		
		$data['sales_mode_selected']='Return'; 
		
		$data['paction']=isset($data['paction'])?$data['paction']:'Save';
		//$data['recid']=isset($data['recid'])?$data['recid']:'';
		$data['itemfocus']=$this->input->post('item_focus');

		//branch info
		$this->load->model('branch');
		$data['branchInfo']=$this->branch->getBranch();
	
		$data['error_message']='';//$error_message;

		//invoice return form view
		$this->load->view('invoice/invoice_return_form',$data);
	}
	
	function processInvoiceForm(){
		
			//process form
		$this->load->model('invoice_model');
		$itemcount=$this->input->post('item_count');
		$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
		if($itemcount==null) $this->session->unset_userdata('batchidInfo');
		$item_loc=$this->input->post('item_loc');
		$select_batch=$this->input->post('select_batch_position');

		if (isset($select_batch)) {
			$data['select_batch_position_pres']=$select_batch;
		}
		else{
			$data['select_batch_position_pres']=$this->input->post('select_batch_position_pres');
		}


        $data['paction']=$paction=$this->input->post('paction');
		$data['billid']=$bill_id=$this->input->post('billid');
		$data['customer_type_select']=$customer_type_select=$this->input->post('customer_type');
		$data['draft']=$draft=$this->input->post('draft');
		$data['edit_status']=$edit_status=$this->input->post('edit_status');
		$data['invoice_id']=$invoice_id=$this->input->post('invoice_id');
	    $data['op_no']=$this->input->post('op_no');
	    $data['op_id']=$op_id=$this->input->post('op_id');

	    $data['payment_status'] = $payment_status = $this->input->post('payment_status');
	    $data['op_reg_amount']  = $op_reg_amount  = $this->input->post('op_reg_amount');
	    $data['op_payment']     = $op_payment  = $this->input->post('op_payment');

	       // var_dump($op_id);
	    $data['ip_no']=$ip_no=$this->input->post('ip_no');

	      $data['op_num']=$this->commonDBFunctions->getidToValue('opno','id',$ip_no,'ip_info');

		$data['customer_name']=$this->input->post('cust_name');
		$data['doctor']=$this->input->post('doctor');
		$data['doc_id']=$this->input->post('doc_id');

		$data['payment_type_selected']=$this->input->post('payment_type');
		$data['checque_no']=$this->input->post('checque_no');
		$data['checque_amt']=$this->input->post('checque_amt');
		$data['card_amt']=$this->input->post('card_amt');
		$data['amt_paid']=$this->input->post('amount_paid');
		$data['branch_select']=$this->input->post('branch');
		$sales_mode_selected=$this->input->post('sales_mode_selected');
		$data['upi_amt']=$this->input->post('upi_amt');

		$data['return_billid']=$return_billid=$this->input->post('return_bill');

		$data['ip_medicines_id']=$this->input->post('ip_medicines_id');

		$data['doct_presc']=$this->input->post('doct_presc');

		$data['op_medicines_id']=$this->input->post('op_medicines_id');

	    $data['billwise_return']=$billwise_return=$this->input->post('billwise_return');

		
		$data['invoice_Credit_Info']=$invoice_Credit_Info=$this->input->post('invoice_Credit_Info');

		$data['invoice_bill_date']=$this->input->post('invoice_bill_date');
  
		if(empty($sales_mode_selected)){

			$data['sales_mode_selected']='Sales';

		}else{

            $data['sales_mode_selected']=$sales_mode_selected;

		}

		$items_in_array=array();

		$sales_amt=0;
		$return_amt=0;
		$total_gst=0;
		$total_cgst=0;
		$total_sgst=0;
		$round_amt=0;
		$roundstatus=0;
		$total_flood_cess=0;
        $free_bill=0;

		if($itemcount > 0 ){
		                       
			for($i=0;$i<$itemcount;$i++){
		
		
			  if($item_loc!="" && $item_loc == $i){
			  	
				 //Request to remove the item
			    //So  Exclude the item 
			    //remove item from batchidinfo session
                  $batchidInfo = $this->session->userdata('batchidInfo');
			      unset($batchidInfo[$item_loc]);
                  $this->session->set_userdata('batchidInfo', $batchidInfo);

			  }else{
			  	    
				  $item=$this->input->post('item');
                 
				  $qty=$item[$i][6];			
				  $sellp=$item[$i][7];
				  $batch_stock=$item[$i][10];
				  $batch_id=$item[$i][18];


				  $saled_qty=$item[$i][26];
				  $return_qty=$item[$i][27];
				  $avilable_qty=$item[$i][28];
				 

				  $total=$qty*$sellp;



                            $new_criteria[0] = "item_id = ".$item[$i][0];
							$new_criteria[1] = "batch_id = ".$item[$i][18];
							$new_criteria[2] = "bill_id = ".$bill_id;
							$new_criteria[3] = "status = 0";

				$qty_before_updation=$this->commonDBFunctions->getidToValue_multiple('quantity',$new_criteria,'pharma_invoice_items');

				  if($paction=='Update' && empty($draft) )
				  {
				     $batch_stock1=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				     $batch_stock1+=$qty_before_updation;
				  }
				  else
				  {
				  	$batch_stock1=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				  }

				  if(($qty > $batch_stock1) && $sales_mode_selected=='Sales'){ 
				  	      $data['batch_error'][$i]="Insufficient Stock";
                  } 

                  elseif(!empty($avilable_qty) && ($qty > $avilable_qty) && $sales_mode_selected=='Return' ){

                  	    $data['batch_error'][$i]="Check Saled Qty";

                   }elseif(!empty($saled_qty) && ($avilable_qty=='0') && $sales_mode_selected=='Return'){

                  	    $data['batch_error'][$i]="No Qty to Return";





                  }else{
                  	      $batch_error[]='';
                  }
      
				  // $item=$this->input->post('item');

				  // $qty=$item[$i][6];			
				  // $sellp=$item[$i][7];
				 
				  //   $batch_id=$this->input->post('batch_ID');
				  //   $batch_id=$item[$i][18];
				  // $batch_stock1=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				  //  $item[$i][10]= $batch_stock1;



				  // if(($qty > $batch_stock1) && $sales_mode_selected=='Sales'){ 
				  // 	      $data['batch_error'][$i]="Insufficient Stock";
      //             }else{
      //             	      $batch_error[]='';
      //             }

				  $total=$qty*$sellp;

                  $sellp=to_currency($sellp);				
				  $total=to_currency($total);

if($sales_mode_selected=='Sales')
    {
                  if($total >0 ) {
					$sales_amt=$sales_amt+$total;
				  }
	}

if($sales_mode_selected=='Return')
    {
				  if($total >0 ) {
					$return_amt=$return_amt+$total;
				  }	
    }

/*... Select batch ...*/
                  if($select_batch!="" && $select_batch==$i){

                  	   $batch_id=$this->input->post('batch_ID');
                  	   $item[$i][18]=$batch_id;

                  	   	//batch details
				
				$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
                $item[$i][3]=$batch_name;

				$expiry_date=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');

                $item[$i][4]=$expiry_date;
        
				$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				$item[$i][10]=$batch_stock;


				$selling_unit=$this->commonDBFunctions->getidToValue('price_type','id',$batch_id,'pharma_batch');
				$item[$i][5]=$selling_unit;

				$mrp=$this->commonDBFunctions->getidToValue('sellp','id',$batch_id,'pharma_batch');
				$item[$i][7]=$mrp;

/*....... gst details .......*/	
                $gst_per=$this->commonDBFunctions->getidToValue('gst_per','id',$batch_id,'pharma_batch');
                $item[$i][12]=$gst_per;

                $sgst_per=$this->commonDBFunctions->getidToValue('sgst_per','id',$batch_id,'pharma_batch');
                $item[$i][13]=$sgst_per;

                $cgst_per=$this->commonDBFunctions->getidToValue('cgst_per','id',$batch_id,'pharma_batch');
                $item[$i][14]=$cgst_per;

                $gst_id=$this->commonDBFunctions->getidToValue('gst_id','id',$batch_id,'pharma_batch');
                $item[$i][11]=$gst_id;

/*....... gst details .......*/

/*.... gst calculations ....*/
                if(!empty($gst_id) && !empty($gst_per)) 
                   {
                   	  $taxable_mrp=($mrp * 100)/(100+$gst_per);
                      $gst_amt=($mrp-$taxable_mrp);
                      $cgst_amt = $sgst_amt = ($gst_amt/2);
                      
                     

                      $sellprice=$mrp-$gst_amt;
                      $sellprice=to_currency($sellprice);
                      $item[$i][8]=$sellprice;
                   
                    /* ........FLOOD CESS CALCULATIONS....(1% TAXABLE VALUE  INCREASE FOR 2 YRS -01/08/2019   TO 2021).....*/
                      
                     if($gst_per !='5' && (date("Y-m-d") < "2021-08-01") ){
                      
                        $taxable_mrp    = ($mrp * 100)/(101+$gst_per); 
                        $total_cess     =($mrp-$taxable_mrp);//= $gst_amt+$cess                       
                      	$flood_cess_amt = $taxable_mrp/100;
                      	$gst_amt        = $flood_cess_amt*$gst_per; 
                      	$cgst_amt = $sgst_amt = ($gst_amt/2);                    	
                        $item[$i][24]   =$flood_cess_amt;

                        $sellprice=$mrp-$total_cess;
                        $sellprice=to_currency($sellprice);
                        $item[$i][8]=$sellprice;
                      }
                      else{
                        $flood_cess_amt=0;
                      	$item[$i][24]=0;
                      	
                      }       
                      
         /* ........... FLOOD CESS CALCULATIONS..........*/
                 

                      $item[$i][16]=$sgst_amt;
                      $item[$i][17]=$cgst_amt;

                      $item[$i][15]=$gst_amt;




                    } 
                else{
             	      $item[$i][11]=$gst_id='';
             	      $item[$i][12]=$gst_per='';
             	      $item[$i][13]=$sgst_per='';
             	      $item[$i][14]=$cgst_per='';
             	      $item[$i][15]=$gst_amt='';
             	      $item[$i][16]=$sgst_amt='';
             	      $item[$i][17]=$cgst_amt='';
                      $sellprice=$mrp;
                      $item[$i][8]=$sellprice=to_currency($sellprice); 
                      $flood_cess_amt='';
                 }   
/*.... gst calculations ....*/
			  		
			  		}	
/*... Select batch ...*/	
                if($item[$i][1]=='Return'){
                 if($item[$i][1]=='Return' && $item[$i][12]!='5' && $item[$i][12]!='' && (date("Y-m-d") < "2021-08-01") ){
                 	 
                      
                        $taxable_mrp    = ($item[$i][7] * 100)/(101+$item[$i][12]); 
                        $total_cess     =($item[$i][7]-$taxable_mrp);//= $gst_amt+$cess                       
                      	$flood_cess_amt = $taxable_mrp/100;
                      	$gst_amt        = $flood_cess_amt*$item[$i][12]; 
                      	$cgst_amt = $sgst_amt = ($gst_amt/2);                    	
                        $item[$i][24]   =$flood_cess_amt;

                        $sellprice=$item[$i][7]-$total_cess;
                        $sellprice=to_currency($sellprice);
                        $item[$i][8]=$sellprice;
                      }
                      else{
                        $flood_cess_amt=0;
                      	$item[$i][24]=0;
                      	
                      }       
                 }



                  $item[$i][20]=to_currency($qty * $item[$i][15]); //total gst
                  $item[$i][21]=to_currency($qty * ($item[$i][16])); //total sgst
                  $item[$i][22]=to_currency($qty * ($item[$i][17])); //total cgst	
                  $item[$i][25]=to_currency($qty * $item[$i][24]); //total flood cess
          
                  if($paction=='Update' && empty($draft)){
                  	
                  $item[$i][23] =$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][18],'pharma_batch');
                
                  $item[$i][23]+=$qty_before_updation;
                 
                  }else{

                  	 $item[$i][23] =$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][18],'pharma_batch');
                  }
                  $total_gst +=$item[$i][20];
                  $total_sgst+=$item[$i][21];
		          $total_cgst+=$item[$i][22];
		          $total_flood_cess+=$item[$i][25];// fllod cess		  			
          
			  	  $items_in_array[]=array($item[$i][0],$item[$i][1],$item[$i][2],$item[$i][3],$item[$i][4],$item[$i][5],$qty,$item[$i][7],$item[$i][8],$total,$item[$i][10],$item[$i][11],$item[$i][12],$item[$i][13],$item[$i][14],$item[$i][15],$item[$i][16],$item[$i][17],$item[$i][18],$item[$i][19],$item[$i][20],$item[$i][21],$item[$i][22],$item[$i][23],$item[$i][24],$item[$i][25],$item[$i][26],$item[$i][27],$item[$i][28]);

              }
			}
		}
      
		$data['sales_amt']=$sales_amt;
	    $data['return_amt']=$return_amt;

	    $data['tot_gst']=$total_gst;
		$data['tot_cgst']=$total_cgst;
		$data['tot_sgst']=$total_sgst;
		$data['tot_flood_cess']=$total_flood_cess;//flood cess
	

	    $total_bill=$sales_amt;

        if($return_amt>0){
		
			$total_bill= $return_amt;
		}

	    $net_amt= $total_bill;

	    $data['total_bill']=to_currency($total_bill);

  $free_bill=$this->input->post('free_bill');

     // if(!empty($free_bill) && ($free_bill==1))
		   //  {
		   	 
		   // 	  $discount_type='%';
		   // 	  $discount_value='100';
		   // 	  // $discount_amt='';
     //          $data['discount_type']=$discount_type;

		   //     $data['discount_value']=$discount_value;

		   //  }else{
		    	  $data['discount_type']=$discount_type=$this->input->post('bill_disc_type');
		          $data['discount_value']=$discount_value=$this->input->post('bill_disc_value');

		  //  }
		       
            
		      
	  
		$data['free_bill']=$free_bill;
		$discount_amt=0;
		
		if(!empty($discount_type) && ($discount_value > 0)){
			
			if($discount_type == 'CASH'){
			
				$discount_amt=$discount_value;
				
			}else{
				$discount_amt= $total_bill *($discount_value/100);
			}
		}
		$data['discount_amt']=to_currency($discount_amt);
		
		if($discount_amt >0 ) {
		
			$net_amt= $total_bill - $discount_amt;

		}else if($discount_amt <0  && $return_amt<0) {
		
			$net_amt= $total_bill - $discount_amt;
		}	
		
		 
		$data['net_amt']=to_currency($net_amt);
		$data['bill_date']=date('d-m-Y');

		$roundstatus=$this->input->post('roundstatus');
		$round_net_amt=to_currency($net_amt);

/*... round of net total ...*/

		if(!empty($roundstatus) && ($roundstatus==1))
		    {
		   	   $round_net_amt= round($net_amt);
		   	   $round_amt=$round_net_amt-$net_amt;
               $round_amt=to_currency($round_amt);
		    }
               $data['round_net_amt']=$round_net_amt;
		       $data['roundstatus']=$roundstatus;
		       $data['round_amt']=$round_amt;

/*... round of net total ...*/

		$brand_name=$this->input->post('brand');
		$id=$this->input->post('brand_ID');
		$batch_id=$this->input->post('batch_ID');

        if(!empty($brand_name)){	
		
		  if(!empty($id) && !empty($batch_id)){	

		  	//batch details
				
				$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
				$expiry_date=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
				$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				$selling_unit=$this->commonDBFunctions->getidToValue('price_type','id',$batch_id,'pharma_batch');

				if($sales_mode_selected=='Sales'){

					  $sales_mode="Sales";

				}else $sales_mode="Return";

				$mrp=$this->commonDBFunctions->getidToValue('sellp','id',$batch_id,'pharma_batch');
                $mrp = to_currency($mrp);
/*....... gst details .......*/	
                $gst_per=$this->commonDBFunctions->getidToValue('gst_per','id',$batch_id,'pharma_batch');

                $sgst_per=$this->commonDBFunctions->getidToValue('sgst_per','id',$batch_id,'pharma_batch');

                $cgst_per=$this->commonDBFunctions->getidToValue('cgst_per','id',$batch_id,'pharma_batch');

                $gst_id=$this->commonDBFunctions->getidToValue('gst_id','id',$batch_id,'pharma_batch');
/*....... gst details .......*/
                
                // hsn no
                $hsn_no=$this->commonDBFunctions->getidToValue('hsn_no','id',$id,'pharma_brand');

/*.... gst calculations ....*/
             if(!empty($gst_id) && !empty($gst_per)) 
                 { 
                    $taxable_mrp=($mrp * 100)/(100+$gst_per);
                    $gst_amt=($mrp-$taxable_mrp);
                    $cgst_amt = $sgst_amt = ($gst_amt/2);

                    $sellprice=$mrp-$gst_amt;
                    $sellprice=to_currency($sellprice);

            /* ........FLOOD CESS CALCULATIONS....(1% TAXABLE VALUE  INCREASE FOR 2 YRS -01/08/2019   TO 2021).....*/
                      
                      if($gst_per !='5' && (date("Y-m-d") < "2021-08-01") ){
                        
                        $taxable_mrp    = ($mrp * 100)/(101+$gst_per); 
                        $total_cess     =($mrp-$taxable_mrp);//= $gst_amt+$cess
                        $flood_cess_amt = $total_cess/($gst_per+1);
                      	$gst_amt        = $flood_cess_amt*$gst_per; 
                      	$cgst_amt = $sgst_amt = ($gst_amt/2);                      	
                       
                        $sellprice=$mrp-$total_cess;
                        $sellprice=to_currency($sellprice);
                      
                      }
                      else{

                      	$flood_cess_amt=0;
                      	
                      }
       
                      
         /* ........... FLOOD CESS CALCULATIONS..........*/

                 } 
             else{
             	    $gst_id='';
             	    $gst_per='';
             	    $sgst_per='';
             	    $cgst_per='';
             	    $gst_amt='';
             	    $sgst_amt='';
             	    $cgst_amt='';
                    $sellprice=$mrp;
                    $sellprice=to_currency($sellprice);
                    $flood_cess_amt=''; 
                 }   
/*.... gst calculations ....*/

		  	$items_in_array[]=array($id,$sales_mode,$brand_name,$batch_name,$expiry_date,$selling_unit,'',$mrp,$sellprice,0,$batch_stock,$gst_id,$gst_per,$sgst_per,$cgst_per,$gst_amt,$sgst_amt,$cgst_amt,$batch_id,$hsn_no,'','','','',$flood_cess_amt,'',$saled_qty,$return_qty,$avilable_qty);

		  	$batchInfo=$this->session->userdata('batchidInfo');
			$batchInfo[]=$batch_id;
		    $this->session->set_userdata('batchidInfo',$batchInfo);

          
		  }else{
                 if(empty($batch_id)) $data['message']="Invalid Batch Selected";
			     else $data['message']="Invalid Brand Selected";
           }

        }

/*....... prescribed medicines .......*/
        
        $presc_med = $this->input->post('med_presc');
       // var_dump($presc_med);
		if(!empty($presc_med)){
			for ($i=0; $i<count($presc_med) ; $i++) { 

				$id=$presc_med[$i];

				$brand = $this->commonDBFunctions->getidToValue('brand','id',$presc_med[$i],'hcare_pharma_brand');
			    $generic_name = $this->commonDBFunctions->getidToValue('generic_name','id',$presc_med[$i],'hcare_pharma_brand');

			    $brand_name = $brand."(".$generic_name.")";

			    $selling_unit=$this->commonDBFunctions->getidToValue('selling_unit','id',$presc_med[$i],'hcare_pharma_brand');

			    $mrp=$this->commonDBFunctions->getidToValue('sellp','id',$presc_med[$i],'hcare_pharma_brand');

			    // hsn no
                $hsn_no=$this->commonDBFunctions->getidToValue('hsn_no','id',$id,'pharma_brand');

				$items_in_array[]=array($id,"Sales",$brand_name,'','',$selling_unit,'',$mrp,'',0,'','','','','','','','','',$hsn_no,'','','','','');
                
    	   }
		}        
        
/*....... prescribed medicines .......*/

/*....... purchased medicines .......*/
        
        $med_purchase = $this->input->post('med_purchase');
		if(!empty($med_purchase)){
			for ($i=0; $i<count($med_purchase) ; $i++) {

				$purchase_item_id=$med_purchase[$i];

				$brand_id = $this->commonDBFunctions->getidToValue('item_id','id',$purchase_item_id,'pharma_invoice_items');

				$brand = $this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			    $generic_name = $this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');

			    $brand_name = $brand."(".$generic_name.")";

			    $batch = $this->commonDBFunctions->getidToValue('batch_no','id',$purchase_item_id,'pharma_invoice_items');

			    $expiry_date = $this->commonDBFunctions->getidToValue('expiry','id',$purchase_item_id,'pharma_invoice_items');

			

			    $mrp = $this->commonDBFunctions->getidToValue('mrp','id',$purchase_item_id,'pharma_invoice_items');

			    $sellp = $this->commonDBFunctions->getidToValue('sellp','id',$purchase_item_id,'pharma_invoice_items');

			    $gst_id = $this->commonDBFunctions->getidToValue('gst_id','id',$purchase_item_id,'pharma_invoice_items');

			    $gst_per = $this->commonDBFunctions->getidToValue('gst_per','id',$purchase_item_id,'pharma_invoice_items');

			    $sgst_per = $this->commonDBFunctions->getidToValue('sgst_per','id',$purchase_item_id,'pharma_invoice_items');

			    $cgst_per = $this->commonDBFunctions->getidToValue('cgst_per','id',$purchase_item_id,'pharma_invoice_items');

			    $gst_amt = $this->commonDBFunctions->getidToValue('gst_amt','id',$purchase_item_id,'pharma_invoice_items');

			    $sgst_amt = $this->commonDBFunctions->getidToValue('sgst_amt','id',$purchase_item_id,'pharma_invoice_items');

			    $cgst_amt = $this->commonDBFunctions->getidToValue('cgst_amt','id',$purchase_item_id,'pharma_invoice_items');

			    $batch_id = $this->commonDBFunctions->getidToValue('batch_id','id',$purchase_item_id,'pharma_invoice_items');

			    // hsn no
                $hsn_no = $this->commonDBFunctions->getidToValue('hsn_no','id',$purchase_item_id,'pharma_invoice_items');
                
                $flood_cess_amt = $this->commonDBFunctions->getidToValue('flood_cess_amt','id',$purchase_item_id,'pharma_invoice_items');


				$items_in_array[]=array($brand_id,"Return",$brand_name,$batch,$expiry_date,'NOS','',$mrp,$sellp,0,0,$gst_id,$gst_per,$sgst_per,$cgst_per,$gst_amt,$sgst_amt,$cgst_amt,$batch_id,$hsn_no,'','','',$flood_cess_amt,'');
                
    	   }
		}        
        
/*....... purchased medicines .......*/
     
        $data['items_in_array']=$items_in_array;
		$data['itemcount']=count($items_in_array);

		return $data;
	}
	
	function manage_invoice($next_page = null){

		//load model info
		$this->load->model('invoice_model');
  
        $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$bill_no=$this->input->post("bill_no");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$patient_id=$this->input->post("patient_id");
		$bill_status=$this->input->post("bill_status");

		$current_page=$this->input->post("current_page");

		$message='';

		if(!empty($from_date)){
			$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}

        if(!empty($end_date)){
			$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}

		if(!empty($customer_type) && $customer_type == "OP"){
		
		  $search[] = "cust_type = '".$customer_type."'";
		  $data['cust_type_select']=$customer_type;
          $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		  if($patient_id!=""){

		  	$search[] = "op_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; OP No : ".$patient_id;

		  }
		  

		}elseif(!empty($customer_type) && $customer_type == "IP"){
		
		  $search[] = "cust_type = '".$customer_type."'";
		  $data['cust_type_select']=$customer_type;
          $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		  if($patient_id!=""){

		  	$search[] = "ip_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; IP No : ".$patient_id;

		  }
		  

		}elseif(!empty($customer_type) && $customer_type == "DIRECT"){

		  $search[] = "cust_type = '".$customer_type."'";
		  $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
		  $data['cust_type_select']=$customer_type;
		}

		if(!empty($bill_no)){
			$search[] = "id = ".$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
			$data['bill_no']=$bill_no;
		}

		if(!empty($payment_type)){
			$search[] = "payment_mode = '".$payment_type."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
			$data['payment_type_select']=$payment_type;
		}

		if($bill_status == 'CANCELLED'){
		
			$search[] ="status = 1";
			$data['bill_status']=1;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Cancelled Bill";
		}

		if(empty($search)){

            $search[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
              
            $search[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";

		}

	    if(empty($bill_status) || $bill_status == 'ACTIVE'){

		    $search[] ="status = 0";
		}

		$data['message']=$message;

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

		$invoice_count=$this->invoice_model->getInvoiceCount($search);

	    $data['billInfo']=$this->invoice_model->searchBill($search,'',$limit);

	    $data['pagination_link']=printPageLinks($invoice_count,$current_page,$perPage);
        
        $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view('invoice/manage_invoice',$data);
	}

	public function print_invoice($billid = null,$popup_path=null,$duplicate=null){

		 //load model
		$this->load->model('invoice_model');
		$this->load->model('admin_model');

		if(empty($billid)){

            $billid=$this->input->post("bill_id");
        }
	
		$search[0] = "id = ".$billid;
		$data['invoice_info']=$invoice_info=$this->invoice_model->searchBill($search);
		
		$search[0] = "bill_id = ".$billid;
		$search[1] = "status = 0";
		$data['invoice_item_Info']=$this->invoice_model->searchBillItems($search);
		$data['hospitalInfo']=$this->admin_model->getHospitalInfo();
		$data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();
		
		$from_path = $this->input->post("from_path");
		
		if (!empty($from_path)) {
			$data['from_path'] = $from_path;
		}
		
		if (!empty($popup_path)) {
			$data['popup_path'] = $popup_path;
		}

        $duplicate=$this->input->post("duplicate_print");

        if(!empty($duplicate)){

            $data['duplicate']=$duplicate;
        }

        $data['billid'] = $billid;

        $bill_type=$this->input->post("billtype");
        if(empty($bill_type)) $bill_type=$invoice_info[0][37];
        $data['bill_type']=$bill_type;

        if (!empty($data['hospitalInfo']) && $data['hospitalInfo'][0][13]==1 ) {
        	$this->load->view('invoice/print_invoice',$data);
        }
        else if (!empty($data['hospitalInfo']) && $data['hospitalInfo'][0][13]==2) {
        	$this->load->view('invoice/invoice_with_gst',$data);
        }
        else if (!empty($data['hospitalInfo']) && $data['hospitalInfo'][0][13]==3){
        	$this->load->view('invoice/invoice_with_gst_two',$data);
        }
	
	}

    function select_return_bill($next_page = null){
       
        //load model info
		$this->load->model('invoice_model');
  
        $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$bill_no=$this->input->post("bill_no");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");
		$patient_id=$this->input->post("patient_id");

		$current_page=$this->input->post("current_page");

		$message='';

		if(!empty($from_date)){
			$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}

        if(!empty($end_date)){
			$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}

		if(!empty($customer_type) && $customer_type == "OP"){
		
		  $search[] = "cust_type = '".$customer_type."'";

		  if($patient_id!=""){

		  	$search[] = "op_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; OP No : ".$patient_id;

		  }

		  $data['cust_type_select']=$customer_type;
		  $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		}elseif(!empty($customer_type) && $customer_type == "IP" && $patient_id!=""){
		
		  $search[] = "cust_type = '".$customer_type."'";

		  if($patient_id!=""){

		  	$search[] = "ip_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; IP No : ".$patient_id;

		  }
		  
		  $data['cust_type_select']=$customer_type;
		  $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		}elseif(!empty($customer_type) && $customer_type == "DIRECT"){

		  $search[] = "cust_type = '".$customer_type."'";
		  $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
		  $data['cust_type_select']=$customer_type;
		}

		if(!empty($bill_no)){
			$search[] = "id = ".$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
			$data['bill_no']=$bill_no;
		}

		if(!empty($payment_type)){
			$search[] = "payment_mode = '".$payment_type."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
			$data['payment_type_select']=$payment_type;
		}

		if(empty($search)){
           
            $search[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
            
            $search[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
	
		}

		$search[] ="status = 0";
		$search[] ="sales_mode != 'Return'";

		$data['message']=$message;

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

        $invoice_count = $this->invoice_model->getInvoiceCount($search);
       
	    $data['billInfo']=$this->invoice_model->searchBill($search,'',$limit);

	    $data['pagination_link']=printPageLinks($invoice_count,$current_page,$perPage);
        
        $data['current_page']=$current_page;

    /*... pagination end ...*/

		$this->load->view('invoice/select_return_bill',$data);
    }

    function invoice_return(){

    	//load model info
		$this->load->model('invoice_model');

    	$bill_id   =$this->input->post('bill_id');

    	$search[0] = "id = ".$bill_id;
		$invoice_info=$this->invoice_model->searchBill($search);
		
		$search[0] = "bill_id = ".$bill_id;
		$search[1] = "status = 0";
		$invoice_item_Info=$this->invoice_model->searchBillItems($search,'','Return');

		if(!empty($invoice_item_Info)){

		  for($i=0;$i<count($invoice_item_Info);$i++){

            if($invoice_item_Info[$i][5] =="Sales") {

            	$id            = $invoice_item_Info[$i][3];
            	$brand_name    = $invoice_item_Info[$i][12];
            	$batch_name    = $invoice_item_Info[$i][6];
            	$expiry_date   = $invoice_item_Info[$i][7];
            	$selling_unit  = $invoice_item_Info[$i][8];
            	$mrp           = $invoice_item_Info[$i][20];
            	$sellprice     = $invoice_item_Info[$i][10];
            	$batch_stock   = '';
            	$gst_id        = $invoice_item_Info[$i][21];
            	$gst_per       = $invoice_item_Info[$i][14];
            	$sgst_per      = $invoice_item_Info[$i][15];
            	$cgst_per      = $invoice_item_Info[$i][16];
            	$gst_amt       = $invoice_item_Info[$i][17];
            	$sgst_amt      = $invoice_item_Info[$i][18];
            	$cgst_amt      = $invoice_item_Info[$i][19];
            	$batch_id      = $invoice_item_Info[$i][4];
            	$hsn_no        = $invoice_item_Info[$i][28];
            	$flood_cess_amt= $invoice_item_Info[$i][37];

            	$saled_qty     = $invoice_item_Info[$i][9];;
            	$return_qty    = $invoice_item_Info[$i][40];
				$available_qty = $saled_qty-$return_qty;

// var_dump($saled_qty);var_dump($return_qty);
// var_dump($available_qty);exit();

            	$items_in_array[]=array($id,"Return",$brand_name,$batch_name,$expiry_date,$selling_unit,'',$mrp,$sellprice,0,$batch_stock,$gst_id,$gst_per,$sgst_per,$cgst_per,$gst_amt,$sgst_amt,$cgst_amt,$batch_id,$hsn_no,'','','','',$flood_cess_amt,'',$saled_qty,$return_qty,$available_qty);

            }

		  }

		}

		$data['items_in_array']=$items_in_array;
		$data['itemcount']     =count($items_in_array);

		$data['paction']       ='Save';
		$data['billid']        ='';
		$data['customer_type_select']=$invoice_info[0][2];
     
        if($invoice_info[0][2] =="OP"){

            $data['op_no']        =$invoice_info[0][34];
		    $data['op_id']        =$invoice_info[0][3];

		}else if($invoice_info[0][2] =="IP"){

            $data['ip_no']        =$invoice_info[0][33];
		}
		$data['customer_name']    =$invoice_info[0][4];
		$data['doctor']           =$invoice_info[0][30];
		$data['doc_id']           =$invoice_info[0][48];

		$data['return_billid']    =$invoice_info[0][1];

		$data['payment_type_selected']='';
		$data['checque_no']           ='';
		$data['checque_amt']          ='';
		$data['card_amt']             ='';
		$data['upi_amt']             ='';
		$data['branch_select']        ='';
        $data['sales_amt']            ='';
	    $data['return_amt']           ='';
        $data['total_bill']           ='';
        if($invoice_info[0][59] ==1){
        	 $data['discount_type']        ='%';
		$data['discount_value']       ='100';
        }else{
        	$data['discount_type']        ='';
		$data['discount_value']       ='';
        }
        
		$data['discount_amt']         ='';
        $data['net_amt']              ='';
		$data['bill_date']            ='';
		$data['amt_paid']             ='';
        
        $data['tot_gst']              ='';
        $data['tot_cgst']             ='';
        $data['tot_sgst']             ='';
        $data['tot_flood_cess']       ='';

		$data['roundstatus']          ='';
		$data['round_net_amt']        ='';
		$data['round_amt']            ='';
        
		$data['sales_mode_selected']  ='Return';

		$data['itemfocus']            ='';

		$data['item_focus_select']    ='';

		$data['billwise_return']      ='Billwise_Return';
		$data['free_bill']            =$invoice_info[0][59];
        
        $this->load->view('invoice/invoice_form',$data);
    }

    public function delete($id){

    	//load model info
		$this->load->model('invoice_model');


		$criteria[0] = "bill_no = ".$id;
		$criteria[1] = "status = 0";
		$data['invoice_Credit_Info']=$invoice_Credit_Info=$this->invoice_model->getCreditPayment($criteria);

		 if(!empty($invoice_Credit_Info)){

		  $this->session->set_flashdata('delete_msg', 'Credit already payed. Cant delete!');

		  redirect("invoice/manage_invoice", 'refresh');

		 }
	
		$cancellation_details=$this->input->post("cancellation_details");
	
		$this->delete_invoice_items($id);
		$this->invoice_model->delete_invoice($id,$cancellation_details);


		$this->session->set_flashdata('delete_msg', 'Deleted Successfully!');

		redirect("invoice/manage_invoice", 'refresh');
		
	}

	public function delete_invoice_items($id){

		//load model info
		$this->load->model('invoice_model');
		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('item_history_model');
	
		$search[] = "bill_id = ".$id;
		$search[] = "status = 0";
		$itemInfo=$this->invoice_model->searchBillItems($search);
		
		if(!empty($itemInfo)){
		
		  for($i=0;$i<count($itemInfo);$i++){

             $branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$itemInfo[$i][4],'pharma_batch');

					$invoice_mode=$itemInfo[$i][5];

					$new_batch_qty=$itemInfo[$i][9];

					if($invoice_mode=="Return"){

					  $new_batch_qty=-($new_batch_qty);
					  $invoice_mode_info="INVOICE_RETURN_CANCEL";

					}else $invoice_mode_info="INVOICE_CANCEL";
                    
                    $brand_id=$itemInfo[$i][3];
					$batch_id=$itemInfo[$i][4];

					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

				    $new_batch_stock=$batch_stock+$new_batch_qty;
					
					if($new_batch_stock<0) $new_batch_stock=0;

					$this->batch_model->update_stock($batch_id,$new_batch_stock,$invoice_mode_info);

					if(!empty($branch_id)){

                        $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }else{

                    	$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }

                        //add info to history
			
			               $info['brand_id']=$brand_id;
			               $info['batch_id']=$batch_id;
			               $info['type']=$itemInfo[$i][8];
			               $info['quantity']= $new_batch_qty;
			               $info['old_stock_batch']=$batch_stock;
			               $info['new_stock_batch']=$new_batch_stock;
			               $info['old_stock_brand']=$brand_stock;
			               $info['new_stock_brand']=$new_brand_stock;
			               $info['action']="DELETE";
			               $info['mode']=$invoice_mode_info;
			               $info['reference_id']=$id;//bill id
			               $info['expiry_date']=$itemInfo[$i][7];
			               $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			               $info['branch_id']=$branch_id;
			               $info['old_stock_branch']=$branch_stock;
			               $info['new_stock_branch']=$new_branch_stock;

	$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
	$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			               $info['brand_name']=$brand_name;
			               $info['batch_number']=$batch_name;
			
			               $this->item_history_model->add_history($info);

		  }

		}

        $this->invoice_model->delete_invoice_items($id);
	}

	function user_authentication($billid=null,$authentication_type){

		$data['billid']=$billid;
		$data['authentication_type']=$authentication_type;
		$this->load->view('invoice/user_authentication',$data);
	}

	public function addUpdationhistory($billid,$net_total,$balance){
	
		$criteria[0] = "id = ".$billid;
		$invoice_info=$this->invoice_model->searchBill($criteria);
		
		$net_prev=to_currency($invoice_info[0][14]);
		$balance_prev=to_currency($invoice_info[0][20]);
		
		
		$user_id=$this->input->post('user_id');
		
		$info[0]=$billid;
		$info[1]=date("Y-m-d H:i:s");
		$info[2]=$net_prev;
		$info[3]=$balance_prev;
		$info[4]=$net_total;
		$info[5]=$balance;
		$info[6]=$user_id;
		
		$this->invoice_model->addUpdationhistory($info);
		
	
	}

	function add_invoice($auth_user_id = null){


		//load model
		$this->load->model('invoice_model');
		$this->load->model('batch_model');
		$this->load->model('brand_model');
                $this->load->model('item_history_model');
		
		$op_no=$this->input->post('op_no');
		$draft=$this->input->post('draft');
		$date=$this->input->post('date');
	
		$free_bill=$this->input->post('free_bill');

		$payment_type=$this->input->post('payment_type');
		$net_total=$this->input->post('net_total');
		$rounded_net_total=$this->input->post('round_net_amt');
		$amount_paid=$this->input->post('amount_paid');
		$user_id   		= $this->session->userdata('user_id');
		$this->session->unset_userdata('batchidInfo');
		
		$action=$this->input->post('paction');
		$billid=$this->input->post('billid');

		$invoice_bill_date=$this->input->post('invoice_bill_date');
		
		if($payment_type == "CREDIT CARD"){
		
			$card_amt=$this->input->post('card_amt');
			$balance= $rounded_net_total - ($amount_paid+$card_amt);
			
		}else if($payment_type == "CHEQUE"){
		
			$checque_amt=$this->input->post('checque_amt');
			$balance= $rounded_net_total - ($amount_paid+$checque_amt);
			
		}else if($payment_type == "UPI"){
		
			$upi_amt=$this->input->post('upi_amt');
			$balance= $rounded_net_total - ($amount_paid+$upi_amt);
			
		}else {
		
			
			$balance= $rounded_net_total - ($amount_paid);
		}
		
// 		if($action == "Update"){

// 		if($draft !='YES'){

// 				$this->addUpdationhistory($billid,$net_total,$balance);
// 				$result=$this->invoice_model->updateBill($balance,$auth_user_id);
// 				$this->delete_invoice_items($billid);

// 		}else{
			
// 			// if(!empty($billid)){
				
// 				$status=2;
// 				$result1=$this->invoice_model->update_DraftBill($balance,$auth_user_id,$status);
//                 $result=$this->invoice_model->addBill($balance,$auth_user_id);
// 			}
// }
// 			else{
			
// 			    $result=$this->invoice_model->addBill($balance,$auth_user_id);
// 		    }
// 		}


			if($action == 'Update'){ 
			if($draft== 'YES'){
			
				$status=2;
				$result1=$this->invoice_model->update_DraftBill($balance,$auth_user_id,$status);
				
                $result=$this->invoice_model->addBill($balance,$auth_user_id);
			}
			else{
		
				$this->addUpdationhistory($billid,$net_total,$balance);
				$result=$this->invoice_model->updateBill($balance,$auth_user_id);
				$this->delete_invoice_items($billid);


				$op_payment = $this->input->post('op_payment');

				// if (!empty($op_payment)) {
					$this->load->model('hcare_model');
					$this->hcare_model->updateOpPayment();
				// }
			 

			
		    }
           }
			else{
         
          
			$result=$this->invoice_model->addBill($balance,$auth_user_id);

			$op_payment = $this->input->post('op_payment');

			if (!empty($op_payment)) {
				$this->load->model('hcare_model');
				$this->hcare_model->updateOpPayment();
			}
			 
		

		}
		
		if($result > 0 ) {

			$billid=$result1;
			$bill_id=$result;
			
			$itemcount=$this->input->post('item_count');
			if($itemcount > 0 ){
                         
					// $status=2;
				for($i=0;$i<$itemcount;$i++){
                    $this->invoice_model->update_invoice_draft_items($billid,'');
			         
					$item=$this->input->post('item');

					// $this->invoice_model->addBillItems($item[$i],$bill_id);

					if($action == 'Update'){ 
						$this->invoice_model->addBillItems($item[$i],$bill_id,$invoice_bill_date);

					}
					else{
						$this->invoice_model->addBillItems($item[$i],$bill_id);
					}
					

					$branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$item[$i][18],'pharma_batch');

					$invoice_mode=$item[$i][1];

					$new_batch_qty=$item[$i][6];

					if($invoice_mode=="Sales"){

					  $new_batch_qty=-($new_batch_qty);
					  $invoice_mode_info="INVOICE_SALES";

					}else $invoice_mode_info="INVOICE_RETURN";
                    
                    $brand_id=$item[$i][0];
					$batch_id=$item[$i][18];

					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

				    $new_batch_stock=$batch_stock+$new_batch_qty;
					
					if($new_batch_stock<0) $new_batch_stock=0;

					$this->batch_model->update_stock($batch_id,$new_batch_stock,$invoice_mode_info);

					if(!empty($branch_id)){

                        $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }else{

                    	$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }

                        //add info to history
			
			               $info['brand_id']=$brand_id;
			               $info['batch_id']=$batch_id;
			               $info['type']=$item[$i][5];
			               $info['quantity']= $new_batch_qty;
			               $info['old_stock_batch']=$batch_stock;
			               $info['new_stock_batch']=$new_batch_stock;
			               $info['old_stock_brand']=$brand_stock;
			               $info['new_stock_brand']=$new_brand_stock;
			               $info['action']="ADD";
			               $info['mode']=$invoice_mode_info;
			               $info['reference_id']=$bill_id;//bill id
			               $info['expiry_date']=$item[$i][4];
			               $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			               $info['branch_id']=$branch_id;
			               $info['old_stock_branch']=$branch_stock;
			               $info['new_stock_branch']=$new_branch_stock;
			               $info['brand_name']=$item[$i][2];
			               $info['batch_number']=$item[$i][3];
			
			               $this->item_history_model->add_history($info);


			    }

			    $ip_medicines_id=$this->input->post('ip_medicines_id');

			    if (!empty($ip_medicines_id)) {
			    	
			    	$ip_medicines_id = explode(",", $ip_medicines_id);

			    	for ($i=0; $i <count($ip_medicines_id) ; $i++) { 
			    		
			    		$this->invoice_model->update_ip_prescribed($ip_medicines_id[$i],$bill_id);

			    	}

			    }

// Doctor Prescription in IP 22-12-2020 Start
			    $doct_presc=$this->input->post('doct_presc');

			    if (!empty($doct_presc)) {

			        if (!empty($ip_medicines_id)) {

			    	  for ($i=0; $i <count($ip_medicines_id) ; $i++) { 
			    		
			    		$this->invoice_model->update_ip_doctor_prescribed($ip_medicines_id[$i],$bill_id);

			    	  } 
			        }
			    }
// Doctor Prescription in IP 22-12-2020 End

			    $op_medicines_id=$this->input->post('op_medicines_id');

			    if (!empty($op_medicines_id)) {
			    
			    	$op_medicines_id = explode(",", $op_medicines_id);

			    	for ($i=0; $i <count($op_medicines_id) ; $i++) {
						
			    		
			    		$this->invoice_model->update_op_prescribed($op_medicines_id[$i],$bill_id);

			    	}

			    }




			} 
			// $this->print_invoice($bill_id);   
			redirect('invoice/print_invoice/'.$bill_id);
		}
	}

	function op_patinet_list($sales_mode=null){

		//load model
        $this->load->model('hcare_model');

        $search=$this->input->post("op_search");

        if(!empty($search)){
		    
			$opno=$this->input->post("opno");
			$date=$this->input->post("date");
			$name=$this->input->post("name");
			$place=$this->input->post("place");
			$contact_no=$this->input->post("contact_no");
			$doctor=$this->input->post("doctor");

            //sales return or sales checking
			$sales_type=$this->input->post("sales_type");
			if(empty($sales_mode) && $sales_type=='Return') $sales_mode=$sales_type;
			
			if(!empty($opno)){			
				$selectCondition[]="a.`id` ='".$opno."'";
			
			}
			if(!empty($date)){			
				$selectCondition[]="b.`visit_date` like '".date('Y-m-d',strtotime($date))."%'";
			
			}
			if(!empty($name)){			
				$selectCondition[]="a.`first_name` like '%".$name."%'";
			
			}
			if(!empty($place)){			
				$selectCondition[]="a.`place` ='".$place."'";
			
			}
			if(!empty($contact_no)){			
				$selectCondition[]="a.`contact_no` ='".$contact_no."'";
			
			}
			if(!empty($doctor)){			
				$selectCondition[]="b.`doc_id` ='".$doctor."'";
			
			}

            //sales return or sales checking
			if($sales_mode=='Return'){

               $url=base_url()."index.php/invoice/invoice_return_form";

            }else{

               $url=base_url()."index.php/invoice/invoice_form";

            }
			
			$patientInfo=$this->hcare_model->getOPPatientInfo($selectCondition);
			$tablerow ="";
			if(!empty($patientInfo)){
				$j=1;
				for($i=0;$i<count($patientInfo);$i++){
				
					$patient_name=$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];
					$doctor_name="DR. ".$patientInfo[$i][15]." ".$patientInfo[$i][16];
					
					$tablerow.= "<tr>";
					
					$tablerow.="<td>";
					$tablerow.= $j++;
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][0];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$function='redirect("'.$patientInfo[$i][13].'","'.$patientInfo[$i][0].'","'.$patient_name.'","'.$doctor_name.'","'.$url.'","'.$patientInfo[$i][14].'")';
					$tablerow.= "<a href='#' onclick='$function'>$patient_name</a>";

					if($patientInfo[$i][44] == 'YES' || $patientInfo[$i][44] == 'DISCHARGED'){

					$tablerow.=	"<Br><span class='text-red' ><small>(Observation)</small></span>";

					}
					
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][4];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][6];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][8];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= date("d-m-Y",strtotime($patientInfo[$i][20]));
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][19];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][23];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= "DR. ".$patientInfo[$i][15]." ".$patientInfo[$i][16];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][32];
					$tablerow.="</td>";

					if (!empty($patientInfo[$i][45])) {
						$tablerow.="<td class='prescription_color'>";
						$tablerow.= 'YES';
						$tablerow.="</td>";
					}
					else{
						$tablerow.="<td>";
						$tablerow.= '';
						$tablerow.="</td>";
					}


					
					
				
				}
			
			}
			$data['tableInfo']=$tablerow;
			echo json_encode($data);
	    }else{
		
		   $data['doctors']=$this->hcare_model->getDoctors();
           
		   $where[]="b.visit_date like '".date("Y-m-d")."%'";
		   $data['patientInfo']=$this->hcare_model->getOPPatientInfo($where);
		   $data['sales_mode']=$sales_mode;
		
		 $this->load->view('invoice/op_patient_list',$data);
	    }
		
	}

	function ip_patient_list($sales_mode=null){
    
        //load model
        $this->load->model('hcare_model');

        $search=$this->input->post("ip_search");

	    if(!empty($search)){
		
			$from_date=$this->input->post("from_date");
			$to_date=$this->input->post("to_date");
			$name=$this->input->post("first_name");
			$ipno=$this->input->post("ipno");
			$room_no=$this->input->post("room_no");
            $place=$this->input->post("place");
			//$doctor=$this->input->post("doctor");

            //sales return or sales checking
			$sales_type=$this->input->post("sales_type");
			if(empty($sales_mode) && $sales_type=='Return') $sales_mode=$sales_type;
			
			if(!empty($ipno)){			
				$selectCondition[]="b.`id` ='".$ipno."'";
			
			}
			if(!empty($from_date)){			
				$selectCondition[]="b.`admission_date` >='".date('Y-m-d',strtotime($from_date))."'";
			
			}
                        if(!empty($to_date)){			
				$selectCondition[]="b.`admission_date` <='".date('Y-m-d',strtotime($to_date))."'";
			
			}
			if(!empty($name)){			
				$selectCondition[]="a.`first_name` like '%".$name."%'";
			
			}
			if(!empty($place)){			
				$selectCondition[]="a.`place` ='".$place."'";
			
			}
			if(!empty($room_no)){			
				$selectCondition[]="c.`room_number` ='".$room_no."'";
			
			}
			/*if(!empty($doctor)){			
				$selectCondition[]="b.`doc_id` ='".$doctor."'";
			
			}*/

			$selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
            $selectCondition[]="(b.bill_status =0 or b.bill_status =3)";
			$selectCondition[]="(b.cancelled =0)";
			
			$patientInfo=$this->hcare_model->getIPPatientInfo($selectCondition);
			$tablerow ="";

            //sales return or sales checking
            if($sales_mode=='Return'){

               $url=base_url()."index.php/invoice/invoice_return_form";

            }else{

               $url=base_url()."index.php/invoice/invoice_form";

            }

			if(!empty($patientInfo)){
				$j=1;
				for($i=0;$i<count($patientInfo);$i++){
				
					$patient_name=$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];
                                         $doctor_name="DR. ".$patientInfo[$i][17]." ".$patientInfo[$i][18];
					
					$tablerow.= "<tr>";
					
					$tablerow.="<td>";
					$tablerow.= $j++;
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][13];
					$tablerow.="</td>";

                                        $tablerow.="<td>";
					$tablerow.= $patientInfo[$i][15];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$function='redirect("'.$patientInfo[$i][13].'","'.$patient_name.'","'.$doctor_name.'","'.$url.'","'.$patientInfo[$i][16].'")';
					$tablerow.= "<a href='#' onclick='$function'>$patient_name</a>";
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][4];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][6];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][8];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= date("d-m-Y",strtotime($patientInfo[$i][20]));
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][19];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= $patientInfo[$i][36];
					$tablerow.="</td>";
					
					$tablerow.="<td>";
					$tablerow.= "DR. ".$patientInfo[$i][17]." ".$patientInfo[$i][18];
					$tablerow.="</td>";

					if (!empty($patientInfo[$i][39]) || !empty($patientInfo[$i][40])) {
						$tablerow.="<td class='prescription_color'>";
						$tablerow.= 'YES';
						$tablerow.="</td>";
					}
					else{
						$tablerow.="<td>";
						$tablerow.= '';
						$tablerow.="</td>";
					}

					
						
				}
			
			}
			$data['tableInfo']=$tablerow;
			echo json_encode($data);
	      }else{

                   $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";
		           $selectCondition[]="(b.bill_status =0 or b.bill_status=3)";
			       $selectCondition[]="(b.cancelled =0)";

                   $data['patientInfo']=$this->hcare_model->getIPPatientInfo($selectCondition);
                   $data['sales_mode']=$sales_mode;

                   $this->load->view('invoice/ip_patient_list',$data);

                }
	}

	public function credit_payment(){

        //load model info
		$this->load->model('invoice_model');
  
        $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$bill_no=$this->input->post("bill_no");
		$payment_type=$this->input->post("payment_type");
		$customer_type=$this->input->post("customer_type");

		$message='';

		if(!empty($from_date)){
			$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}

        if(!empty($end_date)){
			$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}

		if(!empty($customer_type)){
			$search[] = "cust_type = '".$customer_type."'";
			$data['cust_type_select']=$customer_type;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
		}

		if(!empty($bill_no)){
			$search[] = "id = ".$bill_no;
			$data['bill_no']=$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
		}

		if(!empty($payment_type)){
			$search[] = "payment_mode = '".$payment_type."'";
			$data['payment_type_select']=$payment_type;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
		}

		if(empty($search)){

            $search[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
	
            $search[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";
            

		}

            $search[] ="balance > 0";
			$search[] ="status = 0";
		
		$data['message']=$message;

		$data['billInfo']=$this->invoice_model->searchBill($search,'credit');

		$this->load->view('invoice/credit_payment',$data);

	}

    public function credit_payment_form($id){	

    	//load model info
		$this->load->model('invoice_model');

    	$search[] = "id = ".$id;
		
		$billInfo=$this->invoice_model->searchBill($search);

		$data['bill_no']=$id;
		$data['billInfo']=$billInfo;

    	$this->load->view('invoice/credit_payment_form',$data);
    }

    public function addCreditPayment(){

    	//load model info
		$this->load->model('invoice_model');
	
		$billid=$this->invoice_model->addCreditPayment();
		
		$this->print_credit_payment($billid);
	
	}

	public function manage_credit_payment(){

		//load model info
		$this->load->model('invoice_model');
	
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$bill_no=$this->input->post("bill_no");
		$bill_status=$this->input->post("bill_status");
		$payment_type=$this->input->post("payment_type");

		$current_page=$this->input->post('current_page');

		$message='';

		if(!empty($from_date)){

			$search[] = "date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){

			$search[] = "date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}
		
		if(!empty($bill_no)){

			$search[] = "bill_no = ".$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
			$data['bill_no']=$bill_no;
		}

		if(!empty($payment_type)){

			$search[] = "payment_type = '".$payment_type."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
			$data['payment_type']=$payment_type;
		}

		if($bill_status == 'CANCELLED'){
		
			$search[] ="status = 1";
			$data['bill_status']=1;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Cancelled Bill";
		}

		if(empty($search)){

			$search[] = "date >= '".date("Y-m-d")." 00:00:00'";
	
			$search[] = "date <= '".date("Y-m-d")." 23:59:59'";
         
		
		}

		if(empty($bill_status) || $bill_status == 'ACTIVE'){

			$search[] ="status = 0";
		}



		$data['message']=$message;

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
		
        $count_credit_payments=$this->invoice_model->getCreditPaymentCount($search);

        $data['billInfo']=$this->invoice_model->getCreditPayment($search,$limit);
		
        $data['pagination_link']=printPageLinks($count_credit_payments,$current_page,$perPage);
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('invoice/manage_credit_payment',$data);
		
	}

	public function print_credit_payment($id = null){

		//load model info
		$this->load->model('invoice_model');
		$this->load->model('admin_model');

		if(empty($id)){
   
            $id=$this->input->post('credit_id');
		}

          $search[] = "id = ".$id;
          $search[] ="status =0";

        $data['billInfo']=$this->invoice_model->getCreditPayment($search);
        $data['hospitalInfo']=$this->admin_model->getHospitalInfo();
        $data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();


        $this->load->view('invoice/print_credit_payment',$data);

    }

    public function delete_credit_payment($id){

    	//load model info
		$this->load->model('invoice_model');
	
		$cancellation_details=$this->input->post("cancellation_details");

		$this->invoice_model->delete_credit_payment($id,$cancellation_details);
		
		$this->session->set_flashdata('delete_msg', 'Deleted Successfully!');

		redirect("invoice/manage_credit_payment", 'refresh');
		
	}

	public function doctor_prescription($op_id,$item_count){

        //load model
		$this->load->model('invoice_model');

		$data['op_id']=$op_id;

		$data['op_no'] = $this->commonDBFunctions->getidToValue('opno','id',$op_id,'hcare_op_visit_info'); 

		$data['item_count']=$item_count;

		$criteria[0] = "visit_id = ".$op_id;

		$data['prescription_info'] = $prescription_info = $this->invoice_model->getPrescription($criteria);
	//	$data['draft']=$draft;
		$this->load->view('invoice/select_prescription',$data);


	}	

// 	function select_batch($brand_id,$opno=null,$draft=null,$invoice_id=null){

// 		//load model
// 		$this->load->model('batch_model');
// 		$this->load->model('invoice_model');
//       // $op_no=$this->input->post("opno");
        
       
// 		$data['opno']=$opno;
//         $data['brand_id'] = $brand_id;

//         $batch_drafted = array();
		
// 		$newDate = date("Y-m-d",strtotime("+30 day"));
		
// 		$search[0]="brand_id = ".$brand_id;				
// 		$search[1]="expiry_date >'".$newDate."'";
// 		$search[2]="batch_stock >0";
		
// 		$user_id   		= $this->session->userdata('user_id');
// 		$branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');

// 		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
// 		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
// 		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
// 		$data['brand_name']=$brand_name."(".$generic_name.")";
// 		$data['shelf_number']=$shelf_number;
// //...............patient_allergy_details
// 		 // var_dump( $brand);
// 		 $search1[0]="status=0";
// 		 $search1[1]="opno= ".$opno;
// 		  $search1[2]="(`allergic_to` like '%".$brand_name."%' or `allergic_to` like '%".$generic_name."%')";		
// 	     $itemInfo=$this->invoice_model->get_patient_allergies($search1);
// 	     // var_dump( $search1);
// 			if (!empty($itemInfo)) {
				
// 				for ($i=0; $i <count($itemInfo) ; $i++) { 
					
// 					$allergy_item[] = $itemInfo[$i][3];

// 				}

// 			}
// 			    $data['item_name']=$brand_name;
// 			    $data['generic_name']=$generic_name;
// 				$data['allergy_item'] =$allergy_item;

// //...............patient_allergy_detais	
// 		if($branch > 0){
		
// 			$search[3]="branch_id = ".$branch;				
// 		}else{
// 			$search[3]="branch_id = 0";
// 		}

// 		$data['draft']=$draft;

// 		if (!empty($draft)) {
			
// 			$criteria[0] = "bill_id = ".$invoice_id;
// 			$criteria[1] = "status = 0";
// 			$draft_itemInfo=$this->invoice_model->search_DraftBillItems($criteria);

// 			if (!empty($draft_itemInfo)) {
				
// 				for ($i=0; $i <count($draft_itemInfo) ; $i++) { 
					
// 					$batch_drafted[] = $draft_itemInfo[$i][4];

// 				}

// 			}


// 		}

// 		$data['batch_drafted']=$batch_drafted;
		 
// 		$data['batch']=$this->batch_model->getBatch($search);
// 		$this->load->view('invoice/select_batch',$data);

// 	}

	function select_batch($brand_id,$invoice_id=null,$type=null,$opno=null){
   
		//load model
		$this->load->model('batch_model');
		$this->load->model('invoice_model');

        $data['opno']=$opno;
        $data['brand_id'] = $brand_id;

        $batch_drafted = array();
        $edited_item = array();
		
		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;				
		$search[1]="expiry_date >'".$newDate."'";
		$search[2]="batch_stock >0";
		
		$user_id   		= $this->session->userdata('user_id');
		$branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');

		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$brand_name = str_replace('"', '\"', $brand_name);
		$brand_name = str_replace("'", "\'", $brand_name);
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
		$generic_name = str_replace('"', '\"', $generic_name);
		$generic_name = str_replace("'", "\'", $generic_name);
		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
		$data['brand_name']=$brand_name."(".$generic_name.")";
		$data['shelf_number']=$shelf_number;

		//...............patient_allergy_details
		 // var_dump( $brand);
		 $search1=array();
		 $search1[0]="status=0";
		 $search1[1]="opno= ".$opno;
		  $search1[2]="(`allergic_to` like '%".$brand_name."%' or `allergic_to` like '%".$generic_name."%')";		
	     $itemInfo=$this->invoice_model->get_patient_allergies($search1);
	     // var_dump( $itemInfo);
			if (!empty($itemInfo)) {
				
				for ($i=0; $i <count($itemInfo) ; $i++) { 
					
					$allergy_item[] = $itemInfo[$i][3];

				}

			}
			    $data['item_name']=$brand_name;
			    $data['generic_name']=$generic_name;
				$data['allergy_item'] =$allergy_item;

//...............patient_allergy_detais	
	
		if($branch > 0){
		
			$search[3]="branch_id = ".$branch;				
		}else{
			$search[3]="branch_id = 0";
		}


		if ($type=="YES") {

			$data['draft']=$type;
			if (!empty($type)) {
				
				$criteria[0] = "bill_id = ".$invoice_id;
				$criteria[1] = "status = 0";
				$draft_itemInfo=$this->invoice_model->search_DraftBillItems($criteria);

				if (!empty($draft_itemInfo)) {
					
					for ($i=0; $i <count($draft_itemInfo) ; $i++) { 
						
						$batch_drafted[] = $draft_itemInfo[$i][4];

					}

				}


			}

			$data['batch_drafted']=$batch_drafted;


		}
		else if ($type=="EDIT") {

			$data['draft']=$type;
			if (!empty($type)) {
				
				$criteria[0] = "bill_id = ".$invoice_id;
				$criteria[1] = "status = 0";
				$itemInfo=$this->invoice_model->searchBillItems($criteria);

				if (!empty($itemInfo)) {
					
					for ($i=0; $i <count($itemInfo) ; $i++) { 
						
						$edited_item[] = $itemInfo[$i][4];

					}

				}


			}

			$data['edited_item']=$edited_item;



		}




		
		$data['batch']=$this->batch_model->getBatch($search);
		$this->load->view('invoice/select_batch',$data);

	}


	function select_batch_return($brand_id){

		//load model
		$this->load->model('batch_model');

        $data['brand_id'] = $brand_id;
		
		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;				
		$search[1]="expiry_date >'".$newDate."'";
		$search[2]="batch_stock >=0";
		
		$user_id   		= $this->session->userdata('user_id');
		$branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');

		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
		$data['brand_name']=$brand_name."(".$generic_name.")";
		$data['shelf_number']=$shelf_number;
	
		if($branch > 0){
		
			$search[3]="branch_id = ".$branch;				
		}else{
			$search[3]="branch_id = 0";
		}
		
		$data['batch']=$this->batch_model->getBatch($search);
		$this->load->view('invoice/select_batch_return',$data);

	}

	function select_batch_medicine($brand_id,$item_pos,$opno=null){

		//load model

		$this->load->model('batch_model');
		$this->load->model('invoice_model');


        $data['brand_id'] = $brand_id;

        $data['opno']=$opno;

        $data['item_pos'] = $item_pos;
      
       // $batch_drafted = array();

		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;				
		$search[1]="expiry_date >'".$newDate."'";
		$search[2]="batch_stock >0";
		
		$user_id   		= $this->session->userdata('user_id');
		$branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');

		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$brand_name = str_replace('"', '\"', $brand_name);
		$brand_name = str_replace("'", "\'", $brand_name);
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
		$generic_name = str_replace('"', '\"', $generic_name);
		$generic_name = str_replace("'", "\'", $generic_name);
		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
		$data['brand_name']=$brand_name."(".$generic_name.")";
		$data['shelf_number']=$shelf_number;

		 $search1[0]="status=0";
		 $search1[1]="opno= ".$opno;
		  $search1[2]="(`allergic_to` like '%".$brand_name."%' or `allergic_to` like '%".$generic_name."%')";		
	     $itemInfo=$this->invoice_model->get_patient_allergies($search1);
	     // var_dump( $itemInfo);
			if (!empty($itemInfo)) {
				
				for ($i=0; $i <count($itemInfo) ; $i++) { 
					
					$allergy_item[] = $itemInfo[$i][3];

				}

			}
			    $data['item_name']=$brand_name;
			    $data['generic_name']=$generic_name;
				$data['allergy_item'] =$allergy_item;
	
		if($branch > 0){
		
			$search[3]="branch_id = ".$branch;				
		}else{
			$search[3]="branch_id = 0";
		}
		// $data['draft']=$draft;

		// if (!empty($draft)) {
			
		// 	$criteria[0] = "bill_id = ".$invoice_id;
		// 	$criteria[1] = "status = 0";
		// 	$draft_itemInfo=$this->invoice_model->search_DraftBillItems($criteria);

		// 	if (!empty($draft_itemInfo)) {
				
		// 		for ($i=0; $i <count($draft_itemInfo) ; $i++) { 
					
		// 			$batch_drafted[] = $draft_itemInfo[$i][4];

		// 		}

		// 	}


		// }

		//$data['batch_drafted']=$batch_drafted;

				
		$data['batch']=$this->batch_model->getBatch($search);
		$this->load->view('invoice/select_batch_medicine',$data);

	}
	public function doctor_prescription_ip($ip_no,$item_count){

        //load model
		$this->load->model('invoice_model');
        $criteria = array();

		$data['ip_no']=$ip_no;

		// $data['op_no'] = $this->commonDBFunctions->getidToValue('opno','id',$op_id,'hcare_op_visit_info'); 

		$data['item_count']=$item_count;

		$criteria[0] = "ipno = ".$ip_no;

		$data['prescription_info'] = $prescription_info = $this->invoice_model->getPrescriptionIp($criteria);	

		if (!empty($prescription_info)) {
			
			for ($i=0; $i < count($prescription_info); $i++) { 
				$prescribed_id[$i] = $prescription_info[$i][0];
			}

		}
	//	$data['draft']=$draft;
		$this->load->view('invoice/select_prescription_ip',$data);


	}	

	public function purchased_medicines_list($customer_type,$ref_no,$item_count){

        //load model
		$this->load->model('invoice_model');

		if($customer_type=='IP'){

           $data['ip_no']=$ref_no;

		   $op_no = $this->commonDBFunctions->getidToValue('opno','id',$ref_no,'ip_info');

		   $patient_name = $this->commonDBFunctions->getidToValue('first_name','id',$op_no,'op_patient_info')." ".$this->commonDBFunctions->getidToValue('middle_name','id',$op_no,'op_patient_info')."".$this->commonDBFunctions->getidToValue('last_name','id',$op_no,'op_patient_info');

		   $data['patient_name']=$patient_name;

		   $criteria[0] = "a.`cust_type` = 'IP'";
		   $criteria[1] = "a.`ip_no` = '".$ref_no."'";
		   $criteria[2] = "a.`sales_mode` = 'Sales'";

		}

		$data['medicines_list'] =$medicines_list= $this->invoice_model->purchased_medicines_list($criteria);

		$data['item_count']=$item_count;

		$this->load->view('invoice/purchased_medicines_list',$data);

	}

	function add_draft_invoice($auth_user_id = null){


		$item=$this->input->post('item');

	

		//load model
		$this->load->model('invoice_model');
		$this->load->model('batch_model');
		$this->load->model('brand_model');
                $this->load->model('item_history_model');
		
		$payment_type=$this->input->post('payment_type');
		$net_total=$this->input->post('net_total');
		$rounded_net_total=$this->input->post('round_net_amt');
		$amount_paid=$this->input->post('amount_paid');
		
		$this->session->unset_userdata('batchidInfo');
		
		$paction=$this->input->post('paction');
		$billid=$this->input->post('invoice_id');
	        $item_loc=$this->input->post('item_loc');



		if($payment_type == "CREDIT CARD"){
		
			$card_amt=$this->input->post('card_amt');
			$balance= $rounded_net_total - ($amount_paid+$card_amt);
			
		}else if($payment_type == "CHEQUE"){
		
			$checque_amt=$this->input->post('checque_amt');
			$balance= $rounded_net_total - ($amount_paid+$checque_amt);
			
		}else if($payment_type == "UPI"){
		
			$upi_amt=$this->input->post('upi_amt');
			$balance= $rounded_net_total - ($amount_paid+$card_amt+$upi_amt);
			
		}else {
		
			
			$balance= $rounded_net_total - ($amount_paid);
		}
	
		if($paction == "Update"){
	       	$status=0;
			$result=$this->invoice_model->update_DraftBill($balance,$auth_user_id,$status);
		
			
		}else{

			$result=$this->invoice_model->add_DraftBill($balance,$auth_user_id);
		}
		
		if($result > 0 ) {


			$bill_id=$result;
			
			$itemcount=$this->input->post('item_count');
			if($itemcount > 0 ){

			 $this->invoice_model->delete_invoice_draft_items($bill_id,'');
				for($i=0;$i<$itemcount;$i++){
					 if($item_loc!="" && $item_loc == $i){
			  	
			      //Request to remove the item
			      //So  Exclude the item 
			      //remove item from batchidinfo session
                  $batchidInfo = $this->session->userdata('batchidInfo');
			      unset($batchidInfo[$item_loc]);
                  $this->session->set_userdata('batchidInfo', $batchidInfo);

			  }else{
			
					$item=$this->input->post('item');

					$this->invoice_model->add_DraftBillItems($item[$i],$bill_id);

					$branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$item[$i][18],'pharma_batch');

					$invoice_mode=$item[$i][1];

					$new_batch_qty=$item[$i][6];

					if($invoice_mode=="Sales"){

					 // $new_batch_qty=-($new_batch_qty);
					  $invoice_mode_info="INVOICE_SALES";

					}else $invoice_mode_info="INVOICE_RETURN";
                    
                                        $brand_id=$item[$i][0];
					$batch_id=$item[$i][18];

					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

				    $new_batch_stock=$batch_stock;
					
					if($new_batch_stock<0) $new_batch_stock=0;

					$this->batch_model->update_stock($batch_id,$new_batch_stock,$invoice_mode_info);

					if(!empty($branch_id)){

                                        $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }else{

                                    	$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }


/*... MM/YY format convert to DD-MM-YYYY ...*/

                    $expiry_field = $item[$i][4];
  //                   $expiry_field = str_replace('/', '-', $expiry_field);
  //                   $newDate = explode( "-" , $expiry_field);
  //                   $output = $newDate[1]."-".$newDate[0]."-".'1';
  //                   // $output = '1'."-".$newDate[0]."-".$newDate[1];
  //                   // $item[$i][3]=date("t-m-Y", strtotime($output));

  //                   // $date = date_create_from_format('d-m-Y', $output);

  //       $year_obj = DateTime::createFromFormat('y', $newDate[1]);
  //       $year = $year_obj->format('Y');
  //       $month = $newDate[0];
  //       $date = "1";

  //       $s = $date."/".$month."/".$year;
		// $date = date_create_from_format('d/m/Y', $s);
		// $output = $date->format('Y-m-t');
		// $item[$i][4] = $output;
	

			/*... MM/YY format convert to DD-MM-YYYY ...*/




                        //add draftinfo 
			
			               $info['brand_id']=$brand_id;
			               $info['batch_id']=$batch_id;
			               $info['type']=$item[$i][5];
			               $info['quantity']= $new_batch_qty;
			               $info['old_stock_batch']=$batch_stock;
			               $info['new_stock_batch']=$new_batch_stock;
			               $info['old_stock_brand']=$brand_stock;
			               $info['new_stock_brand']=$new_brand_stock;
			               $info['action']="ADD";
			               $info['mode']=$invoice_mode_info;
			               $info['reference_id']=$bill_id;//bill id
			               $info['expiry_date']=$expiry_field;
			               $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			               $info['branch_id']=$branch_id;
			               $info['old_stock_branch']=$branch_stock;
			               $info['new_stock_branch']=$new_branch_stock;
			               $info['brand_name']=$item[$i][2];


			               $info['batch_number']=$item[$i][3];
			
			               $this->item_history_model->add_history($info);


			    }
           }



			    $ip_medicines_id=$this->input->post('ip_medicines_id');

			    if (!empty($ip_medicines_id)) {
			    	
			    	$ip_medicines_id = explode(",", $ip_medicines_id);

			    	for ($i=0; $i <count($ip_medicines_id) ; $i++) { 
			    		
			    		//$this->invoice_model->update_ip_prescribed($ip_medicines_id[$i],$bill_id);

			    	}

			    }

			    $op_medicines_id=$this->input->post('op_medicines_id');

			    if (!empty($op_medicines_id)) {
			    	
			    	$op_medicines_id = explode(",", $op_medicines_id);

			    	for ($i=0; $i <count($op_medicines_id) ; $i++) {
						
			    		//$status=2;
			    		//$this->invoice_model->update_op_prescribed_drafted($op_medicines_id[$i]);

			    	}

			    }




			} 
			  
			redirect('invoice/draft_invoice');
		}
	}


	function draft_invoice($next_page = null){

		//load model info
		$this->load->model('invoice_model');
  
        $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$bill_no=$this->input->post("bill_no");
		$payment_type=$this->input->post("payment_type");

		$customer_type=$this->input->post("customer_type");

		$patient_id=$this->input->post("patient_id");

		$bill_status=$this->input->post("bill_status");

		$bill_no=$this->input->post("bill_no");

		$current_page=$this->input->post("current_page");



		$message='';


		if(!empty($from_date)){
			$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))." 00:00:00'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}

        if(!empty($end_date)){
			$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))." 23:59:59'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}

		if(!empty($customer_type) && $customer_type == "OP"){
		
		  $search[] = "cust_type = '".$customer_type."'";
		  $data['cust_type_select']=$customer_type;
          $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		  if($patient_id!=""){

		  	$search[] = "op_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; OP No : ".$patient_id;

		  }
		  

		}elseif(!empty($customer_type) && $customer_type == "IP"){
		
		  $search[] = "cust_type = '".$customer_type."'";
		  $data['cust_type_select']=$customer_type;
          $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;

		  if($patient_id!=""){

		  	$search[] = "ip_no = '".$patient_id."'";
		  	$data['patient_id']=$patient_id;
            $message .="&nbsp;&nbsp;&nbsp;&nbsp; IP No : ".$patient_id;

		  }
		  

		}elseif(!empty($customer_type) && $customer_type == "DIRECT"){

		  $search[] = "cust_type = '".$customer_type."'";
		  $message .="&nbsp;&nbsp;&nbsp;&nbsp; Customer Type : ".$customer_type;
		  $data['cust_type_select']=$customer_type;
		}

		if(!empty($bill_no)){
			$search[] = "id = ".$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
			$data['bill_no']=$bill_no;
		}

		if(!empty($payment_type)){
			$search[] = "payment_mode = '".$payment_type."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
			$data['payment_type_select']=$payment_type;
		}



		if(empty($search)){

            $search[] = "bill_date >= '".date("Y-m-d")." 00:00:00'";
              
            $search[] = "bill_date <= '".date("Y-m-d")." 23:59:59'";

		}


		if($bill_status == 'CANCELLED'){
		
			$search[] ="status = 1";
			$data['bill_status']=1;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Cancelled Bill";
		}


	    if(empty($bill_status) || $bill_status == 'ACTIVE'){

		    $search[] ="status = 0";
		}

		$data['message']=$message;

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

       

		$invoice_count=$this->invoice_model->getInvoice_draft_Count($search);

	        $data['daft_billInfo']=$daft_billInfo=$this->invoice_model->search_DraftBill($search,'',$limit);

	        $data['pagination_link']=printPageLinks($invoice_count,$current_page,$perPage);
     
                $data['current_page']=$current_page;

/*... pagination end ...*/

		$this->load->view('invoice/draft_invoice',$data);
	}

 public function show_drafted_item(){

        //load model
	    	$this->load->model('invoice_model');
	    	 $item=$this->input->post('item');
   
	        $invoice_id=$this->input->post('bill_id');
        
	        $data['invoice_id']=$invoice_id;
	        $data['bill_status']=$bill_status=$this->input->post('bill_status'); 
    
              // $batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				//$item[$i][10]=$batch_stock;
 
		//gst model
		$this->load->model('gst_model');
		$search_gst[]="status = 0";
		$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


		$criteria[0] = "id = ".$invoice_id;
		$criteria[1]="status= 0";
		$draftInfo=$this->invoice_model->search_DraftBill($criteria);

		if(!empty($draftInfo)){



                $itemcount=$this->input->post('item_count');
		$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
		if($itemcount==null) $this->session->unset_userdata('batchidInfo');
		$item_loc=$this->input->post('item_loc');
		$select_batch=$this->input->post('select_batch_position');

                $data['paction']=$this->input->post('paction');
		$data['billid']=$draftInfo[0][1];
		$data['customer_type_select']=$customer_type_select=$draftInfo[0][2];
	
	         $data['op_no']=$op_no=$draftInfo[0][34];
	         $data['op_id']=$op_id=$draftInfo[0][3];
	          $data['ip_no']=$ip_no=$draftInfo[0][33];
      
		$data['customer_name']=$draftInfo[0][4];
		$data['doctor']=$draftInfo[0][30];
		$data['doc_id']=$draftInfo[0][48];


		$data['payment_type_selected']=$draftInfo[0][15];
		$data['checque_no']=$draftInfo[0][16];
		$data['checque_amt']=$draftInfo[0][17];
		$data['card_amt']=$draftInfo[0][18];

		$sales_mode_selected=$draftInfo[0][37];
		

		$data['ip_medicines_id']=$this->input->post('ip_medicines_id');

		$data['op_medicines_id']=$this->input->post('op_medicines_id');

		if(empty($sales_mode_selected)){

			$data['sales_mode_selected']=$draftInfo[0][37];;

		}else{

            $data['sales_mode_selected']=$sales_mode_selected;

		}



		    $data['sales_amt']=$draftInfo[0][6];
		    $data['tot_gst']=$draftInfo[0][23];
		    $data['tot_cgst']=$draftInfo[0][45];
		    $data['tot_sgst']=$draftInfo[0][46];
		     $data['tot_flood_cess']=$draftInfo[0][49];

		    $data['discount_type']=$draftInfo[0][11];
		    $data['discount_value']=empty($draftInfo[0][12])?'':$draftInfo[0][12];

		    $discount_amt=$draftInfo[0][13];
            $data['discount_amt']=to_currency($discount_amt);
		    $data['total_bill']=$draftInfo[0][10];
		    $data['net_total']=$draftInfo[0][41];
		    $data['net_amt']=$draftInfo[0][10];
		    $data['roundstatus']=$draftInfo[0][40];
		    $data['round_net_amt']=$draftInfo[0][20];
		    $data['round_amt']=$draftInfo[0][42];
		    $data['bill_date']=date('d-m-Y');
		    $data['payment_type_selected']=$draftInfo[0][18];
		    $data['checque_no']='';//empty($draftInfo[0][19])?'':$draftInfo[0][19];
		    $data['checque_amt']='';//empty($draftInfo[0][20])?'':$draftInfo[0][20];
		    $data['card_amt']='';//empty($draftInfo[0][21])?'':$draftInfo[0][21];
		    $data['remarks']=empty($draftInfo[0][26])?'':$draftInfo[0][26];
		    $data['paction']='Update';

		    $data['item_focus_select']='';

		    $data['itemfocus']='';
		    $bill_date='';
		    $data['free_bill']=$draftInfo[0][50];
		    $data['payment_status']=$draftInfo[0][51];

			
		}
	//	var_dump($draftInfo);exit();
		$criteria[0] = "bill_id = ".$invoice_id;
		$criteria[1] = "status = 0";
		$draft_itemInfo=$this->invoice_model->search_DraftBillItems($criteria);
//	var_dump($draft_itemInfo);exit();
		if(!empty($draft_itemInfo)){
		
			for($i=0;$i<count($draft_itemInfo);$i++){

/*... YYYY-MM-DD format convert to MM/YY ...*/	
               if(($draft_itemInfo[$i][7] !='1970-01-01') && ($draft_itemInfo[$i][7] !='1970-01-31')){
					    $exp = DateTime::createFromFormat('Y-m-d', $draft_itemInfo[$i][7]);
					  
                     $expiry=$exp->format('m/y');
					  //$expiry=date('m/y',strtotime($itemInfo[$i][5]));
				}else{
				       $expiry='';
				     }	

				 
/*... YYYY-MM-DD format convert to MM/YY ...*/
              $qty=empty($draft_itemInfo[$i][9])?'':$draft_itemInfo[$i][9];
                  $bill_date= date('d-m-Y');
               
				$brand_id=$draft_itemInfo[$i][3];
				//$brand = $this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			    $generic_name = $this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');

			    $brand_name = $brand."(".$generic_name.")";
				$brand_name=empty($draft_itemInfo[$i][12])?'':$draft_itemInfo[$i][12].$generic_name;
				$batch=empty($draft_itemInfo[$i][6])?'':$draft_itemInfo[$i][6];
				$expiry_date= $draft_itemInfo[$i][7];
				$mrp=$draft_itemInfo[$i][20];

                $sellp=$draft_itemInfo[$i][10];
               $data['batch_id']= $batch_id=$draft_itemInfo[$i][4];
              
                $gst_per=empty($draft_itemInfo[$i][14])?'':$draft_itemInfo[$i][14];
                $cgst_per=empty($draft_itemInfo[$i][15])?'':$draft_itemInfo[$i][15];
                $sgst_per=empty($draft_itemInfo[$i][16])?'':$draft_itemInfo[$i][16];
                $gst_amt=empty($draft_itemInfo[$i][17])?'':$draft_itemInfo[$i][17];
                $cgst_amt=empty($draft_itemInfo[$i][24])?'':$draft_itemInfo[$i][24];
                $sgst_amt=empty($draft_itemInfo[$i][25])?'':$draft_itemInfo[$i][25];
                $gst_id=empty($draft_itemInfo[$i][21])?'':$draft_itemInfo[$i][21];
            $data['batch_stock']=$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
            $data['op_medicines_id']=$op_mid=$draft_itemInfo[$i][37];
 
           
				$total=empty($draft_itemInfo[$i][11])?'':$draft_itemInfo[$i][11];

				$hsn_no=$draft_itemInfo[$i][28];
				$flood_cess_amt=empty($draft_itemInfo[$i][38])?'':$draft_itemInfo[$i][38];
				$total_flood_cess=empty($draft_itemInfo[$i][39])?'':$draft_itemInfo[$i][39];

		        	$items_in_array[]=array($brand_id,"Sales",$brand_name,$batch,$expiry_date,'NOS',$qty,$mrp,$sellp,$total,0,$gst_id,$gst_per,$sgst_per,$cgst_per,$gst_amt,$sgst_amt,$cgst_amt,$batch_id,$hsn_no,'',$cgst_amt,$sgst_amt,$batch_stock,$flood_cess_amt,$total_flood_cess);
		    
		    }
	    } 


        
            /*....... prescribed medicines .......*/
  //           	$criterias[0] = "visit_id = ".$op_id;

		// $data['prescription_info'] = $prescription_info = $this->invoice_model->getPrescription($criterias);
		
//var_dump($prescription_info);exit();
        
  //       $presc_med = $this->input->post('med_presc');
  //    //   var_dump($presc_med);
		// if(!empty($presc_med)){
		// 	for ($i=0; $i<count($presc_med) ; $i++) { 

		// 		$id=$presc_med[$i];

		// 		$brand = $this->commonDBFunctions->getidToValue('brand','id',$presc_med[$i],'hcare_pharma_brand');
		// 	    $generic_name = $this->commonDBFunctions->getidToValue('generic_name','id',$presc_med[$i],'hcare_pharma_brand');

		// 	    $brand_name = $brand."(".$generic_name.")";

		// 	    $selling_unit=$this->commonDBFunctions->getidToValue('selling_unit','id',$presc_med[$i],'hcare_pharma_brand');

		// 	    $mrp=$this->commonDBFunctions->getidToValue('sellp','id',$presc_med[$i],'hcare_pharma_brand');

		// 	    // hsn no
  //               $hsn_no=$this->commonDBFunctions->getidToValue('hsn_no','id',$id,'pharma_brand');

		// 		$items_in_array[]=array($id,"Sales",$brand_name,'','',$selling_unit,'',$mrp,'',0,'','','','','','','','','',$hsn_no,'','','','');
                
  //   	   }
		// }        
        
/*....... prescribed medicines .......*/




















	    $data['items_in_array']=$items_in_array;
		$data['itemcount']=count($items_in_array);


		$data['draft']="YES";
		$data['refresh_data']="refresh_data";
		$data['draft_batch_id']=$batch_id;

		//draft invoice to invoice form view
		$this->load->view('invoice/invoice_form',$data);

	}

	  public function delete_draft($id){

    	//load model info
		$this->load->model('invoice_model');
	
		$cancellation_details=$this->input->post("cancellation_details");
	        $status=1;
		$this->invoice_model->delete_invoice_draft_items($id,$status);
		$this->invoice_model->delete_invoice_draft($id,$cancellation_details);

		$this->session->set_flashdata('delete_msg', 'Deleted Successfully!');

		redirect("invoice/draft_invoice", 'refresh');
		
	}

	public function delete_invoice_draft_items($id){

		//load model info
		$this->load->model('invoice_model');
		$this->load->model('brand_model');
		$this->load->model('batch_model');
		$this->load->model('item_history_model');
	
		$search[] = "bill_id = ".$id;
		$itemInfo=$this->invoice_model->search_DraftBillItems($search);
		
		if(!empty($itemInfo)){
		
		  for($i=0;$i<count($itemInfo);$i++){

                                       $branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$itemInfo[$i][4],'pharma_batch');

					$invoice_mode=$itemInfo[$i][5];

					$new_batch_qty=$itemInfo[$i][9];

					if($invoice_mode=="Return"){

					  $new_batch_qty=-($new_batch_qty);
					  $invoice_mode_info="INVOICE_RETURN_CANCEL";

					}else $invoice_mode_info="INVOICE_CANCEL";
                    
                                        $brand_id=$itemInfo[$i][3];
					$batch_id=$itemInfo[$i][4];

					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

				     $new_batch_stock=$batch_stock+$new_batch_qty;
					
					if($new_batch_stock<0) $new_batch_stock=0;

					$this->batch_model->update_stock($batch_id,$new_batch_stock,$invoice_mode_info);

					if(!empty($branch_id)){

                                        $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }else{

                        $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				        $branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

				        $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					    $this->brand_model->update_stock($brand_id,$new_brand_stock);
				        $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

                    }

                        //add info to history
			
			               $info['brand_id']=$brand_id;
			               $info['batch_id']=$batch_id;
			               $info['type']=$itemInfo[$i][8];
			               $info['quantity']= $new_batch_qty;
			               $info['old_stock_batch']=$batch_stock;
			               $info['new_stock_batch']=$new_batch_stock;
			               $info['old_stock_brand']=$brand_stock;
			               $info['new_stock_brand']=$new_brand_stock;
			               $info['action']="DELETE";
			               $info['mode']=$invoice_mode_info;
			               $info['reference_id']=$id;//bill id
			               $info['expiry_date']=$itemInfo[$i][7];
			               $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			               $info['branch_id']=$branch_id;
			               $info['old_stock_branch']=$branch_stock;
			               $info['new_stock_branch']=$new_branch_stock;

                           $brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
	                       $batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			               $info['brand_name']=$brand_name;
			               $info['batch_number']=$batch_name;
			
			               $this->item_history_model->add_history($info);

		  }

		}
          $status=1;
        $this->invoice_model->delete_invoice_draft_items($id);
	}




	public function update_invoice(){

        //load model
    	$this->load->model('invoice_model');
    	 $item=$this->input->post('item');
         $user_id   		= $this->session->userdata('user_id');
        $invoice_id=$this->input->post('bill_id');
        
        $data['invoice_id']=$invoice_id;
    
              // $batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
				//$item[$i][10]=$batch_stock;
 
		//gst model
		$this->load->model('gst_model');
		$search_gst[]="status = 0";
		$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


		$criteria[0] = "id = ".$invoice_id;
		$criteria[1]="status= 0";
		$itemInfo=$this->invoice_model->searchBill($criteria);

		if(!empty($itemInfo)){



          $itemcount=$this->input->post('item_count');
		$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
		if($itemcount==null) $this->session->unset_userdata('batchidInfo');
		$item_loc=$this->input->post('item_loc');
		$select_batch=$this->input->post('select_batch_position');

        $data['paction']=$this->input->post('paction');
		$data['billid']=$itemInfo[0][1];
		$data['customer_type_select']=$customer_type_select=$itemInfo[0][2];
	
         $data['op_no']=$op_no=$itemInfo[0][34];
         $data['op_id']=$op_id=$itemInfo[0][3];
      
		if ($itemInfo[0][2]=="IP") {
			$data['ip_no'] = $itemInfo[0][33];
		}
      
		$data['customer_name']=$itemInfo[0][4];
		$data['doctor']=$itemInfo[0][30];
		$data['doc_id']=$itemInfo[0][48];


		$data['payment_type_selected']=$itemInfo[0][15];
		$data['checque_no']=$itemInfo[0][16];
		$data['checque_amt']=$itemInfo[0][17];
		$data['card_amt']=$itemInfo[0][18];
		$data['amt_paid']=$itemInfo[0][19];

		$sales_mode_selected=$itemInfo[0][37];


		$data['ip_medicines_id']=$this->input->post('ip_medicines_id');

		$data['op_medicines_id']=$this->input->post('op_medicines_id');

		if(empty($sales_mode_selected)){

			$data['sales_mode_selected']=$itemInfo[0][37];;

		}else{

            $data['sales_mode_selected']=$sales_mode_selected;

		}



			$data['sales_amt']=$itemInfo[0][6];
		    $data['tot_gst']=$itemInfo[0][23];
		    $data['tot_cgst']=$itemInfo[0][45];
		    $data['tot_sgst']=$itemInfo[0][46];
		    $data['tot_flood_cess']=$itemInfo[0][54];
		    if($itemInfo[0][59] ==1 ){
		     $data['discount_type']='%';
		    $data['discount_value']='100';
		    }else{
		    $data['discount_type']=$itemInfo[0][11];
		    $data['discount_value']=empty($itemInfo[0][12])?'':$itemInfo[0][12];
		    }

		   

		    $discount_amt=$itemInfo[0][13];
            $data['discount_amt']=to_currency($discount_amt);
		    $data['total_bill']=$itemInfo[0][10];
		    $data['net_total']=$itemInfo[0][41];
		    $data['net_amt']=$itemInfo[0][10];
		    $data['roundstatus']=$itemInfo[0][40];
		    $data['round_net_amt']=$itemInfo[0][20];
		    $data['round_amt']=$itemInfo[0][42];
		    $data['bill_date']=date('d-m-Y');
		    $data['payment_type_selected']=$itemInfo[0][15];
		    $data['checque_no']=empty($itemInfo[0][16])?'':$itemInfo[0][16];
		    $data['checque_amt']=empty($itemInfo[0][17])?'':$itemInfo[0][17];
		    $data['card_amt']=empty($itemInfo[0][18])?'':$itemInfo[0][18];
            $data['amt_paid']=empty($itemInfo[0][19])?'':$itemInfo[0][19];

		    $data['remarks']=empty($itemInfo[0][26])?'':$itemInfo[0][26];
		    $data['paction']='Update';

		    $data['item_focus_select']='';

		    $data['itemfocus']='';
		    $bill_date='';
		    $data['invoice_no']=$itemInfo[0][36];

		    $data['invoice_bill_date']=date("Y-m-d",strtotime($itemInfo[0][5]));
		    $data['free_bill']=$itemInfo[0][59];
		    $data['payment_status']=$itemInfo[0][60];
			
		}
		
		$criteria[0] = "bill_id = ".$invoice_id;
		$criteria[1] = "status = 0";
		$invoice_itemInfo=$this->invoice_model->searchBillItems($criteria);
  
		if(!empty($invoice_itemInfo)){
		
			for($i=0;$i<count($invoice_itemInfo);$i++){

/*... YYYY-MM-DD format convert to MM/YY ...*/	
               if(($invoice_itemInfo[$i][7] !='1970-01-01') && ($invoice_itemInfo[$i][7] !='1970-01-31')){
					    $exp = DateTime::createFromFormat('Y-m-d', $invoice_itemInfo[$i][7]);
                        $expiry=$exp->format('m/y');
					  //$expiry=date('m/y',strtotime($itemInfo[$i][5]));
				}else{
				       $expiry='';
				     }	

				 
/*... YYYY-MM-DD format convert to MM/YY ...*/
              $qty=empty($invoice_itemInfo[$i][9])?'':$invoice_itemInfo[$i][9];
                  $bill_date= date('d-m-Y');
               
				$brand_id=$invoice_itemInfo[$i][3];
				$brand_name=empty($invoice_itemInfo[$i][12])?'':$invoice_itemInfo[$i][12];
				$batch=empty($invoice_itemInfo[$i][6])?'':$invoice_itemInfo[$i][6];
				$expiry_date= $invoice_itemInfo[$i][7];
				$mrp=$invoice_itemInfo[$i][20];

                $sellp=$invoice_itemInfo[$i][10];
               $data['batch_id']= $batch_id=$invoice_itemInfo[$i][4];
                $gst_per=empty($invoice_itemInfo[$i][14])?'':$invoice_itemInfo[$i][14];
                $cgst_per=empty($invoice_itemInfo[$i][15])?'':$invoice_itemInfo[$i][15];
                $sgst_per=empty($invoice_itemInfo[$i][16])?'':$invoice_itemInfo[$i][16];
                $gst_amt=empty($invoice_itemInfo[$i][17])?'':$invoice_itemInfo[$i][17];
                $cgst_amt=empty($invoice_itemInfo[$i][18])?'':$invoice_itemInfo[$i][18];
                $sgst_amt=empty($invoice_itemInfo[$i][19])?'':$invoice_itemInfo[$i][19];
                $gst_id=empty($invoice_itemInfo[$i][21])?'':$invoice_itemInfo[$i][21];
                $data['batch_stock']=$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
                 $flood_cess_amt=empty($invoice_itemInfo[$i][37])?'':$invoice_itemInfo[$i][37];
                 $total_flood_cess=empty($invoice_itemInfo[$i][38])?'':$invoice_itemInfo[$i][38];

 
           
				$total=empty($invoice_itemInfo[$i][11])?'':$invoice_itemInfo[$i][11];

				$hsn_no=$invoice_itemInfo[$i][28];

				$data['return_billid']=$return_billid=$itemInfo[0][1];


				 $new_criteria[0] = "sales_mode= 'Sales'";
							$new_criteria[1] = "item_id= ".$brand_id;
							$new_criteria[2] = "bill_id= ".$return_billid;
							$new_criteria[3] = "status= 0";
		
                 $saled_qty=$this->commonDBFunctions->getidToValue_multiple('quantity',$new_criteria,'pharma_invoice_items');

                            $new_criteria1[0] = "sales_mode= 'Return'";
							$new_criteria1[1] = "item_id= ".$brand_id;
							$new_criteria1[2] = "return_billid= ".$return_billid;
							$new_criteria1[3] = "status= 0";
		
                 $return_qty=$this->commonDBFunctions->getidToValue_multiple('sum(quantity)',$new_criteria1,'pharma_invoice_items');

				$available_qty=$saled_qty-$return_qty;
				$data['draft_id']=$draft_id=$invoice_itemInfo[$i][39];

		        	$items_in_array[]=array($brand_id,"Sales",$brand_name,$batch,$expiry_date,'NOS',$qty,$mrp,$sellp,$total,0,$gst_id,$gst_per,$sgst_per,$cgst_per,$gst_amt,$sgst_amt,$cgst_amt,$batch_id,$hsn_no,'',$cgst_amt,$sgst_amt,$batch_stock,$flood_cess_amt,$total_flood_cess,$saled_qty,$return_qty,$available_qty);

		  	
		    }

	    } 
        
	    $data['items_in_array']=$items_in_array;
		$data['itemcount']=count($items_in_array);
		// var_dump($items_in_array);exit;

	
		$data['refresh_data']="refresh_data";

		$data['edit_status']="EDIT";
	
		$data['draft_batch_id']=$batch_id;

         
		$criteria[0] = "bill_no = ".$invoice_id;
		$criteria[1] = "status = 0";
		$data['invoice_Credit_Info']=$invoice_Credit_Info=$this->invoice_model->getCreditPayment($criteria);
           
        if (!empty($invoice_Credit_Info)) {
        	
		$this->session->set_flashdata('delete_msg', 'Credit already payed. Cant edit!');

		redirect("invoice/manage_invoice", 'refresh');


        }
 
		//invoice to invoice form view
		$this->load->view('invoice/invoice_form',$data);

	}
	public function patient_details()
	{
		
		$this->load->model('hcare_model');

		$search_from = $this->input->post('search_from');

		$ref_no_search = $this->input->post('ref_no_search');

		$sales_mode = $this->input->post('sales_mode_selected');

		$customer_type = $this->input->post('customer_type');

		$selectCondition=array();

		if ($search_from=="op_patient" && $customer_type=="OP") {

			
			if(!empty($ref_no_search)){	

				$selectCondition[]="a.`id` ='".$ref_no_search."'";

				if ($sales_mode!="Return") {
					$selectCondition[]="b.`visit_date` like '".date("Y-m-d")."%'";
				}

			
			}

			$patientInfo=$this->hcare_model->getOPPatientInfo($selectCondition);

			if (!empty($patientInfo)) {
					
				$id = $patientInfo[0][13];
				$no = $patientInfo[0][0];
				$cust_name = $patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];
				$customer_type = "OP";
				$doctor="DR. ".$patientInfo[0][15]." ".$patientInfo[0][16];
				$doc_id = $patientInfo[0][14];

			}

		}
		else if ($search_from=="ip_patient") {


			if(!empty($ref_no_search)){	


				

					$selectCondition[]="b.`id` ='".$ref_no_search."'";
					$selectCondition[]="(b.`cancelled` =0)";
					

				


				if ($sales_mode!="Return") {
	                // $selectCondition[]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date`='')";
			        // $selectCondition[]="(b.`bill_status` =0 or b.`bill_status`=3)";
			        $selectCondition[]="(b.`bill_status` != 1)";
				}



			
			}

			$patientInfo=$this->hcare_model->getIPPatientInfo($selectCondition);

			if (!empty($patientInfo)) {
					
				$id = '';
				$no = $patientInfo[0][13];
				$cust_name = $patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];
				$customer_type = "IP";
				$doctor="DR. ".$patientInfo[0][17]." ".$patientInfo[0][18];
				$doc_id = $patientInfo[0][16];

			}

		}

		echo ($id.":".$no.":".$cust_name.":".$customer_type.":".$doctor.":".$doc_id);



	}
	public function saveOp($value='')
	{

		$op_payment = $this->input->post('op_payment');

		if (!empty($op_payment)) {
			$this->load->model('hcare_model');
			$this->hcare_model->updateOpPayment();
		}

		redirect('invoice/invoice_form');

	}
 
	public function get_doctor_prescription_ip($ip_no=null,$item_count=null){

        //load model
		$this->load->model('invoice_model');
        $criteria = array();
        $doctor_prescr_date_list = array();
        $doctor_prescr_unique_date_list = array();

        $ipno = $this->input->post('ipno');
        $prescription_date = $this->input->post('prescription_date');

        if(!empty($ip_no)){

          $ipno = $ip_no;

        }

     if(!empty($prescription_date)){	

        if(!empty($ipno)){

          $ip_no=$ipno;

        }

        $criteria[0] = "ipno = ".$ip_no;
        $criteria[1] = "date_time >= '".date("Y-m-d",strtotime($prescription_date))." 00:00:00'";
        $criteria[2] = "date_time <= '".date("Y-m-d",strtotime($prescription_date))." 23:59:59'";

        $prescription_info=$this->invoice_model->getDoctorPrescriptionIp($criteria);
		$tablerow ="";
		if(!empty($prescription_info)){
		   $j=1;
		   for($i=0;$i<count($prescription_info);$i++){

		   	 $tablerow.= "<tr>";
					
			 $tablerow.="<td>";
			 $tablerow.= $j++;
			 $tablerow.="</td>";

			 $tablerow.="<td>";
			 $tablerow.= !empty($prescription_info[$i][2])?$prescription_info[$i][16]:$prescription_info[$i][3];
			 $tablerow.="</td>";

			 $tablerow.="<td>";
			 $tablerow.= $prescription_info[$i][4];
			 $tablerow.="</td>";

			 $tablerow.="<td>";
			 $tablerow.= $prescription_info[$i][5];
			 $tablerow.="</td>";

			 $tablerow.="<td>";
			 $tablerow.= date('d-m-Y h:i A', strtotime($prescription_info[$i][6]));
			 $tablerow.="</td>";

			 if (!empty($prescription_info[$i][17])) {
				 $tablerow.="<td style='text-align: center;'>";
				 $tablerow.= "<label style='color:red;'>Solded</label>";
				 $tablerow.="</td>";
			 }
			 else{
				 $tablerow.="<td style='text-align: center;'>";
				 $tablerow.= "Not Solded";
				 $tablerow.="</td>";
			 	
			 }

			 if (!empty($prescription_info[$i][2])) {
				 $tablerow.="<td style='text-align: center;'>";
				 $tablerow.= "<input type='checkbox' name='select_medicines[]' id=".$prescription_info[$i][0]." class='select_medicines' class='selectone' value=".$prescription_info[$i][2].">";
				 $tablerow.="</td>";
			 }
			 else{
				 
			 	 // No Data
			 }

           }
        }

        $data['tableInfo']=$tablerow;
		echo json_encode($data);

     }else{
     
        $data['ip_no']=$ipno; 
 
		$data['item_count']=$item_count;

		$criteria[0] = "ipno = ".$ip_no;
		$doctor_prescription_info_all = $this->invoice_model->getDoctorPrescriptionIp($criteria,'a.`date_time`','desc');

		if(!empty($prescription_date)){

           $criteria[1] = "date_time >= '".date("Y-m-d",strtotime($prescription_date))." 00:00:00'";
           $criteria[2] = "date_time <= '".date("Y-m-d",strtotime($prescription_date))." 23:59:59'";

		}else{

           $criteria[1] = "date_time >= '".date("Y-m-d")." 00:00:00'";
              
           $criteria[2] = "date_time <= '".date("Y-m-d")." 23:59:59'";

		}

		$data['prescription_info'] = $prescription_info = $this->invoice_model->getDoctorPrescriptionIp($criteria);

		if (!empty($prescription_info)) {
			
			for ($j=0; $j < count($prescription_info); $j++) { 
				$prescribed_id[$j] = $prescription_info[$j][0];
			
			}
		}

		if (!empty($doctor_prescription_info_all)) {
			
			for ($k=0; $k < count($doctor_prescription_info_all); $k++) { 
				
				$doctor_prescr_date_list[$k] = date("d-m-Y",strtotime($doctor_prescription_info_all[$k][6]));
			}
		}
        
        $doctor_prescr_unique_date_list = array_unique($doctor_prescr_date_list);
        $data['doctor_presc_date'] = array_values($doctor_prescr_unique_date_list);
         
        $this->load->view('invoice/select_doctor_prescription_ip',$data);
     }

	}
	
}


