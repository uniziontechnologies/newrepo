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
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
   <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
   <script type="text/javascript" src="../../dist/js/common_functions.js"></script>
    <!-- jQuery 2.1.4 -->
     <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
<script>
 
   function submitForm(){
   
   		
			var data= $("#form1").serialize();
		       inline_action="../../lib/controllers/centralController.php?module=Billing&sub_module=add_changeamount_billing";
			
		       $.post(inline_action,data,function (response) {
		   
		           total_amount=response['total_amount'];
				   pos=$("#pos").val();
		           $("#"+pos+"2").val(total_amount);
		            $("#form").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Process_Bill_Form&action=CHAMT&loc="+pos);
                  $("#form").submit();
		       },"json");
		
		
   
   }
   //alert(document.billing.items[0][2].value);
	  $(document).ready(function() {  

    
      
	  });
</script>

</head>
<body id="frame" onload="document.procedure.category.focus();">
<form name="procedure" id="form1" method="post" action=""> 
<?php
	$post = $this->popArr['post'];
	// var_dump($post);
	
	
	 if(!empty($_SESSION['changeamt'][$post['pos']])){
	 $items_in_array=explode("!$%",$_SESSION['changeamt'][$post['pos']]);
	 // var_dump($items_in_array);
	 

	    $procedure=$items_in_array[0];
		$amount=$items_in_array[1];
		$dr_amount=$items_in_array[2];
		$surgeon_fee=$items_in_array[3];
		$assistant_fee1=$items_in_array[4];
		$assistant_fee2=$items_in_array[5];
		$anethesia_charge=$items_in_array[6];
		$theatre_charge=$items_in_array[7];
		$other_charges=$items_in_array[8];
		$type=$items_in_array[9];
		//Since this is changable
		$price_type=1;
	 
	 }else if(isset($this->popArr['procedureInfo'])){
	
		$procedureInfo=$this->popArr['procedureInfo'];
		
		$procedure=$procedureInfo[0][3];
		$amount=$procedureInfo[0][5];
		
		$dr_amount=$procedureInfo[0][6];
		$surgeon_fee=$procedureInfo[0][9];
		$assistant_fee1=$procedureInfo[0][13];
		$assistant_fee2=$procedureInfo[0][14];
		$anethesia_charge=$procedureInfo[0][10];
		$theatre_charge=$procedureInfo[0][11];
		$other_charges=$procedureInfo[0][12];
		$price_type=$procedureInfo[0][15];
		
		
		
	}else{
	
		$id='';		
		$procedure='';
		$dr_amount='';		
		$surgeon_fee='';
		$anethesia_charge='';
		$theatre_charge='';
		$other_charges='';
		
		
	}
?>
<div id="content">
            
 <div class="row">
          
			</div>
					
					<?php if(isset($this->popArr['message'])){?>
					
						<div class="callout callout-success"><?php echo $this->popArr['message'];?></div>
						
					<?php } ?>
		<div class="row">
            <!-- Left col -->
            <div class="col-md-6">	
					<div class="box box-info">
                       <div class="box-header with-border">
                       <h4 class="box-title"><?php echo $lang_procedure." ".$lang_amount." ".$lang_information;?></</h4>
					    
                    </div>	
                    <div class="box-body">
							
					<table  class="table table-striped">
                    
                     <tr>					
						<td><?php echo $lang_procedure; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="procedure" id="procedure"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,amount)" value="<?php echo $procedure; ?>" autocomplete="off" readonly/> 
						</td>
					</tr>
					<tr>
						<td><?php echo $lang_hosp_amount; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="amount" id="amount"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,dr_amount)" value="<?php echo $amount; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<?php if( (!empty($procedureInfo)&&$procedureInfo[0][2]!=4 ) || (!empty($type)&&$type=="NOT THEATRE PROCEDURE" ) ){?>
					<tr class="normal_procedure">
						<td><?php echo $lang_dr_amount; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="dr_amount" id="dr_amount"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,surgeon_fee)" value="<?php echo $dr_amount; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<?php } ?>
					<?php if((!empty($procedureInfo)&&$procedureInfo[0][2]==4 )|| (!empty($type)&&$type=="THEATRE PROCEDURE" ) ){?>
					<tr >
						<td><?php echo $lang_surgeon_fee; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="surgeon_fee" id="surgeon_fee"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,assisstant_fee1)" value="<?php echo $surgeon_fee; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr >
						<td><?php echo $lang_assistant_fee1; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="assistant_fee1" id="assistant_fee1"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,assistant_fee2)" value="<?php echo $assistant_fee1; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr >
						<td><?php echo $lang_assistant_fee2; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="assistant_fee2" id="assistant_fee2"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,anethesia_charge)" value="<?php echo $assistant_fee2; ?>" autocomplete="off"/> 
						</td>
					</tr>
					
					<tr >
						<td><?php echo $lang_anethesia_charge; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="anethesia_charge" id="anethesia_charge"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,theatre_charge)" value="<?php echo $anethesia_charge; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr >
						<td><?php echo $lang_theatre_charge; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="theatre_charge" id="theatre_charge"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $theatre_charge; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<tr >
						<td><?php echo $lang_other_charges; ?> <span id='requiredfield'>*</span> : </td>
                        <td><input name="other_charges" id="other_charges"  
                            tabindex="2"  onkeypress="nextField(event.keyCode,description)" value="<?php echo $other_charges; ?>" autocomplete="off"/> 
						</td>
					</tr>
					<input type="hidden" name="theatre_proceedure" id="theatre_proceedure" value="THEATRE PROCEDURE">
					<?php } ?>
					
					
					
                      	</table>			
				
				
					<div align="center">
					
					
                     		 <input id="button1" type="button" name="Add" class="btn btn-success" value="Add" onclick="return submitForm()"/>
					
					
					 </div>
					
				</div>
			
				
            </div>
           
      </div>
	  <input name="pos" id="pos" type="hidden" value="<?php echo $post['pos'];?>" />
	   <input name="itemid" id="itemid" type="hidden" value="<?php echo $post['itemid'];?>" />
</form>	  
</body>
	</html>
	
