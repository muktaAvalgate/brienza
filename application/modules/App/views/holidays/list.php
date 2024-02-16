<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-bookmark"></span> Holidays</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span> Holidays');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Holiday');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Holidays</li>
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
		echo form_open(base_url('app/holidays/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Name</th>
					<th>Batch</th>
					<th>Date</th>
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
					<td><?php echo $item->batch;?></td>
					<td><?php echo date_display($item->start_date);?> <?php if($item->end_date){ echo " to ".date_display($item->end_date);}?></td>
	            	<td>
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
						<?php echo render_buttons(array('delete'));?>
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php //echo $this->pagination->create_links(); ?>
</div>
