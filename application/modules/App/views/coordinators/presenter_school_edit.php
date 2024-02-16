<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span>Presenter Assignment &raquo; <small> <?php echo character_limiter($coordinatorData->first_name, 50);?></small></h1>
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('assign_presenter_school_list', '<span class="glyphicon glyphicon-shopping-cart"></span> Presenters');?></li>
				<li class="active"><?php echo render_link('assign_presenter_school', '<span class="glyphicon glyphicon-plus-sign"></span> Presenter Assignment');?></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/coordinator');?>">Coordinator Management</a></li>
		<li><a href="<?php echo base_url('app/coordinator/assign_presenter_school_list/'.$coordinator_id);?>">Assigned Presenters</a></li>
		<li class="active">Presenter Assignment</li>
	</ol>

	<?php
	//echo "<pre>";print_r($coordinator_id);die;
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/coordinator/assign_presenter_school_edit/'.$coordinator_id.'/'.$presenterid), $attributes);
    ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
			<div class="form-group">
		  		<label for="inputPresenter" class="col-sm-3 control-label">Presenter *</label>
		  		<div class="col-sm-7">
		  			<select name="presenter_id" class="form-control" id="inputPresenter" disabled=disabled>
						<option value="" >Select Presenter</option>
						<?php 
						foreach ($presenters as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if(isset($presenter_list->presenter) && $presenter_list->presenter == $item->id ) { echo "selected"; } ?> ><?php echo $item->first_name." ".$item->last_name;?></option>

						<?php } ?>

					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			  <div class="form-group">
				<label for="inputSchool" class="col-sm-3 control-label">School *</label>
				<div class="col-sm-7">
					<?php $school_ids=$presenter_list->school_ids;
     						$ids=explode(',',$school_ids); 
     						?>
					<select name="school_id[]" class="form-control" id="inputSchool" multiple required="true">
						<option value="">Select School</option>
						<?php 
						foreach ($schools as $item) {
							?>
							<option value="<?php echo $item->id;?>" <?php if (in_array($item->id, $ids) ){echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
					<div class="help-block with-errors"></div>
				</div>
			</div>			  

			
			<div class="form-group">
		  		<label for="inputBDate" class="col-sm-3 control-label">From Date  *</label>
		  		<div class="col-sm-7">
					<div class="input-group">
						<input type="text" name="from_date" class="form-control calender-control" id="inputBDate" placeholder="Enter from date" value="<?php echo date_display($presenter_list->from_date);?>" autocomplete="off" >
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
					<input type="hidden" name="coordinator_id" value="<?php echo $coordinator_id; ?>">		
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Assign Presenter</button> or <a href="<?php echo base_url('app/coordinator/assign_presenter_school_list/'.$coordinator_id);?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

