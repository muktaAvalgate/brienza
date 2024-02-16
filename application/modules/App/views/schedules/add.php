<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-calendar"></span> Add New Schedules</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-calendar"></span> Schedules');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add Schedules');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schedules');?>">Schedule Management</a></li>
		<li class="active">Add Schedule</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schedules/add'), $attributes);
      ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter schedule name" value="<?php echo set_value('name'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputWD" class="col-sm-3 control-label">Working Days  *</label>
		  		<div class="col-sm-7">
		  			<table class="table table-striped table-nonfluid">
						<tbody>
						<?php
							foreach ($weekdays as $key => $day) {
								$lower_day = strtolower($day);
						?>
							<tr>
								<td><?=$day?></td>
								<td><input type="checkbox" class="checkbox" name="workingdays[<?=strtolower($day)?>]" id="<?=strtolower($day)."_select"?>" value="Y" ></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
		  		</div>
		  	</div>

    	</fieldset>
	</div>
	<div class="col-sm-6">
		
      	<fieldset>
    		<legend>Holiday Info</legend>
			<div class="form-group">
		  		<label for="inputWD" class="col-sm-2 control-label">Holidays  *</label>
		  		<div class="col-sm-9">
		  			<table class="table table-striped table-nonfluid">
						<tbody>
						<?php
							foreach ($holidays as $key => $holiday) {
						?>
							<tr>
								<td><?=date_display($holiday->start_date);?> <?php if($holiday->end_date){ echo " to ".date_display($holiday->end_date);}?></td>
								<td><?=$holiday->name?></td>
								<td><input type="checkbox" class="checkbox" name="holidays[<?=$holiday->id?>]" id="<?=strtolower($day)."_select"?>" value="Y" ></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<div class="col-sm-offset-2 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Schedule</button> or <a href="<?php echo base_url('app/schedules');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

