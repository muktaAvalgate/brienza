<style>
	.arrow {
		border: solid white;
		border-width: 0 3px 3px 0;
		display: inline-block;
		padding: 3px;
		margin-left: 30px;
	}
	.up {
		transform: rotate(-135deg);
		-webkit-transform: rotate(-135deg);
	}
	.down {
		transform: rotate(45deg);
		-webkit-transform: rotate(45deg);
	}
	.pointer {
        cursor: pointer;
    }
</style>
<div class="subnav">
	<div class="container-fluid">
    	<h1><i class="fa fa-bell"></i></span> Manage Agenda Schedule</h1>

        <!-- <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php //echo base_url('app/payroll');?>"><span class="glyphicon glyphicon-time"></span> Payment Schedule</a></li>
				<li><a href="<?php //echo base_url('app/payroll/payment_schedules_add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add Payment Schedule</a></li>
			</ul>
        </div> -->
    </div>
</div>


<div class="container-fluid main">
		<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Agenda Schedules </li>
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
		$searchURL = base_url('auth/submit_agenda_search');
		$attributes = array('class' => 'form-inline search-form', 'id' => 'agenda-search-form', 'role' => 'form');
		echo form_open($searchURL, $attributes);
	?>
		<fieldset>
				<?php if ($this->session->userdata('role') == 'administrator') {?>
					<legend>
						<div class="row">
							<div class="col-md-1" id="button" style="cursor:pointer;"><span class="glyphicon glyphicon-filter"></span> Filters</div>
							<div class="col-md-11"></div>
						</div>
					</legend>
					<div class="row" id="item" style="display:none";>
				<?php }else{ ?>
					<legend>
						<div><span class="glyphicon glyphicon-filter"></span> Filters</div>
					</legend>
					<div class="row">
				<?php } ?>

						<div class="col-md-12">
							<div class="col-md-9">
							<div class="form-group">
								<input type="text" class="form-control calender-control" id="date" name="date" placeholder="Date" value="<?php if (isset($filter['date']) && $filter['date'] != '') {echo date('m/d/Y', strtotime($filter['date']));}?>" size="15" >
							</div>
							
							<div class="form-group">
								<select name="presenter" class="form-control" id="presenter_list">
									<option value="" selected>Select a presenter</option>
									<?php foreach ($presenters as $item) { ?>
										<option value="<?php echo $item->id;?>" <?php if ($filter['presenter'] == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
									<?php }?>
								</select>
							</div>

							<div class="form-group">
								<!-- <input type="hidden" id="sessionSort" name="sessionSort" value=""> -->
									<?php if(isset($filter['sessionSort']) && $filter['sessionSort'] == 'DESC'){ ?>
										<input type="hidden" id="sessionSort" name="sessionSort" value="DESC">
									<?php }else if(isset($filter['sessionSort']) && $filter['sessionSort'] == 'ASC'){ ?>
											<input type="hidden" id="sessionSort" name="sessionSort" value="ASC">
									<?php }else{ ?>
										<input type="hidden" id="sessionSort" name="sessionSort" value="DESC">
									<?php } ?>
									<input type="hidden" id="onlySessionSort" name="onlySessionSort" value="onlySessionSort">
									
							</div>
							<div class="form-group">
								<?php if(isset($filter['statusSort']) && $filter['statusSort'] == 'DESC'){ ?>
									<input type="hidden" id="statusSort" name="statusSort" value="DESC">
								<?php }else{ ?>
									<input type="hidden" id="statusSort" name="statusSort" value="ASC">
								<?php } ?>
								<input type="hidden" id="onlyStatusSort" name="onlyStatusSort" value="onlyStatusSort">
							</div>

							<div class="form-group">
								<select name="status" class="form-control" id="status_list">
									<option value="" selected>Select order status</option>
									<option value="Hours scheduled" <?php if ($filter['status'] == 'Hours+scheduled') { echo "selected";}?>>Hours scheduled</option>

									<option value="Draft attached" <?php if ($filter['status'] == 'Draft+attached') { echo "selected";}?>>Draft attached</option>

									<option value="Approved" <?php if ($filter['status'] == 'Approved') { echo "selected";}?>>Approved</option>

									<option value="Confirm hours" <?php if ($filter['status'] == 'Confirm+hours') { echo "selected";}?>>Confirm hours</option>

									

									<option value="Log sent - awaiting principal signature" <?php if ($filter['status'] == 'Log+sent+-+awaiting+principal+signature') { echo "selected";}?>>Log sent - awaiting principal signature</option>

									<option value="Awaiting Review" <?php if ($filter['status'] == 'Awaiting+Review') { echo "selected";}?>>Awaiting Review</option>

									<option value="Create invoice" <?php if ($filter['status'] == 'Create+invoice') { echo "selected";}?>>Create invoice</option>

									<option value="Invoice created" <?php if ($filter['status'] == 'Invoice+created') { echo "selected";}?>>Invoice created</option>

									


									
								</select>
							</div>
							</div>
							<div class="col-md-3" style="margin-top: -9px;">
							<div class="form-group" style="width:100%; text-align:right; margin:10px 0 0 0;">
								<!-- <button type="button" class="btn btn-default" onclick="window.location='<?php echo $resetURL; ?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
								<button type="button" class="btn btn-default" onclick="resetForm();"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">&nbsp;</div>
					</div>
		</fieldset>
	<?php echo form_close();?>

        <div class="row">
			<?php 
			if (!empty($schedules)) 
			{ 
			?>
			<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<tbody>
					<tr class="gradeA even" role="row">
						<td style="padding-left: 0px; padding-right: 0px;">
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								//echo form_open_multipart(base_url('app/payroll/show_payable_schedules/'.$id), $attributes);
							?>
							<table class="table" width="100%">

							<tr>
								<td colspan="5">
									<table class="table sub-order" width="100%">
										<tr>
											<!-- <th class="pointer" onclick="dateByAscending();">Session
												<?php if(isset($filter['sessionSort']) && $filter['sessionSort'] == 'DESC'){ ?>
													<i class="arrow down" id="down"></i>
												<?php }else if(isset($filter['sessionSort']) && $filter['sessionSort'] == 'ASC'){ ?>
													<i class="arrow up"></i>
												<?php }else{ ?>
													<i class="arrow down"></i>
												<?php } ?>
											</th> -->
											<th>Session</th>
											<th>PO</th>
											<th>Schedule Hours</th>
											<th>Presenter</th>
											<!-- <th class="pointer" onclick="statusByAscending();">Status
												<?php if(isset($filter['statusSort']) && $filter['statusSort'] == 'DESC'){ ?>
													<i class="arrow down" id="down"></i>
												<?php }else{ ?>
													<i class="arrow up"></i>
												<?php } ?>
											</th> -->
											<th>Status</th>
										</tr>
										<?php $submit_btn = false; ?>

										<?php if (count($schedules) == 0) { ?>
											<tr>
												<td colspan="100%">Sorry!! No Records found.</td>
											</tr>
										<?php } else{
											foreach ($schedules as $row) 
											{
										?>
												<tr>
													<td><?php echo date_display($row->start_date, "m/d/Y");?> @ <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?> with <?php echo $row->teacher;?> </td>
													<td><?php echo $row->order_no;?></td>
													<td><?php echo $row->total_hours.' Hours';?></td>
													<td><?php echo $row->presenter_name;?></td>
													<td><?php echo $row->status;?></td>
												</tr>
										<?php 
											}}
										?>
									</table>
									
								</td>
							</tr>
							
							</table>
							<?php //echo form_close();?>
						</td>
					</tr>
				</tbody>
			</table>
				<?php }else{ ?>
				<tr>
					<td colspan="100%">Sorry!! No Records Available.</td>
				</tr>

			<?php   }
				?>
		</div>

	<?php echo $this->pagination->create_links(); ?>        
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
		<div class="row">
			<div class="col-lg-9 col-md-8"></div>
			<div class="col-lg-3 col-md-4 text-right">
				<div class="panel panel-success">
					<div class="panel-heading">
						Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModal">Click here</a>
                    </div>
				</div>
			</div>
        </div>
	<!-- </div> -->
</div>

<script>
	$( "#button" ).click(function() {
		$( "#item" ).toggle();
	});

	function dateByAscending(){
		// alert($('#sessionSort').val());
		
		if($('#sessionSort').val() == 'ASC'){
			// alert()
			var toSort = 'DESC';
			$('#sessionSort').val(toSort);
		}
		else{
			var toSort = 'ASC';
			$('#sessionSort').val(toSort);
		}
		// $('#statusSort').val('');
		var onlySessionSort = 'onlySessionSort';
		$('#onlySessionSort').val(onlySessionSort);

		$('#agenda-search-form').submit();
		
	}
	
	function statusByAscending(){
		// alert($('#sessionSort').val());
		
		if($('#statusSort').val() == 'ASC'){
			// alert()
			var toSort = 'DESC';
			$('#statusSort').val(toSort);
		}else{
			var toSort = 'ASC';
			$('#statusSort').val(toSort);
		}
		// $('#onlySessionSort').val('');
		var onlyStatusSort = 'onlyStatusSort';
		$('#onlyStatusSort').val(onlyStatusSort);
		$('#agenda-search-form').submit();
		
	}
	function resetForm(){
		$('#presenter_list').val('');
		$('#date').val('');
		$('#sessionSort').val('');
		$('#statusSort').val('');
		$('#status_list').val('');
		
		$("#agenda-search-form").submit();
	}
</script>
