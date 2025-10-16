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

        tb_show('MEDICINES',"../../lib/controllers/centralController.php?module=Registration&sub_module=show_medicines&id="+id,'',750,550);
    });

	});
  </script>
	



<?php
	
$patientInfo=$this  ->popArr['patient_info'];
$medicine_info=$this  ->popArr['medicine_info'];




?>

<div id="content">
   <div class="box box-info">
                

            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#"><?php echo $lang_date; ?></a></th>
						<th ><a href="#"><?php echo $lang_type; ?></a></th>
						<th><a href="#"><?php echo $lang_doctor; ?></a></th>  
						<th><a href="#"><?php echo $lang_mode; ?></a></th> 
						<th><a href="#"><?php echo $lang_amount; ?></a></th> 
						<th><a href="#"><?php echo $lang_medicines; ?></a></th>  
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($medicine_info)){
					$j=1;	     
					for($i=0;$i<count($medicine_info);$i++){
				?>
				   <tr>
				      <td><?php echo $j++;?></td>
					  <td><?php echo $medicine_info[$i][5];?></td>
					  <td><?php echo $medicine_info[$i][2];?></td>
					  <td><?php echo $medicine_info[$i][30];?></td>
					  <td><?php echo $medicine_info[$i][37];?></td>
					  <td><?php echo $medicine_info[$i][10];?></td>
					  <td><input type="button" class="btn btn-danger btn-sm show_details" name="show_details" id="<?php echo $medicine_info[$i][1];?>" value="Medicines"></td>
					</tr>
	
			<?php }
			
			  }
			?>
			</tbody>
			</table>
            </div><!-- /.box-body -->


<!--   <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Simple collapsible</button>
  <div id="demo" class="collapse">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
  </div> -->





	</div>
</div>


