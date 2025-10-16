<?php $this->load->view("header"); 
?> 
<form name="order_form" id="order_form" method="post" action="<?php echo base_url(); ?>index.php/purchase_order/order_form">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>

          <?php echo (!empty($paction) && $paction=='Save' )?'New':'Update' ; ?> Purchase Order
             
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">
			    
				</div><!--boxbody-->
			  </div><!--boxinfo-->
			  
			  <div align="center"><?php echo $this->lang->line('brand');?>&nbsp;:&nbsp;
					
					
					<input name="brand" id="brand" tabbindex="2"  onkeypress="if(event.keyCode== 13){return process_form('unit<?php echo($itemcount); ?>','','');}" value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
					 
					
					 <input type="hidden" id="brand_hidden" name="brand_ID" >

					 
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
							<th><?php echo $this->lang->line('pack') ?></th>
							<th><?php echo $this->lang->line('tab') ?>/<?php echo $this->lang->line('strip');?></th>
							<th><?php echo $this->lang->line('qty') ?></th>
							<th><?php echo $this->lang->line('foc') ?></th>
							<th><?php echo $this->lang->line('buyp') ?></th>
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
								<input type="text" name="item[<?php echo $i;?>][1]" id="brand<?php echo $i;?>" value="<?php echo $items[1];?>" onkeypress="nextField(event.keyCode,unit<?php echo $i;?>)" size="8" readonly></td>
								<td><select name="item[<?php echo $i;?>][2]" id="unit<?php echo $i;?>" onkeypress="if(event.keyCode== 13)return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','2');" onchange="return process_form('tpers<?php echo $i;?>','<?php echo $i;?>','2');">
                                    <option value="NOS" <?php echo ($items[2] == 'NOS')?'selected' :'';?>>NOS</option>
                                    <option value="STRIP" <?php echo ($items[2] == 'STRIP')?'selected' :'';?>>STRIP</option>
                                     </select>                        
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][3]" value="<?php echo $items[3];?>" id="tpers<?php echo $i;?>" onkeypress="if(event.keyCode== 13){return process_form('qty<?php echo $i;?>','<?php echo $i;?>','3');}" autocomplete="off" size="3" <?php echo ($items[2] == 'NOS')?'readonly' :'';?> onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','tpers','unit<?php echo $i;?>','qty<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][4]" id="qty<?php echo $i;?>" value="<?php echo $items[4];?>"  size="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('foc<?php echo $i;?>','<?php echo $i;?>','4');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','qty','tpers<?php echo $i;?>','foc<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][5]" id="foc<?php echo $i;?>" value="<?php echo $items[5];?>"  size="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('buyp<?php echo $i;?>','<?php echo $i;?>','5');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','foc','qty<?php echo $i;?>','buyp<?php echo $i;?>')"></td>
								<td><input type="text" name="item[<?php echo $i;?>][6]" id="buyp<?php echo $i;?>" value="<?php echo $items[6];?>"  size="2" onkeypress="if(event.keyCode== 13){return process_form('brand','','');}" autocomplete="off" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','buyp','foc<?php echo $i;?>','buyp<?php echo $i;?>')"></td>
								
								
								<td><input type="text" name="item[<?php echo $i;?>][7]" id="total<?php echo $i;?>" value="<?php echo $items[7];?>" readonly size="2" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','7');}"></td>
								
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
					   	
					   	<td >Date <span id='requiredfield'>*</span>&nbsp; : </td>
					
						<td ><input type="text" name="date" value="<?php echo !empty($date)?$date:'' ?>" id="order_date" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" size="7" readonly="true" /></td>

					</tr>

					<tr>
						
						<td >Supplier <span id='requiredfield'>*</span>&nbsp; : </td>
							
						<td>
						<?php
							  if(!empty($supplier)){
						?>
						       <select name="supplier" id="supplier" onkeypress="nextField(event.keyCode,price_type);">
                                           <option value="">-------------------------------</option>

                        <?php
                                for($i=0; $i<count($supplier); $i++) 
                                   { 
                        ?>
                                           <option value="<?php echo $supplier[$i][0]; ?>" <?php echo (!empty($supplier_selected) && ($supplier_selected==$supplier[$i][0]))?'selected':'' ?> ><?php echo $supplier[$i][1]; ?></option>         
                        <?php        
                                   }
                        ?>

                               </select>
						<?php
                              }
						?>
                        </td>
					</tr>

					<tr>
						
						<td >Net Total : </td>

                        <td>
                        	<input type="text" name="net_total" value="<?php echo !empty($net_total)?$net_total:'' ?>" id="net_total" onkeypress="nextField(event.keyCode,remarks);" autocomplete="off" size="10" readonly="true" >
                        </td>

					</tr>

					<tr>
						
						<td >Remarks : </td>
						
                        <td>
                        	<textarea name="remarks" cols="15" rows="2" id="remarks" onkeypress="nextField(event.keyCode,save)" autocomplete="off" ><?php echo !empty($remarks)?$remarks:'' ?></textarea>
                        </td>

					</tr>
			
					<tr>
							
							<td  ><input type="button" name="save" value="Save" id="button1" class="save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  /></td>
					</tr>
					   </table>
					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
        </div><!-- /.container -->
		
		        <input type="hidden" name="item_focus" id="item_focus" >
				<input type="hidden" name="error" id="error" >
				<input type="hidden" name="item_count" id="item_count" value="<?php echo $itemcount;?>">
				<input type="hidden" name="item_loc" id="item_loc" value="">
				<input type="hidden" name="paction" id="paction" value="<?php echo $paction;?>">

				<input type="hidden" name="order_id" id="order_id" value="<?php echo !empty($order_id)?$order_id:'' ?>" >
				
  </form>  
  
  

				<?php
			 $this->load->view("footer"); 
	       ?>
		 
<script>
      $(function () {
	 
	   //Date range picker
        $('#order_date').datepicker();
		 
	  });

$(document).ready(function(){

	if($("#item_count").val() == 0){

		$("#brand").focus();
    }

    $( ".remove_item" ).click(function() {
		   
		      $( "#item_loc" ).val($(this).attr('id'));
	    
			   $( "#order_form" ).attr("action","<?php echo base_url(); ?>index.php/purchase_order/order_form");
    			  
			  $( "#order_form" ).submit();
		   
	});

	$(".save_bill").click(function(){

	    if($("#order_date").val() == ""){
			showDialog('Error','Please Select Date.','error',2);
			return false;
		}else if($("#supplier").val() == ""){
			showDialog('Error','Please Select Supplier.','error',2);
			return false;
		}else if (!checklist()){
			
		}else{

			  $( "#order_form" ).attr("action","<?php echo base_url(); ?>index.php/purchase_order/save_purchase_order");
    			  
			  $( "#order_form" ).submit();
		}

	});

        
});
function checklist(){	
	
		var item_count=$("#item_count").val();
		
		for(i=0;i<item_count;i++){
		
			k=i+1;
		
			if(!isNumeric($("#qty"+i).val()) || $("#qty"+i).val()=="0" || $("#qty"+i).val()=="" )  {
				showDialog('Error','Please Enter Valid Item quantity for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if(!isNumeric($("#buyp"+i).val()) || $("#buyp"+i).val()==0 ){
				showDialog('Error','Please Enter Valid Buy price for item'+k+'.','error',2);
				$("#buyp"+i).focus();
				return false;
			}
			
		}
	    return true;
	}

document.getElementById("<?php echo $itemfocus;?>").focus();

function process_form(next_focus,pos,loc){

	document.order_form.item_focus.value=next_focus;
	document.order_form.action='<?php echo base_url(); ?>index.php/purchase_order/order_form';
	document.order_form.submit();
}
	  
	 
</script>
	  
     
