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

<form name="manage_customer" id="manage_customer" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div>
				    <button type="button" class="btn btn-success" onclick="createCustomer()"><i class="fa fa-plus"></i> CUSTOMER
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
				        <td>Customer Name : &nbsp;&nbsp;&nbsp;<input type="text" name="search_customer_name" id="search_customer_name" value="<?php echo !empty($customer_name)?$customer_name:''; ?>" autocomplete="off"/> &nbsp;&nbsp;&nbsp; 
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
				          <h1 class="box-title">CUSTOMER</h1>
                    </div>

                    <div class="box-body">
				
					   <table width="100%" class="table table-striped table-bordered">
                        <thead>
					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Customer Name</a></th>
				            <th class="font_th"><a href="#">Address</a></th>
				            <th class="font_th"><a href="#">Contact No</a></th>
				            <th class="font_th"><a href="#">Email</a></th>
				            <th class="font_th"><a href="#">Opening Balance</a></th>
				            <th class="font_th"><a href="#">Credit Limit</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
				         </thead>
				         <tbody>
		<?php        
                if(!empty($customers)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($customers);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $customers[$i][1];?></td>
						    <td><?php echo $customers[$i][2];?></td>
							<td><?php echo !empty($customers[$i][3])?$customers[$i][3]:'';?></td>
							<td><?php echo !empty($customers[$i][4])?$customers[$i][4]:'';?></td>
						    <td><?php echo $customers[$i][5];?></td>
							<td><?php echo $customers[$i][6];?></td>
						    <td>
						    	<button type="button" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateCustomer('<?php echo $customers[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
                
						    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteCustomer('<?php echo $customers[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                
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
                 $("#manage_customer").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/customer");
                 $("#manage_customer").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_customer").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/customer");
                 $("#manage_customer").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_customer").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/customer");
                 $("#manage_customer").submit();
    });

});

function searchForm(){

     $("#current_page").val('');
	   document.manage_customer.action="<?php echo base_url(); ?>index.php/admin/manageInfo/customer";
	   document.manage_customer.submit();
		
}

function clearForm(){

        window.location = "<?php echo site_url('admin/manageInfo/customer'); ?>";
        return false;

}
	  
function createCustomer() {
        
    tb_show('CREATE CUSTOMER',"<?php echo base_url(); ?>index.php/admin/generateForm/customer/create");

}

function updateCustomer(id) {
     	
     	tb_show('CREATE CUSTOMER',"<?php echo base_url(); ?>index.php/admin/generateForm/customer/update/"+id);
     	
}

function tb_remove(){
  
    document.manage_customer.action='<?php echo base_url(); ?>index.php/admin/manageInfo/customer';
    document.manage_customer.submit();
}

function deleteCustomer(id) {

    var v=confirm("Do You Want To Delete!");
    if(v) {
   			
	   document.manage_customer.action='<?php echo base_url(); ?>index.php/admin/delete/customer/'+id;
	   document.manage_customer.submit();
			  return true;
    }else return false;
}

</script>