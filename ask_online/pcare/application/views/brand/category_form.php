<style type="text/css">

   #requiredfield{
        
        color: #FF0000;
   } 
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="category_form" id="category_form" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
           
          </section>

          <!-- Main content -->
          <section class="content">
          <div class="row">
            <div class="col-md-6">
					<div class="callout callout-info">Fields Marked With * Are Required</div>
			</div>
		  </div>
            <div class="row">
          <div class="col-md-6">
		    <div class="box box-info">

		        <div class="box-header with-border">
                       <h2 class="box-title">CATEGORY INFORMATION</</h2>
					    
                </div>
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
                       <tr>
						
						        <td>Category Name <span id='requiredfield'>*</span> : </td>
						
                    <td>
                            <input type="text" name="category_name" id="category_name" value="<?php echo !empty($category[0][1])?$category[0][1]:'' ?>" autocomplete="off">
						      
                    </td>
						</tr>
						
            <tr>
                    <td></td>
					<td>
					<?php if($action=='create'){?>
                     		 <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Category" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Category" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php } ?>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="id" id="id" value="<?php echo !empty($category[0][0])?$category[0][0]:'' ?>">
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
		  </div> <!--row-->

		  
          </section><!-- /.content -->
    </div><!-- /.container -->
		
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">

function submitForm(action) {

           var category_name  = $('#category_name').val();

        if( category_name=="" ){

               showDialog('Error','Please Enter Category Name.','error',2);
               return false;
     	
     	  }else{    

               if(action=='create'){
              
                    document.category_form.action="<?php echo base_url(); ?>index.php/brand/processCategory/create";

               }else{

                    document.category_form.action="<?php echo base_url(); ?>index.php/brand/processCategory/update";

               }
      
                    document.category_form.submit();

        }

               
}
	  
</script>