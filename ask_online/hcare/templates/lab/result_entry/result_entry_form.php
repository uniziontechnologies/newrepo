
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
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

	<link rel="stylesheet" href="../../dist/css/ajax.css">
   <script type="text/javascript" src="../../ajax/ajax.js"></script>
   <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>

     <!-- tinymce -->
<script type="text/javascript" src="../../plugins/tinymce/tinymce.min.js">  </script>
 <script language="javascript">
 	// Tinymce Script
   var nanospell_directory  = "nanospell/plugin.js";
	// Tinymce Script
	tinymce.init({
	  oninit : "setPlainText",
	  selector: '.tinymce',
      external_plugins: {"nanospell": nanospell_directory},
      nanospell_server: "php", // choose "php" "asp" "asp.net" or "java"
      nanospell_autostart:true,
	  menubar:false,
      statusbar: false,
	  height: 20,
	  theme: 'modern',
	  plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help paste',
	  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
	  image_advtab: true,
	  templates: [
	    { title: 'Test template 1', content: 'Test 1' },
	    { title: 'Test template 2', content: 'Test 2' }
	  ]
	 });
        
	//Tinymce - copy & paste
 	function setPlainText() {
        var ed = tinyMCE.get('elm1');

        ed.pasteAsPlainText = true;  

        //adding handlers crossbrowser
        if (tinymce.isOpera || /Firefox\/2/.test(navigator.userAgent)) {
            ed.onKeyDown.add(function (ed, e) {
                if (((tinymce.isMac ? e.metaKey : e.ctrlKey) && e.keyCode == 86) || (e.shiftKey && e.keyCode == 45))
                    ed.pasteAsPlainText = true;
            });
        } else {            
            ed.onPaste.addToTop(function (ed, e) {
                ed.pasteAsPlainText = true;
            });
        }
    }


   $(document).ready(function () {
    //Disable cut copy paste
    /*$('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });*/
	
	$('#save_result').click(function() {
		
		
		if(!checkresult()){
			 showDialog('Error','Please Enter Lab Result','error',2);
				return false;
				
		}else{
			  // tb_show('User Authentication',"../../lib/controllers/centralController.php?module=Billing&sub_module=credit_bill_authentication&bill_id=0&from=verify_lab_result");
			  $('#form').attr('action',"../../lib/controllers/centralController.php?module=Lab&sub_module=Save_result_entry&auth_id="+<?php echo $_SESSION['user_id']; ?>);
			  $("#form").submit();
              return false;
		}
	});
/*....input field next....*/
 $(function() {

    $('.inputs').keydown(function (e) {
     if (e.which === 13) {
         var index = $('.inputs').index(this) + 1;
         $('.inputs').eq(index).focus();
     }
       });

 });
/*... key press submit button...*/
 $("#save_result").keyup(function(event){
    if(event.keyCode == 13){
        $("#save_result").click();
    }
});

 $('#update_patient_info').click(function() {

 	$('#form').attr('action',"../../lib/controllers/centralController.php?module=Lab&sub_module=update_patient_info&auth_id="+<?php echo $_SESSION['user_id']; ?>);
			  $("#form").submit();
    	
		});



	function checkresult(){
	
		var result_count=document.getElementsByName('result_value[]').length;
		var status=0;
		result_value=document.getElementsByName(['result_value[]']);
		for(i=0;i<result_count;i++){
		
			if(result_value[i].value!=''){
				status=1;
			}
		}
	
		if(status == 0){
			
				return false;
		}else return true;
	
	}
});
    </script>
    <style type="text/css">
    	tr.edit_info_content td {
    padding-bottom: 5px;
}
    </style>

</head>
<body id="frame">
<form name="result_entry" id="form"  method="post" action=""> 
<div id="content">
<?php
	
	$testItemInfo=$this  ->popArr['testItemInfo'];
	$paction=$this  ->popArr['paction'];
	$billno=$this  ->popArr['billno'];
	$billInfo=$this  ->popArr['billInfo'];
	$age=$this  ->popArr['age'];
	$age_type=$this  ->popArr['age_type'];
	$billItemInfo=$this  ->popArr['billItemInfo'];
	$mantoxResult = $this  ->popArr['mantoxResult'];

	$config_obj=new Config_hims();

	// echo $paction;exit;

	// var_dump($testItemInfo);
	
?>
 
		<section class="content">
				<h5 align="center"><b><u><?php echo $lang_result_entry;?></u></b></h5>
				<div class="box box-info">
                
               <div class="box-body">
			   
			   <table width="100%" >
			   
			     <tr>
				    <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_patient;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][3];?></font></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_age;?> / <?php echo $lang_gender;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][4]." / ". $billInfo[0][5];?></td>
					<td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_hosp_id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo strtoupper($billInfo[0][26])."/";echo ($billInfo[0][1]=="OP" || $billInfo[0][1]=="IP")?$billInfo[0][19]:$billInfo[0][2]; ?></font></td>
				 </tr>
				 <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_ref_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][1];?> <?php echo $billInfo[0][2];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_bill_no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][0];?></font></td>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_doctor;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][8];?></font></td>
				 </tr>
				  <tr>
				  <td><font size="<?php echo $lang_font_size;?>"><?php echo $lang_recieved_date;?>&nbsp;&nbsp;&nbsp;:<?php echo date("d-m-Y",strtotime($billInfo[0][16]));?></font></td>
				   <?php 
			   if($paction =="EDIT_PATIENT_INFO"){
			   ?> 
				  <td>
				  	<font size="<?php echo $lang_font_size;?>"><?php echo $lang_email;?>&nbsp;&nbsp;&nbsp;:<?php echo $billInfo[0][49];?></font>
				  </td>
				 <?php }?> 
				  <td></td>
				  </tr>
				  
			   </table>
			   </div>
			   <br>

			   <?php 
			   if($paction =="EDIT_PATIENT_INFO"){
			   ?>

			   <table class="edit_info_table">
			   	
				  <tr class="edit_info_content">
				  	<td width="10%">Name</td>
				  	<td width="90%"> : <input size="30" class="patinet_info" name="patient_name" id="patient_name" value="<?php echo $billInfo[0][3];?>"></td>
				  	<!-- <td></td> -->
				  </tr>
				  <tr class="edit_info_content">
				  	<td width="10%">Place</td>
				  	<td width="90%"> : <input size="30"  class="patinet_info" name="patient_place" id="patient_place" value="<?php echo $billInfo[0][6];?>"></td>
				  	<!-- <td></td> -->
				  </tr>

				  <tr class="edit_info_content">
				  	<td width="10%">Age</td>
				  	<td> : <input size="30"  class="patinet_info" name="patient_age" id="patient_age" value="<?php echo (!empty($age) ?$age:'')?>" style="width: 80px;">

				  		<select name="patient_age_type" onkeypress="nextField(event.keyCode,patient_gender)">

											<option value="Y" <?php echo (!empty($age_type) && $age_type =='Y')?'selected':''?>>Y</option>
											<option value="M" <?php echo (!empty($age_type) && $age_type=='M')?'selected':''?>>M</option>
											<option value="D" <?php echo (!empty($age_type) && $age_type=='D')?'selected':''?>>D</option>
										</select> 


				  	</td>
				  	<!-- <td></td> -->
				  </tr>

				  

				  <tr class="edit_info_content">
				  	<td width="10%">Gender</td>
				  	<td width="90%" > : 
				  		<!-- <input  class="patinet_info" name="patient_name" id="patient_name" value="<?php echo $billInfo[0][5];?>"> -->
						<select  name="patient_gender" class="patinet_info" onkeypress="nextField(event.keyCode,contact_no)" style="width: 100px;">
							<option value="">------</option>
							<option <?php echo (!empty($billInfo[0][5]) && $billInfo[0][5]=='M')?'selected':''?> value="M">Male</option>
							<option <?php echo (!empty($billInfo[0][5]) && $billInfo[0][5]=='F')?'selected':''?> value="F">Female</option>
							<option <?php echo (!empty($billInfo[0][5]) && $billInfo[0][5]=='O')?'selected':''?> value="O">Other</option>
						</select>

				  	</td>
				  	<!-- <td></td> -->
				  </tr>

				  <tr class="edit_info_content">
				  	<td width="10%">Contact No</td>
				  	<td width="90%"> : <input  class="patinet_info" name="patient_contact_no" id="patient_contact_no" value="<?php echo $billInfo[0][7];?>" size="30"></td>
				  	<!-- <td></td> -->
				  </tr>

				  <tr class="edit_info_content">
				  	<td width="10%">Referral Info</td>
				  	<td width="90%"> : <input  class="patinet_info" name="patient_referral_info" id="patient_referral_info" value="<?php echo $billInfo[0][53];?>" size="30" onKeyUp="ajax_showOptions(this,'getDoctors',event)";>

					<!-- <input type="hidden" id="patient_referral_info_hidden" name="patient_referral_info_ID" value="<?php echo (!empty($post['patient_referral_info_ID']))?$post['patient_referral_info_ID']:''?>"> -->
				  	</td>
				  	<!-- <td></td> -->
				  </tr>

				  <tr class="edit_info_content">
				  	<td width="10%">Email ID</td>
				  	<td width="90%"> : <input  class="patinet_info" name="patient_email" id="patient_email" value="<?php echo $billInfo[0][50];?>" size="30"></td>
				  	<!-- <td></td> -->
				  </tr>


				  <tr class="edit_info_content">
				  	<td width="10%">Doctor</td>
				  	<td width="90%"> : <input  class="patinet_info" name="patient_doctor_direct" id="patient_doctor_direct" value="<?php echo $billInfo[0][8];?>" size="30" autocomplete="off" onKeyUp="ajax_showOptions(this,'getDoctors',event)";>

				  	<input type="hidden"  class="patinet_info" id="patient_doctor_direct_hidden" name="patient_doctor_direct_ID"  value="<?php echo $billInfo[0][54];?>">
				  	</td>
				  </tr>

				  <input type="hidden"  class="patinet_info" name="patient_prefix" id="patient_prefix" value="<?php echo $billInfo[0][26];?>">
				  

			   </table>
			   <div class="col-md-3 text-center">
			   <input id="update_patient_info" type="button" class="btn btn-sm btn-success " name="update_patient_info" value="Update" onclick="update_patient_info();"/>
			</div>



			<?php }?>

			   </div>


			   <?php 
			   if($paction!="EDIT_PATIENT_INFO"){
			   ?>
				<div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped" >
					<thead>
						<tr>
							<th><?php echo $lang_sl_no; ?></th>
							<th><?php echo $lang_test_name; ?></th>
							<th><?php echo $lang_value; ?></th>
							<th><?php echo $lang_unit; ?></th>
							<th><?php echo $lang_normal_range; ?></th>
							<th width="30%"><?php echo $lang_description; ?></th>
							<th>RANGE</th>
							
						</tr>
				    </thead>
					<tbody>
					<?php
					    if(!empty($testItemInfo)){
							
						  for($i=0;$i<count($testItemInfo);$i++){ 

						  	if ($testItemInfo[$i][5] != 'HR') {
						  		

						   ?>

                            <tr>
							   <td></td>
							   <td >
							    <?php echo ($testItemInfo[$i][5] ==1 || $testItemInfo[$i][5] ==2 || $testItemInfo[$i][5] ==10 || $testItemInfo[$i][5] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
								<?php echo ($testItemInfo[$i][5] ==10 || $testItemInfo[$i][5] ==20)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';?>
								
							   <?php echo ($testItemInfo[$i][5] ==1 || $testItemInfo[$i][5] ==2 || $testItemInfo[$i][5] ==3)?'<b><u>':'';?>
							    <?php echo (($testItemInfo[$i][5] !=1 || $testItemInfo[$i][5] !=2 || $testItemInfo[$i][5] !=3) && ($testItemInfo[$i][7] =='H' || $testItemInfo[$i][7] =='L'))?'<b>':'';?>
							  
							   <?php echo $testItemInfo[$i][0];?>

							    <?php echo (($testItemInfo[$i][5] !=1 || $testItemInfo[$i][5] !=2 || $testItemInfo[$i][5] !=3) && ($testItemInfo[$i][7] =='H' || $testItemInfo[$i][7] =='L'))?'</b>':'';?>

							   <?php echo ($testItemInfo[$i][5] ==1 || $testItemInfo[$i][5] ==2 || $testItemInfo[$i][5] ==3)?'</u></b>':'';?>
							   </td>
							 <?php
							    if($testItemInfo[$i][5] ==1 || $testItemInfo[$i][5] ==2 || $testItemInfo[$i][5] ==3){?>
								
								    <td><input type="hidden" name="result_value[]"  value="" autocomplete="off"></td>
									<td></td>
									<td></td>
									<td></td>
									<td><input type="hidden" name="test_range[]"  value="" autocomplete="off"></td>
								
								<?php }else{ ?>
							        <td><input type="text" class="inputs" name="result_value[]"  value='<?php echo $testItemInfo[$i][1];?>'
							         autocomplete="off"></td>
									<td><?php echo $testItemInfo[$i][6];?></td>
							        <td><?php echo $testItemInfo[$i][2];?></td>
							         <td>
							        	<?php if($paction =="SAVE"){ ?>
							        	<textarea class="tinymce" name="<?php echo $i."_".$testItemInfo[$i][3];?>_tinymce[]"><?php echo $testItemInfo[$i][9];?></textarea>
							        <?php }else{?>
							        	<textarea class="tinymce" name="<?php echo $i."_".$testItemInfo[$i][3];?>_tinymce[]"><?php echo $testItemInfo[$i][8];?></textarea>
							        	<?php } ?>
							        </td>
							        <td>
							        	<select name="test_range[]" >
														<option value ="N" <?php echo (isset($testItemInfo[$i][7]) && $testItemInfo[$i][7]=='N')?'selected':'';?>>Normal</option>
														<option value ="H" <?php echo (isset($testItemInfo[$i][7]) && $testItemInfo[$i][7]=='H')?'selected':'';?>>High</option>
														<option value ="L" <?php echo (isset($testItemInfo[$i][7]) && $testItemInfo[$i][7]=='L')?'selected':'';?>>Low</option>
										</select>
							        </td>
								<?php } ?>

							</tr>
							<input type="hidden" name="test_name[]" value="<?php echo $testItemInfo[$i][0];?>">
							<input type="hidden" name="normal[]" value="<?php echo $testItemInfo[$i][2];?>">
					        <input type="hidden" name="tid[]" value="<?php echo $testItemInfo[$i][3];?>">
					        <input type="hidden" name="cid[]" value="<?php echo $testItemInfo[$i][4];?>">
					       <input type="hidden" name="type[]" value="<?php echo $testItemInfo[$i][5];?>">
						   <input type="hidden" name="unit[]" value="<?php echo $testItemInfo[$i][6];?>">
						  <?php
  							}

                          }						  
						}
					
					?>
					
					<!-- MANTOX TEST STARTS -->
					<?php 

					if (!empty($billItemInfo)) {
						
						for ($b=0; $b < count($billItemInfo) ; $b++) { 
							
							if ($billItemInfo[$b][3]=="LE" && $billItemInfo[$b][4]==$config_obj->mantox_id) { //var_dump($mantoxResult); ?>


								<tr class="mantox_tr">
									<td></td>
									<td></td>
									<td>
										<br><br><br>
										MANTOUX TEST DETAILS
										<hr style="border-top: 2px solid #0f0f10;border-style: dashed;margin-top: 5px;margin-bottom: 5px;">
										ARM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="arm_type" value="LEFT ARM" <?php if (!empty($mantoxResult) && $mantoxResult[3][4] == "LEFT ARM" ) {echo checked;} ?> > LEFT ARM &nbsp;&nbsp;&nbsp;
										<input type="radio" name="arm_type" value="RIGHT ARM" <?php if (!empty($mantoxResult) && $mantoxResult[3][4] == "RIGHT ARM" ) {echo checked;} ?> > RIGHT ARM
										<br><br><br>
										GIVEN AT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" class="inputs" name="given_at"  value='<?php if (!empty($mantoxResult[2][4]) ) {echo $mantoxResult[2][4];} ?>'autocomplete="off">
										<br><br><br>
										READING ON &nbsp; <input type="text" class="inputs" name="reading_on"  value='<?php if (!empty($mantoxResult[1][4]) ) {echo $mantoxResult[1][4];} ?>'autocomplete="off">
										<br><br><br>
									</td>
									<td></td>
									<td></td>
								</tr>

							<?php
							}
							

						}

					}

					?>
					<!-- MANTOX TEST ENDS -->

					<tr>
						<td></td>
						<td id="noborder" colspan="2" align="center">
						
						<?php if($paction =="UPDATE"){ ?>
						 <input id="save_result" type="button" class="btn btn-success inputs" name="save_result" value="Update Result" onclick="save_result();"/>
						<?php }else{ ?>
						 <input id="save_result" type="button" class="btn btn-success inputs" name="save_result" value="Save Result" onclick="save_result();"/>
						<?php } ?>
					   </td>
					   <td></td>
					</tr>
					
				 </tbody>
				</table>
			</div>
			</div>
		<?php }?>
            </section>
	  <input type="hidden" name="id" id="id" />
	 <input type="hidden" name="paction" id="paction" value="<?php echo $paction;?>"/>
	  <input type="hidden" name="billno" id="billno" value="<?php echo $billno;?>"/>
	  <input type="hidden" name="direct_id" id="direct_id" value="<?php echo !empty($billInfo[0][2])?$billInfo[0][2]:'';?>"/>

		<?php 

			if ($billItemInfo[0][3]=="LE" && $billItemInfo[0][4]==100) {?>
				<input type="hidden" name="mantox_test" id="mantox_test" value="<?php echo 'YES';?>"/>
			<?php
			}
		?>


	 </div>
</form>	  
</body>
	</html>
	
