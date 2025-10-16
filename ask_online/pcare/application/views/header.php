<?php 
//Define Root Path
if(!$this->user->is_logged_in()){
     redirect('login/index');
}

$user_type=$this->session->userdata('user_type');

$user_type_name=$this->session->userdata('user_type_name');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pcare Powered by Unizion Technologies</title>
    <!-- Bootstrap Styles-->
     <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/AdminLTE.min.css">
    
    <!-- morris style -->
    <link href="<?php echo base_url(); ?>application/assets/dist/morris/morris-0.4.3.min.css" rel="stylesheet" />
  
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/skins/skin-blue.min.css">
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/plugins/datepicker/datepicker3.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/plugins/timepicker/bootstrap-timepicker.min.css">
  
   <link href="<?php echo base_url(); ?>application/assets/dist/css/ajax_list.css" rel="stylesheet" type="text/css" />
   
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/dist/css/dialog_box.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/dist/css/thickbox.css" />
    
</head>
 <body class="hold-transition skin-blue layout-top-nav" >
<!--<div id='loader'><img src='<?php echo base_url(); ?>application/assets/img/loading.gif' /></div>-->

<div id="wrapper">
<div>
  <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>index.php/dashboard" class="navbar-brand"><b><?php echo $clinic_name; ?></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo base_url(); ?>index.php/dashboard"><i class="fa fa-user"></i> Home</a></li>
                
<?php if( $user_type == "8"){?> 

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<i class="fa fa-envelope-o"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">

                     <li><a href="<?php echo base_url(); ?>index.php/admin/hospital_info">Hospital Info</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/pharmacy_info">Pharma Config</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/manageInfo/gst">Gst Info</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/manageInfo/user">Users</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/manageInfo/customer">Customer</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/manageInfo/supplier">Supplier</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/manageInfo/branch">Branch</a></li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/pharmacy_stock">New Stock Import</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/pharmacy_stock_clearence">Stock Clearence & Import</a></li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/pharmacy_stock_export">Stock Export</a></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/pharmacy_stock_update">Stock Update</a></li>
                     <li class="divider"></li>
                     <li><a href="<?php echo base_url(); ?>index.php/admin/printer_settings">Printer Settings</a></li>
                  </ul>
        </li>

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Brand<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     
                     <li><a href="<?php echo base_url(); ?>index.php/brand/manageBrand">Manage Brand</a></li>

                     <li><a href="<?php echo base_url(); ?>index.php/brand/manageCategory">Manage Category</a></li>
                     <li class="divider"></li>

                    <li><a href="<?php echo base_url(); ?>index.php/brand/branch_wise_stock_report">Branch Stock Consumables</a></li>

                    <li><a href="<?php echo base_url(); ?>index.php/brand/consume_adjust_report">Consumables Report</a></li>



                  </ul>
        </li>

<?php } ?> 

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Invoice<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     
                     <li><a href="<?php echo base_url(); ?>index.php/invoice/invoice_form">New Invoice</a></li>

                     <li><a href="<?php echo base_url(); ?>index.php/invoice/invoice_return_form">Invoice Return</a></li>

                       <li><a href="<?php echo base_url(); ?>index.php/invoice/draft_invoice">Invoice Drafts</a></li>
                     

                     <li><a href="<?php echo base_url(); ?>index.php/invoice/select_return_bill">Invoice Return Billwise</a></li>

                     <li><a href="<?php echo base_url(); ?>index.php/invoice/manage_invoice">Manage Invoice</a></li>

                      <li><a href="<?php echo base_url(); ?>index.php/invoice/credit_payment">Credit Payment</a></li>

                      <li><a href="<?php echo base_url(); ?>index.php/invoice/manage_credit_payment">Manage Credit Payment</a></li>

                  </ul>
        </li>

<?php if( $user_type == "8" ||  $user_type == "9" ){?> 

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchase Order<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     
                     <li><a href="<?php echo base_url(); ?>index.php/purchase_order/order_form">New Purchase Order</a></li>

                     <li><a href="<?php echo base_url(); ?>index.php/purchase_order/manage_purchase_order">Manage Purchase Order</a></li>
                     
                  </ul>
        </li>

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Purchase<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
              <li><a href="<?php echo base_url(); ?>index.php/purchase/purchase_form">New Purchase</a></li>
              <li><a href="<?php echo base_url(); ?>index.php/purchase/purchase_return_form">Purchase Return</a></li>
              <li><a href="<?php echo base_url(); ?>index.php/purchase/drafted_bills">Drafted Bills</a></li>
              <li><a href="<?php echo base_url(); ?>index.php/purchase/manage_purchase">Manage Purchase</a></li>

                      
<?php }
if( $user_type == "8"){
 ?> 

              <li><a href="<?php echo base_url(); ?>index.php/purchase/issue_cheque">Issue Cheque</a></li>  
              <li><a href="<?php echo base_url(); ?>index.php/purchase/credit_payment">Credit Payment</a></li>
              <li><a href="<?php echo base_url(); ?>index.php/purchase/manage_purchase_credit_payment">Manage Credit Payment</a></li>   
          
                               
                  </ul>
        </li>

        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Movement<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     
                     <li><a href="<?php echo base_url(); ?>index.php/movement/movement_form">New Movement</a></li>

                     <li><a href="<?php echo base_url(); ?>index.php/movement/manage_movement">Manage Movement</a></li>
                     
                  </ul>
        </li>

<?php }
if( $user_type == "8"){
 ?> 
 
        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>

                  <ul class="dropdown-menu" role="menu">

                    <li><a href="<?php echo base_url(); ?>index.php/reports/dailyBillCollection">Daily Collection Report</a></li>
                    
                    <li class="menu-item dropdown dropdown-submenu">
                        <a href="#">Gst Reports</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>index.php/reports/gstPurchaseReport">Purchase Report</a></li>
                                   <li><a href="<?php echo base_url(); ?>index.php/reports/gstwisePurchaseReport">Gst Wise Purchase Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/hsnWisePurchaseReport">Hsn Wise Purchase Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/hsnWiseSalesReport">Hsn Wise Sales Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/hsnWiseSalesReturnReport">Hsn Wise Sales Return Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/hsnWiseSummaryReport">Hsn Wise Summary Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/hsnWiseSummaryReportPercentageWiseNew">GST % Wise Hsn Summary Report </a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/salesReportCtwoBtwo">B2C2 Sales Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/salesFile">Sales File Report</a></li>
                            </ul>
                    </li>
                     
                    <li class="menu-item dropdown dropdown-submenu">
                        <a href="#">Stock Reports</a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>index.php/reports/daily_stock_report">Daily Stock Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/dailyBrandWiseStockReport">Daily Brand Wise Stock Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/stock_report">Stock Report</a></li>
                                 <li><a href="<?php echo base_url(); ?>index.php/reports/supplier_wise_stock_report">Supplier Wise Stock Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/low_inventory_report">Low Inventory Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/expired_medicines_report">Expiry Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/non_movement_report">Non Movable Brands</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/FastMovingMedicineReport">Fast Moving Medicine Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/h1n_sheduled_x">H1N Sheduled-X Report</a></li>
                            </ul>
                    </li>

                     <li class="menu-item dropdown dropdown-submenu">
                        <a href="#">Invoice Reports</a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>index.php/reports/invoice_report">Invoice Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/invoice_return_report">Invoice Return Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/branchwise_report">Branchwise Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/invoice_return_itemwise">Invoice Return Itemwise Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/itemwise_report">Itemwise Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/credit_payment_report">Credit Payment Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/discount_report">Discount Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/cancelled_bill">Cancelled Report</a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/reports/doctor_medicine_report">Doctor Medicine Report</a></li>
                            </ul>                        
                      </li>

                     <li class="menu-item dropdown dropdown-submenu">
                        <a href="#">Purchase Reports</a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>index.php/reports/purchase_report">Purchase Report</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/reports/purchase_itemwise_report">Itemwise Report</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/reports/purchase_return">Purchase Return</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/reports/supplier_purchase_report">Supplier Purchase Report</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/reports/issue_cheque_report">Issue Cheque Report</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/reports/purchase_cancelled_report">Cancelled Report</a></li>
                          </ul>
                    </li>

                     <li class="menu-item dropdown dropdown-submenu">
                        <a href="#">Movement Reports</a>
                        <ul class="dropdown-menu">
                          <li><a href="<?php echo base_url(); ?>index.php/reports/movement_report">Movement Report</a></li>
                          <li><a href="<?php echo base_url(); ?>index.php/reports/movement_item_report">Movement Item Report</a></li>
                          <li><a href="<?php echo base_url(); ?>index.php/reports/cancelled_movement_reports">Cancelled Report</a></li>
                      </ul>
                    </li>
                    
                    <li class="menu-item ">
                      <a href="<?php echo base_url(); ?>index.php/reports/itemwise_sales_profit_report">Itemwise Sales Profit Report</a>
                       <!--  <ul class="dropdown-menu">
                        <li><a href="<?php// echo base_url(); ?>index.php/reports/profit_report">Sales Profit Report</a>
                        <li><a href="<?php// echo base_url(); ?>index.php/reports/itemwise_sales_profit_report">Itemwise Sales Profit Report</a>
                    </li>
                  </ul> -->
                </li>
                     
                  </ul>

        </li>

<?php } ?>

        </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
        
         <!--<li class="dropdown messages-menu">
               
                <a href="<?php echo base_path;?>index.php" >
                  <i><?php echo date('F d, Y h:i a') ?></i>
                  
                </a>
                
              </li>-->
                                  
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?php echo base_url(); ?>application/assets/dist/img/user.jpg" class="user-image" alt="User Image">
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php echo $this->session->userdata('username') ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <!--<li class="user-header">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <p>
                          <?php echo $this->session->userdata('username'); ?>
                         
                        </p>
                      </li>-->
                     
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo base_url(); ?>index.php/login/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
     </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>

      <input type="hidden" name="user_type_value" id="user_type_value" value="<?php echo $user_type; ?>" >
