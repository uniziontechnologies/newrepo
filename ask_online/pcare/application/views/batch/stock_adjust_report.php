<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        color: #006633;   
   }	
   .single{
            display:inline;
   }
</style>

<form name="adjust_stock_report" id="adjust_stock_report" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
                  BRAND INFORMATION
            </h1>
           
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                   
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>
                      <h4>
                         <b>
                            Brand  : &nbsp;&nbsp;&nbsp;
                            <?php echo $brand; ?>
                         </b>    
                      </h4>    
				        </td>
				    </tr>
                   
				  </table>
				  <div id="success"><?php echo !empty($message)?$message:''; ?></div>
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
		  </div> <!--row-->

        <section class="content-header">
            <h1>
                  STOCK ADJUSTMENTS
            </h1>
           
        </section>

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">
                         
                    <div class="box-body">
				          <div id="pagination" align="right">
                              <?php //echo $this->pagination->create_links(); ?>
                          </div>
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th">Sl No</th>
				            <th class="font_th">Batch</th>
				            <th class="font_th">Date/Time</th>
				            <th class="font_th">Qty</th>
				            <th class="font_th">Remarks</th>
				            <th class="font_th">User</th>
				        </tr>
		<?php        
                if(!empty($adjustInfo)){						
				    $j=1;
				    for($i=0;$i<count($adjustInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
					    <td><?php echo $adjustInfo[$i][4];?></td>
							<td><?php echo $adjustInfo[$i][6]." ".$adjustInfo[$i][7];?></td>
							<td><?php echo $adjustInfo[$i][8];?></td>
							<td><?php echo $adjustInfo[$i][13];?></td>
							<td><?php echo $adjustInfo[$i][15];?></td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>

					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>
