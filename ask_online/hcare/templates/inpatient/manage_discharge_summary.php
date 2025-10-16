
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
    <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	   
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
 
   function search(action,id){
   	setAction(action,id);
   	$("#current_page").val('');
	
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=manage_discharge_summary";
	document.department.submit();
   }
   function edit(action,id){
   	setAction(action,id);
	
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=edit_discharge_summary";
	document.department.submit();
   }
   function remove(action,id){

   		var confirm_data = confirm("Are you sure to Delete this Dicharge Summary ? ");

	   	if (confirm_data==true) {
		
		   	setAction(action,id);
			
		   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=delete_patient_discharge_summary";
			document.department.submit();	
	   	}
	   	else{
	   		return false;
	   	}

   }
   function print_discharge_summary(action,id){
	setAction(action,id);
   	document.department.action="../../lib/controllers/centralController.php?module=IP&sub_module=print_discharge_summary";
	document.department.submit();
   }
   function clear_form(){

	window.location.href = "../../lib/controllers/centralController.php?module=IP&sub_module=manage_discharge_summary";
   }
   
  
      $(function () {
	  
	   //Date range picker
        $('#doa').datepicker();
		 $('#dod').datepicker();
	  });
      /*........pagination.........*/	
  $(document).ready(function(){
     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manage_discharge_summary");
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manage_discharge_summary");
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=manage_discharge_summary");
                 $("#form").submit();
              });
  });  
/*........pagination.........*/

</script>

</head>
<body id="frame">
<form name="department" id="form"  method="post" action=""> 
<?php
	$discharge_summary=$this->popArr['discharge_summary'];
	$post=$this->popArr['postArr'];
	$pagination=$this ->popArr['pagination'];
	$current_page=$this ->popArr['current_page'];
	$perPage=$this->popArr['perPage'];
?>
            	
					
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
					
								<tr>

										<td ><?php echo $lang_ip_no; ?></td>
										<td>
											<input name="ipno" id="ipno" value='<?php echo (!empty($post['ipno']))?$post['ipno']:'';?>' autocomplete="off" size="10" />
										</td>
										<td ><?php echo $lang_name; ?></td>
										<td>
											<input name="patient_name" id="patient_name" value='<?php echo (!empty($post['patient_name']))?$post['patient_name']:'';?>' autocomplete="off" />
										</td>
										<td id="noborder"><?php echo $lang_doa; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="doa" id="doa"  class="DatePicker" value="<?php echo (!empty($post['doa']))?$post['doa']:'';?>" readonly="true" size="10" />
										</td>
										
										<td id="noborder"><?php echo $lang_dod; ?>:</td>
										<td id="noborder" >	<input type="text" name="dod" id="dod"  class="DatePicker" value="<?php echo (!empty($post['dod']))?$post['dod']:'';?>" readonly="true" size="10" /></td>
										<td ><?php echo $lang_template; ?></td>
										<td>
											<input name="temp_name" id="temp_name" value='<?php echo (!empty($post['temp_name']))?$post['temp_name']:'';?>' autocomplete="off" />
										</td>
									</tr>
									<tr>
										<td id="noborder" colspan="12" align="center" style="padding-top: 10px;">

											<input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="search('<?php echo $lang_search;?>','');"/>&nbsp;
											<input id="clear" type="button" name="clear" value="Clear"  class="btn btn-info" onclick="clear_form();"/>

										</td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			
					<?php if(isset($post['message'])){?>
						<div class="callout callout-success"><?php echo $post['message'];?></div>
					<?php } ?>

					<?php if(isset($post['message_error'])){?>
						<div class="callout callout-danger"><?php echo $post['message_error'];?></div>
					<?php } ?>
				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_template."S"; ?></h3>
					    <?php echo $pagination;?>
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
								<th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                         <th><a href="#"><?php echo $lang_op_no; ?></a></th> 
                         <th><a href="#"><?php echo $lang_ip_no; ?></a></th>                               
                         <th ><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
                         <th ><a href="#"><?php echo $lang_room; ?></a></th>
                         <th ><a href="#"><?php echo $lang_doa; ?></a></th>
                         <th ><a href="#"><?php echo $lang_dod; ?></a></th>
                         <th ><a href="#"><?php echo $lang_template." ".$lang_name; ?></a></th>
                         <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($discharge_summary)){
				$k=($current_page -1)*$perPage+1;
				for($i=0;$i<count($discharge_summary);$i++) {?>
					<tr>
						<td><?php echo $k++;?></td>
						<td><?php echo $discharge_summary[$i][0];?></td>
						<td><?php echo $discharge_summary[$i][9]."/".$discharge_summary[$i][8];?></td>
						<td><?php echo $discharge_summary[$i][1];?></td>
						<td><?php echo $discharge_summary[$i][2];?></td>
						<td><?php echo $discharge_summary[$i][13];?></td>
						<td><?php echo $discharge_summary[$i][3];?></td>
						<td><?php echo $discharge_summary[$i][4];?></td>
						<td><?php echo $discharge_summary[$i][5];?></td>
									
						<td>
							  <button type="button" class="btn btn-info" onclick="print_discharge_summary('<?php echo $lang_print;?>','<?php echo $discharge_summary[$i][0];?>');"><i class="fa fa-print"></i></button>

						<?php

							if ($discharge_summary[$i][15]!=1) {?>

							<button type="button" class="btn btn-success" onclick="edit('<?php echo $discharge_summary[$i][14];?>','<?php echo $discharge_summary[$i][1];?>');"><i class="fa fa-edit"></i></button>
						    <button type="button" class="btn btn-danger" onclick="remove('<?php echo $lang_delete;?>','<?php echo $discharge_summary[$i][0];?>');"><i class="fa fa-remove"></i></button>
							</td>

							
							<?php
							}
						 	?>

							
                           
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
	  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
	 
</form>	  
</body>
	</html>
	
