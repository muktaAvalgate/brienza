<?php if($this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'teacher') {?>
<link href="<?php echo HTTP_CSS_PATH;?>/jquery.signaturepad.css" rel="stylesheet">
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="<?php echo HTTP_JS_PATH;?>/plugins/numeric-1.2.6.min.js"></script> 
<script src="<?php echo HTTP_JS_PATH;?>/plugins/bezier.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/jquery.signaturepad.js"></script> 
		
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/json2.min.js"></script>
<?php }?>

<div class="container clearfix">
	<div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-10 col-md-10 page-name">
                <h3>Sessions</h3>
            </div>
            <!-- <div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div> -->
			<?php if($approvedStatus && $this->session->userdata('role') == "teacher"){?>
			<div class="col-sm-2 col-md-2" style="text-align: right;">
				
				<button type="button" class="btn mybtn" id="confirm_dates">Confirm Selected Dates</button>
				
				
			</div>
			<?php }?>
			<?php if($this->session->userdata('role') == "teacher" && $previewButton){?>
			<div class="col-sm-2 col-md-2" style="text-align: right;">
				
				<a href="<?php echo base_url('app/orders/preview_invoice/?order_id='.$order->id);?>"><button type="button" class="btn prvbtn" id="preview_invoice">Preview Invoice</button></a>
				
			</div>
			<?php }?>
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
        <div class="row">
			<?php if (!empty($order)) { ?>
			<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<tbody>
					<tr class="gradeA even" role="row">
						<td>
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								echo form_open_multipart(base_url('app/orders/billing/?order_id='.$order->id), $attributes);
							?>
							<table class="table" width="100%">
								<tr class="gradeA even" role="row" >
									
									<td style="font-size:20px;"><b><?php echo $order->school_name;?></b></td>
									<td style="color:#753099;font-size:20px;font-weight:500;"><?php echo $order->order_no;?></td>
									<td style="color:#753099;"><?php echo $order->work_plan_number;?></td>
									<!-- <td class="center">
										<?php if($this->session->userdata('role') == 'teacher') { ?>
										<?php echo ($remaining_schedule_hrs); ?> out of <?php echo $schedulable_hr; ?> hours left to schedule		
										<?php } else { ?>
										<?php echo ($order->hours-$order->total_hours_scheduled);?> out of <?php echo $order->hours;?> hours left to schedule
										<?php } ?>
									</td>
									<td class="center"><?php echo ($order->last_day_scheduled)?"Last Day <br>".date_display($order->last_day_scheduled):"No Schedule"?></td> -->
									<td class="center" style="color:#753099;">
										Total Hours Confirmed : 
										<?php if($this->session->userdata('role') == 'teacher') {
											echo  $schedulable_hr-$remaining_schedule_hrs;
										 } else { 
										 	echo round($order->total_hours_scheduled);
										  } ?>
									</td>
									<td class="center" style="color:#753099;">Balance of Hours :
										<?php if($this->session->userdata('role') == 'teacher') {
											echo  $remaining_schedule_hrs;
											//echo $order->hours;
										 } else { 
										 	echo $order->hours-$order->total_hours_scheduled;
										  } ?>
									</td>
								</tr>
<tr>
	<td colspan="5" id="sub-order-<?php echo $order->id;?>">
    <div class="table-responsive">
		<table class="table table-striped table-responsive table-hover sub-order" width="100%">
			<tr>
				<th>Dates Of Service</th>
				<th>Total Hours</th>
				<th colspan="2">Action</th>
				<?php if($approvedStatus && $this->session->userdata('role') == "teacher"){?>
				<th><input type="checkbox" name="selectall" id="selectAll" class="all" value="0" style="vertical-align: bottom;"><label for="selectAll">Select All</label></th>
			<?php } ?>
			</tr>
			<?php $submit_btn = false; ?>

			<?php foreach ($schedules as $row) {?>
			<tr>
				<!-- Update code in this section by Ahmed (2019-07-23) -->
				<td style="border:2px solid #763199;"><?php echo date_display($row->start_date, "m/d/Y");?> @ <?php echo time_display($row->start_date, true);?> to <?php echo time_display($row->end_date, true);?> with <?php echo $row->teacher.', Grade - '.$row->grade_name; ?>, Topic -<?php echo $row->topic_name; ?>
					
				</td>
				<td style="border:2px solid #763199;background-color:#fff;"><span style=""><?php echo round($row->total_hours);?></span></td>
				<!-- end code (2019-07-23) -->
				<?php echo billing_status_update($row, true);?>
				
				<td width="40%" style="border:2px solid #763199;">
					<!-- If Current Status is "Hours scheduled" & Role is "administrator" -->
					<?php if($row->status == "Hours scheduled" && $this->session->userdata('role') == 'administrator') {?>
						<div id="draft_attached_<?php echo $row->id?>" style="display:none;">
							<input type="file" name="attachment[<?php echo $row->id;?>]" class="upload_file" >

							<!-- For update attach file -->
							<input type="hidden" name="order_schedule_status_id[<?php echo $row->id;?>]" value="<?php echo $row->order_schedule_status_id; ?>">
						</div>
						<?php $submit_btn = true;?>
					<?php }?>
					<!-- If Current Status is "Hours scheduled" & Role is not "administrator" -->
					<?php if($row->status == "Hours scheduled" && $this->session->userdata('role') != 'administrator') {?>
						Waiting for Administrator to attach draft.
					<?php }?>
					
					<!-- If Current Status is "Draft attached" & Role is "administrator" -->
					<?php if($row->status == "Draft attached" && $this->session->userdata('role') == 'administrator') {?>
						<div id="approved_<?php echo $row->id?>">
							<input type="file" name="attachment[<?php echo $row->id;?>]" class="upload_file" >

							<!-- For update attach file -->
							<input type="hidden" name="order_schedule_status_id[<?php echo $row->id;?>]" value="<?php echo $row->order_schedule_status_id; ?>">
						</div>
						<?php 
						if ($row->attachment) {
							echo ' <div id="file_attach_'. $row->id.'"><a href="'.base_url('app/orders/download/'.$row->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							echo "<br>Waiting for a status update.</div>";
						}

						$submit_btn = true;?>
					<?php }?>
					
					<!-- If Current Status is "Approved" & Role is "administrator" -->
					<?php if($row->status == "Approved" && $this->session->userdata('role') == 'administrator') {
						
						if ($row->attachment) {
							echo ' <div id="file_attach_'. $row->id.'"><a href="'.base_url('app/orders/download/'.$row->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							echo "<br>Waiting for Presenter to confirm hours.</div>";
						}
					}?>
					
					<!-- If Current Status is "Approved" & Role is "teacher" -->
					<?php if($row->status == "Approved" && $this->session->userdata('role') == 'teacher') {?>
						<div id="confirm_hours_<?php echo $row->id?>" style="display:none;">
							
							<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $row->id ?>" data-status="<?php echo $row->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>

							<button type="button" class="btn btn-danger" onclick="displayDeclineConfirm('<?php echo $row->id;?>');"><span class="glyphicon glyphicon-ban-circle"></span> Decline</button>
						</div>
						
						<!-- Confirm log Modal -->
						<div class="modal fade" id="ConfirmLogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-header">
										<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
										<h4 class="modal-title">Confirm Session</h4>
									</div>
									<div class="modal-body">
										If you want to create log, click on 
										<a class="closeLogPopup" href="<?php echo base_url('app/presenters/create_log/?id='.$row->id); ?>" target="_blank">Yes</a> Or <a href="javascript:void(0)" class="closeLogPopup" >cancel</a> to continue.
									</div>
									<div class="modal-footer">
									</div>
								</div>
							</div>
						</div>

						<!-- Set Reject Modal -->
						<div class="modal fade" id="displayDeclineConfirm_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Confirm</h4>
									</div>
									<div class="modal-body">
										<p><?php echo date_display($row->start_date, "l, F j, Y");?> @ <?php echo $row->teacher;?> <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?></p>
									</div>
									<div class="modal-footer">
										<button type="submit" name="status[<?php echo $row->id;?>]" value="Rejected - reschedule" class="btn btn-primary">Yes, I will reschedule</button>
										<button type="submit" name="status[<?php echo $row->id;?>]" value="Rejected - don't want" class="btn btn-default">No, don't want these hours</button>
									</div>
								</div>
							</div>
						</div>
						
					<?php }?>
					
					<!-- If Current Status is "Confirm hours" & Role is "administrator" -->
					<?php if($row->status == "Confirm hours" && $this->session->userdata('role') == 'administrator') {?>
						Waiting for Presenter to upload / create log.
					<?php }?>
					
					<!-- If Current Status is "Confirm hours" & Role is "teacher" -->
					<?php if($row->status == "Confirm hours" && $this->session->userdata('role') == 'teacher') {?>
						<div id="create_log_<?php echo $row->id?>" style="display:none">
							<?php if ($row->worktype_name != "Workshop") {?>
								<a href="<?php echo base_url('app/presenters/create_log/?id='.$row->id);?>" target="_blank" class="btn btn-default">Create Log</a><br />
								<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Create invoice" > -->
							<?php } else {?>
								<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Log sent - awaiting principal signature" > -->
							<?php }?>
							<input type="file" name="attachment[<?php echo $row->id;?>]" class="upload_file" >

							<!-- For update attach file -->
							<input type="hidden" name="order_schedule_status_id[<?php echo $row->id;?>]" value="<?php echo $row->order_schedule_status_id; ?>">
						</div>
						<?php $submit_btn = true;?>
					<?php }?>
					
					<?php if((($row->status == "Approved" || $row->status == "Draft attached") && $this->session->userdata('role') == 'teacher') || (($this->session->userdata('role') == 'teacher' || $this->session->userdata('role') == 'administrator') && $row->status == "Log sent - awaiting principal signature") ) {
						if ($row->attachment) {
							echo ' <a href="https://img246.managed.center/'.$row->attachment.'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							echo "<br>Waiting for a status update.";
						}
					}?>
					
					<?php if($row->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'school_admin')) {
						if ($row->content) {
							echo ' <a href="'.base_url('app/orders/display_log/'.$row->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							echo "<br>Waiting for a status update.";
						}else{
							echo ' <a href="https://img247.managed.center/'.$row->attachment.'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							echo "<br>Waiting for a status update.";
						}
					}?> 
					
					<?php if($row->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'teacher')) { ?>
						<!-- <input type="file" name="attachment[<?php //echo $row->id;?>]" class="upload_file" > -->

							<!-- For update attach file -->
						<!-- <input type="hidden" name="order_schedule_status_id[<?php //echo $row->id;?>]" value="<?php //echo $row->order_schedule_status_id; ?>">
						<input type="hidden" name="status[<?php //echo $row->id;?>]" value="Awaiting Review" >
						Upload signed log file. -->
						<?php //$submit_btn = true;?>
					<?php }?> 
					<!-- For Digital signature -->
					<?php if($row->status == "Log sent - awaiting principal signature" && $this->session->userdata('role') == 'school_admin' && $row->log_status=='template') {?>
						<div class="signArea" >
							<h2 class="tag-ingo">Put signature below,</h2>
							<div class="sig sigWrapper" style="height:auto;">
								<div class="typed"></div>
								<canvas class="sign-pad" id="sign-pad-<?php echo $row->id ?>" width="300" height="100"></canvas>
								<input type="hidden" name="output" class="output sign-output-<?php echo $row->id ?>">
							</div>
						</div>
						<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Awaiting Review" > -->
						<!-- <input type="hidden" name="content" id="content" > -->
						<button type="button" id="btnSaveSign_<?php echo $row->id;?>" class="btn btn-primary btnSaveSign" data-id="<?php echo $row->id ?>" data-status="<?php echo $row->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Save Signature</button>
						<?php //$submit_btn = true;?>
					<?php }?> 
					
					<?php if($row->status == "Awaiting Review" && $this->session->userdata('role') == 'administrator') {?>
						<?php 
							if ($row->content) {
								// echo ' <a href="'.base_url($row->content).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
								echo ' <a href="'.base_url('app/orders/display_log/'.$row->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							}
							if ($row->attachment) {
								echo ' <a href="'.base_url(DIR_TEACHER_FILES.$row->attachment).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							}
						?>
						<input type="hidden" name="status[<?php echo $row->id;?>]" value="Create invoice" >
						<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $row->id ?>" data-status="<?php echo $row->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Approve</button>
					<?php }?> 
															
					<?php /* if($row->status == "Create invoice" && $this->session->userdata('role') == 'teacher') {
						$create_invoice_date = get_session_invoice_date($order->id, $row->id);
						// $ready_to_invoice	 = is_order_readyto_invoice($order->id, $row->id);
						//print_r($create_invoice_date);
							if($create_invoice_date['billing_date'] >= date('Y-m-d'))
							{ */						
					?>
						<!--<div class="invoiceSignArea" >
							<h2 class="tag-ingo">Put signature below,</h2>
							<div class="sig sigWrapper" style="height:auto;">
								<div class="typed"></div>
								<canvas class="sign-pad" id="invoice-sign-pad-<?php echo $row->id ?>" width="300" height="100"></canvas>
								<input type="hidden" name="output" class="output invoice-sign-output-<?php echo $row->id ?>">
							</div>
						</div>-->
						<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Invoice created" > -->
						<!-- <input type="hidden" name="content" id="invoiceContent" > -->
						<!--<button type="button" id="invoiceBtnSaveSign_<?php echo $row->id;?>" class="btn btn-success invoiceBtnSaveSign" data-id="<?php echo $row->id ?>" data-status="<?php echo $row->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Create Invoice</button>-->
					<?php /* }
						} */
					?> 
					
					<?php if($row->status == "Invoice created" && $this->session->userdata('role') == 'administrator') {?>
						<input type="hidden" name="status[<?php echo $row->id;?>]" value="Payment sent" >
						<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $row->id ?>" data-status="<?php echo $row->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Send Payment</button>
					<?php }?> 
					
					<?php if($row->status == "Invoice created" && $this->session->userdata('role') != 'school_admin') {?>
						<?php 
							if ($row->attachment) {
								echo ' <a href="'.base_url('app/orders/download/'.$row->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
							}
						?>
					<?php }?>
					
					<?php if($row->status == "Invoice created" && $this->session->userdata('role') == 'teacher') {?>
						<br/>Waiting for payment by administrator
					<?php }?> 
					
					<?php 
					// if($row->status == "Payment sent" && $this->session->userdata('role') == 'administrator') {
					if($row->status == "Payment sent") {

						echo date('F j, Y', strtotime($row->created_on)).' / $'. number_format(($order->hourly_rate * $row->total_hours), 2);
					?>
						<?php $submit_btn = true;?>
					<?php }?>
					
					<input type="hidden" name="old_status[<?php echo $row->id;?>]" value="<?php echo $row->status?>" >

					 <a href="javascript:;"  class="show_logs btn"  data-id="<?php echo $row->id ?>">Expand</a>
				</td>
				<?php if($approvedStatus && $this->session->userdata('role') == "teacher"){?>
				<td width="15%" id="checkBox" style="border:2px solid #763199;">
					<?php 
						if($row->status == 'Approved' && date('Y-m-d H:i:s') > $row->end_date){
					?>
					<input type="checkbox" name="check[]" value="<?php echo $row->id?>" class="checkBox">
					<?php 
					}
					?>
				</td>
			<?php } ?>
					
			</tr>
            <tr  style="display: none;"  class="show_log_<?php echo $row->id ?> ">
             <td colspan="3">
               <table width="100%" cellpadding="0" cellspacing="0" border="0" class="sub-sub-order"> 
			<?php foreach ($row->order_log as $k1 => $order_log) {?>
            
				<tr>
					<?php if($order_log->new_status != 'Create invoice'){ ?>
					<td style="padding:15px 0;"><p><?php echo date_display($row->start_date, "l, F j, Y");?> @ <?php echo $row->teacher;?> <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?></p>
						
					</td>
					<td>
						<?php
						if($order_log->new_status == 'Invoice created'){
							echo "Invoice created";
						}elseif ($order_log->new_status == 'Awaiting Review') {
							echo "Awaiting Review";
						}elseif($order_log->new_status == 'Log sent - awaiting principal signature'){
							echo "Log sent - awaiting principal signature";
						}elseif($order_log->new_status == 'Confirm hours'){
							echo "Hours Confirmed";
						}elseif($order_log->new_status == 'Approved'){
							echo "Approved";
						}elseif($order_log->new_status == 'Draft attached'){
							echo "Draft attached";
						}
						?>
					</td>
					<td>
						<?php
						if($order_log->new_status != 'Confirm hours'){
							if($order_log->attachment && $order_log->attachment != NULL){
								if($order_log->new_status == 'Invoice created'){
									echo ' <a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
								}else{
									echo ' <div id="file_attach_'. $order_log->id.'"><a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
								}
							}if($order_log->content){
								echo ' <a href="'.base_url('app/orders/display_log/'.$row->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							}
						}else{
							echo "--";
						}
						?>
					</td>
					<?php } ?>

				</tr>
            
            
			<?php } ?>
			 </table>
             
             </td>
            </tr>
						
			<?php }?>
			<?php if (count($schedules) == 0) { ?>
				<tr>
					<td colspan="100%">Sorry!! No Records found.</td>
				</tr>
			<?php } ?>
		</table>
	</div>
		<?php if (count($schedules) > 0 && $submit_btn) {?>
			<button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
		<?php }?>
	</td>
</tr>
							</table>
							<?php echo form_close();?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php }?>
		</div>        
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
	</div>
</div>


<?php if($this->session->userdata('role') == 'school_admin') {?>
<script>

	jQuery(document).ready(function() {
		jQuery('.signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		

	});
			
	jQuery(".btnSaveSign").click(function(e){
		var order_id = '<?php echo $this->input->get('order_id') ?>';
		var order_schedule_id = jQuery(this).attr('data-id');
		var oldStatus = jQuery(this).attr('data-status');
		var output = jQuery('.sign-output-'+order_schedule_id).val();
		if(output == ''){
			alert('Please sign before submission');
			return false;
		}

		html2canvas([document.getElementById('sign-pad-'+order_schedule_id)], {
			onrendered: function (canvas) {
				var canvas_img_data = canvas.toDataURL('image/png');
				var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
				// ajax call to save image inside folder
				jQuery.ajax({
					url: base_url+'app/orders/save_sign',
					data: { img_data:img_data },
					type: 'post',
					dataType: 'json',
					async: false,
					success: function (response) {
						// jQuery("#content").val(response.file_name);
						// document.getElementById('frm_billing').submit()
						save_logsign_status(order_id, order_schedule_id, 'Awaiting Review', oldStatus, response.file_name);
					}
				});
			}
		});
	});
	function save_logsign_status(order_id, order_schedule_id, status, old_status, content ){
		var stats = {};
		stats[order_schedule_id] = status;
		var oldstats = {};
		oldstats[order_schedule_id] = old_status;
		jQuery.ajax({
			url: base_url+'app/orders/billing/?order_id='+order_id,
			data: { order_id:order_id, status:stats, old_status:oldstats, content:content, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
			}
		});
	};
</script> 
<?php }?>

<?php if($this->session->userdata('role') == 'administrator') {?>
<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('.approveBtn').on('click', function(){
			var order_id = '<?php echo $this->input->get('order_id') ?>';
			var order_schedule_id = jQuery(this).attr('data-id');
			var oldStatus = jQuery(this).attr('data-status');
			if(oldStatus == "Invoice created"){
				oldstatus1 = "Payment sent";
			}else{
				oldstatus1 = "Create invoice";
			}
			var stats = {};
			stats[order_schedule_id] = oldstatus1;
			var oldstats = {};
			oldstats[order_schedule_id] = oldStatus;
			
			jQuery.ajax({
				type: "POST",
				url: base_url+'app/orders/billing/?order_id='+order_id,
				data: { order_id:order_id, status:stats, old_status:oldstats, ajaxCall:true },
				async: true,
				success: function(response){
					window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
				}
			});
		});
	});
</script>
<?php } ?>

<?php if($this->session->userdata('role') == 'teacher') {?>
<script>


	jQuery(document).ready(function() {

		jQuery('.approveBtn').on('click', function(){
			var order_id = '<?php echo $this->input->get('order_id') ?>';
			var order_schedule_id = jQuery(this).attr('data-id');
			var oldStatus = jQuery(this).attr('data-status');
			
			var stats = {};
			stats[order_schedule_id] = 'Confirm hours';
			var oldstats = {};
			oldstats[order_schedule_id] = oldStatus;
			
			jQuery.ajax({
				type: "POST",
				url: base_url+'app/orders/billing/?order_id='+order_id,
				data: { order_id:order_id, status:stats, old_status:oldstats, ajaxCall:true },
				async: true,
				success: function(response){
					jQuery('#ConfirmLogModal').modal('show');
					//window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
				}
			});
		});
	});


	jQuery(document).ready(function() {
		jQuery('.invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
	});
			
	jQuery(".invoiceBtnSaveSign").click(function(e){
		var order_id = '<?php echo $this->input->get('order_id') ?>';
		var order_schedule_id = jQuery(this).attr('data-id');
		var oldStatus = jQuery(this).attr('data-status');
		var output = jQuery('.invoice-sign-output-'+order_schedule_id).val();
		if(output == ''){
			alert('Please sign before submission');
			return false;
		}

		html2canvas([document.getElementById('invoice-sign-pad-'+order_schedule_id)], {
			onrendered: function (canvas) {
				var canvas_img_data = canvas.toDataURL('image/png');
				var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
				// ajax call to save image inside folder
				jQuery.ajax({
					url: base_url+'app/orders/save_sign',
					data: { img_data:img_data },
					type: 'post',
					dataType: 'json',
					async: false,
					success: function (response) {
						// jQuery("#invoiceContent").val(response.file_name);
						// document.getElementById('frm_billing').submit()
						save_invoicesign_status(order_id, order_schedule_id, 'Invoice created', oldStatus, response.file_name);
					}
				});
			}
		});
	});
	function save_invoicesign_status(order_id, order_schedule_id, status, old_status, content ){
		var stats = {};
		stats[order_schedule_id] = status;
		var oldstats = {};
		oldstats[order_schedule_id] = old_status;
		jQuery.ajax({
			url: base_url+'app/orders/billing/?order_id='+order_id,
			data: { order_id:order_id, status:stats, old_status:oldstats, content:content, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
			}
		});
	};
</script> 
<?php }?>

<script type="text/javascript">
	
	jQuery(document).ready(function() {
		
		jQuery('.closeLogPopup').click(function(){
			var order_id = '<?php echo $this->input->get('order_id') ?>';
			window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
		});

		// For table row show and hide
		jQuery('.show_logs').click(function(){
			var id = jQuery(this).data('id');
			jQuery('.show_log_'+id).slideToggle();
		});

		jQuery("#orderUpdateStatus").attr("disabled", true);
		var counter = 0;

		jQuery('input[type=file]').change(function(){
			var ext = $(this).val().split('.').pop().toLowerCase();
			//Allowed file types
			if($.inArray(ext, ['png','jpg','jpeg', 'docx', 'doc', 'pdf', 'xls', 'xlsx', 'txt']) == -1) {
				alert('The file type is invalid!');
				if(counter==0){
					jQuery("#orderUpdateStatus").attr("disabled", true);
				}
			}else{
				jQuery("#orderUpdateStatus").attr("disabled", false);
				counter++;
			}
		})
	});
	
</script>
<script type="text/javascript">
	
	$('#selectAll').click(function(){
        if($(this).prop("checked")) {
            $(".checkBox").prop("checked", true);
        } else {
            $(".checkBox").prop("checked", false);
        }                
    });


    $('.checkBox').click(function(){
        if($(".checkBox").length == $(".checkBox:checked").length) { 
             //if the length is same then untick 
            $("#selectAll").prop("checked", true);
        }else {
            //vise versa
            $("#selectAll").prop("checked", false);            
        }
    });
    $('#confirm_dates').click(function(){
    	//alert($(".checkBox:checked").length);
    	var order_id = '<?php echo $this->input->get('order_id') ?>';
    	if($(".checkBox:checked").length == 0){
    		alert('Please Select a checkbox');
    	}else{
    		
    		var ids = [];
        	$('#checkBox input:checked').each(function() {
            	ids.push(this.value);
        	});
	        jQuery('#ConfirmLogModal').modal('show');
	        jQuery.ajax({
				url: base_url+'app/orders/multipleConfirmhoursUpdate',
				data: { scheduled_id:ids, ajaxCall:true },
				type: 'post',
				async: false,
				success: function (response) {
					//window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
				}
			});
    	}
    });
</script> 