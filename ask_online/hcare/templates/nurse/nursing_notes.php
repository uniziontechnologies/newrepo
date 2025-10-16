<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" type="text/css" href="../../css/theme.css" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<script type="text/javascript" src="../../js/common_functions.js">  </script>
<script type="text/javascript" src="../../js/mootools.v1.11.js"></script>


<script type="text/javascript" src="../../js/jquery-1.2.6.min.js"></script>
<link href="../../css/dp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/dateValidation.js"></script>
<script src="../../js/datepicker_lang_US.js" type="text/javascript"></script>
    <script src="../../js/jquery.datepicker.js" type="text/javascript"></script>
<script>
	
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
  
   document.writeln('<link rel="stylesheet" type="text/css" href="../../css/' + StyleFile + '">');
</script>
<script type="text/javascript">

// The following should be put in your external js file,
// with the rest of your ondomready actions.
window.addEvent('domready', function(){

	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});

});

$(document).ready(function(){
 
  $(".date_cal").datepicker({ picker: "<img class='picker' align='middle' src='../../img/cal.gif' alt=''/>" });


 	$(".add").bind('click', function() {
		
                       if($("#nursing_notes").val() == ""){

                      }else {
			
                        
			$("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=add_nursing_notes");
			$("#form").submit();
                     }
		});

       $(".delete").bind('click', function() {

           $("#id").val($(this).attr("id"));

            var a=confirm("Do u want to Delete Doctor Visit Added to Selected patient!");
		
  		 if(a==true)
   			{
			
                      var details=prompt("Please Enter cancellation Details:","");
				
				if(details!= null){
                                       $("#del_details").val(details);
                                       $("#form").attr("action","../../lib/controllers/centralController.php?module=Nurse&sub_module=delete_nursing_notes");
			               $("#form").submit();
                                }
                }

     });
 });
</script>
</head>
<body id="frame">

<?php


$nurNotes=$this  ->popArr['nurNotes'];
?>
<form name="nurNotes" id="form"  method="post" action="">
<div id="wrapper">
            <div id="content">
			<div id="box">
                	
					<h3> <?php echo $lang_add." ".$lang_nursing_notes; ?></h3>

                                           <div align="center">
                                          <br>

                                            <table width="80%" style="font-weight:bold">

                                               <tr>
                                                  <td id="noborder"><?php echo $lang_ip_no; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['patient_selected'];?>"></td>
                                                   <td id="noborder"><?php echo $lang_name; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['patient_name'];?>"></td>
                                                    <td id="noborder"><?php echo $lang_age; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['age'];?>"></td>
                                              </tr>
                                              <tr>
                                                   <td id="noborder"><?php echo $lang_gender; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['gender'];?>"></td>
                                            
                                                   <td id="noborder"><?php echo $lang_room; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['room_no'];?> (BED NO:<?php echo $_SESSION['bed_no'];?>)"></td>
                                                   <td id="noborder"><?php echo $lang_doctor; ?>:&nbsp;</td><td id="noborder"><input type="text" value="<?php echo $_SESSION['doctor'];?>"></td>
                                               </tr>
                                           </table>

                                             <br><br>


                                                     <table width="20%">
							<tr>
								<td id="noborder"><?php echo $lang_date; ?>:</td>
								<td id="noborder" >	
									<input type="text" name="date" id="date"  class="date_cal" value="<?php echo (!empty($post['from_date']))?$post['from_date']:date('d-m-Y');?>" readonly="true"/>
								</td>
                                                       </tr>

                                                       <tr>
								<td id="noborder"><?php echo $lang_nursing_notes; ?></td>
								<td id="noborder" >	
								 <textarea col="4" rows="5" name="nursing_notes" id="nursing_notes"></textarea>
											
								</td>

                                                       </tr>
                                                       
                                                       <tr>
                                                             <td id="noborder">
									&nbsp;&nbsp;
								<input id="button1" type="button" name="add" class="add" value="ADD" /></td>
								</tr>
                                                    </table>
                                       </div>
                                       <div id="rightnow">
                	               <h3 class="reallynow">
						<?php echo $lang_ip." ".$lang_nursing_notes." ".$list; ?></h3>

					<?php if(isset($this->popArr['message'])){?>
						<div id='message'><?php echo $this->popArr['message'];?></div>
					<?php } ?>
					<br />

			                <div align="center">
			               <table width="55%">
				          <thead>
					     <tr>
                                                 <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>                            	              
                                                 <th><a href="#"><?php echo $lang_nursing_notes; ?></a></th> 
						 <th><a href="#"><?php echo $lang_date; ?></a></th> 						
                                                 <th><a href="#"><?php echo $lang_user; ?></a></th>   
						 <th><a href="#"><?php echo $lang_action; ?></a></th>                                
                                
                            </tr>
						</thead>
						<tbody>	
		<?php
			if(!empty($nurNotes)){
                               $j=1;
				for($i=0;$i<count($nurNotes);$i++) {?>
					<tr>
                                                <td><?php echo $j++;?></td>
						<td><?php echo $nurNotes[$i][1];?></td>
						<td><?php echo $nurNotes[$i][2];?></td>						
						<td><?php echo $nurNotes[$i][5];?></td>
                                               
										
						
						<td>
							
							<a href="#" id="<?php echo $nurNotes[$i][0];?>" class="delete"><img src="../../img/icons/user_delete.png" title="Delete user" width="16" height="16" /></a>
						</td>
                           
					</tr>
						
				
		<?php	}
			
			}		
		?>
					</tbody>
				</table>
			</div>
                        </div>
              </div>
 </div>
<input type="hidden" name="del_details" id="del_details">
<input type="hidden" name="id" id="id">
</form>
</body>
</html>
