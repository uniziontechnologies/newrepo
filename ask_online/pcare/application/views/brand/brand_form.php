<?php
  if($from_location!='from_purchase')
  	 {
       $this->load->view("header");
  	 }
?>
<style type="text/css">

	#requiredfield{
        
        color: #FF0000;
	}


<?php
  if($from_location=='from_purchase')
  	 {?>

		div#ajax_listOfOptions {
		    z-index: 999 !important;
		}

      <?php
  	 }
?>



</style>

<form name="brand_form" id="brand_form" method="post" action="">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  <?php echo ($action=='create')?'CREATE':'UPDATE'; ?> BRAND      
            </h1>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-6">
										
			        <div class="box box-info ">
                     <div class="box-header with-border">	

                      <h2 class="box-title">BRAND INFORMATION</</h2>

                      </div>
								
						<table  class="table table-striped">	
							
								<tr>

  								    <td>Brand Name <span id='requiredfield'>*</span> : </td>
									<td>
									    <input type="text" name="brand_name" id="brand_name" value="<?php echo !empty($brand[0][1])?$brand[0][1]:'' ?>" onkeypress="nextField(event.keyCode,generic_name)" autocomplete="off">
									</td>
								</tr>
								<tr>
								
								    <td>Generic Name : </td>
									<td>
									    <input type="text" name="generic_name" id="generic_name" value="<?php echo !empty($brand[0][2])?$brand[0][2]:'' ?>" onkeypress="nextField(event.keyCode,hsn_no)" onKeyUp="ajax_showOptions(this,'get_generic_name',event,'<?php echo base_url()."index.php/brand";?>')" autocomplete="off">
									</td>
                                </tr>
                                 <tr>

  								    <td>HSN Number : </td>
									<td>
									    <input type="text" name="hsn_no" id="hsn_no" value="<?php echo !empty($brand[0][24])?$brand[0][24]:'' ?>" onkeypress="nextField(event.keyCode,manufacturer)" autocomplete="off">
									</td>
								</tr>
                                <tr>

  								    <td>Manufacturer : </td>
									<td>
									    <input type="text" name="manufacturer" id="manufacturer" value="<?php echo !empty($brand[0][3])?$brand[0][3]:'' ?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getManufacturerName',event,'<?php echo base_url()."index.php/brand";?>')">
									</td>
								</tr>
                                <tr>
                                								
									<td>Category : </td>
									<td>	
									    <select name="category" id="category" onkeypress="nextField(event.keyCode,selling_unit)">
                                          <option value="0">------select------</option>

                            <?php
                                    for ($i=0; $i<count($category); $i++) { 
                            ?>
                                          <option value="<?php echo $category[$i][0]; ?>" <?php echo (!empty($brand[0][4]) && ($brand[0][4]==$category[$i][0]))?'selected':'' ?> ><?php echo $category[$i][1]; ?></option>
                            <?php       	
                                    }
                            ?>

                                        </select>
                                    </td>
								</tr>
								<tr>
										<td>SellP : </td>
										<td>
										    <input type="text" name="selling_price" id="selling_price" value="<?php echo !empty($brand[0][10])?$brand[0][10]:'' ?>"  onkeypress="nextField(event.keyCode,buying_price)" readonly autocomplete="off">
										</td>
								</tr>
								<tr>
										<td>BuyP : </td>
										<td>
										    <input type="text" name="buying_price" id="buying_price" value="<?php echo !empty($brand[0][11])?$brand[0][11]:'' ?>" readonly  onkeypress="nextField(event.keyCode,reorder)" autocomplete="off">
										</td>
								</tr>
                         
								<tr>
									<td>Gst Class : </td>
									<td>
										<select name="gst_class" id="gst_class" width="40">
                                    <option value=''>--</option>
											
											<?php for($k=0;$k<count($gst_class);$k++){ 
																						
													if(!empty($brand[0][26]) && $brand[0][26]==$gst_class[$k][0]) { ?>
													
														<option value='<?php echo $gst_class[$k][0];?>' selected><?php echo $gst_class[$k][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $gst_class[$k][0];?>'><?php echo  $gst_class[$k][1];?></option>
												
										<?php 		} 
												} ?>
                                     </select> 
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
										
										<td>Reorder Level : </td>
										<td>
										    <input type="text" name="reorder" id="reorder" value="<?php echo !empty($brand[0][16])?$brand[0][16]:'' ?>"  onkeypress="nextField(event.keyCode,shelf_number)" autocomplete="off">
										</td>
								</tr>
								<tr>	
										<td>Shelf Number : </td>
										<td>
										    <input type="text" name="shelf_number" id="shelf_number" value="<?php echo !empty($brand[0][23])?$brand[0][23]:'' ?>"  onkeypress="nextField(event.keyCode,h1n_shld_x)" autocomplete="off">
										</td>
								</tr>
								<tr>	
										<td>H1N SHEDULED-X : </td>
										<td>
										    <input type="checkbox" name="h1n_shld_x" id="h1n_shld_x" onkeypress="if(event.keyCode== 13){return checked_box('h1n_shld_x','description');}" value="1" <?php echo !empty($brand[0][25])?'checked':'' ?> >
										</td>
								</tr>
								<tr>	
										<td>Description : </td>
										<td>
										    <textarea name="description" cols="16" rows="3" id="description" onkeypress="nextField(event.keyCode,Create)" autocomplete="off"><?php echo !empty($brand[0][17])?$brand[0][17]:'' ?></textarea>
										</td>
									
									
								</tr>
								<tr>
								     <td colspan='2' align="center">

					<?php if($action=='create'){
       
					           if($from_location=='from_purchase'){
  	 
                    ?>
                                     <input type="button" name="Create" value="Create Brand" class="btn btn-success" id="create_brand">
                    <?php
                               }else{
                    ?>
                     		          <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Brand" onclick="return submitForm('<?php echo $action; ?>')"/>

					<?php
					           }

					        }else{ 
					?>

							          <input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Brand" onclick="return submitForm('<?php echo $action; ?>')"/>

					<?php   } ?>

								     </td>
								</tr>
							</table>

							<input type="hidden" name="t_per_s" id="t_per_s" value="<?php echo !empty($brand[0][7])?$brand[0][7]:1 ?>">

							<input type="hidden" name="s_per_p" id="s_per_p" value="<?php echo !empty($brand[0][8])?$brand[0][8]:1 ?>">
	 
						    <input type="hidden" name="selling_unit" id="selling_unit"  autocomplete="off" value="<?php echo !empty($brand[0][6])?$brand[0][6]:'NOS' ?>">
						
							<input type="hidden" name="price_type" id="price_type" value="">

							<input type="hidden" name="id" id="id" value="<?php echo !empty($brand[0][0])?$brand[0][0]:'' ?>">

						</div>
									
						
				</div>
		</div>
	</div>
	</section>
	</div>
	<input type="hidden" name="current_page" id="current_page" value="<?php echo !empty($current_page)?$current_page:'' ?>">
  </form>  
       
<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">
 
function submitForm(action){
   
   		
   		    
   		    var trimed_brand_name=$('#brand_name').val().trim();
   		    $('#brand_name').val(trimed_brand_name);
   		    var brand_name= $('#brand_name').val();


   		    // alert(trimed_brand_name); return false;
   		    var selling_price= $('#selling_price').val();
   		    var buying_price= $('#buying_price').val();
   		    var selling_unit= $('#selling_unit').val();
            

        if( brand_name=="" ){

               showDialog('Error','Please Enter brand Name.','error',2);
               return false;
     	
     	  }else if( selling_price!="" && !(isNumeric(selling_price)) ){

               showDialog('Error','Please Enter Valid selling price.','error',2);
               return false;
      
        }else if( buying_price!="" && !(isNumeric(buying_price)) ){

               showDialog('Error','Please Enter Valid buying price.','error',2);
               return false;
      
        }else{
        	   if(selling_unit== "NOS"){
				document.brand_form.price_type.value="NOS";
			   }

               if(action=='create'){
              
                    document.brand_form.action="<?php echo base_url(); ?>index.php/brand/create";

               }else{

                    document.brand_form.action="<?php echo base_url(); ?>index.php/brand/update";

               }
      
                    document.brand_form.submit();
        }

}

function checked_box(field,next_focus){

   var check_status=$("#"+field).prop("checked");

   if(check_status== true){

       $("#"+field).prop( "checked", false );

   }else{

   	   $("#"+field).prop( "checked", true );

   }
   
   $("#"+next_focus).focus();
}

$(document).ready(function(){


   $("#create_brand").click(function(){

    
          
          var trimed_brand_name=$('#brand_name').val().trim();
   		    $('#brand_name').val(trimed_brand_name);
   		    var brand_name= $('#brand_name').val();
       
   		    var selling_price= $('#selling_price').val();
   		    var buying_price= $('#buying_price').val();
   		    var selling_unit= $('#selling_unit').val();
            

        if( brand_name=="" ){

               showDialog('Error','Please Enter brand Name.','error',2);
               return false;
     	
     	  }else if( selling_price!="" && !(isNumeric(selling_price)) ){

               showDialog('Error','Please Enter Valid selling price.','error',2);
               return false;
      
        }else if( buying_price!="" && !(isNumeric(buying_price)) ){

               showDialog('Error','Please Enter Valid buying price.','error',2);
               return false;
      
        }else{
        	   if(selling_unit== "NOS"){
				document.brand_form.price_type.value="NOS";
			   }
              
               $.post("<?php echo base_url(); ?>index.php/brand/create/json_submit", $("#brand_form").serialize(),function(data){
		   
		         if(data['brand_id'] >0){
		         	
		         	var trimed_brand_name=$('#brand_name').val().trim();
		         	$("#brand_name").val(trimed_brand_name);
   		    		$('#brand').val(trimed_brand_name);
			   
			      // $("#brand").val($("#brand_name").val());
			      $("#brand_hidden").val(data['brand_id']);
				  $("#item_focus").val("batch");
				  $("#purchase_form").attr("action","<?php echo base_url(); ?>index.php/purchase/purchase_form");
			      $("#purchase_form").submit();
			     }

		       },"json");

        }
      
   });

});
</script>