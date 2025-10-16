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

<form name="manage_supplier" id="manage_supplier" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div>
				    <button type="button" class="btn btn-success" onclick="createSupplier()"><i class="fa fa-plus"></i> SUPPLIER
				    </button>

		    </div>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $delete_success = $this->session->flashdata('delete_success'); 
                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>
                        <?php
                            }
                        if(!empty($delete_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo $delete_success; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>Supplier Name : &nbsp;&nbsp;&nbsp;<input type="text" name="search_supplier_name" id="search_supplier_name" value="<?php echo !empty($supplier_name)?$supplier_name:''; ?>" autocomplete="off"/> &nbsp;&nbsp;&nbsp;
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
				          <h1 class="box-title">SUPPLIER</h1>
                     </div>	

                    <div class="box-body">
				          
					   <table width="100%" class="table table-striped table-bordered">
                         <thead>
					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Supplier Name</a></th>
				            <th class="font_th"><a href="#">Address</a></th>
				            <th class="font_th"><a href="#">GST No</a></th>
				            <th class="font_th"><a href="#">Tin No</a></th>
				            <th class="font_th"><a href="#">Contact No</a></th>
				            <th class="font_th"><a href="#">Email</a></th>
				            <th class="font_th"><a href="#">Opening Balance</a></th>
				            <th class="font_th"><a href="#">Credit Limit</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
				         </thead>
				         <tbody>
		<?php        
                if(!empty($suppliers)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($suppliers);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $suppliers[$i][1];?></td>
						    <td><?php echo $suppliers[$i][2];?></td>
							<td><?php echo ($suppliers[$i][10]!=0)?$suppliers[$i][10]:'';?></td>
						    <td><?php echo ($suppliers[$i][8]!=0)?$suppliers[$i][8]:'';?></td>
						    <td><?php echo !empty($suppliers[$i][3])?$suppliers[$i][3]:'';?></td>
						    <td><?php echo !empty($suppliers[$i][4])?$suppliers[$i][4]:'';?></td>
						    <td><?php echo $suppliers[$i][5];?></td>
						    <td><?php echo $suppliers[$i][6];?></td>
						    <td>
						    	<button type="button" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateSupplier('<?php echo $suppliers[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
               
						    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteSupplier('<?php echo $suppliers[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
               
						    </td>
				        </tr>
		<?php
		            }
		        }
		?>			
		                </tbody>   
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
                 $("#manage_supplier").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/supplier");
                 $("#manage_supplier").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_supplier").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/supplier");
                 $("#manage_supplier").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_supplier").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/supplier");
                 $("#manage_supplier").submit();
    });

});


function searchForm(){
      
      $("#current_page").val('');
	  document.manage_supplier.action="<?php echo base_url(); ?>index.php/admin/manageInfo/supplier";
	  document.manage_supplier.submit();
		
}

function clearForm(){

       window.location = "<?php echo site_url('admin/manageInfo/supplier'); ?>";
       return false;

}
	  
function createSupplier() {
        
    tb_show('CREATE SUPPLIER',"<?php echo base_url(); ?>index.php/admin/generateForm/supplier/create");

}

function updateSupplier(id) {
     	
    tb_show('UPDATE SUPPLIER',"<?php echo base_url(); ?>index.php/admin/generateForm/supplier/update/"+id);
}

function tb_remove(){
  
    document.manage_supplier.action='<?php echo base_url(); ?>index.php/admin/manageInfo/supplier';
    document.manage_supplier.submit();
}

function deleteSupplier(id) {

     	var v=confirm("Do You Want To Delete!");
		if(v) {
   			
			document.manage_supplier.action='<?php echo base_url(); ?>index.php/admin/delete/supplier/'+id;
			document.manage_supplier.submit();
			  return true;
		}else return false;
}

</script>