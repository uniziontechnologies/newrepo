<!-- print for dot matrixs, page size 8*6 -->
<?php 
	  if (empty($popup_path)) {
	  	$this->load->view("header");
	  }

?> 

<style type="text/css">
	html,body{
		height: 100% !important;
	}
    hr{
        border:none;
        border-top:1px dashed #f00;
        color:#fff;
        height:0px;
        width:100%;
        margin-top: 5px;
        margin-bottom: 5px;
    }

   .font_th{

	    font-size: 9px;
   }
   #success{
        color: #006633;   
   }
<?php if (!empty($from_path)) {?>
	.content{
		margin-top: 90px;
	}
<?php
} ?> 	
@media print{
	@page{
		    margin:0mm 30mm 0mm 0mm;
		 }
	*{
    	/*font-family: "testing" !important;*/
	font-family: Arial;
	/*font-size: 18.72px;*/
	font-style: normal;
	font-variant: normal;
	font-weight: 400;
	line-height: normal;
    	/*font-size:7px;*/
    }
}
	.user_details{
		margin-left: 18px;
		font-size: 12px;
	}
	.print_logo{
		margin-top: -21px !important;
	}
	#main_head{
		 font-size: 27px !important;
	}
	#sub_head{
        font-size: 16px !important;
        margin-top: -1px;
    }
	.user_details{
		margin-left: 18px;
		font-size: 12px;
	}
	.bill_info{
		font-size: 12px;
	}
	td,th{
   	   font-size: 12px !important; 
    }
    #main_table td,th{
    	padding: 1px;
    }

</style>

<form name="print_invoice" id="print_invoice" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
    <?php if (empty($from_path) && empty($popup_path) ) {?>

    <center>   
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="80" style="margin-top: -21px;" class="print_logo"></img>   
          <!-- <h5 style="margin-top: 0px;" class="main_head"><b><?php echo strtoupper($pharmacyInfo[0][1]); ?></b></h5> -->
          <h6 class="sub_head" style="margin-top:-2px;"><b><?php echo (!empty($pharmacyInfo[0][1]))?$pharmacyInfo[0][1]:""; ?><?php echo (!empty($hospitalInfo[0][7]))?", Ph-".$hospitalInfo[0][7]:""; ?></b></h6>
          <!-- <h6 style="margin-top: -10px" class="sub_head"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h6> -->
          <h5 style="margin-top: -10px;font-size: 11px;" class="sub_head"><b>PHARMACY CASH BILL</b></h5>
          <h6 style="margin-top: -10px;font-size: 10px;" class="sub_head"><b>TAX INVOICE <?php echo ($bill_type=='Return')?strtoupper($bill_type):""; ?></b></h6>
<?php
if(!empty($duplicate)){
?>
          <h6 style="margin-top: -10px" class="sub_head"><b>(duplicate)</b></h6>
<?php
}
?>
          
    </center>  

<!--     <div class="row">
      <div class="col-md-4 col-xs-3">
      	
      </div>
      <div class="col-md-6 col-xs-6">

         <div class="row">
          
         <div class="col-md-2 col-xs-4">

           <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.JPG" width="100" style="margin-top: -21px;" class="print_logo"></img>
      	
         </div>
         <div class="col-md-4 col-xs-8" style="    text-align: center;
    margin-left: -25px;">

            <h5 style="margin-top: 0px;" class="main_head"><b><?php echo strtoupper($pharmacyInfo[0][1]); ?></b></h5>
          <h6 style="margin-top: -10px" class="sub_head"><b><?php echo strtoupper($hospitalInfo[0][3])." , ".strtoupper($hospitalInfo[0][4]); ?></b></h6>
          <h6 style="margin-top: -10px" class="sub_head"><b><?php echo "PH : ".$hospitalInfo[0][7]; ?></b></h6>
          <h5 style="margin-top: -10px" class="sub_head"><b>PHARMACY CASH BILL</b></h5>
          <h6 style="margin-top: -10px" class="sub_head"><b>TAX INVOICE</b></h6>
      	
         </div>

         </div>    
      	
      </div>
      <div class="col-md-3 col-xs-3">
      	
      </div>
    </div> -->
    

    <?php
    } ?>      
      
          <!-- Main content -->
          <section class="content">
   
            <table width="95%" class="user_details" style="margin-top: -40px;">
                   <tr style="height: 0px;">
						<td>
			 				 DL NO : <?php echo $pharmacyInfo[0][3]; ?>
						</td>
						
						<td align="right">
			 			  GSTIN : <?php echo $pharmacyInfo[0][2]; ?>
						</td>
						
		
				</tr>
            </table>

            <hr style="border-color:#000000;" />

            <table width="95%" class="user_details">
                <tr style="height: 0px;">
						<td style="text-transform: uppercase;font-size: 16px;">
			 				 <b>patient : <?php echo $invoice_info[0][4]; ?></b>
						</td>
						
						<td align="right">
			 			  Bill Number : <?php echo $invoice_info[0][1];?>
						</td>
						
		
				</tr>
				<tr style="height: 0px;">
						
						<td style="font-size: 16px;"><b>
		 					<?php  if($invoice_info[0][2] == "OP"){
										
										 echo "OP.NO : ".$invoice_info[0][34];

								   }else if($invoice_info[0][2] == "IP"){
										
										 echo "IP.NO : ".$invoice_info[0][33];

								   }else{
											
										 echo "DIRECT PATIENT";       
							      } 
							?></b>
						</td>

						<td align="right" >

						<?php

                              $date = explode(' ', $invoice_info[0][5]);
                              $bill_date=$date[0];
                              $bill_time=$date[1];
						?>
			 				 
			 				    Date : <?php echo $bill_date; ?>

						</td>
					</tr>
					<tr style="height: 0px;">
						
						<td>
		 					    Doctor : <?php echo $invoice_info[0][30];?>
						</td>
						<td align="right" >
			 				    Time : <?php echo $bill_time; ?>
						</td>
					</tr>
            </table>
				
			<table width="95%" class="user_details" id="main_table">

                        <tr>
					        <td colspan="14">
					            <hr style="border-color:#000000;" />
					        </td>
					    </tr>
					    <tr>
				            <th class="font_th" >Sl</th>
				            <th class="font_th" >Particulars</th>
				            <th class="font_th" >Qty</th>
				            <th class="font_th" >HSN Code</th>
				            <th class="font_th" >Mfr</th>
				            <th class="font_th" >Batch</th>
				            <th class="font_th" >Expiry</th>
				            <th class="font_th" >MRP</th>
				            <th class="font_th" >Rate</th>
				            <th class="font_th" >Amt</th>
				            <th class="font_th" >Tax%</th>
				            <th class="font_th" >CGST</th>
				            <th class="font_th" >SGST</th>
				            <th class="font_th" >Total</th>
				        </tr>
				        <tr>
				            <td colspan="14">
					            <hr style="border-color:#000000;" />
					        </td>
					    </tr>

		<?php        
                if(!empty($invoice_item_Info)){				
				    $j=1;
				    for($i=0;$i<count($invoice_item_Info);$i++) {
		?>						
				        <tr>
				            <td ><?php echo $j++; ?></td>
							<td ><?php echo $invoice_item_Info[$i][12]; ?></td>
							<td ><?php echo $invoice_item_Info[$i][9]; ?></td>
							<td ><?php echo $invoice_item_Info[$i][28]; ?></td>
							<td ><?php echo substr($invoice_item_Info[$i][13],0,4); ?></td>
							<td ><?php echo $invoice_item_Info[$i][6]; ?></td>
							<td ><?php echo date('m/y',strtotime($invoice_item_Info[$i][7])); ?></td>
							<td ><?php echo $invoice_item_Info[$i][20]; ?></td>
							<td ><?php echo $invoice_item_Info[$i][10]; ?></td>
							<td><?php echo  $invoice_item_Info[$i][10]*$invoice_item_Info[$i][9]; ?></td>
							<td><?php echo !empty($invoice_item_Info[$i][14])?$invoice_item_Info[$i][14].'%':''; ?></td>
							<td><?php echo $invoice_item_Info[$i][25]; ?></td>
							<td><?php echo $invoice_item_Info[$i][24]; ?></td>
							<td><?php echo $invoice_item_Info[$i][11]; ?></td>
				        </tr>
		<?php
		            }
		        }
		?>	
		</table>
		<table width="95%" class="user_details">
		    <tr>
				<td colspan="2">
					<hr style="border-color:#000000;" />
			    </td>
			</tr>

		    <tr>
		        <td></td>
		        <td align="right">

		           <table style="width: 100% !important;">
	
 						<tr style="height: 0px !important;">

 						    <td colspan="13" align="right"> 
 						         CGST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][45];?>
 						         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 						    </td>

 							<td>
 							     Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][10];?>
 								
 							</td>
  							
 						</tr>

 						<tr style="height: 0px !important;">

 						    <td colspan="13" align="right"> 
 						         SGST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][46];?>
 						         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 						    </td>
 						</tr>

 						<tr style="height: 0px !important;">
 						<td colspan="13" align="right"> 
 						         TOTAL GST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][44];?>
 						         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 						    </td>
 						</tr>
 						<tr>
 						    <!-- flood cess 1% -->
 					    <td colspan="13" align="right"> 
 						         TOTAL FLOOD CESS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][54];?>
 						         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 						</td>
                       
                        <!-- flood cess 1% -->
 							<td style="font-size: 24px !important;"><b>
 							     Net Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $invoice_info[0][14];?>
 								</b>
 							</td>
  							
 						</tr>
 				   </table>
 				</td>
 			</tr>

 						<tr>
 							<td colspan="2">
 								<h5 style="font-size: 7px;">Rupee (s) <?php  echo convertNumberToWord($invoice_info[0][14]); ?> Only</h5>
 							</td>
 						</tr>

 						<tr>
				            <td colspan="2">
					            <hr style="border-color:#000000;margin-top: -7px;" />
					        </td>
					    </tr>

					    <tr>
					    	<td>Prepared By &nbsp;: &nbsp;<?php echo $invoice_info[0][25];?></td>
					    	<td align="right"> 
 						         (Signature of Pharmacist)
 						         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 						    </td>
					    </tr>

					    <tr style="height: 25px !important;">
					          <td colspan="2" style="font-size: 9px !important;">
					              1.Please verify the medicines and balance amount if any,before leaving the Pharmacy Counter.<br>
					              2.Sales return would be accepted only one the production of the original bill(conditions apply).<br>
					              3.Refrigerated items once sold will not be taken back.
					          </td>
					    </tr>

		    </table>   
				
				        <div align="center">
             				 <?php 

             				 	if (empty($popup_path)) {?>
             				 		<input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printinvoice()">
             				 	
             				 	<?php
                                    if (empty($from_path) ){  
             				    ?>
             				 		  <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack()">
                                <?php
                                        if(!empty($credit_bill_status) && $credit_bill_status=='YES'){
                                ?>
                                            <button type="button" class="btn btn-danger flash-button DONTPrint" onclick="goToProcedureBilling('<?php echo $credit_bill_date; ?>','<?php echo $ref_no; ?>')">
                                                  <span class="glyphicon glyphicon-warning-sign"></span> Procedure Billing
                                            </button>
                                <?php
                                        }
                                ?>
             				    <?php
             				        }elseif(!empty($from_path)){
             				    ?>
             				          <input type="button" name="but" value="Close" class="btn btn-danger DONTPrint" onclick="closeTab()">    
             				<?php      	
             				        }
             				 	}

             				?>
         
                        </div>
          </section><!-- /.content -->
    </div><!-- /.container -->
<!-- hidden fields -->
<?php
    $to_day=date("d-m-Y");

    $from_date=$this->input->post("from_date");
    $end_date=$this->input->post("end_date");
    $bill_no=$this->input->post("bill_no");
    $payment_type=$this->input->post("payment_type");
	$customer_type=$this->input->post("customer_type");
	$patient_id=$this->input->post("patient_id");
	$bill_status=$this->input->post("bill_status");
	$current_page=$this->input->post("current_page");
 
    if($bill_no=='' && $payment_type=='' && $customer_type=='' && $patient_id=='' && $bill_status=='ACTIVE'){
      
        if($from_date==$to_day && $end_date==$to_day){
      
          $from_date='';
	      $end_date='';

        } 

	}
?>
    <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
    <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
    <input type="hidden" name="bill_no" id="bill_no" value="<?php echo $bill_no; ?>">
    <input type="hidden" name="payment_type" id="payment_type" value="<?php echo $payment_type; ?>">
    <input type="hidden" name="customer_type" id="customer_type" value="<?php echo $customer_type; ?>">
    <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>">
    <input type="hidden" name="bill_status" id="bill_status" value="<?php echo $bill_status; ?>">

    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
    <input type="hidden" name="ref_no" id="ref_no" value="">
<!-- hidden fields -->
</form>    

<?php
	  $this->load->view("footer"); 
?>
<script type="text/javascript">

function goBack(){
      	
    document.print_invoice.action="<?php echo base_url(); ?>index.php/invoice/manage_invoice";
    document.print_invoice.submit();

}

function goToProcedureBilling(cr_billdate,ref_no){

	$('#from_date').val(cr_billdate);
	$('#end_date').val(cr_billdate);
    $('#ref_no').val(ref_no);

    document.print_invoice.action="<?php echo base_url(); ?>index.php/hcare_credit_billing/credit_billing";
    document.print_invoice.submit();

}

function closeTab(){

	window.top.close();

}
	
function printinvoice(){
      	
    window.print();

 }

</script>