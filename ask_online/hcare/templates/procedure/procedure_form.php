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
    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
 
   function submitForm(){

   	    var cat_name=$("#category :selected").text();
   
   		if(document.procedure.category.value=='') {
   			showDialog('Error','Please Select Category.','error',2);
			return false;
		}else if(document.procedure.procedure.value=='') {
   			showDialog('Error','Please Enter procedure.','error',2);
			return false;
		}else if((cat_name!='LABOUR CHARGES') && document.procedure.amount.value=='') {
   			showDialog('Error','Please Enter Amount.','error',2);
			return false;
		}else {
			document.procedure.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=Manage_Procedure";
			document.procedure.submit();
		
		}
   
   }
   
	  $(document).ready(function() {  

     procedure_toggle();	  
	  $('#category').change(function(){
	  
	    procedure_toggle();
	  
	  });
      function procedure_toggle(){	
	  
		var category=$('#category').val();
		var cat_name=$("#category :selected").text();
		$('#category_name').val(cat_name);
	
		 if(category == 4) {
		 
		      $(".normal_procedure").hide();
			  $(".theatre_procedure").show();
			  $(".labour_charges_field").hide();

		 }else if(cat_name == 'LABOUR CHARGES') {

		 	  $(".hospital_amount_field").hide();
		 	  $(".normal_procedure").hide();
			  $(".theatre_procedure").hide();
			  $(".labour_charges_field").show();

		 }else{
		 
		          $(".normal_procedure").show();
			  $(".theatre_procedure").hide();
			  $(".labour_charges_field").hide();
		 }
		}
	  });
</script>

</head>
<body id="frame" onload="document.procedure.category.focus();">
<form name="procedure" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	$category = $this->popArr['category'];
	
	
	if(isset($this->popArr['procedureInfo'])){
	
		$procedureInfo=$this->popArr['procedureInfo'];
		$id=$procedureInfo[0][0];
		$category_name=$procedureInfo[0][1];
		$category_id=$procedureInfo[0][2];
		$procedure=$procedureInfo[0][3];
		$amount=$procedureInfo[0][5];
		$description=$procedureInfo[0][7];
		$dr_amount=$procedureInfo[0][6];
		$surgeon_fee=$procedureInfo[0][9];
		$assistant_fee1=$procedureInfo[0][13];
		$assistant_fee2=$procedureInfo[0][14];
		$anethesia_charge=$procedureInfo[0][10];
		$theatre_charge=$procedureInfo[0][11];
		$other_charges=$procedureInfo[0][12];
		$price_type=$procedureInfo[0][15];
		$gynec_fee=$procedureInfo[0][16];
		$room_charges=$procedureInfo[0][17];
		
		
		
	}else{
	
		$id='';
		$category_name='';
		$category_id='';
		$procedure='';
		$dr_amount='';
		$description='';
		$surgeon_fee='';
		$anethesia_charge='';
		$theatre_charge='';
		$other_charges='';
		$gynec_fee='';
		$room_charges='';
		
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h4 id="<?php echo $lang_add.' '.$lang_category;?>" ><?php echo $lang_add.' '.$lang_procedure;?></h4><BR />
				<?php }else { ?>
				
					<h4 id="<?php echo $lang_update.' '.$lang_category;?>"><?php echo $lang_update.' '.$lang_procedure;?></h4><BR />
					
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
                       <h4 class="box-title"><?php echo $lang_procedure." ".$lang_information;?></</h4>
					    
                    </div>	
                    <div class="box-body">
							
					<table  class="table table-striped">
                     <tr>
					
						<td><?php echo $lang_category; ?> <span id='requiredfield'>*</span> : </td>
                        <td><select name="category" id="category"  
                          onkeypress="nextField(event.keyCode,procedure)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($category)){
								
									for($i=0;$i<count($category);$i++){ 
										
										if($category_id == $category[$i][0]){	
							?>
											<option value='<?php echo $category[$i][0];?>' selected><?php echo $category[$i][1];?></option>
											
						<?php            }else { ?>
												
												<option value='<?php echo $category[$i][0];?>' ><?php echo $category[$i][1];?></option>
						<?php			}
									}
								}
						?>							
						
						</select>
                       	</td>
                    </tr>
                     <tr>					
						<td><?php echo $lang_procedure; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="procedure" id="procedure"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,amount)" value="<?php echo $procedure; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="hospital_amount_field">
						<td><?php echo $lang_hosp_amount; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="amount" id="amount" tabindex="2"  onkeypress="nextField(event.keyCode,dr_amount)" value="<?php echo $amount; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="labour_charges_field">
						<td>GYNEC FEE <span id='requiredfield'>*</span> : </td>
                        <td><input name="gynec_fee" id="gynec_fee"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,room_charges)" value="<?php echo $gynec_fee; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="labour_charges_field">
						<td>ROOM CHARGES <span id='requiredfield'>*</span> : </td>
                        <td><input name="room_charges" id="room_charges"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $room_charges; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="normal_procedure">
						<td><?php echo $lang_dr_amount; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="dr_amount" id="dr_amount"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,surgeon_fee)" value="<?php echo $dr_amount; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="theatre_procedure">
						<td><?php echo $lang_surgeon_fee; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="surgeon_fee" id="surgeon_fee"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,assisstant_fee1)" value="<?php echo $surgeon_fee; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="theatre_procedure">
						<td><?php echo $lang_assistant_fee1; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="assistant_fee1" id="assistant_fee1"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,assistant_fee2)" value="<?php echo $assistant_fee1; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="theatre_procedure">
						<td><?php echo $lang_assistant_fee2; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="assistant_fee2" id="assistant_fee2"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,anethesia_charge)" value="<?php echo $assistant_fee2; ?>" autocomplete="off"/> 
						</td>
					</tr>
					
					<tr class="theatre_procedure">
						<td><?php echo $lang_anethesia_charge; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="anethesia_charge" id="anethesia_charge"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,theatre_charge)" value="<?php echo $anethesia_charge; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="theatre_procedure">
						<td><?php echo $lang_theatre_charge; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="theatre_charge" id="theatre_charge"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $theatre_charge; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr class="theatre_procedure">
						<td><?php echo $lang_other_charges; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="other_charges" id="other_charges"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $other_charges; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<?php if($action== $lang_add){?>
					<tr>
						<td><?php echo $lang_description; ?> : </td>
                        <td> <input name="description" id="description"  
                             tabindex="2"  onkeypress="nextField(event.keyCode,price_type)" value="<?php echo $description; ?>" autocomplete="off"/>
						</td>
					</tr>	
					<?php }else { ?>
					
						<tr>
						<td><?php echo $lang_description; ?> : </td>
                        <td><input name="description" id="description"  
                             tabindex="2"  onkeypress="nextField(event.keyCode,price_type)" value="<?php echo $description; ?>" autocomplete="off"/>
						</td>
					</tr>
					<?php } ?>
                     <tr>					
						<td><?php echo $lang_fixed; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input type="checkbox" name="price_type" id="price_type" value="YES" <?php if($action== $lang_add){ echo "checked"; }elseif (!empty($price_type) && $price_type=="YES" ) {
                        	 echo "checked";
                        }?> /></td>
					</tr>
					

                      	</table>			
				
				
					<div align="center">
					
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update"  class="btn btn-success" value="Update" onclick="return submitForm()"/>
					<?php } ?>
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="action" id="action" type="hidden" value="<?php echo $action;?>" />
	   <input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
	   <input type="hidden" name="category_name" id="category_name" value="">
</form>	  
</body>
	</html>
	
