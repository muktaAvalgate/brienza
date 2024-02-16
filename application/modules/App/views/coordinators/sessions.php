<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-calendar-check-o"></span> List Sessions</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
						<li class="active"><a href="<?php echo base_url('app/coordinator/sessions');?>"><span class="fa fa-calendar-check-o"></span> Sessions</a></li>
					</ul>
        </div>

    </div>
</div>





<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Session List</li>
	</ol>

		<?php
		echo validation_errors();
		$searchURL =  base_url('app/coordinator/search_submit_n?id='.$this->input->get('id'));
		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open($searchURL, $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">

				<div class="form-group" >
					<input type="text" class="form-control calender-control" id="" name="start_date" placeholder="Session Date" value="<?php if (isset($filter['start_date']) && $filter['start_date'] != '') { echo date('m/d/Y', strtotime($filter['start_date']));}?>"  >
					
				</div>

				<?php //if ($this->session->userdata('role') == 'administrator') {?>
				<div class="form-group" >
					<select name="school" class="form-control" >
						<option value="" selected>Select a school</option>
						<?php foreach ($search as $item) {?>
						<option value="<?php echo $item->school_id;?>" <?php if ($filter['school'] == $item->school_id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
				</div>
				<?php //}?>
				<div class="form-group" >
					<select name="presenter" class="form-control" >
						<option value="" selected>Select a presenter</option>
						<?php foreach ($search as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($filter['presenter'] == $item->id) {echo "selected";}?>><?php echo $item->presenter;?></option>
						<?php }?>
					</select>
				</div>
				
				<div class="form-group" >
					<select name="status" class="form-control" >
						<option value="" selected>Select Order Status</option>
						<option value="approved" <?php if ($filter['status'] == 'approved') { echo "selected";}?>>Approved</option>

						<option value="payment_sent" <?php if ($filter['status'] == 'payment_sent') { echo "selected";}?>>Payment sent</option>

						<option value="completed" <?php if ($filter['status'] == 'completed') { echo "selected";}?>>Completed</option>

						<option value="invoice_created" <?php if ($filter['status'] == 'invoice_created') { echo "selected";}?>>Invoice created</option>

						<option value="draft_attached" <?php if ($filter['status'] == 'draft_attached') { echo "selected";}?>>Draft attached</option>

						<option value="confirm_hours" <?php if ($filter['status'] == 'confirm_hours') { echo "selected";}?>>Confirm hours</option>

						<option value="create_invoice" <?php if ($filter['status'] == 'create_invoice') { echo "selected";}?>>Create invoice</option>

						<option value="create_log" <?php if ($filter['status'] == 'create_log') { echo "selected";}?>>Create log</option>

						<option value="log_sent_-_awaiting_principal_signature" <?php if ($filter['status'] == 'log_sent_-_awaiting_principal_signature') { echo "selected";}?>>Log sent - awaiting principal signature</option>

						<option value="awaiting_review" <?php if ($filter['status'] == 'awaiting_review') { echo "selected";}?>>Awaiting Review</option>

						<option value="hours_scheduled" <?php if ($filter['status'] == 'hours_scheduled') { echo "selected";}?>>Hours scheduled</option>
					</select>
				</div>

				<div class="form-group">
					<button type="button" class="btn btn-default" onclick="window.location='https://schooldev.managed.center/app/coordinator/sessions'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

				   <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				</div>
				<?php 
				// if(isset($co_id)){
				// 		$resetURL =  base_url('app/coordinator/main_orders/?id='.$co_id);
				// 	}else{
				 		$resetURL =  base_url('app/coordinator/sessions');
				// 	}
				?>
				

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>


	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
						<th>Order No.</th>
						<th>Session</th>
						<th>Presenter</th>
						<th>School</th>
						<th>Hours</th>
						<th>Status</th>
						<!-- <th>Action</th> -->
	        </tr>
	        </thead>
	        <tbody>
	            <?php 
	            //echo "<pre>";print_r($total_hours);die;
	            if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
							<?php 
							//echo '<pre>'; print_r($list); echo '</pre>';
							foreach($list as $session) { ?>
	            <tr>		<!-- <td><a href="javascript:void(0);" title="<?php //echo $item['student_id'];?>" class="open_modal"><u><?php //echo $item['last_name']; ?></u></a></td> -->
								<td><?php echo $session->order_no; ?></td>
								<td><?php echo date_display($session->start_date, "m/d/Y");?> @ <?php echo time_display($session->start_date, true);?> to <?php echo time_display($session->end_date, true);?></td>
								<td><?php echo $session->presenter; ?></td>
								<td><?php echo $session->meta['school_name']; ?></td>
								<td><?php echo $session->total_hours.' Hours';?></td>
								<td><?php echo $session->status;?></td>
<!-- 								<td class="text-nowrap">
									<a href="<?php //echo base_url('app/coordinator/assign_presenter_school_list/'.$teacher['id']);?>" title="Assign Presenter" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> View Presenter</a>
														
								</td> -->
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
          <td colspan="8">
						&nbsp; 
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>


	<?php echo $this->pagination->create_links(); ?>
</div>



<?php
	function format_date($str) {
		$str = urldecode($str);
		return str_replace('~', '/', $str);
	}
?>