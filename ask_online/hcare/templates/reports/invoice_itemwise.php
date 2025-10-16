<?php
	
	$post=$this  ->popArr['post'];
	$PharmaInvoiceItems=$this  ->popArr['PharmaInvoiceItems'];

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
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../../plugins/export/dist/jquery.table2excel.min.js"></script>
<style type="text/css">
	.small{
              width:70%; 
              margin-left:15%; 
              margin-right:15%;
	      }
	.center{
	         text-align: center;  
	       } 
	@media print{a[href]:after{content:none}}            
</style>
 <script>
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

   function submitform(action){
   	
	 
		
		if(action =="CLEAR"){
		
			document.invoice_itemwise_report.from_date.value='';
			document.invoice_itemwise_report.to_date.value='';
			document.invoice_itemwise_report.brand.value='';
			
			
		}
		
   		document.invoice_itemwise_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=pharmacy_invoice_itemwise_report";
		
		document.invoice_itemwise_report.submit();
		
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
					filename: "Pharma Invoice Itemwise Report",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			$('.hide_div').hide();

		// document.invoice_itemwise_report.action="../../lib/controllers/centralController.php?module=Report&sub_module=download_pdf";
		// document.invoice_itemwise_report.submit();

   }
   
</script>

</head>
<body id="frame">
<form name="invoice_itemwise_report" id="form"  method="post" action=""> 

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
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?date('d-m-Y',strtotime($post['to_date'])):date('d-m-Y');?>" readonly="true"/>
											
										</td>
											
									<td id="noborder">
										<?php echo $lang_brand; ?></td>
									<td id="noborder" >
									
										<input name="brand" id="brand" tabbindex="2"  onkeypress="if(event.keyCode==13 || event.keyCode==9)" value="<?php echo (!empty($post['brand']))?$post['brand']:'';?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getMedicines',event)" >
					                    <input type="hidden" id="brand_hidden" name="brand_ID" >
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
        <div>
            <div>
            	   <h4 ><?php echo $itemwise_ivoice_report." From ".$post['from_date']." To ".$post['to_date']; ?></h4>
            </div>
		    <div>
            	   <div align="left"><?php echo !empty($post['brand'])?"BRAND : ".$post['brand']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				Report Date : <?php echo date("m-d-Y");;?>
				</div>	
            </div>			
        </div> 
			<div class="box box-info">
                
                           <div class="box-body">

			        <table class="table table-bordered table-striped small table2excel" border="1" style="border-collapse: collapse;"	>
       			
				<thead>
					<tr class="hide_div"><td><h4><?php echo $itemwise_ivoice_report; ?> From <?php echo date("d-m-Y",strtotime($post['from_date']));?> To <?php echo date("d-m-Y",strtotime($post['to_date']));?></h4></td></tr>
					<tr>
                          <th width="2%" class="center"><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th width="20%" class="center"><a href="#"><?php echo $lang_brand; ?></a></th>
						  <th width="5%" class="center"><a href="#"><?php echo $lang_quantity; ?></a></th>
                          <th width="5%" class="center"><a href="#"><?php echo $lang_net_total; ?></a></th>
                          
                            </tr>
						</thead>
						<tbody>	
		<?php
		       if(!empty($post['from_date']) && ($post['to_date']))
		       	   {
		       	   	  $from_date=$post['from_date'];

		       	   	  $to_date=$post['to_date'];
		       	   }
		       else{
                      $from_date=date("d-m-Y");

                      $to_date=date("d-m-Y");
		           }	      
		$totalcash =0;	
			
			if(!empty($PharmaInvoiceItems)){
			$j=1;
				for($i=0;$i<count($PharmaInvoiceItems);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td>
						  <a href="../../lib/controllers/centralController.php?module=Report&sub_module=itemwise_detailed_report&item_id=<?php echo $PharmaInvoiceItems[$i][3];?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="thickbox none" title="VIEW ITEM BILL INFORMATION">
						         <?php echo $PharmaInvoiceItems[$i][0];?>
						  </a>               
						</td>
						<td><?php echo $PharmaInvoiceItems[$i][1];?></td>
						<td><?php echo $PharmaInvoiceItems[$i][2];?></td>
						
						<?php 
						
						
							$totalcash=$totalcash+$PharmaInvoiceItems[$i][2];
							
						
					?>
					</tr>
				<?php
				
			}
			
			}		
		?>
		<tr>
			<td></td>
			<td></td>
		<td align="right"><b>Total</b></td>
		
		<td><b><?php echo $totalcash;?></b></td>
		
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

           
      </section>
<input type="hidden" name="page_name" id="pharmacy_invoice_itemwise_report" value="pharmacy_invoice_itemwise_report" />	 
</form>	  
</body>
	</html>
