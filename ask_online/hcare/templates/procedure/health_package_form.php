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
    
    <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
     <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
 <!-- Select2 -->
   <script src="../../plugins/select2/select2.full.min.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
   });


    $(document).ready(function(){


// $('#group_test').select2().on('change', function() {
//     $('#group_test').select2({data:data[$(this).val()]});
// }).trigger('change');


    // 	 $(".select2").select2();

    
    
    $("select").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
      $(this).data("select2").$container.find(".select2-search__field").focus();
    });
    // $('.select2-search input').prop('focus',false);

	    	});
    
   function submitForm(){
   
   		if(document.package_form.package.value=='') {
   			showDialog('Error','Please Enter Package Name.','error',2);
			return false;
		}else if(document.package_form.amount.value=='') {
   			showDialog('Error','Please Enter Package Amount.','error',2);
			return false;
		}else {
			document.package_form.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=health_checkup_package";
			document.package_form.submit();
		
		}
   
   }

   function updateOrder(){

		document.package_form.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=health_checkup_package_order";
		document.package_form.submit();

   }

</script>

</head>
<body id="frame" onload="document.package.dep_name.focus();">
<form name="package_form" id="form" method="post" action=""> 
<?php
	$action = $this->popArr['action'];
	
	$labTestInfo=$this->popArr['labTestInfo'];
	$labElementInfo=$this->popArr['labElementInfo'];
	$procedureInfo=$this->popArr['procedureInfo'];
	$doctors=$this->popArr['doctors'];
	
	
	if(isset($this->popArr['packageInfo'])){
	
		$packageInfo=$this->popArr['packageInfo'];
		$id=$packageInfo[0][0];
		$package=$packageInfo[0][1];
		$amount=$packageInfo[0][2];
		$description=$packageInfo[0][3];
		$dr_amount=$packageInfo[0][4];
		$doctor_selected=$packageInfo[0][6];
		
		$labTestSelected=$this->popArr['labTestSelected'];
		
		$labElementSelected=$this->popArr['labElementSelected'];
		$procedureSelected=$this->popArr['procedureSelected'];

		$fullArray = array();
		// $fullArray = array_merge($labTestSelected,$labElementSelected,$procedureSelected);

		$fullArray = array_merge($labTestSelected,$labElementSelected);

		if (!empty($fullArray) ) {


			foreach ($fullArray as $key => $row) {
				$distance[$key] = $row[3];
			}
													
			array_multisort($distance, SORT_ASC, $fullArray);

		}

		
		
	}else{
	
		$id='';
		$package='';
		$description='';
		$amount='';
		$dr_amount='';

		$fullArray = array();
		
		
	}
?>
<div id="content">
            <section class="content-header">
          <h1>
            <?php if($action == $lang_add){ ?>
				
                	<h3 id="<?php echo $lang_add.' '.$lang_package;?>" ><?php echo $lang_add.' '.$lang_package;?></h3><BR />
				<?php }else { ?>
				
					<h3 id="<?php echo $lang_update.' '.$lang_package;?>"><?php echo $lang_update.' '.$lang_package;?></h3><BR />
					
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
                       <h3 class="box-title"><?php echo $lang_package." ".$lang_information;?></</h3>
					    
                    </div>	
                    <div class="box-body">
							
					<table  class="table table-striped">
                      <tr>
					
						<td><?php echo $lang_package; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="package" id="package"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,group_test)" value="<?php echo $package; ?>" autocomplete="off"/>
						</td>
					</tr>
					<tr>
					<td><?php echo $lang_group_test; ?></td>
					<td> <select name="group_test[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Group Test" style="width: 100%;">
					
					    <?php 


				           	if ($action=="UPDATE") {
					           		
					           	for ($i=0; $i < count($labTestSelected) ; $i++) { ?>

					           			<option value="<?php echo $labTestSelected[$i][0];?>" selected><?php echo $labTestSelected[$i][2];?></option>

					           	<?php
					           	}

					        }

					    if(!empty($labTestInfo)){
					    
					           for($i=0;$i<count($labTestInfo);$i++){?>
						      <option value="<?php echo $labTestInfo[$i][0];?>"><?php echo $labTestInfo[$i][1];?></option>
					    <?php  }
					       }
					      ?>
                                            
                                             </select>   
		                        </td>
					</tr>
					<tr>
					<td><?php echo $lang_elements; ?></td>
					<td> <select name="elements[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Elements" style="width: 100%;">
                                             <?php 



				           	if ($action=="UPDATE") {
					           		
					           	for ($i=0; $i < count($labElementSelected) ; $i++) { ?>

					           			<option value="<?php echo $labElementSelected[$i][0];?>" selected><?php echo $labElementSelected[$i][2];?></option>

					           	<?php
					           	}

					        }

                                             if(!empty($labElementInfo)){
					    
					           for($i=0;$i<count($labElementInfo);$i++){?>
						      <option value="<?php echo $labElementInfo[$i][0];?>" ><?php echo $labElementInfo[$i][1];?></option>
					    <?php  }
					       }
					      ?>
                                             </select>   
		                        </td>
					</tr>
                                        <tr>
					<td><?php echo $lang_procedure; ?></td>
					<td> <select name="procedure[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Procedure" style="width: 100%;">
                                              <?php 

				           	if ($action=="UPDATE") {
					           		
					           	for ($i=0; $i < count($procedureSelected) ; $i++) { ?>

					           			<option value="<?php echo $procedureSelected[$i][0];?>" selected><?php echo $procedureSelected[$i][2];?></option>

					           	<?php
					           	}

					        }

                                              if(!empty($procedureInfo)){
					    
					           for($i=0;$i<count($procedureInfo);$i++){?>
						      <option value="<?php echo $procedureInfo[$i][0];?>" ><?php echo $procedureInfo[$i][3];?></option>
					    <?php  }
					       }
					      ?>
                                             </select>   
		                        </td>
					</tr>
                                         <tr>
					
						<td><?php echo $lang_amount; ?> <span id='requiredfield'>*</span> : </td>
                                                <td><input name="amount" id="amount" tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $amount; ?>" autocomplete="off"/>
						</td>
					</tr>



                    <tr>
					
						<td><?php echo $lang_doctor; ?> <span id='requiredfield'>*</span> : </td>
                        <td>

                        	<select id="doctor" name="doctor">
                        		
                        		<option value="">--- Please Select ---</option>

                        		<?php 

                        			if (!empty($doctors)) {
                        				
                        				for ($i=0; $i < count($doctors) ; $i++) { ?>

                        					<option value="<?php echo $doctors[$i][0]; ?>" <?php if (!empty($doctor_selected) && ($doctor_selected==$doctors[$i][0]) ) {
                        						echo "selected";
                        					} ?>  ><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>

                        				<?php
                        				}

                        			}

                        		?>

                        	</select>

						</td>
					</tr>

                                        <tr class="normal_procedure">
						<td><?php echo $lang_dr_amount; ?>: </td>
                                                <td><input name="dr_amount" id="dr_amount" tabindex="2"  onkeypress="nextField(event.keyCode,surgeon_fee)" value="<?php echo $dr_amount; ?>" autocomplete="off"/> 
						</td>
					</tr>					
					<?php if($action== $lang_add){?>
					<tr>
						<td><?php echo $lang_description; ?> : </td>
                        <td> <input name="description" id="description"  
                             tabindex="2"  onkeypress="nextField(event.keyCode,Add)" value="<?php echo $description; ?>" autocomplete="off"/>
						</td>
					</tr>	
					<?php }else { ?>
					
						<tr>
						<td><?php echo $lang_description; ?> : </td>
                        <td><input name="description" id="description"  
                             tabindex="2"  onkeypress="nextField(event.keyCode,Update)" value="<?php echo $description; ?>" autocomplete="off"/>
						</td>
					</tr>
					
					<?php } ?>
                      
					
				</table>				
				
				
					<div align="center">
					
					<?php if($action== $lang_add){?>
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					<?php }else { ?>
							<input id="button1" type="button" name="Update" class="btn btn-success" value="Update" onclick="return submitForm()"/>
					<?php } ?>
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>

      <div class="col-md-6">
      			
      		<div class="box box-info">
      				
                <div class="box-header with-border">
                       
                    <h3 class="box-title"><?php echo $lang_package." ORDER";?></</h3>
					    
                </div>

                <div class="box-body">

                	<table class="table table-striped">

                		<thead>
	                		<th>SL NO</th>
	                		<th>ITEMS</th>
	                		<th>TYPE</th>
	                		<th>ORDER</th>
                		</thead>

                		<tbody>
                			
                			<?php

                				if (!empty($fullArray)) {
                						$h=1;
                					for ($i=0; $i < count($fullArray) ; $i++) { ?>
                						
                						<tr>
                							<td><?php echo $h++; ?></td>
                							<td><?php echo $fullArray[$i][2]; ?></td>
                							<td>
                								<?php 

                									if ($fullArray[$i][1]=="LT") {
                										
                										echo "GROUP TEST";

                									}
                									else if ($fullArray[$i][1]=="LE") {
                										
                										echo "ELEMENT";

                									}
                									else if ($fullArray[$i][1]=="P") {
                										
                										echo "PROCEDURE";

                									}

                							 	?>
                							 </td>
                							<td><input type="text" name="order_no[]" class="order_no" value="<?php echo $fullArray[$i][3]; ?>" size="1" style="font-weight: 700;">

                							<input type="hidden" name="package_ids[]" value="<?php echo $fullArray[$i][4]; ?>">
                							<input type="hidden" name="package_test_ids[]" value="<?php echo $fullArray[$i][0]; ?>">

                							</td>
                						</tr>

                					<?php
                					}


                				?>

		                			<tr>
		                				<td colspan="4" style="text-align: center;">
		                					<br>
		                					<input id="button3" type="button" name="update_order" class="btn btn-danger" value="Update Order" onclick="return updateOrder()"/></td>
		                			</tr>
                				
                				<?php 
                				}

                			?>



                		</tbody>

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
	
