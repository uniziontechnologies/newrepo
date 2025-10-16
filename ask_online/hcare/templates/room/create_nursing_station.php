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
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>

<script>
     
   $(document).ready(function(){

        $(".create").bind('click', function() {

              status =0;
              $('.check_room').each(function(){ 

                if(this.checked == true ) status =1; 


             });

             check_name=0;

              if($("#station_name").val() == ""){
			
				showDialog('Error','Please Enter Station Name.','error',2);
				return false;
	     }else{

                var sname=$("#station_name").val();
                var sid=$("#id").val(); 
                var data= "";
               
		inline_action="../../lib/controllers/centralController.php?module=Room&sub_module=Check_Station_Name&sname="+sname+"&sid="+sid;
			
		   $.post(inline_action,data,function (response) {
		   
                      if(response['station_count'] >0) check_name=1;
		       
                     
		   

                   if($("#station_name").val() == ""){
			
				showDialog('Error','Please Enter Station Name.','error',2);
				return false;
	           }else if(check_name == 1) {

                         showDialog('Error','Station Name Already Exist, Please Choose Another Name.','error',2);
		        return false;

                  }else if(status == 0) {

                      showDialog('Error','Please Select Room Number.','error',2);
		      return false;

                 }else {

                    $("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Process_Station");
		    $("#form").submit();
                }

                },"json");;
             }
                 


       });
       $( "#category" ).change(function() {

             $("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Create_Nursing_Station");
		$("#form").submit();

       });


  });
   	
	
</script>

</head>
<body id="frame" onload="document.room.category.focus();">
<form name="room" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	$categoryInfo=$this->popArr['categoryInfo'];
	$roomInfo=$this->popArr['roomInfo'];
        $station_assigned=$this->popArr['room_assigned_list'];
        $station_name=$this->popArr['station_name'];
        $station_id=$this->popArr['station_id'];

        
		
?>
<div id="content">
            <section class="content-header">
          <h3>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_nursing_station;?>" ><?php echo $lang_add.' '.$lang_nursing_station;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_nursing_station;?>"><?php echo $lang_update.' '.$lang_nursing_station;?></h3><BR />
					
				<?php } ?>
           
          </h3>		  
         
        </section>

	<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
					
					<?php if(isset($this->popArr['message'])){?>
					
						<div id='message'><?php echo $this->popArr['message'];?></div>
						
					<?php } ?>

                                      <div align="center">

                                                  <?php echo $lang_station_name;?>&nbsp;&nbsp;:<input type="text" name="station_name" id="station_name" value="<?php echo $station_name; ?>">
                                    </div>
					
			<fieldset id="personal">
					
                        <legend><?php echo $lang_room." DETAILS ";?></legend>
						
			
						
					

                                  <div align="center">

                                    <table width="100%">
                                    <?php if(!empty($roomInfo)) {

                                            for($i=0;$i<count($roomInfo);$i++) { ?>
                                          <?php if($i%10 == 0) {?>

                                             <tr>
                                        <?php } ?>
                                                  
                                                <td> 

                                                     <input type="checkbox" name="rooms[]" id="rooms[]" class="check_room"  value="<?php echo $roomInfo[$i][0];?>" <?php echo ($action == "UPDATE" && in_array($roomInfo[$i][0],$station_assigned))?"checked":"";?>>
                                                     <?php echo $roomInfo[$i][2];?>
                                                  </td>
                                           <?php if(($i+1)%10 == 0) {?>
                                              </tr> 
                                            <?php } ?>
                                   <?php    }
                                         }
                                   ?>
                                   </table>
                                  </div>			
				    <br>
				
					<div align="center">
					
					<?php if($action== $lang_add){?>
                     		                   <input id="button1" type="button" name="Add" value="Add" class="create btn btn-success" />
					<?php }else { ?>
							<input id="button1" type="button" name="Update" value="Update" class="create btn btn-success"/>
					<?php } ?>
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="page_action" id="paction" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $station_id;?>" />
</form>	  
</body>
	</html>
	
