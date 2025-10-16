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

    function searchForm(action,id){
   
   	document.bill_items.action="../../lib/controllers/centralController.php?module=Billing&sub_module=ip_bill_items_list";
	document.bill_items.submit();
   }
       
    function show_bil_item(id,particular,ip_no){	

    	    
          
              tb_show('Update Addon Field',"../../lib/controllers/centralController.php?module=Billing&sub_module=update_ip_addon_field&item_id="+id+"&particular="+particular);
              return false;
		
	}
	 $(document).ready(function(){
     $(".next_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=ip_bill_items_list");
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=ip_bill_items_list");
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  
			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=ip_bill_items_list");
				 $("#form").submit();
			  });
 });
     
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
	$pagination=$this  ->popArr['pagination'];
	$current_page=$this  ->popArr['current_page'];
	$perPage=$this->popArr['perPage'];
	$post=$this->popArr['post'];
  
?>
<section class="content-header">
          <h4><?php echo $lang_addon_bill_items; ?></h4>
		  
        </section>
 
		<section class="content">
			<div class="row">
                   <div class="col-md-9">

            <div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
					
								<tr>
										<td ><?php echo $lang_bill_no; ?>
											
											<input name="bill_no" id="bill_no" value='' autocomplete="off" />
											</td>
											<td ><?php echo $lang_particulars; ?>
											
											<input name="particulars" id="particulars" value='<?php echo $post['particulars'];?>' autocomplete="off" />
											</td>
										
									<td><input id="button1" type="button" name="Search" value="Search"  class="btn btn-success" onclick="searchForm();"/></td>
								</tr>
						</table>
				
					</div>
			</div>				   
			<div class="box box-info">
                <div class="box-header with-border">
                      
					     <div class="box-tools">
				          <?php echo $pagination;?><br>
				          </div>
                    </div>	
               <div class="box-body">
				<table class="table table-bordered table-striped">
				
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_particulars; ?></a></th>
						  <th ><a href="#">UPDATE HISTORY</a></th>
						 
					</tr>
				</thead>
	        <?php
			     if(!empty($billitemInfo)){
					 $k=($current_page -1)*$perPage+1;
                          for($i=0;$i<count($billitemInfo);$i++) {
			?>	
			        <tr>
						<td><?php echo $k++;?></td>
						<td id="noborder"><?php echo $billitemInfo[$i][1]; ?></td>
						<td id="noborder"><?php echo $billitemInfo[$i][2]; ?></td>	
						<td id="noborder"><?php echo $billitemInfo[$i][5]; ?></td>	
						<td id="noborder"><a href="#" onclick="show_bil_item('<?php echo $billitemInfo[$i][0]; ?>','<?php echo $billitemInfo[$i][2]; ?>','<?php echo $billInfo[0][1]; ?>')">update</a></td>	
						
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
			</div>
</div>			
					
			
				
				 </div>
           
      </div>
	  
	    
		  <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
	     
	     
</form>	  
</body>
	</html>
                
