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
</style>

<form name="gst_info" id="gst_info" method="post" action="">

    <div class="container"  id="content">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div>
				    <button type="button" class="btn btn-success" onclick="createGst()"><i class="fa fa-plus"></i> GST
				    </button>
		    </div>
           
          </section>

          <!-- Main content -->
          <section class="content">
                        <?php 
                         $create_success = $this->session->flashdata('create_success');
                         $update_success = $this->session->flashdata('update_success');
                         $delete_success = $this->session->flashdata('delete_success'); 
                        if(!empty($create_success) || !empty($update_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-success"><?php echo !empty($create_success)?$create_success:$update_success; ?></div>
                        <?php
                            }
                        if(!empty($delete_success)) 
                            {
                        ?>

                              <div id='message' class="callout callout-danger"><?php echo $delete_success; ?></div>
                        <?php
                            }
                        ?>
            <div class="row">
          <div class="col-md-12">
		    <div class="box box-info">
                
               <div class="box-body">
			      <table width="100%" class="table table-striped">
				
				    <tr>
				        <td>GST% : &nbsp;&nbsp;&nbsp;<input type="text" name="search_gst" id="search_gst" value='' autocomplete="off"/> &nbsp;&nbsp;&nbsp;
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
				          <h1 class="box-title">GST</h1>
                    </div>

                    <div class="box-body">
				
					   <table width="100%" class="table table-striped table-bordered">
                        <thead>
					    <tr>
				            <th class="font_th"><a href="#">Sl No</a></th>
				            <th class="font_th"><a href="#">GST%</a></th>
				            <th class="font_th"><a href="#">SGST</a></th>
				            <th class="font_th"><a href="#">CGST</a></th>
				            <th class="font_th"><a href="#">IGST</a></th>
				            <th class="font_th"><a href="#">Action</a></th>
				        </tr>
				         </thead>
				         <tbody>
		<?php        
                if(!empty($gstInfo)){						
				    $j=1;
				    for($i=0;$i<count($gstInfo);$i++) {
		?>						
				        <tr>
				            <td><?php echo $j++;?></td>
							<td><?php echo $gstInfo[$i][1];?></td>
						    <td><?php echo $gstInfo[$i][2];?></td>
							<td><?php echo $gstInfo[$i][3];?></td>
						    <td><?php echo $gstInfo[$i][4];?></td>	
						    <td>
						    	<button type="button" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="updateGst('<?php echo $gstInfo[$i][0]; ?>')"><span class="glyphicon glyphicon-pencil"></span></button>

						    	<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" onclick="deleteGst('<?php echo $gstInfo[$i][0]; ?>')"><span class="glyphicon glyphicon-trash"></span></button>
						    </td>
				        </tr>
		<?php
		            }
		        }
		?>		
		                 </tbody>	   
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

<script type="text/javascript">

function searchForm() {
     	
    document.gst_info.action="<?php echo base_url(); ?>index.php/admin/manageInfo/gst";
    document.gst_info.submit();
}

function clearForm(){

        window.location = "<?php echo site_url('admin/manageInfo/gst'); ?>";
        return false;

}
	  
function createGst() { 
        
    tb_show('CREATE GST',"<?php echo base_url(); ?>index.php/admin/generateForm/gst/create");

}

function updateGst(id) {
     	
    tb_show('UPDATE GST',"<?php echo base_url(); ?>index.php/admin/generateForm/gst/update/"+id);
}

function tb_remove(){
	
	document.gst_info.action='<?php echo base_url(); ?>index.php/admin/manageInfo/gst';
	document.gst_info.submit();
}

function deleteGst(id) {

    var v=confirm("Do You Want To Delete!");
		if(v) {
   			
			document.gst_info.action='<?php echo base_url(); ?>index.php/admin/delete/gst/'+id;
			document.gst_info.submit();
			return true;
		}else return false;
}

</script>