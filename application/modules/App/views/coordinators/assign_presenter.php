<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span>Presenter Assignment</h1>
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/coordinator');?>"><span class="glyphicon glyphicon-user"></span>Coordinator</a></li>
				<li><a href="<?php echo base_url('app/coordinator/assign_presenter_school_list/'.$coordinator_id);?>"><span class="glyphicon glyphicon-user"></span>Assigned Presenters</a></li>
				<li class="active"><a href="<?php echo base_url('app/coordinator/assign_presenter_school/'.$coordinator_id);?>"><span class="glyphicon glyphicon-plus-sign"></span>Presenter Assignment</a></li>
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
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/coordinator/assign_presenter_school/'.$coordinator_id), $attributes);
    ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
			<div class="form-group">
		  		<label for="inputPresenter" class="col-sm-3 control-label">Presenter *</label>
		  		<div class="col-sm-7">
		  			<select name="presenter_id" class="form-control" id="inputPresenter" required>
						<option value="" selected>Select Presenter</option>
						<?php foreach ($presenters as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if (set_value('presenter_id') == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?><!-- (Hourly Rate: <?php echo price_display($item->meta['rate']);?>)--></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			  <div class="form-group">
				<label for="inputSchool" class="col-sm-3 control-label">School *</label>
				<div class="col-sm-7">
					<select name="school_id[]" class="form-control" id="inputSchool" multiple required>
						<option value="" selected>Select School</option>
						<?php foreach ($schools as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if (set_value('school_id') == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
					<div class="help-block with-errors"></div>
				</div>
			</div>			  

			
			<div class="form-group">
		  		<label for="inputBDate" class="col-sm-3 control-label">From Date </label>
		  		<div class="col-sm-7">
					<div class="input-group">
						<input type="text" name="from_date" class="form-control calender-control" id="inputBDate" placeholder="Enter from date" value="" autocomplete="off">
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

<script type="text/javascript">
	$('#inputBDate').keypress(function(event){
	      event.preventDefault();
	});
	$(document).ready(function(){
		$('#inputPresenter').on('change', function(){
			var co_id = '<?php echo $this->uri->segment(4); ?>';
			var p_id = $(this).val();
			$.ajax({
	            type:'POST',
	            url: base_url+"app/coordinator/get_assign_presenter_school",
	            dataType: "json",
	            data:'co_id='+co_id+'&p_id='+p_id,
	            success:function(response){
	    //         	var html = '<option value="" selected="">Select School</option>';
	    //         	$(response).each(function(index, value) { 
					// 	html += '<option value="'+value.id+'">'+value.school_name+'</option>'
					// });

	            	$('#inputSchool').html(response);
	            }
	        });
		});
	});
</script>