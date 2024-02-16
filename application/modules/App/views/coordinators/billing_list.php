<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-credit-card"></span> CO Billing</h1>
		
		<div id="sub-menu" class="pull-right">
<!--         	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('order', '<span class="glyphicon glyphicon-shopping-cart"></span> Orders');?></li>
				<li><?php echo render_link('order_add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Order');?></li>
			</ul> -->
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Invoices</li>
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
		/*
		echo validation_errors();

		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open(base_url('app/orders/search_submit'), $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" id="" name="order_no" placeholder="Order number" value="<?php if (isset($filter['order_no'])) {echo $filter['order_no'];}?>" size="10" >
				</div>
				<div class="form-group">
					<input type="text" class="form-control calender-control" id="" name="order_start_date" placeholder="Order date range start" value="<?php if (isset($filter['order_start_date'])) {echo $filter['order_start_date'];}?>" size="15" >
					<input type="text" class="form-control calender-control" id="" name="order_end_date" placeholder="Order date range end" value="<?php if (isset($filter['order_end_date'])) {echo $filter['order_end_date'];}?>" size="15" >
				</div>
				<?php if ($this->session->userdata('role') != 'school_admin') {?>
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
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
					<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('app/orders');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close(); */ ?>

	<?php
		/*
		$attributes = array('class' => 'form-inline status-form', 'id' => 'customer-status-form');
		echo form_open(base_url('app/coordinator/update_status_temporder'), $attributes);
		*/
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
					<!-- <th><input type="checkbox" id="checkall"></th> -->
					<th>Invoice No</th>
	          		<th>Order No</th>
	          		<th>Work Plan No</th>
					<th>School</th>
					<?php if($this->session->userdata('role') != 'coordinator') { ?>
					<th>Coordinator</th>
					<?php } ?>
					<th>Total Payable</th>
					<th>Invoiced on</th>
					<th>Payment Status</th>
					<th>Pay Date</th>
					<?php if($this->session->userdata('role') == 'administrator') { ?>
					<th>Action</th>
					<?php } ?>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php 
	           	##echo '<pre>'; print_r($list); echo '</pre>';  exit();
	            foreach($list as $item) { 
	            ?>
	            <tr>
					<!-- <td><input type="checkbox" name="item_id[<?php // echo $item->id;?>]" class="checkbox-item" value="Y"></td> -->

					<td><?php echo $item->billing_no;?></td>
	            	<td><a href="<?php echo base_url('app/orders/billing/?order_id='.$item->order_id);?>"><?php echo $item->order_no; ?></a></td>
					<td><?php echo ($item->work_plan_number != '') ? $item->work_plan_number : 'N/A'; ?></td>
					<td><?php echo $item->school_name; ?></td>
					<?php if($this->session->userdata('role') != 'coordinator') { ?>
					<td><?php echo $item->coordinator_name; ?></td>
					<?php } ?>
					<td>$<?php echo $item->amount_payable;?></td>				
					<td><?php echo date_display($item->create_date);?></td>
					<td><?php if(!empty($item->paid_on)) echo 'Paid'; else echo 'Unpaid'; ?></td>
					<td><?php echo date_display($item->paid_on);?></td>
					<?php if($this->session->userdata('role') == 'administrator') { ?>
	            	<td class="text-nowrap">
						<a target="_blank" href="<?php echo base_url('app/coordinator/view_invoice_coordinator/'.$item->id);?>" title="Coordinator Invoice<?php //echo $item->id; ?>" class="btn btn-danger btn-xs open_modal_approval"><span class="glyphicon glyphicon-ok-circle"></span> View PDF</a>

						<?php if(empty($item->paid_on)) { ?>
						<a href="<?php echo base_url('app/coordinator/pay_to_coordinator/'.$item->id);?>" title="<?php echo $item->id; ?>" class="btn btn-success btn-xs open_modal_approval"><span class="glyphicon glyphicon-ok-circle"></span> Pay</a>
						<?php } ?>
	            	</td>
	            	<?php } ?>
					
	            </tr>
	            <?php } ?>
	        </tbody>

			<tfoot>
				<tr>
                	<td colspan="16">
						<?php //echo render_buttons(array('delete_temp_order'));?>
					</td>
				</tr>
			</tfoot>

	    </table>
	</div>
	<?php //echo form_close();?>

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

