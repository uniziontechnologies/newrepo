
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
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>

<style type="text/css">
	.btn-xs {
            padding: 5px;
           }
</style>
<script>
	
$(document).ready(function() { 

		       $("#attatch_document").bind('click', function() {
		    
			   if($("#document").val() == ""){
				   showDialog('Error','Please Upload Patient Document.','error',2);
			      return false;
			   }else{

		         $("#xray_upload").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=attach_patient_documents").attr("enctype","multipart/form-data");
   	             $("#xray_upload").submit();
				 return true;
			   }
		  });


          $(".delete_document_files").bind('click', function() {
		    
		         var id = $(this).attr('id');
                        
			  	$("#hidden_remove").val(id);
				
			  		         $("#xray_upload").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=delete_patient_document").attr("enctype","multipart/form-data");
   	             			 $("#xray_upload").submit();
		      
		    });

          $("#back").bind('click', function() {

			  		         $("#xray_upload").attr("action","../../lib/controllers/centralController.php?module=Billing&sub_module=Manage_Billing").attr("enctype","multipart/form-data");
   	             			 $("#xray_upload").submit();
		      
		    });	




});

</script>
</head>
<?php
	
	$documentInfo=$this ->popArr['documentInfo'];
	$billInfo=$this ->popArr['billInfo'];
	$post=$this ->popArr['post'];	

	
?>
<body id="frame">



 
		<section class="content">

			<h3>Patient Name : <?php if (!empty($billInfo)) {
				echo $billInfo[0][3]; } ?> &nbsp;&nbsp; Type : <?php echo $billInfo[0][1]; ?> 


             &nbsp;&nbsp; Ref.No :   <?php if(!empty($documentInfo[0][10])){ echo $documentInfo[0][11] ; }
							 else if(!empty($documentInfo[0][1]) && empty($documentInfo[0][10])){echo $documentInfo[0][1];}
							 else{
							 	echo $documentInfo[0][7];
							 }?>

           

			</h3>


<form name="xray_upload" id="xray_upload"  method="post" action=""> 
   <div class="box box-info">
                
                     <div class="box-body">

                <div class="col-md-3">
                	

			       <table class="table">
			         <tr>
				   <td><?php echo $lang_documents;?></td>
				   <td> <!-- <input name="document" id="document" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,remark)"> -->
                        

                        <input type="file" name="document" id="document" type="text" size="25"  autocomplete="off">               
				
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo ucwords(strtolower($lang_remarks));?></td>
				   <td> <input name="remark" id="remark" type="text" size="20"  autocomplete="off"  onkeypress="nextField(event.keyCode,attatch_document)">
                         </td>
				</tr>
				
				    <tr>
					<td id="noborder" colspan="2"><input type="button" id="attatch_document"  name="Save" class="btn btn-success" value="Attatch" class="attatch_document" style="margin-left: 21%;" /><input type="button" name="back" id="back" value="Back" class="btn btn-danger" style="margin-left: 5px;" /></td>
					<td></td>
				    </tr>
				</tr>
			       </table>


                </div>
	 <div class="col-md-9">				 
                 <div class="box box-info box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_documents;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints -->
			       <table id="show_documents" class="table table-striped" width="100%" style="table-layout: fixed;word-break: break-word;">
			       	<thead>
			       		<th >Sl.No</th>
			       		<!-- <th style="width: 5%;">Type</th>
			       		<th style="width: 5%;">Ref.No</th> -->
			       		<th >Bill No</th>
			       		<th >Bill Date</th>
			       		<th >File Name</th>
			       		<th >Remarks</th>
			       		<th  >Xray</th>
			       		<th >Action</th>
			       	</thead>
				 
			       <?php
 

							if(!empty($documentInfo)){ 
							$j=1;
							for($i=0;$i<count($documentInfo);$i++) { ?>
                            

						<tr >
							 <td ><?php echo $j++ ; ?></td>
							<!--  <td><?php echo $documentInfo[$i][8] ; ?></td>
							 <td><?php if(!empty($documentInfo[$i][10])){ echo $documentInfo[$i][11] ; }
							 else if(!empty($documentInfo[$i][1]) && empty($documentInfo[$i][10])){echo $documentInfo[$i][1];}
							 else{
							 	echo $documentInfo[$i][7];
							 }?></td> -->
							 <td><?php echo $documentInfo[$i][6] ; ?></td>
							 <?php if(!empty($documentInfo[$i][6])){?>
							 <td><?php echo date('d-m-y h:i:s',strtotime($documentInfo[$i][12])) ; ?></td>
                             <?php }else{?>
                             	<td></td>
                             <?php }?>
						<?php		if ($documentInfo[$i][3] != "") {
						
					

								$file_name = $documentInfo[$i][3];
							
								// $file_download_path = "../../lib/patient_documents";
								if($documentInfo[$i][7] != 0){
									$file_download_path = "../../lib/patient_documents/DIRECT"."/".$documentInfo[$i][7]."/";

								}else{
									$file_download_path = "../../lib/patient_documents"."/".$documentInfo[$i][1]."/";	
								}
							

								?>


					   
					   <td><?php echo $documentInfo[$i][3] ; ?></td>
					    <td ><?php echo $documentInfo[$i][4] ; ?></td>
					    <td ><?php echo(!empty($documentInfo[$i][9] )?'YES':'-') ; ?></td>

					   <td>
					       <a href='<?php echo $file_download_path.$file_name ?>' target="_blanck" title="View" class='show_documents delete_document btn btn-primary btn-xs'><i class='fa fa-eye'></i></a>&nbsp;&nbsp;
						    <a href='<?php echo $file_download_path.$file_name ?>' download class='delete_document btn btn-success btn-xs' title="Download"><i class='fa fa-download'></i></a>&nbsp;&nbsp;
							<a href='#' class='delete_document_files btn btn-danger btn-xs' id="<?php echo $documentInfo[$i][0]; ?>" title="Remove"><i class='fa fa-remove'></i></a>
							

					   </td>
					  
					  </tr>

				<?php
			}}}
					?>


		    
		                </table>
				
				
		    </div>
		 </div>
	</div>


		     </div>
		</div>
	</div>
</div>

<input type="hidden" name="hidden_remove" id="hidden_remove" value="">

<input type="hidden" name="bill_id" id="bill_id" value="<?php echo(!empty($billInfo[0][0])?$billInfo[0][0]:'') ; ?>">

<input type="hidden" name="opno" id="opno" value="<?php echo(!empty($billInfo[0][19])?$billInfo[0][19]:'') ; ?>"> 

<?php
if (!empty($billInfo[0][1]) && $billInfo[0][1]=="IP"  ) {?>
<input type="hidden" name="ipno" id="ipno" value="<?php echo(!empty($billInfo[0][2])?$billInfo[0][2]:'') ; ?>"> 
<?php
}
else{?>
<input type="hidden" name="ipno" id="ipno" value=""> 
<?php
}
?>

<?php
if (!empty($billInfo[0][1]) && $billInfo[0][1]=="IP"  ) {?>
<input type="hidden" name="visit_id" id="visit_id" value="<?php echo(!empty($billInfo[0][36])?$billInfo[0][36]:'') ; ?>"> 
<?php
}
else{?>
<input type="hidden" name="visit_id" id="visit_id" value="<?php echo(!empty($billInfo[0][2])?$billInfo[0][2]:'') ; ?>"> 
<?php
}
?>
<?php
if (!empty($billInfo[0][1]) && $billInfo[0][1]=="DIRECT"  ) {?>
<input type="hidden" name="direct_id" id="direct_id" value="<?php echo(!empty($billInfo[0][2])?$billInfo[0][2]:'') ; ?>"> 
<?php
}else{?>
<input type="hidden" name="direct_id" id="direct_id" value="0"> 
<?php
}
?>
<input type="hidden" name="cust_type" id="cust_type" value="<?php echo(!empty($billInfo[0][1])?$billInfo[0][1]:'') ; ?>">
<input type="hidden" name="xray_status" id="xray_status" value="1">


<input type="hidden" name="from_date" id="from_date" value="<?php echo(!empty($post['from_date'])?$post['from_date']:'') ; ?>">
<input type="hidden" name="to_date" id="to_date" value="<?php echo(!empty($post['to_date'])?$post['to_date']:'') ; ?>">
<input type="hidden" name="billno" id="billno" value="<?php echo(!empty($post['billno'])?$post['billno']:'') ; ?>">

<input type="hidden" name="type" id="type" value="<?php echo(!empty($post['type'])?$post['type']:'') ; ?>">

<input type="hidden" name="user" id="user" value="<?php echo(!empty($post['user'])?$post['user']:'') ; ?>">

<input type="hidden" name="status" id="status" value="<?php echo(!empty($post['status'])?$post['status']:'') ; ?>">



</form>   

</section>
  
</body>
</html>
