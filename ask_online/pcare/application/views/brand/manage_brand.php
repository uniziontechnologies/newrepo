<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        padding-top: 15px;
        font-size: 14px;   
   }	
   .single{
            display:inline;
   }
</style>

<form name="manage_brand" id="manage_brand" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            
            <div>
  
				    <button type="button" class="btn btn-success" onclick="createBrand()"><i class="fa fa-plus"></i> BRAND
				    </button>

            </div>

           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $delete_success = $this->session->flashdata('delete_success');
                         $brand_exist_message = $this->session->flashdata('brand_exist_message');
                         if(!empty($delete_success) || !empty($brand_exist_message)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo !empty($delete_success)?$delete_success:$brand_exist_message; ?></div>
                        <?php
                            }
                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>

                              <!-- <div class="alert alert-info alert-dismissable" id="message_box">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                   <?php echo !empty($create_success)?$create_success:$update_success; ?>
                  </div> -->
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>List Brand By :</td>
				        <td>
				         <select name="list_brand_by" id="list_brand_by" onkeypress="return searchForm();" onchange="return searchForm();">
                                <option value="BRAND" <?php echo !empty($list_brand_by_select) && ($list_brand_by_select=='BRAND')?'selected':'selected'; ?> >BRAND</option>
                                <option value="GENERIC NAME" <?php echo !empty($list_brand_by_select) && ($list_brand_by_select=='GENERIC NAME')?'selected':''; ?> >GENERIC NAME</option>
                                <option value="MANUFACTURER" <?php echo !empty($list_brand_by_select) && ($list_brand_by_select=='MANUFACTURER')?'selected':''; ?> >MANUFACTURER</option>
                                </select>
                        </td>

            <?php if(!empty($list_brand_by_select) && $list_brand_by_select == 'GENERIC NAME'){?>
                                
                            <td>Generic Name :</td>
                            <td>
                                <input type="text" name="generic_name_search" value="<?php echo !empty($generic_name)?$generic_name:''; ?>" id="generic_name_search" autocomplete="off">
                            </td>             
  
            <?php }else if(!empty($list_brand_by_select) && $list_brand_by_select == 'MANUFACTURER'){?>
                              

                            <td>Manufacturer :</td>
                            <td>
                                <input type="text" name="manufacturer_name" value="<?php echo !empty($manufacturer_name)?$manufacturer_name:''; ?>" id="manufacturer_name" value="" autocomplete="off">
                            </td>

            <?php }else { ?>


                            <td>Brand Name :</td>
                            <td>
                                <input type="text" name="brand_name_search" value="<?php echo !empty($brand_name)?$brand_name:''; ?>" id="brand_name_search" value="" autocomplete="off"> 
                            </td>     

            <?php }?>

                          <td>OR</td>
                          <td>Search By :</td>
                        <td>
                         <select name="search_by" id="search_by" onkeypress="return searchForm();" onchange="return searchForm();">
                                <option value="">------------------</option>
                                <option value="LOW INVENTORY" <?php echo !empty($low_inventry) && ($low_inventry=='LOW INVENTORY')?'selected':''; ?> >LOW INVENTORY</option>
                         </select>
                        </td>
                        <td>Category :</td>
						<td>	
									    <select name="category_search" id="category_search">
                                          <option value="0">------select------</option>

                            <?php
                                    for ($i=0; $i<count($category); $i++) { 
                            ?>
                                          <option value="<?php echo $category[$i][0]; ?>"><?php echo $category[$i][1]; ?></option>
                            <?php       	
                                    }
                            ?>

                                        </select>
                        </td>
            </tr>
            <tr>
                <td colspan="9" align="center">
				            <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                    </button>
                    <button type="button" class="btn btn-danger" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                    </button>
				        </td>
				    </tr>
                   
				  </table>
			   </div><!--boxbody-->           
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
		  </div> <!--row-->
        <div class="row">

           <div class="col-md-9" id="success">
              <?php echo !empty($message)?$message:''; ?>
             
           </div>

          <!--  <div class="col-md-3">
             
                    <?php echo $pagination_link; ?>
              
           </div> -->

           <div class="col-md-12">
            <div class="col-md-5">
            
                 <input type="button" name="check_all" id="check_all" class="btn btn-success" value="Check/Uncheck All Brands" style="width: auto;">&nbsp;
           
                 <input type="button" name="clear_all" id="clear_all" class="btn btn-success" value="Clear checked Stock" onclick="clearAll('SELECTED')">
             </div>
             <div class="col-md-3">
                 <input type="button" name="clear_all_brand" id="clear_all_brand" class="btn btn-danger" value="Clear Complete Stock" onclick="clearAll('ALL')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
             </div>
             <div class="col-md-4">
                 <?php echo $pagination_link; ?>
             </div>
            </div>
        </div>
       

        

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">

				    <div class="box-header with-border">
				          <h1 class="box-title">BRAND</h1>
                    </div>	
                   
                    <div class="box-body">
				          
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Brand</a></th>
				            <th class="font_th"><a href="#">Generic Name</a></th>
				            <th class="font_th"><a href="#"> HSN </a></th>
				            <th class="font_th"><a href="#">Manufacturer</a></th>
				            <th class="font_th"><a href="#">Unit</a></th>
				            <th class="font_th"><a href="#">SellP</a></th>
				            <th class="font_th"><a href="#">BuyP</a></th>
                    <th class="font_th"><a href="#">Gst%</a></th>
				            <th class="font_th" colspan="2" style="text-align: center;"><a href="#">Stock</a></th>
				            <th class="font_th"><a href="#">Reorder</a></th>
				            <th class="font_th"><a href="#">Shelf No</a></th>
				            <th class="font_th"><a href="#"> Batch </a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
                <tr>
                    <th colspan="9"></th>
                    <th class="font_th"><a href="#">Main</a></th>
                    <th class="font_th"><a href="#">Branch</a></th>
                </tr>
		<?php        
                if(!empty($brand)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($brand);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $brand[$i][1];?></td>
							<td><?php echo $brand[$i][2];?></td>
							<td><?php echo $brand[$i][24];?></td>
							<td><?php echo $brand[$i][3];?></td>
							<td><?php echo $brand[$i][6];?></td>
							<td><?php echo $brand[$i][10];?></td>
							<td><?php echo $brand[$i][11];?></td>
              <td><?php echo $brand[$i][27];?></td>
							<td>

							      <?php echo display_in_pack($brand[$i][13],$brand[$i][14],$brand[$i][15]);?>
								
							</td>
							<td>

							      <?php echo display_in_pack($brand[$i][20],$brand[$i][21],$brand[$i][22]);?>   
								
							</td>
							<td><?php echo $brand[$i][16];?></td>
							<td><?php echo $brand[$i][23];?></td>
							<td>

							     <!-- <a href="<?php //echo base_url(); ?>index.php/batch/index/<?php //echo $brand[$i][0]; ?>"> -->
							     	
							     	<i class="fa fa-external-link-square" style="font-size:25px;color:#00a65a;" onclick="manage_batch('<?php echo $brand[$i][0]; ?>')"></i>

							     <!-- </a> -->
								
							</td>
					
						    <td>
						  	
					            <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateBrand('<?php echo $brand[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
						   
				                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteBrand('<?php echo $brand[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
											
						    </td>

                            <td>
                              <input type="checkbox"  value="<?php echo $brand[$i][0]; ?>" name="selected_brand[]" id="selected_brand<?php echo $i;?>" title="<?php echo "Brand ID: ".$brand[$i][0];?>" class="selected_brand">
                            </td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
                      <input type="hidden" name="brand_id" id="brand_id">
                      <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
                      <input type="hidden" name="paction" id="paction">
					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">

$(document).ready(function(){

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#manage_brand").attr("action","<?php echo base_url(); ?>index.php/brand/manageBrand");
                 $("#manage_brand").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_brand").attr("action","<?php echo base_url(); ?>index.php/brand/manageBrand");
                 $("#manage_brand").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_brand").attr("action","<?php echo base_url(); ?>index.php/brand/manageBrand");
                 $("#manage_brand").submit();
    });
    // $("#message_box").fadeTo(2000, 500).slideUp(500, function(){
    //          $("#success-alert").slideUp(500);
    //       });
    $('#check_all').click(function(){
                  var d = $(this).data(); // access the data object of the button
                  $('.selected_brand').prop('checked', !d.checked); // set all checkboxes 'checked' property using '.prop()'
                  d.checked = !d.checked; // set the new 'checked' opposite value to the button's data object
              });


    
   
  });

function clearAll(action){
    // alert(action);return false;
     $('#paction').val(action);
    if(action=='SELECTED'){
                
                  no_of_items=$(":checkbox:checked").length;
                  if (no_of_items <= 0) {
                    showDialog('Error','Select Atleast One Item.','error',2);
                        return false;
                  }else{

                   var confirm_data = confirm("Are you sure you want to clear it ?");
                   
                   if(confirm_data){
                     no_of_items=$(":checkbox:checked").length;
                     // alert(no_of_items);
                     // branch = $('#branch').val();
                     // brand = $('#brand_hidden').val();
                      
                        
                        document.manage_brand.action="<?php echo base_url(); ?>index.php/brand/clearAllStockSelected/"+no_of_items;
                        document.manage_brand.submit();
                        
                      

                   }else{
                    return false;
                   }
                 }
             }else{
                 var confirm_data = confirm("Are you sure you want to clear complete stock ?");
                   
                   if(confirm_data){
                document.manage_brand.action="<?php echo base_url(); ?>index.php/brand/clearAllStock";
                        document.manage_brand.submit();
                    }

             }
              }

function searchForm(){

  $("#current_page").val('');
	document.manage_brand.action="<?php echo base_url(); ?>index.php/brand/manageBrand";
	document.manage_brand.submit();
		
}

function clearForm(){

    window.location = "<?php echo site_url('brand/manageBrand'); ?>";
    return false;

}

function manage_batch(brand_id){

    $('#brand_id').val(brand_id);

    document.manage_brand.action="<?php echo base_url(); ?>index.php/batch/index";
    document.manage_brand.submit();

}
	  
function createBrand() {
    
   document.manage_brand.action="<?php echo base_url(); ?>index.php/brand/brandForm/create";
   document.manage_brand.submit();

}

function updateBrand(id) {
    var current_page=$("#current_page").val();
   
        // alert(a);return false;

     	
   document.manage_brand.action="<?php echo base_url(); ?>index.php/brand/brandForm/update/"+id;
   document.manage_brand.submit();
}

function deleteBrand(id) {

    var v=confirm("Do You Want To Delete!");
	if(v) {
   			
		document.manage_brand.action='<?php echo base_url(); ?>index.php/brand/delete/'+id;
		document.manage_brand.submit();
		return true;
	}else return false;
}

</script>