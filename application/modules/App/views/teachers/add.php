<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Add New Teacher</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-user"></span> Teachers');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add Teacher');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/teachers');?>">Teachers Management</a></li>
		<li class="active">Add Teacher</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/teachers/add'), $attributes);
      ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
			<div class="form-group">
		  		<label for="inputSchool" class="col-sm-3 control-label">School *</label>
		  		<div class="col-sm-7">
					<select name="school_id" class="form-control" id="inputSchool" required>
						<option value="" selected>Select School</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if (set_value('school_id') == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputGrade" class="col-sm-3 control-label">Grade *</label>
		  		<div class="col-sm-7">
					<select name="grade_id" class="form-control" id="inputGrade" required>
						<option value="" selected>Select Grade</option>
						<?php foreach ($grades as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if (set_value('grade_id') == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
						
		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo set_value('name'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<!--<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="email" class="form-control" id="inputEmail" placeholder="Enter email address" value="<?php echo set_value('email'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputPhone" class="col-sm-3 control-label">Phone *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Enter Phone" value="<?php echo set_value('phone'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>-->
		
			
			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if(set_value('status') != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if(set_value('status') == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>

		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Teacher</button> or <a href="<?php echo base_url('app/teachers');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

