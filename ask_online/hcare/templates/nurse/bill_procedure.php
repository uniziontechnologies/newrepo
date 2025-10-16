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
        $('#date').datepicker();
		
	  });
	  </script>
<script type="text/javascript">

$(document).ready(function(){
 
        
 
 	$(".add").bind('click', function() {
		
                       if($("#procedure").val() == ""){

                      }else {
			
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_procedure");
			$("#form").submit();
                     }
		});

       $(".delete").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Procedure Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_procedure");
			               $("#form").submit();
                                }
                }

     });
 });
</script>
</head>
<body id="frame">

<?php

$procedureInfo=$this  ->popArr['procedureInfo'];
$ipProcedure=$this  ->popArr['ipProcedure'];
?>
<form name="procedure" id="form"  method="post" action="">
<section class="content-header">
          <h4> <?php echo $lang_ip." ".$lang_procedure." ".$lang_list; ?></h4>
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 

                                               <tr>
                                                  <td id="noborder"><?php echo $lang_ip_no; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['patient_selected'];?>"></td>
                                                   <td id="noborder"><?php echo $lang_name; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['patient_name'];?>"></td>
                                                    <td id="noborder"><?php echo $lang_age; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['age'];?>"></td>
                                              </tr>
                                              <tr>
                                                   <td id="noborder"><?php echo $lang_gender; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['gender'];?>"></td>
                                            
                                                   <td id="noborder"><?php echo $lang_room; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['room_no'];?> (BED NO:<?php echo $_SESSION['bed_no'];?>)"></td>
                                                   <td id="noborder"><?php echo $lang_doctor; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['doctor'];?>"></td>
                                               </tr>
                                           </table>
				</div>
				</div>
		<div class="row">
		
		 <div class="col-md-4">
				<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
							<tr>
								<td id="noborder"><?php echo $lang_date; ?>:</td>
								<td id="noborder" >	
									<input type="text" name="date" id="date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
								</td>
                                                       </tr>

                                                       <tr>
								<td id="noborder"><?php echo $lang_procedure; ?></td>
								<td id="noborder" >	
											
											 <select name="procedure" id="procedure" keypress="nextField(event.keyCode,Search)" />
						  
						  		<option value=''>------------------------</option>
						<?php
								if(!empty($procedureInfo)){
								
									for($i=0;$i<count($procedureInfo);$i++){ ?>									
												
												<option value='<?php echo $procedureInfo[$i][0];?>' ><?php echo $procedureInfo[$i][3];?></option>
						<?php			
									}
								}
						?>							
						
						</select>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>

                                                       </tr>
                                                       <tr>
                                                             <td id="noborder">
									&nbsp;&nbsp;
								<input id="button1" type="button" name="add"  value="ADD"class="add btn btn-success" /></td>
								</tr>
                        </table>
					</div>
				</div>
			</div>
			 <div class="col-md-6">
               
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">
			        <table class="table table-bordered table-striped">                 
				          <thead>
					     <tr>
                                                 <th ><a href="#"><?php echo $lang_id; ?></a></th>                            	              
                                                 <th><a href="#"><?php echo $lang_procedure; ?></a></th> 
						 <th><a href="#"><?php echo $lang_date; ?></a></th> 
						 <th><a href="#"><?php echo $lang_user; ?></a></th>   
						 <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($ipProcedure)){
                               $j=1;
				for($i=0;$i<count($ipProcedure);$i++) {?>
					<tr>
                                                <td><?php echo $j++;?></td>
						<td><?php echo $ipProcedure[$i][2];?></td>
						<td><?php echo $ipProcedure[$i][4];?></td>						
						<td><?php echo $ipProcedure[$i][8];?></td>
						
					<?php if($ipProcedure[$i][5] ==0){	?>			
						
						<td>
							  <a href="#" class="delete btn btn-danger btn-flat" id="<?php echo $ipProcedure[$i][0];?>"><i class='fa fa-remove'></i></a>
							</td>
					<?php }else{ ?>
					           <td> <p class="text-red"><strong>Deleted</strong></p>
							   Reason:<?php echo $ipProcedure[$i][9];?>
							    </td>
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
	</section>
          
<input type="hidden" name="del_details" id="del_details">
<input type="hidden" name="id" id="id">
</form>
</body>
</html>
