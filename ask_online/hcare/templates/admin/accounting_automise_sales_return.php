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
    // Disable cut copy paste
    // $('body').bind('cut copy paste', function (e) {
    //     e.preventDefault();
    // });
   
    // //Disable mouse right click
    // $("body").on("contextmenu",function(e){
    //     return false;
    // });
});
     
   function lock_data(){


   	    var pharma_return_ledger = $("#pharma_return_ledger").val();
   	    var cgst_5        = $("#cgst_5").val();
        var sgst_5        = $("#sgst_5").val();
        var cgst_12       = $("#cgst_12").val();
        var sgst_12       = $("#sgst_12").val();
        var cgst_18       = $("#cgst_18").val();
        var sgst_18       = $("#sgst_18").val();
        var cgst_28       = $("#cgst_28").val();
        var sgst_28       = $("#sgst_28").val();
        var round_off     = $("#round_off").val();
        var cash_in_hand  = $("#cash_in_hand").val();
        var discount      = $("#discount").val();

      if (cash_in_hand=="") {
        alert("Please select Cash In Hand ledger");
        return false;
      }
      else if (discount=="") {
        alert("Please select Discount ledger");
        return false;
      }
   	  else if (pharma_return_ledger=="") {
   		   alert("Please select Pharmacy Return Collection ledger");
   			return false;
   	  }
   	  else if (cgst_5=="") {
   			alert("Please select 5% Cgst ledger");
   			return false;
   	  }
        else if (sgst_5=="") {
            alert("Please select 5% Sgst ledger");
            return false;
        }
        else if (cgst_12=="") {
            alert("Please select 12% Cgst ledger");
            return false;
        }
        else if (sgst_12=="") {
            alert("Please select 12% Sgst ledger");
            return false;
        }
        else if (cgst_18=="") {
            alert("Please select 18% Cgst ledger");
            return false;
        }
        else if (sgst_18=="") {
            alert("Please select 18% Sgst ledger");
            return false;
        }
        else if (cgst_28=="") {
            alert("Please select 28% Cgst ledger");
            return false;
        }
        else if (sgst_28=="") {
            alert("Please select 28% Sgst ledger");
            return false;
        }
        else if (round_off=="") {
            alert("Please select Round Off ledger");
            return false;
        }
   	  else{

				var a = confirm("Are you sure?");

				if (a==true) {

					document.daily_collection.action="../../lib/controllers/centralController.php?module=Admin&sub_module=lock_pharmacy_sales_return_data";
					document.daily_collection.submit();

				}
				else{
					return false;
				}

   	  }

   		
   		



		
   }





   
</script>
<style type="text/css">
.ledgers {
    text-align: center;
}
.ledgers h6{
   font-size: 15px !important;
   margin-bottom: 20px !important;
   font-weight: 600;
}
span {
    font-size: 15px;
    font-weight: 400;
}
.margin_15{
   margin-bottom: 15px;
}
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
					 

			
			<h3>ACCOUNTING AUTOMISE - PHARMACY SALES RETURN COLLECTION</h3>
					<?php if(isset($message)){?>
						<div id='message' class="callout callout-success"><?php echo $message;?></div>
					<?php } ?>

				<br>



			
      <div class="box box-info" style="padding-bottom: 25px;">


         <div class="row">
            
            <div class="col-md-6 ledgers">
               
               <div class="box-header with-border">
                   <h6 class="box-title"><?php echo "CR LEDGERS";?></h6>
               </div>   

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>Cash In Hand</span><br>

                        <select id="cash_in_hand" name="cash_in_hand" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][12]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>


               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>Discount Given</span><br>

                        <select id="discount" name="discount" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][13]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>




            </div>

            <div class="col-md-6 ledgers">
               
               <div class="box-header with-border">
                   <h6 class="box-title"><?php echo "DR LEDGERS";?></h6>
               </div>   


               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>Pharmacy Return Collection</span><br>

                        <select id="pharma_return_ledger" name="pharma_return_ledger" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
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


                  </div>

               </div>


               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>5% cgst</span><br>

                        <select id="cgst_5" name="cgst_5" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
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


                  </div>

               </div>


               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>5% sgst</span><br>

                        <select id="sgst_5" name="sgst_5" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][4]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>12% cgst</span><br>

                        <select id="cgst_12" name="cgst_12" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][5]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>12% sgst</span><br>

                        <select id="sgst_12" name="sgst_12" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][6]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>18% cgst</span><br>

                        <select id="cgst_18" name="cgst_18" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][7]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>18% sgst</span><br>

                        <select id="sgst_18" name="sgst_18" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][8]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>28% cgst</span><br>

                        <select id="cgst_28" name="cgst_28" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][9]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>28% sgst</span><br>

                        <select id="sgst_28" name="sgst_28" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][10]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>



               <div class="row margin_15">
                  
                  <div class="col-md-12">
                     
                        <span>Round Off</span><br>

                        <select id="round_off" name="round_off" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                           echo "disabled";
                        } ?> >
                           <option value="">----- Please Select -----</option>
                        
                        
                        <?php

                           if (!empty($ledgers)) {
                              
                              for ($i=0; $i <count($ledgers) ; $i++) { ?>

                                 <option value="<?php echo $ledgers[$i][0]; ?>" <?php if (!empty($accounting_details) && $accounting_details[0][11]==$ledgers[$i][0] ) {
                                    echo "selected";
                                 } ?> ><?php echo $ledgers[$i][2]; ?></option>

                              <?php
                              }


                           }

                        ?>

                        </select>


                  </div>

               </div>

            </div>


         </div>


         <div class="row" style="margin-top: 30px;">
            
            <div class="col-md-offset-4 col-md-3">
               
               <input type="button" name="save" value="Lock" id="save" class="btn btn-block btn-primary" onclick="lock_data();" <?php if (!empty($accounting_details) && $accounting_details[0][17]==1 ) {
                        echo "disabled";
                     } ?> >

            </div>

         </div>

					

      </div>







           


</form>	  

</body>
	</html>
	
