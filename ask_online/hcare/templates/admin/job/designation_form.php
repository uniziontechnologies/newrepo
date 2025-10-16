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
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script>
 
   function submitForm(){
   
   		if(document.designation.des_name.value=='') {
   			showDialog('Error','Please Enter Designation.','error',2);
			return false;
		}else {
			document.designation.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Designation";
			document.designation.submit();
		
		}
   
   }
</script>

</head>
<body id="frame" onload="document.department.dep_name.focus();">
<form name="designation" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	
	if(isset($this->popArr['DesignationInfo'])){
	
		$DesignationInfo=$this->popArr['DesignationInfo'];
		$id=$DesignationInfo[0][0];
		$designation=$DesignationInfo[0][1];
		$description=$DesignationInfo[0][2];
		
		
		
	}else{
	
		$id='';
		$designation='';
		$description='';
		
		
	}
?>
 <div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_designation;?>" ><?php echo $lang_add.' '.$lang_designation;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_designation;?>"><?php echo $lang_update.' '.$lang_designation;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_designation." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
				 	
				             <tr>
							   <td><?php echo $lang_designation; ?> <span id='requiredfield'>*</span> : </td>
                               <td><input name="des_name" id="des_name" tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $designation; ?>" autocomplete="off"/></td>
							 </tr>
					
					<?php if($action== $lang_add){?>
					
					       <tr>
						     <td><?php echo $lang_description; ?> : </td>
                             <td><textarea name="description" id="description" onkeypress="nextField(event.keyCode,Add)"autocomplete="off"/><?php echo $description; ?></textarea> </td>
						 </tr>
						
					<?php }else { ?>
					
					      <tr>
						   <td><?php echo $lang_description; ?> : </td>
                           <td><textarea name="description" id="description" onkeypress="nextField(event.keyCode,Update)"autocomplete="off"/><?php echo $description; ?></textarea> </td>
						  </tr>
					
					<?php } ?>
                    
					    <tr>
						  <td align="center" colspan="2">
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add"  class="btn btn-success" value="Add" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update"  class="btn btn-success" value="Update" onclick="return submitForm()"/>
					<?php } ?>
					      </td>
					     </tr>
						</table>		
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
</form>	  
</body>
	</html>
	
