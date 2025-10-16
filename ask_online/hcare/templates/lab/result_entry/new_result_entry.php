
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
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
  
    <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	/*......pagination......*/	
  $(document).ready(function(){
       var old="old";
     $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry&old_data="+old);
                 $("#form").submit();
              });

     $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry&old_data="+old);
                 $("#form").submit();
              });
     $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry&old_data="+old);
                 $("#form").submit();
              });
  });
	  </script>
<script>

   
   function submitform(action,id){
		
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.type.value='';
			document.manage_bill.patient_id.value='';
			// document.manage_bill.status.value='0';
			
		}
		
		if(action =="SEARCH"){
			
			if(document.manage_bill.cust_type=='' && document.manage_bill.patient_id!=''){
				
				showDialog('Error','Please Select Customer Type.','error',2);
			return false;
			}
		}
		
		
			
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry";
		
		document.manage_bill.submit();
		return true;
   }
   
   function show_bill_items(billid){
	     
	      tb_show('BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_bill_items&billno="+billid);
	}
	function result_entry(billno){
		
		 
		  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=result_entry&billno="+billno);
          $("#form").submit();
	}
	function view_result(billno){
		
		 
		  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=print_lab_result&billno="+billno);
          $("#form").submit();
	}
	function edit_result(billno){
		
		 
		  $("#form").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=edit_lab_result&billno="+billno);
          $("#form").submit();
	}
/*..... Older Result Entry .....*/
    function older_result(old) {
       
         document.manage_bill.action="../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry&old_data="+old;
		document.manage_bill.submit();
     
   }

</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	// $user=$this  ->popArr['user'];
/*......pagination......*/	

	$pagination=isset($this ->popArr['pagination']);
    $current_page=isset($this ->popArr['current_page']);
?>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">

 
								<tr>
									
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							          </td>
									 <td id="noborder">
										<?php echo $lang_type; ?></td>
									         <td id="noborder" >	<select name="type">
														<option value ="">------</option>
														<option value ="OP">OP</option>
														<option value ="DIRECT">DIRECT</option>
                                                                                     <option value ="IP">IP</option>
														</select>
									  </td>	
									  
									  <td id="noborder">							
								
										<?php echo $lang_patient_id; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="patient_id" id="patient_id"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['patient_id']))?$post['patient_id']:''?>" /> 	 
							          </td>
									
								</tr>
								<tr>
								
								
								
							       	<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
										</td>
							
							
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success"  onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
	<div style="height: 41px;">		
		<h3 style="display:inline;" >
						<?php echo $lang_billing." ".$lang_list; ?>
						
                      <!--  <a href="../../lib/controllers/centralController.php?module=Lab&sub_module=new_result_entry&old_data=old" style="color: #FF8C00; font-size: 21px; padding-left: 10px;">Older Result Entry </a> -->
					   
					</h3>
	  				
	    <button style="display:inline; float: right;" class="btn btn-warning" onclick="older_result('<?php echo "old"; ?>')">Older Result Entry</button>
	</div>  
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
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>					 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>   
                          
						   				  
					      <th ><a href="#"><?php echo $lang_result_entry; ?></a></th>
					 <th width="10%"><a href="#"><?php echo $lang_action; ?></a></th>
						
					                             
                                
                            </tr>
						</thead>
						<tbody>	
		<?php 
			if(!empty($billInfo)){
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {

					if ( ($billInfo[$i][51]!='P') || ($billInfo[$i][52]=="6" || $billInfo[$i][52]=="7")  ) {

					?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][16];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo strtoupper($billInfo[$i][26])."/";echo ($billInfo[$i][1]=="OP")?$billInfo[$i][19]:$billInfo[$i][2]; ;?></td>
						<td><?php echo $billInfo[$i][3];?></td>
						<td><?php echo $billInfo[$i][11];?></td>
				
				    
					<?php if($billInfo[$i][22] == 0){?>
						<td><a href="#" onclick="result_entry('<?php echo $billInfo[$i][0];?>')"><?php echo $lang_result_entry; ?></a></td>
				<?php }else{ ?>
				       <td class="text-green"><font size="-1"><?php echo $lang_result_ready;?></font></td>
				<?php } ?>
				<td>
				
				       <div class="btn-group">
                                
                                 <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                 <span class="caret"></span>
                                 <span class="sr-only">Toggle Dropdown</span>
                               </button>
                               <ul class="dropdown-menu" role="menu">
                             
                                 <li onclick="show_bill_items('<?php echo $billInfo[$i][0];?>')"><a href="#">SHOW BILL ITEMS</a></li>
								<?php if($billInfo[$i][22] == 1){?> 
								 <li onclick="view_result('<?php echo $billInfo[$i][0];?>')"><a href="#"><?php echo $lang_view_result;?></a></li>
							<?php 
							     // if($_SESSION['user_type'] == "LAB ADMIN"){
							?>	 
								     <li onclick="edit_result('<?php echo $billInfo[$i][0];?>')"><a href="#"><?php echo $lang_edit_result;?></a></li>
								<?php 
							      // }
								} ?>  
                                
                                </ul>
                    </div>
						
							
						</td>
					
				
							
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
				
			
				
            </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	 <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>"> 

</form>	  
</body>
	</html>
	
