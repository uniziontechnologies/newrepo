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

<form name="manage_users" id="manage_users" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
             <div>
				    <button type="button" class="btn btn-success" onclick="createUser()"><i class="fa fa-plus"></i> USER
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
				        <td>User Name : &nbsp;&nbsp;&nbsp;<input type="text" name="search_user_name" id="search_user_name" value="<?php echo !empty($user_name)?$user_name:''; ?>" autocomplete="off"/> &nbsp;&nbsp;&nbsp; OR &nbsp;&nbsp;&nbsp; 	User Type : &nbsp;&nbsp;&nbsp;
				        <select name="search_user_type" id="search_user_type" onchange="searchForm();" onkeypress="searchForm();">
				                   <option value="">------------------</option>
                           <option value="8" <?php echo (!empty($user_type) && ($user_type=='8'))?"selected":''; ?> >PHARMA ADMIN</option>
				                   <option value="9" <?php echo (!empty($user_type) && ($user_type=='9'))?"selected":''; ?> >PHARMA USER</option>
				        </select> &nbsp;&nbsp;&nbsp;
				        Branch : &nbsp;&nbsp;&nbsp;
				        <select name="search_branch" id="search_branch" onchange="searchForm();" onkeypress="searchForm();">
				                   <option value="">-----------------------</option>
				                   <option value="main_branch" <?php echo (!empty($branch_select) && ($branch_select=='main_branch'))?"selected":''; ?> >Main Branch</option>
				    <?php 
                            for($i=0; $i<count($branchInfo); $i++) { 
                
                    ?>
                                <option value="<?php echo $branchInfo[$i][0]; ?>" <?php echo (!empty($branch_select) && ($branch_select==$branchInfo[$i][0]))?"selected":''; ?> >
                                          
                                           <?php echo $branchInfo[$i][1]; ?>

                                </option>  
                    <?php
                            }
                    ?>
				        </select> &nbsp;&nbsp;&nbsp;
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
				          <h1 class="box-title">USER</h1>
                     </div>	

                    <div class="box-body">
				
					   <table width="100%" class="table table-striped table-bordered">
                          <thead>
					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">User Name</a></th>
				            <th class="font_th"><a href="#">User Type</a></th>
				            <th class="font_th"><a href="#">Branch</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
                          </thead>
						  <tbody>	
		<?php        
                if(!empty($users)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($users);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $users[$i][2];?></td>
						    <td><?php echo $users[$i][4];?></td>
							<td>
							    <?php echo empty($users[$i][7])?"Main Branch":$users[$i][7];?>
							</td>
						    	
						    <td>
						    	<button type="button" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateUser('<?php echo $users[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
<?php if($this->session->userdata('user_id') != $users[$i][0]) 
        {
?>
						    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteUser('<?php echo $users[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
<?php
        }
?>
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
                 $("#manage_users").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/user");
                 $("#manage_users").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_users").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/user");
                 $("#manage_users").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_users").attr("action","<?php echo base_url(); ?>index.php/admin/manageInfo/user");
                 $("#manage_users").submit();
    });

});


function searchForm(){

    $("#current_page").val('');
	  document.manage_users.action="<?php echo base_url(); ?>index.php/admin/manageInfo/user";
	  document.manage_users.submit();
		
}

function clearForm(){

        window.location = "<?php echo site_url('admin/manageInfo/user'); ?>";
        return false;

}
	  
function createUser() {
     	  
  tb_show('CREATE USER',"<?php echo base_url(); ?>index.php/admin/generateForm/user/create");

}

function updateUser(id) {
     	
  tb_show('UPDATE USER',"<?php echo base_url(); ?>index.php/admin/generateForm/user/update/"+id);

}

function tb_remove(){
  
    document.manage_users.action='<?php echo base_url(); ?>index.php/admin/manageInfo/user';
    document.manage_users.submit();
}

function deleteUser(id) {

      var v=confirm("Do You Want To Delete!");
		  if(v) {
   			
			  document.manage_users.action='<?php echo base_url(); ?>index.php/admin/delete/user/'+id;
			  document.manage_users.submit();
			  return true;
		  }else return false;
}

</script>