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
  .paid{
    color: green;
    font-weight: 700;
    font-size: 15px !important;
  }
</style>

<form name="manage_invoice" id="manage_invoice" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  INVOICE LIST
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $delete_msg = $this->session->flashdata('delete_msg'); 
                        if(!empty($delete_msg)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $delete_msg; ?></div>
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

                        Cust Type : 
                </td>
                <td>
                        <select name="customer_type" id="customer_type" onkeypress="nextField(event.keyCode,Search);">
                            <option value="" selected="selected">----------</option>
                            <option value="DIRECT" <?php echo (!empty($cust_type_select) && $cust_type_select=='DIRECT')?'selected':'' ?> >DIRECT</option>
                            <option value="OP" <?php echo (!empty($cust_type_select) && $cust_type_select=='OP')?'selected':'' ?> >OP</option>
                            <option value="IP" <?php echo (!empty($cust_type_select) && $cust_type_select=='IP')?'selected':'' ?> >IP</option>
                        </select>
                         
                </td>
                <td>
                         Patient Id : 
                </td>
                <td>
                        <input type="text" name="patient_id" id="patient_id" value="<?php echo !empty($patient_id)?$patient_id:'' ?>" autocomplete="off">
                         
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

                        Payment Type : 
                </td>
                <td>
                          <select name="payment_type" id="payment_type" onkeypress="nextField(event.keyCode,Search);">
                              <option value="" selected="selected">----------------</option>
                              <option value="CASH" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CASH') )?'selected':''; ?> >CASH</option>
                              <option value="CREDIT" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CREDIT') )?'selected':''; ?> >CREDIT</option>
                              <option value="CHEQUE" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CHEQUE') )?'selected':''; ?> >CHEQUE</option>
                              <option value="CREDIT CARD" <?php echo (!empty($payment_type_select) && ($payment_type_select=='CREDIT CARD') )?'selected':''; ?> >CREDIT CARD</option>
                              <option value="BRANCH" <?php echo (!empty($payment_type_select) && ($payment_type_select=='BRANCH') )?'selected':''; ?> >BRANCH</option>
                              <option value="UPI" <?php echo (!empty($payment_type_select) && ($payment_type_select=='UPI') )?'selected':''; ?> >UPI</option>
                          </select> 
                         
                </td>
                <td>
                       Bill Status : 
                </td>
                <td>

                        <select name="bill_status" id="bill_status" onkeypress="nextField(event.keyCode,Search);">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="CANCELLED" <?php echo (!empty($bill_status) && ($bill_status==1) )?'selected':''; ?> >CANCELLED</option>
                        </select>
                  
                </td>
                
            </tr>
            <tr>
                  <td colspan="8" align="center">
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
		  </div> <!--row-->
       <div class="row">

           <div class="col-md-9" id="success">
              <?php echo !empty($message)?$message:''; ?>
             
           </div>

           <div class="col-md-3">
             
                    <?php echo $pagination_link; ?>
              
           </div>
        </div>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">

					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Bill Type</a></th>
                    <th class="font_th"><a href="#">Bill No</a></th>
                    <th class="font_th"><a href="#">Cust Type</a></th>
				            <th class="font_th"><a href="#">OP/IP NO</a></th>
                    <th class="font_th"><a href="#">Customer Name</a></th>
				            <th class="font_th"><a href="#">DOCTOR</a></th>
				            <th class="font_th"><a href="#">Payment Type</a></th>
                    <th class="font_th"><a href="#">Net Total</a></th>
                    <th class="font_th"><a href="#">Card Amount</a></th>
                    <th class="font_th"><a href="#">Checque Amount</a></th>
                    <th class="font_th"><a href="#">UPI Amount</a></th>
				            <th class="font_th"><a href="#">Cash Amount</a></th>
                    <th class="font_th"><a href="#">Credit Paid</a></th>
                    <th class="font_th"><a href="#">Balance</a></th>

<?php   if(!empty($bill_status) && $bill_status == 1){?>
                    <th class="font_th"><a href="#">Cancellation Details</a></th>
                    <th class="font_th"><a href="#">Cancellation Date</a></th>
<?php }?>
                    <th class="font_th"><a href="#">Update History</a></th>
                    <th class="font_th"><a href="#">OP REG</a></th>
                    <th class="font_th"><a href="#">Action</a></th>
				    
				        </tr>
		<?php        
                if(!empty($billInfo)){	//var_dump($billInfo);	
				          $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($billInfo);$i++) {
		?>						
				        <tr>
				          <td><?php echo $j++; ?></td>
                        
                        <td><?php echo $billInfo[$i][5];?></td>
                        <td><?php echo $billInfo[$i][37];?></td>
                        <td><?php echo $billInfo[$i][1];?></td>
                        <td><?php echo $billInfo[$i][2];?></td>
                        <?php if($billInfo[$i][2] == "OP"){?>
                    
                            <td><?php echo $billInfo[$i][43]."/".$billInfo[$i][34];?></td>
                    <?php }else if($billInfo[$i][2] == "IP"){?>
                    
                           <td><?php echo $billInfo[$i][33];?></td>
                    <?php }else{?>
                            <td></td>
                    <?php } ?>
                        <td><?php echo $billInfo[$i][4];?></td>
                        <td><?php echo $billInfo[$i][30];?></td>
                        <td><?php echo $billInfo[$i][15];?> 
                 <!-- <?php //if($billInfo[$i][15] =="CREDIT" || $billInfo[$i][11] !=""){?>
                        
                       <br>Sanctioned By <?php echo $billInfo[$i][35];?><br> -->
                      <!-- Remarks:<?php echo $billInfo[$i][36];
                     // }
                        ?>-->
                        </td>
                        <td><?php echo $billInfo[$i][14];?></td>
                        <td><?php echo $billInfo[$i][18];?></td>
                        <td><?php echo $billInfo[$i][17];?></td>
                        <td><?php echo $billInfo[$i][61];?></td>
                        <td><?php echo ($billInfo[$i][19]);?></td>
                        <td><?php echo $billInfo[$i][29];?></td>
                        <td><?php echo $billInfo[$i][32];?></td>
              <?php   if($billInfo[$i][28] == 1){?>
              
              
                        <td><?php echo $billInfo[$i][26];?></td>
                        <td><?php echo $billInfo[$i][27];?></td>
              <?php }?>
							           <td><?php echo $billInfo[$i][52];?></td>
                         <td><?php if ($billInfo[$i][60]==1) {?>
                            <span class="paid">YES</span>
                          <?php
                         } ?></td>
						    <td>

                  <button class="btn btn-primary btn-xs" data-title="Print" data-toggle="modal" data-target="#print" onclick="printInvoice('<?php echo $billInfo[$i][1]; ?>','<?php echo $billInfo[$i][37]; ?>')"><span class="glyphicon glyphicon-print"></span></button>
                   <?php if($_SESSION['user_type']== '8'  && $billInfo[$i][37] !="Return")
        {
?>
                <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateInvoice('<?php echo $billInfo[$i][1]; ?>')" title="Go To Purchase"><span class="glyphicon glyphicon-pencil"></span></button>
<?php
        }
?>
<?php

                 
                

    if($this->session->userdata('user_type')==8)
      {
?>
                  <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteInvoice('<?php echo $billInfo[$i][1]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
<?php
      }
?>

                     
						    </td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
                <input type="hidden" name="bill_id" id="bill_id">
                <input type="hidden" name="cancellation_details">
                <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
                <input type="hidden" name="duplicate_print" id="duplicate_print">
                <input type="hidden" name="billtype" id="billtype">

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

    /*......pagination......*/  
      
    $(".next_page").bind('click', function() {

                 var current_page= $("#current_page").val();
                 current_page++;
                 $("#current_page").val(current_page);
                 $("#manage_invoice").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_invoice");
                 $("#manage_invoice").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_invoice").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_invoice");
                 $("#manage_invoice").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_invoice").attr("action","<?php echo base_url(); ?>index.php/invoice/manage_invoice");
                 $("#manage_invoice").submit();
    });

  });

function searchForm(){
      
      $("#current_page").val('');
      document.manage_invoice.action="<?php echo base_url(); ?>index.php/invoice/manage_invoice";
      document.manage_invoice.submit();

}

function clearForm(){

      window.location = "<?php echo site_url('invoice/manage_invoice'); ?>";
      return false;

}

function printInvoice(id,bill_type) {
 
        $('#bill_id').val(id);
        $('#duplicate_print').val('duplicate');
        $('#billtype').val(bill_type);
        
        document.manage_invoice.action='<?php echo base_url(); ?>index.php/invoice/print_invoice';
        document.manage_invoice.submit();
        
}

function deleteInvoice(id) {
        
        var v=confirm("Do You Want To Delete!");
        
    if(v) {
    
      var details=prompt("Please Enter Cancellation Details:","");
        
        if(details!= null){
          
          document.manage_invoice.cancellation_details.value=details;
          document.manage_invoice.action='<?php echo base_url(); ?>index.php/invoice/delete/'+id;
          document.manage_invoice.submit();
          return true;
          
        }else{
          return false;
        }
        
      
      
    }else return false;
       
     }



function updateInvoice(id){

        $('#bill_id').val(id);
        
        document.manage_invoice.action='<?php echo base_url(); ?>index.php/invoice/update_invoice';
        document.manage_invoice.submit();

}
</script>