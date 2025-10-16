<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
 <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>


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
<script type="text/javascript">

function select_patient(opno,doc_id,op_visit_id){
    
   $("#pid").val(opno);
   $("#doc_id").val(doc_id);
   $("#op_visit_id").val(op_visit_id);


   $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=op_case_sheet");
   $("#form").submit();

}

function search_form(){

    $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=op_patient_list");
    $("#form").submit();
}

function clear_form(){

	$("#opno").val('');
	$("#first_name").val('');
	$("#place").val('');
	$("#doctor").val('');

    $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=op_patient_list");
    $("#form").submit();

}
</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php

	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$doctors=$this  ->popArr['doctors'];

        
?>
<section class="content-header">
          <h4> <?php echo $lang_search." ".$lang_op_patients; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 
								<tr>
										
									
								<td id="noborder">
										<?php echo $lang_op_no; ?></td>
								<td id="noborder" >	<input name="opno" id="opno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" autocomplete="off"/>
									</td>
					
								
								<td id="noborder">
									<?php echo $lang_first_name; ?></td>
									<td id="noborder" >	 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['first_name']))?$post['first_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">							
								
								<?php echo $lang_place; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" /> 	 
							</td>
							
							<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
						
							</tr>
							<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" class="search" onclick="search_form();" value="Search" />

									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="clear_form();">

									</td>
							</tr>
						</table>
				
					</div>
			</div>
				<h3 >
						<?php echo $lang_op_patients." ".$lang_list; ?>
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
       			-
				<thead>
					<tr>
                        <th><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#"><?php echo $lang_op_no; ?></a></th>
                        <th><a href="#"><?php echo $lang_token_no; ?></a></th>
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th><a href="#"><?php echo $lang_age; ?></a></th>	
						<th><a href="#"><?php echo $lang_gender; ?></a></th>  			  
                        <th><a href="#"><?php echo $lang_place; ?></a></th>
						<th><a href="#"><?php echo $lang_date; ?></a></th>
						<th><a href="#"><?php echo $lang_time; ?></a></th>	
                        <th><a href="#"><?php echo $lang_visit_status; ?></a></th>
	                    <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						<th><a href="#"><?php echo $lang_action; ?></a></th> 
                    </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr <?php echo(!empty($patientInfo[$i][32])&&$patientInfo[$i][32]=="REVISIT")?'class="revisit"':""; ?> >
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
									
						<td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
			
						<td>
						<a href="#" class="select_patient btn btn-info btn-flat" id="select_patient" onclick="select_patient('<?php echo $patientInfo[$i][0];?>','<?php echo $patientInfo[$i][14];?>','<?php echo $patientInfo[$i][13];?>');">SELECT</a>
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

	  <input type="hidden" name="pid" id="pid" />
	  <input type="hidden" name="doc_id" id="doc_id" />
	  <input type="hidden" name="op_visit_id" id="op_visit_id" />
	
  
</form>
</body>
</html>
