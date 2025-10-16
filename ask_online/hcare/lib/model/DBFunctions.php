<?php 
require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';


class DBFunction{

	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
	}

	function getCountries(){
	
			$arrList=array();
			$query=$this->dbConnection->BuiltQuery("hcare_countries");	
			$result=$this->dbConnection->executeQuery($query);
			
			$i=0;
		
			if(mysqli_num_rows($result)>0){
						
				while($row=$result -> fetch_assoc()){
				
					$arrList[$i][0]=$row['id'];
					$arrList[$i][1]=$row['country'];
					$i++;
				}	
			}
			
			return $arrList;
	}
	
	public function getDoctorPrescribedTest($opid){
	
			$wheredata[0]="opid = '".$opid."'";
			$query=$this->dbConnection->BuiltQuery("hcare_doc_page",'',$wheredata);	
			$result=$this->dbConnection->executeQuery($query);
			$row='';
			if(mysqli_num_rows($result)>0){
			
				$row=$result -> fetch_assoc();
				
				
			}
			
			return $row;
	}
	public function getidToValue($field,$where_field,$value,$table){
	
		$result=$this->dbConnection->idToValue($table,$field,$where_field,$value);
		
		return $result;
	}
	
	function isValidCatagory($test)
	{
	
			$wheredata[0]="test_name = '".$test."'";
			 $query=$this->dbConnection->BuiltQuery("hcare_lab_element",'',$wheredata);	
			$result=$this->dbConnection->executeQuery($query);
			
			if(mysqli_num_rows($result)>0){
			
				return true;
			}else return false;
	
	}
	function isValidTest($test)
	{
	
			$wheredata[0]="test_name = '".$test."'";
			$query=$this->dbConnection->BuiltQuery("hcare_lab_test",'',$wheredata);	
			$result=$this->dbConnection->executeQuery($query);
			
			if(mysqli_num_rows($result)>0){
			
				return true;
			}else return false;
	
	}
	function tab_to_pack($quantity,$t_per_s,$s_per_p){

	  if(empty($t_per_s)){
		  $t_per_s=1;
	  }
	  if(empty($s_per_p)){
		$s_per_p=1;
	  }
	
	//commented for koyas
	//$pack=floor( $quantity / (  $t_per_s  * $s_per_p ) );
	
	//$remaining_qty= $quantity -( $pack * $t_per_s  * $s_per_p );
	
	//for koyas
	  $pack=0;
	  $remaining_qty= $quantity;
	
	  if( $remaining_qty >=  $t_per_s ) {
	
			$strips = round ( $remaining_qty / $t_per_s ,0);
			$tablets = $remaining_qty  % ( $t_per_s );

	  }else{
	
			$tablets = $remaining_qty;
			$strips=0;

	  }
	
	  return array($pack,$strips,$tablets);

    }
    function pack_to_tab($pack,$strips,$tablets,$t_per_s,$s_per_p){

	  if($pack == '' ) $pack=0;
	  if($strips == '' ) $strips=0;
	  if($tablets == '' ) $tablets=0;
	  $quantity=($pack * $t_per_s * $s_per_p) + ($strips * $t_per_s) + $tablets;
	
	  return $quantity;

    }
	public function convert_stock_format($brand_id,$selected,$stock = null,$pack = null,$strips = null,$tablets = null){
	
			$t_per_s=$this->getidToValue('tablet_per_strip','id',$brand_id,'hcare_pharma_brand');
			$s_per_p=$this->getidToValue('strip_per_pack','id',$brand_id,'hcare_pharma_brand');
			
			if($selected == 1) {
				return $this->tab_to_pack($stock,$t_per_s,$s_per_p);
			}
			
			if($selected == 2) {
				return $this->pack_to_tab($pack,$strips,$tablets,$t_per_s,$s_per_p);
			}
	
	}
	function display_in_pack($pack,$strips,$tablets){

	    $display=0;
	  if($pack > 0){
		 //$display.=$pack."P ";
		
		 $display+=$pack;
	    }
	    if($strips > 0){
	
		 //$display.=$strips."S ";
		 $display+=$strips;
	    }
	    if($tablets > 0){
	
		 //$display.=$tablets."T ";
		 $display+=$tablets;
	    }
	 return $display;
    }
    public function total_amount_sold($search){

    	$select_field[]="sum(total)";
        $search[]="status =0";

        $query=$this->dbConnection->BuiltQuery('hcare_pharma_invoice_items',$select_field,$search,'id','asc','',$limit);

        $result=$this->dbConnection->executeQuery($query);

         $row=$result -> fetch_assoc();
          
		   return $row['sum(total)'];
    }
    public function total_amount_sold_receivings($search){
     
    	$select_field[]="sum(total)";

        $query=$this->dbConnection->BuiltQuery('hcare_pharma_recievings_items',$select_field,$search,'id','asc','',$limit);

        $result=$this->dbConnection->executeQuery($query);

         $row=$result -> fetch_assoc();
          
		   return $row['sum(total)'];
    }
    function to_currency($number){
	 //$CI =& get_instance();
	 //$currency=$CI->commonDBFunctions->getidToValue('currency','id',1,'hospital_info');
	  if($number >= 0)
	      {
		    return number_format($number, 2, '.', '');
          }
      else
          {
    	     return '-'.number_format(abs($number), 2, '.', '');
          }
    }
	public function getIdToValueMultiple($field,$where_field,$table){
	
		$result=$this->dbConnection->idToValueMultiple($field,$where_field,$table);
		
		return $result;
	}

}
?>