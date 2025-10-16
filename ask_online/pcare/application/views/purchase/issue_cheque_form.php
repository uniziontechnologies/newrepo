<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="issue_cheque_form" id="issue_cheque_form" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                 Credit Payment
            </h1>
           
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

                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				   
            <tr>
              <td><b>Inv No : <?php echo $purchaseInfo[0][1];?></b></td>
              <td><b>Bill Date : <?php echo $purchaseInfo[0][3];?></b></td>
            </tr>
            <tr>
						
						        <td>Bill Amount : </td>
						
                    <td>
                          <input type="text" name="bill_total" id="bill_total" onkeypress="nextField(event.keyCode,balance_amt)" value="<?php echo $purchaseInfo[0][12];?>" autocomplete="off" readonly="true" >
						      
                    </td>
						</tr>
						<tr>
						      <td>Balance Amount : </td>

                  <td> 
                        <input type="text" name="balance_amt" id="balance_amt"  onkeypress="nextField(event.keyCode,new_amount)" value="<?php echo $purchaseInfo[0][44];?>" autocomplete="off" readonly="true" >
                  </td>
            </tr>
            <tr>						
						
						      <td>New Amount <span id='requiredfield'>*</span> : </td>

                  <td> 
                        <input type="text" name="new_amount" id="new_amount" onkeypress="nextField(event.keyCode,cheque_no)" value="" autocomplete="off"/>
                  </td>
					  </tr>
					  <tr>
					        <td>Checque No <span id='requiredfield'>*</span> : </td>
                        
						      <td> 
						           <input type="text" name="cheque_no" id="cheque_no" onkeypress="nextField(event.keyCode,issue_date)" value="" autocomplete="off"/>
                  </td>
					   
				    </tr>
            <tr>
                  <td>Issue Date <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="issue_date" id="issue_date" onkeypress="nextField(event.keyCode,re_pass)" value="" autocomplete="off"/>
                  </td>
             
            </tr>
            <tr>
                  <td></td>
					  <td>
                     		 <input id="button1" type="button" name="save" class="btn btn-success"  value="Add Payment" onclick="return save_bill()"/>
					 </td>
				</tr>

				  </table>
				           <input type="hidden" name="billid" id="billid" value="<?php echo $purchaseInfo[0][1];?>">
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

$(function () {
   
     //Date range picker
        $('#issue_date').datepicker();
     
   });

function save_bill() {
 
            var new_amount= $('#new_amount').val();
            var cheque_no= $('#cheque_no').val();
            var issue_date= $('#issue_date').val();

      if(new_amount=="" || !isNumeric(new_amount)){
        showDialog('Error','Please Enter Valid Amount!.','error',2);
        $("#new_amount").focus();
        return false;
      }
      else if( Number(new_amount) != Number($('#balance_amt').val()) ){
        showDialog('Error','Please Check Balance Amount!.','error',2);
        $("#new_amount").focus();
        return false;
      }else if(cheque_no == ""){
        showDialog('Error','Please Enter Cheque No!.','error',2);
        $("#cheque_no").focus();
        return false;
      }else if(issue_date == ""){
        showDialog('Error','Please Enter Cheque Issue Date!.','error',2);
        $("#issue_date").focus();
        return false;
      }else{

                document.issue_cheque_form.action="<?php echo base_url(); ?>index.php/purchase/addChequePayment";
                document.issue_cheque_form.submit();
        }

}
	  
</script>