<?php if($this->session->userdata('role') == 'school_admin') {?>
<link href="<?php echo HTTP_CSS_PATH;?>/jquery.signaturepad.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/numeric-1.2.6.min.js"></script> 
<script src="<?php echo HTTP_JS_PATH;?>/plugins/bezier.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/jquery.signaturepad.js"></script> 
		
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/json2.min.js"></script>
<?php }?>

<div class="container clearfix">
	<div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Billing</h3>
            </div>
            <div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div>
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
								<tr class="gradeA even" role="row">
									<td class="sorting_1">Order details<br> <a href="javascript:;" onclick="expandSubOrder('<?php echo $order->id;?>');" class="expand">Expand</a></td>
									<td><?php echo $order->school_name;?></td>
									<td><?php echo $order->order_no;?></td>
									<td class="center"><?php echo ($order->hours-$order->total_hours_scheduled);?> out of <?php echo $order->hours;?> hours left to schedule</td>
									<td class="center"><?php echo ($order->last_day_scheduled)?"Last Day <br>".date_display($order->last_day_scheduled):"No Schedule"?></td>
								</tr>
								<tr>
									<td colspan="5" id="sub-order-<?php echo $order->id;?>" style="display:none">
										<table class="table sub-order" width="100%">
											<tr>
												<th>Sub Order</th>
												<th colspan="2">Status</th>
											</tr>
											<?php $submit_btn = false; ?>
											<?php foreach ($schedules as $row) {?>
											<tr>
												<td><?php echo date_display($row->start_date, "l, F j, Y");?> @ <?php echo $row->teacher;?> <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?></td>
												<?php echo billing_status_update($row, true);?>
												
												<td width="25%">
													<!-- If Current Status is "Hours scheduled" & Role is "administrator" -->
													<?php if($row->status == "Hours scheduled" && $this->session->userdata('role') == 'administrator') {?>
														<div id="draft_attached_<?php echo $row->id?>" style="display:none;">
															<input type="file" name="attachment[<?php echo $row->id;?>]" >
														</div>
														<?php $submit_btn = true;?>
													<?php }?>
													<!-- If Current Status is "Hours scheduled" & Role is not "administrator" -->
													<?php if($row->status == "Hours scheduled" && $this->session->userdata('role') != 'administrator') {?>
														Waiting for Administrator to attach draft.
													<?php }?>
													
													<!-- If Current Status is "Draft attached" & Role is "administrator" -->
													<?php if($row->status == "Draft attached" && $this->session->userdata('role') == 'administrator') {?>
														<div id="approved_<?php echo $row->id?>" style="display:none;">
															<input type="file" name="attachment[<?php echo $row->id;?>]" >
														</div>
														<?php $submit_btn = true;?>
													<?php }?>
													
													<!-- If Current Status is "Approved" & Role is "administrator" -->
													<?php if($row->status == "Approved" && $this->session->userdata('role') == 'administrator') {?>
														Waiting for Presenter to confirm hours.
													<?php }?>
													
													<!-- If Current Status is "Approved" & Role is "teacher" -->
													<?php if($row->status == "Approved" && $this->session->userdata('role') == 'teacher') {?>
														<div id="confirm_hours_<?php echo $row->id?>" style="display:none;">
															<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
															<button type="button" class="btn btn-danger" onclick="displayDeclineConfirm('<?php echo $row->id;?>');"><span class="glyphicon glyphicon-ban-circle"></span> Decline</button>
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
																		<?php echo date_display($row->start_date, "l, F j, Y");?> @ <?php echo $row->teacher;?> <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?>
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
																<input type="hidden" name="status[<?php echo $row->id;?>]" value="Create invoice"" >
															<?php } else {?>
																<input type="hidden" name="status[<?php echo $row->id;?>]" value="Log sent - awaiting principal signature" >
															<?php }?>
															<input type="file" name="attachment[<?php echo $row->id;?>]" >
														</div>
														<?php $submit_btn = true;?>
													<?php }?>
													
													<?php if((($row->status == "Approved" || $row->status == "Draft attached") && $this->session->userdata('role') == 'teacher') || (($this->session->userdata('role') == 'teacher' || $this->session->userdata('role') == 'administrator') && $row->status == "Log sent - awaiting principal signature") ) {
														if ($row->attachment) {
															echo ' <a href="'.base_url(DIR_TEACHER_FILES.$row->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
															echo "<br>Waiting for a status update.";
														}
													}?>
													
													<?php if($row->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'administrator')) {
														if ($row->content) {
															echo ' <a href="'.base_url('app/orders/display_log/'.$row->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
															echo "<br>Waiting for a status update.";
														}
													}?> 
													
													<!-- For Digital signature -->
													<?php if($row->status == "Log sent - awaiting principal signature" && $this->session->userdata('role') == 'school_admin') {?>
														<div id="signArea" >
															<h2 class="tag-ingo">Put signature below,</h2>
															<div class="sig sigWrapper" style="height:auto;">
																<div class="typed"></div>
																<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
															</div>
														</div>
														<input type="hidden" name="status[<?php echo $row->id;?>]" value="Awaiting Review" >
														<input type="hidden" name="content" id="content" >
														<button type="button" id="btnSaveSign" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Signature</button>
														<?php //$submit_btn = true;?>
													<?php }?> 
													
													<?php if($row->status == "Awaiting Review" && $this->session->userdata('role') == 'administrator') {?>
														<?php 
															if ($row->content) {
																echo ' <a href="'.base_url($row->content).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
															}
														?>
														<input type="hidden" name="status[<?php echo $row->id;?>]" value="Create invoice" >
														<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Approve</button>
													<?php }?> 
																							
													<?php if($row->status == "Create invoice" && $this->session->userdata('role') == 'teacher') {?>
														<input type="hidden" name="status[<?php echo $row->id;?>]" value="Invoice created" >
														<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Create Invoice</button>
													<?php }?> 
													
													<?php if($row->status == "Invoice created" && $this->session->userdata('role') == 'administrator') {?>
														<input type="hidden" name="status[<?php echo $row->id;?>]" value="Payment sent" >
														<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Send Payment</button>
													<?php }?> 
													
													<?php if($row->status == "Invoice created" && $this->session->userdata('role') != 'school_admin') {?>
														<?php 
															if ($row->attachment) {
																echo ' <a href="'.base_url($row->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
															}
														?>
													<?php }?>
													
													<?php if($row->status == "Payment sent" && $this->session->userdata('role') == 'administrator') {?>
														<?php $submit_btn = true;?>
													<?php }?>
													
													<input type="hidden" name="old_status[<?php echo $row->id;?>]" value="<?php echo $row->status?>" >
												</td>
											</tr>
											
											<?php }?>
											<?php if (count($schedules) == 0) { ?>
												<tr>
													<td colspan="100%">Sorry!! No Records found.</td>
												</tr>
											<?php } ?>
										</table>
										
										<?php if (count($schedules) > 0 && $submit_btn) {?>
											<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
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
		jQuery('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
	});
			
	jQuery("#btnSaveSign").click(function(e){
		html2canvas([document.getElementById('sign-pad')], {
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
						jQuery("#content").val(response.file_name);
						document.getElementById('frm_billing').submit()
					}
				});
			}
		});
	});
</script> 
<?php }?>