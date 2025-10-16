<?php $this->load->view("header");
?> 
<style type="text/css">
	#requiredfield{
        
        color: #FF0000;
    }
</style>
<form name="purchase_form" id="purchase_form" method="post" action="<?php echo base_url(); ?>index.php/purchase/processPurchase">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">

<?php
     $stock_mismatch_error = $this->session->flashdata('stock_mismatch_error'); 
     if(!empty($stock_mismatch_error)) 
       {
?>
        <div id='message' class="callout callout-danger"><?php echo $stock_mismatch_error; ?></div>
<?php
       }
?>

            <h1>
             <?php echo (!empty($paction) && $paction=='Save' )?'New':'Update' ; ?> Purchase 
             
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
				
				<tr>
					
																		
							<td ><?php echo $this->lang->line('bill_no'); ?> : </td>
					
							
							<td ><input type="text" name="bill_no" value="<?php echo $bill_no;?>" id="bill_no" onkeypress="nextField(event.keyCode,bill_date)" autocomplete="off" size="6"  /></td>
							
							<td ><?php echo $this->lang->line('pono'); ?> : </td>
					
							
							<td ><input type="text" name="pono" value="<?php echo $po_no;?>" id="pono" onkeypress="nextField(event.keyCode,date)" autocomplete="off" size="5" readonly="true"  /></td>
											
					
							<td ><?php echo $this->lang->line('date');?> <span id='requiredfield'>*</span>&nbsp;: </td>
					
							<td ><input type="text" name="date" value="<?php echo date("d-m-Y");?>" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" size="8" readonly="true"  /></td>
							
							<td ><?php echo $this->lang->line('bill_date') ?> <span id='requiredfield'>*</span>&nbsp;: </td>
					
							<td ><input type="text" name="bill_date" value="<?php echo $bill_date;?>" id="bill_date" class="DatePicker" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" size="10" readonly="true"  /></td>
							<td ><?php echo $this->lang->line('supplier') ?> <span id='requiredfield'>*</span>&nbsp; : </td>
							
							<td>
								<?php
								  if(!empty($supplier)){?>
								  
								       <select name="supplier" id="supplier" > 		
									<option value=''>------------------------------</option>
											
											<?php for($k=0;$k<count($supplier);$k++){ 
																						
													if(!empty($supplier_selected) && $supplier_selected==$supplier[$k][0]) { ?>
													
														<option value='<?php echo $supplier[$k][0];?>' selected><?php echo $supplier[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $supplier[$k][0];?>'><?php echo  $supplier[$k][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
									
								<?php   } else{ ?>
								<input type="hidden" name="items[<?php echo $i; ?>][9]" value="<?php echo $items_in_array[9]; ?>" />
								<?php } ?>
								</td>
                </tr>
                <tr>
                    <td colspan="9"></td>
                	<td>
                	     <input type="button" name="supplier_create" value="New Supplier" class="create_supplier btn btn-info" id="button1">
                	</td>
                </tr>
				</table>
				</div><!--boxbody-->
			  </div><!--boxinfo-->
			  
			  <div align="center"><?php echo $this->lang->line('brand');?>&nbsp;:&nbsp;
					

					<input name="brand" id="brand" tabbindex="2" onkeypress="if(event.keyCode== 13){return process_form('batch<?php echo($itemcount); ?>','','');}" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
					 
					
					 <input type="hidden" id="brand_hidden" name="brand_ID" >
					 
					 &nbsp;<input type="button" name="brand_create" value="New Brand" class="create_brand btn btn-info" id="button1">					

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
						  <th>Sl</th>
							<th><?php echo $this->lang->line('brand') ?></th>
							<th>Hsn</th>
							<th><?php echo $this->lang->line('batch') ?></th>
							<th><?php echo $this->lang->line('expiry') ?></th>
							<th><?php echo $this->lang->line('pack') ?></th>
							<th><?php echo $this->lang->line('tab') ?>/<?php echo $this->lang->line('strip');?></th>
							<th><?php echo $this->lang->line('qty') ?></th>
							<th><?php echo $this->lang->line('foc') ?></th>
							<th><?php echo $this->lang->line('mrp') ?></th>
							<th><?php echo $this->lang->line('rate') ?></th>
							<th>Vat Inc</th>

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
					?>
							<tr>
							    <td ><?php echo $j++; ?></td>
							    <td>
								<input type="text" name="item[<?php echo $i;?>][1]" id="brand<?php echo $i;?>" value="<?php echo $items[1];?>" onkeypress="nextField(event.keyCode,batch<?php echo $i;?>)" size="7" readonly>

								<br>

								<a href="<?php echo base_url(); ?>index.php/reports/itemwise_previous_purchase_history_report_purchase/<?php echo $items[0];?>" class="thickbox none" title="View Previous Item History"><i class="fa fa-info-circle" style="font-size: 20px;"></i></a>
							</td>
								<td>
								<input type="text" name="item[<?php echo $i; ?>][20]" value="<?php echo $items[20];?>" size="2"></td>
								<td><input type="text" name="item[<?php echo $i;?>][2]" id="batch<?php echo $i;?>" value="<?php echo $items[2];?>" onkeypress="nextField(event.keyCode,expiry<?php echo $i;?>)" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','batch','','expiry<?php echo $i;?>')" size="4" autocomplete="off"></td>

								<!-- <td><input type="text" name="item[<?php echo $i;?>][3]" class="expiry_date" id="expiry<?php echo $i;?>" value="<?php echo $items[3];?>"  size="5" onkeypress = "nextField(event.keyCode,unit<?php echo $i;?>)" readonly></td> -->

                            <!-- MM/YY format -->

								<td><input type="text" name="item[<?php echo $i;?>][3]" placeholder="MM/YY" id="expiry<?php echo $i;?>" value="<?php echo $items[3];?>"  size="5" onkeypress = "nextField(event.keyCode,unit<?php echo $i;?>)" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','expiry','batch<?php echo $i;?>','unit<?php echo $i;?>')" autocomplete="off"></td>

							<!-- MM/YY format -->

								<td><select name="item[<?php echo $i;?>][4]" id="unit<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','4');" onchange="return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','4');">
                                    <option value="NOS" <?php echo ($items[4] == 'NOS')?'selected' :'';?>>NOS</option>
                                    <option value="STRIP" <?php echo ($items[4] == 'STRIP')?'selected' :'';?>>STRIP</option>
                                     </select>                        
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][5]" value="<?php echo $items[5];?>" id="tpers<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('qty<?php echo $i;?>','<?php echo $i;?>','5');}" autocomplete="off" size="2" <?php echo ($items[4] == 'NOS')?'readonly' :'';?> onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','tpers','unit<?php echo $i;?>','qty<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][6]" id="qty<?php echo $i;?>" value="<?php echo $items[6];?>"  size="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('foc<?php echo $i;?>','<?php echo $i;?>','6');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','qty','tpers<?php echo $i;?>','foc<?php echo $i;?>')">
								<?php echo (!empty($batch_stock_error[$i]))?"<br><div id='requiredfield'>".$batch_stock_error[$i]."</div>":'';?>
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][7]" id="foc<?php echo $i;?>" value="<?php echo $items[7];?>"  size="1" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('sellp<?php echo $i;?>','<?php echo $i;?>','7');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','foc','qty<?php echo $i;?>','sellp<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][8]" id="sellp<?php echo $i;?>" value="<?php echo $items[8];?>"  size="2" onkeypress="if(event.keyCode== 13){return process_form('buyp<?php echo $i;?>','<?php echo $i;?>','8');}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g, '')" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','sellp','foc<?php echo $i;?>','buyp<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][9]" id="buyp<?php echo $i;?>" value="<?php echo $items[9];?>"  size="2" onkeypress="if(event.keyCode== 13){return process_form('vat_inc<?php echo $i;?>','<?php echo $i;?>','9');}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g, '')" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','buyp','sellp<?php echo $i;?>','vat_inc<?php echo $i;?>')"></td>
								<td>
									<input type="checkbox" name="item[<?php echo $i;?>][17]" value="1" id="vat_inc<?php echo $i;?>" onchange="return process_form('disc_type<?php echo $i;?>','<?php echo $i;?>','17');" onkeypress="checked_box('vat_inc<?php echo $i;?>','disc_type<?php echo $i;?>')" autocomplete="off" <?php echo (!empty($items[17]) && ($items[17]==1))?'checked':''; ?> onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','vat_inc','buyp<?php echo $i;?>','disc_type<?php echo $i;?>')">
								</td>

								<td><select name="item[<?php echo $i;?>][10]" id="disc_type<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('disc_value<?php echo $i;?>','<?php echo $i;?>','10');" onchange="return process_form('disc_type<?php echo $i;?>','<?php echo $i;?>','10');">
                                    <option value="CASH" <?php echo ($items[10] == 'CASH')?'selected' :'';?>>CASH</option>
                                    <option value="%" <?php echo ($items[10] == '%')?'selected' :'';?>>%</option>
                                     </select>   
                                   <input type="text" name="item[<?php echo $i;?>][11]" value="<?php echo $items[11];?>" id="disc_value<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('gst_class<?php echo $i;?>','<?php echo $i;?>','11');}" autocomplete="off" size="2" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','disc_value','disc_type<?php echo $i;?>','gst_class<?php echo $i;?>')">									 
								</td>


                             <td>
									<input type="checkbox" name="item[<?php echo $i;?>][21]" value="1" id="igst<?php echo $i;?>"  onchange="return process_form('gst_class<?php echo $i;?>','<?php echo $i;?>','21');" onkeypress="checked_box('igst<?php echo $i;?>','gst_class<?php echo $i;?>')" autocomplete="off" <?php echo (!empty($items[21]) && ($items[21]==1))?'checked':''; ?> onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','igst','disc_type<?php echo $i;?>','gst_class<?php echo $i;?>')" >
								</td>






								<td><select name="item[<?php echo $i;?>][12]" id="gst_class<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('brand','','');" onchange="return process_form('gst_class<?php echo $i;?>','<?php echo $i;?>','12');">
                                    <option value=''>--</option>
											
											<?php for($k=0;$k<count($gst_class);$k++){ 
																						
													if(!empty($items[12]) && $items[12]==$gst_class[$k][0]) { ?>
													
														<option value='<?php echo $gst_class[$k][0];?>' selected><?php echo $gst_class[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $gst_class[$k][0];?>'><?php echo  $gst_class[$k][1];?></option>
												
										<?php 		} 
												} ?>
                                     </select>   
                                   <input type="text" name="item[<?php echo $i;?>][13]" value="<?php echo $items[13];?>" id="gst_amt<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','13');}" autocomplete="off" size="2" readonly>
                                   <input type="hidden" name="item[<?php echo $i; ?>][14]" value="<?php echo $items[14];?>" />
                                   <input type="hidden" name="item[<?php echo $i; ?>][15]" value="<?php echo $items[15];?>" />								   
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][16]" id="total<?php echo $i;?>" value="<?php echo $items[16];?>" readonly size="2" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','14');}"></td>
								
								<td> <a href='#' id="<?php echo $i;?>" class='remove_item'><img src="<?php echo base_url(); ?>application/assets/dist/img/delete.png" title='Remove' width='16' height='16' /></a></td>
									
								<input type="hidden" name="item[<?php echo $i; ?>][0]" value="<?php echo $items[0];?>" />
										  
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
							<td ><?php echo $this->lang->line('purchase_amt') ?> : </td>
					
							<td ><input type="text" name="purchase_amt" value="<?php echo $purchase_amt;?>" id="purchase_amt" onkeypress="nextField(event.keyCode,tax)" autocomplete="off" readonly="1"  size="12"/></td>
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
							
						          <select name="bill_disc_type" id="bill_disc_type" onkeypress="if(event.keyCode== 13){return process_form('bill_disc_value','','');}" onchange="return process_form('bill_disc_value','','');">
                                      <option value="" >----------</option>
                                      <option value="CASH" <?php echo ($discount_type == 'CASH')?'selected' :'';?>>CASH</option>
                                      <option value="%" <?php echo ($discount_type == '%')?'selected' :'';?>>%</option>
                                 </select>							&nbsp;
							<input type="text" name="bill_disc_value" value="<?php echo $discount_value;?>" id="bill_disc_value" onkeypress="if(event.keyCode== 13){return process_form('roundstatus','','');}" autocomplete="off" size="5"  />							&nbsp;
							<input type="text" name="disc_amt" value="<?php echo $discount_amt;?>" id="disc_amt" autocomplete="off" readonly="1" size="5"  />	
							</td>					
							
				</tr>
				<!-- <tr>
						<td ><?php echo $this->lang->line('gst_amount') ?> : </td>
						<td ><input type="text" name="gst_amount" value="<?php echo $gst_amount;?>" id="gst_amount" onkeypress="nextField(event.keyCode,taxable_amount)" autocomplete="off" size="12" /></td>
							
				</tr> -->
				<tr>
							<td ><?php echo $this->lang->line('net_total') ?> : </td>
							<td ><input type="text" name="net_total" value="<?php echo $net_amt;?>" id="net_total" onkeypress="nextField(event.keyCode,pono)" autocomplete="off" readonly="1" size="12" /></td>
							
				</tr>
				<tr>
					        <td>Net Total (R/O) : 
					             <input type="checkbox" name="roundstatus" value="1" id="roundstatus" <?php echo (!empty($roundstatus) && ($roundstatus==1))?'checked':'' ?> onchange="process_form('payment_type','','');" onkeypress="if(event.keyCode== 13){return checked_box('roundstatus','payment_type');}">
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
				            <?php

                                if($payment_type_selected == "CASH"){
                                      $nextfieldname="amount_paid";
                                }elseif($payment_type_selected == "CREDIT"){
                                      $nextfieldname="amount_paid";
                                }elseif($payment_type_selected == "CHEQUE"){
                                      $nextfieldname="checque_no";
                                }elseif($payment_type_selected == "CREDIT CARD"){
                                      $nextfieldname="card_amt";
                                 }elseif($payment_type_selected == "NEFT"){
                                      $nextfieldname="neft";
                                }elseif($payment_type_selected == "UPI"){
                                      $nextfieldname="upi_amt";
                                 }

                        
				            ?>
							<td ><?php echo $this->lang->line('payment_type') ?> : </td>
							<td ><select name="payment_type" id="payment_type" onkeypress="if(event.keyCode== 13){return process_form('<?php echo $nextfieldname; ?>','','');}" onchange="return process_form('payment_type','','');">
                                   <option value="CASH" <?php echo ($payment_type_selected == 'CASH')?'selected' :'';?>>CASH</option>
                                   <option value="CREDIT" <?php echo ($payment_type_selected == 'CREDIT')?'selected' :'';?>>CREDIT</option>
                                   <option value="CHEQUE" <?php echo ($payment_type_selected == 'CHEQUE')?'selected' :'';?>>CHEQUE</option>
                                   <option value="CREDIT CARD" <?php echo ($payment_type_selected == 'CREDIT CARD')?'selected' :'';?>>CREDIT CARD</option>
                                   <option value="NEFT" <?php echo ($payment_type_selected == 'NEFT')?'selected' :'';?>>NEFT</option>
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
	<?php	/* if($payment_type_selected == "BRANCH"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('branch') ?> : </td>
							<td ><?php echo form_dropdown('branch',$branch,$branch_selected,$branch_extra); ?></td>
							<td >&nbsp;</td>
							
					</tr>
		<?php }*/ ?>	
		<?php	 if($payment_type_selected == "UPI"){ ?>
				<tr>
							<td ><?php echo $this->lang->line('upi_amt') ?> : </td>
							<td ><input type="text" name="upi_amt" value="" id="upi_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>			
				<tr>
							<td ><?php echo $this->lang->line('amount_paid') ?> : </td>
							<td ><input type="text" name="amount_paid" value="" id="amount_paid" onkeypress="nextField(event.keyCode,remarks)" autocomplete="off"  size="12"/></td>
							
				</tr>
				<tr>
						<td ><?php echo $this->lang->line('remarks') ?> : </td>
						<td ><textarea name="remarks" cols="15" rows="2" id="remarks" onkeypress="nextField(event.keyCode,save)" autocomplete="off" ><?php echo !empty($remarks)?$remarks:''; ?></textarea></td>
						
						
				</tr>
					<tr>
<?php 
      if(empty($batch_stock_change)){
?>			
							<td  ><input type="button" name="save" value="Save" id="button1" class="save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  /></td>
<?php	       
	  }
 
      if(empty($purchase_status)){
?>		
							<td  ><input type="button" name="draft" value="Draft" id="button1" class="draft_bill btn btn-warning" onclick="return submitForm()" style="width: 115px"  /></td>
<?php	       
	  }
?>
							
					</tr>
					   </table>
					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
        </div><!-- /.container -->
		
		        <input type="hidden" name="item_focus" id="item_focus" value="<?php echo $itemfocus; ?>">
		        <input type="hidden" name="item_focus_select" id="item_focus_select" value="<?php echo $item_focus_select; ?>">
				<input type="hidden" name="error" id="error" >
				<input type="hidden" name="item_count" id="item_count" value="<?php echo $itemcount;?>">
				<input type="hidden" name="item_loc" id="item_loc" value="">
				<input type="hidden" name="paction" id="paction" value="<?php echo $paction;?>">
				<input type="hidden" name="purchase_mode_selected" id="purchase_mode_selected" value="<?php echo $purchase_mode_selected;?>">

				<input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo !empty($purchase_id)?$purchase_id:''; ?>">

				<input type="hidden" name="purchase_status" id="purchase_status" value="<?php echo !empty($purchase_status)?$purchase_status:''; ?>">

				<input type="hidden" name="batch_stock_change" id="batch_stock_change" value="<?php echo !empty($batch_stock_change)?$batch_stock_change:''; ?>">

				<input type="hidden" name="newsupplier" id="newsupplier" >

				<input type="hidden" name="sanc_by_hidden" id="sanc_by_hidden" >
				<input type="hidden" name="auth_remarks_hidden" id="auth_remarks_hidden" >
  </form>  
  
  

				<?php
			 $this->load->view("footer"); 
	       ?>
		 
<script>


$(function () {
	 
   //Date range picker
    $('#bill_date').datepicker();
    $('.expiry_date').datepicker();
		 
});
	  
	 


$(document).ready(function(){

	if($("#item_count").val() == 0){

		$("#brand").focus();
    }

    var item_focus=$("#item_focus").val();
    if(item_focus!=''){
        
        var item_focus_select=$("#item_focus_select").val();
    	$("#"+item_focus_select).focus();
    }

	var batch_stock_change=$( "#batch_stock_change" ).val();

	if(batch_stock_change!=''){
		$('#purchase_form').find('input, textarea, button, select').attr('disabled','disabled');
		preventDefault();
	}

	
	$( ".remove_item" ).click(function() {
		   
		      $( "#item_loc" ).val($(this).attr('id'));
	    
			   $( "#purchase_form" ).attr("action","<?php echo base_url(); ?>index.php/purchase/purchase_form");
    			  
			  $( "#purchase_form" ).submit();
		   
		   });

	
   $(".draft_bill").click(function(){
	   
      if($("#item_count").val() == 0){
			showDialog('Error','Please Select Atleast One Item in Bill.','error',2);
			return false;
		}else{
	     $("#purchase_form").attr("action","<?php echo base_url(); ?>index.php/purchase/draft_purchase");
	     $("#purchase_form").submit();
		}
    });	
	$(".save_bill").click(function(){ 
	
	
	var amount_paid = 0;
		if($("#amount_paid").val()!=''){
			amount_paid = Number($("#amount_paid").val());
		}

	if($("#payment_type").val() == "CREDIT CARD"){

	 amount_paid1=Number($("#card_amt").val())+Number($("#amount_paid").val());
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
		}else if($("#payment_type").val() == "CREDIT"){
		
			tb_show('USER AUTHENTICATION',"<?php echo base_url(); ?>index.php/purchase/user_authentication/CREDIT_PURCHASE_BILL_AUTHENTICATION");
			
		}
		// else if($("#payment_type").val() == "CHEQUE" && $("#checque_no").val() == ''){
		
		// 	$("#checque_no").focus();
		// 	showDialog('Error','Please Enter Checque Number.','error',2);
		// 	return false;
		// }else if($("#payment_type").val() == "CHEQUE" && (!isNumeric($("#checque_amt").val()) || $("#checque_amt").val() =='' )){
		
		// 	$("#checque_amt").focus();
		// 	showDialog('Error','Please Enter Checque Amount.','error',2);
		// 	return false;
  //       }
        else if($("#payment_type").val() == "CHEQUE" && (Number($("#checque_amt").val())+amount_paid) > Number($("#round_net_amt").val())){		
			$("#checque_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;

		}else if($("#payment_type").val() == "CREDIT CARD" && (!isNumeric($("#card_amt").val()) || $("#card_amt").val() =='' || $("#card_amt").val() =='0')){
		
			$("#card_amt").focus();
			showDialog('Error','Please Enter Card Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "CREDIT CARD" && (Number($("#card_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#card_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "BRANCH" && $("#branch").val() == ''){
		
			$("#branch").focus();
			showDialog('Error','Please Select Branch.','error',2);
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
			$("#purchase_form").attr("action","<?php echo base_url(); ?>index.php/purchase/add_purchase");
			$("#purchase_form").submit();
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
			}else if($("#expiry"+i).val() == ""){
				showDialog('Error','Please Enter Valid Expiryfor item'+k+'.','error',2);
				$("#expiry"+i).focus();
				return false;
			}
			else if(/^(0[1-9]|1[0-2])\/\d{2}$/.test($("#expiry"+i).val())==false){
				showDialog('Error','Please Enter Valid Expiryfor item'+k+'.','error',2);
				$("#expiry"+i).focus();
				return false;
			}else if($("#unit"+i).val() == "STRIP" && !isNumeric($("#tpers"+i).val())){
				showDialog('Error','Please Enter No Of Tablets Per Pack for item'+k+'.','error',2);
				$("#disc_value"+i).focus();
				return false;
			}else if($("#unit"+i).val() == "STRIP" && $("#tpers"+i).val()<=0){
				showDialog('Error','Please Enter No Of Tablets Per Pack for item'+k+'.','error',2);
				$("#disc_value"+i).focus();
				return false;
			}else if(!isNumeric($("#qty"+i).val())  || $("#qty"+i).val()=="" )  {
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
	
	$('.create_brand').bind('click', function(e) {
	
	  tb_show('Create New Brand',"<?php echo base_url(); ?>index.php/brand/brandForm/create/0/from_purchase");
	
	});
	$('.return_item').bind('click', function(e) {
	
	//tb_show('Return Item',"<?php echo base_url(); ?>index.php/recievings/return_item_form");
	
	});
	
	$('.create_supplier').bind('click', function(e) {
	
	tb_show('Create New Brand',"<?php echo base_url(); ?>index.php/admin/generateForm/supplier/create/0/from_purchase");
	
	});
});

document.getElementById("<?php echo $itemfocus;?>").focus();

function tb_remove(){
	
	document.purchase_form.item_focus.value='';
	document.purchase_form.action='<?php echo base_url(); ?>index.php/purchase/purchase_form';
	document.purchase_form.submit();
}

function process_form(next_focus,pos,loc){

	document.purchase_form.item_focus.value=next_focus;
	document.purchase_form.action='<?php echo base_url(); ?>index.php/purchase/purchase_form';
	document.purchase_form.submit();
}

function checked_box(field,next_focus){
   
   $("#"+field).prop( "checked", true );
   process_form(next_focus,'','');
}

 
	  </script>
	  
     
