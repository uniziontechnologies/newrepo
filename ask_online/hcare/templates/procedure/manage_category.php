
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
	
   	document.category.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=Manage_Category";
	document.category.submit();
   }
   
   
</script>

</head>
<body id="frame">
<form name="category" id="form"  method="post" action=""> 
<?php
	$categoryInfo=$this->popArr['category'];
?>
					
<section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $lang_add." ".$lang_category;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_category; ?>
											
											<input name="category" id="category" value='' autocomplete="off" />
											
										
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
                       <h3 class="box-title"><?php echo $lang_category." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_category; ?></a></th>
                                <th><a href="#"><?php echo $lang_description; ?></a></th>                                                  
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($categoryInfo)){
				for($i=0;$i<count($categoryInfo);$i++) {?>
					<tr>
						<td><?php echo $categoryInfo[$i][0];?></td>
						<td><?php echo $categoryInfo[$i][1];?></td>
						<td><?php echo $categoryInfo[$i][2];?></td>	
						<td>			
						<button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $categoryInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>	
					<?php if($categoryInfo[$i][3] == 0) {?>	
						
							 
						   <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $categoryInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
							
                     <?php }?>  
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
	
