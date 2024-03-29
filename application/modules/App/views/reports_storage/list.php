<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-archive"></span> Manage Reports Storage</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/reports_storage');?>" title="Coordinator"><span class="fa fa-archive" ></span> Reports Storage</a></li>
				<li><a href="<?php echo base_url('app/reports_storage/add');?>" title="Add Reports"><span class="glyphicon glyphicon-plus-sign"></span> Add Reports</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Reports Storage Management</li>
	</ol>

	<?php
		if($this->session->flashdata('message_type')) {
			if($this->session->flashdata('message')) {
				echo '<div class="alert alert-'.$this->session->flashdata('message_type').' alert-dismissable">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo $this->session->flashdata('message');
				echo '</div>';
			}
		}
	?>

	<?php
	
		echo validation_errors();

		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/reports_storage/update_status'), $attributes);
	?>

	<div class="table-responsive">
	
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Title</th>
					<th>Report File</th>
					<th><?php echo sorting_html($filter, 'Created Date', 'created_on'); ?></th>
					<th>Action</th>
	        </tr>
	        </thead>
	        <tbody>
	            <?php
	            //echo "<pre>";print_r($list);die;
	             if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $reports) { ?>
	            <tr>
	            	<td><input type="checkbox" name="item_id[<?php echo $reports->id ;?>]" class="checkbox-item" value="Y"></td>
								<td><?php echo ucfirst($reports->title); ?></td>
								<td><?php echo $reports->file;?> <p><?php if(isset($reports->file) && $reports->file != '') {echo anchor(base_url(DIR_REPORT_FILES.$reports->file),"Show PDF", array("target"=>"_blank"));}?></p> </td>
								<td><?php echo date_display($reports->created_on); ?></td>
								
								<td class="text-nowrap">
									<?php echo render_action(array('delete'), $reports->id);?>
									 <input type='hidden' id='sort' value='asc'>
								</td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						<?php echo render_buttons(array('delete'));?>
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php //echo $this->pagination->create_links(); ?>
</div>

<?php
	function format_date($str) {
		$str = urldecode($str);
		return str_replace('~', '/', $str);
	}
?>


<?php
	function sorting_html($filter, $label, $field) {
//echo "<pre>";print_r($filter);die;
		$output = "";
		if ($filter['s_by'] == $field) {
			if ($filter['s_dir'] == 'ASC') {
				$output .= '<a href="'. base_url('app/reports_storage/index/s_by/'.$field.'/s_dir/DESC').'" style="color: #ffffff;">'.$label." <span class='glyphicon glyphicon-sort-by-attributes-alt'></span>";
			} else {
				$output .= '<a href="'. base_url('app/reports_storage/index/s_by/'.$field.'/s_dir/ASC').'" style="color: #ffffff;">'.$label." <span class='glyphicon glyphicon-sort-by-attributes'></span>";
			}
		} else {
			$output .= "<a href='". base_url('app/reports_storage/index/s_by/'.$field.'/s_dir/ASC')."'>".$label."</a>";
		}
		return $output;
	}
?>