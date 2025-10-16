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
   
      
   		if(document.category.category_name.value=='') {
   			showDialog('Error','Please Enter Category Name.','error',2);
			return false;
		}else if(document.category.price.value==''){
				showDialog('Error','Please Enter Price.','error',2);
				return false;
		}else if(document.category.price.value!='' && !(isNumeric(document.category.price.value))){
				showDialog('Error','Please Enter Numbers For Price.','error',2);
				return false;
		}else if(document.category.elem_selected.options.length==0){
				showDialog('Error','Please Select Atleast One Test.','error',2);
				return false;
		}else {
			
			for (var i = 0; i < document.category.elem_selected.options.length; i++) { 
                document.category.elem_selected.options[i].selected = true;; 
            }
			document.category.action="../../lib/controllers/centralController.php?module=Lab&sub_module=SubCategory";
			document.category.submit();
		
		}
   
   }
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
function assignElement(a) {

	moveSelectOptions($('elements'), $('elem_selected'), '<?php echo "No Data"; ?>');
	
}

function removeElement(a) {
	
	moveSelectOptions($('elem_selected'), $('elements'), '<?php echo "No Data"; ?>');
	
}

</script>
</head>
<body id="frame" onload="document.category.category_name.focus();">
<form name="category" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	$elementInfo=$this->popArr['elementInfo'];

	if(isset($this->popArr['subCatInfo'])){
	
		$testInfo=$this->popArr['subCatInfo'];
		$id=$testInfo[0][0];
		$category_name=$testInfo[0][1];
		$price=$testInfo[0][2];
		
		
		$elementSelected=$this->popArr['elementSelected'];
		$elemIdSelected=$this->popArr['elemIdSelected'];
	  
		
	}else{
	
		$id='';
		$category_name='';
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
				
                	<h3 id="<?php echo $lang_add.' '.$lang_sub_category;?>" ><?php echo $lang_add.' '.$lang_sub_category;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_sub_category;?>"><?php echo $lang_update.' '.$lang_sub_category;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_sub_category." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							<table  class="table table-striped">
					
                             <tr>
						
						        <td><?php echo $lang_category_name; ?> <span id='requiredfield'>*</span> : </td>
                                <td><input name="category_name" id="category_name"  
                                     tabindex="2"  onkeypress="nextField(event.keyCode,normal1)"  value="<?php echo $category_name; ?>" autocomplete="off"/></td>
						
						
                       	     </tr>

							<tr>
						
						        <td><?php echo $lang_price; ?> : </td>
						
                                <td><input name="price" id="price"  
                                    tabindex="2" onkeypress="nextField(event.keyCode,outside)"  value="<?php echo $price; ?>" autocomplete="off"/>
						
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
				
						 <div class="col-md-6">	
						    <div class="box box-info">
						        <div class="box-body">
							       <table  class="table table-striped">
								   <tr>
								      <td><?php echo $lang_elements; ?> <span id='requiredfield'>*</span> : </td>
							  <td>
							 <select name="elements" id="elements"  size="10"  multiple="multiple" style="width:185px;"/>
						  
						  		
						      <?php
								if(!empty($elementInfo)){
									
									
								
									for($i=0;$i<count($elementInfo);$i++){ 
										
										if(!empty($elementSelected) && in_array($elementInfo[$i][0],$elemIdSelected)){?>
											
											
											<?php }else{?>
												
												<option value='<?php echo $elementInfo[$i][0];?>' ><?php echo $elementInfo[$i][1];?></option>
							<?php			}
									}
								}
						?>							
						
						</select>
						</td>
						<td align="center" width="300">
							<a href="#" type="button" name="btnAssign" id="btnAssign" onClick="assignElement(0);" class="btn btn-success">
    								Add <i class="fa fa-plus-square" aria-hidden="true"></i>
								</a>
				              <!-- <input type="button" name="btnAssign" id="btnAssign" onClick="assignElement(0);" value=" Add >>" >---><br><br>
				              <a href="#" type="button" name="btnRemove" id="btnRemove" onClick="removeElement(0);" class="btn btn-danger">
    								Remove <i class="fa fa-trash" aria-hidden="true"></i>
								</a>
				              <!-- <input type="button" name="btnRemove" id="btnRemove" onClick="removeElement(0);" value="<< Remove" > -->
			            </td>
			       <td>
			              <select size="10" name="elem_selected[]" id="elem_selected" style="width:125px;" multiple="multiple">
						  
						  <?php
								if(!empty($elementSelected)){
								
									for($i=0;$i<count($elementSelected);$i++){ ?>
										
										
												
												<option value='<?php echo $elementSelected[$i][2];?>' selected><?php echo $elementSelected[$i][3];?></option>
						<?php			
									}
								}
						?>					
						  </select>
				   </td>
					
					
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
	
