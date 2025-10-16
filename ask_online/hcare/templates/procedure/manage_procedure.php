
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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script>
  
   function submitform(action,id){
   	setAction(action,id);
	
   	document.procedure.action="../../lib/controllers/centralController.php?module=Procedures&sub_module=Manage_Procedure";
	document.procedure.submit();
   }
   
   
</script>

</head>
<body id="frame">
<form name="procedure" id="form"  method="post" action=""> 
<?php
	$procedureInfo=$this->popArr['procedureInfo'];
	$category = $this->popArr['category'];
?>
<section class="content-heaer">
         
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $lang_add." ".$lang_procedure;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_category; ?>
											
											 <select name="category" id="category" keypress="nextField(event.keyCode,Search)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($category)){
								
									for($i=0;$i<count($category);$i++){ ?>									
												
												<option value='<?php echo $category[$i][0];?>' ><?php echo $category[$i][1];?></option>
						<?php			
									}
								}
						?>							
						
						</select>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
										<td id="noborder"><?php echo $lang_procedure; ?>
											
											<input name="procedure" id="procedure" value='' autocomplete="off" />
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
										
									<td id="noborder">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<?php if(!empty($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
			<?php } ?>
				
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_procedure." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_category; ?></a></th>
                                <th><a href="#"><?php echo $lang_procedure; ?></a></th>								
								<th><a href="#"><?php echo $lang_test_amount; ?></a></th> 
								<th><a href="#"><?php echo $lang_details; ?></a></th> 
								<th><a href="#"><?php echo $lang_description; ?></a></th>   
								<th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($procedureInfo)){
				for($i=0;$i<count($procedureInfo);$i++) {?>
					<tr>
						<td><?php echo $procedureInfo[$i][0];?></td>
						<td><?php echo $procedureInfo[$i][1];?></td>
						<td><?php echo $procedureInfo[$i][3];?></td>
						<td><?php echo $procedureInfo[$i][4];?></td>
					    <td><h6>

					       <?php if($procedureInfo[$i][1]!='LABOUR CHARGES'){ ?>

						      <?php echo $lang_hosp_amount;echo str_repeat('&nbsp;', 18);?>: <?php echo $procedureInfo[$i][5];?><br>

                           <?php } ?>

						   <?php if($procedureInfo[$i][2] == 4){?>
						   
						              <?php echo $lang_surgeon_fee;echo str_repeat('&nbsp;', 19);?> : <?php echo $procedureInfo[$i][9];?><br>
									   <?php echo $lang_assistant_fee1;echo str_repeat('&nbsp;', 14);?> : <?php echo $procedureInfo[$i][13];?><br>
									  <?php echo $lang_assistant_fee2;echo str_repeat('&nbsp;', 14);?> : <?php echo $procedureInfo[$i][14];?><br>
						              <?php echo $lang_anethesia_charge;echo str_repeat('&nbsp;', 4);?> : <?php echo $procedureInfo[$i][10];?><br>
									  <?php echo $lang_theatre_charge;echo str_repeat('&nbsp;', 11);?> : <?php echo $procedureInfo[$i][11];?><br>
									  <?php echo $lang_other_charges;echo str_repeat('&nbsp;', 14);?> : <?php echo $procedureInfo[$i][12];?>
									 
						   <?php }elseif($procedureInfo[$i][1]=='LABOUR CHARGES'){?>

                                      <?php echo "GYNEC";echo str_repeat('&nbsp;', 22);?> : <?php echo $procedureInfo[$i][16];?><br>
									  <?php echo "ROOM CHARGES";echo str_repeat('&nbsp;', 5);?> : <?php echo $procedureInfo[$i][17];?>

						   <?php }else {?>
						   
						           <?php echo $lang_dr_amount;echo str_repeat('&nbsp;', 25);?>: <?php echo $procedureInfo[$i][6];?><br>
						   
						   <?php } ?>
						   </h6>
						</td>
                        <td><?php echo $procedureInfo[$i][7];?></td>						
						
						<td>
							<button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $procedureInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						   <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $procedureInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
							</td>
                           
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
	
