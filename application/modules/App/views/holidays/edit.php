<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-bookmark"></span> Edit Holiday &raquo; <small> <?php echo $holiday->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-bookmark"></span>  Holidays');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Holiday');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/holidays');?>">Holidays</a></li>
		<li class="active">Edit Holiday</li>
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
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/holidays/edit/'.$holiday->id), $attributes);
   	?>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $holiday->name; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inputBatch" class="col-sm-3 control-label">Batch *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="batch" class="form-control" id="inputBatch" placeholder="Enter batch" value="<?php echo $holiday->batch; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputStartDate" class="col-sm-3 control-label">Start Date *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="start_date" class="form-control calender-control" id="inputStartDate" placeholder="Enter start date" value="<?php echo date_display($holiday->start_date); ?>" required >
		  			<div class="help-block with-errors">For a single day event, please enter start date only.</div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputEndDate" class="col-sm-3 control-label">End Date</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="end_date" class="form-control calender-control" id="inputEndDate" placeholder="Enter end date" value="<?php echo date_display($holiday->end_date); ?>" >
		  			<div class="help-block with-errors" style="color: red; display: none;" id="showError"></div>
		  		</div>
		  	</div>

			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary" onclick="return dateValid();"><span class="glyphicon glyphicon-ok-sign"></span> Save Holiday</button> or <a href="<?php echo base_url('app/holidays');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Audit Info</legend>


			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" href="<?php echo base_url('app/holidays/delete/'.$holiday->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Holiday</a></p>
    	</fieldset>

	</div>
	<?php echo form_close();?>
</div>
<script type="text/javascript">
	function dateValid(){
		var startDate = $('#inputStartDate').val();
		var endDate = $('#inputEndDate').val();
		if(endDate && (new Date(startDate) > new Date(endDate))){
			$('#showError').css('display','block');
			$('#inputEndDate').css('border-color', 'red');
			$('#showError').html('The end date cannot be smaller than the start date!');
			return false;
		}
		return true;
	}
</script>