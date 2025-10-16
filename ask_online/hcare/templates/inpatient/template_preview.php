
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
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />  
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

<script>
 
 //   function search(action,id){
 //   	setAction(action,id);
	
 //   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=manage_templates";
	// document.department.submit();
 //   }
 //   function edit(action,id){
 //   	setAction(action,id);
	
 //   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=edit_template";
	// document.department.submit();
 //   }
 //   function remove(action,id){
 //   	setAction(action,id);
	
 //   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=delete_template";
	// document.department.submit();
 //   }
 //   function create_template(){
	
 //   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=create_template";
	// document.department.submit();
 //   }
 //   function preview(action,id){

 //      tb_show('TEMPLATE PREVIEW',"../../lib/controllers/centralController.php?module=IP&sub_module=template_preview&id="+id,'',750,550);

 //   }
   
   
</script>

</head>
<body id="frame">
<form name="department" id="form"  method="post" action=""> 
<?php
	$template_selected=$this->popArr['template_selected'];
	$template_selected_items=$this->popArr['template_selected_items'];
?>
            	
 
		<section class="content">
					 				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h6 class="box-title"><?php echo (!empty($template_selected[0][1])?$template_selected[0][1]:''); ?></h6>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>                             
                         <th ><a href="#"><?php echo $lang_fields; ?></a></th>
                         <th ><a href="#"><?php echo $lang_type; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
							<?php
								if(!empty($template_selected_items)){
									$j=1;
									for($i=0;$i<count($template_selected_items);$i++) {?>
										<tr>
											<td><?php echo $j++;?></td>
											<td><?php echo $template_selected_items[$i][3];?></td>
											<td><?php echo $template_selected_items[$i][4];?></td>   
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
	
