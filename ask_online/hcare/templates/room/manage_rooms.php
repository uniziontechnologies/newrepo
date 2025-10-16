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
     
   $(document).ready(function(){
  
   		$(".Search").bind('click', function() {
		
			$("#room_list").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Room");
			$("#room_list").submit();
		});
		$(".edit").bind('click', function() {	 
			

                      var roomid=$(this).attr("id");
                      var data= "id="+roomid;

                      inline_action="../../lib/controllers/centralController.php?module=Room&sub_module=check_room_status";
			
		     $.post(inline_action,data,function (response) {

                          if(response['room_status'] == 1){
                              
                             showDialog('Error','Failed to Edit room. Patients are admitted to this room.','error',2);
			         return false;
                          }else{
                             
								$("#page_action").val("EDIT_PAGE");
										$("#id").val(roomid);
									
										$(".rooms").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Room");
										//document.rooms.action="../../lib/controllers/centralController.php?module=Room&sub_module=Room";
										//alert(document.rooms.action.value);
										
										
										$(".rooms").submit();


                          }

                     },"json");;

		
		});
        $(".delete").bind('click', function() {	
                      var roomid=$(this).attr("id");
                      var data= "id="+roomid;

                      inline_action="../../lib/controllers/centralController.php?module=Room&sub_module=check_room_status";
			
		     $.post(inline_action,data,function (response) {

                          if(response['room_status'] == 1){
                              
                             showDialog('Error','Failed to delete room. Patients are admitted to this room.','error',2);
			         return false;
                          }else{
                                $("#id").val(roomid);
                                var a=confirm("Do u want to Delete Room!");

                                if(a==true){
		
		                  $(".rooms").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=delete_room");
                                  $(".rooms").submit();
                               }
                          }

                     },"json");;

                     
                });
		
		$("#add").bind('click', function() {	
		
			$("#page_action").val("CREATE_PAGE");
			$("#room_list").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Room");			
			$("#room_list").submit();
		});
   });
   
   /*function submitform(action,id){
   	setAction(action,id);
	
   	document.rooms.action="../../lib/controllers/centralController.php?module=Room&sub_module=Room";
	document.rooms.submit();
   }*/
</script>

</head>
<body id="content">
<form name="rooms" id="room_list"  class ="rooms" method="post" action=""> 
<?php
	$roomInfo=$this->popArr['roomInfo'];
	$categoryInfo=$this->popArr['categoryInfo'];
?>
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" id="add"><i class="fa fa-plus"></i><?php echo $add." ".$lang_room;?></font></button>
           
          </ol>
        </section>
 
         <section class="content">
					 
	    <div class="box box-info">
                
               <div class="box-body">
		 <table class="table table-striped">


								<tr>
										<td id="noborder"><?php echo $lang_room." ".$lang_category; ?>
											
											<select name="category" id="category"   onkeypress="nextField(event.keyCode,roomno)" onChange="nextField(event.keyCode,roomno)" /> 		
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($categoryInfo);$i++){ 
																						
													if(!empty($post['category']) && $post['category']==$categoryInfo[$i][0]) { ?>
													
														<option value='<?php echo $categoryInfo[$i][0];?>' selected><?php echo $categoryInfo[$i][1];?></option>
											<?php   }else {?>
										
														<option value='<?php echo $categoryInfo[$i][0];?>'><?php echo  $categoryInfo[$i][1];?></option>
												
											<?php } 
												} ?>
											</select>
											
										</td>
										<td id="noborder">
												
												<?php echo $lang_room_no; ?> : 
												
												<input type="text" name="roomno" value="" />
										</td>
										
										<td id="noborder">
										
											<?php echo $lang_bed_capacity; ?> :
											
											<select name="bed_capacity" id="bed_capacity"    onChange="return select_bedtype()" /> 		
									
												<option value='SINGLE'>SINGLE</option>
												<option value='MULTIBED'>MULTIBED</option>
											</select>
										</td>
										
									<td id="noborder">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="Search btn btn-success" value="Search" /></td>
								</tr>
						</table>
				
					</div>
			</div>
			<h3 ><?php echo $lang_room."S ".$lang_list; ?></h3>
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
                                <th><a href="#"><?php echo $lang_room_no; ?></a></th>    
								<th><a href="#"><?php echo $lang_bed_capacity; ?></a></th> 
								<th><a href="#"><?php echo "TOTAL ".$lang_bed_no; ?></a></th>  
                                <th><a href="#"><?php echo $lang_room_rent; ?></a></th> 								
                                  <th><a href="#"><?php echo $lang_nursing_charges; ?></a></th> 
                                  <th><a href="#"><?php echo $lang_bystander_charge; ?></a></th>  
                                 <th><a href="#"><?php echo $lang_maintenance; ?></a></th>                           
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($roomInfo)){
			$j=1;
				for($i=0;$i<count($roomInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $roomInfo[$i][5];?></td>
						<td><?php echo $roomInfo[$i][2];?></td>	
						<td><?php echo $roomInfo[$i][3];?></td>	
						<td><?php echo $roomInfo[$i][4];?></td>	
						<td><?php echo $roomInfo[$i][6];?></td>	
						<td><?php echo $roomInfo[$i][8];?></td>
						<td><?php echo $roomInfo[$i][11];?></td>	
                        <td><?php echo $roomInfo[$i][9];?></td>							
						
						<td>
						    <button type="button" class="edit btn btn-success" id="<?php echo $roomInfo[$i][0];?>"><i class="fa fa-edit"></i></button>
						     <button type="button" class="delete btn btn-danger" id="<?php echo $roomInfo[$i][0];?>"><i class="fa fa-remove"></i></button>
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
	 <input type="hidden" name="page_action" id="page_action" />
</form>	  
</body>
	</html>
	
