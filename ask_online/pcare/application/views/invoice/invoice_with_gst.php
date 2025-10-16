<!-- print for dot matrixs, page size 8*6 -->
<?php
  if (empty($popup_path)) {
  $this->load->view("header");
  }
?>

<style type="text/css">
   .font_th{

    font-size: 18px;
   }
   .font_th a{
    font-weight: 700;
    font-size: 20px !important;
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
    size: auto;
    margin:0mm 50mm 0mm 0mm;
}

}
    *{
    /*font-family: "testing" !important;*/
font-family: Arial;
/*font-size: 18.72px;*/
font-style: normal;
font-variant: normal;
font-weight: 400;
line-height: normal;
    font-size: 18px;
    }
.box-body{
padding: 0px !important;
margin-top: 5px !important;
}
.box{
border-top: none;
}
#main_head{
font-size: 23px !important;
}
.sub_head{
        font-size: 18px !important;
        margin-top: -1px;
    }
.user_details{
/*margin-left: 18px;*/
font-size: 12px;
}
.bill_info{
font-size: 12px;
}

h3#cash_bill {
    font-weight: 700 !important;
    text-decoration: underline;
    font-size: 17px !important;
   }
   td{
   font-size: 19px !important;
   }
   .main_content{
      font-size: 15px !important;
      font-weight: 400 !important;
   }


</style>

<form name="print_invoice" id="print_invoice" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
    <?php if (empty($from_path) && empty($popup_path) ) {?>

    <center>  
          <img src="<?php echo base_url(); ?>application/assets/dist/img/logo.png" width="100" style="margin-top: -12px;" class="print_logo"></img>   
          <h2 id="main_head" style="margin-top: 1px;"><?php echo strtoupper($hospitalInfo[0][1]); ?></h2>

          <h4 class="sub_head" style="margin-top: -7px;"><?php echo strtoupper($hospitalInfo[0][2].", ".$hospitalInfo[0][3]); ?>, <?php echo "Ph :".$hospitalInfo[0][7] ; ?></h4>

          <h4 class="sub_head" style="margin-top: -9px;"><?php echo "GST No : ".$pharmacyInfo[0][2].", "."DL No : ".$pharmacyInfo[0][3]; ?></h4>

          <!-- <h4 class="sub_head"><?php //echo $hospitalInfo[0][9]; ?></h4> -->

          <h3 class="sub_head" style="margin-top: -7px;font-size: 10px;text-align: center;" class="sub_head"><b>TAX INVOICE <?php echo ($bill_type=='Return')?strtoupper($bill_type):""; ?></b></h3>
    </center>


    <?php
    } ?>     

<?php
    if(!empty($duplicate)){
?>
          <h6 style="margin-top: -10px;text-align: center;" id="sub_head"><b>(duplicate)</b></h6>
<?php
    }

?>
     
          <!-- Main content -->
          <section class="content">
                   <table width="100%" class="user_details">
                   <tr style="height: 18px;">
<td>
INV NO : <?php echo !empty($invoice_info[0][53])?$invoice_info[0][53]:$invoice_info[0][1];?>
</td>

<td align="right">
  DATE : <?php echo date("d-m-Y",strtotime($invoice_info[0][5]));?>
</td>


</tr>
<tr style="height: 18px;">

<td>
TYPE : <?php echo $invoice_info[0][2]; ?>
</td>
<td align="right" >
<?php if($invoice_info[0][2] == "OP"){?>
OP : 
        <?php echo $invoice_info[0][37]."/".$invoice_info[0][34];?>
<?php }else if($invoice_info[0][2] == "IP"){?>
IP : 
       <?php echo $invoice_info[0][33];?>
<?php }else{?>
 DIRECT:     
<?php } ?>
</td>
</tr>
<tr style="height: 18px;">

<td>
NAME : <?php echo strtoupper($invoice_info[0][4]); ?>
</td>
<td align="right" >
DOCTOR : <?php echo strtoupper($invoice_info[0][30]);?>
</td>
</tr>
                    </table>


  <div class="row">
<div class="col-md-12">
<div class="box box-info">
               
                    <div class="box-body">

   <table width="100%" class="table bill_info" style="width: 100%;margin: 0 auto;margin-top: 10px;">

    <tr>
            <th class="font_th" width="1%"><a href="#">SL</a></th>
            <th class="font_th" width="39%"><a href="#">PARTICULARS</a></th>
            <th class="font_th" width="10%" ><a href="#">MFR</a></th>
            <th class="font_th" width="10%" ><a href="#">BATCH</a></th>
            <!-- <th class="font_th" width="5%" ><a href="#" style="font-size: 14px !important;">SHELF&nbsp;NO</a></th> -->
            <th class="font_th" width="5%" ><a href="#">EXPIRY</a></th>
            <th class="font_th" width="2%" ><a href="#">QTY</a></th>
            <th class="font_th" width="3%" ><a href="#">MRP</a></th>
            <!-- <th class="font_th" width="5%" ><a href="#" style="font-size: 14px !important;">RATE</a></th> -->
            <th class="font_th" width="5%" ><a href="#">GST%</a></th>
<!--             <th class="font_th" width="5%" ><a href="#">CGST</a></th>
            <th class="font_th" width="5%" ><a href="#">SGST</a></th> -->
            <th class="font_th" width="5%" ><a href="#">GST</a></th>
            <th class="font_th" width="5%" ><a href="#">TOTAL</a></th>
        </tr>
<?php       
                if(!empty($invoice_item_Info)){
                    $total_disc_amount=0;
    $j=1;
    for($i=0;$i<count($invoice_item_Info);$i++) {
?>
        <tr>
            <td class="main_content" ><?php echo $j++; ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][12]; ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][13]; ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][6]; ?></td>
            <!-- <td class="main_content" ><?php //echo $invoice_item_Info[$i][40]; ?></td> -->
            <td class="main_content" ><?php echo date("m/Y",strtotime($invoice_item_Info[$i][7])); ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][9]; ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][20]; ?></td>
            <!-- <td class="main_content" ><?php //echo $invoice_item_Info[$i][38]; ?></td> -->
            <td class="main_content" ><?php echo !empty($invoice_item_Info[$i][14])?$invoice_item_Info[$i][14].'%':''; ?></td>
            <td class="main_content" ><?php echo $invoice_item_Info[$i][23]; ?></td>
            <!-- <td class="main_content" ><?php //echo $invoice_item_Info[$i][25]; ?></td>
            <td class="main_content" ><?php //echo $invoice_item_Info[$i][24]; ?></td> -->
            <td class="main_content" ><?php echo $invoice_item_Info[$i][11]; ?></td>
        </tr>
<?php
                      // $total_disc_amount += $invoice_item_Info[$i][39];

            }
        }
?>
<tr>
<td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">TOTAL</td>
  <td class="last_words" style="font-size: 17px !important;"><?php echo $invoice_info[0][10];?></td>
</tr>
<?php if($invoice_info[0][13] > 0){?>
<tr>
<td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">DISCOUNT</td>
  <td class="last_words" style="font-size: 17px !important;"><?php echo $invoice_info[0][13];?></td>
</tr>

<?php } ?>

<tr>
<td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">TOTAL F.CESS</td>
<td class="last_words" style="font-size: 17px !important;"><?php echo $invoice_info[0][54];?></td>
</tr>

<tr>
<td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">R/O</td>
<td class="last_words" style="font-size: 17px !important;"><?php echo $invoice_info[0][42];?></td>
</tr>
<!-- <?php if($invoice_info[0][59] ==1){?>
<tr>
<td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">FREE BILL</td>
<td class="last_words" style="font-size: 17px !important;"><?php echo '-'.$invoice_info[0][10];?></td>
</tr>
<?php }?> -->

<?php 
  
  if ($invoice_info[0][32] > 0) {?>

    <tr>
      <td colspan="8" align="right" class="last_words" style="font-size: 17px !important;">BALANCE</td>
      <td class="last_words" style="font-size: 17px !important;"><?php echo $invoice_info[0][32];?></td>
    </tr>
    
  <?php
  }  
  
?>

    <tr>
<td colspan="8" align="right" class="last_words"  ><b style="font-size: 28px !important">NET TOTAL : </b></td>
<td class="last_words" style="font-size: 28px !important" ><b style="font-size: 28px !important"><?php echo $invoice_info[0][14];?></b></td>
</tr>
<!--<tr>-->
<!-- <td colspan="7" align="right" class="last_words">AMOUNT PAID</td>-->
  <!-- <td class="last_words"><?php echo $invoice_info[0][19];?><br /></td>-->
<!--</tr>-->
<?php if(!empty($invoice_info[0][17])){?>

<!--<tr>-->
<!-- <td colspan="7" align="right" class="last_words">CHECQUE AMOUNT</td>-->
  <!-- <td class="last_words"><?php echo $invoice_info[0][17];?><br /></td>-->
<!--</tr>-->

<?php } ?>
<?php if(!empty($invoice_info[0][18])){?>

<!--<tr>-->
<!-- <td colspan="7" align="right" class="last_words">CARD AMOUNT</td>-->
  <!-- <td class="last_words"><?php echo $invoice_info[0][18];?><br /></td>-->
<!--</tr>-->

<?php } ?>





   <?php
       $total_disc_amount=to_currency($total_disc_amount);
       if(!empty($total_disc_amount) && $total_disc_amount > 0){
                       ?>
       <tr>
       <td colspan="13" align="left">
        <b style="font-size: 12px !important;">
          You Have Saved <?php echo $total_disc_amount; ?> Rupees
        </b>
    </tr>
   <?php
       }
   ?>

               </table>  
              
               <h5 style="margin-top: -9px;font-size: 12px;text-align: right;margin-right: 10% !important;">

                            <b><?php echo $this->session->userdata('employee_name');?><br>(Pharmacist)</b>

               </h5>
</div>
</div>
        <div align="center">
             <?php

             if (empty($popup_path)) {?>
             <input type="button" name="but" value="Print" class="btn btn-info DONTPrint" onclick="printinvoiceData()">
             <input type="button" name="but" value="Back" class="btn btn-danger DONTPrint" onclick="goBack()">
             <input type="button" name="but" value="New Invoice" class="btn btn-primary DONTPrint" onclick="newReg()">
             <?php
             }

               ?>
        
                        </div>
</div>
</div><!--row-->
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
<!-- hidden fields -->
    <input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">

    <input type="hidden" name="hospital_info" id="hospital_info" value="<?php echo base64_encode(serialize($hospitalInfo));; ?>">
    <input type="hidden" name="invoice_info" id="invoice_info" value="<?php echo base64_encode(serialize($invoice_info)); ?>">
    <input type="hidden" name="invoice_item_Info" id="invoice_item_Info" value="<?php echo base64_encode(serialize($invoice_item_Info)); ?>">
     <input type="hidden" name="pharmacyInfo" id="pharmacyInfo" value="<?php echo base64_encode(serialize($pharmacyInfo)); ?>">

</form>   

<?php
  $this->load->view("footer");
?>
<script type="text/javascript">

function goBack() {
     
    document.print_invoice.action="<?php echo base_url(); ?>index.php/invoice/manage_invoice";
    document.print_invoice.submit();

}

function printinvoice() {
     
    window.print();

}
function printinvoiceData() {
     
    document.print_invoice.action="<?php echo base_url(); ?>application/libraries/escpos-php-2.2/print/interface/smb.php";
    document.print_invoice.submit();

}
function newReg() {
     
    window.location = "<?php echo site_url('invoice/invoice_form'); ?>";
    return false;

}

</script>
