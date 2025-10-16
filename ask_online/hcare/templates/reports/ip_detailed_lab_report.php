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
   <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
   <script language="javascript">
   $(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
    </script>
</head>
<?php
$patientInfo=$this->popArr['patient_info'];
$resultInfo=$this->popArr['resultInfo'];

?>
<body id="frame">
<form name="opsheet" id="form"  method="post" action=""> 
<div id="wrapper">
   <div id="content" >
     <table width ="90%"  align="center">
     
        <tr>
						
		<td id="noborder" colspan="2">
			 <?php echo $lang_name; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];?>
		</td>
		<td id="noborder">
			<?php echo $lang_age; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][4]." ".$patientInfo[0][6];?>
		</td>
		 <td><?php echo $lang_room_no; ?> : <?php echo $patientInfo[0][37];?></td>
	</tr>
	<tr>
		<td id="noborder" colspan="2">
			<?php echo $lang_doctor; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][17]." ".$patientInfo[0][18];?>
		</td>
		<td id="noborder">
		 <?php echo $lang_place; ?>&nbsp;:&nbsp;<?php echo $patientInfo[0][8];?>
		</td>
		<td> <?php echo $lang_doa; ?> : <?php echo $patientInfo[0][20];?></td>
	</tr>
	<tr>
		
		<td> <?php echo $lang_dod; ?> : <?php echo ($patientInfo[0][22] == '0000-00-00'?'':$patientInfo[0][22]);?></td>
	</tr>
    </table>
    <br>			
                 <table align="center" width="90%" class="table-bordered" id="datatable">
			<tr>
			    <td>SL</td>
			    <td>TEST</td>
			    <td>VALUE</td>							
							
			</tr>
		      <?php
		      
		         if(!empty($resultInfo)){
			 $j=1;
			    for($i=0;$i<count($resultInfo);$i++){
			     $testInfo=$resultInfo[$i];
			    ?>
			    
			     <tr>
			         
			        
				<?php if($testInfo[$i][4] == 3){ ?>
				    <td><?php echo $j++;?></td>
				    <td><?php echo $testInfo[$i][0];?></td>
				    <td></td>
				<?php }else{ ?>
				 <td></td>
				 <td><?php echo $testInfo[$i][0];?></td>
				 <td><?php echo $testInfo[$i][1];?></td>
				<?php } ?>
			     </tr>
			<?php
			    
			    }
			}
			?>
		 </table>