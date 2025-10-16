
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
 
   function submitform(){
   	document.department.action="../../lib/controllers/centralController.php?module=Admin&sub_module=delete_med_days";
	document.department.submit();
   }
   function delete_data(id){

   		var a = confirm("Are you sure to delete ?");

	   	if (a==true) {

			document.department.id.value=id;
		   	document.department.action="../../lib/controllers/centralController.php?module=Admin&sub_module=delete_med_days";
			document.department.submit();

	   	}
	   	else{
	   		return false;
	   	}


   }
   
   
</script>

</head>
<body id="frame">
<form name="department" id="form"  method="post" action=""> 
<?php
	$medicine_presc=$this->popArr['medicine_presc'];
	$post=$this->popArr['post'];


?>
            	
					
<section class="content-heaer">
         
		  <!-- <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_department;?></font></button> -->
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
					
								<tr>
										<td ><?php echo 'MEDICINE DAYS'; ?>
											
											<input name="medicine_days" id="medicine_days" value='<?php echo !empty($post['medicine_days'])?$post['medicine_days']:''; ?>' autocomplete="off" />
										
									<input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="submitform();"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			
					<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_department." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped" style="width: 50%;">
				<thead>
					<tr>
                         <th><a href="#"><?php echo $lang_sl_no; ?></a></th>
                         <th><a href="#"><?php echo 'MEDICINE DAYS'; ?></a></th>                              
                         <th ><a href="#"><?php echo $lang_action; ?></a></th>
                    </tr>
				</thead>
				<tbody>	
		<?php
			if(!empty($medicine_presc)){
				$j=1;
				for($i=0;$i<count($medicine_presc);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $medicine_presc[$i][6];?></td>						
						<td>
						   <button type="button" class="btn btn-danger" onclick="delete_data('<?php echo $medicine_presc[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	 <input type="hidden" name="med_days" id="med_days" />
</form>	  
</body>
	</html>
	
