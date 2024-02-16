<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-bookmark"></span> Programs</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span> Programs');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Program');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Programs</li>
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
		echo form_open(base_url('app/programs/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Name</th>
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
					<td><small>On <?php echo datetime_display($item->created_on);?> By <?php echo $item->created_by_name;?></small></td>
					<td><small><?php if($item->updated_on) {?>On <?php echo datetime_display($item->updated_on);?> By <?php echo $item->updated_by_name;?><?php }?></small></td>
	            	<td><?php echo status_display($item->status);?></td>
	            	<td>
						<!--<a href="javascript:void(0);" data-src="<?php echo base_url('app/grades/view_teachers/'.$item->id);?>" data-toggle="modal" data-target="#viewTeacherModal" title="View Teachers" class="btn btn-info btn-xs teacherModalButton">
							<span class="glyphicon glyphicon-eye-open"></span> Teachers
						</a>
						<a href="javascript:void(0);" data-src="<?php echo base_url('app/grades/view_titles/'.$item->id);?>" data-toggle="modal" data-target="#viewTtitleModal" title="View Titles" class="btn btn-info btn-xs titleModalButton">
							<span class="glyphicon glyphicon-eye-open"></span> Titles
						</a>-->
						<?php
							echo render_action(array('edit', 'delete'), $item->id);
						?>
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

<!-- Set Teacher Modal -->
<div class="modal fade bs-example-modal-sm" id="viewTeacherModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => 'frm_grade_teacher', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/grades'), $attributes);
	?>
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Assign Teachers</h4>
			</div>
			<div class="modal-body">
				<!-- Remote data loads here -->
				<span class="glyphicon glyphicon-refresh"></span> Loading please wait ...
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="operation" value="teacher_save">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	<?php echo form_close();?>
</div>

<!-- Set Title Modal -->
<div class="modal fade bs-example-modal-sm" id="viewTtitleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => 'frm_grade_title', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/grades'), $attributes);
	?>
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Assign Titles</h4>
		    </div>
		    <div class="modal-body">
				<!-- Remote data loads here -->
				<span class="glyphicon glyphicon-refresh"></span> Loading please wait ...
			</div>
		    <div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="operation" value="title_save">Save</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	</div>
	<?php echo form_close();?>
</div>
