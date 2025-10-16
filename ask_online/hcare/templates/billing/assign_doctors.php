 <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>
var $j = jQuery.noConflict();
function change_doctor(billid,e,field_name){

      document.show_items.billid.value=billid;
	  document.show_items.doc_id.value=e.value;
	  document.show_items.field_name.value=field_name;
	
      $j.post("../../lib/controllers/centralController.php?module=Billing&sub_module=change_doctor_billing_item", $("#show_items").serialize(),function(data){
		
		 if(data['result'] == true){
		   showDialog('Success','Successfully Updated Doctor For Selected Item.','error',3);
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
  <input type="hidden" name="field_name" id="field_name" />
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
          <div class="col-xs-12">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
							<tr style="font-weight:bold" class="text-navy">
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
							
							<th><?php echo $lang_particulars; ?></th>
							<th><?php echo $lang_doctor; ?>/<?php echo $lang_surgeon; ?></th>
							
							<th><?php echo $lang_anesthestis; ?></th>
							<th><?php echo $lang_assistant_doc1; ?></th>
							<th><?php echo $lang_assistant_doc2; ?></th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($billItemInfo)) { 
								$j=1;
								for ($i=0;$i<count($billItemInfo);$i++) {
								if($billItemInfo[$i][31] == 0) {
									
								?>
								
								<tr>
									
									<td><?php echo $billItemInfo[$i][5];?></td>
									
									<td>
								<?php
								  if(($billItemInfo[$i][14] > 0 || $billItemInfo[$i][36] > 0 || $billItemInfo[$i][37] > 0)  && !empty($doctors)){?>
								  
								       <select  onchange="change_doctor('<?php echo $billItemInfo[$i][0]; ?>',this,'doc_id')" name="items[<?php echo $i; ?>][1]" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($billItemInfo[$i][12]) && $billItemInfo[$i][12]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   }else if($billItemInfo[$i][16] > 0  && !empty($doctors)){?>
								  
								       <select  onchange="change_doctor('<?php echo $billItemInfo[$i][0]; ?>',this,'surgeon_id')" name="items[<?php echo $i; ?>][1]" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($billItemInfo[$i][22]) && $billItemInfo[$i][22]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][1]" value="<?php echo $billItemInfo[$i][12]; ?>" />
								<?php } ?>
								</td>
								
								<td>
								<?php
								  if($billItemInfo[$i][18] > 0  && !empty($doctors)){?>
								  
								       <select  onchange="change_doctor('<?php echo $billItemInfo[$i][0]; ?>',this,'anesthestis')" name="items[<?php echo $i; ?>][3]" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($billItemInfo[$i][24]) && $billItemInfo[$i][24]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][3]" value="<?php echo $billItemInfo[$i][18]; ?>" />
								<?php } ?>
								</td>
								<td>
								<?php
								  if($billItemInfo[$i][20] > 0  && !empty($doctors)){?>
								  
								       <select  onchange="change_doctor('<?php echo $billItemInfo[$i][0]; ?>',this,'assistant_doc1')" name="items[<?php echo $i; ?>][4]" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($billItemInfo[$i][26]) && $billItemInfo[$i][26]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][4]" value="<?php echo $billItemInfo[$i][12]; ?>" />
								<?php } ?>
								</td>
								<td>
								<?php
								  if($billItemInfo[$i][21] > 0  && !empty($doctors)){?>
								  
								       <select  onchange="change_doctor('<?php echo $billItemInfo[$i][0]; ?>',this,'assistant_doc2')" name="items[<?php echo $i; ?>][5]" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($doctors);$k++){ 
																						
													if(!empty($billItemInfo[$i][28]) && $billItemInfo[$i][28]==$doctors[$k][0]) { ?>
													
														<option value='<?php echo $doctors[$k][0];?>' selected><?php echo $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$k][0];?>'><?php echo  $doctors[$k][1].".".$doctors[$k][2]." ".$doctors[$k][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][5]" value="<?php echo $billItemInfo[$i][12]; ?>" />
								<?php } ?>
								</td>
								
								<input type="hidden" name="items[<?php echo $i; ?>][0]" value="<?php echo $billItemInfo[$i][0]; ?>" />
									
								</tr>
						
						<?php 	}
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

	
