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
 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
  
   $(document).ready(function(){
  
   		$(".Search").bind('click', function() {
		
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=RoomStatus");
			$("#form").submit();
		});
		
   });
   
   /*function submitform(action,id){
   	setAction(action,id);
	
   	document.rooms.action="../../lib/controllers/centralController.php?module=Room&sub_module=Room";
	document.rooms.submit();
   }*/
</script>

</head>
<body id="frame">
<form name="rooms" id="form"  class ="rooms" method="post" action=""> 
<?php
	$roomInfo=$this->popArr['roomStatus'];
        $categoryInfo=$this->popArr['categoryInfo'];
?>
 
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
									                       <option value=''>----select---</option>
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
				<th><a href="#"><?php echo $lang_bed_no; ?></a></th> 
                                <th><a href="#"><?php echo $lang_ip_no; ?></a></th> 
                                <th><a href="#"><?php echo $lang_op_no; ?></a></th> 
				 <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th> 
                                <th ><a href="#"><?php echo $lang_admitted_on; ?></a></th>
			        <th ><a href="#"><?php echo $lang_time; ?></a></th> 
                                <th><a href="#"><?php echo $lang_doctor; ?></a></th>                
                                                          
                                <th ><a href="#"><?php echo $lang_status; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($roomInfo)){
			$j=1;
				for($i=0;$i<count($roomInfo);$i++) {?>
					<tr <?php echo ($roomInfo[$i][11] == 'FREE')?'style=background-color:green;color:#ffffff':"";?>>
						<td><?php echo $j++;?></td>
						<td><?php echo $roomInfo[$i][1];?></td>
						<td><b><?php echo $roomInfo[$i][2];?></b></td>	
						<td><b><?php echo $roomInfo[$i][4];?></b></td>	
                                                <td><?php echo $roomInfo[$i][5];?></td>
                                                <td><?php echo $roomInfo[$i][6];?></td>
						<td><?php echo $roomInfo[$i][7];?></td>	
                                                <td><?php if (!empty($roomInfo[$i][9]) && $roomInfo[$i][9]!='1970-01-01' && $roomInfo[$i][9]!='0000-00-00'  ) {
                                                	echo date("d-m-Y",strtotime($roomInfo[$i][9]));
                                                } ?></td>	
                                                <td><?php echo $roomInfo[$i][8];?></td>	
                                               <td><?php echo $roomInfo[$i][10];?></td>	
						 <td ><b><?php echo $roomInfo[$i][11];?></b></td>					
						
						
                           
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
	
