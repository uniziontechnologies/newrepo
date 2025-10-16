
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	
   	document.package.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=health_checkup_package";
	document.package.submit();
   }
   
   
</script>

</head>
<body id="frame">
<form name="package" id="form"  method="post" action=""> 
<?php
	$packageInfo=$this->popArr['packageInfo'];
	$elementInfo=$this->popArr['elementInfo'];
?>
					
<section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $lang_add." ".$lang_package;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_package_name; ?>
											
											<input name="package_name" id="package_name" value='' autocomplete="off" />
											
										
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_health_checkup_packages." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                            	<th><a href="#"><?php echo $lang_package_name; ?></a></th>
				<th><a href="#"><?php echo $lang_test; ?></a></th>
				<th><a href="#"><?php echo $lang_amount; ?></a></th>
				<th><a href="#"><?php echo $lang_dr_amount; ?></a></th>
                                <th><a href="#"><?php echo $lang_description; ?></a></th>                                                  
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($packageInfo)){
			$j=1;
				for($i=0;$i<count($packageInfo);$i++) {
				
				?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $packageInfo[$i][1];?></td>
						<td>
					  <?php if(!empty($elementInfo)){
					  
					        for($k=0;$k<count($elementInfo[$i]);$k++){
						 echo $elementInfo[$i][$k][3]."<br>";
						}
					   }?>
					       </td>
						<td><?php echo $packageInfo[$i][2];?></td>
						<td><?php echo $packageInfo[$i][4];?></td>
						<td><?php echo $packageInfo[$i][3];?></td>
										
					
						<td>
							 <button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $packageInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						   <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $packageInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
							</td>
                   
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </section>
    
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
</form>	  
</body>
	</html>
	
