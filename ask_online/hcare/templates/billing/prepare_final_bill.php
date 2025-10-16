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
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
		 <!-- jQuery 2.1.4 -->
    
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- <script type="text/javascript" src="../../dist/js/common_functions.js">  </script> -->

<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
	
	 <script>
      $(function () {
	  
	   //Date range picker
        $('#dod').datepicker();
		
	  });
	  </script>
	 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>	
<script>

$(document).ready(function() {           
           
          
            
             $("#credit_card").hide();
             $("#cheque").hide();
            
            $( ".ipbill" ).blur(function() {
            
               process_form();
              
            });
			
			
            $('.ipbill').bind('keypress', function(e) {
	            if(e.keyCode==13){
		           process_form();
	           }
            });
            
            $( "#disc_type" ).change(function() {
            
               process_form();
            });
            
            $( "#payment_mode" ).change(function() {
            
                payment_mode= $("#payment_mode").val();
                
                if(payment_mode == "CREDIT CARD"){
                
                   $("#credit_card").show();
                    $("#cheque").hide();
                }else if(payment_mode == "CHEQUE"){
                
                    $("#cheque").show();
                     $("#credit_card").hide();
                }else{
                  
                   $("#credit_card").hide();
                   $("#cheque").hide();
                
                }
            });
            
            
             $( "#save" ).click(function() {
             
               
                  $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Save_Prepare_Bill");
                  $("#form").submit();
              
             });
			 $('#newfield_add').click(function(e) {
	           e.preventDefault();

		        var field_name=$("#field_name").val();
		        var field_amount=$("#field_amount").val();
				 var field_count=$("#field_count").val();
				
				if(field_name ==""){
                
                    showDialog('Error','Please Enter Addon Filed Name.','error',2);
			        return false;
                }else if(field_amount ==""){
                
                    showDialog('Error','Please Enter Addon Filed Amount.','error',2);
			        return false;
                }else{
                	// alert(field_amount);
			
				 var new_row="<tr id='tr"+field_count+"'><td>"+field_name+"<input type='hidden' name='particulars[]' value='"+field_name+"'><input type='hidden' name='item_id["+field_count+"]' value='"+field_count+"'></td><td ><input name='item[]'  tabbindex='2' class='ipbill' value='"+field_amount+"' autocomplete='off'  /><input type='hidden' name='item_type["+field_count+"]' value='new_field'></td><td><a href='#' class='delete_addon_field text-red' id='"+field_count+"' ><i class='fa fa-remove'></i></a></td></tr>";
				 $( "#show_addon_field" ).append(new_row);	
				 
				 field_count++;
				 
				 $("#field_count").val(field_count);
				 $("#field_name").val('');
		         $("#field_amount").val('');
				 
				 process_form();
				}
				  
		    });

			$('#procedure_field_add').click(function(e) {
	           
		        var procedure_name=$("#procedure").val();
		        var procedure_qty=$("#procedure_qty").val();
				var field_count=$("#field_count").val();
				var procedure_id=$("#procedure_hidden").val();
                
                if(procedure_name ==""){
                
                    showDialog('Error','Please Enter Addon Procedure Name.','error',2);
			        return false;
                }else if(procedure_qty ==""){
                
                    showDialog('Error','Please Enter Addon Quantity.','error',2);
			        return false;
                }else{
		

				  $("#paction").val("json"); 
               
		          var data= $("#form").serialize();
		          inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=procedure_amount";
			
		          $.post(inline_action,data,function (response) {
		   
		               var procedure_amt=response['amount'];
		               var total_amt=procedure_amt * procedure_qty;
				       
				       var qty_price=" ("+procedure_qty+"*"+procedure_amt+")";

				       var PriceQtyTotalamt=procedure_amt+"*"+procedure_qty+"*"+procedure_amt * procedure_qty;

				       var new_row="<tr id='tr"+field_count+"'><td>"+procedure_name+"<input type='hidden' name='particulars[]' value='"+procedure_name+"'><input type='hidden' name='item_id["+field_count+"]' value='"+field_count+"'></td><td ><input name='item[]' tabbindex='2' class='ipbill' value='"+total_amt+"'>"+qty_price+"<input type='hidden' name='qty["+field_count+"]' value='"+procedure_qty+"'><input type='hidden' name='price["+field_count+"]' value='"+procedure_amt+"'><input type='hidden' name='proce_id["+field_count+"]' value='"+procedure_id+"'><input type='hidden' name='item_type["+field_count+"]' value='procedure'></td><td><a href='#' class='delete_addon_field text-red' id='"+field_count+"' ><i class='fa fa-remove'></i></a></td></tr>";
				   $( "#show_addon_procedure" ).append(new_row);	
				 
			       field_count++;
				 
				    $("#field_count").val(field_count);
				    $("#procedure").val('');
		            $("#procedure_qty").val('');
				 
				    process_form();
		            
		          },"json");
		         
				} 
				  
		    });	



	 	$(".add_specialist_consultation").click(function() {
			 $("#ipno").val($(this).attr("id"));
			 $("#type").val("specialist_consultation");
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=ip_case_sheet");
			 // $("#form").attr("target","frame-popup");
			 // $(".frame-pop").css("display","block");
			$("#form").submit();

		});
		$(".add_nursing_procedures").click(function() {
			 $("#ipno").val($(this).attr("id"));
			 $("#type").val("nursing_procedures");
			 $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=ip_case_sheet");
			 // $("#form").attr("target","frame-popup");
			 // $(".frame-pop").css("display","block");
			$("#form").submit();

		});
		// $('.pop_up_close-frame').click(function(e){
			
});

function process_form(){
	// alert("process_form");
			
			  $("#paction").val("json"); 
               
		       var data= $("#form").serialize();
		       inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=Final_Payment_Form";


			
		       $.post(inline_action,data,function (response) {
		   // alert(response);return false;
		           total_amount=response['total_amount'];

		           $("#total_amount").val(total_amount);
		           $("#balance").val(response['balance']);
		       },"json");
                
			}
function show_surgery_bills(ipid){
	    tb_show('SURGERY BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_surgery_bill_finalitems&ipno="+ipid);
}
function show_medicine_bills(ipid){
	    tb_show('MEDICINE BILL ITEMS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_medicine_finalbills&ipno="+ipid);
}
function show_specialist_bills(ipid){
	    tb_show('SPECIALIST CONSULTATION CHARGES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_specialist_finalbills&ipno="+ipid);
}
function show_xray_bills(ipid){
	    tb_show('X-RAY CHARGES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_xray_finalbills&ipno="+ipid);
}
function show_lab_bills(ipid){
	    tb_show('LABORATORY CHARGES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_lab_finalbills&ipno="+ipid);
}
function show_rent_bills(ipid){
	    tb_show('ROOM RENT CHARGES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_rent_finalbills&ipno="+ipid);
}
function show_nursing_procedures_bills(ipid){
	    tb_show('NURSING PROCEDURES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_nursing_procedures_finalbills&ipno="+ipid);
}
//for labour chargesdeliveryCharges
function show_labour_charges_bills(ipid){
	    tb_show('LABOUR CHARGES',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_labour_charges_bills&ipno="+ipid);
}
//for all bill details
function show_final_bills(ipid){
	    tb_show('ALL BILL DETAILS',"../../lib/controllers/centralController.php?module=Billing&sub_module=show_final_bills&ipno="+ipid);
}
</script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
var $j = jQuery.noConflict();
$j(document).ready(function() {   

$j(document).on('click','.delete_addon_field', function() {
		 
		         
			  var field_id = $(this).attr('id');
			 $( "#tr"+field_id ).remove();	
			 process_form();

		   });
		   
		   $j(document).on('blur','.ipbill', function() {
		     process_form();
		   });
});
</script>
<style>
.preload{
	display: none;
	z-index: 999;
}
/*.content{
	display: none;
}*//*
	.frame-pop{
		position: absolute;
		top : 10px;
		left :10px;
		background-color: white;
		z-index: 10;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		padding: 20px;
		display: none;
	}
	#frame-popup{
		width: 1200;
		height: 700;
		border: 0px;
	}
	.preload{
		position: absolute;
		top: 45%;
		left: 50%;
	}*/
	.fa-info-circle{
		 color: #00BFEF;
		 font-size: 20px;
	}
	.fa-pencil{
		 color: #00A55A;
		 font-size: 20px;
	}
	.fa-close{
		 color: #FF0000;
		 font-size: 20px;
		 float:right;
	}

</style>
<body id="frame" >
<form name="final_payment" id="form"  method="post" action="" > 

<?php
$patientInfo=$this ->popArr['patient_info'];
//$itemInfo=$this ->popArr['procedure_items'];
//$theatre_procedure=$this ->popArr['theatre_procedure'];
$post=$this->popArr['post'];
$itemName=$this->popArr['itemName'];
$itemAmount=$this->popArr['itemAmount'];
$pops=$this->popArr['pops'];
//for labour charges
$gynec_charges=$this ->popArr['gynec_charges'];
$labour_room_charges=$this ->popArr['labour_room_charges'];
  // var_dump($itemAmount);
?>
<div id="content">

 
<section class="content">
					 
	<div class="box box-info">
                
               <div class="box-body">
			    <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_ip_no; ?> : <?php echo strtoupper($patientInfo[0][13]);?>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_name; ?> : <?php echo strtoupper(strtolower(($patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3])));?>
                    </div>
                    <div class="col-xs-5">
					 <?php echo $lang_room_no; ?> : <?php echo $patientInfo[0][37];?>
                   
                    </div>
                  </div>
				   <div class="row" style="font-weight:bold;font-size:16px;">
                    <div class="col-xs-3">
                      <?php echo $lang_doa; ?> : <?php echo strtoupper($patientInfo[0][20]);?>
                    </div>
                    <div class="col-xs-4">
					<?php echo $lang_date; ?> : <input type="text" name="bill_prepare_date"   value="<?php echo (!empty($post['bill_prepare_date']))?$post['bill_prepare_date']:''?>" id="bill_prepare_date"   onkeypress="nextField(event.keyCode,from_date)" readonly size="10"/>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div>
				
			         </div>
			</div>
			       <h4><?php echo $lang_final_payment;?></h4>
		<div class="row">
                   <div class="col-md-6">
				
		     <div class="box box-info">
                
                         <div class="box-body">
			        <table class="table table-bordered table-striped">
				
				<?php $i=13;?>
				      <tr>
				      
				           <td id="noborder"><?php echo $lang_admission_fee;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_admission_fee;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>">
						   </td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="admission_fee" class="ipbill" tabbindex="2"  value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,'item[1]')" />
						    <?php $i++;?>
						   </td>
				       </tr>
				
				       <tr>
				           <td id="noborder"><?php echo $lang_surgery_charges ;?>: </td>
				           <td id="noborder"></td>
				       </tr>
					    <tr>
				           <td id="noborder" align="right"><?php echo $lang_hosp_amount;?>:<input type="hidden" name="particulars[0]" value="<?php echo $lang_hosp_amount;?>">
				           </td>
				           <td id="noborder"><input name="item[0]" id="surgeon_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[0]))?$itemAmount[0]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						    <input type="hidden" name="item_id[0]" value="0">
				           	<span class="popup-theater">
								<i class="fa fa-info-circle" onclick="show_surgery_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>								
							</span>
						   </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_surgeon_fee;?>:<input type="hidden" name="particulars[1]" value="<?php echo $lang_surgeon_fee;?>"></td>
				           <td id="noborder"><input name="item[1]" id="surgeon_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[1]))?$itemAmount[1]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[1]" value="1">
						   </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_anaesthesia_fee;?>:<input type="hidden" name="particulars[2]" value="<?php echo $lang_anaesthesia_fee;?>"></td>
				           <td id="noborder"><input name="item[2]" id="anaesthesia_fee" tabbindex="2" class="ipbill"  value="<?php echo (!empty($itemAmount[2]))?$itemAmount[2]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[2]" value="2">
						   </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_theatre_charges;?>:<input type="hidden" name="particulars[3]" value="<?php echo $lang_theatre_charges;?>"></td>
				           <td id="noborder"><input name="item[3]" id="theatre_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($itemAmount[3]))?$itemAmount[3]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[3]" value="3">
						   </td>
				       </tr>
					   <tr>
				           <td id="noborder" align="right"><?php echo $lang_other_charges;?>:<input type="hidden" name="particulars[4]" value="<?php echo $lang_other_charges;?>"></td>
				           <td id="noborder"><input name="item[4]" id="other_charges" tabbindex="2"class="ipbill"value="<?php echo (!empty($itemAmount[4]))?$itemAmount[4]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[4]" value="4">
						   </td>
				       </tr>
				       <!-- <?php if($i==25){?> -->
				       	<!-- <tr>

				       	<td id="noborder"><?php echo $lang_assistant_fee1;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_assistant_fee1;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>">
						   </td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="assistant_fee1" class="ipbill" tabbindex="2"  value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,'assistant_fee2')" />
						    <?php $i++;?>
						   </td>
						</tr> -->

				       <!-- <?php  } ?> -->
				
                          <tr>
				           <td id="noborder"><?php echo $lang_medicine_charges;?><input type="hidden" name="particulars[5]" value="<?php echo $lang_medicine_charges;?>"></td>
				           <td id="noborder"><input name="item[5]" id="medicine_charges"  tabbindex="2"class="ipbill"value="<?php echo (!empty($itemAmount[5]))?$itemAmount[5]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" readonly/>
						   <input type="hidden" name="item_id[5]" value="5">
						    <span class="popup-med">
								<i class="fa fa-info-circle pop_up-med" onclick="show_medicine_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span>
						   </td>
				       </tr>	
                       <tr>
				           <td id="noborder"><?php echo $lang_special_cons;?><input type="hidden" name="particulars[6]" value="<?php echo $lang_special_cons;?>"></td>
				           <td id="noborder"><input name="item[6]" id="special_cons" tabbindex="2" class="ipbill"  value="<?php echo (!empty($itemAmount[6]))?$itemAmount[6]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[6]" value="6">
						   	<span class="popup-spec">
								<i class="fa fa-info-circle" onclick="show_specialist_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
								<a href="#" class="add_specialist_consultation" id="<?php echo $patientInfo[0][13];?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							</span>
						</td>
				       </tr>
				     
				       <tr>
				           <td id="noborder"><?php echo $lang_xray_charges;?><input type="hidden" name="particulars[7]" value="<?php echo $lang_xray_charges;?>"></td>
				           <td id="noborder"><input name="item[7]" id="xray_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($itemAmount[7]))?$itemAmount[7]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[7]" value="7">
						   <span class="popup-xray">
								<i class="fa fa-info-circle" onclick="show_xray_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span></td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_laboratory_charges;?><input type="hidden" name="particulars[8]" value="<?php echo $lang_laboratory_charges;?>"></td>
				           <td id="noborder"><input name="item[8]" id="lab" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[8]))?$itemAmount[8]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" readonly/>
						   <input type="hidden" name="item_id[8]" value="8">
						   <span class="popup-lab">
								<i class="fa fa-info-circle" onclick="show_lab_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span> </td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_room_rent;?><input type="hidden" name="particulars[9]" value="<?php echo $lang_room_rent;?>"> </td>
				           </td>
				           
				           <td id="noborder"><input name="item[9]" id="room_rent" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[9]))?$itemAmount[9]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[9]" value="9">

				           	<span class="popup-room">
								<i class="fa fa-info-circle" onclick="show_rent_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span>
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_nursing_charges;?><input type="hidden" name="particulars[10]" value="<?php echo $lang_nursing_charges;?>"></td>
				           
				           <td id="noborder"><input name="item[10]" id="nursing_charges" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[10]))?$itemAmount[10]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[10]" value="10">
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_bystander_charge;?><input type="hidden" name="particulars[24]" value="<?php echo $lang_bystander_charge;?>"></td>
				           
				           <td id="noborder"><input name="item[24]" id="bystander_charges" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[24]))?$itemAmount[24]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[24]" value="24">
				           </td>
				       </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_maintenance;?><input type="hidden" name="particulars[11]" value="<?php echo $lang_maintenance;?>"></td>
				           
				           <td id="noborder"><input name="item[11]" id="maintenance" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[11]))?$itemAmount[11]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
						   <input type="hidden" name="item_id[11]" value="11">
				           </td>
				       </tr>
                       <tr>
				           <td id="noborder"><?php echo "PROCEDURE CHARGES";?><input type="hidden" name="particulars[12]" value="<?php echo "PROCEDURE CHARGES";?>"></td>
				           <td id="noborder"><input name="item[12]" id="nursing_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($itemAmount[12]))?$itemAmount[12]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"  />
						   <input type="hidden" name="item_id[12]" value="12">
						   <span class="popup-room">
								<i class="fa fa-info-circle" onclick="show_nursing_procedures_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
								<a href="#" class="add_nursing_procedures" id="<?php echo $patientInfo[0][13];?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							</span>
						   
						</td>
				       </tr>
                                      
				       <tr>				       
				       <tr>
				           <td id="noborder"><?php echo $lang_delivery_fee;?></td>
				           <td id="noborder"></td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo$lang_gynaecologist_fee;;?>:<input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_gynaecologist_fee;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="gynaecologist_fee"  class="ipbill" tabbindex="2"  value="<?php echo (!empty($gynec_charges))?$gynec_charges:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" />
				           	<span class="popup-labour_charges">
								<i class="fa fa-info-circle" onclick="show_labour_charges_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span> </td>
				          <?php $i++;?>

					   </tr>
				       <tr>
				           <td id="noborder" align="right"><?php echo $lang_labour_charges;?>:<input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_labour_charges;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="labour_charges" tabbindex="2" class="ipbill"  value="<?php echo (!empty($labour_room_charges))?$labour_room_charges:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
                                <?php $i++;?>
					  </tr>
				       <tr>
				       
				       
				           <td id="noborder"><?php echo $lang_icu_charge;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_icu_charge;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="icu_charge" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="if(event.keyCode==13){ processForm()};" onblur="processForm"/></td>
				         <?php $i++;?>
					   </tr>
				      
				       <tr>
				           <td id="noborder"><?php echo $lang_candd_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_candd_charges;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="candd_charges" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				           <?php $i++;?>
					   </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_suturing_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_suturing_charges;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="suturing_charges" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				           <?php $i++;?>
					   </tr>
				       
				       <tr>
				           <td id="noborder"><?php echo $lang_medico_charges;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_medico_charges;?>"><input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="medico" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
                         		   <?php $i++;?>    
					  </tr>
                          <tr>
				           <td id="noborder"><?php echo $lang_birth_reg_fee;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_birth_reg_fee;?>"><input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="birth_reg_fee" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				           <?php $i++;?>
					   </tr>
				       <tr>
				           <td id="noborder"><?php echo $lang_ryes_tube;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_ryes_tube;?>"><input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="ryes_tube" tabbindex="2" class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
                           		 <?php $i++;?>		      
					  </tr>
				       
				          <tr>
				           <td id="noborder"><?php echo $lang_warmer;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_warmer;?>"><input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="warmer" tabbindex="2"  class="ipbill" value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)"/></td>
				            <?php $i++;?>
					   </tr> 
                                            <tr>
				           <td id="noborder" ><?php echo $lang_ip_billing;?>:<input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_ip_billing;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="ip_bill_visit"  class="ipbill" tabbindex="2"  value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" /></td>
				          <?php $i++;?>
					   </tr>
					   <?php  $i=25;?>
					   	<tr>

				       	<td id="noborder"><?php echo $lang_assistant_fee1;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_assistant_fee1;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>">
						   </td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="assistant_fee1" class="ipbill" tabbindex="2"  value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,'assistant_fee2')" />
						    <?php $i++;?>
						   </td>
						</tr>
						<tr>

				       	<td id="noborder"><?php echo $lang_assistant_fee2;?><input type="hidden" name="particulars[<?php echo $i;?>]" value="<?php echo $lang_assistant_fee2;?>">
						   <input type="hidden" name="item_id[<?php echo $i;?>]" value="<?php echo $i;?>">
						   </td>
				           <td id="noborder"><input name="item[<?php echo $i;?>]" id="assistant_fee2" class="ipbill" tabbindex="2"  value="<?php echo (!empty($itemAmount[$i]))?$itemAmount[$i]:''?>" autocomplete="off"  />
						    <?php $i++;?>
						   </td>
						</tr>					   
				       <?php
					         $m=27;
				             // $m=$i;
				             // var_dump($m,$i);
				           if($post['procedure_count']>0){ 
				           
				              for($i=0;$i<$post['procedure_count'];$i++){
				                
				           ?>
				           
				           <tr>
				           <td id="noborder"><?php echo $itemName[$m];?><input type="hidden" name="particulars[<?php echo $m;?>]" value="<?php echo $itemName[$m];?>"><input type="hidden" name="item_id[<?php echo $m;?>]" value="<?php echo $m;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $m;?>]" id="$items[]" tabbindex="2"  value="<?php echo (!empty($itemAmount[$m]))?$itemAmount[$m]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" readonly/></td>
				             <?php $m++;?>
					   </tr>
				           
				           
				        <?php }
				        
				        
				         }
						 
						 
                          for($i=$m;$i<count($itemAmount);$i++){?>
						   <tr>
				           <td id="noborder"><?php echo $itemName[$m];?><input type="hidden" name="particulars[<?php echo $m;?>]" value="<?php echo $itemName[$m];?>"><input type="hidden" name="item_id[<?php echo $m;?>]" value="<?php echo $m;?>"></td>
				           <td id="noborder"><input name="item[<?php echo $m;?>]" id="$items[]" tabbindex="2"  value="<?php echo (!empty($itemAmount[$m]))?$itemAmount[$m]:''?>" autocomplete="off" onkeypress="nextField(event.keyCode,from_date)" readonly/></td>
				             <?php $m++;?>
					   </tr>
				           
						<?php  
						  }
						 ?>
				        <tr>
				           <td id="noborder" colspan="2"><hr width="100%"></td>
				         </tr>
				</table>
			  </div>
			</div>
		    </div>
			<div class="col-md-6">
				
		     <div class="box box-info">
                
                         <div class="box-body">
			        <table class="table table-bordered table-striped" id="show_addon_field">
				      <tr>
				   <td><?php echo $lang_new_field;?></td>
				   <td> <input name="field_name" id="field_name" type="text" size="25" onKeyUp="ajax_showOptions(this,'getIPBillFieldName',event)" autocomplete="off"  onkeypress="nextField(event.keyCode,field_amount)">
                        <input type="text" name="field_amount" id="field_amount"  size="7"  >
						<a href="#" class="btn btn-success btn-flat" id="newfield_add"><i class="fa fa-plus"></i></a>
					<input type="hidden" name="field_count" id="field_count" value="<?php echo $m;?>">
					<!--<a href="#" class="btn btn-success btn-flat" id="pcomp_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>
				</table>
				<table class="table table-bordered table-striped" id="show_addon_procedure">
				<tr>
				     <td width="18%"><?php echo $lang_procedure;?></td>
				     <td> <input name="procedure" id="procedure" size="25" onKeyUp="ajax_showOptions(this,'getNormalProcedures',event)" autocomplete="off" onkeypress="nextField(event.keyCode,procedure_qty)" >
				     <input type="hidden" id="procedure_hidden" name="procedure_ID" >
					    <input type="text" name="procedure_qty" id="procedure_qty" placeholder="QTY"  size="7"  >
						<a href="#" class="btn btn-success btn-flat" id="procedure_field_add"><i class="fa fa-plus"></i></a>
						<input type="hidden" name="field_count" id="field_count" value="<?php echo $m;?>">
                        </td>
				</tr>
				   </table>	
                   <table class="table table-bordered table-striped" >	
                       <!-- <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_total_amount;?></b>:</td>
				           <td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2"  value="<?php echo (!empty($post['total_bill_amount']))?$post['total_bill_amount']:''?>" autocomplete="off" readonly/>
				           <input type="hidden" name="actual_bill" id="actual_bill" value="<?php echo (!empty($post['total_bill_amount']))?$post['total_bill_amount']:''?>">
				           <span class="popup-final">
								<i class="fa fa-info-circle pop_up-final" onclick="show_final_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span>
				           </td>
				       </tr> -->
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_total_amount;?></b>:</td>
				           <td id="noborder"><input name="total_amount" id="total_amount" tabbindex="2"  value="<?php echo (!empty($post['total_bill']))?$post['total_bill']:''?>" autocomplete="off" readonly/>
				           <input type="hidden" name="actual_bill" id="actual_bill" value="<?php echo (!empty($post['total_bill']))?$post['total_bill']:''?>">
				           <span class="popup-final">
								<i class="fa fa-info-circle pop_up-final" onclick="show_final_bills('<?php echo $patientInfo[0][13];?>')" aria-hidden="true"></i>
							</span>
				           </td>
				       </tr>
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_amount_paid;?> SO FAR </b>:</td>
				           
				           <!-- <td id="noborder" ><b><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($post['paid_amount']))?$post['paid_amount']:''?>" autocomplete="off" readonly/></td> -->
				           	<td id="noborder" ><b><input name="amount_paid" id="amount_paid" tabbindex="2"  value="<?php echo (!empty($post['advance_paid']))?$post['advance_paid']:''?>" autocomplete="off" readonly/></td>
				       </tr>
				       
				       <tr>
				           <td id="noborder" align="right"><b><?php echo $lang_balance;?></b>:</td>
				           <!-- <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($post['balance']))?$post['balance']:''?>" autocomplete="off" readonly/>
				            <input type="hidden" name="actual_balance" id="actual_balance" value="<?php echo (!empty($post['balance']))?$post['balance']:''?>"> -->
				            <td id="noborder"><input name="balance" id="balance" tabbindex="2"  value="<?php echo (!empty($post['balance_amt']))?$post['balance_amt']:''?>" autocomplete="off" readonly/>
				            <input type="hidden" name="actual_balance" id="actual_balance" value="<?php echo (!empty($post['balance_amt']))?$post['balance_amt']:''?>">
				           
				           </td>
				       </tr>
					   <tr>
					
					<td id="noborder" align="right"><b><?php echo $lang_remarks; ?> </b>:	</td>
					<td id="noborder"><textarea cols="18" rows="3" name="remarks"><?php echo (!empty($post['remarks']))?$post['remarks']:''?></textarea></td>
				     </tr>
				     <tr>

				     	<!-- wheather needed detailed bill or not -->
				     <!-- 	<tr>
					<td id="noborder" colspan="2" align="center"><input id="print_status" type="checkbox" name="print_status" value="print_status"/>Print Detailed Bill</td>
				     </tr> -->
					    <tr>
					<td id="noborder" colspan="2" align="center"><input id="save" type="button" name="Save" class="btn btn-success" value="Save" class="save"/></td>
				     </tr>
                   </table>				   
                	 
                	   </div>
                       </div>
             </div>
</div>

</section>
<input type="hidden" name="paction" id="paction" value="">
<input type="hidden" name="bill_status" id="bill_status" value="2">
 <input type="hidden" name="id" value="<?php echo $patientInfo[0][13];?>" readonly/>
 <input type="hidden" name="ipno" id="ipno" />
 <input type="hidden" name="type" id="type" />

 <input type="hidden" name="print_status" id="print_status" value="print_status" />
<!--  <div class="frame-pop">
 	<i class="fa fa-close pop_up_close-frame" aria-hidden="true"></i>
 	<iframe src="" id="frame-popup" name="frame-popup"></iframe>
</div> -->
              
