<?php session_start();?>

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
	

	
	$(".user_info").bind('click', function() {

		$('#paction').val('ADD');
		
		 if($("#userid").val() == "" && $("#password").val() == ""){
			showDialog('Error','Please Enter Password.','error',2);
			return false;
        }else if($("#password").val() != "" && ($("#password").val() != $("#re_pass").val())){
			showDialog('Error','Password Mismatching.','error',2);
			return false;
        }else if($("#password").val() == "" &&  $("#re_pass").val() ==""){
			showDialog('Error','Please Enter Password.','error',2);
			return false;
        }else{
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Admin&sub_module=change_password");
			 $("#form").submit();
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

		$userid=$_SESSION['user_id'];

		// echo $userid;
	

	

?>
<section class="content-header">
        <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
		<?php } ?>


			<div class="row col-md-6">
				   			<div class="box box-info">
                       <div class="box-header with-border">
                       <h3 class="box-title text-bold"><?php echo $lang_change_password;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
				 	
					
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
					<td colspan="2" align="center">
						<br>
				
							<input id="button1" type="button" name="Update" class="user_info btn btn-success"  value="Update" />
				
					 </td>
				</tr>
				</table>
					
				</div>
			
				
            </div>
        </div>
				
                
	  <input name="paction" id="paction" type="hidden" value="" />
	   <input name="change" id="change" type="hidden" value="" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
	   <input name="userid" id="userid" type="hidden" value="<?php echo $userid;?>" />
</form>	
</div>  
</body>
	</html>
	
