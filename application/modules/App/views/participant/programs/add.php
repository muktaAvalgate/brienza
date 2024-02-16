<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-bookmark"></span> Create New Program</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span> Programs');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Program');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/categories');?>">Program</a></li>
		<li class="active">Create Program</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/programs/add/'), $attributes);
   	?>

	<div class="col-sm-6">

      	<fieldset>
			<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="program_name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo set_value('name'); ?>" required >
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
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Program</button> or <a href="<?php echo base_url('app/programs');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-6">


	</div>

	<?php echo form_close();?>
</div>
