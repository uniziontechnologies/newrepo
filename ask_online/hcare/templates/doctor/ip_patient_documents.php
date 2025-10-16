<script>
	
$(document).ready(function() { 

		       $("#attatch_document").bind('click', function() {
		    
			   if($("#document").val() == ""){
				   showDialog('Error','Please Upload Patient Document.','error',2);
			      return false;
			   }else{

			   	

		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=attach_ip_patient_documents").attr("enctype","multipart/form-data");
   	             $("#form").submit();
				 return true;
			   }
		  });


          $(".delete_document_files").bind('click', function() {
		    
		         var id = $(this).attr('id');
                        
			  	 $("#hidden_remove").val(id);
				
			  		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_patient_document").attr("enctype","multipart/form-data");
   	             			 $("#form").submit();
		      
		    });	

	// $(".show_documents").bind('click', function() {
      
	//   var opid=$(this).attr('id');

	//   // alert(opid);

 //      tb_show('Documents',"<?php //echo $_SERVER['ROOT_PATH'].'/emr/lib/files/'.$documentInfo[1][1].'/'.$documentInfo[1][3] ?>",'',450,250);
 //    });		       





});

</script>
	
<?php
	
	$documentInfo=$this ->popArr['documentInfo'];	
	// var_dump($_SERVER['ROOT_PATH'].'/emr/lib/files/'.$documentInfo[1][1].'/'.$documentInfo[1][3]);

	
?>

<div id="content">
   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo $lang_documents;?></td>
				   <td> <!-- <input name="document" id="document" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,remark)"> -->
                        

                        <input type="file" name="document" id="document" type="text" size="25"  autocomplete="off">               
				
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo ucwords(strtolower($lang_remarks));?></td>
				   <td> <input name="remark" id="remark" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,attatch_document)">
                         </td>
				</tr>
				
				    <tr>
					<td id="noborder" colspan="2" align="center"><input type="button" id="attatch_document"  name="Save" class="btn btn-success" value="Attatch" class="attatch_document"/></td>
				    </tr>
				</tr>
			       </table>
		     </div>
		</div>
	</div>
</div>
	 <div class="col-md-6">				 
                 <div class="box box-info box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_documents;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints -->
			       <table id="show_documents" class="table table-striped" width="25%" style="table-layout: fixed;word-break: break-word;">
				       	<thead>
			       		<th  style="width: 8%;">Sl.N</th>
			       		<!-- <th style="width: 5%;">Type</th>
			       		<th style="width: 5%;">Ref.No</th> -->
			       		<!-- <th >Bill No</th>
			       		<th >Bill Date</th> -->
			       		<th >File Name</th>
			       		<th >Remarks</th>
			       		<th  style="width: 10%;" >Xray</th>
			       		<th >Action</th>
			       	</thead>
			       <?php


							if(!empty($documentInfo)){

							$j=1;
							for($i=0;$i<count($documentInfo);$i++) {


								// if ($documentInfo[$i][3] == 0) {
						
					

								$file_name = $documentInfo[$i][3];
								$file_download_path = "../../lib/patient_documents"."/".$documentInfo[$i][1]."/";
								// $file_download_path = "../../lib/patient_documents";
								// var_dump($file_download_path);
								?>


						<tr >
					     <td><?php echo $j++ ; ?></td> 
					   <td><?php echo $documentInfo[$i][3] ; ?></td>
					    <td ><?php echo $documentInfo[$i][4] ; ?></td>
					    <td ><?php echo(!empty($documentInfo[$i][9] )?'YES':'-') ; ?></td>
					   <td>

					   	<a href='<?php echo $file_download_path.$file_name ?>' target="_blanck" title="View" class='show_documents delete_document btn btn-primary btn-xs'><i class='fa fa-eye'></i></a>&nbsp;&nbsp;
						    <a href='<?php echo $file_download_path.$file_name ?>' download class='delete_document btn btn-success btn-xs' title="Download"><i class='fa fa-download'></i></a>&nbsp;&nbsp;
							<a href='#' class='delete_document_files btn btn-danger btn-xs' id="<?php echo $documentInfo[$i][0]; ?>" title="Remove"><i class='fa fa-remove'></i></a>
					      <!--  <a href='<?php echo $file_download_path.$file_name ?>' target="_blanck" class='show_documents delete_document text-light_blue'><i class='fa fa-th'></i>View</a>&nbsp;&nbsp;
						    <a href='<?php echo $file_download_path.$file_name ?>' download class='delete_document text-green' ><i class='fa fa-download'></i>Download</a>&nbsp;&nbsp;
							<a href='#' class='delete_document_files text-red' id="<?php echo $documentInfo[$i][0]; ?>"><i class='fa fa-remove'></i>Remove</a> -->
							

					   </td>
					  
					  </tr>

				<?php
			// }
		}}
					?>


		    
		                </table>
				
				
		    </div>
		 </div>
	</div>
	
<input type="hidden" name="hidden_remove" id="hidden_remove" value="">
<!-- <input type="hidden" name="opid" id="opid" value="<?php echo $documentInfo[$i][1]; ?>"> -->