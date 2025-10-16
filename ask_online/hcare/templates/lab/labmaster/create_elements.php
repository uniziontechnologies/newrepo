<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/ajax.css" />

 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script> 

<script>
 
   function submitForm(){
   
   		if(document.elements.element_name.value=='') {
   			showDialog('Error','Please Enter Element Name.','error',2);
			return false;
		}else if(document.elements.category.value=='') {
   			showDialog('Error','Please Select Category.','error',2);
			return false;
		}else if(document.elements.price.value==''){
				showDialog('Error','Please Enter Price.','error',2);
				return false;
		}else if(document.elements.price.value!='' && !(isNumeric(document.elements.price.value))){
				showDialog('Error','Please Enter Numbers For Price.','error',2);
				return false;
		}else {
			document.elements.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Elements";
			document.elements.submit();
		
		}
   
   }
</script>

<style type="text/css">
	.disabled_class{
		backgroud:#dddddd !important;
		cursor: not-allowed;
	}
</style>

</head>
<body id="frame" onload="document.elements.element_name.focus();">
<form name="elements" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$categoryInfo=$this->popArr['categoryInfo'];
	
	if(isset($this->popArr['elementInfo'])){
	
		$elementInfo=$this->popArr['elementInfo'];
		$id=$elementInfo[0][0];
		$element_name=$elementInfo[0][1];
		$category_id=$elementInfo[0][2];
		$normal1=$elementInfo[0][4];
		$normal2=$elementInfo[0][5];
		$normal3=$elementInfo[0][6];
		$normal4=$elementInfo[0][7];
		$normal5=$elementInfo[0][8];
		$normal6=$elementInfo[0][9];
		$unit=$elementInfo[0][10];
		$material=$elementInfo[0][11];
		$price=$elementInfo[0][12];
		$outside=$elementInfo[0][13];
		
		
	}else{
	
		$id='';
		$element_name='';
		$category_id='';
		$normal1='';
		$normal2='';
		$normal3='';
		$normal4='';
		$normal5='';
		$normal6='';
		$unit='';
		$material='';
		$price='';
		$outside='';
		
	}

	$config_obj=new Config_hims();
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_elements;?>" ><?php echo $lang_add.' '.$lang_elements;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_elements;?>"><?php echo $lang_update.' '.$lang_elements;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_elements." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
					
                             <tr>
						
						        <td><?php echo $lang_element_name; ?> <span id='requiredfield'>*</span> : </td>
                                <td><input name="element_name" id="element_name"  
                                     tabindex="2"  onkeypress="nextField(event.keyCode,normal1)"  value="<?php echo $element_name; ?>" autocomplete="off"/ <?php if ($action == 'UPDATE' && ($elementInfo[0][0]== $config_obj->mantox_id) ) {
                                     	echo "readonly";
                                     	echo " class='disabled_class'";
                                     } ?> ></td>
						
						
                       	     </tr>	
							 <tr>
							
							 <td><?php echo $lang_category; ?> <span id='requiredfield'>*</span> : </td>
							  <td>
							 <select name="category" id="category"  nkeypress="nextField(event.keyCode,spec_id)" onchange="changeaction()" />
						  
						  		<option value=''>------------------------</option>
						      <?php
								if(!empty($categoryInfo)){
								
									for($i=0;$i<count($categoryInfo);$i++){ 
										
										if(($category_id==$categoryInfo[$i][0])){	
							?>
											<option value='<?php echo $categoryInfo[$i][0];?>' selected><?php echo $categoryInfo[$i][1];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $categoryInfo[$i][0];?>' ><?php echo $categoryInfo[$i][1];?></option>
						<?php			}
									}
								}
						?>							
						
						</select>
						</td>
							 
							 </tr>
							 <tr>
						
						        <td><?php echo $lang_normal1; ?> : </td>
						
                                <td><input name="normal1" id="normal1"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,normal2)"  value="<?php echo $normal1; ?>" autocomplete="off"/>
						
								</td>
							</tr>
						
					     <tr>
						
						        <td><?php echo $lang_normal2; ?> : </td>
						
                                <td><input name="normal2" id="normal2"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,normal3)"  value="<?php echo $normal2; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							 <tr>
						
						        <td><?php echo $lang_normal3; ?> : </td>
						
                                <td><input name="normal3" id="normal3"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,normal4)"  value="<?php echo $normal3; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							 <tr>
						
						        <td><?php echo $lang_normal4; ?> : </td>
						
                                <td><input name="normal4" id="normal4"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,normal4)"  value="<?php echo $normal4; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							 <tr>
						
						        <td><?php echo $lang_normal5; ?> : </td>
						
                                <td><input name="normal5" id="normal5"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,normal6)"  value="<?php echo $normal5; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							 <tr>
						
						        <td><?php echo $lang_normal6; ?> : </td>
						
                                <td><textarea rows="3" cols="12" name="normal6" id="normal6"><?php echo $normal6; ?></textarea> 
								</td>
							</tr>
							<tr>
						</table>
						</div>
					</div>
					</div>
					
						 <div class="col-md-6">	
						    <div class="box box-info">
						        <div class="box-body">
							       <table  class="table table-striped">
						        <td><?php echo $lang_unit; ?> : </td>
						
                                <td><input name="unit" id="unit"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,material_cost)"  value="<?php echo $unit; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							<tr>
						
						        <td><?php echo $lang_material_cost; ?> : </td>
						
                                <td><input name="material_cost" id="material_cost"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,price)"  value="<?php echo $material; ?>" autocomplete="off"/>
						
								</td>
							</tr>
							<tr>
						
						        <td><?php echo $lang_price; ?> : </td>
						
                                <td><input name="price" id="price"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,outside)"  value="<?php echo $price; ?>" autocomplete="off"/>
						
								</td>
							</tr>
                      		
				           <td><?php echo $lang_outside; ?> : </td>
						
                                <td><input type="checkbox" name="outside" id="outside"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,button1)" <?php echo ($outside ==1)?'checked':'';?> value="<?php echo $outside; ?>" autocomplete="off"/>
						
								</td>
							</tr>
				
					<tr >
                        <td align="center" colspan="2">
					
					     <?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					    <?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
					   <?php } ?>
					</tr>
				  </table>
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
</form>	  
</body>
	</html>
	
