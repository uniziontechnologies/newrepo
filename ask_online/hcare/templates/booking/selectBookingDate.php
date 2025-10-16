
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" type="text/css" href="../../css/theme.css" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<script type="text/javascript" src="../../js/common_functions.js">  </script>
<script type="text/javascript" src="../../js/mootools.v1.11.js"></script>

<script type="text/javascript" src="../../js/DatePicker.js"></script>
<script>
	
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
  
   document.writeln('<link rel="stylesheet" type="text/css" href="../../css/' + StyleFile + '">');
   
  
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
<form name="booking" id="form"  method="post" action=""> 
<?php
	
	
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];
	$departments=$this  ->popArr['departments'];
	
	$doc_id='';
	$dep_id='';
	
	
	
	

?>
 <div id="wrapper">
            <div id="content">
			<div id="box">
                	
					<h3> <?php echo $lang_search; ?></h3>
					<div align="center">
						<table width="60%">
								
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
								
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" onclick="processForm();"/>
									<input id="button1" type="button" name="Clear" value="Clear" onclick="clearForm();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			<div id="rightnow">
                	<h3 class="reallynow">
						<?php echo $lang_doctor." ".$lang_availability; ?>			
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div align="center">
			<table width="97%">
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
			$j=1;
				for($i=0;$i<count($scheduling_list);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo	$scheduling_list[$i][1];?></td>
					<?php if(count($scheduling_list[$i]) >2) { ?>
					
							
							<td><?php echo	$scheduling_list[$i][7];?></td>
							<td><?php echo	$scheduling_list[$i][8];?></td>
							<td><?php echo	$scheduling_list[$i][9];?></td>
							<td><?php echo	$scheduling_list[$i][10];?></td>
							<td><?php echo	$scheduling_list[$i][11];?></td>
							<td><?php echo	$scheduling_list[$i][12];?></td>
							<td><?php echo	$scheduling_list[$i][13];?></td>
							<td><?php echo	$scheduling_list[$i][6];?></td>
					
					
					<?php }else { ?>
					
							<td colspan="8" align="center" id="lightMessage"></td>
					<?php } ?>
						
						
						
										
						
						<td>
							<a href="#" onClick="submitform('<?php echo $scheduling_list[$i][0];?>');"><img src="../../img/icons/user_edit.png" title="Time Schedule" width="16" height="16" /></a>
							
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
	
