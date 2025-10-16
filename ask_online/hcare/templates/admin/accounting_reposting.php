
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
        $('#date').datepicker();
	  });
	  </script>
<script>
	
     
   function search(){

		document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=accounting_reposting";
		document.daily_collection.submit();
   }

   function clear_form(){

   		window.location.href = "../../lib/controllers/centralController.php?module=Admin&sub_module=accounting_reposting";

   }

   function resync_accounting(id,amount){

   		var data = confirm('Are you sure to re-post this ?');

   		if (data==true) {

	        document.daily_collection.id.value=id;
	        document.daily_collection.amount.value=amount;

			document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=update_accounting";
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
	$accountingInfo   = $this->popArr['accountingInfo'];
	$daily_collection = $this->popArr['daily_collection'];

?>
 <section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped" style="margin: 0 auto;width: 40%;">
								<tr style="text-align: center;">
									<td id="noborder" style="width: 5%;"><?php echo $lang_date; ?>:</td>
									<td id="noborder" >	
											<input type="text" name="date" id="date"  class="DatePicker" value="<?php echo (!empty($post['date']))?$post['date']:date('d-m-Y');?>" readonly="true"/>
									</td>
									<td id="noborder" colspan="6" align="center">
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
                        <th ><a href="#"><?php echo "Ledger"; ?></a></th>
						<th ><a href="#"><?php echo $lang_date; ?></a></th>					 	
						<th ><a href="#"><?php echo $lang_total_amount." ( In Ledger )"; ?></a></th>
						<th ><a href="#"><?php echo "HCARE AMOUNT"; ?></a></th>	
						<th ><a href="#"><?php echo "STATUS"; ?></a></th>  
						<th ><a href="#"><?php echo $lang_action; ?></a></th>    
                    </tr>
				</thead>
				<tbody>	
					<?php

						if(!empty($accountingInfo)){

							$j=1;

							for($i=0;$i<count($accountingInfo);$i++) {

								if (!empty($accountingInfo[$i][11]) && $accountingInfo[$i][11]!=0 && ($accountingInfo[$i][10]==35||$accountingInfo[$i][10]==37||$accountingInfo[$i][10]==39||$accountingInfo[$i][10]==373) ) {

								?>	
					                   
								<tr>
									<td><?php echo $j++;?></td>
									<td><?php if ($accountingInfo[$i][10]==35) {
										echo "OP Collection";
									}
									else if ($accountingInfo[$i][10]==37) {
										echo "Theatre Procedure Collection";
									}
									else if ($accountingInfo[$i][10]==39) {
										echo "X-ray Collection";
									}
									else if ($accountingInfo[$i][10]==373) {
										echo "Lab Collection";
									}
									 ?></td>	
									<td><?php echo date("d-m-Y",strtotime($accountingInfo[$i][4])); ?></td>	
									<td><?php echo $accountingInfo[$i][11]; ?></td>	
									<td><?php if ($i==0) {
										echo $daily_collection['op_collection'];
									}
									elseif ($i==1) {
									 	echo $daily_collection['theatre'];
									 }
									elseif ($i==2) {
									 	echo $daily_collection['xray'];
									 }
									elseif ($i==3) {
									 	echo $daily_collection['lab'];
									 } ?></td>	
									<td><?php if ( $accountingInfo[$i][10]==35 && $accountingInfo[$i][11]==$daily_collection['op_collection'] ) {
										echo "<b style='color:green'>Synced</b>";
									}
									else if( $accountingInfo[$i][10]==35 && $accountingInfo[$i][11]!=$daily_collection['op_collection'] ){
										echo "<b style='color:red'>Mismatch</b>";
										$action[$i] = 1;
										$amount[$i] = $daily_collection['op_collection'];
									}
									else if ($accountingInfo[$i][10]==37 && $accountingInfo[$i][11]==$daily_collection['theatre']) {
										echo "<b style='color:green'>Synced</b>";
									}
									else if($accountingInfo[$i][10]==37 && $accountingInfo[$i][11]!=$daily_collection['theatre']){
										echo "<b style='color:red'>Mismatch</b>";
										$action[$i] = 1;
										$amount[$i] = $daily_collection['theatre'];
									}
									else if ($accountingInfo[$i][10]==39 && $accountingInfo[$i][11]==$daily_collection['xray']) {
										echo "<b style='color:green'>Synced</b>";
									}
									else if($accountingInfo[$i][10]==39 && $accountingInfo[$i][11]!=$daily_collection['xray']){
										echo "<b style='color:red'>Mismatch</b>";
										$action[$i] = 1;
										$amount[$i] = $daily_collection['xray'];
									}
									else if ($accountingInfo[$i][10]==373 && $accountingInfo[$i][11]==$daily_collection['lab']) {
										echo "<b style='color:green'>Synced</b>";
									}
									else if($accountingInfo[$i][10]==373 && $accountingInfo[$i][11]!=$daily_collection['lab']){
										echo "<b style='color:red'>Mismatch</b>";
										$action[$i] = 1;
										$amount[$i] = $daily_collection['lab'];
									}
									?></td>	
									<td><?php if ( ($action[$i]==1) && ( date("Y-m-d",strtotime($accountingInfo[$i][4]))!=date("Y-m-d") ) ) {?>
									
										<button class="btn btn-danger" id="resync_acc" name="resync_acc[]" value="<?php echo $accountingInfo[$i][0]; ?>" onclick="return resync_accounting('<?php echo $accountingInfo[$i][0]; ?>','<?php echo $amount[$i]; ?>');" ><i class="fa fa-refresh"></i></button>

									<?php
									}else{echo " - ";} ?></td>

								</tr>		
									
							<?php	
					                              					                  
					        }

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
	
