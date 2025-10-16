<?php $this->load->view("header");
?> 
<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .move_history{
   	    color: #375b91;
        font-size: 16px;
   }
</style>
<form name="movement_form" id="movement_form" method="post" action="<?php echo base_url(); ?>index.php/movement/movement_form">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
             <?php echo (!empty($paction) && $paction=='Save' )?'New':'Update' ; ?> Movement 
             
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-9">
		    <div class="box box-info">
                
               <div class="box-body">

<?php if(empty($from_branch) && empty($to_branch)){?>


			    <table width="100%" class="table table-striped">
				
				<tr>
					
																		
				<td>
                         Move From <span id='requiredfield'>*</span> : 
                </td>
                <td>
                         <select name="from" id="from" onchange="return select_branch();">
                            <option value="">------select-----</option>
                            <option value="main_stock" <?php echo (!empty($from_branch) && ($from_branch=='main_stock')?'selected':''); ?> >Main Stock</option>

        <?php
                for($i=0; $i<count($branchInfo); $i++) 
                    { 
        ?>
                           <option value="<?php echo $branchInfo[$i][0]; ?>" <?php echo (!empty($from_branch) && ($from_branch==$branchInfo[$i][0])?'selected':''); ?> ><?php echo $branchInfo[$i][1]; ?></option>         
        <?php
                    }
        ?>                    

                         </select>
                </td>
                <td>
                        Move To <span id='requiredfield'>*</span> : 
                </td>
                <td>
                           <select name="to" id="to" onchange="return select_branch();">
                            <option value="">------select-----</option>
                            <option value="main_stock" <?php echo (!empty($to_branch) && ($to_branch=='main_stock')?'selected':''); ?> >Main Stock</option>

        <?php
                for($i=0; $i<count($branchInfo); $i++) 
                    { 
        ?>
                           <option value="<?php echo $branchInfo[$i][0]; ?>" <?php echo (!empty($to_branch) && ($to_branch==$branchInfo[$i][0])?'selected':''); ?> ><?php echo $branchInfo[$i][1]; ?></option>         
        <?php
                    }
        ?>                  
                         
				         
				        </td>
                        </tr>
				</table>
<?php }?>
				</div><!--boxbody-->
			  </div><!--boxinfo-->

<?php if(!empty($from_branch) && !empty($to_branch)){?>	

            <input type="hidden" id="from" name="from" value="<?php echo $from_branch; ?>">		
            <input type="hidden" id="to" name="to" value="<?php echo $to_branch; ?>">		  
			  
			  <div align="center"><?php echo $this->lang->line('brand');?>&nbsp;:&nbsp;
					
					
					<input name="brand" id="brand" tabbindex="2"   value="" autocomplete="off" onKeyUp="ajax_showOptions(this,'get_brand_name',event,'<?php echo base_url()."index.php/brand";?>')" >
					 
					
					 <input type="hidden" id="brand_hidden" name="brand_ID" >
					 <input type="hidden" id="batch_hidden" name="batch_ID" >
					 					
					 </div>
					 <br>
					 
					 <?php if(isset($error_message)){?>
								<br /><br />
								<div id='error_message'><?php echo $error_message;?></div>
					<?php } ?>
					<div align="center" class="move_history">

                            Movement From <?php echo $from_branch_name; ?> To <?php echo $to_branch_name; ?>

					</div>
					<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					<thead>
						<tr>
						    <th>Sl No</th>
							<th>Brand</th>
							<th>Batch</th>
							<th>Expiry</th>
							<th>Selling Unit</th>
							<th>Stock</th>
							<th>Qty</th>
							<th>GST%</th>
							<th>Amount</th>
							<th>Remove</th>
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
								<input type="text" name="item[<?php echo $i;?>][1]" id="brand<?php echo $i;?>" value="<?php echo $items[1];?>" size="16" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][2]" id="batch<?php echo $i;?>" value="<?php echo $items[2];?>" size="10" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][3]" id="expiry<?php echo $i;?>" value="<?php echo $items[3];?>"  size="8" readonly></td>
								<td><select name="item[<?php echo $i;?>][4]" id="unit<?php echo $i;?>">
								<?php if($items[4]=='NOS'){ ?>
                                    <option value="NOS">NOS</option>
                                <?php }elseif($items[4]=='STRIP'){ ?>    
                                    <option value="STRIP">STRIP</option>
                                <?php } ?>
                                     </select>                        
								</td>
								<td><input type="text" name="item[<?php echo $i;?>][5]" id="stock<?php echo $i;?>" value="<?php echo $items[5];?>" size="4" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][6]" id="qty<?php echo $i;?>" value="<?php echo $items[6];?>"  size="4" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeypress="if(event.keyCode== 13){return process_form('brand','<?php echo $i;?>','6');}" onkeydown="ArrowKeynextField(event.keyCode,'<?php echo $i;?>','qty','qty<?php echo $i;?>','qty<?php echo $i;?>')" autocomplete="off"></td>
								<td><input type="text" name="item[<?php echo $i;?>][7]" id="gstper<?php echo $i;?>" value="<?php echo $items[7];?>"  size="3" readonly></td>
								<td><input type="text" name="item[<?php echo $i;?>][16]" id="gstamt<?php echo $i;?>" value="<?php echo $items[16]*$items[6];?>"  size="9" readonly></td>

								<td> <a href='#' id="<?php echo $i;?>" class='remove_item'><img src="<?php echo base_url(); ?>application/assets/dist/img/delete.png" title='Remove' width='16' height='16' /></a></td>
									
									<input type="hidden" name="item[<?php echo $i; ?>][0]" value="<?php echo $items[0];?>" /><!--brand_id-->
									<input type="hidden" name="item[<?php echo $i; ?>][9]" value="<?php echo $items[9];?>" /><!--batch_id-->
									<input type="hidden" name="item[<?php echo $i; ?>][10]" value="<?php echo $items[10];?>" /><!--gst_id-->
									<input type="hidden" name="item[<?php echo $i; ?>][11]" value="<?php echo $items[11];?>" /><!--sgst_per-->
									<input type="hidden" name="item[<?php echo $i; ?>][12]" value="<?php echo $items[12];?>" /><!--cgst_per-->
									<input type="hidden" name="item[<?php echo $i; ?>][13]" value="<?php echo $items[13];?>" /><!--sgst_amt-->
									<input type="hidden" name="item[<?php echo $i; ?>][14]" value="<?php echo $items[14];?>" /><!--cgst_amt-->

									<input type="hidden" name="item[<?php echo $i; ?>][15]" value="<?php echo $items[15];?>" /><!--buyp-->
									<input type="hidden" name="item[<?php echo $i; ?>][16]" value="<?php echo $items[16];?>" /><!--sellp-->
									<input type="hidden" name="item[<?php echo $i; ?>][17]" value="<?php echo $items[17];?>" /><!--buyp_total-->
									<input type="hidden" name="item[<?php echo $i; ?>][18]" value="<?php echo $items[18];?>" /><!--sellp_total-->
									<input type="hidden" name="item[<?php echo $i; ?>][8]" value="<?php echo $items[8];?>" /><!--Gst amount-->
										  
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
						<td ><?php echo $this->lang->line('remarks') ?> : </td>
						<td ><textarea name="remarks" cols="15" rows="2" id="remarks" onkeypress="nextField(event.keyCode,save)" autocomplete="off" ><?php echo !empty($remarks)?$remarks:''; ?></textarea></td>
						
						
				</tr>
					<tr>
							
							<td  ><input type="button" name="save" value="Save Bill" id="button1" class="save_bill btn btn-success" onclick="return submitForm()" style="width: 115px"  /></td>
							
					</tr>
					   </table>
					</div>
				</div>
			</div>
<?php } ?>
			</div><!--row-->
          </section><!-- /.content -->
        </div><!-- /.container -->
		
		        <input type="hidden" name="item_focus" id="item_focus" value="<?php echo $itemfocus; ?>">
		        <input type="hidden" name="item_focus_select" id="item_focus_select" value="<?php echo $item_focus_select; ?>">
				<input type="hidden" name="error" id="error" >
				<input type="hidden" name="item_count" id="item_count" value="<?php echo $itemcount;?>">
				<input type="hidden" name="item_loc" id="item_loc" value="">
				<input type="hidden" name="paction" id="paction" value="<?php echo $paction;?>">

				<input type="hidden" name="movement_id" id="movement_id" value="<?php echo !empty($movement_id)?$movement_id:''; ?>">

				<input type="hidden" name="total_buyp" id="total_buyp" value="<?php echo !empty($total_buyp)?$total_buyp:''; ?>"><!-- total buyp -->
				<input type="hidden" name="total_sellp" id="total_sellp" value="<?php echo !empty($total_sellp)?$total_sellp:''; ?>"><!-- total sellp -->
				
  </form>  
  
  

				<?php
			 $this->load->view("footer"); 
	       ?>
		 
<script>

$(document).ready(function(){

	if($("#item_count").val() == 0){

		$("#brand").focus();
    }

    var item_focus=$("#item_focus").val();
    if(item_focus!=''){
        
        var item_focus_select=$("#item_focus_select").val();
    	$("#"+item_focus_select).focus();
    }

	$('#brand').bind('keypress', function(e) {
	 
	        if(e.keyCode == 13 ){
				if($('#brand_hidden').val() != ""){
			
				
				$.post("<?php echo base_url(); ?>index.php/brand/valid_brand", $("#movement_form").serialize(),function(data){
				
					if(data['message'] == "Valid Brand"){
					
						tb_show('Select Batch',"<?php echo base_url(); ?>index.php/movement/select_batch/"+$('#brand_hidden').val()+"/"+$('#from').val());
						
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
		   
		      $( "#item_loc" ).val($(this).attr('id'));
	    
			   $( "#movement_form" ).attr("action","<?php echo base_url(); ?>index.php/movement/movement_form");
    			  
			  $( "#movement_form" ).submit();
		   
	});

	$(".save_bill").click(function(){

	    if($("#item_count").val() == 0){
			showDialog('Error','Please Select Atleast One Item in Bill.','error',2);
			return false;
		}else if (!checklist()){
			
		}else{ 
		       $(".save_bill").attr('disabled',true);
			   $("#movement_form").attr("action","<?php echo base_url(); ?>index.php/movement/add_movement");
			   $("#movement_form").submit();
		}

	});


});

function checklist(){
	
		var item_count=$("#item_count").val();
		
		for(i=0;i<item_count;i++){
		
			k=i+1;
			if(!isNumeric($("#qty"+i).val()) || $("#qty"+i).val()=="0" || $("#qty"+i).val()==""){
				showDialog('Error','Please Enter Valid Item quantity for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}else if(parseInt($("#qty"+i).val()) > parseInt($("#stock"+i).val())){
			    showDialog('Error','Please Check Available Stock for item'+k+'.','error',2);
				$("#qty"+i).focus();
				return false;
			}
			
		}
	    return true;
}
	  
function select_branch(){

	if(document.movement_form.from.value == document.movement_form.to.value !=""){
	
		showDialog('Error','Please Select Diffrent Branches.','error',2);
			return false;
	}else if(document.movement_form.from.value !="" && document.movement_form.to.value !=""){
	
		document.movement_form.action='<?php echo base_url(); ?>index.php/movement/movement_form';
	    document.movement_form.submit();
	}
}	 



document.getElementById("<?php echo $itemfocus;?>").focus();

function tb_remove(){
	
	document.movement_form.item_focus.value='brand';
	document.movement_form.action='<?php echo base_url(); ?>index.php/movement/movement_form';
	document.movement_form.submit();
}

function process_form(next_focus,pos,loc){

	document.movement_form.item_focus.value=next_focus;
	document.movement_form.action='<?php echo base_url(); ?>index.php/movement/movement_form';
	document.movement_form.submit();
}

    
	  </script>
	  
     
