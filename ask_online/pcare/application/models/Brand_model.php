<?php
class Brand_model extends CI_Model {

   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function brandExist($id = null){
	    
		$this->brand = $this->input->post('brand_name');
		if(!empty($id)){
			$this->db->not_like('id',$id);
		}
		
		$this->db->where('brand',$this->brand);
		$this->db->where('status','0');
		
        $query = $this->db->get('pharma_brand');
// echo $this->db->last_query();
		return $query->result();
	}
	function valid_brand($id){
	
		
		$this->db->where('id',$id);
		$this->db->where('status',0);
		
        $query = $this->db->get('pharma_brand');
        //echo $this->db->last_query();
		return $query->result();
	}
    function countBrand($search = null){
	
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');
		 $query = $this->db->get('pharma_brand');
		 
		 return $query->num_rows();
	
	}
    function getBrand($search = null,$limit=null,$offset=null)
    {  

    	if(!empty($limit)){

            $limit=explode(",",$limit);

		}

		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');
		$this->db->order_by("brand", "asc"); 
		
		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_brand');

        // echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand;
			$options[$i][2] = $row->generic_name;			
			$options[$i][3] = $row->manufacturer ;
			$options[$i][4] = $row->category_id;
			$options[$i][5]=  $this->commonDBFunctions->getidToValue('category','id',$row->category_id,'pharma_brand_category');
			$options[$i][6] = $row->selling_unit  ;
			$options[$i][7] = $row->tablet_per_strip;
			$options[$i][8] = $row->strip_per_pack;
			$options[$i][9] = $row->price_type;
			$options[$i][10] = $row->sellp;
			$options[$i][11] = $row->buyp;
			
			/*$criteria[0]="brand_id = ".$row->id;
	                $criteria[1]="(branch_id = 0 or branch_id ='')";
	                $criteria[2]="status = 0";
	                $criteria[3]="batch_stock >0";
			
	                $brand_count=$this->batchDB->getbatch_count($criteria);
			
			$options[$i][12] = $brand_count;*/
			$options[$i][12] = $row->brand_stock;
			$stock_conversion=tab_to_pack($row->brand_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			$options[$i][13]=$stock_conversion[0];
			$options[$i][14]=$stock_conversion[1];
			$options[$i][15]=$stock_conversion[2];
			
			$options[$i][16] = $row->re_order_level;
			$options[$i][17] = $row->description;
			$options[$i][18] = $row->status;
			
			/*$criteria[0]="brand_id = ".$row->id;
	                $criteria[1]="(branch_id > 0 )";
	                $criteria[2]="status = 0";
	                $criteria[3]="batch_stock >0";
			
			//$branch_stock=$this->batchDB->getbatch_count($criteria);*/
			$options[$i][19] = $row->branch_stock;
			
			$stock_conversion=tab_to_pack($row->branch_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			$options[$i][20]=$stock_conversion[0];
			$options[$i][21]=$stock_conversion[1];
			$options[$i][22]=$stock_conversion[2];
			$options[$i][23]=$row->shelf_number;
			$options[$i][24]=$row->hsn_no;
			$options[$i][25]=$row->h1n_sheduled_x;
			$options[$i][26]=$row->gst_per;
			$options[$i][27]= $this->commonDBFunctions->getidToValue('gst','id',$row->gst_per,'pharma_gst');;
			
			$i++;
		}
		return $options;
		
    }
    function getGeneric($sql)
    {   
		$options = array();
		$i=0;		
	    
	    $query = $this->db->query($sql);

		foreach ($query->result() as $row)
		 {
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand;
			$options[$i][2] = $row->generic_name;			
			
			$i++;
		 }

		return $options;
    }
	function countLowInventory($search = null){
	
		$options = array();
		$i=0;		
		$this->db->from('pharma_brand a');
        $this->db->join('pharma_batch b', 'a.id = b.brand_id');
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');
		$this->db->where('b.status','0');
		
		$this->db->group_by("b.brand_id");
		 $query = $this->db->get();
		// echo $this->db->last_query(); 
		 return $query->num_rows();
	
	}
	function getLowInventory($search,$limit=null,$offset=null){
       
       if(!empty($limit)){

            $limit=explode(",",$limit);

	   }

	   $options = array();
		$i=0;
	  $this->db->select('a.id as brand_id,a.brand as brand,a.generic_name as generic_name,a.brand_stock as brand_stock,a.branch_stock as branch_stock,a.re_order_level as re_order_level');
      $this->db->from('pharma_brand a');
      $this->db->join('pharma_batch b', 'a.id = b.brand_id');
	  if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');
		$this->db->where('b.status','0');
		$this->db->order_by("brand", "asc"); 
	  $this->db->group_by("b.brand_id");
	  
		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

      $query = $this->db->get();
	 // echo $this->db->last_query();
	    foreach ($query->result_array() as $row)
		{
		
		 $options[$i][0] = $row['brand_id'];	
		 $options[$i][1] = $row['brand'];
		 $options[$i][2] = $row['generic_name'];
		 $options[$i][3] = $row['brand_stock'];
		 $options[$i][4] = $row['branch_stock'];
		 $options[$i][5] = $row['re_order_level'];
		 
		 $i++;
		
		}
	return $options;
	}
	  
	 function getNonMovBrand($search = null,$limit=null,$offset=null)
    {
		$options = array();
		$i=0;		
		
		if(!empty($limit)){

            $limit=explode(",",$limit);

	   }
		
		
		$sql='SELECT * FROM hcare_pharma_brand WHERE id NOT IN (SELECT DISTINCT item_id FROM `hcare_pharma_invoice_items` WHERE ';
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				//$this->db->where($search[$k]);
				if($k>0)
				$sql.= " AND ";
				
				$sql.= $search[$k];
			
			}
		}
		$sql.= ") AND (brand_stock >0 OR branch_stock >0)";

		if($limit !=''){

		   $sql.= "LIMIT ".$limit[0].",".$limit[1]."";
		}
		// var_dump($sql);
        $query = $this->db->query($sql);
		// echo $this->db->last_query();
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand;
			$options[$i][2] = $row->generic_name;			
			$options[$i][3] = $row->manufacturer ;
			$options[$i][4] = $row->category_id;
			$options[$i][5]=  $this->commonDBFunctions->getidToValue('category','id',$row->category_id,'pharma_brand_category');
			$options[$i][6] = $row->selling_unit  ;
			$options[$i][7] = $row->tablet_per_strip;
			$options[$i][8] = $row->strip_per_pack;
			$options[$i][9] = $row->price_type;
			$options[$i][10] = $row->sellp;
			$options[$i][11] = $row->buyp;
			$options[$i][12] = $row->brand_stock;
			$stock_conversion=tab_to_pack($row->brand_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			$options[$i][13]=$stock_conversion[0];
			$options[$i][14]=$stock_conversion[1];
			$options[$i][15]=$stock_conversion[2];
			
			$options[$i][16] = $row->re_order_level;
			$options[$i][17] = $row->description;
			$options[$i][18] = $row->status;
			$options[$i][19] = $row->branch_stock;
			
			$stock_conversion=tab_to_pack($row->branch_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			$options[$i][20]=$stock_conversion[0];
			$options[$i][21]=$stock_conversion[1];
			$options[$i][22]=$stock_conversion[2];
			
			$i++;
		}
		return $options;
		
    }
	 function CountNonMovBrand($search = null,$limit=null,$offset=null)
    {
		$options = array();
		$i=0;		
		
		if (!empty($offset)) {
			$test = $offset." ,";
		}
		else{
			$test="";
		}
		
		
		$sql='SELECT * FROM hcare_pharma_brand WHERE id NOT IN (SELECT DISTINCT item_id FROM `hcare_pharma_invoice_items` WHERE ';
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				//$this->db->where($search[$k]);
				if($k>0)
				$sql.= " AND ";
				
				$sql.= $search[$k];
			
			}
		}
		$sql.= ") AND (brand_stock >0 OR branch_stock >0)";
		
		if($limit !=''){

		   $sql.= "LIMIT ".$test."".$limit."";
		}
		// var_dump($sql);
        $query = $this->db->query($sql);
        return $query->num_rows();
		
    }  
	    
	function create(){
	    
	   	$tpers=$this->input->post('t_per_s');
		$sperp=$this->input->post('s_per_p');
		if($tpers == "")$tpers=1;
		if($sperp == "")$sperp=1;

		$h1n_shld_x=$this->input->post('h1n_shld_x');
		if(empty($h1n_shld_x)) $h1n_shld_x=0;
		
		$this->brand 				= $this->input->post('brand_name');
	    $this->generic_name   		= $this->input->post('generic_name');
	    $this->hsn_no   		    = $this->input->post('hsn_no');
	    $this->manufacturer  		= $this->input->post('manufacturer');
		$this->category_id   		=$this->input->post('category');
		$this->selling_unit 		=$this->input->post('selling_unit');
		$this->tablet_per_strip 	=$tpers;
		$this->strip_per_pack   	=$sperp;
		$this->price_type			=$this->input->post('price_type');
		$this->sellp  				=$this->input->post('selling_price');
		$this->buyp  				=$this->input->post('buying_price');
		$this->re_order_level   	=$this->input->post('reorder');
		$this->shelf_number   	    =$this->input->post('shelf_number');
		$this->description   		=$this->input->post('description');
		$this->h1n_sheduled_x   	=$h1n_shld_x;
		$this->status   			= '0';
		$this->brand_stock   		= '0';
		$this->gst_per   		= $this->input->post('gst_class');
		$result=$this->db->insert('pharma_brand', $this);
		
		if($result) {
			return  array($this->lang->line('add_success'),$this->db->insert_id());
		}else{
			return  array($this->lang->line('add_failed'),0);
		}
	}
	function update(){

		$h1n_shld_x=$this->input->post('h1n_shld_x');
		if(empty($h1n_shld_x)) $h1n_shld_x=0;
	    
		$condition				= array('id' => $this->input->post('id'));
		$this->brand 				= $this->input->post('brand_name');
	    $this->generic_name   		= $this->input->post('generic_name');
	    $this->hsn_no   		    = $this->input->post('hsn_no');
	    $this->manufacturer  		= $this->input->post('manufacturer');
		$this->category_id   		=$this->input->post('category');
		$this->selling_unit 		=$this->input->post('selling_unit');
		$this->tablet_per_strip 	=$this->input->post('t_per_s');
		$this->strip_per_pack   	=$this->input->post('s_per_p');
		$this->price_type			=$this->input->post('price_type');
		$this->sellp 				=$this->input->post('selling_price');
		$this->buyp   				=$this->input->post('buying_price');
		$this->re_order_level   	=$this->input->post('reorder');
		$this->shelf_number   	    =$this->input->post('shelf_number');
		$this->description   		=$this->input->post('description');
		$this->h1n_sheduled_x   	=$h1n_shld_x;
		$this->status   			= '0';
		$this->gst_per   		= $this->input->post('gst_class');
		
		$result=$this->db->update('pharma_brand', $this,$condition);
		//echo $this->db->last_query();
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	function update_stock($id,$stock,$price_type = null,$sellp = null,$buyp = null,$type= 'main'){
	
		$condition= array('id' => $id);
		
		/*if($stock !=''){

		  $data['brand_stock']	=$stock;
		}else if($stock != null && $stock <= 0){
		   $data['brand_stock']	=0;
		}*/
		
		if($stock < 0){
		  $stock=0;
		}
		if($type == "main"){
			
		  $data['brand_stock']	=$stock;
		  
		}else if($type == "branch"){
			
		  $data['branch_stock']	=$stock;
		}
		if(!empty($price_type)){
		
			$data['price_type']	=$price_type;
			$data['sellp'] 		=$sellp;
			$data['buyp']  		=$buyp;
		}
		/*if(!empty($branch_stock)){
		
			$data['branch_stock']	=$branch_stock;
		}else if($branch_stock != null && $branch_stock <= 0){
		   $data['branch_stock']	=0;
		}*/

		$result=$this->db->update('pharma_brand', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	
	function delete($id){
	
	   date_default_timezone_set('Asia/Kolkata');
	   $cancelled_by = $this->session->userdata('user_id');
	   $cancelled_date=date("Y-m-d h:i:s");
	
		$condition				= array('id' => $id);
		$data   		= array('status' => '1', 'cancellation_date' =>$cancelled_date,'cancelled_by' =>$cancelled_by);
		
		$result=$this->db->update('pharma_brand', $data,$condition);
		
		if($result) {
			return  $this->lang->line('delete_success');
		}else{
			return  $this->lang->line('delete_failed');
		}
	}

	function countCategory($search = null){
	
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		 $this->db->where('status','0');
         $this->db->order_by('category','asc');
		 $query = $this->db->get('pharma_brand_category');
		 
		 return $query->num_rows();
	
	}
	function getCategory($search = null,$limit = null)
    {
    	if(!empty($limit)){

            $limit=explode(",",$limit);

		}
	

		$options = array();
		$i=0;
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('status','0');
		$this->db->order_by('category','asc');

        if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_brand_category');
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->category;			
			$options[$i][2] = $row->status;
			$i++;
		}
		return $options;
		
    }
	
	function createCategory(){
	
		$data 				= array('category' => $this->input->post('category_name'));
		
		$result=$this->db->insert('pharma_brand_category', $data);
		
		if($result) {
			return $this->db->insert_id();
		}else{
			return  $this->lang->line('add_failed');
		}
		
	}
	
	function updateCategory(){
	
		$condition				= array('id' => $this->input->post('id'));
		$data 				= array('category' => $this->input->post('category_name'));
		
		$result=$this->db->update('pharma_brand_category', $data,$condition);
	}
	function deleteCategory($id){
	
		$condition				= array('id' => $id);
		$data 				= array('status' => 1);
		
		$result=$this->db->update('pharma_brand_category', $data,$condition);
	}

    function totalLowInventory(){

        $sql="SELECT * FROM `hcare_pharma_brand` `a` JOIN `hcare_pharma_batch` `b` ON `a`.`id` = `b`.`brand_id` WHERE (`a`.`brand_stock` < `a`.`re_order_level` or `a`.`brand_stock` =0) AND `b`.`branch_id` =0 AND `a`.`status` = '0' AND `b`.`status` = '0' GROUP BY `b`.`brand_id`";

        $query = $this->db->query($sql);

        return $query->num_rows();
        
    }
   
    function brandStocks_and_price($search = null){

    	$i=0;
    	$options=array();

    	if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->where('status','0');
		$this->db->order_by("brand", "asc"); 

        $query = $this->db->get('pharma_brand');

        // echo $this->db->last_query();
		
		$total_brand_stock=0;
        $total_brand_stock_sellp=0;
        $total_brand_stock_buyp=0;

		$total_branch_stock=0;
		$total_branch_stock_sellp=0;
		$total_branch_stock_buyp=0;

		foreach ($query->result() as $row)
		{
			
			$sellp = $row->sellp;
			$buyp = $row->buyp;
			
			$brand_stock = $row->brand_stock;
			$total_brand_stock += $brand_stock;
			$total_brand_stock_sellp += ($brand_stock * $sellp);
			$total_brand_stock_buyp += ($brand_stock * $buyp);

			$branch_stock = $row->branch_stock;
			$total_branch_stock += $branch_stock;
			$total_branch_stock_sellp += ($branch_stock * $sellp);
			$total_branch_stock_buyp += ($branch_stock * $buyp);
			
			$i++;
		}

		    $options[0]= $total_brand_stock;
		    $options[1]= $total_brand_stock_sellp;
		    $options[2]= $total_brand_stock_buyp;
		    $options[3]= $total_branch_stock;
		    $options[4]= $total_branch_stock_sellp;
		    $options[5]= $total_branch_stock_buyp;

		    return $options;
    }

    function searchDailyStock($search = null){

        $i=0;
    	$options=array();

    	if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}

		$this->db->order_by("id", "asc"); 

        $query = $this->db->get('pharma_daily_stock_history');

		foreach ($query->result() as $row)
		{
			
			$options[$i][0]=$row->date;
			$options[$i][1]=$row->main_stock;
			$options[$i][2]=$row->main_stock_sellp;
			$options[$i][3]=$row->main_stock_buyp;
			$options[$i][4]=$row->branch_stock;
			$options[$i][5]=$row->branch_stock_sellp;
			$options[$i][6]=$row->branch_stock_buyp;
			
			$i++;
		}

		return $options;

    }
	function update_brand($brand_id,$buyp,$sellp,$brand_stock,$branch_stock){

		$sql = "UPDATE `hcare_pharma_brand` SET `sellp`='".$sellp."', `buyp`='".$buyp."', `brand_stock`=`brand_stock`+'".$brand_stock."', `branch_stock`=`branch_stock`+'".$branch_stock."' WHERE id='".$brand_id."'";

		$query = $this->db->query($sql);


	}
	function create_brand($brand,$hsn_no,$selling_unit,$price_type,$gst_per=null){

		$sql = "INSERT INTO `hcare_pharma_brand`(`brand`, `hsn_no`, `selling_unit`, `price_type`, `status`,`gst_per`) VALUES ('".$brand."','".$hsn_no."','".$selling_unit."','".$price_type."','0','".$gst_per."')";

		$query = $this->db->query($sql);

		return $this->db->insert_id();


	}
	function updateBrandHsn($brand_id,$hsn_no){
	
		$condition= array('id' => $brand_id);
		
		$data['hsn_no']	=$hsn_no;

		$result=$this->db->update('pharma_brand', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}
	 function countBrandAll($search = null){
	
		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
		 $query = $this->db->get('pharma_brand');
		 
		 return $query->num_rows();
	
	}

	   function getBrandAll($search = null,$limit=null,$offset=null,$date=null)
    {  

    	if(!empty($limit)){

            $limit=explode(",",$limit);

		}

		$options = array();
		$i=0;		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
		$this->db->order_by("brand", "asc"); 
		
		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

        $query = $this->db->get('pharma_brand');

        // echo $this->db->last_query();
		
		foreach ($query->result() as $row)
		{
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->brand;
			$options[$i][2] = $row->generic_name;			
			// $options[$i][3] = $row->manufacturer ;
			// $options[$i][4] = $row->category_id;
			// $options[$i][5]=  $this->commonDBFunctions->getidToValue('category','id',$row->category_id,'pharma_brand_category');
			// $options[$i][6] = $row->selling_unit  ;
			// $options[$i][7] = $row->tablet_per_strip;
			// $options[$i][8] = $row->strip_per_pack;
			// $options[$i][9] = $row->price_type;
			// $options[$i][10] = $row->sellp;
			// $options[$i][11] = $row->buyp;
			// $options[$i][12] = $row->brand_stock;
			// $stock_conversion=tab_to_pack($row->brand_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			// $options[$i][13]=$stock_conversion[0];
			// $options[$i][14]=$stock_conversion[1];
			// $options[$i][15]=$stock_conversion[2];
			
			// $options[$i][16] = $row->re_order_level;
			// $options[$i][17] = $row->description;
			// $options[$i][18] = $row->status;
			// $options[$i][19] = $row->branch_stock;
			
			// $stock_conversion=tab_to_pack($row->branch_stock,$row->tablet_per_strip,$row->strip_per_pack);
			
			// $options[$i][20]=$stock_conversion[0];
			// $options[$i][21]=$stock_conversion[1];
			// $options[$i][22]=$stock_conversion[2];
			// $options[$i][23]=$row->shelf_number;
			// $options[$i][24]=$row->hsn_no;
			// $options[$i][25]=$row->h1n_sheduled_x;
			// $options[$i][26]=$row->cancellation_date;
			// CHECK BRANDS IN ITEM HISTORY
			// $in_item_history=$this->commonDBFunctions->in_item_history($row->id);
			// if(empty($in_item_history)){
			// $options[$i][27]= 'NO';
			// }else{
			// $options[$i][27]= 'YES';
			// }
			$options[$i][28]=$this->getItemHistoryOnDate($row->id,$date);
			// var_dump($options[$i][28]);
			
			$i++;
		}

		return $options;
		
    }
     function getItemHistoryOnDate($brand_id = null,$date=null)
    {
		$itemInfo = array();
		$i=0;		
	
		$sql='SELECT *
				FROM hcare_pharma_item_history
				WHERE `brand_id` ="'.$brand_id.'"
				AND id = (
				SELECT MAX( `id` )
				FROM hcare_pharma_item_history
				WHERE `brand_id` ="'.$brand_id.'" AND `date`  <= "'.$date.' 23:59:59" )';
		
		// var_dump($sql);

        $query = $this->db->query($sql);
		 // echo $this->db->last_query(); 
		foreach ($query->result() as $row)
		{
				// $itemInfo[$i][0]= $row->id ;
				// $itemInfo[$i][1]= $row->brand_id;
				$itemInfo[$i][0]= $row->new_stock_brand;
				$itemInfo[$i][1]= $row->new_stock_branch;
				// $itemInfo[$i][4]= $row->date;
				// $itemInfo[$i][5]= $row->brand_name;
				
			
			$i++;
		}
		return $itemInfo;
		
    }

    function getMedicineDoctorWise($search,$limit=null,$offset=null){

    	       if(!empty($limit)){

            $limit=explode(",",$limit);

	   }

	   $options = array();
		$i=0;
	  $this->db->select('a.`id`,a.`cust_type`,a.`doctor`,a.`doc_id`,a.`cust_name`,b.`id` as items_id,b.`bill_date`,b.`item_id`,b.`batch_id`,b.`sales_mode`,b.`batch_no`,b.`hsn_no`,b.`expiry`,b.`selling_unit`,b.`quantity`,b.`sellp`,b.`mrp`,b.`gst_per`,b.`total`,a.`op_no`,a.`ip_no`');
      $this->db->from('hcare_pharma_invoice a');
      $this->db->join('hcare_pharma_invoice_items b', 'a.`id` = b.`bill_id`');
	  if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');
		$this->db->where('a.`doc_id > 0');
		$this->db->order_by("b.id", "asc"); 
	  // $this->db->group_by("b.brand_id");
	  
		if($limit !=''){
		
		   $this->db->limit($limit[1],$limit[0]);
		}

      $query = $this->db->get();
	  // echo $this->db->last_query();
	    foreach ($query->result_array() as $row)
		{
		
		 $options[$i][0] = $row['id'];	
		 $options[$i][1] = $row['cust_type'];
		 $options[$i][2] = $row['doctor'];
		 $options[$i][3] = $row['doc_id'];
		 $options[$i][4] = $row['cust_name'];
		 $options[$i][5] = $row['items_id'];
		 $options[$i][6] = $row['bill_date'];
		 $options[$i][7] = $row['item_id'];
		 $options[$i][8] = $row['batch_id'];
		 $options[$i][9] = $row['sales_mode'];
		 $options[$i][10] = $row['batch_no'];
		 $options[$i][11] = $row['hsn_no'];
		 $options[$i][12] = $row['expiry'];
		 $options[$i][13] = $row['selling_unit'];
		 $options[$i][14] = $row['quantity'];
		 $options[$i][15] = $row['sellp'];
		 $options[$i][16] = $row['mrp'];
		 $options[$i][17] = $row['gst_per'];
		 $options[$i][18] = $row['total'];
		 $options[$i][19]=$this->commonDBFunctions->getidToValue('brand','id',$options[$i][7],'hcare_pharma_brand');
		 $options[$i][20] = $row['op_no'];
		 $options[$i][21] = $row['ip_no'];

		 
		 $i++;
		
		}
		 // var_dump($options);
	return $options;

    }

    	function countMedicineDoctorWise($search = null){
	
		$options = array();
		$i=0;		
		$this->db->from('hcare_pharma_invoice a');
        $this->db->join('hcare_pharma_invoice_items b', 'a.`id` = b.`bill_id`');
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		$this->db->where('a.status','0');
		$this->db->where('a.`doc_id > 0');
		
		$this->db->order_by("b.id", "asc");
		 $query = $this->db->get();
		// echo $this->db->last_query(); 
		 return $query->num_rows();
	
	}

	function getManufacturer($sql)
    {   
		$options = array();
		$i=0;		
	    
	    $query = $this->db->query($sql);

		foreach ($query->result() as $row)
		 {
			$options[$i][0] = $row->id;
			$options[$i][1] = $row->manufacturer;
						
			
			$i++;
		 }

		return $options;
    }

      function updateBrandBranchStock($id=null,$brand_stock=null,$branch_stock=null){
	
		$condition= array('id' => $id);
			
		  $data['brand_stock']	=$brand_stock;
		  $data['branch_stock']	=$branch_stock;

		$result=$this->db->update('pharma_brand', $data,$condition);
		
		if($result) {
			return  $this->lang->line('update_success');
		}else{
			return  $this->lang->line('update_failed');
		}
	}



}
?>
