
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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>
<link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
	 <script>
	 	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
		 $('.hide_div').hide();
	  });
	  </script>
 <link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

<script>
	
   
   
   function submitform(action,id){
   	
	 
		setAction(action,id);
		if(action =="CLEAR"){
		
			document.manage_bill.from_date.value='';
			document.manage_bill.to_date.value='';
			document.manage_bill.particulars.value='';
			document.manage_bill.particulars_ID.value='';
			
		}
		login_user_check=document.manage_bill.login_user.value;
		
   			document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_ip_visit_report&login_user="+login_user_check;
		
		document.manage_bill.submit();
   }
	function submit_form(){

		$("#doctor").val('');
		$("#user_type").val('');
		$("#user").val('');
		document.manage_bill.action="../../lib/controllers/centralController.php?module=Report&sub_module=doctor_ip_visit_consolidated";
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
					filename: "Doctor Ip Visit Report",
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
<?php
	
	$visitInfo=$this  ->popArr['visitInfo'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];
	$doctors=$this  ->popArr['doctors'];
?>
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
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
											
										</td>
									
										
									<td id="noborder">
							<?php echo $lang_doctor; ?> </td>
								<td id="noborder" ><select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" class="select2" /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} 
											?>
									</select>
							</td>	
							<?php if(!isset($post['login_user'])){?>
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
												}
												} ?>
									</select>
							</td>
										
								</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" class="btn btn-info"  value="Clear" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<h4 ><?php echo $lang_doctor." ".$lang_ip." ".$lang_visit." ".$lang_report; ?> From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?></h4>
		
			
			</h4>
				<div align="left"><?php echo !empty($post['doc_name'])?"Doctor : ".$post['doc_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
			<div class="box box-info">
                
                           <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_doctor." ".$lang_ip." ".$lang_visit." ".$lang_report; ?>&nbsp;&nbsp;&nbsp;<?php echo !empty($post['doc_name'])?"Doctor : ".$post['doc_name']:"";?>&nbsp;&nbsp;&nbsp;From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
			  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
			 <?php if(empty($post['doc_name'])){?> <th ><a href="#"><?php echo $lang_doctor; ?></a></th><?php } ?>
			  <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
                          <th><a href="#"><?php echo $lang_room_no;?></a></th>	
                         <th   align="center"><?php echo $lang_emergency ?></th>
			<th ><?php echo $lang_ip_visit ?></th>
			<th ><?php echo $lang_ip_billing; ?></th>	
                          <th ><a href="#">UPDATE HISTORY</a></th>			  
					  
                                                        
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		$total_e=0;
		$total_v=0;
		$total_s=0;
			
			if(!empty($visitInfo)){
			$j=1;
				for($i=0;$i<count($visitInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $visitInfo[$i][11];?></td>
						<?php if(empty($post['doc_name'])){?> <td><?php echo $visitInfo[$i][2];?></td> <?php } ?>
						<td><?php echo	$visitInfo[$i][12];?></td>
						<td><?php echo	$visitInfo[$i][13];?></td>
						<td> <?php echo ($visitInfo[$i][5] == "E")?$visitInfo[$i][3]:0;?></td>
						<td> <?php echo ($visitInfo[$i][5] == "V")?$visitInfo[$i][3]:0;?></td>
						<td> <?php echo ($visitInfo[$i][5] == "IP BILL")?$visitInfo[$i][3]:0;?></td>
						<td><?php echo	$visitInfo[$i][10];?></td>
						
						
					</tr>
					
		<?php
		
		if($visitInfo[$i][5] == "E"){
		    $total_e +=$visitInfo[$i][3];
		}else if($visitInfo[$i][5] == "V"){
		    $total_v +=$visitInfo[$i][3];
		}else if($visitInfo[$i][5] == "IP BILL"){
		    $total_s +=$visitInfo[$i][3];
		}			
				
			}
			
			}		
		?>
		<tr>
		<?php if(empty($post['doc_name'])){
		         $colspan="5";
			}else $colspan="4";
			?>
		
		<td colspan="<?php echo $colspan;?>" align="right"><b>Total</b></td>
		<td><b><?php echo number_format($total_e,2);?></b></td>
		<td><b><?php echo number_format($total_v,2);?></b></td>
		<td><b><?php echo number_format($total_s,2);?></b></td>
		
		<td></td>
		</tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
<?php

if (empty($post['pdf'])) {?>	
		
           <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">&nbsp;<input type="button" name="back" value="Back" id="back" class="btn btn-success" onclick="submit_form()">
      	   </div>
  		
<?php
}
?>
				
     </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="login_user" id="login_user" value="<?php echo $post['login_user'];?>"/>
	 <input type="hidden" name="page_name" id="doctor_ip_visit_report" value="doctor_ip_visit_report" />
	 <input type="hidden" name="from_date" value="<?php echo(!empty($post['from_date']))?$post['from_date']:''; ?>">
	<input type="hidden" name="to_date" value="<?php echo(!empty($post['to_date']))?$post['to_date']:''; ?>">

</form>	  
</body>
	</html>
