<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-gg-circle"></span> Manage Goals</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/goals');?>" title="Goals"><span class="fa fa-gg-circle" ></span> Goals</a></li>
				<li><a href="<?php echo base_url('app/goals/add');?>" title="Add Goal"><span class="glyphicon glyphicon-plus-sign"></span> Add New Goal</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Goals Management</li>
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
	//echo "<pre>";print_r($list);die;
		echo validation_errors();

		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/goals/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Title</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Action</th>
	        </tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $goal) { ?>
	            <tr>
	            	<td><input type="checkbox" name="item_id[<?php echo $goal['id'];?>]" class="checkbox-item" value="Y"></td>
								<td><?php echo ucfirst($goal['title']);?></td>
								<td><?php echo date_display($goal['start_date']); ?></td>
								<td><?php echo date_display($goal['end_date']); ?></td>
								<td><?php echo price_display($goal['amount']); ?></td>
								
								
								<td><?php echo status_display($goal['status']);?></td>
								<td class="text-nowrap">
									<?php echo render_action(array('edit', 'delete'), $goal['id']);?>
									<br />
								</td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						<?php echo render_buttons(array('update_status', 'delete'));?>
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

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.openPopup').on('click', function(){
			jQuery('#pId').val(jQuery(this).attr('data-id'));
			var action_url = base_url+"app/presenters/upload_header/"+jQuery(this).attr('data-id');
			jQuery('#headerImgFrm').attr('action', action_url);
			jQuery('#headerModal').modal('show');
		});
	});
</script>
