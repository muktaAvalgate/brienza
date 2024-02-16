<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-bookmark"></span> Edit Work Type &raquo; <small> <?php echo $worktype->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span>  Work Type');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Work Type');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/worktypes');?>">Work Type</a></li>
		<li class="active">Edit Work Type</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/worktypes/edit/'.$worktype->id), $attributes);
   	?>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $worktype->name; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Work Type</button> or <a href="<?php echo base_url('app/worktypes');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Audit Info</legend>


			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" href="<?php echo base_url('app/worktypes/delete/'.$worktype->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Work Type</a></p>
    	</fieldset>

	</div>
	<?php echo form_close();?>
</div>
