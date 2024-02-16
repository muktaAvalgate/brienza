<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-gg-circle"></span> Edit Goal &raquo; <small> <?php echo character_limiter($goals->title, 50);?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="fa fa-gg-circle"></span> Goals');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add New Goal');?></li>
    		</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/goals');?>">Goals Management</a></li>
		<li class="active">Edit Goal</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/goals/edit/'.$goals->id), $attributes);
  ?>

	<div class="col-sm-6">

      <fieldset>	
			<div class="form-group">
				<label for="inputName" class="col-sm-3 control-label">Title *</label>
				<div class="col-sm-7">
					<input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter Title" maxlength="50" value="<?php echo $goals->title; ?>" required>
					<div class="help-block with-errors"></div>
				</div>
			</div>

			<div class="form-group">
			  		<label for="inputStartDate" class="col-sm-3 control-label">Start Date *</label>
			  		<div class="col-sm-7">
			  			<input type="text" name="start_date" class="form-control" id="session_from" placeholder="Enter start date" value="<?php echo date_display($goals->start_date); ?>" required >
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>
				
				<div class="form-group">
			  		<label for="inputEndDate" class="col-sm-3 control-label">End Date  *</label>
			  		<div class="col-sm-7">
			  			<input type="text" name="end_date" class="form-control calender-control calender-control-futureonly" id="session_to" placeholder="Enter end date" value="<?php echo date_display($goals->end_date); ?>" required>
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>

			  	<div class="form-group">
					<label for="inputName" class="col-sm-3 control-label">Amount ($) *</label>
					<div class="col-sm-7">
						<input type="number" name="amount" class="form-control" id="inputName" placeholder="Enter amount" value="<?php echo $goals->amount; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
			    </div>

			  	<div class="form-group">
			  		<label for="" class="col-sm-3 control-label">Status</label>
			  		<div class="col-sm-7">
				  		<div class="radio">
						  <label for="checkboxActive">
						    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($goals->status != "inactive") echo "checked";?>>
						    Active
						  </label>
						</div>
						<div class="radio">
						  <label for="checkboxinactive">
						    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($goals->status == "inactive") echo "checked";?>>
						    In-active
						  </label>
						</div>
					</div>
				</div>

			  	<div class="form-group">
			  		<div class="col-sm-offset-3 col-sm-6">
				  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Goal</button> or <a href="<?php echo base_url('app/goals');?>">Cancel</a>
				  	</div>
			  	</div>
			

			
		
	  	</fieldset>
	</div>

	<?php echo form_close();?>
</div>

<script type="text/javascript">
	jQuery(".calender-control-futureonly").keypress(function(e){
		e.preventDefault();
	})
</script>


<script type="text/javascript">
$(function () {
    $("#session_from").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#session_to").datepicker("option", "minDate", dt);
        }
    });
    $("#session_to").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#session_from").datepicker("option", "maxDate", dt);
        }
    });
});
</script>

