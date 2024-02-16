<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-question-sign"></span> Create Signup Questions</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-question-sign"></span> Signup Questions');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create Signup Questions');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/questions');?>">Signup Questions</a></li>
		<li class="active">Create Signup Questions</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/questions/add/'), $attributes);
   	?>

	<div class="col-sm-6">

      	<fieldset>
			<legend>Basic Info</legend>

			<div class="form-group" id="location_container">
				<label for="inputParent" class="col-sm-3 control-label">Group *</label>
				<div class="col-sm-7">
					<select name="question_group" class="form-control" id="inputParent" required>
						<option value="Group 1" <?php if (set_value('question_group') == 'Group 1') {echo "selected";}?>>Group 1</option>
						<option value="Group 2" <?php if (set_value('question_group') == 'Group 2') {echo "selected";}?>>Group 2</option>
					</select>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo set_value('name'); ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

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

			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Signup Questions</button> or <a href="<?php echo base_url('app/questions');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-6">


	</div>

	<?php echo form_close();?>
</div>
