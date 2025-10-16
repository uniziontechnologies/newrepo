<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="gst_form" id="gst_form" method="post" action="">

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
                       <h2 class="box-title">GST INFORMATION</</h2>
					    
                </div>
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
                       <tr>
						
						        <td>GST% <span id='requiredfield'>*</span> : </td>
						
                    <td>
                                    <input type="text" name="gst_per" id="gst_per" onkeypress="nextField(event.keyCode,sgst_per)" value="<?php echo !empty($gstInfo[0][1])?$gstInfo[0][1]:'' ?>" autocomplete="off">
						      
                    </td>
						</tr>
						<tr>
						      <td>SGST <span id='requiredfield'>*</span> : </td>

                  <td> 
                                   <input type="text" name="sgst_per" id="sgst_per"  onkeypress="nextField(event.keyCode,cgst_per)" value="<?php echo !empty($gstInfo[0][2])?$gstInfo[0][2]:'' ?>" autocomplete="off"/>
                  </td>
            </tr>
            <tr>						
						
						      <td>CGST <span id='requiredfield'>*</span> : </td>

                  <td> 
                                   <input type="text" name="cgst_per" id="cgst_per" onkeypress="nextField(event.keyCode,igst_per)" value="<?php echo !empty($gstInfo[0][3])?$gstInfo[0][3]:'' ?>" autocomplete="off"/>
                  </td>
					  </tr>
					  <tr>
					        <td>IGST : </td>
                        
						      <td> 
						           <input type="text" name="igst_per" id="igst_per" onkeypress="nextField(event.keyCode,re_pass)" value="<?php echo !empty($gstInfo[0][4])?$gstInfo[0][4]:'' ?>" autocomplete="off"/>
                  </td>
					   
				    </tr>
            <tr>
                  <td></td>
					  <td>
					      <?php if($action=='create'){?>

                     		 <input id="button1" type="button" name="Create" class="btn btn-success"  value="Add" onclick="return submitForm('<?php echo $action; ?>')"/>

					      <?php }else { ?>

							          <input id="button1" type="button" name="Update" class="btn btn-success"  value="Update" onclick="return submitForm('<?php echo $action; ?>')"/>

					      <?php } ?>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="gstid" id="gstid" value="<?php echo !empty($gstInfo[0][0])?$gstInfo[0][0]:'' ?>">
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

            var gst_per= $('#gst_per').val();
            var sgst_per= $('#sgst_per').val();
            var cgst_per= $('#cgst_per').val();

        if( gst_per=="" || !(isNumeric(gst_per)) ){

               showDialog('Error','Please Enter Valid GST Percentage.','error',2);
               return false;
     	
     	  }else if( sgst_per=="" || !(isNumeric(sgst_per)) ){

               showDialog('Error','Please Enter Valid SGST  Percentage.','error',2);
               return false;
      
        }else if( cgst_per=="" || !(isNumeric(cgst_per)) ){

               showDialog('Error','Please Enter Valid CGST  Percentage.','error',2);
               return false;
      
        }else{

               if(action=='create'){
              
                    document.gst_form.action="<?php echo base_url(); ?>index.php/admin/create/gst";

               }else{

                    document.gst_form.action="<?php echo base_url(); ?>index.php/admin/update/gst";

               }
      
                    document.gst_form.submit();
        }

}
	  
</script>