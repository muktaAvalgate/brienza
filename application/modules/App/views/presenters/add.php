<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-user-plus"></span> Add New Presenter</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="fa fa-user-plus"></span> Presenters');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add Presenter');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
		<li class="active">Add Presenter</li>
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
		echo form_open_multipart(base_url('app/presenters/add'), $attributes);
      ?>
	<div class="col-sm-6">

      	<fieldset>			
			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email *</label>
		  		<div class="col-sm-7">
		  			<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email address" value="<?php echo set_value('email'); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="example@gmail.com">
		  			<div class="help-block with-errors">This will be used for login</div>
		  		</div>
		  	</div>
			
		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo set_value('name'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputDesc" class="col-sm-3 control-label">Info</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[info]" class="form-control" id="inputDesc" placeholder="Enter info"><?php echo set_value('meta[info]'); ?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputRate" class="col-sm-3 control-label">Hourly Rate *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[rate]" class="form-control" id="inputRate" placeholder="Enter Rate" value="<?php echo set_value('meta[rate]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
		  	
	  	</fieldset>
	</div>

	<div class="col-sm-6">
		<fieldset>
			
			<div class="form-group">
		  		<label for="inputPhone" class="col-sm-3 control-label">Phone *</label>
		  		<div class="col-sm-7">
		  			<input type="number" name="meta[phone]" class="form-control" id="inputPhone" placeholder="Enter Phone" value="<?php echo set_value('meta[phone]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		  	<!-- Start Code By Ahmed on 2019-08-05 -->
			<div class="form-group">
		  		<label for="inputCompany" class="col-sm-3 control-label">Company Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[company_name]" class="form-control" id="inputCompany" placeholder="Enter Company Name" value="<?php echo set_value('meta[company_name]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			<div class="form-group">
		  		<label for="inputAddress" class="col-sm-3 control-label">Address *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter Address" value="<?php echo set_value('meta[address]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			<!-- End Code -->
			
			<div class="form-group">
		  		<label for="inputRateFile" class="col-sm-3 control-label">Hourly Rate PDF</label>
		  		<div class="col-sm-7">
		  			<input type="file" name="rate_file" class="form-control" id="inputRateFile" value="" >
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

		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Presenter</button> or <a href="<?php echo base_url('app/presenters');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

