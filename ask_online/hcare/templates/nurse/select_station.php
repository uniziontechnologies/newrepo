
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
 <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script>
  
           $(document).ready(function(){
   
                $(".save").bind('click', function() {
		
                       if($("#station").val() == ""){
                          
                         showDialog('Error','Please Select Your Nursing Station.','error',2);
			 return false;

                      }else {
			
                        
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=save_nursing_station");
			$("#form").submit();
                     }
		});
   
        });
</script>

</head>
<body id="frame">
<form name="station" id="form"  method="post" action=""> 
<?php
	$stationInfo=$this->popArr['stationInfo'];
?>
 <div id="wrapper">
            <div id="content">
			<div id="box">
                	
				
				
						
						<fieldset id="op">
					
                        		<legend><?php echo $lang_select." ".$lang_nursing_station;?></legend>
								
								<label for="station"><?php echo $lang_nursing_station; ?> <span id='requiredfield'>*</span> : </label>
											
									<select name="station" id="station">
                                                                            <option value="">-------select--------</option>
                                                                            <?php

                                                                               if(!empty($stationInfo)) {

                                                                                  for($i=0;$i<count($stationInfo);$i++) {


                                                                               ?>
                                                                                 <option value="<?php echo $stationInfo[$i][0];?>"><?php echo $stationInfo[$i][1];?> </option>


                                                                          <?php }

                                                                              }

                                                                         ?>
											
										
								    </select>
								
															
										
								
									<input id="button1" type="button" class="save btn btn-success" name="save"  value="Save" /></td>
								
					</fieldset>			
					
			</div>
			<BR />
       			
				</div>
				
			
				
            </div>
           
      </div>
	 
</form>	  
</body>
	</html>
	
