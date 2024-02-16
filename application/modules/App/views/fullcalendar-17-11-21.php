
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
  
<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Order Schedule Calendar</h3>
            </div>
			<!-- <div class="col-sm-3 col-md-3 userprint hidden-print">
				<a href="javascript:;" onclick="window.print()"><span class="glyphicon glyphicon-print"><span> Print</a>
			</div> -->
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
					<form action="<?php echo base_url('app/calendar/index'); ?>" method="POST" name="srch_calendar" class="form-inline">


						<fieldset>
							<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
							<div class="row">

								<div class="col-sm-3">
									<div class="form-group" style="width: 100%; display: block;">
										<label>View Type</label><br/>
										<select name="srch_type" class="form-control srch_type" id="srch_type" style="width: 100%;">
											<option value="presenter" <?php echo $srch_type == 'presenter' ? 'selected' : '';?>>Presenter</option>
											<option value="school" <?php echo $srch_type == 'school' ? 'selected' : '';?>>School</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group" id="p_list" style="width: 100%; display: block;">
										<label>Select Presenter</label>	<br/>									
										<select name="presenter[]" class="form-control presenter_list" id="presenter_list" multiple="multiple" style="width: 100%;">
											<?php foreach ($presenter as $k => $p) { ?>
												<option value="<?php echo $p->id; ?>" <?php echo in_array($p->id, $presenterids) ? 'selected' : '' ?>><?php echo ucwords($p->presenter_name); ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" id="s_list" style="display: none; width: 100%;" >
										<label>Select School</label>	<br/>									
										<select name="school[]" class="form-control school_list" id="school_list" multiple="multiple" style="width: 100%; display: block;">
											<?php foreach ($school as $k1 => $s) { ?>
												<option value="<?php echo $s->id; ?>" <?php echo in_array($s->id, $schoolids) ? 'selected' : '' ?>><?php echo ucwords($s->school_name); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>`
								<div class="col-sm-3">
									<div class="form-group" style="width: 100%; display: block;">	
										<label>Select Title</label>	<br/>								
										<select name="title[]" class="form-control title_list" id="title_list" multiple="multiple" style="width: 100%;">
											<?php foreach ($title as $k2 => $t) { ?>
												<option value="<?php echo $t->id; ?>" <?php echo in_array($t->id, $titleids) ? 'selected' : '' ?>><?php echo ucwords($t->name); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
			                			<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(); ?>app/calendar/fullcalendar'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

										<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">&nbsp;</div>
							</div>
						</fieldset>
						
					</form>
				<div id="calendar"></div>	
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
				Loading schedule...
			</div>
		</div>
	</div>
</div>
   
<script type="text/javascript">
   $(document).ready(function(){

   		var viewtype = '<?php echo $srch_type ?>';
   		if(typeof viewtype !== 'undefined'){
   			if(viewtype == 'school'){
   				$('#s_list').show();
   				$('#p_list').hide();
   			}else{
   				$('#p_list').show();
   				$('#s_list').hide();
   			}
   		}


   		$('#srch_type').on('change', function(){
   			var type = $(this).val();
   			if(type == 'school'){
   				$("#presenter_list option:selected").prop("selected", false);
   				$('#s_list').show();
   				$('#p_list').hide();
   			}else{
   				$("#school_list option:selected").prop("selected", false);
   				$('#p_list').show();
   				$('#s_list').hide();
   			}
   		});
   });
    var events = <?php echo json_encode($schedules) ?>;
    
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
           
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      events    : events
    })
</script>
