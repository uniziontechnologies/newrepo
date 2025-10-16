
<style type="text/css">

.table_style{
	font-size: 15px;width: 70%;margin: 0 auto;
}	
.margin_10{
	margin-top: 10px;
}
.margin_50{
	margin-top: 30px;
}
table{
        width: 100% !important;
      }

</style>


    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h4>
                  ITEMWISE PURCHASE HISTORY REPORT
            </h4>
           
          </section>

          <!-- Main content -->
          <section class="content">

            <div class="row">
          <div class="col-md-12">
            <div class="box box-info DONTPrint">
            
               <div class="box-body">
						<table class="table table-striped table-bordered table_style margin_10">

							<tr>
								<!-- <td> <?php echo $this->lang->line('from_date'); ?>:<?php echo $from_date;?></td>
								<td> <?php echo $this->lang->line('end_date'); ?>:<?php echo $to_date;?></td> -->
								<td><?php echo $this->lang->line('brand'); ?>:<b><i><?php echo $brand_name;?></i></b></td>
																
							</tr>
						</table>  

						<table class="table table-striped table-bordered table_style margin_50" width="100%">
							<thead>
								<tr>
									<th  width="6%">Sl No</th>														
									<th width="25%"><?php echo $this->lang->line('bill_no');?></th>
									<th width="20%"><?php echo $this->lang->line('date');?></th>
									<!-- <th><?php echo $this->lang->line('mode') ?></th> -->							
									<th><?php echo $this->lang->line('batch') ?></th>
									<th width="20%"><?php echo $this->lang->line('expiry') ?></th>
									<th><?php echo $this->lang->line('pack') ?></th>
									<th><?php echo $this->lang->line('qty') ?></th>
									<th><?php echo $this->lang->line('foc') ?></th>
									<th width="50%"><?php echo $this->lang->line('supplier') ?></th>
									<th><?php echo $this->lang->line('buyp') ?></th>
									<!-- <th><?php echo $this->lang->line('discount') ?></th> -->
									<th><?php echo $this->lang->line('sellp') ?></th>
								    <th><?php echo $this->lang->line('gst%') ?></th>
									<th><?php echo $this->lang->line('sgst') ?></th>
									<th><?php echo $this->lang->line('cgst') ?></th>
									<th><?php echo $this->lang->line('total_gst') ?></th>
									<th><?php echo $this->lang->line('total') ?></th>
																	
								</tr>
							</thead>
							<tbody>
							
							<?php
							    $sgst=0;
							    $cgst=0;
							    $totalgst=0;
								$net_total=0;
								 $j=1;
								if(!empty($itemInfo)){	
								// var_dump($itemInfo);
								// return false;					
										
									for($i=0;$i<count($itemInfo);$i++) {?>
											<tr>
												<td><?php echo  $itemInfo[$i][0];;?></td>
												<td><?php echo $itemInfo[$i][6];?></td>
												<td><?php echo date("d-m-Y",strtotime($itemInfo[$i][13]));?></td>
												<td><?php echo $itemInfo[$i][2];?></td>
												<td><?php echo date("d-m-Y",strtotime($itemInfo[$i][3]));?></td>
												<td><?php echo $itemInfo[$i][14];?></td>
												<td><?php echo $itemInfo[$i][4];?></td>	
												<!-- <td>
												    <?php echo ($itemInfo[$i][3]=='Return')?(-$itemInfo[$i][7]):$itemInfo[$i][7];?>
												</td> -->
												<td><?php echo $itemInfo[$i][5];?></td>
												<td><b><font color="red"><?php echo $itemInfo[$i][17];?></font></b></td>

												<td><b><font color="red"><?php echo $itemInfo[$i][7];?></font></b></td>													
												<!-- <td><?php echo empty($itemInfo[$i][11])?$itemInfo[$i][11]:$itemInfo[$i][11]."(".$itemInfo[$i][10].")";?></td> -->
												<td><?php echo $itemInfo[$i][8];?></td>	
												<td><?php echo $itemInfo[$i][9];?></td>
												<td><?php echo $itemInfo[$i][10];?></td>
												<td><?php echo $itemInfo[$i][11];?></td>
												<td><?php echo $itemInfo[$i][15];?></td>

												<td><?php echo $itemInfo[$i][12];?></td>
															
												
											</tr>


						<?php	
     
											
								}
							}
							
								?>
						
							
							</tbody>
						</table>


             
               </div><!--boxbody-->
              </div><!--boxinfo-->
            </div><!--col-md-12-->
          </div> <!--row-->
        </section><!-- /.content -->
    </div><!-- /.container -->
