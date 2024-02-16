<div class="container clearfix">
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