<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Manage Orders</h1>
		
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-shopping-cart"></span> Orders');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Order');?></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Orders</li>
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
		echo form_open(base_url('app/orders/search_submit'), $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" style="width:23.5%;">
					<input type="text" class="form-control" id="" name="order_no" placeholder="Order number" value="<?php if (isset($filter['order_no'])) {echo $filter['order_no'];}?>" size="25" >
				</div>
				<div class="form-group">
					<input type="text" class="form-control calender-control" id="" name="order_start_date" placeholder="Order date range start" value="<?php if (isset($filter['order_start_date'])) {echo $filter['order_start_date'];}?>" size="15" >
					<input type="text" class="form-control calender-control" id="" name="order_end_date" placeholder="Order date range end" value="<?php if (isset($filter['order_end_date'])) {echo $filter['order_end_date'];}?>" size="15" >
				</div>
				<?php if ($this->session->userdata('role') == 'administrator') {?>
				<div class="form-group">
					<select name="school" class="form-control" >
						<option value="" selected>Select a school</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($filter['school'] == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
				</div>
				<?php }?>
				<div class="form-group">
					<select name="presenter" class="form-control" >
						<option value="" selected>Select a presenter</option>
						<?php foreach ($presenters as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($filter['presenter'] == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
					<select name="status" class="form-control" >
						<option value="" selected>Select order status</option>
						<option value="pending" <?php if ($filter['status'] == 'pending') { echo "selected";}?>>Pending</option>
						<option value="approved" <?php if ($filter['status'] == 'approved') { echo "selected";}?>>Approved</option>
						<option value="cancelled" <?php if ($filter['status'] == 'cancelled') { echo "selected";}?>>Cancelled</option>
					</select>
				</div>

				<div class="form-group" style="width:100%; text-align:right; margin:10px 0 0 0;">
                					<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('app/orders');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

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
		$attributes = array('class' => 'form-inline status-form', 'id' => 'customer-status-form');
		echo form_open(base_url('app/orders/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
	          		<th>Order No</th>
					<th>School</th>
					<th>Presenter</th>
					<th>Title</th>
					<th>Hours</th>
					<!--<th>Hourly Rate</th>-->
					<th>Order Date</th>
	          		<!--<th>Order Date</th>-->
					<th>Status</th>
					<?php if ($this->session->userdata('role') == 'administrator') {?>
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
					<td><a href="<?php echo base_url('app/orders/billing/?order_id='.$item->id);?>"><?php echo $item->order_no;?></a></td>
	            	<td><?php echo $item->school_name;?></td>
					<td><?php echo $item->teacher_name;?></td>
					<td><?php echo $item->title_name;?></td>
					<td><?php echo $item->hours;?></td>
					<!--<td><?php echo price_display($item->hourly_rate);?></td>-->					
					<td><?php echo date_display($item->booking_date);?></td>
					<!--<td><?php echo datetime_display($item->created_on);?></td>-->
	            	<td><?php echo order_status_display($item->status);?></td>
					<?php if ($this->session->userdata('role') == 'administrator') {?>
	            	<td class="text-nowrap">
						<?php
							//echo render_action(array('delete'), $item->id);
							if ($item->status == 'pending') {
								echo anchor('/app/orders/change_status/approved/'.$item->id, '<span class="glyphicon glyphicon-ok-circle"></span> Approve', array('title' => 'Approve', 'class' => 'btn btn-success btn-xs'));
								echo anchor('/app/orders/change_status/cancelled/'.$item->id, '<span class="glyphicon glyphicon-ban-circle"></span> Cancel', array('title' => 'Cancel', 'class' => 'btn btn-warning btn-xs'));
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

