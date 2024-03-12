<style>
.table>tbody>tr>td, .table>tbody>tr>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	padding: 15px 16px !important;
}
.editable{
	display: none;
}

</style>
<?php
## Logic for return to co order page ##
$modulename = $this->uri->segment(1);
$controller = $this->uri->segment(2);
$method		= $this->uri->segment(3);

if($controller == 'coordinator')
{
	$puturl = $modulename.'/'.$controller.'/'.$method.'/?id='.$co_id;
	$redirecting_url = base_url($puturl);
}
else
	$redirecting_url = '';	
## End of the code ##
?>
<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Manage Orders</h1>
		
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				
				<?php
				$coordinatorId = $this->input->get('id');
				if(isset($coordinatorId) && $coordinatorId != '')
				{
					$searchURL = base_url('app/coordinator/search_submit?id='.$coordinatorId);
					$orderURL = base_url('app/coordinator/main_orders/?id='.$coordinatorId);
					$createURL = base_url('app/coordinator/order_add?id='.$coordinatorId);
					$resetURL =  base_url('app/coordinator/main_orders/?id='.$co_id);
				}
				elseif($this->session->userdata('role') == 'coordinator'){
					$searchURL = base_url('app/coordinator/search_submit');
					$orderURL = base_url('app/coordinator/main_orders');
					$createURL = base_url('app/coordinator/order_add/?ref=main_orders');
					$resetURL =  base_url('app/coordinator/main_orders');
				}
				else
				{
					$searchURL = base_url('app/orders/search_submit');
					$orderURL = base_url('app/orders');
					$createURL = base_url('app/orders/add');
					$resetURL =  base_url('app/orders');
				} 
				?>

				<li class="active"><a href="<?php echo $orderURL; ?>" title=" Orders" class=""><span class="glyphicon glyphicon-shopping-cart"></span> Orders</a></li>
				<li>
					<a href="<?php echo $createURL; ?>" title=" Create New Order" class=""><span class="glyphicon glyphicon-plus-sign"></span> Create New Order</a>
						
				</li>
			</ul>
			<?php if ($this->session->userdata('role') == 'administrator') {?>
				<div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getsession(this.value)">
						<?php foreach ($s_array as $key => $value) {?>
						<option value="<?php echo $key;?>" <?php if ($filter['session'] == $key) {echo "selected";}?>><?php echo $value;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group" style="margin-top: 10px;">
					<span><b>Total hours assigned : <?php echo $totHoursAssgnd?round($totHoursAssgnd->total_assigned_hours):0;?></b></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
					<span><b>Total hours scheduled : <?php echo $totHoursSchedule?round($totHoursSchedule->total_scheduled_hours):0;?></b></span>
				</div>
			<?php } ?>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		
		<?php
		if($this->uri->segment(2) == 'coordinator'){
			echo '<li><a href="'.base_url("app/coordinator").'">Coordinator Management</a></li>';
		}
		if(($this->uri->segment(2) == 'orders' || $this->uri->segment(2) == 'coordinator' || $this->uri->segment(3) == 'index') && $this->uri->segment(4) == ''){
			echo '<li class="active">Manage Orders</li>';
		}
		if($this->uri->segment(5) == 'pending'){
			echo '<li><a href="'.base_url("app/orders").'">Manage Orders</a></li>';
			echo '<li class="active">Pending Orders</li>';
		}
		if($this->uri->segment(5) == 'approved'){
			echo '<li><a href="'.base_url("app/orders").'">Manage Orders</a></li>';
			echo '<li class="active">Approved Orders</li>';
		}

		?>
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
		echo validation_errors();
		
		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open($searchURL, $attributes);
	?>

	<fieldset>
		<!-- <legend><span class="glyphicon glyphicon-filter"></span> Filters</legend> -->
		<!-- <legend>
			<div class="row">
				<div class="col-md-1" id="button" style="cursor:pointer;"><span class="glyphicon glyphicon-filter"></span> Filters</div>
				<div class="col-md-11"></div>
			</div>
		</legend> -->
		<!-- <div class="row"> -->
		<!-- <div class="row" id="item" style="display:none";>
			<input type="hidden" id="hdnSession" name="hdnSession" value="<?php echo $filter['session']?>"> -->
			<?php if ($this->session->userdata('role') == 'administrator') {?>
				<legend>
					<div class="row">
						<div class="col-md-1" id="button" style="cursor:pointer;"><span class="glyphicon glyphicon-filter"></span> Filters</div>
						<div class="col-md-11"></div>
					</div>
				</legend>
				<div class="row" id="item" style="display:none";>
					<input type="hidden" id="hdnSession" name="hdnSession" value="<?php echo $filter['session']?>">
			<?php }else{ ?>
				<legend>
					<div><span class="glyphicon glyphicon-filter"></span> Filters</div>
				</legend>
				<div class="row">
			<?php } ?>

			<div class="col-md-12">
				<div class="form-group" style="width:23.5%;">
					<input type="text" class="form-control" id="order_no" name="order_no" placeholder="Order number" value="<?php if (isset($filter['order_no'])) {echo $filter['order_no'];}?>" size="25" >
				</div>
				<div class="form-group">
					<input type="text" class="form-control calender-control" id="order_start_date" name="order_start_date" placeholder="Order date range start" value="<?php if (isset($filter['order_start_date']) && $filter['order_start_date'] != '') {echo date('m/d/Y', strtotime($filter['order_start_date']));}?>" size="15" >
					<input type="text" class="form-control calender-control" id="order_end_date" name="order_end_date" placeholder="Order date range end" value="<?php if (isset($filter['order_end_date']) && $filter['order_end_date'] != '') {echo date('m/d/Y', strtotime($filter['order_end_date']));}?>" size="15" >
				</div>
				<?php if ($this->session->userdata('role') == 'administrator') {?>
				<div class="form-group">
					<select name="school" class="form-control" id="school_list">
						<option value="" selected>Select a school</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($filter['school'] == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
				</div>
				<?php }?>
				<?php if ($this->session->userdata('role') == 'coordinator') {?>
                    <div class="form-group">
                    <select name="presenter" class="form-control" id="presenter_list">
                        <option value="" selected>Select a presenter</option>
                        <?php foreach ($presenters as $item) {?>
                        <option value="<?php echo $item->presenter_id;?>" <?php if ($filter['presenter'] == $item->presenter_id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
                        <?php }?>
                    </select>
                    </div>
                <?php }else{ ?>
                    <div class="form-group">
                    <select name="presenter" class="form-control" id="presenter_list">
                        <option value="" selected>Select a presenter</option>
                        <?php foreach ($presenters as $item) {?>
                        <option value="<?php echo $item->id;?>" <?php if ($filter['presenter'] == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
                        <?php }?>
                    </select>
                    </div>
                <?php } ?>
				<div class="form-group">
					<select name="status" class="form-control" id="status_list">
						<option value="" selected>Select order status</option>
						<option value="pending" <?php if ($filter['status'] == 'pending') { echo "selected";}?>>Pending</option>
						<option value="approved" <?php if ($filter['status'] == 'approved') { echo "selected";}?>>Approved</option>
						<option value="cancelled" <?php if ($filter['status'] == 'cancelled') { echo "selected";}?>>Cancelled</option>
					</select>
				</div>
				<div class="form-group" style="width:100%; text-align:right; margin:10px 0 0 0;">
                	<!-- <button type="button" class="btn btn-default" onclick="window.location='<?php echo $resetURL; ?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
					<button type="button" class="btn btn-default" onclick="resetForm();"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close();?>

	<?php
		$actionURL = ($this->uri->segment(2) == 'orders') ? base_url('app/orders/update_status') : base_url('app/coordinator/update_status/co_order?id='.$this->input->get('id'));
		$attributes = array('class' => 'form-inline status-form', 'id' => 'customer-status-form');
		echo form_open($actionURL, $attributes);
	?>
<!-- <?//php echo '<pre>'; print_r($schools);die; ?> -->
	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
	          		<th>Order No</th>
	          		<th>Work Plan No</th>
					<th>School</th>
					<th>Presenter(Req./ Assigned)</th>
					<th>Title</th>
					<th>Program</th>
					<th>Hours</th>
					<!--<th>Hourly Rate</th>-->
					<th>Order Date</th>
	          		<!--<th>Order Date</th>-->
					<th>Status</th>
					<?php if ($this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'coordinator') {?>
					<th>Action</th>
					<?php }?>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($orders) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($orders as $item) { ?>
	            <tr>
					<td><input type="checkbox" name="item_id[<?php echo $item->id;?>]" class="checkbox-item" value="Y"></td>
					<td><a class="default_value_<?php echo $item->id ?>" href="<?php echo base_url('app/orders/billing/?order_id='.$item->id);?>"><?php echo $item->order_no;?></a><input class="editable edit_input_<?php echo $item->id ?>" type="text" value="<?php echo $item->order_no;?>"></td>
	            	<td><span class="default_value_<?php echo $item->id ?>"><?php echo ($item->work_plan_number != '') ? $item->work_plan_number : 'N/A';?></span><input class="editable edit_input_<?php echo $item->id ?>" id="work_plan_number" type="text" value="<?php echo $item->work_plan_number;?>"><div id="wp_no_error" class="help-block with-errors"></div></td>
	            	<td>
						<span class="default_value_<?php echo $item->id ?>"><?php echo $item->school_name;?></span>
						<select name="school_id" class="editable edit_input_<?php echo $item->id ?>" id="inputSchool" required>
							<option value="" selected>Select School</option>
							<?php foreach ($schools as $sch) {?>
								<option value="<?php echo $sch->id;?>" <?php if ($item->school_name == $sch->meta['school_name']) {echo "selected";}?>><?php echo $sch->meta['school_name'];?></option>
							<?php }?>
						</select>
					</td>
					<td><?php //echo $item->teacher_name;?><a class="default_value_<?php echo $item->id ?>" href="javascript:void(0);" title="<?php echo $item->id;?>" class="open_modal">View Presenter</a>
					<span><select name="presenter_id" class="editable edit_input_<?php echo $item->id ?>" id="inputPresenter">
						<option value="" selected>Select Presenter</option>
						<?php foreach ($presenters as $pres) {?>
							<option value="<?php echo $pres->id;?>" <?php if (set_value('presenter_id') == $pres->id) {echo "selected";}?>><?php echo $pres->first_name." ".$pres->last_name;?></option>
						<?php }?>
					</select></span>
				</td>
					<td><span class="default_value_<?php echo $item->id ?>"><?php echo $item->title_name;?></span>
					<select name="title_id" class="editable edit_input_<?php echo $item->id ?>" id="inputTitle" required>
						<option value="" selected>Select Title</option>
						<?php foreach ($titles as $title) {?>
							<option value="<?php echo $title->id;?>" <?php if (set_value('title_id') == $title->id) {echo "selected";}?>><?php echo $title->name;?></option>
						<?php }?>
					</select>
				</td>
					<?php if(!empty($item->programName)){?><td><span class="default_value_<?php echo $item->id ?>"><?php echo $item->programName;?></span><input class="editable edit_input_<?php echo $item->id ?>" type="text" value="<?php echo $item->programName;?>"></td>
						<?php } else{ ?>
						<td>N/A</td>
					<?php } ?>
					<td><?php echo $item->hours;?></td>
					<!--<td><?php echo price_display($item->hourly_rate);?></td>-->					
					<td><span class="default_value_<?php echo $item->id ?>"><?php echo date_display($item->booking_date);?></span><input class="editable edit_input_<?php echo $item->id ?>" type="text" value="<?php echo $item->booking_date;?>"></td>
					<!--<td><?php echo datetime_display($item->created_on);?></td>-->
	            	<td><?php echo order_status_display($item->status);?></td>
					<?php if ($this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'coordinator') {?>
	            	<td class="text-nowrap">
					<span class="default_value_<?php echo $item->id ?>" onclick="editOrder(<?php echo $item->id; ?>);"><a  href="javascript:void(0);" id="editable editbtn_<?php echo $item->id; ?>" class="btn btn-success btn-xs "><span class="glyphicon glyphicon-ok-circle"></span> Edit</a></span>
					<span class="editable edit_input_<?php echo $item->id ?>"><a id="savebtn_<?php echo $item->id; ?>" href="javascript:void(0);" title="<?php echo $item->id; ?>" class="btn btn-success btn-xs savebtn"><span class="glyphicon glyphicon-ok-circle"></span> Save & Cancel</a></span>
					<br>
						<?php
							//echo render_action(array('delete'), $item->id);
							if ($item->status == 'pending') {
								if($this->session->userdata('role') == 'administrator')
									{
						?>
										<a href="javascript:void(0);" title="<?php echo $item->id; ?>" class="btn btn-success btn-xs open_modal_approval"><span class="glyphicon glyphicon-ok-circle"></span> Approve</a>
						<?php
									}
									/*
									echo anchor('/app/orders/change_status/approved/'.$item->id, '<span class="glyphicon glyphicon-ok-circle"></span> Approve', array('title' => 'Approve', 'class' => 'btn btn-success btn-xs open_modal_approval'));
									*/

								if($this->session->userdata('role') == 'administrator')
									echo anchor('/app/orders/change_status/cancelled/'.$item->id, '<span class="glyphicon glyphicon-ban-circle"></span> Cancel', array('title' => 'Cancel', 'class' => 'btn btn-warning btn-xs'));

							}
							if ($item->status == 'approved') {
								if($this->session->userdata('role') == 'administrator')
									echo anchor('/app/orders/assign_hours/'.$item->id, '<span class="glyphicon glyphicon-ok-circle"></span> Assign Hours', array('title' => 'Assign Hours', 'class' => 'btn btn-success btn-xs'));
						    }

							if($this->session->userdata('role') == 'coordinator') 
							{
								$flag 		= can_generate_invoice($item->id);
								$disabled 	= disable_invoice_button($item->id);

								// echo "<pre>";print_r($flag);

								if(!$flag)
								{
									if($disabled == 0)
										echo anchor('/app/coordinator/generate_invoice/'.$item->id, '<span class="glyphicon glyphicon-ok-circle"></span> Generate Invoice', array('title' => 'Generate Invoice', 'class' => 'btn btn-success btn-xs'));
									else
										echo '<span class="glyphicon glyphicon-ok-circle"></span> Invoice Generated</a>';
								}
							}

						?>
	            	</td>
					<?php }?>
	            </tr>
	            <?php } ?>
	        </tbody>
			<?php if ($this->session->userdata('role') == 'administrator') {?>
			<tfoot>
				<tr>
                	<td colspan="16">
						<?php echo render_buttons(array('delete'));?>
						<!--<button name="operation" type="submit" id="btn_status_approve" value="approved" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok-circle"></span> Approve</button>
						<button name="operation" type="submit" id="btn_status_cancel" value="cancelled" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>-->
					</td>
				</tr>
			</tfoot>
			<?php }?>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php echo $this->pagination->create_links(); ?>
</div>

<!-- Set Payment Modal -->
<div class="modal fade bs-example-modal-sm" id="viewSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Subscription History</h4>
		    </div>
		    <div class="modal-body">
				<!-- Remote data loads here -->
				<span class="glyphicon glyphicon-refresh"></span> Loading please wait ...
			</div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
	</div>
</div>

<!-- Topic Modal -->
<div class="modal fade" id="presentarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">

		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Requested / Assigned Presenter</h4>
		    </div>
		    <div class="modal-body presenter-body">
				
			</div>
		    <div class="modal-footer">

		    </div>
		</div>

	</div>
</div>

<!-- Topic Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">

		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Fill the information</h4>
		    </div>

		    <div class="modal-body">
				
			<?php
				$attributes = array('class' => '', 'name' => 'order_approval', 'id' => 'order_approval', 'role' => 'form');
				echo form_open_multipart(base_url('app/orders/change_status/approved/'), $attributes);							
			?>       
			<div class="row">
				<div class="col-md-12 form-group">
					<label>Order Number</label>
	                <input type="text" name="order_no" id="provider_uploaded_file" class="form-control" required/>
				</div>

				<div class="col-md-12 form-group">
					<button type="submit" class="btn btn-primary">Update Data</button>
					<input type="hidden" name="order_id" id="order_id" value=""/>
					<?php if(!empty($redirecting_url)) { ?>
					<input type="hidden" name="redirection" id="redirection" value="<?php echo $redirecting_url; ?>" />
					<?php } ?>
				</div>				
			</div>
			<?php
				echo form_close();
			?>

			</div>

		    <div class="modal-footer">

		    </div>
		</div>

	</div>
</div>

<script>
	// $(document).ready(function(){
	var prev_work_plan=$('#work_plan_number').val();
	
	$( "#button" ).click(function() {
		$( "#item" ).toggle();
	});

	function getsession(session){
		$('#hdnSession').val(session);
		$("#order-search-form").submit();
	}
	function resetForm(){
		sessionId = $('#hdnSession').val();
		$('#presenter_list').val('');
		$('#school_list').val('');
		$('#status_list').val('');
		$('#order_no').val('');
		$('#order_start_date').val('');
		$('#order_end_date').val('');
		$("#order-search-form").submit();
	}

	// $('.editbtn').on('click',function(){
	// // alert('clicked');
	// var tid = $(this).attr('data-id');
	// $('.default_value').css('display', 'none');
	// $('.edit_input').css('display', 'block');

	// });

	function editOrder(id){
		$('.default_value_'+id).css('display', 'none');
		$('.edit_input_'+id).css('display', 'block');
	}

	
	$('#inputSchool').on('change', function(){
		console.log('trigger');
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
			// // For school coordinator
			// $.ajax({
	        //     type:'POST',
	        //     url: base_url+"app/orders/get_assign_school_coordinator",
	        //     dataType: "json",
	        //     data:{school_id: school_id},
	        //     success:function(response){
	        //     	var html = '<option value="" selected="">Select Coordinator</option>';
	        //     	$(response).each(function(index, value) { 
			// 			html += '<option value="'+value.coordinator_id+'">'+value.first_name+' '+value.last_name+'</option>'
			// 		});

	        //     	$('#coordinator_id').html(html);
	        //     }
	        // });
		});

		$('#work_plan_number').on('keyup',function(){
			$('#wp_no_error').html();
			// $('#create_order').prop('disabled',true);
			var programVal=$(this).val();
			// alert(programVal);
			// $('#wp_no').val(programVal);
			if(!programVal || programVal==prev_work_plan){
				return;
			}else{
			$.ajax({
	            type:'POST',
	            url: base_url+"app/orders/check_wp_status",
	            dataType: "json",
	            data:{wp_no: programVal},
	            success:function(response){
	            	// var html = '<option value="" selected="">Select Presenter</option>';
	            	// $(response).each(function(index, value) { 
					// 	html += '<option value="'+value.presenter_id+'">'+value.first_name+' '+value.last_name+'</option>'
					// });

	            	// $('#inputPresenter').html(html);
					if(response.success){
						// var html = '<div id="wp_no_error" class="help-block with-errors"></div>'
						$('#wp_no_error').html('');
						$('.savebtn').prop('disabled',false);
						
						
					}else{
						$('#wp_no_error').html(response.msg).css('color', 'red');
						$('.savebtn').prop('disabled',true);
					}
	            }
	        });
		}
		});



	// });
</script>

