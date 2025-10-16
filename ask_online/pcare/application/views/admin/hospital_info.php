<?php 
      $this->load->view("header");
?> 
<style type="text/css">

	#requiredfield{
        
        color: #FF0000;
	}
</style>

<form name="hospital_info" id="hospital_info" method="post" action="">
        <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  HOSPITAL INFO      
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">

                    <?php 
                         if(!empty($message)) 
                            {
                    ?>

                              <div id='message' class="callout callout-success"><?php echo $message;?></div>
                    <?php
                            }
                    ?>
            <div class="row">
          <div class="col-md-6">
										
			        <div class="box box-info ">
                     <div class="box-header with-border">	
								
						<table  class="table table-striped">	
							
								<tr>

  								    <td>HOSPITAL NAME <span id='requiredfield'>*</span> : </td>
									<td><input type="text" name="hospital_name" id="hospital_name" value='<?php echo $hospitalInfo[0][1];?>' autocomplete="off" onkeypress="nextField(event.keyCode,address)"/></td>
								</tr>
								<tr>
								
								    <td>ADDRESS : </td>
									<td><textarea name="address" id="address" autocomplete="off" onkeypress="nextField(event.keyCode,gst_no)" rows="2" cols="15"/><?php echo $hospitalInfo[0][2];?></textarea>
									</td>
                                </tr>
                                <tr>
                                								
									<td>CITY : </td>
									<td>	<input type="text" name="city" id="city" value='<?php echo $hospitalInfo[0][3];?>' autocomplete="off" onkeypress="nextField(event.keyCode,state)"/></td>
								</tr>
								<tr>
								    <td>STATE : </td>
									<td><input type="text" name="state" id="state" value='<?php echo $hospitalInfo[0][4];?>' autocomplete="off" onkeypress="nextField(event.keyCode,country)"/></td>
								</tr>
								<tr>
								
								   
										<td>COUNTRY : </td>
										
										<td> <select name="country" id="country" onkeypress="nextField(event.keyCode,zipicode)">
											   <option value=''>------------------------------</option>
											
										       <?php for($i=0;$i<count($countries);$i++){ 
																						
													if($countries[$i][1] == $hospitalInfo[0][5]) { ?>
													
														<option value='<?php echo $countries[$i][1];?>' selected><?php echo $countries[$i][1];?></option>
										     <?php  }else {?>
										
														<option value='<?php echo $countries[$i][1];?>'><?php echo $countries[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select>
										</td>
									</tr>
										
									<tr>
										
										<td>ZIP CODE : </td>
										<td><input type="text" name="zipcode" id="zipcode" value='<?php echo ($hospitalInfo[0][6] == 0 )?'':$hospitalInfo[0][6] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,phone_no)"/></td>
									</tr>	

							</table>
								
						</div>
					</div>
				</div>
					  <div class="col-md-6">
						<div class="box box-info">
                
                           <div class="box-body">
							 
							 <table  class="table table-striped">	

							    <tr>
									    										
										<td>PHONE : </td>
										<td><input type="text" name="phone_no" id="phone_no" value='<?php echo ($hospitalInfo[0][7] == 0 )?'':$hospitalInfo[0][7] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,fax)"/></td>
								</tr>
								<tr>
										<td>FAX NO : </td>
										<td><input type="text" name="fax" id="fax" value='<?php echo ($hospitalInfo[0][8] == 0 )?'':$hospitalInfo[0][8] ?>' autocomplete="off" onkeypress="nextField(event.keyCode,email)"/></td>
								</tr>
								<tr>
										<td>EMAIL : </td>
										<td><input type="text" name="email" id="email" value='<?php echo $hospitalInfo[0][9];?>' autocomplete="off" onkeypress="nextField(event.keyCode,website)"/></td>
								</tr>
								<tr>
										
										<td>WEBSITE : </td>
										<td><input type="text" name="website" id="website" value='<?php echo $hospitalInfo[0][10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,logo)"/></td>
								</tr>
								<tr>	
										<td>LOGO : </td>
										<td><input type="text" name="logo" id="logo" value='<?php echo $hospitalInfo[0][11];?>' autocomplete="off" onkeypress="nextField(event.keyCode,currency)"/></td>
								</tr>
								<tr>	
										<td>CURRENCY <span id='requiredfield'>*</span> : </td>
										<td><input type="text" name="currency" id="currency" value='<?php echo $hospitalInfo[0][12];?>' autocomplete="off" onkeypress="nextField(event.keyCode,Update)"/></td>
									
									
								</tr>
								<tr>
								     <td colspan='2' align="center"><input id="button1" class="btn btn-success" type="button" name="Update" value="Update" onclick="return submitForm()"/></td>
								</tr>
							</table>
						</div>
									
						
				</div>
		</div>
	</div>
	</section>
	</div>
  </form>  
       
<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">
 
     function submitForm(){
   
   		
   		if(document.hospital_info.hospital_name.value=='') {
   			showDialog('Error','Please Enter Hospital Name.','error',2);
			return false;
			
		}else if(document.hospital_info.currency.value=='') {
		
   			showDialog('Error','Please Enter Currency.','error',2);
			return false;
			
		}else if((!validateEmail(document.hospital_info.email.value))){
				showDialog('Error','Please Enter A Valid Email.','error',2);
				return false;
		}else {

		    showDialog('Message','UPDATING HOSPITAL INFO','',2); 

			setTimeout(function(){

				document.hospital_info.action="<?php echo base_url(); ?>index.php/admin/hospital_info/update";
			    document.hospital_info.submit();
				
            }, 2000);
          	
		}
	}
</script>