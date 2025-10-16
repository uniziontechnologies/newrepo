<?php

$batchInfo=$this->session->userdata('batchidInfo');

?>
<style type="text/css">
  .prescription_color{
    font-weight: 700;
    font-size: 17px;
    background: lightgreen;
  }
</style>
<form name="select_patient" id="select_patient"  method="post" action="">
 <div id="wrapper">
            <div id="content">
            <div class="row">
                  <h3>IP PATIENTS LIST</h3>
               <div class="box box-info">
          
                      <div class="box-body">
 
            <table width="100%" class="table table-striped">
            
                <tr>

                <td>
                     From Date : 
                </td>
                <td>
                      <input type="text" name="from_date" id="from_date" value="" readonly="true"/>
                </td>
                <td>
                      End Date : 
                </td>
                <td>
                      <input type="text" name="to_date" id="to_date"  class= 'date_cal' value="" readonly="true"/>
                </td>
                <td>
                      IP No :   
                </td>
                <td>
                      <input name="ipno" id="ipno" tabbindex="2"  onkeypress="nextField(event.keyCode,first_name)" value="" autocomplete="off" size="12"/>   
                </td>
            </tr>
            <tr>
                <td>
                      First Name :   
                </td>
                <td>
                      <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,place)" value="" autocomplete="off"/>   
                </td>
                <td>
                      Place : 
                </td>
                <td>
                      <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,room_no)" value="" />      
                </td>
                <td>
                         Room No : 
                </td>
                <td>
                         <input name="room_no" id="room_no" tabbindex="2" value="" autocomplete="off" size="12"/>
                         
                </td>
                
            </tr>
            <tr>
                           <td colspan="6" align="center">
                              <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>

                              <input type="hidden" name="ip_search" id="ip_search" />
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
                    <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Ip No</a></th>
                    <th class="font_th"><a href="#">Op No</a></th>
                    <th class="font_th"><a href="#">Patient Name</a></th>
                    <th class="font_th"><a href="#">Age</a></th>
                    <th class="font_th"><a href="#">Gender</a></th>
                    <th class="font_th"><a href="#">Place</a></th>
                    <th class="font_th"><a href="#">Admitted On</a></th>
                    <th class="font_th"><a href="#">Time</a></th>
                    <th class="font_th"><a href="#">Room No</a></th>
                    <th class="font_th"><a href="#">Doctor</a></th>
                    <th class="font_th"><a href="#">Prescription</a></th>
            
                </tr>
              </thead>
               <tbody>
<?php 

if($sales_mode=='Return'){

    $url=base_url()."index.php/invoice/invoice_return_form";

}else{

    $url=base_url()."index.php/invoice/invoice_form";

}

            if(!empty($patientInfo)){
              $j=1;
              for($i=0;$i<count($patientInfo);$i++){   
                $patient_name=$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];
                $doctor_name="DR. ".$patientInfo[$i][17]." ".$patientInfo[$i][18];
?>
              
          
              <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $patientInfo[$i][13];?></td>
                <td><?php echo $patientInfo[$i][15];?></td>
                <td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>','<?php echo $patient_name;?>','<?php echo $doctor_name; ?>','<?php echo $url ?>','<?php echo $patientInfo[$i][16] ?>')"><?php echo $patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a></td>
                <td><?php echo $patientInfo[$i][4];?></td>
                <td><?php echo $patientInfo[$i][6];?></td>
                <td><?php echo $patientInfo[$i][8];?></td>
                <td><?php echo date("d-m-Y",strtotime($patientInfo[$i][20]));?></td>
                <td><?php echo $patientInfo[$i][19];?></td>
                <td><?php echo $patientInfo[$i][36];?></td>
                <td><?php echo "DR. ".$patientInfo[$i][17]." ".$patientInfo[$i][18];?></td>
                
                <?php 

                  if (!empty($patientInfo[$i][39]) || !empty($patientInfo[$i][40])) {?>
                    <td class="prescription_color"><?php echo 'YES';?></td>
                  <?php
                  }
                  else{?>
                    <td><?php //echo ' - ';?></td>
                  <?php
                  }

                ?>

                
            </tr>
            
                  
                
          <?php
                }
              }
            
          ?>
              </tbody>
            </table>
          </div>
         </div>
      </div>
              <input type="hidden" name="sales_type" id="sales_type" value="<?php echo $sales_mode; ?>">
            
            </div>
           
      </div>
</form>  

<?php
       $this->load->view("footer"); 
?>

<script type="text/javascript">

    $(function () {
   
     //Date range picker
        $('#from_date').datepicker();
        $('#to_date').datepicker();
   });

function searchForm(){
  
    document.select_patient.ip_search.value="search";
    
    $.post("<?php echo base_url(); ?>index.php/invoice/ip_patient_list", $("#select_patient").serialize(),function(data){
    
    $("table#iplist tbody").html(data['tableInfo']);
    },"json");
}

function redirect(ipno,cust_name,doctor,url,doc_id){
  
    $('#ip_no').val(ipno);
    $('#cust_name').val(cust_name);
    $('#customer_type').val('IP');
    $('#doctor').val(doctor);
    $('#op_id').val('');
    $('#doc_id').val(doc_id);
    
    $('#invoice_form').attr('action',url);
    $('#invoice_form').submit();
    
}

</script>

