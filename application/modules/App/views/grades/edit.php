<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-bookmark"></span> Edit Grade &raquo; <small> <?php echo $grade->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span>  Grades');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Grade');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/grades');?>">Grades</a></li>
		<li class="active">Edit Grade</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/grades/edit/'.$grade->id), $attributes);
   	?>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $grade->name; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>


			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($grade->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($grade->status == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>



			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Grade</button> or <a href="<?php echo base_url('app/grades');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Audit Info</legend>
    		<p>
    			<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
		    	<?php if (!is_null($grade->updated_on)) {?>
			    	<small><?php echo datetime_display($grade->updated_on);?></small>
			    	by <small><?php echo $grade->updated_by_name;?></small>
		    	<?php } else {echo "N/A";}?>
		    </p>

		    <p>
		    	<span class="glyphicon glyphicon-info-sign"></span> Created on:
		    	<?php if (!is_null($grade->created_on)) {?>
			    	<small><?php echo datetime_display($grade->created_on);?></small>
			    	by <small><?php echo $grade->created_by_name;?></small>
			    <?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" href="<?php echo base_url('app/grades/delete/'.$grade->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Grade</a></p>
    	</fieldset>

	</div>
	<?php echo form_close();?>
</div>
