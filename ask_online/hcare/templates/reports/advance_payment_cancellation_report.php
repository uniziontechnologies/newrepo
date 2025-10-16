
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
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
			$('.hide_div').hide();
	  });
</script>
<script>
	
  
   
   function submitform(action,id){
   	
	 
		//setAction(action,id);
		document.manage_bill.paction.value=action;
		document.manage_bill.billid.value=id;
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.ipno.value='';
			document.manage_bill.user_type.value='';
			document.manage_bill.user.value='';
			
			
		}
		

		
		document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=advance_payment_cancellation_report";
		document.manage_bill.submit();
			
		
		
   }

    function clear_form(){

   		window.location.href ="../../lib/controllers/centralController.php?module=Report&sub_module=advance_payment_cancellation_report";

   }

   function printit(){  

     alert('Printing..Please make Printer and Paper Ready');
					if (window.print) {
					   window.print();  
					} else {
					   var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
					document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
					   WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = "";  
					}
   }

   function download_pdf(){
   	$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Advance Payment Cancellation Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		// document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		// document.manage_bill.submit();

   }
   
   
</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 
<?php
	
	$billInfo=$this ->popArr['billInfo'];
	
	$post=$this  ->popArr['post'];
	$user_type=$this  ->popArr['user_type'];
	$user=$this  ->popArr['user'];

?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_billing; ?></h4>
		  
        </section>
 
		<section class="content">
		 <div class="DONTPrint">		 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
											
										</td>
										<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	 <input type="text" name="ipno" id="ipno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" /> 	 
									</td>
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							</td>
										
								</tr>
								<tr>

								<td id="noborder">
							    <?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($user_type);$i++){ 
																						
													if(!empty($post['user_type']) && $post['user_type']==$user_type[$i][0]) { ?>
													
														<option value='<?php echo $user_type[$i][0];?>' selected><?php echo $user_type[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user_type[$i][0];?>'><?php echo $user_type[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">
							<?php echo $lang_user; ?> </td>
								<td id="noborder" ><select name="user" id="user"   onkeypress="nextField(event.keyCode,inc)" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($user);$i++){ 
																						
													if(!empty($post['user']) && $post['user']==$user[$i][0]) { ?>
													
														<option value='<?php echo $user[$i][0];?>' selected><?php echo $user[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user[$i][0];?>'><?php echo $user[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							    </td>
							    </tr>
							    <tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="clear_form();"/>
									</td>
								</tr>
						</table>
				
					</div>

			</div>
        </div>
			<h4 ><?php echo "ADVANCE PAYMENT CANCELLATION LIST"; ?> From 
			       <?php if (!empty($post['from_date'])) {
		                       echo $post['from_date'];
		                 }else echo date('Y-m-d');
                          
                            echo " To ";

		                 if (!empty($post['to_date'])) {
			                    echo $post['to_date'];
		                 }else echo date('Y-m-d'); 
		           ?>
			
			</h4>
			<div class="box box-info">
                
               <div class="box-body">

			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4 ><?php echo "ADVANCE PAYMENT CANCELLATION LIST"; ?> From 
			       <?php if (!empty($post['from_date'])) {
		                       echo $post['from_date'];
		                 }else echo date('Y-m-d');
                          
                            echo " To ";

		                 if (!empty($post['to_date'])) {
			                    echo $post['to_date'];
		                 }else echo date('Y-m-d'); 
		           ?>
			
	</h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>						 
						  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th><a href="#"><?php echo $lang_room_no; ?></a></th>					 	
					       <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th> 
						  <th ><a href="#"><?php echo $lang_amount_paid; ?></a></th>
						   <th ><a href="#"><?php echo $lang_card_amount; ?></a></th>
						   <th ><a href="#"><?php echo $lang_upi; ?></a></th>
						   <th ><a href="#"><?php echo $lang_checque_no; ?></a></th>
						   <th ><a href="#">ENTERED BY</a></th>
						  <th ><a href="#">CANCELLED DETAILS</a></th>
						  <th ><a href="#">CANCELLED DATE</a></th>
						  <th ><a href="#">CANCELLED BY</a></th>
					      
				     </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($billInfo)){
			$j=1;
			$total_paid=0;
			$total_card=0;
			$totalupi_amount=0;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo $billInfo[$i][6];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo	$billInfo[$i][13]."/".$billInfo[$i][12];?></td>
						<td><?php echo $billInfo[$i][8];?></td>
						<td><?php echo $billInfo[$i][9];?></td>
						<td><?php echo $billInfo[$i][2]; ;?></td>
						<td><?php echo $billInfo[$i][3]; ;?></td>
						<td><?php echo $billInfo[$i][4];?></td>
						<td><?php echo $billInfo[$i][20];?></td>
						<td><?php echo $billInfo[$i][5];?></td>
						<td><?php echo $billInfo[$i][19];?></td>
				        <td><?php echo $billInfo[$i][15];?></td>
				        <td><?php echo $billInfo[$i][16];?></td>
				        <td><?php echo $billInfo[$i][18];?></td>		
					</tr>
						
				
		<?php
		           $total_paid=$total_paid+$billInfo[$i][3];
		           $total_card=$total_card+$billInfo[$i][4];
		           $totalupi_amount=$totalupi_amount+$billInfo[$i][20];
		     	}
			
			}		
		?>
		            <tr>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	  <td></td>
		            	  <td align="right"><b>Total</b></td>
		            	  <td><?php echo $total_paid; ?></td>
		            	  <td><?php echo $total_card; ?></td>
		            	  <td><?php echo $totalupi_amount; ?></td>
		            	  <td colspan="3"></td>
		            </tr>

					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="billid" id="billid" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="advance_payment_cancellation" value="advance_payment_cancellation_report" />
 <?php if(!isset($_POST['export']) && empty($post['pdf']))
{?>

	    <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
        </div>
<?php }?>
</form>	  
</body>
	</html>

