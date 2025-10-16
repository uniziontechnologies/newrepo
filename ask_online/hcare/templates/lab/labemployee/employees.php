
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
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script>
     
   function submitform(action,id){
   	setAction('',id);
  //  	document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=xray_attahments&billno="+billid;
		// document.manage_bill.submit();
		if(action == 'SEARCH'){
			document.employee.paction.value=action;
        document.employee.id.value=id;
   	document.employee.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Lab_employees";
	document.employee.submit();

		}else{
	
        document.employee.paction.value=action;
        document.employee.id.value=id;
   	document.employee.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Lab_signature";
	document.employee.submit();
}
   }
   function labInCharge(id,lab_in_status){
 //   	var elements = document.getElementsByName( 'yourname' );
	// var id = elements[0].getAttribute( 'id' );
	// alert(id);
 //   	  alert(lab_in_status);return false;
   	document.employee.paction.value="LAB IN CHARGE";
   	document.employee.id.value=id;
   	document.employee.lab_in_status.value=lab_in_status;
   	document.employee.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Lab_employees";
	document.employee.submit();
   	
   }
   
   
</script>

</head>
<body id="frame">
<form name="employee" id="form"  method="post" action=""> 
<?php
	$SpecialityInfo		=	$this->popArr['SpecialityInfo'];
	$departmentInfo 	= $this->popArr['department'];
	$designatioInfo		=	$this ->popArr['DesignationInfo'];
	$employeeInfo		=	$this  ->popArr['EmployeeInfo'];
	// var_dump($employeeInfo);
	$userInfo		=	$this  ->popArr['userInfo'];
?>
<section class="content-heaer">
       
		  <!-- <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_employee;?></font></button>
           
          </ol> -->
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table width="55%">
 
								<tr>
										<td id="noborder"><?php echo $lang_search." BY"; ?>:
											
											 <select name="search_by" id="search_by" keypress="nextField(event.keyCode,Search)" />
						  
						  							<option value='first_name'>First Name</option>													
													<!-- <option value='department'>Department</option> -->													
													<!-- <option value='designation'>Designation</option> -->
												</td>
						
											
										</td>
										<td id="noborder"><?php echo $lang_search." FOR"; ?>:
											
											<input name="search_for" id="search_for" value='' autocomplete="off" />
											
										</td>
										
									<td id="noborder">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
		
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo "EMPLOYEES"; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
						 <th><a href="#"><?php echo $lang_employee." ".$lang_name; ?></a></th>
						 <th><a href="#"><?php echo $lang_designation; ?></a></th>	
						 <th><a href="#"><?php echo $lang_speciality; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_department; ?></a></th>
                         <th><a href="#"><?php echo $lang_username; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_user." ".$lang_type;?></a></th>                            
							<th><a href="#"><?php echo $lang_action; ?></a></th>
							<th><a href="#"><?php echo "LAB IN CHARGE" ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($employeeInfo)){
				// var_dump($employeeInfo);exit;
				for($i=0;$i<count($employeeInfo);$i++) {
					
					?>
					<tr>
						<td><?php echo $employeeInfo[$i][0];?></td>
						<td><?php echo $employeeInfo[$i][2]." ".$employeeInfo[$i][3];?></td>
						<td><?php echo $employeeInfo[$i][13];?></td>
						<td><?php echo $employeeInfo[$i][11];?></td>
						<td><?php echo $employeeInfo[$i][9];?></td>
					<?php if(!empty($userInfo[$i])){ ?>
					
					       <td><?php echo $userInfo[$i][0][3];?></td>
						<td><?php echo $userInfo[$i][0][5];?></td>
					<?php }else{ ?>
						<td></td>
						<td></td>
					<?php } ?>
						 <td>
							<button type="button" class="btn <?php if ($employeeInfo[$i][27] == '') {echo ' btn-info ';}else{ echo 'btn-success';} ?>" onClick="submitform('<?php echo "UPLOAD";?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-upload"></i></button>
						     <!-- <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-remove"></i></button> -->


<!-- <?php 

if ($employeeInfo[$i][1]!="Dr") {?>

<button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>

<?php
}
if ($employeeInfo[$i][1]=="Dr" && $_SESSION['user_id']==14 ) {?>

<button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
<?php
}


?> -->


							</td> 
							<td>
								<input type="checkbox" id="<?php echo $employeeInfo[$i][0]?>" name="lab_in_charge<?php echo $employeeInfo[$i][0]?>" value="<?php echo $employeeInfo[$i][28]?>" onclick="labInCharge('<?php echo $employeeInfo[$i][0]?>','<?php echo $employeeInfo[$i][28]?>')" <?php if ($employeeInfo[$i][28] == '1') {echo ' checked ';} ?>>
								<!-- <input type="radio" id="html" name="fav_language" value="<?php echo $employeeInfo[$i][0];?>" onclick="labInCharge(this.value)" <?php if ($employeeInfo[$i][28] == '1') {echo ' checked ';} ?>> -->

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
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	 <input type="hidden" name="lab_in_status" id="lab_in_status" />

</form>	  
</body>
	</html>
	
