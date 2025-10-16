<style type="text/css">
 #requiredfield{
        
        color: #FF0000;
}
.font_th{

	    font-size: 15px;
}	  
</style>

<form name="user_form" id="user_form" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
           
          </section>

          <!-- Main content -->
          <section class="content">
          <div class="row">
            <div class="col-md-6">
					<div class="callout callout-info">All Fields Are Required</div>
			</div>
		  </div>
            <div class="row">
          <div class="col-md-6">
		    <div class="box box-info">

		        <div class="box-header with-border">
                       <h2 class="box-title">USER INFORMATION</</h2>
					    
                </div>
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
                       <tr>
						
						        <td>User Name <span id='requiredfield'>*</span> : </td>
						
                    <td>
                            <input type="text" name="user_name" id="user_name" onkeypress="nextField(event.keyCode,password)" value="<?php echo !empty($user[0][2])?$user[0][2]:'' ?>" autocomplete="off">
						      
                    </td>
						</tr>
						<tr>
						      <td>Password <span id='requiredfield'>*</span> : </td>

                    <td> 
                                   <input type="password" name="password" id="password"  onkeypress="nextField(event.keyCode,retype_pwd)" value="" autocomplete="off"/>
                    </td>
            </tr>
            <tr>						
						
						        <td>Retype Password <span id='requiredfield'>*</span>  : </td>
                    <td> 
                                   <input type="password" name="retype_pwd" id="retype_pwd" onkeypress="if(event.keyCode ==13)checkPassword();" value="" autocomplete="off"/>
                     </td>
					  </tr>
					  <tr>
					          <td>User Type <span id='requiredfield'>*</span> : </td>
                        
						        <td> 
						              <select name="user_type" id="user_type" onkeypress="nextField(event.keyCode,branch)">
                              <option value="" selected="selected">------------------</option>
                              <option value="8" <?php echo (!empty($user[0][3]) && ($user[0][3]==8))?'selected':'' ?> >PHARMA ADMIN</option>
                              <option value="9" <?php echo (!empty($user[0][3]) && ($user[0][3]==9))?'selected':'' ?> >PHARMA USER</option>
                          </select> 
                    </td>
				       </tr>
               <tr>
                    <td>Branch : </td>
                    
                    <td>
                          <select name="branch" id="branch">

                                <option value="main_branch">Main Branch</option>
                      <?php 
                            for($i=0; $i<count($branchInfo); $i++) { 
                
                      ?>
                                <option value="<?php echo $branchInfo[$i][0]; ?>" <?php echo (!empty($user[0][6]) && ($user[0][6]==$branchInfo[$i][0]))?'selected':'' ?> >
                                          
                                           <?php echo $branchInfo[$i][1]; ?>

                                </option>  
                      <?php
                            }
                      ?>

                          </select>
                    </td>
               </tr>
               <tr>
                    <td></td>
					<td>
					<?php if($action=='create'){?>
                     		 <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create User" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success"  value="Update User" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php } ?>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="id" id="id" value="<?php echo !empty($user[0][0])?$user[0][0]:'' ?>">
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

function checkPassword(){

      pwd=document.user_form.password.value;
      repwd=document.user_form.retype_pwd.value;

      if(repwd=='' || pwd!=repwd){

           showDialog('Error','Password Does Not Match.','error',2);     
           document.user_form.retype_pwd.focus();
           return false;
    
      }else{
  
            user_type.focus();
            return true
      }

}

function submitForm(action) {

            var username  = $('#user_name').val();
            var password  = $('#password').val();
            var retypepwd = $('#retype_pwd').val();
            var usertype= $('#user_type').val();

        if( username=="" ){

               showDialog('Error','Please Enter User Name.','error',2);
               return false;
     	
     	  }else if( password=="" ){

               showDialog('Error','Please Enter Your password.','error',2);
               return false;
      
        }else if( usertype=='' ){

               showDialog('Error','Please Select User Type.','error',2);
               return false;
      
        }else if( retypepwd=='' || password!=retypepwd ){

               showDialog('Error','Password Does Not Match.','error',2);
               return false;
      
        }else{    

               if(action=='create'){
              
                    document.user_form.action="<?php echo base_url(); ?>index.php/admin/create/user";

               }else{

                    document.user_form.action="<?php echo base_url(); ?>index.php/admin/update/user";

               }
      
                    document.user_form.submit();

        }

               
}
	  
</script>