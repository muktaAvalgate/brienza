<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> List of Paid Orders</h1>
		<div id="sub-menu" class="pull-right">

        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('totalbilled');?>">Paid Orders</a></li>
		<li class="active">Paid Order Details</li>
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
	<div class="row">

		<div class="col-xs-4">
			<fieldset>
				<legend>Order Information</legend>
				<div class="row">
					<div class="col-sm-4"><strong>WR</strong></div> 
					<div class="col-sm-8">
						<ul class="list-group">
							<li class="list-group-item"><?php echo $order_details['order_no']; ?></li>
							<li class="list-group-item"><?php echo $order_details['hours']." Total hour(s)"; ?></li>
							<li class="list-group-item"><?php echo $order_details['hour_remains']." hour(s) remainning to bill."; ?></li>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4"><strong>Title</strong></div> 
					<div class="col-sm-8">
						<ul class="list-group">
								<li class="list-group-item"><?php echo $order_details['title']; ?></li>
						</ul>				
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4"><strong>Total</strong></div> 
					<div class="col-sm-8">
						<ul class="list-group">
							<li class="list-group-item">$<?php echo number_format($order_details['total_amount_billed'], 2); ?></li>
							<!-- <li class="list-group-item">--</li> -->
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4"><strong>Remaining</strong></div> 
					<div class="col-sm-8">
						<ul class="list-group">
							<li class="list-group-item">$<?php echo number_format($order_details['total_amount_unbilled'], 2); ?></li>
							<!-- <li class="list-group-item">--</li> -->
						</ul>				
					</div>
				</div>			

				<div class="row">
					<div class="col-sm-4"><strong>School</strong></div> 
					<div class="col-sm-8">
						<ul class="list-group">
							<li class="list-group-item"><?php echo $order_details['school_name']; ?></li>
						</ul>					
					</div>
				</div>						

			</fieldset>				
		</div>

		<div class="col-xs-8">

			<fieldset>
				<legend>Schdeule Billing Info</legend>

				<!-- List data begins here -->
				<div class="table-responsive">
					<table class="table">

						<thead class="thead-dark">
							<tr>
								<th scope="col">Order Number</th>
								<th scope="col">Hours</th>
								<th scope="col">Amount</th>
								<th scope="col">Check Number</th>								
							</tr>
						</thead>

						<tbody>
							
							<?php
							if(!empty($schedule_list[0]))
							{
								$serrial = 1;
								foreach($schedule_list as $innerval)
								{
							?>
									<tr>
										<td>TBD-<?php echo $order_details['order_no']."-".$serrial; ?></td>
										<td><?php echo $innerval['total_hours']." Hours"; ?></td>
										<td><?php echo "$".number_format($innerval['total_hours']*$order_details['brienza_price'], 2); ?></td>
										<td width="40%">
											<?php if($innerval['check_number'] !=''){ 
												$cheq_val = $innerval['check_number'];
												$readonly = 'readonly';
												$sbmtBtn = 'display : none';
												$editBtn = 'display : block';
												$placeholder = $innerval['check_number'];
											}else{ 
												$cheq_val = '';
												$readonly = '';
												$sbmtBtn = 'display : block';
												$editBtn = 'display : none';
												$placeholder = 'Enter Cheque No.';
											} ?>
											<div class="col-sm-12">
												<div class="col-sm-8">
													<input type="text" class="form-control" id="cheqNo_<?php echo $innerval['id']; ?>" name="cheq_no" placeholder="Enter Check No." title="<?php echo $placeholder; ?>" value="<?php echo $cheq_val; ?>" <?php echo $readonly; ?>>
												</div>
												<div class="col-sm-4">
													<a href="javascript:void(0)" style="<?php echo $sbmtBtn; ?>" class="btn btn-primary btn-xs cheqSbtBtn" id="sbmt_<?php echo $order_details['id'].'_'.$innerval['id']; ?>" data-schedule-id="<?php echo $innerval['id']; ?>" data-order-id="<?php echo $order_details['id']; ?>">Submit</a>

													<a href="javascript:void(0)" style="<?php echo $editBtn; ?>" title="Edit" class="btn btn-primary btn-xs edit_btn" id="edit_<?php echo $order_details['id'].'_'.$innerval['id']; ?>" data-schedule-id="<?php echo $innerval['id']; ?>" data-order-id="<?php echo $order_details['id']; ?>">Edit</a>

													<a href="javascript:void(0)" style="display : none" title="Cancel" class="btn btn-danger btn-xs cancel_btn" id="cncl_<?php echo $order_details['id'].'_'.$innerval['id']; ?>" data-schedule-id="<?php echo $innerval['id']; ?>" data-order-id="<?php echo $order_details['id']; ?>"> Cancel</a>
												</div>
											</div>
												
										</td>
									</tr>
							<?php
									$serrial++;
								}
							?>
									<tr>
										<td><strong>TOTAL : </strong></td>
										<td> <?php echo $total_hours." Hours"; ?></td>
										<td> <?php echo "$".number_format($total_hours*$order_details['brienza_price'],2); ?></td>
									</tr>
							<?php	
							}
							else
							{
							?>
							<tr>
								<td width="100%">No Data Found</td>
							</tr>
							<?php
							}
							?>
						</tbody>

					</table>
				</div>			
				<!-- List data ends here -->
				
				<?php /* if ($this->session->userdata('role') == 'administrator') {?>
					<div class="form-group">
						<label for="inputSchool" class="col-sm-3 control-label">School *</label>
						<div class="col-sm-7">
							<select name="school_id" class="form-control" id="inputSchool" onchange="javascript:getschool_id(this.value);" required>
								<option value="" selected>Select School</option>
								<?php foreach ($schools as $item) {?>
									<option value="<?php echo $item->id;?>" <?php if (set_value('school_id') == $item->id || (!empty($_GET['school_id']) && $_GET['school_id'] == $item->id)) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
								<?php }?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<?php }?>

					<div class="form-group">
						<label for="inputSchool" class="col-sm-3 control-label">Coordinators </label>
						<div class="col-sm-7">
							<select name="coordinator_id" class="form-control" id="coordinator_id">
								<option value="" selected>Select Coordinators</option>
								<?php foreach ($coordinator_list as $item2) {?>
									<option value="<?php echo $item2->id;?>" <?php if (set_value('coordinator_id') == $item2->id) {echo "selected";}?>><?php echo $item2->first_name." ".$item2->last_name ;?></option>
								<?php }?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
							

				<div class="form-group">
					<label for="inputPresenter" class="col-sm-3 control-label">Requested Presenter</label>
					<div class="col-sm-7">
						<select name="presenter_id" class="form-control" id="inputPresenter">
							<option value="" selected>Select Presenter</option>
							<?php foreach ($presenters as $item) {?>
								<option value="<?php echo $item->id;?>" <?php if (set_value('presenter_id') == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?><!-- (Hourly Rate: <?php echo price_display($item->meta['rate']);?>)--></option>
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
						<input type="number" name="hour" min="1" class="form-control" id="inputHour" placeholder="Enter hour" value="1" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
				<?php */ ?>  
				
			</fieldset>
		</div>
		
	</div>							

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
		        <h4 class="modal-title" id="myModalLabel">Choose Topicc (optional)</h4>
		    </div>
		    <div class="modal-body">
				
			</div>
		    <div class="modal-footer">
				<input type="hidden" name="title_id" id="title_id">
				<input type="hidden" name="hour" id="hour">
				<input type="hidden" name="booking_date" id="booking_date">
				<input type="hidden" name="presenter_id" id="presenter_id">
				<input type="hidden" name="school_id" id="school_id">
				<input type="hidden" name="coordinator_id" id="coordinator_id2">
				
				<button type="submit" class="btn btn-primary" id="btn_place_order">Confirm Order</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
		<?php echo form_close();?>
	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('.cheqSbtBtn').on('click', function(e){
			var orderId = jQuery(this).attr('data-order-id');
			var scheduleId = jQuery(this).attr('data-schedule-id');
			var cheqNo = jQuery('#cheqNo_'+scheduleId).val();

			if(cheqNo == ''){
				alert('please fill cheque number');
			}else{
				jQuery.ajax({
					type: "POST",
					url: base_url+'app/orders/save_cheque_no',
					data: { order_schedule_id:scheduleId, cheque_no:cheqNo },
					success: function(response){
						window.location.href=base_url+'auth/get_invoice_details/'+orderId;
					}
				});
			}
		});

		jQuery('.edit_btn').on('click', function(e){
			var orderId = jQuery(this).attr('data-order-id');
			var scheduleId = jQuery(this).attr('data-schedule-id');

			jQuery('#sbmt_'+orderId+'_'+scheduleId).show();
			jQuery('#cncl_'+orderId+'_'+scheduleId).show();
			jQuery('#edit_'+orderId+'_'+scheduleId).hide();
			jQuery('#cheqNo_'+scheduleId).attr('readonly', false);
		});
		
		jQuery('.cancel_btn').on('click', function(e){
			var orderId = jQuery(this).attr('data-order-id');
			var scheduleId = jQuery(this).attr('data-schedule-id');

			jQuery('#sbmt_'+orderId+'_'+scheduleId).hide();
			jQuery('#cncl_'+orderId+'_'+scheduleId).hide();
			jQuery('#edit_'+orderId+'_'+scheduleId).show();
			jQuery('#cheqNo_'+scheduleId).attr('readonly', true);
		});
	});
</script>