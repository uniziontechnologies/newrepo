
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
   	setAction(action,id);
	
   	document.speciality.action="../../lib/controllers/centralController.php?module=Admin&sub_module=Speciality";
	document.speciality.submit();
   }
   
   
</script>

</head>
<body id="frame">
<form name="speciality" id="form"  method="post" action=""> 
<?php
	$SpecialityInfo=$this->popArr['SpecialityInfo'];
	$department = $this->popArr['department'];
?>
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_speciality;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table>
								<tr>
										<td id="noborder"><?php echo $lang_department; ?>
											
											 <select name="dep_id" id="dep_id" keypress="nextField(event.keyCode,Search)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($department)){
								
									for($i=0;$i<count($department);$i++){ ?>									
												
												<option value='<?php echo $department[$i][0];?>' ><?php echo $department[$i][1];?></option>
						<?php			
									}
								}
						?>							
						
						</select>&nbsp;&nbsp;&nbsp;&nbsp;
										
										</td>
										<td id="noborder"><?php echo $lang_speciality; ?>
											
											<input name="spec_name" id="spec_name" value='' autocomplete="off" />
											
										
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_speciality." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_department; ?></a></th>
                                <th><a href="#"><?php echo $lang_speciality; ?></a></th>   
								<th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($SpecialityInfo)){
				for($i=0;$i<count($SpecialityInfo);$i++) {?>
					<tr>
						<td><?php echo $SpecialityInfo[$i][0];?></td>
						<td><?php echo $SpecialityInfo[$i][1];?></td>
						<td><?php echo $SpecialityInfo[$i][3];?></td>
										
						
						<td>
							 <button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $SpecialityInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						     <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $SpecialityInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	 <input type="hidden" name="action" id="action" />
</form>	  
</body>
	</html>
	
