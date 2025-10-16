
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
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

<script>
  
   function submitForm(){
   
   		 checktrue=0;
		with (document.token_reservation) {
		
			for (var i=0; i < elements.length; i++) {
				if (elements[i].type == 'checkbox' && elements[i].checked == true) {
					checktrue++;
				}
			}	
		}
		if(checktrue == 0){
		
			showDialog('Error','Please Select Atleast One Reserved Token!','error',2);
			return false;
		}else{
		
					document.token_reservation.action="../../lib/controllers/centralController.php?module=Booking&sub_module=Token_Reservation";
					document.token_reservation.submit();	
					return true;
		}
		
   		return true;
   
   }
   
  
	
</script>

</head>
<body id="frame" >
<form name="token_reservation" id="form" method="post" action=""> 
<?php
	
	$reserved_tokens=$this  ->popArr['reserved_tokens'];
	
?>
    <section class="content-header">
          
          <h3  ><?php echo $lang_token_reservation; ?></h3>
     </section>
		<!-- Main content -->
        <section class="content">
          <?php if(isset($this->popArr['message'])){?>
				
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		 <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
 
								<?php 
									$k=1;
								while($k<=100) { ?>
											<tr>
										<?php for($j=0;$j<10;$j++) { ?>
												<td>
												
												
													<input type="checkbox" name="tokens[]"  value="<?php echo $k;?>" <?php echo (!empty($reserved_tokens) && in_array($k,$reserved_tokens))?'checked':'';?>/>
													
													<?php echo (!empty($reserved_tokens) && in_array($k,$reserved_tokens))?'<a href=#><b>':'';?>
													<?php echo $k++;?>
													
													<?php echo (!empty($reserved_tokens) && in_array($k,$reserved_tokens))?'</b></a>':'';?>
												</td>
										<?php	} ?>
											</tr>
							
						<?php 
									}?>
							</table>
						<br>
						
					 <div align="center">
						
						<input id="button1" type="button" name="update" value="Update" class="btn btn-success" onclick="return submitForm()"/>
				     </div>				
				 </div>
				
					
					
				</div>
			
				
            </div>
           
      </div>
	</section>
	  <input name="action" id="action" type="hidden" value="<?php echo $lang_add;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $arrList[0];?>" />
	    <input name="booking_date" id="booking_date" type="hidden" value="<?php echo $arrList[3];?>" />
</form>	  
</body>
	</html>
	
