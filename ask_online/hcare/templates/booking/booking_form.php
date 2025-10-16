
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   <script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script>
  
   function submitForm(){

        // check box validate 
   	    var restok_checked=false;
        var k=0;
    
        var elements = document.getElementsByName("tokens[]");
     
        for(var i=0; i < elements.length; i++){

          if(elements[i].checked) {

            restok_checked = true;
          
            k++;
          }

        }

        var avltok_checked=false;
        med_list =new Array();
        var k=0;
    
        var elements = document.getElementsByName("avl_tokens[]");
     
        for(var i=0; i < elements.length; i++){

          if(elements[i].checked) {

            avltok_checked = true;
          
            k++;
          }

        }

   
   		if(document.booking_form.patient_name.value =='' ){
				showDialog('Error','Please Enter Patient Name.','error',2);
				return false;
		}else if(document.booking_form.phone.value =='' ){
				showDialog('Error','Please Enter Mobile Number.','error',2);
				return false;
		}else {	

				if(validateToken()==false){
				
   				 	
				}else if(AvailableTokenValidate()==false){
				
   					
				}else if(validateToken()==true && AvailableTokenValidate()==true){
				 
				  showDialog('Error','Please Select One Reserved Token Or One Available Token!','error',3);
			      return false;
   					
				}else if(restok_checked==false && avltok_checked==false){
				 
				  showDialog('Error','Please Select Atleast One Token!','error',3);
			      return false;
   					
				}else{ 


				  document.booking_form.Book.disabled = true;

                   document.booking_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Booking_Form";
				   document.booking_form.submit();	
				   return true;

				}
		}
   
   }
   
   function validateToken(){
   
   		checktrue=0;
		var elements = document.getElementsByName("tokens[]");
		
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox' && elements[i].checked == true) {
					checktrue++;
				}
			}	
		
		if(checktrue >1){
		
			showDialog('Error','Please Select One Reserved Token!','error',2);
			return false;
		}else if(checktrue !=""){

			return true;

		}
		
   		
   }

   function AvailableTokenValidate(){

   	    checktrue=0;
		var elements = document.getElementsByName("avl_tokens[]");
		
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox' && elements[i].checked == true) {
					checktrue++;
				}
			}	

		if(checktrue >1){
		
			showDialog('Error','Please Select One Available Token!','error',2);
			return false;
		}else if(checktrue !=""){

			return true;

		}

        
   }

    function transfer_booking(){

  //       document.booking_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=transfer_booking";
		// document.booking_form.submit();	

    // check box validate 
   	    var restok_checked=false;
        var k=0;
    
        var elements = document.getElementsByName("tokens[]");
     
        for(var i=0; i < elements.length; i++){

          if(elements[i].checked) {

            restok_checked = true;
          
            k++;
          }

        }

        var avltok_checked=false;
        med_list =new Array();
        var k=0;
    
        var elements = document.getElementsByName("avl_tokens[]");
     
        for(var i=0; i < elements.length; i++){

          if(elements[i].checked) {

            avltok_checked = true;
          
            k++;
          }

        }

   
   		if(document.booking_form.patient_name.value =='' ){
				showDialog('Error','Please Enter Patient Name.','error',2);
				return false;
		}else if(document.booking_form.phone.value =='' ){
				showDialog('Error','Please Enter Mobile Number.','error',2);
				return false;
		}else {	

				if(validateToken()==false){
				
   				 	
				}else if(AvailableTokenValidate()==false){
				
   					
				}else if(validateToken()==true && AvailableTokenValidate()==true){
				 
				  showDialog('Error','Please Select One Reserved Token Or One Available Token!','error',3);
			      return false;
   					
				}else if(restok_checked==false && avltok_checked==false){
				 
				  showDialog('Error','Please Select Atleast One Token!','error',3);
			      return false;
   					
				}else{ 


				  document.booking_form.transfer.disabled = true;

		        document.booking_form.action="../../lib/controllers/centralController.php?module=Booking&sub_module=transfer_booking";
				document.booking_form.submit();	
				   return true;

				}
		}
		

    }
   
	
</script>
<style type="text/css">
	.token-no{

        color: #3c8dbc;
        font-size: 15px;
        font-weight: bold;

	}
	.time-display{

        color: #f3895f;
        font-size: 15px;
        font-weight: bold;

	}
</style>
</head>
<body id="frame" >
 <div  id="content">
<form name="booking_form" id="form" method="post" action=""> 
<?php
	$arrList=$this  ->popArr['arrList'];
	$reserved_tokens=$this  ->popArr['reserved_tokens'];
	$doc_cons_time=$this  ->popArr['doc_cons_time'];
	$booking_list=$this  ->popArr['booking_list'];
	$booked_tokens=$this  ->popArr['booked_tokens'];
	$post=$this  ->popArr['post'];

$booking_token_list=array();

if(!empty($booking_list)){

	for ($i=0; $i < count($booking_list) ; $i++) { 
		
		 $booking_token_list[]=$booking_list[$i][1];

	}
}

?>
<section class="content-header">
          <h1>
            <?php echo  $lang_booking;?>
           
          </h1>
         
        </section>
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		 <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
							<tr>
								<td id="noborder">
									<?php echo $lang_doctor; ?>:
								
									
									<?php echo $arrList[1]; ?>
								</td>
								<td id="noborder">
									<?php echo $lang_cons_time; ?>:
								
									
									<?php echo $arrList[2]; ?>
								</td>
								
							
								<td id="noborder">
									<?php echo $lang_date; ?>:
								
									
									<?php echo $arrList[3]; ?>
								</td>
								<td id="noborder">
									<?php echo $lang_doc_fees; ?>:
								
									
									<?php echo $arrList[4]; ?>
								</td>
								<td id="noborder">
									<?php echo $lang_reg_fee; ?>:
									<?php echo $arrList[5]; ?>
								</td>
								
							</tr>
						</table>
					</div>
				</div>
					
		<div class="row">
           <div class="col-md-6">
			<div class="box box-info">
               <div class="box-body">
			     <table class="table table-bordered table-striped">
							<tr>
								<td id="noborder">
									<?php echo $lang_patient." ".$lang_name;?>:
								</td>
								<td id="noborder">
									<input type="text" name="patient_name" id="patient_name" value="<?php echo !empty($post['transfer_name'])?$post['transfer_name']:''; ?>" />
								</td>
								
							</tr>
							<tr>
								<td id="noborder">
									<?php echo $lang_place?>:
								</td>
								<td id="noborder">
									<input type="text" name="place" id="place" value="<?php echo !empty($post['transfer_place'])?$post['transfer_place']:''; ?>" />
								</td>
							</tr>
							<tr>
								<td id="noborder">
									<?php echo $lang_phone_no?>:
								</td>
								<td id="noborder">
									<input type="text" name="phone" id="phone" value="<?php echo !empty($post['transfer_phone'])?$post['transfer_phone']:''; ?>" />
								</td>
							</tr>
						
						<tr>
				           <td colspan="2" align="center">

				           	<?php if (!empty($post['transfer_id'])) {?>
				           		<input id="button2" type="button" name="transfer" value="Transfer" class="btn btn-info" onclick="return transfer_booking()"/>
				           	<?php
				           	}
				           	else{?>
				           		<input id="button1" type="button" name="Book" value="Book" class="btn btn-success" onclick="return submitForm()"/>
				           	<?php
				           	}
				           	 ?>

							  
							</td>
					
					
					 </table>
					</div>
				</div>
					<div class="box box-info">
					   <div class="box-header with-border">
                          <h3 class="box-title">Resrved Tokens</h3>
                      </div>	
                     <div class="box-body">
			<?php if(!empty($reserved_tokens)) { 
				// var_dump($reserved_tokens);
				?>
			          <table class="table table-bordered table-striped">
						
			   <?php
					  $consulting_time=$arrList[2];
					  if(!empty($consulting_time)) { 
                        
                    // split consulting time
					    $split_consulting_time=explode("/", $consulting_time);

					    $morning_consulting_time=$split_consulting_time[0];
					    $afternoon_consulting_time=$split_consulting_time[1];

					// split morning consulting time
					    if(!empty($morning_consulting_time)) {

					        $split_morning_consulting_time=explode("-", $morning_consulting_time);

					        $morning_start_time=$split_morning_consulting_time[0];
					        $morning_end_time=$split_morning_consulting_time[1];
					    }

					// split afternoon consulting time
					    if(!empty($afternoon_consulting_time)) {

					        $split_afternoon_consulting_time=explode("-", $afternoon_consulting_time);

					        $afternoon_start_time=$split_afternoon_consulting_time[0];
					        $afternoon_end_time=$split_afternoon_consulting_time[1];
                        }
                      }

					    $token_no=1;
					    $res_tok_pos=0;

					      //  morning consulting tokens
					    if(!empty($morning_consulting_time)){

                            $start_time = date("H:i", strtotime($morning_start_time));
					    	$end_time = date("H:i", strtotime($morning_end_time));

					    	$start_time = strtotime($start_time);

					    	$end_time = strtotime($end_time);

					    	$time_increment = 60*$doc_cons_time;
                        
                           for ($i=$start_time; $i<$end_time; $i+=$time_increment) { 

                              if (in_array($token_no, $reserved_tokens)){ 
                               
			   ?>
									<tr>
										<td>
												
											<input type="checkbox" name="tokens[]" onclick="validateToken();" value="<?php echo $reserved_tokens[$res_tok_pos]."/".date("h:i a",$i);?>"/>
											<a href="#"><b><?php echo $reserved_tokens[$res_tok_pos];?></b></a><br><span class="time-display"><?php echo date("h:i a",$i); ?></span>
										</td>
									</tr>
							
				<?php
				                $res_tok_pos++;
				              }
				              $token_no++;
				           }
				        }
				        if(!empty($afternoon_consulting_time)){

                            $start_time = date("H:i", strtotime($afternoon_start_time));
					    	$end_time = date("H:i", strtotime($afternoon_end_time));
                            $start_time = strtotime($start_time);

					    	$end_time = strtotime($end_time);

					    	$time_increment = 60*$doc_cons_time;
                        
                           for ($i=$start_time; $i<$end_time; $i+=$time_increment) { 

                           	  if (in_array($token_no, $reserved_tokens)){
                                    
                ?>
                                    <tr>
										<td>
												
											<input type="checkbox" name="tokens[]" onclick="validateToken();" value="<?php echo $reserved_tokens[$res_tok_pos]."/".date("h:i a",$i);?>"/>
											<a href="#"><b><?php echo $reserved_tokens[$res_tok_pos];?></b></a><br><span class="time-display"><?php echo date("h:i a",$i); ?></span>
										</td>
									</tr>     

                <?php
                                $res_tok_pos++;
                              }
                              $token_no++;
                           }
                        }
				?>
							</table>
	        <?php } ?>
						</div>
					</div>
			</div>
			
                   <div class="col-md-6">
					<div class="box box-info">
					   <div class="box-header with-border">
                          <h3 class="box-title">Available Tokens</h3>
                      </div>	
                     <div class="box-body">

					<?php 
                        $consulting_time=$arrList[2];
					    if(!empty($consulting_time)) { 
                        
                        $output='';
                    // split consulting time
					    $split_consulting_time=explode("/", $consulting_time);

					    $morning_consulting_time=$split_consulting_time[0];
					    $afternoon_consulting_time=$split_consulting_time[1];

					// split morning consulting time
					    if(!empty($morning_consulting_time)) {

					        $split_morning_consulting_time=explode("-", $morning_consulting_time);

					        $morning_start_time=$split_morning_consulting_time[0];
					        $morning_end_time=$split_morning_consulting_time[1];
					    }

					// split afternoon consulting time
					    if(!empty($afternoon_consulting_time)) {

					        $split_afternoon_consulting_time=explode("-", $afternoon_consulting_time);

					        $afternoon_start_time=$split_afternoon_consulting_time[0];
					        $afternoon_end_time=$split_afternoon_consulting_time[1];
                        }

					    $token_no=1;
                
                //  morning consulting tokens
					    if(!empty($morning_consulting_time)){

					    	$output .="<table width='100%' class='table table-striped'><tr>";

					    	$start_time = date("H:i", strtotime($morning_start_time));
					    	$end_time = date("H:i", strtotime($morning_end_time));

					    	$start_time = strtotime($start_time);

					    	$end_time = strtotime($end_time);

					    	$time_increment = 60*$doc_cons_time;
                        
                           for ($i=$start_time; $i<$end_time; $i+=$time_increment) { 

                              if (!in_array($token_no, $reserved_tokens) && !in_array($token_no, $booking_token_list) && !in_array($token_no, $booked_tokens) ){ 

                           	   $output .= "<td><span class='token-no'>".$token_no."</span>"." <input type='checkbox' name='avl_tokens[]' onclick='AvailableTokenValidate()' value='$token_no"."/".date("h:i a",$i)."'>"."<br><span class='time-display'>".date("h:i a",$i)."</span></td>";
                           	    }
                             
                           
                           	   if ($token_no % 5 == 0) {
                                    $output .="</tr><tr>";
                               }

                        	   $token_no++;
                           } 

                           $output .="</tr></table>";
                           
                        }

                //  afternoon consulting tokens
                        if(!empty($afternoon_consulting_time)){

                        	$output .="<br><br><table width='100%' class='table table-striped'><tr>";

					    	$start_time = date("H:i", strtotime($afternoon_start_time));
					    	$end_time = date("H:i", strtotime($afternoon_end_time));

					    	$start_time = strtotime($start_time);

					    	$end_time = strtotime($end_time);

					    	$time_increment = 60*$doc_cons_time;
                        
                           for ($i=$start_time; $i<$end_time; $i+=$time_increment) { 

                           	  if (!in_array($token_no, $reserved_tokens) && !in_array($token_no, $booking_token_list) && !in_array($token_no, $booked_tokens) ){

                           	   $output .= "<td><span class='token-no'>".$token_no."</span>"." <input type='checkbox' name='avl_tokens[]' onclick='AvailableTokenValidate()' value='$token_no"."/".date("h:i a",$i)."'>"."<br><span class='time-display'>".date("h:i a",$i)."</span></td>";
                           	  }

                           	   if ($token_no % 5 == 0) {
                                    $output .="</tr><tr>";
                               }

                        	   $token_no++;
                           } 

                           $output .="</tr></table>";
                           
                        }
                               echo $output;
					?>
         
						</table>
							
					<?php } ?>
						</div>
					</div>
					
				
				</div>
			
				
            </div>
           
      </div>
	</section>
	  <input name="action" id="action" type="hidden" value="<?php echo $lang_add;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $arrList[0];?>" />
	    <input name="booking_date" id="booking_date" type="hidden" value="<?php echo $arrList[3];?>" />

	  <input type="hidden" name="transfer_id" id="transfer_id" value="<?php echo !empty($post['transfer_id'])?$post['transfer_id']:''; ?>" />
	  <input type="hidden" name="transfer_name" id="transfer_name" value="<?php echo !empty($post['transfer_name'])?$post['transfer_name']:''; ?>" />
	  <input type="hidden" name="transfer_place" id="transfer_place" value="<?php echo !empty($post['transfer_place'])?$post['transfer_place']:''; ?>" />
	  <input type="hidden" name="transfer_phone" id="transfer_phone" value="<?php echo !empty($post['transfer_phone'])?$post['transfer_phone']:''; ?>" />

</form>	
</div> 
</body>
	</html>
	
