<?php $this->load->view("header");

?> 
<style type="text/css">
	#requiredfield{
        
        color: #FF0000;
    }
.flash-button{
	padding:7px 10px;
	color:#fff;
	border:none;
	border-radius:5px;
	
	animation-name: flash;
	animation-duration: 1s;
	animation-timing-function: linear;
	animation-iteration-count: infinite;

	//Firefox 1+
	-webkit-animation-name: flash;
	-webkit-animation-duration: 1s;
	-webkit-animation-timing-function: linear;
	-webkit-animation-iteration-count: infinite;

	//Safari 3-4
	-moz-animation-name: flash;
	-moz-animation-duration: 1s;
	-moz-animation-timing-function: linear;
	-moz-animation-iteration-count: infinite;
}

@keyframes flash {  
    0% { opacity: 1.0; }
    50% { opacity: 0.5; }
    100% { opacity: 1.0; }
}

//Firefox 1+
@-webkit-keyframes flash {  
    0% { opacity: 1.0; }
    50% { opacity: 0.5; }
    100% { opacity: 1.0; }
}

//Safari 3-4
@-moz-keyframes flash {  
    0% { opacity: 1.0; }
    50% { opacity: 0.5; }
    100% { opacity: 1.0; }
}
</style>

<body onload="check_data();">
<form name="invoice_form" id="invoice_form" method="post" action="<?php echo base_url(); ?>index.php/invoice/processInvoiceForm">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1> 

             <?php echo (!empty($paction) && $paction=='Save' )?'New':'Update' ; ?> Invoice
             <?php echo (!empty($sales_mode_selected) && $sales_mode_selected=='Return' )?'Return':'' ; ?> 
             
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
<?php
  if(!empty($sales_mode_selected) && $sales_mode_selected!='Return')
        { 
?>				
				<tr>
				    <td colspan="3"></td>
					<td>
					     <button type="button" id="oplist" class="btn btn-primary btn-block" style="width: 98px;" <?php if ($paction=="Update") {
                    		echo "disabled";} ?> >OP List</button>
					</td>
					<td></td>
					<td colspan="5">
					     <button type="button" id="iplist" class="btn btn-primary btn-block" style="width: 98px;" <?php if ($paction=="Update") {
                    		echo "disabled";} ?> >IP List</button>
					</td>
				</tr>
<?php
        }
?>
				<tr>
	                 
	                <td>
                        Cust Type <span id='requiredfield'>*</span> : 
                    </td>
                    <td>
                        <select name="customer_type" id="customer_type" onkeypress="nextField(event.keyCode,Search);" <?php if ($paction=="Update") {
                    		echo "style='pointer-events:none;'";} ?> >
                    		<option value="OP" <?php echo ($customer_type_select == 'OP')?'selected' :'';?>>OP</option>
                            <option value="IP" <?php echo ($customer_type_select == 'IP')?'selected' :'';?>>IP</option>
                            <option value="DIRECT" <?php echo ($customer_type_select == 'DIRECT')?'selected' :'';?>>DIRECT</option>
                          
                        </select>
                         
                    </td>
                    <td>
                    	OP No : 
                    </td>
                    <td>
                    	<input type="text" name="op_no" value="<?php echo (!empty($op_no) && ($customer_type_select == 'OP'))?$op_no:'';?>" id="op_no" autocomplete="off" size="10" onkeypress="if(event.keyCode== 13){return get_patient_details('op_patient',this.value);}" <?php if ($paction=="Update") {
                    		echo "readonly";} ?> > 
                    </td>
				    <td>
                    	IP No : 
                    </td>
                    <td>
                    	<input type="text" name="ip_no" value="<?php echo (!empty($ip_no) && ($customer_type_select == 'IP'))?$ip_no:'';?>" id="ip_no" autocomplete="off" size="10" onkeypress="if(event.keyCode== 13){return get_patient_details('ip_patient',this.value);}" <?php if ($paction=="Update") {
                    		echo "readonly";} ?> > 
                    </td>
                    <td>
                    	Customer Name <span id='requiredfield'>*</span> : 
                    </td>
                    <td>
                    	<input type="text" name="cust_name" value="<?php echo !empty($customer_name)?$customer_name:'';?>" id="cust_name" onkeypress="nextField(event.keyCode,doctor)" autocomplete="off" size="10" <?php if ($paction=="Update") {
                    		echo "readonly";} ?> > 
                    </td>
                    <td>
                    	Doctor : 
                    </td>
                    <td>
                    	<input type="text" name="doctor" value="<?php echo !empty($doctor)?$doctor:'';?>" id="doctor" autocomplete="off" size="12" onKeyUp="ajax_showOptions(this,'getDoctorList',event,'<?php echo base_url()."index.php/admin";?>')" <?php echo (!empty($op_no) || !empty($ip_no))?'readonly' :'';?> onkeypress="nextField(event.keyCode,brand)" >
                    </td>

                </tr>
				</table>
				</div><!--boxbody-->
			  </div><!--boxinfo-->
<?php
  if(!empty($sales_mode_selected) && $sales_mode_selected!='Return')
         { 
?>				  
			  <div align="center"><?php echo $this->lang->line('brand');?>&nbsp;:&nbsp;
					
					
					<input name="brand" id="brand" tabbindex="2" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
					
					<input type="hidden" id="brand_hidden" name="brand_ID" >
					<input type="hidden" id="batch_hidden" name="batch_ID" >

					&nbsp;<input type="button" name="prescription" value="Prescribed Medicines" class="btn btn-info" id="prescription"  />

					&nbsp;<input type="button" name="doc_prescr" value="Doctor Prescription" class="btn btn-info" id="doc_prescr"  />

					&nbsp;<input type="button" name="nurse_prescr" value="Nurse Prescription" class="btn btn-info" id="nurse_prescr"  />	
					 
					 </div>
<?php
         }
?>
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
							<th><?php echo $this->lang->line('mode') ?></th>
							<th><?php echo $this->lang->line('brand') ?></th>
							<th>Hsn</th>
							<th><?php echo $this->lang->line('batch') ?></th>
							<th><?php echo $this->lang->line('expiry') ?></th>
							<th><?php echo $this->lang->line('selling_unit') ?></th>

                            <?php
					          if( !empty($sales_mode_selected) && $sales_mode_selected=='Return' && $paction !='Update')
						        { 
				      ?>
						                            <th>Saled Qty</th>
						                            <!-- <th>Avl Qty</th>      -->
					 <?php
						        }
					 ?>

							<th><?php echo $this->lang->line('qty') ?></th>						
							<th><?php echo $this->lang->line('mrp') ?></th>
							<th>CGST</th>
							<th>SGST</th>
							<th>F.Cess1%</th>
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
							    <td><select name="item[<?php echo $i;?>][1]" id="sales_mode<?php echo $i;?>">
								<?php if($items[1]=='Sales'){ ?>
                                        <option value="Sales">Sales</option>
                                <?php }elseif($items[1]=='Return'){ ?>    
                                        <option value="Return">Return</option>
                                <?php } ?>
                                     </select>                         
								</td>
							    <td>
								<input type="text" name="item[<?php echo $i;?>][2]" id="brand<?php echo $i;?>" value="<?php echo $items[2];?>" onkeypress="nextField(event.keyCode,batch<?php echo $i;?>)" size="30" readonly></td>
                                <td>
								<input type="text" name="item[<?php echo $i; ?>][19]" value="<?php echo $items[19];?>" size="2" readonly></td><!-- hsn_no -->
                                </td>
								<td><input type="text" name="item[<?php echo $i;?>][3]" id="batch<?php echo $i;?>" value="<?php echo $items[3];?>" onkeypress="nextField(event.keyCode,expiry<?php echo $i;?>)" size="4" readonly>
								<?php
								    if(empty($items[3])){
                                ?>
                                    <br>
                                    <a href="#"  id="select_batch" class="select_batch" title="select_batch" onclick="select_batch('<?php echo $items[0]; ?>','<?php echo $i; ?>')">select batch</a> 
                                <?php
								    } 
								?>


								</td>
								<td><input type="text" name="item[<?php echo $i;?>][4]" id="expiry<?php echo $i;?>" value="<?php echo $items[4];?>"  size="5" onkeypress = "nextField(event.keyCode,unit<?php echo $i;?>)" readonly></td>
								<td><select name="item[<?php echo $i;?>][5]" id="unit<?php echo $i;?>">
								     <?php if($items[5]=='NOS'){ ?>
                                              <option value="NOS">NOS</option>
                                     <?php }elseif($items[5]=='STRIP'){ ?>    
                                              <option value="STRIP">STRIP</option>
                                     <?php } ?>
                                    </select>
                                </td>

                                     <?php
						if(!empty($sales_mode_selected) && $sales_mode_selected=='Return' && $paction !='Update')
						        { 
						?> 
                                <td>


                                 <input type="text" name="item[<?php echo $i;?>][26]" id="sale_qty<?php echo $i;?>" value="<?php echo $items[26];?>" size="2" readonly>
                                </td>
                                <input type="hidden" name="item[<?php echo $i;?>][28]" id="avilable_qty<?php echo $i;?>" value="<?php echo $items[28];?>" size="2" readonly>
                                </td>
                                <input type="hidden" name="item[<?php echo $i;?>][27]" id="return_qty<?php echo $i;?>" value="<?php echo $items[27];?>" size="2" readonly>
                                </td>
   
						<?php
					}
						?>

								<td><input type="text" name="item[<?php echo $i;?>][6]" id="qty<?php echo $i;?>" value="<?php echo $items[6];?>"  size="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','6');}" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','qty','qty<?php echo $i;?>','qty<?php echo $i;?>')" autocomplete="off">
								<?php echo (!empty($batch_error[$i]))?"<br><div id='requiredfield'>".$batch_error[$i]."</div>":'';?>
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][7]" id="mrp<?php echo $i;?>" value="<?php echo $items[7];?>" size="3" readonly></td>

								<td><input type="text" name="item[<?php echo $i; ?>][22]" value="<?php echo $items[22];?>" size="2" readonly ></td><!-- cgst_amt -->

								<td><input type="text" name="item[<?php echo $i; ?>][21]" value="<?php echo $items[21];?>" size="2" readonly></td><!-- sgst_amt -->

								<td><input type="text" name="item[<?php echo $i; ?>][25]" value="<?php echo $items[25];?>" size="2" readonly/></td><!-- total_flood_cess -->

								<td><input type="text" name="item[<?php echo $i;?>][9]" id="total<?php echo $i;?>" value="<?php echo $items[9];?>" size="4" readonly></td>
								
								<td> <a href='#' id="<?php echo $i;?>" class='remove_item'><img src="<?php echo base_url(); ?>application/assets/dist/img/delete.png" title='Remove' width='16' height='16' /></a>
                                 <?php if(!empty($sales_mode_selected) && $sales_mode_selected=='Return' && $paction !='Update') 
						        {  ?>

                                <a href="<?php echo base_url(); ?>index.php/reports/itemwise_detailed_report_invoice/<?php echo $items[0];?>/<?php echo $return_billid;?>/<?php echo $sales_mode_selected; ?>" 
                                    class="thickbox none" title="View Item Bill Information"><i class="fa fa-info-circle"></i></a>
						      <?php

					          }

						      ?>

								</td>

								    <input type="hidden" name="item[<?php echo $i; ?>][8]" value="<?php echo $items[8];?>" /><!-- sellp -->
                                    
								    <input type="hidden" name="item[<?php echo $i; ?>][10]" id="stock<?php echo $i;?>" value="<?php echo $items[10];?>" /><!-- BatchStock -->
									
									<input type="hidden" name="item[<?php echo $i; ?>][0]" value="<?php echo $items[0];?>" /><!-- brand_id -->
									<input type="hidden" name="item[<?php echo $i; ?>][18]" value="<?php echo $items[18];?>" /><!-- batch_id -->
									<input type="hidden" name="item[<?php echo $i; ?>][11]" value="<?php echo $items[11];?>" /><!-- gst_id -->
									<input type="hidden" name="item[<?php echo $i; ?>][12]" value="<?php echo $items[12];?>" /><!-- gst_per -->
									<input type="hidden" name="item[<?php echo $i; ?>][13]" value="<?php echo $items[13];?>" /><!-- sgst_per -->
									<input type="hidden" name="item[<?php echo $i; ?>][14]" value="<?php echo $items[14];?>" /><!-- cgst_per -->
									<input type="hidden" name="item[<?php echo $i; ?>][15]" value="<?php echo $items[15];?>" /><!-- gst_amt -->
									<input type="hidden" name="item[<?php echo $i; ?>][16]" value="<?php echo $items[16];?>" /><!-- sgst_amt -->
									<input type="hidden" name="item[<?php echo $i; ?>][17]" value="<?php echo $items[17];?>" /><!-- cgst_amt -->

									<input type="hidden" name="item[<?php echo $i; ?>][20]" value="<?php echo $items[20];?>" /><!-- total_gst_amt -->
									    <input type="hidden" name="item[<?php echo $i; ?>][23]" id="stocks<?php echo $i;?>" value="<?php echo !empty($items[23])?$items[23]:'';?>" /><!-- BatchStock -->

								   <!--  ........FLOOD CESS CALCULATIONS....(1% TAXABLE VALUE  INCREASE FOR 2 YRS -01/08/2019   TO 2021)..-->

									<input type="hidden" name="item[<?php echo $i; ?>][24]" value="<?php echo $items[24];?>" /><!-- flood_cess_amt -->
								
		<!--........... FLOOD CESS CALCULATIONS..........-->
										  
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
							<td>Date : </td>
					
							<td><input type="text" name="date" value="<?php echo $bill_date; ?>" autocomplete="off" size="8" readonly="true"></td>
					   </tr>
<?php
  if(!empty($sales_mode_selected) && $sales_mode_selected=='Sales')
        { 
?>
					   <tr>
							<td>Sales Amount : </td>
					
							<td><input type="text" name="sales_amt" value="<?php echo $sales_amt; ?>" id="sales_amt" autocomplete="off" readonly="1" size="12"></td>
						
					</tr>
<?php

        }

  if(!empty($sales_mode_selected) && $sales_mode_selected=='Return')
        { 
?>					
					<tr>
							<td>Returns Amount : </td>
					
							<td><input type="text" name="return_amt" value="<?php echo $return_amt; ?>" id="return_amt" autocomplete="off" readonly="1"></td>
						
					</tr>
<?php
        }
?>
                    <tr>
							<td >CGST : </td>
							<td ><input type="text" name="tot_cgst" id="tot_cgst" value="<?php echo $tot_cgst; ?>" readonly="1" size="12" /></td>
							
					</tr>
         
					<tr>
							<td >SGST : </td>
							<td ><input type="text" name="tot_sgst" id="tot_sgst" value="<?php echo $tot_sgst; ?>" readonly="1"  size="12"/></td>
							
					</tr>

                    <!-- flood cess 1%  -->
                    <tr>
							<td >Flood Cess : </td>
							<td ><input type="text" name="tot_flood_cess" id="tot_flood_cess" value="<?php echo $tot_flood_cess; ?>" readonly="1"  size="12"/></td>
							
					</tr>

                    <!-- flood cess 1%  -->

					<tr>
							<td>Bill Total : </td>
							<td><input type="text" name="bill_total" value="<?php echo $total_bill; ?>" id="bill_total" autocomplete="off" readonly="1" size="12"></td>
							
					</tr>

                     <tr>
				            <td>Free Bill: </td>
				            <td> <input type="checkbox" name="free_bill" value="1" id="free_bill" <?php echo (!empty($free_bill) && ($free_bill==1))?'checked':'' ?> onchange="return checked_box2('free_bill','save');" onkeypress="if(event.keyCode== 13){return process_form('','','');}"></td>

				            
				</tr>


				<tr>
							<td  colspan="2">Discount : </td>
				</tr>
				<tr>
							<td  colspan="2">
							
						          <select name="bill_disc_type" id="bill_disc_type" onkeypress="if(event.keyCode== 13){return process_form('bill_disc_value','','');}" onchange="return process_form('bill_disc_value','','');"  >
                                      <option value="" >----------</option>
                                      <option value="CASH" <?php echo ($discount_type == 'CASH')?'selected' :'';?>>CASH</option>
                                      <option value="%" <?php echo ($discount_type == '%')?'selected' :'';?>>%</option>
                                 </select>&nbsp;
							     <input type="text" name="bill_disc_value" value="<?php echo $discount_value;?>" id="bill_disc_value" onkeypress="if(event.keyCode== 13){return process_form('roundstatus','','');}" autocomplete="off" size="5" />&nbsp;
							     <input type="text" name="disc_amt" value="<?php echo $discount_amt;?>" id="disc_amt" autocomplete="off" readonly="1" size="5"  />	
							</td>					
							
				</tr>
				<tr>
							<td>Net Total : </td>
							<td><input type="text" name="net_total" value="<?php echo $net_amt;?>" id="net_total" autocomplete="off" readonly="1" size="12"></td>
							
				</tr>
				<tr>
					        <td>Net Total (R/O) : 
					             <input type="checkbox" name="roundstatus" value="1" id="roundstatus" <?php echo (!empty($roundstatus) && ($roundstatus==1))?'checked':'checked' ?> onchange="checked_box('roundstatus','payment_type');" onkeypress="if(event.keyCode== 13){return checked_box('roundstatus','payment_type');}">
					        </td>
					        <td>
					             <input type="text" name="round_net_amt" value="<?php echo $round_net_amt;?>" id="round_net_amt" autocomplete="off" readonly="1" size="12" />
					        </td>
				</tr>
				<tr>
				            <td>R/O : </td>
				            <td><input type="text" name="round_amt" value="<?php echo $round_amt ?>" id="round_amt" autocomplete="off" readonly="1" size="12"></td>
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
                           }elseif($payment_type_selected == "BRANCH"){
                              $nextfieldname="branch";
                           }
                           elseif($payment_type_selected == "UPI"){
                              $nextfieldname="upi_amount";
                           }

				    ?>
					        <td>
					        	Payment Type : 
					        </td>
					        <td>
					        	<select name="payment_type" id="payment_type" onkeypress="if(event.keyCode== 13){return process_form('<?php echo $nextfieldname; ?>','','');}" onchange="return process_form('payment_type','','');"  >
                                       <option value="CASH" <?php echo ($payment_type_selected == 'CASH')?'selected' :'';?>>CASH</option>
                                       <option value="CREDIT" <?php echo ($payment_type_selected == 'CREDIT')?'selected' :'';?>>CREDIT</option>
                                       <option value="CHEQUE" <?php echo ($payment_type_selected == 'CHEQUE')?'selected' :'';?>>CHEQUE</option>
                                       <option value="CREDIT CARD" <?php echo ($payment_type_selected == 'CREDIT CARD')?'selected' :'';?>>CREDIT CARD</option>
                                      <!--  <option value="BRANCH" <?php// echo ($payment_type_selected == 'BRANCH')?'selected' :'';?>>BRANCH</option> -->
                                      <option value="UPI" <?php echo ($payment_type_selected == 'UPI')?'selected' :'';?>>UPI</option>
                                </select>
					        </td>
				</tr>
				<?php	 if($payment_type_selected == "CHEQUE"){ ?>
				<tr>
							<td >Checque No : </td>
							<td ><input type="text" name="checque_no" value="" id="checque_no" onkeypress="nextField(event.keyCode,checque_amt)" autocomplete="off" size="12"></td>
							
				</tr>
				<tr>
							<td >Checque Amount : </td>
							<td ><input type="text" name="checque_amt" value="" id="checque_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>
	<?php	 if($payment_type_selected == "CREDIT CARD"){ ?>
				<tr>
							<td >Card Amount : </td>
							<td ><input type="text" name="card_amt" value="" id="card_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>
	<?php } ?>
	<?php	 if($payment_type_selected == "BRANCH"){ ?>
				<tr>
                      <td >Branch : </td>
                      <td >
                           <select name="branch" id="branch" onkeypress="if(event.keyCode== 13){return process_form('amount_paid','','');}" onchange="return process_form('amount_paid','','');">

                                <option value="">------select-----</option>
                        <?php 
                            for($i=0; $i<count($branchInfo); $i++) { 
                
                        ?>
                                <option value="<?php echo $branchInfo[$i][0]; ?>" <?php echo (!empty($branch_select) && ($branch_select==$branchInfo[$i][0]))?'selected':'' ?>>  
                                           <?php echo $branchInfo[$i][1]; ?>
                                </option>  
                        <?php
                            }
                        ?>
</select>
                      </td>
						
				</tr>
	<?php } ?>

	<?php	 if($payment_type_selected == "UPI"){ ?>
				<tr>
							<td >UPI Amount : </td>
							<td ><input type="text" name="upi_amt" value="" id="upi_amt" onkeypress="nextField(event.keyCode,amount_paid)" autocomplete="off" size="12"></td>
							
				</tr>

	<?php } ?>
				<tr>
					        <td>
					        	Amount Paid : 
					        </td>
					        <td>
					        	<input type="text" name="amount_paid" value="<?php echo ($payment_type_selected == 'CASH')?$round_net_amt :'';?>" id="amount_paid" onkeypress="nextField(event.keyCode,remarks)" autocomplete="off" size="12">
					        </td>
				</tr>
				<tr>
				            <td>
				            	Remarks : 
				            </td>
					        <td>
					           <textarea name="remarks" cols="15" rows="2" id="remarks" onkeypress="nextField(event.keyCode,save)" autocomplete="off" ><?php echo !empty($remarks)?$remarks:''; ?></textarea>
					        </td>
				</tr>


<!-- 				<?php 

					if (isset($payment_status) && $payment_status==0 && ($paction == "Save" || $draft== 'YES') && $customer_type_select=="OP" ) {?>


						<tr>
						            <td>
						            	OP REG Amount : 
						            
							           <input type="button" name="op_reg_amount" value="<?php echo $op_reg_amount; ?>" id="op_reg_amount" class="btn btn-danger flash-button" style="width: 93px;padding: 1px 7px !important;">
							        </td>

							        <td>
							        	<input type="checkbox" name="op_payment" value="1" id="op_payment" <?php echo (!empty($op_payment) && ($op_payment==1))?'checked':'' ?> >
							        </td>
						</tr>


						<tr>
						            <td>
						            	ONLY OP REG : 

							        </td>

							        <td>
							        	<input type="checkbox" name="only_op" value="1" id="only_op" <?php echo (!empty($only_op) && ($only_op==1))?'checked':'' ?> >
							        </td>
						</tr>



					<?php
					}
					else if ($paction=="Update" && $invoice_bill_date == date("Y-m-d") && $customer_type_select=="OP" ) {?>

						<tr>
						            <td>
						            	OP REG Amount : 
						            
							           <input type="button" name="op_reg_amount" value="<?php echo $op_reg_amount; ?>" id="op_reg_amount" class="btn btn-danger flash-button" style="width: 93px;padding: 1px 7px !important;">
							        </td>

							        <td>
							        	<input type="checkbox" name="op_payment" value="1" id="op_payment" <?php echo (!empty($payment_status) && ($payment_status==1))?'checked':'' ?> >
							        </td>
						</tr>

					<?php
					}


				?>
 -->







				<tr>   <?php  if(!empty($paction) && $paction == 'Update' && (empty($draft) || ($draft !='YES')) ){
?>

                             <td>
					        	<input type="button" name="save" value="Update Bill" id="button1" class="button1 save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  />
					        </td>

<?php }else{?>
					        <td>
					        	<input type="button" name="save" value="Save Bill" id="button1" class="button1 save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  />

					        	<input type="button" name="save_op" value="Save OP" id="save_op" class="save_op btn btn-primary" style="width: 115px"  />
					        </td>
					        <?php 
  }if(!empty($sales_mode_selected) && $sales_mode_selected=='Sales' && (($paction=='Save')  || ($paction=='Update') && !empty($draft) && ($draft== 'YES') ) )
        { 
?>

					           <td  ><input type="button" name="draft" value="Draft" id="button1" class="button1 draft_bill btn btn-warning" onclick="return submitForm()" style="width: 115px"  /></td>
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
				<input type="hidden" name="billid" id="billid" value="<?php echo !empty($billid)?$billid:''; ?>">
 
				<input type="hidden" name="op_id" id="op_id" value="<?php echo (($customer_type_select == 'OP') && !empty($op_id))?$op_id:'';?>" >

                <input type="hidden" name="sanc_by_hidden" id="sanc_by_hidden" >
				<input type="hidden" name="auth_remarks_hidden" id="auth_remarks_hidden" >

				<input type="hidden" name="sales_mode_selected" id="sales_mode_selected" value="<?php echo $sales_mode_selected; ?>">

				<input type="hidden" name="select_batch_position" id="select_batch_position" value=""> 
<!-- Total gst values -->

            <input type="hidden" name="tot_gst" id="tot_gst" value="<?php echo $tot_gst; ?>">

            <input type="hidden" name="ip_medicines_id" id="ip_medicines_id" value="<?php echo !empty($ip_medicines_id)?$ip_medicines_id:''; ?>">
            
            <input type="hidden" name="doct_presc" id="doct_presc" value="<?php echo !empty($doct_presc)?$doct_presc:''; ?>">
        


<!-- Total gst values -->

				<div id="doctor_prescriptions"><!--Doctor prescription list hidden fields--></div>

			<input type="hidden" name="doc_id" id="doc_id" value="<?php echo !empty($doc_id)?$doc_id:''; ?>">

			<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo !empty($invoice_id)?$invoice_id:''; ?>">

				<input type="hidden" name="invoice_status" id="invoice_status" value="<?php echo !empty($invoice_status)?$invoice_status:''; ?>">
				<!-- <input type="hidden" id="batch_hidden" name="batch_id" value="<?php echo !empty($batch_id)?$batch_id:''; ?>" > -->
				<?php  if($customer_type_select=='IP'){?>
					<input type="hidden" id="opno" name="opno" value="<?php echo !empty($op_num)?$op_num:''; ?>" >
					<input type="hidden" id="ipno" name="ipno" value="<?php echo !empty($ip_no)?$ip_no:''; ?>" >

				<?php }else{?>
				<input type="hidden" id="opno" name="opno" value="<?php echo !empty($op_no)?$op_no:''; ?>" >
			<?php }?>
				<input type="hidden" id="draft" name="draft" value="<?php echo !empty($draft)?$draft:''; ?>" >
				<input type="hidden" id="refresh_data" name="refresh_data" value="<?php echo !empty($refresh_data)?$refresh_data:''; ?>" >
              <?php //if(!empty($draft) && $draft=='YES') { ?>
				  
				     <input type="hidden" name="op_medicines_id" id="op_medicines_id" value="<?php echo !empty($op_medicines_id)?$op_medicines_id:''; ?>">
				<?php// }else{ ?>
				         <input type="hidden" name="op_medicine_id" id="op_medicine_id" value="<?php echo !empty($op_mid)?$op_mid:''; ?>">
				    <?php// }?>
	<input type="hidden" id="edit_status" name="edit_status" value="<?php echo !empty($edit_status)?$edit_status:''; ?>" >

	   <input type="hidden" name="return_bill" id="return_bill" value="<?php echo (!empty($return_billid)?$return_billid:'0'); ?>">

	   <input type="hidden" id="search_from" name="search_from" value="<?php echo !empty($search_from)?$search_from:''; ?>" >

	   <input type="hidden" id="ref_no_search" name="ref_no_search" value="<?php echo !empty($ref_no_search)?$ref_no_search:''; ?>" >
				
		<input type="hidden" id="invoice_bill_date" name="invoice_bill_date" value="<?php echo !empty($invoice_bill_date)?$invoice_bill_date:''; ?>" >
	   <input type="hidden" id="free_bill_status" name="free_bill_status" value="<?php echo !empty($free_bill)?$free_bill:'0'; ?>" >

	   <input type="hidden" name="select_batch_position_pres" id="select_batch_position_pres" value="<?php echo $select_batch_position_pres; ?>"> 

	   <input type="hidden" name="select_batch_position_pres" id="select_batch_position_pres" value="<?php echo $select_batch_position_pres; ?>"> 

	   <input type="hidden" name="payment_status" id="payment_status" value="<?php echo $payment_status; ?>"> 

		
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

    if($("#customer_type").val() == "OP"){

	    $("#prescription").show();
	    $("#doc_prescr").hide();
		$("#nurse_prescr").hide();

    }else if($("#customer_type").val() == "IP"){

		$("#prescription").hide();
		$("#doc_prescr").show();
		$("#nurse_prescr").show();

	}else{

		$("#prescription").hide();
		$("#doc_prescr").hide();
		$("#nurse_prescr").hide();

	}
		
	if($("#item_count").val() == 0){

		$("#brand").focus();
    }

    var item_focus=$("#item_focus").val();

if ($("#select_batch_position_pres").val() == 0 || $("#select_batch_position_pres").val()!="") {
    	var i = $("#select_batch_position_pres").val();
    	$("#qty"+i).focus();
    }

    else if(item_focus!=''){
        
        var item_focus_select=$("#item_focus_select").val();
    	$("#"+item_focus_select).focus();
    }
    else if ($("#customer_type").val() == "DIRECT") {
    	$("#cust_name").focus();
    } else if ($("#customer_type").val() == "OP") {
    	$("#op_no").focus();
    }


	if($("#customer_type").val() == "OP"){
		
		$('#ip_no').attr('readonly','readonly');

		$('#iplist').attr('disabled','disabled');

		$('#cust_name').attr('readonly','readonly');
		$('#doctor').attr('readonly','readonly');

		// $("#op_no").focus();
		
	}else if($("#customer_type").val() == "IP"){
	
		$('#cust_name').attr('readonly','readonly');


		$('#op_no').attr('readonly','readonly');

		$('#oplist').attr('disabled','disabled');
		$('#doctor').attr('readonly','readonly');

		// $("#ip_no").focus();

	}else if($("#customer_type").val() == "DIRECT"){
            
         $('#cust_name').attr('readonly',false);

	    $('#ip_no').attr('readonly','readonly');
		$('#op_no').attr('readonly','readonly');
		
		$('#iplist').attr('readonly','readonly');
		$('#oplist').attr('readonly','readonly');

		$('#oplist').attr('disabled','disabled');
		$('#iplist').attr('disabled','disabled');
		
		
	}

	 var item_focus=$("#item_focus").val();
    if(item_focus =='brand'){
		
		$("#brand").focus();
		
	}else if(item_focus!=''){
        
        var item_focus_select=$("#item_focus_select").val();
    	$("#"+item_focus_select).focus();
    }
    
$('#brand').bind('keypress', function(e) {


	
			if ($('#invoice_id').val()=="") {
				$('#invoice_id').val('0');
			}
			if ($('#draft').val()=="" && $('#edit_status').val() !="" ) {
				$('#draft').val('EDIT');
			}else if($('#draft').val()=="" && $('#edit_status').val() =="" ) {
				$('#draft').val('NO');
			}
	 
	        if(e.keyCode == 13 ){
				if($('#brand_hidden').val() != ""){
			
				
				$.post("<?php echo base_url(); ?>index.php/brand/valid_brand", $("#invoice_form").serialize(),function(data){
				
					if(data['message'] == "Valid Brand"){
					// alert($('#opno').val());
						tb_show('Select Batch',"<?php echo base_url(); ?>index.php/invoice/select_batch/"+$('#brand_hidden').val()+'/'+$('#invoice_id').val()+'/'+$('#draft').val()+'/'+$('#opno').val());
						
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

	$( ".remove_item" ).click(function() {

			  var ip_medicines_id = $("#ip_medicines_id").val();

			  if (ip_medicines_id!="") {

			  	var ip_medicines_id = ip_medicines_id.split(",");

			  		for (var i = 0; i < ip_medicines_id.length; i++) {

					    if(ip_medicines_id[i] == ip_medicines_id[$(this).attr('id')]) {
					      ip_medicines_id.splice(i, 1);
					       ip_medicines_id.join(",");
					    }

			  		}

			  		$("#ip_medicines_id").val(ip_medicines_id);

			  }

			  var op_medicines_id = $("#op_medicines_id").val();

			  if (op_medicines_id!="") {

			  	var op_medicines_id = op_medicines_id.split(",");

			  		for (var i = 0; i < op_medicines_id.length; i++) {

					    if(op_medicines_id[i] == op_medicines_id[$(this).attr('id')]) {
					      op_medicines_id.splice(i, 1);
					       op_medicines_id.join(",");
					    }

			  		}

			  		$("#op_medicines_id").val(op_medicines_id);

			  }

		   
		      $( "#item_loc" ).val($(this).attr('id'));
	    
			   $( "#invoice_form" ).attr("action","<?php echo base_url(); ?>index.php/invoice/invoice_form");
    			  
			  $( "#invoice_form" ).submit();
		   
	});


	// $('#customer_type').change(function() {
		
	// 	if($("#customer_type").val() == "OP"){

	// 		tb_show('Select OP Patient',"<?php echo base_url(); ?>index.php/invoice/op_patinet_list");

	// 	}else if($("#customer_type").val() == "IP"){

	// 		tb_show('Select IP Patient',"<?php echo base_url(); ?>index.php/invoice/ip_patient_list");
	// 	}else{
		
	// 		$('#op_id').val('');
	// 		$('#ip_no').val('');
	// 		$('#op_no').val('');
	// 		$('#cust_name').val('');
	// 		$('#doctor').val('');

	// 		$('#invoice_form').attr('action',"<?php echo base_url(); ?>index.php/invoice/invoice_form");
 //            $('#invoice_form').submit();
	// 	}
	// });

	$('#customer_type').change(function() {
		
		if($("#customer_type").val() == "OP"){

			$("#prescription").show();
		    $("#doc_prescr").hide();
		    $("#nurse_prescr").hide();

			$('#ip_no').attr('readonly','readonly');
		   
		    $('#cust_name').attr('readonly','readonly');

		    $('#doctor').attr('readonly','readonly');

 

			$('#op_no').prop("readonly", false);

			$('#ip_no').val("");

			$('#cust_name').val("");

			$('#doctor').val("");

			$('#doc_id').val("");

			$('#opno').val("");

			$('#ipno').val("");

			$('#oplist').attr('disabled',false);

			$('#iplist').attr('disabled','disabled');

		    $("#op_no").focus();

		}else if($("#customer_type").val() == "IP"){

			$("#prescription").hide();
		    $("#doc_prescr").show();
		    $("#nurse_prescr").show();

			$('#op_no').attr('readonly','readonly');

	     	$('#cust_name').attr('readonly','readonly');

		    $('#doctor').attr('readonly','readonly');



			$('#ip_no').prop("readonly", false);

			$("#customer_type").val('IP');

			$('#op_no').val("");

			$('#ip_no').val("");

			$('#cust_name').val("");

			$('#doctor').val("");

			$('#doc_id').val("");
	      
	        $('#opno').val("");

	        $('#op_id').val("");


			$('#iplist').attr('disabled',false);

			$('#oplist').attr('disabled','disabled');

			$("#ip_no").focus();

		}else{

			$("#prescription").hide();
		    $("#doc_prescr").hide();
		    $("#nurse_prescr").hide();


			$('#op_no').attr('readonly','readonly');

			$('#ip_no').attr('readonly','readonly');

			$('#cust_name').attr('readonly',false);

			$('#doctor').attr('readonly',false);



			$('#op_no').val("");

			$('#ip_no').val("");

			

			$('#cust_name').val("");

			$('#doctor').val("");

			$('#doc_id').val("");
			
	       

			$('#op_id').val("");
			$('#opno').val("");

			$('#ipno').val("");

			$('#oplist').attr('disabled','disabled');

			$('#iplist').attr('disabled','disabled');

			$('#cust_name').focus();

		}
	});


    $('#oplist').click(function() {
		
		     
			tb_show('Select OP Patient',"<?php echo base_url(); ?>index.php/invoice/op_patinet_list");
		
	});
    $('#iplist').click(function() {
		
		 
			tb_show('Select IP Patient',"<?php echo base_url(); ?>index.php/invoice/ip_patient_list");
		
	});

	$('#prescription').click(function() {
		
			var op_id = $('#op_id').val();

			var item_count = $('#item_count').val();

			var ip_no = $('#ip_no').val();

          //  var draft =$('#draft').val();
			// alert(ip_no);
			
			if (op_id!=""){
				tb_show('Prescribed Medicines',"<?php echo base_url(); ?>index.php/invoice/doctor_prescription/"+op_id+"/"+item_count);
            
			   //tb_show('Prescribed Medicines',"<?php //echo base_url(); ?>index.php/invoice/doctor_prescription/"+op_id+"/"+item_count+"/"+draft);
			}else{
				showDialog('Error','Please select an OP Patient or an IP Patient','error',2);
			}	

	});

	$('#nurse_prescr').click(function() {

		var op_id = $('#op_id').val();

		var item_count = $('#item_count').val();

		var ip_no = $('#ip_no').val();

		if (ip_no!="") {

		tb_show('Nurse Prescribed Medicines IP',"<?php echo base_url(); ?>index.php/invoice/doctor_prescription_ip/"+ip_no+"/"+item_count);

		}else{
				showDialog('Error','Please select an OP Patient or an IP Patient','error',2);
		}
		
	});

	$('#doc_prescr').click(function() {

		var op_id = $('#op_id').val();

		var item_count = $('#item_count').val();

		var ip_no = $('#ip_no').val();

		if (ip_no!="") {

		tb_show('Doctor Prescribed Medicines IP',"<?php echo base_url(); ?>index.php/invoice/get_doctor_prescription_ip/"+ip_no+"/"+item_count);

		}else{
				showDialog('Error','Please select an OP Patient or an IP Patient','error',2);
		}
		
	});

    $(".draft_bill").click(function(){
	   
      if($("#item_count").val() == 0){
			showDialog('Error','Please Select Atleast One Item in Bill.','error',2);
			return false;
	    }else if($("#cust_name").val() == ""){
			showDialog('Error','Please Enter Patient Name.','error',2);
			return false;
		}else{
	     $("#invoice_form").attr("action","<?php echo base_url(); ?>index.php/invoice/add_draft_invoice");
	     $("#invoice_form").submit();
		}
    });	

	$(".save_bill").click(function(){

			var amount_paid = 0;
		if($("#amount_paid").val()!=''){
			amount_paid = Number($("#amount_paid").val());
		}

	    if($("#cust_name").val() == ""){
			showDialog('Error','Please Enter Patient Name.','error',2);
			return false;
		}else if($("#item_count").val() == 0){
			showDialog('Error','Please Select Atleast One Item in Bill.','error',2);
			return false;
		}else if (!checklist()){
			
		}else if($("#bill_disc_type").val() == '' && $("#bill_disc_value").val() != ''){
		
			$("#bill_disc_type").focus();
			showDialog('Error','Please Select Bill discount Type.','error',2);
			return false;
		}else if($("#bill_disc_type").val() != '' && (!isNumeric($("#bill_disc_value").val()) || $("#bill_disc_value").val() =='')){
		
			$("#bill_disc_value").focus();
			showDialog('Error','Please Enter Bill Discount Value.','error',2);
			return false;
		}else if($("#payment_type").val() == "CASH" && $("#free_bill").val() == "" && (!isNumeric($("#amount_paid").val()) || $("#amount_paid").val() =='' || $("#amount_paid").val() =='0')){
		
			$("#amount_paid").focus();
			showDialog('Error','Please Enter Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "CASH" && (Number($("#amount_paid").val()) != Number($("#round_net_amt").val()))){
		
			$("#amount_paid").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;
		}else if($("#payment_type").val() == "CHEQUE" && $("#checque_no").val() == ''){
		
			$("#checque_no").focus();
			showDialog('Error','Please Enter Checque Number.','error',2);
			return false;
		}else if($("#payment_type").val() == "CHEQUE" && (!isNumeric($("#checque_amt").val()) || $("#checque_amt").val() =='' || $("#checque_amt").val() =='0')){
		
			$("#checque_amt").focus();
			showDialog('Error','Please Enter Checque Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "CHEQUE" && (Number($("#checque_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#checque_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;

		}else if($("#payment_type").val() == "CREDIT CARD" && (!isNumeric($("#card_amt").val()) || $("#card_amt").val() =='' || $("#card_amt").val() =='0' )){
		
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
		}else if($("#payment_type").val() == "UPI" && (!isNumeric($("#upi_amt").val()) || $("#upi_amt").val() =='' || $("#upi_amt").val() =='0' )){
		
			$("#upi_amt").focus();
			showDialog('Error','Please Enter UPI Amount.','error',2);
			return false;
        }else if($("#payment_type").val() == "UPI" && (Number($("#upi_amt").val())+amount_paid) != Number($("#round_net_amt").val())){		
			$("#upi_amt").focus();
			showDialog('Error','Please Enter Full Amount Paid.','error',2);
			return false;
		}
		// else if(($("#customer_type").val() == "DIRECT" || $("#customer_type").val() == "OP") && $("#payment_type").val() == "CREDIT"){
		
		   //tb_show('USER AUTHENTICATION',"<?php echo base_url(); ?>index.php/invoice/user_authentication/0/CREDIT_BILL_AUTHENTICATION");
		// }else if($("#bill_disc_type").val() != "" && $("#bill_disc_value").val() >10){
		
		  // tb_show('USER AUTHENTICATION',"<?php echo base_url(); ?>index.php/invoice/user_authentication/0/DISCOUNT_BILL_AUTHENTICATION");
		// }
		else{
			$(".save_bill").attr('disabled',true);
			$("#invoice_form").attr("action","<?php echo base_url(); ?>index.php/invoice/add_invoice");
			$("#invoice_form").submit();
		}

	});

    $(".save_op").hide();
         
    $("#only_op").click(function() {
          
        if ($(this).is(":checked")) {

            $(".button1").hide();

            $(".save_op").show();
        }
        else{
               
            $(".button1").show();

            $(".save_op").hide();
        }

    });

    $("#save_op").click(function(){
    	
    	if ($("#op_payment").prop('checked') != true) {

			showDialog('Error','Please check OP Registration checkbox.','error',2);
			return false;

    	}
    	else{

    		var n = $("#cust_name").val();
    		var a = confirm("Confirm only OP saving for "+n+" ?");

    		if (a==true) {

				$("#invoice_form").attr("action","<?php echo base_url(); ?>index.php/invoice/saveOp");
				$("#invoice_form").submit();

    		}
    		else{

    			return false;

    		}


    	}

    });


});


    $(document).bind('keypress', function(event) {

		 var code = event.keyCode || event.which;
		 if(code == 96) { //Enter keycode
		 	event.preventDefault();

		 	var a = confirm("Are you sure to save bill ?");

		 	if (a==true) {
		 		$(".save_bill").click();
		 	}
		 	else{
		 		return false;
		 	}

		   
		 }
       

    });

function checklist(){

	var item_count=$("#item_count").val();
		
		for(i=0;i<item_count;i++){
		
			k=i+1;
			if(!isNumeric($("#qty"+i).val()) || $("#qty"+i).val()=="0" || $("#qty"+i).val()==""){
				showDialog('Error','Please Enter Valid Item quantity for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if(parseInt($("#qty"+i).val()) > parseInt($("#stocks"+i).val())){
			    showDialog('Error','Please Check Available Stock for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if($("#total"+i).val()=="0" || $("#total"+i).val()=="0.00"){
				showDialog('Error','Please Press Enter Key Item quantity for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if($("#sale_qty"+i).val()!="" && parseInt($("#qty"+i).val()) > parseInt($("#sale_qty"+i).val())){
			    showDialog('Error','Please Check Saled Qty'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}
			// else if(Number(Number(Number($("#total"+i).val()) / Number($("#qty"+i).val())).toFixed(1)) != Number($("#mrp"+i).val()).toFixed(1) ) {
            

			// 	showDialog('Error','Please Press Enter Key Item quantity for item'+k+'.','error',2);
			//     $("#qty"+i).focus();
			// 	 // process_form();
			// 	 return false;
			// }
			
			
		}
    return true;
}

function select_batch(brand_id,item_pos) {

		   
		   tb_show('Select Batch',"<?php echo base_url(); ?>index.php/invoice/select_batch_medicine/"+brand_id+"/"+item_pos+"/"+$('#opno').val());
		// tb_show('Select Batch',"<?php// echo base_url(); ?>index.php/invoice/select_batch_medicine/"+brand_id+"/"+item_pos+"/"+$('#draft').val()+'/'+$('#invoice_id').val());
		   
}

document.getElementById("<?php echo $itemfocus;?>").focus();

function tb_remove(){
	
	document.invoice_form.item_focus.value='brand';
	document.invoice_form.action='<?php echo base_url(); ?>index.php/invoice/invoice_form';
	document.invoice_form.submit();
}

function process_form(next_focus,pos,loc){


	document.invoice_form.item_focus.value=next_focus;
	document.invoice_form.action='<?php echo base_url(); ?>index.php/invoice/invoice_form';
	document.invoice_form.submit();
}

function checked_box(field,next_focus){
   
   $("#"+field).prop( "checked", true );
   process_form(next_focus,'','');
}

function checked_box2(field,next_focus){
	// alert("sdffdf");
   
    var checkBox = document.getElementById("free_bill");
  var text = document.getElementById("bill_disc_type");
  if (checkBox.checked == true){
    text.value = "%";
    document.getElementById("bill_disc_value").value='100';
  } else {
     text.value = "";
    document.getElementById("bill_disc_value").value='';
    document.getElementById("free_bill").value='0';


  }
   $("#"+field).prop( "checked", true );
   process_form(next_focus,'','');
}

function check_data(){

if ($("#refresh_data").val()!="") {

	$("#refresh_data").val('');

	process_form();


}	


if ($("#op_medicines_id").val()!="") {
	$(".draft_bill").hide();
}


}


function get_patient_details(search_from,ref_no_search){

	if (ref_no_search!="") {

		$("#search_from").val(search_from);

		$("#ref_no_search").val(ref_no_search);

			var url = "<?php echo site_url('invoice/patient_details'); ?>"; 

					event.preventDefault();// using this page stop being refreshing 

				        $.ajax({
				            type: 'POST',
				            url:url,
				            data: $('form').serialize(),
				            success: function (data) {
				            	
				            	var data_array = data.split(':');

				            	if (data_array[2]!="") {

					            	if (data_array[3]=="IP") {
					            		$('#op_id').val(data_array[0]);
					            		$('#ip_no').val(data_array[1]);
					            	}
					            	else{
					            		$('#op_id').val(data_array[0]);
					            		$('#op_no').val(data_array[1]);
					            	}
								    
								    
								    $('#cust_name').val(data_array[2]);
								    $('#customer_type').val(data_array[3]);
								    $('#doctor').val(data_array[4]);
								    $('#doc_id').val(data_array[5]);
					            	
								    process_form();

					            }
					            else{

					            	$('#op_id').val('');
					            	$('#op_no').val('');
					            	$('#ip_no').val('');
					            	$('#cust_name').val('');
					            	$('#customer_type').val('');
					            	$('#doctor').val('');
					            	$('#doc_id').val('');

									showDialog('Error','No Patient Details Found !','error',2);
									return false;

					            }



				            }

				        });


	}
	else{

		showDialog('Error','Please Enter Patient Details !','error',2);
		return false;

	}



}

 


    
	  </script>
	  
     
</body>