<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
 
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

  function hospital_info($action = null){
    
     $this->load->model('admin_model');

    if($action == "update"){

      $data['message']=$this->admin_model->updateHospitalInfo();
    }

     $data['countries']=$this->commonDBFunctions->getCountries();
     
     $data['hospitalInfo']=$this->admin_model->getHospitalInfo();

       $this->load->view('admin/hospital_info',$data);
  }

  function pharmacy_info($action = null){
    
     $this->load->model('admin_model');

     $hospital_name_status=$this->input->post('hosp_name');

    if($action == "update"){

      $data['message']=$this->admin_model->updatePharmacyInfo();
      $hospital_name_status='';
    }

    if(!empty($hospital_name_status) && $hospital_name_status==1)
      {
        $data['hosp_name']=$hospital_name_status;
        $hospitalInfo=$this->admin_model->getHospitalInfo();
        $data['hospital_name']=$hospitalInfo[0][1];
      }
     
      $data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();

       $this->load->view('admin/pharma_config',$data);
  }

  function manageInfo($info_type = null,$next_page= null){

       $message='';
    
       if($info_type=='gst'){
        
           $this->load->model('gst_model');

           $gst_per=$this->input->post('search_gst');

           if(!empty($gst_per)){

                $search[0]="gst = ".$gst_per;

                $message .="GST% : ".$gst_per;
                $data['message']=$message;

           }else{

                $search=null;
           }

           $data['gstInfo']=$this->gst_model->getGstInfo($search);  
          
       }elseif($info_type=='user'){
        
           $this->load->model('user');

           $this->load->model('branch');
           $data['branchInfo']=$this->branch->getBranch();

           $user_name=$this->input->post('search_user_name');
           $user_type=$this->input->post('search_user_type');
           $branch_select=$this->input->post('search_branch');
           $current_page=$this->input->post("current_page");
       $k=0;

       if(!empty($user_name)){
    
          $search[$k++]="user_name like '%".$user_name."%'";
          $message .="User Name : ".$user_name;
          $data['user_name']=$user_name;

          $data['message']=$message;
      
        }else if(!empty($user_type)){
      
        $search[$k++]="user_type = '".$user_type."'";
        $message .=" User Type : ".$this->commonDBFunctions->getidToValue('user_type','id',$user_type,'user_type');

        $data['user_type']=$user_type;

        $data['message']=$message;

      }else{

        $search=null;
      }

      if(!empty($branch_select)){


         if($branch_select=='main_branch'){
      
            $search[$k++]="branch = 0";
            $message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Branch : Main Branch";

            $data['branch_select']=$branch_select;

            $data['message']=$message;

         }else{

            $search[$k++]="branch = '".$branch_select."'";
            $message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Branch : ".$this->commonDBFunctions->getidToValue('branch_name','id',$branch_select,'pharma_branch');

            $data['branch_select']=$branch_select;

            $data['message']=$message;

         }
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
           
           $user_count = $this->user->getUsersCount($search);

           $data['users']=$this->user->getUsers($search,$limit);

           $data['pagination_link']=printPageLinks($user_count,$current_page,$perPage);
        
           $data['current_page']=$current_page;
        
        /*... pagination end ...*/
        
       }elseif($info_type=='customer'){
           
           $this->load->model('customer');

           $customer_name=$this->input->post('search_customer_name');
           $current_page=$this->input->post("current_page");

       if(!empty($customer_name)){

          $search[0]="customer_name like '%".$customer_name."%'";
          $message .="Customer Name : ".$customer_name;
          $data['customer_name']=$customer_name;

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

           $customer_count = $this->customer->getCustomerCount($search);

           $data['customers']=$this->customer->getCustomer($search,$limit);

           $data['pagination_link']=printPageLinks($customer_count,$current_page,$perPage);
        
           $data['current_page']=$current_page;

         /*... pagination end ...*/

       }elseif($info_type=='supplier'){
           
           $this->load->model('supplier');

           $supplier_name=$this->input->post('search_supplier_name');
           $current_page=$this->input->post("current_page");

       if(!empty($supplier_name)){

          $search[0]="supplier_name like '%".$supplier_name."%'";
          $message .="Supplier Name : ".$supplier_name;
          $data['supplier_name']=$supplier_name;

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

           $supplier_count = $this->supplier->getSupplierCount($search);

           $data['suppliers']=$this->supplier->getSupplier($search,$limit);

           $data['pagination_link']=printPageLinks($supplier_count,$current_page,$perPage);
        
           $data['current_page']=$current_page;

        /*... pagination end ...*/

       }elseif($info_type=='branch'){
           
           $this->load->model('branch');

           $branch_name=$this->input->post('search_branch_name');
           $current_page=$this->input->post("current_page");

       if(!empty($branch_name)){

          $search[0]="branch_name like '%".$branch_name."%'";
          $message .="Branch Name : ".$branch_name;
          $data['branch_name']=$branch_name;

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

           $branch_count = $this->branch->getBranchCount($search);

           $data['branch']=$this->branch->getBranch($search,$limit);

           $data['pagination_link']=printPageLinks($branch_count,$current_page,$perPage);
        
           $data['current_page']=$current_page;

        /*... pagination end ...*/

       }

       $this->load->view('admin/manage_'.$info_type,$data); 
  }

  function generateForm($form_type = null,$action = null,$id = null,$from_location=null){

       $data['action']=$action;
       
       if($form_type=='gst'){
           
           if($action=='update'){

                  $this->load->model('gst_model');

                  $search[0]="id = ".$id;
          $data['gstInfo']=$this->gst_model->getGstInfo($search);
                 
           }
       }elseif($form_type=='user'){

           $this->load->model('branch');
           $data['branchInfo']=$this->branch->getBranch();
           
           if($action=='update'){

                  $this->load->model('user');

                  $search[0]="id = ".$id;
          $data['user']=$this->user->getUsers($search); 
                
           }
       }elseif($form_type=='customer'){
           
           if($action=='update'){

                  $this->load->model('customer');

                  $search[0]="id = ".$id;
          $data['customer']=$this->customer->getCustomer($search); 
                
           }
       }elseif($form_type=='supplier'){
    
           if($action=='update'){

                  $this->load->model('supplier');

                  $search[0]="id = ".$id;
          $data['supplier']=$this->supplier->getSupplier($search); 
               
           }

          $data['from_location']=$from_location;

       }elseif($form_type=='branch'){
    
           if($action=='update'){

                  $this->load->model('branch');

                  $search[0]="id = ".$id;
          $data['branch']=$this->branch->getBranch($search); 
               
           }

       }

     $this->load->view('admin/'.$form_type.'_form',$data);
  }

  function create($info_type = null,$json_submit = null){
      
           if($info_type=='gst'){
                
                  $this->load->model('gst_model');

                  $this->gst_model->create();
                  $this->session->set_flashdata('create_success', 'Added Successfully!');
                
           }elseif($info_type=='user'){
                
                  $this->load->model('user');

                  $exist=$this->user->userExist();

                  if(empty($exist)) {

                      $this->user->create();
                      $this->session->set_flashdata('create_success', 'Added Successfully!');
        
                  }else{
                       $this->session->set_flashdata('user_exist_message', 'USER NAME ALREADY EXIST. PLEASE ENTER ANOTHER USER NAME');
                  }
                
           }elseif($info_type=='customer'){
                
                  $this->load->model('customer');

                  $this->customer->create();
                  $this->session->set_flashdata('create_success', 'Added Successfully!');
                
           }elseif($info_type=='supplier'){

    /* Insert to Accounting database */

                  $this->load->helper('accounting');

                  $ledger_acc=$this->input->post('ledger');

                  if(!empty($ledger_acc)){

                    $name=$this->input->post('Supplier_name');

                    $insert_data=array('group_id' =>20 ,'name' =>$name ,'op_balance' =>'' ,'op_balance_dc' =>'C' ,'type' =>'' ,'reconciliation' =>0 );

                    $insert_id=insertLedger($insert_data);

                    $ledger_id=$insert_id;

                  }else{

                         $ledger_id=0;   
                  }

                  // $ledger_id=0;

    /* Insert to Accounting database */   

                  $this->load->model('supplier');  

                  $result=$this->supplier->create($ledger_id);
                  $data['supplier_id']=$result[1];

                  $this->session->set_flashdata('create_success', 'Added Successfully!');
                
           }elseif($info_type=='branch'){
                
                  $this->load->model('branch');

                  $this->branch->create();
                  $this->session->set_flashdata('create_success', 'Added Successfully!');
                
           }

      if(!empty($json_submit)){

              echo json_encode($data);
      }else{
             redirect("admin/manageInfo/".$info_type, 'refresh');
      }
  
  }

  function update($info_type = null,$id = null){

           if($info_type=='gst'){
                
                  $this->load->model('gst_model');

                  $this->gst_model->update();
                  $this->session->set_flashdata('update_success', 'Updated Successfully!');
               
           }elseif($info_type=='user'){
                
                  $this->load->model('user');

                  $exist=$this->user->userExist($this->input->post('id'));

              if(empty($exist)) {

                  $this->user->update();
                  $this->session->set_flashdata('update_success', 'Updated Successfully!');

              }else{
                  
                  $this->session->set_flashdata('user_exist_message', 'USER NAME ALREADY EXIST. PLEASE ENTER ANOTHER USER NAME');
              }
                
           }elseif($info_type=='customer'){
                
                  $this->load->model('customer');

                  $this->customer->update();
                  $this->session->set_flashdata('update_success', 'Updated Successfully!');
                
           }elseif($info_type=='supplier'){

    /* Insert to Accounting database */

                  // $this->load->helper('accounting');

                  // $ledger_acc_name=$this->input->post('ledger_acc_name');

                  // $ledger_acc=$this->input->post('ledger');

                  // if(!empty($ledger_acc_name)){

                  //       $name=$this->input->post('Supplier_name');

                  //       $ldg_id=$this->input->post('ledger_id');

                  //       $update_data=array('name' =>$name);

                  //       updateLedger($update_data,$ldg_id);

                  //       $ledger_id=$ldg_id;

                  // }elseif(!empty($ledger_acc)){

                  //         $name=$this->input->post('Supplier_name');

                  //         $insert_data=array('group_id' =>20 ,'name' =>$name ,'op_balance' =>'' ,'op_balance_dc' =>'C' ,'type' =>'' ,'reconciliation' =>0 );

                  //         $insert_id=insertLedger($insert_data);

                  //         $ledger_id=$insert_id;   
                  // }else{

                  //         $ledger_id=0;    
                  // }

                  $ledger_id=0;
                  
    /* Insert to Accounting database */  

                  $this->load->model('supplier');

                  $this->supplier->update($ledger_id);
                  $this->session->set_flashdata('update_success', 'Updated Successfully!');
                
           }elseif($info_type=='branch'){
                
                  $this->load->model('branch');

                  $this->branch->update();
                  $this->session->set_flashdata('update_success', 'Updated Successfully!');
                
           }
            
           redirect("admin/manageInfo/".$info_type, 'refresh');

  }

  function delete($info_type = null,$id = null){

    if($info_type=='gst'){
            
            $this->load->model('gst_model');

            $this->gst_model->delete($id);
            $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

        }elseif($info_type=='user'){
            
            $this->load->model('user');

            $this->user->delete($id);
            $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

        }elseif($info_type=='customer'){
            
            $this->load->model('customer');
            $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

            $this->customer->delete($id);

        }elseif($info_type=='supplier'){
            
            $this->load->model('supplier');

            $this->supplier->delete($id);
            $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

        }elseif($info_type=='branch'){
            
            $this->load->model('branch');

            $this->branch->delete($id);
            $this->session->set_flashdata('delete_success', 'Deleted Successfully!');

        }

        redirect("admin/manageInfo/".$info_type, 'refresh');

  }

  function getDoctorList($letters){
       
    //load brand model
    $this->load->model('hcare_model');

     if(!empty($letters)){  
     
      $search[0]="first_name like '$letters%'";
  
      $doctorlist=$this->hcare_model->getDoctors($search);
     
      if(!empty($doctorlist)){
     
        for($i=0;$i<count($doctorlist);$i++){
      
        echo $doctorlist[$i][0]."###".$doctorlist[$i][1]." ".$doctorlist[$i][2]." ".$doctorlist[$i][3]."|";
        }
     
        
      }
  
    }
  }


  function pharmacy_stock($action = null){
    
    $this->load->model('admin_model');

    $this->load->view('admin/pharmacy_stock',$data);

  }

  function pharmacy_stock_upload($action = null){
    
    $this->load->model('admin_model');
    $this->load->model('supplier');
    $this->load->model('brand_model');
    $this->load->model('batch_model');
    $this->load->model('item_history_model');
    $this->load->helper('accounting');

    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel/IOFactory.php');

    $this->load->library('PHPExcel');

    $file = $_FILES["excel"]["tmp_name"];


    if (!empty($file)) {

      $objPHPExcel = new PHPExcel();

      $objPHPExcel = PHPExcel_IOFactory::load($file);

      $z=1;

        // CHECKING STARTS
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {

           $highestRow = $worksheet->getHighestRow();

           
           for($row=2; $row<=$highestRow; $row++)
           {


              /************ EXPIRY DATE  **********/

              $expiry_date = $worksheet->getCellByColumnAndRow(2, $row);

              if (PHPExcel_Shared_Date::isDateTime($expiry_date)==false) {

                $error[] = "Date format Error in expiry date, row no - ".$row."";

              }
              else{

                $cellValue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cellValue);                       
                $dateh     = date('Y-m-t',$dateValue); 

                if ($this->validateDate($dateh)==false) {

                  $error[] = "Date format Error in expiry date, row no - ".$row."";

                }
                      
              }



              /************ BUYP  **********/

              $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

              // if (is_numeric($buyp)==false || empty($buyp) ) {
                
              //   $error[] = "Buyp Error. Cell value must be a number !!, row no - ".$row."";

              // }

              if (empty($buyp)) {
                $buyp = 0;
              }


              /************ SELLP  **********/

              $sellp = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

              if (empty($sellp)) {
                $sellp = 0;
              }

              // if (is_numeric($sellp)==false || empty($sellp) ) {
                
              //   $error[] = "MRP Error. Cell value must be a number !!, row no - ".$row."";

              // }


              /************ GST  **********/

              $gst_per = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
              // var_dump($gst_per*100);

              $gst_per = ($gst_per*100);

              if (is_numeric($gst_per)==false || !isset($gst_per) ) {
                
                $error[] = "GST Error. Cell value must be a number !!, row no - ".$row."";

              }

              /************ Branch stock  **********/

              // $branch_stock = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

              // if (is_numeric($branch_stock)==false || !isset($branch_stock) ) {
                
              //   $error[] = "Branch stock Error. Cell value must be a number !!, row no - ".$row."";

              // }

              /************ Brand stock  **********/

              $brand_stock = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

              if (is_numeric($brand_stock)==false || !isset($brand_stock) ) {
                
                $error[] = "Brand stock Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ Brand name  **********/

              $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

              if (empty($brand) ) {
                
                $error[] = "Brand Name Error !!, row no - ".$row."";

              }

              /************ Batch No  **********/

              $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

              if (!isset($batch)) {
                
                $error[] = "Batch No Error !!, row no - ".$row."";

              }

              /************ Supplier  **********/

              // $supplier = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

              // if (empty($supplier) ) {
                
              //   $error[] = "Supplier Error !!, row no - ".$row."";

              // }





           }

        }
        // CHECKING ENDS
      
// var_dump($error);exit();
        if (empty($error)) {

            // EXCEL INSERTION
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {

               $highestRow = $worksheet->getHighestRow();

               // $highestRow = 10;

               for($row=2; $row<=$highestRow; $row++)
                {

                  $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                  $brand = str_replace('"', "", $brand);

                  $brand = str_replace("'", "", $brand);

                  $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                  $batch = str_replace("\\", "", $batch);

                  $expiry_date = $worksheet->getCellByColumnAndRow(2, $row);

                  if(!strtotime($expiry_date)) {
                      if(PHPExcel_Shared_Date::isDateTime($expiry_date)) {
                          $cellValue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                          $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cellValue);                       
                          $dateh     = date('Y-m-t',$dateValue);                          
                      } else {
                          $st = strtotime($expiry_date);
                          $dateh = date('Y-m-t',$st);                         

                      }               
                  }

                  $expiry_date = $dateh;

                  $selling_unit = "NOS";

                  $price_type = "NOS";

                  $hsn_no = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                  $supplier = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                  if (empty($supplier)) {
                    $supplier = 'NO SUPPLIER';
                  }

                  $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                  $sellp = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                  if (empty($sellp)) {
                    $sellp=0;
                  }

                  $branch_stock = 0;

                  $brand_stock = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                  $batch_stock = ($brand_stock+$branch_stock);

                  $gst_per = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                  $gst_per = ($gst_per*100);

                  if (empty($gst_per)) {
                    $gst_per = 0;
                  }

                  $gst_id = $this->commonDBFunctions->getidToValue('id','gst',$gst_per,'hcare_pharma_gst');

                  $cgst_per = $sgst_per = ($gst_per/2);

                  if ( !empty($gst_id) && !empty($gst_per) ) {

                    $gst_amt = ($gst_per * $buyp)/100;

                    $gst_amt = number_format((float)$gst_amt, 2, '.', '');

                    $cgst_amt = $gst_amt/2;

                    $cgst_amt = number_format((float)$cgst_amt, 2, '.', '');

                    $sgst_amt = $gst_amt/2;

                    $sgst_amt = number_format((float)$sgst_amt, 2, '.', '');

                  }
                  else{

                      $cgst_amt = "";

                      $sgst_amt = "";

                      $gst_amt = "";

                  }


                  $search = array();

                  $search[0] = "supplier_name = '".$supplier."'";
                  $search[1] = "status = 0";

                  $supplier_exist = $this->supplier->getSupplier($search);

                  if (!empty($supplier_exist)) {
                    
                    $supplier_id = $supplier_exist[0][0];

                  }
                  else{

                      $insert_data=array('group_id' =>20 ,'name' =>$supplier ,'op_balance' =>'' ,'op_balance_dc' =>'C' ,'type' =>'' ,'reconciliation' =>0 );

                      $insert_id=insertLedger($insert_data);

                      $ledger_id=$insert_id;

                      // $ledger_id=0;

                      $result=$this->supplier->create_supplier($ledger_id,$supplier);

                      $supplier_id=$result[1];


                  }

                  
                  $search = array();

                  $search[0] = "brand = '".$brand."'";
                  $search[1] = "status = 0";
            
                  $brand_exist = $this->brand_model->getBrand($search); 

                  if (!empty($brand_exist)) {
                    
                    $brand_id = $brand_exist[0][0];

                    $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                        
                    $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                    $this->brand_model->update_brand($brand_id,$buyp,$sellp,$brand_stock,$branch_stock); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');


                  }
                  else{


                      $result = $this->brand_model->create_brand($brand,$hsn_no,$selling_unit,$price_type,$gst_per); 

                      $brand_id = $result;

                      $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                          
                      $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      $this->brand_model->update_brand($result,$buyp,$sellp,$brand_stock,$branch_stock); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      


                  }

                  $update_history = 'imported from excel on '.date('d-m-Y');

                  if ( $branch_stock > 0 && empty($brand_stock) ) {

                      $result = $this->batch_model->create_batch_branch($brand_id,$batch,$expiry_date,$branch_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$branch_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$branch_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=1;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);


                  }
                  else if ( $brand_stock >0 && empty($branch_stock) ) {

                    $result = $this->batch_model->create_batch_brand($brand_id,$batch,$expiry_date,$brand_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$brand_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$brand_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=0;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);

                  }
                  else{

                    $result = $this->batch_model->create_batch_branch($brand_id,$batch,$expiry_date,$branch_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$branch_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$branch_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$old_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=1;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);



                      $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                          
                      $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');


                    $result = $this->batch_model->create_batch_brand($brand_id,$batch,$expiry_date,$brand_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);


                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$brand_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$brand_stock;
                      $info['old_stock_brand']=($old_stock_brand-$brand_stock);
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=0;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);

                  }


                }

            }

            $user_id = $this->session->userdata('user_id');

            $this->admin_model->addStatus(1,$user_id);

            $this->session->set_flashdata('create_success', 'Stock Imported Successfully!');

            redirect("admin/pharmacy_stock", 'refresh');

         
        }
        else{

            $this->session->set_flashdata('error_detected', $error);

            redirect("admin/pharmacy_stock", 'refresh');


        }


    }
    else{

      $this->session->set_flashdata('delete_success', 'Importing failed...File not selected');

      redirect("admin/pharmacy_stock", 'refresh');

    }


  }

  public function validateDate($date, $format = 'Y-m-d')
  {
      $d = DateTime::createFromFormat($format, $date);
      // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
      return $d && $d->format($format) === $date;
  }
  public function show_history($type=null){

    //load model
    $this->load->model('admin_model');
  
    $data['history']=$history=$this->admin_model->showHistory($type);

    $this->load->view('admin/show_history',$data);
  
  }
  function pharmacy_stock_clearence($action = null){
    
    $this->load->model('admin_model');

    $this->load->view('admin/pharmacy_stock_clearence',$data);

  }
  function pharmacy_stock_clear_upload($action = null){
    
    $this->load->model('admin_model');
    $this->load->model('supplier');
    $this->load->model('brand_model');
    $this->load->model('batch_model');
    $this->load->model('item_history_model');
    $this->load->helper('accounting');

    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel/IOFactory.php');

    $this->load->library('PHPExcel');

    $file = $_FILES["excel"]["tmp_name"];


    if (!empty($file)) {

      $objPHPExcel = new PHPExcel();

      $objPHPExcel = PHPExcel_IOFactory::load($file);

      $z=1;

        // CHECKING STARTS
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {

           $highestRow = $worksheet->getHighestRow();

           
           for($row=2; $row<=$highestRow; $row++)
           {


              /************ EXPIRY DATE  **********/

              $expiry_date = $worksheet->getCellByColumnAndRow(2, $row);

              if (PHPExcel_Shared_Date::isDateTime($expiry_date)==false) {

                $error[] = "Date format Error in expiry date, row no - ".$row."";

              }
              else{

                $cellValue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cellValue);                       
                $dateh     = date('Y-m-t',$dateValue); 

                if ($this->validateDate($dateh)==false) {

                  $error[] = "Date format Error in expiry date, row no - ".$row."";

                }
                      
              }



              /************ BUYP  **********/

              $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

              if (is_numeric($buyp)==false || empty($buyp) ) {
                
                $error[] = "Buyp Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ SELLP  **********/

              $sellp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

              if (is_numeric($sellp)==false || empty($sellp) ) {
                
                $error[] = "MRP Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ GST  **********/

              $gst_per = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

              if (is_numeric($gst_per)==false || !isset($gst_per) ) {
                
                $error[] = "GST Error. Cell value must be a number !!, row no - ".$row."";

              }

              /************ Branch stock  **********/

              $branch_stock = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

              if (is_numeric($branch_stock)==false || !isset($branch_stock) ) {
                
                $error[] = "Branch stock Error. Cell value must be a number !!, row no - ".$row."";

              }

              /************ Brand stock  **********/

              $brand_stock = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

              if (is_numeric($brand_stock)==false || !isset($brand_stock) ) {
                
                $error[] = "Brand stock Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ Brand name  **********/

              $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

              if (empty($brand) ) {
                
                $error[] = "Brand Name Error !!, row no - ".$row."";

              }

              /************ Batch No  **********/

              $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

              if (empty($batch) ) {
                
                $error[] = "Batch No Error !!, row no - ".$row."";

              }

              /************ Supplier  **********/

              $supplier = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

              if (empty($supplier) ) {
                
                $error[] = "Supplier Error !!, row no - ".$row."";

              }





           }

        }
        // CHECKING ENDS

        if (empty($error)) {


            // BATCH CLEARENCE

            // EXCEL INSERTION
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {

               $highestRow = $worksheet->getHighestRow();

               // $highestRow = 10;

               for($row=2; $row<=$highestRow; $row++)
                {

                  $excel_brands[] = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                }


            }

            if (!empty($excel_brands)) {

              $excel_brands = array_unique($excel_brands);

              $excel_brands = array_values($excel_brands);
             
              for ($i=0; $i < count($excel_brands) ; $i++) { 
                
                  $search = array();

                  $search[0] = "brand = '".$excel_brands[$i]."'";
                  $search[1] = "status = 0";
              
                  $brand_exist[$i] = $this->brand_model->getBrand($search); 

                  if (!empty($brand_exist[$i])) {
                    
                    $search = array();

                    $search[0]="brand_id = ".$brand_exist[$i][0][0];       
                    $search[1]="batch_stock > 0";
                    $search[2]="status = 0";

                    $batches[$i] = $this->batch_model->getBatch($search);

                    if (!empty($batches[$i])) {
                     
                      for ($j=0; $j < count($batches[$i]) ; $j++) { 
                        
                        if (!empty($batches[$i][$j][12])) {
                         
                          $old_stock_branch = $this->commonDBFunctions->getidToValue('batch_stock','id',$batches[$i][$j][0],'pharma_batch');

                          $old_stock_brand = 0;

                        }
                        else{

                          $old_stock_brand = $this->commonDBFunctions->getidToValue('batch_stock','id',$batches[$i][$j][0],'pharma_batch');

                          $old_stock_branch = 0;

                        }
  

                        $this->batch_model->update_batch_stock($batches[$i][$j][0],0,'STOCK_ADJ');

                        $this->brand_model->update_stock($brand_exist[$i][0][0],0);

                        $this->brand_model->update_stock($brand_exist[$i][0][0],0,'','','','branch');


                        $adjustInfo[0]=$brand_exist[$i][0][0];
                        $adjustInfo[1]=$batches[$i][$j][0];
                        $adjustInfo[2]=date('Y-m-d');
                        $adjustInfo[3]=date('H:i:s');
                        $adjustInfo[4]=-$batches[$i][$j][4];
                        $adjustInfo[5]='';
                        $adjustInfo[6]='';
                        if(empty($batches[$i][$j][12])){
                        
                          $adjustInfo[7]=$batches[$i][$j][4];
                          $adjustInfo[12]=0;
                        }else{
                        
                          $adjustInfo[7]=0;
                          $adjustInfo[12]=$batches[$i][$j][4];
                        }
                        $adjustInfo[8]=$this->commonDBFunctions->getidToValue('batch_stock','id',$batches[$i][$j][0],'pharma_batch');
                        $adjustInfo[9]='EXCEL STOCK CLEARENCE';
                        $adjustInfo[10]=$this->session->userdata('user_id');
                        $adjustInfo[11]=$batches[$i][$j][12];
                        $this->batch_model->stock_adjustment($adjustInfo,0);


                        //add info to history
                      
                          $info['brand_id']=$brand_exist[$i][0][0];
                          $info['batch_id']=$batches[$i][$j][0];
                          $info['type']='NOS';
                          $info['quantity']=-$batches[$i][$j][4];
                          $info['old_stock_batch']=$batches[$i][$j][4];
                          $info['new_stock_batch']=0;
                      if(!empty($batches[$i][$j][12])){
                          
                    
                        $info['old_stock_brand']=$old_stock_brand;
                          $info['new_stock_brand']=$old_stock_brand;
                        
                        $info['old_stock_branch']=$old_stock_branch;
                          $info['new_stock_branch']=0;
                      }else{
                         
                        $info['old_stock_brand']=$old_stock_brand;
                          $info['new_stock_brand']=0;
                        

                        $info['old_stock_branch']=$old_stock_branch;
                          $info['new_stock_branch']=$old_stock_branch;
                        // $branch_id=0;
                      }
                          $info['action']="ADD";
                          $info['mode']="EXCEL STOCK CLEARENCE";
                          $info['reference_id']='';
                          $info['expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batches[$i][$j][0],'pharma_batch');
                          $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batches[$i][$j][0],'pharma_batch');
                          $info['branch_id']=$batches[$i][$j][12];
                          
                      $brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_exist[$i][0][0],'pharma_brand');
                      $batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batches[$i][$j][0],'pharma_batch');
                      
                      $info['brand_name']=$brand_name;
                      $info['batch_number']=$batch_name;

                        
                         $this->item_history_model->add_history($info);


                      }

                    }

                  }

              }

            }

      

            // EXCEL INSERTION
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {

               $highestRow = $worksheet->getHighestRow();

               // $highestRow = 10;

               for($row=2; $row<=$highestRow; $row++)
                {

                  $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                  $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                  $expiry_date = $worksheet->getCellByColumnAndRow(2, $row);

                  if(!strtotime($expiry_date)) {
                      if(PHPExcel_Shared_Date::isDateTime($expiry_date)) {
                          $cellValue = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                          $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cellValue);                       
                          $dateh     = date('Y-m-t',$dateValue);                          
                      } else {
                          $st = strtotime($expiry_date);
                          $dateh = date('Y-m-t',$st);                         

                      }               
                  }

                  $expiry_date = $dateh;

                  $selling_unit = "NOS";

                  $price_type = "NOS";

                  $hsn_no = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                  $supplier = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                  $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                  $sellp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                  $branch_stock = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                  $brand_stock = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                  $batch_stock = ($brand_stock+$branch_stock);

                  $gst_per = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                  $gst_per = ltrim($gst_per, '0');

                  $gst_id = $this->commonDBFunctions->getidToValue('id','gst',$gst_per,'hcare_pharma_gst');

                  $cgst_per = $sgst_per = ($gst_per/2);

                  if ( !empty($gst_id) && !empty($gst_per) ) {

                    $gst_amt = ($gst_per * $buyp)/100;

                    $gst_amt = number_format((float)$gst_amt, 2, '.', '');

                    $cgst_amt = $gst_amt/2;

                    $cgst_amt = number_format((float)$cgst_amt, 2, '.', '');

                    $sgst_amt = $gst_amt/2;

                    $sgst_amt = number_format((float)$sgst_amt, 2, '.', '');

                  }
                  else{

                      $cgst_amt = "";

                      $sgst_amt = "";

                      $gst_amt = "";

                  }


                  $search = array();

                  $search[0] = "supplier_name = '".$supplier."'";
                  $search[1] = "status = 0";

                  $supplier_exist = $this->supplier->getSupplier($search);

                  if (!empty($supplier_exist)) {
                    
                    $supplier_id = $supplier_exist[0][0];

                  }
                  else{

                      $insert_data=array('group_id' =>20 ,'name' =>$supplier ,'op_balance' =>'' ,'op_balance_dc' =>'C' ,'type' =>'' ,'reconciliation' =>0 );

                      $insert_id=insertLedger($insert_data);

                      $ledger_id=$insert_id;

                      $result=$this->supplier->create_supplier($ledger_id,$supplier);

                      $supplier_id=$result[1];


                  }

                  
                  $search = array();

                  $search[0] = "brand = '".$brand."'";
                  $search[1] = "status = 0";
            
                  $brand_exist = $this->brand_model->getBrand($search); 

                  if (!empty($brand_exist)) {
                    
                    $brand_id = $brand_exist[0][0];

                    $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                        
                    $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                    $this->brand_model->update_brand($brand_id,$buyp,$sellp,$brand_stock,$branch_stock); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');


                  }
                  else{


                      $result = $this->brand_model->create_brand($brand,$hsn_no,$selling_unit,$price_type); 

                      $brand_id = $result;

                      $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                          
                      $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      $this->brand_model->update_brand($result,$buyp,$sellp,$brand_stock,$branch_stock); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      


                  }

                  $update_history = 'imported from excel on '.date('d-m-Y');

                  if ( $branch_stock > 0 && empty($brand_stock) ) {

                      $result = $this->batch_model->create_batch_branch($brand_id,$batch,$expiry_date,$branch_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$branch_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$branch_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=1;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);


                  }
                  else if ( $brand_stock >0 && empty($branch_stock) ) {

                    $result = $this->batch_model->create_batch_brand($brand_id,$batch,$expiry_date,$brand_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$brand_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$brand_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=0;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);

                  }
                  else{

                    $result = $this->batch_model->create_batch_branch($brand_id,$batch,$expiry_date,$branch_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$branch_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$branch_stock;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$old_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=1;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);



                      $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                          
                      $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');


                    $result = $this->batch_model->create_batch_brand($brand_id,$batch,$expiry_date,$brand_stock,$sellp,$buyp,$supplier_id,$update_history,$gst_id,$gst_per,$gst_amt,$sgst_amt,$cgst_amt,$sgst_per,$cgst_per);


                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$result;
                      $info['type']=$price_type;
                      $info['quantity']=$brand_stock;
                      $info['old_stock_batch']=0;
                      $info['new_stock_batch']=$brand_stock;
                      $info['old_stock_brand']=($old_stock_brand-$brand_stock);
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXPORT_STOCK_IMPORT";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$result,'pharma_batch');
                      $info['branch_id']=0;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);

                  }


                }

            }

            $user_id = $this->session->userdata('user_id');

            $this->admin_model->addStatus(2,$user_id);

            $this->session->set_flashdata('create_success', 'Stock Imported Successfully!');

            redirect("admin/pharmacy_stock_clearence", 'refresh');

         
        }
        else{

            $this->session->set_flashdata('error_detected', $error);

            redirect("admin/pharmacy_stock_clearence", 'refresh');


        }


    }
    else{

      $this->session->set_flashdata('delete_success', 'Importing failed...File not selected');

      redirect("admin/pharmacy_stock_clearence", 'refresh');

    }


  }
  public function pharmacy_stock_export($export= null){

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

    if (!empty($export)) {
      
      require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel.php');
      require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel/IOFactory.php');

      $this->load->library('PHPExcel');

      $object = new PHPExcel();

      $object->setActiveSheetIndex(0);

      $table_columns = array("BRAND","BATCH","EXP DATE","BATCH STOCK","SELLP","BUYP","SUPPLIER NAME","BRANCH","BRAND ID","BATCH ID");

      $column = 0;

      $bold = array(
          "font" => array(
              "bold" => true,
          ),
      );

      foreach ($table_columns as $field) {
        
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1,$field)->getStyle('A1:J1')->applyFromArray($bold);

        $column++;

      }

      foreach(range('A','J') as $columnID) {

          $object->getActiveSheet()->getColumnDimension($columnID)
              ->setAutoSize(true);
      }

      // $object->getActiveSheet()->getProtection()->setSheet(true);

      // $object->getActiveSheet()->getStyle('B:F')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);


      $batchInfo= $data['batchInfo'];

      $excel_row = 2;

      foreach ($batchInfo as $row) {

        if (empty($row[13])) {
          
          $row[13] = "MAIN STOCK";

        }
        
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row,$row[14]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row,$row[2]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row,date("d-m-Y",strtotime($row[3])));
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row,$row[4]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row,$row[6]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row,$row[7]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row,$row[9]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,$row[13]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row,$row[1]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,$row[0]);

        $excel_row++;

      }

      $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5'); 
      header('Content-Type: application/vnd.ms-excel'); 
      header('Content-Disposition: attachment;filename="Batch_Export.xls"'); 
      $objWriter->save('php://output');

    }

/*... pagination end ...*/

    $this->load->view('admin/pharmacy_stock_export',$data);
  }
  function pharmacy_stock_update($action = null){
    
    $this->load->model('admin_model');

    $this->load->view('admin/pharmacy_stock_update',$data);

  }
  function pharmacy_stock_upload_action($action = null){
    
    $this->load->model('admin_model');
    $this->load->model('supplier');
    $this->load->model('brand_model');
    $this->load->model('batch_model');
    $this->load->model('item_history_model');
    $this->load->helper('accounting');

    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'libraries/PHPExcel/Classes/PHPExcel/IOFactory.php');

    $this->load->library('PHPExcel');

    $file = $_FILES["excel"]["tmp_name"];


    if (!empty($file)) {

      $objPHPExcel = new PHPExcel();

      $objPHPExcel = PHPExcel_IOFactory::load($file);

      $z=1;

        // CHECKING STARTS
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {

           $highestRow = $worksheet->getHighestRow();

           
           for($row=2; $row<=$highestRow; $row++)
           {


              /************ EXPIRY DATE  **********/

              $expiry = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

              if (empty($expiry) ) {
                
                $error[] = "EXP Date Error. Cell value is empty !!, row no - ".$row."";

              }

              if ($this->validateDateYear($expiry)==false) {

                $error[] = "Date format Error in expiry date, row no - ".$row."";

              }


              /************ BUYP  **********/

              $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

              if (is_numeric($buyp)==false || empty($buyp) ) {
                
                $error[] = "Buyp Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ SELLP  **********/

              $sellp = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

              if (is_numeric($sellp)==false || empty($sellp) ) {
                
                $error[] = "MRP Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ Batch stock  **********/

              $batch_stock = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

              if (is_numeric($batch_stock)==false || !isset($batch_stock) ) {
                
                $error[] = "Batch stock Error. Cell value must be a number !!, row no - ".$row."";

              }


              /************ Brand name  **********/

              $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

              if (empty($brand) ) {
                
                $error[] = "Brand Name Error !!, row no - ".$row."";

              }

              /************ Batch No  **********/

              $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

              if (empty($batch) ) {
                
                $error[] = "Batch No Error !!, row no - ".$row."";

              }

              /************ Supplier  **********/

              $supplier = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

              if (empty($supplier) ) {
                
                $error[] = "Supplier Error !!, row no - ".$row."";

              }

              /************ Brand ID  **********/

              $brand_id = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

              if (empty($brand_id) ) {
                
                $error[] = "Brand ID Error !!, row no - ".$row."";

              }

              /************ Batch ID  **********/

              $batch_id = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

              if (empty($batch_id) ) {
                
                $error[] = "Batch ID Error !!, row no - ".$row."";

              }


           }

        }
        // CHECKING ENDS

        if (empty($error)) {

            // EXCEL INSERTION
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {

               $highestRow = $worksheet->getHighestRow();

               // $highestRow = 10;

               for($row=2; $row<=$highestRow; $row++)
                {

                  $brand = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

                  $batch = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                  $expiry_date = date("Y-m-d",strtotime($worksheet->getCellByColumnAndRow(2, $row)->getValue()));

                  $batch_stock = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                  $sellp = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                  $buyp = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                  $supplier = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                  $branch = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                  $brand_id = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                  $batch_id = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                  if (!empty($brand_id) && $batch_id ) {
                    
                    $old_stock_brand =$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');
                        
                    $old_stock_branch =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                    $old_stock_batch = $this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');


                    if ($branch=="MAIN STOCK") {

                      $this->brand_model->update_brand($brand_id,$buyp,$sellp,($batch_stock-$old_stock_batch),0); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      $this->batch_model->update_batches($brand_id,$batch_id,$batch,$expiry_date,$batch_stock,$sellp,$buyp);

                      $new_stock_batch = $this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');


                      // ADJUST INFO
                      $adjustInfo[0]=$brand_id;
                      $adjustInfo[1]=$batch_id;
                      $adjustInfo[2]=date('Y-m-d');
                      $adjustInfo[3]=date('H:i:s');
                      $adjustInfo[4]=($batch_stock-$old_stock_batch);
                      $adjustInfo[5]='';
                      $adjustInfo[6]='';
                      $adjustInfo[7]=$new_stock_brand;
                      $adjustInfo[12]=$new_stock_branch;
                      $adjustInfo[8]=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
                      $adjustInfo[9]='STOCK_ADJ';
                      $adjustInfo[10]=$this->session->userdata('user_id');
                      $adjustInfo[11]=0;
                      $this->batch_model->stock_adjustment($adjustInfo,0);


                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$batch_id;
                      $info['type']='NOS';
                      $info['quantity']=($batch_stock-$old_stock_batch);
                      $info['old_stock_batch']=$old_stock_batch;
                      $info['new_stock_batch']=$new_stock_batch;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXCEL_STOCK_UPDATE";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
                      $info['branch_id']=0;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);


                    }
                    else{

                      $this->brand_model->update_brand($brand_id,$buyp,$sellp,0,($batch_stock-$old_stock_batch)); 

                      $new_stock_brand = $this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

                      $new_stock_branch  =$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

                      $old_stock_batch = $this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

                       $this->batch_model->update_batches($brand_id,$batch_id,$batch,$expiry_date,$batch_stock,$sellp,$buyp);

                       $new_stock_batch = $this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');

                      // ADJUST INFO
                      $adjustInfo[0]=$brand_id;
                      $adjustInfo[1]=$batch_id;
                      $adjustInfo[2]=date('Y-m-d');
                      $adjustInfo[3]=date('H:i:s');
                      $adjustInfo[4]=($batch_stock-$old_stock_batch);
                      $adjustInfo[5]='';
                      $adjustInfo[6]='';
                      $adjustInfo[7]=$new_stock_brand;
                      $adjustInfo[12]=$new_stock_branch;
                      $adjustInfo[8]=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
                      $adjustInfo[9]='STOCK_ADJ';
                      $adjustInfo[10]=$this->session->userdata('user_id');
                      $adjustInfo[11]=1;
                      $this->batch_model->stock_adjustment($adjustInfo,0);


                      //add info to history
                      $info['brand_id']=$brand_id;
                      $info['batch_id']=$batch_id;
                      $info['type']='NOS';
                      $info['quantity']=($batch_stock-$old_stock_batch);
                      $info['old_stock_batch']=$old_stock_batch;
                      $info['new_stock_batch']=$new_stock_batch;
                      $info['old_stock_brand']=$old_stock_brand;
                      $info['new_stock_brand']=$new_stock_brand;
                      $info['action']="ADD";
                      $info['mode']="EXCEL_STOCK_UPDATE";
                      $info['reference_id']=0;
                      $info['expiry_date']=$expiry_date;
                      $info['new_expiry_date']=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
                      $info['branch_id']=1;//branch id
                      $info['old_stock_branch']=$old_stock_branch;
                      $info['new_stock_branch']=$new_stock_branch;
                      $info['brand_name']=$brand;
                      $info['batch_number']=$batch;
                      
                      $this->item_history_model->add_history($info);



                      
                    }
                   
                    

                  }


                }

            }

            $user_id = $this->session->userdata('user_id');

            $this->admin_model->addStatus(3,$user_id);

            $this->session->set_flashdata('create_success', 'Stock Updated Successfully!');

            redirect("admin/pharmacy_stock_update", 'refresh');

         
        }
        else{

            $this->session->set_flashdata('error_detected', $error);

            redirect("admin/pharmacy_stock_update", 'refresh');


        }


    }
    else{

      $this->session->set_flashdata('delete_success', 'Importing failed...File not selected');

      redirect("admin/pharmacy_stock_update", 'refresh');

    }


  }
  public function validateDateYear($date, $format = 'd-m-Y')
  {
      $d = DateTime::createFromFormat($format, $date);
      // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
      return $d && $d->format($format) === $date;
  }
  function printer_settings($action = null){
    
    $this->load->model('admin_model');

    $data['hospitalInfo']=$this->admin_model->getHospitalInfo();

    $this->load->view('admin/printer_settings',$data);

  }
  function printer_settings_lock($action = null){
    
    $this->load->model('admin_model');

    $lock_page = $this->input->post('lock_page');

    $this->admin_model->updatePrinterSettings($lock_page);

    $this->session->set_flashdata('create_success', 'Updated Successfully ....');

    redirect("admin/printer_settings", 'refresh');

  }


  
}
?>
