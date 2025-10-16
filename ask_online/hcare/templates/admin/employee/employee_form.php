<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
	<!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	 <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
   
 
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js"></script>
    
<script type="text/javascript">

$(document).ready(function(){
	
	$(".personl_info").bind('click', function() {
		
		 if($("#title").val() == ""){
			showDialog('Error','Please Select Title.','error',2);
			return false;
        }else if($("#first_name").val() == ""){
			showDialog('Error','Please Enter First Name.','error',2);
			return false;
        }else if(!validateEmail($("#email").val())){
			showDialog('Error','Please Enter A Valid Email.','error',2);
			return false;
        }else{
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Admin&sub_module=Employee&active_module=personal_info");
			 $("#form").submit();
		}
	});
	$(".job_info").bind('click', function() {
		
		 if($("#dep_id").val() == ""){
			showDialog('Error','Please Select Department.','error',2);
			return false;
        }else if($("#title").val() == "Dr" && $("#spec_id").val() == ""){
			showDialog('Error','Please Select Speciality.','error',2);
			return false;
        }else if($("#title").val() == "Dr" && $("#des_id").val() == ""){
			showDialog('Error','Please Select Designation.','error',2);
			return false;
        }else{
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Admin&sub_module=Employee&active_module=job_info");
			 $("#form").submit();
		}
	});
	
	 $(".doc_fee_info").bind('click', function() {
		
		 if($("#title").val() == "Dr" && !isDecimalNumber($("#op_validity").val())){
			showDialog('Error','Please Enter OP Sheet Validity.','error',2);
				return false;
        }else if($("#title").val() == "Dr" && !isDecimalNumber($("#consultation").val())){
			showDialog('Error','Please Enter a Valid Consultation.','error',2);
			return false;
        }
        // else if($("#title").val() == "Dr" && !isDecimalNumber($("#ip_visit").val())){
		// 	showDialog('Error','Please Enter a Valid IP Visit Fee.','error',2);
		// 	return false;
        // }else if($("#title").val() == "Dr" && !isDecimalNumber($("#surgery").val())){
		// 	showDialog('Error','Please Enter a Valid Surgery Fee.','error',2);
		// 	return false;
        // }else if($("#title").val() == "Dr" && !isDecimalNumber($("#emergency").val())){
		// 	showDialog('Error','Please Enter a Valid Emergency Visit Fee.','error',2);
		// 	return false;
        // }
        else if($("#title").val() == "Dr" && $("#op_validity").val() == ""){
			showDialog('Error','Please Enter Op Validity Days.','error',2);
			return false;
        }else{
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Admin&sub_module=Employee&active_module=doc_fee_info");
			 $("#form").submit();
		}
	});
	
	$(".user_info").bind('click', function() {
		
		if($("#username").val() == ""){
			showDialog('Error','Please Enter User Name.','error',2);
			return false;
        }else if($("#userid").val() == "" && $("#password").val() == ""){
			showDialog('Error','Please Enter Password.','error',2);
			return false;
        }else if($("#password").val() != "" && ($("#password").val() != $("#re_pass").val())){
			showDialog('Error','Password Mismatching.','error',2);
			return false;
        }else if($("#user_type").val() == ""){
			showDialog('Error','Please Select User Type.','error',2);
			return false;
        }else if(($("#user_type").val() == 8 || $("#user_type").val() == 9) && $("#branch").val() == ""){
			showDialog('Error','Please Select Pharma Branch.','error',2);
			return false;
        }else{
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Admin&sub_module=Employee&active_module=user_info");
			 $("#form").submit();
		}
		
	});
});
</script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<script>
var $j = jQuery.noConflict();
$j(document).ready(function(){
$j( "#dep_id" ).change(function() {
	
     
	 
	  if( $( "#dep_id" ).val() !=''){  
		  data='dep_id='+$( "#dep_id" ).val();

		  inline_action="../../lib/controllers/centralController.php?module=Admin&sub_module=show_dep_speciality";
		  
		  $j.post(inline_action,data,function (response) {

			
			       specInfo=response['SpecialityInfo'];
			       $('#spec_id').empty();
				
				   $('#spec_id').append( '<option value="">'+'---------------------------</option>' );
				 
			  if(specInfo!=''){
				 
				  for(i=0;i<specInfo.length;i++){
					 
					   $('#spec_id').append( '<option value="'+specInfo[i][0]+'">'+specInfo[i][3]+'</option>' );
				  }
				  
			  }
			  
		   },"json");
		  
	  }else {
		  $('#spec_id').empty();
		   $('#spec_id').append( '<option value="">'+'---------------------------</option>' );
	  }
  }); 
   $j( "#user_type" ).change(function() {
	
     var user_type=$( "#user_type" ).val();
	 
	  if(user_type == 8 || user_type==9){  
		  data='';
		  inline_action="../../lib/controllers/centralController.php?module=Admin&sub_module=show_pharma_branch";
		  
		  $j.post(inline_action,data,function (response) {
			
			  pharma_branch=response['pharma_branch'];
			       $('#branch').empty();
				
				   $('#branch').append( '<option value="">'+'---------------------------</option>' );
				   $('#branch').append( '<option value="main_branch">'+'Main Branch</option>' );
			  if(pharma_branch!=''){
				 
				  for(i=0;i<pharma_branch.length;i++){
					 
					   $('#branch').append( '<option value="'+pharma_branch[i][0]+'">'+pharma_branch[i][1]+'</option>' );
				  }
				  
			  }
			  
		   },"json");
		  
	  }else {
		  $('#branch').empty();
		   $('#branch').append( '<option value="">'+'---------------------------</option>' );
	  }
  });  
});  
</script>


</head>
<body id="frame" onload="document.department.title.focus();">
 <div  id="content">
<form name="employee" id="form" method="post" action=""> 
<?php
	

		$action = $this->popArr['action'];
		$post=$this->popArr['post'];
		
		$SpecialityInfo		=	$this->popArr['SpecialityInfo'];
		$departmentInfo 	= $this->popArr['department'];
		$designatioInfo		=	$this ->popArr['DesignationInfo'];
	if($action ==$lang_update) {
	
		$SpecialityInfo		=	$this->popArr['SpecialityInfo'];

		// var_dump($SpecialityInfo);
		
		
		
	}
	if(isset($this->popArr['userInfo'])){
	
		$userInfo=$this->popArr['userInfo'];
		$userid=$userInfo[0][0];
		$user_name=$userInfo[0][3];
		$user_type=$userInfo[0][5];
		$user_type_id=$userInfo[0][6];
		$usertype_info=$this->popArr['user_type'];
	}else{
	
		$userid='';
		$user_name='';
		$user_type='';
		$user_type_id='';
	}
	if(isset($this->popArr['EmployeeInfo'])){
		
		$employeeInfo		=	$this  ->popArr['EmployeeInfo'];
		$id=$employeeInfo[0][0];
		$title=$employeeInfo[0][1];
		$first_name=$employeeInfo[0][2];
		$last_name=$employeeInfo[0][3];
		$contact_details=$employeeInfo[0][4];
		$contact_no=$employeeInfo[0][5];
		$email=$employeeInfo[0][6];
		$dep_id=$employeeInfo[0][10];
		$spec_id=$employeeInfo[0][12];
		$des_id=$employeeInfo[0][14];
		$ssn=$employeeInfo[0][15];
		$qualification=$employeeInfo[0][16];
		$joing_date=$employeeInfo[0][17];
		
		
		if($title == "Dr"){
		
			$consultation=$employeeInfo[0][19];
			$ip_visit=$employeeInfo[0][20];
			$surgery=$employeeInfo[0][21];
			$emergency=$employeeInfo[0][22];
			$op_validity=$employeeInfo[0][23];
			$ip_billing_dr=$employeeInfo[0][24];
			$ip_billing=$employeeInfo[0][25];
		}	
			
	}else{
		$employeeInfo=null;	
		$id='';
		$title='Dr';
		$first_name='';
		$last_name='';
		$contact_details='';
		$contact_no='';
		$email='';
		$op_validity=0;
		
		if(!empty($this->popArr['dep_id'])){
			$dep_id=$this->popArr['dep_id'];
		}else{
			$dep_id='';
		}
		$spec_id='';
		$des_id='';
		$ssn='';
		$qualification='';
		$joing_date='';	
		$consultation='';
		$ip_visit='';
		$surgery='';
		$emergency='';
		
	}

?>
<section class="content-header">
        <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
		<?php } ?>
            <div class="row">
            <div class="col-md-12">
              <!-- Custom Tabs -->
               <div class="nav-tabs-custom bg-gray">
                <ul class="nav nav-tabs">
                  <li class="<?php echo (!empty($post['active_module']) && $post['active_module']=='personal_info')?'active':'';?>"><a href="#tab_1" data-toggle="tab"><?php echo $lang_personal." ".$lang_information;?></a></li>
				  
		<?php
				if($action == "UPDATE") { ?> 
                  <li class="<?php echo (!empty($post['active_module']) && $post['active_module']=='job_info')?'active':'';?>"><a href="#tab_2" data-toggle="tab"><?php echo $lang_job." ".$lang_information;?></a></li>
                  <?php if($title =="Dr") { ?>
				  <li class="<?php echo (!empty($post['active_module']) && $post['active_module']=='doc_fee_info')?'active':'';?>"><a href="#tab_3" data-toggle="tab"><?php echo $lang_doc_fees." ".$lang_information;?></a></li>
				  <?php } ?>
				  <li class="<?php echo (!empty($post['active_module']) && $post['active_module']=='user_info')?'active':'';?>"><a href="#tab_4" data-toggle="tab"><?php echo $lang_user." ".$lang_information;?></a></li>
		<?php } ?>
                </ul>
                <div class="tab-content">
				
                <div class="tab-pane <?php echo empty($post['active_module'])?'active':'' ?><?php echo ($post['active_module']=='personal_info')?'active':'' ?>" id="tab_1">
                    	 <div class="box box-info">
                <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_personal." ".$lang_information;?></h3>
                    </div>		
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
					<tr>
					<td id="noborder">
								
								<?php echo $lang_emp_title; ?> <span id='requiredfield'>*</span> : 
					</td>
					<td id="noborder">
								
								 <select name="title" id="title"   onkeypress="nextField(event.keyCode,first_name)" >
								 	<option value=''>-------------------------------</option>
									<option value ="Dr" <?php echo ( $title=="Dr")?'selected':''; ?>>Dr</option>
									<option value ="Mr" <?php echo ($title=="Mr")?'selected':''; ?>>Mr</option>
									<option value ="Mrs" <?php echo ( $title=="Mrs")?'selected':''; ?>>Mrs</option>
									<option value ="Miss" <?php echo ($title=="Miss")?'selected':''; ?>>Miss</option>
								</select>
								 
								
					</td>
					<td id="noborder">
								
								<?php echo $lang_first_name; ?> <span id='requiredfield'>*</span> : 
					</td>
					<td id="noborder">
								
								 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,last_name)" value="<?php echo $first_name; ?>" autocomplete="off"/> 
								 
				</td>
				<td id="noborder">
								 
								
								
								<?php echo $lang_last_name; ?> <span id='requiredfield'>*</span> : 
				</td>
				<td id="noborder">
								
								 <input name="last_name" id="last_name" tabbindex="2"  onkeypress="nextField(event.keyCode,contact_details)" value="<?php echo $last_name; ?>" autocomplete="off"/> 
								 
				</td>
				
		</tr>
		<tr>
			<td id="noborder">
								 
								
								
								<?php echo $lang_contact_details; ?> : 
				</td>
				<td id="noborder">
								
								 <textarea name="contact_details" id="contact_details"   onkeypress="nextField(event.keyCode,contact_no)" cols="15" rows="1"><?php echo $contact_details; ?></textarea> 
								 
			</td>
				<td id="noborder">
								 
								
								
								<?php echo $lang_contact_no; ?>  : 
				</td>
				<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2"  onkeypress="nextField(event.keyCode,email)" value="<?php echo ($contact_no==0)?'':$contact_no; ?>" autocomplete="off"/> 
								 
				</td>
				<td id="noborder">
								 
								 
								
								<?php echo $lang_email; ?> :
				</td>
				<td id="noborder">
								
								 <input name="email" id="email" tabbindex="2"  onkeypress="nextField(event.keyCode,dep_id)" value="<?php echo $email; ?>" type="text" autocomplete="off"/> 
								 
					</td>
				</tr>
				<td colspan="6" align="center">
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="personl_info btn btn-success"  value="Add Employee" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="personl_info btn btn-success"  value="Update Employee" onclick="return submitForm()"/>
					<?php } ?>
					 </td>
				</table >
			</div>
		</div>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane <?php echo ($post['active_module']=='job_info')?'active':'' ?>" id="tab_2">
                   	 <div class="box box-info">
                <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_job." ".$lang_information;?></h3>
                    </div>		
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					
					<tr>
					<td id="noborder">
						
							<?php echo $lang_department; ?> <span id='requiredfield'>*</span> : 
					</td>
				<td id="noborder">
                        		<select name="dep_id" id="dep_id"  nkeypress="nextField(event.keyCode,spec_id)"  />
						  
						  				<option value=''>------------------------</option>
						<?php
								if(!empty($departmentInfo)){
								
									for($i=0;$i<count($departmentInfo);$i++){ 
										
										if(($dep_id==$departmentInfo[$i][0])){	
							?>
											<option value='<?php echo $departmentInfo[$i][0];?>' selected><?php echo $departmentInfo[$i][1];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $departmentInfo[$i][0];?>' ><?php echo $departmentInfo[$i][1];?></option>
						<?php			}
									}
								}
						?>							
						
						</select>
				</td>
				<td id="noborder">
						
                       		
					<?php echo $lang_speciality; ?> <span id='requiredfield'>*</span> : 
			</td>
				<td id="noborder">
                        		<select name="spec_id" id="spec_id"  nkeypress="nextField(event.keyCode,des_id)" />
						  
						  				<option value=''>------------------------</option>
						<?php
								if(!empty($SpecialityInfo)){

								
									for($i=0;$i<count($SpecialityInfo);$i++){ 
										
										if($spec_id== $SpecialityInfo[$i][0]){	
							?>
											<option value='<?php echo $SpecialityInfo[$i][0];?>' selected><?php echo $SpecialityInfo[$i][3];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $SpecialityInfo[$i][0];?>' ><?php echo $SpecialityInfo[$i][3];?></option>
						<?php			}
									}
								}
						?>							
						
						</select>
						
               </td>
				<td id="noborder">	
					
					<?php echo $lang_designation; ?> <span id='requiredfield'>*</span> : 
			</td>
				<td id="noborder">
                        		<select name="des_id" id="des_id"  nkeypress="nextField(event.keyCode,ssn)" />
						  
						  				<option value=''>------------------------</option>
						<?php
								if(!empty($designatioInfo)){
								
									for($i=0;$i<count($designatioInfo);$i++){ 
										
										if($des_id == $designatioInfo[$i][0]){	
							?>
											<option value='<?php echo $designatioInfo[$i][0];?>' selected><?php echo $designatioInfo[$i][1];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $designatioInfo[$i][0];?>' ><?php echo $designatioInfo[$i][1];?></option>
						<?php			}
									}
								}
						?>							
						
						</select>
						
                  </td>
				</tr>
		<tr>
				  
				<td id="noborder">
						<?php echo $lang_ssn; ?> :
				</td>
		
		
				<td id="noborder">
								
								 <input name="ssn" id="ssn" tabbindex="2"  onkeypress="nextField(event.keyCode,qualification)" value="<?php echo ($ssn ==0 )?'':$ssn; ?>" autocomplete="off"/> 
				</td>
				<td id="noborder">
								 
								
						<?php echo $lang_qualification; ?> : 
				</td>
				<td id="noborder">
								
								 <input name="qualification" id="qualification" tabbindex="2"  onkeypress="nextField(event.keyCode,joing_date)" value="<?php echo $qualification; ?>" autocomplete="off"/> 
								 
				</td>
				<td id="noborder">
								 
						<?php echo $lang_joing_date; ?> : 
				</td>
				<td id="noborder">
								
						<?php if($title == "Dr"){?>
						
									 <input name="joing_date" id="joing_date" tabbindex="2"  onkeypress="nextField(event.keyCode,consultation)" value="<?php echo ($joing_date=='0000-00-00')?'': $joing_date; ?>" autocomplete="off"/> 
						
				<?php		}else{ ?>
						
								 <input name="joing_date" id="joing_date" tabbindex="2"  onkeypress="nextField(event.keyCode,op_validity)" value="<?php echo ($joing_date=='0000-00-00')?'': $joing_date; ?>" autocomplete="off"/> 
						
						<?php } ?>
								 
			</td>
			</tr>
			<tr>
			<td colspan="6" align="center">
					
							<input id="button1" type="button" name="Update" class=" job_info btn btn-success"  value="Update Job Info" onclick="return submitForm()"/>
					
					 </td>
				
		</tr>
	</table>
		</div>
</div>	
                  </div><!-- /.tab-pane -->
	<?php if($title =="Dr") { ?>
                  <div class="tab-pane <?php echo ($post['active_module']=='doc_fee_info')?'active':'' ?>" id="tab_3">
                     <div class="box box-info">
                <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_doc_fees." ".$lang_information;?></h3>
                    </div>		
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					
				
					<tr>
					<td id="noborder">
								
								<?php echo $lang_consultation.' CHARGE'; ?> <span id='requiredfield'>*</span> : 
				</td>
				<td id="noborder">
								
								 <input name="consultation" id="consultation" tabbindex="2"  size="8" onkeypress="nextField(event.keyCode,ip_visit)" value="<?php echo $consultation; ?>" autocomplete="off"/> 
								 
				</td>
				<!-- <td id="noborder">
								 
								
								
								<?php //echo $lang_ip_visit; ?>  : 
				</td>
				<td id="noborder">
								
								 <input name="ip_visit" id="ip_visit" tabbindex="2" size="8" onkeypress="nextField(event.keyCode,surgery)" value="<?php //echo $ip_visit; ?>" autocomplete="off"/> 
								 
				</td> -->
				<!-- <td id="noborder">
								 
								
								
								<?php //echo $lang_surgery; ?> : 
				</td>
				<td id="noborder">
								
								 <input name="surgery" id="surgery" tabbindex="2"size="8"  onkeypress="nextField(event.keyCode,emergency)" value="<?php //echo $surgery; ?>" autocomplete="off"/>
								 
				</td> -->
				<!-- <td id="noborder">
								 
								
								
								<?php //echo $lang_emergency; ?>  : 
				</td>
				<td id="noborder">
								
							
							
								 <input name="emergency" id="emergency" tabbindex="2" size="8" onkeypress="nextField(event.keyCode,op_validity)" value="<?php //echo $emergency;?>" autocomplete="off"/> 
							
							
								 
					</td> -->
					<td id="noborder">
								 
						<?php echo $lang_op_validity_days; ?> <span id='requiredfield'>*</span>
				</td>
					<td id="noborder">
				               <input name="op_validity" id="op_validity" tabbindex="2"  size="8" onkeypress="nextField(event.keyCode,ip_billing_dr)" value="<?php echo $op_validity ?>" autocomplete="off"/> 
				</td>
				</tr>
				<tr>
				
				<!-- <td id="noborder">
								
								<?php echo $lang_ip_billing_dr; ?> <span id='requiredfield'>*</span> : 
				</td>
				<td id="noborder">
								
								 <input name="ip_billing_dr" id="ip_billing_dr" tabbindex="2"  size="8" onkeypress="nextField(event.keyCode,lang_ip_billing)" value="<?php echo $ip_billing_dr; ?>" autocomplete="off"/> 
								 
				</td> -->
				<!-- <td id="noborder">
								 
								
								
								<?php echo $lang_ip_billing; ?>  : 
				</td> -->
				<!-- <td id="noborder">
				<?php //if($action== $lang_add){?>
								
								 <input name="ip_billing" id="ip_billing" tabbindex="2" size="8" onkeypress="nextField(event.keyCode,Add)" value="<?php //echo $ip_billing; ?>" autocomplete="off"/> 
					<?php //}else{ ?>		

                                             <input name="ip_billing" id="ip_billing" tabbindex="2" size="8" onkeypress="nextField(event.keyCode,Update)" value="<?php //echo $ip_billing; ?>" autocomplete="off"/> 
                                        <?php //} ?>					     
				</td> -->
				<td colspan="6" align="center">
					
							<input id="button1" type="button" name="Update" class="doc_fee_info btn btn-success"  value="Update Doc Fee" />
					
					 </td>
				</tr>
				</table>								 
					</div>
				</div>
                  </div><!-- /.tab-pane -->
	<?php } ?>
				   <div class="tab-pane <?php echo ($post['active_module']=='user_info')?'active':'' ?>" id="tab_4">
				   			<div class="box box-info">
                       <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_user." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
				 	
						<tr>
						      <td><?php echo $lang_username; ?> : </td>
                              <td> <input name="username" id="username"  
                                     tabindex="2"  onkeypress="nextField(event.keyCode,password)" value="<?php echo $user_name; ?>" autocomplete="off"/>
                       	     </td>
                        </tr>
                        <tr>						
						
						  <td><?php echo $lang_new." ".$lang_password; ?> : </td>
                          <td> <input name="password" id="password" type="password" 
                                   tabindex="2" onkeypress="nextField(event.keyCode,re_pass)" value="" autocomplete="off"/>
                          </td>
					   </tr>
					   <tr>
					   <td>
                        <?php echo $lang_re.$lang_type.' '.$lang_password; ?> : </td>
                        
						<td> <input name="re_pass" id="re_pass" type="password" 
                                    tabindex="2" onkeypress="nextField(event.keyCode,user_type)" value="" autocomplete="off"/>
                       </td>
					   
				</tr>
				
				<tr>
				
					    <td>
						 <?php echo $lang_user." ".$lang_type;?>: </td>
						 <td><select name="user_type" id="user_type" onkeypress="nextField(event.keyCode,button1)">
						 		<option value=''>----------------------------</option>
						<?php 		if(!empty($usertype_info)){
										for($j=0;$j<count($usertype_info);$j++){											
											if($usertype_info[$j][0] == $user_type_id){
						?>						<option value='<?php echo $usertype_info[$j][0];?>' selected><?php echo $usertype_info[$j][1];?></option>
						<?php				}else {?>
												<option value='<?php echo $usertype_info[$j][0];?>'><?php echo $usertype_info[$j][1];?></option>
						<?php				}
										}
									}
						?>
						</select>
						
						<br />
				</td>
				</tr>
				<tr id="branch_tr">
				  <td><?php echo $lang_branch;?></td>
				  <td id="branch_td"> <select name="branch" id="branch" onkeypress="nextField(event.keyCode,button1)">
						 		<option value=''>----------------------------</option>
				  </td>
				 </tr>
				<tr>
					<td colspan="2" align="center">
					<?php if(empty($userInfo)){?>
                     		 <input id="button1" type="button" name="Add" class="user_info btn btn-success"  value="Add User" />
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="user_info btn btn-success"  value="Update User" />
					<?php } ?>
					 </td>
				</tr>
				</table>
					
				</div>
			
				
            </div>
				   </div>
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->

        
          </div> <!-- /.row -->
			
			</section>
	  <input name="paction" id="paction" type="hidden" value="<?php echo $action;?>" />
	   <input name="change" id="change" type="hidden" value="" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
	   <input name="userid" id="userid" type="hidden" value="<?php echo $userid;?>" />
</form>	
</div>  
</body>
	</html>
	
