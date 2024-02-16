
<style type="text/css">
.blink {
 -webkit-animation: blink .75s linear infinite;
 -moz-animation: blink .75s linear infinite;
 -ms-animation: blink .75s linear infinite;
 -o-animation: blink .75s linear infinite;
 animation: blink .75s linear infinite;
}
@-webkit-keyframes blink {
 0% { opacity: 1; }
 50% { opacity: 1; }
 50.01% { opacity: 0; }
 100% { opacity: 0; }
}
@-moz-keyframes blink {
 0% { opacity: 1; }
 50% { opacity: 1; }
 50.01% { opacity: 0; }
 100% { opacity: 0; }
}
@-ms-keyframes blink {
 0% { opacity: 1; }
 50% { opacity: 1; }
 50.01% { opacity: 0; }
 100% { opacity: 0; }
}
@-o-keyframes blink {
 0% { opacity: 1; }
 50% { opacity: 1; }
 50.01% { opacity: 0; }
 100% { opacity: 0; }
}
@keyframes blink {
 0% { opacity: 1; }
 50% { opacity: 1; }
 50.01% { opacity: 0; }
 100% { opacity: 0; }
}

.old_div{
    position: absolute;
    right: 59px;
    width: 285px;
}

</style>


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
						<!-- <p class="form-control-static highlight-block"> <?php echo ($order->hours-$order->total_hours_scheduled);?> hours left </p> -->
						<p class="form-control-static highlight-block"> <?php echo ($remaining_schedule_hrs);?> hours left </p>
						<input type="hidden" name="leftHours" id="leftHours" value="<?php echo $remaining_schedule_hrs; ?>">
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
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($schedules as $row) {?>
						<tr class="gradeA odd" role="row" data-id="<?php echo $row->id; ?>"data-school-id="<?php echo $row->school_id; ?>" data-order-id="<?php echo $row->order_id;?>">
							<td>
								<span class="editSpan date"><?php echo date_display($row->start_date, "l, F j, Y");?></span>
								<input class="editInput date form-control custom-calendar-control-schedule input-nobg" readonly type="text" data-src="<?php echo (isset($order->id) ? base_url('/app/presenters/show_calendar?order_id='.$order->id) : '');?>" data-toggle="modal" data-target="#calendarModal" name="date" value="<?php echo date_display($row->start_date, "l, F j, Y");?>" placeholder="Select" style="display: none;">
							</td>
							<td>
								<span class="editSpan start_time"><?php echo time_display($row->start_date, true);?></span>
								<input class="editInput start_time form-control timepicker-control-start input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." type="text" name="start_time" value="<?php echo time_display($row->start_date);?>" slug="total_hours_<?php echo $row->id; ?>" placeholder="Select" style="display: none;">
							</td>
							<td>
								<span class="editSpan end_time"><?php echo time_display($row->end_date, true);?></span>
								<input class="editInput end_time form-control timepicker-control-end input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." type="text" name="end_time" value="<?php echo time_display($row->end_date,true);?>" old_hrs="<?php echo $row->total_hours;?>" slug="total_hours_<?php echo $row->id; ?>" placeholder="Select" style="display: none;">
							</td>
							<td>
								<span class="editSpan topics" data-topic="<?php echo $row->topic_id; ?>"><?php echo $row->topic_name;?></span>
								<select name="topics" class="editInput topics form-control" required  style="display: none;">
									<option value="">Select</option>
									<?php foreach ($topics as $id=>$item) {?>
										<option value="<?php echo $id;?>" <?php if(isset($row->topic_id) && $row->topic_id==$id){echo "selected";}?>><?php echo $item;?></option>
									<?php }?>
								</select>
							</td>
							<td>
								<span class="editSpan types" data-type="<?php echo $row->type_id; ?>"><?php echo $row->worktype_name;?></span>
								<select name="types" class="form-control editInput types" required  style="display: none;">
									<option value="">Select</option>
									<?php foreach ($types as $item) {?>
										<option value="<?php echo $item->id;?>" <?php if(isset($row->type_id) && $row->type_id==$item->id){echo "selected";}?>><?php echo $item->name;?></option>
									<?php }?>
								</select>
							</td>
								<td>
								<span class="editSpan grades" data-grade="<?php echo $row->grade_id; ?>"><?php echo $row->grade_name;?></span>
								 <select name="grades" class="form-control editInput grade_teacher" data-id="<?php echo $row->id;?>" style="display: none;">
									<option>Select</option>
									<?php foreach ($teacher_grades as $item) { ?>
										<option value="<?php echo $item->grade_id;?>" data-slug="<?php echo $item->school_id;?>" data-order="<?php echo $row->order_id;?>" data-id="<?php echo $row->id;?>" <?php if(isset($row->grade_id) && $row->grade_id==$item->grade_id){echo "selected";}?>><?php echo $item->grade_name;?></option>
									<?php }?>
								</select> 
							</td>
					    	<td>
								<span class="editSpan teachers grade_tech "><?php echo $row->teacher;?></span>
								  <select name="teachers1"  class="editInput  form-control grade_tech<?php echo $row->id; ?>" data-d="<?php echo $row->id;?>" style="display: none;" >
									</div><option value="<?php ;?>" class="op">select</option>
								</select>

							 <input type="text"  value="" class="editInput  form-control input_grade<?php echo $row->id; ?>" placeholder="" name="teachers" style="display: none;"> 
						  </td>  
							<td>
								<span class="editSpan total_hrs"><?php echo $row->total_hours;?></span>
								<input type="text" class="editInput total_hrs form-control input-nobg" name="total_hours" id="total_hours_<?php echo $row->id; ?>" readonly placeholder="Hours" value="<?php echo $row->total_hours;?>" style="display: none;">
							</td>
							<td>
	                            <div class="btn-group btn-group-sm">
									<?php
                                        if($row->status == 'Hours scheduled' || $row->status == 'Draft attached'){
                                    ?>
									<button type="button" class="btn btn-sm btn-default editBtn " data-id="<?php echo $row->id; ?>" data-name="<?php echo $row->grade_id;?>" data-s="<?php echo $row->school_id; ?>" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
									<?php
                                        }
                                    ?>
	                            </div>
	                            <button type="button" class="btn btn-sm btn-success saveBtn" style="float: none; display: none;">Save</button>
	                            <button type="button" class="btn btn-sm btn-primary cancelBtn" style="float: none; display: none;">Cancel</button>
	                            <button type="button" class="btn btn-sm btn-danger confirmBtn" style="float: none; display: none;">Confirm</button>
	                        </td>
						</tr>
						<?php }?>
						<?php if(isset($order->id) && (($remaining_schedule_hrs) >= 1)) { ?>
						<tr class="gradeA odd" role="row">
							<td><input type="text" class="form-control custom-calendar-control input-nobg" readonly placeholder="Select" data-src="<?php echo (isset($order->id) ? base_url('/app/presenters/show_calendar?order_id='.$order->id) : '');?>" data-toggle="modal" data-target="#calendarModal" name="date" id="calDate"></td>
							<td class="col-md-1"><input type="text" class="form-control timepicker-control-start input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." name="start_time" id="" placeholder="Select" value="" ></td>
							<td class="col-md-1"><input type="text" class="form-control timepicker-control-end input-nobg" pattern="^([01]\d|2[0-3]):?([0-5]\d) [APap][mM]$" maxlength="8" data-error="Sorry! Please use HH:MM am/pm format for time." name="end_time" id="" placeholder="Select" value="" ></td>
							<td class="col-md-1">
								<!-- <select name="topics" class="form-control" required>
									<option value="">Select</option>
									<?php foreach ($topics as $id=>$item) {?>
										<option value="<?php echo $id;?>" <?php if (isset($selected_topic) && $selected_topic==$id){echo "selected";}?>><?php echo $item;?></option>
									<?php }?>
								</select> -->
								<?php
                                    if(!empty($topics)){
                                ?>
                                    <select name="topics" class="form-control" required>
                                        <option value="">Select</option>
                                        <?php foreach ($topics as $id=>$item) {?>
                                            <option value="<?php echo $id;?>" <?php if (isset($selected_topic) && $selected_topic==$id){echo "selected";}?>><?php echo $item;?></option>
                                        <?php }?>
                                    </select>
                                <?php
                                    }else{
                                ?>
                                    <input type="text"  name="topics" value="" class="form-control" placeholder="Topic name" required>
                                <?php
                                    }
                                ?>
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
							<?php
								if(!empty($teacher_grades)){
							?>
								<select name="grades" class="form-control grades">
									<option value="">Select</option>
									<?php foreach ($teacher_grades as $item) {?>
										<option value="<?php echo $item->grade_id;?>" data-slug="<?php echo $item->school_id; ?>" ><?php echo $item->grade_name;?></option>

									<?php }?>
								</select>

								<input type="hidden" id="schoolId" value="<?php echo $school_id ?>" >
								<input type="hidden" id="titleId" value="<?php echo $title_id ?>" >
								<input type="hidden" id="is_grade_present" value="" >
							<?php
								}else{
							?>
								<input type="text"  name="grades" value="" class="form-control" placeholder="Grade name" required>
								<input type="hidden" id="is_grade_present" value="present" >
							<?php
								}
							?>
								
							</td>
							<td>
								<!-- <select name="teachers1"  class="form-control teach" style="display: none;" onclick="blockFreeText();">
									</div><option value="<?php ;?>">select</option>
								</select> -->

								<select onmousedown="(function(e){ e.preventDefault(); })(event, this)" name="teachers1"   class="form-control teach_hideNew" style="display: none;" onclick="blockFreeText();" id="teach_hideNew">
									<option value="">select</option>
								</select>

								<select name="teachers1"  class="form-control teach" style="display: none;">
									</div><option value="<?php ;?>">select</option>
								</select>

								<input type="text"  value="" class="form-control inputteacher" placeholder="" onclick="blockFreeText();" name="teachers" required readonly>
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
        	<?php if(isset($order->id) && (($remaining_schedule_hrs) >= 1)) { ?>

			<div class="col-lg-4 col-md-5">
				<div class="panel panel-warning">
					<!--<div class="panel-heading">
						You have scheduled <span id="total_hours_scheduled"><?php echo ($order->total_hours_scheduled)?$order->total_hours_scheduled:0;?></span> out of <?php echo $order->hours;?> hours. Submit to Admin?
                    </div> -->
					<span id="total_hours_scheduled" class="hide"><?php echo ($order->total_hours_scheduled)?$order->total_hours_scheduled:0;?></span>
					<!--<span id="total_order_hours" class="hide"><?php echo ($order->hours)?$order->hours:0;?></span>-->
					<span id="total_order_hours" class="hide"><?php echo ($presenter_hours->assigned_hours)?$presenter_hours->assigned_hours:0;?></span>
					
					<div class="panel-heading" id="total_hours_scheduled_now">&nbsp;</div>
				</div>
			</div>
            <div class="col-lg-5 col-md-3">
				<!-- <input type="submit" class="btn btn-success" value="Submit Schedule"> -->
				<input type="submit" class="btn btn-success" value="Submit Schedule" onclick="return checkValidation();">
				<input type="hidden"  value="<?php echo $startDate ?>" id="sdate">
				<input type="hidden"  value="<?php echo $endDate ?>" id="edate">
			</div>

			<?php } ?>

			<!-- blink for teacher add -->
			<div class="col-lg-3 col-md-4 text-right" style="display: none;" id="blink_div">
                <div class="panel panel-success" style="text-align:center;">
                    <div class="panel-heading">
                        <!-- <span class="tab blink">Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModalBlink">Click here</a></span> -->
						<span class="tab blink">Is something not right? <a href="#" onclick="openTeacherRequestModal();">Click here</a></span>
                    </div>
                </div>
            </div>

			<div class="col-lg-3 col-md-4 text-right old_div" id="old_div">
				<div class="panel panel-success" style="text-align:center;">
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

	<!-- Admin Message Modal For add teachers Blink -->
	<div class="modal fade" id="adminMessageModalBlink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <?php
                $attributes = array('class' => '', 'name' => 'notification_submit_form', 'id' => 'notification-submit-form', 'role' => 'form', 'data-toggle' => 'validator');
                echo form_open(base_url('app/notifications/add_blink_direct'), $attributes);
            ?>
            <form class="form-horizontal" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">To: Admin</h4>
                </div>
                <div class="modal-body">
                    <label for="teacher_name">Please enter the Grade and Teacher that you would like to add:</label>
                    <textarea name="description" id= "description" class="form-control" rows="5" required ></textarea>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="type" value="admin" />
                    <input type="hidden" name="subject" value="Issue reported from portal" />
                    <button type="button" onclick="requestTeacher();"
                        class="btn btn-primary">Send</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>



<script>
	function checkValidation(){
		var session_sdate = $("#sdate").val();
		var session_edate = $("#edate").val();
		var dt = $("#calDate").val();
		var chunks = dt.split(",");
		var mnthDay = chunks[1];
		var testyr = chunks[2];
		const ftestyr = testyr.split(" ");
		const mnthDaychunks = mnthDay.split(" ");
		var dat = new Date('1 ' + mnthDaychunks[1] + ' 1999');
		var fmonth = dat.getMonth() + 1;
		if(fmonth<10){
			fmonth = '0'+fmonth;
		}
		if(mnthDaychunks[2]<10){
			var fday = '0'+mnthDaychunks[2];
		}else{
			var fday = mnthDaychunks[2];
		}

		var fdate = ftestyr[1]+"-"+fmonth+"-"+ fday;
		if(fdate >= session_sdate && fdate <= session_edate){
			return true;
		}else{
			alert('Schedule date must be within the session of this order.');
			return false;
		}
	}

$(document).ready(function(){
    $('.editBtn').on('click',function(){

    	 var tid = $(this).attr('data-id'); 
     	 var grade_id = $(this).attr('data-name'); 
     	 var school_id = $(this).attr('data-s'); 


        //hide edit span
        $(this).closest("tr").find(".editSpan").hide();
        
        //show edit input
        $(this).closest("tr").find(".editInput").show();
      	$(this).closest("tr").find(".grade_teach"+tid).hide();
        $(this).closest("tr").find(".input_grade"+tid).hide();
        
        //hide edit button
        $(this).closest("tr").find(".editBtn").hide();
        
        //show edit button
        $(this).closest("tr").find(".saveBtn").show();
        $(this).closest("tr").find(".cancelBtn").show();

        $.ajax({
		        type: "POST",
		        url: '<?php echo base_url('app/presenters/get_grade_teacher/');?>',
		        dataType:"json",
		        data: {grade_id:grade_id ,school_id:school_id ,tid:tid
		        },	
        		success: function(res){
        			if(res.msg == 'multiple')
        			{
        				
        				$(".grade_teach"+tid).show();
        				$(".input_grade"+tid).hide();
        				$(".grade_tech"+tid).html(res.opt);
        			}else{
        				$(".grade_tech"+tid).hide();
        				$(".input_grade"+tid).show();
        				$(".input_grade"+tid).val(res.opt);
        			}
				}

		   
		    });
        
    });
    
    $('.cancelBtn').on('click',function(){
        //show edit span
        $(this).closest("tr").find(".editSpan").show();
        
        //hide edit input
        $(this).closest("tr").find(".editInput").hide();
        /* $(this).closest("tr").find(".editInput.date").val(jQuery(".editSpan.date").html());
        $(this).closest("tr").find(".editInput.start_time").val(jQuery(".editSpan.start_time").html());
        $(this).closest("tr").find(".editInput.end_time").val(jQuery(".editSpan.end_time").html());
        $(this).closest("tr").find(".editInput.topics").val(jQuery(".editSpan.topics").attr("data-topic"));
        $(this).closest("tr").find(".editInput.types").val(jQuery(".editSpan.types").attr("data-type"));
        $(this).closest("tr").find(".editInput.grades").val(jQuery(".editSpan.grades").attr("data-grade"));
        $(this).closest("tr").find(".editInput.teachers").val(jQuery(".editSpan.teachers").html());
        $(this).closest("tr").find(".editInput.total_hrs").val(jQuery(".editSpan.total_hrs").html()); */
        
        //show edit button
        $(this).closest("tr").find(".editBtn").show();
        
        //hide edit button
        $(this).closest("tr").find(".saveBtn").hide();
        $(this).closest("tr").find(".cancelBtn").hide();

        // Remove end time picker
		jQuery('.timepicker-control-end').timepicker('remove');
        
    });
    
    $('.saveBtn').on('click',function(){
		//validation for session 
		var session_sdate = $("#sdate").val();
		var session_edate = $("#edate").val();
		//end

        var trObj = $(this).closest("tr");
        var order_schedule_id = trObj.attr('data-id');
        var school_id = trObj.attr('data-school-id');
        var order_id = trObj.attr('data-order-id');
        var inputData = trObj.find(".editInput").serialize();

		//validation for session 
		var dt = trObj.find(".editInput.date").val();
		var chunks = dt.split(",");
		var mnthDay = chunks[1];
		var testyr = chunks[2];
		const ftestyr = testyr.split(" ");
		const mnthDaychunks = mnthDay.split(" ");
		var dat = new Date('1 ' + mnthDaychunks[1] + ' 1999');
		var fmonth = dat.getMonth() + 1;
		if(fmonth<10){
			fmonth = '0'+fmonth;
		}
		if(mnthDaychunks[2]<10){
			var fday = '0'+mnthDaychunks[2];
		}else{
			var fday = mnthDaychunks[2];
		}

		var fdate = ftestyr[1]+"-"+fmonth+"-"+ fday;
		var flag=0;
		if(fdate >= session_sdate && fdate <= session_edate){
			var flag = 1;
		}
		//end

        var err = "";
        if(trObj.find(".editInput.start_time").val() == ""){
        	err += "Start time field is required.\n";
        }
        if(trObj.find(".editInput.end_time").val() == ""){
        	err += "End time field is required.\n";
        }
        if(trObj.find(".editInput.topics").val() == ""){
        	err += "Topics field is required.\n";
        }
        if(trObj.find(".editInput.types").val() == ""){
        	err += "Types field is required.\n";
        }
        if(trObj.find(".editInput.grades").val() == ""){
        	err += "Grade field is required.\n";
        }
        // if(trObj.find(".editInput.teachers").val() == ""){
        // 	err += "Teachers field is required.\n";
        // }
		if(flag == 0){
        	err += "Schedule date must be within the session of this order.\n";
        }

        if(trObj.find(".editInput.teachers").val() == "" && trObj.find(".editInput.teachers").val() != ""){
        	err += "Teachers field is required.\n";
        }
        if(trObj.find(".editInput.teachers").val() != "" && trObj.find(".editInput.teachers").val() == ""){
        	err += "Teachers field is required.\n";
        }
         if(trObj.find(".editInput.teachers").val() == "" && trObj.find(".editInput.teachers").val() == ""){
        	err += "Teachers field is required.\n";
        }
        if(trObj.find(".editInput.total_hrs").val() == ""){
        	err += "Total hours field is required.\n";
        }

        console.log(inputData);
        if(err == ""){
	        $.ajax({
	            type:'POST',
	            url: base_url+"app/presenters/update_scheduling",
	            dataType: "json",
	            data:'order_id='+order_id+'&school_id='+school_id+'&order_schedule_id='+order_schedule_id+'&'+inputData,
	            success:function(response){
	            	window.location.href = base_url+"/app/presenters/scheduling/?order_id="+order_id+"&school_id="+school_id;
	            }
	        });
	    }else{
	    	alert(err);
	    }
    });
    
    $('.deleteBtn').on('click',function(){
        //hide delete button
        $(this).closest("tr").find(".deleteBtn").hide();
        
        //show confirm button
        $(this).closest("tr").find(".confirmBtn").show();
        
    });
    
    $('.confirmBtn').on('click',function(){
        var trObj = $(this).closest("tr");
        var ID = $(this).closest("tr").attr('id');
        $.ajax({
            type:'POST',
            url:'userAction.php',
            dataType: "json",
            data:'action=delete&id='+ID,
            success:function(response){
                if(response.status == 'ok'){
                    trObj.remove();
                }else{
                    trObj.find(".confirmBtn").hide();
                    trObj.find(".deleteBtn").show();
                    alert(response.msg);
                }
            }
        });
    });
});
</script>

<script>
	$( document ).ready(function() {

		$(".teach").hide();

		// start time end time drop down list not typeing
		$('.timepicker-control-start').keydown(function(e) {
		  e.preventDefault();
		});
		$('.timepicker-control-end').keydown(function(e) {
		  e.preventDefault();
		});

		$('.teach').on( "change", function(e) {
		  	var grd = $(this).find(":selected").val();

		  	$(".inputteacher").val(grd);
		});

		$('.grades').on( "change", function(e) {
		
		  	var school_id = $(this).find(':selected').attr('data-slug');
		  	var grade_id = $(this).find(":selected").val();
			//var tech     = $(this).find(':selected').attr('data-id');
			// var order_id = $(this).find(':selected').attr('data-orderId');
		
		  	  $.ajax({
			        type: "POST",
			        url: '<?php echo base_url('app/presenters/get_grades/');?>',
			        dataType:"json",
			        data: {grade_id:grade_id ,school_id:school_id},	
	        		success: function(res){
	        			if(res.msg == 'multiple')
	        			{
	        				//lert('kjbkjb');
	        				// $(".teach").show();
							$(".teach_hideNew").show();//16-11-2022
	        				$(".inputteacher").hide();
	        				$(".inputteacher").val('');
	        				$(".teach").html(res.opt);
							$(".teach").hide(); //16-11-2022
	        			}else{
	        				$(".teach").hide(); //16-11-2022
							// $(".teach_hideNew").hide();  
	        				$(".inputteacher").show();
	        				$(".inputteacher").val(res.opt);
	        			}
					}

			   
			    });
		  	
		   
	    });


	 //    $('.grade_tech').on( "change", function(e) {
		//   	var grd = $(this).find(":selected").val();
		//   	var tech_d    = $(this).find(':selected').attr('data-d');

		//   	$(".input_grade").val(grd);
		// });


	    $('.grade_teacher').on( "change", function(e) {
		
		  	var school_id = $(this).find(':selected').attr('data-slug');
		  	var grade_id = $(this).find(":selected").val();
			var tech     = $(this).find(':selected').attr('data-id');
			var order_id = $(this).find(':selected').attr('data-order');

			// alert(order_id);alert(grade_id);alert(tech);alert(school_id);
		
		  	  $.ajax({
			        type: "POST",
			        url: '<?php echo base_url('app/presenters/get_grade_teacher/');?>',
			        dataType:"json",
			        data: {grade_id:grade_id ,school_id:school_id ,order_id:order_id
			        },	
	        		success: function(res){
	        			if(res.msg == 'multiple')
	        			{
	        				
	        				$(".grade_tech"+tech).show();
	        				$(".input_grade"+tech).hide();
	        				$(".input_grade"+tech).val('');
	        				$(".grade_tech"+tech).html(res.opt);
	        			}else{
	        				$(".grade_tech"+tech).hide();
	        				$(".input_grade"+tech).show();
	        				$(".input_grade"+tech).val(res.opt);
	        			}
					}

			   
			    });
		  	
		   
	    });
	});

	// function blockFreeText() {
	// 	alert("Don't see the teacher that you want? Make sure to send the teacher's name and grade to your PD admin.");
	// 	$("#old_div").hide();
	// 	$("#blink_div").show();

	// 	setTimeout(function() {
	// 		$('#blink_div').fadeOut('fast');
	// 		$("#old_div").show();
	// 	}, 10000);
	// }

	function blockFreeText() {
		if (confirm("Don't see the teacher that you want? Make sure to send the teacher's name and grade to your PD admin.")) {
			$(".teach_hideNew").hide();
			$(".teach").show();

			$("#old_div").hide();
			$("#blink_div").show();
			setTimeout(function() {
				$('#blink_div').fadeOut('fast');
				$("#old_div").show();
			}, 10000);
		}else{
			$(".teach_hideNew").hide();
			$(".teach").show();
		}
		

	}

	

	function openTeacherRequestModal(){
		$('#adminMessageModalBlink').modal('show');
	}

	function requestTeacher(){
		var message = $("#description").val();
		if (message==''){
			alert ('Please enter Teacher name and Grade.');}
		else{
			$("#notification-submit-form").submit();
		}
	}

</script>