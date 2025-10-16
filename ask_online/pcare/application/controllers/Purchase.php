<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends CI_Controller {

function __construct()
{
// Call the Model constructor
parent::__construct();
date_default_timezone_set('Asia/Kolkata');
}

function purchase_form()
{
//process data
$data=$this->processPurchaseForm();


$data['paction']=isset($data['paction'])?$data['paction']:'Save';
//$data['recid']=isset($data['recid'])?$data['recid']:'';
$data['itemfocus']=$this->input->post('item_focus');

//supplier info
$this->load->model('supplier');

$search[]="status = 0";
$data['supplier']=$this->supplier->getSupplier($search); 

//gst model
$this->load->model('gst_model');
$search_gst[]="status = 0";
$data['gst_class']=$this->gst_model->getGstInfo($search_gst);



$data['error_message']='';//$error_message;


//purchase form view
$this->load->view('purchase/purchase_form',$data);
}

function processPurchaseForm(){

//process form

$itemcount=$this->input->post('item_count');
$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
$item_loc=$this->input->post('item_loc');
$items_in_array=array();


//PROCESS EXISTING ARRAY

$purchase_amt=0;
$total_gst=0;
$total_cgst=0;
$total_sgst=0;
$total_bill =0;
$round_amt=0;
$roundstatus=0;
// $vat_inc=0;
// $igst=0;

if($itemcount > 0 ){
       
for($i=0;$i<$itemcount;$i++){


if($item_loc!="" && $item_loc == $i){

//Request to remove the item
//So  Exclude the item 
}else{

$item=$this->input->post('item');

//var_dump($item);

$qty=$item[$i][6];
$foc=$item[$i][7];			
$buyp=$item[$i][9];
$disc_type=$item[$i][10];
$disc_value=$item[$i][11];
$sellp=$item[$i][8];				
$brand_id=$item[$i][0];
$tpers=$item[$i][5];
// $vat_inc=$item[$i][17];
// $igst=$item[$i][21];

if(empty($item[$i][17])){

 $item[$i][17]='';
}
if(empty($item[$i][21])){

 $item[$i][21]='';
}

$buyp_bef_foc=$buyp;
//End discount calculation

//End Foc Calculations
$total=$qty*$buyp_bef_foc;

//Start discount calculation
if($disc_type =='CASH' && $disc_value>0){

$total=$total-$disc_value;
}else if($disc_type =='%' && $disc_value>0){

$total=$total-($total*($disc_value/100));;
}

/*...... gst calculation ......*/	


if(!empty($item[$i][12]))
{
 
$cgst_per=$this->commonDBFunctions->getidToValue('cgst','id',$item[$i][12],'pharma_gst');
$sgst_per=$this->commonDBFunctions->getidToValue('sgst','id',$item[$i][12],'pharma_gst');
$gst_per=$this->commonDBFunctions->getidToValue('gst','id',$item[$i][12],'pharma_gst');

 
$cgst_amt=$cgst_per*($total/100);
$cgst_amt=to_currency($cgst_amt);

$sgst_amt=$sgst_per*($total/100);
$sgst_amt=to_currency($sgst_amt);

$gst_amt=$cgst_amt+$sgst_amt;
$gst_amt=to_currency($gst_amt);

/*... Vat Include ...*/
if(!empty($item[$i][17]) && ($item[$i][17]==1))
	  {
	  	$cgst_amt='';
    $sgst_amt='';
    $gst_amt='';
	  }
/*... Vat Include ...*/
/*... IGST...*/
if (!empty($item[$i][21]) && ($item[$i][21]==1)) {

	   $igst_per=$gst_per;

	  	$cgst_per='';
	  	$sgst_per='';
	  	$cgst_amt='';
    $sgst_amt='';

    $igst_amt=$gst_amt;

    $total=$total+$igst_amt;
     $total_gst+=$igst_amt;
    
	 // var_dump($total);

	  }
/*... IGST ...*/

  else{
     $total=$total+$gst_amt;
      $total_gst+=$gst_amt;
     //var_dump($total);
  }
 
  $total_cgst+=$cgst_amt;
  $total_sgst+=$sgst_amt;
  

}
else{
$gst_amt='';
$cgst_amt='';
$sgst_amt='';
$igst_amt='';
} 


if (!empty($item[$i][21]) && ($item[$i][21]==1)) {
$item[$i][13]=$igst_amt;
}else {
$item[$i][13]=$gst_amt;
}
$item[$i][14]=$cgst_amt;
$item[$i][15]=$sgst_amt;				
/*...... gst calculation ......*/


$sellp=to_currency($sellp);
$buyp=to_currency($buyp);
$item[$i][16]=$total=to_currency($total);	

$items_in_array[]=array($item[$i][0],$item[$i][1],$item[$i][2],$item[$i][3],$item[$i][4],$item[$i][5],$item[$i][6],$item[$i][7],$item[$i][8],$item[$i][9],$item[$i][10],$item[$i][11],$item[$i][12],$item[$i][13],$item[$i][14],$item[$i][15],$item[$i][16],$item[$i][17],'','',$item[$i][20],$item[$i][21]);

$purchase_amt +=($qty*$buyp_bef_foc);
$total_bill = $total_bill+$total;				

}
}
}

$data['purchase_amt']=$purchase_amt;
$data['tot_gst']=$total_gst;
$data['tot_cgst']=$total_cgst;
$data['tot_sgst']=$total_sgst;

//calculate frieght

$data['frieght']=$frieght=$this->input->post('frieght');

if($frieght > 0 ){
$total_bill = $total_bill+$frieght;
}

$data['total_bill']=to_currency($total_bill);

//Calculate Discount

$data['discount_type']=$discount_type=$this->input->post('bill_disc_type');
$data['discount_value']=$discount_value=$this->input->post('bill_disc_value');
$discount_amt=0;

if(!empty($discount_type) && ($discount_value > 0) && $total_bill != 0){



if($discount_type == 'CASH'){

$discount_amt=$discount_value;

}else{
$discount_amt=$total_bill *($discount_value/100);
}
}
$data['discount_amt']=to_currency($discount_amt);

if($discount_amt >0 && $total_bill>0) {

$net_amt= $total_bill - $discount_amt;
}else if($discount_amt >0 && $total_bill<0) {

$net_amt= $total_bill + $discount_amt;
}else{

$net_amt= $total_bill;
}

$data['net_amt']=to_currency($net_amt);
$data['po_no']=$this->input->post('pono');
$data['bill_no']=$this->input->post('bill_no');
$data['bill_date']=$this->input->post('bill_date');
$data['payment_type_selected']=$this->input->post('payment_type');
$data['checque_no']=$this->input->post('checque_no');
$data['checque_amt']=$this->input->post('checque_amt');
$data['card_amt']=$this->input->post('card_amt');
$data['remarks']=$this->input->post('remarks');
$data['paction']=$this->input->post('paction');
$data['purchase_mode_selected']='Recievings';
$data['supplier_selected']=$this->input->post('supplier');
$data['upi_amt']=$this->input->post('upi_amt');
/*...... New Supplier ......*/

$newsupplier=$this->input->post('newsupplier');
if(!empty($newsupplier)){

$data['supplier_selected']=$newsupplier;
}

/*...... New Supplier ......*/		

$data['purchase_id']=$this->input->post('purchase_id');
$data['purchase_status']=$this->input->post('purchase_status');
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

//Adding new items to array

$brand_name=$this->input->post('brand');
$id=$this->input->post('brand_ID');

if(!empty($brand_name)){

if(!empty($id)){

$unit=$this->commonDBFunctions->getidToValue('selling_unit','id',$id,'pharma_brand');
$sellp=$this->commonDBFunctions->getidToValue('sellp','id',$id,'pharma_brand');
$buyp=$this->commonDBFunctions->getidToValue('buyp','id',$id,'pharma_brand');

$hsn_no=$this->commonDBFunctions->getidToValue('hsn_no','id',$id,'pharma_brand');
$gst_class=$this->commonDBFunctions->getidToValue('gst_per','id',$id,'pharma_brand');

$batch='';
$expiry='';
$tpers='';
$qty='';
$foc='';
$disc_type='';
$disc_value='';
//$gst_class='';
$gst_amt='';
$cgst_amt='';
$sgst_amt='';
$total='';
$vat_inc='';
$igst='';

$items_in_array[]=array($id,$brand_name,$batch,$expiry,$unit,$tpers,$qty,$foc,$sellp,$buyp,$disc_type,$disc_value,$gst_class,$gst_amt,$cgst_amt,$sgst_amt,$total,$vat_inc,'','',$hsn_no,$igst);

}


}else{
$data['message']="Invalid Brand Selected";


}
$data['items_in_array']=$items_in_array;
$data['itemcount']=count($items_in_array);

return $data;
}

public function add_purchase($auth_user_id=null){

//load model info
$this->load->model('purchase_model');
$this->load->model('brand_model');
$this->load->model('batch_model');
$this->load->model('item_history_model');

$payment_type=$this->input->post('payment_type');
$net_total=$this->input->post('net_total');
$rounded_net_total=$this->input->post('round_net_amt');
$amount_paid=$this->input->post('amount_paid');
$paction=$this->input->post('paction');

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

$status=0;

if($paction == "Update"){

$result=$this->purchase_model->UpdatePurchase($balance,$status,$auth_user_id);
}else{

$result=$this->purchase_model->addPurchase($balance,$status,$auth_user_id);
}

if($result > 0 ) {

$bill_id=$result;

$itemcount=$this->input->post('item_count');

if($itemcount > 0 ){

if($paction == "Update"){
$this->purchase_model->delete_purchase_items($bill_id);
$this->batch_model->delete_current_batch_items($bill_id,'','','P');
}

for($i=0;$i<$itemcount;$i++){

$item=$this->input->post('item');

$buyp_foc=0;
//start foc calculation
if($item[$i][6] >0 && $item[$i][7]>0){

$buyp_foc=($item[$i][6]*$item[$i][9])/($item[$i][6]+$item[$i][7]);
}

$rec_item_id=$this->purchase_model->addPurchaseItems($item[$i],$buyp_foc,$status,$bill_id);

$batchInfo['brand_id'] = $item[$i][0];
$batchInfo['purchase_id'] = $bill_id;
$batchInfo['batch_number'] = $item[$i][2];



/*... MM/YY format convert to DD-MM-YYYY ...*/

$expiry_field = $item[$i][3];
$expiry_field = str_replace('/', '-', $expiry_field);
$newDate = explode( "-" , $expiry_field);
$output = $newDate[1]."-".$newDate[0]."-".'1';
// $output = '1'."-".$newDate[0]."-".$newDate[1];
// $item[$i][3]=date("t-m-Y", strtotime($output));

// $date = date_create_from_format('d-m-Y', $output);

$year_obj = DateTime::createFromFormat('y', $newDate[1]);
$year = $year_obj->format('Y');
$month = $newDate[0];
$date = "1";

$s = $date."/".$month."/".$year;
$date = date_create_from_format('d/m/Y', $s);
$output = $date->format('Y-m-t');
$item[$i][3] = $output;
// $date->getTimestamp();



/*... MM/YY format convert to DD-MM-YYYY ...*/

/*$expiry_field = $item[$i][3];
$expiry_field = str_replace('/', '-', $expiry_field);
$newDate = explode( "-" , $expiry_field);
$output = $newDate[1]."-".$newDate[0]."-".'1';
$item[$i][3]=date("t-m-Y", strtotime($output));*/

/*... MM/YY format convert to DD-MM-YYYY ...*/

$batchInfo['expiry_date'] = $item[$i][3];
//var_dump(expression)
$batchInfo['supplier_id'] = $this->input->post('supplier');

if($item[$i][4] == "STRIP") {

$tpers=$item[$i][5];
$qty=$tpers*$item[$i][6];
if($item[$i][7] > 0){
 $qty +=$tpers*$item[$i][7];//foc
}

$batchInfo['batch_stock'] = $qty;


//convert price to nos
$item[$i][8]=round($item[$i][8]/$tpers,2);//sellp
$item[$i][9]=round($item[$i][9]/$tpers,2);//buyp
$item[$i][4]="NOS";
}else{

$qty=$item[$i][6];
if($item[$i][7] > 0){
 $qty +=$item[$i][7];//foc
}

$batchInfo['batch_stock'] = $qty;

}
$batchInfo['price_type'] = $item[$i][4];
$batchInfo['sellp'] = $item[$i][8];
$batchInfo['buyp'] = $item[$i][9];
$batchInfo['description'] = '';

if(!empty($item[$i][12])){

$batchInfo['gst_id'] = $item[$i][12];
$batchInfo['gst_per'] = $this->commonDBFunctions->getidToValue('gst','id',$item[$i][12],'pharma_gst');
$batchInfo['cgst_per'] = $this->commonDBFunctions->getidToValue('cgst','id',$item[$i][12],'pharma_gst');
$batchInfo['sgst_per'] = $this->commonDBFunctions->getidToValue('sgst','id',$item[$i][12],'pharma_gst');
$batchInfo['gst_amt'] = $item[$i][13];
$batchInfo['sgst_amt'] = $item[$i][14];
$batchInfo['cgst_amt'] = $item[$i][15];

}else{

$batchInfo['gst_id'] ='';
$batchInfo['gst_per'] ='';
$batchInfo['cgst_per'] ='';
$batchInfo['sgst_per'] ='';
$batchInfo['gst_amt'] ='';
$batchInfo['sgst_amt'] ='';
$batchInfo['cgst_amt'] ='';
}


$batch_id=$this->batch_model->create($batchInfo,"RECIEVINGS_ADD");

//add status of purchase and movement  p and M
$this->batch_model->Update_p_m_Status($batch_id,"P");

if($batch_id >0 ) {				
//if batch updation success	
$brand_id=$batchInfo['brand_id'];
$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

$new_brand_stock=$this->batch_model->getMainStock($brand_id);

$this->brand_model->update_stock($brand_id,$new_brand_stock,$batchInfo['price_type'],$batchInfo['sellp'],$batchInfo['buyp']);

$new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);  
$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch'); 

//add info to history
$message2=$this->purchase_model->add_batchid($rec_item_id,$batch_id);


if (!empty($item[$i][20])) {

$brand_hsn = $this->commonDBFunctions->getidToValue('hsn_no','id',$brand_id,'pharma_brand');

if ($item[$i][20] != $brand_hsn) {

	$this->brand_model->updateBrandHsn($brand_id,$item[$i][20]); 
	
}

}


//add to item history

$info['brand_id']=$batchInfo['brand_id'];
$info['batch_id']=$batch_id;
$info['type']=$batchInfo['price_type'];
$info['quantity']= $batchInfo['batch_stock'];
$info['old_stock_batch']=0;
$info['new_stock_batch']=$batchInfo['batch_stock'];
$info['old_stock_brand']=$brand_stock;
$info['new_stock_brand']=$new_brand_stock;
$info['action']="ADD";
$info['mode']="RECIEVINGS_ADD";
$info['reference_id']=$bill_id;
$info['expiry_date']=$batchInfo['expiry_date'];
$info['new_expiry_date' ]=$this->commonDBFunctions->getidToValue('expiry_date','id',$info['batch_id'],'pharma_batch');
$info['branch_id']=0;//branch id
$info['old_stock_branch']=$branch_stock;
$info['new_stock_branch']=$new_branch_stock;
$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

$info['brand_name']=$brand_name;
$info['batch_number']=$batch_name;
$this->item_history_model->add_history($info);

}

}
}
// $this->print_purchase($bill_id);
redirect('purchase/print_purchase/'.$bill_id);
}else{
$data['message']="Failed to Add Purchase Entry";
}

}

public function draft_purchase(){

//load model info
$this->load->model('purchase_model');

$payment_type=$this->input->post('payment_type');
$net_total=$this->input->post('net_total');
$rounded_net_total=$this->input->post('round_net_amt');
$amount_paid=$this->input->post('amount_paid');
$paction=$this->input->post('paction');

if($payment_type == "CREDIT CARD"){

$card_amt=$this->input->post('card_amt');
$balance= $rounded_net_total - ($amount_paid+$card_amt);

}else if($payment_type == "CHECQUE"){

$checque_amt=$this->input->post('checque_amt');
$balance= $rounded_net_total - ($amount_paid+$checque_amt);

}else if($payment_type == "UPI"){

$upi_amt=$this->input->post('upi_amt');
$balance= $rounded_net_total - ($amount_paid+$upi_amt);

}else {


$balance= $rounded_net_total - ($amount_paid);
}
//$this->recievings_model->balance=$balance;
$status=2;
if($paction == "Update"){

$result=$this->purchase_model->UpdatePurchase($balance,$status);
}else{
$result=$this->purchase_model->addPurchase($balance,$status);
}

if($result > 0 ) {

$bill_id=$result;

$itemcount=$this->input->post('item_count');

if($itemcount > 0 ){

if($paction == "Update"){
$this->purchase_model->delete_purchase_items($bill_id);
}
for($i=0;$i<$itemcount;$i++){

$item=$this->input->post('item');
$buyp_foc=0;
//start foc calculation
if($item[$i][6] >0 && $item[$i][7]>0){

$buyp_foc=($item[$i][6]*$item[$i][9])/($item[$i][6]+$item[$i][7]);
}



$this->purchase_model->addPurchaseItems($item[$i],$buyp_foc,$status,$bill_id);


}
}

// $this->drafted_bills();
redirect('purchase/drafted_bills');

}else{
$data['message']="Failed to Add Purchase Entry";
}
}

public function show_drafted_item(){

//load model
$this->load->model('purchase_model');

$purchase_id=$this->input->post('purchase_id');

$data['purchase_id']=$purchase_id;

//supplier info
$this->load->model('supplier');

$search[]="status = 0";
$data['supplier']=$this->supplier->getSupplier($search); 

//gst model
$this->load->model('gst_model');
$search_gst[]="status = 0";
$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


$criteria[0] = "id = ".$purchase_id;
$draftInfo=$this->purchase_model->searchPurchase($criteria);

if(!empty($draftInfo)){

$data['po_no']= empty($draftInfo[0][2])?'':$draftInfo[0][2];
$data['supplier_selected']=$draftInfo[0][4];
$data['purchase_amt']=$draftInfo[0][6];
$data['tot_gst']=$draftInfo[0][7];
$data['tot_cgst']=$draftInfo[0][8];
$data['tot_sgst']=$draftInfo[0][9];
$data['frieght']=$draftInfo[0][10];
$data['discount_type']=$draftInfo[0][13];
$data['discount_value']=empty($draftInfo[0][14])?'':$draftInfo[0][14];

$discount_amt=$draftInfo[0][15];
$data['discount_amt']=to_currency($discount_amt);
$data['total_bill']=$draftInfo[0][12];
$data['net_amt']=$draftInfo[0][41];
$data['roundstatus']=$draftInfo[0][40];
$data['round_net_amt']=$draftInfo[0][17];
$data['round_amt']=$draftInfo[0][42];
$data['bill_no']=empty($draftInfo[0][27])?'':$draftInfo[0][27];
$data['bill_date']=($draftInfo[0][3] !='1970-01-01')?date('d-m-Y',strtotime($draftInfo[0][3])):'';
$data['payment_type_selected']=$draftInfo[0][18];
$data['checque_no']=empty($draftInfo[0][19])?'':$draftInfo[0][19];
$data['checque_amt']=empty($draftInfo[0][20])?'':$draftInfo[0][20];
$data['card_amt']=empty($draftInfo[0][21])?'':$draftInfo[0][21];
$data['remarks']=empty($draftInfo[0][26])?'':$draftInfo[0][26];
$data['paction']='Update';
$data['purchase_mode_selected']='Recievings';

$data['item_focus_select']='';

$data['itemfocus']='';

}

$criteria[0] = "bill_id = ".$purchase_id;
$criteria[1] = "status = 2";
$itemInfo=$this->purchase_model->searchPurchaseItems($criteria);

if(!empty($itemInfo)){

for($i=0;$i<count($itemInfo);$i++){

$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$itemInfo[$i][14],'pharma_brand');
$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$itemInfo[$i][14],'pharma_brand');

$brand_name .="(".$generic_name.")";

// 				$id=$itemInfo[$i][14];
// 				$batch=empty($itemInfo[$i][4])?'':$itemInfo[$i][4];

// 				//$expiry=($itemInfo[$i][5] !='1970-01-01')?date('d-m-Y',strtotime($itemInfo[$i][5])):'';

// /*... YYYY-MM-DD format convert to MM/YY ...*/				
//                 // $expiry=($itemInfo[$i][5] !='1970-01-01')?date('m/y',strtotime($itemInfo[$i][5])):'';

//  if(($itemInfo[$i][5] !='1970-01-01') && ($itemInfo[$i][5] !='1970-01-31')){
// 					    $exp = DateTime::createFromFormat('d-m-Y', $itemInfo[$i][5]);
// 					    // var_dump($exp);
//                     $expiry=$exp->format('m/y');
// 					  $expiry=date('m/y',strtotime($itemInfo[$i][5]));
// 				}else{
// 				       $expiry='';
// 				     }	






	$id=$itemInfo[$i][14];
$batch=empty($itemInfo[$i][4])?'':$itemInfo[$i][4];

if(($itemInfo[$i][5] !='1970-01-01') && ($itemInfo[$i][5] !='1970-01-31') && ($itemInfo[$i][5] !='0000-00-00')){
$expiry=date('d-m-Y',strtotime($itemInfo[$i][5]));
}else{
$expiry='';
}

/*... YYYY-MM-DD format convert to MM/YY ...*/	
if(($itemInfo[$i][5] !='1970-01-01') && ($itemInfo[$i][5] !='1970-01-31') && ($itemInfo[$i][5] !='0000-00-00')){
$expiry=date('m/y',strtotime($itemInfo[$i][5]));
}else{
$expiry='';
}			
/*... YYYY-MM-DD format convert to MM/YY ...*/	

$unit=$itemInfo[$i][6];
$tpers=empty($itemInfo[$i][16])?'':$itemInfo[$i][16];
$qty=empty($itemInfo[$i][7])?'':$itemInfo[$i][7];
$foc=empty($itemInfo[$i][8])?'':$itemInfo[$i][8];
$buyp=$itemInfo[$i][12];

$sellp=$itemInfo[$i][9];
$disc_type=empty($itemInfo[$i][10])?'':$itemInfo[$i][10];
$disc_value=empty($itemInfo[$i][11])?'':$itemInfo[$i][11];
$gst_class=empty($itemInfo[$i][23])?'':$itemInfo[$i][23];
$gst_amt=empty($itemInfo[$i][20])?'':$itemInfo[$i][20];
$cgst_amt=empty($itemInfo[$i][22])?'':$itemInfo[$i][22];
$sgst_amt=empty($itemInfo[$i][21])?'':$itemInfo[$i][21];

$vat_inc=empty($itemInfo[$i][24])?'':$itemInfo[$i][24];

$total=empty($itemInfo[$i][13])?'':$itemInfo[$i][13];

$hsn_no=$itemInfo[$i][27];

$igst=empty($itemInfo[$i][30])?'':$itemInfo[$i][30];


$items_in_array[]=array($id,$brand_name,$batch,$expiry,$unit,$tpers,$qty,$foc,$sellp,$buyp,$disc_type,$disc_value,$gst_class,$gst_amt,$cgst_amt,$sgst_amt,$total,$vat_inc,'','',$hsn_no,$igst);

}
} 

$data['items_in_array']=$items_in_array;
$data['itemcount']=count($items_in_array);

//draft purchase to purchase form view
$this->load->view('purchase/purchase_form',$data);

}

public function purchase_return_form(){


$supplier_selected=$this->input->post('supplier');

if(!empty($supplier_selected)){

//process data
$data=$this->processPurchaseRetrunForm();

//supplier info
$this->load->model('supplier');

$search[]="status = 0";
$search[]="id = ".$supplier_selected;
$data['supplier']=$this->supplier->getSupplier($search); 

$data['itemfocus']=$this->input->post('item_focus');

if(empty($data['itemfocus'])) $data['itemfocus']="brand";

//gst model
$this->load->model('gst_model');
$search_gst[]="status = 0";
$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


}else{

$this->session->unset_userdata('batchidInfo'); 

//supplier info
$this->load->model('supplier');

$data['itemfocus']='supplier';

$search[]="status = 0";
$data['supplier']=$this->supplier->getSupplier($search); 


}
$data['supplier_selected']=$supplier_selected;
//purchase form view
$this->load->view('purchase/purchase_return_form',$data);
}

function processPurchaseRetrunForm(){

$itemcount=$this->input->post('item_count');
$data['item_focus_select']=$this->input->post('item_focus').$itemcount;
$item_loc=$this->input->post('item_loc');
$items_in_array=array();
$batchidInfo=array();

//PROCESS EXISTING ARRAY

$return_amt=0;
$total_gst=0;
$total_cgst=0;
$total_sgst=0;
$total_bill =0;
$round_amt=0;
$roundstatus=0;
$batch_error=array();

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
$exp=date('m/y',strtotime($item[$i][3]));
$qty=$item[$i][6];
$item[$i][18]=$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$item[$i][19],'pharma_batch');		
$buyp=$item[$i][9];
$disc_type=$item[$i][10];
$disc_value=$item[$i][11];
$sellp=$item[$i][8];				
$brand_id=$item[$i][0];
$tpers=$item[$i][5];

if(($qty > $batch_stock)){
  $batch_error[]="Insufficient Stock";
              //$batch_error[]='';
}else $batch_error[]='';

//Start discount calculation
if($disc_type =='CASH' && $disc_value>0){

$buyp=$buyp-$disc_value;
}else if($disc_type =='%' && $disc_value>0){

$buyp=$buyp-($buyp*($disc_value/100));;
}


//End discount calculation

//End Foc Calculations
$total=$qty*$buyp;

/*...... gst calculation ......*/	
if(empty($item[$i][21])){

 $item[$i][21]='';
}


if(!empty($item[$i][12]))
{
 
$cgst_per=$this->commonDBFunctions->getidToValue('cgst','id',$item[$i][12],'pharma_gst');
$sgst_per=$this->commonDBFunctions->getidToValue('sgst','id',$item[$i][12],'pharma_gst');
$gst_per=$this->commonDBFunctions->getidToValue('gst','id',$item[$i][12],'pharma_gst');
 
$cgst_amt=$cgst_per*($total/100);
$cgst_amt=to_currency($cgst_amt);

$sgst_amt=$sgst_per*($total/100);
$sgst_amt=to_currency($sgst_amt);

$gst_amt=$cgst_amt+$sgst_amt;
$gst_amt=to_currency($gst_amt);


/*... IGST...*/
if (!empty($item[$i][21]) && ($item[$i][21]==1)) {

	   $igst_per=$gst_per;

	  	$cgst_per='';
	  	$sgst_per='';
	  	$cgst_amt='';
    $sgst_amt='';

    $igst_amt=$gst_amt;

    $total=$total+$igst_amt;
     $total_gst+=$igst_amt;
    
	 // var_dump($total);

	  }
/*... IGST ...*/

  else{
     $total=$total+$gst_amt;
      $total_gst+=$gst_amt;
     //var_dump($total);
  }
 
  $total_cgst+=$cgst_amt;
  $total_sgst+=$sgst_amt;
  

}



// 	  $total=$total+$gst_amt;

// $total_gst+=$gst_amt;
//          $total_cgst+=$cgst_amt;
//          $total_sgst+=$sgst_amt;
//  }
else{
$gst_amt='';
$cgst_amt='';
$sgst_amt='';
} 

if (!empty($item[$i][21]) && ($item[$i][21]==1)) { 
$item[$i][13]=$igst_amt;
}
else{
$item[$i][13]=$gst_amt;
}
$item[$i][14]=$cgst_amt;
$item[$i][15]=$sgst_amt;
	
/*...... gst calculation ......*/


$sellp=to_currency($sellp);
$buyp=to_currency($buyp);
$item[$i][16]=$total=to_currency($total);	


$items_in_array[]=array($item[$i][0],$item[$i][1],$item[$i][2],$exp,$item[$i][4],$item[$i][5],$item[$i][6],$item[$i][7],$item[$i][8],$item[$i][9],$item[$i][10],$item[$i][11],$item[$i][12],$item[$i][13],$item[$i][14],$item[$i][15],$item[$i][16],$item[$i][17],$item[$i][18],$item[$i][19],$item[$i][20],$item[$i][21]);

$return_amt +=($qty*$buyp);
$total_bill = $total_bill+$total;				

}
}

}

$data['batch_error']=$batch_error;
$data['return_amt']=$return_amt;
$data['tot_gst']=$total_gst;
$data['tot_cgst']=$total_cgst;
$data['tot_sgst']=$total_sgst;

//calculate frieght

$data['frieght']=$frieght=$this->input->post('frieght');

if($frieght > 0 ){
$total_bill = $total_bill+$frieght;
}

$data['total_bill']=to_currency($total_bill);

//Calculate Discount

$data['discount_type']=$discount_type=$this->input->post('bill_disc_type');
$data['discount_value']=$discount_value=$this->input->post('bill_disc_value');
$discount_amt=0;

if(!empty($discount_type) && ($discount_value > 0) && $total_bill != 0){



if($discount_type == 'CASH'){

$discount_amt=$discount_value;

}else{
$discount_amt=$total_bill *($discount_value/100);
}
}
$data['discount_amt']=to_currency($discount_amt);

if($discount_amt >0 && $total_bill>0) {

$net_amt= $total_bill - $discount_amt;
}else if($discount_amt >0 && $total_bill<0) {

$net_amt= $total_bill + $discount_amt;
}else{

$net_amt= $total_bill;
}




$data['net_amt']=to_currency($net_amt);

$data['gst_amount']=$this->input->post('gst_amount');
$data['taxable_amount']=$this->input->post('taxable_amount');
$data['po_no']=$this->input->post('po_no');
$data['bill_no']=$this->input->post('bill_no');
$data['bill_date']=$this->input->post('bill_date');
$data['payment_type_selected']=$this->input->post('payment_type');
$data['checque_no']=$this->input->post('checque_no');
$data['checque_amt']=$this->input->post('checque_amt');
$data['card_amt']=$this->input->post('card_amt');
$data['branch_selected']=$this->input->post('branch');
$data['remarks']=$this->input->post('remarks');
$data['purchase_mode_selected']='Return';
$data['upi_amt']=$this->input->post('upi_amt');

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

if(!empty($brand_name) && !empty($batch_id)){		

if(!empty($id)){

$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

$expiry_date=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');


/*... YYYY-MM-DD format convert to MM/YY ...*/
// $expiry_date=date('m/y',strtotime($expiry_date));
/*... YYYY-MM-DD format convert to MM/YY ...*/

$batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
$sellp=$this->commonDBFunctions->getidToValue('sellp','id',$batch_id,'pharma_batch');
$buyp=$this->commonDBFunctions->getidToValue('buyp','id',$batch_id,'pharma_batch');

$unit=$this->commonDBFunctions->getidToValue('selling_unit','id',$id,'pharma_brand');



$gst_class=$this->commonDBFunctions->getidToValue('gst_id','id',$batch_id,'pharma_batch');

//hsn_no
$hsn_no=$this->commonDBFunctions->getidToValue('hsn_no','id',$id,'pharma_brand');

$gst_amt='';
$cgst_amt='';
$sgst_amt='';
$tpers='';
$qty='';

$disc_type='';
$disc_value='';
$igst='';

$total='';

$items_in_array[]=array($id,$brand_name,$batch_name,$expiry_date,$unit,$tpers,$qty,'',$sellp,$buyp,$disc_type,$disc_value,$gst_class,$gst_amt,$cgst_amt,$sgst_amt,$total,'',$batch_stock,$batch_id,$hsn_no,$igst);
$batchInfo=$this->session->userdata('batchidInfo');
$batchInfo[]=$batch_id;
$this->session->set_userdata('batchidInfo',$batchInfo);


}
}

$data['items_in_array']=$items_in_array;
$data['itemcount']=count($items_in_array);

return $data;

}
public function add_purchase_return(){

//load model info
$this->load->model('purchase_model');
$this->load->model('brand_model');
$this->load->model('batch_model');
$this->load->model('item_history_model');

$payment_type=$this->input->post('payment_type');
$net_total=$this->input->post('net_total');
$rounded_net_total=$this->input->post('round_net_amt');
$amount_paid=$this->input->post('amount_paid');

if($payment_type == "CREDIT CARD"){

$card_amt=$this->input->post('card_amt');
$balance= $rounded_net_total - ($amount_paid+$card_amt);

}else if($payment_type == "UPI"){

$upi_amt=$this->input->post('upi_amt');
$balance= $rounded_net_total - ($amount_paid+$upi_amt);

}else if($payment_type == "CHEQUE"){

$checque_amt=$this->input->post('checque_amt');
$balance= $rounded_net_total - ($amount_paid+$checque_amt);

}else {


$balance= $rounded_net_total - ($amount_paid);
}

$status=0;

$result=$this->purchase_model->addPurchase($balance,$status);

if($result > 0 ) {

$bill_id=$result;

$itemcount=$this->input->post('item_count');

for($i=0;$i<$itemcount;$i++){

$item=$this->input->post('item');

$buyp_foc=0;


$rec_item_id=$this->purchase_model->addPurchaseItems($item[$i],$buyp_foc,$status,$bill_id);

/*... MM/YY format convert to DD-MM-YYYY ...*/

/*$expiry_field = $item[$i][3];
$expiry_field = str_replace('/', '-', $expiry_field);
$newDate = explode( "-" , $expiry_field);
$output = $newDate[1]."-".$newDate[0]."-".'1';
$item[$i][3]=date("t-m-Y", strtotime($output));

$item[$i][3]=date("Y-m-d",strtotime($item[$i][3]));*/

/*... MM/YY format convert to DD-MM-YYYY ...*/

if($item[$i][4] == "STRIP") {

$tpers=$item[$i][5];
$qty=$tpers*$item[$i][6];



//convert price to nos
$item[$i][8]=round($item[$i][8]/$tpers,2);//sellp
$item[$i][9]=round($item[$i][9]/$tpers,2);//buyp
$item[$i][4]="NOS";
}else{

$qty=$item[$i][6];


$batchInfo['batch_stock'] = $qty;

}

$batch_id=$item[$i][19];


if($batch_id >0 ) {	

//UPDATE BATCH Stock
$current_batch_stock=$this->commonDBFunctions->getidToValue('batch_stock','id',$batch_id,'pharma_batch');
$new_batch_stock=$current_batch_stock-$qty;	

$data['message']=$this->batch_model->update_stock($batch_id,$new_batch_stock,"RECIEVINGS_RETURN");

//if batch updation success	
$brand_id=$item[$i][0];
$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');

$new_brand_stock=$this->batch_model->getMainStock($brand_id);

$this->brand_model->update_stock($brand_id,$new_brand_stock);

$new_branch_stock=$this->batch_model->getAllBranchStock($brand_id);  
$message2=$this->brand_model->update_stock($brand_id,$new_branch_stock,'','','','branch'); 

//add info to history
$message2=$this->purchase_model->add_batchid($rec_item_id,$batch_id);

//add to item history

$info['brand_id']=$brand_id;
$info['batch_id']=$batch_id;
$info['type']='NOS';
$info['quantity']= -($qty);
$info['old_stock_batch']=$current_batch_stock;
$info['new_stock_batch']=$new_batch_stock;
$info['old_stock_brand']=$brand_stock;
$info['new_stock_brand']=$new_brand_stock;
$info['action']="ADD";
$info['mode']="RECIEVINGS_RETURN";
$info['reference_id']=$bill_id;
$info['expiry_date' ]=$item[$i][3];
$info['new_expiry_date' ]=$this->commonDBFunctions->getidToValue('expiry_date','id',$info['batch_id'],'pharma_batch');
$info['branch_id']=0;//branch id
$info['old_stock_branch']=$branch_stock;
$info['new_stock_branch']=$new_branch_stock;
$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

$info['brand_name']=$brand_name;
$info['batch_number']=$batch_name;
$this->item_history_model->add_history($info);

}

}
// $this->print_purchase($bill_id);
redirect('purchase/print_purchase/'.$bill_id);

}else{
$data['message']="Failed to Add Purchase Entry";
}

}

function manage_purchase($next_page = null){

//load model
$this->load->model('purchase_model');
$this->load->model('supplier');

$data['suppliers']=$this->supplier->getSupplier();

$from_date=$this->input->post("from_date");
$end_date=$this->input->post("end_date");
$supplier=$this->input->post("supplier");
$bill_no=$this->input->post("bill_no");
$pono=$this->input->post("pono");
$payment_type=$this->input->post("payment_type");

$current_page=$this->input->post("current_page");

$message='';

if(!empty($from_date)){
$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
$message .="From Date : ".$from_date;
$data['from_date']=$from_date;
}

if(!empty($end_date)){
$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
$data['end_date']=$end_date;
}

if(!empty($supplier)){
$search[] = "supplier = ".$supplier;
$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'hcare_pharma_suppliers');

$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Supplier : ".$supplier_name;
$data['supplier_selected']=$supplier;
}

if(!empty($bill_no)){
$search[] = "bill_no LIKE '%".$bill_no."%'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
$data['bill_no']=$bill_no;
}

if(!empty($pono)){
$search[] = "pono = '".$pono."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PO No : ".$pono;
$data['pono']=$pono;
}

if(!empty($payment_type)){
$search[] = "payment_mode = '".$payment_type."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
$data['payment_type_select']=$payment_type;
}

if(empty($search)){

$search[] = "bill_date >= '".date("Y-m-d")."'";

$search[] = "bill_date <= '".date("Y-m-d")."'";

}

$data['message']=$message;

$search[] = "status = '0'";

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

$count_purchase = $this->purchase_model->getPurchaseCount($search);

$data['purchaseInfo']=$this->purchase_model->searchPurchase($search,'','',$limit);

$data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);

$data['current_page']=$current_page;

/*... pagination end ...*/

$this->load->view('purchase/manage_purchase',$data);
}

function update_purchase(){

//load model
$this->load->model('purchase_model');
$this->load->model('batch_model');

$purchase_id=$this->input->post('purchase_id');

$data['purchase_id']=$purchase_id;

//supplier info
$this->load->model('supplier');

$search[]="status = 0";
$data['supplier']=$this->supplier->getSupplier($search); 

//gst model
$this->load->model('gst_model');
$search_gst[]="status = 0";
$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


$criteria[0] = "id = ".$purchase_id;
$purchaseInfo=$this->purchase_model->searchPurchase($criteria);

if(!empty($purchaseInfo)){

$data['po_no']= empty($purchaseInfo[0][2])?'':$purchaseInfo[0][2];
$data['supplier_selected']=$purchaseInfo[0][4];
$data['purchase_amt']=$purchaseInfo[0][6];
$data['tot_gst']=$purchaseInfo[0][7];
$data['tot_cgst']=$purchaseInfo[0][8];
$data['tot_sgst']=$purchaseInfo[0][9];
$data['frieght']=$purchaseInfo[0][10];
$data['discount_type']=$purchaseInfo[0][13];
$data['discount_value']=empty($purchaseInfo[0][14])?'':$purchaseInfo[0][14];

$discount_amt=$purchaseInfo[0][15];
$data['discount_amt']=to_currency($discount_amt);
$data['total_bill']=$purchaseInfo[0][12];
$data['net_amt']=$purchaseInfo[0][41];
$data['roundstatus']=$purchaseInfo[0][40];
$data['round_net_amt']=$purchaseInfo[0][17];
$data['round_amt']=$purchaseInfo[0][42];
$data['bill_no']=empty($purchaseInfo[0][27])?'':$purchaseInfo[0][27];
$data['bill_date']=($purchaseInfo[0][3] !='1970-01-01')?date('d-m-Y',strtotime($purchaseInfo[0][3])):'';
$data['payment_type_selected']=$purchaseInfo[0][18];
$data['checque_no']=empty($purchaseInfo[0][19])?'':$purchaseInfo[0][19];
$data['checque_amt']=empty($purchaseInfo[0][20])?'':$purchaseInfo[0][20];
$data['card_amt']=empty($purchaseInfo[0][21])?'':$purchaseInfo[0][21];
$data['remarks']=empty($purchaseInfo[0][26])?'':$purchaseInfo[0][26];
$data['paction']='Update';
$data['purchase_mode_selected']='Recievings';
$data['purchase_status']='saved_bill';

$data['item_focus_select']='';

$data['itemfocus']='';

}

$criteria[0] = "bill_id = ".$purchase_id;
$criteria[1] = "status = 0";
$itemInfo=$this->purchase_model->searchPurchaseItems($criteria);
//var_dump($itemInfo);
if(!empty($itemInfo)){

for($i=0;$i<count($itemInfo);$i++){

/*.... if purchase items is move or stock adjustment ....*/
$batch_name=$itemInfo[$i][4];
$brand_id=$itemInfo[$i][14];
$expiry=$itemInfo[$i][5];
$EXP=date('Y-m-d',strtotime($itemInfo[$i][5]));
$batchid=$itemInfo[$i][29];

if($itemInfo[$i][6]=='STRIP'){//item type STRIP

$Item_qty=$itemInfo[$i][16]*$itemInfo[$i][7];
$foc_qty=$itemInfo[$i][16]*$itemInfo[$i][8];

$Item_qty_total=$Item_qty+$foc_qty;

}else{// item type NOS

$Item_qty=$itemInfo[$i][7];
$foc_qty=$itemInfo[$i][8];

$Item_qty_total=$Item_qty+$foc_qty;

}

$batch_stock=$this->batch_model->checkBatchChange($purchase_id,$brand_id,$batch_name,$EXP,$batchid);
//  var_dump( $EXP);

if((!empty($batch_stock) || empty($batch_stock)) && ($batch_stock<$Item_qty_total)){

$data['batch_stock_error'][$i]='Qty Mismatch';
$data['batch_stock_change']="YES";
$this->session->set_flashdata('stock_mismatch_error', 'You cannot Update This Purchase!');
}
/*.... if purchase items is move or stock adjustment ....*/

$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$itemInfo[$i][14],'pharma_brand');
$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$itemInfo[$i][14],'pharma_brand');

$brand_name .="(".$generic_name.")";

$id=$itemInfo[$i][14];
$batch=empty($itemInfo[$i][4])?'':$itemInfo[$i][4];



if(($itemInfo[$i][5] !='1970-01-01') && ($itemInfo[$i][5] !='1970-01-31')){
$expiry=date('d-m-Y',strtotime($itemInfo[$i][5]));
}else{
$expiry='';
}

/*... YYYY-MM-DD format convert to MM/YY ...*/	

if(($itemInfo[$i][5] !='1970-01-01') && ($itemInfo[$i][5] !='1970-01-31')){
$expiry=date('m/y',strtotime($itemInfo[$i][5]));
}else{
$expiry='';
}			

// /*... YYYY-MM-DD format convert to MM/YY ...*/


//$expiry=date('m/y',strtotime($itemInfo[$i][5]));
//$expiry=($itemInfo[$i][5] !='1970-01-01')?date('d-m-Y',strtotime($itemInfo[$i][5])):'';

//$expiry=date('m/y',strtotime($itemInfo[$i][5]));

// $expiry=($itemInfo[$i][5] !='1970-01-01')?date('m/y',strtotime($itemInfo[$i][5])):'';
/*... YYYY-MM-DD format convert to MM/YY ...*/

$unit=$itemInfo[$i][6];
$tpers=empty($itemInfo[$i][16])?'':$itemInfo[$i][16];
$qty=empty($itemInfo[$i][7])?'':$itemInfo[$i][7];
$foc=empty($itemInfo[$i][8])?'':$itemInfo[$i][8];
$buyp=$itemInfo[$i][12];

$sellp=$itemInfo[$i][9];
$disc_type=empty($itemInfo[$i][10])?'':$itemInfo[$i][10];
$disc_value=empty($itemInfo[$i][11])?'':$itemInfo[$i][11];
$gst_class=empty($itemInfo[$i][23])?'':$itemInfo[$i][23];
$gst_amt=empty($itemInfo[$i][20])?'':$itemInfo[$i][20];
$cgst_amt=empty($itemInfo[$i][22])?'':$itemInfo[$i][22];
$sgst_amt=empty($itemInfo[$i][21])?'':$itemInfo[$i][21];

$vat_inc=empty($itemInfo[$i][24])?'':$itemInfo[$i][24];

$total=empty($itemInfo[$i][13])?'':$itemInfo[$i][13];

// hsn no
$hsn_no=$itemInfo[$i][27];

$igst=empty($itemInfo[$i][30])?'':$itemInfo[$i][30];

$items_in_array[]=array($id,$brand_name,$batch,$expiry,$unit,$tpers,$qty,$foc,$sellp,$buyp,$disc_type,$disc_value,$gst_class,$gst_amt,$cgst_amt,$sgst_amt,$total,$vat_inc,'','',$hsn_no,$igst);

}
} 

$data['items_in_array']=$items_in_array;
$data['itemcount']=count($items_in_array);

//purchase to purchase update form purchase form view
$this->load->view('purchase/purchase_form',$data);

}

function print_purchase($bill_id = null,$popup_path=null){

//load model
$this->load->model('purchase_model');
$this->load->model('admin_model');

if(empty($bill_id)){

$bill_id=$this->input->post("purchase_id");
}

$criteria[0] = "id = ".$bill_id;
$data['purchaseInfo']=$this->purchase_model->searchPurchase($criteria);

$criteria[0] = "bill_id = ".$bill_id;
$criteria[1] = "status = 0";
$data['purchaseItemInfo']=$this->purchase_model->searchPurchaseItems($criteria);

$data['hospitalInfo']=$this->admin_model->getHospitalInfo();
$data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();

$from_path = $this->input->post("from_path");

if (!empty($from_path)) {
$data['from_path'] = $from_path;
}

if (!empty($popup_path)) {
$data['popup_path'] = $popup_path;
}

$this->load->view('purchase/print_purchase',$data);
}

function drafted_bills($next_page = null){

//load model
$this->load->model('purchase_model');
$this->load->model('supplier');

$data['suppliers']=$this->supplier->getSupplier();

$from_date=$this->input->post("from_date");
$end_date=$this->input->post("end_date");
$supplier=$this->input->post("supplier");
$bill_no=$this->input->post("bill_no");
$pono=$this->input->post("pono");
$payment_type=$this->input->post("payment_type");

$current_page=$this->input->post("current_page");

$message='';

if(!empty($from_date)){
$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
$message .="From Date : ".$from_date;
$data['from_date']=$from_date;
}

if(!empty($end_date)){
$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
$data['end_date']=$end_date;
}

if(!empty($supplier)){
$search[] = "supplier = ".$supplier;

$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'hcare_pharma_suppliers');

$message .="&nbsp;&nbsp;&nbsp;&nbsp; Supplier : ".$supplier_name;
$data['supplier_selected']=$supplier;
}
if(!empty($bill_no)){
$search[] = "bill_no = ".$bill_no;
$message .="&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
$data['bill_no']=$bill_no;
}
if(!empty($pono)){
$search[] = "pono = '".$pono."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp; PO No : ".$pono;
$data['pono']=$pono;
}

if(!empty($payment_type)){
$search[] = "payment_mode = '".$payment_type."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp; Payment Type : ".$payment_type;
$data['payment_type_select']=$payment_type;
}

$search[] ="status ='2'";

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

$count_purchase = $this->purchase_model->getPurchaseCount($search);

$data['purchaseInfo']=$this->purchase_model->searchPurchase($search,'','',$limit);

$data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);

$data['current_page']=$current_page;

/*... pagination end ...*/

$this->load->view('purchase/drafted_bills',$data);
}

function delete_draft_bill($id){

//load model
$this->load->model('purchase_model');

$this->purchase_model->delete_purchase($id);
$this->purchase_model->delete_purchase_items($id);
$this->session->set_flashdata('delete_success', 'Deleted Successfully!');

redirect("purchase/drafted_bills", 'refresh');
}

function issue_cheque($next_page = null){

//load model
$this->load->model('purchase_model');
$this->load->model('supplier');

$data['suppliers']=$this->supplier->getSupplier();

$from_date=$this->input->post("from_date");
$end_date=$this->input->post("end_date");
$supplier=$this->input->post("supplier");
$bill_no=$this->input->post("bill_no");
$pono=$this->input->post("pono");

$current_page=$this->input->post("current_page");

$message='';

if(!empty($from_date)){
$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
$message .="From Date : ".$from_date;
$data['from_date']=$from_date;
}

if(!empty($end_date)){
$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
$data['end_date']=$end_date;
}

if(!empty($supplier)){
$search[] = "supplier = ".$supplier;

$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'hcare_pharma_suppliers');

$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Supplier : ".$supplier_name;
$data['supplier_selected']=$supplier;
}
if(!empty($bill_no)){
$search[] = "bill_no = ".$bill_no;
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
$data['bill_no']=$bill_no;
}
if(!empty($pono)){
$search[] = "pono = '".$pono."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PO No : ".$pono;
$data['pono']=$pono;
}

$search[] = "(payment_mode = 'CHEQUE' || payment_mode = 'CHECQUE')";
$search[] = "(checque_no = '' || checque_no = '0')";
$search[] ="status ='0'";

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

$count_purchase = $this->purchase_model->getPurchaseCount($search);

$data['purchaseInfo']=$this->purchase_model->searchPurchase($search,'id','desc',$limit);

$data['pagination_link']=printPageLinks($count_purchase,$current_page,$perPage);

$data['current_page']=$current_page;

/*... pagination start ...*/

$data['issue_cheque_list_page']='YES';
$this->load->view('purchase/issue_cheque_list',$data);
}

function issue_cheque_form($purchase_id){

//load model
$this->load->model('purchase_model');

/* get bill details */

$search[0] = "id = ".$purchase_id;
$data['purchaseInfo']=$this->purchase_model->searchPurchase($search);
// var_dump($data['purchaseInfo']);exit;

$this->load->view('purchase/issue_cheque_form',$data);
}

function addChequePayment(){

//load model
$this->load->model('purchase_model');

$itemInfo[0]=$this->input->post("billid");

$search[0] = "id = ".$itemInfo[0];
$billInfo=$this->purchase_model->searchPurchase($search);
// $balance=$billInfo[0][23];
$balance=$billInfo[0][44];
$amount=$this->input->post("new_amount");

$new_balance=$balance-$amount;

if($new_balance >0){

$credit_paid="CREDIT";

}else $credit_paid="";

$itemInfo[1]=$this->input->post("new_amount");
$itemInfo[2]=$this->input->post("cheque_no");
$itemInfo[3]=$this->input->post("issue_date");
$itemInfo[4]= $new_balance;
$itemInfo[5]= $credit_paid;	 
$result=$this->purchase_model->addChequePayment($itemInfo);

redirect("purchase/issue_cheque", 'refresh');

}

function purchase_item_delete(){

//load model
$this->load->model('purchase_model');
$this->load->model('batch_model');

$bill_id=$this->input->post("purchase_id");

$criteria[0] = "id = ".$bill_id;
$data['purchaseInfo']=$this->purchase_model->searchPurchase($criteria);

$criteria[0] = "bill_id = ".$bill_id;
$criteria[1] = "status = 0";
$data['purchaseItemInfo']=$purchaseItemInfo=$this->purchase_model->searchPurchaseItems($criteria);
/* if purchase items is move */

if(!empty($purchaseItemInfo)){

for($i=0; $i<count($purchaseItemInfo); $i++) { 

$batch_name=$purchaseItemInfo[$i][4];
$brand_id=$purchaseItemInfo[$i][14];
$expiry=$purchaseItemInfo[$i][5];
$batchid=$purchaseItemInfo[$i][29];

if($purchaseItemInfo[$i][6]=='STRIP'){//item type STRIP

$Item_qty=$purchaseItemInfo[$i][16]*$purchaseItemInfo[$i][7];
$foc_qty=$purchaseItemInfo[$i][16]*$purchaseItemInfo[$i][8];

$Item_qty_total=$Item_qty+$foc_qty;

}else{// item type NOS

$Item_qty=$purchaseItemInfo[$i][7];
$foc_qty=$purchaseItemInfo[$i][8];

$Item_qty_total=$Item_qty+$foc_qty;

}

$batch_stock=$this->batch_model->checkBatchChange($bill_id,$brand_id,$batch_name,$expiry,$batchid);

if((!empty($batch_stock) || empty($batch_stock)) && ($batch_stock<$Item_qty_total)){

$data['batch_stock_error'][$i]='Qty Mismatch';
$data['batch_stock_change']="YES";
$this->session->set_flashdata('stock_mismatch_error', 'You cannot Delete This Purchase!');
}
}

} 

/* if purchase items is move */

$this->load->view('purchase/purchase_item_delete',$data);

}

function delete(){

//load model
$this->load->model('purchase_model');
$this->load->model('brand_model');
$this->load->model('batch_model');
$this->load->model('item_history_model');

$purchase_id=$this->input->post('purchase_id');
$criteria[0] = "bill_id = ".$purchase_id;
$criteria[1] = "status = 0";
$itemInfo=$this->purchase_model->searchPurchaseItems($criteria);

if(!empty($itemInfo)){

for($i=0;$i<count($itemInfo);$i++){

$batchInfo[0]=$itemInfo[$i][14];//item_id
$batchInfo[1]=$itemInfo[$i][4];//batch_number
$batchInfo[2]=$itemInfo[$i][5];//expiry
$expiry=$itemInfo[$i][5];//expiry
$purchase_mode=$itemInfo[$i][3];

if($purchase_mode == "Return"){
$exist=$this->batch_model->batchExist($batchInfo);
}else $exist=$this->batch_model->batchExist($batchInfo,'',$purchase_id);

if(!empty($exist)){   

$batch_id=$exist['id'];

$qty=-($exist['batch_stock']);
$old_qty=$exist['batch_stock'];
$brand_id=$exist['brand_id'];

$stock=0;
$delete_history='RECIEVINGS_CANCEL_Recievings';

if($purchase_mode == "Return"){

$qty=$itemInfo[$i][7];
$stock=$itemInfo[$i][7]+$old_qty;
$delete_history='RECIEVINGS_CANCEL_Return';
}


$data['message']=$message=$this->batch_model->update_stock($batch_id,$stock,$delete_history);


//update brand stock
if($data['message']==$this->lang->line('update_success')){

$brand_stock=$this->commonDBFunctions->getidToValue('brand_stock','id',$brand_id,'pharma_brand');

$new_brand_stock=$this->batch_model->getMainStock($brand_id);


$price_type=$itemInfo[$i][6];
$sellp=$itemInfo[$i][9];
$buyp=$itemInfo[$i][12];

$this->brand_model->update_stock($brand_id,$new_brand_stock,$price_type,$sellp,$buyp);

$new_branch_stock=$branch_stock=$this->commonDBFunctions->getidToValue('branch_stock','id',$brand_id,'pharma_brand');


$info['brand_id']=$brand_id;
$info['batch_id']=$batch_id;
$info['type']=$price_type;
$info['quantity']= $qty;
$info['old_stock_batch']=$old_qty;
$info['new_stock_batch']=$stock;
$info['old_stock_brand']=$brand_stock;
$info['new_stock_brand']=$new_brand_stock;
$info['action']="Recievings";
$info['mode']="RECIEVINGS_CANCEL";
$info['reference_id']=$purchase_id;
$info['expiry_date']=date('Y-m-d',strtotime($expiry));
$info['new_expiry_date' ]=$this->commonDBFunctions->getidToValue('expiry_date','id',$batch_id,'pharma_batch');
$info['branch_id']=0;//branch id
$info['old_stock_branch']=$branch_stock;
$info['new_stock_branch']=$new_branch_stock;
$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$brand_id,'pharma_brand');
$batch_name=$this->commonDBFunctions->getidToValue('batch_number','id',$batch_id,'pharma_batch');

$info['brand_name']=$brand_name;
$info['batch_number']=$batch_name;
$this->item_history_model->add_history($info);

}
}
}
}   

$this->purchase_model->delete_purchase_items($purchase_id);
$this->purchase_model->delete_purchase($purchase_id);

redirect("purchase/manage_purchase", 'refresh');	

}

function process_purchase_order(){

$order_id=$this->input->post('order_id');

$this->load->model('purchase_order_model');


//supplier info
$this->load->model('supplier');

$search[]="status = 0";
$data['supplier']=$this->supplier->getSupplier($search); 

//gst model
$this->load->model('gst_model');
$search_gst[]="status = 0";
$data['gst_class']=$this->gst_model->getGstInfo($search_gst);


$criteria[0] = "id = ".$order_id;
$orderInfo=$this->purchase_order_model->searchPurchaseOrder($criteria);

if(!empty($orderInfo)){

$data['po_no']=$orderInfo[0][1];
$data['supplier_selected']=$orderInfo[0][3];
$data['purchase_amt']=$orderInfo[0][7];
$data['tot_gst']=0;
$data['tot_cgst']=0;
$data['tot_sgst']=0;
$data['frieght']='';
$data['discount_type']='';
$data['discount_value']='';

$discount_amt=0;
$data['discount_amt']=to_currency($discount_amt);
$data['total_bill']=$orderInfo[0][7];
$data['net_amt']=$orderInfo[0][7];
$data['bill_no']='';
$data['bill_date']='';
$data['payment_type_selected']='';
$data['checque_no']='';
$data['checque_amt']='';
$data['card_amt']='';
$data['remarks']='';
$data['paction']='Save';
$data['purchase_mode_selected']='Recievings';
$data['round_net_amt']='';
$data['round_amt']='';

$data['itemfocus']='';

$data['item_focus_select']='';

}

$criteria[0] = "order_id = ".$order_id;
$itemInfo=$this->purchase_order_model->searchPurchaseOrderItems($criteria);

if(!empty($itemInfo)){

for($i=0;$i<count($itemInfo);$i++){

$brand_name=$this->commonDBFunctions->getidToValue('brand','id',$itemInfo[$i][5],'pharma_brand');
$generic_name=$this->commonDBFunctions->getidToValue('generic_name','id',$itemInfo[$i][5],'pharma_brand');

$brand_name .="(".$generic_name.")";

$id=$itemInfo[$i][5];
$unit=$itemInfo[$i][3];
$tpers=empty($itemInfo[$i][7])?'':$itemInfo[$i][7];
$qty=$itemInfo[$i][4];
$foc=empty($itemInfo[$i][9])?'':$itemInfo[$i][9];
$buyp=$itemInfo[$i][8];

$sellp=$this->commonDBFunctions->getidToValue('sellp','id',$id,'pharma_brand');

$total=$itemInfo[$i][10];

$items_in_array[]=array($id,$brand_name,'','',$unit,$tpers,$qty,$foc,$sellp,$buyp,'','','','','','',$total,'','','','');


}
} 

$data['items_in_array']=$items_in_array;
$data['itemcount']=count($items_in_array);

//purchase order to purchase form view
$this->load->view('purchase/purchase_form',$data);
}

function user_authentication($auth_type=null){

$data['authentication_type']=$auth_type;

$this->load->view('purchase/user_authentication',$data);
}

function credit_payment(){

//load model
$this->load->model('purchase_model');
$this->load->model('supplier');

$data['suppliers']=$this->supplier->getSupplier();

$from_date=$this->input->post("from_date");
$end_date=$this->input->post("end_date");
$supplier=$this->input->post("supplier");
$bill_no=$this->input->post("bill_no");
$pono=$this->input->post("pono");
$inv_no=$this->input->post("inv_no");

$message='';

if(!empty($from_date)){
$search[] = "bill_date >= '".date("Y-m-d",strtotime($from_date))."'";
$message .="From Date : ".$from_date;
$data['from_date']=$from_date;
}

if(!empty($end_date)){
$search[] = "bill_date <= '".date("Y-m-d",strtotime($end_date))."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End Date : ".$end_date;
$data['end_date']=$end_date;
}

if(!empty($supplier)){
$search[] = "supplier = ".$supplier;
$supplier_name=$this->commonDBFunctions->getidToValue('supplier_name','id',$supplier,'hcare_pharma_suppliers');

$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Supplier : ".$supplier_name;
$data['supplier_selected']=$supplier;
}

if(!empty($bill_no)){
$search[] = "bill_no = ".$bill_no;
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bill No : ".$bill_no;
$data['bill_no']=$bill_no;
}

if(!empty($pono)){
$search[] = "pono = '".$pono."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PO No : ".$pono;
$data['pono']=$pono;
}

if(!empty($inv_no)){
$search[] = "id = '".$inv_no."'";
$message .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Inv No : ".$inv_no;
$data['inv_no']=$inv_no;
}

if(empty($search)){

$search[] = "bill_date >= '".date("Y-m-d")."'";

$search[] = "bill_date <= '".date("Y-m-d")."'";

}

$data['message']=$message;

$search[] = "status = '0'";
$search[] = "balance > 0";
$search[] = "(payment_mode = 'CREDIT' OR payment_mode = 'NEFT' OR payment_mode = 'UPI')";

$data['purchaseInfo']=$this->purchase_model->searchPurchase($search,'','','','credit');

$this->load->view('purchase/credit_payment',$data);

}

function credit_payment_form($id){

//load model info
$this->load->model('purchase_model');

$search[] = "id = ".$id;

$billInfo=$this->purchase_model->searchPurchase($search,'','','');

$data['inv_no']=$id;
$data['billInfo']=$billInfo;

$this->load->view('purchase/credit_payment_form',$data);

}

function addCreditPayment(){

//load model info
$this->load->model('purchase_model');

$billid=$this->purchase_model->addPurchaseCreditPayment();

$this->print_purchase_credit_payment($billid);

}

// 	 public function multiple_credit_payment_form($amount){	

//     	//load model info
// 		$this->load->model('purchase_model');
// 		$paybill = $this->input->post('paybill');
// //  var_dump($this->input->post('paybill'));exit();
//         $data['amount']=$amount;


//     	$this->load->view('purchase/multiple_credit_payment_form',$data);
//     }
//     public function add_MultipleCreditPayment()
// 	{
// 		$this->load->model('purchase_model');

// 		$paybill = $this->input->post('paybill');
// 		$payment_mode = $this->input->post('payment_type_selected');

// 	//	var_dump($this->input->post());exit();


// 		if (!empty($paybill)) {

// 			for ($i=0; $i < count($paybill) ; $i++) { 

// 				$arrayInfo=explode('#',$paybill[$i]);

// 				$billInfo['bill_no']=$arrayInfo[0];
// 				$billInfo['payment_type']=$payment_mode;

// 				if($payment_mode=='CASH'){
// 				$billInfo['amount']=$arrayInfo[1];
// 				$billInfo['card_amt']=0;	
// 			}else{//var_dump($payment_mode);exit();
// 				$billInfo['amount']=0;
// 				$billInfo['card_amt']=$arrayInfo[1];
// 			}


// 				$result = $this->purchase_model->addCreditPaymentMultiple($billInfo);

// 			}

// 		}

// 		$this->session->set_flashdata('success_message', 'Added Successfully!');

// 		redirect("purchase/credit_payment", 'refresh');


// 	}


function multiple_credit_payment_form($total){
//load model info
$this->load->model('purchase_model');


$data['total']=$total;
$paybill=$this->input->post("paybill");

// var_dump($paybill);exit();

$this->load->view('purchase/multiple_credit_payment_form',$data);

}
function add_MultipleCreditPayment(){

//load model info
$this->load->model('purchase_model');

$paybill=$this->input->post("paybill");

// var_dump($paybill);exit();

if(!empty($paybill)){
																			
				for($i=0;$i<count($paybill);$i++)
							{										$arrayInfo=explode('#',$paybill[$i]);

												$billInfo['recievings_id']=$arrayInfo[0];
											$billInfo['date']=$arrayInfo[1];
											$billInfo['payment_type']=$arrayInfo[2];
											$billInfo['amount']=$arrayInfo[3];
											$billInfo['neft_amount']=$arrayInfo[4];

											// $reg_obj->addPurchaseCreditPayment($billInfo);
                     	$billid=$this->purchase_model->addPurchase_MultipleCrediPayment($billInfo);


									}
							}

							$post['message']="Payment Added Successfully!";
$this->load->view('purchase/credit_payment','');


// $billid=$this->purchase_model->addPurchase_MultipleCrediPayment();

// $this->print_purchase_credit_payment($billid);

}

public function manage_purchase_credit_payment(){

//load model info
$this->load->model('purchase_model');

$from_date=$this->input->post("from_date");
$end_date=$this->input->post("end_date");
$inv_no=$this->input->post("inv_no");
$bill_status=$this->input->post("bill_status");

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

if(!empty($inv_no)){

$search[] = "Recievings_id = ".$inv_no;
$message .="&nbsp;&nbsp;&nbsp;&nbsp; Inv No : ".$inv_no;
$data['inv_no']=$inv_no;
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

$count_credit_payments=$this->purchase_model->getPurchaseCreditPaymentCount($search);

$data['billInfo']=$this->purchase_model->getPurchaseCreditPayment($search,$limit);

$data['pagination_link']=printPageLinks($count_credit_payments,$current_page,$perPage);

$data['current_page']=$current_page;

/*... pagination end ...*/

$this->load->view('purchase/manage_purchase_credit_payment',$data);

}

public function print_purchase_credit_payment($id = null){

//load model info
$this->load->model('purchase_model');
$this->load->model('admin_model');

if(empty($id)){

$id=$this->input->post('credit_id');
}

$search[] = "id = ".$id;
$search[] ="status =0";

$data['billInfo']=$this->purchase_model->getPurchaseCreditPayment($search);
$data['hospitalInfo']=$this->admin_model->getHospitalInfo();
$data['pharmacyInfo']=$this->admin_model->getPharmacyInfo();


$this->load->view('purchase/print_purchase_credit_payment',$data);

}

public function delete_purchase_credit_payment($id){

//load model info
$this->load->model('purchase_model');

$cancellation_details=$this->input->post("cancellation_details");

$this->purchase_model->delete_purchase_credit_payment($id,$cancellation_details);

$this->session->set_flashdata('delete_msg', 'Deleted Successfully!');

redirect("purchase/manage_purchase_credit_payment", 'refresh');

}


public function add_multiple_credits()
{
$this->load->model('purchase_model');

$paybill = $this->input->post('paybill');
$payment_mode = $this->input->post('payment_type_selected');


if (!empty($paybill)) {

for ($i=0; $i < count($paybill) ; $i++) { 

$arrayInfo=explode('#',$paybill[$i]);

$billInfo['bill_no']=$arrayInfo[0];
$billInfo['payment_type']=$payment_mode;

if($payment_mode=='CASH'){
$billInfo['amount']=$arrayInfo[4];
$billInfo['neft_amount']=0;	
$billInfo['upi_amount']=0;
}else if($payment_mode=='UPI'){
	$billInfo['amount']=0;
$billInfo['neft_amount']=0;
$billInfo['upi_amount']=$arrayInfo[4];

}else{//var_dump($payment_mode);exit();
$billInfo['amount']=0;
$billInfo['upi_amount']=0;
$billInfo['neft_amount']=$arrayInfo[4];
}


$result = $this->purchase_model->addCreditPaymentMultiple($billInfo);

}

}

$this->session->set_flashdata('success_message', 'Added Successfully!');

redirect("purchase/credit_payment", 'refresh');


}

public function add_multiple_credits_form($amount){	

//load model info
$this->load->model('purchase_model');
$paybill = $this->input->post('paybill');

//$paybill = $this->input->post('paybill');
//var_dump($this->input->post());
$data['amount']=$amount;


$this->load->view('purchase/multiple_credit_payment_form',$data);
}


}


