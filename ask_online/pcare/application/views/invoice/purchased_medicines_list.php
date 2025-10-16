<?php

$batchInfo=$this->session->userdata('batchidInfo');

?>
<form name="prescription" id="prescription"  method="post" action="">
 <div id="wrapper">
            <div id="content">
            <div class="row">
                  <h3>PURCHASED MEDICINES LIST</h3>
               <div class="box box-info">
          
                      <div class="box-body">
 
            <table width="100%" class="table table-striped">
            
               <tr>

                 <td>
                     Patient Name : <?php echo $patient_name; ?>
                 </td>
                 <td>
                      
                 </td>
                 <td>
                   IP NO : <?php echo $ip_no; ?>
                 </td>
              </tr>
            </table>
            </div>
         </div>
         <div class="box box-info">
                
                      <div class="box-body">
              <table width="100%" class="table table-striped table-bordered" id="iplist">
              <thead>
                <tr>
                    <th class="font_th"><a href="#">Sl no</a></th>
                    <th class="font_th"><a href="#">Bill Date</a></th>
                    <th class="font_th"><a href="#">Bill No</a></th>
                    <th class="font_th"><a href="#">Brand Name</a></th>
                    <th class="font_th"><a href="#">Batch Name</a></th>
                    <th class="font_th"><a href="#">Qty</a></th>
                    <th class="font_th"><a href="#">Expiry Date</a></th>
                    <th class="font_th"><a href="#">Select Medicine</a></th>
                </tr>
              </thead>
                    <div style="float: right;margin-right: 26px;padding: 10px;">

					  <label style="font-size: 14px;">Select / Deselect all</label> <input type='checkbox' id='checkAll'/>
					
				    </div>
               <tbody>
        <?php if(!empty($medicines_list)){
				 $j=1;
				 for($i=0;$i<count($medicines_list);$i++){
								
		?>
							
						<tr>
							<td><?php echo $j++;?></td>
							<td><?php echo $medicines_list[$i][1];?></td>
							<td><?php echo $medicines_list[$i][0];?></td>
							<td><?php echo $medicines_list[$i][3];?></td>
							<td><?php echo $medicines_list[$i][5];?></td>
							<td><?php echo $medicines_list[$i][8];?></td>
							<td><?php echo $medicines_list[$i][6];?></td>
							<td style="text-align: center;">
						
							  <input type="checkbox" name="select_medicines[]" id="<?php echo $medicines_list[$i][7]; ?>" class="select_medicines" class="selectone" value="<?php echo $medicines_list[$i][7]; ?>">
						
							</td>								

								
							
						</tr>
						
									
								
					<?php
						
						

								}
							}
						
					?>
            </table>
                    <br>
                    <div align="right">
                    	 <input type="button" name="submit" value="Select Medicines" class="btn btn-info" id="submit"  />	
                    </div>
          </div>
         </div>
      </div>
              
        
            </div>
           
      </div>
</form>  

<?php
       $this->load->view("footer"); 
?>

<script type="text/javascript">

$(document).ready(function() {
	 
	 $('#checkAll').click(function(){

	  if ($("#checkAll").is(':checked')) {

		  	var checked_status = this.checked;
		  	$("input[name='select_medicines[]']").each(function(){
	        this.checked = checked_status;
	  		});

	  }
	  else{

	  	  	var checked_status = this.unchecked;
		  	$("input[name='select_medicines[]']").each(function(){
		    this.checked = checked_status;
		  	});

	  }
});
	
$("#submit").click(function(event){
    
	var checked=false;
		 med_list =new Array();
		 var k=0;

	     var elements = document.getElementsByName("select_medicines[]");

	     for(var i=0; i < elements.length; i++){

		    if(elements[i].checked) {

			   checked = true;
               med_list.push(elements[i].id);
			   
			 //add input box
             jQuery('#doctor_prescriptions').append('<input type="hidden" name="med_purchase[]" value='+elements[i].value+' >');
			   k++;
		    }

	    }

	    if (!checked) {

		   showDialog('Error','Please Select atleast One item!','error', 2);
    	   return false;

	    }else{
	   
             
          $('#invoice_form').attr('action',"<?php echo base_url(); ?>index.php/invoice/invoice_return_form");
	      $('#invoice_form').submit();
		  return true;
		}
	
});	
	 
});

</script>

