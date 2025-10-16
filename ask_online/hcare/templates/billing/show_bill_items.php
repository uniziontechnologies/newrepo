 <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>
var $j = jQuery.noConflict();
function change_doctor(billid,e){

      document.show_items.billid.value=billid;
	  document.show_items.doc_id.value=e.value
	
      $j.post("../../lib/controllers/centralController.php?module=Billing&sub_module=change_doctor_billing_item", $("#show_items").serialize(),function(data){
		
		 if(data['result'] == true){
		   showDialog('Success','Successfully Updated Doctor For Selected Item.','error',5);
		 }else{
		  showDialog('Error','Failed To Update Doctor.','error',2);
		 }
		
	},"json");
	
}
</script>
 <div  id="content">
<form name="show_items" id="show_items"  method="post" action="" > 

 <input type="hidden" name="billid" id="billid" />
 <input type="hidden" name="doc_id" id="doc_id" />
<?php

$billInfo=$this->popArr['billInfo'];
$billItemInfo=$this->popArr['billItemInfo'];
$doctors=$this->popArr['doctors'];
?>

       
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
				
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		
		<div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
							<tr >
						<td>
			 			<font size="<?php echo $lang_font_size;?>"><?php echo "INV NO:&nbsp;".$billInfo[0][0];?></font>
						</td>
						<td id="noborder" >
		 						<font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no; ?> &nbsp;:&nbsp; <?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP")?$billInfo[0][19]:$billInfo[0][2]; ?></font>
						</td>
					   <td id="noborder" >
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][3];?></font>
						</td>
						<td id="noborder">
			 				<font size="<?php echo $lang_font_size;?>"><?php echo $lang_age."/".$lang_gender; ?>&nbsp;:&nbsp;<?php echo $billInfo[0][4]."/". $billInfo[0][5];?></font>
						</td>
						<td id="noborder" >
							<font size="<?php echo $lang_font_size;?>"><?php echo $lang_date.":&nbsp;".$billInfo[0][16];?></font>
						</td>
		
					</tr>
					</table>
				</div>
			</div>
					
			<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $lang_sl_no; ?></th>
							<th><?php echo $lang_particulars; ?></th>
							<th><?php echo $lang_amount; ?></th>
							<th><?php echo $lang_discount." ".$lang_type; ?></th>
							<th><?php echo $lang_discount; ?></th>
							<th><?php echo $lang_net_amount; ?></th>
						   <th><?php echo $lang_doctor; ?></th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($billItemInfo)) { 
								$j=1;
								for ($i=0;$i<count($billItemInfo);$i++) {
								  if($billItemInfo[$i][31] == 0) {
									
								?>
								
								<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $billItemInfo[$i][5];?></td>
									<td><?php echo $billItemInfo[$i][7];?></td>
									<td><?php echo $billItemInfo[$i][8];?></td>
									<td><?php echo $billItemInfo[$i][9];?></td>
									<td><?php echo $billItemInfo[$i][11];?></td>
									<td><?php echo $billItemInfo[$i][13];?>
								
								    </td>
								
								<input type="hidden" name="items[<?php echo $i; ?>][0]" value="<?php echo $billItemInfo[$i][0]; ?>" />
									
								</tr>
						
						<?php 	
								}
							  }
							} ?>
					
					
					</tbody>
				</table>
				</div>	
			</div>
		 </div>
				
				
						
			
	</div>
	</div>
</div>	

   
    
</form>
</div>

	
