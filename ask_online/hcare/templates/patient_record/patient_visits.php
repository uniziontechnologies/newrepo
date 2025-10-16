
	
<?php
	
$patientInfo=$this  ->popArr['patient_info'];
$ip_info=$this  ->popArr['ip_info'];


	
?>

<div id="content">
   <div class="box box-info">
                
            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                        <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						<th><a href="#"><?php echo $lang_doctor; ?></a></th>
						<th ><a href="#"><?php echo $lang_date; ?></a></th>
						<th ><a href="#"><?php echo $lang_type; ?></a></th>
						<th width="5%"><a href="#"><?php echo $lang_status; ?></a></th>  
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($patientInfo)){
						     
						         for($i=0;$i<count($patientInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
					  <td><?php echo $patientInfo[$i][20]." ".$patientInfo[$i][19];?></td>
					  <td><?php echo (!empty($ip_info[$i])?"IP":"OP"); ?></td>
					  <td>
							<?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?></td>
			<?php }
			
			  }
			?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
		</div>
	</div>


