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
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script>
  
   $(document).ready(function(){
   	
	$("#total_bed_no").attr("readonly",true);
	
	if($("#total_bed_no").val() == ''){
	
	   $("#total_bed_no").val("1");
	}
	
   		$("#bed_capacity").bind('change', function() {
		
			if($("#bed_capacity").val() == "MULTIBED"){
			
				$("#total_bed_no").val("");
				$("#total_bed_no").attr("readonly",false);
			}else{
			
				$("#total_bed_no").val("1");
				$("#total_bed_no").attr("readonly",true);
			}
		});
		
		$("#button1").bind('click', function() {
		
			if($("#category").val() == ""){
			
				showDialog('Error','Please Select Room Category.','error',2);
				return false;
			}else if($("#roomno").val() == ""){
			
				showDialog('Error','Please  Enter Valid Room Number.','error',2);
				return false;
			}
			else if($("#bed_capacity").val() == "MULTIBED" && $("#total_bed_no").val() ==""){
			
				showDialog('Error','Please Enter No Of Beds In the Room.','error',2);
				return false;
			}else{
			
				$("#form").attr("action","../../lib/controllers/centralController.php?module=Room&sub_module=Room");
				$("#form").submit();
			
			}
		});
   });
   
   /*function select_bedtype(){
   alert(document.room.total_bed_no.disabled);
   		if(document.room.bed_type.value =='MULTIBED'){
		    alert("1");
			document.room.total_bed_no.disabled = "false"; alert(document.room.total_bed_no.disabled);
		}else if(document.room.bed_type.value =='SINGLE'){
		alert("2");
			document.room.total_bed_no.disabled="true"; alert(document.room.total_bed_no.disabled);
		}
   }*/
</script>

</head>
<body id="frame" onload="document.room.category.focus();">
<form name="room" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	$categoryInfo=$this->popArr['categoryInfo'];
	if(isset($this->popArr['roomInfo'])){
	
		$roomInfo=$this->popArr['roomInfo'];
		$id=$roomInfo[0][0];
		$category=$roomInfo[0][1];
		$roomno=$roomInfo[0][2];
		$bed_capacity=$roomInfo[0][3];
		$total_bed_no=$roomInfo[0][4];
		
		
		
	}else{
	
		$id='';
		$category='';
		$roomno='';
		$bed_capacity='';
		$total_bed_no='';
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_room;?>" ><?php echo $lang_add.' '.$lang_room;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_room;?>"><?php echo $lang_update.' '.$lang_room;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_room;?></h3>
					    
                    </div>	
                    <div class="box-body">
			<table  class="table table-striped">
 
			   <tr>
				<td><?php echo $lang_category; ?> <span id='requiredfield'>*</span> : </td>
                        <!--<input name="category" id="category"  
                        tabindex="2"  onkeypress="nextField(event.keyCode,rent)" value="<?php echo $category; ?>" autocomplete="off"/>-->
						
				<td><select name="category" id="category"   onkeypress="nextField(event.keyCode,roomno)" onChange="nextField(event.keyCode,roomno)" /> 		
						<option value=''>------------------------------</option>
											
							<?php for($i=0;$i<count($categoryInfo);$i++){ 
																						
								if((!empty($post['category']) && $post['category']==$categoryInfo[$i][0]) || (!empty($category) && $category==$categoryInfo[$i][0])) { ?>
													
									<option value='<?php echo $categoryInfo[$i][0];?>' selected><?php echo $categoryInfo[$i][1];?></option>
								<?php   }else {?>
										
									<option value='<?php echo $categoryInfo[$i][0];?>'><?php echo  $categoryInfo[$i][1];?></option>
												
							<?php 		} 
							} ?>
				</select>
				</td>
			</tr>
			<tr>
						
				<td><?php echo $lang_room_no; ?> : </td>
                               <td><input name="roomno" id="roomno"  
                                    tabindex="2"  onkeypress="nextField(event.keyCode,bed_capacity)" value="<?php echo $roomno ?>" autocomplete="off"/>
				</td>
			</tr>
			<tr>	
				<td><?php echo $lang_bed_capacity; ?> : </td>
				<td><select name="bed_capacity" id="bed_capacity"    /> 		
									
							<option value='SINGLE' <?php echo (!empty($bed_capacity) && $bed_capacity=="SINGLE")?'selected':'';?>>SINGLE</option>
									<option value='MULTIBED' <?php echo (!empty($bed_capacity) && $bed_capacity=="MULTIBED")?'selected':'';?>>MULTIBED</option>
				   </select>
				</td>
			</tr>
			<tr>		  
			
					<?php if($action== $lang_add){?>
					
						<td><?php echo $lang_bed_no; ?> : </td>
                                              <td> <input name="total_bed_no" id="total_bed_no" tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="<?php echo $total_bed_no ?>" autocomplete="off" size="5" /></td>
						
					<?php }else { ?>
					
						<td><?php echo $lang_bed_no; ?> : </td>
                                                <td> <input name="total_bed_no" id="total_bed_no" tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo $total_bed_no ?>" autocomplete="off" size="5" /></td>
					
					<?php } ?>
                       	</tr>						
						
					   
							
				
				
					<tr>
					 <td colspan="2"align="center">
					
					<?php if($action== $lang_add){?>
                     		             <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" />
					<?php }else { ?>
					     <input id="button1" type="button" class="btn btn-success" name="Update" value="Update" />
					<?php } ?>
				      </td>
				   </tr>
			</table>	
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
     </section>
    </div>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
</form>	  
</body>
	</html>
	
