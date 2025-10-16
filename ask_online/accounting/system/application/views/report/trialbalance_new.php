<script src="<?php echo base_url().'system/plugins/export/dist/jquery.table2excel.min.js' ?>"></script>

<style type="text/css">

	div#main-links{
		position: absolute;
		top: 135px;
		right: 84%;
	}
	.tooltip {
	    position: relative;
	    display: inline-block;
	}

	.tooltip .tooltiptext {
	    visibility: hidden;
	    width: 315px;
	    background-color: black;
	    color: #fff;
	    text-align: center;
	    border-radius: 6px;
	    padding: 15px 0;
	    position: absolute;
	    z-index: 1;
	    top: 150%;
	    left: 50%;
	    margin-left: -60px;
	}

	.tooltip .tooltiptext::after {
	    /*content: "";*/
	    position: absolute;
	    bottom: 100%;
	    left: 20%;
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: transparent transparent black transparent;
	}

	.tooltip:hover .tooltiptext {
	    visibility: visible;
	}
	span.tooltiptext {
	    margin-top: 80px !important;
	}	
	#export_id{
		border-radius: 3px 3px 3px 3px;
	    background: repeat-x scroll 0 0 transparent;
	    color: #FFFFFF;
	    font-size: 11px;
	    font-weight: bold;
	    padding: 4px 20px;
	    text-shadow: -1px -1px 0 #333333;
	    text-decoration: none;
 		background-image: url(<?php echo base_url().'system/application/assets/images/buttons/navlink.png' ?>);
	    position: absolute;
	    top: 132px;
	}

</style>

<?php
	
	$temp_dr_total = 0;
	$temp_cr_total = 0;
	$account_fy_start = $this->config->item('account_fy_start');
	$account_fy_end   = $this->config->item('account_fy_end');
	$account_fy_start = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_start)));
	$account_fy_end = date('Y-m-d', strtotime(str_replace('/', '-', $account_fy_end)));



	if (empty($print_preview)) {

		$search_from=$from_date['value'];
		$search_to=$to_date['value'];

	}
	else{

		$search_from=$from_date;
		$search_to=$to_date; 	


	}



		if (empty($show_search)) {

			$attr=array('id'=>'form');
			echo form_open('report/trialbalance_new',$attr);
			echo "<div style='display:flex;'>";
			echo "<div>";
			echo form_label('Start Date', 'from_date');
			echo " ";
			echo form_input_date_restrict($from_date);
			echo "<div class='tooltip'>";?>
			<img src="<?php echo asset_url(); ?>images/icons/info_icon.png" width="15" height="15" style="margin-left: 5px;">
			<?php
			echo "<span class='tooltiptext'>Note : Leave start date as empty if you want statement from the start of the financial year.</span>";
			echo "</div>";
			echo "</div>";
			echo "&nbsp;&nbsp;&nbsp;";
			echo "<div>";
			echo form_label('End Date', 'to_date');
			echo " ";	
			echo form_input_date_restrict($to_date);
			echo "<div class='tooltip'>";?>
			<img src="<?php echo asset_url(); ?>images/icons/info_icon.png" width="15" height="15" style="margin-left: 5px;">
			<?php
			echo "<span class='tooltiptext'>Note : Leave end date as empty if you want statement till the end of the financial year.</span>";
			echo "</div>";
			echo "</div>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
			echo "<div>";				
			echo form_submit($data=array('id'=>'submit','name'=>'submit','content'=>'show','value'=>'show'));
			echo "</div>";
			echo "</div>";
			echo "&nbsp;<a href='#' id='export_id' >Download</a>";
			echo form_close();

			if (!empty($submit_press)) {

				if (!empty($search_from) && !empty($search_to) ) {

					$search_from_display = date('M d Y', strtotime($search_from));
					$search_to_display = date('M d Y', strtotime($search_to));				
							
					echo "<div style='margin-top:7px;font-family: sans-serif;'>";
					echo "Start date : <b style='font-size:15px;color:#dd1136'>".$search_from_display."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
					echo "End date : <b style='font-size:15px;color:#dd1136'>".$search_to_display."</b>";
					echo "</div>";

				}
			}

		}


	$this->load->library('accountlist');
	echo "<table>";
	echo "<tr valign=\"top\">";
	$asset = new Accountlist();
	echo "<td>";
	$asset->init(0);
	echo "<table border=0 cellpadding=5 class=\"simple-table account-table table2excel\" style='margin-top:70px;'>";
	echo "<thead><tr><th>Account Name</th><th>Type</th><th>Debit</th><th>Credit</th></tr></thead>";
	$asset->account_st_main_new(-1);
	echo "</td>";
	echo "</tr>";

	$this->load->model('ledger_model');

	if (empty($print_preview)) {

		$dr_sum = $this->Ledger_model->get_dr_total_search_sum($from_date['value'],$to_date['value']); 

		$cr_sum = $this->Ledger_model->get_cr_total_search_sum($from_date['value'],$to_date['value']); 

	}
	else{

		$dr_sum = $this->Ledger_model->get_dr_total_search_sum($from_date,$to_date); 

		$cr_sum = $this->Ledger_model->get_cr_total_search_sum($from_date,$to_date); 	


	}



	echo "<tr><th style='font-weight:700;padding-top: 30px;'></th><th style='font-weight:700;padding-top: 30px;'>";
	if (float_ops($dr_sum, $cr_sum, '=='))
		echo "<img src=\"" . asset_url() . "images/icons/match.png\">";
	else
		echo "<img src=\"" . asset_url() . "images/icons/nomatch.png\">";
	echo "</th><th style='font-weight:700;padding-top: 30px;'>Dr " . convert_cur($dr_sum) . "</th><th style='font-weight:700;padding-top: 30px;'>Cr " . convert_cur($cr_sum) . "</th></tr>";

		$diff_dr = $dr_sum - $cr_sum;
		$diff_cr = $cr_sum - $dr_sum;


	echo "<tr><th style='font-weight:700;'></th><th style='font-weight:700;'>";

	echo "Difference</th><th style='font-weight:700;'>" . convert_cur($diff_dr) . "</th><th style='font-weight:700;'>" . convert_cur($diff_cr) . "</th></tr>";


	echo "</table>";

?>

<script type="text/javascript">
	

$(document).ready(function(){

  $("#export_id").click(function(){
   
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Trial_Balance.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});


  });
});


</script>