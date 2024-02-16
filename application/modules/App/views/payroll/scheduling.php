<?php if($this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'teacher') {?>
<link href="<?php echo HTTP_CSS_PATH;?>/jquery.signaturepad.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/numeric-1.2.6.min.js"></script> 
<script src="<?php echo HTTP_JS_PATH;?>/plugins/bezier.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/jquery.signaturepad.js"></script> 
		
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/json2.min.js"></script>
<?php }?>
<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-time"></span> Manage Payroll Schedule</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/payroll');?>"><span class="glyphicon glyphicon-time"></span> Payment Schedule</a></li>
				<li><a href="<?php echo base_url('app/payroll/payment_schedules_add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add Payment Schedule</a></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
		<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/payroll');?>">Payment Schedule Management</a></li>
		<li class="active">Payroll Schedules </li>
		</ol>	

	
		
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
			<?php 
			if (!empty($order)) 
			{ 
			?>
			<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<tbody>
					<tr class="gradeA even" role="row">
						<td>
							<?php
								$attributes = array('class' => 'form-inline', 'id' => 'frm_billing', 'role' => 'form', 'data-toggle' => 'validator');
								echo form_open_multipart(base_url('app/payroll/show_payable_schedules/'.$id), $attributes);
							?>
							<table class="table" width="100%">

							<tr>
								<td colspan="5" id="sub-order-<?php echo $order[0]->id;?>">
									<table class="table sub-order" width="100%">
										<tr>
											<th>Session</th>
											<th>PO</th>
											<th>Work Plan No</th>
											<th>Presenter</th>
											<th>Email</th>
											<th>Phone No.</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php $submit_btn = false; ?>

										<?php if (count($order) == 0) { ?>
											<tr>
												<td colspan="100%">Sorry!! No Records found.</td>
											</tr>
										<?php } else{
											foreach ($order as $row) 
											{
												// echo "<pre>";print_r($order);exit;
										?>
												<tr>
													<td class="sorting_1"><?php echo date_display($row->start_date, "m/d/Y");?> @ <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?> with <?php echo $row->teacher;?> 
                                                    <?php
                                                        if($row->late_flag == 1){
                                                    ?>
                                                        <div class="latetagbillAdminPayroll">Late</div>
                                                    <?php
                                                        }
                                                    ?>
													</td>
													<td><?php echo $row->order_no;?></td>
													<td><?php echo ($row->work_plan_number != '') ? $row->work_plan_number : 'N/A';?></td>
													<td><?php echo $row->presenter_data->first_name;?></td>
                                                    <td><?php echo $row->presenter_data->email;?></td>
                                                    <td><?php echo $row->presenter_data->meta_value;?></td>
													<td><?php echo $row->status;?></td>
													<td>
														<!-- <button type="button" class="btn btn-primary" title="Download Logs" onclick="window.open('<?php //echo base_url('app/payroll/download_log/'.$row->id)?>', '_blank')"><span class="glyphicon glyphicon-download"></span> Logs</button>
														<button type="button" class="btn btn-info" title="Download Invoice" onclick="window.open('<?php //echo base_url($row->invoice) ?>', '_blank')"><span class="glyphicon glyphicon-download"></span> Invoice</button> -->
														<a href="javascript:void(0)"  class="show_logs btn"  data-id="<?php echo $row->id ?>">Expand</a>
													</td>
												</tr>

			<?php foreach ($row->order_log as $k1 => $order_log) { ?>				
				<tr style="display: none;"  class="show_log_<?php echo $row->id ?>">
					<?php if($order_log->new_status != 'Create invoice'){ ?>
					<td colspan="3"><?php echo date_display($row->start_date, "m/d/Y");?> @ <?php echo time_display($row->start_date, true);?> to <?php echo time_display($row->end_date, true);?> with <?php echo $row->teacher.',<br/> Grade - '.$row->grade_name.', Topic - '.$row->topic_name;?>
						
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
						}elseif($order_log->new_status == 'Payment sent'){
							echo "Payment sent";
						}
						?>
					</td>
					<td>
						<?php
						if($order_log->new_status != 'Confirm hours'){
							if($order_log->attachment && $order_log->attachment != NULL){
								if($order_log->new_status == 'Invoice created'){
									echo ' <a href="'.base_url($order_log->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
								}else{
									echo ' <div id="file_attach_'. $order_log->id.'"><a href="'.base_url(DIR_TEACHER_FILES.$order_log->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
								}
							}if($order_log->content){
								echo ' <a href="'.base_url('app/orders/display_log/'.$order_log->order_schedule_id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
							}
						}else{
							echo "--";
						}
						?>
					</td>
					<?php } ?>

				</tr>
			<?php } ?>
										<?php 
											}}
										?>
									</table>
									
									<?php if (count($order) > 0 ) { ?>
										<button type="button" class="btn btn-primary" onclick="window.location.href = '<?php echo base_url('app/payroll/download_csv/'.$this->uri->segment(4)) ?>'"><span class="glyphicon glyphicon-download"></span> Export to CSV</button>
									<?php } ?>
								</td>
							</tr>
							
							</table>
							<?php echo form_close();?>
						</td>
					</tr>
				</tbody>
			</table>
				<?php }else{ ?>
				<tr>
					<td colspan="100%">Sorry!! No Records Available.</td>
				</tr>

			<?php   }
				?>
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
	<!-- </div> -->
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

<?php if($this->session->userdata('role') == 'teacher') {?>
<script>
	jQuery(document).ready(function() {
		jQuery('#invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
	});
			
	jQuery("#invoiceBtnSaveSign").click(function(e){
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
						jQuery("#invoiceContent").val(response.file_name);
						document.getElementById('frm_billing').submit()
					}
				});
			}
		});
	});
</script> 
<?php }?>

<script type="text/javascript">
	
	jQuery(document).ready(function() {

		// For table row show and hide
		jQuery('.show_logs').click(function(){

			var id = jQuery(this).data('id');
			//alert(id);
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