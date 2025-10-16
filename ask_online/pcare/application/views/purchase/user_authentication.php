<?php
$batchInfo=$this->session->userdata('batchidInfo');

?> 
<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .font_th{

      font-size: 15px;
   }    
</style>

<form name="user" id="user" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                 User Authentication
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
            
                    <td>User Name <span id='requiredfield'>*</span> : </td>
            
                    <td>
                          <input type="text" name="username" id="username" onkeypress="nextField(event.keyCode,password)" value="" autocomplete="off" >
                  
                    </td>
            </tr>
            <tr>
                  <td>Password <span id='requiredfield'>*</span> : </td>

                  <td> 
                        <input type="password" name="password" id="password"  onkeypress="nextField(event.keyCode,sanctioned_by)" value="" autocomplete="off" >
                  </td>
            </tr>
            <tr>            
            
                  <td>Sanctioned By <span id='requiredfield'>*</span> : </td>

                  <td> 
                        <input type="text" name="sanctioned_by" id="sanctioned_by" onkeypress="nextField(event.keyCode,authentication_remarks)" value="" autocomplete="off"/>
                  </td>
            </tr>
            <tr>
                  <td>Remarks <span id='requiredfield'>*</span> : </td>
                        
                  <td> 
                       <input type="text" name="authentication_remarks" id="authentication_remarks" onkeypress="nextField(event.keyCode,authenticate)" value="" autocomplete="off"/>
                  </td>
             
            </tr>
            
            <tr>
                  <td></td>
            <td>
                         <input id="authenticate" type="button" name="authenticate" class="btn btn-success"  value="Authenticate" onclick="return save_bill()"/>
           </td>
        </tr>

          </table>
                        <input type="hidden" name="authentication_type" id="authentication_type" value="<?php echo $authentication_type;?>">
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

$(document).ready(function() {
 
  $("#authenticate").click( function () {

 
    if(($("#username").val() == '' )){
      showDialog('Error','Please Enter User name.','error',2);
    }else if(($("#password").val() == '' )){
      showDialog('Error','Please Enter Password.','error',2);
    }else if(($("#authentication_type").val() == "CREDIT_PURCHASE_BILL_AUTHENTICATION" ) && $("#sanctioned_by").val() == '' ){
    
      showDialog('Error','Please Enter Sanctioned By.','error',2);
    }else if(($("#authentication_type").val() == "CREDIT_PURCHASE_BILL_AUTHENTICATION" ) && $("#authentication_remarks").val() == '' ){
    
      showDialog('Error','Please Enter Remarks.','error',2);
    }else{
    
      $.post("<?php echo base_url(); ?>index.php/login/user_authentication", $("#user").serialize(),function(data){
        
        if(data['authentication'] == "failed"){
          showDialog('Error','User Authentication Failed.Please Enter Correct user name and password to update the bill.','error',2);
        }else if(($("#authentication_type").val() == "CREDIT_PURCHASE_BILL_AUTHENTICATION" ) ){
          
          $('#sanc_by_hidden').val($("#sanctioned_by").val());
          $('#auth_remarks_hidden').val($("#authentication_remarks").val());
          
          $('#purchase_form').attr('action',"<?php echo base_url(); ?>index.php/purchase/add_purchase/"+data['user_id']);
          $('#purchase_form').submit();
        }
      },"json");
    
    }

  });

});
    
</script>
