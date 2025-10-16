<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        color: #006633;   
   }	
   .single{
            display:inline;
   }
</style>

<form name="adjust_stock" id="adjust_stock" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  BATCH INFORMATION
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
               
               <div class="box-body">
            <table width="100%" class="table table-striped">
        
            <tr>
                <td>
                      <h4>
                         <b>
                            Brand  :
                            <?php echo $brand_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            Batch :
                            <?php echo $batch_number ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            Expiry Date :
                            <?php echo $expiry_date ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         </b>    
                      </h4>    
                </td>
            </tr>
                   
          </table>
			     
				  <div id="success"><?php echo !empty($message)?$message:''; ?></div>
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
		  </div> <!--row-->

      <section class="content-header">
            <h1>
                  STOCK ADJUSTMENTS
            </h1>
           
      </section>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">
				          <div id="pagination" align="right">
                              
                          </div>
					   <table width="100%" class="table table-striped table-bordered">

					           <tr>

                      <td>Current Stock : </td>
                  <td>
                      <input type="text" name="stock" id="stock" value="<?php echo $stock; ?>" autocomplete="off" readonly="true" >
                  </td>
                </tr>

                <tr>
                
                  <td>Qty : (+/-) : </td>
                  <td>
                      <input type="text" name="qty" id="qty" value="" onkeypress="nextField(event.keyCode,description)" autocomplete="off" >
                  </td>
                </tr>

                <tr>
                      
                </tr>
                     <td>Description : </td>
                     <td>
                          <textarea name="description" cols="16" rows="3" id="description" onkeypress="nextField(event.keyCode,Update)" autocomplete="off"></textarea>
                     </td>
                <tr>
                     <td></td>
                     <td>

                        <input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Stock" onclick="return submitForm()"/>

                     </td>
                </tr>

					   </table> 

                      <input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">
                      <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">

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

function submitForm(){


          var stock= $('#stock').val();
          var qty= $('#qty').val();

          var newstock=Number(stock)+Number(qty);
   
      if( qty=='' ) {

        showDialog('Error','Please Enter Quantity.','error',2);
        return false;

      }else if( qty!='' && !(isNumeric(qty))) {

        showDialog('Error','Please Enter Valid Quantity.','error',2);
        return false;

      }
      else if(newstock<0){

        showDialog('Error','Stock Below Zero.','error',2);
        return false;   

      }
      else{

	      document.adjust_stock.action="<?php echo base_url(); ?>index.php/batch/stock_adjust_update";
	      document.adjust_stock.submit();

      }
		
}

</script>