
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

<script>
	
$(document).ready(function() { 
	$('#documentcheck').hide();
	 $('#documentsizecheck').hide();
	 $('#documenttypecheck').hide();

		       $("#attatch_document").bind('click', function() {
		       	var file_name=$("#document").val();
		    
			   if($("#document").val() == ""){
				   $('#doc_namecheck').show();
			      return false;
			   }else if($("#filesize").val() == "1"  ){
			   	$('#documentsizecheck').show();
            	$("#document").focus();
			      return false;

			   }else if($("#filetype").val() == "1"  ){
			   	$('#documenttypecheck').show();
            	$("#document").focus();
			      return false;

			   }else{

		         $("#signature_upload").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=attach_lab_signature").attr("enctype","multipart/form-data");
   	             $("#signature_upload").submit();
				 return true;
			   }
		  });

  $('INPUT[type="file"]').change(function () {
    var fileExtension = ['jpg', 'jpeg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        alert("Only '.jpg','.jpeg','.png' formats are allowed.");
        // $('#documenttypecheck').show();
        // $("#document").focus();
        $("#filetype").val("1");
        // return false; 
    }else {
    	$("#filetype").val("0");
    }
    if (this.files[0].size > 2097152) {
                alert("Try to upload file less than 2MB!");
                // $('#documentsizecheck').show();
                // $("#document").focus();
                $("#filesize").val("1");
    }else{
    	$("#filesize").val("0");
    }

         
    
});


          $(".delete_document_files").bind('click', function() {

		       var a=confirm('Are you sure you want to delete this item?');
		       // alert(a);return false;
		       if( a == true){

		         var id = $(this).attr('id');
		      
                        
			  	$("#hidden_remove").val(id);
				
			  		         $("#signature_upload").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=delete_lab_signature").attr("enctype","multipart/form-data");
   	             			 $("#signature_upload").submit();
   	        }
		      
		    });

          $("#back").bind('click', function() {

			  		         $("#signature_upload").attr("action","../../lib/controllers/centralController.php?module=Lab&sub_module=Lab_employees").attr("enctype","multipart/form-data");
   	             			 $("#signature_upload").submit();
		      
		    });	




});

</script>
</head>
<?php
	
	// $documentInfo=$this ->popArr['documentInfo'];
	// $billInfo=$this ->popArr['billInfo'];
	$post=$this ->popArr['post'];

	$employeeInfo		=	$this  ->popArr['EmployeeInfo'];
	$userInfo		=	$this  ->popArr['userInfo'];	

	
?>
<body id="frame">



 
		<section class="content">

			<h3>Employee Name : <?php if (!empty($employeeInfo)) {
				echo $employeeInfo[0][2]." ".$employeeInfo[0][3];  } ?> &nbsp;&nbsp; Type : <?php echo $employeeInfo[0][13]; ?></h3>


<form name="signature_upload" id="signature_upload"  method="post" action=""> 
   <div class="box box-info">
                
                     <div class="box-body">

                <div class="col-md-6">
                	

			       <table class="table">
			         <tr>
				   <td><?php echo $lang_documents;?></td>
				   <td> <!-- <input name="document" id="document" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,remark)"> -->
                        

                        <input type="file" name="document" id="document" type="text" size="25"  autocomplete="off"> 
                        <br> 
                        <h5 id="documentcheck" style="color: red;">
					                  **Please Select a File
					              </h5>
					              <h5 id="documentsizecheck" style="color: red;">
					                  **File size is greater than 2MB
					              </h5>
					              <h5 id="documenttypecheck" style="color: red;">
					                  **Only '.jpg','.jpeg','.png' formats are allowed
					              </h5>
					                        
				
						
                                   </td>

				</tr>
				<tr>
					<p style="font-size: 15px;"><strong>Note:</strong> Only '.jpg','.jpeg','.png' formats allowed to a max size of 2 MB.</p><br>
				</tr>
				<!-- <tr>
				   <td><?php echo ucwords(strtolower($lang_remarks));?></td>
				   <td> <input name="remark" id="remark" type="text" size="20"  autocomplete="off"  onkeypress="nextField(event.keyCode,attatch_document)">
                         </td>
				</tr> -->

				
				    <tr>
					<td id="noborder" colspan="2"><input type="button" id="attatch_document"  name="Save" class="btn btn-success" value="Attatch" class="attatch_document" style="margin-left: 21%;" /><input type="button" name="back" id="back" value="Back" class="btn btn-danger" style="margin-left: 5px;" /></td>
					<td></td>
				    </tr>
				</tr>
			       </table>


                </div>
	 <div class="col-md-6">				 
                 <div class="box box-info box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_documents;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints -->
			       <table id="show_documents" class="table table-striped" width="25%">
				 
			       <?php


							if(!empty($employeeInfo[0][27])){

							// $j=1;
							// for($i=0;$i<count($documentInfo);$i++) {


								// if ($documentInfo[$i][3] == 0) {
						
					

								$file_name = $employeeInfo[0][27];
								$file_download_path = "../../lib/lab_signatures"."/".$employeeInfo[0][0]."/";
								// $file_download_path = "../../lib/patient_documents";
								// var_dump($file_download_path);
								?>


						<tr >
					   
					   <!-- <td>1.</td> -->
					    <td ><?php echo $employeeInfo[0][27] ; ?></td>
					   <td>
					       <a href='<?php echo $file_download_path.$file_name ?>' target="_blanck" class='show_documents delete_document text-light_blue'><i class='fa fa-th'></i>View</a>&nbsp;&nbsp;
						    <a href='<?php echo $file_download_path.$file_name ?>' download class='delete_document text-green' ><i class='fa fa-download'></i>Download</a>&nbsp;&nbsp;
							<a href='#' class='delete_document_files text-red' id="<?php echo $employeeInfo[0][0]; ?>" ><i class='fa fa-remove'></i>Remove</a>
							

					   </td>
					  
					  </tr>

				<?php
			}
		// }
		// }
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

<input type="hidden" name="emp_id" id="emp_id" value="<?php echo(!empty($employeeInfo[0][0])?$employeeInfo[0][0]:'') ; ?>">
<input type="hidden" name="filename_sign" id="filename_sign" value="<?php echo(!empty($employeeInfo[0][27])?$employeeInfo[0][27]:'') ; ?>">





<input type="hidden" name="from_date" id="from_date" value="<?php echo(!empty($post['from_date'])?$post['from_date']:'') ; ?>">
<input type="hidden" name="to_date" id="to_date" value="<?php echo(!empty($post['to_date'])?$post['to_date']:'') ; ?>">
<input type="hidden" name="billno" id="billno" value="<?php echo(!empty($post['billno'])?$post['billno']:'') ; ?>">

<input type="hidden" name="type" id="type" value="<?php echo(!empty($post['type'])?$post['type']:'') ; ?>">

<input type="hidden" name="user" id="user" value="<?php echo(!empty($post['user'])?$post['user']:'') ; ?>">

<input type="hidden" name="status" id="status" value="<?php echo(!empty($post['status'])?$post['status']:'') ; ?>">
<input type="hidden" name="filetype" id="filetype" value="" />
			<input type="hidden" name="filesize" id="filesize" value="" />



</form>   

</section>
  
</body>
</html>
