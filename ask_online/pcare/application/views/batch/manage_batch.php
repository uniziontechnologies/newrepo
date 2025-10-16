<?php 
      $this->load->view("header");
?> 

<style type="text/css">
   .font_th{

	    font-size: 15px;
   }
   #success{
        margin-left: 14px;
        font-size: 14px;    
   }	
   .single{
        display:inline;
   }
</style>

<form name="manage_batch" id="manage_batch" method="post" action="">
<input type="button" name="but" value="Go Back" class="btn btn-danger black-background white DONTPrint" onclick="goBack()">
    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div>
                  <button type="button" class="btn btn-success" onclick="createBatch('<?php echo $brand_id; ?>')"><i class="fa fa-plus"></i> BATCH
                    </button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success" onclick="AdjustmentsReport('<?php echo $brand_id; ?>')">ADJUSTMENTS
                    </button>

            </div>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $create_failed = $this->session->flashdata('create_failed'); 
                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>
                        <?php
                            }
                        if(!empty($create_failed)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo $create_failed; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
                <div align="center" style="margin-top: 5px;">

                	  <h5 class="single text-muted"><b>Brand Name : <?php echo $brand_name ; ?></b></h5>
                	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	  <h5 class="single text-muted"><b>Main Stock : <?php echo $brand_stock ; ?></b></h5>
                	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	  <h5 class="single text-muted"><b>Branch Stock : <?php echo $branch_stock ; ?></b></h5>

                </div>	    
               
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>
                          Batch : &nbsp;&nbsp;&nbsp;

                          <input type="text" name="batch_no" id="batch_no" value="" autocomplete="off">             
                         &nbsp;&nbsp;&nbsp;
                         Branch : &nbsp;&nbsp;&nbsp;

                         <select name="branch" id="branch" onchange="return searchForm();">
                            <option value="" selected="selected">------select-----</option>
                            <option value="main_branch">Main Branch</option>

        <?php
                for($i=0; $i<count($branchInfo); $i++) 
                    { 
        ?>
                           <option value="<?php echo $branchInfo[$i][0]; ?>"><?php echo $branchInfo[$i][1]; ?></option>         
        <?php
                    }
        ?>                    

                         </select>
                         &nbsp;&nbsp;&nbsp;
                         Expired : &nbsp;&nbsp;&nbsp;

                         <input type="checkbox" name="expired_batch" id="expired_batch" onchange="searchForm();" value="1" <?php echo !empty($expired_batch) && ($expired_batch == 1)?'checked':'' ?> >
                         &nbsp;&nbsp;&nbsp;
                         
                         Zero Stock : &nbsp;&nbsp;&nbsp;

                         <input type="checkbox" name="zero_stock" id="zero_stock" onchange="searchForm();" value="1" <?php echo !empty($zero_stock) && ($zero_stock == 1)?'checked':'' ?> >
                         &nbsp;&nbsp;&nbsp;

				                 <button type="button" class="btn btn-info" onclick="searchForm()">
                              <span class="glyphicon glyphicon-search"></span> Search
                         </button>
                         <button type="button" class="btn btn-danger" onclick="clearForm()">
                              <span class="glyphicon glyphicon-refresh"></span> Clear
                    </button>
				        </td>
				    </tr>
                   
				  </table>
			   </div><!--boxbody-->
			  </div><!--boxinfo-->
			</div><!--col-md-12-->
          <div id="success"><?php echo !empty($message)?$message:''; ?></div>
		  </div> <!--row-->

		  <div class="row">
			 <div class="col-md-12">
				<div class="box box-info">

             <div class="box-header with-border">
                  <h1 class="box-title">BATCH</h1>
             </div>
                         
             <div class="box-body">
				          
					   <table width="100%" class="table table-striped table-bordered">

					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">Batch</a></th>
				            <th class="font_th"><a href="#">Expiry Date</a></th>
				            <th class="font_th"><a href="#">Stock</a></th>
				            <th class="font_th"><a href="#">Price Type</a></th>
				            <th class="font_th"><a href="#">SellP</a></th>
				            <th class="font_th"><a href="#">BuyP</a></th>
				            <th class="font_th"><a href="#">Supplier</a></th>
				            <th class="font_th"><a href="#">Branch</a></th>
				            <th class="font_th"><a href="#">Bill No</a></th>
				            <th class="font_th"><a href="#">Bill Date</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
		<?php        
                if(!empty($batch)){						
				    $j=1;
				    for($i=0;$i<count($batch);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
					        <td><?php echo $batch[$i][2];?></td>
							<td><?php echo $batch[$i][3];?></td>
							<td><?php echo $batch[$i][4];?></td>
							<td><?php echo $batch[$i][5];?></td>
							<td><?php echo $batch[$i][6];?></td>
							<td><?php echo $batch[$i][7];?></td>
							<td><?php echo $batch[$i][9];?></td>
							<td><?php echo empty($batch[$i][13])?"Main Branch":$batch[$i][13];?></td>
                            
                            <?php 

                                if ($batch[$i][30] == "M") {?>

                                    <td class="text-center"><?php echo $batch[$i][33];?></td>
                                    <td class="text-center"><?php echo date("d-m-Y",strtotime($batch[$i][34]));?></td>

                                <?php 
                                }
                                else if($batch[$i][30] == "P"){?>

                                    <td class="text-center"><?php echo $batch[$i][16];?></td>
                                    <td class="text-center"><?php echo date("d-m-Y",strtotime($batch[$i][27]));?></td>

                                <?php
                                }
                                else{

                                    if (!empty($batch[$i][31])) {?>


                                    <td class="text-center"><?php echo $batch[$i][33];?></td>
                                    <td class="text-center"><?php echo date("d-m-Y",strtotime($batch[$i][34]));?></td>

                                <?php 

                                    }
                                    else{?>

                                    <td class="text-center"></td>
                                    <td class="text-center"></td>

                                    <?php
                                    }

                                }


                            ?>
							<!-- <td><?php echo $batch[$i][16];?></td>
							<td><?php echo ($batch[$i][16] >0)?date("d-m-Y",strtotime($batch[$i][27])):'';?></td> -->
					
						    <td>
						    	<div class="btn-group">	
	                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Option
                                      <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>   
                                  <ul class="dropdown-menu" role="menu">	

					                 <li onclick="updateBatch('<?php echo $brand_id; ?>','<?php echo $batch[$i][0]; ?>')"><a href="#">Edit</a></li>
						   
				                     <li onclick="AdjustStock('<?php echo $batch[$i][0]; ?>')"><a href="#">Adjust Stock</a></li>
										
							      </ul>
	                            </div>
						    </td>
				        </tr>
		<?php
		            }
		        }
		?>			   
					   </table>
                    <input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
					</div>
				</div>
			</div>
			</div><!--row-->
          </section><!-- /.content -->
    </div><!-- /.container -->

<?php
      $brand_name=$this->input->post('brand_name_search');
      $manufacturer_name=$this->input->post('manufacturer_name');
      $generic_name=$this->input->post('generic_name_search');
      $category=$this->input->post('category_search');
      $current_page=$this->input->post("current_page");
?>
      
    <input type="hidden" name="brand_name_search" id="brand_name_search" value="<?php echo $brand_name; ?>">
    <input type="hidden" name="manufacturer_name" id="manufacturer_name" value="<?php echo $manufacturer_name; ?>">
    <input type="hidden" name="generic_name_search" id="generic_name_search" value="<?php echo $generic_name; ?>">
    <input type="hidden" name="category_search" id="category_search" value="<?php echo $category; ?>">
    <input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page; ?>">
		        
</form>    

<?php
	  $this->load->view("footer"); 
?>

<script type="text/javascript">

function searchForm(){

	   document.manage_batch.action="<?php echo base_url(); ?>index.php/batch/index";
	   document.manage_batch.submit();
		
}

function clearForm(){

    $('#expired_batch').attr('checked', false);
    $('#zero_stock').attr('checked', false);
    
    document.manage_batch.action="<?php echo base_url(); ?>index.php/batch/index";
    document.manage_batch.submit();

}
	  
function createBatch(brand_id) {
     	    
    tb_show('CREATE BATCH',"<?php echo base_url(); ?>index.php/batch/batch_form/create/"+brand_id);

}

function updateBatch(brand_id,id) {
     	
    tb_show('UPDATE BATCH',"<?php echo base_url(); ?>index.php/batch/batch_form/update/"+brand_id+"/"+id);

}

function AdjustStock(id) {
     	
    tb_show('Adjust Stock',"<?php echo base_url(); ?>index.php/batch/stock_adjust_form/"+id);
	 
}

function AdjustmentsReport(id) {

    tb_show('STOCK ADJUSTMENTS DETAILS',"<?php echo base_url(); ?>index.php/batch/stock_adjust_report/"+id);
	
}

function tb_remove(){
  
  document.manage_batch.action='<?php echo base_url(); ?>index.php/batch/index';
  document.manage_batch.submit();
}

function goBack(){

  document.manage_batch.action="<?php echo base_url(); ?>index.php/brand/manageBrand";
  document.manage_batch.submit();

}

</script>