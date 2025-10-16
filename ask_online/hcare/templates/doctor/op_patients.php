
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="10" />
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


<script type="text/javascript">


$(document).ready(function(){

    $(".select_patient").bind('click', function() {

        $("#id").val($(this).attr("id"));

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=op_case_sheet&active_module=presenting_complaints");
   	$("#form").submit();
    });
    $(".consulted").bind('click', function() {
    
          $("#id").val($(this).attr("id"));
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=dr_consulted");
   	$("#form").submit();
    });
 });

</script>

<style type="text/css">
.revisit{
	background-color: #d6b8ad;
}
tr#yesterday {
    background-color: lightgray;
}
</style>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$op_div =  "<div style='display:inline-flex;'><div style='width: 20px;height: 20px;background-color: lightgrey;'><P style='font-size: 12px;padding-top: 5px;padding-left: 30px;'>YESTERDAY</P></div><div style='width: 20px;height: 20px;background-color: #d6b8ad;margin-left: 110px;'><P style='font-size: 12px;padding-top: 5px;padding-left: 30px;'>REVISIT</P></div></div>";
	
?>
<section class="content-header">
          <h4><?php echo $lang_op_patients." ".$lang_list."&nbsp;&nbsp;&nbsp;&nbsp;".$op_div;; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-bordered">
 
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
                                                 <th ><a href="#"><?php echo $lang_token_no; ?></a></th>
						 <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						 <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>  			  
                                                 <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_date; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>	
                         <th width="5%"><a href="#"><?php echo $lang_visit_status; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_health_checkup; ?></a></th>
					         <th><a href="#"><?php echo $lang_select; ?></a></th> 
                                                 <th><a href="#"><?php echo $lang_consulted; ?></a></th>  						 
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr <?php echo(!empty($patientInfo[$i][32])&&$patientInfo[$i][32]=="REVISIT")?'class="revisit"':""; ?> <?php if (date("d-m-Y",strtotime($patientInfo[$i][20]))!=date("d-m-Y")) {
									echo "id=yesterday";
								} ?>>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][0];?></td>
                                                <td><?php echo $patientInfo[$i][36];?></td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?></td>
									
						<td><?php if($patientInfo[$i][58] == 'YES') echo "YES";?></td>
						
					<?php if($patientInfo[$i][42] == 0) { ?>
						<td>
						<a href="#" class="select_patient btn btn-info btn-flat" id="<?php echo $patientInfo[$i][13];?>">SELECT</a>
						</td>
						<td>
						 <input type="checkbox" name="consulted" class="consulted" id="<?php echo $patientInfo[$i][13];?>" value="consulted">
						</td>
                    <?php }else{ ?>  
                          <td ><span class="text-red">CANCELLED</span></td>
						  <td><span class="text-red"><?php echo $patientInfo[$i][43];?></span></td>
                    <?php } ?>					
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
	 <input type="hidden" name="paction" id="paction" />
	 
</form>	  
</body>
	</html>
	
