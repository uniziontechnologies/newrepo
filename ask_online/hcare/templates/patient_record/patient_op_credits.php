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
	   <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	   
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	<!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/iCheck/all.css">
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
 <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="../../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	 <link rel="stylesheet" href="../../dist/css/ajax.css">
   <script type="text/javascript" src="../../ajax/ajax.js"></script>
   <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
  <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />

  <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
 <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

 <!-- iCheck 1.0.1 -->
    <script src="../../plugins/iCheck/icheck.js"></script>
	 <!-- Slimscroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>


  <script>

  $(document).ready(function(){
	  
	  $(".show_details").bind('click', function() {

        var id=$(this).attr("id");
        tb_show('CREDIT BILLS',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_creditBills&id="+id,'',750,550);
    });

	});

  $(document).ready(function(){
	  
	  $(".show_details1").bind('click', function() {

        var id=$(this).attr("id");
        tb_show('PHARMA CREDIT BILLS',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_pharmacreditBills&id="+id,'',750,550);
    });

	});
  </script>
	
<style type="text/css">

ul.pagination.pagination-sm.no-margin.pull-right {
    float: left !important;
}


</style>


	
<?php
	
$opcreditInfo=$this  ->popArr['opcreditInfo'];
$op_visit_date=$this  ->popArr['op_visit_date'];
$pagination=$this  ->popArr['pagination'];
$current_page=$this  ->popArr['current_page'];
$perPage=$this  ->popArr['perPage'];
$date_selected=$this  ->popArr['date_selected'];

$pharmaCreditInfo=$this  ->popArr['pharmaCreditInfo'];
$total_opcredit=$this  ->popArr['total_opcredit'];
$total_pharmaCredit=$this  ->popArr['total_pharmaCredit']; 
?>

 <section class="content">


    <div class="box box-info">

   	  <div class="row">

   	  	<div class="col-md-offset-2 col-md-2">
   	  		<h4><b>HCARE : <font color="red"><?php echo $total_opcredit;?></font></b></h4>
   	  	</div>
   	  	<div class="col-md-2">
   	  		<h4><b>PCARE : <font color="red"><?php echo $total_pharmaCredit;?></font></b></h4>
   	  	</div>
   	  	<div class="col-md-2">
   	  		
   	  		<select id="visit_date" name="visit_date" class="form-control">
   	  			<option value=""> Please Select </option>
   	  		
              	<?php

   	  				for ($i=0; $i <count($op_visit_date) ; $i++) { ?>
   	  					<option value="<?php echo $op_visit_date[$i][13]; ?>" <?php if (!empty($op_visit_date[$i]) && $op_visit_date[$i][13]==$date_selected ) {
   	  						echo "selected";
   	  					} ?>><?php echo $op_visit_date[$i][20]; ?></option>
   	  				<?php
   	  				}

   	  			?>

                


   	  		</select>

   	  	</div>

   	  	<div class="col-md-3">
   	  		<?php echo $pagination;?>
   	  	</div>

   	  </div>
   </div>

            <div class="box box-info">
            <div class="row">  
            <div class="box-body">
			 <table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#">VISIT ID </a></th>
						  <th ><a href="#" >VISIT DATE</a></th>
						  <th ><a href="#">BILL NO </a></th>
						  <th><a href="#">NET AMT</a></th>
						  <th><a href="#">CREDIT AMT</a></th>	
						  <th><a href="#">BALANCE</a></th>	

					</tr>
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($opcreditInfo)){
			      	$total_amt=0;
			      	$total_credit=0;
			      	$total_balance=0;
			      	$j=(($current_page-1)*$perPage)+1;
						
					for($i=0;$i<count($opcreditInfo);$i++){
				?>
				   <tr>
				       <td><?php echo $i+1;?></td>
					   <td><?php echo $opcreditInfo[$i][1];?></td>
					   <td ><?php echo date("d-m-Y",strtotime($opcreditInfo[$i][2]));?></td>
					   <td><a href="#" class="show_details" id="<?php echo $opcreditInfo[$i][0];?>" ><?php echo $opcreditInfo[$i][0];?></a></td>
					   <td><?php  echo $opcreditInfo[$i][7];?></td>
					   <td><?php  echo $opcreditInfo[$i][9];?></td>
					   <td><?php  echo $opcreditInfo[$i][13];?></td>

				   </tr>
				  
					
			<?php

                  $total_amt=$total_amt+$opcreditInfo[$i][7];
                  $total_credit=$total_credit+$opcreditInfo[$i][9];
                  $total_balance=$total_balance+$opcreditInfo[$i][13];

			 }
			
			  }
			?>
                       <tr>
				    	<td colspan="4" align="right"><b>total</b></td>
				   		<td><b><?php  echo $total_amt;?></b></td>
				   		<td><b><?php  echo $total_credit;?></b></td>
				   		<td><b><?php  echo $total_balance;?></b></td>
				   </tr>
			</tbody>
	     </table>
        </div><!-- /.box-body -->
        </div>
        </div>

    <h3>OP Pharma Credits</h3> 
        <div class="box box-info">

        <div class="row"> 

        <div class="box-body">
		 <table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#">VISIT ID </a></th>
						  <th ><a href="#" >VISIT DATE</a></th>
						  <th ><a href="#">BILL NO </a></th>
						  <th><a href="#">NET AMT</a></th>
						  <th><a href="#">CREDIT AMT</a></th>	
						  <th><a href="#">BALANCE</a></th>	

					</tr>
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($pharmaCreditInfo)){
			      	$total_pharma_amt=0;
			      	$total_pharma_credit=0;
			      	$total_pharma_balance=0;
			      	$j=(($current_page-1)*$perPage)+1;
						
					for($i=0;$i<count($pharmaCreditInfo);$i++){
				?>
				   <tr>
				       <td><?php echo $i+1;?></td>
					   <td><?php echo $pharmaCreditInfo[$i][16];?></td>
					   <td ><?php echo date("d-m-Y",strtotime($pharmaCreditInfo[$i][15]));?></td>
			  <td><a href="#" class="show_details1" id="<?php echo $pharmaCreditInfo[$i][1];?>" ><?php echo $pharmaCreditInfo[$i][1];?></a></td> 
					  
					   <td><?php  echo $pharmaCreditInfo[$i][2];?></td>
					   <td><?php  echo $pharmaCreditInfo[$i][8];?></td>
					   <td><?php  echo $pharmaCreditInfo[$i][11];?></td>

				   </tr>
				  
					
			<?php

                  $total_pharma_amt=$total_pharma_amt+$pharmaCreditInfo[$i][2];
                  $total_pharma_credit=$total_pharma_credit+$pharmaCreditInfo[$i][8];
                  $total_pharma_balance=$total_pharma_balance+$pharmaCreditInfo[$i][11];

			 }
			
			  }
			?>
                       <tr>
				    	<td colspan="4" align="right"><b>total</b></td>
				   		<td><b><?php  echo $total_pharma_amt;?></b></td>
				   		<td><b><?php  echo $total_pharma_credit;?></b></td>
				   		<td><b><?php  echo $total_pharma_balance;?></b></td>
				   </tr>

			   </tbody>
			 </table>
			 
            </div><!-- /.box-body -->
            </div>
	        </div>	

</section>

<input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">


<script type="text/javascript">
	
	  $(document).ready(function() {  	
	
	    $('#inner-content-div').slimScroll({
	        height: '400px'
	    });

	    $('#inner-content-div h4').css('font-size','17px');

	   });

      $(function () {
	  
	  	  $(".next_page").bind('click', function() {

	  	  		 $("#visit_date").val("");
			     var current_page= $("#current_page").val();
				 current_page++;
				 //alert(current_page);
				 $("#current_page").val(current_page);
				 var active_module="patient_op_credits";
				 $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);

				  $("#form").submit();
			  });
		  $(".prev_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");
			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				 var active_module="patient_op_credits";
				 $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });
		   $(".change_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");
			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				 var active_module="patient_op_credits";
				 $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });	

		   $("#visit_date").bind('change', function() {
			  	
			  	var visit_id= $(this).val();
			  	$("#current_page").val("");
			  	$(".pagination").val("");
			    var active_module="patient_op_credits";
			    // alert(active_module+" ||| "+visit_id);return false;
			    $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
			    $("#form").submit();

			  		
					
			  });	

	  });


</script>


