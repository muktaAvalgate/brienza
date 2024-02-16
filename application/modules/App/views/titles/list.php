<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-education"></span> Titles</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-education"></span> Titles');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Title');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Titles</li>
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

		$attributes = array('class' => 'form-inline status-form', 'id' => 'locations-status-form');
		echo form_open(base_url('app/titles/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Name</th>
					<th>Grades and Teachers</th>
					<th>Created</th>
					<th>Updated</th>
	          		<th>Status</th>
					<th>Action</th>
	          	</tr>
	        </thead>
	        <tbody>
				<?php //print "<pre>"; print_r($list); print "</pre>";	?>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $item) { ?>
	            <tr>
					<td><input type="checkbox" name="item_id[<?php echo $item->id;?>]" class="checkbox-item" value="Y"></td>
					<td><?php echo $item->name;?></td>
					<td><?php echo ($item->grade_teachers?"Required":"Not Required");?></td>
					<td><small>On <?php echo datetime_display($item->created_on);?> By <?php echo $item->created_by_name;?></small></td>
					<td><small><?php if($item->updated_on) {?>On <?php echo datetime_display($item->updated_on);?> By <?php echo $item->updated_by_name;?><?php }?></small></td>
	            	<td><?php echo status_display($item->status);?></td>
	            	<td width="15%">
						<?php
							echo render_action(array('edit', 'delete'), $item->id);
						?>
						<!-- <a href="<?php echo site_url('app/titles/add_log_templates/'.$item->id);?>" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Add Log Templates</a> -->

						<a onclick="add_log_template(<?php echo $item->id;?>)" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Add Log Templates</a>
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

<script>
	function add_log_template(title_id){
		jQuery.ajax({
			url: '<?php echo base_url('app/titles/title_topic_check/');?>',
			
			data: {title_id:title_id},
			type: 'post',
			// ajaxCall:true,
			async: false,
			success: function (response) {
				// alert(response);
				if (response == false){
					alert('Oops!  This title has no topics for adding a template.');
				}else{
					// $('.view_message').val(response);
					window.location.href=base_url+'app/titles/add_log_templates/'+title_id;
				}
			}
		});
	}
</script>