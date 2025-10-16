<?php
      $itemInfo=$this  ->popArr['itemInfo'];
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
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
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
		 $('.hide_div').hide();
	  });

</script>
<script type="text/javascript">


function submitform(action,id){

	
        document.patients.paction.value=action;
		document.patients.id.value=id;
  if(action =="CLEAR"){
		
			document.patients.from_date.value='';

			document.patients.to_date.value='';
		}	
  
   		    document.patients.action="../../lib/controllers/centralController.php?module=Report&sub_module=pharmacy_invoice_return_report";
   	    
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
					filename: "Pharma Invoice Return Report",
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
											
										</td>
						
											
										
										<td id="noborder"><?php echo $lang_to_date; ?>:</td>
										<td id="noborder" >	<input type="text" name="to_date" id="to_date"  class="DatePicker" value="<?php echo (!empty($post['to_date']))?$post['to_date']:'';?>" readonly="true"/>
											
										</td>
										<td id="noborder">
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
										
								</tr>
								
								<!-- <tr>		
									<td id="noborder" colspan="6" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="submitform('<?php echo $lang_search;?>','');"/>
									<input id="button1" type="button" name="Clear" value="Clear" class="btn btn-info" onclick="submitform('<?php echo $lang_clear;?>','');"/>
									</td>
								</tr> -->
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
						<?php echo $lang_ivoice_return_report." From ".$from_date." To ".$to_date; ?>

					
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

			        <table class="table table-bordered table-striped table2excel" border="1" style="border-collapse: collapse;"	>
				<thead>
					<tr class="hide_div"><td><h4><?php echo $lang_ivoice_return_report; ?> From <?php if (!empty($post['from_date'])) {
		echo $post['from_date'];} if (!empty($post['to_date'])) {
			echo " To ".$post['to_date'];
		}?></h4></td></tr>
					<tr>
                        <th width="2%" class="center"><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_bill_no; ?></a></th>
						<th width="5%" class="center"><a href="#"><?php echo $lang_date; ?></a></th>
						<th width="4%" class="center"><a href="#"><?php echo $lang_mode; ?></a></th>
						<th width="11%" class="center"><a href="#"><?php echo $lang_brand; ?></a></th>	
						<th width="5%" class="center"><a href="#"><?php echo $lang_batch; ?></a></th>   				 
                        <th width="6%" class="center"><a href="#"><?php echo $lang_expiry; ?></a></th>
						 <th width="4%" class="center"><a href="#"><?php echo $lang_pack; ?></a></th>
					     <th width="3%" class="center"><a href="#"><?php echo $lang_qty; ?></a></th>
						 <th width="4%" class="center"><a href="#"><?php echo $lang_sellp; ?></a></th>
					     <th width="4%" class="center"><a href="#"><?php echo $lang_total; ?></a></th>
												
						 
						                            
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
		      $total=0;
			if(!empty($itemInfo)){
			$j=1;
				for($i=0;$i<count($itemInfo);$i++) {?>
					<tr>
						<td><?php echo $j++;?></td>
						<td><?php echo $itemInfo[$i][1];?></td>
						<td><?php echo $itemInfo[$i][2];?></td>
						<td><?php echo $itemInfo[$i][5];?></td>
						<td><?php echo $itemInfo[$i][12];?></td>
						<td><?php echo $itemInfo[$i][6];?></td>
						<td><?php echo $itemInfo[$i][7];?></td>
						<td><?php echo $itemInfo[$i][8];?></td>
						<td><?php echo $itemInfo[$i][9];?></td>
						<td><?php echo $itemInfo[$i][10];?></td>
						<td><?php echo $itemInfo[$i][11];?></td>
						
						
						
                           
					</tr>
						
				
		<?php	
		           $total=$total+$itemInfo[$i][11];
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
		           	<td></td>
		           	    <td align="right"><b>Total</b></td>
		           	    <td><b><?php echo $total; ?></b></td>
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
	  <input type="hidden" name="page_name" id="pharmacy_invoice_return_report" value="pharmacy_invoice_return_report" />
  
</form>
</body>
</html>

