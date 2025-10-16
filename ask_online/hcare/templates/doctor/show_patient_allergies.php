
	
<?php
	$allergicInfo=$this ->popArr['allergicInfo'];
	
?>

  
	 <div class="col-md-12">				 
                 <div class="box box-danger box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_allergies;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <table id="show_allergies" class="table table-striped" width="25%">
		               
		                 
				  <?php if(!empty($allergicInfo)){
					  
					      $k=1;
				    for($i=0;$i<count($allergicInfo);$i++){?>
					   <tr id="trs_data<?php echo $allergicInfo[$i][0];?>">
					   <td><?php echo $k++;?>
					   <td><?php echo $allergicInfo[$i][3];?></td>
					    <td ><?php echo $allergicInfo[$i][4];?></td>
					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>
				
				
		    </div>
		 </div>
	</div>
