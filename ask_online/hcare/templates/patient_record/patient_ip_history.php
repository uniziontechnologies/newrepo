
	
<?php
	
$patientIpInfo=$this  ->popArr['patientIpInfo'];


	
?>

<div id="content">
   <div class="box box-info">
                
            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_admitted_on; ?></a></th>
						  <th><a href="#"><?php echo $lang_discharged_on; ?></a></th>
						  <th><a href="#"><?php echo $lang_room_no;?></a></th>	
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($patientIpInfo)){
						     
					for($i=0;$i<count($patientIpInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo $patientIpInfo[$i][13];?></td>
					  <td><?php echo date("d-m-Y",strtotime($patientIpInfo[$i][20]));?></td>
					  <td><?php echo ($patientIpInfo[$i][22] !='0000-00-00')?date("d-m-Y",strtotime($patientIpInfo[$i][22])):"";?></td>
					  <td><?php echo $patientIpInfo[$i][37]."(BED:".$patientIpInfo[$i][38].")";?></td>
				   </tr>
					
			<?php }
			
			  }
			?>

			</tbody>
			</table>
            </div><!-- /.box-body -->
		</div>
	</div>


