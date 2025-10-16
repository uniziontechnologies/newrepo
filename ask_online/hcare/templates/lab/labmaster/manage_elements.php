
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
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>	   
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script>
 
   function submitform(action,id){
   	setAction(action,id);
   	if(action == "SEARCH"){
   		document.test_element.current_page.value=1;

   	}
	
	if(action == "DELETE"){

				var a=confirm("Do You Really Want to Delete The Test Element?");
		
  		        if(a==true)
   			      {
				
			      }else return false;
				

			     }
			
   	document.test_element.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Elements";
	document.test_element.submit();
   }
   $(document).ready(function(){
     $(".next_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=Elements");
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=Elements");
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  
			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=Elements");
				 $("#form").submit();
			  });
 });

</script>
</script>

</head>
<body id="frame">
<form name="test_element" id="form"  method="post" action=""> 
<?php
	$elementInfo=$this->popArr['elementInfo'];
	$pagination=$this  ->popArr['pagination'];
	$current_page=$this  ->popArr['current_page'];
	$perPage=$this->popArr['perPage'];

	$config_obj=new Config_hims();
?>
            	
					
<section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $lang_test_elements;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
					
								<tr>
										<td ><?php echo $lang_element_name; ?>
											
											<input name="elem_name" id="elem_name" value='' autocomplete="off" />
										
									<input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
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
                       <h3 class="box-title"><?php echo $lang_test_elements; ?></h3>
					     <div class="box-tools">
				   <?php echo $pagination;?>
				  </div>
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
					            <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                                <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_element_name; ?></a></th>
                                <th><a href="#"><?php echo $lang_normal_value; ?></a></th>  
                                <th ><a href="#"><?php echo $lang_unit; ?></a></th>								
                                <th ><a href="#"><?php echo $lang_material_cost; ?></a></th> 
                                <th ><a href="#"><?php echo $lang_price; ?></a></th>
                                <th ><a href="#"><?php echo $lang_outside; ?></a></th>  								
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($elementInfo)){
				
				
				$j=($current_page -1)*$perPage+1;
				for($i=0;$i<count($elementInfo);$i++) {?>
					<tr>
					    <td><?php echo $j++;?></td>
						<td><?php echo $elementInfo[$i][0];?></td>
						<td><?php echo $elementInfo[$i][1];?></td>
						<td><?php echo $elementInfo[$i][4];?><br>
						    <?php echo $elementInfo[$i][5];?><br>
							<?php echo $elementInfo[$i][6];?><br>
							<?php echo $elementInfo[$i][7];?><br>
							<?php echo $elementInfo[$i][8];?>
						
						</td>	
						<td><?php echo $elementInfo[$i][10];?></td>
                        <td><?php echo $elementInfo[$i][11];?></td>
                        <td><?php echo $elementInfo[$i][12];?></td>	
                        <td><?php echo ($elementInfo[$i][13] == 1)?'YES':'';?></td>							
						
						<td>
							  <button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $elementInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>

						<?php 

							if ( $elementInfo[$i][0] != $config_obj->mantox_id ) {?>

						   <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $elementInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>


							<?php
							}


						?>
						   
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
	  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
</form>	  
</body>
	</html>
	
