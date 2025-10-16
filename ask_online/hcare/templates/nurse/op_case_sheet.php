 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
 <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />

 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	
	
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>   
	
	<!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
	
<script type="text/javascript">

  $(document).ready(function() { 

	  	 $("#height").blur(function() {

                var height=$("#height").val();
                var weight=$("#weight").val();

            if(height!='' && weight!='')
                {
              	   var bmi;
              	   bmi=bmi_calculation(height,weight);
              	   $("#bmi").val(bmi);
             
                }
            else{
                   $("#bmi").val('');
                }

         });
        
         $("#weight").blur(function(){

              	var height=$("#height").val();
                var weight=$("#weight").val();

            if(height!='' && weight!='')
                {
              	   var bmi;
              	   bmi=bmi_calculation(height,weight);
              	   $("#bmi").val(bmi);

                } 
            else{
                   $("#bmi").val('');  
                }    
              
         }); 

         $("#save").bind('click', function() {
		    
		        $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=save_physical_examination");
   	            $("#form").submit();
		  });	
     });	

     function  bmi_calculation(height,weight){
         
         var height_mtr;
         var bmi_value;
         var bmi;

         height_mtr=height/100;

         bmi_value=weight/(height_mtr*height_mtr);

         bmi=bmi_value.toFixed(1);
         
         return bmi;
     }	  

</script>
</head>
<body id="content">

<?php
$patientInfo=$this  ->popArr['patientInfo'];

$physical_examination=$this  ->popArr['physical_examination'];
$post=$this  ->popArr['post'];

$subtab=$this  ->popArr['subtab'];
if(empty($subtab)) $subtab='physical_exam';

?>
<form name="op_case_sheet" id="form"  method="post" action="">
<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
 

                                               <tr>
                                                  <td id="noborder"><?php echo $lang_op_no; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][0];?>"></td>
                                                   <td id="noborder"><?php echo $lang_name; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3];?>"></td>
                                                    <td id="noborder"><?php echo $lang_age; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][4];?>"></td>
                                              </tr>
                                              <tr>
                                                   <td id="noborder"><?php echo $lang_gender; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][6];?>"></td>
                                            
                                                   <td id="noborder"><?php echo $lang_place; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][8];?>"></td>
                                                   <td id="noborder"><?php echo $lang_doctor; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $patientInfo[0][15]." ".$patientInfo[0][16];?>"></td>
                                               </tr>
                        </table>
				</div>
			</div>	
	 <!-- START CUSTOM TABS -->
        
           
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom bg-gray">
                <ul class="nav nav-tabs">
                  <li class="<?php echo (!empty($subtab) && $subtab == 'physical_exam')?'active' :'';?>"><a href="#tab_1" data-toggle="tab">Physical Examination</a></li>
                  
                </ul>
                <div class="tab-content">
                  <div class="tab-pane <?php echo (!empty($subtab) && $subtab == 'physical_exam')?'active' :'';?>" id="tab_1">
                  	<div class="row">
		
		 <div class="col-md-6">
				<div class="box box-info">
                
               <div class="box-body">
						<table class="table table-striped">
	  
	              <tr>
				                <td ><?php echo $lang_temp;?></td>
								<td><?php echo $lang_pulse;?></td>
								<td><?php echo $lang_bp;?></td>
				  </tr>
				  <tr>
				             <td >
							     <input name="temp" id="temp" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][3];?>' autocomplete="off" onkeypress="nextField(event.keyCode,pulse)"/> F
							</td>
							<td >
							     <input name="pulse" id="pulse" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][4];?>' autocomplete="off" onkeypress="nextField(event.keyCode,bp)"/> bpm
							</td>
								<td >
							     <input name="bp" id="bp" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][5];?>' autocomplete="off" onkeypress="nextField(event.keyCode,height)"/> (mm/hg)
							</td>
				  </tr>
			     
						
						 <tr>
				                <td ><?php echo $lang_height;?></td>
								<td><?php echo $lang_weight;?></td>
								<td><?php echo $lang_bmi;?></td>
				        </tr>
						<tr>
							  <td id="noborder">
							     <input name="height" id="height" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][6];?>' autocomplete="off" onkeypress="nextField(event.keyCode,weight)"/> (cm)
							</td>
							<td id="noborder">
							     <input name="weight" id="weight"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][7];?>' autocomplete="off" onkeypress="nextField(event.keyCode,bmi)"/>  (kgs)
							</td>
							<td id="noborder">
							     <input name="bmi" id="bmi" size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][8];?>' readonly autocomplete="off" onkeypress="nextField(event.keyCode,resp)"/>
							</td>
						</tr>
					 <tr>
				                <td ><?php echo $lang_resp_rate;?></td>
								<td colspan="2"><?php echo $lang_oxy_saturation;?></td>
							    
								
								<!--<th id="noborder">GEN.CONDITION</td>-->
					</tr>
						<tr>
							<td >
							     <input name="resp" id="resp"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][9];?>' autocomplete="off" onkeypress="nextField(event.keyCode,oxygen_satu)"/> rpm
							</td>
							<td colspan="2">
							     <input name="oxygen_satu" id="oxygen_satu"  size="3" value='<?php echo empty($physical_examination)?"":$physical_examination[0][10];?>' autocomplete="off" onkeypress="nextField(event.keyCode,gen_condn)"/> %
							</td>
						</tr>
							<tr>
							  <td colspan="3"><?php echo $lang_gen_condition;?></td>
							  
							</tr>
							<tr>
							  <td colspan="3"><textarea name="gen_condn" id="gen_condn" rows="2" cols="55"><?php echo empty($physical_examination)?"":$physical_examination[0][11];?></textarea>
							  </td>
							 </tr>
							  <tr>
					<td id="noborder" colspan="3" align="center"><input type="button" id="save"  name="Save" class="btn btn-success" value="Save" class="save"/></td>
				    </tr>
		</table>
					</div>
				</div>


<div class="box box-info">

<?php

    $entered_user='';
    $updated_user='';

    $update_history_list=$physical_examination[0][13];
    if(!empty($update_history_list)){

       $count=count($update_history_list);
       $entered_user_position=$count-1;

       $entered_user=$update_history_list[$entered_user_position];

       for ($i=0; $i<count($update_history_list)-1 ; $i++) { 
       	
       	    $updated_user.=$update_history_list[$i]."<br>";
       }

    }

?>
                
        <div class="box-body">
			<table class="table">
			
			 <tbody>
			  <tr>
			     <th>Entered By : </th>
			     <td><div style="background-color: #f5f5c7 !important;"><?php echo $entered_user; ?></div></td>
			 
		     </tr>
		     <tr>
		     	   <td colspan="2"></td>
		     </tr>
		     <tr>
			    
			     <th>Updated By : </th>
			     <td>
			        <div style="background-color: #f5f5c7 !important;">
			         <?php echo $updated_user; ?>
			        </div>
			     </td>
			 </tr>
			
			</tbody></table>
			
		</div>
	 	
		  
</div>
				
			</div>
			 <div class="col-md-6">
               
			<div class="box box-info direct-chat direct-chat-success">

			  <div class="box-header with-border">
		        <b style="font-size: 14px;">EXAMINATION DETAILS</b>
		      </div>
                
               <div class="box-body">
			         <table class="table table-striped">
                     <tr >
					   
					     <td ><b><?php echo $lang_temp;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][3];?>F</td>
						<td><b><?php echo $lang_pulse;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][4];?>bpm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_bp;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][5];?>(mm/hg)</td>
						<td ><b><?php echo $lang_height;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][6];?>cm</td>
					 </tr>
					 <tr >
						<td><b><?php echo $lang_weight;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][7];?>kgs</td>
						<td><b><?php echo $lang_bmi;?></b></td><td><?php echo empty($physical_examination)?"":$physical_examination[0][8];?></td>
					    
					 </tr>
					 <tr >
					   
					     <td colspan="2"><b><?php echo $lang_resp_rate;?></b> <?php echo empty($physical_examination)?"":$physical_examination[0][9];?>rpm</td>
					 </tr>
					 <tr >
						<td colspan="2"><b><?php echo $lang_oxy_saturation;?></b> <?php echo empty($physical_examination)?"":$physical_examination[0][10];?>%</td>
						
					    
					 </tr>
					 <tr>
							  <td colspan="3"><b><?php echo $lang_gen_condition;?></b></td>
							  
							</tr>
							<tr>
							  <td colspan="3"><p><?php echo empty($physical_examination)?"":$physical_examination[0][11];?></p>
							  </td>
							 </tr>
		    
				   </table>
			</div>
        </div>
	</div>
        </div>
                  </div><!-- /.tab-pane -->
                 
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
          

        
          <!-- END CUSTOM TABS -->

<input type="hidden" name="pid" id="pid" value="<?php echo $post['pid']; ?>">
<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $post['doc_id']; ?>">
<input type="hidden" name="op_visit_id" id="op_visit_id" value="<?php echo $post['op_visit_id']; ?>">
<input type="hidden" name="patient_type" id="patient_type" value="<?php echo $post['patient_type']; ?>">
		  
<input type="hidden" name="phid" id="phid" value="<?php echo empty($physical_examination)?"":$physical_examination[0][0];?>">

</form>
</body>
</html>