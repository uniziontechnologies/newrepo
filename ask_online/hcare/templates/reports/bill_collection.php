<?php
	
	$collectionInfo=$this  ->popArr['daily_collection'];
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
	$user_type=$this  ->popArr['user_type'];

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
<link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
	 <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />

<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
 <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
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


<script type="text/javascript">

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



function submitform(){  	
	 
		 if(document.bill_collection.from_time.value == "" && document.bill_collection.to_time.value != ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else if(document.bill_collection.from_time.value != "" && document.bill_collection.to_time.value == ""){
		
		  showDialog('Error','Please Enter From Time.','error',2);
		  return false;
		}else{
   		  document.bill_collection.action="../../lib/controllers/centralController.php?module=Report&sub_module=bill_collection";
		
		  document.bill_collection.submit();
		}
   }
 function redirect(type){
 
 
 	if(type == "Credit Payment"){
	
		document.bill_collection.action="../../lib/controllers/centralController.php?module=Report&sub_module=credit_payment";
	}else{
 		document.bill_collection.action="../../lib/controllers/centralController.php?module=Report&sub_module=bill_report";
	}	
		document.bill_collection.submit();
 }
   function download_pdf(){
   		$('.hide_div').show();
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Bill Collection Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		//document.bill_collection.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		//document.bill_collection.submit();

   }

</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
<style type="text/css">
	.credit_details{
	    font-size: 15px;
	    padding-top: 5px;
	    color: brown;
	    font-weight: 600;
	}
</style>
</head>
<body id="content">
<form name="bill_collection" id="form"  method="post" action=""> 


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
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo $post['from_date']; ?>" readonly="true"/>
										   <span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo $post['to_date']; ?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>	
											
										</td>
								</tr>
								<tr>
										<td id="noborder">
							<?php echo $lang_user; ?><?php echo $lang_type; ?> </td>
								<td id="noborder" ><select name="user_type" id="user_type"   onkeypress="nextField(event.keyCode,user)" onchange="submitform();"/> 		
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
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" value="Search" class="btn btn-success" onclick="submitform();"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
		</div>
			<h4 ><?php echo $lang_daily_collection." ".$lang_report; ?> From <?php echo $post['from_date']. " ".$post['from_time'];?> To <?php echo $post['to_date']." ".$post['to_time'];?>
			
			</h4>
				<div align="left"><?php echo !empty($post['user_type_name'])?"User Type : ".$post['user_type_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo !empty($post['user_name'])?"User : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				Report Date : <?php echo date("m-d-Y");;?>
				</div>			
			<div class="box box-info">
                
                           <div class="box-body">

	



			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
       			<tr class="hide_div"><td><h4><?php echo $lang_daily_collection." ".$lang_report; ?> <?php if (!empty($post['from_date'])) {
		echo "From ".$post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
				<?php for($i=0;$i<count($collectionInfo);$i++){?>
					<?php //var_dump($collectionInfo);

						if ($i==6) {?>


							<tr>
								<td width="50%"><a href="#" onClick="redirect('<?php echo $collectionInfo[$i][0];?>');"><b><?php echo "Credit Payment - CASH";?></b></a></td>
								<td><?php echo $collectionInfo[$i][3];?></td>
							</tr>

							<tr>
								<td width="50%"><a href="#" onClick="redirect('<?php echo $collectionInfo[$i][0];?>');"><b><?php echo "Credit Payment - CREDIT CARD";?></b></a></td>
								<td><?php echo $collectionInfo[$i][5];?></td>
							</tr>
							<tr>
								<td width="50%"><a href="#" onClick="redirect('<?php echo $collectionInfo[$i][0];?>');"><b><?php echo "Credit Payment - UPI";?></b></a></td>
								<td><?php echo $collectionInfo[$i][11];?></td>
							</tr>


						<?php
						}
						else if ($i==7||$i==8) {?>

							<tr>
								<td width="50%"><a href="#" onClick="redirect('<?php echo $collectionInfo[$i][0];?>');"><b><?php echo $collectionInfo[$i][0];?></b></a></td>
								<th><?php echo ($collectionInfo[$i][1] == '') ?0:round($collectionInfo[$i][1]);?></th>
							</tr>

						<?php
						}
						else{?>

							<tr>
								<td width="50%"><a href="#" onClick="redirect('<?php echo $collectionInfo[$i][0];?>');"><b><?php echo $collectionInfo[$i][0];?></b></a></td>
								<td><?php echo ($collectionInfo[$i][1] == '') ?0:round($collectionInfo[$i][1]);?></td>
							</tr>

						<?php
						}

					?>
					

				<?php } ?>
				</table>
			</div>


				<!-- <?php

					//if ($collectionInfo[5][1]>0) {?>

					<div class="row">

						<div class="col-md-12 credit_details">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit Payment - Cash : <?php// echo round($collectionInfo[5][3]);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit Payment - Card Amount : <?php// echo round($collectionInfo[5][5]);?>
						</div>

					</div>

				<?php
					//}
				?>
 -->


			</div>
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="action" id="action" />
	 <input type="hidden" name="page_name" id="bill_collection" value="bill_collection" />
	 
<?php

if (empty($post['pdf'])) {?>	

	 <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print"  class="btn btn-info" onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()">

<?php
}
?>

</div>
</section>
</form>	  

</body>
	</html>
	
