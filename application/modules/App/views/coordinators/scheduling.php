<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Scheduling</h3>
            </div>
            <!--<div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div>-->
		</div>
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

			$attributes = array('class' => 'form-inline search-form', 'name' => 'schedule_form', 'id' => 'schedule-form', 'role' => 'form');
			echo form_open(base_url('app/orders/search_submit'), $attributes);
		?>
		<div class="row">
			<div class="col-lg-9 col-md-8">
				<div class="form-group">
					<select name="school" class="form-control" onchange="updateSchedulingSchool(this.value);" >
						<option value="" selected>Select a school</option>
						<?php foreach ($schools as $item) {?>
							<option value="<?php echo $item->school_id;?>" <?php if(isset($selected_school) && $selected_school == $item->school_id) {echo "selected";}?>><?php echo $item->school_name;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
					<select name="order" class="form-control" onchange="updateSchedulingOrder(document.schedule_form.school.value, this.value);" >
						<option value="" selected>Select an order</option>
						<?php foreach ($purchase_orders as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if(isset($selected_order) && $selected_order == $item->id) {echo "selected";}?>><?php echo $item->order_no;?></option>
						<?php }?>	
					</select>
				</div>
				<div class="form-group">
					<?php if(isset($order->id)) :?>
						<p class="form-control-static highlight-block"> <?php echo ($order->hours-$order->total_hours_scheduled);?> hours left </p>
					<?php endif;?>
				</div>
				<div class="form-group">
					<?php if(isset($order->id)) :?>
						<p class="form-control-static highlight-block-purple"> Title: <?php echo $order->title_name;?> </p>
					<?php endif;?>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
		<?php echo form_close();?>
		
		
		<?php if(isset($order->id)) :?>
		<?php
			$q_str = "?";
			if (isset($selected_order)) $q_str .= "&order_id=".$selected_order;
			if (isset($selected_school)) $q_str .= "&school_id=".$selected_school;
			
			$attributes = array('class' => '', 'name' => 'schedule_submit_form', 'id' => 'schedule-submit-form', 'role' => 'form', 'data-toggle' => 'validator');
			echo form_open(base_url('app/presenters/scheduling/'.$q_str), $attributes);
		?>
		
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling"  style="width: 100%;">
					<thead>
						<tr role="row">
							<th>Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Topic</th>
							<th>Type</th>
							<th>Grade</th>
							<th>Teacher</th>
							<th>Total Hours</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($schedules as $row) {?>
						<tr class="gradeA odd" role="row">
							<td><?php echo date_display($row->start_date, "l, F j, Y");?></td>
							<td><?php echo time_display($row->start_date, true);?></td>
							<td><?php echo time_display($row->end_date, true);?></td>
							<td><?php echo $row->topic_name;?></td>
							<td><?php echo $row->worktype_name;?></td>
							<td><?php echo $row->grade_name;?></td>
							<td><?php echo $row->teacher;?></td>
							<td><?php echo $row->total_hours;?></td>
						</tr>
						<?php }?>
						<?php if(isset($order->id) && (($order->hours-$order->total_hours_scheduled) >= 2)) { ?>
						<tr class="gradeA odd" role="row">
							<td><input type="text" class="form-control custom-calendar-control input-nobg" readonly placeholder="Select" data-src="<?php echo (isset($order->id) ? base_url('/app/presenters/show_calendar?order_id='.$order->id) : '');?>" data-toggle="modal" data-target="#calendarModal" name="date"></td>
							<td class="col-md-1"><input type="text" class="form-control timepicker-control-start input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." name="start_time" id="" placeholder="Select" value="" ></td>
							<td class="col-md-1"><input type="text" class="form-control timepicker-control-end input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." name="end_time" id="" placeholder="Select" value="" ></td>
							<td class="col-md-1">
								<select name="topics" class="form-control" required>
									<option value="">Select</option>
									<?php foreach ($topics as $id=>$item) {?>
										<option value="<?php echo $id;?>" <?php if (isset($selected_topic) && $selected_topic==$id){echo "selected";}?>><?php echo $item;?></option>
									<?php }?>
								</select>
							</td>
							<td class="col-md-1">
								<select name="types" class="form-control" required>
									<option value="">Select</option>
									<?php foreach ($types as $item) {?>
										<option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
									<?php }?>
								</select>
							</td>
							<td class="col-md-2">
								<select name="grades" class="form-control" onchange="updateSchedulingGrade(this);" required>
									<option>Select</option>
									<?php foreach ($grades as $item) {?>
										<option value="<?php echo $item->grade_id;?>" data-teacher="<?php echo $item->name;?>"><?php echo $item->grade_name;?></option>
									<?php }?>
								</select>
							</td>
							<td class="col-md-2">
								<input type="text" class="form-control" placeholder="" name="teachers" required>
							</td>
							<td class="col-md-1">
								<input type="text" class="form-control input-nobg" name="total_hours" id="total_hours" readonly placeholder="Hours">
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>      
			</div>
        </div>
        
		
        <div class="row">
        	<?php if(isset($order->id) && (($order->hours-$order->total_hours_scheduled) >= 2)) { ?>

			<div class="col-lg-4 col-md-5">
				<div class="panel panel-warning">
					<!--<div class="panel-heading">
						You have scheduled <span id="total_hours_scheduled"><?php echo ($order->total_hours_scheduled)?$order->total_hours_scheduled:0;?></span> out of <?php echo $order->hours;?> hours. Submit to Admin?
                    </div> -->
					<span id="total_hours_scheduled" class="hide"><?php echo ($order->total_hours_scheduled)?$order->total_hours_scheduled:0;?></span>
					<span id="total_order_hours" class="hide"><?php echo ($order->hours)?$order->hours:0;?></span>
					
					<div class="panel-heading" id="total_hours_scheduled_now">&nbsp;</div>
				</div>
			</div>
            <div class="col-lg-5 col-md-3">
				<input type="submit" class="btn btn-success" value="Submit Schedule">
			</div>

			<?php } ?>


			<div class="col-lg-3 col-md-4 text-right">
				<div class="panel panel-success">
					<div class="panel-heading">
						Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModal">Click here</a>
                    </div>
				</div>
			</div>
        </div>
		<?php echo form_close();?>
		<?php endif;?>
	</div>
</div>

<!-- Calendar Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Calendar</h4>
		    </div>
		    <div class="modal-body">
				Loading calendar...
			</div>
		</div>
	</div>
</div>
