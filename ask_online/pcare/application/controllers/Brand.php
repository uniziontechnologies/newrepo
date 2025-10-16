<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller {

  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	function manageBrand($next_page= null,$current_page=null,$status=null){
		// echo $current_page;exit;

		$this->load->model('brand_model');
		if(empty($current_page)){

		$current_page=$this->input->post("current_page");
	}

/*.......Brand Searching .......*/

		$list_brand_by_select=$this->input->post('list_brand_by');

		if(!empty($list_brand_by_select) && ($list_brand_by_select=='BRAND')){

           $data['list_brand_by_select']=$list_brand_by_select;

		}elseif(!empty($list_brand_by_select) && ($list_brand_by_select=='GENERIC NAME')){

           $data['list_brand_by_select']=$list_brand_by_select;
			
		}elseif(!empty($list_brand_by_select) && ($list_brand_by_select=='MANUFACTURER')){

           $data['list_brand_by_select']=$list_brand_by_select;
			
		}

		$brand_name=$this->input->post('brand_name_search');
		$manufacturer_name=$this->input->post('manufacturer_name');
		$generic_name=$this->input->post('generic_name_search');
		$category=$this->input->post('category_search');
		
		$search_by=$this->input->post('search_by');
		$message='';
		$k=0;
		$search=array();
		
		if(!empty($brand_name)){
		
			
			$data['brand_name']=$brand_name;
			
			$search[$k++]="brand like '".$brand_name."%'";
			$message .="Brand Name : ".$brand_name;
			
		}else if(!empty($manufacturer_name)){
		
			
			$data['manufacturer_name']=$manufacturer_name;
			
			$search[$k++]="manufacturer like '".$manufacturer_name."%'";
			$message .="Manufacturer : ".$manufacturer_name;
			
		}else if(!empty($generic_name)){
		
			
			$data['generic_name']=$generic_name;
			
			$search[$k++]="generic_name like '%".$generic_name."%'";
			$message .="Generic Name : ".$generic_name;
			
		}else if(!empty($search_by) && ($search_by == "LOW INVENTORY")){
			
				$search[$k++]="brand_stock < re_order_level";
				$message .=" ".$search_by;

				$data['low_inventry']=$search_by;
			
		}

		if(!empty($category)){

			$search[$k++]="category_id =".$category;
			$category_name=$this->commonDBFunctions->getidToValue('category','id',$category,'pharma_brand_category');;
			$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Category : ".$category_name;
		}
          
            $data['message']=$message;

        $data['category']=$this->brand_model->getCategory();

/*.......Brand Searching .......*/		

/*... pagination start ...*/

		$this->load->helper('pagination');

		$perPage=50; 
        if(empty($current_page) && empty($status)){
            $current_page =1;	
        }else{ 
            $current_page = $current_page; 
        }  

		$limit=pageLimit($current_page,$perPage);
        
        $next_page=explode(",",$limit);
        $data['next_page']=$next_page[0];
        $brand_count = $this->brand_model->countBrand($search);

        $data['brand']=$this->brand_model->getBrand($search,$limit);

        $data['pagination_link']=printPageLinks($brand_count,$current_page,$perPage);
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
        
        $this->load->view('brand/manage_brand',$data);

	}

	function brandForm($action = null,$id= null,$from_location=null){

		$data['action']=$action;
		$current_page=$this->input->post('current_page');


		$this->load->model('brand_model');

		if($action == "update"){

			$data['current_page']=$current_page;

		   $search[0]="id = ".$id;

           $data['brand']= $this->brand_model->getBrand($search);  
        }

		$data['category']=$this->brand_model->getCategory();
		$data['from_location']=$from_location;

		 $this->load->model('gst_model');
		 $search_gst[]="status = 0";
		 $data['gst_class']=$this->gst_model->getGstInfo($search_gst);
        
        $this->load->view('brand/brand_form',$data);

	}

	function create($json_submit = null){		
			
			$this->load->model('brand_model');
		
			$exist=$this->brand_model->brandExist();
			// var_dump($exist);
			if(empty($exist)) {
				$status=$this->brand_model->create();
				$data['brand_id']=$status[1];
				$this->session->set_flashdata('create_success', 'Added Successfully!');

			}else{

				$this->session->set_flashdata('brand_exist_message', 'BRAND NAME ALREADY EXIST. PLEASE ENTER ANOTHER BRAND NAME');
				
			}
		if(empty($json_submit)){

				redirect("brand/manageBrand", 'refresh');

		}else{
		  echo json_encode($data);
		}
	
	}

	function update(){ 
	
		   $this->load->model('brand_model');
		   $current_page=$this->input->post("current_page");
		   // $current_page=$this->input->post('current_page');
		    // echo $current_page; exit;
			
			$exist=$this->brand_model->brandExist($this->input->post('id'));
       
			if(empty($exist)) {
				$data['message']=$this->brand_model->update();
				$this->session->set_flashdata('update_success', 'Updated Successfully!');
			}else{
				
				$this->session->set_flashdata('brand_exist_message', 'BRAND NAME ALREADY EXIST. PLEASE ENTER ANOTHER BRAND NAME');
			}

		



			 redirect('brand/manageBrand/0/'.$current_page.'/update', 'refresh');
				
	}

	function delete($id){

		     $this->load->model('brand_model');

		     $this->load->model('batch_model');
	
			 $data['message']=$this->brand_model->delete($id);
			 $this->batch_model->delete('',$id);
			  $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

			 redirect("brand/manageBrand", 'refresh');

	}

	function manageCategory(){ 

		//load brand model
		$this->load->model('brand_model');

           $category_name=$this->input->post('search_category_name');
           $current_page=$this->input->post("current_page");

           $message='';

           if(!empty($category_name)){

			    $search[0]="category like '%".$category_name."%'";
			    $message .="Category Name : ".$category_name;
			    $data['category_name']=$category_name;

			    $data['message']=$message;

           }else{

                $search=null;
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

        $count_category=$this->brand_model->countCategory($search);
     
        $data['categoryInfo']=$this->brand_model->getCategory($search,$limit);

        $data['pagination_link']=printPageLinks($count_category,$current_page,$perPage);
        
        $data['current_page']=$current_page;

    /*... pagination end ...*/

        $this->load->view('brand/manage_category',$data);

	}

    function categoryForm($action,$id=null){

    	$this->load->model('brand_model');
         
        $data['action']=$action;

        if($action=='update'){

                  $search[0]="id = ".$id;
				  $data['category']=$this->brand_model->getCategory($search);
                 
       	   }

       	   $this->load->view('brand/category_form',$data);

	}

	public function processCategory($action,$id=null){

		$this->load->model('brand_model');
	
		$search ="";

		if($action == "create"){
		
			$id=$this->brand_model->createCategory();

			if($id >0 ) {
				$this->session->set_flashdata('create_success', 'Added Successfully!');
			}
			
		}else if($action == "update"){
		
			$this->brand_model->updateCategory();

			$this->session->set_flashdata('update_success', 'Updated Successfully!');
			
		}else if($action == "delete"){
		   
			$this->brand_model->deleteCategory($id);

			$this->session->set_flashdata('delete_success', 'Deleted Successfully!');
	
		}
		
			redirect('brand/manageCategory', 'refresh');
	}

	function get_brand_name($letters){  

		$letters=str_replace("%20", " ", $letters);
       
	 //load brand model
		   $this->load->model('brand_model');
	   if(!empty($letters)){ 

	     $brandInfo=array(); 
	     $count=array(); 
		 
		 $search[0]="brand like '$letters%'";
		 $search[1]="status =0";
		
	     $brandInfo[]=$this->brand_model->getBrand($search);

	     $search1[0]="generic_name like '$letters%'";
		 $search1[1]="status =0";
		 $order_status=1;
		
	     $brandInfo[]=$this->brand_model->getBrand($search1,"","",$order_status);

		      //get user branch
		      // $user_id   		= $this->session->userdata('user_id');
		      // $branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');
		
		    //  if($branch > 0){
		
			   // $count[0]="branch_id = ".$branch;				
		    //  }else{
			   //  $search[0]="branch_id = 0";
		    //  }


		
		 if(!empty($brandInfo)){

		 	$brand_id='';
		 
		    for($i=0;$i<count($brandInfo);$i++){

		    	for ($j=0; $j<count($brandInfo[$i]); $j++) { 

		    		if($brand_id!=$brandInfo[$i][$j][0]){

		    			// $count[0] = "brand_id = '".$brandInfo[$i][$j][0]."'";
		    			// $count[1] = "status = 0";

				     //    if($branch > 0){
					    //   $count[2]="branch_id = ".$branch;				
				     //    }else{
					    //   $count[2]="branch_id = 0";
				     //    }

		    			// $stock = $this->brand_model->getBatchStock($count);

		    			// var_dump($stock);

		    			$brand_stock=$brandInfo[$i][$j][12];

		    			$batch_stock=$brandInfo[$i][$j][19];

		    			$total_stock = ($brand_stock+$batch_stock);

		    			if($total_stock > '0'){

		    				if($total_stock <= '10'){

		    					 $brand_status="<span class='glyphicon glyphicon-ok' style='color:#d8ca5f;'></span>";

		    				}else{

		    					 $brand_status="<span class='glyphicon glyphicon-ok text-success'></span>";

		    				}

		    			}else{

                                 $brand_status="<span class='glyphicon glyphicon-remove text-danger'></span>";

		    			}

		    			echo $brandInfo[$i][$j][0]."###".$brandInfo[$i][$j][1]."(".$brandInfo[$i][$j][2].")"." (MAIN : $brand_stock / BR : $batch_stock)"."$brand_status"."|";

		    		}		

		    	    $brand_id=$brandInfo[$i][$j][0];

		    	}
			
			}
		 
		    
		 }
	
      }
    }

    function get_generic_name($letters){

        //load brand model
		$this->load->model('brand_model');

	    if(!empty($letters)){  
		 
		  $sql="select distinct generic_name from hcare_pharma_brand where(brand like '".$letters."%' or generic_name like '".$letters."%') and status='0' order by brand asc";
    
		
	
	       $brandInfo=$this->brand_model->getGeneric($sql);
		 
		    if(!empty($brandInfo)){
		 
		       for($i=0;$i<count($brandInfo);$i++){
			
			     echo $brandInfo[$i][0]."###".$brandInfo[$i][2]."|";

			   }
		 
		    
		    }
	    }

    }
	
	public function valid_brand(){
	
		//load brand model
		   $this->load->model('brand_model');
		
		//get user branch
		   // $user_id = $this->session->userdata('user_id');
		   // $branch=$this->commonDBFunctions->getidToValue('branch','id',$user_id,'users');

		$exist=$this->brand_model->valid_brand($this->input->post('brand_ID'));
		
		if(!empty($exist)) {
		
		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$this->input->post('brand_ID'),'pharma_brand');
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$this->input->post('brand_ID'),'pharma_brand');
		$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$this->input->post('brand_ID'),'pharma_brand');

		$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$this->input->post('brand_ID'),'pharma_brand');

		 //    $count[0] = "brand_id = '".$this->input->post('brand_ID')."'";
		 //    $count[1] = "status = 0";

			// if($branch > 0){
			// 	$count[2]="branch_id = ".$branch;				
			// }else{
			// 	$count[2]="branch_id = 0";
			// }

			// $stock = $this->brand_model->getBatchStock($count);

		$total_stock = ($brand_stock+$branch_stock);
		
		$brand_name .="(".$generic_name.")";

		$brand_name .=" (MAIN : ".$brand_stock." / BR : ".$branch_stock.")";
		
			if($brand_name != $this->input->post('brand')){
			
				$data['message']="Invalid Brand";
			}else{
				$data['message']="Valid Brand";
			}
		}else{
		
			$data['message']="Invalid Brand";
		}
		
		$data['total_stock']="stock";
		echo  json_encode($data);
	}

//---------------------------------------branch_stock Consumables-------------------------------------------------------------------------

	public function branch_wise_stock_report($export= null,$branch_post= null,$brand_post=null){

        $this->load->model('Batch_model');
		$this->load->model('branch');
	    $this->load->model('supplier');

		$branch_id=$this->session->userdata('branch_id');
      //  $search_by[] ="id != 1";
	    $data['branchInfo']=$this->branch->getBranch();	

		$data['suppliers']=$this->supplier->getSupplier();	

		$expiry_date=$this->input->post("expiry_date");

		if (!empty($brand_post)) {

			$brand_ID=$brand_post;
			$brand=$this->commonDBFunctions->getidToValue('brand','id',$brand_ID,'pharma_brand');

		}
		else{

			$brand_ID=$this->input->post("brand_ID");
			$brand=$this->input->post("brand");

		}


		$batch=$this->input->post("batch");
		$supplier=$this->input->post("supplier");

		if (!empty($branch_post)) {
			$branch=$branch_post;
		}
		else{
			$branch=$this->input->post("branch");
		}

		

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

		$criteria[] = "batch_stock > 0";

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

		$this->load->view('brand/branch_wise_stock_report',$data);
	}

	public function stock_adjust_form($batch_id,$branch_id,$brand=null){
			
			$brand_id=$this->commonDBFunctions->getidToValue('brand_id','id',$batch_id,'pharma_batch');	

			$data['brand_id']=$brand_id;

			$data['batch_id']=$batch_id;
         
			$data['stock']=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');	

			$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');	

			$data['batch_number']=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

			$data['expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
		    
		    $data['brand_post']=$brand;

		    $data['branch_id']=$branch_id;
			
			$this->load->view('brand/adjust_stock',$data);	
	}

	public function stock_adjust_update(){

		    $this->load->model('batch_model');

		    $this->load->model('brand_model');

		    $post=$this->input->post();
	
			$brand_id=$this->input->post('brand_id');

			$batch_id=$this->input->post('batch_id');

			$brand_selected=$this->input->post('brand_post');

			$branch_selected=$this->input->post('branch_id');
			
			$adjust_qty=$this->input->post('qty');


			        $new_branch_stock=$branch_stock=$this->batch_model->getAllBranchStock($brand_id);
				$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');
			
			
			$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

			$new_batch_qty=$adjust_qty+$batch_stock;

			$branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$batch_id,'pharma_batch');
			
			
			if(!empty($branch_id)){
			
				//if branch id exit get branch stock and calculate new branch stock
				
				$branch_stock=$brnch_stk=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				$new_branch_stock=$branch_stock+$adjust_qty;
				
			}else{
			
				//if branch id not exit get main stock and calculate new stock
				
				$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$new_brand_stock=$a=$brand_stock+$adjust_qty;
			}
			
			
			
			$data['message']=$message=$this->batch_model->update_batch_stock($batch_id,$new_batch_qty,'STOCK_ADJ');
			
			if($message == $this->lang->line('update_success')) {
				
				
				//if branch id exit update branch stock else update main stock in brand table.
			
				/*if(!empty($branch_id)){
				
					$message2=$this->brand->update_stock($brand_id,$new_branch_stock,'','','','branch');
				}else{
				
					$message2=$this->brand->update_stock($brand_id,$new_brand_stock);
				}*/
				
				$new_brand_stock=$this->batch_model->getMainStock($brand_id);
			        $this->brand_model->update_stock($brand_id,$new_brand_stock);
			
			        $new_branch_stock=$branch_stocks=$this->batch_model->getAllBranchStock($brand_id);
				$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');
			
				$adjustInfo[0]=$brand_id;
				$adjustInfo[1]=$batch_id;
				$adjustInfo[2]=date('Y-m-d');
				$adjustInfo[3]=date('H:i:s');
				$adjustInfo[4]=$adjust_qty;
				$adjustInfo[5]='';
				$adjustInfo[6]='';
				if(empty($branch_id)){
				
					$adjustInfo[7]=$brand_stock;
					$adjustInfo[12]=0;
				}else{
				
					$adjustInfo[7]=0;
					$adjustInfo[12]=$branch_stocks;
				}
				$adjustInfo[8]=$batch_stock;
				$adjustInfo[9]=$this->input->post('description');
				$adjustInfo[10]=$this->session->userdata('user_id');
				$adjustInfo[11]=$branch_id;
				$this->batch_model->stock_adjustment($adjustInfo,1);
				
				//add info to history
			
			    $info['brand_id']=$brand_id;
			    $info['batch_id']=$batch_id;
			    $info['type']=$this->commonDBFunctions->getidToValue('price_type','id',$brand_id,'pharma_brand');;
			    $info['quantity']=$adjust_qty;
			    $info['old_stock_batch']=$batch_stock;
			    $info['new_stock_batch']=$new_batch_qty;
			if(!empty($branch_id)){
			    
				$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$info['old_stock_brand']=$brand_stock;
			    $info['new_stock_brand']=$new_brand_stock;
				
				$info['old_stock_branch']=$brnch_stk;
			    $info['new_stock_branch']=$new_branch_stock;
			}else{
			   
				$info['old_stock_brand']=$brand_stock;
			    $info['new_stock_brand']=$new_brand_stock;
				
				$new_branch_stock=$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				$info['old_stock_branch']=$branch_stock;
			    $info['new_stock_branch']=$new_branch_stock;
				$branch_id=0;
			}
			    $info['action']="ADD";
			    $info['mode']="STOCK_ADJ";
			    $info['reference_id']='';
			    $info['expiry_date']='';
			    $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			    $info['branch_id']=$branch_id;
			    
			$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			
			$info['brand_name']=$brand_name;
			$info['batch_number']=$batch_name;

			   $this->load->model('item_history_model');
			   $this->item_history_model->add_history($info);
			}
				

	      redirect('brand/branch_wise_stock_report/0/'.$branch_selected.'/'.$brand_selected, 'refresh');

	}
	
  function consume_adjust_report($export=null){

           $this->load->model('batch_model');

           $this->load->model('branch');

            $brand_ID=$this->input->post("brand_ID");
			$brand=$this->input->post("brand");
            $branch=$this->input->post("branch");

           $current_page=$this->input->post('current_page');		
		
		   $criteria=array();

           $branch_id=$this->session->userdata('branch_id');
           // $search_by[] ="id != 1";

	       $data['branchInfo']=$this->branch->getBranch();
           

           if(!empty($branch)){
		   
		     $data['branch_name']=$branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$supplier,'pharma_branch');
             $criteria[] = "branch_id  = '".$branch."'";
		     $data['branch']=$branch;	

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
        


           $criteria[]="consume_status= 1";
      
           $consume =$this->batch_model->getadjustmentDetails($criteria,$limit);
           $count_consume=$this->batch_model->get_consumeCount($criteria);
           
           $data['adjustInfo']=$consume;



           if(empty($export)){
        	$data['pagination_link']=printPageLinks($count_consume,$current_page,$perPage);
        	}
        
        $data['current_page']=$current_page;

        /*... pagination end ...*/	

		$data['export']=$export;

        /*... pagination end ...*/
		
		   $this->load->view('brand/consume_adjust_report',$data);	

           

  }

      function getManufacturerName($letters){

        //load brand model
		$this->load->model('brand_model');

	    if(!empty($letters)){  
		 
		  $sql="select distinct manufacturer from hcare_pharma_brand where( manufacturer like '".$letters."%') and status='0' order by manufacturer asc";
    
		
	
	       $brandInfo=$this->brand_model->getManufacturer($sql);
		 
		    if(!empty($brandInfo)){
		 
		       for($i=0;$i<count($brandInfo);$i++){
			
			     echo $brandInfo[$i][0]."###".$brandInfo[$i][1]."|";

			   }
		 
		    
		    }
	    }

    }

     function clearAllStockSelected($no_of_items=null){
    	
    	$this->load->model('batch_model');
		$this->load->model('brand_model');
		 // echo $no_of_items;exit();
		$brand_id_selected=$this->input->post('selected_brand');
		$user_id=$this->session->userdata('user_id');
		$paction=$this->input->post('paction');
		// echo $user_id;exit;
		
		for($i=0;$i<$no_of_items;$i++){
			$brand_id=$brand_id_selected[$i];

			$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
			$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

			 $search[0]="brand_id = '".$brand_id."'";
			 // $search[1]="batch_stock != 0";
			 
			$batchInfo[$i]=$a=$this->batch_model->getBatch($search);
				 // var_dump($batchInfo[$i]);exit();
			if(!empty($batchInfo[$i])){
			for($j=0;$j<count($batchInfo[$i]);$j++){
				// brand_id=
				$batch_id=$batchInfo[$i][$j][0];
				$pack =$batchInfo[$i][$j][4];
				// $brand_stock=$batchInfo[$j][0];
				$branch_id=$batchInfo[$i][$j][12];
				
				$batch_stock=$batchInfo[$i][$j][4];

//////////////clear batch_stock in pharma_batch//////////////
				$old_stock_brand=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$old_stock_branch=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				$new_batch_qty=$batch_stock-$batch_stock;
				$data['message']=$message=$this->batch_model->update_batch_stock_clear($batch_id,$new_batch_qty,'STOCK_CLEARED');
			if($message == $this->lang->line('update_success')) {
				$new_brand_stock=$this->batch_model->getMainStock($brand_id);
					// =========brand(brand_stock)
			    $this->brand_model->update_stock($brand_id,$new_brand_stock);
			    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);
			        
			        //===========brand (branch stock)
				$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');



/////////////////////stock adjustment datas///////////
				// $adjustInfo = array();
				$adjustInfo[0]=$brand_id;
				$adjustInfo[1]=$batch_id;
				$adjustInfo[2]=date('Y-m-d');
				$adjustInfo[3]=date('H:i:s');
				if($pack == 0){
				$adjustInfo[4]=0;
				}else{
				$adjustInfo[4]="-".$pack;
				}
				$adjustInfo[5]='';
				$adjustInfo[6]='';
				if(empty($branch_id)){
					// $brand_stock from brand
					$adjustInfo[7]=$old_stock_brand;
					$adjustInfo[12]=0;
				}else{
					// $branch_stock from brand
					$adjustInfo[7]=0;
					$adjustInfo[12]=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				}
				$adjustInfo[8]=$batch_stock;
				$adjustInfo[9]="stock cleared";
				$adjustInfo[10]=$this->session->userdata('user_id');
				$adjustInfo[11]=$branch_id;

				// var_dump($adjustInfo);
				
				$this->batch_model->stock_adjustment($adjustInfo,1);
/////////////////add info to history//////
				$info['brand_id']=$brand_id;
			    $info['batch_id']=$batch_id;
			    $info['type']='';
			    if($pack == 0){
				$info['quantity']=0;
				}else{
				$info['quantity']="-".$pack;
				}


				$info['old_stock_batch']=$batch_stock;
			    $info['new_stock_batch']=$new_batch_qty;
			if(!empty($branch_id)){
			    
				$new_brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$info['old_stock_brand']=$old_stock_brand;
			    $info['new_stock_brand']=$new_brand_stock;
				
				$info['old_stock_branch']=$old_stock_branch;
			    $info['new_stock_branch']=$new_branch_stock;
			}else{
			   
				$info['old_stock_brand']=$old_stock_brand;
			    $info['new_stock_brand']=$new_brand_stock;
				$info['old_stock_branch']=$old_stock_branch;
			    $info['new_stock_branch']=$new_branch_stock;
				$branch_id=0;
			}
			    $info['action']="ADD";
			    $info['mode']="STOCK_CLEARED";
			    $info['reference_id']='';
			    $info['expiry_date']='';
			    $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			    $info['branch_id']=$branch_id;
			    
			$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			
			$info['brand_name']=$brand_name;
			$info['batch_number']=$batch_name;

			   $this->load->model('item_history_model');
			   $this->item_history_model->add_history($info);
			    
			}//end of if update_batch_stock
		} //j loop
	}else{
		$this->brand_model->updateBrandBranchStock($brand_id,0,0);

	}
	
		 }//i loop

		redirect('brand/manageBrand', 'refresh');

    }

     function clearAllStock(){
    	
    	$this->load->model('batch_model');
		$this->load->model('brand_model');
		 // echo $no_of_items;exit();
		$brand_id_selected=$this->input->post('selected_brand');
		$user_id=$this->session->userdata('user_id');
		$paction=$this->input->post('paction');
		// echo $user_id;exit;
		$brandInfo=$a=$this->brand_model->getBrand();
		// var_dump($brandInfo);exit;
		
		for($i=0;$i<count($brandInfo);$i++){
			$brand_id=$brandInfo[$i][0];

			$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
			$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

			 $search[0]="brand_id = '".$brand_id."'";
			 // $search[1]="batch_stock != 0";
			 
			$batchInfo[$i]=$a=$this->batch_model->getBatch($search);
				 // var_dump($batchInfo[$i]);exit();
			// echo count($batchInfo[$i]);exit();
			if(!empty($batchInfo[$i])){
			for($j=0;$j<count($batchInfo[$i]);$j++){
				// brand_id=
				$batch_id=$batchInfo[$i][$j][0];
				$pack =$batchInfo[$i][$j][4];
				// $brand_stock=$batchInfo[$j][0];
				$branch_id=$batchInfo[$i][$j][12];
				
				$batch_stock=$batchInfo[$i][$j][4];

//////////////clear batch_stock in pharma_batch//////////////
				$old_stock_brand=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$old_stock_branch=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				$new_batch_qty=$batch_stock-$batch_stock;
				$data['message']=$message=$this->batch_model->update_batch_stock_clear($batch_id,$new_batch_qty,'STOCK_CLEARED');
			if($message == $this->lang->line('update_success')) {
				$new_brand_stock=$this->batch_model->getMainStock($brand_id);
					// =========brand(brand_stock)
			    $this->brand_model->update_stock($brand_id,$new_brand_stock);
			    $new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);
			        
			        //===========brand (branch stock)
				$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch');



/////////////////////stock adjustment datas///////////
				// $adjustInfo = array();
				$adjustInfo[0]=$brand_id;
				$adjustInfo[1]=$batch_id;
				$adjustInfo[2]=date('Y-m-d');
				$adjustInfo[3]=date('H:i:s');
				if($pack == 0){
				$adjustInfo[4]=0;
				}else{
				$adjustInfo[4]="-".$pack;
				}
				$adjustInfo[5]='';
				$adjustInfo[6]='';
				if(empty($branch_id)){
					// $brand_stock from brand
					$adjustInfo[7]=$old_stock_brand;
					$adjustInfo[12]=0;
				}else{
					// $branch_stock from brand
					$adjustInfo[7]=0;
					$adjustInfo[12]=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				}
				$adjustInfo[8]=$batch_stock;
				$adjustInfo[9]="stock cleared";
				$adjustInfo[10]=$this->session->userdata('user_id');
				$adjustInfo[11]=$branch_id;

				// var_dump($adjustInfo);
				
				$this->batch_model->stock_adjustment($adjustInfo,1);
/////////////////add info to history//////
				$info['brand_id']=$brand_id;
			    $info['batch_id']=$batch_id;
			    $info['type']='';
			    if($pack == 0){
				$info['quantity']=0;
				}else{
				$info['quantity']="-".$pack;
				}


				$info['old_stock_batch']=$batch_stock;
			    $info['new_stock_batch']=$new_batch_qty;
			if(!empty($branch_id)){
			    
				$new_brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$info['old_stock_brand']=$old_stock_brand;
			    $info['new_stock_brand']=$new_brand_stock;
				
				$info['old_stock_branch']=$old_stock_branch;
			    $info['new_stock_branch']=$new_branch_stock;
			}else{
			   
				$info['old_stock_brand']=$old_stock_brand;
			    $info['new_stock_brand']=$new_brand_stock;
				$info['old_stock_branch']=$old_stock_branch;
			    $info['new_stock_branch']=$new_branch_stock;
				$branch_id=0;
			}
			    $info['action']="ADD";
			    $info['mode']="STOCK_CLEARED";
			    $info['reference_id']='';
			    $info['expiry_date']='';
			    $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			    $info['branch_id']=$branch_id;
			    
			$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			
			$info['brand_name']=$brand_name;
			$info['batch_number']=$batch_name;

			   $this->load->model('item_history_model');
			   $this->item_history_model->add_history($info);
			    
			}//end of if update_batch_stock
		} //j loop
	}else{
		$this->brand_model->updateBrandBranchStock($brand_id,0,0);

	}
	
		 }//i loop

		redirect('brand/manageBrand', 'refresh');

    }


}


