<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-calendar"></span> Edit Schedule &raquo; <small> <?php echo character_limiter($schedule->name, 50);?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-calendar"></span> Schedules');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add Schedules');?></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schedules');?>">Schedule Management</a></li>
		<li class="active">Edit Schedule</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schedules/edit/'.$schedule->id), $attributes);
    ?>
	<div class="col-sm-6">
		<fieldset>
    		<legend>Basic Info</legend>
			
			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter schedule name" value="<?php echo $schedule->name; ?>" required>
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
								<td><input type="checkbox" class="checkbox" name="workingdays[<?=$lower_day?>]" id="<?=$lower_day."_select"?>" value="Y" <?php if ( isset($schedule->workingdays[$lower_day]) && $schedule->workingdays[$lower_day] == "Y" ) echo "checked";?> ></td>
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
								<td><input type="checkbox" class="checkbox" name="holidays[<?=$holiday->id?>]" id="<?=strtolower($day)."_select"?>" value="Y" <?php if ( isset($schedule->holidays[$holiday->id]) && $schedule->holidays[$holiday->id] == "Y" ) echo "checked";?> ></td>
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

		<fieldset>
			<legend>Audit Info</legend>
			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
				<?php if (!is_null($schedule->updated_on)) {?>
					<small><?php echo datetime_display($schedule->updated_on);?></small>
					by <small><?php echo $schedule->updated_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Created on:
				<?php if (!is_null($schedule->created_on)) {?>
					<small><?php echo datetime_display($schedule->created_on);?></small>
					by <small><?php echo $schedule->created_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the schedule?')" href="<?php echo base_url('app/schedules/delete/'.$schedule->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Schedule</a></p>
		</fieldset>
		
		
	</div>
	<?php echo form_close();?>
</div>

