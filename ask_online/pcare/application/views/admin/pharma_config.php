<?php 
      $this->load->view("header");
?> 
<style type="text/css">
   #requiredfield{
        
        color: #FF0000;
   }
   .font_th{

	    font-size: 15px;
   }	  
</style>

<form name="pharma_config" id="pharma_config" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
                <h1>   
                    PHARMACY INFO 
                </h1>
          </section>

          <!-- Main content -->
          <section class="content">
                    
          <div class="row">
            <div class="col-md-6">
<?php 
     if(!empty($message)) 
        {
?>

                    <div id='message' class="callout callout-success"><?php echo $message;?></div>
<?php
        }
?>
					<div class="callout callout-info">Fields Marked With * Are Required</div>
			</div>
		  </div>
            <div class="row">
          <div class="col-md-6">
		    <div class="box box-info">
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				        <tr>
				            <td>
							 SAME HOSPITAL NAME :
							</td>
				        	<td>
							    <input type="checkbox" name="hosp_name" value="1" id="hosp_name" <?php echo (!empty($hosp_name) && ($hosp_name==1))?'checked':'' ?> onchange="change_name();">
                            </td>
				        </tr>
                        <tr>

  							<td>PHARMACY NAME <span id='requiredfield'>*</span> : </td>
							<td>
							    <input type="text" name="pharmacy_name" id="pharmacy_name" value='<?php echo !empty($hospital_name)?$hospital_name:$pharmacyInfo[0][1];?>' autocomplete="off" onkeypress="nextField(event.keyCode,address)"/>
							</td>
						</tr>
                        <tr>

  							<td>GST NO <span id='requiredfield'>*</span> : </td>
							<td><input type="text" name="gst_no" id="gst_no" value='<?php echo $pharmacyInfo[0][2];?>' autocomplete="off" onkeypress="nextField(event.keyCode,dl_no)"/></td>
					    </tr>
						<tr>

  							<td>DL NO <span id='requiredfield'>*</span> : </td>
							<td><input type="text" name="dl_no" id="dl_no" value='<?php echo $pharmacyInfo[0][3];?>' autocomplete="off" onkeypress="nextField(event.keyCode,city)"/></td>
						</tr>
				    </table>
				</div>
			   </div>
			</div> 
		  </div>
		  <div class="row">
          <div class="col-md-6">
		    <div class="box box-info">
                
                <div class="box-header with-border">
                       <h2 class="box-title">CC EMAIL LIST</</h2>
					    
                </div>

               <div class="box-body">	
				    <table width="100%" class="table table-striped" id="add_new_email">
						<tr>
							<td>ADD NEW CC EMAIL : </td>
							<td>
								<input type="text" name="cc_email" id="cc_email" value='' autocomplete="off" onkeypress="if(event.keyCode== 13){return add_mail()}"/>
							</td>
						</tr>
					
				     <?php
				         $last_position='';
                         $old_email=$pharmacyInfo[0][7];
                         $old_email_list=explode(",",$old_email);
                  
                          if(!empty($old_email)){
                         	    
                         	for ($i=0; $i<count($old_email_list); $i++){ 
                     ?>   <tr id="tr<?php echo $i; ?>">
                            <td>
                              <?php echo $old_email_list[$i] ?>
                              <input type="hidden" name="cc_email_list[]" id="cc_email_list" value="<?php echo $old_email_list[$i]; ?>" readonly>
                              <a href='#' class='delete_email text-red' id="<?php echo $i ?>" onclick="delete_email('<?php echo $i ?>')"><i class='fa fa-remove'></i></a>
                            </td>
                          </tr>
                     <?php
                            }
                             end($old_email_list);
                             $last_position = key($old_email_list);
                          }
                     ?>
				  </table>	
				  <table width="100%" class="table table-striped">
						<tr>
								<td colspan='2' align="center"><input id="button1" class="btn btn-success" type="button" name="Update" value="Update" onclick="return submitForm()"/></td>
						</tr>
				  </table>
				            <input type="hidden" name="last_position_email" id="last_position_email" value="<?php echo $last_position; ?>" >

				            <input type=hidden name="actualposition" id="actualposition" value="">

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

function change_name(){

	document.pharma_config.action="<?php echo base_url(); ?>index.php/admin/pharmacy_info";
	document.pharma_config.submit();
}

function add_mail(){

   var new_email = $('#cc_email').val();
   var last_position = $('#last_position_email').val();
   var actualposition = $('#actualposition').val();
   var position=0;

   if(last_position!=''){
   	  last_position++;
   	  position=last_position;
   }

   if(actualposition!=''){

   	  position=actualposition;
   }
   
   var new_row="<tr id=tr"+position+"><td>"+new_email+"<input type='hidden' name=cc_email_list[] id='cc_email_list' value='"+new_email+"' readonly> <a href='#' class='delete_email text-red' id='"+position+"' onclick=delete_email("+position+")><i class='fa fa-remove'></i></a></td></tr>";
  $( "#add_new_email" ).append(new_row);

  position++;

  $('#cc_email').val('');
  $('#actualposition').val(position);

}

function delete_email(id){

	$("#tr"+id ).remove();
}

function submitForm() {
   
   		if(document.pharma_config.pharmacy_name.value=='') {
   			showDialog('Error','Please Enter Pharmacy Name.','error',2);
			return false;
			
		}else if(document.pharma_config.gst_no.value=='') {
		
   			showDialog('Error','Please Enter Gst No.','error',2);
			return false;
			
		}else if(document.pharma_config.dl_no.value=='') {
		
   			showDialog('Error','Please Enter Dl No.','error',2);
			return false;
			
		}else {

		    showDialog('Message','UPDATING PHARMACY INFO','',2); 

			setTimeout(function(){

				document.pharma_config.action="<?php echo base_url(); ?>index.php/admin/pharmacy_info/update";
			    document.pharma_config.submit();
				
            }, 2000);
          	
		}
}

// $(document).ready(function(){

//     $( ".delete_email" ).click(function() {
		   
// 		var id=$(this).attr('id');
// 		alert(id);
	    
		   
// 	});
// });
	  
</script>