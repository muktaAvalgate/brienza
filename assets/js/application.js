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
	
	jQuery(".disable-pre-date-calender").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
		minDate: 0
	});
	
	jQuery(".calender-control-futureonly").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
		minDate: 0
	});
		
    $("#session_from").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#session_to").datepicker("option", "minDate", dt);
        }
    });
    $("#session_to").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'mm/dd/yy',
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#session_from").datepicker("option", "maxDate", dt);
        }
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
		'minTime': '7:00 am',
		'maxTime': '5:00 pm',
		'step': '15',
	});
	

	jQuery('.timepicker-control-enddemo').timepicker({
		'timeFormat': 'h:i A',
		'minTime': '7:00 am',
		'maxTime': '5:00 pm',
		'step': '60',
	});

	// startTime = $('#strN').val();
	// 	alert(startTime);
	
	var start_time, end_time;
	var hoursScheduled = jQuery("#total_hours_scheduled").html();
	if (parseFloat(hoursScheduled) == "") {
		hoursScheduled = 0;
	}
	var totalHours = jQuery("#total_order_hours").html();
	if (parseFloat(totalHours) == "") {
		totalHours = 0;
	}

	hoursLeft = (parseInt(totalHours) - parseInt(hoursScheduled));
	leftHours = $('#leftHours').val();
	//console.log(hoursScheduled);
	//console.log(totalHours);

	jQuery('.timepicker-control-start, .timepicker-control-end').on('changeTime', function() {
		// alert($('#strtTme').val());
		// alert($('#strtTmeinpt').val());
		var selected_date = jQuery(this).parent().parent().find(".custom-calendar-control").val();
		// var sdate = jQuery(this).parent().parent().find(".timepicker-control-start").val('');
		if(typeof selected_date === 'undefined'){
			selected_date = jQuery(this).parent().parent().find(".custom-calendar-control-schedule").val();
		}
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
			end_time = jQuery(this).val();
			
			//oldDate.setHours(hour + 2);

			hourId = jQuery(this).attr("slug");
			if(typeof hourId !== 'undefined'){
				hoursLeft = parseInt(totalHours) - (parseInt(hoursScheduled) - parseInt(jQuery("#"+hourId).val()));
			}

			// Reset total hour feild
			jQuery("#"+hourId).val("");
			
			if(leftHours == 1 || leftHours == 0)
				oldDate.setHours(hour + 1);
			else
				oldDate.setHours(hour + 2);
			var min_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			oldDate.setHours(hour + 5);
			var max_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			// Update condition by Ahmed on 04-02-2020 for 7AM to 7PM
			var maxD = new Date(selected_date+" "+max_time);
			if(maxD.getHours() >= 19){
				if(maxD.getMinutes() > 0){
					max_time = format_time(18, oldDate.getMinutes());
				}else{
					max_time = format_time(19, oldDate.getMinutes());
				}
			}
			// End code on 04-02-2020 for 7AM to 7PM

			//console.log(oldDate.getHours());
			//console.log(oldDate.getMinutes());
			console.log("min time: "+min_time);
			console.log("max time: "+max_time);

			// jQuery('.timepicker-control-end').val("");	
			jQuery(this).parent().parent().find(".timepicker-control-end").val('');		
			jQuery('#total_hours').val("");
			jQuery('.timepicker-control-end').timepicker('remove');
			jQuery('.timepicker-control-end').timepicker({
				'timeFormat': 'h:i A',
				'minTime': min_time,
				'maxTime': max_time,
				'step': '60',
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
 
			hourId = jQuery(this).attr("slug");

			if(typeof hourId !== 'undefined'){
				jQuery("#"+hourId).val(timeDiff);
				oldHrs = jQuery(this).attr("old_hrs");
				hoursSc = (Math.abs(parseInt(timeDiff) - parseInt(oldHrs)));
				var totalHoursScheduled = parseFloat(hoursScheduled)+parseFloat(hoursSc);
			}else{
				jQuery("#total_hours").val(timeDiff);
				var totalHoursScheduled = parseFloat(hoursScheduled)+parseFloat(timeDiff);
			}
			
			jQuery("#total_hours_scheduled_now").html("You have scheduled "+totalHoursScheduled+" out of "+totalHours+" hours. Submit to Admin?")
		}
		//console.log(jQuery(this).attr('name'));
	});

	jQuery('.timepicker-control-starte, .timepicker-control-ende').on('click', function() {
		
		var selected_date = jQuery(this).parent().parent().find(".custom-calendar-control").val();
		
		// var sdate = jQuery(this).parent().parent().find(".timepicker-control-start").val('');
		alert(selected_date);
		alert('aa');
		if(typeof selected_date === 'undefined'){
			selected_date = jQuery(this).parent().parent().find(".custom-calendar-control-schedule").val();
		}
		alert(selected_date);
		//console.log(selected_date);
		if (selected_date == "") {
			alert("Please select a date");
			jQuery(".custom-calendar-control").click();
			return false;
		}
		
		
		if (jQuery(this).attr('name') == "start_time") {
			start_time = jQuery(this).val();
			alert(start_time);
			console.log("start_time: "+start_time);
			
			var oldDate = new Date(selected_date+" "+start_time);
			var hour = oldDate.getHours();
			
			if (hour > 17){
				jQuery(this).val('');
			}
			end_time = jQuery(this).val();
			alert(end_time);
			
			//oldDate.setHours(hour + 2);

			hourId = jQuery(this).attr("slug");
			if(typeof hourId !== 'undefined'){
				hoursLeft = parseInt(totalHours) - (parseInt(hoursScheduled) - parseInt(jQuery("#"+hourId).val()));
			}

			// Reset total hour feild
			jQuery("#"+hourId).val("");
			
			if(leftHours == 1 || leftHours == 0)
				oldDate.setHours(hour + 1);
			else
				oldDate.setHours(hour + 2);
			var min_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			oldDate.setHours(hour + 5);
			var max_time = format_time(oldDate.getHours(), oldDate.getMinutes());
			
			// Update condition by Ahmed on 04-02-2020 for 7AM to 7PM
			var maxD = new Date(selected_date+" "+max_time);
			if(maxD.getHours() >= 19){
				if(maxD.getMinutes() > 0){
					max_time = format_time(18, oldDate.getMinutes());
				}else{
					max_time = format_time(19, oldDate.getMinutes());
				}
			}
			// End code on 04-02-2020 for 7AM to 7PM

			//console.log(oldDate.getHours());
			//console.log(oldDate.getMinutes());
			console.log("min time: "+min_time);
			console.log("max time: "+max_time);

			// jQuery('.timepicker-control-end').val("");	
			jQuery(this).parent().parent().find(".timepicker-control-end").val('');		
			var etime = jQuery(this).parent().parent().find(".timepicker-control-end").val('');	
			alert(etime);
			jQuery('#total_hours').val("");
			jQuery('.timepicker-control-end').timepicker('remove');
			jQuery('.timepicker-control-end').timepicker({
				'timeFormat': 'h:i A',
				'minTime': min_time,
				'maxTime': max_time,
				'step': '60',
			});
		}
		
		if (jQuery(this).attr('name') == "end_time") {

			
			end_time = jQuery(this).val();
			start_time = jQuery(this).val();
			// alert(end_time);
			console.log("end_time: "+end_time);
			
			var timeStart = new Date(selected_date+" "+start_time);
			var timeEnd = new Date(selected_date+" "+end_time);
			
			var diff =(timeEnd.getTime() - timeStart.getTime()) / 1000;
			diff /= 60;
			var timeDiff = parseFloat(Math.abs(Math.round(diff)) / 60);
 
			hourId = jQuery(this).attr("slug");

			if(typeof hourId !== 'undefined'){
				jQuery("#"+hourId).val(timeDiff);
				oldHrs = jQuery(this).attr("old_hrs");
				hoursSc = (Math.abs(parseInt(timeDiff) - parseInt(oldHrs)));
				var totalHoursScheduled = parseFloat(hoursScheduled)+parseFloat(hoursSc);
			}else{
				jQuery("#total_hours").val(timeDiff);
				var totalHoursScheduled = parseFloat(hoursScheduled)+parseFloat(timeDiff);
			}
			
			jQuery("#total_hours_scheduled_now").html("You have scheduled "+totalHoursScheduled+" out of "+totalHours+" hours. Submit to Admin?")
		}
		// console.log(jQuery(this).attr('name'));
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
	
	jQuery("input.custom-calendar-control, input.custom-calendar-control-schedule").on( "click", function() { 
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
		if (jQuery(this).find("select[name='session_id']").val() == "") {
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
						$.each(response.topics, function( id, val ) {
							$table += '<tr>';
							$table += '<td width="20"><input type="checkbox" name="topics[]" class="checkbox-item" value="'+id+'"></td>';
							$table += '<td>'+val.topic+' <span title="'+val.description+'"><i class="fa fa-question-circle"></i></span></td>';
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
						jQuery("#coordinator_id2").val(response.coordinator_id);
						jQuery("#hour").val(response.hour);
						jQuery("#booking_date").val(response.booking_date);
						jQuery("#hdn_session_id").val(response.session_id);
						jQuery('#topicModal').modal('show');
					}
				}
			});
		}
		//console.log(data);
	});
	
	/**
	Following Js code is the 
	replica of placeing order but used for
	coordinator order placing ..
	Created on: 20-06-2019
	Created by: Soumya
	**/
	jQuery(".frm_place_order_coordinator").submit(function(e) {
		e.preventDefault();
		
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
				url: base_url+"app/coordinator/place_order/",
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
						$.each(response.topics, function( id, val ) {
							$table += '<tr>';
							$table += '<td width="20"><input type="checkbox" name="topics[]" class="checkbox-item" value="'+id+'"></td>';
							$table += '<td>'+val.topic+' <span title="'+val.description+'"><i class="fa fa-question-circle"></i></span></td>';
							//$table += '<td>'+topic+'</td>';
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
						jQuery("#coordinator_id").val(response.coordinator_id);
						jQuery("#hour").val(response.hour);
						jQuery("#booking_date").val(response.booking_date);
						jQuery('#topicModal').modal('show');
					}
				}
			});
		}
		//console.log(data);
	});	

	// ------- Code ends here ------------ //	
	

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
		jQuery('.loader_img').show();
		if (data.length > 0) {
			jQuery.ajax({
				type: "POST",
				url: base_url+"app/orders/place_order_confirm/",
				data: data,
				async: true,
				success: function(response){
					alert(response.msg);
					if (response.success)
					{
						location.href = base_url+'app/orders';
					}
				}
			});
		}
	});

	/**
	Following Js code is the 
	replica of confirm order but used for
	coordinator order placing ..
	Created on: 20-06-2019
	Created by: Soumya
	**/
	jQuery("#btn_place_order_co").on( "click", function(e) {
		e.preventDefault();
		
		var topics 	= $("input[name='topics[]']").serializeArray(); 
		var data 	= jQuery("#frm_place_order_confirm_co").serialize();
		jQuery('.cor_loader_img').show();
		//console.log(data);

		if (data.length > 0) {
			jQuery.ajax({
				type: "POST",
				url: base_url+"app/coordinator/place_order_confirm/",
				data: data,
				async: true,
				success: function(response){
					alert(response.msg);
					if (response.success) 
					{
						if(response.coordinator_id)
						location.href = base_url+'app/coordinator/order/'+response.coordinator_id;
						else						
						location.href = base_url+'app/coordinator/order';
					}
				}
			});
		}
	});

	/**
	Following code will 
	be involced to open modal
	for presenters
	Created on: 24-06-2019
	Created by: Soumya
	**/
	$('.open_modal').on('click', function() {
		var order_id 	= $(this).attr('title');
		var baseurl 	= base_url+"app/orders/presenter_view/"+order_id;
	    $.ajax({
	        url: baseurl,
	        type: 'post',
	        success: function(data) {
				$('.presenter-body').html(data);
	        }             
	    });		

		$('#presentarModal').modal('show');
	});	
	
	/**
	Following code will be involved
	to open the modal befoe approval
	and make it submit
	Created on: 24-06-2019
	Created by: Soumya	
	**/
	$('.open_modal_approval').on('click', function() {
		var order_id 	= $(this).attr('title');
		var form_url 	= base_url+'app/orders/change_status/approved/'+order_id;

		$('#order_approval').attr('action', form_url);
		$('#approvalModal').modal('show');
		//$('#order_approval').attr('action', form_url);
	});	
	//Filter session destroy function 
	destroySessionFilter();
	destroySessionFilterForPresenterCalendar();
});


function loadCalendar(url) {
	var urls = url.split("/");
	var  index = urls.indexOf("calendar");
	if (url == "") {
		return false;
	}
	if(index > 0){
		var session_sdate = $('#stDate').val();
		var session_edate = $('#endDate').val();
		var chunks = url.split("//");
		var chunks1 = chunks[1].split("/");
		var year = chunks1[5];
		var mnth = chunks1[6].split("?");
		var fdate = year+'-'+mnth[0]+'-01';
		if(fdate >= session_sdate && fdate <= session_edate){
			if (jQuery('#calendarModal').length) {
				jQuery("#calendarModal .modal-body").load(url);
			} else {
				document.location.href = url;
			}
		}else{
			alert('Oops! Cannot proceed to the next/previous month as it does not belong to the selected session.');
		}
	}else{
		if (jQuery('#calendarModal').length) {
			jQuery("#calendarModal .modal-body").load(url);
		} else {
			document.location.href = url;
		}
	}
	
}

function inputCalendarDate(year, month, date, orderId, schoolId) {
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

	checkScheduleAvailability(date, orderId, schoolId);
	
	jQuery($calendarInput).val(date);
	
	jQuery("#calendarModal").modal('hide');
}

function getschool_id(school_id)
{
	var url = base_url+'app/orders/add/?school_id='+school_id;
	location.href = url;
}

function format_time(hours, min) {
	
	var minute = min + "";
	var type = 'AM';
	if (parseFloat(hours) >= 12) {
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
		data: {schedule_id: id},
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
	// console.log(id);
	jQuery("#"+ele+"_"+id).show();
	if(ele=="completed"){
		jQuery("#orderUpdateStatus").attr("disabled", false);
	}else{
		jQuery("#orderUpdateStatus").attr("disabled", true);
	}
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

function checkScheduleAvailability(date, orderId, schoolId) {
	jQuery.ajax({
		type: "POST",
		url: base_url+"app/presenters/schedule_availability/",
		data: {date:date, order_id:orderId, school_id:schoolId},
		async: true,
		success: function(response){
			// console.log(response);
			var disableTime = [];
			$.each(response.disable_time, function (from_time, to_time) {
		        disableTime.push([from_time, to_time]);
		    });
			jQuery('.timepicker-control-start').timepicker('remove')
			jQuery('.timepicker-control-start').timepicker({
				'timeFormat': 'h:i A',
				'minTime': '7:00 am',
				'maxTime': '5:00 pm',
				'step': '15',
				'disableTimeRanges': disableTime
			});	
		}
	});
}

function destroySessionFilter(){
	var previousUrl = document.referrer;
	var billingUrl = base_url+"app/orders/billings"
	var searcUrl = base_url+"app/orders/billings_search";
	var currentUrl = window.location.href;
	var previousUrls = previousUrl.split("/");
	var currentUrls = currentUrl.split("/");
	if((previousUrls.indexOf('billings') > 0  || previousUrls.indexOf('billings_search') > 0) && (currentUrl !=searcUrl && currentUrls.indexOf('billings') < 0 )){
		var baseurl     = base_url+"app/orders/destroySessionFilter";
		$.ajax({
			url: baseurl,
			type: 'post',
			success: function(data) {
				// console.log('success');
			}            
		});
	}
}

function destroySessionFilterForPresenterCalendar(){
    var previousUrl = document.referrer;
	var currentUrl = window.location.href;
	var currenturls = currentUrl.split("/");
	var urls = previousUrl.split("/");
	var  index = urls.indexOf("calendar");
	if(urls.indexOf("app") > 0 && urls.indexOf("presenters") > 0 && urls.indexOf("calendar") > 0 && currenturls.indexOf("calendar") < 0){
		var baseurl     = base_url+"app/presenters/destroySessionFilterForPresenterCalendar";
        $.ajax({
            url: baseurl,
            type: 'post',
            success: function(data) {
                // console.log('success');
            }            
        });  
	}
}