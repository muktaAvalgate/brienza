		<!-- session -->
		<div class="container">
			<div id="sub-menu" class="pull-right" style="margin-bottom: -41px;">
				<div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getDetails()"; id="session">
						<?php foreach ($s_array as $key => $value) {?>
							<option value="<?php echo $key;?>" <?php echo $curr_session_id == $key?'selected':''; ?>><?php echo $value;?></option>
						<?php }?>
					</select>
					<input type="hidden" id="stDate" value="<?php echo $start_date;?>">
					<input type="hidden" id="endDate" value="<?php echo $end_date;?>">
				</div>
				<div class="form-group" style="margin-top: 10px;">
					<span><b>Total hours assigned : <?php echo $totHoursAssgnd?round($totHoursAssgnd->total_assigned_hours):0;?></b></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
					<span><b>Total hours scheduled : <?php echo $totHoursSchedule?round($totHoursSchedule->total_scheduled_hours):0;?></b></span>
				</div>
			</div>
			<!-- <div class="row">
			</div> -->
		</div>
		<!-- end -->

<div class="container clearfix" style="margin-top:-45px">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Calendar</h3>
            </div>
			<div class="col-sm-3 col-md-3 userprint hidden-print">
				<a href="javascript:;" onclick="window.print()"><span class="glyphicon glyphicon-print"><span> Print</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<?php echo $calendar;?>		
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
		<div class="row hidden-print">
			<div class="col-lg-9 col-md-8"></div>
			<div class="col-lg-3 col-md-4 text-right">
				<div class="panel panel-success">
					<div class="panel-heading">
						Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModal">Click here</a>
                    </div>
				</div>
			</div>
        </div>
	</div>
</div>

<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Schedule</h4>
		    </div>
		    <div class="modal-body">
				Loading calendar...
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function getDetails(){
		var session = $('#session').val();
		
		jQuery.ajax({
			url: base_url+'app/presenters/create_calendar_link',
			data: { session:session },
			type: 'post',
			success: function (response) {
				var link = base_url+'app/presenters/calendar/'+ response;
				window.location.href=link;
			}
		});
	}

</script>