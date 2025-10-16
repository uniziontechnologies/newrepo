
<style type="text/css">

.table_style{
	font-size: 15px;width: 85%;margin: 0 auto;
}	
.margin_10{
	margin-top: 10px;
}
.margin_50{
	margin-top: 30px;
}

</style>


    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h4>
                  H1N SHEDULED X INVOICE REPORT
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
								<td> <?php echo $this->lang->line('from_date'); ?>:<?php echo $from_date;?></td>
								<td> <?php echo $this->lang->line('end_date'); ?>:<?php echo $to_date;?></td>
								<td> <?php echo $this->lang->line('brand'); ?>:<?php echo $brand_name;?></td>
																
							</tr>
						</table>  

						<table class="table table-striped table-bordered table_style margin_50">
							<thead>
								<tr>
									<th>Sl No</th>	
									<th><?php echo $this->lang->line('bill_no');?></th>
									<th>Cust Type</th>
									<th>Customer Name</th>
									<th>Op/Ip No</th>
									<th>Doctor</th>
									<th><?php echo $this->lang->line('date');?></th>			
									<th>Mode</th>									
									<th><?php echo $this->lang->line('batch');?></th>
									<th><?php echo $this->lang->line('expiry');?></th>
									<th><?php echo $this->lang->line('qty');?></th>
									<th><?php echo $this->lang->line('sellp');?></th>
									<th><?php echo $this->lang->line('total');?></th>
																	
								</tr>
							</thead>
							<tbody>
							
							<?php
								$net_total=0;
								$tot_qty=0;
								 $j=1;
								if(!empty($itemInfo)){				
										
									for($i=0;$i<count($itemInfo);$i++) {?>
											<tr>
												<td><?php echo $j++;?></td>
												<td><?php echo $itemInfo[$i][1];?></td>
												<td><?php echo $itemInfo[$i][32];?></td>
												<td><?php echo $itemInfo[$i][30];?></td>
												<td>
												<?php 
												     if($itemInfo[$i][32]=='OP'){
                                                        echo $itemInfo[$i][33];
												     }elseif ($itemInfo[$i][32]=='IP') {
												     	echo $itemInfo[$i][34];
												     }else{
                                                         //direct
												     }
												?>   	
												</td>
												<td><?php echo $itemInfo[$i][37];?></td>
												<td><?php echo $itemInfo[$i][2];?></td>
												<td><?php echo $itemInfo[$i][5];?></td>
												<td><?php echo $itemInfo[$i][6];?></td>
												<td><?php echo $itemInfo[$i][7];?></td>
												<td>
												<?php 
												   echo ($itemInfo[$i][5]=='Return')?(-$itemInfo[$i][9]):$itemInfo[$i][9];
                                                   echo " ".$itemInfo[$i][8];
												?>
												</td>	
												<td><?php echo $itemInfo[$i][10];?></td>
												<td><?php echo ($itemInfo[$i][5]=='Return')?(-$itemInfo[$i][11]):$itemInfo[$i][11];?></td>					
												
											</tr>
						<?php	
						                $net_total_all=($itemInfo[$i][5]=='Return')?(-$itemInfo[$i][11]):$itemInfo[$i][11];

						                $qty_all=($itemInfo[$i][5]=='Return')?(-$itemInfo[$i][9]):$itemInfo[$i][9];
						
										$net_total=$net_total+$net_total_all;
										$tot_qty=$tot_qty+$qty_all;
											
								}
							}
							
								?>
							<tr>
								<td colspan="9" align="right"><b>Total</b></td>
								<td><b><?php echo $tot_qty;?> NOS</b></td>
								<td></td>
								<td><b><?php echo $net_total;?></b></td>
								
							</tr>
							
							</tbody>
						</table>


             
               </div><!--boxbody-->
              </div><!--boxinfo-->
            </div><!--col-md-12-->
          </div> <!--row-->
        </section><!-- /.content -->
    </div><!-- /.container -->
