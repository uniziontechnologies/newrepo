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
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
 
   
   $(document).ready(function(){
  
   		$(".Search").bind('click', function() {
		
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Nursing_Stations");
			$("#form").submit();
		});
   		$( "#station_name" ).keypress(function(e) {
   			if ( e.which == 13 ) {
     e.preventDefault();
   			$("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Nursing_Stations");
			$("#form").submit();
		}
 
});
		$(".edit").bind('click', function() {	 
			
			$("#page_action").val("EDIT_PAGE");
			$("#id").val($(this).attr("id"));
		
			$(".rooms").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Create_Nursing_Station");
			//document.rooms.action="../../lib/controllers/centralController.php?module=Room&sub_module=Room";
			//alert(document.rooms.action.value);
			
			
			$(".rooms").submit();
		});
                $(".delete").bind('click', function() {
	
                                var sid=$(this).attr("id");

                                $("#page_action").val("DELETE");
                                             
                                $("#id").val(sid);
                                var a=confirm("Do u want to Delete Nursing Station!");

                                if(a==true){
		
		                  $(".rooms").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Process_Station");
                                  $(".rooms").submit();
                               }
                         

                     
                });
		
		$("#add").bind('click', function() {	
		
			$("#page_action").val("CREATE_PAGE");
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Create_Nursing_Station");			
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
	$roomInfo=$this->popArr['roomInfo'];
   $stationInfo=$this->popArr['stationInfo'];
?>
 <div id="content">
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" id="add"><i class="fa fa-plus"></i><?php echo $lang_create." ".$lang_nursing_station;?></font></button>
           
          </ol>
        </section>
 <h4> <?php echo $lang_search." ".$lang_room ?></h4>	
         <section class="content">
				 
	    <div class="box box-info">
                
               <div class="box-body">
		 <table class="table table-striped">

 
								<tr>
								 <td id="noborder">
												
												<?php echo $lang_station_name; ?> : 
												
												<input type="text" name="station_name" value="" id="station_name"/>
												&nbsp;&nbsp;&nbsp;<input id="button1" type="button" name="Search"  class="Search btn btn-success" value="Search" />
										</td>
										
									
									
										
										<!-- <td id="noborder">
												
												<?php echo $lang_room_no; ?> : 
												
												<input type="text" name="roomno" value="" />
										</td>
										 -->
										<!-- <td id="noborder">
										
											<?php echo $lang_bed_capacity; ?> :
											
											<select name="bed_capacity" id="bed_capacity"    onChange="return select_bedtype()" /> 		
									
												<option value='SINGLE'>SINGLE</option>
												<option value='MULTIBED'>MULTIBED</option>
											</select>
										</td> -->
										
									
								</tr>
						</table>
				
					</div>
			</div>
			<h4 ><?php echo $lang_nursing_station." ".$lang_list; ?></h4>
					<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
                           <div class="box-body">
			         <table class="table table-bordered table-striped">
       			
				
                             <thead>
					<tr>
                                            <th><a href="#"><?php echo $lang_station_name;?></a></th>
                                             <th ><a href="#"><?php echo $lang_room."S";?></a></th>
                                              <th ><a href="#"><?php echo $lang_action;?></a></th>
                                        </tr>
                             </thead>
                             <tbody>
                         <?php if(!empty($stationInfo)){ 

                                     for($i=0;$i<count($stationInfo);$i++) { ?>

                                     
					<tr>
                                            <td ><b style="font-size: 18;"><?php echo $stationInfo[$i][1];?>
                                            </b></td>

                                          <td>


                                            <TABLE WIDTH="100%">


                                             <?php
                                                $roomNumber=$roomInfo[$i];
			                      if(!empty($roomNumber)){
			                        $j=1;
				                   for($j=0;$j<count($roomNumber);$j++) { 
				                   	// echo $i."iii"; echo $i%5;

				                   	?>
				              <!--  <tr><b><?php  echo $roomNumber[$j][0]."\t"."&nbsp;&nbsp;";?></b></tr> -->
				
						
                                                  <?php if($j%5 == 0) {?>

                                                            <TR>
                                                       <?php } ?>
						              <TD id="noborder"><b><?php  echo $roomNumber[$j][0];?></b></TD>

                                                      <?php if(($j+1)%5 == 0) { ?>
                                                              </TR> 
                                                     <?php } ?>
						
						
											
					
						
                           
					
						
				
		<?php	}
			
			}		
		?>
                                   </TABLE>

                                      </td>
                                      <td>  <button type="button" class="edit btn btn-success" id="<?php echo $stationInfo[$i][0];?>"><i class="fa fa-edit"></i></button>
						     <button type="button" class="delete btn btn-danger" id="<?php echo $stationInfo[$i][0];?>"><i class="fa fa-remove"></i></button>
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
	
