<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-user-plus"></span> Edit Presenter &raquo; <small> <?php echo character_limiter($teacher->first_name, 50);?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/presenters');?>"><span class="fa fa-user-plus"></span> Presenters</a></li>
				<li><a href="<?php echo base_url('app/presenters/add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add New Presenter</a></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
		<li class="active">Edit Presenter</li>
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
		echo form_open_multipart(base_url('app/presenters/edit/'.$teacher->id), $attributes);
    ?>
	<div class="col-sm-5">
		<fieldset>			
			<!-- <div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email </label>
		  		<div class="col-sm-7">
		  			<p class="help-block with-errors"><?php echo $teacher->email; ?></p>
		  		</div>
		  	</div> -->

			<!-- edit email 26-07-2022 -->
			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label"> Email </label>
		  		<div class="col-sm-7">
		  			<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" value="<?php echo $teacher->email; ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label"> Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $teacher->first_name; ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>


			<div class="form-group">
		  		<label for="inputInfo" class="col-sm-3 control-label">Info</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[info]" class="form-control" id="inputInfo" placeholder="Enter info"><?php if(isset($teacher->meta['info'])) {echo $teacher->meta['info'];}?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>

			<div class="form-group">
		  		<label for="inpuRate" class="col-sm-3 control-label">Hourly Rate *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[rate]" class="form-control" id="inpuRate" placeholder="Enter Rate" value="<?php if(isset($teacher->meta['rate'])) {echo $teacher->meta['rate'];}?>" required>
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
		  			<input type="number" name="meta[phone]" class="form-control" id="inputPhone" placeholder="Enter Phone" value="<?php if(isset($teacher->meta['phone'])) {echo $teacher->meta['phone'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

		  	<!-- Start Code By Ahmed On 2018-08-05 -->
			<div class="form-group">
		  		<label for="inputCompany" class="col-sm-3 control-label">Company Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[company_name]" class="form-control" id="inputCompany" placeholder="Enter Company Name" value="<?php if(isset($teacher->meta['company_name'])) {echo $teacher->meta['company_name'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			<div class="form-group">
		  		<label for="inputAddress" class="col-sm-3 control-label">Address *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter Address" value="<?php if(isset($teacher->meta['address'])) {echo $teacher->meta['address'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		  	<!-- End Code -->
			
			<div class="form-group">
		  		<label for="inputRateFile" class="col-sm-3 control-label">Hourly Rate PDF</label>
		  		<div class="col-sm-7">
		  			<input type="file" name="rate_file" class="form-control" id="inputRateFile" value="" >
		  			<div class="help-block with-errors">
		  				<p><?php if(isset($teacher->meta['rate_file']) && $teacher->meta['rate_file'] != '') {echo anchor(base_url(DIR_TEACHER_FILES.strtolower($teacher->meta['rate_file'])),"Download Rate File", array("target"=>"_blank"));}?></p>
		  			</div>
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
			<?php 
			if(isset($_SERVER['HTTP_REFERER'])){
				$url= $_SERVER['HTTP_REFERER']; 
				$url2=explode('/',$url);
				if(isset($url2[9]))
					{
					$page=$url2[9];
			     	}
	        	}
			?>
		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Presenter</button> or <a href="<?php if(isset($page)) { echo base_url('app/presenters/index/status/0/page/'.$page); }else{ echo base_url('app/presenters'); }?>">Cancel</a>
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

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the Presenter?')" href="<?php echo base_url('app/presenters/delete/'.$teacher->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Presenter</a></p>
		</fieldset>
	</div>
	<?php echo form_close();?>
</div>

