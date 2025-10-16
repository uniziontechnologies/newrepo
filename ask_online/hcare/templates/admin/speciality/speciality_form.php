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
   
   		if(document.speciality.dep_id.value=='') {
   			showDialog('Error','Please Select Department.','error',2);
			return false;
		}else if(document.speciality.spec_name.value=='') {
   			showDialog('Error','Please Enter Speciality.','error',2);
			return false;
		}else {
			document.speciality.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Speciality";
			document.speciality.submit();
		
		}
   
   }
</script>

</head>
<body id="frame" onload="document.department.dep_name.focus();">
<form name="speciality" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$department = $this->popArr['department'];
	
	
	if(isset($this->popArr['SpecialityInfo'])){
	
		$SpecialityInfo=$this->popArr['SpecialityInfo'];
		$id=$SpecialityInfo[0][0];
		$department_name=$SpecialityInfo[0][1];
		$department_id=$SpecialityInfo[0][2];
		$speciality=$SpecialityInfo[0][3];
		
		
		
	}else{
	
		$id='';
		$department_name='';
		$department_id='';
		$speciality='';
		
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_speciality;?>" ><?php echo $lang_add.' '.$lang_speciality;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_speciality;?>"><?php echo $lang_update.' '.$lang_speciality;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_speciality." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
                            <tr>
						     <td><?php echo $lang_department; ?> <span id='requiredfield'>*</span> : </td>
                             <td><select name="dep_id" id="dep_id"  
                          onkeypress="nextField(event.keyCode,speciality)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($department)){
								
									for($i=0;$i<count($department);$i++){ 
										
										if($department_id == $department[$i][0]){	
							?>
											<option value='<?php echo $department[$i][0];?>' selected><?php echo $department[$i][1];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $department[$i][0];?>' ><?php echo $department[$i][1];?></option>
						<?php			}
									}
								}
						?>							
						
						             </select>
							</td>
                       	</tr>
                        <tr>						
						
						
					<?php if($action== $lang_add){?>
					
						<td><?php echo $lang_speciality; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="spec_name" id="spec_name"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="<?php echo $speciality; ?>" autocomplete="off"/> 
						</td>
						
					<?php }else { ?>
					
						<td><?php echo $lang_speciality; ?> <span id='requiredfield'>*</span> : </td>
                        <td> <input name="spec_name" id="spec_name"  
                                tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo $speciality; ?>" autocomplete="off"/>
						</td>
					
					<?php } ?>
                       	</tr>						
						
				<tr>
				   <td>
					
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
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
	
