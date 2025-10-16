<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>

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
	
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/ajax.css" />

<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script> 
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>


<script>
  
   function submitForm(){
   
     
   		if(document.user.employee.value=='') {
   			showDialog('Error','Please Select Employee.','error',2);
			return false;
		}else if(document.user.username.value=='') {
   			showDialog('Error','Please Enter User Name.','error',2);
			return false;
		}else if(document.user.password.value=='' && document.user.action.value == "ADD") {
   			showDialog('Error','Please Enter Password.','error',2);
			return false;
		}else if(document.user.password.value!='' && document.user.password.value!=document.user.re_pass.value) {
   			showDialog('Error','Password Mismatching.','error',2);
			return false;
		}else if(document.user.user_type.value=='') {
   			showDialog('Error','Please Select User Type.','error',2);
			return false;
		}else if((document.user.user_type.value==8 || document.user.user_type.value==9) && document.user.branch.value=="") {
   			showDialog('Error','Please Select Pharma Branch.','error',2);
			return false;
		}else {
			document.user.action="../../lib/controllers/centralController.php?module=Admin&sub_module=User";
			document.user.submit();
		
		}
   
   }
</script>
<script>

$(document).ready(function() { 

  $( "#user_type" ).change(function() {
	
     var user_type=$( "#user_type" ).val();
	 
	  if(user_type == 8 || user_type==9){  
		  data='';
		  inline_action="../../lib/controllers/centralController.php?module=Admin&sub_module=show_pharma_branch";
		  
		  $.post(inline_action,data,function (response) {
			
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
<body id="frame" "document.user.employee.focus();">
<form name="user" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$usertype_info=$this->popArr['user_type'];
	
	if(isset($this->popArr['userInfo'])){
	
		$userInfo=$this->popArr['userInfo'];
		$userid=$userInfo[0][0];
		$emp_name=$userInfo[0][1];
                $emp_id=$userInfo[0][2];
		$user_name=$userInfo[0][3];
		$pass_word=$userInfo[0][4];
		$user_type=$userInfo[0][5];
		$user_type_id=$userInfo[0][6];
		
	}else{
	
		$userid='';
		$emp_name='';
                $emp_id="";
		$user_name='';
		$pass_word='';
		$user_type='';
		$user_type_id='';
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_user;?>" ><?php echo $lang_add.' '.$lang_user;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_user;?>"><?php echo $lang_update.' '.$lang_user;?></h3><BR />
					
				<?php } ?>
           
          </h1>		  
         
        </section>
 <div class="row">
            <div class="col-md-6">
					<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
			</div>
			</div>
					
					<?php if(isset($this->popArr['message'])){?>
					
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
						
					<?php } ?>
		<div class="row">
            <!-- Left col -->
            <div class="col-md-6">	
					<div class="box box-info">
                       <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_user." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
				 	
                            <tr>
						
						        <td><?php echo $lang_employee; ?> : </td>
						
                               <td><input type="text" name="employee" id="employee"  
                                     tabindex="2" onkeypress="nextField(event.keyCode,username)" value="<?php echo $emp_name; ?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getEmployeeNotUser',event)"/>
						        
						               <input id="employee_hidden" name="employee_ID" type="hidden" value="<?php echo $emp_id;?>"/>
                             </td>
						</tr>
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
					<td>
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success"  value="Add" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success"  value="Update" onclick="return submitForm()"/>
					<?php } ?>
					 </td>
				</tr>
				</table>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $userid;?>" />
</form>	  
</body>
	</html>
	
