<?php
	
	$billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];
	$user_type=$this  ->popArr['user_type'];
	$user=$this  ->popArr['user'];

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
	
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
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
   	
	 
		document.manage_bill.action.value=action;
		document.manage_bill.id.value=id;
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.from_time.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.to_time.value='';
			document.manage_bill.billno.value='';
			document.manage_bill.name.value='';
			document.manage_bill.type.value='';
			document.manage_bill.user.value='';
			document.manage_bill.status.value='0';
			
		}
		if(action == "PRINT"){
			document.manage_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Print_Bill";
		}else{
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=bill_report_item_details";
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
					filename: "Billing Item Details Report",
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
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?date('d-m-Y',strtotime($post['from_date'])):date('d-m-Y');?>" readonly="true" size="10"/>
										    <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="6" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true" size="10"/>
											<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="6" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>	
										
										</td>
										<td id="noborder">							
								
										<?php echo $lang_bill_no; ?> : </td>
													
											<td id="noborder"  >	 <input type="text" name="billno" id="billno"   size="10" onkeypress="nextField(event.keyCode,name)" value="<?php echo (!empty($post['billno']))?$post['billno']:''?>" /> 	 
							</td>
										
								<td id="noborder">							
								
										<?php echo $lang_patient." ".$lang_name; ?>: </td>
													
											<td id="noborder"  >	 <input type="text" name="name" id="name"   onkeypress="nextField(event.keyCode,type)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" /> 	 
							</td>	
								</tr>
								<tr>
								
								<td id="noborder">
										<?php echo $lang_type; ?></td>
									<td id="noborder" >	<select name="type">
														<option value ="">------</option>
														<option value ="OP">OP</option>
														<option value ="IP">IP</option>
														<option value ="DIRECT">DIRECT</option>
														</select>
									</td>
								 <td id="noborder">
										<?php echo $lang_status; ?></td>
							<td id="noborder" >	<select name="status">
									
														<option value ="0">Active</option>
														<option value ="1">Cancelled</option>
														</select>
									</td>
							<td id="noborder">
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/> 		
							
									<option value=''>-----------------</option>
						
											
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
									<option value=''>-------------</option>
											
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
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<h4 ><?php echo $lang_bill_report; ?> [Itemwise]</h4>
			<div class="box box-info">
                
                           <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo  $lang_bill_report; ?> [Itemwise] From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						   <th ><a href="#"><?php echo $lang_type; ?></a></th>
						    <th ><a href="#"><?php echo $lang_ref_no; ?></a></th>
						   <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>	
						  <th><a href="#"><?php echo $lang_particulars; ?></a></th>				 	
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>   					  
                          <th ><a href="#"><?php echo $lang_cash; ?></a></th>
						  <th ><a href="#"><?php echo $lang_credit_card; ?></a></th>
						   <th ><a href="#"><?php echo $lang_upi; ?></a></th>
						  <th ><a href="#"><?php echo $lang_balance; ?></a></th>						                     
						   <th ><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
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
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo	$billInfo[$i][16];?></td>
						<td><?php echo $billInfo[$i][1];?></td>
						<td><?php echo $billInfo[$i][2];?></td>
						<td><?php echo $billInfo[$i][3];?></td>
						<td><?php echo $billInfo[$i][23];?></td>
						<td><?php echo number_format($billInfo[$i][11],2);?></td>						
						<td><?php echo !empty($billInfo[$i][34])?number_format($billInfo[$i][34],2):number_format($billInfo[$i][13],2) ;?></td>
						<td><?php echo !empty($billInfo[$i][35])?number_format($billInfo[$i][35],2):number_format($billInfo[$i][15],2) ;?></td>
						<td><?php echo !empty($billInfo[$i][39])?number_format($billInfo[$i][39],2):number_format($billInfo[$i][40],2) ;?></td>
						<td><?php echo number_format($billInfo[$i][14],2);?></td>
						
						<td>
							
							<a href="#" class="btn btn-info btn-flat" onClick="submitform('<?php echo $lang_print;?>','<?php echo $billInfo[$i][0];?>');"><i class="fa fa-print"></i></a>
					      </td>
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
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>Total</b></td>
		<td><b><?php echo number_format($total,2);?></b></td>
		<td><b><?php echo number_format($totalcash,2);?></b></td>
		<td><b><?php echo number_format($totalcard,2);?></b></td>
		<td><b><?php echo number_format($totalupi,2);?></b></td>
		<td><b><?php echo number_format($totalcredit,2);?></b></td>
		<td></td>
		</tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
<?php

if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"   class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
      	   </div>
  		
<?php
}
?>          

      </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="bill_report_item_details" value="bill_report_item_details" />
</form>	  
</body>
	</html>
