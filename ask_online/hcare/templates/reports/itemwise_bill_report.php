<?php
	
	$post=$this  ->popArr['post'];
	$category=$this  ->popArr['category'];
	$itemInfo=$this  ->popArr['itemInfo'];

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
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
<script src="../../plugins/timepicker/bootstrap-timepicker.js"></script>
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
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
	  
	  <link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

<script>

   function submitform(action){
   	
	 
		
		if(action =="CLEAR"){
		
			document.item_wise_bill_report.from_date.value='';
			document.item_wise_bill_report.to_date.value='';
			document.item_wise_bill_report.particulars.value='';
			document.item_wise_bill_report.particulars_ID.value='';
			document.item_wise_bill_report.from_time.value='';
			document.item_wise_bill_report.to_time.value='';
			
			
		}/*else{
		
			if(document.item_wise_bill_report.particulars.value == ""){
			
				showDialog('Error','Please Select a test.','error',2);
				return false;
			}
		
		}*/
		
   		document.item_wise_bill_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=itemwise_bill_report";
		
		document.item_wise_bill_report.submit();
		
		return true;
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
					filename: "Itemwise Bill Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.item_wise_bill_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.item_wise_bill_report.submit();

   }
   
</script>

</head>
<body id="frame">
<form name="item_wise_bill_report" id="form"  method="post" action=""> 

 <section class="content-header">
          <h4 class="DONTPrint"><?php echo $lang_search; ?></h4>
		  
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
										
								
								<!--<td id="noborder">
										<?php echo $lang_category; ?></td>
									<td id="noborder" >	<select name="category">
														<option value ="">------</option>
													<?php if(!empty($category)){
													     
														     for($i=0;$i<count($category);$i++){ ?>
															 
															 	<option value ="<?php echo $category[$i][0];?>"><?php echo $category[$i][1];?></option>
																
												    <?php     }
													      }
													?>
														
														</select>
									</td>-->
									
									<td id="noborder">
										<?php echo $lang_particulars; ?></td>
									<td id="noborder" >
									
										<input name="particulars" id="particulars" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9){ submitform('<?php echo $lang_search;?>')};" value="<?php echo (!empty($post['particulars']))?$post['particulars']:'';?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getBillParticulars',event)" >
					 <input type="hidden" id="particulars_hidden" name="particulars_ID"  value="<?php echo (!empty($post['particulars_ID']))?$post['particulars_ID']:'';?>">
					 
					                  </td>
										
								
							
							
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>');"/>
									<input id="button1" type="button" name="Clear" class="btn btn-info" value="Clear" onclick="submitform('<?php echo $lang_clear;?>');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<h4 ><?php echo $lang_itemwise_bill_report ?></h4>		
			<div class="box box-info">
                
                           <div class="box-body">
<?php if(!empty($post['particulars'])){
			  
			   		echo "<tr><th colspan='3'><a href='#'>Bill Report For Test Item ".$post['particulars']." From ".$post['from_date']." To ".$post['to_date']."</a></th></tr>";
				}?>


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_itemwise_bill_report; ?> From  <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4></td></tr>
				
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_bill_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_particulars; ?></a></th>
						   <th ><a href="#"><?php echo $lang_qty; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
                          <th ><a href="#"><?php echo $lang_type; ?></a></th>
                          <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
                         <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>						  
                          <th ><a href="#"><?php echo $lang_name; ?></a></th>							  
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
                         <th ><a href="#"><?php echo $lang_credit; ?></a></th>						  
                                                        
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		
		$totalcash =0;	
		$totalcredit=0;
			
			if(!empty($itemInfo)){
			$j=1;
				for($i=0;$i<count($itemInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						
						<td><?php echo	$itemInfo[$i][0];?></td>
						<td><?php echo	$itemInfo[$i][1];?></td>
						<td><?php if (!empty($itemInfo[$i][10])) {
							echo $itemInfo[$i][10];
						}else{echo "1";}?></td>
						<td><?php echo	date("d-m-Y h:i A",strtotime($itemInfo[$i][7]));?></td>
						<td><?php echo	$itemInfo[$i][2];?></td>
						<td><?php echo	$itemInfo[$i][3];?></td>
						<td><?php echo	$itemInfo[$i][4];?></td>
						<td><?php echo	$itemInfo[$i][5];?></td>
						<td><?php echo	$itemInfo[$i][6];?></td>
						<td><?php echo	$itemInfo[$i][8];?></td>
						<?php 
						
						
							$totalcash=$totalcash+$itemInfo[$i][6];
							$totalcredit=$totalcredit+$itemInfo[$i][8];
						
					?>
					</tr>
				<?php
				
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
			<td></td>
		<td align="right"><b>Total</b></td>
		
		<td><b><?php echo $totalcash;?></b></td>
		<td><b><?php echo $totalcredit;?></b></td>
		
		</tr>
					</tbody>
				</table>
			</div>
				</div>
				
		
<?php

if (empty($post['pdf'])) {?>	
		
<div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">
</div>
  		
<?php
}
?>

           
<input type="hidden" name="page_name" id="itemwise_bill_report" value="itemwise_bill_report" />

      </section>
	 
</form>	  
</body>
	</html>
