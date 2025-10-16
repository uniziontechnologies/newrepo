
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
 
   function search(action,id){
   	setAction(action,id);
	
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=manage_templates";
	document.department.submit();
   }
   function edit(action,id){
   	setAction(action,id);
	
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=edit_template";
	document.department.submit();
   }
   function remove(action,id){

   		var confirm_data = confirm("Are you sure to Delete this Template ? ");

	   	if (confirm_data==true) {
	   		
		   	setAction(action,id);
			
		   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=delete_template";
			document.department.submit();		
	   	}
	   	else{
	   		return false;
	   	}

   }
   function create_template(){
	
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=create_template";
	document.department.submit();
   }
   function preview(action,id){

      tb_show('TEMPLATE PREVIEW',"../../lib/controllers/centralController.php?module=IP&sub_module=template_preview&id="+id,'',750,550);

   }
   
   
</script>

</head>
<body id="frame">
<form name="department" id="form"  method="post" action=""> 
<?php
	$templates=$this->popArr['templates'];
	$post=$this->popArr['postArr'];
?>
            	
					
<section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onclick="create_template();"><i class="fa fa-plus"></i><?php echo $add." ".$lang_template;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
					
								<tr>
										<td ><?php echo $lang_template; ?>
											
											<input name="temp_name" id="temp_name" value="<?php echo(!empty($post['temp_name'])?$post['temp_name']:''); ?>" autocomplete="off" />
										
									<input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="search('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			
					<?php if(isset($post['message'])){?>
						<div class="callout callout-success"><?php echo $post['message'];?></div>
					<?php } ?>
				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_template."S"; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                         <th><a href="#"><?php echo $lang_template; ?></a></th>                               
                         <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($templates)){
				for($i=0;$i<count($templates);$i++) {?>
					<tr>
						<td><?php echo $templates[$i][0];?></td>
						<td><?php echo $templates[$i][1];?></td>
									
						<td>
							<button type="button" class="btn btn-info" onclick="preview('<?php echo $lang_preview;?>','<?php echo $templates[$i][0];?>');"><i class="fa fa-eye"></i></button>
							<button type="button" class="btn btn-success" onclick="edit('<?php echo $lang_edit_page;?>','<?php echo $templates[$i][0];?>');"><i class="fa fa-edit"></i></button>
						    <button type="button" class="btn btn-danger" onclick="remove('<?php echo $lang_delete;?>','<?php echo $templates[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	
