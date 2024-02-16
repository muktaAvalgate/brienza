<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-equalizer"></span> Edit  Title &raquo; <small> <?php echo $category->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-equalizer"></span>  Titles');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Title');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/categories');?>">Titles</a></li>
		<li class="active">Edit Title</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/categories/edit/'.$category->id), $attributes);
   	?>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Basic Info</legend>

			<div class="form-group" id="location_container">
				<label for="inputParent" class="col-sm-3 control-label">Parent *</label>
				<div class="col-sm-7">
					<select name="parent_id" class="form-control" id="inputParent" required>
						<option value="0" selected>Root</option>
						<?php foreach ($list as $item) {?>
						<option value="<?php echo $item['id'];?>" <?php if ($category->parent_id == $item['id']) {echo "selected";}?>><?php echo $item['name'];?></option>
						<?php }?>
					</select>
					<div class="help-block with-errors">Select Root if you want to add parent category.</div>
				</div>
			</div>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $category->name; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputTopic" class="col-sm-3 control-label">Topic</label>
		  		<div class="col-sm-7">
			  		<textarea name="topic" class="form-control" id="inputTopic" placeholder="Enter topic"><?php echo $category->topic;?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>


			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($category->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($category->status == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>



			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Title</button> or <a href="<?php echo base_url('app/categories');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Audit Info</legend>
    		<p>
    			<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
		    	<?php if (!is_null($category->updated_on)) {?>
			    	<small><?php echo datetime_display($category->updated_on);?></small>
			    	by <small><?php echo $category->updated_by_name;?></small>
		    	<?php } else {echo "N/A";}?>
		    </p>

		    <p>
		    	<span class="glyphicon glyphicon-info-sign"></span> Created on:
		    	<?php if (!is_null($category->created_on)) {?>
			    	<small><?php echo datetime_display($category->created_on);?></small>
			    	by <small><?php echo $category->created_by_name;?></small>
			    <?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" href="<?php echo base_url('app/categories/delete/'.$category->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Title</a></p>
    	</fieldset>

	</div>
	<?php echo form_close();?>
</div>
