<?php $this->load->view("header");
?> 
<form name="purchase_return_form" id="purchase_return_form" method="post" action="<?php echo base_url(); ?>index.php/purchase/purchase_return_form">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
             <?php echo $this->lang->line('purchase')." ".$this->lang->line('return'); ?> 
             
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
		  
		  <?php if(empty($supplier_selected)){?>
		  <div class="row">
          <div class="col-md-9"> 
		  <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
		  
		       <td ><?php echo $this->lang->line('supplier') ?> <span id='requiredfield'>*</span>&nbsp; : </td>
							
							<td>
								<?php
								  if(!empty($supplier)){?>
								  
								       <select name="supplier" id="supplier"/> 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($supplier);$k++){ 
																						
													if(!empty($supplier_selected) && $supplier_selected==$supplier[$k][0]) { ?>
													
														<option value='<?php echo $supplier[$k][0];?>' selected><?php echo $supplier[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $supplier[$k][0];?>'><?php echo  $supplier[$k][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
								  <?php } ?>
							</td>
						</table>
					</div>
				</div>
			</div>
				</div>
		  
		  <?php }else{?>
            <div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
				
				<tr>
					
																		
							<td ><?php echo $this->lang->line('bill_no'); ?> : </td>
					
							
							<td ><input type="text" name="bill_no" value="<?php echo $bill_no;?>" id="bill_no" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" size="6"  /></td>
							
							
							<td ><?php echo $this->lang->line('date');?> <span id='requiredfield'>*</span>&nbsp;: </td>
					
							<td ><input type="text" name="date" value="<?php echo date("d-m-Y");?>" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" size="8" readonly="true"  /></td>
							
							<td ><?php echo $this->lang->line('bill_date') ?> <span id='requiredfield'>*</span>&nbsp;: </td>
					
							<td ><input type="text" name="bill_date" value="<?php echo $bill_date;?>" id="bill_date" class="DatePicker" onkeypress="nextField(event.keyCode,bill_no)" autocomplete="off" size="10" readonly="true"  /></td>
							<td ><?php echo $this->lang->line('supplier') ?> <span id='requiredfield'>*</span>&nbsp; : </td>
							
							<td>
								
								<?php
								  if(!empty($supplier)){?>
								  
								       <select name="supplier" id="supplier"/> 		
									
											
											<?php for($k=0;$k<count($supplier);$k++){ 
																						
													if(!empty($supplier_selected) && $supplier_selected==$supplier[$k][0]) { ?>
													
														<option value='<?php echo $supplier[$k][0];?>' selected><?php echo $supplier[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $supplier[$k][0];?>'><?php echo  $supplier[$k][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
								  <?php } ?>
								</td>

				</table>
				</div><!--boxbody-->
			  </div><!--boxinfo-->
			  
			  <div align="center"><?php echo $this->lang->line('brand');?>&nbsp;:&nbsp;
					
					
					<input name="brand" id="brand" tabbindex="2"  value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
					 
					
					 <input type="hidden" id="brand_hidden" name="brand_ID" >
					 <input type="hidden" id="batch_hidden" name="batch_ID" >
					 
					 
					 </div>
					 <br>
					 
					 <?php if(isset($error_message)){?>
								<br /><br />
								<div id='error_message'><?php echo $error_message;?></div>
					<?php } ?>
					
					<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					<thead>
						<tr>
						  <th><?php echo $this->lang->line('slno') ?></th>
							<th><?php echo $this->lang->line('brand') ?></th>
							<th>Hsn</th>
							<th><?php echo $this->lang->line('batch') ?></th>
							<th><?php echo $this->lang->line('expiry') ?></th>
							<th><?php echo $this->lang->line('pack') ?></th>
							<th><?php echo $this->lang->line('tab') ?>/<?php echo $this->lang->line('strip');?></th>
							<th><?php echo $this->lang->line('qty') ?></th>
							<th><?php echo $this->lang->line('stock') ?></th>
							<th><?php echo $this->lang->line('sellp') ?></th>
							<th><?php echo $this->lang->line('buyp') ?></th>
							<th><?php echo $this->lang->line('discount') ?></th>
						    <th>IGST</th> 
							
							<th><?php echo $this->lang->line('gst%') ?></th>
							
							<th><?php echo $this->lang->line('total') ?></th>
							<th><?php echo $this->lang->line('remove') ?></th>
							</tr>
					</thead>
					<tbody>
					
					<?php if($itemcount > 0 ) {
							$j=1;
							for($i=0;$i<$itemcount;$i++){
							
								//$items=explode("!^*",$items_in_array[$i]);
								$items=$items_in_array[$i];
							//	var_dump($items);
					?>
							<tr>
							    <td ><?php echo $j++; ?></td>
							    <td>
								<input type="text" name="item[<?php echo $i;?>][1]" id="brand<?php echo $i;?>" value="<?php echo $items[1];?>" onkeypress="nextField(event.keyCode,batch<?php echo $i;?>)" size="7" readonly></td>
								<td>
								<input type="text" name="item[<?php echo $i; ?>][20]" value="<?php echo $items[20];?>" size="2" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][2]" id="batch<?php echo $i;?>" value="<?php echo $items[2];?>" onkeypress="nextField(event.keyCode,expiry<?php echo $i;?>)" size="4" readonly></td>

								<!--  <td><input type="text" name="item[<?php echo $i;?>][3]"  id="expiry<?php echo $i;?>" value="<?php echo $items[3];?>"  size="5" onkeypress = "nextField(event.keyCode,unit<?php echo $i;?>)" readonly></td> -->

                            <!-- MM/YY format -->

								<td><input type="text" name="item[<?php echo $i;?>][3]" placeholder="MM/YY" id="expiry<?php echo $i;?>" value="<?php echo $items[3];?>"  size="5" onkeypress = "nextField(event.keyCode,unit<?php echo $i;?>)" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','expiry','batch<?php echo $i;?>','unit<?php echo $i;?>')" autocomplete="off"></td>

							<!-- MM/YY format -->

								<td><select name="item[<?php echo $i;?>][4]" id="unit<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','4');" onchange="return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','4');">
                                    <option value="NOS" <?php echo ($items[4] == 'NOS')?'selected' :'';?>>NOS</option>
                                    <option value="STRIP" <?php echo ($items[4] == 'STRIP')?'selected' :'';?>>STRIP</option>
                                     </select>                        
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][5]" value="<?php echo $items[5];?>" id="tpers<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('qty<?php echo $i;?>','<?php echo $i;?>','5');}" autocomplete="off" size="2" <?php echo ($items[4] == 'NOS')?'readonly' :'';?> onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','tpers','unit<?php echo $i;?>','qty<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][6]" id="qty<?php echo $i;?>" value="<?php echo $items[6];?>"  size="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('brand','','');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','qty','tpers<?php echo $i;?>','')">
								<br><div class="text-red"><?php echo (!empty($batch_error[$i]))?$batch_error[$i]:'';?></div></td>
								<td><input type="text" name="item[<?php echo $i;?>][18]" id="stock<?php echo $i;?>" value="<?php echo $items[18];?>"  size="2"onkeypress="if(event.keyCode== 13){return process_form('sellp<?php echo $i;?>','<?php echo $i;?>','7');}" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][8]" id="sellp<?php echo $i;?>" value="<?php echo $items[8];?>"  size="2" onkeypress="if(event.keyCode== 13){return process_form('buyp<?php echo $i;?>','<?php echo $i;?>','8');}" autocomplete="off"></td>
								<td><input type="text" name="item[<?php echo $i;?>][9]" id="buyp<?php echo $i;?>" value="<?php echo $items[9];?>"  size="2" onkeypress="if(event.keyCode== 13){return process_form('disc_type<?php echo $i;?>','<?php echo $i;?>','9');}" autocomplete="off"></td>
								<td><select name="item[<?php echo $i;?>][10]" id="disc_type<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('disc_value<?php echo $i;?>','<?php echo $i;?>','10');" onchange="return process_form('disc_value<?php echo $i;?>','<?php echo $i;?>','10');">
                                    <option value="" >--</option>
									<option value="CASH" <?php echo ($items[10] == 'CASH')?'selected' :'';?>>CASH</option>
                                    <option value="%" <?php echo ($items[10] == '%')?'selected' :'';?>>%</option>
                                     </select>   
                                   <input type="text" name="item[<?php echo $i;?>][11]" value="<?php echo $items[11];?>" id="disc_value<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('gst_class<?php echo $i;?>','<?php echo $i;?>','11');}" autocomplete="off" size="2" readonly>									 
								</td>


                                     <td>
									<input type="checkbox" name="item[<?php echo $i;?>][21]" value="1" id="igst<?php echo $i;?>"  onchange="return process_form('gst_class<?php echo $i;?>','<?php echo $i;?>','21');" onkeypress="checked_box('igst<?php echo $i;?>','gst_class<?php echo $i;?>')" autocomplete="off" <?php echo (!empty($items[21]) && ($items[21]==1))?'checked':''; ?> onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','igst','disc_type<?php echo $i;?>','gst_class<?php echo $i;?>')" >
								</td>






								<td> 
									  <select name="item[<?php echo $i;?>][12]" id="gst_class<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('gst_amt<?php echo $i;?>','<?php echo $i;?>','12');" onchange="return process_form('gst_amt<?php echo $i;?>','<?php echo $i;?>','12');">
                                    <option value=''>--</option>
											
											<?php for($k=0;$k<count($gst_class);$k++){ 
																						
													if(!empty($items[12]) && $items[12]==$gst_class[$k][0]) { ?>
													
														<option value='<?php echo $gst_class[$k][0];?>' selected><?php echo $gst_class[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $gst_class[$k][0];?>'><?php echo  $gst_class[$k][1];?></option>
												
										<?php 		} 
												} ?>
                                     </select>  <input type="text" name="item[<?php echo $i;?>][13]" value="<?php echo $items[13];?>" id="gst_amt<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','13');}" autocomplete="off" size="2" readonly>
                                   <input type="hidden" name="item[<?php echo $i; ?>][14]" value="<?php echo $items[14];?>" />
									<input type="hidden" name="item[<?php echo $i; ?>][15]" value="<?php echo $items[15];?>" />
                                  </td>
								<td><input type="text" name="item[<?php echo $i;?>][16]" id="total<?php echo $i;?>" value="<?php echo $items[16];?>" readonly size="2" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','14');}"></td>
								
								<td> <a href='#' id="<?php echo $i;?>" class='remove_item'><img src="<?php echo base_url(); ?>application/assets/dist/img/delete.png" title='Remove' width='16' height='16' /></a></td>
									
									<input type="hidden" name="item[<?php echo $i; ?>][0]" value="<?php echo $items[0];?>" />
									<input type="hidden" name="item[<?php echo $i; ?>][17]" value="<?php echo $items[17];?>" />
									<input type="hidden" name="item[<?php echo $i; ?>][19]" value="<?php echo $items[19];?>" />
									<input type="hidden" name="item[<?php echo $i; ?>][7]" value="<?php echo $items[7];?>" />

										  
							</tr>							
					<?php    }
					
						   }
						   
					?>			
							
					</tbody>
				</table>
				</div><!--boxbody-->
			  </div><!--boxinfo-->
			 </div><!--col-md-9-->
			 <div class="col-md-3">
				<div class="box box-info">
                
                    <div class="box-body">
				
					   <table  class="table table-striped">
					   <tr>
							<td ><?php echo $this->lang->line('return_amt') ?> : </td>
					
							<td ><input type="text" name="return_amt" value="<?php echo $return_amt;?>" id="return_amt" onkeypress="nextField(event.keyCode,tax)" autocomplete="off" readonly="1"  size="12"/></td>
					   </tr>
					   <tr>
							<td ><?php echo $this->lang->line('gst') ?> : </td>
					
							<td ><input type="text" name="gst" value="<?php echo $tot_gst;?>" id="gst" onkeypress="nextField(event.keyCode,cess)" autocomplete="off" readonly="1"  size="12"/></td>
						
					</tr>
					<tr>
							<td ><?php echo $this->lang->line('cgst') ?> : </td>
							<td ><input type="text" name="cgst" value="<?php echo $tot_cgst;?>" id="cgst" onkeypress="nextField(event.keyCode,cess)" autocomplete="off" readonly="1" size="12" /></td>
							
					</tr>
					<tr>
							<td ><?php echo $this->lang->line('sgst') ?> : </td>
							<td ><input type="text" name="sgst" value="<?php echo $tot_sgst;?>" id="sgst" onkeypress="nextField(event.keyCode,cess)" autocomplete="off" readonly="1"  size="12"/></td>
							
					</tr>
					
					
				<tr style="display:none;">
							<td ><?php echo $this->lang->line('frieght') ?> : </td>
							<td ><input type="text" name="frieght" value="<?php echo $frieght;?>" id="frieght" onkeypress="if(event.keyCode== 13){return process_form('amount_paid','','');}" autocomplete="off"  size="12"/></td>
							
				</tr>
				
				<tr>
							<td ><?php echo $this->lang->line('bill_total') ?> : </td>
							<td ><input type="text" name="bill_total" value="<?php echo $total_bill;?>" id="bill_total" onkeypress="nextField(event.keyCode,tax)" autocomplete="off" readonly="1"  size="12"/></td>
							
				</tr>
				<tr>
							<td  colspan="2"><?php echo $this->lang->line('discount') ?> : </td>
				</tr>
				<tr>
							<td  colspan="2">
							
						          <select name="bill_disc_type" id="bill_disc_type" onkeypress="if(event.keyCode== 13){return process_form('bill_disc_type','','');"} onchange="return process_form('bill_disc_type','','');">
                                      <option value="" >----------</option>
                                      <option value="CASH" <?php echo ($discount_type == 'CASH')?'selected' :'';?>>CASH</option>
                                      <option value="%" <?php echo ($discount_type == '%')?'selected' :'';?>>%</option>
                                 </select>							&nbsp;
							<input type="text" name="bill_disc_value" value="<?php echo $discount_value;?>" id="bill_disc_value" onkeypress="if(event.keyCode== 13){return process_form('disc_value','','');}" onblur="return process_form('disc_value','','');" autocomplete="off" size="5"  />							&nbsp;
							<input type="text" name="disc_amt" value="<?php echo $discount_amt;?>" id="disc_amt" onkeypress="nextField(event.keyCode,pono)" autocomplete="off" readonly="1" size="5"  />	
							</td>					
							
				</tr>
				
				<tr>
							<td ><?php echo $this->lang->line('net_total') ?> : </td>
							<td ><input type="text" name="net_total" value="<?php echo $net_amt;?>" id="net_total" onkeypress="nextField(event.keyCode,pono)" autocomplete="off" readonly="1" size="12" /></td>
							
				</tr>
				<tr>
					        <td>Net Total (R/O) : 
					             <input type="checkbox" name="roundstatus" value="1" id="roundstatus" <?php echo (!empty($roundstatus) && ($roundstatus==1))?'checked':'' ?> onchange="process_form('roundstatus','','');">
					        </td>
					        <td>
					             <input type="text" name="round_net_amt" value="<?php echo $round_net_amt;?>" id="round_net_amt" autocomplete="off" readonly="1" size="12" />
					        </td>
				</tr>
				<tr>
				            <td>R/O : </td>
				            <td><input type="text" name="round_amt" value="<?php echo $round_amt ?>" id="round_amt" autocomplete="off" readonly="1"></td>
				</tr>
				<tr>
							<td ><?php echo $this->lang->line('payment_type') ?> : </td>
							<td ><select name="payment_type" id="payment_type" onkeypress=if(event.keyCode== 13){"return process_form('payment_type','','');"} onchange="return process_form('payment_type','','');">
								   <option value="CASH" <?php echo ($payment_type_selected == 'CASH')?'selected' :'';?>>CASH</option>
                                   <option value="CHEQUE" <?php echo ($payment_type_selected == 'CHEQUE')?'selected' :'';?>>CHEQUE</option>
                                   <option value="CREDIT CARD" <?php echo ($payment_type_selected == 'CREDIT CARD')?'selected' :'';?>>CREDIT CARD</option>
                                   <option value="UPI" <?php echo ($payment_type_selected == 'UPI')?'selected' :'';?>>UPI</option>
                                   
                                 </select></td>
							<td >&nbsp;</td>
							
					</tr>
	<?php	 if($payment_type_selected == "CHEQUE"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('checque_no') ?> : </td>
							<td ><input type="text" name="checque_no" value="" id="checque_no" onkeypress="nextField(event.keyCode,checque_amt)" autocomplete="off" size="12"></td>
							
				</tr>
				<tr>
							<td ><?php echo $this->lang->line('checque_amt') ?> : </td>
							<td ><input type="text" name="checque_amt" value="" id="checque_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>
	<?php	 if($payment_type_selected == "CREDIT CARD"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('card_amt') ?> : </td>
							<td ><input type="text" name="card_amt" value="" id="card_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>
	<?php	 if($payment_type_selected == "UPI"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('upi_amt') ?> : </td>
							<td ><input type="text" name="upi_amt" value="" id="upi_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>
	<?php	/* if($payment_type_selected == "BRANCH"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('branch') ?> : </td>
							<td ><?php echo form_dropdown('branch',$branch,$branch_selected,$branch_extra); ?></td>
							<td >&nbsp;</td>
							
					</tr>
		<?php }*/ ?>				
				<tr>
							<td ><?php echo $this->lang->line('amount_paid') ?> : </td>
							<td ><input type="text" name="amount_paid" value="" id="amount_paid" onkeypress="nextField(event.keyCode,save)" autocomplete="off"  size="12"/></td>
							
				</tr>
				<tr>
						<td ><?php echo $this->lang->line('remarks') ?> : </td>
						<td ><textarea name="remarks" cols="15" rows="2" id="remarks" onkeypress="nextField(event.keyCode,save)" autocomplete="off" ></textarea></td>
						
						
				</tr>
					<tr>
							
							<td  ><input type="button" name="save" value="Save" id="button1" class="save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  /></td>
							
					</tr>
					   </table>
					</div>
				</div>
			</div>
			</div><!--row-->
			
			  <input type="hidden" name="item_focus" id="item_focus" value="<?php echo $itemfocus; ?>">
			   <input type="hidden" name="item_focus_select" id="item_focus_select" value="<?php echo $item_focus_select; ?>">
			  <input type="hidden" name="pono" value="0" id="pono"  /></td>
							
				<input type="hidden" name="error" id="error" >
				<input type="hidden" name="item_count" id="item_count" value="<?php echo $itemcount;?>">
				<input type="hidden" name="item_loc" id="item_loc" value="">
				<input type="hidden" name="purchase_mode_selected" id="purchase_mode_selected" value="<?php echo $purchase_mode_selected;?>">
		  <?php }?>
		  
		  
          </section><!-- /.content -->
        </div><!-- /.container -->
		
		      
				
  </form>  
  
  

				<?php
			 $this->load->view("footer"); 
	       ?>
		 
		 <script>
      $(function () {
	 
	   //Date range picker
       $('#bill_date').datepicker();
		
	  });
	  
	 


$(document).ready(function(){


    var item_focus=$("#item_focus").val();
    if(item_focus!=''){
        
        var item_focus_select=$("#item_focus_select").val();
    	$("#"+item_focus_select).focus();
    }


	$( ".remove_item" ).click(function() {
		   
		      $( "#item_loc" ).val($(this).attr('id'));
	    
			   $( "#purchase_return_form" ).attr("action","<?php echo base_url(); ?>index.php/purchase/purchase_return_form");
    			  
			  $( "#purchase_return_form" ).submit();
		   
	});

	
	$( "#supplier" ).change(function() {
		   
		  
	    
			   $( "#purchase_return_form" ).attr("action","<?php echo base_url(); ?>index.php/purchase/purchase_return_form");
    			  
			  $( "#purchase_return_form" ).submit();
		   
		   });
		   
		  $('#brand').bind('keypress', function(e) {
	 
	        if(e.keyCode == 13 ){
				if($('#brand_hidden').val() != ""){
			
				
				$.post("<?php echo base_url(); ?>index.php/brand/valid_brand", $("#purchase_return_form").serialize(),function(data){
				
					if(data['message'] == "Valid Brand"){
					
					
					
						tb_show('Select Batch',"<?php echo base_url(); ?>index.php/batch/select_batch_supplier/"+$('#brand_hidden').val()+"/"+$('#supplier').val());
						
					}else{
					
						$('#message').html("Invalid Brand Selected");
						$('#brand_hidden').val('');						
					}
				
				},"json");
			
			}else{
				$('#message').html("Invalid Brand Selected");
				$('#brand_hidden').val('');	
			}
				
			}
		
	      });
		  $(".save_bill").click(function(){ 
	
	
	var amount_paid = 0;
	
		if($("#amount_paid").val()!=''){
			amount_paid = Number($("#amount_paid").val());
		}
	if($("#payment_type").val() == "CREDIT CARD"){


	
	 amount_paid1=$("#card_amt").val()+$("#amount_paid").val();
	}
	if($("#payment_type").val() == "UPI"){

	 amount_paid_upi=Number($("#upi_amt").val())+Number($("#amount_paid").val());
	}
	
		if($("#bill_no").val() == ""){
			showDialog('Error','Please Enter Bill No.','error',2);
			return false;
		}else if($("#bill_date").val() == ""){
			showDialog('Error','Please Enter Bill Date.','error',2);
			return false;
		}else if($("#supplier").val() == ""){
			showDialog('Error','Please Select Supplier.','error',2);
			return false;
		}else if($("#item_count").val() == 0){
			showDialog('Error','Please Select Atleast One Item in Bill.','error',2);
			return false;
		}else if (!checklist()){
			
		}else if($("#bill_disc_type").val() == '' && $("#bill_disc_value").val() != ''){
		
			$("#bill_disc_value").focus();
			showDialog('Error','Please Select Bill discount Type.','error',2);
			return false;
		}else if($("#bill_disc_type").val() != '' && !isNumeric($("#bill_disc_value").val())){
		
			$("#bill_disc_value").focus();
			showDialog('Error','Please Enter Bill Discount Value.','error',2);
			return false;
			// hffgg
		}else if($("#payment_type").val() == "CASH" && $("#amount_paid").val() ==''){
		
			$("#amount_paid").focus();
			showDialog('Error','Please Enter Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "CASH" && (!isNumeric($("#amount_paid").val()))){
		
			$("#amount_paid").focus();
			showDialog('Error','Please Enter Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "CASH" && (Number($("#amount_paid").val()) != Number($("#round_net_amt").val()))){
		
			$("#amount_paid").focus();
			showDialog('Error','Please Enter Full Amount.','error',2);
			return false;
			}else if($("#payment_type").val() == "CHEQUE" && $("#checque_no").val() == ''){
		
			$("#checque_no").focus();
			showDialog('Error','Please Enter Checque Number.','error',2);
			return false;
		}else if($("#payment_type").val() == "CHEQUE" && (!isNumeric($("#checque_amt").val()) || $("#checque_amt").val() =='')){
		
			$("#checque_amt").focus();
			showDialog('Error','Please Enter Checque Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "CHEQUE" && (Number($("#checque_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#checque_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;

		}else if($("#payment_type").val() == "CREDIT CARD" && (!isNumeric($("#card_amt").val()) || $("#card_amt").val() =='')){
		
			$("#card_amt").focus();
			showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "CREDIT CARD" && (Number($("#card_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#card_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "UPI" && (!isNumeric($("#upi_amt").val()) || $("#upi_amt").val() =='' || $("#upi_amt").val() =='0')){
		
			$("#upi_amt").focus();
			showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "UPI" && (Number($("#upi_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#upi_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;
		}else{
		      $(".save_bill").attr('disabled',true);
			$("#purchase_return_form").attr("action","<?php echo base_url(); ?>index.php/purchase/add_purchase_return");
			$("#purchase_return_form").submit();
		}
	
		
		
	});
	function checklist(){
	
		var item_count=$("#item_count").val();
		
		for(i=0;i<item_count;i++){
		
			k=i+1;
			qty=$("#qty"+i).val();
			if($("#batch"+i).val() == ""){
				showDialog('Error','Please Enter Batch Number for item'+k+'.','error',2);
				$("#batch"+i).focus();
				return false;
			}

			// else if(/^(0[1-9]|1[0-2])\/\d{2}$/.test($("#expiry"+i).val())==false){
			// 	showDialog('Error','Please Enter Valid Expiryfor item'+k+'.','error',2);
			// 	$("#expiry"+i).focus();
			// 	return false;
			// }
			else if(/^(0[1-9]|1[0-2])\/\d{2}$/.test($("#expiry"+i).val())==false){
				showDialog('Error','Please Enter Valid Expiryfor item'+k+'.','error',2);
				$("#expiry"+i).focus();
				return false;
			}
			else if($("#unit"+i).val() == "STRIP" && !isNumeric($("#tpers"+i).val())){
				showDialog('Error','Please Enter No Of Tablets Per Pack for item'+k+'.','error',2);
				$("#disc_value"+i).focus();
				return false;
			}else if($("#unit"+i).val() == "STRIP" && $("#tpers"+i).val()<=0){
				showDialog('Error','Please Enter No Of Tablets Per Pack for item'+k+'.','error',2);
				$("#disc_value"+i).focus();
				return false;
			}else if(!isNumeric($("#qty"+i).val()) || $("#qty"+i).val()=="0" || $("#qty"+i).val()=="" )  {
				showDialog('Error','Please Enter Valid Item quantity for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if(!isNumeric($("#buyp"+i).val())){
				showDialog('Error','Please Enter Valid Buy price for item'+k+'.','error',2);
				$("#buyp"+i).focus();
				return false;
			}else if($("#disc_type"+i).val() != "" && !isNumeric($("#disc_value"+i).val())){
				showDialog('Error','Please Enter Item Discount Amount for item'+k+'.','error',2);
				$("#disc_value"+i).focus();
				return false;
			}else if(!isNumeric($("#sellp"+i).val())){
				showDialog('Error','Please Enter Valid Sellp price for item'+k+'.','error',2);
				$("#sellp"+i).focus();
				return false;
			}
			
		}
	    return true;
	}
	
	      
	
});
document.getElementById("<?php echo $itemfocus;?>").focus();
function tb_remove(){
	
	document.purchase_return_form.item_focus.value='brand';
	document.purchase_return_form.action='<?php echo base_url(); ?>index.php/purchase/purchase_return_form';
	document.purchase_return_form.submit();
}

function process_form(next_focus,pos,loc){

	document.purchase_return_form.item_focus.value=next_focus;
	document.purchase_return_form.action='<?php echo base_url(); ?>index.php/purchase/purchase_return_form';
	document.purchase_return_form.submit();
}
    
	  </script>
	  
     
