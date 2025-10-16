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
	
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../dist/js/jscolor.js"></script>

<script>
  
   function submitForm(){
   
   		if(document.categoryform.category.value=='') {
   			showDialog('Error','Please Enter Room Category Name.','error',2);
			return false;
		}else if(document.categoryform.rent.value =='' ){
				showDialog('Error','Please Enter Valid Rent Amount.','error',2);
				return false;
		}else {
			document.categoryform.action="../../lib/controllers/centralController.php?module=Room&sub_module=RoomCategory";
			document.categoryform.submit();
		
		}
   
   }
</script>

</head>
<body id="frame" onload="document.categoryform.category.focus();">
<form name="categoryform" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	
	if(isset($this->popArr['categoryInfo'])){
	
		$categoryInfo=$this->popArr['categoryInfo'];
		$id=$categoryInfo[0][0];
		$category=$categoryInfo[0][1];
		$rent=$categoryInfo[0][2];
		$ncharge=$categoryInfo[0][3];
		$mcharge=$categoryInfo[0][4];
		$hcharge=$categoryInfo[0][6];
		$bcharge=$categoryInfo[0][7];
		
		
	}else{
	
		$id='';
		$category='';
		$rent='';
		$ncharge='';
		$mcharge='';
		$hcharge='';
		$bcharge='';
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_room.' '.$lang_category;?>" ><?php echo $lang_add.' '.$lang_room.' '.$lang_category;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_room.' '.$lang_category;?>"><?php echo $lang_update.' '.$lang_room.' '.$lang_category;?></h3><BR />
					
				<?php } ?>
           
          </h1>		  
         
        </section>
	<div class="row">
            <div class="col-md-6">
					<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
			</div>
			</div>
					
					<?php if(isset($this->popArr['message'])){?>
					
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
						
					<?php } ?>
   <div class="row">
            <!-- Left col -->
            <div class="col-md-6">	
					<div class="box box-info">
                       <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_room." ".$lang_category;?></h3>
					    
                    </div>	
                    <div class="box-body">
			<table  class="table table-striped">
			        <tr>
    				     <td><?php echo $lang_category; ?> <span id='requiredfield'>*</span> : </td>
                                     <td><input name="category" id="category" tabindex="2"  onkeypress="nextField(event.keyCode,rent)" value="<?php echo $category; ?>" autocomplete="off"/></td>
						
                       	</tr>
			<tr>
						
						<td><?php echo $lang_rent; ?> : </td>
                                                <td><input name="rent" id="rent" tabindex="2"  onkeypress="nextField(event.keyCode,ncharge)" value="<?php echo $rent ?>" autocomplete="off"/></td>
						
						
				
                       	</tr>
                       <tr>
                         
						<td><?php echo $lang_nursing_charges; ?> : </td>
                                                <td><input name="ncharge" id="ncharge" tabindex="2"  onkeypress="nextField(event.keyCode,bcharge)" value="<?php echo ($ncharge == 0 )?'':$ncharge ?>" autocomplete="off"/></td>
					</tr>	
					 <tr>
                         
						<td><?php echo $lang_bystander_charge; ?> : </td>
                                                <td><input name="bcharge" id="bcharge" tabindex="2"  onkeypress="nextField(event.keyCode,mcharge)" value="<?php echo ($bcharge == 0 )?'':$bcharge ?>" autocomplete="off"/></td>
					</tr>	
                  <tr>

                    <?php if($action== $lang_add){?>
					
						<td><?php echo $lang_maintenance; ?> : </td>
                                                <td><input name="mcharge" id="mcharge" tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="" autocomplete="off"/></td>
						
					<?php }else { ?>
					
						<td><?php echo $lang_maintenance; ?> : </td>
                                                <td><input name="mcharge" id="mcharge" tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo ($mcharge == 0 )?'':$mcharge ?>" autocomplete="off"/></td>
					
					<?php } ?>
                  </tr>		
                  		  <!-- Room charge per hour -->
					<tr>
						<?php if($action== $lang_add){?>
						<td><?php echo $lang_observation_charge; ?> : </td>
						<td><input name="hcharge" id="hcharge" tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="" autocomplete="off"/></td>
						<?php }else { ?>
						<td><?php echo $lang_observation_charge; ?> : </td>
						<td><input name="hcharge" id="hcharge" tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo ($hcharge == 0 )?'':$hcharge ?>" autocomplete="off"/></td>
						<?php } ?>
					</tr>
			<tr>
			   <td colspan="2" align="center">
					<?php if($action== $lang_add){?>
                     		        <input id="button1" type="button" name="Add" value="Add" class="btn btn-success" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
					<?php } ?>
					
			   </td>
			</tr>
		</table>
					
	</div>
			
				
   </div>
           
      </div>
    </div>
   </section>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
</form>	  
</body>
	</html>
	
