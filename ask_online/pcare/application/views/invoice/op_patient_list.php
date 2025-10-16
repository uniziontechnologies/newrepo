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
                  <h3>OP PATIENTS LIST</h3>
               <div class="box box-info">
          
                      <div class="box-body">
 
            <table width="100%" class="table table-striped">
            
                <tr>

                <td>
                      OP No : 
                </td>
                <td>
                      <input type="text" name="opno" size="12" value="" onkeypress="nextField(event.keyCode,name)">
                </td>
                <td>
                      First Name : 
                </td>
                <td>
                      <input type="text" name="name" size="12" value="" onkeypress="nextField(event.keyCode,place)">
                </td>
                <td>
                      Place :   
                </td>
                <td>
                      <input type="text" name="place" value="" size="12" onkeypress="nextField(event.keyCode,lname)">    
                </td>
            </tr>
            <tr>
                <td>
                      Phone Number :   
                </td>
                <td>
                      <input type="text" name="contact_no" value="" size="12" onkeypress="nextField(event.keyCode,date)">   
                </td>
                <td>
                      Date OF Visit : 
                </td>
                <td>
                      <input type="text" name="date" id="date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off" readonly="true">       
                </td>
                <td>
                         Doctor : 
                </td>
                <td>
                         <select name="doctor" id="doctor">
                            <option value="" selected="selected">------select-----</option>

        <?php
                for($i=0; $i<count($doctors); $i++) 
                    { 
        ?>
                        <option value="<?php echo $doctors[$i][0]; ?>"><?php echo $doctors[$i][4]; ?></option>         
        <?php
                    }
        ?>                    

                         </select>
                         
                </td>
                
            </tr>
            <tr>
                           <td colspan="6" align="center">
                              <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                              </button>

                              <input type="hidden" name="op_search" id="op_search" />
                           </td>
            </tr>

            </table>
            </div>
         </div>
         <div class="box box-info">
                
                      <div class="box-body">
              <table width="100%" class="table table-striped table-bordered" id="oplist">
              <thead>
                <tr>
                    <th class="font_th"><a href="#">Sl No</a></th>
                    <th class="font_th"><a href="#">Op No</a></th>
                    <th class="font_th"><a href="#">Patient Name</a></th>
                    <th class="font_th"><a href="#">Age</a></th>
                    <th class="font_th"><a href="#">Gender</a></th>
                    <th class="font_th"><a href="#">Place</a></th>
                    <th class="font_th"><a href="#">Date</a></th>
                    <th class="font_th"><a href="#">Time</a></th>
                    <th class="font_th"><a href="#">Insurance Company</a></th>
                    <th class="font_th"><a href="#">Doctor</a></th>
                    <th class="font_th"><a href="#">Visit Status</a></th>
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
            for($i=0;$i<count($patientInfo);$i++) {

             $patient_name=$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];
             $doctor_name="DR. ".$patientInfo[$i][15]." ".$patientInfo[$i][16];
?>            
            <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $patientInfo[$i][0];?></td>
                <td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>','<?php echo $patientInfo[$i][0];?>','<?php echo $patient_name;?>','<?php echo $doctor_name; ?>','<?php echo $url ?>','<?php echo $patientInfo[$i][14];?>')"><?php echo $patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a>
                <?php if($patientInfo[$i][44] == 'YES' || $patientInfo[$i][44] == 'DISCHARGED') echo "<Br><span class='text-red' ><small>(Observation)</small></span>"; ?>
                </td>
                <td><?php echo $patientInfo[$i][4];?></td>
                <td><?php echo $patientInfo[$i][6];?></td>
                <td><?php echo $patientInfo[$i][8];?></td>
                <td><?php echo date("d-m-Y",strtotime($patientInfo[$i][20]));?></td>
                <td><?php echo $patientInfo[$i][19];?></td>
                <td><?php echo $patientInfo[$i][23];?></td>
                <td><?php echo "DR. ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
                <td><?php echo $patientInfo[$i][32];?></td>

                <?php 

                  if (!empty($patientInfo[$i][45])) {?>
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
        $('#date').datepicker();
   });

function searchForm(){
  
    document.select_patient.op_search.value="search";
    
    $.post("<?php echo base_url(); ?>index.php/invoice/op_patinet_list", $("#select_patient").serialize(),function(data){
  
    $("table#oplist tbody").html(data['tableInfo']);
    },"json");
}

function redirect(opid,opno,cust_name,doctor,url,doc_id){
  
    $('#op_id').val(opid);
    $('#op_no').val(opno);
    $('#cust_name').val(cust_name);
    $('#customer_type').val('OP');
    $('#doctor').val(doctor);
    $('#doc_id').val(doc_id);
    
    $('#invoice_form').attr('action',url);
    $('#invoice_form').submit();
    
}

</script>
