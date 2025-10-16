<?php
    $billInfo=$this  ->popArr['billInfo'];
	$post=$this  ->popArr['post'];

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
           .small{
                   width:98%; 
                   margin-left:1%; 
                   margin-right:1%;
	             }
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
			document.patients.bill_no.value='';
			document.patients.bill_status.value='';
	
		}	
  
   		    document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=pharmacy_credit_payment_report";
   	    
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
					filename: "Invoice Credit Report",
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
											<input type="text" name="from_date" id="from_date"  class="DatePicker" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
											<span class="bootstrap-timepicker"><input type="text"  name="from_time" id="from_time" class="timepicker" size="8" value="<?php echo (!empty($post['from_time']))?$post['from_time']:''?>"></span>
										</td>
							
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:date('d-m-Y');?>" readonly="true"/>
										<span class="bootstrap-timepicker"><input type="text"  name="to_time" id="to_time" class="timepicker" size="8" value="<?php echo (!empty($post['to_time']))?$post['to_time']:''?>"></span>
											
										</td>
								</tr>
								
					
						<tr>
								        <td id="noborder">
									       <?php echo $lang_bill_no; ?></td>
									    <td id="noborder" >	 <input name="bill_no" id="bill_no" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['bill_no']))?$post['bill_no']:''?>" autocomplete="off"/> 
								 
								        </td>

						<td id="noborder">
						<?php echo $lang_bill_status; ?> </td>
						<td id="noborder" ><select name="bill_status" id="bill_status"   onkeypress="nextField(event.keyCode,inc)" /> 	

							<option value='0' >ACTIVE</option>	
							<option value='1' <?php echo ($post['bill_status']=="1")?'selected':''?>>CANCELLED</option>	
											
							    </select>
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
						 <?php
		                    if(!empty($post['from_date']) && empty($post['to_date']))
		       	                  {
		       	   	                 $from_date=$post['from_date'];

		       	   	                 $to_date=date("d-m-Y");
		       	                  }
		       	            elseif(!empty($post['from_date']) && ($post['to_date']))
		       	                  {
                                     $from_date=$post['from_date'];

		       	   	                 $to_date=$post['to_date'];
		       	                  }    
		                    else  {
                                     $from_date=date("d-m-Y");

                                     $to_date=date("d-m-Y");
		                          }	
                	    ?>
						<?php echo $lang_credit_payment_report." From ".$from_date." To ".$to_date; ?>
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
					<div align="left"><?php echo !empty($post['bill_no'])?"BILL NO : ".$post['bill_no']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
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

			        <table class="table table-bordered table-striped small table2excel" border="1" style="border-collapse: collapse;">
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_credit_payment_report; ?> <?php if (!empty($post['from_date'])) {
		echo "From ".$post['from_date']. " ".$post['from_time'];} if (!empty($post['to_date'])) {
			echo "To ".$post['to_date']." ".$post['to_time'];
		}?></h4></td></tr>
					<tr>
                        <th width="1%" class="center"><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_date; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th width="5%" class="center"><a href="#"><?php echo $lang_customer_name; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_amount_paid; ?></a></th>	
						 
						<?php if($post['bill_status']=='1') 
						      {
						?>
                                <th width="4%" class="center"><a href="#"><?php echo $lang_cancellation_details; ?></a></th>
						        <th width="4%" class="center"><a href="#"><?php echo $lang_cancellation_date; ?></a></th>	
						<?php           
						      }	
						 ?>
						<th width="2%" class="center"><a href="#"><?php echo $lang_entered_by; ?></a></th>   		
                            </tr>
						</thead>
						<tbody>	
		<?php
		      $amount=0;

			if(!empty($billInfo)){
			$j=1;
				for($i=0;$i<count($billInfo);$i++) {?>
					<tr>
						<td><?php echo $billInfo[$i][0];?></td>
						<td><?php echo $billInfo[$i][4];?></td>
						<td><?php echo $billInfo[$i][2];?></td>
						<td><?php echo $billInfo[$i][5];?></td>
						<td><?php echo $billInfo[$i][13];?></td>
            <?php if($billInfo[$i][6]=='1') 
						{
			?>
                            <td><?php echo $billInfo[$i][7];?></td>
						    <td><?php echo $billInfo[$i][8];?></td>	
		    <?php           
			            }	
			?>  

						<td><?php echo $billInfo[$i][10];?></td>
                           
					</tr>
						
				
		<?php
		          $amount +=$billInfo[$i][13];
			   }
			
			}		
		?>

		        <tr><td></td><td></td><td></td>
						<td align="right"><b>Total</b></td>
						<td><b><?php echo $amount;?></b></td>
								
			    </tr>
					</tbody>
				</table>
			</div>
				</div>
				
			
				
            </div>
           
      </div>

<?php

if (empty($post['pdf'])) {?>	
		
	  <div class="DONTPrint" align="center"><input  type="button" name="but" value="Print" class="btn btn-info"  onClick="printit()">&nbsp;<input  type="button" name="but" value="Download" class="btn btn-danger"  onclick="download_pdf()"></div>
  		
<?php
}
?>


	  <input type="hidden" name="id" id="id" />
	  <input type="hidden" name="paction" id="paction" />
	  <input type="hidden" name="cancellation_details" id="cancellation_details" />
	  <input type="hidden" name="page_name" id="pharmacy_credit_payment_report" value="pharmacy_credit_payment_report" />
  
</form>
</body>
</html>
