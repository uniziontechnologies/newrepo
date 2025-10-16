<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movement extends CI_Controller {
 
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	function movement_form()
	{
        
		//process data
		$data=$this->processMovementForm();

		$from_branch=$this->input->post('from');
		$to_branch=$this->input->post('to');
		
		$data['from_branch']=$from_branch;
		$data['to_branch']=$to_branch;

		if(!empty($from_branch)){

          $from_branch_name='Main Stock';
          if($from_branch !='main_stock'){

			$from_branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$from_branch,'hcare_pharma_branch');
		  }
		    	
			$data['from_branch_name']=$from_branch_name;
		}
				
		if(!empty($to_branch)){

		  $to_branch_name='Main Stock';
          if($to_branch !='main_stock'){

			 $to_branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$to_branch,'hcare_pharma_branch');
		  }

			$data['to_branch_name']=$to_branch_name;
		}
		 
		
		$data['paction']=isset($data['paction'])?$data['paction']:'Save';
		//$data['recid']=isset($data['recid'])?$data['recid']:'';
		$data['itemfocus']=$this->input->post('item_focus');
		 
		//branch info
		$this->load->model('branch');
		
	    $data['branchInfo']=$this->branch->getBranch(); 
		  
		 
		$data['error_message']='';//$error_message;
		  
		//movement form view
		$this->load->view('movement/movement_form',$data);
	}

	function processMovementForm(){

		//process form
		  
		$itemcount=$this->input->post('item_count');
		$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
		$item_loc=$this->input->post('item_loc');
		$items_in_array=array();

		$total_buyp=0;
        $total_sellp=0;

		if($itemcount > 0 ){
		                       
			for($i=0;$i<$itemcount;$i++){
		
		
			   if($item_loc!="" && $item_loc == $i){
				 //Request to remove the item
			    //So  Exclude the item 
			  }else{

			  	  $item=$this->input->post('item');

			  	  $total_item_buyp=$item[$i][6]*$item[$i][15];
			  	  $total_item_sellp=$item[$i][6]*$item[$i][16];

			  	  $total_buyp+=$total_item_buyp;
		          $total_sellp+=$total_item_sellp;

		          $item[$i][17]=$total_item_buyp;
		          $item[$i][18]=$total_item_sellp;

			  	  $items_in_array[]=array($item[$i][0],$item[$i][1],$item[$i][2],$item[$i][3],$item[$i][4],$item[$i][5],$item[$i][6],$item[$i][7],$item[$i][8],$item[$i][9],$item[$i][10],$item[$i][11],$item[$i][12],$item[$i][13],$item[$i][14],$item[$i][15],$item[$i][16],$item[$i][17],$item[$i][18]);

              }
			}
		}

		$data['total_buyp']=$total_buyp;
		$data['total_sellp']=$total_sellp;

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
/*....... gst details .......*/	

                $gst_id=$this->commonDBFunctions->getidToValue('gst_id','id',$batch_id,'pharma_batch');
                $gst_per=$this->commonDBFunctions->getidToValue('gst_per','id',$batch_id,'pharma_batch');
                $gst_amt=$this->commonDBFunctions->getidToValue('gst_amt','id',$batch_id,'pharma_batch');
                $sgst_amt=$this->commonDBFunctions->getidToValue('sgst_amt','id',$batch_id,'pharma_batch');
                $cgst_amt=$this->commonDBFunctions->getidToValue('cgst_amt','id',$batch_id,'pharma_batch');
                $sgst_per=$this->commonDBFunctions->getidToValue('sgst_per','id',$batch_id,'pharma_batch');
                $cgst_per=$this->commonDBFunctions->getidToValue('cgst_per','id',$batch_id,'pharma_batch');

/*..... sellp and buyp .....*/
                $buyp=$this->commonDBFunctions->getidToValue('buyp','id',$batch_id,'pharma_batch');
                $sellp=$this->commonDBFunctions->getidToValue('sellp','id',$batch_id,'pharma_batch');

		  	$items_in_array[]=array($id,$brand_name,$batch_name,$expiry_date,$selling_unit,$batch_stock,'',$gst_per,$gst_amt,$batch_id,$gst_id,$sgst_per,$cgst_per,$sgst_amt,$cgst_amt,$buyp,$sellp,'','');

		  }else{
                 if(empty($batch_id)) $data['message']="Invalid Batch Selected";
			     else $data['message']="Invalid Brand Selected";
           }
        }
        

        $data['items_in_array']=$items_in_array;
		$data['itemcount']=count($items_in_array);

		return $data;
	}

	public function add_movement(){

		//load model
		$this->load->model('movement_model');
		$this->load->model('batch_model');
		$this->load->model('brand_model');
		$this->load->model('item_history_model');

        $from=$this->input->post('from');
		$to=$this->input->post('to');
		$remarks=$this->input->post('remarks');
		
		$result=$this->movement_model->addMovement();

		if($result > 0 ) {
		
			$movement_id=$result;
			
			$itemcount=$this->input->post('item_count');
			
			$this->movement_model->id = $movement_id;
			
			if($itemcount > 0 ){
			
				for($i=0;$i<$itemcount;$i++){
			
					$item=$this->input->post('item');
					// var_dump($item);exit;
					
					$this->movement_model->addmovementItems($item[$i]);

					$brand_id=$item[$i][0];
					$brand_name=$item[$i][1];
					$batch_name=$item[$i][2];	
                    $new_batch_qty=$item[$i][6];

                    $batchInfo['brand_id']=$brand_id;
                    $batchInfo['batch_number']=$item[$i][2];
                    $batchInfo['expiry_date']=$item[$i][3];
                    $batchInfo['supplier_id']=$this->commonDBFunctions->getidToValue('supplier_id','id',$item[$i][9],'pharma_batch');
                    $batchInfo['batch_stock']=$new_batch_qty;

                    $batchInfo['price_type']=$this->commonDBFunctions->getidToValue('price_type','id',$item[$i][9],'pharma_batch');
					$batchInfo['sellp']=$this->commonDBFunctions->getidToValue('sellp','id',$item[$i][9],'pharma_batch');
					$batchInfo['buyp']=$this->commonDBFunctions->getidToValue('buyp','id',$item[$i][9],'pharma_batch');

					$batchInfo['description']='';
					$batchInfo['purchase_id']=$movement_id;

					if($to == "main_stock") $batchInfo['branch_id']="";//MOVEMENT TO
					else $batchInfo['branch_id']=$to;

/*................... gst details ................*/

                     $batchInfo['gst_per']=$item[$i][7];
                     $batchInfo['sgst_per']=$item[$i][11];
                     $batchInfo['cgst_per']=$item[$i][12];
                     $batchInfo['gst_amt']=$item[$i][8];
                     $batchInfo['sgst_amt']=$item[$i][13];
                     $batchInfo['cgst_amt']=$item[$i][14];
                     $batchInfo['gst_id']=$item[$i][10];

/*.................. gst details .................*/	
                    
                  if($from == "main_stock"){
					 //main stock to branch transaction
					 
					 //update main store batch qty
					  
				     $batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][9],'pharma_batch');
				     $new_stock_update=$batch_stock-$new_batch_qty;

				     $this->batch_model->update_stock($item[$i][9],$new_stock_update,"MOVEMENT_FROM".$movement_id);
                     
                     $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				     $new_brand_stock=$this->batch_model->getMainStock($brand_id);
					 
					 $this->brand_model->update_stock($brand_id,$new_brand_stock);

					 $branch_stock=$this->batch_model->getAllBranchStock($brand_id);

					 //add info to history for newly created batch 
			
			        $info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$item[$i][9];
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=$batch_stock;
			        $info['new_stock_batch']=$new_stock_update;
			        $info['old_stock_brand']=$brand_stock;
			        $info['new_stock_brand']=$new_brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_FROM_MAINSTORE";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$item[$i][9],'pharma_batch');
			        $info['branch_id']=0;//BRANCH_ID
			        $info['old_stock_branch']=$branch_stock;
			        $info['new_stock_branch']=$branch_stock;
			        $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;
			
			        $this->item_history_model->add_history($info);

			        //create new stock in selected branch
			        
					   
					$batch_id=$this->batch_model->create($batchInfo);

					//add status of purchase and movement  p and M
					$this->batch_model->Update_p_m_Status($batch_id,"M");
					   
					//update branch stock
					$new_branch_stock=$branch_stock+$new_batch_qty;
				    $this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');

				    //add info to history for newly created batch 
			
			        $info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$batch_id;
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=0;
			        $info['new_stock_batch']=$new_batch_qty;
			        $info['old_stock_brand']=$new_brand_stock;
			        $info['new_stock_brand']=$new_brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_TO_BRANCH";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			        $info['branch_id']=$batchInfo['branch_id'];//BRANCH_ID
			        $info['old_stock_branch']=$branch_stock;
			        $info['new_stock_branch']=$new_branch_stock;
			        $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;
			
			        $this->item_history_model->add_history($info);

				  }elseif($to == "main_stock"){

				  	//MOVEMENT FROM BRANCH TO MAINSTOCK
					  
					//UPDATE BRANCH STOCK
					  
					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][9],'pharma_batch');
				    $new_stock_update=$batch_stock-$new_batch_qty;
					$this->batch_model->update_stock($item[$i][9],$new_stock_update,"MOVEMENT_FROM".$movement_id);
					  
					$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
					$new_branch_stock=$branch_stock-$new_batch_qty;
					$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');
					  
					$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
						
						 //add info to history for newly created batch 
			
			        $info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$item[$i][9];
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=$batch_stock;
			        $info['new_stock_batch']=$new_stock_update;
			        $info['old_stock_brand']=$brand_stock;
			        $info['new_stock_brand']=$brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_FROM_BRANCH";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$item[$i][9],'pharma_batch');
			        $info['branch_id']=$batchInfo['branch_id'];//BRANCH_ID
			        $info['old_stock_branch']=$branch_stock;
			        $info['new_stock_branch']=$new_branch_stock;
			        $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;
			
			        $this->item_history_model->add_history($info);

			        //UPDATE MAIN STOCK
					//create new stock in selected branch
					   
					$batch_id=$this->batch_model->create($batchInfo);
					//add status of purchase and movement  p and M
					$this->batch_model->Update_p_m_Status($batch_id,"M");
					   
					$new_brand_stock=$brand_stock+$new_batch_qty;
					$this->brand_model->update_stock($brand_id,$new_brand_stock);
					   
					   //add info to history for newly created batch 
			
			        $info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$batch_id;
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=0;
			        $info['new_stock_batch']=$new_batch_qty;
			        $info['old_stock_brand']=$brand_stock;
			        $info['new_stock_brand']=$new_brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_TO_MAINSTOCK";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			        $info['branch_id']=0;//BRANCH_ID
			        $info['old_stock_branch']=$new_branch_stock;
			        $info['new_stock_branch']=$new_branch_stock;
			        $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;
			
			        $this->item_history_model->add_history($info);

				  }else{
                    
                    //MOVEMENT FROM BRANCH TO BRANCH
					  
					$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][9],'pharma_batch');
				    $new_stock_update=$batch_stock-$new_batch_qty;
					$this->batch_model->update_stock($item[$i][9],$new_stock_update,"MOVEMENT_FROM".$movement_id);
					   
					$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
					   
					$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

					   //add info to history for newly created batch 

					$info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$item[$i][9];
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=$batch_stock;
			        $info['new_stock_batch']=$new_stock_update;
			        $info['old_stock_brand']=$brand_stock;
			        $info['new_stock_brand']=$brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_FROM_BRANCH";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$item[$i][9],'pharma_batch');
			        $info['branch_id']=$from;//BRANCH_ID
			        $info['old_stock_branch']=$branch_stock;
			        $info['new_stock_branch']=$branch_stock; 
			        $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;

			        $this->item_history_model->add_history($info);
                    
                    //create new stock in selected branch
					   
					$batch_id=$this->batch_model->create($batchInfo);
					//add status of purchase and movement  p and M
					$this->batch_model->Update_p_m_Status($batch_id,"M");
					   
					$info['brand_id']=$batchInfo['brand_id'];
			        $info['batch_id']=$batch_id;
			        $info['type']=$batchInfo['price_type'];
			        $info['quantity']=$batchInfo['batch_stock'];
			        $info['old_stock_batch']=$batch_stock;
			        $info['new_stock_batch']=$new_stock_update;
			        $info['old_stock_brand']=$brand_stock;
			        $info['new_stock_brand']=$brand_stock;
			        $info['action']="ADD";
			        $info['mode']="MOVEMENT_TO_BRANCH";
			        $info['reference_id']=$batchInfo['purchase_id'];
			        $info['expiry_date']=$batchInfo['expiry_date'];
			        $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			        $info['branch_id']=$to;//BRANCH_ID
			        $info['old_stock_branch']=$branch_stock;
			        $info['new_stock_branch']=$branch_stock;   
				    $info['brand_name']=$brand_name;
			        $info['batch_number']=$batch_name;

			        $this->item_history_model->add_history($info);
				  }
				}
            }

                 // $this->printMovement($movement_id);
                    redirect('movement/printMovement/'.$movement_id);

        }
	}

	public function manage_movement(){
	
		//load model
		$this->load->model('movement_model');
        $this->load->model('branch');

        $data['branchInfo']=$this->branch->getBranch();
	    
	    $from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$from_branch=$this->input->post('from');
		$to_branch=$this->input->post('to');
		$bill_no=$this->input->post('bill_no');

		$current_page=$this->input->post("current_page");

		$message='';

		if(!empty($from_date)){
			$search[] = "movement_date >= '".date("Y-m-d",strtotime($from_date))."'";
			$data['from_date']=$from_date;
			$message .="From Date : ".$from_date;
		}
		
		if(!empty($end_date)){
			$search[] = "movement_date <= '".date("Y-m-d",strtotime($end_date))."'";
			$data['end_date']=$end_date;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
		}
		
		if(!empty($from_branch)){

		  $search[] = "move_from = '".$from_branch."'";
		  $data['from_branch']=$from_branch;

          $from_branch_name='Main Stock';
          if($from_branch !='main_stock'){

			$from_branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$from_branch,'hcare_pharma_branch');
		  }
		    	
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Move From : ".$from_branch_name;
		}
				
		if(!empty($to_branch)){

		  $search[] = "move_to = '".$to_branch."'";
		  $data['to_branch']=$to_branch;

		  $to_branch_name='Main Stock';
          if($to_branch !='main_stock'){

			 $to_branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$to_branch,'hcare_pharma_branch');
		  }

			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Move To : ".$to_branch_name;
		}

		if(!empty($bill_no)){
			$search[] = "id= ".$bill_no;
			$data['bill_no']=$bill_no;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill NO : ".$bill_no;
		}

		if(empty($search)){

		    $search[] = "movement_date >= '".date("Y-m-d")."'";
		   
		    $search[] = "movement_date <= '".date("Y-m-d")."'";

		}
         
	    $search[] = "status = '0'";

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

        $movement_count=$this->movement_model->getMovementCount($search);
       
	    $data['movementInfo']=$this->movement_model->searchMovement($search,'',$limit);

	    $data['pagination_link']=printPageLinks($movement_count,$current_page,$perPage);
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
		
		$this->load->view('movement/manage_movement',$data);
	}

	function printMovement($movement_id = null,$popup_path=null){

		//load model
		$this->load->model('movement_model');
		$this->load->model('admin_model');
	
	    if(empty($movement_id)){

            $movement_id=$this->input->post("move_id");
        }

        $from_path = $this->input->post("from_path");

		if (!empty($from_path) || !empty($popup_path)) {

			$data['from_path'] = $from_path;
			$cancelled = "cancelled";
			$criteria[0] = "id = ".$movement_id;
			$data['movement_info']=$this->movement_model->searchMovement($criteria,$cancelled);
			
			$criteria[0] = "movement_id = ".$movement_id;
			$data['movement_item_Info']=$this->movement_model->searchMovementItems($criteria,$cancelled);
		}
		else{

			$criteria[0] = "id = ".$movement_id;
			$data['movement_info']=$this->movement_model->searchMovement($criteria);
			
			$criteria[0] = "movement_id = ".$movement_id;
			$data['movement_item_Info']=$this->movement_model->searchMovementItems($criteria);

		}

		$data['hospitalInfo']=$this->admin_model->getHospitalInfo();
		$data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();

		

		if (!empty($popup_path)) {
			$data['popup_path'] = $popup_path;
		}
		
		$this->load->view('movement/print_movement',$data);
	}

	function movement_item_delete(){

        //load model
		$this->load->model('movement_model');
		$this->load->model('batch_model');

        $movement_id=$this->input->post("move_id");

        $criteria[0] = "id = ".$movement_id;
		$data['movement_info']=$this->movement_model->searchMovement($criteria);
		
		$criteria[0] = "movement_id = ".$movement_id;
		$data['movement_item_Info']=$movement_item_Info=$this->movement_model->searchMovementItems($criteria);

/* if moved item is sell */
       
        if(!empty($movement_item_Info)){

            for($i=0; $i<count($movement_item_Info); $i++) { 
                
                 $batch_name=$movement_item_Info[$i][4];
                 $brand_id=$movement_item_Info[$i][2];
                 $expiry=$movement_item_Info[$i][5];
                 $batchid=$movement_item_Info[$i][3];

                 $batch_stock=$this->batch_model->checkBatchChange($movement_id,$brand_id,$batch_name,$expiry,$batchid);
                 
                 if(!empty($batch_stock) && ($batch_stock<$movement_item_Info[$i][7])){

                    $data['batch_stock_error'][$i]='Qty Mismatch';
                    $data['batch_stock_change']="YES";
                    $this->session->set_flashdata('stock_mismatch_error', 'Unable to Cancel Movement!');
                    
                 }
            }
                 
        } 

/* if moved item is sell */
        
        $this->load->view('movement/movement_item_delete',$data);
	}

	function delete(){

       //load model
	   $this->load->model('movement_model');
	   $this->load->model('batch_model');
	   $this->load->model('brand_model');
	   $this->load->model('item_history_model');

       $movement_id=$this->input->post('move_id');
       $criteria[0] = "movement_id = ".$movement_id;
	   $criteria[1] = "status = 0";
	   $itemInfo=$this->movement_model->searchMovementItems($criteria);

	  if(!empty($itemInfo)){
		
	    for($i=0;$i<count($itemInfo);$i++){

          $batchInfo['brand_id']=$itemInfo[$i][2];//brand_id
	      $batchInfo['batch_number']=$itemInfo[$i][4];//batch_number
	      $batchInfo['expiry']=$itemInfo[$i][5];//expiry
	      $expiry=$itemInfo[$i][5];//expiry
          $quantity=$itemInfo[$i][7];

	      $exist=$this->batch_model->checkbatchExist($batchInfo,$movement_id);

	      if(!empty($exist)){  

             $batch_id=$exist['id']; 
             $old_stock_batch=$exist['batch_stock'];
             $qty=-($exist['batch_stock']);
             $new_stock_batch=$old_stock_batch-$quantity;

	         $this->batch_model->delete_current_batch_items('',$batch_id,$new_stock_batch,'M');
             
             $old_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$itemInfo[$i][3],'pharma_batch');

             $new_stock=$old_stock+$old_stock_batch;
             $delete_history="MOVEMENT_CANCEL";

	         $this->batch_model->update_stock($itemInfo[$i][3],$new_stock,$delete_history);

	         $brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$batchInfo['brand_id'],'pharma_brand');
			
		     $new_brand_stock=$this->batch_model->getMainStock($batchInfo['brand_id']);

		     $this->brand_model->update_stock($batchInfo['brand_id'],$new_brand_stock);
 
            //branch updation
             $branch_stock=$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$batchInfo['brand_id'],'pharma_brand');

		     $new_branch_stock=$this->batch_model->getAllBranchStock($batchInfo['brand_id']);

		     $this->brand_model->update_stock($batchInfo['brand_id'],$new_branch_stock,'','','','branch');


	         $info['brand_id']=$batchInfo['brand_id'];
	         $info['batch_id']=$batch_id;
	         $info['type']=$itemInfo[$i][6];
             $info['quantity']= $qty;
	         $info['old_stock_batch']=$old_stock_batch;
	         $info['new_stock_batch']=$new_stock_batch;
	         $info['old_stock_brand']=$brand_stock;
	         $info['new_stock_brand']=$new_brand_stock;
	         $info['action']="CANCEL";
	         $info['mode']="MOVEMENT_CANCEL";
	         $info['reference_id']=$movement_id;
	         $info['expiry_date']=$expiry;
	         $info['new_expiry_date' ]=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
	         $info['branch_id']=0;//branch id
	         $info['old_stock_branch']=$branch_stock;
	         $info['new_stock_branch']=$new_branch_stock;
	         $brand_name=$this->commonDBFunctions->getidToValue('brand','id',$batchInfo['brand_id'],'pharma_brand');
	         $batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			
	         $info['brand_name']=$brand_name;
	         $info['batch_number']=$batch_name;

	         $this->item_history_model->add_history($info);
	      }
	    }
	  }

             $this->movement_model->delete_movement($movement_id);
		     $this->movement_model->delete_movement_items($movement_id);
		
		redirect("movement/manage_movement", 'refresh');	

    }    
	function select_batch($brand_id,$branch_id){

		//load model
		$this->load->model('batch_model');

    	$data['brand_id'] = $brand_id;
		
		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;				
		$search[1]="expiry_date >'".$newDate."'";
		$search[2]="batch_stock >0";

		if($branch_id !="main_stock"){
			$search[3]="branch_id = '".$branch_id."'";	
		}else{
			$search[3]="(branch_id = '' or branch_id=0)";
		}
		
		$data['batch']=$this->batch_model->getBatch($search);
		

		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
		$data['brand_name']=$brand_name."(".$generic_name.")";
		$data['shelf_number']=$shelf_number;
		
		$this->load->view('movement/select_batch',$data);

    }


}


