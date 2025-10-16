<?php
session_start();

$path=$_SESSION['path'];

?>
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
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
  <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>

   
   
   function submitform(action,id){
   	setAction(action,id);

   	// alert(action);

   	if(action =='DELETE'){
   		  var catid=id;
                      var data= "id="+catid;
                      // alert(data);

                      inline_action="../../lib/controllers/centralController.php?module=Room&sub_module=check_category_status";
			
		     $.post(inline_action,data,function (response) {
		     	// alert(111111111111);

                          if(response['room_status'] == 1){

                          	alert("Failed to delete category. Rooms already created under this category ");
                              
                             // showDialog('Error','Failed to delete category. Rooms already created under this category .','error',2);
			         return false;
                          }else{
                                $("#id").val(catid);
                                var a=confirm("Do u want to Delete Category!");

                                if(a==true){
		
		                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=RoomCategory");
                                  $("#form").submit();
                               }
                          }

                     },"json");;

                     
   	}else{

   		document.category.action="../../lib/controllers/centralController.php?module=Room&sub_module=RoomCategory";
	document.category.submit();

   	}
	
   	
   }
   
   
</script>

</head>
<body id="frame">
<form name="category" id="form"  method="post" action=""> 
<?php
	$categoryInfo=$this->popArr['category'];
?>
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_category;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_category; ?>
											
											<input name="category" id="category" value='' autocomplete="off" />
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
										
									<td id="noborder">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<h3 ><?php echo $lang_category." ".$lang_list; ?></h3>
					<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
                           <div class="box-body">
			         <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                            	<th><a href="#"><?php echo $lang_category; ?></a></th>
                                <th><a href="#"><?php echo $lang_rent; ?></a></th>                    
                                 <th><a href="#"><?php echo $lang_nursing_charges; ?></a></th> 
                                 <th><a href="#"><?php echo $lang_bystander_charge; ?></a></th>  
                                 <th><a href="#"><?php echo $lang_maintenance; ?></a></th>  
                                 <th><a href="#"><?php echo $lang_observation_charge; ?></a></th>  								 
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($categoryInfo)){
			$j=1;
				for($i=0;$i<count($categoryInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $categoryInfo[$i][1];?></td>
						<td><?php echo $categoryInfo[$i][2];?></td>	
						<td><?php echo $categoryInfo[$i][3];?></td>
						<td><?php echo $categoryInfo[$i][7];?></td>						
						<td><?php echo $categoryInfo[$i][4];?></td>						
						<td><?php echo $categoryInfo[$i][6];?></td>		
						<td>
						     <button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $categoryInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						     <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $categoryInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	
