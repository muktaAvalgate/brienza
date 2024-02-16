<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Add New Order</h1>
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-shopping-cart"></span> Orders');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Order');?></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/orders');?>">Manage Orders</a></li>
		<li class="active">Add Order</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal frm_place_order', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/order/add'), $attributes);
    ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>
			
			<?php if ($this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'coordinator') {?>
				<div class="form-group">
					<label for="inputSchool" class="col-sm-3 control-label">School *</label>
					<div class="col-sm-7">
						<select name="school_id" class="form-control" id="inputSchool" required>
							<option value="" selected>Select School</option>
							<?php foreach ($schools as $item) {?>
								<option value="<?php echo $item->id;?>" <?php if (set_value('school_id') == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
							<?php }?>
						</select>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			<?php }?>
			
  			<?php if ($this->session->userdata('role') == 'school_admin') { ?>
  				<div class="form-group">
					<label for="inputSchool" class="col-sm-3 control-label">School *</label>
					<div class="col-sm-7">
		  				<input type="text" name="school" class="form-control" value="<?php echo $school_meta['school_name']; ?>" readonly disabled >
		  				<input type="hidden" name="school_id" id="inputSchool" class="form-control" value="<?php echo $this->session->userdata('id'); ?>">
						<div class="help-block with-errors"></div>
					</div>
				</div>
  			<?php } ?>

			<?php 
			if ($this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'school_admin') {
			?>
			
			<div class="form-group">
				<label for="coordinator_id" class="col-sm-3 control-label">Coordinator </label>
				<div class="col-sm-7">
					<select name="coordinator_id" class="form-control" id="coordinator_id">
						<option value="" selected>Select Coordinator</option>
						<?php foreach ($coordinator_list as $item2) {?>
							<option value="<?php echo $item2->id;?>" <?php if (set_value('coordinator_id') == $item2->id) {echo "selected";}?>><?php echo $item2->first_name." ".$item2->last_name ;?></option>
						<?php }?>
					</select>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<?php } ?>			
			
  			<?php if ($this->session->userdata('role') == 'coordinator') {?>
  				<input type="hidden" name="coordinator_id" class="form-control" value="<?php echo $this->session->userdata('id'); ?>">
  			<?php } ?>

			<div class="form-group">
		  		<label for="inputPresenter" class="col-sm-3 control-label">Requested Presenter</label>
		  		<div class="col-sm-7">
		  			<select name="presenter_id" class="form-control" id="inputPresenter">
						<option value="" selected>Select Presenter</option>
						<?php foreach ($presenters as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if (set_value('presenter_id') == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
		  	<div class="form-group">
		  		<label for="inputTitle" class="col-sm-3 control-label">Title *</label>
		  		<div class="col-sm-7">
		  			<select name="title_id" class="form-control" id="inputTitle" required>
						<option value="" selected>Select Title</option>
						<?php foreach ($titles as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if (set_value('title_id') == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  	<label for="inputsession" class="col-sm-3 control-label">Session *</label>
		  		<div class="col-sm-7">
		  			<select name="session_id" class="form-control" id="session_id" required>
						<?php foreach ($sessions as $key => $value) {?>
							<option value="<?php echo $key;?>" <?php if (set_value('session_id') == $key) {echo "selected";}?>><?php echo $value;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<!--<div class="form-group">
		  		<label for="inputBDate" class="col-sm-3 control-label">Booking Date  *</label>
		  		<div class="col-sm-7">
					<div class="input-group">
						<input type="text" name="booking_date" class="form-control calender-control-futureonly" id="inputBDate" placeholder="Enter booking date" value="<?php echo set_value('email'); ?>" autocomplete="off" required>
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>-->
			
			<div class="form-group">
		  		<label for="inputHour" class="col-sm-3 control-label">Hours  *</label>
		  		<div class="col-sm-7">
		  			<!-- <input type="number" name="hour" min="1" class="form-control" id="inputHour" placeholder="Enter hour" value="1" required> -->
					  <input type="number" name="hour" min="1" class="form-control" id="inputHour" placeholder="Enter hour" value="1" oninput="validity.valid||(value='');" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			

			<!-- new added for program dropdown -->
			<!-- <?php echo print_r($programs->name); ?> -->
			<div class="form-group">
		  	<label for="inputprograms" class="col-sm-3 control-label">Program</label>
		  		<div class="col-sm-7">
		  			<select name="program_id" class="form-control" id="inputProgram">
					  <option value="<?php echo null; ?>">None</option>
						<?php foreach ($programs as $key ){ 
							print($key->name);?>
							
							<option value="<?php echo $key->id;?>" <?php if (set_value('program_id') == $key->id) {echo "selected";}?>><?php echo $key->name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>


		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Create Order</button> or <a href="<?php echo base_url('app/orders');?>">Cancel</a>
			  	</div>
		  	</div>
    	</fieldset>
	</div>
	<?php echo form_close();?>
</div>

<!-- Topic Modal -->
<div class="modal fade" id="topicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<?php
			$attributes = array('class' => 'form-inline', 'id' => 'frm_place_order_confirm', 'role' => 'form', 'data-toggle' => 'validator');
			echo form_open('', $attributes);
		?>
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Choose Topic (optional)</h4>
		    </div>
		    <div class="modal-body">
				
			</div>
		    <div class="modal-footer">
				<input type="hidden" name="title_id" id="title_id">
				<input type="hidden" name="hour" id="hour">
				<input type="hidden" name="booking_date" id="booking_date">
				<input type="hidden" name="presenter_id" id="presenter_id">
				<input type="hidden" name="coordinator_id" id="coordinator_id2">
				<input type="hidden" name="school_id" id="school_id">
				<input type="hidden" name="session_id" id="hdn_session_id">
				<input type="hidden" name="program_id" id="program_value">
				
				<button type="submit" class="btn btn-primary" id="btn_place_order">Confirm Order</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
		<?php echo form_close();?>
	</div>
</div>

<!-- For loader -->
<div class="loader_img" style="display:none;"> </div>
<style type="text/css">
  .loader_img {
      position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(<?php echo base_url('assets/images/loader.gif'); ?>) center no-repeat #fff;
    opacity: .6;
  }
</style>

<script type="text/javascript">
	
	$(document).ready(function(){
		$('#inputSchool').on('change', function(){
			var school_id = $(this).val();
			$.ajax({
	            type:'POST',
	            url: base_url+"app/orders/get_assign_school_presenter",
	            dataType: "json",
	            data:{school_id: school_id},
	            success:function(response){
	            	var html = '<option value="" selected="">Select Presenter</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.presenter_id+'">'+value.first_name+' '+value.last_name+'</option>'
					});

	            	$('#inputPresenter').html(html);
	            }
	        });
			// For school title
			$.ajax({
	            type:'POST',
	            url: base_url+"app/orders/get_assign_school_titles",
	            dataType: "json",
	            data:{school_id: school_id},
	            success:function(response){
	            	var html = '<option value="" selected="">Select Title</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.id+'">'+value.title+'</option>'
					});

	            	$('#inputTitle').html(html);
	            }
	        });
			// For school coordinator
			$.ajax({
	            type:'POST',
	            url: base_url+"app/orders/get_assign_school_coordinator",
	            dataType: "json",
	            data:{school_id: school_id},
	            success:function(response){
	            	var html = '<option value="" selected="">Select Coordinator</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.coordinator_id+'">'+value.first_name+' '+value.last_name+'</option>'
					});

	            	$('#coordinator_id').html(html);
	            }
	        });
		});

		$('#coordinator_id').on('change', function(){
			var co_id = $(this).val();
			var school_id = $('#inputSchool').val();
			$.ajax({
	            type:'POST',
	            url: base_url+"app/orders/get_assign_school_presenter",
	            dataType: "json",
	            data:{school_id: school_id, co_id: co_id},
	            success:function(response){
	            	var html = '<option value="" selected="">Select Presenter</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.presenter_id+'">'+value.first_name+' '+value.last_name+'</option>'
					});

	            	$('#inputPresenter').html(html);
	            }
	        });
		});

		$('#inputProgram').on('change', function(){

			var programVal=$(this).val();
			// alert(programVal);
			$('#program_value').val(programVal);
		});

	});
</script>