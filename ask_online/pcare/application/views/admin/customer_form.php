<style type="text/css">

   #requiredfield{
        
        color: #FF0000;
   } 
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="customer_form" id="customer_form" method="post" action="">

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
                       <h2 class="box-title">CUSTOMER INFORMATION</</h2>
					    
                </div>
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
                       <tr>
						
						        <td>Customer Name <span id='requiredfield'>*</span> : </td>
						
                    <td>
                            <input type="text" name="Customer_name" id="Customer_name" onkeypress="nextField(event.keyCode,address)" value="<?php echo !empty($customer[0][1])?$customer[0][1]:'' ?>" autocomplete="off">
						      
                    </td>
						</tr>
						<tr>
						      <td>Address : </td>

                    <td> 
                            <textarea name="address" cols="16" rows="3" id="address" onkeypress="nextField(event.keyCode,contact_no)" autocomplete="off"><?php echo !empty($customer[0][2])?$customer[0][2]:'' ?></textarea>
                    </td>
            </tr>
            <tr>						
						
						        <td>Contact No : </td>
                    <td> 
                            <input type="text" name="contact_no" id="contact_no" onkeypress="nextField(event.keyCode,email)" value="<?php echo !empty($customer[0][3])?$customer[0][3]:'' ?>" autocomplete="off"/>
                     </td>
					  </tr>
					  <tr>
					          <td>Email : </td>
                        
						        <td> 
						                       <input type="text" name="email" id="email" value="<?php echo !empty($customer[0][4])?$customer[0][4]:'' ?>" onkeypress="nextField(event.keyCode,opening_balance)" autocomplete="off">
                    </td>
				       </tr>
               <tr>
                    <td>Opening Balance : </td>
                    
                    <td>
                                  <input type="text" name="opening_balance" id="opening_balance" value="<?php echo !empty($customer[0][5])?$customer[0][5]:'' ?>"onkeypress="nextField(event.keyCode,credit_limit)" autocomplete="off">
                    </td>
               </tr>
               <tr>
                    <td>Credit Limit : </td>
                    
                    <td>
                                  <input type="text" name="credit_limit" id="credit_limit" value="<?php echo !empty($customer[0][6])?$customer[0][6]:'' ?>" autocomplete="off">
                    </td>
               </tr>
               <tr>
                    <td></td>
					<td>
					<?php if($action=='create'){?>
                     		 <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Customer" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Customer" onclick="return submitForm('<?php echo $action; ?>')"/>
					<?php } ?>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="id" id="id" value="<?php echo !empty($customer[0][0])?$customer[0][0]:'' ?>">
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

           var customername  = $('#Customer_name').val();

        if( customername=="" ){

               showDialog('Error','Please Enter Customer Name.','error',2);
               return false;
     	
     	  }else{    

               if(action=='create'){
              
                    document.customer_form.action="<?php echo base_url(); ?>index.php/admin/create/customer";

               }else{

                    document.customer_form.action="<?php echo base_url(); ?>index.php/admin/update/customer";

               }
      
                    document.customer_form.submit();

        }

               
}
	  
</script>