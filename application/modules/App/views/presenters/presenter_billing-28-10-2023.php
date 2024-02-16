<style>
 /* ::-webkit-file-upload-button {
  color: white;
  display: inline-block;
  background: #601A87;
  border: none;
  padding: 7px 15px;
  font-weight: 700;
  border-radius: 3px;
  white-space: nowrap;
  cursor: pointer;
  font-size: 10pt;
  text-decoration: none;
}  */

.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

</style>

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
			<div id="sub-menu" class="col-sm-2 col-md-2 pull-right">
                <div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getDetailsPre(this.value)">
						<?php foreach ($s_array as $key => $value) {?>
						<option value="<?php echo $key;?>" <?php if ($session_id == $key) {echo "selected";}?>><?php echo $value;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group" style="margin-top: 10px;">
				<span><b>Total hours assigned : <?php echo $totHoursAssgnd?round($totHoursAssgnd->total_assigned_hours):0;?></b></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
				<span><b>Total hours scheduled : <?php echo $totHoursSchedule?round($totHoursSchedule->total_scheduled_hours):0;?></b></span>
				</div>
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
					<?php  
						$public_school_flag=0;
						foreach($orders as $order) {
							if($order['order_schedules'][0]->status=='Invoice created'||$order['order_schedules'][0]->status=='Payment sent'||$order['order_schedules'][0]->status=='Completed'){
								$public_school_flag=1;
							}
							?>	
						<?php if($rdyInvc !=NULL){ 
							if($order['submit_invoice_counter'] == 1){
						?>					
						<tr>
							<td class="sorting_1" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo $order['school'];?>
								<?php
									if($order['late_flag'] == 1){
										// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
										if(($order['order_schedules'][0]->public_school_title_status=="unchecked") || ($public_school_flag==1 && $order['order_schedules'][0]->is_old_order=="0")){
								?>
											<div class="latetag">Late</div>
								<?php
										}
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

							<!-- <td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo ($order['completed_by']); ?></td> -->

							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php 
                            // if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
							if($order['schedule_status']=="unchecked"||$order['order_schedules'][0]->is_old_order=="0"){
                             echo ($order['completed_by']);
                             }else{ echo('Next available payroll cycle.');} ?></td>

							<!-- <td class="center">
							    
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
								<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['session_from']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>');"  >Submit Invoice</button>
								<?php
									}
								?>
								
							</td> -->

							<td class="center">
                                
                                <?php
                                    if($order['dwnld_flag'] == 1){
                                ?>
                                    <button type="button" class="btn dwnbtnnew" onclick="window.open('<?php echo base_url()?><?php echo $order['invoice_document'] ?>', '_blank')" >Download Invoice</button>
                                <?php
                                    }else if($order['submit_invoice_counter'] == 0 || $order['payment_schedule_flag'] == 0){
                                        // if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['submit_invoice_counter'] == 0){
										if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['submit_invoice_counter'] == 0){
                                        if($order['payment_schedule_flag'] == 0){
                                            $title = "Please contact billing support, no billing date was added for this billing period";
                                        }else{
                                            $title = "Invoice sessions are not ready for Invoice creation";
                                        }
                                ?>
                                    <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  data-title="<?php echo $title; ?>"  disabled >Submit Invoice</button>
                                <?php
                                    }else{
                                        $order['completed_by_DateFormat'] = 'N/A';
                                        // echo $order['completed_by_DateFormat'];
                                        // echo '<pre>'; print_r($order);
                                ?>
                                
                                <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['bill_period_start_date']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>','<?php echo $order['schedule_status']; ?>');"  >Submit Invoice</button>
                                <?php
                                }}else{
                                ?>
                                    <?php //echo $order['completed_by_DateFormat']; die; ?>
                                    <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['session_from']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>','<?php echo $order['schedule_status']; ?>');"  >Submit Invoice</button>
                                <?php
                                    }
                                ?>
                                
                            </td>



						</tr>
						<tr>
							<td class="sorting_1" colspan="4">
							<?php
								if($order['late_flag'] == 1){
									// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
									if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['order_schedules'][0]->is_old_order=="0"){
							?>
									<div class="late">This invoice has not been submitted on time, admin has been notified.</div>
							<?php
									}
								}
							?>
							</td>
							<td class="sorting_1" colspan="3">
							<?php
								if($order['payDate_flag'] == 1){
									// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
									if($order['order_schedules'][0]->public_school_title_status=="unchecked"|| $order['order_schedules'][0]->is_old_order=="0"){
							?>
										<div class="payDate">Payment will be sent on <?php echo $order['payment_date']; ?>.</div>
							<?php
									}
								}
							?>
							</td>
							
						</tr>
						<tr class="sec collapse" id="<?php echo $i;?>">
							<td colspan="7">
							<div class="arrowupDiv"><i class="fa fa-arrow-circle-up" style="color: #1fa6c5; font-size: 30px;" onclick="arrCollapse(<?php echo $i;?>);"></i></div>


							<!-- new add -->
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								echo form_open_multipart(base_url('app/orders/presenter_billing/?order_id='.$order['order_id']), $attributes);
							?>
							<!-- end new add -->

								<table class="table table-striped table-responsive table-hover sub-order">
										<tr>
											<!-- new add -->
											<th>Dates Of Service</th>
												<th>Total Hours</th>
												<th colspan="2">Action</th>
												
											<!-- end new add -->

										</tr>
									
										<!-- new add -->
										<?php $submit_btn = false; ?>
										<!-- end new add -->

										<?php 
											if(count(array($order['order_schedules'])) > 0){
												foreach($order['order_schedules'] as $orderSchedules ){ ?>
												<tr>

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
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

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
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php 
															if ($orderSchedules->attachment) {
															
																echo "<br>Waiting for a status update.</div>";
															}

															$submit_btn = true;?>
														<?php }?>
														
														<!-- If Current Status is "Approved" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'administrator') {
															
															if ($orderSchedules->attachment) {
																
																echo "<br>Waiting for Presenter to confirm hours.</div>";
															}
														}?>
														
														<!-- If Current Status is "Approved" & Role is "teacher" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'teacher') {?>
															<div id="confirm_hours_<?php echo $orderSchedules->id?>" style="display:none;">
																
															<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>" data-order_id="<?php echo $order['order_id'] ?>"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>

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
																			<a class="closeLogPopup" href="<?php echo base_url('app/presenters/create_log_billing/?id='.$orderSchedules->id); ?>" target="_blank">Yes</a> or <a href="javascript:void(0)" class="closeLogPopup" >Cancel</a> to continue.
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
																			<!-- <h4 class="modal-title">Confirm</h4> -->
																		</div>
																		<div class="modal-body">
																		
																			<p><?php echo 'Are you sure you want to decline this session?'; ?></p>
																		</div>
																		<div class="modal-footer">
																			
																			<button type="button" onclick="declineSchedule(<?php echo $orderSchedules->id;?>);" class="btn btn-primary">Yes</button>
                                                                            <button type="button"  onclick="cancelDecline(<?php echo $orderSchedules->id;?>);" class="btn btn-default">No</button>
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
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php $submit_btn = true;?>
														<?php }?>
														
														<?php if((($orderSchedules->status == "Approved" || $orderSchedules->status == "Draft attached") && $this->session->userdata('role') == 'teacher') || (($this->session->userdata('role') == 'teacher' || $this->session->userdata('role') == 'administrator') && $orderSchedules->status == "Log sent - awaiting principal signature") ) {
															if ($orderSchedules->attachment) {
																
																echo "<br>Waiting for a status update.";
															}
														}?>
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'school_admin')) {
															if ($orderSchedules->content) {
															
																echo "<br>Waiting for a status update.";
															}else{
															
																echo "<br>Waiting for a status update.";
															}
														}?> 
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'teacher')) { ?>
														
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
														<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#history" data-ordr_id="<?php echo $order['order_id']; ?>"  data-startdate="<?php echo $order['session_from']; ?>" data-enddate="<?php echo $order['sessionEndDate']; ?>" data-schedule_id="<?php echo $orderSchedules->id; ?>"   style="margin-top: 4px;float:right;">View History</button>
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
					<!-- <?php //} ?> -->
					<?php }}else{ ?>
						<tr>
							<td class="sorting_1" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo $order['school'];?>
								<?php
									if($order['late_flag'] == 1){
										// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
										if(($order['order_schedules'][0]->public_school_title_status=="unchecked") || ($public_school_flag==1 && $order['order_schedules'][0]->is_old_order=="0")){
								?>
											<div class="latetag">Late</div>
								<?php
										}
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

							<!-- <td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php echo ($order['completed_by']); ?></td> -->

							<td data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="false" class="abc"><?php 
                            // if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
							if($order['schedule_status']=="unchecked"||$order['order_schedules'][0]->is_old_order=="0"){
                             echo ($order['completed_by']);
                             }else{ echo('Next available payroll cycle.');} ?></td>

							<!-- <td class="center">
							    
								<?php
									if($order['dwnld_flag'] == 1){
								?>
									
									<button type="button" class="btn dwnbtnnew" onclick="window.open('<?php echo base_url($order['invoice_document']) ?>', '_blank')" >Download Invoice</button>
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
									<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['session_from']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>');"  >Submit Invoice</button>
								<?php
									}
								?>
								
							</td> -->

							<td class="center">
                                
                                <?php
                                    if($order['dwnld_flag'] == 1){
                                ?>
                                    <button type="button" class="btn dwnbtnnew" onclick="window.open('<?php echo base_url()?><?php echo $order['invoice_document'] ?>', '_blank')" >Download Invoice</button>
                                <?php
                                    }else if($order['submit_invoice_counter'] == 0 || $order['payment_schedule_flag'] == 0){
                                        // if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['submit_invoice_counter'] == 0){
										if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['submit_invoice_counter'] == 0){
                                        if($order['payment_schedule_flag'] == 0){
                                            $title = "Please contact billing support, no billing date was added for this billing period";
                                        }else{
                                            $title = "Invoice sessions are not ready for Invoice creation";
                                        }
                                ?>
                                    <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  data-title="<?php echo $title; ?>"  disabled >Submit Invoice</button>
                                <?php
                                    }else{
                                        $order['completed_by_DateFormat'] = 'N/A';
                                        // echo $order['completed_by_DateFormat'];
                                        // echo '<pre>'; print_r($order);
                                ?>
                                
                                <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['bill_period_start_date']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>','<?php echo $order['schedule_status']; ?>');"  >Submit Invoice</button>
                                <?php
                                }}else{
                                ?>
                                    <?php //echo $order['completed_by_DateFormat']; die; ?>
                                    <button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" data-ordr_id="<?php echo $order['order_id']; ?>"  onclick="sign('<?php echo $order['order_id']; ?>','<?php echo $order['session_from']; ?>','<?php echo $order['sessionEndDate'];?>','<?php echo $order['late_flag']; ?>','<?php echo $order['completed_by_DateFormat']; ?>','<?php echo $order['schedule_status']; ?>');"  >Submit Invoice</button>
                                <?php
                                    }
                                ?>
                                
                            </td>


						</tr>
						<tr>
							<td class="sorting_1" colspan="4">
							<?php
								if($order['late_flag'] == 1){
									// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
									if($order['order_schedules'][0]->public_school_title_status=="unchecked" || $order['order_schedules'][0]->is_old_order=="0"){
							?>
									<div class="late">This invoice has not been submitted on time, admin has been notified.</div>
							<?php
									}
								}
							?>
							</td>
							<td class="sorting_1" colspan="3">
							<?php
								if($order['payDate_flag'] == 1){
									// if($order['order_schedules'][0]->public_school_title_status=="unchecked"){
									if($order['order_schedules'][0]->public_school_title_status=="unchecked"|| $order['order_schedules'][0]->is_old_order=="0"){
							?>
										<div class="payDate">Payment will be sent on <?php echo $order['payment_date']; ?>.</div>
							<?php
									}
								}
							?>
							</td>
							
						</tr>
						<tr class="sec collapse" id="<?php echo $i;?>">
							<td colspan="7">
							<div class="arrowupDiv"><i class="fa fa-arrow-circle-up" style="color: #1fa6c5; font-size: 30px;" onclick="arrCollapse(<?php echo $i;?>);"></i></div>


							<!-- new add -->
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								echo form_open_multipart(base_url('app/orders/presenter_billing/?order_id='.$order['order_id']), $attributes);
							?>
							<!-- end new add -->

								<table class="table table-striped table-responsive table-hover sub-order">
										<tr>
											<!-- new add -->
											<th>Dates Of Service</th>
												<th>Total Hours</th>
												<th colspan="2">Action</th>
												
											<!-- end new add -->

										</tr>
									
										<!-- new add -->
										<?php $submit_btn = false; ?>
										<!-- end new add -->

										<?php 
											if(count(array($order['order_schedules'])) > 0){
												foreach($order['order_schedules'] as $orderSchedules ){ ?>
												<tr>
												
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
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

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
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php 
															if ($orderSchedules->attachment) {
																
																echo "<br>Waiting for a status update.</div>";
															}

															$submit_btn = true;?>
														<?php }?>
														
														<!-- If Current Status is "Approved" & Role is "administrator" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'administrator') {
															
															if ($orderSchedules->attachment) {
																
																echo "<br>Waiting for Presenter to confirm hours.</div>";
															}
														}?>
														
														<!-- If Current Status is "Approved" & Role is "teacher" -->
														<?php if($orderSchedules->status == "Approved" && $this->session->userdata('role') == 'teacher') {?>
															<div id="confirm_hours_<?php echo $orderSchedules->id?>" style="display:none;">
																
																<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>" data-order_id="<?php echo $order['order_id'] ?>"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>

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
																			<a class="closeLogPopup" href="<?php echo base_url('app/presenters/create_log_billing/?id='.$orderSchedules->id); ?>" target="_blank">Yes</a> or <a href="javascript:void(0)" class="closeLogPopup" >Cancel</a> to continue.
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
																			<!-- <h4 class="modal-title">Confirm</h4> -->
																		</div>
																		<div class="modal-body">
																			<!-- <p><?php echo date_display($orderSchedules->start_date, "l, F j, Y");?> @ <?php echo $orderSchedules->teacher;?> <?php echo time_display($orderSchedules->start_date, true);?>-<?php echo time_display($orderSchedules->end_date, true);?></p> -->

																			<p><?php echo 'Are you sure you want to decline this session?'; ?></p>

																		</div>
																		<div class="modal-footer">
																		
																			<button type="button" onclick="declineSchedule(<?php echo $orderSchedules->id;?>);" class="btn btn-primary">Yes</button>
																			<button type="button"  onclick="cancelDecline(<?php echo $orderSchedules->id;?>);" class="btn btn-default">No</button>

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
																
																<?php } else {?>
																
																<?php }?>
																<input type="file" name="attachment[<?php echo $orderSchedules->id;?>]" class="upload_file" onchange="checkFileType(this)">

																<!-- For update attach file -->
																<input type="hidden" name="order_schedule_status_id[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->order_schedule_status_id; ?>">
															</div>
															<?php $submit_btn = true;?>
														<?php }?>
														
														<?php if((($orderSchedules->status == "Approved" || $orderSchedules->status == "Draft attached") && $this->session->userdata('role') == 'teacher') || (($this->session->userdata('role') == 'teacher' || $this->session->userdata('role') == 'administrator') && $orderSchedules->status == "Log sent - awaiting principal signature") ) {
															if ($orderSchedules->attachment) {
																
																echo "<br>Waiting for a status update.";
															}
														}?>
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'school_admin')) {
															if ($orderSchedules->content) {
																
																echo "<br>Waiting for a status update.";
															}else{
															
																echo "<br>Waiting for a status update.";
															}
														}?> 
														
														<?php if($orderSchedules->status == "Log sent - awaiting principal signature" && ($this->session->userdata('role') == 'teacher')) { ?>
														
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
															
															<button type="button" id="btnSaveSign_<?php echo $orderSchedules->id;?>" class="btn btn-primary btnSaveSign" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Save Signature</button>
															<?php //$submit_btn = true;?>
														<?php }?> 
														
														<?php if($orderSchedules->status == "Awaiting Review" && $this->session->userdata('role') == 'administrator') {?>
															<?php 
																if ($orderSchedules->content) {
																	
																	echo ' <a href="'.base_url('app/orders/display_log/'.$orderSchedules->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																}
																if ($orderSchedules->attachment) {
																	echo ' <a href="'.base_url(DIR_TEACHER_FILES.$orderSchedules->attachment).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
																}
															?>
															<input type="hidden" name="status[<?php echo $orderSchedules->id;?>]" value="Create invoice" >
															<button type="button" class="btn btn-success approveBtn" data-id="<?php echo $orderSchedules->id ?>" data-status="<?php echo $orderSchedules->status ?>"><span class="glyphicon glyphicon-ok-sign"></span> Approve</button>
														<?php }?> 
																								
														
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
	
														if($orderSchedules->status == "Payment sent") {

															echo date('F j, Y', strtotime($orderSchedules->created_on)).' / $'. number_format(($order['bill_rate'] * $orderSchedules->total_hours), 2);
														?>
															<?php $submit_btn = true;?>
														<?php }?>
														
														<input type="hidden" name="old_status[<?php echo $orderSchedules->id;?>]" value="<?php echo $orderSchedules->status?>" >

														<!-- Print button -->
                                                        <?php if($orderSchedules->status == "Log sent - awaiting principal signature" && $this->session->userdata('role') == 'teacher') {?>
                                                            <div id="print_log">
                                                                <?php if ($orderSchedules->worktype_name != "Workshop") {?>
                                                                    <a  target="_blank" class="btn btn-default print" onclick="print_log(<?php if(isset($orderSchedules->id)){echo $orderSchedules->id;} ?>)">Print</a>
                                                                <?php } ?>
                                                                <!-- <input type="file" name="attachment[<?php echo $row->id;?>]" class="upload_file" > -->
																	<br>
                                                                    <div class="fileUpload btn btn-sm btn-primary" style=" padding: 2px 10px;margin-top: 3px; margin-left: 0rem;">
                                                                        <span> Upload Signed Log </span>
                                                                        <input id="photo_log<?php echo $orderSchedules->order_schedule_status_id;?>" type="file" class="upload" onchange="upload_document_for_presenter('<?php echo $orderSchedules->order_schedule_status_id;?>','<?php echo $orderSchedules->id;?>',this);"/>
                                                                    </div>
                                                                <!-- For update attach file -->
                                                                <!-- <input type="hidden" name="order_schedule_status_id[<?php echo $row->id;?>]" value="<?php //echo $row->order_schedule_status_id; ?>"> -->
                                                                <!-- <a  target="_blank" class="btn btn-default " >Upload Signed Log</a> <br> -->
                                                                
                                                            </div>
                                                            
                                                        <?php }?>

														<!-- add new -->
														<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#history" data-ordr_id="<?php echo $order['order_id']; ?>"  data-startdate="<?php echo $order['session_from']; ?>" data-enddate="<?php echo $order['sessionEndDate']; ?>" data-schedule_id="<?php echo $orderSchedules->id; ?>"   style="margin-top: 4px; float:right;">View History</button>
														<!-- end add new -->

													</td>

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
					<?php } ?>
					
					<?php if (count($orders) == 0) { ?>
						<tr>
							<td colspan="100%">Sorry!! No Records found.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>      
		</div>
            
        <!--<div class="row">
            <div class="col-lg-9 col-md-8"></div>
            <div class="col-lg-3 col-md-4 text-right">
				<div class="panel panel-success">
					<div class="panel-heading">
						Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModal">Click here</a>
                    </div>
				</div>
			</div>
        </div>-->
		<div class="row">
            <div class="col-lg-3 col-md-4">
                <button type="button" class="btn btn-primary" onclick="window.location.href = '<?php echo base_url('app/orders/download_previous_billing_csv/') ?>'">Download Previous Billing</button>
            </div>
            <div class="col-lg-6 col-md-4"></div>
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
						<input type="hidden" id="hdn_completed_by_DateFormat">
						<input type="hidden" id="hdn_schedule_status">
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

<!-- <div id="msgModal" class="modal fade" role="dialog"> -->
<div id="msgModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close show_loder" data-dismiss="modal">&times;</button>
	        <!-- <h4 class="modal-title">Please provide your signature and submit to complete your billing</h4> -->
	      </div>
	      <div class="modal-body">
	        <h4 class="modal-title">Your invoice has been successfully submitted.</h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default show_loder" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>


<!-- For loader -->
<div class="loader_img" style="display:none;"> </div>
<style type="text/css">
  .loader_img {
      position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(<?php echo base_url('assets/images/loader.gif'); ?>) center no-repeat #fff;
    opacity: .6;
  }
</style>

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


	function arrCollapse(id){
		$('abc').addClass("collapsed");
		//$('.sec').removeClass("in");
		//$('#1'+).addClass("collapsed");
		$('#'+id).removeClass("in");
	}

	//function sign(order_id,session_from,session_end,late_flag){
	function sign(order_id,session_from,session_end,late_flag,completed_by_DateFormat,schedule_stat){

		// alert(order_id);
		$('#hdn_oder_id').val(order_id);
		$('#hdn_session_from').val(session_from);
		$('#hdn_session_end').val(session_end);
		$('#hdn_late_flag').val(late_flag);
		$('#hdn_completed_by_DateFormat').val(completed_by_DateFormat);
		$('#hdn_schedule_status').val(schedule_stat);

	}

// added 04-10-2021
function declineSchedule(schedule_id){
        // alert('aa'); 
        // alert(schedule_id); die();
        jQuery.ajax({
            url: base_url+'app/orders/declineSchedule',
            data: { schedule_id:schedule_id },
            type: 'post',
            async: false,
            success: function (response) {
                if(response == 1){
                    // alert('Successfully deleted.');
                    window.location.href=base_url+'app/presenters/billing';
                }else{
                    alert('Something went wrong.');
                    window.location.href=base_url+'app/presenters/billing';
                }
            }
        });
    }
    function cancelDecline(id){
        jQuery('#displayDeclineConfirm_'+id).modal('hide');
    }


	jQuery("#savebtn").click(function(e){
		var order_id = jQuery('#hdn_oder_id').val();
		var session_from = jQuery('#hdn_session_from').val();
		var session_end = jQuery('#hdn_session_end').val();
		var late_flag = jQuery('#hdn_late_flag').val();
		var hdn_completed_by_DateFormat = jQuery('#hdn_completed_by_DateFormat').val();
		var output = jQuery('.invoice-sign-output').val();
		var schedule_status = jQuery('#hdn_schedule_status').val();
		// alert(order_id);
		// alert(session_from);
		// alert(session_end);
		if(output == ''){
			alert('Please sign before submission');
			return false;
		}
		$('#savebtn').css("display","none");
		$('#spinner_btn').css("display","block");
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
						save_invoice_for_biling(order_id,session_from,session_end,late_flag,hdn_completed_by_DateFormat,response.file_name,schedule_status);
					}
				});
			}
		});
	});

	//function save_invoice_for_biling(order_id, session_from, session_end, late_flag, content ){
	function save_invoice_for_biling(order_id, session_from, session_end, late_flag, hdn_completed_by_DateFormat, content,schedule_status ){
		//alert(content);
		jQuery.ajax({
			url: base_url+'app/orders/save_billing_from_billing',
			data: { order_id:order_id, session_from:session_from, session_end:session_end, late_flag:late_flag, hdn_completed_by_DateFormat:hdn_completed_by_DateFormat, content:content,schedule_status:schedule_status, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				$('#savebtn').css("display","block");
				$('#spinner_btn').css("display","none");
				$('#signModal').modal('hide');
				$('#msgModal').modal('show');
				// setTimeout(function(){ window.location.href=base_url+'app/presenters/billing' }, 4000);
				// jQuery('.loader_img').show();
				// setTimeout(function(){ window.location.reload() }, 4000);
				
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



	jQuery(document).ready(function() {

		jQuery('.approveBtn').on('click', function(){
			// var order_id = '<?php //echo $this->input->get('order_id') ?>';
			var order_id = jQuery(this).attr('data-order_id');
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
				// async: true,
				async: false,
				success: function(response){
					// jQuery('#ConfirmLogModal').modal('show');
					// //window.location.href=base_url+'app/orders/billing/?order_id='+order_id;
					if(response == true){
                        jQuery('#ConfirmLogModal').modal('show');
                    }else if(response == 4){
                        alert('Oops... This schedule has no longer been assigned to you!');
                        window.location.reload();
                    }
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
		//added
		var noCount = 0;
		var fSize = 0;
		//end

		jQuery('input[type=file]').change(function(){
			//for size
			var size = this.files[0].size;
			fSize = fSize + size;
			//file count
			noCount++;
			//end
			var ext = $(this).val().split('.').pop().toLowerCase();
			//validation for numbers of file counts.
			if(noCount >20 || fSize > 12582912){
				// alert('Cannot upload more than 20 files or the maximum file size should be less than 12MB');
				alert('                         Maximum of 20 files can be uploaded \r\n                                                    and \r\n                          Total file size should be less than 12MB.');
				// var file = document.getElementById("file1");
    			// file.value = file.defaultValue;
				fSize = fSize - size;
				noCount--;
				$(this).val('');
				jQuery("#orderUpdateStatus").attr("disabled", false);
			}else{
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
			}
			//Allowed file types
			// if($.inArray(ext, ['png','jpg','jpeg', 'docx', 'doc', 'pdf', 'xls', 'xlsx', 'txt']) == -1) {
			// 	// alert('The file type is invalid!');
			// 	return false;
			// 	if(counter==0){
			// 		jQuery("#orderUpdateStatus").attr("disabled", true);
			// 	}
			// }else{
			// 	jQuery("#orderUpdateStatus").attr("disabled", false);
			// 	counter++;
			// }
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
	        // jQuery('#ConfirmLogModal').modal('show');
			if(response == true){
				jQuery('#ConfirmLogModal').modal('show');
			}else{
				alert('Cannot approve a session that is scheduled on a unselected working day');
				window.location.href=base_url+'app/presenters/billing';
			}
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

	function reUpload_document_for_presenter(log_id,row_id,input){

		var imgVal = $('#photo'+log_id).val();
		if(imgVal=='') 
        { 
            alert("Oops! Please choose a file for reuploading."); 
            return false; 
        } 

		if(confirm("Are you sure you want to replace this document?")){
			var file = input.files[0];  // Get the selected file
			var forbiddenTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];  // Forbidden file types

			
			if (forbiddenTypes.includes(file.type)) {
			// File type is forbidden, display an alert
			alert('It seems you are trying to upload a doc file. Please convert this doc file to pdf and upload it again.');
			// Clear the file input field
			input.value = '';
			}else{
				jQuery('.loader_img').show();
				var property = document.getElementById('photo'+log_id).files[0];
				var image_name = property.name;
				
				var image_extension = image_name.split('.').pop().toLowerCase();
				// alert(image_extension);
				// // if(jQuery.inArray(image_extension,['gif','jpg','jpeg','png']) == -1){
				// //   alert("Invalid image file");
				// // }

				var form_data = new FormData();
				form_data.append("file",property);
				form_data.append('log_id', log_id);
				form_data.append('row_id', row_id);
				form_data.append('sign_log_status', 'sign_log_false');

				$.ajax({
				url:base_url+'app/orders/reUpload_document_for_presenter',
				method:'POST',
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function(){
					$('#msg').html('Loading......');
				},
				success:function(data){
					window.location.href=base_url+'app/presenters/billing';
					// window.location.reload();
					}
				});
				return false;
			}
		}else{
			document.getElementById('photo'+log_id).value="";
			return false;
		}
	}

	function upload_document_for_presenter(log_id,row_id,input){

		var imgVal = $('#photo_log'+log_id).val();
		if(imgVal=='') 
		{ 
			alert("Oops! Please choose a file for reuploading."); 
			return false; 
		} 

		if(confirm("Are you sure you want to upload this document?")){
			var file = input.files[0];  // Get the selected file
			var forbiddenTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];  // Forbidden file types

			
			if (forbiddenTypes.includes(file.type)) {
			// File type is forbidden, display an alert
			alert('It seems you are trying to upload a doc file. Please convert this doc file to pdf and upload it again.');
			// Clear the file input field
			input.value = '';
			}else{
				jQuery('.loader_img').show();
				var property = document.getElementById('photo_log'+log_id).files[0];
				var image_name = property.name;
				
				var image_extension = image_name.split('.').pop().toLowerCase();
				// alert(image_extension);
				// // if(jQuery.inArray(image_extension,['gif','jpg','jpeg','png']) == -1){
				// //   alert("Invalid image file");
				// // }

				var form_data = new FormData();
				form_data.append("file",property);
				form_data.append('log_id', log_id);
				form_data.append('row_id', row_id);
				form_data.append('sign_log_status', 'sign_log_true');

				$.ajax({
				url:base_url+'app/orders/reUpload_document_for_presenter',
				method:'POST',
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function(){
					$('#msg').html('Loading......');
				},
				success:function(data){
					window.location.href=base_url+'app/presenters/billing';
					// window.location.reload();
					}
				});
				return false;
			}
		}else{
			document.getElementById('photo_log'+log_id).value="";
			return false;
		}
	}

	function getDetailsPre(session){
		// alert(session);
		jQuery.ajax({
				url: base_url+'app/presenters/billing',
				data: { session:session, ajaxCall:true },
				type: 'post',
				async: false,
				success: function (response) {
					window.location.href=base_url+'app/presenters/billing/?pre_blng_session_id='+session;
				}
			});
	}

	function print_log(log_id){
        jQuery.ajax({
            url: '<?php echo base_url('app/presenters/print_log/');?>',
            data: {log_id:log_id},
            type: 'post',
            async: false,
            success: function (response) {
				var print_area = window.open();
				print_area.document.write(response);
				print_area.document.close();
				print_area.focus();
				print_area.print();
            }

        });
    }

	function checkFileType(input) {
			var file = input.files[0];  // Get the selected file
			var forbiddenTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];  // Forbidden file types

			if (file) {
				if (forbiddenTypes.includes(file.type)) {
				// File type is forbidden, display an alert
				alert('It seems you are trying to upload a doc file. Please convert this doc file to pdf and upload it again.');
				// Clear the file input field
				input.value = '';
				}
			}
		}

		$('.show_loder').click(function(){
			jQuery('.loader_img').show();
			window.location.reload()
   		 });

</script>


