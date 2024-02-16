
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
        <div class="row">
			<?php 
			if (!empty($schedules)) 
			{ 
			?>
			<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<tbody>
					<tr class="gradeA even" role="row">
						<td>
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								//echo form_open_multipart(base_url('app/payroll/show_payable_schedules/'.$id), $attributes);
							?>
							<table class="table" width="100%">

							<tr>
								<td colspan="5">
									<table class="table sub-order" width="100%">
										<tr>
											<th>Session</th>
											<th>PO</th>
											<th>Schedule Hours</th>
											<th>Presenter</th>
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

