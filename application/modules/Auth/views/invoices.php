<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Billed Orders</h1>
		
		<div id="sub-menu" class="pull-right">
			<?php /* ?>
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-shopping-cart"></span> Orders');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Order');?></li>
			</ul>
			<?php */ ?>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Billed Orders</li>
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
		echo form_open(base_url('auth/auth/search_submit'), $attributes);
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

				<div class="form-group">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
					<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('totalbilled');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
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
	          		<th>Order No</th>
	          		<th>Work Plan No</th>
					<th>School</th>
					<th>Presenter<br/>(Req./ Assigned)</th>
					<th>Title</th>
					<th>Hours</th>
					<th>Amount Paid To Brienza</th>
					<th>Unbilled Amount Brienza</th>
					<th>Amount Paid To Presenter</th>
					<th>Unbilled Amount Presenter</th>
					<th>Order Date</th>
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
					<!-- <td><a href="<?php //echo base_url('app/orders/billing/?order_id='.$item->id);?>"><?php echo $item->order_no;?></a></td> -->
					<!-- <td><a href="javascript:void(0);"><?php //echo $item->order_no;?></a></td> -->
					<td><?php echo $item->order_no;?></td>
					<td><?php echo ($item->work_plan_number != '') ? $item->work_plan_number : 'N/A';?></td>
	            	<td><?php echo $item->school_name;?></td>
	            	<td><a href="javascript:void(0);" title="<?php echo $item->id;?>" class="open_modal">View Presenter</a></td>
					<!-- <td><?php if ($item->status == 'pending') echo 'N/A'; ?></td> -->

					<td><?php echo $item->title_name;?></td>
					<td><?php echo $item->hours;?></td>
					<td><?php echo '$'.number_format(($item->brienza_price*$item->paid_to_brienza), 2);?></td>
					<td><?php echo '$'.number_format(($item->brienza_price*($item->hours-$item->paid_to_brienza)), 2);?></td>
					<td>
						<?php 
						// echo "<pre>";print_r($item->assigned_presenter);die;
							$sumArray = array();

							foreach ($item->assigned_presenter as $k=>$subArray) {
							  foreach ($subArray as $id=>$value) {
							    $sumArray[$id]=$value;
							  }
							}
							if(isset($sumArray['paid']))
							{
							echo  '$'.number_format($sumArray['paid'], 2);
						    }else{
						    	echo 'N/A';
						    }
						?>
					
				</td>
				<td>
					<?php 
					$sumArray1 = array();

						foreach ($item->assigned_presenter as $k1=>$subArray1) {
						  foreach ($subArray1 as $id=>$value1) {
						    $sumArray1[$id]=$value1;
						  }
						}
						if(isset($sumArray1['unbilled_payment']))
						{
						echo  '$'.number_format($sumArray1['unbilled_payment'], 2);
					    }else{
					    	echo 'N/A';
					    }?>
					    	
			    </td>
				<td><?php echo date_display($item->booking_date);?></td>

	            	<td class="text-nowrap">
						<?php
						echo anchor('/auth/get_invoice_details/'.$item->id, '<span class="glyphicon glyphicon-ok-circle"></span> View Details', array('title' => 'View Details', 'class' => 'btn btn-success btn-xs'));
						?>
	            	</td>
					
	            </tr>
	            <?php } ?>
	        </tbody>
			
			<tfoot>
				<tr>
                	<td colspan="16">
                		<button type="button" class="btn btn-primary" onclick="window.location.href = '<?php echo base_url('totalbilled/export_excel/'.$this->uri->segment(4)) ?>'"><span class="glyphicon glyphicon-download"></span> Export to Excel</button>
                	</td>
				</tr>
			</tfoot>
			
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

		    <div class="modal-body presenter-body">
				
			<?php
				$attributes = array('class' => '', 'name' => 'order_approval', 'id' => 'order_approval', 'role' => 'form');
				echo form_open_multipart(base_url('app/orders/change_status/approved/'), $attributes);							
			?>       
			<div class="row">
				<div class="col-md-12 form-group">
					<label>Order Number</label>
	                <input type="text" name="order_no" id="provider_uploaded_file" class="form-control" />
				</div>

				<div class="col-md-12 form-group">
					<label>Work Plan Number</label>
	                <input type="text" name="work_plan_number" id="work_plan_number" class="form-control" />
				</div>

				<div class="col-md-12 form-group">
					<button type="submit" class="btn btn-primary">Update Data</button>
					<input type="hidden" name="order_id" id="provider_id" value=""/>
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