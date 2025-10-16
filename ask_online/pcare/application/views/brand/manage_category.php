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
</style>

<form name="manage_category" id="manage_category" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div>
				    <button type="button" class="btn btn-success" onclick="createCategory()"><i class="fa fa-plus"></i> CATEGORY
				    </button>
		    </div>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $delete_success = $this->session->flashdata('delete_success');
                         $user_exist_message = $this->session->flashdata('user_exist_message');
                         if(!empty($delete_success) || !empty($user_exist_message)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo !empty($delete_success)?$delete_success:$user_exist_message; ?></div>
                        <?php
                            }
                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>Category Name : &nbsp;&nbsp;&nbsp;<input type="text" name="search_category_name" id="search_category_name" value="<?php echo !empty($category_name)?$category_name:''; ?>" autocomplete="off"/> &nbsp;&nbsp;&nbsp; 
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

               <div class="col-md-3">
             
                    <?php echo $pagination_link; ?>
              
               </div>
            </div>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                    
                    <div class="box-header with-border">
				          <h1 class="box-title">CATEGORY</h1>
                    </div>

                    <div class="box-body">
				
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Category Name</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
		<?php        
                if(!empty($categoryInfo)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($categoryInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $categoryInfo[$i][1];?></td>
						 
						    <td>
						    	<button type="button" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateCategory('<?php echo $categoryInfo[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                
						    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteCategory('<?php echo $categoryInfo[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                
						    </td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
					       <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
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
                 $("#manage_category").attr("action","<?php echo base_url(); ?>index.php/brand/manageCategory");
                 $("#manage_category").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_category").attr("action","<?php echo base_url(); ?>index.php/brand/manageCategory");
                 $("#manage_category").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_category").attr("action","<?php echo base_url(); ?>index.php/brand/manageCategory");
                 $("#manage_category").submit();
    });

  });

function searchForm(){

       $("#current_page").val('');
	   document.manage_category.action="<?php echo base_url(); ?>index.php/brand/manageCategory";
	   document.manage_category.submit();
		
}

function clearForm(){

    window.location = "<?php echo site_url('brand/manageCategory'); ?>";
    return false;

}
	  
function createCategory() {
        
    tb_show('CREATE CATEGORY',"<?php echo base_url(); ?>index.php/brand/categoryForm/create");

}

function updateCategory(id) {
     	
    tb_show('UPDATE CATEGORY',"<?php echo base_url(); ?>index.php/brand/categoryForm/update/"+id);

}

function tb_remove(){
	
	document.manage_category.action='<?php echo base_url(); ?>index.php/brand/manageCategory';
	document.manage_category.submit();
}

function deleteCategory(id) {

    var v=confirm("Do You Want To Delete!");
    if(v) {
   			
		document.manage_category.action='<?php echo base_url(); ?>index.php/brand/processCategory/delete/'+id;
		document.manage_category.submit();
			  return true;
	}else return false;
}

</script>