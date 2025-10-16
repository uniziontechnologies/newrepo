<?php session_start();
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
$comm_obj= new CommonFunctions();
?>
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
	
    <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
     
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
   <script type="text/javascript" src="../../dist/js/thickbox.js"></script>
   <script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
       
    function searchForm(id,particular,ip_no){	

    	      $('#item_id').val(id);
              $('#particular').val(particular);
          
          tb_show('Update New Field',"../../lib/controllers/centralController.php?module=Billing&sub_module=update_new_field&item_id="+id+"&particular="+particular+"&ip_no="+ip_no);
              return false;
		// document.bill_items.action="../../lib/controllers/centralController.php?module=Billing&sub_module=update_new_field";
		// document.bill_items.submit();
	}
     
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="bill_items" id="form"  method="post" action=""> 
<?php
			
    $billInfo =$this->popArr['billInfo'];
    $billitemInfo =$this->popArr['billitems'];
  
?>
<section class="content-header">
          <h4><?php echo $$lang_update." ".$lang_bill_items; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
	        <?php
			     if(!empty($billitemInfo)){
                          for($i=0;$i<count($billitemInfo);$i++) {
			?>	
			        <tr>
							
						<td id="noborder"><?php echo $billitemInfo[$i][2]; ?></td>	
						<td id="noborder"><a href="#" onclick="searchForm('<?php echo $billitemInfo[$i][0]; ?>','<?php echo $billitemInfo[$i][2]; ?>','<?php echo $billInfo[0][1]; ?>')">update</a></td>	
						
					</tr>
			<?php

			     	}
			?>
                      
			<?php
				}
                 
			?>	        	
								</table>
				</div>
			</div>
				
					
			<div class="box box-info">
                
               <div class="box-body">
			       
                        
                         
           
          
			</div>
				</div>
				
				
				 </div>
           
      </div>
	  
	     <input type="hidden" name="item_id" id="item_id" value="">
	     <input type="hidden" name="particular" id="particular" value="">
	      <input type="hidden" name="ip_no" id="ip_no" value="<?php echo $billInfo[0][1]; ?>">
	     
</form>	  
</body>
	</html>
                
