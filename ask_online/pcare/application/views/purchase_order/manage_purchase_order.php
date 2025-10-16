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

<form name="manage_purchaseorder" id="manage_purchaseorder" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  PURCHASE ORDER LIST
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php
                        $delete_success = $this->session->flashdata('delete_success'); 
                        $email_success = $this->session->flashdata('email_success');
                        $email_error = $this->session->flashdata('email_error');
                        if(!empty($delete_success)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $delete_success; ?></div>
                        <?php
                            }
                        if(!empty($email_success)) 
                            {
                        ?>
                              <div id='message' class="callout callout-success"><?php echo $email_success; ?></div>   
                        <?php
                            }
                        if(!empty($email_error)) 
                            {
                        ?>
                              <div id='message' class="callout callout-danger"><?php echo $email_error; ?></div>  
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
                           <option value="<?php echo $suppliers[$i][0]; ?>" <?php echo (!empty($supplier_selected) && $supplier_selected==$suppliers[$i][0])?'selected':'' ?> ><?php echo $suppliers[$i][1]; ?></option>         
        <?php
                    }
        ?>                    

                         </select>
                </td>
                <td>
                        PO No :
                </td> 
                <td>
                          <input type="text" name="pono" id="pono" value="<?php echo !empty($pono)?$pono:'' ?>" autocomplete="off">    
                </td>
            </tr>
            <tr>
                <td>Purchase Status : </td>
                <td> 
                      <select name="purchase_status" id="purchase_status">
                         <option value="">---------------</option>
                         <option value="PENDING" <?php echo (!empty($purchase_status_selected) && $purchase_status_selected=='PENDING')?'selected':'' ?> >PENDING</option>
                         <option value="RECIEVED" <?php echo (!empty($purchase_status_selected) && $purchase_status_selected=='RECIEVED')?'selected':'' ?> >RECIEVED</option>
                      </select>
                </td>
                <td>Show Deleted : </td>
                <td>
                      <input type="checkbox" name="show_deleted" id="show_deleted" value="show_deleted" readonly="" <?php echo !empty($show_deleted)?'checked':'' ?> >
                </td>
                <td>
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
<?php
              if(empty($pagination_status)){ 

                  echo $pagination_link;
              }
?>
           </div>
        </div>


		  <div class="row">
			 <div class="col-md-12">
  <div id ="emailSentLoading" style="display:none;text-align: center;"><img id = "myImage" src ="<?php echo base_url(); ?>application/assets/dist/img/loop_loader.gif"></div>
				<div class="box box-info">
                         
                    <div class="box-body">
    
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Date</a></th>
				            <th class="font_th"><a href="#">PO No</a></th>
				            <th class="font_th"><a href="#">Supplier</a></th>
				            <th class="font_th"><a href="#">Remarks</a></th>
				            <th class="font_th"><a href="#">Add To Purchase</a></th>
                    <!-- <th class="font_th"><a href="#">Email Status</a></th> -->
                    <!-- <th class="font_th"><a href="#">Sent To Emails</a></th> -->
<?php
      if(!empty($show_deleted) && $show_deleted=='Deleted'){
?> 
                    <th class="font_th"><a href="#">Cancelled By</a></th>
                    <th class="font_th"><a href="#">Cancelled Date</a></th>
                    <th class="font_th"><a href="#">Cancellation Details</a></th>     
<?php
      }
?>                   
				            <th class="font_th"><a href="#">Action</a></th>
				    
				        </tr>
<?php        
                if(!empty($purchase_order_info)){						
				    $j= !empty($next_page)?$next_page+1:1;
				    for($i=0;$i<count($purchase_order_info);$i++) {
?>						
				        <tr>
				            <td><?php echo $j++;?></td>
					        <td><?php echo $purchase_order_info[$i][2];?></td>
							<td><?php echo $purchase_order_info[$i][1];?></td>
							<td><?php echo $purchase_order_info[$i][4];?></td>
							<td><?php echo $purchase_order_info[$i][5];?></td>
							<td>

                    <?php if(!empty($purchase_order_info[$i][6])){
                    ?>
                             Purchase Order Recieved
                    <?php
                    }elseif($purchase_order_info[$i][12]==1){
                    ?>
                             Purchase Order Deleted
                    <?php
                    }else{?>
                             <a href="#" onclick="addToPurchase('<?php echo $purchase_order_info[$i][1]; ?>')"> ADD </a>
                    <?php
                    } ?>
                    
              </td>
<!--               <td>
                  <?php 
                        //if($purchase_order_info[$i][14]==1){
                  ?>
                          <p>Sent</p> 
                  <?php           
                        //}elseif($purchase_order_info[$i][14]==2){
                  ?>
                          <p style="color:#dd4b39;">Failed</p>    
                  <?php
                        //}else{
                         
                  ?>
                          <p>Not Sent</p>     
                  <?php
                        //}
                  ?>
              </td> -->
           <!--    <td>
                    <?php //echo $purchase_order_info[$i][15];?>
              </td> -->

<?php
      if($purchase_order_info[$i][12]==1){
?>
              <td><?php echo $purchase_order_info[$i][9];?></td>
              <td><?php echo $purchase_order_info[$i][10];?></td>
              <td><?php echo $purchase_order_info[$i][11];?></td>           
<?php
      }
?>
					
						    <td>

                 <!-- <button class="btn btn-info btn-xs" data-title="Envelope" data-toggle="modal" data-target="#envelope" onclick="emailToSupplier('<?php //echo $purchase_order_info[$i][1]; ?>','<?php //echo $purchase_order_info[$i][13]; ?>')" title="Send Email"><span class="glyphicon glyphicon-envelope"></span></button> -->

                <button class="btn btn-primary btn-xs" data-title="Print" data-toggle="modal" data-target="#print" onclick="printPurrchaseOrder('<?php echo $purchase_order_info[$i][1]; ?>')"><span class="glyphicon glyphicon-print"></span></button>

<?php 
     if($purchase_order_info[$i][12]==0){

                      if(empty($purchase_order_info[$i][6])){
?>
                      <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updatePurrchaseOrder('<?php echo $purchase_order_info[$i][1]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>
<?php
                      }
?> 

<?php  
                      if(empty($purchase_order_info[$i][6])){
?>
                        <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deletePurrchaseOrder('<?php echo $purchase_order_info[$i][1]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
<?php
                      }
     }
?> 
                     
						    </td>
				        </tr>
<?php
		            }
		        }
?>			   
					   </table>
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="cancellation_details" id="cancellation_details">
                <input type="hidden" name="mail_id" id="mail_id">
                <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">

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
                 $("#manage_purchaseorder").attr("action","<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order");
                 $("#manage_purchaseorder").submit();
    });

    $(".prev_page").bind('click', function() {
              
                 var current_page= $("#current_page").val();
                 current_page--;
                 $("#current_page").val(current_page);
                 $("#manage_purchaseorder").attr("action","<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order");
                 $("#manage_purchaseorder").submit();
    });

    $(".change_page").bind('click', function() {
              
                 var current_page= $(this).attr("id");
                 $("#current_page").val(current_page);
                 $("#manage_purchaseorder").attr("action","<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order");
                 $("#manage_purchaseorder").submit();
    });

  });

function searchForm(){
      
      $("#current_page").val('');
      document.manage_purchaseorder.action="<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order";
      document.manage_purchaseorder.submit();

}

function clearForm(){

        window.location = "<?php echo site_url('purchase_order/manage_purchase_order'); ?>";
        return false;

}

function addToPurchase(id) {
 
        $('#order_id').val(id);
        
        document.manage_purchaseorder.action='<?php echo base_url(); ?>index.php/purchase/process_purchase_order';
        document.manage_purchaseorder.submit();
        
     }

function updatePurrchaseOrder(id) {
 
        $('#order_id').val(id);
        
        document.manage_purchaseorder.action='<?php echo base_url(); ?>index.php/purchase_order/update_purchase_order';
        document.manage_purchaseorder.submit();
        
}

function emailToSupplier(id,email_id){

    var v=confirm("Send Purchase Order to Supplier");
        
    if(v) {
     
            if(email_id==''){

                   var details=prompt("Please Enter Supplier Email :","");

            }else{

                   var details=prompt("Supplier Email :",email_id);

            }
        
      if(details!= null){
          
          document.getElementById("emailSentLoading").style.display="block";

          document.manage_purchaseorder.mail_id.value=details;
          document.manage_purchaseorder.action="<?php echo base_url(); ?>index.php/purchase_order/order_email_to_supplier/"+id;
          document.manage_purchaseorder.submit();
          
         
          return true;
          
      }else{
          return false;
      }  
      
    }else return false;

}

function printPurrchaseOrder(id) {
 
        $('#order_id').val(id);
        
        document.manage_purchaseorder.action='<?php echo base_url(); ?>index.php/purchase_order/print_purchase_order';
        document.manage_purchaseorder.submit();
        
     }

function deletePurrchaseOrder(id) {

       var v=confirm("Do You Want To Delete!");
        if(v) {  

          var details=prompt("Please Enter Cancellation Details:",""); 

          if(details!= null){

             $('#order_id').val(id);
             $('#cancellation_details').val(details);
        
            document.manage_purchaseorder.action='<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order';
            document.manage_purchaseorder.submit();
            return true;

          }else{
          return false;
        }  

        }else return false;
     }

</script>