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
   
      
   		if(document.test.test_name.value=='') {
   			showDialog('Error','Please Enter Test Name.','error',2);
			return false;
		}else if(document.test.price.value==''){
				showDialog('Error','Please Enter Price.','error',2);
				return false;
		}else if(document.test.price.value!='' && !(isNumeric(document.test.price.value))){
				showDialog('Error','Please Enter Numbers For Price.','error',2);
				return false;
		}else if(document.test.elem_selected.options.length==0){
				showDialog('Error','Please Select Atleast One Test.','error',2);
				return false;
		}else {
			
			for (var i = 0; i < document.test.elem_selected.options.length; i++) { 
                document.test.elem_selected.options[i].selected = true;; 
            }
            // for (var i = 0; i < document.test.sub_cat.options.length; i++) { 
            //     document.test.sub_cat.options[i].selected = true;; 
            // }			
			document.test.action="../../lib/controllers/centralController.php?module=Lab&sub_module=Group_test";
			document.test.submit();
		
		}
   
   }
  
   
</script>
</script>
<script>


function moveSelectOptions(from, to, errorWhenNotSelected) {
//alert(from);
		if (from.selectedIndex == -1) {
			if (errorWhenNotSelected != "") {
				alert(errorWhenNotSelected);
			}
			return;
		}

		var fromLength = from.length;
		var toLength = to.length;
		var selected = new Array();
		var numSelected = 0;

		for (i = fromLength - 1; i>=0; i--) {
			if (from.options[i].selected) {

				selected[numSelected] = from.options[i];
				from.options[i] = null;
				numSelected++;
			}
		}

		for (i = numSelected - 1; i >= 0; i--) {
			to.options[toLength] = selected[i];
			toLength++;
		}
	}
function $(id) {
		return document.getElementById(id);
	}
function assignEmployee(a) {

//alert(a);
if(a==0)
	moveSelectOptions($('elements'), $('elem_selected'), '<?php echo "No Data"; ?>');
	else
	moveSelectOptions($('sub_category'), $('sub_cat'), '<?php echo "No Data"; ?>');

	return false;
}

function removeEmployee(a) {
	if(a==0)
	moveSelectOptions($('elem_selected'), $('elements'), '<?php echo "No Data"; ?>');
	else
	moveSelectOptions($('sub_cat'), $('sub_category'), '<?php echo "No Data"; ?>');
}

function clear_selected() {

	document.getElementById("elem_selected").options.length = 0;
	return false;
}

function reload_page() {
	window.location.reload();
	return false;
}

</script>
</head>
<body id="frame" onload="document.test.test_name.focus();">
<form name="test" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$categoryInfo=$this->popArr['categoryInfo'];
	$elementInfo=$this->popArr['elementInfo'];
	$subCategoryInfo=$this->popArr['subCategoryInfo'];
	
	if(isset($this->popArr['testInfo'])){
	
		$testInfo=$this->popArr['testInfo'];
		$id=$testInfo[0][0];
		$test_name=$testInfo[0][1];
		$category_id=$testInfo[0][3];
		$material=$testInfo[0][5];
		$price=$testInfo[0][2];
		$outside=$testInfo[0][6];
		
		$elementSelected=$this->popArr['elementSelected'];
	    $subCatSelected=$this->popArr['subCatSelected'];
		
		$elemIdSelected=$this->popArr['elemIdSelected'];
	    $subCatIdSelected=$this->popArr['subCatIdSelected'];
		
	}else{
	
		$id='';
		$element_name='';
		$category_id='';
		$material='';
		$price='';
		$outside='';
		
		$elementSelected='';
	    $subCatSelected='';
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_group_test;?>" ><?php echo $lang_add.' '.$lang_group_test;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_group_test;?>"><?php echo $lang_update.' '.$lang_group_test;?></h3><BR />
					
				<?php } ?>
           
          </h1>		  
         
        </section>
 <div class="row">
            <div class="col-md-4">
					<div class="callout callout-info"><?php echo $lang_allfieldrequired; ?></div>
			</div>

			<div class="col-md-8">
					

					<div style='display:inline-flex;margin-top: 16px;'>
						<div style='width: 30px;height: 30px;background-color: green;'>
							
						</div>
						<P style='font-size: 17px;padding-top: 5px;padding-left: 10px;'>ELEMENTS</P>
						<div style='width: 30px;height: 30px;background-color: red;margin-left: 25px;'>
							
						</div>
						<P style='font-size: 17px;padding-top: 5px;padding-left: 10px;'>SUB CATEGORY</P>
					</div>


			</div>
			

			</div>
					
					<?php if(isset($this->popArr['message'])){?>
					
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
						
					<?php } ?>
		<div class="row">
            <!-- Left col -->
            <div class="col-md-4">	
					<div class="box box-info">
                       <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_group_test." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
					
                             <tr>
						
						        <td><?php echo $lang_test_name; ?> <span id='requiredfield'>*</span> : </td>
                                <td><input name="test_name" id="test_name"  
                                     tabindex="2"  onkeypress="nextField(event.keyCode,normal1)"  value="<?php echo  (!empty($test_name))?$test_name:''; ?>" autocomplete="off"/></td>
						
						
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
                     		 <input id="save_test" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					    <?php }else { ?>
							<input id="save_test" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
					   <?php } ?>
					</tr>
				</table>
						</div>
					</div>
					</div>
					
						 <div class="col-md-8">	
						    <div class="box box-info">
						        <div class="box-body">
							       <table  class="table table-striped">
								   <tr>
								      <td><?php echo $lang_elements." &<br> ".$lang_sub_category; ?> <span id='requiredfield'>*</span> : </td>
							  <td>
							 <select name="elements" id="elements"  size="10"  multiple="multiple" style="width:300px; height: 400px;font-size: 17px;"/>
						  
						  		
						      <?php
								if(!empty($elementInfo)){
								
									for($i=0;$i<count($elementInfo);$i++){ 
										
										if(!empty($elementSelected) && in_array($elementInfo[$i][0],$elemIdSelected)){?>

											<option data-type='elements' value='<?php echo $elementInfo[$i][0]."#".'elements';?>' style="color: green;"><?php echo $elementInfo[$i][1];?></option>
											
											
											<?php }else{?>
												
												<option data-type='elements' value='<?php echo $elementInfo[$i][0]."#".'elements';?>' style="color: green;"><?php echo $elementInfo[$i][1];?></option>
							<?php			}
									}
								}
						?>	

						<option disabled></option>
						<option disabled style="color: #fd0000;font-size: 20px;font-weight: 800;"><b>*** SUB CATEGORY ***</b></option>
						<option disabled></option>


						      <?php
							
								if(!empty($subCategoryInfo)){
								
									for($i=0;$i<count($subCategoryInfo);$i++){ 
										
										
										    if(!empty($subCatSelected) && in_array($subCategoryInfo[$i][0],$subCatIdSelected)){?>
											
											<option data-type='sub_category' value='<?php echo $subCategoryInfo[$i][0]."#".'sub_category';?>' style="color: red;"><?php echo $subCategoryInfo[$i][1];?></option>
											<?php }else{?>
												
												<option data-type='sub_category' value='<?php echo $subCategoryInfo[$i][0]."#".'sub_category';?>' style="color: red;"><?php echo $subCategoryInfo[$i][1];?></option>
							<?php			  }
									}
								}
						?>

						
						</select>
						</td>
						<td align="center" width="200" style="vertical-align: middle;">
				              <!-- <input type="button" name="btnAssignEmployee" id="btnAssignEmployee" onClick="assignEmployee(0);" value=" Add >>" class="btn btn-success" ><br><br> -->
				              <!-- <input type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="clear_selected();" value="Clear Selected" class="btn btn-danger"><br><br> -->
				              <!-- <input type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="reload_page();" value="Reload" class="btn btn-primary"> -->

								<a href="#" type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="return assignEmployee(0);" class="btn btn-success">
    								Add <i class="fa fa-plus-square" aria-hidden="true"></i>
								</a>

				                <br><br>
								<a href="#" type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="return clear_selected();" class="btn btn-danger">
    								Clear All Selected <i class="fa fa-trash" aria-hidden="true"></i>
								</a>

								<br><br>
								<a href="#" type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="return reload_page();" class="btn btn-primary">
    								Reload <i class="fa fa-refresh" aria-hidden="true"></i>
								</a>

			            </td>
			       <td>
			              <select size="10" name="elem_selected[]" id="elem_selected" style="width:250px; height: 400px;font-size: 17px;" multiple="multiple">
						  
						  <?php
								if(!empty($elementSelected)){
								
									for($i=0;$i<count($elementSelected);$i++){ 


										if (!empty($elementSelected)) {
											
											for ($i=0; $i < count($elementSelected) ; $i++) { 
												
												if ($elementSelected[$i][2] > 0) {?>
													<option value='<?php echo $elementSelected[$i][2]."#".'elements';?>' selected style="color: green;"><?php echo $elementSelected[$i][3];?></option>
												<?php
												}
												else{?>
													<option value='<?php echo $elementSelected[$i][4]."#".'sub_category';?>' selected style="color: red;"><?php echo $elementSelected[$i][5];?></option>
												<?php
												}

											}

										}

										?>
										
										
												
												
						<?php			
									}
								}
						?>					
						  </select>
				<!--    </td>
					
								   <tr>
								      <td><?php echo $lang_sub_category; ?> <span id='requiredfield'>*</span> : </td>
							  <td>
							 <select name="sub_category" id="sub_category"  size="10"  multiple="multiple" style="width:185px;"/>
						  
						  		
							
						
						</select>
						</td> -->
						<!-- <td align="center" width="300">
				              <input type="button" name="btnAssignEmployee" id="btnAssignEmployee" onClick="assignEmployee(1);" value=" Add >>" ><br><br>
				              <input type="button" name="btnRemoveEmployee" id="btnRemoveEmployee" onClick="removeEmployee(1);" value="<< Remove" >
			            </td> -->
			   <!--     <td>
			              <select size="10" name="sub_cat[]" id="sub_cat" style="width:125px;" multiple="multiple">
						  
						 <?php
								if(!empty($subCatSelected)){
								
									for($i=0;$i<count($subCatSelected);$i++){ ?>
										
										
												
												<option value='<?php echo $subCatSelected[$i][4];?>' selected><?php echo $subCatSelected[$i][5];?></option>
						<?php			
									}
								}
						?>					
						  </select>
				   </td> -->
					
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
	
