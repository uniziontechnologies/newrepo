
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
<script>
  
   function submitform(action,id){
   
   	setAction(action,id);
	
   	document.category.action="../../lib/controllers/centralController.php?module=Admin&sub_module=patient_category";
	document.category.submit();
   }
   
   
</script>
<style>
	.fa-users{
		color: green;
		font-size: 25px;
	}
	.btn_member{
		border: 0px;
		background-color: white;
	}
</style>
</head>
<body id="frame">
<form name="category" id="form"  method="post" action=""> 
<?php 
	$catInfo=$this->popArr['PatientCategoryInfo'];
?>
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $lang_patient_category;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">

						<table width="55%">
 
								<tr>
										<td id="noborder"><?php echo $lang_patient_category; ?>
											
											<input name="pati_category" id="pati_category" value='' autocomplete="off" />
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										</td>
										
									<td id="noborder">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onClick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_patient_category." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
       			
       			
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_patient_category; ?></a></th>                                
                                <th ><a href="#"><?php echo $lang_consultation; ?></a></th>                               
                                <th ><a href="#"><?php echo $lang_lab; ?></a></th>
								 <th ><a href="#"><?php echo $lang_test; ?></a></th>
								  <th ><a href="#"><?php echo $lang_pharma; ?></a></th>
								  <th ><a href="#"><?php echo $lang_ip; ?></a></th>
								  <th ><a href="#"><?php echo $lang_reg_fee; ?></a></th>
								  <th ><a href="#"><?php echo $lang_card_fee; ?></a></th>
								  <th ><a href="#"><?php echo 'ONLY FOR MEMBERS'; ?></a></th>
								   <th ><a href="#"><?php echo 'MEMBERS'; ?></a></th>
								   <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr> 
						</thead>
						<tbody>	
		<?php
			if(!empty($catInfo)){
				for($i=0;$i<count($catInfo);$i++) {?>
					<tr>
						<!-- <td><?php //echo $catInfo[$i][0];?></td>
						<td><?php //echo $catInfo[$i][1];?></td>	
						<td><?php //echo $catInfo[$i][6];?></td>	
						<td><?php //echo $catInfo[$i][8];?></td>	
						<td><?php //echo $catInfo[$i][10];?></td>	
						<td><?php //echo $catInfo[$i][12];?></td>							
						<td><?php //echo $catInfo[$i][15];?></td>	 -->

						<td><?php echo $catInfo[$i][0];?></td>
						<td><?php echo $catInfo[$i][1];?></td>	
						<td><?php if($catInfo[$i][5]=='CASH'){echo 'Rs. '.$catInfo[$i][6];}else if($catInfo[$i][5]=='%'){ echo $catInfo[$i][6].' %';}?></td>	
						<td><?php if($catInfo[$i][7]=='CASH'){echo 'Rs. '.$catInfo[$i][8];}else if($catInfo[$i][7]=='%'){ echo $catInfo[$i][8].' %';}?></td>	
						<td><?php if($catInfo[$i][9]=='CASH'){echo 'Rs. '.$catInfo[$i][10];}else if($catInfo[$i][9]=='%'){ echo $catInfo[$i][10].' %';}?></td>	
						<td><?php if($catInfo[$i][11]=='CASH'){echo 'Rs. '.$catInfo[$i][12];}else if($catInfo[$i][11]=='%'){ echo $catInfo[$i][12].' %';}?></td>							
						<td><?php if($catInfo[$i][14]=='CASH'){echo 'Rs. '.$catInfo[$i][15];}else if($catInfo[$i][14]=='%'){ echo $catInfo[$i][15].' %';}?></td>
						<td><?php if($catInfo[$i][16]=='CASH'){echo 'Rs. '.$catInfo[$i][17];}else if($catInfo[$i][16]=='%'){ echo $catInfo[$i][17].' %';}?></td>
						<td><?php if($catInfo[$i][18]=='CASH'){echo 'Rs. '.$catInfo[$i][19];}else if($catInfo[$i][18]=='%'){ echo $catInfo[$i][19].' %';}?></td>


						<td><?php echo $catInfo[$i][13];?></td>	
						<td><?php
						 if($catInfo[$i][13]=='YES'){
						 	?>
						 	<button type="button" class="btn_member" onClick="submitform('<?php echo 'MEMBER';?>','<?php echo $catInfo[$i][0];?>');"><i class="fa fa-users"></i></button>
						 	<?php
						 }
						 ?>	</td>					
						
						<td>
							<button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $catInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						     <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $catInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	
