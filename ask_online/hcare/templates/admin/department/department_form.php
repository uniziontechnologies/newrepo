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

 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script> 

<script>
 
   function submitForm(){
   
   		if(document.department.dep_name.value=='') {
   			showDialog('Error','Please Enter Department Name.','error',2);
			return false;
		}else if(document.department.phone.value!='' && !(isNumeric(document.department.phone.value))){
				showDialog('Error','Please Enter Valid Phone Number.','error',2);
				return false;
		}else {
			document.department.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Department";
			document.department.submit();
		
		}
   
   }
</script>

</head>
<body id="frame" onload="document.department.dep_name.focus();">
<form name="department" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	
	if(isset($this->popArr['DepartmentInfo'])){
	
		$departmentInfo=$this->popArr['DepartmentInfo'];
		$id=$departmentInfo[0][0];
		$department=$departmentInfo[0][1];
		$dep_incharge_name=$departmentInfo[0][2];
		$dep_incharge_id=$departmentInfo[0][3];
		$phone=$departmentInfo[0][4];
		
		
	}else{
	
		$id='';
		$department='';
		$dep_incharge_name='';
		$dep_incharge_id='';
		$phone='';
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_department;?>" ><?php echo $lang_add.' '.$lang_department;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_department;?>"><?php echo $lang_update.' '.$lang_department;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_department." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
					
                             <tr>
						
						        <td><?php echo $lang_department; ?> <span id='requiredfield'>*</span> : </td>
                                <td><input name="dep_name" id="dep_name"  
                                     tabindex="2"  onkeypress="nextField(event.keyCode,dep_in_charge)"  value="<?php echo $department; ?>" autocomplete="off"/></td>
						
						
                       	     </tr>	
							 <tr>
						
						        <td><?php echo $lang_in_charge; ?> : </td>
						
                                <td><input name="dep_in_charge" id="dep_in_charge"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,phone)" onKeyUp="ajax_showOptions(this,'getEmployee',event)" value="<?php echo $dep_incharge_name; ?>" autocomplete="off"/>
						
						            <input name="dep_in_charge_ID" id="dep_in_charge_hidden" value="<?php echo $dep_incharge_id; ?>" type="hidden"/>
								</td>
							</tr>
						
					<?php if($action== $lang_add){?>
					
					     <tr>
						      <td><?php echo $lang_phone_no; ?> : </td>
                              <td><input name="phone" id="phone"  
                                  tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="<?php echo ($phone == 0 )?'':$phone ?>" autocomplete="off"/>
							  </td>
						 </tr>
						
					<?php }else { ?>
					
						<tr>
						   <td><?php echo $lang_phone_no; ?> : </td>
                          <td> <input name="phone" id="phone"  
                               tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo ($phone == 0 )?'':$phone ?>" autocomplete="off"/>
							</td>
						</tr>
					
					<?php } ?>
                      		
				
				
					<tr >
                        <td align="center" colspan="2">
					
					     <?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					    <?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
					   <?php } ?>
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
	
