<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        padding-top: 15px;
        font-size: 14px;    
   }	
   .single{
            display:inline;
   }
</style>

<form name="credit_payments_list" id="credit_payments_list" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                 CREDIT PURCHASE LIST
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $error_message = $this->session->flashdata('error_message'); 
                        if(!empty($error_message)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $error_message; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
            
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>
                         From Date : 
                </td>
                <td>
                          <input type="text" name="from_date" id="from_date" value="<?php echo !empty($from_date)?$from_date:'' ?>" autocomplete="off" readonly="true">             
                </td>
                <td>
                         End Date : 
                </td>
                <td>
                          <input type="text" name="end_date" id="end_date" value="<?php echo !empty($end_date)?$end_date:'' ?>" autocomplete="off" readonly="true">       
                </td>
                <td>
                         Supplier : 
                </td>
                <td>
                         <select name="supplier" id="supplier">
                            <option value="" selected="selected">------select-----</option>

        <?php
                for($i=0; $i<count($suppliers); $i++) 
                    { 
        ?>
                           <option value="<?php echo $suppliers[$i][0]; ?>" <?php echo (!empty($supplier_selected) && ($supplier_selected==$suppliers[$i][0]) )?'selected':''; ?> ><?php echo $suppliers[$i][1]; ?></option>         
        <?php
                    }
        ?>                    

                         </select>
                         
				        </td>
				        
				    </tr>
            <tr>
                <td>

                        Bill No : 
                </td>
                <td>
                          <input type="text" name="bill_no" id="bill_no" value="<?php echo !empty($bill_no)?$bill_no:'' ?>" autocomplete="off"> 
                         
                </td>
                 <td>

                        PO No : 
                </td>
                <td>
                          <input type="text" name="pono" id="pono" value="<?php echo !empty($pono)?$pono:'' ?>" autocomplete="off"> 
                         
                </td>
                <td>

                        Inv No : 
                </td>
                <td>
                          <input type="text" name="inv_no" id="inv_no" value="<?php echo !empty($inv_no)?$inv_no:'' ?>" autocomplete="off"> 
                         
                </td>
                
            </tr>
            <tr>
                           <td colspan="6" align="center">
                              <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>
                              <button type="button" class="btn btn-danger" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                              </button>

                           </td>
            </tr>
           
                   
				  </table>
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->

       <div align="right"> 
          <?php 
             // $user_type_logged_in=$_SESSION['user_type'];
           //   if($_SESSION['user_type']=='PHARMA_ADMIN'){?>
             <input type="button" name="check_all" id="check_all" class="btn btn-success" value="Check/Uncheck All">

                <input type="button" name="pay_all" id="pay_all" class="btn btn-warning" value="Pay Selected">
             <!-- <a href="#" class="btn btn-success btn-flat" onclick="payAll();"  class="add">PAY SELECTED BILL</a> -->
                        
              <?php //}?>
        </div><br>
		  </div> <!--row-->
        <div class="row">

           <div class="col-md-12" id="success">
              <?php echo !empty($message)?$message:''; ?>
             
           </div>

        </div>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">

					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Bill Type</a></th>
                    <th class="font_th"><a href="#">Inv No</a></th>
                    <th class="font_th"><a href="#">Bill No</a></th>
                    <th class="font_th"><a href="#">PO No</a></th>
				            <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Entry Date</a></th>
				            <th class="font_th"><a href="#">Supplier</a></th>
                    <th class="font_th"><a href="#">Payment Type</a></th>
				            <th class="font_th"><a href="#">Net Total</a></th>
				            <th class="font_th"><a href="#">Card Amount</a></th>
                    <th class="font_th"><a href="#">Checque Amount</a></th>
                    <th class="font_th"><a href="#">Cash Amount</a></th>
                    <th class="font_th"><a href="#">UPI Amount</a></th>
                    <th class="font_th"><a href="#">NEFT Amount</a></th>
                    <th class="font_th"><a href="#">Adjust Balance</a></th>
<!--  -->
                    <th class="font_th"><a href="#">Balance</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
                      <?php 
             
           //   if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
              
              <th ><a href="#"><?php echo "PAY"; ?></a></th>                               
                             <?php //}?>  
				    
				        </tr>
		<?php        
                if(!empty($purchaseInfo)){	//var_dump($purchaseInfo)	;				
				          $j= 1;
				    for($i=0;$i<count($purchaseInfo);$i++) {
		?>						
				        <tr>
				          <td><?php echo $j++;?></td>
                  <td><?php echo $purchaseInfo[$i][31];?></td>
					        <td><?php echo $purchaseInfo[$i][1];?></td>
							    <td><?php echo $purchaseInfo[$i][27];?></td>
							    <td><?php echo $purchaseInfo[$i][2];?></td>
							    <td><?php echo $purchaseInfo[$i][3];?></td>

                  <td><?php echo date("d-m-Y",strtotime($purchaseInfo[$i][28]));?></td>
                  <td><?php echo $purchaseInfo[$i][5];?></td>
                  <td><?php echo $purchaseInfo[$i][18];?></td>
                  <td><?php echo $purchaseInfo[$i][17];?></td>
                  <td><?php echo $purchaseInfo[$i][21];?></td>

                  <td><?php echo $purchaseInfo[$i][20];?></td>


                   <td><?php echo $purchaseInfo[$i][45];?></td>
                   <td><?php echo $purchaseInfo[$i][51];?></td>
                  <td><?php echo $purchaseInfo[$i][48];?></td>

                  <td><?php echo $purchaseInfo[$i][47];?></td>
                  <td><?php echo $purchaseInfo[$i][44];?></td>

							    
                  <td>
                      <a href="#"   class="add_payment" id="<?php echo $purchaseInfo[$i][1];?>">Add payment</a> 
                  </td>


              <?php 
              
             // if($user_type_logged_in=='ADMIN' || $user_type_logged_in=='ADMIN+DOCTOR'){?>
              
              
              <td><input type="checkbox"   value="<?php echo $purchaseInfo[$i][1]."#".date("Y-m-d H:i:s")."#".$purchaseInfo[$i][18]."#".$purchaseInfo[$i][44]."#".$purchaseInfo[$i][44];?>" name="paybill[]" id="paybill<?php echo $i;?>" title="<?php echo "Bill No: ".$purchaseInfo[$i][1];?>">

                <input type="hidden"   value="<?php echo $purchaseInfo[$i][1]."#".date("Y-m-d H:i:s")."#".$purchaseInfo[$i][18]."#".$purchaseInfo[$i][23]."#".$purchaseInfo[$i][23];?>" name="pay_bill[]" id="pay_bill<?php echo $i;?>" title="<?php echo "Bill No: ".$purchaseInfo[$i][1];?>">


          
              </td>
                <?php 
              //  }?>
              
						  
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
                <input type="hidden" name="purchase_id" id="purchase_id">
                <input type="hidden" name="credit_amount" id="credit_amount">
                <input type="hidden" name="payment_type_selected" id="payment_type_selected">
                <input type="hidden" name="neft_amount" id="neft_amount">
                <input type="hidden" name="adjust_amount" id="adjust_amount">
                <input type="hidden" name="upi_amount" id="upi_amount">



					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">

$(function () {
   
     //Date range picker
        $('#from_date').datepicker();
        $('#end_date').datepicker();
     
});

$(document).ready(function(){

    $(".add_payment").bind('click', function() {
    
      var id=$(this).attr("id");
      
      tb_show('Add Credit Payment',"<?php echo base_url(); ?>index.php/purchase/credit_payment_form/"+id);
    });

});

function tb_remove(){
  
  document.credit_payments_list.action='<?php echo base_url(); ?>index.php/purchase/credit_payment';
  document.credit_payments_list.submit();
}

function searchForm(){
      
      document.credit_payments_list.action="<?php echo base_url(); ?>index.php/purchase/credit_payment";
      document.credit_payments_list.submit();

}

function clearForm(){

      window.location = "<?php echo site_url('purchase/credit_payment'); ?>";
      return false;

}




   // function pay_now(recieving_id,date,doc_fee,doc_id,balance,amount_paid_so_far) {
    
   //    $("#visit_date").val(visit_date);
   //    $("#doc_name").val(doc_name);
   //    $("#doc_fee").val(doc_fee);
   //    $("#doc_id").val(doc_id);
   //    // $("#balance").val(balance);
   //    // $("#amount_paid_so_far").val(amount_paid_so_far);
   //    var id=$(this).attr("id");


   //    document.credit_payments_list.action="<?php echo base_url(); ?>index.php/purchase/credit_payment_form/"+id;
   //    document.credit_payments_list.submit();

   // }
   

  $('#check_all').click(function(){
      var d = $(this).data(); // access the data object of the button
      $(':checkbox').prop('checked', !d.checked); // set all checkboxes 'checked' property using '.prop()'
      d.checked = !d.checked; // set the new 'checked' opposite value to the button's data object
  });

  // $('#pay_all').click(function(){
$("#pay_all").bind('click', function(){

    var amount = 0;

      $("input:checked").each(function () {

          var data = $(this).attr("value");

          data=data.split("#");

//alert(data);
          amount+=Number(data[4]);
          
      });
//alert(amount);
      if (amount==0) {

        showDialog('Error','Please select Atleast One Bill','error',2);
        return false;

      }
     tb_show('Add Multiple Credit Payment',"<?php echo base_url(); ?>index.php/purchase/add_multiple_credits_form/"+amount);
         // tb_show('Add Multiple Credit Payment',"<?php echo base_url(); ?>index.php/purchase/multiple_credit_payment_form/"+amount);

        

  });













 // function payAll(){
 
 //  var isChecked = false;
 //  var total=0;var amt=0;
 //    with (document.credit_payments_list) {
 //      for (i in elements) {
 //        if (elements[i] && elements[i].type == 'checkbox' && elements[i].checked==true) {
 //          isChecked = true;
 //          amt=elements[i].value;          
 //          amt=amt.split("#");
 //          total=total+parseInt(amt[3]);

          
 //          }
         
 //      }
 //    }
      
 //    if(isChecked!=true)
 //    {
 //    alert("Please select atleast one bill");
 //    return false;
 //    }else{ 
 //      tb_show('Add Credit Payment',"<?php echo base_url(); ?>index.php/purchase/multiple_credit_payment_form/"+total);

 //    // var v=confirm("Do you want to pay selected bills; Total Bill Amount :"+total);
 //    // var v=confirm("Do you want to pay selected bills");
 //      // if(v==true){
 //      //     document.credit_payments_list.action="<?php echo base_url(); ?>index.php/purchase/add_MultipleCreditPayment";
 //      // }else{
 //      // return false;
 //      // }
 //      // document.credit_payments_list.submit();
      
 //    }
        
    


 
// }  
</script>

</script>