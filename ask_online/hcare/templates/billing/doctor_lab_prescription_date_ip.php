
<body>
<script>

 $(document).ready(function() {
 
  // $(".date_cal").datepicker({ picker: "<img class='picker' align='middle' src='../../img/cal.gif' alt=''/>" });
			
  });
function redirect(ipno,ippresdate){

	document.select_bill.id.value=ipno;
	document.select_bill.ip_prescribed_date.value=ippresdate;
	document.select_bill.action="../../lib/controllers/centralController.php?module=Billing&sub_module=Billing_Form";
		
	document.select_bill.submit();
			
}
</script>
<form name="op_search" id="op_search"  method="post" action=""> 

<?php
$ip_no=$this  ->popArr['ipno'];
$op_no=$this  ->popArr['opno']; 
$patient_name=$this->popArr['patientname'];
$ip_prescription_date=$this  ->popArr['IpPrescriptionDate'];
// $ip_prescription_status=$this  ->popArr['IpPrescriptionStatus'];
?>
 <section class="content-header">
        <table class="table table-striped">
         	<tr>
         		<th>Name:  <?php echo $patient_name; ?></th>
         		<th>IP NO: <?php echo $ip_no; ?></th>
         		<th>OP NO: <?php echo $op_no; ?></th>
         	</tr>

        </table>	
		  
        </section>
 
		<section class="content">
					 
			<div class="box box-info">
                
               <div class="box-body">
				<table class="table table-striped">				
						<tr> 
						<th><b style="font-size: 16px;color: black;">SL NO</b></th>
						<th><b style="font-size: 16px;color: black;">Date</b></th>
						<th><b style="font-size: 16px;color: black;">Action</b></th>
						<th><b style="font-size: 16px;color: black;">Status</b></th>
						</tr>
<?php
        if(!empty($ip_prescription_date)){
			$j=1;
			for($i=0;$i<count($ip_prescription_date);$i++){
?>
					<tr> 
						<th><a href="#"><?php echo $j++;?></a></th>
						<th><a href="#"><?php echo $ip_prescription_date[$i][0];?></a></th>
						<th><input type="button" name="submit" value="Go to Billing" onclick="redirect('<?php echo $ip_no; ?>','<?php echo $ip_prescription_date[$i][0];?>')" class="btn btn-info" id="submit"></th>
						<th>
							<a href="#" style="color: #e11919;">
							  <?php echo (!empty($ip_prescription_date[$i][1]))?'Billed':''; ?>
							</a>
						</th>
					</tr>
<?php
            }
        }
?>
						 	
				
				</table>
				</div>
			</div>
				
	
			
       			
				
			
				
            </div>
           
      </div>
	  <input type="hidden" name="paction" id="paction" />
	   <script>
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
	
</form>	  

</body>