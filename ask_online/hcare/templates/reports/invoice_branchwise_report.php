<?php
	$post=$this  ->popArr['post'];
	$user=$this  ->popArr['user'];
    $pharmaInfo =$this->popArr['pharmaInfo'];

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
<style type="text/css">
	.center{
	         text-align: center;  
	       } 
</style>
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


function submitform(action,id){

	
        document.patients.paction.value=action;
		document.patients.id.value=id;
  if(action =="CLEAR"){
		
			document.patients.from_date.value='';
			document.patients.from_time.value='';
			document.patients.to_date.value='';
			document.patients.to_time.value='';
			document.patients.name.value='';
			document.patients.type.value='';
			document.patients.user.value='';
			document.patients.patient_id.value='';
			document.patients.bill_no.value='';
	
		}	
  
   		    document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=pharmacy_invoice_branchwise_report";
   	    
		document.patients.submit();
    
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
					filename: "Pharma Invoice Branchwise Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();
		// document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		// document.patients.submit();

   }
</script>

</head>
<body id="frame">
<form name="patients" id="form"  method="post" action=""> 

<section class="content-header">
          <h4><?php echo $lang_search; ?></h4>
		  
        </section>
 
		<section class="content">
			<div class="DONTPrint">			 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">

								<tr>
										<td id="noborder"><?php echo $lang_from_date; ?>:</td>
										<td id="noborder" >	
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:'';?>" readonly="true"/>
											<span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>
											
										</td>
										<td id="noborder">
									       <?php echo $lang_name; ?></td>
									    <td id="noborder" >	 <input name="name" id="name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['name']))?$post['name']:''?>" autocomplete="off"/> 
								 
								        </td>
								</tr>
								<tr>
								
							
						<td id="noborder">
						<?php echo $lang_type; ?> </td>
						<td id="noborder" ><select name="type" id="type"   onkeypress="nextField(event.keyCode,inc)" /> 		
							<option value=''>-----------</option>
							<option value='DIRECT' <?php echo ($post['type']=="DIRECT")?'selected':''?> >DIRECT</option>	
							<option value='OP' <?php echo ($post['type']=="OP")?'selected':''?> >OP</option>
							<option value='IP' <?php echo ($post['type']=="IP")?'selected':''?> >IP</option>	
											
							    </select>
						</td>	
						<td id="noborder">
						<?php echo $lang_user; ?></td>
						<td id="noborder" ><select name="user" id="user"   onkeypress="nextField(event.keyCode,inc)" /> 		
							<option value=''>------------</option>
							  <?php
							        for ($i=0; $i<count($user); $i++) { 

							          if(!empty($post['user']) && $post['user']==$user[$i][0]){
                              ?>
                                           <option value='<?php echo $user[$i][0]; ?>' selected><?php echo $user[$i][3]; ?></option>
							  <?php   
							            }
                                    else{
                              ?>
                                           <option value='<?php echo $user[$i][0]; ?>'><?php echo $user[$i][3]; ?></option>
                              <?php   
                                        }       	
							        }
							  ?>
								
										
							    </select>
								 
						</td>
						 <td id="noborder">
									       <?php echo $lang_patient_id; ?></td>
						<td id="noborder" >	 <input name="patient_id" id="patient_id" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['patient_id']))?$post['patient_id']:''?>" autocomplete="off"/> 
								 
						</td>
						</tr>
						<tr>
								        <td id="noborder">
									       <?php echo $lang_bill_no; ?></td>
									    <td id="noborder" >	 <input name="bill_no" id="bill_no" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['bill_no']))?$post['bill_no']:''?>" autocomplete="off"/> 
								 
								        </td>
						</tr>
								<tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr>
						</table>
				
					</div>
			</div>
			</div>
			<div>
			    <div>
                  <h4> 
					<?php echo empty($post) || ($post['paction']=="CLEAR")?$lang_invoice_branchwise_report." From ".date("d-m-Y")." To ".date("d-m-Y"):$lang_invoice_branchwise_report." From ".$post['from_date']." ".$post['from_time']." To ".$post['to_date']." ".$post['to_time']; ?>

						</a>
				  </h4>
			    </div>
			    <div>
			    	    <div class="box-header">
                          <div class="box-tools DONTPrint">
                            <?php echo $pagination;?>
                          </div>
                        </div>
			    </div>		
		    </div>			
					<div align="left"><?php echo !empty($post['name'])?"CUSTOMER NAME : ".$post['name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<?php echo !empty($post['user'])?"USER : ".$post['user_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"USER : ALL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>

                <?php echo !empty($post['type'])?"TYPE : ".$post['type']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"TYPE : ALL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>

				<?php echo !empty($post['patient_id'])?"PATIENT ID : ".$post['patient_id']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>

				<?php echo !empty($post['bill_no'])?"BILL NO : ".$post['bill_no']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"";?>
				
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
			<div class="box box-info">
                  <!-- <div class="box-header">
                  <div class="box-tools DONTPrint">
                    <?php echo $pagination;?>
                  </div>
                </div> -->
               <div class="box-body">


			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_invoice_branchwise_report; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
					<tr>
                        <th width="2%" class="center"><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th width="6%" class="center"><a href="#"><?php echo $lang_date; ?></a></th>
						<th width="5%" class="center"><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th width="3%" class="center"><a href="#"><?php echo $lang_type; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_ip."/".$lang_op." ".$lang_no; ?></a></th>
						<th width="6%" class="center"><a href="#"><?php echo $lang_customer_name; ?></a></th>   		  
                        <th width="5%" class="center"><a href="#"><?php echo $lang_payment_type; ?></a></th>
						<th width="5%" class="center"><a href="#"><?php echo $lang_net_total; ?></a></th>
					    <th width="5%" class="center"><a href="#"><?php echo $lang_card_amount; ?></a></th>
					    <th width="5%" class="center"><a href="#"><?php echo $lang_upi_amount; ?></a></th>
						<th width="7%" class="center"><a href="#"><?php echo $lang_checque_amount; ?></a></th>
					    <th width="5%" class="center"><a href="#"><?php echo $lang_cash_amount; ?></a></th>
						<th width="2%" class="center"><a href="#"><?php echo $lang_balance;?></a></th>						
						 
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($pharmaInfo)){
			     $net_total=0;
				 $cash=0;
				 $card=0;
				 $checque=0;
				 $credit=0; 
				 $upi=0;
				for($i=0;$i<count($pharmaInfo);$i++) {?>
					<tr>
												<td><?php echo $pharmaInfo[$i][0];?></td>
												<td><?php echo $pharmaInfo[$i][5];?></td>
												<td><?php echo $pharmaInfo[$i][1];?></td>
												<td><?php echo $pharmaInfo[$i][2];?></td>
										<?php if($pharmaInfo[$i][2] == "OP"){?>
										
										        <td><?php echo $pharmaInfo[$i][37]."/".$pharmaInfo[$i][34];?></td>
										<?php }else if($pharmaInfo[$i][2] == "IP"){?>
										
										       <td><?php echo $pharmaInfo[$i][33];?></td>
										<?php }else{?>
										        <td></td>
										<?php } ?>
												<td><?php echo $pharmaInfo[$i][4];?></td>
												<td><?php echo $pharmaInfo[$i][15];?> 
										<?php if($pharmaInfo[$i][15] =="CREDIT" || $pharmaInfo[$i][11] !=""){?>
												
												<br>Sanctioned By <?php echo $pharmaInfo[$i][35];?><br>
												Remarks:<?php echo $pharmaInfo[$i][36];
											}
												?>
												</td>
												<td><?php echo $pharmaInfo[$i][14];?></td>
												<td><?php echo $pharmaInfo[$i][18];?></td>
												<td><?php echo $pharmaInfo[$i][38];?></td>
												<td><?php echo $pharmaInfo[$i][17];?></td>
												<td><?php echo $pharmaInfo[$i][31];?></td>
												<td><?php echo $pharmaInfo[$i][32];?></td>
												
												
												
												
											</tr>
						
				
		<?php	
		                 $net_total=$net_total+$pharmaInfo[$i][14];
						 $card=$card+$pharmaInfo[$i][18];
						 $checque=$checque+$pharmaInfo[$i][17];
						 $cash=$cash+$pharmaInfo[$i][31];
						 $credit=$credit+$pharmaInfo[$i][32];
						 $upi=$upi+$pharmaInfo[$i][38];	
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
							<td align="right"><b>Total</b></td>
							<td><b><?php echo $net_total;?></b></td>
							<td><b><?php echo $card;?></b></td>
							<td><b><?php echo $upi;?></b></td>
							<td><b><?php echo $checque;?></b></td>
							<td><b><?php echo $cash;?></b></td>
							<td><b><?php echo $credit;?></b></td>
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
	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="pharmacy_invoice_branchwise_report" value="pharmacy_invoice_branchwise_report" />
  
</form>
</body>
</html>
