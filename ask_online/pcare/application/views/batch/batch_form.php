<style type="text/css">

	#requiredfield{
        
        color: #FF0000;
	}
</style>

<form name="batch_form" id="batch_form" method="post" action="">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-6">
										
			        <div class="box box-info ">
                     <div class="box-header with-border">	

                      <h2 class="box-title">BATCH INFORMATION</</h2>

                      </div>
								
						<table  class="table table-striped">	
							
								<tr>

  								    <td>Batch No <span id='requiredfield'>*</span> : </td>
									<td>
									    <input type="text" name="batch_number" id="batch_number" value="<?php echo !empty($batch[0][2])?$batch[0][2]:'' ?>" onkeypress="nextField(event.keyCode,expiry_date)" autocomplete="off">
									</td>
								</tr>
								<tr>
								
								    <td>Expiry Date <span id='requiredfield'>*</span> : </td>
									<td>
									    <input type="text" name="expiry_date" id="expiry_date" class="expiry_date" value="<?php echo !empty($batch[0][3])?date('d-m-Y',strtotime($batch[0][3])):'' ?>" onkeypress="nextField(event.keyCode,supplier)" autocomplete="off" readonly="true" >
									</td>
                                </tr>
                                 <tr>

  								    <td>Supplier : </td>
									<td>
									    <select name="supplier" id="supplier" onkeypress="nextField(event.keyCode,price_type);">
                                           <option value="">------------------------------------</option>
                <?php
                        for($i=0; $i<count($suppliers); $i++) 
                           { 
                ?>
                                           <option value="<?php echo $suppliers[$i][0]; ?>" <?php echo (!empty($batch[0][8]) && ($batch[0][8]==$suppliers[$i][0]))?'selected':'' ?> ><?php echo $suppliers[$i][1]; ?></option>         
                <?php        
                           }
                ?>
                                        </select>
									</td>
								</tr>
                                <tr>

  								    <td>SellP : </td>
									<td>
									    <input type="text" name="sellp" id="sellp" value="<?php echo !empty($batch[0][6])?$batch[0][6]:'' ?>" onkeypress="nextField(event.keyCode,buyp)" autocomplete="off">
									</td>
								</tr>
								<tr>

  								    <td>BuyP : </td>
									<td>
									    <input type="text" name="buyp" id="buyp" value="<?php echo !empty($batch[0][7])?$batch[0][7]:'' ?>" onkeypress="nextField(event.keyCode,pack)" autocomplete="off">
									</td>
								</tr>
								
							</table>
								
					</div>
				</div>
					  <div class="col-md-6">
						<div class="box box-info">
                
                           <div class="box-body">
							 
							 <table  class="table table-striped">	

								<tr>
										<td>Qty : </td>
										<td>
										    <input type="text" name="qty" id="qty" value="<?php echo !empty($batch[0][4])?$batch[0][4]:'' ?>"  onkeypress="nextField(event.keyCode,gst)" <?php echo !empty($batch[0][4])?"readonly":'' ?> autocomplete="off">
										</td>
								</tr>

                                <tr>

  								    <td>Gst% : </td>
									<td>
									    <select name="gst" id="gst" onkeypress="nextField(event.keyCode,description);">
                                           <option value="">------</option>
                <?php
                        for($i=0; $i<count($gstInfo); $i++) 
                           { 
                ?>
                                           <option value="<?php echo $gstInfo[$i][0]; ?>" <?php echo (!empty($batch[0][17]) && ($batch[0][17]==$gstInfo[$i][0]))?'selected':'' ?> ><?php echo $gstInfo[$i][1]; ?></option>         
                <?php        
                           }
                ?>
                                        </select>
									</td>
								</tr>

								<tr>	
										<td>Description : </td>
										<td>
										    <textarea name="description" cols="16" rows="3" id="description" onkeypress="nextField(event.keyCode,Create)" autocomplete="off"><?php echo !empty($batch[0][10])?$batch[0][10]:'' ?></textarea>
										</td>
									
									
								</tr>
								<tr>
								     <td colspan='2' align="center">

					<?php if($action=='create'){?>

                     		          <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Batch" onclick="return submitForm('<?php echo $action; ?>')"/>

					<?php }else { ?>

							          <input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Batch" onclick="return submitForm('<?php echo $action; ?>')"/>

					<?php } ?>

								     </td>
								</tr>
							</table>

							<input type="hidden" name="price_type" id="price_type" value="NOS">

							<input type="hidden" name="id" value="<?php echo !empty($batch[0][0])?$batch[0][0]:'' ?>">

						</div>
									
						
				</div>
		</div>
	</div>
	</section>
	</div>
  </form>  
       
<?php
	  $this->load->view("footer"); 
?>

<script>

     $(function () {
	 
	   //Date range picker
        $('.expiry_date').datepicker();
		 
	 });
 
function submitForm(action){


	        var batch_number= $('#batch_number').val();
   		    var expiry_date= $('#expiry_date').val();
   		    var qty= $('#qty').val();
   		    var sellp= $('#sellp').val();
   		    var buyp= $('#buyp').val();
   
   		
   		if( batch_number=='' ) {
   			showDialog('Error','Please Enter Batch Number.','error',2);
			return false;
		}else if( expiry_date=='' ) {
   			showDialog('Error','Please Choose Expiry Date.','error',2);
			return false;
		}else if( sellp=='' ){
				showDialog('Error','Please Enter selling price.','error',2);
				return false;
		}else if( sellp!='' && !(isNumeric(sellp)) ){
				showDialog('Error','Please Enter Valid selling price.','error',2);
				return false;
		}else if( buyp=='' ){
				showDialog('Error','Please Enter buying price.','error',2);
				return false;
		}else if( buyp!='' && !(isNumeric(buyp)) ){
				showDialog('Error','Please Enter Valid buying price.','error',2);
				return false;
		}else if( qty!='' && !(isNumeric(qty)) ){
				showDialog('Error','Please Enter Valid Quantity.','error',2);
				return false;
		}else if( qty=='' || qty<1 ){
				showDialog('Error','Please Enter Valid Quantity.','error',2);
				return false;
		}else{

               if(action=='create'){
              
                    document.batch_form.action="<?php echo base_url(); ?>index.php/batch/create/"+<?php echo $brand_id; ?>

               }else{

                    document.batch_form.action="<?php echo base_url(); ?>index.php/batch/update/"+<?php echo $brand_id; ?>

               }
      
                    document.batch_form.submit();
        }

}
</script>