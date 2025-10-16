
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
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  
    <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
        $('#to_date').datepicker();
	  });
	  </script>
<script>
	
     
   function search(){

		document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=accounting_reposting_pcare";
		document.daily_collection.submit();
   }

   function clear_form(){

   		window.location.href = "../../lib/controllers/centralController.php?module=Admin&sub_module=accounting_reposting_pcare";

   }

   function resync_accounting(id){

   		var data = confirm('Are you sure to re-post this ?');

   		if (data==true) {

	        document.daily_collection.id.value=id;
	        // document.daily_collection.amount.value=amount;

			document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=update_accounting_pcare";
			document.daily_collection.submit();

   		}
   		else{
   			return false;
   		}
		

   		// return false;
   }

   
</script>
<style type="text/css">
table.table.table-bordered.table-striped td {
    padding-top: 10px;
    padding-bottom: 10px;
}
</style>
</head>
<body id="frame">
<form name="daily_collection" id="daily_collection"  method="post" action=""> 
<?php
	
	$post             = $this->popArr['post'];
	$pharma_purchase_edited   = $this->popArr['pharma_purchase_edited'];
	// $daily_collection = $this->popArr['daily_collection'];

?>
 <section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped" >
								<tr style="text-align: center;">
									<td id="noborder"><?php echo $lang_from_date; ?>:</td>
									<td id="noborder" >	
										<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
									</td>

									<td id="noborder"><?php echo $lang_to_date; ?>:</td>
									<td id="noborder" >	
										<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
									</td>

									<td id="noborder"><?php echo $lang_bill_no; ?>:</td>
									<td id="noborder" >	
										<input type="text" name="bill_no" id="bill_no"  class="DatePicker" value="<?php echo (!empty($post['bill_no']))?$post['bill_no']:'';?>" />
									</td>

								</tr>
								<tr>
									<td id="noborder" colspan="6" align="center" style="padding-top: 20px;">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="search();"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="clear_form();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			
			<h3 >ACCOUNTING REPOSTING</h3>
					<?php if(isset($post['message'])){?>
						<div id='message' class="callout callout-success"><?php echo $post['message'];?></div>
					<?php } ?>

				<br>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
                        <th ><a href="#"><?php echo $lang_invoice_no; ?></a></th>
                        <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_date; ?></a></th>					 	
						<th ><a href="#"><?php echo $lang_supplier; ?></a></th>
						<th ><a href="#"><?php echo $lang_payment_mode; ?></a></th>	
						<th ><a href="#"><?php echo $lang_net_total; ?></a></th>	
						<th ><a href="#"><?php echo "STATUS"; ?></a></th>  
						<th ><a href="#"><?php echo $lang_action; ?></a></th>    
                    </tr>
				</thead>
				<tbody>	
					
					<?php 

						if (!empty($pharma_purchase_edited)) {
							
							$j=1;

							for ($i=0; $i <count($pharma_purchase_edited) ; $i++) { ?>
									
								<tr>

									<td><?php echo $j++; ?></td>
									<td><?php echo $pharma_purchase_edited[$i][8]; ?></td>
									<td><?php echo $pharma_purchase_edited[$i][9]; ?></td>
									<td><?php echo date("d-m-Y",strtotime($pharma_purchase_edited[$i][6])); ?></td>
									<td><?php echo $pharma_purchase_edited[$i][10]; ?></td>
									<td><?php echo $pharma_purchase_edited[$i][14]; ?></td>
									<td><?php echo $pharma_purchase_edited[$i][4]; ?></td>
									<td><?php echo "<b style='color:red'>Mismatch</b>"; ?></td>

									<td>
										<button class="btn btn-danger" id="resync_acc" name="resync_acc[]" value="<?php echo $pharma_purchase_edited[$i][0]; ?>" onclick="return resync_accounting('<?php echo $pharma_purchase_edited[$i][8]; ?>','<?php echo $pharma_purchase_edited[$i][6]; ?>');" ><i class="fa fa-refresh"></i></button>
									</td>


								</tr>
								

							<?php
							}

						}


					?>


				</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="amount" id="amount" value="">
	  <input type="hidden" name="paction" id="paction" value="">
</form>	  

</body>
	</html>
	
