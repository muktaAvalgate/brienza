<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Add New Coordinator</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-user"></span> Coordinator');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add Coordinator');?></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/coordinator');?>">Coordinator Management</a></li>
		<li class="active">Add Coordinator</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/coordinator/add'), $attributes);
  ?>

	<div class="col-sm-6">

      <fieldset>	
			<div class="form-group">
				<label for="inputName" class="col-sm-3 control-label">First Name *</label>
				<div class="col-sm-7">
					<input type="text" name="first_name" class="form-control" id="inputName" placeholder="Enter first name" value="<?php echo set_value('first_name'); ?>" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
				<label for="inputName" class="col-sm-3 control-label">Last Name *</label>
				<div class="col-sm-7">
					<input type="text" name="last_name" class="form-control" id="inputName" placeholder="Enter last name" value="<?php echo set_value('last_name'); ?>" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email *</label>
		  		<div class="col-sm-7">
		  			<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email address" value="<?php echo set_value('email'); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="example@gmail.com">
		  			<div class="help-block with-errors">This will be used for login</div>
		  		</div>
		  	</div>
			

			
			<div class="form-group">
		  		<label for="inputDesc" class="col-sm-3 control-label">Home Adddress</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[address]" class="form-control" id="inputDesc" placeholder="Enter Address"><?php echo set_value('meta[address]'); ?></textarea>
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
		  			<input type="number" name="meta[phone]" class="form-control" id="inputPhone" placeholder="Enter Phone" maxlength="10" data-minlength="10" value="<?php echo set_value('meta[phone]'); ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

				<div class="form-group">
		  		<label for="inputRate" class="col-sm-3 control-label">Rate Type *</label>
		  		<div class="col-sm-7">
						<select name="meta[rate_type]" class="form-control" required>
							<option value="">Choose rate type</option>	
							<option value="percentage">Percentage</option>
							<option value="fixed">Fixed</option>
						</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>				
			
				<div class="form-group">
		  		<label for="inputRate" class="col-sm-3 control-label">Rate * (% or fixed value) </label>
		  		<div class="col-sm-7">
		  			<input type="number" name="meta[rate]" class="form-control" id="inputRate" placeholder="Enter Rate" value="<?php echo set_value('meta[rate]'); ?>" required step=".01">
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if(set_value('status') != "active") echo "checked";?>>
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
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Coordinator</button> or <a href="<?php echo base_url('app/coordinator');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

