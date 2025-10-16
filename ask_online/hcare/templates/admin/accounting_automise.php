<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>


<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<link rel="stylesheet" type="text/css" href="../../dist/css/ajax.css" />

 <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script> 
  

<script>

$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
     
   function lock_data(type){

   		if (type=="OP") {

   			var op_ledger_cr = $("#op_ledger_cr").val();
   			var op_ledger_dr = $("#op_ledger_dr").val();

   			if (op_ledger_cr=="") {
   				alert("Please select OP CR ledger");
   				return false;
   			}
   			else if (op_ledger_dr=="") {
   				alert("Please select OP DR ledger");
   				return false;
   			}
   			else{

				var a = confirm("Are you sure?");

				if (a==true) {

					document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_op_data";
					document.daily_collection.submit();

				}
				else{
					return false;
				}

   			}

   		}
   		else if (type=="LAB") {

   			var lab_ledger_cr = $("#lab_ledger_cr").val();
   			var lab_ledger_dr = $("#lab_ledger_dr").val();

   			if (lab_ledger_cr=="") {
   				alert("Please select LAB CR ledger");
   				return false;
   			}
   			else if (lab_ledger_dr=="") {
   				alert("Please select LAB DR ledger");
   				return false;
   			}
   			else{

				var a = confirm("Are you sure?");

				if (a==true) {

					document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_lab_data";
					document.daily_collection.submit();

				}
				else{
					return false;
				}

   			}

   		}
   		else if (type=="XRAY") {

   			var xray_ledger_cr = $("#xray_ledger_cr").val();
   			var xray_ledger_dr = $("#xray_ledger_dr").val();

   			if (xray_ledger_cr=="") {
   				alert("Please select XRAY CR ledger");
   				return false;
   			}
   			else if (xray_ledger_dr=="") {
   				alert("Please select XRAY DR ledger");
   				return false;
   			}
   			else{

				var a = confirm("Are you sure?");

				if (a==true) {

					document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_xray_data";
					document.daily_collection.submit();

				}
				else{
					return false;
				}

   			}

   		}
         else if (type=="PROCEDURE") {

            var procedure_ledger_cr = $("#procedure_ledger_cr").val();
            var procedure_ledger_dr = $("#procedure_ledger_dr").val();

            if (procedure_ledger_cr=="") {
               alert("Please select PROCEDURE CR ledger");
               return false;
            }
            else if (procedure_ledger_dr=="") {
               alert("Please select PROCEDURE DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_procedure_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="IP") {

            var ip_ledger_cr = $("#ip_ledger_cr").val();
            var ip_ledger_dr = $("#ip_ledger_dr").val();

            if (ip_ledger_cr=="") {
               alert("Please select IP CR ledger");
               return false;
            }
            else if (ip_ledger_dr=="") {
               alert("Please select IP DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_ip_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }

         else if (type=="THEATER") {

            var theater_ledger_cr = $("#theater_ledger_cr").val();
            var theater_ledger_dr = $("#theater_ledger_dr").val();

            if (theater_ledger_cr=="") {
               alert("Please select THEATER CR ledger");
               return false;
            }
            else if (theater_ledger_dr=="") {
               alert("Please select THEATER DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_theater_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="OP_DR_PAYMENTS") {

            var op_dr_payments_cr = $("#op_dr_payments_cr").val();
            var op_dr_payments_dr = $("#op_dr_payments_dr").val();

            if (op_dr_payments_cr=="") {
               alert("Please select OP DR PAYMENTS CR ledger");
               return false;
            }
            else if (op_dr_payments_dr=="") {
               alert("Please select OP DR PAYMENTS DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_op_dr_payments_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="LAB_CREDIT") {

            var lab_credit_ledger_dr = $("#lab_credit_ledger_dr").val();
            var lab_credit_ledger_dr = $("#lab_credit_ledger_dr").val();

            if (lab_credit_ledger_dr=="") {
               alert("Please select LAB CREDIT CR ledger");
               return false;
            }
            else if (lab_credit_ledger_dr=="") {
               alert("Please select LAB CREDIT DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_lab_credit_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="XRAY_CREDIT") {

            var xray_credit_ledger_cr = $("#xray_credit_ledger_cr").val();
            var xray_credit_ledger_dr = $("#xray_credit_ledger_dr").val();

            if (xray_credit_ledger_cr=="") {
               alert("Please select XRAY CREDIT CR ledger");
               return false;
            }
            else if (xray_credit_ledger_dr=="") {
               alert("Please select XRAY CREDIT DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_xray_credit_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="PROCEDURE_CREDIT") {

            var procedure_credit_ledger_cr = $("#procedure_credit_ledger_cr").val();
            var procedure_credit_ledger_dr = $("#procedure_credit_ledger_dr").val();

            if (procedure_credit_ledger_cr=="") {
               alert("Please select PROCEDURE CREDIT CR ledger");
               return false;
            }
            else if (procedure_credit_ledger_dr=="") {
               alert("Please select PROCEDURE CREDIT DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_procedure_credit_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="THEATER_CREDIT") {

            var theater_credit_ledger_cr = $("#theater_credit_ledger_cr").val();
            var theater_credit_ledger_dr = $("#theater_credit_ledger_dr").val();

            if (theater_credit_ledger_cr=="") {
               alert("Please select THEATER CREDIT CR ledger");
               return false;
            }
            else if (theater_credit_ledger_dr=="") {
               alert("Please select THEATER CREDIT DR ledger");
               return false;
            }
            else{

            var a = confirm("Are you sure?");

            if (a==true) {

               document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_theater_credit_data";
               document.daily_collection.submit();

            }
            else{
               return false;
            }

            }

         }
         else if (type=="IP_ADVANCE") {

               var ip_advance_ledger_cr = $("#ip_advance_ledger_cr").val();
               var ip_advance_ledger_dr = $("#ip_advance_ledger_dr").val();

               if (ip_advance_ledger_cr=="") {
                  alert("Please select IP ADVANCE CR ledger");
                  return false;
               }
               else if (ip_advance_ledger_dr=="") {
                  alert("Please select IP ADVANCE DR ledger");
                  return false;
               }
               else{

               var a = confirm("Are you sure?");

               if (a==true) {

                  document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_ip_advance_data";
                  document.daily_collection.submit();

               }
               else{
                  return false;
               }

               }

            }



		
   }





   
</script>
<style type="text/css">

</style>
</head>
<body id="frame">
<form name="daily_collection" id="daily_collection"  method="post" action=""> 
<?php
	
	$ledgers = $this->popArr['ledgers'];
	$message = $this->popArr['message'];
	$post = $this->popArr['post'];
	$accounting_details = $this->popArr['accounting_details'];


?>
 <section class="content">
					 

			
			<h3>ACCOUNTING AUTOMISE - DAILY COLLECTION</h3>
					<?php if(isset($message)){?>
						<div id='message' class="callout callout-success"><?php echo $message;?></div>
					<?php } ?>

				<br>



			
        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "OP COLLECTION";?></h6>
            </div>	

            <table class="table table-striped">
            	
            	<thead>
            		<th>CR</th>
            		<th>DR</th>
            		<th>ACTION</th>
            	</thead>

            	<tbody>

            		<td>

            			<select id="op_ledger_cr" name="op_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[0][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][2]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>

            			<select id="op_ledger_dr" name="op_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[0][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][3]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>
            			

            			<input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('OP');" <?php if (!empty($accounting_details) && $accounting_details[0][7]==1 ) {
            				echo "disabled";
            			} ?> >


            		</td>




            	</tbody>

            </table>	
					

        </div>








        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "LAB COLLECTION";?></h6>
            </div>	

            <table class="table table-striped">
            	
            	<thead>
            		<th>CR</th>
            		<th>DR</th>
            		<th>ACTION</th>
            	</thead>

            	<tbody>

            		<td>

            			<select id="lab_ledger_cr" name="lab_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[1][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[1][2]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>

            			<select id="lab_ledger_dr" name="lab_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[1][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[1][3]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>
            			

            			<input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('LAB');" <?php if (!empty($accounting_details) && $accounting_details[1][7]==1 ) {
            				echo "disabled";
            			} ?> >


            		</td>




            	</tbody>

            </table>	
					

        </div>

			
        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "X-RAY COLLECTION";?></h6>
            </div>	

            <table class="table table-striped">
            	
            	<thead>
            		<th>CR</th>
            		<th>DR</th>
            		<th>ACTION</th>
            	</thead>

            	<tbody>

            		<td>

            			<select id="xray_ledger_cr" name="xray_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[2][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[2][2]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>

            			<select id="xray_ledger_dr" name="xray_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[2][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[2][3]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>
            			

            			<input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('XRAY');" <?php if (!empty($accounting_details) && $accounting_details[2][7]==1 ) {
            				echo "disabled";
            			} ?> >


            		</td>




            	</tbody>

            </table>	
					

        </div>







        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "PROCEDURE COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="procedure_ledger_cr" name="procedure_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[3][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[3][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="procedure_ledger_dr" name="procedure_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[3][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[3][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('PROCEDURE');" <?php if (!empty($accounting_details) && $accounting_details[3][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>



        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "IP COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="ip_ledger_cr" name="ip_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[4][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[4][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="ip_ledger_dr" name="ip_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[4][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[4][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('IP');" <?php if (!empty($accounting_details) && $accounting_details[4][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>


        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "THEATER COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="theater_ledger_cr" name="theater_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[5][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[5][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="theater_ledger_dr" name="theater_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[5][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[5][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('THEATER');" <?php if (!empty($accounting_details) && $accounting_details[5][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>


<!-- 
        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "NURSE COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="nurse_ledger_cr" name="nurse_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[11][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="nurse_ledger_dr" name="nurse_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[11][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('NURSE');" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div> -->


        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "OP DOCTOR PAYMENTS COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="op_dr_payments_cr" name="op_dr_payments_cr" <?php if (!empty($accounting_details) && $accounting_details[6][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[6][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="op_dr_payments_dr" name="op_dr_payments_dr" <?php if (!empty($accounting_details) && $accounting_details[6][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[6][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('OP_DR_PAYMENTS');" <?php if (!empty($accounting_details) && $accounting_details[6][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>

 

        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "LAB CREDIT COLLECTION";?></h6>
            </div>	

            <table class="table table-striped">
            	
            	<thead>
            		<th>CR</th>
            		<th>DR</th>
            		<th>ACTION</th>
            	</thead>

            	<tbody>

            		<td>

            			<select id="lab_credit_ledger_cr" name="lab_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[7][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[7][2]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>

            			<select id="lab_credit_ledger_dr" name="lab_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[7][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[7][3]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>
            			

            			<input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('LAB_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[7][7]==1 ) {
            				echo "disabled";
            			} ?> >


            		</td>




            	</tbody>

            </table>	
					

        </div>


				
       <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "X-RAY CREDIT COLLECTION";?></h6>
            </div>	

            <table class="table table-striped">
            	
            	<thead>
            		<th>CR</th>
            		<th>DR</th>
            		<th>ACTION</th>
            	</thead>

            	<tbody>

            		<td>

            			<select id="xray_credit_ledger_cr" name="xray_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[8][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[8][2]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>

            			<select id="xray_credit_ledger_dr" name="xray_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[8][7]==1 ) {
            				echo "disabled";
            			} ?> >
            				<option value="">----- Please Select -----</option>
            			
            			
            			<?php

            				if (!empty($ledgers)) {
            					
            					for ($i=0; $i <count($ledgers) ; $i++) { ?>

            						<option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[8][3]==$ledgers[$i][0] ) {
            							echo "selected";
            						} ?> ><?php echo $ledgers[$i][2]; ?></option>

            					<?php
            					}


            				}

            			?>

            			</select>

            		</td>


            		<td>
            			

            			<input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('XRAY_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[8][7]==1 ) {
            				echo "disabled";
            			} ?> >


            		</td>




            	</tbody>

            </table>	
					

        </div>	
 

 
        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "PROCEDURE CREDIT COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="procedure_credit_ledger_cr" name="procedure_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[9][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[9][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="procedure_credit_ledger_dr" name="procedure_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[9][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[9][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('PROCEDURE_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[9][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>

        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "THEATER CREDIT COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="theater_credit_ledger_cr" name="theater_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[10][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="theater_credit_ledger_dr" name="theater_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[10][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('THEATER_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>



        <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "IP ADVANCE PAYMENTS";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="ip_advance_ledger_cr" name="ip_advance_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[11][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="ip_advance_ledger_dr" name="ip_advance_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[11][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('IP_ADVANCE');" <?php if (!empty($accounting_details) && $accounting_details[11][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div>



  <!--       <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "SUPER NURSE CREDIT COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="super_nurse_credit_ledger_cr" name="super_nurse_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[10][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="super_nurse_credit_ledger_dr" name="super_nurse_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[10][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('SUPER_NURSE_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[10][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div> -->


   <!--      <div class="box box-info">

            <div class="box-header with-border">
                <h6 class="box-title"><?php echo "NURSE CREDIT COLLECTION";?></h6>
            </div>   

            <table class="table table-striped">
               
               <thead>
                  <th>CR</th>
                  <th>DR</th>
                  <th>ACTION</th>
               </thead>

               <tbody>

                  <td>

                     <select id="nurse_credit_ledger_cr" name="nurse_credit_ledger_cr" <?php if (!empty($accounting_details) && $accounting_details[12][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[12][2]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>

                     <select id="nurse_credit_ledger_dr" name="nurse_credit_ledger_dr" <?php if (!empty($accounting_details) && $accounting_details[12][7]==1 ) {
                        echo "disabled";
                     } ?> >
                        <option value="">----- Please Select -----</option>
                     
                     
                     <?php

                        if (!empty($ledgers)) {
                           
                           for ($i=0; $i <count($ledgers) ; $i++) { ?>

                              <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[12][3]==$ledgers[$i][0] ) {
                                 echo "selected";
                              } ?> ><?php echo $ledgers[$i][2]; ?></option>

                           <?php
                           }


                        }

                     ?>

                     </select>

                  </td>


                  <td>
                     

                     <input type="button" class="btn btn-primary btn-md" value="LOCK" onclick="lock_data('NURSE_CREDIT');" <?php if (!empty($accounting_details) && $accounting_details[12][7]==1 ) {
                        echo "disabled";
                     } ?> >


                  </td>




               </tbody>

            </table> 
               

        </div> -->

				
            
           


</form>	  

</body>
	</html>
	
