<?php
	
	$billInfo=$this ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];
	$user_type_logged_in=$_SESSION['user_type'];

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
    <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
   <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>


<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="../../plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>

 <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 $(".timepicker").timepicker({showInputs: false,defaultTime: false});
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
			document.manage_bill.from_time.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.to_time.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.ipno.value='';
			document.manage_bill.user.value='';
			document.manage_bill.user_type.value='';
			
			
		}
		if(action == "PRINT"){
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Advance_Bill";
		}else{
		
			if(action == "DELETE"){

				var a=confirm("Do You Really Want to Delete The Bill?");
		
  		 if(a==true)
   			{
				var details=prompt("Please Enter Cancellation Details:","");
				
				if(details!= null){
					document.manage_bill.cancellation_details.value=details;
					
				}else{
				return false;
			}
				

			}else{
				return false;
			}
			}
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=ip_advance_payments_report";
		}
		document.manage_bill.submit();
		return true;
   }
//print
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
					filename: "Ip Advanced Payments Report",
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
										<span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>	
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>

										</td>
										<td id="noborder">
										<?php echo $lang_ip_no; ?></td>
									<td id="noborder" >	 <input type="text" name="ipno" id="ipno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" /> 	 
									</td>
									
								</tr>
							<tr>
							    <td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							    </td>
										
							    <td id="noborder">
								  <?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
							    <td id="noborder" ><select name="user_type" id="user_type"
							      onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/>

                                  <?php if($user_type_logged_in =="ADMIN" || $user_type_logged_in =="ADMIN+DOCTOR" || $user_type_logged_in =="LAB ADMIN"){ ?>								
									<option value=''>---------------</option>
								  <?php } ?>
											
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
									<option value=''>------------</option>
											
											<?php for($i=0;$i<count($user);$i++){ 
																						
													if(!empty($post['user']) && $post['user']==$user[$i][0]) { ?>
													
														<option value='<?php echo $user[$i][0];?>' selected><?php echo $user[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $user[$i][0];?>'><?php echo $user[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							    </td>
								<td><select name="bill_status">
									
									<option value ="0" <?php echo (isset($post['bill_status']) && $post['bill_status']=='0')?'selected':'';?>>Active</option>
									<option value ="1" <?php echo (isset($post['bill_status']) && $post['bill_status']=='1')?'selected':'';?>>Cancelled</option>
								</select>	</td>
							</tr>	
								
								<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>		
			</div>
	
            <h4><?php echo $lang_ip." ".$lang_advance_payment_report;?><?php echo !empty($post['from_time']) || !empty($post['from_date'])?" From ".$post['from_date']. " ".$post['from_time']." To ".$post['to_date']." ".$post['to_time']:"";?></h4>
    	  
		   <div align="left">
		  <?php echo !empty($post['ipno'])?"IPNO : ".$post['ipno']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
	      <?php echo !empty($post['billno'])?"BILL NO : ".$post['billno']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
	      <?php echo !empty($post['user_type_name'])?"USERTYPE : ".$post['user_type_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
	      <?php echo !empty($post['user_name'])?"USER : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                
               <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_ip." ".$lang_advance_payment_report; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
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
						 <?php if(isset($post['bill_status']) && $post['bill_status'] ==0){?>
						
						  <th ><a href="#"><?php echo $lang_remarks; ?></a></th>
						  <th ><a href="#"><?php echo $lang_action; ?></a></th>
					<?php }else{ ?>
						  <th ><a href="#"><?php echo $lang_remarks; ?></a></th>
						  <th ><a href="#">CANCELLED DATE</a></th>
						  <th ><a href="#">CANCELLED BY</a></th>
					<?php } ?>
					      
				     </tr>
						</thead>
						<tbody>	
		<?php
		                $totalcash=0;
						$totalcard_amount=0;
						$totalupi_amount=0;
			if(!empty($billInfo)){
			$j=1;
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
				<?php if(isset($post['bill_status']) && $post['bill_status'] ==0){?>
						<td><?php echo $billInfo[$i][10];?></td>
						
					    <td class="DONTPrint">
						
							<a href="#" class="btn btn-info btn-flat" onClick="submitform('<?php echo $lang_print;?>','<?php echo $billInfo[$i][0];?>');"><i class="fa fa-print"></i></a>
							
						</td>
					
					<?php }else{ ?>	
				<td><?php echo $billInfo[$i][15];?></td>
				<td><?php echo $billInfo[$i][16];?></td>
				<td><?php echo $billInfo[$i][18];?></td>
				
					<?php } ?>		
				
				
							
					</tr>
                        <?php
						    $totalcash=$totalcash+$billInfo[$i][3];
					        $totalcard_amount=$totalcard_amount+$billInfo[$i][4];
					         $totalupi_amount=$totalupi_amount+$billInfo[$i][20];
					    ?> 
		<?php	}
			
			}		
		?>
		            <tr id="noborder">
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
					      <td align="right"></td>
					      <td><b>TOTAL</b></td>  
					      <td><b><?php echo $totalcash; ?></b></td> 
					      <td><b><?php echo $totalcard_amount; ?></b></td> 
					      <td><b><?php echo $totalupi_amount; ?></b></td>  
					      <td colspan="2"></td>
					
					</tr>

					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>


<?php

if (empty($post['pdf'])) {?>	
		
      <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
      </div>
  		
<?php
}
?>



	  <input type="hidden" name="billid" id="billid" />
	 <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="ip_advance_payments_report" value="ip_advance_payments_report" />
</form>	  
</body>
	</html>
