
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />
<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  
	  <link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<style type="text/css">
	html{
		height:100%;
	}
	body{
		background-color:#FFFFFF;
		
		width:100%;
		height:100%;		
		margin:0px;
		text-align:center;
	}
	.reallynow{
                 background-color: #F0F8FF;
	          }
	.center{
	         text-align: center;  
	         background-color: #F0F8FF;
	       }              
</style>


</head>
<body id="frame">
<?php
      $itemInfo=$this  ->popArr['itemInfo'];
	  $data=$this  ->popArr['data'];
?>
<div id="wrapper">
            <div id="contentSmallFrame">
			<div id="rightnow">
				
                	<div class="reallynow" width="70%" style="margin-left: 2%;margin-right: 28%">	
                	    <h4>ITEMWISE INVOICE REPORT</h4>			
						<table width="70%" style="margin-left: 2%;"">
							<tr>
							     <td id="noborder"> <?php echo $lang_from_date; ?>:<?php echo $data[0];?></td>
								<td id="noborder"> <?php echo $lang_to_date; ?>:<?php echo $data[1];?></td>
								<td id="noborder"> <?php echo $lang_brand; ?>:<?php echo $data[2];?></td>
																
							</tr>
						</table>                   
					
					</div>		
					
					
						<table width="70%" border="1" style="margin-left: 2%">
							<thead>
								<tr>
									<th  width="6%" class="center"><?php echo $lang_sl_no; ?></th>														
									<th width="15%" class="center"><?php echo $lang_bill_no; ?></th>
									<th width="15%" class="center"><?php echo $lang_date; ?></th>													
									<th width="15%" class="center"><?php echo $lang_batch; ?></th>
									<th width="15%" class="center"><?php echo $lang_expiry; ?></th>
									<th width="10%" class="center"><?php echo $lang_qty; ?></th>
									<th width="15%" class="center"><?php echo $lang_sellp; ?></th>
									<th width="15%" class="center"><?php echo $lang_total; ?></th>
																	
								</tr>
							</thead>
							<tbody>
							
							<?php
								$net_total=0;
								 $j=1;
								if(!empty($itemInfo)){						
										
									for($i=0;$i<count($itemInfo);$i++) {?>
											<tr>
												<td><?php echo $j++;?></td>
												<td><?php echo $itemInfo[$i][1];?></td>
												<td><?php echo $itemInfo[$i][2];?></td>
												<td><?php echo $itemInfo[$i][6];?></td>
												<td><?php echo $itemInfo[$i][7];?></td>
												<td><?php echo $itemInfo[$i][9]." ".$itemInfo[$i][8];?></td>	
												<td><?php echo $itemInfo[$i][10];?></td>
												<td><?php echo $itemInfo[$i][11];?></td>					
												
											</tr>
						<?php	
						
										$net_total=$net_total+$itemInfo[$i][11];
											
								}
							}
							
								?>
							<tr>
								<td colspan="7" align="right"><b>Total</b></td>
								<td><b><?php echo $net_total;?></b></td>
								
							</tr>
							
							</tbody>
						</table>
				
			</div>
		</div>
		
		
</div>
</body>
	</html>
	
