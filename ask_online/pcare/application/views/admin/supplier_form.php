<style type="text/css">

   #requiredfield{
        
        color: #FF0000;
   } 
   .font_th{

      font-size: 15px;
   }    
</style>

<form name="supplier_form" id="supplier_form" method="post" action="">

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
                       <h2 class="box-title">SUPPLIER INFORMATION</</h2>
              
                </div>
                
               <div class="box-body">
            <table width="100%" class="table table-striped">
        
                       <tr>
            
                    <td>Supplier Name <span id='requiredfield'>*</span> : </td>
            
                    <td>
                            <input type="text" name="Supplier_name" id="Supplier_name" onkeypress="nextField(event.keyCode,address)" value="<?php echo !empty($supplier[0][1])?$supplier[0][1]:'' ?>" autocomplete="off">
                  
                    </td>
            </tr>
            <tr>
                  <td>Address : </td>

                    <td> 
                            <textarea name="address" cols="16" rows="3" id="address" onkeypress="nextField(event.keyCode,tin_no)" autocomplete="off"><?php echo !empty($supplier[0][2])?$supplier[0][2]:'' ?></textarea>
                    </td>
            </tr>
            <tr>            
            
                    <td>Tin No : </td>
                    <td> 
                            <input type="text" name="tin_no" id="tin_no" onkeypress="nextField(event.keyCode,gst_no)" value="<?php echo !empty($supplier[0][8])?$supplier[0][8]:'' ?>" autocomplete="off"/>
                     </td>
            </tr>
            <tr>
                    <td>GST No : </td>
                        
                    <td> 
                                   <input type="text" name="gst_no" id="gst_no" value="<?php echo !empty($supplier[0][10])?$supplier[0][10]:'' ?>" onkeypress="nextField(event.keyCode,contact_no)" autocomplete="off">
                    </td>
               </tr>
               <tr>
                    <td>Contact No : </td>
                    
                    <td>
                                  <input type="text" name="contact_no" id="contact_no" value="<?php echo !empty($supplier[0][3])?$supplier[0][3]:'' ?>" onkeypress="nextField(event.keyCode,email)" autocomplete="off">
                    </td>
               </tr>
               <tr>
                    <td>Email : </td>
                    
                    <td>
                                  <input type="text" name="email" id="email" value="<?php echo !empty($supplier[0][4])?$supplier[0][4]:'' ?>" onkeypress="nextField(event.keyCode,opening_balance)" autocomplete="off">
                    </td>
               </tr>
            <!--    <tr>
                    <td>Opening Balance  : </td>
                    
                    <td>
                                  <input type="text" name="opening_balance" id="opening_balance" value="<?php echo !empty($supplier[0][5])?$supplier[0][5]:'' ?>" onkeypress="nextField(event.keyCode,credit_limit)" autocomplete="off">
                    </td>
               </tr> -->
                                  
               <tr>
                    <td>Credit Limit : </td>
                    
                    <td>
                                  <input type="text" name="credit_limit" id="credit_limit" value="<?php echo !empty($supplier[0][6])?$supplier[0][6]:'' ?>" onkeypress="nextField(event.keyCode,ledger)" autocomplete="off">
                    </td>
               </tr>
             <!--   <tr>
                    <td>Ledger Account : </td>
                    
                    <td>  -->
          <?php if($action=='create'){?>       

                               <input type="hidden" name="ledger" id="ledger" value="1" checked>

          <?php }else{  
                        if(!empty($supplier[0][9]) && ($supplier[0][9]!=0)){
          ?>
 
                                      <input type="hidden" name="ledger_acc_name" id="ledger_acc_name" value="<?php echo $supplier[0][1]; ?>" readonly >                         
          <?php              }else{
          ?>

                                      <input type="hidden" name="ledger" id="ledger" value="1">                           

          <?php
                        }
          ?>

          <?php }  ?>

                    </td>
               </tr>
               <tr>
                    <td></td>
          <td>
          <?php if($action=='create'){

                   if($from_location=='from_purchase'){
          ?>
                         <input type="button" name="Create" value="Create Supplier" class="btn btn-success" id="create_supplier">
          <?php
                   }else{
          ?>

                         <input id="button1" type="button" name="Create" class="btn btn-success"  value="Create Supplier" onclick="return submitForm('<?php echo $action; ?>')"/>
          <?php
                   }

                }else { 
          ?>

                   <input id="button1" type="button" name="Update" class="btn btn-success"  value="Update Supplier" onclick="return submitForm('<?php echo $action; ?>')"/>

          <?php } ?>
           </td>
        </tr>

          </table>

                  <input type="hidden" name="opening_balance" id="opening_balance" value="0" onkeypress="nextField(event.keyCode,credit_limit)" autocomplete="off">

                   <input type="hidden" name="id" id="id" value="<?php echo !empty($supplier[0][0])?$supplier[0][0]:'' ?>">

                   <input type="hidden" name="ledger_id" id="ledger_id" value="<?php echo !empty($supplier[0][9])?$supplier[0][9]:'' ?>">
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

           var suppliername  = $('#Supplier_name').val();
           var contact_no  = $('#contact_no').val();
           var email  = $('#email').val();

        if( suppliername=="" ){

               showDialog('Error','Please Enter Supplier Name.','error',2);
               return false;
      
        }else if(contact_no!='' && !(isNumeric(contact_no))){

               showDialog('Error','Please Enter Valid Contact  Number.','error',2);
               return false;

        }else if((!validateEmail(email))){

               showDialog('Error','Please Enter Valid Email.','error',2);
               return false;

        }else{    

               if(action=='create'){
              
                    document.supplier_form.action="<?php echo base_url(); ?>index.php/admin/create/supplier";

               }else{

                    document.supplier_form.action="<?php echo base_url(); ?>index.php/admin/update/supplier";

               }
      
                    document.supplier_form.submit();

        }

               
}

$(document).ready(function(){

  $("#create_supplier").click(function(){

        var suppliername  = $('#Supplier_name').val();
        var contact_no  = $('#contact_no').val();
        var email  = $('#email').val();

        if( suppliername=="" ){

               showDialog('Error','Please Enter Supplier Name.','error',2);
               return false;
      
        }else if(contact_no!='' && !(isNumeric(contact_no))){

               showDialog('Error','Please Enter Valid Contact  Number.','error',2);
               return false;

        }else if((!validateEmail(email))){

               showDialog('Error','Please Enter Valid Email.','error',2);
               return false;

        }else{    

              $.post("<?php echo base_url(); ?>index.php/admin/create/supplier/json_submit", $("#supplier_form").serialize(),function(data){
       
                if(data['supplier_id'] >0){

                  $("#newsupplier").val(data['supplier_id']);
                  $("#item_focus").val("brand");
                  $("#purchase_form").attr("action","<?php echo base_url(); ?>index.php/purchase/purchase_form");
                  $("#purchase_form").submit();
                }

              },"json");

        }

  });

});
    
</script>