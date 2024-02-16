<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-archive"></span> Add New Reports</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="fa fa-archive"></span> Reports_storage');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add New Reports');?></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/reports_storage');?>">Reports Storage Management</a></li>
		<li class="active">Add New Reports</li>
	</ol>

	<?php
		if($this->session->flashdata('message_type')) {
			if($this->session->flashdata('message')) {
				echo '<div class="alert alert-'.$this->session->flashdata('message_type').' alert-dismissable">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo $this->session->flashdata('message');
				echo '</div>';
			}
		}
	?>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/reports_storage/add'), $attributes);
  ?>

	<div class="col-sm-6">

      <fieldset>	
			<div class="form-group">
				<label for="inputName" class="col-sm-3 control-label">Title *</label>
				<div class="col-sm-7">
					<input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter Title" maxlength="50"  value="<?php echo set_value('title'); ?>" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
			  		<label for="inputStartDate" class="col-sm-3 control-label">Upload File *</label>
			  		<div class="col-sm-7">
			  			<input type="file" name="file1" class="form-control " id="inputStartDate" placeholder="Enter file" value="<?php echo set_value('file'); ?>" required >
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>
				
				

			  	<div class="form-group">
			  		<div class="col-sm-offset-3 col-sm-6">
				  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Reports</button> or <a href="<?php echo base_url('app/reports_storage');?>">Cancel</a>
				  	</div>
			  	</div>
			

			
		
	  	</fieldset>
	</div>

	
	<?php echo form_close();?>
</div>


