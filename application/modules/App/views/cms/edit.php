<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-edit"></span> Manage Content &raquo; <small> <?php echo $cms->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
        		<li><a href="<?php echo base_url('app/cms');?>"><span class="glyphicon glyphicon-edit"></span> Contents</a></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/cms');?>">Manage Content</a></li>
		<li class="active">Update Page</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/cms/edit/'.$cms->id), $attributes);
   	?>

	<div class="col-md-8">

      	<fieldset>
    		<legend>Page Details</legend>

		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-2 control-label">Page Name *</label>
		  		<div class="col-sm-9">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter page name" value="<?php echo $cms->name; ?>" required >
		  			<div class="help-block with-errors">This will be used in page heading</div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		  		<label for="inputContent" class="col-sm-2 control-label">Content *</label>
		  		<div class="col-sm-9">
		  			<textarea name="description" class="form-control" rows="15" id="inputContent" placeholder="Enter page content" required><?php echo $cms->description; ?></textarea>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		</fieldset>
	</div>

	<div class="col-md-4">
		<fieldset>
    		<legend>Meta Info</legend>

			<div class="form-group">
		  		<label for="inputType" class="col-sm-4 control-label">Page URL *</label>
		  		<div class="col-sm-8">
					<div class="input-group">
      					<span class="input-group-addon"><?php echo base_url().'page/';?></span>
				      	<input type="text" name="page_type" class="form-control" id="inputType" placeholder="Enter page url" value="<?php echo $cms->page_type; ?>" required >
			    	</div>
		  			<div class="help-block">This will be used as page url. Only use alphanumeric with underscore(_).<br /><?php echo anchor_popup('page/'.$cms->page_type.'/?nocache=1', '<span class="glyphicon glyphicon-share"></span> Preview Page', array('class' => 'btn btn-default', 'title' => 'Preview Page'));?></div>
					<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
				<label for="inputTitle" class="col-sm-4 control-label">Meta Title *</label>
				<div class="col-sm-8">
					<input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter email address" value="<?php echo $cms->title; ?>" required >
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
		  		<label for="inputKey" class="col-sm-4 control-label">Meta Ketwords</label>
		  		<div class="col-sm-8">
		  			<textarea name="meta_keyword" class="form-control" id="inputKey" placeholder="Enter meta keywords"><?php echo $cms->meta_keyword; ?></textarea>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inputDesc" class="col-sm-4 control-label">Meta Description</label>
		  		<div class="col-sm-8">
		  			<textarea name="meta_description" class="form-control" id="inputDesc" placeholder="Enter meta description"><?php echo $cms->meta_description; ?></textarea>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		</fieldset>

		<fieldset>
    		<legend>Audit Info</legend>

			<div class="form-group">
		  		<label for="inputUpdated" class="col-sm-4 control-label">Last Updated</label>
		  		<div class="col-sm-8">
		  			<p class="form-control-static" id="inputUpdated">
						<?php if (!is_null($cms->updated_on)) {?>
					    	On <small><?php echo datetime_display($cms->updated_on);?></small>
					    	by <small><?php echo $cms->updated_by_name;?></small>
				    	<?php } else {echo "N/A";}?>
					</p>
		  		</div>
		  	</div>

			<div class="form-group">
			  	<div class="col-sm-offset-4 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Page</button> or <a href="<?php echo base_url('app/cms');?>">Cancel</a>
				</div>
			</div>
    	</fieldset>

	</div>

	<?php echo form_close();?>
</div>
