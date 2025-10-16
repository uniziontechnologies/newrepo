<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_order extends CI_Controller {
     
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	public function order_form($data = null){

       // New purchase order
        if(empty($data)){

            $data=$this->processOrederForm();

            $data['paction']=isset($data['paction'])?$data['paction']:'Save';

            $data['itemfocus']=$this->input->post('item_focus');
        }

       //supplier info
		 $this->load->model('supplier');
		 
		  $search[]="status = 0";
	      $data['supplier']=$this->supplier->getSupplier($search); 

	      $data['error_message']='';//$error_message;
       
        $this->load->view('purchase_order/order_form',$data);
	}

	function processOrederForm(){

		 //process form
		  
		  $itemcount=$this->input->post('item_count');
		  $item_loc=$this->input->post('item_loc');
		  $items_in_array=array();
		  
		//PROCESS EXISTING ARRAY
		
		$net_total =0;
		
		if($itemcount > 0 ){
		                       
			for($i=0;$i<$itemcount;$i++){
		
		
			   if($item_loc!="" && $item_loc == $i){
			     
				 //Request to remove the item
			    //So  Exclude the item 
			  }else{
				  
				  $item=$this->input->post('item');
				  
				  $qty=$item[$i][6];
						
				  $buyp=to_currency($item[$i][6]);

				  $total=$item[$i][4]*$item[$i][6];

				  $total=to_currency($total);
			
				  if($total >0 ){
				   		$net_total +=$total;
					}

                $items_in_array[]=array($item[$i][0],$item[$i][1],$item[$i][2],$item[$i][3],$item[$i][4],$item[$i][5],$buyp,$total);			
				
			  }
			}
		}
		 
		$data['paction']=$this->input->post('paction');
		$data['date']=$this->input->post('date');
		$data['supplier_selected']=$this->input->post('supplier');
		$data['net_total']=$net_total;

		$order_id=$this->input->post('order_id');
		$data['order_id']=!empty($order_id)?$order_id:'';
		
		//Adding new items to array

        $brand_name=$this->input->post('brand');
		$id=$this->input->post('brand_ID');
		
		if(!empty($brand_name)){
			
			if(!empty($id)){
				              
				$unit=$this->commonDBFunctions->getidToValue('selling_unit','id',$id,'pharma_brand');

				$buyp=$this->commonDBFunctions->getidToValue('buyp','id',$id,'pharma_brand');
				
				
				$tpers='';
				$qty='';
				$foc='';
				$total='';
				
				$items_in_array[]=array($id,$brand_name,$unit,$tpers,$qty,$foc,$buyp,$total);
				
			}
			
			
		}else{
				$data['message']="Invalid Brand Selected";
			
		}
		$data['items_in_array']=$items_in_array;
		$data['itemcount']=count($items_in_array);
		
		return $data;

	}

	public function update_purchase_order(){

		 $order_id=$this->input->post("order_id");

		 $this->load->model('purchase_order_model');
	
		$criteria[0] = "id = ".$order_id;
		$purchase_order_info=$this->purchase_order_model->searchPurchaseOrder($criteria);

		$data['paction']='update';
		$data['date']=date("d-m-Y",strtotime($purchase_order_info[0][2]));
		$data['supplier_selected']=$purchase_order_info[0][3];
		$data['net_total']=$purchase_order_info[0][7];
		$data['remarks']=$purchase_order_info[0][5];
		$data['itemfocus']='';
		$data['order_id']=$order_id;
		
		$criteria[0] = "order_id = ".$order_id;
		$purchase_order_item_Info=$this->purchase_order_model->searchPurchaseOrderItems($criteria);

        if(!empty($purchase_order_item_Info)){	

			$j=1;

		    for($i=0;$i<count($purchase_order_item_Info);$i++) {

		       $brand_name=$this->commonDBFunctions->getidToValue('brand','id',$purchase_order_item_Info[$i][5],'pharma_brand');
		       $generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$purchase_order_item_Info[$i][5],'pharma_brand');

               $brand_name .="(".$generic_name.")";

               $id=$purchase_order_item_Info[$i][5];
               $unit=$purchase_order_item_Info[$i][3];
               $foc=empty($purchase_order_item_Info[$i][9])?'':$purchase_order_item_Info[$i][9];
               $buyp=$purchase_order_item_Info[$i][8];

               $tpers=empty($purchase_order_item_Info[$i][7])?'':$purchase_order_item_Info[$i][7];

               $qty=$purchase_order_item_Info[$i][4];
               $total=$purchase_order_item_Info[$i][10];

                $items_in_array[]=array($id,$brand_name,$unit,$tpers,$qty,$foc,$buyp,$total);

            }
		}
      
          $data['items_in_array']=$items_in_array;
		  $data['itemcount']=count($items_in_array);

	   $this->order_form($data);

	}

	public function save_purchase_order(){

		$action=$this->input->post('paction');

		$this->load->model('purchase_order_model');


        if($action=='update'){

		       $result=$this->purchase_order_model->updatePurchaseOrders();

               //Delete existing order items
		       $id=$this->input->post('order_id');
		       $this->purchase_order_model->delete_order_items($id);

        }else{
              
               $result=$this->purchase_order_model->addPurchaseOrders();

        }
		
		if($result > 0 ) {
		
			$order_id=$result;
			
			$itemcount=$this->input->post('item_count');
			
			$this->purchase_order_model->id = $order_id;
		
			if($itemcount > 0 ){
		
				for($i=0;$i<$itemcount;$i++){
			
					$item=$this->input->post('item');
										 
					$this->purchase_order_model->addPurchaseorderItems($item[$i]);						
				}
			}
			
			// $this->print_purchase_order($order_id);
			redirect('purchase_order/print_purchase_order/'.$order_id);
		
		}else{
			$data['message']="Failed to Add Purchase Order";
		}

	}

	public function manage_purchase_order($next_page = null){

           //load model
           $this->load->model('purchase_order_model');
           $this->load->model('supplier');
/* Delete purchase order */

		$order_id=$this->input->post("order_id");
        
        if(!empty($order_id)){

        	$this->delete($order_id);

        }

/* Delete purchase order */

        $data['suppliers']=$this->supplier->getSupplier();

		
		$from_date=$this->input->post("from_date");
		$end_date=$this->input->post("end_date");
		$supplier=$this->input->post("supplier");		
		$pono=$this->input->post("pono");
		$purchase_status=$this->input->post("purchase_status");
		$show_deleted=$this->input->post("show_deleted");

		$current_page=$this->input->post("current_page");

		$message='';
		
		if(!empty($from_date)){
			$search[] = "date >= '".date("Y-m-d",strtotime($from_date))."'";
			$message .="From Date : ".$from_date;
			$data['from_date']=$from_date;
		}
		
		if(!empty($end_date)){
			$search[] = "date <= '".date("Y-m-d",strtotime($end_date))."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
			$data['end_date']=$end_date;
		}
		
		if(!empty($supplier)){
			$search[] = "supplier = ".$supplier;
			$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'hcare_pharma_suppliers');

            $message .="&nbsp;&nbsp;&nbsp;&nbsp; Supplier : ".$supplier_name;
            $data['supplier_selected']=$supplier;
		}
		
		if(!empty($pono)){
			$search[] = "id = '".$pono."'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; PO No : ".$pono;
			$data['pono']=$pono;
		}

		if(!empty($purchase_status) && $purchase_status=='PENDING'){
			
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Purchase Status : Pending";
			$data['purchase_status_selected']=$purchase_status;
	
		}elseif(!empty($purchase_status) && $purchase_status=='RECIEVED'){
	        
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Purchase Status : Recieved";
			$data['purchase_status_selected']=$purchase_status;
		
		}

		if(!empty($show_deleted)){
			$search[] = "status = '1'";
			$message .="&nbsp;&nbsp;&nbsp;&nbsp; Deleted Purchase Orders";
			$data['show_deleted']='Deleted';
		}

		if(empty($search) && empty($purchase_status)){

            $search[] = "date >= '".date("Y-m-d")."'";

            $search[] = "date <= '".date("Y-m-d")."'";

		}


		if(empty($show_deleted)){

			$search[] = "status = '0'";
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

        if(!empty($purchase_status)){
        	
        	$limit='';
        	$data['pagination_status']="NO";
        }

        $count_purchase_order = $this->purchase_order_model->getPurchaseOrderCount($search);

		$data['purchase_order_info']=$this->purchase_order_model->searchPurchaseOrder($search,$purchase_status,$limit);

		$data['pagination_link']=printPageLinks($count_purchase_order,$current_page,$perPage);
        
        $data['current_page']=$current_page;

/*... pagination end ...*/
   
		$this->load->view('purchase_order/manage_purchase_order',$data);
	}

	public function delete($id){
	
        $this->load->model('purchase_order_model');

		$this->purchase_order_model->delete_purchase_order($id);
		$this->purchase_order_model->delete_order_items($id);

		$this->session->set_flashdata('delete_success', 'Deleted Successfully!');
		
		return true;
		
			
	}

	public function print_purchase_order($order_id = null){
   
        //load model
		$this->load->model('purchase_order_model');
        $this->load->model('admin_model');

        if(empty($order_id)){

            $order_id=$this->input->post("order_id");
        }

	
		$criteria[0] = "id = ".$order_id;
		$data['purchase_order_info']=$this->purchase_order_model->searchPurchaseOrder($criteria);
		
		$criteria[0] = "order_id = ".$order_id;
		$data['purchase_order_item_Info']=$this->purchase_order_model->searchPurchaseOrderItems($criteria);
             

		$data['hospitalInfo']=$this->admin_model->getHospitalInfo();
		$data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();

		$this->load->view('purchase_order/print_purchase_order',$data);
	
	
	}

	public function order_email_to_supplier($order_id = null){

        //load model
		//load model
		$this->load->model('purchase_order_model');
        $this->load->model('admin_model');

        $email_id=$this->input->post('mail_id');

        $criteria[0] = "id = ".$order_id;
		$data['purchase_order_info']=$this->purchase_order_model->searchPurchaseOrder($criteria);
		
		$criteria[0] = "order_id = ".$order_id;
		$data['purchase_order_item_Info']=$this->purchase_order_model->searchPurchaseOrderItems($criteria);
             

		$data['hospitalInfo']=$hospitalInfo=$this->admin_model->getHospitalInfo();
		$data['pharmacyInfo']=$pharmacyInfo=$this->admin_model->getPharmacyInfo();

		$from_email=$hospitalInfo[0][9];
		$pharma_name=$pharmacyInfo[0][1];
		$cc_emails=$pharmacyInfo[0][7];
	
		//load the view and saved it into $html variable
	    $html=$this->load->view('purchase_order/pdf_purchase_order', $data, true);
	 
	    //this the the PDF filename that user will get to download
      
	    $pdfFilePath = "pdf/Purchase_Order"."(".$order_id.")."."pdf";
	 
	    //load mPDF library
	    $this->load->library('m_pdf');
	 
	    //generate the PDF from the given html
	    $this->m_pdf->pdf->WriteHTML($html);
	 
	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "F"); 


	    $this->load->library('mailgun');
	    $config=$this->mailgun->email_config();

	    $this->load->library('email',$config); 
	    $this->email->from($from_email, $pharma_name);
		$this->email->to($email_id,'Recipient Name');
		$this->email->cc($cc_emails); 
		$this->email->subject('Purchase Order');
		$this->email->message('Purchase order Detailed list'); 
		$this->email->attach($pdfFilePath);
		if($this->email->send()) {
			    
			    //echo 'Message has been sent.';
			    $this->session->set_flashdata('email_success', 'This Purchase Order has been sent.');
			    $this->purchase_order_model->updateEmailStatus($order_id,1,$email_id);

		} else {
			    
			    //echo $this->email->print_debugger();
                $this->session->set_flashdata('email_error', 'This Purchase Order has not been sent , Invalid email address');
                $this->purchase_order_model->updateEmailStatus($order_id,2);

		}

	    unlink($pdfFilePath);

	    redirect('purchase_order/manage_purchase_order','refresh');
	}

	
}


