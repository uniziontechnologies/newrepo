<style type="text/css">

   #requiredfield{
        
        color: #FF0000;
   } 
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="branch_form" id="branch_form" method="post" action="">

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
                       <h2 class="box-title">BRANCH INFORMATION</</h2>
					    
                </div>
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
                       <tr>
						
						        <td>Branch Name <span id='requiredfield'>*</span> : </td>
						
                    <td>
                            <input type="text" name="Branch_name" id="Branch_name" onkeypress="nextField(event.keyCode,address)" value="<?php echo !empty($branch[0][1])?$branch[0][1]:'' ?>" autocomplete="off">
						      
                    </td>
						</tr>
						<tr>
						      <td>Address : </td>

                    <td> 
                            <textarea name="address" cols="16" rows="3" id="address" onkeypress="nextField(event.keyCode,contact_no)" autocomplete="off"><?php echo !empty($branch[0][2])?$branch[0][2]:'' ?></textarea>
                    </td>
            </tr>
            <tr>
                    <td>Contact No : </td>
                    
                    <td>
                                  <input type="text" name="contact_no" id="contact_no" value="<?php echo !empty($branch[0][3])?$branch[0][3]:'' ?>" onkeypress="nextField(event.keyCode,email)" autocomplete="off">
                    </td>
            </tr>
            <tr>
                    <td>Email : </td>
                    
                    <td>
                                  <input type="text" name="email" id="email" value="<?php echo !empty($branch[0][4])?$branch[0][4]:'' ?>" onkeypress="nextField(event.keyCode,opening_balance)" autocomplete="off">
                    </td>
            </tr>
            <tr>
                    <td>Opening Balance  : </td>
                    
                    <td>
                                  <input type="text" name="opening_balance" id="opening_balance" value="<?php echo !empty($branch[0][5])?$branch[0][5]:'' ?>" onkeypress="nextField(event.keyCode,credit_limit)" autocomplete="off">
                    </td>
            </tr>
            <tr>
                    <td>Credit Limit : </td>
                    
                    <td>
                                  <input type="text" name="credit_limit" id="credit_limit" value="<?php echo !empty($branch[0][6])?$branch[0][6]:'' ?>" autocomplete="off">
                    </td>
            </tr>
            <tr>
                    <td></td>
					<td>
					<?php if($action=='create'){?>
                     		 <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Branch" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Branch" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php } ?>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="id" id="id" value="<?php echo !empty($branch[0][0])?$branch[0][0]:'' ?>">
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

           var branchname  = $('#Branch_name').val();

        if( branchname=="" ){

               showDialog('Error','Please Enter Branch Name.','error',2);
               return false;
     	
     	  }else{    

               if(action=='create'){
              
                    document.branch_form.action="<?php echo base_url(); ?>index.php/admin/create/branch";

               }else{

                    document.branch_form.action="<?php echo base_url(); ?>index.php/admin/update/branch";

               }
      
                    document.branch_form.submit();

        }

               
}
	  
</script>