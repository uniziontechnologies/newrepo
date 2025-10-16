
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


</head>
<body id="frame">
	<form method="post">
		<?php
		$consultation = $this->postarr['consultation'];
		// var_dump($consultation);
		?>
		<section class="content">
		<h3> CONSULTATION STATUS</h3>					 
			<div class="box box-info">                
               	<div class="box-body">
					<table class="table table-striped">
						<tr>
							<th>SL NO</th>
							<th>DOCTOR</th>
							<th>TOT REGISTRATION</th>
							<th>TOT BOOKING</th>
							<th>TOT CONSULTED</th>
							<th>NEXT TOKEN</th>
						</tr>
						<?php
						if($consultation){
							for($i=0;$i<sizeof($consultation['doctors']);$i++){
						?>
						<tr>
							<td><?php echo $i+1?></td>
							<td><?php echo $consultation['doctors'][$i];?></td>
							<td><?php echo $consultation['tot_registration'][$i];?></td>
							<td><?php echo $consultation['tot_booking'][$i];?></td>
							<td><?php echo $consultation['tot_consulted'][$i];?></td>
							<td><?php echo $consultation['next_token'][$i];?></td>					
						</tr>
						<?php
							}
						}
						?>
					</table>
				</div>
			</div>
		</section>
	</form>	 
</body>
</html>
	
