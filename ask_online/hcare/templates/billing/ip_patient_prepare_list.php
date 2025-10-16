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
     <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 
		  $('.print_bill').click(function(e) {
		  
		   $("#id").val($(this).attr('id'));
		  
		   $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Print_IP_Bill");
           $("#form").submit();
		  });
		   $('.cancel_bill').click(function(e) {
		  
		   $("#id").val($(this).attr('id'));
		   var a=confirm("Do You Really Want to Cancel The Bill?");
		
  		   if(a==true)
   			{
				var details=prompt("Please Enter Cancellation Details:","");
				
				if(details!= null){
					$("#cancellation_details").val(details);
					 $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Cancel_IP_Bill");
                    $("#form").submit();
					
				}else{
				return false;
			}
				

			}else{
				return false;
			}
		  
		  });
	  });
	  </script>
<script type="text/javascript">

      function searchForm(){	
		
		document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=IP_Search";
		document.select_patient.submit();
	}
	function redirect(pid,action){
	    
		document.select_patient.id.value=pid;

		document.select_patient.action="../../lib/controllers/centralController.php?module=Billing&sub_module=update_ip_bill_items"
		
		
		document.select_patient.submit();
	}
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="select_patient" id="form"  method="post" action=""> 
<?php
	
	
		$post=$this  ->popArr['post'];
		$doctors=$this  ->popArr['doctors'];
		$patientInfo=$this  ->popArr['patient_info'];
?>
<section class="content-header">
        
		  
        </section>
 
		<section class="content">
					 
		<h3 ><?php echo $lang_inpatient." ".$lang_list; ?></h3>
		
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">
			
       			
				<thead>
					<tr>
                                  
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						<th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						<th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						<th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						<th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                         <th><a href="#"><?php echo $lang_place; ?></a></th>
						 <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
                         <th width="5%"><a href="#"><?php echo $lang_time; ?></a></th>
						 <th><a href="#"><?php echo $lang_room_no;?></a></th>			
					         
					         
					     <th><a href="#"><?php echo $lang_doctor; ?></a></th>
					        
							<th  width="15%"><a href="#"><?php echo $lang_action; ?></a></th>
										                              
						
                              </tr>
                          </thead>
                          <tbody>
                               
                                       <?php
			if(!empty($patientInfo)){
			$j=1;
				for($i=0;$i<count($patientInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $patientInfo[$i][13];?></td>
						<td><?php echo $patientInfo[$i][15];?></td>
					<td><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>
						
						<td><?php echo $patientInfo[$i][4];?></td>
						<td><?php echo $patientInfo[$i][6];?></td>
						<td><?php echo $patientInfo[$i][8];?></td>
						<td><?php echo $patientInfo[$i][20];?></td>
						<td><?php echo $patientInfo[$i][19];?></td>
						<td><?php echo $patientInfo[$i][37]."(BED:".$patientInfo[$i][38].")";?></td>
						<td><?php echo $lang_dr.". ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>

						<td><?php
						   if($patientInfo[$i][51] == 2){?>
						   
						      <a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>')">Update Bill Items</a>
						      
                        </td>
					<?php  }
						?>
						
				        </tr>
		       <?php       }
		             }
		        ?>
                                       
                          </tbody>
                        </table>
                        
                         
           
          
			</div>
				</div>
				
				
				 </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
           <input type="hidden" name="request_from" id="request_from" value="<?php echo (!empty($post['request_from']) )?$post['request_from']:'';?>"/>
	  
	
</form>	  
</body>
	</html>
                
