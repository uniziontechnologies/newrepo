<?php session_start();
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
$comm_obj= new CommonFunctions();
?>
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
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>

      <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
    <script src="../../plugins/select2/select2.full.min.js"></script>
	 <script>

	 	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

   });
      $(function () {
	  
	   //Date range picker
        $('#from_date').datepicker();
		 $('#to_date').datepicker();
	  });
	  </script>
		

<script>

	function searchForm(){
	
		
		document.op_search.action="../../lib/controllers/centralController.php?module=IP&sub_module=OP_Search";
		document.op_search.submit();
	}
	
	
	
   
</script>
<script type="text/javascript">

 $(document).ready(function(){
    
 
 	$(".btn-info").bind('click', function() { 
		var values = $(this).attr("id").split('/');
			$("#id").val(values[0]);
			if(values[1]=='YES'){
				showDialog1('Error','Admit through Observation.','error',2);
				return false;
			}else{
				$("#form").attr("action","../../lib/controllers/centralController.php?module=IP&sub_module=Admission_Form");
				$("#form").submit();
			}
		});
 });

		function showDialog1(title,message,type,autohide) {
			if(!type) {
				type = 'error';
			}
			var dialog;
			var dialogheader;
			var dialogclose;
			var dialogtitle;
			var dialogcontent;
			var dialogmask;
			if(!document.getElementById('dialog')) {
				dialog = document.createElement('div');
				dialog.id = 'dialog';
				dialogheader = document.createElement('div');
				dialogheader.id = 'dialog-header';
				dialogtitle = document.createElement('div');
				dialogtitle.id = 'dialog-title';
				dialogclose = document.createElement('div');
				dialogclose.id = 'dialog-close'
				dialogcontent = document.createElement('div');
				dialogcontent.id = 'dialog-content';
				dialogmask = document.createElement('div');
				dialogmask.id = 'dialog-mask';
				document.body.appendChild(dialogmask);
				document.body.appendChild(dialog);
				dialog.appendChild(dialogheader);
				dialogheader.appendChild(dialogtitle);
				dialogheader.appendChild(dialogclose);
				dialog.appendChild(dialogcontent);;
				dialogclose.setAttribute('onclick','hideDialog()');
				dialogclose.onclick = hideDialog;
			} else {
				dialog = document.getElementById('dialog');
				dialogheader = document.getElementById('dialog-header');
				dialogtitle = document.getElementById('dialog-title');
				dialogclose = document.getElementById('dialog-close');
				dialogcontent = document.getElementById('dialog-content');
				dialogmask = document.getElementById('dialog-mask');
				dialogmask.style.visibility = "visible";
				dialog.style.visibility = "visible";
			}
			dialog.style.opacity = .00;
			dialog.style.filter = 'alpha(opacity=0)';
			dialog.alpha = 0;
			var width = pageWidth();
			var height = pageHeight();
			var left = leftPosition();
			var top = topPosition();
			var dialogwidth = dialog.offsetWidth;
			var dialogheight = dialog.offsetHeight;
			var topposition = top + (height / 3) - (dialogheight / 2);
			var leftposition = left + (width / 2) - (dialogwidth / 2);
			dialog.style.top = topposition + "px";
			dialog.style.left = leftposition + "px";
			dialogheader.className = type + "header";
			dialogtitle.innerHTML = title;
			dialogcontent.className = type;
			dialogcontent.innerHTML = message;
			var content = document.getElementById(WRAPPER);
			dialogmask.style.height = '100%';
			dialog.timer = setInterval("fadeDialog(1)", TIMER);
			if(autohide) {
				dialogclose.style.visibility = "hidden";
				window.setTimeout("hideDialog()", (autohide * 1000));
			} else {
				dialogclose.style.visibility = "visible";
			}
		}
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>
<body id="frame">
<form name="op_search" id="form"  method="post" action=""> 
<?php
		$post=$this->popArr['post'];
		$doctors=$this  ->popArr['doctors'];
		$patientInfo=$this  ->popArr['patient_info']; 
	
	$dep_id='';
	
	if(!empty($this->popArr['dep_id'])){
		$dep_id=$this->popArr['dep_id'];
	}
	if(!empty($post['date'])) {
		$date=$post['date'];
	}else $date=date("d-m-Y");

?>
<section class="content-header">
          <h4><?php echo $lang_search." ".$lang_op_patients; ?></h4>
</section>
 
        <section class="content">
					 
		<div class="box box-info">
                
                     <div class="box-body">
						<table class="table table-striped">
							<tr>
							
								<td id="noborder"> <?php echo $lang_op_no; ?>:</td>
								<td id="noborder"><input type="text" name="opno"  size="12" value="" onkeypress="nextField(event.keyCode,name)" /></td>
								
								<td id="noborder"> <?php echo $lang_first_name; ?>:</td>
								<td id="noborder"><input type="text" name="name"  size="12" value="" onkeypress="nextField(event.keyCode,place)" /></td>

																
								<td id="noborder"> <?php echo $lang_place; ?>:</td>
								<td id="noborder"><input type="text" name="place" value="" size="12" onkeypress="nextField(event.keyCode,lname)" /></td>
							</tr>
							<tr>
							
								<td id="noborder"><?php echo $lang_contact_no; ?>:</td>
								<td id="noborder"><input type="text" name="telNo" value="" size="12" onkeypress="nextField(event.keyCode,lname)" /></td>	
								
								<td id="noborder"><?php echo $lang_date." OF VISIT"; ?> </td>
								<td id="noborder" ><input type="text" name="date" id="date" value="<?php echo $date;?>" autocomplete="off"   class="DatePicker" onkeypress="if(event.keycode == 13){searchForm()}" readonly="true"/></td>
								
								<td id="noborder"><?php echo $lang_doctor; ?> </td>
								<td id="noborder">
								<select name="doctor" id="doctor"   onkeypress="nextField(event.keyCode,inc)" onChange="searchForm();" class="select2"/> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>	
							
							</tr>	
							<tr>		
									<td id="noborder" colspan="8" align="center">
									&nbsp;&nbsp;
									<input id="button1" type="button" name="Search" class="btn btn-success" value="Search" onclick="searchForm();"/>
									
									</td>
								</tr>	
				
				
				</table>
				</div>
			</div>
				
		<h3 ><?php echo $lang_admit." - ".$lang_op_patients." ".$lang_list; ?></h3>
		
					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					
		<div class="box box-info">
                
                       <div class="box-body">
			        <table class="table table-bordered table-striped">
				
				<thead>
					<tr>
                         <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						 <th ><a href="#"><?php echo $lang_op_no; ?></a></th>
						 <th><a href="#"><?php echo $lang_patient_category; ?></a></th>
						 <th><a href="#"><?php echo $lang_patient." ".$lang_name; ?></a></th>
						 <th width="3%"><a href="#"><?php echo $lang_age; ?></a></th>	
						 <th width="3%"><a href="#"><?php echo $lang_gender; ?></a></th>   					  
                                                 <th><a href="#"><?php echo $lang_place; ?></a></th>
						    <th width="5%"><a href="#"><?php echo $lang_date; ?></a></th>
							<th width="6%"><a href="#"><?php echo $lang_time; ?></a></th>
							<th><a href="#"><?php echo $lang_insurance_company; ?></a></th>							
						    <th><a href="#"><?php echo $lang_doctor; ?></a></th>							 
							  <th width="5%"><a href="#"><?php echo $lang_visit_status; ?></a></th>
							  <th width="5%"><a href="#"><?php echo $lang_admit; ?></a></th>                           
							                                
                                
                          </tr>
				</thead>
				<tbody>
				
					<?php if(!empty($patientInfo)){ 
							$j=1;
							for($i=0;$i<count($patientInfo);$i++){	 ?>
							
					
							<tr>
								<td><?php echo $j++;?></td>
								<td><?php echo $patientInfo[$i][0];?></td>
								<td>
									<?php 
										echo $patientInfo[$i][57];
										if($patientInfo[$i][81]){
											echo '<br>Member ID:'.$patientInfo[$i][81];
										}
									?>	
								</td>
								<td><a href="#" onclick="redirect('<?php echo $patientInfo[$i][13];?>')"><?php echo	$patientInfo[$i][1]." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></a></td>
								<td><?php echo $patientInfo[$i][4];?></td>
								<td><?php echo $patientInfo[$i][6];?></td>
								<td><?php echo $patientInfo[$i][8];?></td>
								<td><?php echo date("d-m-Y",strtotime($patientInfo[$i][20]));?></td>
								<td><?php echo $patientInfo[$i][19];?></td>
								<td><?php echo $patientInfo[$i][23];?></td>
								<td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
								
								<td><?php echo $patientInfo[$i][32];
									if($patientInfo[$i][59]=='YES'){
										echo '<br><font color="red">(In Observation)</font>';
									}
								?></td>
								<td>
                                
                                                         <?php if($patientInfo[$i][48] >0){?>
                                                                               Admitted
                                                         <?php }else{?>
							            <a href="#" class="btn btn-info btn-flat" id="<?php echo $patientInfo[$i][13].'/'.$patientInfo[$i][59];?>">ADMIT</a>
							
                                                                    
                                                         <?php } ?>
                                                </td>
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
           
      </div>
	  <input type="hidden" name="id" id="id" />
	  
	
</form>	  
</body>
	</html>
	
