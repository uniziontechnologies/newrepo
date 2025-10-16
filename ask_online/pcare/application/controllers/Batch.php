<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct()
	{
		parent::__construct('batch');
        $this->load->model('batch_model');	
        date_default_timezone_set('Asia/Kolkata');	
	}
	public function index($brand_id = null)
	{
	    
        $this->load->model('batch_model');

        $this->load->model('branch');

        if(empty($brand_id)) $brand_id=$this->input->post('brand_id');

		
		$data['brand_id'] =$brand_id;

		$data['brand_name'] =$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$data['brand_stock'] =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
		$data['branch_stock'] =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
	
		
		$search[0]="brand_id = ".$brand_id;

		
		$branch_selected=$this->input->post("branch");

		$batch_no=$this->input->post("batch_no");

		$expired_batch=$this->input->post("expired_batch");

		$zero_stock=$this->input->post("zero_stock");

		$message='';
		
		if(!empty($branch_selected)){
			
			if($branch_selected == "main_branch"){
			
				$search[]="(branch_id is NULL or branch_id=0)";

                $message .="Branch : Main Branch";

			}else{

				$search[]="branch_id = ".$branch_selected;

                $branch_name=$this->commonDBFunctions->getidToValue('branch_name','id',$branch_selected,'hcare_pharma_branch');

                $message .="Branch : ".$branch_name;
			}

		}
		
        if(!empty($batch_no)){

             $search[]="batch_number = '".$batch_no."'";
             $search[]="batch_stock >0";  

             $message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Batch : ".$batch_no;

        }

        if(!empty($expired_batch)){

             $search[]="expiry_date <= '".date("Y-m-d")."'";  

             $data['expired_batch']=$expired_batch;

             $message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Expired Batch";

        }

        if(!empty($zero_stock)){

             $search[]="batch_stock <=0"; 

             $data['zero_stock']=$zero_stock;

             $message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Zero Stock";

        }else{

             $search[]="batch_stock >0"; 
        }

        $data['message']=$message;     

        $data['branchInfo']=$this->branch->getBranch();

		// $data['batch']=$this->batch_model->getBatch($search);
		$data['batch']=$this->batch_model->getBatch($search,'','','','','FROM_MANAGE_BATCH');
			
		$this->load->view('batch/manage_batch',$data);
		
		
	}
	public function batch_form($action = null,$brand_id = null,$id = null){
	       
			$data['action']=$action;

			$data['brand_id']=$brand_id;

			$data['batch_id']=$id;
    
			if($action == "update"){

				$this->load->model('batch_model');
			
				$search[0]="id = ".$id;
				$data['batch'] = $batch=$this->batch_model->getBatch($search);
			
			}

			$this->load->model('gst_model');

			$data['gstInfo']=$this->gst_model->getGstInfo();

            $this->load->model('supplier');

			$data['suppliers']=$this->supplier->getSupplier();
			
			$this->load->view('batch/batch_form',$data);
	
	}
	public function create($brand_id){ //echo $brand_id;exit();
	   
			$this->load->model('batch_model');

			$this->load->model('brand_model');
			
			$batchInfo['brand_id'] = $brand_id;
			$batchInfo['batch_number'] = $this->input->post('batch_number');
			$batchInfo['expiry_date'] = $this->input->post('expiry_date');
			$batchInfo['supplier_id'] = $this->input->post('supplier');
			$batchInfo['batch_stock'] = $this->input->post('qty');
			$batchInfo['price_type'] = $this->input->post('price_type');
			$batchInfo['sellp'] = $this->input->post('sellp');
			$batchInfo['buyp'] = $this->input->post('buyp');
			$batchInfo['description'] = $this->input->post('description');
			$batchInfo['action'] = "CREATE";
			$batchInfo['reference_id'] ="";
			$batchInfo['mode']="MANUAL_ADD";

/*..... Add Gst .....*/	

    $gst_id=$this->input->post('gst');

    if(!empty($gst_id)){

            $gst_per=$this->commonDBFunctions->getidToValue('gst','id',$gst_id,'pharma_gst');
            $sgst_per=$this->commonDBFunctions->getidToValue('sgst','id',$gst_id,'pharma_gst');
            $cgst_per=$this->commonDBFunctions->getidToValue('cgst','id',$gst_id,'pharma_gst');

    }else{

            $gst_id='';
            $gst_per='';
            $sgst_per='';
            $cgst_per='';        

    }

/*..... Add Gst .....*/		
            
            $batchInfo['gst_per']=$gst_per;
			$batchInfo['sgst_per']=$sgst_per;
			$batchInfo['cgst_per']=$cgst_per;
			$batchInfo['gst_amt']='';
			$batchInfo['sgst_amt']='';
			$batchInfo['cgst_amt']='';
			$batchInfo['gst_id']=$gst_id;
			
			//create new batch
			$batch_id=$this->batch_model->create($batchInfo,$batchInfo['action']);
			$batch_stock=$batchInfo['batch_stock'];;
			$branch_id=$this->commonDBFunctions->getidToValue('branch_id','id',$batch_id,'pharma_batch');

			if(!empty($branch_id)){
			
				//if branch id exit get branch stock and calculate new branch stock
				
				$branch_stock=$brnch_stk=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');
				$new_branch_stock=$branch_stock+$batch_stock;
				
			}else{
			
				//if branch id not exit get main stock and calculate new stock
				
				$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
				$new_brand_stock=$brand_stock+$batch_stock;
			}
			
			if($batch_id >0){

				$adjustInfo[0]=$brand_id;
				$adjustInfo[1]=$batch_id;
				$adjustInfo[2]=date('Y-m-d');
				$adjustInfo[3]=date('H:i:s');
				$adjustInfo[4]=$this->input->post('qty');
				$adjustInfo[5]='';
				$adjustInfo[6]='';
				if(empty($branch_id)){
				
					$adjustInfo[7]=$brand_stock;
					$adjustInfo[12]=0;
				}else{
				
					$adjustInfo[7]=0;
					$adjustInfo[12]=$branch_stock;
				}
				$adjustInfo[8]=$batch_stock;
				$adjustInfo[9]="BATCH CREATED";
				$adjustInfo[10]=$this->session->userdata('user_id');
				$adjustInfo[11]=$branch_id;
				$this->batch_model->stock_adjustment($adjustInfo,0);
				
			    $this->session->set_flashdata('create_success', 'Added Successfully!');
			}else{
			    $this->session->set_flashdata('create_failed', 'Failed To Add!');
			}
			//update brand stock
			$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
			
			/*$new_brand_stock=$brand_stock+$new_batch_qty;
			
			$this->brand->update_stock($brand_id,$new_brand_stock,$batchInfo[7],$batchInfo[8],$batchInfo[9]);
			
			$new_branch_stock=$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');*/
			
			$new_brand_stock=$this->batch_model->getMainStock($brand_id);
			$this->brand_model->update_stock($brand_id,$new_brand_stock,$batchInfo['price_type'],$batchInfo['sellp'],$batchInfo['buyp']);
			
			$new_branch_stock=$branch_stock=$this->batch_model->getAllBranchStock($brand_id);
			$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
			$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');
			
			//add info to history
			
			$info['brand_id']=$batchInfo['brand_id'];
			$info['batch_id']=$batch_id;
			$info['type']=$batchInfo['price_type'];
			$info['quantity']=$batchInfo['batch_stock'];
			$info['old_stock_batch']=0;
			$info['new_stock_batch']=$batch_stock;
			$info['old_stock_brand']=$brand_stock;
			$info['new_stock_brand']=$new_brand_stock;
			$info['action']="ADD";
			$info['mode']="MANUAL_ADD";
			$info['reference_id']=$batchInfo['reference_id'];
			$info['expiry_date']=$batchInfo['expiry_date'];
			$info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
			$info['branch_id']=0;//branch id
			$info['old_stock_branch']=$branch_stock;
			$info['new_stock_branch']=$new_branch_stock;
			$info['brand_name']=$brand_name;
			$info['batch_number']=$batch_name;
			
			$this->load->model('item_history_model');
			$this->item_history_model->add_history($info);
			
			
	      redirect('batch/index/'.$brand_id, 'refresh');
	}
	
	public function update($brand_id){
	        
	        $this->load->model('batch_model');
			
			$batch_id=$this->input->post('id');

			$batchInfo['brand_id'] = $brand_id;
			$batchInfo['batch_number'] = $this->input->post('batch_number');
			$batchInfo['expiry_date'] = $this->input->post('expiry_date');
			$batchInfo['supplier_id'] = $this->input->post('supplier');
			$batchInfo['price_type'] = $this->input->post('price_type');
			$batchInfo['sellp'] = $this->input->post('sellp');
			$batchInfo['buyp'] = $this->input->post('buyp');
			$batchInfo['description'] = $this->input->post('description');
			$batchInfo['batch_stock'] = $this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

/*..... Update Gst .....*/	

    $gst_id=$this->input->post('gst');

    if(!empty($gst_id)){

            $gst_per=$this->commonDBFunctions->getidToValue('gst','id',$gst_id,'pharma_gst');
            $sgst_per=$this->commonDBFunctions->getidToValue('sgst','id',$gst_id,'pharma_gst');
            $cgst_per=$this->commonDBFunctions->getidToValue('cgst','id',$gst_id,'pharma_gst');

    }else{

            $gst_id='';
            $gst_per='';
            $sgst_per='';
            $cgst_per='';        

    }

/*..... Update Gst .....*/		
            
            $batchInfo['gst_per']=$gst_per;
			$batchInfo['sgst_per']=$sgst_per;
			$batchInfo['cgst_per']=$cgst_per;
			$batchInfo['gst_amt']='';
			$batchInfo['sgst_amt']='';
			$batchInfo['cgst_amt']='';
			$batchInfo['gst_id']=$gst_id;
			
		
			
			$data['message']=$this->batch_model->update($batch_id,$batchInfo);
			$this->session->set_flashdata('update_success', 'Updated Successfully!');
			
		    redirect('batch/index/'.$brand_id, 'refresh');
	}
	public function stock_adjust_form($batch_id){
			
			$brand_id=$this->commonDBFunctions->getidToValue('brand_id','id',$batch_id,'pharma_batch');	

			$data['brand_id']=$brand_id;

			$data['batch_id']=$batch_id;

			$data['stock']=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');	

			$data['brand_name']=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');	

			$data['batch_number']=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

			$data['expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
		
			
			$this->load->view('batch/adjust_stock',$data);	
	}
	
	public function stock_adjust_update(){

		    $this->load->model('batch_model');
		    $this->load->model('brand_model');
	
			$brand_id=$this->input->post('brand_id');

			$batch_id=$this->input->post('batch_id');
			
			$adjust_qty=$this->input->post('qty');
			
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
				$new_brand_stock=$brand_stock+$adjust_qty;
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
				$this->batch_model->stock_adjustment($adjustInfo,0);
				
				//add info to history
			
			    $info['brand_id']=$brand_id;
			    $info['batch_id']=$batch_id;
			    $info['type']='';
			    $info['quantity']=$adjust_qty;
			    $info['old_stock_batch']=$batch_stock;
			    $info['new_stock_batch']=$new_batch_qty;
			if(!empty($branch_id)){
			    
				$new_brand_stock=$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
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
				
			
			redirect('batch/index/'.$brand_id, 'refresh');
	}
	public function stock_adjust_report($brand_id){
	
			$data['brand']=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');;
			
			$search[0]="brand_id =".$brand_id;
			$data['adjustInfo']=$this->batch_model->getadjustmentDetails($search);
		
			$this->load->view('batch/stock_adjust_report',$data);
	
	}
	public function valid_batch(){
	
	   $batchInfo[0]=$this->input->post('brand_id');
		$batchInfo[1]=$this->input->post('batch_number');
		$batchInfo[2]=$this->input->post('expiry_date');
		
		$exist=$this->batchDB->batchExist($batchInfo);
		
		if(!empty($exist)) {
		
		  $data['stock']=$exist['batch_stock'];
		  $data['message']="Valid Batch";
		
		}else{
		$data['message']="Invalid Batch";
		}
		echo  json_encode($data);
	}
	
	function select_batch_supplier($brand_id,$supp_id){
		
		
	
		$data['brand_id'] = $brand_id;
		
	
		
		$newDate = date("Y-m-d",strtotime("+30 day"));
		
		$search[0]="brand_id = ".$brand_id;				
		//$search[1]="expiry_date >'".$newDate."'";
		$search[1]="batch_stock >0";
		$search[2]="branch_id = 0";
		$search[3]="supplier_id = ".$supp_id;
		
		$data['batch']=$this->batch_model->getBatch($search);
        
        //other branch expired medicines
        $search_exp[0]="brand_id = ".$brand_id;				
		$search_exp[1]="expiry_date <='".date('Y-m-d')."'";
		$search_exp[2]="batch_stock >0";
		$search_exp[3]="(branch_id !=  '' && branch_id !=  0)";
		$search_exp[4]="supplier_id = ".$supp_id;

		$data['other_branch_batch']=$this->batch_model->getBatch($search_exp);
		

		$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
		$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$brand_id,'pharma_brand');
		$shelf_number=$this->commonDBFunctions->getidToValue('shelf_number','id',$brand_id,'pharma_brand');
		$data['brand_name']=$brand_name."(".$generic_name.")";
		$data['shelf_number']=$shelf_number;
		$data['supplier_name']=$this->commonDBFunctions->getidToValue('supplier_name','id',$supp_id,'pharma_suppliers');
		
		$this->load->view('batch/select_batch_supplier',$data);
	
	}
	/*
	public function delete($id){
	
			 $data['message']=$this->brand->delete($id);
			 
			 $data['form_attributes']=array('id' => 'form', 'name' =>'manage_brand');
			 $data['brand']=$this->brand->getBrand();
			$this->load->view('brand/manage_brand',$data);
	}
	*/
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
