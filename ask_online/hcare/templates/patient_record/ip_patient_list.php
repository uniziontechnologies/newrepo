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
	  
	  $(".view_patient_record").bind('click', function() {
	  
	      $("#id").val($(this).attr("id"));
	      var value=$("#id").val();
	      $("#summary").val("ip_summary");
	      $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record");
		  $("#form").submit();
	  });
	   $("#search").bind('click', function() {
	  
	      $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_Patient_Records");
		  $("#form").submit();
	  });
	  $(".next_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_Patient_Records");
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  
			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_Patient_Records");
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  
			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_Patient_Records");
				 $("#form").submit();
			  });		
	  });
	  </script>
		

<script>
	
  
  
</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['post'];
	$pagination=$this  ->popArr['pagination'];
	$current_page=$this  ->popArr['current_page'];
	$perPage=$this  ->popArr['perPage'];

?>
<section class="content-header">
          <h4><?php echo $lang_search." IP PATIENTS"; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
								<tr>
										
										<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	<input name="ipno" id="ipno" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" autocomplete="off"/>
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
								
								<?php echo $lang_contact_no; ?> : </td>
													
							<td id="noborder"  >	 <input type="text" name="contact_no" id="contact_no"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" /> 	 
							</td>
							
								
								</tr>
								<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="search" type="button" name="Search" value="Search"  class="btn btn-success" />
									
									</td>
								</tr>
						</table>
				
					</div>
			</div>
       			
                	<h3>
						<?php echo"IP PATIENT ".$lang_list; ?>
						</a>
                       
					
					</h3>
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                 <div class="box-header">
                  <div class="box-tools">
				   <?php echo $pagination;?>
				  </div>
               </div>	
               <div class="box-body">
			     <table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						<th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
						<th width="10%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
					    <th width="10%"><a href="#"><?php echo 'DISCHARGED ON'; ?></a></th>				
				        <th><a href="#"><?php echo $lang_room_no;?></a></th>							
						<th><a href="#"><?php echo $lang_doctor; ?></a></th>						           
                                
                    </tr>
				</thead>
			  <tbody>	

		    <?php
			  if(!empty($patientInfo)){
			    $j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];// $patientInfo[$i][13];?></td>
						
						</td>
						<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						
						<td><?php echo date('d-m-Y',strtotime($patientInfo[$i][20]));?>&nbsp;<?php echo $patientInfo[$i][19];?></td>
						<td><?php echo (($patientInfo[$i][22]=='0000-00-00' || $patientInfo[$i][22]=='1970-01-01')?'':date('d-m-Y',strtotime($patientInfo[$i][22])));?>&nbsp;<?php echo $patientInfo[$i][21];?></td>
						
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
				
							<td>
						
							<a href="#" class="view_patient_record btn btn-info btn-flat" id="<?php echo $patientInfo[$i][13];?>" >VIEW</a>
							
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
           
      </section>
	  <input type="hidden" name="id" id="id" />
	 <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
	 <input type='hidden' name='summary' id='summary' value="summary">
</form>	  
</body>

	</html>
	
