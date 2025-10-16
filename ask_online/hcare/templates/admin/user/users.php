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
	
   	document.user.action="../../lib/controllers/centralController.php?module=Admin&sub_module=User";
	document.user.submit();
   }
   
   
</script>

</head>
<body id="frame">
<form name="user" id="form"  method="post" action=""> 
<?php
	$userInfo=$this->popArr['users'];
	$usertype_info=$this->popArr['user_type'];
?>
 
<section class="content-heaer">
       
		  <ol class="breadcrumb"><button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_create_page;?>','');"><i class="fa fa-plus"></i><?php echo $add." ".$lang_user;?></font></button>
           
          </ol>
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
								<tr>
										<td><?php echo $lang_username; ?>
											
											<input name="username" id="username" value='' autocomplete="off"/>
											&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $lang_user." ".$lang_type;?>:
						 					<select name="user_type" id="user_type" onkeypress="nextField(event.keyCode,button1)">
						 					<option value=''>----------------------------</option>
												<?php 		if(!empty($usertype_info)){
																for($j=0;$j<count($usertype_info);$j++){	?>										
											
															<option value='<?php echo $usertype_info[$j][0];?>'><?php echo $usertype_info[$j][1];?></option>
												<?php				
																}
															}
												?>
											</select>
									
									
									<input id="button1" type="button" name="Search"  class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/></td>
								</tr>
						</table>
				
					</div>
			</div>
			<BR />
       			
			<?php if(isset($this->popArr['message'])){?>
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />
			<div class="box box-info">
			
			   <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_user." ".$list; ?></h3>
					    
                    </div>	
                
               <div class="box-body">
			   
			   
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_id; ?></a></th>
                            	<th><a href="#"><?php echo $lang_employee; ?></a></th>
                                <th><a href="#"><?php echo $lang_username; ?></a></th>                                
                                <th ><a href="#"><?php echo $lang_user." ".$lang_type; ?></a></th>                               
                                <th ><a href="#"><?php echo $lang_action; ?></a></th>
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($userInfo)){
				for($i=0;$i<count($userInfo);$i++) {?>
					<tr>
						<td><?php echo $userInfo[$i][0];?></td>
						<td><?php echo $userInfo[$i][1];?></td>
						<td><?php echo $userInfo[$i][3];?></td>						
						<td><?php echo $userInfo[$i][5];?></td>
						<td>
							 <button type="button" class="btn btn-success" onClick="submitform('<?php echo $lang_edit_page;?>','<?php echo $userInfo[$i][0];?>');"><i class="fa fa-edit"></i></button>
						     <button type="button" class="btn btn-danger" onClick="submitform('<?php echo $lang_delete;?>','<?php echo $userInfo[$i][0];?>');"><i class="fa fa-remove"></i></button>
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
	
