
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

	   	if (action=="DELETE") {

	   		var a = confirm("Are You Sure To Delete ?");

	   		if (a==true) {

			   	setAction('',id);
				
			    document.employee.paction.value=action;
			   	document.employee.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Employee";
				document.employee.submit();

	   		}
	   		else{
	   			return false;
	   		}

	   	}
	   	else{


		   	setAction('',id);
			
		        document.employee.paction.value=action;
		   	document.employee.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Employee";
			document.employee.submit();

	   	}

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
	$userInfo		=	$this  ->popArr['userInfo'];
	$post		=	$this  ->popArr['post'];

?>
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_employee;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table width="55%">
 
								<tr>
										<td id="noborder"><?php echo $lang_search." BY"; ?>:
											
											 <select name="search_by" id="search_by" keypress="nextField(event.keyCode,Search)" />
						  		
						  							<option value='first_name' <?php if (!empty($post['search_by']) && $post['search_by']=="first_name" ) {
						  								echo "selected";
						  							} ?> >First Name</option>							

													<option value='last_name' <?php if (!empty($post['search_by']) && $post['search_by']=="last_name" ) {
						  								echo "selected";
						  							} ?> >Last Name</option>
												</td>
						
											
										</td>
										<td id="noborder"><?php echo $lang_search." FOR"; ?>:
											
											<input name="search_for" id="search_for" value='<?php if(!empty($post['search_for'])){echo $post['search_for'];} ?>' autocomplete="off" />
											
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
                       <h3 class="box-title"><?php echo $lang_employee." ".$list; ?></h3>
					    
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
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($employeeInfo)){
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
							<button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						     <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $employeeInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
</form>	  
</body>
	</html>
	
