<div id="tag-sidebar">
	<?php $this->load->view('sidebar/tag', $tag_id); ?>
</div>


<style type="text/css">

	input.datepicker-restrict.hasDatepick {
	    width: 110px !important;
	}
	table.simple-table {
    margin-top: 25px;
	}
	div#main-links {
	    margin-top: 10px;
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

</style>

<?php


		$attr=array('id'=>'form');
		echo form_open('entry/show/'.$entry_type_page,$attr);
		echo "<div style='display:flex;' class='date_search'>";
		echo "<div>";
		echo form_label('Start Date', 'start_date');
		echo " ";
		echo form_input_date_restrict($start_date);
		echo "<div class='tooltip'>";?>
		<img src="<?php echo asset_url(); ?>images/icons/info_icon.png" width="15" height="15" style="margin-left: 5px;">
		<?php
		echo "<span class='tooltiptext'>Note : Leave start date as empty if you want statement from the start of the financial year.</span>";
		echo "</div>";
		echo "</div>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<div>";
		echo form_label('End Date', 'end_date');
		echo " ";	
		echo form_input_date_restrict($end_date);
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
		echo form_close();

			if (!empty($submit_press)) {

					if (!empty($start_date['value']) && !empty($end_date['value']) ) {

						$search_from_display = date('M d Y', strtotime($start_date['value']));
						$search_to_display = date('M d Y', strtotime($end_date['value']));				
						
						echo "<div style='margin-top:20px;font-family: sans-serif;'>";
						echo "Start date : <b style='font-size:15px;color:#dd1136'>".$search_from_display."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
						echo "End date : <b style='font-size:15px;color:#dd1136'>".$search_to_display."</b>";
						echo "</div>";

					}
			}		





 ?>

<table border=0 cellpadding=5 class="simple-table">
	<thead>
		<tr>
			<th>Date</th>
			<th>No</th>
			<th>Ledger Account</th>
			<th>Type</th>
			<th>DR Amount</th>
			<th>CR Amount</th>
			<th>Entry By</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($entry_data->result() as $row)
		{
			$current_entry_type = entry_type_info($row->entry_type);
			echo "<tr>";

			echo "<td>" . date_mysql_to_php_display($row->date) . "</td>";
			echo "<td>" . anchor('entry/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";

			echo "<td>";
			echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
			echo "</td>";

			echo "<td>" . $current_entry_type['name'] . "</td>";
			echo "<td>" . $row->dr_total . "</td>";
			echo "<td>" . $row->cr_total . "</td>";

			echo "<td>";
			echo $this->Tag_model->show_entry_tag($row->tag_id);
			echo "</td>";


			if ($row->tag_id!=1) {
				
				echo "<td>" . anchor('entry/edit/' . $current_entry_type['label'] . "/" . $row->id , "Edit", array('title' => 'Edit ' . $current_entry_type['name'] . ' Entry', 'class' => 'red-link')) . " ";
				echo " &nbsp;" . anchor('entry/delete/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Delete ' . $current_entry_type['name'] . ' Entry', 'class' => "confirmClick", 'title' => "Delete entry")), array('title' => 'Delete  ' . $current_entry_type['name'] . ' Entry')) . " ";
				echo " &nbsp;" . anchor_popup('entry/printpreview/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Print ' . $current_entry_type['name']. ' Entry', 'width' => '600', 'height' => '600')) . " ";
				echo " &nbsp;" . anchor_popup('entry/email/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/email.png", 'border' => '0', 'alt' => 'Email ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Email ' . $current_entry_type['name'] . ' Entry', 'width' => '500', 'height' => '300')) . " ";
				echo " &nbsp;" . anchor('entry/download/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/save.png", 'border' => '0', 'alt' => 'Download ' . $current_entry_type['name'] . ' Entry', 'title' => "Download entry")), array('title' => 'Download  ' . $current_entry_type['name'] . ' Entry')) . "</td>";



			}
			else{


				echo "<td>" . anchor_popup('entry/printpreview/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Print ' . $current_entry_type['name']. ' Entry', 'width' => '600', 'height' => '600')) . " ";
				echo " &nbsp;" . anchor_popup('entry/email/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/email.png", 'border' => '0', 'alt' => 'Email ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Email ' . $current_entry_type['name'] . ' Entry', 'width' => '500', 'height' => '300')) . " ";
				echo " &nbsp;" . anchor('entry/download/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/save.png", 'border' => '0', 'alt' => 'Download ' . $current_entry_type['name'] . ' Entry', 'title' => "Download entry")), array('title' => 'Download  ' . $current_entry_type['name'] . ' Entry')) . "</td>";







			}




			echo "</tr>";
		}
	?>
	</tbody>
</table>

<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>


<script type="text/javascript">
$('form').submit(function(){
    $('#form').submit();
    return false;
});

if ($('div#main-links').length > 0) {
	   $('.date_search').css('margin-top', '20px');    
}

</script>