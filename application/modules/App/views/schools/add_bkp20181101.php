<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-object-align-bottom"></span> Add New School</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-object-align-bottom"></span> Schools');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add School');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schools');?>">School Management</a></li>
		<li class="active">Add School</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schools/add'), $attributes);
      ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">School Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[school_name]" class="form-control" id="inputName" placeholder="Enter school name" value="<?php echo set_value('meta[school_name]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email  *</label>
		  		<div class="col-sm-7">
		  			<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" value="<?php echo set_value('email'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save School</button> or <a href="<?php echo base_url('app/schools');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

