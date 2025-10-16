
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
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
   <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>

   <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script>
   
   
   function submitform(action,id){
   	setAction(action,id);
		if(action == "ADD"){
	
			if(document.opsettings.validity_days.value=='') {
   				showDialog('Error','Please Enter OP Sheet Validity.','error',2);
				return false;
			}else if(document.opsettings.reg_fee.value=='') {
   				showDialog('Error','Please Enter OP Patient Registration Fees.','error',2);
				return false;
			}
			else if((document.opsettings.card_expiry.value=='') || document.opsettings.card_expiry.value==0) {
   				showDialog('Error','Please Enter Card Validity.','error',2);
				return false;
			}
		}
   	document.opsettings.action="../../lib/controllers/centralController.php?module=Admin&sub_module=OPSettings";
	document.opsettings.submit();
	return true;
   }
   
   
</script>
<style type="text/css">
#table_body tr:first-child td {
    background: lightgreen !important;
}
</style>
</head>
<body id="frame">
<form name="opsettings" id="form"  method="post" action=""> 
<?php
	$opSettingsinfo=$this->popArr['opSettingsinfo'];
?>
<div id="content">
<section class="content-heaer">
       
		  <h3><?php echo $lang_add." ".$lang_op_settings;?></h3>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table width="90%">
                            <tr>
                        	
								
								<td><?php echo $lang_op_validity_days; ?> <span id='requiredfield'>*</span> : </td>
							
                                 <td><input name="validity_days" id="validity_days" value='' autocomplete="off"onkeypress="nextField(event.keyCode,reg_fee)" /></td>
							
								<td><?php echo $lang_reg_fee; ?> <span id='requiredfield'>*</span> : </td>
											
								<td><input name="reg_fee" id="reg_fee" value='' autocomplete="off"onkeypress="nextField(event.keyCode,card_fee)" /></td>
							<td><?php echo $lang_card_fee; ?> <span id='requiredfield'>*</span> : </td>

							<td><input name="card_fee" id="card_fee" value='' autocomplete="off"onkeypress="nextField(event.keyCode,card_expiry)" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_card_validity; ?> <span id='requiredfield'>*</span> : </td>
							<td><input name="card_expiry" id="card_expiry" tabbindex="2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  onkeypress="nextField(event.keyCode,card_expiry_type)" value="" autocomplete="off" size="2"/> 
										<select name="card_expiry_type" onkeypress="nextField(event.keyCode,Add)">

											<option value="Y">Y</option>
											<option value="M" >M</option>
											
										</select> </td>
											
								
							
							   <td>
									<input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="submitform('<?php echo $lang_add;?>','');"/>
								</td>
							</tr>
								
					</table>			
					
			</div>
			<BR />
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_op_settings." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_op_validity_days; ?></a></th>
                                <th><a href="#"><?php echo $lang_reg_fee; ?></a></th> 
				<th><a href="#"><?php echo $lang_card_fee; ?></a></th>
				<th><a href="#"><?php echo $lang_card_validity; ?></a></th> 
				<th><a href="#"><?php echo $lang_op_validity_from; ?></a></th>   
								                             
                                
                            </tr>
						</thead>
						<tbody id="table_body">	
		<?php
			if(!empty($opSettingsinfo)){
				for($i=0;$i<count($opSettingsinfo);$i++) {?>
					<tr>
						<td><?php echo $opSettingsinfo[$i][0];?></td>
						<td><?php echo $opSettingsinfo[$i][1];?></td>
						<td><?php echo $opSettingsinfo[$i][2];?></td>
						<td><?php echo $opSettingsinfo[$i][4];?></td>
						<td><?php echo $opSettingsinfo[$i][5]." ".$opSettingsinfo[$i][6];?></td>
						<td><?php echo $opSettingsinfo[$i][3];?></td>
										
						
						
                           
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
</form>	  
</body>
	</html>
	
