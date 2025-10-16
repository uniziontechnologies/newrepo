<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
 <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>


 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
 <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
<script type="text/javascript">


$(document).ready(function(){

	$("#message_box").fadeTo(2000, 500).slideUp(500, function(){
             $("#success-alert").slideUp(500);
          });
 
       $(".search").bind('click', function() {

       	// alert(11111111);
       					$("#paction").val('SEARCH');

                    $("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule");
		            $("#manage_ot_schedule_form").submit();
       });


       $(".clear").bind('click', function() {

       	window.location.href="../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule";
       	return false;

       	
       });

     //   $(".edit").bind('click', function(){
     //   	$("#paction").val('EDIT_PAGE');
     //   	var id=$(this).attr("idval");
     //   	alert(id);
     //   	$("#id").val(id);
     //   	$("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule_info");
		   // $("#manage_ot_schedule_form").submit();


     //   });
       // $(".delete").bind('click', function(){
       	$("#patient-table").on("click", ".delete", function(){

	       	var id=$(this).attr("idval");
	       	 // alert(id);
	       	$("#id").val(id);

	       	var a=confirm("Do You Really Want to Delete This Schedule?");

	       	if(a==true)
   			{
					var details=prompt("Please Enter Cancellation Details:","");
					
					if(details!= null){
						document.manage_ot_schedule_form.cancellation_details.value=details;

						$("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_ot_schedule_info");
		       		$("#manage_ot_schedule_form").submit();
						
					}else{
					return false;
					}

					
						

				}else{
					return false;
				}

	       	


       });




     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule");
                 $("#manage_ot_schedule_form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule");
                 $("#manage_ot_schedule_form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#paction").val('SEARCH');
                  $("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule");
                 $("#manage_ot_schedule_form").submit();
              });
  });  

function submitForm(id){

	$("#paction").val('EDIT_PAGE');
       
       	// alert(id);
       	$("#id").val(id);
       	$("#manage_ot_schedule_form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=manage_ot_schedule_info");
		   $("#manage_ot_schedule_form").submit();


}
 
 	


	

</script>

</head>
<body id="frame">
<form name="manage_ot_schedule_form" id="manage_ot_schedule_form"  method="post" action=""> 
<?php
date_default_timezone_set('Asia/Kolkata');
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctorInfo=$this->popArr['doctorInfo'];

	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];
	$perPage=$this->popArr['perPage'];
	// var_dump($doctorInfo);
	

        
?>
<section class="content-header">
          <h4> <?php echo $lang_search; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="date_cal" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
											
										</td>

										<td id="noborder">
										<?php echo $lang_type; ?></td>
									<td id="noborder" >	
										<select name="type" id="type">
											<option value ="">----------</option>
											
											<option value ="OP" <?php echo (isset($post['type']) && $post['type']=='OP')?'selected':'';?>>OP</option>
											<option value ="DIRECT" <?php echo (isset($post['type']) && $post['type']=='DIRECT')?'selected':'';?>>DIRECT</option>
	                               <option value ="IP" <?php echo (isset($post['type']) && $post['type']=='IP')?'selected':'';?>>IP</option>
										</select>
									</td>

                          <td id="noborder">
									<?php echo $lang_ref_no; ?> </td>
									<td id="noborder" >
										<input type="text" name="ref_no" id="ref_no" value="<?php echo (!empty($post['ref_no']))?$post['ref_no']:''?>" />
									</td>  

									<td id="noborder">							
								
								<?php echo $lang_surgery_status; ?>  : 
							</td>
							<td id="noborder">
								
								 <select name="surgery_status" id="surgery_status" >
								 	<option value ="">----------</option>
								 	<option value="1" <?php if ($post['surgery_status'] == 1) { echo ' selected="selected"'; } ?>>Success</option>
								 	<option value="2" <?php if ($post['surgery_status'] == 2) { echo ' selected="selected"'; } ?>>Failed</option>
								 </select> 
								 
							</td>    
										
								</tr>
								<tr>
								
								
							
								
								</tr>
								<tr>		
									<td id="noborder" colspan="10" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success btn-sm search"  value="Search" />
									<input id="button1" type="button" name="Clear" class="clear btn btn-danger btn-sm" value="Clear" />
									</td>

									<!-- <td colspan=""></td> -->
								</tr>
						</table>
				
					</div>
			</div>
				<h3>
						<?php echo $lang_ot_patients_list; ?>
					
					</h3>
					<!-- <?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?> -->



								<!---- show flash messages--->
			     <?php
			          $message_type = '';
                      $search_message = $this->popArr['message'];
					   
					 if(!empty($search_message)){
				?>
					<div class="alert alert-info alert-dismissable ml-2 mr-2" id="message_box">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $search_message;?>
                  </div>
					 <?php } ?>	





			<div class="box box-info">
				 <?php echo $pagination;?>
                
               <div class="box-body">
			        <table class="table table-bordered table-striped" id="patient-table">
       			
				<thead>
					<tr>
                  <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                  <th><a href="#"><?php echo $lang_ref_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_name; ?></a></th>
						<th ><a href="#"><?php echo $lang_age; ?></a></th>
						<th><a href="#"><?php echo $lang_contact_no; ?></a></th>
						
						<th ><a href="#"><?php echo $lang_surgery_name; ?></a></th>
						<th ><a href="#"><?php echo $lang_surgery_details; ?></a></th>
						<th><a href="#"><?php echo $lang_surgery_started; ?></a></th>
						<th><a href="#"><?php echo $lang_surgery_ended; ?></a></th>
						<th><a href="#"><?php echo $lang_status; ?></a></th>
						<th><a href="#"><?php echo $lang_doctors; ?></a></th>
						<th><a href="#"><?php echo $lang_remarks; ?></a></th>
						<th><a href="#"><?php echo $lang_action; ?></a></th>

						

						                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=($current_page -1)*$perPage+1;
				for($i=0;$i<count($patientInfo);$i++) {
					// var_dump($doctorInfo[$i]);

					?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][17];?></td>
						<td><?php echo $patientInfo[$i][3]." ".$patientInfo[$i][4]." ".$patientInfo[$i][5];?></td>
						<td><?php echo	$patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][7];?></td>
						<td><?php echo $patientInfo[$i][1];?></td>
						<td><?php echo $patientInfo[$i][2];?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($patientInfo[$i][10]));?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($patientInfo[$i][11]));?></td>
						<td><?php 
						if( $patientInfo[$i][12] ==1){
							echo "success";
						}else if($patientInfo[$i][12] ==2){
							echo "failed";
						}
						?>
							
						</td>
						<td>
						
							<?php if(!empty($doctorInfo[$i])){


								for($k=0;$k<count($doctorInfo[$i]);$k++){?>

							
							<?php echo $doctorInfo[$i][$k][3]."<br><br>";?>

					

								<?php }
							}?>
								</td>

						<td><?php echo $patientInfo[$i][13];?></td>
						<td>
							
							<div class="btn-group">
                                
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">

                               	<li><a href="#" class="edit"  onClick="submitForm('<?php echo $patientInfo[$i][0];?>');">Edit</a></li>

                               <?php
                                 	

                                  if ( $_SESSION["user_type"]=="ADMIN"||$_SESSION["user_type"]=="ADMIN+DOCTOR")  {?>

                               	<li><a href="#" class="delete" idval="<?php echo $patientInfo[$i][0];?>">Delete</a></li>
                               <?php }?>

                             

                               </ul>
                            </div>
						</td>
						
						
                           
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	 <input type="hidden" name="paction" id="paction" />
	 <input type="hidden" name="id" id="id" />
<input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
<input type="hidden" name="cancellation_details" id="cancellation_details" />

	
  
</form>
</body>
</html>
