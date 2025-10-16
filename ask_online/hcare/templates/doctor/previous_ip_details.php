<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<script type="text/javascript">

function closeWin() {
      window.close();
}

</script>
<style>
    p {
        font-size: 16px;
      }
    #close{
            background-color: #f32908;
            border: none;
            color: white;
            padding: 12px 16px;
            font-size: 16px;
            cursor: pointer;
          }
</style>

</head>
<body id="frame">
<form name="previous_ip_details" id="form"  method="post" action=""> 
<?php
	
	$patient_info=$this  ->popArr['patient_info'];

	$patientName=$this  ->popArr['patientName'];

	$ip_no_list=$this  ->popArr['ip_no_list'];

    $admission_date=$this  ->popArr['admission_date'];
    $admission_time=$this  ->popArr['admission_time'];
    $discharge_date=$this  ->popArr['discharge_date'];
    $discharge_time=$this  ->popArr['discharge_time'];

	$presenting_complaints=$this  ->popArr['presenting_complaints'];
    $prov_diagnosis=$this  ->popArr['prov_diagnosis'];
    $procedure_presc=$this  ->popArr['procedure_presc'];
    $labtest_presc=$this  ->popArr['labtest_presc'];
    $medicine_presc=$this  ->popArr['medicine_presc'];
    $physical_examination=$this  ->popArr['physical_examination'];
    $past_history=$this  ->popArr['past_history'];
    $radiology_presc=$this  ->popArr['radiology_presc'];
    $allergicInfo=$this  ->popArr['allergicInfo'];
    $otInfo=$this  ->popArr['otInfo'];
    $details=$this  ->popArr['details'];
    $details_remarks=$this  ->popArr['details'];
    $referalInfo=$this  ->popArr['referalInfo'];
    
?>
<section class="content-header" style="margin-top: -30px;">

     <h3><center><u><b><?php echo $lang_previous." ".$lang_ip." ".$lang_details." (".$patientName.")"; ?></b></u>&nbsp;&nbsp;&nbsp;<button id="close" class="btn" onclick="closeWin()"><i class="fa fa-close"></i></button></center></h3>
		  
</section>

<div class="col-md-1">				 
     <!-- ******NO Data******** -->
</div>

<div class="col-md-10">				 
        <div class="box box-success direct-chat direct-chat-success">
		 
		 <div class="box-header with-border">
		    <!-- <b style="font-size: 13px;"><center><?php echo $lang_complete_note;?></center></b> -->
		    </div>
		  <div class="box-body">

<?php

    if(!empty($patient_info)){

        for($k=0;$k<count($patient_info);$k++){
		  
?>
           	    
                       <div class="box box-success  box-solid">
                          <div class="box-header with-border" style="font-size: 20px;">
                             <?php echo "IP NO: ".$ip_no_list[$k]."  &nbsp;&nbsp;&nbsp;Admission : ".date('d-m-Y',strtotime($admission_date[$k]))." ".date('h:i a',strtotime($admission_time[$k]))."  &nbsp;&nbsp;&nbsp;Discharge : ".date('d-m-Y',strtotime($discharge_date[$k]))." ".date('h:i a',strtotime($discharge_time[$k])) ;?> 
                         
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body" style="padding-left: 30px;">
			    
                                <!-- presenting complaints---->
			  
	<table class="table table-striped">			   
		
<?php
    $presenting_complaints = array_filter($presenting_complaints);
    if(!empty($presenting_complaints)){

?>

        <h4 class="box-title"><u><b><?php  echo $lang_presenting_complaints; ?></b></u></h4>

<?php

        for($i=0;$i<count($presenting_complaints[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">				              
					<p><?php echo $presenting_complaints[$k][$i][3];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $presenting_complaints[$k][$i][4];?></p>
                </div> 
                <div class="col-md-2">
					<p><?php echo date('d-m-Y',strtotime($presenting_complaints[$k][$i][5]));?></p>
				</div>
			</div>
<?php

        }
    }

    $past_history = array_filter($past_history);
    if(!empty($past_history)){

?>

        <h4 class="box-title"><u><b><?php  echo $lang_past_history; ?></b></u></h4>

<?php

        for($i=0;$i<count($past_history[$k]);$i++){

?>		  
	        <div class="row">
	            <div class="col-md-6">		
		            <p><?php echo $past_history[$k][$i][4];?></p>
			    </div>
			    <div class="col-md-2">		
		            <p><?php echo date('d-m-Y',strtotime($past_history[$k][$i][5]));?></p>
			    </div>
			</div>
<?php

        }
    }
    
    $procedure_presc = array_filter($procedure_presc);
    if(!empty($procedure_presc)){

?>

        <h4 class="box-title"><u><b><?php echo ucfirst(strtolower($lang_procedure));?></b></u></h4>

<?php

        for($i=0;$i<count($procedure_presc[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">       
		           <p><?php echo $procedure_presc[$k][$i][4];?></p>
                </div>
                <div class="col-md-2">       
		           <p><?php echo date('d-m-Y',strtotime($procedure_presc[$k][$i][5]));?></p>
                </div>
            </div>
<?php

        }
    }
    
    $radiology_presc = array_filter($radiology_presc);
    if(!empty($radiology_presc)){

?>

        <h4 class="box-title"><u><b><?php echo ucfirst(strtolower($lang_radiology));?></b></u></h4>

<?php

        for($i=0;$i<count($radiology_presc[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">         
		           <p><?php echo $radiology_presc[$k][$i][4];?></p>
		        </div>
		        <div class="col-md-2">         
		           <p><?php echo date('d-m-Y',strtotime($radiology_presc[$k][$i][5]));?></p>
		        </div>
		    </div>

<?php

        }
    }
    
    $labtest_presc = array_filter($labtest_presc);
    if(!empty($labtest_presc)){

?>

        <h4 class="box-title"><u><b><?php echo ucfirst(strtolower($lang_lab))." ".ucfirst(strtolower($lang_test));?></b></u></h4>

<?php

        for($i=0;$i<count($labtest_presc[$k]);$i++){

?>
            <div class="row">
	            <div class="col-md-6"> 	       
		           <p><?php echo $labtest_presc[$k][$i][4];?></p>
		        </div>
		        <div class="col-md-2"> 	       
		           <p><?php echo date('d-m-Y',strtotime($labtest_presc[$k][$i][6]));?></p>
		        </div>
            </div>
<?php

        }
    }
    
    $prov_diagnosis = array_filter($prov_diagnosis);
    if(!empty($prov_diagnosis)){

?>

        <h4 class="box-title"><u><b><?php  echo $lang_diagnosis; ?></b></u></h4>

<?php

        for($i=0;$i<count($prov_diagnosis[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">  
		           <p><?php echo $prov_diagnosis[$k][$i][3];?></p>
		        </div>
		        <div class="col-md-2">  
		           <p><?php echo date('d-m-Y',strtotime($prov_diagnosis[$k][$i][4]));?></p>
		        </div>
		    </div>

<?php

        }
    }

    $medicine_presc = array_filter($medicine_presc);
    if(!empty($medicine_presc)){

?>

        <h4 class="box-title"><u><b><?php echo ucfirst(strtolower($lang_medicine_prescription));?></b></u></h4>

<?php

        for($i=0;$i<count($medicine_presc[$k]);$i++){

?>
            <div class="row">
	            <div class="col-md-6">
		           <p><?php echo $medicine_presc[$k][$i][4];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$k][$i][5];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$k][$i][6];?></p>
                </div>
                <div class="col-md-2">  
		           <p><?php echo date('d-m-Y',strtotime($medicine_presc[$k][$i][7]));?></p>
		        </div>
            </div>
<?php

        }
    }

    $details = array_filter($details);
    if(!empty($details)){

?>

        <h4 class="box-title"><u><b><?php echo 'Advice';?></b></u></h4>

<?php

        for($i=0;$i<count($details[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">	      
		           <p><?php echo $details[$k][$i][3];?></p>
		        </div>
		        <div class="col-md-2">	      
		           <p>
		           	
<?php 
                    if(!empty($details[$k][$i][3])){

                        echo date('d-m-Y',strtotime($details[$k][$i][6]));

                    }
?>
		           		
		           </p>
		        </div>
		    </div>

<?php

        }
    }
    
    $details_remarks = array_filter($details_remarks);
    if(!empty($details_remarks)){

?>

        <h4 class="box-title"><u><b><?php echo 'Remarks';?></b></u></h4>

<?php

        for($i=0;$i<count($details_remarks[$k]);$i++){

?>
	        <div class="row">
	            <div class="col-md-6">	         
		           <p><?php echo $details_remarks[$k][$i][4];?></p>
		        </div>
		        <div class="col-md-2">	      
		           <p>
		         
<?php 
                    if(!empty($details_remarks[$k][$i][4])){

                        echo date('d-m-Y',strtotime($details_remarks[$k][$i][6]));

                    }
?>
		           		
		           </p>
		        </div>
            </div>

<?php

        }
    }

    $physical_examination = array_filter($physical_examination);
    if(!empty($physical_examination)){

?>

        <br><br>
		<h4 class="box-title"><u><b><?php echo 'Physical Examination ';?></b></u></h4>

<?php

        for($i=0;$i<count($physical_examination[$k]);$i++){

?>
            <table class="table table-striped">
              <tr>	
            	<th colspan="4" style="text-align: center;background: #e9e0c1;">
                  <?php echo date('d-m-Y h:i a',strtotime($physical_examination[$k][$i][14])) ;?> 
                </th>
              </tr>
                                      
			  <?php 
			     $examHis=$physical_examination[$k][$i][0];
			  
		            if(!empty($examHis)){?>
				   
					   <tr>
					   
					     <td ><b><?php echo $lang_temp;?></b></td><td><?php echo $physical_examination[$k][$i][3];?>F</td>
						<td><b><?php echo $lang_pulse;?></b></td><td><?php echo $physical_examination[$k][$i][4];?>bpm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_bp;?></b></td><td><?php echo $physical_examination[$k][$i][5];?>(mm/hg)</td>
						<td ><b><?php echo $lang_height;?></b></td><td><?php echo $physical_examination[$k][$i][6];?>cm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_weight;?></b></td><td><?php echo $physical_examination[$k][$i][7];?>kgs</td>
						<td><b><?php echo $lang_bmi;?></b></td><td><?php echo $physical_examination[$k][$i][8];?></td>
					    
					 </tr>
					 <tr >
					   
					     <td colspan="2"><b><?php echo $lang_resp_rate;?></b> <?php echo $physical_examination[$k][$i][9];?>rpm</td>
					 </tr>
					 <tr >
						<td colspan="2"><b><?php echo $lang_oxy_saturation;?></b> <?php echo $physical_examination[$k][$i][10];?>%</td>
						
					    
					 </tr>
					 <tr>
							  <td colspan="3"><b><?php echo $lang_gen_condition;?></b></td>
							  
							</tr>
							<tr>
							  <td colspan="3" ><p><?php echo $physical_examination[$k][$i][11];?></p>
							  </td>
							 </tr>
		    
			</table>
				<?php }?>              

<?php

        }
    }

    $allergicInfo = array_filter($allergicInfo);
    if(!empty($allergicInfo)){

?>

        <br><br>	  
		<h4 class="box-title"><u><b><?php echo 'Allergies';?></b></u></h4>

        <table class="table table-striped">
         <tr>
        	<th>Allergies</th>
        	<th>Description</th>
        	<th>Date</th>
         </tr>
<?php

        for($i=0;$i<count($allergicInfo[$k]);$i++){

?>
            
            
  	     <tr>
        	<td><?php echo $allergicInfo[$k][$i][3]; ?></td>
        	<td><?php echo $allergicInfo[$k][$i][4]; ?></td>
        	<td><?php echo date('d-m-Y',strtotime($allergicInfo[$k][$i][6])); ?></td>
         </tr>
		         
<?php

        }
?>
        </table>
<?php
    }
    
    $otInfo = array_filter($otInfo);
    if(!empty($otInfo)){

?>

        <br><br>	  
		<h4 class="box-title"><u><b><?php echo 'Operation Threatre Note';?></b></u></h4>

        <table class="table table-striped">
         <tr>
        	<th>OT Note</th>
        	<th>Date</th>
         </tr>
<?php

        for($i=0;$i<count($otInfo[$k]);$i++){

?>
            
            
  	     <tr>
        	<td><?php echo $otInfo[$k][$i][5]; ?></td>
        	<td><?php echo date('d-m-Y',strtotime($otInfo[$k][$i][6])); ?></td>
         </tr>
		         
<?php

        }
?>
        </table>
<?php
    }

?>
    </table>

		  </div><!-- /.box-body -->
        </div><!-- /.box -->

<?php

       }
    }else{

?>
   
            <h2><center>NO PREVIOUS IP DETAILS</center></h2>

<?php

    }

?>
					         
</div>
</div>
</div>
</div>
<div class="col-md-1">				 
     <!-- ******NO Data******** -->
</div>
	
</form>
</body>
</html>
