<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Edit Coordinator &raquo; <small> <?php echo character_limiter($teacher->first_name, 50);?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/coordinator');?>" title="Coordinator"><span class="glyphicon glyphicon-user"></span> Coordinator</a></li>
				<li><a href="<?php echo base_url('app/coordinator/add');?>" title="Add Coordinator"><span class="glyphicon glyphicon-plus-sign"></span> Add Coordinator</a></li>
    		</ul>
        </div>
    </div>
</div>



<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/coordinator');?>">Coordinator Management</a></li>
		<li class="active">Edit Coordinator</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/coordinator/edit/'.$teacher->id), $attributes);
    ?>
	<div class="col-sm-5">
		<fieldset>			
			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email </label>
		  		<div class="col-sm-7">
		  			<p class="help-block with-errors"><?php echo $teacher->email; ?></p>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label"> First Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="first_name" class="form-control" id="inputName" placeholder="Enter first name" value="<?php echo $teacher->first_name; ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Last Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="last_name" class="form-control" id="inputName" placeholder="Enter last name" value="<?php echo $teacher->last_name; ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inputInfo" class="col-sm-3 control-label">Home Address</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[address]" class="form-control" id="inputInfo" placeholder="Enter home address"><?php if(isset($teacher->meta['address'])) {echo $teacher->meta['address'];}?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>

		</fieldset>
	</div>
	<div class="col-sm-5">

		<fieldset>

			<div class="form-group">
		  		<label for="inputPhone" class="col-sm-3 control-label">Phone *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[phone]" class="form-control" id="inputPhone" placeholder="Enter Phone" value="<?php if(isset($teacher->meta['phone'])) {echo $teacher->meta['phone'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>	

				<div class="form-group">
		  		<label for="inputRate" class="col-sm-3 control-label">Rate Type *</label>
		  		<div class="col-sm-7">
						<select name="meta[rate_type]" class="form-control" required>
							<option value="">Choose rate type</option>	
							<option value="percentage" <?php if(!empty($teacher->meta['rate_type']) && $teacher->meta['rate_type'] == 'Percentage') echo 'selected'; ?>>Percentage</option>
                            <option value="fixed" <?php if(!empty($teacher->meta['rate_type']) && $teacher->meta['rate_type'] == 'Fixed') echo 'selected'; ?>>Fixed</option>


						</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>					

			<div class="form-group">
					<label for="inpuRate" class="col-sm-3 control-label">Rate * (% or fixed value) </label>
					<div class="col-sm-7">
						<input type="number" name="meta[rate]" class="form-control" id="inpuRate" placeholder="Enter Rate" value="<?php if(isset($teacher->meta['rate'])) {echo $teacher->meta['rate'];}?>" required step=".01">
						<div class="help-block with-errors"></div>
					</div>
				</div>		

			
			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($teacher->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($teacher->status == "inactive") echo "checked";?>>
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
	<div class="col-sm-2">
		<fieldset>
			<legend>Audit Info</legend>
			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
				<?php if (!is_null($teacher->updated_on)) {?>
					<small><?php echo datetime_display($teacher->updated_on);?></small>
					by <small><?php echo $teacher->updated_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Created on:
				<?php if (!is_null($teacher->created_on)) {?>
					<small><?php echo datetime_display($teacher->created_on);?></small>
					by <small><?php echo $teacher->created_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the Coordinator?')" href="<?php echo base_url('app/presenters/delete/'.$teacher->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Coordinator</a></p>
		</fieldset>
	</div>
	<?php echo form_close();?>
</div>

