jQuery(document).ready(function() {
	$calendarInput = null;
	
	jQuery("#checkall").click(function() {
		jQuery(".checkbox-item").prop('checked', this.checked);
	});

	jQuery(".calender-control").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy'
	});
	
	jQuery(".calender-control-futureonly").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
		minDate: 0
	});
		
	jQuery(".status-form").submit(function(e) {

		var fields = jQuery("input[type='checkbox']").serializeArray();
		if (fields.length === 0) {

			jQuery('html, body').animate({
		        scrollTop: $("#checkall").offset().top - 100
		    }, 500);
			jQuery('#checkall').popover({trigger: "click focus", content: "Please check atleast one record.", placement: "right"});
			jQuery('#checkall').popover('show');
			e.preventDefault();
		}
	});

	jQuery('.timepicker-control').timepicker({'timeFormat': 'h:i A'});
	
	// Schedule timepicker
	jQuery('.timepicker-control-start').timepicker({
		'timeFormat': 'h:i A',
		'minTime': '9:00 am',
		'maxTime': '5:00 pm',
	});
	
	var start_time, end_time;
	var hoursScheduled = jQuery("#total_hours_scheduled").html();
	if (parseFloat(hoursScheduled) == "") {
		hoursScheduled = 0;
	}
	var totalHours = jQuery("#total_order_hours").html();
	if (parseFloat(totalHours) == "") {
		totalHours = 0;
	}
	//console.log(hoursScheduled);
	//console.log(totalHours);
	jQuery('.timepicker-control-start, .timepicker-control-end').on('changeTime', function() {
		
		var selected_date = jQuery(this).parent().parent().find(".custom-calendar-control").val();
		//console.log(selected_date);
		if (selected_date == "") {
			alert("Please select a date");
			jQuery(".custom-calendar-control").click();
			return false;
		}
		
		
		if (jQuery(this).attr('name') == "start_time") {
			start_time = jQuery(this).val();
			console.log("start_time: "+start_time);
			
			var oldDate = new Date(selected_date+" "+start_time);
			var hour = oldDate.getHours();
			
			if (hour > 17){
				jQuery(this).val('');
			}
			
			oldDate.setHours(hour + 2);
			var min_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			oldDate.setHours(hour + 5);
			var max_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			//console.log(oldDate.getHours());
			//console.log(oldDate.getMinutes());
			console.log("min time: "+min_time);
			console.log("max time: "+max_time);
			
			jQuery('.timepicker-control-end').timepicker('remove');
			jQuery('.timepicker-control-end').timepicker({
				'timeFormat': 'h:i A',
				'minTime': min_time,
				'maxTime': max_time,
			});
		}
		
		if (jQuery(this).attr('name') == "end_time") {

			end_time = jQuery(this).val();
			console.log("end_time: "+end_time);
			
			var timeStart = new Date(selected_date+" "+start_time);
			var timeEnd = new Date(selected_date+" "+end_time);
			
			var diff =(timeEnd.getTime() - timeStart.getTime()) / 1000;
			diff /= 60;
			var timeDiff = parseFloat(Math.abs(Math.round(diff)) / 60);
 
			console.log(timeDiff);
			jQuery("#total_hours").val(timeDiff);
			
			// Update the Total Scheduled time
			var totalHoursScheduled = parseFloat(hoursScheduled)+parseFloat(timeDiff);
			jQuery("#total_hours_scheduled_now").html("You have scheduled "+totalHoursScheduled+" out of "+totalHours+" hours. Submit to Admin?")
		}
		//console.log(jQuery(this).attr('name'));
	});
	
	jQuery('.popover-control').popover({'html': true, 'template': '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title text-primary"></h3><div class="popover-content"></div></div>'});

	jQuery("tr.deleted input, tr.deleted select, tr.deleted textarea, tr.deleted button").prop('disabled', true);
	
	jQuery("a.teacherModalButton").on( "click", function() {
		jQuery("#viewTeacherModal .modal-body").load(
			jQuery(this).attr('data-src')
			//jQuery("#frm_grade_teacher").validator('update');
		);
	});
	
	jQuery("a.titleModalButton").on( "click", function() {
		jQuery("#viewTtitleModal .modal-body").load(
			jQuery(this).attr('data-src')
			//jQuery("#frm_grade_title").validator('update');
		);
	});
	
	jQuery("input.custom-calendar-control").on( "click", function() { 
		$calendarInput = this;
		var url = jQuery(this).attr('data-src');
		loadCalendar(url);
	});
	
	// Place Order button click
	jQuery(".frm_place_order").submit(function(e) {
		e.preventDefault();
		//alert(jQuery(this).find("select[name='title_id']").val());
		
		if (jQuery(this).find("input[name='hour']").val() == "") {
			return false;
		}
		if (jQuery(this).find("input[name='booking_date']").val() == "") {
			return false;
		}
		if (jQuery(this).find("select[name='title_id']").val() == "") {
			return false;
		}
		
		var data = jQuery(this).serialize();
		
		if (data.length > 0) {
			jQuery.ajax({
				type: "POST",
				url: base_url+"app/orders/place_order/",
				data: data,
				async: true,
				success: function(response){
					//console.log(response);
					if (!response.success) {
						alert(response.msg);
					} else {
						$table = '<table class="table table-responsive" width="100%">';
						$table += '<tbody>';

						$i = 0;
						$.each(response.topics, function( id, topic ) {
							$table += '<tr>';
							$table += '<td width="20"><input type="checkbox" name="topics[]" class="checkbox-item" value="'+id+'"></td>';
							$table += '<td>'+topic+'</td>';
							$table += '</tr>';
							$i++;
						});
						if (response.topics.length == 0) {
							$table += '<tr><td>No topics found.</td></tr>';
						}
						$table += '</tbody>';
						$table += '</table>';

						jQuery("#topicModal .modal-body").html($table);
						jQuery("#title_id").val(response.title_id);
						jQuery("#school_id").val(response.school_id);
						jQuery("#presenter_id").val(response.presenter_id);
						jQuery("#hour").val(response.hour);
						jQuery("#booking_date").val(response.booking_date);
						jQuery('#topicModal').modal('show');
					}
				}
			});
		}
		//console.log(data);
	});
	
	jQuery("#btn_place_order").on( "click", function(e) {
		e.preventDefault();
		
		var topics = $("input[name='topics[]']").serializeArray(); 
		/*if (topics.length === 0) 
		{ 
			alert('Please select a topic');
			return false;
		} */
		
		var data = jQuery("#frm_place_order_confirm").serialize();
		//console.log(data);
		if (data.length > 0) {
			jQuery.ajax({
				type: "POST",
				url: base_url+"app/orders/place_order_confirm/",
				data: data,
				async: true,
				success: function(response){
					alert(response.msg);
					if (response.success) {
						location.href = base_url+'app/orders';
					}
				}
			});
		}
	});
});


function loadCalendar(url) {
	if (url == "") {
		return false;
	}
	//alert(url);
	if (jQuery('#calendarModal').length) {
		jQuery("#calendarModal .modal-body").load(url);
	} else {
		document.location.href = url;
	}
	
}

function inputCalendarDate(year, month, date) {
	//alert($calendarInput);
	month = month - 1; // Converting PHP month to JS month
	var d = new Date(year, month, date);
	var date = "";
	
	var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	//console.log(d);
	//console.log(d.getDay());
	//console.log(d.getMonth());
	date += days[d.getDay()]+", ";
	date += months[d.getMonth()]+" ";
	date += d.getDate()+", ";
	date += d.getFullYear();
	
	jQuery($calendarInput).val(date);
	
	jQuery("#calendarModal").modal('hide');
}

function format_time(hours, min) {
	
	var minute = min + "";
	var type = 'AM';
	if (parseFloat(hours) > 12) {
		type = 'PM';
		hours = hours - 12;
	} 
	
	if(minute.length == 1) {
		minute = "0" + minute;
	} 
	//console.log(min);
	return hours+':'+minute+' '+type;
}

function updateSchedulingSchool(school_id) {
	if (school_id == "") {
		return false;
	}
	
	location.href = base_url + "app/presenters/scheduling/?school_id=" + school_id;
}

function updateSchedulingOrder(school_id, order_id) {
	if (order_id == "") {
		return false;
	}
	
	location.href = base_url + "app/presenters/scheduling/?school_id=" + school_id + "&order_id=" + order_id;
}

function updateSchedulingGrade(obj) {
	var teacher = jQuery(obj).find(':selected').attr('data-teacher');
	jQuery(obj).parent().parent().find("input[name='teachers']").val(teacher);
}

function displayMessageBox() {
	jQuery("#adminMessageModal").show();
}

function displaySchedule(id) {
	if (id == "") {
		return false;
	}

	jQuery.ajax({
		type: "POST",
		url: base_url+"app/presenters/display_schedule/"+id,
		async: true,
		success: function(response){
			if (response.success) {
				jQuery("#scheduleModal .modal-body").html(response.content);
				jQuery("#scheduleModal").modal('show');
			}
		}
	});
}

function expandSubOrder(id) {
	if (id == "") {
		return false;
	}
	
	var ele = "sub-order-"+id
	jQuery("#"+ele).slideToggle();
}

function updateBillingStatus(obj, id) {
	var ele = jQuery(obj).find(':selected').attr('data-id');
	console.log(id);
	jQuery("#"+ele+"_"+id).show();
	if(ele=="approved"){
		jQuery("#file_attach_"+id).hide();
	}else if(ele=="draft_attached"){
		jQuery("#file_attach_"+id).show();
	}
}

function displayDeclineConfirm(schedule_id) {
	//jQuery("#displayDeclineConfirm .modal-body").html(content);
	jQuery("#displayDeclineConfirm_"+schedule_id).modal('show');
}