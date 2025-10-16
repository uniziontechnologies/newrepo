<?php 

     $this->load->view("header"); 
 
     $user_type=$this->session->userdata('user_type');
?>
<style type="text/css">

body{
   
   background-color: #f3efea;

}
.chartstyle{

    font-weight: bold !important;
    font-size: 16px !important;
}
.icon i {
    /*font-size: 126px !important;*/
    padding-top: 23px !important;
}

</style>
<form name="homepage_form" id="homepage_form" method="post" action=""> 
<div id="page-wrapper" style="margin-top: 10px;">
  <div id="page-inner">

<?php
if($user_type=="8"){
?>

    <div id="row">

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green" style="height: 190px !important;">
                <div class="inner">
                  <h3><?php echo $today_bill_collection; ?></h3>
                  <p>Todays Bill Collection</p>
                </div>
                <div class="icon">
                   <i class="fa fa-rupee fa-1x"></i>
                </div>
                <a href="<?php echo base_url(); ?>index.php/reports/dailyBillCollection" class="small-box-footer" style="margin-top: 72px !important;">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
             
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua" style="height: 190px !important;">
                <div class="inner">
                  <h3><?php echo $total_credit; ?></h3>
                  <p>Total Credit</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks fa-1x"></i>
                </div>
                <a href="#" onclick="credit_payments()" class="small-box-footer" style="margin-top: 72px !important;">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red" style="height: 190px !important;">
                <div class="inner">
                  <h3><?php echo $expired_stock; ?></h3>
                  <p>Expired</p>
                </div>
                <div class="icon">
                  <i class="fa fa-times fa-1x"></i>
                </div>
                <a href="#" onclick="expired_stock('<?php echo date('Y-m-d'); ?>')" class="small-box-footer" style="margin-top: 72px !important;">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow" style="height: 190px !important;">
                <div class="inner">
                  <h3><?php echo $low_inventory; ?></h3>
                  <p>Low Inventory</p>
                </div>
                <div class="icon">
                  <i class="fa fa-minus-circle fa-1x"></i>
                </div>
                <a href="<?php echo base_url(); ?>index.php/reports/low_inventory_report" class="small-box-footer" style="margin-top: 72px !important;">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col --> 
    </div>

    <div class="row">


                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="panel panel-default" style="margin-top: 20px !important;">
                            <div class="panel-heading chartstyle">
                                Bill Collections Last 7 Days
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-default" style="margin-top: 20px !important;">
                            <div class="panel-heading chartstyle">
                                Todays Detailed Bill Collection 
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                            </div>
                        </div>
                    </div>

    </div>

<?php
}else{
?>
        <section class="content-header">
          <h1>
            HOME
           
          </h1>
         
        </section>
   
        <!-- Main content -->
        <section class="content">
        <div class="box box-info">
        <div class="box-body" ></div>
        <div class="box-body" >
          <img src="<?php echo base_url(); ?>application/assets/dist/img/pharmacy_banner1.jpg" height="535" width="1180px">
        </div>
      </div>
      
    </section>


             
<?php
}
?>

    <div class="row">
           
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
<?php if( $user_type == "8"){?> 
          <center style="font-size: 16px;font-weight: bold;">Shortcut Keys</center>
        
          <table width="100%" class="table table-striped table-bordered" style="font-size: 14px;">

              <tr>
                  <th>Home Page (CTR + H)</th>
                  <th>New Invoice (CTR + B)</th>
                  <th>New Purchase Order (CTR + O)</th>
                  <th>New Purchase (CTR + R)</th>
                  <th>New Movement (CTR + M)</th>
              </tr>

          </table>
<?php 
      } 
      if( $user_type == "9"){
?> 
          <center style="font-size: 16px;font-weight: bold;">Shortcut Keys</center>
        
          <table width="100%" class="table table-striped table-bordered" style="font-size: 14px;">

              <tr>
                  <th style="text-align: center;">Home Page (CTR + H)</th>
                  <th style="text-align: center;">New Invoice (CTR + B)</th>
              </tr>

          </table>
<?php } ?> 
          </div>
          <div style="margin-top: -14px;">
               <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="http://uniziontechnologies.com">Unizion Technologies</a>.</strong> All rights reserved.
          </div>
      </div>

    </div>
   
  </div>
</div>
         <input type="hidden" name="expired_date" id="expired_date">
         
</form>
<?php
			 $this->load->view("footer"); 
?>
<script type="text/javascript">

$(document).ready(function() {

        var inline_action="<?php echo base_url(); ?>index.php/reports/getBillCollections_graph";
		   
			var data='';
		    $.post(inline_action, data, function (response) {	  
				 
				 // document.write(item_info);
				  //data: [{y: '2006',a: 100,b: 90}, {y: '2007',a: 75,b: 65}, {y: '2008',a: 50,b: 40}, {y: '2009',a: 75,b: 65}, {y: '2010',a: 50,b: 40}, {y: '2011',a: 75, b: 65}, {y: '2012',a: 100,b: 90}],
                
				Morris.Bar({
                element: 'morris-bar-chart',
				data: response,
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Bill Collection'],
                hideHover: 'auto',
                resize: true
            });
				 
		},"json");



        var inline_action="<?php echo base_url(); ?>index.php/reports/getDetailedBillCollection_graph";
                
                var data='';
                 $.post(inline_action, data, function (response) {
                 
                
                 
                Morris.Donut({
                element: 'morris-donut-chart',
                data: [{
                    label: "Cash",
                    value: response['cash']
                }, {
                    label: "Card",
                    value: response['card_amount']
                }, {
                    label: "Credit",
                    value: response['credit_amont']
                }, {
                    label: "Credit Payment",
                    value: response['credit_payment']
                }],
                resize: true
            });
                 
                 
                 },"json");

});


function expired_stock(expired_date){

    $('#expired_date').val(expired_date);

    document.homepage_form.action='<?php echo base_url(); ?>index.php/reports/expired_medicines_report';
	document.homepage_form.submit();

}

function credit_payments(){

    document.homepage_form.action='<?php echo base_url(); ?>index.php/invoice/credit_payment';
	document.homepage_form.submit();

}

</script>
		
