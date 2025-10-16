<?php
	
	$billInfo=$this  ->popArr['billInfo'];
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
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
	 
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../../plugins/timepicker/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
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
   	
	 
		setAction(action,id);
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.from_time.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.to_time.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.type.value='';
			document.manage_bill.user.value='';
			document.manage_bill.status.value='0';
			
		}
		if(action == "PRINT"){
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Bill";
		}  
		if(document.manage_bill.from_time.value == "" && document.manage_bill.to_time.value != ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else if(document.manage_bill.from_time.value != "" && document.manage_bill.to_time.value == ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else{
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=bill_report";
		}
		document.manage_bill.submit();
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
					filename: "Billing Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.manage_bill.submit();

   }

   
</script>

</head>
<body id="frame">
<form name="manage_bill" id="form"  method="post" action=""> 

 <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search." ".$lang_billing; ?></h4>
		  
        </section>
 
	<section class="content">
	 <div class="DONTPrint">				 
	   <div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">
 
								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?date('d-m-Y',strtotime($post['from_date'])):date('d-m-Y');?>" readonly="true"/>
										   <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										
										
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>		
										</td>
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   onkeypress="nextField(event.keyCode,name)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							</td>
										
								
								</tr>
								<tr>
								<td id="noborder">							
								
										<?php echo $lang_patient." ".$lang_name; ?>: </td>
													
											<td id="noborder"  >	 <input type="text" name="name" id="name"   onkeypress="nextField(event.keyCode,type)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" /> 	 
							    </td>	
								
								
							
							<td id="noborder">
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/>

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
							
								
								</tr>
								<tr>	
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
										<?php echo $lang_status; ?></td>
							<td id="noborder" >	<select name="status">
									
														<option value ="0" <?php echo (isset($post['status']) && $post['status']=='0')?'selected':'';?>>Active</option>
														<option value ="1" <?php echo (isset($post['status']) && $post['status']=='1')?'selected':'';?>>Cancelled</option>
														</select>
									</td>									
									<td id="noborder" colspan="2" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
									<td id="noborder" colspan="2" align="center"></td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<h4 ><?php echo $lang_bill_report; ?>From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?>
			
			</h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>			
			<div class="box box-info">
                
                           <div class="box-body">

			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_bill_report; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_type; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>					
						<th ><a href="#"><?php echo $lang_patient_category; ?></a></th> 
						  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						  <th ><a href="#"><?php echo $lang_phone_no; ?></a></th>					 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>  
                          <th ><a href="#"><?php echo $lang_payment_mode; ?></a></th> 							  
                          <th ><a href="#"><?php echo $lang_cash; ?></a></th>
						  <th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						   <th ><a href="#"><?php echo $lang_upi; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th>
                          						  
						  <?php if($post['status'] == "1"){ ?>						                     
						  	<th ><a href="#">CANCELLATION DETAILS</a></th>
					<?php }?>					                     
						   <th class="DONTPrint"><a href="#"><?php echo "UPDATE HISTORY"; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		$total=0;
		$totalcash =0;	
		$totalcard =0;	
		$totalcredit =0;	
		$totalupi =0;
			if(!empty($billInfo)){
				// var_dump($billInfo);
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][16];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo ($billInfo[$i][1]=="OP")?$billInfo[$i][19]:$billInfo[$i][2];?></td>
						<td>
							<?php								
								if($billInfo[$i][37]){
									echo	$billInfo[$i][37];
									if($billInfo[$i][38]){
										echo "<br> Member ID : ".$billInfo[$i][38];
									}
								}
							?>
						</td>
						<td><?php echo $billInfo[$i][3];?></td>
						<td><?php echo $billInfo[$i][7];?></td>
						<td><?php echo $billInfo[$i][11];?></td>
						<td><?php echo $billInfo[$i][12];?>
						
						   <?php if($billInfo[$i][12] == "CREDIT" && $billInfo[$i][1]!="IP"){ ?>
						   <br>Sanctioned By:<?php echo $billInfo[$i][26];?>
						   <br>Remarks:<?php echo $billInfo[$i][27];?>
						   <?php } ?>
						</td>
						<td><?php echo !empty($billInfo[$i][34])?$billInfo[$i][34]:$billInfo[$i][13]; ?></td>
						<td><?php echo !empty($billInfo[$i][35])?$billInfo[$i][35]:$billInfo[$i][15];?></td>
						<td><?php echo !empty($billInfo[$i][39])?$billInfo[$i][39]:$billInfo[$i][40];?></td>
						<td><?php echo $billInfo[$i][14];?><br>
						<?php if($billInfo[$i][21] > $billInfo[$i][14]){?>
						    CREDIT PAID:<?php echo $billInfo[$i][25];?>
						<?php } ?>
						</td>
						<?php if($post['status'] == "1"){ ?>	
						<td><?php echo $billInfo[$i][23];?></td>
				<?php } ?>
						<td class="DONTPrint">
							
							
							<!-- <a href="#" onClick="submitform('<?php echo $lang_print;?>','<?php echo $billInfo[$i][0];?>');"><img src="../../img/icons/report_link.png" title="Print Bill" width="16" height="16" /></a> -->
							<?php echo $billInfo[$i][33];?></td>
							
					</tr>
					<tr>
		<?php
		$total +=$billInfo[$i][11];

		if (!empty($billInfo[$i][34])) {
			$totalcash +=$billInfo[$i][34];	
		}
		else if (!empty($billInfo[$i][13])) {
			$totalcash +=$billInfo[$i][13];	
		}
		
		if (!empty($billInfo[$i][35])) {
			$totalcard +=$billInfo[$i][35];	
		}
		else if (!empty($billInfo[$i][15])) {
			$totalcard +=$billInfo[$i][15];	
		}

		if (!empty($billInfo[$i][39])) {
			$totalupi +=$billInfo[$i][39];	
		}
		else if (!empty($billInfo[$i][40])) {
			$totalupi +=$billInfo[$i][40];	
		}
		
		$totalcredit +=$billInfo[$i][14];				
				
			}
			
			}		
		?>
		<td colspan="8" align="right"><b>Total</b></td>
		<td colspan="2"><b><?php echo $total;?></b></td>
		<td><b><?php echo $totalcash;?></b></td>
		<td><b><?php echo $totalcard;?></b></td>
		<td><b><?php echo $totalupi;?></b></td>
		<td><b><?php echo $totalcredit;?></b></td>
		<td></td>
		</tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
<?php

if (empty($post['pdf'])) {?>	
		
        <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"   class="btn btn-info" onClick="printit()">   &nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
       </div>
  		
<?php
}
?>				




     </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="bill_report" value="bill_report" />
</form>	  
</body>
	</html>
	
