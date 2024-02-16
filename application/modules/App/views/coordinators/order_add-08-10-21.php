
<?php
$coid = $this->input->get('id');
$ref = $this->input->get('ref');
if(isset($coid) && $coid != ''){
	$pageListURL = 'app/coordinator/main_orders/?id='.$coid;
	$pageCreateURL = 'app/coordinator/order_add/';
}elseif(isset($ref) && $ref != ''){
	$pageListURL = 'app/coordinator/'.$ref;
	$pageCreateURL = 'app/coordinator/order_add/?ref='.$ref;
}else{
	$pageListURL = 'app/coordinator/order';
	$pageCreateURL = 'app/coordinator/order_add';
}

if($this->session->userdata('role') == 'coordinator'){
	$coid = $this->session->userdata('id');
}
?>	

<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Create New Order</h1>
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url($pageListURL); ?>" title=" Orders" class=""><span class="glyphicon glyphicon-shopping-cart"></span> Orders</a></li>
				<li class="active">
					<a href="<?php echo base_url($pageCreateURL); ?>" title=" Create New Order" class=""><span class="glyphicon glyphicon-plus-sign"></span> Create New Order</a>
						
				</li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<?php if($this->session->userdata('role') == 'administrator'){ ?>
		<li><a href="<?php echo base_url('app/coordinator')?>">Coordinator Management</a></li>
		<li><a href="<?php echo base_url('app/coordinator/main_orders/?id='.$this->input->get('id'));?>">Order Management</a></li>
	<?php }else{ ?>
		<li><a href="<?php echo base_url($pageListURL)?>"> Manage Orders</a></li>
	<?php } ?>
		<li class="active">Create New Order</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal frm_place_order_coordinator', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/coordinator/order_add'), $attributes);
    ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>

				<div class="form-group">
					<label for="inputSchool" class="col-sm-3 control-label">School *</label>
					<div class="col-sm-7">
						<?php if($this->session->userdata('role') == 'school_admin'){ ?>
							<input type="text" name="school" class="form-control" value="<?php echo $schools['school_name']; ?>" readonly disabled>
							<input type="hidden" name="school_id" value="<?php echo $this->session->userdata('id'); ?>">
						<?php }else{ ?>
							<select name="school_id" class="form-control" id="inputSchool" required>
								<option value="" selected>Select School</option>
								<?php foreach ($schools as $item) {?>
									<option value="<?php echo $item->id;?>" <?php if (set_value('school_id') == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
								<?php }?>
							</select>
						<?php } ?>
						<div class="help-block with-errors"></div>
					</div>
				</div>

			<div class="form-group">
		  		<label for="inputPresenter" class="col-sm-3 control-label">Requested Presenter</label>
		  		<div class="col-sm-7">
		  			<select name="presenter_id" class="form-control" id="inputPresenter">
						<option value="" selected>Select Presenter</option>
						<?php foreach ($presenters as $item) {?>
							<option value="<?php echo $item['presenter_id'];?>" <?php if (set_value('presenter_id') == $item['presenter_id']) {echo "selected";}?>><?php echo $item['first_name']." ".$item['last_name'];?><!-- (Hourly Rate: <?php //echo price_display($item->meta['rate']);?>) --></option>
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
		  		<label for="inputHour" class="col-sm-3 control-label">Hours  *</label>
		  		<div class="col-sm-7">
		  			<input type="number" name="hour" min="1" class="form-control" id="inputHour" placeholder="Enter hour" value="1" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
		  			<input type="hidden" name="coordinator_id" class="form-control" id="coID" value="<?php echo $coid; ?>">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Create Order</button> or <a href="<?php echo base_url($pageListURL);?>">Cancel</a>
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
			$attributes = array('class' => 'form-inline', 'id' => 'frm_place_order_confirm_co', 'role' => 'form', 'data-toggle' => 'validator');
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
				<input type="hidden" name="school_id" id="school_id">
				<input type="hidden" name="presenter_id" id="presenter_id">
				<input type="hidden" name="coordinator_id" id="coordinator_id">
				
				<button type="submit" class="btn btn-primary" id="btn_place_order_co">Confirm Order</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
		<?php echo form_close();?>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		$('#inputSchool').on('change', function(){
			var co_id = $('#coID').val();
			var school_id = $(this).val();
			$.ajax({
	            type:'POST',
	            url: base_url+"app/coordinator/get_assign_school_presenter",
	            dataType: "json",
	            data:'co_id='+co_id+'&school_id='+school_id,
	            success:function(response){
	            	var html = '<option value="" selected="">Select Presenter</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.presenter_id+'">'+value.first_name+' '+value.last_name+'</option>'
					});

	            	$('#inputPresenter').html(html);
	            }
	        });

			$.ajax({
	            type:'POST',
	            url: base_url+"app/coordinator/get_assign_school_titles",
	            dataType: "json",
	            data:'school_id='+school_id,
	            success:function(response){
	            	var html = '<option value="" selected="">Select Title</option>';
	            	$(response).each(function(index, value) { 
						html += '<option value="'+value.id+'">'+value.title+'</option>'
					});

	            	$('#inputTitle').html(html);
	            }
	        });
		});
	});
</script>