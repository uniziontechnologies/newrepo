<?php
class CommonDBFunctions extends CI_Model {

   

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getCountries($search = null,$dropdown = null){
	
			$options = array();
			$i=0;
		
		
		if(!empty($search)){
			for($k=0;$k<count($search);$k++){
			
				$this->db->where($search[$k]);
			
			}
		}
		
		$this->db->order_by('id','asc');
        $query = $this->db->get('countries');
		
		if($dropdown !=''){
			foreach ($query->result() as $row)
			{
				$options[$row->country] = $row->country;
			}
			
		}else{
			foreach ($query->result() as $row)
			{
				$options[$i][0] = $row->id;
				$options[$i][1] = $row->country;		
				
				$i++;
			}
		}
		return $options;
	}
    function getCategory($search = null,$dropdown = null)
    {
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
		
		if($dropdown !=''){
		
		$options[0] = '------select------';
			foreach ($query->result() as $row)
			{
				$options[$row->id] = $row->category;
			}
			
		}else{
			foreach ($query->result() as $row)
			{
				$options[$i][0] = $row->id;
				$options[$i][1] = $row->category;		
				$options[$i][2] = $row->status;
				$i++;
			}
		}
		return $options;
		
    }
	public function getidToValue($field,$where_field,$value,$table){
	
		$this->db->select($field);
		$this->db->where($where_field,$value);
		$query = $this->db->get($table);
		$row= $query->row_array();
		if(!empty($row)) {
		
					 
			return  $row[$field];
		}else return '';
		
	
	}
	public function getidToValue_multiple($field,$where_field,$table){
	
		$this->db->select($field);
		// $this->db->where($where_field,$value);

		if(!empty($where_field)){
		
			for($i=0;$i<count($where_field);$i++){
				
				$this->db->where($where_field[$i]);
			}
		}

		$query = $this->db->get($table);
		// echo $this->db->last_query();
		$row= $query->row_array();
		if(!empty($row)) {
		
					 
			return  $row[$field];
		}else return '';
		
	
	}
	public function convert_stock_format($brand_id,$selected,$stock = null,$pack = null,$strips = null,$tablets = null){
	
			$t_per_s=$this->commonDBFunctions->getidToValue('tablet_per_strip','id',$brand_id,'pharma_brand');
			$s_per_p=$this->commonDBFunctions->getidToValue('strip_per_pack','id',$brand_id,'pharma_brand');
			
			if($selected == 1) {
				return tab_to_pack($stock,$t_per_s,$s_per_p);
			}
			
			if($selected == 2) {
				return pack_to_tab($pack,$strips,$tablets,$t_per_s,$s_per_p);
			}
	
	}
	public function convert_price_type($brand_id,$mode,$price_type = null,$sellp = null,$buyp = null){
	
								
				$t_per_s=$this->commonDBFunctions->getidToValue('tablet_per_strip','id',$brand_id,'pharma_brand');
				$s_per_p=$this->commonDBFunctions->getidToValue('strip_per_pack','id',$brand_id,'pharma_brand');
				
				if(empty($sellp) && empty($buyp)){
					
					$price_type=$this->commonDBFunctions->getidToValue('price_type','id',$brand_id,'pharma_brand');
					$sellp=$this->commonDBFunctions->getidToValue('sellp','id',$brand_id,'pharma_brand');
					$buyp=$this->commonDBFunctions->getidToValue('buyp','id',$brand_id,'pharma_brand');
				}
				//echo $price_type ;
				//echo $sellp;
				if($price_type == "PACK"){
				
					if($mode == "STRIP"){
					
						$sellp =$sellp/$s_per_p;
						$buyp =$buyp/$s_per_p;
					}
					
					if($mode == "TABLET"){
					
						$sellp =$sellp/($s_per_p*$t_per_s);
						$buyp =$buyp/($s_per_p*$t_per_s);
					}
				
				
				}else if($price_type == "STRIP"){
				
					if($mode == "PACK"){
					
						$sellp =$sellp *$s_per_p;
						$buyp =$buyp*$s_per_p;
					}
					
					if($mode == "TABLET"){
					
						$sellp =$sellp/$t_per_s;
						$buyp =$buyp/$t_per_s;
					}
				
				
				}else if($price_type == "TABLET"){
				
					if($mode == "PACK"){
					
						$sellp =$sellp *$s_per_p*$t_per_s;
						$buyp =$buyp*$s_per_p;
					}
					
					if($mode == "STRIP"){
					
						$sellp =$sellp*$t_per_s;
						$buyp =$buyp*$t_per_s;
					}
				
				
				}
				
					$sellp=to_round($sellp);
					$buyp=to_round($buyp);
					
					$sellp=to_currency($sellp);
					$buyp=to_currency($buyp);
				
				
				
				return array($sellp,$buyp);
	
	}
	public function convert_price_type_batch($brand_id,$batch_id,$mode,$price_type = null,$sellp = null,$buyp = null){
	
								
				$t_per_s=$this->commonDBFunctions->getidToValue('tablet_per_strip','id',$brand_id,'pharma_brand');
				$s_per_p=$this->commonDBFunctions->getidToValue('strip_per_pack','id',$brand_id,'pharma_brand');
				
				if(empty($sellp) && empty($buyp)){
					
					$price_type=$this->commonDBFunctions->getidToValue('price_type','id',$batch_id,'pharma_batch');
					$sellp=$this->commonDBFunctions->getidToValue('sellp','id',$batch_id,'pharma_batch');
					$buyp=$this->commonDBFunctions->getidToValue('buyp','id',$batch_id,'pharma_batch');
				}
				//echo $price_type ;
				//echo $sellp;
				if($price_type == "PACK"){
				
					if($mode == "STRIP"){
					
						$sellp =$sellp/$s_per_p;
						$buyp =$buyp/$s_per_p;
					}
					
					if($mode == "TABLET"){
					
						$sellp =$sellp/($s_per_p*$t_per_s);
						$buyp =$buyp/($s_per_p*$t_per_s);
					}
				
				
				}else if($price_type == "STRIP"){
				
					if($mode == "PACK"){
					
						$sellp =$sellp *$s_per_p;
						$buyp =$buyp*$s_per_p;
					}
					
					if($mode == "TABLET"){
					
						$sellp =$sellp/$t_per_s;
						$buyp =$buyp/$t_per_s;
					}
				
				
				}else if($price_type == "TABLET"){
				
					if($mode == "PACK"){
					
						$sellp =$sellp *$s_per_p*$t_per_s;
						$buyp =$buyp*$s_per_p;
					}
					
					if($mode == "STRIP"){
					
						$sellp =$sellp*$t_per_s;
						$buyp =$buyp*$t_per_s;
					}
				
				
				}
				
					$sellp=to_round($sellp);
					$buyp=to_round($buyp);
					
					$sellp=to_currency($sellp);
					$buyp=to_currency($buyp);
				
				
				
				return array($sellp,$buyp);
	
	}

}
?>
