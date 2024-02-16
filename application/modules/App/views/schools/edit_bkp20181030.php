<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-object-align-bottom"></span> Edit School &raquo; <small> <?php if(isset($school->meta['school_name'])) {echo $school->meta['school_name'];}?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/schools');?>"><span class="glyphicon glyphicon-object-align-bottom"></span> Schools</a></li>
				<li><a href="<?php echo base_url('app/schools/add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add New School</a></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schools');?>">School Management</a></li>
		<li class="active">Edit School</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schools/edit/'.$school->id), $attributes);
    ?>
	<div class="col-sm-5">
		<fieldset>
    		<legend>Basic Info</legend>
			
			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label"> School Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[school_name]" class="form-control" id="inputName" placeholder="Enter name" value="<?php if(isset($school->meta['school_name'])) {echo $school->meta['school_name'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuEmail" class="col-sm-3 control-label">Email *</label>
		  		<div class="col-sm-7">
		  			<input type="email" name="email" class="form-control" id="inpuEmail" placeholder="Enter email address" value="<?php echo $school->email; ?>" readonly>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuPhone" class="col-sm-3 control-label">Phone</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[phone]" class="form-control" id="inpuPhone" placeholder="Enter phone" value="<?php if(isset($school->meta['phone'])) {echo $school->meta['phone'];}?>" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputAddress" class="col-sm-3 control-label">Address</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter address" ><?php if(isset($school->meta['address'])) {echo $school->meta['address'];}?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuCity" class="col-sm-3 control-label">City</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[city]" class="form-control" id="inpuCity" placeholder="Enter city" value="<?php if(isset($school->meta['city'])) {echo $school->meta['city'];}?>" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuState" class="col-sm-3 control-label">State</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[state]" class="form-control" id="inpuState" placeholder="Enter state" value="<?php if(isset($school->meta['state'])) {echo $school->meta['state'];}?>" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuContact" class="col-sm-3 control-label">Contact Person</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="first_name" class="form-control" id="inpuContact" placeholder="Enter contact person" value="<?php echo $school->first_name;?>" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			

		</fieldset>
	</div>
	<div class="col-sm-5">

		<fieldset>
    		<legend>Others Info</legend>

			<div class="form-group">
		  		<label for="inputSchool" class="col-sm-3 control-label">Holiday Schedule *</label>
		  		<div class="col-sm-7">
					<select name="meta[holiday_schedule_id]" class="form-control" id="inputSchool" required>
						<option value="" selected>Select Schedule</option>
						<?php foreach ($schedules as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if (isset($school->meta['holiday_schedule_id']) && $school->meta['holiday_schedule_id'] == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($school->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($school->status == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>

		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save School</button> or <a href="<?php echo base_url('app/schools');?>">Cancel</a>
			  	</div>
		  	</div>

		</fieldset>

		<fieldset>
			<legend>Audit Info</legend>
			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
				<?php if (!is_null($school->updated_on)) {?>
					<small><?php echo datetime_display($school->updated_on);?></small>
					by <small><?php echo $school->updated_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Created on:
				<?php if (!is_null($school->created_on)) {?>
					<small><?php echo datetime_display($school->created_on);?></small>
					by <small><?php echo $school->created_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the school?')" href="<?php echo base_url('app/schools/delete/'.$school->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this School</a></p>
		</fieldset>
	</div>
	<?php echo form_close();?>
</div>

