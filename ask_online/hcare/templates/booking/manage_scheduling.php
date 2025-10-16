
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
	
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
  
   document.writeln('<link rel="stylesheet" type="text/css" href="../../css/' + StyleFile + '">');
   
   function submitform(id){
   
	
		setAction('',id);	
   		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Scheduling_Form";
		document.manage_scheduling.submit();
   }
   function processForm(){
	
	
	
		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Manage_Scheduling&View=View";
		document.manage_scheduling.submit();
		
		
	}
	function clearForm(){
	
		document.manage_scheduling.department.value='';
		document.manage_scheduling.doctor.value='';
		document.manage_scheduling.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Manage_Scheduling&View=View";
		document.manage_scheduling.submit();
	}
	
   
</script>
<script type="text/javascript">

// The following should be put in your external js file,
// with the rest of your ondomready actions.
window.addEvent('domready', function(){

	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});

});


</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="manage_scheduling" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$departments=$this  ->popArr['departments'];
	$scheduling_list=$this  ->popArr['scheduling_list'];
	
	$doc_id='';
	$dep_id='';
	
	if(!empty($this->popArr['dep_id'])){
		$dep_id=$this->popArr['dep_id'];
	}
	if(!empty($this->popArr['doc_id'])){
		$doc_id=$this->popArr['doc_id'];
	}
	
?>
<section class="content-heaer">
       
		  <!--<ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="newSchedule();"><i class="fa fa-plus"></i><?php echo $add." ".$lang_scheduling;?></font></button>
           
          </ol>-->
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table width="75%">
 
								
							<td id="noborder">
							<?php echo $lang_department; ?> </td>
								<td id="noborder" ><select name="department" id="department"   onkeypress="processForm();" onChange="processForm();"/> 		
									<option value=''>------------------------------</option>
											
											<?php if(!empty($doctors)){
													
													for($i=0;$i<count($departments);$i++){ 
																						
													if(!empty($dep_id) && $dep_id==$departments[$i][0]) { ?>
													
														<option value='<?php echo $departments[$i][0];?>' selected><?php echo $departments[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $departments[$i][0];?>'><?php echo  $departments[$i][1];?></option>
												
										<?php 		} 
												} 
												} ?>
									</select>
							</td>		
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="processForm();" onChange="processForm();" /> 		
									<option value=''>------------------------------</option>
											
											<?php if(!empty($doctors)){
													for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($doc_id) && $doc_id==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} 
												} ?>
									</select>
							</td>	
								
									
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search"  class="btn btn-success" value="Search" onclick="processForm();"/>
									<input id="button1" type="button" name="Clear"  class="btn btn-danger" value="Clear" onclick="clearForm();"/>
									</td>
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
                       <h3 class="box-title"><?php echo $lang_scheduling." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_doctor; ?></a></th>
						 <th><a href="#"><?php echo $lang_sunday; ?></a></th>
						 <th ><a href="#"><?php echo $lang_monday; ?></a></th>	
						 <th ><a href="#"><?php echo $lang_tuesday; ?></a></th>   					  
                           <th><a href="#"><?php echo $lang_wednesday; ?></a></th>
						    <th ><a href="#"><?php echo $lang_thursday; ?></a></th>
							<th ><a href="#"><?php echo $lang_friday; ?></a></th>
							<th><a href="#"><?php echo $lang_saturday; ?></a></th>					    
							  <th ><a href="#"><?php echo $lang_status; ?></a></th>                           
							<th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		
			if(!empty($scheduling_list)){
			$o=1;
				for($i=0;$i<count($scheduling_list);$i++) {?>
					<tr>
						<td><?php echo $o++;?></td>
						<td><?php echo	$scheduling_list[$i][1];?></td>
					<?php if(count($scheduling_list[$i]) >2) { 
						
							for($j=0;$j<7;$j++) {
							
							$expInfo=explode("/",$scheduling_list[$i][$j+7]);
					?>
							<td>
							<?php if(!empty($expInfo[0])){ 
								
								echo $expInfo[0]."-".$expInfo[1]."<br>";
						 	} ?>
							<?php if(!empty($expInfo[2])){ 
								
								echo $expInfo[2]."-".$expInfo[3];
						 	} ?>
							<br />	
							</td>
						
					<?php } ?>	
							<!--/*<td><?php echo	$scheduling_list[$i][7];?></td>
							<td><?php echo	$scheduling_list[$i][8];?></td>
							<td><?php echo	$scheduling_list[$i][9];?></td>
							<td><?php echo	$scheduling_list[$i][10];?></td>
							<td><?php echo	$scheduling_list[$i][11];?></td>
							<td><?php echo	$scheduling_list[$i][12];?></td>
							<td><?php echo	$scheduling_list[$i][13];?></td>*/-->
							<td><?php echo	$scheduling_list[$i][6];?></td>
					
					
					<?php }else { ?>
					
							<td colspan="8" align="center" id="lightMessage"></td>
					<?php } ?>
						
						
						
										
						
						<td>
						<button type="button" class="btn btn-success" onClick="submitform('<?php echo $scheduling_list[$i][0];?>');"><i class="fa fa-edit"></i></button>
						  
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
	
</form>	  
</body>
	</html>
	
