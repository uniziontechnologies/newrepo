<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>application/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>application/assets/bootstrap/js/bootstrap.min.js"></script>

     <!-- Morris Chart Js -->
    <script src="<?php echo base_url(); ?>application/assets/dist/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>application/assets/dist/morris/morris.js"></script>

    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>application/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>application/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>application/assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>application/assets/dist/js/demo.js"></script>
	
	<!-- date-range-picker -->
    <script src="<?php echo base_url(); ?>application/assets/plugins/datepicker/bootstrap-datepicker.js"></script>

  <!-- time-range-picker -->
   <script src="<?php echo base_url(); ?>application/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/ajax.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/ajax-dynamic-list.js"></script>
	
	
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/dialog_box.js"></script>
	
	 <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/dist/js/common_functions.js"></script>
	 
	<script src="<?php echo base_url(); ?>application/assets/dist/js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url(); ?>application/assets/dist/js/thickbox_common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>


    <!--... Short cut keys ...-->
<script type="text/javascript">

    $(document).keydown(function(event) {

       var type=$('#user_type_value').val();

       //New Invoice
       if( event.which === 66 && event.ctrlKey ) {

           event.preventDefault();

           window.location = "<?php echo site_url('invoice/invoice_form'); ?>";
           return false;

       }
       
       //New Purchase Order
       if( (event.which === 79 && event.ctrlKey ) && (type == 8) ) {

           event.preventDefault();

           window.location = "<?php echo site_url('purchase_order/order_form'); ?>";
           return false;
           
       }

       //New Purchase
       if( (event.which === 82 && event.ctrlKey ) && (type == 8) ) {

           event.preventDefault();

           window.location = "<?php echo site_url('purchase/purchase_form'); ?>";
           return false;
           
       }

       //New Movement
       if( (event.which === 77 && event.ctrlKey ) && (type == 8) ) {

           event.preventDefault();

           window.location = "<?php echo site_url('movement/movement_form'); ?>";
           return false;
           
       }

       //Home Page
       if( event.which === 72 && event.ctrlKey ) {

           event.preventDefault();

           window.location = "<?php echo site_url('dashboard'); ?>";
           return false;

       }

    });
    
</script>
	