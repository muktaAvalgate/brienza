<?php if($this->session->userdata('role') == 'teacher') {?>
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
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Billing</h3>
            </div>
            <!-- <div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div> -->
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
			<table class="table table-bordered" id="datatable-order" style="width: 100%;" width="100%">
				<thead>
					<tr role="row">
						<th>School</th>
						<th>Title</th>
						<th>Order number</th>
						<th>Hours to confirm</th>
						<th>Billing Period</th>
						<th>Billing due date</th>
						<th>Click to billing</th>
					</tr>
                </thead>
                <tbody>
					<?php $i = 1;?>
					<?php  foreach($orders as $order) {?>					
						<tr>
							<td class="sorting_1" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo $order['school'];?>
								<?php
									if($order['late_flag'] == 1){
								?>
									<div class="latetag">Late</div>
								<?php
									}
								?>
							</td>
							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo $order['title'];?></td>
							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo $order['order_no'];?></td>
							<td class="center" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc">
								<?php
									// echo number_format($order['assigned_hours'] - $order['schedule_hours_confirm']).'/'.$order['assigned_hours'].' hours to confirm';
									echo number_format($order['schedule_hours'] - $order['schedule_hours_confirm']).'/'.number_format($order['schedule_hours']).' hours to confirm';
								?>
							</td>
							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo ($order['billing_period']?$order['billing_period']:'N/A'); ?></td>
							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo ($order['completed_by']?$order['completed_by']:'N/A'); ?></td>
							<td class="center">
							    
								<?php
									if($order['dwnld_flag'] == 1){
								?>
									<button type="button" class="btn dwnbtnnew" onclick="window.open('../../<?php echo $order['invoice_document'] ?>', '_blank')" >Download Invoice</button>
								<?php
									}else if($order['submit_invoice_counter'] == 0 || $order['payment_schedule_flag'] == 0){
										if($order['payment_schedule_flag'] == 0){
											$title = "Please contact billing support, no billing date was added for this billing period";
										}else{
											$title = "Invoice sessions are not ready for Invoice creation";
										}
								?>
									<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  data-title="<?php echo $title; ?>"  disabled >Submit Invoice</button>
								<?php
									}else{
								?>
									<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['session_from']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>');"  >Submit Invoice</button>
								<?php
									}
								?>
								
							</td>
						</tr>
						<tr>
							<td class="sorting_1" colspan="4">
							<?php
								if($order['late_flag'] == 1){
							?>
								<div class="late">This invoice has not been submitted on time, admin has been notified.</div>
							<?php
								}
							?>
							</td>
							<td class="sorting_1" colspan="3">
							<?php
								if($order['payDate_flag'] == 1){
							?>
								<div class="payDate">Payment will be sent on <?php echo $order['payment_date']; ?>.</div>
							<?php
								}
							?>
							</td>
							
						</tr>
						<tr class="sec collapse" id="<?php echo $i;?>">
							<td colspan="7">
							<div class="arrowupDiv"><i class="fa fa-arrow-circle-up" style="color: #1fa6c5; font-size: 30px;" onclick="arrCollapse();"></i></div>


							<!-- new add -->
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								echo form_open_multipart(base_url('app/orders/presenter_billing/?order_id='.$order['order_id']), $attributes);
							?>
							<!-- end new add -->

								<table class="table table-striped table-responsive table-hover sub-order">
										<tr>
											<!-- <th>Date Of Service</th>
											<th>Total Hours</th>
											<th>Status</th>
											<th></th> -->

											<!-- new add -->
											<th>Dates Of Service</th>
												<th>Total Hours</th>
												<th colspan="2">Action</th>
												<?php //if($order['approvedStatus'] && $this->session->userdata('role') == "teacher"){?>
												<!-- <th><input type="checkbox" name="selectall" id="selectAll" class="all" value="0" style="vertical-align: bottom;"><label for="selectAll">Select All</label></th> -->
											<?php// } ?>
											<!-- end new add -->

										</tr>
									
										<!-- new add -->
										<?php $submit_btn = false; ?>
										<!-- end new add -->

										<?php 
											if(count(array($order['order_schedules'])) > 0){
												foreach($order['order_schedules'] as $orderSchedules ){ ?>
												<tr>
													<!-- <td style="border:2px solid #763199;"><?php echo date_display($orderSchedules->start_date, "m/d/Y");?> @ <?php echo time_display($orderSchedules->start_date, true);?> to <?php echo time_display($orderSchedules->end_date, true);?> with <?php echo $orderSchedules->teacher.', Grade - '.$orderSchedules->grade_name; ?>, Topic -<?php echo $orderSchedules->topic_name; ?></td>
													<td style="border:2px solid #763199;background-color:#fff;"><?php echo round($orderSchedules->total_hours); ?></td>
													<td width="20%" style="border:2px solid #763199;">
														<select class="form-control">
															<option selected><?php echo $orderSchedules->status; ?></option>
															<option value="1">Create log</option>
														</select>
													</td>
													<td width="20%" style="border:2px solid #763199;">
														<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#history" data-ordr_id="<?php echo $order['order_id']; ?>"  data-startdate="<?php echo $order['session_from']; ?>" data-enddate="<?php echo $order['sessionEndDate']; ?>" data-schedule_id="<?php echo $orderSchedules->id; ?>"   style="margin-top: 4px;">View History</button>
													</td> -->



													<!-- new add -->
													<td style="border:2px solid #763199;"><?php echo date_display($orderSchedules->start_date, "m/d/Y");?> @ <?php echo time_display($orderSchedules->start_date, true);?> to <?php echo time_display($orderSchedules->end_date, true);?> with <?php echo $orderSchedules->teacher.', Grade - '.$orderSchedules->grade_name; ?>, Topic -<?php echo $orderSchedules->topic_name; ?>
					
													</td>
													<td style="border:2px solid #763199;background-color:#fff;"><span style=""><?php echo round($orderSchedules->total_hours);?></span></td>
													<!-- end code (2019-07-23) -->
													<?php echo billing_status_update($orderSchedules, true);?>
													
													<td width="40%" style="border:2px solid #763199;">
														<!-- If Current Status is "Hours scheduled" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Hours scheduled" && $this->session->userdata('role') == 'administrator') {?>
															<div id="draft_attached_<?php echo $orderSchedules->id?>" style="display:none;">
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" >

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php $submit_btn = true;?>
														<?php }?>
														<!-- If Current Status is "Hours scheduled" & Role is not "administrator" -->
														<?php if($orderSchedules->status == "Hours scheduled" && $this->session->userdata('role') != 'administrator') {?>
															Waiting for Administrator to attach draft.
														<?php }?>
														
														<!-- If Current Status is "Draft attached" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Draft attached" && $this->session->userdata('role') == 'administrator') {?>
															<div id="approved_<?php echo $orderSchedules->id?>">
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" >

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php 
															if ($orderSchedules->attachment) {
																/* echo ' <div id="file_attach_'. $orderSchedules->id.'"><a href="'.base_url('app/orders/download/'.$orderSchedules->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>'; */
																echo "<br>Waiting for a status update.</div>";
															}

															$submit_btn = true;?>
														<?php }?>
														
														<!-- If Current Status is "Approved" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'administrator') {
															
															if ($orderSchedules->attachment) {
																/* echo ' <div id="file_attach_'. $orderSchedules->id.'"><a href="'.base_url('app/orders/download/'.$orderSchedules->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>'; */
																echo "<br>Waiting for Presenter to confirm hours.</div>";
															}
														}?>
														
														<!-- If Current Status is "Approved" & Role is "teacher" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'teacher') {?>
															<div id="confirm_hours_<?php echo $orderSchedules->id?>" style="display:none;">
																
																<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>

																<button type="button" class="btn btn-danger" onclick="displayDeclineConfirm('<?php echo $orderSchedules->id;?>');"><span class="glyphicon glyphicon-ban-circle"></span> Decline</button>
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
																			<a class="closeLogPopup" href="<?php echo base_url('app/presenters/create_log_billing/?id='.$orderSchedules->id); ?>" target="_blank">Yes</a> Or <a href="javascript:void(0)" class="closeLogPopup" >cancel</a> to continue.
																		</div>
																		<div class="modal-footer">
																		</div>
																	</div>
																</div>
															</div>

															<!-- Set Reject Modal -->
															<div class="modal fade" id="displayDeclineConfirm_<?php echo $orderSchedules->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																<div class="modal-dialog modal-md">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			<h4 class="modal-title">Confirm</h4>
																		</div>
																		<div class="modal-body">
																			<p><?php echo date_display($orderSchedules->start_date, "l, F j, Y");?> @ <?php echo $orderSchedules->teacher;?> <?php echo time_display($orderSchedules->start_date, true);?>-<?php echo time_display($orderSchedules->end_date, true);?></p>
																		</div>
																		<div class="modal-footer">
																			<button type="submit" name="status[<?php echo $orderSchedules->id;?>]" value="Rejected - reschedule" class="btn btn-primary">Yes, I will reschedule</button>
																			<button type="submit" name="status[<?php echo $orderSchedules->id;?>]" value="Rejected - don't want" class="btn btn-default">No, don't want these hours</button>
																		</div>
																	</div>
																</div>
															</div>
															
														<?php }?>
														
														<!-- If Current Status is "Confirm hours" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Confirm hours" && $this->session->userdata('role') == 'administrator') {?>
															Waiting for Presenter to upload / create log.
														<?php }?>
														
														<!-- If Current Status is "Confirm hours" & Role is "teacher" -->
														<?php if($orderSchedules->status == "Confirm hours" && $this->session->userdata('role') == 'teacher') {?>
															<div id="create_log_<?php echo $orderSchedules->id?>" style="display:none">
																<?php if ($orderSchedules->worktype_name != "Workshop") {?>
																	<a href="<?php echo base_url('app/presenters/create_log_billing/?id='.$orderSchedules->id);?>" target="_blank" class="btn btn-default">Create Log</a><br />
																	<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Create invoice" > -->
																<?php } else {?>
																	<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Log sent - awaiting principal signature" > -->
																<?php }?>
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" >

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php $submit_btn = true;?>
														<?php }?>
														
														<?php if((($orderSchedules->status == "Approved" || $orderSchedules->status == "Draft attached") && $this->session->userdata('role') == 'teacher') || (($this->session->userdata('role') == 'teacher' || $this->session->userdata('role') == 'administrator') && $orderSchedules->status == "Log sent - awaiting principal signature") ) {
															if ($orderSchedules->attachment) {
																// echo ' <a href="https://img246.managed.center/'.$orderSchedules->attachment.'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																// echo "<br>Waiting for a status update.";

																/* echo ' <a href="'.base_url('assets/teachers/'.$orderSchedules->attachment).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>'; */
																echo "<br>Waiting for a status update.";
															}
														}?>
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'school_admin')) {
															if ($orderSchedules->content) {
																/* echo ' <a href="'.base_url('app/orders/display_log/'.$orderSchedules->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>'; */
																echo "<br>Waiting for a status update.";
															}else{
																/* echo ' <a href="https://img247.managed.center/'.$orderSchedules->attachment.'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>'; */
																echo "<br>Waiting for a status update.";
															}
														}?> 
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'teacher')) { ?>
															<!-- <input type="file" name="attachment[<?php //echo $row->id;?>]" class="upload_file" > -->

																<!-- For update attach file -->
															<!-- <input type="hidden" name="order_schedule_status_id[<?php //echo $row->id;?>]" value="<?php //echo $row->order_schedule_status_id; ?>">
															<input type="hidden" name="status[<?php //echo $row->id;?>]" value="Awaiting Review" >
															Upload signed log file. -->
															<?php //$submit_btn = true;?>
														<?php }?> 
														<!-- For Digital signature -->
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && $this->session->userdata('role') == 'school_admin' && $orderSchedules->log_status=='template') {?>
															<div class="signArea" >
																<h2 class="tag-ingo">Put signature below,</h2>
																<div class="sig sigWrapper" style="height:auto;">
																	<div class="typed"></div>
																	<canvas class="sign-pad" id="sign-pad-<?php echo $orderSchedules->id ?>" width="300" height="100"></canvas>
																	<input type="hidden" name="output" class="output sign-output-<?php echo $orderSchedules->id ?>">
																</div>
															</div>
															<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Awaiting Review" > -->
															<!-- <input type="hidden" name="content" id="content" > -->
															<button type="button" id="btnSaveSign_<?php echo $orderSchedules->id;?>" class="btn btn-primary btnSaveSign" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Save Signature</button>
															<?php //$submit_btn = true;?>
														<?php }?> 
														
														<?php if($orderSchedules->status == "Awaiting Review" && $this->session->userdata('role') == 'administrator') {?>
															<?php 
																if ($orderSchedules->content) {
																	// echo ' <a href="'.base_url($row->content).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																	echo ' <a href="'.base_url('app/orders/display_log/'.$orderSchedules->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																}
																if ($orderSchedules->attachment) {
																	echo ' <a href="'.base_url(DIR_TEACHER_FILES.$orderSchedules->attachment).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																}
															?>
															<input type="hidden" name="status[<?php echo $orderSchedules->id;?>]" value="Create invoice" >
															<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Approve</button>
														<?php }?> 
																								
														<!-- <?php //if($orderSchedules->status == "Create invoice" && $this->session->userdata('role') == 'teacher') {
															// $create_invoice_date = get_session_invoice_date($order['order_id'], $orderSchedules->id);
															// // $ready_to_invoice	 = is_order_readyto_invoice($order->id, $row->id);
															// //print_r($create_invoice_date);
															// if(isset($create_invoice_date)){
															// 	if($create_invoice_date['billing_date'] >= date('Y-m-d'))
															// 	{						
														?>
															<div class="invoiceSignArea" >
																<h2 class="tag-ingo">Put signature below,</h2>
																<div class="sig sigWrapper" style="height:auto;">
																	<div class="typed"></div>
																	<canvas class="sign-pad" id="invoice-sign-pad-<?php echo $orderSchedules->id ?>" width="300" height="100"></canvas>
																	<input type="hidden" name="output" class="output invoice-sign-output-<?php echo $orderSchedules->id ?>">
																</div>
															</div>
															<!-- <input type="hidden" name="status[<?php //echo $row->id;?>]" value="Invoice created" > -->
															<!-- <input type="hidden" name="content" id="invoiceContent" > -->
															<!-- <button type="button" id="invoiceBtnSaveSign_<?php echo $orderSchedules->id;?>" class="btn btn-success invoiceBtnSaveSign" data-id="<?php echo $orderSchedules->id ?>" data-order_id="<?php echo $orderSchedules->order_id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Create Invoice</button> -->
														<?php //}
															// }
															// }
														?> 
														
														<?php if($orderSchedules->status == "Invoice created" && $this->session->userdata('role') == 'administrator') {?>
															<input type="hidden" name="status[<?php echo $orderSchedules->id;?>]" value="Payment sent" >
															<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Send Payment</button>
														<?php }?> 
														
														<?php if($orderSchedules->status == "Invoice created" && $this->session->userdata('role') != 'school_admin') {?>
															<?php 
																if ($orderSchedules->attachment) {
																	echo ' <a href="'.base_url('app/orders/download/'.$orderSchedules->id).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
																}
															?>
														<?php }?>
														
														<?php if($orderSchedules->status == "Invoice created" && $this->session->userdata('role') == 'teacher') {?>
															<br/>Waiting for payment by administrator
														<?php }?> 
														
														<?php 
														// if($row->status == "Payment sent" && $this->session->userdata('role') == 'administrator') {
														if($orderSchedules->status == "Payment sent") {

															echo date('F j, Y', strtotime($orderSchedules->created_on)).' / $'. number_format(($order['bill_rate'] * $orderSchedules->total_hours), 2);
														?>
															<?php $submit_btn = true;?>
														<?php }?>
														
														<input type="hidden" name="old_status[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->status?>" >

														<!-- <a href="javascript:;"  class="show_logs btn"  data-id="<?php echo $orderSchedules->id ?>">Expand</a> -->

														<!-- add new -->
														<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#history" data-ordr_id="<?php echo $order['order_id']; ?>"  data-startdate="<?php echo $order['session_from']; ?>" data-enddate="<?php echo $order['sessionEndDate']; ?>" data-schedule_id="<?php echo $orderSchedules->id; ?>"   style="margin-top: 4px;">View History</button>
														<!-- end add new -->

													</td>

													<?php //if($order['approvedStatus'] && $this->session->userdata('role') == "teacher"){?>
														<!-- <td width="15%" id="checkBox" style="border:2px solid #763199;">
															<?php 
																// if($orderSchedules->status == 'Approved' && date('Y-m-d H:i:s') > $orderSchedules->end_date){
															?>
															<input type="checkbox" name="check[]" value="<?php echo $orderSchedules->id?>" class="checkBox"> -->
															<?php 
															// }
															?>
														<!-- </td> -->
													<?php //} ?>
													<!-- end new add -->


												</tr>
										<?php   }
											}else{
										?>
										<tr>
											<td>No records found.</td>
										</tr>
										<?php
										}
										?>
										
										
									
								</table>

								<!-- new add -->
								

							<!-- <button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button> -->

							<!-- new add -->
							<?php if (count($order['order_schedules']) > 0 && $submit_btn) {?>
								<button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
							<?php }?>

							<?php echo form_close();?>

							<!-- end new add -->
							
							</td>
						</tr>
						<tr style="padding:0px; margin:0px;">
							<td colspan="7"><hr style="margin-top: 0px; margin-bottom: 0px; border: 0; border-top: 1px solid;"/></td>
						</tr>
						<?php $i++;?>
					<?php } ?>
					
					<?php if (count($orders) == 0) { ?>
						<tr>
							<td colspan="100%">Sorry!! No Records found.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>      
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
	<?php //echo $this->pagination->create_links(); ?>
</div>



<!-- model -->
	<div id="signModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color:#763199;">Please provide your signature and submit to complete your billing</h4>
				</div>
				<div class="modal-body">
					<div class="invoiceSignArea" >
						<div class="sig sigWrapper" style="height:auto;">
						<div class="typed"></div>
						<canvas class="sign-pad" id="invoice-sign-pad" width="300" height="100"></canvas>
						<input type="hidden" name="output" class="output invoice-sign-output">
						<input type="hidden" id="hdn_oder_id">
						<input type="hidden" id="hdn_session_from">
						<input type="hidden" id="hdn_session_end">
						<input type="hidden" id="hdn_late_flag">
					</div>
					</div>
						<button type="button" class="btn mybtn" id="savebtn">Submit</button>
						<button type="button" class="btn mybtn" id="spinner_btn" style="display:none;">Please wait<i class="fa fa-spinner fa-spin" style="margin-left: 5px;"></i></button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>



	<!-- Modal -->

<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="historyLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="historyLabel">Session History</h4>
      </div>
      <div class="modal-body" style="padding: 18px;">
	  	<table class="resultappend" width="100%">
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="msgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <!-- <h4 class="modal-title">Please provide your signature and submit to complete your billing</h4> -->
	      </div>
	      <div class="modal-body">
	        <h4 class="modal-title">Your invoice has been successfully submitted.</h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		//late msg
		setTimeout(function() { $('.late').css('display','none'); }, 30000);

		// $(".arrowupDiv").on('click', function(event){
		// 	alert(abc);
		// 	$('.collapse').collapse();
		// });

		// $(".arrowupDiv").click(function() {
		// 	alert( "Handler for .click() called." );
		// });
	});	


	function arrCollapse(){
		$('.abc').addClass("collapsed");
		$('.sec').removeClass("in");
	}

	function sign(order_id,session_from,session_end,late_flag){
		// alert(order_id);
		$('#hdn_oder_id').val(order_id);
		$('#hdn_session_from').val(session_from);
		$('#hdn_session_end').val(session_end);
		$('#hdn_late_flag').val(late_flag);
	}



	jQuery("#savebtn").click(function(e){
		$('#savebtn').css("display","none");
		$('#spinner_btn').css("display","block");
		var order_id = jQuery('#hdn_oder_id').val();
		var session_from = jQuery('#hdn_session_from').val();
		var session_end = jQuery('#hdn_session_end').val();
		var late_flag = jQuery('#hdn_late_flag').val();
		var output = jQuery('.invoice-sign-output').val();
		// alert(order_id);
		// alert(session_from);
		// alert(session_end);
		if(output == ''){
			alert('Please sign before submission');
			return false;
		}
		html2canvas([document.getElementById('invoice-sign-pad')], {
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
						//alert(response.file_name);
						

						save_invoice_for_biling(order_id,session_from,session_end,late_flag,response.file_name);
					}
				});
			}
		});
	});

	function save_invoice_for_biling(order_id, session_from, session_end, late_flag, content ){
		//alert(content);
		jQuery.ajax({
			url: base_url+'app/orders/save_billing_from_billing',
			data: { order_id:order_id, session_from:session_from, session_end:session_end, late_flag:late_flag, content:content, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				$('#savebtn').css("display","block");
				$('#spinner_btn').css("display","none");
				$('#signModal').modal('hide');
				$('#msgModal').modal('show');
				setTimeout(function(){ window.location.href=base_url+'app/presenters/billing' }, 4000);
				
			}
		});
	};


	

	$('#history').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var ordr_id = button.data('ordr_id') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var startdate = button.data('startdate') 
		var enddate = button.data('enddate') 
		var schedule_id = button.data('schedule_id')
		var modal = $(this)
		// modal.find('.modal-title').text('New message to ' + recipient)
		// modal.find('.modal-body input').val(recipient)
		$.ajax({
			url: base_url+'app/presenters/viewHistory_ajax',
			data: { ordr_id:ordr_id, startdate:startdate, enddate,enddate, schedule_id:schedule_id },
			type: 'post',
			success: function (response) {
				// console.log(response);
				modal.find('.modal-body .resultappend').html(response);
				
			},
			error:function(response){
				console.log(response);
			}
		});

	})

	// new add


	// jQuery(document).ready(function() {
	// 	jQuery('.invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
	// });
			
	// jQuery(".invoiceBtnSaveSign").click(function(e){
	// 	// var order_id = '<?php //echo $this->input->get('order_id') ?>';
	// 	var order_id = jQuery(this).attr('data-order_id');
	// 	var order_schedule_id = jQuery(this).attr('data-id');
	// 	var oldStatus = jQuery(this).attr('data-status');
	// 	var output = jQuery('.invoice-sign-output-'+order_schedule_id).val();
	// 	if(output == ''){
	// 		alert('Please sign before submission');
	// 		return false;
	// 	}

	// 	html2canvas([document.getElementById('invoice-sign-pad-'+order_schedule_id)], {
	// 		onrendered: function (canvas) {
	// 			var canvas_img_data = canvas.toDataURL('image/png');
	// 			var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
	// 			// ajax call to save image inside folder
	// 			jQuery.ajax({
	// 				url: base_url+'app/orders/save_sign',
	// 				data: { img_data:img_data },
	// 				type: 'post',
	// 				dataType: 'json',
	// 				async: false,
	// 				success: function (response) {
	// 					// jQuery("#invoiceContent").val(response.file_name);
	// 					// document.getElementById('frm_billing').submit()
	// 					save_invoicesign_status(order_id, order_schedule_id, 'Invoice created', oldStatus, response.file_name);
	// 				}
	// 			});
	// 		}
	// 	});
	// });
	// function save_invoicesign_status(order_id, order_schedule_id, status, old_status, content ){
	// 	var stats = {};
	// 	stats[order_schedule_id] = status;
	// 	var oldstats = {};
	// 	oldstats[order_schedule_id] = old_status;
	// 	jQuery.ajax({
	// 		url: base_url+'app/orders/billing/?order_id='+order_id,
	// 		data: { order_id:order_id, status:stats, old_status:oldstats, content:content, ajaxCall:true },
	// 		type: 'post',
	// 		async: false,
	// 		success: function (response) {
	// 			window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
	// 		}
	// 	});
	// };




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
				url: base_url+'app/orders/presenter_billing/?order_id='+order_id,
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
		
		jQuery('.closeLogPopup').click(function(){
			var order_id = '<?php echo $this->input->get('order_id') ?>';
			window.location.href=base_url+'app/presenters/billing';
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
	// end new add

</script>


